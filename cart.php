<?php
session_start();
require 'db.php';

// Add item to the cart
if (isset($_GET['item_id'])) {
    $item_id = $_GET['item_id'];
    $quantity = $_GET['quantity'] ?? 1;

    $sql = "SELECT * FROM menu_items WHERE id = :item_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':item_id', $item_id, PDO::PARAM_INT);
    $stmt->execute();
    $item = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($item) {
        // Add item to session cart
        $_SESSION['cart'][] = [
            'item_id' => $item['id'],
            'name' => $item['name'],
            'price' => $item['price'],
            'quantity' => $quantity
        ];
    }
}

// Calculate total price
$total = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $cart_item) {
        $total += $cart_item['price'] * $cart_item['quantity'];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cart</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f9;
        }
        .container {
            margin: 20px;
        }
        .cart-item {
            background: #fff;
            padding: 20px;
            margin: 10px 0;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .cart-item h3 {
            font-size: 20px;
        }
        .cart-item p {
            color: #555;
        }
        .cart-item .price {
            font-weight: bold;
        }
        .checkout {
            display: block;
            width: 100%;
            padding: 10px;
            background: #007bff;
            color: #fff;
            text-align: center;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Your Cart</h1>

        <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
            <?php foreach ($_SESSION['cart'] as $cart_item): ?>
                <div class="cart-item">
                    <h3><?php echo htmlspecialchars($cart_item['name']); ?></h3>
                    <p>Price: $<?php echo number_format($cart_item['price'], 2); ?></p>
                    <p>Quantity: <?php echo $cart_item['quantity']; ?></p>
                    <p class="price">Total: $<?php echo number_format($cart_item['price'] * $cart_item['quantity'], 2); ?></p>
                </div>
            <?php endforeach; ?>
            <h3>Total: $<?php echo number_format($total, 2); ?></h3>
            <a href="checkout.php" class="checkout">Proceed to Checkout</a>
        <?php else: ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>
    </div>
</body>
</html>
