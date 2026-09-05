<?php
require_once("db.php");

header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$version_id = $_POST['version_id'] ?? 0;

if($version_id <= 0){
    echo json_encode(['success' => false, 'message' => 'Invalid version ID']);
    exit;
}

try {
    $stmt = $conn->prepare("
        SELECT * FROM template_version_history 
        WHERE version_id = ?
    ");
    $stmt->bind_param("i", $version_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $version = $result->fetch_assoc();
    
    if($version){
        echo json_encode([
            'success' => true,
            'version' => $version
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Version not found']);
    }
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>