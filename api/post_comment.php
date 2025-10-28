<?php
// api/post_comment.php
require_once '../database.php';
require_once 'cors.php';
session_start();

header('Content-Type: application/json');
// ── 1) Only allow POST ────────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo json_encode(['success' => false, 'error' => 'POST required']);
  exit;
}

// ── 2) Accept JSON or form-encoded ────────────────────────────────────────────
$raw  = file_get_contents('php://input');
$data = json_decode($raw, true);
if (!$data) $data = $_POST;

// ── 3) Who is the logged-in user? (pick what your app actually sets) ─────────
$username = $_SESSION['username']
         ?? $_SESSION['name']
         ?? $_SESSION['email']
         ?? ($_SESSION['role'] ?? null);   // last resort

$file      = $data['file']    ?? null;
$comment   = $data['comment'] ?? null;
$parent_id = (isset($data['parent_id']) && is_numeric($data['parent_id']))
           ? (int)$data['parent_id'] : null;

if (!$username || !$file || !$comment) {
  http_response_code(400);
  echo json_encode(['success' => false, 'error' => 'Missing data (session/fields)']);
  exit;
}

// ── 4) Insert the comment ─────────────────────────────────────────────────────
if ($parent_id !== null) {
  $sql  = "INSERT INTO `file_comments`
           (`file`,`username`,`comment`,`parent_id`,`created_at`)
           VALUES (?,?,?,?,NOW())";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sssi", $file, $username, $comment, $parent_id);
} else {
  $sql  = "INSERT INTO `file_comments`
           (`file`,`username`,`comment`,`created_at`)
           VALUES (?,?,?,NOW())";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sss", $file, $username, $comment);
}

if (!$stmt || !$stmt->execute()) {
  http_response_code(500);
  echo json_encode([
    'success' => false,
    'error'   => 'Database error',
    'mysqli'  => $stmt ? $stmt->error : $conn->error
  ]);
  exit;
}

$newCommentId = $conn->insert_id;
$notified = false;

// ── 5) If this is a reply, notify the parent comment’s author ────────────────
if ($parent_id !== null) {
  // Look up parent to know who to notify
  $q = $conn->prepare("SELECT `username`, `file` FROM `file_comments` WHERE `id` = ? LIMIT 1");
  if ($q) {
    $q->bind_param("i", $parent_id);
    $q->execute();
    $parent = $q->get_result()->fetch_assoc();
    $q->close();

    if ($parent && !empty($parent['username']) && $parent['username'] !== $username) {
      $notifTitle = "New reply to your comment";
      // Keep "file: <name>" in body so the front-end can route back
      $notifBody  = $username . " replied on file: " . $parent['file'];

      // IMPORTANT: user_key must match what list_my_notifications.php uses
      $n = $conn->prepare("
        INSERT INTO `notifications`
          (`user_key`, `type`, `ref_id`, `title`, `body`, `status`, `created_at`)
        VALUES
          (?, 'comment', ?, ?, ?, 'sent', NOW())
      ");
      if ($n) {
        $n->bind_param("siss", $parent['username'], $newCommentId, $notifTitle, $notifBody);
        if ($n->execute()) $notified = true;
        $n->close();
      }
    }
  }
}

// ── 6) Done ──────────────────────────────────────────────────────────────────
echo json_encode([
  'success'     => true,
  'message'     => 'Comment saved',
  'comment_id'  => $newCommentId,
  'is_reply'    => ($parent_id !== null),
  'notif_sent'  => $notified
]);
