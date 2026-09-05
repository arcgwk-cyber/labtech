<?php
/**
 * VenSaas LabTech - Next-Gen Pathology Laboratory Reporting & Management ERP
 * Direct Landing Page for https://labs.vensaas.com/
 * Highlights:
 *   - Online Cloud SaaS: ₹499/- Monthly (No hidden charges online)
 *   - Offline On-Premise: One-Time Lifetime Payment (No Domain and Hosting Required)
 *   - Live Interactive Demo Access
 *   - Fast Onboarding / Registration
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>VenSaas LabTech | Pathology Lab Reporting & Diagnostic Management Software</title>
  <meta name="description" content="Next-Gen Diagnostic Lab Reporting & Management System. Cloud SaaS at ₹499/Month (No hidden charges) or 100% Offline Lifetime Payment (No Domain and Hosting Required).">
  <meta name="keywords" content="lab management software, pathology reporting software, LIMS, diagnostic billing, lab ERP, vensaas labtech">

  <!-- Bootstrap 5 & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  
  <!-- Modern Typography -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@500;700;800&display=swap" rel="stylesheet">

  <style>
    :root {
      --primary: #0284c7;
      --primary-dark: #0369a1;
      --primary-light: #e0f2fe;
      --accent: #06b6d4;
      --success: #10b981;
      --warning: #f59e0b;
      --dark: #0f172a;
      --slate-800: #1e293b;
      --slate-600: #475569;
      --slate-400: #94a3b8;
      --slate-100: #f1f5f9;
      --bg-surface: #f8fafc;
      --card-border: #e2e8f0;
    }

    * {
      box-sizing: border-box;
    }

    body {
      font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
      background-color: #ffffff;
      color: var(--dark);
      line-height: 1.6;
      overflow-x: hidden;
    }

    /* Navbar */
    .navbar-landing {
      background: rgba(255, 255, 255, 0.92);
      backdrop-filter: blur(12px);
      border-bottom: 1px solid rgba(226, 232, 240, 0.8);
      padding: 16px 0;
      position: sticky;
      top: 0;
      z-index: 1050;
      transition: all 0.3s ease;
    }
    .brand-logo {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      text-decoration: none;
      font-weight: 800;
      font-size: 1.35rem;
      color: var(--dark);
      letter-spacing: -0.02em;
    }
    .brand-icon-box {
      width: 40px;
      height: 40px;
      background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #ffffff;
      box-shadow: 0 4px 12px rgba(2, 132, 199, 0.3);
    }
    .nav-link-custom {
      font-weight: 600;
      font-size: 0.94rem;
      color: var(--slate-600) !important;
      padding: 8px 16px !important;
      border-radius: 8px;
      transition: all 0.2s ease;
    }
    .nav-link-custom:hover {
      color: var(--primary) !important;
      background: var(--primary-light);
    }

    /* Hero Section */
    .hero-section {
      background: radial-gradient(circle at 50% -20%, rgba(2, 132, 199, 0.08) 0%, rgba(248, 250, 252, 0.4) 60%, #ffffff 100%);
      padding: 70px 0 60px;
      position: relative;
    }
    .badge-eyebrow {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: #eff6ff;
      border: 1px solid #bfdbfe;
      color: #1d4ed8;
      padding: 6px 14px;
      border-radius: 30px;
      font-weight: 700;
      font-size: 0.82rem;
      margin-bottom: 22px;
      box-shadow: 0 2px 8px rgba(2, 132, 199, 0.08);
    }
    .hero-title {
      font-size: 3.2rem;
      font-weight: 800;
      line-height: 1.18;
      letter-spacing: -0.03em;
      color: var(--dark);
      margin-bottom: 22px;
    }
    .hero-title .gradient-text {
      background: linear-gradient(135deg, #0284c7 0%, #06b6d4 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }
    .hero-subtitle {
      font-size: 1.18rem;
      color: var(--slate-600);
      margin-bottom: 34px;
      max-width: 650px;
      line-height: 1.6;
    }

    /* Primary CTAs */
    .btn-hero-primary {
      background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
      color: #ffffff;
      font-weight: 700;
      padding: 14px 28px;
      border-radius: 10px;
      font-size: 1rem;
      border: none;
      box-shadow: 0 6px 20px rgba(2, 132, 199, 0.35);
      transition: all 0.25s ease;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      text-decoration: none;
    }
    .btn-hero-primary:hover {
      background: linear-gradient(135deg, #0369a1 0%, #075985 100%);
      color: #ffffff;
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(2, 132, 199, 0.45);
    }

    .btn-hero-outline {
      background: #ffffff;
      color: var(--slate-800);
      font-weight: 700;
      padding: 14px 26px;
      border-radius: 10px;
      font-size: 1rem;
      border: 1px solid var(--card-border);
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
      transition: all 0.25s ease;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      text-decoration: none;
    }
    .btn-hero-outline:hover {
      background: var(--slate-100);
      color: var(--primary-dark);
      border-color: #cbd5e1;
      transform: translateY(-2px);
    }

    .btn-hero-whatsapp {
      background: #25d366;
      color: #ffffff;
      font-weight: 700;
      padding: 14px 22px;
      border-radius: 10px;
      font-size: 0.96rem;
      border: none;
      box-shadow: 0 4px 15px rgba(37, 211, 102, 0.3);
      transition: all 0.25s ease;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      text-decoration: none;
    }
    .btn-hero-whatsapp:hover {
      background: #1eb956;
      color: #ffffff;
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(37, 211, 102, 0.4);
    }

    /* Trust Stats */
    .hero-stat-card {
      background: #ffffff;
      border: 1px solid var(--card-border);
      border-radius: 14px;
      padding: 20px;
      text-align: center;
      box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);
      transition: all 0.25s;
    }
    .hero-stat-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08);
      border-color: #cbd5e1;
    }
    .stat-number {
      font-family: 'JetBrains Mono', monospace;
      font-size: 1.85rem;
      font-weight: 800;
      color: var(--primary);
    }
    .stat-label {
      font-size: 0.82rem;
      font-weight: 600;
      color: var(--slate-600);
      margin-top: 2px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    /* App Preview Mockup Window */
    .app-mockup-wrapper {
      background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
      border-radius: 16px;
      padding: 12px;
      box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.25), 0 0 0 1px rgba(255, 255, 255, 0.1);
      position: relative;
    }
    .mockup-toolbar {
      display: flex;
      align-items: center;
      gap: 8px;
      padding: 8px 12px 14px;
    }
    .mockup-dot {
      width: 11px;
      height: 11px;
      border-radius: 50%;
    }
    .dot-red { background: #ef4444; }
    .dot-yellow { background: #f59e0b; }
    .dot-green { background: #10b981; }

    .mockup-inner {
      background: #ffffff;
      border-radius: 10px;
      overflow: hidden;
      border: 1px solid #334155;
    }

    /* Feature Pillars */
    .section-title-wrap {
      text-align: center;
      max-width: 720px;
      margin: 0 auto 50px;
    }
    .section-eyebrow {
      font-size: 0.82rem;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 1.2px;
      color: var(--primary);
      margin-bottom: 10px;
      display: block;
    }
    .section-heading {
      font-size: 2.3rem;
      font-weight: 800;
      letter-spacing: -0.02em;
      color: var(--dark);
    }
    .section-subtext {
      color: var(--slate-600);
      font-size: 1.05rem;
      margin-top: 10px;
    }

    .feature-card {
      background: #ffffff;
      border: 1px solid var(--card-border);
      border-radius: 16px;
      padding: 28px;
      height: 100%;
      box-shadow: 0 4px 16px rgba(15, 23, 42, 0.03);
      transition: all 0.25s ease;
      display: flex;
      flex-direction: column;
    }
    .feature-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 12px 30px rgba(15, 23, 42, 0.08);
      border-color: #bae6fd;
    }
    .feature-icon-box {
      width: 52px;
      height: 52px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.35rem;
      margin-bottom: 20px;
    }
    .icon-blue { background: #e0f2fe; color: #0284c7; }
    .icon-emerald { background: #d1fae5; color: #059669; }
    .icon-purple { background: #ede9fe; color: #7c3aed; }
    .icon-amber { background: #fef3c7; color: #d97706; }
    .icon-rose { background: #ffe4e6; color: #e11d48; }
    .icon-indigo { background: #e0e7ff; color: #4338ca; }

    .feature-title {
      font-size: 1.18rem;
      font-weight: 700;
      color: var(--dark);
      margin-bottom: 10px;
    }
    .feature-text {
      font-size: 0.92rem;
      color: var(--slate-600);
      line-height: 1.55;
    }

    /* PRICING SECTION - USER REQUIREMENT */
    .pricing-section {
      background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);
      padding: 90px 0;
      position: relative;
    }
    .price-card {
      background: #ffffff;
      border: 2px solid var(--card-border);
      border-radius: 20px;
      padding: 36px 32px;
      height: 100%;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      position: relative;
      transition: all 0.3s ease;
      box-shadow: 0 8px 24px rgba(15, 23, 42, 0.04);
    }
    .price-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 20px 40px rgba(15, 23, 42, 0.1);
    }
    .price-card.featured {
      border-color: var(--primary);
      box-shadow: 0 16px 36px rgba(2, 132, 199, 0.12);
      background: radial-gradient(circle at 100% 0%, rgba(2, 132, 199, 0.04) 0%, #ffffff 70%);
    }

    .pricing-popular-badge {
      position: absolute;
      top: -14px;
      left: 50%;
      transform: translateX(-50%);
      background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
      color: #ffffff;
      font-size: 0.76rem;
      font-weight: 800;
      letter-spacing: 0.6px;
      text-transform: uppercase;
      padding: 5px 16px;
      border-radius: 20px;
      box-shadow: 0 4px 12px rgba(2, 132, 199, 0.3);
    }

    .pricing-title {
      font-size: 1.45rem;
      font-weight: 800;
      color: var(--dark);
      margin-bottom: 8px;
    }
    .pricing-desc {
      font-size: 0.92rem;
      color: var(--slate-600);
      min-height: 44px;
      margin-bottom: 24px;
    }

    .price-tag-wrap {
      display: flex;
      align-items: baseline;
      gap: 4px;
      margin-bottom: 24px;
      padding-bottom: 20px;
      border-bottom: 1px solid var(--card-border);
    }
    .price-currency {
      font-size: 1.6rem;
      font-weight: 700;
      color: var(--dark);
    }
    .price-value {
      font-family: 'JetBrains Mono', monospace;
      font-size: 3.2rem;
      font-weight: 800;
      color: var(--dark);
      letter-spacing: -0.03em;
    }
    .price-period {
      font-size: 1rem;
      color: var(--slate-600);
      font-weight: 600;
    }

    .price-feature-list {
      list-style: none;
      padding: 0;
      margin: 0 0 32px 0;
    }
    .price-feature-list li {
      display: flex;
      align-items: flex-start;
      gap: 12px;
      font-size: 0.92rem;
      color: var(--slate-800);
      margin-bottom: 14px;
    }
    .price-feature-list li i {
      color: var(--success);
      font-size: 1.05rem;
      margin-top: 2px;
      flex-shrink: 0;
    }

    /* Comparison Table */
    .comparison-table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0;
      border: 1px solid var(--card-border);
      border-radius: 14px;
      overflow: hidden;
      background: #ffffff;
      box-shadow: 0 4px 16px rgba(15, 23, 42, 0.03);
    }
    .comparison-table th {
      background: #f8fafc;
      padding: 16px 20px;
      font-weight: 700;
      font-size: 0.9rem;
      color: var(--dark);
      border-bottom: 2px solid var(--card-border);
    }
    .comparison-table td {
      padding: 14px 20px;
      font-size: 0.9rem;
      border-bottom: 1px solid var(--slate-100);
      color: var(--slate-800);
    }
    .comparison-table tr:last-child td {
      border-bottom: none;
    }

    /* FAQ Section */
    .faq-section {
      padding: 80px 0;
      background: #ffffff;
    }
    .accordion-button {
      font-weight: 700;
      font-size: 1.02rem;
      color: var(--dark);
      padding: 18px 24px;
      background: #f8fafc;
      border-radius: 12px !important;
      border: 1px solid var(--card-border);
      margin-bottom: 12px;
      box-shadow: none !important;
    }
    .accordion-button:not(.collapsed) {
      background: #eff6ff;
      color: var(--primary-dark);
      border-color: #bfdbfe;
    }
    .accordion-body {
      padding: 14px 24px 24px;
      font-size: 0.95rem;
      color: var(--slate-600);
      line-height: 1.65;
    }

    /* CTA Bottom Banner */
    .cta-banner {
      background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
      border-radius: 24px;
      padding: 60px 40px;
      color: #ffffff;
      text-align: center;
      position: relative;
      overflow: hidden;
      box-shadow: 0 20px 40px -10px rgba(2, 132, 199, 0.35);
    }

    /* Footer */
    .footer-landing {
      background: #0f172a;
      color: #94a3b8;
      padding: 60px 0 30px;
      font-size: 0.92rem;
    }
    .footer-heading {
      color: #ffffff;
      font-weight: 700;
      font-size: 1rem;
      margin-bottom: 18px;
    }
    .footer-links {
      list-style: none;
      padding: 0;
      margin: 0;
    }
    .footer-links li {
      margin-bottom: 10px;
    }
    .footer-links a {
      color: #94a3b8;
      text-decoration: none;
      transition: color 0.2s;
    }
    .footer-links a:hover {
      color: #38bdf8;
    }
  </style>
</head>
<body>

  <!-- 1. NAVIGATION BAR -->
  <nav class="navbar navbar-expand-lg navbar-landing">
    <div class="container">
      <a class="brand-logo" href="index.php">
        <div class="brand-icon-box">
          <i class="fas fa-microscope"></i>
        </div>
        <div>
          <span>VenSaas <span style="color: var(--primary);">LabTech</span></span>
          <span class="badge bg-primary-subtle text-primary border border-primary-subtle ms-1" style="font-size: 0.68rem; font-weight: 700;">LIMS & ERP</span>
        </div>
      </a>

      <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navContent">
        <i class="fas fa-bars fs-4 text-dark"></i>
      </button>

      <div class="collapse navbar-collapse" id="navContent">
        <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link nav-link-custom" href="#features">Features</a></li>
          <li class="nav-item"><a class="nav-link nav-link-custom" href="#pricing">Price Card</a></li>
          <li class="nav-item"><a class="nav-link nav-link-custom" href="#offline-vs-cloud">Offline vs Cloud</a></li>
          <li class="nav-item"><a class="nav-link nav-link-custom" href="demo/" target="_blank"><i class="fas fa-play-circle text-primary me-1"></i> Live Demo</a></li>
          <li class="nav-item"><a class="nav-link nav-link-custom" href="#faq">FAQ</a></li>
          <li class="nav-item"><a class="nav-link nav-link-custom text-primary" href="brochure.php" target="_blank"><i class="fas fa-file-pdf me-1"></i> Brochure</a></li>
        </ul>
        <div class="d-flex align-items-center gap-2">
          <a href="admin/login.php" class="btn btn-outline-secondary btn-sm fw-bold px-3 py-2" title="Super Admin Portal">
            <i class="fas fa-user-shield me-1"></i> Admin Login
          </a>
          <a href="demo/" class="btn btn-outline-primary btn-sm fw-bold px-3 py-2">
            <i class="fas fa-desktop me-1"></i> Explore Demo
          </a>
          <a href="register.php" class="btn btn-primary btn-sm fw-bold px-3 py-2 shadow-sm" style="background: var(--primary); border: none;">
            <i class="fas fa-rocket me-1"></i> Get Started
          </a>
        </div>
      </div>
    </div>
  </nav>

  <!-- 2. HERO SECTION -->
  <section class="hero-section">
    <div class="container">
      <div class="row align-items-center g-5">
        <div class="col-lg-7 text-center text-lg-start">
          <div class="badge-eyebrow">
            <i class="fas fa-award text-primary"></i> NABL ISO 15189 Ready • Cloud SaaS & Offline On-Premise
          </div>
          <h1 class="hero-title">
            Smart Pathology Lab Reporting & <span class="gradient-text">Diagnostic Management</span>
          </h1>
          <p class="hero-subtitle">
            Modernize your diagnostic centre with lightning-fast patient billing, smart phlebotomy barcoding, drag-and-drop report templates, doctor digital signatures, and zero-cost WhatsApp report delivery.
          </p>

          <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start gap-3 mb-4">
            <a href="demo/" class="btn-hero-primary">
              <i class="fas fa-play-circle"></i> Launch Live Demo
            </a>
            <a href="register.php" class="btn-hero-outline">
              <i class="fas fa-rocket text-primary"></i> Start Free Cloud Trial
            </a>
            <a href="https://wa.me/919876543210?text=Hello%20VenSaas%20LabTech,%20I%20want%20to%20know%20more%20about%20your%20Lab%20Software%20(Cloud%20₹499/mo%20and%20Offline%20One-Time)" target="_blank" class="btn-hero-whatsapp">
              <i class="fab fa-whatsapp fs-5"></i> Chat on WhatsApp
            </a>
          </div>

          <!-- Bullet Points -->
          <div class="d-flex flex-wrap justify-content-center justify-content-lg-start gap-4 pt-2 text-muted small fw-semibold">
            <span><i class="fas fa-check-circle text-success me-1"></i> Monthly ₹499/- (No Hidden Charges)</span>
            <span><i class="fas fa-check-circle text-success me-1"></i> Offline One-Time Payment Available</span>
            <span><i class="fas fa-check-circle text-success me-1"></i> No Domain & Hosting Needed</span>
          </div>
        </div>

        <div class="col-lg-5">
          <!-- Interactive Mockup Card -->
          <div class="app-mockup-wrapper">
            <div class="mockup-toolbar">
              <div class="mockup-dot dot-red"></div>
              <div class="mockup-dot dot-yellow"></div>
              <div class="mockup-dot dot-green"></div>
              <span class="text-white-50 ms-2 font-monospace" style="font-size: 0.75rem;">labs.vensaas.com &bull; Clinical ERP</span>
            </div>
            <div class="mockup-inner p-3">
              <!-- Mini UI Representation -->
              <div class="d-flex align-items-center justify-content-between border-bottom pb-2 mb-3">
                <div class="d-flex align-items-center gap-2">
                  <div class="bg-primary text-white p-2 rounded" style="font-size: 0.8rem;"><i class="fas fa-flask"></i></div>
                  <div>
                    <div class="fw-bold text-dark" style="font-size: 0.85rem;">Central Diagnostics Lab</div>
                    <div class="text-muted" style="font-size: 0.7rem;">Live Workstation &bull; ISO 15189</div>
                  </div>
                </div>
                <span class="badge bg-success-subtle text-success border border-success-subtle" style="font-size: 0.7rem;">System Online</span>
              </div>

              <!-- Live Patient Demographics Card -->
              <div class="bg-light p-2 rounded border mb-2" style="font-size: 0.78rem;">
                <div class="d-flex justify-content-between mb-1">
                  <span class="text-muted">Patient: <strong>Mrs. Meenakshi S. (48/F)</strong></span>
                  <span class="badge bg-primary text-white">UHID-8841</span>
                </div>
                <div class="text-muted" style="font-size: 0.72rem;">Assays: CBC with Diff, Lipid Profile, Blood Glucose Fasting</div>
              </div>

              <!-- Barcode Tubes Preview -->
              <div class="d-flex gap-2 mb-2" style="font-size: 0.72rem;">
                <span class="badge" style="background: #f3e8ff; color: #7c3aed; border: 1px solid #ddd6fe;">
                  <i class="fas fa-vial me-1"></i>EDTA (Whole Blood)
                </span>
                <span class="badge" style="background: #fef9c3; color: #a16207; border: 1px solid #fef08a;">
                  <i class="fas fa-vial me-1"></i>SST (Serum)
                </span>
                <span class="badge" style="background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1;">
                  <i class="fas fa-vial me-1"></i>Fluoride (Plasma)
                </span>
              </div>

              <!-- Live Results Table Snippet -->
              <div class="border rounded overflow-hidden mb-2">
                <table class="table table-sm table-striped mb-0" style="font-size: 0.72rem;">
                  <thead class="table-light">
                    <tr><th>Parameter</th><th>Observed</th><th>Interval</th><th>Status</th></tr>
                  </thead>
                  <tbody>
                    <tr><td>Hemoglobin</td><td><strong>12.8 g/dL</strong></td><td>12.0 - 15.0</td><td><span class="badge bg-success text-white py-0">NORMAL</span></td></tr>
                    <tr><td>Total WBC</td><td class="text-danger"><strong>11,800 /mcL</strong></td><td>4,000 - 11,000</td><td><span class="badge bg-danger text-white py-0">HIGH</span></td></tr>
                    <tr><td>Platelet Count</td><td><strong>2,45,000</strong></td><td>1.5L - 4.5L</td><td><span class="badge bg-success text-white py-0">NORMAL</span></td></tr>
                  </tbody>
                </table>
              </div>

              <!-- Footer with Signatures & QR -->
              <div class="d-flex align-items-center justify-content-between pt-2 border-top" style="font-size: 0.7rem;">
                <div class="d-flex align-items-center gap-1 text-muted">
                  <i class="fas fa-qrcode fa-lg text-dark"></i>
                  <span>Digital QR Seal</span>
                </div>
                <div class="text-end">
                  <div class="fw-bold text-dark">Dr. Robert Vance, MD</div>
                  <div class="text-muted" style="font-size: 0.65rem;">Consultant Pathologist</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Trust Metrics Strip -->
      <div class="row g-3 mt-5">
        <div class="col-md-3 col-6">
          <div class="hero-stat-card">
            <div class="stat-number">500+</div>
            <div class="stat-label">Preloaded Lab Assays</div>
          </div>
        </div>
        <div class="col-md-3 col-6">
          <div class="hero-stat-card">
            <div class="stat-number">₹499</div>
            <div class="stat-label">Cloud Monthly (No Hidden Cost)</div>
          </div>
        </div>
        <div class="col-md-3 col-6">
          <div class="hero-stat-card">
            <div class="stat-number">100%</div>
            <div class="stat-label">Offline Capability (No Hosting)</div>
          </div>
        </div>
        <div class="col-md-3 col-6">
          <div class="hero-stat-card">
            <div class="stat-number">0 Sec</div>
            <div class="stat-label">WhatsApp PDF Report Share</div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- 3. SIX CORE FEATURE PILLARS -->
  <section class="py-5" id="features">
    <div class="container py-4">
      <div class="section-title-wrap">
        <span class="section-eyebrow">Everything Diagnostic Labs Need</span>
        <h2 class="section-heading">Built Specifically for Modern Pathology Labs & Diagnostic Centres</h2>
        <p class="section-subtext">Designed by clinical software engineers to eliminate lab operational bottlenecks, reduce reporting errors, and boost daily patient throughput.</p>
      </div>

      <div class="row g-4">
        <!-- Feature 1 -->
        <div class="col-lg-4 col-md-6">
          <div class="feature-card">
            <div class="feature-icon-box icon-blue">
              <i class="fas fa-receipt"></i>
            </div>
            <h3 class="feature-title">Fast Patient Registration & Billing</h3>
            <p class="feature-text">
              Rapid search for returning patients by phone or UHID. Handles doctor commissions, corporate discount structures, multiple payment splits (Cash, UPI, Card), and instant thermal/A4 invoices.
            </p>
          </div>
        </div>

        <!-- Feature 2 -->
        <div class="col-lg-4 col-md-6">
          <div class="feature-card">
            <div class="feature-icon-box icon-purple">
              <i class="fas fa-barcode"></i>
            </div>
            <h3 class="feature-title">Phlebotomy & Barcode Tube Workstation</h3>
            <p class="feature-text">
              Automatic specimen tube guidance (EDTA Purple, SST Gold, Fluoride Grey, Citrate Blue). Generates 1D vector barcode tube stickers ready for standard thermal label printers.
            </p>
          </div>
        </div>

        <!-- Feature 3 -->
        <div class="col-lg-4 col-md-6">
          <div class="feature-card">
            <div class="feature-icon-box icon-emerald">
              <i class="fas fa-file-medical-alt"></i>
            </div>
            <h3 class="feature-title">Drag-and-Drop Report Studio</h3>
            <p class="feature-text">
              Visually customize report header layouts, parameter columns, analytical methods, and abnormal flags. Comes with pre-formatted reference ranges for Male, Female, and Pediatric cases.
            </p>
          </div>
        </div>

        <!-- Feature 4 -->
        <div class="col-lg-4 col-md-6">
          <div class="feature-card">
            <div class="feature-icon-box icon-amber">
              <i class="fab fa-whatsapp"></i>
            </div>
            <h3 class="feature-title">Zero-Cost WhatsApp Web Dispatch</h3>
            <p class="feature-text">
              Direct integration with Web WhatsApp. Send verified PDF pathology reports and receipt messages to patients with a single click—no expensive API credits or third-party monthly subscriptions!
            </p>
          </div>
        </div>

        <!-- Feature 5 -->
        <div class="col-lg-4 col-md-6">
          <div class="feature-card">
            <div class="feature-icon-box icon-rose">
              <i class="fas fa-sliders-h"></i>
            </div>
            <h3 class="feature-title">Live In-Place Rate Card Studio</h3>
            <p class="feature-text">
              Update test and package prices on the fly directly from the catalog page without clicking into individual test edit forms. Apply bulk department percentage adjustments (+10% / -5%) in seconds.
            </p>
          </div>
        </div>

        <!-- Feature 6 -->
        <div class="col-lg-4 col-md-6">
          <div class="feature-card">
            <div class="feature-icon-box icon-indigo">
              <i class="fas fa-shield-alt"></i>
            </div>
            <h3 class="feature-title">Digital Signatures & Dynamic QR</h3>
            <p class="feature-text">
              Secure authorized reports with dual pathologist and lab technician digital signatures. Every report includes a tamper-proof QR code for instant authentication by doctors and hospitals.
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- 4. PRICING CARDS - CORE REQUIREMENT -->
  <section class="pricing-section" id="pricing">
    <div class="container">
      <div class="section-title-wrap">
        <span class="section-eyebrow">Clear, Transparent & Fair Pricing</span>
        <h2 class="section-heading">Choose The Right Edition For Your Laboratory</h2>
        <p class="section-subtext">No hidden fees. No per-report metering. No compulsory long-term lock-ins.</p>
      </div>

      <div class="row g-4 justify-content-center">
        <!-- PLAN 1: CLOUD SAAS MONTHLY 499/- (ONLINE) -->
        <div class="col-lg-5 col-md-6">
          <div class="price-card featured">
            <div class="pricing-popular-badge">
              <i class="fas fa-cloud me-1"></i> Cloud SaaS Plan
            </div>

            <div>
              <h3 class="pricing-title">Cloud Edition (Online)</h3>
              <p class="pricing-desc">
                Ideal for growing diagnostic centres wanting remote access from anywhere with automated cloud backups.
              </p>

              <div class="price-tag-wrap">
                <span class="price-currency">₹</span>
                <span class="price-value">499</span>
                <span class="price-period">/ month</span>
              </div>

              <div class="alert alert-success py-2 px-3 small fw-bold mb-4" style="border-radius: 8px;">
                <i class="fas fa-check-circle me-1"></i> No Hidden Charges Online &bull; Cancel Anytime
              </div>

              <ul class="price-feature-list">
                <li><i class="fas fa-check-circle"></i> <strong>Unlimited</strong> Patient Registrations & Bills</li>
                <li><i class="fas fa-check-circle"></i> <strong>500+ Built-in Assays</strong> (Biochemistry, Hematology, etc.)</li>
                <li><i class="fas fa-check-circle"></i> <strong>Visual Drag & Drop</strong> Report Template Studio</li>
                <li><i class="fas fa-check-circle"></i> <strong>Doctor Digital Signatures</strong> & Verification QR Code</li>
                <li><i class="fas fa-check-circle"></i> <strong>One-Click Web WhatsApp</strong> PDF Report Dispatch</li>
                <li><i class="fas fa-check-circle"></i> <strong>Vacutainer Tube Guide</strong> & Barcode Sticker Printing</li>
                <li><i class="fas fa-check-circle"></i> <strong>Live In-Place Rate Card</strong> & Bulk Tariff Adjuster</li>
                <li><i class="fas fa-check-circle"></i> <strong>Automated Daily Backups</strong> & High-Speed Cloud SSD</li>
                <li><i class="fas fa-check-circle"></i> Access from Desktop, Laptop, or Tablet Anywhere</li>
              </ul>
            </div>

            <div>
              <a href="register.php" class="btn btn-primary w-100 py-3 fw-bold shadow-sm" style="border-radius: 10px; font-size: 1rem;">
                <i class="fas fa-rocket me-2"></i> Start 14-Day Free Trial
              </a>
              <div class="text-center text-muted small mt-2">Instant Setup &bull; No Credit Card Required</div>
            </div>
          </div>
        </div>

        <!-- PLAN 2: OFFLINE ONE-TIME PAYMENT (NO DOMAIN & HOSTING REQUIRED) -->
        <div class="col-lg-5 col-md-6">
          <div class="price-card">
            <div class="pricing-popular-badge" style="background: linear-gradient(135deg, #059669 0%, #047857 100%);">
              <i class="fas fa-hdd me-1"></i> Lifetime License
            </div>

            <div>
              <h3 class="pricing-title">Offline Edition (On-Premise)</h3>
              <p class="pricing-desc">
                Install directly on your Lab PC / Local Server. 100% Offline with zero internet dependence.
              </p>

              <div class="price-tag-wrap">
                <span class="price-currency">₹</span>
                <span class="price-value" style="font-size: 2.5rem;">One-Time</span>
                <span class="price-period ms-1">Payment</span>
              </div>

              <div class="alert alert-info py-2 px-3 small fw-bold mb-4" style="border-radius: 8px;">
                <i class="fas fa-info-circle me-1"></i> No Domain & Hosting Required &bull; Lifetime Ownership
              </div>

              <ul class="price-feature-list">
                <li><i class="fas fa-check-circle"></i> <strong>Works 100% Offline</strong> – No Internet Connection Needed</li>
                <li><i class="fas fa-check-circle"></i> <strong>No Domain & Hosting Required</strong> – Save Recurring Costs</li>
                <li><i class="fas fa-check-circle"></i> <strong>Lifetime License</strong> – Zero Monthly or Annual Fees</li>
                <li><i class="fas fa-check-circle"></i> <strong>Local LAN Support</strong> – Multi-counter (Billing, Lab, Doctor)</li>
                <li><i class="fas fa-check-circle"></i> <strong>Complete Data Privacy</strong> – All Patient Records Stay in Your Lab</li>
                <li><i class="fas fa-check-circle"></i> <strong>Full Feature Suite</strong> (Billing, Phlebotomy, Reports, QR)</li>
                <li><i class="fas fa-check-circle"></i> <strong>Direct Thermal & Laser</strong> Printer Compatibility</li>
                <li><i class="fas fa-check-circle"></i> One-Click Local Database Backup & Easy Restore</li>
                <li><i class="fas fa-check-circle"></i> Free Installation & Remote Onboarding Assistance</li>
              </ul>
            </div>

            <div>
              <a href="https://wa.me/919876543210?text=Hello%20VenSaas%20LabTech,%20I%20am%20interested%20in%20the%20Offline%20One-Time%20Payment%20Lifetime%20License%20(No%20Domain%20%26%20Hosting)." target="_blank" class="btn btn-dark w-100 py-3 fw-bold shadow-sm" style="border-radius: 10px; font-size: 1rem; background: var(--dark);">
                <i class="fab fa-whatsapp me-2 text-success"></i> Inquire Offline Lifetime Price
              </a>
              <div class="text-center text-muted small mt-2">Personalized Quote &bull; Instant WhatsApp Response</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- 5. OFFLINE VS CLOUD COMPARISON TABLE -->
  <section class="py-5 bg-white" id="offline-vs-cloud">
    <div class="container py-4">
      <div class="section-title-wrap">
        <span class="section-eyebrow">Compare Deployment Models</span>
        <h2 class="section-heading">Online Cloud SaaS vs. Offline On-Premise</h2>
        <p class="section-subtext">Both editions deliver the exact same comprehensive pathology reporting and clinical workflows. Pick what fits your lab best.</p>
      </div>

      <div class="table-responsive">
        <table class="comparison-table">
          <thead>
            <tr>
              <th width="36%">Feature / Capability</th>
              <th width="32%" class="text-primary text-center">Cloud SaaS Edition (₹499/mo)</th>
              <th width="32%" class="text-dark text-center">Offline On-Premise Edition (One-Time)</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><strong>Active Internet Requirement</strong></td>
              <td class="text-center"><span class="badge bg-info-subtle text-info border">Required</span></td>
              <td class="text-center"><span class="badge bg-success-subtle text-success border">100% Offline (No Internet Needed)</span></td>
            </tr>
            <tr>
              <td><strong>Domain & Web Hosting</strong></td>
              <td class="text-center">Hosted by VenSaas (Included)</td>
              <td class="text-center"><strong class="text-success">Not Required (Zero Server Costs)</strong></td>
            </tr>
            <tr>
              <td><strong>Payment Structure</strong></td>
              <td class="text-center"><strong class="text-primary">₹499 / Month</strong> (No Hidden Charges)</td>
              <td class="text-center"><strong class="text-dark">One-Time Lifetime Payment</strong></td>
            </tr>
            <tr>
              <td><strong>Multi-Counter LAN Operation</strong></td>
              <td class="text-center">Via Browser / Cloud Login</td>
              <td class="text-center">Via Local Office LAN Wi-Fi / Ethernet</td>
            </tr>
            <tr>
              <td><strong>Patient Data Storage</strong></td>
              <td class="text-center">Secure Cloud Data Centre (Daily Backups)</td>
              <td class="text-center">100% On-Premise in Your Lab PC</td>
            </tr>
            <tr>
              <td><strong>Barcoding & Tube Stickers</strong></td>
              <td class="text-center"><i class="fas fa-check-circle text-success"></i> Supported</td>
              <td class="text-center"><i class="fas fa-check-circle text-success"></i> Supported</td>
            </tr>
            <tr>
              <td><strong>Visual Drag-Drop Report Designer</strong></td>
              <td class="text-center"><i class="fas fa-check-circle text-success"></i> Included</td>
              <td class="text-center"><i class="fas fa-check-circle text-success"></i> Included</td>
            </tr>
            <tr>
              <td><strong>Web WhatsApp PDF Dispatch</strong></td>
              <td class="text-center"><i class="fas fa-check-circle text-success"></i> 1-Click (No API Fees)</td>
              <td class="text-center"><i class="fas fa-check-circle text-success"></i> 1-Click via Browser</td>
            </tr>
            <tr>
              <td><strong>Software Updates</strong></td>
              <td class="text-center">Automatic & Continuous</td>
              <td class="text-center">Free Minor Updates Included</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </section>

  <!-- 6. FREQUENTLY ASKED QUESTIONS -->
  <section class="faq-section" id="faq">
    <div class="container">
      <div class="section-title-wrap">
        <span class="section-eyebrow">Clear Answers</span>
        <h2 class="section-heading">Frequently Asked Questions</h2>
        <p class="section-subtext">Everything you need to know about getting started with VenSaas LabTech.</p>
      </div>

      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="accordion" id="faqAccordion">

            <!-- Question 1 -->
            <div class="accordion-item border-0">
              <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                  1. Do I need to purchase a domain name or web hosting for the Offline Edition?
                </button>
              </h2>
              <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                  <strong>No domain or web hosting is required!</strong> The Offline Edition runs directly on your local laboratory computer or clinic desktop. You do not pay any yearly domain renewals, web hosting bills, or cloud bandwidth costs. It is a genuine one-time investment.
                </div>
              </div>
            </div>

            <!-- Question 2 -->
            <div class="accordion-item border-0">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                  2. Are there any hidden fees or per-patient charges on the ₹499/month Cloud plan?
                </button>
              </h2>
              <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                  <strong>There are zero hidden fees!</strong> The ₹499/month Cloud SaaS plan includes unlimited patient registrations, unlimited pathology report generation, unlimited barcode printing, automated daily backups, and free updates. We do not meter your bills or charge extra per test.
                </div>
              </div>
            </div>

            <!-- Question 3 -->
            <div class="accordion-item border-0">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                  3. How does the WhatsApp report dispatch work without paid API charges?
                </button>
              </h2>
              <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                  VenSaas LabTech integrates directly with standard Web WhatsApp through your desktop browser. When you click <em>"Send on WhatsApp"</em>, it automatically prepares a professional message with the patient's report summary and direct report link, allowing you to send it directly without paying recurring third-party API service fees.
                </div>
              </div>
            </div>

            <!-- Question 4 -->
            <div class="accordion-item border-0">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                  4. Can multiple staff members use LabTech at the same time?
                </button>
              </h2>
              <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                  Yes! Both editions support multi-user operations. Your reception staff can enter patient bills at the front desk, phlebotomists can verify sample collection in the collection room, and the pathologist can authorize and sign reports from their office. In the offline version, this operates seamlessly across your local clinic LAN network.
                </div>
              </div>
            </div>

            <!-- Question 5 -->
            <div class="accordion-item border-0">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                  5. Can I test the full software before purchasing?
                </button>
              </h2>
              <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                  Yes! You can immediately explore our interactive <strong><a href="demo/" target="_blank">Live Demo</a></strong> with full sample data (billing, phlebotomy, barcode printing, report designer, and rate card). You can also sign up for a 14-day free Cloud trial with no credit card required.
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- 7. CALL TO ACTION STRIP -->
  <section class="py-5">
    <div class="container">
      <div class="cta-banner">
        <h2 class="fw-bold mb-3" style="font-size: 2.4rem;">Upgrade Your Diagnostic Centre Today</h2>
        <p class="mb-4 opacity-90 mx-auto" style="max-width: 600px; font-size: 1.1rem;">
          Join pathology laboratories using VenSaas LabTech for seamless patient billing, smart barcoded tube tracking, and automated digital reporting.
        </p>
        <div class="d-flex flex-wrap justify-content-center gap-3">
          <a href="demo/" class="btn btn-light text-primary px-4 py-3 fw-bold shadow-sm" style="border-radius: 10px; font-size: 1rem;">
            <i class="fas fa-desktop me-2"></i> Try Live Demo
          </a>
          <a href="register.php" class="btn btn-outline-light px-4 py-3 fw-bold" style="border-radius: 10px; font-size: 1rem;">
            <i class="fas fa-rocket me-2"></i> Start Free Trial
          </a>
          <a href="https://wa.me/919876543210?text=Hi%20VenSaas%20LabTech,%20I%20want%20to%20get%20started%20with%20LabTech%20Software" target="_blank" class="btn btn-success px-4 py-3 fw-bold shadow-sm" style="border-radius: 10px; font-size: 1rem; background: #25d366; border: none;">
            <i class="fab fa-whatsapp me-2"></i> Connect on WhatsApp
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- 8. FOOTER -->
  <footer class="footer-landing">
    <div class="container">
      <div class="row g-4 mb-5">
        <div class="col-lg-4 col-md-6">
          <div class="d-flex align-items-center gap-2 mb-3">
            <div class="brand-icon-box" style="width: 34px; height: 34px; font-size: 0.9rem;">
              <i class="fas fa-microscope"></i>
            </div>
            <span class="text-white fw-bold fs-5">VenSaas LabTech</span>
          </div>
          <p class="small text-muted" style="line-height: 1.6;">
            Next-generation Laboratory Information Management System (LIMS) & Clinical ERP designed for standalone pathology laboratories, hospital diagnostics, and scan centres.
          </p>
          <div class="d-flex gap-3 text-white-50 fs-5 pt-2">
            <a href="#" class="text-secondary"><i class="fab fa-facebook"></i></a>
            <a href="#" class="text-secondary"><i class="fab fa-twitter"></i></a>
            <a href="#" class="text-secondary"><i class="fab fa-linkedin"></i></a>
            <a href="#" class="text-secondary"><i class="fab fa-youtube"></i></a>
          </div>
        </div>

        <div class="col-lg-2 col-md-6">
          <h4 class="footer-heading">Quick Links</h4>
          <ul class="footer-links">
            <li><a href="demo/"><i class="fas fa-chevron-right me-1 small"></i> Live Demo</a></li>
            <li><a href="register.php"><i class="fas fa-chevron-right me-1 small"></i> Free Trial</a></li>
            <li><a href="#pricing"><i class="fas fa-chevron-right me-1 small"></i> Price Card</a></li>
            <li><a href="#features"><i class="fas fa-chevron-right me-1 small"></i> Features</a></li>
            <li><a href="#faq"><i class="fas fa-chevron-right me-1 small"></i> FAQs</a></li>
            <li><a href="brochure.php" target="_blank"><i class="fas fa-chevron-right me-1 small"></i> Digital Brochure</a></li>
          </ul>
        </div>

        <div class="col-lg-3 col-md-6">
          <h4 class="footer-heading">Features</h4>
          <ul class="footer-links">
            <li><a href="demo/bill_add.php">Patient Smart Billing</a></li>
            <li><a href="demo/sample_collection.php">Phlebotomy Barcode Station</a></li>
            <li><a href="demo/template_designer.php">Report Template Designer</a></li>
            <li><a href="demo/rate_card.php">In-Place Rate Card Studio</a></li>
            <li><a href="demo/sign_master.php">Doctor Digital Signatures</a></li>
          </ul>
        </div>

        <div class="col-lg-3 col-md-6">
          <h4 class="footer-heading">Contact & Support</h4>
          <ul class="footer-links text-muted small">
            <li class="mb-2"><i class="fas fa-envelope text-primary me-2"></i> support@vensaas.com</li>
            <li class="mb-2"><i class="fab fa-whatsapp text-success me-2"></i> +91 98765 43210</li>
            <li class="mb-2"><i class="fas fa-map-marker-alt text-danger me-2"></i> Health Tech Towers, Chennai, India</li>
            <li class="mt-3">
              <a href="admin/login.php" class="btn btn-outline-secondary btn-sm text-white w-100 py-2">
                <i class="fas fa-lock me-1"></i> Super Admin Portal
              </a>
            </li>
          </ul>
        </div>
      </div>

      <div class="border-top border-secondary pt-4 d-flex flex-wrap align-items-center justify-content-between text-muted small">
        <div>
          &copy; <?= date('Y') ?> VenSaas LabTech. All rights reserved. Clinical Diagnostics ERP.
        </div>
        <div class="d-flex gap-3">
          <a href="#" class="text-muted text-decoration-none">Privacy Policy</a>
          <a href="#" class="text-muted text-decoration-none">Terms of Service</a>
          <a href="admin/login.php" class="text-muted text-decoration-none">Admin Login</a>
        </div>
      </div>
    </div>
  </footer>

  <!-- Bootstrap Bundle JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>