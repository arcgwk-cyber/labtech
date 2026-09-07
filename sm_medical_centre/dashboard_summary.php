<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include('db.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo "<div class='alert alert-danger'>Access denied.</div>";
    exit;
}

$start = $_GET['start_date'] ?? date('Y-m-01');
$end = $_GET['end_date'] ?? date('Y-m-d');

$where = "WHERE bill_date BETWEEN '$start' AND '$end'";

$bill_q = mysqli_query($conn, "SELECT COUNT(*) AS total_bills, SUM(total_amount) AS total_revenue, SUM(balance) AS total_due FROM bills $where");
$bill_data = mysqli_fetch_assoc($bill_q);

$tests_q = mysqli_query($conn, "SELECT COUNT(*) AS total_tests FROM test_results WHERE result_date BETWEEN '$start' AND '$end'");
$test_data = mysqli_fetch_assoc($tests_q);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Summary Report</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f8f9fa;
      font-family: 'Segoe UI', sans-serif;
    }

    .card {
      border-radius: 10px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }

    .card-body h5 {
      font-size: clamp(0.9rem, 1vw, 1.1rem);
      font-weight: 600;
    }

    .card-body h3 {
      font-size: clamp(1.3rem, 2.5vw, 2rem);
      font-weight: bold;
    }

    @media (max-width: 576px) {
      h4 {
        font-size: 1.2rem;
        text-align: center;
      }
    }
  </style>
</head>
<body>
<div class="container py-4">
  <h4 class="mb-3">📊 Summary Report</h4>

  <form class="row g-2 mb-4">
    <div class="col-12 col-md-3">
      <input type="date" name="start_date" class="form-control" value="<?= $start ?>">
    </div>
    <div class="col-12 col-md-3">
      <input type="date" name="end_date" class="form-control" value="<?= $end ?>">
    </div>
    <div class="col-12 col-md-3">
      <button class="btn btn-success w-100">Filter</button>
    </div>
  </form>

  <div class="row g-3">
    <div class="col-12 col-sm-6 col-md-4">
      <div class="card bg-info text-white">
        <div class="card-body text-center">
          <h5>Total Bills</h5>
          <h3><?= $bill_data['total_bills'] ?? 0 ?></h3>
        </div>
      </div>
    </div>

    <div class="col-12 col-sm-6 col-md-4">
      <div class="card bg-success text-white">
        <div class="card-body text-center">
          <h5>Total Revenue</h5>
          <h3>₹ <?= number_format($bill_data['total_revenue'] ?? 0, 2) ?></h3>
        </div>
      </div>
    </div>

    <div class="col-12 col-sm-6 col-md-4">
      <div class="card bg-danger text-white">
        <div class="card-body text-center">
          <h5>Total Due</h5>
          <h3>₹ <?= number_format($bill_data['total_due'] ?? 0, 2) ?></h3>
        </div>
      </div>
    </div>

    <div class="col-12 col-sm-6 col-md-4">
      <div class="card bg-warning text-dark">
        <div class="card-body text-center">
          <h5>Tests Done</h5>
          <h3><?= $test_data['total_tests'] ?? 0 ?></h3>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
