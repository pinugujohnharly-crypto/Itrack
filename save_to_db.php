<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Send plain text so fetch(...).text() is readable
header('Content-Type: text/plain');

// Include your DB connection ($conn = new mysqli(...))
require_once __DIR__ . '/database.php';

// Read raw body and try JSON
$raw  = file_get_contents('php://input');
$data = json_decode($raw, true);
if (!is_array($data)) { $data = []; }

// Optional: log to inspect payloads while debugging
// file_put_contents(__DIR__ . "/debug_log.txt", "[".date('c')."] RAW: $raw\nPARSED: ".print_r($data,true)."\n", FILE_APPEND);

// Accept JSON or form POST as fallback
$filename       = $data['filename']       ?? ($_POST['filename']       ?? '');
$url            = $data['url']            ?? ($_POST['url']            ?? '');
$uploaded_by    = $data['uploaded_by']    ?? ($_POST['uploaded_by']    ?? '');
$capstone_title = $data['capstone_title'] ?? ($_POST['capstone_title'] ?? '');
$year_published = $data['year_published'] ?? ($_POST['year_published'] ?? '');
$authors        = $data['authors']        ?? ($_POST['authors']        ?? '');

// Basic validation
if ($filename === '' || $url === '' || $uploaded_by === '' || $capstone_title === '' || $year_published === '' || $authors === '') {
    http_response_code(400);
    echo "❌ Missing required data. Required: filename, url, uploaded_by, capstone_title, year_published, authors.";
    exit;
}

// Normalize year (keep only digits, typical 4-digit year)
$year_published = preg_replace('/\D+/', '', $year_published);
if (strlen($year_published) < 4) {
    http_response_code(400);
    echo "❌ Invalid year_published. Provide a 4-digit year.";
    exit;
}

// Prepare SQL (mysqli)
$sql = "INSERT INTO uploaded_files
        (filename, url, uploaded_by, capstone_title, year_published, authors, uploaded_at, approved)
        VALUES (?, ?, ?, ?, ?, ?, NOW(), 0)";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    http_response_code(500);
    echo "❌ SQL prepare error: " . $conn->error;
    exit;
}

if (!$stmt->bind_param("ssssss", $filename, $url, $uploaded_by, $capstone_title, $year_published, $authors)) {
    http_response_code(500);
    echo "❌ bind_param error: " . $stmt->error;
    $stmt->close();
    exit;
}

if (!$stmt->execute()) {
    http_response_code(500);
    echo "❌ Database execute error: " . $stmt->error;
    $stmt->close();
    exit;
}

// Cleanup
$stmt->close();
$conn->close();

echo "✅ Upload saved to database!";
