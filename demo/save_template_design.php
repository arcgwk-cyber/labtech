<?php
require_once("db.php");

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);

$template_id = $input['template_id'] ?? 0;
$layout_json = $input['layout_json'] ?? '{}';

if($template_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid template ID']);
    exit;
}

try {
    // Get current version
    $stmt = $conn->prepare("SELECT version FROM report_templates WHERE template_id = ?");
    $stmt->bind_param("i", $template_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $template = $result->fetch_assoc();
    $current_version = $template['version'] ?? 1;
    
    // Save to version history
    $history_stmt = $conn->prepare("
        INSERT INTO template_version_history 
        (template_id, version, layout_json, change_description) 
        VALUES (?, ?, ?, ?)
    ");
    $description = "Updated template design";
    $history_stmt->bind_param("iiss", $template_id, $current_version, $layout_json, $description);
    $history_stmt->execute();
    
    // Update template
    $update_stmt = $conn->prepare("
        UPDATE report_templates 
        SET layout_json = ?, updated_at = NOW()
        WHERE template_id = ?
    ");
    $update_stmt->bind_param("si", $layout_json, $template_id);
    $update_stmt->execute();
    
    echo json_encode(['success' => true, 'message' => 'Template design saved successfully']);
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>