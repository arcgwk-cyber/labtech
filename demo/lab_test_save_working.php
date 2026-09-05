<?php
// Enable strict error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

include 'auth_check.php';
include 'db.php';

// Get form values
$id = isset($_POST['test_id']) ? (int)$_POST['test_id'] : 0;
$name = $_POST['test_name'] ?? '';
$testcode = $_POST['test_code'] ?? '';
$cat = isset($_POST['category_id']) ? (int)$_POST['category_id'] : 0;
$group = isset($_POST['group_id']) && $_POST['group_id'] !== '' ? (int)$_POST['group_id'] : null;
$price = isset($_POST['price']) ? (float)$_POST['price'] : 0.00;
$notes = $_POST['notes'] ?? '';
$interpretations = $_POST['interpretations'] ?? '';
$params = $_POST['parameters'] ?? [];

$conn->begin_transaction();

try {
    // ✅ Check if category_id is valid
    $catCheckStmt = $conn->prepare("SELECT 1 FROM test_categories WHERE category_id = ?");
    $catCheckStmt->bind_param("i", $cat);
    $catCheckStmt->execute();
    $catCheckStmt->store_result();
    if ($catCheckStmt->num_rows === 0) {
        throw new Exception("Invalid category_id: $cat does not exist.");
    }
    $catCheckStmt->close();

    // ✅ Insert or update lab test
    if ($id) {
        $stmt = $conn->prepare("UPDATE lab_tests SET test_name = ?, test_code = ?, category_id = ?, group_id = ?, price = ?, notes = ?, interpretations = ? WHERE test_id = ?");
        $stmt->bind_param("ssiidssi", $name, $testcode, $cat, $group, $price, $notes,$interpretations, $id);
        $stmt->execute();
        $stmt->close();

        // ✅ Delete existing test parameters
        $delStmt = $conn->prepare("DELETE FROM lab_test_parameters WHERE test_id = ?");
        $delStmt->bind_param("i", $id);
        $delStmt->execute();
        $delStmt->close();
    } else {
        $stmt = $conn->prepare("INSERT INTO lab_tests (test_name, test_code, category_id, group_id, price, notes,interpretations) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiidss", $name, $testcode, $cat, $group, $price, $notes, $interpretations);
        $stmt->execute();
        $id = $stmt->insert_id;
        $stmt->close();
    }

    // ✅ Insert parameters
    if (!empty($params)) {
        $insertStmt = $conn->prepare("INSERT INTO lab_test_parameters (test_id, parameter_id) VALUES (?, ?)");
        foreach ($params as $pid) {
            $pid = (int)$pid;
            $insertStmt->bind_param("ii", $id, $pid);
            $insertStmt->execute();
        }
        $insertStmt->close();
    }

    // ✅ Commit transaction
    $conn->commit();
    header("Location: lab_test_list.php");
    exit;

} catch (Exception $e) {
    $conn->rollback();
    echo "Transaction rolled back. Error: " . $e->getMessage();
}
