<?php
session_start();
include('db.php');
if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  exit;
}

// Fix: Use correct role
if (!isset($_SESSION['role'])) {
  $role = '';
  if (isset($_SESSION['role_id'])) {
    $role_id = $_SESSION['role_id'];
    $role_res = mysqli_query($conn, "SELECT role_name FROM roles WHERE role_id = $role_id LIMIT 1");
    if ($row = mysqli_fetch_assoc($role_res)) {
      $role = $row['role_name'];
      $_SESSION['role'] = $role;
    }
  }
} else {
  $role = $_SESSION['role'];
}

// Dashboard stats
$filter_clause = '';
if (isset($_GET['filter']) && $_GET['filter'] === 'week') {
    $filter_clause = "AND bill_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
} elseif (isset($_GET['filter']) && $_GET['filter'] === 'month') {
    $filter_clause = "AND bill_date >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)";
} elseif (!empty($_GET['start_date']) && !empty($_GET['end_date'])) {
    $start = $_GET['start_date'];
    $end = $_GET['end_date'];
    $filter_clause = "AND bill_date BETWEEN '$start' AND '$end'";
}

$stats = [
  'total_bills' => 0,
  'unpaid_amount' => 0,
  'completed_tests' => 0,
  'pending_tests' => 0
];

$q1 = mysqli_query($conn, "SELECT COUNT(*) as total FROM bills WHERE 1 $filter_clause");
$stats['total_bills'] = mysqli_fetch_assoc($q1)['total'];

$q2 = mysqli_query($conn, "SELECT SUM(balance) as unpaid FROM bills WHERE payment_status != 'paid' $filter_clause");
$stats['unpaid_amount'] = mysqli_fetch_assoc($q2)['unpaid'] ?? 0;

$q3 = mysqli_query($conn, "SELECT COUNT(*) as completed FROM test_results WHERE status = 'Completed'");
$stats['completed_tests'] = mysqli_fetch_assoc($q3)['completed'];

$q4 = mysqli_query($conn, "SELECT COUNT(*) as pending FROM test_samples WHERE status != 'completed'");
$stats['pending_tests'] = mysqli_fetch_assoc($q4)['pending'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { font-family: 'Segoe UI', sans-serif; background-color: #f5f7fa; }
    .nav-link:hover { background-color: #0069d9 !important; color: #fff !important; }
    .card h3 { font-size: 28px; }
  </style>
</head>
<body>
  <nav class="nav nav-tabs bg-primary px-3 d-flex align-items-center">
    <a class="nav-link text-white" href="#" onclick="loadPage('dashboard_summary.php')">Dashboard</a>
    <?php if ($role == 'admin'): ?>
      <a class="nav-link text-white" href="#" onclick="loadPage('bill_list.php')">All Bills</a>
      <a class="nav-link text-white" href="#" onclick="loadPage('rate_card.php')">Rate Card</a>
      <a class="nav-link text-white" href="#" onclick="loadPage('category_tests.php')">Category Tests</a>
      <a class="nav-link text-white" href="#" onclick="loadPage('summary_report.php')">Reports</a>
      <a class="nav-link text-white" href="#" onclick="loadPage('users.php')">Manage Users</a>
    <?php endif; ?>
    <div class="ms-auto text-white">
      👤 <?= $_SESSION['username'] ?? 'User' ?>
      <a class="btn btn-sm btn-light ms-2" href="logout.php">Logout</a>
    </div>
  </nav>

  <div class="container-fluid p-3">
    <iframe id="content-frame" src="dashboard_summary.php" style="width:100%; height:80vh; border:none;"></iframe>
  </div>

  <script>
    function loadPage(page) {
      document.getElementById('content-frame').src = page;
    }
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>