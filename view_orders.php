<?php
session_start();
require 'db.php';

// If the admin is not logged in, redirect to login page
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}

// Fetch all orders
$sql = "SELECT * FROM orders";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle order status update
if (isset($_GET['update_status']) && isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    $status = $_GET['update_status'];

    $sql_update = "UPDATE orders SET status = :status WHERE id = :order_id";
    $stmt_update = $pdo->prepare($sql_update);
    $stmt_update->bindParam(':status', $status);
    $stmt_update->bindParam(':order_id', $order_id, PDO::PARAM_INT);
    $stmt_update->execute();

    header("Location: view_orders.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Orders</title>
</head>
<body>
    <h1>Manage Orders</h1>
    <table border="1">
        <tr>
            <th>Order ID</th>
            <th>User ID</th>
            <th>Total</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($orders as $order): ?>
            <tr>
                <td><?php echo $order['id']; ?></td>
                <td><?php echo $order['user_id']; ?></td>
                <td><?php echo $order['total']; ?></td>
                <td><?php echo $order['status']; ?></td>
                <td>
                    <a href="?update_status=Pending&order_id=<?php echo $order['id']; ?>">Set as Pending</a>
                    <a href="?update_status=Completed&order_id=<?php echo $order['id']; ?>">Set as Completed</a>
                    <a href="?update_status=Canceled&order_id=<?php echo $order['id']; ?>">Set as Canceled</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
