<?php
session_start();
require 'db.php';

// Get the order ID from the URL
$order_id = $_GET['order_id'];

// Fetch order details
$sql = "SELECT * FROM orders WHERE id = :order_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
$stmt->execute();
$order = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
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
        p {
            text-align: center;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Order Confirmation</h2>

        <p>Thank you for your order! Your order ID is: #<?php echo $order['id']; ?></p>
        <p>Your order is currently: <?php echo $order['status']; ?></p>
    </div>
</body>
</html>
