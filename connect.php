<?php
$host = "localhost"; // XAMPP server
$user = "root"; // Default MySQL username in XAMPP
$password = ""; // No password for root user by default
$dbname = "coxyl"; // Your database name

// Create connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
