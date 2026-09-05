<?php
/**
 * Pending Lab Registrations & Auto-Provisioning Queue
 */
$page_title = "Pending Approvals";
require_once __DIR__ . '/header.php';
require_once __DIR__ . '/provision_helper.php';

$message = '';
$error = '';

// Handle Rejection
if (isset($_POST['action']) && $_POST['action'] === 'reject') {
    $vendor_id = (int)($_POST['vendor_id'] ?? 0);
    if ($vendor_id > 0 && $conn) {
        $stmt = $conn->prepare("UPDATE vendor_master SET status = 'rejected', remarks = 'Rejected by Super Admin on " . date('Y-m-d H:i') . "' WHERE vendor_id = ?");
        $stmt->bind_param("i", $vendor_id);
        $stmt->execute();
        $stmt->close();
        $message = "Registration request #{$vendor_id} has been rejected.";
    }
}

// Fetch all pending requests
$pending_requests = [];
if ($conn && !$conn->connect_error) {
    $res = $conn->query("SELECT * FROM vendor_master WHERE status = 'pending' ORDER BY vendor_id DESC");
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $pending_requests[] = $row;
        }
    }
}

$highlight_id = (int)($_GET['approve_id'] ?? 0);
?>

<div class="container-fluid px-4 py-4">

  <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
    <div>
      <h3 class="fw-bold mb-1 text-dark">Pending Lab Approvals</h3>
      <p class="text-muted small mb-0">Review interested diagnostic laboratories, verify applicant information, and provision dedicated SaaS instances.</p>
    </div>
    <div>
      <a href="labs_manage.php" class="btn btn-outline-primary rounded-3 px-3 py-2 fw-semibold">
        <i class="fas fa-list me-1"></i> View Operating Labs
      </a>
    </div>
  </div>

  <?php if ($message): ?>
    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 mb-4" role="alert">
      <i class="fas fa-check-circle fa-lg"></i>
      <div><?= htmlspecialchars($message) ?></div>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>

  <?php if ($error): ?>
    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2 mb-4" role="alert">
      <i class="fas fa-exclamation-circle fa-lg"></i>
      <div><?= htmlspecialchars($error) ?></div>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>

  <?php if (empty($pending_requests)): ?>
    <div class="card-sa p-5 text-center my-4">
      <div class="kpi-icon-box bg-success bg-opacity-10 text-success mx-auto mb-3" style="width: 72px; height: 72px; font-size: 2rem;">
        <i class="fas fa-check-double"></i>
      </div>
      <h4 class="fw-bold text-dark">All Clear! No Pending Approvals</h4>
      <p class="text-muted small mb-3">All laboratory registration requests have been approved or processed.</p>
      <a href="labs_manage.php" class="btn btn-primary px-4 py-2 rounded-3 fw-semibold">
        Manage Active Labs <i class="fas fa-arrow-right ms-1"></i>
      </a>
    </div>
  <?php else: ?>

    <div class="row g-4">
      <?php foreach ($pending_requests as $req): 
        $vid = (int)$req['vendor_id'];
        $suggested_slug = LabProvisioner::slugify($req['name']);
        $suggested_db   = 'lab_' . $suggested_slug;
        $suggested_user = !empty($req['vendor_userid']) ? $req['vendor_userid'] : 'admin_' . $suggested_slug;
        $suggested_pass = !empty($req['password']) ? $req['password'] : 'Lab@' . rand(1000, 9999);
        $is_highlighted = ($highlight_id === $vid);
      ?>
        <div class="col-lg-6">
          <div class="card-sa h-100 <?= $is_highlighted ? 'border-primary shadow' : '' ?>">
            
            <div class="p-3 border-bottom d-flex align-items-center justify-content-between bg-light rounded-top-4">
              <div class="d-flex align-items-center gap-2">
                <div class="p-2 bg-primary bg-opacity-10 text-primary rounded-3">
                  <i class="fas fa-hospital-user"></i>
                </div>
                <div>
                  <h5 class="fw-bold text-dark mb-0"><?= htmlspecialchars($req['name']) ?></h5>
                  <span class="small text-muted font-monospace">Application #<?= $vid ?> &bull; <?= date('d-M-Y h:i A', strtotime($req['created_at'])) ?></span>
                </div>
              </div>
              <span class="badge bg-warning bg-opacity-25 text-warning-emphasis fw-bold px-3 py-2 rounded-pill">
                <i class="fas fa-hourglass-half me-1"></i> Pending Review
              </span>
            </div>

            <div class="p-4">
              <div class="row g-3 mb-4">
                <div class="col-sm-6">
                  <span class="text-muted small d-block">Requested User ID</span>
                  <span class="fw-bold text-dark"><?= htmlspecialchars($req['vendor_userid'] ?? 'Not specified') ?></span>
                </div>
                <div class="col-sm-6">
                  <span class="text-muted small d-block">Phone Number</span>
                  <span class="fw-bold text-dark"><i class="fas fa-phone fa-xs text-primary me-1"></i> <?= htmlspecialchars($req['phone'] ?? '-') ?></span>
                </div>
                <div class="col-sm-6">
                  <span class="text-muted small d-block">Email Address</span>
                  <span class="fw-bold text-dark"><i class="fas fa-envelope fa-xs text-primary me-1"></i> <?= htmlspecialchars($req['email'] ?? '-') ?></span>
                </div>
                <div class="col-sm-6">
                  <span class="text-muted small d-block">Location / Pincode</span>
                  <span class="fw-bold text-dark"><?= htmlspecialchars($req['address'] ?? '') ?> - <?= htmlspecialchars($req['pincode'] ?? '') ?></span>
                </div>
              </div>

              <!-- Provisioning Configuration Form -->
              <form method="POST" action="approve_action.php" class="p-3 bg-light rounded-3 border">
                <input type="hidden" name="vendor_id" value="<?= $vid ?>">
                
                <h6 class="fw-bold text-dark mb-3"><i class="fas fa-cogs text-primary me-2"></i> Auto-Provisioning Setup</h6>
                
                <div class="row g-2 mb-3">
                  <div class="col-sm-6">
                    <label class="form-label small fw-semibold text-muted mb-1">Folder Slug (URL)</label>
                    <div class="input-group input-group-sm">
                      <span class="input-group-text bg-white">/</span>
                      <input type="text" name="folder_slug" class="form-control" value="<?= htmlspecialchars($suggested_slug) ?>" required pattern="[a-zA-Z0-9_\-]+" title="Alphanumeric and underscores only">
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <label class="form-label small fw-semibold text-muted mb-1">Database Name</label>
                    <input type="text" name="db_name" class="form-control form-control-sm" value="<?= htmlspecialchars($suggested_db) ?>" required>
                  </div>
                </div>

                <div class="row g-2 mb-3">
                  <div class="col-sm-6">
                    <label class="form-label small fw-semibold text-muted mb-1">Admin Username</label>
                    <input type="text" name="admin_username" class="form-control form-control-sm" value="<?= htmlspecialchars($suggested_user) ?>" required>
                  </div>
                  <div class="col-sm-6">
                    <label class="form-label small fw-semibold text-muted mb-1">Admin Password</label>
                    <input type="text" name="admin_password" class="form-control form-control-sm font-monospace" value="<?= htmlspecialchars($suggested_pass) ?>" required>
                  </div>
                </div>

                <div class="row g-2 mb-3">
                  <div class="col-sm-6">
                    <label class="form-label small fw-semibold text-muted mb-1">Trial Validity</label>
                    <select name="trial_days" class="form-select form-select-sm">
                      <option value="14" selected>14 Days Free Trial</option>
                      <option value="30">30 Days (1 Month)</option>
                      <option value="60">60 Days (2 Months)</option>
                      <option value="365">1 Year Subscription</option>
                    </select>
                  </div>
                  <div class="col-sm-6 d-flex align-items-end">
                    <button type="submit" class="btn btn-success btn-sm w-100 fw-bold py-2 rounded-2">
                      <i class="fas fa-check-circle me-1"></i> Approve & Deploy Lab
                    </button>
                  </div>
                </div>
              </form>

              <!-- Discard / Reject Button -->
              <div class="mt-3 text-end">
                <form method="POST" action="labs_pending.php" onsubmit="return confirm('Are you sure you want to reject and discard this registration request?');" class="d-inline">
                  <input type="hidden" name="action" value="reject">
                  <input type="hidden" name="vendor_id" value="<?= $vid ?>">
                  <button type="submit" class="btn btn-link text-danger text-decoration-none small p-0">
                    <i class="fas fa-times me-1"></i> Reject & Discard Request
                  </button>
                </form>
              </div>

            </div>

          </div>
        </div>
      <?php endforeach; ?>
    </div>

  <?php endif; ?>

</div>

<?php require_once __DIR__ . '/footer.php'; ?>
