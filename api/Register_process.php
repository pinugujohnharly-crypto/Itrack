<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../database.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize inputs
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name  = trim($_POST['last_name'] ?? '');
    $username   = trim($_POST['username'] ?? '');
    $password   = $_POST['password'] ?? '';
    $role       = $_POST['role'] ?? 'user';

    // Basic input validation
    if (empty($first_name) || empty($last_name) || empty($username) || empty($password)) {
        echo "All fields are required.";
        exit();
    }

    // Hash the password securely
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if username already exists
    $check = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $check->bind_param("s", $username);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        echo "Username already exists. Please choose another.";
        exit();
    }

    // Insert new user into the database
    
    $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, username, password_hash, role) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $first_name, $last_name, $username, $hashed_password, $role);

    if ($stmt->execute()) {
        echo "Registration successful. <a href='../Homescreen.php'>Click here to login</a>";
    } else {
        echo "Registration failed. Please try again later.";
    }

    // Clean up
    $stmt->close();
    $check->close();
    $conn->close();
}
?>
