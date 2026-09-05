<?php
require_once 'db.php';

// Fetch all patient types
$types = $conn->query("SELECT * FROM patient_types");

// Add new field
if (isset($_POST['add'])) {
    $type_id = intval($_POST['type_id']);
    $name = trim($_POST['field_name']);
    $label = trim($_POST['field_label']);
    $type = $_POST['field_type'];
    $required = isset($_POST['is_required']) ? 1 : 0;

    $stmt = $conn->prepare("INSERT INTO patient_type_fields (type_id, field_name, field_label, field_type, is_required) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("isssi", $type_id, $name, $label, $type, $required);
    $stmt->execute();
    $stmt->close();

    header("Location: patient_type_fields.php");
    exit;
}

// Update field
if (isset($_POST['update'])) {
    $id = intval($_POST['field_id']);
    $name = trim($_POST['field_name']);
    $label = trim($_POST['field_label']);
    $type = $_POST['field_type'];
    $required = isset($_POST['is_required']) ? 1 : 0;

    $stmt = $conn->prepare("UPDATE patient_type_fields SET field_name=?, field_label=?, field_type=?, is_required=? WHERE field_id=?");
    $stmt->bind_param("sssii", $name, $label, $type, $required, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: patient_type_fields.php");
    exit;
}

// Delete field
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM patient_type_fields WHERE field_id = $id");
    header("Location: patient_type_fields.php");
    exit;
}

// Fetch fields
$fields = $conn->query("SELECT f.*, pt.type_name FROM patient_type_fields f JOIN patient_types pt ON f.type_id = pt.type_id ORDER BY pt.type_name, f.field_id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Patient Type Fields</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<?php include_once __DIR__ . '/header.php'; ?>

<div class="container py-5">
    <h3 class="mb-4 text-center">Patient Type - Custom Fields</h3>

    <!-- Add New -->
    <div class="card p-4 mb-4">
        <form method="POST">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Patient Type</label>
                    <select name="type_id" class="form-select" required>
                        <?php foreach ($types as $t): ?>
                            <option value="<?= $t['type_id'] ?>"><?= htmlspecialchars($t['type_name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Field Name (e.g. passport_number)</label>
                    <input type="text" name="field_name" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Field Label</label>
                    <input type="text" name="field_label" class="form-control" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Field Type</label>
                    <select name="field_type" class="form-select">
                        <option value="text">Text</option>
                        <option value="number">Number</option>
                        <option value="date">Date</option>
                        <option value="file">File</option>
                        <option value="dropdown">Dropdown</option>
                        <option value="hidden">Hidden</option>
                    </select>
                </div>
                <div class="col-md-2 mb-3 d-flex align-items-center">
                    <div class="form-check mt-4">
                        <input type="checkbox" name="is_required" class="form-check-input">
                        <label class="form-check-label">Required</label>
                    </div>
                </div>
                <div class="col-md-3 mb-3 d-flex align-items-end">
                    <button type="submit" name="add" class="btn btn-primary">Add Field</button>
                </div>
            </div>
        </form>
    </div>

    <!-- List -->
    <div class="card p-4">
        <h5 class="mb-3">Defined Fields</h5>
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Patient Type</th>
                    <th>Field Name</th>
                    <th>Label</th>
                    <th>Type</th>
                    <th>Required</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($fields as $i => $f): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= htmlspecialchars($f['type_name']) ?></td>
                    <td><?= htmlspecialchars($f['field_name']) ?></td>
                    <td><?= htmlspecialchars($f['field_label']) ?></td>
                    <td><?= $f['field_type'] ?></td>
                    <td><?= $f['is_required'] ? 'Yes' : 'No' ?></td>
                    <td>
                        <!-- Edit modal trigger -->
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?= $f['field_id'] ?>">Edit</button>
                        <a href="?delete=<?= $f['field_id'] ?>" onclick="return confirm('Delete this field?')" class="btn btn-sm btn-danger">Delete</a>
                        
                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal<?= $f['field_id'] ?>" tabindex="-1">
                          <div class="modal-dialog">
                            <form method="POST">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Field</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="field_id" value="<?= $f['field_id'] ?>">
                                        <div class="mb-3">
                                            <label class="form-label">Field Name</label>
                                            <input type="text" name="field_name" class="form-control" value="<?= htmlspecialchars($f['field_name']) ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Label</label>
                                            <input type="text" name="field_label" class="form-control" value="<?= htmlspecialchars($f['field_label']) ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Type</label>
                                            <select name="field_type" class="form-select">
                                                <?php foreach (['text','number','date','file','dropdown','hidden'] as $type): ?>
                                                    <option value="<?= $type ?>" <?= $f['field_type'] === $type ? 'selected' : '' ?>><?= ucfirst($type) ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" name="is_required" <?= $f['is_required'] ? 'checked' : '' ?>>
                                            <label class="form-check-label">Required</label>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" name="update" class="btn btn-success">Save</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                            </form>
                          </div>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if ($fields->num_rows === 0): ?>
                <tr><td colspan="7" class="text-center">No fields defined yet.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
