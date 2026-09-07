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
    "interpretations" => "Assessment of anemia, infections, hematological disorders, acute phase response and platelet function.",
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
    "interpretations" => "Evaluation of erythrocytic, leukocytic and thrombocytic series.",
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
    "interpretations" => "Primary screening for anemia, nutritional deficiencies and polycythemia.",
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
    "interpretations" => "Essential for monitoring dengue fever, thrombocytopenia, chemotherapy response, and bleeding disorders.",
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
    "interpretations" => "Assessment of leukocytosis (infection, inflammation) or leukopenia.",
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
    "interpretations" => "Evaluation of neutrophil, lymphocyte, eosinophil, monocyte, and basophil proportions.",
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
    "interpretations" => "Non-specific indicator of systemic inflammation, infection, autoimmune disease, or malignancy.",
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
    "interpretations" => "Evaluation of allergic disorders, bronchial asthma, drug reactions, and parasitic infestations.",
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
    "interpretations" => "Essential pre-operative, transfusion, antenatal, and donor blood group verification.",
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
    "interpretations" => "Mandatory pre-operative coagulation screening before all surgical and dental procedures.",
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
    "interpretations" => "Complete assessment of extrinsic, intrinsic, and common coagulation pathways.",
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
    "interpretations" => "Standardized monitoring of Oral Anticoagulant Therapy (Warfarin/Acitrom) and extrinsic pathway.",
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
    "interpretations" => "Monitoring unfractionated heparin therapy, hemophilia screening, and lupus anticoagulant.",
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
    "interpretations" => "Detailed morphological assessment of RBCs, WBCs, platelets, and screening for abnormal cells/parasites.",
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
    "interpretations" => "Evaluation of bone marrow erythropoietic response in anemia and hemolysis.",
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
    "interpretations" => "Exclusion of Deep Vein Thrombosis (DVT), Pulmonary Embolism (PE), and assessment of DIC / COVID coagulopathy.",
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
    "interpretations" => "Primary gold standard screening and diagnostic test for Diabetes Mellitus and Impaired Fasting Glucose.",
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
    "interpretations" => "Assessment of postprandial glycemic excursions and diabetes management.",
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
    "interpretations" => "Emergency screening for hypoglycemia, acute hyperglycemia, and walk-in clinical assessment.",
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
    "interpretations" => "Reflects 3-month retrospective glycemic control; diagnostic for diabetes mellitus (>= 6.5%).",
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
    "interpretations" => "Comprehensive diabetic evaluation, therapy optimization, and monitoring.",
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
    "interpretations" => "Definitive diagnosis of Impaired Glucose Tolerance and Gestational Diabetes Mellitus (GDM).",
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
    "interpretations" => "Key indicator of renal glomerular filtration rate. Crucial before intravenous contrast CT scans and drug dosing.",
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
    "interpretations" => "Assessment of renal function, hydration status, catabolic rate, and gastrointestinal bleeding.",
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
    "interpretations" => "Assessment of protein metabolism and renal clearance.",
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
    "interpretations" => "Diagnosis and monitoring of Gout, hyperuricemia, renal calculi, and pre-eclampsia.",
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
    "interpretations" => "Complete biochemical panel for evaluating renal parenchymal function, glomerular filtration and mineral metabolism.",
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
    "interpretations" => "Comprehensive evaluation of hepatic synthetic capacity, hepatocellular integrity, and cholestasis.",
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
    "interpretations" => "Evaluation of jaundice (hemolytic, hepatocellular, obstructive) and neonatal hyperbilirubinemia.",
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
    "interpretations" => "Evaluation of acute myocardial injury, hepatocellular damage, skeletal muscle injury, and alcoholic hepatitis.",
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
    "interpretations" => "Sensitive marker for viral hepatitis, drug-induced liver injury, non-alcoholic fatty liver disease (NAFLD).",
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
    "interpretations" => "Marker for obstructive jaundice, biliary tract disease, and osteoblastic bone disorders (Paget, rickets).",
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
    "interpretations" => "Most sensitive marker for biliary epithelial injury and chronic alcohol consumption.",
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
    "interpretations" => "Assessment of nutritional status, hepatic synthesis, nephrotic syndrome, and multiple myeloma.",
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
    "interpretations" => "Cardiovascular risk stratification, dyslipidemia diagnosis, and statin therapy monitoring.",
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
    "interpretations" => "Screening for hypercholesterolemia and coronary artery disease risk.",
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
    "interpretations" => "Evaluation of hypertriglyceridemia, metabolic syndrome, and acute pancreatitis risk.",
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
    "interpretations" => "Protective anti-atherogenic lipoprotein fraction; low levels indicate heightened coronary risk.",
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
    "interpretations" => "Primary target of lipid-lowering therapy for cardiovascular disease prevention.",
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
    "interpretations" => "Critical evaluation of electrolyte balance, acid-base homeostasis, renal failure, and hypertension.",
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
    "interpretations" => "Assessment of hyponatremia, dehydration, edema, and neurological status.",
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
    "interpretations" => "Crucial marker for cardiac arrhythmias, muscle weakness, diuretic therapy, and renal dysfunction.",
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
    "interpretations" => "Evaluation of bone metabolism, parathyroid disorders, tetany, and renal osteodystrophy.",
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
    "interpretations" => "Assessment of calcium-phosphorus homeostasis, renal failure, and rickets.",
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
    "interpretations" => "Evaluation of metabolic bone diseases, secondary hyperparathyroidism, and chronic kidney disease.",
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
    "interpretations" => "Rapid diagnosis of acute pancreatitis, pancreatic pseudocyst, and acute abdominal pain.",
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
    "interpretations" => "Highly sensitive and specific diagnostic test for acute pancreatitis, remains elevated up to 14 days.",
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
    "interpretations" => "Evaluation of myocardial infarction, acute muscle breakdown (rhabdomyolysis), and myopathies.",
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
    "interpretations" => "Specific marker for myocardial infarction necrosis and re-infarction.",
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
    "interpretations" => "Definitive clinical standard for the diagnosis and exclusion of Acute Myocardial Infarction (AMI).",
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
    "interpretations" => "Differential diagnosis of iron deficiency anemia vs anemia of chronic disease and hemochromatosis.",
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
    "interpretations" => "Measures circulating transferrin-bound iron.",
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
    "interpretations" => "Serodiagnosis of Enteric (Typhoid and Paratyphoid) fever.",
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
    "interpretations" => "Early detection of acute typhoid fever (IgM) and past infection or carrier status (IgG).",
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
    "interpretations" => "Rapid diagnosis and speciation of Plasmodium falciparum and Plasmodium vivax malaria.",
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
    "interpretations" => "Comprehensive malarial screening and microscopic morphological confirmation.",
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
    "interpretations" => "Early diagnosis of acute dengue fever from Day 1 to Day 5 before antibodies develop.",
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
    "interpretations" => "Diagnosis of acute late dengue (IgM) and secondary/past dengue infection (IgG).",
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
    "interpretations" => "Complete staging of dengue infection from early day 1 to convalescent phase.",
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
    "interpretations" => "Diagnosis of acute Chikungunya viral fever in patients presenting with debilitating joint pain.",
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
    "interpretations" => "Sensitive acute-phase reactant; monitors bacterial infection, inflammatory disease, and tissue damage.",
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
    "interpretations" => "Assessment of cardiovascular risk and arterial inflammation in asymptomatic individuals.",
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
    "interpretations" => "Screening test for Rheumatoid Arthritis and connective tissue autoimmune disorders.",
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
    "interpretations" => "Diagnostic confirmation of post-streptococcal sequelae (Rheumatic fever, acute glomerulonephritis).",
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
    "interpretations" => "Screening for Human Immunodeficiency Virus types 1 & 2 exposure.",
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
    "interpretations" => "Serological marker for acute or chronic Hepatitis B viral infection.",
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
    "interpretations" => "Screening test for Hepatitis C exposure and chronic hepatitis.",
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
    "interpretations" => "Serological screening for Treponema pallidum (Syphilis) infection.",
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
    "interpretations" => "Best indicator of bone marrow iron stores; also markedly elevated in hyperferritinemic inflammation.",
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
    "interpretations" => "Evaluation of atopic allergic diathesis, bronchial asthma, urticaria, and parasitic infections.",
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
    "interpretations" => "Comprehensive evaluation of thyroid gland activity (hypothyroidism, hyperthyroidism).",
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
    "interpretations" => "Most sensitive initial screening test for primary thyroid disorders and dosage monitoring of thyroxine.",
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
    "interpretations" => "Accurate assessment of thyroid status during pregnancy, critical illness, or protein-binding variations.",
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
    "interpretations" => "Specific assessment of T3 thyrotoxicosis.",
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
    "interpretations" => "Accurate physiological measure of thyroid hormone output.",
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
    "interpretations" => "Essential for bone density, calcium absorption, muscle strength, and immune competence.",
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
    "interpretations" => "Essential for erythropoiesis and neurological health; low in vegetarian diets and pernicious anemia.",
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
    "interpretations" => "Combined screening for the two most prevalent vitamin deficiencies in India.",
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
    "interpretations" => "Precise dating of early pregnancy, diagnosis of ectopic pregnancy, and threatened abortion monitoring.",
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
    "interpretations" => "Evaluation of hyperprolactinemia, galactorrhea, pituitary adenomas, and female/male infertility.",
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
    "interpretations" => "Screening for prostate carcinoma in men over 50 years, and monitoring treatment response in BPH/cancer.",
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
    "interpretations" => "Monitoring recurrence and therapeutic response in colorectal, gastrointestinal, and lung malignancies.",
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
    "interpretations" => "Definitive diagnosis of autoimmune thyroiditis (Hashimoto thyroiditis, Graves disease).",
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
    "interpretations" => "Primary screening for urinary tract infections, glomerulonephritis, proteinuria, and metabolic diseases.",
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
    "interpretations" => "Immediate qualitative confirmation of early pregnancy from first day of missed menstrual period.",
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
    "interpretations" => "Earliest clinical marker of diabetic nephropathy, hypertensive vascular disease, and kidney damage.",
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
    "interpretations" => "Emergency screening for diabetic ketoacidosis (DKA) and uncontrolled diabetes.",
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
    "interpretations" => "Diagnosis of intestinal parasitic infections, amoebiasis, giardiasis, dysentery, and malabsorption.",
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
    "interpretations" => "Screening for occult lower gastrointestinal bleeding, colon polyps, and colorectal cancer.",
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
    "interpretations" => "Essential workup for male fertility assessment, post-vasectomy verification, and testicular function.",
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
    "interpretations" => "Definitive diagnostic test for pulmonary tuberculosis (TB) as per National TB Elimination Program (NTEP).",
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
    "interpretations" => "Screening for exposure to Mycobacterium tuberculosis infection and latent TB.",
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
