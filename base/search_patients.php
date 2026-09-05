<?php
include 'db.php';

$term = $_GET['q'] ?? '';
$term = "%".$conn->real_escape_string($term)."%";

$sql = "SELECT * FROM patients 
        WHERE full_name LIKE ? OR phone LIKE ?
        ORDER BY full_name LIMIT 20";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $term, $term);
$stmt->execute();
$result = $stmt->get_result();

$patients = [];
while ($row = $result->fetch_assoc()) {
    $patients[] = $row;
}

header('Content-Type: application/json');
echo json_encode($patients);
