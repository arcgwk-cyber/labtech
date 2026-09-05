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
            'Dashboard' => 'dashboard_content.php',
            'Users' => 'users_content.php',
            'Patients' => 'register_patient_content.php',
            'Billing' => 'billing_content.php',
            'Sample Collection' => 'sample_collection_content.php',
            'Enter Results' => 'test_entry_list_content.php',
            'Lab Tests' => 'lab_tests_content.php',
            'Templates' => 'template_editor_content.php',
            'Reports' => 'reports_content.php'
        ],
        'lab_technician' => [
            'Dashboard' => 'dashboard_content.php',
            'Sample Collection' => 'sample_collection_content.php',
            'Enter Results' => 'test_entry_list_content.php',
            'Reports' => 'reports_content.php'
        ],
        'receptionist' => [
            'Dashboard' => 'dashboard_content.php',
            'Patients' => 'register_patient_content.php',
            'Billing' => 'billing_content.php'
        ],
        'guest' => [
            'Dashboard' => 'dashboard_content.php'
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
            margin: 0;
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
            margin-top: 60px;
        }
        iframe {
            width: 100%;
            height: calc(100vh - 60px);
            border: none;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h4><i class="fa-solid fa-flask"></i> Lab Portal</h4>
    <?php foreach ($navItems as $name => $link): ?>
        <a href="<?= $link ?>" target="contentFrame">
            <i class="fa-solid fa-angle-right me-2"></i> <?= $name ?>
        </a>
    <?php endforeach; ?>
    <hr class="text-secondary mx-3">
    <a href="logout.php" class="text-danger px-3"><i class="fa-solid fa-right-from-bracket me-2"></i> Logout</a>
</div>

<div class="navbar">
    <div class="d-flex justify-content-between">
        <div><strong><?= ucfirst($role) ?> Dashboard</strong></div>
        <div>Welcome, <strong><?= htmlspecialchars($username) ?></strong></div>
    </div>
</div>

<div class="main-content">
    <iframe name="contentFrame" src="dashboard_content.php"></iframe>
</div>

</body>
</html>
