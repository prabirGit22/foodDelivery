<?php
session_start();
require 'db.php';

// If the user is not logged in, redirect to login page
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Handle order tracking
$order_status = null;

if (isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];

    // Fetch the order details
    $sql = "SELECT * FROM orders WHERE id = :order_id AND user_id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt->execute();
    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($order) {
        $order_status = $order['status']; // Get the order status
    } else {
        $error_message = "Order not found or you're not authorized to view this order.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Tracking</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #007bff;
        }
        .status {
            font-size: 18px;
            font-weight: bold;
            color: #28a745;
            text-align: center;
        }
        .error {
            color: red;
            text-align: center;
        }
        .input-group {
            margin-bottom: 15px;
        }
        input[type="text"] {
            padding: 10px;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            width: 100%;
            border-radius: 5px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Track Your Order</h2>

        <?php if (isset($error_message)): ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="input-group">
                <label for="order_id">Enter Order ID:</label>
                <input type="text" name="order_id" required>
            </div>
            <button type="submit">Track Order</button>
        </form>

        <?php if ($order_status !== null): ?>
            <div class="status">
                <p>Your order status is: <?php echo htmlspecialchars($order_status); ?></p>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>
