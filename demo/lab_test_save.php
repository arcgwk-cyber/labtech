<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

include 'auth_check.php';
include 'db.php';

$id = isset($_POST['test_id']) ? (int)$_POST['test_id'] : 0;
$name = $_POST['test_name'] ?? '';
$testcode = $_POST['test_code'] ?? '';
$cat = isset($_POST['category_id']) ? (int)$_POST['category_id'] : 0;
$group = isset($_POST['group_id']) && $_POST['group_id'] !== '' ? (int)$_POST['group_id'] : null;
$price = isset($_POST['price']) ? (float)$_POST['price'] : 0.00;
$notes = $_POST['notes'] ?? '';
$interpretations = $_POST['interpretations'] ?? '';
$param_orders = $_POST['param_order'] ?? [];
$section_names = $_POST['section_name'] ?? [];

$conn->begin_transaction();

try {
    // Validate category_id
    $catCheckStmt = $conn->prepare("SELECT 1 FROM test_categories WHERE category_id = ?");
    $catCheckStmt->bind_param("i", $cat);
    $catCheckStmt->execute();
    $catCheckStmt->store_result();
    if ($catCheckStmt->num_rows === 0) {
        throw new Exception("Invalid category_id: $cat");
    }
    $catCheckStmt->close();

    if ($id) {
        // Update existing test
        $stmt = $conn->prepare("UPDATE lab_tests SET test_name = ?, test_code = ?, category_id = ?, group_id = ?, price = ?, notes = ?, interpretations = ? WHERE test_id = ?");
        $stmt->bind_param("ssiidssi", $name, $testcode, $cat, $group, $price, $notes, $interpretations, $id);
        $stmt->execute();
        $stmt->close();

        // Delete old parameters
        $delStmt = $conn->prepare("DELETE FROM lab_test_parameters WHERE test_id = ?");
        $delStmt->bind_param("i", $id);
        $delStmt->execute();
        $delStmt->close();
    } else {
        // Insert new test
        $stmt = $conn->prepare("INSERT INTO lab_tests (test_name, test_code, category_id, group_id, price, notes, interpretations) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiidss", $name, $testcode, $cat, $group, $price, $notes, $interpretations);
        $stmt->execute();
        $id = $stmt->insert_id;
        $stmt->close();
    }

    // Insert selected parameters with section names
    if (!empty($param_orders)) {
        $insertStmt = $conn->prepare("INSERT INTO lab_test_parameters (test_id, parameter_id, param_order, section_name) VALUES (?, ?, ?, ?)");
        foreach ($param_orders as $param_id => $order) {
            $param_id = (int)$param_id;
            $order = (int)$order;
            $section = trim($section_names[$param_id] ?? '');

            if ($param_id > 0 && $order > 0) {
                $insertStmt->bind_param("iiis", $id, $param_id, $order, $section);
                $insertStmt->execute();
            }
        }
        $insertStmt->close();
    }

    $conn->commit();
    header("Location: lab_test_list.php");
    exit;

} catch (Exception $e) {
    $conn->rollback();
    echo "Transaction rolled back. Error: " . $e->getMessage();
}
?>
