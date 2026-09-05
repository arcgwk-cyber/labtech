<?php
require_once 'db.php';

// Insert
if (isset($_POST['add'])) {
    $conn->begin_transaction();

    try {
        // Insert into test_parameters
        $stmt = $conn->prepare("INSERT INTO test_parameters (param_name, category_id, group_id, unit, method, interpretation, notes) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("siissss",
            $_POST['param_name'], $_POST['category_id'], $_POST['group_id'],
            $_POST['unit'], $_POST['method'], $_POST['interpretation'], $_POST['notes']
        );
        $stmt->execute();
        $parameter_id = $stmt->insert_id;
        $stmt->close();

        // Insert 3 reference ranges
        $ranges = [
            ['male', 'adult', $_POST['min_m'], $_POST['max_m'], $_POST['default_val']],
            ['female', 'adult', $_POST['min_f'], $_POST['max_f'], $_POST['default_val']],
            ['any', 'child', $_POST['min_c'], $_POST['max_c'], $_POST['default_val']],
        ];

        $stmt = $conn->prepare("INSERT INTO parameter_reference_ranges (parameter_id, gender, age_group, min_range, max_range, default_value) VALUES (?, ?, ?, ?, ?, ?)");
        foreach ($ranges as $r) {
            $stmt->bind_param("issdds", $parameter_id, $r[0], $r[1], $r[2], $r[3], $r[4]);
            $stmt->execute();
        }
        $stmt->close();

        $conn->commit();
        header("Location: test_parameters.php");
        exit;
    } catch (Exception $e) {
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }
}

// Delete parameter
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM parameter_reference_ranges WHERE parameter_id = $id");
    $conn->query("DELETE FROM test_parameters WHERE parameter_id = $id");
    header("Location: test_parameters.php");
    exit;
}

// Fetch options
$categories = $conn->query("SELECT * FROM test_categories");
$groups = $conn->query("SELECT * FROM test_groups");

// Fetch parameters with ranges
$params = $conn->query("
    SELECT tp.*, c.category_name, g.group_name 
    FROM test_parameters tp
    LEFT JOIN test_categories c ON tp.category_id = c.category_id
    LEFT JOIN test_groups g ON tp.group_id = g.group_id
");
?>

<!-- HTML + Bootstrap -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Test Parameter Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f6f8; }
        .container { max-width: 1200px; margin-top: 40px; }
    </style>
</head>
<body>
<div class="container">
    <h4 class="mb-4 text-center">Add New Test Parameter</h4>

    <div class="card p-4 mb-4">
        <form method="POST">
            <div class="row g-3">
                <div class="col-md-4"><label>Parameter Name</label><input type="text" name="param_name" class="form-control" required></div>
                <div class="col-md-4">
                    <label>Category</label>
                    <select name="category_id" class="form-select" required>
                        <option value="">--Select--</option>
                        <?php while ($c = $categories->fetch_assoc()): ?>
                            <option value="<?= $c['category_id'] ?>"><?= $c['category_name'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label>Group</label>
                    <select name="group_id" class="form-select" required>
                        <option value="">--Select--</option>
                        <?php while ($g = $groups->fetch_assoc()): ?>
                            <option value="<?= $g['group_id'] ?>"><?= $g['group_name'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="col-md-3"><label>Unit</label><input type="text" name="unit" class="form-control"></div>
                <div class="col-md-3"><label>Method</label><input type="text" name="method" class="form-control"></div>
                <div class="col-md-6"><label>Interpretation</label><textarea name="interpretation" class="form-control"></textarea></div>
                <div class="col-md-6"><label>Notes</label><textarea name="notes" class="form-control"></textarea></div>

                <hr class="mt-4 mb-2">

                <h6>Reference Ranges</h6>
                <div class="col-md-2"><label>Min Male</label><input type="number" name="min_m" class="form-control" step="0.01"></div>
                <div class="col-md-2"><label>Max Male</label><input type="number" name="max_m" class="form-control" step="0.01"></div>
                <div class="col-md-2"><label>Min Female</label><input type="number" name="min_f" class="form-control" step="0.01"></div>
                <div class="col-md-2"><label>Max Female</label><input type="number" name="max_f" class="form-control" step="0.01"></div>
                <div class="col-md-2"><label>Min Child</label><input type="number" name="min_c" class="form-control" step="0.01"></div>
                <div class="col-md-2"><label>Max Child</label><input type="number" name="max_c" class="form-control" step="0.01"></div>
                <div class="col-md-4"><label>Default Value</label><input type="text" name="default_val" class="form-control"></div>
            </div>

            <button type="submit" name="add" class="btn btn-primary mt-3">Add Parameter</button>
        </form>
    </div>

    <div class="card p-4">
        <h5>Existing Parameters</h5>
        <table class="table table-bordered table-hover mt-3">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Parameter</th>
                    <th>Category</th>
                    <th>Group</th>
                    <th>Unit</th>
                    <th>Method</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php $i = 1; while ($row = $params->fetch_assoc()): ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= $row['param_name'] ?></td>
                    <td><?= $row['category_name'] ?></td>
                    <td><?= $row['group_name'] ?></td>
                    <td><?= $row['unit'] ?></td>
                    <td><?= $row['method'] ?></td>
                    <td>
                        <a href="?delete=<?= $row['parameter_id'] ?>" onclick="return confirm('Delete this parameter?')" class="btn btn-sm btn-danger">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
