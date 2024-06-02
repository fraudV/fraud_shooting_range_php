<?php
$servername = "mysql";
$username = "root";
$password = "root";
$dbname = "fraud";

// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

function controls($sql,$var1)
{
    // 准备预编译语句
    global $conn;
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("s", $var1);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    if ($result&&$result->num_rows > 0){
        return $result;
    }
    return false;
}
?>