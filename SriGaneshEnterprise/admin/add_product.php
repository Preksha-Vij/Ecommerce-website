<?php
session_start();
include '../api/config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $image_url = 'uploads/' . basename($_FILES['image']['name']);

    if (move_uploaded_file($_FILES['image']['tmp_name'], '../' . $image_url)) {
        $stmt = $conn->prepare("INSERT INTO products (name, description, category, price, image_url) VALUES (:name, :description, :category, :price, :image_url)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':image_url', $image_url);

        if ($stmt->execute()) {
            header('Location: dashboard.php');
        } else {
            $error = "Failed to add product.";
        }
    } else {
        $error = "Failed to upload image.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <h1>Add New Product</h1>
    <form method="POST" action="add_product.php" enctype="multipart/form-data">
        <label for="name">Product Name:</label>
        <input type="text" id="name" name="name" required><br>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea><br>

        <label for="category">Category:</label>
        <input type="text" id="category" name="category" required><br>

        <label for="price">Price:</label>
        <input type="number" id="price" name="price" required><br>

        <label for="image">Product Image:</label>
        <input type="file" id="image" name="image" required><br>

        <button type="submit">Add Product</button>
    </form>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
</body>
</html>
