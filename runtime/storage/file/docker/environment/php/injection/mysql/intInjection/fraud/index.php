<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>int注入</title>
    <!-- 请勿在项目正式环境中引用该 layui.css 地址 -->
    <link href="/public/layui/css/layui.css" rel="stylesheet">
</head>
<body>
<form class="layui-form layui-row layui-col-space16">
    <div class="layui-form-item">
        <div class="layui-input-group">
            <div class="layui-input-split layui-input-prefix">
                用户id：
            </div>
            <input type="number" placeholder="用户id" class="layui-input" name="id">
            <div class="layui-input-suffix">
                <button class="layui-btn layui-btn-primary">查询</button>
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
        <th>用户名</th>
        <th>密码</th>
    </tr>
    </thead>
    <tbody>
    <?php
    require_once './config/db.php';
    global$conn;

    $id = $_GET['id'] ?? 0;
    $sql = "SELECT user, pwd FROM users where id={$id}";
    $result = $conn->query($sql);
    if ($result!=null && $result->num_rows > 0) {
        // 输出数据
        while($row = $result->fetch_assoc()) {
           echo " <tr>
        <td>".$row['user']."</td>
        <td>".$row['pwd']."</td>
    </tr>";
        }
    } else {
        echo " <tr>
        <td>无数据</td>
        <td>无数据</td>
    </tr>";
    }
    ?>


    </tbody>
</table>

</body>
</html>