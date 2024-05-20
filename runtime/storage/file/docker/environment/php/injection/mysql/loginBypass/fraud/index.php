<?php
if(!isset($_COOKIE['user'])) {
    header("Location: /login.php");
}
$user = $_COOKIE['user'];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>登录绕过</title>
</head>
<body>
<h1>欢迎回来：<?php echo $user?></h1>
<?php
$f_flag = getenv('F_FLAG');
echo $f_flag !== false ? $f_flag : '';
?>
</body>
</html>
