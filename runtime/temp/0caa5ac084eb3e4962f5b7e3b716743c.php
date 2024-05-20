<?php /*a:1:{s:68:"/www/admin/fraud_80/wwwroot/fraud_shooting_range_php/view/index.html";i:1716207676;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>首页</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/static/layui/css/layui.css" rel="stylesheet">
</head>
<body>
<div class="layui-layout layui-layout-admin">
    <div class="layui-header">
        <div class="layui-logo layui-hide-xs layui-bg-black">fraud_web_靶场</div>
        <!-- 头部区域（可配合layui 已有的水平导航） -->


    </div>
    <div class="layui-side layui-bg-black">
        <div class="layui-side-scroll">
            <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
            <ul class="layui-nav layui-nav-tree" lay-filter="test" >
                <?php
                function tree($menus){
                  foreach ($menus as $menu){
                        echo '<dl class="layui-nav-child">';
                        if(count($menu->menus)!=0){
                            echo '<dd><a href="#">'.$menu->name.'</a>';
                            tree($menu->menus);
                            echo '</dd>';
                        }else{
                            echo '<dd><a href="'.$menu->to.'?id='.$menu->envId.'" lay-menu-event="menu">'.$menu->name.'</a></dd>';
                        }
                        echo '</dl>';
                    }
                }


                foreach ($menu_nodes as $menu){
                    echo '<li class="layui-nav-item"><a class="" href="#"> '.$menu->name.'</a>';
                    tree($menu->menus);
                    echo '</li>';
}
                ?>
            </ul>
        </div>
    </div>
    <div class="layui-body">
        <!-- 内容主体区域 -->
        <iframe id="blockquote" src=""  frameborder="0" style="width: 100%; height: 100%; overflow-x: visible;"></iframe>
    </div>
    <div class="layui-footer">
        <!-- 底部固定区域 -->
        <button type="button" class="layui-btn layui-btn-primary" lay-on="answer">答案</button>

    </div>
</div>

<script src="/static/layui/layui.js"></script>
<script>
    //JS
    layui.use(['element', 'layer', 'util'], function(){
        var element = layui.element;
        var layer = layui.layer;
        var util = layui.util;
        var $ = layui.$;

        //头部事件
        util.event('lay-header-event', {
            menuLeft: function(othis){ // 左侧菜单事件
                layer.msg('展开左侧菜单的操作', {icon: 0});
            },
            menuRight: function(){  // 右侧菜单事件
                layer.open({
                    type: 1,
                    title: '更多',
                    content: '<div style="padding: 15px;">处理右侧面板的操作</div>',
                    area: ['260px', '100%'],
                    offset: 'rt', // 右上角
                    anim: 'slideLeft', // 从右侧抽屉滑出
                    shadeClose: true,
                    scrollbar: false
                });
            }
        });

        $('a').on('click', function(e) {
            e.preventDefault(); // 阻止默认跳转行为
            var href = $(this).attr('href');
            if (!href || href === '#') {

            } else {
                $('#blockquote').attr('src', href);
                $.ajax({
                    url:  $('#blockquote').attr('src'), // 替换为你的 API 端点
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        'answer':true
                    },
                    success: function(response) {

                        if (response.code===0){

                        }

                    },
                    error: function(xhr, status, error) {
                        // 错误回调
                        console.log('Error:', error);
                    }
                })
            }
        });

        util.on('lay-on', {
            'answer':function (){
                layer.confirm('确认不在想想了？', {icon: 3}, function(){
                    $.ajax({
                        url:  $('#blockquote').attr('src'), // 替换为你的 API 端点
                        type: 'GET',
                        dataType: 'json',
                        data: {
                            'answer':true
                        },
                        success: function(response) {
                            if (response.code===0){
                                window.open(response.msg)
                            }else {
                                console.log('答案地址异常');
                            }
                        },
                        error: function(xhr, status, error) {
                            // 错误回调
                            console.log('答案地址异常');
                        }
                    })

                }, function(){
                    layer.msg('加油');
                });
            }

        })
    });
</script>
</body>
</html>