<?php
/**
 * VenSaas LabTech - Diagnostic Laboratory ERP & Reporting Software
 * High-Converting Digital Brochure & A4 Printable Marketing Flyer
 * Sharable link: https://labs.vensaas.com/brochure.php
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>VenSaas LabTech | Pathology Lab Reporting & Management Software Brochure</title>
  
  <!-- Bootstrap 5 & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@600;700;800&display=swap" rel="stylesheet">

  <style>
    :root {
      --brand-primary: #0284c7;
      --brand-dark: #0369a1;
      --brand-accent: #06b6d4;
      --brand-success: #10b981;
      --slate-900: #0f172a;
      --slate-800: #1e293b;
      --slate-600: #475569;
      --slate-100: #f1f5f9;
      --border-color: #e2e8f0;
    }

    body {
      font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
      background: #f8fafc;
      color: var(--slate-900);
      margin: 0;
      padding: 30px 15px 60px;
    }

    /* Floating Action Bar (Screen Only) */
    .brochure-actions {
      position: sticky;
      top: 15px;
      z-index: 1000;
      max-width: 900px;
      margin: 0 auto 25px;
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
      border: 1px solid var(--border-color);
      border-radius: 12px;
      padding: 12px 20px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.06);
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 10px;
    }

    /* Flyer A4 Container */
    .flyer-paper {
      max-width: 900px;
      margin: 0 auto;
      background: #ffffff;
      border: 1px solid var(--border-color);
      border-radius: 16px;
      box-shadow: 0 12px 35px rgba(15, 23, 42, 0.07);
      overflow: hidden;
    }

    /* Flyer Header */
    .flyer-header {
      background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
      color: #ffffff;
      padding: 36px 40px;
      position: relative;
    }
    .flyer-badge {
      display: inline-block;
      background: rgba(255, 255, 255, 0.2);
      border: 1px solid rgba(255, 255, 255, 0.4);
      color: #ffffff;
      font-size: 0.75rem;
      font-weight: 800;
      letter-spacing: 0.6px;
      text-transform: uppercase;
      padding: 4px 14px;
      border-radius: 20px;
      margin-bottom: 12px;
    }
    .flyer-title {
      font-size: 2.2rem;
      font-weight: 800;
      letter-spacing: -0.02em;
      margin-bottom: 8px;
    }
    .flyer-subtitle {
      font-size: 1.05rem;
      color: #e0f2fe;
      max-width: 700px;
      margin-bottom: 0;
    }

    /* Pricing Highlights Banner */
    .pricing-strip {
      background: #0f172a;
      color: #ffffff;
      padding: 20px 40px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 20px;
    }
    .price-pill-box {
      display: flex;
      align-items: center;
      gap: 14px;
    }
    .price-big {
      font-family: 'JetBrains Mono', monospace;
      font-size: 2.2rem;
      font-weight: 800;
      color: #38bdf8;
      line-height: 1;
    }
    .price-big small {
      font-size: 0.95rem;
      color: #94a3b8;
    }

    /* Content Body */
    .flyer-body {
      padding: 40px;
    }

    /* Feature Grid */
    .feature-box {
      border: 1px solid var(--border-color);
      border-radius: 12px;
      padding: 20px;
      background: #f8fafc;
      height: 100%;
      transition: all 0.2s;
    }
    .feature-box:hover {
      background: #ffffff;
      border-color: var(--brand-primary);
      box-shadow: 0 6px 18px rgba(2, 132, 199, 0.08);
      transform: translateY(-2px);
    }
    .feature-icon {
      width: 44px;
      height: 44px;
      border-radius: 10px;
      background: #e0f2fe;
      color: var(--brand-primary);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.25rem;
      margin-bottom: 14px;
    }
    .feature-title {
      font-weight: 800;
      font-size: 1.02rem;
      color: var(--slate-900);
      margin-bottom: 6px;
    }
    .feature-desc {
      font-size: 0.86rem;
      color: var(--slate-600);
      line-height: 1.5;
      margin: 0;
    }

    /* Comparison Dual Box */
    .plan-box {
      border: 2px solid var(--border-color);
      border-radius: 14px;
      padding: 24px;
      background: #ffffff;
      height: 100%;
    }
    .plan-box.featured {
      border-color: var(--brand-primary);
      background: #f0f9ff;
    }
    .plan-title {
      font-weight: 800;
      font-size: 1.25rem;
      color: var(--slate-900);
      margin-bottom: 4px;
    }
    .plan-rate {
      font-family: 'JetBrains Mono', monospace;
      font-size: 1.8rem;
      font-weight: 800;
      color: var(--brand-dark);
      margin-bottom: 14px;
    }
    .plan-list {
      list-style: none;
      padding: 0;
      margin: 0;
      font-size: 0.88rem;
    }
    .plan-list li {
      margin-bottom: 10px;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .plan-list li i {
      color: var(--brand-success);
    }

    /* Flyer Footer */
    .flyer-footer {
      background: #f8fafc;
      border-top: 1px solid var(--border-color);
      padding: 26px 40px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 15px;
    }

    /* Print Formatting (For A4 Marketing PDF Flyer) */
    @media print {
      body {
        background: #ffffff !important;
        padding: 0 !important;
        margin: 0 !important;
      }
      .brochure-actions, .no-print {
        display: none !important;
      }
      .flyer-paper {
        border: none !important;
        box-shadow: none !important;
        max-width: 100% !important;
      }
      .flyer-header {
        padding: 24px 30px !important;
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
      }
      .pricing-strip {
        padding: 16px 30px !important;
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
      }
      .flyer-body {
        padding: 24px 30px !important;
      }
      .feature-box, .plan-box {
        page-break-inside: avoid;
      }
    }
  </style>
</head>
<body>

  <!-- Screen Top Bar -->
  <div class="brochure-actions no-print">
    <div class="d-flex align-items-center gap-2">
      <div class="bg-primary text-white p-2 rounded" style="font-size: 0.85rem;"><i class="fas fa-microscope"></i></div>
      <div>
        <strong class="text-dark">VenSaas LabTech Brochure</strong>
        <div class="text-muted" style="font-size: 0.72rem;">Pathology ERP &bull; labs.vensaas.com</div>
      </div>
    </div>
    <div class="d-flex align-items-center gap-2">
      <button onclick="window.print()" class="btn btn-outline-secondary btn-sm fw-bold">
        <i class="fas fa-print me-1"></i> Print / Save PDF
      </button>
      <a href="https://api.whatsapp.com/send?text=Check%20out%20VenSaas%20LabTech%20-%20Pathology%20Lab%20Reporting%20%26%20Management%20Software.%20Cloud%20SaaS%20at%20%E2%82%B9499/Month%20or%20Offline%20One-Time%20Payment%20(No%20Hosting%20Required).%20Explore%20Live%20Demo:%20https://labs.vensaas.com/demo/%20%7C%20Brochure:%20https://labs.vensaas.com/brochure.php" target="_blank" class="btn btn-success btn-sm fw-bold" style="background: #25d366; border: none;">
        <i class="fab fa-whatsapp me-1"></i> Share on WhatsApp
      </a>
      <a href="demo/" target="_blank" class="btn btn-primary btn-sm fw-bold">
        <i class="fas fa-play-circle me-1"></i> Live Demo
      </a>
      <a href="register.php" target="_blank" class="btn btn-dark btn-sm fw-bold">
        <i class="fas fa-rocket me-1"></i> Free Trial
      </a>
    </div>
  </div>

  <!-- A4 Digital Marketing Flyer / Brochure Container -->
  <div class="flyer-paper">
    <!-- Header Banner -->
    <div class="flyer-header">
      <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
        <div>
          <span class="flyer-badge"><i class="fas fa-award me-1"></i> NABL ISO 15189 Ready Diagnostic ERP</span>
          <h1 class="flyer-title">VenSaas LabTech</h1>
          <p class="flyer-subtitle">Complete Pathology Laboratory Reporting, Billing, Barcoding & Multi-Center Diagnostic Management Software</p>
        </div>
        <div class="text-end text-white-50" style="font-size: 0.8rem;">
          <div class="text-white fw-bold">Official Portal:</div>
          <a href="https://labs.vensaas.com/" class="text-white text-decoration-none">labs.vensaas.com</a>
        </div>
      </div>
    </div>

    <!-- Pricing Highlights Strip -->
    <div class="pricing-strip">
      <div class="price-pill-box">
        <div>
          <div class="text-uppercase small text-white-50 fw-bold">Cloud SaaS Plan</div>
          <div class="price-big">₹499 <small>/ month</small></div>
        </div>
        <div class="border-start border-secondary ps-3 ms-2">
          <div class="badge bg-success-subtle text-success border border-success-subtle fw-bold mb-1">Zero Hidden Charges</div>
          <div class="small text-white-50">Unlimited Patients, Bills & Reports</div>
        </div>
      </div>

      <div class="price-pill-box border-start border-secondary ps-lg-4">
        <div>
          <div class="text-uppercase small text-white-50 fw-bold">Offline Edition</div>
          <div class="price-big" style="color: #34d399;">Lifetime <small>Payment</small></div>
        </div>
        <div class="border-start border-secondary ps-3 ms-2">
          <div class="badge bg-info-subtle text-info border border-info-subtle fw-bold mb-1">No Hosting Required</div>
          <div class="small text-white-50">100% Offline on Local PC / LAN</div>
        </div>
      </div>
    </div>

    <!-- Brochure Body Content -->
    <div class="flyer-body">
      <!-- 6 Key Capabilities -->
      <div class="text-center mb-4">
        <h4 class="fw-bold text-dark mb-1">Engineered Specifically For Pathology Laboratories</h4>
        <p class="text-muted small">Everything required to automate reception billing, phlebotomy, analytical reporting, and patient communication.</p>
      </div>

      <div class="row g-3 mb-4">
        <div class="col-md-4 col-sm-6">
          <div class="feature-box">
            <div class="feature-icon"><i class="fas fa-receipt"></i></div>
            <div class="feature-title">Smart Reception Billing</div>
            <p class="feature-desc">Fast patient registration, doctor commission tracking, corporate discounts, and instant thermal/A4 receipt printing.</p>
          </div>
        </div>

        <div class="col-md-4 col-sm-6">
          <div class="feature-box">
            <div class="feature-icon"><i class="fas fa-barcode"></i></div>
            <div class="feature-title">Phlebotomy & Barcode Tubes</div>
            <p class="feature-desc">Color-coded vacutainer tube guide (EDTA, SST, Fluoride, Citrate) with 1D vector barcode sticker generator for tubes.</p>
          </div>
        </div>

        <div class="col-md-4 col-sm-6">
          <div class="feature-box">
            <div class="feature-icon"><i class="fas fa-file-medical-alt"></i></div>
            <div class="feature-title">Drag-Drop Report Designer</div>
            <p class="feature-desc">Visual layout studio for headers, test parameters, biological reference intervals, and analytical methodology notes.</p>
          </div>
        </div>

        <div class="col-md-4 col-sm-6">
          <div class="feature-box">
            <div class="feature-icon" style="background: #dcfce7; color: #15803d;"><i class="fab fa-whatsapp"></i></div>
            <div class="feature-title">Zero-Cost WhatsApp Dispatch</div>
            <p class="feature-desc">Send verified PDF diagnostic reports directly to patients' WhatsApp without recurring third-party API subscription costs.</p>
          </div>
        </div>

        <div class="col-md-4 col-sm-6">
          <div class="feature-box">
            <div class="feature-icon"><i class="fas fa-sliders-h"></i></div>
            <div class="feature-title">In-Place Editable Rate Card</div>
            <p class="feature-desc">Modify test and package prices directly on the catalog without opening individual test forms. Bulk percentage revisions.</p>
          </div>
        </div>

        <div class="col-md-4 col-sm-6">
          <div class="feature-box">
            <div class="feature-icon"><i class="fas fa-qrcode"></i></div>
            <div class="feature-title">Doctor Digital Signatures & QR</div>
            <p class="feature-desc">Dual authorizer sign-offs (Pathologist & Technician) with tamper-proof QR code verification on all printed reports.</p>
          </div>
        </div>
      </div>

      <!-- Pricing Plans Comparison Grid -->
      <div class="row g-3 mb-4">
        <!-- Cloud Plan -->
        <div class="col-md-6">
          <div class="plan-box featured">
            <span class="badge bg-primary text-white mb-2">ONLINE CLOUD SAAS</span>
            <div class="plan-title">Cloud Edition</div>
            <div class="plan-rate">₹499 <span class="fs-6 text-muted fw-normal">/ Month</span></div>
            <ul class="plan-list">
              <li><i class="fas fa-check-circle"></i> <strong>Zero Hidden Charges</strong> Online</li>
              <li><i class="fas fa-check-circle"></i> Unlimited Patient Bills & Reports</li>
              <li><i class="fas fa-check-circle"></i> 500+ Built-in Pathology Tests & Packages</li>
              <li><i class="fas fa-check-circle"></i> 1-Click WhatsApp PDF Report Dispatch</li>
              <li><i class="fas fa-check-circle"></i> Automatic Daily Cloud Backups & SSL</li>
              <li><i class="fas fa-check-circle"></i> Access from PC, Laptop, or Tablet Anywhere</li>
            </ul>
          </div>
        </div>

        <!-- Offline Plan -->
        <div class="col-md-6">
          <div class="plan-box">
            <span class="badge bg-success text-white mb-2">LOCAL ON-PREMISE</span>
            <div class="plan-title">Offline Lifetime Edition</div>
            <div class="plan-rate">One-Time <span class="fs-6 text-muted fw-normal">Payment</span></div>
            <ul class="plan-list">
              <li><i class="fas fa-check-circle"></i> <strong>No Domain & Hosting Required</strong></li>
              <li><i class="fas fa-check-circle"></i> Works 100% Offline (No Internet Needed)</li>
              <li><i class="fas fa-check-circle"></i> Lifetime License & Zero Recurring Fees</li>
              <li><i class="fas fa-check-circle"></i> Complete Patient Data Privacy on Local PC</li>
              <li><i class="fas fa-check-circle"></i> Multi-Counter LAN (Reception, Lab, Doctor)</li>
              <li><i class="fas fa-check-circle"></i> Thermal & Laser Printer Compatibility</li>
            </ul>
          </div>
        </div>
      </div>

      <!-- How to Get Started in 3 Steps -->
      <div class="bg-light p-3 rounded-3 border">
        <div class="row text-center g-2">
          <div class="col-md-4">
            <span class="badge bg-primary rounded-pill mb-1">Step 1</span>
            <div class="fw-bold small text-dark">Explore Live Demo</div>
            <div class="text-muted" style="font-size: 0.76rem;">Visit <a href="demo/" target="_blank">labs.vensaas.com/demo/</a></div>
          </div>
          <div class="col-md-4">
            <span class="badge bg-primary rounded-pill mb-1">Step 2</span>
            <div class="fw-bold small text-dark">Register 14-Day Trial</div>
            <div class="text-muted" style="font-size: 0.76rem;">Fill quick form on <a href="register.php" target="_blank">register.php</a></div>
          </div>
          <div class="col-md-4">
            <span class="badge bg-success rounded-pill mb-1">Step 3</span>
            <div class="fw-bold small text-dark">Go Live in 2 Minutes</div>
            <div class="text-muted" style="font-size: 0.76rem;">Start billing & printing reports immediately</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Flyer Footer -->
    <div class="flyer-footer">
      <div>
        <div class="fw-bold text-dark" style="font-size: 1rem;"><i class="fas fa-microscope text-primary me-2"></i>VenSaas LabTech Software</div>
        <div class="text-muted small">Official Website: <strong>https://labs.vensaas.com/</strong> &bull; Cloud &bull; Offline LAN</div>
      </div>
      <div class="text-end">
        <a href="https://wa.me/919876543210?text=Hi%20VenSaas%20LabTech,%20I%20saw%20your%20brochure%20and%20want%20to%20register%20my%20lab" target="_blank" class="btn btn-success btn-sm fw-bold px-3 py-2" style="background: #25d366; border: none;">
          <i class="fab fa-whatsapp me-1"></i> WhatsApp: +91 98765 43210
        </a>
      </div>
    </div>
  </div>

  <div class="text-center text-muted small mt-4 no-print">
    &copy; <?= date('Y') ?> VenSaas LabTech. Designed for Modern Pathology Laboratories & Diagnostic Centres.
  </div>

</body>
</html>