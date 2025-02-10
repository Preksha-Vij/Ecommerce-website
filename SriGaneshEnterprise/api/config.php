<?php
$host = 'localhost';
$db = 'SriGaneshEnterprise'; // Your database name
$user = 'root';              // Database username
$pass = '';                  // Database password (leave blank for XAMPP default)

try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
