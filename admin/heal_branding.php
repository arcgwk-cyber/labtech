<?php
/**
 * Master Branding & Database Isolation Self-Healing Utility
 * Ensures lab_slug column exists in admin_settings and restores
 * Amma Diagnostic Centre (for demo) and SM Medical Centre (for tenant) records.
 */
require_once __DIR__ . '/db.php';

$log = [];

if (!isset($conn) || !$conn || $conn->connect_error) {
    die(json_encode(['error' => 'Database connection failed: ' . (isset($conn) && $conn ? $conn->connect_error : 'No connection object')]));
}

// 1. Ensure lab_slug column exists in admin_settings
$res = $conn->query("SHOW COLUMNS FROM admin_settings LIKE 'lab_slug'");
if ($res && $res->num_rows === 0) {
    $conn->query("ALTER TABLE admin_settings ADD COLUMN lab_slug VARCHAR(100) DEFAULT NULL AFTER id");
    $conn->query("ALTER TABLE admin_settings ADD INDEX (lab_slug)");
    $log[] = "Added 'lab_slug' column to admin_settings table.";
} else {
    $log[] = "'lab_slug' column already exists in admin_settings.";
}

// Ensure other standard columns exist
$cols = [];
$cRes = $conn->query("SHOW COLUMNS FROM admin_settings");
if ($cRes) {
    while ($r = $cRes->fetch_assoc()) { 
        $cols[] = $r['Field']; 
    }
}

if (!in_array('phone', $cols))       { $conn->query("ALTER TABLE admin_settings ADD COLUMN phone VARCHAR(50) DEFAULT NULL"); }
if (!in_array('email', $cols))       { $conn->query("ALTER TABLE admin_settings ADD COLUMN email VARCHAR(100) DEFAULT NULL"); }
if (!in_array('status', $cols))      { $conn->query("ALTER TABLE admin_settings ADD COLUMN status VARCHAR(20) DEFAULT 'active'"); }
if (!in_array('expiry_date', $cols)) { $conn->query("ALTER TABLE admin_settings ADD COLUMN expiry_date DATE DEFAULT NULL"); }
if (!in_array('grace_days', $cols))  { $conn->query("ALTER TABLE admin_settings ADD COLUMN grace_days INT DEFAULT 7"); }

// 2. Normalize remarks in vendor_master to include state code (e.g. /ap/medione)
$vRes = $conn->query("SELECT vendor_id, name, vendor_userid, password, remarks FROM vendor_master");
if ($vRes) {
    while ($vRow = $vRes->fetch_assoc()) {
        $vid = (int)$vRow['vendor_id'];
        $rem = $vRow['remarks'] ?? '';
        $folderSlug = null;
        if (preg_match('/Provisioned at \/([a-zA-Z0-9_\-\/]+)/', $rem, $m)) {
            $folderSlug = trim($m[1], '/');
        } else {
            $folderSlug = strtolower(preg_replace('/[^a-zA-Z0-9_]+/', '_', trim($vRow['name'])));
        }

        if (strpos($folderSlug, '/') === false) {
            $stateCodes = ['ap', 'ts', 'os', 'od', 'ka', 'tn', 'mh', 'dl', 'wb', 'kl', 'labs'];
            $matchedState = null;
            $wsRoot = dirname(__DIR__);
            foreach ($stateCodes as $sc) {
                if (is_dir($wsRoot . '/' . $sc . '/' . $folderSlug)) {
                    $matchedState = $sc;
                    break;
                }
            }
            if (!$matchedState && ($folderSlug === 'medione' || $folderSlug === 'sm_medical_centre')) {
                $matchedState = 'ap';
            }
            if ($matchedState) {
                $newSlug = $matchedState . '/' . $folderSlug;
                if (preg_match('/Provisioned at \/[a-zA-Z0-9_\-]+/', $rem)) {
                    $newRem = preg_replace('/Provisioned at \/[a-zA-Z0-9_\-]+/', 'Provisioned at /' . $newSlug, $rem);
                } else {
                    $newRem = trim("Provisioned at /{$newSlug} | " . $rem, ' |');
                }
                $conn->query("UPDATE vendor_master SET remarks = '" . $conn->real_escape_string($newRem) . "' WHERE vendor_id = {$vid}");
                $log[] = "Updated vendor #{$vid} ({$vRow['name']}) remarks to /{$newSlug}.";
            }
        }

        // Ensure this vendor's admin user exists in users table with active status!
        if (!empty($vRow['vendor_userid']) && !empty($vRow['password'])) {
            $uName = $vRow['vendor_userid'];
            $uPass = $vRow['password'];
            $chkU = $conn->query("SELECT user_id FROM users WHERE username = '" . $conn->real_escape_string($uName) . "' LIMIT 1");
            $uHash = password_hash($uPass, PASSWORD_BCRYPT);
            if (!$chkU || $chkU->num_rows === 0) {
                $roleChk = $conn->query("SELECT role_id FROM roles WHERE role_id = 1 LIMIT 1");
                $roleId = ($roleChk && $roleChk->num_rows > 0) ? 1 : 1;
                $conn->query("INSERT INTO users (username, password_hash, full_name, role_id, status) 
                              VALUES ('" . $conn->real_escape_string($uName) . "', '{$uHash}', '" . $conn->real_escape_string($vRow['name']) . "', {$roleId}, 'active')");
                $log[] = "Seeded active user '{$uName}' for {$vRow['name']} into users table.";
            } else {
                $conn->query("UPDATE users SET password_hash = '{$uHash}', status = 'active' WHERE username = '" . $conn->real_escape_string($uName) . "'");
                $log[] = "Synchronized password and activated user '{$uName}'.";
            }
        }
    }
}

// 3. Ensure distinct admin_settings rows for demo, MEDIONE, and SM Medical Centre
// Demo row (Vensaas LabTech)
$chkDemo = $conn->query("SELECT id FROM admin_settings WHERE lab_slug = 'demo' LIMIT 1");
if (!$chkDemo || $chkDemo->num_rows === 0) {
    $conn->query("INSERT INTO admin_settings (company_name, company_address, phone, email, lab_slug, status) 
                  VALUES ('Vensaas LabTech', 'Visakhapatnam-530016 (A.P)', '+91 9515680080', 'info@vensaas.com', 'demo', 'active')");
    $log[] = "Created demo row under lab_slug = 'demo'.";
} else {
    $conn->query("UPDATE admin_settings SET company_name = 'Vensaas LabTech', status = 'active' WHERE lab_slug = 'demo'");
}

// MEDIONE Diagnostic Centre row
$chkMed = $conn->query("SELECT id FROM admin_settings WHERE lab_slug = 'ap/medione' OR lab_slug = 'medione' LIMIT 1");
if (!$chkMed || $chkMed->num_rows === 0) {
    $conn->query("INSERT INTO admin_settings (company_name, company_address, phone, email, lab_slug, status) 
                  VALUES ('MEDIONE Diagnostic Centre', 'Andhra Pradesh', '9876543210', 'medione@diagnostic.com', 'ap/medione', 'active')");
    $log[] = "Created admin_settings row for MEDIONE Diagnostic Centre (ap/medione).";
} else {
    $rowM = $chkMed->fetch_assoc();
    $conn->query("UPDATE admin_settings SET company_name = 'MEDIONE Diagnostic Centre', lab_slug = 'ap/medione', status = 'active' WHERE id = " . (int)$rowM['id']);
    $log[] = "Updated admin_settings for MEDIONE Diagnostic Centre.";
}

// SM Medical Centre row
$chkSM = $conn->query("SELECT id FROM admin_settings WHERE lab_slug = 'ap/sm_medical_centre' OR lab_slug = 'sm_medical_centre' LIMIT 1");
if (!$chkSM || $chkSM->num_rows === 0) {
    $conn->query("INSERT INTO admin_settings (company_name, company_address, phone, email, lab_slug, status) 
                  VALUES ('SM Medical Centre', 'Canara Bank Road, Opp. Vallabha Dharma Kata, B-Block, Autonagar, Gajuwaka, Visakhapatnam - 530 012', '9490262751, 9291347464', 'sm.medicalcentre@gmail.com', 'ap/sm_medical_centre', 'active')");
    $log[] = "Created admin_settings row for SM Medical Centre (ap/sm_medical_centre).";
} else {
    $rowS = $chkSM->fetch_assoc();
    $conn->query("UPDATE admin_settings SET company_name = 'SM Medical Centre', lab_slug = 'ap/sm_medical_centre', status = 'active' WHERE id = " . (int)$rowS['id']);
    $log[] = "Updated admin_settings for SM Medical Centre.";
}

// 3. Output results
header('Content-Type: application/json');
echo json_encode([
    'success' => true,
    'message' => 'Branding and database isolation check completed successfully.',
    'actions' => $log
], JSON_PRETTY_PRINT);
