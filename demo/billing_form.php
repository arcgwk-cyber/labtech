<?php
include 'auth_check.php';
include 'db.php';

$tests = $conn->query("SELECT test_id, test_name, price FROM lab_tests");
$packages = $conn->query("SELECT package_id, package_name, package_price FROM test_packages");

// Save billing
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn->begin_transaction();

    try {
        $stmt = $conn->prepare("INSERT INTO patients (full_name, gender, date_of_birth, phone, emnail, address, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("ssssss", $_POST['full_name'], $_POST['gender'], $_POST['dob'], $_POST['phone'], $_POST['email'], $_POST['address']);
        $stmt->execute();
        $patient_id = $stmt->insert_id;
        $stmt->close();

        $stmt = $conn->prepare("INSERT INTO bills (patient_id, bill_date, total_amount, paid_amount, balance, payment_status, created_by) VALUES (?, NOW(), ?, ?, ?, ?, 'admin')");
        $balance = $_POST['total'] - $_POST['paid'];
        $status = $balance > 0 ? 'Pending' : 'Paid';
        $stmt->bind_param("iddds", $patient_id, $_POST['total'], $_POST['paid'], $balance, $status);
        $stmt->execute();
        $bill_id = $stmt->insert_id;
        $stmt->close();

        // Save selected tests
        foreach ($_POST['tests'] as $test_id) {
            $stmt = $conn->prepare("INSERT INTO bill_tests (bill_id, test_id) VALUES (?, ?)");
            $stmt->bind_param("ii", $bill_id, $test_id);
            $stmt->execute();
            $stmt->close();
        }

        // Save selected packages
        if (!empty($_POST['packages'])) {
            foreach ($_POST['packages'] as $pkg_id) {
                $stmt = $conn->prepare("INSERT INTO bill_packages (bill_id, package_id) VALUES (?, ?)");
                $stmt->bind_param("ii", $bill_id, $pkg_id);
                $stmt->execute();
                $stmt->close();
            }
        }

        $conn->commit();
        header("Location: bill_list.php?success=1");
        exit;
    } catch (Exception $e) {
        $conn->rollback();
        echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>New Billing</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function updateTotal() {
            let total = 0;
            document.querySelectorAll('.test-price').forEach(el => {
                total += parseFloat(el.dataset.price || 0);
            });
            document.getElementById('total_amount').value = total.toFixed(2);
        }

        function addTestRow(test_id, name, price) {
            const table = document.getElementById('test_table');
            const row = table.insertRow();
            row.innerHTML = `<td>${name}</td><td>${price}</td><td><input type="hidden" name="tests[]" value="${test_id}" class="test-price" data-price="${price}"><button type="button" class="btn btn-danger btn-sm" onclick="this.closest('tr').remove(); updateTotal();">Remove</button></td>`;
            updateTotal();
        }
    </script>
</head>
<body>
<div class="container mt-4">
    <h4>Add Billing</h4>
    <form method="post">
        <div class="card p-3 mb-4">
            <h6>Patient Details</h6>
            <div class="row g-2">
                <div class="col-md-4"><input name="full_name" required placeholder="Full Name" class="form-control"></div>
                <div class="col-md-2">
                    <select name="gender" class="form-select" required>
                        <option value="">Gender</option>
                        <option>Male</option><option>Female</option>
                    </select>
                </div>
                <div class="col-md-3"><input type="date" name="dob" class="form-control" placeholder="DOB"></div>
                <div class="col-md-3"><input name="phone" placeholder="Phone" class="form-control"></div>
            </div>
            <div class="row g-2 mt-2">
                <div class="col-md-4"><input name="email" placeholder="Email" class="form-control"></div>
                <div class="col-md-8"><input name="address" placeholder="Address" class="form-control"></div>
            </div>
        </div>

        <div class="card p-3 mb-4">
            <h6>Select Tests</h6>
            <div class="row">
                <div class="col-md-6">
                    <select onchange="if(this.value) { let opt = this.options[this.selectedIndex]; addTestRow(this.value, opt.text, opt.dataset.price); this.selectedIndex=0; }" class="form-select">
                        <option value="">-- Add Test --</option>
                        <?php while ($row = $tests->fetch_assoc()): ?>
                            <option value="<?= $row['test_id'] ?>" data-price="<?= $row['price'] ?>"><?= $row['test_name'] ?> (₹<?= $row['price'] ?>)</option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <select name="packages[]" class="form-select" multiple>
                        <?php while ($row = $packages->fetch_assoc()): ?>
                            <option value="<?= $row['package_id'] ?>"><?= $row['package_name'] ?> (₹<?= $row['package_price'] ?>)</option>
                        <?php endwhile; ?>
                    </select>
                    <small class="text-muted">Hold Ctrl/Cmd to select multiple packages</small>
                </div>
            </div>

            <table class="table mt-3" id="test_table">
                <thead><tr><th>Test Name</th><th>Price</th><th>Action</th></tr></thead>
                <tbody></tbody>
            </table>
        </div>

        <div class="row g-2">
            <div class="col-md-3">
                <label>Total Amount</label>
                <input type="text" id="total_amount" name="total" class="form-control" readonly>
            </div>
            <div class="col-md-3">
                <label>Paid Amount</label>
                <input type="number" name="paid" step="0.01" class="form-control" required>
            </div>
        </div>

        <div class="mt-4">
            <button class="btn btn-success">Save Bill</button>
            <a href="bill_list.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
</body>
</html>
