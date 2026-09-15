<?php
// bill_list.php
include 'auth_check.php';
require_once 'db.php';

// 1. Collect Filter & Sort Inputs (All Bills by default, no date restriction)
$search         = trim($_GET['search'] ?? '');
$sample_filter  = trim($_GET['sample'] ?? '');
$status_filter  = trim($_GET['status'] ?? 'all');
$start_date     = trim($_GET['start_date'] ?? '');
$end_date       = trim($_GET['end_date'] ?? '');
$sort           = trim($_GET['sort'] ?? 'bill_desc');

$current_role   = strtolower($_SESSION['role'] ?? 'user');
$role_id        = (int)($_SESSION['role_id'] ?? 0);
$is_admin       = ($current_role === 'admin' || $role_id === 1);

// Count pending cancellation requests for admin notification
$pendingCancelCount = 0;
if ($is_admin) {
    $pRes = $conn->query("SELECT COUNT(*) as cnt FROM bills WHERE cancellation_status = 'requested'");
    if ($pRes && $pRow = $pRes->fetch_assoc()) {
        $pendingCancelCount = (int)$pRow['cnt'];
    }
}

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

if ($status_filter === 'active') {
    $whereClause .= " AND (b.status = 'active' OR b.status IS NULL)";
} elseif ($status_filter === 'pending_approval') {
    $whereClause .= " AND b.cancellation_status = 'requested'";
} elseif ($status_filter === 'cancelled') {
    $whereClause .= " AND b.status = 'cancelled'";
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

// 5. Query KPI Statistics for Filtered/All Rows (Excluding cancelled bills from active revenue)
$statsSql = "
    SELECT 
        COUNT(DISTINCT CASE WHEN (b.status != 'cancelled' OR b.status IS NULL) THEN b.bill_id END) as total_bills,
        COALESCE(SUM(CASE WHEN (b.status != 'cancelled' OR b.status IS NULL) THEN b.total_amount ELSE 0 END), 0) as total_amount,
        COUNT(DISTINCT CASE WHEN s.status = 'completed' AND (b.status != 'cancelled' OR b.status IS NULL) THEN b.bill_id END) as completed,
        COUNT(DISTINCT CASE WHEN LOWER(b.payment_status) = 'paid' AND (b.status != 'cancelled' OR b.status IS NULL) THEN b.bill_id END) as paid,
        COUNT(DISTINCT CASE WHEN b.status = 'cancelled' THEN b.bill_id END) as cancelled_count
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
    SELECT b.*, p.patient_id, p.full_name, p.phone, p.dr_ref,
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
        'status'     => $_GET['status'] ?? 'all',
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
            
            <?php if (!empty($_SESSION['alert'])): ?>
                <div class="alert alert-<?= htmlspecialchars($_SESSION['alert']['type']) ?> alert-dismissible fade show mb-3 shadow-sm" role="alert">
                    <i class="bi <?= $_SESSION['alert']['type'] === 'success' ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill' ?> me-2"></i>
                    <?= htmlspecialchars($_SESSION['alert']['msg']) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['alert']); ?>
            <?php endif; ?>

            <?php if ($is_admin && $pendingCancelCount > 0): ?>
                <div class="alert alert-warning d-flex flex-wrap align-items-center justify-content-between mb-3 shadow-sm border-warning">
                    <div class="d-flex align-items-center gap-2 mb-2 mb-md-0">
                        <i class="bi bi-shield-exclamation text-warning fs-4"></i>
                        <div>
                            <strong class="d-block">Administrator Review Required:</strong>
                            <span class="small text-muted">There <?= $pendingCancelCount === 1 ? 'is 1 bill cancellation request' : "are {$pendingCancelCount} bill cancellation requests" ?> awaiting your administrative approval.</span>
                        </div>
                    </div>
                    <a href="bill_list.php?status=pending_approval" class="btn btn-sm btn-warning text-dark fw-bold px-3">
                        <i class="bi bi-eye-fill me-1"></i> Review Requests (<?= $pendingCancelCount ?>)
                    </a>
                </div>
            <?php endif; ?>

            <!-- Quick Statistics Grid -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-value"><?= number_format($stats['total_bills'] ?? 0) ?></div>
                    <div class="stat-label">Active Invoices</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value" style="color: var(--erp-primary);">₹<?= number_format($stats['total_amount'] ?? 0, 2) ?></div>
                    <div class="stat-label">Active Billed (₹)</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value" style="color: var(--erp-success);"><?= number_format($stats['completed'] ?? 0) ?></div>
                    <div class="stat-label">Completed Tests</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value text-success"><?= number_format($stats['paid'] ?? 0) ?></div>
                    <div class="stat-label">Paid Bills</div>
                </div>
                <?php if (($stats['cancelled_count'] ?? 0) > 0): ?>
                <div class="stat-card" style="border-left: 3px solid var(--erp-danger);">
                    <div class="stat-value text-danger"><?= number_format($stats['cancelled_count']) ?></div>
                    <div class="stat-label">Cancelled Bills</div>
                </div>
                <?php endif; ?>
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

                <!-- Bill Status -->
                <div style="flex: 1.2; min-width: 150px;">
                    <label class="form-label-compact"><i class="bi bi-shield-check me-1"></i> Bill Status</label>
                    <select name="status" class="form-control-compact">
                        <option value="all" <?= $status_filter === 'all' ? 'selected' : '' ?>>All Invoices</option>
                        <option value="active" <?= $status_filter === 'active' ? 'selected' : '' ?>>Active Only</option>
                        <option value="pending_approval" <?= $status_filter === 'pending_approval' ? 'selected' : '' ?>>
                            Cancellation Pending <?= ($pendingCancelCount > 0) ? "({$pendingCancelCount})" : '' ?>
                        </option>
                        <option value="cancelled" <?= $status_filter === 'cancelled' ? 'selected' : '' ?>>Cancelled / Void</option>
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
                            <?php
                            $isCancelled = (($row['status'] ?? '') === 'cancelled');
                            $isPendingCancel = (($row['cancellation_status'] ?? '') === 'requested');
                            $isReportDone = ((int)($row['result_entered'] ?? 0) === 1) || ((int)($row['report_printed'] ?? 0) === 1);
                            ?>
                            <tr class="<?= $isCancelled ? 'table-light opacity-75' : '' ?>">
                                <td data-label="Bill #">
                                    <strong class="<?= $isCancelled ? 'text-danger text-decoration-line-through' : 'text-primary' ?> font-monospace fs-6">#<?= $row['bill_id'] ?></strong>
                                    <?php if ($isCancelled): ?>
                                        <div><span class="badge bg-danger font-monospace" style="font-size:0.65rem;"><i class="bi bi-slash-circle me-1"></i>CANCELLED</span></div>
                                    <?php elseif ($isPendingCancel): ?>
                                        <div><span class="badge bg-warning text-dark font-monospace" style="font-size:0.65rem;" title="<?= htmlspecialchars($row['cancellation_reason'] ?? '') ?>"><i class="bi bi-hourglass-split me-1"></i>CANCEL REQ</span></div>
                                    <?php endif; ?>
                                </td>
                                <td data-label="Date">
                                    <div class="text-end text-md-start"><?= date('d M Y', strtotime($row['bill_date'])) ?> <small class="text-muted">(<?= date('D', strtotime($row['bill_date'])) ?>)</small></div>
                                </td>
                                <td data-label="Patient">
                                    <div class="text-end text-md-start">
                                        <a href="patient_history.php?patient_id=<?= $row['patient_id'] ?>" class="fw-bold <?= $isCancelled ? 'text-muted' : 'text-primary' ?> text-decoration-none" title="View Patient 360° History">
                                            <?= htmlspecialchars($row['full_name']) ?> <i class="fas fa-history text-muted ms-1" style="font-size: 0.72rem;"></i>
                                        </a>
                                        <div class="small text-muted mt-1">
                                            <i class="bi bi-telephone me-1"></i><?= htmlspecialchars($row['phone'] ?: 'N/A') ?>
                                            <?php if (!empty($row['dr_ref'])): ?>
                                                <span class="mx-1">•</span>
                                                <a href="doctor_report.php?doctor=<?= urlencode(trim($row['dr_ref'])) ?>" class="badge bg-light text-secondary border text-decoration-none" title="View Doctor Referral Report">
                                                    <i class="fas fa-user-md me-1 text-primary"></i><?= htmlspecialchars($row['dr_ref']) ?>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <td data-label="Amount">
                                    <div class="text-end text-md-start">
                                        <?php if ($isCancelled): ?>
                                            <div class="text-muted text-decoration-line-through small">₹<?= number_format($row['total_amount'], 2) ?></div>
                                            <span class="badge bg-danger-subtle text-danger border border-danger small">VOID</span>
                                        <?php else: ?>
                                            <div class="fw-bold text-primary">₹<?= number_format($row['total_amount'], 2) ?></div>
                                            <small class="text-muted">Paid: ₹<?= number_format($row['paid_amount'] ?? 0, 2) ?></small>
                                        <?php endif; ?>
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
                                        <?php if (!$isCancelled): ?>
                                            <a href="result_entry.php?bill_id=<?= $row['bill_id'] ?>" 
                                               class="btn btn-outline-success btn-sm" title="Enter / View Test Results">
                                                <i class="bi bi-clipboard-pulse"></i> Results
                                            </a>
                                            <a href="pdf_options.php?bill_id=<?= $row['bill_id'] ?>" 
                                               class="btn btn-outline-danger btn-sm" title="Customize, Preview & Print Diagnostic Report">
                                                <i class="bi bi-file-earmark-pdf"></i> Report
                                            </a>
                                        <?php endif; ?>
                                        <a href="bill_edit.php?id=<?= $row['bill_id'] ?>" 
                                           class="btn btn-outline-primary btn-sm" title="<?= $isCancelled ? 'View Cancelled Bill (Read-Only)' : 'Edit Bill' ?>">
                                            <i class="bi <?= $isCancelled ? 'bi-eye' : 'bi-pencil' ?>"></i>
                                        </a>

                                        <?php if ($isCancelled): ?>
                                            <!-- Voided -->
                                        <?php elseif ($isPendingCancel && $is_admin): ?>
                                            <button type="button" class="btn btn-warning btn-sm text-dark px-2 shadow-sm" title="Review Cancellation Request"
                                                    onclick="openApprovalModal(<?= $row['bill_id'] ?>, '<?= htmlspecialchars(addslashes($row['full_name']), ENT_QUOTES) ?>', '<?= htmlspecialchars(addslashes($row['cancellation_reason'] ?? ''), ENT_QUOTES) ?>', '<?= htmlspecialchars($row['cancellation_requested_at'] ?? '', ENT_QUOTES) ?>')">
                                                <i class="bi bi-shield-check"></i> Review
                                            </button>
                                        <?php elseif ($isPendingCancel && !$is_admin): ?>
                                            <span class="btn btn-outline-warning btn-sm disabled px-2" title="Cancellation request pending admin approval">
                                                <i class="bi bi-hourglass-split"></i> Pending
                                            </span>
                                        <?php else: ?>
                                            <button type="button" class="btn btn-outline-danger btn-sm px-2" title="<?= ($isReportDone && !$is_admin) ? 'Request Cancellation (Admin Approval)' : 'Cancel Bill' ?>"
                                                    onclick="openCancelModal(<?= $row['bill_id'] ?>, '<?= htmlspecialchars(addslashes($row['full_name']), ENT_QUOTES) ?>', <?= $isReportDone ? 'true' : 'false' ?>, <?= $is_admin ? 'true' : 'false' ?>)">
                                                <i class="bi bi-x-circle"></i>
                                            </button>
                                        <?php endif; ?>
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

<!-- Bill Cancellation Modal -->
<div class="modal fade" id="billListCancelModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-lg border-0">
      <form action="bill_cancel.php" method="POST">
        <input type="hidden" name="bill_id" id="cancel_modal_bill_id" value="">
        <input type="hidden" name="action" id="cancel_modal_action" value="">

        <div class="modal-header" id="cancel_modal_header">
          <h5 class="modal-title fw-bold" id="cancel_modal_title">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> Bill Cancellation
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body p-4">
          <div class="text-center mb-3">
            <div class="badge bg-light text-dark border px-3 py-2 font-monospace fs-6" id="cancel_modal_patient_badge">
              Bill # - Patient
            </div>
          </div>

          <div id="cancel_modal_notice" class="alert small mb-3"></div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Reason for Cancellation <span class="text-danger">*</span></label>
            <textarea name="reason" class="form-control" rows="3" required placeholder="Please describe clinical or billing reason for cancellation..."></textarea>
          </div>
        </div>

        <div class="modal-footer bg-light">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn" id="cancel_modal_submit_btn">Confirm</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php if ($is_admin): ?>
<!-- Admin Cancellation Approval Modal -->
<div class="modal fade" id="adminApprovalModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-lg border-0">
      <form action="bill_cancel.php" method="POST" id="approvalForm">
        <input type="hidden" name="bill_id" id="approval_bill_id" value="">
        <input type="hidden" name="action" id="approval_action" value="approve_cancel">

        <div class="modal-header bg-warning text-dark">
          <h5 class="modal-title fw-bold">
            <i class="bi bi-shield-check me-2"></i> Review Cancellation Request
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body p-4">
          <div class="text-center mb-3">
            <div class="badge bg-light text-dark border px-3 py-2 font-monospace fs-6" id="approval_patient_badge">
              Bill # - Patient
            </div>
          </div>

          <div class="card bg-light border mb-3">
            <div class="card-body p-3">
              <div class="small text-muted fw-bold mb-1"><i class="bi bi-chat-left-quote me-1"></i> Staff Cancellation Reason:</div>
              <div id="approval_reason_text" class="text-dark fst-italic"></div>
              <div id="approval_time_text" class="text-muted small mt-2"></div>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Administrator Remarks / Notes (Optional)</label>
            <textarea name="admin_remarks" class="form-control" rows="2" placeholder="Optional notes regarding approval or rejection..."></textarea>
          </div>
        </div>

        <div class="modal-footer bg-light d-flex justify-content-between">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <div class="d-flex gap-2">
            <button type="button" class="btn btn-outline-danger" onclick="submitApprovalAction('reject_cancel')">
              <i class="bi bi-x-circle me-1"></i> Reject Request
            </button>
            <button type="button" class="btn btn-danger" onclick="submitApprovalAction('approve_cancel')">
              <i class="bi bi-check2-circle me-1"></i> Approve & Void Bill
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function openCancelModal(billId, patientName, isReportDone, isAdmin) {
    document.getElementById('cancel_modal_bill_id').value = billId;
    document.getElementById('cancel_modal_patient_badge').textContent = 'Bill #' + billId + ' • ' + patientName;
    
    const header = document.getElementById('cancel_modal_header');
    const title = document.getElementById('cancel_modal_title');
    const notice = document.getElementById('cancel_modal_notice');
    const submitBtn = document.getElementById('cancel_modal_submit_btn');
    const actionInput = document.getElementById('cancel_modal_action');

    if (isReportDone && !isAdmin) {
        actionInput.value = 'request_cancel';
        header.className = 'modal-header bg-warning text-dark';
        title.innerHTML = '<i class="bi bi-shield-exclamation me-2"></i> Submit Cancellation Request';
        notice.className = 'alert alert-warning border-warning small mb-3';
        notice.innerHTML = '<i class="bi bi-info-circle-fill me-1"></i> <strong>Diagnostic Report Generated:</strong> This bill has already been tested, printed, or downloaded. Non-admin staff cannot cancel this bill directly. Submitting this request will forward it to the <strong>Administrator</strong> for approval.';
        submitBtn.className = 'btn btn-warning text-dark fw-bold';
        submitBtn.innerHTML = '<i class="bi bi-send-check me-1"></i> Submit for Admin Approval';
    } else {
        actionInput.value = 'direct_cancel';
        header.className = 'modal-header bg-danger text-white';
        title.innerHTML = '<i class="bi bi-exclamation-triangle-fill me-2"></i> Confirm Bill Cancellation';
        notice.className = 'alert alert-danger border-danger small mb-3';
        notice.innerHTML = '<i class="bi bi-exclamation-octagon-fill me-1"></i> <strong>Warning:</strong> Cancelling this bill will mark it as <strong>VOID / CANCELLED</strong>, deduct its amount from active revenue summaries, and watermark all printed invoices & reports. This action is permanently logged in the audit log.';
        submitBtn.className = 'btn btn-danger';
        submitBtn.innerHTML = '<i class="bi bi-x-circle me-1"></i> Yes, Cancel Bill Now';
    }

    const modal = new bootstrap.Modal(document.getElementById('billListCancelModal'));
    modal.show();
}

<?php if ($is_admin): ?>
function openApprovalModal(billId, patientName, reason, requestedAt) {
    document.getElementById('approval_bill_id').value = billId;
    document.getElementById('approval_patient_badge').textContent = 'Bill #' + billId + ' • ' + patientName;
    document.getElementById('approval_reason_text').textContent = reason || 'No reason provided';
    document.getElementById('approval_time_text').textContent = requestedAt ? ('Requested at: ' + requestedAt) : '';
    
    const modal = new bootstrap.Modal(document.getElementById('adminApprovalModal'));
    modal.show();
}

function submitApprovalAction(action) {
    document.getElementById('approval_action').value = action;
    document.getElementById('approvalForm').submit();
}
<?php endif; ?>
</script>
</body>
</html>
