<?php
// api/list_my_notifications.php
session_start();
require_once '../database.php';
header('Content-Type: application/json');
require_once 'cors.php';
// Pick the SAME identity you inserted as notifications.user_key
$me = $_SESSION['username']
   ?? $_SESSION['name']
   ?? $_SESSION['email']
   ?? ($_SESSION['role'] ?? null);

if (!$me) {
  echo json_encode(['ok' => false, 'error' => 'No session']); exit;
}

$stmt = $conn->prepare("
  SELECT id, type, ref_id, title, body, status, created_at, read_at
  FROM notifications
  WHERE user_key = ?
  ORDER BY created_at DESC
  LIMIT 50
");
if (!$stmt) {
  echo json_encode(['ok'=>false, 'error'=>'Prepare failed']); exit;
}
$stmt->bind_param("s", $me);
$stmt->execute();
$res = $stmt->get_result();

$items = [];
while ($row = $res->fetch_assoc()) $items[] = $row;

echo json_encode(['ok' => true, 'items' => $items]);
