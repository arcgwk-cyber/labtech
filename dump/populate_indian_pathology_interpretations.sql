-- VenSaas LabTech - Indian Pathology Master Fixed Interpretation Templates
-- Follows NABL / CAP / WHO / RSSDI / NCEP / KDIGO clinical standard formats
-- Character set: UTF-8

SET NAMES utf8mb4;

-- Test: CBC
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Clinical Significance:</b> The Complete Hemogram / CBC provides quantitative and qualitative evaluation of the formed elements of blood (erythrocytes, leukocytes, and thrombocytes).</p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:25%; padding:2px 4px;">Parameter Flag</th>
    <th style="width:35%; padding:2px 4px;">Potential Pathological Causes</th>
    <th style="width:40%; padding:2px 4px;">Recommended Correlative Workup</th>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Anemia (Low Hb/RBC)</b></td>
    <td style="padding:2px 4px;">Iron deficiency, Thalassemia trait, Vit B12/Folate deficiency, Acute blood loss, Chronic disease</td>
    <td style="padding:2px 4px;">Serum Ferritin, Iron Profile, Vit B12, Peripheral Smear (PBS), Reticulocyte count</td>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Leukocytosis (High TLC)</b></td>
    <td style="padding:2px 4px;">Acute bacterial infection, tissue necrosis, severe inflammation, leukemoid reaction, hematological malignancy</td>
    <td style="padding:2px 4px;">Differential count, CRP, Blood culture, Peripheral blood smear review</td>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Leukopenia (Low TLC)</b></td>
    <td style="padding:2px 4px;">Viral infections (Dengue, Typhoid, Viral hepatitis), autoimmune conditions, drug-induced marrow suppression</td>
    <td style="padding:2px 4px;">Serology (Dengue NS1/IgM, Widal, Typhidot), repeat counts in 48 hours</td>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Thrombocytopenia</b></td>
    <td style="padding:2px 4px;">Dengue, ITP, sepsis, malaria, drug-induced, hypersplenism, marrow suppression</td>
    <td style="padding:2px 4px;">Manual platelet smear estimate, Dengue/Malaria screen, daily monitoring if &lt; 50,000</td>
  </tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Note: Microscopic peripheral blood smear examination is recommended when automated flags or marked cytopenias are observed.</i></p>' WHERE `test_code` = 'CBC';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Clinical Significance:</b> The Complete Hemogram / CBC provides quantitative and qualitative evaluation of the formed elements of blood (erythrocytes, leukocytes, and thrombocytes).</p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:25%; padding:2px 4px;">Parameter Flag</th>
    <th style="width:35%; padding:2px 4px;">Potential Pathological Causes</th>
    <th style="width:40%; padding:2px 4px;">Recommended Correlative Workup</th>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Anemia (Low Hb/RBC)</b></td>
    <td style="padding:2px 4px;">Iron deficiency, Thalassemia trait, Vit B12/Folate deficiency, Acute blood loss, Chronic disease</td>
    <td style="padding:2px 4px;">Serum Ferritin, Iron Profile, Vit B12, Peripheral Smear (PBS), Reticulocyte count</td>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Leukocytosis (High TLC)</b></td>
    <td style="padding:2px 4px;">Acute bacterial infection, tissue necrosis, severe inflammation, leukemoid reaction, hematological malignancy</td>
    <td style="padding:2px 4px;">Differential count, CRP, Blood culture, Peripheral blood smear review</td>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Leukopenia (Low TLC)</b></td>
    <td style="padding:2px 4px;">Viral infections (Dengue, Typhoid, Viral hepatitis), autoimmune conditions, drug-induced marrow suppression</td>
    <td style="padding:2px 4px;">Serology (Dengue NS1/IgM, Widal, Typhidot), repeat counts in 48 hours</td>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Thrombocytopenia</b></td>
    <td style="padding:2px 4px;">Dengue, ITP, sepsis, malaria, drug-induced, hypersplenism, marrow suppression</td>
    <td style="padding:2px 4px;">Manual platelet smear estimate, Dengue/Malaria screen, daily monitoring if &lt; 50,000</td>
  </tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Note: Microscopic peripheral blood smear examination is recommended when automated flags or marked cytopenias are observed.</i></p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'CBC'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Clinical Significance:</b> The Complete Hemogram / CBC provides quantitative and qualitative evaluation of the formed elements of blood (erythrocytes, leukocytes, and thrombocytes).</p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:25%; padding:2px 4px;">Parameter Flag</th>
    <th style="width:35%; padding:2px 4px;">Potential Pathological Causes</th>
    <th style="width:40%; padding:2px 4px;">Recommended Correlative Workup</th>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Anemia (Low Hb/RBC)</b></td>
    <td style="padding:2px 4px;">Iron deficiency, Thalassemia trait, Vit B12/Folate deficiency, Acute blood loss, Chronic disease</td>
    <td style="padding:2px 4px;">Serum Ferritin, Iron Profile, Vit B12, Peripheral Smear (PBS), Reticulocyte count</td>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Leukocytosis (High TLC)</b></td>
    <td style="padding:2px 4px;">Acute bacterial infection, tissue necrosis, severe inflammation, leukemoid reaction, hematological malignancy</td>
    <td style="padding:2px 4px;">Differential count, CRP, Blood culture, Peripheral blood smear review</td>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Leukopenia (Low TLC)</b></td>
    <td style="padding:2px 4px;">Viral infections (Dengue, Typhoid, Viral hepatitis), autoimmune conditions, drug-induced marrow suppression</td>
    <td style="padding:2px 4px;">Serology (Dengue NS1/IgM, Widal, Typhidot), repeat counts in 48 hours</td>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Thrombocytopenia</b></td>
    <td style="padding:2px 4px;">Dengue, ITP, sepsis, malaria, drug-induced, hypersplenism, marrow suppression</td>
    <td style="padding:2px 4px;">Manual platelet smear estimate, Dengue/Malaria screen, daily monitoring if &lt; 50,000</td>
  </tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Note: Microscopic peripheral blood smear examination is recommended when automated flags or marked cytopenias are observed.</i></p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: CBC-ESR
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Clinical Significance:</b> The Complete Hemogram / CBC provides quantitative and qualitative evaluation of the formed elements of blood (erythrocytes, leukocytes, and thrombocytes).</p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:25%; padding:2px 4px;">Parameter Flag</th>
    <th style="width:35%; padding:2px 4px;">Potential Pathological Causes</th>
    <th style="width:40%; padding:2px 4px;">Recommended Correlative Workup</th>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Anemia (Low Hb/RBC)</b></td>
    <td style="padding:2px 4px;">Iron deficiency, Thalassemia trait, Vit B12/Folate deficiency, Acute blood loss, Chronic disease</td>
    <td style="padding:2px 4px;">Serum Ferritin, Iron Profile, Vit B12, Peripheral Smear (PBS), Reticulocyte count</td>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Leukocytosis (High TLC)</b></td>
    <td style="padding:2px 4px;">Acute bacterial infection, tissue necrosis, severe inflammation, leukemoid reaction, hematological malignancy</td>
    <td style="padding:2px 4px;">Differential count, CRP, Blood culture, Peripheral blood smear review</td>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Leukopenia (Low TLC)</b></td>
    <td style="padding:2px 4px;">Viral infections (Dengue, Typhoid, Viral hepatitis), autoimmune conditions, drug-induced marrow suppression</td>
    <td style="padding:2px 4px;">Serology (Dengue NS1/IgM, Widal, Typhidot), repeat counts in 48 hours</td>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Thrombocytopenia</b></td>
    <td style="padding:2px 4px;">Dengue, ITP, sepsis, malaria, drug-induced, hypersplenism, marrow suppression</td>
    <td style="padding:2px 4px;">Manual platelet smear estimate, Dengue/Malaria screen, daily monitoring if &lt; 50,000</td>
  </tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Note: Microscopic peripheral blood smear examination is recommended when automated flags or marked cytopenias are observed.</i></p>
<p style="margin:3px 0 0 0;"><b>ESR Significance:</b> Westergren 1st-hour ESR is an indirect acute-phase marker of systemic inflammation. Marked elevation (&gt; 100 mm/hr) strongly suggests bacterial infection (e.g., TB, osteomyelitis), autoimmune disease (e.g., SLE, RA), or multiple myeloma.</p>' WHERE `test_code` = 'CBC-ESR';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Clinical Significance:</b> The Complete Hemogram / CBC provides quantitative and qualitative evaluation of the formed elements of blood (erythrocytes, leukocytes, and thrombocytes).</p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:25%; padding:2px 4px;">Parameter Flag</th>
    <th style="width:35%; padding:2px 4px;">Potential Pathological Causes</th>
    <th style="width:40%; padding:2px 4px;">Recommended Correlative Workup</th>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Anemia (Low Hb/RBC)</b></td>
    <td style="padding:2px 4px;">Iron deficiency, Thalassemia trait, Vit B12/Folate deficiency, Acute blood loss, Chronic disease</td>
    <td style="padding:2px 4px;">Serum Ferritin, Iron Profile, Vit B12, Peripheral Smear (PBS), Reticulocyte count</td>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Leukocytosis (High TLC)</b></td>
    <td style="padding:2px 4px;">Acute bacterial infection, tissue necrosis, severe inflammation, leukemoid reaction, hematological malignancy</td>
    <td style="padding:2px 4px;">Differential count, CRP, Blood culture, Peripheral blood smear review</td>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Leukopenia (Low TLC)</b></td>
    <td style="padding:2px 4px;">Viral infections (Dengue, Typhoid, Viral hepatitis), autoimmune conditions, drug-induced marrow suppression</td>
    <td style="padding:2px 4px;">Serology (Dengue NS1/IgM, Widal, Typhidot), repeat counts in 48 hours</td>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Thrombocytopenia</b></td>
    <td style="padding:2px 4px;">Dengue, ITP, sepsis, malaria, drug-induced, hypersplenism, marrow suppression</td>
    <td style="padding:2px 4px;">Manual platelet smear estimate, Dengue/Malaria screen, daily monitoring if &lt; 50,000</td>
  </tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Note: Microscopic peripheral blood smear examination is recommended when automated flags or marked cytopenias are observed.</i></p>
<p style="margin:3px 0 0 0;"><b>ESR Significance:</b> Westergren 1st-hour ESR is an indirect acute-phase marker of systemic inflammation. Marked elevation (&gt; 100 mm/hr) strongly suggests bacterial infection (e.g., TB, osteomyelitis), autoimmune disease (e.g., SLE, RA), or multiple myeloma.</p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'CBC-ESR'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Clinical Significance:</b> The Complete Hemogram / CBC provides quantitative and qualitative evaluation of the formed elements of blood (erythrocytes, leukocytes, and thrombocytes).</p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:25%; padding:2px 4px;">Parameter Flag</th>
    <th style="width:35%; padding:2px 4px;">Potential Pathological Causes</th>
    <th style="width:40%; padding:2px 4px;">Recommended Correlative Workup</th>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Anemia (Low Hb/RBC)</b></td>
    <td style="padding:2px 4px;">Iron deficiency, Thalassemia trait, Vit B12/Folate deficiency, Acute blood loss, Chronic disease</td>
    <td style="padding:2px 4px;">Serum Ferritin, Iron Profile, Vit B12, Peripheral Smear (PBS), Reticulocyte count</td>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Leukocytosis (High TLC)</b></td>
    <td style="padding:2px 4px;">Acute bacterial infection, tissue necrosis, severe inflammation, leukemoid reaction, hematological malignancy</td>
    <td style="padding:2px 4px;">Differential count, CRP, Blood culture, Peripheral blood smear review</td>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Leukopenia (Low TLC)</b></td>
    <td style="padding:2px 4px;">Viral infections (Dengue, Typhoid, Viral hepatitis), autoimmune conditions, drug-induced marrow suppression</td>
    <td style="padding:2px 4px;">Serology (Dengue NS1/IgM, Widal, Typhidot), repeat counts in 48 hours</td>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Thrombocytopenia</b></td>
    <td style="padding:2px 4px;">Dengue, ITP, sepsis, malaria, drug-induced, hypersplenism, marrow suppression</td>
    <td style="padding:2px 4px;">Manual platelet smear estimate, Dengue/Malaria screen, daily monitoring if &lt; 50,000</td>
  </tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Note: Microscopic peripheral blood smear examination is recommended when automated flags or marked cytopenias are observed.</i></p>
<p style="margin:3px 0 0 0;"><b>ESR Significance:</b> Westergren 1st-hour ESR is an indirect acute-phase marker of systemic inflammation. Marked elevation (&gt; 100 mm/hr) strongly suggests bacterial infection (e.g., TB, osteomyelitis), autoimmune disease (e.g., SLE, RA), or multiple myeloma.</p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: HB
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Clinical Significance:</b> Hemoglobin measurement is the primary clinical parameter for evaluating oxygen-carrying capacity and screening for anemia or polycythemia.</p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:30%; padding:2px 4px;">Severity Category (WHO)</th>
    <th style="width:35%; padding:2px 4px;">Adult Males (g/dL)</th>
    <th style="width:35%; padding:2px 4px;">Adult Non-Pregnant Females (g/dL)</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>Normal</b></td><td style="padding:2px 4px;">13.0 – 17.0</td><td style="padding:2px 4px;">12.0 – 15.0</td></tr>
  <tr><td style="padding:2px 4px;"><b>Mild Anemia</b></td><td style="padding:2px 4px;">11.0 – 12.9</td><td style="padding:2px 4px;">11.0 – 11.9</td></tr>
  <tr><td style="padding:2px 4px;"><b>Moderate Anemia</b></td><td style="padding:2px 4px;">8.0 – 10.9</td><td style="padding:2px 4px;">8.0 – 10.9</td></tr>
  <tr><td style="padding:2px 4px;"><b>Severe Anemia</b></td><td style="padding:2px 4px;">&lt; 8.0</td><td style="padding:2px 4px;">&lt; 8.0</td></tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Physiological decrease occurs in pregnancy (hemodilution, cut-off: 11.0 g/dL). High levels may indicate polycythemia vera, chronic hypoxia (COPD, cyanotic heart disease), or hemoconcentration (dehydration).</i></p>' WHERE `test_code` = 'HB';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Clinical Significance:</b> Hemoglobin measurement is the primary clinical parameter for evaluating oxygen-carrying capacity and screening for anemia or polycythemia.</p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:30%; padding:2px 4px;">Severity Category (WHO)</th>
    <th style="width:35%; padding:2px 4px;">Adult Males (g/dL)</th>
    <th style="width:35%; padding:2px 4px;">Adult Non-Pregnant Females (g/dL)</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>Normal</b></td><td style="padding:2px 4px;">13.0 – 17.0</td><td style="padding:2px 4px;">12.0 – 15.0</td></tr>
  <tr><td style="padding:2px 4px;"><b>Mild Anemia</b></td><td style="padding:2px 4px;">11.0 – 12.9</td><td style="padding:2px 4px;">11.0 – 11.9</td></tr>
  <tr><td style="padding:2px 4px;"><b>Moderate Anemia</b></td><td style="padding:2px 4px;">8.0 – 10.9</td><td style="padding:2px 4px;">8.0 – 10.9</td></tr>
  <tr><td style="padding:2px 4px;"><b>Severe Anemia</b></td><td style="padding:2px 4px;">&lt; 8.0</td><td style="padding:2px 4px;">&lt; 8.0</td></tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Physiological decrease occurs in pregnancy (hemodilution, cut-off: 11.0 g/dL). High levels may indicate polycythemia vera, chronic hypoxia (COPD, cyanotic heart disease), or hemoconcentration (dehydration).</i></p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'HB'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Clinical Significance:</b> Hemoglobin measurement is the primary clinical parameter for evaluating oxygen-carrying capacity and screening for anemia or polycythemia.</p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:30%; padding:2px 4px;">Severity Category (WHO)</th>
    <th style="width:35%; padding:2px 4px;">Adult Males (g/dL)</th>
    <th style="width:35%; padding:2px 4px;">Adult Non-Pregnant Females (g/dL)</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>Normal</b></td><td style="padding:2px 4px;">13.0 – 17.0</td><td style="padding:2px 4px;">12.0 – 15.0</td></tr>
  <tr><td style="padding:2px 4px;"><b>Mild Anemia</b></td><td style="padding:2px 4px;">11.0 – 12.9</td><td style="padding:2px 4px;">11.0 – 11.9</td></tr>
  <tr><td style="padding:2px 4px;"><b>Moderate Anemia</b></td><td style="padding:2px 4px;">8.0 – 10.9</td><td style="padding:2px 4px;">8.0 – 10.9</td></tr>
  <tr><td style="padding:2px 4px;"><b>Severe Anemia</b></td><td style="padding:2px 4px;">&lt; 8.0</td><td style="padding:2px 4px;">&lt; 8.0</td></tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Physiological decrease occurs in pregnancy (hemodilution, cut-off: 11.0 g/dL). High levels may indicate polycythemia vera, chronic hypoxia (COPD, cyanotic heart disease), or hemoconcentration (dehydration).</i></p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: PLT
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Clinical Significance:</b> Platelets play a critical role in primary hemostasis and vascular endothelial integrity.</p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:30%; padding:2px 4px;">Platelet Count Range</th>
    <th style="width:35%; padding:2px 4px;">Clinical State</th>
    <th style="width:35%; padding:2px 4px;">Risk Assessment</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>&gt; 450,000 /µL</b></td><td style="padding:2px 4px;">Thrombocytosis</td><td style="padding:2px 4px;">Reactive (inflammation, iron deficiency) vs Myeloproliferative (ET)</td></tr>
  <tr><td style="padding:2px 4px;"><b>150,000 – 450,000 /µL</b></td><td style="padding:2px 4px;">Normal Range</td><td style="padding:2px 4px;">Normal hemostatic capacity</td></tr>
  <tr><td style="padding:2px 4px;"><b>50,000 – 100,000 /µL</b></td><td style="padding:2px 4px;">Moderate Thrombocytopenia</td><td style="padding:2px 4px;">Bleeding risk with major trauma or surgery; monitor closely</td></tr>
  <tr><td style="padding:2px 4px;"><b>&lt; 20,000 /µL</b></td><td style="padding:2px 4px;">Severe / Critical Thrombocytopenia</td><td style="padding:2px 4px;">High risk of spontaneous mucosal, gastrointestinal, or intracranial bleeding</td></tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Note: In Dengue fever, counts &lt; 100,000 /µL require close monitoring for plasma leakage signs (hematocrit elevation, gall bladder wall edema).</i></p>' WHERE `test_code` = 'PLT';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Clinical Significance:</b> Platelets play a critical role in primary hemostasis and vascular endothelial integrity.</p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:30%; padding:2px 4px;">Platelet Count Range</th>
    <th style="width:35%; padding:2px 4px;">Clinical State</th>
    <th style="width:35%; padding:2px 4px;">Risk Assessment</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>&gt; 450,000 /µL</b></td><td style="padding:2px 4px;">Thrombocytosis</td><td style="padding:2px 4px;">Reactive (inflammation, iron deficiency) vs Myeloproliferative (ET)</td></tr>
  <tr><td style="padding:2px 4px;"><b>150,000 – 450,000 /µL</b></td><td style="padding:2px 4px;">Normal Range</td><td style="padding:2px 4px;">Normal hemostatic capacity</td></tr>
  <tr><td style="padding:2px 4px;"><b>50,000 – 100,000 /µL</b></td><td style="padding:2px 4px;">Moderate Thrombocytopenia</td><td style="padding:2px 4px;">Bleeding risk with major trauma or surgery; monitor closely</td></tr>
  <tr><td style="padding:2px 4px;"><b>&lt; 20,000 /µL</b></td><td style="padding:2px 4px;">Severe / Critical Thrombocytopenia</td><td style="padding:2px 4px;">High risk of spontaneous mucosal, gastrointestinal, or intracranial bleeding</td></tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Note: In Dengue fever, counts &lt; 100,000 /µL require close monitoring for plasma leakage signs (hematocrit elevation, gall bladder wall edema).</i></p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'PLT'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Clinical Significance:</b> Platelets play a critical role in primary hemostasis and vascular endothelial integrity.</p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:30%; padding:2px 4px;">Platelet Count Range</th>
    <th style="width:35%; padding:2px 4px;">Clinical State</th>
    <th style="width:35%; padding:2px 4px;">Risk Assessment</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>&gt; 450,000 /µL</b></td><td style="padding:2px 4px;">Thrombocytosis</td><td style="padding:2px 4px;">Reactive (inflammation, iron deficiency) vs Myeloproliferative (ET)</td></tr>
  <tr><td style="padding:2px 4px;"><b>150,000 – 450,000 /µL</b></td><td style="padding:2px 4px;">Normal Range</td><td style="padding:2px 4px;">Normal hemostatic capacity</td></tr>
  <tr><td style="padding:2px 4px;"><b>50,000 – 100,000 /µL</b></td><td style="padding:2px 4px;">Moderate Thrombocytopenia</td><td style="padding:2px 4px;">Bleeding risk with major trauma or surgery; monitor closely</td></tr>
  <tr><td style="padding:2px 4px;"><b>&lt; 20,000 /µL</b></td><td style="padding:2px 4px;">Severe / Critical Thrombocytopenia</td><td style="padding:2px 4px;">High risk of spontaneous mucosal, gastrointestinal, or intracranial bleeding</td></tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Note: In Dengue fever, counts &lt; 100,000 /µL require close monitoring for plasma leakage signs (hematocrit elevation, gall bladder wall edema).</i></p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: TLC
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Clinical Significance:</b> Total Leucocyte Count (TLC) indicates systemic immune response and bone marrow output.</p>
<p style="margin:2px 0; font-size:7.5pt;"><b>Leukocytosis (&gt; 11,000 /µL):</b> Commonly seen in acute bacterial infections, abscesses, appendicitis, diabetic ketoacidosis, tissue necrosis (AMI), burns, strenuous exercise, glucocorticoid therapy, or myeloproliferative disorders.<br>
<b>Leukopenia (&lt; 4,000 /µL):</b> Common in viral infections (Dengue, Influenza, HIV, Hepatitis), severe sepsis (toxic depression), enteric fever, autoimmune lupus, bone marrow hypoplasia, and cytotoxic chemotherapy.</p>' WHERE `test_code` = 'TLC';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Clinical Significance:</b> Total Leucocyte Count (TLC) indicates systemic immune response and bone marrow output.</p>
<p style="margin:2px 0; font-size:7.5pt;"><b>Leukocytosis (&gt; 11,000 /µL):</b> Commonly seen in acute bacterial infections, abscesses, appendicitis, diabetic ketoacidosis, tissue necrosis (AMI), burns, strenuous exercise, glucocorticoid therapy, or myeloproliferative disorders.<br>
<b>Leukopenia (&lt; 4,000 /µL):</b> Common in viral infections (Dengue, Influenza, HIV, Hepatitis), severe sepsis (toxic depression), enteric fever, autoimmune lupus, bone marrow hypoplasia, and cytotoxic chemotherapy.</p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'TLC'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Clinical Significance:</b> Total Leucocyte Count (TLC) indicates systemic immune response and bone marrow output.</p>
<p style="margin:2px 0; font-size:7.5pt;"><b>Leukocytosis (&gt; 11,000 /µL):</b> Commonly seen in acute bacterial infections, abscesses, appendicitis, diabetic ketoacidosis, tissue necrosis (AMI), burns, strenuous exercise, glucocorticoid therapy, or myeloproliferative disorders.<br>
<b>Leukopenia (&lt; 4,000 /µL):</b> Common in viral infections (Dengue, Influenza, HIV, Hepatitis), severe sepsis (toxic depression), enteric fever, autoimmune lupus, bone marrow hypoplasia, and cytotoxic chemotherapy.</p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: DLC
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Differential Count Interpretation:</b><br>
• <b>Neutrophilia (&gt; 70%):</b> Bacterial infection, inflammation, tissue damage, stress, steroids.<br>
• <b>Lymphocytosis (&gt; 40%):</b> Viral infections (EBV, CMV, mumps, hepatitis), chronic lymphocytic leukemia (CLL), tuberculosis.<br>
• <b>Eosinophilia (&gt; 6%):</b> Allergic asthma, allergic rhinitis, parasitic intestinal worms (helminths), drug hypersensitivity, tropical pulmonary eosinophilia.<br>
• <b>Monocytosis (&gt; 10%):</b> Chronic infections, subacute bacterial endocarditis (SBE), tuberculosis, recovery phase of acute infection.<br>
• <b>Basophilia (&gt; 2%):</b> Chronic myeloid leukemia (CML), systemic allergic reactions, polycythemia vera.</p>' WHERE `test_code` = 'DLC';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Differential Count Interpretation:</b><br>
• <b>Neutrophilia (&gt; 70%):</b> Bacterial infection, inflammation, tissue damage, stress, steroids.<br>
• <b>Lymphocytosis (&gt; 40%):</b> Viral infections (EBV, CMV, mumps, hepatitis), chronic lymphocytic leukemia (CLL), tuberculosis.<br>
• <b>Eosinophilia (&gt; 6%):</b> Allergic asthma, allergic rhinitis, parasitic intestinal worms (helminths), drug hypersensitivity, tropical pulmonary eosinophilia.<br>
• <b>Monocytosis (&gt; 10%):</b> Chronic infections, subacute bacterial endocarditis (SBE), tuberculosis, recovery phase of acute infection.<br>
• <b>Basophilia (&gt; 2%):</b> Chronic myeloid leukemia (CML), systemic allergic reactions, polycythemia vera.</p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'DLC'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Differential Count Interpretation:</b><br>
• <b>Neutrophilia (&gt; 70%):</b> Bacterial infection, inflammation, tissue damage, stress, steroids.<br>
• <b>Lymphocytosis (&gt; 40%):</b> Viral infections (EBV, CMV, mumps, hepatitis), chronic lymphocytic leukemia (CLL), tuberculosis.<br>
• <b>Eosinophilia (&gt; 6%):</b> Allergic asthma, allergic rhinitis, parasitic intestinal worms (helminths), drug hypersensitivity, tropical pulmonary eosinophilia.<br>
• <b>Monocytosis (&gt; 10%):</b> Chronic infections, subacute bacterial endocarditis (SBE), tuberculosis, recovery phase of acute infection.<br>
• <b>Basophilia (&gt; 2%):</b> Chronic myeloid leukemia (CML), systemic allergic reactions, polycythemia vera.</p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: ESR
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Clinical Significance:</b> Westergren ESR reflects systemic inflammation and elevation of circulating fibrinogen and immunoglobulins.<br>
• <b>Moderate Elevation (20 – 50 mm/hr):</b> Localized infection, pregnancy, mild anemia, thyroid dysfunction, aging.<br>
• <b>Marked Elevation (&gt; 100 mm/hr):</b> Active tuberculosis, deep-seated bacterial abscesses, polymyalgia rheumatica, giant cell arteritis, systemic lupus erythematosus (SLE), multiple myeloma, metastatic malignancy.</p>' WHERE `test_code` = 'ESR';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Clinical Significance:</b> Westergren ESR reflects systemic inflammation and elevation of circulating fibrinogen and immunoglobulins.<br>
• <b>Moderate Elevation (20 – 50 mm/hr):</b> Localized infection, pregnancy, mild anemia, thyroid dysfunction, aging.<br>
• <b>Marked Elevation (&gt; 100 mm/hr):</b> Active tuberculosis, deep-seated bacterial abscesses, polymyalgia rheumatica, giant cell arteritis, systemic lupus erythematosus (SLE), multiple myeloma, metastatic malignancy.</p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'ESR'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Clinical Significance:</b> Westergren ESR reflects systemic inflammation and elevation of circulating fibrinogen and immunoglobulins.<br>
• <b>Moderate Elevation (20 – 50 mm/hr):</b> Localized infection, pregnancy, mild anemia, thyroid dysfunction, aging.<br>
• <b>Marked Elevation (&gt; 100 mm/hr):</b> Active tuberculosis, deep-seated bacterial abscesses, polymyalgia rheumatica, giant cell arteritis, systemic lupus erythematosus (SLE), multiple myeloma, metastatic malignancy.</p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: AEC
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Absolute Eosinophil Count (AEC) Interpretation:</b><br>
• <b>Normal:</b> 40 – 440 cells/µL<br>
• <b>Mild Eosinophilia (440 – 1500 cells/µL):</b> Bronchial asthma, allergic dermatitis, seasonal rhinitis, drug allergy.<br>
• <b>Moderate to Marked (&gt; 1500 cells/µL):</b> Parasitic infestations (Ascaris, Strongyloides, Filariasis), Tropical Pulmonary Eosinophilia (TPE), Churg-Strauss syndrome, Hypereosinophilic Syndrome (HES).</p>' WHERE `test_code` = 'AEC';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Absolute Eosinophil Count (AEC) Interpretation:</b><br>
• <b>Normal:</b> 40 – 440 cells/µL<br>
• <b>Mild Eosinophilia (440 – 1500 cells/µL):</b> Bronchial asthma, allergic dermatitis, seasonal rhinitis, drug allergy.<br>
• <b>Moderate to Marked (&gt; 1500 cells/µL):</b> Parasitic infestations (Ascaris, Strongyloides, Filariasis), Tropical Pulmonary Eosinophilia (TPE), Churg-Strauss syndrome, Hypereosinophilic Syndrome (HES).</p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'AEC'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Absolute Eosinophil Count (AEC) Interpretation:</b><br>
• <b>Normal:</b> 40 – 440 cells/µL<br>
• <b>Mild Eosinophilia (440 – 1500 cells/µL):</b> Bronchial asthma, allergic dermatitis, seasonal rhinitis, drug allergy.<br>
• <b>Moderate to Marked (&gt; 1500 cells/µL):</b> Parasitic infestations (Ascaris, Strongyloides, Filariasis), Tropical Pulmonary Eosinophilia (TPE), Churg-Strauss syndrome, Hypereosinophilic Syndrome (HES).</p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: BLOODGRP
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Clinical Significance:</b> Determination of ABO and Rh(D) blood group antigens by forward (cell) and reverse (serum) grouping.<br>
• <b>Pre-transfusion Verification:</b> Vital for matching donor and recipient packed red blood cells to prevent acute hemolytic transfusion reactions.<br>
• <b>Antenatal Screening:</b> Essential for detecting Rh(D)-negative pregnant mothers to administer Anti-D immunoglobulin prophylaxis against Hemolytic Disease of the Fetus and Newborn (HDFN).</p>' WHERE `test_code` = 'BLOODGRP';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Clinical Significance:</b> Determination of ABO and Rh(D) blood group antigens by forward (cell) and reverse (serum) grouping.<br>
• <b>Pre-transfusion Verification:</b> Vital for matching donor and recipient packed red blood cells to prevent acute hemolytic transfusion reactions.<br>
• <b>Antenatal Screening:</b> Essential for detecting Rh(D)-negative pregnant mothers to administer Anti-D immunoglobulin prophylaxis against Hemolytic Disease of the Fetus and Newborn (HDFN).</p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'BLOODGRP'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Clinical Significance:</b> Determination of ABO and Rh(D) blood group antigens by forward (cell) and reverse (serum) grouping.<br>
• <b>Pre-transfusion Verification:</b> Vital for matching donor and recipient packed red blood cells to prevent acute hemolytic transfusion reactions.<br>
• <b>Antenatal Screening:</b> Essential for detecting Rh(D)-negative pregnant mothers to administer Anti-D immunoglobulin prophylaxis against Hemolytic Disease of the Fetus and Newborn (HDFN).</p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: BTCT
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Clinical Significance:</b> Primary pre-operative bedside screening for hemostatic competency.<br>
• <b>Bleeding Time (Duke: 1 – 5 mins):</b> Assesses platelet-vessel wall interaction (primary hemostasis). Prolonged in thrombocytopenia, von Willebrand disease, and antiplatelet (Aspirin/Clopidogrel) therapy.<br>
• <b>Clotting Time (Capillary: 3 – 8 mins):</b> Assesses intrinsic and common coagulation factor cascade. Prolonged in severe hemophilia or factor deficiencies.</p>' WHERE `test_code` = 'BTCT';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Clinical Significance:</b> Primary pre-operative bedside screening for hemostatic competency.<br>
• <b>Bleeding Time (Duke: 1 – 5 mins):</b> Assesses platelet-vessel wall interaction (primary hemostasis). Prolonged in thrombocytopenia, von Willebrand disease, and antiplatelet (Aspirin/Clopidogrel) therapy.<br>
• <b>Clotting Time (Capillary: 3 – 8 mins):</b> Assesses intrinsic and common coagulation factor cascade. Prolonged in severe hemophilia or factor deficiencies.</p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'BTCT'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Clinical Significance:</b> Primary pre-operative bedside screening for hemostatic competency.<br>
• <b>Bleeding Time (Duke: 1 – 5 mins):</b> Assesses platelet-vessel wall interaction (primary hemostasis). Prolonged in thrombocytopenia, von Willebrand disease, and antiplatelet (Aspirin/Clopidogrel) therapy.<br>
• <b>Clotting Time (Capillary: 3 – 8 mins):</b> Assesses intrinsic and common coagulation factor cascade. Prolonged in severe hemophilia or factor deficiencies.</p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: PTINR
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Clinical Significance:</b> Prothrombin Time (PT) assesses the extrinsic (Factor VII) and common (Factors X, V, II, I) coagulation pathways. International Normalized Ratio (INR) standardizes results across thromboplastin reagents.</p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:30%; padding:2px 4px;">Clinical Indication</th>
    <th style="width:35%; padding:2px 4px;">Target Therapeutic INR Range</th>
    <th style="width:35%; padding:2px 4px;">Clinical Action Guidance</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>Normal (Not on Anticoagulants)</b></td><td style="padding:2px 4px;">0.8 – 1.2</td><td style="padding:2px 4px;">Normal baseline coagulation</td></tr>
  <tr><td style="padding:2px 4px;"><b>Standard DVT / PE / Atrial Fib</b></td><td style="padding:2px 4px;">2.0 – 3.0</td><td style="padding:2px 4px;">Standard Warfarin / Acitrom therapeutic window</td></tr>
  <tr><td style="padding:2px 4px;"><b>Mechanical Heart Valves</b></td><td style="padding:2px 4px;">2.5 – 3.5</td><td style="padding:2px 4px;">Intensive anticoagulation target</td></tr>
  <tr><td style="padding:2px 4px;"><b>INR &gt; 4.5 (High Bleeding Risk)</b></td><td style="padding:2px 4px;">Above Therapeutic Range</td><td style="padding:2px 4px;">Risk of major hemorrhage; withhold dose / administer Vitamin K per clinician advice</td></tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Note: Also prolonged in Vitamin K deficiency, liver cirrhosis / hepatocellular failure, and DIC.</i></p>' WHERE `test_code` = 'PTINR';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Clinical Significance:</b> Prothrombin Time (PT) assesses the extrinsic (Factor VII) and common (Factors X, V, II, I) coagulation pathways. International Normalized Ratio (INR) standardizes results across thromboplastin reagents.</p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:30%; padding:2px 4px;">Clinical Indication</th>
    <th style="width:35%; padding:2px 4px;">Target Therapeutic INR Range</th>
    <th style="width:35%; padding:2px 4px;">Clinical Action Guidance</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>Normal (Not on Anticoagulants)</b></td><td style="padding:2px 4px;">0.8 – 1.2</td><td style="padding:2px 4px;">Normal baseline coagulation</td></tr>
  <tr><td style="padding:2px 4px;"><b>Standard DVT / PE / Atrial Fib</b></td><td style="padding:2px 4px;">2.0 – 3.0</td><td style="padding:2px 4px;">Standard Warfarin / Acitrom therapeutic window</td></tr>
  <tr><td style="padding:2px 4px;"><b>Mechanical Heart Valves</b></td><td style="padding:2px 4px;">2.5 – 3.5</td><td style="padding:2px 4px;">Intensive anticoagulation target</td></tr>
  <tr><td style="padding:2px 4px;"><b>INR &gt; 4.5 (High Bleeding Risk)</b></td><td style="padding:2px 4px;">Above Therapeutic Range</td><td style="padding:2px 4px;">Risk of major hemorrhage; withhold dose / administer Vitamin K per clinician advice</td></tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Note: Also prolonged in Vitamin K deficiency, liver cirrhosis / hepatocellular failure, and DIC.</i></p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'PTINR'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Clinical Significance:</b> Prothrombin Time (PT) assesses the extrinsic (Factor VII) and common (Factors X, V, II, I) coagulation pathways. International Normalized Ratio (INR) standardizes results across thromboplastin reagents.</p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:30%; padding:2px 4px;">Clinical Indication</th>
    <th style="width:35%; padding:2px 4px;">Target Therapeutic INR Range</th>
    <th style="width:35%; padding:2px 4px;">Clinical Action Guidance</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>Normal (Not on Anticoagulants)</b></td><td style="padding:2px 4px;">0.8 – 1.2</td><td style="padding:2px 4px;">Normal baseline coagulation</td></tr>
  <tr><td style="padding:2px 4px;"><b>Standard DVT / PE / Atrial Fib</b></td><td style="padding:2px 4px;">2.0 – 3.0</td><td style="padding:2px 4px;">Standard Warfarin / Acitrom therapeutic window</td></tr>
  <tr><td style="padding:2px 4px;"><b>Mechanical Heart Valves</b></td><td style="padding:2px 4px;">2.5 – 3.5</td><td style="padding:2px 4px;">Intensive anticoagulation target</td></tr>
  <tr><td style="padding:2px 4px;"><b>INR &gt; 4.5 (High Bleeding Risk)</b></td><td style="padding:2px 4px;">Above Therapeutic Range</td><td style="padding:2px 4px;">Risk of major hemorrhage; withhold dose / administer Vitamin K per clinician advice</td></tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Note: Also prolonged in Vitamin K deficiency, liver cirrhosis / hepatocellular failure, and DIC.</i></p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: COAG
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Clinical Significance:</b> Prothrombin Time (PT) assesses the extrinsic (Factor VII) and common (Factors X, V, II, I) coagulation pathways. International Normalized Ratio (INR) standardizes results across thromboplastin reagents.</p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:30%; padding:2px 4px;">Clinical Indication</th>
    <th style="width:35%; padding:2px 4px;">Target Therapeutic INR Range</th>
    <th style="width:35%; padding:2px 4px;">Clinical Action Guidance</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>Normal (Not on Anticoagulants)</b></td><td style="padding:2px 4px;">0.8 – 1.2</td><td style="padding:2px 4px;">Normal baseline coagulation</td></tr>
  <tr><td style="padding:2px 4px;"><b>Standard DVT / PE / Atrial Fib</b></td><td style="padding:2px 4px;">2.0 – 3.0</td><td style="padding:2px 4px;">Standard Warfarin / Acitrom therapeutic window</td></tr>
  <tr><td style="padding:2px 4px;"><b>Mechanical Heart Valves</b></td><td style="padding:2px 4px;">2.5 – 3.5</td><td style="padding:2px 4px;">Intensive anticoagulation target</td></tr>
  <tr><td style="padding:2px 4px;"><b>INR &gt; 4.5 (High Bleeding Risk)</b></td><td style="padding:2px 4px;">Above Therapeutic Range</td><td style="padding:2px 4px;">Risk of major hemorrhage; withhold dose / administer Vitamin K per clinician advice</td></tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Note: Also prolonged in Vitamin K deficiency, liver cirrhosis / hepatocellular failure, and DIC.</i></p>
<p style="margin:3px 0 0 0;"><b>Activated Partial Thromboplastin Time (aPTT):</b> Evaluates intrinsic pathway factors (VIII, IX, XI, XII). Normal range: 26 – 38 seconds. Therapeutic Unfractionated Heparin target: 1.5 to 2.5 times baseline control.</p>' WHERE `test_code` = 'COAG';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Clinical Significance:</b> Prothrombin Time (PT) assesses the extrinsic (Factor VII) and common (Factors X, V, II, I) coagulation pathways. International Normalized Ratio (INR) standardizes results across thromboplastin reagents.</p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:30%; padding:2px 4px;">Clinical Indication</th>
    <th style="width:35%; padding:2px 4px;">Target Therapeutic INR Range</th>
    <th style="width:35%; padding:2px 4px;">Clinical Action Guidance</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>Normal (Not on Anticoagulants)</b></td><td style="padding:2px 4px;">0.8 – 1.2</td><td style="padding:2px 4px;">Normal baseline coagulation</td></tr>
  <tr><td style="padding:2px 4px;"><b>Standard DVT / PE / Atrial Fib</b></td><td style="padding:2px 4px;">2.0 – 3.0</td><td style="padding:2px 4px;">Standard Warfarin / Acitrom therapeutic window</td></tr>
  <tr><td style="padding:2px 4px;"><b>Mechanical Heart Valves</b></td><td style="padding:2px 4px;">2.5 – 3.5</td><td style="padding:2px 4px;">Intensive anticoagulation target</td></tr>
  <tr><td style="padding:2px 4px;"><b>INR &gt; 4.5 (High Bleeding Risk)</b></td><td style="padding:2px 4px;">Above Therapeutic Range</td><td style="padding:2px 4px;">Risk of major hemorrhage; withhold dose / administer Vitamin K per clinician advice</td></tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Note: Also prolonged in Vitamin K deficiency, liver cirrhosis / hepatocellular failure, and DIC.</i></p>
<p style="margin:3px 0 0 0;"><b>Activated Partial Thromboplastin Time (aPTT):</b> Evaluates intrinsic pathway factors (VIII, IX, XI, XII). Normal range: 26 – 38 seconds. Therapeutic Unfractionated Heparin target: 1.5 to 2.5 times baseline control.</p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'COAG'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Clinical Significance:</b> Prothrombin Time (PT) assesses the extrinsic (Factor VII) and common (Factors X, V, II, I) coagulation pathways. International Normalized Ratio (INR) standardizes results across thromboplastin reagents.</p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:30%; padding:2px 4px;">Clinical Indication</th>
    <th style="width:35%; padding:2px 4px;">Target Therapeutic INR Range</th>
    <th style="width:35%; padding:2px 4px;">Clinical Action Guidance</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>Normal (Not on Anticoagulants)</b></td><td style="padding:2px 4px;">0.8 – 1.2</td><td style="padding:2px 4px;">Normal baseline coagulation</td></tr>
  <tr><td style="padding:2px 4px;"><b>Standard DVT / PE / Atrial Fib</b></td><td style="padding:2px 4px;">2.0 – 3.0</td><td style="padding:2px 4px;">Standard Warfarin / Acitrom therapeutic window</td></tr>
  <tr><td style="padding:2px 4px;"><b>Mechanical Heart Valves</b></td><td style="padding:2px 4px;">2.5 – 3.5</td><td style="padding:2px 4px;">Intensive anticoagulation target</td></tr>
  <tr><td style="padding:2px 4px;"><b>INR &gt; 4.5 (High Bleeding Risk)</b></td><td style="padding:2px 4px;">Above Therapeutic Range</td><td style="padding:2px 4px;">Risk of major hemorrhage; withhold dose / administer Vitamin K per clinician advice</td></tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Note: Also prolonged in Vitamin K deficiency, liver cirrhosis / hepatocellular failure, and DIC.</i></p>
<p style="margin:3px 0 0 0;"><b>Activated Partial Thromboplastin Time (aPTT):</b> Evaluates intrinsic pathway factors (VIII, IX, XI, XII). Normal range: 26 – 38 seconds. Therapeutic Unfractionated Heparin target: 1.5 to 2.5 times baseline control.</p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: APTT
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Clinical Significance:</b> aPTT evaluates the intrinsic and common coagulation pathways (Factors VIII, IX, XI, XII, X, V, II, I).<br>
• <b>Prolonged aPTT:</b> Unfractionated Heparin therapy, Hemophilia A (Factor VIII deficiency), Hemophilia B (Factor IX deficiency), Von Willebrand disease, Lupus Anticoagulant, Severe liver disease.<br>
• <b>Heparin Monitoring:</b> Target therapeutic aPTT is typically 1.5 – 2.5 times the laboratory normal control value (approx. 50 – 75 seconds).</p>' WHERE `test_code` = 'APTT';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Clinical Significance:</b> aPTT evaluates the intrinsic and common coagulation pathways (Factors VIII, IX, XI, XII, X, V, II, I).<br>
• <b>Prolonged aPTT:</b> Unfractionated Heparin therapy, Hemophilia A (Factor VIII deficiency), Hemophilia B (Factor IX deficiency), Von Willebrand disease, Lupus Anticoagulant, Severe liver disease.<br>
• <b>Heparin Monitoring:</b> Target therapeutic aPTT is typically 1.5 – 2.5 times the laboratory normal control value (approx. 50 – 75 seconds).</p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'APTT'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Clinical Significance:</b> aPTT evaluates the intrinsic and common coagulation pathways (Factors VIII, IX, XI, XII, X, V, II, I).<br>
• <b>Prolonged aPTT:</b> Unfractionated Heparin therapy, Hemophilia A (Factor VIII deficiency), Hemophilia B (Factor IX deficiency), Von Willebrand disease, Lupus Anticoagulant, Severe liver disease.<br>
• <b>Heparin Monitoring:</b> Target therapeutic aPTT is typically 1.5 – 2.5 times the laboratory normal control value (approx. 50 – 75 seconds).</p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: PBS
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Clinical Significance:</b> Morphological light microscopic evaluation of stained peripheral blood smear film by Pathologist.<br>
• <b>RBC Morphology:</b> Microcytic hypochromic (Iron deficiency, Thalassemia), Macrocytic/Megaloblastic (Vit B12/Folate deficiency), Normocytic normochromic (anemia of chronic disease, acute blood loss), Sickle cells, Spherocytes, Target cells.<br>
• <b>WBC Morphology:</b> Toxic granules, vacuolation, Dohle bodies (severe sepsis); Hypersegmented neutrophils (&gt; 5 lobes: megaloblastic anemia); Blast cells, immature myeloid/lymphoid precursors (leukemia workup required).<br>
• <b>Platelet Morphology:</b> Giant platelets (ITP, Bernard-Soulier syndrome); Platelet clumping (EDTA-induced pseudothrombocytopenia, re-check in citrate).</p>' WHERE `test_code` = 'PBS';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Clinical Significance:</b> Morphological light microscopic evaluation of stained peripheral blood smear film by Pathologist.<br>
• <b>RBC Morphology:</b> Microcytic hypochromic (Iron deficiency, Thalassemia), Macrocytic/Megaloblastic (Vit B12/Folate deficiency), Normocytic normochromic (anemia of chronic disease, acute blood loss), Sickle cells, Spherocytes, Target cells.<br>
• <b>WBC Morphology:</b> Toxic granules, vacuolation, Dohle bodies (severe sepsis); Hypersegmented neutrophils (&gt; 5 lobes: megaloblastic anemia); Blast cells, immature myeloid/lymphoid precursors (leukemia workup required).<br>
• <b>Platelet Morphology:</b> Giant platelets (ITP, Bernard-Soulier syndrome); Platelet clumping (EDTA-induced pseudothrombocytopenia, re-check in citrate).</p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'PBS'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Clinical Significance:</b> Morphological light microscopic evaluation of stained peripheral blood smear film by Pathologist.<br>
• <b>RBC Morphology:</b> Microcytic hypochromic (Iron deficiency, Thalassemia), Macrocytic/Megaloblastic (Vit B12/Folate deficiency), Normocytic normochromic (anemia of chronic disease, acute blood loss), Sickle cells, Spherocytes, Target cells.<br>
• <b>WBC Morphology:</b> Toxic granules, vacuolation, Dohle bodies (severe sepsis); Hypersegmented neutrophils (&gt; 5 lobes: megaloblastic anemia); Blast cells, immature myeloid/lymphoid precursors (leukemia workup required).<br>
• <b>Platelet Morphology:</b> Giant platelets (ITP, Bernard-Soulier syndrome); Platelet clumping (EDTA-induced pseudothrombocytopenia, re-check in citrate).</p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: RETIC
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Clinical Significance:</b> Reticulocytes are young, non-nucleated RBCs containing remnant ribosomal RNA. Reflects active bone marrow erythropoiesis.<br>
• <b>Reticulocytosis (&gt; 2.5%):</b> Acute blood loss, hemolytic anemia (sickle cell, autoimmune hemolysis), or positive response to iron/vitamin B12/folate therapy within 5–7 days.<br>
• <b>Reticulocytopenia (&lt; 0.5%):</b> Bone marrow failure (Aplastic anemia, pure red cell aplasia), untreated nutritional deficiency, myelodysplastic syndrome (MDS).</p>' WHERE `test_code` = 'RETIC';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Clinical Significance:</b> Reticulocytes are young, non-nucleated RBCs containing remnant ribosomal RNA. Reflects active bone marrow erythropoiesis.<br>
• <b>Reticulocytosis (&gt; 2.5%):</b> Acute blood loss, hemolytic anemia (sickle cell, autoimmune hemolysis), or positive response to iron/vitamin B12/folate therapy within 5–7 days.<br>
• <b>Reticulocytopenia (&lt; 0.5%):</b> Bone marrow failure (Aplastic anemia, pure red cell aplasia), untreated nutritional deficiency, myelodysplastic syndrome (MDS).</p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'RETIC'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Clinical Significance:</b> Reticulocytes are young, non-nucleated RBCs containing remnant ribosomal RNA. Reflects active bone marrow erythropoiesis.<br>
• <b>Reticulocytosis (&gt; 2.5%):</b> Acute blood loss, hemolytic anemia (sickle cell, autoimmune hemolysis), or positive response to iron/vitamin B12/folate therapy within 5–7 days.<br>
• <b>Reticulocytopenia (&lt; 0.5%):</b> Bone marrow failure (Aplastic anemia, pure red cell aplasia), untreated nutritional deficiency, myelodysplastic syndrome (MDS).</p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: DDIMER
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Clinical Significance:</b> D-Dimer is a specific fibrin degradation product generated when cross-linked fibrin is degraded by plasmin. Sensitive marker for active fibrin formation and fibrinolysis.</p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:30%; padding:2px 4px;">D-Dimer Level</th>
    <th style="width:35%; padding:2px 4px;">Diagnostic Utility</th>
    <th style="width:35%; padding:2px 4px;">Clinical Significance</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>&lt; 0.50 µg/mL FEU (&lt; 500 ng/mL)</b></td><td style="padding:2px 4px;">High Negative Predictive Value (&gt; 98%)</td><td style="padding:2px 4px;">Reliably excludes Deep Vein Thrombosis (DVT) and Pulmonary Embolism (PE) in low-to-moderate pretest risk patients</td></tr>
  <tr><td style="padding:2px 4px;"><b>&gt; 0.50 µg/mL FEU</b></td><td style="padding:2px 4px;">Positive / Elevated</td><td style="padding:2px 4px;">Venous thromboembolism (DVT/PE), Disseminated Intravascular Coagulation (DIC), acute aortic dissection, severe sepsis, COVID-19 associated coagulopathy, malignancy, major trauma, pregnancy</td></tr>
</table>' WHERE `test_code` = 'DDIMER';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Clinical Significance:</b> D-Dimer is a specific fibrin degradation product generated when cross-linked fibrin is degraded by plasmin. Sensitive marker for active fibrin formation and fibrinolysis.</p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:30%; padding:2px 4px;">D-Dimer Level</th>
    <th style="width:35%; padding:2px 4px;">Diagnostic Utility</th>
    <th style="width:35%; padding:2px 4px;">Clinical Significance</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>&lt; 0.50 µg/mL FEU (&lt; 500 ng/mL)</b></td><td style="padding:2px 4px;">High Negative Predictive Value (&gt; 98%)</td><td style="padding:2px 4px;">Reliably excludes Deep Vein Thrombosis (DVT) and Pulmonary Embolism (PE) in low-to-moderate pretest risk patients</td></tr>
  <tr><td style="padding:2px 4px;"><b>&gt; 0.50 µg/mL FEU</b></td><td style="padding:2px 4px;">Positive / Elevated</td><td style="padding:2px 4px;">Venous thromboembolism (DVT/PE), Disseminated Intravascular Coagulation (DIC), acute aortic dissection, severe sepsis, COVID-19 associated coagulopathy, malignancy, major trauma, pregnancy</td></tr>
</table>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'DDIMER'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Clinical Significance:</b> D-Dimer is a specific fibrin degradation product generated when cross-linked fibrin is degraded by plasmin. Sensitive marker for active fibrin formation and fibrinolysis.</p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:30%; padding:2px 4px;">D-Dimer Level</th>
    <th style="width:35%; padding:2px 4px;">Diagnostic Utility</th>
    <th style="width:35%; padding:2px 4px;">Clinical Significance</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>&lt; 0.50 µg/mL FEU (&lt; 500 ng/mL)</b></td><td style="padding:2px 4px;">High Negative Predictive Value (&gt; 98%)</td><td style="padding:2px 4px;">Reliably excludes Deep Vein Thrombosis (DVT) and Pulmonary Embolism (PE) in low-to-moderate pretest risk patients</td></tr>
  <tr><td style="padding:2px 4px;"><b>&gt; 0.50 µg/mL FEU</b></td><td style="padding:2px 4px;">Positive / Elevated</td><td style="padding:2px 4px;">Venous thromboembolism (DVT/PE), Disseminated Intravascular Coagulation (DIC), acute aortic dissection, severe sepsis, COVID-19 associated coagulopathy, malignancy, major trauma, pregnancy</td></tr>
</table>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: FBS
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Diagnostic Criteria for Fasting Blood Glucose (ADA / WHO Guidelines):</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:30%; padding:2px 4px;">Fasting Plasma Glucose (mg/dL)</th>
    <th style="width:35%; padding:2px 4px;">Diagnostic Classification</th>
    <th style="width:35%; padding:2px 4px;">Clinical Management Recommendation</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>70 – 99 mg/dL</b></td><td style="padding:2px 4px;">Normal Fasting Glucose</td><td style="padding:2px 4px;">Routine annual health checkup</td></tr>
  <tr><td style="padding:2px 4px;"><b>100 – 125 mg/dL</b></td><td style="padding:2px 4px;">Impaired Fasting Glucose (Pre-Diabetes)</td><td style="padding:2px 4px;">Lifestyle modification, dietary intervention, repeat with HbA1c/OGTT</td></tr>
  <tr><td style="padding:2px 4px;"><b>≥ 126 mg/dL</b></td><td style="padding:2px 4px;">Provisional Diabetes Mellitus</td><td style="padding:2px 4px;">Confirm on repeat testing or correlate with HbA1c ≥ 6.5%</td></tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Pre-analytical requirement: Minimum 8 to 12 hours overnight fast. Water permitted. Hypoglycemia defined as &lt; 70 mg/dL.</i></p>' WHERE `test_code` = 'FBS';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Diagnostic Criteria for Fasting Blood Glucose (ADA / WHO Guidelines):</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:30%; padding:2px 4px;">Fasting Plasma Glucose (mg/dL)</th>
    <th style="width:35%; padding:2px 4px;">Diagnostic Classification</th>
    <th style="width:35%; padding:2px 4px;">Clinical Management Recommendation</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>70 – 99 mg/dL</b></td><td style="padding:2px 4px;">Normal Fasting Glucose</td><td style="padding:2px 4px;">Routine annual health checkup</td></tr>
  <tr><td style="padding:2px 4px;"><b>100 – 125 mg/dL</b></td><td style="padding:2px 4px;">Impaired Fasting Glucose (Pre-Diabetes)</td><td style="padding:2px 4px;">Lifestyle modification, dietary intervention, repeat with HbA1c/OGTT</td></tr>
  <tr><td style="padding:2px 4px;"><b>≥ 126 mg/dL</b></td><td style="padding:2px 4px;">Provisional Diabetes Mellitus</td><td style="padding:2px 4px;">Confirm on repeat testing or correlate with HbA1c ≥ 6.5%</td></tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Pre-analytical requirement: Minimum 8 to 12 hours overnight fast. Water permitted. Hypoglycemia defined as &lt; 70 mg/dL.</i></p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'FBS'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Diagnostic Criteria for Fasting Blood Glucose (ADA / WHO Guidelines):</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:30%; padding:2px 4px;">Fasting Plasma Glucose (mg/dL)</th>
    <th style="width:35%; padding:2px 4px;">Diagnostic Classification</th>
    <th style="width:35%; padding:2px 4px;">Clinical Management Recommendation</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>70 – 99 mg/dL</b></td><td style="padding:2px 4px;">Normal Fasting Glucose</td><td style="padding:2px 4px;">Routine annual health checkup</td></tr>
  <tr><td style="padding:2px 4px;"><b>100 – 125 mg/dL</b></td><td style="padding:2px 4px;">Impaired Fasting Glucose (Pre-Diabetes)</td><td style="padding:2px 4px;">Lifestyle modification, dietary intervention, repeat with HbA1c/OGTT</td></tr>
  <tr><td style="padding:2px 4px;"><b>≥ 126 mg/dL</b></td><td style="padding:2px 4px;">Provisional Diabetes Mellitus</td><td style="padding:2px 4px;">Confirm on repeat testing or correlate with HbA1c ≥ 6.5%</td></tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Pre-analytical requirement: Minimum 8 to 12 hours overnight fast. Water permitted. Hypoglycemia defined as &lt; 70 mg/dL.</i></p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: PPBS
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Diagnostic Criteria for 2-Hour Postprandial Glucose (ADA Guidelines):</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:30%; padding:2px 4px;">2-Hour PP Glucose (mg/dL)</th>
    <th style="width:35%; padding:2px 4px;">Diagnostic Classification</th>
    <th style="width:35%; padding:2px 4px;">Clinical Implication</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>&lt; 140 mg/dL</b></td><td style="padding:2px 4px;">Normal Postprandial Glucose</td><td style="padding:2px 4px;">Normal insulinemic response</td></tr>
  <tr><td style="padding:2px 4px;"><b>140 – 199 mg/dL</b></td><td style="padding:2px 4px;">Impaired Glucose Tolerance (Pre-Diabetes)</td><td style="padding:2px 4px;">High cardiovascular risk, insulin resistance; lifestyle modification</td></tr>
  <tr><td style="padding:2px 4px;"><b>≥ 200 mg/dL</b></td><td style="padding:2px 4px;">Provisional Diabetes Mellitus</td><td style="padding:2px 4px;">Suggests overt Diabetes Mellitus; confirm with fasting/HbA1c</td></tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Note: Sample should be collected exactly 2 hours after the start of a regular meal or 75g oral glucose load.</i></p>' WHERE `test_code` = 'PPBS';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Diagnostic Criteria for 2-Hour Postprandial Glucose (ADA Guidelines):</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:30%; padding:2px 4px;">2-Hour PP Glucose (mg/dL)</th>
    <th style="width:35%; padding:2px 4px;">Diagnostic Classification</th>
    <th style="width:35%; padding:2px 4px;">Clinical Implication</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>&lt; 140 mg/dL</b></td><td style="padding:2px 4px;">Normal Postprandial Glucose</td><td style="padding:2px 4px;">Normal insulinemic response</td></tr>
  <tr><td style="padding:2px 4px;"><b>140 – 199 mg/dL</b></td><td style="padding:2px 4px;">Impaired Glucose Tolerance (Pre-Diabetes)</td><td style="padding:2px 4px;">High cardiovascular risk, insulin resistance; lifestyle modification</td></tr>
  <tr><td style="padding:2px 4px;"><b>≥ 200 mg/dL</b></td><td style="padding:2px 4px;">Provisional Diabetes Mellitus</td><td style="padding:2px 4px;">Suggests overt Diabetes Mellitus; confirm with fasting/HbA1c</td></tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Note: Sample should be collected exactly 2 hours after the start of a regular meal or 75g oral glucose load.</i></p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'PPBS'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Diagnostic Criteria for 2-Hour Postprandial Glucose (ADA Guidelines):</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:30%; padding:2px 4px;">2-Hour PP Glucose (mg/dL)</th>
    <th style="width:35%; padding:2px 4px;">Diagnostic Classification</th>
    <th style="width:35%; padding:2px 4px;">Clinical Implication</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>&lt; 140 mg/dL</b></td><td style="padding:2px 4px;">Normal Postprandial Glucose</td><td style="padding:2px 4px;">Normal insulinemic response</td></tr>
  <tr><td style="padding:2px 4px;"><b>140 – 199 mg/dL</b></td><td style="padding:2px 4px;">Impaired Glucose Tolerance (Pre-Diabetes)</td><td style="padding:2px 4px;">High cardiovascular risk, insulin resistance; lifestyle modification</td></tr>
  <tr><td style="padding:2px 4px;"><b>≥ 200 mg/dL</b></td><td style="padding:2px 4px;">Provisional Diabetes Mellitus</td><td style="padding:2px 4px;">Suggests overt Diabetes Mellitus; confirm with fasting/HbA1c</td></tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Note: Sample should be collected exactly 2 hours after the start of a regular meal or 75g oral glucose load.</i></p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: RBS
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Random Blood Sugar (RBS) Clinical Interpretation:</b><br>
• <b>Normal:</b> 70 – 140 mg/dL (depending on time elapsed since last meal).<br>
• <b>Diabetes Mellitus:</b> Random blood glucose ≥ 200 mg/dL in the presence of classic diabetic symptoms (polyuria, polydipsia, unexplained weight loss) is diagnostic of Diabetes Mellitus.<br>
• <b>Hypoglycemia (&lt; 70 mg/dL):</b> Requires prompt clinical management, particularly in diabetic patients taking insulin or sulfonylureas.</p>' WHERE `test_code` = 'RBS';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Random Blood Sugar (RBS) Clinical Interpretation:</b><br>
• <b>Normal:</b> 70 – 140 mg/dL (depending on time elapsed since last meal).<br>
• <b>Diabetes Mellitus:</b> Random blood glucose ≥ 200 mg/dL in the presence of classic diabetic symptoms (polyuria, polydipsia, unexplained weight loss) is diagnostic of Diabetes Mellitus.<br>
• <b>Hypoglycemia (&lt; 70 mg/dL):</b> Requires prompt clinical management, particularly in diabetic patients taking insulin or sulfonylureas.</p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'RBS'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Random Blood Sugar (RBS) Clinical Interpretation:</b><br>
• <b>Normal:</b> 70 – 140 mg/dL (depending on time elapsed since last meal).<br>
• <b>Diabetes Mellitus:</b> Random blood glucose ≥ 200 mg/dL in the presence of classic diabetic symptoms (polyuria, polydipsia, unexplained weight loss) is diagnostic of Diabetes Mellitus.<br>
• <b>Hypoglycemia (&lt; 70 mg/dL):</b> Requires prompt clinical management, particularly in diabetic patients taking insulin or sulfonylureas.</p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: HBA1C
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Clinical Significance:</b> Glycated Hemoglobin (HbA1c) reflects average plasma glucose concentration over the preceding 2 to 3 months (red cell lifespan). Standardized to NGSP / IFCC reference methods.</p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:25%; padding:2px 4px;">HbA1c Range (%)</th>
    <th style="width:35%; padding:2px 4px;">Glycemic Category (ADA / RSSDI)</th>
    <th style="width:40%; padding:2px 4px;">Estimated Average Glucose (eAG)</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>&lt; 5.7 %</b></td><td style="padding:2px 4px;">Normal (Non-Diabetic)</td><td style="padding:2px 4px;">Approx. &lt; 117 mg/dL</td></tr>
  <tr><td style="padding:2px 4px;"><b>5.7 % – 6.4 %</b></td><td style="padding:2px 4px;">Pre-Diabetes (High Risk for Diabetes)</td><td style="padding:2px 4px;">117 – 137 mg/dL</td></tr>
  <tr><td style="padding:2px 4px;"><b>≥ 6.5 %</b></td><td style="padding:2px 4px;">Diabetes Mellitus (Confirmatory)</td><td style="padding:2px 4px;">≥ 140 mg/dL (eAG formula: 28.7 × HbA1c – 46.7)</td></tr>
</table>
<p style="margin:2px 0 0 0; font-size:7.5pt;"><b>Therapeutic Target for Diabetics:</b> &lt; 7.0% for most non-pregnant adults. More stringent (&lt; 6.5%) in young patients; less stringent (&lt; 8.0%) in elderly or those with hypoglycemia history.<br>
<span style="font-size:7pt; color:#64748b;"><i>Limitations: Falsely low in hemolytic anemia, pregnancy, acute blood loss. Falsely high in iron deficiency anemia, splenectomy. Hemoglobin variants (HbS, HbE, Thalassemia) may interfere depending on assay method.</i></span></p>' WHERE `test_code` = 'HBA1C';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Clinical Significance:</b> Glycated Hemoglobin (HbA1c) reflects average plasma glucose concentration over the preceding 2 to 3 months (red cell lifespan). Standardized to NGSP / IFCC reference methods.</p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:25%; padding:2px 4px;">HbA1c Range (%)</th>
    <th style="width:35%; padding:2px 4px;">Glycemic Category (ADA / RSSDI)</th>
    <th style="width:40%; padding:2px 4px;">Estimated Average Glucose (eAG)</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>&lt; 5.7 %</b></td><td style="padding:2px 4px;">Normal (Non-Diabetic)</td><td style="padding:2px 4px;">Approx. &lt; 117 mg/dL</td></tr>
  <tr><td style="padding:2px 4px;"><b>5.7 % – 6.4 %</b></td><td style="padding:2px 4px;">Pre-Diabetes (High Risk for Diabetes)</td><td style="padding:2px 4px;">117 – 137 mg/dL</td></tr>
  <tr><td style="padding:2px 4px;"><b>≥ 6.5 %</b></td><td style="padding:2px 4px;">Diabetes Mellitus (Confirmatory)</td><td style="padding:2px 4px;">≥ 140 mg/dL (eAG formula: 28.7 × HbA1c – 46.7)</td></tr>
</table>
<p style="margin:2px 0 0 0; font-size:7.5pt;"><b>Therapeutic Target for Diabetics:</b> &lt; 7.0% for most non-pregnant adults. More stringent (&lt; 6.5%) in young patients; less stringent (&lt; 8.0%) in elderly or those with hypoglycemia history.<br>
<span style="font-size:7pt; color:#64748b;"><i>Limitations: Falsely low in hemolytic anemia, pregnancy, acute blood loss. Falsely high in iron deficiency anemia, splenectomy. Hemoglobin variants (HbS, HbE, Thalassemia) may interfere depending on assay method.</i></span></p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'HBA1C'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Clinical Significance:</b> Glycated Hemoglobin (HbA1c) reflects average plasma glucose concentration over the preceding 2 to 3 months (red cell lifespan). Standardized to NGSP / IFCC reference methods.</p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:25%; padding:2px 4px;">HbA1c Range (%)</th>
    <th style="width:35%; padding:2px 4px;">Glycemic Category (ADA / RSSDI)</th>
    <th style="width:40%; padding:2px 4px;">Estimated Average Glucose (eAG)</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>&lt; 5.7 %</b></td><td style="padding:2px 4px;">Normal (Non-Diabetic)</td><td style="padding:2px 4px;">Approx. &lt; 117 mg/dL</td></tr>
  <tr><td style="padding:2px 4px;"><b>5.7 % – 6.4 %</b></td><td style="padding:2px 4px;">Pre-Diabetes (High Risk for Diabetes)</td><td style="padding:2px 4px;">117 – 137 mg/dL</td></tr>
  <tr><td style="padding:2px 4px;"><b>≥ 6.5 %</b></td><td style="padding:2px 4px;">Diabetes Mellitus (Confirmatory)</td><td style="padding:2px 4px;">≥ 140 mg/dL (eAG formula: 28.7 × HbA1c – 46.7)</td></tr>
</table>
<p style="margin:2px 0 0 0; font-size:7.5pt;"><b>Therapeutic Target for Diabetics:</b> &lt; 7.0% for most non-pregnant adults. More stringent (&lt; 6.5%) in young patients; less stringent (&lt; 8.0%) in elderly or those with hypoglycemia history.<br>
<span style="font-size:7pt; color:#64748b;"><i>Limitations: Falsely low in hemolytic anemia, pregnancy, acute blood loss. Falsely high in iron deficiency anemia, splenectomy. Hemoglobin variants (HbS, HbE, Thalassemia) may interfere depending on assay method.</i></span></p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: DIABETES
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Clinical Significance:</b> Glycated Hemoglobin (HbA1c) reflects average plasma glucose concentration over the preceding 2 to 3 months (red cell lifespan). Standardized to NGSP / IFCC reference methods.</p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:25%; padding:2px 4px;">HbA1c Range (%)</th>
    <th style="width:35%; padding:2px 4px;">Glycemic Category (ADA / RSSDI)</th>
    <th style="width:40%; padding:2px 4px;">Estimated Average Glucose (eAG)</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>&lt; 5.7 %</b></td><td style="padding:2px 4px;">Normal (Non-Diabetic)</td><td style="padding:2px 4px;">Approx. &lt; 117 mg/dL</td></tr>
  <tr><td style="padding:2px 4px;"><b>5.7 % – 6.4 %</b></td><td style="padding:2px 4px;">Pre-Diabetes (High Risk for Diabetes)</td><td style="padding:2px 4px;">117 – 137 mg/dL</td></tr>
  <tr><td style="padding:2px 4px;"><b>≥ 6.5 %</b></td><td style="padding:2px 4px;">Diabetes Mellitus (Confirmatory)</td><td style="padding:2px 4px;">≥ 140 mg/dL (eAG formula: 28.7 × HbA1c – 46.7)</td></tr>
</table>
<p style="margin:2px 0 0 0; font-size:7.5pt;"><b>Therapeutic Target for Diabetics:</b> &lt; 7.0% for most non-pregnant adults. More stringent (&lt; 6.5%) in young patients; less stringent (&lt; 8.0%) in elderly or those with hypoglycemia history.<br>
<span style="font-size:7pt; color:#64748b;"><i>Limitations: Falsely low in hemolytic anemia, pregnancy, acute blood loss. Falsely high in iron deficiency anemia, splenectomy. Hemoglobin variants (HbS, HbE, Thalassemia) may interfere depending on assay method.</i></span></p>
<p style="margin:3px 0 0 0;"><b>Comprehensive Blood Sugar Profile:</b> Combines immediate acute fasting (FBS) and postprandial (PPBS) excursions with 3-month retrospective glycemic control (HbA1c) to optimize anti-diabetic pharmacotherapy and lifestyle planning.</p>' WHERE `test_code` = 'DIABETES';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Clinical Significance:</b> Glycated Hemoglobin (HbA1c) reflects average plasma glucose concentration over the preceding 2 to 3 months (red cell lifespan). Standardized to NGSP / IFCC reference methods.</p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:25%; padding:2px 4px;">HbA1c Range (%)</th>
    <th style="width:35%; padding:2px 4px;">Glycemic Category (ADA / RSSDI)</th>
    <th style="width:40%; padding:2px 4px;">Estimated Average Glucose (eAG)</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>&lt; 5.7 %</b></td><td style="padding:2px 4px;">Normal (Non-Diabetic)</td><td style="padding:2px 4px;">Approx. &lt; 117 mg/dL</td></tr>
  <tr><td style="padding:2px 4px;"><b>5.7 % – 6.4 %</b></td><td style="padding:2px 4px;">Pre-Diabetes (High Risk for Diabetes)</td><td style="padding:2px 4px;">117 – 137 mg/dL</td></tr>
  <tr><td style="padding:2px 4px;"><b>≥ 6.5 %</b></td><td style="padding:2px 4px;">Diabetes Mellitus (Confirmatory)</td><td style="padding:2px 4px;">≥ 140 mg/dL (eAG formula: 28.7 × HbA1c – 46.7)</td></tr>
</table>
<p style="margin:2px 0 0 0; font-size:7.5pt;"><b>Therapeutic Target for Diabetics:</b> &lt; 7.0% for most non-pregnant adults. More stringent (&lt; 6.5%) in young patients; less stringent (&lt; 8.0%) in elderly or those with hypoglycemia history.<br>
<span style="font-size:7pt; color:#64748b;"><i>Limitations: Falsely low in hemolytic anemia, pregnancy, acute blood loss. Falsely high in iron deficiency anemia, splenectomy. Hemoglobin variants (HbS, HbE, Thalassemia) may interfere depending on assay method.</i></span></p>
<p style="margin:3px 0 0 0;"><b>Comprehensive Blood Sugar Profile:</b> Combines immediate acute fasting (FBS) and postprandial (PPBS) excursions with 3-month retrospective glycemic control (HbA1c) to optimize anti-diabetic pharmacotherapy and lifestyle planning.</p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'DIABETES'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Clinical Significance:</b> Glycated Hemoglobin (HbA1c) reflects average plasma glucose concentration over the preceding 2 to 3 months (red cell lifespan). Standardized to NGSP / IFCC reference methods.</p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:25%; padding:2px 4px;">HbA1c Range (%)</th>
    <th style="width:35%; padding:2px 4px;">Glycemic Category (ADA / RSSDI)</th>
    <th style="width:40%; padding:2px 4px;">Estimated Average Glucose (eAG)</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>&lt; 5.7 %</b></td><td style="padding:2px 4px;">Normal (Non-Diabetic)</td><td style="padding:2px 4px;">Approx. &lt; 117 mg/dL</td></tr>
  <tr><td style="padding:2px 4px;"><b>5.7 % – 6.4 %</b></td><td style="padding:2px 4px;">Pre-Diabetes (High Risk for Diabetes)</td><td style="padding:2px 4px;">117 – 137 mg/dL</td></tr>
  <tr><td style="padding:2px 4px;"><b>≥ 6.5 %</b></td><td style="padding:2px 4px;">Diabetes Mellitus (Confirmatory)</td><td style="padding:2px 4px;">≥ 140 mg/dL (eAG formula: 28.7 × HbA1c – 46.7)</td></tr>
</table>
<p style="margin:2px 0 0 0; font-size:7.5pt;"><b>Therapeutic Target for Diabetics:</b> &lt; 7.0% for most non-pregnant adults. More stringent (&lt; 6.5%) in young patients; less stringent (&lt; 8.0%) in elderly or those with hypoglycemia history.<br>
<span style="font-size:7pt; color:#64748b;"><i>Limitations: Falsely low in hemolytic anemia, pregnancy, acute blood loss. Falsely high in iron deficiency anemia, splenectomy. Hemoglobin variants (HbS, HbE, Thalassemia) may interfere depending on assay method.</i></span></p>
<p style="margin:3px 0 0 0;"><b>Comprehensive Blood Sugar Profile:</b> Combines immediate acute fasting (FBS) and postprandial (PPBS) excursions with 3-month retrospective glycemic control (HbA1c) to optimize anti-diabetic pharmacotherapy and lifestyle planning.</p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: OGTT
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Oral Glucose Tolerance Test (75g anhydrous oral glucose) Diagnostic Cutoffs:</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:25%; padding:2px 4px;">Category</th>
    <th style="width:35%; padding:2px 4px;">Fasting Plasma Glucose</th>
    <th style="width:40%; padding:2px 4px;">2-Hour Plasma Glucose</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>Normal</b></td><td style="padding:2px 4px;">&lt; 100 mg/dL</td><td style="padding:2px 4px;">&lt; 140 mg/dL</td></tr>
  <tr><td style="padding:2px 4px;"><b>Impaired (Pre-Diabetes)</b></td><td style="padding:2px 4px;">100 – 125 mg/dL (IFG)</td><td style="padding:2px 4px;">140 – 199 mg/dL (IGT)</td></tr>
  <tr><td style="padding:2px 4px;"><b>Diabetes Mellitus</b></td><td style="padding:2px 4px;">≥ 126 mg/dL</td><td style="padding:2px 4px;">≥ 200 mg/dL</td></tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Gestational Diabetes (DIPSI Guidelines): Single 2-hr non-fasting 75g glucose ≥ 140 mg/dL is diagnostic for GDM in pregnant women.</i></p>' WHERE `test_code` = 'OGTT';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Oral Glucose Tolerance Test (75g anhydrous oral glucose) Diagnostic Cutoffs:</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:25%; padding:2px 4px;">Category</th>
    <th style="width:35%; padding:2px 4px;">Fasting Plasma Glucose</th>
    <th style="width:40%; padding:2px 4px;">2-Hour Plasma Glucose</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>Normal</b></td><td style="padding:2px 4px;">&lt; 100 mg/dL</td><td style="padding:2px 4px;">&lt; 140 mg/dL</td></tr>
  <tr><td style="padding:2px 4px;"><b>Impaired (Pre-Diabetes)</b></td><td style="padding:2px 4px;">100 – 125 mg/dL (IFG)</td><td style="padding:2px 4px;">140 – 199 mg/dL (IGT)</td></tr>
  <tr><td style="padding:2px 4px;"><b>Diabetes Mellitus</b></td><td style="padding:2px 4px;">≥ 126 mg/dL</td><td style="padding:2px 4px;">≥ 200 mg/dL</td></tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Gestational Diabetes (DIPSI Guidelines): Single 2-hr non-fasting 75g glucose ≥ 140 mg/dL is diagnostic for GDM in pregnant women.</i></p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'OGTT'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Oral Glucose Tolerance Test (75g anhydrous oral glucose) Diagnostic Cutoffs:</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:25%; padding:2px 4px;">Category</th>
    <th style="width:35%; padding:2px 4px;">Fasting Plasma Glucose</th>
    <th style="width:40%; padding:2px 4px;">2-Hour Plasma Glucose</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>Normal</b></td><td style="padding:2px 4px;">&lt; 100 mg/dL</td><td style="padding:2px 4px;">&lt; 140 mg/dL</td></tr>
  <tr><td style="padding:2px 4px;"><b>Impaired (Pre-Diabetes)</b></td><td style="padding:2px 4px;">100 – 125 mg/dL (IFG)</td><td style="padding:2px 4px;">140 – 199 mg/dL (IGT)</td></tr>
  <tr><td style="padding:2px 4px;"><b>Diabetes Mellitus</b></td><td style="padding:2px 4px;">≥ 126 mg/dL</td><td style="padding:2px 4px;">≥ 200 mg/dL</td></tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Gestational Diabetes (DIPSI Guidelines): Single 2-hr non-fasting 75g glucose ≥ 140 mg/dL is diagnostic for GDM in pregnant women.</i></p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: CREAT
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Clinical Significance:</b> Serum Creatinine is an endogenous catabolic product of muscle creatine phosphate, eliminated primarily by glomerular filtration.</p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:25%; padding:2px 4px;">CKD Stage (KDIGO)</th>
    <th style="width:35%; padding:2px 4px;">eGFR (mL/min/1.73 m²)</th>
    <th style="width:40%; padding:2px 4px;">Kidney Function Description</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>Stage 1</b></td><td style="padding:2px 4px;">≥ 90</td><td style="padding:2px 4px;">Normal or high GFR with structural/urinary kidney damage</td></tr>
  <tr><td style="padding:2px 4px;"><b>Stage 2</b></td><td style="padding:2px 4px;">60 – 89</td><td style="padding:2px 4px;">Mild reduction in GFR with evidence of kidney damage</td></tr>
  <tr><td style="padding:2px 4px;"><b>Stage 3a / 3b</b></td><td style="padding:2px 4px;">45 – 59 / 30 – 44</td><td style="padding:2px 4px;">Moderate to severe reduction in kidney function</td></tr>
  <tr><td style="padding:2px 4px;"><b>Stage 4</b></td><td style="padding:2px 4px;">15 – 29</td><td style="padding:2px 4px;">Severely decreased GFR; preparation for renal replacement</td></tr>
  <tr><td style="padding:2px 4px;"><b>Stage 5 (ESRD)</b></td><td style="padding:2px 4px;">&lt; 15</td><td style="padding:2px 4px;">Kidney failure; dialysis or renal transplantation indicated</td></tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Creatinine levels are proportional to muscle mass; lower in elderly/malnourished and higher in athletes. Mandatory check prior to intravenous radiocontrast imaging.</i></p>' WHERE `test_code` = 'CREAT';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Clinical Significance:</b> Serum Creatinine is an endogenous catabolic product of muscle creatine phosphate, eliminated primarily by glomerular filtration.</p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:25%; padding:2px 4px;">CKD Stage (KDIGO)</th>
    <th style="width:35%; padding:2px 4px;">eGFR (mL/min/1.73 m²)</th>
    <th style="width:40%; padding:2px 4px;">Kidney Function Description</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>Stage 1</b></td><td style="padding:2px 4px;">≥ 90</td><td style="padding:2px 4px;">Normal or high GFR with structural/urinary kidney damage</td></tr>
  <tr><td style="padding:2px 4px;"><b>Stage 2</b></td><td style="padding:2px 4px;">60 – 89</td><td style="padding:2px 4px;">Mild reduction in GFR with evidence of kidney damage</td></tr>
  <tr><td style="padding:2px 4px;"><b>Stage 3a / 3b</b></td><td style="padding:2px 4px;">45 – 59 / 30 – 44</td><td style="padding:2px 4px;">Moderate to severe reduction in kidney function</td></tr>
  <tr><td style="padding:2px 4px;"><b>Stage 4</b></td><td style="padding:2px 4px;">15 – 29</td><td style="padding:2px 4px;">Severely decreased GFR; preparation for renal replacement</td></tr>
  <tr><td style="padding:2px 4px;"><b>Stage 5 (ESRD)</b></td><td style="padding:2px 4px;">&lt; 15</td><td style="padding:2px 4px;">Kidney failure; dialysis or renal transplantation indicated</td></tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Creatinine levels are proportional to muscle mass; lower in elderly/malnourished and higher in athletes. Mandatory check prior to intravenous radiocontrast imaging.</i></p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'CREAT'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Clinical Significance:</b> Serum Creatinine is an endogenous catabolic product of muscle creatine phosphate, eliminated primarily by glomerular filtration.</p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:25%; padding:2px 4px;">CKD Stage (KDIGO)</th>
    <th style="width:35%; padding:2px 4px;">eGFR (mL/min/1.73 m²)</th>
    <th style="width:40%; padding:2px 4px;">Kidney Function Description</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>Stage 1</b></td><td style="padding:2px 4px;">≥ 90</td><td style="padding:2px 4px;">Normal or high GFR with structural/urinary kidney damage</td></tr>
  <tr><td style="padding:2px 4px;"><b>Stage 2</b></td><td style="padding:2px 4px;">60 – 89</td><td style="padding:2px 4px;">Mild reduction in GFR with evidence of kidney damage</td></tr>
  <tr><td style="padding:2px 4px;"><b>Stage 3a / 3b</b></td><td style="padding:2px 4px;">45 – 59 / 30 – 44</td><td style="padding:2px 4px;">Moderate to severe reduction in kidney function</td></tr>
  <tr><td style="padding:2px 4px;"><b>Stage 4</b></td><td style="padding:2px 4px;">15 – 29</td><td style="padding:2px 4px;">Severely decreased GFR; preparation for renal replacement</td></tr>
  <tr><td style="padding:2px 4px;"><b>Stage 5 (ESRD)</b></td><td style="padding:2px 4px;">&lt; 15</td><td style="padding:2px 4px;">Kidney failure; dialysis or renal transplantation indicated</td></tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Creatinine levels are proportional to muscle mass; lower in elderly/malnourished and higher in athletes. Mandatory check prior to intravenous radiocontrast imaging.</i></p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: UREA
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Blood Urea / BUN Clinical Significance:</b> Major nitrogenous end-product of protein catabolism produced by the liver.<br>
• <b>Pre-Renal Azotemia:</b> Dehydration, hypovolemia, congestive heart failure, upper GI bleeding, high protein intake (BUN:Creatinine ratio &gt; 20:1).<br>
• <b>Renal Azotemia:</b> Acute tubular necrosis, chronic glomerulonephritis, bilateral pyelonephritis (BUN:Creatinine ratio 10–15:1).<br>
• <b>Post-Renal Azotemia:</b> Urinary tract obstruction (prostatic enlargement, calculi, tumors).</p>' WHERE `test_code` = 'UREA';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Blood Urea / BUN Clinical Significance:</b> Major nitrogenous end-product of protein catabolism produced by the liver.<br>
• <b>Pre-Renal Azotemia:</b> Dehydration, hypovolemia, congestive heart failure, upper GI bleeding, high protein intake (BUN:Creatinine ratio &gt; 20:1).<br>
• <b>Renal Azotemia:</b> Acute tubular necrosis, chronic glomerulonephritis, bilateral pyelonephritis (BUN:Creatinine ratio 10–15:1).<br>
• <b>Post-Renal Azotemia:</b> Urinary tract obstruction (prostatic enlargement, calculi, tumors).</p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'UREA'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Blood Urea / BUN Clinical Significance:</b> Major nitrogenous end-product of protein catabolism produced by the liver.<br>
• <b>Pre-Renal Azotemia:</b> Dehydration, hypovolemia, congestive heart failure, upper GI bleeding, high protein intake (BUN:Creatinine ratio &gt; 20:1).<br>
• <b>Renal Azotemia:</b> Acute tubular necrosis, chronic glomerulonephritis, bilateral pyelonephritis (BUN:Creatinine ratio 10–15:1).<br>
• <b>Post-Renal Azotemia:</b> Urinary tract obstruction (prostatic enlargement, calculi, tumors).</p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: BUN
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Blood Urea / BUN Clinical Significance:</b> Major nitrogenous end-product of protein catabolism produced by the liver.<br>
• <b>Pre-Renal Azotemia:</b> Dehydration, hypovolemia, congestive heart failure, upper GI bleeding, high protein intake (BUN:Creatinine ratio &gt; 20:1).<br>
• <b>Renal Azotemia:</b> Acute tubular necrosis, chronic glomerulonephritis, bilateral pyelonephritis (BUN:Creatinine ratio 10–15:1).<br>
• <b>Post-Renal Azotemia:</b> Urinary tract obstruction (prostatic enlargement, calculi, tumors).</p>' WHERE `test_code` = 'BUN';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Blood Urea / BUN Clinical Significance:</b> Major nitrogenous end-product of protein catabolism produced by the liver.<br>
• <b>Pre-Renal Azotemia:</b> Dehydration, hypovolemia, congestive heart failure, upper GI bleeding, high protein intake (BUN:Creatinine ratio &gt; 20:1).<br>
• <b>Renal Azotemia:</b> Acute tubular necrosis, chronic glomerulonephritis, bilateral pyelonephritis (BUN:Creatinine ratio 10–15:1).<br>
• <b>Post-Renal Azotemia:</b> Urinary tract obstruction (prostatic enlargement, calculi, tumors).</p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'BUN'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Blood Urea / BUN Clinical Significance:</b> Major nitrogenous end-product of protein catabolism produced by the liver.<br>
• <b>Pre-Renal Azotemia:</b> Dehydration, hypovolemia, congestive heart failure, upper GI bleeding, high protein intake (BUN:Creatinine ratio &gt; 20:1).<br>
• <b>Renal Azotemia:</b> Acute tubular necrosis, chronic glomerulonephritis, bilateral pyelonephritis (BUN:Creatinine ratio 10–15:1).<br>
• <b>Post-Renal Azotemia:</b> Urinary tract obstruction (prostatic enlargement, calculi, tumors).</p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: URIC
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Serum Uric Acid Clinical Interpretation:</b> End-product of purine metabolism.<br>
• <b>Hyperuricemia (&gt; 7.0 mg/dL in males, &gt; 6.0 mg/dL in females):</b> Associated with acute/chronic gout, uric acid nephrolithiasis, renal failure, pre-eclampsia, metabolic syndrome, psoriasis, and tumor lysis syndrome.<br>
• <b>Asymptomatic Hyperuricemia:</b> Does not establish a diagnosis of acute gouty arthritis without compatible joint aspirate (monosodium urate crystals) or clinical arthritis signs.</p>' WHERE `test_code` = 'URIC';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Serum Uric Acid Clinical Interpretation:</b> End-product of purine metabolism.<br>
• <b>Hyperuricemia (&gt; 7.0 mg/dL in males, &gt; 6.0 mg/dL in females):</b> Associated with acute/chronic gout, uric acid nephrolithiasis, renal failure, pre-eclampsia, metabolic syndrome, psoriasis, and tumor lysis syndrome.<br>
• <b>Asymptomatic Hyperuricemia:</b> Does not establish a diagnosis of acute gouty arthritis without compatible joint aspirate (monosodium urate crystals) or clinical arthritis signs.</p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'URIC'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Serum Uric Acid Clinical Interpretation:</b> End-product of purine metabolism.<br>
• <b>Hyperuricemia (&gt; 7.0 mg/dL in males, &gt; 6.0 mg/dL in females):</b> Associated with acute/chronic gout, uric acid nephrolithiasis, renal failure, pre-eclampsia, metabolic syndrome, psoriasis, and tumor lysis syndrome.<br>
• <b>Asymptomatic Hyperuricemia:</b> Does not establish a diagnosis of acute gouty arthritis without compatible joint aspirate (monosodium urate crystals) or clinical arthritis signs.</p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: KFT
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Clinical Significance:</b> Serum Creatinine is an endogenous catabolic product of muscle creatine phosphate, eliminated primarily by glomerular filtration.</p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:25%; padding:2px 4px;">CKD Stage (KDIGO)</th>
    <th style="width:35%; padding:2px 4px;">eGFR (mL/min/1.73 m²)</th>
    <th style="width:40%; padding:2px 4px;">Kidney Function Description</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>Stage 1</b></td><td style="padding:2px 4px;">≥ 90</td><td style="padding:2px 4px;">Normal or high GFR with structural/urinary kidney damage</td></tr>
  <tr><td style="padding:2px 4px;"><b>Stage 2</b></td><td style="padding:2px 4px;">60 – 89</td><td style="padding:2px 4px;">Mild reduction in GFR with evidence of kidney damage</td></tr>
  <tr><td style="padding:2px 4px;"><b>Stage 3a / 3b</b></td><td style="padding:2px 4px;">45 – 59 / 30 – 44</td><td style="padding:2px 4px;">Moderate to severe reduction in kidney function</td></tr>
  <tr><td style="padding:2px 4px;"><b>Stage 4</b></td><td style="padding:2px 4px;">15 – 29</td><td style="padding:2px 4px;">Severely decreased GFR; preparation for renal replacement</td></tr>
  <tr><td style="padding:2px 4px;"><b>Stage 5 (ESRD)</b></td><td style="padding:2px 4px;">&lt; 15</td><td style="padding:2px 4px;">Kidney failure; dialysis or renal transplantation indicated</td></tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Creatinine levels are proportional to muscle mass; lower in elderly/malnourished and higher in athletes. Mandatory check prior to intravenous radiocontrast imaging.</i></p>
<p style="margin:3px 0 0 0;"><b>Comprehensive KFT/RFT Panel:</b> Evaluates glomerular filtration (Creatinine, BUN, Urea), mineral metabolism (Calcium, Phosphorus), and purine catabolism (Uric Acid). Serum Electrolytes (Na, K) are recommended for complete renal assessment.</p>' WHERE `test_code` = 'KFT';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Clinical Significance:</b> Serum Creatinine is an endogenous catabolic product of muscle creatine phosphate, eliminated primarily by glomerular filtration.</p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:25%; padding:2px 4px;">CKD Stage (KDIGO)</th>
    <th style="width:35%; padding:2px 4px;">eGFR (mL/min/1.73 m²)</th>
    <th style="width:40%; padding:2px 4px;">Kidney Function Description</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>Stage 1</b></td><td style="padding:2px 4px;">≥ 90</td><td style="padding:2px 4px;">Normal or high GFR with structural/urinary kidney damage</td></tr>
  <tr><td style="padding:2px 4px;"><b>Stage 2</b></td><td style="padding:2px 4px;">60 – 89</td><td style="padding:2px 4px;">Mild reduction in GFR with evidence of kidney damage</td></tr>
  <tr><td style="padding:2px 4px;"><b>Stage 3a / 3b</b></td><td style="padding:2px 4px;">45 – 59 / 30 – 44</td><td style="padding:2px 4px;">Moderate to severe reduction in kidney function</td></tr>
  <tr><td style="padding:2px 4px;"><b>Stage 4</b></td><td style="padding:2px 4px;">15 – 29</td><td style="padding:2px 4px;">Severely decreased GFR; preparation for renal replacement</td></tr>
  <tr><td style="padding:2px 4px;"><b>Stage 5 (ESRD)</b></td><td style="padding:2px 4px;">&lt; 15</td><td style="padding:2px 4px;">Kidney failure; dialysis or renal transplantation indicated</td></tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Creatinine levels are proportional to muscle mass; lower in elderly/malnourished and higher in athletes. Mandatory check prior to intravenous radiocontrast imaging.</i></p>
<p style="margin:3px 0 0 0;"><b>Comprehensive KFT/RFT Panel:</b> Evaluates glomerular filtration (Creatinine, BUN, Urea), mineral metabolism (Calcium, Phosphorus), and purine catabolism (Uric Acid). Serum Electrolytes (Na, K) are recommended for complete renal assessment.</p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'KFT'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Clinical Significance:</b> Serum Creatinine is an endogenous catabolic product of muscle creatine phosphate, eliminated primarily by glomerular filtration.</p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:25%; padding:2px 4px;">CKD Stage (KDIGO)</th>
    <th style="width:35%; padding:2px 4px;">eGFR (mL/min/1.73 m²)</th>
    <th style="width:40%; padding:2px 4px;">Kidney Function Description</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>Stage 1</b></td><td style="padding:2px 4px;">≥ 90</td><td style="padding:2px 4px;">Normal or high GFR with structural/urinary kidney damage</td></tr>
  <tr><td style="padding:2px 4px;"><b>Stage 2</b></td><td style="padding:2px 4px;">60 – 89</td><td style="padding:2px 4px;">Mild reduction in GFR with evidence of kidney damage</td></tr>
  <tr><td style="padding:2px 4px;"><b>Stage 3a / 3b</b></td><td style="padding:2px 4px;">45 – 59 / 30 – 44</td><td style="padding:2px 4px;">Moderate to severe reduction in kidney function</td></tr>
  <tr><td style="padding:2px 4px;"><b>Stage 4</b></td><td style="padding:2px 4px;">15 – 29</td><td style="padding:2px 4px;">Severely decreased GFR; preparation for renal replacement</td></tr>
  <tr><td style="padding:2px 4px;"><b>Stage 5 (ESRD)</b></td><td style="padding:2px 4px;">&lt; 15</td><td style="padding:2px 4px;">Kidney failure; dialysis or renal transplantation indicated</td></tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Creatinine levels are proportional to muscle mass; lower in elderly/malnourished and higher in athletes. Mandatory check prior to intravenous radiocontrast imaging.</i></p>
<p style="margin:3px 0 0 0;"><b>Comprehensive KFT/RFT Panel:</b> Evaluates glomerular filtration (Creatinine, BUN, Urea), mineral metabolism (Calcium, Phosphorus), and purine catabolism (Uric Acid). Serum Electrolytes (Na, K) are recommended for complete renal assessment.</p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: ELEC
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Serum Electrolytes Interpretation:</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:25%; padding:2px 4px;">Electrolyte</th>
    <th style="width:25%; padding:2px 4px;">Reference Range</th>
    <th style="width:50%; padding:2px 4px;">Clinical Significance of Abnormal Values</th>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Sodium (Na+)</b></td>
    <td style="padding:2px 4px;">136 – 145 mmol/L</td>
    <td style="padding:2px 4px;"><b>Hyponatremia (&lt; 135):</b> SIADH, diuretic excess, cirrhosis, heart failure, Addison disease.<br><b>Hypernatremia (&gt; 145):</b> Dehydration, diabetes insipidus, excessive saline infusion.</td>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Potassium (K+)</b></td>
    <td style="padding:2px 4px;">3.5 – 5.1 mmol/L</td>
    <td style="padding:2px 4px;"><b>Hypokalemia (&lt; 3.5):</b> Diuretics, vomiting, diarrhea; risk of cardiac arrhythmias.<br><b>Hyperkalemia (&gt; 5.5):</b> Renal failure, ACE inhibitors, acidosis; critical risk of fatal cardiac arrest.</td>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Chloride (Cl-)</b></td>
    <td style="padding:2px 4px;">98 – 107 mmol/L</td>
    <td style="padding:2px 4px;">Assists in acid-base balance and serum anion gap calculation.</td>
  </tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Critical Alert: Mild hemolysis in sample artificially raises potassium markedly (pseudohyperkalemia); repeat sample required if hemolyzed.</i></p>' WHERE `test_code` = 'ELEC';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Serum Electrolytes Interpretation:</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:25%; padding:2px 4px;">Electrolyte</th>
    <th style="width:25%; padding:2px 4px;">Reference Range</th>
    <th style="width:50%; padding:2px 4px;">Clinical Significance of Abnormal Values</th>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Sodium (Na+)</b></td>
    <td style="padding:2px 4px;">136 – 145 mmol/L</td>
    <td style="padding:2px 4px;"><b>Hyponatremia (&lt; 135):</b> SIADH, diuretic excess, cirrhosis, heart failure, Addison disease.<br><b>Hypernatremia (&gt; 145):</b> Dehydration, diabetes insipidus, excessive saline infusion.</td>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Potassium (K+)</b></td>
    <td style="padding:2px 4px;">3.5 – 5.1 mmol/L</td>
    <td style="padding:2px 4px;"><b>Hypokalemia (&lt; 3.5):</b> Diuretics, vomiting, diarrhea; risk of cardiac arrhythmias.<br><b>Hyperkalemia (&gt; 5.5):</b> Renal failure, ACE inhibitors, acidosis; critical risk of fatal cardiac arrest.</td>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Chloride (Cl-)</b></td>
    <td style="padding:2px 4px;">98 – 107 mmol/L</td>
    <td style="padding:2px 4px;">Assists in acid-base balance and serum anion gap calculation.</td>
  </tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Critical Alert: Mild hemolysis in sample artificially raises potassium markedly (pseudohyperkalemia); repeat sample required if hemolyzed.</i></p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'ELEC'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Serum Electrolytes Interpretation:</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:25%; padding:2px 4px;">Electrolyte</th>
    <th style="width:25%; padding:2px 4px;">Reference Range</th>
    <th style="width:50%; padding:2px 4px;">Clinical Significance of Abnormal Values</th>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Sodium (Na+)</b></td>
    <td style="padding:2px 4px;">136 – 145 mmol/L</td>
    <td style="padding:2px 4px;"><b>Hyponatremia (&lt; 135):</b> SIADH, diuretic excess, cirrhosis, heart failure, Addison disease.<br><b>Hypernatremia (&gt; 145):</b> Dehydration, diabetes insipidus, excessive saline infusion.</td>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Potassium (K+)</b></td>
    <td style="padding:2px 4px;">3.5 – 5.1 mmol/L</td>
    <td style="padding:2px 4px;"><b>Hypokalemia (&lt; 3.5):</b> Diuretics, vomiting, diarrhea; risk of cardiac arrhythmias.<br><b>Hyperkalemia (&gt; 5.5):</b> Renal failure, ACE inhibitors, acidosis; critical risk of fatal cardiac arrest.</td>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Chloride (Cl-)</b></td>
    <td style="padding:2px 4px;">98 – 107 mmol/L</td>
    <td style="padding:2px 4px;">Assists in acid-base balance and serum anion gap calculation.</td>
  </tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Critical Alert: Mild hemolysis in sample artificially raises potassium markedly (pseudohyperkalemia); repeat sample required if hemolyzed.</i></p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: NA
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Serum Electrolytes Interpretation:</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:25%; padding:2px 4px;">Electrolyte</th>
    <th style="width:25%; padding:2px 4px;">Reference Range</th>
    <th style="width:50%; padding:2px 4px;">Clinical Significance of Abnormal Values</th>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Sodium (Na+)</b></td>
    <td style="padding:2px 4px;">136 – 145 mmol/L</td>
    <td style="padding:2px 4px;"><b>Hyponatremia (&lt; 135):</b> SIADH, diuretic excess, cirrhosis, heart failure, Addison disease.<br><b>Hypernatremia (&gt; 145):</b> Dehydration, diabetes insipidus, excessive saline infusion.</td>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Potassium (K+)</b></td>
    <td style="padding:2px 4px;">3.5 – 5.1 mmol/L</td>
    <td style="padding:2px 4px;"><b>Hypokalemia (&lt; 3.5):</b> Diuretics, vomiting, diarrhea; risk of cardiac arrhythmias.<br><b>Hyperkalemia (&gt; 5.5):</b> Renal failure, ACE inhibitors, acidosis; critical risk of fatal cardiac arrest.</td>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Chloride (Cl-)</b></td>
    <td style="padding:2px 4px;">98 – 107 mmol/L</td>
    <td style="padding:2px 4px;">Assists in acid-base balance and serum anion gap calculation.</td>
  </tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Critical Alert: Mild hemolysis in sample artificially raises potassium markedly (pseudohyperkalemia); repeat sample required if hemolyzed.</i></p>' WHERE `test_code` = 'NA';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Serum Electrolytes Interpretation:</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:25%; padding:2px 4px;">Electrolyte</th>
    <th style="width:25%; padding:2px 4px;">Reference Range</th>
    <th style="width:50%; padding:2px 4px;">Clinical Significance of Abnormal Values</th>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Sodium (Na+)</b></td>
    <td style="padding:2px 4px;">136 – 145 mmol/L</td>
    <td style="padding:2px 4px;"><b>Hyponatremia (&lt; 135):</b> SIADH, diuretic excess, cirrhosis, heart failure, Addison disease.<br><b>Hypernatremia (&gt; 145):</b> Dehydration, diabetes insipidus, excessive saline infusion.</td>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Potassium (K+)</b></td>
    <td style="padding:2px 4px;">3.5 – 5.1 mmol/L</td>
    <td style="padding:2px 4px;"><b>Hypokalemia (&lt; 3.5):</b> Diuretics, vomiting, diarrhea; risk of cardiac arrhythmias.<br><b>Hyperkalemia (&gt; 5.5):</b> Renal failure, ACE inhibitors, acidosis; critical risk of fatal cardiac arrest.</td>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Chloride (Cl-)</b></td>
    <td style="padding:2px 4px;">98 – 107 mmol/L</td>
    <td style="padding:2px 4px;">Assists in acid-base balance and serum anion gap calculation.</td>
  </tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Critical Alert: Mild hemolysis in sample artificially raises potassium markedly (pseudohyperkalemia); repeat sample required if hemolyzed.</i></p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'NA'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Serum Electrolytes Interpretation:</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:25%; padding:2px 4px;">Electrolyte</th>
    <th style="width:25%; padding:2px 4px;">Reference Range</th>
    <th style="width:50%; padding:2px 4px;">Clinical Significance of Abnormal Values</th>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Sodium (Na+)</b></td>
    <td style="padding:2px 4px;">136 – 145 mmol/L</td>
    <td style="padding:2px 4px;"><b>Hyponatremia (&lt; 135):</b> SIADH, diuretic excess, cirrhosis, heart failure, Addison disease.<br><b>Hypernatremia (&gt; 145):</b> Dehydration, diabetes insipidus, excessive saline infusion.</td>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Potassium (K+)</b></td>
    <td style="padding:2px 4px;">3.5 – 5.1 mmol/L</td>
    <td style="padding:2px 4px;"><b>Hypokalemia (&lt; 3.5):</b> Diuretics, vomiting, diarrhea; risk of cardiac arrhythmias.<br><b>Hyperkalemia (&gt; 5.5):</b> Renal failure, ACE inhibitors, acidosis; critical risk of fatal cardiac arrest.</td>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Chloride (Cl-)</b></td>
    <td style="padding:2px 4px;">98 – 107 mmol/L</td>
    <td style="padding:2px 4px;">Assists in acid-base balance and serum anion gap calculation.</td>
  </tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Critical Alert: Mild hemolysis in sample artificially raises potassium markedly (pseudohyperkalemia); repeat sample required if hemolyzed.</i></p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: K
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Serum Electrolytes Interpretation:</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:25%; padding:2px 4px;">Electrolyte</th>
    <th style="width:25%; padding:2px 4px;">Reference Range</th>
    <th style="width:50%; padding:2px 4px;">Clinical Significance of Abnormal Values</th>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Sodium (Na+)</b></td>
    <td style="padding:2px 4px;">136 – 145 mmol/L</td>
    <td style="padding:2px 4px;"><b>Hyponatremia (&lt; 135):</b> SIADH, diuretic excess, cirrhosis, heart failure, Addison disease.<br><b>Hypernatremia (&gt; 145):</b> Dehydration, diabetes insipidus, excessive saline infusion.</td>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Potassium (K+)</b></td>
    <td style="padding:2px 4px;">3.5 – 5.1 mmol/L</td>
    <td style="padding:2px 4px;"><b>Hypokalemia (&lt; 3.5):</b> Diuretics, vomiting, diarrhea; risk of cardiac arrhythmias.<br><b>Hyperkalemia (&gt; 5.5):</b> Renal failure, ACE inhibitors, acidosis; critical risk of fatal cardiac arrest.</td>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Chloride (Cl-)</b></td>
    <td style="padding:2px 4px;">98 – 107 mmol/L</td>
    <td style="padding:2px 4px;">Assists in acid-base balance and serum anion gap calculation.</td>
  </tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Critical Alert: Mild hemolysis in sample artificially raises potassium markedly (pseudohyperkalemia); repeat sample required if hemolyzed.</i></p>' WHERE `test_code` = 'K';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Serum Electrolytes Interpretation:</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:25%; padding:2px 4px;">Electrolyte</th>
    <th style="width:25%; padding:2px 4px;">Reference Range</th>
    <th style="width:50%; padding:2px 4px;">Clinical Significance of Abnormal Values</th>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Sodium (Na+)</b></td>
    <td style="padding:2px 4px;">136 – 145 mmol/L</td>
    <td style="padding:2px 4px;"><b>Hyponatremia (&lt; 135):</b> SIADH, diuretic excess, cirrhosis, heart failure, Addison disease.<br><b>Hypernatremia (&gt; 145):</b> Dehydration, diabetes insipidus, excessive saline infusion.</td>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Potassium (K+)</b></td>
    <td style="padding:2px 4px;">3.5 – 5.1 mmol/L</td>
    <td style="padding:2px 4px;"><b>Hypokalemia (&lt; 3.5):</b> Diuretics, vomiting, diarrhea; risk of cardiac arrhythmias.<br><b>Hyperkalemia (&gt; 5.5):</b> Renal failure, ACE inhibitors, acidosis; critical risk of fatal cardiac arrest.</td>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Chloride (Cl-)</b></td>
    <td style="padding:2px 4px;">98 – 107 mmol/L</td>
    <td style="padding:2px 4px;">Assists in acid-base balance and serum anion gap calculation.</td>
  </tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Critical Alert: Mild hemolysis in sample artificially raises potassium markedly (pseudohyperkalemia); repeat sample required if hemolyzed.</i></p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'K'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Serum Electrolytes Interpretation:</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:25%; padding:2px 4px;">Electrolyte</th>
    <th style="width:25%; padding:2px 4px;">Reference Range</th>
    <th style="width:50%; padding:2px 4px;">Clinical Significance of Abnormal Values</th>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Sodium (Na+)</b></td>
    <td style="padding:2px 4px;">136 – 145 mmol/L</td>
    <td style="padding:2px 4px;"><b>Hyponatremia (&lt; 135):</b> SIADH, diuretic excess, cirrhosis, heart failure, Addison disease.<br><b>Hypernatremia (&gt; 145):</b> Dehydration, diabetes insipidus, excessive saline infusion.</td>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Potassium (K+)</b></td>
    <td style="padding:2px 4px;">3.5 – 5.1 mmol/L</td>
    <td style="padding:2px 4px;"><b>Hypokalemia (&lt; 3.5):</b> Diuretics, vomiting, diarrhea; risk of cardiac arrhythmias.<br><b>Hyperkalemia (&gt; 5.5):</b> Renal failure, ACE inhibitors, acidosis; critical risk of fatal cardiac arrest.</td>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Chloride (Cl-)</b></td>
    <td style="padding:2px 4px;">98 – 107 mmol/L</td>
    <td style="padding:2px 4px;">Assists in acid-base balance and serum anion gap calculation.</td>
  </tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Critical Alert: Mild hemolysis in sample artificially raises potassium markedly (pseudohyperkalemia); repeat sample required if hemolyzed.</i></p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: CALC
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Serum Calcium Clinical Interpretation:</b> Essential for bone mineral density, neuromuscular excitability, and cardiac contraction.<br>
• <b>Hypercalcemia (&gt; 10.5 mg/dL):</b> Primary hyperparathyroidism, osteolytic malignancy/metastases, multiple myeloma, vitamin D intoxication, sarcoidosis.<br>
• <b>Hypocalcemia (&lt; 8.5 mg/dL):</b> Hypoparathyroidism, vitamin D deficiency, chronic renal failure, acute pancreatitis, malabsorption.<br>
<span style="font-size:7pt; color:#64748b;"><i>Corrected Calcium Formula: Corrected Ca = Measured Total Ca + 0.8 × (4.0 – Serum Albumin in g/dL).</i></span></p>' WHERE `test_code` = 'CALC';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Serum Calcium Clinical Interpretation:</b> Essential for bone mineral density, neuromuscular excitability, and cardiac contraction.<br>
• <b>Hypercalcemia (&gt; 10.5 mg/dL):</b> Primary hyperparathyroidism, osteolytic malignancy/metastases, multiple myeloma, vitamin D intoxication, sarcoidosis.<br>
• <b>Hypocalcemia (&lt; 8.5 mg/dL):</b> Hypoparathyroidism, vitamin D deficiency, chronic renal failure, acute pancreatitis, malabsorption.<br>
<span style="font-size:7pt; color:#64748b;"><i>Corrected Calcium Formula: Corrected Ca = Measured Total Ca + 0.8 × (4.0 – Serum Albumin in g/dL).</i></span></p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'CALC'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Serum Calcium Clinical Interpretation:</b> Essential for bone mineral density, neuromuscular excitability, and cardiac contraction.<br>
• <b>Hypercalcemia (&gt; 10.5 mg/dL):</b> Primary hyperparathyroidism, osteolytic malignancy/metastases, multiple myeloma, vitamin D intoxication, sarcoidosis.<br>
• <b>Hypocalcemia (&lt; 8.5 mg/dL):</b> Hypoparathyroidism, vitamin D deficiency, chronic renal failure, acute pancreatitis, malabsorption.<br>
<span style="font-size:7pt; color:#64748b;"><i>Corrected Calcium Formula: Corrected Ca = Measured Total Ca + 0.8 × (4.0 – Serum Albumin in g/dL).</i></span></p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: PHOS
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Serum Phosphorus Clinical Interpretation:</b> Evaluates calcium-phosphate homeostasis and parathyroid function.<br>
• <b>Hyperphosphatemia (&gt; 4.5 mg/dL):</b> Chronic renal failure (reduced excretion), hypoparathyroidism, tumor lysis syndrome, excessive vitamin D.<br>
• <b>Hypophosphatemia (&lt; 2.5 mg/dL):</b> Primary hyperparathyroidism, vitamin D deficiency (rickets/osteomalacia), refeeding syndrome, diabetic ketoacidosis recovery.</p>' WHERE `test_code` = 'PHOS';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Serum Phosphorus Clinical Interpretation:</b> Evaluates calcium-phosphate homeostasis and parathyroid function.<br>
• <b>Hyperphosphatemia (&gt; 4.5 mg/dL):</b> Chronic renal failure (reduced excretion), hypoparathyroidism, tumor lysis syndrome, excessive vitamin D.<br>
• <b>Hypophosphatemia (&lt; 2.5 mg/dL):</b> Primary hyperparathyroidism, vitamin D deficiency (rickets/osteomalacia), refeeding syndrome, diabetic ketoacidosis recovery.</p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'PHOS'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Serum Phosphorus Clinical Interpretation:</b> Evaluates calcium-phosphate homeostasis and parathyroid function.<br>
• <b>Hyperphosphatemia (&gt; 4.5 mg/dL):</b> Chronic renal failure (reduced excretion), hypoparathyroidism, tumor lysis syndrome, excessive vitamin D.<br>
• <b>Hypophosphatemia (&lt; 2.5 mg/dL):</b> Primary hyperparathyroidism, vitamin D deficiency (rickets/osteomalacia), refeeding syndrome, diabetic ketoacidosis recovery.</p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: CALPHOS
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Serum Calcium Clinical Interpretation:</b> Essential for bone mineral density, neuromuscular excitability, and cardiac contraction.<br>
• <b>Hypercalcemia (&gt; 10.5 mg/dL):</b> Primary hyperparathyroidism, osteolytic malignancy/metastases, multiple myeloma, vitamin D intoxication, sarcoidosis.<br>
• <b>Hypocalcemia (&lt; 8.5 mg/dL):</b> Hypoparathyroidism, vitamin D deficiency, chronic renal failure, acute pancreatitis, malabsorption.<br>
<span style="font-size:7pt; color:#64748b;"><i>Corrected Calcium Formula: Corrected Ca = Measured Total Ca + 0.8 × (4.0 – Serum Albumin in g/dL).</i></span></p><br><p style="margin:2px 0;"><b>Serum Phosphorus Clinical Interpretation:</b> Evaluates calcium-phosphate homeostasis and parathyroid function.<br>
• <b>Hyperphosphatemia (&gt; 4.5 mg/dL):</b> Chronic renal failure (reduced excretion), hypoparathyroidism, tumor lysis syndrome, excessive vitamin D.<br>
• <b>Hypophosphatemia (&lt; 2.5 mg/dL):</b> Primary hyperparathyroidism, vitamin D deficiency (rickets/osteomalacia), refeeding syndrome, diabetic ketoacidosis recovery.</p>' WHERE `test_code` = 'CALPHOS';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Serum Calcium Clinical Interpretation:</b> Essential for bone mineral density, neuromuscular excitability, and cardiac contraction.<br>
• <b>Hypercalcemia (&gt; 10.5 mg/dL):</b> Primary hyperparathyroidism, osteolytic malignancy/metastases, multiple myeloma, vitamin D intoxication, sarcoidosis.<br>
• <b>Hypocalcemia (&lt; 8.5 mg/dL):</b> Hypoparathyroidism, vitamin D deficiency, chronic renal failure, acute pancreatitis, malabsorption.<br>
<span style="font-size:7pt; color:#64748b;"><i>Corrected Calcium Formula: Corrected Ca = Measured Total Ca + 0.8 × (4.0 – Serum Albumin in g/dL).</i></span></p><br><p style="margin:2px 0;"><b>Serum Phosphorus Clinical Interpretation:</b> Evaluates calcium-phosphate homeostasis and parathyroid function.<br>
• <b>Hyperphosphatemia (&gt; 4.5 mg/dL):</b> Chronic renal failure (reduced excretion), hypoparathyroidism, tumor lysis syndrome, excessive vitamin D.<br>
• <b>Hypophosphatemia (&lt; 2.5 mg/dL):</b> Primary hyperparathyroidism, vitamin D deficiency (rickets/osteomalacia), refeeding syndrome, diabetic ketoacidosis recovery.</p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'CALPHOS'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Serum Calcium Clinical Interpretation:</b> Essential for bone mineral density, neuromuscular excitability, and cardiac contraction.<br>
• <b>Hypercalcemia (&gt; 10.5 mg/dL):</b> Primary hyperparathyroidism, osteolytic malignancy/metastases, multiple myeloma, vitamin D intoxication, sarcoidosis.<br>
• <b>Hypocalcemia (&lt; 8.5 mg/dL):</b> Hypoparathyroidism, vitamin D deficiency, chronic renal failure, acute pancreatitis, malabsorption.<br>
<span style="font-size:7pt; color:#64748b;"><i>Corrected Calcium Formula: Corrected Ca = Measured Total Ca + 0.8 × (4.0 – Serum Albumin in g/dL).</i></span></p><br><p style="margin:2px 0;"><b>Serum Phosphorus Clinical Interpretation:</b> Evaluates calcium-phosphate homeostasis and parathyroid function.<br>
• <b>Hyperphosphatemia (&gt; 4.5 mg/dL):</b> Chronic renal failure (reduced excretion), hypoparathyroidism, tumor lysis syndrome, excessive vitamin D.<br>
• <b>Hypophosphatemia (&lt; 2.5 mg/dL):</b> Primary hyperparathyroidism, vitamin D deficiency (rickets/osteomalacia), refeeding syndrome, diabetic ketoacidosis recovery.</p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: LFT
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Liver Function Panel Clinical Pattern Differentiation:</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:25%; padding:2px 4px;">Pattern Type</th>
    <th style="width:35%; padding:2px 4px;">Predominant Enzyme Elevation</th>
    <th style="width:40%; padding:2px 4px;">Common Etiologies</th>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Hepatocellular Injury</b></td>
    <td style="padding:2px 4px;"><b>SGPT (ALT) &gt; SGOT (AST)</b> (markedly high, often &gt; 5–10× ULN)</td>
    <td style="padding:2px 4px;">Acute viral hepatitis (Hep A, B, E), drug-induced liver injury (Paracetamol, ATT), ischemic hepatitis, NAFLD/NASH</td>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Alcoholic Liver Disease</b></td>
    <td style="padding:2px 4px;"><b>SGOT (AST) &gt; SGPT (ALT)</b> (De Ritis ratio &gt; 2:1) + high GGT</td>
    <td style="padding:2px 4px;">Alcoholic hepatitis, alcoholic cirrhosis</td>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Cholestatic / Obstructive</b></td>
    <td style="padding:2px 4px;"><b>Alkaline Phosphatase (ALP) &amp; GGT</b> markedly elevated &gt;&gt; transaminases</td>
    <td style="padding:2px 4px;">Choledocholithiasis (CBD stone), biliary stricture, carcinoma head of pancreas, primary biliary cholangitis</td>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Hepatic Synthetic Failure</b></td>
    <td style="padding:2px 4px;">Low Albumin, Reversed A/G ratio, Prolonged Prothrombin Time (PT/INR)</td>
    <td style="padding:2px 4px;">Decompensated liver cirrhosis, acute fulminant liver failure</td>
  </tr>
</table>' WHERE `test_code` = 'LFT';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Liver Function Panel Clinical Pattern Differentiation:</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:25%; padding:2px 4px;">Pattern Type</th>
    <th style="width:35%; padding:2px 4px;">Predominant Enzyme Elevation</th>
    <th style="width:40%; padding:2px 4px;">Common Etiologies</th>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Hepatocellular Injury</b></td>
    <td style="padding:2px 4px;"><b>SGPT (ALT) &gt; SGOT (AST)</b> (markedly high, often &gt; 5–10× ULN)</td>
    <td style="padding:2px 4px;">Acute viral hepatitis (Hep A, B, E), drug-induced liver injury (Paracetamol, ATT), ischemic hepatitis, NAFLD/NASH</td>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Alcoholic Liver Disease</b></td>
    <td style="padding:2px 4px;"><b>SGOT (AST) &gt; SGPT (ALT)</b> (De Ritis ratio &gt; 2:1) + high GGT</td>
    <td style="padding:2px 4px;">Alcoholic hepatitis, alcoholic cirrhosis</td>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Cholestatic / Obstructive</b></td>
    <td style="padding:2px 4px;"><b>Alkaline Phosphatase (ALP) &amp; GGT</b> markedly elevated &gt;&gt; transaminases</td>
    <td style="padding:2px 4px;">Choledocholithiasis (CBD stone), biliary stricture, carcinoma head of pancreas, primary biliary cholangitis</td>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Hepatic Synthetic Failure</b></td>
    <td style="padding:2px 4px;">Low Albumin, Reversed A/G ratio, Prolonged Prothrombin Time (PT/INR)</td>
    <td style="padding:2px 4px;">Decompensated liver cirrhosis, acute fulminant liver failure</td>
  </tr>
</table>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'LFT'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Liver Function Panel Clinical Pattern Differentiation:</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:25%; padding:2px 4px;">Pattern Type</th>
    <th style="width:35%; padding:2px 4px;">Predominant Enzyme Elevation</th>
    <th style="width:40%; padding:2px 4px;">Common Etiologies</th>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Hepatocellular Injury</b></td>
    <td style="padding:2px 4px;"><b>SGPT (ALT) &gt; SGOT (AST)</b> (markedly high, often &gt; 5–10× ULN)</td>
    <td style="padding:2px 4px;">Acute viral hepatitis (Hep A, B, E), drug-induced liver injury (Paracetamol, ATT), ischemic hepatitis, NAFLD/NASH</td>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Alcoholic Liver Disease</b></td>
    <td style="padding:2px 4px;"><b>SGOT (AST) &gt; SGPT (ALT)</b> (De Ritis ratio &gt; 2:1) + high GGT</td>
    <td style="padding:2px 4px;">Alcoholic hepatitis, alcoholic cirrhosis</td>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Cholestatic / Obstructive</b></td>
    <td style="padding:2px 4px;"><b>Alkaline Phosphatase (ALP) &amp; GGT</b> markedly elevated &gt;&gt; transaminases</td>
    <td style="padding:2px 4px;">Choledocholithiasis (CBD stone), biliary stricture, carcinoma head of pancreas, primary biliary cholangitis</td>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Hepatic Synthetic Failure</b></td>
    <td style="padding:2px 4px;">Low Albumin, Reversed A/G ratio, Prolonged Prothrombin Time (PT/INR)</td>
    <td style="padding:2px 4px;">Decompensated liver cirrhosis, acute fulminant liver failure</td>
  </tr>
</table>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: BILIRUBIN
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Serum Bilirubin Clinical Interpretation:</b><br>
• <b>Predominantly Unconjugated (Indirect) Hyperbilirubinemia:</b> Hemolytic disorders (G6PD deficiency, hereditary spherocytosis, autoimmune hemolysis), neonatal jaundice, Gilbert syndrome.<br>
• <b>Predominantly Conjugated (Direct) Hyperbilirubinemia (&gt; 50% of total):</b> Extrahepatic biliary obstruction (gallstones, stricture, pancreatic tumor), intrahepatic cholestasis (viral hepatitis, drugs, sepsis).<br>
• <b>Mixed Hyperbilirubinemia:</b> Acute hepatocellular necrosis, advanced cirrhosis.</p>' WHERE `test_code` = 'BILIRUBIN';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Serum Bilirubin Clinical Interpretation:</b><br>
• <b>Predominantly Unconjugated (Indirect) Hyperbilirubinemia:</b> Hemolytic disorders (G6PD deficiency, hereditary spherocytosis, autoimmune hemolysis), neonatal jaundice, Gilbert syndrome.<br>
• <b>Predominantly Conjugated (Direct) Hyperbilirubinemia (&gt; 50% of total):</b> Extrahepatic biliary obstruction (gallstones, stricture, pancreatic tumor), intrahepatic cholestasis (viral hepatitis, drugs, sepsis).<br>
• <b>Mixed Hyperbilirubinemia:</b> Acute hepatocellular necrosis, advanced cirrhosis.</p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'BILIRUBIN'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Serum Bilirubin Clinical Interpretation:</b><br>
• <b>Predominantly Unconjugated (Indirect) Hyperbilirubinemia:</b> Hemolytic disorders (G6PD deficiency, hereditary spherocytosis, autoimmune hemolysis), neonatal jaundice, Gilbert syndrome.<br>
• <b>Predominantly Conjugated (Direct) Hyperbilirubinemia (&gt; 50% of total):</b> Extrahepatic biliary obstruction (gallstones, stricture, pancreatic tumor), intrahepatic cholestasis (viral hepatitis, drugs, sepsis).<br>
• <b>Mixed Hyperbilirubinemia:</b> Acute hepatocellular necrosis, advanced cirrhosis.</p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: SGOT
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>SGOT / AST Clinical Significance:</b> Enzyme present in liver, cardiac muscle, skeletal muscle, and kidneys.<br>
• <b>Marked Elevation (&gt; 1000 U/L):</b> Acute ischemic hepatitis, paracetamol toxicity, severe acute viral hepatitis.<br>
• <b>Moderate Elevation (100 – 500 U/L):</b> Alcoholic hepatitis (AST/ALT ratio typically &gt; 2), acute pancreatitis, skeletal muscle trauma/rhabdomyolysis, myocardial infarction.<br>
• <b>Mild Elevation (&lt; 100 U/L):</b> Chronic hepatitis, non-alcoholic fatty liver disease (NAFLD), cirrhosis.</p>' WHERE `test_code` = 'SGOT';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>SGOT / AST Clinical Significance:</b> Enzyme present in liver, cardiac muscle, skeletal muscle, and kidneys.<br>
• <b>Marked Elevation (&gt; 1000 U/L):</b> Acute ischemic hepatitis, paracetamol toxicity, severe acute viral hepatitis.<br>
• <b>Moderate Elevation (100 – 500 U/L):</b> Alcoholic hepatitis (AST/ALT ratio typically &gt; 2), acute pancreatitis, skeletal muscle trauma/rhabdomyolysis, myocardial infarction.<br>
• <b>Mild Elevation (&lt; 100 U/L):</b> Chronic hepatitis, non-alcoholic fatty liver disease (NAFLD), cirrhosis.</p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'SGOT'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>SGOT / AST Clinical Significance:</b> Enzyme present in liver, cardiac muscle, skeletal muscle, and kidneys.<br>
• <b>Marked Elevation (&gt; 1000 U/L):</b> Acute ischemic hepatitis, paracetamol toxicity, severe acute viral hepatitis.<br>
• <b>Moderate Elevation (100 – 500 U/L):</b> Alcoholic hepatitis (AST/ALT ratio typically &gt; 2), acute pancreatitis, skeletal muscle trauma/rhabdomyolysis, myocardial infarction.<br>
• <b>Mild Elevation (&lt; 100 U/L):</b> Chronic hepatitis, non-alcoholic fatty liver disease (NAFLD), cirrhosis.</p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: SGPT
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>SGPT / ALT Clinical Significance:</b> Highly specific marker for hepatocellular injury localized predominantly in liver parenchymal cells.<br>
• <b>Very High (&gt; 10× ULN):</b> Acute viral hepatitis (A, B, C, E), toxin/drug-induced liver damage, severe hypotension/shock liver.<br>
• <b>Mild-to-Moderate Elevation:</b> Non-Alcoholic Fatty Liver Disease (NAFLD / NASH), chronic hepatitis B/C, obesity, statin or NSAID use.</p>' WHERE `test_code` = 'SGPT';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>SGPT / ALT Clinical Significance:</b> Highly specific marker for hepatocellular injury localized predominantly in liver parenchymal cells.<br>
• <b>Very High (&gt; 10× ULN):</b> Acute viral hepatitis (A, B, C, E), toxin/drug-induced liver damage, severe hypotension/shock liver.<br>
• <b>Mild-to-Moderate Elevation:</b> Non-Alcoholic Fatty Liver Disease (NAFLD / NASH), chronic hepatitis B/C, obesity, statin or NSAID use.</p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'SGPT'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>SGPT / ALT Clinical Significance:</b> Highly specific marker for hepatocellular injury localized predominantly in liver parenchymal cells.<br>
• <b>Very High (&gt; 10× ULN):</b> Acute viral hepatitis (A, B, C, E), toxin/drug-induced liver damage, severe hypotension/shock liver.<br>
• <b>Mild-to-Moderate Elevation:</b> Non-Alcoholic Fatty Liver Disease (NAFLD / NASH), chronic hepatitis B/C, obesity, statin or NSAID use.</p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: ALP
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Alkaline Phosphatase (ALP) Clinical Significance:</b> Originates primarily from bile canalicular membranes and osteoblasts.<br>
• <b>Hepatobiliary Disorders:</b> Biliary obstruction, choledocholithiasis, primary sclerosing cholangitis, drug-induced cholestasis (correlate with high GGT).<br>
• <b>Bone Pathologies (normal GGT):</b> Paget disease of bone, osteoblastic metastases, rickets/osteomalacia, healing fractures, hyperparathyroidism.<br>
<span style="font-size:7pt; color:#64748b;"><i>Physiologically elevated in growing children (active bone growth) and normal 3rd trimester pregnancy (placental ALP).</i></span></p>' WHERE `test_code` = 'ALP';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Alkaline Phosphatase (ALP) Clinical Significance:</b> Originates primarily from bile canalicular membranes and osteoblasts.<br>
• <b>Hepatobiliary Disorders:</b> Biliary obstruction, choledocholithiasis, primary sclerosing cholangitis, drug-induced cholestasis (correlate with high GGT).<br>
• <b>Bone Pathologies (normal GGT):</b> Paget disease of bone, osteoblastic metastases, rickets/osteomalacia, healing fractures, hyperparathyroidism.<br>
<span style="font-size:7pt; color:#64748b;"><i>Physiologically elevated in growing children (active bone growth) and normal 3rd trimester pregnancy (placental ALP).</i></span></p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'ALP'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Alkaline Phosphatase (ALP) Clinical Significance:</b> Originates primarily from bile canalicular membranes and osteoblasts.<br>
• <b>Hepatobiliary Disorders:</b> Biliary obstruction, choledocholithiasis, primary sclerosing cholangitis, drug-induced cholestasis (correlate with high GGT).<br>
• <b>Bone Pathologies (normal GGT):</b> Paget disease of bone, osteoblastic metastases, rickets/osteomalacia, healing fractures, hyperparathyroidism.<br>
<span style="font-size:7pt; color:#64748b;"><i>Physiologically elevated in growing children (active bone growth) and normal 3rd trimester pregnancy (placental ALP).</i></span></p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: GGT
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Gamma-Glutamyl Transferase (GGT) Clinical Significance:</b> Sensitive biliary enzyme.<br>
• Confirms hepatobiliary origin of elevated Alkaline Phosphatase (ALP is high, GGT is high → liver; ALP high, GGT normal → bone).<br>
• Most sensitive biomarker for heavy or chronic alcohol ingestion and alcoholic liver injury.</p>' WHERE `test_code` = 'GGT';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Gamma-Glutamyl Transferase (GGT) Clinical Significance:</b> Sensitive biliary enzyme.<br>
• Confirms hepatobiliary origin of elevated Alkaline Phosphatase (ALP is high, GGT is high → liver; ALP high, GGT normal → bone).<br>
• Most sensitive biomarker for heavy or chronic alcohol ingestion and alcoholic liver injury.</p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'GGT'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Gamma-Glutamyl Transferase (GGT) Clinical Significance:</b> Sensitive biliary enzyme.<br>
• Confirms hepatobiliary origin of elevated Alkaline Phosphatase (ALP is high, GGT is high → liver; ALP high, GGT normal → bone).<br>
• Most sensitive biomarker for heavy or chronic alcohol ingestion and alcoholic liver injury.</p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: PROTEIN
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Total Protein, Albumin &amp; A/G Ratio Significance:</b><br>
• <b>Hypoalbuminemia (&lt; 3.5 g/dL):</b> Impaired liver synthesis (cirrhosis), renal urinary loss (nephrotic syndrome), GI loss (protein-losing enteropathy), malnutrition.<br>
• <b>Hypergammaglobulinemia / Inverted A/G Ratio (&lt; 1.0):</b> Multiple myeloma, chronic active hepatitis, cirrhosis, severe chronic systemic infections.<br>
• <b>Monoclonal Spike:</b> Serum protein electrophoresis (SPEP) recommended if Total Protein is elevated with normal Albumin.</p>' WHERE `test_code` = 'PROTEIN';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Total Protein, Albumin &amp; A/G Ratio Significance:</b><br>
• <b>Hypoalbuminemia (&lt; 3.5 g/dL):</b> Impaired liver synthesis (cirrhosis), renal urinary loss (nephrotic syndrome), GI loss (protein-losing enteropathy), malnutrition.<br>
• <b>Hypergammaglobulinemia / Inverted A/G Ratio (&lt; 1.0):</b> Multiple myeloma, chronic active hepatitis, cirrhosis, severe chronic systemic infections.<br>
• <b>Monoclonal Spike:</b> Serum protein electrophoresis (SPEP) recommended if Total Protein is elevated with normal Albumin.</p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'PROTEIN'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Total Protein, Albumin &amp; A/G Ratio Significance:</b><br>
• <b>Hypoalbuminemia (&lt; 3.5 g/dL):</b> Impaired liver synthesis (cirrhosis), renal urinary loss (nephrotic syndrome), GI loss (protein-losing enteropathy), malnutrition.<br>
• <b>Hypergammaglobulinemia / Inverted A/G Ratio (&lt; 1.0):</b> Multiple myeloma, chronic active hepatitis, cirrhosis, severe chronic systemic infections.<br>
• <b>Monoclonal Spike:</b> Serum protein electrophoresis (SPEP) recommended if Total Protein is elevated with normal Albumin.</p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: LIPID
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Cardiovascular Risk Stratification (NCEP ATP-III / Indian Consensus Guidelines):</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:25%; padding:2px 4px;">Lipid Fraction</th>
    <th style="width:25%; padding:2px 4px;">Optimal / Desirable</th>
    <th style="width:25%; padding:2px 4px;">Borderline High</th>
    <th style="width:25%; padding:2px 4px;">High Risk</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>Total Cholesterol</b></td><td style="padding:2px 4px;">&lt; 200 mg/dL</td><td style="padding:2px 4px;">200 – 239 mg/dL</td><td style="padding:2px 4px;">≥ 240 mg/dL</td></tr>
  <tr><td style="padding:2px 4px;"><b>Triglycerides</b></td><td style="padding:2px 4px;">&lt; 150 mg/dL</td><td style="padding:2px 4px;">150 – 199 mg/dL</td><td style="padding:2px 4px;">200 – 499 mg/dL (≥ 500 pancreatitis risk)</td></tr>
  <tr><td style="padding:2px 4px;"><b>HDL Cholesterol (Good)</b></td><td style="padding:2px 4px;">&gt; 50 mg/dL (protective)</td><td style="padding:2px 4px;">40 – 50 mg/dL</td><td style="padding:2px 4px;">&lt; 40 mg/dL (Major risk factor for CAD)</td></tr>
  <tr><td style="padding:2px 4px;"><b>LDL Cholesterol (Bad)</b></td><td style="padding:2px 4px;">&lt; 100 mg/dL (CAD: &lt; 70)</td><td style="padding:2px 4px;">100 – 129 mg/dL</td><td style="padding:2px 4px;">130 – 159 (Borderline), ≥ 160 mg/dL (High)</td></tr>
  <tr><td style="padding:2px 4px;"><b>VLDL Cholesterol</b></td><td style="padding:2px 4px;">&lt; 30 mg/dL</td><td style="padding:2px 4px;">30 – 40 mg/dL</td><td style="padding:2px 4px;">&gt; 40 mg/dL</td></tr>
</table>
<p style="margin:2px 0 0 0; font-size:7.5pt;"><b>Ratios:</b> Total Chol / HDL ratio &lt; 3.5 is desirable (CAD risk increases &gt; 4.5). LDL / HDL ratio &lt; 2.5 is optimal.<br>
<span style="font-size:7pt; color:#64748b;"><i>Requirement: 10 – 12 hours overnight fasting. If Triglycerides &gt; 400 mg/dL, calculated LDL (Friedewald) is invalid; direct LDL assay is advised.</i></span></p>' WHERE `test_code` = 'LIPID';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Cardiovascular Risk Stratification (NCEP ATP-III / Indian Consensus Guidelines):</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:25%; padding:2px 4px;">Lipid Fraction</th>
    <th style="width:25%; padding:2px 4px;">Optimal / Desirable</th>
    <th style="width:25%; padding:2px 4px;">Borderline High</th>
    <th style="width:25%; padding:2px 4px;">High Risk</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>Total Cholesterol</b></td><td style="padding:2px 4px;">&lt; 200 mg/dL</td><td style="padding:2px 4px;">200 – 239 mg/dL</td><td style="padding:2px 4px;">≥ 240 mg/dL</td></tr>
  <tr><td style="padding:2px 4px;"><b>Triglycerides</b></td><td style="padding:2px 4px;">&lt; 150 mg/dL</td><td style="padding:2px 4px;">150 – 199 mg/dL</td><td style="padding:2px 4px;">200 – 499 mg/dL (≥ 500 pancreatitis risk)</td></tr>
  <tr><td style="padding:2px 4px;"><b>HDL Cholesterol (Good)</b></td><td style="padding:2px 4px;">&gt; 50 mg/dL (protective)</td><td style="padding:2px 4px;">40 – 50 mg/dL</td><td style="padding:2px 4px;">&lt; 40 mg/dL (Major risk factor for CAD)</td></tr>
  <tr><td style="padding:2px 4px;"><b>LDL Cholesterol (Bad)</b></td><td style="padding:2px 4px;">&lt; 100 mg/dL (CAD: &lt; 70)</td><td style="padding:2px 4px;">100 – 129 mg/dL</td><td style="padding:2px 4px;">130 – 159 (Borderline), ≥ 160 mg/dL (High)</td></tr>
  <tr><td style="padding:2px 4px;"><b>VLDL Cholesterol</b></td><td style="padding:2px 4px;">&lt; 30 mg/dL</td><td style="padding:2px 4px;">30 – 40 mg/dL</td><td style="padding:2px 4px;">&gt; 40 mg/dL</td></tr>
</table>
<p style="margin:2px 0 0 0; font-size:7.5pt;"><b>Ratios:</b> Total Chol / HDL ratio &lt; 3.5 is desirable (CAD risk increases &gt; 4.5). LDL / HDL ratio &lt; 2.5 is optimal.<br>
<span style="font-size:7pt; color:#64748b;"><i>Requirement: 10 – 12 hours overnight fasting. If Triglycerides &gt; 400 mg/dL, calculated LDL (Friedewald) is invalid; direct LDL assay is advised.</i></span></p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'LIPID'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Cardiovascular Risk Stratification (NCEP ATP-III / Indian Consensus Guidelines):</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:25%; padding:2px 4px;">Lipid Fraction</th>
    <th style="width:25%; padding:2px 4px;">Optimal / Desirable</th>
    <th style="width:25%; padding:2px 4px;">Borderline High</th>
    <th style="width:25%; padding:2px 4px;">High Risk</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>Total Cholesterol</b></td><td style="padding:2px 4px;">&lt; 200 mg/dL</td><td style="padding:2px 4px;">200 – 239 mg/dL</td><td style="padding:2px 4px;">≥ 240 mg/dL</td></tr>
  <tr><td style="padding:2px 4px;"><b>Triglycerides</b></td><td style="padding:2px 4px;">&lt; 150 mg/dL</td><td style="padding:2px 4px;">150 – 199 mg/dL</td><td style="padding:2px 4px;">200 – 499 mg/dL (≥ 500 pancreatitis risk)</td></tr>
  <tr><td style="padding:2px 4px;"><b>HDL Cholesterol (Good)</b></td><td style="padding:2px 4px;">&gt; 50 mg/dL (protective)</td><td style="padding:2px 4px;">40 – 50 mg/dL</td><td style="padding:2px 4px;">&lt; 40 mg/dL (Major risk factor for CAD)</td></tr>
  <tr><td style="padding:2px 4px;"><b>LDL Cholesterol (Bad)</b></td><td style="padding:2px 4px;">&lt; 100 mg/dL (CAD: &lt; 70)</td><td style="padding:2px 4px;">100 – 129 mg/dL</td><td style="padding:2px 4px;">130 – 159 (Borderline), ≥ 160 mg/dL (High)</td></tr>
  <tr><td style="padding:2px 4px;"><b>VLDL Cholesterol</b></td><td style="padding:2px 4px;">&lt; 30 mg/dL</td><td style="padding:2px 4px;">30 – 40 mg/dL</td><td style="padding:2px 4px;">&gt; 40 mg/dL</td></tr>
</table>
<p style="margin:2px 0 0 0; font-size:7.5pt;"><b>Ratios:</b> Total Chol / HDL ratio &lt; 3.5 is desirable (CAD risk increases &gt; 4.5). LDL / HDL ratio &lt; 2.5 is optimal.<br>
<span style="font-size:7pt; color:#64748b;"><i>Requirement: 10 – 12 hours overnight fasting. If Triglycerides &gt; 400 mg/dL, calculated LDL (Friedewald) is invalid; direct LDL assay is advised.</i></span></p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: CHOL
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Cardiovascular Risk Stratification (NCEP ATP-III / Indian Consensus Guidelines):</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:25%; padding:2px 4px;">Lipid Fraction</th>
    <th style="width:25%; padding:2px 4px;">Optimal / Desirable</th>
    <th style="width:25%; padding:2px 4px;">Borderline High</th>
    <th style="width:25%; padding:2px 4px;">High Risk</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>Total Cholesterol</b></td><td style="padding:2px 4px;">&lt; 200 mg/dL</td><td style="padding:2px 4px;">200 – 239 mg/dL</td><td style="padding:2px 4px;">≥ 240 mg/dL</td></tr>
  <tr><td style="padding:2px 4px;"><b>Triglycerides</b></td><td style="padding:2px 4px;">&lt; 150 mg/dL</td><td style="padding:2px 4px;">150 – 199 mg/dL</td><td style="padding:2px 4px;">200 – 499 mg/dL (≥ 500 pancreatitis risk)</td></tr>
  <tr><td style="padding:2px 4px;"><b>HDL Cholesterol (Good)</b></td><td style="padding:2px 4px;">&gt; 50 mg/dL (protective)</td><td style="padding:2px 4px;">40 – 50 mg/dL</td><td style="padding:2px 4px;">&lt; 40 mg/dL (Major risk factor for CAD)</td></tr>
  <tr><td style="padding:2px 4px;"><b>LDL Cholesterol (Bad)</b></td><td style="padding:2px 4px;">&lt; 100 mg/dL (CAD: &lt; 70)</td><td style="padding:2px 4px;">100 – 129 mg/dL</td><td style="padding:2px 4px;">130 – 159 (Borderline), ≥ 160 mg/dL (High)</td></tr>
  <tr><td style="padding:2px 4px;"><b>VLDL Cholesterol</b></td><td style="padding:2px 4px;">&lt; 30 mg/dL</td><td style="padding:2px 4px;">30 – 40 mg/dL</td><td style="padding:2px 4px;">&gt; 40 mg/dL</td></tr>
</table>
<p style="margin:2px 0 0 0; font-size:7.5pt;"><b>Ratios:</b> Total Chol / HDL ratio &lt; 3.5 is desirable (CAD risk increases &gt; 4.5). LDL / HDL ratio &lt; 2.5 is optimal.<br>
<span style="font-size:7pt; color:#64748b;"><i>Requirement: 10 – 12 hours overnight fasting. If Triglycerides &gt; 400 mg/dL, calculated LDL (Friedewald) is invalid; direct LDL assay is advised.</i></span></p>' WHERE `test_code` = 'CHOL';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Cardiovascular Risk Stratification (NCEP ATP-III / Indian Consensus Guidelines):</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:25%; padding:2px 4px;">Lipid Fraction</th>
    <th style="width:25%; padding:2px 4px;">Optimal / Desirable</th>
    <th style="width:25%; padding:2px 4px;">Borderline High</th>
    <th style="width:25%; padding:2px 4px;">High Risk</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>Total Cholesterol</b></td><td style="padding:2px 4px;">&lt; 200 mg/dL</td><td style="padding:2px 4px;">200 – 239 mg/dL</td><td style="padding:2px 4px;">≥ 240 mg/dL</td></tr>
  <tr><td style="padding:2px 4px;"><b>Triglycerides</b></td><td style="padding:2px 4px;">&lt; 150 mg/dL</td><td style="padding:2px 4px;">150 – 199 mg/dL</td><td style="padding:2px 4px;">200 – 499 mg/dL (≥ 500 pancreatitis risk)</td></tr>
  <tr><td style="padding:2px 4px;"><b>HDL Cholesterol (Good)</b></td><td style="padding:2px 4px;">&gt; 50 mg/dL (protective)</td><td style="padding:2px 4px;">40 – 50 mg/dL</td><td style="padding:2px 4px;">&lt; 40 mg/dL (Major risk factor for CAD)</td></tr>
  <tr><td style="padding:2px 4px;"><b>LDL Cholesterol (Bad)</b></td><td style="padding:2px 4px;">&lt; 100 mg/dL (CAD: &lt; 70)</td><td style="padding:2px 4px;">100 – 129 mg/dL</td><td style="padding:2px 4px;">130 – 159 (Borderline), ≥ 160 mg/dL (High)</td></tr>
  <tr><td style="padding:2px 4px;"><b>VLDL Cholesterol</b></td><td style="padding:2px 4px;">&lt; 30 mg/dL</td><td style="padding:2px 4px;">30 – 40 mg/dL</td><td style="padding:2px 4px;">&gt; 40 mg/dL</td></tr>
</table>
<p style="margin:2px 0 0 0; font-size:7.5pt;"><b>Ratios:</b> Total Chol / HDL ratio &lt; 3.5 is desirable (CAD risk increases &gt; 4.5). LDL / HDL ratio &lt; 2.5 is optimal.<br>
<span style="font-size:7pt; color:#64748b;"><i>Requirement: 10 – 12 hours overnight fasting. If Triglycerides &gt; 400 mg/dL, calculated LDL (Friedewald) is invalid; direct LDL assay is advised.</i></span></p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'CHOL'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Cardiovascular Risk Stratification (NCEP ATP-III / Indian Consensus Guidelines):</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:25%; padding:2px 4px;">Lipid Fraction</th>
    <th style="width:25%; padding:2px 4px;">Optimal / Desirable</th>
    <th style="width:25%; padding:2px 4px;">Borderline High</th>
    <th style="width:25%; padding:2px 4px;">High Risk</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>Total Cholesterol</b></td><td style="padding:2px 4px;">&lt; 200 mg/dL</td><td style="padding:2px 4px;">200 – 239 mg/dL</td><td style="padding:2px 4px;">≥ 240 mg/dL</td></tr>
  <tr><td style="padding:2px 4px;"><b>Triglycerides</b></td><td style="padding:2px 4px;">&lt; 150 mg/dL</td><td style="padding:2px 4px;">150 – 199 mg/dL</td><td style="padding:2px 4px;">200 – 499 mg/dL (≥ 500 pancreatitis risk)</td></tr>
  <tr><td style="padding:2px 4px;"><b>HDL Cholesterol (Good)</b></td><td style="padding:2px 4px;">&gt; 50 mg/dL (protective)</td><td style="padding:2px 4px;">40 – 50 mg/dL</td><td style="padding:2px 4px;">&lt; 40 mg/dL (Major risk factor for CAD)</td></tr>
  <tr><td style="padding:2px 4px;"><b>LDL Cholesterol (Bad)</b></td><td style="padding:2px 4px;">&lt; 100 mg/dL (CAD: &lt; 70)</td><td style="padding:2px 4px;">100 – 129 mg/dL</td><td style="padding:2px 4px;">130 – 159 (Borderline), ≥ 160 mg/dL (High)</td></tr>
  <tr><td style="padding:2px 4px;"><b>VLDL Cholesterol</b></td><td style="padding:2px 4px;">&lt; 30 mg/dL</td><td style="padding:2px 4px;">30 – 40 mg/dL</td><td style="padding:2px 4px;">&gt; 40 mg/dL</td></tr>
</table>
<p style="margin:2px 0 0 0; font-size:7.5pt;"><b>Ratios:</b> Total Chol / HDL ratio &lt; 3.5 is desirable (CAD risk increases &gt; 4.5). LDL / HDL ratio &lt; 2.5 is optimal.<br>
<span style="font-size:7pt; color:#64748b;"><i>Requirement: 10 – 12 hours overnight fasting. If Triglycerides &gt; 400 mg/dL, calculated LDL (Friedewald) is invalid; direct LDL assay is advised.</i></span></p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: TRIG
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Cardiovascular Risk Stratification (NCEP ATP-III / Indian Consensus Guidelines):</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:25%; padding:2px 4px;">Lipid Fraction</th>
    <th style="width:25%; padding:2px 4px;">Optimal / Desirable</th>
    <th style="width:25%; padding:2px 4px;">Borderline High</th>
    <th style="width:25%; padding:2px 4px;">High Risk</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>Total Cholesterol</b></td><td style="padding:2px 4px;">&lt; 200 mg/dL</td><td style="padding:2px 4px;">200 – 239 mg/dL</td><td style="padding:2px 4px;">≥ 240 mg/dL</td></tr>
  <tr><td style="padding:2px 4px;"><b>Triglycerides</b></td><td style="padding:2px 4px;">&lt; 150 mg/dL</td><td style="padding:2px 4px;">150 – 199 mg/dL</td><td style="padding:2px 4px;">200 – 499 mg/dL (≥ 500 pancreatitis risk)</td></tr>
  <tr><td style="padding:2px 4px;"><b>HDL Cholesterol (Good)</b></td><td style="padding:2px 4px;">&gt; 50 mg/dL (protective)</td><td style="padding:2px 4px;">40 – 50 mg/dL</td><td style="padding:2px 4px;">&lt; 40 mg/dL (Major risk factor for CAD)</td></tr>
  <tr><td style="padding:2px 4px;"><b>LDL Cholesterol (Bad)</b></td><td style="padding:2px 4px;">&lt; 100 mg/dL (CAD: &lt; 70)</td><td style="padding:2px 4px;">100 – 129 mg/dL</td><td style="padding:2px 4px;">130 – 159 (Borderline), ≥ 160 mg/dL (High)</td></tr>
  <tr><td style="padding:2px 4px;"><b>VLDL Cholesterol</b></td><td style="padding:2px 4px;">&lt; 30 mg/dL</td><td style="padding:2px 4px;">30 – 40 mg/dL</td><td style="padding:2px 4px;">&gt; 40 mg/dL</td></tr>
</table>
<p style="margin:2px 0 0 0; font-size:7.5pt;"><b>Ratios:</b> Total Chol / HDL ratio &lt; 3.5 is desirable (CAD risk increases &gt; 4.5). LDL / HDL ratio &lt; 2.5 is optimal.<br>
<span style="font-size:7pt; color:#64748b;"><i>Requirement: 10 – 12 hours overnight fasting. If Triglycerides &gt; 400 mg/dL, calculated LDL (Friedewald) is invalid; direct LDL assay is advised.</i></span></p>' WHERE `test_code` = 'TRIG';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Cardiovascular Risk Stratification (NCEP ATP-III / Indian Consensus Guidelines):</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:25%; padding:2px 4px;">Lipid Fraction</th>
    <th style="width:25%; padding:2px 4px;">Optimal / Desirable</th>
    <th style="width:25%; padding:2px 4px;">Borderline High</th>
    <th style="width:25%; padding:2px 4px;">High Risk</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>Total Cholesterol</b></td><td style="padding:2px 4px;">&lt; 200 mg/dL</td><td style="padding:2px 4px;">200 – 239 mg/dL</td><td style="padding:2px 4px;">≥ 240 mg/dL</td></tr>
  <tr><td style="padding:2px 4px;"><b>Triglycerides</b></td><td style="padding:2px 4px;">&lt; 150 mg/dL</td><td style="padding:2px 4px;">150 – 199 mg/dL</td><td style="padding:2px 4px;">200 – 499 mg/dL (≥ 500 pancreatitis risk)</td></tr>
  <tr><td style="padding:2px 4px;"><b>HDL Cholesterol (Good)</b></td><td style="padding:2px 4px;">&gt; 50 mg/dL (protective)</td><td style="padding:2px 4px;">40 – 50 mg/dL</td><td style="padding:2px 4px;">&lt; 40 mg/dL (Major risk factor for CAD)</td></tr>
  <tr><td style="padding:2px 4px;"><b>LDL Cholesterol (Bad)</b></td><td style="padding:2px 4px;">&lt; 100 mg/dL (CAD: &lt; 70)</td><td style="padding:2px 4px;">100 – 129 mg/dL</td><td style="padding:2px 4px;">130 – 159 (Borderline), ≥ 160 mg/dL (High)</td></tr>
  <tr><td style="padding:2px 4px;"><b>VLDL Cholesterol</b></td><td style="padding:2px 4px;">&lt; 30 mg/dL</td><td style="padding:2px 4px;">30 – 40 mg/dL</td><td style="padding:2px 4px;">&gt; 40 mg/dL</td></tr>
</table>
<p style="margin:2px 0 0 0; font-size:7.5pt;"><b>Ratios:</b> Total Chol / HDL ratio &lt; 3.5 is desirable (CAD risk increases &gt; 4.5). LDL / HDL ratio &lt; 2.5 is optimal.<br>
<span style="font-size:7pt; color:#64748b;"><i>Requirement: 10 – 12 hours overnight fasting. If Triglycerides &gt; 400 mg/dL, calculated LDL (Friedewald) is invalid; direct LDL assay is advised.</i></span></p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'TRIG'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Cardiovascular Risk Stratification (NCEP ATP-III / Indian Consensus Guidelines):</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:25%; padding:2px 4px;">Lipid Fraction</th>
    <th style="width:25%; padding:2px 4px;">Optimal / Desirable</th>
    <th style="width:25%; padding:2px 4px;">Borderline High</th>
    <th style="width:25%; padding:2px 4px;">High Risk</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>Total Cholesterol</b></td><td style="padding:2px 4px;">&lt; 200 mg/dL</td><td style="padding:2px 4px;">200 – 239 mg/dL</td><td style="padding:2px 4px;">≥ 240 mg/dL</td></tr>
  <tr><td style="padding:2px 4px;"><b>Triglycerides</b></td><td style="padding:2px 4px;">&lt; 150 mg/dL</td><td style="padding:2px 4px;">150 – 199 mg/dL</td><td style="padding:2px 4px;">200 – 499 mg/dL (≥ 500 pancreatitis risk)</td></tr>
  <tr><td style="padding:2px 4px;"><b>HDL Cholesterol (Good)</b></td><td style="padding:2px 4px;">&gt; 50 mg/dL (protective)</td><td style="padding:2px 4px;">40 – 50 mg/dL</td><td style="padding:2px 4px;">&lt; 40 mg/dL (Major risk factor for CAD)</td></tr>
  <tr><td style="padding:2px 4px;"><b>LDL Cholesterol (Bad)</b></td><td style="padding:2px 4px;">&lt; 100 mg/dL (CAD: &lt; 70)</td><td style="padding:2px 4px;">100 – 129 mg/dL</td><td style="padding:2px 4px;">130 – 159 (Borderline), ≥ 160 mg/dL (High)</td></tr>
  <tr><td style="padding:2px 4px;"><b>VLDL Cholesterol</b></td><td style="padding:2px 4px;">&lt; 30 mg/dL</td><td style="padding:2px 4px;">30 – 40 mg/dL</td><td style="padding:2px 4px;">&gt; 40 mg/dL</td></tr>
</table>
<p style="margin:2px 0 0 0; font-size:7.5pt;"><b>Ratios:</b> Total Chol / HDL ratio &lt; 3.5 is desirable (CAD risk increases &gt; 4.5). LDL / HDL ratio &lt; 2.5 is optimal.<br>
<span style="font-size:7pt; color:#64748b;"><i>Requirement: 10 – 12 hours overnight fasting. If Triglycerides &gt; 400 mg/dL, calculated LDL (Friedewald) is invalid; direct LDL assay is advised.</i></span></p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: HDL
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Cardiovascular Risk Stratification (NCEP ATP-III / Indian Consensus Guidelines):</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:25%; padding:2px 4px;">Lipid Fraction</th>
    <th style="width:25%; padding:2px 4px;">Optimal / Desirable</th>
    <th style="width:25%; padding:2px 4px;">Borderline High</th>
    <th style="width:25%; padding:2px 4px;">High Risk</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>Total Cholesterol</b></td><td style="padding:2px 4px;">&lt; 200 mg/dL</td><td style="padding:2px 4px;">200 – 239 mg/dL</td><td style="padding:2px 4px;">≥ 240 mg/dL</td></tr>
  <tr><td style="padding:2px 4px;"><b>Triglycerides</b></td><td style="padding:2px 4px;">&lt; 150 mg/dL</td><td style="padding:2px 4px;">150 – 199 mg/dL</td><td style="padding:2px 4px;">200 – 499 mg/dL (≥ 500 pancreatitis risk)</td></tr>
  <tr><td style="padding:2px 4px;"><b>HDL Cholesterol (Good)</b></td><td style="padding:2px 4px;">&gt; 50 mg/dL (protective)</td><td style="padding:2px 4px;">40 – 50 mg/dL</td><td style="padding:2px 4px;">&lt; 40 mg/dL (Major risk factor for CAD)</td></tr>
  <tr><td style="padding:2px 4px;"><b>LDL Cholesterol (Bad)</b></td><td style="padding:2px 4px;">&lt; 100 mg/dL (CAD: &lt; 70)</td><td style="padding:2px 4px;">100 – 129 mg/dL</td><td style="padding:2px 4px;">130 – 159 (Borderline), ≥ 160 mg/dL (High)</td></tr>
  <tr><td style="padding:2px 4px;"><b>VLDL Cholesterol</b></td><td style="padding:2px 4px;">&lt; 30 mg/dL</td><td style="padding:2px 4px;">30 – 40 mg/dL</td><td style="padding:2px 4px;">&gt; 40 mg/dL</td></tr>
</table>
<p style="margin:2px 0 0 0; font-size:7.5pt;"><b>Ratios:</b> Total Chol / HDL ratio &lt; 3.5 is desirable (CAD risk increases &gt; 4.5). LDL / HDL ratio &lt; 2.5 is optimal.<br>
<span style="font-size:7pt; color:#64748b;"><i>Requirement: 10 – 12 hours overnight fasting. If Triglycerides &gt; 400 mg/dL, calculated LDL (Friedewald) is invalid; direct LDL assay is advised.</i></span></p>' WHERE `test_code` = 'HDL';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Cardiovascular Risk Stratification (NCEP ATP-III / Indian Consensus Guidelines):</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:25%; padding:2px 4px;">Lipid Fraction</th>
    <th style="width:25%; padding:2px 4px;">Optimal / Desirable</th>
    <th style="width:25%; padding:2px 4px;">Borderline High</th>
    <th style="width:25%; padding:2px 4px;">High Risk</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>Total Cholesterol</b></td><td style="padding:2px 4px;">&lt; 200 mg/dL</td><td style="padding:2px 4px;">200 – 239 mg/dL</td><td style="padding:2px 4px;">≥ 240 mg/dL</td></tr>
  <tr><td style="padding:2px 4px;"><b>Triglycerides</b></td><td style="padding:2px 4px;">&lt; 150 mg/dL</td><td style="padding:2px 4px;">150 – 199 mg/dL</td><td style="padding:2px 4px;">200 – 499 mg/dL (≥ 500 pancreatitis risk)</td></tr>
  <tr><td style="padding:2px 4px;"><b>HDL Cholesterol (Good)</b></td><td style="padding:2px 4px;">&gt; 50 mg/dL (protective)</td><td style="padding:2px 4px;">40 – 50 mg/dL</td><td style="padding:2px 4px;">&lt; 40 mg/dL (Major risk factor for CAD)</td></tr>
  <tr><td style="padding:2px 4px;"><b>LDL Cholesterol (Bad)</b></td><td style="padding:2px 4px;">&lt; 100 mg/dL (CAD: &lt; 70)</td><td style="padding:2px 4px;">100 – 129 mg/dL</td><td style="padding:2px 4px;">130 – 159 (Borderline), ≥ 160 mg/dL (High)</td></tr>
  <tr><td style="padding:2px 4px;"><b>VLDL Cholesterol</b></td><td style="padding:2px 4px;">&lt; 30 mg/dL</td><td style="padding:2px 4px;">30 – 40 mg/dL</td><td style="padding:2px 4px;">&gt; 40 mg/dL</td></tr>
</table>
<p style="margin:2px 0 0 0; font-size:7.5pt;"><b>Ratios:</b> Total Chol / HDL ratio &lt; 3.5 is desirable (CAD risk increases &gt; 4.5). LDL / HDL ratio &lt; 2.5 is optimal.<br>
<span style="font-size:7pt; color:#64748b;"><i>Requirement: 10 – 12 hours overnight fasting. If Triglycerides &gt; 400 mg/dL, calculated LDL (Friedewald) is invalid; direct LDL assay is advised.</i></span></p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'HDL'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Cardiovascular Risk Stratification (NCEP ATP-III / Indian Consensus Guidelines):</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:25%; padding:2px 4px;">Lipid Fraction</th>
    <th style="width:25%; padding:2px 4px;">Optimal / Desirable</th>
    <th style="width:25%; padding:2px 4px;">Borderline High</th>
    <th style="width:25%; padding:2px 4px;">High Risk</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>Total Cholesterol</b></td><td style="padding:2px 4px;">&lt; 200 mg/dL</td><td style="padding:2px 4px;">200 – 239 mg/dL</td><td style="padding:2px 4px;">≥ 240 mg/dL</td></tr>
  <tr><td style="padding:2px 4px;"><b>Triglycerides</b></td><td style="padding:2px 4px;">&lt; 150 mg/dL</td><td style="padding:2px 4px;">150 – 199 mg/dL</td><td style="padding:2px 4px;">200 – 499 mg/dL (≥ 500 pancreatitis risk)</td></tr>
  <tr><td style="padding:2px 4px;"><b>HDL Cholesterol (Good)</b></td><td style="padding:2px 4px;">&gt; 50 mg/dL (protective)</td><td style="padding:2px 4px;">40 – 50 mg/dL</td><td style="padding:2px 4px;">&lt; 40 mg/dL (Major risk factor for CAD)</td></tr>
  <tr><td style="padding:2px 4px;"><b>LDL Cholesterol (Bad)</b></td><td style="padding:2px 4px;">&lt; 100 mg/dL (CAD: &lt; 70)</td><td style="padding:2px 4px;">100 – 129 mg/dL</td><td style="padding:2px 4px;">130 – 159 (Borderline), ≥ 160 mg/dL (High)</td></tr>
  <tr><td style="padding:2px 4px;"><b>VLDL Cholesterol</b></td><td style="padding:2px 4px;">&lt; 30 mg/dL</td><td style="padding:2px 4px;">30 – 40 mg/dL</td><td style="padding:2px 4px;">&gt; 40 mg/dL</td></tr>
</table>
<p style="margin:2px 0 0 0; font-size:7.5pt;"><b>Ratios:</b> Total Chol / HDL ratio &lt; 3.5 is desirable (CAD risk increases &gt; 4.5). LDL / HDL ratio &lt; 2.5 is optimal.<br>
<span style="font-size:7pt; color:#64748b;"><i>Requirement: 10 – 12 hours overnight fasting. If Triglycerides &gt; 400 mg/dL, calculated LDL (Friedewald) is invalid; direct LDL assay is advised.</i></span></p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: LDL
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Cardiovascular Risk Stratification (NCEP ATP-III / Indian Consensus Guidelines):</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:25%; padding:2px 4px;">Lipid Fraction</th>
    <th style="width:25%; padding:2px 4px;">Optimal / Desirable</th>
    <th style="width:25%; padding:2px 4px;">Borderline High</th>
    <th style="width:25%; padding:2px 4px;">High Risk</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>Total Cholesterol</b></td><td style="padding:2px 4px;">&lt; 200 mg/dL</td><td style="padding:2px 4px;">200 – 239 mg/dL</td><td style="padding:2px 4px;">≥ 240 mg/dL</td></tr>
  <tr><td style="padding:2px 4px;"><b>Triglycerides</b></td><td style="padding:2px 4px;">&lt; 150 mg/dL</td><td style="padding:2px 4px;">150 – 199 mg/dL</td><td style="padding:2px 4px;">200 – 499 mg/dL (≥ 500 pancreatitis risk)</td></tr>
  <tr><td style="padding:2px 4px;"><b>HDL Cholesterol (Good)</b></td><td style="padding:2px 4px;">&gt; 50 mg/dL (protective)</td><td style="padding:2px 4px;">40 – 50 mg/dL</td><td style="padding:2px 4px;">&lt; 40 mg/dL (Major risk factor for CAD)</td></tr>
  <tr><td style="padding:2px 4px;"><b>LDL Cholesterol (Bad)</b></td><td style="padding:2px 4px;">&lt; 100 mg/dL (CAD: &lt; 70)</td><td style="padding:2px 4px;">100 – 129 mg/dL</td><td style="padding:2px 4px;">130 – 159 (Borderline), ≥ 160 mg/dL (High)</td></tr>
  <tr><td style="padding:2px 4px;"><b>VLDL Cholesterol</b></td><td style="padding:2px 4px;">&lt; 30 mg/dL</td><td style="padding:2px 4px;">30 – 40 mg/dL</td><td style="padding:2px 4px;">&gt; 40 mg/dL</td></tr>
</table>
<p style="margin:2px 0 0 0; font-size:7.5pt;"><b>Ratios:</b> Total Chol / HDL ratio &lt; 3.5 is desirable (CAD risk increases &gt; 4.5). LDL / HDL ratio &lt; 2.5 is optimal.<br>
<span style="font-size:7pt; color:#64748b;"><i>Requirement: 10 – 12 hours overnight fasting. If Triglycerides &gt; 400 mg/dL, calculated LDL (Friedewald) is invalid; direct LDL assay is advised.</i></span></p>' WHERE `test_code` = 'LDL';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Cardiovascular Risk Stratification (NCEP ATP-III / Indian Consensus Guidelines):</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:25%; padding:2px 4px;">Lipid Fraction</th>
    <th style="width:25%; padding:2px 4px;">Optimal / Desirable</th>
    <th style="width:25%; padding:2px 4px;">Borderline High</th>
    <th style="width:25%; padding:2px 4px;">High Risk</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>Total Cholesterol</b></td><td style="padding:2px 4px;">&lt; 200 mg/dL</td><td style="padding:2px 4px;">200 – 239 mg/dL</td><td style="padding:2px 4px;">≥ 240 mg/dL</td></tr>
  <tr><td style="padding:2px 4px;"><b>Triglycerides</b></td><td style="padding:2px 4px;">&lt; 150 mg/dL</td><td style="padding:2px 4px;">150 – 199 mg/dL</td><td style="padding:2px 4px;">200 – 499 mg/dL (≥ 500 pancreatitis risk)</td></tr>
  <tr><td style="padding:2px 4px;"><b>HDL Cholesterol (Good)</b></td><td style="padding:2px 4px;">&gt; 50 mg/dL (protective)</td><td style="padding:2px 4px;">40 – 50 mg/dL</td><td style="padding:2px 4px;">&lt; 40 mg/dL (Major risk factor for CAD)</td></tr>
  <tr><td style="padding:2px 4px;"><b>LDL Cholesterol (Bad)</b></td><td style="padding:2px 4px;">&lt; 100 mg/dL (CAD: &lt; 70)</td><td style="padding:2px 4px;">100 – 129 mg/dL</td><td style="padding:2px 4px;">130 – 159 (Borderline), ≥ 160 mg/dL (High)</td></tr>
  <tr><td style="padding:2px 4px;"><b>VLDL Cholesterol</b></td><td style="padding:2px 4px;">&lt; 30 mg/dL</td><td style="padding:2px 4px;">30 – 40 mg/dL</td><td style="padding:2px 4px;">&gt; 40 mg/dL</td></tr>
</table>
<p style="margin:2px 0 0 0; font-size:7.5pt;"><b>Ratios:</b> Total Chol / HDL ratio &lt; 3.5 is desirable (CAD risk increases &gt; 4.5). LDL / HDL ratio &lt; 2.5 is optimal.<br>
<span style="font-size:7pt; color:#64748b;"><i>Requirement: 10 – 12 hours overnight fasting. If Triglycerides &gt; 400 mg/dL, calculated LDL (Friedewald) is invalid; direct LDL assay is advised.</i></span></p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'LDL'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Cardiovascular Risk Stratification (NCEP ATP-III / Indian Consensus Guidelines):</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:25%; padding:2px 4px;">Lipid Fraction</th>
    <th style="width:25%; padding:2px 4px;">Optimal / Desirable</th>
    <th style="width:25%; padding:2px 4px;">Borderline High</th>
    <th style="width:25%; padding:2px 4px;">High Risk</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>Total Cholesterol</b></td><td style="padding:2px 4px;">&lt; 200 mg/dL</td><td style="padding:2px 4px;">200 – 239 mg/dL</td><td style="padding:2px 4px;">≥ 240 mg/dL</td></tr>
  <tr><td style="padding:2px 4px;"><b>Triglycerides</b></td><td style="padding:2px 4px;">&lt; 150 mg/dL</td><td style="padding:2px 4px;">150 – 199 mg/dL</td><td style="padding:2px 4px;">200 – 499 mg/dL (≥ 500 pancreatitis risk)</td></tr>
  <tr><td style="padding:2px 4px;"><b>HDL Cholesterol (Good)</b></td><td style="padding:2px 4px;">&gt; 50 mg/dL (protective)</td><td style="padding:2px 4px;">40 – 50 mg/dL</td><td style="padding:2px 4px;">&lt; 40 mg/dL (Major risk factor for CAD)</td></tr>
  <tr><td style="padding:2px 4px;"><b>LDL Cholesterol (Bad)</b></td><td style="padding:2px 4px;">&lt; 100 mg/dL (CAD: &lt; 70)</td><td style="padding:2px 4px;">100 – 129 mg/dL</td><td style="padding:2px 4px;">130 – 159 (Borderline), ≥ 160 mg/dL (High)</td></tr>
  <tr><td style="padding:2px 4px;"><b>VLDL Cholesterol</b></td><td style="padding:2px 4px;">&lt; 30 mg/dL</td><td style="padding:2px 4px;">30 – 40 mg/dL</td><td style="padding:2px 4px;">&gt; 40 mg/dL</td></tr>
</table>
<p style="margin:2px 0 0 0; font-size:7.5pt;"><b>Ratios:</b> Total Chol / HDL ratio &lt; 3.5 is desirable (CAD risk increases &gt; 4.5). LDL / HDL ratio &lt; 2.5 is optimal.<br>
<span style="font-size:7pt; color:#64748b;"><i>Requirement: 10 – 12 hours overnight fasting. If Triglycerides &gt; 400 mg/dL, calculated LDL (Friedewald) is invalid; direct LDL assay is advised.</i></span></p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: AMYLASE
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Serum Amylase &amp; Lipase Interpretation:</b><br>
• <b>Acute Pancreatitis:</b> Levels typically rise &gt; 3 times the upper reference limit within 6–12 hours. Serum Lipase remains elevated longer (7–14 days) and has superior clinical specificity (95–99%) compared to Amylase.<br>
• <b>Other Causes of High Amylase:</b> Salivary gland disease (mumps, parotitis), acute cholecystitis, intestinal ischemia, perforated peptic ulcer, diabetic ketoacidosis, renal failure (decreased clearance).</p>' WHERE `test_code` = 'AMYLASE';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Serum Amylase &amp; Lipase Interpretation:</b><br>
• <b>Acute Pancreatitis:</b> Levels typically rise &gt; 3 times the upper reference limit within 6–12 hours. Serum Lipase remains elevated longer (7–14 days) and has superior clinical specificity (95–99%) compared to Amylase.<br>
• <b>Other Causes of High Amylase:</b> Salivary gland disease (mumps, parotitis), acute cholecystitis, intestinal ischemia, perforated peptic ulcer, diabetic ketoacidosis, renal failure (decreased clearance).</p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'AMYLASE'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Serum Amylase &amp; Lipase Interpretation:</b><br>
• <b>Acute Pancreatitis:</b> Levels typically rise &gt; 3 times the upper reference limit within 6–12 hours. Serum Lipase remains elevated longer (7–14 days) and has superior clinical specificity (95–99%) compared to Amylase.<br>
• <b>Other Causes of High Amylase:</b> Salivary gland disease (mumps, parotitis), acute cholecystitis, intestinal ischemia, perforated peptic ulcer, diabetic ketoacidosis, renal failure (decreased clearance).</p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: LIPASE
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Serum Amylase &amp; Lipase Interpretation:</b><br>
• <b>Acute Pancreatitis:</b> Levels typically rise &gt; 3 times the upper reference limit within 6–12 hours. Serum Lipase remains elevated longer (7–14 days) and has superior clinical specificity (95–99%) compared to Amylase.<br>
• <b>Other Causes of High Amylase:</b> Salivary gland disease (mumps, parotitis), acute cholecystitis, intestinal ischemia, perforated peptic ulcer, diabetic ketoacidosis, renal failure (decreased clearance).</p>' WHERE `test_code` = 'LIPASE';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Serum Amylase &amp; Lipase Interpretation:</b><br>
• <b>Acute Pancreatitis:</b> Levels typically rise &gt; 3 times the upper reference limit within 6–12 hours. Serum Lipase remains elevated longer (7–14 days) and has superior clinical specificity (95–99%) compared to Amylase.<br>
• <b>Other Causes of High Amylase:</b> Salivary gland disease (mumps, parotitis), acute cholecystitis, intestinal ischemia, perforated peptic ulcer, diabetic ketoacidosis, renal failure (decreased clearance).</p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'LIPASE'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Serum Amylase &amp; Lipase Interpretation:</b><br>
• <b>Acute Pancreatitis:</b> Levels typically rise &gt; 3 times the upper reference limit within 6–12 hours. Serum Lipase remains elevated longer (7–14 days) and has superior clinical specificity (95–99%) compared to Amylase.<br>
• <b>Other Causes of High Amylase:</b> Salivary gland disease (mumps, parotitis), acute cholecystitis, intestinal ischemia, perforated peptic ulcer, diabetic ketoacidosis, renal failure (decreased clearance).</p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: CPK
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Total Creatine Kinase (CPK) Interpretation:</b><br>
• <b>Striated Muscle Injury / Rhabdomyolysis:</b> Marked elevation (often 10× to 100× ULN) following crush injury, severe trauma, prolonged immobilization, statin myopathy, or vigorous unaccustomed exercise.<br>
• <b>Myocardial Infarction:</b> CPK rises within 4–6 hours, peaks at 24 hours, and returns to baseline in 48–72 hours.<br>
• <b>Neuromuscular Disorders:</b> Duchenne muscular dystrophy, polymyositis, dermatomyositis.</p>' WHERE `test_code` = 'CPK';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Total Creatine Kinase (CPK) Interpretation:</b><br>
• <b>Striated Muscle Injury / Rhabdomyolysis:</b> Marked elevation (often 10× to 100× ULN) following crush injury, severe trauma, prolonged immobilization, statin myopathy, or vigorous unaccustomed exercise.<br>
• <b>Myocardial Infarction:</b> CPK rises within 4–6 hours, peaks at 24 hours, and returns to baseline in 48–72 hours.<br>
• <b>Neuromuscular Disorders:</b> Duchenne muscular dystrophy, polymyositis, dermatomyositis.</p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'CPK'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Total Creatine Kinase (CPK) Interpretation:</b><br>
• <b>Striated Muscle Injury / Rhabdomyolysis:</b> Marked elevation (often 10× to 100× ULN) following crush injury, severe trauma, prolonged immobilization, statin myopathy, or vigorous unaccustomed exercise.<br>
• <b>Myocardial Infarction:</b> CPK rises within 4–6 hours, peaks at 24 hours, and returns to baseline in 48–72 hours.<br>
• <b>Neuromuscular Disorders:</b> Duchenne muscular dystrophy, polymyositis, dermatomyositis.</p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: CKMB
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>CK-MB (Cardiac Isoenzyme) Clinical Interpretation:</b><br>
• Highly specific for myocardial necrosis. Rises 3 to 6 hours after acute coronary occlusion, peaks at 12–24 hours, and normalizes within 48–72 hours.<br>
• A CK-MB Relative Index (CK-MB / Total CPK × 100) &gt; 3.0% strongly indicates myocardial necrosis rather than skeletal muscle trauma.<br>
• Useful for detecting early re-infarction due to its rapid clearance.</p>' WHERE `test_code` = 'CKMB';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>CK-MB (Cardiac Isoenzyme) Clinical Interpretation:</b><br>
• Highly specific for myocardial necrosis. Rises 3 to 6 hours after acute coronary occlusion, peaks at 12–24 hours, and normalizes within 48–72 hours.<br>
• A CK-MB Relative Index (CK-MB / Total CPK × 100) &gt; 3.0% strongly indicates myocardial necrosis rather than skeletal muscle trauma.<br>
• Useful for detecting early re-infarction due to its rapid clearance.</p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'CKMB'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>CK-MB (Cardiac Isoenzyme) Clinical Interpretation:</b><br>
• Highly specific for myocardial necrosis. Rises 3 to 6 hours after acute coronary occlusion, peaks at 12–24 hours, and normalizes within 48–72 hours.<br>
• A CK-MB Relative Index (CK-MB / Total CPK × 100) &gt; 3.0% strongly indicates myocardial necrosis rather than skeletal muscle trauma.<br>
• Useful for detecting early re-infarction due to its rapid clearance.</p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: TROP-I
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Cardiac Troponin-I (High Sensitivity) Clinical Significance:</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:30%; padding:2px 4px;">Troponin-I Level</th>
    <th style="width:35%; padding:2px 4px;">Diagnostic Classification</th>
    <th style="width:35%; padding:2px 4px;">Clinical Management Recommendation</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>&lt; 99th Percentile URL</b></td><td style="padding:2px 4px;">Normal (Myocardial necrosis unlikely)</td><td style="padding:2px 4px;">Repeat after 2–3 hours if acute chest pain started &lt; 3 hours ago</td></tr>
  <tr><td style="padding:2px 4px;"><b>Elevated with Dynamic Rise/Fall</b></td><td style="padding:2px 4px;"><b>Acute Myocardial Infarction (AMI)</b></td><td style="padding:2px 4px;">Immediate cardiology evaluation, coronary angiography / intervention</td></tr>
  <tr><td style="padding:2px 4px;"><b>Chronically Elevated (Stable)</b></td><td style="padding:2px 4px;">Non-AMI Myocardial Strain</td><td style="padding:2px 4px;">Heart failure, pulmonary embolism, myocarditis, severe sepsis, chronic renal failure</td></tr>
</table>' WHERE `test_code` = 'TROP-I';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Cardiac Troponin-I (High Sensitivity) Clinical Significance:</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:30%; padding:2px 4px;">Troponin-I Level</th>
    <th style="width:35%; padding:2px 4px;">Diagnostic Classification</th>
    <th style="width:35%; padding:2px 4px;">Clinical Management Recommendation</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>&lt; 99th Percentile URL</b></td><td style="padding:2px 4px;">Normal (Myocardial necrosis unlikely)</td><td style="padding:2px 4px;">Repeat after 2–3 hours if acute chest pain started &lt; 3 hours ago</td></tr>
  <tr><td style="padding:2px 4px;"><b>Elevated with Dynamic Rise/Fall</b></td><td style="padding:2px 4px;"><b>Acute Myocardial Infarction (AMI)</b></td><td style="padding:2px 4px;">Immediate cardiology evaluation, coronary angiography / intervention</td></tr>
  <tr><td style="padding:2px 4px;"><b>Chronically Elevated (Stable)</b></td><td style="padding:2px 4px;">Non-AMI Myocardial Strain</td><td style="padding:2px 4px;">Heart failure, pulmonary embolism, myocarditis, severe sepsis, chronic renal failure</td></tr>
</table>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'TROP-I'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Cardiac Troponin-I (High Sensitivity) Clinical Significance:</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:30%; padding:2px 4px;">Troponin-I Level</th>
    <th style="width:35%; padding:2px 4px;">Diagnostic Classification</th>
    <th style="width:35%; padding:2px 4px;">Clinical Management Recommendation</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>&lt; 99th Percentile URL</b></td><td style="padding:2px 4px;">Normal (Myocardial necrosis unlikely)</td><td style="padding:2px 4px;">Repeat after 2–3 hours if acute chest pain started &lt; 3 hours ago</td></tr>
  <tr><td style="padding:2px 4px;"><b>Elevated with Dynamic Rise/Fall</b></td><td style="padding:2px 4px;"><b>Acute Myocardial Infarction (AMI)</b></td><td style="padding:2px 4px;">Immediate cardiology evaluation, coronary angiography / intervention</td></tr>
  <tr><td style="padding:2px 4px;"><b>Chronically Elevated (Stable)</b></td><td style="padding:2px 4px;">Non-AMI Myocardial Strain</td><td style="padding:2px 4px;">Heart failure, pulmonary embolism, myocarditis, severe sepsis, chronic renal failure</td></tr>
</table>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: IRON-PROF
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Iron Profile Differential Diagnostic Guidelines:</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:25%; padding:2px 4px;">Condition</th>
    <th style="width:18%; padding:2px 4px;">Serum Iron</th>
    <th style="width:18%; padding:2px 4px;">TIBC</th>
    <th style="width:18%; padding:2px 4px;">Transferrin Sat.</th>
    <th style="width:21%; padding:2px 4px;">Serum Ferritin</th>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Iron Deficiency Anemia</b></td>
    <td style="padding:2px 4px;">Decreased (&lt; 50)</td>
    <td style="padding:2px 4px;"><b>Elevated (&gt; 400)</b></td>
    <td style="padding:2px 4px;"><b>Low (&lt; 15%)</b></td>
    <td style="padding:2px 4px;"><b>Very Low (&lt; 15 ng/mL)</b></td>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Anemia of Chronic Disease</b></td>
    <td style="padding:2px 4px;">Decreased</td>
    <td style="padding:2px 4px;">Decreased / Normal</td>
    <td style="padding:2px 4px;">Normal / Low</td>
    <td style="padding:2px 4px;"><b>Normal or High (acute reactant)</b></td>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Thalassemia Minor Trait</b></td>
    <td style="padding:2px 4px;">Normal / High</td>
    <td style="padding:2px 4px;">Normal</td>
    <td style="padding:2px 4px;">Normal</td>
    <td style="padding:2px 4px;">Normal / High (HbA2 &gt; 3.5%)</td>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Hemochromatosis (Iron Overload)</b></td>
    <td style="padding:2px 4px;"><b>Very High</b></td>
    <td style="padding:2px 4px;">Low / Normal</td>
    <td style="padding:2px 4px;"><b>&gt; 50% (High risk)</b></td>
    <td style="padding:2px 4px;"><b>Markedly High (&gt; 1000 ng/mL)</b></td>
  </tr>
</table>' WHERE `test_code` = 'IRON-PROF';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Iron Profile Differential Diagnostic Guidelines:</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:25%; padding:2px 4px;">Condition</th>
    <th style="width:18%; padding:2px 4px;">Serum Iron</th>
    <th style="width:18%; padding:2px 4px;">TIBC</th>
    <th style="width:18%; padding:2px 4px;">Transferrin Sat.</th>
    <th style="width:21%; padding:2px 4px;">Serum Ferritin</th>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Iron Deficiency Anemia</b></td>
    <td style="padding:2px 4px;">Decreased (&lt; 50)</td>
    <td style="padding:2px 4px;"><b>Elevated (&gt; 400)</b></td>
    <td style="padding:2px 4px;"><b>Low (&lt; 15%)</b></td>
    <td style="padding:2px 4px;"><b>Very Low (&lt; 15 ng/mL)</b></td>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Anemia of Chronic Disease</b></td>
    <td style="padding:2px 4px;">Decreased</td>
    <td style="padding:2px 4px;">Decreased / Normal</td>
    <td style="padding:2px 4px;">Normal / Low</td>
    <td style="padding:2px 4px;"><b>Normal or High (acute reactant)</b></td>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Thalassemia Minor Trait</b></td>
    <td style="padding:2px 4px;">Normal / High</td>
    <td style="padding:2px 4px;">Normal</td>
    <td style="padding:2px 4px;">Normal</td>
    <td style="padding:2px 4px;">Normal / High (HbA2 &gt; 3.5%)</td>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Hemochromatosis (Iron Overload)</b></td>
    <td style="padding:2px 4px;"><b>Very High</b></td>
    <td style="padding:2px 4px;">Low / Normal</td>
    <td style="padding:2px 4px;"><b>&gt; 50% (High risk)</b></td>
    <td style="padding:2px 4px;"><b>Markedly High (&gt; 1000 ng/mL)</b></td>
  </tr>
</table>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'IRON-PROF'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Iron Profile Differential Diagnostic Guidelines:</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:25%; padding:2px 4px;">Condition</th>
    <th style="width:18%; padding:2px 4px;">Serum Iron</th>
    <th style="width:18%; padding:2px 4px;">TIBC</th>
    <th style="width:18%; padding:2px 4px;">Transferrin Sat.</th>
    <th style="width:21%; padding:2px 4px;">Serum Ferritin</th>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Iron Deficiency Anemia</b></td>
    <td style="padding:2px 4px;">Decreased (&lt; 50)</td>
    <td style="padding:2px 4px;"><b>Elevated (&gt; 400)</b></td>
    <td style="padding:2px 4px;"><b>Low (&lt; 15%)</b></td>
    <td style="padding:2px 4px;"><b>Very Low (&lt; 15 ng/mL)</b></td>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Anemia of Chronic Disease</b></td>
    <td style="padding:2px 4px;">Decreased</td>
    <td style="padding:2px 4px;">Decreased / Normal</td>
    <td style="padding:2px 4px;">Normal / Low</td>
    <td style="padding:2px 4px;"><b>Normal or High (acute reactant)</b></td>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Thalassemia Minor Trait</b></td>
    <td style="padding:2px 4px;">Normal / High</td>
    <td style="padding:2px 4px;">Normal</td>
    <td style="padding:2px 4px;">Normal</td>
    <td style="padding:2px 4px;">Normal / High (HbA2 &gt; 3.5%)</td>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Hemochromatosis (Iron Overload)</b></td>
    <td style="padding:2px 4px;"><b>Very High</b></td>
    <td style="padding:2px 4px;">Low / Normal</td>
    <td style="padding:2px 4px;"><b>&gt; 50% (High risk)</b></td>
    <td style="padding:2px 4px;"><b>Markedly High (&gt; 1000 ng/mL)</b></td>
  </tr>
</table>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: IRON
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Iron Profile Differential Diagnostic Guidelines:</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:25%; padding:2px 4px;">Condition</th>
    <th style="width:18%; padding:2px 4px;">Serum Iron</th>
    <th style="width:18%; padding:2px 4px;">TIBC</th>
    <th style="width:18%; padding:2px 4px;">Transferrin Sat.</th>
    <th style="width:21%; padding:2px 4px;">Serum Ferritin</th>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Iron Deficiency Anemia</b></td>
    <td style="padding:2px 4px;">Decreased (&lt; 50)</td>
    <td style="padding:2px 4px;"><b>Elevated (&gt; 400)</b></td>
    <td style="padding:2px 4px;"><b>Low (&lt; 15%)</b></td>
    <td style="padding:2px 4px;"><b>Very Low (&lt; 15 ng/mL)</b></td>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Anemia of Chronic Disease</b></td>
    <td style="padding:2px 4px;">Decreased</td>
    <td style="padding:2px 4px;">Decreased / Normal</td>
    <td style="padding:2px 4px;">Normal / Low</td>
    <td style="padding:2px 4px;"><b>Normal or High (acute reactant)</b></td>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Thalassemia Minor Trait</b></td>
    <td style="padding:2px 4px;">Normal / High</td>
    <td style="padding:2px 4px;">Normal</td>
    <td style="padding:2px 4px;">Normal</td>
    <td style="padding:2px 4px;">Normal / High (HbA2 &gt; 3.5%)</td>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Hemochromatosis (Iron Overload)</b></td>
    <td style="padding:2px 4px;"><b>Very High</b></td>
    <td style="padding:2px 4px;">Low / Normal</td>
    <td style="padding:2px 4px;"><b>&gt; 50% (High risk)</b></td>
    <td style="padding:2px 4px;"><b>Markedly High (&gt; 1000 ng/mL)</b></td>
  </tr>
</table>' WHERE `test_code` = 'IRON';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Iron Profile Differential Diagnostic Guidelines:</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:25%; padding:2px 4px;">Condition</th>
    <th style="width:18%; padding:2px 4px;">Serum Iron</th>
    <th style="width:18%; padding:2px 4px;">TIBC</th>
    <th style="width:18%; padding:2px 4px;">Transferrin Sat.</th>
    <th style="width:21%; padding:2px 4px;">Serum Ferritin</th>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Iron Deficiency Anemia</b></td>
    <td style="padding:2px 4px;">Decreased (&lt; 50)</td>
    <td style="padding:2px 4px;"><b>Elevated (&gt; 400)</b></td>
    <td style="padding:2px 4px;"><b>Low (&lt; 15%)</b></td>
    <td style="padding:2px 4px;"><b>Very Low (&lt; 15 ng/mL)</b></td>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Anemia of Chronic Disease</b></td>
    <td style="padding:2px 4px;">Decreased</td>
    <td style="padding:2px 4px;">Decreased / Normal</td>
    <td style="padding:2px 4px;">Normal / Low</td>
    <td style="padding:2px 4px;"><b>Normal or High (acute reactant)</b></td>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Thalassemia Minor Trait</b></td>
    <td style="padding:2px 4px;">Normal / High</td>
    <td style="padding:2px 4px;">Normal</td>
    <td style="padding:2px 4px;">Normal</td>
    <td style="padding:2px 4px;">Normal / High (HbA2 &gt; 3.5%)</td>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Hemochromatosis (Iron Overload)</b></td>
    <td style="padding:2px 4px;"><b>Very High</b></td>
    <td style="padding:2px 4px;">Low / Normal</td>
    <td style="padding:2px 4px;"><b>&gt; 50% (High risk)</b></td>
    <td style="padding:2px 4px;"><b>Markedly High (&gt; 1000 ng/mL)</b></td>
  </tr>
</table>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'IRON'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Iron Profile Differential Diagnostic Guidelines:</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:25%; padding:2px 4px;">Condition</th>
    <th style="width:18%; padding:2px 4px;">Serum Iron</th>
    <th style="width:18%; padding:2px 4px;">TIBC</th>
    <th style="width:18%; padding:2px 4px;">Transferrin Sat.</th>
    <th style="width:21%; padding:2px 4px;">Serum Ferritin</th>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Iron Deficiency Anemia</b></td>
    <td style="padding:2px 4px;">Decreased (&lt; 50)</td>
    <td style="padding:2px 4px;"><b>Elevated (&gt; 400)</b></td>
    <td style="padding:2px 4px;"><b>Low (&lt; 15%)</b></td>
    <td style="padding:2px 4px;"><b>Very Low (&lt; 15 ng/mL)</b></td>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Anemia of Chronic Disease</b></td>
    <td style="padding:2px 4px;">Decreased</td>
    <td style="padding:2px 4px;">Decreased / Normal</td>
    <td style="padding:2px 4px;">Normal / Low</td>
    <td style="padding:2px 4px;"><b>Normal or High (acute reactant)</b></td>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Thalassemia Minor Trait</b></td>
    <td style="padding:2px 4px;">Normal / High</td>
    <td style="padding:2px 4px;">Normal</td>
    <td style="padding:2px 4px;">Normal</td>
    <td style="padding:2px 4px;">Normal / High (HbA2 &gt; 3.5%)</td>
  </tr>
  <tr>
    <td style="padding:2px 4px;"><b>Hemochromatosis (Iron Overload)</b></td>
    <td style="padding:2px 4px;"><b>Very High</b></td>
    <td style="padding:2px 4px;">Low / Normal</td>
    <td style="padding:2px 4px;"><b>&gt; 50% (High risk)</b></td>
    <td style="padding:2px 4px;"><b>Markedly High (&gt; 1000 ng/mL)</b></td>
  </tr>
</table>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: FERRITIN
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Serum Ferritin Clinical Significance:</b> Primary intracellular iron storage protein; directly proportional to total bone marrow iron stores.<br>
• <b>Ferritin &lt; 15 – 20 ng/mL:</b> Definitive confirmation of true Iron Deficiency Anemia (most sensitive biomarker).<br>
• <b>Ferritin &gt; 500 – 1000 ng/mL:</b> Acute phase reactant elevated in systemic hyperinflammation (COVID-19 cytokine storm, Macrophage Activation Syndrome / HLH, adult-onset Still disease, severe sepsis, chronic hemodialysis, and hemochromatosis/transfusional iron overload).</p>' WHERE `test_code` = 'FERRITIN';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Serum Ferritin Clinical Significance:</b> Primary intracellular iron storage protein; directly proportional to total bone marrow iron stores.<br>
• <b>Ferritin &lt; 15 – 20 ng/mL:</b> Definitive confirmation of true Iron Deficiency Anemia (most sensitive biomarker).<br>
• <b>Ferritin &gt; 500 – 1000 ng/mL:</b> Acute phase reactant elevated in systemic hyperinflammation (COVID-19 cytokine storm, Macrophage Activation Syndrome / HLH, adult-onset Still disease, severe sepsis, chronic hemodialysis, and hemochromatosis/transfusional iron overload).</p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'FERRITIN'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Serum Ferritin Clinical Significance:</b> Primary intracellular iron storage protein; directly proportional to total bone marrow iron stores.<br>
• <b>Ferritin &lt; 15 – 20 ng/mL:</b> Definitive confirmation of true Iron Deficiency Anemia (most sensitive biomarker).<br>
• <b>Ferritin &gt; 500 – 1000 ng/mL:</b> Acute phase reactant elevated in systemic hyperinflammation (COVID-19 cytokine storm, Macrophage Activation Syndrome / HLH, adult-onset Still disease, severe sepsis, chronic hemodialysis, and hemochromatosis/transfusional iron overload).</p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: WIDAL
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Widal Agglutination Test (Typhoid Serodiagnosis):</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:25%; padding:2px 4px;">Antigen Marker</th>
    <th style="width:30%; padding:2px 4px;">Indian Endemic Baseline Titer</th>
    <th style="width:45%; padding:2px 4px;">Diagnostic Significant Titer (Active Infection)</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>S. typhi ''O'' (Somatic)</b></td><td style="padding:2px 4px;">Up to 1:80</td><td style="padding:2px 4px;"><b>≥ 1:160</b> (Suggests acute ongoing infection)</td></tr>
  <tr><td style="padding:2px 4px;"><b>S. typhi ''H'' (Flagellar)</b></td><td style="padding:2px 4px;">Up to 1:80</td><td style="padding:2px 4px;"><b>≥ 1:160</b> (Past infection, late stage, or TAB vaccination)</td></tr>
  <tr><td style="padding:2px 4px;"><b>S. paratyphi ''AH''</b></td><td style="padding:2px 4px;">Up to 1:40</td><td style="padding:2px 4px;"><b>≥ 1:80</b> (Suggestive of Paratyphoid A fever)</td></tr>
  <tr><td style="padding:2px 4px;"><b>S. paratyphi ''BH''</b></td><td style="padding:2px 4px;">Up to 1:40</td><td style="padding:2px 4px;"><b>≥ 1:80</b> (Suggestive of Paratyphoid B fever)</td></tr>
</table>
<p style="margin:2px 0 0 0; font-size:7.5pt;"><b>Clinical Guidelines:</b><br>
1. A single high titer (≥ 1:160 for O and H) along with step-ladder fever, headache, relative bradycardia, and toxic facies is clinically suggestive of Enteric fever.<br>
2. A <b>4-fold rise in paired serum titers</b> collected 7–10 days apart provides definitive confirmation.<br>
<span style="font-size:7pt; color:#64748b;"><i>Limitations: False-positive agglutination can occur in malaria, typhus, chronic liver disease, or previous typhoid immunization (anamnestic reaction). Blood culture is the gold standard during the 1st week of fever.</i></span></p>' WHERE `test_code` = 'WIDAL';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Widal Agglutination Test (Typhoid Serodiagnosis):</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:25%; padding:2px 4px;">Antigen Marker</th>
    <th style="width:30%; padding:2px 4px;">Indian Endemic Baseline Titer</th>
    <th style="width:45%; padding:2px 4px;">Diagnostic Significant Titer (Active Infection)</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>S. typhi ''O'' (Somatic)</b></td><td style="padding:2px 4px;">Up to 1:80</td><td style="padding:2px 4px;"><b>≥ 1:160</b> (Suggests acute ongoing infection)</td></tr>
  <tr><td style="padding:2px 4px;"><b>S. typhi ''H'' (Flagellar)</b></td><td style="padding:2px 4px;">Up to 1:80</td><td style="padding:2px 4px;"><b>≥ 1:160</b> (Past infection, late stage, or TAB vaccination)</td></tr>
  <tr><td style="padding:2px 4px;"><b>S. paratyphi ''AH''</b></td><td style="padding:2px 4px;">Up to 1:40</td><td style="padding:2px 4px;"><b>≥ 1:80</b> (Suggestive of Paratyphoid A fever)</td></tr>
  <tr><td style="padding:2px 4px;"><b>S. paratyphi ''BH''</b></td><td style="padding:2px 4px;">Up to 1:40</td><td style="padding:2px 4px;"><b>≥ 1:80</b> (Suggestive of Paratyphoid B fever)</td></tr>
</table>
<p style="margin:2px 0 0 0; font-size:7.5pt;"><b>Clinical Guidelines:</b><br>
1. A single high titer (≥ 1:160 for O and H) along with step-ladder fever, headache, relative bradycardia, and toxic facies is clinically suggestive of Enteric fever.<br>
2. A <b>4-fold rise in paired serum titers</b> collected 7–10 days apart provides definitive confirmation.<br>
<span style="font-size:7pt; color:#64748b;"><i>Limitations: False-positive agglutination can occur in malaria, typhus, chronic liver disease, or previous typhoid immunization (anamnestic reaction). Blood culture is the gold standard during the 1st week of fever.</i></span></p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'WIDAL'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Widal Agglutination Test (Typhoid Serodiagnosis):</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:25%; padding:2px 4px;">Antigen Marker</th>
    <th style="width:30%; padding:2px 4px;">Indian Endemic Baseline Titer</th>
    <th style="width:45%; padding:2px 4px;">Diagnostic Significant Titer (Active Infection)</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>S. typhi ''O'' (Somatic)</b></td><td style="padding:2px 4px;">Up to 1:80</td><td style="padding:2px 4px;"><b>≥ 1:160</b> (Suggests acute ongoing infection)</td></tr>
  <tr><td style="padding:2px 4px;"><b>S. typhi ''H'' (Flagellar)</b></td><td style="padding:2px 4px;">Up to 1:80</td><td style="padding:2px 4px;"><b>≥ 1:160</b> (Past infection, late stage, or TAB vaccination)</td></tr>
  <tr><td style="padding:2px 4px;"><b>S. paratyphi ''AH''</b></td><td style="padding:2px 4px;">Up to 1:40</td><td style="padding:2px 4px;"><b>≥ 1:80</b> (Suggestive of Paratyphoid A fever)</td></tr>
  <tr><td style="padding:2px 4px;"><b>S. paratyphi ''BH''</b></td><td style="padding:2px 4px;">Up to 1:40</td><td style="padding:2px 4px;"><b>≥ 1:80</b> (Suggestive of Paratyphoid B fever)</td></tr>
</table>
<p style="margin:2px 0 0 0; font-size:7.5pt;"><b>Clinical Guidelines:</b><br>
1. A single high titer (≥ 1:160 for O and H) along with step-ladder fever, headache, relative bradycardia, and toxic facies is clinically suggestive of Enteric fever.<br>
2. A <b>4-fold rise in paired serum titers</b> collected 7–10 days apart provides definitive confirmation.<br>
<span style="font-size:7pt; color:#64748b;"><i>Limitations: False-positive agglutination can occur in malaria, typhus, chronic liver disease, or previous typhoid immunization (anamnestic reaction). Blood culture is the gold standard during the 1st week of fever.</i></span></p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: TYPHIDOT
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Typhidot (IgM &amp; IgG) Serology Interpretation:</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:25%; padding:2px 4px;">Typhoid IgM</th>
    <th style="width:25%; padding:2px 4px;">Typhoid IgG</th>
    <th style="width:50%; padding:2px 4px;">Clinical Significance</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>Positive</b></td><td style="padding:2px 4px;">Negative</td><td style="padding:2px 4px;"><b>Acute Enteric (Typhoid) Fever:</b> Detectable as early as Day 2 to 3 of fever.</td></tr>
  <tr><td style="padding:2px 4px;"><b>Positive</b></td><td style="padding:2px 4px;"><b>Positive</b></td><td style="padding:2px 4px;"><b>Acute / Subacute Infection:</b> Middle-to-late phase of acute typhoid or re-infection.</td></tr>
  <tr><td style="padding:2px 4px;">Negative</td><td style="padding:2px 4px;"><b>Positive</b></td><td style="padding:2px 4px;"><b>Past Typhoid Infection</b> or carrier status; does not indicate acute active fever.</td></tr>
  <tr><td style="padding:2px 4px;">Negative</td><td style="padding:2px 4px;">Negative</td><td style="padding:2px 4px;">Enteric fever unlikely; repeat in 48–72 hours if high clinical suspicion persists.</td></tr>
</table>' WHERE `test_code` = 'TYPHIDOT';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Typhidot (IgM &amp; IgG) Serology Interpretation:</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:25%; padding:2px 4px;">Typhoid IgM</th>
    <th style="width:25%; padding:2px 4px;">Typhoid IgG</th>
    <th style="width:50%; padding:2px 4px;">Clinical Significance</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>Positive</b></td><td style="padding:2px 4px;">Negative</td><td style="padding:2px 4px;"><b>Acute Enteric (Typhoid) Fever:</b> Detectable as early as Day 2 to 3 of fever.</td></tr>
  <tr><td style="padding:2px 4px;"><b>Positive</b></td><td style="padding:2px 4px;"><b>Positive</b></td><td style="padding:2px 4px;"><b>Acute / Subacute Infection:</b> Middle-to-late phase of acute typhoid or re-infection.</td></tr>
  <tr><td style="padding:2px 4px;">Negative</td><td style="padding:2px 4px;"><b>Positive</b></td><td style="padding:2px 4px;"><b>Past Typhoid Infection</b> or carrier status; does not indicate acute active fever.</td></tr>
  <tr><td style="padding:2px 4px;">Negative</td><td style="padding:2px 4px;">Negative</td><td style="padding:2px 4px;">Enteric fever unlikely; repeat in 48–72 hours if high clinical suspicion persists.</td></tr>
</table>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'TYPHIDOT'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Typhidot (IgM &amp; IgG) Serology Interpretation:</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:25%; padding:2px 4px;">Typhoid IgM</th>
    <th style="width:25%; padding:2px 4px;">Typhoid IgG</th>
    <th style="width:50%; padding:2px 4px;">Clinical Significance</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>Positive</b></td><td style="padding:2px 4px;">Negative</td><td style="padding:2px 4px;"><b>Acute Enteric (Typhoid) Fever:</b> Detectable as early as Day 2 to 3 of fever.</td></tr>
  <tr><td style="padding:2px 4px;"><b>Positive</b></td><td style="padding:2px 4px;"><b>Positive</b></td><td style="padding:2px 4px;"><b>Acute / Subacute Infection:</b> Middle-to-late phase of acute typhoid or re-infection.</td></tr>
  <tr><td style="padding:2px 4px;">Negative</td><td style="padding:2px 4px;"><b>Positive</b></td><td style="padding:2px 4px;"><b>Past Typhoid Infection</b> or carrier status; does not indicate acute active fever.</td></tr>
  <tr><td style="padding:2px 4px;">Negative</td><td style="padding:2px 4px;">Negative</td><td style="padding:2px 4px;">Enteric fever unlikely; repeat in 48–72 hours if high clinical suspicion persists.</td></tr>
</table>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: MAL-CARD
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Malaria Rapid Antigen Test (Card) Interpretation:</b><br>
• <b>Pan / Pv-pLDH Positive:</b> Suggests *Plasmodium vivax* (or *P. malariae / P. ovale*) infection.<br>
• <b>Pf HRP-2 Positive:</b> Indicates *Plasmodium falciparum* infection (high risk for cerebral malaria, acute renal failure, severe anemia). Requires immediate emergency antimalarial therapy.<br>
• <b>Both Pf and Pv Positive:</b> Mixed malarial infection.<br>
<span style="font-size:7pt; color:#64748b;"><i>Note: Pf HRP-2 antigen can persist in circulating blood for up to 2 to 4 weeks following successful parasite clearance. Correlate with peripheral blood smear microscopy.</i></span></p>' WHERE `test_code` = 'MAL-CARD';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Malaria Rapid Antigen Test (Card) Interpretation:</b><br>
• <b>Pan / Pv-pLDH Positive:</b> Suggests *Plasmodium vivax* (or *P. malariae / P. ovale*) infection.<br>
• <b>Pf HRP-2 Positive:</b> Indicates *Plasmodium falciparum* infection (high risk for cerebral malaria, acute renal failure, severe anemia). Requires immediate emergency antimalarial therapy.<br>
• <b>Both Pf and Pv Positive:</b> Mixed malarial infection.<br>
<span style="font-size:7pt; color:#64748b;"><i>Note: Pf HRP-2 antigen can persist in circulating blood for up to 2 to 4 weeks following successful parasite clearance. Correlate with peripheral blood smear microscopy.</i></span></p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'MAL-CARD'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Malaria Rapid Antigen Test (Card) Interpretation:</b><br>
• <b>Pan / Pv-pLDH Positive:</b> Suggests *Plasmodium vivax* (or *P. malariae / P. ovale*) infection.<br>
• <b>Pf HRP-2 Positive:</b> Indicates *Plasmodium falciparum* infection (high risk for cerebral malaria, acute renal failure, severe anemia). Requires immediate emergency antimalarial therapy.<br>
• <b>Both Pf and Pv Positive:</b> Mixed malarial infection.<br>
<span style="font-size:7pt; color:#64748b;"><i>Note: Pf HRP-2 antigen can persist in circulating blood for up to 2 to 4 weeks following successful parasite clearance. Correlate with peripheral blood smear microscopy.</i></span></p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: MALARIA
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Malaria Rapid Antigen Test (Card) Interpretation:</b><br>
• <b>Pan / Pv-pLDH Positive:</b> Suggests *Plasmodium vivax* (or *P. malariae / P. ovale*) infection.<br>
• <b>Pf HRP-2 Positive:</b> Indicates *Plasmodium falciparum* infection (high risk for cerebral malaria, acute renal failure, severe anemia). Requires immediate emergency antimalarial therapy.<br>
• <b>Both Pf and Pv Positive:</b> Mixed malarial infection.<br>
<span style="font-size:7pt; color:#64748b;"><i>Note: Pf HRP-2 antigen can persist in circulating blood for up to 2 to 4 weeks following successful parasite clearance. Correlate with peripheral blood smear microscopy.</i></span></p>
<p style="margin:3px 0 0 0;"><b>Microscopic Smear Confirmation:</b> Examination of Giemsa-stained thick and thin blood films remains the clinical gold standard for species identification (P. vivax vs P. falciparum), parasite life-cycle staging (ring forms, trophozoites, schizonts, gametocytes), and parasitemia quantification.</p>' WHERE `test_code` = 'MALARIA';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Malaria Rapid Antigen Test (Card) Interpretation:</b><br>
• <b>Pan / Pv-pLDH Positive:</b> Suggests *Plasmodium vivax* (or *P. malariae / P. ovale*) infection.<br>
• <b>Pf HRP-2 Positive:</b> Indicates *Plasmodium falciparum* infection (high risk for cerebral malaria, acute renal failure, severe anemia). Requires immediate emergency antimalarial therapy.<br>
• <b>Both Pf and Pv Positive:</b> Mixed malarial infection.<br>
<span style="font-size:7pt; color:#64748b;"><i>Note: Pf HRP-2 antigen can persist in circulating blood for up to 2 to 4 weeks following successful parasite clearance. Correlate with peripheral blood smear microscopy.</i></span></p>
<p style="margin:3px 0 0 0;"><b>Microscopic Smear Confirmation:</b> Examination of Giemsa-stained thick and thin blood films remains the clinical gold standard for species identification (P. vivax vs P. falciparum), parasite life-cycle staging (ring forms, trophozoites, schizonts, gametocytes), and parasitemia quantification.</p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'MALARIA'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Malaria Rapid Antigen Test (Card) Interpretation:</b><br>
• <b>Pan / Pv-pLDH Positive:</b> Suggests *Plasmodium vivax* (or *P. malariae / P. ovale*) infection.<br>
• <b>Pf HRP-2 Positive:</b> Indicates *Plasmodium falciparum* infection (high risk for cerebral malaria, acute renal failure, severe anemia). Requires immediate emergency antimalarial therapy.<br>
• <b>Both Pf and Pv Positive:</b> Mixed malarial infection.<br>
<span style="font-size:7pt; color:#64748b;"><i>Note: Pf HRP-2 antigen can persist in circulating blood for up to 2 to 4 weeks following successful parasite clearance. Correlate with peripheral blood smear microscopy.</i></span></p>
<p style="margin:3px 0 0 0;"><b>Microscopic Smear Confirmation:</b> Examination of Giemsa-stained thick and thin blood films remains the clinical gold standard for species identification (P. vivax vs P. falciparum), parasite life-cycle staging (ring forms, trophozoites, schizonts, gametocytes), and parasitemia quantification.</p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: DENG-NS1
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Dengue NS1 Antigen Clinical Significance:</b><br>
• <b>Early Detection Window:</b> Highly sensitive during <b>Day 1 to Day 5</b> of fever onset (viremic phase) before detectable IgM antibodies develop.<br>
• <b>Positive:</b> Confirms acute primary or secondary Dengue viral infection.<br>
• <b>Negative:</b> Does not exclude Dengue if tested after Day 5 of fever; Dengue IgM/IgG serology testing is indicated.</p>' WHERE `test_code` = 'DENG-NS1';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Dengue NS1 Antigen Clinical Significance:</b><br>
• <b>Early Detection Window:</b> Highly sensitive during <b>Day 1 to Day 5</b> of fever onset (viremic phase) before detectable IgM antibodies develop.<br>
• <b>Positive:</b> Confirms acute primary or secondary Dengue viral infection.<br>
• <b>Negative:</b> Does not exclude Dengue if tested after Day 5 of fever; Dengue IgM/IgG serology testing is indicated.</p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'DENG-NS1'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Dengue NS1 Antigen Clinical Significance:</b><br>
• <b>Early Detection Window:</b> Highly sensitive during <b>Day 1 to Day 5</b> of fever onset (viremic phase) before detectable IgM antibodies develop.<br>
• <b>Positive:</b> Confirms acute primary or secondary Dengue viral infection.<br>
• <b>Negative:</b> Does not exclude Dengue if tested after Day 5 of fever; Dengue IgM/IgG serology testing is indicated.</p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: DENG-AB
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Dengue Antibodies (IgM &amp; IgG) Clinical Interpretation:</b><br>
• <b>Dengue IgM:</b> Appears by Day 4 to 5 of fever, peaks at Day 14, and persists for 2 to 3 months. Indicates current or recent Dengue infection.<br>
• <b>Dengue IgG:</b> In primary infection, appears slowly after Day 10 and persists for life. In secondary infection, rises rapidly to very high levels within 1–2 days of fever.<br>
• <b>Secondary Dengue Alert:</b> Positive IgG in early fever (with or without IgM) flags secondary infection, associated with higher risk of Dengue Hemorrhagic Fever (DHF) and Dengue Shock Syndrome (DSS).</p>' WHERE `test_code` = 'DENG-AB';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Dengue Antibodies (IgM &amp; IgG) Clinical Interpretation:</b><br>
• <b>Dengue IgM:</b> Appears by Day 4 to 5 of fever, peaks at Day 14, and persists for 2 to 3 months. Indicates current or recent Dengue infection.<br>
• <b>Dengue IgG:</b> In primary infection, appears slowly after Day 10 and persists for life. In secondary infection, rises rapidly to very high levels within 1–2 days of fever.<br>
• <b>Secondary Dengue Alert:</b> Positive IgG in early fever (with or without IgM) flags secondary infection, associated with higher risk of Dengue Hemorrhagic Fever (DHF) and Dengue Shock Syndrome (DSS).</p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'DENG-AB'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Dengue Antibodies (IgM &amp; IgG) Clinical Interpretation:</b><br>
• <b>Dengue IgM:</b> Appears by Day 4 to 5 of fever, peaks at Day 14, and persists for 2 to 3 months. Indicates current or recent Dengue infection.<br>
• <b>Dengue IgG:</b> In primary infection, appears slowly after Day 10 and persists for life. In secondary infection, rises rapidly to very high levels within 1–2 days of fever.<br>
• <b>Secondary Dengue Alert:</b> Positive IgG in early fever (with or without IgM) flags secondary infection, associated with higher risk of Dengue Hemorrhagic Fever (DHF) and Dengue Shock Syndrome (DSS).</p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: DENGUE
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Comprehensive Dengue Serology Staging Guide:</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:20%; padding:2px 4px;">NS1 Antigen</th>
    <th style="width:18%; padding:2px 4px;">IgM Antibody</th>
    <th style="width:18%; padding:2px 4px;">IgG Antibody</th>
    <th style="width:44%; padding:2px 4px;">Clinical Staging &amp; Interpretation</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>Reactive</b></td><td style="padding:2px 4px;">Non-reactive</td><td style="padding:2px 4px;">Non-reactive</td><td style="padding:2px 4px;"><b>Early Acute Primary Dengue</b> (Day 1 – 4 of fever onset)</td></tr>
  <tr><td style="padding:2px 4px;"><b>Reactive</b></td><td style="padding:2px 4px;"><b>Reactive</b></td><td style="padding:2px 4px;">Non-reactive</td><td style="padding:2px 4px;"><b>Acute Primary Dengue</b> (Day 4 – 7 of fever)</td></tr>
  <tr><td style="padding:2px 4px;">Non-reactive</td><td style="padding:2px 4px;"><b>Reactive</b></td><td style="padding:2px 4px;">Non-reactive</td><td style="padding:2px 4px;"><b>Late Acute / Convalescent Primary Dengue</b> (&gt; Day 5)</td></tr>
  <tr><td style="padding:2px 4px;"><b>Reactive</b> / Non-react</td><td style="padding:2px 4px;"><b>Reactive</b></td><td style="padding:2px 4px;"><b>Reactive</b></td><td style="padding:2px 4px;"><b>Acute Secondary Dengue</b> (High risk for plasma leakage / DHF; monitor platelets &amp; hematocrit)</td></tr>
  <tr><td style="padding:2px 4px;">Non-reactive</td><td style="padding:2px 4px;">Non-reactive</td><td style="padding:2px 4px;"><b>Reactive</b></td><td style="padding:2px 4px;"><b>Past Dengue Infection</b> (Distant immunity; no evidence of acute dengue)</td></tr>
</table>' WHERE `test_code` = 'DENGUE';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Comprehensive Dengue Serology Staging Guide:</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:20%; padding:2px 4px;">NS1 Antigen</th>
    <th style="width:18%; padding:2px 4px;">IgM Antibody</th>
    <th style="width:18%; padding:2px 4px;">IgG Antibody</th>
    <th style="width:44%; padding:2px 4px;">Clinical Staging &amp; Interpretation</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>Reactive</b></td><td style="padding:2px 4px;">Non-reactive</td><td style="padding:2px 4px;">Non-reactive</td><td style="padding:2px 4px;"><b>Early Acute Primary Dengue</b> (Day 1 – 4 of fever onset)</td></tr>
  <tr><td style="padding:2px 4px;"><b>Reactive</b></td><td style="padding:2px 4px;"><b>Reactive</b></td><td style="padding:2px 4px;">Non-reactive</td><td style="padding:2px 4px;"><b>Acute Primary Dengue</b> (Day 4 – 7 of fever)</td></tr>
  <tr><td style="padding:2px 4px;">Non-reactive</td><td style="padding:2px 4px;"><b>Reactive</b></td><td style="padding:2px 4px;">Non-reactive</td><td style="padding:2px 4px;"><b>Late Acute / Convalescent Primary Dengue</b> (&gt; Day 5)</td></tr>
  <tr><td style="padding:2px 4px;"><b>Reactive</b> / Non-react</td><td style="padding:2px 4px;"><b>Reactive</b></td><td style="padding:2px 4px;"><b>Reactive</b></td><td style="padding:2px 4px;"><b>Acute Secondary Dengue</b> (High risk for plasma leakage / DHF; monitor platelets &amp; hematocrit)</td></tr>
  <tr><td style="padding:2px 4px;">Non-reactive</td><td style="padding:2px 4px;">Non-reactive</td><td style="padding:2px 4px;"><b>Reactive</b></td><td style="padding:2px 4px;"><b>Past Dengue Infection</b> (Distant immunity; no evidence of acute dengue)</td></tr>
</table>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'DENGUE'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Comprehensive Dengue Serology Staging Guide:</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:20%; padding:2px 4px;">NS1 Antigen</th>
    <th style="width:18%; padding:2px 4px;">IgM Antibody</th>
    <th style="width:18%; padding:2px 4px;">IgG Antibody</th>
    <th style="width:44%; padding:2px 4px;">Clinical Staging &amp; Interpretation</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>Reactive</b></td><td style="padding:2px 4px;">Non-reactive</td><td style="padding:2px 4px;">Non-reactive</td><td style="padding:2px 4px;"><b>Early Acute Primary Dengue</b> (Day 1 – 4 of fever onset)</td></tr>
  <tr><td style="padding:2px 4px;"><b>Reactive</b></td><td style="padding:2px 4px;"><b>Reactive</b></td><td style="padding:2px 4px;">Non-reactive</td><td style="padding:2px 4px;"><b>Acute Primary Dengue</b> (Day 4 – 7 of fever)</td></tr>
  <tr><td style="padding:2px 4px;">Non-reactive</td><td style="padding:2px 4px;"><b>Reactive</b></td><td style="padding:2px 4px;">Non-reactive</td><td style="padding:2px 4px;"><b>Late Acute / Convalescent Primary Dengue</b> (&gt; Day 5)</td></tr>
  <tr><td style="padding:2px 4px;"><b>Reactive</b> / Non-react</td><td style="padding:2px 4px;"><b>Reactive</b></td><td style="padding:2px 4px;"><b>Reactive</b></td><td style="padding:2px 4px;"><b>Acute Secondary Dengue</b> (High risk for plasma leakage / DHF; monitor platelets &amp; hematocrit)</td></tr>
  <tr><td style="padding:2px 4px;">Non-reactive</td><td style="padding:2px 4px;">Non-reactive</td><td style="padding:2px 4px;"><b>Reactive</b></td><td style="padding:2px 4px;"><b>Past Dengue Infection</b> (Distant immunity; no evidence of acute dengue)</td></tr>
</table>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: CHIK-IGM
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Chikungunya IgM Serology Interpretation:</b><br>
• Detectable from Day 4 to 5 after onset of fever with debilitating polyarthralgia.<br>
• <b>Positive:</b> Confirms acute or recent Chikungunya viral infection.<br>
• <b>Negative:</b> Does not rule out infection if sample taken &lt; 4 days from symptom onset; repeat testing in 7 days recommended if severe symmetrical joint pain persists.</p>' WHERE `test_code` = 'CHIK-IGM';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Chikungunya IgM Serology Interpretation:</b><br>
• Detectable from Day 4 to 5 after onset of fever with debilitating polyarthralgia.<br>
• <b>Positive:</b> Confirms acute or recent Chikungunya viral infection.<br>
• <b>Negative:</b> Does not rule out infection if sample taken &lt; 4 days from symptom onset; repeat testing in 7 days recommended if severe symmetrical joint pain persists.</p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'CHIK-IGM'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Chikungunya IgM Serology Interpretation:</b><br>
• Detectable from Day 4 to 5 after onset of fever with debilitating polyarthralgia.<br>
• <b>Positive:</b> Confirms acute or recent Chikungunya viral infection.<br>
• <b>Negative:</b> Does not rule out infection if sample taken &lt; 4 days from symptom onset; repeat testing in 7 days recommended if severe symmetrical joint pain persists.</p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: CRP
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>C-Reactive Protein (CRP, Quantitative) Clinical Significance:</b> Prototypic acute-phase reactant synthesized by hepatocytes under IL-6 stimulation.<br>
• <b>&lt; 6.0 mg/L:</b> Normal / Baseline level.<br>
• <b>10 – 40 mg/L:</b> Mild/moderate systemic inflammation (viral infections, mild arthritis, localized tissue injury).<br>
• <b>&gt; 50 – 100 mg/L:</b> Severe acute bacterial infection, deep sepsis, pneumonia, active systemic vasculitis, acute pancreatitis.<br>
• Useful for monitoring antibiotic response and infection resolution (rapid drop matches clinical recovery).</p>' WHERE `test_code` = 'CRP';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>C-Reactive Protein (CRP, Quantitative) Clinical Significance:</b> Prototypic acute-phase reactant synthesized by hepatocytes under IL-6 stimulation.<br>
• <b>&lt; 6.0 mg/L:</b> Normal / Baseline level.<br>
• <b>10 – 40 mg/L:</b> Mild/moderate systemic inflammation (viral infections, mild arthritis, localized tissue injury).<br>
• <b>&gt; 50 – 100 mg/L:</b> Severe acute bacterial infection, deep sepsis, pneumonia, active systemic vasculitis, acute pancreatitis.<br>
• Useful for monitoring antibiotic response and infection resolution (rapid drop matches clinical recovery).</p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'CRP'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>C-Reactive Protein (CRP, Quantitative) Clinical Significance:</b> Prototypic acute-phase reactant synthesized by hepatocytes under IL-6 stimulation.<br>
• <b>&lt; 6.0 mg/L:</b> Normal / Baseline level.<br>
• <b>10 – 40 mg/L:</b> Mild/moderate systemic inflammation (viral infections, mild arthritis, localized tissue injury).<br>
• <b>&gt; 50 – 100 mg/L:</b> Severe acute bacterial infection, deep sepsis, pneumonia, active systemic vasculitis, acute pancreatitis.<br>
• Useful for monitoring antibiotic response and infection resolution (rapid drop matches clinical recovery).</p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: HS-CRP
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>High Sensitivity CRP (hs-CRP) Cardiovascular Risk Assessment (AHA / CDC Guidelines):</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:35%; padding:2px 4px;">hs-CRP Level (mg/L)</th>
    <th style="width:35%; padding:2px 4px;">Relative 10-Year Cardiovascular Risk</th>
    <th style="width:30%; padding:2px 4px;">Clinical Interpretation</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>&lt; 1.0 mg/L</b></td><td style="padding:2px 4px;">Low Risk</td><td style="padding:2px 4px;">Minimal baseline vascular inflammation</td></tr>
  <tr><td style="padding:2px 4px;"><b>1.0 – 3.0 mg/L</b></td><td style="padding:2px 4px;">Average / Moderate Risk</td><td style="padding:2px 4px;">Intermediate vascular risk</td></tr>
  <tr><td style="padding:2px 4px;"><b>&gt; 3.0 mg/L</b></td><td style="padding:2px 4px;">High Relative Risk</td><td style="padding:2px 4px;">Elevated coronary heart disease risk</td></tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Note: If hs-CRP &gt; 10 mg/L, acute intercurrent infection or trauma should be ruled out; repeat in 2 weeks in stable metabolic state.</i></p>' WHERE `test_code` = 'HS-CRP';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>High Sensitivity CRP (hs-CRP) Cardiovascular Risk Assessment (AHA / CDC Guidelines):</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:35%; padding:2px 4px;">hs-CRP Level (mg/L)</th>
    <th style="width:35%; padding:2px 4px;">Relative 10-Year Cardiovascular Risk</th>
    <th style="width:30%; padding:2px 4px;">Clinical Interpretation</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>&lt; 1.0 mg/L</b></td><td style="padding:2px 4px;">Low Risk</td><td style="padding:2px 4px;">Minimal baseline vascular inflammation</td></tr>
  <tr><td style="padding:2px 4px;"><b>1.0 – 3.0 mg/L</b></td><td style="padding:2px 4px;">Average / Moderate Risk</td><td style="padding:2px 4px;">Intermediate vascular risk</td></tr>
  <tr><td style="padding:2px 4px;"><b>&gt; 3.0 mg/L</b></td><td style="padding:2px 4px;">High Relative Risk</td><td style="padding:2px 4px;">Elevated coronary heart disease risk</td></tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Note: If hs-CRP &gt; 10 mg/L, acute intercurrent infection or trauma should be ruled out; repeat in 2 weeks in stable metabolic state.</i></p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'HS-CRP'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>High Sensitivity CRP (hs-CRP) Cardiovascular Risk Assessment (AHA / CDC Guidelines):</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:35%; padding:2px 4px;">hs-CRP Level (mg/L)</th>
    <th style="width:35%; padding:2px 4px;">Relative 10-Year Cardiovascular Risk</th>
    <th style="width:30%; padding:2px 4px;">Clinical Interpretation</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>&lt; 1.0 mg/L</b></td><td style="padding:2px 4px;">Low Risk</td><td style="padding:2px 4px;">Minimal baseline vascular inflammation</td></tr>
  <tr><td style="padding:2px 4px;"><b>1.0 – 3.0 mg/L</b></td><td style="padding:2px 4px;">Average / Moderate Risk</td><td style="padding:2px 4px;">Intermediate vascular risk</td></tr>
  <tr><td style="padding:2px 4px;"><b>&gt; 3.0 mg/L</b></td><td style="padding:2px 4px;">High Relative Risk</td><td style="padding:2px 4px;">Elevated coronary heart disease risk</td></tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Note: If hs-CRP &gt; 10 mg/L, acute intercurrent infection or trauma should be ruled out; repeat in 2 weeks in stable metabolic state.</i></p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: RA-FACTOR
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Rheumatoid Factor (RF) Clinical Interpretation:</b> Autoantibody (predominantly IgM) directed against the Fc fragment of human IgG.<br>
• <b>Positive (&gt; 20 IU/mL):</b> Present in 70–80% of adult patients with Rheumatoid Arthritis (RA). Higher titers correlate with erosive joint disease, subcutaneous nodules, and extra-articular manifestations.<br>
• <b>Other Causes of Positive RF:</b> Sjögren syndrome (75–90%), SLE, systemic sclerosis, chronic hepatitis C, active tuberculosis, leprosy, subacute bacterial endocarditis, healthy elderly (5%).<br>
• <b>Anti-CCP Antibody:</b> Recommended for higher diagnostic specificity (&gt; 96%) in early rheumatoid arthritis.</p>' WHERE `test_code` = 'RA-FACTOR';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Rheumatoid Factor (RF) Clinical Interpretation:</b> Autoantibody (predominantly IgM) directed against the Fc fragment of human IgG.<br>
• <b>Positive (&gt; 20 IU/mL):</b> Present in 70–80% of adult patients with Rheumatoid Arthritis (RA). Higher titers correlate with erosive joint disease, subcutaneous nodules, and extra-articular manifestations.<br>
• <b>Other Causes of Positive RF:</b> Sjögren syndrome (75–90%), SLE, systemic sclerosis, chronic hepatitis C, active tuberculosis, leprosy, subacute bacterial endocarditis, healthy elderly (5%).<br>
• <b>Anti-CCP Antibody:</b> Recommended for higher diagnostic specificity (&gt; 96%) in early rheumatoid arthritis.</p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'RA-FACTOR'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Rheumatoid Factor (RF) Clinical Interpretation:</b> Autoantibody (predominantly IgM) directed against the Fc fragment of human IgG.<br>
• <b>Positive (&gt; 20 IU/mL):</b> Present in 70–80% of adult patients with Rheumatoid Arthritis (RA). Higher titers correlate with erosive joint disease, subcutaneous nodules, and extra-articular manifestations.<br>
• <b>Other Causes of Positive RF:</b> Sjögren syndrome (75–90%), SLE, systemic sclerosis, chronic hepatitis C, active tuberculosis, leprosy, subacute bacterial endocarditis, healthy elderly (5%).<br>
• <b>Anti-CCP Antibody:</b> Recommended for higher diagnostic specificity (&gt; 96%) in early rheumatoid arthritis.</p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: ASO
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Anti-Streptolysin O (ASO) Titre Interpretation:</b> Detects neutralizing antibodies to streptolysin O toxin produced by Group A beta-hemolytic *Streptococcus pyogenes*.<br>
• <b>Titre &gt; 200 IU/mL:</b> Confirms antecedent streptococcal pharyngeal infection.<br>
• Crucial supportive diagnostic criterion for Acute Rheumatic Fever (Jones Criteria) and Post-Streptococcal Acute Glomerulonephritis (PSAGN).<br>
<span style="font-size:7pt; color:#64748b;"><i>Note: A single elevated titer indicates past exposure within 2–6 months; a rising or falling serial titer is clinically more significant.</i></span></p>' WHERE `test_code` = 'ASO';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Anti-Streptolysin O (ASO) Titre Interpretation:</b> Detects neutralizing antibodies to streptolysin O toxin produced by Group A beta-hemolytic *Streptococcus pyogenes*.<br>
• <b>Titre &gt; 200 IU/mL:</b> Confirms antecedent streptococcal pharyngeal infection.<br>
• Crucial supportive diagnostic criterion for Acute Rheumatic Fever (Jones Criteria) and Post-Streptococcal Acute Glomerulonephritis (PSAGN).<br>
<span style="font-size:7pt; color:#64748b;"><i>Note: A single elevated titer indicates past exposure within 2–6 months; a rising or falling serial titer is clinically more significant.</i></span></p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'ASO'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Anti-Streptolysin O (ASO) Titre Interpretation:</b> Detects neutralizing antibodies to streptolysin O toxin produced by Group A beta-hemolytic *Streptococcus pyogenes*.<br>
• <b>Titre &gt; 200 IU/mL:</b> Confirms antecedent streptococcal pharyngeal infection.<br>
• Crucial supportive diagnostic criterion for Acute Rheumatic Fever (Jones Criteria) and Post-Streptococcal Acute Glomerulonephritis (PSAGN).<br>
<span style="font-size:7pt; color:#64748b;"><i>Note: A single elevated titer indicates past exposure within 2–6 months; a rising or falling serial titer is clinically more significant.</i></span></p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: HIV
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>HIV I &amp; II Antibody Screening:</b><br>
• <b>Non-Reactive:</b> No antibodies to HIV-1 or HIV-2 detected. Does not rule out infection during the early "window period" (first 2 to 4 weeks post-exposure).<br>
• <b>Reactive:</b> Initial screening test reactive. As per NACO / WHO guidelines, a reactive screening result must be confirmed by three different test principles / kits or Western Blot / HIV-1 RNA PCR before issuing a positive diagnostic report. Confidential post-test counseling is advised.</p>' WHERE `test_code` = 'HIV';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>HIV I &amp; II Antibody Screening:</b><br>
• <b>Non-Reactive:</b> No antibodies to HIV-1 or HIV-2 detected. Does not rule out infection during the early "window period" (first 2 to 4 weeks post-exposure).<br>
• <b>Reactive:</b> Initial screening test reactive. As per NACO / WHO guidelines, a reactive screening result must be confirmed by three different test principles / kits or Western Blot / HIV-1 RNA PCR before issuing a positive diagnostic report. Confidential post-test counseling is advised.</p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'HIV'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>HIV I &amp; II Antibody Screening:</b><br>
• <b>Non-Reactive:</b> No antibodies to HIV-1 or HIV-2 detected. Does not rule out infection during the early "window period" (first 2 to 4 weeks post-exposure).<br>
• <b>Reactive:</b> Initial screening test reactive. As per NACO / WHO guidelines, a reactive screening result must be confirmed by three different test principles / kits or Western Blot / HIV-1 RNA PCR before issuing a positive diagnostic report. Confidential post-test counseling is advised.</p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: HBSAG
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Hepatitis B Surface Antigen (HBsAg) Interpretation:</b><br>
• <b>Non-Reactive:</b> No active circulating Hepatitis B surface antigen detected.<br>
• <b>Reactive:</b> Confirms active Hepatitis B viral infection (acute or chronic hepatitis B carrier state).<br>
• <b>Further Workup:</b> HBeAg, Anti-HBe, Anti-HBc IgM (to differentiate acute vs chronic), HBV DNA quantitative viral load by real-time PCR, and Liver Function Tests.</p>' WHERE `test_code` = 'HBSAG';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Hepatitis B Surface Antigen (HBsAg) Interpretation:</b><br>
• <b>Non-Reactive:</b> No active circulating Hepatitis B surface antigen detected.<br>
• <b>Reactive:</b> Confirms active Hepatitis B viral infection (acute or chronic hepatitis B carrier state).<br>
• <b>Further Workup:</b> HBeAg, Anti-HBe, Anti-HBc IgM (to differentiate acute vs chronic), HBV DNA quantitative viral load by real-time PCR, and Liver Function Tests.</p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'HBSAG'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Hepatitis B Surface Antigen (HBsAg) Interpretation:</b><br>
• <b>Non-Reactive:</b> No active circulating Hepatitis B surface antigen detected.<br>
• <b>Reactive:</b> Confirms active Hepatitis B viral infection (acute or chronic hepatitis B carrier state).<br>
• <b>Further Workup:</b> HBeAg, Anti-HBe, Anti-HBc IgM (to differentiate acute vs chronic), HBV DNA quantitative viral load by real-time PCR, and Liver Function Tests.</p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: HCV
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Anti-HCV Antibody Screening:</b><br>
• <b>Non-Reactive:</b> No detectable antibodies to Hepatitis C virus.<br>
• <b>Reactive:</b> Indicates current active infection, chronic hepatitis C, or resolved past infection.<br>
• <b>Next Step:</b> Quantitative HCV RNA Real-Time PCR testing is mandatory to confirm active viral replication prior to direct-acting antiviral (DAA) therapy.</p>' WHERE `test_code` = 'HCV';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Anti-HCV Antibody Screening:</b><br>
• <b>Non-Reactive:</b> No detectable antibodies to Hepatitis C virus.<br>
• <b>Reactive:</b> Indicates current active infection, chronic hepatitis C, or resolved past infection.<br>
• <b>Next Step:</b> Quantitative HCV RNA Real-Time PCR testing is mandatory to confirm active viral replication prior to direct-acting antiviral (DAA) therapy.</p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'HCV'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Anti-HCV Antibody Screening:</b><br>
• <b>Non-Reactive:</b> No detectable antibodies to Hepatitis C virus.<br>
• <b>Reactive:</b> Indicates current active infection, chronic hepatitis C, or resolved past infection.<br>
• <b>Next Step:</b> Quantitative HCV RNA Real-Time PCR testing is mandatory to confirm active viral replication prior to direct-acting antiviral (DAA) therapy.</p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: VDRL
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>VDRL / RPR Syphilis Screen Interpretation:</b> Non-treponemal flocculation test measuring anti-cardiolipin antibodies.<br>
• <b>Non-Reactive:</b> Seronegative for active syphilis. (May be non-reactive in very early primary chancre or late tertiary syphilis).<br>
• <b>Reactive:</b> Suggestive of active or treated *Treponema pallidum* (syphilis) infection. Reported with quantitative endpoint titer (e.g., 1:8, 1:16). A four-fold change in titer evaluates treatment response.<br>
• <b>Biological False Positives:</b> Can occur in pregnancy, autoimmune lupus (APLA), malaria, leprosy, viral hepatitis, and advanced age. Specific treponemal confirmation (TPHA / FTA-ABS) recommended.</p>' WHERE `test_code` = 'VDRL';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>VDRL / RPR Syphilis Screen Interpretation:</b> Non-treponemal flocculation test measuring anti-cardiolipin antibodies.<br>
• <b>Non-Reactive:</b> Seronegative for active syphilis. (May be non-reactive in very early primary chancre or late tertiary syphilis).<br>
• <b>Reactive:</b> Suggestive of active or treated *Treponema pallidum* (syphilis) infection. Reported with quantitative endpoint titer (e.g., 1:8, 1:16). A four-fold change in titer evaluates treatment response.<br>
• <b>Biological False Positives:</b> Can occur in pregnancy, autoimmune lupus (APLA), malaria, leprosy, viral hepatitis, and advanced age. Specific treponemal confirmation (TPHA / FTA-ABS) recommended.</p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'VDRL'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>VDRL / RPR Syphilis Screen Interpretation:</b> Non-treponemal flocculation test measuring anti-cardiolipin antibodies.<br>
• <b>Non-Reactive:</b> Seronegative for active syphilis. (May be non-reactive in very early primary chancre or late tertiary syphilis).<br>
• <b>Reactive:</b> Suggestive of active or treated *Treponema pallidum* (syphilis) infection. Reported with quantitative endpoint titer (e.g., 1:8, 1:16). A four-fold change in titer evaluates treatment response.<br>
• <b>Biological False Positives:</b> Can occur in pregnancy, autoimmune lupus (APLA), malaria, leprosy, viral hepatitis, and advanced age. Specific treponemal confirmation (TPHA / FTA-ABS) recommended.</p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: IGE
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Total Serum IgE Interpretation:</b><br>
• <b>Elevated (&gt; 100 – 150 IU/mL):</b> Atopic allergic disorders (extrinsic bronchial asthma, allergic rhinitis, atopic eczema), parasitic helminthic infections (Ascaris, Echinococcus), allergic bronchopulmonary aspergillosis (ABPA), hyper-IgE syndrome.<br>
• Allergen-specific IgE blood panel or skin prick testing advised to identify specific offending environmental or food allergens.</p>' WHERE `test_code` = 'IGE';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Total Serum IgE Interpretation:</b><br>
• <b>Elevated (&gt; 100 – 150 IU/mL):</b> Atopic allergic disorders (extrinsic bronchial asthma, allergic rhinitis, atopic eczema), parasitic helminthic infections (Ascaris, Echinococcus), allergic bronchopulmonary aspergillosis (ABPA), hyper-IgE syndrome.<br>
• Allergen-specific IgE blood panel or skin prick testing advised to identify specific offending environmental or food allergens.</p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'IGE'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Total Serum IgE Interpretation:</b><br>
• <b>Elevated (&gt; 100 – 150 IU/mL):</b> Atopic allergic disorders (extrinsic bronchial asthma, allergic rhinitis, atopic eczema), parasitic helminthic infections (Ascaris, Echinococcus), allergic bronchopulmonary aspergillosis (ABPA), hyper-IgE syndrome.<br>
• Allergen-specific IgE blood panel or skin prick testing advised to identify specific offending environmental or food allergens.</p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: TFT
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Thyroid Function Test Hormonal Correlation Matrix:</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:28%; padding:2px 4px;">Clinical Thyroid State</th>
    <th style="width:24%; padding:2px 4px;">Serum TSH</th>
    <th style="width:24%; padding:2px 4px;">Free T3 / Total T3</th>
    <th style="width:24%; padding:2px 4px;">Free T4 / Total T4</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>Euthyroid (Normal)</b></td><td style="padding:2px 4px;">Normal (0.35 – 4.94)</td><td style="padding:2px 4px;">Normal</td><td style="padding:2px 4px;">Normal</td></tr>
  <tr><td style="padding:2px 4px;"><b>Primary Hypothyroidism</b></td><td style="padding:2px 4px;"><b>Elevated (&gt; 5.0)</b></td><td style="padding:2px 4px;">Low / Normal</td><td style="padding:2px 4px;"><b>Low</b></td></tr>
  <tr><td style="padding:2px 4px;"><b>Subclinical Hypothyroidism</b></td><td style="padding:2px 4px;"><b>Elevated (&gt; 5.0)</b></td><td style="padding:2px 4px;">Normal</td><td style="padding:2px 4px;">Normal</td></tr>
  <tr><td style="padding:2px 4px;"><b>Primary Hyperthyroidism</b></td><td style="padding:2px 4px;"><b>Suppressed (&lt; 0.1)</b></td><td style="padding:2px 4px;"><b>Elevated</b></td><td style="padding:2px 4px;"><b>Elevated</b></td></tr>
  <tr><td style="padding:2px 4px;"><b>Subclinical Hyperthyroidism</b></td><td style="padding:2px 4px;"><b>Low / Suppressed</b></td><td style="padding:2px 4px;">Normal</td><td style="padding:2px 4px;">Normal</td></tr>
  <tr><td style="padding:2px 4px;"><b>Central (Pituitary) Hypothyroid</b></td><td style="padding:2px 4px;">Low or Inappropriately Normal</td><td style="padding:2px 4px;">Low</td><td style="padding:2px 4px;">Low</td></tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Note: TSH exhibits physiological diurnal rhythm (peak at night/early morning). Fasting morning sample recommended. Non-thyroidal critical illness and pregnancy alter binding proteins (Free T3/Free T4 preferred).</i></p>' WHERE `test_code` = 'TFT';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Thyroid Function Test Hormonal Correlation Matrix:</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:28%; padding:2px 4px;">Clinical Thyroid State</th>
    <th style="width:24%; padding:2px 4px;">Serum TSH</th>
    <th style="width:24%; padding:2px 4px;">Free T3 / Total T3</th>
    <th style="width:24%; padding:2px 4px;">Free T4 / Total T4</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>Euthyroid (Normal)</b></td><td style="padding:2px 4px;">Normal (0.35 – 4.94)</td><td style="padding:2px 4px;">Normal</td><td style="padding:2px 4px;">Normal</td></tr>
  <tr><td style="padding:2px 4px;"><b>Primary Hypothyroidism</b></td><td style="padding:2px 4px;"><b>Elevated (&gt; 5.0)</b></td><td style="padding:2px 4px;">Low / Normal</td><td style="padding:2px 4px;"><b>Low</b></td></tr>
  <tr><td style="padding:2px 4px;"><b>Subclinical Hypothyroidism</b></td><td style="padding:2px 4px;"><b>Elevated (&gt; 5.0)</b></td><td style="padding:2px 4px;">Normal</td><td style="padding:2px 4px;">Normal</td></tr>
  <tr><td style="padding:2px 4px;"><b>Primary Hyperthyroidism</b></td><td style="padding:2px 4px;"><b>Suppressed (&lt; 0.1)</b></td><td style="padding:2px 4px;"><b>Elevated</b></td><td style="padding:2px 4px;"><b>Elevated</b></td></tr>
  <tr><td style="padding:2px 4px;"><b>Subclinical Hyperthyroidism</b></td><td style="padding:2px 4px;"><b>Low / Suppressed</b></td><td style="padding:2px 4px;">Normal</td><td style="padding:2px 4px;">Normal</td></tr>
  <tr><td style="padding:2px 4px;"><b>Central (Pituitary) Hypothyroid</b></td><td style="padding:2px 4px;">Low or Inappropriately Normal</td><td style="padding:2px 4px;">Low</td><td style="padding:2px 4px;">Low</td></tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Note: TSH exhibits physiological diurnal rhythm (peak at night/early morning). Fasting morning sample recommended. Non-thyroidal critical illness and pregnancy alter binding proteins (Free T3/Free T4 preferred).</i></p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'TFT'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Thyroid Function Test Hormonal Correlation Matrix:</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:28%; padding:2px 4px;">Clinical Thyroid State</th>
    <th style="width:24%; padding:2px 4px;">Serum TSH</th>
    <th style="width:24%; padding:2px 4px;">Free T3 / Total T3</th>
    <th style="width:24%; padding:2px 4px;">Free T4 / Total T4</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>Euthyroid (Normal)</b></td><td style="padding:2px 4px;">Normal (0.35 – 4.94)</td><td style="padding:2px 4px;">Normal</td><td style="padding:2px 4px;">Normal</td></tr>
  <tr><td style="padding:2px 4px;"><b>Primary Hypothyroidism</b></td><td style="padding:2px 4px;"><b>Elevated (&gt; 5.0)</b></td><td style="padding:2px 4px;">Low / Normal</td><td style="padding:2px 4px;"><b>Low</b></td></tr>
  <tr><td style="padding:2px 4px;"><b>Subclinical Hypothyroidism</b></td><td style="padding:2px 4px;"><b>Elevated (&gt; 5.0)</b></td><td style="padding:2px 4px;">Normal</td><td style="padding:2px 4px;">Normal</td></tr>
  <tr><td style="padding:2px 4px;"><b>Primary Hyperthyroidism</b></td><td style="padding:2px 4px;"><b>Suppressed (&lt; 0.1)</b></td><td style="padding:2px 4px;"><b>Elevated</b></td><td style="padding:2px 4px;"><b>Elevated</b></td></tr>
  <tr><td style="padding:2px 4px;"><b>Subclinical Hyperthyroidism</b></td><td style="padding:2px 4px;"><b>Low / Suppressed</b></td><td style="padding:2px 4px;">Normal</td><td style="padding:2px 4px;">Normal</td></tr>
  <tr><td style="padding:2px 4px;"><b>Central (Pituitary) Hypothyroid</b></td><td style="padding:2px 4px;">Low or Inappropriately Normal</td><td style="padding:2px 4px;">Low</td><td style="padding:2px 4px;">Low</td></tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Note: TSH exhibits physiological diurnal rhythm (peak at night/early morning). Fasting morning sample recommended. Non-thyroidal critical illness and pregnancy alter binding proteins (Free T3/Free T4 preferred).</i></p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: TSH
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>TSH Clinical Significance:</b> Chemiluminescent 3rd-generation TSH is the most sensitive first-line screening test for thyroid dysfunction and dosage titration of Levothyroxine therapy.<br>
• <b>TSH &gt; 10 µIU/mL:</b> Overt primary hypothyroidism; thyroxine replacement therapy generally indicated.<br>
• <b>TSH 4.5 – 10 µIU/mL:</b> Subclinical hypothyroidism; evaluate Anti-TPO antibodies, symptoms, pregnancy, and dyslipidemia before initiating treatment.<br>
• <b>TSH &lt; 0.1 µIU/mL:</b> Primary hyperthyroidism / Thyrotoxicosis or excessive thyroxine replacement.</p>' WHERE `test_code` = 'TSH';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>TSH Clinical Significance:</b> Chemiluminescent 3rd-generation TSH is the most sensitive first-line screening test for thyroid dysfunction and dosage titration of Levothyroxine therapy.<br>
• <b>TSH &gt; 10 µIU/mL:</b> Overt primary hypothyroidism; thyroxine replacement therapy generally indicated.<br>
• <b>TSH 4.5 – 10 µIU/mL:</b> Subclinical hypothyroidism; evaluate Anti-TPO antibodies, symptoms, pregnancy, and dyslipidemia before initiating treatment.<br>
• <b>TSH &lt; 0.1 µIU/mL:</b> Primary hyperthyroidism / Thyrotoxicosis or excessive thyroxine replacement.</p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'TSH'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>TSH Clinical Significance:</b> Chemiluminescent 3rd-generation TSH is the most sensitive first-line screening test for thyroid dysfunction and dosage titration of Levothyroxine therapy.<br>
• <b>TSH &gt; 10 µIU/mL:</b> Overt primary hypothyroidism; thyroxine replacement therapy generally indicated.<br>
• <b>TSH 4.5 – 10 µIU/mL:</b> Subclinical hypothyroidism; evaluate Anti-TPO antibodies, symptoms, pregnancy, and dyslipidemia before initiating treatment.<br>
• <b>TSH &lt; 0.1 µIU/mL:</b> Primary hyperthyroidism / Thyrotoxicosis or excessive thyroxine replacement.</p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: FTFT
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Thyroid Function Test Hormonal Correlation Matrix:</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:28%; padding:2px 4px;">Clinical Thyroid State</th>
    <th style="width:24%; padding:2px 4px;">Serum TSH</th>
    <th style="width:24%; padding:2px 4px;">Free T3 / Total T3</th>
    <th style="width:24%; padding:2px 4px;">Free T4 / Total T4</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>Euthyroid (Normal)</b></td><td style="padding:2px 4px;">Normal (0.35 – 4.94)</td><td style="padding:2px 4px;">Normal</td><td style="padding:2px 4px;">Normal</td></tr>
  <tr><td style="padding:2px 4px;"><b>Primary Hypothyroidism</b></td><td style="padding:2px 4px;"><b>Elevated (&gt; 5.0)</b></td><td style="padding:2px 4px;">Low / Normal</td><td style="padding:2px 4px;"><b>Low</b></td></tr>
  <tr><td style="padding:2px 4px;"><b>Subclinical Hypothyroidism</b></td><td style="padding:2px 4px;"><b>Elevated (&gt; 5.0)</b></td><td style="padding:2px 4px;">Normal</td><td style="padding:2px 4px;">Normal</td></tr>
  <tr><td style="padding:2px 4px;"><b>Primary Hyperthyroidism</b></td><td style="padding:2px 4px;"><b>Suppressed (&lt; 0.1)</b></td><td style="padding:2px 4px;"><b>Elevated</b></td><td style="padding:2px 4px;"><b>Elevated</b></td></tr>
  <tr><td style="padding:2px 4px;"><b>Subclinical Hyperthyroidism</b></td><td style="padding:2px 4px;"><b>Low / Suppressed</b></td><td style="padding:2px 4px;">Normal</td><td style="padding:2px 4px;">Normal</td></tr>
  <tr><td style="padding:2px 4px;"><b>Central (Pituitary) Hypothyroid</b></td><td style="padding:2px 4px;">Low or Inappropriately Normal</td><td style="padding:2px 4px;">Low</td><td style="padding:2px 4px;">Low</td></tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Note: TSH exhibits physiological diurnal rhythm (peak at night/early morning). Fasting morning sample recommended. Non-thyroidal critical illness and pregnancy alter binding proteins (Free T3/Free T4 preferred).</i></p>' WHERE `test_code` = 'FTFT';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Thyroid Function Test Hormonal Correlation Matrix:</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:28%; padding:2px 4px;">Clinical Thyroid State</th>
    <th style="width:24%; padding:2px 4px;">Serum TSH</th>
    <th style="width:24%; padding:2px 4px;">Free T3 / Total T3</th>
    <th style="width:24%; padding:2px 4px;">Free T4 / Total T4</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>Euthyroid (Normal)</b></td><td style="padding:2px 4px;">Normal (0.35 – 4.94)</td><td style="padding:2px 4px;">Normal</td><td style="padding:2px 4px;">Normal</td></tr>
  <tr><td style="padding:2px 4px;"><b>Primary Hypothyroidism</b></td><td style="padding:2px 4px;"><b>Elevated (&gt; 5.0)</b></td><td style="padding:2px 4px;">Low / Normal</td><td style="padding:2px 4px;"><b>Low</b></td></tr>
  <tr><td style="padding:2px 4px;"><b>Subclinical Hypothyroidism</b></td><td style="padding:2px 4px;"><b>Elevated (&gt; 5.0)</b></td><td style="padding:2px 4px;">Normal</td><td style="padding:2px 4px;">Normal</td></tr>
  <tr><td style="padding:2px 4px;"><b>Primary Hyperthyroidism</b></td><td style="padding:2px 4px;"><b>Suppressed (&lt; 0.1)</b></td><td style="padding:2px 4px;"><b>Elevated</b></td><td style="padding:2px 4px;"><b>Elevated</b></td></tr>
  <tr><td style="padding:2px 4px;"><b>Subclinical Hyperthyroidism</b></td><td style="padding:2px 4px;"><b>Low / Suppressed</b></td><td style="padding:2px 4px;">Normal</td><td style="padding:2px 4px;">Normal</td></tr>
  <tr><td style="padding:2px 4px;"><b>Central (Pituitary) Hypothyroid</b></td><td style="padding:2px 4px;">Low or Inappropriately Normal</td><td style="padding:2px 4px;">Low</td><td style="padding:2px 4px;">Low</td></tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Note: TSH exhibits physiological diurnal rhythm (peak at night/early morning). Fasting morning sample recommended. Non-thyroidal critical illness and pregnancy alter binding proteins (Free T3/Free T4 preferred).</i></p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'FTFT'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Thyroid Function Test Hormonal Correlation Matrix:</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:28%; padding:2px 4px;">Clinical Thyroid State</th>
    <th style="width:24%; padding:2px 4px;">Serum TSH</th>
    <th style="width:24%; padding:2px 4px;">Free T3 / Total T3</th>
    <th style="width:24%; padding:2px 4px;">Free T4 / Total T4</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>Euthyroid (Normal)</b></td><td style="padding:2px 4px;">Normal (0.35 – 4.94)</td><td style="padding:2px 4px;">Normal</td><td style="padding:2px 4px;">Normal</td></tr>
  <tr><td style="padding:2px 4px;"><b>Primary Hypothyroidism</b></td><td style="padding:2px 4px;"><b>Elevated (&gt; 5.0)</b></td><td style="padding:2px 4px;">Low / Normal</td><td style="padding:2px 4px;"><b>Low</b></td></tr>
  <tr><td style="padding:2px 4px;"><b>Subclinical Hypothyroidism</b></td><td style="padding:2px 4px;"><b>Elevated (&gt; 5.0)</b></td><td style="padding:2px 4px;">Normal</td><td style="padding:2px 4px;">Normal</td></tr>
  <tr><td style="padding:2px 4px;"><b>Primary Hyperthyroidism</b></td><td style="padding:2px 4px;"><b>Suppressed (&lt; 0.1)</b></td><td style="padding:2px 4px;"><b>Elevated</b></td><td style="padding:2px 4px;"><b>Elevated</b></td></tr>
  <tr><td style="padding:2px 4px;"><b>Subclinical Hyperthyroidism</b></td><td style="padding:2px 4px;"><b>Low / Suppressed</b></td><td style="padding:2px 4px;">Normal</td><td style="padding:2px 4px;">Normal</td></tr>
  <tr><td style="padding:2px 4px;"><b>Central (Pituitary) Hypothyroid</b></td><td style="padding:2px 4px;">Low or Inappropriately Normal</td><td style="padding:2px 4px;">Low</td><td style="padding:2px 4px;">Low</td></tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Note: TSH exhibits physiological diurnal rhythm (peak at night/early morning). Fasting morning sample recommended. Non-thyroidal critical illness and pregnancy alter binding proteins (Free T3/Free T4 preferred).</i></p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: FT3
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Thyroid Function Test Hormonal Correlation Matrix:</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:28%; padding:2px 4px;">Clinical Thyroid State</th>
    <th style="width:24%; padding:2px 4px;">Serum TSH</th>
    <th style="width:24%; padding:2px 4px;">Free T3 / Total T3</th>
    <th style="width:24%; padding:2px 4px;">Free T4 / Total T4</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>Euthyroid (Normal)</b></td><td style="padding:2px 4px;">Normal (0.35 – 4.94)</td><td style="padding:2px 4px;">Normal</td><td style="padding:2px 4px;">Normal</td></tr>
  <tr><td style="padding:2px 4px;"><b>Primary Hypothyroidism</b></td><td style="padding:2px 4px;"><b>Elevated (&gt; 5.0)</b></td><td style="padding:2px 4px;">Low / Normal</td><td style="padding:2px 4px;"><b>Low</b></td></tr>
  <tr><td style="padding:2px 4px;"><b>Subclinical Hypothyroidism</b></td><td style="padding:2px 4px;"><b>Elevated (&gt; 5.0)</b></td><td style="padding:2px 4px;">Normal</td><td style="padding:2px 4px;">Normal</td></tr>
  <tr><td style="padding:2px 4px;"><b>Primary Hyperthyroidism</b></td><td style="padding:2px 4px;"><b>Suppressed (&lt; 0.1)</b></td><td style="padding:2px 4px;"><b>Elevated</b></td><td style="padding:2px 4px;"><b>Elevated</b></td></tr>
  <tr><td style="padding:2px 4px;"><b>Subclinical Hyperthyroidism</b></td><td style="padding:2px 4px;"><b>Low / Suppressed</b></td><td style="padding:2px 4px;">Normal</td><td style="padding:2px 4px;">Normal</td></tr>
  <tr><td style="padding:2px 4px;"><b>Central (Pituitary) Hypothyroid</b></td><td style="padding:2px 4px;">Low or Inappropriately Normal</td><td style="padding:2px 4px;">Low</td><td style="padding:2px 4px;">Low</td></tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Note: TSH exhibits physiological diurnal rhythm (peak at night/early morning). Fasting morning sample recommended. Non-thyroidal critical illness and pregnancy alter binding proteins (Free T3/Free T4 preferred).</i></p>' WHERE `test_code` = 'FT3';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Thyroid Function Test Hormonal Correlation Matrix:</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:28%; padding:2px 4px;">Clinical Thyroid State</th>
    <th style="width:24%; padding:2px 4px;">Serum TSH</th>
    <th style="width:24%; padding:2px 4px;">Free T3 / Total T3</th>
    <th style="width:24%; padding:2px 4px;">Free T4 / Total T4</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>Euthyroid (Normal)</b></td><td style="padding:2px 4px;">Normal (0.35 – 4.94)</td><td style="padding:2px 4px;">Normal</td><td style="padding:2px 4px;">Normal</td></tr>
  <tr><td style="padding:2px 4px;"><b>Primary Hypothyroidism</b></td><td style="padding:2px 4px;"><b>Elevated (&gt; 5.0)</b></td><td style="padding:2px 4px;">Low / Normal</td><td style="padding:2px 4px;"><b>Low</b></td></tr>
  <tr><td style="padding:2px 4px;"><b>Subclinical Hypothyroidism</b></td><td style="padding:2px 4px;"><b>Elevated (&gt; 5.0)</b></td><td style="padding:2px 4px;">Normal</td><td style="padding:2px 4px;">Normal</td></tr>
  <tr><td style="padding:2px 4px;"><b>Primary Hyperthyroidism</b></td><td style="padding:2px 4px;"><b>Suppressed (&lt; 0.1)</b></td><td style="padding:2px 4px;"><b>Elevated</b></td><td style="padding:2px 4px;"><b>Elevated</b></td></tr>
  <tr><td style="padding:2px 4px;"><b>Subclinical Hyperthyroidism</b></td><td style="padding:2px 4px;"><b>Low / Suppressed</b></td><td style="padding:2px 4px;">Normal</td><td style="padding:2px 4px;">Normal</td></tr>
  <tr><td style="padding:2px 4px;"><b>Central (Pituitary) Hypothyroid</b></td><td style="padding:2px 4px;">Low or Inappropriately Normal</td><td style="padding:2px 4px;">Low</td><td style="padding:2px 4px;">Low</td></tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Note: TSH exhibits physiological diurnal rhythm (peak at night/early morning). Fasting morning sample recommended. Non-thyroidal critical illness and pregnancy alter binding proteins (Free T3/Free T4 preferred).</i></p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'FT3'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Thyroid Function Test Hormonal Correlation Matrix:</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:28%; padding:2px 4px;">Clinical Thyroid State</th>
    <th style="width:24%; padding:2px 4px;">Serum TSH</th>
    <th style="width:24%; padding:2px 4px;">Free T3 / Total T3</th>
    <th style="width:24%; padding:2px 4px;">Free T4 / Total T4</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>Euthyroid (Normal)</b></td><td style="padding:2px 4px;">Normal (0.35 – 4.94)</td><td style="padding:2px 4px;">Normal</td><td style="padding:2px 4px;">Normal</td></tr>
  <tr><td style="padding:2px 4px;"><b>Primary Hypothyroidism</b></td><td style="padding:2px 4px;"><b>Elevated (&gt; 5.0)</b></td><td style="padding:2px 4px;">Low / Normal</td><td style="padding:2px 4px;"><b>Low</b></td></tr>
  <tr><td style="padding:2px 4px;"><b>Subclinical Hypothyroidism</b></td><td style="padding:2px 4px;"><b>Elevated (&gt; 5.0)</b></td><td style="padding:2px 4px;">Normal</td><td style="padding:2px 4px;">Normal</td></tr>
  <tr><td style="padding:2px 4px;"><b>Primary Hyperthyroidism</b></td><td style="padding:2px 4px;"><b>Suppressed (&lt; 0.1)</b></td><td style="padding:2px 4px;"><b>Elevated</b></td><td style="padding:2px 4px;"><b>Elevated</b></td></tr>
  <tr><td style="padding:2px 4px;"><b>Subclinical Hyperthyroidism</b></td><td style="padding:2px 4px;"><b>Low / Suppressed</b></td><td style="padding:2px 4px;">Normal</td><td style="padding:2px 4px;">Normal</td></tr>
  <tr><td style="padding:2px 4px;"><b>Central (Pituitary) Hypothyroid</b></td><td style="padding:2px 4px;">Low or Inappropriately Normal</td><td style="padding:2px 4px;">Low</td><td style="padding:2px 4px;">Low</td></tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Note: TSH exhibits physiological diurnal rhythm (peak at night/early morning). Fasting morning sample recommended. Non-thyroidal critical illness and pregnancy alter binding proteins (Free T3/Free T4 preferred).</i></p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: FT4
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Thyroid Function Test Hormonal Correlation Matrix:</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:28%; padding:2px 4px;">Clinical Thyroid State</th>
    <th style="width:24%; padding:2px 4px;">Serum TSH</th>
    <th style="width:24%; padding:2px 4px;">Free T3 / Total T3</th>
    <th style="width:24%; padding:2px 4px;">Free T4 / Total T4</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>Euthyroid (Normal)</b></td><td style="padding:2px 4px;">Normal (0.35 – 4.94)</td><td style="padding:2px 4px;">Normal</td><td style="padding:2px 4px;">Normal</td></tr>
  <tr><td style="padding:2px 4px;"><b>Primary Hypothyroidism</b></td><td style="padding:2px 4px;"><b>Elevated (&gt; 5.0)</b></td><td style="padding:2px 4px;">Low / Normal</td><td style="padding:2px 4px;"><b>Low</b></td></tr>
  <tr><td style="padding:2px 4px;"><b>Subclinical Hypothyroidism</b></td><td style="padding:2px 4px;"><b>Elevated (&gt; 5.0)</b></td><td style="padding:2px 4px;">Normal</td><td style="padding:2px 4px;">Normal</td></tr>
  <tr><td style="padding:2px 4px;"><b>Primary Hyperthyroidism</b></td><td style="padding:2px 4px;"><b>Suppressed (&lt; 0.1)</b></td><td style="padding:2px 4px;"><b>Elevated</b></td><td style="padding:2px 4px;"><b>Elevated</b></td></tr>
  <tr><td style="padding:2px 4px;"><b>Subclinical Hyperthyroidism</b></td><td style="padding:2px 4px;"><b>Low / Suppressed</b></td><td style="padding:2px 4px;">Normal</td><td style="padding:2px 4px;">Normal</td></tr>
  <tr><td style="padding:2px 4px;"><b>Central (Pituitary) Hypothyroid</b></td><td style="padding:2px 4px;">Low or Inappropriately Normal</td><td style="padding:2px 4px;">Low</td><td style="padding:2px 4px;">Low</td></tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Note: TSH exhibits physiological diurnal rhythm (peak at night/early morning). Fasting morning sample recommended. Non-thyroidal critical illness and pregnancy alter binding proteins (Free T3/Free T4 preferred).</i></p>' WHERE `test_code` = 'FT4';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Thyroid Function Test Hormonal Correlation Matrix:</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:28%; padding:2px 4px;">Clinical Thyroid State</th>
    <th style="width:24%; padding:2px 4px;">Serum TSH</th>
    <th style="width:24%; padding:2px 4px;">Free T3 / Total T3</th>
    <th style="width:24%; padding:2px 4px;">Free T4 / Total T4</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>Euthyroid (Normal)</b></td><td style="padding:2px 4px;">Normal (0.35 – 4.94)</td><td style="padding:2px 4px;">Normal</td><td style="padding:2px 4px;">Normal</td></tr>
  <tr><td style="padding:2px 4px;"><b>Primary Hypothyroidism</b></td><td style="padding:2px 4px;"><b>Elevated (&gt; 5.0)</b></td><td style="padding:2px 4px;">Low / Normal</td><td style="padding:2px 4px;"><b>Low</b></td></tr>
  <tr><td style="padding:2px 4px;"><b>Subclinical Hypothyroidism</b></td><td style="padding:2px 4px;"><b>Elevated (&gt; 5.0)</b></td><td style="padding:2px 4px;">Normal</td><td style="padding:2px 4px;">Normal</td></tr>
  <tr><td style="padding:2px 4px;"><b>Primary Hyperthyroidism</b></td><td style="padding:2px 4px;"><b>Suppressed (&lt; 0.1)</b></td><td style="padding:2px 4px;"><b>Elevated</b></td><td style="padding:2px 4px;"><b>Elevated</b></td></tr>
  <tr><td style="padding:2px 4px;"><b>Subclinical Hyperthyroidism</b></td><td style="padding:2px 4px;"><b>Low / Suppressed</b></td><td style="padding:2px 4px;">Normal</td><td style="padding:2px 4px;">Normal</td></tr>
  <tr><td style="padding:2px 4px;"><b>Central (Pituitary) Hypothyroid</b></td><td style="padding:2px 4px;">Low or Inappropriately Normal</td><td style="padding:2px 4px;">Low</td><td style="padding:2px 4px;">Low</td></tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Note: TSH exhibits physiological diurnal rhythm (peak at night/early morning). Fasting morning sample recommended. Non-thyroidal critical illness and pregnancy alter binding proteins (Free T3/Free T4 preferred).</i></p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'FT4'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Thyroid Function Test Hormonal Correlation Matrix:</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:28%; padding:2px 4px;">Clinical Thyroid State</th>
    <th style="width:24%; padding:2px 4px;">Serum TSH</th>
    <th style="width:24%; padding:2px 4px;">Free T3 / Total T3</th>
    <th style="width:24%; padding:2px 4px;">Free T4 / Total T4</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>Euthyroid (Normal)</b></td><td style="padding:2px 4px;">Normal (0.35 – 4.94)</td><td style="padding:2px 4px;">Normal</td><td style="padding:2px 4px;">Normal</td></tr>
  <tr><td style="padding:2px 4px;"><b>Primary Hypothyroidism</b></td><td style="padding:2px 4px;"><b>Elevated (&gt; 5.0)</b></td><td style="padding:2px 4px;">Low / Normal</td><td style="padding:2px 4px;"><b>Low</b></td></tr>
  <tr><td style="padding:2px 4px;"><b>Subclinical Hypothyroidism</b></td><td style="padding:2px 4px;"><b>Elevated (&gt; 5.0)</b></td><td style="padding:2px 4px;">Normal</td><td style="padding:2px 4px;">Normal</td></tr>
  <tr><td style="padding:2px 4px;"><b>Primary Hyperthyroidism</b></td><td style="padding:2px 4px;"><b>Suppressed (&lt; 0.1)</b></td><td style="padding:2px 4px;"><b>Elevated</b></td><td style="padding:2px 4px;"><b>Elevated</b></td></tr>
  <tr><td style="padding:2px 4px;"><b>Subclinical Hyperthyroidism</b></td><td style="padding:2px 4px;"><b>Low / Suppressed</b></td><td style="padding:2px 4px;">Normal</td><td style="padding:2px 4px;">Normal</td></tr>
  <tr><td style="padding:2px 4px;"><b>Central (Pituitary) Hypothyroid</b></td><td style="padding:2px 4px;">Low or Inappropriately Normal</td><td style="padding:2px 4px;">Low</td><td style="padding:2px 4px;">Low</td></tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Note: TSH exhibits physiological diurnal rhythm (peak at night/early morning). Fasting morning sample recommended. Non-thyroidal critical illness and pregnancy alter binding proteins (Free T3/Free T4 preferred).</i></p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: VITD
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>25-Hydroxy Vitamin D (Total) Clinical Classification (Endocrine Society Guidelines):</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:30%; padding:2px 4px;">25-OH Vitamin D Level</th>
    <th style="width:35%; padding:2px 4px;">Clinical Status</th>
    <th style="width:35%; padding:2px 4px;">Clinical Implication &amp; Action</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>&lt; 20 ng/mL (&lt; 50 nmol/L)</b></td><td style="padding:2px 4px;"><b>Deficiency</b></td><td style="padding:2px 4px;">Impaired bone mineralization, osteomalacia, rickets, muscle aches; high-dose supplementation indicated</td></tr>
  <tr><td style="padding:2px 4px;"><b>20 – 30 ng/mL (50 – 75 nmol/L)</b></td><td style="padding:2px 4px;"><b>Insufficiency</b></td><td style="padding:2px 4px;">Suboptimal for calcium absorption and bone health; maintenance supplementation recommended</td></tr>
  <tr><td style="padding:2px 4px;"><b>30 – 100 ng/mL (75 – 250 nmol/L)</b></td><td style="padding:2px 4px;"><b>Sufficiency</b></td><td style="padding:2px 4px;">Optimal target range for skeletal, muscular, and immune health</td></tr>
  <tr><td style="padding:2px 4px;"><b>&gt; 100 ng/mL (&gt; 250 nmol/L)</b></td><td style="padding:2px 4px;"><b>Potential Toxicity / Hypervitaminosis D</b></td><td style="padding:2px 4px;">Risk of hypercalcemia, hypercalciuria, nephrocalcinosis, and renal stones</td></tr>
</table>' WHERE `test_code` = 'VITD';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>25-Hydroxy Vitamin D (Total) Clinical Classification (Endocrine Society Guidelines):</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:30%; padding:2px 4px;">25-OH Vitamin D Level</th>
    <th style="width:35%; padding:2px 4px;">Clinical Status</th>
    <th style="width:35%; padding:2px 4px;">Clinical Implication &amp; Action</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>&lt; 20 ng/mL (&lt; 50 nmol/L)</b></td><td style="padding:2px 4px;"><b>Deficiency</b></td><td style="padding:2px 4px;">Impaired bone mineralization, osteomalacia, rickets, muscle aches; high-dose supplementation indicated</td></tr>
  <tr><td style="padding:2px 4px;"><b>20 – 30 ng/mL (50 – 75 nmol/L)</b></td><td style="padding:2px 4px;"><b>Insufficiency</b></td><td style="padding:2px 4px;">Suboptimal for calcium absorption and bone health; maintenance supplementation recommended</td></tr>
  <tr><td style="padding:2px 4px;"><b>30 – 100 ng/mL (75 – 250 nmol/L)</b></td><td style="padding:2px 4px;"><b>Sufficiency</b></td><td style="padding:2px 4px;">Optimal target range for skeletal, muscular, and immune health</td></tr>
  <tr><td style="padding:2px 4px;"><b>&gt; 100 ng/mL (&gt; 250 nmol/L)</b></td><td style="padding:2px 4px;"><b>Potential Toxicity / Hypervitaminosis D</b></td><td style="padding:2px 4px;">Risk of hypercalcemia, hypercalciuria, nephrocalcinosis, and renal stones</td></tr>
</table>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'VITD'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>25-Hydroxy Vitamin D (Total) Clinical Classification (Endocrine Society Guidelines):</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:30%; padding:2px 4px;">25-OH Vitamin D Level</th>
    <th style="width:35%; padding:2px 4px;">Clinical Status</th>
    <th style="width:35%; padding:2px 4px;">Clinical Implication &amp; Action</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>&lt; 20 ng/mL (&lt; 50 nmol/L)</b></td><td style="padding:2px 4px;"><b>Deficiency</b></td><td style="padding:2px 4px;">Impaired bone mineralization, osteomalacia, rickets, muscle aches; high-dose supplementation indicated</td></tr>
  <tr><td style="padding:2px 4px;"><b>20 – 30 ng/mL (50 – 75 nmol/L)</b></td><td style="padding:2px 4px;"><b>Insufficiency</b></td><td style="padding:2px 4px;">Suboptimal for calcium absorption and bone health; maintenance supplementation recommended</td></tr>
  <tr><td style="padding:2px 4px;"><b>30 – 100 ng/mL (75 – 250 nmol/L)</b></td><td style="padding:2px 4px;"><b>Sufficiency</b></td><td style="padding:2px 4px;">Optimal target range for skeletal, muscular, and immune health</td></tr>
  <tr><td style="padding:2px 4px;"><b>&gt; 100 ng/mL (&gt; 250 nmol/L)</b></td><td style="padding:2px 4px;"><b>Potential Toxicity / Hypervitaminosis D</b></td><td style="padding:2px 4px;">Risk of hypercalcemia, hypercalciuria, nephrocalcinosis, and renal stones</td></tr>
</table>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: VITB12
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Serum Vitamin B12 (Cyanocobalamin) Clinical Classification:</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:30%; padding:2px 4px;">Vitamin B12 Level</th>
    <th style="width:35%; padding:2px 4px;">Diagnostic Classification</th>
    <th style="width:35%; padding:2px 4px;">Clinical Manifestations</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>&lt; 200 pg/mL (&lt; 148 pmol/L)</b></td><td style="padding:2px 4px;"><b>Deficiency</b></td><td style="padding:2px 4px;">Megaloblastic anemia, peripheral neuropathy (numbness, paresthesias), subacute combined spinal degeneration</td></tr>
  <tr><td style="padding:2px 4px;"><b>200 – 300 pg/mL</b></td><td style="padding:2px 4px;"><b>Borderline / Equivocal</b></td><td style="padding:2px 4px;">May have tissue-level deficiency; correlate with serum Homocysteine / Methylmalonic Acid (MMA)</td></tr>
  <tr><td style="padding:2px 4px;"><b>&gt; 300 – 900 pg/mL</b></td><td style="padding:2px 4px;"><b>Normal Range</b></td><td style="padding:2px 4px;">Adequate tissue cobalamin stores</td></tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>High prevalence in strict Indian vegetarian/vegan diets, elderly, prolonged Metformin or PPI antacid therapy, and post-bariatric gastrectomy.</i></p>' WHERE `test_code` = 'VITB12';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Serum Vitamin B12 (Cyanocobalamin) Clinical Classification:</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:30%; padding:2px 4px;">Vitamin B12 Level</th>
    <th style="width:35%; padding:2px 4px;">Diagnostic Classification</th>
    <th style="width:35%; padding:2px 4px;">Clinical Manifestations</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>&lt; 200 pg/mL (&lt; 148 pmol/L)</b></td><td style="padding:2px 4px;"><b>Deficiency</b></td><td style="padding:2px 4px;">Megaloblastic anemia, peripheral neuropathy (numbness, paresthesias), subacute combined spinal degeneration</td></tr>
  <tr><td style="padding:2px 4px;"><b>200 – 300 pg/mL</b></td><td style="padding:2px 4px;"><b>Borderline / Equivocal</b></td><td style="padding:2px 4px;">May have tissue-level deficiency; correlate with serum Homocysteine / Methylmalonic Acid (MMA)</td></tr>
  <tr><td style="padding:2px 4px;"><b>&gt; 300 – 900 pg/mL</b></td><td style="padding:2px 4px;"><b>Normal Range</b></td><td style="padding:2px 4px;">Adequate tissue cobalamin stores</td></tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>High prevalence in strict Indian vegetarian/vegan diets, elderly, prolonged Metformin or PPI antacid therapy, and post-bariatric gastrectomy.</i></p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'VITB12'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Serum Vitamin B12 (Cyanocobalamin) Clinical Classification:</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:30%; padding:2px 4px;">Vitamin B12 Level</th>
    <th style="width:35%; padding:2px 4px;">Diagnostic Classification</th>
    <th style="width:35%; padding:2px 4px;">Clinical Manifestations</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>&lt; 200 pg/mL (&lt; 148 pmol/L)</b></td><td style="padding:2px 4px;"><b>Deficiency</b></td><td style="padding:2px 4px;">Megaloblastic anemia, peripheral neuropathy (numbness, paresthesias), subacute combined spinal degeneration</td></tr>
  <tr><td style="padding:2px 4px;"><b>200 – 300 pg/mL</b></td><td style="padding:2px 4px;"><b>Borderline / Equivocal</b></td><td style="padding:2px 4px;">May have tissue-level deficiency; correlate with serum Homocysteine / Methylmalonic Acid (MMA)</td></tr>
  <tr><td style="padding:2px 4px;"><b>&gt; 300 – 900 pg/mL</b></td><td style="padding:2px 4px;"><b>Normal Range</b></td><td style="padding:2px 4px;">Adequate tissue cobalamin stores</td></tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>High prevalence in strict Indian vegetarian/vegan diets, elderly, prolonged Metformin or PPI antacid therapy, and post-bariatric gastrectomy.</i></p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: VITPKG
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>25-Hydroxy Vitamin D (Total) Clinical Classification (Endocrine Society Guidelines):</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:30%; padding:2px 4px;">25-OH Vitamin D Level</th>
    <th style="width:35%; padding:2px 4px;">Clinical Status</th>
    <th style="width:35%; padding:2px 4px;">Clinical Implication &amp; Action</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>&lt; 20 ng/mL (&lt; 50 nmol/L)</b></td><td style="padding:2px 4px;"><b>Deficiency</b></td><td style="padding:2px 4px;">Impaired bone mineralization, osteomalacia, rickets, muscle aches; high-dose supplementation indicated</td></tr>
  <tr><td style="padding:2px 4px;"><b>20 – 30 ng/mL (50 – 75 nmol/L)</b></td><td style="padding:2px 4px;"><b>Insufficiency</b></td><td style="padding:2px 4px;">Suboptimal for calcium absorption and bone health; maintenance supplementation recommended</td></tr>
  <tr><td style="padding:2px 4px;"><b>30 – 100 ng/mL (75 – 250 nmol/L)</b></td><td style="padding:2px 4px;"><b>Sufficiency</b></td><td style="padding:2px 4px;">Optimal target range for skeletal, muscular, and immune health</td></tr>
  <tr><td style="padding:2px 4px;"><b>&gt; 100 ng/mL (&gt; 250 nmol/L)</b></td><td style="padding:2px 4px;"><b>Potential Toxicity / Hypervitaminosis D</b></td><td style="padding:2px 4px;">Risk of hypercalcemia, hypercalciuria, nephrocalcinosis, and renal stones</td></tr>
</table><br><p style="margin:2px 0;"><b>Serum Vitamin B12 (Cyanocobalamin) Clinical Classification:</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:30%; padding:2px 4px;">Vitamin B12 Level</th>
    <th style="width:35%; padding:2px 4px;">Diagnostic Classification</th>
    <th style="width:35%; padding:2px 4px;">Clinical Manifestations</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>&lt; 200 pg/mL (&lt; 148 pmol/L)</b></td><td style="padding:2px 4px;"><b>Deficiency</b></td><td style="padding:2px 4px;">Megaloblastic anemia, peripheral neuropathy (numbness, paresthesias), subacute combined spinal degeneration</td></tr>
  <tr><td style="padding:2px 4px;"><b>200 – 300 pg/mL</b></td><td style="padding:2px 4px;"><b>Borderline / Equivocal</b></td><td style="padding:2px 4px;">May have tissue-level deficiency; correlate with serum Homocysteine / Methylmalonic Acid (MMA)</td></tr>
  <tr><td style="padding:2px 4px;"><b>&gt; 300 – 900 pg/mL</b></td><td style="padding:2px 4px;"><b>Normal Range</b></td><td style="padding:2px 4px;">Adequate tissue cobalamin stores</td></tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>High prevalence in strict Indian vegetarian/vegan diets, elderly, prolonged Metformin or PPI antacid therapy, and post-bariatric gastrectomy.</i></p>' WHERE `test_code` = 'VITPKG';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>25-Hydroxy Vitamin D (Total) Clinical Classification (Endocrine Society Guidelines):</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:30%; padding:2px 4px;">25-OH Vitamin D Level</th>
    <th style="width:35%; padding:2px 4px;">Clinical Status</th>
    <th style="width:35%; padding:2px 4px;">Clinical Implication &amp; Action</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>&lt; 20 ng/mL (&lt; 50 nmol/L)</b></td><td style="padding:2px 4px;"><b>Deficiency</b></td><td style="padding:2px 4px;">Impaired bone mineralization, osteomalacia, rickets, muscle aches; high-dose supplementation indicated</td></tr>
  <tr><td style="padding:2px 4px;"><b>20 – 30 ng/mL (50 – 75 nmol/L)</b></td><td style="padding:2px 4px;"><b>Insufficiency</b></td><td style="padding:2px 4px;">Suboptimal for calcium absorption and bone health; maintenance supplementation recommended</td></tr>
  <tr><td style="padding:2px 4px;"><b>30 – 100 ng/mL (75 – 250 nmol/L)</b></td><td style="padding:2px 4px;"><b>Sufficiency</b></td><td style="padding:2px 4px;">Optimal target range for skeletal, muscular, and immune health</td></tr>
  <tr><td style="padding:2px 4px;"><b>&gt; 100 ng/mL (&gt; 250 nmol/L)</b></td><td style="padding:2px 4px;"><b>Potential Toxicity / Hypervitaminosis D</b></td><td style="padding:2px 4px;">Risk of hypercalcemia, hypercalciuria, nephrocalcinosis, and renal stones</td></tr>
</table><br><p style="margin:2px 0;"><b>Serum Vitamin B12 (Cyanocobalamin) Clinical Classification:</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:30%; padding:2px 4px;">Vitamin B12 Level</th>
    <th style="width:35%; padding:2px 4px;">Diagnostic Classification</th>
    <th style="width:35%; padding:2px 4px;">Clinical Manifestations</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>&lt; 200 pg/mL (&lt; 148 pmol/L)</b></td><td style="padding:2px 4px;"><b>Deficiency</b></td><td style="padding:2px 4px;">Megaloblastic anemia, peripheral neuropathy (numbness, paresthesias), subacute combined spinal degeneration</td></tr>
  <tr><td style="padding:2px 4px;"><b>200 – 300 pg/mL</b></td><td style="padding:2px 4px;"><b>Borderline / Equivocal</b></td><td style="padding:2px 4px;">May have tissue-level deficiency; correlate with serum Homocysteine / Methylmalonic Acid (MMA)</td></tr>
  <tr><td style="padding:2px 4px;"><b>&gt; 300 – 900 pg/mL</b></td><td style="padding:2px 4px;"><b>Normal Range</b></td><td style="padding:2px 4px;">Adequate tissue cobalamin stores</td></tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>High prevalence in strict Indian vegetarian/vegan diets, elderly, prolonged Metformin or PPI antacid therapy, and post-bariatric gastrectomy.</i></p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'VITPKG'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>25-Hydroxy Vitamin D (Total) Clinical Classification (Endocrine Society Guidelines):</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:30%; padding:2px 4px;">25-OH Vitamin D Level</th>
    <th style="width:35%; padding:2px 4px;">Clinical Status</th>
    <th style="width:35%; padding:2px 4px;">Clinical Implication &amp; Action</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>&lt; 20 ng/mL (&lt; 50 nmol/L)</b></td><td style="padding:2px 4px;"><b>Deficiency</b></td><td style="padding:2px 4px;">Impaired bone mineralization, osteomalacia, rickets, muscle aches; high-dose supplementation indicated</td></tr>
  <tr><td style="padding:2px 4px;"><b>20 – 30 ng/mL (50 – 75 nmol/L)</b></td><td style="padding:2px 4px;"><b>Insufficiency</b></td><td style="padding:2px 4px;">Suboptimal for calcium absorption and bone health; maintenance supplementation recommended</td></tr>
  <tr><td style="padding:2px 4px;"><b>30 – 100 ng/mL (75 – 250 nmol/L)</b></td><td style="padding:2px 4px;"><b>Sufficiency</b></td><td style="padding:2px 4px;">Optimal target range for skeletal, muscular, and immune health</td></tr>
  <tr><td style="padding:2px 4px;"><b>&gt; 100 ng/mL (&gt; 250 nmol/L)</b></td><td style="padding:2px 4px;"><b>Potential Toxicity / Hypervitaminosis D</b></td><td style="padding:2px 4px;">Risk of hypercalcemia, hypercalciuria, nephrocalcinosis, and renal stones</td></tr>
</table><br><p style="margin:2px 0;"><b>Serum Vitamin B12 (Cyanocobalamin) Clinical Classification:</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:30%; padding:2px 4px;">Vitamin B12 Level</th>
    <th style="width:35%; padding:2px 4px;">Diagnostic Classification</th>
    <th style="width:35%; padding:2px 4px;">Clinical Manifestations</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>&lt; 200 pg/mL (&lt; 148 pmol/L)</b></td><td style="padding:2px 4px;"><b>Deficiency</b></td><td style="padding:2px 4px;">Megaloblastic anemia, peripheral neuropathy (numbness, paresthesias), subacute combined spinal degeneration</td></tr>
  <tr><td style="padding:2px 4px;"><b>200 – 300 pg/mL</b></td><td style="padding:2px 4px;"><b>Borderline / Equivocal</b></td><td style="padding:2px 4px;">May have tissue-level deficiency; correlate with serum Homocysteine / Methylmalonic Acid (MMA)</td></tr>
  <tr><td style="padding:2px 4px;"><b>&gt; 300 – 900 pg/mL</b></td><td style="padding:2px 4px;"><b>Normal Range</b></td><td style="padding:2px 4px;">Adequate tissue cobalamin stores</td></tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>High prevalence in strict Indian vegetarian/vegan diets, elderly, prolonged Metformin or PPI antacid therapy, and post-bariatric gastrectomy.</i></p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: BHCG
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Quantitative Beta-hCG Clinical Reference Limits:</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:35%; padding:2px 4px;">Gestational Age (from LMP)</th>
    <th style="width:35%; padding:2px 4px;">Approximate hCG Range (mIU/mL)</th>
    <th style="width:30%; padding:2px 4px;">Clinical Context</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>Non-Pregnant / Post-Menopausal</b></td><td style="padding:2px 4px;">&lt; 5.0 mIU/mL</td><td style="padding:2px 4px;">Negative for pregnancy</td></tr>
  <tr><td style="padding:2px 4px;"><b>3 – 4 Weeks</b></td><td style="padding:2px 4px;">9 – 130</td><td style="padding:2px 4px;">Early implantation</td></tr>
  <tr><td style="padding:2px 4px;"><b>4 – 5 Weeks</b></td><td style="padding:2px 4px;">75 – 2,600</td><td style="padding:2px 4px;">Doubles every 48–72 hours</td></tr>
  <tr><td style="padding:2px 4px;"><b>5 – 6 Weeks</b></td><td style="padding:2px 4px;">850 – 20,800</td><td style="padding:2px 4px;">Gestational sac visible on TVS (&gt; 1500–2000)</td></tr>
  <tr><td style="padding:2px 4px;"><b>6 – 8 Weeks</b></td><td style="padding:2px 4px;">4,000 – 100,000</td><td style="padding:2px 4px;">Fetal cardiac activity visible</td></tr>
  <tr><td style="padding:2px 4px;"><b>8 – 12 Weeks (Peak)</b></td><td style="padding:2px 4px;">32,000 – 210,000</td><td style="padding:2px 4px;">Peak concentration</td></tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Suboptimal rise (&lt; 53% in 48h) or plateau suggests ectopic pregnancy or non-viable intrauterine pregnancy. Markedly excessive levels (&gt; 200,000 mIU/mL) suggest hydatidiform mole or choriocarcinoma.</i></p>' WHERE `test_code` = 'BHCG';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Quantitative Beta-hCG Clinical Reference Limits:</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:35%; padding:2px 4px;">Gestational Age (from LMP)</th>
    <th style="width:35%; padding:2px 4px;">Approximate hCG Range (mIU/mL)</th>
    <th style="width:30%; padding:2px 4px;">Clinical Context</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>Non-Pregnant / Post-Menopausal</b></td><td style="padding:2px 4px;">&lt; 5.0 mIU/mL</td><td style="padding:2px 4px;">Negative for pregnancy</td></tr>
  <tr><td style="padding:2px 4px;"><b>3 – 4 Weeks</b></td><td style="padding:2px 4px;">9 – 130</td><td style="padding:2px 4px;">Early implantation</td></tr>
  <tr><td style="padding:2px 4px;"><b>4 – 5 Weeks</b></td><td style="padding:2px 4px;">75 – 2,600</td><td style="padding:2px 4px;">Doubles every 48–72 hours</td></tr>
  <tr><td style="padding:2px 4px;"><b>5 – 6 Weeks</b></td><td style="padding:2px 4px;">850 – 20,800</td><td style="padding:2px 4px;">Gestational sac visible on TVS (&gt; 1500–2000)</td></tr>
  <tr><td style="padding:2px 4px;"><b>6 – 8 Weeks</b></td><td style="padding:2px 4px;">4,000 – 100,000</td><td style="padding:2px 4px;">Fetal cardiac activity visible</td></tr>
  <tr><td style="padding:2px 4px;"><b>8 – 12 Weeks (Peak)</b></td><td style="padding:2px 4px;">32,000 – 210,000</td><td style="padding:2px 4px;">Peak concentration</td></tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Suboptimal rise (&lt; 53% in 48h) or plateau suggests ectopic pregnancy or non-viable intrauterine pregnancy. Markedly excessive levels (&gt; 200,000 mIU/mL) suggest hydatidiform mole or choriocarcinoma.</i></p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'BHCG'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Quantitative Beta-hCG Clinical Reference Limits:</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:35%; padding:2px 4px;">Gestational Age (from LMP)</th>
    <th style="width:35%; padding:2px 4px;">Approximate hCG Range (mIU/mL)</th>
    <th style="width:30%; padding:2px 4px;">Clinical Context</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>Non-Pregnant / Post-Menopausal</b></td><td style="padding:2px 4px;">&lt; 5.0 mIU/mL</td><td style="padding:2px 4px;">Negative for pregnancy</td></tr>
  <tr><td style="padding:2px 4px;"><b>3 – 4 Weeks</b></td><td style="padding:2px 4px;">9 – 130</td><td style="padding:2px 4px;">Early implantation</td></tr>
  <tr><td style="padding:2px 4px;"><b>4 – 5 Weeks</b></td><td style="padding:2px 4px;">75 – 2,600</td><td style="padding:2px 4px;">Doubles every 48–72 hours</td></tr>
  <tr><td style="padding:2px 4px;"><b>5 – 6 Weeks</b></td><td style="padding:2px 4px;">850 – 20,800</td><td style="padding:2px 4px;">Gestational sac visible on TVS (&gt; 1500–2000)</td></tr>
  <tr><td style="padding:2px 4px;"><b>6 – 8 Weeks</b></td><td style="padding:2px 4px;">4,000 – 100,000</td><td style="padding:2px 4px;">Fetal cardiac activity visible</td></tr>
  <tr><td style="padding:2px 4px;"><b>8 – 12 Weeks (Peak)</b></td><td style="padding:2px 4px;">32,000 – 210,000</td><td style="padding:2px 4px;">Peak concentration</td></tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Suboptimal rise (&lt; 53% in 48h) or plateau suggests ectopic pregnancy or non-viable intrauterine pregnancy. Markedly excessive levels (&gt; 200,000 mIU/mL) suggest hydatidiform mole or choriocarcinoma.</i></p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: PROLACTIN
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Serum Prolactin Interpretation:</b><br>
• <b>Normal Adult Non-Pregnant:</b> 4.8 – 23.3 ng/mL.<br>
• <b>Hyperprolactinemia (&gt; 25 ng/mL):</b> Manifests as amenorrhea, galactorrhea, oligomenorrhea, female infertility, and male erectile dysfunction/gynecomastia.<br>
• <b>Etiologies:</b> Prolactinoma (pituitary adenoma; levels often &gt; 100–200 ng/mL), primary hypothyroidism (high TRH stimulates prolactin), dopamine-blocking drugs (Antipsychotics, Metoclopramide, Domperidone), chronic kidney disease, stress.<br>
<span style="font-size:7pt; color:#64748b;"><i>Sample requirement: Morning collection, patient should be seated quietly for 20 minutes prior to venipuncture (avoid exercise, breast stimulation, and acute stress).</i></span></p>' WHERE `test_code` = 'PROLACTIN';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Serum Prolactin Interpretation:</b><br>
• <b>Normal Adult Non-Pregnant:</b> 4.8 – 23.3 ng/mL.<br>
• <b>Hyperprolactinemia (&gt; 25 ng/mL):</b> Manifests as amenorrhea, galactorrhea, oligomenorrhea, female infertility, and male erectile dysfunction/gynecomastia.<br>
• <b>Etiologies:</b> Prolactinoma (pituitary adenoma; levels often &gt; 100–200 ng/mL), primary hypothyroidism (high TRH stimulates prolactin), dopamine-blocking drugs (Antipsychotics, Metoclopramide, Domperidone), chronic kidney disease, stress.<br>
<span style="font-size:7pt; color:#64748b;"><i>Sample requirement: Morning collection, patient should be seated quietly for 20 minutes prior to venipuncture (avoid exercise, breast stimulation, and acute stress).</i></span></p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'PROLACTIN'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Serum Prolactin Interpretation:</b><br>
• <b>Normal Adult Non-Pregnant:</b> 4.8 – 23.3 ng/mL.<br>
• <b>Hyperprolactinemia (&gt; 25 ng/mL):</b> Manifests as amenorrhea, galactorrhea, oligomenorrhea, female infertility, and male erectile dysfunction/gynecomastia.<br>
• <b>Etiologies:</b> Prolactinoma (pituitary adenoma; levels often &gt; 100–200 ng/mL), primary hypothyroidism (high TRH stimulates prolactin), dopamine-blocking drugs (Antipsychotics, Metoclopramide, Domperidone), chronic kidney disease, stress.<br>
<span style="font-size:7pt; color:#64748b;"><i>Sample requirement: Morning collection, patient should be seated quietly for 20 minutes prior to venipuncture (avoid exercise, breast stimulation, and acute stress).</i></span></p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: PSA
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Total PSA Clinical Interpretation (Prostate Cancer Screening):</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:30%; padding:2px 4px;">Serum Total PSA (ng/mL)</th>
    <th style="width:35%; padding:2px 4px;">Risk Assessment</th>
    <th style="width:35%; padding:2px 4px;">Clinical Recommendation</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>0 – 4.0 ng/mL</b></td><td style="padding:2px 4px;">Normal Baseline Range</td><td style="padding:2px 4px;">Low probability of prostate carcinoma</td></tr>
  <tr><td style="padding:2px 4px;"><b>4.0 – 10.0 ng/mL</b></td><td style="padding:2px 4px;"><b>"Diagnostic Gray Zone"</b> (approx. 25% cancer risk)</td><td style="padding:2px 4px;">Calculate Free/Total PSA ratio (% Free PSA &lt; 15% favors malignancy; &gt; 25% favors BPH)</td></tr>
  <tr><td style="padding:2px 4px;"><b>&gt; 10.0 ng/mL</b></td><td style="padding:2px 4px;">High Suspicion of Malignancy (&gt; 50% risk)</td><td style="padding:2px 4px;">Multiparametric prostate MRI and TRUS-guided prostate biopsy indicated</td></tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Benign causes of elevated PSA: Benign Prostatic Hyperplasia (BPH), acute prostatitis, urinary retention, recent urinary catheterization, digital rectal examination (DRE), or ejaculation within 48 hours.</i></p>' WHERE `test_code` = 'PSA';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Total PSA Clinical Interpretation (Prostate Cancer Screening):</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:30%; padding:2px 4px;">Serum Total PSA (ng/mL)</th>
    <th style="width:35%; padding:2px 4px;">Risk Assessment</th>
    <th style="width:35%; padding:2px 4px;">Clinical Recommendation</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>0 – 4.0 ng/mL</b></td><td style="padding:2px 4px;">Normal Baseline Range</td><td style="padding:2px 4px;">Low probability of prostate carcinoma</td></tr>
  <tr><td style="padding:2px 4px;"><b>4.0 – 10.0 ng/mL</b></td><td style="padding:2px 4px;"><b>"Diagnostic Gray Zone"</b> (approx. 25% cancer risk)</td><td style="padding:2px 4px;">Calculate Free/Total PSA ratio (% Free PSA &lt; 15% favors malignancy; &gt; 25% favors BPH)</td></tr>
  <tr><td style="padding:2px 4px;"><b>&gt; 10.0 ng/mL</b></td><td style="padding:2px 4px;">High Suspicion of Malignancy (&gt; 50% risk)</td><td style="padding:2px 4px;">Multiparametric prostate MRI and TRUS-guided prostate biopsy indicated</td></tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Benign causes of elevated PSA: Benign Prostatic Hyperplasia (BPH), acute prostatitis, urinary retention, recent urinary catheterization, digital rectal examination (DRE), or ejaculation within 48 hours.</i></p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'PSA'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Total PSA Clinical Interpretation (Prostate Cancer Screening):</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:30%; padding:2px 4px;">Serum Total PSA (ng/mL)</th>
    <th style="width:35%; padding:2px 4px;">Risk Assessment</th>
    <th style="width:35%; padding:2px 4px;">Clinical Recommendation</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>0 – 4.0 ng/mL</b></td><td style="padding:2px 4px;">Normal Baseline Range</td><td style="padding:2px 4px;">Low probability of prostate carcinoma</td></tr>
  <tr><td style="padding:2px 4px;"><b>4.0 – 10.0 ng/mL</b></td><td style="padding:2px 4px;"><b>"Diagnostic Gray Zone"</b> (approx. 25% cancer risk)</td><td style="padding:2px 4px;">Calculate Free/Total PSA ratio (% Free PSA &lt; 15% favors malignancy; &gt; 25% favors BPH)</td></tr>
  <tr><td style="padding:2px 4px;"><b>&gt; 10.0 ng/mL</b></td><td style="padding:2px 4px;">High Suspicion of Malignancy (&gt; 50% risk)</td><td style="padding:2px 4px;">Multiparametric prostate MRI and TRUS-guided prostate biopsy indicated</td></tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Benign causes of elevated PSA: Benign Prostatic Hyperplasia (BPH), acute prostatitis, urinary retention, recent urinary catheterization, digital rectal examination (DRE), or ejaculation within 48 hours.</i></p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: CEA
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Carcinoembryonic Antigen (CEA) Interpretation:</b><br>
• Oncofetal glycoprotein primarily used for <b>monitoring therapeutic response and detecting post-surgical recurrence</b> in diagnosed colorectal, gastric, and pancreatic carcinoma.<br>
• <b>Reference:</b> Non-smokers: &lt; 3.0 ng/mL; Smokers: &lt; 5.0 ng/mL.<br>
• Not recommended for general asymptomatic cancer screening due to limited sensitivity and specificity.<br>
<span style="font-size:7pt; color:#64748b;"><i>Benign elevations occur in chronic heavy smoking, alcoholic cirrhosis, chronic hepatitis, inflammatory bowel disease (Crohn/Ulcerative Colitis), and pancreatitis.</i></span></p>' WHERE `test_code` = 'CEA';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Carcinoembryonic Antigen (CEA) Interpretation:</b><br>
• Oncofetal glycoprotein primarily used for <b>monitoring therapeutic response and detecting post-surgical recurrence</b> in diagnosed colorectal, gastric, and pancreatic carcinoma.<br>
• <b>Reference:</b> Non-smokers: &lt; 3.0 ng/mL; Smokers: &lt; 5.0 ng/mL.<br>
• Not recommended for general asymptomatic cancer screening due to limited sensitivity and specificity.<br>
<span style="font-size:7pt; color:#64748b;"><i>Benign elevations occur in chronic heavy smoking, alcoholic cirrhosis, chronic hepatitis, inflammatory bowel disease (Crohn/Ulcerative Colitis), and pancreatitis.</i></span></p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'CEA'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Carcinoembryonic Antigen (CEA) Interpretation:</b><br>
• Oncofetal glycoprotein primarily used for <b>monitoring therapeutic response and detecting post-surgical recurrence</b> in diagnosed colorectal, gastric, and pancreatic carcinoma.<br>
• <b>Reference:</b> Non-smokers: &lt; 3.0 ng/mL; Smokers: &lt; 5.0 ng/mL.<br>
• Not recommended for general asymptomatic cancer screening due to limited sensitivity and specificity.<br>
<span style="font-size:7pt; color:#64748b;"><i>Benign elevations occur in chronic heavy smoking, alcoholic cirrhosis, chronic hepatitis, inflammatory bowel disease (Crohn/Ulcerative Colitis), and pancreatitis.</i></span></p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: THYAB
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Thyroid Autoantibodies (Anti-TPO &amp; Anti-Tg) Interpretation:</b><br>
• <b>Anti-TPO (Thyroid Peroxidase):</b> Hallmark serological biomarker for autoimmune thyroid disease. Present in &gt; 90% of patients with <b>Hashimoto thyroiditis</b> and 70–80% of patients with <b>Graves disease</b>.<br>
• <b>Anti-Tg (Thyroglobulin):</b> Helpful adjunctive marker in autoimmune thyroiditis and crucial for validating serum Thyroglobulin measurements in thyroid cancer surveillance.<br>
• High titers in euthyroid or subclinical hypothyroid individuals predict high risk of progression to overt hypothyroidism.</p>' WHERE `test_code` = 'THYAB';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Thyroid Autoantibodies (Anti-TPO &amp; Anti-Tg) Interpretation:</b><br>
• <b>Anti-TPO (Thyroid Peroxidase):</b> Hallmark serological biomarker for autoimmune thyroid disease. Present in &gt; 90% of patients with <b>Hashimoto thyroiditis</b> and 70–80% of patients with <b>Graves disease</b>.<br>
• <b>Anti-Tg (Thyroglobulin):</b> Helpful adjunctive marker in autoimmune thyroiditis and crucial for validating serum Thyroglobulin measurements in thyroid cancer surveillance.<br>
• High titers in euthyroid or subclinical hypothyroid individuals predict high risk of progression to overt hypothyroidism.</p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'THYAB'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Thyroid Autoantibodies (Anti-TPO &amp; Anti-Tg) Interpretation:</b><br>
• <b>Anti-TPO (Thyroid Peroxidase):</b> Hallmark serological biomarker for autoimmune thyroid disease. Present in &gt; 90% of patients with <b>Hashimoto thyroiditis</b> and 70–80% of patients with <b>Graves disease</b>.<br>
• <b>Anti-Tg (Thyroglobulin):</b> Helpful adjunctive marker in autoimmune thyroiditis and crucial for validating serum Thyroglobulin measurements in thyroid cancer surveillance.<br>
• High titers in euthyroid or subclinical hypothyroid individuals predict high risk of progression to overt hypothyroidism.</p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: URINE
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Complete Urine Examination (CUE) Clinical Diagnostic Significance:</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:25%; padding:2px 4px;">Urinary Finding</th>
    <th style="width:35%; padding:2px 4px;">Pathological Correlation</th>
    <th style="width:40%; padding:2px 4px;">Clinical Guidance</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>Proteinuria (&gt; 30 mg/dL)</b></td><td style="padding:2px 4px;">Glomerular disease, diabetic nephropathy, pre-eclampsia, nephrotic syndrome</td><td style="padding:2px 4px;">Quantify via Spot Urine ACR or 24-hr urine protein</td></tr>
  <tr><td style="padding:2px 4px;"><b>Glucosuria</b></td><td style="padding:2px 4px;">Hyperglycemia exceeding renal threshold (~180 mg/dL), Renal glucosuria</td><td style="padding:2px 4px;">Correlate with FBS / PPBS / HbA1c</td></tr>
  <tr><td style="padding:2px 4px;"><b>Ketonuria</b></td><td style="padding:2px 4px;">Diabetic Ketoacidosis (DKA), prolonged fasting/starvation, severe vomiting</td><td style="padding:2px 4px;">Emergency evaluation in diabetic patients</td></tr>
  <tr><td style="padding:2px 4px;"><b>Pus Cells (&gt; 5 / HPF) &amp; Nitrites</b></td><td style="padding:2px 4px;">Urinary Tract Infection (Cystitis, Pyelonephritis)</td><td style="padding:2px 4px;">Urine culture &amp; antimicrobial susceptibility advised</td></tr>
  <tr><td style="padding:2px 4px;"><b>RBCs (&gt; 3 / HPF, Hematuria)</b></td><td style="padding:2px 4px;">Urinary calculi, trauma, glomerulonephritis, malignancy (bladder/renal)</td><td style="padding:2px 4px;">Ultrasound KUB, urological evaluation</td></tr>
  <tr><td style="padding:2px 4px;"><b>Casts (Granular / RBC / WBC)</b></td><td style="padding:2px 4px;">Intrinsic renal parenchymal disease (Glomerulonephritis, ATN)</td><td style="padding:2px 4px;">Nephrology evaluation</td></tr>
</table>' WHERE `test_code` = 'URINE';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Complete Urine Examination (CUE) Clinical Diagnostic Significance:</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:25%; padding:2px 4px;">Urinary Finding</th>
    <th style="width:35%; padding:2px 4px;">Pathological Correlation</th>
    <th style="width:40%; padding:2px 4px;">Clinical Guidance</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>Proteinuria (&gt; 30 mg/dL)</b></td><td style="padding:2px 4px;">Glomerular disease, diabetic nephropathy, pre-eclampsia, nephrotic syndrome</td><td style="padding:2px 4px;">Quantify via Spot Urine ACR or 24-hr urine protein</td></tr>
  <tr><td style="padding:2px 4px;"><b>Glucosuria</b></td><td style="padding:2px 4px;">Hyperglycemia exceeding renal threshold (~180 mg/dL), Renal glucosuria</td><td style="padding:2px 4px;">Correlate with FBS / PPBS / HbA1c</td></tr>
  <tr><td style="padding:2px 4px;"><b>Ketonuria</b></td><td style="padding:2px 4px;">Diabetic Ketoacidosis (DKA), prolonged fasting/starvation, severe vomiting</td><td style="padding:2px 4px;">Emergency evaluation in diabetic patients</td></tr>
  <tr><td style="padding:2px 4px;"><b>Pus Cells (&gt; 5 / HPF) &amp; Nitrites</b></td><td style="padding:2px 4px;">Urinary Tract Infection (Cystitis, Pyelonephritis)</td><td style="padding:2px 4px;">Urine culture &amp; antimicrobial susceptibility advised</td></tr>
  <tr><td style="padding:2px 4px;"><b>RBCs (&gt; 3 / HPF, Hematuria)</b></td><td style="padding:2px 4px;">Urinary calculi, trauma, glomerulonephritis, malignancy (bladder/renal)</td><td style="padding:2px 4px;">Ultrasound KUB, urological evaluation</td></tr>
  <tr><td style="padding:2px 4px;"><b>Casts (Granular / RBC / WBC)</b></td><td style="padding:2px 4px;">Intrinsic renal parenchymal disease (Glomerulonephritis, ATN)</td><td style="padding:2px 4px;">Nephrology evaluation</td></tr>
</table>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'URINE'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Complete Urine Examination (CUE) Clinical Diagnostic Significance:</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:25%; padding:2px 4px;">Urinary Finding</th>
    <th style="width:35%; padding:2px 4px;">Pathological Correlation</th>
    <th style="width:40%; padding:2px 4px;">Clinical Guidance</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>Proteinuria (&gt; 30 mg/dL)</b></td><td style="padding:2px 4px;">Glomerular disease, diabetic nephropathy, pre-eclampsia, nephrotic syndrome</td><td style="padding:2px 4px;">Quantify via Spot Urine ACR or 24-hr urine protein</td></tr>
  <tr><td style="padding:2px 4px;"><b>Glucosuria</b></td><td style="padding:2px 4px;">Hyperglycemia exceeding renal threshold (~180 mg/dL), Renal glucosuria</td><td style="padding:2px 4px;">Correlate with FBS / PPBS / HbA1c</td></tr>
  <tr><td style="padding:2px 4px;"><b>Ketonuria</b></td><td style="padding:2px 4px;">Diabetic Ketoacidosis (DKA), prolonged fasting/starvation, severe vomiting</td><td style="padding:2px 4px;">Emergency evaluation in diabetic patients</td></tr>
  <tr><td style="padding:2px 4px;"><b>Pus Cells (&gt; 5 / HPF) &amp; Nitrites</b></td><td style="padding:2px 4px;">Urinary Tract Infection (Cystitis, Pyelonephritis)</td><td style="padding:2px 4px;">Urine culture &amp; antimicrobial susceptibility advised</td></tr>
  <tr><td style="padding:2px 4px;"><b>RBCs (&gt; 3 / HPF, Hematuria)</b></td><td style="padding:2px 4px;">Urinary calculi, trauma, glomerulonephritis, malignancy (bladder/renal)</td><td style="padding:2px 4px;">Ultrasound KUB, urological evaluation</td></tr>
  <tr><td style="padding:2px 4px;"><b>Casts (Granular / RBC / WBC)</b></td><td style="padding:2px 4px;">Intrinsic renal parenchymal disease (Glomerulonephritis, ATN)</td><td style="padding:2px 4px;">Nephrology evaluation</td></tr>
</table>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: UPT
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Urine Pregnancy Test (Rapid hCG Card):</b><br>
• Qualitative immunochromatographic assay detecting hCG in urine (sensitivity ~ 20–25 mIU/mL).<br>
• <b>Positive:</b> Two distinct colored bands (Control and Test line). Confirms pregnancy.<br>
• <b>Negative:</b> Single colored band at Control line only. If clinically suspected (missed period), repeat on fresh early-morning first-void urine after 48–72 hours or perform quantitative serum Beta-hCG.</p>' WHERE `test_code` = 'UPT';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Urine Pregnancy Test (Rapid hCG Card):</b><br>
• Qualitative immunochromatographic assay detecting hCG in urine (sensitivity ~ 20–25 mIU/mL).<br>
• <b>Positive:</b> Two distinct colored bands (Control and Test line). Confirms pregnancy.<br>
• <b>Negative:</b> Single colored band at Control line only. If clinically suspected (missed period), repeat on fresh early-morning first-void urine after 48–72 hours or perform quantitative serum Beta-hCG.</p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'UPT'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Urine Pregnancy Test (Rapid hCG Card):</b><br>
• Qualitative immunochromatographic assay detecting hCG in urine (sensitivity ~ 20–25 mIU/mL).<br>
• <b>Positive:</b> Two distinct colored bands (Control and Test line). Confirms pregnancy.<br>
• <b>Negative:</b> Single colored band at Control line only. If clinically suspected (missed period), repeat on fresh early-morning first-void urine after 48–72 hours or perform quantitative serum Beta-hCG.</p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: MICROALB
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Urine Microalbumin / Albumin-to-Creatinine Ratio (ACR) Classification (KDIGO):</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:30%; padding:2px 4px;">Albumin/Creatinine Ratio (ACR)</th>
    <th style="width:35%; padding:2px 4px;">Category (KDIGO Staging)</th>
    <th style="width:35%; padding:2px 4px;">Clinical Significance</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>&lt; 30 mg/g (&lt; 3 mg/mmol)</b></td><td style="padding:2px 4px;"><b>A1: Normal to Mildly Increased</b></td><td style="padding:2px 4px;">Normal baseline urinary albumin excretion</td></tr>
  <tr><td style="padding:2px 4px;"><b>30 – 300 mg/g (3 – 30 mg/mmol)</b></td><td style="padding:2px 4px;"><b>A2: Microalbuminuria (Moderately Increased)</b></td><td style="padding:2px 4px;">Earliest clinical marker of Diabetic Nephropathy and cardiovascular risk; ACEi/ARB therapy indicated</td></tr>
  <tr><td style="padding:2px 4px;"><b>&gt; 300 mg/g (&gt; 30 mg/mmol)</b></td><td style="padding:2px 4px;"><b>A3: Macroalbuminuria (Severely Increased)</b></td><td style="padding:2px 4px;">Overt diabetic nephropathy, high progression to chronic kidney failure</td></tr>
</table>' WHERE `test_code` = 'MICROALB';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Urine Microalbumin / Albumin-to-Creatinine Ratio (ACR) Classification (KDIGO):</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:30%; padding:2px 4px;">Albumin/Creatinine Ratio (ACR)</th>
    <th style="width:35%; padding:2px 4px;">Category (KDIGO Staging)</th>
    <th style="width:35%; padding:2px 4px;">Clinical Significance</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>&lt; 30 mg/g (&lt; 3 mg/mmol)</b></td><td style="padding:2px 4px;"><b>A1: Normal to Mildly Increased</b></td><td style="padding:2px 4px;">Normal baseline urinary albumin excretion</td></tr>
  <tr><td style="padding:2px 4px;"><b>30 – 300 mg/g (3 – 30 mg/mmol)</b></td><td style="padding:2px 4px;"><b>A2: Microalbuminuria (Moderately Increased)</b></td><td style="padding:2px 4px;">Earliest clinical marker of Diabetic Nephropathy and cardiovascular risk; ACEi/ARB therapy indicated</td></tr>
  <tr><td style="padding:2px 4px;"><b>&gt; 300 mg/g (&gt; 30 mg/mmol)</b></td><td style="padding:2px 4px;"><b>A3: Macroalbuminuria (Severely Increased)</b></td><td style="padding:2px 4px;">Overt diabetic nephropathy, high progression to chronic kidney failure</td></tr>
</table>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'MICROALB'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Urine Microalbumin / Albumin-to-Creatinine Ratio (ACR) Classification (KDIGO):</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:30%; padding:2px 4px;">Albumin/Creatinine Ratio (ACR)</th>
    <th style="width:35%; padding:2px 4px;">Category (KDIGO Staging)</th>
    <th style="width:35%; padding:2px 4px;">Clinical Significance</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>&lt; 30 mg/g (&lt; 3 mg/mmol)</b></td><td style="padding:2px 4px;"><b>A1: Normal to Mildly Increased</b></td><td style="padding:2px 4px;">Normal baseline urinary albumin excretion</td></tr>
  <tr><td style="padding:2px 4px;"><b>30 – 300 mg/g (3 – 30 mg/mmol)</b></td><td style="padding:2px 4px;"><b>A2: Microalbuminuria (Moderately Increased)</b></td><td style="padding:2px 4px;">Earliest clinical marker of Diabetic Nephropathy and cardiovascular risk; ACEi/ARB therapy indicated</td></tr>
  <tr><td style="padding:2px 4px;"><b>&gt; 300 mg/g (&gt; 30 mg/mmol)</b></td><td style="padding:2px 4px;"><b>A3: Macroalbuminuria (Severely Increased)</b></td><td style="padding:2px 4px;">Overt diabetic nephropathy, high progression to chronic kidney failure</td></tr>
</table>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: URINE-SK
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Urine Sugar &amp; Ketones Interpretation:</b><br>
• <b>Urine Sugar Positive + Urine Ketones Positive:</b> Strongly suggestive of <b>Diabetic Ketoacidosis (DKA)</b>, a medical emergency requiring urgent hospitalization, intravenous fluid resuscitation, and insulin infusion.<br>
• <b>Urine Sugar Positive + Urine Ketones Negative:</b> Uncontrolled hyperglycemia exceeding renal tubular absorptive threshold.<br>
• <b>Urine Sugar Negative + Urine Ketones Positive:</b> Starvation ketosis, low-carbohydrate (keto) diet, persistent vomiting (hyperemesis gravidarum).</p>' WHERE `test_code` = 'URINE-SK';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Urine Sugar &amp; Ketones Interpretation:</b><br>
• <b>Urine Sugar Positive + Urine Ketones Positive:</b> Strongly suggestive of <b>Diabetic Ketoacidosis (DKA)</b>, a medical emergency requiring urgent hospitalization, intravenous fluid resuscitation, and insulin infusion.<br>
• <b>Urine Sugar Positive + Urine Ketones Negative:</b> Uncontrolled hyperglycemia exceeding renal tubular absorptive threshold.<br>
• <b>Urine Sugar Negative + Urine Ketones Positive:</b> Starvation ketosis, low-carbohydrate (keto) diet, persistent vomiting (hyperemesis gravidarum).</p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'URINE-SK'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Urine Sugar &amp; Ketones Interpretation:</b><br>
• <b>Urine Sugar Positive + Urine Ketones Positive:</b> Strongly suggestive of <b>Diabetic Ketoacidosis (DKA)</b>, a medical emergency requiring urgent hospitalization, intravenous fluid resuscitation, and insulin infusion.<br>
• <b>Urine Sugar Positive + Urine Ketones Negative:</b> Uncontrolled hyperglycemia exceeding renal tubular absorptive threshold.<br>
• <b>Urine Sugar Negative + Urine Ketones Positive:</b> Starvation ketosis, low-carbohydrate (keto) diet, persistent vomiting (hyperemesis gravidarum).</p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: STOOL
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Stool Routine &amp; Microscopic Examination Significance:</b><br>
• <b>Pus Cells &amp; Red Blood Cells:</b> Suggests invasive bacterial dysentery (*Shigella, Salmonella, Campylobacter*) or inflammatory bowel disease (Ulcerative Colitis).<br>
• <b>Trophozoites / Cysts:</b> *Entamoeba histolytica* (amebic colitis), *Giardia lamblia* cysts (malabsorption, giardiasis).<br>
• <b>Ova / Helminth Larvae:</b> *Ascaris lumbricoides, Ancylostoma duodenale* (hookworm), *Taenia* species, *Trichuris trichiura*.<br>
• <b>Reducing Substances (&gt; 0.5%):</b> Carbohydrate / lactose malabsorption, common in post-enteritis pediatric diarrhea.</p>' WHERE `test_code` = 'STOOL';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Stool Routine &amp; Microscopic Examination Significance:</b><br>
• <b>Pus Cells &amp; Red Blood Cells:</b> Suggests invasive bacterial dysentery (*Shigella, Salmonella, Campylobacter*) or inflammatory bowel disease (Ulcerative Colitis).<br>
• <b>Trophozoites / Cysts:</b> *Entamoeba histolytica* (amebic colitis), *Giardia lamblia* cysts (malabsorption, giardiasis).<br>
• <b>Ova / Helminth Larvae:</b> *Ascaris lumbricoides, Ancylostoma duodenale* (hookworm), *Taenia* species, *Trichuris trichiura*.<br>
• <b>Reducing Substances (&gt; 0.5%):</b> Carbohydrate / lactose malabsorption, common in post-enteritis pediatric diarrhea.</p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'STOOL'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Stool Routine &amp; Microscopic Examination Significance:</b><br>
• <b>Pus Cells &amp; Red Blood Cells:</b> Suggests invasive bacterial dysentery (*Shigella, Salmonella, Campylobacter*) or inflammatory bowel disease (Ulcerative Colitis).<br>
• <b>Trophozoites / Cysts:</b> *Entamoeba histolytica* (amebic colitis), *Giardia lamblia* cysts (malabsorption, giardiasis).<br>
• <b>Ova / Helminth Larvae:</b> *Ascaris lumbricoides, Ancylostoma duodenale* (hookworm), *Taenia* species, *Trichuris trichiura*.<br>
• <b>Reducing Substances (&gt; 0.5%):</b> Carbohydrate / lactose malabsorption, common in post-enteritis pediatric diarrhea.</p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: FOBT
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Stool Occult Blood Test (FOBT / FIT) Interpretation:</b><br>
• Detects invisible microscopic gastrointestinal bleeding.<br>
• <b>Positive:</b> Colorectal polyps, colorectal carcinoma, peptic ulcer disease, angiodysplasia, ulcerative colitis, hemorrhoids.<br>
• Recommended as primary annual non-invasive screening for colorectal cancer in adults ≥ 45–50 years.<br>
• Positive result warrants comprehensive lower gastrointestinal colonoscopy workup.</p>' WHERE `test_code` = 'FOBT';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Stool Occult Blood Test (FOBT / FIT) Interpretation:</b><br>
• Detects invisible microscopic gastrointestinal bleeding.<br>
• <b>Positive:</b> Colorectal polyps, colorectal carcinoma, peptic ulcer disease, angiodysplasia, ulcerative colitis, hemorrhoids.<br>
• Recommended as primary annual non-invasive screening for colorectal cancer in adults ≥ 45–50 years.<br>
• Positive result warrants comprehensive lower gastrointestinal colonoscopy workup.</p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'FOBT'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Stool Occult Blood Test (FOBT / FIT) Interpretation:</b><br>
• Detects invisible microscopic gastrointestinal bleeding.<br>
• <b>Positive:</b> Colorectal polyps, colorectal carcinoma, peptic ulcer disease, angiodysplasia, ulcerative colitis, hemorrhoids.<br>
• Recommended as primary annual non-invasive screening for colorectal cancer in adults ≥ 45–50 years.<br>
• Positive result warrants comprehensive lower gastrointestinal colonoscopy workup.</p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: SEMEN
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Semen Analysis Reference Standards (WHO 6th Edition):</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:30%; padding:2px 4px;">Parameter</th>
    <th style="width:35%; padding:2px 4px;">Lower Reference Limit (WHO 6th Ed)</th>
    <th style="width:35%; padding:2px 4px;">Diagnostic Terminology</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>Semen Volume</b></td><td style="padding:2px 4px;">≥ 1.4 mL</td><td style="padding:2px 4px;">&lt; 1.4 mL: Hypospermia</td></tr>
  <tr><td style="padding:2px 4px;"><b>Total Sperm Count</b></td><td style="padding:2px 4px;">≥ 39 million per ejaculate</td><td style="padding:2px 4px;">&lt; 39 million: Oligozoospermia (0: Azoospermia)</td></tr>
  <tr><td style="padding:2px 4px;"><b>Sperm Concentration</b></td><td style="padding:2px 4px;">≥ 16 million / mL</td><td style="padding:2px 4px;">&lt; 16 million/mL: Oligozoospermia</td></tr>
  <tr><td style="padding:2px 4px;"><b>Progressive Motility (PR)</b></td><td style="padding:2px 4px;">≥ 30% (Total PR + NP ≥ 42%)</td><td style="padding:2px 4px;">&lt; 30% PR: Asthenozoospermia</td></tr>
  <tr><td style="padding:2px 4px;"><b>Normal Morphology (Kruger)</b></td><td style="padding:2px 4px;">≥ 4.0% normal forms</td><td style="padding:2px 4px;">&lt; 4.0%: Teratozoospermia</td></tr>
  <tr><td style="padding:2px 4px;"><b>Vitality (Live Sperm)</b></td><td style="padding:2px 4px;">≥ 54% viable</td><td style="padding:2px 4px;">&lt; 54%: Necrozoospermia</td></tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Sample collection instructions: Strict sexual abstinence of 2 to 7 days. Complete specimen delivered to laboratory within 30–60 minutes at body temperature.</i></p>' WHERE `test_code` = 'SEMEN';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Semen Analysis Reference Standards (WHO 6th Edition):</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:30%; padding:2px 4px;">Parameter</th>
    <th style="width:35%; padding:2px 4px;">Lower Reference Limit (WHO 6th Ed)</th>
    <th style="width:35%; padding:2px 4px;">Diagnostic Terminology</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>Semen Volume</b></td><td style="padding:2px 4px;">≥ 1.4 mL</td><td style="padding:2px 4px;">&lt; 1.4 mL: Hypospermia</td></tr>
  <tr><td style="padding:2px 4px;"><b>Total Sperm Count</b></td><td style="padding:2px 4px;">≥ 39 million per ejaculate</td><td style="padding:2px 4px;">&lt; 39 million: Oligozoospermia (0: Azoospermia)</td></tr>
  <tr><td style="padding:2px 4px;"><b>Sperm Concentration</b></td><td style="padding:2px 4px;">≥ 16 million / mL</td><td style="padding:2px 4px;">&lt; 16 million/mL: Oligozoospermia</td></tr>
  <tr><td style="padding:2px 4px;"><b>Progressive Motility (PR)</b></td><td style="padding:2px 4px;">≥ 30% (Total PR + NP ≥ 42%)</td><td style="padding:2px 4px;">&lt; 30% PR: Asthenozoospermia</td></tr>
  <tr><td style="padding:2px 4px;"><b>Normal Morphology (Kruger)</b></td><td style="padding:2px 4px;">≥ 4.0% normal forms</td><td style="padding:2px 4px;">&lt; 4.0%: Teratozoospermia</td></tr>
  <tr><td style="padding:2px 4px;"><b>Vitality (Live Sperm)</b></td><td style="padding:2px 4px;">≥ 54% viable</td><td style="padding:2px 4px;">&lt; 54%: Necrozoospermia</td></tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Sample collection instructions: Strict sexual abstinence of 2 to 7 days. Complete specimen delivered to laboratory within 30–60 minutes at body temperature.</i></p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'SEMEN'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Semen Analysis Reference Standards (WHO 6th Edition):</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:30%; padding:2px 4px;">Parameter</th>
    <th style="width:35%; padding:2px 4px;">Lower Reference Limit (WHO 6th Ed)</th>
    <th style="width:35%; padding:2px 4px;">Diagnostic Terminology</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>Semen Volume</b></td><td style="padding:2px 4px;">≥ 1.4 mL</td><td style="padding:2px 4px;">&lt; 1.4 mL: Hypospermia</td></tr>
  <tr><td style="padding:2px 4px;"><b>Total Sperm Count</b></td><td style="padding:2px 4px;">≥ 39 million per ejaculate</td><td style="padding:2px 4px;">&lt; 39 million: Oligozoospermia (0: Azoospermia)</td></tr>
  <tr><td style="padding:2px 4px;"><b>Sperm Concentration</b></td><td style="padding:2px 4px;">≥ 16 million / mL</td><td style="padding:2px 4px;">&lt; 16 million/mL: Oligozoospermia</td></tr>
  <tr><td style="padding:2px 4px;"><b>Progressive Motility (PR)</b></td><td style="padding:2px 4px;">≥ 30% (Total PR + NP ≥ 42%)</td><td style="padding:2px 4px;">&lt; 30% PR: Asthenozoospermia</td></tr>
  <tr><td style="padding:2px 4px;"><b>Normal Morphology (Kruger)</b></td><td style="padding:2px 4px;">≥ 4.0% normal forms</td><td style="padding:2px 4px;">&lt; 4.0%: Teratozoospermia</td></tr>
  <tr><td style="padding:2px 4px;"><b>Vitality (Live Sperm)</b></td><td style="padding:2px 4px;">≥ 54% viable</td><td style="padding:2px 4px;">&lt; 54%: Necrozoospermia</td></tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Sample collection instructions: Strict sexual abstinence of 2 to 7 days. Complete specimen delivered to laboratory within 30–60 minutes at body temperature.</i></p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: AFB
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Sputum for Acid-Fast Bacilli (AFB - Ziehl-Neelsen Stain) RNTCP/NTEP Grading:</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:35%; padding:2px 4px;">Acid-Fast Bacilli Count (1000× Oil Immersion)</th>
    <th style="width:30%; padding:2px 4px;">NTEP Grading Result</th>
    <th style="width:35%; padding:2px 4px;">Clinical Significance</th>
  </tr>
  <tr><td style="padding:2px 4px;">No AFB observed in 100 oil immersion fields</td><td style="padding:2px 4px;"><b>Negative</b></td><td style="padding:2px 4px;">No microscopic evidence of AFB (does not exclude TB)</td></tr>
  <tr><td style="padding:2px 4px;">1 to 9 AFB per 100 oil immersion fields</td><td style="padding:2px 4px;"><b>Scanty (Record exact number)</b></td><td style="padding:2px 4px;">Positive for pulmonary tuberculosis</td></tr>
  <tr><td style="padding:2px 4px;">10 to 99 AFB per 100 oil immersion fields</td><td style="padding:2px 4px;"><b>Positive 1+</b></td><td style="padding:2px 4px;">Infectious open pulmonary tuberculosis</td></tr>
  <tr><td style="padding:2px 4px;">1 to 10 AFB per single oil immersion field (50 fields)</td><td style="padding:2px 4px;"><b>Positive 2+</b></td><td style="padding:2px 4px;">Moderately heavy bacillary load</td></tr>
  <tr><td style="padding:2px 4px;">&gt; 10 AFB per single oil immersion field (20 fields)</td><td style="padding:2px 4px;"><b>Positive 3+</b></td><td style="padding:2px 4px;">Extremely heavy bacillary load; highly infectious</td></tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Note: CBNAAT / GeneXpert MTB/RIF assay is recommended for rapid confirmation and upfront Rifampicin resistance detection.</i></p>' WHERE `test_code` = 'AFB';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Sputum for Acid-Fast Bacilli (AFB - Ziehl-Neelsen Stain) RNTCP/NTEP Grading:</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:35%; padding:2px 4px;">Acid-Fast Bacilli Count (1000× Oil Immersion)</th>
    <th style="width:30%; padding:2px 4px;">NTEP Grading Result</th>
    <th style="width:35%; padding:2px 4px;">Clinical Significance</th>
  </tr>
  <tr><td style="padding:2px 4px;">No AFB observed in 100 oil immersion fields</td><td style="padding:2px 4px;"><b>Negative</b></td><td style="padding:2px 4px;">No microscopic evidence of AFB (does not exclude TB)</td></tr>
  <tr><td style="padding:2px 4px;">1 to 9 AFB per 100 oil immersion fields</td><td style="padding:2px 4px;"><b>Scanty (Record exact number)</b></td><td style="padding:2px 4px;">Positive for pulmonary tuberculosis</td></tr>
  <tr><td style="padding:2px 4px;">10 to 99 AFB per 100 oil immersion fields</td><td style="padding:2px 4px;"><b>Positive 1+</b></td><td style="padding:2px 4px;">Infectious open pulmonary tuberculosis</td></tr>
  <tr><td style="padding:2px 4px;">1 to 10 AFB per single oil immersion field (50 fields)</td><td style="padding:2px 4px;"><b>Positive 2+</b></td><td style="padding:2px 4px;">Moderately heavy bacillary load</td></tr>
  <tr><td style="padding:2px 4px;">&gt; 10 AFB per single oil immersion field (20 fields)</td><td style="padding:2px 4px;"><b>Positive 3+</b></td><td style="padding:2px 4px;">Extremely heavy bacillary load; highly infectious</td></tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Note: CBNAAT / GeneXpert MTB/RIF assay is recommended for rapid confirmation and upfront Rifampicin resistance detection.</i></p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'AFB'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Sputum for Acid-Fast Bacilli (AFB - Ziehl-Neelsen Stain) RNTCP/NTEP Grading:</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:35%; padding:2px 4px;">Acid-Fast Bacilli Count (1000× Oil Immersion)</th>
    <th style="width:30%; padding:2px 4px;">NTEP Grading Result</th>
    <th style="width:35%; padding:2px 4px;">Clinical Significance</th>
  </tr>
  <tr><td style="padding:2px 4px;">No AFB observed in 100 oil immersion fields</td><td style="padding:2px 4px;"><b>Negative</b></td><td style="padding:2px 4px;">No microscopic evidence of AFB (does not exclude TB)</td></tr>
  <tr><td style="padding:2px 4px;">1 to 9 AFB per 100 oil immersion fields</td><td style="padding:2px 4px;"><b>Scanty (Record exact number)</b></td><td style="padding:2px 4px;">Positive for pulmonary tuberculosis</td></tr>
  <tr><td style="padding:2px 4px;">10 to 99 AFB per 100 oil immersion fields</td><td style="padding:2px 4px;"><b>Positive 1+</b></td><td style="padding:2px 4px;">Infectious open pulmonary tuberculosis</td></tr>
  <tr><td style="padding:2px 4px;">1 to 10 AFB per single oil immersion field (50 fields)</td><td style="padding:2px 4px;"><b>Positive 2+</b></td><td style="padding:2px 4px;">Moderately heavy bacillary load</td></tr>
  <tr><td style="padding:2px 4px;">&gt; 10 AFB per single oil immersion field (20 fields)</td><td style="padding:2px 4px;"><b>Positive 3+</b></td><td style="padding:2px 4px;">Extremely heavy bacillary load; highly infectious</td></tr>
</table>
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Note: CBNAAT / GeneXpert MTB/RIF assay is recommended for rapid confirmation and upfront Rifampicin resistance detection.</i></p>', `show_interpretation` = 1, `updated_at` = NOW();

-- Test: MANTOUX
UPDATE `lab_tests` SET `interpretations` = '<p style="margin:2px 0;"><b>Mantoux Tuberculin Skin Test (5 TU PPD) Interpretation:</b><br>
Measured as transverse diameter of palpable induration (not erythema) after 48 to 72 hours:<br>
• <b>≥ 10 mm Induration:</b> Positive test in endemic populations (India), healthcare workers, diabetes, chronic renal disease.<br>
• <b>≥ 5 mm Induration:</b> Positive in HIV-infected individuals, immunosuppressed patients (&gt; 15 mg/day prednisolone), close contacts of active TB cases.<br>
• <b>&lt; 10 mm:</b> Negative result. Does not rule out active disease in severe malnutrition, miliary TB, or anergic states.<br>
<span style="font-size:7pt; color:#64748b;"><i>Note: Positive Mantoux indicates delayed-type hypersensitivity cell-mediated response to M. tuberculosis exposure or prior BCG vaccination; it does not differentiate latent TB from active disease.</i></span></p>' WHERE `test_code` = 'MANTOUX';
INSERT INTO `test_templates` (`test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`)
SELECT `test_id`, CONCAT(`test_name`, ' Standard'), '', '<p style="margin:2px 0;"><b>Mantoux Tuberculin Skin Test (5 TU PPD) Interpretation:</b><br>
Measured as transverse diameter of palpable induration (not erythema) after 48 to 72 hours:<br>
• <b>≥ 10 mm Induration:</b> Positive test in endemic populations (India), healthcare workers, diabetes, chronic renal disease.<br>
• <b>≥ 5 mm Induration:</b> Positive in HIV-infected individuals, immunosuppressed patients (&gt; 15 mg/day prednisolone), close contacts of active TB cases.<br>
• <b>&lt; 10 mm:</b> Negative result. Does not rule out active disease in severe malnutrition, miliary TB, or anergic states.<br>
<span style="font-size:7pt; color:#64748b;"><i>Note: Positive Mantoux indicates delayed-type hypersensitivity cell-mediated response to M. tuberculosis exposure or prior BCG vaccination; it does not differentiate latent TB from active disease.</i></span></p>', `notes`, 'default', 1, 1, 1, 1, 1, NOW()
FROM `lab_tests` WHERE `test_code` = 'MANTOUX'
ON DUPLICATE KEY UPDATE `interpretation` = '<p style="margin:2px 0;"><b>Mantoux Tuberculin Skin Test (5 TU PPD) Interpretation:</b><br>
Measured as transverse diameter of palpable induration (not erythema) after 48 to 72 hours:<br>
• <b>≥ 10 mm Induration:</b> Positive test in endemic populations (India), healthcare workers, diabetes, chronic renal disease.<br>
• <b>≥ 5 mm Induration:</b> Positive in HIV-infected individuals, immunosuppressed patients (&gt; 15 mg/day prednisolone), close contacts of active TB cases.<br>
• <b>&lt; 10 mm:</b> Negative result. Does not rule out active disease in severe malnutrition, miliary TB, or anergic states.<br>
<span style="font-size:7pt; color:#64748b;"><i>Note: Positive Mantoux indicates delayed-type hypersensitivity cell-mediated response to M. tuberculosis exposure or prior BCG vaccination; it does not differentiate latent TB from active disease.</i></span></p>', `show_interpretation` = 1, `updated_at` = NOW();
