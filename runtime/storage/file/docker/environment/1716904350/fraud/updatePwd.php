<?php

require_once './config/db.php';
session_start();

if(!isset($_SESSION['user'])){
    $_SESSION['message']='无权访问';
    header("Location: /login.php");
    exit();
}

$user = $_SESSION['user'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = isset($_POST['user']) ? $_POST['user'] : '';
    $pwd = isset($_POST['pwd']) ? $_POST['pwd'] : '';
    $pwd1 = isset($_POST['pwd1']) ? $_POST['pwd1'] : '';
    $pwd2 = isset($_POST['pwd2']) ? $_POST['pwd2'] : '';

    $result  = controls("SELECT user,pwd FROM users WHERE user = ?",$user);
    if ($result){
        while ($row = $result->fetch_assoc()) {
            if ($row['pwd'] === $pwd) {
                if($pwd1==$pwd2){
                    updatePassword($user,$pwd1);
                    session_destroy();
                    $_SESSION['message']='修改成功，请重新登录';
                    header("Location: /login.php");
                    exit();
                }else{
                    $_SESSION['message']='密码不一致';
                }
            }else{
                if($pwd1==$pwd2){
                    session_destroy();
                    $_SESSION['message']='密码错误，请重新登录';
                    header("Location: /login.php");
                    exit();
                }else{
                    $_SESSION['message']='当前密码不正确';
                }
            }
        }
    }

}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>修改密码</title>
    <!-- 请勿在项目正式环境中引用该 layui.css 地址 -->
    <link href="//unpkg.com/layui@2.9.8/dist/css/layui.css" rel="stylesheet">
</head>
<body>
<style>
    .demo-reg-container{width: 320px; margin: 21px auto 0;}
    .demo-reg-other .layui-icon{position: relative; display: inline-block; margin: 0 2px; top: 2px; font-size: 26px;}
</style>
<form class="layui-form" method="post">
    <div class="demo-reg-container">
        <input type="hidden" name="user" value="<?php echo $user ?>" lay-verify="required" placeholder="昵称" autocomplete="off" class="layui-input" lay-affix="clear">

        <div class="layui-form-item">
            <div class="layui-input-wrap">
                <div class="layui-input-prefix">
                    <i class="layui-icon layui-icon-password"></i>
                </div>
                <input type="password" name="pwd" value="" lay-verify="required" placeholder="原始密码" autocomplete="off" class="layui-input"  lay-affix="eye">
            </div>
        </div>

        <div class="layui-form-item">
            <div class="layui-input-wrap">
                <div class="layui-input-prefix">
                    <i class="layui-icon layui-icon-password"></i>
                </div>
                <input type="password" name="pwd1" value="" lay-verify="required" placeholder="密码" autocomplete="off" class="layui-input" id="reg-password" lay-affix="eye">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-wrap">
                <div class="layui-input-prefix">
                    <i class="layui-icon layui-icon-password"></i>
                </div>
                <input type="password" name="pwd2" value="" lay-verify="required|confirmPassword" placeholder="确认密码" autocomplete="off" class="layui-input" lay-affix="eye">
            </div>
        </div>


        <div class="layui-form-item">
            <button class="layui-btn layui-btn-fluid" lay-submit lay-filter="demo-reg">修改</button>
        </div>

    </div>
</form>

<!-- 请勿在项目正式环境中引用该 layui.js 地址 -->
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