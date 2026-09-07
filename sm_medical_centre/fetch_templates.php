<?php
include 'db.php';

$type = $_POST['type'];

if ($type === 'test') {
    $query = "SELECT test_id as id, test_name as name FROM lab_tests ORDER BY test_name";
} elseif ($type === 'package') {
    $query = "SELECT package_id as id, package_name as name FROM test_packages ORDER BY package_name";
} else {
    echo json_encode([]);
    exit;
}

$result = $conn->query($query);
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
?>
