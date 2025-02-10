<?php
session_start();
include '../api/config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: index.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM products WHERE id = :id");
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        header('Location: dashboard.php');
    } else {
        echo "Failed to delete product.";
    }
}
?>
