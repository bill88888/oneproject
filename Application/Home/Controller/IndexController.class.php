<?php
namespace Home\Controller;

use Think\Controller;

class IndexController extends Controller
{
    public function index()
    {   
        //帖子搜索
        // var_dump($_GET['title']);

        $title = $_POST['title'];
        //按帖子标题条件找到指定帖子
        if( !empty($title) ){

            // $post = M('post') ->where("title='$title'") ->select();
            $condition['title'] = array('like','%'.$title.'%');
            // var_dump($condition);
            
            //模糊搜索
            $posts = M('post') ->where($condition) ->select();
            // var_dump($posts);

            
        }

       

        //统计数
        $count = M('post') ->count();

        //重组成新的数组且下标为pid
    	$part = M('part') ->getField('pid, pname, uid, created_at, updated_at');
    	// var_dump($part);

    	$cate = M('cate') ->select();
    	// var_dump($cate);
        
    	foreach($cate as $k=>$v){
    		$part[ $v['pid'] ]['cate'][] = $v;
    	}
    	//看效果
    	// echo '<pre>';
    	// print_r($part);
    	// echo '</pre>';
    	

    	//分配变量
        $this ->assign('posts',$posts);     //帖子
        $this ->assign('part',$part);       //分区
        $this ->assign('count',$count);     //总数
    	$this ->assign('user',$user);       //用户

    	$this ->display();
    }

    //查看所有帖子
    public function indexPost()
    {

        //统计帖子数
        $count = M('post') ->count();

        // var_dump($uid);

        //实例化 获取数据
        $posts = M('post') ->order('updated_at desc') ->select();

        // var_dump($posts);
        //遍历显示
        $this ->assign('count',$count);
        $this ->assign('posts',$posts);
        $this ->display();

    }

}