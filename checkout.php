<?php
session_start();
require 'db.php';

// If the user is not logged in, redirect to login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Place the order
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $order_total = $_POST['total'];
    $status = 'Pending';

    // Insert order into database
    $sql_order = "INSERT INTO orders (user_id, total, status) VALUES (:user_id, :total, :status)";
    $stmt_order = $pdo->prepare($sql_order);
    $stmt_order->bindParam(':user_id', $user_id);
    $stmt_order->bindParam(':total', $order_total);
    $stmt_order->bindParam(':status', $status);
    $stmt_order->execute();
    $order_id = $pdo->lastInsertId();

    // Insert order items into database
    foreach ($_SESSION['cart'] as $cart_item) {
        $sql_item = "INSERT INTO order_items (order_id, item_id, quantity, price) VALUES (:order_id, :item_id, :quantity, :price)";
        $stmt_item = $pdo->prepare($sql_item);
        $stmt_item->bindParam(':order_id', $order_id);
        $stmt_item->bindParam(':item_id', $cart_item['item_id']);
        $stmt_item->bindParam(':quantity', $cart_item['quantity']);
        $stmt_item->bindParam(':price', $cart_item['price']);
        $stmt_item->execute();
    }

    // Clear cart
    unset($_SESSION['cart']);

    echo "Order placed successfully! Your order ID is: $order_id";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
</head>
<body>
    <h1>Checkout</h1>
    <form method="POST">
        <h3>Total: $<?php echo number_format($_POST['total'], 2); ?></h3>
        <button type="submit">Place Order</button>
    </form>
</body>
</html>
