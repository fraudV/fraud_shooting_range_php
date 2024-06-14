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