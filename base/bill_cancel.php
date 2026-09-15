<?php
/**
 * Diagnostic Bill Cancellation & Approval Controller
 * Handles cancellation requests, direct staff/admin cancellations, and admin approvals/rejections.
 */
include_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$current_user_id = $_SESSION['user_id'] ?? 0;
$current_role    = strtolower($_SESSION['role'] ?? 'user');
$role_id         = (int)($_SESSION['role_id'] ?? 0);
$is_admin        = ($current_role === 'admin' || $role_id === 1);

function isAjax() {
    return (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') ||
           (!empty($_SERVER['CONTENT_TYPE']) && strpos($_SERVER['CONTENT_TYPE'], 'application/json') !== false);
}

function respondResult($success, $message, $redirect = 'bill_list.php') {
    if (isAjax()) {
        header('Content-Type: application/json');
        echo json_encode(['success' => $success, 'message' => $message]);
        exit;
    }
    $_SESSION['alert'] = [
        'type' => $success ? 'success' : 'danger',
        'msg'  => $message
    ];
    header("Location: " . $redirect);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respondResult(false, "Invalid request method.");
}

$action = trim($_POST['action'] ?? '');
$bill_id = (int)($_POST['bill_id'] ?? 0);
$reason  = trim($_POST['reason'] ?? $_POST['cancellation_reason'] ?? '');
$remarks = trim($_POST['admin_remarks'] ?? $_POST['cancellation_admin_remarks'] ?? '');
$referer = !empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'bill_list.php';

if ($bill_id <= 0) {
    respondResult(false, "Invalid Bill ID specified.", $referer);
}

// Fetch current bill record
$stmt = $conn->prepare("SELECT * FROM bills WHERE bill_id = ? LIMIT 1");
$stmt->bind_param("i", $bill_id);
$stmt->execute();
$bill = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$bill) {
    respondResult(false, "Bill #{$bill_id} not found.", $referer);
}

if ($bill['status'] === 'cancelled' && $action !== 'reject_cancel') {
    respondResult(false, "Bill #{$bill_id} is already cancelled.", $referer);
}

// Check if report is already done
$is_report_done = ((int)$bill['result_entered'] === 1) || ((int)($bill['report_printed'] ?? 0) === 1);
if (!$is_report_done) {
    $resCheck = $conn->prepare("SELECT COUNT(*) as cnt FROM test_results WHERE bill_id = ? AND result_value IS NOT NULL AND TRIM(result_value) != ''");
    if ($resCheck) {
        $resCheck->bind_param("i", $bill_id);
        $resCheck->execute();
        $cRow = $resCheck->get_result()->fetch_assoc();
        if ($cRow && (int)$cRow['cnt'] > 0) {
            $is_report_done = true;
        }
        $resCheck->close();
    }
}

switch ($action) {
    // -------------------------------------------------------------
    // 1. Submit Cancellation Request (Staff when report already done)
    // -------------------------------------------------------------
    case 'request_cancel':
        if (empty($reason)) {
            respondResult(false, "A reason for bill cancellation request is mandatory.", $referer);
        }

        $upStmt = $conn->prepare("
            UPDATE bills 
            SET cancellation_status = 'requested',
                cancellation_reason = ?,
                cancellation_requested_by = ?,
                cancellation_requested_at = NOW()
            WHERE bill_id = ?
        ");
        $upStmt->bind_param("sii", $reason, $current_user_id, $bill_id);
        if ($upStmt->execute()) {
            $upStmt->close();
            respondResult(true, "Cancellation request for Bill #{$bill_id} has been submitted for Administrator approval.", $referer);
        } else {
            $upStmt->close();
            respondResult(false, "Failed to submit cancellation request: " . $conn->error, $referer);
        }
        break;

    // -------------------------------------------------------------
    // 2. Direct Cancellation (Admin anytime, or Staff if report NOT done)
    // -------------------------------------------------------------
    case 'direct_cancel':
        if (empty($reason)) {
            respondResult(false, "Please provide a valid reason for cancelling this bill.", $referer);
        }

        // If report is already completed and user is NOT admin, enforce request approval workflow
        if ($is_report_done && !$is_admin) {
            // Auto-route to request_cancel
            $upStmt = $conn->prepare("
                UPDATE bills 
                SET cancellation_status = 'requested',
                    cancellation_reason = ?,
                    cancellation_requested_by = ?,
                    cancellation_requested_at = NOW()
                WHERE bill_id = ?
            ");
            $upStmt->bind_param("sii", $reason, $current_user_id, $bill_id);
            $upStmt->execute();
            $upStmt->close();
            respondResult(true, "Report is already completed for Bill #{$bill_id}. Cancellation request was automatically submitted for Administrator approval.", $referer);
        }

        // Direct cancel permitted
        $upStmt = $conn->prepare("
            UPDATE bills 
            SET status = 'cancelled',
                cancellation_status = 'approved',
                cancellation_reason = ?,
                cancelled_by = ?,
                cancelled_at = NOW()
            WHERE bill_id = ?
        ");
        $upStmt->bind_param("sii", $reason, $current_user_id, $bill_id);
        if ($upStmt->execute()) {
            $upStmt->close();
            respondResult(true, "Bill #{$bill_id} has been successfully CANCELLED.", $referer);
        } else {
            $upStmt->close();
            respondResult(false, "Failed to cancel bill: " . $conn->error, $referer);
        }
        break;

    // -------------------------------------------------------------
    // 3. Admin Approval for Pending Cancellation Request
    // -------------------------------------------------------------
    case 'approve_cancel':
        if (!$is_admin) {
            respondResult(false, "Access denied. Only an Administrator can approve bill cancellations.", $referer);
        }

        $admin_note = !empty($remarks) ? $remarks : (!empty($reason) ? $reason : "Approved by Administrator");
        $upStmt = $conn->prepare("
            UPDATE bills 
            SET status = 'cancelled',
                cancellation_status = 'approved',
                cancelled_by = ?,
                cancelled_at = NOW(),
                cancellation_admin_remarks = ?
            WHERE bill_id = ?
        ");
        $upStmt->bind_param("isi", $current_user_id, $admin_note, $bill_id);
        if ($upStmt->execute()) {
            $upStmt->close();
            respondResult(true, "Cancellation request for Bill #{$bill_id} has been APPROVED. The bill is now voided.", $referer);
        } else {
            $upStmt->close();
            respondResult(false, "Failed to approve cancellation: " . $conn->error, $referer);
        }
        break;

    // -------------------------------------------------------------
    // 4. Admin Rejection of Cancellation Request
    // -------------------------------------------------------------
    case 'reject_cancel':
        if (!$is_admin) {
            respondResult(false, "Access denied. Only an Administrator can reject bill cancellations.", $referer);
        }

        $rejection_note = !empty($remarks) ? $remarks : "Cancellation rejected by Administrator";
        $upStmt = $conn->prepare("
            UPDATE bills 
            SET cancellation_status = 'rejected',
                cancellation_admin_remarks = ?
            WHERE bill_id = ?
        ");
        $upStmt->bind_param("si", $rejection_note, $bill_id);
        if ($upStmt->execute()) {
            $upStmt->close();
            respondResult(true, "Cancellation request for Bill #{$bill_id} has been REJECTED. The bill remains active.", $referer);
        } else {
            $upStmt->close();
            respondResult(false, "Failed to reject cancellation: " . $conn->error, $referer);
        }
        break;

    default:
        respondResult(false, "Unknown cancellation action.", $referer);
}
