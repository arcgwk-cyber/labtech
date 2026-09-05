<?php
require_once 'db.php';
session_start();

$bill_id = isset($_POST['bill_id']) ? intval($_POST['bill_id']) : 0;
$status = isset($_POST['status']) ? $_POST['status'] : '';
$collected_by = $_SESSION['user_id'] ?? 1;
$sample_date = date('Y-m-d H:i:s');

// Validate input
if (!in_array($status, ['pending', 'collected']) || $bill_id <= 0) {
    echo "Invalid input.";
    exit;
}

// Check if sample record already exists
$check = $conn->prepare("SELECT bill_id FROM test_samples WHERE bill_id = ?");
$check->bind_param("i", $bill_id);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    // Update
    $update = $conn->prepare("UPDATE test_samples SET status = ?, sample_date = ?, collected_by = ? WHERE bill_id = ?");
    $update->bind_param("ssii", $status, $sample_date, $collected_by, $bill_id);

    echo $update->execute()
        ? "Sample status updated to $status."
        : "Failed to update sample: " . $update->error;

    $update->close();
} else {
    // Insert new
    $insert = $conn->prepare("INSERT INTO test_samples (bill_id, sample_date, collected_by, status) VALUES (?, ?, ?, ?)");
    $insert->bind_param("isis", $bill_id, $sample_date, $collected_by, $status);

    echo $insert->execute()
        ? "Sample recorded as $status."
        : "Failed to insert sample: " . $insert->error;

    $insert->close();
}

$check->close();
$conn->close();
?>
