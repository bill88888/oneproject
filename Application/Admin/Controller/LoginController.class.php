<?php
namespace Admin\Controller;

use Think\Controller;

class LoginController extends Controller
{
	//登录
	public function login()
	{
		$this ->display();
	}

	//接收登录信息 验证
	public function dologin()
	{
		//检测接收
		// echo '<pre>';
		// 	print_r($_POST);
		// echo '</pre>';

		$code = $_POST['code'];	  // 判断验证码
		$uname = $_POST['uname']; //表示成功		
		$upwd = $_POST['upwd'];	  //用户信息组

		$verify = new \Think\Verify();

		if( !$verify->check($code) ){
			$this ->error('验证码错误!');
		}


		//实例化	
		$user = M('user') ->where("uname='$uname'") ->find();
		// var_dump($user);

		// $verify = new \Think\Verify();

		//判断
		if( $user && password_verify($upwd,$user['upwd']) ){
			if( $user['auth']>=3 ){
				$this ->error('您不是管理员!');
			}

			$_SESSION['adminflag'] = true;
			$_SESSION['adminuser'] = $user;
			
			$this ->success('登录成功!','/index.php?m=admin&c=index&a=index');
		
		}else{
			$this ->error('账号或者密码不正确!','/index.php?m=admin&c=login&a=login');
		}

	}

	//退出登录
	public function logout()
	{

		$_SESSION['adminflag'] = false;
		$_SESSION['adminuser'] = NULL;

		$this ->success('退出成功!');
	}

	//验证码
	public function code()
	{
		ob_clean();
		$config = array(
			'fontSize' => 20, 		// 验证码字体大小
			'length' => 3, 			// 验证码位数
			'useNoise' => false,	// 关闭验证码杂点
			'useCurve' => true,
			'imageW' => 130,
			'imageH' => 40,
		);

		$Verify = new \Think\Verify( $config );
		$Verify->entry();
	}
}