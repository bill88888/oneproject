<?php
namespace Home\Controller;

use Think\Controller;

class LoginController extends Controller
{
	//登录
    public function dologin()
    {

    	$uname = $_POST['uname'];
    	$upwd = $_POST['upwd'];
    	
    	//实例化
    	$user = M('user') ->where("uname = '$uname'") ->find();

    	$verify = new \Think\Verify();

    	//判断
    	if( $user && password_verify($upwd,$user['upwd']) ){
    		
    		$_SESSION['homeflag'] = true;
    		$_SESSION['homeuser'] = $user;

    		$this ->success('登录成功!','index.php?m=home&c=index&a=index');
    	}else{
    		$this ->error('账号或密码错误!','index.php?m=home&c=index&a=index');
    	}
    }

    //退出
    public function logout()
    {
    	$_SESSION['homeflag'] = false;
    	$_SESSION['homeuser'] = NULL;

    	$this ->success('退出成功!','/');
    }


}