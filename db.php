<?php
// Database configuration
$host = "localhost";
$user = "root";
$password = "";
$database = "bloodbank";  // Use the actual DB name you created

// Create connection
$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("<div style='color: red; font-weight: bold;'>Database Connection Failed: " . $conn->connect_error . "</div>");
}

// Optional: Set character encoding
$conn->set_charset("utf8");
?>

