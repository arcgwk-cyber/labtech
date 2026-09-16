<?php
/**
 * Standard NABL / ICMR Compliant Indian Pathology Master Catalog Data
 * 92 Clinical Tests | 144 Clinical Parameters | 15 Health Packages
 */

$MASTER_CATALOG_TESTS = [
  [
    "test_id" => 1,
    "name" => "Complete Blood Count (CBC with ESR)",
    "code" => "CBC-ESR",
    "category_id" => 2,
    "category_name" => "Hematology",
    "price" => 350.0,
    "notes" => "Includes automated 5-part differential, RBC indices, Platelet count and ESR",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Clinical Significance:</b> The Complete Hemogram / CBC provides quantitative and qualitative evaluation of the formed elements of blood (erythrocytes, leukocytes, and thrombocytes).</p>
<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\" style=\"border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;\">
  <tr style=\"background-color:#f1f5f9; font-weight:bold;\">
    <th style=\"width:25%; padding:2px 4px;\">Parameter Flag</th>
    <th style=\"width:35%; padding:2px 4px;\">Potential Pathological Causes</th>
    <th style=\"width:40%; padding:2px 4px;\">Recommended Correlative Workup</th>
  </tr>
  <tr>
    <td style=\"padding:2px 4px;\"><b>Anemia (Low Hb/RBC)</b></td>
    <td style=\"padding:2px 4px;\">Iron deficiency, Thalassemia trait, Vit B12/Folate deficiency, Acute blood loss, Chronic disease</td>
    <td style=\"padding:2px 4px;\">Serum Ferritin, Iron Profile, Vit B12, Peripheral Smear (PBS), Reticulocyte count</td>
  </tr>
  <tr>
    <td style=\"padding:2px 4px;\"><b>Leukocytosis (High TLC)</b></td>
    <td style=\"padding:2px 4px;\">Acute bacterial infection, tissue necrosis, severe inflammation, leukemoid reaction, hematological malignancy</td>
    <td style=\"padding:2px 4px;\">Differential count, CRP, Blood culture, Peripheral blood smear review</td>
  </tr>
  <tr>
    <td style=\"padding:2px 4px;\"><b>Leukopenia (Low TLC)</b></td>
    <td style=\"padding:2px 4px;\">Viral infections (Dengue, Typhoid, Viral hepatitis), autoimmune conditions, drug-induced marrow suppression</td>
    <td style=\"padding:2px 4px;\">Serology (Dengue NS1/IgM, Widal, Typhidot), repeat counts in 48 hours</td>
  </tr>
  <tr>
    <td style=\"padding:2px 4px;\"><b>Thrombocytopenia</b></td>
    <td style=\"padding:2px 4px;\">Dengue, ITP, sepsis, malaria, drug-induced, hypersplenism, marrow suppression</td>
    <td style=\"padding:2px 4px;\">Manual platelet smear estimate, Dengue/Malaria screen, daily monitoring if &lt; 50,000</td>
  </tr>
</table>
<p style=\"font-size:7pt; color:#64748b; margin:2px 0 0 0;\"><i>Note: Microscopic peripheral blood smear examination is recommended when automated flags or marked cytopenias are observed.</i></p>
<p style=\"margin:3px 0 0 0;\"><b>ESR Significance:</b> Westergren 1st-hour ESR is an indirect acute-phase marker of systemic inflammation. Marked elevation (&gt; 100 mm/hr) strongly suggests bacterial infection (e.g., TB, osteomyelitis), autoimmune disease (e.g., SLE, RA), or multiple myeloma.</p>",
    "param_count" => 15,
    "parameters" => [
      [
        "name" => "Hemoglobin (Hb)",
        "unit" => "g/dL",
        "method" => "SLS-Hemoglobin / Automated",
        "sample" => "Whole Blood EDTA",
        "male_min" => 13.0,
        "male_max" => 17.0,
        "female_min" => 12.0,
        "female_max" => 15.5,
        "text" => "Male: 13.0-17.0, Female: 12.0-15.5, Child: 11.0-14.5 g/dL"
      ],
      [
        "name" => "Total RBC Count",
        "unit" => "mill/cumm",
        "method" => "Automated Cell Counter",
        "sample" => "Whole Blood EDTA",
        "male_min" => 4.5,
        "male_max" => 5.9,
        "female_min" => 4.0,
        "female_max" => 5.2,
        "text" => "Male: 4.5-5.9, Female: 4.0-5.2 mill/cumm"
      ],
      [
        "name" => "Total WBC Count (TLC)",
        "unit" => "cells/cumm",
        "method" => "Automated Cell Counter",
        "sample" => "Whole Blood EDTA",
        "male_min" => 4000,
        "male_max" => 11000,
        "female_min" => 4000,
        "female_max" => 11000,
        "text" => "Adults: 4,000 - 11,000 /cumm; Children: 5,000 - 15,000 /cumm"
      ],
      [
        "name" => "Packed Cell Volume (PCV / Hematocrit)",
        "unit" => "%",
        "method" => "Calculated / Centrifugation",
        "sample" => "Whole Blood EDTA",
        "male_min" => 40.0,
        "male_max" => 50.0,
        "female_min" => 36.0,
        "female_max" => 46.0,
        "text" => "Male: 40-50%, Female: 36-46%"
      ],
      [
        "name" => "Mean Corpuscular Volume (MCV)",
        "unit" => "fL",
        "method" => "Calculated",
        "sample" => "Whole Blood EDTA",
        "male_min" => 80.0,
        "male_max" => 100.0,
        "female_min" => 80.0,
        "female_max" => 100.0,
        "text" => "Normal: 80.0 - 100.0 fL"
      ],
      [
        "name" => "Mean Corpuscular Hemoglobin (MCH)",
        "unit" => "pg",
        "method" => "Calculated",
        "sample" => "Whole Blood EDTA",
        "male_min" => 27.0,
        "male_max" => 32.0,
        "female_min" => 27.0,
        "female_max" => 32.0,
        "text" => "Normal: 27.0 - 32.0 pg"
      ],
      [
        "name" => "Mean Corpuscular Hb Conc (MCHC)",
        "unit" => "g/dL",
        "method" => "Calculated",
        "sample" => "Whole Blood EDTA",
        "male_min" => 32.0,
        "male_max" => 36.0,
        "female_min" => 32.0,
        "female_max" => 36.0,
        "text" => "Normal: 32.0 - 36.0 g/dL"
      ],
      [
        "name" => "Red Cell Distribution Width (RDW-CV)",
        "unit" => "%",
        "method" => "Calculated",
        "sample" => "Whole Blood EDTA",
        "male_min" => 11.5,
        "male_max" => 14.5,
        "female_min" => 11.5,
        "female_max" => 14.5,
        "text" => "Normal: 11.5 - 14.5 %"
      ],
      [
        "name" => "Platelet Count",
        "unit" => "lakh/cumm",
        "method" => "Automated Cell Counter",
        "sample" => "Whole Blood EDTA",
        "male_min" => 1.5,
        "male_max" => 4.5,
        "female_min" => 1.5,
        "female_max" => 4.5,
        "text" => "Normal: 1.50 - 4.50 lakh/cumm (150,000 - 450,000 /\u00b5L)"
      ],
      [
        "name" => "Neutrophils",
        "unit" => "%",
        "method" => "Microscopy / Automated",
        "sample" => "Whole Blood EDTA",
        "male_min" => 40,
        "male_max" => 75,
        "female_min" => 40,
        "female_max" => 75,
        "text" => "40 - 75 %"
      ],
      [
        "name" => "Lymphocytes",
        "unit" => "%",
        "method" => "Microscopy / Automated",
        "sample" => "Whole Blood EDTA",
        "male_min" => 20,
        "male_max" => 45,
        "female_min" => 20,
        "female_max" => 45,
        "text" => "20 - 45 %"
      ],
      [
        "name" => "Eosinophils",
        "unit" => "%",
        "method" => "Microscopy / Automated",
        "sample" => "Whole Blood EDTA",
        "male_min" => 1,
        "male_max" => 6,
        "female_min" => 1,
        "female_max" => 6,
        "text" => "1 - 6 %"
      ],
      [
        "name" => "Monocytes",
        "unit" => "%",
        "method" => "Microscopy / Automated",
        "sample" => "Whole Blood EDTA",
        "male_min" => 2,
        "male_max" => 8,
        "female_min" => 2,
        "female_max" => 8,
        "text" => "2 - 8 %"
      ],
      [
        "name" => "Basophils",
        "unit" => "%",
        "method" => "Microscopy / Automated",
        "sample" => "Whole Blood EDTA",
        "male_min" => 0,
        "male_max" => 1,
        "female_min" => 0,
        "female_max" => 1,
        "text" => "0 - 1 %"
      ],
      [
        "name" => "Erythrocyte Sedimentation Rate (ESR)",
        "unit" => "mm/1st hr",
        "method" => "Westergren Method",
        "sample" => "Citrated Blood",
        "male_min" => 0,
        "male_max" => 15,
        "female_min" => 0,
        "female_max" => 20,
        "text" => "Male: 0-15 mm, Female: 0-20 mm, Child: 0-10 mm / 1st hr"
      ]
    ]
  ],
  [
    "test_id" => 2,
    "name" => "Complete Hemogram / CBC",
    "code" => "CBC",
    "category_id" => 2,
    "category_name" => "Hematology",
    "price" => 300.0,
    "notes" => "Includes automated 5-part differential, RBC indices and Platelet count",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Clinical Significance:</b> The Complete Hemogram / CBC provides quantitative and qualitative evaluation of the formed elements of blood (erythrocytes, leukocytes, and thrombocytes).</p>
<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\" style=\"border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;\">
  <tr style=\"background-color:#f1f5f9; font-weight:bold;\">
    <th style=\"width:25%; padding:2px 4px;\">Parameter Flag</th>
    <th style=\"width:35%; padding:2px 4px;\">Potential Pathological Causes</th>
    <th style=\"width:40%; padding:2px 4px;\">Recommended Correlative Workup</th>
  </tr>
  <tr>
    <td style=\"padding:2px 4px;\"><b>Anemia (Low Hb/RBC)</b></td>
    <td style=\"padding:2px 4px;\">Iron deficiency, Thalassemia trait, Vit B12/Folate deficiency, Acute blood loss, Chronic disease</td>
    <td style=\"padding:2px 4px;\">Serum Ferritin, Iron Profile, Vit B12, Peripheral Smear (PBS), Reticulocyte count</td>
  </tr>
  <tr>
    <td style=\"padding:2px 4px;\"><b>Leukocytosis (High TLC)</b></td>
    <td style=\"padding:2px 4px;\">Acute bacterial infection, tissue necrosis, severe inflammation, leukemoid reaction, hematological malignancy</td>
    <td style=\"padding:2px 4px;\">Differential count, CRP, Blood culture, Peripheral blood smear review</td>
  </tr>
  <tr>
    <td style=\"padding:2px 4px;\"><b>Leukopenia (Low TLC)</b></td>
    <td style=\"padding:2px 4px;\">Viral infections (Dengue, Typhoid, Viral hepatitis), autoimmune conditions, drug-induced marrow suppression</td>
    <td style=\"padding:2px 4px;\">Serology (Dengue NS1/IgM, Widal, Typhidot), repeat counts in 48 hours</td>
  </tr>
  <tr>
    <td style=\"padding:2px 4px;\"><b>Thrombocytopenia</b></td>
    <td style=\"padding:2px 4px;\">Dengue, ITP, sepsis, malaria, drug-induced, hypersplenism, marrow suppression</td>
    <td style=\"padding:2px 4px;\">Manual platelet smear estimate, Dengue/Malaria screen, daily monitoring if &lt; 50,000</td>
  </tr>
</table>
<p style=\"font-size:7pt; color:#64748b; margin:2px 0 0 0;\"><i>Note: Microscopic peripheral blood smear examination is recommended when automated flags or marked cytopenias are observed.</i></p>",
    "param_count" => 14,
    "parameters" => [
      [
        "name" => "Hemoglobin (Hb)",
        "unit" => "g/dL",
        "method" => "SLS-Hemoglobin / Automated",
        "sample" => "Whole Blood EDTA",
        "male_min" => 13.0,
        "male_max" => 17.0,
        "female_min" => 12.0,
        "female_max" => 15.5,
        "text" => "Male: 13.0-17.0, Female: 12.0-15.5, Child: 11.0-14.5 g/dL"
      ],
      [
        "name" => "Total RBC Count",
        "unit" => "mill/cumm",
        "method" => "Automated Cell Counter",
        "sample" => "Whole Blood EDTA",
        "male_min" => 4.5,
        "male_max" => 5.9,
        "female_min" => 4.0,
        "female_max" => 5.2,
        "text" => "Male: 4.5-5.9, Female: 4.0-5.2 mill/cumm"
      ],
      [
        "name" => "Total WBC Count (TLC)",
        "unit" => "cells/cumm",
        "method" => "Automated Cell Counter",
        "sample" => "Whole Blood EDTA",
        "male_min" => 4000,
        "male_max" => 11000,
        "female_min" => 4000,
        "female_max" => 11000,
        "text" => "Adults: 4,000 - 11,000 /cumm; Children: 5,000 - 15,000 /cumm"
      ],
      [
        "name" => "Packed Cell Volume (PCV / Hematocrit)",
        "unit" => "%",
        "method" => "Calculated / Centrifugation",
        "sample" => "Whole Blood EDTA",
        "male_min" => 40.0,
        "male_max" => 50.0,
        "female_min" => 36.0,
        "female_max" => 46.0,
        "text" => "Male: 40-50%, Female: 36-46%"
      ],
      [
        "name" => "Mean Corpuscular Volume (MCV)",
        "unit" => "fL",
        "method" => "Calculated",
        "sample" => "Whole Blood EDTA",
        "male_min" => 80.0,
        "male_max" => 100.0,
        "female_min" => 80.0,
        "female_max" => 100.0,
        "text" => "Normal: 80.0 - 100.0 fL"
      ],
      [
        "name" => "Mean Corpuscular Hemoglobin (MCH)",
        "unit" => "pg",
        "method" => "Calculated",
        "sample" => "Whole Blood EDTA",
        "male_min" => 27.0,
        "male_max" => 32.0,
        "female_min" => 27.0,
        "female_max" => 32.0,
        "text" => "Normal: 27.0 - 32.0 pg"
      ],
      [
        "name" => "Mean Corpuscular Hb Conc (MCHC)",
        "unit" => "g/dL",
        "method" => "Calculated",
        "sample" => "Whole Blood EDTA",
        "male_min" => 32.0,
        "male_max" => 36.0,
        "female_min" => 32.0,
        "female_max" => 36.0,
        "text" => "Normal: 32.0 - 36.0 g/dL"
      ],
      [
        "name" => "Red Cell Distribution Width (RDW-CV)",
        "unit" => "%",
        "method" => "Calculated",
        "sample" => "Whole Blood EDTA",
        "male_min" => 11.5,
        "male_max" => 14.5,
        "female_min" => 11.5,
        "female_max" => 14.5,
        "text" => "Normal: 11.5 - 14.5 %"
      ],
      [
        "name" => "Platelet Count",
        "unit" => "lakh/cumm",
        "method" => "Automated Cell Counter",
        "sample" => "Whole Blood EDTA",
        "male_min" => 1.5,
        "male_max" => 4.5,
        "female_min" => 1.5,
        "female_max" => 4.5,
        "text" => "Normal: 1.50 - 4.50 lakh/cumm (150,000 - 450,000 /\u00b5L)"
      ],
      [
        "name" => "Neutrophils",
        "unit" => "%",
        "method" => "Microscopy / Automated",
        "sample" => "Whole Blood EDTA",
        "male_min" => 40,
        "male_max" => 75,
        "female_min" => 40,
        "female_max" => 75,
        "text" => "40 - 75 %"
      ],
      [
        "name" => "Lymphocytes",
        "unit" => "%",
        "method" => "Microscopy / Automated",
        "sample" => "Whole Blood EDTA",
        "male_min" => 20,
        "male_max" => 45,
        "female_min" => 20,
        "female_max" => 45,
        "text" => "20 - 45 %"
      ],
      [
        "name" => "Eosinophils",
        "unit" => "%",
        "method" => "Microscopy / Automated",
        "sample" => "Whole Blood EDTA",
        "male_min" => 1,
        "male_max" => 6,
        "female_min" => 1,
        "female_max" => 6,
        "text" => "1 - 6 %"
      ],
      [
        "name" => "Monocytes",
        "unit" => "%",
        "method" => "Microscopy / Automated",
        "sample" => "Whole Blood EDTA",
        "male_min" => 2,
        "male_max" => 8,
        "female_min" => 2,
        "female_max" => 8,
        "text" => "2 - 8 %"
      ],
      [
        "name" => "Basophils",
        "unit" => "%",
        "method" => "Microscopy / Automated",
        "sample" => "Whole Blood EDTA",
        "male_min" => 0,
        "male_max" => 1,
        "female_min" => 0,
        "female_max" => 1,
        "text" => "0 - 1 %"
      ]
    ]
  ],
  [
    "test_id" => 3,
    "name" => "Hemoglobin (Hb alone)",
    "code" => "HB",
    "category_id" => 2,
    "category_name" => "Hematology",
    "price" => 80.0,
    "notes" => "Cyanmethemoglobin / SLS automated method",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Clinical Significance:</b> Hemoglobin measurement is the primary clinical parameter for evaluating oxygen-carrying capacity and screening for anemia or polycythemia.</p>
<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\" style=\"border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;\">
  <tr style=\"background-color:#f1f5f9; font-weight:bold;\">
    <th style=\"width:30%; padding:2px 4px;\">Severity Category (WHO)</th>
    <th style=\"width:35%; padding:2px 4px;\">Adult Males (g/dL)</th>
    <th style=\"width:35%; padding:2px 4px;\">Adult Non-Pregnant Females (g/dL)</th>
  </tr>
  <tr><td style=\"padding:2px 4px;\"><b>Normal</b></td><td style=\"padding:2px 4px;\">13.0 – 17.0</td><td style=\"padding:2px 4px;\">12.0 – 15.0</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>Mild Anemia</b></td><td style=\"padding:2px 4px;\">11.0 – 12.9</td><td style=\"padding:2px 4px;\">11.0 – 11.9</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>Moderate Anemia</b></td><td style=\"padding:2px 4px;\">8.0 – 10.9</td><td style=\"padding:2px 4px;\">8.0 – 10.9</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>Severe Anemia</b></td><td style=\"padding:2px 4px;\">&lt; 8.0</td><td style=\"padding:2px 4px;\">&lt; 8.0</td></tr>
</table>
<p style=\"font-size:7pt; color:#64748b; margin:2px 0 0 0;\"><i>Physiological decrease occurs in pregnancy (hemodilution, cut-off: 11.0 g/dL). High levels may indicate polycythemia vera, chronic hypoxia (COPD, cyanotic heart disease), or hemoconcentration (dehydration).</i></p>",
    "param_count" => 1,
    "parameters" => [
      [
        "name" => "Hemoglobin (Hb)",
        "unit" => "g/dL",
        "method" => "SLS-Hemoglobin / Automated",
        "sample" => "Whole Blood EDTA",
        "male_min" => 13.0,
        "male_max" => 17.0,
        "female_min" => 12.0,
        "female_max" => 15.5,
        "text" => "Male: 13.0-17.0, Female: 12.0-15.5, Child: 11.0-14.5 g/dL"
      ]
    ]
  ],
  [
    "test_id" => 4,
    "name" => "Platelet Count alone",
    "code" => "PLT",
    "category_id" => 2,
    "category_name" => "Hematology",
    "price" => 100.0,
    "notes" => "Automated Cell Counter / Chamber confirmation",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Clinical Significance:</b> Platelets play a critical role in primary hemostasis and vascular endothelial integrity.</p>
<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\" style=\"border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;\">
  <tr style=\"background-color:#f1f5f9; font-weight:bold;\">
    <th style=\"width:30%; padding:2px 4px;\">Platelet Count Range</th>
    <th style=\"width:35%; padding:2px 4px;\">Clinical State</th>
    <th style=\"width:35%; padding:2px 4px;\">Risk Assessment</th>
  </tr>
  <tr><td style=\"padding:2px 4px;\"><b>&gt; 450,000 /µL</b></td><td style=\"padding:2px 4px;\">Thrombocytosis</td><td style=\"padding:2px 4px;\">Reactive (inflammation, iron deficiency) vs Myeloproliferative (ET)</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>150,000 – 450,000 /µL</b></td><td style=\"padding:2px 4px;\">Normal Range</td><td style=\"padding:2px 4px;\">Normal hemostatic capacity</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>50,000 – 100,000 /µL</b></td><td style=\"padding:2px 4px;\">Moderate Thrombocytopenia</td><td style=\"padding:2px 4px;\">Bleeding risk with major trauma or surgery; monitor closely</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>&lt; 20,000 /µL</b></td><td style=\"padding:2px 4px;\">Severe / Critical Thrombocytopenia</td><td style=\"padding:2px 4px;\">High risk of spontaneous mucosal, gastrointestinal, or intracranial bleeding</td></tr>
</table>
<p style=\"font-size:7pt; color:#64748b; margin:2px 0 0 0;\"><i>Note: In Dengue fever, counts &lt; 100,000 /µL require close monitoring for plasma leakage signs (hematocrit elevation, gall bladder wall edema).</i></p>",
    "param_count" => 1,
    "parameters" => [
      [
        "name" => "Platelet Count",
        "unit" => "lakh/cumm",
        "method" => "Automated Cell Counter",
        "sample" => "Whole Blood EDTA",
        "male_min" => 1.5,
        "male_max" => 4.5,
        "female_min" => 1.5,
        "female_max" => 4.5,
        "text" => "Normal: 1.50 - 4.50 lakh/cumm (150,000 - 450,000 /\u00b5L)"
      ]
    ]
  ],
  [
    "test_id" => 5,
    "name" => "Total Leucocyte Count (TLC / Total WBC)",
    "code" => "TLC",
    "category_id" => 2,
    "category_name" => "Hematology",
    "price" => 100.0,
    "notes" => "Automated cell counter count of total circulating white blood cells",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Clinical Significance:</b> Total Leucocyte Count (TLC) indicates systemic immune response and bone marrow output.</p>
<p style=\"margin:2px 0; font-size:7.5pt;\"><b>Leukocytosis (&gt; 11,000 /µL):</b> Commonly seen in acute bacterial infections, abscesses, appendicitis, diabetic ketoacidosis, tissue necrosis (AMI), burns, strenuous exercise, glucocorticoid therapy, or myeloproliferative disorders.<br>
<b>Leukopenia (&lt; 4,000 /µL):</b> Common in viral infections (Dengue, Influenza, HIV, Hepatitis), severe sepsis (toxic depression), enteric fever, autoimmune lupus, bone marrow hypoplasia, and cytotoxic chemotherapy.</p>",
    "param_count" => 1,
    "parameters" => [
      [
        "name" => "Total WBC Count (TLC)",
        "unit" => "cells/cumm",
        "method" => "Automated Cell Counter",
        "sample" => "Whole Blood EDTA",
        "male_min" => 4000,
        "male_max" => 11000,
        "female_min" => 4000,
        "female_max" => 11000,
        "text" => "Adults: 4,000 - 11,000 /cumm; Children: 5,000 - 15,000 /cumm"
      ]
    ]
  ],
  [
    "test_id" => 6,
    "name" => "Differential Leucocyte Count (DLC)",
    "code" => "DLC",
    "category_id" => 2,
    "category_name" => "Hematology",
    "price" => 100.0,
    "notes" => "Automated / Stained smear differential counting of 100 white blood cells",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Differential Count Interpretation:</b><br>
• <b>Neutrophilia (&gt; 70%):</b> Bacterial infection, inflammation, tissue damage, stress, steroids.<br>
• <b>Lymphocytosis (&gt; 40%):</b> Viral infections (EBV, CMV, mumps, hepatitis), chronic lymphocytic leukemia (CLL), tuberculosis.<br>
• <b>Eosinophilia (&gt; 6%):</b> Allergic asthma, allergic rhinitis, parasitic intestinal worms (helminths), drug hypersensitivity, tropical pulmonary eosinophilia.<br>
• <b>Monocytosis (&gt; 10%):</b> Chronic infections, subacute bacterial endocarditis (SBE), tuberculosis, recovery phase of acute infection.<br>
• <b>Basophilia (&gt; 2%):</b> Chronic myeloid leukemia (CML), systemic allergic reactions, polycythemia vera.</p>",
    "param_count" => 5,
    "parameters" => [
      [
        "name" => "Neutrophils",
        "unit" => "%",
        "method" => "Microscopy / Automated",
        "sample" => "Whole Blood EDTA",
        "male_min" => 40,
        "male_max" => 75,
        "female_min" => 40,
        "female_max" => 75,
        "text" => "40 - 75 %"
      ],
      [
        "name" => "Lymphocytes",
        "unit" => "%",
        "method" => "Microscopy / Automated",
        "sample" => "Whole Blood EDTA",
        "male_min" => 20,
        "male_max" => 45,
        "female_min" => 20,
        "female_max" => 45,
        "text" => "20 - 45 %"
      ],
      [
        "name" => "Eosinophils",
        "unit" => "%",
        "method" => "Microscopy / Automated",
        "sample" => "Whole Blood EDTA",
        "male_min" => 1,
        "male_max" => 6,
        "female_min" => 1,
        "female_max" => 6,
        "text" => "1 - 6 %"
      ],
      [
        "name" => "Monocytes",
        "unit" => "%",
        "method" => "Microscopy / Automated",
        "sample" => "Whole Blood EDTA",
        "male_min" => 2,
        "male_max" => 8,
        "female_min" => 2,
        "female_max" => 8,
        "text" => "2 - 8 %"
      ],
      [
        "name" => "Basophils",
        "unit" => "%",
        "method" => "Microscopy / Automated",
        "sample" => "Whole Blood EDTA",
        "male_min" => 0,
        "male_max" => 1,
        "female_min" => 0,
        "female_max" => 1,
        "text" => "0 - 1 %"
      ]
    ]
  ],
  [
    "test_id" => 7,
    "name" => "Erythrocyte Sedimentation Rate (ESR)",
    "code" => "ESR",
    "category_id" => 2,
    "category_name" => "Hematology",
    "price" => 80.0,
    "notes" => "Westergren Method (1st Hour reading)",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Clinical Significance:</b> Westergren ESR reflects systemic inflammation and elevation of circulating fibrinogen and immunoglobulins.<br>
• <b>Moderate Elevation (20 – 50 mm/hr):</b> Localized infection, pregnancy, mild anemia, thyroid dysfunction, aging.<br>
• <b>Marked Elevation (&gt; 100 mm/hr):</b> Active tuberculosis, deep-seated bacterial abscesses, polymyalgia rheumatica, giant cell arteritis, systemic lupus erythematosus (SLE), multiple myeloma, metastatic malignancy.</p>",
    "param_count" => 1,
    "parameters" => [
      [
        "name" => "Erythrocyte Sedimentation Rate (ESR)",
        "unit" => "mm/1st hr",
        "method" => "Westergren Method",
        "sample" => "Citrated Blood",
        "male_min" => 0,
        "male_max" => 15,
        "female_min" => 0,
        "female_max" => 20,
        "text" => "Male: 0-15 mm, Female: 0-20 mm, Child: 0-10 mm / 1st hr"
      ]
    ]
  ],
  [
    "test_id" => 8,
    "name" => "Absolute Eosinophil Count (AEC)",
    "code" => "AEC",
    "category_id" => 2,
    "category_name" => "Hematology",
    "price" => 120.0,
    "notes" => "Calculated from total WBC and differential eosinophil percentage",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Absolute Eosinophil Count (AEC) Interpretation:</b><br>
• <b>Normal:</b> 40 – 440 cells/µL<br>
• <b>Mild Eosinophilia (440 – 1500 cells/µL):</b> Bronchial asthma, allergic dermatitis, seasonal rhinitis, drug allergy.<br>
• <b>Moderate to Marked (&gt; 1500 cells/µL):</b> Parasitic infestations (Ascaris, Strongyloides, Filariasis), Tropical Pulmonary Eosinophilia (TPE), Churg-Strauss syndrome, Hypereosinophilic Syndrome (HES).</p>",
    "param_count" => 1,
    "parameters" => [
      [
        "name" => "Absolute Eosinophil Count (AEC)",
        "unit" => "cells/cumm",
        "method" => "Calculated / Direct Chamber",
        "sample" => "Whole Blood EDTA",
        "male_min" => 40,
        "male_max" => 440,
        "female_min" => 40,
        "female_max" => 440,
        "text" => "Normal: 40 - 440 cells/cumm"
      ]
    ]
  ],
  [
    "test_id" => 9,
    "name" => "Blood Grouping & Rh (D) Typing",
    "code" => "BLOODGRP",
    "category_id" => 2,
    "category_name" => "Hematology",
    "price" => 100.0,
    "notes" => "Forward and Reverse Tube / Slide Agglutination",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Clinical Significance:</b> Determination of ABO and Rh(D) blood group antigens by forward (cell) and reverse (serum) grouping.<br>
• <b>Pre-transfusion Verification:</b> Vital for matching donor and recipient packed red blood cells to prevent acute hemolytic transfusion reactions.<br>
• <b>Antenatal Screening:</b> Essential for detecting Rh(D)-negative pregnant mothers to administer Anti-D immunoglobulin prophylaxis against Hemolytic Disease of the Fetus and Newborn (HDFN).</p>",
    "param_count" => 2,
    "parameters" => [
      [
        "name" => "ABO Blood Grouping",
        "unit" => "",
        "method" => "Forward & Reverse Agglutination",
        "sample" => "Whole Blood EDTA",
        "male_min" => 0,
        "male_max" => 0,
        "female_min" => 0,
        "female_max" => 0,
        "text" => "Group A / B / AB / O"
      ],
      [
        "name" => "Rh (D) Factor",
        "unit" => "",
        "method" => "Slide / Tube Agglutination",
        "sample" => "Whole Blood EDTA",
        "male_min" => 0,
        "male_max" => 0,
        "female_min" => 0,
        "female_max" => 0,
        "text" => "Positive / Negative"
      ]
    ]
  ],
  [
    "test_id" => 10,
    "name" => "Bleeding Time & Clotting Time (BT & CT)",
    "code" => "BTCT",
    "category_id" => 2,
    "category_name" => "Hematology",
    "price" => 100.0,
    "notes" => "Duke Method (BT) and Capillary Glass Tube Method (CT)",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Clinical Significance:</b> Primary pre-operative bedside screening for hemostatic competency.<br>
• <b>Bleeding Time (Duke: 1 – 5 mins):</b> Assesses platelet-vessel wall interaction (primary hemostasis). Prolonged in thrombocytopenia, von Willebrand disease, and antiplatelet (Aspirin/Clopidogrel) therapy.<br>
• <b>Clotting Time (Capillary: 3 – 8 mins):</b> Assesses intrinsic and common coagulation factor cascade. Prolonged in severe hemophilia or factor deficiencies.</p>",
    "param_count" => 2,
    "parameters" => [
      [
        "name" => "Bleeding Time (BT)",
        "unit" => "minutes",
        "method" => "Duke Method",
        "sample" => "Capillary Blood",
        "male_min" => 1.0,
        "male_max" => 5.0,
        "female_min" => 1.0,
        "female_max" => 5.0,
        "text" => "Normal: 1.0 - 5.0 minutes (Duke Method)"
      ],
      [
        "name" => "Clotting Time (CT)",
        "unit" => "minutes",
        "method" => "Capillary Tube / Lee-White",
        "sample" => "Capillary / Whole Blood",
        "male_min" => 4.0,
        "male_max" => 9.0,
        "female_min" => 4.0,
        "female_max" => 9.0,
        "text" => "Normal: 4.0 - 9.0 minutes"
      ]
    ]
  ],
  [
    "test_id" => 11,
    "name" => "Coagulation Profile (PT, INR, aPTT)",
    "code" => "COAG",
    "category_id" => 2,
    "category_name" => "Hematology",
    "price" => 450.0,
    "notes" => "Citrated plasma automated coagulometer testing",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Clinical Significance:</b> Prothrombin Time (PT) assesses the extrinsic (Factor VII) and common (Factors X, V, II, I) coagulation pathways. International Normalized Ratio (INR) standardizes results across thromboplastin reagents.</p>
<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\" style=\"border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;\">
  <tr style=\"background-color:#f1f5f9; font-weight:bold;\">
    <th style=\"width:30%; padding:2px 4px;\">Clinical Indication</th>
    <th style=\"width:35%; padding:2px 4px;\">Target Therapeutic INR Range</th>
    <th style=\"width:35%; padding:2px 4px;\">Clinical Action Guidance</th>
  </tr>
  <tr><td style=\"padding:2px 4px;\"><b>Normal (Not on Anticoagulants)</b></td><td style=\"padding:2px 4px;\">0.8 – 1.2</td><td style=\"padding:2px 4px;\">Normal baseline coagulation</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>Standard DVT / PE / Atrial Fib</b></td><td style=\"padding:2px 4px;\">2.0 – 3.0</td><td style=\"padding:2px 4px;\">Standard Warfarin / Acitrom therapeutic window</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>Mechanical Heart Valves</b></td><td style=\"padding:2px 4px;\">2.5 – 3.5</td><td style=\"padding:2px 4px;\">Intensive anticoagulation target</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>INR &gt; 4.5 (High Bleeding Risk)</b></td><td style=\"padding:2px 4px;\">Above Therapeutic Range</td><td style=\"padding:2px 4px;\">Risk of major hemorrhage; withhold dose / administer Vitamin K per clinician advice</td></tr>
</table>
<p style=\"font-size:7pt; color:#64748b; margin:2px 0 0 0;\"><i>Note: Also prolonged in Vitamin K deficiency, liver cirrhosis / hepatocellular failure, and DIC.</i></p>
<p style=\"margin:3px 0 0 0;\"><b>Activated Partial Thromboplastin Time (aPTT):</b> Evaluates intrinsic pathway factors (VIII, IX, XI, XII). Normal range: 26 – 38 seconds. Therapeutic Unfractionated Heparin target: 1.5 to 2.5 times baseline control.</p>",
    "param_count" => 4,
    "parameters" => [
      [
        "name" => "Prothrombin Time (PT)",
        "unit" => "seconds",
        "method" => "Neoplastin / Coagulometer",
        "sample" => "Citrated Plasma",
        "male_min" => 11.0,
        "male_max" => 15.0,
        "female_min" => 11.0,
        "female_max" => 15.0,
        "text" => "11.0 - 15.0 seconds"
      ],
      [
        "name" => "PT Control",
        "unit" => "seconds",
        "method" => "Laboratory Control",
        "sample" => "Citrated Plasma",
        "male_min" => 11.0,
        "male_max" => 13.0,
        "female_min" => 11.0,
        "female_max" => 13.0,
        "text" => "11.0 - 13.0 seconds"
      ],
      [
        "name" => "INR (International Normalized Ratio)",
        "unit" => "",
        "method" => "Calculated (PT Patient / PT Control)^ISI",
        "sample" => "Citrated Plasma",
        "male_min" => 0.85,
        "male_max" => 1.15,
        "female_min" => 0.85,
        "female_max" => 1.15,
        "text" => "Normal: 0.85 - 1.15; Therapeutic Warfarin: 2.0 - 3.0"
      ],
      [
        "name" => "Activated Partial Thromboplastin Time (aPTT)",
        "unit" => "seconds",
        "method" => "Coagulometer",
        "sample" => "Citrated Plasma",
        "male_min" => 25.0,
        "male_max" => 35.0,
        "female_min" => 25.0,
        "female_max" => 35.0,
        "text" => "25.0 - 35.0 seconds"
      ]
    ]
  ],
  [
    "test_id" => 12,
    "name" => "Prothrombin Time with INR (PT / INR)",
    "code" => "PTINR",
    "category_id" => 2,
    "category_name" => "Hematology",
    "price" => 300.0,
    "notes" => "Automated coagulometric thromboplastin time measurement",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Clinical Significance:</b> Prothrombin Time (PT) assesses the extrinsic (Factor VII) and common (Factors X, V, II, I) coagulation pathways. International Normalized Ratio (INR) standardizes results across thromboplastin reagents.</p>
<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\" style=\"border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;\">
  <tr style=\"background-color:#f1f5f9; font-weight:bold;\">
    <th style=\"width:30%; padding:2px 4px;\">Clinical Indication</th>
    <th style=\"width:35%; padding:2px 4px;\">Target Therapeutic INR Range</th>
    <th style=\"width:35%; padding:2px 4px;\">Clinical Action Guidance</th>
  </tr>
  <tr><td style=\"padding:2px 4px;\"><b>Normal (Not on Anticoagulants)</b></td><td style=\"padding:2px 4px;\">0.8 – 1.2</td><td style=\"padding:2px 4px;\">Normal baseline coagulation</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>Standard DVT / PE / Atrial Fib</b></td><td style=\"padding:2px 4px;\">2.0 – 3.0</td><td style=\"padding:2px 4px;\">Standard Warfarin / Acitrom therapeutic window</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>Mechanical Heart Valves</b></td><td style=\"padding:2px 4px;\">2.5 – 3.5</td><td style=\"padding:2px 4px;\">Intensive anticoagulation target</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>INR &gt; 4.5 (High Bleeding Risk)</b></td><td style=\"padding:2px 4px;\">Above Therapeutic Range</td><td style=\"padding:2px 4px;\">Risk of major hemorrhage; withhold dose / administer Vitamin K per clinician advice</td></tr>
</table>
<p style=\"font-size:7pt; color:#64748b; margin:2px 0 0 0;\"><i>Note: Also prolonged in Vitamin K deficiency, liver cirrhosis / hepatocellular failure, and DIC.</i></p>",
    "param_count" => 3,
    "parameters" => [
      [
        "name" => "Prothrombin Time (PT)",
        "unit" => "seconds",
        "method" => "Neoplastin / Coagulometer",
        "sample" => "Citrated Plasma",
        "male_min" => 11.0,
        "male_max" => 15.0,
        "female_min" => 11.0,
        "female_max" => 15.0,
        "text" => "11.0 - 15.0 seconds"
      ],
      [
        "name" => "PT Control",
        "unit" => "seconds",
        "method" => "Laboratory Control",
        "sample" => "Citrated Plasma",
        "male_min" => 11.0,
        "male_max" => 13.0,
        "female_min" => 11.0,
        "female_max" => 13.0,
        "text" => "11.0 - 13.0 seconds"
      ],
      [
        "name" => "INR (International Normalized Ratio)",
        "unit" => "",
        "method" => "Calculated (PT Patient / PT Control)^ISI",
        "sample" => "Citrated Plasma",
        "male_min" => 0.85,
        "male_max" => 1.15,
        "female_min" => 0.85,
        "female_max" => 1.15,
        "text" => "Normal: 0.85 - 1.15; Therapeutic Warfarin: 2.0 - 3.0"
      ]
    ]
  ],
  [
    "test_id" => 13,
    "name" => "Activated Partial Thromboplastin Time (aPTT)",
    "code" => "APTT",
    "category_id" => 2,
    "category_name" => "Hematology",
    "price" => 350.0,
    "notes" => "Coagulometer evaluation of intrinsic pathway factors",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Clinical Significance:</b> aPTT evaluates the intrinsic and common coagulation pathways (Factors VIII, IX, XI, XII, X, V, II, I).<br>
• <b>Prolonged aPTT:</b> Unfractionated Heparin therapy, Hemophilia A (Factor VIII deficiency), Hemophilia B (Factor IX deficiency), Von Willebrand disease, Lupus Anticoagulant, Severe liver disease.<br>
• <b>Heparin Monitoring:</b> Target therapeutic aPTT is typically 1.5 – 2.5 times the laboratory normal control value (approx. 50 – 75 seconds).</p>",
    "param_count" => 1,
    "parameters" => [
      [
        "name" => "Activated Partial Thromboplastin Time (aPTT)",
        "unit" => "seconds",
        "method" => "Coagulometer",
        "sample" => "Citrated Plasma",
        "male_min" => 25.0,
        "male_max" => 35.0,
        "female_min" => 25.0,
        "female_max" => 35.0,
        "text" => "25.0 - 35.0 seconds"
      ]
    ]
  ],
  [
    "test_id" => 14,
    "name" => "Peripheral Blood Smear Study (PBS)",
    "code" => "PBS",
    "category_id" => 2,
    "category_name" => "Hematology",
    "price" => 200.0,
    "notes" => "Giemsa / Leishman stained thin blood film microscopic examination by Pathologist",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Clinical Significance:</b> Morphological light microscopic evaluation of stained peripheral blood smear film by Pathologist.<br>
• <b>RBC Morphology:</b> Microcytic hypochromic (Iron deficiency, Thalassemia), Macrocytic/Megaloblastic (Vit B12/Folate deficiency), Normocytic normochromic (anemia of chronic disease, acute blood loss), Sickle cells, Spherocytes, Target cells.<br>
• <b>WBC Morphology:</b> Toxic granules, vacuolation, Dohle bodies (severe sepsis); Hypersegmented neutrophils (&gt; 5 lobes: megaloblastic anemia); Blast cells, immature myeloid/lymphoid precursors (leukemia workup required).<br>
• <b>Platelet Morphology:</b> Giant platelets (ITP, Bernard-Soulier syndrome); Platelet clumping (EDTA-induced pseudothrombocytopenia, re-check in citrate).</p>",
    "param_count" => 3,
    "parameters" => [
      [
        "name" => "RBC Morphology (Smear)",
        "unit" => "",
        "method" => "Leishman / Giemsa Smear",
        "sample" => "Whole Blood EDTA",
        "male_min" => 0,
        "male_max" => 0,
        "female_min" => 0,
        "female_max" => 0,
        "text" => "Normocytic Normochromic RBCs"
      ],
      [
        "name" => "WBC Morphology (Smear)",
        "unit" => "",
        "method" => "Smear Microscopy",
        "sample" => "Whole Blood EDTA",
        "male_min" => 0,
        "male_max" => 0,
        "female_min" => 0,
        "female_max" => 0,
        "text" => "Normal in number and morphology; no immature cells seen"
      ],
      [
        "name" => "Platelet on Smear",
        "unit" => "",
        "method" => "Smear Microscopy",
        "sample" => "Whole Blood EDTA",
        "male_min" => 0,
        "male_max" => 0,
        "female_min" => 0,
        "female_max" => 0,
        "text" => "Adequate on smear (10-15 platelets / oil immersion field)"
      ]
    ]
  ],
  [
    "test_id" => 15,
    "name" => "Reticulocyte Count",
    "code" => "RETIC",
    "category_id" => 2,
    "category_name" => "Hematology",
    "price" => 200.0,
    "notes" => "Supravital Brilliant Cresyl Blue staining",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Clinical Significance:</b> Reticulocytes are young, non-nucleated RBCs containing remnant ribosomal RNA. Reflects active bone marrow erythropoiesis.<br>
• <b>Reticulocytosis (&gt; 2.5%):</b> Acute blood loss, hemolytic anemia (sickle cell, autoimmune hemolysis), or positive response to iron/vitamin B12/folate therapy within 5–7 days.<br>
• <b>Reticulocytopenia (&lt; 0.5%):</b> Bone marrow failure (Aplastic anemia, pure red cell aplasia), untreated nutritional deficiency, myelodysplastic syndrome (MDS).</p>",
    "param_count" => 1,
    "parameters" => [
      [
        "name" => "Reticulocyte Count",
        "unit" => "%",
        "method" => "Supravital Brilliant Cresyl Blue / Automated",
        "sample" => "Whole Blood EDTA",
        "male_min" => 0.5,
        "male_max" => 2.5,
        "female_min" => 0.5,
        "female_max" => 2.5,
        "text" => "Adults: 0.5 - 2.5 %, Infants: 2.0 - 6.0 %"
      ]
    ]
  ],
  [
    "test_id" => 16,
    "name" => "D-Dimer (Quantitative)",
    "code" => "DDIMER",
    "category_id" => 2,
    "category_name" => "Hematology",
    "price" => 800.0,
    "notes" => "Immunoturbidimetric quantitative measurement",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Clinical Significance:</b> D-Dimer is a specific fibrin degradation product generated when cross-linked fibrin is degraded by plasmin. Sensitive marker for active fibrin formation and fibrinolysis.</p>
<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\" style=\"border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;\">
  <tr style=\"background-color:#f1f5f9; font-weight:bold;\">
    <th style=\"width:30%; padding:2px 4px;\">D-Dimer Level</th>
    <th style=\"width:35%; padding:2px 4px;\">Diagnostic Utility</th>
    <th style=\"width:35%; padding:2px 4px;\">Clinical Significance</th>
  </tr>
  <tr><td style=\"padding:2px 4px;\"><b>&lt; 0.50 µg/mL FEU (&lt; 500 ng/mL)</b></td><td style=\"padding:2px 4px;\">High Negative Predictive Value (&gt; 98%)</td><td style=\"padding:2px 4px;\">Reliably excludes Deep Vein Thrombosis (DVT) and Pulmonary Embolism (PE) in low-to-moderate pretest risk patients</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>&gt; 0.50 µg/mL FEU</b></td><td style=\"padding:2px 4px;\">Positive / Elevated</td><td style=\"padding:2px 4px;\">Venous thromboembolism (DVT/PE), Disseminated Intravascular Coagulation (DIC), acute aortic dissection, severe sepsis, COVID-19 associated coagulopathy, malignancy, major trauma, pregnancy</td></tr>
</table>",
    "param_count" => 1,
    "parameters" => [
      [
        "name" => "D-Dimer",
        "unit" => "ng/mL FEU",
        "method" => "Immunoturbidimetry",
        "sample" => "Citrated Plasma",
        "male_min" => 0,
        "male_max" => 500,
        "female_min" => 0,
        "female_max" => 500,
        "text" => "< 500 ng/mL FEU (Negative)"
      ]
    ]
  ],
  [
    "test_id" => 17,
    "name" => "Fasting Blood Glucose (FBS)",
    "code" => "FBS",
    "category_id" => 1,
    "category_name" => "Biochemistry",
    "price" => 60.0,
    "notes" => "GOD-POD / Hexokinase method following 8-12 hours overnight fast",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Diagnostic Criteria for Fasting Blood Glucose (ADA / WHO Guidelines):</b></p>
<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\" style=\"border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;\">
  <tr style=\"background-color:#f1f5f9; font-weight:bold;\">
    <th style=\"width:30%; padding:2px 4px;\">Fasting Plasma Glucose (mg/dL)</th>
    <th style=\"width:35%; padding:2px 4px;\">Diagnostic Classification</th>
    <th style=\"width:35%; padding:2px 4px;\">Clinical Management Recommendation</th>
  </tr>
  <tr><td style=\"padding:2px 4px;\"><b>70 – 99 mg/dL</b></td><td style=\"padding:2px 4px;\">Normal Fasting Glucose</td><td style=\"padding:2px 4px;\">Routine annual health checkup</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>100 – 125 mg/dL</b></td><td style=\"padding:2px 4px;\">Impaired Fasting Glucose (Pre-Diabetes)</td><td style=\"padding:2px 4px;\">Lifestyle modification, dietary intervention, repeat with HbA1c/OGTT</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>≥ 126 mg/dL</b></td><td style=\"padding:2px 4px;\">Provisional Diabetes Mellitus</td><td style=\"padding:2px 4px;\">Confirm on repeat testing or correlate with HbA1c ≥ 6.5%</td></tr>
</table>
<p style=\"font-size:7pt; color:#64748b; margin:2px 0 0 0;\"><i>Pre-analytical requirement: Minimum 8 to 12 hours overnight fast. Water permitted. Hypoglycemia defined as &lt; 70 mg/dL.</i></p>",
    "param_count" => 1,
    "parameters" => [
      [
        "name" => "Fasting Blood Glucose (FBS)",
        "unit" => "mg/dL",
        "method" => "GOD-POD / Hexokinase",
        "sample" => "Fluoride Plasma",
        "male_min" => 70,
        "male_max" => 100,
        "female_min" => 70,
        "female_max" => 100,
        "text" => "Normal: 70-100, Impaired/Pre-diabetes: 101-125, Diabetes: >=126 mg/dL"
      ]
    ]
  ],
  [
    "test_id" => 18,
    "name" => "Postprandial Blood Glucose (PPBS)",
    "code" => "PPBS",
    "category_id" => 1,
    "category_name" => "Biochemistry",
    "price" => 60.0,
    "notes" => "GOD-POD method measured exactly 2 hours after breakfast or meal",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Diagnostic Criteria for 2-Hour Postprandial Glucose (ADA Guidelines):</b></p>
<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\" style=\"border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;\">
  <tr style=\"background-color:#f1f5f9; font-weight:bold;\">
    <th style=\"width:30%; padding:2px 4px;\">2-Hour PP Glucose (mg/dL)</th>
    <th style=\"width:35%; padding:2px 4px;\">Diagnostic Classification</th>
    <th style=\"width:35%; padding:2px 4px;\">Clinical Implication</th>
  </tr>
  <tr><td style=\"padding:2px 4px;\"><b>&lt; 140 mg/dL</b></td><td style=\"padding:2px 4px;\">Normal Postprandial Glucose</td><td style=\"padding:2px 4px;\">Normal insulinemic response</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>140 – 199 mg/dL</b></td><td style=\"padding:2px 4px;\">Impaired Glucose Tolerance (Pre-Diabetes)</td><td style=\"padding:2px 4px;\">High cardiovascular risk, insulin resistance; lifestyle modification</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>≥ 200 mg/dL</b></td><td style=\"padding:2px 4px;\">Provisional Diabetes Mellitus</td><td style=\"padding:2px 4px;\">Suggests overt Diabetes Mellitus; confirm with fasting/HbA1c</td></tr>
</table>
<p style=\"font-size:7pt; color:#64748b; margin:2px 0 0 0;\"><i>Note: Sample should be collected exactly 2 hours after the start of a regular meal or 75g oral glucose load.</i></p>",
    "param_count" => 1,
    "parameters" => [
      [
        "name" => "Postprandial Blood Glucose (PPBS)",
        "unit" => "mg/dL",
        "method" => "GOD-POD / Hexokinase",
        "sample" => "Fluoride Plasma",
        "male_min" => 70,
        "male_max" => 140,
        "female_min" => 70,
        "female_max" => 140,
        "text" => "Normal: <140, Impaired Glucose Tolerance: 140-199, Diabetes: >=200 mg/dL"
      ]
    ]
  ],
  [
    "test_id" => 19,
    "name" => "Random Blood Sugar (RBS)",
    "code" => "RBS",
    "category_id" => 1,
    "category_name" => "Biochemistry",
    "price" => 60.0,
    "notes" => "GOD-POD enzymatic method taken at any time regardless of food intake",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Random Blood Sugar (RBS) Clinical Interpretation:</b><br>
• <b>Normal:</b> 70 – 140 mg/dL (depending on time elapsed since last meal).<br>
• <b>Diabetes Mellitus:</b> Random blood glucose ≥ 200 mg/dL in the presence of classic diabetic symptoms (polyuria, polydipsia, unexplained weight loss) is diagnostic of Diabetes Mellitus.<br>
• <b>Hypoglycemia (&lt; 70 mg/dL):</b> Requires prompt clinical management, particularly in diabetic patients taking insulin or sulfonylureas.</p>",
    "param_count" => 1,
    "parameters" => [
      [
        "name" => "Random Blood Sugar (RBS)",
        "unit" => "mg/dL",
        "method" => "GOD-POD / Hexokinase",
        "sample" => "Fluoride Plasma",
        "male_min" => 70,
        "male_max" => 140,
        "female_min" => 70,
        "female_max" => 140,
        "text" => "Normal: 70 - 140 mg/dL (Diabetes suspected if >= 200 with symptoms)"
      ]
    ]
  ],
  [
    "test_id" => 20,
    "name" => "HbA1c (Glycated Hemoglobin)",
    "code" => "HBA1C",
    "category_id" => 1,
    "category_name" => "Biochemistry",
    "price" => 400.0,
    "notes" => "NGSP / IFCC certified High Performance Liquid Chromatography (HPLC)",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Clinical Significance:</b> Glycated Hemoglobin (HbA1c) reflects average plasma glucose concentration over the preceding 2 to 3 months (red cell lifespan). Standardized to NGSP / IFCC reference methods.</p>
<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\" style=\"border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;\">
  <tr style=\"background-color:#f1f5f9; font-weight:bold;\">
    <th style=\"width:25%; padding:2px 4px;\">HbA1c Range (%)</th>
    <th style=\"width:35%; padding:2px 4px;\">Glycemic Category (ADA / RSSDI)</th>
    <th style=\"width:40%; padding:2px 4px;\">Estimated Average Glucose (eAG)</th>
  </tr>
  <tr><td style=\"padding:2px 4px;\"><b>&lt; 5.7 %</b></td><td style=\"padding:2px 4px;\">Normal (Non-Diabetic)</td><td style=\"padding:2px 4px;\">Approx. &lt; 117 mg/dL</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>5.7 % – 6.4 %</b></td><td style=\"padding:2px 4px;\">Pre-Diabetes (High Risk for Diabetes)</td><td style=\"padding:2px 4px;\">117 – 137 mg/dL</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>≥ 6.5 %</b></td><td style=\"padding:2px 4px;\">Diabetes Mellitus (Confirmatory)</td><td style=\"padding:2px 4px;\">≥ 140 mg/dL (eAG formula: 28.7 × HbA1c – 46.7)</td></tr>
</table>
<p style=\"margin:2px 0 0 0; font-size:7.5pt;\"><b>Therapeutic Target for Diabetics:</b> &lt; 7.0% for most non-pregnant adults. More stringent (&lt; 6.5%) in young patients; less stringent (&lt; 8.0%) in elderly or those with hypoglycemia history.<br>
<span style=\"font-size:7pt; color:#64748b;\"><i>Limitations: Falsely low in hemolytic anemia, pregnancy, acute blood loss. Falsely high in iron deficiency anemia, splenectomy. Hemoglobin variants (HbS, HbE, Thalassemia) may interfere depending on assay method.</i></span></p>",
    "param_count" => 2,
    "parameters" => [
      [
        "name" => "HbA1c (Glycated Hemoglobin)",
        "unit" => "%",
        "method" => "HPLC (NGSP / IFCC Certified)",
        "sample" => "Whole Blood EDTA",
        "male_min" => 4.0,
        "male_max" => 5.6,
        "female_min" => 4.0,
        "female_max" => 5.6,
        "text" => "Non-diabetic: 4.0-5.6%, Pre-diabetes: 5.7-6.4%, Diabetes: >=6.5%, Good Control: <7.0%"
      ],
      [
        "name" => "Estimated Average Glucose (eAG)",
        "unit" => "mg/dL",
        "method" => "Calculated (28.7 * HbA1c - 46.7)",
        "sample" => "Whole Blood EDTA",
        "male_min" => 90,
        "male_max" => 120,
        "female_min" => 90,
        "female_max" => 120,
        "text" => "Normal: 90 - 120 mg/dL"
      ]
    ]
  ],
  [
    "test_id" => 21,
    "name" => "Blood Sugar Profile (FBS, PPBS & HbA1c)",
    "code" => "DIABETES",
    "category_id" => 1,
    "category_name" => "Biochemistry",
    "price" => 450.0,
    "notes" => "Complete glycemic assessment combining fasting, postprandial, and 3-month glycated hemoglobin",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Clinical Significance:</b> Glycated Hemoglobin (HbA1c) reflects average plasma glucose concentration over the preceding 2 to 3 months (red cell lifespan). Standardized to NGSP / IFCC reference methods.</p>
<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\" style=\"border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;\">
  <tr style=\"background-color:#f1f5f9; font-weight:bold;\">
    <th style=\"width:25%; padding:2px 4px;\">HbA1c Range (%)</th>
    <th style=\"width:35%; padding:2px 4px;\">Glycemic Category (ADA / RSSDI)</th>
    <th style=\"width:40%; padding:2px 4px;\">Estimated Average Glucose (eAG)</th>
  </tr>
  <tr><td style=\"padding:2px 4px;\"><b>&lt; 5.7 %</b></td><td style=\"padding:2px 4px;\">Normal (Non-Diabetic)</td><td style=\"padding:2px 4px;\">Approx. &lt; 117 mg/dL</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>5.7 % – 6.4 %</b></td><td style=\"padding:2px 4px;\">Pre-Diabetes (High Risk for Diabetes)</td><td style=\"padding:2px 4px;\">117 – 137 mg/dL</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>≥ 6.5 %</b></td><td style=\"padding:2px 4px;\">Diabetes Mellitus (Confirmatory)</td><td style=\"padding:2px 4px;\">≥ 140 mg/dL (eAG formula: 28.7 × HbA1c – 46.7)</td></tr>
</table>
<p style=\"margin:2px 0 0 0; font-size:7.5pt;\"><b>Therapeutic Target for Diabetics:</b> &lt; 7.0% for most non-pregnant adults. More stringent (&lt; 6.5%) in young patients; less stringent (&lt; 8.0%) in elderly or those with hypoglycemia history.<br>
<span style=\"font-size:7pt; color:#64748b;\"><i>Limitations: Falsely low in hemolytic anemia, pregnancy, acute blood loss. Falsely high in iron deficiency anemia, splenectomy. Hemoglobin variants (HbS, HbE, Thalassemia) may interfere depending on assay method.</i></span></p>
<p style=\"margin:3px 0 0 0;\"><b>Comprehensive Blood Sugar Profile:</b> Combines immediate acute fasting (FBS) and postprandial (PPBS) excursions with 3-month retrospective glycemic control (HbA1c) to optimize anti-diabetic pharmacotherapy and lifestyle planning.</p>",
    "param_count" => 4,
    "parameters" => [
      [
        "name" => "Fasting Blood Glucose (FBS)",
        "unit" => "mg/dL",
        "method" => "GOD-POD / Hexokinase",
        "sample" => "Fluoride Plasma",
        "male_min" => 70,
        "male_max" => 100,
        "female_min" => 70,
        "female_max" => 100,
        "text" => "Normal: 70-100, Impaired/Pre-diabetes: 101-125, Diabetes: >=126 mg/dL"
      ],
      [
        "name" => "Postprandial Blood Glucose (PPBS)",
        "unit" => "mg/dL",
        "method" => "GOD-POD / Hexokinase",
        "sample" => "Fluoride Plasma",
        "male_min" => 70,
        "male_max" => 140,
        "female_min" => 70,
        "female_max" => 140,
        "text" => "Normal: <140, Impaired Glucose Tolerance: 140-199, Diabetes: >=200 mg/dL"
      ],
      [
        "name" => "HbA1c (Glycated Hemoglobin)",
        "unit" => "%",
        "method" => "HPLC (NGSP / IFCC Certified)",
        "sample" => "Whole Blood EDTA",
        "male_min" => 4.0,
        "male_max" => 5.6,
        "female_min" => 4.0,
        "female_max" => 5.6,
        "text" => "Non-diabetic: 4.0-5.6%, Pre-diabetes: 5.7-6.4%, Diabetes: >=6.5%, Good Control: <7.0%"
      ],
      [
        "name" => "Estimated Average Glucose (eAG)",
        "unit" => "mg/dL",
        "method" => "Calculated (28.7 * HbA1c - 46.7)",
        "sample" => "Whole Blood EDTA",
        "male_min" => 90,
        "male_max" => 120,
        "female_min" => 90,
        "female_max" => 120,
        "text" => "Normal: 90 - 120 mg/dL"
      ]
    ]
  ],
  [
    "test_id" => 22,
    "name" => "Oral Glucose Tolerance Test (OGTT / GTT)",
    "code" => "OGTT",
    "category_id" => 1,
    "category_name" => "Biochemistry",
    "price" => 250.0,
    "notes" => "Fasting, 1-hour, and 2-hour blood sugars following 75g anhydrous oral glucose load",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Oral Glucose Tolerance Test (75g anhydrous oral glucose) Diagnostic Cutoffs:</b></p>
<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\" style=\"border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;\">
  <tr style=\"background-color:#f1f5f9; font-weight:bold;\">
    <th style=\"width:25%; padding:2px 4px;\">Category</th>
    <th style=\"width:35%; padding:2px 4px;\">Fasting Plasma Glucose</th>
    <th style=\"width:40%; padding:2px 4px;\">2-Hour Plasma Glucose</th>
  </tr>
  <tr><td style=\"padding:2px 4px;\"><b>Normal</b></td><td style=\"padding:2px 4px;\">&lt; 100 mg/dL</td><td style=\"padding:2px 4px;\">&lt; 140 mg/dL</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>Impaired (Pre-Diabetes)</b></td><td style=\"padding:2px 4px;\">100 – 125 mg/dL (IFG)</td><td style=\"padding:2px 4px;\">140 – 199 mg/dL (IGT)</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>Diabetes Mellitus</b></td><td style=\"padding:2px 4px;\">≥ 126 mg/dL</td><td style=\"padding:2px 4px;\">≥ 200 mg/dL</td></tr>
</table>
<p style=\"font-size:7pt; color:#64748b; margin:2px 0 0 0;\"><i>Gestational Diabetes (DIPSI Guidelines): Single 2-hr non-fasting 75g glucose ≥ 140 mg/dL is diagnostic for GDM in pregnant women.</i></p>",
    "param_count" => 3,
    "parameters" => [
      [
        "name" => "OGTT - Fasting",
        "unit" => "mg/dL",
        "method" => "GOD-POD",
        "sample" => "Fluoride Plasma",
        "male_min" => 70,
        "male_max" => 100,
        "female_min" => 70,
        "female_max" => 100,
        "text" => "Normal: 70 - 100 mg/dL"
      ],
      [
        "name" => "OGTT - 1 Hour (75g Glucose)",
        "unit" => "mg/dL",
        "method" => "GOD-POD",
        "sample" => "Fluoride Plasma",
        "male_min" => 70,
        "male_max" => 180,
        "female_min" => 70,
        "female_max" => 180,
        "text" => "Normal: < 180 mg/dL"
      ],
      [
        "name" => "OGTT - 2 Hours (75g Glucose)",
        "unit" => "mg/dL",
        "method" => "GOD-POD",
        "sample" => "Fluoride Plasma",
        "male_min" => 70,
        "male_max" => 140,
        "female_min" => 70,
        "female_max" => 140,
        "text" => "Normal: < 140 mg/dL (140-199 Impaired, >= 200 Diabetes)"
      ]
    ]
  ],
  [
    "test_id" => 23,
    "name" => "Serum Creatinine",
    "code" => "CREAT",
    "category_id" => 1,
    "category_name" => "Biochemistry",
    "price" => 120.0,
    "notes" => "Modified Jaffe Kinetic / Enzymatic method",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Clinical Significance:</b> Serum Creatinine is an endogenous catabolic product of muscle creatine phosphate, eliminated primarily by glomerular filtration.</p>
<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\" style=\"border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;\">
  <tr style=\"background-color:#f1f5f9; font-weight:bold;\">
    <th style=\"width:25%; padding:2px 4px;\">CKD Stage (KDIGO)</th>
    <th style=\"width:35%; padding:2px 4px;\">eGFR (mL/min/1.73 m²)</th>
    <th style=\"width:40%; padding:2px 4px;\">Kidney Function Description</th>
  </tr>
  <tr><td style=\"padding:2px 4px;\"><b>Stage 1</b></td><td style=\"padding:2px 4px;\">≥ 90</td><td style=\"padding:2px 4px;\">Normal or high GFR with structural/urinary kidney damage</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>Stage 2</b></td><td style=\"padding:2px 4px;\">60 – 89</td><td style=\"padding:2px 4px;\">Mild reduction in GFR with evidence of kidney damage</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>Stage 3a / 3b</b></td><td style=\"padding:2px 4px;\">45 – 59 / 30 – 44</td><td style=\"padding:2px 4px;\">Moderate to severe reduction in kidney function</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>Stage 4</b></td><td style=\"padding:2px 4px;\">15 – 29</td><td style=\"padding:2px 4px;\">Severely decreased GFR; preparation for renal replacement</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>Stage 5 (ESRD)</b></td><td style=\"padding:2px 4px;\">&lt; 15</td><td style=\"padding:2px 4px;\">Kidney failure; dialysis or renal transplantation indicated</td></tr>
</table>
<p style=\"font-size:7pt; color:#64748b; margin:2px 0 0 0;\"><i>Creatinine levels are proportional to muscle mass; lower in elderly/malnourished and higher in athletes. Mandatory check prior to intravenous radiocontrast imaging.</i></p>",
    "param_count" => 1,
    "parameters" => [
      [
        "name" => "Serum Creatinine",
        "unit" => "mg/dL",
        "method" => "Modified Jaffe Kinetic / Enzymatic",
        "sample" => "Serum",
        "male_min" => 0.7,
        "male_max" => 1.3,
        "female_min" => 0.6,
        "female_max" => 1.1,
        "text" => "Male: 0.7 - 1.3 mg/dL, Female: 0.6 - 1.1 mg/dL, Child: 0.3 - 0.7 mg/dL"
      ]
    ]
  ],
  [
    "test_id" => 24,
    "name" => "Blood Urea",
    "code" => "UREA",
    "category_id" => 1,
    "category_name" => "Biochemistry",
    "price" => 100.0,
    "notes" => "Enzymatic Colorimetric (Urease-GLDH)",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Blood Urea / BUN Clinical Significance:</b> Major nitrogenous end-product of protein catabolism produced by the liver.<br>
• <b>Pre-Renal Azotemia:</b> Dehydration, hypovolemia, congestive heart failure, upper GI bleeding, high protein intake (BUN:Creatinine ratio &gt; 20:1).<br>
• <b>Renal Azotemia:</b> Acute tubular necrosis, chronic glomerulonephritis, bilateral pyelonephritis (BUN:Creatinine ratio 10–15:1).<br>
• <b>Post-Renal Azotemia:</b> Urinary tract obstruction (prostatic enlargement, calculi, tumors).</p>",
    "param_count" => 1,
    "parameters" => [
      [
        "name" => "Blood Urea",
        "unit" => "mg/dL",
        "method" => "Enzymatic Colorimetric (Urease-GLDH)",
        "sample" => "Serum",
        "male_min" => 15.0,
        "male_max" => 40.0,
        "female_min" => 15.0,
        "female_max" => 40.0,
        "text" => "15.0 - 40.0 mg/dL"
      ]
    ]
  ],
  [
    "test_id" => 25,
    "name" => "Blood Urea Nitrogen (BUN)",
    "code" => "BUN",
    "category_id" => 1,
    "category_name" => "Biochemistry",
    "price" => 100.0,
    "notes" => "Calculated from Urea / Urease UV method",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Blood Urea / BUN Clinical Significance:</b> Major nitrogenous end-product of protein catabolism produced by the liver.<br>
• <b>Pre-Renal Azotemia:</b> Dehydration, hypovolemia, congestive heart failure, upper GI bleeding, high protein intake (BUN:Creatinine ratio &gt; 20:1).<br>
• <b>Renal Azotemia:</b> Acute tubular necrosis, chronic glomerulonephritis, bilateral pyelonephritis (BUN:Creatinine ratio 10–15:1).<br>
• <b>Post-Renal Azotemia:</b> Urinary tract obstruction (prostatic enlargement, calculi, tumors).</p>",
    "param_count" => 1,
    "parameters" => [
      [
        "name" => "Blood Urea Nitrogen (BUN)",
        "unit" => "mg/dL",
        "method" => "Calculated / Urease",
        "sample" => "Serum",
        "male_min" => 7.0,
        "male_max" => 20.0,
        "female_min" => 7.0,
        "female_max" => 20.0,
        "text" => "7.0 - 20.0 mg/dL"
      ]
    ]
  ],
  [
    "test_id" => 26,
    "name" => "Serum Uric Acid",
    "code" => "URIC",
    "category_id" => 1,
    "category_name" => "Biochemistry",
    "price" => 120.0,
    "notes" => "Enzymatic Uricase-PAP method",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Serum Uric Acid Clinical Interpretation:</b> End-product of purine metabolism.<br>
• <b>Hyperuricemia (&gt; 7.0 mg/dL in males, &gt; 6.0 mg/dL in females):</b> Associated with acute/chronic gout, uric acid nephrolithiasis, renal failure, pre-eclampsia, metabolic syndrome, psoriasis, and tumor lysis syndrome.<br>
• <b>Asymptomatic Hyperuricemia:</b> Does not establish a diagnosis of acute gouty arthritis without compatible joint aspirate (monosodium urate crystals) or clinical arthritis signs.</p>",
    "param_count" => 1,
    "parameters" => [
      [
        "name" => "Serum Uric Acid",
        "unit" => "mg/dL",
        "method" => "Uricase-PAP",
        "sample" => "Serum",
        "male_min" => 3.5,
        "male_max" => 7.2,
        "female_min" => 2.6,
        "female_max" => 6.0,
        "text" => "Male: 3.5 - 7.2 mg/dL, Female: 2.6 - 6.0 mg/dL"
      ]
    ]
  ],
  [
    "test_id" => 27,
    "name" => "Kidney Function Test (KFT / RFT Complete)",
    "code" => "KFT",
    "category_id" => 1,
    "category_name" => "Biochemistry",
    "price" => 450.0,
    "notes" => "Includes Blood Urea, BUN, Serum Creatinine, Uric Acid, Calcium and Phosphorus",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Clinical Significance:</b> Serum Creatinine is an endogenous catabolic product of muscle creatine phosphate, eliminated primarily by glomerular filtration.</p>
<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\" style=\"border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;\">
  <tr style=\"background-color:#f1f5f9; font-weight:bold;\">
    <th style=\"width:25%; padding:2px 4px;\">CKD Stage (KDIGO)</th>
    <th style=\"width:35%; padding:2px 4px;\">eGFR (mL/min/1.73 m²)</th>
    <th style=\"width:40%; padding:2px 4px;\">Kidney Function Description</th>
  </tr>
  <tr><td style=\"padding:2px 4px;\"><b>Stage 1</b></td><td style=\"padding:2px 4px;\">≥ 90</td><td style=\"padding:2px 4px;\">Normal or high GFR with structural/urinary kidney damage</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>Stage 2</b></td><td style=\"padding:2px 4px;\">60 – 89</td><td style=\"padding:2px 4px;\">Mild reduction in GFR with evidence of kidney damage</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>Stage 3a / 3b</b></td><td style=\"padding:2px 4px;\">45 – 59 / 30 – 44</td><td style=\"padding:2px 4px;\">Moderate to severe reduction in kidney function</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>Stage 4</b></td><td style=\"padding:2px 4px;\">15 – 29</td><td style=\"padding:2px 4px;\">Severely decreased GFR; preparation for renal replacement</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>Stage 5 (ESRD)</b></td><td style=\"padding:2px 4px;\">&lt; 15</td><td style=\"padding:2px 4px;\">Kidney failure; dialysis or renal transplantation indicated</td></tr>
</table>
<p style=\"font-size:7pt; color:#64748b; margin:2px 0 0 0;\"><i>Creatinine levels are proportional to muscle mass; lower in elderly/malnourished and higher in athletes. Mandatory check prior to intravenous radiocontrast imaging.</i></p>
<p style=\"margin:3px 0 0 0;\"><b>Comprehensive KFT/RFT Panel:</b> Evaluates glomerular filtration (Creatinine, BUN, Urea), mineral metabolism (Calcium, Phosphorus), and purine catabolism (Uric Acid). Serum Electrolytes (Na, K) are recommended for complete renal assessment.</p>",
    "param_count" => 6,
    "parameters" => [
      [
        "name" => "Blood Urea",
        "unit" => "mg/dL",
        "method" => "Enzymatic Colorimetric (Urease-GLDH)",
        "sample" => "Serum",
        "male_min" => 15.0,
        "male_max" => 40.0,
        "female_min" => 15.0,
        "female_max" => 40.0,
        "text" => "15.0 - 40.0 mg/dL"
      ],
      [
        "name" => "Blood Urea Nitrogen (BUN)",
        "unit" => "mg/dL",
        "method" => "Calculated / Urease",
        "sample" => "Serum",
        "male_min" => 7.0,
        "male_max" => 20.0,
        "female_min" => 7.0,
        "female_max" => 20.0,
        "text" => "7.0 - 20.0 mg/dL"
      ],
      [
        "name" => "Serum Creatinine",
        "unit" => "mg/dL",
        "method" => "Modified Jaffe Kinetic / Enzymatic",
        "sample" => "Serum",
        "male_min" => 0.7,
        "male_max" => 1.3,
        "female_min" => 0.6,
        "female_max" => 1.1,
        "text" => "Male: 0.7 - 1.3 mg/dL, Female: 0.6 - 1.1 mg/dL, Child: 0.3 - 0.7 mg/dL"
      ],
      [
        "name" => "Serum Uric Acid",
        "unit" => "mg/dL",
        "method" => "Uricase-PAP",
        "sample" => "Serum",
        "male_min" => 3.5,
        "male_max" => 7.2,
        "female_min" => 2.6,
        "female_max" => 6.0,
        "text" => "Male: 3.5 - 7.2 mg/dL, Female: 2.6 - 6.0 mg/dL"
      ],
      [
        "name" => "Serum Calcium",
        "unit" => "mg/dL",
        "method" => "Arsenazo III",
        "sample" => "Serum",
        "male_min" => 8.5,
        "male_max" => 10.5,
        "female_min" => 8.5,
        "female_max" => 10.5,
        "text" => "8.5 - 10.5 mg/dL"
      ],
      [
        "name" => "Serum Phosphorus",
        "unit" => "mg/dL",
        "method" => "Phosphomolybdate UV",
        "sample" => "Serum",
        "male_min" => 2.5,
        "male_max" => 4.5,
        "female_min" => 2.5,
        "female_max" => 4.5,
        "text" => "Adults: 2.5 - 4.5 mg/dL, Children: 4.0 - 6.5 mg/dL"
      ]
    ]
  ],
  [
    "test_id" => 28,
    "name" => "Liver Function Test (LFT Complete)",
    "code" => "LFT",
    "category_id" => 1,
    "category_name" => "Biochemistry",
    "price" => 500.0,
    "notes" => "Includes Bilirubin Total, Direct, Indirect, SGOT, SGPT, ALP, GGT, Total Protein, Albumin, Globulin & A/G Ratio",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Liver Function Panel Clinical Pattern Differentiation:</b></p>
<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\" style=\"border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;\">
  <tr style=\"background-color:#f1f5f9; font-weight:bold;\">
    <th style=\"width:25%; padding:2px 4px;\">Pattern Type</th>
    <th style=\"width:35%; padding:2px 4px;\">Predominant Enzyme Elevation</th>
    <th style=\"width:40%; padding:2px 4px;\">Common Etiologies</th>
  </tr>
  <tr>
    <td style=\"padding:2px 4px;\"><b>Hepatocellular Injury</b></td>
    <td style=\"padding:2px 4px;\"><b>SGPT (ALT) &gt; SGOT (AST)</b> (markedly high, often &gt; 5–10× ULN)</td>
    <td style=\"padding:2px 4px;\">Acute viral hepatitis (Hep A, B, E), drug-induced liver injury (Paracetamol, ATT), ischemic hepatitis, NAFLD/NASH</td>
  </tr>
  <tr>
    <td style=\"padding:2px 4px;\"><b>Alcoholic Liver Disease</b></td>
    <td style=\"padding:2px 4px;\"><b>SGOT (AST) &gt; SGPT (ALT)</b> (De Ritis ratio &gt; 2:1) + high GGT</td>
    <td style=\"padding:2px 4px;\">Alcoholic hepatitis, alcoholic cirrhosis</td>
  </tr>
  <tr>
    <td style=\"padding:2px 4px;\"><b>Cholestatic / Obstructive</b></td>
    <td style=\"padding:2px 4px;\"><b>Alkaline Phosphatase (ALP) &amp; GGT</b> markedly elevated &gt;&gt; transaminases</td>
    <td style=\"padding:2px 4px;\">Choledocholithiasis (CBD stone), biliary stricture, carcinoma head of pancreas, primary biliary cholangitis</td>
  </tr>
  <tr>
    <td style=\"padding:2px 4px;\"><b>Hepatic Synthetic Failure</b></td>
    <td style=\"padding:2px 4px;\">Low Albumin, Reversed A/G ratio, Prolonged Prothrombin Time (PT/INR)</td>
    <td style=\"padding:2px 4px;\">Decompensated liver cirrhosis, acute fulminant liver failure</td>
  </tr>
</table>",
    "param_count" => 11,
    "parameters" => [
      [
        "name" => "Total Bilirubin",
        "unit" => "mg/dL",
        "method" => "Diazo / Modified Jendrassik-Grof",
        "sample" => "Serum (Fasting preferred)",
        "male_min" => 0.2,
        "male_max" => 1.2,
        "female_min" => 0.2,
        "female_max" => 1.1,
        "text" => "0.2 - 1.2 mg/dL"
      ],
      [
        "name" => "Direct Bilirubin (Conjugated)",
        "unit" => "mg/dL",
        "method" => "Diazo Method",
        "sample" => "Serum",
        "male_min" => 0.0,
        "male_max" => 0.3,
        "female_min" => 0.0,
        "female_max" => 0.3,
        "text" => "0.0 - 0.3 mg/dL"
      ],
      [
        "name" => "Indirect Bilirubin (Unconjugated)",
        "unit" => "mg/dL",
        "method" => "Calculated",
        "sample" => "Serum",
        "male_min" => 0.2,
        "male_max" => 0.8,
        "female_min" => 0.2,
        "female_max" => 0.8,
        "text" => "0.2 - 0.8 mg/dL"
      ],
      [
        "name" => "SGOT / AST",
        "unit" => "U/L",
        "method" => "IFCC without Pyridoxal Phosphate",
        "sample" => "Serum",
        "male_min" => 10,
        "male_max" => 40,
        "female_min" => 9,
        "female_max" => 32,
        "text" => "Male: 10-40 U/L, Female: 9-32 U/L"
      ],
      [
        "name" => "SGPT / ALT",
        "unit" => "U/L",
        "method" => "IFCC without Pyridoxal Phosphate",
        "sample" => "Serum",
        "male_min" => 10,
        "male_max" => 45,
        "female_min" => 7,
        "female_max" => 35,
        "text" => "Male: 10-45 U/L, Female: 7-35 U/L"
      ],
      [
        "name" => "Alkaline Phosphatase (ALP)",
        "unit" => "U/L",
        "method" => "p-NPP / AMP Buffer (IFCC)",
        "sample" => "Serum",
        "male_min" => 44,
        "male_max" => 147,
        "female_min" => 44,
        "female_max" => 147,
        "text" => "Adults: 44 - 147 U/L; Children: 100 - 350 U/L"
      ],
      [
        "name" => "Gamma Glutamyl Transferase (GGT)",
        "unit" => "U/L",
        "method" => "Enzymatic Colorimetric (IFCC)",
        "sample" => "Serum",
        "male_min" => 10,
        "male_max" => 55,
        "female_min" => 8,
        "female_max" => 38,
        "text" => "Male: 10-55 U/L, Female: 8-38 U/L"
      ],
      [
        "name" => "Total Protein",
        "unit" => "g/dL",
        "method" => "Biuret Method",
        "sample" => "Serum",
        "male_min" => 6.4,
        "male_max" => 8.3,
        "female_min" => 6.4,
        "female_max" => 8.3,
        "text" => "6.4 - 8.3 g/dL"
      ],
      [
        "name" => "Serum Albumin",
        "unit" => "g/dL",
        "method" => "Bromocresol Green (BCG)",
        "sample" => "Serum",
        "male_min" => 3.5,
        "male_max" => 5.2,
        "female_min" => 3.5,
        "female_max" => 5.2,
        "text" => "3.5 - 5.2 g/dL"
      ],
      [
        "name" => "Serum Globulin",
        "unit" => "g/dL",
        "method" => "Calculated (Total Protein - Albumin)",
        "sample" => "Serum",
        "male_min" => 2.0,
        "male_max" => 3.5,
        "female_min" => 2.0,
        "female_max" => 3.5,
        "text" => "2.0 - 3.5 g/dL"
      ],
      [
        "name" => "A/G Ratio (Albumin/Globulin)",
        "unit" => "",
        "method" => "Calculated",
        "sample" => "Serum",
        "male_min" => 1.2,
        "male_max" => 2.2,
        "female_min" => 1.2,
        "female_max" => 2.2,
        "text" => "1.2 - 2.2"
      ]
    ]
  ],
  [
    "test_id" => 29,
    "name" => "Serum Bilirubin (Total, Direct & Indirect)",
    "code" => "BILIRUBIN",
    "category_id" => 1,
    "category_name" => "Biochemistry",
    "price" => 150.0,
    "notes" => "Modified Jendrassik-Grof Diazo method",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Serum Bilirubin Clinical Interpretation:</b><br>
• <b>Predominantly Unconjugated (Indirect) Hyperbilirubinemia:</b> Hemolytic disorders (G6PD deficiency, hereditary spherocytosis, autoimmune hemolysis), neonatal jaundice, Gilbert syndrome.<br>
• <b>Predominantly Conjugated (Direct) Hyperbilirubinemia (&gt; 50% of total):</b> Extrahepatic biliary obstruction (gallstones, stricture, pancreatic tumor), intrahepatic cholestasis (viral hepatitis, drugs, sepsis).<br>
• <b>Mixed Hyperbilirubinemia:</b> Acute hepatocellular necrosis, advanced cirrhosis.</p>",
    "param_count" => 3,
    "parameters" => [
      [
        "name" => "Total Bilirubin",
        "unit" => "mg/dL",
        "method" => "Diazo / Modified Jendrassik-Grof",
        "sample" => "Serum (Fasting preferred)",
        "male_min" => 0.2,
        "male_max" => 1.2,
        "female_min" => 0.2,
        "female_max" => 1.1,
        "text" => "0.2 - 1.2 mg/dL"
      ],
      [
        "name" => "Direct Bilirubin (Conjugated)",
        "unit" => "mg/dL",
        "method" => "Diazo Method",
        "sample" => "Serum",
        "male_min" => 0.0,
        "male_max" => 0.3,
        "female_min" => 0.0,
        "female_max" => 0.3,
        "text" => "0.0 - 0.3 mg/dL"
      ],
      [
        "name" => "Indirect Bilirubin (Unconjugated)",
        "unit" => "mg/dL",
        "method" => "Calculated",
        "sample" => "Serum",
        "male_min" => 0.2,
        "male_max" => 0.8,
        "female_min" => 0.2,
        "female_max" => 0.8,
        "text" => "0.2 - 0.8 mg/dL"
      ]
    ]
  ],
  [
    "test_id" => 30,
    "name" => "SGOT / AST (Aspartate Aminotransferase)",
    "code" => "SGOT",
    "category_id" => 1,
    "category_name" => "Biochemistry",
    "price" => 120.0,
    "notes" => "IFCC without Pyridoxal Phosphate UV kinetic method",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>SGOT / AST Clinical Significance:</b> Enzyme present in liver, cardiac muscle, skeletal muscle, and kidneys.<br>
• <b>Marked Elevation (&gt; 1000 U/L):</b> Acute ischemic hepatitis, paracetamol toxicity, severe acute viral hepatitis.<br>
• <b>Moderate Elevation (100 – 500 U/L):</b> Alcoholic hepatitis (AST/ALT ratio typically &gt; 2), acute pancreatitis, skeletal muscle trauma/rhabdomyolysis, myocardial infarction.<br>
• <b>Mild Elevation (&lt; 100 U/L):</b> Chronic hepatitis, non-alcoholic fatty liver disease (NAFLD), cirrhosis.</p>",
    "param_count" => 1,
    "parameters" => [
      [
        "name" => "SGOT / AST",
        "unit" => "U/L",
        "method" => "IFCC without Pyridoxal Phosphate",
        "sample" => "Serum",
        "male_min" => 10,
        "male_max" => 40,
        "female_min" => 9,
        "female_max" => 32,
        "text" => "Male: 10-40 U/L, Female: 9-32 U/L"
      ]
    ]
  ],
  [
    "test_id" => 31,
    "name" => "SGPT / ALT (Alanine Aminotransferase)",
    "code" => "SGPT",
    "category_id" => 1,
    "category_name" => "Biochemistry",
    "price" => 120.0,
    "notes" => "IFCC kinetic method, highly liver-specific enzyme",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>SGPT / ALT Clinical Significance:</b> Highly specific marker for hepatocellular injury localized predominantly in liver parenchymal cells.<br>
• <b>Very High (&gt; 10× ULN):</b> Acute viral hepatitis (A, B, C, E), toxin/drug-induced liver damage, severe hypotension/shock liver.<br>
• <b>Mild-to-Moderate Elevation:</b> Non-Alcoholic Fatty Liver Disease (NAFLD / NASH), chronic hepatitis B/C, obesity, statin or NSAID use.</p>",
    "param_count" => 1,
    "parameters" => [
      [
        "name" => "SGPT / ALT",
        "unit" => "U/L",
        "method" => "IFCC without Pyridoxal Phosphate",
        "sample" => "Serum",
        "male_min" => 10,
        "male_max" => 45,
        "female_min" => 7,
        "female_max" => 35,
        "text" => "Male: 10-45 U/L, Female: 7-35 U/L"
      ]
    ]
  ],
  [
    "test_id" => 32,
    "name" => "Alkaline Phosphatase (ALP)",
    "code" => "ALP",
    "category_id" => 1,
    "category_name" => "Biochemistry",
    "price" => 150.0,
    "notes" => "p-NPP / AMP Buffer kinetic IFCC method",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Alkaline Phosphatase (ALP) Clinical Significance:</b> Originates primarily from bile canalicular membranes and osteoblasts.<br>
• <b>Hepatobiliary Disorders:</b> Biliary obstruction, choledocholithiasis, primary sclerosing cholangitis, drug-induced cholestasis (correlate with high GGT).<br>
• <b>Bone Pathologies (normal GGT):</b> Paget disease of bone, osteoblastic metastases, rickets/osteomalacia, healing fractures, hyperparathyroidism.<br>
<span style=\"font-size:7pt; color:#64748b;\"><i>Physiologically elevated in growing children (active bone growth) and normal 3rd trimester pregnancy (placental ALP).</i></span></p>",
    "param_count" => 1,
    "parameters" => [
      [
        "name" => "Alkaline Phosphatase (ALP)",
        "unit" => "U/L",
        "method" => "p-NPP / AMP Buffer (IFCC)",
        "sample" => "Serum",
        "male_min" => 44,
        "male_max" => 147,
        "female_min" => 44,
        "female_max" => 147,
        "text" => "Adults: 44 - 147 U/L; Children: 100 - 350 U/L"
      ]
    ]
  ],
  [
    "test_id" => 33,
    "name" => "Gamma Glutamyl Transferase (GGT)",
    "code" => "GGT",
    "category_id" => 1,
    "category_name" => "Biochemistry",
    "price" => 250.0,
    "notes" => "L-gamma-glutamyl-3-carboxy-4-nitroanilide enzymatic method",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Gamma-Glutamyl Transferase (GGT) Clinical Significance:</b> Sensitive biliary enzyme.<br>
• Confirms hepatobiliary origin of elevated Alkaline Phosphatase (ALP is high, GGT is high → liver; ALP high, GGT normal → bone).<br>
• Most sensitive biomarker for heavy or chronic alcohol ingestion and alcoholic liver injury.</p>",
    "param_count" => 1,
    "parameters" => [
      [
        "name" => "Gamma Glutamyl Transferase (GGT)",
        "unit" => "U/L",
        "method" => "Enzymatic Colorimetric (IFCC)",
        "sample" => "Serum",
        "male_min" => 10,
        "male_max" => 55,
        "female_min" => 8,
        "female_max" => 38,
        "text" => "Male: 10-55 U/L, Female: 8-38 U/L"
      ]
    ]
  ],
  [
    "test_id" => 34,
    "name" => "Total Protein with Albumin & A/G Ratio",
    "code" => "PROTEIN",
    "category_id" => 1,
    "category_name" => "Biochemistry",
    "price" => 150.0,
    "notes" => "Biuret (Total Protein) and Bromocresol Green (Albumin) with calculated Globulin & Ratio",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Total Protein, Albumin &amp; A/G Ratio Significance:</b><br>
• <b>Hypoalbuminemia (&lt; 3.5 g/dL):</b> Impaired liver synthesis (cirrhosis), renal urinary loss (nephrotic syndrome), GI loss (protein-losing enteropathy), malnutrition.<br>
• <b>Hypergammaglobulinemia / Inverted A/G Ratio (&lt; 1.0):</b> Multiple myeloma, chronic active hepatitis, cirrhosis, severe chronic systemic infections.<br>
• <b>Monoclonal Spike:</b> Serum protein electrophoresis (SPEP) recommended if Total Protein is elevated with normal Albumin.</p>",
    "param_count" => 4,
    "parameters" => [
      [
        "name" => "Total Protein",
        "unit" => "g/dL",
        "method" => "Biuret Method",
        "sample" => "Serum",
        "male_min" => 6.4,
        "male_max" => 8.3,
        "female_min" => 6.4,
        "female_max" => 8.3,
        "text" => "6.4 - 8.3 g/dL"
      ],
      [
        "name" => "Serum Albumin",
        "unit" => "g/dL",
        "method" => "Bromocresol Green (BCG)",
        "sample" => "Serum",
        "male_min" => 3.5,
        "male_max" => 5.2,
        "female_min" => 3.5,
        "female_max" => 5.2,
        "text" => "3.5 - 5.2 g/dL"
      ],
      [
        "name" => "Serum Globulin",
        "unit" => "g/dL",
        "method" => "Calculated (Total Protein - Albumin)",
        "sample" => "Serum",
        "male_min" => 2.0,
        "male_max" => 3.5,
        "female_min" => 2.0,
        "female_max" => 3.5,
        "text" => "2.0 - 3.5 g/dL"
      ],
      [
        "name" => "A/G Ratio (Albumin/Globulin)",
        "unit" => "",
        "method" => "Calculated",
        "sample" => "Serum",
        "male_min" => 1.2,
        "male_max" => 2.2,
        "female_min" => 1.2,
        "female_max" => 2.2,
        "text" => "1.2 - 2.2"
      ]
    ]
  ],
  [
    "test_id" => 35,
    "name" => "Lipid Profile (Complete)",
    "code" => "LIPID",
    "category_id" => 1,
    "category_name" => "Biochemistry",
    "price" => 500.0,
    "notes" => "Includes Total Cholesterol, HDL, LDL, Triglycerides, VLDL and Atherogenic Ratios",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Cardiovascular Risk Stratification (NCEP ATP-III / Indian Consensus Guidelines):</b></p>
<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\" style=\"border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;\">
  <tr style=\"background-color:#f1f5f9; font-weight:bold;\">
    <th style=\"width:25%; padding:2px 4px;\">Lipid Fraction</th>
    <th style=\"width:25%; padding:2px 4px;\">Optimal / Desirable</th>
    <th style=\"width:25%; padding:2px 4px;\">Borderline High</th>
    <th style=\"width:25%; padding:2px 4px;\">High Risk</th>
  </tr>
  <tr><td style=\"padding:2px 4px;\"><b>Total Cholesterol</b></td><td style=\"padding:2px 4px;\">&lt; 200 mg/dL</td><td style=\"padding:2px 4px;\">200 – 239 mg/dL</td><td style=\"padding:2px 4px;\">≥ 240 mg/dL</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>Triglycerides</b></td><td style=\"padding:2px 4px;\">&lt; 150 mg/dL</td><td style=\"padding:2px 4px;\">150 – 199 mg/dL</td><td style=\"padding:2px 4px;\">200 – 499 mg/dL (≥ 500 pancreatitis risk)</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>HDL Cholesterol (Good)</b></td><td style=\"padding:2px 4px;\">&gt; 50 mg/dL (protective)</td><td style=\"padding:2px 4px;\">40 – 50 mg/dL</td><td style=\"padding:2px 4px;\">&lt; 40 mg/dL (Major risk factor for CAD)</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>LDL Cholesterol (Bad)</b></td><td style=\"padding:2px 4px;\">&lt; 100 mg/dL (CAD: &lt; 70)</td><td style=\"padding:2px 4px;\">100 – 129 mg/dL</td><td style=\"padding:2px 4px;\">130 – 159 (Borderline), ≥ 160 mg/dL (High)</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>VLDL Cholesterol</b></td><td style=\"padding:2px 4px;\">&lt; 30 mg/dL</td><td style=\"padding:2px 4px;\">30 – 40 mg/dL</td><td style=\"padding:2px 4px;\">&gt; 40 mg/dL</td></tr>
</table>
<p style=\"margin:2px 0 0 0; font-size:7.5pt;\"><b>Ratios:</b> Total Chol / HDL ratio &lt; 3.5 is desirable (CAD risk increases &gt; 4.5). LDL / HDL ratio &lt; 2.5 is optimal.<br>
<span style=\"font-size:7pt; color:#64748b;\"><i>Requirement: 10 – 12 hours overnight fasting. If Triglycerides &gt; 400 mg/dL, calculated LDL (Friedewald) is invalid; direct LDL assay is advised.</i></span></p>",
    "param_count" => 7,
    "parameters" => [
      [
        "name" => "Total Cholesterol",
        "unit" => "mg/dL",
        "method" => "CHOD-PAP (Enzymatic)",
        "sample" => "Serum (12 hr Fasting)",
        "male_min" => 0,
        "male_max" => 200,
        "female_min" => 0,
        "female_max" => 200,
        "text" => "Desirable: <200, Borderline: 200-239, High: >=240 mg/dL"
      ],
      [
        "name" => "HDL Cholesterol (Good Cholesterol)",
        "unit" => "mg/dL",
        "method" => "Direct Enzymatic Clearance",
        "sample" => "Serum",
        "male_min" => 40,
        "male_max" => 60,
        "female_min" => 50,
        "female_max" => 70,
        "text" => "Male: >40 mg/dL, Female: >50 mg/dL, Optimal: >60 mg/dL"
      ],
      [
        "name" => "LDL Cholesterol (Bad Cholesterol)",
        "unit" => "mg/dL",
        "method" => "Direct Enzymatic / Friedewald",
        "sample" => "Serum",
        "male_min" => 0,
        "male_max" => 100,
        "female_min" => 0,
        "female_max" => 100,
        "text" => "Optimal: <100, Near Optimal: 100-129, Borderline: 130-159, High: >=160 mg/dL"
      ],
      [
        "name" => "Serum Triglycerides",
        "unit" => "mg/dL",
        "method" => "GPO-PAP (Enzymatic)",
        "sample" => "Serum (12 hr Fasting)",
        "male_min" => 0,
        "male_max" => 150,
        "female_min" => 0,
        "female_max" => 150,
        "text" => "Normal: <150, Borderline: 150-199, High: 200-499, Very High: >=500 mg/dL"
      ],
      [
        "name" => "VLDL Cholesterol",
        "unit" => "mg/dL",
        "method" => "Calculated (Triglycerides / 5)",
        "sample" => "Serum",
        "male_min" => 5,
        "male_max" => 30,
        "female_min" => 5,
        "female_max" => 30,
        "text" => "5.0 - 30.0 mg/dL"
      ],
      [
        "name" => "Total Chol / HDL Ratio",
        "unit" => "",
        "method" => "Calculated",
        "sample" => "Serum",
        "male_min" => 3.0,
        "male_max" => 5.0,
        "female_min" => 3.0,
        "female_max" => 4.5,
        "text" => "Desirable: 3.0 - 5.0"
      ],
      [
        "name" => "LDL / HDL Ratio",
        "unit" => "",
        "method" => "Calculated",
        "sample" => "Serum",
        "male_min" => 1.5,
        "male_max" => 3.5,
        "female_min" => 1.5,
        "female_max" => 3.0,
        "text" => "Desirable: 1.5 - 3.5"
      ]
    ]
  ],
  [
    "test_id" => 36,
    "name" => "Serum Cholesterol (Total)",
    "code" => "CHOL",
    "category_id" => 1,
    "category_name" => "Biochemistry",
    "price" => 120.0,
    "notes" => "Enzymatic CHOD-PAP method after 10-12 hour fast",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Cardiovascular Risk Stratification (NCEP ATP-III / Indian Consensus Guidelines):</b></p>
<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\" style=\"border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;\">
  <tr style=\"background-color:#f1f5f9; font-weight:bold;\">
    <th style=\"width:25%; padding:2px 4px;\">Lipid Fraction</th>
    <th style=\"width:25%; padding:2px 4px;\">Optimal / Desirable</th>
    <th style=\"width:25%; padding:2px 4px;\">Borderline High</th>
    <th style=\"width:25%; padding:2px 4px;\">High Risk</th>
  </tr>
  <tr><td style=\"padding:2px 4px;\"><b>Total Cholesterol</b></td><td style=\"padding:2px 4px;\">&lt; 200 mg/dL</td><td style=\"padding:2px 4px;\">200 – 239 mg/dL</td><td style=\"padding:2px 4px;\">≥ 240 mg/dL</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>Triglycerides</b></td><td style=\"padding:2px 4px;\">&lt; 150 mg/dL</td><td style=\"padding:2px 4px;\">150 – 199 mg/dL</td><td style=\"padding:2px 4px;\">200 – 499 mg/dL (≥ 500 pancreatitis risk)</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>HDL Cholesterol (Good)</b></td><td style=\"padding:2px 4px;\">&gt; 50 mg/dL (protective)</td><td style=\"padding:2px 4px;\">40 – 50 mg/dL</td><td style=\"padding:2px 4px;\">&lt; 40 mg/dL (Major risk factor for CAD)</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>LDL Cholesterol (Bad)</b></td><td style=\"padding:2px 4px;\">&lt; 100 mg/dL (CAD: &lt; 70)</td><td style=\"padding:2px 4px;\">100 – 129 mg/dL</td><td style=\"padding:2px 4px;\">130 – 159 (Borderline), ≥ 160 mg/dL (High)</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>VLDL Cholesterol</b></td><td style=\"padding:2px 4px;\">&lt; 30 mg/dL</td><td style=\"padding:2px 4px;\">30 – 40 mg/dL</td><td style=\"padding:2px 4px;\">&gt; 40 mg/dL</td></tr>
</table>
<p style=\"margin:2px 0 0 0; font-size:7.5pt;\"><b>Ratios:</b> Total Chol / HDL ratio &lt; 3.5 is desirable (CAD risk increases &gt; 4.5). LDL / HDL ratio &lt; 2.5 is optimal.<br>
<span style=\"font-size:7pt; color:#64748b;\"><i>Requirement: 10 – 12 hours overnight fasting. If Triglycerides &gt; 400 mg/dL, calculated LDL (Friedewald) is invalid; direct LDL assay is advised.</i></span></p>",
    "param_count" => 1,
    "parameters" => [
      [
        "name" => "Total Cholesterol",
        "unit" => "mg/dL",
        "method" => "CHOD-PAP (Enzymatic)",
        "sample" => "Serum (12 hr Fasting)",
        "male_min" => 0,
        "male_max" => 200,
        "female_min" => 0,
        "female_max" => 200,
        "text" => "Desirable: <200, Borderline: 200-239, High: >=240 mg/dL"
      ]
    ]
  ],
  [
    "test_id" => 37,
    "name" => "Serum Triglycerides",
    "code" => "TRIG",
    "category_id" => 1,
    "category_name" => "Biochemistry",
    "price" => 150.0,
    "notes" => "Enzymatic GPO-PAP method after 12 hour fast",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Cardiovascular Risk Stratification (NCEP ATP-III / Indian Consensus Guidelines):</b></p>
<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\" style=\"border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;\">
  <tr style=\"background-color:#f1f5f9; font-weight:bold;\">
    <th style=\"width:25%; padding:2px 4px;\">Lipid Fraction</th>
    <th style=\"width:25%; padding:2px 4px;\">Optimal / Desirable</th>
    <th style=\"width:25%; padding:2px 4px;\">Borderline High</th>
    <th style=\"width:25%; padding:2px 4px;\">High Risk</th>
  </tr>
  <tr><td style=\"padding:2px 4px;\"><b>Total Cholesterol</b></td><td style=\"padding:2px 4px;\">&lt; 200 mg/dL</td><td style=\"padding:2px 4px;\">200 – 239 mg/dL</td><td style=\"padding:2px 4px;\">≥ 240 mg/dL</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>Triglycerides</b></td><td style=\"padding:2px 4px;\">&lt; 150 mg/dL</td><td style=\"padding:2px 4px;\">150 – 199 mg/dL</td><td style=\"padding:2px 4px;\">200 – 499 mg/dL (≥ 500 pancreatitis risk)</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>HDL Cholesterol (Good)</b></td><td style=\"padding:2px 4px;\">&gt; 50 mg/dL (protective)</td><td style=\"padding:2px 4px;\">40 – 50 mg/dL</td><td style=\"padding:2px 4px;\">&lt; 40 mg/dL (Major risk factor for CAD)</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>LDL Cholesterol (Bad)</b></td><td style=\"padding:2px 4px;\">&lt; 100 mg/dL (CAD: &lt; 70)</td><td style=\"padding:2px 4px;\">100 – 129 mg/dL</td><td style=\"padding:2px 4px;\">130 – 159 (Borderline), ≥ 160 mg/dL (High)</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>VLDL Cholesterol</b></td><td style=\"padding:2px 4px;\">&lt; 30 mg/dL</td><td style=\"padding:2px 4px;\">30 – 40 mg/dL</td><td style=\"padding:2px 4px;\">&gt; 40 mg/dL</td></tr>
</table>
<p style=\"margin:2px 0 0 0; font-size:7.5pt;\"><b>Ratios:</b> Total Chol / HDL ratio &lt; 3.5 is desirable (CAD risk increases &gt; 4.5). LDL / HDL ratio &lt; 2.5 is optimal.<br>
<span style=\"font-size:7pt; color:#64748b;\"><i>Requirement: 10 – 12 hours overnight fasting. If Triglycerides &gt; 400 mg/dL, calculated LDL (Friedewald) is invalid; direct LDL assay is advised.</i></span></p>",
    "param_count" => 1,
    "parameters" => [
      [
        "name" => "Serum Triglycerides",
        "unit" => "mg/dL",
        "method" => "GPO-PAP (Enzymatic)",
        "sample" => "Serum (12 hr Fasting)",
        "male_min" => 0,
        "male_max" => 150,
        "female_min" => 0,
        "female_max" => 150,
        "text" => "Normal: <150, Borderline: 150-199, High: 200-499, Very High: >=500 mg/dL"
      ]
    ]
  ],
  [
    "test_id" => 38,
    "name" => "HDL Cholesterol (Good Cholesterol)",
    "code" => "HDL",
    "category_id" => 1,
    "category_name" => "Biochemistry",
    "price" => 150.0,
    "notes" => "Direct Immunoinhibition / Enzymatic clearance method",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Cardiovascular Risk Stratification (NCEP ATP-III / Indian Consensus Guidelines):</b></p>
<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\" style=\"border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;\">
  <tr style=\"background-color:#f1f5f9; font-weight:bold;\">
    <th style=\"width:25%; padding:2px 4px;\">Lipid Fraction</th>
    <th style=\"width:25%; padding:2px 4px;\">Optimal / Desirable</th>
    <th style=\"width:25%; padding:2px 4px;\">Borderline High</th>
    <th style=\"width:25%; padding:2px 4px;\">High Risk</th>
  </tr>
  <tr><td style=\"padding:2px 4px;\"><b>Total Cholesterol</b></td><td style=\"padding:2px 4px;\">&lt; 200 mg/dL</td><td style=\"padding:2px 4px;\">200 – 239 mg/dL</td><td style=\"padding:2px 4px;\">≥ 240 mg/dL</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>Triglycerides</b></td><td style=\"padding:2px 4px;\">&lt; 150 mg/dL</td><td style=\"padding:2px 4px;\">150 – 199 mg/dL</td><td style=\"padding:2px 4px;\">200 – 499 mg/dL (≥ 500 pancreatitis risk)</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>HDL Cholesterol (Good)</b></td><td style=\"padding:2px 4px;\">&gt; 50 mg/dL (protective)</td><td style=\"padding:2px 4px;\">40 – 50 mg/dL</td><td style=\"padding:2px 4px;\">&lt; 40 mg/dL (Major risk factor for CAD)</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>LDL Cholesterol (Bad)</b></td><td style=\"padding:2px 4px;\">&lt; 100 mg/dL (CAD: &lt; 70)</td><td style=\"padding:2px 4px;\">100 – 129 mg/dL</td><td style=\"padding:2px 4px;\">130 – 159 (Borderline), ≥ 160 mg/dL (High)</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>VLDL Cholesterol</b></td><td style=\"padding:2px 4px;\">&lt; 30 mg/dL</td><td style=\"padding:2px 4px;\">30 – 40 mg/dL</td><td style=\"padding:2px 4px;\">&gt; 40 mg/dL</td></tr>
</table>
<p style=\"margin:2px 0 0 0; font-size:7.5pt;\"><b>Ratios:</b> Total Chol / HDL ratio &lt; 3.5 is desirable (CAD risk increases &gt; 4.5). LDL / HDL ratio &lt; 2.5 is optimal.<br>
<span style=\"font-size:7pt; color:#64748b;\"><i>Requirement: 10 – 12 hours overnight fasting. If Triglycerides &gt; 400 mg/dL, calculated LDL (Friedewald) is invalid; direct LDL assay is advised.</i></span></p>",
    "param_count" => 1,
    "parameters" => [
      [
        "name" => "HDL Cholesterol (Good Cholesterol)",
        "unit" => "mg/dL",
        "method" => "Direct Enzymatic Clearance",
        "sample" => "Serum",
        "male_min" => 40,
        "male_max" => 60,
        "female_min" => 50,
        "female_max" => 70,
        "text" => "Male: >40 mg/dL, Female: >50 mg/dL, Optimal: >60 mg/dL"
      ]
    ]
  ],
  [
    "test_id" => 39,
    "name" => "LDL Cholesterol (Bad Cholesterol)",
    "code" => "LDL",
    "category_id" => 1,
    "category_name" => "Biochemistry",
    "price" => 150.0,
    "notes" => "Direct Enzymatic / Friedewald calculated",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Cardiovascular Risk Stratification (NCEP ATP-III / Indian Consensus Guidelines):</b></p>
<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\" style=\"border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;\">
  <tr style=\"background-color:#f1f5f9; font-weight:bold;\">
    <th style=\"width:25%; padding:2px 4px;\">Lipid Fraction</th>
    <th style=\"width:25%; padding:2px 4px;\">Optimal / Desirable</th>
    <th style=\"width:25%; padding:2px 4px;\">Borderline High</th>
    <th style=\"width:25%; padding:2px 4px;\">High Risk</th>
  </tr>
  <tr><td style=\"padding:2px 4px;\"><b>Total Cholesterol</b></td><td style=\"padding:2px 4px;\">&lt; 200 mg/dL</td><td style=\"padding:2px 4px;\">200 – 239 mg/dL</td><td style=\"padding:2px 4px;\">≥ 240 mg/dL</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>Triglycerides</b></td><td style=\"padding:2px 4px;\">&lt; 150 mg/dL</td><td style=\"padding:2px 4px;\">150 – 199 mg/dL</td><td style=\"padding:2px 4px;\">200 – 499 mg/dL (≥ 500 pancreatitis risk)</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>HDL Cholesterol (Good)</b></td><td style=\"padding:2px 4px;\">&gt; 50 mg/dL (protective)</td><td style=\"padding:2px 4px;\">40 – 50 mg/dL</td><td style=\"padding:2px 4px;\">&lt; 40 mg/dL (Major risk factor for CAD)</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>LDL Cholesterol (Bad)</b></td><td style=\"padding:2px 4px;\">&lt; 100 mg/dL (CAD: &lt; 70)</td><td style=\"padding:2px 4px;\">100 – 129 mg/dL</td><td style=\"padding:2px 4px;\">130 – 159 (Borderline), ≥ 160 mg/dL (High)</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>VLDL Cholesterol</b></td><td style=\"padding:2px 4px;\">&lt; 30 mg/dL</td><td style=\"padding:2px 4px;\">30 – 40 mg/dL</td><td style=\"padding:2px 4px;\">&gt; 40 mg/dL</td></tr>
</table>
<p style=\"margin:2px 0 0 0; font-size:7.5pt;\"><b>Ratios:</b> Total Chol / HDL ratio &lt; 3.5 is desirable (CAD risk increases &gt; 4.5). LDL / HDL ratio &lt; 2.5 is optimal.<br>
<span style=\"font-size:7pt; color:#64748b;\"><i>Requirement: 10 – 12 hours overnight fasting. If Triglycerides &gt; 400 mg/dL, calculated LDL (Friedewald) is invalid; direct LDL assay is advised.</i></span></p>",
    "param_count" => 1,
    "parameters" => [
      [
        "name" => "LDL Cholesterol (Bad Cholesterol)",
        "unit" => "mg/dL",
        "method" => "Direct Enzymatic / Friedewald",
        "sample" => "Serum",
        "male_min" => 0,
        "male_max" => 100,
        "female_min" => 0,
        "female_max" => 100,
        "text" => "Optimal: <100, Near Optimal: 100-129, Borderline: 130-159, High: >=160 mg/dL"
      ]
    ]
  ],
  [
    "test_id" => 40,
    "name" => "Serum Electrolytes (Na+, K+, Cl-)",
    "code" => "ELEC",
    "category_id" => 1,
    "category_name" => "Biochemistry",
    "price" => 350.0,
    "notes" => "Direct Ion Selective Electrode (ISE) method",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Serum Electrolytes Interpretation:</b></p>
<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\" style=\"border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;\">
  <tr style=\"background-color:#f1f5f9; font-weight:bold;\">
    <th style=\"width:25%; padding:2px 4px;\">Electrolyte</th>
    <th style=\"width:25%; padding:2px 4px;\">Reference Range</th>
    <th style=\"width:50%; padding:2px 4px;\">Clinical Significance of Abnormal Values</th>
  </tr>
  <tr>
    <td style=\"padding:2px 4px;\"><b>Sodium (Na+)</b></td>
    <td style=\"padding:2px 4px;\">136 – 145 mmol/L</td>
    <td style=\"padding:2px 4px;\"><b>Hyponatremia (&lt; 135):</b> SIADH, diuretic excess, cirrhosis, heart failure, Addison disease.<br><b>Hypernatremia (&gt; 145):</b> Dehydration, diabetes insipidus, excessive saline infusion.</td>
  </tr>
  <tr>
    <td style=\"padding:2px 4px;\"><b>Potassium (K+)</b></td>
    <td style=\"padding:2px 4px;\">3.5 – 5.1 mmol/L</td>
    <td style=\"padding:2px 4px;\"><b>Hypokalemia (&lt; 3.5):</b> Diuretics, vomiting, diarrhea; risk of cardiac arrhythmias.<br><b>Hyperkalemia (&gt; 5.5):</b> Renal failure, ACE inhibitors, acidosis; critical risk of fatal cardiac arrest.</td>
  </tr>
  <tr>
    <td style=\"padding:2px 4px;\"><b>Chloride (Cl-)</b></td>
    <td style=\"padding:2px 4px;\">98 – 107 mmol/L</td>
    <td style=\"padding:2px 4px;\">Assists in acid-base balance and serum anion gap calculation.</td>
  </tr>
</table>
<p style=\"font-size:7pt; color:#64748b; margin:2px 0 0 0;\"><i>Critical Alert: Mild hemolysis in sample artificially raises potassium markedly (pseudohyperkalemia); repeat sample required if hemolyzed.</i></p>",
    "param_count" => 3,
    "parameters" => [
      [
        "name" => "Serum Sodium (Na+)",
        "unit" => "mEq/L",
        "method" => "Direct ISE",
        "sample" => "Serum",
        "male_min" => 135,
        "male_max" => 145,
        "female_min" => 135,
        "female_max" => 145,
        "text" => "135.0 - 145.0 mEq/L"
      ],
      [
        "name" => "Serum Potassium (K+)",
        "unit" => "mEq/L",
        "method" => "Direct ISE",
        "sample" => "Serum (Non-hemolyzed)",
        "male_min" => 3.5,
        "male_max" => 5.1,
        "female_min" => 3.5,
        "female_max" => 5.1,
        "text" => "3.5 - 5.1 mEq/L"
      ],
      [
        "name" => "Serum Chloride (Cl-)",
        "unit" => "mEq/L",
        "method" => "Direct ISE",
        "sample" => "Serum",
        "male_min" => 96,
        "male_max" => 106,
        "female_min" => 96,
        "female_max" => 106,
        "text" => "96.0 - 106.0 mEq/L"
      ]
    ]
  ],
  [
    "test_id" => 41,
    "name" => "Serum Sodium (Na+)",
    "code" => "NA",
    "category_id" => 1,
    "category_name" => "Biochemistry",
    "price" => 150.0,
    "notes" => "Direct ISE method",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Serum Electrolytes Interpretation:</b></p>
<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\" style=\"border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;\">
  <tr style=\"background-color:#f1f5f9; font-weight:bold;\">
    <th style=\"width:25%; padding:2px 4px;\">Electrolyte</th>
    <th style=\"width:25%; padding:2px 4px;\">Reference Range</th>
    <th style=\"width:50%; padding:2px 4px;\">Clinical Significance of Abnormal Values</th>
  </tr>
  <tr>
    <td style=\"padding:2px 4px;\"><b>Sodium (Na+)</b></td>
    <td style=\"padding:2px 4px;\">136 – 145 mmol/L</td>
    <td style=\"padding:2px 4px;\"><b>Hyponatremia (&lt; 135):</b> SIADH, diuretic excess, cirrhosis, heart failure, Addison disease.<br><b>Hypernatremia (&gt; 145):</b> Dehydration, diabetes insipidus, excessive saline infusion.</td>
  </tr>
  <tr>
    <td style=\"padding:2px 4px;\"><b>Potassium (K+)</b></td>
    <td style=\"padding:2px 4px;\">3.5 – 5.1 mmol/L</td>
    <td style=\"padding:2px 4px;\"><b>Hypokalemia (&lt; 3.5):</b> Diuretics, vomiting, diarrhea; risk of cardiac arrhythmias.<br><b>Hyperkalemia (&gt; 5.5):</b> Renal failure, ACE inhibitors, acidosis; critical risk of fatal cardiac arrest.</td>
  </tr>
  <tr>
    <td style=\"padding:2px 4px;\"><b>Chloride (Cl-)</b></td>
    <td style=\"padding:2px 4px;\">98 – 107 mmol/L</td>
    <td style=\"padding:2px 4px;\">Assists in acid-base balance and serum anion gap calculation.</td>
  </tr>
</table>
<p style=\"font-size:7pt; color:#64748b; margin:2px 0 0 0;\"><i>Critical Alert: Mild hemolysis in sample artificially raises potassium markedly (pseudohyperkalemia); repeat sample required if hemolyzed.</i></p>",
    "param_count" => 1,
    "parameters" => [
      [
        "name" => "Serum Sodium (Na+)",
        "unit" => "mEq/L",
        "method" => "Direct ISE",
        "sample" => "Serum",
        "male_min" => 135,
        "male_max" => 145,
        "female_min" => 135,
        "female_max" => 145,
        "text" => "135.0 - 145.0 mEq/L"
      ]
    ]
  ],
  [
    "test_id" => 42,
    "name" => "Serum Potassium (K+)",
    "code" => "K",
    "category_id" => 1,
    "category_name" => "Biochemistry",
    "price" => 150.0,
    "notes" => "Direct ISE method",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Serum Electrolytes Interpretation:</b></p>
<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\" style=\"border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;\">
  <tr style=\"background-color:#f1f5f9; font-weight:bold;\">
    <th style=\"width:25%; padding:2px 4px;\">Electrolyte</th>
    <th style=\"width:25%; padding:2px 4px;\">Reference Range</th>
    <th style=\"width:50%; padding:2px 4px;\">Clinical Significance of Abnormal Values</th>
  </tr>
  <tr>
    <td style=\"padding:2px 4px;\"><b>Sodium (Na+)</b></td>
    <td style=\"padding:2px 4px;\">136 – 145 mmol/L</td>
    <td style=\"padding:2px 4px;\"><b>Hyponatremia (&lt; 135):</b> SIADH, diuretic excess, cirrhosis, heart failure, Addison disease.<br><b>Hypernatremia (&gt; 145):</b> Dehydration, diabetes insipidus, excessive saline infusion.</td>
  </tr>
  <tr>
    <td style=\"padding:2px 4px;\"><b>Potassium (K+)</b></td>
    <td style=\"padding:2px 4px;\">3.5 – 5.1 mmol/L</td>
    <td style=\"padding:2px 4px;\"><b>Hypokalemia (&lt; 3.5):</b> Diuretics, vomiting, diarrhea; risk of cardiac arrhythmias.<br><b>Hyperkalemia (&gt; 5.5):</b> Renal failure, ACE inhibitors, acidosis; critical risk of fatal cardiac arrest.</td>
  </tr>
  <tr>
    <td style=\"padding:2px 4px;\"><b>Chloride (Cl-)</b></td>
    <td style=\"padding:2px 4px;\">98 – 107 mmol/L</td>
    <td style=\"padding:2px 4px;\">Assists in acid-base balance and serum anion gap calculation.</td>
  </tr>
</table>
<p style=\"font-size:7pt; color:#64748b; margin:2px 0 0 0;\"><i>Critical Alert: Mild hemolysis in sample artificially raises potassium markedly (pseudohyperkalemia); repeat sample required if hemolyzed.</i></p>",
    "param_count" => 1,
    "parameters" => [
      [
        "name" => "Serum Potassium (K+)",
        "unit" => "mEq/L",
        "method" => "Direct ISE",
        "sample" => "Serum (Non-hemolyzed)",
        "male_min" => 3.5,
        "male_max" => 5.1,
        "female_min" => 3.5,
        "female_max" => 5.1,
        "text" => "3.5 - 5.1 mEq/L"
      ]
    ]
  ],
  [
    "test_id" => 43,
    "name" => "Serum Calcium",
    "code" => "CALC",
    "category_id" => 1,
    "category_name" => "Biochemistry",
    "price" => 120.0,
    "notes" => "Arsenazo III photometric method",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Serum Calcium Clinical Interpretation:</b> Essential for bone mineral density, neuromuscular excitability, and cardiac contraction.<br>
• <b>Hypercalcemia (&gt; 10.5 mg/dL):</b> Primary hyperparathyroidism, osteolytic malignancy/metastases, multiple myeloma, vitamin D intoxication, sarcoidosis.<br>
• <b>Hypocalcemia (&lt; 8.5 mg/dL):</b> Hypoparathyroidism, vitamin D deficiency, chronic renal failure, acute pancreatitis, malabsorption.<br>
<span style=\"font-size:7pt; color:#64748b;\"><i>Corrected Calcium Formula: Corrected Ca = Measured Total Ca + 0.8 × (4.0 – Serum Albumin in g/dL).</i></span></p>",
    "param_count" => 1,
    "parameters" => [
      [
        "name" => "Serum Calcium",
        "unit" => "mg/dL",
        "method" => "Arsenazo III",
        "sample" => "Serum",
        "male_min" => 8.5,
        "male_max" => 10.5,
        "female_min" => 8.5,
        "female_max" => 10.5,
        "text" => "8.5 - 10.5 mg/dL"
      ]
    ]
  ],
  [
    "test_id" => 44,
    "name" => "Serum Phosphorus",
    "code" => "PHOS",
    "category_id" => 1,
    "category_name" => "Biochemistry",
    "price" => 120.0,
    "notes" => "Phosphomolybdate UV method",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Serum Phosphorus Clinical Interpretation:</b> Evaluates calcium-phosphate homeostasis and parathyroid function.<br>
• <b>Hyperphosphatemia (&gt; 4.5 mg/dL):</b> Chronic renal failure (reduced excretion), hypoparathyroidism, tumor lysis syndrome, excessive vitamin D.<br>
• <b>Hypophosphatemia (&lt; 2.5 mg/dL):</b> Primary hyperparathyroidism, vitamin D deficiency (rickets/osteomalacia), refeeding syndrome, diabetic ketoacidosis recovery.</p>",
    "param_count" => 1,
    "parameters" => [
      [
        "name" => "Serum Phosphorus",
        "unit" => "mg/dL",
        "method" => "Phosphomolybdate UV",
        "sample" => "Serum",
        "male_min" => 2.5,
        "male_max" => 4.5,
        "female_min" => 2.5,
        "female_max" => 4.5,
        "text" => "Adults: 2.5 - 4.5 mg/dL, Children: 4.0 - 6.5 mg/dL"
      ]
    ]
  ],
  [
    "test_id" => 45,
    "name" => "Serum Calcium & Phosphorus",
    "code" => "CALPHOS",
    "category_id" => 1,
    "category_name" => "Biochemistry",
    "price" => 220.0,
    "notes" => "Combined photometric determination",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Serum Calcium Clinical Interpretation:</b> Essential for bone mineral density, neuromuscular excitability, and cardiac contraction.<br>
• <b>Hypercalcemia (&gt; 10.5 mg/dL):</b> Primary hyperparathyroidism, osteolytic malignancy/metastases, multiple myeloma, vitamin D intoxication, sarcoidosis.<br>
• <b>Hypocalcemia (&lt; 8.5 mg/dL):</b> Hypoparathyroidism, vitamin D deficiency, chronic renal failure, acute pancreatitis, malabsorption.<br>
<span style=\"font-size:7pt; color:#64748b;\"><i>Corrected Calcium Formula: Corrected Ca = Measured Total Ca + 0.8 × (4.0 – Serum Albumin in g/dL).</i></span></p><br><p style=\"margin:2px 0;\"><b>Serum Phosphorus Clinical Interpretation:</b> Evaluates calcium-phosphate homeostasis and parathyroid function.<br>
• <b>Hyperphosphatemia (&gt; 4.5 mg/dL):</b> Chronic renal failure (reduced excretion), hypoparathyroidism, tumor lysis syndrome, excessive vitamin D.<br>
• <b>Hypophosphatemia (&lt; 2.5 mg/dL):</b> Primary hyperparathyroidism, vitamin D deficiency (rickets/osteomalacia), refeeding syndrome, diabetic ketoacidosis recovery.</p>",
    "param_count" => 2,
    "parameters" => [
      [
        "name" => "Serum Calcium",
        "unit" => "mg/dL",
        "method" => "Arsenazo III",
        "sample" => "Serum",
        "male_min" => 8.5,
        "male_max" => 10.5,
        "female_min" => 8.5,
        "female_max" => 10.5,
        "text" => "8.5 - 10.5 mg/dL"
      ],
      [
        "name" => "Serum Phosphorus",
        "unit" => "mg/dL",
        "method" => "Phosphomolybdate UV",
        "sample" => "Serum",
        "male_min" => 2.5,
        "male_max" => 4.5,
        "female_min" => 2.5,
        "female_max" => 4.5,
        "text" => "Adults: 2.5 - 4.5 mg/dL, Children: 4.0 - 6.5 mg/dL"
      ]
    ]
  ],
  [
    "test_id" => 46,
    "name" => "Serum Amylase",
    "code" => "AMYLASE",
    "category_id" => 1,
    "category_name" => "Biochemistry",
    "price" => 350.0,
    "notes" => "Enzymatic photometric CNPG3 method",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Serum Amylase &amp; Lipase Interpretation:</b><br>
• <b>Acute Pancreatitis:</b> Levels typically rise &gt; 3 times the upper reference limit within 6–12 hours. Serum Lipase remains elevated longer (7–14 days) and has superior clinical specificity (95–99%) compared to Amylase.<br>
• <b>Other Causes of High Amylase:</b> Salivary gland disease (mumps, parotitis), acute cholecystitis, intestinal ischemia, perforated peptic ulcer, diabetic ketoacidosis, renal failure (decreased clearance).</p>",
    "param_count" => 1,
    "parameters" => [
      [
        "name" => "Serum Amylase",
        "unit" => "U/L",
        "method" => "Enzymatic CNPG3",
        "sample" => "Serum",
        "male_min" => 28,
        "male_max" => 100,
        "female_min" => 28,
        "female_max" => 100,
        "text" => "Normal: 28 - 100 U/L"
      ]
    ]
  ],
  [
    "test_id" => 47,
    "name" => "Serum Lipase",
    "code" => "LIPASE",
    "category_id" => 1,
    "category_name" => "Biochemistry",
    "price" => 400.0,
    "notes" => "Enzymatic colorimetric method",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Serum Amylase &amp; Lipase Interpretation:</b><br>
• <b>Acute Pancreatitis:</b> Levels typically rise &gt; 3 times the upper reference limit within 6–12 hours. Serum Lipase remains elevated longer (7–14 days) and has superior clinical specificity (95–99%) compared to Amylase.<br>
• <b>Other Causes of High Amylase:</b> Salivary gland disease (mumps, parotitis), acute cholecystitis, intestinal ischemia, perforated peptic ulcer, diabetic ketoacidosis, renal failure (decreased clearance).</p>",
    "param_count" => 1,
    "parameters" => [
      [
        "name" => "Serum Lipase",
        "unit" => "U/L",
        "method" => "Enzymatic Colorimetric",
        "sample" => "Serum",
        "male_min" => 13,
        "male_max" => 60,
        "female_min" => 13,
        "female_max" => 60,
        "text" => "Normal: 13 - 60 U/L"
      ]
    ]
  ],
  [
    "test_id" => 48,
    "name" => "Creatine Kinase / CPK (Total)",
    "code" => "CPK",
    "category_id" => 1,
    "category_name" => "Biochemistry",
    "price" => 350.0,
    "notes" => "NAC-activated UV kinetic IFCC method",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Total Creatine Kinase (CPK) Interpretation:</b><br>
• <b>Striated Muscle Injury / Rhabdomyolysis:</b> Marked elevation (often 10× to 100× ULN) following crush injury, severe trauma, prolonged immobilization, statin myopathy, or vigorous unaccustomed exercise.<br>
• <b>Myocardial Infarction:</b> CPK rises within 4–6 hours, peaks at 24 hours, and returns to baseline in 48–72 hours.<br>
• <b>Neuromuscular Disorders:</b> Duchenne muscular dystrophy, polymyositis, dermatomyositis.</p>",
    "param_count" => 1,
    "parameters" => [
      [
        "name" => "Creatine Kinase / CPK (Total)",
        "unit" => "U/L",
        "method" => "IFCC / NAC-activated",
        "sample" => "Serum",
        "male_min" => 39,
        "male_max" => 308,
        "female_min" => 26,
        "female_max" => 192,
        "text" => "Male: 39 - 308 U/L, Female: 26 - 192 U/L"
      ]
    ]
  ],
  [
    "test_id" => 49,
    "name" => "CK-MB (Cardiac Isoenzyme)",
    "code" => "CKMB",
    "category_id" => 1,
    "category_name" => "Biochemistry",
    "price" => 450.0,
    "notes" => "Immunoinhibition enzymatic kinetic assay",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>CK-MB (Cardiac Isoenzyme) Clinical Interpretation:</b><br>
• Highly specific for myocardial necrosis. Rises 3 to 6 hours after acute coronary occlusion, peaks at 12–24 hours, and normalizes within 48–72 hours.<br>
• A CK-MB Relative Index (CK-MB / Total CPK × 100) &gt; 3.0% strongly indicates myocardial necrosis rather than skeletal muscle trauma.<br>
• Useful for detecting early re-infarction due to its rapid clearance.</p>",
    "param_count" => 1,
    "parameters" => [
      [
        "name" => "CK-MB (Mass / Activity)",
        "unit" => "U/L",
        "method" => "Immunoinhibition / IFCC",
        "sample" => "Serum",
        "male_min" => 0,
        "male_max" => 24,
        "female_min" => 0,
        "female_max" => 24,
        "text" => "Normal: 0 - 24 U/L (CK-MB index > 2.5-3% suggestive of MI)"
      ]
    ]
  ],
  [
    "test_id" => 50,
    "name" => "Troponin-I (Quantitative)",
    "code" => "TROP-I",
    "category_id" => 1,
    "category_name" => "Biochemistry",
    "price" => 600.0,
    "notes" => "Chemiluminescent / High-Sensitivity Fluorescence Immunoassay",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Cardiac Troponin-I (High Sensitivity) Clinical Significance:</b></p>
<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\" style=\"border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;\">
  <tr style=\"background-color:#f1f5f9; font-weight:bold;\">
    <th style=\"width:30%; padding:2px 4px;\">Troponin-I Level</th>
    <th style=\"width:35%; padding:2px 4px;\">Diagnostic Classification</th>
    <th style=\"width:35%; padding:2px 4px;\">Clinical Management Recommendation</th>
  </tr>
  <tr><td style=\"padding:2px 4px;\"><b>&lt; 99th Percentile URL</b></td><td style=\"padding:2px 4px;\">Normal (Myocardial necrosis unlikely)</td><td style=\"padding:2px 4px;\">Repeat after 2–3 hours if acute chest pain started &lt; 3 hours ago</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>Elevated with Dynamic Rise/Fall</b></td><td style=\"padding:2px 4px;\"><b>Acute Myocardial Infarction (AMI)</b></td><td style=\"padding:2px 4px;\">Immediate cardiology evaluation, coronary angiography / intervention</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>Chronically Elevated (Stable)</b></td><td style=\"padding:2px 4px;\">Non-AMI Myocardial Strain</td><td style=\"padding:2px 4px;\">Heart failure, pulmonary embolism, myocarditis, severe sepsis, chronic renal failure</td></tr>
</table>",
    "param_count" => 1,
    "parameters" => [
      [
        "name" => "Troponin-I (Quantitative)",
        "unit" => "ng/mL",
        "method" => "CLIA / Fluorescence Immunoassay",
        "sample" => "Serum / Heparin Plasma",
        "male_min" => 0.0,
        "male_max" => 0.04,
        "female_min" => 0.0,
        "female_max" => 0.04,
        "text" => "Normal: < 0.04 ng/mL (Negative / Non-ischemic)"
      ]
    ]
  ],
  [
    "test_id" => 51,
    "name" => "Serum Iron Profile (Iron, TIBC, % Saturation)",
    "code" => "IRON-PROF",
    "category_id" => 1,
    "category_name" => "Biochemistry",
    "price" => 600.0,
    "notes" => "Ferrozine and direct spectrophotometric assay",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Iron Profile Differential Diagnostic Guidelines:</b></p>
<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\" style=\"border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;\">
  <tr style=\"background-color:#f1f5f9; font-weight:bold;\">
    <th style=\"width:25%; padding:2px 4px;\">Condition</th>
    <th style=\"width:18%; padding:2px 4px;\">Serum Iron</th>
    <th style=\"width:18%; padding:2px 4px;\">TIBC</th>
    <th style=\"width:18%; padding:2px 4px;\">Transferrin Sat.</th>
    <th style=\"width:21%; padding:2px 4px;\">Serum Ferritin</th>
  </tr>
  <tr>
    <td style=\"padding:2px 4px;\"><b>Iron Deficiency Anemia</b></td>
    <td style=\"padding:2px 4px;\">Decreased (&lt; 50)</td>
    <td style=\"padding:2px 4px;\"><b>Elevated (&gt; 400)</b></td>
    <td style=\"padding:2px 4px;\"><b>Low (&lt; 15%)</b></td>
    <td style=\"padding:2px 4px;\"><b>Very Low (&lt; 15 ng/mL)</b></td>
  </tr>
  <tr>
    <td style=\"padding:2px 4px;\"><b>Anemia of Chronic Disease</b></td>
    <td style=\"padding:2px 4px;\">Decreased</td>
    <td style=\"padding:2px 4px;\">Decreased / Normal</td>
    <td style=\"padding:2px 4px;\">Normal / Low</td>
    <td style=\"padding:2px 4px;\"><b>Normal or High (acute reactant)</b></td>
  </tr>
  <tr>
    <td style=\"padding:2px 4px;\"><b>Thalassemia Minor Trait</b></td>
    <td style=\"padding:2px 4px;\">Normal / High</td>
    <td style=\"padding:2px 4px;\">Normal</td>
    <td style=\"padding:2px 4px;\">Normal</td>
    <td style=\"padding:2px 4px;\">Normal / High (HbA2 &gt; 3.5%)</td>
  </tr>
  <tr>
    <td style=\"padding:2px 4px;\"><b>Hemochromatosis (Iron Overload)</b></td>
    <td style=\"padding:2px 4px;\"><b>Very High</b></td>
    <td style=\"padding:2px 4px;\">Low / Normal</td>
    <td style=\"padding:2px 4px;\"><b>&gt; 50% (High risk)</b></td>
    <td style=\"padding:2px 4px;\"><b>Markedly High (&gt; 1000 ng/mL)</b></td>
  </tr>
</table>",
    "param_count" => 3,
    "parameters" => [
      [
        "name" => "Serum Iron",
        "unit" => "\u00b5g/dL",
        "method" => "Ferrozine / Nitro-PAPS",
        "sample" => "Serum (Morning sample)",
        "male_min" => 60,
        "male_max" => 170,
        "female_min" => 50,
        "female_max" => 160,
        "text" => "Male: 60 - 170 \u00b5g/dL, Female: 50 - 160 \u00b5g/dL"
      ],
      [
        "name" => "Total Iron Binding Capacity (TIBC)",
        "unit" => "\u00b5g/dL",
        "method" => "Direct Spectrophotometric",
        "sample" => "Serum",
        "male_min" => 250,
        "male_max" => 450,
        "female_min" => 250,
        "female_max" => 450,
        "text" => "Normal: 250 - 450 \u00b5g/dL"
      ],
      [
        "name" => "Transferrin Saturation",
        "unit" => "%",
        "method" => "Calculated (Serum Iron / TIBC * 100)",
        "sample" => "Serum",
        "male_min" => 20,
        "male_max" => 50,
        "female_min" => 15,
        "female_max" => 50,
        "text" => "Normal: 20 - 50 % (< 16% indicates iron deficiency)"
      ]
    ]
  ],
  [
    "test_id" => 52,
    "name" => "Serum Iron",
    "code" => "IRON",
    "category_id" => 1,
    "category_name" => "Biochemistry",
    "price" => 250.0,
    "notes" => "Colorimetric Ferrozine method",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Iron Profile Differential Diagnostic Guidelines:</b></p>
<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\" style=\"border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;\">
  <tr style=\"background-color:#f1f5f9; font-weight:bold;\">
    <th style=\"width:25%; padding:2px 4px;\">Condition</th>
    <th style=\"width:18%; padding:2px 4px;\">Serum Iron</th>
    <th style=\"width:18%; padding:2px 4px;\">TIBC</th>
    <th style=\"width:18%; padding:2px 4px;\">Transferrin Sat.</th>
    <th style=\"width:21%; padding:2px 4px;\">Serum Ferritin</th>
  </tr>
  <tr>
    <td style=\"padding:2px 4px;\"><b>Iron Deficiency Anemia</b></td>
    <td style=\"padding:2px 4px;\">Decreased (&lt; 50)</td>
    <td style=\"padding:2px 4px;\"><b>Elevated (&gt; 400)</b></td>
    <td style=\"padding:2px 4px;\"><b>Low (&lt; 15%)</b></td>
    <td style=\"padding:2px 4px;\"><b>Very Low (&lt; 15 ng/mL)</b></td>
  </tr>
  <tr>
    <td style=\"padding:2px 4px;\"><b>Anemia of Chronic Disease</b></td>
    <td style=\"padding:2px 4px;\">Decreased</td>
    <td style=\"padding:2px 4px;\">Decreased / Normal</td>
    <td style=\"padding:2px 4px;\">Normal / Low</td>
    <td style=\"padding:2px 4px;\"><b>Normal or High (acute reactant)</b></td>
  </tr>
  <tr>
    <td style=\"padding:2px 4px;\"><b>Thalassemia Minor Trait</b></td>
    <td style=\"padding:2px 4px;\">Normal / High</td>
    <td style=\"padding:2px 4px;\">Normal</td>
    <td style=\"padding:2px 4px;\">Normal</td>
    <td style=\"padding:2px 4px;\">Normal / High (HbA2 &gt; 3.5%)</td>
  </tr>
  <tr>
    <td style=\"padding:2px 4px;\"><b>Hemochromatosis (Iron Overload)</b></td>
    <td style=\"padding:2px 4px;\"><b>Very High</b></td>
    <td style=\"padding:2px 4px;\">Low / Normal</td>
    <td style=\"padding:2px 4px;\"><b>&gt; 50% (High risk)</b></td>
    <td style=\"padding:2px 4px;\"><b>Markedly High (&gt; 1000 ng/mL)</b></td>
  </tr>
</table>",
    "param_count" => 1,
    "parameters" => [
      [
        "name" => "Serum Iron",
        "unit" => "\u00b5g/dL",
        "method" => "Ferrozine / Nitro-PAPS",
        "sample" => "Serum (Morning sample)",
        "male_min" => 60,
        "male_max" => 170,
        "female_min" => 50,
        "female_max" => 160,
        "text" => "Male: 60 - 170 \u00b5g/dL, Female: 50 - 160 \u00b5g/dL"
      ]
    ]
  ],
  [
    "test_id" => 53,
    "name" => "Widal Agglutination Test (Typhoid)",
    "code" => "WIDAL",
    "category_id" => 3,
    "category_name" => "Serology & Immunology",
    "price" => 150.0,
    "notes" => "Slide and Tube agglutination with S. typhi O, H and S. paratyphi AH, BH antigens",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Widal Agglutination Test (Typhoid Serodiagnosis):</b></p>
<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\" style=\"border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;\">
  <tr style=\"background-color:#f1f5f9; font-weight:bold;\">
    <th style=\"width:25%; padding:2px 4px;\">Antigen Marker</th>
    <th style=\"width:30%; padding:2px 4px;\">Indian Endemic Baseline Titer</th>
    <th style=\"width:45%; padding:2px 4px;\">Diagnostic Significant Titer (Active Infection)</th>
  </tr>
  <tr><td style=\"padding:2px 4px;\"><b>S. typhi 'O' (Somatic)</b></td><td style=\"padding:2px 4px;\">Up to 1:80</td><td style=\"padding:2px 4px;\"><b>≥ 1:160</b> (Suggests acute ongoing infection)</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>S. typhi 'H' (Flagellar)</b></td><td style=\"padding:2px 4px;\">Up to 1:80</td><td style=\"padding:2px 4px;\"><b>≥ 1:160</b> (Past infection, late stage, or TAB vaccination)</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>S. paratyphi 'AH'</b></td><td style=\"padding:2px 4px;\">Up to 1:40</td><td style=\"padding:2px 4px;\"><b>≥ 1:80</b> (Suggestive of Paratyphoid A fever)</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>S. paratyphi 'BH'</b></td><td style=\"padding:2px 4px;\">Up to 1:40</td><td style=\"padding:2px 4px;\"><b>≥ 1:80</b> (Suggestive of Paratyphoid B fever)</td></tr>
</table>
<p style=\"margin:2px 0 0 0; font-size:7.5pt;\"><b>Clinical Guidelines:</b><br>
1. A single high titer (≥ 1:160 for O and H) along with step-ladder fever, headache, relative bradycardia, and toxic facies is clinically suggestive of Enteric fever.<br>
2. A <b>4-fold rise in paired serum titers</b> collected 7–10 days apart provides definitive confirmation.<br>
<span style=\"font-size:7pt; color:#64748b;\"><i>Limitations: False-positive agglutination can occur in malaria, typhus, chronic liver disease, or previous typhoid immunization (anamnestic reaction). Blood culture is the gold standard during the 1st week of fever.</i></span></p>",
    "param_count" => 4,
    "parameters" => [
      [
        "name" => "S. typhi \"O\" Titer",
        "unit" => "",
        "method" => "Slide / Tube Agglutination",
        "sample" => "Serum",
        "male_min" => 0,
        "male_max" => 0,
        "female_min" => 0,
        "female_max" => 0,
        "text" => "Negative (< 1:80)"
      ],
      [
        "name" => "S. typhi \"H\" Titer",
        "unit" => "",
        "method" => "Slide / Tube Agglutination",
        "sample" => "Serum",
        "male_min" => 0,
        "male_max" => 0,
        "female_min" => 0,
        "female_max" => 0,
        "text" => "Negative (< 1:80)"
      ],
      [
        "name" => "S. paratyphi \"AH\" Titer",
        "unit" => "",
        "method" => "Slide / Tube Agglutination",
        "sample" => "Serum",
        "male_min" => 0,
        "male_max" => 0,
        "female_min" => 0,
        "female_max" => 0,
        "text" => "Negative (< 1:80)"
      ],
      [
        "name" => "S. paratyphi \"BH\" Titer",
        "unit" => "",
        "method" => "Slide / Tube Agglutination",
        "sample" => "Serum",
        "male_min" => 0,
        "male_max" => 0,
        "female_min" => 0,
        "female_max" => 0,
        "text" => "Negative (< 1:80)"
      ]
    ]
  ],
  [
    "test_id" => 54,
    "name" => "Typhoid IgM & IgG Antibodies (Typhidot)",
    "code" => "TYPHIDOT",
    "category_id" => 3,
    "category_name" => "Serology & Immunology",
    "price" => 300.0,
    "notes" => "Rapid immunochromatographic differential assay",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Typhidot (IgM &amp; IgG) Serology Interpretation:</b></p>
<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\" style=\"border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;\">
  <tr style=\"background-color:#f1f5f9; font-weight:bold;\">
    <th style=\"width:25%; padding:2px 4px;\">Typhoid IgM</th>
    <th style=\"width:25%; padding:2px 4px;\">Typhoid IgG</th>
    <th style=\"width:50%; padding:2px 4px;\">Clinical Significance</th>
  </tr>
  <tr><td style=\"padding:2px 4px;\"><b>Positive</b></td><td style=\"padding:2px 4px;\">Negative</td><td style=\"padding:2px 4px;\"><b>Acute Enteric (Typhoid) Fever:</b> Detectable as early as Day 2 to 3 of fever.</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>Positive</b></td><td style=\"padding:2px 4px;\"><b>Positive</b></td><td style=\"padding:2px 4px;\"><b>Acute / Subacute Infection:</b> Middle-to-late phase of acute typhoid or re-infection.</td></tr>
  <tr><td style=\"padding:2px 4px;\">Negative</td><td style=\"padding:2px 4px;\"><b>Positive</b></td><td style=\"padding:2px 4px;\"><b>Past Typhoid Infection</b> or carrier status; does not indicate acute active fever.</td></tr>
  <tr><td style=\"padding:2px 4px;\">Negative</td><td style=\"padding:2px 4px;\">Negative</td><td style=\"padding:2px 4px;\">Enteric fever unlikely; repeat in 48–72 hours if high clinical suspicion persists.</td></tr>
</table>",
    "param_count" => 2,
    "parameters" => [
      [
        "name" => "Typhoid IgM Antibody (Typhidot)",
        "unit" => "",
        "method" => "Rapid Immunochromatography",
        "sample" => "Serum",
        "male_min" => 0,
        "male_max" => 0,
        "female_min" => 0,
        "female_max" => 0,
        "text" => "Negative / Non-Reactive"
      ],
      [
        "name" => "Typhoid IgG Antibody (Typhidot)",
        "unit" => "",
        "method" => "Rapid Immunochromatography",
        "sample" => "Serum",
        "male_min" => 0,
        "male_max" => 0,
        "female_min" => 0,
        "female_max" => 0,
        "text" => "Negative / Non-Reactive"
      ]
    ]
  ],
  [
    "test_id" => 55,
    "name" => "Malaria Antigen Detection (Rapid Card Pf / Pv)",
    "code" => "MAL-CARD",
    "category_id" => 3,
    "category_name" => "Serology & Immunology",
    "price" => 200.0,
    "notes" => "Rapid Card immunochromatography for HRP-2 (Pf) and pLDH (Pv/Pan)",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Malaria Rapid Antigen Test (Card) Interpretation:</b><br>
• <b>Pan / Pv-pLDH Positive:</b> Suggests *Plasmodium vivax* (or *P. malariae / P. ovale*) infection.<br>
• <b>Pf HRP-2 Positive:</b> Indicates *Plasmodium falciparum* infection (high risk for cerebral malaria, acute renal failure, severe anemia). Requires immediate emergency antimalarial therapy.<br>
• <b>Both Pf and Pv Positive:</b> Mixed malarial infection.<br>
<span style=\"font-size:7pt; color:#64748b;\"><i>Note: Pf HRP-2 antigen can persist in circulating blood for up to 2 to 4 weeks following successful parasite clearance. Correlate with peripheral blood smear microscopy.</i></span></p>",
    "param_count" => 1,
    "parameters" => [
      [
        "name" => "Malaria Parasite Antigen (Pf / Pv)",
        "unit" => "",
        "method" => "Rapid Antigen Card (HRP-2 & pLDH)",
        "sample" => "Whole Blood EDTA",
        "male_min" => 0,
        "male_max" => 0,
        "female_min" => 0,
        "female_max" => 0,
        "text" => "Negative / Not Detected"
      ]
    ]
  ],
  [
    "test_id" => 56,
    "name" => "Malaria Parasite Detection (Card & Smear)",
    "code" => "MALARIA",
    "category_id" => 3,
    "category_name" => "Serology & Immunology",
    "price" => 250.0,
    "notes" => "Combines Rapid Antigen Card (Pf/Pv) and Giemsa stained peripheral smear examination",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Malaria Rapid Antigen Test (Card) Interpretation:</b><br>
• <b>Pan / Pv-pLDH Positive:</b> Suggests *Plasmodium vivax* (or *P. malariae / P. ovale*) infection.<br>
• <b>Pf HRP-2 Positive:</b> Indicates *Plasmodium falciparum* infection (high risk for cerebral malaria, acute renal failure, severe anemia). Requires immediate emergency antimalarial therapy.<br>
• <b>Both Pf and Pv Positive:</b> Mixed malarial infection.<br>
<span style=\"font-size:7pt; color:#64748b;\"><i>Note: Pf HRP-2 antigen can persist in circulating blood for up to 2 to 4 weeks following successful parasite clearance. Correlate with peripheral blood smear microscopy.</i></span></p>
<p style=\"margin:3px 0 0 0;\"><b>Microscopic Smear Confirmation:</b> Examination of Giemsa-stained thick and thin blood films remains the clinical gold standard for species identification (P. vivax vs P. falciparum), parasite life-cycle staging (ring forms, trophozoites, schizonts, gametocytes), and parasitemia quantification.</p>",
    "param_count" => 2,
    "parameters" => [
      [
        "name" => "Malaria Parasite Antigen (Pf / Pv)",
        "unit" => "",
        "method" => "Rapid Antigen Card (HRP-2 & pLDH)",
        "sample" => "Whole Blood EDTA",
        "male_min" => 0,
        "male_max" => 0,
        "female_min" => 0,
        "female_max" => 0,
        "text" => "Negative / Not Detected"
      ],
      [
        "name" => "Peripheral Blood Smear for MP",
        "unit" => "",
        "method" => "Giemsa Stained Smear Microscopy",
        "sample" => "Whole Blood EDTA",
        "male_min" => 0,
        "male_max" => 0,
        "female_min" => 0,
        "female_max" => 0,
        "text" => "No Malarial Parasite Seen"
      ]
    ]
  ],
  [
    "test_id" => 57,
    "name" => "Dengue NS1 Antigen (Early Dengue)",
    "code" => "DENG-NS1",
    "category_id" => 3,
    "category_name" => "Serology & Immunology",
    "price" => 400.0,
    "notes" => "Rapid immunochromatographic assay for Dengue NS1 glycoprotein",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Dengue NS1 Antigen Clinical Significance:</b><br>
• <b>Early Detection Window:</b> Highly sensitive during <b>Day 1 to Day 5</b> of fever onset (viremic phase) before detectable IgM antibodies develop.<br>
• <b>Positive:</b> Confirms acute primary or secondary Dengue viral infection.<br>
• <b>Negative:</b> Does not exclude Dengue if tested after Day 5 of fever; Dengue IgM/IgG serology testing is indicated.</p>",
    "param_count" => 1,
    "parameters" => [
      [
        "name" => "Dengue NS1 Antigen",
        "unit" => "",
        "method" => "Immunochromatography (Early Dengue)",
        "sample" => "Serum",
        "male_min" => 0,
        "male_max" => 0,
        "female_min" => 0,
        "female_max" => 0,
        "text" => "Negative / Non-Reactive"
      ]
    ]
  ],
  [
    "test_id" => 58,
    "name" => "Dengue Antibodies (IgM & IgG)",
    "code" => "DENG-AB",
    "category_id" => 3,
    "category_name" => "Serology & Immunology",
    "price" => 400.0,
    "notes" => "Differential immunochromatographic detection of Dengue IgM and IgG",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Dengue Antibodies (IgM &amp; IgG) Clinical Interpretation:</b><br>
• <b>Dengue IgM:</b> Appears by Day 4 to 5 of fever, peaks at Day 14, and persists for 2 to 3 months. Indicates current or recent Dengue infection.<br>
• <b>Dengue IgG:</b> In primary infection, appears slowly after Day 10 and persists for life. In secondary infection, rises rapidly to very high levels within 1–2 days of fever.<br>
• <b>Secondary Dengue Alert:</b> Positive IgG in early fever (with or without IgM) flags secondary infection, associated with higher risk of Dengue Hemorrhagic Fever (DHF) and Dengue Shock Syndrome (DSS).</p>",
    "param_count" => 1,
    "parameters" => [
      [
        "name" => "Dengue IgM & IgG Antibodies",
        "unit" => "",
        "method" => "Immunochromatography (Late/Secondary Dengue)",
        "sample" => "Serum",
        "male_min" => 0,
        "male_max" => 0,
        "female_min" => 0,
        "female_max" => 0,
        "text" => "Negative / Non-Reactive"
      ]
    ]
  ],
  [
    "test_id" => 59,
    "name" => "Dengue Serology (NS1 Ag, IgM, IgG)",
    "code" => "DENGUE",
    "category_id" => 3,
    "category_name" => "Serology & Immunology",
    "price" => 600.0,
    "notes" => "Comprehensive combo testing for NS1 Antigen, IgM and IgG antibodies",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Comprehensive Dengue Serology Staging Guide:</b></p>
<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\" style=\"border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;\">
  <tr style=\"background-color:#f1f5f9; font-weight:bold;\">
    <th style=\"width:20%; padding:2px 4px;\">NS1 Antigen</th>
    <th style=\"width:18%; padding:2px 4px;\">IgM Antibody</th>
    <th style=\"width:18%; padding:2px 4px;\">IgG Antibody</th>
    <th style=\"width:44%; padding:2px 4px;\">Clinical Staging &amp; Interpretation</th>
  </tr>
  <tr><td style=\"padding:2px 4px;\"><b>Reactive</b></td><td style=\"padding:2px 4px;\">Non-reactive</td><td style=\"padding:2px 4px;\">Non-reactive</td><td style=\"padding:2px 4px;\"><b>Early Acute Primary Dengue</b> (Day 1 – 4 of fever onset)</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>Reactive</b></td><td style=\"padding:2px 4px;\"><b>Reactive</b></td><td style=\"padding:2px 4px;\">Non-reactive</td><td style=\"padding:2px 4px;\"><b>Acute Primary Dengue</b> (Day 4 – 7 of fever)</td></tr>
  <tr><td style=\"padding:2px 4px;\">Non-reactive</td><td style=\"padding:2px 4px;\"><b>Reactive</b></td><td style=\"padding:2px 4px;\">Non-reactive</td><td style=\"padding:2px 4px;\"><b>Late Acute / Convalescent Primary Dengue</b> (&gt; Day 5)</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>Reactive</b> / Non-react</td><td style=\"padding:2px 4px;\"><b>Reactive</b></td><td style=\"padding:2px 4px;\"><b>Reactive</b></td><td style=\"padding:2px 4px;\"><b>Acute Secondary Dengue</b> (High risk for plasma leakage / DHF; monitor platelets &amp; hematocrit)</td></tr>
  <tr><td style=\"padding:2px 4px;\">Non-reactive</td><td style=\"padding:2px 4px;\">Non-reactive</td><td style=\"padding:2px 4px;\"><b>Reactive</b></td><td style=\"padding:2px 4px;\"><b>Past Dengue Infection</b> (Distant immunity; no evidence of acute dengue)</td></tr>
</table>",
    "param_count" => 2,
    "parameters" => [
      [
        "name" => "Dengue NS1 Antigen",
        "unit" => "",
        "method" => "Immunochromatography (Early Dengue)",
        "sample" => "Serum",
        "male_min" => 0,
        "male_max" => 0,
        "female_min" => 0,
        "female_max" => 0,
        "text" => "Negative / Non-Reactive"
      ],
      [
        "name" => "Dengue IgM & IgG Antibodies",
        "unit" => "",
        "method" => "Immunochromatography (Late/Secondary Dengue)",
        "sample" => "Serum",
        "male_min" => 0,
        "male_max" => 0,
        "female_min" => 0,
        "female_max" => 0,
        "text" => "Negative / Non-Reactive"
      ]
    ]
  ],
  [
    "test_id" => 60,
    "name" => "Chikungunya IgM Rapid Card",
    "code" => "CHIK-IGM",
    "category_id" => 3,
    "category_name" => "Serology & Immunology",
    "price" => 400.0,
    "notes" => "Immunochromatographic qualitative detection of Chikungunya virus IgM antibodies",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Chikungunya IgM Serology Interpretation:</b><br>
• Detectable from Day 4 to 5 after onset of fever with debilitating polyarthralgia.<br>
• <b>Positive:</b> Confirms acute or recent Chikungunya viral infection.<br>
• <b>Negative:</b> Does not rule out infection if sample taken &lt; 4 days from symptom onset; repeat testing in 7 days recommended if severe symmetrical joint pain persists.</p>",
    "param_count" => 1,
    "parameters" => [
      [
        "name" => "Chikungunya IgM Rapid",
        "unit" => "",
        "method" => "Immunochromatography",
        "sample" => "Serum",
        "male_min" => 0,
        "male_max" => 0,
        "female_min" => 0,
        "female_max" => 0,
        "text" => "Negative / Non-Reactive"
      ]
    ]
  ],
  [
    "test_id" => 61,
    "name" => "C-Reactive Protein (CRP, Quantitative)",
    "code" => "CRP",
    "category_id" => 3,
    "category_name" => "Serology & Immunology",
    "price" => 250.0,
    "notes" => "Immunoturbidimetric quantitative determination",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>C-Reactive Protein (CRP, Quantitative) Clinical Significance:</b> Prototypic acute-phase reactant synthesized by hepatocytes under IL-6 stimulation.<br>
• <b>&lt; 6.0 mg/L:</b> Normal / Baseline level.<br>
• <b>10 – 40 mg/L:</b> Mild/moderate systemic inflammation (viral infections, mild arthritis, localized tissue injury).<br>
• <b>&gt; 50 – 100 mg/L:</b> Severe acute bacterial infection, deep sepsis, pneumonia, active systemic vasculitis, acute pancreatitis.<br>
• Useful for monitoring antibiotic response and infection resolution (rapid drop matches clinical recovery).</p>",
    "param_count" => 1,
    "parameters" => [
      [
        "name" => "C-Reactive Protein (CRP, Quantitative)",
        "unit" => "mg/L",
        "method" => "Turbidimetry / Immunoturbidimetric",
        "sample" => "Serum",
        "male_min" => 0,
        "male_max" => 6.0,
        "female_min" => 0,
        "female_max" => 6.0,
        "text" => "< 6.0 mg/L (Normal)"
      ]
    ]
  ],
  [
    "test_id" => 62,
    "name" => "High Sensitivity CRP (hs-CRP)",
    "code" => "HS-CRP",
    "category_id" => 3,
    "category_name" => "Serology & Immunology",
    "price" => 450.0,
    "notes" => "High-sensitivity particle-enhanced turbidimetry",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>High Sensitivity CRP (hs-CRP) Cardiovascular Risk Assessment (AHA / CDC Guidelines):</b></p>
<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\" style=\"border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;\">
  <tr style=\"background-color:#f1f5f9; font-weight:bold;\">
    <th style=\"width:35%; padding:2px 4px;\">hs-CRP Level (mg/L)</th>
    <th style=\"width:35%; padding:2px 4px;\">Relative 10-Year Cardiovascular Risk</th>
    <th style=\"width:30%; padding:2px 4px;\">Clinical Interpretation</th>
  </tr>
  <tr><td style=\"padding:2px 4px;\"><b>&lt; 1.0 mg/L</b></td><td style=\"padding:2px 4px;\">Low Risk</td><td style=\"padding:2px 4px;\">Minimal baseline vascular inflammation</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>1.0 – 3.0 mg/L</b></td><td style=\"padding:2px 4px;\">Average / Moderate Risk</td><td style=\"padding:2px 4px;\">Intermediate vascular risk</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>&gt; 3.0 mg/L</b></td><td style=\"padding:2px 4px;\">High Relative Risk</td><td style=\"padding:2px 4px;\">Elevated coronary heart disease risk</td></tr>
</table>
<p style=\"font-size:7pt; color:#64748b; margin:2px 0 0 0;\"><i>Note: If hs-CRP &gt; 10 mg/L, acute intercurrent infection or trauma should be ruled out; repeat in 2 weeks in stable metabolic state.</i></p>",
    "param_count" => 1,
    "parameters" => [
      [
        "name" => "High Sensitivity CRP (hs-CRP)",
        "unit" => "mg/L",
        "method" => "High-Sensitivity Turbidimetry",
        "sample" => "Serum",
        "male_min" => 0,
        "male_max" => 1.0,
        "female_min" => 0,
        "female_max" => 1.0,
        "text" => "Low Risk: <1.0 mg/L, Average Risk: 1.0-3.0 mg/L, High Risk: >3.0 mg/L"
      ]
    ]
  ],
  [
    "test_id" => 63,
    "name" => "Rheumatoid Factor (RA / RF)",
    "code" => "RA-FACTOR",
    "category_id" => 3,
    "category_name" => "Serology & Immunology",
    "price" => 250.0,
    "notes" => "Latex Turbidimetry / Quantitative slide agglutination",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Rheumatoid Factor (RF) Clinical Interpretation:</b> Autoantibody (predominantly IgM) directed against the Fc fragment of human IgG.<br>
• <b>Positive (&gt; 20 IU/mL):</b> Present in 70–80% of adult patients with Rheumatoid Arthritis (RA). Higher titers correlate with erosive joint disease, subcutaneous nodules, and extra-articular manifestations.<br>
• <b>Other Causes of Positive RF:</b> Sjögren syndrome (75–90%), SLE, systemic sclerosis, chronic hepatitis C, active tuberculosis, leprosy, subacute bacterial endocarditis, healthy elderly (5%).<br>
• <b>Anti-CCP Antibody:</b> Recommended for higher diagnostic specificity (&gt; 96%) in early rheumatoid arthritis.</p>",
    "param_count" => 1,
    "parameters" => [
      [
        "name" => "Rheumatoid Factor (RA / RF)",
        "unit" => "IU/mL",
        "method" => "Latex Turbidimetry / Agglutination",
        "sample" => "Serum",
        "male_min" => 0,
        "male_max" => 20.0,
        "female_min" => 0,
        "female_max" => 20.0,
        "text" => "Negative: < 20.0 IU/mL; Positive: >= 20.0 IU/mL"
      ]
    ]
  ],
  [
    "test_id" => 64,
    "name" => "ASO Titre (Anti-Streptolysin O)",
    "code" => "ASO",
    "category_id" => 3,
    "category_name" => "Serology & Immunology",
    "price" => 300.0,
    "notes" => "Quantitative latex turbidimetric assay",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Anti-Streptolysin O (ASO) Titre Interpretation:</b> Detects neutralizing antibodies to streptolysin O toxin produced by Group A beta-hemolytic *Streptococcus pyogenes*.<br>
• <b>Titre &gt; 200 IU/mL:</b> Confirms antecedent streptococcal pharyngeal infection.<br>
• Crucial supportive diagnostic criterion for Acute Rheumatic Fever (Jones Criteria) and Post-Streptococcal Acute Glomerulonephritis (PSAGN).<br>
<span style=\"font-size:7pt; color:#64748b;\"><i>Note: A single elevated titer indicates past exposure within 2–6 months; a rising or falling serial titer is clinically more significant.</i></span></p>",
    "param_count" => 1,
    "parameters" => [
      [
        "name" => "ASO Titre (Anti-Streptolysin O)",
        "unit" => "IU/mL",
        "method" => "Latex Turbidimetry",
        "sample" => "Serum",
        "male_min" => 0,
        "male_max" => 200,
        "female_min" => 0,
        "female_max" => 200,
        "text" => "Adults: < 200 IU/mL, Children: < 150 IU/mL"
      ]
    ]
  ],
  [
    "test_id" => 65,
    "name" => "HIV I & II Antibody Screening",
    "code" => "HIV",
    "category_id" => 3,
    "category_name" => "Serology & Immunology",
    "price" => 300.0,
    "notes" => "Rapid 3rd/4th generation immunochromatographic assay",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>HIV I &amp; II Antibody Screening:</b><br>
• <b>Non-Reactive:</b> No antibodies to HIV-1 or HIV-2 detected. Does not rule out infection during the early \"window period\" (first 2 to 4 weeks post-exposure).<br>
• <b>Reactive:</b> Initial screening test reactive. As per NACO / WHO guidelines, a reactive screening result must be confirmed by three different test principles / kits or Western Blot / HIV-1 RNA PCR before issuing a positive diagnostic report. Confidential post-test counseling is advised.</p>",
    "param_count" => 1,
    "parameters" => [
      [
        "name" => "HIV I & II Antibody Screening",
        "unit" => "",
        "method" => "Immunochromatography (3rd/4th Gen)",
        "sample" => "Serum / Plasma",
        "male_min" => 0,
        "male_max" => 0,
        "female_min" => 0,
        "female_max" => 0,
        "text" => "Non-Reactive"
      ]
    ]
  ],
  [
    "test_id" => 66,
    "name" => "HBsAg (Hepatitis B Surface Antigen)",
    "code" => "HBSAG",
    "category_id" => 3,
    "category_name" => "Serology & Immunology",
    "price" => 250.0,
    "notes" => "Rapid immunochromatographic card / ELISA test",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Hepatitis B Surface Antigen (HBsAg) Interpretation:</b><br>
• <b>Non-Reactive:</b> No active circulating Hepatitis B surface antigen detected.<br>
• <b>Reactive:</b> Confirms active Hepatitis B viral infection (acute or chronic hepatitis B carrier state).<br>
• <b>Further Workup:</b> HBeAg, Anti-HBe, Anti-HBc IgM (to differentiate acute vs chronic), HBV DNA quantitative viral load by real-time PCR, and Liver Function Tests.</p>",
    "param_count" => 1,
    "parameters" => [
      [
        "name" => "HBsAg (Hepatitis B Surface Antigen)",
        "unit" => "",
        "method" => "Immunochromatography / Rapid Card",
        "sample" => "Serum",
        "male_min" => 0,
        "male_max" => 0,
        "female_min" => 0,
        "female_max" => 0,
        "text" => "Non-Reactive"
      ]
    ]
  ],
  [
    "test_id" => 67,
    "name" => "Anti-HCV Antibody (Hepatitis C)",
    "code" => "HCV",
    "category_id" => 3,
    "category_name" => "Serology & Immunology",
    "price" => 350.0,
    "notes" => "Rapid immunochromatography for Hepatitis C viral antibodies",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Anti-HCV Antibody Screening:</b><br>
• <b>Non-Reactive:</b> No detectable antibodies to Hepatitis C virus.<br>
• <b>Reactive:</b> Indicates current active infection, chronic hepatitis C, or resolved past infection.<br>
• <b>Next Step:</b> Quantitative HCV RNA Real-Time PCR testing is mandatory to confirm active viral replication prior to direct-acting antiviral (DAA) therapy.</p>",
    "param_count" => 1,
    "parameters" => [
      [
        "name" => "Anti-HCV Antibody",
        "unit" => "",
        "method" => "Immunochromatography",
        "sample" => "Serum",
        "male_min" => 0,
        "male_max" => 0,
        "female_min" => 0,
        "female_max" => 0,
        "text" => "Non-Reactive"
      ]
    ]
  ],
  [
    "test_id" => 68,
    "name" => "VDRL / RPR Syphilis Screen",
    "code" => "VDRL",
    "category_id" => 3,
    "category_name" => "Serology & Immunology",
    "price" => 150.0,
    "notes" => "Non-treponemal carbon antigen flocculation test",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>VDRL / RPR Syphilis Screen Interpretation:</b> Non-treponemal flocculation test measuring anti-cardiolipin antibodies.<br>
• <b>Non-Reactive:</b> Seronegative for active syphilis. (May be non-reactive in very early primary chancre or late tertiary syphilis).<br>
• <b>Reactive:</b> Suggestive of active or treated *Treponema pallidum* (syphilis) infection. Reported with quantitative endpoint titer (e.g., 1:8, 1:16). A four-fold change in titer evaluates treatment response.<br>
• <b>Biological False Positives:</b> Can occur in pregnancy, autoimmune lupus (APLA), malaria, leprosy, viral hepatitis, and advanced age. Specific treponemal confirmation (TPHA / FTA-ABS) recommended.</p>",
    "param_count" => 1,
    "parameters" => [
      [
        "name" => "VDRL / RPR Syphilis Screen",
        "unit" => "",
        "method" => "Flocculation / Carbon Antigen",
        "sample" => "Serum",
        "male_min" => 0,
        "male_max" => 0,
        "female_min" => 0,
        "female_max" => 0,
        "text" => "Non-Reactive"
      ]
    ]
  ],
  [
    "test_id" => 69,
    "name" => "Serum Ferritin",
    "code" => "FERRITIN",
    "category_id" => 1,
    "category_name" => "Biochemistry",
    "price" => 400.0,
    "notes" => "Chemiluminescent Immunoassay (CLIA)",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Serum Ferritin Clinical Significance:</b> Primary intracellular iron storage protein; directly proportional to total bone marrow iron stores.<br>
• <b>Ferritin &lt; 15 – 20 ng/mL:</b> Definitive confirmation of true Iron Deficiency Anemia (most sensitive biomarker).<br>
• <b>Ferritin &gt; 500 – 1000 ng/mL:</b> Acute phase reactant elevated in systemic hyperinflammation (COVID-19 cytokine storm, Macrophage Activation Syndrome / HLH, adult-onset Still disease, severe sepsis, chronic hemodialysis, and hemochromatosis/transfusional iron overload).</p>",
    "param_count" => 1,
    "parameters" => [
      [
        "name" => "Serum Ferritin",
        "unit" => "ng/mL",
        "method" => "CLIA",
        "sample" => "Serum",
        "male_min" => 20,
        "male_max" => 250,
        "female_min" => 10,
        "female_max" => 120,
        "text" => "Male: 20 - 250 ng/mL, Female: 10 - 120 ng/mL"
      ]
    ]
  ],
  [
    "test_id" => 70,
    "name" => "Total Serum IgE (Allergy Marker)",
    "code" => "IGE",
    "category_id" => 3,
    "category_name" => "Serology & Immunology",
    "price" => 500.0,
    "notes" => "CLIA / Turbidimetric quantitative assay",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Total Serum IgE Interpretation:</b><br>
• <b>Elevated (&gt; 100 – 150 IU/mL):</b> Atopic allergic disorders (extrinsic bronchial asthma, allergic rhinitis, atopic eczema), parasitic helminthic infections (Ascaris, Echinococcus), allergic bronchopulmonary aspergillosis (ABPA), hyper-IgE syndrome.<br>
• Allergen-specific IgE blood panel or skin prick testing advised to identify specific offending environmental or food allergens.</p>",
    "param_count" => 1,
    "parameters" => [
      [
        "name" => "Total Serum IgE",
        "unit" => "IU/mL",
        "method" => "CLIA / Turbidimetry",
        "sample" => "Serum",
        "male_min" => 0,
        "male_max" => 100,
        "female_min" => 0,
        "female_max" => 100,
        "text" => "Adults: < 100 IU/mL, Children: < 60 IU/mL"
      ]
    ]
  ],
  [
    "test_id" => 71,
    "name" => "Thyroid Profile (Total T3, Total T4, TSH)",
    "code" => "TFT",
    "category_id" => 6,
    "category_name" => "Endocrinology & Vitamins",
    "price" => 400.0,
    "notes" => "Quantitative assessment of primary thyroid hormones by CLIA",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Thyroid Function Test Hormonal Correlation Matrix:</b></p>
<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\" style=\"border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;\">
  <tr style=\"background-color:#f1f5f9; font-weight:bold;\">
    <th style=\"width:28%; padding:2px 4px;\">Clinical Thyroid State</th>
    <th style=\"width:24%; padding:2px 4px;\">Serum TSH</th>
    <th style=\"width:24%; padding:2px 4px;\">Free T3 / Total T3</th>
    <th style=\"width:24%; padding:2px 4px;\">Free T4 / Total T4</th>
  </tr>
  <tr><td style=\"padding:2px 4px;\"><b>Euthyroid (Normal)</b></td><td style=\"padding:2px 4px;\">Normal (0.35 – 4.94)</td><td style=\"padding:2px 4px;\">Normal</td><td style=\"padding:2px 4px;\">Normal</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>Primary Hypothyroidism</b></td><td style=\"padding:2px 4px;\"><b>Elevated (&gt; 5.0)</b></td><td style=\"padding:2px 4px;\">Low / Normal</td><td style=\"padding:2px 4px;\"><b>Low</b></td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>Subclinical Hypothyroidism</b></td><td style=\"padding:2px 4px;\"><b>Elevated (&gt; 5.0)</b></td><td style=\"padding:2px 4px;\">Normal</td><td style=\"padding:2px 4px;\">Normal</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>Primary Hyperthyroidism</b></td><td style=\"padding:2px 4px;\"><b>Suppressed (&lt; 0.1)</b></td><td style=\"padding:2px 4px;\"><b>Elevated</b></td><td style=\"padding:2px 4px;\"><b>Elevated</b></td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>Subclinical Hyperthyroidism</b></td><td style=\"padding:2px 4px;\"><b>Low / Suppressed</b></td><td style=\"padding:2px 4px;\">Normal</td><td style=\"padding:2px 4px;\">Normal</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>Central (Pituitary) Hypothyroid</b></td><td style=\"padding:2px 4px;\">Low or Inappropriately Normal</td><td style=\"padding:2px 4px;\">Low</td><td style=\"padding:2px 4px;\">Low</td></tr>
</table>
<p style=\"font-size:7pt; color:#64748b; margin:2px 0 0 0;\"><i>Note: TSH exhibits physiological diurnal rhythm (peak at night/early morning). Fasting morning sample recommended. Non-thyroidal critical illness and pregnancy alter binding proteins (Free T3/Free T4 preferred).</i></p>",
    "param_count" => 3,
    "parameters" => [
      [
        "name" => "TSH (Thyroid Stimulating Hormone)",
        "unit" => "\u00b5IU/mL",
        "method" => "Chemiluminescent Immunoassay (CLIA)",
        "sample" => "Serum",
        "male_min" => 0.35,
        "male_max" => 4.94,
        "female_min" => 0.35,
        "female_max" => 4.94,
        "text" => "Adults: 0.35 - 4.94 \u00b5IU/mL (Pregnancy: 1st Tri 0.1-2.5, 2nd Tri 0.2-3.0, 3rd Tri 0.3-3.0)"
      ],
      [
        "name" => "Total T3 (Triiodothyronine)",
        "unit" => "ng/dL",
        "method" => "CLIA / CMIA",
        "sample" => "Serum",
        "male_min" => 60,
        "male_max" => 180,
        "female_min" => 60,
        "female_max" => 180,
        "text" => "60.0 - 180.0 ng/dL"
      ],
      [
        "name" => "Total T4 (Thyroxine)",
        "unit" => "\u00b5g/dL",
        "method" => "CLIA / CMIA",
        "sample" => "Serum",
        "male_min" => 4.5,
        "male_max" => 12.0,
        "female_min" => 4.5,
        "female_max" => 12.0,
        "text" => "4.5 - 12.0 \u00b5g/dL"
      ]
    ]
  ],
  [
    "test_id" => 72,
    "name" => "TSH (Thyroid Stimulating Hormone alone)",
    "code" => "TSH",
    "category_id" => 6,
    "category_name" => "Endocrinology & Vitamins",
    "price" => 200.0,
    "notes" => "Chemiluminescent Microparticle Immunoassay (CLIA)",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>TSH Clinical Significance:</b> Chemiluminescent 3rd-generation TSH is the most sensitive first-line screening test for thyroid dysfunction and dosage titration of Levothyroxine therapy.<br>
• <b>TSH &gt; 10 µIU/mL:</b> Overt primary hypothyroidism; thyroxine replacement therapy generally indicated.<br>
• <b>TSH 4.5 – 10 µIU/mL:</b> Subclinical hypothyroidism; evaluate Anti-TPO antibodies, symptoms, pregnancy, and dyslipidemia before initiating treatment.<br>
• <b>TSH &lt; 0.1 µIU/mL:</b> Primary hyperthyroidism / Thyrotoxicosis or excessive thyroxine replacement.</p>",
    "param_count" => 1,
    "parameters" => [
      [
        "name" => "TSH (Thyroid Stimulating Hormone)",
        "unit" => "\u00b5IU/mL",
        "method" => "Chemiluminescent Immunoassay (CLIA)",
        "sample" => "Serum",
        "male_min" => 0.35,
        "male_max" => 4.94,
        "female_min" => 0.35,
        "female_max" => 4.94,
        "text" => "Adults: 0.35 - 4.94 \u00b5IU/mL (Pregnancy: 1st Tri 0.1-2.5, 2nd Tri 0.2-3.0, 3rd Tri 0.3-3.0)"
      ]
    ]
  ],
  [
    "test_id" => 73,
    "name" => "Free Thyroid Profile (FT3, FT4, TSH)",
    "code" => "FTFT",
    "category_id" => 6,
    "category_name" => "Endocrinology & Vitamins",
    "price" => 650.0,
    "notes" => "Quantitative CLIA for free active unbound hormones",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Thyroid Function Test Hormonal Correlation Matrix:</b></p>
<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\" style=\"border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;\">
  <tr style=\"background-color:#f1f5f9; font-weight:bold;\">
    <th style=\"width:28%; padding:2px 4px;\">Clinical Thyroid State</th>
    <th style=\"width:24%; padding:2px 4px;\">Serum TSH</th>
    <th style=\"width:24%; padding:2px 4px;\">Free T3 / Total T3</th>
    <th style=\"width:24%; padding:2px 4px;\">Free T4 / Total T4</th>
  </tr>
  <tr><td style=\"padding:2px 4px;\"><b>Euthyroid (Normal)</b></td><td style=\"padding:2px 4px;\">Normal (0.35 – 4.94)</td><td style=\"padding:2px 4px;\">Normal</td><td style=\"padding:2px 4px;\">Normal</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>Primary Hypothyroidism</b></td><td style=\"padding:2px 4px;\"><b>Elevated (&gt; 5.0)</b></td><td style=\"padding:2px 4px;\">Low / Normal</td><td style=\"padding:2px 4px;\"><b>Low</b></td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>Subclinical Hypothyroidism</b></td><td style=\"padding:2px 4px;\"><b>Elevated (&gt; 5.0)</b></td><td style=\"padding:2px 4px;\">Normal</td><td style=\"padding:2px 4px;\">Normal</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>Primary Hyperthyroidism</b></td><td style=\"padding:2px 4px;\"><b>Suppressed (&lt; 0.1)</b></td><td style=\"padding:2px 4px;\"><b>Elevated</b></td><td style=\"padding:2px 4px;\"><b>Elevated</b></td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>Subclinical Hyperthyroidism</b></td><td style=\"padding:2px 4px;\"><b>Low / Suppressed</b></td><td style=\"padding:2px 4px;\">Normal</td><td style=\"padding:2px 4px;\">Normal</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>Central (Pituitary) Hypothyroid</b></td><td style=\"padding:2px 4px;\">Low or Inappropriately Normal</td><td style=\"padding:2px 4px;\">Low</td><td style=\"padding:2px 4px;\">Low</td></tr>
</table>
<p style=\"font-size:7pt; color:#64748b; margin:2px 0 0 0;\"><i>Note: TSH exhibits physiological diurnal rhythm (peak at night/early morning). Fasting morning sample recommended. Non-thyroidal critical illness and pregnancy alter binding proteins (Free T3/Free T4 preferred).</i></p>",
    "param_count" => 3,
    "parameters" => [
      [
        "name" => "TSH (Thyroid Stimulating Hormone)",
        "unit" => "\u00b5IU/mL",
        "method" => "Chemiluminescent Immunoassay (CLIA)",
        "sample" => "Serum",
        "male_min" => 0.35,
        "male_max" => 4.94,
        "female_min" => 0.35,
        "female_max" => 4.94,
        "text" => "Adults: 0.35 - 4.94 \u00b5IU/mL (Pregnancy: 1st Tri 0.1-2.5, 2nd Tri 0.2-3.0, 3rd Tri 0.3-3.0)"
      ],
      [
        "name" => "Free T3 (FT3)",
        "unit" => "pg/mL",
        "method" => "CLIA",
        "sample" => "Serum",
        "male_min" => 2.0,
        "male_max" => 4.4,
        "female_min" => 2.0,
        "female_max" => 4.4,
        "text" => "Normal: 2.0 - 4.4 pg/mL"
      ],
      [
        "name" => "Free T4 (FT4)",
        "unit" => "ng/dL",
        "method" => "CLIA",
        "sample" => "Serum",
        "male_min" => 0.8,
        "male_max" => 1.8,
        "female_min" => 0.8,
        "female_max" => 1.8,
        "text" => "Normal: 0.8 - 1.8 ng/dL"
      ]
    ]
  ],
  [
    "test_id" => 74,
    "name" => "Free T3 (FT3 alone)",
    "code" => "FT3",
    "category_id" => 6,
    "category_name" => "Endocrinology & Vitamins",
    "price" => 250.0,
    "notes" => "Quantitative CLIA for Free Triiodothyronine",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Thyroid Function Test Hormonal Correlation Matrix:</b></p>
<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\" style=\"border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;\">
  <tr style=\"background-color:#f1f5f9; font-weight:bold;\">
    <th style=\"width:28%; padding:2px 4px;\">Clinical Thyroid State</th>
    <th style=\"width:24%; padding:2px 4px;\">Serum TSH</th>
    <th style=\"width:24%; padding:2px 4px;\">Free T3 / Total T3</th>
    <th style=\"width:24%; padding:2px 4px;\">Free T4 / Total T4</th>
  </tr>
  <tr><td style=\"padding:2px 4px;\"><b>Euthyroid (Normal)</b></td><td style=\"padding:2px 4px;\">Normal (0.35 – 4.94)</td><td style=\"padding:2px 4px;\">Normal</td><td style=\"padding:2px 4px;\">Normal</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>Primary Hypothyroidism</b></td><td style=\"padding:2px 4px;\"><b>Elevated (&gt; 5.0)</b></td><td style=\"padding:2px 4px;\">Low / Normal</td><td style=\"padding:2px 4px;\"><b>Low</b></td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>Subclinical Hypothyroidism</b></td><td style=\"padding:2px 4px;\"><b>Elevated (&gt; 5.0)</b></td><td style=\"padding:2px 4px;\">Normal</td><td style=\"padding:2px 4px;\">Normal</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>Primary Hyperthyroidism</b></td><td style=\"padding:2px 4px;\"><b>Suppressed (&lt; 0.1)</b></td><td style=\"padding:2px 4px;\"><b>Elevated</b></td><td style=\"padding:2px 4px;\"><b>Elevated</b></td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>Subclinical Hyperthyroidism</b></td><td style=\"padding:2px 4px;\"><b>Low / Suppressed</b></td><td style=\"padding:2px 4px;\">Normal</td><td style=\"padding:2px 4px;\">Normal</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>Central (Pituitary) Hypothyroid</b></td><td style=\"padding:2px 4px;\">Low or Inappropriately Normal</td><td style=\"padding:2px 4px;\">Low</td><td style=\"padding:2px 4px;\">Low</td></tr>
</table>
<p style=\"font-size:7pt; color:#64748b; margin:2px 0 0 0;\"><i>Note: TSH exhibits physiological diurnal rhythm (peak at night/early morning). Fasting morning sample recommended. Non-thyroidal critical illness and pregnancy alter binding proteins (Free T3/Free T4 preferred).</i></p>",
    "param_count" => 1,
    "parameters" => [
      [
        "name" => "Free T3 (FT3)",
        "unit" => "pg/mL",
        "method" => "CLIA",
        "sample" => "Serum",
        "male_min" => 2.0,
        "male_max" => 4.4,
        "female_min" => 2.0,
        "female_max" => 4.4,
        "text" => "Normal: 2.0 - 4.4 pg/mL"
      ]
    ]
  ],
  [
    "test_id" => 75,
    "name" => "Free T4 (FT4 alone)",
    "code" => "FT4",
    "category_id" => 6,
    "category_name" => "Endocrinology & Vitamins",
    "price" => 250.0,
    "notes" => "Quantitative CLIA for Free Thyroxine",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Thyroid Function Test Hormonal Correlation Matrix:</b></p>
<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\" style=\"border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;\">
  <tr style=\"background-color:#f1f5f9; font-weight:bold;\">
    <th style=\"width:28%; padding:2px 4px;\">Clinical Thyroid State</th>
    <th style=\"width:24%; padding:2px 4px;\">Serum TSH</th>
    <th style=\"width:24%; padding:2px 4px;\">Free T3 / Total T3</th>
    <th style=\"width:24%; padding:2px 4px;\">Free T4 / Total T4</th>
  </tr>
  <tr><td style=\"padding:2px 4px;\"><b>Euthyroid (Normal)</b></td><td style=\"padding:2px 4px;\">Normal (0.35 – 4.94)</td><td style=\"padding:2px 4px;\">Normal</td><td style=\"padding:2px 4px;\">Normal</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>Primary Hypothyroidism</b></td><td style=\"padding:2px 4px;\"><b>Elevated (&gt; 5.0)</b></td><td style=\"padding:2px 4px;\">Low / Normal</td><td style=\"padding:2px 4px;\"><b>Low</b></td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>Subclinical Hypothyroidism</b></td><td style=\"padding:2px 4px;\"><b>Elevated (&gt; 5.0)</b></td><td style=\"padding:2px 4px;\">Normal</td><td style=\"padding:2px 4px;\">Normal</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>Primary Hyperthyroidism</b></td><td style=\"padding:2px 4px;\"><b>Suppressed (&lt; 0.1)</b></td><td style=\"padding:2px 4px;\"><b>Elevated</b></td><td style=\"padding:2px 4px;\"><b>Elevated</b></td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>Subclinical Hyperthyroidism</b></td><td style=\"padding:2px 4px;\"><b>Low / Suppressed</b></td><td style=\"padding:2px 4px;\">Normal</td><td style=\"padding:2px 4px;\">Normal</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>Central (Pituitary) Hypothyroid</b></td><td style=\"padding:2px 4px;\">Low or Inappropriately Normal</td><td style=\"padding:2px 4px;\">Low</td><td style=\"padding:2px 4px;\">Low</td></tr>
</table>
<p style=\"font-size:7pt; color:#64748b; margin:2px 0 0 0;\"><i>Note: TSH exhibits physiological diurnal rhythm (peak at night/early morning). Fasting morning sample recommended. Non-thyroidal critical illness and pregnancy alter binding proteins (Free T3/Free T4 preferred).</i></p>",
    "param_count" => 1,
    "parameters" => [
      [
        "name" => "Free T4 (FT4)",
        "unit" => "ng/dL",
        "method" => "CLIA",
        "sample" => "Serum",
        "male_min" => 0.8,
        "male_max" => 1.8,
        "female_min" => 0.8,
        "female_max" => 1.8,
        "text" => "Normal: 0.8 - 1.8 ng/dL"
      ]
    ]
  ],
  [
    "test_id" => 76,
    "name" => "Vitamin D3 (25-Hydroxy Vitamin D)",
    "code" => "VITD",
    "category_id" => 6,
    "category_name" => "Endocrinology & Vitamins",
    "price" => 650.0,
    "notes" => "Chemiluminescent Immunoassay (CLIA) for total 25-OH Vitamin D",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>25-Hydroxy Vitamin D (Total) Clinical Classification (Endocrine Society Guidelines):</b></p>
<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\" style=\"border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;\">
  <tr style=\"background-color:#f1f5f9; font-weight:bold;\">
    <th style=\"width:30%; padding:2px 4px;\">25-OH Vitamin D Level</th>
    <th style=\"width:35%; padding:2px 4px;\">Clinical Status</th>
    <th style=\"width:35%; padding:2px 4px;\">Clinical Implication &amp; Action</th>
  </tr>
  <tr><td style=\"padding:2px 4px;\"><b>&lt; 20 ng/mL (&lt; 50 nmol/L)</b></td><td style=\"padding:2px 4px;\"><b>Deficiency</b></td><td style=\"padding:2px 4px;\">Impaired bone mineralization, osteomalacia, rickets, muscle aches; high-dose supplementation indicated</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>20 – 30 ng/mL (50 – 75 nmol/L)</b></td><td style=\"padding:2px 4px;\"><b>Insufficiency</b></td><td style=\"padding:2px 4px;\">Suboptimal for calcium absorption and bone health; maintenance supplementation recommended</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>30 – 100 ng/mL (75 – 250 nmol/L)</b></td><td style=\"padding:2px 4px;\"><b>Sufficiency</b></td><td style=\"padding:2px 4px;\">Optimal target range for skeletal, muscular, and immune health</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>&gt; 100 ng/mL (&gt; 250 nmol/L)</b></td><td style=\"padding:2px 4px;\"><b>Potential Toxicity / Hypervitaminosis D</b></td><td style=\"padding:2px 4px;\">Risk of hypercalcemia, hypercalciuria, nephrocalcinosis, and renal stones</td></tr>
</table>",
    "param_count" => 1,
    "parameters" => [
      [
        "name" => "25-Hydroxy Vitamin D3",
        "unit" => "ng/mL",
        "method" => "CLIA",
        "sample" => "Serum",
        "male_min" => 30,
        "male_max" => 100,
        "female_min" => 30,
        "female_max" => 100,
        "text" => "Deficient: <20, Insufficient: 20-29, Sufficient: 30-100, Toxicity: >100 ng/mL"
      ]
    ]
  ],
  [
    "test_id" => 77,
    "name" => "Vitamin B12 (Cyanocobalamin)",
    "code" => "VITB12",
    "category_id" => 6,
    "category_name" => "Endocrinology & Vitamins",
    "price" => 500.0,
    "notes" => "Chemiluminescent Immunoassay (CLIA)",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Serum Vitamin B12 (Cyanocobalamin) Clinical Classification:</b></p>
<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\" style=\"border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;\">
  <tr style=\"background-color:#f1f5f9; font-weight:bold;\">
    <th style=\"width:30%; padding:2px 4px;\">Vitamin B12 Level</th>
    <th style=\"width:35%; padding:2px 4px;\">Diagnostic Classification</th>
    <th style=\"width:35%; padding:2px 4px;\">Clinical Manifestations</th>
  </tr>
  <tr><td style=\"padding:2px 4px;\"><b>&lt; 200 pg/mL (&lt; 148 pmol/L)</b></td><td style=\"padding:2px 4px;\"><b>Deficiency</b></td><td style=\"padding:2px 4px;\">Megaloblastic anemia, peripheral neuropathy (numbness, paresthesias), subacute combined spinal degeneration</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>200 – 300 pg/mL</b></td><td style=\"padding:2px 4px;\"><b>Borderline / Equivocal</b></td><td style=\"padding:2px 4px;\">May have tissue-level deficiency; correlate with serum Homocysteine / Methylmalonic Acid (MMA)</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>&gt; 300 – 900 pg/mL</b></td><td style=\"padding:2px 4px;\"><b>Normal Range</b></td><td style=\"padding:2px 4px;\">Adequate tissue cobalamin stores</td></tr>
</table>
<p style=\"font-size:7pt; color:#64748b; margin:2px 0 0 0;\"><i>High prevalence in strict Indian vegetarian/vegan diets, elderly, prolonged Metformin or PPI antacid therapy, and post-bariatric gastrectomy.</i></p>",
    "param_count" => 1,
    "parameters" => [
      [
        "name" => "Serum Vitamin B12 (Cyanocobalamin)",
        "unit" => "pg/mL",
        "method" => "CLIA",
        "sample" => "Serum",
        "male_min" => 211,
        "male_max" => 911,
        "female_min" => 211,
        "female_max" => 911,
        "text" => "Normal: 211-911 pg/mL, Borderline: 150-210, Deficient: <150 pg/mL"
      ]
    ]
  ],
  [
    "test_id" => 78,
    "name" => "Vitamin D & B12 Combo Panel",
    "code" => "VITPKG",
    "category_id" => 6,
    "category_name" => "Endocrinology & Vitamins",
    "price" => 1000.0,
    "notes" => "Chemiluminescent quantification of 25-OH Vitamin D and Vitamin B12",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>25-Hydroxy Vitamin D (Total) Clinical Classification (Endocrine Society Guidelines):</b></p>
<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\" style=\"border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;\">
  <tr style=\"background-color:#f1f5f9; font-weight:bold;\">
    <th style=\"width:30%; padding:2px 4px;\">25-OH Vitamin D Level</th>
    <th style=\"width:35%; padding:2px 4px;\">Clinical Status</th>
    <th style=\"width:35%; padding:2px 4px;\">Clinical Implication &amp; Action</th>
  </tr>
  <tr><td style=\"padding:2px 4px;\"><b>&lt; 20 ng/mL (&lt; 50 nmol/L)</b></td><td style=\"padding:2px 4px;\"><b>Deficiency</b></td><td style=\"padding:2px 4px;\">Impaired bone mineralization, osteomalacia, rickets, muscle aches; high-dose supplementation indicated</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>20 – 30 ng/mL (50 – 75 nmol/L)</b></td><td style=\"padding:2px 4px;\"><b>Insufficiency</b></td><td style=\"padding:2px 4px;\">Suboptimal for calcium absorption and bone health; maintenance supplementation recommended</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>30 – 100 ng/mL (75 – 250 nmol/L)</b></td><td style=\"padding:2px 4px;\"><b>Sufficiency</b></td><td style=\"padding:2px 4px;\">Optimal target range for skeletal, muscular, and immune health</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>&gt; 100 ng/mL (&gt; 250 nmol/L)</b></td><td style=\"padding:2px 4px;\"><b>Potential Toxicity / Hypervitaminosis D</b></td><td style=\"padding:2px 4px;\">Risk of hypercalcemia, hypercalciuria, nephrocalcinosis, and renal stones</td></tr>
</table><br><p style=\"margin:2px 0;\"><b>Serum Vitamin B12 (Cyanocobalamin) Clinical Classification:</b></p>
<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\" style=\"border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;\">
  <tr style=\"background-color:#f1f5f9; font-weight:bold;\">
    <th style=\"width:30%; padding:2px 4px;\">Vitamin B12 Level</th>
    <th style=\"width:35%; padding:2px 4px;\">Diagnostic Classification</th>
    <th style=\"width:35%; padding:2px 4px;\">Clinical Manifestations</th>
  </tr>
  <tr><td style=\"padding:2px 4px;\"><b>&lt; 200 pg/mL (&lt; 148 pmol/L)</b></td><td style=\"padding:2px 4px;\"><b>Deficiency</b></td><td style=\"padding:2px 4px;\">Megaloblastic anemia, peripheral neuropathy (numbness, paresthesias), subacute combined spinal degeneration</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>200 – 300 pg/mL</b></td><td style=\"padding:2px 4px;\"><b>Borderline / Equivocal</b></td><td style=\"padding:2px 4px;\">May have tissue-level deficiency; correlate with serum Homocysteine / Methylmalonic Acid (MMA)</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>&gt; 300 – 900 pg/mL</b></td><td style=\"padding:2px 4px;\"><b>Normal Range</b></td><td style=\"padding:2px 4px;\">Adequate tissue cobalamin stores</td></tr>
</table>
<p style=\"font-size:7pt; color:#64748b; margin:2px 0 0 0;\"><i>High prevalence in strict Indian vegetarian/vegan diets, elderly, prolonged Metformin or PPI antacid therapy, and post-bariatric gastrectomy.</i></p>",
    "param_count" => 2,
    "parameters" => [
      [
        "name" => "25-Hydroxy Vitamin D3",
        "unit" => "ng/mL",
        "method" => "CLIA",
        "sample" => "Serum",
        "male_min" => 30,
        "male_max" => 100,
        "female_min" => 30,
        "female_max" => 100,
        "text" => "Deficient: <20, Insufficient: 20-29, Sufficient: 30-100, Toxicity: >100 ng/mL"
      ],
      [
        "name" => "Serum Vitamin B12 (Cyanocobalamin)",
        "unit" => "pg/mL",
        "method" => "CLIA",
        "sample" => "Serum",
        "male_min" => 211,
        "male_max" => 911,
        "female_min" => 211,
        "female_max" => 911,
        "text" => "Normal: 211-911 pg/mL, Borderline: 150-210, Deficient: <150 pg/mL"
      ]
    ]
  ],
  [
    "test_id" => 79,
    "name" => "Serum Beta-hCG (Quantitative)",
    "code" => "BHCG",
    "category_id" => 6,
    "category_name" => "Endocrinology & Vitamins",
    "price" => 500.0,
    "notes" => "Quantitative CLIA for total beta-human Chorionic Gonadotropin",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Quantitative Beta-hCG Clinical Reference Limits:</b></p>
<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\" style=\"border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;\">
  <tr style=\"background-color:#f1f5f9; font-weight:bold;\">
    <th style=\"width:35%; padding:2px 4px;\">Gestational Age (from LMP)</th>
    <th style=\"width:35%; padding:2px 4px;\">Approximate hCG Range (mIU/mL)</th>
    <th style=\"width:30%; padding:2px 4px;\">Clinical Context</th>
  </tr>
  <tr><td style=\"padding:2px 4px;\"><b>Non-Pregnant / Post-Menopausal</b></td><td style=\"padding:2px 4px;\">&lt; 5.0 mIU/mL</td><td style=\"padding:2px 4px;\">Negative for pregnancy</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>3 – 4 Weeks</b></td><td style=\"padding:2px 4px;\">9 – 130</td><td style=\"padding:2px 4px;\">Early implantation</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>4 – 5 Weeks</b></td><td style=\"padding:2px 4px;\">75 – 2,600</td><td style=\"padding:2px 4px;\">Doubles every 48–72 hours</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>5 – 6 Weeks</b></td><td style=\"padding:2px 4px;\">850 – 20,800</td><td style=\"padding:2px 4px;\">Gestational sac visible on TVS (&gt; 1500–2000)</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>6 – 8 Weeks</b></td><td style=\"padding:2px 4px;\">4,000 – 100,000</td><td style=\"padding:2px 4px;\">Fetal cardiac activity visible</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>8 – 12 Weeks (Peak)</b></td><td style=\"padding:2px 4px;\">32,000 – 210,000</td><td style=\"padding:2px 4px;\">Peak concentration</td></tr>
</table>
<p style=\"font-size:7pt; color:#64748b; margin:2px 0 0 0;\"><i>Suboptimal rise (&lt; 53% in 48h) or plateau suggests ectopic pregnancy or non-viable intrauterine pregnancy. Markedly excessive levels (&gt; 200,000 mIU/mL) suggest hydatidiform mole or choriocarcinoma.</i></p>",
    "param_count" => 1,
    "parameters" => [
      [
        "name" => "Beta-hCG (Total Quantitative)",
        "unit" => "mIU/mL",
        "method" => "CLIA",
        "sample" => "Serum",
        "male_min" => 0,
        "male_max" => 5.0,
        "female_min" => 0,
        "female_max" => 5.0,
        "text" => "Non-Pregnant: < 5.0 mIU/mL; Pregnancy: 1-2 wks: 50-500, 2-3 wks: 100-5000, 3-4 wks: 500-10000 mIU/mL"
      ]
    ]
  ],
  [
    "test_id" => 80,
    "name" => "Serum Prolactin",
    "code" => "PROLACTIN",
    "category_id" => 6,
    "category_name" => "Endocrinology & Vitamins",
    "price" => 350.0,
    "notes" => "Quantitative CLIA for morning prolactin",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Serum Prolactin Interpretation:</b><br>
• <b>Normal Adult Non-Pregnant:</b> 4.8 – 23.3 ng/mL.<br>
• <b>Hyperprolactinemia (&gt; 25 ng/mL):</b> Manifests as amenorrhea, galactorrhea, oligomenorrhea, female infertility, and male erectile dysfunction/gynecomastia.<br>
• <b>Etiologies:</b> Prolactinoma (pituitary adenoma; levels often &gt; 100–200 ng/mL), primary hypothyroidism (high TRH stimulates prolactin), dopamine-blocking drugs (Antipsychotics, Metoclopramide, Domperidone), chronic kidney disease, stress.<br>
<span style=\"font-size:7pt; color:#64748b;\"><i>Sample requirement: Morning collection, patient should be seated quietly for 20 minutes prior to venipuncture (avoid exercise, breast stimulation, and acute stress).</i></span></p>",
    "param_count" => 1,
    "parameters" => [
      [
        "name" => "Serum Prolactin",
        "unit" => "ng/mL",
        "method" => "CLIA",
        "sample" => "Serum (Morning)",
        "male_min" => 2.0,
        "male_max" => 18.0,
        "female_min" => 2.0,
        "female_max" => 29.0,
        "text" => "Male: 2.0 - 18.0 ng/mL, Female: 2.0 - 29.0 ng/mL (Postmenopausal: 2.0 - 20.0 ng/mL)"
      ]
    ]
  ],
  [
    "test_id" => 81,
    "name" => "PSA (Prostate Specific Antigen, Total)",
    "code" => "PSA",
    "category_id" => 6,
    "category_name" => "Endocrinology & Vitamins",
    "price" => 500.0,
    "notes" => "Quantitative CLIA for total circulating PSA",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Total PSA Clinical Interpretation (Prostate Cancer Screening):</b></p>
<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\" style=\"border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;\">
  <tr style=\"background-color:#f1f5f9; font-weight:bold;\">
    <th style=\"width:30%; padding:2px 4px;\">Serum Total PSA (ng/mL)</th>
    <th style=\"width:35%; padding:2px 4px;\">Risk Assessment</th>
    <th style=\"width:35%; padding:2px 4px;\">Clinical Recommendation</th>
  </tr>
  <tr><td style=\"padding:2px 4px;\"><b>0 – 4.0 ng/mL</b></td><td style=\"padding:2px 4px;\">Normal Baseline Range</td><td style=\"padding:2px 4px;\">Low probability of prostate carcinoma</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>4.0 – 10.0 ng/mL</b></td><td style=\"padding:2px 4px;\"><b>\"Diagnostic Gray Zone\"</b> (approx. 25% cancer risk)</td><td style=\"padding:2px 4px;\">Calculate Free/Total PSA ratio (% Free PSA &lt; 15% favors malignancy; &gt; 25% favors BPH)</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>&gt; 10.0 ng/mL</b></td><td style=\"padding:2px 4px;\">High Suspicion of Malignancy (&gt; 50% risk)</td><td style=\"padding:2px 4px;\">Multiparametric prostate MRI and TRUS-guided prostate biopsy indicated</td></tr>
</table>
<p style=\"font-size:7pt; color:#64748b; margin:2px 0 0 0;\"><i>Benign causes of elevated PSA: Benign Prostatic Hyperplasia (BPH), acute prostatitis, urinary retention, recent urinary catheterization, digital rectal examination (DRE), or ejaculation within 48 hours.</i></p>",
    "param_count" => 1,
    "parameters" => [
      [
        "name" => "PSA (Prostate Specific Antigen, Total)",
        "unit" => "ng/mL",
        "method" => "CLIA",
        "sample" => "Serum",
        "male_min" => 0,
        "male_max" => 4.0,
        "female_min" => 0,
        "female_max" => 0,
        "text" => "Normal: 0.0 - 4.0 ng/mL (Age specific: 40-49: <2.5, 50-59: <3.5, 60-69: <4.5, 70+: <6.5 ng/mL)"
      ]
    ]
  ],
  [
    "test_id" => 82,
    "name" => "CEA (Carcinoembryonic Antigen)",
    "code" => "CEA",
    "category_id" => 6,
    "category_name" => "Endocrinology & Vitamins",
    "price" => 500.0,
    "notes" => "Quantitative CLIA for circulating oncofetal antigen",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Carcinoembryonic Antigen (CEA) Interpretation:</b><br>
• Oncofetal glycoprotein primarily used for <b>monitoring therapeutic response and detecting post-surgical recurrence</b> in diagnosed colorectal, gastric, and pancreatic carcinoma.<br>
• <b>Reference:</b> Non-smokers: &lt; 3.0 ng/mL; Smokers: &lt; 5.0 ng/mL.<br>
• Not recommended for general asymptomatic cancer screening due to limited sensitivity and specificity.<br>
<span style=\"font-size:7pt; color:#64748b;\"><i>Benign elevations occur in chronic heavy smoking, alcoholic cirrhosis, chronic hepatitis, inflammatory bowel disease (Crohn/Ulcerative Colitis), and pancreatitis.</i></span></p>",
    "param_count" => 1,
    "parameters" => [
      [
        "name" => "CEA (Carcinoembryonic Antigen)",
        "unit" => "ng/mL",
        "method" => "CLIA",
        "sample" => "Serum",
        "male_min" => 0,
        "male_max" => 5.0,
        "female_min" => 0,
        "female_max" => 5.0,
        "text" => "Non-smoker: < 3.0 ng/mL; Smoker: < 5.0 ng/mL"
      ]
    ]
  ],
  [
    "test_id" => 83,
    "name" => "Thyroid Antibodies (Anti-TPO, Anti-Tg)",
    "code" => "THYAB",
    "category_id" => 6,
    "category_name" => "Endocrinology & Vitamins",
    "price" => 850.0,
    "notes" => "Quantitative CLIA for anti-thyroid peroxidase and anti-thyroglobulin",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Thyroid Autoantibodies (Anti-TPO &amp; Anti-Tg) Interpretation:</b><br>
• <b>Anti-TPO (Thyroid Peroxidase):</b> Hallmark serological biomarker for autoimmune thyroid disease. Present in &gt; 90% of patients with <b>Hashimoto thyroiditis</b> and 70–80% of patients with <b>Graves disease</b>.<br>
• <b>Anti-Tg (Thyroglobulin):</b> Helpful adjunctive marker in autoimmune thyroiditis and crucial for validating serum Thyroglobulin measurements in thyroid cancer surveillance.<br>
• High titers in euthyroid or subclinical hypothyroid individuals predict high risk of progression to overt hypothyroidism.</p>",
    "param_count" => 2,
    "parameters" => [
      [
        "name" => "Anti-TPO (Thyroid Peroxidase Antibodies)",
        "unit" => "IU/mL",
        "method" => "CLIA",
        "sample" => "Serum",
        "male_min" => 0,
        "male_max" => 34.0,
        "female_min" => 0,
        "female_max" => 34.0,
        "text" => "Normal: < 34.0 IU/mL (Negative)"
      ],
      [
        "name" => "Anti-Thyroglobulin Antibodies (Anti-Tg)",
        "unit" => "IU/mL",
        "method" => "CLIA",
        "sample" => "Serum",
        "male_min" => 0,
        "male_max" => 115.0,
        "female_min" => 0,
        "female_max" => 115.0,
        "text" => "Normal: < 115.0 IU/mL (Negative)"
      ]
    ]
  ],
  [
    "test_id" => 84,
    "name" => "Complete Urine Examination (CUE / Routine)",
    "code" => "URINE",
    "category_id" => 5,
    "category_name" => "Clinical Pathology",
    "price" => 120.0,
    "notes" => "Physical, chemical reagent strip and centrifuged sediment microscopic examination",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Complete Urine Examination (CUE) Clinical Diagnostic Significance:</b></p>
<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\" style=\"border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;\">
  <tr style=\"background-color:#f1f5f9; font-weight:bold;\">
    <th style=\"width:25%; padding:2px 4px;\">Urinary Finding</th>
    <th style=\"width:35%; padding:2px 4px;\">Pathological Correlation</th>
    <th style=\"width:40%; padding:2px 4px;\">Clinical Guidance</th>
  </tr>
  <tr><td style=\"padding:2px 4px;\"><b>Proteinuria (&gt; 30 mg/dL)</b></td><td style=\"padding:2px 4px;\">Glomerular disease, diabetic nephropathy, pre-eclampsia, nephrotic syndrome</td><td style=\"padding:2px 4px;\">Quantify via Spot Urine ACR or 24-hr urine protein</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>Glucosuria</b></td><td style=\"padding:2px 4px;\">Hyperglycemia exceeding renal threshold (~180 mg/dL), Renal glucosuria</td><td style=\"padding:2px 4px;\">Correlate with FBS / PPBS / HbA1c</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>Ketonuria</b></td><td style=\"padding:2px 4px;\">Diabetic Ketoacidosis (DKA), prolonged fasting/starvation, severe vomiting</td><td style=\"padding:2px 4px;\">Emergency evaluation in diabetic patients</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>Pus Cells (&gt; 5 / HPF) &amp; Nitrites</b></td><td style=\"padding:2px 4px;\">Urinary Tract Infection (Cystitis, Pyelonephritis)</td><td style=\"padding:2px 4px;\">Urine culture &amp; antimicrobial susceptibility advised</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>RBCs (&gt; 3 / HPF, Hematuria)</b></td><td style=\"padding:2px 4px;\">Urinary calculi, trauma, glomerulonephritis, malignancy (bladder/renal)</td><td style=\"padding:2px 4px;\">Ultrasound KUB, urological evaluation</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>Casts (Granular / RBC / WBC)</b></td><td style=\"padding:2px 4px;\">Intrinsic renal parenchymal disease (Glomerulonephritis, ATN)</td><td style=\"padding:2px 4px;\">Nephrology evaluation</td></tr>
</table>",
    "param_count" => 16,
    "parameters" => [
      [
        "name" => "Urine Color",
        "unit" => "",
        "method" => "Visual Inspection",
        "sample" => "Fresh Urine Sample",
        "male_min" => 0,
        "male_max" => 0,
        "female_min" => 0,
        "female_max" => 0,
        "text" => "Pale Yellow / Straw"
      ],
      [
        "name" => "Urine Appearance / Transparency",
        "unit" => "",
        "method" => "Visual Inspection",
        "sample" => "Fresh Urine Sample",
        "male_min" => 0,
        "male_max" => 0,
        "female_min" => 0,
        "female_max" => 0,
        "text" => "Clear"
      ],
      [
        "name" => "Urine Specific Gravity",
        "unit" => "",
        "method" => "Refractometer / Reagent Strip",
        "sample" => "Fresh Urine Sample",
        "male_min" => 1.005,
        "male_max" => 1.03,
        "female_min" => 1.005,
        "female_max" => 1.03,
        "text" => "1.005 - 1.030"
      ],
      [
        "name" => "Urine Reaction / pH",
        "unit" => "",
        "method" => "pH Indicator Strip",
        "sample" => "Fresh Urine Sample",
        "male_min" => 5.0,
        "male_max" => 7.5,
        "female_min" => 5.0,
        "female_max" => 7.5,
        "text" => "5.0 - 7.5 (Acidic)"
      ],
      [
        "name" => "Urine Albumin / Protein",
        "unit" => "",
        "method" => "Sulfosalicylic Acid / Strip",
        "sample" => "Fresh Urine Sample",
        "male_min" => 0,
        "male_max" => 0,
        "female_min" => 0,
        "female_max" => 0,
        "text" => "Nil / Negative"
      ],
      [
        "name" => "Urine Sugar / Glucose",
        "unit" => "",
        "method" => "Benedict / Glucose Oxidase",
        "sample" => "Fresh Urine Sample",
        "male_min" => 0,
        "male_max" => 0,
        "female_min" => 0,
        "female_max" => 0,
        "text" => "Nil / Negative"
      ],
      [
        "name" => "Urine Ketone Bodies",
        "unit" => "",
        "method" => "Rothera Nitroprusside Method",
        "sample" => "Fresh Urine Sample",
        "male_min" => 0,
        "male_max" => 0,
        "female_min" => 0,
        "female_max" => 0,
        "text" => "Negative / Absent"
      ],
      [
        "name" => "Urine Bile Salts",
        "unit" => "",
        "method" => "Hay Sulfur Test",
        "sample" => "Fresh Urine Sample",
        "male_min" => 0,
        "male_max" => 0,
        "female_min" => 0,
        "female_max" => 0,
        "text" => "Negative / Absent"
      ],
      [
        "name" => "Urine Bile Pigments",
        "unit" => "",
        "method" => "Fouchet Test",
        "sample" => "Fresh Urine Sample",
        "male_min" => 0,
        "male_max" => 0,
        "female_min" => 0,
        "female_max" => 0,
        "text" => "Negative / Absent"
      ],
      [
        "name" => "Urobilinogen",
        "unit" => "mg/dL",
        "method" => "Ehrlich Reagent Strip",
        "sample" => "Fresh Urine Sample",
        "male_min" => 0.2,
        "male_max" => 1.0,
        "female_min" => 0.2,
        "female_max" => 1.0,
        "text" => "Normal: 0.2 - 1.0 mg/dL"
      ],
      [
        "name" => "Pus Cells (Leukocytes)",
        "unit" => "/HPF",
        "method" => "Centrifuged Sediment Microscopy",
        "sample" => "Fresh Urine Sample",
        "male_min" => 0,
        "male_max" => 5,
        "female_min" => 0,
        "female_max" => 5,
        "text" => "0 - 5 / HPF"
      ],
      [
        "name" => "Red Blood Cells (RBCs)",
        "unit" => "/HPF",
        "method" => "Microscopy",
        "sample" => "Fresh Urine Sample",
        "male_min" => 0,
        "male_max" => 2,
        "female_min" => 0,
        "female_max" => 2,
        "text" => "0 - 2 / HPF (Occasional)"
      ],
      [
        "name" => "Epithelial Cells",
        "unit" => "/HPF",
        "method" => "Microscopy",
        "sample" => "Fresh Urine Sample",
        "male_min" => 0,
        "male_max" => 5,
        "female_min" => 0,
        "female_max" => 5,
        "text" => "Few (0 - 5 / HPF)"
      ],
      [
        "name" => "Casts",
        "unit" => "/LPF",
        "method" => "Microscopy",
        "sample" => "Fresh Urine Sample",
        "male_min" => 0,
        "male_max" => 0,
        "female_min" => 0,
        "female_max" => 0,
        "text" => "Nil / Not Seen"
      ],
      [
        "name" => "Crystals",
        "unit" => "",
        "method" => "Microscopy",
        "sample" => "Fresh Urine Sample",
        "male_min" => 0,
        "male_max" => 0,
        "female_min" => 0,
        "female_max" => 0,
        "text" => "Nil / Occasional Calcium Oxalate"
      ],
      [
        "name" => "Bacteria / Microorganisms",
        "unit" => "",
        "method" => "Microscopy",
        "sample" => "Fresh Urine Sample",
        "male_min" => 0,
        "male_max" => 0,
        "female_min" => 0,
        "female_max" => 0,
        "text" => "Absent / Nil"
      ]
    ]
  ],
  [
    "test_id" => 85,
    "name" => "Urine Pregnancy Test (UPT / Card)",
    "code" => "UPT",
    "category_id" => 5,
    "category_name" => "Clinical Pathology",
    "price" => 100.0,
    "notes" => "Rapid immunochromatographic cassette test for urine hCG",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Urine Pregnancy Test (Rapid hCG Card):</b><br>
• Qualitative immunochromatographic assay detecting hCG in urine (sensitivity ~ 20–25 mIU/mL).<br>
• <b>Positive:</b> Two distinct colored bands (Control and Test line). Confirms pregnancy.<br>
• <b>Negative:</b> Single colored band at Control line only. If clinically suspected (missed period), repeat on fresh early-morning first-void urine after 48–72 hours or perform quantitative serum Beta-hCG.</p>",
    "param_count" => 1,
    "parameters" => [
      [
        "name" => "Urine Pregnancy Test (Card)",
        "unit" => "",
        "method" => "Rapid hCG Immunochromatography",
        "sample" => "Early Morning Urine",
        "male_min" => 0,
        "male_max" => 0,
        "female_min" => 0,
        "female_max" => 0,
        "text" => "Negative (Non-Pregnant) / Positive (Pregnant)"
      ]
    ]
  ],
  [
    "test_id" => 86,
    "name" => "Urine Microalbumin (Spot ACR)",
    "code" => "MICROALB",
    "category_id" => 5,
    "category_name" => "Clinical Pathology",
    "price" => 350.0,
    "notes" => "Quantitative immunoturbidimetric microalbumin with spot creatinine ratio",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Urine Microalbumin / Albumin-to-Creatinine Ratio (ACR) Classification (KDIGO):</b></p>
<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\" style=\"border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;\">
  <tr style=\"background-color:#f1f5f9; font-weight:bold;\">
    <th style=\"width:30%; padding:2px 4px;\">Albumin/Creatinine Ratio (ACR)</th>
    <th style=\"width:35%; padding:2px 4px;\">Category (KDIGO Staging)</th>
    <th style=\"width:35%; padding:2px 4px;\">Clinical Significance</th>
  </tr>
  <tr><td style=\"padding:2px 4px;\"><b>&lt; 30 mg/g (&lt; 3 mg/mmol)</b></td><td style=\"padding:2px 4px;\"><b>A1: Normal to Mildly Increased</b></td><td style=\"padding:2px 4px;\">Normal baseline urinary albumin excretion</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>30 – 300 mg/g (3 – 30 mg/mmol)</b></td><td style=\"padding:2px 4px;\"><b>A2: Microalbuminuria (Moderately Increased)</b></td><td style=\"padding:2px 4px;\">Earliest clinical marker of Diabetic Nephropathy and cardiovascular risk; ACEi/ARB therapy indicated</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>&gt; 300 mg/g (&gt; 30 mg/mmol)</b></td><td style=\"padding:2px 4px;\"><b>A3: Macroalbuminuria (Severely Increased)</b></td><td style=\"padding:2px 4px;\">Overt diabetic nephropathy, high progression to chronic kidney failure</td></tr>
</table>",
    "param_count" => 3,
    "parameters" => [
      [
        "name" => "Urine Microalbumin",
        "unit" => "mg/L",
        "method" => "Immunoturbidimetry",
        "sample" => "Spot Early Morning Urine",
        "male_min" => 0,
        "male_max" => 20.0,
        "female_min" => 0,
        "female_max" => 20.0,
        "text" => "Normal: < 20.0 mg/L"
      ],
      [
        "name" => "Urine Creatinine",
        "unit" => "mg/dL",
        "method" => "Jaffe Kinetic",
        "sample" => "Spot Urine",
        "male_min" => 40,
        "male_max" => 250,
        "female_min" => 30,
        "female_max" => 200,
        "text" => "40 - 250 mg/dL"
      ],
      [
        "name" => "Albumin / Creatinine Ratio (ACR)",
        "unit" => "mg/g",
        "method" => "Calculated (Microalbumin / Creatinine * 1000)",
        "sample" => "Spot Urine",
        "male_min" => 0,
        "male_max" => 30.0,
        "female_min" => 0,
        "female_max" => 30.0,
        "text" => "Normal: < 30.0 mg/g; Microalbuminuria: 30.0 - 300.0 mg/g; Clinical Proteinuria: > 300.0 mg/g"
      ]
    ]
  ],
  [
    "test_id" => 87,
    "name" => "Urine Sugar & Ketone Bodies",
    "code" => "URINE-SK",
    "category_id" => 5,
    "category_name" => "Clinical Pathology",
    "price" => 60.0,
    "notes" => "Rapid chemical reagent strip method",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Urine Sugar &amp; Ketones Interpretation:</b><br>
• <b>Urine Sugar Positive + Urine Ketones Positive:</b> Strongly suggestive of <b>Diabetic Ketoacidosis (DKA)</b>, a medical emergency requiring urgent hospitalization, intravenous fluid resuscitation, and insulin infusion.<br>
• <b>Urine Sugar Positive + Urine Ketones Negative:</b> Uncontrolled hyperglycemia exceeding renal tubular absorptive threshold.<br>
• <b>Urine Sugar Negative + Urine Ketones Positive:</b> Starvation ketosis, low-carbohydrate (keto) diet, persistent vomiting (hyperemesis gravidarum).</p>",
    "param_count" => 2,
    "parameters" => [
      [
        "name" => "Urine Sugar / Glucose",
        "unit" => "",
        "method" => "Benedict / Glucose Oxidase",
        "sample" => "Fresh Urine Sample",
        "male_min" => 0,
        "male_max" => 0,
        "female_min" => 0,
        "female_max" => 0,
        "text" => "Nil / Negative"
      ],
      [
        "name" => "Urine Ketone Bodies",
        "unit" => "",
        "method" => "Rothera Nitroprusside Method",
        "sample" => "Fresh Urine Sample",
        "male_min" => 0,
        "male_max" => 0,
        "female_min" => 0,
        "female_max" => 0,
        "text" => "Negative / Absent"
      ]
    ]
  ],
  [
    "test_id" => 88,
    "name" => "Stool Routine & Microscopic Examination",
    "code" => "STOOL",
    "category_id" => 5,
    "category_name" => "Clinical Pathology",
    "price" => 150.0,
    "notes" => "Macroscopic examination and Saline / Iodine mount light microscopy",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Stool Routine &amp; Microscopic Examination Significance:</b><br>
• <b>Pus Cells &amp; Red Blood Cells:</b> Suggests invasive bacterial dysentery (*Shigella, Salmonella, Campylobacter*) or inflammatory bowel disease (Ulcerative Colitis).<br>
• <b>Trophozoites / Cysts:</b> *Entamoeba histolytica* (amebic colitis), *Giardia lamblia* cysts (malabsorption, giardiasis).<br>
• <b>Ova / Helminth Larvae:</b> *Ascaris lumbricoides, Ancylostoma duodenale* (hookworm), *Taenia* species, *Trichuris trichiura*.<br>
• <b>Reducing Substances (&gt; 0.5%):</b> Carbohydrate / lactose malabsorption, common in post-enteritis pediatric diarrhea.</p>",
    "param_count" => 7,
    "parameters" => [
      [
        "name" => "Stool Color",
        "unit" => "",
        "method" => "Macroscopic",
        "sample" => "Fresh Stool",
        "male_min" => 0,
        "male_max" => 0,
        "female_min" => 0,
        "female_max" => 0,
        "text" => "Brownish"
      ],
      [
        "name" => "Stool Consistency",
        "unit" => "",
        "method" => "Macroscopic",
        "sample" => "Fresh Stool",
        "male_min" => 0,
        "male_max" => 0,
        "female_min" => 0,
        "female_max" => 0,
        "text" => "Formed / Semi-formed"
      ],
      [
        "name" => "Stool Mucus",
        "unit" => "",
        "method" => "Macroscopic",
        "sample" => "Fresh Stool",
        "male_min" => 0,
        "male_max" => 0,
        "female_min" => 0,
        "female_max" => 0,
        "text" => "Absent / Nil"
      ],
      [
        "name" => "Stool Visible Blood",
        "unit" => "",
        "method" => "Macroscopic",
        "sample" => "Fresh Stool",
        "male_min" => 0,
        "male_max" => 0,
        "female_min" => 0,
        "female_max" => 0,
        "text" => "Absent / Nil"
      ],
      [
        "name" => "Stool Pus Cells",
        "unit" => "/HPF",
        "method" => "Saline / Iodine Mount Microscopy",
        "sample" => "Fresh Stool",
        "male_min" => 0,
        "male_max" => 2,
        "female_min" => 0,
        "female_max" => 2,
        "text" => "0 - 2 / HPF (Nil)"
      ],
      [
        "name" => "Stool RBCs",
        "unit" => "/HPF",
        "method" => "Microscopy",
        "sample" => "Fresh Stool",
        "male_min" => 0,
        "male_max" => 0,
        "female_min" => 0,
        "female_max" => 0,
        "text" => "Nil / Absent"
      ],
      [
        "name" => "Ova & Cysts",
        "unit" => "",
        "method" => "Saline / Iodine Mount Microscopy",
        "sample" => "Fresh Stool",
        "male_min" => 0,
        "male_max" => 0,
        "female_min" => 0,
        "female_max" => 0,
        "text" => "No Ova or Cysts Seen"
      ]
    ]
  ],
  [
    "test_id" => 89,
    "name" => "Stool Occult Blood Test (FOBT)",
    "code" => "FOBT",
    "category_id" => 5,
    "category_name" => "Clinical Pathology",
    "price" => 150.0,
    "notes" => "Fecal Immunochemical Test (FIT) / Guaiac method",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Stool Occult Blood Test (FOBT / FIT) Interpretation:</b><br>
• Detects invisible microscopic gastrointestinal bleeding.<br>
• <b>Positive:</b> Colorectal polyps, colorectal carcinoma, peptic ulcer disease, angiodysplasia, ulcerative colitis, hemorrhoids.<br>
• Recommended as primary annual non-invasive screening for colorectal cancer in adults ≥ 45–50 years.<br>
• Positive result warrants comprehensive lower gastrointestinal colonoscopy workup.</p>",
    "param_count" => 1,
    "parameters" => [
      [
        "name" => "Occult Blood Test (FOBT)",
        "unit" => "",
        "method" => "Guaiac / Immunochemical (FIT)",
        "sample" => "Stool",
        "male_min" => 0,
        "male_max" => 0,
        "female_min" => 0,
        "female_max" => 0,
        "text" => "Negative"
      ]
    ]
  ],
  [
    "test_id" => 90,
    "name" => "Semen Analysis (Complete)",
    "code" => "SEMEN",
    "category_id" => 5,
    "category_name" => "Clinical Pathology",
    "price" => 300.0,
    "notes" => "WHO 6th Edition standardized physical, count, motility and Kruger strict morphology evaluation",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Semen Analysis Reference Standards (WHO 6th Edition):</b></p>
<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\" style=\"border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;\">
  <tr style=\"background-color:#f1f5f9; font-weight:bold;\">
    <th style=\"width:30%; padding:2px 4px;\">Parameter</th>
    <th style=\"width:35%; padding:2px 4px;\">Lower Reference Limit (WHO 6th Ed)</th>
    <th style=\"width:35%; padding:2px 4px;\">Diagnostic Terminology</th>
  </tr>
  <tr><td style=\"padding:2px 4px;\"><b>Semen Volume</b></td><td style=\"padding:2px 4px;\">≥ 1.4 mL</td><td style=\"padding:2px 4px;\">&lt; 1.4 mL: Hypospermia</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>Total Sperm Count</b></td><td style=\"padding:2px 4px;\">≥ 39 million per ejaculate</td><td style=\"padding:2px 4px;\">&lt; 39 million: Oligozoospermia (0: Azoospermia)</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>Sperm Concentration</b></td><td style=\"padding:2px 4px;\">≥ 16 million / mL</td><td style=\"padding:2px 4px;\">&lt; 16 million/mL: Oligozoospermia</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>Progressive Motility (PR)</b></td><td style=\"padding:2px 4px;\">≥ 30% (Total PR + NP ≥ 42%)</td><td style=\"padding:2px 4px;\">&lt; 30% PR: Asthenozoospermia</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>Normal Morphology (Kruger)</b></td><td style=\"padding:2px 4px;\">≥ 4.0% normal forms</td><td style=\"padding:2px 4px;\">&lt; 4.0%: Teratozoospermia</td></tr>
  <tr><td style=\"padding:2px 4px;\"><b>Vitality (Live Sperm)</b></td><td style=\"padding:2px 4px;\">≥ 54% viable</td><td style=\"padding:2px 4px;\">&lt; 54%: Necrozoospermia</td></tr>
</table>
<p style=\"font-size:7pt; color:#64748b; margin:2px 0 0 0;\"><i>Sample collection instructions: Strict sexual abstinence of 2 to 7 days. Complete specimen delivered to laboratory within 30–60 minutes at body temperature.</i></p>",
    "param_count" => 8,
    "parameters" => [
      [
        "name" => "Semen Volume",
        "unit" => "mL",
        "method" => "Graduated Pipette / Syringe",
        "sample" => "Fresh Semen (3-5 days abstinence)",
        "male_min" => 1.5,
        "male_max" => 5.0,
        "female_min" => 0,
        "female_max" => 0,
        "text" => "Normal: 1.5 - 5.0 mL (>= 1.4 mL per WHO criteria)"
      ],
      [
        "name" => "Semen Reaction / pH",
        "unit" => "",
        "method" => "pH Indicator Paper",
        "sample" => "Fresh Semen",
        "male_min" => 7.2,
        "male_max" => 8.0,
        "female_min" => 0,
        "female_max" => 0,
        "text" => "7.2 - 8.0 (Alkaline)"
      ],
      [
        "name" => "Liquefaction Time",
        "unit" => "minutes",
        "method" => "Incubation at 37\u00b0C",
        "sample" => "Fresh Semen",
        "male_min" => 15,
        "male_max" => 30,
        "female_min" => 0,
        "female_max" => 0,
        "text" => "Complete within 15 - 30 minutes"
      ],
      [
        "name" => "Total Sperm Count",
        "unit" => "mill/mL",
        "method" => "Improved Neubauer Chamber",
        "sample" => "Fresh Semen",
        "male_min" => 15,
        "male_max" => 200,
        "female_min" => 0,
        "female_max" => 0,
        "text" => "Normal: 15.0 - 200.0 million/mL (>= 15 mill/mL per WHO criteria)"
      ],
      [
        "name" => "Progressive Motility (PR)",
        "unit" => "%",
        "method" => "Microscopy (Wet Mount)",
        "sample" => "Fresh Semen",
        "male_min" => 32,
        "male_max" => 100,
        "female_min" => 0,
        "female_max" => 0,
        "text" => ">= 32.0 % (WHO criteria)"
      ],
      [
        "name" => "Non-Progressive Motility (NP)",
        "unit" => "%",
        "method" => "Microscopy (Wet Mount)",
        "sample" => "Fresh Semen",
        "male_min" => 5,
        "male_max" => 15,
        "female_min" => 0,
        "female_max" => 0,
        "text" => "5.0 - 15.0 %"
      ],
      [
        "name" => "Immotile Spermatozoa",
        "unit" => "%",
        "method" => "Microscopy (Wet Mount)",
        "sample" => "Fresh Semen",
        "male_min" => 0,
        "male_max" => 40,
        "female_min" => 0,
        "female_max" => 0,
        "text" => "<= 40.0 %"
      ],
      [
        "name" => "Normal Morphology (Kruger Strict)",
        "unit" => "%",
        "method" => "Papanicolaou / Giemsa Staining",
        "sample" => "Fresh Semen",
        "male_min" => 4,
        "male_max" => 100,
        "female_min" => 0,
        "female_max" => 0,
        "text" => ">= 4.0 % Normal Forms (WHO criteria)"
      ]
    ]
  ],
  [
    "test_id" => 91,
    "name" => "Sputum for AFB (Acid Fast Bacilli - ZN Stain)",
    "code" => "AFB",
    "category_id" => 4,
    "category_name" => "Microbiology",
    "price" => 150.0,
    "notes" => "Ziehl-Neelsen carbol fuchsin acid-fast microscopic examination",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Sputum for Acid-Fast Bacilli (AFB - Ziehl-Neelsen Stain) RNTCP/NTEP Grading:</b></p>
<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\" style=\"border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;\">
  <tr style=\"background-color:#f1f5f9; font-weight:bold;\">
    <th style=\"width:35%; padding:2px 4px;\">Acid-Fast Bacilli Count (1000× Oil Immersion)</th>
    <th style=\"width:30%; padding:2px 4px;\">NTEP Grading Result</th>
    <th style=\"width:35%; padding:2px 4px;\">Clinical Significance</th>
  </tr>
  <tr><td style=\"padding:2px 4px;\">No AFB observed in 100 oil immersion fields</td><td style=\"padding:2px 4px;\"><b>Negative</b></td><td style=\"padding:2px 4px;\">No microscopic evidence of AFB (does not exclude TB)</td></tr>
  <tr><td style=\"padding:2px 4px;\">1 to 9 AFB per 100 oil immersion fields</td><td style=\"padding:2px 4px;\"><b>Scanty (Record exact number)</b></td><td style=\"padding:2px 4px;\">Positive for pulmonary tuberculosis</td></tr>
  <tr><td style=\"padding:2px 4px;\">10 to 99 AFB per 100 oil immersion fields</td><td style=\"padding:2px 4px;\"><b>Positive 1+</b></td><td style=\"padding:2px 4px;\">Infectious open pulmonary tuberculosis</td></tr>
  <tr><td style=\"padding:2px 4px;\">1 to 10 AFB per single oil immersion field (50 fields)</td><td style=\"padding:2px 4px;\"><b>Positive 2+</b></td><td style=\"padding:2px 4px;\">Moderately heavy bacillary load</td></tr>
  <tr><td style=\"padding:2px 4px;\">&gt; 10 AFB per single oil immersion field (20 fields)</td><td style=\"padding:2px 4px;\"><b>Positive 3+</b></td><td style=\"padding:2px 4px;\">Extremely heavy bacillary load; highly infectious</td></tr>
</table>
<p style=\"font-size:7pt; color:#64748b; margin:2px 0 0 0;\"><i>Note: CBNAAT / GeneXpert MTB/RIF assay is recommended for rapid confirmation and upfront Rifampicin resistance detection.</i></p>",
    "param_count" => 1,
    "parameters" => [
      [
        "name" => "Sputum for AFB (ZN Stain)",
        "unit" => "",
        "method" => "Ziehl-Neelsen Acid Fast Staining",
        "sample" => "Early Morning Deep Sputum",
        "male_min" => 0,
        "male_max" => 0,
        "female_min" => 0,
        "female_max" => 0,
        "text" => "Negative for Acid Fast Bacilli (No AFB Seen)"
      ]
    ]
  ],
  [
    "test_id" => 92,
    "name" => "Mantoux Test (Tuberculin Skin Test / PPD)",
    "code" => "MANTOUX",
    "category_id" => 3,
    "category_name" => "Serology & Immunology",
    "price" => 150.0,
    "notes" => "Intradermal injection of 5 TU PPD with induration calliper reading after 48-72 hours",
    "interpretations" => "<p style=\"margin:2px 0;\"><b>Mantoux Tuberculin Skin Test (5 TU PPD) Interpretation:</b><br>
Measured as transverse diameter of palpable induration (not erythema) after 48 to 72 hours:<br>
• <b>≥ 10 mm Induration:</b> Positive test in endemic populations (India), healthcare workers, diabetes, chronic renal disease.<br>
• <b>≥ 5 mm Induration:</b> Positive in HIV-infected individuals, immunosuppressed patients (&gt; 15 mg/day prednisolone), close contacts of active TB cases.<br>
• <b>&lt; 10 mm:</b> Negative result. Does not rule out active disease in severe malnutrition, miliary TB, or anergic states.<br>
<span style=\"font-size:7pt; color:#64748b;\"><i>Note: Positive Mantoux indicates delayed-type hypersensitivity cell-mediated response to M. tuberculosis exposure or prior BCG vaccination; it does not differentiate latent TB from active disease.</i></span></p>",
    "param_count" => 1,
    "parameters" => [
      [
        "name" => "Mantoux Tuberculin Skin Test (PPD)",
        "unit" => "mm",
        "method" => "Intradermal PPD (5 TU) / 48-72h Calliper Reading",
        "sample" => "Intradermal Reading",
        "male_min" => 0,
        "male_max" => 5.0,
        "female_min" => 0,
        "female_max" => 5.0,
        "text" => "Negative: < 5.0 mm induration; Intermediate: 5.0 - 9.0 mm; Positive: >= 10.0 mm (Past or active TB infection)"
      ]
    ]
  ]
];

$MASTER_CATALOG_PACKAGES = [
  [
    "package_id" => 1,
    "name" => "Basic Health Checkup",
    "code" => "BASICPKG",
    "price" => 699.0,
    "notes" => "Essential baseline health check: CBC, Fasting Blood Sugar, Lipid Profile, LFT, and Kidney Function Test",
    "original_price" => 1810.0,
    "savings" => 1111.0,
    "test_count" => 5,
    "tests" => [
      [
        "test_id" => 2,
        "name" => "Complete Hemogram / CBC",
        "code" => "CBC",
        "price" => 300.0
      ],
      [
        "test_id" => 17,
        "name" => "Fasting Blood Glucose (FBS)",
        "code" => "FBS",
        "price" => 60.0
      ],
      [
        "test_id" => 35,
        "name" => "Lipid Profile (Complete)",
        "code" => "LIPID",
        "price" => 500.0
      ],
      [
        "test_id" => 28,
        "name" => "Liver Function Test (LFT Complete)",
        "code" => "LFT",
        "price" => 500.0
      ],
      [
        "test_id" => 27,
        "name" => "Kidney Function Test (KFT / RFT Complete)",
        "code" => "KFT",
        "price" => 450.0
      ]
    ]
  ],
  [
    "package_id" => 2,
    "name" => "Executive Health Checkup",
    "code" => "EXECUTIVE",
    "price" => 1499.0,
    "notes" => "Comprehensive corporate executive checkup: CBC, Blood Sugar, Lipid Profile, LFT, KFT, Thyroid Profile, Electrolytes & Urine Routine",
    "original_price" => 2680.0,
    "savings" => 1181.0,
    "test_count" => 8,
    "tests" => [
      [
        "test_id" => 2,
        "name" => "Complete Hemogram / CBC",
        "code" => "CBC",
        "price" => 300.0
      ],
      [
        "test_id" => 17,
        "name" => "Fasting Blood Glucose (FBS)",
        "code" => "FBS",
        "price" => 60.0
      ],
      [
        "test_id" => 35,
        "name" => "Lipid Profile (Complete)",
        "code" => "LIPID",
        "price" => 500.0
      ],
      [
        "test_id" => 28,
        "name" => "Liver Function Test (LFT Complete)",
        "code" => "LFT",
        "price" => 500.0
      ],
      [
        "test_id" => 27,
        "name" => "Kidney Function Test (KFT / RFT Complete)",
        "code" => "KFT",
        "price" => 450.0
      ],
      [
        "test_id" => 71,
        "name" => "Thyroid Profile (Total T3, Total T4, TSH)",
        "code" => "TFT",
        "price" => 400.0
      ],
      [
        "test_id" => 40,
        "name" => "Serum Electrolytes (Na+, K+, Cl-)",
        "code" => "ELEC",
        "price" => 350.0
      ],
      [
        "test_id" => 84,
        "name" => "Complete Urine Examination (CUE / Routine)",
        "code" => "URINE",
        "price" => 120.0
      ]
    ]
  ],
  [
    "package_id" => 3,
    "name" => "Fever Profile (Complete)",
    "code" => "FEVERPKG",
    "price" => 599.0,
    "notes" => "Comprehensive acute fever workup: CBC with ESR, LFT, Malaria Antigen & Smear, Widal Agglutination, and Urine Routine",
    "original_price" => 1370.0,
    "savings" => 771.0,
    "test_count" => 5,
    "tests" => [
      [
        "test_id" => 1,
        "name" => "Complete Blood Count (CBC with ESR)",
        "code" => "CBC-ESR",
        "price" => 350.0
      ],
      [
        "test_id" => 28,
        "name" => "Liver Function Test (LFT Complete)",
        "code" => "LFT",
        "price" => 500.0
      ],
      [
        "test_id" => 56,
        "name" => "Malaria Parasite Detection (Card & Smear)",
        "code" => "MALARIA",
        "price" => 250.0
      ],
      [
        "test_id" => 53,
        "name" => "Widal Agglutination Test (Typhoid)",
        "code" => "WIDAL",
        "price" => 150.0
      ],
      [
        "test_id" => 84,
        "name" => "Complete Urine Examination (CUE / Routine)",
        "code" => "URINE",
        "price" => 120.0
      ]
    ]
  ],
  [
    "package_id" => 4,
    "name" => "Diabetic Care Package",
    "code" => "DIABETESPKG",
    "price" => 499.0,
    "notes" => "Complete diabetes monitoring: Fasting Sugar, Postprandial Sugar, HbA1c, Serum Creatinine, and Urine Microalbumin",
    "original_price" => 990.0,
    "savings" => 491.0,
    "test_count" => 5,
    "tests" => [
      [
        "test_id" => 17,
        "name" => "Fasting Blood Glucose (FBS)",
        "code" => "FBS",
        "price" => 60.0
      ],
      [
        "test_id" => 18,
        "name" => "Postprandial Blood Glucose (PPBS)",
        "code" => "PPBS",
        "price" => 60.0
      ],
      [
        "test_id" => 20,
        "name" => "HbA1c (Glycated Hemoglobin)",
        "code" => "HBA1C",
        "price" => 400.0
      ],
      [
        "test_id" => 23,
        "name" => "Serum Creatinine",
        "code" => "CREAT",
        "price" => 120.0
      ],
      [
        "test_id" => 86,
        "name" => "Urine Microalbumin (Spot ACR)",
        "code" => "MICROALB",
        "price" => 350.0
      ]
    ]
  ],
  [
    "package_id" => 5,
    "name" => "Comprehensive Cardiac Profile",
    "code" => "CARDIAC",
    "price" => 999.0,
    "notes" => "Cardiovascular risk package: Lipid Profile, Blood Sugar, CBC, Serum Electrolytes, and High Sensitivity hs-CRP",
    "original_price" => 1660.0,
    "savings" => 661.0,
    "test_count" => 5,
    "tests" => [
      [
        "test_id" => 35,
        "name" => "Lipid Profile (Complete)",
        "code" => "LIPID",
        "price" => 500.0
      ],
      [
        "test_id" => 17,
        "name" => "Fasting Blood Glucose (FBS)",
        "code" => "FBS",
        "price" => 60.0
      ],
      [
        "test_id" => 2,
        "name" => "Complete Hemogram / CBC",
        "code" => "CBC",
        "price" => 300.0
      ],
      [
        "test_id" => 40,
        "name" => "Serum Electrolytes (Na+, K+, Cl-)",
        "code" => "ELEC",
        "price" => 350.0
      ],
      [
        "test_id" => 62,
        "name" => "High Sensitivity CRP (hs-CRP)",
        "code" => "HS-CRP",
        "price" => 450.0
      ]
    ]
  ],
  [
    "package_id" => 6,
    "name" => "Liver Health Package",
    "code" => "LIVERPKG",
    "price" => 599.0,
    "notes" => "Comprehensive liver workup: Complete LFT, HBsAg, HCV Antibody, and CBC",
    "original_price" => 1400.0,
    "savings" => 801.0,
    "test_count" => 4,
    "tests" => [
      [
        "test_id" => 28,
        "name" => "Liver Function Test (LFT Complete)",
        "code" => "LFT",
        "price" => 500.0
      ],
      [
        "test_id" => 66,
        "name" => "HBsAg (Hepatitis B Surface Antigen)",
        "code" => "HBSAG",
        "price" => 250.0
      ],
      [
        "test_id" => 67,
        "name" => "Anti-HCV Antibody (Hepatitis C)",
        "code" => "HCV",
        "price" => 350.0
      ],
      [
        "test_id" => 2,
        "name" => "Complete Hemogram / CBC",
        "code" => "CBC",
        "price" => 300.0
      ]
    ]
  ],
  [
    "package_id" => 7,
    "name" => "Kidney Care Package",
    "code" => "KIDNEYPKG",
    "price" => 550.0,
    "notes" => "Complete renal assessment: KFT (Urea, Creatinine, Uric Acid, Calcium, Phos), Serum Electrolytes & Urine Examination",
    "original_price" => 920.0,
    "savings" => 370.0,
    "test_count" => 3,
    "tests" => [
      [
        "test_id" => 27,
        "name" => "Kidney Function Test (KFT / RFT Complete)",
        "code" => "KFT",
        "price" => 450.0
      ],
      [
        "test_id" => 40,
        "name" => "Serum Electrolytes (Na+, K+, Cl-)",
        "code" => "ELEC",
        "price" => 350.0
      ],
      [
        "test_id" => 84,
        "name" => "Complete Urine Examination (CUE / Routine)",
        "code" => "URINE",
        "price" => 120.0
      ]
    ]
  ],
  [
    "package_id" => 8,
    "name" => "Antenatal Profile (ANC Complete)",
    "code" => "ANTENATAL",
    "price" => 1299.0,
    "notes" => "Mandatory pregnancy profile: CBC, Blood Grouping & Rh, Blood Sugar, HIV I/II, HBsAg, VDRL, TSH & Urine Routine",
    "original_price" => 1480.0,
    "savings" => 181.0,
    "test_count" => 8,
    "tests" => [
      [
        "test_id" => 2,
        "name" => "Complete Hemogram / CBC",
        "code" => "CBC",
        "price" => 300.0
      ],
      [
        "test_id" => 9,
        "name" => "Blood Grouping & Rh (D) Typing",
        "code" => "BLOODGRP",
        "price" => 100.0
      ],
      [
        "test_id" => 19,
        "name" => "Random Blood Sugar (RBS)",
        "code" => "RBS",
        "price" => 60.0
      ],
      [
        "test_id" => 65,
        "name" => "HIV I & II Antibody Screening",
        "code" => "HIV",
        "price" => 300.0
      ],
      [
        "test_id" => 66,
        "name" => "HBsAg (Hepatitis B Surface Antigen)",
        "code" => "HBSAG",
        "price" => 250.0
      ],
      [
        "test_id" => 68,
        "name" => "VDRL / RPR Syphilis Screen",
        "code" => "VDRL",
        "price" => 150.0
      ],
      [
        "test_id" => 72,
        "name" => "TSH (Thyroid Stimulating Hormone alone)",
        "code" => "TSH",
        "price" => 200.0
      ],
      [
        "test_id" => 84,
        "name" => "Complete Urine Examination (CUE / Routine)",
        "code" => "URINE",
        "price" => 120.0
      ]
    ]
  ],
  [
    "package_id" => 9,
    "name" => "Senior Citizen Wellness Package",
    "code" => "SENIOR",
    "price" => 1699.0,
    "notes" => "Complete elderly health screening: CBC, KFT, LFT, Lipid, HbA1c, Calcium, Electrolytes, TSH & Complete Urine",
    "original_price" => 2940.0,
    "savings" => 1241.0,
    "test_count" => 9,
    "tests" => [
      [
        "test_id" => 2,
        "name" => "Complete Hemogram / CBC",
        "code" => "CBC",
        "price" => 300.0
      ],
      [
        "test_id" => 27,
        "name" => "Kidney Function Test (KFT / RFT Complete)",
        "code" => "KFT",
        "price" => 450.0
      ],
      [
        "test_id" => 28,
        "name" => "Liver Function Test (LFT Complete)",
        "code" => "LFT",
        "price" => 500.0
      ],
      [
        "test_id" => 35,
        "name" => "Lipid Profile (Complete)",
        "code" => "LIPID",
        "price" => 500.0
      ],
      [
        "test_id" => 20,
        "name" => "HbA1c (Glycated Hemoglobin)",
        "code" => "HBA1C",
        "price" => 400.0
      ],
      [
        "test_id" => 43,
        "name" => "Serum Calcium",
        "code" => "CALC",
        "price" => 120.0
      ],
      [
        "test_id" => 40,
        "name" => "Serum Electrolytes (Na+, K+, Cl-)",
        "code" => "ELEC",
        "price" => 350.0
      ],
      [
        "test_id" => 72,
        "name" => "TSH (Thyroid Stimulating Hormone alone)",
        "code" => "TSH",
        "price" => 200.0
      ],
      [
        "test_id" => 84,
        "name" => "Complete Urine Examination (CUE / Routine)",
        "code" => "URINE",
        "price" => 120.0
      ]
    ]
  ],
  [
    "package_id" => 10,
    "name" => "Full Body Health Screening (75+ Parameters)",
    "code" => "FULLBODY",
    "price" => 2199.0,
    "notes" => "Complete multi-organ checkup: CBC, LFT, KFT, Lipid, Thyroid (TFT), HbA1c, Electrolytes, Vitamin D3, Vitamin B12 & Urine",
    "original_price" => 4170.0,
    "savings" => 1971.0,
    "test_count" => 10,
    "tests" => [
      [
        "test_id" => 2,
        "name" => "Complete Hemogram / CBC",
        "code" => "CBC",
        "price" => 300.0
      ],
      [
        "test_id" => 28,
        "name" => "Liver Function Test (LFT Complete)",
        "code" => "LFT",
        "price" => 500.0
      ],
      [
        "test_id" => 27,
        "name" => "Kidney Function Test (KFT / RFT Complete)",
        "code" => "KFT",
        "price" => 450.0
      ],
      [
        "test_id" => 35,
        "name" => "Lipid Profile (Complete)",
        "code" => "LIPID",
        "price" => 500.0
      ],
      [
        "test_id" => 71,
        "name" => "Thyroid Profile (Total T3, Total T4, TSH)",
        "code" => "TFT",
        "price" => 400.0
      ],
      [
        "test_id" => 20,
        "name" => "HbA1c (Glycated Hemoglobin)",
        "code" => "HBA1C",
        "price" => 400.0
      ],
      [
        "test_id" => 40,
        "name" => "Serum Electrolytes (Na+, K+, Cl-)",
        "code" => "ELEC",
        "price" => 350.0
      ],
      [
        "test_id" => 76,
        "name" => "Vitamin D3 (25-Hydroxy Vitamin D)",
        "code" => "VITD",
        "price" => 650.0
      ],
      [
        "test_id" => 77,
        "name" => "Vitamin B12 (Cyanocobalamin)",
        "code" => "VITB12",
        "price" => 500.0
      ],
      [
        "test_id" => 84,
        "name" => "Complete Urine Examination (CUE / Routine)",
        "code" => "URINE",
        "price" => 120.0
      ]
    ]
  ],
  [
    "package_id" => 11,
    "name" => "Pre-Operative / Surgical Fitness Profile",
    "code" => "PREOP",
    "price" => 999.0,
    "notes" => "Mandatory pre-surgery fitness: CBC, Blood Group, BT & CT, PT/INR, Blood Sugar, HIV, HBsAg, HCV, Serum Creatinine & Urine",
    "original_price" => 2000.0,
    "savings" => 1001.0,
    "test_count" => 10,
    "tests" => [
      [
        "test_id" => 2,
        "name" => "Complete Hemogram / CBC",
        "code" => "CBC",
        "price" => 300.0
      ],
      [
        "test_id" => 9,
        "name" => "Blood Grouping & Rh (D) Typing",
        "code" => "BLOODGRP",
        "price" => 100.0
      ],
      [
        "test_id" => 10,
        "name" => "Bleeding Time & Clotting Time (BT & CT)",
        "code" => "BTCT",
        "price" => 100.0
      ],
      [
        "test_id" => 12,
        "name" => "Prothrombin Time with INR (PT / INR)",
        "code" => "PTINR",
        "price" => 300.0
      ],
      [
        "test_id" => 19,
        "name" => "Random Blood Sugar (RBS)",
        "code" => "RBS",
        "price" => 60.0
      ],
      [
        "test_id" => 65,
        "name" => "HIV I & II Antibody Screening",
        "code" => "HIV",
        "price" => 300.0
      ],
      [
        "test_id" => 66,
        "name" => "HBsAg (Hepatitis B Surface Antigen)",
        "code" => "HBSAG",
        "price" => 250.0
      ],
      [
        "test_id" => 67,
        "name" => "Anti-HCV Antibody (Hepatitis C)",
        "code" => "HCV",
        "price" => 350.0
      ],
      [
        "test_id" => 23,
        "name" => "Serum Creatinine",
        "code" => "CREAT",
        "price" => 120.0
      ],
      [
        "test_id" => 84,
        "name" => "Complete Urine Examination (CUE / Routine)",
        "code" => "URINE",
        "price" => 120.0
      ]
    ]
  ],
  [
    "package_id" => 12,
    "name" => "Arthritis & Joint Pain Profile",
    "code" => "ARTHRITIS",
    "price" => 799.0,
    "notes" => "Specialized joint screening: CBC with ESR, Serum Uric Acid, Serum Calcium, RA Factor, and Quantitative CRP",
    "original_price" => 1090.0,
    "savings" => 291.0,
    "test_count" => 5,
    "tests" => [
      [
        "test_id" => 1,
        "name" => "Complete Blood Count (CBC with ESR)",
        "code" => "CBC-ESR",
        "price" => 350.0
      ],
      [
        "test_id" => 26,
        "name" => "Serum Uric Acid",
        "code" => "URIC",
        "price" => 120.0
      ],
      [
        "test_id" => 43,
        "name" => "Serum Calcium",
        "code" => "CALC",
        "price" => 120.0
      ],
      [
        "test_id" => 63,
        "name" => "Rheumatoid Factor (RA / RF)",
        "code" => "RA-FACTOR",
        "price" => 250.0
      ],
      [
        "test_id" => 61,
        "name" => "C-Reactive Protein (CRP, Quantitative)",
        "code" => "CRP",
        "price" => 250.0
      ]
    ]
  ],
  [
    "package_id" => 13,
    "name" => "Thyroid & Vitamin Health Panel",
    "code" => "THY-VIT",
    "price" => 1299.0,
    "notes" => "Complete endocrine vitality check: Thyroid Profile (TFT), Vitamin D3 (25-OH), Vitamin B12, and Serum Calcium",
    "original_price" => 1670.0,
    "savings" => 371.0,
    "test_count" => 4,
    "tests" => [
      [
        "test_id" => 71,
        "name" => "Thyroid Profile (Total T3, Total T4, TSH)",
        "code" => "TFT",
        "price" => 400.0
      ],
      [
        "test_id" => 76,
        "name" => "Vitamin D3 (25-Hydroxy Vitamin D)",
        "code" => "VITD",
        "price" => 650.0
      ],
      [
        "test_id" => 77,
        "name" => "Vitamin B12 (Cyanocobalamin)",
        "code" => "VITB12",
        "price" => 500.0
      ],
      [
        "test_id" => 43,
        "name" => "Serum Calcium",
        "code" => "CALC",
        "price" => 120.0
      ]
    ]
  ],
  [
    "package_id" => 14,
    "name" => "Anemia Screening Profile",
    "code" => "ANEMIA",
    "price" => 699.0,
    "notes" => "Comprehensive anemia differential: CBC with ESR, Serum Iron Profile (Iron, TIBC, % Saturation), Serum Ferritin & Peripheral Smear",
    "original_price" => 1550.0,
    "savings" => 851.0,
    "test_count" => 4,
    "tests" => [
      [
        "test_id" => 1,
        "name" => "Complete Blood Count (CBC with ESR)",
        "code" => "CBC-ESR",
        "price" => 350.0
      ],
      [
        "test_id" => 51,
        "name" => "Serum Iron Profile (Iron, TIBC, % Saturation)",
        "code" => "IRON-PROF",
        "price" => 600.0
      ],
      [
        "test_id" => 69,
        "name" => "Serum Ferritin",
        "code" => "FERRITIN",
        "price" => 400.0
      ],
      [
        "test_id" => 14,
        "name" => "Peripheral Blood Smear Study (PBS)",
        "code" => "PBS",
        "price" => 200.0
      ]
    ]
  ],
  [
    "package_id" => 15,
    "name" => "Monsoon / Acute Fever Panel",
    "code" => "MONSOON",
    "price" => 899.0,
    "notes" => "Rapid monsoon epidemic fever differential: CBC, Dengue Combo (NS1+IgM+IgG), Malaria Card & Smear, Widal Agglutination & Urine Routine",
    "original_price" => 1420.0,
    "savings" => 521.0,
    "test_count" => 5,
    "tests" => [
      [
        "test_id" => 2,
        "name" => "Complete Hemogram / CBC",
        "code" => "CBC",
        "price" => 300.0
      ],
      [
        "test_id" => 59,
        "name" => "Dengue Serology (NS1 Ag, IgM, IgG)",
        "code" => "DENGUE",
        "price" => 600.0
      ],
      [
        "test_id" => 56,
        "name" => "Malaria Parasite Detection (Card & Smear)",
        "code" => "MALARIA",
        "price" => 250.0
      ],
      [
        "test_id" => 53,
        "name" => "Widal Agglutination Test (Typhoid)",
        "code" => "WIDAL",
        "price" => 150.0
      ],
      [
        "test_id" => 84,
        "name" => "Complete Urine Examination (CUE / Routine)",
        "code" => "URINE",
        "price" => 120.0
      ]
    ]
  ]
];
