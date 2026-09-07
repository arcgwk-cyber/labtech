<?php
include 'auth_check.php';
include 'db.php';
session_start(); // For alerts

$bill_id        = isset($_POST['bill_id']) && $_POST['bill_id'] > 0 ? (int)$_POST['bill_id'] : 0;
$patient_id     = (int)($_POST['patient_id'] ?? 0);
$bill_date      = $_POST['bill_date'] ?? date('Y-m-d');
$total_amount   = (float)($_POST['total_amount'] ?? 0);
$paid_amount    = (float)($_POST['paid_amount'] ?? 0);
$balance        = $total_amount - $paid_amount;
$payment_status = $_POST['payment_status'] ?? 'Pending';
$created_by     = $_SESSION['user_id'] ?? 1;
$patient_type_id = !empty($_POST['patient_type_id']) ? (int)$_POST['patient_type_id'] : null;

$item_types  = $_POST['item_type'] ?? [];
$item_ids    = $_POST['item_id'] ?? [];

$conn->begin_transaction();

try {
    // --- Patient Insert / Update ---
    if (!$patient_id && !empty($_POST['full_name'])) {
        // New patient
        $stmt = $conn->prepare("INSERT INTO patients 
            (full_name, gender, age, phone, address, dr_ref, created_at)
            VALUES (?, ?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param(
            "ssisss",
            $_POST['full_name'],
            $_POST['gender'],
            $_POST['age'],
            $_POST['phone'],
            $_POST['address'],
            $_POST['dr_ref']
        );
        $stmt->execute();
        $patient_id = $stmt->insert_id;
        $stmt->close();
    } elseif ($patient_id > 0) {
        // Update existing patient
        $email = $_POST['email'] ?? '';
        $stmt = $conn->prepare("UPDATE patients 
            SET full_name=?, gender=?, age=?, phone=?, email=?, address=?, dr_ref=? 
            WHERE patient_id=?");
        $stmt->bind_param(
            "ssissssi",
            $_POST['full_name'],
            $_POST['gender'],
            $_POST['age'],
            $_POST['phone'],
            $email,
            $_POST['address'],
            $_POST['dr_ref'],
            $patient_id
        );
        $stmt->execute();
        $stmt->close();
    }

    // --- Bill Insert / Update ---
    if ($bill_id > 0) {
        $stmt = $conn->prepare("UPDATE bills 
            SET patient_id=?, bill_date=?, total_amount=?, paid_amount=?, balance=?, payment_status=?, patient_type_id=? 
            WHERE bill_id=?");
        $stmt->bind_param("isddssii",
            $patient_id,
            $bill_date,
            $total_amount,
            $paid_amount,
            $balance,
            $payment_status,
            $patient_type_id,
            $bill_id
        );
        $stmt->execute();
        $stmt->close();

        // Clear previous tests/packages/extra fields
        $conn->query("DELETE FROM bill_tests WHERE bill_id = $bill_id");
        $conn->query("DELETE FROM bill_packages WHERE bill_id = $bill_id");
        $conn->query("DELETE FROM patient_extra_info WHERE bill_id = $bill_id");
    } else {
        $stmt = $conn->prepare("INSERT INTO bills 
            (patient_id, bill_date, total_amount, paid_amount, balance, payment_status, created_by, patient_type_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isddssii",
            $patient_id,
            $bill_date,
            $total_amount,
            $paid_amount,
            $balance,
            $payment_status,
            $created_by,
            $patient_type_id
        );
        $stmt->execute();
        $bill_id = $stmt->insert_id;
        $stmt->close();
    }

    // --- Save selected tests and packages ---
    foreach ($item_types as $index => $type) {
        $id = (int)$item_ids[$index];
        if ($id <= 0) continue;

        if ($type === 'test') {
            $stmt = $conn->prepare("INSERT INTO bill_tests (bill_id, test_id) VALUES (?, ?)");
        } elseif ($type === 'package') {
            $stmt = $conn->prepare("INSERT INTO bill_packages (bill_id, package_id) VALUES (?, ?)");
        } else {
            continue;
        }
        $stmt->bind_param("ii", $bill_id, $id);
        $stmt->execute();
        $stmt->close();
    }

    // --- Save extra patient fields ---
    if (!empty($_POST['extra'])) {
        foreach ($_POST['extra'] as $field_id => $value) {
            if (trim($value) === '') continue;
            $stmt = $conn->prepare("INSERT INTO patient_extra_info (bill_id, patient_id, field_id, field_value) VALUES (?,?,?,?)");
            $stmt->bind_param("iiis", $bill_id, $patient_id, $field_id, $value);
            $stmt->execute();
            $stmt->close();
        }
    }

    $conn->commit();
    $_SESSION['alert'] = [
        'type' => 'success',
        'msg' => $bill_id > 0 ? "Bill updated successfully." : "Bill created successfully."
    ];
    header("Location: print_bill.php?id=" . $bill_id);
    exit;

} catch (Exception $e) {
    $conn->rollback();
    $_SESSION['alert'] = [
        'type' => 'danger',
        'msg' => "Error saving bill: " . $e->getMessage()
    ];
    header("Location: bill_list.php");
    exit;
}
