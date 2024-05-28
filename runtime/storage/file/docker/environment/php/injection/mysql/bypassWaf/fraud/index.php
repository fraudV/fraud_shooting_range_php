<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once './config/db.php';
    global $conn;

    $xmlData = file_get_contents("php://input");
    if(strpos($xmlData,' ')!==false){

        return json_encode(['code'=>201,'msg'=>'检测到攻击']);
    }
    $xml = simplexml_load_string($xmlData);

    $id = $xml->id ?? 0;

    $sql = "SELECT id,user FROM users where id={$id}";
    $result = $conn->query($sql);
    $userData = array();
    if ($result!=null && $result->num_rows > 0){
        while($row = $result->fetch_assoc()) {
            $userData[] = $row;
        }
    }
    echo json_encode(['code'=>0,'data'=>$userData,'msg'=>'查询成功']);
    return;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>绕waf</title>
    <!-- 请勿在项目正式环境中引用该 layui.css 地址 -->
    <link href="/public/layui/css/layui.css" rel="stylesheet">
</head>
<body>
<form class="layui-form" lay-filter="form-1">
    <div class="layui-form-item">
        <div class="layui-inline">
            <label class="layui-form-label">用户id</label>
            <div class="layui-input-inline layui-input-wrap">
                <input type="number" name="id"   lay-reqtext="请填写用户id" class="layui-input demo-phone">
            </div>
            <div class="layui-form-mid" style="padding: 0!important;">
                <button type="button" class="layui-btn layui-btn-primary" lay-on="get-id">查询</button>
            </div>
        </div>
    </div>
</form>
<table class="layui-table">
    <colgroup>
        <col width="150">
        <col width="150">
        <col>
    </colgroup>
    <thead>
    <tr>
        <th>id</th>
        <th>用户</th>
    </tr>
    </thead>
    <tbody id="tableBody">

    </tbody>
</table>

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
                var userId = $('input[name="id"]').val();
                var xmlData = '<Select>' +
                    '<id>' + userId + '</id>' +
                    '</Select>';

                $.ajax({
                    url: '/', // 替换为你的获取数据的URL
                    type: 'POST',
                    dataType: 'json',
                    data:xmlData,
                    success: function(response) {
                        if(response.code==0){
                            // 清空表格内容
                            $('#tableBody').empty();

                            // 遍历响应数据，并将数据添加到表格中
                            $.each(response.data, function(index, item) {
                                var row = $('<tr>');
                                row.append($('<td>').text(item.id));
                                row.append($('<td>').text(item.user));
                                $('#tableBody').append(row);
                            });
                            layer.msg(response.msg);
                        }else {
                            layer.msg(response.error,{icon: 2});
                        }

                    },
                    error: function(xhr, status, error) {
                        layer.msg('服务器异常',{icon: 2});
                    }
                });


            }
        });
    });
</script>
</body>