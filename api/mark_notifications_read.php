<?php
// api/mark_notification_read.php  (mark ONE notification as read)
require_once 'cors.php';
session_start();
require_once '../database.php';
header('Content-Type: application/json');
$user_key = $_SESSION['user_key'] 
         ?? $_SESSION['username']   // ✅ fallback to username
         ?? null;

if (!$user_key) {
  echo json_encode(['ok'=>false,'error'=>'Not logged in']); exit;
}


$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
if ($id <= 0) { echo json_encode(['ok'=>false,'error'=>'Missing id']); exit; }

$sql = "UPDATE notifications
        SET read_at = NOW()
        WHERE id = ? AND user_key = ? AND status = 'sent' AND read_at IS NULL";
$stmt = $conn->prepare($sql);
$stmt->bind_param('is', $id, $user_key);
$stmt->execute();
$affected = $stmt->affected_rows;
$stmt->close();

echo json_encode(['ok' => $affected > 0, 'marked' => $affected]);
$conn->close();
