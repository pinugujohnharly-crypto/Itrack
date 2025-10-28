<?php
header('Content-Type: application/json');
require_once '../database.php';
session_start();

// ✅ Optional: Allow only admin
if (!isset($_SESSION['role']) || strtolower($_SESSION['role']) !== 'admin') {
    echo json_encode(["ok" => false, "error" => "Unauthorized access"]);
    exit;
}

$limit = 10;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $limit;

// Count total files
$totalRes = $conn->query("SELECT COUNT(*) as cnt FROM uploaded_files");
$totalRow = $totalRes->fetch_assoc();
$total = (int)$totalRow['cnt'];
$totalPages = ceil($total / $limit);

// Fetch files
$stmt = $conn->prepare("SELECT id, filename, capstone_title, authors, year_published, uploaded_by, date_uploaded, approved, url 
                        FROM uploaded_files 
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
?>
