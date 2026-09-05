<?php
/**
 * Super Admin Authentication Middleware
 * Ensures the user has an active super admin session.
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['super_admin_logged_in']) || $_SESSION['super_admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
