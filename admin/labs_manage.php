<?php
/**
 * Master Labs Management Directory
 * Activate / Deactivate, view/edit credentials, inspect portal, manage validity.
 */
$page_title = "Manage Labs";
require_once __DIR__ . '/header.php';
require_once __DIR__ . '/provision_helper.php';

$search = trim($_GET['search'] ?? '');
$status_filter = trim($_GET['status'] ?? 'all');

$where = ["1=1"];
$params = [];
$types = "";

if (!empty($search)) {
    $where[] = "(name LIKE ? OR vendor_userid LIKE ? OR phone LIKE ? OR email LIKE ?)";
    $s = "%{$search}%";
    $params[] = $s; $params[] = $s; $params[] = $s; $params[] = $s;
    $types .= "ssss";
}

if ($status_filter !== 'all') {
    $where[] = "status = ?";
    $params[] = $status_filter;
    $types .= "s";
}

$whereClause = implode(" AND ", $where);
$sql = "SELECT * FROM vendor_master WHERE {$whereClause} ORDER BY vendor_id DESC";

$labs = [];
if ($conn && !$conn->connect_error) {
    if (!empty($params)) {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $res = $stmt->get_result();
    } else {
        $res = $conn->query($sql);
    }
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $labs[] = $row;
        }
    }
}
?>

<div class="container-fluid px-4 py-4">

  <!-- Title & Actions -->
  <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
    <div>
      <h3 class="fw-bold mb-1 text-dark">Diagnostic Laboratories Directory</h3>
      <p class="text-muted small mb-0">Control tenant lab status, view/reset administrator passwords, manage subscriptions, and access instances.</p>
    </div>
    <div class="d-flex align-items-center gap-2">
      <a href="labs_pending.php" class="btn btn-outline-danger rounded-3 px-3 py-2 fw-semibold">
        <i class="fas fa-clock me-1"></i> Pending Queue
        <?php if ($pending_count > 0): ?>
          <span class="badge bg-danger ms-1"><?= $pending_count ?></span>
        <?php endif; ?>
      </a>
      <a href="renewals.php" class="btn btn-outline-primary rounded-3 px-3 py-2 fw-semibold">
        <i class="fas fa-calendar-check me-1"></i> Renewals Monitor
      </a>
    </div>
  </div>

  <!-- Search & Filter Card -->
  <div class="card-sa p-3 mb-4">
    <form method="GET" action="labs_manage.php" class="row g-2 align-items-center">
      <div class="col-md-5">
        <div class="input-group input-group-sm">
          <span class="input-group-text bg-light"><i class="fas fa-search text-muted"></i></span>
          <input type="text" name="search" class="form-control" placeholder="Search by Lab Name, User ID, Mobile or Email..." value="<?= htmlspecialchars($search) ?>">
        </div>
      </div>
      <div class="col-md-3">
        <select name="status" class="form-select form-select-sm">
          <option value="all" <?= $status_filter === 'all' ? 'selected' : '' ?>>All Account Statuses</option>
          <option value="active" <?= $status_filter === 'active' ? 'selected' : '' ?>>Active Only</option>
          <option value="inactive" <?= $status_filter === 'inactive' ? 'selected' : '' ?>>Suspended / Inactive</option>
          <option value="pending" <?= $status_filter === 'pending' ? 'selected' : '' ?>>Pending Review</option>
        </select>
      </div>
      <div class="col-md-4 d-flex gap-2">
        <button type="submit" class="btn btn-primary btn-sm px-3 rounded-2 fw-semibold">
          <i class="fas fa-filter me-1"></i> Filter
        </button>
        <?php if (!empty($search) || $status_filter !== 'all'): ?>
          <a href="labs_manage.php" class="btn btn-light btn-sm px-3 rounded-2 text-muted">
            <i class="fas fa-undo me-1"></i> Clear
          </a>
        <?php endif; ?>
      </div>
    </form>
  </div>

  <!-- Labs Table -->
  <div class="card-sa overflow-hidden">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light small text-muted">
          <tr>
            <th style="width: 50px;">#</th>
            <th>LAB / DIAGNOSTIC CENTRE</th>
            <th>ADMIN LOGIN CREDENTIALS</th>
            <th>CONTACT DETAILS</th>
            <th>SUBSCRIPTION / DUE DATE</th>
            <th>STATUS</th>
            <th class="text-end" style="min-width: 180px;">ACTIONS</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($labs)): ?>
            <tr>
              <td colspan="7" class="text-center py-5 text-muted">
                <i class="fas fa-search fa-2x mb-2 text-secondary opacity-50"></i>
                <div>No diagnostic labs matched your filter criteria.</div>
              </td>
            </tr>
          <?php else: ?>
            <?php foreach ($labs as $lab): 
              $vid = (int)$lab['vendor_id'];
              $is_active = ($lab['status'] === 'active');
              $is_pending = ($lab['status'] === 'pending');
              $folder_slug = LabProvisioner::slugify($lab['name']);
              
              $days_left = null;
              if (!empty($lab['due_date'])) {
                  $due_ts = strtotime($lab['due_date']);
                  $days_left = (int)ceil(($due_ts - time()) / 86400);
              }
            ?>
              <tr>
                <td class="text-muted small font-monospace"><?= $vid ?></td>
                <td>
                  <div class="fw-bold text-dark fs-6"><?= htmlspecialchars($lab['name']) ?></div>
                  <div class="small text-muted font-monospace"><i class="fas fa-folder fa-xs text-secondary me-1"></i> /<?= htmlspecialchars($folder_slug) ?></div>
                </td>
                <td>
                  <div class="small fw-semibold text-dark"><i class="fas fa-user fa-xs text-primary me-1"></i> <?= htmlspecialchars($lab['vendor_userid'] ?? 'admin') ?></div>
                  <div class="small text-muted font-monospace"><i class="fas fa-key fa-xs text-warning me-1"></i> <?= htmlspecialchars($lab['password'] ?? '••••••') ?></div>
                </td>
                <td class="small">
                  <div><i class="fas fa-phone fa-xs text-muted me-1"></i> <?= htmlspecialchars($lab['phone'] ?? '-') ?></div>
                  <div class="text-muted"><i class="fas fa-envelope fa-xs text-muted me-1"></i> <?= htmlspecialchars($lab['email'] ?? '-') ?></div>
                </td>
                <td>
                  <?php if (!empty($lab['due_date'])): ?>
                    <div class="fw-semibold small text-dark"><?= date('d-M-Y', strtotime($lab['due_date'])) ?></div>
                    <?php if ($days_left !== null): ?>
                      <?php if ($days_left > 7): ?>
                        <span class="badge bg-success bg-opacity-10 text-success fw-semibold">
                          <?= $days_left ?> days active
                        </span>
                      <?php elseif ($days_left >= 0): ?>
                        <span class="badge bg-warning bg-opacity-20 text-warning-emphasis fw-bold">
                          Expires in <?= $days_left ?>d
                        </span>
                      <?php else: ?>
                        <span class="badge bg-danger bg-opacity-10 text-danger fw-bold">
                          Expired <?= abs($days_left) ?>d ago
                        </span>
                      <?php endif; ?>
                    <?php endif; ?>
                  <?php else: ?>
                    <span class="text-muted small">No Due Date</span>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if ($is_pending): ?>
                    <span class="badge bg-warning text-dark"><i class="fas fa-clock me-1"></i> Pending</span>
                  <?php elseif ($is_active): ?>
                    <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i> Active</span>
                  <?php else: ?>
                    <span class="badge bg-danger bg-opacity-75"><i class="fas fa-ban me-1"></i> Suspended</span>
                  <?php endif; ?>
                </td>
                <td class="text-end">
                  <div class="btn-group btn-group-sm">
                    
                    <?php if ($is_pending): ?>
                      <a href="labs_pending.php?approve_id=<?= $vid ?>" class="btn btn-sm btn-success fw-semibold px-2">
                        <i class="fas fa-check me-1"></i> Approve
                      </a>
                    <?php else: ?>
                      <!-- 1-Click Toggle Active / Inactive -->
                      <a href="lab_toggle_status.php?id=<?= $vid ?>&csrf=<?= md5($vid . 'sa_salt') ?>" 
                         class="btn btn-<?= $is_active ? 'outline-warning' : 'outline-success' ?>" 
                         title="<?= $is_active ? 'Suspend / Deactivate Lab Access' : 'Activate Lab Access' ?>"
                         onclick="return confirm('Do you want to <?= $is_active ? 'SUSPEND' : 'ACTIVATE' ?> access for <?= addslashes($lab['name']) ?>?');">
                        <i class="fas fa-power-off"></i> <?= $is_active ? 'Suspend' : 'Activate' ?>
                      </a>

                      <!-- Open Portal -->
                      <a href="../<?= htmlspecialchars($folder_slug) ?>/login.php" target="_blank" class="btn btn-outline-primary" title="Open Lab Login Screen">
                        <i class="fas fa-external-link-alt"></i> Portal
                      </a>

                      <!-- Edit Details / Password -->
                      <a href="lab_edit.php?id=<?= $vid ?>" class="btn btn-outline-secondary" title="Edit Lab Details & Reset Password">
                        <i class="fas fa-edit"></i>
                      </a>
                    <?php endif; ?>

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

<?php require_once __DIR__ . '/footer.php'; ?>
