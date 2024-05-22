<?php


//echo encipher('cocacola');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once './config/db.php';

    global $conn;

    $jsonData = json_decode(file_get_contents("php://input"));

    $user = $jsonData->user;
    $pwd = $jsonData->pwd;
    $ip = $_SERVER['REMOTE_ADDR'];

    $ipCounts = $conn->prepare("SELECT count,update_time FROM ip_counts WHERE ip = ?");
    if ($ipCounts === false) {
        die("Prepare failed: " . $conn->error);
    }
    // 绑定参数
    $ipCounts->bind_param("s", $ip);
    $ipCounts->execute();
    $result = $ipCounts->get_result();
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if($row['count']>=3){
                if (time() - strtotime($row['update_time'])<60){
                    echo json_encode(['code'=>1,'msg'=>'超出最大登录次数']);
                    return;
                }else{
                    $update_login = $conn->prepare("UPDATE ip_counts SET count = 0 WHERE ip = ?");
                }
            }else{
                $update_login = $conn->prepare("UPDATE ip_counts SET count = count+1 WHERE ip = ?");
            }
        }
    }else{
        $update_login = $conn->prepare("INSERT INTO ip_counts (ip,count) VALUES (?,1)");
    }
    if ($update_login === false) {
        die("Prepare failed: " . $conn->error);
    }
    $update_login->bind_param("s", $ip);
    $update_login->execute();

    // 准备预编译语句
    $stmt = $conn->prepare("SELECT user,pwd FROM users WHERE user = ?");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result!=null&&$result->num_rows > 0){
        while ($row = $result->fetch_assoc()) {
            if(in_array($row['pwd'], $pwd, true)){
                setcookie("user", $user, time() + 5, "/");
                echo json_encode(['code'=>0,'msg'=>'登录成功','data'=>'/index.php']);
                return;
            }

        }
    }
    echo json_encode(['code'=>1,'msg'=>'用户名密码错误']);
    return;







}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>多次请求</title>
    <!-- 请勿在项目正式环境中引用该 layui.css 地址 -->
    <link href="/pulic/layui/css/layui.css" rel="stylesheet">
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
                <input type="text" name="user" value="yoko" lay-verify="required" placeholder="用户名" lay-reqtext="请填写用户名" autocomplete="off" class="layui-input" lay-affix="clear">
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
            <button class="layui-btn layui-btn-fluid" lay-submit lay-filter="demo-login">登录</button>
        </div>
    </div>
</form>
<script src="/pulic/layui//layui.js"></script>
<script>
    layui.use(function(){
        var form = layui.form;
        var layer = layui.layer;
        var $ = layui.$;
        // 提交事件
        form.on('submit(demo-login)', function(data){
            data.field.pwd=[data.field.pwd]
            var field =JSON.stringify(data.field); // 获取表单字段值
            // 显示填写结果，仅作演示用
            $.ajax({
                url: '/login.php',
                type: 'POST',
                dataType:'json',
                data:field,
                success: function(data) {
                    if(data.code==0){
                        layer.msg(data.msg);
                        window.location.href=data.data;
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
    });
</script>
</body>
</html>