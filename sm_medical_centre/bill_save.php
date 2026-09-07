<?php
include 'auth_check.php';
include 'db.php';
session_start();

$conn->begin_transaction();

try {
    $bill_id = isset($_POST['bill_id']) && $_POST['bill_id'] > 0 ? (int)$_POST['bill_id'] : 0;

    // --- Patient: existing or new ---
    if (!empty($_POST['patient_id'])) {
        $patient_id = (int)$_POST['patient_id'];
    } else {
        $stmt = $conn->prepare("INSERT INTO patients 
            (full_name, gender, age, phone, email, address,dr_ref, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
        if (!$stmt) throw new Exception("Prepare failed: ".$conn->error);

        $stmt->bind_param("ssissss", $_POST['full_name'], $_POST['gender'], $_POST['age'], $_POST['phone'], $_POST['email'], $_POST['address'], $_POST['dr_ref']);
        if(!$stmt->execute()) throw new Exception("Patient insert failed: ".$stmt->error);

        $patient_id = $stmt->insert_id;
        $_SESSION['alert'] = ['type' => 'success', 'msg' => 'New Patient created successfully.'];
        $stmt->close();
    }

    // --- Bill fields ---
    $bill_date       = $_POST['bill_date'] ?? date('Y-m-d');
    $total_amount    = (float)($_POST['total_amount'] ?? 0);
    $paid_amount     = (float)($_POST['paid_amount'] ?? 0);
    $balance         = $total_amount - $paid_amount;
    $payment_status  = $_POST['payment_status'] ?? 'Pending';
    $created_by      = $_SESSION['user_id'] ?? 1;
    $sample          = 1;
    $patient_type_id = !empty($_POST['patient_type_id']) ? (int)$_POST['patient_type_id'] : null;

    $item_types = $_POST['item_type'] ?? [];
    $item_ids   = $_POST['item_id'] ?? [];

    // --- Save or update bill ---
    if ($bill_id > 0) {
        $stmt = $conn->prepare("UPDATE bills 
            SET patient_id=?, bill_date=?, total_amount=?, paid_amount=?, balance=?, payment_status=?, patient_type_id=? 
            WHERE bill_id=?");
        if (!$stmt) throw new Exception("Prepare failed: ".$conn->error);

        $stmt->bind_param("isdddsii", $patient_id, $bill_date, $total_amount, $paid_amount, $balance, $payment_status, $patient_type_id, $bill_id);
        if(!$stmt->execute()) throw new Exception("Bill update failed: ".$stmt->error);
        $stmt->close();

        // Clear old items
        $conn->query("DELETE FROM bill_tests WHERE bill_id = $bill_id");
        $conn->query("DELETE FROM bill_packages WHERE bill_id = $bill_id");
        $conn->query("DELETE FROM patient_extra_info WHERE bill_id = $bill_id");
    } else {
        $stmt = $conn->prepare("INSERT INTO bills 
            (patient_id, bill_date, total_amount, paid_amount, balance, payment_status, created_by,sample_collected, patient_type_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if (!$stmt) throw new Exception("Prepare failed: ".$conn->error);

        $stmt->bind_param("isdddsiii", $patient_id, $bill_date, $total_amount, $paid_amount, $balance, $payment_status, $created_by, $sample, $patient_type_id);
        if(!$stmt->execute()) throw new Exception("Bill insert failed: ".$stmt->error);
        $bill_id = $stmt->insert_id;
        $stmt->close();
    }

    // --- Save bill_tests and bill_packages ---
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
        if (!$stmt) throw new Exception("Prepare failed: ".$conn->error);

        $stmt->bind_param("ii", $bill_id, $id);
        if(!$stmt->execute()) throw new Exception("Insert test/package failed: ".$stmt->error);
        $stmt->close();
    }

    // --- Save extra fields ---
    if (!empty($_POST['extra'])) {
        foreach ($_POST['extra'] as $field_id => $value) {
            if (trim($value) === '') continue; // skip empty
            $stmt = $conn->prepare("INSERT INTO patient_extra_info 
                (bill_id, patient_id, field_id, field_value) 
                VALUES (?,?,?,?)");
            if (!$stmt) throw new Exception("Prepare failed: ".$conn->error);

            $stmt->bind_param("iiis", $bill_id, $patient_id, $field_id, $value);
            if(!$stmt->execute()) throw new Exception("Insert extra field failed: ".$stmt->error);
            $stmt->close();
        }
    }

    // --- Commit ---
    $conn->commit();
    $_SESSION['alert'] = ['type' => 'success', 'msg' => $bill_id > 0 ? 'Bill updated successfully.' : 'Bill created successfully.'];
    header("Location: print_bill.php?id=" . $bill_id);
    exit;

} catch (Exception $e) {
    $conn->rollback();
    $_SESSION['alert'] = ['type' => 'danger', 'msg' => "Error: " . $e->getMessage()];
    header("Location: bill_list.php");
    exit;
}
?>
