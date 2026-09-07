<?php
/**
 * VenSaas LabTech - Central Database Connection Loader
 * Automatically reads .env from project root or system environment variables.
 * Provides:
 *   - $conn : MySQLi connection
 *   - $pdo  : PDO connection
 */

// Helper function to load .env file if present
if (!function_exists('loadEnvFile')) {
    function loadEnvFile($envPath) {
        if (!file_exists($envPath)) return false;
        $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '' || strpos($line, '#') === 0) continue;
            if (strpos($line, '=') !== false) {
                list($name, $value) = explode('=', $line, 2);
                $name = trim($name);
                $value = trim($value, " \t\n\r\0\x0B\"'");
                if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
                    putenv("{$name}={$value}");
                    $_ENV[$name] = $value;
                    $_SERVER[$name] = $value;
                }
            }
        }
        return true;
    }
}

// Check for .env in current directory or parent directory
$possible_env_paths = [
    __DIR__ . '/.env',
    dirname(__DIR__) . '/.env'
];
foreach ($possible_env_paths as $ep) {
    if (file_exists($ep)) {
        loadEnvFile($ep);
        break;
    }
}

$host   = getenv('DB_HOST') ?: 'localhost';
$user   = getenv('DB_USER') ?: 'root';
$pass   = getenv('DB_PASS') !== false ? getenv('DB_PASS') : '';
$dbname = getenv('DB_NAME') ?: 'diagnostic_lab_db';

// 1. MySQLi Connection ($conn)
mysqli_report(MYSQLI_REPORT_OFF);
$conn = @new mysqli($host, $user, $pass, $dbname);

// Local fallback attempt if default credentials fail (common in local XAMPP/WAMP dev)
if ($conn->connect_error && ($host === 'localhost' || $host === '127.0.0.1')) {
    $fallback_user = 'root';
    $fallback_pass = '';
    $fallback_conn = @new mysqli($host, $fallback_user, $fallback_pass, $dbname);
    if (!$fallback_conn->connect_error) {
        $conn = $fallback_conn;
        $user = $fallback_user;
        $pass = $fallback_pass;
    }
}

if ($conn->connect_error) {
    $db_error = "Database Connection Failed: " . $conn->connect_error;
} else {
    $conn->set_charset("utf8mb4");
}

// 2. PDO Connection ($pdo)
$pdo = null;
try {
    $dsn = "mysql:host={$host};dbname={$dbname};charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    $pdo_error = $e->getMessage();
}
