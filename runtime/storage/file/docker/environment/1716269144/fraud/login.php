<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once './config/db.php';

    global $conn;
    $user = $_POST['user'];
    $pwd = $_POST['pwd'];

    // 准备预编译语句
    $stmt = $conn->prepare("SELECT user,pwd,update_time,login_count FROM users WHERE user = ?");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    // 绑定参数
    $stmt->bind_param("s", $user);

    $stmt->execute();

    $result = $stmt->get_result();
    if ($result!=null&&$result->num_rows > 0){
        while ($row = $result->fetch_assoc()) {
            if($row['login_count']>=3){
                if (time() - strtotime($row['update_time'])<60){
                    $error_msg = "登录超过最大次数，请稍后重试";
                    break;
                }else{
                    $update_login = $conn->prepare("UPDATE users SET login_count = 0 WHERE user = ?");
                }

            }else{
                $update_login = $conn->prepare("UPDATE users SET login_count = login_count+1 WHERE user = ?");
            }

            if ($update_login === false) {
                die("Prepare failed: " . $conn->error);
            }
            // 绑定参数并执行更新
            $update_login->bind_param("s", $user);
            $update_login->execute();
            
            if($row['pwd']==$pwd){
                $update_login = $conn->prepare("UPDATE users SET login_count = 0 WHERE user = ?");
                if ($update_login === false) {
                    die("Prepare failed: " . $conn->error);
                }
                // 绑定参数并执行更新
                $update_login->bind_param("s", $user);
                $update_login->execute();
                setcookie("user", $user, time() + 5, "/");
                header("Location: /index.php");
                exit;
            }
            $error_msg = "用户名或密码错误";
        }
    }else{
        $error_msg = "用户名或密码错误";
    }







}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>枚举次数</title>
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