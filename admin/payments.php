<?php
/**
 * Super Admin SaaS Payments & Subscription Revenue Ledger
 */
$page_title = "Payments & Revenue";
require_once __DIR__ . '/header.php';

$message = '';
$error = '';

// Handle Record Payment
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'record_payment') {
    $vendor_id   = (int)($_POST['vendor_id'] ?? 0);
    $amount      = (float)($_POST['amount'] ?? 0);
    $txn_date    = !empty($_POST['txn_date']) ? $_POST['txn_date'] : date('Y-m-d');
    $description = trim($_POST['description'] ?? 'Subscription Payment');
    $extend_days = (int)($_POST['extend_days'] ?? 0);

    if ($vendor_id <= 0 || $amount <= 0) {
        $error = "Please select a valid laboratory and enter an amount greater than 0.";
    } else {
        $stmt = $conn->prepare("INSERT INTO transactions (vendor_id, txn_date, description, amount) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("issd", $vendor_id, $txn_date, $description, $amount);
        if ($stmt->execute()) {
            $message = "Payment of <strong>₹" . number_format($amount, 2) . "</strong> recorded successfully!";
            
            // Auto extend if requested
            if ($extend_days > 0) {
                $v_stmt = $conn->prepare("SELECT due_date FROM vendor_master WHERE vendor_id = ?");
                $v_stmt->bind_param("i", $vendor_id);
                $v_stmt->execute();
                $v_row = $v_stmt->get_result()->fetch_assoc();
                $v_stmt->close();

                $curr = (!empty($v_row['due_date']) && strtotime($v_row['due_date']) > time()) 
                        ? $v_row['due_date'] 
                        : date('Y-m-d');
                $new_due = date('Y-m-d', strtotime($curr . " +{$extend_days} days"));

                $up = $conn->prepare("UPDATE vendor_master SET due_date = ?, payment = 'paid', status = 'active' WHERE vendor_id = ?");
                $up->bind_param("si", $new_due, $vendor_id);
                $up->execute();
                $up->close();
                $message .= " Lab subscription automatically extended to <strong>" . date('d-M-Y', strtotime($new_due)) . "</strong>.";
            }
        } else {
            $error = "Failed to record transaction: " . $conn->error;
        }
        $stmt->close();
    }
}

// Fetch all transactions
$txns = [];
$total_collected = 0.00;
if ($conn && !$conn->connect_error) {
    $res = $conn->query("
        SELECT t.*, v.name as lab_name, v.vendor_userid, v.phone 
        FROM transactions t 
        LEFT JOIN vendor_master v ON t.vendor_id = v.vendor_id 
        ORDER BY t.txn_id DESC
    ");
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $txns[] = $row;
            $total_collected += (float)$row['amount'];
        }
    }
}

// Fetch labs for dropdown
$vendor_dropdown = [];
if ($conn && !$conn->connect_error) {
    $vres = $conn->query("SELECT vendor_id, name, vendor_userid FROM vendor_master WHERE status != 'rejected' ORDER BY name ASC");
    if ($vres) {
        while ($v = $vres->fetch_assoc()) {
            $vendor_dropdown[] = $v;
        }
    }
}
?>

<div class="container-fluid px-4 py-4">

  <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
    <div>
      <h3 class="fw-bold mb-1 text-dark">SaaS Payments & Financial Ledger</h3>
      <p class="text-muted small mb-0">Record subscription fees, track laboratory renewals, and monitor multi-tenant recurring revenue.</p>
    </div>
    <div class="d-flex align-items-center gap-3">
      <div class="px-3 py-2 bg-success bg-opacity-10 rounded-3 text-success border border-success border-opacity-25">
        <span class="small fw-semibold text-uppercase d-block">Total Collections</span>
        <h4 class="fw-bold mb-0">₹<?= number_format($total_collected, 2) ?></h4>
      </div>
      <button type="button" class="btn btn-primary rounded-3 px-3 py-2 fw-semibold" data-bs-toggle="modal" data-bs-target="#recordPaymentModal">
        <i class="fas fa-plus me-1"></i> Record Payment
      </button>
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
            <th style="width: 80px;">TXN #</th>
            <th>DATE</th>
            <th>LABORATORY</th>
            <th>PAYMENT DESCRIPTION / MODE</th>
            <th class="text-end">AMOUNT</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($txns)): ?>
            <tr>
              <td colspan="5" class="text-center py-5 text-muted">
                <i class="fas fa-receipt fa-2x mb-2 text-secondary opacity-50"></i>
                <div>No payments recorded yet. Click "Record Payment" to log revenue.</div>
              </td>
            </tr>
          <?php else: ?>
            <?php foreach ($txns as $tx): ?>
              <tr>
                <td class="font-monospace fw-semibold text-muted">#<?= $tx['txn_id'] ?></td>
                <td><?= date('d-M-Y', strtotime($tx['txn_date'])) ?></td>
                <td>
                  <div class="fw-bold text-dark"><?= htmlspecialchars($tx['lab_name'] ?? 'Unknown Lab') ?></div>
                  <div class="small text-muted font-monospace"><i class="fas fa-user fa-xs me-1"></i> <?= htmlspecialchars($tx['vendor_userid'] ?? '') ?></div>
                </td>
                <td>
                  <span class="badge bg-light text-dark border px-2 py-1">
                    <i class="fas fa-tag text-primary me-1"></i>
                    <?= htmlspecialchars($tx['description'] ?? 'Subscription') ?>
                  </span>
                </td>
                <td class="text-end fw-bold text-success fs-6">
                  ₹<?= number_format($tx['amount'], 2) ?>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

</div>

<!-- Record Payment Modal -->
<div class="modal fade" id="recordPaymentModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow rounded-4 overflow-hidden">
      <form method="POST" action="payments.php">
        <input type="hidden" name="action" value="record_payment">
        
        <div class="modal-header bg-dark text-white p-3">
          <h5 class="modal-title fw-bold"><i class="fas fa-money-bill-wave text-success me-2"></i> Record Subscription Payment</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        
        <div class="modal-body p-4">
          <div class="mb-3">
            <label class="form-label small fw-semibold text-muted">Select Diagnostic Lab</label>
            <select name="vendor_id" class="form-select" required>
              <option value="">-- Choose Lab --</option>
              <?php foreach ($vendor_dropdown as $v): ?>
                <option value="<?= $v['vendor_id'] ?>"><?= htmlspecialchars($v['name']) ?> (<?= htmlspecialchars($v['vendor_userid'] ?? '') ?>)</option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="row g-2 mb-3">
            <div class="col-6">
              <label class="form-label small fw-semibold text-muted">Amount (₹)</label>
              <div class="input-group">
                <span class="input-group-text">₹</span>
                <input type="number" step="0.01" name="amount" class="form-control fw-bold" placeholder="999.00" required>
              </div>
            </div>
            <div class="col-6">
              <label class="form-label small fw-semibold text-muted">Payment Date</label>
              <input type="date" name="txn_date" class="form-control" value="<?= date('Y-m-d') ?>" required>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label small fw-semibold text-muted">Payment Mode / Description</label>
            <input type="text" name="description" class="form-control" placeholder="e.g. Monthly Plan - GPay / UPI Ref #12345" required>
          </div>

          <div class="mb-2">
            <label class="form-label small fw-semibold text-muted">Auto-Extend Subscription</label>
            <select name="extend_days" class="form-select">
              <option value="0">Do not extend validity (Record payment only)</option>
              <option value="30" selected>Add +30 Days (1 Month Renewal)</option>
              <option value="90">Add +90 Days (Quarterly Renewal)</option>
              <option value="365">Add +365 Days (1 Year Renewal)</option>
            </select>
          </div>
        </div>

        <div class="modal-footer bg-light p-3">
          <button type="button" class="btn btn-outline-secondary rounded-2" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success rounded-2 fw-bold px-4">
            <i class="fas fa-check me-1"></i> Save Payment
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
