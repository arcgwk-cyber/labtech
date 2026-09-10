<?php
/**
 * Password Reset Handler
 * Restricted: Password updates require authenticated session or administrative authorization.
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect unauthenticated requests to recovery guidance page
if (empty($_SESSION['user_id'])) {
    header("Location: reset_password.php");
    exit;
}

require_once __DIR__ . '/db.php';

$user_id = (int)$_SESSION['user_id'];
$old_pass = trim($_POST['old_password'] ?? '');
$new_pass = trim($_POST['new_password'] ?? '');
$confirm_pass = trim($_POST['confirm_password'] ?? '');

$error = null;
$success = false;

if (empty($old_pass) || empty($new_pass) || empty($confirm_pass)) {
    $error = "All fields are required.";
} elseif ($new_pass !== $confirm_pass) {
    $error = "New passwords do not match.";
} elseif (strlen($new_pass) < 6) {
    $error = "New password must be at least 6 characters long.";
} else {
    if ($conn) {
        $stmt = $conn->prepare("SELECT password_hash FROM users WHERE user_id = ? LIMIT 1");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($user = $res->fetch_assoc()) {
            if (password_verify($old_pass, $user['password_hash']) || md5($old_pass) === $user['password_hash']) {
                $new_hash = password_hash($new_pass, PASSWORD_BCRYPT);
                $upStmt = $conn->prepare("UPDATE users SET password_hash = ? WHERE user_id = ?");
                $upStmt->bind_param("si", $new_hash, $user_id);
                if ($upStmt->execute()) {
                    $success = true;
                } else {
                    $error = "Failed to update password: " . $conn->error;
                }
                $upStmt->close();
            } else {
                $error = "Current password is incorrect.";
            }
        } else {
            $error = "User not found.";
        }
        $stmt->close();
    } else {
        $error = "Database unavailable.";
    }
}

if ($success) {
    header("Location: profile.php?msg=password_updated");
    exit;
} else {
    header("Location: profile.php?error=" . urlencode($error));
    exit;
}
