<?php
include 'api/config.php';

// Check if the product ID is passed in the URL
$productId = $_GET['id'] ?? null;

if (!$productId) {
    die("Error: Product ID is missing.");
}

// Fetch product details
$stmt = $conn->prepare("SELECT * FROM products WHERE id = :id");
$stmt->bindParam(':id', $productId, PDO::PARAM_INT);
$stmt->execute();
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die("Error: Product not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['name']); ?></title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <header>
        <h1><?php echo htmlspecialchars($product['name']); ?></h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="products.php">All Products</a>
        </nav>
    </header>

    <main>
        <div class="product-detail">
            <img src="<?php echo $product['image_url']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-image">
            <h2><?php echo htmlspecialchars($product['name']); ?></h2>
            <p><?php echo htmlspecialchars($product['description']); ?></p>
            <p>Price: ₹<?php echo htmlspecialchars($product['price']); ?></p>
            <a href="cart.php?action=add&id=<?php echo $product['id']; ?>" class="btn">Add to Cart</a>
            <a href="products.php" class="btn">Back to Products</a>
        </div>
    </main>
</body>
</html>
