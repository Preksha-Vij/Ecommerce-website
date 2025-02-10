<?php
session_start();
include '../api/config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: index.php');
    exit();
}

// Fetch all products
$stmt = $conn->prepare("SELECT * FROM products");
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <h1>Admin Dashboard</h1>
    <a href="add_product.php">Add New Product</a>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($products as $product): ?>
        <tr>
            <td><?php echo $product['id']; ?></td>
            <td><?php echo $product['name']; ?></td>
            <td><?php echo $product['category']; ?></td>
            <td>₹<?php echo $product['price']; ?></td>
            <td>
                <a href="edit_product.php?id=<?php echo $product['id']; ?>">Edit</a>
                <a href="delete_product.php?id=<?php echo $product['id']; ?>">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
