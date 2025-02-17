<?php
require 'db.php';

$restaurant_id = $_GET['restaurant_id'] ?? null;
if (!$restaurant_id) {
    die("Restaurant not found.");
}

$sql = "SELECT * FROM menu_items WHERE restaurant_id = :restaurant_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':restaurant_id', $restaurant_id, PDO::PARAM_INT);
$stmt->execute();
$menu_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql_restaurant = "SELECT * FROM restaurants WHERE id = :restaurant_id";
$stmt_restaurant = $pdo->prepare($sql_restaurant);
$stmt_restaurant->bindParam(':restaurant_id', $restaurant_id, PDO::PARAM_INT);
$stmt_restaurant->execute();
$restaurant = $stmt_restaurant->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Menu - <?php echo htmlspecialchars($restaurant['name']); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f9;
        }
        .container {
            margin: 20px;
        }
        .menu-item {
            background: #fff;
            padding: 20px;
            margin: 10px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .menu-item img {
            width: 100%;
            border-radius: 10px;
        }
        .menu-item h3 {
            font-size: 20px;
            margin-top: 10px;
        }
        .menu-item p {
            color: #555;
        }
        .price {
            font-size: 18px;
            font-weight: bold;
        }
        .btn {
            display: block;
            width: 100%;
            padding: 10px;
            background: #28a745;
            color: #fff;
            text-align: center;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Menu - <?php echo htmlspecialchars($restaurant['name']); ?></h1>
        <?php foreach ($menu_items as $item): ?>
            <div class="menu-item">
                <img src="https://via.placeholder.com/250" alt="Food Image">
                <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                <p><?php echo htmlspecialchars($item['description']); ?></p>
                <span class="price">$<?php echo number_format($item['price'], 2); ?></span>
                <a href="cart.php?item_id=<?php echo $item['id']; ?>" class="btn">Add to Cart</a>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
