<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once './config/db.php';
    global $conn;
    $user = $_POST['user'];
    $pwd = $_POST['pwd'];

    // 准备预编译语句
    $stmt = $conn->prepare("SELECT user,pwd FROM users WHERE user = ?");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    // 绑定参数
    $stmt->bind_param("s", $user);

    $stmt->execute();

    $result = $stmt->get_result();
    if ($result!=null&&$result->num_rows > 0){
        while ($row = $result->fetch_assoc()) {
            if($row['pwd']==$pwd){
                setcookie("user", $user, time() + 5, "/");
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
    <title>用户名枚举</title>
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