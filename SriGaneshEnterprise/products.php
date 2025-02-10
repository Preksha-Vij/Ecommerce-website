<?php
include 'api/config.php';

// Get category filter from URL
$category = $_GET['category'] ?? null;

// Fetch products
try {
    if ($category) {
        $stmt = $conn->prepare("SELECT * FROM products WHERE category = :category");
        $stmt->bindParam(':category', $category, PDO::PARAM_STR);
    } else {
        $stmt = $conn->prepare("SELECT * FROM products");
    }
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die("Error fetching products: " . $e->getMessage());
}

// Debugging: Uncomment to inspect data
// echo "<pre>";
// print_r($products);
// echo "</pre>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Products</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <header>
        <h1>Our Products</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="products.php">All Products</a>
            <a href="products.php?category=Mobile Accessories">Mobile Accessories</a>
            <a href="products.php?category=Stationery">Stationery</a>
        </nav>
    </header>

    <main>
        <h2><?php echo $category ? htmlspecialchars($category) : 'All Products'; ?></h2>
        <div class="product-grid">
            <?php if (empty($products)): ?>
                <p>No products available in this category.</p>
            <?php else: ?>
                <?php foreach ($products as $product): ?>
                    <div class="product-item">
                        <img src="<?php echo $product['image_url']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                        <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                        <p><?php echo htmlspecialchars($product['description']); ?></p>
                        <p>₹<?php echo htmlspecialchars($product['price']); ?></p>
                        <a href="product.php?id=<?php echo $product['id']; ?>">View Details</a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
