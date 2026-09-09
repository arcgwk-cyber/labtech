<?php
/**
 * Patient 360° History & Clinical Medical Record
 * - Search by Name, Phone, or Patient ID
 * - Complete chronological visit & billing timeline
 * - Longitudinal parameter result comparison & trends
 * - Printable clinical history sheet
 */
include_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/db.php';

$patient_id = isset($_GET['patient_id']) ? (int)$_GET['patient_id'] : 0;
$search_term = trim($_GET['search'] ?? '');

$patient = null;
$bills = [];
$stats = [
    'total_visits' => 0,
    'total_billed' => 0,
    'total_paid' => 0,
    'total_balance' => 0,
    'total_tests' => 0
];
$param_history = []; // parameter_id => [ info, readings: [date => value] ]
$all_dates = [];

// Resolve Patient
if ($patient_id > 0) {
    $stmt = $conn->prepare("SELECT * FROM patients WHERE patient_id = ? LIMIT 1");
    $stmt->bind_param("i", $patient_id);
    $stmt->execute();
    $patient = $stmt->get_result()->fetch_assoc();
    $stmt->close();
} elseif (!empty($search_term)) {
    $stmt = $conn->prepare("SELECT * FROM patients WHERE full_name LIKE ? OR phone LIKE ? OR CAST(patient_id AS CHAR) = ? ORDER BY patient_id DESC LIMIT 1");
    $term_like = "%" . $search_term . "%";
    $stmt->bind_param("sss", $term_like, $term_like, $search_term);
    $stmt->execute();
    $patient = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    if ($patient) {
        $patient_id = (int)$patient['patient_id'];
    }
}

// If patient found, load their complete history
if ($patient && $patient_id > 0) {
    // 1. Lifetime Stats
    $stat_stmt = $conn->prepare("
        SELECT 
            COUNT(DISTINCT b.bill_id) as total_visits,
            COALESCE(SUM(b.total_amount), 0) as total_billed,
            COALESCE(SUM(b.paid_amount), 0) as total_paid,
            COALESCE(SUM(b.balance), 0) as total_balance
        FROM bills b 
        WHERE b.patient_id = ?
    ");
    $stat_stmt->bind_param("i", $patient_id);
    $stat_stmt->execute();
    $s_res = $stat_stmt->get_result()->fetch_assoc();
    if ($s_res) {
        $stats['total_visits'] = (int)$s_res['total_visits'];
        $stats['total_billed'] = (float)$s_res['total_billed'];
        $stats['total_paid'] = (float)$s_res['total_paid'];
        $stats['total_balance'] = (float)$s_res['total_balance'];
    }
    $stat_stmt->close();

    // 2. All Visits & Bills
    $bills_stmt = $conn->prepare("
        SELECT b.*, s.status as sample_status, s.sample_id
        FROM bills b
        LEFT JOIN test_samples s ON b.bill_id = s.bill_id
        WHERE b.patient_id = ?
        ORDER BY b.bill_date DESC, b.bill_id DESC
    ");
    $bills_stmt->bind_param("i", $patient_id);
    $bills_stmt->execute();
    $b_res = $bills_stmt->get_result();
    
    $bill_ids = [];
    while ($b = $b_res->fetch_assoc()) {
        $b['tests'] = [];
        $b['packages'] = [];
        $bills[$b['bill_id']] = $b;
        $bill_ids[] = (int)$b['bill_id'];
    }
    $bills_stmt->close();

    if (!empty($bill_ids)) {
        $id_list_str = implode(',', $bill_ids);

        // Fetch bill tests
        $bt_q = $conn->query("
            SELECT bt.bill_id, lt.test_id, lt.test_name, lt.test_code, lt.price
            FROM bill_tests bt
            JOIN lab_tests lt ON bt.test_id = lt.test_id
            WHERE bt.bill_id IN ({$id_list_str})
        ");
        if ($bt_q) {
            while ($bt = $bt_q->fetch_assoc()) {
                $bills[$bt['bill_id']]['tests'][] = $bt;
                $stats['total_tests']++;
            }
        }

        // Fetch bill packages
        $bp_q = $conn->query("
            SELECT bp.bill_id, tp.package_id, tp.package_name, tp.package_code, tp.package_price
            FROM bill_packages bp
            JOIN test_packages tp ON bp.package_id = tp.package_id
            WHERE bp.bill_id IN ({$id_list_str})
        ");
        if ($bp_q) {
            while ($bp = $bp_q->fetch_assoc()) {
                $bills[$bp['bill_id']]['packages'][] = $bp;
                $stats['total_tests']++;
            }
        }

        // 3. Fetch Test Results Trends Across All Visits
        $tr_q = $conn->query("
            SELECT 
                tr.bill_id, b.bill_date, tr.parameter_id, tr.result_value, tr.status as result_status,
                p.param_name, p.unit, p.method,
                r.male_min, r.male_max, r.female_min, r.female_max, r.reference_text, r.use_reference_text,
                lt.test_name
            FROM test_results tr
            JOIN bills b ON tr.bill_id = b.bill_id
            JOIN test_parameters p ON tr.parameter_id = p.parameter_id
            LEFT JOIN (
                SELECT parameter_id,
                       MAX(male_min) as male_min, MAX(male_max) as male_max,
                       MAX(female_min) as female_min, MAX(female_max) as female_max,
                       MAX(reference_text) as reference_text,
                       MAX(use_reference_text) as use_reference_text
                FROM parameter_reference_ranges
                GROUP BY parameter_id
            ) r ON p.parameter_id = r.parameter_id
            LEFT JOIN lab_tests lt ON tr.test_id = lt.test_id
            WHERE b.patient_id = {$patient_id} AND tr.result_value IS NOT NULL AND TRIM(tr.result_value) != ''
            ORDER BY b.bill_date ASC, tr.result_id ASC
        ");

        if ($tr_q) {
            while ($row = $tr_q->fetch_assoc()) {
                $pid = $row['parameter_id'];
                $date_key = date('d-M-Y', strtotime($row['bill_date']));
                
                if (!in_array($date_key, $all_dates)) {
                    $all_dates[] = $date_key;
                }

                if (!isset($param_history[$pid])) {
                    $param_history[$pid] = [
                        'name' => $row['param_name'],
                        'unit' => $row['unit'],
                        'method' => $row['method'],
                        'test_name' => $row['test_name'],
                        'male_min' => $row['male_min'],
                        'male_max' => $row['male_max'],
                        'female_min' => $row['female_min'],
                        'female_max' => $row['female_max'],
                        'ref_text' => $row['reference_text'],
                        'readings' => []
                    ];
                }
                
                $param_history[$pid]['readings'][$date_key] = [
                    'value' => $row['result_value'],
                    'status' => $row['result_status'],
                    'bill_id' => $row['bill_id']
                ];
            }
        }
    }
}

// Fetch recent patients for quick switch drawer
$recent_patients = [];
$rp_q = $conn->query("
    SELECT p.patient_id, p.full_name, p.phone, p.gender, p.age, p.dr_ref, COUNT(b.bill_id) as visit_count
    FROM patients p
    LEFT JOIN bills b ON p.patient_id = b.patient_id
    GROUP BY p.patient_id
    ORDER BY p.patient_id DESC
    LIMIT 15
");
if ($rp_q) {
    while ($r = $rp_q->fetch_assoc()) {
        $recent_patients[] = $r;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= $patient ? htmlspecialchars($patient['full_name']) . ' - Patient 360° History' : 'Patient History Lookup' ?> | LabTech</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      background-color: #f8fafc;
      color: #334155;
      font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
    }
    .profile-card {
      background: white;
      border: 1px solid #e2e8f0;
      border-radius: 1rem;
      box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
    }
    .avatar-circle {
      width: 72px;
      height: 72px;
      border-radius: 50%;
      background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 2rem;
      font-weight: 700;
    }
    .kpi-card {
      background: #ffffff;
      border: 1px solid #e2e8f0;
      border-radius: 0.75rem;
      padding: 1rem 1.25rem;
    }
    .timeline-item {
      position: relative;
      padding-left: 2rem;
      padding-bottom: 2rem;
      border-left: 2px solid #e2e8f0;
    }
    .timeline-item:last-child {
      border-left: 2px solid transparent;
      padding-bottom: 0;
    }
    .timeline-dot {
      position: absolute;
      left: -0.55rem;
      top: 0;
      width: 1rem;
      height: 1rem;
      border-radius: 50%;
      background: #0284c7;
      border: 3px solid #ffffff;
      box-shadow: 0 0 0 2px #0284c7;
    }
    .nav-tabs .nav-link {
      font-weight: 600;
      color: #64748b;
      border: none;
      border-bottom: 3px solid transparent;
      padding: 0.75rem 1.25rem;
    }
    .nav-tabs .nav-link.active {
      color: #0284c7;
      border-bottom: 3px solid #0284c7;
      background: transparent;
    }
    .val-abnormal {
      color: #dc2626;
      font-weight: 700;
      background: #fee2e2;
      padding: 2px 6px;
      border-radius: 4px;
    }
    .val-normal {
      color: #059669;
      font-weight: 600;
    }
    @media print {
      body { background: white; color: black; }
      .no-print { display: none !important; }
      .profile-card, .timeline-card { border: 1px solid #ccc !important; box-shadow: none !important; }
    }
  </style>
</head>
<body>
<?php include_once __DIR__ . '/header.php'; ?>

<div class="container-fluid px-lg-5 py-4">

  <!-- Search & Action Bar -->
  <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3 no-print">
    <div>
      <h3 class="fw-bold text-dark mb-1">
        <i class="fas fa-history text-primary me-2"></i> Patient 360° History & Clinical Records
      </h3>
      <p class="text-muted small mb-0">Search any patient to view complete visit history, tests taken, financial balances, and longitudinal diagnostic trends.</p>
    </div>

    <!-- Search input -->
    <div class="d-flex align-items-center gap-2" style="max-width: 500px; width: 100%;">
      <form method="GET" action="patient_history.php" class="input-group shadow-sm">
        <input type="text" name="search" class="form-control" placeholder="Search by Patient Name, Phone or ID..." value="<?= htmlspecialchars($search_term) ?>">
        <button type="submit" class="btn btn-primary px-3">
          <i class="fas fa-search me-1"></i> Search
        </button>
      </form>
      <button type="button" class="btn btn-outline-secondary" data-bs-toggle="offcanvas" data-bs-target="#recentPatientsOffcanvas" title="Recent Patients">
        <i class="fas fa-users"></i>
      </button>
    </div>
  </div>

  <?php if (!$patient): ?>
    <!-- No Patient Selected State -->
    <div class="card border-0 shadow-sm rounded-4 p-5 text-center my-4">
      <div class="py-4">
        <div class="mb-3">
          <span class="p-3 bg-primary bg-opacity-10 text-primary rounded-circle d-inline-block">
            <i class="fas fa-user-search fa-3x"></i>
          </span>
        </div>
        <h4 class="fw-bold text-dark">Lookup Patient History</h4>
        <p class="text-muted mx-auto" style="max-width: 500px;">
          Enter a patient name or phone number in the search bar above, or pick from recent patients to view their complete clinical profile, past bills, and parameter trends.
        </p>
        
        <div class="mt-4">
          <h6 class="text-muted fw-bold text-uppercase small mb-3">Recently Registered Patients</h6>
          <div class="d-flex flex-wrap justify-content-center gap-2">
            <?php foreach ($recent_patients as $rp): ?>
              <a href="patient_history.php?patient_id=<?= $rp['patient_id'] ?>" class="btn btn-sm btn-outline-secondary rounded-pill px-3 py-2">
                <i class="fas fa-user me-1 text-primary"></i> <?= htmlspecialchars($rp['full_name']) ?>
                <span class="badge bg-light text-dark border ms-1"><?= $rp['phone'] ?: 'ID #' . $rp['patient_id'] ?></span>
              </a>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  <?php else: ?>

    <!-- Patient Header Card -->
    <div class="profile-card p-4 mb-4">
      <div class="row align-items-center g-3">
        <div class="col-auto">
          <div class="avatar-circle">
            <?= strtoupper(substr($patient['full_name'], 0, 1)) ?>
          </div>
        </div>
        <div class="col-lg-5 col-md-6">
          <div class="d-flex align-items-center gap-2 mb-1">
            <h4 class="fw-bold text-dark mb-0"><?= htmlspecialchars($patient['full_name']) ?></h4>
            <span class="badge bg-primary rounded-pill font-monospace">UHID #<?= $patient['patient_id'] ?></span>
          </div>
          <div class="text-muted small mb-2">
            <span><i class="fas fa-venus-mars me-1"></i> <?= ucfirst($patient['gender'] ?: 'Not Specified') ?></span>
            <span class="mx-2">•</span>
            <span><i class="fas fa-birthday-cake me-1"></i> Age: <?= htmlspecialchars($patient['age'] ?: '-') ?></span>
            <span class="mx-2">•</span>
            <span><i class="fas fa-phone me-1"></i> <?= htmlspecialchars($patient['phone'] ?: 'No Phone') ?></span>
          </div>
          <div class="text-muted small">
            <span><i class="fas fa-user-md text-primary me-1"></i> Ref Doctor: <strong><?= htmlspecialchars($patient['dr_ref'] ?: 'Self / Walk-In') ?></strong></span>
            <?php if (!empty($patient['address'])): ?>
              <span class="mx-2">•</span>
              <span><i class="fas fa-map-marker-alt me-1"></i> <?= htmlspecialchars($patient['address']) ?></span>
            <?php endif; ?>
          </div>
        </div>

        <div class="col-lg-6 col-md-12">
          <div class="row g-2 text-center">
            <div class="col-sm-3 col-6">
              <div class="kpi-card">
                <span class="text-muted" style="font-size: 0.72rem; font-weight: 700; text-transform: uppercase;">Total Visits</span>
                <h4 class="fw-bold text-primary mb-0 mt-1"><?= $stats['total_visits'] ?></h4>
              </div>
            </div>
            <div class="col-sm-3 col-6">
              <div class="kpi-card">
                <span class="text-muted" style="font-size: 0.72rem; font-weight: 700; text-transform: uppercase;">Total Tests</span>
                <h4 class="fw-bold text-info mb-0 mt-1"><?= $stats['total_tests'] ?></h4>
              </div>
            </div>
            <div class="col-sm-3 col-6">
              <div class="kpi-card">
                <span class="text-muted" style="font-size: 0.72rem; font-weight: 700; text-transform: uppercase;">Total Paid</span>
                <h4 class="fw-bold text-success mb-0 mt-1">₹<?= number_format($stats['total_paid'], 0) ?></h4>
              </div>
            </div>
            <div class="col-sm-3 col-6">
              <div class="kpi-card">
                <span class="text-muted" style="font-size: 0.72rem; font-weight: 700; text-transform: uppercase;">Balance Due</span>
                <h4 class="fw-bold <?= $stats['total_balance'] > 0 ? 'text-danger' : 'text-secondary' ?> mb-0 mt-1">
                  ₹<?= number_format($stats['total_balance'], 0) ?>
                </h4>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="d-flex justify-content-end gap-2 mt-3 pt-3 border-top no-print">
        <a href="bill_add.php?patient_id=<?= $patient['patient_id'] ?>" class="btn btn-sm btn-primary rounded-pill px-3">
          <i class="fas fa-plus-circle me-1"></i> New Bill For Patient
        </a>
        <button type="button" onclick="window.print();" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
          <i class="fas fa-print me-1"></i> Print History
        </button>
      </div>
    </div>

    <!-- Main History Tabs -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
      <div class="card-header bg-white border-bottom px-4 pt-3 pb-0 no-print">
        <ul class="nav nav-tabs" id="historyTabs" role="tablist">
          <li class="nav-item">
            <button class="nav-link active" id="visits-tab" data-bs-toggle="tab" data-bs-target="#visits-content" type="button" role="tab">
              <i class="fas fa-calendar-check me-2"></i> Visits & Bills (<?= count($bills) ?>)
            </button>
          </li>
          <li class="nav-item">
            <button class="nav-link" id="trends-tab" data-bs-toggle="tab" data-bs-target="#trends-content" type="button" role="tab">
              <i class="fas fa-chart-line me-2"></i> Clinical Parameter Trends (<?= count($param_history) ?>)
            </button>
          </li>
        </ul>
      </div>

      <div class="card-body p-4">
        <div class="tab-content" id="historyTabContent">

          <!-- Tab 1: Visits Timeline -->
          <div class="tab-pane fade show active" id="visits-content" role="tabpanel">
            <?php if (empty($bills)): ?>
              <div class="text-center py-5 text-muted">
                <i class="fas fa-file-invoice fa-3x mb-3 text-secondary opacity-50"></i>
                <h6>No bills found for this patient yet.</h6>
              </div>
            <?php else: ?>
              <div class="timeline ps-2">
                <?php foreach ($bills as $bill): ?>
                  <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="card border rounded-3 shadow-none p-3 bg-white">
                      <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-2">
                        <div>
                          <div class="d-flex align-items-center gap-2">
                            <h6 class="fw-bold mb-0">Visit on <?= date('d M Y', strtotime($bill['bill_date'])) ?></h6>
                            <span class="badge bg-light text-dark border font-monospace">Bill #<?= $bill['bill_id'] ?></span>
                            <?php 
                              $p_status = strtolower($bill['payment_status'] ?? 'unpaid');
                              $badge_cls = match($p_status) {
                                'paid' => 'bg-success',
                                'partial' => 'bg-warning text-dark',
                                default => 'bg-danger'
                              };
                            ?>
                            <span class="badge <?= $badge_cls ?> text-uppercase" style="font-size: 0.7rem;"><?= $p_status ?></span>
                          </div>
                          <div class="text-muted small mt-1">
                            <span>Total Amount: <strong>₹<?= number_format($bill['total_amount'], 2) ?></strong></span>
                            <span class="mx-2">•</span>
                            <span>Paid: <strong>₹<?= number_format($bill['paid_amount'], 2) ?></strong></span>
                            <?php if ($bill['balance'] > 0): ?>
                              <span class="mx-2">•</span>
                              <span class="text-danger font-monospace">Due: ₹<?= number_format($bill['balance'], 2) ?></span>
                            <?php endif; ?>
                          </div>
                        </div>

                        <div class="d-flex align-items-center gap-2 no-print">
                          <a href="print_bill.php?id=<?= $bill['bill_id'] ?>" target="_blank" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                            <i class="fas fa-receipt me-1"></i> Print Bill
                          </a>
                          <a href="report_generate_pdf.php?bill_id=<?= $bill['bill_id'] ?>" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                            <i class="fas fa-file-pdf me-1"></i> View Report
                          </a>
                          <a href="bill_edit.php?id=<?= $bill['bill_id'] ?>" class="btn btn-sm btn-light border rounded-pill px-2" title="Edit Bill">
                            <i class="fas fa-pencil-alt text-muted"></i>
                          </a>
                        </div>
                      </div>

                      <!-- Tests and Packages in this visit -->
                      <div class="mt-2 pt-2 border-top">
                        <span class="text-muted small fw-semibold me-2"><i class="fas fa-vial me-1"></i> Tests & Packages:</span>
                        <div class="d-inline-flex flex-wrap gap-1">
                          <?php foreach ($bill['tests'] as $bt): ?>
                            <span class="badge bg-light text-dark border font-monospace" style="font-size: 0.75rem;">
                              <?= htmlspecialchars($bt['test_name']) ?> (₹<?= number_format($bt['price'], 0) ?>)
                            </span>
                          <?php endforeach; ?>
                          <?php foreach ($bill['packages'] as $bp): ?>
                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25" style="font-size: 0.75rem;">
                              <i class="fas fa-box me-1"></i> <?= htmlspecialchars($bp['package_name']) ?>
                            </span>
                          <?php endforeach; ?>
                        </div>
                      </div>

                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
          </div>

          <!-- Tab 2: Parameter Trends & Comparison -->
          <div class="tab-pane fade" id="trends-content" role="tabpanel">
            <?php if (empty($param_history)): ?>
              <div class="text-center py-5 text-muted">
                <i class="fas fa-chart-bar fa-3x mb-3 text-secondary opacity-50"></i>
                <h6>No test result values recorded for this patient yet.</h6>
                <p class="small">Enter test results under Test Results menu to see longitudinal trends here.</p>
              </div>
            <?php else: ?>
              <div class="mb-3 small text-muted">
                <i class="fas fa-info-circle me-1 text-primary"></i> 
                Comparison of patient clinical results across multiple visit dates. Values outside normal reference intervals are highlighted in red.
              </div>

              <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle bg-white" style="font-size: 0.85rem;">
                  <thead class="table-light">
                    <tr>
                      <th style="min-width: 180px;">Parameter Name</th>
                      <th style="width: 100px;">Unit</th>
                      <th style="min-width: 180px;">Normal Reference Interval</th>
                      <?php foreach ($all_dates as $d): ?>
                        <th class="text-center" style="min-width: 110px;">
                          <?= $d ?>
                        </th>
                      <?php endforeach; ?>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($param_history as $pid => $p): 
                      $gender = strtolower($patient['gender'] ?? 'male');
                      $ref_min = ($gender === 'female' && $p['female_min'] > 0) ? $p['female_min'] : $p['male_min'];
                      $ref_max = ($gender === 'female' && $p['female_max'] > 0) ? $p['female_max'] : $p['male_max'];
                    ?>
                      <tr>
                        <td class="fw-bold text-dark">
                          <?= htmlspecialchars($p['name']) ?>
                          <div class="small text-muted fw-normal" style="font-size: 0.72rem;"><?= htmlspecialchars($p['test_name'] ?? '') ?></div>
                        </td>
                        <td class="font-monospace text-muted"><?= htmlspecialchars($p['unit'] ?: '-') ?></td>
                        <td>
                          <?php if (!empty($p['ref_text'])): ?>
                            <span class="text-muted"><?= htmlspecialchars($p['ref_text']) ?></span>
                          <?php elseif ($ref_min > 0 || $ref_max > 0): ?>
                            <span class="text-muted"><?= $ref_min ?> - <?= $ref_max ?> <?= htmlspecialchars($p['unit']) ?></span>
                          <?php else: ?>
                            <span class="text-muted">Standard</span>
                          <?php endif; ?>
                        </td>

                        <?php foreach ($all_dates as $d): 
                          $reading = $p['readings'][$d] ?? null;
                        ?>
                          <td class="text-center font-monospace">
                            <?php if ($reading): 
                              $val = trim($reading['value']);
                              $num_val = is_numeric($val) ? (float)$val : null;
                              $is_abnormal = false;
                              if ($num_val !== null && ($ref_min > 0 || $ref_max > 0)) {
                                if (($ref_min > 0 && $num_val < $ref_min) || ($ref_max > 0 && $num_val > $ref_max)) {
                                  $is_abnormal = true;
                                }
                              }
                            ?>
                              <span class="<?= $is_abnormal ? 'val-abnormal' : 'val-normal' ?>">
                                <?= htmlspecialchars($val) ?>
                              </span>
                            <?php else: ?>
                              <span class="text-muted opacity-25">-</span>
                            <?php endif; ?>
                          </td>
                        <?php endforeach; ?>

                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            <?php endif; ?>
          </div>

        </div>
      </div>
    </div>

  <?php endif; ?>

</div>

<!-- Offcanvas Recent Patients Drawer -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="recentPatientsOffcanvas" aria-labelledby="recentPatientsLabel">
  <div class="offcanvas-header border-bottom">
    <h5 class="offcanvas-title fw-bold" id="recentPatientsLabel"><i class="fas fa-users text-primary me-2"></i> Recent Patients</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body p-0">
    <div class="list-group list-group-flush">
      <?php foreach ($recent_patients as $rp): ?>
        <a href="patient_history.php?patient_id=<?= $rp['patient_id'] ?>" class="list-group-item list-group-item-action p-3 <?= ($rp['patient_id'] == $patient_id) ? 'active' : '' ?>">
          <div class="d-flex justify-content-between align-items-center mb-1">
            <strong class="mb-0"><?= htmlspecialchars($rp['full_name']) ?></strong>
            <span class="badge <?= ($rp['patient_id'] == $patient_id) ? 'bg-white text-primary' : 'bg-primary bg-opacity-10 text-primary' ?>">
              UHID #<?= $rp['patient_id'] ?>
            </span>
          </div>
          <div class="small <?= ($rp['patient_id'] == $patient_id) ? 'text-white-50' : 'text-muted' ?>">
            <span><i class="fas fa-phone me-1"></i> <?= htmlspecialchars($rp['phone'] ?: 'No Phone') ?></span>
            <span class="mx-1">•</span>
            <span><?= $rp['visit_count'] ?> Visits</span>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
