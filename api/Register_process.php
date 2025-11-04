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
    echo "
    <html>
    <head>
      <meta http-equiv='refresh' content='2;url=../Homescreen.php'>
      <style>
        body {
          background: #f9fafc;
          font-family: Arial, sans-serif;
          display: flex;
          justify-content: center;
          align-items: center;
          height: 100vh;
          color: #333;
        }
        .message-box {
          background: #fff;
          padding: 30px 40px;
          border-radius: 10px;
          box-shadow: 0 4px 10px rgba(0,0,0,0.1);
          text-align: center;
        }
        .message-box h2 {
          color: #007bff;
          margin-bottom: 10px;
        }
        .message-box p {
          font-size: 14px;
          color: #555;
        }
      </style>
    </head>
    <body>
      <div class='message-box'>
        <h2>Registration Successful!</h2>
        <p>Redirecting to home page...</p>
      </div>
    </body>
    </html>
    ";
    exit;
} else {
    echo "Registration failed. Please try again later.";
}


    // Clean up
    $stmt->close();
    $check->close();
    $conn->close();
}
?>
