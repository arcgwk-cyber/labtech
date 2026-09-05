<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'auth_check.php';
include 'db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$bill_id = isset($_GET['bill_id']) ? (int)$_GET['bill_id'] : 0;

/* ==========================================================================
   SCREEN A: PATIENT & BILL SELECTION PORTAL (When bill_id is not specified)
   ========================================================================== */
if ($bill_id <= 0) {
    // Collect Filters & Sorting
    $search        = trim($_GET['search'] ?? '');
    $status_filter = trim($_GET['status'] ?? 'all');
    $sample_filter = trim($_GET['sample'] ?? 'all');
    $start_date    = trim($_GET['start_date'] ?? '');
    $end_date      = trim($_GET['end_date'] ?? '');
    $sort          = trim($_GET['sort'] ?? 'bill_desc');

    $page   = (isset($_GET['page']) && is_numeric($_GET['page']) && (int)$_GET['page'] > 0) ? (int)$_GET['page'] : 1;
    $limit  = 25;
    $offset = ($page - 1) * $limit;

    // Sorting Clause
    $orderSql = match($sort) {
        'bill_asc'  => "ORDER BY b.bill_id ASC",
        'date_desc' => "ORDER BY b.bill_date DESC, b.bill_id DESC",
        'date_asc'  => "ORDER BY b.bill_date ASC, b.bill_id ASC",
        default     => "ORDER BY b.bill_id DESC" // Default: Newest Bill first
    };

    // Where Clause
    $whereClause = "WHERE 1=1";
    $params = [];
    $types  = "";

    if ($search !== '') {
        $whereClause .= " AND (p.full_name LIKE ? OR p.phone LIKE ? OR CAST(b.bill_id AS CHAR) LIKE ?)";
        $term = "%" . $search . "%";
        $params[] = $term;
        $params[] = $term;
        $params[] = $term;
        $types .= "sss";
    }

    if ($sample_filter !== '' && $sample_filter !== 'all') {
        $whereClause .= " AND s.status = ?";
        $params[] = $sample_filter;
        $types .= "s";
    }

    if ($start_date !== '' && $end_date !== '') {
        $whereClause .= " AND b.bill_date BETWEEN ? AND ?";
        $params[] = $start_date;
        $params[] = $end_date;
        $types .= "ss";
    }

    // Results status filter (completed vs pending)
    if ($status_filter === 'completed') {
        $whereClause .= " AND (SELECT COUNT(*) FROM test_results tr WHERE tr.bill_id = b.bill_id) > 0";
    } elseif ($status_filter === 'pending') {
        $whereClause .= " AND (SELECT COUNT(*) FROM test_results tr WHERE tr.bill_id = b.bill_id) = 0";
    }

    // Count Total Matching Rows
    $countSql = "
        SELECT COUNT(DISTINCT b.bill_id) AS total 
        FROM bills b
        JOIN patients p ON b.patient_id = p.patient_id
        LEFT JOIN test_samples s ON b.bill_id = s.bill_id
        {$whereClause}
    ";
    $countStmt = $conn->prepare($countSql);
    if (!empty($params)) {
        $countStmt->bind_param($types, ...$params);
    }
    $countStmt->execute();
    $totalRows  = (int)($countStmt->get_result()->fetch_assoc()['total'] ?? 0);
    $totalPages = ceil($totalRows / $limit) ?: 1;
    $countStmt->close();

    // Query Summary Statistics
    $statsSql = "
        SELECT 
            COUNT(DISTINCT b.bill_id) as total_bills,
            COUNT(DISTINCT CASE WHEN s.status = 'collected' THEN b.bill_id END) as samples_collected,
            COUNT(DISTINCT CASE WHEN (SELECT COUNT(*) FROM test_results tr WHERE tr.bill_id = b.bill_id) > 0 THEN b.bill_id END) as results_entered,
            COUNT(DISTINCT CASE WHEN (SELECT COUNT(*) FROM test_results tr WHERE tr.bill_id = b.bill_id) = 0 THEN b.bill_id END) as results_pending
        FROM bills b
        JOIN patients p ON b.patient_id = p.patient_id
        LEFT JOIN test_samples s ON b.bill_id = s.bill_id
        {$whereClause}
    ";
    $statsStmt = $conn->prepare($statsSql);
    if (!empty($params)) {
        $statsStmt->bind_param($types, ...$params);
    }
    $statsStmt->execute();
    $stats = $statsStmt->get_result()->fetch_assoc();
    $statsStmt->close();

    // Query Main Patients/Bills for Result Entry
    $mainSql = "
        SELECT b.*, p.full_name, p.gender, p.age, p.phone,
               s.status as sample_status,
               (SELECT COUNT(*) FROM bill_tests bt WHERE bt.bill_id = b.bill_id) as test_count,
               (SELECT COUNT(*) FROM test_results tr WHERE tr.bill_id = b.bill_id) as entered_results_count
        FROM bills b
        JOIN patients p ON b.patient_id = p.patient_id
        LEFT JOIN test_samples s ON b.bill_id = s.bill_id
        {$whereClause}
        GROUP BY b.bill_id
        {$orderSql}
        LIMIT ? OFFSET ?
    ";
    $mainStmt = $conn->prepare($mainSql);
    $mainParams = $params;
    $mainParams[] = $limit;
    $mainParams[] = $offset;
    $mainTypes = $types . 'ii';
    $mainStmt->bind_param($mainTypes, ...$mainParams);
    $mainStmt->execute();
    $billsResult = $mainStmt->get_result();

    function buildSelectionUrl($overrides = []) {
        $current = [
            'search'     => $_GET['search'] ?? '',
            'status'     => $_GET['status'] ?? 'all',
            'sample'     => $_GET['sample'] ?? 'all',
            'start_date' => $_GET['start_date'] ?? '',
            'end_date'   => $_GET['end_date'] ?? '',
            'sort'       => $_GET['sort'] ?? 'bill_desc',
            'page'       => $_GET['page'] ?? 1
        ];
        $merged = array_merge($current, $overrides);
        $filtered = array_filter($merged, fn($v) => $v !== '' && $v !== null);
        return 'result_entry.php?' . http_build_query($filtered);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Diagnostic Results Entry | Patient Portal</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
  <style>
    :root {
      --primary-color: #0284c7;
      --bg-surface: #f8fafc;
      --border-color: #e2e8f0;
    }

    body {
      background-color: var(--bg-surface);
      font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
      font-size: 13px;
      color: #334155;
    }

    .page-container {
      max-width: 1600px;
      margin: 15px auto;
      padding: 0 15px;
    }

    /* Page Header Card */
    .title-card {
      background: #ffffff;
      border: 1px solid var(--border-color);
      border-radius: 12px;
      padding: 18px 24px;
      box-shadow: 0 1px 3px rgba(0,0,0,0.02);
      margin-bottom: 16px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    /* Quick KPI Stat Cards */
    .stats-row {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
      gap: 14px;
      margin-bottom: 16px;
    }

    .stat-pill-card {
      background: #ffffff;
      border: 1px solid var(--border-color);
      border-radius: 10px;
      padding: 14px 18px;
      box-shadow: 0 1px 3px rgba(0,0,0,0.02);
      transition: all 0.2s;
    }

    .stat-pill-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .stat-num {
      font-size: 22px;
      font-weight: 700;
      color: #0f172a;
      line-height: 1.2;
    }

    .stat-desc {
      font-size: 11px;
      font-weight: 600;
      color: #64748b;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      margin-top: 4px;
    }

    /* Filter Toolbar Card */
    .filter-card {
      background: #ffffff;
      border: 1px solid var(--border-color);
      border-radius: 12px;
      padding: 16px;
      margin-bottom: 16px;
      display: flex;
      flex-wrap: wrap;
      gap: 12px;
      align-items: flex-end;
    }

    .form-label-sm {
      font-size: 11.5px;
      font-weight: 600;
      color: #475569;
      margin-bottom: 4px;
      display: block;
    }

    .input-sm-custom {
      padding: 7px 12px;
      font-size: 13px;
      height: 36px;
      border: 1px solid #cbd5e1;
      border-radius: 6px;
      background-color: white;
      width: 100%;
      transition: all 0.2s;
    }

    .input-sm-custom:focus {
      border-color: var(--primary-color);
      box-shadow: 0 0 0 2px rgba(2, 132, 199, 0.15);
      outline: none;
    }

    /* Scrollable Table Card with Sticky Header */
    .table-card {
      background: #ffffff;
      border: 1px solid var(--border-color);
      border-radius: 12px;
      box-shadow: 0 4px 6px -1px rgba(0,0,0,0.04);
      overflow: hidden;
    }

    .table-scroll-wrap {
      max-height: 650px;
      overflow-y: auto;
      overflow-x: auto;
    }

    .table-sticky-head thead th {
      position: sticky;
      top: 0;
      background-color: #f1f5f9;
      z-index: 5;
      box-shadow: 0 1px 2px rgba(0,0,0,0.05);
      padding: 11px 14px;
      font-weight: 600;
      color: #334155;
      border-bottom: 2px solid var(--border-color);
      white-space: nowrap;
    }

    .table-sticky-head td {
      padding: 11px 14px;
      border-bottom: 1px solid var(--border-color);
      vertical-align: middle;
      background-color: #ffffff;
    }

    .table-sticky-head tbody tr:hover td {
      background-color: #f8fafc;
    }

    .btn-action-custom {
      padding: 6px 14px;
      font-size: 12px;
      font-weight: 600;
      border-radius: 6px;
      display: inline-flex;
      align-items: center;
      gap: 5px;
      transition: all 0.2s;
      text-decoration: none;
    }

    .badge-pill-custom {
      display: inline-flex;
      align-items: center;
      padding: 4px 10px;
      border-radius: 20px;
      font-size: 11px;
      font-weight: 600;
    }

    /* =======================================================
       MOBILE APP RESPONSIVE CARDS (result_entry Screen A)
       ======================================================= */
    @media (max-width: 991.98px) {
      .page-container {
        padding: 0 10px !important;
        margin: 10px auto !important;
      }
      .title-card {
        padding: 12px 16px !important;
        flex-direction: column !important;
        align-items: flex-start !important;
        gap: 10px !important;
      }
      .title-card .d-flex {
        width: 100% !important;
      }
      .title-card .d-flex a {
        flex: 1 !important;
        justify-content: center !important;
      }
      .stats-row {
        grid-template-columns: repeat(2, 1fr) !important;
        gap: 8px !important;
        margin-bottom: 12px !important;
      }
      .stat-pill-card {
        padding: 10px 12px !important;
      }
      .stat-num {
        font-size: 18px !important;
      }
      .filter-card {
        padding: 12px !important;
      }
      .filter-card .col-md-4,
      .filter-card .col-md-2,
      .filter-card .col-auto {
        width: 100% !important;
        flex: 1 1 100% !important;
      }
      .filter-card .col-auto {
        display: flex !important;
        gap: 8px !important;
      }
      .filter-card .col-auto button,
      .filter-card .col-auto a {
        flex: 1 !important;
        justify-content: center !important;
      }

      /* Native Mobile Cards for Invoice Table */
      .results-table thead {
        display: none !important;
      }
      .results-table, .results-table tbody, .results-table tr {
        display: block !important;
        width: 100% !important;
      }
      .results-table tr {
        background: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 12px !important;
        padding: 14px !important;
        margin-bottom: 12px !important;
        box-shadow: 0 2px 6px rgba(15, 23, 42, 0.04) !important;
      }
      .results-table td {
        display: flex !important;
        justify-content: space-between !important;
        align-items: center !important;
        padding: 6px 0 !important;
        border: none !important;
        border-bottom: 1px solid #f8fafc !important;
      }
      .results-table td:last-child {
        border-bottom: none !important;
        padding-top: 10px !important;
        flex-direction: column !important;
        align-items: stretch !important;
      }
      .results-table td::before {
        content: attr(data-label);
        font-weight: 700;
        font-size: 11px;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
      }
      .results-table td:last-child::before {
        display: none !important;
      }
      .results-table td:last-child .d-flex {
        width: 100% !important;
        gap: 8px !important;
      }
      .results-table td:last-child .d-flex a {
        flex: 1 !important;
        justify-content: center !important;
        padding: 8px 10px !important;
      }
    }

  </style>
</head>
<body>
<?php include_once __DIR__ . '/header.php'; ?>

<div class="page-container">

  <!-- Clean Title Card -->
  <div class="title-card">
    <div>
      <h4 class="fw-bold mb-1 text-dark">
        <i class="fas fa-notes-medical text-primary me-2"></i> Diagnostic Test Results Entry
      </h4>
      <p class="text-muted mb-0 small">Select a patient invoice below to record parameters, test values, and verify reference ranges.</p>
    </div>
    <div class="d-flex gap-2">
      <a href="sample_collection.php" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-vial me-1"></i> Sample Collection
      </a>
      <a href="bill_list.php" class="btn btn-primary btn-sm">
        <i class="fas fa-file-invoice me-1"></i> All Bills
      </a>
    </div>
  </div>

  <!-- KPI Summary Stats -->
  <div class="stats-row">
    <div class="stat-pill-card">
      <div class="stat-num text-dark"><?= number_format($stats['total_bills'] ?? 0) ?></div>
      <div class="stat-desc">Total Invoices</div>
    </div>
    <div class="stat-pill-card">
      <div class="stat-num text-warning"><?= number_format($stats['results_pending'] ?? 0) ?></div>
      <div class="stat-desc">Awaiting Results</div>
    </div>
    <div class="stat-pill-card">
      <div class="stat-num text-success"><?= number_format($stats['results_entered'] ?? 0) ?></div>
      <div class="stat-desc">Results Recorded</div>
    </div>
    <div class="stat-pill-card">
      <div class="stat-num text-primary"><?= number_format($stats['samples_collected'] ?? 0) ?></div>
      <div class="stat-desc">Samples Ready</div>
    </div>
  </div>

  <!-- Responsive Filter Toolbar Card -->
  <form method="GET" class="filter-card">
    <!-- Search Bar -->
    <div style="flex: 2; min-width: 230px;">
      <label class="form-label-sm"><i class="bi bi-search me-1"></i> Search Patient / Phone / Bill #</label>
      <input type="text" name="search" class="input-sm-custom" placeholder="Search by patient name, mobile or bill ID..." value="<?= htmlspecialchars($search) ?>">
    </div>

    <!-- Results Status Filter -->
    <div style="flex: 1.2; min-width: 160px;">
      <label class="form-label-sm">Result Status</label>
      <select name="status" class="input-sm-custom">
        <option value="all" <?= $status_filter === 'all' ? 'selected' : '' ?>>All Result Status</option>
        <option value="pending" <?= $status_filter === 'pending' ? 'selected' : '' ?>>Pending Results</option>
        <option value="completed" <?= $status_filter === 'completed' ? 'selected' : '' ?>>Results Completed</option>
      </select>
    </div>

    <!-- Sample Collection Filter -->
    <div style="flex: 1.2; min-width: 160px;">
      <label class="form-label-sm">Sample Status</label>
      <select name="sample" class="input-sm-custom">
        <option value="all" <?= $sample_filter === 'all' ? 'selected' : '' ?>>All Samples</option>
        <option value="collected" <?= $sample_filter === 'collected' ? 'selected' : '' ?>>Collected (Ready)</option>
        <option value="pending" <?= $sample_filter === 'pending' ? 'selected' : '' ?>>Pending Collection</option>
      </select>
    </div>

    <!-- Sort Dropdown -->
    <div style="flex: 1.5; min-width: 180px;">
      <label class="form-label-sm"><i class="bi bi-arrow-down-up me-1"></i> Sort Order</label>
      <select name="sort" class="input-sm-custom">
        <option value="bill_desc" <?= $sort === 'bill_desc' ? 'selected' : '' ?>>Bill # (Newest to Oldest)</option>
        <option value="bill_asc" <?= $sort === 'bill_asc' ? 'selected' : '' ?>>Bill # (Oldest to Newest)</option>
        <option value="date_desc" <?= $sort === 'date_desc' ? 'selected' : '' ?>>Date (New to Old)</option>
        <option value="date_asc" <?= $sort === 'date_asc' ? 'selected' : '' ?>>Date (Old to New)</option>
      </select>
    </div>

    <!-- Optional Date Range -->
    <div style="flex: 1; min-width: 130px;">
      <label class="form-label-sm">Date From (Optional)</label>
      <input type="date" name="start_date" class="input-sm-custom" value="<?= htmlspecialchars($start_date) ?>">
    </div>
    <div style="flex: 1; min-width: 130px;">
      <label class="form-label-sm">Date To (Optional)</label>
      <input type="date" name="end_date" class="input-sm-custom" value="<?= htmlspecialchars($end_date) ?>">
    </div>

    <!-- Action Buttons -->
    <div class="d-flex align-items-end gap-2">
      <button type="submit" class="btn btn-primary btn-sm px-3" style="height: 36px;">
        <i class="bi bi-funnel me-1"></i> Filter
      </button>
      <a href="result_entry.php" class="btn btn-outline-secondary btn-sm px-3" style="height: 36px;" title="Reset all filters">
        <i class="bi bi-x-circle me-1"></i> Clear
      </a>
    </div>
  </form>

  <!-- Scrollable Table Card -->
  <div class="table-card">
    <div class="table-scroll-wrap">
      <table class="table table-sticky-head table-hover mb-0">
        <thead>
          <tr>
            <th>
              <a href="<?= buildSelectionUrl(['sort' => ($sort === 'bill_desc' ? 'bill_asc' : 'bill_desc')]) ?>" class="text-decoration-none text-dark">
                Bill # <i class="bi bi-arrow-down-up small text-muted"></i>
              </a>
            </th>
            <th>
              <a href="<?= buildSelectionUrl(['sort' => ($sort === 'date_desc' ? 'date_asc' : 'date_desc')]) ?>" class="text-decoration-none text-dark">
                Invoice Date <i class="bi bi-arrow-down-up small text-muted"></i>
              </a>
            </th>
            <th>Patient Details</th>
            <th>Contact Phone</th>
            <th>Tests Billed</th>
            <th>Sample Status</th>
            <th>Results Status</th>
            <th class="text-end" style="min-width: 180px;">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($billsResult && $billsResult->num_rows > 0): ?>
            <?php while ($b = $billsResult->fetch_assoc()): 
              $isEntered = $b['entered_results_count'] > 0;
            ?>
              <tr>
                <td data-label="Bill #">
                  <strong class="text-primary font-monospace fs-6">#<?= $b['bill_id'] ?></strong>
                </td>
                <td data-label="Date">
                  <div class="text-end text-md-start">
                    <div><?= date('d M Y', strtotime($b['bill_date'])) ?></div>
                    <small class="text-muted"><?= date('D', strtotime($b['bill_date'])) ?></small>
                  </div>
                </td>
                <td data-label="Patient">
                  <div class="text-end text-md-start">
                    <div class="fw-bold text-dark"><?= htmlspecialchars($b['full_name']) ?></div>
                    <small class="text-muted"><?= htmlspecialchars($b['age'] ? $b['age'] . ' yrs' : 'N/A') ?> / <?= ucfirst($b['gender'] ?? '') ?></small>
                  </div>
                </td>
                <td data-label="Phone">
                  <div class="text-end text-md-start"><?= htmlspecialchars($b['phone'] ?: 'N/A') ?></div>
                </td>
                <td data-label="Ordered">
                  <div class="text-end text-md-start"><span class="badge bg-light text-dark border"><?= $b['test_count'] ?> Tests</span></div>
                </td>
                <td data-label="Sample Status">
                  <?php
                  $sStatus = strtolower($b['sample_status'] ?? 'pending');
                  $sBadge = match($sStatus) {
                    'completed' => 'bg-success-subtle text-success border border-success-subtle',
                    'collected' => 'bg-info-subtle text-info border border-info-subtle',
                    default     => 'bg-warning-subtle text-warning border border-warning-subtle'
                  };
                  ?>
                  <span class="badge-pill-custom <?= $sBadge ?>">
                    <i class="bi bi-circle-fill me-1" style="font-size: 6px;"></i>
                    <?= ucfirst($sStatus) ?>
                  </span>
                </td>
                <td data-label="Results Status">
                  <?php if ($isEntered): ?>
                    <span class="badge-pill-custom bg-success text-white">
                      <i class="bi bi-check2-circle me-1"></i> Recorded
                    </span>
                  <?php else: ?>
                    <span class="badge-pill-custom bg-secondary-subtle text-secondary border">
                      <i class="bi bi-hourglass me-1"></i> Awaiting Entry
                    </span>
                  <?php endif; ?>
                </td>
                <td data-label="Action" class="text-end">
                  <div class="d-flex justify-content-end gap-1">
                    <a href="result_entry.php?bill_id=<?= $b['bill_id'] ?>" class="btn-action-custom btn-primary" title="Enter / Update Test Results">
                      <i class="fas fa-keyboard"></i> <?= $isEntered ? 'Edit Results' : 'Enter Results' ?>
                    </a>
                    <?php if ($isEntered): ?>
                      <a href="pdf_options.php?bill_id=<?= $b['bill_id'] ?>" class="btn-action-custom btn-outline-danger" title="Configure, Preview & Print PDF Report">
                        <i class="fas fa-file-pdf"></i> Report
                      </a>
                    <?php endif; ?>
                  </div>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr>
              <td colspan="8" class="text-center py-5">
                <i class="bi bi-clipboard-x fa-3x text-muted mb-2 d-block opacity-50"></i>
                <h6 class="fw-bold text-secondary">No Matching Invoices Found</h6>
                <p class="small text-muted mb-3">Adjust your search keyword or clear filters to view all bills.</p>
                <a href="result_entry.php" class="btn btn-outline-primary btn-sm me-2">Show All Bills</a>
                <a href="bill_add.php" class="btn btn-primary btn-sm">+ Create New Bill</a>
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- Pagination Bar -->
    <?php if ($totalPages > 1): ?>
      <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2 p-3 border-top bg-light">
        <small class="text-muted">
          Showing page <strong><?= $page ?></strong> of <strong><?= $totalPages ?></strong> (<?= number_format($totalRows) ?> total patient invoices)
        </small>

        <nav>
          <ul class="pagination pagination-sm mb-0">
            <?php if ($page > 1): ?>
              <li class="page-item">
                <a class="page-link" href="<?= buildSelectionUrl(['page' => $page - 1]) ?>">
                  <i class="bi bi-chevron-left"></i> Prev
                </a>
              </li>
            <?php endif; ?>

            <?php
            $startP = max(1, $page - 3);
            $endP   = min($totalPages, $page + 3);
            for ($i = $startP; $i <= $endP; $i++):
            ?>
              <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                <a class="page-link" href="<?= buildSelectionUrl(['page' => $i]) ?>"><?= $i ?></a>
              </li>
            <?php endfor; ?>

            <?php if ($page < $totalPages): ?>
              <li class="page-item">
                <a class="page-link" href="<?= buildSelectionUrl(['page' => $page + 1]) ?>">
                  Next <i class="bi bi-chevron-right"></i>
                </a>
              </li>
            <?php endif; ?>
          </ul>
        </nav>
      </div>
    <?php endif; ?>

  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
    exit;
}

/* ==========================================================================
   SCREEN B: PARAMETER ENTRY FORM (When a specific bill_id is selected)
   ========================================================================== */
try {
    $patient_stmt = $conn->prepare("
        SELECT p.full_name, p.gender, p.date_of_birth, b.bill_date, p.phone, p.dr_ref
        FROM bills b
        JOIN patients p ON b.patient_id = p.patient_id
        WHERE b.bill_id = ?
    ");
    if (!$patient_stmt) throw new Exception($conn->error);
    $patient_stmt->bind_param("i", $bill_id);
    $patient_stmt->execute();
    $patient = $patient_stmt->get_result()->fetch_assoc();
    $patient_stmt->close();
    if (!$patient) throw new Exception("Patient not found for bill ID #$bill_id.");

    // Calculate age
    $age = 0;
    $is_child = false;
    $dob = $patient['date_of_birth'] ?? null;
    if (!empty($dob)) {
        $dob_obj = new DateTime($dob);
        $today = new DateTime();
        $age = $today->diff($dob_obj)->y;
        $is_child = $age < 12;
    }

    $test_stmt = $conn->prepare("
        SELECT 
            lt.test_name,
            lt.test_id,
            p.parameter_id, p.param_name, p.unit, p.method, p.interpretation,
            rr.male_min, rr.male_max, rr.male_default,
            rr.female_min, rr.female_max, rr.female_default,
            rr.child_min, rr.child_max, rr.child_default,
            rr.use_reference_text, rr.reference_text
        FROM (
            SELECT bt.test_id FROM bill_tests bt WHERE bt.bill_id = ?
            UNION
            SELECT pt.test_id FROM bill_packages bp
            JOIN package_test_map pt ON bp.package_id = pt.package_id
            WHERE bp.bill_id = ?
        ) AS all_tests
        JOIN lab_tests lt ON all_tests.test_id = lt.test_id
        JOIN lab_test_parameters ltp ON lt.test_id = ltp.test_id
        JOIN test_parameters p ON ltp.parameter_id = p.parameter_id
        LEFT JOIN parameter_reference_ranges rr ON p.parameter_id = rr.parameter_id
        ORDER BY lt.test_id, ltp.param_order
    ");
    if (!$test_stmt) throw new Exception($conn->error);
    $test_stmt->bind_param("ii", $bill_id, $bill_id);
    $test_stmt->execute();
    $result = $test_stmt->get_result();

    $groupedTests = [];
    while ($row = $result->fetch_assoc()) {
        $groupedTests[$row['test_name']][] = $row;
    }
    $test_stmt->close();

} catch (Exception $e) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Error | Results Entry</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<?php include_once __DIR__ . '/header.php'; ?>
<div class="container py-5 text-center" style="max-width: 600px;">
  <div class="alert alert-danger shadow-sm">
    <i class="bi bi-exclamation-triangle-fill fs-3 d-block mb-2"></i>
    <h5>Unable to Load Test Results</h5>
    <p class="mb-3"><?= htmlspecialchars($e->getMessage()) ?></p>
    <a href="result_entry.php" class="btn btn-primary btn-sm"><i class="bi bi-arrow-left"></i> Back to Patient List</a>
  </div>
</div>
</body>
</html>
<?php
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Enter Test Results - Bill #<?= $bill_id ?> | Laboratory ERP</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
<style>
:root {
  --erp-primary: #0284c7;
  --erp-dark: #0f172a;
  --erp-accent: #0284c7;
  --erp-success: #16a34a;
  --erp-border: #e2e8f0;
  --erp-bg: #f8fafc;
  --erp-card-bg: #ffffff;
}

body {
  background-color: var(--erp-bg);
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  font-size: 13px;
  line-height: 1.4;
  color: #334155;
}

.erp-container {
  max-width: 1400px;
  margin: 15px auto;
  padding: 0 15px;
}

/* Modern Clean White Card Header - Matching Theme */
.erp-header {
  background: #ffffff;
  color: #0f172a;
  padding: 16px 24px;
  border-radius: 12px 12px 0 0;
  display: flex;
  justify-content: space-between;
  align-items: center;
  border-bottom: 1px solid var(--erp-border);
}

.erp-header h1 {
  font-size: 18px;
  font-weight: 700;
  color: #0f172a;
  margin: 0;
  display: flex;
  align-items: center;
  gap: 10px;
}

.erp-header h1 i {
  color: var(--erp-primary);
}

.erp-header-actions {
  display: flex;
  gap: 8px;
}

/* ERP Card */
.erp-card {
  background-color: var(--erp-card-bg);
  border-radius: 12px;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.04);
  border: 1px solid var(--erp-border);
  margin-bottom: 25px;
  overflow: hidden;
}

.erp-card-body {
  padding: 20px;
}

/* Patient Information Bar */
.patient-info-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
  gap: 12px;
  background-color: #f8fafc;
  padding: 14px 18px;
  border-radius: 8px;
  margin-bottom: 20px;
  border: 1px solid var(--erp-border);
}

.info-item {
  display: flex;
  flex-direction: column;
}

.info-label {
  font-size: 11px;
  font-weight: 600;
  color: #64748b;
  text-transform: uppercase;
}

.info-value {
  font-size: 13.5px;
  font-weight: 600;
  color: #0f172a;
}

/* Test Group Cards */
.test-group {
  margin-bottom: 20px;
  border: 1px solid var(--erp-border);
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 1px 3px rgba(0,0,0,0.02);
}

.test-group-header {
  background: #f1f5f9;
  color: #0f172a;
  padding: 10px 16px;
  font-size: 14px;
  font-weight: 700;
  display: flex;
  justify-content: space-between;
  align-items: center;
  border-bottom: 1px solid var(--erp-border);
}

.test-count {
  background-color: #e2e8f0;
  color: #475569;
  font-size: 11px;
  padding: 3px 10px;
  border-radius: 10px;
  font-weight: 600;
}

/* Table */
.compact-table {
  width: 100%;
  border-collapse: separate;
  border-spacing: 0;
  font-size: 12.5px;
}

.compact-table thead th {
  background-color: #ffffff;
  padding: 10px 14px;
  font-weight: 600;
  color: #334155;
  border-bottom: 2px solid var(--erp-border);
  text-align: left;
}

.compact-table td {
  padding: 10px 14px;
  border-bottom: 1px solid var(--erp-border);
  vertical-align: middle;
  background-color: #ffffff;
}

.compact-table tbody tr:hover td {
  background-color: #f8fafc;
}

/* Inputs */
.erp-input {
  width: 100%;
  padding: 7px 12px;
  font-size: 13px;
  border: 1px solid #cbd5e1;
  border-radius: 6px;
  background-color: white;
  transition: all 0.2s;
}

.erp-input:focus {
  border-color: var(--erp-primary);
  box-shadow: 0 0 0 2px rgba(2, 132, 199, 0.15);
  outline: none;
}

.erp-input.is-invalid {
  border-color: #dc2626;
  background-color: #fef2f2;
}

/* Buttons */
.erp-btn {
  padding: 7px 16px;
  font-size: 12.5px;
  font-weight: 600;
  border-radius: 6px;
  border: 1px solid transparent;
  cursor: pointer;
  transition: all 0.2s;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  text-decoration: none;
}

.erp-btn-primary { background-color: var(--erp-primary); color: white; }
.erp-btn-primary:hover { background-color: #0369a1; color: white; }
.erp-btn-success { background-color: var(--erp-success); color: white; }
.erp-btn-success:hover { background-color: #15803d; color: white; }
.erp-btn-outline { background-color: white; border-color: #cbd5e1; color: #475569; }
.erp-btn-outline:hover { background-color: #f1f5f9; color: #0f172a; }

.range-display {
  font-family: 'Consolas', monospace;
  font-size: 11.5px;
  color: #475569;
  background-color: #f8fafc;
  padding: 4px 10px;
  border-radius: 4px;
  border: 1px solid #e2e8f0;
  display: inline-block;
}

/* Sticky Action Bar at Bottom */

/* =======================================================
   MOBILE APP RESPONSIVE CARDS (result_entry Screen B)
   ======================================================= */
@media (max-width: 991.98px) {
  .erp-container {
    padding: 0 10px !important;
    margin: 10px auto !important;
  }
  .erp-header {
    padding: 12px 16px !important;
    flex-direction: column !important;
    align-items: flex-start !important;
    gap: 10px !important;
  }
  .erp-header-actions {
    width: 100% !important;
  }
  .erp-header-actions a,
  .erp-header-actions button {
    flex: 1 !important;
    justify-content: center !important;
  }
  .erp-card-body {
    padding: 12px !important;
  }
  .patient-info-grid {
    grid-template-columns: repeat(2, 1fr) !important;
    gap: 8px !important;
    margin-bottom: 15px !important;
  }
  .info-item {
    padding: 8px 10px !important;
  }

  /* Transform Parameter Table to Mobile Cards */
  .compact-table thead {
    display: none !important;
  }
  .compact-table, .compact-table tbody, .compact-table tr {
    display: block !important;
    width: 100% !important;
  }
  .compact-table tr {
    background: #ffffff !important;
    border: 1px solid var(--erp-border) !important;
    border-radius: 10px !important;
    padding: 12px !important;
    margin-bottom: 10px !important;
    box-shadow: 0 2px 5px rgba(15, 23, 42, 0.03) !important;
  }
  .compact-table td {
    display: block !important;
    width: 100% !important;
    padding: 4px 0 !important;
    border: none !important;
  }
  .compact-table td:nth-child(2) {
    margin: 6px 0 !important;
  }
  .compact-table td .erp-input {
    font-size: 15px !important;
    font-weight: 700 !important;
    padding: 9px 12px !important;
  }
  .sticky-footer-bar {
    padding: 10px 14px !important;
    flex-direction: column !important;
    gap: 10px !important;
    bottom: 64px !important; /* Above bottom nav */
  }
  .sticky-footer-bar .d-flex {
    width: 100% !important;
  }
  .sticky-footer-bar .d-flex a,
  .sticky-footer-bar .d-flex button {
    flex: 1 !important;
    justify-content: center !important;
    padding: 10px !important;
  }
}

.sticky-footer-bar {
  position: sticky;
  bottom: 0;
  background: #ffffff;
  border-top: 1px solid var(--erp-border);
  box-shadow: 0 -4px 10px rgba(0,0,0,0.05);
  padding: 12px 24px;
  z-index: 100;
  display: flex;
  justify-content: space-between;
  align-items: center;
  border-radius: 0 0 12px 12px;
}
</style>
</head>
<body>
<?php include_once __DIR__ . '/header.php'; ?>

<div class="erp-container">
    <?php if (isset($_GET['saved']) && $_GET['saved'] == 1): ?>
    <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
      <i class="bi bi-check-circle-fill me-2"></i> <strong>Test Results Saved Successfully!</strong> The patient diagnostic report has been compiled and updated.
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <div class="erp-card">
        <!-- Clean Title Bar -->
        <div class="erp-header">
            <div>
              <h1>
                  <i class="bi bi-clipboard-data"></i>
                  Enter Results - Bill #<?= $bill_id ?>
              </h1>
              <small class="text-muted">Recording clinical findings for <strong><?= htmlspecialchars($patient['full_name']) ?></strong></small>
            </div>
            <div class="erp-header-actions">
                <a href="result_entry.php" class="erp-btn erp-btn-outline">
                    <i class="bi bi-arrow-left"></i> Back to Patient List
                </a>
                <a href="pdf_options.php?bill_id=<?= $bill_id ?>" class="erp-btn erp-btn-outline">
                    <i class="bi bi-file-earmark-pdf"></i> Print / PDF Report
                </a>
                <button type="button" class="erp-btn erp-btn-primary" onclick="window.print()">
                    <i class="bi bi-printer"></i> Print Worksheet
                </button>
            </div>
        </div>
        
        <div class="erp-card-body">
            <!-- Compact Patient Information -->
            <div class="patient-info-grid">
                <div class="info-item">
                    <span class="info-label">Patient Name</span>
                    <span class="info-value"><?= htmlspecialchars($patient['full_name']); ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Gender / Age</span>
                    <span class="info-value"><?= ucfirst($patient['gender']); ?> / <?= $dob ? $age . " years" : "N/A"; ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Bill ID</span>
                    <span class="info-value">#<?= htmlspecialchars($bill_id); ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Invoice Date</span>
                    <span class="info-value"><?= htmlspecialchars($patient['bill_date']); ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Referring Doctor</span>
                    <span class="info-value"><?= htmlspecialchars($patient['dr_ref'] ?: 'Self / Walk-in'); ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Age Category</span>
                    <span class="info-value"><?= $is_child ? '<span class="badge bg-info">Child (<12)</span>' : '<span class="badge bg-secondary">Adult</span>'; ?></span>
                </div>
            </div>

            <form method="post" action="save_results.php" id="resultForm" novalidate>
                <input type="hidden" name="bill_id" value="<?= $bill_id; ?>">
                
                <datalist id="commonResults">
                    <option value="Normal"><option value="Abnormal"><option value="Reactive">
                    <option value="Non-Reactive"><option value="Positive"><option value="Negative">
                    <option value="Absent"><option value="Present"><option value="NAD">
                </datalist>

                <?php if (!empty($groupedTests)): ?>
                    <?php foreach ($groupedTests as $testName => $parameters): ?>
                    <div class="test-group">
                        <div class="test-group-header">
                            <span><i class="fas fa-flask text-primary me-2"></i><?= htmlspecialchars($testName) ?></span>
                            <span class="test-count"><?= count($parameters) ?> parameters</span>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="compact-table">
                                <thead>
                                    <tr>
                                        <th style="width: 32%;">Parameter Name</th>
                                        <th style="width: 28%;">Result Value</th>
                                        <th style="width: 14%;">Unit</th>
                                        <th style="width: 26%;">Normal Reference Range</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($parameters as $row):
                                    $param_id = $row['parameter_id'];
                                    $test_id = $row['test_id'];
                                    
                                    // Determine reference range based on age and gender
                                    if ($is_child) {
                                        $default = $row['child_default'];
                                        $min = $row['child_min'];
                                        $max = $row['child_max'];
                                    } elseif (strtolower($patient['gender']) === 'female') {
                                        $default = $row['female_default'];
                                        $min = $row['female_min'];
                                        $max = $row['female_max'];
                                    } else {
                                        $default = $row['male_default'];
                                        $min = $row['male_min'];
                                        $max = $row['male_max'];
                                    }
                                    
                                    // Check existing recorded result from database if present
                                    $prevResult = '';
                                    $prevQ = $conn->query("SELECT result_value FROM test_results WHERE bill_id = $bill_id AND parameter_id = $param_id LIMIT 1");
                                    if ($prevQ && $pr = $prevQ->fetch_assoc()) {
                                        $prevResult = $pr['result_value'];
                                    }
                                    $currentVal = $prevResult !== '' ? $prevResult : ($default ?? '');

                                    // Format range display
                                    if ($row['use_reference_text'] && trim($row['reference_text'])) {
                                        $range_display = $row['reference_text'];
                                    } elseif (is_numeric($min) && is_numeric($max)) {
                                        $range_display = "$min - $max";
                                    } elseif (is_numeric($min)) {
                                        $range_display = "≥ $min";
                                    } elseif (is_numeric($max)) {
                                        $range_display = "≤ $max";
                                    } else {
                                        $range_display = 'As per clinical correlation';
                                    }
                                ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="fw-bold text-dark fs-6"><?= htmlspecialchars($row['param_name']) ?></div>
                                                <span class="d-md-none range-display"><?= htmlspecialchars($range_display) ?> <?= htmlspecialchars($row['unit'] ?: '') ?></span>
                                            </div>
                                            <?php if (!empty($row['method'])): ?>
                                            <small class="text-muted">Method: <?= htmlspecialchars($row['method']) ?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <input type="text"
                                                   name="results[<?= $param_id ?>]"
                                                   list="commonResults"
                                                   class="erp-input"
                                                   value="<?= htmlspecialchars($currentVal) ?>"
                                                   data-min="<?= $min ?>"
                                                   data-max="<?= $max ?>"
                                                   oninput="validateRange(this)"
                                                   autocomplete="off"
                                                   placeholder="Enter <?= htmlspecialchars($row['param_name']) ?>..." />
                                            <input type="hidden" name="test_ids[<?= $param_id ?>]" value="<?= $test_id ?>">
                                        </td>
                                        <td class="d-none d-md-table-cell">
                                            <span class="fw-semibold text-secondary"><?= htmlspecialchars($row['unit'] ?: '--') ?></span>
                                        </td>
                                        <td class="d-none d-md-table-cell">
                                            <span class="range-display"><?= htmlspecialchars($range_display) ?></span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="alert alert-warning text-center py-4">
                        <i class="bi bi-exclamation-triangle fa-2x d-block mb-2"></i>
                        <h6>No tests or parameters assigned to this bill</h6>
                        <p class="small text-muted mb-0">Please verify the bill items in billing management.</p>
                    </div>
                <?php endif; ?>

                <!-- Sticky Footer Action Bar -->
                <div class="sticky-footer-bar">
                    <div class="small text-muted">
                      <i class="bi bi-info-circle me-1"></i> Values outside normal range are highlighted automatically.
                    </div>
                    <div class="d-flex gap-2">
                        <a href="result_entry.php" class="erp-btn erp-btn-outline">Cancel</a>
                        <button type="submit" class="erp-btn erp-btn-success">
                            <i class="bi bi-check-lg"></i> Save All Results
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function validateRange(input) {
    const val = parseFloat(input.value);
    const min = parseFloat(input.dataset.min);
    const max = parseFloat(input.dataset.max);
    
    if (isNaN(val)) {
        input.classList.remove('is-invalid');
        return;
    }
    
    if ((!isNaN(min) && val < min) || (!isNaN(max) && val > max)) {
        input.classList.add('is-invalid');
    } else {
        input.classList.remove('is-invalid');
    }
}

// Initial range validation on load
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.erp-input').forEach(validateRange);
});

// Shortcut Ctrl+Space to clear field
document.addEventListener('keydown', function(e) {
    if (e.ctrlKey && e.code === 'Space') {
        if (document.activeElement && document.activeElement.classList.contains('erp-input')) {
            document.activeElement.value = '';
        }
    }
});

// Confirmation if any abnormal values
document.getElementById('resultForm').addEventListener('submit', function(e) {
    const invalidInputs = document.querySelectorAll('.erp-input.is-invalid');
    if (invalidInputs.length > 0) {
        if (!confirm(`Found ${invalidInputs.length} test parameter(s) outside expected reference range. Save results anyway?`)) {
            e.preventDefault();
            invalidInputs[0].focus();
        }
    }
});
</script>
</body>
</html>
