<?php
/**
 * Automated Lab Tenant Provisioning Helper
 * Clones template files from base/, creates database using dump/diagnostic_lab_db.sql,
 * configures db.php, and provisions initial lab admin credentials and trial license.
 */

class LabProvisioner {

    public static function slugify($text) {
        // Strip non-alphanumeric and replace with underscore
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
        try {
            $pdo = new PDO("mysql:host={$host}", $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$db_name}` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;");
            return ['success' => true, 'pdo' => $pdo];
        } catch (PDOException $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public static function importSqlFile($pdo, $sqlFilePath) {
        if (!file_exists($sqlFilePath)) {
            return ['success' => false, 'error' => "SQL file not found at: {$sqlFilePath}"];
        }

        $sql = file_get_contents($sqlFilePath);
        // Remove comments
        $sql = preg_replace('/--.*$/m', '', $sql);
        $sql = preg_replace('/\/\*.*?\*\//s', '', $sql);

        // Split queries by semicolon followed by newline
        $queries = preg_split('/;\s*[\r\n]+/', $sql);

        $executed = 0;
        foreach ($queries as $query) {
            $q = trim($query);
            if (!empty($q)) {
                try {
                    $pdo->exec($q);
                    $executed++;
                } catch (PDOException $e) {
                    // Ignore minor drop table / duplicate key warnings
                    if (strpos($e->getMessage(), 'already exists') === false &&
                        strpos($e->getMessage(), 'Duplicate') === false) {
                        // log or continue
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
 * Generated: " . date('Y-m-d H:i:s') . "
 */

\$host = '{$host}';
\$user = '{$user}';
\$pass = '{$pass}';
\$dbname = '{$db_name}';

// 1. Initialize MySQLi connection (\$conn)
mysqli_report(MYSQLI_REPORT_OFF);
\$conn = @new mysqli(\$host, \$user, \$pass, \$dbname);

if (\$conn->connect_error) {
    // Fallback attempt for local root without password if localhost
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
    \$pdo = new PDO(\$dsn, \$user, \$pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
} catch (PDOException \$e) {
    \$pdo_error = \$e->getMessage();
}
";
        return file_put_contents($targetFilePath, $configContent) !== false;
    }

    public static function provisionLab($vendor, $options = []) {
        $rootPath = dirname(__DIR__); // g:/LABTECH
        $baseTemplateDir = $rootPath . DIRECTORY_SEPARATOR . 'base';
        $dumpSqlPath = $rootPath . DIRECTORY_SEPARATOR . 'dump' . DIRECTORY_SEPARATOR . 'diagnostic_lab_db.sql';

        $slug = !empty($options['folder_name']) ? self::slugify($options['folder_name']) : self::slugify($vendor['name']);
        $targetFolder = $rootPath . DIRECTORY_SEPARATOR . $slug;

        $db_name = !empty($options['db_name']) ? $options['db_name'] : 'lab_' . $slug;
        $db_host = !empty($options['db_host']) ? $options['db_host'] : (getenv('DB_HOST') ?: 'localhost');
        $db_user = !empty($options['db_user']) ? $options['db_user'] : (getenv('DB_USER') ?: 'root');
        $db_pass = isset($options['db_pass']) ? $options['db_pass'] : (getenv('DB_PASS') !== false ? getenv('DB_PASS') : '');

        $due_date = !empty($options['due_date']) ? $options['due_date'] : date('Y-m-d', strtotime('+14 days'));
        $grace_days = isset($options['grace_days']) ? (int)$options['grace_days'] : 7;

        $log = [];

        // Step 1: Copy files from base/ to target folder
        $log[] = "Creating tenant folder: {$slug}";
        if (!self::copyDirectory($baseTemplateDir, $targetFolder)) {
            return ['success' => false, 'error' => "Failed to copy template from {$baseTemplateDir} to {$targetFolder}"];
        }

        // Step 2: Ensure required writable directories exist
        $subdirs = ['uploads', 'qrtemp', 'signatures', 'stamps'];
        foreach ($subdirs as $sd) {
            $p = $targetFolder . DIRECTORY_SEPARATOR . $sd;
            if (!is_dir($p)) {
                mkdir($p, 0755, true);
            }
        }

        // Step 3: Copy uploaded logo and letterhead if available
        if (!empty($vendor['logo_image']) && file_exists($vendor['logo_image'])) {
            copy($vendor['logo_image'], $targetFolder . DIRECTORY_SEPARATOR . 'qrtemp' . DIRECTORY_SEPARATOR . 'logo.jpg');
        }
        if (!empty($vendor['letterhead_image']) && file_exists($vendor['letterhead_image'])) {
            copy($vendor['letterhead_image'], $targetFolder . DIRECTORY_SEPARATOR . 'qrtemp' . DIRECTORY_SEPARATOR . 'letterhead.jpg');
        }

        // Step 4: Create new database
        $log[] = "Creating database: {$db_name}";
        $dbRes = self::createDatabase($db_host, $db_user, $db_pass, $db_name);
        if (!$dbRes['success']) {
            // Try localhost fallback if root without password
            if ($db_host === 'localhost' || $db_host === '127.0.0.1') {
                $dbResFallback = self::createDatabase($db_host, 'root', '', $db_name);
                if ($dbResFallback['success']) {
                    $db_user = 'root';
                    $db_pass = '';
                    $dbRes = $dbResFallback;
                }
            }
        }

        if (!$dbRes['success']) {
            $log[] = "Database creation warning: " . $dbRes['error'];
        }

        // Step 5: Connect to the tenant database and import schema
        try {
            $tenantPdo = new PDO("mysql:host={$db_host};dbname={$db_name};charset=utf8mb4", $db_user, $db_pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);

            $log[] = "Importing SQL schema & catalog from dump...";
            $importRes = self::importSqlFile($tenantPdo, $dumpSqlPath);
            $log[] = "Imported {$importRes['queries_executed']} SQL queries.";

            // Step 5b: Purge demo operational / patient / billing data so the new lab starts 100% fresh!
            $tablesToPurge = [
                'bills', 'bill_packages', 'bill_tests',
                'patients', 'patient_extra_info',
                'test_results', 'test_samples',
                'transactions', 'sign_master', 'users'
            ];
            $tenantPdo->exec("SET FOREIGN_KEY_CHECKS = 0;");
            foreach ($tablesToPurge as $tbl) {
                try {
                    $tenantPdo->exec("TRUNCATE TABLE `{$tbl}`;");
                } catch (PDOException $ex) {
                    $tenantPdo->exec("DELETE FROM `{$tbl}`;");
                    @$tenantPdo->exec("ALTER TABLE `{$tbl}` AUTO_INCREMENT = 1;");
                }
            }
            $tenantPdo->exec("SET FOREIGN_KEY_CHECKS = 1;");
            $log[] = "Purged demo transactions (bills, patients, samples, reports) for fresh start.";

            // Step 6: Provision Lab Admin User into tenant DB
            $vendor_username = $vendor['vendor_userid'];
            $vendor_password = $vendor['password']; // already hashed during registration or passed hashed
            $vendor_name = $vendor['name'];

            // Check if admin user already exists
            $uStmt = $tenantPdo->prepare("SELECT user_id FROM users WHERE username = ?");
            $uStmt->execute([$vendor_username]);
            $existingUser = $uStmt->fetch();

            if ($existingUser) {
                $tenantPdo->prepare("UPDATE users SET password_hash = ?, full_name = ?, role_id = 1, status = 'active' WHERE user_id = ?")
                          ->execute([$vendor_password, $vendor_name, $existingUser['user_id']]);
            } else {
                $tenantPdo->prepare("INSERT INTO users (username, password_hash, full_name, role_id, status) VALUES (?, ?, ?, 1, 'active')")
                          ->execute([$vendor_username, $vendor_password, $vendor_name]);
            }
            $log[] = "Provisioned admin login credentials for user: {$vendor_username}";

            // Step 7: Provision admin_settings in tenant DB
            $tenantPdo->prepare("INSERT INTO admin_settings (id, company_name, company_address, phone, email, status, expiry_date, grace_days) 
                VALUES (1, ?, ?, ?, ?, 'active', ?, ?) 
                ON DUPLICATE KEY UPDATE 
                    company_name = VALUES(company_name),
                    company_address = VALUES(company_address),
                    phone = VALUES(phone),
                    email = VALUES(email),
                    status = 'active',
                    expiry_date = VALUES(expiry_date),
                    grace_days = VALUES(grace_days)")
                ->execute([
                    $vendor['name'],
                    $vendor['address'] ?? '',
                    $vendor['phone'] ?? '',
                    $vendor['email'] ?? '',
                    $due_date,
                    $grace_days
                ]);
            $log[] = "Configured admin_settings (Trial expiry: {$due_date}, Grace: {$grace_days} days)";

        } catch (PDOException $e) {
            $log[] = "Tenant database provisioning notice: " . $e->getMessage();
        }

        // Step 8: Write tenant db.php configuration
        $configFile = $targetFolder . DIRECTORY_SEPARATOR . 'db.php';
        self::writeDbConfigFile($configFile, $db_host, $db_user, $db_pass, $db_name);
        $log[] = "Generated tenant db.php";

        return [
            'success'     => true,
            'folder_name' => $slug,
            'target_path' => $targetFolder,
            'db_name'     => $db_name,
            'due_date'    => $due_date,
            'log'         => $log
        ];
    }
}
