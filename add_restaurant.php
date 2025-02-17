<?php
session_start();
require 'db.php';

// If the admin is not logged in, redirect to login page
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];

    $sql = "INSERT INTO restaurants (name, description) VALUES (:name, :description)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':description', $description);
    $stmt->execute();

    header("Location: manage_restaurants.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Restaurant</title>
</head>
<body>
    <h1>Add New Restaurant</h1>
    <form method="POST">
        <label>Name:</label><br>
        <input type="text" name="name" required><br><br>
        <label>Description:</label><br>
        <textarea name="description" required></textarea><br><br>
        <button type="submit">Add Restaurant</button>
    </form>
</body>
</html>
