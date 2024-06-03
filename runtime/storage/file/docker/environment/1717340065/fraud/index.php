<?php
$file = $_GET['file'] ?? null;

if ($file){
    $path = dirname(__FILE__).$file;
    $path = str_replace("../", "", $path);

    $file_content = '';
    $fp = @fopen($path, 'r');
    if (!$fp) {
        $file_content = '图片不存在';
    }else{
        while (false !== ($char = fgetc($fp))) {
            $file_content .= "$char";
        }
    }

    echo  $file_content;
    return;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>文件目录遍历过滤字符串</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/public/layui/css/layui.css" rel="stylesheet">
</head>
<body>
<div class="layui-layout layui-layout-admin">
    <div class="layui-header">
        <div class="layui-logo layui-hide-xs layui-bg-black">fraud</div>

        <ul class="layui-nav layui-layout-right">
            <li class="layui-nav-item layui-hide layui-show-sm-inline-block">
                <a href="javascript:;">
                    <img src="?file=/public/img/icon-v2.png" class="layui-nav-img"/>
                    fraud
                </a>

            </li>
            <li class="layui-nav-item" lay-header-event="menuRight" lay-unselect>
                <a href="javascript:;">
                    <i class="layui-icon layui-icon-more-vertical"></i>
                </a>
            </li>
        </ul>
    </div>
    <div class="layui-side layui-bg-black">

    </div>
    <div class="layui-body">
        <!-- 内容主体区域 -->
        <div style="padding: 15px;">
            <blockquote class="layui-elem-quote layui-text">
                欢迎光临
            </blockquote>
            读取/etc/passwd文件
            <br><br>
        </div>
    </div>

</div>

</body>
</html>