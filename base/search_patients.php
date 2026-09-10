<?php
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/db.php';

$term_plain = trim($_GET['q'] ?? '');
$term = "%".$conn->real_escape_string($term_plain)."%";

$sql = "SELECT p.*, COUNT(b.bill_id) as visit_count 
        FROM patients p 
        LEFT JOIN bills b ON p.patient_id = b.patient_id
        WHERE p.full_name LIKE ? OR p.phone LIKE ? OR CAST(p.patient_id AS CHAR) = ?
        GROUP BY p.patient_id
        ORDER BY p.patient_id DESC LIMIT 20";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $term, $term, $term_plain);
$stmt->execute();
$result = $stmt->get_result();

$patients = [];
while ($row = $result->fetch_assoc()) {
    $patients[] = $row;
}

header('Content-Type: application/json');
echo json_encode($patients);
