<?php
/**
 * Super Admin Executive Header & Navigation
 */
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/db.php';

$active_nav = basename($_SERVER['PHP_SELF'] ?? 'index.php');

// Live count of pending registrations
$pending_count = 0;
if ($conn && !$conn->connect_error) {
    $res = $conn->query("SELECT COUNT(*) as c FROM vendor_master WHERE status = 'pending'");
    if ($res) {
        $pending_count = (int)($res->fetch_assoc()['c'] ?? 0);
    }
}

$super_user_name = $_SESSION['super_admin_name'] ?? 'Super Admin';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $page_title ?? 'Super Admin' ?> | LabTech Cloud SaaS</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    :root {
      --sa-dark: #0f172a;
      --sa-darker: #090d16;
      --sa-primary: #6366f1;
      --sa-primary-hover: #4f46e5;
      --sa-accent: #06b6d4;
      --sa-border: #e2e8f0;
      --sa-bg: #f8fafc;
    }
    body {
      font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
      background-color: var(--sa-bg);
      color: #1e293b;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }
    .sa-navbar {
      background: var(--sa-dark);
      border-bottom: 1px solid rgba(255, 255, 255, 0.08);
      padding: 12px 0;
    }
    .sa-brand {
      color: #ffffff;
      font-weight: 800;
      font-size: 1.15rem;
      letter-spacing: -0.5px;
      display: flex;
      align-items: center;
      gap: 10px;
      text-decoration: none;
    }
    .sa-brand span.badge-role {
      background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
      font-size: 0.65rem;
      font-weight: 700;
      letter-spacing: 0.5px;
      padding: 3px 8px;
      border-radius: 6px;
      text-transform: uppercase;
    }
    .sa-nav-link {
      color: #94a3b8;
      font-weight: 600;
      font-size: 0.9rem;
      padding: 8px 14px;
      border-radius: 8px;
      transition: all 0.2s ease;
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .sa-nav-link:hover {
      color: #ffffff;
      background: rgba(255, 255, 255, 0.06);
    }
    .sa-nav-link.active {
      color: #ffffff;
      background: rgba(99, 102, 241, 0.25);
      border: 1px solid rgba(99, 102, 241, 0.4);
    }
    .badge-pending-glow {
      background: #ef4444;
      color: white;
      font-size: 0.7rem;
      font-weight: 700;
      padding: 2px 7px;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(239, 68, 68, 0.6);
      animation: pulse 2s infinite;
    }
    @keyframes pulse {
      0% { transform: scale(1); }
      50% { transform: scale(1.1); }
      100% { transform: scale(1); }
    }
    .card-sa {
      background: #ffffff;
      border: 1px solid var(--sa-border);
      border-radius: 16px;
      box-shadow: 0 1px 3px rgba(0,0,0,0.02), 0 1px 2px rgba(0,0,0,0.04);
      transition: all 0.2s ease;
    }
    .card-sa:hover {
      box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.02);
    }
    .kpi-icon-box {
      width: 52px;
      height: 52px;
      border-radius: 14px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.4rem;
    }
  </style>
</head>
<body>

<nav class="sa-navbar sticky-top">
  <div class="container-fluid px-4">
    <div class="d-flex align-items-center justify-content-between w-100">
      
      <!-- Left: Brand & Links -->
      <div class="d-flex align-items-center gap-4">
        <a href="index.php" class="sa-brand">
          <div class="p-2 bg-primary rounded-3 text-white d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
            <i class="fas fa-network-wired"></i>
          </div>
          <div>
            <div>LabTech <span style="color: var(--sa-accent);">Cloud</span></div>
          </div>
          <span class="badge-role">Super Admin</span>
        </a>

        <!-- Navigation Links -->
        <div class="d-none d-lg-flex align-items-center gap-1">
          <a href="index.php" class="sa-nav-link <?= $active_nav === 'index.php' ? 'active' : '' ?>">
            <i class="fas fa-chart-line"></i> Dashboard
          </a>
          <a href="labs_pending.php" class="sa-nav-link <?= $active_nav === 'labs_pending.php' ? 'active' : '' ?>">
            <i class="fas fa-clock"></i> Pending Approvals
            <?php if ($pending_count > 0): ?>
              <span class="badge-pending-glow"><?= $pending_count ?></span>
            <?php endif; ?>
          </a>
          <a href="labs_manage.php" class="sa-nav-link <?= in_array($active_nav, ['labs_manage.php', 'lab_edit.php']) ? 'active' : '' ?>">
            <i class="fas fa-vials"></i> All Labs
          </a>
          <a href="renewals.php" class="sa-nav-link <?= $active_nav === 'renewals.php' ? 'active' : '' ?>">
            <i class="fas fa-calendar-check"></i> Renewals & Trials
          </a>
          <a href="payments.php" class="sa-nav-link <?= $active_nav === 'payments.php' ? 'active' : '' ?>">
            <i class="fas fa-receipt"></i> Payments
          </a>
          <a href="settings.php" class="sa-nav-link <?= $active_nav === 'settings.php' ? 'active' : '' ?>">
            <i class="fas fa-cog"></i> Settings
          </a>
        </div>
      </div>

      <!-- Right: User & Actions -->
      <div class="d-flex align-items-center gap-3">
        <a href="../demo/index.php" target="_blank" class="btn btn-sm btn-outline-light d-none d-sm-inline-flex align-items-center gap-2 rounded-3 px-3 py-1">
          <i class="fas fa-external-link-alt text-info"></i> View Demo Lab
        </a>
        
        <div class="dropdown">
          <button class="btn btn-dark btn-sm rounded-pill px-3 py-1 border border-secondary border-opacity-50 text-light d-flex align-items-center gap-2 dropdown-toggle" type="button" data-bs-toggle="dropdown">
            <i class="fas fa-user-circle fa-lg text-primary"></i>
            <span class="fw-semibold d-none d-md-inline"><?= htmlspecialchars($super_user_name) ?></span>
          </button>
          <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 mt-2">
            <li><h6 class="dropdown-header">Super Administrator</h6></li>
            <li><a class="dropdown-item" href="settings.php"><i class="fas fa-key text-primary me-2"></i> Master Password</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-danger" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
          </ul>
        </div>
      </div>

    </div>
  </div>
</nav>

<main class="flex-grow-1">
