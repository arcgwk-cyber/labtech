-- =========================================================================
-- Comprehensive Standard NABL / ICMR Compliant Indian Pathology Catalog
-- Total Lab Tests: 92 | Parameters: 144 | Packages: 15
-- =========================================================================

SET FOREIGN_KEY_CHECKS = 0;

DELETE FROM `package_test_map`;
DELETE FROM `test_packages`;
DELETE FROM `lab_test_parameters`;
DELETE FROM `parameter_reference_ranges`;
DELETE FROM `test_parameters`;
DELETE FROM `lab_tests`;
DELETE FROM `test_groups`;
DELETE FROM `test_categories`;

ALTER TABLE `test_categories` AUTO_INCREMENT = 1;
ALTER TABLE `test_groups` AUTO_INCREMENT = 1;
ALTER TABLE `lab_tests` AUTO_INCREMENT = 1;
ALTER TABLE `test_parameters` AUTO_INCREMENT = 1;
ALTER TABLE `parameter_reference_ranges` AUTO_INCREMENT = 1;
ALTER TABLE `lab_test_parameters` AUTO_INCREMENT = 1;
ALTER TABLE `test_packages` AUTO_INCREMENT = 1;
ALTER TABLE `package_test_map` AUTO_INCREMENT = 1;

INSERT INTO `test_categories` (`category_id`, `category_name`) VALUES
(1, 'Biochemistry'),
(2, 'Hematology'),
(3, 'Serology & Immunology'),
(4, 'Microbiology'),
(5, 'Clinical Pathology'),
(6, 'Endocrinology & Vitamins');

INSERT INTO `test_groups` (`group_id`, `group_name`) VALUES
(1, 'Biochemistry'),
(2, 'Hematology'),
(3, 'Serology'),
(4, 'Microbiology'),
(5, 'Immunology'),
(6, 'Clinical Pathology'),
(7, 'Endocrinology');

INSERT INTO `lab_tests` (`test_id`, `test_name`, `test_code`, `category_id`, `group_id`, `price`, `notes`, `interpretations`, `signature_id`, `stamp_id`) VALUES
(1, 'Complete Blood Count (CBC with ESR)', 'CBC-ESR', 2, 2, '350.00', 'Includes automated 5-part differential, RBC indices, Platelet count and ESR', '<p style="margin:2px 0;"><b>Clinical Significance:</b> The Complete Hemogram / CBC provides quantitative and qualitative evaluation of the formed elements of blood (erythrocytes, leukocytes, and thrombocytes).</p>
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
<p style="margin:3px 0 0 0;"><b>ESR Significance:</b> Westergren 1st-hour ESR is an indirect acute-phase marker of systemic inflammation. Marked elevation (&gt; 100 mm/hr) strongly suggests bacterial infection (e.g., TB, osteomyelitis), autoimmune disease (e.g., SLE, RA), or multiple myeloma.</p>', 1, NULL),
(2, 'Complete Hemogram / CBC', 'CBC', 2, 2, '300.00', 'Includes automated 5-part differential, RBC indices and Platelet count', '<p style="margin:2px 0;"><b>Clinical Significance:</b> The Complete Hemogram / CBC provides quantitative and qualitative evaluation of the formed elements of blood (erythrocytes, leukocytes, and thrombocytes).</p>
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
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Note: Microscopic peripheral blood smear examination is recommended when automated flags or marked cytopenias are observed.</i></p>', 1, NULL),
(3, 'Hemoglobin (Hb alone)', 'HB', 2, 2, '80.00', 'Cyanmethemoglobin / SLS automated method', '<p style="margin:2px 0;"><b>Clinical Significance:</b> Hemoglobin measurement is the primary clinical parameter for evaluating oxygen-carrying capacity and screening for anemia or polycythemia.</p>
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
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Physiological decrease occurs in pregnancy (hemodilution, cut-off: 11.0 g/dL). High levels may indicate polycythemia vera, chronic hypoxia (COPD, cyanotic heart disease), or hemoconcentration (dehydration).</i></p>', 1, NULL),
(4, 'Platelet Count alone', 'PLT', 2, 2, '100.00', 'Automated Cell Counter / Chamber confirmation', '<p style="margin:2px 0;"><b>Clinical Significance:</b> Platelets play a critical role in primary hemostasis and vascular endothelial integrity.</p>
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
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Note: In Dengue fever, counts &lt; 100,000 /µL require close monitoring for plasma leakage signs (hematocrit elevation, gall bladder wall edema).</i></p>', 1, NULL),
(5, 'Total Leucocyte Count (TLC / Total WBC)', 'TLC', 2, 2, '100.00', 'Automated cell counter count of total circulating white blood cells', '<p style="margin:2px 0;"><b>Clinical Significance:</b> Total Leucocyte Count (TLC) indicates systemic immune response and bone marrow output.</p>
<p style="margin:2px 0; font-size:7.5pt;"><b>Leukocytosis (&gt; 11,000 /µL):</b> Commonly seen in acute bacterial infections, abscesses, appendicitis, diabetic ketoacidosis, tissue necrosis (AMI), burns, strenuous exercise, glucocorticoid therapy, or myeloproliferative disorders.<br>
<b>Leukopenia (&lt; 4,000 /µL):</b> Common in viral infections (Dengue, Influenza, HIV, Hepatitis), severe sepsis (toxic depression), enteric fever, autoimmune lupus, bone marrow hypoplasia, and cytotoxic chemotherapy.</p>', 1, NULL),
(6, 'Differential Leucocyte Count (DLC)', 'DLC', 2, 2, '100.00', 'Automated / Stained smear differential counting of 100 white blood cells', '<p style="margin:2px 0;"><b>Differential Count Interpretation:</b><br>
• <b>Neutrophilia (&gt; 70%):</b> Bacterial infection, inflammation, tissue damage, stress, steroids.<br>
• <b>Lymphocytosis (&gt; 40%):</b> Viral infections (EBV, CMV, mumps, hepatitis), chronic lymphocytic leukemia (CLL), tuberculosis.<br>
• <b>Eosinophilia (&gt; 6%):</b> Allergic asthma, allergic rhinitis, parasitic intestinal worms (helminths), drug hypersensitivity, tropical pulmonary eosinophilia.<br>
• <b>Monocytosis (&gt; 10%):</b> Chronic infections, subacute bacterial endocarditis (SBE), tuberculosis, recovery phase of acute infection.<br>
• <b>Basophilia (&gt; 2%):</b> Chronic myeloid leukemia (CML), systemic allergic reactions, polycythemia vera.</p>', 1, NULL),
(7, 'Erythrocyte Sedimentation Rate (ESR)', 'ESR', 2, 2, '80.00', 'Westergren Method (1st Hour reading)', '<p style="margin:2px 0;"><b>Clinical Significance:</b> Westergren ESR reflects systemic inflammation and elevation of circulating fibrinogen and immunoglobulins.<br>
• <b>Moderate Elevation (20 – 50 mm/hr):</b> Localized infection, pregnancy, mild anemia, thyroid dysfunction, aging.<br>
• <b>Marked Elevation (&gt; 100 mm/hr):</b> Active tuberculosis, deep-seated bacterial abscesses, polymyalgia rheumatica, giant cell arteritis, systemic lupus erythematosus (SLE), multiple myeloma, metastatic malignancy.</p>', 1, NULL),
(8, 'Absolute Eosinophil Count (AEC)', 'AEC', 2, 2, '120.00', 'Calculated from total WBC and differential eosinophil percentage', '<p style="margin:2px 0;"><b>Absolute Eosinophil Count (AEC) Interpretation:</b><br>
• <b>Normal:</b> 40 – 440 cells/µL<br>
• <b>Mild Eosinophilia (440 – 1500 cells/µL):</b> Bronchial asthma, allergic dermatitis, seasonal rhinitis, drug allergy.<br>
• <b>Moderate to Marked (&gt; 1500 cells/µL):</b> Parasitic infestations (Ascaris, Strongyloides, Filariasis), Tropical Pulmonary Eosinophilia (TPE), Churg-Strauss syndrome, Hypereosinophilic Syndrome (HES).</p>', 1, NULL),
(9, 'Blood Grouping & Rh (D) Typing', 'BLOODGRP', 2, 2, '100.00', 'Forward and Reverse Tube / Slide Agglutination', '<p style="margin:2px 0;"><b>Clinical Significance:</b> Determination of ABO and Rh(D) blood group antigens by forward (cell) and reverse (serum) grouping.<br>
• <b>Pre-transfusion Verification:</b> Vital for matching donor and recipient packed red blood cells to prevent acute hemolytic transfusion reactions.<br>
• <b>Antenatal Screening:</b> Essential for detecting Rh(D)-negative pregnant mothers to administer Anti-D immunoglobulin prophylaxis against Hemolytic Disease of the Fetus and Newborn (HDFN).</p>', 1, NULL),
(10, 'Bleeding Time & Clotting Time (BT & CT)', 'BTCT', 2, 2, '100.00', 'Duke Method (BT) and Capillary Glass Tube Method (CT)', '<p style="margin:2px 0;"><b>Clinical Significance:</b> Primary pre-operative bedside screening for hemostatic competency.<br>
• <b>Bleeding Time (Duke: 1 – 5 mins):</b> Assesses platelet-vessel wall interaction (primary hemostasis). Prolonged in thrombocytopenia, von Willebrand disease, and antiplatelet (Aspirin/Clopidogrel) therapy.<br>
• <b>Clotting Time (Capillary: 3 – 8 mins):</b> Assesses intrinsic and common coagulation factor cascade. Prolonged in severe hemophilia or factor deficiencies.</p>', 1, NULL),
(11, 'Coagulation Profile (PT, INR, aPTT)', 'COAG', 2, 2, '450.00', 'Citrated plasma automated coagulometer testing', '<p style="margin:2px 0;"><b>Clinical Significance:</b> Prothrombin Time (PT) assesses the extrinsic (Factor VII) and common (Factors X, V, II, I) coagulation pathways. International Normalized Ratio (INR) standardizes results across thromboplastin reagents.</p>
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
<p style="margin:3px 0 0 0;"><b>Activated Partial Thromboplastin Time (aPTT):</b> Evaluates intrinsic pathway factors (VIII, IX, XI, XII). Normal range: 26 – 38 seconds. Therapeutic Unfractionated Heparin target: 1.5 to 2.5 times baseline control.</p>', 1, NULL),
(12, 'Prothrombin Time with INR (PT / INR)', 'PTINR', 2, 2, '300.00', 'Automated coagulometric thromboplastin time measurement', '<p style="margin:2px 0;"><b>Clinical Significance:</b> Prothrombin Time (PT) assesses the extrinsic (Factor VII) and common (Factors X, V, II, I) coagulation pathways. International Normalized Ratio (INR) standardizes results across thromboplastin reagents.</p>
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
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Note: Also prolonged in Vitamin K deficiency, liver cirrhosis / hepatocellular failure, and DIC.</i></p>', 1, NULL),
(13, 'Activated Partial Thromboplastin Time (aPTT)', 'APTT', 2, 2, '350.00', 'Coagulometer evaluation of intrinsic pathway factors', '<p style="margin:2px 0;"><b>Clinical Significance:</b> aPTT evaluates the intrinsic and common coagulation pathways (Factors VIII, IX, XI, XII, X, V, II, I).<br>
• <b>Prolonged aPTT:</b> Unfractionated Heparin therapy, Hemophilia A (Factor VIII deficiency), Hemophilia B (Factor IX deficiency), Von Willebrand disease, Lupus Anticoagulant, Severe liver disease.<br>
• <b>Heparin Monitoring:</b> Target therapeutic aPTT is typically 1.5 – 2.5 times the laboratory normal control value (approx. 50 – 75 seconds).</p>', 1, NULL),
(14, 'Peripheral Blood Smear Study (PBS)', 'PBS', 2, 2, '200.00', 'Giemsa / Leishman stained thin blood film microscopic examination by Pathologist', '<p style="margin:2px 0;"><b>Clinical Significance:</b> Morphological light microscopic evaluation of stained peripheral blood smear film by Pathologist.<br>
• <b>RBC Morphology:</b> Microcytic hypochromic (Iron deficiency, Thalassemia), Macrocytic/Megaloblastic (Vit B12/Folate deficiency), Normocytic normochromic (anemia of chronic disease, acute blood loss), Sickle cells, Spherocytes, Target cells.<br>
• <b>WBC Morphology:</b> Toxic granules, vacuolation, Dohle bodies (severe sepsis); Hypersegmented neutrophils (&gt; 5 lobes: megaloblastic anemia); Blast cells, immature myeloid/lymphoid precursors (leukemia workup required).<br>
• <b>Platelet Morphology:</b> Giant platelets (ITP, Bernard-Soulier syndrome); Platelet clumping (EDTA-induced pseudothrombocytopenia, re-check in citrate).</p>', 1, NULL),
(15, 'Reticulocyte Count', 'RETIC', 2, 2, '200.00', 'Supravital Brilliant Cresyl Blue staining', '<p style="margin:2px 0;"><b>Clinical Significance:</b> Reticulocytes are young, non-nucleated RBCs containing remnant ribosomal RNA. Reflects active bone marrow erythropoiesis.<br>
• <b>Reticulocytosis (&gt; 2.5%):</b> Acute blood loss, hemolytic anemia (sickle cell, autoimmune hemolysis), or positive response to iron/vitamin B12/folate therapy within 5–7 days.<br>
• <b>Reticulocytopenia (&lt; 0.5%):</b> Bone marrow failure (Aplastic anemia, pure red cell aplasia), untreated nutritional deficiency, myelodysplastic syndrome (MDS).</p>', 1, NULL),
(16, 'D-Dimer (Quantitative)', 'DDIMER', 2, 2, '800.00', 'Immunoturbidimetric quantitative measurement', '<p style="margin:2px 0;"><b>Clinical Significance:</b> D-Dimer is a specific fibrin degradation product generated when cross-linked fibrin is degraded by plasmin. Sensitive marker for active fibrin formation and fibrinolysis.</p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:30%; padding:2px 4px;">D-Dimer Level</th>
    <th style="width:35%; padding:2px 4px;">Diagnostic Utility</th>
    <th style="width:35%; padding:2px 4px;">Clinical Significance</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>&lt; 0.50 µg/mL FEU (&lt; 500 ng/mL)</b></td><td style="padding:2px 4px;">High Negative Predictive Value (&gt; 98%)</td><td style="padding:2px 4px;">Reliably excludes Deep Vein Thrombosis (DVT) and Pulmonary Embolism (PE) in low-to-moderate pretest risk patients</td></tr>
  <tr><td style="padding:2px 4px;"><b>&gt; 0.50 µg/mL FEU</b></td><td style="padding:2px 4px;">Positive / Elevated</td><td style="padding:2px 4px;">Venous thromboembolism (DVT/PE), Disseminated Intravascular Coagulation (DIC), acute aortic dissection, severe sepsis, COVID-19 associated coagulopathy, malignancy, major trauma, pregnancy</td></tr>
</table>', 1, NULL),
(17, 'Fasting Blood Glucose (FBS)', 'FBS', 1, 1, '60.00', 'GOD-POD / Hexokinase method following 8-12 hours overnight fast', '<p style="margin:2px 0;"><b>Diagnostic Criteria for Fasting Blood Glucose (ADA / WHO Guidelines):</b></p>
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
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Pre-analytical requirement: Minimum 8 to 12 hours overnight fast. Water permitted. Hypoglycemia defined as &lt; 70 mg/dL.</i></p>', 1, NULL),
(18, 'Postprandial Blood Glucose (PPBS)', 'PPBS', 1, 1, '60.00', 'GOD-POD method measured exactly 2 hours after breakfast or meal', '<p style="margin:2px 0;"><b>Diagnostic Criteria for 2-Hour Postprandial Glucose (ADA Guidelines):</b></p>
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
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Note: Sample should be collected exactly 2 hours after the start of a regular meal or 75g oral glucose load.</i></p>', 1, NULL),
(19, 'Random Blood Sugar (RBS)', 'RBS', 1, 1, '60.00', 'GOD-POD enzymatic method taken at any time regardless of food intake', '<p style="margin:2px 0;"><b>Random Blood Sugar (RBS) Clinical Interpretation:</b><br>
• <b>Normal:</b> 70 – 140 mg/dL (depending on time elapsed since last meal).<br>
• <b>Diabetes Mellitus:</b> Random blood glucose ≥ 200 mg/dL in the presence of classic diabetic symptoms (polyuria, polydipsia, unexplained weight loss) is diagnostic of Diabetes Mellitus.<br>
• <b>Hypoglycemia (&lt; 70 mg/dL):</b> Requires prompt clinical management, particularly in diabetic patients taking insulin or sulfonylureas.</p>', 1, NULL),
(20, 'HbA1c (Glycated Hemoglobin)', 'HBA1C', 1, 1, '400.00', 'NGSP / IFCC certified High Performance Liquid Chromatography (HPLC)', '<p style="margin:2px 0;"><b>Clinical Significance:</b> Glycated Hemoglobin (HbA1c) reflects average plasma glucose concentration over the preceding 2 to 3 months (red cell lifespan). Standardized to NGSP / IFCC reference methods.</p>
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
<span style="font-size:7pt; color:#64748b;"><i>Limitations: Falsely low in hemolytic anemia, pregnancy, acute blood loss. Falsely high in iron deficiency anemia, splenectomy. Hemoglobin variants (HbS, HbE, Thalassemia) may interfere depending on assay method.</i></span></p>', 1, NULL),
(21, 'Blood Sugar Profile (FBS, PPBS & HbA1c)', 'DIABETES', 1, 1, '450.00', 'Complete glycemic assessment combining fasting, postprandial, and 3-month glycated hemoglobin', '<p style="margin:2px 0;"><b>Clinical Significance:</b> Glycated Hemoglobin (HbA1c) reflects average plasma glucose concentration over the preceding 2 to 3 months (red cell lifespan). Standardized to NGSP / IFCC reference methods.</p>
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
<p style="margin:3px 0 0 0;"><b>Comprehensive Blood Sugar Profile:</b> Combines immediate acute fasting (FBS) and postprandial (PPBS) excursions with 3-month retrospective glycemic control (HbA1c) to optimize anti-diabetic pharmacotherapy and lifestyle planning.</p>', 1, NULL),
(22, 'Oral Glucose Tolerance Test (OGTT / GTT)', 'OGTT', 1, 1, '250.00', 'Fasting, 1-hour, and 2-hour blood sugars following 75g anhydrous oral glucose load', '<p style="margin:2px 0;"><b>Oral Glucose Tolerance Test (75g anhydrous oral glucose) Diagnostic Cutoffs:</b></p>
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
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Gestational Diabetes (DIPSI Guidelines): Single 2-hr non-fasting 75g glucose ≥ 140 mg/dL is diagnostic for GDM in pregnant women.</i></p>', 1, NULL),
(23, 'Serum Creatinine', 'CREAT', 1, 1, '120.00', 'Modified Jaffe Kinetic / Enzymatic method', '<p style="margin:2px 0;"><b>Clinical Significance:</b> Serum Creatinine is an endogenous catabolic product of muscle creatine phosphate, eliminated primarily by glomerular filtration.</p>
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
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Creatinine levels are proportional to muscle mass; lower in elderly/malnourished and higher in athletes. Mandatory check prior to intravenous radiocontrast imaging.</i></p>', 1, NULL),
(24, 'Blood Urea', 'UREA', 1, 1, '100.00', 'Enzymatic Colorimetric (Urease-GLDH)', '<p style="margin:2px 0;"><b>Blood Urea / BUN Clinical Significance:</b> Major nitrogenous end-product of protein catabolism produced by the liver.<br>
• <b>Pre-Renal Azotemia:</b> Dehydration, hypovolemia, congestive heart failure, upper GI bleeding, high protein intake (BUN:Creatinine ratio &gt; 20:1).<br>
• <b>Renal Azotemia:</b> Acute tubular necrosis, chronic glomerulonephritis, bilateral pyelonephritis (BUN:Creatinine ratio 10–15:1).<br>
• <b>Post-Renal Azotemia:</b> Urinary tract obstruction (prostatic enlargement, calculi, tumors).</p>', 1, NULL),
(25, 'Blood Urea Nitrogen (BUN)', 'BUN', 1, 1, '100.00', 'Calculated from Urea / Urease UV method', '<p style="margin:2px 0;"><b>Blood Urea / BUN Clinical Significance:</b> Major nitrogenous end-product of protein catabolism produced by the liver.<br>
• <b>Pre-Renal Azotemia:</b> Dehydration, hypovolemia, congestive heart failure, upper GI bleeding, high protein intake (BUN:Creatinine ratio &gt; 20:1).<br>
• <b>Renal Azotemia:</b> Acute tubular necrosis, chronic glomerulonephritis, bilateral pyelonephritis (BUN:Creatinine ratio 10–15:1).<br>
• <b>Post-Renal Azotemia:</b> Urinary tract obstruction (prostatic enlargement, calculi, tumors).</p>', 1, NULL),
(26, 'Serum Uric Acid', 'URIC', 1, 1, '120.00', 'Enzymatic Uricase-PAP method', '<p style="margin:2px 0;"><b>Serum Uric Acid Clinical Interpretation:</b> End-product of purine metabolism.<br>
• <b>Hyperuricemia (&gt; 7.0 mg/dL in males, &gt; 6.0 mg/dL in females):</b> Associated with acute/chronic gout, uric acid nephrolithiasis, renal failure, pre-eclampsia, metabolic syndrome, psoriasis, and tumor lysis syndrome.<br>
• <b>Asymptomatic Hyperuricemia:</b> Does not establish a diagnosis of acute gouty arthritis without compatible joint aspirate (monosodium urate crystals) or clinical arthritis signs.</p>', 1, NULL),
(27, 'Kidney Function Test (KFT / RFT Complete)', 'KFT', 1, 1, '450.00', 'Includes Blood Urea, BUN, Serum Creatinine, Uric Acid, Calcium and Phosphorus', '<p style="margin:2px 0;"><b>Clinical Significance:</b> Serum Creatinine is an endogenous catabolic product of muscle creatine phosphate, eliminated primarily by glomerular filtration.</p>
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
<p style="margin:3px 0 0 0;"><b>Comprehensive KFT/RFT Panel:</b> Evaluates glomerular filtration (Creatinine, BUN, Urea), mineral metabolism (Calcium, Phosphorus), and purine catabolism (Uric Acid). Serum Electrolytes (Na, K) are recommended for complete renal assessment.</p>', 1, NULL),
(28, 'Liver Function Test (LFT Complete)', 'LFT', 1, 1, '500.00', 'Includes Bilirubin Total, Direct, Indirect, SGOT, SGPT, ALP, GGT, Total Protein, Albumin, Globulin & A/G Ratio', '<p style="margin:2px 0;"><b>Liver Function Panel Clinical Pattern Differentiation:</b></p>
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
</table>', 1, NULL),
(29, 'Serum Bilirubin (Total, Direct & Indirect)', 'BILIRUBIN', 1, 1, '150.00', 'Modified Jendrassik-Grof Diazo method', '<p style="margin:2px 0;"><b>Serum Bilirubin Clinical Interpretation:</b><br>
• <b>Predominantly Unconjugated (Indirect) Hyperbilirubinemia:</b> Hemolytic disorders (G6PD deficiency, hereditary spherocytosis, autoimmune hemolysis), neonatal jaundice, Gilbert syndrome.<br>
• <b>Predominantly Conjugated (Direct) Hyperbilirubinemia (&gt; 50% of total):</b> Extrahepatic biliary obstruction (gallstones, stricture, pancreatic tumor), intrahepatic cholestasis (viral hepatitis, drugs, sepsis).<br>
• <b>Mixed Hyperbilirubinemia:</b> Acute hepatocellular necrosis, advanced cirrhosis.</p>', 1, NULL),
(30, 'SGOT / AST (Aspartate Aminotransferase)', 'SGOT', 1, 1, '120.00', 'IFCC without Pyridoxal Phosphate UV kinetic method', '<p style="margin:2px 0;"><b>SGOT / AST Clinical Significance:</b> Enzyme present in liver, cardiac muscle, skeletal muscle, and kidneys.<br>
• <b>Marked Elevation (&gt; 1000 U/L):</b> Acute ischemic hepatitis, paracetamol toxicity, severe acute viral hepatitis.<br>
• <b>Moderate Elevation (100 – 500 U/L):</b> Alcoholic hepatitis (AST/ALT ratio typically &gt; 2), acute pancreatitis, skeletal muscle trauma/rhabdomyolysis, myocardial infarction.<br>
• <b>Mild Elevation (&lt; 100 U/L):</b> Chronic hepatitis, non-alcoholic fatty liver disease (NAFLD), cirrhosis.</p>', 1, NULL),
(31, 'SGPT / ALT (Alanine Aminotransferase)', 'SGPT', 1, 1, '120.00', 'IFCC kinetic method, highly liver-specific enzyme', '<p style="margin:2px 0;"><b>SGPT / ALT Clinical Significance:</b> Highly specific marker for hepatocellular injury localized predominantly in liver parenchymal cells.<br>
• <b>Very High (&gt; 10× ULN):</b> Acute viral hepatitis (A, B, C, E), toxin/drug-induced liver damage, severe hypotension/shock liver.<br>
• <b>Mild-to-Moderate Elevation:</b> Non-Alcoholic Fatty Liver Disease (NAFLD / NASH), chronic hepatitis B/C, obesity, statin or NSAID use.</p>', 1, NULL),
(32, 'Alkaline Phosphatase (ALP)', 'ALP', 1, 1, '150.00', 'p-NPP / AMP Buffer kinetic IFCC method', '<p style="margin:2px 0;"><b>Alkaline Phosphatase (ALP) Clinical Significance:</b> Originates primarily from bile canalicular membranes and osteoblasts.<br>
• <b>Hepatobiliary Disorders:</b> Biliary obstruction, choledocholithiasis, primary sclerosing cholangitis, drug-induced cholestasis (correlate with high GGT).<br>
• <b>Bone Pathologies (normal GGT):</b> Paget disease of bone, osteoblastic metastases, rickets/osteomalacia, healing fractures, hyperparathyroidism.<br>
<span style="font-size:7pt; color:#64748b;"><i>Physiologically elevated in growing children (active bone growth) and normal 3rd trimester pregnancy (placental ALP).</i></span></p>', 1, NULL),
(33, 'Gamma Glutamyl Transferase (GGT)', 'GGT', 1, 1, '250.00', 'L-gamma-glutamyl-3-carboxy-4-nitroanilide enzymatic method', '<p style="margin:2px 0;"><b>Gamma-Glutamyl Transferase (GGT) Clinical Significance:</b> Sensitive biliary enzyme.<br>
• Confirms hepatobiliary origin of elevated Alkaline Phosphatase (ALP is high, GGT is high → liver; ALP high, GGT normal → bone).<br>
• Most sensitive biomarker for heavy or chronic alcohol ingestion and alcoholic liver injury.</p>', 1, NULL),
(34, 'Total Protein with Albumin & A/G Ratio', 'PROTEIN', 1, 1, '150.00', 'Biuret (Total Protein) and Bromocresol Green (Albumin) with calculated Globulin & Ratio', '<p style="margin:2px 0;"><b>Total Protein, Albumin &amp; A/G Ratio Significance:</b><br>
• <b>Hypoalbuminemia (&lt; 3.5 g/dL):</b> Impaired liver synthesis (cirrhosis), renal urinary loss (nephrotic syndrome), GI loss (protein-losing enteropathy), malnutrition.<br>
• <b>Hypergammaglobulinemia / Inverted A/G Ratio (&lt; 1.0):</b> Multiple myeloma, chronic active hepatitis, cirrhosis, severe chronic systemic infections.<br>
• <b>Monoclonal Spike:</b> Serum protein electrophoresis (SPEP) recommended if Total Protein is elevated with normal Albumin.</p>', 1, NULL),
(35, 'Lipid Profile (Complete)', 'LIPID', 1, 1, '500.00', 'Includes Total Cholesterol, HDL, LDL, Triglycerides, VLDL and Atherogenic Ratios', '<p style="margin:2px 0;"><b>Cardiovascular Risk Stratification (NCEP ATP-III / Indian Consensus Guidelines):</b></p>
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
<span style="font-size:7pt; color:#64748b;"><i>Requirement: 10 – 12 hours overnight fasting. If Triglycerides &gt; 400 mg/dL, calculated LDL (Friedewald) is invalid; direct LDL assay is advised.</i></span></p>', 1, NULL),
(36, 'Serum Cholesterol (Total)', 'CHOL', 1, 1, '120.00', 'Enzymatic CHOD-PAP method after 10-12 hour fast', '<p style="margin:2px 0;"><b>Cardiovascular Risk Stratification (NCEP ATP-III / Indian Consensus Guidelines):</b></p>
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
<span style="font-size:7pt; color:#64748b;"><i>Requirement: 10 – 12 hours overnight fasting. If Triglycerides &gt; 400 mg/dL, calculated LDL (Friedewald) is invalid; direct LDL assay is advised.</i></span></p>', 1, NULL),
(37, 'Serum Triglycerides', 'TRIG', 1, 1, '150.00', 'Enzymatic GPO-PAP method after 12 hour fast', '<p style="margin:2px 0;"><b>Cardiovascular Risk Stratification (NCEP ATP-III / Indian Consensus Guidelines):</b></p>
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
<span style="font-size:7pt; color:#64748b;"><i>Requirement: 10 – 12 hours overnight fasting. If Triglycerides &gt; 400 mg/dL, calculated LDL (Friedewald) is invalid; direct LDL assay is advised.</i></span></p>', 1, NULL),
(38, 'HDL Cholesterol (Good Cholesterol)', 'HDL', 1, 1, '150.00', 'Direct Immunoinhibition / Enzymatic clearance method', '<p style="margin:2px 0;"><b>Cardiovascular Risk Stratification (NCEP ATP-III / Indian Consensus Guidelines):</b></p>
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
<span style="font-size:7pt; color:#64748b;"><i>Requirement: 10 – 12 hours overnight fasting. If Triglycerides &gt; 400 mg/dL, calculated LDL (Friedewald) is invalid; direct LDL assay is advised.</i></span></p>', 1, NULL),
(39, 'LDL Cholesterol (Bad Cholesterol)', 'LDL', 1, 1, '150.00', 'Direct Enzymatic / Friedewald calculated', '<p style="margin:2px 0;"><b>Cardiovascular Risk Stratification (NCEP ATP-III / Indian Consensus Guidelines):</b></p>
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
<span style="font-size:7pt; color:#64748b;"><i>Requirement: 10 – 12 hours overnight fasting. If Triglycerides &gt; 400 mg/dL, calculated LDL (Friedewald) is invalid; direct LDL assay is advised.</i></span></p>', 1, NULL),
(40, 'Serum Electrolytes (Na+, K+, Cl-)', 'ELEC', 1, 1, '350.00', 'Direct Ion Selective Electrode (ISE) method', '<p style="margin:2px 0;"><b>Serum Electrolytes Interpretation:</b></p>
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
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Critical Alert: Mild hemolysis in sample artificially raises potassium markedly (pseudohyperkalemia); repeat sample required if hemolyzed.</i></p>', 1, NULL),
(41, 'Serum Sodium (Na+)', 'NA', 1, 1, '150.00', 'Direct ISE method', '<p style="margin:2px 0;"><b>Serum Electrolytes Interpretation:</b></p>
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
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Critical Alert: Mild hemolysis in sample artificially raises potassium markedly (pseudohyperkalemia); repeat sample required if hemolyzed.</i></p>', 1, NULL),
(42, 'Serum Potassium (K+)', 'K', 1, 1, '150.00', 'Direct ISE method', '<p style="margin:2px 0;"><b>Serum Electrolytes Interpretation:</b></p>
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
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Critical Alert: Mild hemolysis in sample artificially raises potassium markedly (pseudohyperkalemia); repeat sample required if hemolyzed.</i></p>', 1, NULL),
(43, 'Serum Calcium', 'CALC', 1, 1, '120.00', 'Arsenazo III photometric method', '<p style="margin:2px 0;"><b>Serum Calcium Clinical Interpretation:</b> Essential for bone mineral density, neuromuscular excitability, and cardiac contraction.<br>
• <b>Hypercalcemia (&gt; 10.5 mg/dL):</b> Primary hyperparathyroidism, osteolytic malignancy/metastases, multiple myeloma, vitamin D intoxication, sarcoidosis.<br>
• <b>Hypocalcemia (&lt; 8.5 mg/dL):</b> Hypoparathyroidism, vitamin D deficiency, chronic renal failure, acute pancreatitis, malabsorption.<br>
<span style="font-size:7pt; color:#64748b;"><i>Corrected Calcium Formula: Corrected Ca = Measured Total Ca + 0.8 × (4.0 – Serum Albumin in g/dL).</i></span></p>', 1, NULL),
(44, 'Serum Phosphorus', 'PHOS', 1, 1, '120.00', 'Phosphomolybdate UV method', '<p style="margin:2px 0;"><b>Serum Phosphorus Clinical Interpretation:</b> Evaluates calcium-phosphate homeostasis and parathyroid function.<br>
• <b>Hyperphosphatemia (&gt; 4.5 mg/dL):</b> Chronic renal failure (reduced excretion), hypoparathyroidism, tumor lysis syndrome, excessive vitamin D.<br>
• <b>Hypophosphatemia (&lt; 2.5 mg/dL):</b> Primary hyperparathyroidism, vitamin D deficiency (rickets/osteomalacia), refeeding syndrome, diabetic ketoacidosis recovery.</p>', 1, NULL),
(45, 'Serum Calcium & Phosphorus', 'CALPHOS', 1, 1, '220.00', 'Combined photometric determination', '<p style="margin:2px 0;"><b>Serum Calcium Clinical Interpretation:</b> Essential for bone mineral density, neuromuscular excitability, and cardiac contraction.<br>
• <b>Hypercalcemia (&gt; 10.5 mg/dL):</b> Primary hyperparathyroidism, osteolytic malignancy/metastases, multiple myeloma, vitamin D intoxication, sarcoidosis.<br>
• <b>Hypocalcemia (&lt; 8.5 mg/dL):</b> Hypoparathyroidism, vitamin D deficiency, chronic renal failure, acute pancreatitis, malabsorption.<br>
<span style="font-size:7pt; color:#64748b;"><i>Corrected Calcium Formula: Corrected Ca = Measured Total Ca + 0.8 × (4.0 – Serum Albumin in g/dL).</i></span></p><br><p style="margin:2px 0;"><b>Serum Phosphorus Clinical Interpretation:</b> Evaluates calcium-phosphate homeostasis and parathyroid function.<br>
• <b>Hyperphosphatemia (&gt; 4.5 mg/dL):</b> Chronic renal failure (reduced excretion), hypoparathyroidism, tumor lysis syndrome, excessive vitamin D.<br>
• <b>Hypophosphatemia (&lt; 2.5 mg/dL):</b> Primary hyperparathyroidism, vitamin D deficiency (rickets/osteomalacia), refeeding syndrome, diabetic ketoacidosis recovery.</p>', 1, NULL),
(46, 'Serum Amylase', 'AMYLASE', 1, 1, '350.00', 'Enzymatic photometric CNPG3 method', '<p style="margin:2px 0;"><b>Serum Amylase &amp; Lipase Interpretation:</b><br>
• <b>Acute Pancreatitis:</b> Levels typically rise &gt; 3 times the upper reference limit within 6–12 hours. Serum Lipase remains elevated longer (7–14 days) and has superior clinical specificity (95–99%) compared to Amylase.<br>
• <b>Other Causes of High Amylase:</b> Salivary gland disease (mumps, parotitis), acute cholecystitis, intestinal ischemia, perforated peptic ulcer, diabetic ketoacidosis, renal failure (decreased clearance).</p>', 1, NULL),
(47, 'Serum Lipase', 'LIPASE', 1, 1, '400.00', 'Enzymatic colorimetric method', '<p style="margin:2px 0;"><b>Serum Amylase &amp; Lipase Interpretation:</b><br>
• <b>Acute Pancreatitis:</b> Levels typically rise &gt; 3 times the upper reference limit within 6–12 hours. Serum Lipase remains elevated longer (7–14 days) and has superior clinical specificity (95–99%) compared to Amylase.<br>
• <b>Other Causes of High Amylase:</b> Salivary gland disease (mumps, parotitis), acute cholecystitis, intestinal ischemia, perforated peptic ulcer, diabetic ketoacidosis, renal failure (decreased clearance).</p>', 1, NULL),
(48, 'Creatine Kinase / CPK (Total)', 'CPK', 1, 1, '350.00', 'NAC-activated UV kinetic IFCC method', '<p style="margin:2px 0;"><b>Total Creatine Kinase (CPK) Interpretation:</b><br>
• <b>Striated Muscle Injury / Rhabdomyolysis:</b> Marked elevation (often 10× to 100× ULN) following crush injury, severe trauma, prolonged immobilization, statin myopathy, or vigorous unaccustomed exercise.<br>
• <b>Myocardial Infarction:</b> CPK rises within 4–6 hours, peaks at 24 hours, and returns to baseline in 48–72 hours.<br>
• <b>Neuromuscular Disorders:</b> Duchenne muscular dystrophy, polymyositis, dermatomyositis.</p>', 1, NULL),
(49, 'CK-MB (Cardiac Isoenzyme)', 'CKMB', 1, 1, '450.00', 'Immunoinhibition enzymatic kinetic assay', '<p style="margin:2px 0;"><b>CK-MB (Cardiac Isoenzyme) Clinical Interpretation:</b><br>
• Highly specific for myocardial necrosis. Rises 3 to 6 hours after acute coronary occlusion, peaks at 12–24 hours, and normalizes within 48–72 hours.<br>
• A CK-MB Relative Index (CK-MB / Total CPK × 100) &gt; 3.0% strongly indicates myocardial necrosis rather than skeletal muscle trauma.<br>
• Useful for detecting early re-infarction due to its rapid clearance.</p>', 1, NULL),
(50, 'Troponin-I (Quantitative)', 'TROP-I', 1, 1, '600.00', 'Chemiluminescent / High-Sensitivity Fluorescence Immunoassay', '<p style="margin:2px 0;"><b>Cardiac Troponin-I (High Sensitivity) Clinical Significance:</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:30%; padding:2px 4px;">Troponin-I Level</th>
    <th style="width:35%; padding:2px 4px;">Diagnostic Classification</th>
    <th style="width:35%; padding:2px 4px;">Clinical Management Recommendation</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>&lt; 99th Percentile URL</b></td><td style="padding:2px 4px;">Normal (Myocardial necrosis unlikely)</td><td style="padding:2px 4px;">Repeat after 2–3 hours if acute chest pain started &lt; 3 hours ago</td></tr>
  <tr><td style="padding:2px 4px;"><b>Elevated with Dynamic Rise/Fall</b></td><td style="padding:2px 4px;"><b>Acute Myocardial Infarction (AMI)</b></td><td style="padding:2px 4px;">Immediate cardiology evaluation, coronary angiography / intervention</td></tr>
  <tr><td style="padding:2px 4px;"><b>Chronically Elevated (Stable)</b></td><td style="padding:2px 4px;">Non-AMI Myocardial Strain</td><td style="padding:2px 4px;">Heart failure, pulmonary embolism, myocarditis, severe sepsis, chronic renal failure</td></tr>
</table>', 1, NULL),
(51, 'Serum Iron Profile (Iron, TIBC, % Saturation)', 'IRON-PROF', 1, 1, '600.00', 'Ferrozine and direct spectrophotometric assay', '<p style="margin:2px 0;"><b>Iron Profile Differential Diagnostic Guidelines:</b></p>
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
</table>', 1, NULL),
(52, 'Serum Iron', 'IRON', 1, 1, '250.00', 'Colorimetric Ferrozine method', '<p style="margin:2px 0;"><b>Iron Profile Differential Diagnostic Guidelines:</b></p>
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
</table>', 1, NULL),
(53, 'Widal Agglutination Test (Typhoid)', 'WIDAL', 3, 3, '150.00', 'Slide and Tube agglutination with S. typhi O, H and S. paratyphi AH, BH antigens', '<p style="margin:2px 0;"><b>Widal Agglutination Test (Typhoid Serodiagnosis):</b></p>
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
<span style="font-size:7pt; color:#64748b;"><i>Limitations: False-positive agglutination can occur in malaria, typhus, chronic liver disease, or previous typhoid immunization (anamnestic reaction). Blood culture is the gold standard during the 1st week of fever.</i></span></p>', 1, NULL),
(54, 'Typhoid IgM & IgG Antibodies (Typhidot)', 'TYPHIDOT', 3, 3, '300.00', 'Rapid immunochromatographic differential assay', '<p style="margin:2px 0;"><b>Typhidot (IgM &amp; IgG) Serology Interpretation:</b></p>
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
</table>', 1, NULL),
(55, 'Malaria Antigen Detection (Rapid Card Pf / Pv)', 'MAL-CARD', 3, 3, '200.00', 'Rapid Card immunochromatography for HRP-2 (Pf) and pLDH (Pv/Pan)', '<p style="margin:2px 0;"><b>Malaria Rapid Antigen Test (Card) Interpretation:</b><br>
• <b>Pan / Pv-pLDH Positive:</b> Suggests *Plasmodium vivax* (or *P. malariae / P. ovale*) infection.<br>
• <b>Pf HRP-2 Positive:</b> Indicates *Plasmodium falciparum* infection (high risk for cerebral malaria, acute renal failure, severe anemia). Requires immediate emergency antimalarial therapy.<br>
• <b>Both Pf and Pv Positive:</b> Mixed malarial infection.<br>
<span style="font-size:7pt; color:#64748b;"><i>Note: Pf HRP-2 antigen can persist in circulating blood for up to 2 to 4 weeks following successful parasite clearance. Correlate with peripheral blood smear microscopy.</i></span></p>', 1, NULL),
(56, 'Malaria Parasite Detection (Card & Smear)', 'MALARIA', 3, 3, '250.00', 'Combines Rapid Antigen Card (Pf/Pv) and Giemsa stained peripheral smear examination', '<p style="margin:2px 0;"><b>Malaria Rapid Antigen Test (Card) Interpretation:</b><br>
• <b>Pan / Pv-pLDH Positive:</b> Suggests *Plasmodium vivax* (or *P. malariae / P. ovale*) infection.<br>
• <b>Pf HRP-2 Positive:</b> Indicates *Plasmodium falciparum* infection (high risk for cerebral malaria, acute renal failure, severe anemia). Requires immediate emergency antimalarial therapy.<br>
• <b>Both Pf and Pv Positive:</b> Mixed malarial infection.<br>
<span style="font-size:7pt; color:#64748b;"><i>Note: Pf HRP-2 antigen can persist in circulating blood for up to 2 to 4 weeks following successful parasite clearance. Correlate with peripheral blood smear microscopy.</i></span></p>
<p style="margin:3px 0 0 0;"><b>Microscopic Smear Confirmation:</b> Examination of Giemsa-stained thick and thin blood films remains the clinical gold standard for species identification (P. vivax vs P. falciparum), parasite life-cycle staging (ring forms, trophozoites, schizonts, gametocytes), and parasitemia quantification.</p>', 1, NULL),
(57, 'Dengue NS1 Antigen (Early Dengue)', 'DENG-NS1', 3, 3, '400.00', 'Rapid immunochromatographic assay for Dengue NS1 glycoprotein', '<p style="margin:2px 0;"><b>Dengue NS1 Antigen Clinical Significance:</b><br>
• <b>Early Detection Window:</b> Highly sensitive during <b>Day 1 to Day 5</b> of fever onset (viremic phase) before detectable IgM antibodies develop.<br>
• <b>Positive:</b> Confirms acute primary or secondary Dengue viral infection.<br>
• <b>Negative:</b> Does not exclude Dengue if tested after Day 5 of fever; Dengue IgM/IgG serology testing is indicated.</p>', 1, NULL),
(58, 'Dengue Antibodies (IgM & IgG)', 'DENG-AB', 3, 3, '400.00', 'Differential immunochromatographic detection of Dengue IgM and IgG', '<p style="margin:2px 0;"><b>Dengue Antibodies (IgM &amp; IgG) Clinical Interpretation:</b><br>
• <b>Dengue IgM:</b> Appears by Day 4 to 5 of fever, peaks at Day 14, and persists for 2 to 3 months. Indicates current or recent Dengue infection.<br>
• <b>Dengue IgG:</b> In primary infection, appears slowly after Day 10 and persists for life. In secondary infection, rises rapidly to very high levels within 1–2 days of fever.<br>
• <b>Secondary Dengue Alert:</b> Positive IgG in early fever (with or without IgM) flags secondary infection, associated with higher risk of Dengue Hemorrhagic Fever (DHF) and Dengue Shock Syndrome (DSS).</p>', 1, NULL),
(59, 'Dengue Serology (NS1 Ag, IgM, IgG)', 'DENGUE', 3, 3, '600.00', 'Comprehensive combo testing for NS1 Antigen, IgM and IgG antibodies', '<p style="margin:2px 0;"><b>Comprehensive Dengue Serology Staging Guide:</b></p>
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
</table>', 1, NULL),
(60, 'Chikungunya IgM Rapid Card', 'CHIK-IGM', 3, 3, '400.00', 'Immunochromatographic qualitative detection of Chikungunya virus IgM antibodies', '<p style="margin:2px 0;"><b>Chikungunya IgM Serology Interpretation:</b><br>
• Detectable from Day 4 to 5 after onset of fever with debilitating polyarthralgia.<br>
• <b>Positive:</b> Confirms acute or recent Chikungunya viral infection.<br>
• <b>Negative:</b> Does not rule out infection if sample taken &lt; 4 days from symptom onset; repeat testing in 7 days recommended if severe symmetrical joint pain persists.</p>', 1, NULL),
(61, 'C-Reactive Protein (CRP, Quantitative)', 'CRP', 3, 3, '250.00', 'Immunoturbidimetric quantitative determination', '<p style="margin:2px 0;"><b>C-Reactive Protein (CRP, Quantitative) Clinical Significance:</b> Prototypic acute-phase reactant synthesized by hepatocytes under IL-6 stimulation.<br>
• <b>&lt; 6.0 mg/L:</b> Normal / Baseline level.<br>
• <b>10 – 40 mg/L:</b> Mild/moderate systemic inflammation (viral infections, mild arthritis, localized tissue injury).<br>
• <b>&gt; 50 – 100 mg/L:</b> Severe acute bacterial infection, deep sepsis, pneumonia, active systemic vasculitis, acute pancreatitis.<br>
• Useful for monitoring antibiotic response and infection resolution (rapid drop matches clinical recovery).</p>', 1, NULL),
(62, 'High Sensitivity CRP (hs-CRP)', 'HS-CRP', 3, 3, '450.00', 'High-sensitivity particle-enhanced turbidimetry', '<p style="margin:2px 0;"><b>High Sensitivity CRP (hs-CRP) Cardiovascular Risk Assessment (AHA / CDC Guidelines):</b></p>
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
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Note: If hs-CRP &gt; 10 mg/L, acute intercurrent infection or trauma should be ruled out; repeat in 2 weeks in stable metabolic state.</i></p>', 1, NULL),
(63, 'Rheumatoid Factor (RA / RF)', 'RA-FACTOR', 3, 3, '250.00', 'Latex Turbidimetry / Quantitative slide agglutination', '<p style="margin:2px 0;"><b>Rheumatoid Factor (RF) Clinical Interpretation:</b> Autoantibody (predominantly IgM) directed against the Fc fragment of human IgG.<br>
• <b>Positive (&gt; 20 IU/mL):</b> Present in 70–80% of adult patients with Rheumatoid Arthritis (RA). Higher titers correlate with erosive joint disease, subcutaneous nodules, and extra-articular manifestations.<br>
• <b>Other Causes of Positive RF:</b> Sjögren syndrome (75–90%), SLE, systemic sclerosis, chronic hepatitis C, active tuberculosis, leprosy, subacute bacterial endocarditis, healthy elderly (5%).<br>
• <b>Anti-CCP Antibody:</b> Recommended for higher diagnostic specificity (&gt; 96%) in early rheumatoid arthritis.</p>', 1, NULL),
(64, 'ASO Titre (Anti-Streptolysin O)', 'ASO', 3, 3, '300.00', 'Quantitative latex turbidimetric assay', '<p style="margin:2px 0;"><b>Anti-Streptolysin O (ASO) Titre Interpretation:</b> Detects neutralizing antibodies to streptolysin O toxin produced by Group A beta-hemolytic *Streptococcus pyogenes*.<br>
• <b>Titre &gt; 200 IU/mL:</b> Confirms antecedent streptococcal pharyngeal infection.<br>
• Crucial supportive diagnostic criterion for Acute Rheumatic Fever (Jones Criteria) and Post-Streptococcal Acute Glomerulonephritis (PSAGN).<br>
<span style="font-size:7pt; color:#64748b;"><i>Note: A single elevated titer indicates past exposure within 2–6 months; a rising or falling serial titer is clinically more significant.</i></span></p>', 1, NULL),
(65, 'HIV I & II Antibody Screening', 'HIV', 3, 3, '300.00', 'Rapid 3rd/4th generation immunochromatographic assay', '<p style="margin:2px 0;"><b>HIV I &amp; II Antibody Screening:</b><br>
• <b>Non-Reactive:</b> No antibodies to HIV-1 or HIV-2 detected. Does not rule out infection during the early "window period" (first 2 to 4 weeks post-exposure).<br>
• <b>Reactive:</b> Initial screening test reactive. As per NACO / WHO guidelines, a reactive screening result must be confirmed by three different test principles / kits or Western Blot / HIV-1 RNA PCR before issuing a positive diagnostic report. Confidential post-test counseling is advised.</p>', 1, NULL),
(66, 'HBsAg (Hepatitis B Surface Antigen)', 'HBSAG', 3, 3, '250.00', 'Rapid immunochromatographic card / ELISA test', '<p style="margin:2px 0;"><b>Hepatitis B Surface Antigen (HBsAg) Interpretation:</b><br>
• <b>Non-Reactive:</b> No active circulating Hepatitis B surface antigen detected.<br>
• <b>Reactive:</b> Confirms active Hepatitis B viral infection (acute or chronic hepatitis B carrier state).<br>
• <b>Further Workup:</b> HBeAg, Anti-HBe, Anti-HBc IgM (to differentiate acute vs chronic), HBV DNA quantitative viral load by real-time PCR, and Liver Function Tests.</p>', 1, NULL),
(67, 'Anti-HCV Antibody (Hepatitis C)', 'HCV', 3, 3, '350.00', 'Rapid immunochromatography for Hepatitis C viral antibodies', '<p style="margin:2px 0;"><b>Anti-HCV Antibody Screening:</b><br>
• <b>Non-Reactive:</b> No detectable antibodies to Hepatitis C virus.<br>
• <b>Reactive:</b> Indicates current active infection, chronic hepatitis C, or resolved past infection.<br>
• <b>Next Step:</b> Quantitative HCV RNA Real-Time PCR testing is mandatory to confirm active viral replication prior to direct-acting antiviral (DAA) therapy.</p>', 1, NULL),
(68, 'VDRL / RPR Syphilis Screen', 'VDRL', 3, 3, '150.00', 'Non-treponemal carbon antigen flocculation test', '<p style="margin:2px 0;"><b>VDRL / RPR Syphilis Screen Interpretation:</b> Non-treponemal flocculation test measuring anti-cardiolipin antibodies.<br>
• <b>Non-Reactive:</b> Seronegative for active syphilis. (May be non-reactive in very early primary chancre or late tertiary syphilis).<br>
• <b>Reactive:</b> Suggestive of active or treated *Treponema pallidum* (syphilis) infection. Reported with quantitative endpoint titer (e.g., 1:8, 1:16). A four-fold change in titer evaluates treatment response.<br>
• <b>Biological False Positives:</b> Can occur in pregnancy, autoimmune lupus (APLA), malaria, leprosy, viral hepatitis, and advanced age. Specific treponemal confirmation (TPHA / FTA-ABS) recommended.</p>', 1, NULL),
(69, 'Serum Ferritin', 'FERRITIN', 1, 1, '400.00', 'Chemiluminescent Immunoassay (CLIA)', '<p style="margin:2px 0;"><b>Serum Ferritin Clinical Significance:</b> Primary intracellular iron storage protein; directly proportional to total bone marrow iron stores.<br>
• <b>Ferritin &lt; 15 – 20 ng/mL:</b> Definitive confirmation of true Iron Deficiency Anemia (most sensitive biomarker).<br>
• <b>Ferritin &gt; 500 – 1000 ng/mL:</b> Acute phase reactant elevated in systemic hyperinflammation (COVID-19 cytokine storm, Macrophage Activation Syndrome / HLH, adult-onset Still disease, severe sepsis, chronic hemodialysis, and hemochromatosis/transfusional iron overload).</p>', 1, NULL),
(70, 'Total Serum IgE (Allergy Marker)', 'IGE', 3, 3, '500.00', 'CLIA / Turbidimetric quantitative assay', '<p style="margin:2px 0;"><b>Total Serum IgE Interpretation:</b><br>
• <b>Elevated (&gt; 100 – 150 IU/mL):</b> Atopic allergic disorders (extrinsic bronchial asthma, allergic rhinitis, atopic eczema), parasitic helminthic infections (Ascaris, Echinococcus), allergic bronchopulmonary aspergillosis (ABPA), hyper-IgE syndrome.<br>
• Allergen-specific IgE blood panel or skin prick testing advised to identify specific offending environmental or food allergens.</p>', 1, NULL),
(71, 'Thyroid Profile (Total T3, Total T4, TSH)', 'TFT', 6, 7, '400.00', 'Quantitative assessment of primary thyroid hormones by CLIA', '<p style="margin:2px 0;"><b>Thyroid Function Test Hormonal Correlation Matrix:</b></p>
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
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Note: TSH exhibits physiological diurnal rhythm (peak at night/early morning). Fasting morning sample recommended. Non-thyroidal critical illness and pregnancy alter binding proteins (Free T3/Free T4 preferred).</i></p>', 1, NULL),
(72, 'TSH (Thyroid Stimulating Hormone alone)', 'TSH', 6, 7, '200.00', 'Chemiluminescent Microparticle Immunoassay (CLIA)', '<p style="margin:2px 0;"><b>TSH Clinical Significance:</b> Chemiluminescent 3rd-generation TSH is the most sensitive first-line screening test for thyroid dysfunction and dosage titration of Levothyroxine therapy.<br>
• <b>TSH &gt; 10 µIU/mL:</b> Overt primary hypothyroidism; thyroxine replacement therapy generally indicated.<br>
• <b>TSH 4.5 – 10 µIU/mL:</b> Subclinical hypothyroidism; evaluate Anti-TPO antibodies, symptoms, pregnancy, and dyslipidemia before initiating treatment.<br>
• <b>TSH &lt; 0.1 µIU/mL:</b> Primary hyperthyroidism / Thyrotoxicosis or excessive thyroxine replacement.</p>', 1, NULL),
(73, 'Free Thyroid Profile (FT3, FT4, TSH)', 'FTFT', 6, 7, '650.00', 'Quantitative CLIA for free active unbound hormones', '<p style="margin:2px 0;"><b>Thyroid Function Test Hormonal Correlation Matrix:</b></p>
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
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Note: TSH exhibits physiological diurnal rhythm (peak at night/early morning). Fasting morning sample recommended. Non-thyroidal critical illness and pregnancy alter binding proteins (Free T3/Free T4 preferred).</i></p>', 1, NULL),
(74, 'Free T3 (FT3 alone)', 'FT3', 6, 7, '250.00', 'Quantitative CLIA for Free Triiodothyronine', '<p style="margin:2px 0;"><b>Thyroid Function Test Hormonal Correlation Matrix:</b></p>
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
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Note: TSH exhibits physiological diurnal rhythm (peak at night/early morning). Fasting morning sample recommended. Non-thyroidal critical illness and pregnancy alter binding proteins (Free T3/Free T4 preferred).</i></p>', 1, NULL),
(75, 'Free T4 (FT4 alone)', 'FT4', 6, 7, '250.00', 'Quantitative CLIA for Free Thyroxine', '<p style="margin:2px 0;"><b>Thyroid Function Test Hormonal Correlation Matrix:</b></p>
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
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Note: TSH exhibits physiological diurnal rhythm (peak at night/early morning). Fasting morning sample recommended. Non-thyroidal critical illness and pregnancy alter binding proteins (Free T3/Free T4 preferred).</i></p>', 1, NULL),
(76, 'Vitamin D3 (25-Hydroxy Vitamin D)', 'VITD', 6, 7, '650.00', 'Chemiluminescent Immunoassay (CLIA) for total 25-OH Vitamin D', '<p style="margin:2px 0;"><b>25-Hydroxy Vitamin D (Total) Clinical Classification (Endocrine Society Guidelines):</b></p>
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
</table>', 1, NULL),
(77, 'Vitamin B12 (Cyanocobalamin)', 'VITB12', 6, 7, '500.00', 'Chemiluminescent Immunoassay (CLIA)', '<p style="margin:2px 0;"><b>Serum Vitamin B12 (Cyanocobalamin) Clinical Classification:</b></p>
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
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>High prevalence in strict Indian vegetarian/vegan diets, elderly, prolonged Metformin or PPI antacid therapy, and post-bariatric gastrectomy.</i></p>', 1, NULL),
(78, 'Vitamin D & B12 Combo Panel', 'VITPKG', 6, 7, '1000.00', 'Chemiluminescent quantification of 25-OH Vitamin D and Vitamin B12', '<p style="margin:2px 0;"><b>25-Hydroxy Vitamin D (Total) Clinical Classification (Endocrine Society Guidelines):</b></p>
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
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>High prevalence in strict Indian vegetarian/vegan diets, elderly, prolonged Metformin or PPI antacid therapy, and post-bariatric gastrectomy.</i></p>', 1, NULL),
(79, 'Serum Beta-hCG (Quantitative)', 'BHCG', 6, 7, '500.00', 'Quantitative CLIA for total beta-human Chorionic Gonadotropin', '<p style="margin:2px 0;"><b>Quantitative Beta-hCG Clinical Reference Limits:</b></p>
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
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Suboptimal rise (&lt; 53% in 48h) or plateau suggests ectopic pregnancy or non-viable intrauterine pregnancy. Markedly excessive levels (&gt; 200,000 mIU/mL) suggest hydatidiform mole or choriocarcinoma.</i></p>', 1, NULL),
(80, 'Serum Prolactin', 'PROLACTIN', 6, 7, '350.00', 'Quantitative CLIA for morning prolactin', '<p style="margin:2px 0;"><b>Serum Prolactin Interpretation:</b><br>
• <b>Normal Adult Non-Pregnant:</b> 4.8 – 23.3 ng/mL.<br>
• <b>Hyperprolactinemia (&gt; 25 ng/mL):</b> Manifests as amenorrhea, galactorrhea, oligomenorrhea, female infertility, and male erectile dysfunction/gynecomastia.<br>
• <b>Etiologies:</b> Prolactinoma (pituitary adenoma; levels often &gt; 100–200 ng/mL), primary hypothyroidism (high TRH stimulates prolactin), dopamine-blocking drugs (Antipsychotics, Metoclopramide, Domperidone), chronic kidney disease, stress.<br>
<span style="font-size:7pt; color:#64748b;"><i>Sample requirement: Morning collection, patient should be seated quietly for 20 minutes prior to venipuncture (avoid exercise, breast stimulation, and acute stress).</i></span></p>', 1, NULL),
(81, 'PSA (Prostate Specific Antigen, Total)', 'PSA', 6, 7, '500.00', 'Quantitative CLIA for total circulating PSA', '<p style="margin:2px 0;"><b>Total PSA Clinical Interpretation (Prostate Cancer Screening):</b></p>
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
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Benign causes of elevated PSA: Benign Prostatic Hyperplasia (BPH), acute prostatitis, urinary retention, recent urinary catheterization, digital rectal examination (DRE), or ejaculation within 48 hours.</i></p>', 1, NULL),
(82, 'CEA (Carcinoembryonic Antigen)', 'CEA', 6, 7, '500.00', 'Quantitative CLIA for circulating oncofetal antigen', '<p style="margin:2px 0;"><b>Carcinoembryonic Antigen (CEA) Interpretation:</b><br>
• Oncofetal glycoprotein primarily used for <b>monitoring therapeutic response and detecting post-surgical recurrence</b> in diagnosed colorectal, gastric, and pancreatic carcinoma.<br>
• <b>Reference:</b> Non-smokers: &lt; 3.0 ng/mL; Smokers: &lt; 5.0 ng/mL.<br>
• Not recommended for general asymptomatic cancer screening due to limited sensitivity and specificity.<br>
<span style="font-size:7pt; color:#64748b;"><i>Benign elevations occur in chronic heavy smoking, alcoholic cirrhosis, chronic hepatitis, inflammatory bowel disease (Crohn/Ulcerative Colitis), and pancreatitis.</i></span></p>', 1, NULL),
(83, 'Thyroid Antibodies (Anti-TPO, Anti-Tg)', 'THYAB', 6, 7, '850.00', 'Quantitative CLIA for anti-thyroid peroxidase and anti-thyroglobulin', '<p style="margin:2px 0;"><b>Thyroid Autoantibodies (Anti-TPO &amp; Anti-Tg) Interpretation:</b><br>
• <b>Anti-TPO (Thyroid Peroxidase):</b> Hallmark serological biomarker for autoimmune thyroid disease. Present in &gt; 90% of patients with <b>Hashimoto thyroiditis</b> and 70–80% of patients with <b>Graves disease</b>.<br>
• <b>Anti-Tg (Thyroglobulin):</b> Helpful adjunctive marker in autoimmune thyroiditis and crucial for validating serum Thyroglobulin measurements in thyroid cancer surveillance.<br>
• High titers in euthyroid or subclinical hypothyroid individuals predict high risk of progression to overt hypothyroidism.</p>', 1, NULL),
(84, 'Complete Urine Examination (CUE / Routine)', 'URINE', 5, 6, '120.00', 'Physical, chemical reagent strip and centrifuged sediment microscopic examination', '<p style="margin:2px 0;"><b>Complete Urine Examination (CUE) Clinical Diagnostic Significance:</b></p>
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
</table>', 1, NULL),
(85, 'Urine Pregnancy Test (UPT / Card)', 'UPT', 5, 6, '100.00', 'Rapid immunochromatographic cassette test for urine hCG', '<p style="margin:2px 0;"><b>Urine Pregnancy Test (Rapid hCG Card):</b><br>
• Qualitative immunochromatographic assay detecting hCG in urine (sensitivity ~ 20–25 mIU/mL).<br>
• <b>Positive:</b> Two distinct colored bands (Control and Test line). Confirms pregnancy.<br>
• <b>Negative:</b> Single colored band at Control line only. If clinically suspected (missed period), repeat on fresh early-morning first-void urine after 48–72 hours or perform quantitative serum Beta-hCG.</p>', 1, NULL),
(86, 'Urine Microalbumin (Spot ACR)', 'MICROALB', 5, 6, '350.00', 'Quantitative immunoturbidimetric microalbumin with spot creatinine ratio', '<p style="margin:2px 0;"><b>Urine Microalbumin / Albumin-to-Creatinine Ratio (ACR) Classification (KDIGO):</b></p>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:7.5pt; width:100%; margin-top:3px;">
  <tr style="background-color:#f1f5f9; font-weight:bold;">
    <th style="width:30%; padding:2px 4px;">Albumin/Creatinine Ratio (ACR)</th>
    <th style="width:35%; padding:2px 4px;">Category (KDIGO Staging)</th>
    <th style="width:35%; padding:2px 4px;">Clinical Significance</th>
  </tr>
  <tr><td style="padding:2px 4px;"><b>&lt; 30 mg/g (&lt; 3 mg/mmol)</b></td><td style="padding:2px 4px;"><b>A1: Normal to Mildly Increased</b></td><td style="padding:2px 4px;">Normal baseline urinary albumin excretion</td></tr>
  <tr><td style="padding:2px 4px;"><b>30 – 300 mg/g (3 – 30 mg/mmol)</b></td><td style="padding:2px 4px;"><b>A2: Microalbuminuria (Moderately Increased)</b></td><td style="padding:2px 4px;">Earliest clinical marker of Diabetic Nephropathy and cardiovascular risk; ACEi/ARB therapy indicated</td></tr>
  <tr><td style="padding:2px 4px;"><b>&gt; 300 mg/g (&gt; 30 mg/mmol)</b></td><td style="padding:2px 4px;"><b>A3: Macroalbuminuria (Severely Increased)</b></td><td style="padding:2px 4px;">Overt diabetic nephropathy, high progression to chronic kidney failure</td></tr>
</table>', 1, NULL),
(87, 'Urine Sugar & Ketone Bodies', 'URINE-SK', 5, 6, '60.00', 'Rapid chemical reagent strip method', '<p style="margin:2px 0;"><b>Urine Sugar &amp; Ketones Interpretation:</b><br>
• <b>Urine Sugar Positive + Urine Ketones Positive:</b> Strongly suggestive of <b>Diabetic Ketoacidosis (DKA)</b>, a medical emergency requiring urgent hospitalization, intravenous fluid resuscitation, and insulin infusion.<br>
• <b>Urine Sugar Positive + Urine Ketones Negative:</b> Uncontrolled hyperglycemia exceeding renal tubular absorptive threshold.<br>
• <b>Urine Sugar Negative + Urine Ketones Positive:</b> Starvation ketosis, low-carbohydrate (keto) diet, persistent vomiting (hyperemesis gravidarum).</p>', 1, NULL),
(88, 'Stool Routine & Microscopic Examination', 'STOOL', 5, 6, '150.00', 'Macroscopic examination and Saline / Iodine mount light microscopy', '<p style="margin:2px 0;"><b>Stool Routine &amp; Microscopic Examination Significance:</b><br>
• <b>Pus Cells &amp; Red Blood Cells:</b> Suggests invasive bacterial dysentery (*Shigella, Salmonella, Campylobacter*) or inflammatory bowel disease (Ulcerative Colitis).<br>
• <b>Trophozoites / Cysts:</b> *Entamoeba histolytica* (amebic colitis), *Giardia lamblia* cysts (malabsorption, giardiasis).<br>
• <b>Ova / Helminth Larvae:</b> *Ascaris lumbricoides, Ancylostoma duodenale* (hookworm), *Taenia* species, *Trichuris trichiura*.<br>
• <b>Reducing Substances (&gt; 0.5%):</b> Carbohydrate / lactose malabsorption, common in post-enteritis pediatric diarrhea.</p>', 1, NULL),
(89, 'Stool Occult Blood Test (FOBT)', 'FOBT', 5, 6, '150.00', 'Fecal Immunochemical Test (FIT) / Guaiac method', '<p style="margin:2px 0;"><b>Stool Occult Blood Test (FOBT / FIT) Interpretation:</b><br>
• Detects invisible microscopic gastrointestinal bleeding.<br>
• <b>Positive:</b> Colorectal polyps, colorectal carcinoma, peptic ulcer disease, angiodysplasia, ulcerative colitis, hemorrhoids.<br>
• Recommended as primary annual non-invasive screening for colorectal cancer in adults ≥ 45–50 years.<br>
• Positive result warrants comprehensive lower gastrointestinal colonoscopy workup.</p>', 1, NULL),
(90, 'Semen Analysis (Complete)', 'SEMEN', 5, 6, '300.00', 'WHO 6th Edition standardized physical, count, motility and Kruger strict morphology evaluation', '<p style="margin:2px 0;"><b>Semen Analysis Reference Standards (WHO 6th Edition):</b></p>
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
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Sample collection instructions: Strict sexual abstinence of 2 to 7 days. Complete specimen delivered to laboratory within 30–60 minutes at body temperature.</i></p>', 1, NULL),
(91, 'Sputum for AFB (Acid Fast Bacilli - ZN Stain)', 'AFB', 4, 4, '150.00', 'Ziehl-Neelsen carbol fuchsin acid-fast microscopic examination', '<p style="margin:2px 0;"><b>Sputum for Acid-Fast Bacilli (AFB - Ziehl-Neelsen Stain) RNTCP/NTEP Grading:</b></p>
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
<p style="font-size:7pt; color:#64748b; margin:2px 0 0 0;"><i>Note: CBNAAT / GeneXpert MTB/RIF assay is recommended for rapid confirmation and upfront Rifampicin resistance detection.</i></p>', 1, NULL),
(92, 'Mantoux Test (Tuberculin Skin Test / PPD)', 'MANTOUX', 3, 3, '150.00', 'Intradermal injection of 5 TU PPD with induration calliper reading after 48-72 hours', '<p style="margin:2px 0;"><b>Mantoux Tuberculin Skin Test (5 TU PPD) Interpretation:</b><br>
Measured as transverse diameter of palpable induration (not erythema) after 48 to 72 hours:<br>
• <b>≥ 10 mm Induration:</b> Positive test in endemic populations (India), healthcare workers, diabetes, chronic renal disease.<br>
• <b>≥ 5 mm Induration:</b> Positive in HIV-infected individuals, immunosuppressed patients (&gt; 15 mg/day prednisolone), close contacts of active TB cases.<br>
• <b>&lt; 10 mm:</b> Negative result. Does not rule out active disease in severe malnutrition, miliary TB, or anergic states.<br>
<span style="font-size:7pt; color:#64748b;"><i>Note: Positive Mantoux indicates delayed-type hypersensitivity cell-mediated response to M. tuberculosis exposure or prior BCG vaccination; it does not differentiate latent TB from active disease.</i></span></p>', 1, NULL);

INSERT INTO `test_parameters` (`parameter_id`, `param_name`, `category_id`, `group_id`, `unit`, `method`, `interpretation`, `notes`) VALUES
(154, 'Hemoglobin (Hb)', 2, 2, 'g/dL', 'SLS-Hemoglobin / Automated', 'Low in anemia; high in polycythemia or dehydration.', 'Whole Blood EDTA'),
(177, 'Total RBC Count', 2, 2, 'mill/cumm', 'Automated Cell Counter', 'Decreased in anemia, blood loss; increased in erythrocytosis.', 'Whole Blood EDTA'),
(17, 'Total WBC Count (TLC)', 2, 2, 'cells/cumm', 'Automated Cell Counter', 'Elevated in acute bacterial infections, leukemias; reduced in viral infections.', 'Whole Blood EDTA'),
(178, 'Packed Cell Volume (PCV / Hematocrit)', 2, 2, '%', 'Calculated / Centrifugation', 'Percentage of blood volume occupied by erythrocytes.', 'Whole Blood EDTA'),
(156, 'Mean Corpuscular Volume (MCV)', 2, 2, 'fL', 'Calculated', 'Average volume of red blood cells. Low in microcytic, high in macrocytic anemia.', 'Whole Blood EDTA'),
(157, 'Mean Corpuscular Hemoglobin (MCH)', 2, 2, 'pg', 'Calculated', 'Average mass of hemoglobin per red blood cell.', 'Whole Blood EDTA'),
(158, 'Mean Corpuscular Hb Conc (MCHC)', 2, 2, 'g/dL', 'Calculated', 'Average concentration of hemoglobin in packed RBCs.', 'Whole Blood EDTA'),
(160, 'Red Cell Distribution Width (RDW-CV)', 2, 2, '%', 'Calculated', 'Measures variation in red blood cell volume (anisocytosis).', 'Whole Blood EDTA'),
(19, 'Platelet Count', 2, 2, 'lakh/cumm', 'Automated Cell Counter', 'Decreased in dengue, ITP, bone marrow suppression; increased in thrombocytosis.', 'Whole Blood EDTA'),
(1, 'Neutrophils', 2, 2, '%', 'Microscopy / Automated', 'Elevated in pyogenic/bacterial infections and tissue necrosis.', 'Whole Blood EDTA'),
(2, 'Lymphocytes', 2, 2, '%', 'Microscopy / Automated', 'Elevated in viral infections, chronic lymphocytic leukemia, tuberculosis.', 'Whole Blood EDTA'),
(3, 'Eosinophils', 2, 2, '%', 'Microscopy / Automated', 'Elevated in allergic reactions, bronchial asthma, and parasitic infestations.', 'Whole Blood EDTA'),
(4, 'Monocytes', 2, 2, '%', 'Microscopy / Automated', 'Elevated in chronic infections, recovery phase of acute infections.', 'Whole Blood EDTA'),
(5, 'Basophils', 2, 2, '%', 'Microscopy / Automated', 'Elevated in myeloproliferative disorders, hypersensitivity reactions.', 'Whole Blood EDTA'),
(6, 'Erythrocyte Sedimentation Rate (ESR)', 2, 2, 'mm/1st hr', 'Westergren Method', 'Non-specific marker for infection, inflammation, tissue injury and malignancy.', 'Citrated Blood'),
(7, 'Absolute Eosinophil Count (AEC)', 2, 2, 'cells/cumm', 'Calculated / Direct Chamber', 'Elevated in allergic disorders, bronchial asthma, tropical eosinophilia, parasitic infections.', 'Whole Blood EDTA'),
(8, 'Bleeding Time (BT)', 2, 2, 'minutes', 'Duke Method', 'Evaluates primary platelet plug formation and capillary integrity. Prolonged in thrombocytopenia.', 'Capillary Blood'),
(9, 'Clotting Time (CT)', 2, 2, 'minutes', 'Capillary Tube / Lee-White', 'Evaluates intrinsic and common coagulation pathways.', 'Capillary / Whole Blood'),
(114, 'Prothrombin Time (PT)', 2, 2, 'seconds', 'Neoplastin / Coagulometer', 'Tests extrinsic and common coagulation pathways.', 'Citrated Plasma'),
(115, 'PT Control', 2, 2, 'seconds', 'Laboratory Control', 'Standard plasma control reference time.', 'Citrated Plasma'),
(116, 'INR (International Normalized Ratio)', 2, 2, '', 'Calculated (PT Patient / PT Control)^ISI', 'Standardized reporting for oral anticoagulant monitoring (Warfarin).', 'Citrated Plasma'),
(135, 'Activated Partial Thromboplastin Time (aPTT)', 2, 2, 'seconds', 'Coagulometer', 'Tests intrinsic and common coagulation pathways.', 'Citrated Plasma'),
(202, 'D-Dimer', 2, 2, 'ng/mL FEU', 'Immunoturbidimetry', 'Fibrin degradation product, useful in ruling out DVT / Pulmonary Embolism and DIC.', 'Citrated Plasma'),
(10, 'Reticulocyte Count', 2, 2, '%', 'Supravital Brilliant Cresyl Blue / Automated', 'Measures erythropoietic activity. Elevated in hemolysis, response to anemia therapy.', 'Whole Blood EDTA'),
(180, 'ABO Blood Grouping', 2, 2, '', 'Forward & Reverse Agglutination', 'ABO group system determination.', 'Whole Blood EDTA'),
(181, 'Rh (D) Factor', 2, 2, '', 'Slide / Tube Agglutination', 'Presence or absence of Rh(D) erythrocyte antigen.', 'Whole Blood EDTA'),
(18, 'RBC Morphology (Smear)', 2, 2, '', 'Leishman / Giemsa Smear', 'Evaluates size, shape and chromia of red blood cells.', 'Whole Blood EDTA'),
(29, 'WBC Morphology (Smear)', 2, 2, '', 'Smear Microscopy', 'Evaluates maturity and atypical changes in white blood cells.', 'Whole Blood EDTA'),
(30, 'Platelet on Smear', 2, 2, '', 'Smear Microscopy', 'Estimation of platelets on peripheral smear.', 'Whole Blood EDTA'),
(105, 'Fasting Blood Glucose (FBS)', 1, 1, 'mg/dL', 'GOD-POD / Hexokinase', 'Diagnostic test for diabetes mellitus following 8-12 hours overnight fast.', 'Fluoride Plasma'),
(106, 'Postprandial Blood Glucose (PPBS)', 1, 1, 'mg/dL', 'GOD-POD / Hexokinase', 'Blood sugar measured exactly 2 hours after meal.', 'Fluoride Plasma'),
(107, 'Random Blood Sugar (RBS)', 1, 1, 'mg/dL', 'GOD-POD / Hexokinase', 'Any time blood sugar without regard to meals.', 'Fluoride Plasma'),
(108, 'HbA1c (Glycated Hemoglobin)', 1, 1, '%', 'HPLC (NGSP / IFCC Certified)', 'Reflects average blood glucose over preceding 90-120 days.', 'Whole Blood EDTA'),
(109, 'Estimated Average Glucose (eAG)', 1, 1, 'mg/dL', 'Calculated (28.7 * HbA1c - 46.7)', 'Equivalent average glucose derived from HbA1c.', 'Whole Blood EDTA'),
(33, 'OGTT - Fasting', 1, 1, 'mg/dL', 'GOD-POD', 'Fasting baseline in Oral Glucose Tolerance Test.', 'Fluoride Plasma'),
(34, 'OGTT - 1 Hour (75g Glucose)', 1, 1, 'mg/dL', 'GOD-POD', '1 hour post 75g anhydrous glucose load.', 'Fluoride Plasma'),
(35, 'OGTT - 2 Hours (75g Glucose)', 1, 1, 'mg/dL', 'GOD-POD', '2 hours post glucose load.', 'Fluoride Plasma'),
(161, 'Blood Urea', 1, 1, 'mg/dL', 'Enzymatic Colorimetric (Urease-GLDH)', 'Elevated in renal failure, dehydration, high protein intake, gastrointestinal bleed.', 'Serum'),
(164, 'Blood Urea Nitrogen (BUN)', 1, 1, 'mg/dL', 'Calculated / Urease', 'Urea nitrogen content in blood.', 'Serum'),
(162, 'Serum Creatinine', 1, 1, 'mg/dL', 'Modified Jaffe Kinetic / Enzymatic', 'Key indicator of renal glomerular filtration rate. Elevated in acute/chronic kidney disease.', 'Serum'),
(163, 'Serum Uric Acid', 1, 1, 'mg/dL', 'Uricase-PAP', 'Elevated in gout, renal failure, leukemia, high purine diet.', 'Serum'),
(165, 'Serum Calcium', 1, 1, 'mg/dL', 'Arsenazo III', 'Important for bone mineralization, neural transmission, cardiac contractility.', 'Serum'),
(133, 'Serum Phosphorus', 1, 1, 'mg/dL', 'Phosphomolybdate UV', 'Reciprocally related to calcium. Elevated in renal failure, hypoparathyroidism.', 'Serum'),
(11, 'Total Bilirubin', 1, 1, 'mg/dL', 'Diazo / Modified Jendrassik-Grof', 'Elevated in hemolytic, hepatocellular or obstructive jaundice.', 'Serum (Fasting preferred)'),
(12, 'Direct Bilirubin (Conjugated)', 1, 1, 'mg/dL', 'Diazo Method', 'Elevated in cholestasis, biliary obstruction, hepatocellular injury.', 'Serum'),
(143, 'Indirect Bilirubin (Unconjugated)', 1, 1, 'mg/dL', 'Calculated', 'Elevated in hemolysis, Gilbert syndrome, neonatal jaundice.', 'Serum'),
(14, 'SGOT / AST', 1, 1, 'U/L', 'IFCC without Pyridoxal Phosphate', 'Elevated in myocardial infarction, hepatitis, acute liver injury, skeletal muscle damage.', 'Serum'),
(13, 'SGPT / ALT', 1, 1, 'U/L', 'IFCC without Pyridoxal Phosphate', 'Highly specific for hepatocellular necrosis, acute/chronic viral hepatitis, fatty liver.', 'Serum'),
(15, 'Alkaline Phosphatase (ALP)', 1, 1, 'U/L', 'p-NPP / AMP Buffer (IFCC)', 'Elevated in biliary obstruction, bone diseases (Paget, rickets), hepatic metastases.', 'Serum'),
(147, 'Gamma Glutamyl Transferase (GGT)', 1, 1, 'U/L', 'Enzymatic Colorimetric (IFCC)', 'Marker of hepatobiliary disease, chronic alcohol consumption, biliary obstruction.', 'Serum'),
(148, 'Total Protein', 1, 1, 'g/dL', 'Biuret Method', 'Decreased in malnutrition, malabsorption, nephrotic syndrome, severe liver disease.', 'Serum'),
(149, 'Serum Albumin', 1, 1, 'g/dL', 'Bromocresol Green (BCG)', 'Synthesized solely by liver. Low in chronic liver failure, nephrotic syndrome, sepsis.', 'Serum'),
(150, 'Serum Globulin', 1, 1, 'g/dL', 'Calculated (Total Protein - Albumin)', 'Elevated in multiple myeloma, chronic active infections, autoimmune collagen diseases.', 'Serum'),
(151, 'A/G Ratio (Albumin/Globulin)', 1, 1, '', 'Calculated', 'Reversed ratio (< 1.0) indicates cirrhosis, nephrotic syndrome, multiple myeloma.', 'Serum'),
(101, 'Total Cholesterol', 1, 1, 'mg/dL', 'CHOD-PAP (Enzymatic)', 'Elevated levels associate with atherosclerotic cardiovascular risk.', 'Serum (12 hr Fasting)'),
(102, 'HDL Cholesterol (Good Cholesterol)', 1, 1, 'mg/dL', 'Direct Enzymatic Clearance', 'Protective anti-atherogenic lipoprotein. High levels reduce heart disease risk.', 'Serum'),
(103, 'LDL Cholesterol (Bad Cholesterol)', 1, 1, 'mg/dL', 'Direct Enzymatic / Friedewald', 'Primary atherogenic lipoprotein. Target levels depend on cardiovascular risk category.', 'Serum'),
(104, 'Serum Triglycerides', 1, 1, 'mg/dL', 'GPO-PAP (Enzymatic)', 'Elevated in metabolic syndrome, diabetes, pancreatitis, obesity.', 'Serum (12 hr Fasting)'),
(123, 'VLDL Cholesterol', 1, 1, 'mg/dL', 'Calculated (Triglycerides / 5)', 'Very low density lipoprotein carrying endogenous triglycerides.', 'Serum'),
(124, 'Total Chol / HDL Ratio', 1, 1, '', 'Calculated', 'Cardiovascular risk factor index.', 'Serum'),
(125, 'LDL / HDL Ratio', 1, 1, '', 'Calculated', 'Atherogenic index.', 'Serum'),
(128, 'Serum Sodium (Na+)', 1, 1, 'mEq/L', 'Direct ISE', 'Major extracellular cation. Critical for fluid balance, osmotic pressure and nerve conduction.', 'Serum'),
(129, 'Serum Potassium (K+)', 1, 1, 'mEq/L', 'Direct ISE', 'Major intracellular cation. Critical for myocardial excitability, neuromuscular function.', 'Serum (Non-hemolyzed)'),
(130, 'Serum Chloride (Cl-)', 1, 1, 'mEq/L', 'Direct ISE', 'Major extracellular anion. Maintains electrical neutrality and acid-base status.', 'Serum'),
(36, 'Serum Amylase', 1, 1, 'U/L', 'Enzymatic CNPG3', 'Elevated in acute pancreatitis, parotitis/mumps, intestinal obstruction.', 'Serum'),
(37, 'Serum Lipase', 1, 1, 'U/L', 'Enzymatic Colorimetric', 'Highly specific for acute pancreatitis; remains elevated longer than amylase.', 'Serum'),
(38, 'Creatine Kinase / CPK (Total)', 1, 1, 'U/L', 'IFCC / NAC-activated', 'Elevated in myocardial infarction, rhabdomyolysis, muscular dystrophy, strenuous exercise.', 'Serum'),
(39, 'CK-MB (Mass / Activity)', 1, 1, 'U/L', 'Immunoinhibition / IFCC', 'Specific for myocardial necrosis in acute myocardial infarction.', 'Serum'),
(40, 'Troponin-I (Quantitative)', 1, 1, 'ng/mL', 'CLIA / Fluorescence Immunoassay', 'Gold standard definitive biomarker for acute coronary syndrome / myocardial injury.', 'Serum / Heparin Plasma'),
(41, 'Serum Iron', 1, 1, 'µg/dL', 'Ferrozine / Nitro-PAPS', 'Measures circulating transferrin-bound iron. Low in iron deficiency anemia.', 'Serum (Morning sample)'),
(42, 'Total Iron Binding Capacity (TIBC)', 1, 1, 'µg/dL', 'Direct Spectrophotometric', 'Maximum amount of iron that can be bound by serum transferrin. Elevated in iron deficiency.', 'Serum'),
(43, 'Transferrin Saturation', 1, 1, '%', 'Calculated (Serum Iron / TIBC * 100)', 'Percentage of transferrin saturated with iron. < 16% diagnostic of iron deficiency.', 'Serum'),
(44, 'S. typhi "O" Titer', 3, 3, '', 'Slide / Tube Agglutination', 'Somatic O antigen antibody. Titer >= 1:80 considered clinically significant.', 'Serum'),
(45, 'S. typhi "H" Titer', 3, 3, '', 'Slide / Tube Agglutination', 'Flagellar H antigen antibody. Titer >= 1:160 considered clinically significant.', 'Serum'),
(46, 'S. paratyphi "AH" Titer', 3, 3, '', 'Slide / Tube Agglutination', 'Paratyphi A flagellar antigen antibody.', 'Serum'),
(47, 'S. paratyphi "BH" Titer', 3, 3, '', 'Slide / Tube Agglutination', 'Paratyphi B flagellar antigen antibody.', 'Serum'),
(48, 'Typhoid IgM Antibody (Typhidot)', 3, 3, '', 'Rapid Immunochromatography', 'Indicates acute Salmonella typhi infection, detectable from Day 2-3 of fever.', 'Serum'),
(49, 'Typhoid IgG Antibody (Typhidot)', 3, 3, '', 'Rapid Immunochromatography', 'Indicates past exposure, convalescent phase, or carrier state.', 'Serum'),
(172, 'Malaria Parasite Antigen (Pf / Pv)', 3, 3, '', 'Rapid Antigen Card (HRP-2 & pLDH)', 'Qualitative detection of Plasmodium falciparum and Plasmodium vivax antigens.', 'Whole Blood EDTA'),
(173, 'Peripheral Blood Smear for MP', 3, 3, '', 'Giemsa Stained Smear Microscopy', 'Gold standard microscopic visualization of malarial parasites.', 'Whole Blood EDTA'),
(175, 'Dengue NS1 Antigen', 3, 3, '', 'Immunochromatography (Early Dengue)', 'Early marker of Dengue viral infection, detectable from Day 1 to Day 5 of fever.', 'Serum'),
(176, 'Dengue IgM & IgG Antibodies', 3, 3, '', 'Immunochromatography (Late/Secondary Dengue)', 'IgM indicates primary acute infection (Day 5+); IgG indicates past or secondary infection.', 'Serum'),
(50, 'Chikungunya IgM Rapid', 3, 3, '', 'Immunochromatography', 'Detection of acute Chikungunya viral infection in patients with fever and arthralgia.', 'Serum'),
(200, 'C-Reactive Protein (CRP, Quantitative)', 3, 3, 'mg/L', 'Turbidimetry / Immunoturbidimetric', 'Acute phase reactant for systemic inflammation, infection, tissue injury.', 'Serum'),
(51, 'High Sensitivity CRP (hs-CRP)', 3, 3, 'mg/L', 'High-Sensitivity Turbidimetry', 'Assessment of low-grade vascular inflammation and cardiovascular risk stratification.', 'Serum'),
(52, 'Rheumatoid Factor (RA / RF)', 3, 3, 'IU/mL', 'Latex Turbidimetry / Agglutination', 'Autoantibody against IgG Fc. Screening for rheumatoid arthritis and autoimmune diseases.', 'Serum'),
(53, 'ASO Titre (Anti-Streptolysin O)', 3, 3, 'IU/mL', 'Latex Turbidimetry', 'Indicates recent Streptococcus pyogenes infection (rheumatic fever, glomerulonephritis).', 'Serum'),
(26, 'HIV I & II Antibody Screening', 3, 3, '', 'Immunochromatography (3rd/4th Gen)', 'Qualitative screening for antibodies to HIV-1 and HIV-2.', 'Serum / Plasma'),
(27, 'HBsAg (Hepatitis B Surface Antigen)', 3, 3, '', 'Immunochromatography / Rapid Card', 'Serological hallmark of acute or chronic Hepatitis B viral infection.', 'Serum'),
(32, 'Anti-HCV Antibody', 3, 3, '', 'Immunochromatography', 'Screening test for Hepatitis C virus exposure and infection.', 'Serum'),
(28, 'VDRL / RPR Syphilis Screen', 3, 3, '', 'Flocculation / Carbon Antigen', 'Non-treponemal screening test for Treponema pallidum infection.', 'Serum'),
(201, 'Serum Ferritin', 1, 1, 'ng/mL', 'CLIA', 'Reflects total body iron stores; also acts as acute phase reactant.', 'Serum'),
(54, 'Total Serum IgE', 3, 3, 'IU/mL', 'CLIA / Turbidimetry', 'Elevated in atopic allergic diseases (asthma, eczema, rhinitis) and helminth infections.', 'Serum'),
(23, 'TSH (Thyroid Stimulating Hormone)', 6, 7, 'µIU/mL', 'Chemiluminescent Immunoassay (CLIA)', 'Primary screening marker for thyroid function. Elevated in hypothyroidism, suppressed in hyperthyroidism.', 'Serum'),
(24, 'Total T3 (Triiodothyronine)', 6, 7, 'ng/dL', 'CLIA / CMIA', 'Active thyroid hormone, especially useful in T3 toxicosis.', 'Serum'),
(25, 'Total T4 (Thyroxine)', 6, 7, 'µg/dL', 'CLIA / CMIA', 'Major circulating thyroid hormone.', 'Serum'),
(55, 'Free T3 (FT3)', 6, 7, 'pg/mL', 'CLIA', 'Unbound active triiodothyronine, unaffected by binding protein variations.', 'Serum'),
(56, 'Free T4 (FT4)', 6, 7, 'ng/dL', 'CLIA', 'Unbound active thyroxine, true reflection of thyroid status.', 'Serum'),
(170, '25-Hydroxy Vitamin D3', 6, 7, 'ng/mL', 'CLIA', 'Total 25-OH Vitamin D for bone mineral density and immune regulation.', 'Serum'),
(171, 'Serum Vitamin B12 (Cyanocobalamin)', 6, 7, 'pg/mL', 'CLIA', 'Essential for erythropoiesis and neurological health. Low in megaloblastic anemia.', 'Serum'),
(57, 'Beta-hCG (Total Quantitative)', 6, 7, 'mIU/mL', 'CLIA', 'Marker for pregnancy, ectopic pregnancy, trophoblastic disease and germ cell tumors.', 'Serum'),
(58, 'Serum Prolactin', 6, 7, 'ng/mL', 'CLIA', 'Elevated in prolactinoma, galactorrhea, amenorrhea, hypothyroidism.', 'Serum (Morning)'),
(119, 'PSA (Prostate Specific Antigen, Total)', 6, 7, 'ng/mL', 'CLIA', 'Screening and monitoring of prostate carcinoma and benign prostatic hyperplasia (BPH).', 'Serum'),
(120, 'CEA (Carcinoembryonic Antigen)', 6, 7, 'ng/mL', 'CLIA', 'Monitoring of colorectal, gastrointestinal and lung carcinomas.', 'Serum'),
(59, 'Anti-TPO (Thyroid Peroxidase Antibodies)', 6, 7, 'IU/mL', 'CLIA', 'Hallmark autoantibody for Hashimoto thyroiditis and autoimmune hypothyroidism.', 'Serum'),
(60, 'Anti-Thyroglobulin Antibodies (Anti-Tg)', 6, 7, 'IU/mL', 'CLIA', 'Elevated in Hashimoto thyroiditis, Graves disease, and thyroid carcinoma monitoring.', 'Serum'),
(185, 'Urine Color', 5, 6, '', 'Visual Inspection', 'Physical examination of urine color.', 'Fresh Urine Sample'),
(186, 'Urine Appearance / Transparency', 5, 6, '', 'Visual Inspection', 'Turbidity indicates pus cells, crystals, bacteria or mucus.', 'Fresh Urine Sample'),
(187, 'Urine Specific Gravity', 5, 6, '', 'Refractometer / Reagent Strip', 'Kidney urine concentrating ability.', 'Fresh Urine Sample'),
(188, 'Urine Reaction / pH', 5, 6, '', 'pH Indicator Strip', 'Acidic or alkaline status of urine.', 'Fresh Urine Sample'),
(189, 'Urine Albumin / Protein', 5, 6, '', 'Sulfosalicylic Acid / Strip', 'Proteinuria indicates renal glomerular or tubular injury.', 'Fresh Urine Sample'),
(190, 'Urine Sugar / Glucose', 5, 6, '', 'Benedict / Glucose Oxidase', 'Glycosuria observed when blood glucose exceeds renal threshold (~180 mg/dL).', 'Fresh Urine Sample'),
(191, 'Urine Ketone Bodies', 5, 6, '', 'Rothera Nitroprusside Method', 'Ketonuria indicates diabetic ketoacidosis, starvation, prolonged vomiting.', 'Fresh Urine Sample'),
(192, 'Urine Bile Salts', 5, 6, '', 'Hay Sulfur Test', 'Positive in obstructive jaundice.', 'Fresh Urine Sample'),
(193, 'Urine Bile Pigments', 5, 6, '', 'Fouchet Test', 'Positive in hepatitis, hepatocellular and obstructive jaundice.', 'Fresh Urine Sample'),
(61, 'Urobilinogen', 5, 6, 'mg/dL', 'Ehrlich Reagent Strip', 'Increased in hemolytic anemia and hepatitis; absent in complete biliary obstruction.', 'Fresh Urine Sample'),
(194, 'Pus Cells (Leukocytes)', 5, 6, '/HPF', 'Centrifuged Sediment Microscopy', 'Pyuria indicates urinary tract infection, cystitis, pyelonephritis.', 'Fresh Urine Sample'),
(195, 'Red Blood Cells (RBCs)', 5, 6, '/HPF', 'Microscopy', 'Hematuria indicates glomerulonephritis, calculi, malignancy, trauma.', 'Fresh Urine Sample'),
(196, 'Epithelial Cells', 5, 6, '/HPF', 'Microscopy', 'Squamous epithelial cells shed from lower urinary tract.', 'Fresh Urine Sample'),
(197, 'Casts', 5, 6, '/LPF', 'Microscopy', 'Cellular, granular, hyaline casts indicative of intrinsic renal pathology.', 'Fresh Urine Sample'),
(198, 'Crystals', 5, 6, '', 'Microscopy', 'Calcium oxalate, uric acid, triple phosphate crystals.', 'Fresh Urine Sample'),
(199, 'Bacteria / Microorganisms', 5, 6, '', 'Microscopy', 'Bacteriuria indicative of infection.', 'Fresh Urine Sample'),
(62, 'Urine Pregnancy Test (Card)', 5, 6, '', 'Rapid hCG Immunochromatography', 'Qualitative detection of human Chorionic Gonadotropin for early pregnancy confirmation.', 'Early Morning Urine'),
(63, 'Urine Microalbumin', 5, 6, 'mg/L', 'Immunoturbidimetry', 'Early indicator of diabetic nephropathy and hypertensive renal damage.', 'Spot Early Morning Urine'),
(64, 'Urine Creatinine', 5, 6, 'mg/dL', 'Jaffe Kinetic', 'Used to standardize spot urine microalbumin ratio.', 'Spot Urine'),
(65, 'Albumin / Creatinine Ratio (ACR)', 5, 6, 'mg/g', 'Calculated (Microalbumin / Creatinine * 1000)', 'Standardized clinical evaluation for microalbuminuria.', 'Spot Urine'),
(66, 'Stool Color', 5, 6, '', 'Macroscopic', 'Color of feces.', 'Fresh Stool'),
(67, 'Stool Consistency', 5, 6, '', 'Macroscopic', 'Texture and consistency of stool.', 'Fresh Stool'),
(68, 'Stool Mucus', 5, 6, '', 'Macroscopic', 'Mucus present in bacillary dysentery, colitis, IBS.', 'Fresh Stool'),
(69, 'Stool Visible Blood', 5, 6, '', 'Macroscopic', 'Frank blood seen in amoebic dysentery, hemorrhoids, anal fissure.', 'Fresh Stool'),
(70, 'Stool Pus Cells', 5, 6, '/HPF', 'Saline / Iodine Mount Microscopy', 'Leukocytes present in inflammatory bowel disease and bacterial enteritis.', 'Fresh Stool'),
(71, 'Stool RBCs', 5, 6, '/HPF', 'Microscopy', 'Microscopic bleeding in GI tract.', 'Fresh Stool'),
(72, 'Ova & Cysts', 5, 6, '', 'Saline / Iodine Mount Microscopy', 'Detection of intestinal parasites (Ascaris, Giardia, E. histolytica, Hookworm).', 'Fresh Stool'),
(73, 'Occult Blood Test (FOBT)', 5, 6, '', 'Guaiac / Immunochemical (FIT)', 'Detection of hidden occult gastrointestinal bleeding, colon polyps, colorectal cancer.', 'Stool'),
(74, 'Semen Volume', 5, 6, 'mL', 'Graduated Pipette / Syringe', 'WHO 6th Edition reference value: >= 1.4 mL.', 'Fresh Semen (3-5 days abstinence)'),
(75, 'Semen Reaction / pH', 5, 6, '', 'pH Indicator Paper', 'Normal semen is slightly alkaline. Acidic pH (< 7.0) indicates seminal vesicle dysgenesis.', 'Fresh Semen'),
(76, 'Liquefaction Time', 5, 6, 'minutes', 'Incubation at 37°C', 'Normal semen liquefies completely within 15-30 minutes.', 'Fresh Semen'),
(77, 'Total Sperm Count', 5, 6, 'mill/mL', 'Improved Neubauer Chamber', 'Total spermatozoa per mL. Oligozoospermia defined as < 15 million/mL.', 'Fresh Semen'),
(78, 'Progressive Motility (PR)', 5, 6, '%', 'Microscopy (Wet Mount)', 'Sperm moving actively, either linearly or in a large circle.', 'Fresh Semen'),
(79, 'Non-Progressive Motility (NP)', 5, 6, '%', 'Microscopy (Wet Mount)', 'All other patterns of motility with absence of progression.', 'Fresh Semen'),
(80, 'Immotile Spermatozoa', 5, 6, '%', 'Microscopy (Wet Mount)', 'Spermatozoa showing no movement.', 'Fresh Semen'),
(81, 'Normal Morphology (Kruger Strict)', 5, 6, '%', 'Papanicolaou / Giemsa Staining', 'Strict criteria for normal sperm head, midpiece and tail.', 'Fresh Semen'),
(82, 'Sputum for AFB (ZN Stain)', 4, 4, '', 'Ziehl-Neelsen Acid Fast Staining', 'Primary microscopic examination for Mycobacterium tuberculosis detection.', 'Early Morning Deep Sputum'),
(83, 'Mantoux Tuberculin Skin Test (PPD)', 3, 3, 'mm', 'Intradermal PPD (5 TU) / 48-72h Calliper Reading', 'Induration measurement: <5 mm Negative, 5-9 mm Intermediate, >=10 mm Positive.', 'Intradermal Reading');

INSERT INTO `parameter_reference_ranges` (`range_id`, `parameter_id`, `male_min`, `male_max`, `male_default`, `female_min`, `female_max`, `female_default`, `child_min`, `child_max`, `child_default`, `reference_text`, `use_reference_text`) VALUES
(1, 154, '13.00', '17.00', '14.50', '12.00', '15.50', '13.50', '11.00', '14.50', '12.50', 'Male: 13.0-17.0, Female: 12.0-15.5, Child: 11.0-14.5 g/dL', 0),
(2, 177, '4.50', '5.90', '5.00', '4.00', '5.20', '4.50', '3.80', '5.00', '4.30', 'Male: 4.5-5.9, Female: 4.0-5.2 mill/cumm', 0),
(3, 17, '4000.00', '11000.00', '7500.00', '4000.00', '11000.00', '7000.00', '5000.00', '15000.00', '8500.00', 'Adults: 4,000 - 11,000 /cumm; Children: 5,000 - 15,000 /cumm', 0),
(4, 178, '40.00', '50.00', '44.00', '36.00', '46.00', '40.00', '34.00', '44.00', '38.00', 'Male: 40-50%, Female: 36-46%', 0),
(5, 156, '80.00', '100.00', '88.00', '80.00', '100.00', '88.00', '75.00', '95.00', '85.00', 'Normal: 80.0 - 100.0 fL', 0),
(6, 157, '27.00', '32.00', '29.50', '27.00', '32.00', '29.50', '25.00', '31.00', '28.00', 'Normal: 27.0 - 32.0 pg', 0),
(7, 158, '32.00', '36.00', '33.50', '32.00', '36.00', '33.50', '31.00', '35.00', '33.00', 'Normal: 32.0 - 36.0 g/dL', 0),
(8, 160, '11.50', '14.50', '12.80', '11.50', '14.50', '12.80', '11.50', '14.50', '12.80', 'Normal: 11.5 - 14.5 %', 0),
(9, 19, '1.50', '4.50', '2.50', '1.50', '4.50', '2.50', '1.50', '4.50', '2.50', 'Normal: 1.50 - 4.50 lakh/cumm (150,000 - 450,000 /µL)', 0),
(10, 1, '40.00', '75.00', '60.00', '40.00', '75.00', '60.00', '30.00', '60.00', '45.00', '40 - 75 %', 0),
(11, 2, '20.00', '45.00', '30.00', '20.00', '45.00', '30.00', '30.00', '65.00', '45.00', '20 - 45 %', 0),
(12, 3, '1.00', '6.00', '3.00', '1.00', '6.00', '3.00', '1.00', '6.00', '3.00', '1 - 6 %', 0),
(13, 4, '2.00', '8.00', '5.00', '2.00', '8.00', '5.00', '2.00', '8.00', '5.00', '2 - 8 %', 0),
(14, 5, '0.00', '1.00', '0.50', '0.00', '1.00', '0.50', '0.00', '1.00', '0.50', '0 - 1 %', 0),
(15, 6, '0.00', '15.00', '8.00', '0.00', '20.00', '12.00', '0.00', '10.00', '5.00', 'Male: 0-15 mm, Female: 0-20 mm, Child: 0-10 mm / 1st hr', 0),
(16, 7, '40.00', '440.00', '220.00', '40.00', '440.00', '200.00', '40.00', '400.00', '180.00', 'Normal: 40 - 440 cells/cumm', 0),
(17, 8, '1.00', '5.00', '2.50', '1.00', '5.00', '2.50', '1.00', '5.00', '2.50', 'Normal: 1.0 - 5.0 minutes (Duke Method)', 0),
(18, 9, '4.00', '9.00', '6.00', '4.00', '9.00', '6.00', '4.00', '9.00', '6.00', 'Normal: 4.0 - 9.0 minutes', 0),
(19, 114, '11.00', '15.00', '12.50', '11.00', '15.00', '12.50', '11.00', '14.50', '12.20', '11.0 - 15.0 seconds', 0),
(20, 115, '11.00', '13.00', '12.00', '11.00', '13.00', '12.00', '11.00', '13.00', '12.00', '11.0 - 13.0 seconds', 0),
(21, 116, '0.85', '1.15', '1.00', '0.85', '1.15', '1.00', '0.85', '1.15', '1.00', 'Normal: 0.85 - 1.15; Therapeutic Warfarin: 2.0 - 3.0', 1),
(22, 135, '25.00', '35.00', '29.00', '25.00', '35.00', '29.00', '26.00', '36.00', '30.00', '25.0 - 35.0 seconds', 0),
(23, 202, '0.00', '500.00', '220.00', '0.00', '500.00', '220.00', '0.00', '500.00', '220.00', '< 500 ng/mL FEU (Negative)', 0),
(24, 10, '0.50', '2.50', '1.20', '0.50', '2.50', '1.20', '0.50', '3.00', '1.50', 'Adults: 0.5 - 2.5 %, Infants: 2.0 - 6.0 %', 0),
(25, 180, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Group A / B / AB / O', 1),
(26, 181, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Positive / Negative', 1),
(27, 18, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Normocytic Normochromic RBCs', 1),
(28, 29, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Normal in number and morphology; no immature cells seen', 1),
(29, 30, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Adequate on smear (10-15 platelets / oil immersion field)', 1),
(30, 105, '70.00', '100.00', '85.00', '70.00', '100.00', '85.00', '70.00', '100.00', '85.00', 'Normal: 70-100, Impaired/Pre-diabetes: 101-125, Diabetes: >=126 mg/dL', 1),
(31, 106, '70.00', '140.00', '115.00', '70.00', '140.00', '115.00', '70.00', '140.00', '115.00', 'Normal: <140, Impaired Glucose Tolerance: 140-199, Diabetes: >=200 mg/dL', 1),
(32, 107, '70.00', '140.00', '100.00', '70.00', '140.00', '100.00', '70.00', '140.00', '100.00', 'Normal: 70 - 140 mg/dL (Diabetes suspected if >= 200 with symptoms)', 0),
(33, 108, '4.00', '5.60', '5.20', '4.00', '5.60', '5.20', '4.00', '5.60', '5.20', 'Non-diabetic: 4.0-5.6%, Pre-diabetes: 5.7-6.4%, Diabetes: >=6.5%, Good Control: <7.0%', 1),
(34, 109, '90.00', '120.00', '102.00', '90.00', '120.00', '102.00', '90.00', '120.00', '102.00', 'Normal: 90 - 120 mg/dL', 0),
(35, 33, '70.00', '100.00', '85.00', '70.00', '100.00', '85.00', '70.00', '100.00', '85.00', 'Normal: 70 - 100 mg/dL', 0),
(36, 34, '70.00', '180.00', '130.00', '70.00', '180.00', '130.00', '70.00', '180.00', '130.00', 'Normal: < 180 mg/dL', 0),
(37, 35, '70.00', '140.00', '110.00', '70.00', '140.00', '110.00', '70.00', '140.00', '110.00', 'Normal: < 140 mg/dL (140-199 Impaired, >= 200 Diabetes)', 1),
(38, 161, '15.00', '40.00', '25.00', '15.00', '40.00', '25.00', '10.00', '36.00', '22.00', '15.0 - 40.0 mg/dL', 0),
(39, 164, '7.00', '20.00', '12.00', '7.00', '20.00', '12.00', '5.00', '18.00', '10.00', '7.0 - 20.0 mg/dL', 0),
(40, 162, '0.70', '1.30', '0.95', '0.60', '1.10', '0.80', '0.30', '0.70', '0.50', 'Male: 0.7 - 1.3 mg/dL, Female: 0.6 - 1.1 mg/dL, Child: 0.3 - 0.7 mg/dL', 0),
(41, 163, '3.50', '7.20', '5.20', '2.60', '6.00', '4.20', '2.00', '5.50', '3.80', 'Male: 3.5 - 7.2 mg/dL, Female: 2.6 - 6.0 mg/dL', 0),
(42, 165, '8.50', '10.50', '9.40', '8.50', '10.50', '9.40', '8.80', '10.80', '9.60', '8.5 - 10.5 mg/dL', 0),
(43, 133, '2.50', '4.50', '3.50', '2.50', '4.50', '3.50', '4.00', '6.50', '5.00', 'Adults: 2.5 - 4.5 mg/dL, Children: 4.0 - 6.5 mg/dL', 0),
(44, 11, '0.20', '1.20', '0.70', '0.20', '1.10', '0.65', '0.20', '1.00', '0.60', '0.2 - 1.2 mg/dL', 0),
(45, 12, '0.00', '0.30', '0.15', '0.00', '0.30', '0.15', '0.00', '0.25', '0.10', '0.0 - 0.3 mg/dL', 0),
(46, 143, '0.20', '0.80', '0.50', '0.20', '0.80', '0.50', '0.20', '0.75', '0.45', '0.2 - 0.8 mg/dL', 0),
(47, 14, '10.00', '40.00', '24.00', '9.00', '32.00', '20.00', '15.00', '50.00', '28.00', 'Male: 10-40 U/L, Female: 9-32 U/L', 0),
(48, 13, '10.00', '45.00', '25.00', '7.00', '35.00', '18.00', '10.00', '40.00', '22.00', 'Male: 10-45 U/L, Female: 7-35 U/L', 0),
(49, 15, '44.00', '147.00', '95.00', '44.00', '147.00', '90.00', '100.00', '350.00', '180.00', 'Adults: 44 - 147 U/L; Children: 100 - 350 U/L', 0),
(50, 147, '10.00', '55.00', '28.00', '8.00', '38.00', '20.00', '5.00', '35.00', '18.00', 'Male: 10-55 U/L, Female: 8-38 U/L', 0),
(51, 148, '6.40', '8.30', '7.20', '6.40', '8.30', '7.20', '6.00', '8.00', '7.00', '6.4 - 8.3 g/dL', 0),
(52, 149, '3.50', '5.20', '4.20', '3.50', '5.20', '4.20', '3.80', '5.40', '4.40', '3.5 - 5.2 g/dL', 0),
(53, 150, '2.00', '3.50', '2.80', '2.00', '3.50', '2.80', '1.80', '3.20', '2.50', '2.0 - 3.5 g/dL', 0),
(54, 151, '1.20', '2.20', '1.50', '1.20', '2.20', '1.50', '1.20', '2.20', '1.50', '1.2 - 2.2', 0),
(55, 101, '0.00', '200.00', '165.00', '0.00', '200.00', '165.00', '0.00', '170.00', '140.00', 'Desirable: <200, Borderline: 200-239, High: >=240 mg/dL', 1),
(56, 102, '40.00', '60.00', '48.00', '50.00', '70.00', '55.00', '40.00', '60.00', '48.00', 'Male: >40 mg/dL, Female: >50 mg/dL, Optimal: >60 mg/dL', 0),
(57, 103, '0.00', '100.00', '88.00', '0.00', '100.00', '85.00', '0.00', '100.00', '80.00', 'Optimal: <100, Near Optimal: 100-129, Borderline: 130-159, High: >=160 mg/dL', 1),
(58, 104, '0.00', '150.00', '115.00', '0.00', '150.00', '110.00', '0.00', '100.00', '80.00', 'Normal: <150, Borderline: 150-199, High: 200-499, Very High: >=500 mg/dL', 1),
(59, 123, '5.00', '30.00', '22.00', '5.00', '30.00', '20.00', '5.00', '20.00', '15.00', '5.0 - 30.0 mg/dL', 0),
(60, 124, '3.00', '5.00', '3.80', '3.00', '4.50', '3.50', '3.00', '4.50', '3.50', 'Desirable: 3.0 - 5.0', 0),
(61, 125, '1.50', '3.50', '2.20', '1.50', '3.00', '2.00', '1.50', '3.00', '2.00', 'Desirable: 1.5 - 3.5', 0),
(62, 128, '135.00', '145.00', '140.00', '135.00', '145.00', '140.00', '134.00', '144.00', '139.00', '135.0 - 145.0 mEq/L', 0),
(63, 129, '3.50', '5.10', '4.20', '3.50', '5.10', '4.20', '3.70', '5.40', '4.40', '3.5 - 5.1 mEq/L', 0),
(64, 130, '96.00', '106.00', '101.00', '96.00', '106.00', '101.00', '98.00', '108.00', '102.00', '96.0 - 106.0 mEq/L', 0),
(65, 36, '28.00', '100.00', '65.00', '28.00', '100.00', '65.00', '25.00', '110.00', '70.00', 'Normal: 28 - 100 U/L', 0),
(66, 37, '13.00', '60.00', '32.00', '13.00', '60.00', '32.00', '10.00', '55.00', '30.00', 'Normal: 13 - 60 U/L', 0),
(67, 38, '39.00', '308.00', '120.00', '26.00', '192.00', '85.00', '30.00', '200.00', '90.00', 'Male: 39 - 308 U/L, Female: 26 - 192 U/L', 0),
(68, 39, '0.00', '24.00', '12.00', '0.00', '24.00', '12.00', '0.00', '24.00', '12.00', 'Normal: 0 - 24 U/L (CK-MB index > 2.5-3% suggestive of MI)', 0),
(69, 40, '0.00', '0.04', '0.01', '0.00', '0.04', '0.01', '0.00', '0.04', '0.01', 'Normal: < 0.04 ng/mL (Negative / Non-ischemic)', 1),
(70, 41, '60.00', '170.00', '110.00', '50.00', '160.00', '95.00', '50.00', '150.00', '90.00', 'Male: 60 - 170 µg/dL, Female: 50 - 160 µg/dL', 0),
(71, 42, '250.00', '450.00', '340.00', '250.00', '450.00', '340.00', '250.00', '450.00', '330.00', 'Normal: 250 - 450 µg/dL', 0),
(72, 43, '20.00', '50.00', '32.00', '15.00', '50.00', '28.00', '15.00', '45.00', '25.00', 'Normal: 20 - 50 % (< 16% indicates iron deficiency)', 0),
(73, 44, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Negative (< 1:80)', 1),
(74, 45, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Negative (< 1:80)', 1),
(75, 46, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Negative (< 1:80)', 1),
(76, 47, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Negative (< 1:80)', 1),
(77, 48, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Negative / Non-Reactive', 1),
(78, 49, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Negative / Non-Reactive', 1),
(79, 172, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Negative / Not Detected', 1),
(80, 173, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'No Malarial Parasite Seen', 1),
(81, 175, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Negative / Non-Reactive', 1),
(82, 176, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Negative / Non-Reactive', 1),
(83, 50, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Negative / Non-Reactive', 1),
(84, 200, '0.00', '6.00', '2.20', '0.00', '6.00', '2.00', '0.00', '6.00', '1.80', '< 6.0 mg/L (Normal)', 0),
(85, 51, '0.00', '1.00', '0.60', '0.00', '1.00', '0.60', '0.00', '1.00', '0.50', 'Low Risk: <1.0 mg/L, Average Risk: 1.0-3.0 mg/L, High Risk: >3.0 mg/L', 1),
(86, 52, '0.00', '20.00', '8.00', '0.00', '20.00', '8.00', '0.00', '20.00', '6.00', 'Negative: < 20.0 IU/mL; Positive: >= 20.0 IU/mL', 1),
(87, 53, '0.00', '200.00', '75.00', '0.00', '200.00', '75.00', '0.00', '150.00', '60.00', 'Adults: < 200 IU/mL, Children: < 150 IU/mL', 0),
(88, 26, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Non-Reactive', 1),
(89, 27, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Non-Reactive', 1),
(90, 32, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Non-Reactive', 1),
(91, 28, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Non-Reactive', 1),
(92, 201, '20.00', '250.00', '110.00', '10.00', '120.00', '65.00', '7.00', '140.00', '50.00', 'Male: 20 - 250 ng/mL, Female: 10 - 120 ng/mL', 0),
(93, 54, '0.00', '100.00', '45.00', '0.00', '100.00', '40.00', '0.00', '60.00', '25.00', 'Adults: < 100 IU/mL, Children: < 60 IU/mL', 0),
(94, 23, '0.35', '4.94', '2.10', '0.35', '4.94', '2.10', '0.70', '6.00', '2.50', 'Adults: 0.35 - 4.94 µIU/mL (Pregnancy: 1st Tri 0.1-2.5, 2nd Tri 0.2-3.0, 3rd Tri 0.3-3.0)', 0),
(95, 24, '60.00', '180.00', '110.00', '60.00', '180.00', '110.00', '70.00', '200.00', '120.00', '60.0 - 180.0 ng/dL', 0),
(96, 25, '4.50', '12.00', '7.80', '4.50', '12.00', '7.80', '5.50', '13.00', '8.50', '4.5 - 12.0 µg/dL', 0),
(97, 55, '2.00', '4.40', '3.10', '2.00', '4.40', '3.10', '2.00', '4.60', '3.20', 'Normal: 2.0 - 4.4 pg/mL', 0),
(98, 56, '0.80', '1.80', '1.20', '0.80', '1.80', '1.20', '0.80', '1.90', '1.30', 'Normal: 0.8 - 1.8 ng/dL', 0),
(99, 170, '30.00', '100.00', '42.00', '30.00', '100.00', '40.00', '30.00', '100.00', '38.00', 'Deficient: <20, Insufficient: 20-29, Sufficient: 30-100, Toxicity: >100 ng/mL', 1),
(100, 171, '211.00', '911.00', '450.00', '211.00', '911.00', '450.00', '211.00', '911.00', '450.00', 'Normal: 211-911 pg/mL, Borderline: 150-210, Deficient: <150 pg/mL', 1),
(101, 57, '0.00', '5.00', '1.20', '0.00', '5.00', '1.50', '0.00', '5.00', '1.00', 'Non-Pregnant: < 5.0 mIU/mL; Pregnancy: 1-2 wks: 50-500, 2-3 wks: 100-5000, 3-4 wks: 500-10000 mIU/mL', 1),
(102, 58, '2.00', '18.00', '8.50', '2.00', '29.00', '12.00', '2.00', '15.00', '7.00', 'Male: 2.0 - 18.0 ng/mL, Female: 2.0 - 29.0 ng/mL (Postmenopausal: 2.0 - 20.0 ng/mL)', 1),
(103, 119, '0.00', '4.00', '1.50', '0.00', '0.00', '0.00', '0.00', '2.50', '0.80', 'Normal: 0.0 - 4.0 ng/mL (Age specific: 40-49: <2.5, 50-59: <3.5, 60-69: <4.5, 70+: <6.5 ng/mL)', 1),
(104, 120, '0.00', '5.00', '1.80', '0.00', '5.00', '1.80', '0.00', '3.00', '1.20', 'Non-smoker: < 3.0 ng/mL; Smoker: < 5.0 ng/mL', 1),
(105, 59, '0.00', '34.00', '12.00', '0.00', '34.00', '12.00', '0.00', '34.00', '10.00', 'Normal: < 34.0 IU/mL (Negative)', 0),
(106, 60, '0.00', '115.00', '30.00', '0.00', '115.00', '30.00', '0.00', '115.00', '25.00', 'Normal: < 115.0 IU/mL (Negative)', 0),
(107, 185, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Pale Yellow / Straw', 1),
(108, 186, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Clear', 1),
(109, 187, '1.00', '1.03', '1.01', '1.00', '1.03', '1.01', '1.00', '1.02', '1.01', '1.005 - 1.030', 0),
(110, 188, '5.00', '7.50', '6.00', '5.00', '7.50', '6.00', '5.00', '7.50', '6.00', '5.0 - 7.5 (Acidic)', 0),
(111, 189, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Nil / Negative', 1),
(112, 190, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Nil / Negative', 1),
(113, 191, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Negative / Absent', 1),
(114, 192, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Negative / Absent', 1),
(115, 193, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Negative / Absent', 1),
(116, 61, '0.20', '1.00', '0.50', '0.20', '1.00', '0.50', '0.20', '1.00', '0.50', 'Normal: 0.2 - 1.0 mg/dL', 0),
(117, 194, '0.00', '5.00', '2.00', '0.00', '5.00', '2.00', '0.00', '4.00', '1.00', '0 - 5 / HPF', 0),
(118, 195, '0.00', '2.00', '0.00', '0.00', '2.00', '0.00', '0.00', '2.00', '0.00', '0 - 2 / HPF (Occasional)', 0),
(119, 196, '0.00', '5.00', '2.00', '0.00', '5.00', '2.00', '0.00', '4.00', '2.00', 'Few (0 - 5 / HPF)', 0),
(120, 197, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Nil / Not Seen', 1),
(121, 198, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Nil / Occasional Calcium Oxalate', 1),
(122, 199, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Absent / Nil', 1),
(123, 62, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Negative (Non-Pregnant) / Positive (Pregnant)', 1),
(124, 63, '0.00', '20.00', '8.00', '0.00', '20.00', '8.00', '0.00', '20.00', '6.00', 'Normal: < 20.0 mg/L', 0),
(125, 64, '40.00', '250.00', '120.00', '30.00', '200.00', '95.00', '30.00', '180.00', '80.00', '40 - 250 mg/dL', 0),
(126, 65, '0.00', '30.00', '12.00', '0.00', '30.00', '12.00', '0.00', '30.00', '10.00', 'Normal: < 30.0 mg/g; Microalbuminuria: 30.0 - 300.0 mg/g; Clinical Proteinuria: > 300.0 mg/g', 1),
(127, 66, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Brownish', 1),
(128, 67, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Formed / Semi-formed', 1),
(129, 68, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Absent / Nil', 1),
(130, 69, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Absent / Nil', 1),
(131, 70, '0.00', '2.00', '0.00', '0.00', '2.00', '0.00', '0.00', '2.00', '0.00', '0 - 2 / HPF (Nil)', 0),
(132, 71, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Nil / Absent', 1),
(133, 72, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'No Ova or Cysts Seen', 1),
(134, 73, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Negative', 1),
(135, 74, '1.50', '5.00', '2.80', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Normal: 1.5 - 5.0 mL (>= 1.4 mL per WHO criteria)', 0),
(136, 75, '7.20', '8.00', '7.60', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '7.2 - 8.0 (Alkaline)', 0),
(137, 76, '15.00', '30.00', '20.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Complete within 15 - 30 minutes', 1),
(138, 77, '15.00', '200.00', '65.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Normal: 15.0 - 200.0 million/mL (>= 15 mill/mL per WHO criteria)', 0),
(139, 78, '32.00', '100.00', '55.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '>= 32.0 % (WHO criteria)', 0),
(140, 79, '5.00', '15.00', '10.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '5.0 - 15.0 %', 0),
(141, 80, '0.00', '40.00', '25.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '<= 40.0 %', 0),
(142, 81, '4.00', '100.00', '12.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '>= 4.0 % Normal Forms (WHO criteria)', 0),
(143, 82, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Negative for Acid Fast Bacilli (No AFB Seen)', 1),
(144, 83, '0.00', '5.00', '2.00', '0.00', '5.00', '2.00', '0.00', '5.00', '1.00', 'Negative: < 5.0 mm induration; Intermediate: 5.0 - 9.0 mm; Positive: >= 10.0 mm (Past or active TB infection)', 1);

INSERT INTO `lab_test_parameters` (`id`, `test_id`, `parameter_id`, `param_order`, `section_name`) VALUES
(1, 1, 154, 1, NULL),
(2, 1, 177, 2, NULL),
(3, 1, 17, 3, NULL),
(4, 1, 178, 4, NULL),
(5, 1, 156, 5, NULL),
(6, 1, 157, 6, NULL),
(7, 1, 158, 7, NULL),
(8, 1, 160, 8, NULL),
(9, 1, 19, 9, NULL),
(10, 1, 1, 10, NULL),
(11, 1, 2, 11, NULL),
(12, 1, 3, 12, NULL),
(13, 1, 4, 13, NULL),
(14, 1, 5, 14, NULL),
(15, 1, 6, 15, NULL),
(16, 2, 154, 1, NULL),
(17, 2, 177, 2, NULL),
(18, 2, 17, 3, NULL),
(19, 2, 178, 4, NULL),
(20, 2, 156, 5, NULL),
(21, 2, 157, 6, NULL),
(22, 2, 158, 7, NULL),
(23, 2, 160, 8, NULL),
(24, 2, 19, 9, NULL),
(25, 2, 1, 10, NULL),
(26, 2, 2, 11, NULL),
(27, 2, 3, 12, NULL),
(28, 2, 4, 13, NULL),
(29, 2, 5, 14, NULL),
(30, 3, 154, 1, NULL),
(31, 4, 19, 1, NULL),
(32, 5, 17, 1, NULL),
(33, 6, 1, 1, NULL),
(34, 6, 2, 2, NULL),
(35, 6, 3, 3, NULL),
(36, 6, 4, 4, NULL),
(37, 6, 5, 5, NULL),
(38, 7, 6, 1, NULL),
(39, 8, 7, 1, NULL),
(40, 9, 180, 1, NULL),
(41, 9, 181, 2, NULL),
(42, 10, 8, 1, NULL),
(43, 10, 9, 2, NULL),
(44, 11, 114, 1, NULL),
(45, 11, 115, 2, NULL),
(46, 11, 116, 3, NULL),
(47, 11, 135, 4, NULL),
(48, 12, 114, 1, NULL),
(49, 12, 115, 2, NULL),
(50, 12, 116, 3, NULL),
(51, 13, 135, 1, NULL),
(52, 14, 18, 1, NULL),
(53, 14, 29, 2, NULL),
(54, 14, 30, 3, NULL),
(55, 15, 10, 1, NULL),
(56, 16, 202, 1, NULL),
(57, 17, 105, 1, NULL),
(58, 18, 106, 1, NULL),
(59, 19, 107, 1, NULL),
(60, 20, 108, 1, NULL),
(61, 20, 109, 2, NULL),
(62, 21, 105, 1, NULL),
(63, 21, 106, 2, NULL),
(64, 21, 108, 3, NULL),
(65, 21, 109, 4, NULL),
(66, 22, 33, 1, NULL),
(67, 22, 34, 2, NULL),
(68, 22, 35, 3, NULL),
(69, 23, 162, 1, NULL),
(70, 24, 161, 1, NULL),
(71, 25, 164, 1, NULL),
(72, 26, 163, 1, NULL),
(73, 27, 161, 1, NULL),
(74, 27, 164, 2, NULL),
(75, 27, 162, 3, NULL),
(76, 27, 163, 4, NULL),
(77, 27, 165, 5, NULL),
(78, 27, 133, 6, NULL),
(79, 28, 11, 1, NULL),
(80, 28, 12, 2, NULL),
(81, 28, 143, 3, NULL),
(82, 28, 14, 4, NULL),
(83, 28, 13, 5, NULL),
(84, 28, 15, 6, NULL),
(85, 28, 147, 7, NULL),
(86, 28, 148, 8, NULL),
(87, 28, 149, 9, NULL),
(88, 28, 150, 10, NULL),
(89, 28, 151, 11, NULL),
(90, 29, 11, 1, NULL),
(91, 29, 12, 2, NULL),
(92, 29, 143, 3, NULL),
(93, 30, 14, 1, NULL),
(94, 31, 13, 1, NULL),
(95, 32, 15, 1, NULL),
(96, 33, 147, 1, NULL),
(97, 34, 148, 1, NULL),
(98, 34, 149, 2, NULL),
(99, 34, 150, 3, NULL),
(100, 34, 151, 4, NULL),
(101, 35, 101, 1, NULL),
(102, 35, 102, 2, NULL),
(103, 35, 103, 3, NULL),
(104, 35, 104, 4, NULL),
(105, 35, 123, 5, NULL),
(106, 35, 124, 6, NULL),
(107, 35, 125, 7, NULL),
(108, 36, 101, 1, NULL),
(109, 37, 104, 1, NULL),
(110, 38, 102, 1, NULL),
(111, 39, 103, 1, NULL),
(112, 40, 128, 1, NULL),
(113, 40, 129, 2, NULL),
(114, 40, 130, 3, NULL),
(115, 41, 128, 1, NULL),
(116, 42, 129, 1, NULL),
(117, 43, 165, 1, NULL),
(118, 44, 133, 1, NULL),
(119, 45, 165, 1, NULL),
(120, 45, 133, 2, NULL),
(121, 46, 36, 1, NULL),
(122, 47, 37, 1, NULL),
(123, 48, 38, 1, NULL),
(124, 49, 39, 1, NULL),
(125, 50, 40, 1, NULL),
(126, 51, 41, 1, NULL),
(127, 51, 42, 2, NULL),
(128, 51, 43, 3, NULL),
(129, 52, 41, 1, NULL),
(130, 53, 44, 1, NULL),
(131, 53, 45, 2, NULL),
(132, 53, 46, 3, NULL),
(133, 53, 47, 4, NULL),
(134, 54, 48, 1, NULL),
(135, 54, 49, 2, NULL),
(136, 55, 172, 1, NULL),
(137, 56, 172, 1, NULL),
(138, 56, 173, 2, NULL),
(139, 57, 175, 1, NULL),
(140, 58, 176, 1, NULL),
(141, 59, 175, 1, NULL),
(142, 59, 176, 2, NULL),
(143, 60, 50, 1, NULL),
(144, 61, 200, 1, NULL),
(145, 62, 51, 1, NULL),
(146, 63, 52, 1, NULL),
(147, 64, 53, 1, NULL),
(148, 65, 26, 1, NULL),
(149, 66, 27, 1, NULL),
(150, 67, 32, 1, NULL),
(151, 68, 28, 1, NULL),
(152, 69, 201, 1, NULL),
(153, 70, 54, 1, NULL),
(154, 71, 23, 1, NULL),
(155, 71, 24, 2, NULL),
(156, 71, 25, 3, NULL),
(157, 72, 23, 1, NULL),
(158, 73, 23, 1, NULL),
(159, 73, 55, 2, NULL),
(160, 73, 56, 3, NULL),
(161, 74, 55, 1, NULL),
(162, 75, 56, 1, NULL),
(163, 76, 170, 1, NULL),
(164, 77, 171, 1, NULL),
(165, 78, 170, 1, NULL),
(166, 78, 171, 2, NULL),
(167, 79, 57, 1, NULL),
(168, 80, 58, 1, NULL),
(169, 81, 119, 1, NULL),
(170, 82, 120, 1, NULL),
(171, 83, 59, 1, NULL),
(172, 83, 60, 2, NULL),
(173, 84, 185, 1, NULL),
(174, 84, 186, 2, NULL),
(175, 84, 187, 3, NULL),
(176, 84, 188, 4, NULL),
(177, 84, 189, 5, NULL),
(178, 84, 190, 6, NULL),
(179, 84, 191, 7, NULL),
(180, 84, 192, 8, NULL),
(181, 84, 193, 9, NULL),
(182, 84, 61, 10, NULL),
(183, 84, 194, 11, NULL),
(184, 84, 195, 12, NULL),
(185, 84, 196, 13, NULL),
(186, 84, 197, 14, NULL),
(187, 84, 198, 15, NULL),
(188, 84, 199, 16, NULL),
(189, 85, 62, 1, NULL),
(190, 86, 63, 1, NULL),
(191, 86, 64, 2, NULL),
(192, 86, 65, 3, NULL),
(193, 87, 190, 1, NULL),
(194, 87, 191, 2, NULL),
(195, 88, 66, 1, NULL),
(196, 88, 67, 2, NULL),
(197, 88, 68, 3, NULL),
(198, 88, 69, 4, NULL),
(199, 88, 70, 5, NULL),
(200, 88, 71, 6, NULL),
(201, 88, 72, 7, NULL),
(202, 89, 73, 1, NULL),
(203, 90, 74, 1, NULL),
(204, 90, 75, 2, NULL),
(205, 90, 76, 3, NULL),
(206, 90, 77, 4, NULL),
(207, 90, 78, 5, NULL),
(208, 90, 79, 6, NULL),
(209, 90, 80, 7, NULL),
(210, 90, 81, 8, NULL),
(211, 91, 82, 1, NULL),
(212, 92, 83, 1, NULL);

INSERT INTO `test_packages` (`package_id`, `package_name`, `package_code`, `package_price`, `notes`) VALUES
(1, 'Basic Health Checkup', 'BASICPKG', '699.00', 'Essential baseline health check: CBC, Fasting Blood Sugar, Lipid Profile, LFT, and Kidney Function Test'),
(2, 'Executive Health Checkup', 'EXECUTIVE', '1499.00', 'Comprehensive corporate executive checkup: CBC, Blood Sugar, Lipid Profile, LFT, KFT, Thyroid Profile, Electrolytes & Urine Routine'),
(3, 'Fever Profile (Complete)', 'FEVERPKG', '599.00', 'Comprehensive acute fever workup: CBC with ESR, LFT, Malaria Antigen & Smear, Widal Agglutination, and Urine Routine'),
(4, 'Diabetic Care Package', 'DIABETESPKG', '499.00', 'Complete diabetes monitoring: Fasting Sugar, Postprandial Sugar, HbA1c, Serum Creatinine, and Urine Microalbumin'),
(5, 'Comprehensive Cardiac Profile', 'CARDIAC', '999.00', 'Cardiovascular risk package: Lipid Profile, Blood Sugar, CBC, Serum Electrolytes, and High Sensitivity hs-CRP'),
(6, 'Liver Health Package', 'LIVERPKG', '599.00', 'Comprehensive liver workup: Complete LFT, HBsAg, HCV Antibody, and CBC'),
(7, 'Kidney Care Package', 'KIDNEYPKG', '550.00', 'Complete renal assessment: KFT (Urea, Creatinine, Uric Acid, Calcium, Phos), Serum Electrolytes & Urine Examination'),
(8, 'Antenatal Profile (ANC Complete)', 'ANTENATAL', '1299.00', 'Mandatory pregnancy profile: CBC, Blood Grouping & Rh, Blood Sugar, HIV I/II, HBsAg, VDRL, TSH & Urine Routine'),
(9, 'Senior Citizen Wellness Package', 'SENIOR', '1699.00', 'Complete elderly health screening: CBC, KFT, LFT, Lipid, HbA1c, Calcium, Electrolytes, TSH & Complete Urine'),
(10, 'Full Body Health Screening (75+ Parameters)', 'FULLBODY', '2199.00', 'Complete multi-organ checkup: CBC, LFT, KFT, Lipid, Thyroid (TFT), HbA1c, Electrolytes, Vitamin D3, Vitamin B12 & Urine'),
(11, 'Pre-Operative / Surgical Fitness Profile', 'PREOP', '999.00', 'Mandatory pre-surgery fitness: CBC, Blood Group, BT & CT, PT/INR, Blood Sugar, HIV, HBsAg, HCV, Serum Creatinine & Urine'),
(12, 'Arthritis & Joint Pain Profile', 'ARTHRITIS', '799.00', 'Specialized joint screening: CBC with ESR, Serum Uric Acid, Serum Calcium, RA Factor, and Quantitative CRP'),
(13, 'Thyroid & Vitamin Health Panel', 'THY-VIT', '1299.00', 'Complete endocrine vitality check: Thyroid Profile (TFT), Vitamin D3 (25-OH), Vitamin B12, and Serum Calcium'),
(14, 'Anemia Screening Profile', 'ANEMIA', '699.00', 'Comprehensive anemia differential: CBC with ESR, Serum Iron Profile (Iron, TIBC, % Saturation), Serum Ferritin & Peripheral Smear'),
(15, 'Monsoon / Acute Fever Panel', 'MONSOON', '899.00', 'Rapid monsoon epidemic fever differential: CBC, Dengue Combo (NS1+IgM+IgG), Malaria Card & Smear, Widal Agglutination & Urine Routine');

INSERT INTO `package_test_map` (`id`, `package_id`, `test_id`) VALUES
(1, 1, 2),
(2, 1, 17),
(3, 1, 35),
(4, 1, 28),
(5, 1, 27),
(6, 2, 2),
(7, 2, 17),
(8, 2, 35),
(9, 2, 28),
(10, 2, 27),
(11, 2, 71),
(12, 2, 40),
(13, 2, 84),
(14, 3, 1),
(15, 3, 28),
(16, 3, 56),
(17, 3, 53),
(18, 3, 84),
(19, 4, 17),
(20, 4, 18),
(21, 4, 20),
(22, 4, 23),
(23, 4, 86),
(24, 5, 35),
(25, 5, 17),
(26, 5, 2),
(27, 5, 40),
(28, 5, 62),
(29, 6, 28),
(30, 6, 66),
(31, 6, 67),
(32, 6, 2),
(33, 7, 27),
(34, 7, 40),
(35, 7, 84),
(36, 8, 2),
(37, 8, 9),
(38, 8, 19),
(39, 8, 65),
(40, 8, 66),
(41, 8, 68),
(42, 8, 72),
(43, 8, 84),
(44, 9, 2),
(45, 9, 27),
(46, 9, 28),
(47, 9, 35),
(48, 9, 20),
(49, 9, 43),
(50, 9, 40),
(51, 9, 72),
(52, 9, 84),
(53, 10, 2),
(54, 10, 28),
(55, 10, 27),
(56, 10, 35),
(57, 10, 71),
(58, 10, 20),
(59, 10, 40),
(60, 10, 76),
(61, 10, 77),
(62, 10, 84),
(63, 11, 2),
(64, 11, 9),
(65, 11, 10),
(66, 11, 12),
(67, 11, 19),
(68, 11, 65),
(69, 11, 66),
(70, 11, 67),
(71, 11, 23),
(72, 11, 84),
(73, 12, 1),
(74, 12, 26),
(75, 12, 43),
(76, 12, 63),
(77, 12, 61),
(78, 13, 71),
(79, 13, 76),
(80, 13, 77),
(81, 13, 43),
(82, 14, 1),
(83, 14, 51),
(84, 14, 69),
(85, 14, 14),
(86, 15, 2),
(87, 15, 59),
(88, 15, 56),
(89, 15, 53),
(90, 15, 84);

SET FOREIGN_KEY_CHECKS = 1;
