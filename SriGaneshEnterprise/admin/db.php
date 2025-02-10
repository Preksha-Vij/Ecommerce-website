// db.php
<?php
$servername = "localhost";  // Change if your server is different
$username = "admin";
$password = "password123";
$dbname = "sriganeshenterprise";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully"; 
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
