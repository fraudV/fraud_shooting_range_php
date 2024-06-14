<?php
global $conn;
require_once './config/db.php';

$page = isset($_GET['page']) ? (int)$_GET['page'] : false;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : false;

if ($page||$limit){
    require_once './utils.php';
    $emails = select_email();
    $offset = ($page - 1) * $limit;
    echo json_encode(['code'=>0,'count'=>count($emails),'data'=>array_slice($emails, $offset, $limit)]);
    return;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>邮件客户端</title>
    <!-- 请勿在项目正式环境中引用该 layui.css 地址 -->
    <link href="/public/layui/css/layui.css" rel="stylesheet">
</head>
<body>
<table class="layui-table" lay-data="{height:315, url:'/email.php', page:true}" id="ID-table-demo-init">
    <thead>
    <tr>
        <th lay-data="{field:'timestamp', width:200, sort: true}">时间</th>
        <th lay-data="{field:'recipient', width:200}">收件人</th>
        <th lay-data="{field:'sender'}">发件</th>
        <th lay-data="{field:'title'}">主题</th>
        <th lay-data="{field:'info', escape: false}" >内容</th>
    </tr>
    </thead>
</table>
<script src="/public/layui/layui.js"></script>
</body>
</html>