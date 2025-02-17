<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_id = $_POST['order_id'];

    // Fetch order details from database
    $sql = "SELECT * FROM orders WHERE id = :order_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
    $stmt->execute();
    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($order) {
        echo "<h3>Order ID: " . $order['id'] . "</h3>";
        echo "<p>Status: " . $order['status'] . "</p>";

        // Fetch order items
        $sql_items = "SELECT * FROM order_items WHERE order_id = :order_id";
        $stmt_items = $pdo->prepare($sql_items);
        $stmt_items->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $stmt_items->execute();
        $order_items = $stmt_items->fetchAll(PDO::FETCH_ASSOC);

        echo "<h4>Order Items:</h4><ul>";
        foreach ($order_items as $item) {
            echo "<li>" . $item['quantity'] . " x " . $item['name'] . " - $" . number_format($item['price'], 2) . "</li>";
        }
        echo "</ul>";
    } else {
        echo "Order not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Track Order</title>
</head>
<body>
    <h1>Track Your Order</h1>
    <form method="POST">
        <input type="number" name="order_id" placeholder="Enter Order ID" required>
        <button type="submit">Track</button>
    </form>
</body>
</html>
