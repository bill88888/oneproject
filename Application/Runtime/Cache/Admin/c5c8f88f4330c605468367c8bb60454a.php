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

        <div class="main-wrap">

        <div class="crumb-wrap">
            <div class="crumb-list"><i class="icon-font"></i><a href="/jscss/admin/design/">首页</a><span class="crumb-step">&gt;</span><a class="crumb-name" href="/jscss/admin/design/">作品管理</a><span class="crumb-step">&gt;</span><span>新增作品</span></div>
        </div>
        <div class="result-wrap">
            <div class="result-content">

                <form action="/index.php?m=Admin&c=User&a=update&uid=<?php echo ($user['uid']); ?>" method="post" id="myform" name="myform" enctype="multipart/form-data">
                    <table class="insert-tab" width="100%">
                        <tbody>
                            <tr>
                            <th width="120"><i class="require-red">*</i>权限：</th>
                            <td>
                                <select name="auth" id="catid" class="required">
                                    <option value="1" 
                                    <?php if($user['auth']==1){echo 'selected';} ?>>
                                    超级管理员</option>
                                    <option value="2" 
                                    <?php if($user['auth']==2){echo 'selected';} ?>>
                                    普通管理员</option>
                                    <option value="3" 
                                    <?php if($user['auth']==3){echo 'selected';} ?>>
                                    普通用户</option>
                                </select>
                            </td>
                        </tr>
                            <tr>
                                <th><i class="require-red">*</i>账号：</th>
                                <td>
                                    <input class="common-text required" id="title" name="uname" size="50" value="<?php echo ($user['uname']); ?>" type="text">
                                </td>
                            </tr>
                        
                            <tr>
                                <th><i class="require-red">*</i>性别：</th>
                                <td>

                                    女<input name="sex" id="" type="radio" value="w" size="50"  
                                    <?php
 if($user['sex'] == 'w') {echo 'checked';} ?>>

                                    男<input name="sex" id="" type="radio" value="m" size="50" 
                                    <?php
 if($user['sex'] == 'm'){echo 'checked';} ?> >

                                    保密<input name="sex" id="" type="radio" value="x" size="50" 
                                    <?php
 if($user['sex'] == 'x'){echo 'checked';} ?> >
                
                            </td>
                            </tr>
                            <tr>
                                <th>年龄：</th>
                                <td><input class="common-text" name="age" size="50" value="<?php echo ($user['age']); ?>" type="text"></td>
                            </tr>
                            <tr>
                                <th>头像：</th>
                                <td><input class="common-text" name="uface" size="50" value="              <?php echo ($user['uface']); ?>" type="file">
                                    <img src="/Public/Uploads/<?=getSm($user['uface'])?>"/>
                                </td>
                            </tr>
                            <tr>
                                <th>电话：</th>
                                <td><input class="common-text" name="tel" size="50" value="<?php echo ($user['tel']); ?>" type="text"></td>
                            </tr>
                            <tr>
                                <th></th>
                                <td>
                                    <input class="btn btn-primary btn6 mr10" value="更新" type="submit">
                                    <input class="btn btn6" onclick="history.go(-1)" value="返回" type="button">
                                </td>
                            </tr>
                        </tbody></table>
                </form>
            </div>
        </div>

    </div>

</div>
</body>
</html>