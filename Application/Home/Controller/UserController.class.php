<?php
namespace Home\Controller;

use Think\Controller;

class UserController extends Controller
{

    //统计数成员方法
    function mkCount()
    {
        //统计数
        $count = M('post') ->count();
        return $this ->assign('count',$count);

    }

	//注册
    public function create()
    {
        //统计数
        $this ->mkCount();

    	$this ->display();
    }

    //
    public function save()
    {
    	//检查接收
    	// var_dump($_POST);

    	//建空数组
    	$data = [];
    	$data['uname'] = $_POST['uname'];
    	$data['upwd'] = $_POST['upwd'];
    	$data['tel'] = $_POST['tel'];
    	$data['auth'] = 3;
    	$data['create_at'] = time();
        
        //加密密码
        $data['upwd'] = password_hash($data['upwd'],PASSWORD_DEFAULT);

        // var_dump($_FILES);die;
        $data['uface'] = $this ->Up();
        // var_dump($data);

        $this ->smPic($data['uface']);

    	//判断
    	

    	if( empty($_POST['uname']) ){
    		$this ->error('账号不能为空!');
    	}

    	if( empty($_POST['upwd']) ){
    		$this ->error('密码不能为空!');
    	}

    	if($_POST['upwd'] !== $_POST['reupwd']){
    		$this ->error('确认密码错误!');
    	}

        //实例化
        $user = M('user');

   		$row = $user ->add($data);


        $this ->success('注册成功!','http://mybbs.com');

    }

    //查看和修改
    public function edit()
    {
        //统计数
        $this ->mkCount();

        $this ->display();
    }

    public function update()
    {

        $uid = $_GET['uid'];
        //新建空数组
        $data = [];

        $data = $_POST;

        // var_dump($_FILES);die;
        //处理文件上传
        if($_FILES['uface']['error'] !== 4){
            $data['uface'] = $this ->Up();

            //生成缩略图
            $this -> smPic($data['uface']);

            // var_dump($data);die;
        }
        

        $user = M('user') ->where("uid=$uid") ->save($data);  

        if(!$user){
            $this ->error('修改失败!','/index.php?m=home&c=user&a=edit');
        }else{

            $this ->success('修改成功!','/');
        }

        
    }

   
    //文件上传
    public function Up()
    {

            // echo '<pre>';
            // print_r($_FILES);die;
            $config = array(
                'maxSize'  => 3145728,
                'rootPath' => './Public/Uploads/',
                'savePath' => '',
                'saveName' => array('uniqid',''),
                'exts'     => array('jpg', 'gif', 'png', 'jpeg'),
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
        
        $this ->mkCount();
        $this ->display();
    }

    public function updatemi()
    {

        $uid = $_GET['uid'];
        // echo $uid;
        // var_dump($_POST);
        //先验证旧密码
        $oop = M('user'); 
        $user = $oop ->find($uid);
        // var_dump($user);

        if( empty($_POST['upwd']) ){
            $this ->error('旧密码不能为空!');
        }

        // var_dump($_POST['upwd']);
        if( !password_verify($_POST['upwd'],$user['upwd']) ){
            $this ->error('确认旧密码失败!');
        }


        //修改密码
        $data = [];
        $data = $_POST;

        //替换密码
        $data['upwd'] = $_POST['nupwd'];

        //*加密
        $data['upwd'] = password_hash($data['upwd'],PASSWORD_DEFAULT);

        try{
            $oop ->where("uid=$uid") ->save($data); 
        }catch(\Exception $a){
            $msg = $a ->getMssage;
            $this ->error($msg);
        }

        // var_dump($data);
        $this ->success('修改成功!','/');
    }

}