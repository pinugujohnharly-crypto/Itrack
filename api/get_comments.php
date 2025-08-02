<?php
include '../database.php';
header('Content-Type: application/json');

// Get file name from query string
$file = $_GET['file'] ?? '';
if (!$file) {
    echo json_encode([]);
    exit;
}

// Fetch all comments and replies for this file
$stmt = $conn->prepare("
    SELECT id, username, comment, created_at, parent_id
    FROM file_comments
    WHERE file = ?
    ORDER BY created_at ASC
");
$stmt->bind_param("s", $file);
$stmt->execute();
$result = $stmt->get_result();

$comments = [];
$commentMap = [];

// Build a map of all comments by ID
while ($row = $result->fetch_assoc()) {
    $row['replies'] = []; // Prepare replies array
    $commentMap[$row['id']] = $row;
}

// Organize comments into parent-child (nested replies)
foreach ($commentMap as $id => &$comment) {
    if ($comment['parent_id']) {
        $parentId = $comment['parent_id'];
        if (isset($commentMap[$parentId])) {
            $commentMap[$parentId]['replies'][] = &$comment;
        }
    } else {
        $comments[] = &$comment;
    }
}

echo json_encode($comments);
?>
