<?php
session_start();
require 'db.php';

if (!isset($_SESSION['vendor_id'])) {
    header("Location: vendor_login.php");
    exit();
}

$vendor_id = $_SESSION['vendor_id'];

// Current FY Range
$today = date('Y-m-d');
$fy_start = (date('m') >= 4) ? date('Y-04-01') : date('Y-04-01', strtotime('-1 year'));
$fy_end   = (date('m') >= 4) ? date('Y-03-31', strtotime('+1 year')) : date('Y-03-31');

$stmt = $pdo->prepare("SELECT * FROM transactions WHERE vendor_id = ? AND txn_date BETWEEN ? AND ?");
$stmt->execute([$vendor_id, $fy_start, $fy_end]);
$transactions = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Vendor Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-4">
    <h4>Welcome, <?= $_SESSION['vendor_userid'] ?></h4>
    <h6>Financial Year: <?= date('d M Y', strtotime($fy_start)) ?> to <?= date('d M Y', strtotime($fy_end)) ?></h6>

    <div class="card mt-3">
      <div class="card-header bg-primary text-white">Your Transactions</div>
      <div class="card-body p-0">
        <table class="table table-bordered m-0">
          <thead>
            <tr>
              <th>Date</th>
              <th>Description</th>
              <th>Amount</th>
            </tr>
          </thead>
          <tbody>
            <?php if (count($transactions)): ?>
              <?php foreach ($transactions as $txn): ?>
                <tr>
                  <td><?= date('d-m-Y', strtotime($txn['txn_date'])) ?></td>
                  <td><?= htmlspecialchars($txn['description']) ?></td>
                  <td><?= number_format($txn['amount'], 2) ?></td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr><td colspan="3" class="text-center">No transactions found</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>
</html>
