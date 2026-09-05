<?php
require_once 'db.php';

$error = null;
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vendor_userid = trim($_POST['vendor_userid'] ?? '');
    $raw_password  = trim($_POST['password'] ?? '');
    $name          = trim($_POST['name'] ?? '');
    $address       = trim($_POST['address'] ?? '');
    $pincode       = trim($_POST['pincode'] ?? '');
    $phone         = trim($_POST['phone'] ?? '');
    $email         = trim($_POST['email'] ?? '');
    $folder_slug   = trim($_POST['folder_slug'] ?? '');

    function slugify_simple($text) {
        $slug = preg_replace('~[^\pL\d]+~u', '_', $text);
        $slug = iconv('utf-8', 'us-ascii//TRANSLIT', $slug);
        $slug = preg_replace('~[^-\w]+~', '', $slug);
        $slug = trim($slug, '_');
        $slug = preg_replace('~_+~', '_', $slug);
        $slug = strtolower($slug);
        return empty($slug) ? 'lab_' . time() : $slug;
    }

    if (empty($folder_slug)) {
        $folder_slug = slugify_simple($name);
    } else {
        $folder_slug = slugify_simple($folder_slug);
    }

    if (empty($vendor_userid) || empty($raw_password) || empty($name) || empty($email)) {
        $error = "Please fill in all required fields (Lab Name, User ID, Password, and Email).";
    } elseif (strlen($raw_password) < 6) {
        $error = "Password must be at least 6 characters long.";
    } else {
        // Upload Helper
        function uploadFileSafely($inputName) {
            if (isset($_FILES[$inputName]) && $_FILES[$inputName]['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR;
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                $ext = strtolower(pathinfo($_FILES[$inputName]['name'], PATHINFO_EXTENSION));
                $allowed = ['jpg', 'jpeg', 'png', 'webp'];
                if (in_array($ext, $allowed)) {
                    $fileName = time() . '_' . uniqid() . '.' . $ext;
                    $targetPath = $uploadDir . $fileName;
                    if (move_uploaded_file($_FILES[$inputName]['tmp_name'], $targetPath)) {
                        return 'uploads/' . $fileName;
                    }
                }
            }
            return null;
        }

        $logo_image = uploadFileSafely('logo_image');
        $letterhead_image = uploadFileSafely('letterhead_image');

        if ($conn && !$conn->connect_error) {
            // Check if username already exists
            $checkStmt = $conn->prepare("SELECT vendor_id FROM vendor_master WHERE vendor_userid = ?");
            $checkStmt->bind_param("s", $vendor_userid);
            $checkStmt->execute();
            if ($checkStmt->get_result()->fetch_assoc()) {
                $error = "The User ID '{$vendor_userid}' is already registered. Please choose a different User ID.";
            } else {
                $remarks_val = "Suggested Folder: /" . $folder_slug;
                $stmt = $conn->prepare("INSERT INTO vendor_master 
                    (vendor_userid, password, name, address, pincode, phone, email, logo_image, letterhead_image, status, payment, remarks) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending', 'unpaid', ?)");

                $stmt->bind_param("ssssssssss", 
                    $vendor_userid,
                    $raw_password,
                    $name,
                    $address,
                    $pincode,
                    $phone,
                    $email,
                    $logo_image,
                    $letterhead_image,
                    $remarks_val
                );

                if ($stmt->execute()) {
                    $success = true;
                } else {
                    $error = "Registration Database Error: " . $conn->error;
                }
                $stmt->close();
            }
            $checkStmt->close();
        } else {
            $error = "Database connection unavailable. Please contact the administrator.";
        }
    }
} else {
    header("Location: register.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registration Status | Diagnostic Centre Management</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 50%, #f8fafc 100%);
      min-height: 100vh;
      font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }
    .status-card {
      background: #ffffff;
      border: 1px solid #e2e8f0;
      border-radius: 20px;
      box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.02);
      max-width: 580px;
      width: 100%;
      overflow: hidden;
    }
  </style>
</head>
<body>

<div class="status-card">
  <div class="p-4 p-sm-5 text-center">
    
    <?php if ($success): ?>
      <div class="mb-4">
        <div class="d-inline-flex align-items-center justify-content-center bg-success bg-opacity-10 text-success rounded-circle" style="width: 80px; height: 80px;">
          <i class="fas fa-check-circle fa-3x"></i>
        </div>
      </div>

      <h3 class="fw-bold text-dark mb-2">Registration Submitted!</h3>
      <p class="text-muted mb-4">
        Thank you for registering <strong><?= htmlspecialchars($name) ?></strong> with LabTech Cloud.
        Your application is currently under review by our Super Admin team.
      </p>

      <div class="bg-light p-3 rounded-3 text-start border mb-4">
        <h6 class="fw-bold text-dark border-bottom pb-2 mb-2"><i class="fas fa-info-circle text-primary me-2"></i> Application Summary</h6>
        <div class="small mb-1"><strong>Lab Name:</strong> <?= htmlspecialchars($name) ?></div>
        <div class="small mb-1"><strong>User ID:</strong> <?= htmlspecialchars($vendor_userid) ?></div>
        <div class="small mb-1"><strong>Email:</strong> <?= htmlspecialchars($email) ?></div>
        <div class="small mb-0"><strong>Status:</strong> <span class="badge bg-warning text-dark">Pending Super Admin Approval</span></div>
      </div>

      <p class="small text-muted mb-4">
        Once approved, your dedicated laboratory software instance and database will be activated automatically.
      </p>

      <div class="d-flex justify-content-center gap-2">
        <a href="login.php" class="btn btn-primary px-4 py-2 rounded-3 fw-semibold">
          <i class="fas fa-sign-in-alt me-1"></i> Go to Login
        </a>
      </div>

    <?php else: ?>
      <div class="mb-4">
        <div class="d-inline-flex align-items-center justify-content-center bg-danger bg-opacity-10 text-danger rounded-circle" style="width: 80px; height: 80px;">
          <i class="fas fa-exclamation-triangle fa-3x"></i>
        </div>
      </div>

      <h3 class="fw-bold text-dark mb-2">Registration Incomplete</h3>
      <div class="alert alert-danger text-start small mb-4">
        <?= htmlspecialchars($error ?? 'An unexpected error occurred.') ?>
      </div>

      <a href="register.php" class="btn btn-primary px-4 py-2 rounded-3 fw-semibold">
        <i class="fas fa-arrow-left me-1"></i> Return to Registration Form
      </a>
    <?php endif; ?>

  </div>
</div>

</body>
</html>
