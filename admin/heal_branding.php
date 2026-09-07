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

// 2. Check if SM Medical Centre is currently in row 1
$r1 = $conn->query("SELECT * FROM admin_settings WHERE id = 1 LIMIT 1");
$row1 = ($r1 && $r1->num_rows > 0) ? $r1->fetch_assoc() : null;

if ($row1 && (stripos($row1['company_name'] ?? '', 'SM') !== false)) {
    // Preserve SM Medical Centre in its own row under lab_slug = 'sm_medical_centre'
    $chkSM = $conn->query("SELECT id FROM admin_settings WHERE lab_slug = 'sm_medical_centre' LIMIT 1");
    if (!$chkSM || $chkSM->num_rows === 0) {
        $smName = $conn->real_escape_string($row1['company_name']);
        $smAddr = $conn->real_escape_string($row1['company_address'] ?? 'Canara Bank Road, Opp. Vallabha Dharma Kata, B-Block, Autonagar, Gajuwaka, Visakhapatnam - 530 012');
        $smPhone = $conn->real_escape_string($row1['phone'] ?? '9490262751, 9291347464');
        $smEmail = $conn->real_escape_string($row1['email'] ?? 'sm.medicalcentre@gmail.com');
        $conn->query("INSERT INTO admin_settings (company_name, company_address, phone, email, lab_slug, status) 
                      VALUES ('{$smName}', '{$smAddr}', '{$smPhone}', '{$smEmail}', 'sm_medical_centre', 'active')");
        $log[] = "Preserved SM Medical Centre under lab_slug = 'sm_medical_centre'.";
    }

    // Now restore row 1 to Amma Diagnostic Centre
    $conn->query("UPDATE admin_settings SET 
                  company_name = 'Amma Diagnostic Centre',
                  company_address = 'Gorjee Street, ICHAPURAM-532312, Srikakulam Dist, (A.P)',
                  phone = '+91 7702271571 / +91 9515680080',
                  email = 'info@ammadiagnostics.com',
                  lab_slug = 'demo',
                  status = 'active'
                  WHERE id = 1");
    $log[] = "Restored row 1 to Amma Diagnostic Centre (lab_slug = 'demo').";
} else {
    // Ensure demo row exists with lab_slug = 'demo'
    $chkDemo = $conn->query("SELECT id FROM admin_settings WHERE lab_slug = 'demo' LIMIT 1");
    if (!$chkDemo || $chkDemo->num_rows === 0) {
        if ($row1 && stripos($row1['company_name'] ?? '', 'Amma') !== false) {
            $conn->query("UPDATE admin_settings SET lab_slug = 'demo' WHERE id = 1");
            $log[] = "Marked row 1 with lab_slug = 'demo'.";
        } else {
            $conn->query("INSERT INTO admin_settings (company_name, company_address, phone, email, lab_slug, status) 
                          VALUES ('Amma Diagnostic Centre', 'Gorjee Street, ICHAPURAM-532312, Srikakulam Dist, (A.P)', '+91 7702271571 / +91 9515680080', 'info@ammadiagnostics.com', 'demo', 'active')");
            $log[] = "Created separate demo row for Amma Diagnostic Centre.";
        }
    } else {
        $conn->query("UPDATE admin_settings SET 
                      company_name = 'Amma Diagnostic Centre',
                      company_address = 'Gorjee Street, ICHAPURAM-532312, Srikakulam Dist, (A.P)',
                      phone = '+91 7702271571 / +91 9515680080',
                      email = 'info@ammadiagnostics.com'
                      WHERE lab_slug = 'demo'");
        $log[] = "Verified Amma Diagnostic Centre demo settings under lab_slug = 'demo'.";
    }

    // Ensure SM Medical Centre row exists if SM Medical Centre folder exists
    $chkSM = $conn->query("SELECT id FROM admin_settings WHERE lab_slug = 'sm_medical_centre' LIMIT 1");
    if (!$chkSM || $chkSM->num_rows === 0) {
        $conn->query("INSERT INTO admin_settings (company_name, company_address, phone, email, lab_slug, status) 
                      VALUES ('SM Medical Centre', 'Canara Bank Road, Opp. Vallabha Dharma Kata, B-Block, Autonagar, Gajuwaka, Visakhapatnam - 530 012', '9490262751, 9291347464', 'sm.medicalcentre@gmail.com', 'sm_medical_centre', 'active')");
        $log[] = "Initialized SM Medical Centre under lab_slug = 'sm_medical_centre'.";
    }
}

// 3. Output results
header('Content-Type: application/json');
echo json_encode([
    'success' => true,
    'message' => 'Branding and database isolation check completed successfully.',
    'actions' => $log
], JSON_PRETTY_PRINT);
