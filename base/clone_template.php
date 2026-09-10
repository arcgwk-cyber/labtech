<?php
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    die("Invalid template ID");
}

$stmtSel = $conn->prepare("SELECT * FROM report_templates WHERE template_id = ?");
$stmtSel->bind_param("i", $id);
$stmtSel->execute();
$template = $stmtSel->get_result()->fetch_assoc();
$stmtSel->close();

if (!$template) {
    die("Template not found");
}

$stmt = $conn->prepare("
INSERT INTO report_templates
(lab_id,template_name,patient_type,layout_json)
VALUES(?,?,?,?)
");

$new_name=$template['template_name']." Copy";

$stmt->bind_param(
"isss",
$template['lab_id'],
$new_name,
$template['patient_type'],
$template['layout_json']
);

$stmt->execute();

echo "Template Cloned";
