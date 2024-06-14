<?php
session_start();

if(!$_SESSION['name']){
    header("Location: /login.php");
    exit();
}


if( $_SERVER['REQUEST_METHOD'] === 'POST'){
    require_once './utils.php';

    $username=$_POST['username']??'';
    $password=$_POST['password']??'';
    $newPassword=$_POST['newPassword']??'';
    $confirmPassword=$_POST['confirmPassword']??'';

    if ($newPassword!=$confirmPassword){
        echo json_encode(['code'=>1,'msg'=>'密码不一致']);
        return;
    }

    $result = get_user($username);
    if ($result){
        if($result['password']==$password){
            if(update_user_pwd($username,$password)){
                echo json_encode(['code'=>0,'msg'=>'密码修改成功']);
                session_destroy();
                return;
            }else{
                echo json_encode(['code'=>1,'msg'=>'密码修改失败']);
                return;
            }
        }else{
            echo json_encode(['code'=>1,'msg'=>'密码错误正确']);
            return;
        }
    }else{
        echo json_encode(['code'=>1,'msg'=>'用户名不正确']);
        return;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>修改信息</title>
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


        <div class="layui-form-item">
            <div class="layui-input-wrap">
                <div class="layui-input-prefix">
                    <i class="layui-icon layui-icon-email"></i>
                </div>
                <input type="text" disabled name="username" value="<?php echo $_SESSION['name'];?>" lay-verify="required" placeholder="密码" autocomplete="off" class="layui-input" lay-affix="clear">
            </div>
        </div>

        <div class="layui-form-item">
            <div class="layui-input-wrap">
                <div class="layui-input-prefix">
                    <i class="layui-icon layui-icon-email"></i>
                </div>
                <input type="text" name="password" value="" lay-verify="required" placeholder="密码" autocomplete="off" class="layui-input" lay-affix="clear">
            </div>
        </div>

        <div class="layui-form-item">
            <div class="layui-input-wrap">
                <div class="layui-input-prefix">
                    <i class="layui-icon layui-icon-email"></i>
                </div>
                <input type="text" name="newPassword" value="" lay-verify="required" placeholder="新密码" autocomplete="off" class="layui-input" lay-affix="clear">
            </div>
        </div>

        <div class="layui-form-item">
            <div class="layui-input-wrap">
                <div class="layui-input-prefix">
                    <i class="layui-icon layui-icon-email"></i>
                </div>
                <input type="text" name="confirmPassword" value="" lay-verify="required" placeholder="确认密码" autocomplete="off" class="layui-input" lay-affix="clear">
            </div>
        </div>

        <div class="layui-form-item">
            <button class="layui-btn layui-btn-fluid" lay-submit lay-filter="update">修改</button>
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



        // 提交事件
        form.on('submit(demo-reg)', function(data){
            var field = data.field; // 获取表单字段值

            $.ajax({
                url: '/update.php', // 替换为你的 API 端点
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