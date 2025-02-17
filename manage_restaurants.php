<?php
session_start();
require 'db.php';

// If the admin is not logged in, redirect to login page
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}

// Fetch all restaurants
$sql = "SELECT * FROM restaurants";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$restaurants = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle restaurant deletion
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql_delete = "DELETE FROM restaurants WHERE id = :id";
    $stmt_delete = $pdo->prepare($sql_delete);
    $stmt_delete->bindParam(':id', $delete_id, PDO::PARAM_INT);
    $stmt_delete->execute();
    header("Location: manage_restaurants.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Restaurants</title>
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
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #007bff;
            color: #fff;
        }
        .btn {
            padding: 10px;
            background-color: #28a745;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn-danger {
            padding: 10px;
            background-color: #dc3545;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>Manage Restaurants</h1>
    </div>
    <div class="container">
        <a href="add_restaurant.php" class="btn">Add New Restaurant</a>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($restaurants as $restaurant): ?>
                <tr>
                    <td><?php echo $restaurant['id']; ?></td>
                    <td><?php echo htmlspecialchars($restaurant['name']); ?></td>
                    <td><?php echo htmlspecialchars($restaurant['description']); ?></td>
                    <td>
                        <a href="edit_restaurant.php?id=<?php echo $restaurant['id']; ?>" class="btn">Edit</a>
                        <a href="?delete_id=<?php echo $restaurant['id']; ?>" class="btn-danger">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
