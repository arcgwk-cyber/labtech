<?php
include 'db.php';

$bill_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($bill_id <= 0) die("Invalid Bill ID");

// Fetch bill, patient
$bill = $conn->query("SELECT b.*, p.full_name, p.gender, p.date_of_birth, p.phone, p.address 
                      FROM bills b JOIN patients p ON b.patient_id = p.patient_id 
                      WHERE b.bill_id = $bill_id")->fetch_assoc();

// Fetch tests
$tests = $conn->query("SELECT t.test_name, t.price FROM bill_tests bt 
                       JOIN lab_tests t ON bt.test_id = t.test_id 
                       WHERE bt.bill_id = $bill_id");

// Fetch packages
$packages = $conn->query("SELECT p.package_name, p.package_price FROM bill_packages bp 
                          JOIN test_packages p ON bp.package_id = p.package_id 
                          WHERE bp.bill_id = $bill_id");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Print Bill #<?= $bill_id ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            .no-print { display: none; }
        }
        .bill-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
        }
    </style>
</head>
<body>
<div class="bill-box">
    <h4 class="text-center mb-4">Patient Test Bill</h4>

    <div class="row mb-2">
        <div class="col-md-6"><strong>Bill ID:</strong> #<?= $bill['bill_id'] ?></div>
        <div class="col-md-6 text-end"><strong>Date:</strong> <?= date('d-M-Y', strtotime($bill['bill_date'])) ?></div>
    </div>

    <div class="mb-3">
        <strong>Patient Name:</strong> <?= $bill['full_name'] ?><br>
        <strong>Gender:</strong> <?= $bill['gender'] ?> | 
        <strong>DOB:</strong> <?= $bill['date_of_birth'] ?><br>
        <strong>Phone:</strong> <?= $bill['phone'] ?><br>
        <strong>Address:</strong> <?= $bill['address'] ?>
    </div>

    <hr>

    <h6>Tests & Packages</h6>
    <table class="table table-bordered">
        <thead class="table-light">
            <tr><th>#</th><th>Item</th><th>Type</th><th class="text-end">Price (₹)</th></tr>
        </thead>
        <tbody>
        <?php
        $i = 1;
        while ($t = $tests->fetch_assoc()):
        ?>
            <tr><td><?= $i++ ?></td><td><?= $t['test_name'] ?></td><td>Test</td><td class="text-end"><?= number_format($t['price'], 2) ?></td></tr>
        <?php endwhile; ?>

        <?php while ($p = $packages->fetch_assoc()): ?>
            <tr><td><?= $i++ ?></td><td><?= $p['package_name'] ?></td><td>Package</td><td class="text-end"><?= number_format($p['package_price'], 2) ?></td></tr>
        <?php endwhile; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="text-end">Total</th>
                <th class="text-end"><?= number_format($bill['total_amount'], 2) ?></th>
            </tr>
            <tr>
                <th colspan="3" class="text-end">Paid</th>
                <th class="text-end"><?= number_format($bill['paid_amount'], 2) ?></th>
            </tr>
            <tr>
                <th colspan="3" class="text-end">Balance</th>
                <th class="text-end"><?= number_format($bill['balance'], 2) ?></th>
            </tr>
        </tfoot>
    </table>

    <div class="text-center mt-4 no-print">
        <button onclick="window.print()" class="btn btn-primary">🖨️ Print Bill</button>
        <a href="bill_list.php" class="btn btn-secondary">Back</a>
    </div>
</div>
</body>
</html>
