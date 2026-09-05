<?php
/**
 * Super Admin Renewals & Subscription Management
 */
$page_title = "Renewals & Trials";
require_once __DIR__ . '/header.php';
require_once __DIR__ . '/provision_helper.php';

$message = '';
$error = '';

// Handle quick extension action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['extend_vendor_id'])) {
    $vid = (int)$_POST['extend_vendor_id'];
    $extension_type = $_POST['extension_type'] ?? '';
    
    if ($vid > 0 && $conn) {
        $stmt = $conn->prepare("SELECT due_date, name FROM vendor_master WHERE vendor_id = ?");
        $stmt->bind_param("i", $vid);
        $stmt->execute();
        $lab = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if ($lab) {
            $current_due = !empty($lab['due_date']) && strtotime($lab['due_date']) > time() 
                           ? $lab['due_date'] 
                           : date('Y-m-d');
            
            $new_due = match($extension_type) {
                '15d'  => date('Y-m-d', strtotime($current_due . ' +15 days')),
                '30d'  => date('Y-m-d', strtotime($current_due . ' +30 days')),
                '90d'  => date('Y-m-d', strtotime($current_due . ' +90 days')),
                '365d' => date('Y-m-d', strtotime($current_due . ' +365 days')),
                'custom' => !empty($_POST['custom_date']) ? $_POST['custom_date'] : $current_due,
                default => date('Y-m-d', strtotime($current_due . ' +30 days'))
            };

            $up = $conn->prepare("UPDATE vendor_master SET due_date = ?, status = 'active' WHERE vendor_id = ?");
            $up->bind_param("si", $new_due, $vid);
            if ($up->execute()) {
                $message = "Subscription for <strong>" . htmlspecialchars($lab['name']) . "</strong> extended to <strong>" . date('d-M-Y', strtotime($new_due)) . "</strong> and account activated!";
            } else {
                $error = "Failed to update validity: " . $conn->error;
            }
            $up->close();
        }
    }
}

// Fetch all labs
$labs = [];
if ($conn && !$conn->connect_error) {
    $res = $conn->query("SELECT * FROM vendor_master WHERE status != 'rejected' ORDER BY due_date ASC");
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $labs[] = $row;
        }
    }
}
?>

<div class="container-fluid px-4 py-4">

  <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
    <div>
      <h3 class="fw-bold mb-1 text-dark">Renewals & Trial Expiry Monitor</h3>
      <p class="text-muted small mb-0">Track subscription expiration dates, grant trial extensions, and renew diagnostic lab licenses.</p>
    </div>
    <div>
      <a href="payments.php?action=new" class="btn btn-success rounded-3 px-3 py-2 fw-semibold">
        <i class="fas fa-plus me-1"></i> Record Subscription Payment
      </a>
    </div>
  </div>

  <?php if ($message): ?>
    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 mb-4" role="alert">
      <i class="fas fa-check-circle fa-lg"></i>
      <div><?= $message ?></div>
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

  <div class="card-sa overflow-hidden">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light small text-muted">
          <tr>
            <th>LABORATORY</th>
            <th>CONTACT</th>
            <th>CURRENT EXPIRY DATE</th>
            <th>LICENSE STATUS</th>
            <th class="text-end" style="min-width: 280px;">QUICK EXTEND / RENEW</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($labs)): ?>
            <tr>
              <td colspan="5" class="text-center py-5 text-muted">No lab licenses registered yet.</td>
            </tr>
          <?php else: ?>
            <?php foreach ($labs as $lab): 
              $vid = (int)$lab['vendor_id'];
              $is_active = ($lab['status'] === 'active');
              $folder_slug = LabProvisioner::slugify($lab['name']);
              
              $days_left = null;
              if (!empty($lab['due_date'])) {
                  $due_ts = strtotime($lab['due_date']);
                  $days_left = (int)ceil(($due_ts - time()) / 86400);
              }
            ?>
              <tr>
                <td>
                  <div class="fw-bold text-dark fs-6"><?= htmlspecialchars($lab['name']) ?></div>
                  <div class="small text-muted font-monospace"><i class="fas fa-folder fa-xs me-1"></i> /<?= htmlspecialchars($folder_slug) ?></div>
                </td>
                <td class="small">
                  <div><i class="fas fa-phone fa-xs text-muted me-1"></i> <?= htmlspecialchars($lab['phone'] ?? '-') ?></div>
                  <div class="text-muted"><i class="fas fa-envelope fa-xs text-muted me-1"></i> <?= htmlspecialchars($lab['email'] ?? '-') ?></div>
                </td>
                <td>
                  <?php if (!empty($lab['due_date'])): ?>
                    <div class="fw-bold text-dark"><?= date('d-M-Y', strtotime($lab['due_date'])) ?></div>
                    <?php if ($days_left !== null): ?>
                      <?php if ($days_left > 14): ?>
                        <span class="badge bg-success bg-opacity-10 text-success fw-semibold">
                          <?= $days_left ?> days remaining
                        </span>
                      <?php elseif ($days_left >= 0): ?>
                        <span class="badge bg-warning bg-opacity-25 text-warning-emphasis fw-bold">
                          Expires in <?= $days_left ?> days!
                        </span>
                      <?php else: ?>
                        <span class="badge bg-danger bg-opacity-10 text-danger fw-bold">
                          Expired (<?= abs($days_left) ?> days ago)
                        </span>
                      <?php endif; ?>
                    <?php endif; ?>
                  <?php else: ?>
                    <span class="badge bg-secondary">No Due Date Set</span>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if ($is_active && $days_left !== null && $days_left >= 0): ?>
                    <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i> Active License</span>
                  <?php else: ?>
                    <span class="badge bg-danger"><i class="fas fa-exclamation-triangle me-1"></i> Expired / Inactive</span>
                  <?php endif; ?>
                </td>
                <td class="text-end">
                  <form method="POST" action="renewals.php" class="d-inline-flex align-items-center gap-1">
                    <input type="hidden" name="extend_vendor_id" value="<?= $vid ?>">
                    
                    <button type="submit" name="extension_type" value="15d" class="btn btn-outline-info btn-sm fw-semibold" title="Extend trial by 15 days">
                      +15d
                    </button>
                    <button type="submit" name="extension_type" value="30d" class="btn btn-outline-primary btn-sm fw-semibold" title="Add 1 month renewal">
                      +1 Month
                    </button>
                    <button type="submit" name="extension_type" value="365d" class="btn btn-outline-success btn-sm fw-semibold" title="Add 1 year renewal">
                      +1 Year
                    </button>

                    <a href="lab_edit.php?id=<?= $vid ?>" class="btn btn-outline-secondary btn-sm" title="Custom Date">
                      <i class="fas fa-calendar-alt"></i>
                    </a>
                  </form>
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
