-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2025 at 03:45 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `diagnostic_lab_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

CREATE TABLE `bills` (
  `bill_id` int(11) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `bill_date` date DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `paid_amount` decimal(10,2) DEFAULT NULL,
  `balance` decimal(10,2) DEFAULT NULL,
  `payment_status` enum('paid','partial','unpaid') DEFAULT 'unpaid',
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bill_packages`
--

CREATE TABLE `bill_packages` (
  `id` int(11) NOT NULL,
  `bill_id` int(11) DEFAULT NULL,
  `package_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bill_tests`
--

CREATE TABLE `bill_tests` (
  `id` int(11) NOT NULL,
  `bill_id` int(11) DEFAULT NULL,
  `test_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lab_tests`
--

CREATE TABLE `lab_tests` (
  `test_id` int(11) NOT NULL,
  `test_name` varchar(100) NOT NULL,
  `test_code` varchar(50) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lab_tests`
--

INSERT INTO `lab_tests` (`test_id`, `test_name`, `test_code`, `category_id`, `group_id`, `price`, `notes`) VALUES
(1, 'Complete Blood Count (CBC)', 'CBC', 1, 2, 300.00, 'Includes Hemoglobin, WBC, Platelets'),
(2, 'Liver Function Test (LFT)', 'LFT', 1, 1, 500.00, 'Includes Bilirubin, SGPT, SGOT'),
(3, 'Thyroid Function Test (TFT)', 'TFT', 1, 1, 600.00, 'Includes TSH, Free T4'),
(4, 'Kidney Function Test (KFT)', 'KFT', 1, 1, 450.00, 'Includes Urea, Creatinine'),
(5, 'RETEST', NULL, 1, 1, 1500.00, 'Test Sample');

-- --------------------------------------------------------

--
-- Table structure for table `lab_test_parameters`
--

CREATE TABLE `lab_test_parameters` (
  `id` int(11) NOT NULL,
  `test_id` int(11) DEFAULT NULL,
  `parameter_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `package_test_map`
--

CREATE TABLE `package_test_map` (
  `id` int(11) NOT NULL,
  `package_id` int(11) DEFAULT NULL,
  `test_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `package_test_map`
--

INSERT INTO `package_test_map` (`id`, `package_id`, `test_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `parameter_reference_ranges`
--

CREATE TABLE `parameter_reference_ranges` (
  `range_id` bigint(20) UNSIGNED NOT NULL,
  `parameter_id` int(11) NOT NULL,
  `male_min` decimal(10,2) DEFAULT NULL,
  `male_max` decimal(10,2) DEFAULT NULL,
  `male_default` decimal(10,2) DEFAULT NULL,
  `female_min` decimal(10,2) DEFAULT NULL,
  `female_max` decimal(10,2) DEFAULT NULL,
  `female_default` decimal(10,2) DEFAULT NULL,
  `child_min` decimal(10,2) DEFAULT NULL,
  `child_max` decimal(10,2) DEFAULT NULL,
  `child_default` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parameter_reference_ranges`
--

INSERT INTO `parameter_reference_ranges` (`range_id`, `parameter_id`, `male_min`, `male_max`, `male_default`, `female_min`, `female_max`, `female_default`, `child_min`, `child_max`, `child_default`) VALUES
(1, 1, 0.30, 1.20, 0.80, 0.30, 1.10, 0.80, 0.20, 1.00, 0.80),
(2, 2, 0.10, 0.30, 0.20, 0.10, 0.30, 0.20, 0.00, 0.30, 0.20),
(3, 3, 10.00, 40.00, 25.00, 7.00, 35.00, 25.00, 5.00, 25.00, 25.00),
(4, 4, 10.00, 40.00, 25.00, 9.00, 32.00, 25.00, 10.00, 30.00, 25.00),
(5, 5, 45.00, 115.00, 250.00, 30.00, 100.00, 250.00, 100.00, 400.00, 250.00),
(6, 6, 13.50, 17.50, 15.00, 12.00, 15.50, 13.50, 11.00, 14.00, 12.50),
(7, 7, 4000.00, 11000.00, 7500.00, 4000.00, 11000.00, 7500.00, 5000.00, 15000.00, 9000.00),
(8, 8, 4.70, 6.10, 5.20, 4.20, 5.40, 4.80, 3.80, 5.50, 4.50),
(9, 9, 1.50, 4.50, 3.00, 1.50, 4.50, 3.00, 1.50, 4.50, 3.00),
(10, 10, 0.70, 1.30, 1.00, 0.60, 1.10, 0.90, 0.20, 0.80, 0.50),
(11, 11, 15.00, 40.00, 25.00, 15.00, 40.00, 25.00, 5.00, 18.00, 15.00),
(12, 12, 3.40, 7.00, 5.20, 2.40, 6.00, 4.50, 2.00, 5.50, 3.50),
(13, 13, 0.40, 4.00, 2.00, 0.40, 4.00, 2.00, 0.70, 6.40, 2.50),
(14, 14, 80.00, 200.00, 120.00, 80.00, 200.00, 120.00, 90.00, 210.00, 120.00),
(15, 15, 5.00, 12.00, 8.00, 5.00, 12.00, 8.00, 6.00, 14.00, 8.00),
(16, 16, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(17, 17, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(18, 101, 0.00, 200.00, 180.00, 0.00, 200.00, 180.00, 0.00, 200.00, 170.00),
(19, 102, 40.00, 60.00, 45.00, 50.00, 70.00, 55.00, 40.00, 60.00, 50.00),
(20, 103, 0.00, 100.00, 90.00, 0.00, 100.00, 85.00, 0.00, 100.00, 80.00),
(21, 104, 0.00, 150.00, 130.00, 0.00, 150.00, 120.00, 0.00, 150.00, 110.00),
(22, 105, 70.00, 99.00, 90.00, 70.00, 99.00, 90.00, 70.00, 99.00, 85.00),
(23, 106, 0.00, 140.00, 120.00, 0.00, 140.00, 120.00, 0.00, 140.00, 110.00),
(24, 107, 4.00, 5.60, 5.20, 4.00, 5.60, 5.20, 4.00, 5.60, 5.00),
(25, 108, 135.00, 145.00, 140.00, 135.00, 145.00, 140.00, 135.00, 145.00, 138.00),
(26, 109, 3.50, 5.00, 4.20, 3.50, 5.00, 4.20, 3.50, 5.00, 4.00),
(27, 110, 98.00, 106.00, 102.00, 98.00, 106.00, 102.00, 98.00, 106.00, 100.00),
(28, 111, 8.50, 10.50, 9.50, 8.50, 10.50, 9.50, 8.50, 10.50, 9.00),
(29, 112, 1.60, 2.60, 2.00, 1.60, 2.60, 2.00, 1.60, 2.60, 1.80),
(30, 113, 2.50, 4.50, 3.50, 2.50, 4.50, 3.50, 2.50, 4.50, 3.00),
(31, 114, 11.00, 13.50, 12.50, 11.00, 13.50, 12.50, 11.00, 13.50, 12.00),
(32, 115, 25.00, 35.00, 30.00, 25.00, 35.00, 30.00, 25.00, 35.00, 28.00),
(33, 116, 0.80, 1.10, 1.00, 0.80, 1.10, 1.00, 0.80, 1.10, 1.00),
(34, 117, 0.00, 35.00, 25.00, 0.00, 35.00, 25.00, 0.00, 35.00, 20.00),
(35, 118, 0.00, 40.00, 30.00, 0.00, 40.00, 30.00, 0.00, 40.00, 25.00),
(36, 119, 0.00, 4.00, 2.50, 0.00, 4.00, 2.00, 0.00, 4.00, 1.50),
(37, 120, 0.00, 5.00, 2.50, 0.00, 5.00, 2.00, 0.00, 5.00, 2.00),
(38, 121, 0.30, 1.20, 0.80, 0.30, 1.10, 0.70, 0.20, 1.00, 0.60),
(39, 122, 0.10, 0.40, 0.30, 0.10, 0.30, 0.20, 0.05, 0.20, 0.10),
(40, 123, 0.20, 0.80, 0.50, 0.20, 0.70, 0.50, 0.15, 0.60, 0.40),
(41, 124, 8.00, 40.00, 20.00, 8.00, 35.00, 18.00, 5.00, 30.00, 15.00),
(42, 125, 7.00, 56.00, 25.00, 7.00, 45.00, 22.00, 5.00, 40.00, 20.00),
(43, 126, 40.00, 129.00, 85.00, 35.00, 104.00, 70.00, 30.00, 90.00, 60.00),
(44, 127, 9.00, 48.00, 25.00, 7.00, 45.00, 22.00, 5.00, 30.00, 15.00),
(45, 128, 6.00, 8.30, 7.20, 6.00, 8.00, 7.00, 5.50, 7.50, 6.50),
(46, 129, 3.50, 5.00, 4.20, 3.50, 5.00, 4.00, 3.00, 4.50, 3.80),
(47, 130, 2.00, 3.50, 2.50, 2.00, 3.50, 2.50, 1.50, 3.00, 2.00),
(48, 131, 1.00, 2.20, 1.40, 1.00, 2.00, 1.30, 0.80, 1.80, 1.20),
(49, 132, 4.00, 11.00, 7.00, 4.00, 10.00, 6.50, 5.00, 13.00, 8.00),
(50, 133, 4.50, 6.50, 5.50, 4.00, 5.50, 5.00, 3.80, 5.20, 4.50),
(51, 134, 13.00, 17.00, 15.00, 12.00, 15.00, 13.50, 11.00, 14.00, 12.50),
(52, 135, 38.00, 50.00, 45.00, 36.00, 44.00, 40.00, 32.00, 42.00, 38.00),
(53, 136, 80.00, 100.00, 90.00, 78.00, 98.00, 88.00, 76.00, 96.00, 86.00),
(54, 137, 27.00, 32.00, 30.00, 26.00, 31.00, 29.00, 24.00, 30.00, 28.00),
(55, 138, 32.00, 36.00, 34.00, 31.00, 35.00, 33.00, 30.00, 34.00, 32.00),
(56, 139, 150.00, 400.00, 250.00, 150.00, 400.00, 250.00, 150.00, 400.00, 250.00),
(57, 140, 11.50, 14.50, 13.00, 11.50, 14.00, 13.00, 11.00, 14.00, 12.00),
(58, 141, 10.00, 50.00, 30.00, 10.00, 45.00, 28.00, 8.00, 40.00, 25.00),
(59, 142, 0.70, 1.30, 1.00, 0.60, 1.10, 0.90, 0.50, 1.00, 0.80),
(60, 143, 3.40, 7.00, 5.50, 2.40, 6.00, 4.50, 2.00, 5.50, 4.00),
(61, 144, 7.00, 20.00, 15.00, 7.00, 18.00, 14.00, 6.00, 16.00, 12.00),
(62, 145, 8.80, 10.60, 9.50, 8.50, 10.20, 9.00, 8.00, 10.00, 9.00),
(63, 146, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(64, 1, 10.00, 50.00, 30.00, 10.00, 45.00, 28.00, 8.00, 40.00, 25.00),
(65, 2, 0.70, 1.30, 1.00, 0.60, 1.10, 0.90, 0.50, 1.00, 0.80),
(66, 3, 3.40, 7.00, 5.50, 2.40, 6.00, 4.50, 2.00, 5.50, 4.00),
(67, 4, 7.00, 20.00, 15.00, 7.00, 18.00, 14.00, 6.00, 16.00, 12.00),
(68, 5, 8.80, 10.60, 9.50, 8.50, 10.20, 9.00, 8.00, 10.00, 9.00);

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `patient_id` int(11) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `gender` enum('male','female','other') DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`patient_id`, `full_name`, `gender`, `date_of_birth`, `phone`, `email`, `address`, `created_at`) VALUES
(1, 'Ravi Kumar', 'male', '1985-07-10', '9876543210', 'ravi@example.com', 'Vizag', '2025-05-14 07:34:17'),
(2, 'Sita Devi', 'female', '1992-03-22', '9876500001', 'sita@example.com', 'Vizag', '2025-05-14 07:34:17'),
(3, 'Kiran Reddy', 'male', '2005-09-15', '9876567890', 'kiran@example.com', 'Vizag', '2025-05-14 07:34:17');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`) VALUES
(1, 'admin'),
(2, 'user');

-- --------------------------------------------------------

--
-- Table structure for table `test_categories`
--

CREATE TABLE `test_categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `test_categories`
--

INSERT INTO `test_categories` (`category_id`, `category_name`) VALUES
(1, 'Laboratory'),
(2, 'Radiology');

-- --------------------------------------------------------

--
-- Table structure for table `test_groups`
--

CREATE TABLE `test_groups` (
  `group_id` int(11) NOT NULL,
  `group_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `test_groups`
--

INSERT INTO `test_groups` (`group_id`, `group_name`) VALUES
(1, 'Biochemistry'),
(2, 'Hematology'),
(3, 'Serology'),
(4, 'Microbiology'),
(5, 'Immunology'),
(6, 'Clinical Pathology');

-- --------------------------------------------------------

--
-- Table structure for table `test_packages`
--

CREATE TABLE `test_packages` (
  `package_id` int(11) NOT NULL,
  `package_name` varchar(100) DEFAULT NULL,
  `package_code` varchar(50) DEFAULT NULL,
  `package_price` decimal(10,2) DEFAULT NULL,
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `test_packages`
--

INSERT INTO `test_packages` (`package_id`, `package_name`, `package_code`, `package_price`, `notes`) VALUES
(1, 'Best Combo Test', 'BESTCOMBO', 1200.00, 'Includes CBC + LFT + KFT');

-- --------------------------------------------------------

--
-- Table structure for table `test_parameters`
--

CREATE TABLE `test_parameters` (
  `parameter_id` int(11) NOT NULL,
  `param_name` varchar(100) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `unit` varchar(20) DEFAULT NULL,
  `method` varchar(100) DEFAULT NULL,
  `interpretation` text DEFAULT NULL,
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `test_parameters`
--

INSERT INTO `test_parameters` (`parameter_id`, `param_name`, `category_id`, `group_id`, `unit`, `method`, `interpretation`, `notes`) VALUES
(11, 'Total Bilirubin', 1, 1, 'mg/dL', 'Diazo Method', 'Elevated in liver dysfunction or hemolysis', 'Fasting preferred'),
(12, 'Direct Bilirubin', 1, 1, 'mg/dL', 'Diazo Method', 'Direct ↑ = obstructive jaundice', ''),
(13, 'SGPT (ALT)', 1, 1, 'U/L', 'UV Kinetic', 'High in liver injury/hepatitis', 'Avoid exercise before test'),
(14, 'SGOT (AST)', 1, 1, 'U/L', 'UV Kinetic', '↑ in liver, cardiac, and muscle disorders', 'AST > ALT = cardiac source'),
(15, 'Alkaline Phosphatase', 1, 1, 'U/L', 'PNPP Method', '↑ in bone and liver diseases', 'High in children (bone growth)'),
(16, 'Hemoglobin', 1, 2, 'g/dL', 'Cyanmethemoglobin Method', 'Low in anemia, high in polycythemia', ''),
(17, 'Total WBC', 1, 2, '/cu mm', 'Automated Cell Counter', 'Increased in infections/inflammation', ''),
(18, 'RBC Count', 1, 2, 'million/cu mm', 'Automated Cell Counter', 'Low in anemia', ''),
(19, 'Platelet Count', 1, 2, 'lakh/cu mm', 'Automated Cell Counter', 'Low in dengue, high in infections', ''),
(20, 'Serum Creatinine', 1, 1, 'mg/dL', 'Jaffe’s method', '↑ in kidney dysfunction', ''),
(21, 'Blood Urea', 1, 1, 'mg/dL', 'Urease method', '↑ in renal issues, ↓ in liver failure', ''),
(22, 'Uric Acid', 1, 1, 'mg/dL', 'Uricase method', '↑ in gout', ''),
(23, 'TSH', 1, 1, 'µIU/mL', 'CLIA', '↑ in hypothyroid, ↓ in hyperthyroid', ''),
(24, 'T3', 1, 1, 'ng/dL', 'CLIA', '↑ in hyperthyroidism', ''),
(25, 'T4', 1, 1, 'µg/dL', 'CLIA', '↑ in hyperthyroidism', ''),
(26, 'HIV I/II', 1, 3, '', 'ELISA/CLIA', 'Positive indicates HIV infection', 'Confirm with Western Blot'),
(27, 'HBsAg', 1, 3, '', 'ELISA', 'Positive indicates Hepatitis B infection', 'Confirmatory test recommended'),
(101, 'Total Cholesterol', 1, 1, 'mg/dL', 'Enzymatic', 'Helps assess risk of cardiovascular disease.', ''),
(102, 'HDL Cholesterol', 1, 1, 'mg/dL', 'Enzymatic', 'Good cholesterol, protects against heart disease.', ''),
(103, 'LDL Cholesterol', 1, 1, 'mg/dL', 'Friedewald Formula', 'Bad cholesterol, high levels increase heart risk.', ''),
(104, 'Triglycerides', 1, 1, 'mg/dL', 'Enzymatic', 'Elevated levels increase risk of heart disease.', ''),
(105, 'Fasting Blood Glucose', 1, 1, 'mg/dL', 'Glucose Oxidase', 'Indicates fasting glucose level.', ''),
(106, 'Postprandial Blood Glucose', 1, 1, 'mg/dL', 'Glucose Oxidase', 'Measured 2 hours after a meal.', ''),
(107, 'HbA1c', 1, 1, '%', 'HPLC', 'Reflects average blood sugar over past 3 months.', ''),
(108, 'Sodium', 1, 1, 'mEq/L', 'Ion-selective electrode', 'Important for fluid balance.', ''),
(109, 'Potassium', 1, 1, 'mEq/L', 'Ion-selective electrode', 'Helps regulate heartbeat.', ''),
(110, 'Chloride', 1, 1, 'mEq/L', 'Ion-selective electrode', 'Maintains acid-base balance.', ''),
(111, 'Calcium', 1, 1, 'mg/dL', 'Colorimetric', 'Vital for bones and muscle function.', ''),
(112, 'Magnesium', 1, 1, 'mg/dL', 'Colorimetric', 'Important for enzyme function.', ''),
(113, 'Phosphate', 1, 1, 'mg/dL', 'Colorimetric', 'Involved in bone formation and energy storage.', ''),
(114, 'Prothrombin Time', 1, 2, 'seconds', 'Clot-based', 'Measures extrinsic pathway of coagulation.', ''),
(115, 'aPTT', 1, 2, 'seconds', 'Clot-based', 'Measures intrinsic pathway of coagulation.', ''),
(116, 'INR', 1, 2, '', 'Calculated', 'Standardized PT result.', ''),
(117, 'Anti-TPO Antibodies', 1, 5, 'IU/mL', 'Immunoassay', 'Marker for autoimmune thyroid diseases.', ''),
(118, 'Anti-Thyroglobulin Antibodies', 1, 5, 'IU/mL', 'Immunoassay', 'Used in thyroid disease diagnosis.', ''),
(119, 'PSA', 1, 3, 'ng/mL', 'Immunoassay', 'Used in prostate cancer screening.', ''),
(120, 'CEA', 1, 3, 'ng/mL', 'Immunoassay', 'Elevated in some cancers.', ''),
(121, 'Total Cholesterol', 1, 1, 'mg/dL', 'Enzymatic', 'Assesses cardiovascular risk.', ''),
(122, 'HDL Cholesterol', 1, 1, 'mg/dL', 'Enzymatic', 'Good cholesterol, cardioprotective.', ''),
(123, 'LDL Cholesterol', 1, 1, 'mg/dL', 'Friedewald Formula', 'Bad cholesterol, contributes to atherosclerosis.', ''),
(124, 'Triglycerides', 1, 1, 'mg/dL', 'Enzymatic', 'Elevated levels linked to heart disease.', ''),
(125, 'Fasting Blood Glucose', 1, 1, 'mg/dL', 'Glucose Oxidase', 'Detects diabetes or hypoglycemia.', ''),
(126, 'Postprandial Blood Glucose', 1, 1, 'mg/dL', 'Glucose Oxidase', 'Checks blood sugar post-meal.', ''),
(127, 'HbA1c', 1, 1, '%', 'HPLC', 'Average blood sugar over 3 months.', ''),
(128, 'Sodium', 1, 1, 'mEq/L', 'Ion-selective electrode', 'Indicates fluid balance and nerve function.', ''),
(129, 'Potassium', 1, 1, 'mEq/L', 'Ion-selective electrode', 'Essential for heart and muscle function.', ''),
(130, 'Chloride', 1, 1, 'mEq/L', 'Ion-selective electrode', 'Maintains acid-base balance.', ''),
(131, 'Calcium', 1, 1, 'mg/dL', 'Colorimetric', 'Important for bones, muscle, nerves.', ''),
(132, 'Magnesium', 1, 1, 'mg/dL', 'Colorimetric', 'Supports enzyme activity and heart rhythm.', ''),
(133, 'Phosphate', 1, 1, 'mg/dL', 'Colorimetric', 'Helps bone strength and energy metabolism.', ''),
(134, 'Prothrombin Time', 1, 2, 'seconds', 'Clot-based', 'Evaluates clotting via extrinsic pathway.', ''),
(135, 'aPTT', 1, 2, 'seconds', 'Clot-based', 'Checks clotting via intrinsic pathway.', ''),
(136, 'INR', 1, 2, '', 'Calculated', 'Standardized PT result for anticoagulant therapy.', ''),
(137, 'Anti-TPO Antibodies', 1, 5, 'IU/mL', 'Immunoassay', 'Autoimmune marker for thyroid disease.', ''),
(138, 'Anti-Thyroglobulin Antibodies', 1, 5, 'IU/mL', 'Immunoassay', 'Useful in thyroid cancer follow-up.', ''),
(139, 'PSA', 1, 3, 'ng/mL', 'Immunoassay', 'Prostate cancer screening.', ''),
(140, 'CEA', 1, 3, 'ng/mL', 'Immunoassay', 'Tumor marker for various cancers.', ''),
(141, 'Total Bilirubin', 1, 1, 'mg/dL', 'Diazo method', 'Assesses liver and bile function.', ''),
(142, 'Direct Bilirubin', 1, 1, 'mg/dL', 'Diazo method', 'Measures conjugated bilirubin.', ''),
(143, 'Indirect Bilirubin', 1, 1, 'mg/dL', 'Calculated', 'Measures unconjugated bilirubin.', ''),
(144, 'AST(SGOT)', 1, 1, 'U/L', 'UV kinetic', 'Marker for liver and cardiac damage.', ''),
(145, 'ALT(SGPT)', 1, 1, 'U/L', 'UV kinetic', 'Sensitive liver damage indicator.', ''),
(146, 'Alkaline Phosphatase', 1, 1, 'U/L', 'Colorimetric', 'Bone/liver disorder marker.', ''),
(147, 'GGT', 1, 1, 'U/L', 'Enzymatic', 'Liver enzyme, alcohol-related.', ''),
(148, 'Total Protein', 1, 1, 'g/dL', 'Biuret method', 'Total serum proteins.', ''),
(149, 'Albumin', 1, 1, 'g/dL', 'BCG method', 'Major serum protein.', ''),
(150, 'Globulin', 1, 1, 'g/dL', 'Calculated', 'Total protein - albumin.', ''),
(151, 'A/G Ratio', 1, 1, '', 'Calculated', 'Albumin to Globulin ratio.', ''),
(152, 'WBC Count', 1, 2, '10^3/uL', 'Impedance', 'Infection or immunity marker.', ''),
(153, 'RBC Count', 1, 2, '10^6/uL', 'Impedance', 'Oxygen transport cells.', ''),
(154, 'Hemoglobin', 1, 2, 'g/dL', 'Cyanmethemoglobin', 'Carries oxygen in blood.', ''),
(155, 'Hematocrit', 1, 2, '%', 'Calculated', 'Volume % of RBCs.', ''),
(156, 'MCV', 1, 2, 'fL', 'Calculated', 'Mean corpuscular volume.', ''),
(157, 'MCH', 1, 2, 'pg', 'Calculated', 'Mean corpuscular hemoglobin.', ''),
(158, 'MCHC', 1, 2, 'g/dL', 'Calculated', 'Concentration in RBCs.', ''),
(159, 'Platelet Count', 1, 2, '10^3/uL', 'Impedance', 'Helps in clotting.', ''),
(160, 'RDW', 1, 2, '%', 'Calculated', 'Variation in RBC size.', ''),
(161, 'Urea', 1, 1, 'mg/dL', 'Enzymatic', 'Renal function test.', ''),
(162, 'Creatinine', 1, 1, 'mg/dL', 'Jaffe method', 'Glomerular filtration indicator.', ''),
(163, 'Uric Acid', 1, 1, 'mg/dL', 'Uricase method', 'Purine metabolism marker.', ''),
(164, 'BUN', 1, 1, 'mg/dL', 'Calculated', 'Blood urea nitrogen.', ''),
(165, 'Calcium (KFT)', 1, 1, 'mg/dL', 'Colorimetric', 'Also used in KFT.', ''),
(166, 'Chest X-Ray', 2, 6, '', 'Imaging', 'Radiographic chest view.', 'No ionizing contrast used.'),
(167, 'Urea', 1, 1, 'mg/dL', 'Enzymatic', 'Indicator of kidney function and protein metabolism.', ''),
(168, 'Creatinine', 1, 1, 'mg/dL', 'Jaffe method', 'Assesses kidney filtration efficiency.', ''),
(169, 'Uric Acid', 1, 1, 'mg/dL', 'Uricase method', 'High levels may indicate gout or kidney disease.', ''),
(170, 'BUN', 1, 1, 'mg/dL', 'Calculated', 'Blood Urea Nitrogen; evaluates renal function.', ''),
(171, 'Calcium', 1, 1, 'mg/dL', 'Colorimetric', 'Important mineral; also involved in kidney health.', '');

-- --------------------------------------------------------

--
-- Table structure for table `test_parameter_map`
--

CREATE TABLE `test_parameter_map` (
  `id` int(11) NOT NULL,
  `test_id` int(11) DEFAULT NULL,
  `parameter_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `test_results`
--

CREATE TABLE `test_results` (
  `result_id` int(11) NOT NULL,
  `sample_id` int(11) DEFAULT NULL,
  `parameter_id` int(11) DEFAULT NULL,
  `result_value` varchar(100) DEFAULT NULL,
  `result_date` datetime DEFAULT NULL,
  `tested_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `test_samples`
--

CREATE TABLE `test_samples` (
  `sample_id` int(11) NOT NULL,
  `bill_id` int(11) DEFAULT NULL,
  `sample_date` datetime DEFAULT NULL,
  `collected_by` int(11) DEFAULT NULL,
  `status` enum('pending','collected','processing','completed') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password_hash`, `full_name`, `role_id`, `status`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500', 'Admin User', 1, 'active'),
(2, 'user1', '6ad14ba9986e3615423dfca256d04e3f', 'Lab Staff 1', 2, 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bills`
--
ALTER TABLE `bills`
  ADD PRIMARY KEY (`bill_id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `bill_packages`
--
ALTER TABLE `bill_packages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bill_id` (`bill_id`),
  ADD KEY `package_id` (`package_id`);

--
-- Indexes for table `bill_tests`
--
ALTER TABLE `bill_tests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bill_id` (`bill_id`),
  ADD KEY `test_id` (`test_id`);

--
-- Indexes for table `lab_tests`
--
ALTER TABLE `lab_tests`
  ADD PRIMARY KEY (`test_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `group_id` (`group_id`);

--
-- Indexes for table `lab_test_parameters`
--
ALTER TABLE `lab_test_parameters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `test_id` (`test_id`),
  ADD KEY `parameter_id` (`parameter_id`);

--
-- Indexes for table `package_test_map`
--
ALTER TABLE `package_test_map`
  ADD PRIMARY KEY (`id`),
  ADD KEY `package_id` (`package_id`),
  ADD KEY `test_id` (`test_id`);

--
-- Indexes for table `parameter_reference_ranges`
--
ALTER TABLE `parameter_reference_ranges`
  ADD PRIMARY KEY (`range_id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`patient_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `test_categories`
--
ALTER TABLE `test_categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `test_groups`
--
ALTER TABLE `test_groups`
  ADD PRIMARY KEY (`group_id`);

--
-- Indexes for table `test_packages`
--
ALTER TABLE `test_packages`
  ADD PRIMARY KEY (`package_id`);

--
-- Indexes for table `test_parameters`
--
ALTER TABLE `test_parameters`
  ADD PRIMARY KEY (`parameter_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `group_id` (`group_id`);

--
-- Indexes for table `test_parameter_map`
--
ALTER TABLE `test_parameter_map`
  ADD PRIMARY KEY (`id`),
  ADD KEY `test_id` (`test_id`),
  ADD KEY `parameter_id` (`parameter_id`);

--
-- Indexes for table `test_results`
--
ALTER TABLE `test_results`
  ADD PRIMARY KEY (`result_id`),
  ADD KEY `sample_id` (`sample_id`),
  ADD KEY `parameter_id` (`parameter_id`),
  ADD KEY `tested_by` (`tested_by`);

--
-- Indexes for table `test_samples`
--
ALTER TABLE `test_samples`
  ADD PRIMARY KEY (`sample_id`),
  ADD KEY `bill_id` (`bill_id`),
  ADD KEY `collected_by` (`collected_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bills`
--
ALTER TABLE `bills`
  MODIFY `bill_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bill_packages`
--
ALTER TABLE `bill_packages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bill_tests`
--
ALTER TABLE `bill_tests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lab_tests`
--
ALTER TABLE `lab_tests`
  MODIFY `test_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `lab_test_parameters`
--
ALTER TABLE `lab_test_parameters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `package_test_map`
--
ALTER TABLE `package_test_map`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `parameter_reference_ranges`
--
ALTER TABLE `parameter_reference_ranges`
  MODIFY `range_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `patient_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `test_categories`
--
ALTER TABLE `test_categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `test_groups`
--
ALTER TABLE `test_groups`
  MODIFY `group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `test_packages`
--
ALTER TABLE `test_packages`
  MODIFY `package_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `test_parameters`
--
ALTER TABLE `test_parameters`
  MODIFY `parameter_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=172;

--
-- AUTO_INCREMENT for table `test_parameter_map`
--
ALTER TABLE `test_parameter_map`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `test_results`
--
ALTER TABLE `test_results`
  MODIFY `result_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `test_samples`
--
ALTER TABLE `test_samples`
  MODIFY `sample_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bills`
--
ALTER TABLE `bills`
  ADD CONSTRAINT `bills_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`),
  ADD CONSTRAINT `bills_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `bill_packages`
--
ALTER TABLE `bill_packages`
  ADD CONSTRAINT `bill_packages_ibfk_1` FOREIGN KEY (`bill_id`) REFERENCES `bills` (`bill_id`),
  ADD CONSTRAINT `bill_packages_ibfk_2` FOREIGN KEY (`package_id`) REFERENCES `test_packages` (`package_id`);

--
-- Constraints for table `bill_tests`
--
ALTER TABLE `bill_tests`
  ADD CONSTRAINT `bill_tests_ibfk_1` FOREIGN KEY (`bill_id`) REFERENCES `bills` (`bill_id`),
  ADD CONSTRAINT `bill_tests_ibfk_2` FOREIGN KEY (`test_id`) REFERENCES `lab_tests` (`test_id`);

--
-- Constraints for table `lab_tests`
--
ALTER TABLE `lab_tests`
  ADD CONSTRAINT `lab_tests_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `test_categories` (`category_id`),
  ADD CONSTRAINT `lab_tests_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `test_groups` (`group_id`);

--
-- Constraints for table `lab_test_parameters`
--
ALTER TABLE `lab_test_parameters`
  ADD CONSTRAINT `lab_test_parameters_ibfk_1` FOREIGN KEY (`test_id`) REFERENCES `lab_tests` (`test_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lab_test_parameters_ibfk_2` FOREIGN KEY (`parameter_id`) REFERENCES `test_parameters` (`parameter_id`) ON DELETE CASCADE;

--
-- Constraints for table `package_test_map`
--
ALTER TABLE `package_test_map`
  ADD CONSTRAINT `package_test_map_ibfk_1` FOREIGN KEY (`package_id`) REFERENCES `test_packages` (`package_id`),
  ADD CONSTRAINT `package_test_map_ibfk_2` FOREIGN KEY (`test_id`) REFERENCES `lab_tests` (`test_id`);

--
-- Constraints for table `test_parameters`
--
ALTER TABLE `test_parameters`
  ADD CONSTRAINT `test_parameters_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `test_categories` (`category_id`),
  ADD CONSTRAINT `test_parameters_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `test_groups` (`group_id`);

--
-- Constraints for table `test_parameter_map`
--
ALTER TABLE `test_parameter_map`
  ADD CONSTRAINT `test_parameter_map_ibfk_1` FOREIGN KEY (`test_id`) REFERENCES `lab_tests` (`test_id`),
  ADD CONSTRAINT `test_parameter_map_ibfk_2` FOREIGN KEY (`parameter_id`) REFERENCES `test_parameters` (`parameter_id`);

--
-- Constraints for table `test_results`
--
ALTER TABLE `test_results`
  ADD CONSTRAINT `test_results_ibfk_1` FOREIGN KEY (`sample_id`) REFERENCES `test_samples` (`sample_id`),
  ADD CONSTRAINT `test_results_ibfk_2` FOREIGN KEY (`parameter_id`) REFERENCES `test_parameters` (`parameter_id`),
  ADD CONSTRAINT `test_results_ibfk_3` FOREIGN KEY (`tested_by`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `test_samples`
--
ALTER TABLE `test_samples`
  ADD CONSTRAINT `test_samples_ibfk_1` FOREIGN KEY (`bill_id`) REFERENCES `bills` (`bill_id`),
  ADD CONSTRAINT `test_samples_ibfk_2` FOREIGN KEY (`collected_by`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
