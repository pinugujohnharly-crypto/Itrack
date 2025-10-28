<?php
require_once '../database.php';
require_once 'cors.php';
session_start();

// Fetch 10 most recent approved files
$sql = "SELECT id, filename, capstone_title, date_uploaded, url
        FROM uploaded_files
        WHERE approved = 1
        ORDER BY date_uploaded DESC
        LIMIT 10";

$result = $conn->query($sql);
$files = [];

while ($row = $result->fetch_assoc()) {
    $files[] = $row;
}

echo json_encode(["ok" => true, "files" => $files]);
$conn->close();
