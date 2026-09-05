
# Lab Report PDF Generator System

This system allows dynamic generation of lab test reports based on test templates, parameters, reference ranges, and doctor credentials. Key features include:

## ✅ Features Overview

| Feature | Description |
|--------|-------------|
| ✅ Group-wise Parameter Display | Test parameters are grouped under their respective group headers for clarity. |
| ✅ Method Under Parameter Name | Each parameter can optionally display its test method in smaller font directly beneath the parameter name. |
| ✅ Reference Range by Gender | Reference ranges are dynamically adjusted and displayed based on patient gender (Male, Female, Child). |
| ✅ Highlight Abnormal/Positive/Reactive | Abnormal values (numeric: below min or above max, or non-numeric: POSITIVE/REACTIVE) are automatically highlighted in **bold red**. |
| ✅ Manual Highlight for Non-numeric | Non-numeric results can be manually flagged as abnormal and highlighted using an override/toggle system. |
| ✅ Doctor Signature + Stamp | Doctors can upload their digital signature and stamp, which are automatically embedded in the PDF reports. |
| ✅ Template-Based Report PDF | Uses customizable HTML templates with placeholders to support different test layouts for each report type. |

## 🛠️ Components Included

- `template.html`: HTML report template with placeholders.
- `generate_report.php`: Script to generate PDF from filled template using DomPDF.
- `admin_upload.html`: UI for uploading doctor details with signature and stamp.
- `upload.php`: Backend processor to handle file upload and save details to database.
- `lab_structure.sql`: SQL script to create all required tables including:
  - `test_parameters`
  - `parameter_reference_range`
  - `parameter_groups`
  - `doctors`

## 📂 Folder Structure

```
lab_report_system_full/
├── template.html
├── generate_report.php
├── admin_upload.html
├── upload.php
├── lab_structure.sql
└── uploads/
    ├── signature.png
    └── stamp.png
```

---

For integration into your existing lab system or extending templates to match real patient and test data, contact support.
