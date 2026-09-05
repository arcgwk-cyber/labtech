<?php
include 'auth_check.php';
include 'db.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$edit = false;
$param_ids = [];
$param_orders = [];

if ($id > 0) {
    $edit = true;
    $stmt = $conn->prepare("SELECT * FROM lab_tests WHERE test_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $test = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    $res = $conn->query("SELECT parameter_id, param_order FROM lab_test_parameters WHERE test_id = $id ORDER BY param_order");
    while ($row = $res->fetch_assoc()) {
        $param_ids[] = $row['parameter_id'];
        $param_orders[$row['parameter_id']] = $row['param_order'];
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
                                $pid = $row['parameter_id'];
                                $checked = in_array($pid, $param_ids) ? 'checked' : '';
                                $orderVal = $param_orders[$pid] ?? '';
                                echo "<div class='col'>
        <div class='form-check'>
            <input class='form-check-input param-checkbox' type='checkbox' data-param-id='{$pid}' id='param{$pid}' $checked>
            <label class='form-check-label' for='param{$pid}'>{$row['param_name']}</label>
            <input type='hidden' name='param_order[{$pid}]' value='{$orderVal}' class='param-order' id='order{$pid}'>";
if ($checked) {
    $stmt_sec = $conn->prepare("SELECT section_name FROM lab_test_parameters WHERE test_id = ? AND parameter_id = ?");
    $stmt_sec->bind_param("ii", $id, $pid);
    $stmt_sec->execute();
    $stmt_sec->bind_result($section_name);
    $stmt_sec->fetch();
    $stmt_sec->close();
} else {
    $section_name = '';
}
echo "<input type='text' name='section_name[{$pid}]' value=\"".htmlspecialchars($section_name)."\" placeholder='sub group' class='form-control mt-1'>";
echo "</div></div>";
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

    let orderCounter = 1;
    const selectedParams = {};

    document.querySelectorAll('.param-checkbox').forEach(cb => {
        cb.addEventListener('change', function () {
            const paramId = this.getAttribute('data-param-id');
            const orderInput = document.getElementById('order' + paramId);

            if (this.checked) {
                if (!selectedParams[paramId]) {
                    selectedParams[paramId] = orderCounter++;
                    orderInput.value = selectedParams[paramId];
                }
            } else {
                delete selectedParams[paramId];
                orderInput.value = '';

                // Reassign orders
                orderCounter = 1;
                const updated = {};
                document.querySelectorAll('.param-checkbox:checked').forEach(cb => {
                    const id = cb.getAttribute('data-param-id');
                    updated[id] = orderCounter++;
                    document.getElementById('order' + id).value = updated[id];
                });
                Object.assign(selectedParams, updated);
            }
        });

        if (cb.checked) {
            cb.dispatchEvent(new Event('change'));
        }
    });
</script>
</body>
</html>
