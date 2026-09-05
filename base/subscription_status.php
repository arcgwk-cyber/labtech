<?php
require_once 'db.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$settings = null;
if ($conn) {
    $res = $conn->query("SELECT * FROM admin_settings WHERE id = 1 LIMIT 1");
    if ($res) {
        $settings = $res->fetch_assoc();
    }
}

$company_name = $settings['company_name'] ?? 'Diagnostic Centre';
$expiry_date  = $settings['expiry_date'] ?? date('Y-m-d', strtotime('+30 days'));
$grace_days   = (int)($settings['grace_days'] ?? 7);

$today = date('Y-m-d');
$grace_limit = date('Y-m-d', strtotime($expiry_date . " +{$grace_days} days"));

$diffSecs = strtotime($expiry_date) - time();
$daysLeft = ceil($diffSecs / 86400);

if ($today <= $expiry_date) {
    $status = 'active';
    $statusBadge = 'bg-success';
    $statusLabel = 'Active License (' . ($daysLeft > 0 ? "{$daysLeft} days remaining" : "Expires today") . ')';
} elseif ($today <= $grace_limit) {
    $status = 'grace';
    $statusBadge = 'bg-warning text-dark';
    $statusLabel = 'In Grace Period (Renew Immediately)';
} else {
    $status = 'expired';
    $statusBadge = 'bg-danger';
    $statusLabel = 'Subscription Expired';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Subscription & License Status | <?= htmlspecialchars($company_name) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      background-color: #f8fafc;
      font-family: 'Segoe UI', system-ui, sans-serif;
      padding: 40px 15px;
    }
    .status-card {
      background: white;
      border-radius: 16px;
      border: 1px solid #e2e8f0;
      box-shadow: 0 10px 25px rgba(0,0,0,0.05);
      max-width: 650px;
      margin: 0 auto;
      overflow: hidden;
    }
  </style>
</head>
<body>
<?php include_once __DIR__ . '/header.php'; ?>

  <div class="status-card">
    <div class="bg-primary text-white p-4 text-center">
      <i class="fas fa-shield-alt fa-3x mb-2"></i>
      <h3 class="fw-bold mb-1">Laboratory License Details</h3>
      <p class="mb-0 small text-light opacity-75">Subscription & System Validity Status</p>
    </div>

    <div class="p-4 p-md-5">
      <table class="table table-bordered mb-4">
        <tr>
          <th class="bg-light" width="40%">Diagnostic Centre</th>
          <td class="fw-bold"><?= htmlspecialchars($company_name) ?></td>
        </tr>
        <tr>
          <th class="bg-light">License Status</th>
          <td><span class="badge <?= $statusBadge ?> px-3 py-2 fs-6"><?= $statusLabel ?></span></td>
        </tr>
        <tr>
          <th class="bg-light">Expiry Date</th>
          <td class="fw-semibold"><?= date('d M Y', strtotime($expiry_date)) ?></td>
        </tr>
        <tr>
          <th class="bg-light">Grace Period Until</th>
          <td><?= date('d M Y', strtotime($grace_limit)) ?></td>
        </tr>
      </table>

      <?php if ($status === 'active'): ?>
        <div class="alert alert-success d-flex align-items-center gap-2 mb-4">
          <i class="fas fa-check-circle fa-lg"></i>
          <div>Your laboratory software license is active and fully functional.</div>
        </div>
      <?php else: ?>
        <div class="alert alert-warning d-flex align-items-center gap-2 mb-4">
          <i class="fas fa-exclamation-triangle fa-lg"></i>
          <div>Your license has expired or entered grace period. Please renew to prevent service disruption.</div>
        </div>
      <?php endif; ?>

      <div class="d-flex justify-content-between">
        <a href="dashboard.php" class="btn btn-outline-secondary">
          <i class="fas fa-arrow-left me-1"></i> Dashboard
        </a>
        <a href="renew.php" class="btn btn-primary">
          <i class="fas fa-sync-alt me-1"></i> Renew Subscription
        </a>
      </div>
    </div>
  </div>
</body>
</html>
