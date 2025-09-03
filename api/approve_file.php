<?php
// api/approve_file.php
session_start();
header('Content-Type: application/json');

require_once '../database.php'; // $conn (mysqli)

// (Optional) simple admin check
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'contributor')) {
  echo json_encode(['ok' => false, 'error' => 'Unauthorized']);
  exit;
}

$file_id = isset($_POST['file_id']) ? (int)$_POST['file_id'] : 0;
if ($file_id <= 0) {
  echo json_encode(['ok' => false, 'error' => 'Missing file_id']);
  exit;
}

// 1) Fetch the file (must be pending)
$sql = "SELECT id, filename, uploaded_by, capstone_title, url
        FROM uploaded_files
        WHERE id = ? AND approved = 0
        LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $file_id);
$stmt->execute();
$file = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$file) {
  echo json_encode(['ok' => false, 'error' => 'File not found or not pending']);
  exit;
}

// 2) Approve (only if still pending)
$sql = "UPDATE uploaded_files
        SET approved = 1
        WHERE id = ? AND approved = 0";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $file_id);
$stmt->execute();
$affected = $stmt->affected_rows;
$stmt->close();

if ($affected <= 0) {
  echo json_encode(['ok' => false, 'error' => 'Approve failed (already processed?)']);
  exit;
}

// 3) Insert a notification to the uploader (best-effort)
$title = 'Your PDF upload was approved';
$lines = [];
$lines[] = 'File: ' . ($file['filename'] ?? '');
if (!empty($file['capstone_title'])) $lines[] = 'Capstone: ' . $file['capstone_title'];
$body = implode("\n", $lines);

if (!empty($file['uploaded_by'])) {
  $sql = "INSERT INTO notifications (user_key, title, body, status, created_at)
          VALUES (?, ?, ?, 'sent', NOW())";
  if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param('sss', $file['uploaded_by'], $title, $body);
    $stmt->execute();
    $stmt->close();
  }
}

// 4) Done
echo json_encode(['ok' => true]);
$conn->close();
