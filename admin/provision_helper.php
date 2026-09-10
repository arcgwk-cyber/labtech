<?php
/**
 * Master Super Admin Lab Tenant Provisioning Helper
 * Clones template files from base/, creates database using dump/diagnostic_lab_db.sql,
 * configures tenant db.php, and provisions initial lab admin credentials and trial license.
 */

class LabProvisioner {

    public static function slugify($text) {
        $slug = preg_replace('~[^\pL\d]+~u', '_', $text);
        $slug = iconv('utf-8', 'us-ascii//TRANSLIT', $slug);
        $slug = preg_replace('~[^-\w]+~', '', $slug);
        $slug = trim($slug, '_');
        $slug = preg_replace('~_+~', '_', $slug);
        $slug = strtolower($slug);
        return empty($slug) ? 'lab_' . time() : $slug;
    }

    public static function copyDirectory($source, $destination) {
        if (!is_dir($source)) {
            return false;
        }

        if (!is_dir($destination)) {
            mkdir($destination, 0755, true);
        }

        $dir = opendir($source);
        while (($file = readdir($dir)) !== false) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            $srcPath = $source . DIRECTORY_SEPARATOR . $file;
            $dstPath = $destination . DIRECTORY_SEPARATOR . $file;

            if (is_dir($srcPath)) {
                self::copyDirectory($srcPath, $dstPath);
            } else {
                copy($srcPath, $dstPath);
            }
        }
        closedir($dir);
        return true;
    }

    public static function findUploadedAsset($relPath, $workspaceRoot) {
        if (empty($relPath)) return null;
        $rel = ltrim($relPath, '/\\');
        $base = basename($rel);

        $candidates = [
            $workspaceRoot . '/' . $rel,
            $workspaceRoot . '/uploads/' . $base,
            $workspaceRoot . '/base/' . $rel,
            $workspaceRoot . '/base/uploads/' . $base,
            $workspaceRoot . '/demo/' . $rel,
            $workspaceRoot . '/demo/uploads/' . $base,
            $workspaceRoot . '/admin/' . $rel,
            $workspaceRoot . '/admin/uploads/' . $base,
            $workspaceRoot . '/uploads/vendors/' . $base,
            dirname($workspaceRoot) . '/' . $rel,
            dirname($workspaceRoot) . '/uploads/' . $base
        ];

        foreach ($candidates as $cand) {
            if (file_exists($cand) && is_file($cand)) {
                return $cand;
            }
        }
        return null;
    }

    public static function installLabAssets($logoSrc, $letterheadSrc, $targetLabDir) {
        $targetQrtemp  = $targetLabDir . '/qrtemp';
        $targetUploads = $targetLabDir . '/uploads';
        if (!is_dir($targetQrtemp))  { @mkdir($targetQrtemp, 0755, true); }
        if (!is_dir($targetUploads)) { @mkdir($targetUploads, 0755, true); }

        if (!empty($logoSrc) && file_exists($logoSrc)) {
            $ext = strtolower(pathinfo($logoSrc, PATHINFO_EXTENSION));
            if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) $ext = 'jpg';
            @copy($logoSrc, $targetQrtemp . '/logo.' . $ext);
            @copy($logoSrc, $targetQrtemp . '/logo.jpg');
            @copy($logoSrc, $targetUploads . '/logo.' . $ext);
            @copy($logoSrc, $targetUploads . '/logo.jpg');
            @copy($logoSrc, $targetLabDir . '/logo.' . $ext);
            @copy($logoSrc, $targetLabDir . '/logo.jpg');
        }

        if (!empty($letterheadSrc) && file_exists($letterheadSrc)) {
            $ext = strtolower(pathinfo($letterheadSrc, PATHINFO_EXTENSION));
            if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) $ext = 'jpg';
            @copy($letterheadSrc, $targetQrtemp . '/letterhead.' . $ext);
            @copy($letterheadSrc, $targetQrtemp . '/letterhead.jpg');
            @copy($letterheadSrc, $targetUploads . '/letterhead.' . $ext);
            @copy($letterheadSrc, $targetUploads . '/letterhead.jpg');
            @copy($letterheadSrc, $targetLabDir . '/letterhead.' . $ext);
            @copy($letterheadSrc, $targetLabDir . '/letterhead.jpg');
        }
    }

    /**
     * Connect to an existing database directly without attempting CREATE DATABASE.
     * Tries candidate credentials (custom user/pass, master .env credentials, root fallback).
     * Returns active PDO instance along with working username and password.
     */
    public static function connectDatabase($host, $customUser, $customPass, $db_name) {
        $envUser = getenv('DB_USER') ?: '';
        $envPass = getenv('DB_PASS') !== false ? getenv('DB_PASS') : '';

        // Build list of candidate credentials to try connecting directly to $db_name
        $candidates = [];

        // 1. Specified custom credentials (if provided)
        if (!empty($customUser)) {
            if ($customPass !== '') {
                $candidates[] = ['user' => $customUser, 'pass' => $customPass, 'label' => "Specified User '{$customUser}'"];
            } else {
                // If custom password was left empty, try with env password and with blank password
                if ($envPass !== '') {
                    $candidates[] = ['user' => $customUser, 'pass' => $envPass, 'label' => "User '{$customUser}' with default password"];
                }
                $candidates[] = ['user' => $customUser, 'pass' => '', 'label' => "User '{$customUser}' with empty password"];
            }
        }

        // 2. Master environment credentials (.env DB_USER & DB_PASS)
        if (!empty($envUser)) {
            $candidates[] = ['user' => $envUser, 'pass' => $envPass, 'label' => "Master User '{$envUser}'"];
        }

        // 3. Localhost root fallback
        if ($host === 'localhost' || $host === '127.0.0.1') {
            $candidates[] = ['user' => 'root', 'pass' => '', 'label' => "Local 'root' user"];
        }

        // De-duplicate candidates by user+pass
        $uniqueCandidates = [];
        $seen = [];
        foreach ($candidates as $c) {
            $key = $c['user'] . ':::' . $c['pass'];
            if (!isset($seen[$key])) {
                $seen[$key] = true;
                $uniqueCandidates[] = $c;
            }
        }

        $connectionErrors = [];

        // Connect directly to the database without attempting CREATE DATABASE
        foreach ($uniqueCandidates as $cand) {
            try {
                $pdo = new PDO("mysql:host={$host};dbname={$db_name};charset=utf8mb4", $cand['user'], $cand['pass'], [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ]);
                return [
                    'success'         => true,
                    'pdo'             => $pdo,
                    'already_existed' => true,
                    'working_user'    => $cand['user'],
                    'working_pass'    => $cand['pass'],
                ];
            } catch (PDOException $e) {
                $cleanMsg = preg_replace('/\s*\(using password:.*?\)/i', '', $e->getMessage());
                $connectionErrors[] = "{$cand['label']}: " . $cleanMsg;
            }
        }

        // If local dev environment (localhost with root) and DB doesn't exist, allow auto-create only locally
        $isLocalhost = ($host === 'localhost' || $host === '127.0.0.1');
        $isRemoteOrPrefixed = (!empty($envUser) && strpos($envUser, '_') !== false) || strpos($db_name, '_') !== false;

        if ($isLocalhost && !$isRemoteOrPrefixed) {
            try {
                $rootPdo = new PDO("mysql:host={$host}", 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
                $rootPdo->exec("CREATE DATABASE IF NOT EXISTS `{$db_name}` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;");
                $pdo = new PDO("mysql:host={$host};dbname={$db_name};charset=utf8mb4", 'root', '', [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ]);
                return [
                    'success'         => true,
                    'pdo'             => $pdo,
                    'already_existed' => false,
                    'working_user'    => 'root',
                    'working_pass'    => '',
                ];
            } catch (Exception $e) {
                // Ignore local create error and report connection failure below
            }
        }

        // Friendly, actionable error for Hostinger / Shared hosting
        $errSummary = implode("<br>&bull; ", array_map('htmlspecialchars', $connectionErrors));
        $effectiveUser = !empty($customUser) ? htmlspecialchars($customUser) : htmlspecialchars($envUser);
        $masterUser = htmlspecialchars($envUser);

        $errorMsg = "Could not connect to pre-created database `{$db_name}` on `{$host}`.<br><br>" .
                    "<strong>Connection attempts:</strong><br>&bull; {$errSummary}<br><br>" .
                    "<strong>How to resolve in Hostinger hPanel:</strong><br>" .
                    "1. Confirm that database <code>{$db_name}</code> exists in Hostinger hPanel &rarr; Databases.<br>" .
                    "2. If you created a dedicated user <code>{$effectiveUser}</code> in Hostinger, enter its password in the <em>Database Password</em> field.<br>" .
                    "3. Or in Hostinger hPanel &rarr; Databases, assign master user <code>{$masterUser}</code> to database <code>{$db_name}</code> with <strong>ALL PRIVILEGES</strong>.";

        return [
            'success' => false,
            'error'   => $errorMsg
        ];
    }

    public static function createDatabase($host, $user, $pass, $db_name) {
        return self::connectDatabase($host, $user, $pass, $db_name);
    }

    public static function importSqlFile($pdo, $sqlFilePath) {
        if (!file_exists($sqlFilePath)) {
            return ['success' => false, 'error' => "SQL file not found at: {$sqlFilePath}"];
        }

        $sql = file_get_contents($sqlFilePath);
        $sql = preg_replace('/--.*$/m', '', $sql);
        $sql = preg_replace('/\/\*.*?\*\//s', '', $sql);

        $queries = preg_split('/;\s*[\r\n]+/', $sql);

        $executed = 0;
        foreach ($queries as $query) {
            $q = trim($query);
            if (!empty($q)) {
                try {
                    $pdo->exec($q);
                    $executed++;
                } catch (PDOException $e) {
                    if (strpos($e->getMessage(), 'already exists') === false &&
                        strpos($e->getMessage(), 'Duplicate') === false) {
                        // ignore benign warnings
                    }
                }
            }
        }
        return ['success' => true, 'queries_executed' => $executed];
    }

    public static function writeDbConfigFile($targetFilePath, $host, $user, $pass, $db_name) {
        $escHost = addcslashes($host, "'\\");
        $escUser = addcslashes($user, "'\\");
        $escPass = addcslashes($pass, "'\\");
        $escDb   = addcslashes($db_name, "'\\");

        $configContent = "<?php
/**
 * Auto-generated Database Connection for Tenant Lab
 * Provisioned: " . date('Y-m-d H:i:s') . "
 */

\$host = '{$escHost}';
\$user = '{$escUser}';
\$pass = '{$escPass}';
\$dbname = '{$escDb}';

// 1. Initialize MySQLi connection (\$conn)
mysqli_report(MYSQLI_REPORT_OFF);
\$conn = @new mysqli(\$host, \$user, \$pass, \$dbname);

if (\$conn->connect_error) {
    if (\$host === 'localhost' || \$host === '127.0.0.1') {
        \$fallback_conn = @new mysqli(\$host, 'root', '', \$dbname);
        if (!\$fallback_conn->connect_error) {
            \$conn = \$fallback_conn;
            \$user = 'root';
            \$pass = '';
        }
    }
}

if (\$conn->connect_error) {
    \$db_error = 'Database Connection Failed: ' . \$conn->connect_error;
} else {
    \$conn->set_charset('utf8mb4');
}

// 2. Initialize PDO connection (\$pdo)
\$pdo = null;
try {
    \$dsn = \"mysql:host={\$host};dbname={\$dbname};charset=utf8mb4\";
    \$options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    \$pdo = new PDO(\$dsn, \$user, \$pass, \$options);
} catch (PDOException \$e) {
    if (\$host === 'localhost' || \$host === '127.0.0.1') {
        try {
            \$pdo = new PDO(\"mysql:host={\$host};dbname={\$dbname};charset=utf8mb4\", 'root', '', \$options);
        } catch (PDOException \$e2) {
            \$pdo = null;
        }
    }
}
";
        return file_put_contents($targetFilePath, $configContent) !== false;
    }

    public static function seedTenantAdminUser($pdoTenant, $username, $password, $fullName) {
        try {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            
            // Check if admin exists
            $stmt = $pdoTenant->prepare("SELECT user_id FROM users WHERE username = ?");
            $stmt->execute([$username]);
            if ($row = $stmt->fetch()) {
                $updateStmt = $pdoTenant->prepare("UPDATE users SET password_hash = ?, full_name = ?, status = 'active' WHERE user_id = ?");
                $updateStmt->execute([$hashedPassword, $fullName, $row['user_id']]);
            } else {
                $insertStmt = $pdoTenant->prepare("INSERT INTO users (username, password_hash, full_name, role_id, status) VALUES (?, ?, ?, 1, 'active')");
                $insertStmt->execute([$username, $hashedPassword, $fullName]);
            }
            return ['success' => true];
        } catch (PDOException $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public static function provisionLab($vendor, $customSlug = '', $customDbName = '', $customUser = '', $customPass = '', $trialDays = 14, $customDbUser = '', $customDbPass = '', $stateCode = '') {
        $workspaceRoot = dirname(__DIR__); // g:/LABTECH
        $baseTemplateDir = $workspaceRoot . '/base';
        $dumpSqlPath = $workspaceRoot . '/dump/diagnostic_lab_db.sql';

        if (!is_dir($baseTemplateDir)) {
            return ['success' => false, 'error' => "Base template folder not found at: {$baseTemplateDir}"];
        }
        if (!file_exists($dumpSqlPath)) {
            return ['success' => false, 'error' => "Master dump SQL not found at: {$dumpSqlPath}"];
        }

        $rawSlug = !empty($customSlug) ? self::slugify($customSlug) : self::slugify($vendor['name'] ?? 'lab');
        $state = strtolower(trim($stateCode));
        if (empty($state) && !empty($vendor['remarks']) && preg_match('/(?:State|Region):\s*([a-zA-Z]{2})/i', $vendor['remarks'], $sm)) {
            $state = strtolower($sm[1]);
        }
        // Default state fallback if not specified: 'ap'
        if (empty($state)) {
            $state = 'ap';
        }

        // If customSlug already starts with a known state prefix (e.g. ap/medione), normalize it
        if (preg_match('~^([a-zA-Z]{2})[\\/](.+)$~', $rawSlug, $nm)) {
            $state = strtolower($nm[1]);
            $rawSlug = self::slugify($nm[2]);
        }

        $fullSlug = $state . '/' . $rawSlug;
        $targetLabDir = $workspaceRoot . '/' . $state . '/' . $rawSlug;

        // Ensure state folder exists
        $stateDir = $workspaceRoot . '/' . $state;
        if (!is_dir($stateDir)) {
            @mkdir($stateDir, 0755, true);
            @file_put_contents($stateDir . '/.gitkeep', ' ');
        }

        // 1. Clone base/ directory
        $copyResult = self::copyDirectory($baseTemplateDir, $targetLabDir);
        if (!$copyResult) {
            return ['success' => false, 'error' => "Failed to copy base blueprint files to {$targetLabDir}."];
        }

        // 2. Database credentials & connection
        $dbHost = getenv('DB_HOST') ?: 'localhost';
        $dbName = !empty($customDbName) ? $customDbName : 'lab_' . $rawSlug;

        // 3. Connect to pre-created tenant database directly
        $dbConnRes = self::connectDatabase($dbHost, $customDbUser, $customDbPass, $dbName);
        if (!$dbConnRes['success']) {
            return ['success' => false, 'error' => $dbConnRes['error']];
        }

        $pdoTenant   = $dbConnRes['pdo'];
        $workingUser = $dbConnRes['working_user'];
        $workingPass = $dbConnRes['working_pass'];

        // 4. Check if tables already exist
        $stmtTables = $pdoTenant->query("SHOW TABLES");
        $existingTables = $stmtTables ? $stmtTables->fetchAll(PDO::FETCH_COLUMN) : [];
        $hasTables = !empty($existingTables);

        if (!$hasTables) {
            // Import master schema & clinical catalog if database is empty
            $importRes = self::importSqlFile($pdoTenant, $dumpSqlPath);
            if (!$importRes['success']) {
                return ['success' => false, 'error' => "Failed during SQL import: " . $importRes['error']];
            }

            // Purge demo operational / patient / billing data so the new lab starts 100% fresh!
            // All clinical master test catalogs, parameter ranges, and reporting templates are preserved.
            $tablesToPurge = [
                'bills',
                'bill_packages',
                'bill_tests',
                'patients',
                'patient_extra_info',
                'test_results',
                'test_samples',
                'transactions',
                'sign_master',
                'users'
            ];

            try {
                $pdoTenant->exec("SET FOREIGN_KEY_CHECKS = 0;");
                foreach ($tablesToPurge as $tbl) {
                    try {
                        $pdoTenant->exec("TRUNCATE TABLE `{$tbl}`;");
                    } catch (PDOException $ex) {
                        $pdoTenant->exec("DELETE FROM `{$tbl}`;");
                        @$pdoTenant->exec("ALTER TABLE `{$tbl}` AUTO_INCREMENT = 1;");
                    }
                }
                $pdoTenant->exec("SET FOREIGN_KEY_CHECKS = 1;");
            } catch (Exception $e) {
                // Non-fatal warning
            }
        } elseif (!in_array('users', $existingTables) || !in_array('admin_settings', $existingTables)) {
            // If some tables exist but critical schema is missing, run import
            $importRes = self::importSqlFile($pdoTenant, $dumpSqlPath);
            if (!$importRes['success']) {
                return ['success' => false, 'error' => "Failed during SQL import: " . $importRes['error']];
            }
        }

        // 4c. Setup fresh upload folders & copy uploaded Logo and Letterhead
        $logoSrc = self::findUploadedAsset($vendor['logo_image'] ?? '', $workspaceRoot);
        $letterheadSrc = self::findUploadedAsset($vendor['letterhead_image'] ?? '', $workspaceRoot);
        self::installLabAssets($logoSrc, $letterheadSrc, $targetLabDir);

        // 5. Write tenant db.php
        $targetDbPhp = $targetLabDir . '/db.php';
        $writeRes = self::writeDbConfigFile($targetDbPhp, $dbHost, $workingUser, $workingPass, $dbName);
        if (!$writeRes) {
            return ['success' => false, 'error' => "Failed writing config to {$targetDbPhp}."];
        }

        // 6. Seed tenant admin credentials
        $adminUsername = !empty($customUser) ? $customUser : ($vendor['vendor_userid'] ?? 'admin_' . $rawSlug);
        $adminPassword = !empty($customPass) ? $customPass : ($vendor['password'] ?? 'Lab@' . rand(1000, 9999));
        $adminFullName = $vendor['name'] ?? 'Lab Administrator';

        $seedRes = self::seedTenantAdminUser($pdoTenant, $adminUsername, $adminPassword, $adminFullName);
        if (!$seedRes['success']) {
            return ['success' => false, 'error' => "Database configured, but seeding initial admin failed: " . $seedRes['error']];
        }

        // 7. Calculate trial expiry date
        $dueDate = date('Y-m-d', strtotime("+{$trialDays} days"));

        // 8. Configure tenant admin_settings with the real lab details
        try {
            $labName = !empty($vendor['name']) ? trim($vendor['name']) : 'Diagnostic Centre';
            $labAddr = !empty($vendor['address']) ? trim($vendor['address']) : '';
            $labPhone = !empty($vendor['phone']) ? trim($vendor['phone']) : '';
            $labEmail = !empty($vendor['email']) ? trim($vendor['email']) : '';

            // Ensure columns exist in tenant's admin_settings table if needed
            $cols = $pdoTenant->query("DESCRIBE admin_settings")->fetchAll(PDO::FETCH_COLUMN);
            if (!in_array('lab_slug', $cols)) {
                @$pdoTenant->exec("ALTER TABLE admin_settings ADD COLUMN lab_slug VARCHAR(100) DEFAULT NULL AFTER id");
                @$pdoTenant->exec("ALTER TABLE admin_settings ADD INDEX (lab_slug)");
            }
            if (!in_array('phone', $cols)) {
                @$pdoTenant->exec("ALTER TABLE admin_settings ADD COLUMN phone VARCHAR(50) DEFAULT NULL");
            }
            if (!in_array('email', $cols)) {
                @$pdoTenant->exec("ALTER TABLE admin_settings ADD COLUMN email VARCHAR(100) DEFAULT NULL");
            }
            if (!in_array('status', $cols)) {
                @$pdoTenant->exec("ALTER TABLE admin_settings ADD COLUMN status VARCHAR(20) DEFAULT 'active'");
            }
            if (!in_array('expiry_date', $cols)) {
                @$pdoTenant->exec("ALTER TABLE admin_settings ADD COLUMN expiry_date DATE DEFAULT NULL");
            }
            if (!in_array('grace_days', $cols)) {
                @$pdoTenant->exec("ALTER TABLE admin_settings ADD COLUMN grace_days INT DEFAULT 7");
            }

            // Refresh available columns
            $cols = $pdoTenant->query("DESCRIBE admin_settings")->fetchAll(PDO::FETCH_COLUMN);

            // Check if existing record with this lab_slug exists (check both fullSlug and rawSlug)
            $stmtSlug = $pdoTenant->prepare("SELECT id FROM admin_settings WHERE lab_slug = ? OR lab_slug = ? LIMIT 1");
            $stmtSlug->execute([$fullSlug, $rawSlug]);
            $existingSlug = $stmtSlug->fetch();

            if ($existingSlug) {
                $fields = ["company_name = ?", "company_address = ?", "lab_slug = ?"];
                $params = [$labName, $labAddr, $fullSlug];
                if (in_array('phone', $cols)) { $fields[] = "phone = ?"; $params[] = $labPhone; }
                if (in_array('email', $cols)) { $fields[] = "email = ?"; $params[] = $labEmail; }
                if (in_array('status', $cols)) { $fields[] = "status = 'active'"; }
                if (in_array('expiry_date', $cols)) { $fields[] = "expiry_date = ?"; $params[] = $dueDate; }
                if (in_array('grace_days', $cols)) { $fields[] = "grace_days = 7"; }
                $params[] = $existingSlug['id'];
                $sql = "UPDATE admin_settings SET " . implode(", ", $fields) . " WHERE id = ?";
                $pdoTenant->prepare($sql)->execute($params);
            } else {
                $totalRows = (int)$pdoTenant->query("SELECT COUNT(*) FROM admin_settings")->fetchColumn();
                if ($totalRows === 0) {
                    $pdoTenant->prepare("INSERT INTO admin_settings (id, company_name, company_address, phone, email, lab_slug, status, expiry_date, grace_days) 
                                        VALUES (1, ?, ?, ?, ?, ?, 'active', ?, 7)")
                              ->execute([$labName, $labAddr, $labPhone, $labEmail, $fullSlug, $dueDate]);
                } else {
                    // Shared DB: insert separate tenant row so other labs (e.g. Amma Diagnostic Centre demo) are untouched!
                    $pdoTenant->prepare("INSERT INTO admin_settings (company_name, company_address, phone, email, lab_slug, status, expiry_date, grace_days) 
                                        VALUES (?, ?, ?, ?, ?, 'active', ?, 7)")
                              ->execute([$labName, $labAddr, $labPhone, $labEmail, $fullSlug, $dueDate]);
                }
            }
        } catch (Exception $e) {
            // Non-fatal warning
        }

        return [
            'success'        => true,
            'folder_slug'    => $fullSlug,
            'raw_slug'       => $rawSlug,
            'state'          => $state,
            'folder_path'    => $targetLabDir,
            'db_name'        => $dbName,
            'admin_username' => $adminUsername,
            'admin_password' => $adminPassword,
            'due_date'       => $dueDate,
            'login_url'      => "../{$fullSlug}/login.php"
        ];
    }
}
