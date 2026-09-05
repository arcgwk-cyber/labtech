-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 03, 2026 at 12:03 PM
-- Server version: 11.8.8-MariaDB-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u258033404_vensaaslabs`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_settings`
--

CREATE TABLE `admin_settings` (
  `id` int(20) NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `company_address` varchar(100) NOT NULL,
  `updated_at` datetime(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_settings`
--

INSERT INTO `admin_settings` (`id`, `company_name`, `company_address`, `updated_at`) VALUES
(1, 'Amma Diagnostic Centre', 'Srikakulam', '2025-07-27 15:22:28.000000');

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

CREATE TABLE `bills` (
  `bill_id` int(11) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `patient_type_id` int(11) DEFAULT NULL,
  `bill_date` date DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `paid_amount` decimal(10,2) DEFAULT NULL,
  `balance` decimal(10,2) DEFAULT NULL,
  `payment_status` enum('paid','partial','unpaid') DEFAULT 'unpaid',
  `created_by` int(11) DEFAULT NULL,
  `sample_collected` tinyint(1) DEFAULT 0,
  `result_entered` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `report_hash` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bills`
--

INSERT INTO `bills` (`bill_id`, `patient_id`, `patient_type_id`, `bill_date`, `total_amount`, `paid_amount`, `balance`, `payment_status`, `created_by`, `sample_collected`, `result_entered`, `created_at`, `report_hash`) VALUES
(5, 2, NULL, '2025-05-21', 450.00, 500.00, -50.00, 'paid', 1, 1, 1, '2025-05-27 13:47:43', NULL),
(6, 3, NULL, '2025-05-21', 1299.00, 0.00, 1299.00, 'paid', 1, 0, 0, '2025-05-27 13:47:43', NULL),
(7, 4, NULL, '2025-05-21', 400.00, 0.00, 400.00, 'paid', 1, 0, 0, '2025-05-27 13:47:43', NULL),
(8, 2, NULL, '2025-05-21', 1000.00, 0.00, 1000.00, 'paid', 1, 0, 0, '2025-05-27 13:47:43', NULL),
(9, 6, NULL, '2025-05-21', 600.00, 0.00, 600.00, 'paid', 1, 0, 0, '2025-05-27 13:47:43', NULL),
(10, 8, NULL, '2025-06-07', 350.00, 0.00, 350.00, 'paid', 1, 0, 0, '2025-05-27 13:47:43', NULL),
(11, 10, NULL, '2025-05-21', 1300.00, 0.00, 1300.00, 'paid', 1, 0, 0, '2025-05-27 13:47:43', NULL),
(12, 10, NULL, '2025-05-27', 350.00, 0.00, 350.00, 'paid', 1, 0, 0, '2025-05-27 16:23:49', NULL),
(13, 6, NULL, '2025-05-27', 350.00, 0.00, 350.00, 'paid', 1, 0, 0, '2025-05-27 16:27:08', NULL),
(14, 3, NULL, '2025-05-29', 350.00, 0.00, 350.00, 'paid', 1, 0, 0, '2025-05-29 10:54:12', NULL),
(15, 9, NULL, '2025-05-30', 350.00, 0.00, 350.00, 'paid', 1, 0, 0, '2025-05-30 15:35:59', NULL),
(16, 3, NULL, '2025-06-03', 350.00, 0.00, 350.00, 'paid', 1, 0, 0, '2025-06-03 23:38:19', NULL),
(17, 6, NULL, '2025-06-06', 350.00, 250.00, 100.00, 'paid', 1, 1, 1, '2025-06-06 07:42:39', NULL),
(18, 4, NULL, '2025-06-07', 500.00, 0.00, 500.00, 'paid', 1, 0, 0, '2025-06-07 16:21:15', NULL),
(19, 2, NULL, '2025-06-08', 250.00, 0.00, 250.00, 'paid', 1, 0, 0, '2025-06-08 16:13:14', NULL),
(20, 7, NULL, '2025-06-20', 1000.00, 0.00, 1000.00, 'paid', 1, 0, 0, '2025-06-20 13:12:34', NULL),
(21, 6, NULL, '2025-06-22', 1000.00, 0.00, 1000.00, 'paid', 1, 0, 0, '2025-06-22 21:51:47', NULL),
(22, 3, NULL, '2025-06-25', 1000.00, 0.00, 1000.00, 'paid', 1, 0, 0, '2025-06-25 05:55:30', NULL),
(23, 4, NULL, '2025-06-26', 500.00, 500.00, 0.00, 'paid', 1, 0, 0, '2025-06-26 12:12:00', NULL),
(24, 5, NULL, '2025-07-04', 3000.00, 0.00, 3000.00, 'paid', 1, 0, 0, '2025-07-03 04:04:47', NULL),
(25, 11, NULL, '2025-07-04', 800.00, 0.00, 800.00, 'paid', 1, 0, 0, '2025-07-04 01:39:20', NULL),
(26, 12, NULL, '2025-07-04', 800.00, 0.00, 800.00, 'paid', 1, 0, 0, '2025-07-04 01:39:26', NULL),
(27, 9, NULL, '2025-07-04', 3500.00, 0.00, 3500.00, 'paid', 1, 0, 0, '2025-07-04 18:54:19', NULL),
(28, 9, NULL, '2025-07-18', 850.00, 0.00, 850.00, 'paid', 1, 0, 0, '2025-07-18 05:24:43', NULL),
(29, 1, NULL, '2025-07-20', 100.00, 0.00, 100.00, 'paid', 1, 0, 0, '2025-07-20 15:54:14', NULL),
(30, 5, NULL, '2025-07-21', 100.00, 0.00, 100.00, 'paid', 1, 0, 0, '2025-07-21 10:28:52', NULL),
(31, 3, NULL, '2025-08-01', 500.00, 0.00, 500.00, 'paid', 1, 0, 0, '2025-08-01 12:38:07', NULL),
(32, 10, NULL, '2025-08-01', 599.00, 0.00, 599.00, 'paid', 1, 0, 0, '2025-08-01 12:48:30', NULL),
(33, 13, NULL, '2025-08-04', 600.00, 0.00, 600.00, 'paid', 1, 0, 0, '2025-08-04 13:43:59', NULL),
(34, 4, NULL, '2025-08-05', 400.00, 150.00, 250.00, 'paid', 1, 0, 0, '2025-08-05 17:49:09', NULL),
(35, 11, NULL, '2025-08-21', 850.00, 0.00, 850.00, 'paid', 1, 0, 0, '2025-08-21 16:23:06', NULL),
(36, 10, NULL, '2025-08-22', 1500.00, 0.00, 1500.00, 'paid', 1, 0, 0, '2025-08-22 06:01:27', NULL),
(37, 10, NULL, '2025-08-22', 350.00, 0.00, 350.00, 'paid', 1, 0, 0, '2025-08-22 08:28:27', NULL),
(38, 10, NULL, '2025-08-23', 350.00, 0.00, 350.00, 'paid', 1, 0, 0, '2025-08-23 10:15:03', NULL),
(39, 11, NULL, '2025-08-23', 350.00, 0.00, 350.00, 'paid', 1, 0, 0, '2025-08-23 17:13:07', NULL),
(40, 10, 1, '2025-08-23', 350.00, 0.00, 350.00, 'paid', 1, 0, 0, '2025-08-23 17:23:48', NULL),
(41, 3, 1, '2025-08-23', 350.00, 0.00, 350.00, 'paid', 1, 0, 0, '2025-08-23 17:25:44', NULL),
(42, 3, 1, '2025-08-24', 350.00, 0.00, 350.00, 'paid', 1, 0, 0, '2025-08-24 02:32:23', NULL),
(43, 14, 1, '2025-08-27', 1150.00, 0.00, 1150.00, 'paid', 1, 0, 0, '2025-08-27 13:21:14', NULL),
(44, 15, NULL, '2025-08-29', 400.00, 400.00, 0.00, 'paid', 1, 0, 0, '2025-08-29 06:30:35', NULL),
(45, 16, NULL, '2025-08-29', 300.00, 0.00, 300.00, 'paid', 1, 0, 0, '2025-08-29 08:49:03', NULL),
(46, 17, NULL, '2025-08-29', 500.00, 0.00, 500.00, 'paid', 1, 0, 0, '2025-08-29 09:10:08', NULL),
(47, 18, NULL, '2025-08-30', 350.00, 350.00, 0.00, 'paid', 1, 0, 0, '2025-08-30 10:47:16', NULL),
(48, 19, NULL, '2025-09-01', 350.00, 200.00, 150.00, 'paid', 1, 0, 0, '2025-09-01 04:36:58', NULL),
(49, 20, NULL, '2025-09-04', 350.00, 350.00, 0.00, 'paid', 1, 0, 0, '2025-09-01 12:29:32', NULL),
(50, 21, NULL, '2025-09-05', 350.00, 250.00, 100.00, 'paid', 1, 0, 0, '2025-09-05 10:07:15', NULL),
(51, 22, NULL, '2025-09-13', 1049.00, 1000.00, 49.00, 'paid', 1, 0, 0, '2025-09-13 05:08:37', NULL),
(52, 23, NULL, '2026-01-31', 599.00, 599.00, 0.00, 'paid', 1, 1, 0, '2026-01-31 17:43:24', NULL),
(53, 24, 1, '2026-02-09', 1500.00, 0.00, 1500.00, '', 1, 1, 0, '2026-02-09 08:54:12', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bill_packages`
--

CREATE TABLE `bill_packages` (
  `id` int(11) NOT NULL,
  `bill_id` int(11) DEFAULT NULL,
  `package_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bill_packages`
--

INSERT INTO `bill_packages` (`id`, `bill_id`, `package_id`) VALUES
(2, 5, 3),
(10, 6, 5),
(14, 8, 5),
(19, 11, 8),
(20, 20, 9),
(21, 21, 9),
(22, 22, 9),
(25, 24, 11),
(28, 27, 11),
(29, 32, 7),
(30, 36, 12),
(32, 52, 7),
(33, 53, 12);

-- --------------------------------------------------------

--
-- Table structure for table `bill_tests`
--

CREATE TABLE `bill_tests` (
  `id` int(11) NOT NULL,
  `bill_id` int(11) DEFAULT NULL,
  `test_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(35, 19, 29),
(36, 23, 4),
(37, 25, 8),
(38, 25, 9),
(39, 25, 28),
(52, 26, 8),
(53, 26, 9),
(54, 26, 28),
(56, 27, 37),
(57, 28, 37),
(58, 28, 1),
(59, 29, 38),
(60, 30, 39),
(61, 31, 4),
(64, 33, 1),
(65, 33, 6),
(66, 34, 2),
(67, 35, 1),
(68, 35, 4),
(69, 37, 1),
(70, 38, 1),
(71, 39, 1),
(72, 40, 1),
(73, 41, 1),
(76, 42, 1),
(78, 43, 27),
(79, 43, 3),
(80, 43, 8),
(81, 43, 9),
(88, 44, 2),
(91, 45, 30),
(92, 46, 4),
(93, 47, 1),
(94, 48, 1),
(96, 49, 1),
(97, 50, 1),
(98, 51, 1);

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
  `notes` text DEFAULT NULL,
  `interpretations` text DEFAULT NULL,
  `signature_id` int(11) DEFAULT NULL,
  `stamp_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lab_test_parameters`
--

CREATE TABLE `lab_test_parameters` (
  `id` int(11) NOT NULL,
  `test_id` int(11) DEFAULT NULL,
  `parameter_id` int(11) DEFAULT NULL,
  `param_order` int(11) DEFAULT 0,
  `section_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `package_template`
--

CREATE TABLE `package_template` (
  `test_id` int(11) NOT NULL,
  `header_html` text DEFAULT NULL,
  `interpretation` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `table_format` varchar(50) DEFAULT NULL,
  `group_by` tinyint(1) DEFAULT NULL,
  `show_method` tinyint(1) DEFAULT NULL,
  `show_interpretation` tinyint(1) DEFAULT NULL,
  `show_notes` tinyint(1) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `package_templates`
--

CREATE TABLE `package_templates` (
  `template_id` int(11) NOT NULL,
  `test_id` int(11) DEFAULT NULL,
  `template_name` varchar(100) DEFAULT NULL,
  `header_html` text DEFAULT NULL,
  `interpretation` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `table_format` varchar(50) DEFAULT NULL,
  `group_by` tinyint(1) DEFAULT NULL,
  `show_method` tinyint(1) DEFAULT NULL,
  `show_interpretation` tinyint(1) DEFAULT NULL,
  `show_notes` tinyint(1) DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT 0,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `package_tests`
--

CREATE TABLE `package_tests` (
  `id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `test_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `package_test_map`
--

CREATE TABLE `package_test_map` (
  `id` int(11) NOT NULL,
  `package_id` int(11) DEFAULT NULL,
  `test_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `reference_text` text DEFAULT NULL,
  `use_reference_text` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `patient_id` int(11) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `gender` enum('male','female','other') DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `age` text NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `dr_ref` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`patient_id`, `full_name`, `gender`, `date_of_birth`, `age`, `phone`, `dr_ref`, `email`, `address`, `created_at`, `photo`) VALUES
(1, 'Ravi Kumar', 'male', '1985-07-10', '', '9876543210', NULL, 'ravi@example.com', 'Vizag', '2025-05-14 07:34:17', NULL),
(2, 'Sita Devi', 'female', '1992-03-22', '', '9876500001', NULL, 'sita@example.com', 'Vizag', '2025-05-14 07:34:17', NULL),
(3, 'Kiran Reddy', 'male', '2005-09-15', '', '9876567890', NULL, 'kiran@example.com', 'Vizag', '2025-05-14 07:34:17', NULL),
(4, 'Ramesh', 'male', '2000-01-10', '', '787887878', NULL, NULL, 'vsp', '2025-05-21 10:37:39', NULL),
(5, 'Rajesh', 'male', '2001-02-10', '', '898989899', NULL, NULL, 'VSP', '2025-05-21 11:03:18', NULL),
(6, 'Sunil', 'male', '2005-05-17', '', '9787887887', NULL, NULL, 'VSP', '2025-05-21 11:34:22', NULL),
(7, 'Mukesh', 'male', '1999-10-10', '', '989898999', NULL, NULL, 'VZM', '2025-05-21 11:35:23', NULL),
(8, 'Rajesh Rai', 'male', '2000-01-02', '', '788787878', NULL, NULL, 'gajuwaka', '2025-05-21 12:06:28', NULL),
(9, 'Laxmi ', 'female', '2000-01-10', '', '7878787878', NULL, NULL, 'VSP', '2025-05-21 12:07:27', NULL),
(10, 'Kumar', 'male', '1999-05-10', '', '98656866588', NULL, NULL, 'gwk', '2025-05-21 12:08:26', NULL),
(11, 'L Rama Rao', 'male', '2001-07-04', '', '7702271571', NULL, NULL, '', '2025-07-04 08:39:20', NULL),
(12, 'L Rama Rao', 'male', '2001-07-04', '', '7702271571', NULL, NULL, '', '2025-07-04 08:39:26', NULL),
(13, 'L Rama Rao', 'male', '1983-08-04', '', '7702271571', NULL, NULL, 'Ichapuram ', '2025-08-04 13:43:59', NULL),
(14, 'TEST', 'male', '1990-02-16', '', '9848055623', NULL, NULL, 'VISAKHAPATNAM ', '2025-08-27 13:21:14', NULL),
(15, 'Sudheer', 'male', NULL, '40', '7887877888', '', NULL, 'VSP', '2025-08-29 06:30:35', NULL),
(16, 'Kiran', 'male', NULL, '25', '1245445455', 'Sudheer', NULL, 'VSP', '2025-08-29 08:49:03', NULL),
(17, 'Kiran', 'male', NULL, '25', '1245445455', 'Sudheer', NULL, 'VSP', '2025-08-29 09:10:08', NULL),
(18, 'rehaman', 'male', NULL, '40', '9393782785', 'Ramesh', NULL, 'VSP', '2025-08-30 10:47:16', NULL),
(19, 'L Rama Rao', 'male', NULL, '25', '7702271571', '', NULL, 'VSP', '2025-09-01 04:36:58', NULL),
(20, 'L Rama Rao', 'male', NULL, '26', '7702271571', 'Gopi', NULL, 'Ipm', '2025-09-01 12:29:32', NULL),
(21, 'Rehaman', 'male', NULL, '25', '7989169700', 'Sunil', NULL, 'VSP', '2025-09-05 10:07:15', NULL),
(22, 'L Rama Rao', 'male', NULL, '25', '7702271571', '', NULL, 'Vsp', '2025-09-13 05:08:37', NULL),
(23, 'Kiran', 'male', NULL, '25', '1245445455', 'Sudheer', NULL, 'VSP', '2026-01-31 17:43:24', NULL),
(24, 'RAJU', 'male', NULL, '50', '9099099090', 'GOPI', NULL, 'VSP', '2026-02-09 08:54:12', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `patient_extra_info`
--

CREATE TABLE `patient_extra_info` (
  `id` int(11) NOT NULL,
  `bill_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `field_id` int(11) NOT NULL,
  `field_value` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `patient_extra_info`
--

INSERT INTO `patient_extra_info` (`id`, `bill_id`, `patient_id`, `field_id`, `field_value`) VALUES
(9, 42, 3, 1, 'SURESH KUMAR'),
(10, 42, 3, 2, 'd4545454'),
(11, 42, 3, 3, 'VSP'),
(12, 42, 3, 4, 'PLUMBER'),
(17, 43, 14, 1, 'TEST'),
(18, 43, 14, 2, 'U3256251'),
(19, 43, 14, 3, 'VISAKHAPATNAM '),
(20, 43, 14, 4, 'WELDER'),
(21, 53, 24, 1, 'KISHORE'),
(22, 53, 24, 2, '125455'),
(23, 53, 24, 3, 'VIZAG'),
(24, 53, 24, 4, 'FITTER');

-- --------------------------------------------------------

--
-- Table structure for table `patient_formats`
--

CREATE TABLE `patient_formats` (
  `format_id` int(11) NOT NULL,
  `type_id` int(11) DEFAULT NULL,
  `format_name` varchar(100) DEFAULT NULL,
  `template_html` mediumtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `is_first_page` tinyint(1) DEFAULT 0,
  `template_json` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `patient_formats`
--

INSERT INTO `patient_formats` (`format_id`, `type_id`, `format_name`, `template_html`, `created_at`, `is_first_page`, `template_json`) VALUES
(1, NULL, 'Dubai Test', '', '2025-08-27 07:59:28', 0, NULL),
(2, NULL, 'Dubai Test', NULL, '2025-08-27 09:40:06', 1, '{\r\n  \"is_first_page\": true,\r\n  \"photo\": true,\r\n  \"qr\": true,\r\n  \"table_style\": {\r\n    \"border\": \"1px solid #000\",\r\n    \"font\": \"Arial\",\r\n    \"font_size\": 10,\r\n    \"cell_padding\": 2\r\n  },\r\n  \"fields_left\": [\r\n    {\"field_name\": \"full_name\", \"label\": \"CANDIDATE NAME\", \"type\": \"text\"},\r\n    {\"field_name\": \"date_of_birth\", \"label\": \"DATE OF BIRTH\", \"type\": \"text\"},\r\n    {\"field_name\": \"age_gender\", \"label\": \"AGE / GENDER\", \"type\": \"text\"},\r\n    {\"field_name\": \"marital_status\", \"label\": \"MARITAL STATUS\", \"type\": \"text\"},\r\n    {\"field_name\": \"passport_no\", \"label\": \"PASSPORT NO\", \"type\": \"text\"},\r\n    {\"field_name\": \"place_of_issue\", \"label\": \"PLACE OF ISSUE\", \"type\": \"text\"},\r\n    {\"field_name\": \"nationality\", \"label\": \"NATIONALITY\", \"type\": \"text\"},\r\n    {\"field_name\": \"post_applied_for\", \"label\": \"POST APPLIED FOR\", \"type\": \"text\"},\r\n    {\"field_name\": \"country\", \"label\": \"COUNTRY\", \"type\": \"text\"}\r\n  ],\r\n  \"fields_right\": [\r\n    {\"field_name\": \"regd_no\", \"label\": \"REGD.NO\", \"type\": \"text\"},\r\n    {\"field_name\": \"exam_date\", \"label\": \"EXAM Dt\", \"type\": \"text\"}\r\n  ]\r\n}\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `patient_info_templates`
--

CREATE TABLE `patient_info_templates` (
  `template_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `template_name` varchar(100) DEFAULT NULL,
  `header_html` text DEFAULT NULL,
  `body_html` text DEFAULT NULL,
  `footer_html` text DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT 0,
  `updated_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patient_types`
--

CREATE TABLE `patient_types` (
  `type_id` int(11) NOT NULL,
  `type_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `template_format` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `patient_types`
--

INSERT INTO `patient_types` (`type_id`, `type_name`, `description`, `created_at`, `template_format`) VALUES
(1, 'Dubai_test', 'Khatar', '2025-08-22 07:30:48', '<p>&lt;?php<br>// db.php (include your connection)<br>include \'db.php\';</p><p>// Example: fetch candidate details<br>$id = 1; // you can pass dynamically<br>$query = $conn-&gt;query(\"SELECT * FROM candidates WHERE id = $id\");<br>$data = $query-&gt;fetch_assoc();<br>?&gt;</p><p>&lt;!DOCTYPE html&gt;<br>&lt;html lang=\"en\"&gt;<br>&lt;head&gt;<br>&nbsp;&lt;meta charset=\"UTF-8\"&gt;<br>&nbsp;&lt;title&gt;Candidate Form&lt;/title&gt;<br>&nbsp;&lt;style&gt;<br>&nbsp; &nbsp;table {<br>&nbsp; &nbsp; &nbsp;width: 100%;<br>&nbsp; &nbsp; &nbsp;border-collapse: collapse;<br>&nbsp; &nbsp; &nbsp;font-family: Arial, sans-serif;<br>&nbsp; &nbsp;}<br>&nbsp; &nbsp;td {<br>&nbsp; &nbsp; &nbsp;border: 1px solid black;<br>&nbsp; &nbsp; &nbsp;padding: 6px;<br>&nbsp; &nbsp; &nbsp;vertical-align: top;<br>&nbsp; &nbsp;}<br>&nbsp; &nbsp;.photo-box {<br>&nbsp; &nbsp; &nbsp;width: 120px;<br>&nbsp; &nbsp; &nbsp;height: 150px;<br>&nbsp; &nbsp; &nbsp;border: 1px solid #000;<br>&nbsp; &nbsp; &nbsp;text-align: center;<br>&nbsp; &nbsp; &nbsp;vertical-align: middle;<br>&nbsp; &nbsp;}<br>&nbsp; &nbsp;.photo-box img {<br>&nbsp; &nbsp; &nbsp;max-width: 100%;<br>&nbsp; &nbsp; &nbsp;max-height: 100%;<br>&nbsp; &nbsp;}<br>&nbsp; &nbsp;.right-col {<br>&nbsp; &nbsp; &nbsp;text-align: left;<br>&nbsp; &nbsp; &nbsp;vertical-align: top;<br>&nbsp; &nbsp; &nbsp;padding: 10px;<br>&nbsp; &nbsp; &nbsp;font-weight: bold;<br>&nbsp; &nbsp;}<br>&nbsp; &nbsp;.colon-col {<br>&nbsp; &nbsp; &nbsp;width: 10px;<br>&nbsp; &nbsp; &nbsp;text-align: center;<br>&nbsp; &nbsp;}<br>&nbsp; &nbsp;.label-col {<br>&nbsp; &nbsp; &nbsp;width: 200px;<br>&nbsp; &nbsp; &nbsp;font-weight: bold;<br>&nbsp; &nbsp;}<br>&nbsp;&lt;/style&gt;<br>&lt;/head&gt;<br>&lt;body&gt;</p><p>&lt;table&gt;<br>&nbsp;&lt;tr&gt;<br>&nbsp; &nbsp;&lt;!-- Left side with photo + details --&gt;<br>&nbsp; &nbsp;&lt;td style=\"width:75%;\"&gt;<br>&nbsp; &nbsp; &nbsp;&lt;table style=\"width:100%; border:none; border-collapse: collapse;\"&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp;&lt;tr&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;td class=\"photo-box\" rowspan=\"10\"&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;?php if(!empty($data[\'photo\'])): ?&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;img src=\"uploads/&lt;?php echo $data[\'photo\']; ?&gt;\" alt=\"Photo\"&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;?php else: ?&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Passport Size Photo<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;?php endif; ?&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;/td&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;td class=\"label-col\"&gt;CANDIDATE NAME&lt;/td&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;td class=\"colon-col\"&gt;:&lt;/td&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;td&gt;&lt;?php echo $data[\'candidate_name\']; ?&gt;&lt;/td&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp;&lt;/tr&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp;&lt;tr&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;td class=\"label-col\"&gt;FATHER NAME&lt;/td&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;td class=\"colon-col\"&gt;:&lt;/td&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;td&gt;&lt;?php echo $data[\'father_name\']; ?&gt;&lt;/td&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp;&lt;/tr&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp;&lt;tr&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;td class=\"label-col\"&gt;DATE OF BIRTH&lt;/td&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;td class=\"colon-col\"&gt;:&lt;/td&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;td&gt;&lt;?php echo $data[\'dob\']; ?&gt;&lt;/td&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp;&lt;/tr&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp;&lt;tr&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;td class=\"label-col\"&gt;AGE / SEX&lt;/td&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;td class=\"colon-col\"&gt;:&lt;/td&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;td&gt;&lt;?php echo $data[\'age\'].\" / \".$data[\'sex\']; ?&gt;&lt;/td&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp;&lt;/tr&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp;&lt;tr&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;td class=\"label-col\"&gt;MARITAL STATUS&lt;/td&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;td class=\"colon-col\"&gt;:&lt;/td&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;td&gt;&lt;?php echo $data[\'marital_status\']; ?&gt;&lt;/td&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp;&lt;/tr&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp;&lt;tr&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;td class=\"label-col\"&gt;PASSPORT NO.&lt;/td&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;td class=\"colon-col\"&gt;:&lt;/td&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;td&gt;&lt;?php echo $data[\'passport_no\']; ?&gt;&lt;/td&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp;&lt;/tr&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp;&lt;tr&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;td class=\"label-col\"&gt;PLACE OF ISSUE&lt;/td&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;td class=\"colon-col\"&gt;:&lt;/td&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;td&gt;&lt;?php echo $data[\'place_issue\']; ?&gt;&lt;/td&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp;&lt;/tr&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp;&lt;tr&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;td class=\"label-col\"&gt;NATIONALITY&lt;/td&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;td class=\"colon-col\"&gt;:&lt;/td&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;td&gt;&lt;?php echo $data[\'nationality\']; ?&gt;&lt;/td&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp;&lt;/tr&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp;&lt;tr&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;td class=\"label-col\"&gt;POST APPLIED FOR&lt;/td&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;td class=\"colon-col\"&gt;:&lt;/td&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;td&gt;&lt;?php echo $data[\'post_applied\']; ?&gt;&lt;/td&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp;&lt;/tr&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp;&lt;tr&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;td class=\"label-col\"&gt;COUNTRY&lt;/td&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;td class=\"colon-col\"&gt;:&lt;/td&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;td&gt;&lt;?php echo $data[\'country\']; ?&gt;&lt;/td&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp;&lt;/tr&gt;<br>&nbsp; &nbsp; &nbsp;&lt;/table&gt;<br>&nbsp; &nbsp;&lt;/td&gt;</p><p>&nbsp; &nbsp;&lt;!-- Right side with Regd. No &amp; Date --&gt;<br>&nbsp; &nbsp;&lt;td class=\"right-col\"&gt;<br>&nbsp; &nbsp; &nbsp;Regd. No: &lt;?php echo $data[\'reg_no\']; ?&gt;&lt;br&gt;<br>&nbsp; &nbsp; &nbsp;Date: &lt;?php echo $data[\'reg_date\']; ?&gt;<br>&nbsp; &nbsp;&lt;/td&gt;<br>&nbsp;&lt;/tr&gt;<br>&lt;/table&gt;</p><p>&lt;/body&gt;<br>&lt;/html&gt;<br>&nbsp;</p>');

-- --------------------------------------------------------

--
-- Table structure for table `patient_type_fields`
--

CREATE TABLE `patient_type_fields` (
  `field_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `field_name` varchar(100) NOT NULL,
  `field_label` varchar(150) NOT NULL,
  `field_type` enum('text','number','date','file','dropdown','hidden') DEFAULT 'text',
  `is_required` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `patient_type_fields`
--

INSERT INTO `patient_type_fields` (`field_id`, `type_id`, `field_name`, `field_label`, `field_type`, `is_required`) VALUES
(1, 1, 'father_name', 'FATHER NAME', 'text', 0),
(2, 1, 'passport_number', 'PASSPORT NUMBER', 'text', 0),
(3, 1, 'passport_issue_place', 'PASSPORT ISSUED AT', 'text', 0),
(4, 1, 'post_applied_for', 'POST APPLIED FOR', 'text', 0);

-- --------------------------------------------------------

--
-- Table structure for table `report_headers`
--

CREATE TABLE `report_headers` (
  `id` int(11) NOT NULL,
  `template_name` varchar(100) DEFAULT NULL,
  `layout_json` longtext DEFAULT NULL,
  `is_default` tinyint(4) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `report_templates`
--

CREATE TABLE `report_templates` (
  `template_id` int(11) NOT NULL,
  `patient_type_id` int(11) NOT NULL,
  `template_name` varchar(150) NOT NULL,
  `version` int(11) DEFAULT 1,
  `is_active` tinyint(4) DEFAULT 1,
  `layout_json` longtext DEFAULT NULL,
  `header_layout_json` text DEFAULT NULL,
  `signature_layout_json` text DEFAULT NULL,
  `is_hardcoded_format` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `report_templates`
--

INSERT INTO `report_templates` (`template_id`, `patient_type_id`, `template_name`, `version`, `is_active`, `layout_json`, `header_layout_json`, `signature_layout_json`, `is_hardcoded_format`, `created_at`, `updated_at`) VALUES
(1, 1, 'Dubai_test', 3, 1, '{\"columns\":[{\"key\":\"param_name\",\"label\":\"Test Description\",\"width\":\"45\"},{\"key\":\"result\",\"label\":\"Result\",\"width\":\"15\"},{\"key\":\"unit\",\"label\":\"Unit\",\"width\":\"15\"},{\"key\":\"reference\",\"label\":\"Reference\",\"width\":\"45\"}],\"method_under_test\":true,\"method_font_size\":\"small\",\"method_italic\":false,\"method_color\":\"#666666\",\"show_border\":true,\"striped_rows\":true}', '{\"rows\":[{\"type\":\"row\",\"columns\":[{\"type\":\"field\",\"field\":\"patient_name\",\"label\":\"Patient Name\",\"width\":\"1 1 50%\"},{\"type\":\"field\",\"field\":\"patient_id\",\"label\":\"Patient ID\",\"width\":\"1 1 50%\"}]},{\"type\":\"row\",\"columns\":[{\"type\":\"field\",\"field\":\"age_gender\",\"label\":\"Age / Gender\",\"width\":\"1 1 33%\"},{\"type\":\"field\",\"field\":\"sample_date\",\"label\":\"Sample Date\",\"width\":\"1 1 33%\"},{\"type\":\"field\",\"field\":\"report_date\",\"label\":\"Report Date\",\"width\":\"1 1 34%\"}]}]}', '{\"show_qr\":true,\"qr_position\":\"right\",\"qr_size\":\"medium\",\"signatures\":[{\"type\":\"doctor\",\"name\":\"Dr. John Smith\",\"designation\":\"Lab Director\",\"position\":\"left\"},{\"type\":\"technician\",\"name\":\"Jane Doe\",\"designation\":\"Lab Technician\",\"position\":\"right\"}],\"footer_text\":\"This is a computer generated report.\",\"show_page_number\":true}', 0, '2026-02-10 09:22:44', '2026-02-10 10:39:00'),
(2, 0, 'a', 1, 1, '{\"type\":\"hardcoded_format\",\"columns\":[{\"key\":\"param_name\",\"label\":\"TEST DESCRIPTION\",\"width\":\"45%\"},{\"key\":\"result\",\"label\":\"RESULT\",\"width\":\"15%\"},{\"key\":\"unit\",\"label\":\"UNIT\",\"width\":\"10%\"},{\"key\":\"reference\",\"label\":\"REFERENCE RANGE\",\"width\":\"30%\"}],\"header_layout\":{\"type\":\"hardcoded\",\"rows\":[{\"columns\":[{\"field\":\"patient_name\",\"label\":\"Name\"},{\"field\":\"bill_id\",\"label\":\"Bill No.\"}]},{\"columns\":[{\"field\":\"age_gender\",\"label\":\"Age/Gender\"},{\"field\":\"bill_date\",\"label\":\"Registered Date\"}]},{\"columns\":[{\"field\":\"dr_ref\",\"label\":\"Referred By\"},{\"field\":\"report_date\",\"label\":\"Reported Date\"}]}]},\"signature_layout\":{\"show_qr\":true,\"qr_position\":\"left\",\"show_signature\":true,\"signature_position\":\"right\",\"footer_text\":\"This is a computer generated report.\"},\"method_under_test\":false,\"show_border\":true,\"pagebreak_per_test\":false,\"include_notes\":true,\"include_interpretation\":true,\"include_method\":false}', NULL, NULL, 1, '2026-02-10 12:04:03', '2026-02-10 12:04:03');

-- --------------------------------------------------------

--
-- Table structure for table `report_template_columns`
--

CREATE TABLE `report_template_columns` (
  `column_id` int(11) NOT NULL,
  `template_id` int(11) DEFAULT NULL,
  `column_key` varchar(50) DEFAULT NULL,
  `column_order` int(11) DEFAULT NULL,
  `is_enabled` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `report_template_sections`
--

CREATE TABLE `report_template_sections` (
  `section_id` int(11) NOT NULL,
  `template_id` int(11) DEFAULT NULL,
  `section_key` varchar(50) DEFAULT NULL,
  `display_order` int(11) DEFAULT NULL,
  `is_enabled` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `report_template_versions`
--

CREATE TABLE `report_template_versions` (
  `id` int(11) NOT NULL,
  `template_id` int(11) DEFAULT NULL,
  `version` int(11) DEFAULT NULL,
  `layout_json` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `sign_master`
--

CREATE TABLE `sign_master` (
  `id` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'Doctor',
  `qualification` varchar(255) NOT NULL DEFAULT '',
  `signimage` varchar(255) DEFAULT NULL,
  `stampimage` varchar(255) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sign_master`
--

INSERT INTO `sign_master` (`id`, `Name`, `role`, `qualification`, `signimage`, `stampimage`, `status`) VALUES
(1, 'N Srinivas Rao', 'Doctor', 'MBBS, MD (Pathology)', 'nsrsign.png', 'reddy.png', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `template_version_history`
--

CREATE TABLE `template_version_history` (
  `version_id` int(11) NOT NULL,
  `template_id` int(11) NOT NULL,
  `version` int(11) NOT NULL,
  `layout_json` text DEFAULT NULL,
  `header_layout_json` text DEFAULT NULL,
  `signature_layout_json` text DEFAULT NULL,
  `change_description` varchar(500) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `template_version_history`
--

INSERT INTO `template_version_history` (`version_id`, `template_id`, `version`, `layout_json`, `header_layout_json`, `signature_layout_json`, `change_description`, `created_at`) VALUES
(1, 1, 1, '{\"columns\":[{\"key\":\"param_name\",\"label\":\"Test Description\",\"width\":\"45\"},{\"key\":\"result\",\"label\":\"Result\",\"width\":\"15\"},{\"key\":\"unit\",\"label\":\"Unit\",\"width\":\"15\"},{\"key\":\"reference\",\"label\":\"Reference\",\"width\":\"45\"}],\"method_under_test\":true,\"method_font_size\":\"small\",\"method_italic\":false,\"method_color\":\"#666666\",\"show_border\":true,\"striped_rows\":true}', '{\"rows\":[{\"type\":\"row\",\"columns\":[{\"type\":\"field\",\"field\":\"patient_name\",\"label\":\"Patient Name\",\"width\":\"1 1 50%\"},{\"type\":\"field\",\"field\":\"patient_id\",\"label\":\"Patient ID\",\"width\":\"1 1 50%\"}]},{\"type\":\"row\",\"columns\":[{\"type\":\"field\",\"field\":\"age_gender\",\"label\":\"Age / Gender\",\"width\":\"1 1 33%\"},{\"type\":\"field\",\"field\":\"sample_date\",\"label\":\"Sample Date\",\"width\":\"1 1 33%\"},{\"type\":\"field\",\"field\":\"report_date\",\"label\":\"Report Date\",\"width\":\"1 1 34%\"}]}]}', '{\"show_qr\":true,\"qr_position\":\"right\",\"qr_size\":\"medium\",\"signatures\":[{\"type\":\"doctor\",\"name\":\"Dr. John Smith\",\"designation\":\"Lab Director\",\"position\":\"left\"},{\"type\":\"technician\",\"name\":\"Jane Doe\",\"designation\":\"Lab Technician\",\"position\":\"right\"}],\"footer_text\":\"This is a computer generated report.\",\"show_page_number\":true}', 'Updated template', '2026-02-10 10:36:26'),
(2, 1, 1, '{\"columns\":[{\"key\":\"param_name\",\"label\":\"Test Description\",\"width\":\"45\"},{\"key\":\"result\",\"label\":\"Result\",\"width\":\"15\"},{\"key\":\"unit\",\"label\":\"Unit\",\"width\":\"15\"},{\"key\":\"reference\",\"label\":\"Reference\",\"width\":\"45\"}],\"method_under_test\":true,\"method_font_size\":\"small\",\"method_italic\":false,\"method_color\":\"#666666\",\"show_border\":true,\"striped_rows\":true}', '{\"rows\":[{\"type\":\"row\",\"columns\":[{\"type\":\"field\",\"field\":\"patient_name\",\"label\":\"Patient Name\",\"width\":\"1 1 50%\"},{\"type\":\"field\",\"field\":\"patient_id\",\"label\":\"Patient ID\",\"width\":\"1 1 50%\"}]},{\"type\":\"row\",\"columns\":[{\"type\":\"field\",\"field\":\"age_gender\",\"label\":\"Age / Gender\",\"width\":\"1 1 33%\"},{\"type\":\"field\",\"field\":\"sample_date\",\"label\":\"Sample Date\",\"width\":\"1 1 33%\"},{\"type\":\"field\",\"field\":\"report_date\",\"label\":\"Report Date\",\"width\":\"1 1 34%\"}]}]}', '{\"show_qr\":true,\"qr_position\":\"right\",\"qr_size\":\"medium\",\"signatures\":[{\"type\":\"doctor\",\"name\":\"Dr. John Smith\",\"designation\":\"Lab Director\",\"position\":\"left\"},{\"type\":\"technician\",\"name\":\"Jane Doe\",\"designation\":\"Lab Technician\",\"position\":\"right\"}],\"footer_text\":\"This is a computer generated report.\",\"show_page_number\":true}', 'Updated template', '2026-02-10 10:36:31'),
(3, 1, 1, '{\"columns\":[{\"key\":\"param_name\",\"label\":\"Test Description\",\"width\":\"45\"},{\"key\":\"result\",\"label\":\"Result\",\"width\":\"15\"},{\"key\":\"unit\",\"label\":\"Unit\",\"width\":\"15\"},{\"key\":\"reference\",\"label\":\"Reference\",\"width\":\"45\"}],\"method_under_test\":true,\"method_font_size\":\"small\",\"method_italic\":false,\"method_color\":\"#666666\",\"show_border\":true,\"striped_rows\":true}', '{\"rows\":[{\"type\":\"row\",\"columns\":[{\"type\":\"field\",\"field\":\"patient_name\",\"label\":\"Patient Name\",\"width\":\"1 1 50%\"},{\"type\":\"field\",\"field\":\"patient_id\",\"label\":\"Patient ID\",\"width\":\"1 1 50%\"}]},{\"type\":\"row\",\"columns\":[{\"type\":\"field\",\"field\":\"age_gender\",\"label\":\"Age / Gender\",\"width\":\"1 1 33%\"},{\"type\":\"field\",\"field\":\"sample_date\",\"label\":\"Sample Date\",\"width\":\"1 1 33%\"},{\"type\":\"field\",\"field\":\"report_date\",\"label\":\"Report Date\",\"width\":\"1 1 34%\"}]}]}', '{\"show_qr\":true,\"qr_position\":\"right\",\"qr_size\":\"medium\",\"signatures\":[{\"type\":\"doctor\",\"name\":\"Dr. John Smith\",\"designation\":\"Lab Director\",\"position\":\"left\"},{\"type\":\"technician\",\"name\":\"Jane Doe\",\"designation\":\"Lab Technician\",\"position\":\"right\"}],\"footer_text\":\"This is a computer generated report.\",\"show_page_number\":true}', 'Updated template', '2026-02-10 10:36:36'),
(4, 1, 1, '{\"columns\":[{\"key\":\"param_name\",\"label\":\"Test Description\",\"width\":\"45\"},{\"key\":\"result\",\"label\":\"Result\",\"width\":\"15\"},{\"key\":\"unit\",\"label\":\"Unit\",\"width\":\"15\"},{\"key\":\"reference\",\"label\":\"Reference\",\"width\":\"45\"}],\"method_under_test\":true,\"method_font_size\":\"small\",\"method_italic\":false,\"method_color\":\"#666666\",\"show_border\":true,\"striped_rows\":true}', '{\"rows\":[{\"type\":\"row\",\"columns\":[{\"type\":\"field\",\"field\":\"patient_name\",\"label\":\"Patient Name\",\"width\":\"1 1 50%\"},{\"type\":\"field\",\"field\":\"patient_id\",\"label\":\"Patient ID\",\"width\":\"1 1 50%\"}]},{\"type\":\"row\",\"columns\":[{\"type\":\"field\",\"field\":\"age_gender\",\"label\":\"Age / Gender\",\"width\":\"1 1 33%\"},{\"type\":\"field\",\"field\":\"sample_date\",\"label\":\"Sample Date\",\"width\":\"1 1 33%\"},{\"type\":\"field\",\"field\":\"report_date\",\"label\":\"Report Date\",\"width\":\"1 1 34%\"}]}]}', '{\"show_qr\":true,\"qr_position\":\"right\",\"qr_size\":\"medium\",\"signatures\":[{\"type\":\"doctor\",\"name\":\"Dr. John Smith\",\"designation\":\"Lab Director\",\"position\":\"left\"},{\"type\":\"technician\",\"name\":\"Jane Doe\",\"designation\":\"Lab Technician\",\"position\":\"right\"}],\"footer_text\":\"This is a computer generated report.\",\"show_page_number\":true}', 'Updated template', '2026-02-10 10:37:27'),
(5, 1, 1, '{\"columns\":[{\"key\":\"param_name\",\"label\":\"Test Description\",\"width\":\"45\"},{\"key\":\"result\",\"label\":\"Result\",\"width\":\"15\"},{\"key\":\"unit\",\"label\":\"Unit\",\"width\":\"15\"},{\"key\":\"reference\",\"label\":\"Reference\",\"width\":\"45\"}],\"method_under_test\":true,\"method_font_size\":\"small\",\"method_italic\":false,\"method_color\":\"#666666\",\"show_border\":true,\"striped_rows\":true}', '{\"rows\":[{\"type\":\"row\",\"columns\":[{\"type\":\"field\",\"field\":\"patient_name\",\"label\":\"Patient Name\",\"width\":\"1 1 50%\"},{\"type\":\"field\",\"field\":\"patient_id\",\"label\":\"Patient ID\",\"width\":\"1 1 50%\"}]},{\"type\":\"row\",\"columns\":[{\"type\":\"field\",\"field\":\"age_gender\",\"label\":\"Age / Gender\",\"width\":\"1 1 33%\"},{\"type\":\"field\",\"field\":\"sample_date\",\"label\":\"Sample Date\",\"width\":\"1 1 33%\"},{\"type\":\"field\",\"field\":\"report_date\",\"label\":\"Report Date\",\"width\":\"1 1 34%\"}]}]}', '{\"show_qr\":true,\"qr_position\":\"right\",\"qr_size\":\"medium\",\"signatures\":[{\"type\":\"doctor\",\"name\":\"Dr. John Smith\",\"designation\":\"Lab Director\",\"position\":\"left\"},{\"type\":\"technician\",\"name\":\"Jane Doe\",\"designation\":\"Lab Technician\",\"position\":\"right\"}],\"footer_text\":\"This is a computer generated report.\",\"show_page_number\":true}', 'Updated template', '2026-02-10 10:37:29'),
(6, 1, 1, '{\"columns\":[{\"key\":\"param_name\",\"label\":\"Test Description\",\"width\":\"45\"},{\"key\":\"result\",\"label\":\"Result\",\"width\":\"15\"},{\"key\":\"unit\",\"label\":\"Unit\",\"width\":\"15\"},{\"key\":\"reference\",\"label\":\"Reference\",\"width\":\"45\"}],\"method_under_test\":true,\"method_font_size\":\"small\",\"method_italic\":false,\"method_color\":\"#666666\",\"show_border\":true,\"striped_rows\":true}', '{\"rows\":[{\"type\":\"row\",\"columns\":[{\"type\":\"field\",\"field\":\"patient_name\",\"label\":\"Patient Name\",\"width\":\"1 1 50%\"},{\"type\":\"field\",\"field\":\"patient_id\",\"label\":\"Patient ID\",\"width\":\"1 1 50%\"}]},{\"type\":\"row\",\"columns\":[{\"type\":\"field\",\"field\":\"age_gender\",\"label\":\"Age / Gender\",\"width\":\"1 1 33%\"},{\"type\":\"field\",\"field\":\"sample_date\",\"label\":\"Sample Date\",\"width\":\"1 1 33%\"},{\"type\":\"field\",\"field\":\"report_date\",\"label\":\"Report Date\",\"width\":\"1 1 34%\"}]}]}', '{\"show_qr\":true,\"qr_position\":\"right\",\"qr_size\":\"medium\",\"signatures\":[{\"type\":\"doctor\",\"name\":\"Dr. John Smith\",\"designation\":\"Lab Director\",\"position\":\"left\"},{\"type\":\"technician\",\"name\":\"Jane Doe\",\"designation\":\"Lab Technician\",\"position\":\"right\"}],\"footer_text\":\"This is a computer generated report.\",\"show_page_number\":true}', 'Updated template', '2026-02-10 10:37:38'),
(7, 1, 1, '{\"columns\":[{\"key\":\"param_name\",\"label\":\"Test Description\",\"width\":\"45\"},{\"key\":\"result\",\"label\":\"Result\",\"width\":\"15\"},{\"key\":\"unit\",\"label\":\"Unit\",\"width\":\"15\"},{\"key\":\"reference\",\"label\":\"Reference\",\"width\":\"45\"}],\"method_under_test\":true,\"method_font_size\":\"small\",\"method_italic\":false,\"method_color\":\"#666666\",\"show_border\":true,\"striped_rows\":true}', '{\"rows\":[{\"type\":\"row\",\"columns\":[{\"type\":\"field\",\"field\":\"patient_name\",\"label\":\"Patient Name\",\"width\":\"1 1 50%\"},{\"type\":\"field\",\"field\":\"patient_id\",\"label\":\"Patient ID\",\"width\":\"1 1 50%\"}]},{\"type\":\"row\",\"columns\":[{\"type\":\"field\",\"field\":\"age_gender\",\"label\":\"Age / Gender\",\"width\":\"1 1 33%\"},{\"type\":\"field\",\"field\":\"sample_date\",\"label\":\"Sample Date\",\"width\":\"1 1 33%\"},{\"type\":\"field\",\"field\":\"report_date\",\"label\":\"Report Date\",\"width\":\"1 1 34%\"}]}]}', '{\"show_qr\":true,\"qr_position\":\"right\",\"qr_size\":\"medium\",\"signatures\":[{\"type\":\"doctor\",\"name\":\"Dr. John Smith\",\"designation\":\"Lab Director\",\"position\":\"left\"},{\"type\":\"technician\",\"name\":\"Jane Doe\",\"designation\":\"Lab Technician\",\"position\":\"right\"}],\"footer_text\":\"This is a computer generated report.\",\"show_page_number\":true}', 'Updated template', '2026-02-10 10:37:57'),
(8, 1, 1, '{\"columns\":[{\"key\":\"param_name\",\"label\":\"Test Description\",\"width\":\"45\"},{\"key\":\"result\",\"label\":\"Result\",\"width\":\"15\"},{\"key\":\"unit\",\"label\":\"Unit\",\"width\":\"15\"},{\"key\":\"reference\",\"label\":\"Reference\",\"width\":\"45\"}],\"method_under_test\":true,\"method_font_size\":\"small\",\"method_italic\":false,\"method_color\":\"#666666\",\"show_border\":true,\"striped_rows\":true}', '{\"rows\":[{\"type\":\"row\",\"columns\":[{\"type\":\"field\",\"field\":\"patient_name\",\"label\":\"Patient Name\",\"width\":\"1 1 50%\"},{\"type\":\"field\",\"field\":\"patient_id\",\"label\":\"Patient ID\",\"width\":\"1 1 50%\"}]},{\"type\":\"row\",\"columns\":[{\"type\":\"field\",\"field\":\"age_gender\",\"label\":\"Age / Gender\",\"width\":\"1 1 33%\"},{\"type\":\"field\",\"field\":\"sample_date\",\"label\":\"Sample Date\",\"width\":\"1 1 33%\"},{\"type\":\"field\",\"field\":\"report_date\",\"label\":\"Report Date\",\"width\":\"1 1 34%\"}]}]}', '{\"show_qr\":true,\"qr_position\":\"right\",\"qr_size\":\"medium\",\"signatures\":[{\"type\":\"doctor\",\"name\":\"Dr. John Smith\",\"designation\":\"Lab Director\",\"position\":\"left\"},{\"type\":\"technician\",\"name\":\"Jane Doe\",\"designation\":\"Lab Technician\",\"position\":\"right\"}],\"footer_text\":\"This is a computer generated report.\",\"show_page_number\":true}', 'Updated template', '2026-02-10 10:37:58'),
(9, 1, 2, '{\"columns\":[{\"key\":\"param_name\",\"label\":\"Test Description\",\"width\":\"45\"},{\"key\":\"result\",\"label\":\"Result\",\"width\":\"15\"},{\"key\":\"unit\",\"label\":\"Unit\",\"width\":\"15\"},{\"key\":\"reference\",\"label\":\"Reference\",\"width\":\"45\"}],\"method_under_test\":true,\"method_font_size\":\"small\",\"method_italic\":false,\"method_color\":\"#666666\",\"show_border\":true,\"striped_rows\":true}', '{\"rows\":[{\"type\":\"row\",\"columns\":[{\"type\":\"field\",\"field\":\"patient_name\",\"label\":\"Patient Name\",\"width\":\"1 1 50%\"},{\"type\":\"field\",\"field\":\"patient_id\",\"label\":\"Patient ID\",\"width\":\"1 1 50%\"}]},{\"type\":\"row\",\"columns\":[{\"type\":\"field\",\"field\":\"age_gender\",\"label\":\"Age / Gender\",\"width\":\"1 1 33%\"},{\"type\":\"field\",\"field\":\"sample_date\",\"label\":\"Sample Date\",\"width\":\"1 1 33%\"},{\"type\":\"field\",\"field\":\"report_date\",\"label\":\"Report Date\",\"width\":\"1 1 34%\"}]}]}', '{\"show_qr\":true,\"qr_position\":\"right\",\"qr_size\":\"medium\",\"signatures\":[{\"type\":\"doctor\",\"name\":\"Dr. John Smith\",\"designation\":\"Lab Director\",\"position\":\"left\"},{\"type\":\"technician\",\"name\":\"Jane Doe\",\"designation\":\"Lab Technician\",\"position\":\"right\"}],\"footer_text\":\"This is a computer generated report.\",\"show_page_number\":true}', 'New version', '2026-02-10 10:38:16'),
(10, 1, 2, '{\"columns\":[{\"key\":\"param_name\",\"label\":\"Test Description\",\"width\":\"45\"},{\"key\":\"result\",\"label\":\"Result\",\"width\":\"15\"},{\"key\":\"unit\",\"label\":\"Unit\",\"width\":\"15\"},{\"key\":\"reference\",\"label\":\"Reference\",\"width\":\"45\"}],\"method_under_test\":true,\"method_font_size\":\"small\",\"method_italic\":false,\"method_color\":\"#666666\",\"show_border\":true,\"striped_rows\":true}', '{\"rows\":[{\"type\":\"row\",\"columns\":[{\"type\":\"field\",\"field\":\"patient_name\",\"label\":\"Patient Name\",\"width\":\"1 1 50%\"},{\"type\":\"field\",\"field\":\"patient_id\",\"label\":\"Patient ID\",\"width\":\"1 1 50%\"}]},{\"type\":\"row\",\"columns\":[{\"type\":\"field\",\"field\":\"age_gender\",\"label\":\"Age / Gender\",\"width\":\"1 1 33%\"},{\"type\":\"field\",\"field\":\"sample_date\",\"label\":\"Sample Date\",\"width\":\"1 1 33%\"},{\"type\":\"field\",\"field\":\"report_date\",\"label\":\"Report Date\",\"width\":\"1 1 34%\"}]}]}', '{\"show_qr\":true,\"qr_position\":\"right\",\"qr_size\":\"medium\",\"signatures\":[{\"type\":\"doctor\",\"name\":\"Dr. John Smith\",\"designation\":\"Lab Director\",\"position\":\"left\"},{\"type\":\"technician\",\"name\":\"Jane Doe\",\"designation\":\"Lab Technician\",\"position\":\"right\"}],\"footer_text\":\"This is a computer generated report.\",\"show_page_number\":true}', 'Updated template', '2026-02-10 10:38:42'),
(11, 1, 3, '{\"columns\":[{\"key\":\"param_name\",\"label\":\"Test Description\",\"width\":\"45\"},{\"key\":\"result\",\"label\":\"Result\",\"width\":\"15\"},{\"key\":\"unit\",\"label\":\"Unit\",\"width\":\"15\"},{\"key\":\"reference\",\"label\":\"Reference\",\"width\":\"45\"}],\"method_under_test\":true,\"method_font_size\":\"small\",\"method_italic\":false,\"method_color\":\"#666666\",\"show_border\":true,\"striped_rows\":true}', '{\"rows\":[{\"type\":\"row\",\"columns\":[{\"type\":\"field\",\"field\":\"patient_name\",\"label\":\"Patient Name\",\"width\":\"1 1 50%\"},{\"type\":\"field\",\"field\":\"patient_id\",\"label\":\"Patient ID\",\"width\":\"1 1 50%\"}]},{\"type\":\"row\",\"columns\":[{\"type\":\"field\",\"field\":\"age_gender\",\"label\":\"Age / Gender\",\"width\":\"1 1 33%\"},{\"type\":\"field\",\"field\":\"sample_date\",\"label\":\"Sample Date\",\"width\":\"1 1 33%\"},{\"type\":\"field\",\"field\":\"report_date\",\"label\":\"Report Date\",\"width\":\"1 1 34%\"}]}]}', '{\"show_qr\":true,\"qr_position\":\"right\",\"qr_size\":\"medium\",\"signatures\":[{\"type\":\"doctor\",\"name\":\"Dr. John Smith\",\"designation\":\"Lab Director\",\"position\":\"left\"},{\"type\":\"technician\",\"name\":\"Jane Doe\",\"designation\":\"Lab Technician\",\"position\":\"right\"}],\"footer_text\":\"This is a computer generated report.\",\"show_page_number\":true}', 'New version', '2026-02-10 10:39:00');

-- --------------------------------------------------------

--
-- Table structure for table `test_categories`
--

CREATE TABLE `test_categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `test_groups`
--

CREATE TABLE `test_groups` (
  `group_id` int(11) NOT NULL,
  `group_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `test_id` int(11) DEFAULT NULL,
  `result_value` varchar(100) DEFAULT NULL,
  `result_date` datetime DEFAULT NULL,
  `tested_by` int(11) DEFAULT NULL,
  `status` varchar(100) NOT NULL,
  `bill_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `test_results`
--

INSERT INTO `test_results` (`result_id`, `sample_id`, `parameter_id`, `test_id`, `result_value`, `result_date`, `tested_by`, `status`, `bill_id`) VALUES
(3, NULL, 151, 3, '2', NULL, NULL, 'Completed', 9),
(4, NULL, 149, 3, '4', NULL, NULL, 'Completed', 9),
(5, NULL, 15, 3, '15', NULL, NULL, 'Completed', 9),
(6, NULL, 12, 3, '5.20', NULL, NULL, 'Completed', 9),
(7, NULL, 147, 3, '5', NULL, NULL, 'Completed', 9),
(8, NULL, 150, 3, '8', NULL, NULL, 'Completed', 9),
(9, NULL, 14, 3, '120.00', NULL, NULL, 'Completed', 9),
(10, NULL, 13, 3, '2.00', NULL, NULL, 'Completed', 9),
(11, NULL, 11, 3, '25.00', NULL, NULL, 'Completed', 9),
(12, NULL, 148, 3, '85', NULL, NULL, 'Completed', 9),
(13, NULL, 111, 12, '9.50', NULL, NULL, 'Completed', 6),
(14, NULL, 154, 1, '16', NULL, NULL, 'Completed', 6),
(15, NULL, 112, 12, '2.00', NULL, NULL, 'Completed', 6),
(16, NULL, 113, 12, '3.50', NULL, NULL, 'Completed', 6),
(17, NULL, 155, NULL, '10', NULL, NULL, 'Completed', 13),
(18, NULL, 154, 1, '15', NULL, NULL, 'Completed', 13),
(19, NULL, 157, 1, '2.5', NULL, NULL, 'Completed', 13),
(20, NULL, 158, 1, '0.5', NULL, NULL, 'Completed', 13),
(21, NULL, 156, 1, '05', NULL, NULL, 'Completed', 13),
(22, NULL, 159, NULL, '21000', NULL, NULL, 'Completed', 13),
(23, NULL, 153, NULL, '120', NULL, NULL, 'Completed', 13),
(24, NULL, 160, NULL, '15', NULL, NULL, 'Completed', 13),
(25, NULL, 152, NULL, '15', NULL, NULL, 'Completed', 13),
(26, NULL, 155, NULL, '15', NULL, NULL, 'Completed', 14),
(27, NULL, 154, 1, '0.2', NULL, NULL, 'Completed', 14),
(28, NULL, 157, 1, '05', NULL, NULL, 'Completed', 14),
(29, NULL, 158, 1, '18', NULL, NULL, 'Completed', 14),
(30, NULL, 156, 1, '18', NULL, NULL, 'Completed', 14),
(31, NULL, 159, NULL, '53', NULL, NULL, 'Completed', 14),
(32, NULL, 153, NULL, '0.2', NULL, NULL, 'Completed', 14),
(33, NULL, 160, NULL, '1000', NULL, NULL, 'Completed', 14),
(34, NULL, 152, NULL, '300', NULL, NULL, 'Completed', 14),
(35, NULL, 151, 3, '10', NULL, NULL, 'Completed', 9),
(36, NULL, 149, 3, '15', NULL, NULL, 'Completed', 9),
(37, NULL, 15, 3, '15', NULL, NULL, 'Completed', 9),
(38, NULL, 12, 3, '5.20', NULL, NULL, 'Completed', 9),
(39, NULL, 147, 3, '2', NULL, NULL, 'Completed', 9),
(40, NULL, 150, 3, '15', NULL, NULL, 'Completed', 9),
(41, NULL, 14, 3, '120.00', NULL, NULL, 'Completed', 9),
(42, NULL, 13, 3, '2.00', NULL, NULL, 'Completed', 9),
(43, NULL, 11, 3, '25.00', NULL, NULL, 'Completed', 9),
(44, NULL, 148, 3, '10', NULL, NULL, 'Completed', 9),
(45, NULL, 155, NULL, 'Normal', NULL, NULL, 'Completed', 15),
(46, NULL, 154, 1, '13.00', NULL, NULL, 'Completed', 15),
(47, NULL, 157, 1, '15', NULL, NULL, 'Completed', 15),
(48, NULL, 158, 1, '', NULL, NULL, 'Completed', 15),
(49, NULL, 156, 1, '', NULL, NULL, 'Completed', 15),
(50, NULL, 159, NULL, '', NULL, NULL, 'Completed', 15),
(51, NULL, 153, NULL, '', NULL, NULL, 'Completed', 15),
(52, NULL, 152, NULL, '', NULL, NULL, 'Completed', 15),
(53, NULL, 155, NULL, 'Negative', NULL, NULL, 'Completed', 13),
(54, NULL, 154, 1, '14.00', NULL, NULL, 'Completed', 13),
(55, NULL, 157, 1, 'Positive', NULL, NULL, 'Completed', 13),
(56, NULL, 158, 1, 'Normal', NULL, NULL, 'Completed', 13),
(57, NULL, 156, 1, '09', NULL, NULL, 'Completed', 13),
(58, NULL, 159, NULL, '9', NULL, NULL, 'Completed', 13),
(59, NULL, 153, NULL, '9', NULL, NULL, 'Completed', 13),
(60, NULL, 152, NULL, '9', NULL, NULL, 'Completed', 13),
(61, NULL, 155, NULL, 'Abnormal', NULL, NULL, 'Completed', 12),
(62, NULL, 154, 1, '14.00', NULL, NULL, 'Completed', 12),
(63, NULL, 157, 1, 'NAD', NULL, NULL, 'Completed', 12),
(64, NULL, 158, 1, '12', NULL, NULL, 'Completed', 12),
(65, NULL, 156, 1, '15', NULL, NULL, 'Completed', 12),
(66, NULL, 159, NULL, '15', NULL, NULL, 'Completed', 12),
(67, NULL, 153, NULL, 'Reactive', NULL, NULL, 'Completed', 12),
(68, NULL, 152, NULL, 'Normal', NULL, NULL, 'Completed', 12),
(69, NULL, 118, 14, '30.00', NULL, NULL, 'Completed', 11),
(70, NULL, 117, 14, '25.00', NULL, NULL, 'Completed', 11),
(71, NULL, 24, 5, 'Absent', NULL, NULL, 'Completed', 11),
(72, NULL, 25, 5, 'Normal', NULL, NULL, 'Completed', 11),
(73, NULL, 23, 5, 'Positive', NULL, NULL, 'Completed', 11),
(74, NULL, 155, NULL, 'NAD', NULL, NULL, 'Completed', 16),
(75, NULL, 154, 1, '14.00', NULL, NULL, 'Completed', 16),
(76, NULL, 157, 1, '15', NULL, NULL, 'Completed', 16),
(77, NULL, 158, 1, 'Positive', NULL, NULL, 'Completed', 16),
(78, NULL, 156, 1, 'Normal', NULL, NULL, 'Completed', 16),
(79, NULL, 159, NULL, 'Non-Reactive', NULL, NULL, 'Completed', 16),
(80, NULL, 153, NULL, 'Positive', NULL, NULL, 'Completed', 16),
(81, NULL, 152, NULL, 'Positive', NULL, NULL, 'Completed', 16),
(130, NULL, 155, NULL, 'Abnormal', NULL, NULL, 'Completed', 17),
(131, NULL, 154, 1, '14.00', NULL, NULL, 'Completed', 17),
(132, NULL, 157, 1, 'Absent', NULL, NULL, 'Completed', 17),
(133, NULL, 158, 1, 'Normal', NULL, NULL, 'Completed', 17),
(134, NULL, 156, 1, 'Normal', NULL, NULL, 'Completed', 17),
(135, NULL, 159, NULL, '15', NULL, NULL, 'Completed', 17),
(136, NULL, 153, NULL, '9', NULL, NULL, 'Completed', 17),
(137, NULL, 152, NULL, 'NAD', NULL, NULL, 'Completed', 17),
(138, NULL, 102, 4, '45.00', NULL, NULL, 'Completed', 18),
(139, NULL, 103, 4, '90.00', NULL, NULL, 'Completed', 18),
(140, NULL, 101, 4, '180.00', NULL, NULL, 'Completed', 18),
(141, NULL, 104, 4, '130.00', NULL, NULL, 'Completed', 18),
(142, NULL, 172, 29, 'Negative', NULL, NULL, 'Completed', 19),
(143, NULL, 155, NULL, 'Positive', NULL, NULL, 'Completed', 20),
(144, NULL, 154, 1, '14.00', NULL, NULL, 'Completed', 20),
(145, NULL, 157, 1, 'Absent', NULL, NULL, 'Completed', 20),
(146, NULL, 158, 1, 'Normal', NULL, NULL, 'Completed', 20),
(147, NULL, 156, 1, 'NAD', NULL, NULL, 'Completed', 20),
(148, NULL, 159, NULL, 'Normal', NULL, NULL, 'Completed', 20),
(149, NULL, 153, NULL, 'Normal', NULL, NULL, 'Completed', 20),
(150, NULL, 152, NULL, 'Absent', NULL, NULL, 'Completed', 20),
(151, NULL, 175, 31, '1.00', NULL, NULL, 'Completed', 20),
(152, NULL, 174, 31, '20.00', NULL, NULL, 'Completed', 20),
(153, NULL, 176, 31, '1.00', NULL, NULL, 'Completed', 20),
(154, NULL, 173, 31, '45.00', NULL, NULL, 'Completed', 20),
(155, NULL, 17, 1, '6000.00', NULL, NULL, 'Completed', 21),
(156, NULL, 177, 1, '4.50', NULL, NULL, 'Completed', 21),
(157, NULL, 154, 1, '14.00', NULL, NULL, 'Completed', 21),
(158, NULL, 178, 1, '40.00', NULL, NULL, 'Completed', 21),
(159, NULL, 156, 1, 'Absent', NULL, NULL, 'Completed', 21),
(160, NULL, 157, 1, 'NAD', NULL, NULL, 'Completed', 21),
(161, NULL, 158, 1, '12', NULL, NULL, 'Completed', 21),
(162, NULL, 19, 1, '1.50', NULL, NULL, 'Completed', 21),
(163, NULL, 173, 31, '45.00', NULL, NULL, 'Completed', 21),
(164, NULL, 174, 31, '20.00', NULL, NULL, 'Completed', 21),
(165, NULL, 175, 31, '1.00', NULL, NULL, 'Completed', 21),
(166, NULL, 176, 31, '1.00', NULL, NULL, 'Completed', 21),
(167, NULL, 17, 1, '6000.00', NULL, NULL, 'Completed', 22),
(168, NULL, 177, 1, '4.50', NULL, NULL, 'Completed', 22),
(169, NULL, 154, 1, '14.00', NULL, NULL, 'Completed', 22),
(170, NULL, 178, 1, '40.00', NULL, NULL, 'Completed', 22),
(171, NULL, 156, 1, 'Normal', NULL, NULL, 'Completed', 22),
(172, NULL, 157, 1, 'Absent', NULL, NULL, 'Completed', 22),
(173, NULL, 158, 1, 'Positive', NULL, NULL, 'Completed', 22),
(174, NULL, 19, 1, '1.50', NULL, NULL, 'Completed', 22),
(175, NULL, 173, 31, '45.00', NULL, NULL, 'Completed', 22),
(176, NULL, 174, 31, '20.00', NULL, NULL, 'Completed', 22),
(177, NULL, 175, 31, '1.00', NULL, NULL, 'Completed', 22),
(178, NULL, 176, 31, '1.00', NULL, NULL, 'Completed', 22),
(223, NULL, 121, 4, '172', NULL, NULL, 'Completed', 23),
(224, NULL, 104, 4, '128', NULL, NULL, 'Completed', 23),
(225, NULL, 122, 4, '43', NULL, NULL, 'Completed', 23),
(226, NULL, 103, 4, '103.40', NULL, NULL, 'Completed', 23),
(227, NULL, 182, 4, '25.6', NULL, NULL, 'Completed', 23),
(267, NULL, 17, 1, '6000.00', NULL, NULL, 'Completed', 10),
(268, NULL, 177, 1, '4.50', NULL, NULL, 'Completed', 10),
(269, NULL, 154, 1, '14.00', NULL, NULL, 'Completed', 10),
(270, NULL, 178, 1, '40.00', NULL, NULL, 'Completed', 10),
(271, NULL, 156, 1, '', NULL, NULL, 'Completed', 10),
(272, NULL, 157, 1, '', NULL, NULL, 'Completed', 10),
(273, NULL, 158, 1, '', NULL, NULL, 'Completed', 10),
(274, NULL, 19, 1, '1.50', NULL, NULL, 'Completed', 10),
(275, NULL, 17, 1, '6000.00', NULL, NULL, 'Completed', 5),
(276, NULL, 177, 1, '4.50', NULL, NULL, 'Completed', 5),
(277, NULL, 154, 1, '13.00', NULL, NULL, 'Completed', 5),
(278, NULL, 178, 1, '40.00', NULL, NULL, 'Completed', 5),
(279, NULL, 156, 1, '', NULL, NULL, 'Completed', 5),
(280, NULL, 157, 1, '', NULL, NULL, 'Completed', 5),
(281, NULL, 158, 1, '', NULL, NULL, 'Completed', 5),
(282, NULL, 19, 1, '1.50', NULL, NULL, 'Completed', 5),
(283, NULL, 11, 3, '0.10', NULL, NULL, 'Completed', 5),
(284, NULL, 12, 3, '4.50', NULL, NULL, 'Completed', 5),
(285, NULL, 143, 3, '0.10', NULL, NULL, 'Completed', 5),
(286, NULL, 144, 3, '0.00', NULL, NULL, 'Completed', 5),
(287, NULL, 145, 3, '0.00', NULL, NULL, 'Completed', 5),
(288, NULL, 147, 3, '8.00', NULL, NULL, 'Completed', 5),
(289, NULL, 15, 3, '42.00', NULL, NULL, 'Completed', 5),
(290, NULL, 148, 3, '6.00', NULL, NULL, 'Completed', 5),
(291, NULL, 149, 3, '3.50', NULL, NULL, 'Completed', 5),
(292, NULL, 150, 3, '2.30', NULL, NULL, 'Completed', 5),
(293, NULL, 151, 3, '1.00', NULL, NULL, 'Completed', 5),
(294, NULL, 172, 29, '0.00', NULL, NULL, 'Completed', 5),
(295, NULL, 17, 1, '6000.00', NULL, NULL, 'Completed', 5),
(296, NULL, 177, 1, '4.50', NULL, NULL, 'Completed', 5),
(297, NULL, 154, 1, '13.00', NULL, NULL, 'Completed', 5),
(298, NULL, 178, 1, '40.00', NULL, NULL, 'Completed', 5),
(299, NULL, 156, 1, '', NULL, NULL, 'Completed', 5),
(300, NULL, 157, 1, '', NULL, NULL, 'Completed', 5),
(301, NULL, 158, 1, '', NULL, NULL, 'Completed', 5),
(302, NULL, 19, 1, '1.50', NULL, NULL, 'Completed', 5),
(303, NULL, 11, 3, '0.10', NULL, NULL, 'Completed', 5),
(304, NULL, 12, 3, '4.50', NULL, NULL, 'Completed', 5),
(305, NULL, 143, 3, '0.10', NULL, NULL, 'Completed', 5),
(306, NULL, 144, 3, '0.00', NULL, NULL, 'Completed', 5),
(307, NULL, 145, 3, '0.00', NULL, NULL, 'Completed', 5),
(308, NULL, 147, 3, '8.00', NULL, NULL, 'Completed', 5),
(309, NULL, 15, 3, '42.00', NULL, NULL, 'Completed', 5),
(310, NULL, 148, 3, '6.00', NULL, NULL, 'Completed', 5),
(311, NULL, 149, 3, '3.50', NULL, NULL, 'Completed', 5),
(312, NULL, 150, 3, '2.30', NULL, NULL, 'Completed', 5),
(313, NULL, 151, 3, '1.00', NULL, NULL, 'Completed', 5),
(314, NULL, 172, 29, '0.00', NULL, NULL, 'Completed', 5),
(315, NULL, 26, 8, 'Negative', NULL, NULL, 'Completed', 26),
(316, NULL, 27, 9, 'Negative', NULL, NULL, 'Completed', 26),
(317, NULL, 21, 2, '15.00', NULL, NULL, 'Completed', 27),
(318, NULL, 20, 2, '0.70', NULL, NULL, 'Completed', 27),
(319, NULL, 22, 2, '3.50', NULL, NULL, 'Completed', 27),
(320, NULL, 111, 2, '9.50', NULL, NULL, 'Completed', 27),
(321, NULL, 184, 2, '2.50', NULL, NULL, 'Completed', 27),
(322, NULL, 11, 3, '0.10', NULL, NULL, 'Completed', 27),
(323, NULL, 12, 3, '4.50', NULL, NULL, 'Completed', 27),
(324, NULL, 143, 3, '0.10', NULL, NULL, 'Completed', 27),
(325, NULL, 144, 3, '0.00', NULL, NULL, 'Completed', 27),
(326, NULL, 145, 3, '0.00', NULL, NULL, 'Completed', 27),
(327, NULL, 147, 3, '8.00', NULL, NULL, 'Completed', 27),
(328, NULL, 15, 3, '42.00', NULL, NULL, 'Completed', 27),
(329, NULL, 148, 3, '6.00', NULL, NULL, 'Completed', 27),
(330, NULL, 149, 3, '3.50', NULL, NULL, 'Completed', 27),
(331, NULL, 150, 3, '2.30', NULL, NULL, 'Completed', 27),
(332, NULL, 151, 3, '1.00', NULL, NULL, 'Completed', 27),
(333, NULL, 121, 4, '0.70', NULL, NULL, 'Completed', 27),
(334, NULL, 104, 4, '120.00', NULL, NULL, 'Completed', 27),
(335, NULL, 122, 4, '0.20', NULL, NULL, 'Completed', 27),
(336, NULL, 103, 4, '85.00', NULL, NULL, 'Completed', 27),
(337, NULL, 182, 4, '6.00', NULL, NULL, 'Completed', 27),
(338, NULL, 185, 33, '0.00', NULL, NULL, 'Completed', 27),
(339, NULL, 186, 33, '0.00', NULL, NULL, 'Completed', 27),
(340, NULL, 187, 33, '0.34', NULL, NULL, 'Completed', 27),
(341, NULL, 189, 37, 'Pale Yellow', NULL, NULL, 'Completed', 27),
(342, NULL, 190, 37, 'Clear', NULL, NULL, 'Completed', 27),
(343, NULL, 191, 37, '4.06', NULL, NULL, 'Completed', 27),
(344, NULL, 192, 37, '1.00', NULL, NULL, 'Completed', 27),
(345, NULL, 193, 37, 'Negative', NULL, NULL, 'Completed', 27),
(346, NULL, 194, 37, 'Normal', NULL, NULL, 'Completed', 27),
(347, NULL, 195, 37, 'Abnormal', NULL, NULL, 'Completed', 27),
(348, NULL, 196, 37, 'Absent', NULL, NULL, 'Completed', 27),
(349, NULL, 197, 37, 'Absent', NULL, NULL, 'Completed', 27),
(350, NULL, 198, 37, '1-2', NULL, NULL, 'Completed', 27),
(351, NULL, 199, 37, '1-2', NULL, NULL, 'Completed', 27),
(352, NULL, 200, 37, 'Absent', NULL, NULL, 'Completed', 27),
(353, NULL, 201, 37, 'NIL', NULL, NULL, 'Completed', 27),
(354, NULL, 202, 37, 'NIL', NULL, NULL, 'Completed', 27),
(355, NULL, 203, 37, 'Absent', NULL, NULL, 'Completed', 27),
(356, NULL, 26, 8, 'Non-Reactive', NULL, NULL, 'Completed', 25),
(357, NULL, 27, 9, 'Non-Reactive', NULL, NULL, 'Completed', 25),
(358, NULL, 17, 1, '6000.00', NULL, NULL, 'Completed', 28),
(359, NULL, 177, 1, '4.50', NULL, NULL, 'Completed', 28),
(360, NULL, 154, 1, '13.00', NULL, NULL, 'Completed', 28),
(361, NULL, 178, 1, '40.00', NULL, NULL, 'Completed', 28),
(362, NULL, 156, 1, 'Abnormal', NULL, NULL, 'Completed', 28),
(363, NULL, 157, 1, 'Normal', NULL, NULL, 'Completed', 28),
(364, NULL, 158, 1, '', NULL, NULL, 'Completed', 28),
(365, NULL, 19, 1, '1.50', NULL, NULL, 'Completed', 28),
(366, NULL, 189, 37, '0.00', NULL, NULL, 'Completed', 28),
(367, NULL, 190, 37, '0.00', NULL, NULL, 'Completed', 28),
(368, NULL, 191, 37, '4.06', NULL, NULL, 'Completed', 28),
(369, NULL, 192, 37, '1.00', NULL, NULL, 'Completed', 28),
(370, NULL, 193, 37, '0.00', NULL, NULL, 'Completed', 28),
(371, NULL, 194, 37, '0.00', NULL, NULL, 'Completed', 28),
(372, NULL, 195, 37, '0.00', NULL, NULL, 'Completed', 28),
(373, NULL, 196, 37, '0.00', NULL, NULL, 'Completed', 28),
(374, NULL, 197, 37, '0.00', NULL, NULL, 'Completed', 28),
(375, NULL, 198, 37, '0.00', NULL, NULL, 'Completed', 28),
(376, NULL, 199, 37, '0.00', NULL, NULL, 'Completed', 28),
(377, NULL, 200, 37, '0.00', NULL, NULL, 'Completed', 28),
(378, NULL, 201, 37, '0.00', NULL, NULL, 'Completed', 28),
(379, NULL, 202, 37, '0.00', NULL, NULL, 'Completed', 28),
(380, NULL, 203, 37, '0.00', NULL, NULL, 'Completed', 28),
(381, NULL, 204, 38, '10TU', NULL, NULL, 'Completed', 29),
(382, NULL, 205, 38, '2', NULL, NULL, 'Completed', 29),
(383, NULL, 206, 38, 'Negative', NULL, NULL, 'Completed', 29),
(384, NULL, 207, 39, '138.00', NULL, NULL, 'Completed', 30),
(385, NULL, 208, 39, '3.50', NULL, NULL, 'Completed', 30),
(386, NULL, 209, 39, '100.00', NULL, NULL, 'Completed', 30),
(387, NULL, 210, 39, '25.00', NULL, NULL, 'Completed', 30),
(388, NULL, 121, 4, '200', NULL, NULL, 'Completed', 31),
(389, NULL, 104, 4, '153', NULL, NULL, 'Completed', 31),
(390, NULL, 122, 4, '0.30', NULL, NULL, 'Completed', 31),
(391, NULL, 103, 4, '90.00', NULL, NULL, 'Completed', 31),
(392, NULL, 182, 4, '6.00', NULL, NULL, 'Completed', 31),
(393, NULL, 21, 2, '15.00', NULL, NULL, 'Completed', 34),
(394, NULL, 20, 2, '0.70', NULL, NULL, 'Completed', 34),
(395, NULL, 22, 2, '3.50', NULL, NULL, 'Completed', 34),
(396, NULL, 111, 2, '9.50', NULL, NULL, 'Completed', 34),
(397, NULL, 184, 2, '2.50', NULL, NULL, 'Completed', 34),
(398, NULL, 17, 1, '6000.00', NULL, NULL, 'Completed', 36),
(399, NULL, 177, 1, '4.50', NULL, NULL, 'Completed', 36),
(400, NULL, 154, 7, '14.00', NULL, NULL, 'Completed', 36),
(401, NULL, 178, 1, '40.00', NULL, NULL, 'Completed', 36),
(402, NULL, 156, 1, 'Abnormal', NULL, NULL, 'Completed', 36),
(403, NULL, 157, 1, 'Positive', NULL, NULL, 'Completed', 36),
(404, NULL, 158, 1, 'Normal', NULL, NULL, 'Completed', 36),
(405, NULL, 19, 1, '1.50', NULL, NULL, 'Completed', 36),
(406, NULL, 21, 2, '15.00', NULL, NULL, 'Completed', 36),
(407, NULL, 20, 2, '0.70', NULL, NULL, 'Completed', 36),
(408, NULL, 22, 2, '3.50', NULL, NULL, 'Completed', 36),
(409, NULL, 111, 2, '9.50', NULL, NULL, 'Completed', 36),
(410, NULL, 184, 2, '2.50', NULL, NULL, 'Completed', 36),
(411, NULL, 11, 3, '0.10', NULL, NULL, 'Completed', 36),
(412, NULL, 12, 3, '5.20', NULL, NULL, 'Completed', 36),
(413, NULL, 143, 3, '0.10', NULL, NULL, 'Completed', 36),
(414, NULL, 144, 3, '0.00', NULL, NULL, 'Completed', 36),
(415, NULL, 145, 3, '0.00', NULL, NULL, 'Completed', 36),
(416, NULL, 147, 3, '8.00', NULL, NULL, 'Completed', 36),
(417, NULL, 15, 3, '42.00', NULL, NULL, 'Completed', 36),
(418, NULL, 148, 3, '6.00', NULL, NULL, 'Completed', 36),
(419, NULL, 149, 3, '3.50', NULL, NULL, 'Completed', 36),
(420, NULL, 150, 3, '2.30', NULL, NULL, 'Completed', 36),
(421, NULL, 151, 3, '1.00', NULL, NULL, 'Completed', 36),
(422, NULL, 121, 4, '0.80', NULL, NULL, 'Completed', 36),
(423, NULL, 104, 4, '130.00', NULL, NULL, 'Completed', 36),
(424, NULL, 122, 4, '0.30', NULL, NULL, 'Completed', 36),
(425, NULL, 103, 4, '90.00', NULL, NULL, 'Completed', 36),
(426, NULL, 182, 4, '6.00', NULL, NULL, 'Completed', 36),
(427, NULL, 26, 8, 'Negative', NULL, NULL, 'Completed', 36),
(428, NULL, 27, 9, 'Non-Reactive', NULL, NULL, 'Completed', 36),
(429, NULL, 11, 3, '0.10', NULL, NULL, 'Completed', 43),
(430, NULL, 12, 3, '5.20', NULL, NULL, 'Completed', 43),
(431, NULL, 143, 3, '0.10', NULL, NULL, 'Completed', 43),
(432, NULL, 144, 3, '0.00', NULL, NULL, 'Completed', 43),
(433, NULL, 145, 3, '0.00', NULL, NULL, 'Completed', 43),
(434, NULL, 147, 3, '8.00', NULL, NULL, 'Completed', 43),
(435, NULL, 15, 3, '42.00', NULL, NULL, 'Completed', 43),
(436, NULL, 148, 3, '6.00', NULL, NULL, 'Completed', 43),
(437, NULL, 149, 3, '3.50', NULL, NULL, 'Completed', 43),
(438, NULL, 150, 3, '2.30', NULL, NULL, 'Completed', 43),
(439, NULL, 151, 3, '1.00', NULL, NULL, 'Completed', 43),
(440, NULL, 26, 8, 'Non-Reactive', NULL, NULL, 'Completed', 43),
(441, NULL, 27, 9, 'Non-Reactive', NULL, NULL, 'Completed', 43),
(442, NULL, 121, 4, '0.80', NULL, NULL, 'Completed', 46),
(443, NULL, 104, 4, '130.00', NULL, NULL, 'Completed', 46),
(444, NULL, 122, 4, '0.30', NULL, NULL, 'Completed', 46),
(445, NULL, 103, 4, '90.00', NULL, NULL, 'Completed', 46),
(446, NULL, 182, 4, '6.00', NULL, NULL, 'Completed', 46),
(447, NULL, 17, 1, '6000.00', NULL, NULL, 'Completed', 42),
(448, NULL, 177, 1, '4.50', NULL, NULL, 'Completed', 42),
(449, NULL, 154, 1, '14.00', NULL, NULL, 'Completed', 42),
(450, NULL, 178, 1, '40.00', NULL, NULL, 'Completed', 42),
(451, NULL, 156, 1, 'Abnormal', NULL, NULL, 'Completed', 42),
(452, NULL, 157, 1, 'Non-Reactive', NULL, NULL, 'Completed', 42),
(453, NULL, 158, 1, 'Normal', NULL, NULL, 'Completed', 42),
(454, NULL, 19, 1, '1.50', NULL, NULL, 'Completed', 42),
(503, 34, 17, 1, '6000.00', '2025-08-30 12:40:05', 1, 'Completed', 47),
(504, 34, 177, 1, '4.50', '2025-08-30 12:40:05', 1, 'Completed', 47),
(505, 34, 154, 1, '14.00', '2025-08-30 12:40:05', 1, 'Completed', 47),
(506, 34, 178, 1, '40.00', '2025-08-30 12:40:05', 1, 'Completed', 47),
(507, 34, 156, 1, 'Normal', '2025-08-30 12:40:05', 1, 'Completed', 47),
(508, 34, 157, 1, 'NAD', '2025-08-30 12:40:05', 1, 'Completed', 47),
(509, 34, 158, 1, 'Non-Reactive', '2025-08-30 12:40:05', 1, 'Completed', 47),
(510, 34, 19, 1, '1.50', '2025-08-30 12:40:05', 1, 'Completed', 47),
(511, 35, 17, 1, '6000.00', '2025-09-01 04:37:55', 1, 'Completed', 48),
(512, 35, 177, 1, '4.50', '2025-09-01 04:37:55', 1, 'Completed', 48),
(513, 35, 154, 1, '14.00', '2025-09-01 04:37:55', 1, 'Completed', 48),
(514, 35, 178, 1, '40.00', '2025-09-01 04:37:55', 1, 'Completed', 48),
(515, 35, 156, 1, 'Normal', '2025-09-01 04:37:55', 1, 'Completed', 48),
(516, 35, 157, 1, 'NAD', '2025-09-01 04:37:55', 1, 'Completed', 48),
(517, 35, 158, 1, 'Normal', '2025-09-01 04:37:55', 1, 'Completed', 48),
(518, 35, 19, 1, '1.50', '2025-09-01 04:37:55', 1, 'Completed', 48),
(527, 36, 17, 1, '6000.00', '2025-09-05 10:05:20', 1, 'Completed', 49),
(528, 36, 177, 1, '4.50', '2025-09-05 10:05:20', 1, 'Completed', 49),
(529, 36, 154, 1, '14.00', '2025-09-05 10:05:20', 1, 'Completed', 49),
(530, 36, 178, 1, '40.00', '2025-09-05 10:05:20', 1, 'Completed', 49),
(531, 36, 156, 1, 'Abnormal', '2025-09-05 10:05:20', 1, 'Completed', 49),
(532, 36, 157, 1, 'Normal', '2025-09-05 10:05:20', 1, 'Completed', 49),
(533, 36, 158, 1, 'Normal', '2025-09-05 10:05:20', 1, 'Completed', 49),
(534, 36, 19, 1, '1.50', '2025-09-05 10:05:20', 1, 'Completed', 49),
(535, 37, 17, 1, '6000.00', '2025-09-05 10:08:00', 1, 'Completed', 50),
(536, 37, 177, 1, '4.50', '2025-09-05 10:08:00', 1, 'Completed', 50),
(537, 37, 154, 1, '14.00', '2025-09-05 10:08:00', 1, 'Completed', 50),
(538, 37, 178, 1, '40.00', '2025-09-05 10:08:00', 1, 'Completed', 50),
(539, 37, 156, 1, 'Normal', '2025-09-05 10:08:00', 1, 'Completed', 50),
(540, 37, 157, 1, 'Normal', '2025-09-05 10:08:00', 1, 'Completed', 50),
(541, 37, 158, 1, 'Normal', '2025-09-05 10:08:00', 1, 'Completed', 50),
(542, 37, 19, 1, '1.50', '2025-09-05 10:08:00', 1, 'Completed', 50),
(543, 39, 17, 1, '6000.00', '2025-10-13 12:27:27', 1, 'Completed', 51),
(544, 39, 177, 1, '4.50', '2025-10-13 12:27:27', 1, 'Completed', 51),
(545, 39, 154, 1, '14.00', '2025-10-13 12:27:27', 1, 'Completed', 51),
(546, 39, 178, 1, '40.00', '2025-10-13 12:27:27', 1, 'Completed', 51),
(547, 39, 156, 1, 'Normal', '2025-10-13 12:27:27', 1, 'Completed', 51),
(548, 39, 157, 1, 'Absent', '2025-10-13 12:27:27', 1, 'Completed', 51),
(549, 39, 158, 1, 'Positive', '2025-10-13 12:27:27', 1, 'Completed', 51),
(550, 39, 19, 1, '1.50', '2025-10-13 12:27:27', 1, 'Completed', 51),
(559, 41, 17, 1, '6000.00', '2026-02-09 08:56:43', 1, 'Completed', 53),
(560, 41, 177, 1, '4.50', '2026-02-09 08:56:43', 1, 'Completed', 53),
(561, 41, 154, 7, '14.00', '2026-02-09 08:56:43', 1, 'Completed', 53),
(562, 41, 178, 1, '40.00', '2026-02-09 08:56:43', 1, 'Completed', 53),
(563, 41, 156, 1, 'Reactive', '2026-02-09 08:56:43', 1, 'Completed', 53),
(564, 41, 157, 1, 'NAD', '2026-02-09 08:56:43', 1, 'Completed', 53),
(565, 41, 158, 1, 'Present', '2026-02-09 08:56:43', 1, 'Completed', 53),
(566, 41, 19, 1, '1.50', '2026-02-09 08:56:43', 1, 'Completed', 53),
(567, 41, 21, 2, '15.00', '2026-02-09 08:56:43', 1, 'Completed', 53),
(568, 41, 20, 2, '0.70', '2026-02-09 08:56:43', 1, 'Completed', 53),
(569, 41, 22, 2, '3.50', '2026-02-09 08:56:43', 1, 'Completed', 53),
(570, 41, 111, 2, '9.50', '2026-02-09 08:56:43', 1, 'Completed', 53),
(571, 41, 184, 2, '2.50', '2026-02-09 08:56:43', 1, 'Completed', 53),
(572, 41, 11, 3, '0.10', '2026-02-09 08:56:43', 1, 'Completed', 53),
(573, 41, 12, 3, '5.20', '2026-02-09 08:56:43', 1, 'Completed', 53),
(574, 41, 143, 3, '0.10', '2026-02-09 08:56:43', 1, 'Completed', 53),
(575, 41, 144, 3, '0.00', '2026-02-09 08:56:43', 1, 'Completed', 53),
(576, 41, 145, 3, '0.00', '2026-02-09 08:56:43', 1, 'Completed', 53),
(577, 41, 147, 3, '8.00', '2026-02-09 08:56:43', 1, 'Completed', 53),
(578, 41, 15, 3, '42.00', '2026-02-09 08:56:43', 1, 'Completed', 53),
(579, 41, 148, 3, '6.00', '2026-02-09 08:56:43', 1, 'Completed', 53),
(580, 41, 149, 3, '3.50', '2026-02-09 08:56:43', 1, 'Completed', 53),
(581, 41, 150, 3, '2.30', '2026-02-09 08:56:43', 1, 'Completed', 53),
(582, 41, 151, 3, '1.00', '2026-02-09 08:56:43', 1, 'Completed', 53),
(583, 41, 121, 4, '0.80', '2026-02-09 08:56:43', 1, 'Completed', 53),
(584, 41, 104, 4, '130.00', '2026-02-09 08:56:43', 1, 'Completed', 53),
(585, 41, 122, 4, '0.30', '2026-02-09 08:56:43', 1, 'Completed', 53),
(586, 41, 103, 4, '90.00', '2026-02-09 08:56:43', 1, 'Completed', 53),
(587, 41, 182, 4, '6.00', '2026-02-09 08:56:43', 1, 'Completed', 53),
(588, 41, 26, 8, 'Normal', '2026-02-09 08:56:43', 1, 'Completed', 53),
(589, 41, 27, 9, 'NAD', '2026-02-09 08:56:43', 1, 'Completed', 53);

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

--
-- Dumping data for table `test_samples`
--

INSERT INTO `test_samples` (`sample_id`, `bill_id`, `sample_date`, `collected_by`, `status`) VALUES
(1, 5, '2025-05-22 13:47:13', 5, 'completed'),
(2, 5, '2025-05-22 13:54:21', 5, 'completed'),
(3, 6, '2025-05-22 13:54:25', 5, 'completed'),
(4, 7, '2025-05-22 13:58:39', 5, 'collected'),
(5, 8, '2025-05-22 13:58:48', 5, 'completed'),
(6, 9, '2025-05-22 13:58:49', 5, 'completed'),
(7, 10, '2025-06-07 08:20:44', 1, 'completed'),
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
(18, 21, '2025-06-22 18:21:50', 1, 'completed'),
(19, 22, '2025-06-25 08:55:34', 1, 'completed'),
(20, 23, '2025-07-03 04:59:30', 1, 'completed'),
(21, 24, '2025-07-04 14:30:41', 1, 'pending'),
(22, 26, '2025-07-04 07:51:48', 1, 'completed'),
(23, 27, '2025-07-04 23:00:09', 1, 'completed'),
(24, 25, '2025-07-06 23:07:14', 1, 'completed'),
(25, 28, '2025-07-18 05:24:52', 1, 'completed'),
(26, 29, '2025-07-20 15:54:18', 1, 'completed'),
(27, 30, '2025-07-21 10:28:55', 1, 'completed'),
(28, 31, '2025-08-05 17:41:05', 1, 'completed'),
(29, 34, '2025-08-08 11:56:34', 1, 'completed'),
(30, 36, '2025-08-22 06:01:39', 1, 'completed'),
(31, 43, '2025-08-27 13:24:53', 1, 'completed'),
(32, 46, '2025-08-29 10:31:30', 1, 'completed'),
(33, 42, '2025-08-30 07:52:56', 1, 'completed'),
(34, 47, '2025-08-30 12:39:51', 1, 'completed'),
(35, 48, '2025-09-01 04:37:07', 1, 'completed'),
(36, 49, '2025-09-05 10:04:45', 1, 'completed'),
(37, 50, '2025-09-05 10:07:46', 1, 'completed'),
(38, 45, '2025-09-06 10:28:54', 1, 'pending'),
(39, 51, '2025-09-13 05:08:51', 1, 'completed'),
(40, 52, '2026-02-01 07:39:22', 1, 'collected'),
(41, 53, '2026-02-09 08:56:09', 1, 'completed');

-- --------------------------------------------------------

--
-- Table structure for table `test_template`
--

CREATE TABLE `test_template` (
  `test_id` int(11) NOT NULL,
  `header_html` text DEFAULT NULL,
  `interpretation` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `table_format` varchar(50) DEFAULT NULL,
  `group_by` tinyint(1) DEFAULT NULL,
  `show_method` tinyint(1) DEFAULT NULL,
  `show_interpretation` tinyint(1) DEFAULT NULL,
  `show_notes` tinyint(1) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `header_html` text DEFAULT NULL,
  `interpretation` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `table_format` varchar(50) DEFAULT NULL,
  `group_by` tinyint(1) DEFAULT NULL,
  `show_method` tinyint(1) DEFAULT NULL,
  `show_interpretation` tinyint(1) DEFAULT NULL,
  `show_notes` tinyint(1) DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT 0,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(18, 7, NULL, '<h2 style=\"color:#D84315\">Blood Sugar Profile</h2><p>FBS, PPBS, HbA1c</p><p><strong>Method:</strong> Hexokinase/Immunoturbidimetry</p>', '<p>FBS and PPBS assess short-term glucose. HbA1c reflects 3-month average.</p>', '<p>Over 6.5% HbA1c = diabetes</p>', 'default', 1, 1, 1, 1, 0, '2025-05-29 17:17:07'),
(19, 29, NULL, '', 'Malaria Parasite Test Result	Interpretation\r\nNot seen 	No malaria parasites were detected\r\nSchizonts of P. Vivax seen	P. vivax parasite detected in the blood\r\nTrophozoites of P. Vivax	Active infection with P. Vivax detected\r\nTrophozoites of P. Falciparum	Active infection with P. Falciparum detected\r\nGametocytes of P. Falciparum	Active infection with P. Falciparum detected and an increased\r\nrisk of transmission to others\r\n', '', 'default', 0, 0, 1, 0, 0, '2025-06-08 16:36:23'),
(20, 27, NULL, '', '', '', 'default', 0, NULL, NULL, NULL, 0, '2025-06-08 23:36:50'),
(21, 1, NULL, '', '', '', 'default', 0, NULL, NULL, NULL, 0, '2025-06-08 23:37:02'),
(23, 1, NULL, '<h2 style=\"color:#283593\">Lipid Profile</h2><p>Includes Total Cholesterol, LDL, HDL, Triglycerides</p><p><strong>Method:</strong> Enzymatic</p>', '<p>LDL is atherogenic. HDL is protective. Evaluate 10-year cardiac risk profile.</p>', '<p>Fasting recommended for accurate triglyceride measurement</p>', 'default', 1, NULL, NULL, NULL, 0, '2025-06-08 23:38:50');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `txn_id` int(11) NOT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `txn_date` date DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, 'admin', '$2y$10$AeoGPqork4CPmV8sYBZqpumBpq/TPutWY/1y3ZaKj.7JbvtA4q46.', 'Admin User', 1, 'active'),
(2, 'user1', '$2y$10$QVsc9k5K4whUN342s110/.eHnS7KmWejhCsc3t5R6NecSHN.k6966', 'Lab Staff 1', 2, 'active'),
(5, 'admin1', '$2y$10$kYr2bH/2qj8vGyP4BlF/xuSlN2Rxs1btQpmi678zkcaWjLTYbPiI.', 'admin1', 1, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `vendor_master`
--

CREATE TABLE `vendor_master` (
  `vendor_id` int(11) NOT NULL,
  `vendor_userid` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `pincode` varchar(10) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `logo_image` varchar(255) DEFAULT NULL,
  `letterhead_image` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected','active','inactive') DEFAULT 'pending',
  `payment` enum('unpaid','paid') DEFAULT 'unpaid',
  `due_date` date DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_settings`
--
ALTER TABLE `admin_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bills`
--
ALTER TABLE `bills`
  ADD PRIMARY KEY (`bill_id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `fk_bills_patient_type` (`patient_type_id`);

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
  ADD KEY `group_id` (`group_id`),
  ADD KEY `fk_lab_test_signature` (`signature_id`),
  ADD KEY `fk_lab_test_stamp` (`stamp_id`);

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
-- Indexes for table `patient_extra_info`
--
ALTER TABLE `patient_extra_info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bill_id` (`bill_id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `field_id` (`field_id`);

--
-- Indexes for table `patient_formats`
--
ALTER TABLE `patient_formats`
  ADD PRIMARY KEY (`format_id`);

--
-- Indexes for table `patient_info_templates`
--
ALTER TABLE `patient_info_templates`
  ADD PRIMARY KEY (`template_id`),
  ADD KEY `type_id` (`type_id`);

--
-- Indexes for table `patient_types`
--
ALTER TABLE `patient_types`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `patient_type_fields`
--
ALTER TABLE `patient_type_fields`
  ADD PRIMARY KEY (`field_id`),
  ADD KEY `type_id` (`type_id`);

--
-- Indexes for table `report_headers`
--
ALTER TABLE `report_headers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `report_templates`
--
ALTER TABLE `report_templates`
  ADD PRIMARY KEY (`template_id`);

--
-- Indexes for table `report_template_columns`
--
ALTER TABLE `report_template_columns`
  ADD PRIMARY KEY (`column_id`);

--
-- Indexes for table `report_template_sections`
--
ALTER TABLE `report_template_sections`
  ADD PRIMARY KEY (`section_id`);

--
-- Indexes for table `report_template_versions`
--
ALTER TABLE `report_template_versions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `sign_master`
--
ALTER TABLE `sign_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `template_version_history`
--
ALTER TABLE `template_version_history`
  ADD PRIMARY KEY (`version_id`),
  ADD KEY `idx_template_version` (`template_id`,`version`);

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
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`txn_id`),
  ADD KEY `vendor_id` (`vendor_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `vendor_master`
--
ALTER TABLE `vendor_master`
  ADD PRIMARY KEY (`vendor_id`),
  ADD UNIQUE KEY `vendor_userid` (`vendor_userid`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_settings`
--
ALTER TABLE `admin_settings`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bills`
--
ALTER TABLE `bills`
  MODIFY `bill_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `bill_packages`
--
ALTER TABLE `bill_packages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `bill_tests`
--
ALTER TABLE `bill_tests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `lab_tests`
--
ALTER TABLE `lab_tests`
  MODIFY `test_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lab_test_parameters`
--
ALTER TABLE `lab_test_parameters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `parameter_reference_ranges`
--
ALTER TABLE `parameter_reference_ranges`
  MODIFY `range_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `patient_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `patient_extra_info`
--
ALTER TABLE `patient_extra_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `patient_formats`
--
ALTER TABLE `patient_formats`
  MODIFY `format_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `patient_info_templates`
--
ALTER TABLE `patient_info_templates`
  MODIFY `template_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `patient_types`
--
ALTER TABLE `patient_types`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `patient_type_fields`
--
ALTER TABLE `patient_type_fields`
  MODIFY `field_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `report_headers`
--
ALTER TABLE `report_headers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `report_templates`
--
ALTER TABLE `report_templates`
  MODIFY `template_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `report_template_columns`
--
ALTER TABLE `report_template_columns`
  MODIFY `column_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `report_template_sections`
--
ALTER TABLE `report_template_sections`
  MODIFY `section_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `report_template_versions`
--
ALTER TABLE `report_template_versions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sign_master`
--
ALTER TABLE `sign_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `template_version_history`
--
ALTER TABLE `template_version_history`
  MODIFY `version_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `test_categories`
--
ALTER TABLE `test_categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `test_groups`
--
ALTER TABLE `test_groups`
  MODIFY `group_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `test_packages`
--
ALTER TABLE `test_packages`
  MODIFY `package_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `test_parameters`
--
ALTER TABLE `test_parameters`
  MODIFY `parameter_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `test_parameter_map`
--
ALTER TABLE `test_parameter_map`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `test_results`
--
ALTER TABLE `test_results`
  MODIFY `result_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=590;

--
-- AUTO_INCREMENT for table `test_samples`
--
ALTER TABLE `test_samples`
  MODIFY `sample_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `test_templates`
--
ALTER TABLE `test_templates`
  MODIFY `template_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `txn_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `vendor_master`
--
ALTER TABLE `vendor_master`
  MODIFY `vendor_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bills`
--
ALTER TABLE `bills`
  ADD CONSTRAINT `bills_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`),
  ADD CONSTRAINT `bills_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `fk_bills_patient_type` FOREIGN KEY (`patient_type_id`) REFERENCES `patient_types` (`type_id`) ON DELETE SET NULL;

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
  ADD CONSTRAINT `fk_lab_test_signature` FOREIGN KEY (`signature_id`) REFERENCES `sign_master` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_lab_test_stamp` FOREIGN KEY (`stamp_id`) REFERENCES `sign_master` (`id`) ON DELETE SET NULL,
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
-- Constraints for table `patient_extra_info`
--
ALTER TABLE `patient_extra_info`
  ADD CONSTRAINT `patient_extra_info_ibfk_1` FOREIGN KEY (`bill_id`) REFERENCES `bills` (`bill_id`),
  ADD CONSTRAINT `patient_extra_info_ibfk_2` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`),
  ADD CONSTRAINT `patient_extra_info_ibfk_3` FOREIGN KEY (`field_id`) REFERENCES `patient_type_fields` (`field_id`);

--
-- Constraints for table `patient_info_templates`
--
ALTER TABLE `patient_info_templates`
  ADD CONSTRAINT `patient_info_templates_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `patient_types` (`type_id`);

--
-- Constraints for table `patient_type_fields`
--
ALTER TABLE `patient_type_fields`
  ADD CONSTRAINT `patient_type_fields_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `patient_types` (`type_id`);

--
-- Constraints for table `template_version_history`
--
ALTER TABLE `template_version_history`
  ADD CONSTRAINT `template_version_history_ibfk_1` FOREIGN KEY (`template_id`) REFERENCES `report_templates` (`template_id`) ON DELETE CASCADE;

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
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`vendor_id`) REFERENCES `vendor_master` (`vendor_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
