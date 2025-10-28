<?php
session_start();
require_once 'cors.php';

require_once '../database.php';
// Number of files per page
$limit = 10;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $limit;

// Count total files (only approved ones)
$totalRes = $conn->query("SELECT COUNT(*) as cnt FROM uploaded_files WHERE approved = 1");
$totalRow = $totalRes->fetch_assoc();
$total = (int)$totalRow['cnt'];
$totalPages = ceil($total / $limit);

// Fetch files for this page
$stmt = $conn->prepare("SELECT id, filename, capstone_title, authors, year_published, uploaded_by, date_uploaded, url 
                        FROM uploaded_files 
                        WHERE approved = 1 
                        ORDER BY date_uploaded DESC 
                        LIMIT ? OFFSET ?");
$stmt->bind_param("ii", $limit, $offset);
$stmt->execute();
$result = $stmt->get_result();

$files = [];
while ($row = $result->fetch_assoc()) {
    $files[] = $row;
}

echo json_encode([
    "ok" => true,
    "files" => $files,
    "totalPages" => $totalPages
]);
