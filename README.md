# VenSaas LabTech - Diagnostic Pathology Laboratory ERP & LIMS Software

A comprehensive, production-ready SaaS & On-Premise Diagnostic Laboratory Information Management System (LIMS) designed for clinical pathology labs, diagnostic centres, hospitals, and clinics.

---

## 🌟 Key Features

### 1. Phlebotomy & Specimen Collection Workstation
- **Barcode Tube Sticker Generation**: Instant print for vacutainer tubes with pre-printed barcode stickers and dynamic SVG/JS barcodes.
- **Tube Recommendation Engine**: Automatic guidance for correct vacutainers (EDTA, Serum Gel, Fluoride, Sodium Citrate) based on ordered tests.
- **1-Click Phlebotomy Workflow**: Fast collection logging with timestamps and phlebotomist identification.

### 2. Clinical Investigation & Fast Billing Studio
- **Touch-Friendly & Mobile-First**: Native app-like experience with persistent bottom navigation and sticky payment checkout bar.
- **Instant Investigation Search**: Real-time autocomplete for individual tests and health checkup packages.
- **Returning Patient Recognition**: Rapid lookup by mobile number or name with auto-fill.
- **Financial Flexibility**: Real-time balance calculations with quick payment shortcuts (*Full Paid*, *50%*, *Zero*).

### 3. Medical Report Studio & Dynamic PDF Generator
- **Multi-Department Reporting**: Hematology, Biochemistry, Clinical Pathology, Serology, Microbiology, and Histopathology.
- **Age- & Gender-Specific Reference Ranges**: Automated validation for Male, Female, and Pediatric ranges with real-time abnormal value highlighting.
- **Digital Signatures & Verification QR Code**: Doctor digital signature stamps with tamper-proof QR code report verification.
- **1-Click Dispatch**: Direct WhatsApp PDF report sharing and thermal receipt printing.

### 4. Interactive Master Data & Dynamic Rate Cards
- **Bulk Updatable Rate Cards**: Update test prices directly in table view with instant background autosave.
- **Health Packages Master**: Group multiple tests into affordable checkup packages.
- **Indian Pathology Master Catalog**: Pre-configured NABL standard test parameters and reference ranges.

### 5. Mobile Progressive Web App (PWA)
- **Installable on Any Device**: Android, iOS, Windows, and Mac.
- **Offline Resilience**: Service worker caching for fast loading even in low-connectivity lab environments.

---

## 🏗️ Architecture & Directory Structure

```text
LABTECH/
├── admin/                 # Super-admin portal for lab provisioning & licensing
├── assets/                # PWA app icons (192x192, 512x512, apple-touch-icon)
├── base/                  # Production template used when provisioning new labs
│   ├── assets/            # PWA icons for base lab instance
│   ├── TCPDF/             # High-precision PDF rendering engine
│   ├── sign_stamp/        # Doctor digital signatures and lab stamps
│   ├── header.php         # Modern responsive navbar & bottom app bar
│   ├── bill_add.php       # Fast billing & patient registration studio
│   ├── bill_edit.php      # Invoice editor with test selection
│   ├── bill_list.php      # Invoices register with mobile card view
│   ├── sample_collection.php # Phlebotomy station & barcode tube printer
│   ├── result_entry.php   # Test parameters result entry & range validation
│   └── rate_card.php      # Live inline rate editing studio
├── demo/                  # Interactive live demo instance
├── dump/                  # Database SQL schemas and migrations
├── brochure.php           # Digital marketing brochure & printable A4 flyer
├── index.php              # SaaS landing page with pricing plans
├── manifest.json          # Web App Manifest for mobile installation
├── register.php           # Lab self-service registration & 14-day trial
├── register_action.php    # Automated lab database provisioning handler
└── sw.js                  # Service worker for PWA functionality
```

---

## 🚀 Installation & Deployment

### Server Requirements
- **PHP**: 8.0, 8.1, or 8.2
- **MySQL / MariaDB**: 5.7+ / 10.3+
- **Extensions**: `mysqli`, `gd` or `imagick`, `mbstring`, `curl`, `json`
- **Web Server**: Apache (`mod_rewrite` enabled) or Nginx

### Quick Setup
1. **Clone repository**:
   ```bash
   git clone https://github.com/arcgwk-cyber/labtech.git
   cd labtech
   ```
2. **Database Setup**:
   - Import `dump/diagnostic_lab_db.sql` into your MySQL server.
   - Update database credentials in:
     - `base/db.php`
     - `demo/db.php`
     - `admin/db.php`
3. **File Permissions**:
   ```bash
   chmod 755 base/ demo/ admin/ assets/
   chmod 777 base/qrtemp/ demo/qrtemp/ base/sign_stamp/ demo/sign_stamp/
   ```
4. **Access the Portal**:
   - Landing Page: `https://your-domain.com/`
   - Live Demo: `https://your-domain.com/demo/` (Login: `admin` / `admin123`)
   - Admin Portal: `https://your-domain.com/admin/`

---

## 📄 License & Commercial Distribution
Developed by **VenSaas Technologies**.  
All rights reserved.
