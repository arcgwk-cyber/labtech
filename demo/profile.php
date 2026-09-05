
<?php
session_start();
include 'db.php';

// Only allow admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

$upload_dir = "qrtemp/";
$allowed_types = ['image/jpeg', 'image/png'];
$max_size = 2 * 1024 * 1024;

$messages = [];

// Create upload dir if not exists
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

// Handle file deletion or saving
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['delete_logo'])) {
        if (file_exists($upload_dir . 'logo.jpg')) {
            unlink($upload_dir . 'logo.jpg');
            $messages[] = '<div class="alert alert-warning">Logo removed.</div>';
        }
    }

    if (!empty($_POST['delete_letter'])) {
        if (file_exists($upload_dir . 'letterhead.jpg')) {
            unlink($upload_dir . 'letterhead.jpg');
            $messages[] = '<div class="alert alert-warning">Letterhead removed.</div>';
        }
    }

    if (!empty($_POST['save_settings'])) {
        $company_name = $conn->real_escape_string($_POST['company_name'] ?? '');
        $company_address = $conn->real_escape_string($_POST['company_address'] ?? '');

        // Upload logo
        if (!empty($_FILES['logo_file']['tmp_name'])) {
            $logo = $_FILES['logo_file'];
            if (in_array($logo['type'], $allowed_types) && $logo['size'] <= $max_size) {
                move_uploaded_file($logo['tmp_name'], $upload_dir . 'logo.jpg');
                $messages[] = '<div class="alert alert-success">Logo uploaded successfully.</div>';
            } else {
                $messages[] = '<div class="alert alert-danger">Invalid logo file type or size.</div>';
            }
        }

        // Upload letterhead
        if (!empty($_FILES['letter_file']['tmp_name'])) {
            $letter = $_FILES['letter_file'];
            if (in_array($letter['type'], $allowed_types) && $letter['size'] <= $max_size) {
                move_uploaded_file($letter['tmp_name'], $upload_dir . 'letterhead.jpg');
                $messages[] = '<div class="alert alert-success">Letterhead uploaded successfully.</div>';
            } else {
                $messages[] = '<div class="alert alert-danger">Invalid letterhead file type or size.</div>';
            }
        }

        // Save settings
        $sql = "UPDATE admin_settings SET company_name = '$company_name', company_address = '$company_address' WHERE id = 1";
        if ($conn->query($sql)) {
            $messages[] = '<div class="alert alert-success">Settings updated successfully.</div>';
        } else {
            $messages[] = '<div class="alert alert-danger">Failed to update settings.</div>';
        }
    }
}

// Get current settings
$result = $conn->query("SELECT * FROM admin_settings WHERE id = 1");
if ($result && $result->num_rows > 0) {
    $settings = $result->fetch_assoc();
} else {
    $conn->query("INSERT INTO admin_settings (id, company_name, company_address) VALUES (1, '', '')");
    $settings = ['company_name' => '', 'company_address' => ''];
}
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
                <input type="file" name="logo_file" class="form-control">
                <?php if (file_exists($upload_dir . 'logo.jpg')): ?>
                    <div class="mt-2 d-flex align-items-center">
                        <img src="<?= $upload_dir ?>logo.jpg" alt="Logo" height="50" class="me-3">
                        <button type="submit" name="delete_logo" value="1" class="btn btn-sm btn-outline-danger">Delete Logo</button>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label class="form-label">Letterhead (for PDF)</label>
                <input type="file" name="letter_file" class="form-control">
                <?php if (file_exists($upload_dir . 'letterhead.jpg')): ?>
                    <div class="mt-2 d-flex align-items-center">
                      <img src="<?= $upload_dir ?>letterhead.jpg" alt="Letterhead" height="250" class="me-3">
                        <button type="submit" name="delete_letter" value="1" class="btn btn-sm btn-outline-danger">Delete Letterhead</button>
                    </div>
                <?php endif; ?>
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
