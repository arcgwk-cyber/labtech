<?php
include 'auth_check.php';
require_once 'db.php';

// Handle alert messages
$msg = '';
if (isset($_GET['success'])) {
    if ($_GET['success'] === 'add') $msg = "Bill added successfully.";
    elseif ($_GET['success'] === 'update') $msg = "Bill updated successfully.";
    elseif ($_GET['success'] === 'delete') $msg = "Bill deleted successfully.";
}

// Fetch all bills with patient info
$sql = "SELECT b.bill_id, p.full_name, p.phone, b.bill_date, b.total_amount, b.paid_amount, b.balance, b.payment_status
        FROM bills b
        JOIN patients p ON b.patient_id = p.patient_id
        ORDER BY b.bill_id DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Bill List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">

    <h4 class="mb-4">Patient Bills</h4>

    <?php if ($msg): ?>
        <div class="alert alert-success"><?= $msg ?></div>
    <?php endif; ?>

    <div class="mb-3">
        <a href="bill_add.php" class="btn btn-primary">➕ Add New Bill</a>
    </div>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>Bill ID</th>
                <th>Patient Name</th>
                <th>Phone</th>
                <th>Bill Date</th>
                <th>Total</th>
                <th>Paid</th>
                <th>Balance</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['bill_id'] ?></td>
                    <td><?= htmlspecialchars($row['full_name']) ?></td>
                    <td><?= htmlspecialchars($row['phone']) ?></td>
                    <td><?= date('d-M-Y', strtotime($row['bill_date'])) ?></td>
                    <td>₹<?= number_format($row['total_amount'], 2) ?></td>
                    <td>₹<?= number_format($row['paid_amount'], 2) ?></td>
                    <td>₹<?= number_format($row['balance'], 2) ?></td>
                    <td>
                        <span class="badge <?= $row['payment_status'] === 'Paid' ? 'bg-success' : 'bg-warning' ?>">
                            <?= $row['payment_status'] ?>
                        </span>
                    </td>
                    <td>
                        <a href="bill_edit.php?id=<?= $row['bill_id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="print_bill.php?id=<?= $row['bill_id'] ?>" class="btn btn-sm btn-info" target="_blank">Print</a>
						<!--<a href="sample_collection.php?id=<?= $row['bill_id'] ?>" class="btn btn-sm btn-warning">next</a>-->
                        <a href="bill_delete.php?id=<?= $row['bill_id'] ?>" class="btn btn-sm btn-danger"
                           onclick="return confirm('Are you sure you want to delete this bill?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="9" class="text-center text-muted">No bills found.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
