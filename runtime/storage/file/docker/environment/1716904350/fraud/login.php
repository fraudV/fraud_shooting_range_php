<?php
session_start();
require_once './config/db.php';
include "./utils.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    global $conn;
    $ipc = ipCount(3);
    if ($ipc){
        $_SESSION['message'] = "操作次数过多，请1分钟后重试";
    }else{
        $user = isset($_POST['user']) ? $_POST['user'] : '';
        $pwd = isset($_POST['pwd']) ? $_POST['pwd'] : '';

        $result  = controls("SELECT user,pwd FROM users WHERE user = ?",$user);
        if ($result){
            while ($row = $result->fetch_assoc()) {
                if ($row['pwd'] === $pwd) {
                    $_SESSION['user']=$user;
                    header("Location: /index.php");
                    exit();
                }
            }
        }
        $_SESSION['message'] =  "用户名或密码错误";
    }

}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>密码重置枚举</title>
    <!-- 请勿在项目正式环境中引用该 layui.css 地址 -->
    <link href="/public/layui/css/layui.css" rel="stylesheet">
</head>
<body>
<style>
    .demo-login-container{width: 320px; margin: 21px auto 0;}
    .demo-login-other .layui-icon{position: relative; display: inline-block; margin: 0 2px; top: 2px; font-size: 26px;}
</style>


<form class="layui-form" method="post">
    <div class="demo-login-container">
        <div class="layui-form-item">
            <div class="layui-input-wrap">
                <div class="layui-input-prefix">
                    <i class="layui-icon layui-icon-username"></i>
                </div>
                <input type="text" name="user" value="admin" lay-verify="required" placeholder="用户名" lay-reqtext="请填写用户名" autocomplete="off" class="layui-input" lay-affix="clear">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-wrap">
                <div class="layui-input-prefix">
                    <i class="layui-icon layui-icon-password"></i>
                </div>
                <input type="password" name="pwd" value="admin" lay-verify="required" placeholder="密   码" lay-reqtext="请填写密码" autocomplete="off" class="layui-input" lay-affix="eye">
            </div>
        </div>

        <div class="layui-form-item">
            <a href="/forgot.php" style="float: right; margin-top: 7px;">忘记密码？</a>
        </div>

        <div class="layui-form-item">
            <button class="layui-btn layui-btn-fluid" lay-submit>登录</button>
        </div>

    </div>
</form>
<script src="/public/layui/layui.js"></script>
<script>
    <?php
    if (isset($_SESSION['message'])) {
        echo 'layer.msg("' . $_SESSION['message'] . '");';}
        unset($_SESSION['message']);
    ?>

</script>
</body>
</html>