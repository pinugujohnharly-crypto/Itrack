<?php
require_once 'cors.php';
require_once __DIR__ . '/../database.php';

if (($_SERVER["REQUEST_METHOD"] ?? '') === "POST") {
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $rawPassword = $_POST['password'] ?? '';

    if ($first_name === '' || $last_name === '' || $username === '' || $rawPassword === '') {
        echo "All fields are required.";
        exit;
    }

    $password = password_hash($rawPassword, PASSWORD_DEFAULT);
    $role = "contributor";

    // Check if username exists.
    $check = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $check->bind_param("s", $username);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        echo "Username already exists. Please choose another.";
    } else {
        $stmt = $conn->prepare("
            INSERT INTO users (first_name, last_name, username, password_hash, role)
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->bind_param("sssss", $first_name, $last_name, $username, $password, $role);

        if ($stmt->execute()) {
            echo "Contributor registration successful.";
        } else {
            echo "Registration failed.";
        }

        $stmt->close();
    }

    $check->close();
    $conn->close();
}
?>
