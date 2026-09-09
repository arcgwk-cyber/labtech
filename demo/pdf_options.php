<?php
/**
 * Diagnostic Report Customization & Print Studio
 * Features real-time reactive PDF preview, 3 clinical report styles,
 * 3 letterhead options (pre-printed 1.5" blank, printed lab logo & address, plain),
 * switches for interpretations, methods, page-breaks, and notes,
 * plus 1-click "Save as Default" for the diagnostic laboratory.
 */
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/db.php';

$bill_id = isset($_GET['bill_id']) ? (int)$_GET['bill_id'] : 0;
if ($bill_id <= 0) {
    $latest_q = $conn->query("SELECT bill_id FROM bills ORDER BY bill_id DESC LIMIT 1");
    if ($latest_q && $lr = $latest_q->fetch_assoc()) {
        $bill_id = (int)$lr['bill_id'];
    }
}
if ($bill_id <= 0) {
    die("Error: Valid Bill ID is required to generate a diagnostic report.");
}

// 1. Fetch Patient & Bill Information
$stmt = $conn->prepare("
    SELECT b.*, p.full_name, p.gender, p.date_of_birth, p.age, p.phone, p.dr_ref, p.address
    FROM bills b
    JOIN patients p ON b.patient_id = p.patient_id
    WHERE b.bill_id = ?
");
$stmt->bind_param("i", $bill_id);
$stmt->execute();
$bill = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$bill) {
    die("Patient invoice record not found.");
}

require_once __DIR__ . '/report_helper.php';

// 2. Load or Save Lab Default or Bill-Specific Report Preferences
$pref_file = __DIR__ . '/report_preferences.json';
$saved_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $posted_options = [
        'style'                  => $_POST['style'] ?? 'clinical',
        'header_mode'            => $_POST['header_mode'] ?? 'printed',
        'include_method'         => isset($_POST['include_method']) && $_POST['include_method'] === '1',
        'include_notes'          => isset($_POST['include_notes']) && $_POST['include_notes'] === '1',
        'include_interpretation' => isset($_POST['include_interpretation']) && $_POST['include_interpretation'] === '1',
        'pagebreak_per_test'     => isset($_POST['pagebreak_per_test']) && $_POST['pagebreak_per_test'] === '1',
        'include_signature'      => isset($_POST['include_signature']) && $_POST['include_signature'] === '1',
        'top_margin'             => isset($_POST['top_margin']) && is_numeric($_POST['top_margin']) ? floatval($_POST['top_margin']) : 55.0,
        'bottom_margin'          => isset($_POST['bottom_margin']) && is_numeric($_POST['bottom_margin']) ? floatval($_POST['bottom_margin']) : 35.0
    ];

    if ($_POST['action'] === 'save_default') {
        file_put_contents($pref_file, json_encode($posted_options, JSON_PRETTY_PRINT));
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'scope' => 'default', 'message' => 'Lab default report preferences have been saved!']);
            exit;
        }
        $saved_message = "Your lab's default report settings have been updated successfully!";
    } elseif ($_POST['action'] === 'save_bill' || $_POST['action'] === 'auto_save_bill') {
        saveBillReportOptions($bill_id, $posted_options, $conn);
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'scope' => 'bill', 'message' => "Report options saved specifically for Bill #{$bill_id}! QR code scan will use these settings."]);
            exit;
        }
        $saved_message = "Report settings for Bill #{$bill_id} saved successfully!";
    }
}

// Load effective options for this bill (Bill-specific overrides -> Lab defaults -> Fallback)
$has_custom_bill_settings = (getBillReportOptions($bill_id, $conn) !== null);
$prefs = getEffectiveReportOptions($bill_id, $conn);

$selected_style         = $prefs['style'];
$selected_header_mode   = $prefs['header_mode'];
$include_method         = $prefs['include_method'];
$include_notes          = $prefs['include_notes'];
$include_interpretation = $prefs['include_interpretation'];
$pagebreak_per_test     = $prefs['pagebreak_per_test'];
$include_signature      = $prefs['include_signature'];
$selected_top_margin    = $prefs['top_margin'] ?? 55.0;
$selected_bottom_margin = $prefs['bottom_margin'] ?? 35.0;
$is_studio = (isset($_GET['studio']) && $_GET['studio'] == '1');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Diagnostic Report & Print | Bill #<?= $bill_id ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    body {
      background-color: #f1f5f9;
      font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
      color: #1e293b;
    }
    .card-custom {
      background: #ffffff;
      border: 1px solid #e2e8f0;
      border-radius: 16px;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.04), 0 2px 4px -2px rgba(0, 0, 0, 0.02);
    }
    .style-card {
      border: 2px solid #e2e8f0;
      border-radius: 14px;
      padding: 13px;
      cursor: pointer;
      transition: all 0.2s ease;
      background: #ffffff;
      position: relative;
      height: 100%;
      user-select: none;
    }
    .style-card:hover {
      border-color: #93c5fd;
      transform: translateY(-2px);
      box-shadow: 0 6px 14px rgba(0,0,0,0.06);
    }
    .style-card.selected {
      border-color: #0284c7;
      background-color: #f0f9ff;
      box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.2);
    }
    .style-badge {
      width: 32px;
      height: 32px;
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1rem;
      margin-bottom: 8px;
    }
    .form-check-input:checked {
      background-color: #0284c7;
      border-color: #0284c7;
    }
    .preview-frame {
      width: 100%;
      height: 740px;
      border: 1px solid #cbd5e1;
      border-radius: 12px;
      background: #ffffff;
    }
    .loader-overlay {
      position: absolute;
      top: 0; left: 0; right: 0; bottom: 0;
      background: rgba(255,255,255,0.7);
      display: none;
      align-items: center;
      justify-content: center;
      z-index: 10;
      border-radius: 12px;
    }
  </style>
</head>
<body>

<?php include_once __DIR__ . '/header.php'; ?>

<div class="container-fluid px-4 py-4" style="max-width: 1480px;">

  <!-- Top Navigation & Action Shortcuts -->
  <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
    <div>
      <div class="d-flex align-items-center gap-2 mb-1">
        <a href="bill_list.php" class="btn btn-sm btn-outline-secondary rounded-2">
          <i class="bi bi-arrow-left me-1"></i> Invoices
        </a>
        <a href="result_entry.php?bill_id=<?= $bill_id ?>" class="btn btn-sm btn-outline-primary rounded-2">
          <i class="bi bi-clipboard-pulse me-1"></i> Edit Results
        </a>
      </div>
      <h3 class="fw-bold text-dark mb-0">Diagnostic Report & Print</h3>
      <p class="text-muted small mb-0">Quick clinical customization, live report preview, and instant printing.</p>
    </div>

    <!-- Direct Print / Download Actions -->
    <div class="d-flex align-items-center gap-2">
      <a id="topPrintBtn" href="#" target="_blank" class="btn btn-success px-4 py-2 rounded-3 fw-bold shadow-sm">
        <i class="bi bi-printer-fill me-1"></i> Print Report Now
      </a>
      <a id="topDownloadBtn" href="#" class="btn btn-outline-primary px-3 py-2 rounded-3 fw-semibold">
        <i class="bi bi-download me-1"></i> Download PDF
      </a>
    </div>
  </div>

  <!-- Toast / Alert Container -->
  <div id="statusAlert" class="alert alert-success alert-dismissible fade d-none align-items-center gap-2 mb-4" role="alert">
    <i class="bi bi-check-circle-fill fa-lg"></i>
    <div id="statusAlertText">Default report preferences saved successfully!</div>
    <button type="button" class="btn-close" onclick="this.parentElement.classList.add('d-none')"></button>
  </div>

  <div class="row g-4">

    <!-- Left Column: Settings & Styles -->
    <div class="col-lg-5">
      
      <!-- Patient Information Summary Card -->
      <div class="card-custom p-4 mb-4">
        <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3">
          <div>
            <span class="text-muted small text-uppercase">Patient Invoice</span>
            <h4 class="fw-bold text-primary mb-0 font-monospace">#<?= $bill['bill_id'] ?></h4>
          </div>
          <span class="badge bg-success bg-opacity-10 text-success fw-bold px-3 py-2 rounded-pill">
            <i class="bi bi-check2-circle me-1"></i> Ready for Print
          </span>
        </div>

        <div class="row g-3 small">
          <div class="col-6">
            <span class="text-muted d-block">Patient Full Name:</span>
            <strong class="text-dark fs-6"><?= htmlspecialchars($bill['full_name']) ?></strong>
          </div>
          <div class="col-6">
            <span class="text-muted d-block">Age / Gender:</span>
            <strong class="text-dark"><?= htmlspecialchars($bill['age'] ?: 'N/A') ?> / <?= htmlspecialchars($bill['gender']) ?></strong>
          </div>
          <div class="col-6">
            <span class="text-muted d-block">Phone Number:</span>
            <strong class="text-dark"><i class="bi bi-telephone text-muted me-1"></i><?= htmlspecialchars($bill['phone'] ?: 'N/A') ?></strong>
          </div>
          <div class="col-6">
            <span class="text-muted d-block">Referred Doctor:</span>
            <strong class="text-dark">Dr. <?= htmlspecialchars($bill['dr_ref'] ?: 'Direct / Self') ?></strong>
          </div>
          <div class="col-12">
            <span class="text-muted d-block">Registration Date:</span>
            <span><?= date('d-M-Y', strtotime($bill['bill_date'])) ?></span>
          </div>
        </div>
      </div>

      <!-- Report Content Customization Card (Primary Everyday View) -->
      <div class="card-custom p-4 mb-4">
        
        <div class="d-flex align-items-center justify-content-between border-bottom pb-2 mb-3">
          <h5 class="fw-bold text-dark mb-0">
            <i class="bi bi-sliders text-primary me-2"></i> Content Customization Switches
          </h5>
          <span class="badge bg-light text-secondary border small font-monospace" id="quickFormatBadge">
            <?= strtoupper($selected_style) ?>
          </span>
        </div>

        <div class="p-3 bg-light rounded-3 border mb-3">
          
          <div class="form-check form-switch mb-3">
            <input class="form-check-input" type="checkbox" role="switch" id="chkInterp" <?= $include_interpretation ? 'checked' : '' ?> onchange="updateLivePreview()">
            <label class="form-check-label fw-semibold text-dark" for="chkInterp">
              Include Diagnostic Interpretations
            </label>
            <div class="small text-muted">Displays clinical interpretations and significance beneath test sections.</div>
          </div>

          <div class="form-check form-switch mb-3">
            <input class="form-check-input" type="checkbox" role="switch" id="chkMethod" <?= $include_method ? 'checked' : '' ?> onchange="updateLivePreview()">
            <label class="form-check-label fw-semibold text-dark" for="chkMethod">
              Include Test Method
            </label>
            <div class="small text-muted">Prints test methodology (e.g. IFCC, HPLC, Hexokinase, CLIA).</div>
          </div>

          <div class="form-check form-switch mb-3">
            <input class="form-check-input" type="checkbox" role="switch" id="chkPagebreak" <?= $pagebreak_per_test ? 'checked' : '' ?> onchange="updateLivePreview()">
            <label class="form-check-label fw-semibold text-dark" for="chkPagebreak">
              Test-wise Page Break
            </label>
            <div class="small text-muted">Starts each major laboratory test profile on a fresh page.</div>
          </div>

          <div class="form-check form-switch mb-3">
            <input class="form-check-input" type="checkbox" role="switch" id="chkNotes" <?= $include_notes ? 'checked' : '' ?> onchange="updateLivePreview()">
            <label class="form-check-label fw-semibold text-dark" for="chkNotes">
              Include Clinical Notes
            </label>
            <div class="small text-muted">Includes footnote disclaimers and special instructions.</div>
          </div>

          <div class="form-check form-switch mb-0">
            <input class="form-check-input" type="checkbox" role="switch" id="chkSig" <?= $include_signature ? 'checked' : '' ?> onchange="updateLivePreview()">
            <label class="form-check-label fw-semibold text-dark" for="chkSig">
              Include Doctor Signature & Stamp
            </label>
            <div class="small text-muted">Appends doctor signature and official stamp on the report.</div>
          </div>

        </div>

        <!-- Save for Bill # (Lock for Patient QR) -->
        <div class="p-3 bg-success bg-opacity-10 border border-success border-opacity-25 rounded-3 d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-2 mb-3">
          <div>
            <div class="fw-bold text-success mb-0 d-flex align-items-center gap-1">
              <i class="bi bi-check-circle-fill text-success"></i> 
              Save for Bill #<?= $bill_id ?>
              <?php if ($has_custom_bill_settings): ?>
                <span class="badge bg-success small text-white ms-1">Customized</span>
              <?php endif; ?>
            </div>
            <div class="small text-muted" style="font-size:0.75rem;">Lock these specific notes, interpretations & page-breaks for this patient's QR download.</div>
          </div>
          <button type="button" class="btn btn-sm btn-success fw-bold px-3 py-2 text-nowrap" onclick="saveForThisBill()">
            <i class="bi bi-save2 me-1"></i> Save for this Bill
          </button>
        </div>

        <!-- Fast Print & Download Action Bar -->
        <div class="d-grid gap-2">
          <a id="panelPrintBtn" href="#" target="_blank" class="btn btn-success py-2 rounded-3 fw-bold shadow-sm">
            <i class="bi bi-printer-fill me-1"></i> Print Report Now
          </a>
          <a id="panelDownloadBtn" href="#" class="btn btn-outline-primary py-2 rounded-3 fw-semibold">
            <i class="bi bi-download me-1"></i> Download PDF
          </a>
        </div>

      </div>

      <!-- Studio & Lab Default Template Card (Collapsible for One-Time Setup or Template Editing) -->
      <div class="card-custom p-0 overflow-hidden mb-4">
        <button class="btn w-100 text-start p-3 d-flex align-items-center justify-content-between bg-light border-0" 
                type="button" data-bs-toggle="collapse" data-bs-target="#studioSettingsCollapse" 
                aria-expanded="<?= $is_studio ? 'true' : 'false' ?>" id="studioCollapseToggle">
          <div class="d-flex align-items-center gap-2">
            <div class="style-badge bg-primary bg-opacity-10 text-primary mb-0" style="width: 28px; height: 28px; border-radius: 6px;">
              <i class="bi bi-palette fs-6"></i>
            </div>
            <div>
              <div class="fw-bold text-dark small">Lab Template & Format Studio</div>
              <div class="text-muted" style="font-size: 0.72rem;">Configure layout format, letterhead mode & margins for the entire lab.</div>
            </div>
          </div>
          <div class="d-flex align-items-center gap-2">
            <span class="badge bg-primary bg-opacity-10 text-primary small font-monospace" id="activeStyleBadge"><?= strtoupper($selected_style) ?></span>
            <i class="bi bi-chevron-down text-muted" id="studioCollapseIcon"></i>
          </div>
        </button>

        <div class="collapse <?= $is_studio ? 'show' : '' ?> p-4 pt-3 border-top" id="studioSettingsCollapse">
          
          <!-- Section 1: Letterhead Option -->
          <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">
            <i class="bi bi-file-earmark-medical text-primary me-2"></i> 1. Letterhead / Top Header Option
          </h6>

          <div class="row g-2 mb-4">
            <!-- Option 1: Full Letterhead Image Background -->
            <div class="col-6 col-md-3">
              <div class="style-card header-card <?= $selected_header_mode === 'letterhead_image' ? 'selected' : '' ?>" data-headermode="letterhead_image" onclick="selectHeaderMode('letterhead_image')">
                <div class="style-badge bg-success bg-opacity-25 text-success">
                  <i class="bi bi-image"></i>
                </div>
                <h6 class="fw-bold text-dark mb-1 small">Letterhead Image</h6>
                <p class="text-muted mb-0" style="font-size: 0.72rem;">Uses uploaded letterhead background image (A4 full page).</p>
              </div>
            </div>

            <!-- Option 2: Pre-Printed Blank (1.5" Top) -->
            <div class="col-6 col-md-3">
              <div class="style-card header-card <?= $selected_header_mode === 'blank_1_5' ? 'selected' : '' ?>" data-headermode="blank_1_5" onclick="selectHeaderMode('blank_1_5')">
                <div class="style-badge bg-warning bg-opacity-25 text-warning-emphasis">
                  <i class="bi bi-file-earmark-ruled"></i>
                </div>
                <h6 class="fw-bold text-dark mb-1 small">Pre-Printed 1.5"</h6>
                <p class="text-muted mb-0" style="font-size: 0.72rem;">Leaves top <strong>1.5" (38mm)</strong> blank for clinic pre-printed sheets.</p>
              </div>
            </div>

            <!-- Option 3: Printed Lab Header (Logo + Address) -->
            <div class="col-6 col-md-3">
              <div class="style-card header-card <?= $selected_header_mode === 'printed' ? 'selected' : '' ?>" data-headermode="printed" onclick="selectHeaderMode('printed')">
                <div class="style-badge bg-primary text-white">
                  <i class="bi bi-hospital"></i>
                </div>
                <h6 class="fw-bold text-dark mb-1 small">Digital Lab Header</h6>
                <p class="text-muted mb-0" style="font-size: 0.72rem;">Prints Digital Lab Logo, Name, Address & divider header.</p>
              </div>
            </div>

            <!-- Option 4: Plain Page -->
            <div class="col-6 col-md-3">
              <div class="style-card header-card <?= $selected_header_mode === 'plain' ? 'selected' : '' ?>" data-headermode="plain" onclick="selectHeaderMode('plain')">
                <div class="style-badge bg-secondary text-white">
                  <i class="bi bi-file-text"></i>
                </div>
                <h6 class="fw-bold text-dark mb-1 small">Plain Page</h6>
                <p class="text-muted mb-0" style="font-size: 0.72rem;">Standard margins without any top header artwork.</p>
              </div>
            </div>
          </div>

          <!-- Header & Footer Margin / Spacing Adjustment Box -->
          <div id="marginAdjustmentBox" class="p-3 bg-light rounded-3 border mb-4">
            <!-- 1. Top Margin / Header Spacing -->
            <div class="mb-3 pb-3 border-bottom">
              <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-2">
                <div>
                  <span class="fw-bold text-dark small"><i class="bi bi-arrow-down-circle text-primary me-1"></i> Header Top Spacing / Content Margin:</span>
                  <span id="topMarginDisplay" class="badge bg-primary fs-7 ms-1"><?= (int)($selected_top_margin ?? 55) ?> mm</span>
                </div>
                <div class="btn-group btn-group-sm" role="group">
                  <button type="button" class="btn btn-outline-secondary btn-sm" onclick="setTopMargin(45)">45mm</button>
                  <button type="button" class="btn btn-outline-secondary btn-sm" onclick="setTopMargin(50)">50mm</button>
                  <button type="button" class="btn btn-outline-primary btn-sm fw-bold active" onclick="setTopMargin(55)">55mm (Standard)</button>
                  <button type="button" class="btn btn-outline-secondary btn-sm" onclick="setTopMargin(60)">60mm</button>
                  <button type="button" class="btn btn-outline-secondary btn-sm" onclick="setTopMargin(65)">65mm</button>
                </div>
              </div>
              <div class="d-flex align-items-center gap-3">
                <input type="range" class="form-range flex-grow-1" id="topMarginRange" min="30" max="85" step="1" value="<?= (int)($selected_top_margin ?? 55) ?>" oninput="onTopMarginChange(this.value)">
                <div class="input-group input-group-sm" style="width: 105px;">
                  <input type="number" class="form-control text-center font-monospace fw-bold" id="topMarginInput" min="30" max="85" value="<?= (int)($selected_top_margin ?? 55) ?>" onchange="onTopMarginChange(this.value)">
                  <span class="input-group-text">mm</span>
                </div>
              </div>
              <small class="text-muted d-block mt-1" style="font-size: 0.73rem;">
                <i class="bi bi-info-circle-fill text-primary"></i> <strong>Header adjust:</strong> If patient details touch your letterhead logo or green divider line, increase this slider (recommended <strong>55mm - 60mm</strong>).
              </small>
            </div>

            <!-- 2. Bottom Margin / Footer Spacing -->
            <div>
              <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-2">
                <div>
                  <span class="fw-bold text-dark small"><i class="bi bi-arrow-up-circle text-success me-1"></i> Footer Bottom Spacing / Margin:</span>
                  <span id="bottomMarginDisplay" class="badge bg-success fs-7 ms-1"><?= (int)($selected_bottom_margin ?? 35) ?> mm</span>
                </div>
                <div class="btn-group btn-group-sm" role="group">
                  <button type="button" class="btn btn-outline-secondary btn-sm" onclick="setBottomMargin(25)">25mm</button>
                  <button type="button" class="btn btn-outline-secondary btn-sm" onclick="setBottomMargin(30)">30mm</button>
                  <button type="button" class="btn btn-outline-success btn-sm fw-bold active" onclick="setBottomMargin(35)">35mm (Standard)</button>
                  <button type="button" class="btn btn-outline-secondary btn-sm" onclick="setBottomMargin(45)">45mm</button>
                  <button type="button" class="btn btn-outline-secondary btn-sm" onclick="setBottomMargin(50)">50mm</button>
                  <button type="button" class="btn btn-outline-secondary btn-sm" onclick="setBottomMargin(55)">55mm</button>
                </div>
              </div>
              <div class="d-flex align-items-center gap-3">
                <input type="range" class="form-range flex-grow-1" id="bottomMarginRange" min="15" max="75" step="1" value="<?= (int)($selected_bottom_margin ?? 35) ?>" oninput="onBottomMarginChange(this.value)">
                <div class="input-group input-group-sm" style="width: 105px;">
                  <input type="number" class="form-control text-center font-monospace fw-bold" id="bottomMarginInput" min="15" max="75" value="<?= (int)($selected_bottom_margin ?? 35) ?>" onchange="onBottomMarginChange(this.value)">
                  <span class="input-group-text">mm</span>
                </div>
              </div>
              <small class="text-muted d-block mt-1" style="font-size: 0.73rem;">
                <i class="bi bi-info-circle-fill text-success"></i> <strong>Footer adjust:</strong> If test rows, doctor signatures, or the QR code overlap your bottom address or swoosh graphic, increase this slider (recommended <strong>45mm - 50mm</strong> for Vensaas Labtech letterhead).
              </small>
            </div>
          </div>

          <!-- Section 2: Table Format Styles -->
          <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">
            <i class="bi bi-palette text-primary me-2"></i> 2. Table Layout Style
          </h6>

          <div class="row g-2 mb-4">
            <!-- Style 1: Smart Barcode (Featured) -->
            <div class="col-sm-6 col-md-3">
              <div class="style-card style-opt-card <?= $selected_style === 'smart' ? 'selected' : '' ?>" data-style="smart" onclick="selectReportStyle('smart')">
                <div class="style-badge bg-success text-white">
                  <i class="bi bi-qr-code-scan"></i>
                </div>
                <h6 class="fw-bold text-dark mb-1 small">Smart Barcode</h6>
                <p class="text-muted mb-0" style="font-size: 0.72rem;">Top QR & Barcode, 3-column header, Bill ID & Collected on.</p>
              </div>
            </div>

            <!-- Style 2: Clinical Standard -->
            <div class="col-sm-6 col-md-3">
              <div class="style-card style-opt-card <?= $selected_style === 'clinical' ? 'selected' : '' ?>" data-style="clinical" onclick="selectReportStyle('clinical')">
                <div class="style-badge bg-primary text-white">
                  <i class="bi bi-table"></i>
                </div>
                <h6 class="fw-bold text-dark mb-1 small">Standard Clinical</h6>
                <p class="text-muted mb-0" style="font-size: 0.72rem;">NABL blue table layout with official borders.</p>
              </div>
            </div>

            <!-- Style 3: Modern Minimalist -->
            <div class="col-sm-6 col-md-3">
              <div class="style-card style-opt-card <?= $selected_style === 'modern' ? 'selected' : '' ?>" data-style="modern" onclick="selectReportStyle('modern')">
                <div class="style-badge bg-dark text-white">
                  <i class="bi bi-layout-text-window-reverse"></i>
                </div>
                <h6 class="fw-bold text-dark mb-1 small">Modern Minimalist</h6>
                <p class="text-muted mb-0" style="font-size: 0.72rem;">Slate headers and alternating soft zebra rows.</p>
              </div>
            </div>

            <!-- Style 4: High Density Compact -->
            <div class="col-sm-6 col-md-3">
              <div class="style-card style-opt-card <?= $selected_style === 'compact' ? 'selected' : '' ?>" data-style="compact" onclick="selectReportStyle('compact')">
                <div class="style-badge bg-info text-white">
                  <i class="bi bi-grid-3x2"></i>
                </div>
                <h6 class="fw-bold text-dark mb-1 small">Compact Panel</h6>
                <p class="text-muted mb-0" style="font-size: 0.72rem;">Tight 8.5pt font, packs 25+ tests per page.</p>
              </div>
            </div>
          </div>

          <!-- Set as Lab Default -->
          <div class="p-3 bg-primary bg-opacity-10 border border-primary border-opacity-25 rounded-3 d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-2">
            <div>
              <div class="fw-bold text-primary mb-0"><i class="bi bi-star-fill text-warning me-1"></i> Set as Lab Default</div>
              <div class="small text-muted" style="font-size:0.75rem;">Apply these letterhead, margin & layout settings as default for all future reports.</div>
            </div>
            <button type="button" class="btn btn-sm btn-primary fw-bold px-3 py-2 text-nowrap shadow-sm" onclick="saveAsLabDefault()">
              <i class="bi bi-check-circle me-1"></i> Save as Lab Default
            </button>
          </div>

        </div>
      </div>

    </div>

    <!-- Right Column: Live Interactive PDF Preview -->
    <div class="col-lg-7">
      <div class="card-custom p-4 h-100 position-relative">
        
        <div class="d-flex align-items-center justify-content-between mb-3">
          <div class="d-flex align-items-center gap-2">
            <i class="bi bi-file-earmark-pdf-fill text-danger fs-4"></i>
            <h5 class="fw-bold text-dark mb-0">Live Diagnostic Report Preview</h5>
          </div>
          <div class="d-flex align-items-center gap-2">
            <a id="cardPrintBtn" href="#" target="_blank" class="btn btn-sm btn-success fw-bold px-3">
              <i class="bi bi-printer me-1"></i> Print
            </a>
            <a id="fullscreenBtn" href="#" target="_blank" class="btn btn-sm btn-outline-secondary fw-semibold">
              <i class="bi bi-fullscreen me-1"></i> Fullscreen
            </a>
          </div>
        </div>

        <!-- Loading spinner overlay -->
        <div id="previewLoader" class="loader-overlay">
          <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading Report...</span>
          </div>
        </div>

        <!-- Embedded PDF Viewer iframe -->
        <iframe id="pdfPreviewFrame" class="preview-frame" title="Diagnostic Report Preview"></iframe>

      </div>
    </div>

  </div>

</div>

<!-- JavaScript Engine for Real-Time Preview & Settings Persistence -->
<script>
let currentStyle = '<?= htmlspecialchars($selected_style) ?>';
let currentHeaderMode = '<?= htmlspecialchars($selected_header_mode) ?>';
let currentTopMargin = <?= (float)$selected_top_margin ?>;
let currentBottomMargin = <?= (float)$selected_bottom_margin ?>;
const billId = <?= $bill_id ?>;

function onTopMarginChange(val) {
  val = parseFloat(val) || 55;
  currentTopMargin = val;
  document.getElementById('topMarginRange').value = val;
  document.getElementById('topMarginInput').value = val;
  document.getElementById('topMarginDisplay').textContent = val + ' mm';
  updateLivePreview();
}

function setTopMargin(val) {
  onTopMarginChange(val);
}

function onBottomMarginChange(val) {
  val = parseFloat(val) || 35;
  currentBottomMargin = val;
  document.getElementById('bottomMarginRange').value = val;
  document.getElementById('bottomMarginInput').value = val;
  document.getElementById('bottomMarginDisplay').textContent = val + ' mm';
  updateLivePreview();
}

function setBottomMargin(val) {
  onBottomMarginChange(val);
}

function selectReportStyle(styleName) {
  currentStyle = styleName;
  
  // Highlight active style card
  document.querySelectorAll('.style-opt-card').forEach(card => {
    if (card.getAttribute('data-style') === styleName) {
      card.classList.add('selected');
    } else {
      card.classList.remove('selected');
    }
  });

  const b1 = document.getElementById('quickFormatBadge');
  if (b1) b1.textContent = styleName.toUpperCase();
  const b2 = document.getElementById('activeStyleBadge');
  if (b2) b2.textContent = styleName.toUpperCase();

  updateLivePreview();
}

function selectHeaderMode(modeName) {
  currentHeaderMode = modeName;

  // Highlight active header card
  document.querySelectorAll('.header-card').forEach(card => {
    if (card.getAttribute('data-headermode') === modeName) {
      card.classList.add('selected');
    } else {
      card.classList.remove('selected');
    }
  });

  updateLivePreview();
}

function buildPdfUrl(isPrint = false, isDownload = false) {
  const method = document.getElementById('chkMethod').checked ? 1 : 0;
  const notes = document.getElementById('chkNotes').checked ? 1 : 0;
  const interp = document.getElementById('chkInterp').checked ? 1 : 0;
  const pagebreak = document.getElementById('chkPagebreak').checked ? 1 : 0;
  const sig = document.getElementById('chkSig').checked ? 1 : 0;

  let url = 'report_generate_pdf.php?bill_id=' + billId +
            '&style=' + encodeURIComponent(currentStyle) +
            '&header_mode=' + encodeURIComponent(currentHeaderMode) +
            '&top_margin=' + encodeURIComponent(currentTopMargin) +
            '&bottom_margin=' + encodeURIComponent(currentBottomMargin) +
            '&include_method=' + method +
            '&include_notes=' + notes +
            '&include_interpretation=' + interp +
            '&pagebreak_per_test=' + pagebreak +
            '&include_signature=' + sig +
            '&applied=1';

  if (isPrint) url += '&print=1';
  if (isDownload) url += '&download=1';
  return url;
}

function updateLivePreview() {
  const loader = document.getElementById('previewLoader');
  const iframe = document.getElementById('pdfPreviewFrame');
  const previewUrl = buildPdfUrl(false);
  const printUrl = buildPdfUrl(true);
  const downloadUrl = buildPdfUrl(false, true);

  // Update action links
  document.getElementById('topPrintBtn').href = printUrl;
  document.getElementById('topDownloadBtn').href = downloadUrl;
  document.getElementById('cardPrintBtn').href = printUrl;
  document.getElementById('fullscreenBtn').href = previewUrl;
  const pb = document.getElementById('panelPrintBtn');
  if (pb) pb.href = printUrl;
  const pd = document.getElementById('panelDownloadBtn');
  if (pd) pd.href = downloadUrl;

  // Show loader and reload iframe
  if (loader) loader.style.display = 'flex';
  iframe.src = previewUrl + '#toolbar=0';
  iframe.onload = function() {
    if (loader) loader.style.display = 'none';
  };

  // Silently auto-save current options for this bill so QR code scan instantly matches
  saveForThisBill(true);
}

function getSelectedOptionsFormData(actionName) {
  const method = document.getElementById('chkMethod').checked ? 1 : 0;
  const notes = document.getElementById('chkNotes').checked ? 1 : 0;
  const interp = document.getElementById('chkInterp').checked ? 1 : 0;
  const pagebreak = document.getElementById('chkPagebreak').checked ? 1 : 0;
  const sig = document.getElementById('chkSig').checked ? 1 : 0;

  const formData = new FormData();
  formData.append('action', actionName);
  formData.append('style', currentStyle);
  formData.append('header_mode', currentHeaderMode);
  formData.append('top_margin', currentTopMargin);
  formData.append('bottom_margin', currentBottomMargin);
  formData.append('include_method', method);
  formData.append('include_notes', notes);
  formData.append('include_interpretation', interp);
  formData.append('pagebreak_per_test', pagebreak);
  formData.append('include_signature', sig);
  return formData;
}

function showNotification(htmlMessage, isSuccess = true) {
  const alertBox = document.getElementById('statusAlert');
  const alertText = document.getElementById('statusAlertText');
  if (!alertBox || !alertText) return;

  alertText.innerHTML = htmlMessage;
  alertBox.classList.remove('d-none');
  alertBox.classList.add('show');
  setTimeout(() => { alertBox.classList.add('d-none'); }, 4000);
}

function saveForThisBill(isSilent = false) {
  const formData = getSelectedOptionsFormData(isSilent ? 'auto_save_bill' : 'save_bill');

  fetch('pdf_options.php?bill_id=' + billId, {
    method: 'POST',
    headers: { 'X-Requested-With': 'XMLHttpRequest' },
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    if (data.success && !isSilent) {
      showNotification('<strong>Saved for Bill #' + billId + '!</strong> When the patient scans the QR code, the report will render with these exact notes, interpretations & page-break settings.');
    }
  })
  .catch(err => {
    if (!isSilent) showNotification('Settings saved for this bill successfully!');
  });
}

function saveAsLabDefault() {
  const formData = getSelectedOptionsFormData('save_default');

  fetch('pdf_options.php?bill_id=' + billId, {
    method: 'POST',
    headers: { 'X-Requested-With': 'XMLHttpRequest' },
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      showNotification('<strong>Lab Defaults Updated!</strong> Future reports will default to <strong>' + currentHeaderMode.toUpperCase() + '</strong> header and <strong>' + currentStyle.toUpperCase() + '</strong> style.');
    }
  })
  .catch(err => {
    showNotification('Lab default preferences saved successfully!');
  });
}

// Initial load on page ready
document.addEventListener('DOMContentLoaded', function() {
  updateLivePreview();
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
