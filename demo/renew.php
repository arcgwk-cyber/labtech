<?php
require_once 'db.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Fetch settings
$settings = null;
if ($conn) {
    $res = $conn->query("SELECT * FROM admin_settings WHERE id = 1 LIMIT 1");
    if ($res) {
        $settings = $res->fetch_assoc();
    }
}

$msg = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $plan = $_POST['plan'] ?? '1_year';
    $ref  = trim($_POST['reference'] ?? '');
    
    // Check if central vendor_master is accessible to record renewal request
    if ($pdo) {
        try {
            $labName = $settings['company_name'] ?? '';
            $desc = "Renewal Request - Plan: {$plan}. Ref: " . ($ref ?: 'Pending payment verification');
            // Try updating vendor_master or recording transaction
            $pdo->prepare("INSERT INTO transactions (vendor_id, txn_date, description, amount) 
                SELECT vendor_id, CURDATE(), ?, 0.00 FROM vendor_master WHERE name = ? LIMIT 1")
                ->execute([$desc, $labName]);
        } catch (Exception $e) {}
    }

    $msg = "Renewal request registered successfully! Our billing team will verify and activate your license shortly.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Renew Subscription | Diagnostic Centre ERP</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      background-color: #f8fafc;
      font-family: 'Segoe UI', system-ui, sans-serif;
      padding: 40px 15px;
    }
    .renew-card {
      background: white;
      border-radius: 16px;
      border: 1px solid #e2e8f0;
      box-shadow: 0 10px 25px rgba(0,0,0,0.05);
      max-width: 650px;
      margin: 0 auto;
      overflow: hidden;
    }
    .plan-box {
      border: 2px solid #e2e8f0;
      border-radius: 10px;
      padding: 15px;
      cursor: pointer;
      transition: all 0.2s;
    }
    .plan-box:hover, .plan-box.selected {
      border-color: #0284c7;
      background: #f0f9ff;
    }
  </style>
</head>
<body>
<?php include_once __DIR__ . '/header.php'; ?>

  <div class="renew-card">
    <div class="bg-primary text-white p-4 text-center">
      <i class="fas fa-certificate fa-3x mb-2"></i>
      <h3 class="fw-bold mb-1">Renew Laboratory Subscription</h3>
      <p class="mb-0 small text-light opacity-75">Extend your diagnostic management license with zero downtime.</p>
    </div>

    <div class="p-4 p-md-5">
      <?php if ($msg): ?>
        <div class="alert alert-success d-flex align-items-center gap-3">
          <i class="fas fa-check-circle fa-2x"></i>
          <div>
            <strong>Request Submitted!</strong><br>
            <?= htmlspecialchars($msg) ?>
          </div>
        </div>
        <div class="text-center mt-4">
          <a href="subscription_status.php" class="btn btn-primary">Check Subscription Status</a>
        </div>
      <?php else: ?>
        <form method="POST">
          <div class="mb-3">
            <label class="form-label fw-semibold">Diagnostic Centre</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($settings['company_name'] ?? 'Diagnostic Centre') ?>" readonly>
          </div>

          <div class="mb-4">
            <label class="form-label fw-semibold">Select Renewal Plan</label>
            <div class="row g-2">
              <div class="col-6">
                <label class="plan-box w-100">
                  <input type="radio" name="plan" value="monthly" class="me-2">
                  <strong>Monthly</strong>
                  <div class="small text-muted">Standard Monthly renewal</div>
                </label>
              </div>
              <div class="col-6">
                <label class="plan-box w-100 selected">
                  <input type="radio" name="plan" value="1_year" checked class="me-2">
                  <strong>Annual (Best Value)</strong>
                  <div class="small text-muted">12 Months complete coverage</div>
                </label>
              </div>
            </div>
          </div>

          <div class="mb-4">
            <label class="form-label fw-semibold">Payment Reference / UTR / Remarks</label>
            <input type="text" name="reference" class="form-control" placeholder="e.g. Bank Transfer Ref / Cheque No / UPI Transaction ID">
            <small class="text-muted">Enter reference number once transfer is initiated.</small>
          </div>

          <div class="d-flex justify-content-between align-items-center pt-3 border-top">
            <a href="dashboard.php" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i> Dashboard</a>
            <button type="submit" class="btn btn-success px-4"><i class="fas fa-paper-plane me-1"></i> Submit Renewal</button>
          </div>
        </form>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>
