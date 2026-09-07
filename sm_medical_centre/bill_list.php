<?php
// bill_list.php
include 'auth_check.php';
require_once 'db.php';

// 1. Collect Filter & Sort Inputs (All Bills by default, no date restriction)
$search        = trim($_GET['search'] ?? '');
$sample_filter = trim($_GET['sample'] ?? '');
$start_date    = trim($_GET['start_date'] ?? '');
$end_date      = trim($_GET['end_date'] ?? '');
$sort          = trim($_GET['sort'] ?? 'bill_desc');

$page   = (isset($_GET['page']) && is_numeric($_GET['page']) && (int)$_GET['page'] > 0) ? (int)$_GET['page'] : 1;
$limit  = 30;
$offset = ($page - 1) * $limit;

// 2. Determine Sorting Order
$orderSql = match($sort) {
    'bill_asc'  => "ORDER BY b.bill_id ASC",
    'date_desc' => "ORDER BY b.bill_date DESC, b.bill_id DESC",
    'date_asc'  => "ORDER BY b.bill_date ASC, b.bill_id ASC",
    default     => "ORDER BY b.bill_id DESC" // Default: New to old by Bill No
};

// 3. Build Dynamic Where Clause & Parameters
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

// 4. Count Total Matching Rows for Pagination
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

// 5. Query KPI Statistics for Filtered/All Rows
$statsSql = "
    SELECT 
        COUNT(DISTINCT b.bill_id) as total_bills,
        COALESCE(SUM(b.total_amount), 0) as total_amount,
        COUNT(DISTINCT CASE WHEN s.status = 'completed' THEN b.bill_id END) as completed,
        COUNT(DISTINCT CASE WHEN LOWER(b.payment_status) = 'paid' THEN b.bill_id END) as paid
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

// 6. Fetch Main Bill Records
$mainSql = "
    SELECT b.*, p.full_name, p.phone, 
           s.status as sample_status, s.sample_id,
           COUNT(DISTINCT bt.test_id) + COUNT(DISTINCT bp.package_id) as total_items
    FROM bills b
    JOIN patients p ON b.patient_id = p.patient_id
    LEFT JOIN test_samples s ON b.bill_id = s.bill_id
    LEFT JOIN bill_tests bt ON b.bill_id = bt.bill_id
    LEFT JOIN bill_packages bp ON b.bill_id = bp.bill_id
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
$result = $mainStmt->get_result();

// Helper URL builder for pagination & sorting
function buildUrl($overrides = []) {
    $current = [
        'search'     => $_GET['search'] ?? '',
        'sample'     => $_GET['sample'] ?? '',
        'start_date' => $_GET['start_date'] ?? '',
        'end_date'   => $_GET['end_date'] ?? '',
        'sort'       => $_GET['sort'] ?? 'bill_desc',
        'page'       => $_GET['page'] ?? 1
    ];
    $merged = array_merge($current, $overrides);
    // remove empty
    $filtered = array_filter($merged, fn($v) => $v !== '' && $v !== null);
    return 'bill_list.php?' . http_build_query($filtered);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoices & Bills | Laboratory ERP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --erp-primary: #0284c7;
            --erp-dark: #0f172a;
            --erp-accent: #0284c7;
            --erp-success: #16a34a;
            --erp-warning: #ea580c;
            --erp-danger: #dc2626;
            --erp-border: #e2e8f0;
            --erp-bg: #f8fafc;
            --erp-card-bg: #ffffff;
        }

        body {
            background-color: var(--erp-bg);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 13px;
            color: #334155;
            line-height: 1.4;
        }

        .erp-container {
            max-width: 1600px;
            margin: 15px auto;
            padding: 0 15px;
        }

        /* Clean White Page Header Card - No dark background */
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
            font-size: 20px;
        }

        /* ERP Card */
        .erp-card {
            background-color: var(--erp-card-bg);
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--erp-border);
            margin-bottom: 20px;
            overflow: hidden;
        }

        .erp-card-body {
            padding: 20px;
        }

        /* Compact Form Controls */
        .form-label-compact {
            font-size: 11.5px;
            font-weight: 600;
            color: #475569;
            margin-bottom: 4px;
            display: block;
        }

        .form-control-compact {
            padding: 7px 12px;
            font-size: 13px;
            height: 36px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            background-color: white;
            transition: all 0.2s;
            width: 100%;
        }

        .form-control-compact:focus {
            border-color: var(--erp-primary);
            box-shadow: 0 0 0 2px rgba(2, 132, 199, 0.15);
            outline: none;
        }

        /* Quick Statistics Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 14px;
            margin-bottom: 18px;
        }

        .stat-card {
            background: #ffffff;
            border: 1px solid var(--erp-border);
            border-radius: 10px;
            padding: 14px 18px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        .stat-value {
            font-size: 22px;
            font-weight: 700;
            color: #0f172a;
            line-height: 1.2;
        }

        .stat-label {
            font-size: 11px;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 4px;
        }

        /* Filter Panel */
        .filter-panel {
            background: #f8fafc;
            border: 1px solid var(--erp-border);
            border-radius: 10px;
            padding: 16px;
            margin-bottom: 18px;
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            align-items: flex-end;
        }

        /* Action Buttons */
        .erp-btn {
            padding: 7px 15px;
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
            height: 36px;
        }

        .erp-btn-primary {
            background-color: var(--erp-primary);
            color: white;
        }

        .erp-btn-primary:hover {
            background-color: #0369a1;
            color: white;
            transform: translateY(-1px);
        }

        .erp-btn-success {
            background-color: var(--erp-success);
            color: white;
        }

        .erp-btn-success:hover {
            background-color: #15803d;
            color: white;
            transform: translateY(-1px);
        }

        .erp-btn-outline {
            background-color: white;
            border-color: #cbd5e1;
            color: #475569;
        }

        .erp-btn-outline:hover {
            background-color: #f1f5f9;
            color: #0f172a;
            border-color: #94a3b8;
        }

        /* Compact Table */
        .compact-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 12.5px;
        }

        .compact-table thead {
            background-color: #f1f5f9;
        }

        .compact-table th {
            padding: 10px 14px;
            font-weight: 600;
            color: #334155;
            text-align: left;
            border-bottom: 2px solid var(--erp-border);
            white-space: nowrap;
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

        /* Status Badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            text-transform: capitalize;
        }

        .status-paid { background-color: #dcfce7; color: #166534; }
        .status-partial { background-color: #fef9c3; color: #854d0e; }
        .status-unpaid { background-color: #fee2e2; color: #991b1b; }

        .sample-badge {
            display: inline-flex;
            align-items: center;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }

        .sample-pending { background-color: #fff7ed; color: #9a3412; }
        .sample-collected { background-color: #e0f2fe; color: #075985; }
        .sample-completed { background-color: #f0fdf4; color: #166534; }

        .btn-group-action {
            display: flex;
            gap: 4px;
        }
    
        /* =======================================================
           MOBILE APP RESPONSIVE CARD VIEW (bill_list)
           ======================================================= */
        @media (max-width: 991.98px) {
            .erp-container {
                padding: 0 8px !important;
                margin: 8px auto !important;
            }
            .erp-header {
                padding: 12px 16px !important;
                flex-direction: column !important;
                align-items: flex-start !important;
                gap: 10px !important;
            }
            .erp-header a.erp-btn {
                width: 100% !important;
                justify-content: center !important;
            }
            .erp-card-body {
                padding: 12px !important;
            }
            .stats-grid {
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 8px !important;
                margin-bottom: 12px !important;
            }
            .stat-card {
                padding: 10px 12px !important;
            }
            .stat-value {
                font-size: 18px !important;
            }
            .filter-panel {
                padding: 12px !important;
                gap: 8px !important;
            }
            .filter-panel > div {
                min-width: 100% !important;
                flex: 1 1 100% !important;
            }
            .filter-panel .d-flex {
                width: 100% !important;
                justify-content: space-between !important;
            }
            .filter-panel .d-flex button,
            .filter-panel .d-flex a {
                flex: 1 !important;
                justify-content: center !important;
            }

            /* Transform Table into Native Mobile Cards */
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
                border-radius: 12px !important;
                padding: 14px !important;
                margin-bottom: 12px !important;
                box-shadow: 0 2px 6px rgba(15, 23, 42, 0.04) !important;
            }
            .compact-table td {
                display: flex !important;
                justify-content: space-between !important;
                align-items: center !important;
                padding: 6px 0 !important;
                border: none !important;
                border-bottom: 1px solid #f1f5f9 !important;
            }
            .compact-table td:last-child {
                border-bottom: none !important;
                padding-top: 10px !important;
                flex-direction: column !important;
                align-items: stretch !important;
            }
            .compact-table td::before {
                content: attr(data-label);
                font-weight: 700;
                font-size: 11px;
                color: #64748b;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }
            .compact-table td:last-child::before {
                display: none !important;
            }
            .btn-group-action {
                display: grid !important;
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 6px !important;
                width: 100% !important;
            }
            .btn-group-action a {
                justify-content: center !important;
                padding: 8px 6px !important;
                font-size: 12px !important;
                font-weight: 600 !important;
            }
        }

    </style>
</head>
<body>
<?php include_once __DIR__ . '/header.php'; ?>

<div class="erp-container">
    <div class="erp-card">
        
        <!-- Clean Page Header Bar - Matching Theme -->
        <div class="erp-header">
            <div>
                <h1>
                    <i class="fas fa-file-invoice"></i>
                    Patient Invoices & Bills
                </h1>
                <small class="text-muted">Showing all patient diagnostic bills (Newest to Oldest by default)</small>
            </div>
            <a href="bill_add.php" class="erp-btn erp-btn-success">
                <i class="bi bi-plus-lg"></i> + New Patient Bill
            </a>
        </div>
        
        <div class="erp-card-body">
            
            <!-- Quick Statistics Grid -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-value"><?= number_format($stats['total_bills'] ?? 0) ?></div>
                    <div class="stat-label">Total Invoices</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value" style="color: var(--erp-primary);">₹<?= number_format($stats['total_amount'] ?? 0, 2) ?></div>
                    <div class="stat-label">Billed Amount</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value" style="color: var(--erp-success);"><?= number_format($stats['completed'] ?? 0) ?></div>
                    <div class="stat-label">Completed Tests</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value text-success"><?= number_format($stats['paid'] ?? 0) ?></div>
                    <div class="stat-label">Paid Bills</div>
                </div>
            </div>

            <!-- Responsive Filter & Search Toolbar -->
            <form method="GET" class="filter-panel">
                <!-- Search by Patient Name / Phone / Bill # -->
                <div style="flex: 2; min-width: 230px;">
                    <label class="form-label-compact"><i class="bi bi-search me-1"></i> Search Patient / Phone / Bill #</label>
                    <input type="text" name="search" class="form-control-compact" 
                           placeholder="Type patient name, phone number, or bill ID..." 
                           value="<?= htmlspecialchars($search) ?>">
                </div>

                <!-- Sort Order Dropdown -->
                <div style="flex: 1.5; min-width: 200px;">
                    <label class="form-label-compact"><i class="bi bi-arrow-down-up me-1"></i> Sort Order</label>
                    <select name="sort" class="form-control-compact">
                        <option value="bill_desc" <?= $sort === 'bill_desc' ? 'selected' : '' ?>>Bill # (Newest to Oldest)</option>
                        <option value="bill_asc" <?= $sort === 'bill_asc' ? 'selected' : '' ?>>Bill # (Oldest to Newest)</option>
                        <option value="date_desc" <?= $sort === 'date_desc' ? 'selected' : '' ?>>Date (Newest First)</option>
                        <option value="date_asc" <?= $sort === 'date_asc' ? 'selected' : '' ?>>Date (Oldest First)</option>
                    </select>
                </div>

                <!-- Sample Status -->
                <div style="flex: 1; min-width: 140px;">
                    <label class="form-label-compact">Sample Status</label>
                    <select name="sample" class="form-control-compact">
                        <option value="all">All Status</option>
                        <option value="pending" <?= $sample_filter === 'pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="collected" <?= $sample_filter === 'collected' ? 'selected' : '' ?>>Collected</option>
                        <option value="completed" <?= $sample_filter === 'completed' ? 'selected' : '' ?>>Completed</option>
                    </select>
                </div>

                <!-- Optional Date Range (blank by default to show all bills) -->
                <div style="flex: 1; min-width: 130px;">
                    <label class="form-label-compact">Date From (Optional)</label>
                    <input type="date" name="start_date" class="form-control-compact" 
                           value="<?= htmlspecialchars($start_date) ?>">
                </div>
                <div style="flex: 1; min-width: 130px;">
                    <label class="form-label-compact">Date To (Optional)</label>
                    <input type="date" name="end_date" class="form-control-compact" 
                           value="<?= htmlspecialchars($end_date) ?>">
                </div>

                <!-- Filter Actions -->
                <div class="d-flex align-items-end gap-2">
                    <button type="submit" class="erp-btn erp-btn-primary">
                        <i class="bi bi-funnel"></i> Apply
                    </button>
                    <a href="bill_list.php" class="erp-btn erp-btn-outline" title="Reset and show all bills">
                        <i class="bi bi-x-circle"></i> Clear
                    </a>
                    <a href="export_bills.php?start_date=<?= urlencode($start_date) ?>&end_date=<?= urlencode($end_date) ?>&sample=<?= urlencode($sample_filter) ?>&search=<?= urlencode($search) ?>" 
                       class="erp-btn erp-btn-outline" title="Export matching records to Excel">
                        <i class="bi bi-download"></i> Export
                    </a>
                </div>
            </form>

            <!-- Bills Table -->
            <div class="table-responsive">
                <table class="compact-table">
                    <thead>
                        <tr>
                            <th>
                                <a href="<?= buildUrl(['sort' => ($sort === 'bill_desc' ? 'bill_asc' : 'bill_desc')]) ?>" class="text-decoration-none text-dark">
                                    Bill # <i class="bi bi-arrow-down-up small text-muted"></i>
                                </a>
                            </th>
                            <th>
                                <a href="<?= buildUrl(['sort' => ($sort === 'date_desc' ? 'date_asc' : 'date_desc')]) ?>" class="text-decoration-none text-dark">
                                    Invoice Date <i class="bi bi-arrow-down-up small text-muted"></i>
                                </a>
                            </th>
                            <th>Patient Information</th>
                            <th>Amount (₹)</th>
                            <th>Tests Billed</th>
                            <th>Sample Status</th>
                            <th>Payment Status</th>
                            <th class="text-end" style="width: 190px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <?php
                            // Fetch test names for preview badge
                            $testList = [];
                            $tq = $conn->query("SELECT lt.test_name FROM bill_tests bt JOIN lab_tests lt ON bt.test_id = lt.test_id WHERE bt.bill_id = {$row['bill_id']} LIMIT 3");
                            if ($tq) {
                                while ($tr = $tq->fetch_assoc()) $testList[] = $tr['test_name'];
                            }
                            $testsPreview = implode(', ', $testList);
                            if ($row['total_items'] > count($testList)) {
                                $testsPreview .= ' +' . ($row['total_items'] - count($testList)) . ' more';
                            }
                            ?>
                            <tr>
                                <td data-label="Bill #">
                                    <strong class="text-primary font-monospace fs-6">#<?= $row['bill_id'] ?></strong>
                                </td>
                                <td data-label="Date">
                                    <div class="text-end text-md-start"><?= date('d M Y', strtotime($row['bill_date'])) ?> <small class="text-muted">(<?= date('D', strtotime($row['bill_date'])) ?>)</small></div>
                                </td>
                                <td data-label="Patient">
                                    <div class="text-end text-md-start">
                                        <div class="fw-bold text-dark"><?= htmlspecialchars($row['full_name']) ?></div>
                                        <small class="text-muted"><i class="bi bi-telephone me-1"></i><?= htmlspecialchars($row['phone'] ?: 'N/A') ?></small>
                                    </div>
                                </td>
                                <td data-label="Amount">
                                    <div class="text-end text-md-start">
                                        <div class="fw-bold text-primary">₹<?= number_format($row['total_amount'], 2) ?></div>
                                        <small class="text-muted">Paid: ₹<?= number_format($row['paid_amount'] ?? 0, 2) ?></small>
                                    </div>
                                </td>
                                <td data-label="Tests">
                                    <div class="text-end text-md-start">
                                        <span class="badge bg-light text-dark border"><?= $row['total_items'] ?> Items</span>
                                        <div class="small text-muted text-truncate" style="max-width: 180px;" title="<?= htmlspecialchars($testsPreview) ?>">
                                            <?= htmlspecialchars($testsPreview ?: 'General') ?>
                                        </div>
                                    </div>
                                </td>
                                <td data-label="Sample Status">
                                    <?php
                                    $sStatus = strtolower($row['sample_status'] ?? 'pending');
                                    $sampleClass = match($sStatus) {
                                        'completed' => 'sample-completed',
                                        'collected' => 'sample-collected',
                                        default     => 'sample-pending'
                                    };
                                    ?>
                                    <span class="sample-badge <?= $sampleClass ?>">
                                        <i class="bi bi-circle-fill me-1" style="font-size: 6px;"></i>
                                        <?= ucfirst($sStatus) ?>
                                    </span>
                                </td>
                                <td data-label="Payment Status">
                                    <?php
                                    $pStatus = strtolower($row['payment_status'] ?? 'unpaid');
                                    $paymentClass = match($pStatus) {
                                        'paid'    => 'status-paid',
                                        'partial' => 'status-partial',
                                        default   => 'status-unpaid'
                                    };
                                    ?>
                                    <span class="status-badge <?= $paymentClass ?>">
                                        <?= ucfirst($pStatus) ?>
                                    </span>
                                </td>
                                <td data-label="Actions" class="text-end">
                                    <div class="btn-group-action justify-content-end">
                                        <a href="print_bill.php?id=<?= $row['bill_id'] ?>" target="_blank" 
                                           class="btn btn-outline-secondary btn-sm" title="Print Invoice Receipt">
                                            <i class="bi bi-receipt"></i> Bill
                                        </a>
                                        <a href="result_entry.php?bill_id=<?= $row['bill_id'] ?>" 
                                           class="btn btn-outline-success btn-sm" title="Enter / View Test Results">
                                            <i class="bi bi-clipboard-pulse"></i> Results
                                        </a>
                                        <a href="pdf_options.php?bill_id=<?= $row['bill_id'] ?>" 
                                           class="btn btn-outline-danger btn-sm" title="Customize, Preview & Print Diagnostic Report">
                                            <i class="bi bi-file-earmark-pdf"></i> Report
                                        </a>
                                        <a href="bill_edit.php?id=<?= $row['bill_id'] ?>" 
                                           class="btn btn-outline-primary btn-sm" title="Edit Bill">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <i class="bi bi-receipt fa-3x text-muted mb-2 d-block opacity-50"></i>
                                <h6 class="fw-bold text-secondary">No Invoices Found</h6>
                                <p class="small text-muted mb-3">No bills matched your criteria. Clear filters or generate a new patient invoice.</p>
                                <a href="bill_list.php" class="btn btn-outline-primary btn-sm me-2">Show All Bills</a>
                                <a href="bill_add.php" class="btn btn-primary btn-sm">+ Create New Bill</a>
                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination Bar -->
            <?php if ($totalPages > 1): ?>
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2 mt-4 pt-3 border-top">
                    <small class="text-muted">
                        Showing page <strong><?= $page ?></strong> of <strong><?= $totalPages ?></strong> (<?= number_format($totalRows) ?> total bills)
                    </small>

                    <nav>
                        <ul class="pagination pagination-sm mb-0">
                            <?php if ($page > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="<?= buildUrl(['page' => $page - 1]) ?>">
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
                                    <a class="page-link" href="<?= buildUrl(['page' => $i]) ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>

                            <?php if ($page < $totalPages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="<?= buildUrl(['page' => $page + 1]) ?>">
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
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
