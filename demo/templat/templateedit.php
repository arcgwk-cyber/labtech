<?php
// template_editor.php
require_once 'db.php';

$mode = $_GET['mode'] ?? 'test'; // 'test' or 'package'
$entity_id = $_GET['id'] ?? 0;
$table = $mode === 'test' ? 'test_templates' : 'package_templates';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $header_html = $_POST['header_html'];
    $interpretation = $_POST['interpretation'];
    $notes = $_POST['notes'];
    $table_format = $_POST['table_format'];
    $group_by = isset($_POST['group_by']) ? 1 : 0;
    $show_method = isset($_POST['show_method']) ? 1 : 0;
    $show_interpretation = isset($_POST['show_interpretation']) ? 1 : 0;
    $show_notes = isset($_POST['show_notes']) ? 1 : 0;

    $column = ($mode === 'test') ? 'test_id' : 'package_id';
    $query = "REPLACE INTO $table ($column, header_html, interpretation, notes, table_format, group_by, updated_at) VALUES (?, ?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("issssi", $entity_id, $header_html, $interpretation, $notes, $table_format, $group_by);
    $stmt->execute();

    echo "<script>alert('Template saved successfully!');</script>";
}

$column = ($mode === 'test') ? 'test_id' : 'package_id';
$template = $conn->prepare("SELECT * FROM $table WHERE $column = ? LIMIT 1");
$template->bind_param("i", $entity_id);
$template->execute();
$result = $template->get_result();
$data = $result->fetch_assoc() ?? ['header_html' => '', 'interpretation' => '', 'notes' => '', 'table_format' => 'default', 'group_by' => 0];
?>
<!DOCTYPE html>
<html>
<head>
  <title>Template Editor</title>
  <script src="https://cdn.ckeditor.com/4.20.2/standard/ckeditor.js"></script>
</head>
<body>
<h2>Template Editor (<?= ucfirst($mode) ?>)</h2>
<form method="post">
  <label>Header HTML (Rich Text):</label>
  <textarea name="header_html" id="header_html"><?= htmlspecialchars($data['header_html']) ?></textarea>
  <script>CKEDITOR.replace('header_html');</script>

  <label>Interpretation:</label>
  <textarea name="interpretation" id="interpretation"><?= htmlspecialchars($data['interpretation']) ?></textarea>
  <script>CKEDITOR.replace('interpretation');</script>

  <label>Notes:</label>
  <textarea name="notes" id="notes"><?= htmlspecialchars($data['notes']) ?></textarea>
  <script>CKEDITOR.replace('notes');</script>

  <label>Table Format:</label>
  <select name="table_format">
    <option value="default" <?= $data['table_format'] == 'default' ? 'selected' : '' ?>>Default</option>
    <option value="compact" <?= $data['table_format'] == 'compact' ? 'selected' : '' ?>>Compact</option>
    <option value="boxed" <?= $data['table_format'] == 'boxed' ? 'selected' : '' ?>>Boxed</option>
  </select>

  <br><label><input type="checkbox" name="group_by" <?= $data['group_by'] ? 'checked' : '' ?>> Group By Parameter Group</label>
  <br><label><input type="checkbox" name="show_method"> Show Method in Report</label>
  <br><label><input type="checkbox" name="show_interpretation"> Show Interpretation</label>
  <br><label><input type="checkbox" name="show_notes"> Show Notes</label>

  <br><br>
  <button type="submit">Save Template</button>
</form>
</body>
</html>