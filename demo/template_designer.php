<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . "/auth_check.php";
require_once __DIR__ . "/db.php";

// Get query params
$type_id = isset($_GET['patient_type_id']) ? (int)$_GET['patient_type_id'] : 0;
$template_id = isset($_GET['template_id']) ? (int)$_GET['template_id'] : 0;

// Load Patient Types
$types_res = $conn->query("SELECT type_id, type_name FROM patient_types ORDER BY type_name ASC");
$patient_types = [];
if ($types_res) {
    while($row = $types_res->fetch_assoc()) {
        $patient_types[] = $row;
    }
}

// Default to first patient type if not specified
if ($type_id <= 0 && !empty($patient_types)) {
    $type_id = (int)$patient_types[0]['type_id'];
}

// Load Templates for Selected Type
$templates = [];
if ($type_id > 0) {
    $stmt = $conn->prepare("SELECT * FROM report_templates WHERE patient_type_id = ? ORDER BY template_id DESC");
    if ($stmt) {
        $stmt->bind_param("i", $type_id);
        $stmt->execute();
        $templates = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
    }
}

// Default to first template if not specified
if ($template_id <= 0 && !empty($templates)) {
    $template_id = (int)$templates[0]['template_id'];
}

// Load Selected Template
$layout = [];
$header_layout = [];
$signature_layout = [];
$tpl = null;

if ($template_id > 0) {
    $stmt = $conn->prepare("SELECT * FROM report_templates WHERE template_id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $template_id);
        $stmt->execute();
        $tpl = $stmt->get_result()->fetch_assoc();
        $stmt->close();
    }
    
    if ($tpl) {
        if (!empty($tpl['layout_json'])) {
            $layout = json_decode($tpl['layout_json'], true);
        }
        if (!empty($tpl['header_layout_json'])) {
            $header_layout = json_decode($tpl['header_layout_json'], true);
        }
        if (!empty($tpl['signature_layout_json'])) {
            $signature_layout = json_decode($tpl['signature_layout_json'], true);
        }
    }
}

// Default Table Layout fallback
if (empty($layout) || !isset($layout['columns'])) {
    $layout = [
        "columns" => [
            ["key" => "param_name", "label" => "Test Parameter / Description", "width" => "32%"],
            ["key" => "result", "label" => "Observed Result", "width" => "18%"],
            ["key" => "unit", "label" => "Unit", "width" => "14%"],
            ["key" => "reference", "label" => "Biological Reference", "width" => "24%"],
            ["key" => "flag", "label" => "Status Flag", "width" => "12%"]
        ],
        "method_under_test" => true,
        "method_font_size" => "small",
        "method_italic" => true,
        "method_color" => "#64748b",
        "show_border" => true,
        "striped_rows" => true,
        "header_bg" => "#f1f5f9"
    ];
}

// Default Header Layout fallback
if (empty($header_layout) || !isset($header_layout['rows'])) {
    $header_layout = [
        "rows" => [
            [
                "type" => "row",
                "columns" => [
                    ["type" => "field", "field" => "patient_name", "label" => "Patient Name", "width" => "50%"],
                    ["type" => "field", "field" => "patient_id", "label" => "Patient ID / UHID", "width" => "50%"]
                ]
            ],
            [
                "type" => "row",
                "columns" => [
                    ["type" => "field", "field" => "age_gender", "label" => "Age / Gender", "width" => "33%"],
                    ["type" => "field", "field" => "sample_date", "label" => "Sample Collected", "width" => "33%"],
                    ["type" => "field", "field" => "report_date", "label" => "Report Date", "width" => "34%"]
                ]
            ],
            [
                "type" => "row",
                "columns" => [
                    ["type" => "field", "field" => "referring_doctor", "label" => "Ref. Doctor", "width" => "50%"],
                    ["type" => "field", "field" => "collection_center", "label" => "Collection Centre", "width" => "50%"]
                ]
            ]
        ]
    ];
}

// Default Signature Layout fallback
if (empty($signature_layout)) {
    $signature_layout = [
        "show_qr" => true,
        "qr_position" => "right",
        "qr_size" => "medium",
        "signatures" => [
            [
                "type" => "technician",
                "name" => "Jane Doe, MLT",
                "designation" => "Medical Lab Technologist",
                "position" => "left"
            ],
            [
                "type" => "doctor",
                "name" => "Dr. Robert Vance, MD",
                "designation" => "Consultant Pathologist",
                "position" => "right"
            ]
        ],
        "footer_text" => "This is a computer-verified diagnostic pathology report. Please correlate clinically.",
        "show_page_number" => true
    ];
}

// Load version history
$versions = [];
if ($template_id > 0) {
    $stmt = $conn->prepare("
        SELECT vh.*, rt.template_name 
        FROM template_version_history vh
        JOIN report_templates rt ON vh.template_id = rt.template_id
        WHERE vh.template_id = ?
        ORDER BY vh.version DESC
    ");
    if ($stmt) {
        $stmt->bind_param("i", $template_id);
        $stmt->execute();
        $versions = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
    }
}

// Available Header Fields Palette
$header_fields = [
    ["key" => "patient_name", "label" => "Patient Name", "icon" => "fa-user"],
    ["key" => "patient_id", "label" => "Patient ID / UHID", "icon" => "fa-id-card"],
    ["key" => "age_gender", "label" => "Age / Gender", "icon" => "fa-venus-mars"],
    ["key" => "sample_date", "label" => "Sample Collected", "icon" => "fa-vial"],
    ["key" => "report_date", "label" => "Report Authorized", "icon" => "fa-calendar-check"],
    ["key" => "referring_doctor", "label" => "Referring Doctor", "icon" => "fa-user-md"],
    ["key" => "collection_center", "label" => "Collection Centre", "icon" => "fa-hospital"],
    ["key" => "test_name", "label" => "Investigation / Test", "icon" => "fa-microscope"],
    ["key" => "accession_number", "label" => "Barcode / Accession", "icon" => "fa-barcode"],
    ["key" => "lab_id", "label" => "Laboratory Bill ID", "icon" => "fa-hashtag"],
    ["key" => "clinic_name", "label" => "Clinic / Organization", "icon" => "fa-clinic-medical"],
    ["key" => "sample_type", "label" => "Sample Specimen", "icon" => "fa-tint"],
    ["key" => "phone", "label" => "Patient Phone", "icon" => "fa-phone"]
];

// Available Table Columns Palette
$table_columns = [
    ["key" => "param_name", "label" => "Test Parameter / Description"],
    ["key" => "result", "label" => "Observed Result"],
    ["key" => "unit", "label" => "Biological Unit"],
    ["key" => "reference", "label" => "Biological Reference Range"],
    ["key" => "flag", "label" => "Abnormal Flag (H / L)"],
    ["key" => "comments", "label" => "Clinical Comments / Interpretation"],
    ["key" => "status", "label" => "Test Status"]
];

include_once __DIR__ . '/header.php';
?>

<!-- jQuery UI for Drag-and-Drop functionality -->
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

:root {
    --brand-primary: #0284c7;
    --brand-dark: #0369a1;
    --surface-bg: #f8fafc;
    --card-border: #e2e8f0;
    --text-primary: #0f172a;
    --text-muted: #64748b;
}

body {
    background-color: var(--surface-bg);
    font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
    color: var(--text-primary);
}

::placeholder {
    color: #94a3b8 !important;
    opacity: 0.75 !important;
}

/* Studio Header Bar */
.studio-header {
    background: #ffffff;
    border-bottom: 1px solid var(--card-border);
    padding: 16px 24px;
    margin-bottom: 20px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.03);
}

/* Main Studio Layout Grid */
.designer-workspace {
    display: grid;
    grid-template-columns: 310px 1fr 430px;
    gap: 20px;
    padding: 0 24px 30px;
    min-height: calc(100vh - 140px);
    align-items: start;
}

@media (max-width: 1399px) {
    .designer-workspace {
        grid-template-columns: 290px 1fr 390px;
        gap: 16px;
        padding: 0 16px 24px;
    }
}

@media (max-width: 1024px) {
    .designer-workspace {
        grid-template-columns: 1fr;
    }
}

/* Studio Panels */
.studio-panel {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid var(--card-border);
    box-shadow: 0 4px 12px rgba(15, 23, 42, 0.04);
    display: flex;
    flex-direction: column;
}

.studio-panel-header {
    padding: 14px 18px;
    border-bottom: 1px solid var(--card-border);
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #ffffff;
    border-top-left-radius: 12px;
    border-top-right-radius: 12px;
}

.studio-panel-body {
    padding: 18px;
}

/* Templates List */
.template-item-card {
    padding: 12px 14px;
    background: #f8fafc;
    border: 1px solid var(--card-border);
    border-radius: 8px;
    margin-bottom: 8px;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.template-item-card:hover {
    border-color: var(--brand-primary);
    background: #f0f9ff;
    transform: translateX(2px);
}

.template-item-card.active {
    background: #e0f2fe;
    border-color: #0284c7;
    box-shadow: 0 2px 6px rgba(2, 132, 199, 0.15);
}

/* Studio Tabs */
.designer-tabs {
    display: flex;
    border-bottom: 1px solid var(--card-border);
    background: #f8fafc;
    border-top-left-radius: 12px;
    border-top-right-radius: 12px;
    overflow-x: auto;
}

.designer-tab-btn {
    padding: 12px 18px;
    font-size: 0.88rem;
    font-weight: 600;
    color: var(--text-muted);
    border: none;
    background: transparent;
    border-bottom: 2px solid transparent;
    cursor: pointer;
    transition: all 0.2s;
    white-space: nowrap;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.designer-tab-btn:hover {
    color: var(--brand-primary);
    background: rgba(2, 132, 199, 0.04);
}

.designer-tab-btn.active {
    color: var(--brand-primary);
    background: #ffffff;
    border-bottom-color: var(--brand-primary);
}

.tab-pane-content {
    display: none;
    padding: 20px;
}

.tab-pane-content.active {
    display: block;
}

/* Draggable Items & Chips */
.field-chip-palette {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 16px;
}

.draggable-field-chip {
    padding: 6px 12px;
    background: #f1f5f9;
    border: 1px solid #cbd5e1;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    color: #334155;
    cursor: grab;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.2s;
    user-select: none;
}

.draggable-field-chip:hover {
    background: #e2e8f0;
    border-color: var(--brand-primary);
    color: var(--brand-primary);
    transform: translateY(-1px);
}

/* Canvas Drop Zones */
.layout-canvas-area {
    min-height: 180px;
    border: 2px dashed #cbd5e1;
    border-radius: 10px;
    padding: 14px;
    background: #f8fafc;
    margin-bottom: 16px;
}

.grid-row-box {
    display: flex;
    gap: 10px;
    margin-bottom: 10px;
    min-height: 52px;
    padding: 10px;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    align-items: center;
    box-shadow: 0 1px 3px rgba(0,0,0,0.02);
}

.grid-col-box {
    flex: 1;
    padding: 8px 12px;
    background: #f0f9ff;
    border: 1px solid #bae6fd;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 0.82rem;
    gap: 8px;
}

.col-drag-handle {
    cursor: move;
    color: #94a3b8;
}

.col-drag-handle:hover {
    color: var(--brand-primary);
}

/* Table Column Sortable Items */
.sortable-col-card {
    padding: 10px 14px;
    background: #ffffff;
    border: 1px solid var(--card-border);
    border-radius: 8px;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.02);
}

.sortable-col-card:hover {
    border-color: var(--brand-primary);
}

/* A4 Report Simulator Paper */
.report-paper-simulator {
    background: #ffffff;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08);
    padding: 24px 20px;
    font-size: 0.82rem;
    line-height: 1.4;
    min-height: 580px;
}

.preview-lab-header {
    text-align: center;
    border-bottom: 2px solid #0284c7;
    padding-bottom: 12px;
    margin-bottom: 14px;
}

.preview-patient-grid {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    padding: 8px 12px;
    margin-bottom: 14px;
}

.preview-header-row {
    display: flex;
    flex-wrap: wrap;
    padding: 3px 0;
}

.preview-header-col {
    flex: 1;
    padding: 2px 6px;
}

.preview-results-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 16px;
    font-size: 0.8rem;
}

.preview-results-table th {
    background: #f1f5f9;
    border-bottom: 2px solid #cbd5e1;
    padding: 6px 8px;
    text-align: left;
    font-weight: 700;
    color: #334155;
}

.preview-results-table td {
    padding: 6px 8px;
    border-bottom: 1px solid #f1f5f9;
    color: #1e293b;
}

.preview-footer-area {
    margin-top: 24px;
    padding-top: 14px;
    border-top: 1px dashed #cbd5e1;
}

.qr-box-sim {
    display: inline-flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: #f8fafc;
    border: 1px dashed #94a3b8;
    border-radius: 4px;
    color: #475569;
    font-size: 0.7rem;
    text-align: center;
}

.qr-box-sim.qr-small { width: 60px; height: 60px; }
.qr-box-sim.qr-medium { width: 80px; height: 80px; }
.qr-box-sim.qr-large { width: 100px; height: 100px; }

/* Status Toast Notification */
#studioToast {
    position: fixed;
    top: 24px;
    right: 24px;
    z-index: 9999;
    min-width: 320px;
    display: none;
}
</style>

<div class="studio-header">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div>
            <div class="d-flex align-items-center gap-2">
                <h4 class="mb-0 fw-bold text-dark"><i class="fas fa-palette text-primary me-2"></i>Report Template Studio</h4>
                <span class="badge bg-primary-subtle text-primary border border-primary-subtle fw-semibold px-2 py-1">Visual Drag & Drop Engine</span>
            </div>
            <p class="text-muted small mb-0 mt-1">Design report header layouts, parameter result columns, method styling, QR security seals, and doctor digital signatures.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="pdf_options.php" class="btn btn-outline-secondary btn-sm fw-semibold">
                <i class="fas fa-sliders-h me-1"></i> PDF Layout & Margins
            </a>
            <a href="sign_master.php" class="btn btn-outline-secondary btn-sm fw-semibold">
                <i class="fas fa-file-signature me-1"></i> Doctor Signatures
            </a>
            <a href="patient_types.php" class="btn btn-outline-secondary btn-sm fw-semibold">
                <i class="fas fa-tags me-1"></i> Patient Categories
            </a>
        </div>
    </div>
</div>

<div class="designer-workspace">
    <!-- 1. LEFT PANEL: Template Manager -->
    <div class="studio-panel">
        <div class="studio-panel-header">
            <span class="fw-bold text-dark"><i class="fas fa-folder-open text-primary me-2"></i>Template Manager</span>
            <button class="btn btn-sm btn-primary py-1 px-2 fw-semibold" onclick="createNewTemplate()">
                <i class="fas fa-plus me-1"></i> New
            </button>
        </div>
        <div class="studio-panel-body">
            <label class="form-label small fw-bold text-muted text-uppercase mb-1">Patient Category</label>
            <div class="input-group input-group-sm mb-3">
                <select id="patientTypeSelect" class="form-select fw-semibold" onchange="changePatientType()">
                    <option value="">-- Select Category --</option>
                    <?php foreach($patient_types as $pt): ?>
                        <option value="<?= $pt['type_id'] ?>" <?= $type_id == $pt['type_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($pt['type_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <a href="patient_types.php" class="btn btn-outline-secondary" title="Manage Categories"><i class="fas fa-cog"></i></a>
            </div>

            <?php if($type_id > 0): ?>
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <label class="form-label small fw-bold text-muted text-uppercase mb-0">Saved Templates (<?= count($templates) ?>)</label>
                </div>

                <div class="templates-list-container" style="max-height: 280px; overflow-y: auto; margin-bottom: 14px;">
                    <?php if(empty($templates)): ?>
                        <div class="text-center text-muted small py-4 bg-light rounded">
                            <i class="fas fa-file-alt fa-2x mb-2 text-secondary opacity-50"></i><br>
                            No templates found for this category.<br>
                            <button class="btn btn-outline-primary btn-sm mt-2 fw-semibold" onclick="createNewTemplate()">
                                Create First Template
                            </button>
                        </div>
                    <?php else: ?>
                        <?php foreach($templates as $t): ?>
                            <div class="template-item-card <?= $template_id == $t['template_id'] ? 'active' : '' ?>"
                                 onclick="loadTemplate(<?= $t['template_id'] ?>)">
                                <div>
                                    <div class="fw-bold small text-dark"><?= htmlspecialchars($t['template_name']) ?></div>
                                    <div class="text-muted" style="font-size: 0.72rem;">
                                        Updated: <?= !empty($t['updated_at']) ? date('d M Y', strtotime($t['updated_at'])) : 'Initial' ?>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-1">
                                    <span class="badge bg-primary text-white" style="font-size: 0.7rem;">v<?= $t['version'] ?? 1 ?></span>
                                    <?php if($template_id == $t['template_id']): ?>
                                        <button class="btn btn-outline-danger btn-sm p-1 border-0" title="Delete Template" onclick="event.stopPropagation(); deleteCurrentTemplate(<?= $t['template_id'] ?>);">
                                            <i class="fas fa-trash-alt text-danger"></i>
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <?php if($template_id > 0): ?>
                    <div class="d-grid gap-2 mb-3">
                        <button class="btn btn-outline-secondary btn-sm fw-semibold" onclick="duplicateTemplate()">
                            <i class="fas fa-clone me-1 text-primary"></i> Duplicate Template
                        </button>
                    </div>

                    <!-- Version History Collapsible -->
                    <div class="border rounded p-2 bg-light">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <span class="small fw-bold text-dark"><i class="fas fa-history text-secondary me-1"></i>Revisions (<?= count($versions) ?>)</span>
                        </div>
                        <div style="max-height: 150px; overflow-y: auto;">
                            <?php if(empty($versions)): ?>
                                <small class="text-muted">No revision history yet.</small>
                            <?php else: ?>
                                <?php foreach($versions as $ver): ?>
                                    <div class="d-flex align-items-center justify-content-between py-1 border-bottom border-light" style="font-size: 0.75rem;">
                                        <div>
                                            <span class="badge bg-secondary">v<?= $ver['version'] ?></span>
                                            <span class="text-muted ms-1"><?= htmlspecialchars(substr($ver['change_description'] ?? 'Revision', 0, 20)) ?></span>
                                        </div>
                                        <button class="btn btn-link btn-sm p-0 text-decoration-none" onclick="viewVersion(<?= $ver['version_id'] ?>)">Restore</button>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- 2. MIDDLE PANEL: Studio Tabs & Drag-Drop Controls -->
    <div class="studio-panel">
        <?php if($template_id > 0 && $tpl): ?>
            <!-- Tab Navigation Header -->
            <div class="designer-tabs">
                <button class="designer-tab-btn active" onclick="showDesignerTab('headerTab')">
                    <i class="fas fa-heading text-primary"></i> 1. Patient Header
                </button>
                <button class="designer-tab-btn" onclick="showDesignerTab('tableTab')">
                    <i class="fas fa-table text-info"></i> 2. Table Columns & Method
                </button>
                <button class="designer-tab-btn" onclick="showDesignerTab('signatureTab')">
                    <i class="fas fa-file-signature text-success"></i> 3. Signatures & QR
                </button>
                <button class="designer-tab-btn" onclick="showDesignerTab('stylingTab')">
                    <i class="fas fa-paint-brush text-warning"></i> 4. Typography & Borders
                </button>
            </div>

            <!-- Tab 1: Header Layout -->
            <div id="headerTab" class="tab-pane-content active">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div>
                        <h6 class="fw-bold mb-0 text-dark">Patient Demographics Header Grid</h6>
                        <small class="text-muted">Drag demographic tags into row dropzones to format patient details.</small>
                    </div>
                    <button class="btn btn-sm btn-outline-primary fw-semibold" onclick="addNewRow()">
                        <i class="fas fa-plus me-1"></i> Add Row
                    </button>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted text-uppercase mb-2">Available Field Tokens (Click or Drag)</label>
                    <div class="field-chip-palette" id="headerFieldsPalette">
                        <?php foreach($header_fields as $hf): ?>
                            <div class="draggable-field-chip" data-field="<?= $hf['key'] ?>" data-label="<?= $hf['label'] ?>" onclick="addColumnToRow('<?= $hf['key'] ?>', '<?= $hf['label'] ?>')">
                                <i class="fas <?= $hf['icon'] ?> text-primary"></i> <?= $hf['label'] ?>
                                <span class="badge bg-white text-muted border ms-1" style="font-size: 0.68rem;">+</span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <label class="form-label small fw-bold text-muted text-uppercase mb-2">Configured Header Grid</label>
                <div class="layout-canvas-area" id="headerLayoutCanvas">
                    <?php foreach($header_layout['rows'] as $rowIndex => $row): ?>
                        <div class="grid-row-box" data-row-index="<?= $rowIndex ?>">
                            <span class="col-drag-handle me-1" title="Drag to reorder rows"><i class="fas fa-grip-vertical"></i></span>
                            <div class="d-flex flex-grow-1 gap-2 row-cols-container">
                                <?php foreach($row['columns'] as $colIndex => $col): ?>
                                    <div class="grid-col-box" data-field="<?= $col['field'] ?>" style="flex: <?= $col['width'] ?? '1' ?>;">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="col-drag-handle"><i class="fas fa-bars"></i></span>
                                            <div>
                                                <div class="fw-bold text-dark" style="font-size: 0.8rem;"><?= htmlspecialchars($col['label']) ?></div>
                                                <div class="text-muted" style="font-size: 0.68rem;"><?= htmlspecialchars($col['field']) ?></div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-link text-danger p-0" onclick="removeColumn(this)" title="Remove"><i class="fas fa-times"></i></button>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-danger ms-1 p-1 border-0" onclick="removeRow(this)" title="Delete Row"><i class="fas fa-trash-alt"></i></button>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-sm btn-secondary" onclick="resetStandardHeader()">
                        <i class="fas fa-undo me-1"></i> Reset Standard 2-Row Header
                    </button>
                </div>
            </div>

            <!-- Tab 2: Table Columns & Method -->
            <div id="tableTab" class="tab-pane-content">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div>
                        <h6 class="fw-bold mb-0 text-dark">Test Result Table Columns</h6>
                        <small class="text-muted">Drag cards to reorder table column headers, set proportional widths, and configure analytical method display.</small>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted text-uppercase mb-2">Add Extra Available Columns</label>
                    <div class="field-chip-palette">
                        <?php foreach($table_columns as $tc): ?>
                            <div class="draggable-field-chip" onclick="addTableColumn('<?= $tc['key'] ?>', '<?= $tc['label'] ?>')">
                                <i class="fas fa-columns text-info"></i> <?= $tc['label'] ?>
                                <span class="badge bg-white text-muted border ms-1">+</span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <label class="form-label small fw-bold text-muted text-uppercase mb-2">Active Columns (Drag to Reorder)</label>
                <div id="selectedColumnsList" class="mb-3">
                    <?php foreach($layout['columns'] as $col): ?>
                        <div class="sortable-col-card" data-key="<?= $col['key'] ?>">
                            <div class="d-flex align-items-center gap-2">
                                <span class="col-drag-handle"><i class="fas fa-grip-vertical"></i></span>
                                <div>
                                    <strong class="text-dark small"><?= htmlspecialchars($col['label']) ?></strong>
                                    <div class="text-muted" style="font-size: 0.7rem;"><?= htmlspecialchars($col['key']) ?></div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <div class="input-group input-group-sm" style="width: 110px;">
                                    <span class="input-group-text p-1 text-muted" style="font-size: 0.7rem;">Width</span>
                                    <input type="text" class="form-control form-control-sm text-center px-1" value="<?= $col['width'] ?? 'auto' ?>" onchange="updateColumnWidth(this, '<?= $col['key'] ?>')" placeholder="e.g. 25%">
                                </div>
                                <button type="button" class="btn btn-sm btn-link text-danger p-0 ms-1" onclick="removeTableColumn(this)"><i class="fas fa-trash-alt"></i></button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="card p-3 border rounded bg-light mb-3">
                    <h6 class="fw-bold text-dark small mb-2"><i class="fas fa-flask text-primary me-1"></i>Analytical Method Configuration</h6>
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" id="methodUnder" <?= ($layout['method_under_test'] ?? true) ? 'checked' : '' ?> onchange="toggleMethodOptions(); updatePreview();">
                        <label class="form-check-label fw-semibold text-dark small" for="methodUnder">Display Analytical Method Sub-line Under Test Name</label>
                    </div>

                    <div id="methodOptionsBox" class="row g-2 mt-1" style="<?= empty($layout['method_under_test']) ? 'display:none;' : '' ?>">
                        <div class="col-md-4">
                            <label class="form-label small text-muted mb-1">Font Size</label>
                            <select id="methodFontSize" class="form-select form-select-sm" onchange="updatePreview()">
                                <option value="small" <?= ($layout['method_font_size'] ?? 'small') == 'small' ? 'selected' : '' ?>>Small (85%)</option>
                                <option value="smaller" <?= ($layout['method_font_size'] ?? 'small') == 'smaller' ? 'selected' : '' ?>>Smaller (80%)</option>
                                <option value="x-small" <?= ($layout['method_font_size'] ?? 'small') == 'x-small' ? 'selected' : '' ?>>Extra Small (75%)</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small text-muted mb-1">Text Color</label>
                            <input type="color" id="methodColor" class="form-control form-control-sm form-control-color w-100" value="<?= $layout['method_color'] ?? '#64748b' ?>" onchange="updatePreview()">
                        </div>
                        <div class="col-md-4 d-flex align-items-center pt-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="methodItalic" <?= ($layout['method_italic'] ?? true) ? 'checked' : '' ?> onchange="updatePreview()">
                                <label class="form-check-label small fw-semibold text-dark" for="methodItalic">Italicize Method Text</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab 3: Signatures & QR -->
            <div id="signatureTab" class="tab-pane-content">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div>
                        <h6 class="fw-bold mb-0 text-dark">Doctor Digital Signatures & Security Seals</h6>
                        <small class="text-muted">Configure laboratory authorizers, report verification QR code, and regulatory disclaimer notes.</small>
                    </div>
                </div>

                <!-- QR Code Block -->
                <div class="card p-3 border rounded bg-light mb-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="showQR" <?= !empty($signature_layout['show_qr']) ? 'checked' : '' ?> onchange="updatePreview()">
                            <label class="form-check-label fw-bold text-dark small" for="showQR"><i class="fas fa-qrcode text-primary me-1"></i>Show Verification QR Code Stamp</label>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-md-6">
                            <label class="form-label small text-muted mb-1">Stamp Position</label>
                            <select id="qrPosition" class="form-select form-select-sm" onchange="updatePreview()">
                                <option value="left" <?= ($signature_layout['qr_position'] ?? 'right') == 'left' ? 'selected' : '' ?>>Bottom Left</option>
                                <option value="center" <?= ($signature_layout['qr_position'] ?? 'right') == 'center' ? 'selected' : '' ?>>Bottom Center</option>
                                <option value="right" <?= ($signature_layout['qr_position'] ?? 'right') == 'right' ? 'selected' : '' ?>>Bottom Right</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted mb-1">Stamp Size</label>
                            <select id="qrSize" class="form-select form-select-sm" onchange="updatePreview()">
                                <option value="small" <?= ($signature_layout['qr_size'] ?? 'medium') == 'small' ? 'selected' : '' ?>>Compact (60x60)</option>
                                <option value="medium" <?= ($signature_layout['qr_size'] ?? 'medium') == 'medium' ? 'selected' : '' ?>>Standard (80x80)</option>
                                <option value="large" <?= ($signature_layout['qr_size'] ?? 'medium') == 'large' ? 'selected' : '' ?>>High Visibility (100x100)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Signatures List -->
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <label class="form-label small fw-bold text-muted text-uppercase mb-0">Authorized Signatory Sign-offs</label>
                    <button class="btn btn-sm btn-outline-success fw-semibold" onclick="addSignature()">
                        <i class="fas fa-plus me-1"></i> Add Signatory
                    </button>
                </div>
                <div id="signaturesListContainer" class="mb-3">
                    <?php foreach($signature_layout['signatures'] as $index => $sig): ?>
                        <div class="sortable-col-card" data-sig-index="<?= $index ?>">
                            <div class="row g-2 flex-grow-1 align-items-center">
                                <div class="col-md-4">
                                    <input type="text" class="form-control form-control-sm fw-semibold" value="<?= htmlspecialchars($sig['name']) ?>" placeholder="Name (e.g. Dr. Vance, MD)" onchange="updateSignature(<?= $index ?>, 'name', this.value)">
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control form-control-sm" value="<?= htmlspecialchars($sig['designation']) ?>" placeholder="Designation (e.g. Pathologist)" onchange="updateSignature(<?= $index ?>, 'designation', this.value)">
                                </div>
                                <div class="col-md-2">
                                    <select class="form-select form-select-sm" onchange="updateSignature(<?= $index ?>, 'type', this.value)">
                                        <option value="doctor" <?= ($sig['type'] ?? 'doctor') == 'doctor' ? 'selected' : '' ?>>Doctor</option>
                                        <option value="technician" <?= ($sig['type'] ?? 'doctor') == 'technician' ? 'selected' : '' ?>>Technician</option>
                                        <option value="reviewer" <?= ($sig['type'] ?? 'doctor') == 'reviewer' ? 'selected' : '' ?>>Reviewer</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select class="form-select form-select-sm" onchange="updateSignature(<?= $index ?>, 'position', this.value)">
                                        <option value="left" <?= ($sig['position'] ?? 'left') == 'left' ? 'selected' : '' ?>>Left</option>
                                        <option value="center" <?= ($sig['position'] ?? 'left') == 'center' ? 'selected' : '' ?>>Center</option>
                                        <option value="right" <?= ($sig['position'] ?? 'left') == 'right' ? 'selected' : '' ?>>Right</option>
                                    </select>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-link text-danger p-0 ms-2" onclick="removeSignature(<?= $index ?>)"><i class="fas fa-trash-alt"></i></button>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Footer Disclaimer & Page No -->
                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted text-uppercase mb-1">Footer Medical Disclaimer</label>
                    <textarea id="footerText" class="form-control form-control-sm" rows="2" onchange="updatePreview()" placeholder="Regulatory notice or clinic disclaimer text..."><?= htmlspecialchars($signature_layout['footer_text'] ?? '') ?></textarea>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="showPageNumber" <?= !empty($signature_layout['show_page_number']) ? 'checked' : '' ?> onchange="updatePreview()">
                    <label class="form-check-label small fw-semibold text-dark" for="showPageNumber">Include "Page X of Y" in report footer</label>
                </div>
            </div>

            <!-- Tab 4: Typography & Styling -->
            <div id="stylingTab" class="tab-pane-content">
                <h6 class="fw-bold mb-1 text-dark">Table Styling & Borders</h6>
                <small class="text-muted d-block mb-3">Refine row contrast, borders, and header backgrounds.</small>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="showBorder" <?= ($layout['show_border'] ?? true) ? 'checked' : '' ?> onchange="updatePreview()">
                            <label class="form-check-label fw-semibold text-dark small" for="showBorder">Show Outer & Column Table Borders</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="stripedRows" <?= ($layout['striped_rows'] ?? true) ? 'checked' : '' ?> onchange="updatePreview()">
                            <label class="form-check-label fw-semibold text-dark small" for="stripedRows">Alternate Zebra Striped Rows</label>
                        </div>
                    </div>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-md-6">
                        <label class="form-label small text-muted mb-1">Table Header Background</label>
                        <input type="color" id="tableHeaderBg" class="form-control form-control-sm form-control-color w-100" value="<?= $layout['header_bg'] ?? '#f1f5f9' ?>" onchange="updatePreview()">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small text-muted mb-1">Report Font Family</label>
                        <select id="reportFontFamily" class="form-select form-select-sm" onchange="updatePreview()">
                            <option value="'Plus Jakarta Sans', system-ui, sans-serif" selected>Plus Jakarta Sans (Modern Clean)</option>
                            <option value="'Segoe UI', Roboto, Helvetica, Arial, sans-serif">Segoe UI / Helvetica</option>
                            <option value="Arial, sans-serif">Arial Standard</option>
                            <option value="'Times New Roman', serif">Times New Roman (Formal)</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Bottom Save Bar -->
            <div class="border-top p-3 bg-light rounded-bottom d-flex flex-wrap align-items-center justify-content-between gap-2">
                <div class="flex-grow-1" style="max-width: 380px;">
                    <input type="text" id="changeDescription" class="form-control form-control-sm" placeholder="Change description (e.g. Added collection center & QR stamp)...">
                </div>
                <div class="d-flex align-items-center gap-2">
                    <button class="btn btn-outline-secondary btn-sm fw-semibold" onclick="resetChanges()">
                        <i class="fas fa-undo me-1"></i> Reset
                    </button>
                    <button class="btn btn-outline-primary btn-sm fw-semibold" onclick="saveAsNewVersion()">
                        <i class="fas fa-code-branch me-1"></i> Save as New Version
                    </button>
                    <button class="btn btn-success btn-sm fw-bold px-3 shadow-sm" onclick="saveTemplate()">
                        <i class="fas fa-save me-1"></i> Save Template
                    </button>
                </div>
            </div>
        <?php else: ?>
            <div class="text-center py-5 text-muted">
                <i class="fas fa-arrow-left fa-2x mb-3 text-primary opacity-50"></i>
                <h5>No Template Selected</h5>
                <p class="small">Choose a category on the left, or click <strong>+ New</strong> to initialize a modern report template.</p>
                <button class="btn btn-primary btn-sm fw-semibold" onclick="createNewTemplate()">
                    <i class="fas fa-plus me-1"></i> Create Template Now
                </button>
            </div>
        <?php endif; ?>
    </div>

    <!-- 3. RIGHT PANEL: Live Medical Report Simulator -->
    <div class="studio-panel">
        <div class="studio-panel-header">
            <span class="fw-bold text-dark"><i class="fas fa-eye text-primary me-2"></i>Live Report Simulator</span>
            <span class="badge bg-success-subtle text-success border border-success-subtle fw-semibold" style="font-size: 0.72rem;">Real-Time</span>
        </div>
        <div class="studio-panel-body p-2" style="background: #f1f5f9;">
            <div class="report-paper-simulator" id="previewReportSheet">
                <!-- Live Report Rendered Here -->
            </div>
        </div>
    </div>
</div>

<!-- Floating Toast Message Notification -->
<div id="studioToast" class="alert alert-dismissible shadow-lg fade show" role="alert">
    <span id="studioToastMsg"></span>
    <button type="button" class="btn-close" onclick="$('#studioToast').hide()"></button>
</div>

<script>
// State Variables
let currentTemplateId = <?= $template_id ?>;
let currentPatientTypeId = <?= $type_id ?>;
let headerLayout = <?= json_encode($header_layout) ?>;
let tableLayout = <?= json_encode($layout) ?>;
let signatureLayout = <?= json_encode($signature_layout) ?>;
let templateData = <?= json_encode($tpl ?: []) ?>;

// Realistic Mock Clinical Data for Live Simulation
const sampleData = {
    patient_name: "Mrs. Meenakshi Sundaram",
    patient_id: "PID-2026-8841",
    age_gender: "48 Yrs / Female",
    sample_date: "<?= date('d M Y, h:i A') ?>",
    report_date: "<?= date('d M Y, h:i A', strtotime('+2 hours')) ?>",
    referring_doctor: "Dr. K. S. Rajan, MD (Gen Med)",
    collection_center: "Central Diagnostics & Phlebotomy Unit",
    test_name: "Complete Blood Count (CBC) with Automated Differential",
    accession_number: "ACC-992014",
    lab_id: "BILL-2026-0042",
    clinic_name: "Apollo Multispeciality Health Hub",
    sample_type: "Whole Blood (EDTA Vacutainer)",
    phone: "+91 98401 23456",
    test_results: [
        { param_name: "Hemoglobin (Hb)", result: "12.8", unit: "g/dL", reference: "12.0 - 15.0", flag: "NORMAL", method: "SLS Hemoglobin Photometric Assay" },
        { param_name: "Total WBC Count", result: "11,800", unit: "cells/mcL", reference: "4,000 - 11,000", flag: "HIGH", method: "Fluorescent Flow Cytometry" },
        { param_name: "Absolute Neutrophil Count", result: "78", unit: "%", reference: "40 - 70", flag: "HIGH", method: "Cell Counting & Sizing" },
        { param_name: "Absolute Lymphocyte Count", result: "18", unit: "%", reference: "20 - 45", flag: "LOW", method: "Fluorescence Analysis" },
        { param_name: "Platelet Count", result: "2,45,000", unit: "/cumm", reference: "1,50,000 - 4,50,000", flag: "NORMAL", method: "DC Impedance Method" },
        { param_name: "Packed Cell Volume (PCV)", result: "38.2", unit: "%", reference: "36.0 - 46.0", flag: "NORMAL", method: "Calculated (RBC x MCV)" }
    ]
};

$(document).ready(function() {
    initDragAndDrop();
    updatePreview();
});

function showDesignerTab(tabId) {
    $('.designer-tab-btn').removeClass('active');
    $('.tab-pane-content').removeClass('active');
    
    $(`button[onclick="showDesignerTab('${tabId}')"]`).addClass('active');
    $(`#${tabId}`).addClass('active');
}

function initDragAndDrop() {
    // Sortable Rows
    $("#headerLayoutCanvas").sortable({
        items: ".grid-row-box",
        handle: ".col-drag-handle",
        cursor: "move",
        update: function() {
            updateHeaderLayout();
            updatePreview();
        }
    });

    // Sortable columns inside each row
    $(".row-cols-container").sortable({
        items: ".grid-col-box",
        cursor: "move",
        connectWith: ".row-cols-container",
        update: function() {
            updateHeaderLayout();
            updatePreview();
        }
    });

    // Sortable table columns
    $("#selectedColumnsList").sortable({
        handle: ".col-drag-handle",
        cursor: "move",
        update: function() {
            updateTableColumns();
            updatePreview();
        }
    });
}

function addNewRow() {
    const rowHtml = `
        <div class="grid-row-box">
            <span class="col-drag-handle me-1" title="Drag to reorder rows"><i class="fas fa-grip-vertical"></i></span>
            <div class="d-flex flex-grow-1 gap-2 row-cols-container">
            </div>
            <button type="button" class="btn btn-sm btn-outline-danger ms-1 p-1 border-0" onclick="removeRow(this)" title="Delete Row"><i class="fas fa-trash-alt"></i></button>
        </div>
    `;
    $("#headerLayoutCanvas").append(rowHtml);
    initDragAndDrop();
    updateHeaderLayout();
    updatePreview();
}

function removeRow(btn) {
    $(btn).closest(".grid-row-box").remove();
    updateHeaderLayout();
    updatePreview();
}

function addColumnToRow(fieldKey, fieldLabel) {
    let $rows = $("#headerLayoutCanvas .grid-row-box");
    if ($rows.length === 0) {
        addNewRow();
        $rows = $("#headerLayoutCanvas .grid-row-box");
    }

    const $lastRowContainer = $rows.last().find(".row-cols-container");
    const colHtml = `
        <div class="grid-col-box" data-field="${fieldKey}" style="flex: 1;">
            <div class="d-flex align-items-center gap-2">
                <span class="col-drag-handle"><i class="fas fa-bars"></i></span>
                <div>
                    <div class="fw-bold text-dark" style="font-size: 0.8rem;">${fieldLabel}</div>
                    <div class="text-muted" style="font-size: 0.68rem;">${fieldKey}</div>
                </div>
            </div>
            <button type="button" class="btn btn-sm btn-link text-danger p-0" onclick="removeColumn(this)" title="Remove"><i class="fas fa-times"></i></button>
        </div>
    `;
    $lastRowContainer.append(colHtml);
    initDragAndDrop();
    updateHeaderLayout();
    updatePreview();
}

function removeColumn(btn) {
    $(btn).closest(".grid-col-box").remove();
    updateHeaderLayout();
    updatePreview();
}

function resetStandardHeader() {
    headerLayout = {
        rows: [
            {
                type: "row",
                columns: [
                    { type: "field", field: "patient_name", label: "Patient Name", width: "50%" },
                    { type: "field", field: "patient_id", label: "Patient ID / UHID", width: "50%" }
                ]
            },
            {
                type: "row",
                columns: [
                    { type: "field", field: "age_gender", label: "Age / Gender", width: "33%" },
                    { type: "field", field: "sample_date", label: "Sample Collected", width: "33%" },
                    { type: "field", field: "report_date", label: "Report Date", width: "34%" }
                ]
            },
            {
                type: "row",
                columns: [
                    { type: "field", field: "referring_doctor", label: "Ref. Doctor", width: "50%" },
                    { type: "field", field: "collection_center", label: "Collection Centre", width: "50%" }
                ]
            }
        ]
    };
    renderHeaderCanvasFromState();
    updatePreview();
}

function renderHeaderCanvasFromState() {
    let html = '';
    if (headerLayout && headerLayout.rows) {
        headerLayout.rows.forEach((row, rIdx) => {
            html += `
                <div class="grid-row-box" data-row-index="${rIdx}">
                    <span class="col-drag-handle me-1" title="Drag to reorder rows"><i class="fas fa-grip-vertical"></i></span>
                    <div class="d-flex flex-grow-1 gap-2 row-cols-container">
            `;
            if (row.columns) {
                row.columns.forEach(col => {
                    html += `
                        <div class="grid-col-box" data-field="${col.field}" style="flex: ${col.width || '1'};">
                            <div class="d-flex align-items-center gap-2">
                                <span class="col-drag-handle"><i class="fas fa-bars"></i></span>
                                <div>
                                    <div class="fw-bold text-dark" style="font-size: 0.8rem;">${col.label}</div>
                                    <div class="text-muted" style="font-size: 0.68rem;">${col.field}</div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-link text-danger p-0" onclick="removeColumn(this)" title="Remove"><i class="fas fa-times"></i></button>
                        </div>
                    `;
                });
            }
            html += `
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-danger ms-1 p-1 border-0" onclick="removeRow(this)" title="Delete Row"><i class="fas fa-trash-alt"></i></button>
                </div>
            `;
        });
    }
    $("#headerLayoutCanvas").html(html);
    initDragAndDrop();
}

function updateHeaderLayout() {
    const rows = [];
    $("#headerLayoutCanvas .grid-row-box").each(function() {
        const columns = [];
        $(this).find(".grid-col-box").each(function() {
            const label = $(this).find(".fw-bold").text().trim();
            const field = $(this).attr("data-field");
            const width = $(this).css("flex") || "1";
            columns.push({
                type: "field",
                field: field,
                label: label,
                width: width
            });
        });
        if (columns.length > 0) {
            rows.push({ type: "row", columns: columns });
        }
    });
    headerLayout.rows = rows;
}

// Table Column Functions
function addTableColumn(key, label) {
    const exists = $("#selectedColumnsList .sortable-col-card[data-key='" + key + "']").length > 0;
    if (exists) {
        showStudioToast("Column '" + label + "' is already in the table.", "warning");
        return;
    }

    const html = `
        <div class="sortable-col-card" data-key="${key}">
            <div class="d-flex align-items-center gap-2">
                <span class="col-drag-handle"><i class="fas fa-grip-vertical"></i></span>
                <div>
                    <strong class="text-dark small">${label}</strong>
                    <div class="text-muted" style="font-size: 0.7rem;">${key}</div>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <div class="input-group input-group-sm" style="width: 110px;">
                    <span class="input-group-text p-1 text-muted" style="font-size: 0.7rem;">Width</span>
                    <input type="text" class="form-control form-control-sm text-center px-1" value="auto" onchange="updateColumnWidth(this, '${key}')" placeholder="e.g. 20%">
                </div>
                <button type="button" class="btn btn-sm btn-link text-danger p-0 ms-1" onclick="removeTableColumn(this)"><i class="fas fa-trash-alt"></i></button>
            </div>
        </div>
    `;
    $("#selectedColumnsList").append(html);
    initDragAndDrop();
    updateTableColumns();
    updatePreview();
}

function removeTableColumn(btn) {
    $(btn).closest(".sortable-col-card").remove();
    updateTableColumns();
    updatePreview();
}

function updateColumnWidth(input, key) {
    updateTableColumns();
    updatePreview();
}

function updateTableColumns() {
    const columns = [];
    $("#selectedColumnsList .sortable-col-card").each(function() {
        const key = $(this).attr("data-key");
        const label = $(this).find("strong").text().trim();
        const width = $(this).find("input").val().trim() || "auto";
        columns.push({ key: key, label: label, width: width });
    });

    tableLayout.columns = columns;
    tableLayout.method_under_test = $("#methodUnder").is(":checked");
    tableLayout.method_font_size = $("#methodFontSize").val();
    tableLayout.method_italic = $("#methodItalic").is(":checked");
    tableLayout.method_color = $("#methodColor").val();
    tableLayout.show_border = $("#showBorder").is(":checked");
    tableLayout.striped_rows = $("#stripedRows").is(":checked");
    tableLayout.header_bg = $("#tableHeaderBg").val();
    tableLayout.font_family = $("#reportFontFamily").val();
}

function toggleMethodOptions() {
    if ($("#methodUnder").is(":checked")) {
        $("#methodOptionsBox").slideDown(150);
    } else {
        $("#methodOptionsBox").slideUp(150);
    }
}

// Signature Functions
function addSignature() {
    const index = signatureLayout.signatures.length;
    signatureLayout.signatures.push({
        type: 'doctor',
        name: 'Dr. New Signatory, MD',
        designation: 'Specialist Pathologist',
        position: 'right'
    });
    renderSignaturesList();
    updatePreview();
}

function removeSignature(idx) {
    signatureLayout.signatures.splice(idx, 1);
    renderSignaturesList();
    updatePreview();
}

function updateSignature(idx, field, val) {
    if (signatureLayout.signatures[idx]) {
        signatureLayout.signatures[idx][field] = val;
        updatePreview();
    }
}

function renderSignaturesList() {
    let html = '';
    signatureLayout.signatures.forEach((sig, index) => {
        html += `
            <div class="sortable-col-card" data-sig-index="${index}">
                <div class="row g-2 flex-grow-1 align-items-center">
                    <div class="col-md-4">
                        <input type="text" class="form-control form-control-sm fw-semibold" value="${sig.name}" placeholder="Name" onchange="updateSignature(${index}, 'name', this.value)">
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control form-control-sm" value="${sig.designation}" placeholder="Designation" onchange="updateSignature(${index}, 'designation', this.value)">
                    </div>
                    <div class="col-md-2">
                        <select class="form-select form-select-sm" onchange="updateSignature(${index}, 'type', this.value)">
                            <option value="doctor" ${sig.type === 'doctor' ? 'selected' : ''}>Doctor</option>
                            <option value="technician" ${sig.type === 'technician' ? 'selected' : ''}>Technician</option>
                            <option value="reviewer" ${sig.type === 'reviewer' ? 'selected' : ''}>Reviewer</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select class="form-select form-select-sm" onchange="updateSignature(${index}, 'position', this.value)">
                            <option value="left" ${sig.position === 'left' ? 'selected' : ''}>Left</option>
                            <option value="center" ${sig.position === 'center' ? 'selected' : ''}>Center</option>
                            <option value="right" ${sig.position === 'right' ? 'selected' : ''}>Right</option>
                        </select>
                    </div>
                </div>
                <button type="button" class="btn btn-sm btn-link text-danger p-0 ms-2" onclick="removeSignature(${index})"><i class="fas fa-trash-alt"></i></button>
            </div>
        `;
    });
    $("#signaturesListContainer").html(html);
}

// Generate Live A4 Report Preview
function updatePreview() {
    updateHeaderLayout();
    updateTableColumns();

    signatureLayout.show_qr = $("#showQR").is(":checked");
    signatureLayout.qr_position = $("#qrPosition").val() || 'right';
    signatureLayout.qr_size = $("#qrSize").val() || 'medium';
    signatureLayout.footer_text = $("#footerText").val();
    signatureLayout.show_page_number = $("#showPageNumber").is(":checked");

    const html = buildSimulatorReportHtml();
    $("#previewReportSheet").html(html);
}

function buildSimulatorReportHtml() {
    const fontFamily = tableLayout.font_family || "'Plus Jakarta Sans', sans-serif";
    let h = `<div style="font-family: ${fontFamily}; color: #1e293b;">`;

    // 1. Diagnostic Lab Banner
    h += `
        <div class="preview-lab-header">
            <div style="font-size: 1.15rem; font-weight: 800; color: #0369a1; letter-spacing: -0.02em;">CENTRAL CLINICAL LABORATORY & RESEARCH</div>
            <div style="font-size: 0.75rem; color: #64748b;">NABL ACCREDITED LAB (ISO 15189:2022 CERTIFIED) • 24x7 EMERGENCY PHLEBOTOMY</div>
            <div style="font-size: 0.72rem; color: #94a3b8;">104, Medical Center Blvd, Health City • Tel: +91 44 2841 0000 • Web: report.labtech.demo</div>
        </div>
    `;

    // 2. Patient Demographics Header
    if (headerLayout && headerLayout.rows && headerLayout.rows.length > 0) {
        h += `<div class="preview-patient-grid">`;
        headerLayout.rows.forEach(r => {
            h += `<div class="preview-header-row">`;
            r.columns.forEach(col => {
                const sampleVal = sampleData[col.field] || '-';
                h += `
                    <div class="preview-header-col" style="flex: ${col.width || '1'};">
                        <span style="font-size: 0.7rem; color: #64748b; font-weight: 600; text-transform: uppercase;">${col.label}:</span>
                        <span style="font-size: 0.8rem; font-weight: 700; color: #0f172a; margin-left: 4px;">${sampleVal}</span>
                    </div>
                `;
            });
            h += `</div>`;
        });
        h += `</div>`;
    }

    // Investigation Banner
    h += `
        <div style="background: #f1f5f9; padding: 5px 10px; border-left: 3px solid #0284c7; margin-bottom: 10px; font-weight: 700; font-size: 0.82rem; color: #0369a1;">
            ${sampleData.test_name}
        </div>
    `;

    // 3. Table Results
    const borderStyle = tableLayout.show_border ? 'border: 1px solid #cbd5e1;' : 'border: none;';
    const headerBg = tableLayout.header_bg || '#f1f5f9';
    h += `<table class="preview-results-table" style="${borderStyle}">`;
    h += `<thead><tr style="background: ${headerBg};">`;
    if (tableLayout.columns) {
        tableLayout.columns.forEach(c => {
            h += `<th style="width: ${c.width};">${c.label}</th>`;
        });
    }
    h += `</tr></thead><tbody>`;

    sampleData.test_results.forEach((row, idx) => {
        const bg = (tableLayout.striped_rows && idx % 2 === 1) ? 'background: #f8fafc;' : '';
        h += `<tr style="${bg}">`;
        if (tableLayout.columns) {
            tableLayout.columns.forEach(c => {
                if (c.key === 'param_name') {
                    h += `<td>`;
                    h += `<div style="font-weight: 700; color: #0f172a;">${row.param_name}</div>`;
                    if (tableLayout.method_under_test && row.method) {
                        const mItalic = tableLayout.method_italic ? 'font-style: italic;' : '';
                        const mColor = tableLayout.method_color || '#64748b';
                        const mSize = tableLayout.method_font_size === 'smaller' ? '0.72rem' : (tableLayout.method_font_size === 'x-small' ? '0.68rem' : '0.76rem');
                        h += `<div style="font-size: ${mSize}; color: ${mColor}; ${mItalic}">Method: ${row.method}</div>`;
                    }
                    h += `</td>`;
                } else if (c.key === 'flag') {
                    if (row.flag === 'HIGH') {
                        h += `<td><span class="badge bg-danger text-white px-2 py-0" style="font-size: 0.7rem;">HIGH</span></td>`;
                    } else if (row.flag === 'LOW') {
                        h += `<td><span class="badge bg-warning text-dark px-2 py-0" style="font-size: 0.7rem;">LOW</span></td>`;
                    } else {
                        h += `<td><span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-0" style="font-size: 0.7rem;">NORMAL</span></td>`;
                    }
                } else if (c.key === 'result') {
                    const isAbnormal = (row.flag === 'HIGH' || row.flag === 'LOW');
                    const rWeight = isAbnormal ? 'font-weight: 800; color: #b91c1c;' : 'font-weight: 600;';
                    h += `<td style="${rWeight}">${row.result}</td>`;
                } else {
                    h += `<td>${row[c.key] || '-'}</td>`;
                }
            });
        }
        h += `</tr>`;
    });
    h += `</tbody></table>`;

    // 4. Report Footer, Signatures & QR Code
    h += `<div class="preview-footer-area">`;
    
    // QR Code rendering
    if (signatureLayout.show_qr) {
        const qrSize = signatureLayout.qr_size || 'medium';
        const qrFloat = signatureLayout.qr_position || 'right';
        h += `
            <div style="float: ${qrFloat}; margin: 8px 16px;">
                <div class="qr-box-sim qr-${qrSize}">
                    <i class="fas fa-qrcode fa-2x mb-1 text-dark opacity-75"></i>
                    <span>Scan to Verify</span>
                </div>
            </div>
        `;
    }

    // Signatures rendering
    h += `<div style="display: flex; justify-content: space-between; gap: 20px; margin-top: 10px;">`;
    const positions = ['left', 'center', 'right'];
    positions.forEach(pos => {
        const sigs = (signatureLayout.signatures || []).filter(s => (s.position || 'left') === pos);
        if (sigs.length > 0) {
            h += `<div style="text-align: ${pos};">`;
            sigs.forEach(s => {
                h += `
                    <div style="display: inline-block; margin: 0 10px;">
                        <div style="height: 35px; border-bottom: 1px dotted #94a3b8; width: 140px; margin: 0 auto 4px;"></div>
                        <div style="font-weight: 700; font-size: 0.78rem; color: #0f172a;">${s.name}</div>
                        <div style="font-size: 0.7rem; color: #64748b;">${s.designation}</div>
                        <span class="badge bg-secondary-subtle text-secondary" style="font-size: 0.65rem;">${s.type.toUpperCase()}</span>
                    </div>
                `;
            });
            h += `</div>`;
        }
    });
    h += `</div>`;
    h += `<div style="clear: both;"></div>`;

    // Disclaimer text
    if (signatureLayout.footer_text) {
        h += `<div style="font-size: 0.7rem; color: #64748b; text-align: center; margin-top: 18px; border-top: 1px solid #f1f5f9; padding-top: 6px;">
            ${signatureLayout.footer_text}
        </div>`;
    }

    // Page number
    if (signatureLayout.show_page_number) {
        h += `<div style="font-size: 0.68rem; color: #94a3b8; text-align: right; margin-top: 4px;">Page 1 of 1</div>`;
    }

    h += `</div></div>`;
    return h;
}

// Navigation & Actions
function changePatientType() {
    const tId = $("#patientTypeSelect").val();
    window.location.href = `?patient_type_id=${tId}`;
}

function loadTemplate(tId) {
    window.location.href = `?patient_type_id=${currentPatientTypeId}&template_id=${tId}`;
}

function createNewTemplate() {
    if (!currentPatientTypeId || currentPatientTypeId <= 0) {
        showStudioToast("Please select a patient category first.", "warning");
        return;
    }
    const name = prompt("Enter Name for the New Report Template:", "Standard Diagnostic Report");
    if (!name || !name.trim()) return;

    $.ajax({
        url: 'create_template.php',
        method: 'POST',
        data: {
            patient_type_id: currentPatientTypeId,
            template_name: name.trim(),
            layout_json: JSON.stringify(tableLayout),
            header_layout_json: JSON.stringify(headerLayout),
            signature_layout_json: JSON.stringify(signatureLayout)
        },
        success: function(resp) {
            const d = (typeof resp === 'object') ? resp : JSON.parse(resp);
            if (d.success) {
                window.location.href = `?patient_type_id=${currentPatientTypeId}&template_id=${d.template_id}`;
            } else {
                showStudioToast('Error: ' + d.message, 'danger');
            }
        },
        error: function() {
            showStudioToast('Server communication failed.', 'danger');
        }
    });
}

function duplicateTemplate() {
    if (!currentTemplateId || currentTemplateId <= 0) return;
    const currentName = templateData ? templateData.template_name : "Report Template";
    const newName = prompt("Enter Name for Cloned Template:", currentName + " - Copy");
    if (!newName || !newName.trim()) return;

    $.ajax({
        url: 'duplicate_template.php',
        method: 'POST',
        data: {
            template_id: currentTemplateId,
            new_name: newName.trim()
        },
        success: function(resp) {
            const d = (typeof resp === 'object') ? resp : JSON.parse(resp);
            if (d.success) {
                window.location.href = `?patient_type_id=${currentPatientTypeId}&template_id=${d.new_template_id}`;
            } else {
                showStudioToast('Error: ' + d.message, 'danger');
            }
        },
        error: function() {
            showStudioToast('Server communication failed.', 'danger');
        }
    });
}

function deleteCurrentTemplate(tId) {
    if (!confirm("Are you sure you want to permanently delete this report template?")) return;

    $.ajax({
        url: 'delete_template.php',
        method: 'POST',
        data: { template_id: tId },
        success: function(resp) {
            const d = (typeof resp === 'object') ? resp : JSON.parse(resp);
            if (d.success) {
                showStudioToast('Template deleted.', 'success');
                setTimeout(() => {
                    window.location.href = `?patient_type_id=${currentPatientTypeId}`;
                }, 1000);
            } else {
                showStudioToast('Error: ' + d.message, 'danger');
            }
        },
        error: function() {
            showStudioToast('Server communication failed.', 'danger');
        }
    });
}

function saveTemplate() {
    if (!currentTemplateId || currentTemplateId <= 0) {
        showStudioToast("Please select or create a template first.", "warning");
        return;
    }
    const desc = $("#changeDescription").val().trim() || "Template layout updated";

    $.ajax({
        url: 'save_template.php',
        method: 'POST',
        data: {
            template_id: currentTemplateId,
            layout_json: JSON.stringify(tableLayout),
            header_layout_json: JSON.stringify(headerLayout),
            signature_layout_json: JSON.stringify(signatureLayout),
            change_description: desc
        },
        success: function(resp) {
            const d = (typeof resp === 'object') ? resp : JSON.parse(resp);
            if (d.success) {
                showStudioToast('Template saved successfully!', 'success');
                setTimeout(() => { location.reload(); }, 1200);
            } else {
                showStudioToast('Error: ' + d.message, 'danger');
            }
        },
        error: function() {
            showStudioToast('Server communication failed.', 'danger');
        }
    });
}

function saveAsNewVersion() {
    if (!currentTemplateId || currentTemplateId <= 0) return;
    const desc = $("#changeDescription").val().trim() || "New Version";
    if (!confirm("Increment version number and save new revision?")) return;

    $.ajax({
        url: 'save_version.php',
        method: 'POST',
        data: {
            template_id: currentTemplateId,
            layout_json: JSON.stringify(tableLayout),
            header_layout_json: JSON.stringify(headerLayout),
            signature_layout_json: JSON.stringify(signatureLayout),
            change_description: desc
        },
        success: function(resp) {
            const d = (typeof resp === 'object') ? resp : JSON.parse(resp);
            if (d.success) {
                showStudioToast('New version saved successfully!', 'success');
                setTimeout(() => { location.reload(); }, 1200);
            } else {
                showStudioToast('Error: ' + d.message, 'danger');
            }
        },
        error: function() {
            showStudioToast('Server communication failed.', 'danger');
        }
    });
}

function viewVersion(versionId) {
    $.ajax({
        url: 'load_version.php',
        method: 'POST',
        data: { version_id: versionId },
        success: function(resp) {
            const d = (typeof resp === 'object') ? resp : JSON.parse(resp);
            if (d.success && d.version) {
                try {
                    headerLayout = JSON.parse(d.version.header_layout_json || '{}');
                    tableLayout = JSON.parse(d.version.layout_json || '{}');
                    signatureLayout = JSON.parse(d.version.signature_layout_json || '{}');
                    renderHeaderCanvasFromState();
                    renderSignaturesList();
                    updatePreview();
                    showStudioToast('Loaded version ' + d.version.version + '. Click Save to keep.', 'info');
                } catch(e) {
                    showStudioToast('Error parsing version JSON.', 'danger');
                }
            } else {
                showStudioToast('Failed to load version.', 'danger');
            }
        },
        error: function() {
            showStudioToast('Server communication failed.', 'danger');
        }
    });
}

function resetChanges() {
    if (confirm("Discard all unsaved changes and reload template?")) {
        location.reload();
    }
}

function showStudioToast(msg, type) {
    const $t = $("#studioToast");
    $t.removeClass('alert-success alert-danger alert-warning alert-info');
    $t.addClass('alert-' + type);
    $("#studioToastMsg").html(msg);
    $t.fadeIn(200);
    setTimeout(() => { $t.fadeOut(300); }, 3500);
}
</script>
