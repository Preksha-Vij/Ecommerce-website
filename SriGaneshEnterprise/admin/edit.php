<?php

session_start();
include 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: login.php');
    exit;
}

// Initialize variables
$product = null;
$error = null;

// Retrieve product information if the ID is set
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    try {
        $stmt = $conn->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$product) {
            $error = "No product found with ID: $id";
        }
    } catch (PDOException $e) {
        $error = "Error retrieving product: " . $e->getMessage();
    }
}

// Update product information if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    try {
        $stmt = $conn->prepare("UPDATE products SET name = :name, price = :price, description = :description WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':price', $price, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);

        if ($stmt->execute()) {
            echo "Product updated successfully";
        } else {
            $error = "Error updating product";
        }
    } catch (PDOException $e) {
        $error = "Error updating product: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <h2>Edit Product</h2>
    <?php if ($error): ?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if ($product): ?>
        <form action="edit.php" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($product['id']); ?>">
            <label for="name">Product Name:</label>
            <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($product['name']); ?>" required><br><br>
            <label for="price">Product Price:</label>
            <input type="text" name="price" id="price" value="<?php echo htmlspecialchars($product['price']); ?>" required><br><br>
            <label for="description">Product Description:</label>
            <textarea name="description" id="description" required><?php echo htmlspecialchars($product['description']); ?></textarea><br><br>
            <button type="submit">Update Product</button>
        </form>
    <?php else: ?>
        <p>No product selected for editing.</p>
    <?php endif; ?>
</body>
</html>
