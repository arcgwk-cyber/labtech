<?php
include 'auth_check.php';
include 'db.php';

if (!isset($_GET['bill_id'])) die("Bill ID is required.");

$bill_id = (int) $_GET['bill_id'];
$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bill_id = (int) $_POST['bill_id'];
    $status = 'Completed';

    if (isset($_POST['results']) && is_array($_POST['results'])) {
        $stmt = $conn->prepare("
            INSERT INTO test_results (bill_id, parameter_id, result_value, status)
            VALUES (?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE result_value = VALUES(result_value), status = VALUES(status)
        ");
        foreach ($_POST['results'] as $param_id => $value) {
            $stmt->bind_param("iiss", $bill_id, $param_id, $value, $status);
            $stmt->execute();
        }
        $stmt->close();
        $conn->query("UPDATE test_samples SET status='Completed' WHERE bill_id=$bill_id");

        header("Location: test_entry_list.php");
        exit;
    }
}

$patient_sql = $conn->prepare("
    SELECT p.full_name, p.gender, p.date_of_birth, b.bill_date
    FROM bills b
    JOIN patients p ON b.patient_id = p.patient_id
    WHERE b.bill_id = ?
");
$patient_sql->bind_param("i", $bill_id);
$patient_sql->execute();
$patient_result = $patient_sql->get_result();
$patient = $patient_result->fetch_assoc();
$patient_sql->close();

$age = 0;
$is_child = false;
$dob = null;

if (!empty($patient['date_of_birth'])) {
    try {
        $dob = new DateTime($patient['date_of_birth']);
        $today = new DateTime();
        $ageInterval = $today->diff($dob);
        $age = $ageInterval->y;
        $is_child = $age < 12;
    } catch (Exception $e) {
        $dob = null;
        $age = 0;
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
        body { background: #f9f9fb; font-family: 'Segoe UI', sans-serif; }
        .container { max-width: 1000px; margin-top: 40px; }
        .card { border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
        .card-header { background-color: #007bff; color: white; font-weight: 500; }
        .table th, .table td { vertical-align: middle; }
        .table thead th { position: sticky; top: 0; background: #fff; }
        .badge-label { font-size: 0.9rem; background-color: #e7f3ff; color: #0056b3; }
        .result-input { max-width: 150px; }
        .is-invalid { border: 2px solid red !important; }
        .tooltip-inner { max-width: 300px; }
    </style>
</head>
<body>
<div class="container">
    <div class="card mb-4">
        <div class="card-header">Patient & Billing Information</div>
        <div class="card-body">
            <p><span class="badge bg-primary">Name:</span> <?= htmlspecialchars($patient['full_name']); ?></p>
            <p><span class="badge bg-primary">Gender:</span> <?= ucfirst($patient['gender']); ?></p>
            <p><span class="badge bg-primary">Age:</span> <?= $dob !== null ? $age . " years" : "N/A"; ?></p>
            <p><span class="badge bg-primary">Bill Date:</span> <?= htmlspecialchars($patient['bill_date']); ?></p>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Enter Test Results</div>
        <div class="card-body">
            <form method="post" id="resultForm">
                <input type="hidden" name="bill_id" value="<?= $bill_id; ?>">
                <?php
                $sql = "
                    SELECT 
                        tp.parameter_id, tp.param_name, tp.unit, tp.method, tp.interpretation,
                        rr.male_min, rr.male_max, rr.male_default,
                        rr.female_min, rr.female_max, rr.female_default,
                        rr.child_min, rr.child_max, rr.child_default
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
                ?>
                <?php if ($result->num_rows > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Test Parameter</th>
                                    <th>Result</th>
                                    <th>Unit</th>
                                    <th>Reference Range</th>
                                    <th>Default</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php while ($row = $result->fetch_assoc()):
                                if ($is_child) {
                                    $min = $row['child_min'];
                                    $max = $row['child_max'];
                                    $default = $row['child_default'];
                                } elseif (strtolower($patient['gender']) == 'female') {
                                    $min = $row['female_min'];
                                    $max = $row['female_max'];
                                    $default = $row['female_default'];
                                } else {
                                    $min = $row['male_min'];
                                    $max = $row['male_max'];
                                    $default = $row['male_default'];
                                }
                                $inputId = "param_" . $row['parameter_id'];
                            ?>
                                <tr>
                                    <td>
                                        <span data-bs-toggle="tooltip" data-bs-placement="top"
                                              title="<?= htmlspecialchars($row['method'] . ' | ' . $row['interpretation']); ?>">
                                            <?= htmlspecialchars($row['param_name']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <input type="number" step="any"
                                               name="results[<?= $row['parameter_id']; ?>]"
                                               id="<?= $inputId; ?>"
                                               class="form-control result-input"
                                               value="<?= $default !== null ? htmlspecialchars($default) : ''; ?>"
                                               data-min="<?= $min; ?>"
                                               data-max="<?= $max; ?>"
                                               oninput="validateRange(this)"
                                               required>
                                    </td>
                                    <td><?= htmlspecialchars($row['unit']); ?></td>
                                    <td><?= $min . " - " . $max; ?></td>
                                    <td><?= $default !== null ? htmlspecialchars($default) : '-'; ?></td>
                                </tr>
                            <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-success px-4">Submit Results</button>
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning">No test parameters found for this bill.</div>
                <?php endif; ?>
                <?php $stmt->close(); ?>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Bootstrap tooltip
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // Validate input ranges
    function validateRange(input) {
        const value = parseFloat(input.value);
        const min = parseFloat(input.dataset.min);
        const max = parseFloat(input.dataset.max);

        input.classList.remove('is-invalid');
        if (!isNaN(value) && !isNaN(min) && !isNaN(max)) {
            if (value < min || value > max) {
                input.classList.add('is-invalid');
            }
        }
    }
</script>
</body>
</html>
