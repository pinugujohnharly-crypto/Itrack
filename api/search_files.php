<?php
require_once 'cors.php';
include '../database.php'; // adjust path if needed
header('Content-Type: application/json');

$q = trim($_GET['q'] ?? '');
if ($q === '') {
    echo json_encode([]);
    exit;
}

$stmt = $conn->prepare("SELECT * FROM uploaded_files 
                        WHERE capstone_title LIKE CONCAT('%', ?, '%') 
                        OR authors LIKE CONCAT('%', ?, '%') 
                        OR year_published LIKE CONCAT('%', ?, '%')");
$stmt->bind_param('sss', $q, $q, $q);
$stmt->execute();
$result = $stmt->get_result();

$files = $result->fetch_all(MYSQLI_ASSOC);
echo json_encode($files);
