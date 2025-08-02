<?php
include '../database.php';

$file_id = $_POST['file_id'] ?? null;

if (!$file_id) {
    http_response_code(400);
    echo "Missing file ID.";
    exit;
}

$stmt = $conn->prepare("UPDATE uploaded_files SET approved = 1 WHERE id = ?");
$stmt->bind_param("i", $file_id);

if ($stmt->execute()) {
    echo "✅ File approved.";
} else {
    http_response_code(500);
    echo "❌ Approval failed.";
}

$stmt->close();
$conn->close();
?>
