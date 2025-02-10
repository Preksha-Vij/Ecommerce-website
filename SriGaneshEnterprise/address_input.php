<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $payment_method = $_POST['payment_method'];
    $_SESSION['payment_method'] = $payment_method;

    if ($payment_method === 'card') {
        $_SESSION['card_number'] = $_POST['card_number'];
        $_SESSION['expiry_date'] = $_POST['expiry_date'];
        $_SESSION['cvv'] = $_POST['cvv'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Address Input</title>
  <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
  <h2>Enter Your Address</h2>
  <form action="mock_payment.php" method="POST">
    <label for="address">Address</label>
    <textarea id="address" name="address" required></textarea><br><br>

    <button type="submit">Submit Order</button>
  </form>
</body>
</html>
