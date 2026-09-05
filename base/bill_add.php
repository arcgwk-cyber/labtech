<?php
/**
 * Modern Clinical Billing & Patient Registration Studio
 * - Fast patient search & auto-fill
 * - Quick search-to-add for laboratory tests and packages
 * - Real-time calculation with discount support & instant "Paid in Full" shortcuts
 * - Beautiful medical ERP visual styling with sticky summary billing card
 */
include_once 'auth_check.php';
include_once 'db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Fetch available Lab Tests and Packages
$tests_query = $conn->query("
    SELECT t.test_id, t.test_name, t.price, g.group_name 
    FROM lab_tests t 
    LEFT JOIN test_groups g ON t.group_id = g.group_id 
    ORDER BY t.test_name ASC
");
$tests_arr = [];
if ($tests_query) {
    while ($row = $tests_query->fetch_assoc()) {
        $tests_arr[] = [
            'test_id'    => (int)$row['test_id'],
            'test_name'  => $row['test_name'],
            'price'      => (float)$row['price'],
            'group_name' => $row['group_name'] ?: 'General'
        ];
    }
}

$packages_query = $conn->query("
    SELECT package_id, package_name, package_price 
    FROM test_packages 
    ORDER BY package_name ASC
");
$packages_arr = [];
if ($packages_query) {
    while ($row = $packages_query->fetch_assoc()) {
        $packages_arr[] = [
            'package_id'    => (int)$row['package_id'],
            'package_name'  => $row['package_name'],
            'package_price' => (float)$row['package_price']
        ];
    }
}

// 2. Fetch Patient Types
$patient_types = [];
$pt_query = $conn->query("SELECT type_id, type_name FROM patient_types ORDER BY type_name");
if ($pt_query) {
    while ($r = $pt_query->fetch_assoc()) {
        $patient_types[] = $r;
    }
}

// 3. Fetch Recent Referring Doctors for Autocomplete
$doctor_list = [];
$doc_query = $conn->query("SELECT DISTINCT dr_ref FROM patients WHERE dr_ref IS NOT NULL AND TRIM(dr_ref) != '' ORDER BY dr_ref LIMIT 30");
if ($doc_query) {
    while ($dr = $doc_query->fetch_assoc()) {
        $doctor_list[] = trim($dr['dr_ref']);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>New Bill Entry | Clinical Laboratory ERP</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

  <style>
    :root {
      --brand-primary: #0284c7;
      --brand-dark: #0369a1;
      --brand-light: #f0f9ff;
      --brand-success: #10b981;
      --brand-warning: #f59e0b;
      --brand-danger: #ef4444;
      --surface-bg: #f8fafc;
      --card-bg: #ffffff;
      --border-color: #e2e8f0;
      --border-light: #f1f5f9;
      --text-main: #0f172a;
      --text-muted: #64748b;
      --placeholder-color: #94a3b8;
    }

    body {
      background-color: var(--surface-bg);
      font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
      color: var(--text-main);
      margin: 0;
      padding-bottom: 60px;
    }

    /* Universal Light Placeholders across all browsers */
    ::placeholder {
      color: var(--placeholder-color) !important;
      opacity: 0.75 !important;
      font-weight: 400 !important;
    }
    ::-webkit-input-placeholder {
      color: var(--placeholder-color) !important;
      opacity: 0.75 !important;
      font-weight: 400 !important;
    }
    :-moz-placeholder {
      color: var(--placeholder-color) !important;
      opacity: 0.75 !important;
      font-weight: 400 !important;
    }
    ::-moz-placeholder {
      color: var(--placeholder-color) !important;
      opacity: 0.75 !important;
      font-weight: 400 !important;
    }
    :-ms-input-placeholder {
      color: var(--placeholder-color) !important;
      opacity: 0.75 !important;
      font-weight: 400 !important;
    }
    .form-control::placeholder {
      color: var(--placeholder-color) !important;
      opacity: 0.75 !important;
      font-size: 0.85rem !important;
    }

    .page-container {
      max-width: 1400px;
      margin: 22px auto;
      padding: 0 18px;
    }

    /* Studio Header */
    .bill-header-card {
      background: #ffffff;
      border: 1px solid var(--border-color);
      border-radius: 14px;
      padding: 18px 24px;
      box-shadow: 0 4px 18px -2px rgba(15, 23, 42, 0.04);
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 22px;
      flex-wrap: wrap;
      gap: 12px;
    }
    .bill-title {
      font-size: 1.32rem;
      font-weight: 800;
      color: var(--text-main);
      margin: 0;
      display: flex;
      align-items: center;
      gap: 10px;
      letter-spacing: -0.3px;
    }
    .bill-subtitle {
      font-size: 0.82rem;
      color: var(--text-muted);
      margin-top: 4px;
    }

    /* Studio Section Cards */
    .studio-card {
      background: #ffffff;
      border: 1px solid var(--border-color);
      border-radius: 14px;
      box-shadow: 0 4px 18px -2px rgba(15, 23, 42, 0.04);
      padding: 22px 24px;
      margin-bottom: 22px;
      transition: border-color 0.2s ease;
    }
    .studio-card:focus-within {
      border-color: #cbd5e1;
    }
    .studio-card-title {
      font-size: 1.02rem;
      font-weight: 700;
      color: var(--text-main);
      margin-bottom: 18px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      border-bottom: 1px solid var(--border-light);
      padding-bottom: 12px;
    }
    .step-badge {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 24px;
      height: 24px;
      border-radius: 50%;
      background: var(--brand-light);
      color: var(--brand-primary);
      font-size: 0.76rem;
      font-weight: 800;
      margin-right: 8px;
      border: 1px solid #bae6fd;
    }

    /* Form Controls */
    .form-label {
      font-size: 0.74rem;
      font-weight: 700;
      color: #64748b;
      margin-bottom: 5px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      display: block;
    }
    .form-control, .form-select {
      border-radius: 8px;
      border: 1px solid var(--border-color);
      font-size: 0.89rem;
      padding: 9px 13px;
      color: var(--text-main);
      background-color: #ffffff;
      transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .form-control:focus, .form-select:focus {
      border-color: var(--brand-primary);
      box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.12);
      outline: none;
    }
    .input-group-text {
      background-color: #f8fafc;
      border-color: var(--border-color);
      color: var(--placeholder-color);
      border-radius: 8px;
      font-size: 0.9rem;
    }

    /* Patient Search Container */
    .patient-search-card {
      background: #f8fafc;
      border: 1px solid var(--border-color);
      border-radius: 10px;
      padding: 12px 14px;
      margin-bottom: 18px;
    }
    .patient-search-box {
      position: relative;
    }
    .search-results-dropdown {
      position: absolute;
      top: 100%;
      left: 0;
      right: 0;
      z-index: 1050;
      background: #ffffff;
      border: 1px solid var(--border-color);
      border-radius: 10px;
      box-shadow: 0 10px 25px rgba(15, 23, 42, 0.1);
      max-height: 250px;
      overflow-y: auto;
      margin-top: 5px;
    }
    .search-patient-item {
      padding: 11px 16px;
      border-bottom: 1px solid var(--border-light);
      cursor: pointer;
      display: flex;
      justify-content: space-between;
      align-items: center;
      transition: background 0.15s ease;
    }
    .search-patient-item:hover {
      background-color: #f0f9ff;
    }
    .search-patient-item:last-child {
      border-bottom: none;
    }

    /* Quick Test Bar */
    .quick-test-bar {
      position: relative;
      margin-bottom: 16px;
    }
    .test-search-dropdown {
      position: absolute;
      top: 100%;
      left: 0;
      right: 0;
      background: #ffffff;
      border: 1px solid var(--border-color);
      border-radius: 10px;
      box-shadow: 0 12px 28px rgba(15, 23, 42, 0.12);
      z-index: 1050;
      max-height: 280px;
      overflow-y: auto;
      margin-top: 5px;
    }
    .test-search-item {
      padding: 11px 16px;
      border-bottom: 1px solid var(--border-light);
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: space-between;
      transition: background 0.15s ease;
    }
    .test-search-item:hover {
      background-color: #f0f9ff;
    }
    .test-search-item:last-child {
      border-bottom: none;
    }

    /* Investigation Items Table */
    .items-table-wrapper {
      border: 1px solid var(--border-color);
      border-radius: 10px;
      overflow: hidden;
      margin-bottom: 16px;
      background: #ffffff;
    }
    .items-table {
      width: 100%;
      border-collapse: collapse;
      margin: 0;
    }
    .items-table th {
      background-color: #f8fafc;
      color: #475569;
      font-size: 0.76rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      padding: 11px 14px;
      border-bottom: 1px solid var(--border-color);
    }
    .items-table td {
      padding: 8px 12px;
      vertical-align: middle;
      border-bottom: 1px solid var(--border-light);
    }
    .items-table tr:hover td {
      background-color: #fafbfc;
    }
    .items-table tr:last-child td {
      border-bottom: none;
    }
    .btn-row-delete {
      color: #94a3b8;
      background: transparent;
      border: none;
      width: 30px;
      height: 30px;
      border-radius: 6px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      transition: all 0.15s ease;
    }
    .btn-row-delete:hover {
      color: var(--brand-danger);
      background: #fee2e2;
    }

    /* Sticky Payment Card */
    .sticky-payment-card {
      position: sticky;
      top: 20px;
      background: #ffffff;
      border: 1px solid var(--border-color);
      border-radius: 14px;
      box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.05);
      padding: 22px;
    }
    .total-display-box {
      background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
      color: #ffffff;
      border-radius: 12px;
      padding: 18px 20px;
      text-align: center;
      margin-bottom: 20px;
      box-shadow: 0 6px 16px rgba(2, 132, 199, 0.25);
    }
    .total-amount-val {
      font-size: 2.2rem;
      font-weight: 800;
      font-family: 'JetBrains Mono', monospace;
      letter-spacing: -0.5px;
      line-height: 1.1;
      margin-top: 4px;
    }

    /* Payment shortcuts */
    .pay-shortcut-pill {
      font-size: 0.72rem;
      font-weight: 700;
      padding: 3px 9px;
      border-radius: 6px;
      background: #e0f2fe;
      color: #0369a1;
      border: 1px solid #bae6fd;
      cursor: pointer;
      transition: all 0.15s ease;
      user-select: none;
    }
    .pay-shortcut-pill:hover {
      background: #0284c7;
      color: #ffffff;
      border-color: #0284c7;
    }

    .btn-submit-bill {
      background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
      color: #ffffff;
      border: none;
      font-weight: 700;
      font-size: 0.96rem;
      padding: 13px 20px;
      border-radius: 9px;
      transition: all 0.2s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }
    .btn-submit-bill:hover {
      background: linear-gradient(135deg, #0369a1 0%, #075985 100%);
      color: #ffffff;
      box-shadow: 0 6px 18px rgba(2, 132, 199, 0.35);
      transform: translateY(-1px);
    }
  
    /* =======================================================
       NATIVE MOBILE APP RESPONSIVE OPTIMIZATIONS (bill_add)
       ======================================================= */
    @media (max-width: 767.98px) {
      body {
        padding-bottom: 95px !important; /* Allow space for sticky mobile checkout bar */
      }
      .page-container {
        margin: 10px auto !important;
        padding: 0 10px !important;
      }
      .bill-header-card {
        padding: 12px 16px !important;
        margin-bottom: 14px !important;
        border-radius: 12px !important;
      }
      .bill-title {
        font-size: 1.15rem !important;
      }
      .studio-card {
        padding: 14px 14px !important;
        margin-bottom: 14px !important;
        border-radius: 12px !important;
      }
      .studio-card-title {
        font-size: 0.95rem !important;
        margin-bottom: 14px !important;
        padding-bottom: 10px !important;
      }
      .patient-search-card {
        padding: 10px 12px !important;
      }
      .form-control, .form-select {
        font-size: 0.92rem !important;
        padding: 9px 12px !important;
      }

      /* Mobile Investigation Card Rows (transforms table into touch-friendly cards) */
      .items-table thead {
        display: none !important;
      }
      .items-table, .items-table tbody, .items-table tr {
        display: block !important;
        width: 100% !important;
      }
      .items-table tr {
        background: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 10px !important;
        padding: 10px !important;
        margin-bottom: 10px !important;
        position: relative !important;
        box-shadow: 0 2px 6px rgba(15, 23, 42, 0.04) !important;
      }
      .items-table td {
        display: block !important;
        width: 100% !important;
        padding: 3px 0 !important;
        border: none !important;
        text-align: left !important;
      }
      .items-table td.td-type-item {
        display: flex !important;
        gap: 6px !important;
        align-items: center !important;
      }
      .items-table td.td-type-item select.item-type {
        width: 32% !important;
        flex: 0 0 32% !important;
      }
      .items-table td.td-type-item select.item-select {
        width: 68% !important;
        flex: 1 !important;
      }
      .items-table td.td-price-del {
        display: flex !important;
        justify-content: space-between !important;
        align-items: center !important;
        margin-top: 4px !important;
        padding-top: 4px !important;
        border-top: 1px dashed #f1f5f9 !important;
      }
      .items-table td.td-price-del .price {
        max-width: 140px !important;
        font-size: 0.95rem !important;
        font-weight: 700 !important;
      }
      .btn-row-delete {
        width: 36px !important;
        height: 36px !important;
        background: #fee2e2 !important;
        color: #ef4444 !important;
      }

      /* Mobile Quick Add Toolbar */
      .quick-actions-mobile {
        display: grid !important;
        grid-template-columns: 1fr 1fr !important;
        gap: 8px !important;
        width: 100% !important;
      }
      .quick-actions-mobile button {
        width: 100% !important;
        padding: 8px 4px !important;
        font-size: 0.8rem !important;
      }

      /* Bottom Mobile Sticky Action Bar */
      .mobile-sticky-checkout {
        display: flex !important;
        position: fixed !important;
        bottom: 64px !important; /* Above bottom nav */
        left: 0 !important;
        right: 0 !important;
        background: #0f172a !important;
        color: #ffffff !important;
        padding: 8px 14px !important;
        box-shadow: 0 -4px 15px rgba(0,0,0,0.18) !important;
        z-index: 1030 !important;
        align-items: center !important;
        justify-content: space-between !important;
      }
      .mobile-sticky-checkout .m-total {
        font-size: 1.15rem !important;
        font-weight: 800 !important;
        color: #38bdf8 !important;
        font-family: 'JetBrains Mono', monospace !important;
        line-height: 1.1 !important;
      }
    }
    @media (min-width: 768px) {
      .mobile-sticky-checkout {
        display: none !important;
      }
    }

  </style>
</head>
<body>

<?php include_once __DIR__ . '/header.php'; ?>

<div class="page-container">

  <!-- Header Card -->
  <div class="bill-header-card">
    <div>
      <h1 class="bill-title">
        <i class="bi bi-receipt text-primary"></i> New Patient Invoice
        <span class="badge-mode bg-light text-primary border ms-2">Studio</span>
      </h1>
      <div class="bill-subtitle">
        Register patient details, select diagnostic investigations, and print receipt with verification token.
      </div>
    </div>
    <div class="d-flex align-items-center gap-2">
      <a href="bill_list.php" class="btn btn-outline-secondary btn-sm fw-semibold">
        <i class="bi bi-arrow-left me-1"></i> All Invoices
      </a>
    </div>
  </div>

  <!-- Main Billing Form -->
  <form id="billForm" method="POST" action="bill_save.php" novalidate>
    <input type="hidden" name="patient_id" id="patient_id" value="">
    <input type="hidden" name="total_amount" id="total_amount" value="0.00">

    <div class="row g-4">
      
      <!-- Left Column (8 cols): Patient Details & Investigations -->
      <div class="col-lg-8">
        
        <!-- Card 1: Patient Information -->
        <div class="studio-card">
          <div class="studio-card-title">
            <div class="d-flex align-items-center">
              <span class="step-badge">1</span>
              <span>Patient Information</span>
            </div>
            <span class="badge bg-light text-muted border font-monospace small" id="patientModeBadge">New Patient</span>
          </div>

          <!-- Instant Search for Existing Patients -->
          <div class="patient-search-card">
            <label class="form-label mb-1"><i class="bi bi-search me-1 text-primary"></i> Fast Search Returning Patient (Name or Mobile)</label>
            <div class="patient-search-box">
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-person-search"></i></span>
                <input type="text" id="patientSearchInput" class="form-control" placeholder="Type at least 2 characters (e.g. Ramesh, 9848)..." autocomplete="off">
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="clearPatientSelection()" title="Clear and create new patient">
                  <i class="bi bi-x-lg"></i> Clear
                </button>
              </div>
              <div id="patientSearchResults" class="search-results-dropdown" style="display:none;"></div>
            </div>
          </div>

          <div class="row g-3">
            <div class="col-md-5">
              <label class="form-label">Full Name <span class="text-danger">*</span></label>
              <input type="text" name="full_name" id="full_name" class="form-control fw-bold" placeholder="e.g. John Doe" required>
            </div>

            <div class="col-md-3">
              <label class="form-label">Gender <span class="text-danger">*</span></label>
              <select name="gender" id="gender" class="form-select" required>
                <option value="Male" selected>Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
              </select>
            </div>

            <div class="col-md-4">
              <label class="form-label">Age (Years) <span class="text-danger">*</span></label>
              <input type="number" name="age" id="age" class="form-control" placeholder="e.g. 35" required min="0" max="130">
            </div>

            <div class="col-md-4">
              <label class="form-label">Phone / Mobile <span class="text-danger">*</span></label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                <input type="tel" name="phone" id="phone" class="form-control" placeholder="10-digit mobile number" required>
              </div>
            </div>

            <div class="col-md-4">
              <label class="form-label">Email Address (Optional)</label>
              <input type="email" name="email" id="email" class="form-control" placeholder="patient@example.com">
            </div>

            <div class="col-md-4">
              <label class="form-label">Doctor Reference</label>
              <input type="text" name="dr_ref" id="dr_ref" class="form-control" list="doctorList" placeholder="Dr. Name or Self">
              <datalist id="doctorList">
                <?php foreach ($doctor_list as $doc_name): ?>
                  <option value="<?= htmlspecialchars($doc_name) ?>"></option>
                <?php endforeach; ?>
              </datalist>
            </div>

            <div class="col-md-6">
              <label class="form-label">Address / Location</label>
              <input type="text" name="address" id="address" class="form-control" placeholder="Town, village or street address">
            </div>

            <div class="col-md-6">
              <label class="form-label">Patient Category / Type</label>
              <select name="patient_type_id" id="patient_type" class="form-select" onchange="loadPatientTypeFields()">
                <option value="">General Walk-in Patient</option>
                <?php foreach ($patient_types as $pt): ?>
                  <option value="<?= $pt['type_id'] ?>"><?= htmlspecialchars($pt['type_name']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <!-- Dynamic Patient Type Fields Container -->
          <div id="patient-type-fields" class="mt-3 p-3 bg-light rounded-3 border" style="display:none;">
            <div class="fw-bold text-secondary small text-uppercase mb-2"><i class="bi bi-card-checklist me-1"></i> Additional Category Details</div>
            <div id="dynamic-fields" class="row g-2"></div>
          </div>
        </div>

        <!-- Card 2: Investigation Items (Tests & Packages) -->
        <div class="studio-card">
          <div class="studio-card-title">
            <div class="d-flex align-items-center">
              <span class="step-badge">2</span>
              <span>Investigation Items (Tests & Packages)</span>
            </div>
            <span class="badge bg-primary bg-opacity-10 text-primary fw-bold" id="itemCountBadge">0 Items Selected</span>
          </div>

          <!-- Instant Search & Quick Add Bar -->
          <div class="quick-test-bar">
            <div class="input-group">
              <span class="input-group-text bg-primary bg-opacity-10 text-primary fw-bold"><i class="bi bi-search"></i></span>
              <input type="text" id="quickTestInput" class="form-control" placeholder="Search test or package by name to add instantly (e.g. CBC, Lipid, Thyroid, Glucose, Urine)..." autocomplete="off">
              <button type="button" class="btn btn-outline-secondary" onclick="$('#quickTestInput').val('').focus(); $('#testSearchResults').hide();">
                <i class="bi bi-x"></i>
              </button>
            </div>
            <div id="testSearchResults" class="test-search-dropdown" style="display:none;"></div>
          </div>

          <!-- Selected Items Table Inside Wrapper -->
          <div class="items-table-wrapper">
            <table class="items-table">
              <thead>
                <tr>
                  <th width="5%" class="text-center d-none d-md-table-cell">#</th>
                  <th width="70%">Investigation / Package Item</th>
                  <th width="25%" class="text-end">Price (₹) & Action</th>
                </tr>
              </thead>
              <tbody id="test-rows">
                <!-- Initial Row -->
                <tr>
                  <td class="text-center text-muted row-idx d-none d-md-table-cell">1</td>
                  <td class="td-type-item">
                    <select name="item_type[]" class="form-select form-select-sm item-type" onchange="loadOptions(this)">
                      <option value="test" selected>Test</option>
                      <option value="package">Package</option>
                    </select>
                    <select name="item_id[]" class="form-select form-select-sm item-select" onchange="setPrice(this)" required>
                      <option value="">-- Choose Investigation --</option>
                      <?php foreach ($tests_arr as $t): ?>
                        <option data-price="<?= $t['price'] ?>" value="<?= $t['test_id'] ?>">
                          <?= htmlspecialchars($t['test_name']) ?> (₹<?= number_format($t['price'], 2) ?>)
                        </option>
                      <?php endforeach; ?>
                    </select>
                  </td>
                  <td class="td-price-del">
                    <div class="d-flex align-items-center gap-1">
                      <span class="d-md-none text-muted small fw-bold">Price: ₹</span>
                      <input type="text" name="item_price[]" class="form-control form-control-sm price text-end font-monospace" readonly style="background-color:#f8fafc;" value="0.00">
                    </div>
                    <button type="button" class="btn-row-delete" onclick="removeRow(this)" title="Remove item">
                      <i class="bi bi-trash3"></i>
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <!-- Add Rows & Clear Toolbar -->
          <div class="pt-1">
            <div class="quick-actions-mobile d-flex align-items-center justify-content-between flex-wrap gap-2">
              <button type="button" class="btn btn-sm btn-outline-primary fw-semibold" onclick="addRow('test')">
                <i class="bi bi-plus-circle me-1"></i> Add Test
              </button>
              <button type="button" class="btn btn-sm btn-outline-info fw-semibold" onclick="addRow('package')">
                <i class="bi bi-box-seam me-1"></i> Add Package
              </button>
              <button type="button" class="btn btn-sm btn-outline-secondary" onclick="addMultipleTests()">
                <i class="bi bi-plus-square me-1"></i> +3 Rows
              </button>
              <button type="button" class="btn btn-sm btn-outline-danger" onclick="clearAllItems()">
                <i class="bi bi-trash me-1"></i> Clear All
              </button>
            </div>
          </div>

        </div>

      </div>

      <!-- Right Column (4 cols): Sticky Payment & Billing Summary -->
      <div class="col-lg-4">
        <div class="sticky-payment-card">
          
          <div class="studio-card-title mb-3">
            <div class="d-flex align-items-center">
              <span class="step-badge">3</span>
              <span>Billing & Payment</span>
            </div>
            <span class="badge bg-light text-dark border font-monospace small"><?= date('d-M-Y') ?></span>
          </div>

          <!-- Date & Reference -->
          <div class="mb-3">
            <label class="form-label">Bill / Registration Date</label>
            <input type="date" name="bill_date" class="form-control" value="<?= date('Y-m-d') ?>" required>
          </div>

          <!-- Prominent Grand Total Display -->
          <div class="total-display-box">
            <div class="small text-uppercase opacity-75 fw-semibold">Grand Total Payable</div>
            <div class="total-amount-val">₹ <span id="grand-total-text">0.00</span></div>
          </div>

          <!-- Payment Input Fields -->
          <div class="mb-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
              <label class="form-label mb-0">Paid Amount (₹)</label>
              <div class="d-flex gap-1">
                <span class="pay-shortcut-pill" onclick="setFullPaid()">Full Paid</span>
                <span class="pay-shortcut-pill" onclick="setPartialHalf()">50%</span>
                <span class="pay-shortcut-pill" onclick="setZeroPaid()">Zero</span>
              </div>
            </div>
            <div class="input-group">
              <span class="input-group-text">₹</span>
              <input type="number" step="0.01" name="paid_amount" id="paid_amount" class="form-control font-monospace fw-bold" placeholder="0.00" oninput="updateBalance()">
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Balance Due (₹)</label>
            <div class="input-group">
              <span class="input-group-text">₹</span>
              <input type="number" step="0.01" name="balance" id="balance" class="form-control font-monospace fw-bold" readonly style="background-color: #f8fafc;" value="0.00">
            </div>
            <div id="balanceAlertText" class="small mt-1 text-muted"></div>
          </div>

          <div class="mb-4">
            <label class="form-label">Payment Status</label>
            <select name="payment_status" id="payment_status" class="form-select fw-semibold">
              <option value="Paid">Paid</option>
              <option value="Pending" selected>Pending</option>
              <option value="Partial">Partial</option>
            </select>
          </div>

          <!-- Primary Submit Button -->
          <div class="d-grid gap-2">
            <button type="submit" class="btn btn-submit-bill btn-lg shadow-sm">
              <i class="bi bi-check2-circle fs-5"></i> Save & Generate Bill
            </button>
            <button type="button" onclick="clearFullForm()" class="btn btn-outline-secondary btn-sm py-2">
              <i class="bi bi-arrow-clockwise me-1"></i> Reset Full Form
            </button>
          </div>

          <div class="text-center text-muted small mt-3" style="font-size:0.75rem;">
            <i class="bi bi-keyboard me-1"></i> Press <kbd>Ctrl</kbd> + <kbd>Enter</kbd> to save invoice
          </div>

        </div>
      </div>

    </div>
  </form>

</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
const testData = <?= json_encode($tests_arr) ?>;
const packageData = <?= json_encode($packages_arr) ?>;

$(document).ready(function() {
  calculateTotal();
  reindexRows();

  // 1. Patient Instant Search Logic
  $('#patientSearchInput').on('input', function() {
    let q = $(this).val().trim();
    if (q.length < 2) {
      $('#patientSearchResults').hide().empty();
      return;
    }

    $.getJSON('search_patients.php', { q: q }, function(data) {
      let html = '';
      if (data && data.length > 0) {
        data.forEach(p => {
          html += `<div class="search-patient-item" onclick='selectPatient(${JSON.stringify(p)})'>
            <div>
              <strong class="text-primary">${p.full_name}</strong>
              <div class="small text-muted"><i class="bi bi-telephone me-1"></i>${p.phone || 'N/A'} &bull; ${p.gender || ''}, ${p.age ? p.age + ' yrs' : ''}</div>
            </div>
            <span class="badge bg-light text-dark border font-monospace">PID #${p.patient_id}</span>
          </div>`;
        });
      } else {
        html = '<div class="p-3 text-center text-muted small">No existing patients found. Continue typing to create a new patient.</div>';
      }
      $('#patientSearchResults').html(html).show();
    });
  });

  // 2. Quick Test Autocomplete Search
  $('#quickTestInput').on('input', function() {
    let q = $(this).val().toLowerCase().trim();
    if (q.length < 1) {
      $('#testSearchResults').hide().empty();
      return;
    }

    let matches = [];
    // Search tests
    testData.forEach(t => {
      if (t.test_name.toLowerCase().includes(q)) {
        matches.push({ type: 'test', id: t.test_id, name: t.test_name, price: t.price, group: t.group_name });
      }
    });
    // Search packages
    packageData.forEach(p => {
      if (p.package_name.toLowerCase().includes(q)) {
        matches.push({ type: 'package', id: p.package_id, name: p.package_name, price: p.package_price, group: 'Package' });
      }
    });

    let html = '';
    if (matches.length > 0) {
      matches.slice(0, 15).forEach(m => {
        let badge = m.type === 'package' ? '<span class="badge bg-info bg-opacity-25 text-info-emphasis me-2">Package</span>' : '<span class="badge bg-light text-secondary border me-2">Test</span>';
        html += `<div class="test-search-item" onclick='quickAddTestItem("${m.type}", ${m.id}, "${m.name.replace(/"/g, '&quot;')}", ${m.price})'>
          <div>${badge}<strong>${m.name}</strong> <small class="text-muted">(${m.group})</small></div>
          <span class="fw-bold font-monospace text-primary">₹${parseFloat(m.price).toFixed(2)}</span>
        </div>`;
      });
    } else {
      html = '<div class="p-3 text-center text-muted small">No tests or packages match your query.</div>';
    }
    $('#testSearchResults').html(html).show();
  });

  // Keyboard shortcut Ctrl + Enter to submit
  $(document).on('keydown', function(e) {
    if ((e.ctrlKey || e.metaKey) && e.keyCode === 13) {
      $('#billForm').submit();
    }
  });

  // Close dropdowns on outside click
  $(document).on('click', function(e) {
    if (!$(e.target).closest('#patientSearchInput, #patientSearchResults').length) {
      $('#patientSearchResults').hide();
    }
    if (!$(e.target).closest('#quickTestInput, #testSearchResults').length) {
      $('#testSearchResults').hide();
    }
  });
});

// Select returning patient
function selectPatient(p) {
  $('#patient_id').val(p.patient_id);
  $('#full_name').val(p.full_name);
  $('#gender').val(p.gender);
  $('#age').val(p.age);
  $('#phone').val(p.phone);
  $('#email').val(p.email || '');
  $('#address').val(p.address || '');
  $('#dr_ref').val(p.dr_ref || '');
  if (p.patient_type_id) {
    $('#patient_type').val(p.patient_type_id);
    loadPatientTypeFields();
  }
  $('#patientModeBadge').text('Existing Patient (PID #' + p.patient_id + ')').removeClass('text-muted').addClass('bg-success text-white');
  $('#patientSearchResults').hide().empty();
  $('#patientSearchInput').val('');
}

function clearPatientSelection() {
  $('#patient_id').val('');
  $('#patientSearchInput').val('');
  $('#patientSearchResults').hide().empty();
  $('#patientModeBadge').text('New Patient').removeClass('bg-success text-white').addClass('text-muted');
  $('#full_name, #phone, #email, #address, #dr_ref, #age').val('');
}

// Quick Add item from instant search bar
function quickAddTestItem(type, id, name, price) {
  let firstRow = $('#test-rows tr:first');
  let firstRowItem = firstRow.find('.item-select').val();

  let targetRow;
  if ($('#test-rows tr').length === 1 && !firstRowItem) {
    targetRow = firstRow;
  } else {
    addRow(type);
    targetRow = $('#test-rows tr:last');
  }

  targetRow.find('.item-type').val(type);
  loadOptions(targetRow.find('.item-type').get(0));
  targetRow.find('.item-select').val(id);
  targetRow.find('.price').val(parseFloat(price).toFixed(2));

  $('#quickTestInput').val('').focus();
  $('#testSearchResults').hide();
  calculateTotal();
}

function addRow(type = 'test') {
  let newRow = $(`
    <tr>
      <td class="text-center text-muted row-idx d-none d-md-table-cell"></td>
      <td class="td-type-item">
        <select name="item_type[]" class="form-select form-select-sm item-type" onchange="loadOptions(this)">
          <option value="test" ${type === 'test' ? 'selected' : ''}>Test</option>
          <option value="package" ${type === 'package' ? 'selected' : ''}>Package</option>
        </select>
        <select name="item_id[]" class="form-select form-select-sm item-select" onchange="setPrice(this)" required>
          <option value="">-- Choose Investigation --</option>
        </select>
      </td>
      <td class="td-price-del">
        <div class="d-flex align-items-center gap-1">
          <span class="d-md-none text-muted small fw-bold">Price: ₹</span>
          <input type="text" name="item_price[]" class="form-control form-control-sm price text-end font-monospace" readonly style="background-color:#f8fafc;" value="0.00">
        </div>
        <button type="button" class="btn-row-delete" onclick="removeRow(this)" title="Remove item">
          <i class="bi bi-trash3"></i>
        </button>
      </td>
    </tr>
  `);
  $('#test-rows').append(newRow);
  loadOptions(newRow.find('.item-type').get(0));
  reindexRows();
}

function addMultipleTests() {
  addRow('test');
  addRow('test');
  addRow('test');
}

function removeRow(btn) {
  if ($('#test-rows tr').length > 1) {
    $(btn).closest('tr').remove();
    calculateTotal();
    reindexRows();
  } else {
    let row = $(btn).closest('tr');
    row.find('select').val('');
    row.find('.price').val('0.00');
    calculateTotal();
  }
}

function clearAllItems() {
  if (confirm('Clear all ordered investigations?')) {
    $('#test-rows').empty();
    addRow('test');
    calculateTotal();
  }
}

function reindexRows() {
  let count = 0;
  $('#test-rows tr').each(function(idx) {
    count++;
    $(this).find('.row-idx').text(count);
  });
  $('#itemCountBadge').text(count + ' Items Selected');
}

function loadOptions(select) {
  const row = $(select).closest('tr');
  const type = $(select).val();
  const itemSelect = row.find('.item-select');
  let html = '<option value="">-- Choose Investigation --</option>';

  if (type === 'test') {
    testData.forEach(opt => {
      html += `<option data-price="${opt.price}" value="${opt.test_id}">${opt.test_name} (₹${parseFloat(opt.price).toFixed(2)})</option>`;
    });
  } else {
    packageData.forEach(opt => {
      html += `<option data-price="${opt.package_price}" value="${opt.package_id}">${opt.package_name} (₹${parseFloat(opt.package_price).toFixed(2)})</option>`;
    });
  }

  itemSelect.html(html);
  row.find('.price').val('0.00');
  calculateTotal();
}

function setPrice(select) {
  const selected = select.selectedOptions[0];
  const price = selected ? selected.getAttribute('data-price') || 0 : 0;
  $(select).closest('tr').find('.price').val(parseFloat(price).toFixed(2));
  calculateTotal();
}

function calculateTotal() {
  let total = 0;
  $('.price').each(function() {
    total += parseFloat($(this).val()) || 0;
  });

  $('#grand-total-text').text(total.toFixed(2));
  $('#mobileGrandTotal').text(total.toFixed(2));
  $('#total_amount').val(total.toFixed(2));
  updateBalance();
}

function updateBalance() {
  const total = parseFloat($('#total_amount').val()) || 0;
  const paidInput = $('#paid_amount').val();
  const paid = parseFloat(paidInput) || 0;
  const balance = total - paid;

  $('#balance').val(balance.toFixed(2));

  // Visual status & alert
  const alertEl = $('#balanceAlertText');
  if (balance <= 0 && total > 0) {
    $('#payment_status').val('Paid');
    alertEl.html('<span class="text-success fw-bold"><i class="bi bi-check-circle-fill me-1"></i>Fully Cleared</span>');
  } else if (balance < total && paid > 0) {
    $('#payment_status').val('Partial');
    alertEl.html('<span class="text-warning fw-bold"><i class="bi bi-hourglass-split me-1"></i>Partial Payment</span>');
  } else {
    $('#payment_status').val('Pending');
    alertEl.html('<span class="text-danger fw-bold"><i class="bi bi-exclamation-circle-fill me-1"></i>Payment Pending</span>');
  }
}

// Payment shortcut buttons
function setFullPaid() {
  const total = parseFloat($('#total_amount').val()) || 0;
  $('#paid_amount').val(total.toFixed(2));
  updateBalance();
}
function setPartialHalf() {
  const total = parseFloat($('#total_amount').val()) || 0;
  $('#paid_amount').val((total / 2).toFixed(2));
  updateBalance();
}
function setZeroPaid() {
  $('#paid_amount').val('0.00');
  updateBalance();
}

// Clear full form
function clearFullForm() {
  if (confirm('Are you sure you want to reset the entire billing form?')) {
    $('#billForm')[0].reset();
    clearPatientSelection();
    $('#test-rows').empty();
    addRow('test');
    calculateTotal();
  }
}

// Dynamic patient type fields
function loadPatientTypeFields() {
  const patientTypeId = document.getElementById("patient_type").value;
  const container = document.getElementById("patient-type-fields");

  if (!patientTypeId) {
    container.style.display = "none";
    $('#dynamic-fields').empty();
    return;
  }

  container.style.display = "block";
  $.ajax({
    url: 'get_patient_type_fields.php',
    method: 'POST',
    data: { patient_type_id: patientTypeId },
    success: function(response) {
      document.getElementById('dynamic-fields').innerHTML = response;
      $('#dynamic-fields input, #dynamic-fields select').addClass('form-control form-control-sm');
    }
  });
}

// Client-side form validation before submission
$('#billForm').on('submit', function(e) {
  const total = parseFloat($('#total_amount').val()) || 0;
  if (total <= 0) {
    e.preventDefault();
    alert('Please select at least one valid investigation test or package for the bill.');
    return false;
  }

  const name = $('#full_name').val().trim();
  if (!name) {
    e.preventDefault();
    alert('Please enter patient full name.');
    $('#full_name').focus();
    return false;
  }

  const phone = $('#phone').val().trim();
  if (!phone || phone.length < 10) {
    e.preventDefault();
    alert('Please enter a valid 10-digit mobile phone number.');
    $('#phone').focus();
    return false;
  }
});
</script>

</body>
</html>
