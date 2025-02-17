<?php
require 'db.php';
$sql = "SELECT * FROM restaurants";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$restaurants = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Available Restaurants</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f9;
        }
        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            margin: 20px;
        }
        .restaurant {
            background: #fff;
            padding: 20px;
            margin: 10px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 250px;
        }
        .restaurant img {
            width: 100%;
            border-radius: 10px;
        }
        .restaurant h3 {
            text-align: center;
            font-size: 20px;
            margin-top: 10px;
        }
        .restaurant p {
            text-align: center;
            color: #555;
        }
        .btn {
            display: block;
            width: 100%;
            padding: 10px;
            background: #007bff;
            color: #fff;
            text-align: center;
            border-radius: 5px;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php foreach ($restaurants as $restaurant): ?>
            <div class="restaurant">
                <img src="images/restaurant-building.png" style="width:100px;height:50px;padding-left:50px;" alt="Restaurant Image">
                <h3><?php echo htmlspecialchars($restaurant['name']); ?></h3>
                <p><?php echo htmlspecialchars($restaurant['description']); ?></p>
                <a href="menu.php?restaurant_id=<?php echo $restaurant['id']; ?>" class="btn">View Menu</a>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
