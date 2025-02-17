<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        .navbar {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            text-align: center;
        }
        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin: 20px;
        }
        .card {
            background: #fff;
            padding: 20px;
            margin: 10px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 250px;
            text-align: center;
        }
        .card a {
            display: block;
            text-decoration: none;
            color: #fff;
            background-color: #007bff;
            padding: 10px;
            border-radius: 5px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>Admin Dashboard</h1>
    </div>
    <div class="container">
        <div class="card">
            <h2>Manage Restaurants</h2>
            <a href="manage_restaurants.php">View and Add Restaurants</a>
        </div>
        <div class="card">
            <h2>Manage Menu Items</h2>
            <a href="manage_menu.php">View and Add Menu Items</a>
        </div>
        <div class="card">
            <h2>View Orders</h2>
            <a href="view_orders.php">Manage Orders</a>
        </div>
    </div>
</body>
</html>
