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

// Check for .env in current directory, parent directory, or grandparent directory (for state folders e.g. /ap/medione/)
$possible_env_paths = [
    __DIR__ . '/.env',
    dirname(__DIR__) . '/.env',
    dirname(dirname(__DIR__)) . '/.env'
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

// 1. MySQLi Connection ($conn) with fast connection timeout (prevents hanging on slow/overloaded host)
mysqli_report(MYSQLI_REPORT_OFF);
$conn = mysqli_init();
if ($conn) {
    $conn->options(MYSQLI_OPT_CONNECT_TIMEOUT, 3);
    @$conn->real_connect($host, $user, $pass, $dbname);
}

// Local fallback attempt if default credentials fail (common in local XAMPP/WAMP dev)
if (($conn->connect_error || !$conn) && ($host === 'localhost' || $host === '127.0.0.1')) {
    $fallback_user = 'root';
    $fallback_pass = '';
    $fallback_conn = mysqli_init();
    if ($fallback_conn) {
        $fallback_conn->options(MYSQLI_OPT_CONNECT_TIMEOUT, 2);
        @$fallback_conn->real_connect($host, $fallback_user, $fallback_pass, $dbname);
        if (!$fallback_conn->connect_error) {
            $conn = $fallback_conn;
            $user = $fallback_user;
            $pass = $fallback_pass;
        } else {
            // Also try fallback to 'diagnostic_lab_db' if the configured dbname failed
            $alt_dbname = 'diagnostic_lab_db';
            if ($dbname !== $alt_dbname) {
                $alt_conn = mysqli_init();
                if ($alt_conn) {
                    $alt_conn->options(MYSQLI_OPT_CONNECT_TIMEOUT, 2);
                    @$alt_conn->real_connect($host, $fallback_user, $fallback_pass, $alt_dbname);
                    if (!$alt_conn->connect_error) {
                        $conn = $alt_conn;
                        $user = $fallback_user;
                        $pass = $fallback_pass;
                        $dbname = $alt_dbname;
                    }
                }
            }
        }
    }
}

if (!$conn || $conn->connect_error) {
    $db_error = "Database Connection Failed: " . ($conn ? $conn->connect_error : 'Initialization error');
} else {
    $conn->set_charset("utf8mb4");

    // Auto-migration & standard medical formula seeder for Dynamic Formula Engine (cached in session)
    if (!function_exists('ensureFormulaEngineSchema')) {
        function ensureFormulaEngineSchema($conn) {
            if (!$conn || $conn->connect_error) return;
            static $checked = false;
            if ($checked) return;
            $checked = true;

            // Avoid expensive SHOW COLUMNS metadata locks on every request
            if (session_status() === PHP_SESSION_ACTIVE && !empty($_SESSION['formula_schema_checked'])) {
                return;
            }

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

            if (session_status() === PHP_SESSION_ACTIVE) {
                $_SESSION['formula_schema_checked'] = true;
            }
        }
    }
    ensureFormulaEngineSchema($conn);

    // Auto-migration for Bill Cancellation & Modification-Locking Workflow
    if (!function_exists('ensureBillCancellationSchema')) {
        function ensureBillCancellationSchema($conn) {
            if (!$conn || $conn->connect_error) return;
            static $checked = false;
            if ($checked) return;
            $checked = true;

            if (session_status() === PHP_SESSION_ACTIVE && !empty($_SESSION['bill_cancel_schema_checked'])) {
                return;
            }

            $colsRes = $conn->query("SHOW COLUMNS FROM bills");
            if ($colsRes) {
                $existing = [];
                while ($c = $colsRes->fetch_assoc()) {
                    $existing[strtolower($c['Field'])] = true;
                }
                if (empty($existing['status'])) {
                    @$conn->query("ALTER TABLE bills ADD COLUMN status ENUM('active', 'cancelled') NOT NULL DEFAULT 'active' AFTER payment_status");
                    @$conn->query("ALTER TABLE bills ADD INDEX idx_bills_status (status)");
                }
                if (empty($existing['cancellation_status'])) {
                    @$conn->query("ALTER TABLE bills ADD COLUMN cancellation_status ENUM('none', 'requested', 'approved', 'rejected') NOT NULL DEFAULT 'none' AFTER status");
                    @$conn->query("ALTER TABLE bills ADD INDEX idx_bills_cancellation (cancellation_status)");
                }
                if (empty($existing['cancellation_reason'])) {
                    @$conn->query("ALTER TABLE bills ADD COLUMN cancellation_reason TEXT NULL AFTER cancellation_status");
                }
                if (empty($existing['cancellation_requested_by'])) {
                    @$conn->query("ALTER TABLE bills ADD COLUMN cancellation_requested_by INT(11) NULL AFTER cancellation_reason");
                }
                if (empty($existing['cancellation_requested_at'])) {
                    @$conn->query("ALTER TABLE bills ADD COLUMN cancellation_requested_at DATETIME NULL AFTER cancellation_requested_by");
                }
                if (empty($existing['cancelled_by'])) {
                    @$conn->query("ALTER TABLE bills ADD COLUMN cancelled_by INT(11) NULL AFTER cancellation_requested_at");
                }
                if (empty($existing['cancelled_at'])) {
                    @$conn->query("ALTER TABLE bills ADD COLUMN cancelled_at DATETIME NULL AFTER cancelled_by");
                }
                if (empty($existing['cancellation_admin_remarks'])) {
                    @$conn->query("ALTER TABLE bills ADD COLUMN cancellation_admin_remarks TEXT NULL AFTER cancelled_at");
                }
                if (empty($existing['report_printed'])) {
                    @$conn->query("ALTER TABLE bills ADD COLUMN report_printed TINYINT(1) NOT NULL DEFAULT 0 AFTER result_entered");
                }
                if (empty($existing['report_printed_at'])) {
                    @$conn->query("ALTER TABLE bills ADD COLUMN report_printed_at DATETIME NULL AFTER report_printed");
                }
                if (empty($existing['report_printed_by'])) {
                    @$conn->query("ALTER TABLE bills ADD COLUMN report_printed_by INT(11) NULL AFTER report_printed_at");
                }
            }

            if (session_status() === PHP_SESSION_ACTIVE) {
                $_SESSION['bill_cancel_schema_checked'] = true;
            }
        }
    }
    ensureBillCancellationSchema($conn);

    // Auto-migration for Billing, Payment, and Report Options
    if (!function_exists('ensureBillingAndReportSchema')) {
        function ensureBillingAndReportSchema($conn) {
            if (!$conn || $conn->connect_error) return;
            static $checked = false;
            if ($checked) return;
            $checked = true;

            if (session_status() === PHP_SESSION_ACTIVE && !empty($_SESSION['billing_schema_checked'])) {
                return;
            }

            // 1. Add discount & payment_mode to bills
            $colsRes = $conn->query("SHOW COLUMNS FROM bills");
            if ($colsRes) {
                $existing = [];
                while ($c = $colsRes->fetch_assoc()) {
                    $existing[strtolower($c['Field'])] = true;
                }
                if (empty($existing['discount'])) {
                    @$conn->query("ALTER TABLE bills ADD COLUMN discount DECIMAL(10,2) NOT NULL DEFAULT 0.00 AFTER total_amount");
                }
                if (empty($existing['payment_mode'])) {
                    @$conn->query("ALTER TABLE bills ADD COLUMN payment_mode VARCHAR(50) NOT NULL DEFAULT 'Cash' AFTER payment_status");
                }
                if (empty($existing['patient_type_id'])) {
                    @$conn->query("ALTER TABLE bills ADD COLUMN patient_type_id INT(11) NULL DEFAULT NULL AFTER payment_mode");
                    @$conn->query("ALTER TABLE bills ADD INDEX idx_bills_patient_type (patient_type_id)");
                }
            }

            // 1b. Add age & dr_ref to patients if missing
            $pColsRes = $conn->query("SHOW COLUMNS FROM patients");
            if ($pColsRes) {
                $pExisting = [];
                while ($pc = $pColsRes->fetch_assoc()) {
                    $pExisting[strtolower($pc['Field'])] = true;
                }
                if (empty($pExisting['age'])) {
                    @$conn->query("ALTER TABLE patients ADD COLUMN age INT(11) NULL DEFAULT NULL AFTER gender");
                }
                if (empty($pExisting['dr_ref'])) {
                    @$conn->query("ALTER TABLE patients ADD COLUMN dr_ref VARCHAR(150) NULL DEFAULT NULL AFTER address");
                }
            }

            // 2. Ensure test_id column exists in test_results
            $trCols = $conn->query("SHOW COLUMNS FROM test_results LIKE 'test_id'");
            if ($trCols && $trCols->num_rows === 0) {
                @$conn->query("ALTER TABLE test_results ADD COLUMN test_id INT(11) NULL DEFAULT NULL AFTER parameter_id");
                @$conn->query("ALTER TABLE test_results ADD INDEX idx_tr_test_id (test_id)");
            }

            // 2b. Ensure reference_text columns in parameter_reference_ranges
            $prrCols = $conn->query("SHOW COLUMNS FROM parameter_reference_ranges LIKE 'use_reference_text'");
            if ($prrCols && $prrCols->num_rows === 0) {
                @$conn->query("ALTER TABLE parameter_reference_ranges ADD COLUMN use_reference_text TINYINT(1) DEFAULT 0 AFTER child_default, ADD COLUMN reference_text TEXT NULL AFTER use_reference_text");
            }

            // 2c. Ensure param_order and section_name in lab_test_parameters
            $ltpCols = $conn->query("SHOW COLUMNS FROM lab_test_parameters LIKE 'param_order'");
            if ($ltpCols && $ltpCols->num_rows === 0) {
                @$conn->query("ALTER TABLE lab_test_parameters ADD COLUMN param_order INT(11) NOT NULL DEFAULT 0 AFTER parameter_id, ADD COLUMN section_name VARCHAR(100) NULL DEFAULT NULL AFTER param_order");
            }

            // 3. Ensure bill_report_options table exists
            @$conn->query("
                CREATE TABLE IF NOT EXISTS `bill_report_options` (
                  `bill_id` int(11) NOT NULL PRIMARY KEY,
                  `style` varchar(32) DEFAULT 'clinical',
                  `header_mode` varchar(32) DEFAULT 'printed',
                  `include_method` tinyint(1) DEFAULT 0,
                  `include_notes` tinyint(1) DEFAULT 1,
                  `include_interpretation` tinyint(1) DEFAULT 1,
                  `pagebreak_per_test` tinyint(1) DEFAULT 0,
                  `include_signature` tinyint(1) DEFAULT 1,
                  `top_margin` decimal(5,2) DEFAULT 55.00,
                  `bottom_margin` decimal(5,2) DEFAULT 35.00,
                  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
            ");

            // 4. Backfill missing test_id in test_results using lab_test_parameters or bill_tests
            @$conn->query("
                UPDATE test_results r
                JOIN lab_test_parameters ltp ON r.parameter_id = ltp.parameter_id
                SET r.test_id = ltp.test_id
                WHERE (r.test_id IS NULL OR r.test_id = 0)
            ");
            @$conn->query("
                UPDATE test_results r
                JOIN bill_tests bt ON r.bill_id = bt.bill_id
                SET r.test_id = bt.test_id
                WHERE (r.test_id IS NULL OR r.test_id = 0)
            ");

            if (session_status() === PHP_SESSION_ACTIVE) {
                $_SESSION['billing_schema_checked'] = true;
            }
        }
    }
    ensureBillingAndReportSchema($conn);
}

// 2. PDO Connection ($pdo) - Lazy loaded only when needed to cut DB connection overhead by 50%
$pdo = null;
$currentScript = basename($_SERVER['PHP_SELF'] ?? '');
$needsPdo = in_array($currentScript, ['renew.php', 'vendor_dashboard.php', 'vendor_login_action.php', 'vendor_auto_deactivate.php', 'provision_helper.php']);

if ($needsPdo) {
    try {
        $dsn = "mysql:host={$host};dbname={$dbname};charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::ATTR_TIMEOUT            => 3,
        ];
        $pdo = new PDO($dsn, $user, $pass, $options);
    } catch (PDOException $e) {
        $pdo_error = $e->getMessage();
    }
}
