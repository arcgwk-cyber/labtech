<?php
require_once 'db.php';
session_start();

$bill_id = isset($_POST['bill_id']) ? intval($_POST['bill_id']) : 0;
$status = isset($_POST['status']) ? $_POST['status'] : '';
$collected_by = $_SESSION['user_id'] ?? 1;
$user_role = $_SESSION['role'] ?? 'user';
$sample_date = date('Y-m-d H:i:s');

// Validate input
if (!in_array($status, ['pending', 'collected']) || $bill_id <= 0) {
    echo "Invalid input.";
    exit;
}

// Get existing sample status
$check = $conn->prepare("SELECT status FROM test_samples WHERE bill_id = ?");
$check->bind_param("i", $bill_id);
$check->execute();
$check->store_result();

$existing_status = null;
if ($check->num_rows > 0) {
    $check->bind_result($existing_status);
    $check->fetch();
    $check->close();

    // Prevent downgrade if not admin
    if ($existing_status === 'completed' && $status !== 'completed' && $user_role !== 'admin') {
        echo "Permission denied. Only admins can downgrade from 'Completed'.";
        exit;
    }

    // Update
    $update = $conn->prepare("UPDATE test_samples SET status = ?, sample_date = ?, collected_by = ? WHERE bill_id = ?");
    $update->bind_param("ssii", $status, $sample_date, $collected_by, $bill_id);

    if ($update->execute()) {
        // Delete test_result if status downgraded from completed
        if ($existing_status === 'completed' && $status !== 'completed') {
            $delete = $conn->prepare("DELETE FROM test_results WHERE bill_id = ?");
            $delete->bind_param("i", $bill_id);
            $delete->execute();
            $delete->close();

            echo "Sample downgraded to '$status'. Test result deleted.";
        } else {
            echo "Sample status updated to '$status'.";
        }
    } else {
        echo "Failed to update sample: " . $update->error;
    }

    $update->close();
} else {
    $check->close();

    // Insert new
    $insert = $conn->prepare("INSERT INTO test_samples (bill_id, sample_date, collected_by, status) VALUES (?, ?, ?, ?)");
    $insert->bind_param("isis", $bill_id, $sample_date, $collected_by, $status);

    echo $insert->execute()
        ? "Sample recorded as '$status'."
        : "Failed to insert sample: " . $insert->error;

    $insert->close();
}

$conn->close();
?>
