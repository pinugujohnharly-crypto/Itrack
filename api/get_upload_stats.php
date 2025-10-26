<?php
require_once '../database.php';

$type = $_GET['type'] ?? 'daily';
$validTypes = ['daily', 'weekly', 'monthly', 'yearly'];
if (!in_array($type, $validTypes)) $type = 'daily';

switch ($type) {
    case 'weekly':
        $group = "YEARWEEK(date_uploaded)";
        $label = "CONCAT('Week ', WEEK(date_uploaded), ' ', YEAR(date_uploaded))";
        break;
    case 'monthly':
        $group = "DATE_FORMAT(date_uploaded, '%Y-%m')";
        $label = "DATE_FORMAT(date_uploaded, '%b %Y')";
        break;
    case 'yearly':
        $group = "YEAR(date_uploaded)";
        $label = "YEAR(date_uploaded)";
        break;
    default:
        $group = "DATE(date_uploaded)";
        $label = "DATE_FORMAT(date_uploaded, '%b %d')";
        break;
}

$sql = "
    SELECT 
        $label AS label,
        COUNT(*) AS total_uploaded
    FROM uploaded_files
    GROUP BY $group
    ORDER BY MIN(date_uploaded) ASC
";

$result = $conn->query($sql);
$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = [
        "label" => $row["label"],
        "uploaded" => (int)$row["total_uploaded"]
    ];
}

echo json_encode(["ok" => true, "data" => $data]);
