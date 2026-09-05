<?php
include 'auth_check.php';
include 'db.php';

if (!isset($_GET['bill_id'])) {
    die("Bill ID is required.");
}

$bill_id = $_GET['bill_id'];
$success = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bill_id = $_POST['bill_id'];
    $status = 'Completed';

    if (isset($_POST['results']) && is_array($_POST['results'])) {
        $stmt = $conn->prepare("INSERT INTO test_results (bill_id, parameter_id, result_value, status)
            VALUES (?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE result_value = VALUES(result_value), status = VALUES(status)");

        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }

        foreach ($_POST['results'] as $param_id => $value) {
            $stmt->bind_param("iiss", $bill_id, $param_id, $value, $status);
            $stmt->execute();
        }

        $stmt->close();

        // Update sample status
        $conn->query("UPDATE test_samples SET status='Completed' WHERE bill_id=$bill_id");

        header("Location: test_entry_list.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Enter Test Results</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .container { margin-top: 40px; }
        .form-section { margin-bottom: 40px; }
        .alert-success { margin-top: 20px; }
    </style>
</head>
<body>
<div class="container">
    <h3 class="mb-4">Enter Test Results</h3>

    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>

    <?php
    // Get patient and bill info
    $patient_sql = $conn->prepare("SELECT p.full_name, b.bill_date FROM bills b JOIN patients p ON b.patient_id = p.patient_id WHERE b.bill_id = ?");
    $patient_sql->bind_param("i", $bill_id);
    $patient_sql->execute();
    $patient_result = $patient_sql->get_result();
    $patient = $patient_result->fetch_assoc();
    ?>

    <div class="mb-4">
        <strong>Patient Name:</strong> <?php echo htmlspecialchars($patient['full_name']); ?><br>
        <strong>Bill Date:</strong> <?php echo htmlspecialchars($patient['bill_date']); ?>
    </div>

    <form method="post">
        <input type="hidden" name="bill_id" value="<?php echo $bill_id; ?>">

        <?php
        // Fetch all test parameters for this bill
        $sql = "
            SELECT 
                tp.parameter_id, 
                tp.param_name, 
                tp.unit, 
                rr.male_min, rr.male_max
            FROM bill_tests bt
            JOIN lab_test_parameters ltp ON bt.test_id = ltp.test_id
            JOIN test_parameters tp ON ltp.parameter_id = tp.parameter_id
            LEFT JOIN parameter_reference_ranges rr ON tp.parameter_id = rr.parameter_id
            WHERE bt.bill_id = ?
            ORDER BY tp.param_name
        ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $bill_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo '<div class="form-section"><table class="table table-bordered">';
            echo '<thead><tr><th>Test Parameter</th><th>Value</th><th>Unit</th><th>Reference Range (Male)</th></tr></thead><tbody>';
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>" . htmlspecialchars($row['param_name']) . "</td>
                    <td><input type='text' name='results[{$row['parameter_id']}]' class='form-control' required></td>
                    <td>" . htmlspecialchars($row['unit']) . "</td>
                    <td>" . htmlspecialchars($row['male_min']) . " - " . htmlspecialchars($row['male_max']) . "</td>
                </tr>";
            }
            echo '</tbody></table></div>';
            echo '<button type="submit" class="btn btn-success">Submit Results</button>';
        } else {
            echo '<div class="alert alert-warning">No test parameters found for this bill.</div>';
        }
        ?>
    </form>
</div>
</body>
</html>
