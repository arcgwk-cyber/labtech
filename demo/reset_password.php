<?php
session_start();
require_once __DIR__ . '/db.php';

// If already logged in, redirect to profile where they can safely change password
if (isset($_SESSION['user_id'])) {
    header("Location: profile.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Password Recovery &bull; Diagnostic Centre Portal</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
      background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }
    .recovery-card {
      background: #ffffff;
      border-radius: 20px;
      max-width: 480px;
      width: 100%;
      box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2), 0 10px 10px -5px rgba(0, 0, 0, 0.1);
      overflow: hidden;
    }
  </style>
</head>
<body>

<div class="recovery-card p-4 p-sm-5 text-center">
  <div class="mb-4 text-primary">
    <div class="d-inline-flex p-3 bg-primary bg-opacity-10 rounded-circle text-primary mb-2">
      <i class="fas fa-shield-halved fa-3x"></i>
    </div>
    <h4 class="fw-bold text-dark mt-2 mb-1">Account Security &amp; Recovery</h4>
    <p class="text-muted small">Diagnostic Laboratory Access Control</p>
  </div>

  <div class="alert alert-info text-start small mb-4">
    <i class="fas fa-info-circle me-1"></i>
    For patient confidentiality and data integrity compliance, diagnostic portal credentials are centrally managed by your <strong>Lab Administrator</strong> and <strong>Super Admin</strong>.
  </div>

  <div class="card bg-light border-0 rounded-3 p-3 mb-4 text-start small">
    <div class="fw-semibold text-dark mb-2"><i class="fas fa-key text-warning me-2"></i> How to reset your credentials:</div>
    <ol class="ps-3 mb-0 text-muted">
      <li class="mb-1">Contact your <strong>Chief Lab Pathologist</strong> or <strong>Administrator</strong>.</li>
      <li class="mb-1">Administrators can update credentials inside <strong>Staff &amp; User Management</strong>.</li>
      <li>For Primary Lab Administrator accounts, passwords can be reset via the <strong>Super Admin Console</strong>.</li>
    </ol>
  </div>

  <a href="login.php" class="btn btn-primary w-100 py-2 rounded-3 fw-semibold shadow-sm">
    <i class="fas fa-arrow-left me-1"></i> Return to Login Screen
  </a>
</div>

</body>
</html>
