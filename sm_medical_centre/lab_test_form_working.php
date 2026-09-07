<?php
include 'auth_check.php';
include 'db.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$edit = false;

if ($id > 0) {
    $edit = true;
    $stmt = $conn->prepare("SELECT * FROM lab_tests WHERE test_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $test = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    $param_ids = [];
    $res = $conn->query("SELECT parameter_id FROM lab_test_parameters WHERE test_id = $id");
    while ($row = $res->fetch_assoc()) {
        $param_ids[] = $row['parameter_id'];
    }
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

function loadParameters($selected = []) {
    global $conn;
    $html = '';
    $res = $conn->query("SELECT parameter_id, param_name FROM test_parameters ORDER BY param_name");
    while ($row = $res->fetch_assoc()) {
        $checked = in_array($row['parameter_id'], $selected) ? 'checked' : '';
        $html .= "<div class='form-check'>
                    <input class='form-check-input' type='checkbox' name='parameters[]' value='{$row['parameter_id']}' id='param{$row['parameter_id']}' $checked>
                    <label class='form-check-label' for='param{$row['parameter_id']}'>{$row['param_name']}</label>
                  </div>";
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
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <style>
        .parameter-container {
            border: 1px solid #ccc;
            padding: 1rem;
            max-height: 250px;
            overflow-y: scroll;
            background: #f8f9fa;
            border-radius: 5px;
        }
    </style>
</head>
<body>
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><?= $edit ? 'Edit Test' : 'Add New Test' ?></h4>
        </div>
        <div class="card-body">
            <form method="post" action="lab_test_save.php">
                <input type="hidden" name="test_id" value="<?= $test['test_id'] ?? '' ?>">

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
                    <label class="form-label">Select Parameters</label>
                    <div class="parameter-container">
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-2">
        <?php
        $res = $conn->query("SELECT parameter_id, param_name FROM test_parameters ORDER BY param_name");
        while ($row = $res->fetch_assoc()) {
            $checked = in_array($row['parameter_id'], $param_ids ?? []) ? 'checked' : '';
            echo "<div class='col'>
                    <div class='form-check'>
                        <input class='form-check-input' type='checkbox' name='parameters[]' value='{$row['parameter_id']}' id='param{$row['parameter_id']}' $checked>
                        <label class='form-check-label' for='param{$row['parameter_id']}'>{$row['param_name']}</label>
                    </div>
                  </div>";
        }
        ?>
    </div>
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

                <div class="text-end">
                    <button type="submit" class="btn btn-success">Save</button>
                    <a href="lab_test_list.php" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    ClassicEditor.create(document.querySelector('#notes')).catch(error => console.error(error));
    ClassicEditor.create(document.querySelector('#interpretations')).catch(error => console.error(error));
</script>
</body>
</html>
