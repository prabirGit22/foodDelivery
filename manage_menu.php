<?php
session_start();
require 'db.php';

// If the admin is not logged in, redirect to login page
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}

// Fetch all menu items
$sql = "SELECT * FROM menu_items";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$menu_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle menu item deletion
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql_delete = "DELETE FROM menu_items WHERE id = :id";
    $stmt_delete = $pdo->prepare($sql_delete);
    $stmt_delete->bindParam(':id', $delete_id, PDO::PARAM_INT);
    $stmt_delete->execute();
    header("Location: manage_menu.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Menu Items</title>
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
        .card {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card a {
            display: block;
            text-decoration: none;
            color: #fff;
            background-color: #007bff;
            padding: 10px;
            border-radius: 5px;
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>Manage Menu Items</h1>
    </div>

    <div class="container">
        <div class="card">
            <a href="add_menu_item.php">Add New Menu Item</a>
        </div>

        <table>
            <tr>
                <th>ID</th>
                <th>Restaurant ID</th>
                <th>Item Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>

            <?php foreach ($menu_items as $menu_item): ?>
                <tr>
                    <td><?php echo $menu_item['id']; ?></td>
                    <td><?php echo $menu_item['restaurant_id']; ?></td>
                    <td><?php echo htmlspecialchars($menu_item['name']); ?></td>
                    <td><?php echo htmlspecialchars($menu_item['description']); ?></td>
                    <td><?php echo $menu_item['price']; ?></td>
                    <td>
                        <a href="edit_menu_item.php?id=<?php echo $menu_item['id']; ?>" class="btn">Edit</a>
                        <a href="?delete_id=<?php echo $menu_item['id']; ?>" class="btn-danger">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
