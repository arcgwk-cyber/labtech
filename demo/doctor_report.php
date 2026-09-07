<?php
/**
 * Referring Doctor-Wise Referral Reports & Business Analytics
 * - Doctor breakdown: patient count, tests, total revenue, collections, outstanding balance
 * - Filter by date range (Today, This Week, This Month, Custom Date Range)
 * - Drill-down into specific patient lists referred by any doctor
 * - Export to CSV & Print statements
 */
include_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/db.php';

// Date range filtering
$range_filter = $_GET['range'] ?? 'this_month';
$start_date   = trim($_GET['start_date'] ?? '');
$end_date     = trim($_GET['end_date'] ?? '');
$doctor_filter= trim($_GET['doctor'] ?? '');

$today = date('Y-m-d');

switch ($range_filter) {
    case 'today':
        $start_date = $today;
        $end_date = $today;
        break;
    case 'yesterday':
        $start_date = date('Y-m-d', strtotime('-1 day'));
        $end_date = $start_date;
        break;
    case 'this_week':
        $start_date = date('Y-m-d', strtotime('monday this week'));
        $end_date = $today;
        break;
    case 'this_month':
        $start_date = date('Y-m-01');
        $end_date = $today;
        break;
    case 'last_month':
        $start_date = date('Y-m-01', strtotime('first day of last month'));
        $end_date = date('Y-m-t', strtotime('last day of last month'));
        break;
    case 'all_time':
        $start_date = '';
        $end_date = '';
        break;
    case 'custom':
        // use custom submitted dates
        break;
    default:
        $start_date = date('Y-m-01');
        $end_date = $today;
        $range_filter = 'this_month';
        break;
}

// Build WHERE SQL
$where_clauses = ["1=1"];
$params = [];
$types = "";

if (!empty($start_date) && !empty($end_date)) {
    $where_clauses[] = "b.bill_date BETWEEN ? AND ?";
    $params[] = $start_date;
    $params[] = $end_date;
    $types .= "ss";
} elseif (!empty($start_date)) {
    $where_clauses[] = "b.bill_date >= ?";
    $params[] = $start_date;
    $types .= "s";
} elseif (!empty($end_date)) {
    $where_clauses[] = "b.bill_date <= ?";
    $params[] = $end_date;
    $types .= "s";
}

$where_sql = implode(' AND ', $where_clauses);

// 1. Overall Totals / KPIs
$kpi_query = "
    SELECT 
        COUNT(DISTINCT NULLIF(TRIM(p.dr_ref), '')) as active_doctors,
        COUNT(DISTINCT p.patient_id) as total_patients,
        COUNT(DISTINCT b.bill_id) as total_bills,
        COALESCE(SUM(b.total_amount), 0) as total_billed,
        COALESCE(SUM(b.paid_amount), 0) as total_paid,
        COALESCE(SUM(b.balance), 0) as total_balance
    FROM bills b
    JOIN patients p ON b.patient_id = p.patient_id
    WHERE {$where_sql}
";
$kpi_stmt = $conn->prepare($kpi_query);
if (!empty($params)) {
    $kpi_stmt->bind_param($types, ...$params);
}
$kpi_stmt->execute();
$kpis = $kpi_stmt->get_result()->fetch_assoc();
$kpi_stmt->close();

// 2. Doctor-Wise Aggregated Summary
$doc_query = "
    SELECT 
        COALESCE(NULLIF(TRIM(p.dr_ref), ''), 'Self / Direct Walk-In') as doctor_name,
        COUNT(DISTINCT p.patient_id) as patient_count,
        COUNT(DISTINCT b.bill_id) as bill_count,
        COALESCE(SUM(b.total_amount), 0) as total_billed,
        COALESCE(SUM(b.paid_amount), 0) as total_paid,
        COALESCE(SUM(b.balance), 0) as total_balance,
        COUNT(DISTINCT bt.id) + COUNT(DISTINCT bp.id) as total_tests
    FROM bills b
    JOIN patients p ON b.patient_id = p.patient_id
    LEFT JOIN bill_tests bt ON b.bill_id = bt.bill_id
    LEFT JOIN bill_packages bp ON b.bill_id = bp.bill_id
    WHERE {$where_sql}
    GROUP BY doctor_name
    ORDER BY total_billed DESC
";
$doc_stmt = $conn->prepare($doc_query);
if (!empty($params)) {
    $doc_stmt->bind_param($types, ...$params);
}
$doc_stmt->execute();
$doc_results = $doc_stmt->get_result();

$doctors_summary = [];
while ($d = $doc_results->fetch_assoc()) {
    $doctors_summary[] = $d;
}
$doc_stmt->close();

// 3. Detailed Patient Drill-Down Table
$detail_where = $where_sql;
$detail_params = $params;
$detail_types = $types;

if (!empty($doctor_filter)) {
    if ($doctor_filter === 'Self / Direct Walk-In') {
        $detail_where .= " AND (p.dr_ref IS NULL OR TRIM(p.dr_ref) = '')";
    } else {
        $detail_where .= " AND TRIM(p.dr_ref) = ?";
        $detail_params[] = $doctor_filter;
        $detail_types .= "s";
    }
}

$detail_query = "
    SELECT 
        b.bill_id, b.bill_date, b.total_amount, b.paid_amount, b.balance, b.payment_status,
        p.patient_id, p.full_name, p.phone, p.gender, p.age,
        COALESCE(NULLIF(TRIM(p.dr_ref), ''), 'Self / Direct Walk-In') as doctor_name,
        GROUP_CONCAT(DISTINCT lt.test_name SEPARATOR ', ') as test_names,
        GROUP_CONCAT(DISTINCT tp.package_name SEPARATOR ', ') as package_names
    FROM bills b
    JOIN patients p ON b.patient_id = p.patient_id
    LEFT JOIN bill_tests bt ON b.bill_id = bt.bill_id
    LEFT JOIN lab_tests lt ON bt.test_id = lt.test_id
    LEFT JOIN bill_packages bp ON b.bill_id = bp.bill_id
    LEFT JOIN test_packages tp ON bp.package_id = tp.package_id
    WHERE {$detail_where}
    GROUP BY b.bill_id
    ORDER BY b.bill_date DESC, b.bill_id DESC
    LIMIT 200
";
$detail_stmt = $conn->prepare($detail_query);
if (!empty($detail_params)) {
    $detail_stmt->bind_param($detail_types, ...$detail_params);
}
$detail_stmt->execute();
$drilldown_patients = $detail_stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$detail_stmt->close();

// Handle CSV Export
if (isset($_GET['export']) && $_GET['export'] === 'csv') {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=Doctor_Referral_Report_' . date('Y-m-d') . '.csv');
    $out = fopen('php://output', 'w');
    fputcsv($out, ['Doctor Name', 'Patients Referred', 'Bills Count', 'Total Tests', 'Total Billed (INR)', 'Paid Amount (INR)', 'Balance (INR)', 'Avg Value (INR)']);
    foreach ($doctors_summary as $row) {
        $avg = ($row['patient_count'] > 0) ? round($row['total_billed'] / $row['patient_count'], 2) : 0;
        fputcsv($out, [
            $row['doctor_name'],
            $row['patient_count'],
            $row['bill_count'],
            $row['total_tests'],
            $row['total_billed'],
            $row['total_paid'],
            $row['total_balance'],
            $avg
        ]);
    }
    fclose($out);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Referring Doctor-Wise Business Report | Lab Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      background-color: #f8fafc;
      color: #334155;
      font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
    }
    .stat-card {
      background: #ffffff;
      border: 1px solid #e2e8f0;
      border-radius: 0.75rem;
      padding: 1.25rem;
    }
    .filter-btn-group .btn {
      font-size: 0.825rem;
      font-weight: 600;
      padding: 0.4rem 0.9rem;
    }
    .table-card {
      background: white;
      border: 1px solid #e2e8f0;
      border-radius: 1rem;
      overflow: hidden;
    }
    @media print {
      body { background: white; color: black; }
      .no-print { display: none !important; }
      .stat-card, .table-card { border: 1px solid #ccc !important; box-shadow: none !important; }
    }
  </style>
</head>
<body>
<?php include_once __DIR__ . '/header.php'; ?>

<div class="container-fluid px-lg-5 py-4">

  <!-- Header Banner -->
  <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <div>
      <h3 class="fw-bold text-dark mb-1">
        <i class="fas fa-user-md text-primary me-2"></i> Referring Doctor-Wise Reports & Analytics
      </h3>
      <p class="text-muted small mb-0">Track referral volume, patient counts, billings, and collections per consulting doctor.</p>
    </div>

    <div class="d-flex align-items-center gap-2 no-print">
      <a href="doctor_report.php?<?= http_build_query(array_merge($_GET, ['export' => 'csv'])) ?>" class="btn btn-outline-success btn-sm rounded-pill px-3">
        <i class="fas fa-file-csv me-1"></i> Export to CSV
      </a>
      <button type="button" onclick="window.print();" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
        <i class="fas fa-print me-1"></i> Print Statement
      </button>
    </div>
  </div>

  <!-- Filter Bar -->
  <div class="card border-0 shadow-sm rounded-4 mb-4 no-print">
    <div class="card-body p-3 p-md-4">
      <form method="GET" action="doctor_report.php" class="row g-3 align-items-end">
        
        <!-- Quick Date Range Pills -->
        <div class="col-12">
          <div class="d-flex flex-wrap align-items-center gap-2 filter-btn-group">
            <span class="text-muted small fw-bold me-1">Period:</span>
            <a href="doctor_report.php?range=today" class="btn <?= $range_filter === 'today' ? 'btn-primary' : 'btn-outline-secondary' ?> rounded-pill">Today</a>
            <a href="doctor_report.php?range=yesterday" class="btn <?= $range_filter === 'yesterday' ? 'btn-primary' : 'btn-outline-secondary' ?> rounded-pill">Yesterday</a>
            <a href="doctor_report.php?range=this_week" class="btn <?= $range_filter === 'this_week' ? 'btn-primary' : 'btn-outline-secondary' ?> rounded-pill">This Week</a>
            <a href="doctor_report.php?range=this_month" class="btn <?= $range_filter === 'this_month' ? 'btn-primary' : 'btn-outline-secondary' ?> rounded-pill">This Month</a>
            <a href="doctor_report.php?range=last_month" class="btn <?= $range_filter === 'last_month' ? 'btn-primary' : 'btn-outline-secondary' ?> rounded-pill">Last Month</a>
            <a href="doctor_report.php?range=all_time" class="btn <?= $range_filter === 'all_time' ? 'btn-primary' : 'btn-outline-secondary' ?> rounded-pill">All Time</a>
          </div>
        </div>

        <!-- Custom Date Selectors -->
        <input type="hidden" name="range" value="custom">
        <div class="col-md-3 col-sm-6">
          <label class="form-label small fw-semibold text-muted">From Date</label>
          <input type="date" name="start_date" class="form-control form-control-sm" value="<?= htmlspecialchars($start_date) ?>">
        </div>
        <div class="col-md-3 col-sm-6">
          <label class="form-label small fw-semibold text-muted">To Date</label>
          <input type="date" name="end_date" class="form-control form-control-sm" value="<?= htmlspecialchars($end_date) ?>">
        </div>

        <!-- Doctor Filter -->
        <div class="col-md-4 col-sm-8">
          <label class="form-label small fw-semibold text-muted">Filter Specific Doctor</label>
          <select name="doctor" class="form-select form-select-sm">
            <option value="">-- All Referring Doctors (<?= count($doctors_summary) ?>) --</option>
            <?php foreach ($doctors_summary as $ds): ?>
              <option value="<?= htmlspecialchars($ds['doctor_name']) ?>" <?= ($doctor_filter === $ds['doctor_name']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($ds['doctor_name']) ?> (<?= $ds['patient_count'] ?> patients)
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="col-md-2 col-sm-4">
          <button type="submit" class="btn btn-primary btn-sm w-100 fw-semibold rounded-pill">
            <i class="fas fa-filter me-1"></i> Apply Filter
          </button>
        </div>

      </form>
    </div>
  </div>

  <!-- KPI Summary Cards -->
  <div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
      <div class="stat-card">
        <span class="text-muted small fw-bold text-uppercase">Referring Doctors</span>
        <h3 class="fw-bold text-primary mb-0 mt-1"><?= (int)$kpis['active_doctors'] ?></h3>
        <span class="text-muted small"><?= !empty($start_date) ? date('d M', strtotime($start_date)) . ' - ' . date('d M', strtotime($end_date)) : 'All-time' ?></span>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="stat-card">
        <span class="text-muted small fw-bold text-uppercase">Referred Patients</span>
        <h3 class="fw-bold text-info mb-0 mt-1"><?= (int)$kpis['total_patients'] ?></h3>
        <span class="text-muted small"><?= (int)$kpis['total_bills'] ?> visits billed</span>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="stat-card">
        <span class="text-muted small fw-bold text-uppercase">Total Billed</span>
        <h3 class="fw-bold text-success mb-0 mt-1">₹<?= number_format($kpis['total_billed'], 2) ?></h3>
        <span class="text-muted small">Paid: ₹<?= number_format($kpis['total_paid'], 2) ?></span>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="stat-card">
        <span class="text-muted small fw-bold text-uppercase">Pending Balance</span>
        <h3 class="fw-bold <?= $kpis['total_balance'] > 0 ? 'text-danger' : 'text-secondary' ?> mb-0 mt-1">
          ₹<?= number_format($kpis['total_balance'], 2) ?>
        </h3>
        <span class="text-muted small">Outstanding from referrals</span>
      </div>
    </div>
  </div>

  <!-- Table 1: Doctor-Wise Summary -->
  <div class="table-card shadow-sm mb-4">
    <div class="p-3 bg-white border-bottom d-flex justify-content-between align-items-center flex-wrap gap-2">
      <h5 class="fw-bold mb-0 text-dark">
        <i class="fas fa-list-ol text-primary me-2"></i> Doctor Referral Breakdown
      </h5>
      <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill">
        <?= count($doctors_summary) ?> Doctors Active
      </span>
    </div>

    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0" style="font-size: 0.875rem;">
        <thead class="table-light">
          <tr>
            <th>Doctor Name</th>
            <th class="text-center">Patients</th>
            <th class="text-center">Total Bills</th>
            <th class="text-center">Tests Conducted</th>
            <th class="text-end">Total Billed (₹)</th>
            <th class="text-end">Paid Amount (₹)</th>
            <th class="text-end">Balance Due (₹)</th>
            <th class="text-end">Avg Ticket (₹)</th>
            <th class="text-center no-print">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($doctors_summary)): ?>
            <tr>
              <td colspan="9" class="text-center py-4 text-muted">No referral records found for the selected period.</td>
            </tr>
          <?php else: ?>
            <?php foreach ($doctors_summary as $doc): 
              $avg_val = ($doc['patient_count'] > 0) ? round($doc['total_billed'] / $doc['patient_count'], 2) : 0;
            ?>
              <tr>
                <td>
                  <strong class="text-dark">
                    <i class="fas fa-user-md text-primary me-1"></i> <?= htmlspecialchars($doc['doctor_name']) ?>
                  </strong>
                </td>
                <td class="text-center font-monospace fw-bold"><?= $doc['patient_count'] ?></td>
                <td class="text-center font-monospace"><?= $doc['bill_count'] ?></td>
                <td class="text-center font-monospace text-muted"><?= $doc['total_tests'] ?></td>
                <td class="text-end font-monospace fw-bold text-dark">₹<?= number_format($doc['total_billed'], 2) ?></td>
                <td class="text-end font-monospace text-success">₹<?= number_format($doc['total_paid'], 2) ?></td>
                <td class="text-end font-monospace <?= $doc['total_balance'] > 0 ? 'text-danger fw-bold' : 'text-muted' ?>">
                  ₹<?= number_format($doc['total_balance'], 2) ?>
                </td>
                <td class="text-end font-monospace text-muted">₹<?= number_format($avg_val, 2) ?></td>
                <td class="text-center no-print">
                  <a href="doctor_report.php?range=<?= htmlspecialchars($range_filter) ?>&start_date=<?= htmlspecialchars($start_date) ?>&end_date=<?= htmlspecialchars($end_date) ?>&doctor=<?= urlencode($doc['doctor_name']) ?>#drilldown" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                    <i class="fas fa-users me-1"></i> View Patients
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Table 2: Patient Drill-Down Table -->
  <div class="table-card shadow-sm" id="drilldown">
    <div class="p-3 bg-white border-bottom d-flex justify-content-between align-items-center flex-wrap gap-2">
      <div>
        <h5 class="fw-bold mb-0 text-dark">
          <i class="fas fa-user-injured text-primary me-2"></i> Referred Patients List
        </h5>
        <?php if (!empty($doctor_filter)): ?>
          <div class="small text-muted">Filtered for: <strong><?= htmlspecialchars($doctor_filter) ?></strong> (<a href="doctor_report.php?range=<?= htmlspecialchars($range_filter) ?>&start_date=<?= htmlspecialchars($start_date) ?>&end_date=<?= htmlspecialchars($end_date) ?>">Clear Doctor Filter</a>)</div>
        <?php endif; ?>
      </div>
      <span class="badge bg-secondary rounded-pill">
        Showing <?= count($drilldown_patients) ?> records
      </span>
    </div>

    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0" style="font-size: 0.85rem;">
        <thead class="table-light">
          <tr>
            <th>Date</th>
            <th>Bill #</th>
            <th>Patient Name</th>
            <th>Age / Gender</th>
            <th>Phone</th>
            <th>Referring Doctor</th>
            <th>Tests Ordered</th>
            <th class="text-end">Amount</th>
            <th class="text-center">Status</th>
            <th class="text-center no-print">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($drilldown_patients)): ?>
            <tr>
              <td colspan="10" class="text-center py-4 text-muted">No patient visits found for this criteria.</td>
            </tr>
          <?php else: ?>
            <?php foreach ($drilldown_patients as $p): ?>
              <tr>
                <td class="text-nowrap text-muted"><?= date('d M Y', strtotime($p['bill_date'])) ?></td>
                <td class="font-monospace"><strong>#<?= $p['bill_id'] ?></strong></td>
                <td>
                  <a href="patient_history.php?patient_id=<?= $p['patient_id'] ?>" class="fw-bold text-primary text-decoration-none" title="View Patient 360° History">
                    <?= htmlspecialchars($p['full_name']) ?> <i class="fas fa-external-link-alt" style="font-size: 0.7rem;"></i>
                  </a>
                </td>
                <td class="text-muted"><?= htmlspecialchars($p['age'] ?: '-') ?> / <?= ucfirst($p['gender'][0] ?? '-') ?></td>
                <td class="font-monospace text-muted"><?= htmlspecialchars($p['phone'] ?: '-') ?></td>
                <td>
                  <span class="badge bg-light text-dark border">
                    <?= htmlspecialchars($p['doctor_name']) ?>
                  </span>
                </td>
                <td>
                  <div class="text-truncate" style="max-width: 250px;" title="<?= htmlspecialchars(trim(($p['test_names'] ?? '') . ' ' . ($p['package_names'] ?? ''), ', ')) ?>">
                    <?= htmlspecialchars(trim(($p['test_names'] ?? '') . ' ' . ($p['package_names'] ?? ''), ', ') ?: 'No tests mapped') ?>
                  </div>
                </td>
                <td class="text-end font-monospace fw-bold">₹<?= number_format($p['total_amount'], 2) ?></td>
                <td class="text-center">
                  <?php 
                    $st = strtolower($p['payment_status'] ?? 'unpaid');
                    $badge = match($st) {
                      'paid' => 'bg-success',
                      'partial' => 'bg-warning text-dark',
                      default => 'bg-danger'
                    };
                  ?>
                  <span class="badge <?= $badge ?> text-uppercase" style="font-size: 0.7rem;"><?= $st ?></span>
                </td>
                <td class="text-center no-print text-nowrap">
                  <a href="patient_history.php?patient_id=<?= $p['patient_id'] ?>" class="btn btn-sm btn-outline-info rounded-pill px-2 py-1" title="View Patient History">
                    <i class="fas fa-history"></i>
                  </a>
                  <a href="print_bill.php?id=<?= $p['bill_id'] ?>" target="_blank" class="btn btn-sm btn-outline-secondary rounded-pill px-2 py-1" title="Print Bill">
                    <i class="fas fa-receipt"></i>
                  </a>
                  <a href="report_generate_pdf.php?bill_id=<?= $p['bill_id'] ?>" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-2 py-1" title="View Report">
                    <i class="fas fa-file-pdf"></i>
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
