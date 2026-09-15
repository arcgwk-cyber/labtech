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

$current_role = strtolower($_SESSION['role'] ?? 'user');
$role_id      = (int)($_SESSION['role_id'] ?? 0);
$is_admin     = ($current_role === 'admin' || $role_id === 1);

// Clinical Audit Protection: Check if bill modification is locked
if ($bill_id > 0) {
    $lockStmt = $conn->prepare("SELECT status, report_printed, result_entered FROM bills WHERE bill_id = ? LIMIT 1");
    if ($lockStmt) {
        $lockStmt->bind_param("i", $bill_id);
        $lockStmt->execute();
        $billRow = $lockStmt->get_result()->fetch_assoc();
        $lockStmt->close();

        if ($billRow) {
            if ($billRow['status'] === 'cancelled') {
                $_SESSION['alert'] = [
                    'type' => 'danger',
                    'msg'  => "Cannot modify Bill #{$bill_id}: This invoice is cancelled and voided."
                ];
                header("Location: bill_list.php");
                exit;
            }

            $is_report_done = ((int)$billRow['result_entered'] === 1) || ((int)($billRow['report_printed'] ?? 0) === 1);
            if (!$is_report_done) {
                $rChk = $conn->prepare("SELECT COUNT(*) as cnt FROM test_results WHERE bill_id = ? AND result_value IS NOT NULL AND TRIM(result_value) != ''");
                if ($rChk) {
                    $rChk->bind_param("i", $bill_id);
                    $rChk->execute();
                    $cRow = $rChk->get_result()->fetch_assoc();
                    if ($cRow && (int)$cRow['cnt'] > 0) {
                        $is_report_done = true;
                    }
                    $rChk->close();
                }
            }

            if ($is_report_done && !$is_admin) {
                $_SESSION['alert'] = [
                    'type' => 'danger',
                    'msg'  => "Modification locked: Diagnostic report has already been generated or printed for Bill #{$bill_id}. Non-admin users cannot alter completed clinical bills. Please request bill cancellation from Administrator."
                ];
                header("Location: bill_list.php");
                exit;
            }
        }
    }
}

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
