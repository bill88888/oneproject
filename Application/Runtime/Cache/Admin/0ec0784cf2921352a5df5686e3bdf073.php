<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>后台管理</title>
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/common.css"/>
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/main.css"/>
    <script type="text/javascript" src="/Public/Admin/js/libs/modernizr.min.js"></script>
</head>
<body>
<div class="topbar-wrap white">
    <div class="topbar-inner clearfix">
        <div class="topbar-logo-wrap clearfix">
            <h1 class="topbar-logo none"><a href="index.html" class="navbar-brand">后台管理</a></h1>
            <ul class="navbar-list clearfix">
                <li><a class="on" href="/index.php?m=admin&c=index&a=index">首页</a></li>
                <li><a href="http://mybbs.com" targiet="_blank">网站首页</a></li>
            </ul>
        </div>
        <div class="top-info-wrap">
            <ul class="top-info-list clearfix">
                <li><a href="/index.php?m=admin&c=user&a=create"><?php echo ($_SESSION['adminuser']['uname']); ?></a></li>
                <li><a href="/index.php?m=admin&c=user&a=editmi">修改密码</a></li>
                <li><a href="/index.php?m=admin&c=login&a=logout">退出</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="container clearfix">
    <div class="sidebar-wrap">
        <div class="sidebar-title">
            <h1>菜单</h1>
        </div>
        <div class="sidebar-content">
            <ul class="sidebar-list">
                <!-- <li>
                    <a href="#"><i class="icon-font">&#xe018;</i>登录管理</a>
                    <ul class="sub-menu">
                        <li><a href="/index.php?m=admin&c=login&a=login"><i class="icon-font">&#xe017;</i>登录</a></li>
                    </ul>
                </li> -->
                
                <li>
                    <a href="#"><i class="icon-font">&#xe003;</i>用户管理</a>
                    <ul class="sub-menu">
                        <li><a href="/index.php?m=admin&c=user&a=create"><i class="icon-font">&#xe008;</i>添加用户</a></li>
                        <li><a href="/index.php?m=admin&c=user&a=index"><i class="icon-font">&#xe005;</i>查看用户</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="icon-font">&#xe018;</i>分区管理</a>
                    <ul class="sub-menu">
                        <li><a href="/index.php?m=admin&c=part&a=create"><i class="icon-font">&#xe008;</i>添加分区</a></li>
                        <li><a href="/index.php?m=admin&c=part&a=index"><i class="icon-font">&#xe005;</i>查看分区</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="icon-font">&#xe018;</i>模块管理</a>
                    <ul class="sub-menu">
                        <li><a href="/index.php?m=admin&c=cate&a=create"><i class="icon-font">&#xe008;</i>添加模块</a></li>
                        <li><a href="/index.php?m=admin&c=cate&a=index"><i class="icon-font">&#xe005;</i>查看模块</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="icon-font">&#xe018;</i>帖子管理</a>
                    <ul class="sub-menu">
                        <li><a href="/index.php?m=admin&c=post&a=index"><i class="icon-font">&#xe008;</i>查看帖子</a></li>
                    </ul>
                </li>
                
            </ul>
        </div>
    </div>
    <!--/sidebar-->

<!--/sidebar-->
    <div class="main-wrap">

        <div class="crumb-wrap">
            <div class="crumb-list"><i class="icon-font"></i><a href="index.html">首页</a><span class="crumb-step">&gt;</span><span class="crumb-name">作品管理</span></div>
        </div>
        <div class="search-wrap">
            <div class="search-content">
                <form action="/index.php?m=admin&c=post&a=index" method="post">
                    <table class="search-tab">
                        <tr>
                            <th width="120">分区:</th>
                            <td>
                                <select name="pname" id="">
                                    <option value="">全部</option>
                                    
                                    <?php foreach( $parts as $part ): ?>
                                    <option value="<?php echo ($part['pname']); ?>"><?php echo ($part['pname']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <th width="120">所属模块:</th>
                            <td>
                                <select name="cname" id="">
                                	<option value="">全部</option>
                                	<?php foreach( $cates as $cate ): ?>
                                    <option value="<?php echo ($cate['cname']); ?>"><?php echo ($cate['cname']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <th width="70">标题:</th>
                            <td><input class="common-text" placeholder="关键字" name="title" value="" id="" type="text"></td>
                            <th width="70">发帖者:</th>
                            <td><input class="common-text" placeholder="" name="uname" value="" id="" type="text"></td>
                            <td><input class="btn btn-primary btn2" name="sub" value="查询" type="submit"></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
        <div class="result-wrap">
            <form name="myform" id="myform" method="post">
                <div class="result-title">
                    <div class="result-list">
                        <a href="insert.html"><i class="icon-font"></i>新增作品</a>
                        <a id="batchDel" href="javascript:void(0)"><i class="icon-font"></i>批量删除</a>
                        <a id="updateOrd" href="javascript:void(0)"><i class="icon-font"></i>更新排序</a>
                    </div>
                </div>
                <div class="result-content">
                    <table class="result-tab" width="100%">
                        <tr>
                            <th>编号</th>
                            <th>标题</th>
                            <th>发帖者</th>
                            <th>所属模块</th>
                            <th>加精</th>
                            <th>置顶</th>
                            <th>创建时间</th>
                            <th>修改时间</th>
                            <th>浏览数</th>
                            <th>回复数</th>
                            <th>操作</th>
                        </tr>
						<?php foreach($post as $k=>$v): ?>
                        <tr>
                            <td><?php echo ($v['pid']); ?></td>
                            <td><?php echo ($v['title']); ?></td>
                            <td><?php
 $uid = $v['uid']; $user = M('user') ->where("uid=$uid") ->find(); if( empty($user) ){ echo ''; }else{ echo $user['uname']; } ?></td>
                            <td>
                                <?php
 $cid = $v['cid']; $cate = M('cate') ->where("cid=$cid") ->find(); if( empty($cate) ){ echo ''; }else{ echo $cate['cname']; } ?></td>
                            <td>
                              <?php
 if( $v[is_jing] ){ echo '是'; }else{ echo '否'; } ?>
                            </td>
                            <td>
                                <?php
 if( $v['is_ding'] ){ echo '是'; }else{ echo '否'; } ?>
                            </td>
                            <td><?php echo date('Y-m-d H:i:s',$v['created_at']) ;?></td>
                            <td><?php echo date('Y-m-d H:i:s',$v['updated_at']) ;?></td>
                            <td><?php echo ($v['v_cnt']); ?></td>
                            <td><?php echo ($v['r_cnt']); ?></td>
                            <td>

                            <!--加精-->
                            <?php if( !$v['is_jing'] ): ?>
                          		<a class="link-jing" href="/index.php?m=admin&c=post&a=jing&pid=<?php echo ($v['pid']); ?>">
                            	加精</a>
                            <?php else: ?>	
                            	<a class="link-jing" href="/index.php?m=admin&c=post&a=nojing&pid=<?php echo ($v['pid']); ?>">
                            	取消加精</a>
							<?php endif; ?>

							<!--置顶-->
							<?php if( !$v['is_ding'] ): ?>
                            	<a class="link-ding" href="/index.php?m=admin&c=post&a=ding&pid=<?php echo ($v['pid']); ?>">
                            	置顶</a>
                            <?php else: ?>		
                            	<a class="link-ding" href="/index.php?m=admin&c=post&a=noding&pid=<?php echo ($v['pid']); ?>">
                            	取消置顶</a>
							<?php endif; ?>

                            <!--隐藏-->
                            <?php if( !$v['hidden'] ): ?>
                                <a class="link-yin" href="/index.php?m=admin&c=post&a=yin&pid=<?php echo ($v['pid']); ?>">
                                取消隐藏</a>
                            <?php else: ?>      
                                <a class="link-yin" href="/index.php?m=admin&c=post&a=noYin&pid=<?php echo ($v['pid']); ?>">
                                隐藏</a>
                            <?php endif; ?>

                                <a class="link-update" href="/index.php?m=admin&c=post&a=sReply&pid=<?php echo ($v['pid']); ?>">查看回复</a>
                                
                                <a class="link-update" href="/index.php?m=admin&c=post&a=edit">修改</a>
               
                                <a class="link-del" href="/index.php?m=admin&c=post&a=del&pid=<?php echo ($v['pid']); ?>">删除</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                    <div class="list-page"><?php echo ($show); ?></div>
                </div>
            </form>
        </div>
    </div>
    <!--/main-->

</div>
</body>
</html>