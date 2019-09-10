<?php
namespace Admin\Controller;

use Think\Controller;

class IndexController extends Controller
{
    public function index()
    {
        // 执行 
        // /index.php?m=admin&c=index&a=index;
    	
    	// echo 'my';
    	$this ->display();
    }
}