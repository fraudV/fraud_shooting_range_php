<?php
global $conn;
require_once './config/db.php';

$page = isset($_GET['page']) ? (int)$_GET['page'] : null;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : null;

if ($page !== null && is_int($page) && $limit !== null && is_int($limit)) {
    $offset = ($page - 1) * $limit;

    $sql = "SELECT * FROM email WHERE sender = ?  ORDER BY time DESC LIMIT ? OFFSET ?";

    $stmt = $conn->prepare($sql);
    $str = "admin@fraud.com";
    $stmt->bind_param("sii", $str,$limit, $offset);
    $stmt->execute();
    $result = $stmt->get_result();

    $emails = [];
    while ($row = $result->fetch_assoc()) {
        $emails[] = $row;
    }

    echo json_encode(['code'=>0,'count'=>count($emails),'data'=>$emails]);
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Demo</title>
    <!-- 请勿在项目正式环境中引用该 layui.css 地址 -->
    <link href="//unpkg.com/layui@2.9.10/dist/css/layui.css" rel="stylesheet">
</head>
<body>
<table class="layui-table" lay-data="{height:315, url:'/content.php', page:true}" id="ID-table-demo-init">
    <thead>
    <tr>
        <th lay-data="{field:'time', width:200, sort: true}">时间</th>
        <th lay-data="{field:'recipient', width:200}">收件</th>
        <th lay-data="{field:'sender'}">发件</th>
        <th lay-data="{field:'subject'}">主题</th>
        <th lay-data="{field:'content', escape: false}" >内容</th>
    </tr>
    </thead>
</table>

<!-- 请勿在项目正式环境中引用该 layui.js 地址 -->
<script src="//unpkg.com/layui@2.9.10/dist/layui.js"></script>

</body>
</html>