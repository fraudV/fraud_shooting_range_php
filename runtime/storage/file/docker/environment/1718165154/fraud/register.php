<?php
if( $_SERVER['REQUEST_METHOD'] === 'POST'){
    require_once './utils.php';
    $username=$_POST['username']??false;
    $email=$_POST['email']??false;
    $password=$_POST['password']??false;
    $confirmPassword=$_POST['confirmPassword']??false;
    if ($username&&$email&&$password&&$confirmPassword){

    }else{
        echo json_encode(['code'=>1,'msg'=>'参数不能为空']);
        return;
    }
    $result = get_user($username);
    if ($result){
        echo json_encode(['code'=>1,'msg'=>'用户名存在']);
        return;
    }

    if ($password!=$confirmPassword){
        echo json_encode(['code'=>1,'msg'=>'密码不一致']);
        return;
    }

    $http  = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://";
    $host = $_SERVER['HTTP_HOST'];
    $host = $http.$host;
    echo add_user($username,$password,$email,$host);
    return;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>注册账号</title>
    <!-- 请勿在项目正式环境中引用该 layui.css 地址 -->
    <link href="/public/layui/css/layui.css" rel="stylesheet">
</head>
<body>
<style>
    .demo-reg-container{width: 320px; margin: 21px auto 0;}
    .demo-reg-other .layui-icon{position: relative; display: inline-block; margin: 0 2px; top: 2px; font-size: 26px;}
</style>

<form class="layui-form">
    <a href="email.php"><button type="button" class="layui-btn">邮件客户端</button></a>
    <div class="demo-reg-container">
        <div class="layui-form-item">
            <div class="layui-input-wrap">
                <div class="layui-input-prefix">
                    <i class="layui-icon layui-icon-username"></i>
                </div>
                <input type="text" name="username" value="" lay-verify="required" placeholder="昵称" autocomplete="off" class="layui-input" lay-affix="clear">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-wrap">
                <div class="layui-input-prefix">
                    <i class="layui-icon layui-icon-email"></i>
                </div>
                <input type="text" name="email" value="" lay-verify="required" placeholder="邮箱：xxxx@fraud.com" autocomplete="off" class="layui-input" lay-affix="clear">
            </div>
        </div>
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
            <button class="layui-btn layui-btn-fluid" lay-submit lay-filter="demo-reg">注册</button>
        </div>

    </div>
</form>

<!-- 请勿在项目正式环境中引用该 layui.js 地址 -->
<script src="/public/layui/layui.js"></script>
<script>
    layui.use(function(){
        var $ = layui.$;
        var form = layui.form;
        var layer = layui.layer;
        var util = layui.util;

        // 自定义验证规则
        form.verify({
            // 确认密码
            confirmPassword: function(value, item){
                var passwordValue = $('#reg-password').val();
                if(value !== passwordValue){
                    return '两次密码输入不一致';
                }
            }
        });

        // 提交事件
        form.on('submit(demo-reg)', function(data){
            var field = data.field; // 获取表单字段值

            $.ajax({
                url: '/register.php', // 替换为你的 API 端点
                type: 'POST',
                dataType: 'json',
                data: field,
                success: function(response) {
                    if (response.code===0){
                        layer.msg(response.msg);
                    }else {
                        layer.msg(response.msg);
                    }

                },
                error: function(xhr, status, error) {
                    console.log('Error:', error);
                }
            });

            return false; // 阻止默认 form 跳转
        });


    });
</script>

</body>
</html>