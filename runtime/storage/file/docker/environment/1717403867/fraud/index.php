<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>外带数据</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="/public/layui/css/layui.css" rel="stylesheet">
</head>
<body>
<div class="layui-layout layui-layout-admin">
    <div class="layui-header">
        <div class="layui-logo layui-hide-xs layui-bg-black">fraud</div>
    </div>
    <div class="layui-side layui-bg-black">
        <div class="layui-side-scroll">
            <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
            <ul class="layui-nav layui-nav-tree" lay-filter="test">
                <li class="layui-nav-item"><a href="/home">首页</a></li>
                <li class="layui-nav-item ">
                    <a class="" href="javascript:;">设置</a>
                    <dl class="layui-nav-child">
                        <dd><a href="/home/network.php">网络检测</a></dd>
                    </dl>
                </li>
            </ul>
        </div>
    </div>
    <div class="layui-body">
        <!-- 内容主体区域 -->
        <iframe id="blockquote" src="/home"  frameborder="0" style="width: 100%; height: 100%; overflow-x: visible;"></iframe>
    </div>

</div>
<script src="/public/layui/layui.js"></script>
<script>

    layui.use(['element', 'layer', 'util'], function(){
        var layer = layui.layer;
        var util = layui.util;
        var $ = layui.$;

        $('a').on('click', function(e) {
            e.preventDefault(); // 阻止默认跳转行为
            var href = $(this).attr('href');
            $('#blockquote').attr('src', href);
        })
    })
</script>
</body>
</html>