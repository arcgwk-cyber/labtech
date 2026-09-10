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

    // Auto-migration & standard medical formula seeder for Dynamic Formula Engine
    if (!function_exists('ensureFormulaEngineSchema')) {
        function ensureFormulaEngineSchema($conn) {
            if (!$conn || $conn->connect_error) return;
            static $checked = false;
            if ($checked) return;
            $checked = true;

            $checkCol = $conn->query("SHOW COLUMNS FROM test_parameters LIKE 'formula'");
            if ($checkCol && $checkCol->num_rows === 0) {
                @$conn->query("ALTER TABLE test_parameters ADD COLUMN formula VARCHAR(255) NULL DEFAULT NULL AFTER interpretation");
                @$conn->query("ALTER TABLE test_parameters ADD COLUMN formula_decimals TINYINT(2) DEFAULT 2 AFTER formula");

                $defaultFormulas = [
                    143 => ['formula' => '[PARAM_11] - [PARAM_12]', 'decimals' => 2], // Indirect Bilirubin
                    150 => ['formula' => '[PARAM_148] - [PARAM_149]', 'decimals' => 2], // Globulin
                    151 => ['formula' => '[PARAM_149] / [PARAM_150]', 'decimals' => 2], // A/G Ratio
                    123 => ['formula' => '[PARAM_104] / 5', 'decimals' => 2], // VLDL
                    103 => ['formula' => '[PARAM_101] - [PARAM_102] - [PARAM_123]', 'decimals' => 2], // LDL
                    124 => ['formula' => '[PARAM_101] / [PARAM_102]', 'decimals' => 2], // Total/HDL Ratio
                    125 => ['formula' => '[PARAM_103] / [PARAM_102]', 'decimals' => 2], // LDL/HDL Ratio
                    157 => ['formula' => '([PARAM_154] * 10) / [PARAM_177]', 'decimals' => 1], // MCH
                    158 => ['formula' => '([PARAM_154] * 100) / [PARAM_178]', 'decimals' => 1], // MCHC
                    164 => ['formula' => '[PARAM_161] / 2.14', 'decimals' => 2], // BUN
                    109 => ['formula' => '(28.7 * [PARAM_108]) - 46.7', 'decimals' => 1], // eAG
                    7   => ['formula' => '([PARAM_3] * [PARAM_17]) / 100', 'decimals' => 0], // AEC
                    43  => ['formula' => '([PARAM_41] / [PARAM_42]) * 100', 'decimals' => 1], // Transferrin Saturation
                    116 => ['formula' => 'pow(([PARAM_114] / [PARAM_115]), 1.0)', 'decimals' => 2], // INR
                ];
                foreach ($defaultFormulas as $pid => $fdata) {
                    @$conn->query("UPDATE test_parameters SET formula = '{$fdata['formula']}', formula_decimals = {$fdata['decimals']} WHERE parameter_id = {$pid} AND (formula IS NULL OR formula = '')");
                }
            }
        }
    }
    ensureFormulaEngineSchema($conn);
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
