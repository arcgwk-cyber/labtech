<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$role = $_SESSION['role'] ?? 'guest';
$username = $_SESSION['username'] ?? 'User';

function renderMenu($role) {
    $menu = [
        'admin' => [
            'Dashboard' => 'dashboard_home.php',
            'Users' => 'users.php',
            'Patients' => 'register_patient.php',
            'Billing' => 'billing.php',
            'Sample Collection' => 'sample_collection.php',
            'Enter Results' => 'test_entry_list.php',
            'Lab Tests' => 'lab_tests.php',
            'Templates' => 'template_editor.php',
            'Reports' => 'reports.php'
        ],
        'lab_technician' => [
            'Dashboard' => 'dashboard_home.php',
            'Sample Collection' => 'sample_collection.php',
            'Enter Results' => 'test_entry_list.php',
            'Reports' => 'reports.php'
        ],
        'receptionist' => [
            'Dashboard' => 'dashboard_home.php',
            'Patients' => 'register_patient.php',
            'Billing' => 'billing.php'
        ],
        'guest' => [
            'Dashboard' => 'dashboard_home.php'
        ]
    ];

    return $menu[$role] ?? $menu['guest'];
}
$navItems = renderMenu($role);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= ucfirst($role) ?> Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: #f1f4f8;
            font-family: 'Segoe UI', sans-serif;
        }
        .sidebar {
            width: 260px;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            background-color: #1e293b;
            color: #fff;
            padding-top: 60px;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            z-index: 1040;
        }
        .sidebar h4 {
            text-align: center;
            color: #60a5fa;
            font-weight: bold;
        }
        .sidebar a {
            color: #cbd5e1;
            display: block;
            padding: 12px 25px;
            text-decoration: none;
            transition: background 0.3s;
        }
        .sidebar a:hover,
        .sidebar a.active {
            background: #334155;
            color: #fff;
        }
        .navbar {
            position: fixed;
            left: 260px;
            right: 0;
            top: 0;
            background: #fff;
            padding: 10px 20px;
            border-bottom: 1px solid #dee2e6;
            z-index: 1030;
        }
        .main-content {
            margin-left: 260px;
            margin-top: 100px;
            height: calc(100vh - 100px);
            padding: 0 20px;
        }
        iframe {
            width: 100%;
            height: 100%;
            border: none;
        }
        .breadcrumb {
            background: transparent;
            padding: 0;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<div class="sidebar">
    <h4><i class="fa-solid fa-flask"></i> Lab Portal</h4>
    <?php foreach ($navItems as $name => $link): ?>
        <a href="#" onclick="loadPage('<?= $link ?>', '<?= $name ?>'); return false;">
            <i class="fa-solid fa-angle-right me-2"></i> <?= $name ?>
        </a>
    <?php endforeach; ?>
    <hr class="text-secondary mx-3">
    <a href="logout.php" class="text-danger px-3"><i class="fa-solid fa-right-from-bracket me-2"></i> Logout</a>
</div>

<div class="navbar">
    <div class="d-flex justify-content-between w-100">
        <div id="breadcrumb"><strong>Dashboard</strong></div>
        <div>Welcome, <strong><?= htmlspecialchars($username) ?></strong></div>
    </div>
</div>

<div class="main-content">
    <iframe id="pageFrame" src="dashboard_home.php"></iframe>
</div>

<script>
function loadPage(page, label) {
    document.getElementById('pageFrame').src = page;
    document.getElementById('breadcrumb').innerHTML = `<nav aria-label='breadcrumb'>
        <ol class='breadcrumb mb-0'>
            <li class='breadcrumb-item'><a href='#' onclick=\"loadPage('dashboard_home.php','Dashboard')\">Dashboard</a></li>
            <li class='breadcrumb-item active' aria-current='page'>${label}</li>
        </ol>
    </nav>`;
}
</script>
</body>
</html>
