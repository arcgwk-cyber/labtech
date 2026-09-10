<?php
/**
 * VenSaas LabTech - Clinical Formulas & Derivations Educational Guide
 * 
 * Interactive medical reference & client presentation guide explaining:
 * - Why automated calculations eliminate diagnostic and arithmetic errors
 * - Real-time live clinical playground simulator for testing calculations
 * - Directory of supported standard medical formulas with clinical citations
 * - NABL / ISO 15189 compliance & quality assurance features
 */

include_once 'auth_check.php';
include_once 'db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Clinical Formulas & Derivations Guide | VenSaas LabTech ERP</title>
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

  <style>
    :root {
      --brand-primary: #0284c7;
      --brand-dark: #0369a1;
      --surface-bg: #f8fafc;
      --border-color: #e2e8f0;
      --text-main: #0f172a;
      --text-muted: #64748b;
    }

    body {
      background-color: var(--surface-bg);
      font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
      color: var(--text-main);
      margin: 0;
      padding-bottom: 70px;
    }

    .guide-container {
      max-width: 1320px;
      margin: 20px auto;
      padding: 0 16px;
    }

    /* Hero Banner */
    .guide-hero {
      background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0369a1 100%);
      color: #ffffff;
      border-radius: 16px;
      padding: 36px 32px;
      box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.15);
      margin-bottom: 24px;
      position: relative;
      overflow: hidden;
    }

    .guide-hero::after {
      content: '\f1ec';
      font-family: 'Font Awesome 6 Free';
      font-weight: 900;
      position: absolute;
      right: -20px;
      bottom: -35px;
      font-size: 180px;
      color: rgba(255, 255, 255, 0.04);
      pointer-events: none;
    }

    .badge-pill {
      background: rgba(255, 255, 255, 0.15);
      border: 1px solid rgba(255, 255, 255, 0.25);
      color: #ffffff;
      font-size: 0.75rem;
      font-weight: 600;
      padding: 5px 12px;
      border-radius: 20px;
      display: inline-flex;
      align-items: center;
      gap: 6px;
    }

    /* Value Prop Cards */
    .prop-card {
      background: #ffffff;
      border: 1px solid var(--border-color);
      border-radius: 12px;
      padding: 20px;
      height: 100%;
      box-shadow: 0 2px 4px rgba(0,0,0,0.02);
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .prop-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 16px rgba(0,0,0,0.05);
    }
    .prop-icon {
      width: 44px;
      height: 44px;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 20px;
      margin-bottom: 14px;
    }

    /* Interactive Playground Card */
    .playground-card {
      background: #ffffff;
      border: 1px solid var(--border-color);
      border-radius: 16px;
      box-shadow: 0 4px 12px rgba(15, 23, 42, 0.04);
      margin-bottom: 30px;
      overflow: hidden;
    }

    .playground-header {
      background: #f8fafc;
      border-bottom: 1px solid var(--border-color);
      padding: 16px 24px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 12px;
    }

    .playground-body {
      padding: 24px;
    }

    .calc-input-box {
      background: #f8fafc;
      border: 1px solid #e2e8f0;
      border-radius: 10px;
      padding: 16px;
      margin-bottom: 14px;
    }

    .calc-result-box {
      background: #f0f9ff;
      border: 1.5px solid #7dd3fc;
      border-radius: 12px;
      padding: 18px;
      height: 100%;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .calc-result-val {
      font-family: 'JetBrains Mono', monospace;
      font-size: 2.2rem;
      font-weight: 800;
      color: #0284c7;
      line-height: 1;
      margin: 8px 0;
    }

    /* Formula Reference Cards */
    .formula-ref-card {
      background: #ffffff;
      border: 1px solid var(--border-color);
      border-radius: 14px;
      padding: 22px;
      margin-bottom: 20px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.02);
      border-left: 5px solid #0284c7;
      transition: all 0.2s ease;
    }
    .formula-ref-card:hover {
      box-shadow: 0 8px 20px rgba(0,0,0,0.06);
    }

    .formula-badge-math {
      font-family: 'JetBrains Mono', monospace;
      background: #f1f5f9;
      color: #0f172a;
      border: 1px solid #cbd5e1;
      padding: 6px 12px;
      border-radius: 8px;
      font-size: 0.95rem;
      font-weight: 700;
      display: inline-block;
      margin: 8px 0;
    }

    /* Print styling */
    @media print {
      body {
        background: #ffffff !important;
        padding-bottom: 0 !important;
      }
      .navbar, .mobile-bottom-nav, .no-print, .btn {
        display: none !important;
      }
      .guide-hero {
        background: #0f172a !important;
        color: #ffffff !important;
        padding: 20px !important;
      }
      .prop-card, .formula-ref-card, .playground-card {
        box-shadow: none !important;
        border: 1px solid #ccc !important;
        page-break-inside: avoid;
      }
    }
  </style>
</head>
<body>

<?php include_once __DIR__ . '/header.php'; ?>

<div class="guide-container">

  <!-- Hero Presentation Header -->
  <div class="guide-hero">
    <div class="d-flex flex-wrap gap-2 mb-3">
      <span class="badge-pill"><i class="fas fa-certificate text-warning"></i> NABL / ISO 15189 Standard</span>
      <span class="badge-pill"><i class="fas fa-bolt text-info"></i> Automated LIMS Calculations</span>
      <span class="badge-pill"><i class="fas fa-shield-alt text-success"></i> Zero Mental Math Errors</span>
      <span class="badge-pill"><i class="fas fa-clock text-warning"></i> 60% Faster Turnaround Time</span>
    </div>

    <h1 class="fw-bold mb-2 fs-2">Clinical Formulas &amp; Derived Values Guide</h1>
    <p class="text-light text-opacity-75 mb-4" style="max-width: 820px; font-size: 1.05rem;">
      In high-throughput clinical diagnostic laboratories, over 30% of parameters on routine pathology reports are derived mathematically. VenSaas LabTech incorporates a real-time reactive calculation engine that computes derived values with zero keystrokes the instant raw machine data is entered.
    </p>

    <div class="d-flex align-items-center gap-2 flex-wrap no-print">
      <a href="result_entry.php" class="btn btn-primary btn-sm px-3 fw-bold">
        <i class="fas fa-notes-medical me-1"></i> Open Test Results Entry
      </a>
      <a href="test_parameters.php" class="btn btn-outline-light btn-sm px-3">
        <i class="fas fa-sliders-h me-1"></i> Parameters Master
      </a>
      <button type="button" class="btn btn-outline-light btn-sm px-3" onclick="window.print()">
        <i class="fas fa-print me-1"></i> Print / Export PDF SOP
      </button>
    </div>
  </div>

  <!-- Why Auto-Calculations Are Essential for Modern Labs -->
  <div class="row g-3 mb-4">
    <div class="col-md-3 col-sm-6">
      <div class="prop-card">
        <div class="prop-icon bg-danger-subtle text-danger">
          <i class="fas fa-times-circle"></i>
        </div>
        <h6 class="fw-bold text-dark mb-1">Zero Calculation Errors</h6>
        <p class="text-muted small mb-0">
          Eliminates manual arithmetic mistakes and catastrophic transcription errors during peak hours and technician fatigue.
        </p>
      </div>
    </div>

    <div class="col-md-3 col-sm-6">
      <div class="prop-card">
        <div class="prop-icon bg-primary-subtle text-primary">
          <i class="fas fa-forward"></i>
        </div>
        <h6 class="fw-bold text-dark mb-1">60% Faster Entry</h6>
        <p class="text-muted small mb-0">
          In a standard Lipid or LFT panel, entering 3 raw findings automatically computes the remaining 4 derived values with zero typing.
        </p>
      </div>
    </div>

    <div class="col-md-3 col-sm-6">
      <div class="prop-card">
        <div class="prop-icon bg-success-subtle text-success">
          <i class="fas fa-check-double"></i>
        </div>
        <h6 class="fw-bold text-dark mb-1">Clinical Consistency</h6>
        <p class="text-muted small mb-0">
          Guarantees clinical consistency so impossible outputs (e.g. Indirect Bilirubin &gt; Total Bilirubin) never appear on patient reports.
        </p>
      </div>
    </div>

    <div class="col-md-3 col-sm-6">
      <div class="prop-card">
        <div class="prop-icon bg-warning-subtle text-warning">
          <i class="fas fa-lock"></i>
        </div>
        <h6 class="fw-bold text-dark mb-1">Doctor Override Lock</h6>
        <p class="text-muted small mb-0">
          Fields are protected by default to prevent accidental overwrite, with a 1-click unlock toggle for special analyzer discrepancies.
        </p>
      </div>
    </div>
  </div>

  <!-- Interactive Live Pathology Calculator / Client Demo Playground -->
  <div class="playground-card">
    <div class="playground-header">
      <div>
        <h5 class="fw-bold text-dark mb-0">
          <i class="fas fa-flask-vial text-primary me-2"></i> Interactive Clinical Simulator &amp; Calculator
        </h5>
        <small class="text-muted">Test how formulas calculate live in real time as values are typed or adjusted.</small>
      </div>
      <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2">
        <i class="fas fa-bolt me-1"></i> Live Interactive Demo
      </span>
    </div>

    <div class="playground-body">
      <!-- Tabs for Different Panels -->
      <ul class="nav nav-pills mb-4 gap-2" id="simTabs" role="tablist">
        <li class="nav-item">
          <button class="nav-link active fw-semibold" data-bs-toggle="pill" data-bs-target="#tab-lft" type="button">
            <i class="fas fa-heartbeat me-1"></i> Liver (LFT)
          </button>
        </li>
        <li class="nav-item">
          <button class="nav-link fw-semibold" data-bs-toggle="pill" data-bs-target="#tab-lipid" type="button">
            <i class="fas fa-tint me-1"></i> Lipid Profile
          </button>
        </li>
        <li class="nav-item">
          <button class="nav-link fw-semibold" data-bs-toggle="pill" data-bs-target="#tab-cbc" type="button">
            <i class="fas fa-vial me-1"></i> CBC / Indices
          </button>
        </li>
        <li class="nav-item">
          <button class="nav-link fw-semibold" data-bs-toggle="pill" data-bs-target="#tab-kft" type="button">
            <i class="fas fa-stethoscope me-1"></i> Kidney (BUN)
          </button>
        </li>
        <li class="nav-item">
          <button class="nav-link fw-semibold" data-bs-toggle="pill" data-bs-target="#tab-diabetes" type="button">
            <i class="fas fa-chart-line me-1"></i> HbA1c &rarr; eAG
          </button>
        </li>
        <li class="nav-item">
          <button class="nav-link fw-semibold" data-bs-toggle="pill" data-bs-target="#tab-coag" type="button">
            <i class="fas fa-stopwatch me-1"></i> PT / INR
          </button>
        </li>
      </ul>

      <div class="tab-content" id="simTabsContent">

        <!-- 1. Liver Function (LFT) Simulator -->
        <div class="tab-pane fade show active" id="tab-lft">
          <div class="row g-4">
            <div class="col-lg-6">
              <h6 class="fw-bold text-dark mb-3"><i class="bi bi-pencil-square text-primary me-1"></i> Raw Measured Findings:</h6>
              <div class="calc-input-box">
                <div class="row g-3">
                  <div class="col-6">
                    <label class="form-label small fw-bold text-muted">Total Bilirubin (mg/dL)</label>
                    <input type="number" step="0.1" id="sim_tb" class="form-control fw-bold" value="2.4" oninput="runLftSim()">
                  </div>
                  <div class="col-6">
                    <label class="form-label small fw-bold text-muted">Direct Bilirubin (mg/dL)</label>
                    <input type="number" step="0.1" id="sim_db" class="form-control fw-bold" value="0.8" oninput="runLftSim()">
                  </div>
                  <div class="col-6">
                    <label class="form-label small fw-bold text-muted">Total Protein (g/dL)</label>
                    <input type="number" step="0.1" id="sim_tp" class="form-control fw-bold" value="7.2" oninput="runLftSim()">
                  </div>
                  <div class="col-6">
                    <label class="form-label small fw-bold text-muted">Serum Albumin (g/dL)</label>
                    <input type="number" step="0.1" id="sim_alb" class="form-control fw-bold" value="4.2" oninput="runLftSim()">
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-6">
              <h6 class="fw-bold text-dark mb-3"><i class="fas fa-calculator text-success me-1"></i> Instant Automated Derivations:</h6>
              <div class="row g-3">
                <div class="col-sm-6">
                  <div class="calc-result-box">
                    <small class="text-muted fw-bold">Indirect Bilirubin</small>
                    <div class="calc-result-val" id="out_ib">1.60</div>
                    <small class="text-secondary">mg/dL &bull; Total Bilirubin &minus; Direct Bilirubin</small>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="calc-result-box">
                    <small class="text-muted fw-bold">Serum Globulin</small>
                    <div class="calc-result-val" id="out_glob">3.00</div>
                    <small class="text-secondary">g/dL &bull; Total Protein &minus; Albumin</small>
                  </div>
                </div>
                <div class="col-12">
                  <div class="calc-result-box">
                    <small class="text-muted fw-bold">A/G Ratio (Albumin / Globulin)</small>
                    <div class="calc-result-val" id="out_ag">1.40</div>
                    <small class="text-secondary">Normal: 1.2 &ndash; 2.2 &bull; Formula: Albumin &divide; Globulin</small>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- 2. Lipid Profile Simulator -->
        <div class="tab-pane fade" id="tab-lipid">
          <div class="row g-4">
            <div class="col-lg-5">
              <h6 class="fw-bold text-dark mb-3"><i class="bi bi-pencil-square text-primary me-1"></i> Raw Measured Findings:</h6>
              <div class="calc-input-box">
                <div class="mb-2">
                  <label class="form-label small fw-bold text-muted">Total Cholesterol (mg/dL)</label>
                  <input type="number" id="sim_tc" class="form-control fw-bold" value="220" oninput="runLipidSim()">
                </div>
                <div class="mb-2">
                  <label class="form-label small fw-bold text-muted">Serum Triglycerides (mg/dL)</label>
                  <input type="number" id="sim_tg" class="form-control fw-bold" value="150" oninput="runLipidSim()">
                </div>
                <div>
                  <label class="form-label small fw-bold text-muted">HDL Cholesterol (mg/dL)</label>
                  <input type="number" id="sim_hdl" class="form-control fw-bold" value="45" oninput="runLipidSim()">
                </div>
              </div>
            </div>

            <div class="col-lg-7">
              <h6 class="fw-bold text-dark mb-3"><i class="fas fa-calculator text-success me-1"></i> Friedewald Equation Derivations:</h6>
              <div class="row g-3">
                <div class="col-6">
                  <div class="calc-result-box">
                    <small class="text-muted fw-bold">VLDL Cholesterol</small>
                    <div class="calc-result-val" id="out_vldl">30.00</div>
                    <small class="text-secondary">mg/dL &bull; Triglycerides &divide; 5</small>
                  </div>
                </div>
                <div class="col-6">
                  <div class="calc-result-box">
                    <small class="text-muted fw-bold">LDL Cholesterol</small>
                    <div class="calc-result-val" id="out_ldl">145.00</div>
                    <small class="text-secondary">mg/dL &bull; Chol &minus; HDL &minus; VLDL</small>
                  </div>
                </div>
                <div class="col-6">
                  <div class="calc-result-box">
                    <small class="text-muted fw-bold">Total / HDL Ratio</small>
                    <div class="calc-result-val" id="out_chdl">4.89</div>
                    <small class="text-secondary">Ratio &bull; Chol &divide; HDL</small>
                  </div>
                </div>
                <div class="col-6">
                  <div class="calc-result-box">
                    <small class="text-muted fw-bold">LDL / HDL Ratio</small>
                    <div class="calc-result-val" id="out_lhdl">3.22</div>
                    <small class="text-secondary">Ratio &bull; LDL &divide; HDL</small>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- 3. CBC / Hemogram Simulator -->
        <div class="tab-pane fade" id="tab-cbc">
          <div class="row g-4">
            <div class="col-lg-5">
              <h6 class="fw-bold text-dark mb-3"><i class="bi bi-pencil-square text-primary me-1"></i> Primary Hemogram Values:</h6>
              <div class="calc-input-box">
                <div class="mb-2">
                  <label class="form-label small fw-bold text-muted">Hemoglobin Hb (g/dL)</label>
                  <input type="number" step="0.1" id="sim_hb" class="form-control fw-bold" value="14.2" oninput="runCbcSim()">
                </div>
                <div class="mb-2">
                  <label class="form-label small fw-bold text-muted">Total RBC Count (mill/cumm)</label>
                  <input type="number" step="0.01" id="sim_rbc" class="form-control fw-bold" value="4.80" oninput="runCbcSim()">
                </div>
                <div>
                  <label class="form-label small fw-bold text-muted">Packed Cell Volume PCV (%)</label>
                  <input type="number" step="0.1" id="sim_pcv" class="form-control fw-bold" value="42.6" oninput="runCbcSim()">
                </div>
              </div>
            </div>

            <div class="col-lg-7">
              <h6 class="fw-bold text-dark mb-3"><i class="fas fa-calculator text-success me-1"></i> Wintrobe Red Cell Indices:</h6>
              <div class="row g-3">
                <div class="col-sm-6">
                  <div class="calc-result-box">
                    <small class="text-muted fw-bold">Mean Corpuscular Hb (MCH)</small>
                    <div class="calc-result-val" id="out_mch">29.6</div>
                    <small class="text-secondary">pg &bull; (Hb &times; 10) &divide; RBC</small>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="calc-result-box">
                    <small class="text-muted fw-bold">Mean Corpuscular Hb Conc (MCHC)</small>
                    <div class="calc-result-val" id="out_mchc">33.3</div>
                    <small class="text-secondary">g/dL &bull; (Hb &times; 100) &divide; PCV</small>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- 4. Kidney Function (BUN) Simulator -->
        <div class="tab-pane fade" id="tab-kft">
          <div class="row g-4">
            <div class="col-lg-5">
              <h6 class="fw-bold text-dark mb-3"><i class="bi bi-pencil-square text-primary me-1"></i> Renal Parameters:</h6>
              <div class="calc-input-box">
                <div class="mb-3">
                  <label class="form-label small fw-bold text-muted">Blood Urea (mg/dL)</label>
                  <input type="number" step="0.1" id="sim_urea" class="form-control fw-bold" value="32.0" oninput="runKftSim()">
                </div>
                <div>
                  <label class="form-label small fw-bold text-muted">Serum Creatinine (mg/dL)</label>
                  <input type="number" step="0.1" id="sim_creat" class="form-control fw-bold" value="1.0" oninput="runKftSim()">
                </div>
              </div>
            </div>

            <div class="col-lg-7">
              <h6 class="fw-bold text-dark mb-3"><i class="fas fa-calculator text-success me-1"></i> Derived Nitrogen Indices:</h6>
              <div class="row g-3">
                <div class="col-sm-6">
                  <div class="calc-result-box">
                    <small class="text-muted fw-bold">Blood Urea Nitrogen (BUN)</small>
                    <div class="calc-result-val" id="out_bun">14.95</div>
                    <small class="text-secondary">mg/dL &bull; Blood Urea &divide; 2.14</small>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="calc-result-box">
                    <small class="text-muted fw-bold">BUN / Creatinine Ratio</small>
                    <div class="calc-result-val" id="out_buncr">14.95</div>
                    <small class="text-secondary">Ratio &bull; Normal: 10 &ndash; 20</small>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- 5. Diabetes & eAG Simulator -->
        <div class="tab-pane fade" id="tab-diabetes">
          <div class="row g-4">
            <div class="col-lg-5">
              <h6 class="fw-bold text-dark mb-3"><i class="bi bi-pencil-square text-primary me-1"></i> Glycated Hemoglobin:</h6>
              <div class="calc-input-box">
                <label class="form-label small fw-bold text-muted">HbA1c (%)</label>
                <input type="number" step="0.1" id="sim_hba1c" class="form-control fw-bold fs-4" value="7.5" oninput="runDiabetesSim()">
                <small class="text-muted mt-2 d-block">NGSP / IFCC Certified Assay percentage.</small>
              </div>
            </div>

            <div class="col-lg-7">
              <h6 class="fw-bold text-dark mb-3"><i class="fas fa-calculator text-success me-1"></i> ADA / ADAG Linear Derivation:</h6>
              <div class="calc-result-box">
                <small class="text-muted fw-bold">Estimated Average Glucose (eAG)</small>
                <div class="calc-result-val" id="out_eag">168.6</div>
                <small class="text-secondary">mg/dL &bull; Standard Formula: (28.7 &times; HbA1c) &minus; 46.7 &bull; Corresponds to 90-120 days average glucose.</small>
              </div>
            </div>
          </div>
        </div>

        <!-- 6. PT / INR Simulator -->
        <div class="tab-pane fade" id="tab-coag">
          <div class="row g-4">
            <div class="col-lg-5">
              <h6 class="fw-bold text-dark mb-3"><i class="bi bi-pencil-square text-primary me-1"></i> Coagulation Time:</h6>
              <div class="calc-input-box">
                <div class="mb-2">
                  <label class="form-label small fw-bold text-muted">Patient Prothrombin Time PT (sec)</label>
                  <input type="number" step="0.1" id="sim_pt" class="form-control fw-bold" value="18.0" oninput="runCoagSim()">
                </div>
                <div class="mb-2">
                  <label class="form-label small fw-bold text-muted">Control PT (sec)</label>
                  <input type="number" step="0.1" id="sim_ptc" class="form-control fw-bold" value="12.0" oninput="runCoagSim()">
                </div>
                <div>
                  <label class="form-label small fw-bold text-muted">Reagent ISI (Sensitivity Index)</label>
                  <input type="number" step="0.05" id="sim_isi" class="form-control fw-bold" value="1.05" oninput="runCoagSim()">
                </div>
              </div>
            </div>

            <div class="col-lg-7">
              <h6 class="fw-bold text-dark mb-3"><i class="fas fa-calculator text-success me-1"></i> WHO Standardized Ratio:</h6>
              <div class="calc-result-box">
                <small class="text-muted fw-bold">International Normalized Ratio (INR)</small>
                <div class="calc-result-val" id="out_inr">1.53</div>
                <small class="text-secondary">Ratio &bull; Formula: (Patient PT &divide; Control PT)<sup>ISI</sup> &bull; Essential for Warfarin / oral anticoagulant monitoring.</small>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  <!-- Standard Clinical Formulas Directory -->
  <h4 class="fw-bold text-dark mb-3">
    <i class="fas fa-book-medical text-primary me-2"></i> Clinical Formulas Directory &amp; Reference Standards
  </h4>

  <div class="row g-3">
    <!-- LFT Indirect Bilirubin -->
    <div class="col-md-6">
      <div class="formula-ref-card">
        <div class="d-flex justify-content-between align-items-start mb-2">
          <h5 class="fw-bold text-dark mb-0">Indirect (Unconjugated) Bilirubin</h5>
          <span class="badge bg-primary-subtle text-primary border border-primary-subtle">LFT Panel</span>
        </div>
        <div class="formula-badge-math">Indirect Bilirubin = Total Bilirubin &minus; Direct Bilirubin</div>
        <p class="text-muted small mb-2">
          <strong>Clinical Significance:</strong> Key indicator in distinguishing pre-hepatic (hemolytic anemia, Gilbert syndrome, neonatal jaundice) from post-hepatic (obstructive biliary) jaundice.
        </p>
        <div class="d-flex justify-content-between align-items-center small text-secondary pt-2 border-top">
          <span><strong>Normal Range:</strong> 0.2 &ndash; 0.8 mg/dL</span>
          <span><strong>Standard:</strong> Jendrassik-Grof</span>
        </div>
      </div>
    </div>

    <!-- LFT Globulin & A/G -->
    <div class="col-md-6">
      <div class="formula-ref-card">
        <div class="d-flex justify-content-between align-items-start mb-2">
          <h5 class="fw-bold text-dark mb-0">Serum Globulin &amp; A/G Ratio</h5>
          <span class="badge bg-primary-subtle text-primary border border-primary-subtle">Protein Panel</span>
        </div>
        <div class="formula-badge-math">Globulin = Total Protein &minus; Albumin</div>
        <div class="formula-badge-math ms-2">A/G Ratio = Albumin &divide; Globulin</div>
        <p class="text-muted small mb-2">
          <strong>Clinical Significance:</strong> A reversed A/G ratio (&lt; 1.0) is a critical diagnostic red flag for chronic liver cirrhosis, multiple myeloma, chronic infections, or autoimmune collagen disease.
        </p>
        <div class="d-flex justify-content-between align-items-center small text-secondary pt-2 border-top">
          <span><strong>Normal A/G:</strong> 1.2 &ndash; 2.2</span>
          <span><strong>Standard:</strong> Biuret &amp; BCG Method</span>
        </div>
      </div>
    </div>

    <!-- Lipid Friedewald VLDL & LDL -->
    <div class="col-md-6">
      <div class="formula-ref-card">
        <div class="d-flex justify-content-between align-items-start mb-2">
          <h5 class="fw-bold text-dark mb-0">VLDL &amp; LDL Cholesterol</h5>
          <span class="badge bg-success-subtle text-success border border-success-subtle">Lipid Panel</span>
        </div>
        <div class="formula-badge-math">VLDL = Triglycerides &divide; 5</div>
        <div class="formula-badge-math ms-2">LDL = Total Chol &minus; HDL &minus; VLDL</div>
        <p class="text-muted small mb-2">
          <strong>Clinical Significance:</strong> Primary atherogenic cardiovascular risk estimation. <em>Medical Caveat:</em> Under NABL standards, Friedewald formula is valid only when Triglycerides &lt; 400 mg/dL.
        </p>
        <div class="d-flex justify-content-between align-items-center small text-secondary pt-2 border-top">
          <span><strong>Normal LDL:</strong> &lt; 100 mg/dL</span>
          <span><strong>Reference:</strong> Friedewald WT (1972)</span>
        </div>
      </div>
    </div>

    <!-- Blood Urea Nitrogen (BUN) -->
    <div class="col-md-6">
      <div class="formula-ref-card">
        <div class="d-flex justify-content-between align-items-start mb-2">
          <h5 class="fw-bold text-dark mb-0">Blood Urea Nitrogen (BUN)</h5>
          <span class="badge bg-info-subtle text-info border border-info-subtle">Renal Panel</span>
        </div>
        <div class="formula-badge-math">BUN = Blood Urea &divide; 2.14</div>
        <p class="text-muted small mb-2">
          <strong>Clinical Significance:</strong> The molecular weight of urea is 60, of which 28 is contributed by nitrogen (ratio 60/28 = 2.14). Critical for classifying pre-renal vs intrinsic renal failure.
        </p>
        <div class="d-flex justify-content-between align-items-center small text-secondary pt-2 border-top">
          <span><strong>Normal BUN:</strong> 7 &ndash; 20 mg/dL</span>
          <span><strong>Standard:</strong> Urease / GLDH</span>
        </div>
      </div>
    </div>

    <!-- Estimated Average Glucose (eAG) -->
    <div class="col-md-6">
      <div class="formula-ref-card">
        <div class="d-flex justify-content-between align-items-start mb-2">
          <h5 class="fw-bold text-dark mb-0">Estimated Average Glucose (eAG)</h5>
          <span class="badge bg-warning-subtle text-warning border border-warning-subtle">Diabetes</span>
        </div>
        <div class="formula-badge-math">eAG = (28.7 &times; HbA1c) &minus; 46.7</div>
        <p class="text-muted small mb-2">
          <strong>Clinical Significance:</strong> Translates abstract percentage HbA1c into daily blood glucose numbers (mg/dL) that diabetic patients easily understand from their home glucometers.
        </p>
        <div class="d-flex justify-content-between align-items-center small text-secondary pt-2 border-top">
          <span><strong>Target eAG:</strong> &lt; 140 mg/dL</span>
          <span><strong>Citation:</strong> ADA / ADAG Trial</span>
        </div>
      </div>
    </div>

    <!-- Wintrobe Red Cell Indices MCH & MCHC -->
    <div class="col-md-6">
      <div class="formula-ref-card">
        <div class="d-flex justify-content-between align-items-start mb-2">
          <h5 class="fw-bold text-dark mb-0">Red Cell Indices (MCH &amp; MCHC)</h5>
          <span class="badge bg-danger-subtle text-danger border border-danger-subtle">Hematology</span>
        </div>
        <div class="formula-badge-math">MCH = (Hb &times; 10) &divide; RBC</div>
        <div class="formula-badge-math ms-2">MCHC = (Hb &times; 100) &divide; PCV</div>
        <p class="text-muted small mb-2">
          <strong>Clinical Significance:</strong> Essential morphological classification of anemias into microcytic hypochromic (iron deficiency, thalassemia) or macrocytic (B12/folate deficiency).
        </p>
        <div class="d-flex justify-content-between align-items-center small text-secondary pt-2 border-top">
          <span><strong>Normal MCH:</strong> 27 &ndash; 32 pg</span>
          <span><strong>Normal MCHC:</strong> 32 &ndash; 36 g/dL</span>
        </div>
      </div>
    </div>
  </div>

</div>

<!-- Interactive Simulator Scripts -->
<script>
function runLftSim() {
  const tb = parseFloat(document.getElementById('sim_tb').value) || 0;
  const db = parseFloat(document.getElementById('sim_db').value) || 0;
  const tp = parseFloat(document.getElementById('sim_tp').value) || 0;
  const alb = parseFloat(document.getElementById('sim_alb').value) || 0;

  const ib = Math.max(0, tb - db);
  const glob = Math.max(0, tp - alb);
  const ag = glob > 0 ? (alb / glob) : 0;

  document.getElementById('out_ib').innerText = ib.toFixed(2);
  document.getElementById('out_glob').innerText = glob.toFixed(2);
  document.getElementById('out_ag').innerText = ag.toFixed(2);
}

function runLipidSim() {
  const tc = parseFloat(document.getElementById('sim_tc').value) || 0;
  const tg = parseFloat(document.getElementById('sim_tg').value) || 0;
  const hdl = parseFloat(document.getElementById('sim_hdl').value) || 0;

  const vldl = tg / 5;
  const ldl = Math.max(0, tc - hdl - vldl);
  const chdl = hdl > 0 ? (tc / hdl) : 0;
  const lhdl = hdl > 0 ? (ldl / hdl) : 0;

  document.getElementById('out_vldl').innerText = vldl.toFixed(2);
  document.getElementById('out_ldl').innerText = ldl.toFixed(2);
  document.getElementById('out_chdl').innerText = chdl.toFixed(2);
  document.getElementById('out_lhdl').innerText = lhdl.toFixed(2);
}

function runCbcSim() {
  const hb = parseFloat(document.getElementById('sim_hb').value) || 0;
  const rbc = parseFloat(document.getElementById('sim_rbc').value) || 0;
  const pcv = parseFloat(document.getElementById('sim_pcv').value) || 0;

  const mch = rbc > 0 ? ((hb * 10) / rbc) : 0;
  const mchc = pcv > 0 ? ((hb * 100) / pcv) : 0;

  document.getElementById('out_mch').innerText = mch.toFixed(1);
  document.getElementById('out_mchc').innerText = mchc.toFixed(1);
}

function runKftSim() {
  const urea = parseFloat(document.getElementById('sim_urea').value) || 0;
  const creat = parseFloat(document.getElementById('sim_creat').value) || 0;

  const bun = urea / 2.14;
  const buncr = creat > 0 ? (bun / creat) : 0;

  document.getElementById('out_bun').innerText = bun.toFixed(2);
  document.getElementById('out_buncr').innerText = buncr.toFixed(2);
}

function runDiabetesSim() {
  const a1c = parseFloat(document.getElementById('sim_hba1c').value) || 0;
  const eag = Math.max(0, (28.7 * a1c) - 46.7);
  document.getElementById('out_eag').innerText = eag.toFixed(1);
}

function runCoagSim() {
  const pt = parseFloat(document.getElementById('sim_pt').value) || 0;
  const ptc = parseFloat(document.getElementById('sim_ptc').value) || 0;
  const isi = parseFloat(document.getElementById('sim_isi').value) || 1.0;

  const inr = ptc > 0 ? Math.pow((pt / ptc), isi) : 0;
  document.getElementById('out_inr').innerText = inr.toFixed(2);
}

document.addEventListener('DOMContentLoaded', () => {
  runLftSim();
  runLipidSim();
  runCbcSim();
  runKftSim();
  runDiabetesSim();
  runCoagSim();
});
</script>

</body>
</html>
