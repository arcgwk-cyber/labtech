
<?php
session_start();
include 'db.php';

// Only allow admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

$upload_dir = "qrtemp/";
$allowed_types = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'];
$max_size = 5 * 1024 * 1024;

$messages = [];

if (!is_dir($upload_dir)) { @mkdir($upload_dir, 0755, true); }
if (!is_dir(__DIR__ . '/uploads')) { @mkdir(__DIR__ . '/uploads', 0755, true); }

function getActiveLogo() {
    $candidates = [
        'qrtemp/logo.jpg', 'qrtemp/logo.png', 'qrtemp/logo.jpeg', 'qrtemp/logo.webp',
        'uploads/logo.jpg', 'uploads/logo.png', 'uploads/logo.jpeg', 'uploads/logo.webp',
        'logo.jpg', 'logo.png'
    ];
    foreach ($candidates as $c) {
        if (file_exists(__DIR__ . '/' . $c)) return $c;
    }
    return null;
}

function getActiveLetterhead() {
    $candidates = [
        'qrtemp/letterhead.jpg', 'qrtemp/letterhead.png', 'qrtemp/letterhead.jpeg', 'qrtemp/letterhead.webp',
        'uploads/letterhead.jpg', 'uploads/letterhead.png', 'uploads/letterhead.jpeg',
        'letterhead.jpg', 'letterhead.png', 'ammaletterhead.jpg'
    ];
    foreach ($candidates as $c) {
        if (file_exists(__DIR__ . '/' . $c)) return $c;
    }
    return null;
}

// Handle file deletion or saving
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['delete_logo'])) {
        foreach (['qrtemp/logo.jpg', 'qrtemp/logo.png', 'qrtemp/logo.jpeg', 'qrtemp/logo.webp',
                  'uploads/logo.jpg', 'uploads/logo.png', 'logo.jpg', 'logo.png'] as $f) {
            if (file_exists(__DIR__ . '/' . $f)) { @unlink(__DIR__ . '/' . $f); }
        }
        $messages[] = '<div class="alert alert-warning">Logo removed.</div>';
    }

    if (!empty($_POST['delete_letter'])) {
        foreach (['qrtemp/letterhead.jpg', 'qrtemp/letterhead.png', 'qrtemp/letterhead.jpeg', 'qrtemp/letterhead.webp',
                  'uploads/letterhead.jpg', 'uploads/letterhead.png', 'letterhead.jpg', 'letterhead.png', 'ammaletterhead.jpg'] as $f) {
            if (file_exists(__DIR__ . '/' . $f)) { @unlink(__DIR__ . '/' . $f); }
        }
        $messages[] = '<div class="alert alert-warning">Letterhead removed.</div>';
    }

    if (!empty($_POST['save_settings'])) {
        $company_name = $conn->real_escape_string($_POST['company_name'] ?? '');
        $company_address = $conn->real_escape_string($_POST['company_address'] ?? '');

        // Upload logo
        if (!empty($_FILES['logo_file']['tmp_name'])) {
            $logo = $_FILES['logo_file'];
            if ($logo['size'] <= $max_size) {
                $ext = strtolower(pathinfo($logo['name'], PATHINFO_EXTENSION));
                if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) $ext = 'jpg';
                $dest = $upload_dir . 'logo.' . $ext;
                if (move_uploaded_file($logo['tmp_name'], $dest)) {
                    @copy($dest, $upload_dir . 'logo.jpg');
                    @copy($dest, __DIR__ . '/uploads/logo.' . $ext);
                    @copy($dest, __DIR__ . '/uploads/logo.jpg');
                    @copy($dest, __DIR__ . '/logo.' . $ext);
                    @copy($dest, __DIR__ . '/logo.jpg');
                    $messages[] = '<div class="alert alert-success">Logo updated successfully across the portal.</div>';
                }
            } else {
                $messages[] = '<div class="alert alert-danger">Invalid logo file type or size exceeds 5MB.</div>';
            }
        }

        // Upload letterhead
        if (!empty($_FILES['letter_file']['tmp_name'])) {
            $letter = $_FILES['letter_file'];
            if ($letter['size'] <= $max_size) {
                $ext = strtolower(pathinfo($letter['name'], PATHINFO_EXTENSION));
                if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) $ext = 'jpg';
                $dest = $upload_dir . 'letterhead.' . $ext;
                if (move_uploaded_file($letter['tmp_name'], $dest)) {
                    @copy($dest, $upload_dir . 'letterhead.jpg');
                    @copy($dest, __DIR__ . '/uploads/letterhead.' . $ext);
                    @copy($dest, __DIR__ . '/uploads/letterhead.jpg');
                    @copy($dest, __DIR__ . '/letterhead.' . $ext);
                    @copy($dest, __DIR__ . '/letterhead.jpg');
                    @copy($dest, __DIR__ . '/ammaletterhead.jpg');
                    $messages[] = '<div class="alert alert-success">Letterhead updated successfully for PDF reports.</div>';
                }
            } else {
                $messages[] = '<div class="alert alert-danger">Invalid letterhead file type or size exceeds 5MB.</div>';
            }
        }

        // Save settings isolated by lab_slug
        $currentDir = basename(__DIR__);
        $labSlug = ($currentDir === 'demo') ? 'demo' : (($currentDir === 'base') ? 'base' : $conn->real_escape_string($currentDir));

        $colCheck = $conn->query("SHOW COLUMNS FROM admin_settings LIKE 'lab_slug'");
        if ($colCheck && $colCheck->num_rows === 0) {
            @$conn->query("ALTER TABLE admin_settings ADD COLUMN lab_slug VARCHAR(100) DEFAULT NULL AFTER id");
        }

        $chkSlug = $conn->query("SELECT id FROM admin_settings WHERE lab_slug = '{$labSlug}' LIMIT 1");
        if ($chkSlug && $chkSlug->num_rows > 0) {
            $sql = "UPDATE admin_settings SET company_name = '$company_name', company_address = '$company_address' WHERE lab_slug = '{$labSlug}'";
        } else {
            $chk1 = $conn->query("SELECT id, lab_slug FROM admin_settings WHERE id = 1 LIMIT 1");
            if ($chk1 && $r1 = $chk1->fetch_assoc()) {
                if ($labSlug === 'demo' || empty($r1['lab_slug']) || $r1['lab_slug'] === 'demo') {
                    $sql = "UPDATE admin_settings SET company_name = '$company_name', company_address = '$company_address', lab_slug = '{$labSlug}' WHERE id = 1";
                } else {
                    $sql = "INSERT INTO admin_settings (company_name, company_address, lab_slug, status) VALUES ('$company_name', '$company_address', '{$labSlug}', 'active')";
                }
            } else {
                $sql = "INSERT INTO admin_settings (company_name, company_address, lab_slug, status) VALUES ('$company_name', '$company_address', '{$labSlug}', 'active')";
            }
        }

        // Save letterhead top & bottom margin preferences if provided
        $pref_file = __DIR__ . '/report_preferences.json';
        $prefs = [];
        if (file_exists($pref_file)) {
            $prefs = json_decode(file_get_contents($pref_file), true) ?: [];
        }
        if (isset($_POST['letterhead_top_margin']) && is_numeric($_POST['letterhead_top_margin'])) {
            $prefs['top_margin'] = floatval($_POST['letterhead_top_margin']);
        }
        if (isset($_POST['letterhead_bottom_margin']) && is_numeric($_POST['letterhead_bottom_margin'])) {
            $prefs['bottom_margin'] = floatval($_POST['letterhead_bottom_margin']);
        }
        if (isset($_POST['letterhead_top_margin']) || isset($_POST['letterhead_bottom_margin'])) {
            @file_put_contents($pref_file, json_encode($prefs, JSON_PRETTY_PRINT));
        }

        if ($conn->query($sql)) {
            $messages[] = '<div class="alert alert-success">Settings updated successfully.</div>';
        } else {
            $messages[] = '<div class="alert alert-danger">Failed to update settings: ' . $conn->error . '</div>';
        }
    }
}

// Get current settings by lab_slug
$currentDir = basename(__DIR__);
$labSlug = ($currentDir === 'demo') ? 'demo' : (($currentDir === 'base') ? 'base' : ($conn ? $conn->real_escape_string($currentDir) : $currentDir));
$settings = ['company_name' => '', 'company_address' => ''];

if ($conn && !$conn->connect_error) {
    $result = $conn->query("SELECT * FROM admin_settings WHERE lab_slug = '{$labSlug}' LIMIT 1");
    if (!$result || $result->num_rows === 0) {
        $result = $conn->query("SELECT * FROM admin_settings WHERE id = 1 LIMIT 1");
    }
    if ($result && $row = $result->fetch_assoc()) {
        $settings = $row;
    } else {
        if ($labSlug === 'demo') {
            $settings['company_name'] = 'Vensaas Labtech';
            $settings['company_address'] = 'Visakhapatnam-530016 (A.P)';
        } else {
            $words = explode('_', str_replace('-', '_', $currentDir));
            $formatted = array_map(function($w) {
                return (strlen($w) <= 3) ? strtoupper($w) : ucfirst($w);
            }, $words);
            $settings['company_name'] = implode(' ', $formatted);
        }
    }
}

// Read saved letterhead top margin preference (default 55.0 mm)
$pref_file = __DIR__ . '/report_preferences.json';
$lab_prefs = [];
if (file_exists($pref_file)) {
    $lab_prefs = json_decode(file_get_contents($pref_file), true) ?: [];
}
$letterhead_top_margin = isset($lab_prefs['top_margin']) ? (float)$lab_prefs['top_margin'] : 55.0;
$letterhead_bottom_margin = isset($lab_prefs['bottom_margin']) ? (float)$lab_prefs['bottom_margin'] : 35.0;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Profile Settings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<?php include_once __DIR__ . '/header.php'; ?>

<div class="container py-5">
    <div class="card p-4 shadow">
        <h3 class="mb-4">Admin Profile Settings</h3>
        <?= implode('', $messages) ?>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="save_settings" value="1">
            <div class="mb-3">
                <label class="form-label">Company Name</label>
                <input type="text" name="company_name" class="form-control" value="<?= htmlspecialchars($settings['company_name'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Company Address</label>
                <textarea name="company_address" class="form-control" required><?= htmlspecialchars($settings['company_address'] ?? '') ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Logo (for login & header)</label>
                <input type="file" name="logo_file" class="form-control" accept="image/png, image/jpeg, image/jpg, image/webp">
                <?php $active_logo = getActiveLogo(); if ($active_logo): ?>
                    <div class="mt-2 d-flex align-items-center">
                        <img src="<?= htmlspecialchars($active_logo) ?>?v=<?= time() ?>" alt="Logo" height="50" class="me-3 p-1 border rounded bg-white shadow-sm" style="object-fit: contain;">
                        <button type="submit" name="delete_logo" value="1" class="btn btn-sm btn-outline-danger">Delete Logo</button>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label class="form-label">Letterhead (for PDF Reports)</label>
                <input type="file" name="letter_file" class="form-control" accept="image/png, image/jpeg, image/jpg, image/webp">
                <?php $active_letterhead = getActiveLetterhead(); if ($active_letterhead): ?>
                    <div class="mt-2 d-flex align-items-center">
                      <img src="<?= htmlspecialchars($active_letterhead) ?>?v=<?= time() ?>" alt="Letterhead" height="200" class="me-3 p-1 border rounded bg-white shadow-sm" style="object-fit: contain;">
                        <button type="submit" name="delete_letter" value="1" class="btn btn-sm btn-outline-danger">Delete Letterhead</button>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mb-4 p-3 border rounded bg-light">
                <h6 class="fw-bold text-dark mb-3"><i class="bi bi-sliders text-primary me-2"></i>Letterhead Report Margins & Spacing (mm)</h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold mb-1">
                            <i class="bi bi-arrow-down-circle text-primary me-1"></i> Top Margin / Header Spacing
                        </label>
                        <div class="input-group" style="max-width: 220px;">
                            <input type="number" step="0.5" name="letterhead_top_margin" class="form-control" value="<?= htmlspecialchars($letterhead_top_margin) ?>" min="30" max="85" required>
                            <span class="input-group-text">mm</span>
                        </div>
                        <div class="form-text text-muted mt-1" style="font-size: 0.8rem;">
                            Distance from top of page before patient info begins. Default: <strong>55 mm</strong>. Increase to <strong>58 - 62 mm</strong> if patient info touches your header artwork or divider line.
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold mb-1">
                            <i class="bi bi-arrow-up-circle text-success me-1"></i> Bottom Margin / Footer Spacing
                        </label>
                        <div class="input-group" style="max-width: 220px;">
                            <input type="number" step="0.5" name="letterhead_bottom_margin" class="form-control" value="<?= htmlspecialchars($letterhead_bottom_margin) ?>" min="15" max="75" required>
                            <span class="input-group-text">mm</span>
                        </div>
                        <div class="form-text text-muted mt-1" style="font-size: 0.8rem;">
                            Distance from bottom of page before tests and signatures stop. Default: <strong>35 mm</strong>. Increase to <strong>45 - 50 mm</strong> if signatures, test rows, or QR code overlap your footer address, phone, or artwork.
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Save Settings</button>
        </form>
    </div>
</div>
</body>
</html>
<?php
include 'get_client_id.php';
$client_id = getClientId($conn);

if (!$client_id) {
    die("Client ID not found.");
}

$api_url = "https://www.vensaas.com/api/get_status.php?id=" . urlencode($client_id);
$response = @file_get_contents($api_url);

if ($response === false) {
    die("Unable to fetch subscription data.");
}

$data = json_decode($response, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    die("Invalid response from API.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Subscription Status</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #f7f9fc;
        }
        .status-box {
            max-width: 600px;
            margin: 50px auto;
            background: #fff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
<div class="status-box">
    <h3 class="mb-4 text-center text-success">License Information</h3>
    <table class="table table-bordered">
        <tr><th>Client Name</th><td><?= htmlspecialchars($data['name']) ?></td></tr>
        <tr><th>Expiry Date</th><td><?= htmlspecialchars($data['expiry_date']) ?></td></tr>
        <tr><th>Grace Until</th><td><?= htmlspecialchars($data['grace_end_date']) ?></td></tr>
        <tr>
            <th>Status</th>
            <td>
                <?php
                $status = strtolower($data['status']);
                $badge = match ($status) {
                    'active' => 'success',
                    'grace' => 'warning',
                    'expired' => 'danger',
                    default => 'secondary'
                };
                echo "<span class='badge bg-$badge'>" . ucfirst($status) . "</span>";
                ?>
            </td>
        </tr>
    </table>

    <?php if ($status !== 'active'): ?>
        <form action="renew.php" method="post">
            <button class="btn btn-primary w-100">Renew Subscription</button>
        </form>
    <?php else: ?>
        <div class="alert alert-success text-center mt-3">Your subscription is active. ✅</div>
    <?php endif; ?>
</div>
</body>
</html>
