<?php
/**
 * Action Handler: Approve & Auto-Provision Diagnostic Lab
 */
$page_title = "Lab Provisioning Status";
require_once __DIR__ . '/header.php';
require_once __DIR__ . '/provision_helper.php';

$vendor_id      = (int)($_POST['vendor_id'] ?? 0);
$custom_slug    = trim($_POST['folder_slug'] ?? '');
$custom_db      = trim($_POST['db_name'] ?? '');
$admin_user     = trim($_POST['admin_username'] ?? '');
$admin_pass     = trim($_POST['admin_password'] ?? '');
$trial_days     = (int)($_POST['trial_days'] ?? 14);

$error = '';
$result = null;

if ($vendor_id <= 0) {
    $error = "Invalid vendor registration ID.";
} else {
    // 1. Fetch vendor data
    $stmt = $conn->prepare("SELECT * FROM vendor_master WHERE vendor_id = ? LIMIT 1");
    $stmt->bind_param("i", $vendor_id);
    $stmt->execute();
    $vendor = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$vendor) {
        $error = "Vendor application not found in database.";
    } else {
        // 2. Execute Automated Provisioning
        $result = LabProvisioner::provisionLab($vendor, $custom_slug, $custom_db, $admin_user, $admin_pass, $trial_days);

        if (!$result['success']) {
            $error = $result['error'];
        } else {
            // 3. Update vendor_master
            $update_stmt = $conn->prepare("
                UPDATE vendor_master 
                SET status = 'active', 
                    vendor_userid = ?, 
                    password = ?, 
                    due_date = ?, 
                    remarks = ? 
                WHERE vendor_id = ?
            ");
            $remarks = "Provisioned at /" . $result['folder_slug'] . " | DB: " . $result['db_name'];
            $update_stmt->bind_param("ssssi", 
                $result['admin_username'], 
                $result['admin_password'], 
                $result['due_date'], 
                $remarks, 
                $vendor_id
            );
            $update_stmt->execute();
            $update_stmt->close();
        }
    }
}
?>

<div class="container py-5" style="max-width: 760px;">

  <?php if ($error): ?>
    <div class="card-sa p-4 text-center border-danger">
      <div class="kpi-icon-box bg-danger bg-opacity-10 text-danger mx-auto mb-3" style="width: 64px; height: 64px;">
        <i class="fas fa-exclamation-triangle fa-lg"></i>
      </div>
      <h4 class="fw-bold text-dark">Provisioning Failed</h4>
      <p class="text-danger small mb-4"><?= htmlspecialchars($error) ?></p>
      <a href="labs_pending.php" class="btn btn-outline-secondary px-4 py-2 rounded-3 fw-semibold">
        <i class="fas fa-arrow-left me-1"></i> Back to Pending Queue
      </a>
    </div>
  <?php else: 
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
    $host = $_SERVER['HTTP_HOST'] ?? 'labs.vensaas.com';
    $parent_dir = rtrim(dirname(dirname($_SERVER['PHP_SELF'] ?? '/admin')), '/\\');
    $full_lab_url = "{$protocol}{$host}{$parent_dir}/" . $result['folder_slug'] . "/login.php";
  ?>
    <div class="card-sa p-4 p-sm-5 text-center border-success">
      <div class="kpi-icon-box bg-success bg-opacity-10 text-success mx-auto mb-3" style="width: 72px; height: 72px; font-size: 2rem;">
        <i class="fas fa-rocket"></i>
      </div>
      <span class="badge bg-success bg-opacity-10 text-success fw-bold text-uppercase px-3 py-1 mb-2">Deployed Successfully</span>
      <h3 class="fw-bold text-dark mb-1"><?= htmlspecialchars($vendor['name']) ?></h3>
      <p class="text-muted small mb-4">Dedicated lab database created, template cloned from base blueprint, and admin credentials initialized.</p>

      <!-- Credentials Card -->
      <div class="bg-light p-4 rounded-3 border text-start mb-4">
        <h6 class="fw-bold text-dark border-bottom pb-2 mb-3"><i class="fas fa-key text-primary me-2"></i> Tenant Access Credentials</h6>
        
        <div class="mb-2">
          <span class="text-muted small d-block">Lab Portal URL:</span>
          <a href="<?= htmlspecialchars($full_lab_url) ?>" target="_blank" class="fw-bold text-primary font-monospace text-break">
            <?= htmlspecialchars($full_lab_url) ?> <i class="fas fa-external-link-alt fa-xs ms-1"></i>
          </a>
        </div>

        <div class="row g-2 mb-2">
          <div class="col-sm-6">
            <span class="text-muted small d-block">Admin Username:</span>
            <span class="fw-bold text-dark font-monospace"><?= htmlspecialchars($result['admin_username']) ?></span>
          </div>
          <div class="col-sm-6">
            <span class="text-muted small d-block">Admin Password:</span>
            <span class="fw-bold text-dark font-monospace"><?= htmlspecialchars($result['admin_password']) ?></span>
          </div>
        </div>

        <div class="row g-2">
          <div class="col-sm-6">
            <span class="text-muted small d-block">Database Assigned:</span>
            <span class="text-secondary small font-monospace"><?= htmlspecialchars($result['db_name']) ?></span>
          </div>
          <div class="col-sm-6">
            <span class="text-muted small d-block">Trial Valid Until:</span>
            <span class="badge bg-success bg-opacity-15 text-success fw-bold"><?= date('d-M-Y', strtotime($result['due_date'])) ?></span>
          </div>
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="d-flex flex-column flex-sm-row justify-content-center gap-2">
        <a href="<?= htmlspecialchars($full_lab_url) ?>" target="_blank" class="btn btn-primary px-4 py-2 rounded-3 fw-bold">
          <i class="fas fa-sign-in-alt me-1"></i> Open Lab Portal Now
        </a>
        <a href="labs_manage.php" class="btn btn-outline-secondary px-4 py-2 rounded-3 fw-semibold">
          <i class="fas fa-list me-1"></i> Go to All Labs
        </a>
      </div>

    </div>
  <?php endif; ?>

</div>

<?php require_once __DIR__ . '/footer.php'; ?>
