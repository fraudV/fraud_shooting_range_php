<?php
require_once './config/db.php';
require_once 'vendor/autoload.php';

use Firebase\JWT\JWT;

$key = 'fraud@asdqo1&(Hro233jrbsy';

function get_user($username)
{

    global $pdo;
    $stmt = $pdo->prepare('SELECT id, username, password, email FROM users WHERE username = :username');
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();
    if ($user) {
        return $user;
    } else {
        return false;
    }

}

/*
 * 模拟发送邮件
 * */
function add_user($username, $password, $email, $host)
{
    global $pdo, $key;

    try {
        $pdo->beginTransaction(); // 开始事务
        $email = substr($email, 0, 225);
        $data = ['username' => $username];
        $jwt = JWT::encode($data, $key, 'HS256');
        $url = $host . '/activate.php?token=' . $jwt;
        $recipient = "激活用户地址: <a href=\"{$url}\">{$url}</a>";

        $stmt = $pdo->prepare('INSERT INTO email (title, sender, recipient, info) VALUES ("激活用户", "admin@admin.com", :recipient, :info)');
        $stmt->execute(['recipient' => $email, 'info' => $recipient]);


        $stmt = $pdo->prepare('INSERT INTO users (username, password, email) VALUES (:username, :password, :email)');
        $stmt->execute(['username' => $username, 'password' => $password, 'email' => $email]);

        $pdo->commit(); // 提交事务

        return json_encode(['code' => 0, 'msg' => '邮件发送成功']);
    } catch (PDOException $e) {
        $pdo->rollBack(); // 回滚事务
        return json_encode(['code' => 1, 'msg' => '注册失败','data'=>$e->getMessage()]);
    }
}

function activate_user($username)
{
    global $pdo;
    $stmt = $pdo->prepare("UPDATE users SET status=1 WHERE username=:username");
    $result = $stmt->execute(['username' => $username]);
    if ($result){
        return $username.' 激活成功';
    }else{
        return $username.' 激活失败';
    }
}

function update_user($email,$username)
{
    global $pdo;
    $stmt = $pdo->prepare("UPDATE users SET email=:email WHERE username=:username");
    $result = $stmt->execute(['email' => $email,'username'=>$username]);
    if ($result){
        return '修改成功，<a href="/login.php">重新登录</a>';
    }else{
        return '修改失败,<a href="/login.php">重新登录</a>';
    }
}

function update_user_pwd($username,$password)
{
    global $pdo;
    $stmt = $pdo->prepare("UPDATE users SET password=:password WHERE username=:username");
    $result = $stmt->execute(['password' => $password,'username'=>$username]);
    if ($result){
        return true;
    }else{
        return false;
    }
}

function select_email() {
    global $pdo;

    // 准备 SQL 查询，增加 WHERE 子句筛选以 'fraud.com' 结尾的 recipient
    $stmt = $pdo->prepare("SELECT * FROM email WHERE recipient LIKE :recipient ORDER BY timestamp");

    // 创建模式字符串变量
    $recipient_pattern = '%fraud.com';

    // 绑定参数
    $stmt->bindParam(':recipient', $recipient_pattern, PDO::PARAM_STR);

    // 执行查询
    $stmt->execute();

    // 获取结果
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $results;
}

function manageIPAccess($ip)
{
    global $pdo;

    // 查询ip是否已存在于数据库中
    $stmt = $pdo->prepare("SELECT * FROM ips WHERE ip=:ip");
    $stmt->execute([':ip' => $ip]);
    $ipInfo = $stmt->fetch();

    if ($ipInfo) {
        // 检查是否在过去60秒内超过3次访问
        $t = time() - strtotime($ipInfo['time']);
        if ($t < 60 && $ipInfo['count'] > 3) {
            // 如果是，则返回false表示IP被禁止
            return $t;
        }

        // 更新计数器
        if ($ipInfo['count'] >= 3) { // 使用>=，因为在达到3次后，应该重置计数器
            $updateStmt = $pdo->prepare("UPDATE ips SET count=0, time=CURRENT_TIMESTAMP WHERE ip=:ip");
        } else {
            $updateStmt = $pdo->prepare("UPDATE ips SET count=count+1, time=CURRENT_TIMESTAMP WHERE ip=:ip");
        }

        // 执行更新
        $updateStmt->execute([':ip' => $ip]);

    } else {
        // 如果IP不存在，则插入新记录
        $insertStmt = $pdo->prepare("INSERT INTO ips (ip, count, time) VALUES (:ip, 1, CURRENT_TIMESTAMP)");
        $insertStmt->execute([':ip' => $ip]);
    }

    return false;
}

function getRealUserIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {   // 检查HTTP_CLIENT_IP是否存在
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  // 检查HTTP_X_FORWARDED_FOR是否存在
        // HTTP_X_FORWARDED_FOR可能包含多个IP地址，因此我们需要获取最前面的一个（最接近客户端的IP）
        $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $ip = trim($ips[0]);
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];  // 如果以上都不存在，使用REMOTE_ADDR
    }

    // 验证IP地址格式
    if (!filter_var($ip, FILTER_VALIDATE_IP)) {
        $ip = '0.0.0.0';  // 或者抛出异常/错误，根据你的需求
    }

    return $ip;
}