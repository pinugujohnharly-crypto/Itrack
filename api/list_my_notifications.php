<?php
session_start();
header('Content-Type: application/json');
require_once '../database.php';

$user_key = $_SESSION['user_key'] 
         ?? $_SESSION['username']   // ✅ fallback to username
         ?? null;

if (!$user_key) {
  echo json_encode(['ok'=>false,'error'=>'Not logged in']); exit;
}


$sql = "SELECT id, title, body, status, created_at, revoked_at, revoke_reason, read_at
        FROM notifications
        WHERE user_key = ?
        ORDER BY created_at DESC
        LIMIT 50";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $user_key);
$stmt->execute();
$res = $stmt->get_result();

$items = [];
while ($row = $res->fetch_assoc()) $items[] = $row;
$stmt->close();

echo json_encode(['ok'=>true, 'items'=>$items]);
$conn->close();
