<?php
namespace Admin\Controller;

use Think\Controller;

class PostController extends CommonController
{
	 //显示帖子信息
    public function index()
    {
   		
   		$oop = M('post');
    	
    	//关键字搜索	
 		  $arr = [];
   		// var_dump($_POST);
   		$title = $_POST['title'];
   		$uname = $_POST['uname'];	
   		$cname = $_POST['cname'];
   		// var_dump($cname);
   		//按标题关键字搜索
   		if( !empty($title) ){
   			$arr['title'] = array('like','%'.$title.'%');
   		}

   		//按发帖者搜索
    	if( !empty($uname) ){

    		$user = M('user') ->where("uname='$uname'") ->find(); 
   			// var_dump($user);

   			$arr['uid'] = $user['uid'];
    	}
    	
      //按所属模块搜索
    	if( !empty($cname) ){
           
    		
        $cate = M('cate') ->where("cname='$cname'") ->find();
    		// var_dump($cate);

    		$arr['cid'] = $cate['cid'];
    	}
        
        
        //按所属分区搜索
        $parts = M('part') ->select();

        $pname = $_POST['pname'];
        // var_dump($pname);

        if( !empty($pname) ){
          
           //通过接收过来的分区名字 在分区表找到与之对应的分区信息
           $part = M('part') ->where("pname='$pname'") ->find(); 
           // var_dump($part);
           //通过分区编号 在模版表找到与之对应的模版信息
           $pid = $part['pid'];
           $cate1 = M('cate') ->where("pid='$pid'") ->find();
           // var_dump($cate1);
           //通过模版编号 在帖子表找到与之对应的帖子信息 
           $arr['cid'] = $cate1['cid'];
           // var_dump($arr);
        }
        





    	//分页
		  //算出总记录数
		  $count = $oop ->where($arr) ->count();

		  //实例化分页类 传入总记录数和每页显示的记录数(2)
		  $page = new \Think\Page($count,4);

		  //分页显示输出 第n页超链接
		  $show = $page ->show();

    	//实例化获取数据
    	$post = $oop ->where($arr) ->order('created_at desc') ->limit($page->firstRow.','.$page->listRows) ->select();		
      //连接数据库
      $cates = M('cate') ->select();

    	// var_dump($count);
    	// var_dump($show);
    	//分配变量
        $this ->assign('parts',$parts);
    	$this ->assign('cates',$cates);
    	$this ->assign('post',$post);
    	$this ->assign('show',$show);
    	$this ->display();
    }

    //删除帖子
    public function del()
    {	
    	$pid = $_GET['pid'];

    	try{
	    	M('post') ->delete($pid);
		}catch(\Excerption $a){
			$msg = $a ->getMessage();
			$this ->error($msg);
		}

		$this ->success('删除帖子成功!');

    }

    //加精指定帖子
    public function jing($j=1)
    {

        // var_dump($_GET); 

    	//获取pid
    	$pid = $_GET['pid'];
    	
    	//加精
    	$data['is_jing'] = $j;

    	//重写入数据库
    	try{
    		M('post') ->where("pid=$pid") ->save($data);
    	}catch(\Exception $a){
    		$msg = $a ->getMessage();
    		$this ->error($msg);
    	}

    	header('location:/index.php?m=admin&c=post&a=index');
    	
    }
    //取消加精指定帖子
    public function nojing()
    {
    	//引用加精方法 将形参改为 实参0
    	$this ->jing(0);
    }

    //置顶指定帖子
    public function ding($d=1)
    {
    	$pid = $_GET['pid'];

    	//置顶
    	$data['is_ding'] = $d;

    	//重写入数据库
    	try{
    		M('post') ->where("pid=$pid") ->save($data);
    	}catch(\Exception $a){
    		$msg = $a ->getMessage();
    		$this ->error($msg);
    	}
    	header('location:/index.php?m=admin&c=post&a=index');
    }
    //取消置顶指定帖子
    public function noding()
    {
    	$this ->ding(0);
    }

    //隐藏
    public function yin($h=1)
    {
      //接收pid
      $pid = $_GET['pid'];

      $data['hidden'] = $h;
      var_dump($data);

      try{
        $post = M('post') ->where("pid=$pid") ->save($data);
      }catch(\Exception $a){
        $msg = $a ->getMessage();
        echo $msg;
      }
      header('location:/index.php?m=admin&c=post&a=index');
    }

    //取消隐藏
    public function noYin()
    {
      $this ->yin(0);
    }

    public function sReply()
    {

      $pid = $_GET['pid'];
      // var_dump($pid);
      //连接回复表
    
      $reply = M('reply') ->where("pid=$pid") ->find();
      if( !empty($reply) ){
        $replys[] =$reply; 
      }
      // var_dump($replys);

      if( !empty($replys) ){
      // var_dump($replys);
      //查出 reply表里的所有uid
      $uarr = array_column($replys,'uid');
      // var_dump($uarr);

      //去重复
      $uarr = array_unique($uarr);
      // var_dump($uarr);

      //新建空数组
      $arr = [];

      $arr['uid'] = array('in',$uarr); 
      
      // echo '<pre>';
      // print_r($arr);
      // echo '</pre>';
      
      //查出reply表 所有pid(帖子编号)
      $parr = array_column($replys,'pid');
      // var_dump($parr);
      
      //去重
      $parr = array_unique($parr);
      // var_dump($parr);
      // //新建数组
      $arr1 = [];
      
      // //把条件赋给新数组
      $arr1['pid'] = array('in',$parr);  
      // var_dump($arr1);
    }

      


      $users = M('user') ->where($arr) ->getField('uid,uname');
      // var_dump($users);
      $posts = M('post') ->where($arr1) ->getField('pid,title');
      // var_dump($posts);

      //分配变量
      $this ->assign('posts',$posts);
      $this ->assign('users',$users);
      $this ->assign('replys',$replys);
      $this ->display();

    } 
}