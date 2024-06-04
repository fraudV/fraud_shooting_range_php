<?php
require_once './config/db.php';
function get_user($name)
{

    global $conn;
    $stmt = $conn->prepare("SELECT id,username,password FROM users WHERE username = ?");
    if ($stmt === false) {
        return false;
    }
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result!=null&&$result->num_rows > 0){
        return $result;
    }else{
        return false;
    }
}

function get_products_list($page,$limit)
{
    global $conn;
    $stmt = $conn->prepare("SELECT id, name, price FROM products");
    if ($stmt === false) {
        return false;
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $products = [];

    if ($result){
        while ($row = $result->fetch_assoc()) {
            $products[] = [
                'id'=>$row['id'],
                'name'=>$row['name'],
                'price'=>$row['price']
            ];
        }

        $data = [
            'code'=>0,
            'msg'=>'',
            'count'=>sizeof($products),
            'data'=>array_slice($products, ($page - 1) * $limit, $limit)
        ];
        return $data;
    }
    return false;
}

function get_shopping_cart_list($page,$limit)
{
    global $conn;
    $stmt = $conn->prepare("SELECT id,name, price, quantity FROM shopping_cart");
    if ($stmt === false) {
        return false;
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $shoppingCart = [];
    $sum = 0;
    if ($result){
        while ($row = $result->fetch_assoc()) {
            $sum+=$row['price']*$row['quantity'];
            $shoppingCart[] = [
                'id'=>$row['id'],
                'name'=>$row['name'],
                'price'=>$row['price'],
                'sum'=>$row['price']*$row['quantity'],
                'quantity'=>$row['quantity']
            ];
        }

        $data = [
            'code'=>0,
            'msg'=>'',
            'totalRow'=>['era'=>['sum'=>$sum]],
            'count'=>sizeof($shoppingCart),
            'data'=>array_slice($shoppingCart, ($page - 1) * $limit, $limit)
        ];
        return $data;
    }
    return false;
}

function inset_shopping_cart($name,$price,$quantity,$p_id)
{
    global $conn;
    // 判断是否在购物车
    $stmt = $conn->prepare("SELECT id, price, quantity FROM shopping_cart WHERE p_id = ?");
    if ($stmt === false) {
        return false;
    }
    $stmt->bind_param("i", $p_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result!=null&&$result->num_rows > 0){
        $stmt = $conn->prepare("UPDATE shopping_cart SET quantity = quantity + 1 WHERE p_id = ?");
        $stmt->bind_param("i", $p_id);
        if ($stmt->execute() === false) {
            return false;
        } else {
            return true;
        }
    }else{
        $stmt = $conn->prepare("INSERT INTO shopping_cart (name, price, quantity,p_id) VALUES ( ?, ?, ?, ?)");
        if ($stmt === false) {
            return false;
        }
        $stmt->bind_param("sdii", $name,$price,$quantity,$p_id);
        if ($stmt->execute() === false) {
            return false;
        } else {
            return true;
        }
    }
}

function update_shopping_cart($id,$operation)
{
    global $conn;
    $stmt = $conn->prepare("UPDATE shopping_cart SET quantity = quantity ".$operation." 1 WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute() === false) {
        return false;
    } else {
        return true;
    }
}

function delete_shopping_cart($id)
{
    global $conn;
    $stmt = $conn->prepare("DELETE FROM shopping_cart WHERE id = ?;");
    $stmt->bind_param("i", $id);
    if ($stmt->execute() === false) {
        return false;
    } else {
        return true;
    }
}

function shopping($productIds,$id)
{
    global $conn;
    $inClause = str_repeat('?,', count($productIds) - 1) . '?'; // 生成占位符字符串
    // 计算总价
    $sql = "SELECT id,name, price, quantity FROM shopping_cart WHERE id IN ($inClause);";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(str_repeat('i', count($productIds)), ...$productIds);

    $stmt->execute();
    $result = $stmt->get_result();
    $sum = 0;
    $f_flag=false;
    while ($row = $result->fetch_assoc()) {
        if ($row["name"]==='flag'){
            $f_flag = getenv('F_FLAG');
        }
        $sum+=$row["price"]*$row["quantity"];
    }


    $sql = "SELECT balance FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $balance = $row['balance']-$sum;
        if ($balance>=0){
            $stmt = $conn->prepare("UPDATE users SET balance = ? WHERE id = ?");
            $stmt->bind_param("ii", $balance,$id);
            if ($stmt->execute() === false) {
                return false;
            } else {
                foreach ($productIds as $productId ){
                    $stmt = $conn->prepare("DELETE FROM shopping_cart WHERE id = ?;");
                    $stmt->bind_param("i", $productId);
                    if ($stmt->execute() === false) {
                        return false;
                    }
                }
                return $f_flag;
            }

        }
    }

    return false;

}

function get_user_balance($id)
{
    global $conn;
    $sql = "SELECT balance FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        return $row['balance'];
    }
    return false;
}