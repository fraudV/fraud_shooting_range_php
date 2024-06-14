<?php
require_once 'vendor/autoload.php';
require_once './utils.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

global $key;
$token = $_GET['token']??false;

if ($token){
    try {
        $decoded = JWT::decode($token, new Key($key, 'HS256'));
        echo activate_user($decoded->username).'，<a href="/login.php">请重新登录</a>';
        return;
    }catch (Firebase\JWT\SignatureInvalidException $ex){

    }

}

echo '参数异常';