<?php
session_start();
require_once 'db.php';

// Authentication Check
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id   = $_SESSION['user_id'];
$username  = $_SESSION['username'] ?? 'Admin';
$role      = $_SESSION['role'] ?? 'admin';
$full_name = $_SESSION['full_name'] ?? $username;

// Fetch settings from admin_settings
$settings = [
    'company_name' => 'Diagnostic Centre ERP',
    'status'       => 'active',
    'expiry_date'  => null,
    'grace_days'   => 7
];
if ($conn) {
    $res = $conn->query("SELECT * FROM admin_settings WHERE id = 1 LIMIT 1");
    if ($res && $row = $res->fetch_assoc()) {
        $settings = array_merge($settings, $row);
    }
}

// Date Filter
$filter = $_GET['filter'] ?? 'month';
$start_date = $_GET['start_date'] ?? date('Y-m-01');
$end_date   = $_GET['end_date'] ?? date('Y-m-d');

if ($filter === 'today') {
    $start_date = date('Y-m-d');
    $end_date   = date('Y-m-d');
} elseif ($filter === 'week') {
    $start_date = date('Y-m-d', strtotime('-7 days'));
    $end_date   = date('Y-m-d');
}

// Fetch KPI statistics
$kpis = [
    'total_bills'     => 0,
    'total_revenue'   => 0.00,
    'total_due'       => 0.00,
    'completed_tests' => 0,
    'pending_samples' => 0
];

if ($conn) {
    // Bills & Revenue
    $bq = $conn->query("SELECT COUNT(*) AS total_bills, 
                               COALESCE(SUM(total_amount), 0) AS total_revenue, 
                               COALESCE(SUM(balance), 0) AS total_due 
                        FROM bills 
                        WHERE bill_date BETWEEN '$start_date' AND '$end_date'");
    if ($bq && $brow = $bq->fetch_assoc()) {
        $kpis['total_bills']   = (int)$brow['total_bills'];
        $kpis['total_revenue'] = (float)$brow['total_revenue'];
        $kpis['total_due']     = (float)$brow['total_due'];
    }

    // Completed Test Results
    $tq = $conn->query("SELECT COUNT(*) AS total_completed 
                        FROM test_results 
                        WHERE status = 'Completed' AND result_date BETWEEN '$start_date' AND '$end_date'");
    if ($tq && $trow = $tq->fetch_assoc()) {
        $kpis['completed_tests'] = (int)$trow['total_completed'];
    }

    // Pending Samples
    $sq = $conn->query("SELECT COUNT(*) AS pending 
                        FROM bills b 
                        LEFT JOIN test_samples ts ON b.bill_id = ts.bill_id 
                        WHERE ts.sample_id IS NULL AND b.bill_date BETWEEN '$start_date' AND '$end_date'");
    if ($sq && $srow = $sq->fetch_assoc()) {
        $kpis['pending_samples'] = (int)$srow['pending'];
    }
}

// Fetch Recent Invoices / Bills
$recentBills = [];
if ($conn) {
    $recentQ = $conn->query("SELECT b.*, p.full_name AS patient_name, p.phone AS patient_phone 
                            FROM bills b 
                            LEFT JOIN patients p ON b.patient_id = p.patient_id 
                            ORDER BY b.bill_id DESC 
                            LIMIT 8");
    if ($recentQ) {
        while ($r = $recentQ->fetch_assoc()) {
            $recentBills[] = $r;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($settings['company_name']) ?> - Management Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --brand-primary: #0284c7;
      --brand-dark: #0369a1;
      --surface-bg: #f8fafc;
      --card-border: #e2e8f0;
    }

    body {
      background-color: var(--surface-bg);
      font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
      color: #1e293b;
    }

    .navbar-custom {
      background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
      box-shadow: 0 4px 12px rgba(2, 132, 199, 0.15);
    }

    .navbar-brand {
      font-weight: 700;
      letter-spacing: -0.02em;
    }

    .nav-link {
      color: rgba(255, 255, 255, 0.9) !important;
      font-weight: 500;
      padding: 8px 14px !important;
      border-radius: 6px;
      transition: all 0.2s;
    }

    .nav-link:hover, .nav-link.active {
      background-color: rgba(255, 255, 255, 0.15);
      color: #fff !important;
    }

    .btn-quick {
      background: #ffffff;
      color: #0284c7;
      font-weight: 600;
      border-radius: 8px;
      padding: 6px 14px;
      border: none;
      transition: all 0.2s;
    }

    .btn-quick:hover {
      background: #f0f9ff;
      color: #0369a1;
      transform: translateY(-1px);
    }

    .kpi-card {
      background: #ffffff;
      border: 1px solid var(--card-border);
      border-radius: 12px;
      padding: 20px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.02);
      display: flex;
      align-items: center;
      gap: 16px;
      transition: transform 0.2s, box-shadow 0.2s;
    }

    .kpi-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 16px rgba(0,0,0,0.04);
    }

    .kpi-icon-box {
      width: 52px;
      height: 52px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.4rem;
    }

    .action-pill-card {
      background: #ffffff;
      border: 1px solid var(--card-border);
      border-radius: 12px;
      padding: 16px;
      text-decoration: none;
      color: #1e293b;
      display: flex;
      align-items: center;
      gap: 14px;
      transition: all 0.2s;
    }

    .action-pill-card:hover {
      border-color: #0284c7;
      background: #f0f9ff;
      transform: translateY(-2px);
      color: #0284c7;
    }

    .table-container {
      background: #ffffff;
      border: 1px solid var(--card-border);
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }
  </style>
</head>
<body>
<?php include_once __DIR__ . '/header.php'; ?>


  <!-- Main Container -->
  <div class="container-fluid px-3 px-lg-4 py-4" style="max-width: 1500px;">

    <!-- Breadcrumb & Date Filter Bar -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
      <div>
        <h4 class="fw-bold mb-1">Diagnostic Centre Dashboard</h4>
        <p class="text-muted mb-0 small">Overview of test orders, patient invoices, revenue collection, and clinical reports.</p>
      </div>

      <!-- Date Filter Form -->
      <form method="GET" class="d-flex flex-wrap align-items-center gap-2">
        <div class="btn-group" role="group">
          <a href="index.php?filter=today" class="btn btn-sm <?= $filter === 'today' ? 'btn-primary' : 'btn-outline-secondary' ?>">Today</a>
          <a href="index.php?filter=week" class="btn btn-sm <?= $filter === 'week' ? 'btn-primary' : 'btn-outline-secondary' ?>">7 Days</a>
          <a href="index.php?filter=month" class="btn btn-sm <?= $filter === 'month' ? 'btn-primary' : 'btn-outline-secondary' ?>">This Month</a>
        </div>
        <input type="date" name="start_date" class="form-control form-control-sm" style="width: 135px;" value="<?= $start_date ?>">
        <input type="date" name="end_date" class="form-control form-control-sm" style="width: 135px;" value="<?= $end_date ?>">
        <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-filter"></i></button>
      </form>
    </div>

    <!-- KPI Summary Cards -->
    <div class="row g-3 mb-4">
      <div class="col-sm-6 col-xl-3">
        <div class="kpi-card">
          <div class="kpi-icon-box bg-primary bg-opacity-10 text-primary">
            <i class="fas fa-file-invoice"></i>
          </div>
          <div>
            <div class="text-muted small fw-semibold text-uppercase">Total Invoices</div>
            <h3 class="fw-bold mb-0 text-dark"><?= number_format($kpis['total_bills']) ?></h3>
            <small class="text-muted">In selected period</small>
          </div>
        </div>
      </div>

      <div class="col-sm-6 col-xl-3">
        <div class="kpi-card">
          <div class="kpi-icon-box bg-success bg-opacity-10 text-success">
            <i class="fas fa-rupee-sign"></i>
          </div>
          <div>
            <div class="text-muted small fw-semibold text-uppercase">Revenue Billed</div>
            <h3 class="fw-bold mb-0 text-success">₹<?= number_format($kpis['total_revenue'], 2) ?></h3>
            <small class="text-muted">Total billing value</small>
          </div>
        </div>
      </div>

      <div class="col-sm-6 col-xl-3">
        <div class="kpi-card">
          <div class="kpi-icon-box bg-danger bg-opacity-10 text-danger">
            <i class="fas fa-hand-holding-usd"></i>
          </div>
          <div>
            <div class="text-muted small fw-semibold text-uppercase">Pending Balance</div>
            <h3 class="fw-bold mb-0 text-danger">₹<?= number_format($kpis['total_due'], 2) ?></h3>
            <small class="text-muted">Uncollected dues</small>
          </div>
        </div>
      </div>

      <div class="col-sm-6 col-xl-3">
        <div class="kpi-card">
          <div class="kpi-icon-box bg-info bg-opacity-10 text-info">
            <i class="fas fa-check-double"></i>
          </div>
          <div>
            <div class="text-muted small fw-semibold text-uppercase">Completed Tests</div>
            <h3 class="fw-bold mb-0 text-info"><?= number_format($kpis['completed_tests']) ?></h3>
            <small class="text-muted">Verified test reports</small>
          </div>
        </div>
      </div>
    </div>

    <!-- Quick Action Launchpad -->
    <div class="mb-4">
      <h6 class="fw-bold text-muted small text-uppercase mb-3"><i class="fas fa-bolt text-warning me-1"></i> Quick Clinical Workflows</h6>
      <div class="row g-3">
        <div class="col-12 col-md-4">
          <a href="bill_add.php" class="action-pill-card">
            <div class="rounded-circle p-2 bg-primary bg-opacity-10 text-primary">
              <i class="fas fa-user-plus fa-lg"></i>
            </div>
            <div>
              <div class="fw-bold">New Patient Bill</div>
              <small class="text-muted">Register patient & tests</small>
            </div>
          </a>
        </div>
        <div class="col-12 col-md-4">
          <a href="sample_collection.php" class="action-pill-card">
            <div class="rounded-circle p-2 bg-warning bg-opacity-10 text-warning">
              <i class="fas fa-vial fa-lg"></i>
            </div>
            <div>
              <div class="fw-bold">Sample Collection</div>
              <small class="text-muted">Barcode & specimen status</small>
            </div>
          </a>
        </div>
        <div class="col-12 col-md-4">
          <a href="result_entry.php" class="action-pill-card">
            <div class="rounded-circle p-2 bg-success bg-opacity-10 text-success">
              <i class="fas fa-keyboard fa-lg"></i>
            </div>
            <div>
              <div class="fw-bold">Enter Test Results</div>
              <small class="text-muted">Fill values & reference ranges</small>
            </div>
          </a>
        </div>
      </div>
    </div>

    <!-- Recent Patient Invoices & Tests Table -->
    <div class="table-container p-3 p-md-4">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
          <h5 class="fw-bold mb-0"><i class="fas fa-receipt text-primary me-2"></i> Recent Patient Invoices</h5>
          <small class="text-muted">Latest diagnostic invoices generated by the reception.</small>
        </div>
        <a href="bill_list.php" class="btn btn-outline-primary btn-sm">
          View All Invoices <i class="fas fa-arrow-right ms-1"></i>
        </a>
      </div>

      <?php if (empty($recentBills)): ?>
        <div class="text-center py-5 text-muted">
          <i class="fas fa-file-medical fa-3x mb-2 text-secondary opacity-50"></i>
          <h6>No invoices recorded yet</h6>
          <p class="small mb-3">Click below to generate your first patient diagnostic bill.</p>
          <a href="bill_add.php" class="btn btn-primary btn-sm"><i class="fas fa-plus me-1"></i> Generate New Bill</a>
        </div>
      <?php else: ?>
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th>Bill ID</th>
                <th>Patient Name</th>
                <th>Bill Date</th>
                <th>Total Amount</th>
                <th>Paid</th>
                <th>Balance</th>
                <th>Status</th>
                <th class="text-end">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($recentBills as $b): ?>
                <tr>
                  <td><strong>#<?= $b['bill_id'] ?></strong></td>
                  <td>
                    <div class="fw-semibold"><?= htmlspecialchars($b['patient_name'] ?? 'Walk-in Patient') ?></div>
                    <small class="text-muted"><?= htmlspecialchars($b['patient_phone'] ?? '') ?></small>
                  </td>
                  <td><?= date('d M Y', strtotime($b['bill_date'])) ?></td>
                  <td class="fw-semibold">₹<?= number_format($b['total_amount'], 2) ?></td>
                  <td class="text-success">₹<?= number_format($b['paid_amount'], 2) ?></td>
                  <td class="text-danger">₹<?= number_format($b['balance'], 2) ?></td>
                  <td>
                    <?php
                      $badgeClass = match($b['payment_status']) {
                        'paid'    => 'bg-success',
                        'partial' => 'bg-warning text-dark',
                        default   => 'bg-danger'
                      };
                    ?>
                    <span class="badge <?= $badgeClass ?>"><?= ucfirst($b['payment_status']) ?></span>
                  </td>
                  <td class="text-end">
                    <a href="print_bill.php?id=<?= $b['bill_id'] ?>" target="_blank" class="btn btn-outline-secondary btn-sm" title="Print Invoice">
                      <i class="fas fa-print"></i>
                    </a>
                    <a href="result_entry.php?bill_id=<?= $b['bill_id'] ?>" class="btn btn-outline-success btn-sm" title="Enter Results">
                      <i class="fas fa-notes-medical"></i>
                    </a>
                    <a href="bill_edit.php?id=<?= $b['bill_id'] ?>" class="btn btn-outline-primary btn-sm" title="Edit Bill">
                      <i class="fas fa-edit"></i>
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </div>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
