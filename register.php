<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Diagnostic Centre Registration | Start Free Trial</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --primary-color: #0284c7;
      --primary-hover: #0369a1;
      --secondary-color: #0f172a;
      --bg-gradient: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 50%, #f8fafc 100%);
    }

    body {
      background: var(--bg-gradient);
      min-height: 100vh;
      font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
      padding: 40px 15px;
    }

    .reg-card {
      background: #ffffff;
      border: 1px solid #e2e8f0;
      border-radius: 16px;
      box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
      overflow: hidden;
    }

    .reg-header {
      background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
      color: white;
      padding: 32px 30px;
      text-align: center;
    }

    .reg-header h3 {
      font-weight: 700;
      margin-bottom: 8px;
    }

    .reg-header p {
      color: #e0f2fe;
      margin-bottom: 0;
      font-size: 0.95rem;
    }

    .form-section-title {
      font-size: 0.85rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.05em;
      color: #64748b;
      margin-bottom: 16px;
      padding-bottom: 6px;
      border-bottom: 2px solid #f1f5f9;
    }

    .form-control, .form-select {
      border-radius: 8px;
      padding: 10px 14px;
      border: 1px solid #cbd5e1;
      font-size: 0.95rem;
      transition: all 0.2s ease;
    }

    .form-control:focus, .form-select:focus {
      border-color: var(--primary-color);
      box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.15);
    }

    .btn-register {
      background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
      border: none;
      border-radius: 8px;
      padding: 12px 28px;
      font-weight: 600;
      font-size: 1rem;
      color: #fff;
      transition: all 0.2s;
    }

    .btn-register:hover {
      background: linear-gradient(135deg, #0369a1 0%, #075985 100%);
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(2, 132, 199, 0.3);
    }

    .feature-badge {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      background: #f0fdf4;
      color: #166534;
      padding: 6px 12px;
      border-radius: 20px;
      font-size: 0.85rem;
      font-weight: 600;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-9 col-xl-8">
        
        <div class="text-center mb-4">
          <div class="d-inline-flex align-items-center gap-2 mb-2">
            <span class="feature-badge"><i class="fas fa-check-circle"></i> Instant Setup</span>
            <span class="feature-badge"><i class="fas fa-shield-alt"></i> 14 Days Free Trial</span>
            <span class="feature-badge"><i class="fas fa-database"></i> Dedicated Lab Database</span>
          </div>
        </div>

        <div class="reg-card">
          <div class="reg-header">
            <h3><i class="fas fa-microscope me-2"></i> Register Your Diagnostic Centre</h3>
            <p>Join leading clinical laboratories. Get your automated portal, billing, test reporting, and barcode management.</p>
          </div>

          <div class="p-4 p-md-5">
            <form action="register_action.php" method="post" enctype="multipart/form-data" id="registerForm">
              
              <!-- 1. Lab Details -->
              <div class="form-section-title">
                <i class="fas fa-clinic-medical me-1"></i> 1. Diagnostic Centre Details
              </div>

              <div class="row g-3 mb-4">
                <div class="col-md-12">
                  <label class="form-label fw-semibold">Diagnostic Centre / Lab Name <span class="text-danger">*</span></label>
                  <input type="text" name="name" id="labName" class="form-control" placeholder="e.g. Apex Diagnostics & Imaging Centre" required>
                </div>
                <div class="col-md-12">
                  <label class="form-label fw-semibold">Laboratory Address</label>
                  <textarea name="address" class="form-control" rows="2" placeholder="Full laboratory address, building, road, area..."></textarea>
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Pincode / Postal Code</label>
                  <input type="text" name="pincode" class="form-control" placeholder="e.g. 600001">
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Contact Phone / Mobile <span class="text-danger">*</span></label>
                  <input type="tel" name="phone" class="form-control" placeholder="e.g. +91 9876543210" required>
                </div>
                <div class="col-md-12">
                  <label class="form-label fw-semibold">Official Email Address <span class="text-danger">*</span></label>
                  <input type="email" name="email" class="form-control" placeholder="lab@apexdiagnostics.com" required>
                </div>
              </div>

              <!-- 2. Admin Credentials -->
              <div class="form-section-title">
                <i class="fas fa-user-shield me-1"></i> 2. Administrator Login Credentials
              </div>

              <div class="row g-3 mb-4">
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Desired Admin Username / User ID <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <input type="text" name="vendor_userid" id="vendorUserid" class="form-control" placeholder="e.g. apexadmin" required>
                  </div>
                  <small class="text-muted">Used to log into your laboratory portal.</small>
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Preferred Portal Folder / URL Slug</label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-link"></i></span>
                    <input type="text" name="folder_slug" id="folderSlug" class="form-control" placeholder="e.g. apex_lab">
                  </div>
                  <small class="text-muted">Leave blank to auto-generate from lab name.</small>
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Password <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Minimum 6 characters" required minlength="6">
                  </div>
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Confirm Password <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" name="confirm_password" id="confirmPassword" class="form-control" placeholder="Re-type password" required>
                  </div>
                  <div id="passwordMismatch" class="text-danger small mt-1" style="display:none;">Passwords do not match!</div>
                </div>
              </div>

              <!-- 3. Branding Assets -->
              <div class="form-section-title">
                <i class="fas fa-image me-1"></i> 3. Laboratory Branding & Report Assets
              </div>

              <div class="row g-3 mb-4">
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Lab Logo (Optional)</label>
                  <input type="file" name="logo_image" class="form-control" accept="image/png, image/jpeg, image/jpg">
                  <small class="text-muted">Displayed on portal header and patient receipts (PNG/JPG).</small>
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Report Letterhead (Optional)</label>
                  <input type="file" name="letterhead_image" class="form-control" accept="image/png, image/jpeg, image/jpg">
                  <small class="text-muted">Used as backdrop header on generated PDF test reports.</small>
                </div>
              </div>

              <!-- Actions -->
              <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 pt-3 border-top">
                <div>
                  Already have a lab portal? <a href="login.php" class="fw-semibold text-primary">Login here</a>
                </div>
                <button type="submit" class="btn btn-register">
                  <i class="fas fa-paper-plane me-2"></i> Submit Registration & Start Trial
                </button>
              </div>

            </form>
          </div>
        </div>

      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Auto suggest folder slug from lab name
    document.getElementById('labName').addEventListener('input', function() {
      const slugInput = document.getElementById('folderSlug');
      if (!slugInput.dataset.manual) {
        const slug = this.value.toLowerCase().replace(/[^a-z0-9]+/g, '_').replace(/^_+|_+$/g, '');
        slugInput.value = slug;
      }
    });

    document.getElementById('folderSlug').addEventListener('input', function() {
      this.dataset.manual = 'true';
    });

    // Password match validation
    document.getElementById('registerForm').addEventListener('submit', function(e) {
      const p1 = document.getElementById('password').value;
      const p2 = document.getElementById('confirmPassword').value;
      const mismatch = document.getElementById('passwordMismatch');

      if (p1 !== p2) {
        e.preventDefault();
        mismatch.style.display = 'block';
        document.getElementById('confirmPassword').focus();
      } else {
        mismatch.style.display = 'none';
      }
    });
  </script>
</body>
</html>
