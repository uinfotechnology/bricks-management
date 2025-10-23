-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 23, 2025 at 11:32 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bricks_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `party_name` varchar(255) NOT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `mobile_number` varchar(255) DEFAULT NULL,
  `secondary_mobile_number` varchar(255) DEFAULT NULL,
  `gst_number` varchar(255) DEFAULT NULL,
  `pan_number` varchar(255) DEFAULT NULL,
  `opening_balance` decimal(15,2) NOT NULL DEFAULT 0.00,
  `address` text DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `account_number` varchar(255) DEFAULT NULL,
  `ifsc_code` varchar(255) DEFAULT NULL,
  `account_holder_name` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `financial_year` varchar(255) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id`, `product_id`, `party_name`, `contact_person`, `mobile_number`, `secondary_mobile_number`, `gst_number`, `pan_number`, `opening_balance`, `address`, `bank_name`, `account_number`, `ifsc_code`, `account_holder_name`, `date`, `financial_year`, `remarks`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 'BCCL', 'Rahul Kumar', '9876543210', '8796543210', 'GST7854215487', 'BHGTF5445D', 50000.00, 'Dhanbad', 'SBI', '3216549875451', 'SBI578455', 'Rahul Kumar', '2025-09-27', '2025-2026', 'Remark', '2025-09-26 11:36:44', '2025-09-26 11:36:44', NULL),
(2, 1, 'MPL', 'Vishal Kumar', '8796543210', '7418529632', 'GST7854125487', 'MNHGT4578G', 50000.00, 'Dhanbad', 'SBI', '3578965412545', 'SBI1254875', 'Vishal Kumar', '2025-09-27', '2025-2026', 'Remarks', '2025-09-26 11:52:06', '2025-10-05 09:46:19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `account_balances`
--

CREATE TABLE `account_balances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `account_balances`
--

INSERT INTO `account_balances` (`id`, `amount`, `created_at`, `updated_at`) VALUES
(1, 25200.00, '2025-10-16 04:28:39', '2025-10-22 06:28:29');

-- --------------------------------------------------------

--
-- Table structure for table `bricks_sales`
--

CREATE TABLE `bricks_sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bill_no` varchar(100) NOT NULL,
  `vehicle_id` bigint(20) UNSIGNED NOT NULL,
  `bricks_type_category_id` bigint(20) UNSIGNED NOT NULL,
  `bricks_type_sub_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_name` varchar(100) NOT NULL,
  `customer_mobile` varchar(15) DEFAULT NULL,
  `customer_address` text DEFAULT NULL,
  `customer_city` varchar(50) DEFAULT NULL,
  `customer_state` varchar(50) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `rate_per_thousand` decimal(10,2) NOT NULL,
  `total_amount` decimal(12,2) NOT NULL,
  `amount_received` decimal(12,2) NOT NULL DEFAULT 0.00,
  `due_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `payment_mode` varchar(50) DEFAULT NULL,
  `sale_date` date NOT NULL,
  `financial_year` varchar(20) NOT NULL,
  `upload_image` varchar(255) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bricks_sales`
--

INSERT INTO `bricks_sales` (`id`, `bill_no`, `vehicle_id`, `bricks_type_category_id`, `bricks_type_sub_category_id`, `customer_name`, `customer_mobile`, `customer_address`, `customer_city`, `customer_state`, `quantity`, `rate_per_thousand`, `total_amount`, `amount_received`, `due_amount`, `payment_mode`, `sale_date`, `financial_year`, `upload_image`, `remarks`, `created_at`, `updated_at`, `deleted_at`) VALUES
(8, '2025-001', 3, 8, NULL, 'Deepak', NULL, 'Dhanbad', NULL, NULL, 100, 2000.00, 200.00, 150.00, 50.00, NULL, '2025-10-22', '2025-2026', 'no-image.png', NULL, '2025-10-22 04:42:33', '2025-10-22 04:42:33', NULL),
(10, '2025-002', 4, 1, 4, 'Rahul', NULL, 'Dhanbad', NULL, NULL, 50, 5000.00, 250.00, 250.00, 0.00, NULL, '2025-10-22', '2025-2026', 'no-image.png', NULL, '2025-10-22 04:44:40', '2025-10-22 04:45:16', NULL),
(11, '2025-003', 4, 8, NULL, 'Vijay', NULL, 'Dhanbad', NULL, NULL, 200, 3000.00, 600.00, 400.00, 200.00, NULL, '2025-10-22', '2025-2026', 'no-image.png', NULL, '2025-10-22 04:48:38', '2025-10-22 04:48:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bricks_stocks`
--

CREATE TABLE `bricks_stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bricks_type_category_name` varchar(255) NOT NULL,
  `bricks_type_category_id` bigint(20) UNSIGNED NOT NULL,
  `bricks_type_sub_category_name` varchar(255) DEFAULT NULL,
  `bricks_type_sub_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `bricks_quantity` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bricks_stocks`
--

INSERT INTO `bricks_stocks` (`id`, `bricks_type_category_name`, `bricks_type_category_id`, `bricks_type_sub_category_name`, `bricks_type_sub_category_id`, `bricks_quantity`, `created_at`, `updated_at`) VALUES
(2, '1 No (A)', 8, NULL, NULL, 300, '2025-10-13 01:04:09', '2025-10-22 04:48:38'),
(4, 'Jaldagi (J)', 1, 'Goria (G)', 4, 50, '2025-10-13 01:06:11', '2025-10-22 04:44:40'),
(5, 'Second 2 No (2B)', 3, NULL, NULL, 700, '2025-10-13 01:12:03', '2025-10-13 01:12:03');

-- --------------------------------------------------------

--
-- Table structure for table `bricks_stocks_transactions`
--

CREATE TABLE `bricks_stocks_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `stock_id` bigint(20) UNSIGNED NOT NULL,
  `bricks_type_category_id` int(11) NOT NULL,
  `bricks_type_sub_category_id` int(11) DEFAULT NULL,
  `bricks_quantity` int(11) NOT NULL,
  `stock_date` date NOT NULL,
  `financial_year` varchar(255) NOT NULL,
  `transaction_type` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bricks_stocks_transactions`
--

INSERT INTO `bricks_stocks_transactions` (`id`, `stock_id`, `bricks_type_category_id`, `bricks_type_sub_category_id`, `bricks_quantity`, `stock_date`, `financial_year`, `transaction_type`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 8, NULL, 100, '2025-10-04', '2025', 'IN', '2025-10-13 01:04:09', '2025-10-13 18:13:29', '2025-10-13 18:13:29'),
(3, 4, 1, 4, 100, '2025-10-08', '2025', 'IN', '2025-10-13 01:06:11', '2025-10-13 01:06:11', NULL),
(4, 5, 3, NULL, 700, '2025-10-10', '2025-2026', 'IN', '2025-10-13 01:12:03', '2025-10-13 01:12:03', NULL),
(5, 2, 8, NULL, 600, '2025-10-14', '2025-2026', 'IN', '2025-10-13 18:13:50', '2025-10-13 18:13:50', NULL),
(6, 2, 8, NULL, 100, '2025-10-22', '2025-2026', 'OUT', '2025-10-22 04:42:33', '2025-10-22 04:42:33', NULL),
(7, 4, 1, 4, 50, '2025-10-22', '2025-2026', 'OUT', '2025-10-22 04:44:40', '2025-10-22 04:44:40', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bricks_type_categorys`
--

CREATE TABLE `bricks_type_categorys` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bricks_type_category_name` varchar(255) NOT NULL,
  `financial_year` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bricks_type_categorys`
--

INSERT INTO `bricks_type_categorys` (`id`, `bricks_type_category_name`, `financial_year`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Jaldagi (J)', '2025-2026', '2025-10-10 23:43:02', '2025-10-10 23:43:02', NULL),
(2, 'Picket (PIC)', '2025-2026', '2025-10-10 23:43:29', '2025-10-10 23:43:29', NULL),
(3, 'Second 2 No (2B)', '2025-2026', '2025-10-10 23:44:01', '2025-10-10 23:45:33', NULL),
(4, 'Patan (P)', '2025-2026', '2025-10-10 23:44:14', '2025-10-10 23:44:14', NULL),
(5, 'Goria (G)', '2025-2026', '2025-10-10 23:44:24', '2025-10-10 23:44:24', NULL),
(6, '2 No (B)', '2025-2026', '2025-10-10 23:44:39', '2025-10-10 23:45:20', NULL),
(7, 'Meetha (M)', '2025-2026', '2025-10-10 23:44:50', '2025-10-10 23:44:50', NULL),
(8, '1 No (A)', '2025-2026', '2025-10-10 23:45:12', '2025-10-10 23:45:12', NULL),
(9, 'abc', '2025-2026', '2025-10-17 06:32:51', '2025-10-17 06:32:51', NULL),
(10, 'XYZ', '2025-2026', '2025-10-17 06:33:12', '2025-10-17 06:33:12', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bricks_type_sub_categorys`
--

CREATE TABLE `bricks_type_sub_categorys` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bricks_type_category_id` bigint(20) UNSIGNED NOT NULL,
  `bricks_type_sub_category_name` varchar(255) NOT NULL,
  `financial_year` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bricks_type_sub_categorys`
--

INSERT INTO `bricks_type_sub_categorys` (`id`, `bricks_type_category_id`, `bricks_type_sub_category_name`, `financial_year`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Picket (PIC)', '2025-2026', '2025-10-12 23:25:51', '2025-10-12 23:25:51', NULL),
(2, 1, 'Second 2 No (2B)', '2025-2026', '2025-10-12 23:26:00', '2025-10-12 23:26:00', NULL),
(3, 1, 'Patan (P)', '2025-2026', '2025-10-12 23:26:08', '2025-10-12 23:26:08', NULL),
(4, 1, 'Goria (G)', '2025-2026', '2025-10-12 23:26:19', '2025-10-12 23:26:19', NULL),
(5, 1, '2 No (B)', '2025-2026', '2025-10-12 23:26:28', '2025-10-12 23:26:28', NULL),
(6, 1, 'Meetha (M)', '2025-2026', '2025-10-12 23:26:35', '2025-10-12 23:26:35', NULL),
(7, 1, '1 No (A)', '2025-2026', '2025-10-12 23:26:43', '2025-10-12 23:26:43', NULL),
(8, 1, 'zxd', '2025-2026', '2025-10-17 06:33:53', '2025-10-17 06:33:53', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `company_details`
--

CREATE TABLE `company_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `registration_number` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `pincode` varchar(255) DEFAULT NULL,
  `gst_number` varchar(255) DEFAULT NULL,
  `pan_number` varchar(255) DEFAULT NULL,
  `tan_number` varchar(255) DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `account_number` varchar(255) DEFAULT NULL,
  `ifsc_code` varchar(255) DEFAULT NULL,
  `account_holder_name` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `company_details`
--

INSERT INTO `company_details` (`id`, `company_name`, `registration_number`, `phone`, `address`, `city`, `state`, `pincode`, `gst_number`, `pan_number`, `tan_number`, `bank_name`, `account_number`, `ifsc_code`, `account_holder_name`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Bricks Management', 'RGN421545465', '9876543210', 'Dhanbad', 'Dhanbad', 'Jharkhand', '865475', 'GST54545656', 'BHKFR9876G', '54545454564564', 'SBI', '32213546546', 'SBI-546546564', 'Bricks Management', 'VG5rZBWhSEW72chV1zCMRgf9ZyEoUD.png', '2025-09-07 15:38:17', '2025-09-16 04:06:42');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purpose_of_expense` varchar(255) NOT NULL,
  `recipient_name` varchar(255) DEFAULT NULL,
  `amount_spent` decimal(12,2) NOT NULL DEFAULT 0.00,
  `payment_mode` varchar(100) DEFAULT NULL,
  `expense_date` date DEFAULT NULL,
  `financial_year` varchar(20) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `purpose_of_expense`, `recipient_name`, `amount_spent`, `payment_mode`, `expense_date`, `financial_year`, `remarks`, `deleted_at`, `created_at`, `updated_at`) VALUES
(2, 'Work', 'Deepak', 500.00, 'cash', '2025-10-22', '2025-2026', NULL, NULL, '2025-10-22 06:28:29', '2025-10-22 06:28:29');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `financial_years`
--

CREATE TABLE `financial_years` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `financial_years`
--

INSERT INTO `financial_years` (`id`, `name`, `start_date`, `end_date`, `is_active`, `created_at`, `updated_at`) VALUES
(1, '2024-2025', '2024-04-01', '2025-03-31', 0, '2025-10-15 02:32:44', '2025-10-15 02:32:44'),
(2, '2025-2026', '2025-04-01', '2026-03-31', 1, '2025-10-15 02:32:44', '2025-10-15 02:32:44'),
(3, '2026-2027', '2026-04-01', '2027-03-31', 0, '2025-10-15 02:32:44', '2025-10-15 02:32:44'),
(4, '2027-2028', '2027-04-01', '2028-03-31', 0, '2025-10-15 02:32:44', '2025-10-15 02:32:44'),
(5, '2028-2029', '2028-04-01', '2029-03-31', 0, '2025-10-15 02:32:44', '2025-10-15 02:32:44');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `labours`
--

CREATE TABLE `labours` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `labour_type_id` bigint(20) UNSIGNED NOT NULL,
  `rate_per_thousand` decimal(8,2) NOT NULL,
  `name` varchar(255) NOT NULL,
  `mobile_number` varchar(15) DEFAULT NULL,
  `secondary_mobile_number` varchar(15) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `aadhar_no` varchar(20) DEFAULT NULL,
  `pan_number` varchar(15) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `financial_year` varchar(255) NOT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `labours`
--

INSERT INTO `labours` (`id`, `labour_type_id`, `rate_per_thousand`, `name`, `mobile_number`, `secondary_mobile_number`, `dob`, `gender`, `aadhar_no`, `pan_number`, `city`, `state`, `address`, `image`, `financial_year`, `remarks`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 3, 800.00, 'Deepak', '9876543210', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.png', '2025-2026', NULL, '2025-10-10 18:53:06', '2025-10-17 06:14:50', '2025-10-17 06:14:50'),
(2, 3, 800.00, 'Nepal', '9876543210', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.png', '2025-2026', NULL, '2025-10-17 06:14:37', '2025-10-17 06:14:37', NULL),
(3, 3, 800.00, 'DEEPAK', '1234567890', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.png', '2025-2026', NULL, '2025-10-17 06:16:30', '2025-10-17 06:16:30', NULL),
(4, 3, 600.00, 'Avinash', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.png', '2025-2026', NULL, '2025-10-22 02:40:15', '2025-10-22 02:40:15', NULL),
(5, 3, 600.00, 'Binay', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.png', '2025-2026', NULL, '2025-10-22 02:40:48', '2025-10-22 02:40:48', NULL),
(6, 3, 500.00, 'Chandan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.png', '2025-2026', NULL, '2025-10-22 02:41:02', '2025-10-22 02:41:02', NULL),
(7, 3, 500.00, 'Submit', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.png', '2025-2026', NULL, '2025-10-22 02:41:25', '2025-10-22 02:41:25', NULL),
(8, 3, 700.00, 'Vishal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.png', '2025-2026', NULL, '2025-10-22 02:41:36', '2025-10-22 02:41:36', NULL),
(9, 3, 800.00, 'Ajay', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.png', '2025-2026', NULL, '2025-10-22 02:42:01', '2025-10-22 02:42:01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `labour_payments`
--

CREATE TABLE `labour_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `labour_id` bigint(20) UNSIGNED NOT NULL,
  `total_bricks` int(11) NOT NULL,
  `current_payment` decimal(15,2) DEFAULT NULL,
  `total_payment` decimal(15,2) NOT NULL,
  `paid_amount` decimal(15,2) DEFAULT NULL,
  `due_amount` decimal(15,2) DEFAULT NULL,
  `payment_date` date NOT NULL,
  `financial_year` varchar(255) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `labour_payments`
--

INSERT INTO `labour_payments` (`id`, `labour_id`, `total_bricks`, `current_payment`, `total_payment`, `paid_amount`, `due_amount`, `payment_date`, `financial_year`, `remarks`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1000, 800.00, 800.00, 500.00, 300.00, '2025-10-02', '2025-2026', NULL, '2025-10-10 19:54:07', '2025-10-10 19:54:07', NULL),
(2, 1, 0, 0.00, 300.00, 100.00, 200.00, '2025-10-03', '2025-2026', NULL, '2025-10-10 19:55:50', '2025-10-10 19:55:50', NULL),
(3, 1, 600, 480.00, 680.00, 600.00, 80.00, '2025-10-05', '2025-2026', NULL, '2025-10-10 19:58:18', '2025-10-10 19:58:18', NULL),
(4, 3, 1650, 1320.00, 1320.00, 850.00, 470.00, '2025-10-17', '2025-2026', NULL, '2025-10-17 06:27:21', '2025-10-17 06:27:21', NULL),
(5, 3, 0, 0.00, 470.00, 300.00, 170.00, '2025-10-06', '2025-2026', NULL, '2025-10-17 06:28:14', '2025-10-17 06:28:14', NULL),
(6, 3, 0, 0.00, 170.00, 100.00, 70.00, '2025-10-22', '2025-2026', NULL, '2025-10-22 05:06:43', '2025-10-22 05:06:43', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `labour_types`
--

CREATE TABLE `labour_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `labour_type` varchar(255) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `labour_types`
--

INSERT INTO `labour_types` (`id`, `labour_type`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Unloading Labour', NULL, '2025-10-07 07:42:21', '2025-10-07 07:42:21'),
(2, 'Loading Labour', NULL, '2025-10-07 07:42:28', '2025-10-07 07:42:28'),
(3, 'Pathera', NULL, '2025-10-07 07:42:35', '2025-10-07 07:42:35');

-- --------------------------------------------------------

--
-- Table structure for table `labour_work_details`
--

CREATE TABLE `labour_work_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `labour_id` bigint(20) UNSIGNED NOT NULL,
  `bricks_quantity` int(11) NOT NULL DEFAULT 0,
  `work_date` date NOT NULL,
  `is_paid` tinyint(1) NOT NULL DEFAULT 0,
  `financial_year` varchar(255) NOT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `labour_work_details`
--

INSERT INTO `labour_work_details` (`id`, `labour_id`, `bricks_quantity`, `work_date`, `is_paid`, `financial_year`, `remarks`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1000, '2025-10-01', 1, '2025-2026', NULL, '2025-10-10 19:53:41', '2025-10-17 06:19:12', '2025-10-17 06:19:12'),
(2, 1, 600, '2025-10-04', 1, '2025-2026', NULL, '2025-10-10 19:56:59', '2025-10-17 06:19:03', '2025-10-17 06:19:03'),
(3, 3, 1000, '2025-10-17', 1, '2025-2026', NULL, '2025-10-17 06:18:49', '2025-10-17 06:18:49', NULL),
(4, 3, 650, '2025-10-15', 1, '2025-2026', NULL, '2025-10-17 06:20:09', '2025-10-17 06:20:39', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_09_12_105218_create_products_table', 1),
(5, '2025_09_12_125826_create_account_table', 1),
(6, '2025_09_13_051212_create_purchases_table', 1),
(7, '2025_09_13_051359_create_stocks_table', 1),
(8, '2025_09_13_064530_create_stock_transactions_table', 1),
(9, '2025_09_13_121930_create_payments_table', 1),
(10, '2025_09_13_122206_create_labour_types_table', 1),
(11, '2025_09_15_123713_create_labours_table', 1),
(12, '2025_09_17_092934_create_labour_work_detsils_table', 1),
(13, '2025_09_18_064440_create_labour_payments_table', 1),
(14, '2025_10_10_105144_create_vehicles_table', 1),
(15, '2025_10_11_101701_create_bricks_type_categorys_table', 1),
(16, '2025_10_11_111107_create_bricks_type_sub_categorys_table', 1),
(17, '2025_10_13_052530_create_bricks_stocks_table', 1),
(18, '2025_10_13_055947_create_bricks_stocks_transactions_table', 1),
(19, '2025_10_15_072542_create_bricks_sales_table', 1),
(20, '2025_10_15_073743_create_account_balances_table', 1),
(21, '2025_10_17_093841_create_vehicle_payments_table', 2),
(22, '2025_10_22_110133_create_expenses_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_id` bigint(20) UNSIGNED NOT NULL,
  `party_id` bigint(20) UNSIGNED NOT NULL,
  `amount_paid` decimal(15,2) NOT NULL,
  `due_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total_amount` decimal(15,2) NOT NULL,
  `payment_status` enum('paid','due','unpaid') NOT NULL DEFAULT 'unpaid',
  `payment_mode` varchar(255) DEFAULT NULL,
  `payment_date` date NOT NULL,
  `financial_year` varchar(255) NOT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `purchase_id`, `party_id`, `amount_paid`, `due_amount`, `total_amount`, `payment_status`, `payment_mode`, `payment_date`, `financial_year`, `remarks`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 1, 2, 100.00, 2000.00, 2100.00, 'due', 'cash', '2025-10-22', '2025-2026', NULL, '2025-10-22 05:02:59', '2025-10-22 05:02:59', NULL),
(3, 1, 2, 200.00, 1800.00, 2100.00, 'due', 'cash', '2025-10-22', '2025-2026', NULL, '2025-10-22 05:03:26', '2025-10-22 05:03:26', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `financial_year` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `financial_year`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Coal', '2025-2026', '2025-09-26 11:31:36', '2025-09-26 11:31:36', NULL),
(2, 'Soil', '2025-2026', '2025-09-26 11:31:40', '2025-09-26 11:31:40', NULL),
(3, 'Demo', '2025-2026', '2025-10-10 01:02:48', '2025-10-10 01:02:48', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bill_no` varchar(255) NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `party_id` bigint(20) UNSIGNED NOT NULL,
  `rate` decimal(10,2) NOT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `unit` varchar(255) NOT NULL,
  `discount` decimal(10,2) DEFAULT NULL,
  `gst` decimal(10,2) DEFAULT NULL,
  `total_amount` decimal(15,2) NOT NULL,
  `payment_status` enum('paid','due','unpaid') NOT NULL DEFAULT 'unpaid',
  `financial_year` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`id`, `bill_no`, `product_id`, `party_id`, `rate`, `quantity`, `unit`, `discount`, `gst`, `total_amount`, `payment_status`, `financial_year`, `date`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '123', 1, 2, 500.00, 5.00, 'ton', 500.00, 5.00, 2100.00, 'due', '2025-2026', '2025-10-09', '2025-10-08 14:57:01', '2025-10-22 05:03:26', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('pfR2wbc033YCmG9FIOEGrQeQe3IdX6NX7reqZRYF', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiUldlNzREamtqRHNGTHFwZVlEbWM1MGRGcnJtOFVEU2JmU21ZZU0zaiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czoxNDoiZmluYW5jaWFsX3llYXIiO2E6NDp7czoyOiJpZCI7aToyO3M6NDoibmFtZSI7czo5OiIyMDI1LTIwMjYiO3M6MTA6InN0YXJ0X2RhdGUiO3M6MTA6IjIwMjUtMDQtMDEiO3M6ODoiZW5kX2RhdGUiO3M6MTA6IjIwMjYtMDMtMzEiO319', 1761137211);

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `unit` varchar(255) NOT NULL,
  `total_amount` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`id`, `product_id`, `quantity`, `unit`, `total_amount`, `created_at`, `updated_at`) VALUES
(1, 1, 4900.00, 'kilogram', 2100.00, '2025-10-08 14:57:01', '2025-10-10 00:57:41');

-- --------------------------------------------------------

--
-- Table structure for table `stock_transactions`
--

CREATE TABLE `stock_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `purchase_id` bigint(20) UNSIGNED DEFAULT NULL,
  `party_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `unit` varchar(255) NOT NULL,
  `rate` decimal(10,2) NOT NULL,
  `gst` decimal(10,2) DEFAULT NULL,
  `total_amount` decimal(15,2) NOT NULL,
  `transaction_type` enum('Purchase','Sale','Use','Adjustment') NOT NULL,
  `date` date NOT NULL,
  `financial_year` varchar(255) NOT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_transactions`
--

INSERT INTO `stock_transactions` (`id`, `product_id`, `purchase_id`, `party_id`, `quantity`, `unit`, `rate`, `gst`, `total_amount`, `transaction_type`, `date`, `financial_year`, `remarks`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 2, 5.00, 'ton', 500.00, 5.00, 2100.00, 'Purchase', '2025-10-09', '2025-2026', 'Purchase Bill No: 123', '2025-10-08 14:57:01', '2025-10-08 14:57:01', NULL),
(2, 1, NULL, NULL, 100.00, 'kilogram', 0.00, 0.00, 0.00, 'Use', '2025-10-10', '2025-2026', 'Stock used in production', '2025-10-10 00:57:41', '2025-10-10 00:57:41', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `role` varchar(255) DEFAULT 'Super Admin',
  `password` varchar(255) NOT NULL,
  `normal_password` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `user_id`, `email`, `email_verified_at`, `role`, `password`, `normal_password`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'A001', 'superadmin@admin.com', NULL, 'Super Admin', '$2y$12$VL87uhEctwHDOQoeRkC0R.oUyqZEmpbiRpwWuQzynAS2/6RIhDvuy', '12345678', 1, NULL, '2025-10-15 02:32:44', '2025-10-16 06:57:07');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vehicle_type` varchar(255) NOT NULL,
  `ownar_name` varchar(255) NOT NULL,
  `contact_no` varchar(15) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `vehicle_name` varchar(255) NOT NULL,
  `vehicle_number` varchar(255) NOT NULL,
  `aadhar_card` varchar(255) DEFAULT NULL,
  `vehicle_document` varchar(255) DEFAULT NULL,
  `rent_amount` decimal(10,2) DEFAULT 0.00,
  `financial_year` varchar(255) NOT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`id`, `vehicle_type`, `ownar_name`, `contact_no`, `address`, `city`, `state`, `vehicle_name`, `vehicle_number`, `aadhar_card`, `vehicle_document`, `rent_amount`, `financial_year`, `remarks`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'company', 'Rahul Kumar', '9876543210', 'Hirapur', 'Dhanbad', 'Jharkhand', 'Truck 407', 'JH 10 CD 7845', 'DtKv9DXVOxYMj0XEQwDE63UJwCz7bd.png', 'AObu7GryK7Qshgw7d5XyJPt1LtuQvh.jpg', 0.00, '2025-2026', 'Remarks', '2025-10-13 18:52:31', '2025-10-13 20:08:15', NULL),
(2, 'rent', 'Vikash Kumar', '8796543210', 'Bank More', 'Dhanbad', 'Jharkhand', 'Tractor', 'JH 10 BR 5421', 'KTBYrRRwoZAVjQmiKar2P3hEVC1u5Z.png', 'nI8rVmflpmk9H5DkhCHPn4nVJzWZ62.jpg', 0.00, '2025-2026', NULL, '2025-10-13 21:44:19', '2025-10-13 21:44:19', NULL),
(3, 'rent', 'Niraj Kumar', '7587458965', 'Govindpur', 'Dhanbad', 'Jharkhand', 'Truck', 'JH 10 BG 6548', 'nnkorqkc6R7ZayEPvpNl5HvhFdnkUq.png', 'zQCj21R41dqoSjxkIXq9mkvUwDMTov.jpg', 5000.00, '2025-2026', 'Remarks', '2025-10-17 02:40:10', '2025-10-17 02:45:31', NULL),
(4, 'company', 'SRS', '1234567890', NULL, NULL, NULL, 'TRACTOR', 'JH09BJ0201', 'no-image.png', 'no-image.png', NULL, '2025-2026', NULL, '2025-10-17 06:36:19', '2025-10-17 06:36:19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_payments`
--

CREATE TABLE `vehicle_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vehicle_id` bigint(20) UNSIGNED NOT NULL,
  `rent_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `paid_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `payment_date` date NOT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vehicle_payments`
--

INSERT INTO `vehicle_payments` (`id`, `vehicle_id`, `rent_amount`, `paid_amount`, `payment_date`, `remarks`, `created_at`, `updated_at`) VALUES
(3, 3, 5000.00, 5000.00, '2025-10-22', NULL, '2025-10-22 05:12:38', '2025-10-22 05:12:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account_financial_year_foreign` (`financial_year`),
  ADD KEY `account_product_id_foreign` (`product_id`);

--
-- Indexes for table `account_balances`
--
ALTER TABLE `account_balances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bricks_sales`
--
ALTER TABLE `bricks_sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bricks_sales_vehicle_id_foreign` (`vehicle_id`),
  ADD KEY `bricks_sales_bricks_type_category_id_foreign` (`bricks_type_category_id`),
  ADD KEY `bricks_sales_bricks_type_sub_category_id_foreign` (`bricks_type_sub_category_id`);

--
-- Indexes for table `bricks_stocks`
--
ALTER TABLE `bricks_stocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bricks_stocks_bricks_type_category_id_foreign` (`bricks_type_category_id`);

--
-- Indexes for table `bricks_stocks_transactions`
--
ALTER TABLE `bricks_stocks_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bricks_stocks_transactions_stock_id_foreign` (`stock_id`);

--
-- Indexes for table `bricks_type_categorys`
--
ALTER TABLE `bricks_type_categorys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bricks_type_sub_categorys`
--
ALTER TABLE `bricks_type_sub_categorys`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bricks_type_sub_categorys_bricks_type_category_id_foreign` (`bricks_type_category_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `company_details`
--
ALTER TABLE `company_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `financial_years`
--
ALTER TABLE `financial_years`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `financial_years_name_unique` (`name`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `labours`
--
ALTER TABLE `labours`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `labours_aadhar_no_unique` (`aadhar_no`),
  ADD KEY `labours_labour_type_id_foreign` (`labour_type_id`);

--
-- Indexes for table `labour_payments`
--
ALTER TABLE `labour_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `labour_payments_labour_id_foreign` (`labour_id`);

--
-- Indexes for table `labour_types`
--
ALTER TABLE `labour_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `labour_work_details`
--
ALTER TABLE `labour_work_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `labour_work_details_labour_id_foreign` (`labour_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_purchase_id_foreign` (`purchase_id`),
  ADD KEY `payments_party_id_foreign` (`party_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `purchases_bill_no_unique` (`bill_no`),
  ADD KEY `purchases_financial_year_foreign` (`financial_year`),
  ADD KEY `purchases_party_id_foreign` (`party_id`),
  ADD KEY `purchases_product_id_foreign` (`product_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stocks_product_id_foreign` (`product_id`);

--
-- Indexes for table `stock_transactions`
--
ALTER TABLE `stock_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_transactions_financial_year_foreign` (`financial_year`),
  ADD KEY `stock_transactions_product_id_foreign` (`product_id`),
  ADD KEY `stock_transactions_purchase_id_foreign` (`purchase_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_user_id_unique` (`user_id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicle_payments`
--
ALTER TABLE `vehicle_payments`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `account_balances`
--
ALTER TABLE `account_balances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bricks_sales`
--
ALTER TABLE `bricks_sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `bricks_stocks`
--
ALTER TABLE `bricks_stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `bricks_stocks_transactions`
--
ALTER TABLE `bricks_stocks_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `bricks_type_categorys`
--
ALTER TABLE `bricks_type_categorys`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `bricks_type_sub_categorys`
--
ALTER TABLE `bricks_type_sub_categorys`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `company_details`
--
ALTER TABLE `company_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `financial_years`
--
ALTER TABLE `financial_years`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `labours`
--
ALTER TABLE `labours`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `labour_payments`
--
ALTER TABLE `labour_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `labour_types`
--
ALTER TABLE `labour_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `labour_work_details`
--
ALTER TABLE `labour_work_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `stock_transactions`
--
ALTER TABLE `stock_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `vehicle_payments`
--
ALTER TABLE `vehicle_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `account`
--
ALTER TABLE `account`
  ADD CONSTRAINT `account_financial_year_foreign` FOREIGN KEY (`financial_year`) REFERENCES `financial_years` (`name`) ON DELETE CASCADE,
  ADD CONSTRAINT `account_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bricks_sales`
--
ALTER TABLE `bricks_sales`
  ADD CONSTRAINT `bricks_sales_bricks_type_category_id_foreign` FOREIGN KEY (`bricks_type_category_id`) REFERENCES `bricks_type_categorys` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bricks_sales_bricks_type_sub_category_id_foreign` FOREIGN KEY (`bricks_type_sub_category_id`) REFERENCES `bricks_type_sub_categorys` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `bricks_sales_vehicle_id_foreign` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bricks_stocks`
--
ALTER TABLE `bricks_stocks`
  ADD CONSTRAINT `bricks_stocks_bricks_type_category_id_foreign` FOREIGN KEY (`bricks_type_category_id`) REFERENCES `bricks_type_categorys` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bricks_stocks_transactions`
--
ALTER TABLE `bricks_stocks_transactions`
  ADD CONSTRAINT `bricks_stocks_transactions_stock_id_foreign` FOREIGN KEY (`stock_id`) REFERENCES `bricks_stocks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bricks_type_sub_categorys`
--
ALTER TABLE `bricks_type_sub_categorys`
  ADD CONSTRAINT `bricks_type_sub_categorys_bricks_type_category_id_foreign` FOREIGN KEY (`bricks_type_category_id`) REFERENCES `bricks_type_categorys` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `labours`
--
ALTER TABLE `labours`
  ADD CONSTRAINT `labours_labour_type_id_foreign` FOREIGN KEY (`labour_type_id`) REFERENCES `labour_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `labour_payments`
--
ALTER TABLE `labour_payments`
  ADD CONSTRAINT `labour_payments_labour_id_foreign` FOREIGN KEY (`labour_id`) REFERENCES `labours` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `labour_work_details`
--
ALTER TABLE `labour_work_details`
  ADD CONSTRAINT `labour_work_details_labour_id_foreign` FOREIGN KEY (`labour_id`) REFERENCES `labours` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_party_id_foreign` FOREIGN KEY (`party_id`) REFERENCES `account` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_purchase_id_foreign` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `purchases_financial_year_foreign` FOREIGN KEY (`financial_year`) REFERENCES `financial_years` (`name`) ON DELETE CASCADE,
  ADD CONSTRAINT `purchases_party_id_foreign` FOREIGN KEY (`party_id`) REFERENCES `account` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `purchases_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stocks`
--
ALTER TABLE `stocks`
  ADD CONSTRAINT `stocks_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stock_transactions`
--
ALTER TABLE `stock_transactions`
  ADD CONSTRAINT `stock_transactions_financial_year_foreign` FOREIGN KEY (`financial_year`) REFERENCES `financial_years` (`name`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_transactions_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_transactions_purchase_id_foreign` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
