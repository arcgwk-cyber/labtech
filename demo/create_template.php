<?php
require_once("db.php");

header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$patient_type_id = $_POST['patient_type_id'] ?? 0;
$template_name = trim($_POST['template_name'] ?? '');
$layout_json = $_POST['layout_json'] ?? '{}';
$header_layout_json = $_POST['header_layout_json'] ?? '{}';
$signature_layout_json = $_POST['signature_layout_json'] ?? '{}';

if($patient_type_id <= 0 || empty($template_name)){
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
    exit;
}

$conn->begin_transaction();

try {
    // Insert new template
    $stmt = $conn->prepare("
        INSERT INTO report_templates 
        (patient_type_id, template_name, version, layout_json, header_layout_json, signature_layout_json) 
        VALUES (?, ?, 1, ?, ?, ?)
    ");
    $stmt->bind_param("issss", $patient_type_id, $template_name, $layout_json, $header_layout_json, $signature_layout_json);
    $stmt->execute();
    $template_id = $conn->insert_id;
    
    // Create initial version history
    $stmt2 = $conn->prepare("
        INSERT INTO template_version_history 
        (template_id, version, layout_json, header_layout_json, signature_layout_json, change_description) 
        VALUES (?, 1, ?, ?, ?, 'Initial version')
    ");
    $stmt2->bind_param("isss", $template_id, $layout_json, $header_layout_json, $signature_layout_json);
    $stmt2->execute();
    
    $conn->commit();
    
    echo json_encode(['success' => true, 'template_id' => $template_id]);
    
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>