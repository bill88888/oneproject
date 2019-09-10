<?php
namespace Admin\Controller;

use Think\Controller;

class UserController extends CommonController
{
	//添加
	public function create()
	{
		$this ->display();

	}

	public function save()
	{	


		// echo '<pre>';

		// print_r($_POST);
		// echo '</pre>';

		$data['auth'] = $_POST['auth'];
		$data['uname'] = $_POST['uname'];
		$data['upwd'] = $_POST['upwd'];
		$data['sex'] = $_POST['sex'];
		$data['age'] = $_POST['age'];
		$data['tel'] = $_POST['tel'];
		$data['create_at'] = time();
		$data['update_at'] = time();

		$data['upwd'] = password_hash($data['upwd'],PASSWORD_DEFAULT);
		//处理上传的文件返回新的文件名 存入数据表
		$data['uface'] = $this ->doUp();

		$this ->smPic($data['uface']);

		


		//获取数据
		$oop = M('user'); //相当于 new UserModel
		
		//插入数据库
		$row = $oop ->add($data);
		// var_dump($row);	

		//判断
		if(empty($_POST['upwd']) || empty($_POST['reupwd'])){
			$this ->error('密码不能为空!');
		}



		if($_POST['upwd'] !== $_POST['reupwd']){
			$this ->error('重复密码错误!');
		}


		if(empty($_POST['uname'])){

			$this ->error('账号不能为空!');
		}

			$this ->success('添加成功!');

	}

	//查看
	public function index()
	{
		//获取数据
		$oop = M('user'); //bb_user表

		//空条件数组
		$arr = [];


		//搜索
		//判断如果不是空的就把接收到的sex赋值给新建的空数组
			
		//按性别搜索	
		if(!empty($_GET['sex'])){
			$arr['sex'] = $_GET['sex']; //相当于 sex=w/m/x
		}

		//按名字搜索
		if(!empty($_GET['uname'])){
			$arr['uname'] = array('like', '%'.$_GET['uname'].'%'); //相当于 uname like %xxx% 模糊搜素
		}


		//分页
		//根据已有搜索条件,算出满足条件的总记录数
		$count = $oop ->where($arr) ->count();
		// var_dump($count);
		//实例化分页类 传入总记录数和每页显示的记录数(2)
		$page = new \Think\Page($count,2);

		//分页显示输出 第n页超链接
		$show = $page ->show();

		//检查是否能拿到$show
		// echo '<pre>';
		// print_r($show);die;
		// echo '</pre>';
			
		//把刚才接到的搜索条件加入显示条件里
		//把分页limit 也加入显示条件
		$users =$oop ->where($arr) 
					 ->limit($page->firstRow.','.$page->listRows) 
					 ->select();


		// echo '<pre>';
		// var_dump($users);
		
		//遍历显示到html
		$this ->assign('users',$users); //分配变量
		
		$this ->assign('show',$show);	//分配变量

		$this ->display(); //View/Ueres/index.html

	}

	//删除
	public function del()
	{

		$oop = M('user');

		if($oop ->delete($_GET['uid'])){
			$this ->success('删除成功');
		}
	}

	//修改
	public function edit()
	{
		
		$oop = M('user');

		$user = $oop ->find($_GET['uid']);
		

		// echo "<pre>";
		// var_dump($user);
		// echo '</pre>';
		//显示
		
		$this ->assign('user',$user);

		$this ->display();

	}

	public function update()
	{
		$uid = $_GET['uid'];


		// echo '<pre>';
		// var_dump($uid);
		// echo '</pre>';
		
		
		$oop = M('user');

		// var_dump($_FILES);die; 
		
		//修改头像
		$data = $_POST;
		// var_dump($data);die;
		$data['update_at'] = time(); 

		if($_FILES['uface']['error'] != 4){
		
			//处理 上传的文件
			$data['uface'] = $this ->doUp();

			//生成缩略图
			$this ->smPic($data['uface']);
		}
		// var_dump($data);die;

		try{
			$oop ->where("uid = $uid") ->save($data); //把修改好所有信息 重新写入
		}catch(Exception $a){
			$this ->error('修改失败!');
		}
			$this ->success('修改成功!','/index.php?m=admin&c=user&a=index');
	}

	//文件上传
	public function doUp()
	{
		//检查能不能拿到上传的文件

		// echo '<pre>';
		// print_r($_FILES['uface']);
		$config = array(
			'maxSize'  => 3145728,
			'rootPath' => './Public/Uploads/',
			'savePath' => '',
			'saveName' => array('uniqid',''),
			'exts' 	   => array('jpg', 'gif', 'png', 'jpeg'),
			'autoSub'  => true,
			'subName'  => array('date','Ymd'),
		);
		$upload = new \Think\Upload($config);// 实例化上传类
		
		$info = $upload -> upload();

		//如果上传失败 报出错误原因
		if(!$info){
			echo $upload ->getError();
		}


		// print_r($info); 打印检查 array(['uface']=>array(['name']=>....))

		//拼接上传文件的完整名
		return $info['uface']['savepath'].$info['uface']['savename'];
	}

	//生成缩略图
	public function smPic($img)
	{
		//图像压缩
		
		$filename = './Public/Uploads/'.$img;

		//打开文件返回对象
		$pic = new \Think\Image(\Think\Image::IMAGE_GD,$filename); // GD库

		
		//生成一个固定大小为150*150的缩略图并保存为 缩略图文件名
		$thumb_name = './Public/Uploads/'.getSm($img);

		$pic ->thumb(150, 150) ->save($thumb_name);
	}


	//修改密码
	public function editmi()
	{
		//实例化
		// $user = M('user') ->select();

		// //分配变量
		// $this ->assign('user',$user);

		$this ->display();
	}

	public function updatemi()
	{
		//验证用户

		//检测
		// var_dump($_POST);

		$uname = $_POST['uname'];
		$upwd = $_POST['upwd'];

		if( empty($upwd) ){
			$this ->error('旧密码不能为空!');
		}

		$oop = M('user');
		$user = $oop ->where("uname='$uname'") ->find();

		// $verify = new \Think\Verify();

		if( !password_verify($upwd,$user['upwd']) ){
			$this ->error('旧密码输入错误!');
		}


		//修改密码
		
		//判断
		if( empty($_POST['nupwd']) ){
			$this ->error('新密码不能为空!');
		}

		if( $_POST['upwd']==$_POST['nupwd'] ){
			$this ->error('新密码不能与旧密码相同!');
		}
		
		
		//新建空数组
		$data = [];
		$uid = $_GET['uid'];
		
		//将接收到的数据信息赋给这个数组
		$data = $_POST;

		//将新密码赋给密码 此时upwd 已经更改成为新密码
		$data['upwd'] = $_POST['nupwd'];

		//加密新密码
		$data['upwd'] = password_hash($data['upwd'],PASSWORD_DEFAULT);

		// var_dump($data);

		try{
			$oop ->where("uid = $uid") ->save($data);
		}catch(\Exception $a){
			$msg = $a->getMessage();
			$this ->error($msg);
		}

		$this ->success('修改成功!','index.php?m=admin&c=login&a=login');
			
	}
}