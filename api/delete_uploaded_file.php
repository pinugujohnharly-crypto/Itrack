<?php
header('Content-Type: application/json');
require_once '../database.php';
session_start();

// ✅ Optional: Only admin can delete
if (!isset($_SESSION['role']) || strtolower($_SESSION['role']) !== 'admin') {
    echo json_encode(["ok" => false, "error" => "Unauthorized access"]);
    exit;
}

if (!isset($_POST['id'])) {
    echo json_encode(["ok" => false, "error" => "Missing file ID"]);
    exit;
}

$id = intval($_POST['id']);

// Fetch file to delete physical file
$result = $conn->query("SELECT url FROM uploaded_files WHERE id = $id");
if ($result->num_rows === 0) {
    echo json_encode(["ok" => false, "error" => "File not found"]);
    exit;
}

$file = $result->fetch_assoc();
$filePath = "../uploads/" . basename($file['url']); // adjust path if different

if (file_exists($filePath)) {
    unlink($filePath);
}

// Delete from DB
$conn->query("DELETE FROM uploaded_files WHERE id = $id");

echo json_encode(["ok" => true, "message" => "File deleted successfully"]);
?>
