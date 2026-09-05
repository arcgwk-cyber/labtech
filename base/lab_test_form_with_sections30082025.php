<?php
include 'auth_check.php';
include 'db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$edit = false;
$test = [];
$parameters = [];
$res = $conn->query("SELECT parameter_id, param_name FROM test_parameters ORDER BY parameter_id ASC");
while ($row = $res->fetch_assoc()) {
    $parameters[] = $row;
}

$existing_sections = [];
if ($id > 0) {
    $edit = true;
    $stmt = $conn->prepare("SELECT * FROM lab_tests WHERE test_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $test = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    $stmt = $conn->prepare("SELECT param_order, parameter_id, section_name FROM lab_test_parameters WHERE test_id = ? ORDER BY param_order");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $existing_sections[$row['section_name']][] = $row['parameter_id'];
    }
    $stmt->close();
}

function loadCategories($selected = null) {
    global $conn;
    $html = '';
    $res = $conn->query("SELECT * FROM test_categories");
    while ($row = $res->fetch_assoc()) {
        $sel = ($selected == $row['category_id']) ? 'selected' : '';
        $html .= "<option value='{$row['category_id']}' $sel>{$row['category_name']}</option>";
    }
    return $html;
}

function loadGroups($selected = null) {
    global $conn;
    $html = '';
    $res = $conn->query("SELECT * FROM test_groups");
    while ($row = $res->fetch_assoc()) {
        $sel = ($selected == $row['group_id']) ? 'selected' : '';
        $html .= "<option value='{$row['group_id']}' $sel>{$row['group_name']}</option>";
    }
    return $html;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $edit ? 'Edit' : 'Add' ?> Lab Test</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"/>
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <style>
        .section-box {
            border: 1px solid #ccc;
            padding: 1rem;
            margin-bottom: 1rem;
            background: #f8f9fa;
            border-radius: 5px;
        }
        .sortable-params {
            list-style: none;
            padding-left: 0;
        }
        .sortable-params li {
            padding: 8px;
            background: #fff;
            border: 1px solid #ddd;
            margin-bottom: 4px;
            cursor: move;
        }
    </style>
</head>
<body>
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Add New Test with Section-wise Parameter Selection</h4>
        </div>
        <div class="card-body">
            <form method="post" action="lab_test_save_with_sections.php">
                <input type="hidden" name="test_id" value="<?= htmlspecialchars($id) ?>">

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Test Name</label>
                        <input type="text" name="test_name" class="form-control" value="<?= htmlspecialchars($test['test_name'] ?? '') ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Test Code</label>
                        <input type="text" name="test_code" class="form-control" value="<?= htmlspecialchars($test['test_code'] ?? '') ?>">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Category</label>
                        <select name="category_id" class="form-control" required>
                            <?= loadCategories($test['category_id'] ?? null) ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Group</label>
                        <select name="group_id" class="form-control">
                            <option value="">None</option>
                            <?= loadGroups($test['group_id'] ?? null) ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Price</label>
                        <input type="number" step="0.01" name="price" class="form-control" value="<?= $test['price'] ?? '0.00' ?>">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Notes (Rich Text)</label>
                    <textarea name="notes" id="notes" class="form-control"><?= htmlspecialchars($test['notes'] ?? '') ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Interpretations (Rich Text)</label>
                    <textarea name="interpretations" id="interpretations" class="form-control"><?= htmlspecialchars($test['interpretations'] ?? '') ?></textarea>
                </div>
                <!--Image sections--->
                
<div class="row mb-3">
    <div class="col-md-6">
        <label class="form-label">Signature</label>
        <select name="signature_id" id="signature_id" class="form-control" onchange="previewImage(this,'sig_preview')">
            <option value="">-- Select Signature --</option>
            <?php
            $res = $conn->query("SELECT id, name, signimage FROM sign_master WHERE signimage<>''");
            while($row = $res->fetch_assoc()):
                $selected = ($test['signature_id'] == $row['id']) ? 'selected' : '';
                $file = 'sign_stamp/'.$row['signimage'];
            ?>
                <option value="<?= $row['id'] ?>" <?= $selected ?> data-file="<?= $file ?>"><?= htmlspecialchars($row['name']) ?></option>
            <?php endwhile; ?>
        </select>
        <div class="mt-2">
            <?php
            $sigPreview = '';
            if(!empty($test['signature_id'])){
                $sigRes = $conn->query("SELECT signimage FROM sign_master WHERE id=".$test['signature_id']);
                if($sigRow = $sigRes->fetch_assoc()) $sigPreview = 'sign_stamp/'.$sigRow['signimage'];
            }
            ?>
            <img id="sig_preview" src="<?= htmlspecialchars($sigPreview) ?>" style="max-height:80px;">
        </div>
    </div>

    <div class="col-md-6">
        <label class="form-label">Stamp</label>
        <select name="stamp_id" id="stamp_id" class="form-control" onchange="previewImage(this,'stamp_preview')">
            <option value="">-- Select Stamp --</option>
            <?php
            $res = $conn->query("SELECT id, name, stampimage FROM sign_master WHERE stampimage<>''");
            while($row = $res->fetch_assoc()):
                $selected = ($test['stamp_id'] == $row['id']) ? 'selected' : '';
                $file = 'sign_stamp/'.$row['stampimage'];
            ?>
                <option value="<?= $row['id'] ?>" <?= $selected ?> data-file="<?= $file ?>"><?= htmlspecialchars($row['name']) ?></option>
            <?php endwhile; ?>
        </select>
        <div class="mt-2">
            <?php
            $stampPreview = '';
            if(!empty($test['stamp_id'])){
                $stampRes = $conn->query("SELECT stampimage FROM sign_master WHERE id=".$test['stamp_id']);
                if($stampRow = $stampRes->fetch_assoc()) $stampPreview = 'sign_stamp/'.$stampRow['stampimage'];
            }
            ?>
            <img id="stamp_preview" src="<?= htmlspecialchars($stampPreview) ?>" style="max-height:80px;">
        </div>
    </div>
</div>

<script>
function previewImage(selectEl, imgId){
    const selected = selectEl.options[selectEl.selectedIndex];
    const file = selected.getAttribute('data-file') || '';
    document.getElementById(imgId).src = file;
}
</script>


                <h5 class="mt-4">Assign Sections & Parameters</h5>
                <div id="sections-container"></div>
                
                

               <div class="d-flex align-items-center gap-2 mb-3">
  <button type="button" class="btn btn-primary" onclick="addSection()">Add Section</button>
  <button type="submit" class="btn btn-success">Save Test</button>
  <a href="lab_test_list.php" class="btn btn-secondary">Cancel</a>
</div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>



<script>
const allParameters = <?= json_encode($parameters) ?>;
const existingSections = <?= json_encode($existing_sections) ?>;
let sectionCounter = 1;


// ... include addSection() here

function addSection(sectionName = '', selectedParams = []) {
    const sectionId = sectionCounter++;
    const sectionBox = $(`
        <div class='section-box'>
            <div class='mb-3'>
                <label>Section Name (optional)</label>
                <input type='text' name='sections[${sectionId}][name]' class='form-control' required value="${sectionName}">
            </div>
            <div class='mb-3'>
                <label>Select Parameters to Add</label>
                <select class='param-select form-control' multiple></select>
            </div>
            <div class='mb-3'>
                <label>Selected Parameters (Drag to reorder)</label>
                <ul class='sortable-params'></ul>
            </div>
            <button type='button' class='btn btn-danger' onclick='$(this).closest(".section-box").remove()'>Remove Section</button>
        </div>
    `);

    const select = sectionBox.find('.param-select');
    allParameters.forEach(param => {
        const option = $('<option>')
            .val(param.parameter_id)
            .text(param.param_name)
            .prop('disabled', selectedParams.includes(param.parameter_id));
        select.append(option);
    });

    select.select2({ width: '100%' });

    // Handle selection from dropdown
    select.on('select2:select', function(e) {
        const id = e.params.data.id;
        const text = e.params.data.text;

        sectionBox.find('.sortable-params').append(`
            <li>
                <input type='hidden' name='sections[${sectionId}][params][]' value='${id}'>
                ${text}
                <button type='button' class='btn btn-sm btn-danger float-end' onclick='$(this).parent().remove()'>Remove</button>
            </li>
        `);

        $(this).find(`option[value='${id}']`).prop('disabled', true);
        $(this).val(null).trigger('change');
    });

    // Preload selected parameters
    const sortable = sectionBox.find('.sortable-params');
    selectedParams.forEach(paramId => {
        const param = allParameters.find(p => p.parameter_id == paramId);
        if (param) {
            sortable.append(`
                <li>
                    <input type='hidden' name='sections[${sectionId}][params][]' value='${param.parameter_id}'>
                    ${param.param_name}
                    <button type='button' class='btn btn-sm btn-danger float-end' onclick='$(this).parent().remove()'>Remove</button>
                </li>
            `);
        }
    });

    sortable.sortable();
    $('#sections-container').append(sectionBox);
}


$(document).ready(function () {
    if (Object.keys(existingSections).length > 0) {
        for (const [sectionName, paramIds] of Object.entries(existingSections)) {
            addSection(sectionName, paramIds);
        }
    }
});
</script>
<script>
    ClassicEditor.create(document.querySelector('#notes')).catch(error => console.error(error));
    ClassicEditor.create(document.querySelector('#interpretations')).catch(error => console.error(error));
</script>
</body>
</html>
