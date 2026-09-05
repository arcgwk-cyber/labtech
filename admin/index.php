<?php
/**
 * Super Admin Master Dashboard
 */
$page_title = "Executive Dashboard";
require_once __DIR__ . '/header.php';

// Auto-check expired active vendors and update to inactive
if ($conn && !$conn->connect_error) {
    $conn->query("UPDATE vendor_master SET status = 'inactive' WHERE due_date < CURDATE() AND status = 'active'");
}

// 1. Fetch Metrics
$total_labs     = 0;
$pending_labs   = 0;
$active_labs    = 0;
$inactive_labs  = 0;
$expiring_soon  = 0;
$total_revenue  = 0.00;

if ($conn && !$conn->connect_error) {
    // Total Labs
    $r = $conn->query("SELECT COUNT(*) as c FROM vendor_master");
    $total_labs = (int)($r->fetch_assoc()['c'] ?? 0);

    // Pending
    $r = $conn->query("SELECT COUNT(*) as c FROM vendor_master WHERE status = 'pending'");
    $pending_labs = (int)($r->fetch_assoc()['c'] ?? 0);

    // Active
    $r = $conn->query("SELECT COUNT(*) as c FROM vendor_master WHERE status = 'active'");
    $active_labs = (int)($r->fetch_assoc()['c'] ?? 0);

    // Inactive
    $r = $conn->query("SELECT COUNT(*) as c FROM vendor_master WHERE status IN ('inactive', 'rejected')");
    $inactive_labs = (int)($r->fetch_assoc()['c'] ?? 0);

    // Expiring within 7 days
    $r = $conn->query("SELECT COUNT(*) as c FROM vendor_master WHERE status = 'active' AND due_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)");
    $expiring_soon = (int)($r->fetch_assoc()['c'] ?? 0);

    // Revenue
    $r = $conn->query("SELECT SUM(amount) as s FROM transactions");
    $total_revenue = (float)($r->fetch_assoc()['s'] ?? 0.00);
}

// 2. Fetch Pending Queue (Limit 5 for quick action)
$pending_list = [];
if ($conn && !$conn->connect_error) {
    $res = $conn->query("SELECT * FROM vendor_master WHERE status = 'pending' ORDER BY vendor_id DESC LIMIT 5");
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $pending_list[] = $row;
        }
    }
}

// 3. Fetch Recent Labs (Limit 8)
$recent_labs = [];
if ($conn && !$conn->connect_error) {
    $res = $conn->query("SELECT * FROM vendor_master WHERE status != 'pending' ORDER BY vendor_id DESC LIMIT 8");
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $recent_labs[] = $row;
        }
    }
}

// 4. Fetch Recent Payments
$recent_txns = [];
if ($conn && !$conn->connect_error) {
    $res = $conn->query("
        SELECT t.*, v.name as lab_name, v.vendor_userid 
        FROM transactions t 
        LEFT JOIN vendor_master v ON t.vendor_id = v.vendor_id 
        ORDER BY t.txn_id DESC LIMIT 5
    ");
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $recent_txns[] = $row;
        }
    }
}
?>

<div class="container-fluid px-4 py-4">

  <!-- Welcome Bar -->
  <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
    <div>
      <h3 class="fw-bold mb-1 text-dark">SaaS Command Center</h3>
      <p class="text-muted small mb-0">Multi-tenant laboratory operations, provisioning pipeline, and recurring billing monitor.</p>
    </div>
    <div class="d-flex align-items-center gap-2">
      <a href="labs_pending.php" class="btn btn-danger position-relative rounded-3 px-3 py-2 fw-semibold">
        <i class="fas fa-user-clock me-1"></i> Review Pending Approvals
        <?php if ($pending_labs > 0): ?>
          <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-dark">
            <?= $pending_labs ?>
          </span>
        <?php endif; ?>
      </a>
      <a href="labs_manage.php" class="btn btn-primary rounded-3 px-3 py-2 fw-semibold">
        <i class="fas fa-list me-1"></i> Manage All Labs
      </a>
    </div>
  </div>

  <!-- KPI Metrics Grid -->
  <div class="row g-3 mb-4">
    
    <!-- Total Labs -->
    <div class="col-sm-6 col-xl-2">
      <div class="card-sa p-3 h-100">
        <div class="d-flex align-items-center justify-content-between mb-2">
          <span class="text-muted small fw-bold text-uppercase">Total Labs</span>
          <div class="kpi-icon-box bg-primary bg-opacity-10 text-primary">
            <i class="fas fa-hospital"></i>
          </div>
        </div>
        <h3 class="fw-bold mb-0 text-dark"><?= $total_labs ?></h3>
        <span class="text-muted small">Registered clients</span>
      </div>
    </div>

    <!-- Pending Approvals -->
    <div class="col-sm-6 col-xl-2">
      <div class="card-sa p-3 h-100 border-<?= $pending_labs > 0 ? 'danger' : 'light' ?>">
        <div class="d-flex align-items-center justify-content-between mb-2">
          <span class="text-muted small fw-bold text-uppercase">Pending</span>
          <div class="kpi-icon-box bg-danger bg-opacity-10 text-danger">
            <i class="fas fa-hourglass-half"></i>
          </div>
        </div>
        <h3 class="fw-bold mb-0 text-danger"><?= $pending_labs ?></h3>
        <span class="text-muted small">Awaiting approval</span>
      </div>
    </div>

    <!-- Active Labs -->
    <div class="col-sm-6 col-xl-2">
      <div class="card-sa p-3 h-100">
        <div class="d-flex align-items-center justify-content-between mb-2">
          <span class="text-muted small fw-bold text-uppercase">Active Labs</span>
          <div class="kpi-icon-box bg-success bg-opacity-10 text-success">
            <i class="fas fa-check-circle"></i>
          </div>
        </div>
        <h3 class="fw-bold mb-0 text-success"><?= $active_labs ?></h3>
        <span class="text-muted small">Live & functioning</span>
      </div>
    </div>

    <!-- Inactive / Suspended -->
    <div class="col-sm-6 col-xl-2">
      <div class="card-sa p-3 h-100">
        <div class="d-flex align-items-center justify-content-between mb-2">
          <span class="text-muted small fw-bold text-uppercase">Suspended</span>
          <div class="kpi-icon-box bg-secondary bg-opacity-10 text-secondary">
            <i class="fas fa-ban"></i>
          </div>
        </div>
        <h3 class="fw-bold mb-0 text-secondary"><?= $inactive_labs ?></h3>
        <span class="text-muted small">Access locked</span>
      </div>
    </div>

    <!-- Expiring Soon -->
    <div class="col-sm-6 col-xl-2">
      <div class="card-sa p-3 h-100 border-<?= $expiring_soon > 0 ? 'warning' : 'light' ?>">
        <div class="d-flex align-items-center justify-content-between mb-2">
          <span class="text-muted small fw-bold text-uppercase">Expiring Soon</span>
          <div class="kpi-icon-box bg-warning bg-opacity-10 text-warning">
            <i class="fas fa-clock"></i>
          </div>
        </div>
        <h3 class="fw-bold mb-0 text-warning"><?= $expiring_soon ?></h3>
        <span class="text-muted small">Within 7 days</span>
      </div>
    </div>

    <!-- Revenue -->
    <div class="col-sm-6 col-xl-2">
      <div class="card-sa p-3 h-100">
        <div class="d-flex align-items-center justify-content-between mb-2">
          <span class="text-muted small fw-bold text-uppercase">Revenue</span>
          <div class="kpi-icon-box bg-info bg-opacity-10 text-info">
            <i class="fas fa-rupee-sign"></i>
          </div>
        </div>
        <h3 class="fw-bold mb-0 text-dark">₹<?= number_format($total_revenue, 0) ?></h3>
        <span class="text-muted small">Total collections</span>
      </div>
    </div>

  </div>

  <!-- Pending Approvals Alert Banner (if any) -->
  <?php if (!empty($pending_list)): ?>
    <div class="card-sa border-danger border-opacity-50 mb-4 overflow-hidden">
      <div class="p-3 bg-danger bg-opacity-10 border-bottom border-danger border-opacity-25 d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2">
          <i class="fas fa-bell text-danger fa-lg"></i>
          <h6 class="fw-bold text-danger mb-0">Action Required: <?= count($pending_list) ?> New Lab Registration(s) Pending Approval</h6>
        </div>
        <a href="labs_pending.php" class="btn btn-sm btn-danger fw-semibold px-3 rounded-2">
          Open Approval Queue <i class="fas fa-arrow-right ms-1"></i>
        </a>
      </div>
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light small text-muted">
            <tr>
              <th>LAB / CENTRE NAME</th>
              <th>APPLICANT</th>
              <th>CONTACT</th>
              <th>LOCATION</th>
              <th>REGISTERED</th>
              <th class="text-end">ACTION</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($pending_list as $pl): ?>
              <tr>
                <td class="fw-bold text-dark">
                  <i class="fas fa-clinic-medical text-primary me-2"></i>
                  <?= htmlspecialchars($pl['name']) ?>
                </td>
                <td><?= htmlspecialchars($pl['vendor_userid'] ?? 'N/A') ?></td>
                <td>
                  <div><i class="fas fa-phone fa-xs text-muted me-1"></i> <?= htmlspecialchars($pl['phone'] ?? '-') ?></div>
                  <div class="small text-muted"><i class="fas fa-envelope fa-xs text-muted me-1"></i> <?= htmlspecialchars($pl['email'] ?? '-') ?></div>
                </td>
                <td class="small"><?= htmlspecialchars($pl['address'] ?? '') ?> (<?= htmlspecialchars($pl['pincode'] ?? '') ?>)</td>
                <td class="small text-muted"><?= date('d-M-Y h:i A', strtotime($pl['created_at'])) ?></td>
                <td class="text-end">
                  <a href="labs_pending.php?approve_id=<?= $pl['vendor_id'] ?>" class="btn btn-sm btn-success fw-semibold px-3 rounded-2">
                    <i class="fas fa-check me-1"></i> Approve & Provision
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  <?php endif; ?>

  <div class="row g-4">
    
    <!-- Active Labs Directory Snapshot -->
    <div class="col-xl-8">
      <div class="card-sa h-100 overflow-hidden">
        <div class="p-3 border-bottom d-flex align-items-center justify-content-between">
          <div class="d-flex align-items-center gap-2">
            <i class="fas fa-hospital-user text-primary"></i>
            <h6 class="fw-bold mb-0">Operating Diagnostic Labs</h6>
          </div>
          <a href="labs_manage.php" class="small fw-semibold text-primary text-decoration-none">
            View All Labs (<?= $total_labs ?>) <i class="fas fa-chevron-right ms-1"></i>
          </a>
        </div>
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="table-light small text-muted">
              <tr>
                <th>LAB NAME</th>
                <th>ADMIN CREDENTIALS</th>
                <th>VALIDITY / DUE</th>
                <th>STATUS</th>
                <th class="text-end">ACTIONS</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($recent_labs)): ?>
                <tr>
                  <td colspan="5" class="text-center py-4 text-muted">
                    <i class="fas fa-folder-open fa-2x mb-2 text-secondary opacity-50"></i>
                    <div>No approved labs found yet. New registrations will appear here.</div>
                  </td>
                </tr>
              <?php else: ?>
                <?php foreach ($recent_labs as $lab): 
                  $is_active = ($lab['status'] === 'active');
                  $days_left = null;
                  if (!empty($lab['due_date'])) {
                      $due_ts = strtotime($lab['due_date']);
                      $days_left = (int)ceil(($due_ts - time()) / 86400);
                  }
                  $folder_slug = LabProvisioner::slugify($lab['name']);
                ?>
                  <tr>
                    <td>
                      <div class="fw-bold text-dark"><?= htmlspecialchars($lab['name']) ?></div>
                      <div class="small text-muted font-monospace">/<?= htmlspecialchars($folder_slug) ?></div>
                    </td>
                    <td>
                      <div class="small fw-semibold text-dark"><i class="fas fa-user fa-xs text-muted me-1"></i> <?= htmlspecialchars($lab['vendor_userid'] ?? 'admin') ?></div>
                      <div class="small text-muted font-monospace"><i class="fas fa-key fa-xs text-muted me-1"></i> <?= htmlspecialchars($lab['password'] ?? '••••••') ?></div>
                    </td>
                    <td>
                      <?php if ($days_left !== null): ?>
                        <?php if ($days_left > 7): ?>
                          <span class="badge bg-success bg-opacity-10 text-success fw-semibold">
                            <?= $days_left ?> days left
                          </span>
                        <?php elseif ($days_left >= 0): ?>
                          <span class="badge bg-warning bg-opacity-15 text-warning-emphasis fw-bold">
                            Expires in <?= $days_left ?> days
                          </span>
                        <?php else: ?>
                          <span class="badge bg-danger bg-opacity-10 text-danger fw-bold">
                            Expired (<?= abs($days_left) ?>d ago)
                          </span>
                        <?php endif; ?>
                        <div class="small text-muted mt-1"><?= date('d-M-Y', strtotime($lab['due_date'])) ?></div>
                      <?php else: ?>
                        <span class="badge bg-secondary">No Due Date</span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <?php if ($is_active): ?>
                        <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i> Active</span>
                      <?php else: ?>
                        <span class="badge bg-secondary"><i class="fas fa-pause-circle me-1"></i> Inactive</span>
                      <?php endif; ?>
                    </td>
                    <td class="text-end">
                      <div class="btn-group btn-group-sm">
                        <!-- 1-Click Toggle Active / Inactive -->
                        <a href="lab_toggle_status.php?id=<?= $lab['vendor_id'] ?>&csrf=<?= md5($lab['vendor_id'] . 'sa_salt') ?>" 
                           class="btn btn-outline-<?= $is_active ? 'warning' : 'success' ?>" 
                           title="<?= $is_active ? 'Deactivate / Suspend Access' : 'Activate Access' ?>"
                           onclick="return confirm('Are you sure you want to <?= $is_active ? 'DEACTIVATE' : 'ACTIVATE' ?> access for <?= addslashes($lab['name']) ?>?');">
                          <i class="fas fa-power-off"></i>
                        </a>
                        <!-- Open Portal -->
                        <a href="../<?= htmlspecialchars($folder_slug) ?>/login.php" target="_blank" class="btn btn-outline-primary" title="Open Lab Portal">
                          <i class="fas fa-external-link-alt"></i>
                        </a>
                        <!-- Manage / Edit -->
                        <a href="lab_edit.php?id=<?= $lab['vendor_id'] ?>" class="btn btn-outline-secondary" title="Edit Credentials & Validity">
                          <i class="fas fa-edit"></i>
                        </a>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Recent Payments & System Health -->
    <div class="col-xl-4">
      
      <!-- Payments Card -->
      <div class="card-sa mb-4 overflow-hidden">
        <div class="p-3 border-bottom d-flex align-items-center justify-content-between">
          <div class="d-flex align-items-center gap-2">
            <i class="fas fa-money-check-alt text-success"></i>
            <h6 class="fw-bold mb-0">Recent Payments</h6>
          </div>
          <a href="payments.php" class="small fw-semibold text-primary text-decoration-none">
            All Payments <i class="fas fa-chevron-right ms-1"></i>
          </a>
        </div>
        <div class="p-3">
          <?php if (empty($recent_txns)): ?>
            <div class="text-center py-4 text-muted">
              <i class="fas fa-receipt fa-2x mb-2 text-secondary opacity-50"></i>
              <div class="small">No transactions recorded yet.</div>
              <a href="payments.php?action=new" class="btn btn-sm btn-outline-primary mt-2 rounded-2">
                <i class="fas fa-plus me-1"></i> Record First Payment
              </a>
            </div>
          <?php else: ?>
            <ul class="list-group list-group-flush">
              <?php foreach ($recent_txns as $tx): ?>
                <li class="list-group-item px-0 py-2 d-flex align-items-center justify-content-between">
                  <div>
                    <div class="fw-bold text-dark small"><?= htmlspecialchars($tx['lab_name'] ?? 'Diagnostic Lab') ?></div>
                    <div class="small text-muted"><?= htmlspecialchars($tx['description'] ?? 'Subscription') ?> &bull; <?= date('d-M-Y', strtotime($tx['txn_date'])) ?></div>
                  </div>
                  <div class="text-end">
                    <span class="fw-bold text-success">+₹<?= number_format($tx['amount'], 2) ?></span>
                  </div>
                </li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>
        </div>
      </div>

      <!-- System Engine Status -->
      <div class="card-sa p-3">
        <div class="d-flex align-items-center gap-2 mb-3">
          <i class="fas fa-server text-info"></i>
          <h6 class="fw-bold mb-0">Provisioning Blueprint Health</h6>
        </div>
        
        <?php
        $ws_root = dirname(__DIR__);
        $base_ok = is_dir($ws_root . '/base');
        $dump_ok = file_exists($ws_root . '/dump/diagnostic_lab_db.sql');
        $demo_ok = is_dir($ws_root . '/demo');
        ?>

        <div class="d-flex align-items-center justify-content-between p-2 mb-2 bg-light rounded-2 small">
          <span><i class="fas fa-layer-group text-primary me-2"></i> Base Blueprint Folder</span>
          <span class="badge bg-<?= $base_ok ? 'success' : 'danger' ?>"><?= $base_ok ? 'Ready (base/)' : 'Missing' ?></span>
        </div>
        <div class="d-flex align-items-center justify-content-between p-2 mb-2 bg-light rounded-2 small">
          <span><i class="fas fa-database text-warning me-2"></i> Clean Pathology SQL Dump</span>
          <span class="badge bg-<?= $dump_ok ? 'success' : 'danger' ?>"><?= $dump_ok ? 'Verified (NABL)' : 'Missing' ?></span>
        </div>
        <div class="d-flex align-items-center justify-content-between p-2 mb-2 bg-light rounded-2 small">
          <span><i class="fas fa-flask text-info me-2"></i> Demo Lab Instance</span>
          <span class="badge bg-<?= $demo_ok ? 'success' : 'danger' ?>"><?= $demo_ok ? 'Online (demo/)' : 'Missing' ?></span>
        </div>
        <div class="d-flex align-items-center justify-content-between p-2 bg-light rounded-2 small">
          <span><i class="fas fa-code-branch text-success me-2"></i> PHP Version</span>
          <span class="fw-semibold text-dark"><?= PHP_VERSION ?></span>
        </div>

      </div>

    </div>

  </div>

</div>

<?php require_once __DIR__ . '/footer.php'; ?>
