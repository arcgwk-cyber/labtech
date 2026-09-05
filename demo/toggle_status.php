<?php
// toggle_status.php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bill_id = intval($_POST['bill_id'] ?? 0);
    $field = $_POST['field'] ?? '';

    // Only allow valid fields
    $allowed_fields = ['sample_collected', 'result_entered'];
    if (!in_array($field, $allowed_fields)) {
        die("Invalid field");
    }

    // Fetch current value
    $stmt = $conn->prepare("SELECT $field FROM bills WHERE bill_id = ?");
    $stmt->bind_param("i", $bill_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $new_value = $row[$field] ? 0 : 1;

        $update = $conn->prepare("UPDATE bills SET $field = ? WHERE bill_id = ?");
        $update->bind_param("ii", $new_value, $bill_id);
        $update->execute();
    }
}

// Redirect back
header("Location: " . $_SERVER['HTTP_REFERER']);
exit;
