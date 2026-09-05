<?php
require_once("db.php");

$id=$_GET['id'];

$template=$conn->query("
SELECT * FROM report_templates 
WHERE template_id=$id
")->fetch_assoc();

$stmt=$conn->prepare("
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
