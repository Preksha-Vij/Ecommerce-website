<?php
session_start();
include 'api/config.php';

// Initialize cart
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add product to cart
if ($_GET['action'] === 'add' && isset($_GET['id'])) {
    $productId = $_GET['id'];
    $_SESSION['cart'][$productId] = ($_SESSION['cart'][$productId] ?? 0) + 1;
}

// Remove product from cart
if ($_GET['action'] === 'remove' && isset($_GET['id'])) {
    $productId = $_GET['id'];
    unset($_SESSION['cart'][$productId]);
}

// Fetch cart products
$cartItems = [];
if (!empty($_SESSION['cart'])) {
    $ids = implode(',', array_keys($_SESSION['cart']));
    $stmt = $conn->prepare("SELECT * FROM products WHERE id IN ($ids)");
    $stmt->execute();
    $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <h1>Your Cart</h1>
    <table>
        <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Subtotal</th>
            <th>Action</th>
        </tr>
        <?php $total = 0; ?>
        <?php foreach ($cartItems as $item): ?>
            <?php
            $quantity = $_SESSION['cart'][$item['id']];
            $subtotal = $quantity * $item['price'];
            $total += $subtotal;
            ?>
            <tr>
                <td><?php echo htmlspecialchars($item['name']); ?></td>
                <td>₹<?php echo htmlspecialchars($item['price']); ?></td>
                <td><?php echo $quantity; ?></td>
                <td>₹<?php echo $subtotal; ?></td>
                <td><a href="cart.php?action=remove&id=<?php echo $item['id']; ?>">Remove</a></td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="3">Total</td>
            <td colspan="2">₹<?php echo $total; ?></td>
        </tr>
    </table>
    <a href="checkout.php">Proceed to Checkout</a>
    <a href="index.php">Continue Shopping</a>
</body>
</html>
