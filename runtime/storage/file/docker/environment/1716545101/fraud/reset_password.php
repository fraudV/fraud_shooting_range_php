<?php
include './config/db.php';
session_start();
$cachedData=isset($_SESSION['cachedData'])?$_SESSION['cachedData']:null;

$token = isset($_GET['token']) ? $_GET['token'] : '';

if ((isset($cachedData['token'])?$cachedData['token']:'')!=$token){
    die('token错误');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $confirmPassword = isset($_POST['confirmPassword']) ? $_POST['confirmPassword'] : '';

    if (isset($cachedData['name'])&&$cachedData['name']!=$name) {
        die('用户名错误');
    }

    $users  = controls("SELECT user,pwd FROM users WHERE user = ?",$name);
    if (!$users){
        die('用户名不存在');
    }else if ($password!=$confirmPassword){
        die('两次密码不一致');
    }



    updatePassword($name,$password);
    unset($_SESSION['cachedData']);
    $_SESSION['message']='密码重置成功';
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


        <input type="hidden" name="name" value="<?php echo $cachedData['name'] ?>">
        <div class="layui-form-item">
            <div class="layui-input-wrap">
                <div class="layui-input-prefix">
                    <i class="layui-icon layui-icon-password"></i>
                </div>

                <input type="password" name="password" value="" lay-verify="required" placeholder="密码" autocomplete="off" class="layui-input" id="reg-password" lay-affix="eye">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-wrap">
                <div class="layui-input-prefix">
                    <i class="layui-icon layui-icon-password"></i>
                </div>
                <input type="password" name="confirmPassword" value="" lay-verify="required|confirmPassword" placeholder="确认密码" autocomplete="off" class="layui-input" lay-affix="eye">
            </div>
        </div>

        <div class="layui-form-item">
            <button class="layui-btn layui-btn-fluid" lay-submit lay-filter="demo-reg">重置</button>
        </div>
    </div>
</form>
<script src="/public/layui/layui.js"></script><script>

    <?php
    if (isset($_SESSION['message'])) {
        echo '<script>';
        echo 'layer.msg("' . $_SESSION['message'] . '");';}
    echo '</script>';
    unset($_SESSION['message']);

    ?>

    </body>
    </html>