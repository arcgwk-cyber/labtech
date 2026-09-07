<?php
require_once("db.php");

header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$template_id = $_POST['template_id'] ?? 0;
$layout_json = $_POST['layout_json'] ?? '{}';
$header_layout_json = $_POST['header_layout_json'] ?? '{}';
$signature_layout_json = $_POST['signature_layout_json'] ?? '{}';
$change_description = trim($_POST['change_description'] ?? 'New version');

if($template_id <= 0){
    echo json_encode(['success' => false, 'message' => 'Invalid template ID']);
    exit;
}

$conn->begin_transaction();

try {
    // Get current version and increment
    $stmt = $conn->prepare("SELECT version FROM report_templates WHERE template_id = ?");
    $stmt->bind_param("i", $template_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $template = $result->fetch_assoc();
    $new_version = $template['version'] + 1;
    
    // Save to version history
    $stmt2 = $conn->prepare("
        INSERT INTO template_version_history 
        (template_id, version, layout_json, header_layout_json, signature_layout_json, change_description) 
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    $stmt2->bind_param("iissss", $template_id, $new_version, $layout_json, $header_layout_json, $signature_layout_json, $change_description);
    $stmt2->execute();
    
    // Update template with new version
    $stmt3 = $conn->prepare("
        UPDATE report_templates 
        SET layout_json = ?, header_layout_json = ?, signature_layout_json = ?,
            version = ?, updated_at = NOW()
        WHERE template_id = ?
    ");
    $stmt3->bind_param("sssii", $layout_json, $header_layout_json, $signature_layout_json, $new_version, $template_id);
    $stmt3->execute();
    
    $conn->commit();
    
    echo json_encode(['success' => true, 'new_version' => $new_version]);
    
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>