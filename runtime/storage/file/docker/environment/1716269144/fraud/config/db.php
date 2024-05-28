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

?>