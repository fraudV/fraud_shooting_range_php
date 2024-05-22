<?php
include "./utils.php";
session_start();
$user =  $_SESSION['user'];
$code=  $_SESSION['code'];

if (!isset($user)) {
    $_SESSION['message'] = "无权访问";
    header("Location: /login.php");
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $p_code = $_POST['code'];
    if ($p_code==$code){
        unset($_SESSION['code']);
        unset($_SESSION['message']);
        header("Location: /index.php");
        exit();
    }
    $ipc = ipCount(6);
    if ($ipc) {
        $_SESSION['message'] = "操作次数过多，请1分钟后重试";
        header("Location: /login.php");
    }

    $_SESSION['message'] = "验证码错误";

}

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>邮箱验证</title>
    <link href="/pulic/layui/css/layui.css" rel="stylesheet">
</head>
<body>
<div class="layui-btn-container">
    <button type="button" class="layui-btn layui-btn-primary" lay-on="test-page">邮件客户端</button>
</div>
<form class="layui-form" action="/verify.php" method="post">
    <div class="layui-form-item">
        <div class="layui-inline">
            <label class="layui-form-label">邮箱验证码</label>
            <div class="layui-input-inline layui-input-wrap">
                <input type="number" name="code" lay-verify="required" autocomplete="off" lay-reqtext="请填验证码" lay-affix="clear" class="layui-input demo-phone">
            </div>
            <div class="layui-form-mid" style="padding: 0!important;">
                <button type="submit" class="layui-btn layui-btn-primary" >确认</button>
            </div>
        </div>
    </div>
</form>
<script src="/pulic/layui//layui.js"></script><script>
    <?php
    if (isset($_SESSION['message'])) {
        echo 'layer.msg("' . $_SESSION['message'] . '");';}
    ?>
    layui.use(function(){
        var layer = layui.layer;
        var util = layui.util;
        // 事件
        util.on('lay-on', {
            'test-page': function(){
                layer.open({
                    type: 2,
                    title :'邮箱客户端',
                    area: ['100%', '100%'], // 宽高
                    content: '/content.php'
                });
            }
        })
    });
</script>
</body>
</html>