<?php
session_start();
include 'db.php'; // Ensure this includes your database connection

$payment_method = $_SESSION['payment_method'];
$address = $_POST['address'];

if ($payment_method) {
    if ($payment_method === 'card') {
        // Simulate card payment processing
        $card_number = $_SESSION['card_number'];
        $expiry_date = $_SESSION['expiry_date'];
        $cvv = $_SESSION['cvv'];
        // Add validation and processing logic here
        $is_payment_successful = true; // Simulate success
    } elseif ($payment_method === 'upi') {
        // Simulate UPI payment processing
        // No validation for the dummy UPI
        $is_payment_successful = true; // Simulate success
    } elseif ($payment_method === 'cod') {
        // Cash on Delivery does not require immediate payment processing
        $is_payment_successful = true; // Simulate success
    } else {
        $is_payment_successful = false; // Invalid payment method
    }

    if ($is_payment_successful) {
        // Save order details to the database with the payment method and address
        $order_total = 500.00; // Example total, replace with actual calculation
        $query = "INSERT INTO orders (total_amount, payment_method, address) VALUES ('$order_total', '$payment_method', '$address')";
        if (mysqli_query($conn, $query)) {
            $_SESSION['payment_status'] = 'Payment successful!';
            // Redirect to success page
            header("Location: payment_success.php");
            exit();
        } else {
            // Debugging: Print error message
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        $_SESSION['payment_status'] = 'Payment failed. Please try again.';
        // Redirect back to checkout page
        header("Location: checkout.php");
        exit();
    }
} else {
    echo "No payment method selected.";
}
?>
