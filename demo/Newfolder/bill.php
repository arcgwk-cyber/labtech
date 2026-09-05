<?php
// db.php assumed to be included for DB connection
require_once 'db.php';

// Fetch all patients for dropdown
$patients = $conn->query("SELECT * FROM patients ORDER BY full_name");

// Fetch all lab tests and packages
$tests = $conn->query("SELECT * FROM lab_tests ORDER BY test_name");
$packages = $conn->query("SELECT * FROM test_packages ORDER BY package_name");

// Save billing entry
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn->begin_transaction();
    try {
        // Insert bill
        $stmt = $conn->prepare("INSERT INTO bills (patient_id, bill_date, total_amount, paid_amount, balance, payment_status, created_by) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issddss", $_POST['patient_id'], $_POST['bill_date'], $_POST['total'], $_POST['paid'], $_POST['balance'], $_POST['status'], $_POST['created_by']);
        $stmt->execute();
        $bill_id = $stmt->insert_id;
        $stmt->close();

        // Save selected tests
        foreach ($_POST['tests'] as $test_id) {
            $stmt = $conn->prepare("INSERT INTO bill_tests (bill_id, test_id) VALUES (?, ?)");
            $stmt->bind_param("ii", $bill_id, $test_id);
            $stmt->execute();
        }

        // Save selected packages
        foreach ($_POST['packages'] as $package_id) {
            $stmt = $conn->prepare("INSERT INTO bill_packages (bill_id, package_id) VALUES (?, ?)");
            $stmt->bind_param("ii", $bill_id, $package_id);
            $stmt->execute();
        }

        $conn->commit();
        echo "<div class='alert alert-success'>Billing entry saved successfully.</div>";
    } catch (Exception $e) {
        $conn->rollback();
        echo "<div class='alert alert-danger'>Error: {$e->getMessage()}</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Billing Entry</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h3>Add Billing Entry</h3>
    <form method="post">
        <div class="row mb-3">
            <div class="col">
                <label>Patient</label>
                <select name="patient_id" class="form-select" required>
                    <option value="">Select Patient</option>
                    <?php while($p = $patients->fetch_assoc()): ?>
                        <option value="<?= $p['patient_id'] ?>"><?= $p['full_name'] ?> (<?= $p['phone'] ?>)</option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="col">
                <label>Bill Date</label>
                <input type="date" name="bill_date" class="form-control" value="<?= date('Y-m-d') ?>" required>
            </div>
        </div>

        <div class="mb-3">
            <label>Tests</label>
            <?php while($t = $tests->fetch_assoc()): ?>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="tests[]" value="<?= $t['test_id'] ?>">
                    <label class="form-check-label">
                        <?= $t['test_name'] ?> - ₹<?= $t['price'] ?>
                    </label>
                </div>
            <?php endwhile; ?>
        </div>

        <div class="mb-3">
            <label>Packages</label>
            <?php while($pkg = $packages->fetch_assoc()): ?>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="packages[]" value="<?= $pkg['package_id'] ?>">
                    <label class="form-check-label">
                        <?= $pkg['package_name'] ?> - ₹<?= $pkg['package_price'] ?>
                    </label>
                </div>
            <?php endwhile; ?>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label>Total Amount</label>
                <input type="number" name="total" class="form-control" step="0.01" required>
            </div>
            <div class="col">
                <label>Paid</label>
                <input type="number" name="paid" class="form-control" step="0.01" required>
            </div>
            <div class="col">
                <label>Balance</label>
                <input type="number" name="balance" class="form-control" step="0.01" required>
            </div>
            <div class="col">
                <label>Status</label>
                <select name="status" class="form-select" required>
                    <option value="Paid">Paid</option>
                    <option value="Partially Paid">Partially Paid</option>
                    <option value="Unpaid">Unpaid</option>
                </select>
            </div>
        </div>

        <input type="hidden" name="created_by" value="admin">
        <button type="submit" class="btn btn-success">Save Bill</button>
    </form>
</div>
</body>
</html>
