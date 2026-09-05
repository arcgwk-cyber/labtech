<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/db.php';

// Auth check
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$current_user_id   = $_SESSION['user_id'];
$current_username  = $_SESSION['username'] ?? 'User';
$current_role      = $_SESSION['role'] ?? 'user';
$current_full_name = $_SESSION['full_name'] ?? $current_username;

// Fetch settings from admin_settings
$app_settings = [
    'company_name' => 'Diagnostic Centre ERP',
    'status'       => 'active',
    'expiry_date'  => null,
    'grace_days'   => 7
];
if ($conn) {
    $res = $conn->query("SELECT * FROM admin_settings WHERE id = 1 LIMIT 1");
    if ($res && $row = $res->fetch_assoc()) {
        $app_settings = array_merge($app_settings, $row);
    }
}

// Dynamic Lab Name resolution for tenant portals
$currentDir = basename(__DIR__);
if ($currentDir !== 'base' && $currentDir !== 'demo') {
    if (empty($app_settings['company_name']) || 
        $app_settings['company_name'] === 'Amma Diagnostic Centre' || 
        $app_settings['company_name'] === 'Diagnostic Centre ERP') {
        
        $words = explode('_', str_replace('-', '_', $currentDir));
        $formatted = array_map(function($w) {
            return (strlen($w) <= 3) ? strtoupper($w) : ucfirst($w);
        }, $words);
        $app_settings['company_name'] = implode(' ', $formatted);
    }
}

// Check logo
$app_logo = null;
foreach ([
    'qrtemp/logo.jpg', 'qrtemp/logo.png', 'qrtemp/logo.jpeg', 'qrtemp/logo.webp',
    'uploads/logo.jpg', 'uploads/logo.png', 'uploads/logo.jpeg',
    'logo.jpg', 'logo.png'
] as $lp) {
    if (file_exists(__DIR__ . '/' . $lp)) {
        $app_logo = $lp;
        break;
    }
}

// Detect current active page
$active_page = basename($_SERVER['PHP_SELF']);

function isNavActive($page_or_pages, $active_page) {
    if (is_array($page_or_pages)) {
        return in_array($active_page, $page_or_pages) ? 'active' : '';
    }
    return $page_or_pages === $active_page ? 'active' : '';
}
?>
<!-- PWA Mobile Web App Manifest & App Configuration -->
<link rel="manifest" href="manifest.json">
<meta name="theme-color" content="#0284c7">
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="apple-mobile-web-app-title" content="LabTech">
<link rel="apple-touch-icon" href="assets/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="192x192" href="assets/icon-192.png">
<link rel="icon" type="image/png" sizes="512x512" href="assets/icon-512.png">

<!-- Pro-Level Modern Medical ERP Navigation -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

<style>
  :root {
    --brand-primary: #0284c7;
    --brand-dark: #0369a1;
    --surface-bg: #f8fafc;
    --card-border: #e2e8f0;
  }

  .navbar-custom {
    background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
    box-shadow: 0 4px 15px rgba(2, 132, 199, 0.2);
    font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
  }

  .navbar-custom .navbar-brand {
    font-weight: 700;
    letter-spacing: -0.02em;
    font-size: 1.15rem;
    color: #ffffff !important;
  }

  .navbar-custom .nav-link {
    color: rgba(255, 255, 255, 0.9) !important;
    font-weight: 500;
    font-size: 0.92rem;
    padding: 7px 13px !important;
    border-radius: 8px;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 6px;
  }

  .navbar-custom .nav-link:hover {
    background-color: rgba(255, 255, 255, 0.18);
    color: #ffffff !important;
    transform: translateY(-1px);
  }

  .navbar-custom .nav-link.active {
    background-color: rgba(255, 255, 255, 0.25);
    color: #ffffff !important;
    font-weight: 600;
    box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
  }

  .btn-quick-bill {
    background: #ffffff;
    color: #0284c7 !important;
    font-weight: 600;
    font-size: 0.9rem;
    border-radius: 8px;
    padding: 7px 15px;
    border: none;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    text-decoration: none;
  }

  .btn-quick-bill:hover {
    background: #f0f9ff;
    color: #0369a1 !important;
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
  }

  .navbar-custom .nav-item.dropdown,
  .navbar-custom .dropdown {
    position: relative !important;
  }

  .navbar-custom .dropdown-menu {
    display: none;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 10px 25px rgba(0,0,0,0.12);
    padding: 8px;
    min-width: 220px;
    background: #ffffff;
    position: absolute !important;
    top: 100% !important;
    left: 0 !important;
    margin-top: 6px !important;
    z-index: 1060 !important;
  }

  .navbar-custom .dropdown-menu-end {
    right: 0 !important;
    left: auto !important;
  }

  .navbar-custom .dropdown-menu.show {
    display: block !important;
    visibility: visible !important;
    opacity: 1 !important;
    pointer-events: auto !important;
    animation: dropdownFadeIn 0.18s ease-out !important;
  }

  .navbar-custom .user-pill,
  .navbar-custom .dropdown-toggle {
    cursor: pointer !important;
    user-select: none;
  }

  @keyframes dropdownFadeIn {
    from { opacity: 0; transform: translateY(-4px); }
    to { opacity: 1; transform: translateY(0); }
  }

  /* Responsive dropdown handling for mobile / tablet screens (<1200px) */
  @media (max-width: 1199.98px) {
    .navbar-custom .dropdown-menu {
      position: static !important;
      float: none !important;
      margin-top: 4px !important;
      background: rgba(255, 255, 255, 0.98);
      box-shadow: none !important;
      border: 1px solid rgba(0, 0, 0, 0.08) !important;
    }
  }

  .navbar-custom .dropdown-item {
    font-size: 0.9rem;
    font-weight: 500;
    padding: 8px 12px;
    border-radius: 6px;
    color: #334155;
    display: flex;
    align-items: center;
    transition: all 0.15s;
  }

  .navbar-custom .dropdown-item:hover {
    background-color: #f0f9ff;
    color: #0284c7;
    transform: translateX(3px);
  }

  .navbar-custom .user-pill {
    background: rgba(255, 255, 255, 0.95);
    color: #0f172a;
    font-weight: 600;
    font-size: 0.88rem;
    border-radius: 30px;
    padding: 5px 14px;
    border: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.08);
  }

  /* ==========================================================
     MOBILE NATIVE-APP & RESPONSIVE UX ENHANCEMENTS
     ========================================================== */
  @media (max-width: 991.98px) {
    body {
      padding-bottom: 74px !important; /* Space for bottom mobile navigation */
      -webkit-tap-highlight-color: transparent;
    }
  }

  /* Bottom Mobile Native Bar */
  .mobile-bottom-nav {
    display: none;
  }

  @media (max-width: 991.98px) {
    .mobile-bottom-nav {
      display: flex;
      position: fixed;
      bottom: 0;
      left: 0;
      right: 0;
      height: 64px;
      background: #ffffff;
      border-top: 1px solid #e2e8f0;
      box-shadow: 0 -4px 16px rgba(15, 23, 42, 0.08);
      z-index: 1040;
      justify-content: space-around;
      align-items: center;
      padding: 0 4px;
    }

    .mobile-bottom-nav a {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-decoration: none;
      color: #64748b;
      font-size: 0.68rem;
      font-weight: 600;
      flex: 1;
      height: 100%;
      padding: 4px 0;
      transition: all 0.15s ease;
      position: relative;
    }

    .mobile-bottom-nav a i {
      font-size: 1.25rem;
      margin-bottom: 2px;
      transition: transform 0.15s ease;
    }

    .mobile-bottom-nav a.active {
      color: #0284c7;
      font-weight: 700;
    }

    .mobile-bottom-nav a.active i {
      transform: scale(1.1);
    }

    .mobile-bottom-nav a.active::after {
      content: '';
      position: absolute;
      top: 0;
      left: 25%;
      right: 25%;
      height: 3px;
      background: #0284c7;
      border-radius: 0 0 3px 3px;
    }

    /* Fast Bill Floating Action in Mobile Bar */
    .mobile-bottom-nav a.mobile-nav-fab {
      color: #ffffff !important;
      position: relative;
      top: -12px;
      background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
      border-radius: 50%;
      width: 52px;
      height: 52px;
      flex: 0 0 52px;
      box-shadow: 0 6px 16px rgba(2, 132, 199, 0.38);
      border: 3px solid #ffffff;
      padding: 0;
    }

    .mobile-bottom-nav a.mobile-nav-fab i {
      font-size: 1.45rem;
      margin-bottom: 0;
    }

    .mobile-bottom-nav a.mobile-nav-fab span {
      display: none;
    }
  }

  /* PWA Install Banner (Mobile Prompter) */
  .pwa-install-banner {
    display: none;
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
    color: #ffffff;
    padding: 10px 16px;
    border-radius: 12px;
    margin: 10px 15px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.18);
    align-items: center;
    justify-content: space-between;
    gap: 12px;
  }
  .pwa-install-banner .pwa-info {
    display: flex;
    align-items: center;
    gap: 10px;
  }
  .pwa-install-banner img {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.2);
  }

</style>

<nav class="navbar navbar-expand-xl navbar-dark navbar-custom sticky-top py-2">
  <div class="container-fluid px-3 px-xl-4">
    
    <!-- Clinic Brand & Logo -->
    <a class="navbar-brand d-flex align-items-center gap-2" href="index.php">
      <?php if ($app_logo): ?>
        <img src="<?= $app_logo ?>" alt="Logo" class="rounded bg-white p-1" style="height: 38px; max-width: 120px; object-fit: contain;">
      <?php else: ?>
        <div class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; font-size: 1.1rem;">
          <i class="fas fa-microscope"></i>
        </div>
      <?php endif; ?>
      <span class="d-none d-sm-inline"><?= htmlspecialchars($app_settings['company_name']) ?></span>
    </a>

    <!-- Mobile Toggle -->
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbarMenu">
      <i class="fas fa-bars text-white fa-lg"></i>
    </button>

    <!-- Navigation Menu Items -->
    <div class="collapse navbar-collapse" id="mainNavbarMenu">
      <ul class="navbar-nav me-auto mb-2 mb-xl-0 ms-xl-3">
        
        <li class="nav-item">
          <a class="nav-link <?= isNavActive(['index.php', 'dashboard.php', 'dashboard_summary.php'], $active_page) ?>" href="index.php">
            <i class="fas fa-chart-pie"></i> Dashboard
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link <?= isNavActive(['bill_list.php', 'bill_add.php', 'bill_edit.php', 'bill_status.php', 'bill_status_list.php'], $active_page) ?>" href="bill_list.php">
            <i class="fas fa-file-invoice-dollar"></i> Bills
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link <?= isNavActive(['sample_collection.php', 'sample_collected_list.php'], $active_page) ?>" href="sample_collection.php">
            <i class="fas fa-vial"></i> Samples
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link <?= isNavActive(['result_entry.php', 'test_entry_list.php'], $active_page) ?>" href="result_entry.php">
            <i class="fas fa-notes-medical"></i> Test Results
          </a>
        </li>

        <!-- Masters Dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?= isNavActive(['lab_test_list.php', 'lab_test_form_with_sections.php', 'test_parameters.php', 'test_categories.php', 'test_groups.php', 'test_packages.php', 'patient_types.php', 'patient_type_fields.php', 'sign_master.php', 'template_designer.php'], $active_page) ?>" href="javascript:void(0);" data-nav-dropdown="toggle" role="button" aria-expanded="false">
            <i class="fas fa-sliders-h"></i> Masters
          </a>
          <ul class="dropdown-menu border-0 shadow">
            <li><a class="dropdown-item" href="lab_test_list.php"><i class="fas fa-flask text-primary me-2"></i> Lab Tests</a></li>
            <li><a class="dropdown-item" href="test_parameters.php"><i class="fas fa-ruler-combined text-primary me-2"></i> Parameters & Ranges</a></li>
            <li><a class="dropdown-item" href="test_categories.php"><i class="fas fa-folder text-primary me-2"></i> Categories</a></li>
            <li><a class="dropdown-item" href="test_groups.php"><i class="fas fa-layer-group text-primary me-2"></i> Test Groups</a></li>
            <li><a class="dropdown-item" href="test_packages.php"><i class="fas fa-box text-primary me-2"></i> Health Packages</a></li>
            <li><a class="dropdown-item" href="patient_types.php"><i class="fas fa-user-tag text-primary me-2"></i> Patient Types</a></li>
            <li><hr class="dropdown-divider my-1"></li>
            <li><a class="dropdown-item" href="sign_master.php"><i class="fas fa-signature text-primary me-2"></i> Doctor Signatures</a></li>
            <li><a class="dropdown-item" href="template_designer.php"><i class="fas fa-palette text-primary me-2"></i> Report Designer</a></li>
            <?php if ($current_role === 'admin'): ?>
              <li><hr class="dropdown-divider my-1"></li>
              <li><a class="dropdown-item" href="update_pathology_catalog.php"><i class="fas fa-database text-success me-2"></i> Indian Pathology Master</a></li>
            <?php endif; ?>
          </ul>
        </li>

        <!-- Reports Dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?= isNavActive(['rate_card.php', 'category_tests.php', 'sample_collected_list.php'], $active_page) ?>" href="javascript:void(0);" data-nav-dropdown="toggle" role="button" aria-expanded="false">
            <i class="fas fa-file-medical-alt"></i> Reports
          </a>
          <ul class="dropdown-menu border-0 shadow">
            <li><a class="dropdown-item" href="rate_card.php"><i class="fas fa-tags text-primary me-2"></i> Price Card / Rate List</a></li>
            <li><a class="dropdown-item" href="category_tests.php"><i class="fas fa-th-list text-primary me-2"></i> Tests by Category</a></li>
            <li><a class="dropdown-item" href="sample_collected_list.php"><i class="fas fa-vials text-primary me-2"></i> Collected Samples Log</a></li>
          </ul>
        </li>

        <!-- Users Management (Admin) -->
        <?php if ($current_role === 'admin'): ?>
          <li class="nav-item">
            <a class="nav-link <?= isNavActive(['users.php', 'edit_user.php'], $active_page) ?>" href="users.php">
              <i class="fas fa-users-cog"></i> Users
            </a>
          </li>
        <?php endif; ?>

      </ul>

      <!-- Right Action Pill & Profile -->
      <div class="d-flex align-items-center gap-2 mt-2 mt-xl-0">
        <a href="bill_add.php" class="btn-quick-bill">
          <i class="fas fa-plus-circle"></i> Fast Bill
        </a>

        <div class="dropdown">
          <button class="user-pill dropdown-toggle" type="button" data-nav-dropdown="toggle" aria-expanded="false">
            <i class="fas fa-user-circle text-primary fs-5"></i>
            <span><?= htmlspecialchars($current_full_name) ?></span>
          </button>
          <ul class="dropdown-menu dropdown-menu-end shadow border-0">
            <li>
              <div class="px-3 py-2 border-bottom mb-1">
                <div class="fw-bold text-dark"><?= htmlspecialchars($current_full_name) ?></div>
                <div class="small text-muted">User: <code><?= htmlspecialchars($current_username) ?></code></div>
                <span class="badge bg-primary-subtle text-primary mt-1 text-uppercase"><?= htmlspecialchars($current_role) ?></span>
              </div>
            </li>
            <li><a class="dropdown-item" href="profile.php"><i class="fas fa-clinic-medical text-muted me-2"></i> Clinic Settings</a></li>
            <li><a class="dropdown-item" href="subscription_status.php"><i class="fas fa-shield-alt text-muted me-2"></i> License Status</a></li>
            <li><hr class="dropdown-divider my-1"></li>
            <li><a class="dropdown-item text-danger" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i> Sign Out</a></li>
          </ul>
        </div>
      </div>

    </div>
  </div>
</nav>

<!-- Mobile PWA Install Banner -->
<div id="pwaInstallBanner" class="pwa-install-banner">
  <div class="pwa-info">
    <img src="assets/icon-192.png" alt="LabTech Icon">
    <div>
      <div class="fw-bold" style="font-size: 0.88rem; line-height: 1.2;">VenSaas LabTech App</div>
      <div style="font-size: 0.72rem; color: #94a3b8;">Install on your phone for 1-tap access</div>
    </div>
  </div>
  <div class="d-flex align-items-center gap-2">
    <button id="pwaInstallBtn" type="button" class="btn btn-sm btn-primary py-1 px-3 fw-bold" style="font-size:0.8rem; border-radius: 6px;">
      Install
    </button>
    <button type="button" class="btn btn-sm text-white-50 p-1" onclick="dismissPwaBanner()" title="Close">
      <i class="fas fa-times"></i>
    </button>
  </div>
</div>

<!-- Mobile Native Bottom Navigation Bar -->
<div class="mobile-bottom-nav">
  <a href="index.php" class="<?= isNavActive(['index.php', 'dashboard.php', 'dashboard_summary.php'], $active_page) ?>">
    <i class="fas fa-chart-pie"></i>
    <span>Home</span>
  </a>
  <a href="bill_list.php" class="<?= isNavActive(['bill_list.php', 'bill_status.php', 'bill_status_list.php'], $active_page) ?>">
    <i class="fas fa-file-invoice-dollar"></i>
    <span>Bills</span>
  </a>
  <a href="bill_add.php" class="mobile-nav-fab" title="Quick New Bill">
    <i class="fas fa-plus"></i>
    <span>New Bill</span>
  </a>
  <a href="sample_collection.php" class="<?= isNavActive(['sample_collection.php', 'sample_collected_list.php'], $active_page) ?>">
    <i class="fas fa-vial"></i>
    <span>Samples</span>
  </a>
  <a href="result_entry.php" class="<?= isNavActive(['result_entry.php', 'test_entry_list.php'], $active_page) ?>">
    <i class="fas fa-notes-medical"></i>
    <span>Reports</span>
  </a>
</div>

<!-- Bootstrap 5 Bundle JS for modals, collapse, tooltips -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Bulletproof Universal Header Controller (Zero Collision, Works Everywhere) -->
<script>
(function() {
  function closeAllNavDropdowns() {
    document.querySelectorAll('.navbar-custom .dropdown-menu.show').forEach(function(menu) {
      menu.classList.remove('show');
      var parent = menu.closest('.dropdown, .nav-item.dropdown');
      if (parent) parent.classList.remove('show');
      var btn = parent ? parent.querySelector('[data-nav-dropdown="toggle"]') : null;
      if (btn) {
        btn.classList.remove('show');
        btn.setAttribute('aria-expanded', 'false');
      }
    });
  }

  // Unified document click listener for dropdown toggling & outside clicks
  document.addEventListener('click', function(e) {
    var toggleBtn = e.target.closest('.navbar-custom [data-nav-dropdown="toggle"]');
    
    if (toggleBtn) {
      e.preventDefault();
      e.stopPropagation();

      var parent = toggleBtn.closest('.dropdown, .nav-item.dropdown');
      if (!parent) return;
      var menu = parent.querySelector('.dropdown-menu');
      if (!menu) return;

      var isCurrentlyOpen = menu.classList.contains('show');

      // Close all dropdowns in navbar first
      closeAllNavDropdowns();

      // If it wasn't already open, open it now
      if (!isCurrentlyOpen) {
        menu.classList.add('show');
        parent.classList.add('show');
        toggleBtn.classList.add('show');
        toggleBtn.setAttribute('aria-expanded', 'true');
      }
      return;
    }

    // If clicked on any menu link inside navbar dropdown, close dropdown
    if (e.target.closest('.navbar-custom .dropdown-item')) {
      closeAllNavDropdowns();
      return;
    }

    // If clicked anywhere outside navbar dropdowns, close all open dropdowns
    if (!e.target.closest('.navbar-custom .dropdown, .navbar-custom .nav-item.dropdown')) {
      closeAllNavDropdowns();
    }
  });

  // Close open dropdowns on Escape key
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' || e.keyCode === 27) {
      closeAllNavDropdowns();
    }
  });

  // Mobile Hamburger Toggle
  function initMobileMenu() {
    var toggler = document.querySelector('.navbar-custom .navbar-toggler');
    var navCollapse = document.getElementById('mainNavbarMenu');
    if (toggler && navCollapse && !toggler.dataset.bound) {
      toggler.dataset.bound = 'true';
      toggler.addEventListener('click', function(e) {
        e.preventDefault();
        navCollapse.classList.toggle('show');
      });
    }
  }

  initMobileMenu();

  // PWA Service Worker Registration & Installation Prompt Logic
  let deferredPrompt = null;
  const pwaBanner = document.getElementById('pwaInstallBanner');
  const pwaBtn = document.getElementById('pwaInstallBtn');

  window.addEventListener('beforeinstallprompt', (e) => {
    e.preventDefault();
    deferredPrompt = e;
    if (pwaBanner && !sessionStorage.getItem('pwa_dismissed')) {
      pwaBanner.style.display = 'flex';
    }
  });

  if (pwaBtn) {
    pwaBtn.addEventListener('click', async () => {
      if (deferredPrompt) {
        deferredPrompt.prompt();
        const { outcome } = await deferredPrompt.userChoice;
        deferredPrompt = null;
        if (pwaBanner) pwaBanner.style.display = 'none';
      }
    });
  }

  window.dismissPwaBanner = function() {
    if (pwaBanner) pwaBanner.style.display = 'none';
    sessionStorage.setItem('pwa_dismissed', 'true');
  };

  window.addEventListener('appinstalled', () => {
    if (pwaBanner) pwaBanner.style.display = 'none';
    deferredPrompt = null;
  });

  // Register Service Worker
  if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
      navigator.serviceWorker.register('sw.js')
        .then((reg) => {
          // Service worker registered successfully
        })
        .catch((err) => {
          // SW registration ignored in non-https or local without error
        });
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initMobileMenu);
  }
})();
</script>
