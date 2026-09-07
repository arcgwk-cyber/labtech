<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'auth_check.php';
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['bill_id']) && isset($_POST['values'])) {
    $bill_id = $_POST['bill_id'];
    $values = $_POST['values'];

    foreach ($values as $param_id => $val) {
        $test_id = isset($_POST['test_ids'][$param_id]) ? $_POST['test_ids'][$param_id] : null;

        if ($test_id) {
            // Fetch sample_id and tested_by from test_samples
            $sample_stmt = $conn->prepare("
                SELECT sample_id, tested_by 
                FROM test_samples 
                WHERE bill_id = ? AND test_id = ?
            ");
            $sample_stmt->bind_param("ii", $bill_id, $test_id);
            $sample_stmt->execute();
            $sample_result = $sample_stmt->get_result();

            if ($sample_row = $sample_result->fetch_assoc()) {
                $sample_id = $sample_row['sample_id'];
                $tested_by = $sample_row['tested_by'];

                // Insert or update result in test_results
                $stmt = $conn->prepare("
                    INSERT INTO test_results 
                        (bill_id, sample_id, parameter_id, test_id, result_value, result_date, status, tested_by) 
                    VALUES 
                        (?, ?, ?, ?, ?, NOW(), 'Completed', ?)
                    ON DUPLICATE KEY UPDATE 
                        result_value = VALUES(result_value), 
                        result_date = NOW(), 
                        status = 'Completed',
                        tested_by = VALUES(tested_by)
                ");

                $stmt->bind_param("iiiisi", $bill_id, $sample_id, $param_id, $test_id, $val, $tested_by);
                $stmt->execute();
                $stmt->close();
            } else {
                // Log missing sample
                error_log("No sample found for bill_id = $bill_id and test_id = $test_id");
            }

            $sample_stmt->close();
        } else {
            // Log missing test_id
            error_log("Missing test_id for parameter_id = $param_id");
        }
    }

    // Redirect after successful processing
    header("Location: pdf-options.php?bill_id={$bill_id}");
    exit;
} else {
    echo "Invalid input or session.";
}
?>
