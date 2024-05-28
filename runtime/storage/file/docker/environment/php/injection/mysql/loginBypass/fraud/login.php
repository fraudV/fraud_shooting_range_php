<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once './config/db.php';
    global $conn;
    $user = $_POST['user'];
    $pwd = $_POST['pwd'];

    $sql = "SELECT user FROM users where user='{$user}' and pwd='{$pwd}'";
    $result = $conn->query($sql);
    if ($result!=null && $result->num_rows > 0){
        setcookie("user", $user, time() + 3600, "/");
        header("Location: /index.php");
        exit;
    }
    $error_msg = "用户名或密码错误";
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>登录绕过</title>
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
                <input type="text" name="user" value="" lay-verify="required" placeholder="用户名" lay-reqtext="请填写用户名" autocomplete="off" class="layui-input" lay-affix="clear">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-wrap">
                <div class="layui-input-prefix">
                    <i class="layui-icon layui-icon-password"></i>
                </div>
                <input type="password" name="pwd" value="" lay-verify="required" placeholder="密   码" lay-reqtext="请填写密码" autocomplete="off" class="layui-input" lay-affix="eye">
            </div>
        </div>

        <div class="layui-form-item">
            <input type="checkbox" name="remember" lay-skin="primary" title="记住密码">
            <a href="#forget" style="float: right; margin-top: 7px;">忘记密码？</a>
        </div>
        <div class="layui-form-item">
            <button class="layui-btn layui-btn-fluid" lay-submit>登录</button>
        </div>
    </div>
</form>
<script src="/public/layui//layui.js"></script>
<script>
    <?php
if (isset($error_msg) && !empty($error_msg)) {
    echo 'layer.msg("' . $error_msg . '");';}
?>

</script>
</body>
</html>