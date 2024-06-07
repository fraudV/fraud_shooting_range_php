<?php
require_once './utils.php';

if (!$_COOKIE["user"]|| !$_COOKIE["id"]){
    header("Location: /login.php");
    exit();
}

$page = $_GET['page']??0;
$limit = $_GET['limit']??0;
$page=(int)$page;
$limit=(int)$limit;
if ($page>0 && $limit>0){
    $data = get_products_list($page,$limit);
    echo json_encode($data);
    return;
}

if( $_SERVER['REQUEST_METHOD'] === 'POST'){
    $id = $_POST['id']??0;
    $name = $_POST['name']??'';
    $num = $_POST['num']??0;
    $insert = insert_shopping_cart($num,$id);
    if ($insert){
        echo json_encode([
                'code'=>0,
            'msg'=>$name.' 添加成功'
        ]);
    }else{
        echo json_encode([
            'code'=>1,
            'msg'=>$name.' 添加失败'
        ]);
    }
    return;
}
$controls = $_GET['controls']??0;
$controls=(int)$controls;
switch ($controls){
    case 1:
        $balance = get_user_balance($_COOKIE["id"]);
        if ($balance===false){

            echo json_encode([
                'code'=>1,
                'msg'=>'余额查询失败'
            ]);
        }else{
            echo json_encode([
                'code'=>0,
                'msg'=>'余额：'.$balance
            ]);
        }
        return;
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>高级逻辑漏洞</title>
    <!-- 请勿在项目正式环境中引用该 layui.css 地址 -->
    <link href="/public/layui/css/layui.css" rel="stylesheet">
</head>
<body>

<div class="layui-layout layui-layout-admin">
    <div class="layui-header">
        <div class="layui-logo layui-hide-xs layui-bg-black">首页</div>

        <ul class="layui-nav layui-layout-right">
            <li class="layui-nav-item layui-hide layui-show-sm-inline-block">
                <a href="javascript:;">
                    <img src="//unpkg.com/outeres@0.0.10/img/layui/icon-v2.png" class="layui-nav-img">
                    <?php echo $_COOKIE['user'] ?>
                </a>
                <dl class="layui-nav-child">
                    <dd><a href="javascript:;" lay-on="balance">余额查询</a></dd>
                </dl>
            </li>
            <li class="layui-nav-item" lay-header-event="menuRight" lay-unselect>
                <a href="javascript:;">
                    <i class="layui-icon layui-icon-more-vertical"></i>
                </a>
            </li>
        </ul>
    </div>
    <div class="layui-side layui-bg-black">
        <div class="layui-side-scroll">
            <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
            <ul class="layui-nav layui-nav-tree" lay-filter="test">
                <li class="layui-nav-item layui-nav-itemed">
                    <a class="" href="javascript:;">商店</a>
                </li>

            </ul>
        </div>
    </div>
    <div class="layui-body">
        <!-- 内容主体区域 -->
        <div style="padding: 15px;">
            <div class="layui-btn-group">
                <button type="button" class="layui-btn layui-btn-primary" lay-on="shopping-cat"><i class="layui-icon layui-icon-cart"></i></button>
            </div>

            <table class="layui-table" lay-data="{height:'full', url:'/index.php', page:true}" id="ID-table-demo-init">
                <thead>
                <tr>
                    <th lay-data="{field:'name'}">商品</th>
                    <th lay-data="{field:'price',sort: true}">价格</th>
                    <th lay-data="{fixed: 'right', width: 160, align: 'center', toolbar: '#templet-demo-theads-tool'}" rowspan="2">操作</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>

</div>


<script type="text/html" id="templet-demo-theads-tool">
    <div class="layui-clear-space">
        <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="add">加入购物车</a>
    </div>
</script>

<script src="/public/layui/layui.js"></script>
<!-- 请勿在项目正式环境中引用该 layui.js 地址 -->
<script>
    layui.use(function() {
        var layer = layui.layer;
        var util = layui.util;
        var $ = layui.$;
        var table = layui.table;
        util.on('lay-on', {
            'shopping-cat': function(){
                // 页面层
                layer.open({
                    type: 2,
                    title :'购物车',
                    area: ['100%', '100%'], // 宽高
                    content: './shopping_cat.php'
                });
            },
            'balance':function (){
                $.ajax({
                    url: 'index.php?controls=1',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        layer.alert(data.msg);
                    },
                    error: function (xhr, status, error) {
                        layer.msg(data.msg);
                    }
                });
            }
        })

        table.on('tool(ID-table-demo-init)', function(obj){
            var data = obj.data;
            data['num']=1;
            if(obj.event === 'add'){
                $.ajax({
                    url: '/index.php',
                    type: 'POST',
                    data:data,
                    dataType: 'json',
                    success: function(data) {
                        layer.msg(data['msg']);
                    },
                    error: function (xhr, status, error) {
                        layer.msg(data.name+'加入购物车失败');
                    }
                });
            }
        })
    })

</script>
</body>
</html>