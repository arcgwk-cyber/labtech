<?php
/**
 * VenSaas LabTech - Central Anti-CSRF Token Security Helper
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!function_exists('getCsrfToken')) {
    function getCsrfToken() {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
}

if (!function_exists('getCsrfField')) {
    function getCsrfField() {
        $token = htmlspecialchars(getCsrfToken(), ENT_QUOTES, 'UTF-8');
        return '<input type="hidden" name="csrf_token" value="' . $token . '">';
    }
}

if (!function_exists('verifyCsrfToken')) {
    function verifyCsrfToken($token = null) {
        if ($token === null) {
            $token = $_POST['csrf_token'] ?? $_GET['csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
        }
        $sessionToken = $_SESSION['csrf_token'] ?? '';
        if (empty($sessionToken) || empty($token) || !hash_equals($sessionToken, $token)) {
            http_response_code(403);
            die("Security Exception: CSRF verification failed. Please refresh the page and try again.");
        }
        return true;
    }
}
