<?php
require_once './vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

include './config/db.php';


if (!isset($_GET['token'])){
    die('token错误');
}

try {
    $key = 'pqXF4qO179SqZQoQFz2nhSzd4OqcJoXo';
    $decoded = JWT::decode($_GET['token'], new Key($key, 'HS256'), $headers = new stdClass());
    $decoded_array = (array) $decoded;
}catch (Exception $e) {
    die('token错误');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $confirmPassword = isset($_POST['confirmPassword']) ? $_POST['confirmPassword'] : '';


    $users  = controls("SELECT user,pwd FROM users WHERE user = ?",$decoded_array['name']);
    if (!$users){
        die('用户名错误');
    }else if ($password!=$confirmPassword){
        die('两次密码不一致');
    }


    updatePassword($decoded_array['name'],$password);
    $msg='密码重置成功';
    header("Location: /login.php");
}


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>重置密码</title>
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
                    <i class="layui-icon layui-icon-password"></i>
                </div>

                <input type="password" name="password" value="" lay-verify="required" placeholder="密码" autocomplete="off" class="layui-input" id="password" lay-affix="eye">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-wrap">
                <div class="layui-input-prefix">
                    <i class="layui-icon layui-icon-password"></i>
                </div>
                <input type="password" id="confirmPassword" name="confirmPassword" value="" lay-verify="required|confirmPassword" placeholder="确认密码" autocomplete="off" class="layui-input" lay-affix="eye">
            </div>
        </div>

        <div class="layui-form-item">
            <button id="reset" class="layui-btn layui-btn-fluid" lay-submit lay-filter="demo-reg">重置</button>
        </div>
    </div>
</form>
<script src="/public/layui/layui.js"></script><script>

    <?php
    if (!is_null($msg)) {
        echo '<script>';
        echo 'layer.msg("' . $msg . '");';}
    echo '</script>';

    ?>

</body>
</html>