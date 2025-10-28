<?php
require_once 'cors.php';
session_start();
header('Content-Type: application/json');
require_once '../database.php';

$user_key = $_SESSION['user_key'] 
         ?? $_SESSION['username']   // ✅ fallback to username
         ?? null;

if (!$user_key) {
  echo json_encode(['ok'=>false,'error'=>'Not logged in']); exit;
}


$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
if ($id <= 0) { echo json_encode(['ok'=>false,'error'=>'Missing id']); exit; }

$sql = "DELETE FROM notifications WHERE id=? AND user_key=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('is', $id, $user_key);
$stmt->execute();
$affected = $stmt->affected_rows;
$stmt->close();

echo json_encode(['ok' => $affected > 0, 'deleted' => $affected]);
$conn->close();
