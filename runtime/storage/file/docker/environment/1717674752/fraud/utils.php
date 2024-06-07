<?php
require_once './config/db.php';
function get_user($username)
{

    global $pdo;
    $stmt = $pdo->prepare('SELECT id, username, password FROM users WHERE username = :username');
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();
    if ($user) {
        return $user;
    } else {
        return false;
    }

}

function get_products_list($page,$limit)
{
    global $pdo;
    $sql = "SELECT id, name, price FROM products";
    $stmt = $pdo->query($sql);
    $products = [];
    while ($row = $stmt->fetch()) {
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

function get_shopping_cart_list($page, $limit)
{
    global $pdo;

    $offset = ($page - 1) * $limit;

    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM shopping_cart");
    $stmt->execute();
    $totalRows = $stmt->fetchColumn();

    $stmt = $pdo->prepare("SELECT id, name, price, quantity FROM shopping_cart LIMIT :offset, :limit");
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();

    $shoppingCart = [];
    $sum = 0;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $sum += $row['price'] * $row['quantity'];
        $shoppingCart[] = [
            'id' => $row['id'],
            'name' => $row['name'],
            'price' => $row['price'],
            'sum' => $row['price'] * $row['quantity'],
            'quantity' => $row['quantity']
        ];
    }

    $data = [
        'code' => 0,
        'msg' => '',
        'totalRow' => ['era' => ['sum' => $sum]],
        'count' => $totalRows,
        'data' => array_slice($shoppingCart, 0, $limit)
    ];

    return $data;
}

function insert_shopping_cart($quantity, $p_id)
{
    global $pdo;

    try {
        // 开始事务
        $pdo->beginTransaction();

        // 获取产品信息
        $stmt = $pdo->prepare('SELECT id, name, price FROM products WHERE id = :id');
        $stmt->execute(['id' => $p_id]);
        $product = $stmt->fetch();

        if ($product) {
            // 检查购物车中是否已有此产品
            $stmt = $pdo->prepare('SELECT id, price, quantity FROM shopping_cart WHERE p_id = :p_id');
            $stmt->execute(['p_id' => $p_id]);
            $shopping_cart = $stmt->fetch();

            if ($shopping_cart) {
                // 如果已有此产品，更新数量
                $stmt = $pdo->prepare('UPDATE shopping_cart SET quantity = quantity + :quantity WHERE p_id = :p_id');
                $stmt->execute(['quantity' => $quantity, 'p_id' => $p_id]);
            } else {
                // 如果没有此产品，插入新记录
                $stmt = $pdo->prepare('INSERT INTO shopping_cart (name, price, quantity, p_id) VALUES (:name, :price, :quantity, :p_id)');
                $stmt->execute(['name' => $product['name'], 'price' => $product['price'], 'quantity' => $quantity, 'p_id' => $p_id]);
            }

            // 提交事务
            $pdo->commit();
            return true;
        }
    } catch (PDOException $e) {
        // 如果发生错误，回滚事务
        $pdo->rollBack();
        return false;
    }
}

function update_shopping_cart($id, $operation)
{
    global $pdo;

    if ($operation == '+') {
        $sql = "UPDATE shopping_cart SET quantity = quantity + 1 WHERE id = ?";
    } else if ($operation == '-') {
        $sql = "UPDATE shopping_cart SET quantity = quantity - 1 WHERE id = ? AND quantity > 1";
    } else {
        return false;
    }

    $stmt = $pdo->prepare($sql);

    if ($stmt === false) {
        return false;
    }

    $stmt->execute([$id]);

    if ($stmt->rowCount() > 0) {
        return true;
    } else {
        return false;
    }
}

function delete_shopping_cart($id)
{
    global $pdo;

    $stmt = $pdo->prepare("DELETE FROM shopping_cart WHERE id = :id");

    try {
        $stmt->execute([':id' => $id]);
        return true;
    } catch (PDOException $e) {
        return false;
    }
}

function shopping($productIds, $id)
{
    global $pdo;

    $pdo->beginTransaction(); // 开始事务

    try {

        $inClause = str_repeat('?,', count($productIds) - 1) . '?';

        // 计算总价
        $sql = "SELECT id, name, price, quantity FROM shopping_cart WHERE id IN ($inClause)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($productIds);

        $sum = 0;
        $f_flag = false;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($row["name"] == 'flag') {
                $f_flag = getenv('F_FLAG');
            }
            $sum += $row["price"] * $row["quantity"];
        }


        // 检查用户余额
        $sql = "SELECT balance FROM users WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $balance = $row['balance'] - $sum;

        if ($balance >= 0 && $balance<=$row['balance']) {
            // 更新用户余额
            $stmt = $pdo->prepare("UPDATE users SET balance = ? WHERE id = ?");
            $stmt->execute([$balance, $id]);

            // 清空购物车
            foreach ($productIds as $productId) {
                $stmt = $pdo->prepare("DELETE FROM shopping_cart WHERE id = ?");
                $stmt->execute([$productId]);
            }

            $pdo->commit(); // 提交事务
            return $f_flag;
        }

    } catch (PDOException $e) {
        $pdo->rollBack(); // 如果出现异常，回滚事务
        return false;
    }

    $pdo->rollBack(); // 如果余额不足，也回滚事务
    return false;
}

function get_user_balance($id)
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT balance FROM users WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $user = $stmt->fetch();
    if ($user) {
        return $user['balance'];
    } else {
        return false;
    }
}