<?php
// Turn off ALL error output to browser - we'll catch them
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

// Start output buffering to catch any stray output
ob_start();

// Set JSON header immediately
header('Content-Type: application/json');

try {
    // Get raw input
    $raw_input = file_get_contents('php://input');
    
    if (empty($raw_input)) {
        throw new Exception('No data received');
    }
    
    $input = json_decode($raw_input, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Invalid JSON: ' . json_last_error_msg());
    }
    
    if (empty($input)) {
        throw new Exception('Empty data');
    }
    
    $template_name = trim($input['template_name'] ?? '');
    $patient_type_id = (int)($input['patient_type_id'] ?? 0);
    $layout_json = $input['layout_json'] ?? '{}';
    
    if (empty($template_name)) {
        throw new Exception('Template name is required');
    }
    
    // Now require the database - any error here will be caught
    require_once('db.php');
    
    if (!isset($conn)) {
        throw new Exception('Database connection not available');
    }
    
    // Check if table exists
    $table_check = $conn->query("SHOW TABLES LIKE 'report_templates'");
    if (!$table_check || $table_check->num_rows === 0) {
        throw new Exception('report_templates table not found');
    }
    
    // Get next version
    $version = 1;
    $version_stmt = $conn->prepare("SELECT MAX(version) as max_version FROM report_templates WHERE patient_type_id = ?");
    if ($version_stmt) {
        $version_stmt->bind_param("i", $patient_type_id);
        $version_stmt->execute();
        $version_result = $version_stmt->get_result();
        if ($version_row = $version_result->fetch_assoc()) {
            $version = ($version_row['max_version'] ?? 0) + 1;
        }
    }
    
    // Insert template - check if column exists
    $columns = $conn->query("SHOW COLUMNS FROM report_templates");
    $has_hardcoded_column = false;
    while ($col = $columns->fetch_assoc()) {
        if ($col['Field'] === 'is_hardcoded_format') {
            $has_hardcoded_column = true;
            break;
        }
    }
    
    if ($has_hardcoded_column) {
        $stmt = $conn->prepare("
            INSERT INTO report_templates 
            (patient_type_id, template_name, version, layout_json, is_hardcoded_format, created_at) 
            VALUES (?, ?, ?, ?, 1, NOW())
        ");
        $stmt->bind_param("isis", $patient_type_id, $template_name, $version, $layout_json);
    } else {
        $stmt = $conn->prepare("
            INSERT INTO report_templates 
            (patient_type_id, template_name, version, layout_json, created_at) 
            VALUES (?, ?, ?, ?, NOW())
        ");
        $stmt->bind_param("isis", $patient_type_id, $template_name, $version, $layout_json);
    }
    
    if (!$stmt->execute()) {
        throw new Exception('Database error: ' . $stmt->error);
    }
    
    $template_id = $conn->insert_id;
    
    // Clear any output buffer and send JSON
    ob_end_clean();
    
    echo json_encode([
        'success' => true, 
        'template_id' => $template_id,
        'message' => 'Template saved successfully',
        'version' => $version
    ]);
    
} catch (Exception $e) {
    // Clear any output buffer
    ob_end_clean();
    
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine()
    ]);
}

// Ensure no extra output
exit;
?>