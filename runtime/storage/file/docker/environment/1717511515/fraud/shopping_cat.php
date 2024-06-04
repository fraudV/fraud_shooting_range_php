<?php
require_once './utils.php';

if (!$_COOKIE["user"] || !$_COOKIE["id"]){
    header("Location: /login.php");
    exit();
}

$page = $_GET['page']??0;
$limit = $_GET['limit']??0;
$page=(int)$page;
$limit=(int)$limit;
if ($page>0 && $limit>0){
    $data = get_shopping_cart_list($page,$limit);

    echo json_encode($data);
    return;
}
$operate = $_GET['operate']??0;
$id = $_GET['id']??0;
$operate=(int)$operate;
if ($operate>0&&$id>0){
    $u = false;
    switch ($operate){
        case 1:
            $u = update_shopping_cart($id,'+');
            $msg = '数量+1';
            break;
        case 2:
            $u = update_shopping_cart($id,'-');
            $msg = '数量-1';
            break;
        case 3:
            $u = delete_shopping_cart($id);
            $msg = '删除成功';
            break;
    }

    if ($u){
        echo json_encode([
            'code'=>0,
            'msg'=>$msg
        ]);
    }else{
        echo json_encode([
            'code'=>1,
            'msg'=>'操作失败'
        ]);
    }
    return;
}

if( $_SERVER['REQUEST_METHOD'] === 'POST'){
    $data = $_POST['data']??null;
    $id = $_COOKIE["id"];
    if ($data==null){
        echo json_encode(['code'=>1,'msg'=>'购物车为空']);
        return ;
    }
    $data_json = json_decode($data);
    $productIds = [];
    foreach ($data_json as $product) {
        $productIds[] = $product->id;
    }
    $shopping = shopping($productIds,$id);
    if ($shopping===false){
        echo json_encode([
            'code'=>1,
            'msg'=>'余额不足'
        ]);
    }else{
        echo json_encode([
            'code'=>0,
            'msg'=>'购买成功'.$shopping
        ]);

    }
    return;
}
?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <title>购物车</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/public/layui/css/layui.css" rel="stylesheet">
</head>
<body>

<div style="padding: 16px;">
    <table class="layui-hide" id="test" lay-filter="test"></table>
</div>
<script type="text/html" id="toolbarDemo">
    <button class="layui-btn layui-btn-sm" lay-event="shopping">购买选中的商品</button>
</script>
<script type="text/html" id="barDemo">
    <div class="layui-clear-space">
        <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="addition"><i class="layui-icon layui-icon-addition"></i> </a>
        <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="subtraction"><i class="layui-icon layui-icon-subtraction"></i> </a>
        <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="delete"><i class="layui-icon layui-icon-delete"></i> </a>
    </div>
</script>
<script src="/public/layui/layui.js"></script>
<script>
    layui.use(['table', 'dropdown'], function(){
        var table = layui.table;
        var $ = layui.$;

        // 创建渲染实例
        table.render({
            elem: '#test',
            url: '/shopping_cat.php', // 此处为静态模拟数据，实际使用时需换成真实接口
            toolbar: '#toolbarDemo',
            height: 'full-35', // 最大高度减去其他容器已占有的高度差
            cellMinWidth: 80,
            totalRow: true, // 开启合计行
            page: true,
            cols: [[
                {type: 'checkbox', fixed: 'left'},
                {field:'id', hide:true },
                {field:'name',  title: '商品',totalRowText: '合计：'},
                {field:'price',  title: '价格', sort: true,totalRow: '{{= d.TOTAL_ROW.era.sum }}'},
                {field:'quantity',  title: '总数', sort: true},
                {field:'sum',  title: '商品总价', sort: true},
                {fixed: 'right', title:'操作', width: 134, minWidth: 125, toolbar: '#barDemo'}
            ]],

            error: function(res, msg){
                console.log(res, msg)
            }
        });

        table.on('tool(test)', function(obj){
            var data = obj.data;
            var url = '';
            if(obj.event === 'addition'){
                url = 'shopping_cat.php?operate=1&id='+data.id;
            }else if(obj.event === 'subtraction') {
                url = 'shopping_cat.php?operate=2&id='+data.id;
            }else if(obj.event === 'delete') {
                url = 'shopping_cat.php?operate=3&id='+data.id;
            }
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    if (data.code==0){
                        layer.msg( data['msg']);
                        table.reloadData('test', {});
                    }else {
                        layer.msg( data['msg'] );
                    }
                },
                error: function (xhr, status, error) {
                    layer.msg('服务器异常',{icon: 2});
                }
            });
        })

        table.on('toolbar(test)', function(obj){
            var id = obj.config.id;
            var checkStatus = table.checkStatus(id);
            data={'data':JSON.stringify(checkStatus.data)};
            if(obj.event === 'shopping'){
                $.ajax({
                    url: 'shopping_cat.php',
                    type: 'POST',
                    dataType: 'json',
                    data:data,
                    success: function(data) {
                        if (data.code==0){
                            layer.msg( data['msg']);
                            table.reloadData('test', {});
                        }else {
                            layer.msg( data['msg'] );
                        }
                    },
                    error: function (xhr, status, error) {
                        layer.msg('服务器异常',{icon: 2});
                    }
                });
            }
        })
    });
</script>
</body>
</html>