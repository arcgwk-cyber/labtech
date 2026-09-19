<?php
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/db.php';

header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$template_id = (int)($_POST['template_id'] ?? 0);

if($template_id <= 0){
    echo json_encode(['success' => false, 'message' => 'Invalid template ID']);
    exit;
}

try {
    $stmt_v = $conn->prepare("DELETE FROM template_version_history WHERE template_id = ?");
    if ($stmt_v) {
        $stmt_v->bind_param("i", $template_id);
        $stmt_v->execute();
        $stmt_v->close();
    }
    
    $stmt = $conn->prepare("DELETE FROM report_templates WHERE template_id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $template_id);
        $stmt->execute();
        $stmt->close();
    }

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>