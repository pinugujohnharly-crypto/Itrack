<?php
include '../database.php';

header('Content-Type: application/json');

$sql = "SELECT * FROM uploaded_files WHERE approved = 1 ORDER BY uploaded_at DESC";
$result = $conn->query($sql);

$files = [];

if ($result && $result->num_rows > 1) {
    while ($row = $result->fetch_assoc()) {
        $files[] = $row;
    }
}

echo json_encode($files);
$conn->close();
