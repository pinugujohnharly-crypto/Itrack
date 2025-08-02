<?php
include '../database.php';

header('Content-Type: application/json');

$sql = "SELECT * FROM uploaded_files WHERE approved = 0 ORDER BY uploaded_at DESC";
$result = $conn->query($sql);

$files = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $files[] = $row;
    }
}

echo json_encode($files);
$conn->close();
