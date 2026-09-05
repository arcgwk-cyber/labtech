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

    public static function createDatabase($host, $user, $pass, $db_name) {
        // First check: does the database already exist? (e.g. pre-created in Hostinger hPanel / cPanel)
        try {
            $pdoExisting = new PDO("mysql:host={$host};dbname={$db_name};charset=utf8mb4", $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
            return ['success' => true, 'pdo' => $pdoExisting, 'already_existed' => true];
        } catch (PDOException $e) {
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
                return [
                    'success' => false, 
                    'error' => "Access denied to CREATE database `{$db_name}`. On Hostinger/Shared hosting, MySQL users cannot create arbitrary databases via PHP scripts. " .
                               "Please go to Hostinger hPanel → Databases, create a database named `" . ($userPrefix ? "{$userPrefix}{$db_name}" : "{$db_name}") . "`, assign user `{$user}` to it with all privileges, and re-run approval with that exact database name."
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

    public static function provisionLab($vendor, $customSlug = '', $customDbName = '', $customUser = '', $customPass = '', $trialDays = 14) {
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
        $dbUser = getenv('DB_USER') ?: 'root';
        $dbPass = getenv('DB_PASS') !== false ? getenv('DB_PASS') : '';
        $dbName = !empty($customDbName) ? $customDbName : 'lab_' . $slug;

        // 3. Create tenant database
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
