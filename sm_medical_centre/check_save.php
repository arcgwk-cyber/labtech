<?php
// Simple endpoint to check if the file works
header('Content-Type: application/json');

echo json_encode([
    'status' => 'ok',
    'message' => 'File is accessible',
    'timestamp' => date('Y-m-d H:i:s'),
    'post_data' => !empty($_POST) ? $_POST : 'No POST data',
    'raw_input' => file_get_contents('php://input') ?: 'No raw input'
]);
?>