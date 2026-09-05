<?php
require_once("db.php");

$template_id = $_GET['template_id'] ?? 0;
$action = $_GET['action'] ?? 'edit';

if($template_id <= 0) {
    die("Template ID required");
}

// Load template
$stmt = $conn->prepare("SELECT * FROM report_templates WHERE template_id = ?");
$stmt->bind_param("i", $template_id);
$stmt->execute();
$result = $stmt->get_result();
$template = $result->fetch_assoc();
$stmt->close();

if(!$template) {
    die("Template not found");
}

$layout = json_decode($template['layout_json'] ?? '{}', true);
$is_hardcoded_format = $template['is_hardcoded_format'] ?? false;

// Load available patient fields
$patient_fields = [];
$stmt = $conn->prepare("SELECT field_id, field_name, field_type FROM patient_type_fields ORDER BY field_order");
$stmt->execute();
$result = $stmt->get_result();
while($row = $result->fetch_assoc()) {
    $patient_fields[] = $row;
}
$stmt->close();

// Load extra fields
$extra_fields = [];
$stmt = $conn->prepare("
    SELECT DISTINCT f.field_id, f.field_label, f.field_type 
    FROM patient_type_fields f
    WHERE f.field_type IN ('text', 'textarea', 'select', 'date', 'number')
    ORDER BY f.field_order
");
$stmt->execute();
$result = $stmt->get_result();
while($row = $result->fetch_assoc()) {
    $extra_fields[] = $row;
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enhanced Template Designer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .designer-container {
            display: grid;
            grid-template-columns: 300px 1fr 350px;
            gap: 20px;
            height: 100vh;
            padding: 20px;
            background: #f5f7fa;
        }
        
        .sidebar {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow-y: auto;
        }
        
        .designer-area {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow-y: auto;
        }
        
        .preview-area {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow-y: auto;
        }
        
        .field-palette {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }
        
        .field-item {
            padding: 10px;
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            margin-bottom: 8px;
            cursor: move;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .field-item:hover {
            border-color: #0d6efd;
            background: #f0f7ff;
        }
        
        .design-area {
            min-height: 400px;
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            background: #f8f9fa;
        }
        
        .page-container {
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        
        .page-header {
            background: #e3f2fd;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 15px;
        }
        
        .row-container {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
            padding: 15px;
            border: 2px dashed #e0e0e0;
            border-radius: 6px;
            min-height: 80px;
        }
        
        .column-item {
            flex: 1;
            padding: 10px;
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            position: relative;
        }
        
        .column-item:hover {
            border-color: #0d6efd;
        }
        
        .remove-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            background: #dc3545;
            color: white;
            border: none;
            width: 20px;
            height: 20px;
            border-radius: 3px;
            font-size: 12px;
            cursor: pointer;
        }
        
        .field-label {
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }
        
        .field-value {
            color: #666;
            font-size: 14px;
        }
        
        .tab-buttons {
            display: flex;
            gap: 5px;
            margin-bottom: 20px;
            border-bottom: 1px solid #dee2e6;
        }
        
        .tab-button {
            padding: 10px 20px;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-bottom: none;
            border-radius: 6px 6px 0 0;
            cursor: pointer;
        }
        
        .tab-button.active {
            background: white;
            border-color: #0d6efd;
            color: #0d6efd;
            font-weight: bold;
        }
        
        .tab-content {
            display: none;
        }
        
        .tab-content.active {
            display: block;
        }
        
        .add-page-btn {
            width: 100%;
            padding: 10px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 6px;
            margin-bottom: 15px;
            cursor: pointer;
        }
        
        .add-row-btn {
            width: 100%;
            padding: 8px;
            background: #17a2b8;
            color: white;
            border: none;
            border-radius: 4px;
            margin-top: 10px;
            cursor: pointer;
        }
        
        .preview-report {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 20px;
            min-height: 500px;
            background: white;
        }
    </style>
</head>
<body>
    <div class="designer-container">
        <!-- Left Sidebar - Fields Palette -->
        <div class="sidebar">
            <h4><i class="fas fa-th-large me-2"></i>Fields Palette</h4>
            
            <div class="field-palette">
                <h6>Patient Information</h6>
                <div class="field-item" data-type="field" data-field="patient_name">
                    <i class="fas fa-user"></i>
                    <span>Patient Name</span>
                </div>
                <div class="field-item" data-type="field" data-field="patient_id">
                    <i class="fas fa-id-card"></i>
                    <span>Patient ID</span>
                </div>
                <div class="field-item" data-type="field" data-field="age_gender">
                    <i class="fas fa-user-friends"></i>
                    <span>Age/Gender</span>
                </div>
                <div class="field-item" data-type="field" data-field="bill_id">
                    <i class="fas fa-file-invoice"></i>
                    <span>Bill Number</span>
                </div>
                <div class="field-item" data-type="field" data-field="bill_date">
                    <i class="fas fa-calendar"></i>
                    <span>Bill Date</span>
                </div>
                <div class="field-item" data-type="field" data-field="dr_ref">
                    <i class="fas fa-user-md"></i>
                    <span>Referring Doctor</span>
                </div>
                <div class="field-item" data-type="field" data-field="report_date">
                    <i class="fas fa-clock"></i>
                    <span>Report Date</span>
                </div>
            </div>
            
            <div class="field-palette">
                <h6>Extra Fields</h6>
                <?php foreach($extra_fields as $field): ?>
                <div class="field-item" data-type="extra" data-field="<?= $field['field_id'] ?>" data-label="<?= htmlspecialchars($field['field_label']) ?>">
                    <i class="fas fa-plus-circle"></i>
                    <span><?= htmlspecialchars($field['field_label']) ?></span>
                    <small class="text-muted">(<?= $field['field_type'] ?>)</small>
                </div>
                <?php endforeach; ?>
            </div>
            
            <div class="field-palette">
                <h6>Table Columns</h6>
                <div class="field-item" data-type="column" data-field="param_name">
                    <i class="fas fa-list"></i>
                    <span>Test Description</span>
                </div>
                <div class="field-item" data-type="column" data-field="result">
                    <i class="fas fa-flask"></i>
                    <span>Result</span>
                </div>
                <div class="field-item" data-type="column" data-field="unit">
                    <i class="fas fa-ruler"></i>
                    <span>Unit</span>
                </div>
                <div class="field-item" data-type="column" data-field="reference">
                    <i class="fas fa-chart-bar"></i>
                    <span>Reference Range</span>
                </div>
                <div class="field-item" data-type="column" data-field="flag">
                    <i class="fas fa-flag"></i>
                    <span>Flag</span>
                </div>
                <div class="field-item" data-type="column" data-field="method">
                    <i class="fas fa-cogs"></i>
                    <span>Method</span>
                </div>
            </div>
        </div>
        
        <!-- Center - Designer Area -->
        <div class="designer-area">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4><i class="fas fa-edit me-2"></i>Template Designer</h4>
                <div>
                    <button class="btn btn-primary me-2" onclick="saveTemplate()">
                        <i class="fas fa-save me-2"></i>Save Template
                    </button>
                    <button class="btn btn-success" onclick="previewTemplate()">
                        <i class="fas fa-eye me-2"></i>Preview
                    </button>
                </div>
            </div>
            
            <div class="tab-buttons">
                <button class="tab-button active" onclick="showTab('header')">Header Layout</button>
                <button class="tab-button" onclick="showTab('pages')">Page Layout</button>
                <button class="tab-button" onclick="showTab('table')">Table Design</button>
                <button class="tab-button" onclick="showTab('signature')">Signature & Footer</button>
            </div>
            
            <!-- Header Tab -->
            <div id="headerTab" class="tab-content active">
                <div class="design-area" id="headerDesignArea">
                    <h6>Drag fields to design header layout</h6>
                    <div id="headerRows">
                        <!-- Header rows will be added here -->
                    </div>
                    <button class="add-row-btn" onclick="addHeaderRow()">
                        <i class="fas fa-plus me-2"></i>Add Row
                    </button>
                </div>
            </div>
            
            <!-- Pages Tab -->
            <div id="pagesTab" class="tab-content">
                <button class="add-page-btn" onclick="addNewPage()">
                    <i class="fas fa-plus me-2"></i>Add New Page
                </button>
                <div id="pagesContainer">
                    <!-- Pages will be added here -->
                </div>
            </div>
            
            <!-- Table Tab -->
            <div id="tableTab" class="tab-content">
                <div class="mb-3">
                    <h6>Table Columns</h6>
                    <div id="tableColumns" class="row-container">
                        <!-- Table columns will be added here -->
                    </div>
                    <p class="text-muted">Drag columns to reorder</p>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-check mb-3">
                            <input type="checkbox" id="showMethod" class="form-check-input">
                            <label class="form-check-label" for="showMethod">Show Method Column</label>
                        </div>
                        <div class="form-check mb-3">
                            <input type="checkbox" id="showBorder" class="form-check-input" checked>
                            <label class="form-check-label" for="showBorder">Show Table Borders</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check mb-3">
                            <input type="checkbox" id="stripedRows" class="form-check-input" checked>
                            <label class="form-check-label" for="stripedRows">Striped Rows</label>
                        </div>
                        <div class="form-check mb-3">
                            <input type="checkbox" id="highlightAbnormal" class="form-check-input" checked>
                            <label class="form-check-label" for="highlightAbnormal">Highlight Abnormal Results</label>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Signature Tab -->
            <div id="signatureTab" class="tab-content">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">QR Code Position</label>
                            <select id="qrPosition" class="form-select">
                                <option value="left">Left</option>
                                <option value="right" selected>Right</option>
                                <option value="center">Center</option>
                                <option value="none">Don't Show</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Signature Position</label>
                            <select id="signaturePosition" class="form-select">
                                <option value="right" selected>Right</option>
                                <option value="left">Left</option>
                                <option value="center">Center</option>
                                <option value="both">Both Sides</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Footer Text</label>
                            <textarea id="footerText" class="form-control" rows="3">This is a computer generated report.</textarea>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" id="showPageNumbers" class="form-check-input" checked>
                            <label class="form-check-label" for="showPageNumbers">Show Page Numbers</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right - Preview Area -->
        <div class="preview-area">
            <h4><i class="fas fa-eye me-2"></i>Live Preview</h4>
            <div id="previewReport" class="preview-report">
                <!-- Preview will be generated here -->
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    // Global variables
    let templateId = <?= $template_id ?>;
    let currentLayout = <?= json_encode($layout) ?>;
    let pages = [];
    let headerRows = [];
    let tableColumns = [];
    
    // Initialize
    $(document).ready(function() {
        initializeDesigner();
        loadTemplateData();
        updatePreview();
    });
    
    function initializeDesigner() {
        // Make fields draggable
        $(".field-item").draggable({
            helper: 'clone',
            revert: 'invalid',
            cursor: 'move'
        });
        
        // Make design areas droppable
        $("#headerDesignArea").droppable({
            accept: ".field-item[data-type='field'], .field-item[data-type='extra']",
            drop: function(event, ui) {
                const type = ui.draggable.data('type');
                const field = ui.draggable.data('field');
                const label = ui.draggable.find('span').text();
                addFieldToHeader(field, label, type);
            }
        });
        
        // Make table columns droppable
        $("#tableColumns").droppable({
            accept: ".field-item[data-type='column']",
            drop: function(event, ui) {
                const field = ui.draggable.data('field');
                const label = ui.draggable.find('span').text();
                addTableColumn(field, label);
            }
        });
        
        // Make table columns sortable
        $("#tableColumns").sortable({
            placeholder: "ui-state-highlight",
            update: function(event, ui) {
                updateTableColumnsOrder();
            }
        });
        
        $("#tableColumns").disableSelection();
    }
    
    function showTab(tabName) {
        $('.tab-button').removeClass('active');
        $('.tab-content').removeClass('active');
        
        $(`button[onclick="showTab('${tabName}')"]`).addClass('active');
        $(`#${tabName}Tab`).addClass('active');
    }
    
    function addHeaderRow() {
        const rowIndex = headerRows.length;
        const rowHtml = `
            <div class="row-container" data-row-index="${rowIndex}">
                <div style="flex: 1; text-align: center; padding: 20px; color: #999;">
                    Drop fields here
                </div>
            </div>
        `;
        $("#headerRows").append(rowHtml);
        
        // Make new row droppable
        $(`[data-row-index="${rowIndex}"]`).droppable({
            accept: ".field-item[data-type='field'], .field-item[data-type='extra']",
            drop: function(event, ui) {
                const type = ui.draggable.data('type');
                const field = ui.draggable.data('field');
                const label = ui.draggable.find('span').text();
                addFieldToRow(rowIndex, field, label, type);
            }
        });
    }
    
    function addFieldToHeader(field, label, type) {
        // Add to last row or create new one
        if(headerRows.length === 0) {
            addHeaderRow();
        }
        addFieldToRow(headerRows.length - 1, field, label, type);
    }
    
    function addFieldToRow(rowIndex, field, label, type) {
        const rowDiv = $(`[data-row-index="${rowIndex}"]`);
        const fieldHtml = `
            <div class="column-item" data-field="${field}" data-type="${type}">
                <button class="remove-btn" onclick="removeField(this)">×</button>
                <div class="field-label">${label}</div>
                <div class="field-value">[${field}]</div>
            </div>
        `;
        rowDiv.append(fieldHtml);
        updateHeaderLayout();
    }
    
    function removeField(button) {
        $(button).closest('.column-item').remove();
        updateHeaderLayout();
    }
    
    function updateHeaderLayout() {
        headerRows = [];
        $("#headerRows .row-container").each(function() {
            const columns = [];
            $(this).find('.column-item').each(function() {
                const field = $(this).data('field');
                const type = $(this).data('type');
                const label = $(this).find('.field-label').text();
                columns.push({ field, type, label });
            });
            if(columns.length > 0) {
                headerRows.push({ columns });
            }
        });
        updatePreview();
    }
    
    function addTableColumn(field, label) {
        const colHtml = `
            <div class="column-item" data-field="${field}">
                <button class="remove-btn" onclick="removeTableColumn(this)">×</button>
                <div class="field-label">${label}</div>
                <div class="field-value">(${field})</div>
            </div>
        `;
        $("#tableColumns").append(colHtml);
        updateTableColumns();
    }
    
    function removeTableColumn(button) {
        $(button).closest('.column-item').remove();
        updateTableColumns();
    }
    
    function updateTableColumns() {
        tableColumns = [];
        $("#tableColumns .column-item").each(function() {
            const field = $(this).data('field');
            const label = $(this).find('.field-label').text();
            tableColumns.push({ field, label });
        });
        updatePreview();
    }
    
    function updateTableColumnsOrder() {
        // This is handled by sortable update
        updateTableColumns();
    }
    
    function addNewPage() {
        const pageIndex = pages.length + 1;
        const pageHtml = `
            <div class="page-container" data-page="${pageIndex}">
                <div class="page-header">
                    <h6>Page ${pageIndex}</h6>
                    <small class="text-muted">Drag fields to design page layout</small>
                </div>
                <div class="design-area" id="pageDesign${pageIndex}">
                    <div class="row-container" data-row="0">
                        <div style="flex: 1; text-align: center; padding: 20px; color: #999;">
                            Drop fields here
                        </div>
                    </div>
                </div>
                <button class="add-row-btn" onclick="addPageRow(${pageIndex})">
                    <i class="fas fa-plus me-2"></i>Add Row to Page ${pageIndex}
                </button>
            </div>
        `;
        $("#pagesContainer").append(pageHtml);
    }
    
    function addPageRow(pageIndex) {
        // Implementation for adding rows to pages
    }
    
    function loadTemplateData() {
        if(currentLayout.header_layout && currentLayout.header_layout.rows) {
            // Load header layout
            currentLayout.header_layout.rows.forEach(row => {
                addHeaderRow();
                // Add fields to row
                // This would need more complex implementation
            });
        }
        
        if(currentLayout.columns) {
            // Load table columns
            currentLayout.columns.forEach(col => {
                addTableColumn(col.key, col.label);
            });
        }
    }
    
    function saveTemplate() {
        const layout = {
            header_layout: {
                rows: headerRows
            },
            table_layout: {
                columns: tableColumns,
                show_method: $("#showMethod").is(":checked"),
                show_border: $("#showBorder").is(":checked"),
                striped_rows: $("#stripedRows").is(":checked"),
                highlight_abnormal: $("#highlightAbnormal").is(":checked")
            },
            signature_layout: {
                qr_position: $("#qrPosition").val(),
                signature_position: $("#signaturePosition").val(),
                footer_text: $("#footerText").val(),
                show_page_numbers: $("#showPageNumbers").is(":checked")
            },
            pages: pages
        };
        
        fetch('save_template_design.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                template_id: templateId,
                layout_json: JSON.stringify(layout)
            })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                alert('Template saved successfully!');
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            alert('Error: ' + error.message);
        });
    }
    
    function previewTemplate() {
        // Generate preview HTML based on current design
        let previewHTML = '<div class="preview-report">';
        
        // Header preview
        previewHTML += '<div style="border-bottom: 2px solid #007bff; margin-bottom: 20px; padding-bottom: 10px;">';
        previewHTML += '<h5>Report Header Preview</h5>';
        
        headerRows.forEach(row => {
            previewHTML += '<div style="display: flex; gap: 20px; margin-bottom: 10px;">';
            row.columns.forEach(col => {
                previewHTML += `<div style="flex: 1;">
                    <strong>${col.label}:</strong>
                    <span style="color: #666;">Sample ${col.field} Data</span>
                </div>`;
            });
            previewHTML += '</div>';
        });
        
        previewHTML += '</div>';
        
        // Table preview
        previewHTML += '<div style="margin-bottom: 20px;">';
        previewHTML += '<h5>Table Preview</h5>';
        previewHTML += '<table style="width: 100%; border-collapse: collapse; border: 1px solid #ddd;">';
        previewHTML += '<thead><tr style="background: #f8f9fa;">';
        
        tableColumns.forEach(col => {
            previewHTML += `<th style="padding: 8px; border: 1px solid #ddd;">${col.label}</th>`;
        });
        
        previewHTML += '</tr></thead>';
        previewHTML += '<tbody>';
        previewHTML += '<tr>';
        tableColumns.forEach(col => {
            previewHTML += `<td style="padding: 8px; border: 1px solid #ddd;">Sample ${col.field}</td>`;
        });
        previewHTML += '</tr>';
        previewHTML += '</tbody></table></div>';
        
        // Signature preview
        previewHTML += '<div style="margin-top: 40px; padding-top: 20px; border-top: 1px solid #ddd;">';
        previewHTML += '<div style="text-align: center; color: #666;">';
        previewHTML += $('#footerText').val();
        previewHTML += '</div></div>';
        
        previewHTML += '</div>';
        
        $("#previewReport").html(previewHTML);
    }
    
    function updatePreview() {
        // Simplified preview update
        previewTemplate();
    }
    </script>
</body>
</html>