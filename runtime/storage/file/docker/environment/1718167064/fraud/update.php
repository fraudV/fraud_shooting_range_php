<?php
if (!$_COOKIE["user"]|| !$_COOKIE["id"]){
    header("Location: /login.php");
    exit();
}

if( $_SERVER['REQUEST_METHOD'] === 'POST'){
    require_once './utils.php';

    $email=$_POST['email']??false;
    if ($email===false){
        die('参数异常');
    }
    setcookie("id", "", time() - 3600);

    setcookie("user", "", time() - 3600);

    die(update_user($email,$_COOKIE["user"]));

}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>修改信息</title>
    <!-- 请勿在项目正式环境中引用该 layui.css 地址 -->
    <link href="/public/layui/css/layui.css" rel="stylesheet">
</head>
<body>
<style>
    .demo-reg-container{width: 320px; margin: 21px auto 0;}
    .demo-reg-other .layui-icon{position: relative; display: inline-block; margin: 0 2px; top: 2px; font-size: 26px;}
</style>

<form class="layui-form" method="post">
    <div class="demo-reg-container">
        <div class="layui-form-item">
            <div class="layui-input-wrap">
                <div class="layui-input-prefix">
                    <i class="layui-icon layui-icon-email"></i>
                </div>
                <input type="text" name="email" value="" lay-verify="required" placeholder="邮箱" autocomplete="off" class="layui-input" lay-affix="clear">
            </div>
        </div>

        <div class="layui-form-item">
            <button class="layui-btn layui-btn-fluid" lay-submit lay-filter="update">修改</button>
        </div>

    </div>
</form>

<!-- 请勿在项目正式环境中引用该 layui.js 地址 -->
<script src="/public/layui/layui.js"></script>


</body>
</html>