<?php

$ip = $_GET['ip'] ?? null;
if ($ip){
    $result = passthru('ping -c 4 '.$ip);
    return ;
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>简单案例</title>
    <!-- 请勿在项目正式环境中引用该 layui.css 地址 -->
    <link href="/public/layui/css/layui.css" rel="stylesheet">
</head>
<body>
<form class="layui-form" lay-filter="form-1">
    <div class="layui-form-item">
        <div class="layui-inline">
            <label class="layui-form-label">ip</label>
            <div class="layui-input-inline layui-input-wrap">
                <input type="text" name="id"   placeholder="输入ip测试是否通信" class="layui-input demo-phone">
            </div>
            <div class="layui-form-mid" style="padding: 0!important;">
                <button type="button" class="layui-btn layui-btn-primary" lay-on="get-id">测试</button>
            </div>
        </div>
    </div>
</form>
<textarea  id="result" readonly style="width: 500px;height: 300px;"></textarea>

<script src="/public/layui/layui.js"></script>
<script>
    layui.use(['form', 'laydate', 'util'], function(){
        var form = layui.form;
        var layer = layui.layer;
        var util = layui.util;
        var $ = layui.$;

        // 普通事件
        util.on('lay-on', {
            // 获取验证码
            "get-id": function(othis){
                var ip = $('input[name="id"]').val();
                var index = layer.load(0, {shade: false});
                $.ajax({
                    url: '/home/network.php?ip='+ip, // 替换为你的获取数据的URL
                    type: 'GET',
                    success: function(response) {
                        // 清空表格内容
                        $('#result').val(response);
                        layer.close(index);


                    },
                    error: function(xhr, status, error) {
                        layer.close(index);
                        layer.msg('服务器异常',{icon: 2});

                    }
                });


            }
        });
    });
</script>
</body>
</html>