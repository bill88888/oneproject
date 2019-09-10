<?php
namespace Admin\Controller;

use Think\Controller;

class CommonController extends Controller
{
       public function __construct()
       {
       		parent::__construct();
       		if(empty($_SESSION['adminflag'])){
       			
       			$this ->error('请先登录!','/index.php?m=admin&c=login&a=login');
       		}
       }
}