<?php
require_once("db.php");

header('Content-Type: application/json');

$bill_id = $_POST['bill_id'] ?? 0;
$patient_type_id = $_POST['patient_type_id'] ?? 0;

if($bill_id <= 0 || $patient_type_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
    exit;
}

try {
    // Update the bill with patient type
    $stmt = $conn->prepare("UPDATE bills SET patient_type_id = ? WHERE bill_id = ?");
    $stmt->bind_param("ii", $patient_type_id, $bill_id);
    
    if($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Patient type assigned successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>