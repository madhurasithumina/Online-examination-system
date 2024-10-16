<?php
// Database Configuration

$host = "localhost";
$db_name = "online_examination_system";
$username = "root"; // Default username, change if required
$password = "";     // Default password for MySQL, change if necessary

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    // Set error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}
?>
 