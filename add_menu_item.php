<?php
session_start();
require 'db.php';

// If the admin is not logged in, redirect to login page
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}

// Fetch all restaurants for selecting a restaurant
$sql = "SELECT * FROM restaurants";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$restaurants = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $restaurant_id = $_POST['restaurant_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Validate form inputs
    if (empty($restaurant_id) || empty($name) || empty($description) || empty($price)) {
        $error_message = "All fields are required.";
    } elseif (!is_numeric($price) || $price <= 0) {
        $error_message = "Price must be a positive number.";
    } else {
        // Insert new menu item into the database
        $sql = "INSERT INTO menu_items (restaurant_id, name, description, price) VALUES (:restaurant_id, :name, :description, :price)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':restaurant_id', $restaurant_id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->execute();

        // Redirect to manage menu page after adding the item
        header("Location: manage_menu.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Menu Item</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #007bff;
        }
        input[type="text"], input[type="number"], textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
        }
        .error {
            color: red;
            text-align: center;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add New Menu Item</h2>

        <!-- Display error message if validation fails -->
        <?php if (isset($error_message)): ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <form method="POST">
            <label for="restaurant_id">Select Restaurant:</label>
            <select name="restaurant_id" required>
                <option value="">Select Restaurant</option>
                <?php foreach ($restaurants as $restaurant): ?>
                    <option value="<?php echo $restaurant['id']; ?>"><?php echo htmlspecialchars($restaurant['name']); ?></option>
                <?php endforeach; ?>
            </select><br>

            <label for="name">Menu Item Name:</label>
            <input type="text" name="name" required><br>

            <label for="description">Description:</label>
            <textarea name="description" required></textarea><br>

            <label for="price">Price:</label>
            <input type="number" name="price" step="0.01" required><br>

            <button type="submit">Add Menu Item</button>
        </form>
    </div>
</body>
</html>
