<?php
namespace Admin\Controller;

use Think\Controller;

class CateController extends CommonController
{
	//添加
	public function create()
	{
		//实例化 查出信息
		$parts = M('part') ->select();
	
		
		//分配变量
		$this ->assign('parts',$parts);
		
		$this ->display();
	}

	public function save()
	{
		

		//生成一个空数组
		$data = [];
		$data = $_POST;
		$data['created_at'] = time();

		//检查
		// echo '<pre>';
		// print_r($data);
		// echo '</pre>';die;
		
		//实例化
		$cates = M('cate');
		
		//插入数据表
		try{
			$row = $cates ->add($data);
		}catch(\Exception $a){
			$msg = $a ->getMessage();
			$this ->error($msg);
		}

		$this ->success('添加成功!','/index.php?m=admin&c=cate&a=index');
	}
	
	//查看
	public function index()
	{	


		//新建空数组
		$arr = [];

		//搜索
		if(!empty($_GET['cname'])){
			$arr['cname'] = array('like','%'.$_GET['cname'].'%');
		}


		//分页
		$count = M('cate') ->where($arr) ->count();

		$page = new \Think\Page($count,3);

		//分页显示输出 第n页超链接
		$show = $page ->show();


		$cates = M('cate') ->where($arr) ->limit($page->firstRow.','.$page->listRows) ->select();
		
		


		// echo '<pre>';
		// print_r($cates);
		// echo '</pre>';
		$this ->assign('show',$show);
		$this ->assign('cates',$cates);
		$this ->display();
	}
	
	//删除
	public function del()
	{
		$cid = $_GET['cid'];
			
		// echo '<pre>';
		// 	print_r($cid);
		// echo '</pre>';

		 try{
		 	M('cate') ->delete($cid);
		}catch(\Exception $a){
			$msg = $a ->getMessage;
			$this ->error($msg);
		}
		$this ->success('删除成功!');
	}

	//修改
	public function edit()
	{
		//接收
		$cid = $_GET['cid'];
		
		//实例化
		$cates = M('cate') ->find($cid);
		$parts = M('part') ->select();


		$this ->assign('cates',$cates);
		$this ->assign('parts',$parts);
		$this ->display();
	}
	public function update()
	{
		$cid = $_GET['cid'];
		$cate = M('cate');
		
		$data = [];
		$data = $_POST;
		$data['updated_at'] = time();

		try{
			$row = $cate ->where("cid=$cid") ->save($data);
		}catch(\Exception $a){
			$msg = $a ->getMessage();
			$this ->error($msg);
		}
		$this ->success('修改成功!','/index.php?m=admin&c=cate&a=index');
	}
}