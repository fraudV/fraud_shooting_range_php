<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>报错注入</title>
    <!-- 请勿在项目正式环境中引用该 layui.css 地址 -->
    <link href="/pulic/layui/css/layui.css" rel="stylesheet">
</head>
<body>
<form class="layui-form layui-row layui-col-space16">
    <div class="layui-form-item">
        <div class="layui-input-group">
            <div class="layui-input-split layui-input-prefix">
                用户id：
            </div>
            <input type="text" placeholder="用户名" class="layui-input" name="user">
            <div class="layui-input-suffix">
                <button class="layui-btn layui-btn-primary">查询</button>
            </div>
        </div>
    </div>
</form>

<table class="layui-table">
    <colgroup>
        <col >
        <col >
        <col>
    </colgroup>
    <thead>
    <tr>
        <th>结果</th>
    </tr>
    </thead>
    <tbody>
    <?php
    require_once './config/db.php';
    global$conn;

    $user = $_GET['user'] ?? "";
    $sql = "SELECT user, pwd FROM users where user='{$user}'";
    $result = $conn->query($sql);
    if (!$result) {
        die("Error in SQL query: " . $conn->error);
    }
    echo " <tr>
        <td>查询成功</td>
    </tr>";
    ?>


    </tbody>
</table>

</body>
</html>