<?php
session_start();
include '../database.php';
header('Content-Type: application/json');

// Debugging (optional during development)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Read and decode the incoming JSON request
$data = json_decode(file_get_contents('php://input'), true);

// Validate required fields
if (!isset($_SESSION['username'], $data['file'], $data['comment'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing data']);
    exit;
}

$file = $data['file'];
$username = $_SESSION['username'];
$comment = $data['comment'];

// Check if it's a reply (has parent_id) or a top-level comment
if (isset($data['parent_id']) && is_numeric($data['parent_id'])) {
    $parent_id = intval($data['parent_id']);
    $stmt = $conn->prepare("INSERT INTO file_comments (file, username, comment, parent_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $file, $username, $comment, $parent_id);
} else {
    // Top-level comment (no parent)
    $stmt = $conn->prepare("INSERT INTO file_comments (file, username, comment) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $file, $username, $comment);
}

// Execute and respond
if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Comment saved']);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Database error', 'details' => $stmt->error]);
}
?>
