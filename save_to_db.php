
<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include your database connection
include 'database.php';

// Read and decode JSON input
$data = json_decode(file_get_contents("php://input"), true);

// Optional: Log incoming data for debugging
file_put_contents("debug_log.txt", print_r($data, true));

// Validate data
$filename = $data['filename'] ?? '';
$url = $data['url'] ?? '';
$uploaded_by = $data['uploaded_by'] ?? '';
$capstone_title = $data['capstone_title'] ?? '';

if (!$filename || !$url || !$uploaded_by || !$capstone_title) {
    http_response_code(400);
    echo "❌ Missing required data.";
    exit;
}

// Prepare SQL statement with approval flag
$stmt = $conn->prepare("INSERT INTO uploaded_files (filename, url, uploaded_by, capstone_title, uploaded_at, approved) VALUES (?, ?, ?, ?, NOW(), 0)");

if (!$stmt) {
    http_response_code(500);
    echo "❌ SQL error: " . $conn->error;
    exit;
}

// Bind and execute
$stmt->bind_param("ssss", $filename, $url, $uploaded_by, $capstone_title);

if ($stmt->execute()) {
    echo "✅ Upload saved to database!";
} else {
    http_response_code(500);
    echo "❌ Database error: " . $stmt->error;
}

// Cleanup
$stmt->close();
$conn->close();
