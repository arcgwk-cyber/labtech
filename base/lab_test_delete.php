<?php
include 'auth_check.php';
include 'db.php';
require_once __DIR__ . '/csrf.php';

if (empty($_SESSION['role_id']) || (int)$_SESSION['role_id'] !== 1) {
    http_response_code(403);
    die("Access Denied: Administrative privileges required.");
}

verifyCsrfToken($_GET['csrf_token'] ?? '');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    // Delete mapped parameters first
    $stmt1 = $conn->prepare("DELETE FROM lab_test_parameters WHERE test_id = ?");
    if ($stmt1) {
        $stmt1->bind_param("i", $id);
        $stmt1->execute();
        $stmt1->close();
    }
    
    // Delete package mappings if any
    $stmt2 = $conn->prepare("DELETE FROM package_test_map WHERE test_id = ?");
    if ($stmt2) {
        $stmt2->bind_param("i", $id);
        $stmt2->execute();
        $stmt2->close();
    }

    // Delete test
    $stmt3 = $conn->prepare("DELETE FROM lab_tests WHERE test_id = ?");
    if ($stmt3) {
        $stmt3->bind_param("i", $id);
        $stmt3->execute();
        $stmt3->close();
    }
}

header("Location: lab_test_list.php");
exit;

