<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Checkout</title>
  <link rel="stylesheet" type="text/css" href="css/styles.css">
  <script>
    function togglePaymentFields() {
      var paymentMethod = document.getElementById("payment_method").value;
      var cardFields = document.getElementById("card_fields");
      var qrCode = document.getElementById("qr_code");

      if (paymentMethod === "card") {
        cardFields.style.display = "block";
        qrCode.style.display = "none";
      } else if (paymentMethod === "upi") {
        cardFields.style.display = "none";
        qrCode.style.display = "block";
      } else {
        cardFields.style.display = "none";
        qrCode.style.display = "none";
      }
    }
  </script>
</head>
<body>
  <h2>Checkout</h2>
  <form action="address_input.php" method="POST">
    <label for="payment_method">Payment Method</label>
    <select id="payment_method" name="payment_method" onchange="togglePaymentFields()">
      <option value="card">Card</option>
      <option value="upi">UPI</option>
      <option value="cod">Cash on Delivery</option>
    </select><br><br>

    <div id="card_fields" style="display: block;">
      <label for="card_number">Card Number</label>
      <input type="text" id="card_number" name="card_number"><br><br>
      <label for="expiry_date">Expiry Date</label>
      <input type="text" id="expiry_date" name="expiry_date"><br><br>
      <label for="cvv">CVV</label>
      <input type="text" id="cvv" name="cvv"><br><br>
    </div>

    <div id="qr_code" style="display: none;">
      <p>Scan the QR code to pay using UPI:</p>
      <img src="uploads/upi_qr.png" alt="UPI QR Code" style="width: 200px; height: auto;">
    </div>

    <button type="submit">Proceed to Address</button>
  </form>
</body>
</html>
