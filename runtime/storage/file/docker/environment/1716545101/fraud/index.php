<?php
include './utils.php';
session_start();

$user = $_SESSION['user'];
if(!isset($user)){
    $_SESSION['message']='无权访问';
    header("Location: /login.php");
    exit();
}



$quit = isset($_GET['quit']) && (bool)$_GET['quit'];
if ($quit){
    unset($_SESSION['user']);
    $_SESSION['message'] = "退出成功";
    header("Location: /login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>离线破解</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/public/layui/css/layui.css" rel="stylesheet">
</head>
<body>
<div class="layui-layout layui-layout-admin">
    <div class="layui-header">
        <div class="layui-logo layui-hide-xs layui-bg-black">fraud</div>

        <ul class="layui-nav layui-layout-right">
            <li class="layui-nav-item layui-hide layui-show-sm-inline-block">
                <a href="javascript:;">
                    <?php echo $user?>
                </a>
                <dl class="layui-nav-child">
                    <dd><a href="/index.php?quit=true">退出</a></dd>
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

    </div>
    <div class="layui-body">
        <!-- 内容主体区域 -->
        <div style="padding: 15px;">
            <blockquote class="layui-elem-quote layui-text">
                欢迎光临<?php echo $user?>
            </blockquote>
            <?php if ($user!='admin'){
                $f_flag = getenv('F_FLAG');
                echo $f_flag !== false ? $f_flag : '';
            } ?>
            <br><br>
        </div>
    </div>
    <div class="layui-footer">
        <!-- 底部固定区域 -->
        底部固定区域
    </div>
</div>

<script src="/public/layui//layui.js"></script>

</body>
</html>