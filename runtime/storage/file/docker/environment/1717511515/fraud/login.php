<?php
if( $_SERVER['REQUEST_METHOD'] === 'POST'){
    require_once './utils.php';
    $name = $_POST['name'] ?? '';
    $pwd = $_POST['pwd'] ?? '';

    $result = get_user($name);
    if ($result){
        while ($row = $result->fetch_assoc()) {
            if($row['password']==$pwd){
                setcookie("id", $row['id'],time()+3600);
                setcookie("user", $name,time()+3600);

                header("Location: /index.php");
                exit;
            }
        }
        $error_msg = "密码错误";
    }else{
        $error_msg = "用户名错误";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>过度信任</title>
    <!-- 请勿在项目正式环境中引用该 layui.css 地址 -->
    <link href="/public/layui/css/layui.css" rel="stylesheet">
</head>
<body>
<style>
    .demo-login-container{width: 320px; margin: 21px auto 0;}
    .demo-login-other .layui-icon{position: relative; display: inline-block; margin: 0 2px; top: 2px; font-size: 26px;}
</style>
<form class="layui-form" action="login.php" method="post">
    <div class="demo-login-container">
        <div class="layui-form-item">
            <div class="layui-input-wrap">
                <div class="layui-input-prefix">
                    <i class="layui-icon layui-icon-username"></i>
                </div>
                <input type="text" name="name" value="fraud" lay-verify="required" placeholder="用户名" lay-reqtext="请填写用户名" autocomplete="off" class="layui-input" lay-affix="clear">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-wrap">
                <div class="layui-input-prefix">
                    <i class="layui-icon layui-icon-password"></i>
                </div>
                <input type="password" name="pwd" value="fraud" lay-verify="required" placeholder="密   码" lay-reqtext="请填写密码" autocomplete="off" class="layui-input" lay-affix="eye">
            </div>
        </div>


        <div class="layui-form-item">
            <button class="layui-btn layui-btn-fluid" lay-submit lay-filter="demo-login">登录</button>
        </div>

    </div>
</form>

<!-- 请勿在项目正式环境中引用该 layui.js 地址 -->
<script src="/public/layui/layui.js"></script>
<script>
    <?php
    if (isset($error_msg) && !empty($error_msg)) {
        echo 'layer.msg("' . $error_msg . '");';}
    ?>
</script>

</body>
</html>