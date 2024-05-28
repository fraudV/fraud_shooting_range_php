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
    <title>枚举次数</title>
</head>
<body>
<h1>欢迎回来：<?php echo $user?></h1>
<?php
if ($user!='admin'){
    $f_flag = getenv('F_FLAG');
    echo $f_flag !== false ? $f_flag : '';
}

?>
</body>
</html>
