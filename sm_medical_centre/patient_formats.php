<?php
require_once 'db.php';
require_once 'TCPDF/tcpdf.php';

$action = $_GET['action'] ?? '';
$id = $_GET['id'] ?? 0;

// Handle Add / Edit / Delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['preview'])) {
    $format_name = $_POST['format_name'];
    $template_json = $_POST['template_json'];
    $is_first_page = isset($_POST['is_first_page']) ? 1 : 0;

    if ($is_first_page) $conn->query("UPDATE patient_formats SET is_first_page=0");

    if (!empty($_POST['format_id'])) {
        $stmt = $conn->prepare("UPDATE patient_formats SET format_name=?, template_json=?, is_first_page=? WHERE format_id=?");
        $stmt->bind_param("ssii", $format_name, $template_json, $is_first_page, $_POST['format_id']);
        $stmt->execute(); $stmt->close();
    } else {
        $stmt = $conn->prepare("INSERT INTO patient_formats (format_name, template_json, is_first_page) VALUES (?,?,?)");
        $stmt->bind_param("ssi", $format_name, $template_json, $is_first_page);
        $stmt->execute(); $stmt->close();
    }
    header("Location: patient_formats.php"); exit;
}

if ($action=='delete' && $id>0){
    $stmt=$conn->prepare("DELETE FROM patient_formats WHERE format_id=?");
    $stmt->bind_param("i",$id);
    $stmt->execute(); $stmt->close();
    header("Location: patient_formats.php"); exit;
}

// Fetch formats
$formats = $conn->query("SELECT * FROM patient_formats ORDER BY format_id DESC");

// Edit current
$current = null;
if($action=='edit' && $id>0){
    $stmt=$conn->prepare("SELECT * FROM patient_formats WHERE format_id=?");
    $stmt->bind_param("i",$id);
    $stmt->execute();
    $current=$stmt->get_result()->fetch_assoc();
    $stmt->close();
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Patient Formats</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>
</head>
<body class="bg-light">
<div class="container mt-4">

<div class="card mb-3">
<div class="card-body">
<h5><?= $current ? 'Edit Format':'Add New Format' ?></h5>
<form method="POST">
<input type="hidden" name="format_id" value="<?= $current['format_id'] ?? '' ?>">

<div class="mb-3">
<label class="form-label">Format Name</label>
<input type="text" name="format_name" class="form-control" required
value="<?= htmlspecialchars($current['format_name'] ?? '') ?>">
</div>

<div class="mb-3">
<label class="form-label">Template JSON</label>
<textarea name="template_json" class="form-control" rows="8"><?= htmlspecialchars($current['template_json'] ?? '') ?></textarea>
</div>

<div class="form-check mb-3">
<input type="checkbox" class="form-check-input" name="is_first_page" id="is_first_page"
<?= ($current['is_first_page'] ?? 0)?'checked':'' ?>>
<label class="form-check-label" for="is_first_page">Is First Page Template</label>
</div>

<button type="submit" class="btn btn-success">Save</button>
<a href="patient_formats.php" class="btn btn-secondary">Cancel</a>
</form>
</div>
</div>

<div class="card">
<div class="card-body">
<h5>Saved Formats</h5>
<table class="table table-bordered table-sm">
<thead>
<tr><th>Name</th><th>First Page</th><th>Actions</th></tr>
</thead>
<tbody>
<?php while($row=$formats->fetch_assoc()): ?>
<tr>
<td><?= htmlspecialchars($row['format_name']) ?></td>
<td><?= $row['is_first_page']?'Yes':'' ?></td>
<td>
<a href="?action=edit&id=<?= $row['format_id'] ?>" class="btn btn-sm btn-warning">Edit</a>
<a href="?action=delete&id=<?= $row['format_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Del</a>
</td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
</div>
</div>

</div>
</body>
</html>
