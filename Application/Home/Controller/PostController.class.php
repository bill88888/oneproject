<?php
namespace Home\Controller;

use Think\Controller;

class PostController extends Controller
{
	//统计数成员方法
    function mkCount()
    {	
    	//接收cid 确定是哪个模块下的帖子
    	$cid = $_GET['cid'];
        //统计数
        $count = M('post') ->where("cid=$cid") ->count();
        return $this ->assign('count',$count);

    }

	//发布帖子
	public function create()
	{
		//统计帖子数
		$this ->mkCount();

		//判断
		if( empty($_SESSION['homeuser']) ){
			$this ->error('请登录账号!');
		}
		
		//接收 cid
		$cid = $_GET['cid'];
		

		$this ->assign('cid',$cid);
		$this ->display();
	}

	//接收帖子 存入数据库
	public function save()
	{

		// var_dump($_POST);
		// var_dump($_GET);

		//新建空数组
		$data = [];

		//将接收过来的数据 赋给空数组
		$data = $_POST;
		$data['is_jing'] = 0;
		$data['is_ding'] = 0;
		$data['uid'] = $_SESSION['homeuser']['uid'];
		$data['created_at'] = time(); 
		$data['updated_at'] = time(); 

		// var_dump($data);die;

		//判断
		if( empty($_POST['title']) ){
			$this ->error('标题不能为空!');
		}

		if( empty($_POST['content']) ){
			$this ->error('内容不能为空!');
		}


		try{
			M('post') ->add($data);
		}catch(\Exception $a){
			$msg = $a ->getMessage();
			$this ->error($msg);
			// echo $msg;die;
		}
		
		//得到cid 并赋给一个变量
		$cid = $data['cid'];


		$this ->success('发帖成功!',"/index.php?m=home&c=post&a=index&cid=$cid");

	}


	//查看指定模版上的所有帖子
	public function index()
	{
		//统计帖子数
		$this ->mkCount();

		
		$cid = $_GET['cid'];

		// var_dump($uid);

		//实例化 获取数据
		$posts = M('post') ->where("cid=$cid") ->order('is_ding desc,updated_at desc') ->select();

		// var_dump($posts);
		//遍历显示
		$this ->assign('cid',$cid);
		$this ->assign('posts',$posts);
		$this ->display();

	}
	

	//查看帖子详情
	public function show()
	{	
		$this -> mkCount();

		$pid = $_GET['pid'];

		//浏览数
		M('post') ->where("pid=$pid") ->setInc('v_cnt',1);

		//获取数据
		//帖子信息
		$post = M('post') ->where("pid=$pid") ->find();
		
		$uid = $post['uid'];
		//帖子作者信息
		$user = M('user') ->where("uid=$uid") ->find();

		// var_dump($post);
		
		//回复者信息
		$reply = M('reply') ->where("pid=$pid") ->select();

		// var_dump($reply);

		$this ->assign('reply',$reply);
		$this ->assign('post',$post);
		$this ->assign('user',$user);
		$this ->display();
	}

	//接收回复 存入数据库
	public function reply()
	{

		$pid = $_POST['pid'];
		$cid = $_POST['cid'];

		// var_dump($pid);
		//回复数
		$set =M('post') ->where("pid=$pid") ->setInc('r_cnt',1);


		// var_dump($set);

		//新建空数组
		$data = [];

		$data = $_POST;
		$data['updated_at'] = time();
		$data['created_at'] = time();

		//判断
		if( empty($data['uid']) ){
			$this ->error('请登录账号!');
		}

		try{
			$reple = M('reply') ->add($data);			
		}catch(\Exception $a){
			$msg = $a ->getMessage();
			$this ->error($msg);
			// echo $msg;die;
		}

		$this ->success('回复成功!',"/index.php?m=home&c=post&a=show&pid={$pid}&cid={$cid}");


	}

	//发布帖子
	public function sCreate()
	{
		//统计帖子数
        $count = M('post') ->count();

        $cates = M('cate') ->select();



		//判断
		if( empty($_SESSION['homeuser']) ){
			$this ->error('请登录账号!');
		}
		
		//分配变量
		$this ->assign('count',$count);
		$this ->assign('cates',$cates);

		$this ->display();
	}

	//接收帖子 存入数据库
	public function pSave()
	{
		var_dump($_POST);
		//获取cname
		$cname = $_POST['cname'];

		//通过收到的cname条件找出这条模块信息
		$cate = M('cate') ->where("cname='$cname'") ->find();
		var_dump($cate);
		$data = $_POST;
		//得到cid
		$data['cid'] = $cate['cid'];
		$data['uid'] = $_SESSION['homeuser']['uid'];
		$data['created_at'] = time();
		$data['updated_at'] = time();
		try{
			M('post') ->add($data);
		}catch(\Exception $a){
			$msg = $a ->getMessage();
			echo $msg;
		}

		// var_dump($data);
		$this ->success('发帖成功!','/index.php?m=home&c=post&a=sCreate');

	}
}