<?php
require_once './vendor/autoload.php';
use Firebase\JWT\JWT;

include './config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $key = 'pqXF4qO179SqZQoQFz2nhSzd4OqcJoXo';
    $name = $_POST['name'];
    $http  = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://";
//    $host = isset($_SERVER['X-Forwarded-Host']) ? $_SERVER['X-Forwarded-Host'] :$_SERVER['HTTP_HOST'];
    $host = $_SERVER['HTTP_X_FORWARDED_FOR'];
    $host = $http.$host;

    $header = ['typ' => 'JWT', 'alg' => 'HS256'];
    $payload = [
        'name' => $name,
        'iat' => time()
    ];

    $jwt = JWT::encode($payload, $key, 'HS256');
    $url = $host.'/reset_password.php?token='.$jwt;

    insetEmail($name.'@fraud.com','重置密码链接：'.$url);
    echo json_encode(['code'=>0,'msg'=>'邮件已发送']);
    return;
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
                <button type="submit" lay-submit lay-filter="demo-forgot" class="layui-btn layui-btn-primary" >确认</button>
            </div>
        </div>
    </div>
</form>
<script src="/public/layui/layui.js"></script><script>
    <?php
    if (isset($msg)) {
        echo 'layer.msg("' . $msg . '");';
    }
    ?>
    layui.use(function(){
        var layer = layui.layer;
        var util = layui.util;
        var $ = layui.$;
        var form = layui.form;

        form.on('submit(demo-forgot)', function(data){
            var field =data.field; // 获取表单字段值
            // 显示填写结果，仅作演示用
            $.ajax({
                url: '/forgot.php',
                type: 'POST',
                headers: {
                    "X-Forwarded-For": window.location.host // 添加请求头
                },
                dataType:'json',
                data:field,
                success: function(data) {
                    if(data.code==0){
                        layer.msg(data.msg);
                    }else {
                        layer.msg(data.msg,{icon: 2});
                    }
                },
                error: function (xhr, status, error) {
                    layer.msg('服务器异常',{icon: 2});
                }
            });
            return false; // 阻止默认 form 跳转
        });
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