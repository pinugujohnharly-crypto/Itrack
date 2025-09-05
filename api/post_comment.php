<?php
session_start();
include '../database.php';
header('Content-Type: application/json');

// Debugging (optional during development)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Read and decode the incoming JSON request
$data = json_decode(file_get_contents('php://input'), true);

// Validate required fields
if (!isset($_SESSION['username'], $data['file'], $data['comment'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Missing data']);
    exit;
}

$file     = $data['file'];
$username = $_SESSION['username'];
$comment  = $data['comment'];

// Insert comment (reply vs top-level)
if (isset($data['parent_id']) && is_numeric($data['parent_id'])) {
    $parent_id = (int)$data['parent_id'];
    $stmt = $conn->prepare(
        "INSERT INTO file_comments (file, username, comment, parent_id)
         VALUES (?, ?, ?, ?)"
    );
    $stmt->bind_param("sssi", $file, $username, $comment, $parent_id);
} else {
    $stmt = $conn->prepare(
        "INSERT INTO file_comments (file, username, comment)
         VALUES (?, ?, ?)"
    );
    $stmt->bind_param("sss", $file, $username, $comment);
}

if (!$stmt) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'DB prepare failed']);
    exit;
}

if (!$stmt->execute()) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Database error', 'details' => $stmt->error]);
    $stmt->close();
    exit;
}

$newCommentId = $conn->insert_id;  // link notifications.ref_id to this reply (when applicable)
$stmt->close();

// === Reply notification ===
// If this is a reply, notify the parent comment’s author (but not yourself)
$notified = false;
if (isset($parent_id)) {
    $q = $conn->prepare("SELECT username, file FROM file_comments WHERE id = ? LIMIT 1");
    if ($q) {
        $q->bind_param("i", $parent_id);
        $q->execute();
        $parent = $q->get_result()->fetch_assoc();
        $q->close();

        if ($parent && !empty($parent['username']) && $parent['username'] !== $username) {
            // Title/body shown in the bell
            $notifTitle = "New reply to your comment";
            $notifBody  = $username . " replied on file: " . $parent['file'];

            // Insert as a comment-type notification linked to this new reply
            // NOTE: notifications.user_key should store the same identifier as your login session for that user (here: username)
            $n = $conn->prepare(
                "INSERT INTO notifications (user_key, type, ref_id, title, body, status, created_at)
                 VALUES (?, 'comment', ?, ?, ?, 'sent', NOW())"
            );
            if ($n) {
                $n->bind_param("siss", $parent['username'], $newCommentId, $notifTitle, $notifBody);
                if ($n->execute()) $notified = true;
                $n->close();
            }
        }
    }
}

// Done
echo json_encode([
    'success'      => true,
    'message'      => 'Comment saved',
    'comment_id'   => $newCommentId,
    'is_reply'     => isset($parent_id),
    'notif_sent'   => $notified
]);
