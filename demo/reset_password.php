<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password | Demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width: 500px;">
    <div class="card p-4 shadow-sm border-0">
        <div class="text-center mb-4">
            <i class="fas fa-shield-alt text-warning fs-1 mb-2"></i>
            <h4 class="fw-bold">Password Reset</h4>
            <span class="badge bg-warning text-dark"><i class="fas fa-lock me-1"></i> Demo Environment</span>
        </div>

        <div class="alert alert-info small mb-4">
            <i class="fas fa-info-circle me-1"></i>
            <strong>Demo Protection Notice:</strong> Password reset is disabled in the demo version to keep login accounts accessible for all evaluators.
        </div>

        <div class="bg-light p-3 rounded border mb-4 small">
            <strong>Default Demo Credentials:</strong><br>
            &bull; Administrator: <code>admin</code> / <code>admin123</code><br>
            &bull; Staff: <code>staff</code> / <code>admin123</code>
        </div>

        <div class="d-grid">
            <a href="login.php" class="btn btn-primary py-2 fw-semibold">
                <i class="fas fa-arrow-left me-1"></i> Return to Login
            </a>
        </div>
    </div>
</div>
</body>
</html>
