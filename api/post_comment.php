<?php
session_start();
require_once '../database.php';
header('Content-Type: application/json');

// Only allow POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo json_encode(['success' => false, 'error' => 'POST required']);
  exit;
}

// Accept JSON or form
$raw  = file_get_contents('php://input');
$data = json_decode($raw, true);
if (!$data) $data = $_POST;

// Pull a usable identity from session (adjust keys if needed)
$username = $_SESSION['username']
         ?? $_SESSION['name']
         ?? $_SESSION['email']
         ?? ($_SESSION['role'] ?? null); // last resort

$file     = $data['file']    ?? null;
$comment  = $data['comment'] ?? null;
$parent_id = isset($data['parent_id']) && is_numeric($data['parent_id']) ? (int)$data['parent_id'] : null;

if (!$username || !$file || !$comment) {
  http_response_code(400);
  echo json_encode(['success' => false, 'error' => 'Missing data (session/fields)']);
  exit;
}

// Insert (uses created_at; adjust to your schema)
if ($parent_id !== null) {
  $sql = "INSERT INTO `file_comments` (`file`,`username`,`comment`,`parent_id`,`created_at`)
          VALUES (?,?,?,?,NOW())";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sssi", $file, $username, $comment, $parent_id);
} else {
  $sql = "INSERT INTO `file_comments` (`file`,`username`,`comment`,`created_at`)
          VALUES (?,?,?,NOW())";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sss", $file, $username, $comment);
}

if (!$stmt || !$stmt->execute()) {
  http_response_code(500);
  echo json_encode(['success' => false, 'error' => 'Database error', 'mysqli' => $stmt ? $stmt->error : $conn->error]);
  exit;
}

$newId = $conn->insert_id;

// (Optional notification code here...)

echo json_encode([
  'success'     => true,
  'message'     => 'Comment saved',
  'comment_id'  => $newId,
  'is_reply'    => $parent_id !== null
]);
