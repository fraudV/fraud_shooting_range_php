<?php
require_once './utils.php';
session_start();

if(!$_SESSION['name']){
    header("Location: /login.php");
    exit();
}

$controls = $_GET['controls']??'';
switch ($controls){
    case 'quit':
        session_destroy();

        header("Location: /login.php");
        exit();
}





?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>弱隔离</title>
    <!-- 请勿在项目正式环境中引用该 layui.css 地址 -->
    <link href="/public/layui/css/layui.css" rel="stylesheet">
</head>
<body>

<div class="layui-layout layui-layout-admin">
    <div class="layui-header">
        <div class="layui-logo layui-hide-xs layui-bg-black">首页</div>

        <ul class="layui-nav layui-layout-right">
            <li class="layui-nav-item layui-hide layui-show-sm-inline-block">
                <a href="javascript:;">
                    <img src="//unpkg.com/outeres@0.0.10/img/layui/icon-v2.png" class="layui-nav-img">
                    <?php echo $_SESSION['name'] ?>
                </a>
                <dl class="layui-nav-child">
                    <dd><a href="update.php">修改密码</a></dd>
                    <dd><a href="index.php?controls=quit">退出</a></dd>
                </dl>
            </li>
            <li class="layui-nav-item" lay-header-event="menuRight" lay-unselect>
                <a href="javascript:;">
                    <i class="layui-icon layui-icon-more-vertical"></i>
                </a>
            </li>
        </ul>
    </div>
    <div class="layui-side layui-bg-black">
        <div class="layui-side-scroll">
            <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
            <ul class="layui-nav layui-nav-tree" lay-filter="test">


            </ul>
        </div>
    </div>
    <div class="layui-body">
        <!-- 内容主体区域 -->
        <div style="padding: 15px;">
            <blockquote class="layui-elem-quote layui-text">
                欢迎管理，目标用户fraud
            </blockquote>
            <div class="layui-card layui-panel">
                <?php
                $user =  $_SESSION['name'];

                if ($user=='fraud') {
                    $f_flag = getenv('F_FLAG');
                    echo $f_flag !== false ? '</br>'.$f_flag : '';
                }
                ?>

            </div>
            <br><br>
        </div>
    </div>

</div>




<script src="/public/layui/layui.js"></script>
<!-- 请勿在项目正式环境中引用该 layui.js 地址 -->
<script>


</script>
</body>
</html>