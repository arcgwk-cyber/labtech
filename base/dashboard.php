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
<!-- Keep your existing PHP logic above -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f5f7fa;
    }

    .navbar-nav .nav-link:hover {
      background-color: #0069d9 !important;
      color: #fff !important;
    }

    .dropdown-menu.card-dropdown {
      min-width: 220px;
      padding: 1rem;
      border-radius: 0.5rem;
      box-shadow: 0 0.25rem 0.5rem rgba(0,0,0,0.15);
      background-color: #fff;
    }

    .dropdown-menu.card-dropdown a {
      display: block;
      padding: 0.375rem 0.5rem;
      color: #0069d9;
      font-weight: 500;
      text-decoration: none;
    }

    .dropdown-menu.card-dropdown a:hover {
      background-color: #e9f2ff;
      color: #004a99;
      border-radius: 0.25rem;
    }

    .navbar-brand img {
      height: 40px;
    }
  </style>
  

</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
      <img src="assets/logo.png" alt="Logo">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNavbar">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link text-white" href="#" onclick="loadPage('dashboard_summary.php')">Dashboard</a>
        </li>

        <?php if ($role == 'admin'): ?>
          <li class="nav-item">
            <a class="nav-link text-white" href="#" onclick="loadPage('bill_list.php')">Bill Entry</a>
          </li>

          <!-- Masters Dropdown -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white" href="#" id="mastersDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Masters
            </a>
            <ul class="dropdown-menu card-dropdown" aria-labelledby="mastersDropdown">
              <li><a class="dropdown-item" href="#" onclick="loadPage('test_parameters.php')">Parameters</a></li>
              <li><a class="dropdown-item" href="#" onclick="loadPage('lab_test_list.php')">Tests</a></li>
              <li><a class="dropdown-item" href="#" onclick="loadPage('test_categories.php')">Categories</a></li>
              <li><a class="dropdown-item" href="#" onclick="loadPage('test_groups.php')">Groups</a></li>
              <li><a class="dropdown-item" href="#" onclick="loadPage('profile.php')">Profile</a></li>
            </ul>
          </li>

          <!-- Price Lists Dropdown -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white" href="#" id="priceDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Price Lists
            </a>
            <ul class="dropdown-menu card-dropdown" aria-labelledby="priceDropdown">
              <li><a class="dropdown-item" href="#" onclick="loadPage('rate_card.php')">Price Card</a></li>
              <li><a class="dropdown-item" href="#" onclick="loadPage('category_tests.php')">Available Tests</a></li>
            </ul>
          </li>

          <!-- Result Dropdown -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white" href="#" id="resultDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Result
            </a>
            <ul class="dropdown-menu card-dropdown" aria-labelledby="resultDropdown">
              <li><a class="dropdown-item" href="#" onclick="loadPage('test_entry_list.php')">Result Entry</a></li>
            </ul>
          </li>

          <li class="nav-item">
            <a class="nav-link text-white" href="#" onclick="loadPage('users.php')">Manage Users</a>
          </li>

        <?php else: ?>
          <li class="nav-item">
            <a class="nav-link text-white" href="#" onclick="loadPage('bill_list.php')">Bill Entry</a>
          </li>

          <!-- Result Dropdown -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white" href="#" id="resultDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Result
            </a>
            <ul class="dropdown-menu card-dropdown" aria-labelledby="resultDropdown">
              <li><a class="dropdown-item" href="#" onclick="loadPage('test_entry_list.php')">Result Entry</a></li>
            </ul>
          </li>
        <?php endif; ?>
      </ul>

      <!-- Right-side user info -->
      <div class="d-flex align-items-center text-white">
        👤 <?= htmlspecialchars($_SESSION['username'] ?? 'User') ?>
        <a class="btn btn-sm btn-light ms-2" href="logout.php">Logout</a>
      </div>
    </div>
  </div>
</nav>

<div class="container-fluid p-3">
  <iframe id="content-frame" src="dashboard_summary.php" style="width:100%; height:80vh; border:none;"></iframe>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  function loadPage(page) {
    const iframe = document.getElementById('content-frame');
    iframe.style.opacity = 0;

    setTimeout(() => {
      iframe.src = page;
    }, 100);

    iframe.onload = () => {
      iframe.style.opacity = 1;
    };

    // Collapse navbar if on mobile view
    const navbarCollapse = document.getElementById('navbarContent');
    if (window.innerWidth < 992 && navbarCollapse.classList.contains('show')) {
      const bsCollapse = bootstrap.Collapse.getOrCreateInstance(navbarCollapse);
      bsCollapse.hide();
    }

    // Hide any open dropdowns
    document.querySelectorAll('.dropdown.show').forEach(drop => {
      const toggle = drop.querySelector('[data-bs-toggle="dropdown"]');
      if (toggle) {
        const dropdownInstance = bootstrap.Dropdown.getOrCreateInstance(toggle);
        dropdownInstance.hide();
      }
    });
  }

  // Ensure all nav and dropdown items work with this
  document.addEventListener('DOMContentLoaded', () => {
    const links = document.querySelectorAll('.nav-link, .dropdown-item');
    links.forEach(link => {
      link.addEventListener('click', () => {
        const onclick = link.getAttribute('onclick');
        const match = onclick?.match(/loadPage\('(.+?)'\)/);
        if (match) {
          loadPage(match[1]);
        }
      });
    });
  });
</script>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const navbarCollapse = document.getElementById('navbarContent');

    const collapseNavbarIfMobile = () => {
      if (window.innerWidth < 992 && navbarCollapse.classList.contains('show')) {
        const bsCollapse = bootstrap.Collapse.getOrCreateInstance(navbarCollapse);
        bsCollapse.hide();
      }
    };

    // Collapse on any nav-link or dropdown-item click
    document.querySelectorAll('.nav-link, .dropdown-item').forEach(link => {
      link.addEventListener('click', function () {
        // Delay allows dropdown animation to complete before collapsing navbar
        setTimeout(() => {
          collapseNavbarIfMobile();
        }, 150);
      });
    });
  });
</script>

</body>
</html>
