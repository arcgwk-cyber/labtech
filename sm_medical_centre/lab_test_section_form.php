<?php
// lab_test_section_form.php
include 'auth_check.php';
include 'db.php';

$test_id = isset($_GET['test_id']) ? (int)$_GET['test_id'] : 0;
$parameters = [];
$res = $conn->query("SELECT parameter_id, param_name FROM test_parameters ORDER BY param_name");
while ($row = $res->fetch_assoc()) {
    $parameters[] = $row;
}

$existing_sections = [];
if ($test_id > 0) {
    $stmt = $conn->prepare("SELECT param_order, parameter_id, section_name FROM lab_test_parameters WHERE test_id = ? ORDER BY param_order");
    $stmt->bind_param("i", $test_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $existing_sections[$row['section_name']][] = $row['parameter_id'];
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Section-wise Parameter Assignment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .section-box {
            border: 1px solid #ccc;
            padding: 1rem;
            margin-bottom: 1rem;
            background: #f8f9fa;
            border-radius: 5px;
        }
    </style>
</head>
<body>
<div class="container mt-4">
    <h3>Assign Sections & Parameters for Test</h3>
    <form method="post" action="save_sections.php">
        <input type="hidden" name="test_id" value="<?= htmlspecialchars($test_id) ?>">
        <div id="sections-container">
            <?php if (!empty($existing_sections)): ?>
                <?php $sectionCounter = 1; foreach ($existing_sections as $section_name => $param_ids): ?>
                    <div class='section-box'>
                        <div class='mb-3'>
                            <label>Section Name</label>
                            <input type='text' name='sections[<?= $sectionCounter ?>][name]' class='form-control' value='<?= htmlspecialchars($section_name) ?>' required>
                        </div>
                        <div class='mb-3'>
                            <label>Select Parameters</label>
                            <select name='sections[<?= $sectionCounter ?>][params][]' class='form-control param-select' multiple required>
                                <?php foreach ($parameters as $param): ?>
                                    <option value='<?= $param['parameter_id'] ?>' <?= in_array($param['parameter_id'], $param_ids) ? 'selected' : '' ?>><?= htmlspecialchars($param['param_name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type='button' class='btn btn-danger' onclick='$(this).closest(".section-box").remove()'>Remove Section</button>
                    </div>
                <?php $sectionCounter++; endforeach; ?>
            <?php endif; ?>
        </div>
        <button type="button" class="btn btn-primary mb-3" onclick="addSection()">Add Section</button>
        <button type="submit" class="btn btn-success">Save</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
let sectionCounter = <?= isset($sectionCounter) ? $sectionCounter : 1 ?>;

function addSection() {
    const sectionId = sectionCounter++;
    const sectionBox = $(
        `<div class='section-box'>
            <div class='mb-3'>
                <label>Section Name</label>
                <input type='text' name='sections[${sectionId}][name]' class='form-control' required>
            </div>
            <div class='mb-3'>
                <label>Select Parameters</label>
                <select name='sections[${sectionId}][params][]' class='form-control param-select' multiple required>
                    <?php foreach ($parameters as $param): ?>
                        <option value='<?= $param['parameter_id'] ?>'><?= htmlspecialchars($param['param_name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type='button' class='btn btn-danger' onclick='$(this).closest(".section-box").remove()'>Remove Section</button>
        </div>`
    );
    $('#sections-container').append(sectionBox);
    sectionBox.find('.param-select').select2({ width: '100%' });
}

$(document).ready(function() {
    $('.param-select').select2({ width: '100%' });
});
</script>
</body>
</html>
