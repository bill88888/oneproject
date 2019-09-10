<?php
namespace Admin\Controller;

use Think\Controller;

class PartController extends CommonController
{
	//添加
    public function create()
    {	
    	//获取所有用户信息
    	$users = M('user') ->where('auth<2') ->select(); //select * from bbs_user where('auth<2')
 
    	//分配变量
    	$this ->assign('users',$users);
    	$this ->display();
    }

	public function save()
	{
		//存入数据库
		
		$data = $_POST;
	
		$data['created_at'] = time();
		$data['updated_at'] = time();

		//检查是否能接收到html
		// echo '<pre>';
		// 	print_r($data);
		// echo '</pre>';
		
		//获取数据
		$oop = M('part');

		//存入数据库
		$row = $oop ->add($data);
		
		if(!$row){
			$this ->error('添加失败!');
		}

		$this ->success('添加成功!','/index.php?m=admin&c=part&a=index');
	}    

    //查看
	public function index()
	{
		//获取数据
		$part = M('part'); 

		//搜索
		$arr = [];
		if(!empty($_GET['pname'])){
			$arr['pname'] = array('like','%'.$_GET['pname'].'%');
 		}
 		
 		// var_dump($arr);die;
		// $part ->where($arr) ->select();

		$parts = $part ->where($arr) ->select();
		
		$uid_arr = array_column($parts,'uid');	//返回数组中指定的一列
		
		$uid_arr = array_unique($uid_arr);		//移除数组中重复的值 

		//判断
		$condition = [];

		if(!empty($parts)){
			$condition['uid'] = ['in',$uid_arr];    
		}



		$users = M('user') ->where($condition) ->getField('uid,uname');



		//检查
		// echo '<pre>';
		// 	print_r($uid_arr);
		// echo '</pre>';
		//遍历显示 分配变量
		$this ->assign('parts',$parts);
		$this ->assign('users',$users); 
		$this ->display();      // View/Part/index.html

	}
    
    //删除
    public function del()
    {
    	//接收数据
    	$oop = $_GET['pid'];
    	$row = M('part') ->delete($oop);

    	$this ->success('删除成功!');

    }
    
    //修改
    public function edit()
    {
    	//实例化
 		$pid = M('part');   
 		$uid = M('user');

 		$parts = $pid ->find($_GET['pid']);
		$users = $uid ->where("auth<2") ->select();	

 		//分配变量
 		$this ->assign('parts',$parts);
 		$this ->assign('users',$users);

    	$this ->display();   // View/Part/edit
    }

    public function update()
    {
    	//检查
    	// echo '<pre>';
    	// print_r($_POST);
    	// echo '</pre>';

    	//接收数据
    	
    	$pid = $_GET['pid'];

    	$data = $_POST;
    	$data['updated_at'] = time(); 

    	$row = M('part') ->where("pid=$pid") ->save($data);
    	if($row){
    		$this ->success('修改成功!','/index.php?m=admin&c=part&a=index');
    	}
    }
}
