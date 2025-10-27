<?php
$servername = "localhost";
$username = "u123456789_admin";  // default XAMPP username
$password = "12345";      // default XAMPP has no password
$database = "capstone_tracker"; // change to your real database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
