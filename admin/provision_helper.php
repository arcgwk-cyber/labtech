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
            @copy($letterheadSrc, $targetLabDir . '/ammaletterhead.jpg');
        }
    }

    public static function createDatabase($host, $user, $pass, $db_name) {
        $firstErr = '';
        try {
            $pdoExisting = new PDO("mysql:host={$host};dbname={$db_name};charset=utf8mb4", $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
            return ['success' => true, 'pdo' => $pdoExisting, 'already_existed' => true];
        } catch (PDOException $e) {
            $firstErr = $e->getMessage();
            // If connection failed because database doesn't exist (1049 Unknown database), we try to CREATE it.
            // If it failed due to bad user/pass (1045), return error immediately.
            if ($e->getCode() == 1045) {
                return ['success' => false, 'error' => "MySQL Authentication failed for user '{$user}': " . $e->getMessage()];
            }
        }

        // Second: attempt CREATE DATABASE
        try {
            $pdo = new PDO("mysql:host={$host}", $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$db_name}` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;");
            return ['success' => true, 'pdo' => $pdo, 'already_existed' => false];
        } catch (PDOException $e) {
            $msg = $e->getMessage();
            // Check for error 1044 (Access denied to database / CREATE DATABASE not allowed on shared hosting)
            if (strpos($msg, '1044') !== false || strpos($msg, 'Access denied') !== false) {
                $userPrefix = '';
                if (preg_match('/^([a-zA-Z0-9]+_)/', $user, $m)) {
                    $userPrefix = $m[1];
                }
                // Avoid duplicating prefix if db_name already starts with prefix
                $expectedDbName = $db_name;
                if ($userPrefix && strpos($expectedDbName, $userPrefix) !== 0) {
                    $expectedDbName = $userPrefix . $expectedDbName;
                }

                $connectErr = isset($firstErr) ? " (Connection check failed: {$firstErr})" : "";
                return [
                    'success' => false, 
                    'error' => "Cannot access database `{$db_name}`{$connectErr}. On Hostinger/Shared hosting, MySQL users cannot create arbitrary databases via PHP scripts. " .
                               "Please create the database `{$expectedDbName}` in Hostinger hPanel → Databases, assign user `{$user}` to it with ALL privileges, and then approve with database name `{$expectedDbName}`."
                ];
            }
            return ['success' => false, 'error' => $msg];
        }
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
        $configContent = "<?php
/**
 * Auto-generated Database Connection for Tenant Lab
 * Provisioned: " . date('Y-m-d H:i:s') . "
 */

\$host = '{$host}';
\$user = '{$user}';
\$pass = '{$pass}';
\$dbname = '{$db_name}';

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

    public static function provisionLab($vendor, $customSlug = '', $customDbName = '', $customUser = '', $customPass = '', $trialDays = 14, $customDbUser = '', $customDbPass = '') {
        $workspaceRoot = dirname(__DIR__); // g:/LABTECH
        $baseTemplateDir = $workspaceRoot . '/base';
        $dumpSqlPath = $workspaceRoot . '/dump/diagnostic_lab_db.sql';

        if (!is_dir($baseTemplateDir)) {
            return ['success' => false, 'error' => "Base template folder not found at: {$baseTemplateDir}"];
        }
        if (!file_exists($dumpSqlPath)) {
            return ['success' => false, 'error' => "Master dump SQL not found at: {$dumpSqlPath}"];
        }

        $slug = !empty($customSlug) ? self::slugify($customSlug) : self::slugify($vendor['name'] ?? 'lab');
        $targetLabDir = $workspaceRoot . '/' . $slug;

        // 1. Clone base/ directory
        $copyResult = self::copyDirectory($baseTemplateDir, $targetLabDir);
        if (!$copyResult) {
            return ['success' => false, 'error' => "Failed to copy base blueprint files to {$targetLabDir}."];
        }

        // 2. Database credentials
        $dbHost = getenv('DB_HOST') ?: 'localhost';
        $dbUser = !empty($customDbUser) ? $customDbUser : (getenv('DB_USER') ?: 'root');
        $dbPass = !empty($customDbPass) ? $customDbPass : (getenv('DB_PASS') !== false ? getenv('DB_PASS') : '');
        $dbName = !empty($customDbName) ? $customDbName : 'lab_' . $slug;

        // 3. Create tenant database (or connect to pre-created database)
        $dbCreateRes = self::createDatabase($dbHost, $dbUser, $dbPass, $dbName);
        if (!$dbCreateRes['success']) {
            return ['success' => false, 'error' => "Could not create database `{$dbName}`: " . $dbCreateRes['error']];
        }

        // 4. Import seed SQL
        try {
            $pdoTenant = new PDO("mysql:host={$dbHost};dbname={$dbName};charset=utf8mb4", $dbUser, $dbPass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
        } catch (PDOException $e) {
            return ['success' => false, 'error' => "Connected to MySQL but cannot select database `{$dbName}`: " . $e->getMessage()];
        }

        $importRes = self::importSqlFile($pdoTenant, $dumpSqlPath);
        if (!$importRes['success']) {
            return ['success' => false, 'error' => "Failed during SQL import: " . $importRes['error']];
        }

        // 4b. Purge demo operational / patient / billing data so the new lab starts 100% fresh!
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

        // 4c. Setup fresh upload folders & copy uploaded Logo and Letterhead
        $logoSrc = self::findUploadedAsset($vendor['logo_image'] ?? '', $workspaceRoot);
        $letterheadSrc = self::findUploadedAsset($vendor['letterhead_image'] ?? '', $workspaceRoot);
        self::installLabAssets($logoSrc, $letterheadSrc, $targetLabDir);

        // 5. Write tenant db.php
        $targetDbPhp = $targetLabDir . '/db.php';
        $writeRes = self::writeDbConfigFile($targetDbPhp, $dbHost, $dbUser, $dbPass, $dbName);
        if (!$writeRes) {
            return ['success' => false, 'error' => "Failed writing config to {$targetDbPhp}."];
        }

        // 6. Seed tenant admin credentials
        $adminUsername = !empty($customUser) ? $customUser : ($vendor['vendor_userid'] ?? 'admin_' . $slug);
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

            $stmtCheck = $pdoTenant->query("SELECT id FROM admin_settings WHERE id = 1");
            if ($stmtCheck && $stmtCheck->fetch()) {
                $fields = ["company_name = ?", "company_address = ?"];
                $params = [$labName, $labAddr];
                if (in_array('phone', $cols)) { $fields[] = "phone = ?"; $params[] = $labPhone; }
                if (in_array('email', $cols)) { $fields[] = "email = ?"; $params[] = $labEmail; }
                if (in_array('status', $cols)) { $fields[] = "status = 'active'"; }
                if (in_array('expiry_date', $cols)) { $fields[] = "expiry_date = ?"; $params[] = $dueDate; }
                if (in_array('grace_days', $cols)) { $fields[] = "grace_days = 7"; }
                
                $sql = "UPDATE admin_settings SET " . implode(", ", $fields) . " WHERE id = 1";
                $pdoTenant->prepare($sql)->execute($params);
            } else {
                $pdoTenant->prepare("INSERT INTO admin_settings (id, company_name, company_address) VALUES (1, ?, ?)")
                          ->execute([$labName, $labAddr]);
            }
        } catch (Exception $e) {
            // Non-fatal warning
        }

        return [
            'success'        => true,
            'folder_slug'    => $slug,
            'folder_path'    => $targetLabDir,
            'db_name'        => $dbName,
            'admin_username' => $adminUsername,
            'admin_password' => $adminPassword,
            'due_date'       => $dueDate,
            'login_url'      => "../{$slug}/login.php"
        ];
    }
}
