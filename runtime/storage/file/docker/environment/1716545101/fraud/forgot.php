<?php
include './config/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $name = $_POST['name'];
    $host  = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://";
    $host = $host.$_SERVER['HTTP_HOST'];
    $token = md5(uniqid());
    $url = $host.'/reset_password.php?token='.$token;
    $cachedData=[
        'name'=>$name,
        'token'=>$token
    ];
    $_SESSION['cachedData']=$cachedData;
    $_SESSION['message']='重置密码链接已经发送';
    insetEmail($name.'@fraud.com','重置密码链接：'.$url);
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>忘记密码</title>
    <link href="/public/layui/css/layui.css" rel="stylesheet">
</head>
<body>
<div class="layui-btn-container">
    <button type="button" class="layui-btn layui-btn-primary" lay-on="test-page">邮件客户端</button>
</div>
<form class="layui-form" action="" method="post">
    <div class="layui-form-item">
        <div class="layui-inline">
            <label class="layui-form-label">用户名</label>
            <div class="layui-input-inline layui-input-wrap">
                <input type="text" name="name" lay-verify="required" autocomplete="off" lay-reqtext="请填用户名" lay-affix="clear" class="layui-input demo-phone">
            </div>
            <div class="layui-form-mid" style="padding: 0!important;">
                <button type="submit" class="layui-btn layui-btn-primary" >确认</button>
            </div>
        </div>
    </div>
</form>
<script src="/public/layui//layui.js"></script><script>
    <?php
    if (isset($_SESSION['message'])) {
        echo 'layer.msg("' . $_SESSION['message'] . '");';}
        unset($_SESSION['message']);
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