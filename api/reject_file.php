<?php
// api/reject_file.php (MySQLi version)
session_start();
header('Content-Type: application/json');
require_once 'cors.php';
// Use the SAME include you use in approve_file.php:
require_once '../database.php';   // must provide $conn (mysqli)

// Optional: simple admin check (remove if you don't use roles)
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'contributor')) {
  echo json_encode(['ok' => false, 'error' => 'Unauthorized']);
  exit;
}

$fileId = isset($_POST['file_id']) ? (int)$_POST['file_id'] : 0;
$reason = isset($_POST['reason']) ? trim($_POST['reason']) : '';

if ($fileId <= 0) {
  echo json_encode(['ok' => false, 'error' => 'Missing file_id']);
  exit;
}

// 1) Fetch the file (must still be pending: approved = 0)
$sql = "SELECT id, filename, uploaded_by, capstone_title, url
        FROM uploaded_files
        WHERE id = ? AND approved = 0
        LIMIT 1";
if (!$stmt = $conn->prepare($sql)) {
  echo json_encode(['ok' => false, 'error' => 'DB prepare failed (select)']);
  exit;
}
$stmt->bind_param('i', $fileId);
$stmt->execute();
$file = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$file) {
  echo json_encode(['ok' => false, 'error' => 'File not found or not pending']);
  exit;
}

// 2) Mark rejected (approved = 2) + audit fields
$sql = "UPDATE uploaded_files
        SET approved = 2,
            rejection_reason = ?,
            reviewed_at = NOW(),
            reviewed_by = ?
        WHERE id = ? AND approved = 0";
if (!$stmt = $conn->prepare($sql)) {
  echo json_encode(['ok' => false, 'error' => 'DB prepare failed (update)']);
  exit;
}
$reviewer = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : null;
$stmt->bind_param('sii', $reason, $reviewer, $fileId);
$stmt->execute();
$affected = $stmt->affected_rows;
$stmt->close();

if ($affected <= 0) {
  echo json_encode(['ok' => false, 'error' => 'Reject failed (already processed?)']);
  exit;
}

/* 3) Fallback auto-revoke (NO schema change required)
   - Find the latest 'sent' notification for this uploader that references the filename
   - Mark it revoked with your reject reason (fills revoke_reason + revoked_at)
   NOTE: requires columns revoke_reason and revoked_at to exist in `notifications`. */
$revokeReason = ($reason !== '') ? $reason : 'File was rejected';

// 3a) Find latest matching 'sent' notification
$sql = "SELECT id
        FROM notifications
        WHERE user_key = ?
          AND status   = 'sent'
          AND body     LIKE CONCAT('%', ?, '%')
        ORDER BY created_at DESC
        LIMIT 1";
if ($stmt = $conn->prepare($sql)) {
  $filename = $file['filename'] ?? '';
  $stmt->bind_param('ss', $file['uploaded_by'], $filename);
  $stmt->execute();
  $found = $stmt->get_result()->fetch_assoc();
  $stmt->close();

  // 3b) Revoke it if found
  if ($found && !empty($found['id'])) {
    $nid = (int)$found['id'];
    $sql = "UPDATE notifications
            SET status='revoked',
                revoke_reason=?,
                revoked_at=NOW()
            WHERE id=? AND status='sent'";
    if ($stmt = $conn->prepare($sql)) {
      $stmt->bind_param('si', $revokeReason, $nid);
      $stmt->execute();
      $stmt->close();
    }
  }
}

// 4) Insert a notification for the uploader (best effort)
// (If you want reason ONLY in revoke_reason and NOT in the new body, remove the line that adds Reason below.)
if (!empty($file['uploaded_by'])) {
  $title = 'Your PDF upload was rejected';
  $parts = ['File: ' . ($file['filename'] ?? '')];
  if (!empty($file['capstone_title'])) $parts[] = 'Capstone: ' . $file['capstone_title'];
  if ($reason !== '') $parts[] = 'Reason: ' . $reason; // <- remove this line if you don't want reason in body
  $body = implode("\n", $parts);

  $sql = "INSERT INTO notifications (user_key, title, body, status, created_at)
          VALUES (?, ?, ?, 'sent', NOW())";
  if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param('sss', $file['uploaded_by'], $title, $body);
    $stmt->execute();
    $stmt->close();
  }
}

echo json_encode(['ok' => true]);
$conn->close();
