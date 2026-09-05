-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 24, 2025 at 01:38 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
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
  `created_by` int(11) DEFAULT NULL,
  `sample_collected` tinyint(1) DEFAULT '0',
  `result_entered` tinyint(1) DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bills`
--

INSERT INTO `bills` (`bill_id`, `patient_id`, `bill_date`, `total_amount`, `paid_amount`, `balance`, `payment_status`, `created_by`, `sample_collected`, `result_entered`, `created_at`) VALUES
(5, 2, '2025-05-21', '450.00', '500.00', '-50.00', 'paid', 1, 1, 1, '2025-05-27 13:47:43'),
(6, 3, '2025-05-21', '1299.00', '0.00', '1299.00', 'paid', 1, 0, 0, '2025-05-27 13:47:43'),
(7, 4, '2025-05-21', '400.00', '0.00', '400.00', 'paid', 1, 0, 0, '2025-05-27 13:47:43'),
(8, 2, '2025-05-21', '1000.00', '0.00', '1000.00', 'paid', 1, 0, 0, '2025-05-27 13:47:43'),
(9, 6, '2025-05-21', '600.00', '0.00', '600.00', 'paid', 1, 0, 0, '2025-05-27 13:47:43'),
(10, 8, '2025-06-07', '350.00', '0.00', '350.00', 'paid', 1, 0, 0, '2025-05-27 13:47:43'),
(11, 10, '2025-05-21', '1300.00', '0.00', '1300.00', 'paid', 1, 0, 0, '2025-05-27 13:47:43'),
(12, 10, '2025-05-27', '350.00', '0.00', '350.00', 'paid', 1, 0, 0, '2025-05-27 16:23:49'),
(13, 6, '2025-05-27', '350.00', '0.00', '350.00', 'paid', 1, 0, 0, '2025-05-27 16:27:08'),
(14, 3, '2025-05-29', '350.00', '0.00', '350.00', 'paid', 1, 0, 0, '2025-05-29 10:54:12'),
(15, 9, '2025-05-30', '350.00', '0.00', '350.00', 'paid', 1, 0, 0, '2025-05-30 15:35:59'),
(16, 3, '2025-06-03', '350.00', '0.00', '350.00', 'paid', 1, 0, 0, '2025-06-03 23:38:19'),
(17, 6, '2025-06-06', '350.00', '250.00', '100.00', 'paid', 1, 1, 1, '2025-06-06 07:42:39'),
(18, 4, '2025-06-07', '500.00', '0.00', '500.00', 'paid', 1, 0, 0, '2025-06-07 16:21:15'),
(19, 2, '2025-06-08', '250.00', '0.00', '250.00', 'paid', 1, 0, 0, '2025-06-08 16:13:14'),
(20, 7, '2025-06-20', '1000.00', '0.00', '1000.00', 'paid', 1, 0, 0, '2025-06-20 13:12:34'),
(21, 6, '2025-06-22', '1000.00', '0.00', '1000.00', 'paid', 1, 0, 0, '2025-06-22 21:51:47');

-- --------------------------------------------------------

--
-- Table structure for table `bill_packages`
--

CREATE TABLE `bill_packages` (
  `id` int(11) NOT NULL,
  `bill_id` int(11) DEFAULT NULL,
  `package_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bill_packages`
--

INSERT INTO `bill_packages` (`id`, `bill_id`, `package_id`) VALUES
(2, 5, 3),
(10, 6, 5),
(14, 8, 5),
(19, 11, 8),
(20, 20, 9),
(21, 21, 9);

-- --------------------------------------------------------

--
-- Table structure for table `bill_tests`
--

CREATE TABLE `bill_tests` (
  `id` int(11) NOT NULL,
  `bill_id` int(11) DEFAULT NULL,
  `test_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bill_tests`
--

INSERT INTO `bill_tests` (`id`, `bill_id`, `test_id`) VALUES
(17, 6, 7),
(18, 6, 12),
(20, 8, 14),
(21, 9, 3),
(25, 11, 14),
(26, 11, 5),
(27, 12, 1),
(28, 13, 1),
(29, 14, 1),
(30, 15, 1),
(31, 16, 1),
(32, 17, 1),
(33, 10, 1),
(34, 18, 4),
(35, 19, 29);

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
  `notes` text,
  `interpretations` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lab_tests`
--

INSERT INTO `lab_tests` (`test_id`, `test_name`, `test_code`, `category_id`, `group_id`, `price`, `notes`, `interpretations`) VALUES
(1, 'Complete Blood Count', 'CBC', 1, 2, '350.00', '<p>Includes all major blood cell parameters</p>', ''),
(2, 'Kidney Function Test', 'KFT', 1, 1, '400.00', 'Includes Urea, Creatinine, Uric Acid, BUN, Calcium', NULL),
(3, 'Liver Function Test', 'LFT', 1, 1, '450.00', 'Includes Bilirubin, SGOT, SGPT, ALP, Protein, Albumin', NULL),
(4, 'Lipid Profile', 'LIPID', 1, 1, '500.00', 'Cholesterol, HDL, LDL, Triglycerides', NULL),
(5, 'Thyroid Profile', 'TFT', 1, 1, '400.00', 'TSH, T3, T4', NULL),
(6, 'Blood Sugar Profile', 'BS', 1, 1, '250.00', 'FBS, PPBS, HbA1c', NULL),
(7, 'Hemoglobin', 'HB', 1, 2, '100.00', 'Hemoglobin level', NULL),
(8, 'HIV Test', 'HIV', 1, 3, '300.00', 'Screening for HIV', NULL),
(9, 'HBsAg Test', 'HBsAg', 1, 3, '300.00', 'Hepatitis B surface antigen', NULL),
(10, 'Coagulation Profile', 'COAG', 1, 2, '350.00', 'PT, aPTT, INR', NULL),
(11, 'Electrolytes Panel', 'ELEC', 1, 1, '250.00', 'Sodium, Potassium, Chloride', NULL),
(12, 'Calcium and Phosphate', 'CALPHOS', 1, 1, '200.00', 'Calcium, Magnesium, Phosphate', NULL),
(13, 'Tumor Markers', 'TUMOR', 1, 3, '600.00', 'Includes PSA, CEA', NULL),
(14, 'Thyroid Antibodies', 'THYAB', 1, 5, '600.00', 'Anti-TPO, Anti-Thyroglobulin', NULL),
(23, 'Vitamin Panel', 'VITPKG', 1, 1, '800.00', 'Vitamin D and B12 levels', NULL),
(24, 'Urine Analysis', 'URINE', 1, 6, '200.00', 'Routine urine analysis', NULL),
(25, 'COVID-19 Panel', 'COVIDPKG', 1, 3, '1200.00', 'Includes RT-PCR, CBC, CRP, D-Dimer', NULL),
(26, 'Urine Routine', 'URINE', 1, 6, '150.00', 'Routine urine examination', NULL),
(27, 'Blood Grouping', 'BLOODGRP', 1, 2, '100.00', 'Blood group and Rh typing', NULL),
(28, 'VDRL Test', 'VDRL', 1, 3, '200.00', 'Syphilis screening test', NULL),
(29, 'Malaria Test', 'MALARIA', 1, 3, '250.00', '', '<figure class=\"table\"><table><tbody><tr><td><strong>Malaria Parasite Test Result</strong></td><td><strong>Interpretation</strong></td></tr><tr><td>Not seen&nbsp;</td><td>No malaria parasites were detected</td></tr><tr><td>Schizonts of P. Vivax seen</td><td>P. vivax parasite detected in the blood</td></tr><tr><td>Trophozoites of P. Vivax</td><td>Active infection with P. Vivax detected</td></tr><tr><td>Trophozoites of P. Falciparum</td><td>Active infection with P. Falciparum detected</td></tr><tr><td>Gametocytes of P. Falciparum</td><td><p>Active infection with P. Falciparum detected and an increased risk of transmission to others</p></td></tr></tbody></table></figure>'),
(30, 'ECG', 'ECG', 2, 6, '300.00', 'Electrocardiogram - heart rhythm test', NULL),
(31, 'DC (Differential Counts)', 'DC', 1, 2, '0.00', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `lab_test_parameters`
--

CREATE TABLE `lab_test_parameters` (
  `id` int(11) NOT NULL,
  `test_id` int(11) DEFAULT NULL,
  `parameter_id` int(11) DEFAULT NULL,
  `param_order` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lab_test_parameters`
--

INSERT INTO `lab_test_parameters` (`id`, `test_id`, `parameter_id`, `param_order`) VALUES
(10, 2, 161, 0),
(11, 2, 162, 0),
(12, 2, 163, 0),
(13, 2, 164, 0),
(14, 2, 165, 0),
(15, 3, 11, 0),
(16, 3, 12, 0),
(17, 3, 13, 0),
(18, 3, 14, 0),
(19, 3, 15, 0),
(20, 3, 147, 0),
(21, 3, 148, 0),
(22, 3, 149, 0),
(23, 3, 150, 0),
(24, 3, 151, 0),
(25, 4, 101, 0),
(26, 4, 102, 0),
(27, 4, 103, 0),
(28, 4, 104, 0),
(29, 5, 23, 0),
(30, 5, 24, 0),
(31, 5, 25, 0),
(32, 6, 105, 0),
(33, 6, 106, 0),
(34, 6, 107, 0),
(35, 7, 154, 0),
(36, 8, 26, 0),
(37, 9, 27, 0),
(38, 10, 114, 0),
(39, 10, 115, 0),
(40, 10, 116, 0),
(41, 11, 108, 0),
(42, 11, 109, 0),
(43, 11, 110, 0),
(44, 12, 111, 0),
(45, 12, 112, 0),
(46, 12, 113, 0),
(47, 13, 119, 0),
(48, 13, 120, 0),
(49, 14, 117, 0),
(50, 14, 118, 0),
(240, 29, 172, 0),
(253, 1, 154, 3),
(254, 1, 157, 6),
(255, 1, 158, 7),
(256, 1, 156, 5),
(257, 1, 19, 8),
(258, 1, 178, 4),
(259, 1, 177, 2),
(260, 1, 17, 1),
(261, 31, 175, 3),
(262, 31, 174, 2),
(263, 31, 176, 4),
(264, 31, 173, 1);

-- --------------------------------------------------------

--
-- Table structure for table `package_template`
--

CREATE TABLE `package_template` (
  `test_id` int(11) NOT NULL,
  `header_html` text,
  `interpretation` text,
  `notes` text,
  `table_format` varchar(50) DEFAULT NULL,
  `group_by` tinyint(1) DEFAULT NULL,
  `show_method` tinyint(1) DEFAULT NULL,
  `show_interpretation` tinyint(1) DEFAULT NULL,
  `show_notes` tinyint(1) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `package_templates`
--

CREATE TABLE `package_templates` (
  `template_id` int(11) NOT NULL,
  `test_id` int(11) DEFAULT NULL,
  `template_name` varchar(100) DEFAULT NULL,
  `header_html` text,
  `interpretation` text,
  `notes` text,
  `table_format` varchar(50) DEFAULT NULL,
  `group_by` tinyint(1) DEFAULT NULL,
  `show_method` tinyint(1) DEFAULT NULL,
  `show_interpretation` tinyint(1) DEFAULT NULL,
  `show_notes` tinyint(1) DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT '0',
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `package_tests`
--

CREATE TABLE `package_tests` (
  `id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `test_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `package_test_map`
--

CREATE TABLE `package_test_map` (
  `id` int(11) NOT NULL,
  `package_id` int(11) DEFAULT NULL,
  `test_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `package_test_map`
--

INSERT INTO `package_test_map` (`id`, `package_id`, `test_id`) VALUES
(6, 2, 1),
(7, 2, 2),
(8, 2, 3),
(9, 2, 4),
(10, 2, 5),
(11, 2, 6),
(12, 2, 11),
(13, 3, 1),
(14, 3, 3),
(15, 4, 6),
(16, 4, 4),
(17, 4, 2),
(18, 5, 4),
(19, 5, 6),
(20, 6, 3),
(21, 6, 1),
(22, 6, 9),
(23, 7, 2),
(24, 7, 11),
(25, 8, 1),
(26, 8, 8),
(27, 8, 9),
(28, 8, 6),
(29, 8, 5),
(30, 3, 29),
(31, 5, 30),
(32, 8, 26),
(33, 8, 27),
(34, 8, 28),
(52, 1, 1),
(53, 1, 2),
(54, 1, 3),
(55, 1, 4),
(56, 1, 6),
(57, 9, 1),
(58, 9, 31);

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
  `child_default` decimal(10,2) DEFAULT NULL,
  `reference_text` text,
  `use_reference_text` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `parameter_reference_ranges`
--

INSERT INTO `parameter_reference_ranges` (`range_id`, `parameter_id`, `male_min`, `male_max`, `male_default`, `female_min`, `female_max`, `female_default`, `child_min`, `child_max`, `child_default`, `reference_text`, `use_reference_text`) VALUES
(1, 1, '0.30', '1.20', '0.80', '0.30', '1.10', '0.80', '0.20', '1.00', '0.80', NULL, 0),
(2, 2, '0.10', '0.30', '0.20', '0.10', '0.30', '0.20', '0.00', '0.30', '0.20', NULL, 0),
(3, 3, '10.00', '40.00', '25.00', '7.00', '35.00', '25.00', '5.00', '25.00', '25.00', NULL, 0),
(4, 4, '10.00', '40.00', '25.00', '9.00', '32.00', '25.00', '10.00', '30.00', '25.00', NULL, 0),
(5, 5, '45.00', '115.00', '250.00', '30.00', '100.00', '250.00', '100.00', '400.00', '250.00', NULL, 0),
(6, 6, '13.50', '17.50', '15.00', '12.00', '15.50', '13.50', '11.00', '14.00', '12.50', NULL, 0),
(7, 7, '4000.00', '11000.00', '7500.00', '4000.00', '11000.00', '7500.00', '5000.00', '15000.00', '9000.00', NULL, 0),
(8, 8, '4.70', '6.10', '5.20', '4.20', '5.40', '4.80', '3.80', '5.50', '4.50', NULL, 0),
(9, 9, '1.50', '4.50', '3.00', '1.50', '4.50', '3.00', '1.50', '4.50', '3.00', NULL, 0),
(10, 10, '0.70', '1.30', '1.00', '0.60', '1.10', '0.90', '0.20', '0.80', '0.50', NULL, 0),
(11, 11, '15.00', '40.00', '25.00', '15.00', '40.00', '25.00', '5.00', '18.00', '15.00', NULL, 0),
(12, 12, '3.40', '7.00', '5.20', '2.40', '6.00', '4.50', '2.00', '5.50', '3.50', NULL, 0),
(13, 13, '0.40', '4.00', '2.00', '0.40', '4.00', '2.00', '0.70', '6.40', '2.50', NULL, 0),
(14, 14, '80.00', '200.00', '120.00', '80.00', '200.00', '120.00', '90.00', '210.00', '120.00', NULL, 0),
(15, 15, '5.00', '12.00', '8.00', '5.00', '12.00', '8.00', '6.00', '14.00', '8.00', NULL, 0),
(16, 16, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', NULL, 0),
(17, 17, '4000.00', '11000.00', '6000.00', '4000.00', '11000.00', '6000.00', '4000.00', '11000.00', '6000.00', '', 0),
(18, 101, '0.00', '200.00', '180.00', '0.00', '200.00', '180.00', '0.00', '200.00', '170.00', 'Desirable 0 - 200,\r\nBorderline high:200-239, \r\nUndesirable:>=240', 1),
(19, 102, '40.00', '60.00', '45.00', '50.00', '70.00', '55.00', '40.00', '60.00', '50.00', NULL, 0),
(20, 103, '0.00', '100.00', '90.00', '0.00', '100.00', '85.00', '0.00', '100.00', '80.00', NULL, 0),
(21, 104, '0.00', '150.00', '130.00', '0.00', '150.00', '120.00', '0.00', '150.00', '110.00', NULL, 0),
(22, 105, '70.00', '99.00', '90.00', '70.00', '99.00', '90.00', '70.00', '99.00', '85.00', NULL, 0),
(23, 106, '0.00', '140.00', '120.00', '0.00', '140.00', '120.00', '0.00', '140.00', '110.00', NULL, 0),
(24, 107, '4.00', '5.60', '5.20', '4.00', '5.60', '5.20', '4.00', '5.60', '5.00', NULL, 0),
(25, 108, '135.00', '145.00', '140.00', '135.00', '145.00', '140.00', '135.00', '145.00', '138.00', NULL, 0),
(26, 109, '3.50', '5.00', '4.20', '3.50', '5.00', '4.20', '3.50', '5.00', '4.00', NULL, 0),
(27, 110, '98.00', '106.00', '102.00', '98.00', '106.00', '102.00', '98.00', '106.00', '100.00', NULL, 0),
(28, 111, '8.50', '10.50', '9.50', '8.50', '10.50', '9.50', '8.50', '10.50', '9.00', NULL, 0),
(29, 112, '1.60', '2.60', '2.00', '1.60', '2.60', '2.00', '1.60', '2.60', '1.80', NULL, 0),
(30, 113, '2.50', '4.50', '3.50', '2.50', '4.50', '3.50', '2.50', '4.50', '3.00', NULL, 0),
(31, 114, '11.00', '13.50', '12.50', '11.00', '13.50', '12.50', '11.00', '13.50', '12.00', NULL, 0),
(32, 115, '25.00', '35.00', '30.00', '25.00', '35.00', '30.00', '25.00', '35.00', '28.00', NULL, 0),
(33, 116, '0.80', '1.10', '1.00', '0.80', '1.10', '1.00', '0.80', '1.10', '1.00', NULL, 0),
(34, 117, '0.00', '35.00', '25.00', '0.00', '35.00', '25.00', '0.00', '35.00', '20.00', NULL, 0),
(35, 118, '0.00', '40.00', '30.00', '0.00', '40.00', '30.00', '0.00', '40.00', '25.00', NULL, 0),
(36, 119, '0.00', '4.00', '2.50', '0.00', '4.00', '2.00', '0.00', '4.00', '1.50', NULL, 0),
(37, 120, '0.00', '5.00', '2.50', '0.00', '5.00', '2.00', '0.00', '5.00', '2.00', NULL, 0),
(38, 121, '0.30', '1.20', '0.80', '0.30', '1.10', '0.70', '0.20', '1.00', '0.60', NULL, 0),
(39, 122, '0.10', '0.40', '0.30', '0.10', '0.30', '0.20', '0.05', '0.20', '0.10', NULL, 0),
(40, 123, '0.20', '0.80', '0.50', '0.20', '0.70', '0.50', '0.15', '0.60', '0.40', NULL, 0),
(41, 124, '8.00', '40.00', '20.00', '8.00', '35.00', '18.00', '5.00', '30.00', '15.00', NULL, 0),
(42, 125, '7.00', '56.00', '25.00', '7.00', '45.00', '22.00', '5.00', '40.00', '20.00', NULL, 0),
(43, 126, '40.00', '129.00', '85.00', '35.00', '104.00', '70.00', '30.00', '90.00', '60.00', NULL, 0),
(44, 127, '9.00', '48.00', '25.00', '7.00', '45.00', '22.00', '5.00', '30.00', '15.00', NULL, 0),
(45, 128, '6.00', '8.30', '7.20', '6.00', '8.00', '7.00', '5.50', '7.50', '6.50', NULL, 0),
(46, 129, '3.50', '5.00', '4.20', '3.50', '5.00', '4.00', '3.00', '4.50', '3.80', NULL, 0),
(47, 130, '2.00', '3.50', '2.50', '2.00', '3.50', '2.50', '1.50', '3.00', '2.00', NULL, 0),
(48, 131, '1.00', '2.20', '1.40', '1.00', '2.00', '1.30', '0.80', '1.80', '1.20', NULL, 0),
(49, 132, '4.00', '11.00', '7.00', '4.00', '10.00', '6.50', '5.00', '13.00', '8.00', NULL, 0),
(50, 133, '4.50', '6.50', '5.50', '4.00', '5.50', '5.00', '3.80', '5.20', '4.50', NULL, 0),
(51, 134, '13.00', '17.00', '15.00', '12.00', '15.00', '13.50', '11.00', '14.00', '12.50', NULL, 0),
(52, 135, '38.00', '50.00', '45.00', '36.00', '44.00', '40.00', '32.00', '42.00', '38.00', NULL, 0),
(53, 136, '80.00', '100.00', '90.00', '78.00', '98.00', '88.00', '76.00', '96.00', '86.00', NULL, 0),
(54, 137, '27.00', '32.00', '30.00', '26.00', '31.00', '29.00', '24.00', '30.00', '28.00', NULL, 0),
(55, 138, '32.00', '36.00', '34.00', '31.00', '35.00', '33.00', '30.00', '34.00', '32.00', NULL, 0),
(56, 139, '150.00', '400.00', '250.00', '150.00', '400.00', '250.00', '150.00', '400.00', '250.00', NULL, 0),
(57, 140, '11.50', '14.50', '13.00', '11.50', '14.00', '13.00', '11.00', '14.00', '12.00', NULL, 0),
(58, 141, '10.00', '50.00', '30.00', '10.00', '45.00', '28.00', '8.00', '40.00', '25.00', NULL, 0),
(59, 142, '0.70', '1.30', '1.00', '0.60', '1.10', '0.90', '0.50', '1.00', '0.80', NULL, 0),
(60, 143, '3.40', '7.00', '5.50', '2.40', '6.00', '4.50', '2.00', '5.50', '4.00', NULL, 0),
(61, 144, '7.00', '20.00', '15.00', '7.00', '18.00', '14.00', '6.00', '16.00', '12.00', NULL, 0),
(62, 145, '8.80', '10.60', '9.50', '8.50', '10.20', '9.00', '8.00', '10.00', '9.00', NULL, 0),
(63, 146, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', NULL, 0),
(64, 1, '10.00', '50.00', '30.00', '10.00', '45.00', '28.00', '8.00', '40.00', '25.00', NULL, 0),
(65, 2, '0.70', '1.30', '1.00', '0.60', '1.10', '0.90', '0.50', '1.00', '0.80', NULL, 0),
(66, 3, '3.40', '7.00', '5.50', '2.40', '6.00', '4.50', '2.00', '5.50', '4.00', NULL, 0),
(67, 4, '7.00', '20.00', '15.00', '7.00', '18.00', '14.00', '6.00', '16.00', '12.00', NULL, 0),
(68, 5, '8.80', '10.60', '9.50', '8.50', '10.20', '9.00', '8.00', '10.00', '9.00', NULL, 0),
(69, 154, '11.00', '18.00', '14.00', '11.00', '18.00', '13.00', '10.00', '17.00', '13.00', NULL, 0),
(70, 172, NULL, NULL, '0.00', NULL, NULL, '0.00', NULL, NULL, '0.00', '', 0),
(71, 173, '40.00', '70.00', '45.00', '40.00', '70.00', '45.00', '40.00', '70.00', '45.00', '', 0),
(72, 174, '20.00', '40.00', '20.00', '20.00', '40.00', '20.00', '20.00', '40.00', '20.00', '', 0),
(73, 175, '1.00', '6.00', '1.00', '1.00', '6.00', '1.00', '1.00', '6.00', '1.00', '', 0),
(74, 176, '1.00', '10.00', '1.00', '1.00', '10.00', '1.00', '1.00', '10.00', '1.00', '', 0),
(75, 177, '4.50', '5.50', '4.50', '4.50', '5.50', '4.50', '4.50', '5.50', '4.50', '', 0),
(76, 178, '40.00', '50.00', '40.00', '40.00', '50.00', '40.00', '40.00', '50.00', '40.00', '', 0),
(77, 159, NULL, NULL, '0.00', NULL, NULL, '0.00', NULL, NULL, '0.00', '', 0),
(78, 159, NULL, NULL, '0.00', NULL, NULL, '0.00', NULL, NULL, '0.00', '', 0),
(79, 19, '1.50', '4.50', '1.50', '1.50', '4.50', '1.50', '1.50', '4.50', '1.50', '', 0),
(80, 19, '1.50', '4.50', '1.50', '1.50', '4.50', '1.50', '1.50', '4.50', '1.50', '', 0);

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
  `address` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`patient_id`, `full_name`, `gender`, `date_of_birth`, `phone`, `email`, `address`, `created_at`, `photo`) VALUES
(1, 'Ravi Kumar', 'male', '1985-07-10', '9876543210', 'ravi@example.com', 'Vizag', '2025-05-14 07:34:17', NULL),
(2, 'Sita Devi', 'female', '1992-03-22', '9876500001', 'sita@example.com', 'Vizag', '2025-05-14 07:34:17', NULL),
(3, 'Kiran Reddy', 'male', '2005-09-15', '9876567890', 'kiran@example.com', 'Vizag', '2025-05-14 07:34:17', NULL),
(4, 'Ramesh', 'male', '2000-01-10', '787887878', NULL, 'vsp', '2025-05-21 10:37:39', NULL),
(5, 'Rajesh', 'male', '2001-02-10', '898989899', NULL, 'VSP', '2025-05-21 11:03:18', NULL),
(6, 'Sunil', 'male', '2005-05-17', '9787887887', NULL, 'VSP', '2025-05-21 11:34:22', NULL),
(7, 'Mukesh', 'male', '1999-10-10', '989898999', NULL, 'VZM', '2025-05-21 11:35:23', NULL),
(8, 'Rajesh Rai', 'male', '2000-01-02', '788787878', NULL, 'gajuwaka', '2025-05-21 12:06:28', NULL),
(9, 'Laxmi ', 'female', '2000-01-10', '7878787878', NULL, 'VSP', '2025-05-21 12:07:27', NULL),
(10, 'Kumar', 'male', '1999-05-10', '98656866588', NULL, 'gwk', '2025-05-21 12:08:26', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `notes` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `test_packages`
--

INSERT INTO `test_packages` (`package_id`, `package_name`, `package_code`, `package_price`, `notes`) VALUES
(1, 'Basic Health Checkup', 'BASICPKG', '799.00', 'CBC, Blood Sugar, Lipid, LFT, KFT'),
(2, 'Executive Health Checkup', 'EXECUTIVE', '1599.00', 'CBC, Blood Sugar, Lipid, LFT, KFT, TFT, Electrolytes'),
(3, 'Fever Profile', 'FEVERPKG', '699.00', 'CBC, LFT, Malaria, Dengue, Typhoid'),
(4, 'Diabetic Profile', 'DIABETES', '499.00', 'FBS, PPBS, HbA1c, Lipid Profile, Creatinine'),
(5, 'Heart Risk Profile', 'HEARTPKG', '999.00', 'Lipid Profile, Blood Sugar, ECG'),
(6, 'Liver Health Package', 'LIVERPKG', '599.00', 'LFT, HBsAg, CBC'),
(7, 'Kidney Health Package', 'KIDNEYPKG', '599.00', 'KFT, Electrolytes'),
(8, 'Antenatal Profile', 'ANTENATAL', '1999.00', 'CBC, Blood Group, HIV, HBsAg, VDRL, Blood Sugar, Urine, TSH'),
(9, 'CBC_DC', 'CBCDC', '1000.00', '');

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
  `interpretation` text,
  `notes` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `test_parameters`
--

INSERT INTO `test_parameters` (`parameter_id`, `param_name`, `category_id`, `group_id`, `unit`, `method`, `interpretation`, `notes`) VALUES
(11, 'Total Bilirubin', 1, 1, 'mg/dL', 'Diazo Method', 'Elevated in liver dysfunction or hemolysis', 'Fasting preferred'),
(12, 'Direct Bilirubin', 1, 1, 'mg/dL', 'Diazo Method', 'Direct ↑ = obstructive jaundice', ''),
(13, 'SGPT (ALT)', 1, 1, 'U/L', 'UV Kinetic', 'High in liver injury/hepatitis', 'Avoid exercise before test'),
(14, 'SGOT (AST)', 1, 1, 'U/L', 'UV Kinetic', '↑ in liver, cardiac, and muscle disorders', 'AST > ALT = cardiac source'),
(15, 'Alkaline Phosphatase', 1, 1, 'U/L', 'PNPP Method', '↑ in bone and liver diseases', 'High in children (bone growth)'),
(16, 'HB', 1, 2, 'g/dL', 'Cyanmethemoglobin Method', 'Low in anemia, high in polycythemia', ''),
(17, 'Total WBC Count', 1, 2, 'cells/cumm', 'Automated Cell Counter', 'Increased in infections/inflammation', ''),
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
(101, 'Total Cholesterols', 1, 1, 'mg/dL', 'Enzymatic', 'Helps assess risk of cardiovascular disease.', ''),
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
(159, 'Platelet Count.', 1, 2, '10^3/uL', 'Impedance', 'Helps in clotting.', ''),
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
(171, 'Calcium', 1, 1, 'mg/dL', 'Colorimetric', 'Important mineral; also involved in kidney health.', ''),
(172, 'Malaria Parasite', 1, 2, '', '', '', ''),
(173, 'Polymorphs', 1, 2, '%', '', '', ''),
(174, 'Lymphocytes', 1, 2, '%', '', '', ''),
(175, 'Eosinophils', 1, 2, '%', '', '', ''),
(176, 'Monocytes', 1, 2, '%', '', '', ''),
(177, 'Total RBC Count', 1, 2, 'mill/cumm', '', '', ''),
(178, 'PVC/HCT', 1, 2, 'vol%', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `test_parameter_map`
--

CREATE TABLE `test_parameter_map` (
  `id` int(11) NOT NULL,
  `test_id` int(11) DEFAULT NULL,
  `parameter_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `tested_by` int(11) DEFAULT NULL,
  `status` varchar(100) NOT NULL,
  `bill_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `test_results`
--

INSERT INTO `test_results` (`result_id`, `sample_id`, `parameter_id`, `result_value`, `result_date`, `tested_by`, `status`, `bill_id`) VALUES
(3, NULL, 151, '2', NULL, NULL, 'Completed', 9),
(4, NULL, 149, '4', NULL, NULL, 'Completed', 9),
(5, NULL, 15, '15', NULL, NULL, 'Completed', 9),
(6, NULL, 12, '5.20', NULL, NULL, 'Completed', 9),
(7, NULL, 147, '5', NULL, NULL, 'Completed', 9),
(8, NULL, 150, '8', NULL, NULL, 'Completed', 9),
(9, NULL, 14, '120.00', NULL, NULL, 'Completed', 9),
(10, NULL, 13, '2.00', NULL, NULL, 'Completed', 9),
(11, NULL, 11, '25.00', NULL, NULL, 'Completed', 9),
(12, NULL, 148, '85', NULL, NULL, 'Completed', 9),
(13, NULL, 111, '9.50', NULL, NULL, 'Completed', 6),
(14, NULL, 154, '16', NULL, NULL, 'Completed', 6),
(15, NULL, 112, '2.00', NULL, NULL, 'Completed', 6),
(16, NULL, 113, '3.50', NULL, NULL, 'Completed', 6),
(17, NULL, 155, '10', NULL, NULL, 'Completed', 13),
(18, NULL, 154, '15', NULL, NULL, 'Completed', 13),
(19, NULL, 157, '2.5', NULL, NULL, 'Completed', 13),
(20, NULL, 158, '0.5', NULL, NULL, 'Completed', 13),
(21, NULL, 156, '05', NULL, NULL, 'Completed', 13),
(22, NULL, 159, '21000', NULL, NULL, 'Completed', 13),
(23, NULL, 153, '120', NULL, NULL, 'Completed', 13),
(24, NULL, 160, '15', NULL, NULL, 'Completed', 13),
(25, NULL, 152, '15', NULL, NULL, 'Completed', 13),
(26, NULL, 155, '15', NULL, NULL, 'Completed', 14),
(27, NULL, 154, '0.2', NULL, NULL, 'Completed', 14),
(28, NULL, 157, '05', NULL, NULL, 'Completed', 14),
(29, NULL, 158, '18', NULL, NULL, 'Completed', 14),
(30, NULL, 156, '18', NULL, NULL, 'Completed', 14),
(31, NULL, 159, '53', NULL, NULL, 'Completed', 14),
(32, NULL, 153, '0.2', NULL, NULL, 'Completed', 14),
(33, NULL, 160, '1000', NULL, NULL, 'Completed', 14),
(34, NULL, 152, '300', NULL, NULL, 'Completed', 14),
(35, NULL, 151, '10', NULL, NULL, 'Completed', 9),
(36, NULL, 149, '15', NULL, NULL, 'Completed', 9),
(37, NULL, 15, '15', NULL, NULL, 'Completed', 9),
(38, NULL, 12, '5.20', NULL, NULL, 'Completed', 9),
(39, NULL, 147, '2', NULL, NULL, 'Completed', 9),
(40, NULL, 150, '15', NULL, NULL, 'Completed', 9),
(41, NULL, 14, '120.00', NULL, NULL, 'Completed', 9),
(42, NULL, 13, '2.00', NULL, NULL, 'Completed', 9),
(43, NULL, 11, '25.00', NULL, NULL, 'Completed', 9),
(44, NULL, 148, '10', NULL, NULL, 'Completed', 9),
(45, NULL, 155, 'Normal', NULL, NULL, 'Completed', 15),
(46, NULL, 154, '13.00', NULL, NULL, 'Completed', 15),
(47, NULL, 157, '15', NULL, NULL, 'Completed', 15),
(48, NULL, 158, '', NULL, NULL, 'Completed', 15),
(49, NULL, 156, '', NULL, NULL, 'Completed', 15),
(50, NULL, 159, '', NULL, NULL, 'Completed', 15),
(51, NULL, 153, '', NULL, NULL, 'Completed', 15),
(52, NULL, 152, '', NULL, NULL, 'Completed', 15),
(53, NULL, 155, 'Negative', NULL, NULL, 'Completed', 13),
(54, NULL, 154, '14.00', NULL, NULL, 'Completed', 13),
(55, NULL, 157, 'Positive', NULL, NULL, 'Completed', 13),
(56, NULL, 158, 'Normal', NULL, NULL, 'Completed', 13),
(57, NULL, 156, '09', NULL, NULL, 'Completed', 13),
(58, NULL, 159, '9', NULL, NULL, 'Completed', 13),
(59, NULL, 153, '9', NULL, NULL, 'Completed', 13),
(60, NULL, 152, '9', NULL, NULL, 'Completed', 13),
(61, NULL, 155, 'Abnormal', NULL, NULL, 'Completed', 12),
(62, NULL, 154, '14.00', NULL, NULL, 'Completed', 12),
(63, NULL, 157, 'NAD', NULL, NULL, 'Completed', 12),
(64, NULL, 158, '12', NULL, NULL, 'Completed', 12),
(65, NULL, 156, '15', NULL, NULL, 'Completed', 12),
(66, NULL, 159, '15', NULL, NULL, 'Completed', 12),
(67, NULL, 153, 'Reactive', NULL, NULL, 'Completed', 12),
(68, NULL, 152, 'Normal', NULL, NULL, 'Completed', 12),
(69, NULL, 118, '30.00', NULL, NULL, 'Completed', 11),
(70, NULL, 117, '25.00', NULL, NULL, 'Completed', 11),
(71, NULL, 24, 'Absent', NULL, NULL, 'Completed', 11),
(72, NULL, 25, 'Normal', NULL, NULL, 'Completed', 11),
(73, NULL, 23, 'Positive', NULL, NULL, 'Completed', 11),
(74, NULL, 155, 'NAD', NULL, NULL, 'Completed', 16),
(75, NULL, 154, '14.00', NULL, NULL, 'Completed', 16),
(76, NULL, 157, '15', NULL, NULL, 'Completed', 16),
(77, NULL, 158, 'Positive', NULL, NULL, 'Completed', 16),
(78, NULL, 156, 'Normal', NULL, NULL, 'Completed', 16),
(79, NULL, 159, 'Non-Reactive', NULL, NULL, 'Completed', 16),
(80, NULL, 153, 'Positive', NULL, NULL, 'Completed', 16),
(81, NULL, 152, 'Positive', NULL, NULL, 'Completed', 16),
(130, NULL, 155, 'Abnormal', NULL, NULL, 'Completed', 17),
(131, NULL, 154, '14.00', NULL, NULL, 'Completed', 17),
(132, NULL, 157, 'Absent', NULL, NULL, 'Completed', 17),
(133, NULL, 158, 'Normal', NULL, NULL, 'Completed', 17),
(134, NULL, 156, 'Normal', NULL, NULL, 'Completed', 17),
(135, NULL, 159, '15', NULL, NULL, 'Completed', 17),
(136, NULL, 153, '9', NULL, NULL, 'Completed', 17),
(137, NULL, 152, 'NAD', NULL, NULL, 'Completed', 17),
(138, NULL, 102, '45.00', NULL, NULL, 'Completed', 18),
(139, NULL, 103, '90.00', NULL, NULL, 'Completed', 18),
(140, NULL, 101, '180.00', NULL, NULL, 'Completed', 18),
(141, NULL, 104, '130.00', NULL, NULL, 'Completed', 18),
(142, NULL, 172, 'Negative', NULL, NULL, 'Completed', 19),
(143, NULL, 155, 'Positive', NULL, NULL, 'Completed', 20),
(144, NULL, 154, '14.00', NULL, NULL, 'Completed', 20),
(145, NULL, 157, 'Absent', NULL, NULL, 'Completed', 20),
(146, NULL, 158, 'Normal', NULL, NULL, 'Completed', 20),
(147, NULL, 156, 'NAD', NULL, NULL, 'Completed', 20),
(148, NULL, 159, 'Normal', NULL, NULL, 'Completed', 20),
(149, NULL, 153, 'Normal', NULL, NULL, 'Completed', 20),
(150, NULL, 152, 'Absent', NULL, NULL, 'Completed', 20),
(151, NULL, 175, '1.00', NULL, NULL, 'Completed', 20),
(152, NULL, 174, '20.00', NULL, NULL, 'Completed', 20),
(153, NULL, 176, '1.00', NULL, NULL, 'Completed', 20),
(154, NULL, 173, '45.00', NULL, NULL, 'Completed', 20),
(155, NULL, 17, '6000.00', NULL, NULL, 'Completed', 21),
(156, NULL, 177, '4.50', NULL, NULL, 'Completed', 21),
(157, NULL, 154, '14.00', NULL, NULL, 'Completed', 21),
(158, NULL, 178, '40.00', NULL, NULL, 'Completed', 21),
(159, NULL, 156, 'Absent', NULL, NULL, 'Completed', 21),
(160, NULL, 157, 'NAD', NULL, NULL, 'Completed', 21),
(161, NULL, 158, '12', NULL, NULL, 'Completed', 21),
(162, NULL, 19, '1.50', NULL, NULL, 'Completed', 21),
(163, NULL, 173, '45.00', NULL, NULL, 'Completed', 21),
(164, NULL, 174, '20.00', NULL, NULL, 'Completed', 21),
(165, NULL, 175, '1.00', NULL, NULL, 'Completed', 21),
(166, NULL, 176, '1.00', NULL, NULL, 'Completed', 21);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `test_samples`
--

INSERT INTO `test_samples` (`sample_id`, `bill_id`, `sample_date`, `collected_by`, `status`) VALUES
(1, 5, '2025-05-22 13:47:13', 5, 'collected'),
(2, 5, '2025-05-22 13:54:21', 5, 'collected'),
(3, 6, '2025-05-22 13:54:25', 5, 'completed'),
(4, 7, '2025-05-22 13:58:39', 5, 'collected'),
(5, 8, '2025-05-22 13:58:48', 5, 'completed'),
(6, 9, '2025-05-22 13:58:49', 5, 'completed'),
(7, 10, '2025-06-07 08:20:44', 1, 'collected'),
(8, 12, '2025-05-27 16:28:01', 5, 'completed'),
(9, 13, '2025-05-27 16:28:03', 5, 'completed'),
(10, 14, '2025-05-29 10:54:58', 5, 'completed'),
(11, 15, '2025-05-30 16:00:17', 5, 'completed'),
(12, 11, '2025-05-30 18:14:17', 5, 'completed'),
(13, 16, '2025-06-03 23:38:34', 1, 'completed'),
(14, 17, '2025-06-07 08:16:57', 1, 'pending'),
(15, 18, '2025-06-07 12:51:20', 1, 'completed'),
(16, 19, '2025-06-08 12:43:19', 1, 'completed'),
(17, 20, '2025-06-20 09:42:40', 1, 'completed'),
(18, 21, '2025-06-22 18:21:50', 1, 'completed');

-- --------------------------------------------------------

--
-- Table structure for table `test_template`
--

CREATE TABLE `test_template` (
  `test_id` int(11) NOT NULL,
  `header_html` text,
  `interpretation` text,
  `notes` text,
  `table_format` varchar(50) DEFAULT NULL,
  `group_by` tinyint(1) DEFAULT NULL,
  `show_method` tinyint(1) DEFAULT NULL,
  `show_interpretation` tinyint(1) DEFAULT NULL,
  `show_notes` tinyint(1) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `test_template`
--

INSERT INTO `test_template` (`test_id`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `updated_at`) VALUES
(1, '<div style=\"font-family:Arial, sans-serif;\">\r\n  <h2 style=\"color:#2A5D9F;border-bottom:1px solid #ccc;padding-bottom:5px;\">Complete Blood Count (CBC)</h2>\r\n  <p style=\"font-size:13px;\">The CBC provides vital information regarding red and white blood cells and platelets.</p>\r\n</div>', '<p style=\"font-size:12px;\">Interpretation of CBC should consider clinical context. Abnormal white cell counts may indicate infection or inflammation.</p>', '<ul style=\"font-size:12px;\"><li>No fasting required</li><li>Check trends over time</li><li>Consult physician for clinical correlation</li></ul>', 'default', 1, 1, 1, 1, '2025-05-27 13:55:32'),
(2, '<div style=\"font-family:Arial, sans-serif;\">\r\n  <h2 style=\"color:#008080;border-bottom:1px solid #ccc;padding-bottom:5px;\">Lipid Profile</h2>\r\n  <p style=\"font-size:13px;\">Assesses cholesterol and triglyceride levels critical to heart health.</p>\r\n</div>', '<p style=\"font-size:12px;\">LDL levels are an established risk factor for cardiovascular disease. HDL is considered protective.</p>', '<ul style=\"font-size:12px;\"><li>Fasting 10–12 hours recommended</li><li>Repeat testing annually for high-risk individuals</li></ul>', 'default', 1, 1, 1, 1, '2025-05-27 13:55:32'),
(3, '<div style=\"font-family:Arial, sans-serif;\">\r\n  <h2 style=\"color:#A52A2A;border-bottom:1px solid #ccc;padding-bottom:5px;\">Liver Function Test (LFT)</h2>\r\n  <p style=\"font-size:13px;\">Evaluates enzymes, proteins, and substances produced or cleared by the liver.</p>\r\n</div>', '<p style=\"font-size:12px;\">Elevated liver enzymes may suggest liver inflammation or damage.</p>', '<ul style=\"font-size:12px;\"><li>Interpret with hepatitis screening and imaging if indicated</li><li>Repeat tests if abnormal</li></ul>', 'default', 1, 1, 1, 1, '2025-05-27 13:55:32');

-- --------------------------------------------------------

--
-- Table structure for table `test_templates`
--

CREATE TABLE `test_templates` (
  `template_id` int(11) NOT NULL,
  `test_id` int(11) DEFAULT NULL,
  `template_name` varchar(100) DEFAULT NULL,
  `header_html` text,
  `interpretation` text,
  `notes` text,
  `table_format` varchar(50) DEFAULT NULL,
  `group_by` tinyint(1) DEFAULT NULL,
  `show_method` tinyint(1) DEFAULT NULL,
  `show_interpretation` tinyint(1) DEFAULT NULL,
  `show_notes` tinyint(1) DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT '0',
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `test_templates`
--

INSERT INTO `test_templates` (`template_id`, `test_id`, `template_name`, `header_html`, `interpretation`, `notes`, `table_format`, `group_by`, `show_method`, `show_interpretation`, `show_notes`, `is_default`, `updated_at`) VALUES
(1, 1, 'CBC Standard', '<h2 style=\"color:#006699\">Complete Blood Count (CBC)</h2><p>Includes WBC, RBC, Hemoglobin, Hematocrit, Platelets</p><p><strong>Method:</strong> Automated Hematology Analyzer</p>', '<p>Interpret CBC with clinical correlation. WBC elevation suggests infection. Low Hb may indicate anemia.</p>', '<ul><li>No fasting required</li><li>Consult physician for abnormal counts</li></ul>', 'default', 1, 1, 1, 1, 1, '2025-05-28 17:55:25'),
(2, 2, 'KFT Basic', '<h2 style=\"color:#00796B\">Kidney Function Test</h2><p>Includes Urea, Creatinine, BUN, Uric Acid</p><p><strong>Method:</strong> Colorimetric, Enzymatic</p>', '<p>Increased Creatinine may indicate impaired renal filtration. Urea elevation can be due to dehydration or renal failure.</p>', '<p>Best interpreted with eGFR</p>', 'default', 1, 1, 1, 1, 1, '2025-05-28 18:05:19'),
(3, 3, 'LFT Elegant', '<h2 style=\"color:#4E342E\">Liver Function Test</h2><p>Includes Bilirubin, SGOT, SGPT, ALP</p><p><strong>Method:</strong> Photometry</p>', '<p>Enzyme elevations suggest hepatocellular damage. Consider viral hepatitis testing if ALT is high.</p>', '<p>Repeat if persistent elevation</p>', 'default', 1, 1, 1, 1, 1, '2025-05-28 18:05:19'),
(4, 4, 'Lipid Profile Pro', '<h2 style=\"color:#283593\">Lipid Profile</h2><p>Includes Total Cholesterol, LDL, HDL, Triglycerides</p><p><strong>Method:</strong> Enzymatic</p>', '<p>LDL is atherogenic. HDL is protective. Evaluate 10-year cardiac risk profile.</p>', '<p>Fasting recommended for accurate triglyceride measurement</p>', 'default', 1, 1, 1, 1, 1, '2025-05-28 18:05:19'),
(5, 5, 'Thyroid Panel CLIA', '<h2 style=\"color:#6A1B9A\">Thyroid Profile</h2><p>TSH, Free T3, Free T4</p><p><strong>Method:</strong> CLIA</p>', '<p>TSH elevation = hypothyroidism. Low TSH + high T3/T4 = hyperthyroidism.</p>', '<p>Test early morning for consistency</p>', 'default', 1, 1, 1, 1, 1, '2025-05-28 18:05:19'),
(6, 6, 'Sugar Profile', '<h2 style=\"color:#D84315\">Blood Sugar Profile</h2><p>FBS, PPBS, HbA1c</p><p><strong>Method:</strong> Hexokinase/Immunoturbidimetry</p>', '<p>FBS and PPBS assess short-term glucose. HbA1c reflects 3-month average.</p>', '<p>Over 6.5% HbA1c = diabetes</p>', 'default', 1, 1, 1, 1, 1, '2025-05-28 18:05:19'),
(7, 7, 'HB Single', '<h2 style=\"color:#B71C1C\">Hemoglobin</h2><p><strong>Method:</strong> Cyanmethemoglobin/Photometric</p>', '<p>Low Hb suggests anemia. High levels may occur in dehydration or polycythemia.</p>', '<p>Compare with CBC or RBC indices</p>', 'default', 0, 1, 1, 1, 1, '2025-05-28 18:05:19'),
(8, 8, 'HIV Screening', '<h2 style=\"color:#AD1457\">HIV Test</h2><p>Rapid or ELISA Method</p>', '<p>Detects HIV 1/2 antibodies. Recommend confirmatory test for reactive results.</p>', '<p>Confidential test. Mandatory pre/post test counselling advised.</p>', 'default', 0, 1, 1, 1, 1, '2025-05-28 18:05:19'),
(9, 9, 'Hepatitis B Antigen', '<h2 style=\"color:#33691E\">HBsAg</h2><p>Rapid Immunochromatography or ELISA</p>', '<p>Indicates active hepatitis B infection or carrier state.</p>', '<p>Positive result requires further evaluation: HBeAg, HBV DNA</p>', 'default', 0, 1, 1, 1, 1, '2025-05-28 18:05:19'),
(10, 10, 'Coagulation Standard', '<h2 style=\"color:#1A237E\">Coagulation Profile</h2><p>PT, aPTT, INR</p><p><strong>Method:</strong> Mechanical/Optical clot detection</p>', '<p>Used to monitor bleeding disorders or anticoagulation therapy.</p>', '<p>Evaluate liver function if prolonged clotting times</p>', 'default', 1, 1, 1, 1, 1, '2025-05-28 18:05:19'),
(11, 1, NULL, '', '', '', 'default', 0, NULL, NULL, NULL, 0, '2025-05-29 17:10:47'),
(12, 1, NULL, '', '', '', 'default', 0, 0, 0, 0, 0, '2025-05-29 17:15:21'),
(13, 1, NULL, '<h2 style=\"color:#006699\">Complete Blood Count (CBC)</h2><p>Includes WBC, RBC, Hemoglobin, Hematocrit, Platelets</p><p><strong>Method:</strong> Automated Hematology Analyzer</p>', '<p>Interpret CBC with clinical correlation. WBC elevation suggests infection. Low Hb may indicate anemia.</p>', '<ul><li>No fasting required</li><li>Consult physician for abnormal counts</li></ul>', 'boxed', 1, 1, 1, 1, 0, '2025-05-29 17:16:04'),
(14, 1, NULL, '<h2 style=\"color:#006699\">Complete Blood Count (CBC)</h2><p>Includes WBC, RBC, Hemoglobin, Hematocrit, Platelets</p><p><strong>Method:</strong> Automated Hematology Analyzer</p>', '<p>Interpret CBC with clinical correlation. WBC elevation suggests infection. Low Hb may indicate anemia.</p>', '<ul><li>No fasting required</li><li>Consult physician for abnormal counts</li></ul>', 'compact', 1, 1, 1, 1, 0, '2025-05-29 17:16:26'),
(15, 1, NULL, '', '', '', 'default', 0, 0, 0, 0, 0, '2025-05-29 17:16:45'),
(16, 1, NULL, '<h2 style=\"color:#006699\">Complete Blood Count (CBC)</h2><p>Includes WBC, RBC, Hemoglobin, Hematocrit, Platelets</p><p><strong>Method:</strong> Automated Hematology Analyzer</p>', '<p>Interpret CBC with clinical correlation. WBC elevation suggests infection. Low Hb may indicate anemia.</p>', '<ul><li>No fasting required</li><li>Consult physician for abnormal counts</li></ul>', 'boxed', 1, 1, 1, 1, 0, '2025-05-29 17:16:54'),
(17, 6, NULL, '<h2 style=\"color:#006699\">Complete Blood Count (CBC)</h2><p>Includes WBC, RBC, Hemoglobin, Hematocrit, Platelets</p><p><strong>Method:</strong> Automated Hematology Analyzer</p>', '<p>Interpret CBC with clinical correlation. WBC elevation suggests infection. Low Hb may indicate anemia.</p>', '<ul><li>No fasting required</li><li>Consult physician for abnormal counts</li></ul>', 'default', 1, 1, 1, 1, 0, '2025-05-29 17:17:03'),
(18, 7, NULL, '<h2 style=\"color:#D84315\">Blood Sugar Profile</h2><p>FBS, PPBS, HbA1c</p><p><strong>Method:</strong> Hexokinase/Immunoturbidimetry</p>', '<p>FBS and PPBS assess short-term glucose. HbA1c reflects 3-month average.</p>', '<p>Over 6.5% HbA1c = diabetes</p>', 'default', 1, 1, 1, 1, 0, '2025-05-29 17:17:07'),
(19, 29, NULL, '', 'Malaria Parasite Test Result	Interpretation\r\nNot seen 	No malaria parasites were detected\r\nSchizonts of P. Vivax seen	P. vivax parasite detected in the blood\r\nTrophozoites of P. Vivax	Active infection with P. Vivax detected\r\nTrophozoites of P. Falciparum	Active infection with P. Falciparum detected\r\nGametocytes of P. Falciparum	Active infection with P. Falciparum detected and an increased\r\nrisk of transmission to others\r\n', '', 'default', 0, 0, 1, 0, 0, '2025-06-08 16:36:23'),
(20, 27, NULL, '', '', '', 'default', 0, NULL, NULL, NULL, 0, '2025-06-08 23:36:50'),
(21, 1, NULL, '', '', '', 'default', 0, NULL, NULL, NULL, 0, '2025-06-08 23:37:02'),
(22, 4, NULL, '<h2 style=\"color:#006699\">Complete Blood Count (CBC)</h2><p>Includes WBC, RBC, Hemoglobin, Hematocrit, Platelets</p><p><strong>Method:</strong> Automated Hematology Analyzer</p>', '<p>Interpret CBC with clinical correlation. WBC elevation suggests infection. Low Hb may indicate anemia.</p>', '<ul><li>No fasting required</li><li>Consult physician for abnormal counts</li></ul>', 'default', 1, NULL, NULL, NULL, 0, '2025-06-08 23:37:56'),
(23, 1, NULL, '<h2 style=\"color:#283593\">Lipid Profile</h2><p>Includes Total Cholesterol, LDL, HDL, Triglycerides</p><p><strong>Method:</strong> Enzymatic</p>', '<p>LDL is atherogenic. HDL is protective. Evaluate 10-year cardiac risk profile.</p>', '<p>Fasting recommended for accurate triglyceride measurement</p>', 'default', 1, NULL, NULL, NULL, 0, '2025-06-08 23:38:50');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password_hash`, `full_name`, `role_id`, `status`) VALUES
(1, 'admin', '$2y$10$AeoGPqork4CPmV8sYBZqpumBpq/TPutWY/1y3ZaKj.7JbvtA4q46.', 'Admin User', 1, 'active'),
(2, 'user1', '6ad14ba9986e3615423dfca256d04e3f', 'Lab Staff 1', 2, 'active'),
(5, 'admin1', '$2y$10$kYr2bH/2qj8vGyP4BlF/xuSlN2Rxs1btQpmi678zkcaWjLTYbPiI.', 'admin1', 1, 'active');

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
-- Indexes for table `package_template`
--
ALTER TABLE `package_template`
  ADD PRIMARY KEY (`test_id`);

--
-- Indexes for table `package_templates`
--
ALTER TABLE `package_templates`
  ADD PRIMARY KEY (`template_id`);

--
-- Indexes for table `package_tests`
--
ALTER TABLE `package_tests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `package_id` (`package_id`,`test_id`),
  ADD KEY `test_id` (`test_id`);

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
-- Indexes for table `test_template`
--
ALTER TABLE `test_template`
  ADD PRIMARY KEY (`test_id`);

--
-- Indexes for table `test_templates`
--
ALTER TABLE `test_templates`
  ADD PRIMARY KEY (`template_id`);

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
  MODIFY `bill_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `bill_packages`
--
ALTER TABLE `bill_packages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `bill_tests`
--
ALTER TABLE `bill_tests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `lab_tests`
--
ALTER TABLE `lab_tests`
  MODIFY `test_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `lab_test_parameters`
--
ALTER TABLE `lab_test_parameters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=265;

--
-- AUTO_INCREMENT for table `package_templates`
--
ALTER TABLE `package_templates`
  MODIFY `template_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `package_tests`
--
ALTER TABLE `package_tests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `package_test_map`
--
ALTER TABLE `package_test_map`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `parameter_reference_ranges`
--
ALTER TABLE `parameter_reference_ranges`
  MODIFY `range_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `patient_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
  MODIFY `package_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `test_parameters`
--
ALTER TABLE `test_parameters`
  MODIFY `parameter_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=179;

--
-- AUTO_INCREMENT for table `test_parameter_map`
--
ALTER TABLE `test_parameter_map`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `test_results`
--
ALTER TABLE `test_results`
  MODIFY `result_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=167;

--
-- AUTO_INCREMENT for table `test_samples`
--
ALTER TABLE `test_samples`
  MODIFY `sample_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `test_templates`
--
ALTER TABLE `test_templates`
  MODIFY `template_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
-- Constraints for table `package_tests`
--
ALTER TABLE `package_tests`
  ADD CONSTRAINT `package_tests_ibfk_1` FOREIGN KEY (`package_id`) REFERENCES `test_packages` (`package_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `package_tests_ibfk_2` FOREIGN KEY (`test_id`) REFERENCES `lab_tests` (`test_id`) ON DELETE CASCADE;

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
