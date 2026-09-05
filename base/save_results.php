<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'auth_check.php';
include 'db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['bill_id'], $_POST['results'])) {

    $bill_id = (int)$_POST['bill_id'];
    $results = $_POST['results'];
    $test_ids = $_POST['test_ids'] ?? [];
    $tested_by = $_SESSION['user_id'] ?? 0; // logged-in user ID

    // Get sample_id(s) for this bill
    $sample_stmt = $conn->prepare("SELECT sample_id FROM test_samples WHERE bill_id = ?");
    $sample_stmt->bind_param("i", $bill_id);
    $sample_stmt->execute();
    $sample_result = $sample_stmt->get_result();

    $sample_ids = [];
    while ($row = $sample_result->fetch_assoc()) {
        $sample_ids[] = $row['sample_id'];
    }
    $sample_stmt->close();

    if (empty($sample_ids)) {
        die("No sample found for this bill.");
    }

    // Insert / Update test_results
    $stmt = $conn->prepare("
        INSERT INTO test_results 
            (bill_id, sample_id, parameter_id, test_id, result_value, result_date, status, tested_by)
        VALUES (?, ?, ?, ?, ?, NOW(), 'Completed', ?)
        ON DUPLICATE KEY UPDATE
            result_value = VALUES(result_value),
            result_date = NOW(),
            status = 'Completed',
            tested_by = VALUES(tested_by)
    ");

    foreach ($results as $param_id => $value) {
        $test_id = isset($test_ids[$param_id]) ? (int)$test_ids[$param_id] : null;
        if (!$test_id) continue;

        // Use first sample_id (or modify if multiple samples per test)
        $sample_id = $sample_ids[0];

        $stmt->bind_param("iiiisi", $bill_id, $sample_id, $param_id, $test_id, $value, $tested_by);
        $stmt->execute();
    }
    $stmt->close();

    // Update all test_samples for this bill as Completed
    $updateSamples = $conn->prepare("UPDATE test_samples SET status = 'Completed' WHERE bill_id = ?");
    $updateSamples->bind_param("i", $bill_id);
    $updateSamples->execute();
    $updateSamples->close();

    // Mark bills.result_entered = 1 so status changes from Pending to Completed
    $updateBill = $conn->prepare("UPDATE bills SET result_entered = 1 WHERE bill_id = ?");
    $updateBill->bind_param("i", $bill_id);
    $updateBill->execute();
    $updateBill->close();

    // Redirect cleanly back to result_entry with success notification
    header("Location: result_entry.php?bill_id={$bill_id}&saved=1");
    exit;

} else {
    die("Invalid input or session.");
}

?>
