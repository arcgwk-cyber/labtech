<?php
require_once("db.php");

header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$template_id = (int)($_POST['template_id'] ?? 0);
$new_name = trim($_POST['new_name'] ?? '');

if($template_id <= 0 || empty($new_name)){
    echo json_encode(['success' => false, 'message' => 'Invalid template ID or name']);
    exit;
}

try {
    $stmt = $conn->prepare("SELECT * FROM report_templates WHERE template_id = ?");
    $stmt->bind_param("i", $template_id);
    $stmt->execute();
    $tpl = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if(!$tpl){
        echo json_encode(['success' => false, 'message' => 'Template not found']);
        exit;
    }

    $patient_type_id = (int)($tpl['patient_type_id'] ?? 0);
    $layout_json = $tpl['layout_json'] ?? '{}';
    $header_layout_json = $tpl['header_layout_json'] ?? '{}';
    $signature_layout_json = $tpl['signature_layout_json'] ?? '{}';

    $ins = $conn->prepare("
        INSERT INTO report_templates 
        (patient_type_id, template_name, version, layout_json, header_layout_json, signature_layout_json) 
        VALUES (?, ?, 1, ?, ?, ?)
    ");
    $ins->bind_param("issss", $patient_type_id, $new_name, $layout_json, $header_layout_json, $signature_layout_json);
    $ins->execute();
    $new_id = $conn->insert_id;
    $ins->close();

    // Initial version history
    $stmt2 = $conn->prepare("
        INSERT INTO template_version_history 
        (template_id, version, layout_json, header_layout_json, signature_layout_json, change_description) 
        VALUES (?, 1, ?, ?, ?, 'Cloned template')
    ");
    $stmt2->bind_param("isss", $new_id, $layout_json, $header_layout_json, $signature_layout_json);
    $stmt2->execute();
    $stmt2->close();

    echo json_encode(['success' => true, 'new_template_id' => $new_id]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>