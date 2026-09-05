<?php
// template_editor.php
include 'auth_check.php';
require_once 'db.php';

$mode = $_GET['mode'] ?? 'test'; // 'test' or 'package'
$entity_id = $_GET['id'] ?? 0;
$table = $mode === 'test' ? 'test_templates' : 'package_templates';

// Fetch available tests or packages for dropdown
if ($mode === 'test') {
    $entities = $conn->query("SELECT test_id AS id, test_name AS name FROM lab_tests ORDER BY test_name");
} else {
    $entities = $conn->query("SELECT package_id AS id, package_name AS name FROM test_packages ORDER BY package_name");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['header_html'])) {
    $entity_id = $_POST['entity_id'];
    $header_html = $_POST['header_html'];
    $interpretation = $_POST['interpretation'];
    $notes = $_POST['notes'];
    $table_format = $_POST['table_format'];
    $group_by = isset($_POST['group_by']) ? 1 : 0;
    $show_method = isset($_POST['show_method']) ? 1 : 0;
    $show_interpretation = isset($_POST['show_interpretation']) ? 1 : 0;
    $show_notes = isset($_POST['show_notes']) ? 1 : 0;

    $column = 'test_id'; // Both tables now use 'test_id' as primary key
    $query = "REPLACE INTO $table ($column, header_html, interpretation, notes, table_format, group_by, show_method, show_interpretation, show_notes, updated_at) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("issssiiii", $entity_id, $header_html, $interpretation, $notes, $table_format, $group_by, $show_method, $show_interpretation, $show_notes);
    $stmt->execute();

    echo "<script>alert('Template saved successfully!'); window.location='?mode=$mode&id=$entity_id';</script>";
    exit;
}

$template = $conn->prepare("SELECT * FROM $table WHERE test_id = ? LIMIT 1");
$template->bind_param("i", $entity_id);
$template->execute();
$result = $template->get_result();
$data = $result->fetch_assoc() ?? [
    'header_html' => '',
    'interpretation' => '',
    'notes' => '',
    'table_format' => 'default',
    'group_by' => 0,
    'show_method' => 0,
    'show_interpretation' => 0,
    'show_notes' => 0
];
?>
<!DOCTYPE html>
<html>
<head>
  <title>Template Editor</title>
  <script src="https://cdn.ckeditor.com/4.25.1-lts/standard/ckeditor.js"></script>
  <style>
    .editor-section, .preview-section {
      display: inline-block;
      vertical-align: top;
      width: 48%;
      padding: 10px;
    }
    .preview-box {
      border: 1px solid #ccc;
      padding: 10px;
      background: #f9f9f9;
      min-height: 300px;
    }
  </style>
</head>
<body>
<h2>Template Editor (<?= ucfirst($mode) ?>)</h2>
<form method="post" id="templateForm" onsubmit="return savePreview()">
  <label><?= ucfirst($mode) ?>:</label>
  <select name="entity_id" id="entity_id_selector">
    <option value="">-- Select <?= ucfirst($mode) ?> --</option>
    <?php while($row = $entities->fetch_assoc()): ?>
      <option value="<?= $row['id'] ?>" <?= $entity_id == $row['id'] ? 'selected' : '' ?>><?= htmlspecialchars($row['name']) ?></option>
    <?php endwhile; ?>
  </select>
  <div class="editor-section">
    <h4>Header HTML (Rich Text):</h4>
    <textarea name="header_html" id="header_html"><?= htmlspecialchars($data['header_html']) ?></textarea>

    <h4>Interpretation:</h4>
    <textarea name="interpretation" id="interpretation"><?= htmlspecialchars($data['interpretation']) ?></textarea>

    <h4>Notes:</h4>
    <textarea name="notes" id="notes"><?= htmlspecialchars($data['notes']) ?></textarea>

    <label>Table Format:</label>
    <select name="table_format">
      <option value="default" <?= $data['table_format'] == 'default' ? 'selected' : '' ?>>Default</option>
      <option value="compact" <?= $data['table_format'] == 'compact' ? 'selected' : '' ?>>Compact</option>
      <option value="boxed" <?= $data['table_format'] == 'boxed' ? 'selected' : '' ?>>Boxed</option>
    </select>

    <br><label><input type="checkbox" name="group_by" <?= $data['group_by'] ? 'checked' : '' ?>> Group By Parameter Group</label>
    <br><label><input type="checkbox" name="show_method" <?= $data['show_method'] ? 'checked' : '' ?>> Show Method in Report</label>
    <br><label><input type="checkbox" name="show_interpretation" <?= $data['show_interpretation'] ? 'checked' : '' ?>> Show Interpretation</label>
    <br><label><input type="checkbox" name="show_notes" <?= $data['show_notes'] ? 'checked' : '' ?>> Show Notes</label>

    <br><br>
    <button type="submit">Save Template</button>
  </div>

  <div class="preview-section">
    <h4>Live Preview</h4>
    <div class="preview-box" id="preview-box"></div>
  </div>
<button type="button" onclick="loadTemplate()">Load Selected Template</button>
</form>

<?php if ($entity_id): ?>
<script>
  CKEDITOR.replace('header_html', { on: { change: updatePreview } });
  CKEDITOR.replace('interpretation', { on: { change: updatePreview } });
  CKEDITOR.replace('notes', { on: { change: updatePreview } });

  function updatePreview() {
    let header = CKEDITOR.instances['header_html'].getData();
    let interpretation = CKEDITOR.instances['interpretation'].getData();
    let notes = CKEDITOR.instances['notes'].getData();
    document.getElementById('preview-box').innerHTML = `
      <div><strong>Header:</strong><br>${header}</div>
      <hr>
      <div><strong>Interpretation:</strong><br>${interpretation}</div>
      <hr>
      <div><strong>Notes:</strong><br>${notes}</div>
    `;
  }

  function savePreview() {
    updatePreview();
    return true;
  }

  function loadTemplate() {
    const id = document.getElementById('entity_id_selector').value;
    if (id) {
      window.location.href = `?mode=<?= $mode ?>&id=${id}`;
    }
  }

  window.onload = updatePreview;
</script>
<?php endif; ?>
</body>
</html>
