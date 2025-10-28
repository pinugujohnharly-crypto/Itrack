<?php
include '../database.php';
require_once 'cors.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = trim($_POST['first_name']);
    $last_name  = trim($_POST['last_name']);
    $username   = trim($_POST['username']);
    $password   = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role       = "contributor";

    // Check if username exists
    $check = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $check->bind_param("s", $username);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        echo "⚠️ Username already exists. Please choose another.";
    } else {
        // Insert contributor into database
        $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, username, password_hash, role) 
                                VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $first_name, $last_name, $username, $password, $role);

        if ($stmt->execute()) {
            echo "✅ Contributor registration successful.";
        } else {
            echo "❌ Registration failed.";
        }
    }
}
?>
