<?php
// save_sections.php

include 'auth_check.php';
include 'db.php';

$test_id = isset($_POST['test_id']) ? (int)$_POST['test_id'] : 0;
$sections = $_POST['sections'] ?? [];

if ($test_id <= 0 || empty($sections)) {
    die('Invalid request: Test ID or Sections missing.');
}

$conn->begin_transaction();

try {
    // Remove existing parameters for this test
    $stmt = $conn->prepare("DELETE FROM lab_test_parameters WHERE test_id = ?");
    $stmt->bind_param("i", $test_id);
    $stmt->execute();
    $stmt->close();

    // Insert new sections & parameters
    $stmt = $conn->prepare("INSERT INTO lab_test_parameters (test_id, parameter_id, param_order, section_name) VALUES (?, ?, ?, ?)");
    
    $orderCounter = 1;
    foreach ($sections as $section) {
        $section_name = trim($section['name'] ?? '');
        $params = $section['params'] ?? [];
        
        foreach ($params as $param_id) {
            $param_id = (int)$param_id;
            if ($param_id > 0) {
                $stmt->bind_param("iiis", $test_id, $param_id, $orderCounter, $section_name);
                $stmt->execute();
                $orderCounter++;
            }
        }
    }

    $stmt->close();
    $conn->commit();
    header("Location: lab_test_list.php?success=1");
    exit;

} catch (Exception $e) {
    $conn->rollback();
    echo "Transaction failed: " . $e->getMessage();
}
?>
