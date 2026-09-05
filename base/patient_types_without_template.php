<?php
require_once 'db.php';

// Ensure table exists
$conn->query("
  CREATE TABLE IF NOT EXISTS patient_types (
    type_id INT AUTO_INCREMENT PRIMARY KEY,
    type_name VARCHAR(100) NOT NULL,
    description TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

// Add
if (isset($_POST['add'])) {
    $name = trim($_POST['type_name']);
    $desc = trim($_POST['description']);
    if (!empty($name)) {
        $stmt = $conn->prepare("INSERT INTO patient_types (type_name, description) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $desc);
        $stmt->execute();
        $stmt->close();
    }
    header("Location: patient_types.php");
    exit;
}

// Update
if (isset($_POST['update'])) {
    $id   = intval($_POST['type_id']);
    $name = trim($_POST['type_name']);
    $desc = trim($_POST['description']);
    $stmt = $conn->prepare("UPDATE patient_types SET type_name=?, description=? WHERE type_id=?");
    $stmt->bind_param("ssi", $name, $desc, $id);
    $stmt->execute();
    $stmt->close();
    header("Location: patient_types.php");
    exit;
}

// Delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM patient_types WHERE type_id = $id");
    header("Location: patient_types.php");
    exit;
}

// Fetch all
$types = $conn->query("SELECT * FROM patient_types ORDER BY type_id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Patient Types Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f8f9fa; }
        .container { max-width: 800px; margin-top: 50px; }
        .card { box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
<div class="container">
    <h3 class="mb-4 text-center">Patient Types Management</h3>

    <!-- Add Form -->
    <div class="card p-4 mb-4">
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Patient Type Name</label>
                <input type="text" name="type_name" class="form-control" required placeholder="e.g., Inpatient">
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3" placeholder="Optional description"></textarea>
            </div>
            <button type="submit" name="add" class="btn btn-primary">Add Type</button>
        </form>
    </div>

    <!-- List -->
    <div class="card p-4">
        <h5 class="mb-3">Existing Patient Types</h5>
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th style="width: 160px;">Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($types as $i => $type): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= htmlspecialchars($type['type_name']) ?></td>
                    <td><?= htmlspecialchars($type['description']) ?></td>
                    <td>
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?= $type['type_id'] ?>">Edit</button>
                        <a href="?delete=<?= $type['type_id'] ?>" onclick="return confirm('Delete this type?')" class="btn btn-sm btn-danger">Delete</a>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal<?= $type['type_id'] ?>" tabindex="-1">
                          <div class="modal-dialog">
                            <form method="POST">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Patient Type</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="type_id" value="<?= $type['type_id'] ?>">
                                        <div class="mb-3">
                                            <label class="form-label">Patient Type Name</label>
                                            <input type="text" name="type_name" class="form-control" value="<?= htmlspecialchars($type['type_name']) ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Description</label>
                                            <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($type['description']) ?></textarea>
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
            <?php if ($types->num_rows == 0): ?>
                <tr><td colspan="4" class="text-center">No patient types found.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
