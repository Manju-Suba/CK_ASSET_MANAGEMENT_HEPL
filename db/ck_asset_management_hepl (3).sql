-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 15, 2022 at 10:38 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 7.4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ck_asset_management_hepl`
--

-- --------------------------------------------------------

--
-- Table structure for table `assets`
--

CREATE TABLE `assets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `assetid` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `a_c_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `a_type_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `locationid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brandid` int(11) NOT NULL,
  `barcode` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `cost` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `warranty` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `available_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `emp_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `spoc_emp_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `r_asset_id` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `picture` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assets`
--

INSERT INTO `assets` (`id`, `assetid`, `type`, `a_c_id`, `a_type_id`, `locationid`, `brandid`, `barcode`, `name`, `quantity`, `date`, `cost`, `warranty`, `available_status`, `emp_id`, `spoc_emp_id`, `r_asset_id`, `status`, `picture`, `description`, `created_at`, `updated_at`) VALUES
(1, 'AST21122913', 'Rental', '1', '1', '1', 1, '234444', 'test name', 'undefined', '2021-12-29', '23000', '', 'Stock', '', 'EMP001', '', 'Active', '1229202109585961cc3163ed7f8new col.PNG', 'test desc', '2021-12-29 04:28:59', '2021-12-30 02:15:21'),
(2, 'AST21123055', 'BYOD', '1', '1', '1', 1, '23423424', 'HPx 3', 'undefined', '2021-12-30', '20000', '', 'Allocated', 'EMP001', 'EMP002', '', 'Active', '1230202107481761cd6441174batest2.PNG', 'asdasd', '2021-12-30 02:18:16', '2022-01-21 02:02:09'),
(3, 'AST211230556', 'Rental', '1', '1', '1', 1, '7987987', 'wtetert', 'undefined', '2021-12-29', '30000', '', 'Retiral', '', 'EMP001', 'AST21123055', 'Active', '1230202107553161cd65f3c964acoll detail.PNG', 'test', '2021-12-30 02:25:31', '2021-12-30 03:04:49'),
(4, 'AST21123066', 'Rental', '1', '1', '1', 1, '345345345', 'test as 44', 'undefined', '2021-12-31', '33333', '', 'Retiral', '', 'EMP001', '', 'Active', '1230202108404561cd708d18fe3valog.PNG', 'test desc', '2021-12-30 03:10:44', '2021-12-30 23:21:54');

-- --------------------------------------------------------

--
-- Table structure for table `asset_category_models`
--

CREATE TABLE `asset_category_models` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `asset_category_models`
--

INSERT INTO `asset_category_models` (`id`, `name`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'IT', 'Test IT desc', 'Active', '2021-12-27 23:18:59', '2021-12-27 23:18:59');

-- --------------------------------------------------------

--
-- Table structure for table `asset_history`
--

CREATE TABLE `asset_history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `assetid` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `employeeid` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `allocated_date` date DEFAULT NULL,
  `get_back_date` date DEFAULT NULL,
  `retiraldate` date DEFAULT NULL,
  `type` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reason` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remark` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `asset_history`
--

INSERT INTO `asset_history` (`id`, `assetid`, `employeeid`, `allocated_date`, `get_back_date`, `retiraldate`, `type`, `location`, `reason`, `remark`, `status`, `created_at`, `updated_at`) VALUES
(1, 'AST21123066', '', '0000-00-00', '0000-00-00', '2022-01-11', 'Retiral', NULL, 'STOLEN', 'test', 'Active', '2022-01-10 01:33:01', '2022-01-10 01:33:01'),
(2, 'AST211230556', '', '0000-00-00', '0000-00-00', '2022-01-10', 'Replacement & Retiral', NULL, 'LOST', 'test', 'Active', '2022-01-10 01:33:25', '2022-01-10 01:33:25'),
(3, 'AST21123055', 'EMP001', '2022-01-10', '2022-01-21', '0000-00-00', 'Allocation', '1', '', '', 'Active', '2022-01-10 01:39:19', '2022-01-21 01:41:03'),
(4, 'AST21123055', 'EMP001', '2022-01-21', '0000-00-00', '0000-00-00', 'Allocation', '', '', '', 'Active', '2022-01-21 02:02:09', '2022-01-21 02:02:09');

-- --------------------------------------------------------

--
-- Table structure for table `asset_type`
--

CREATE TABLE `asset_type` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `c_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `asset_type`
--

INSERT INTO `asset_type` (`id`, `c_id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, '1', 'Laptop', 'test description', '2021-12-28 00:13:46', '2021-12-28 00:13:46');

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Test Brand 1', 'test brand description', '2021-12-20 06:09:49', '2021-12-20 06:09:49');

-- --------------------------------------------------------

--
-- Table structure for table `business_models`
--

CREATE TABLE `business_models` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `business_models`
--

INSERT INTO `business_models` (`id`, `name`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'CKPL', 'CKPL Description', 'Active', '2021-12-28 01:11:23', '2021-12-28 01:11:23'),
(2, 'HEPL', 'HEPL Description', 'Active', '2021-12-28 01:11:42', '2021-12-28 01:11:42');

-- --------------------------------------------------------

--
-- Table structure for table `component`
--

CREATE TABLE `component` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `supplierid` int(11) NOT NULL,
  `typeid` int(11) NOT NULL,
  `brandid` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `serial` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purchasedate` date NOT NULL,
  `cost` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `warranty` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `picture` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `locationid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `component_assets`
--

CREATE TABLE `component_assets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `assetid` int(11) NOT NULL,
  `componentid` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `b_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `b_id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, '1', 'Dept 1', 'test Dept 1', '2021-12-29 01:18:16', '2021-12-29 01:18:16'),
(2, '2', 'Dept 2', 'test Dept 2', '2021-12-29 01:18:38', '2021-12-29 01:18:38');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `emp_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `business` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `departmentid` int(11) NOT NULL,
  `fullname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jobrole` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cost_center` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `specialrole` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supervisor` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `emp_id`, `business`, `departmentid`, `fullname`, `email`, `jobrole`, `city`, `country`, `address`, `cost_center`, `specialrole`, `supervisor`, `status`, `created_at`, `updated_at`) VALUES
(1, 'EMP001', '1', 1, 'narayanan balu', 'gotonarayanan@gmail.com', '', NULL, NULL, NULL, '123', 'Supervisor', '', 'Active', '2021-12-29 01:32:47', '2021-12-29 01:32:47'),
(2, 'EMP002', '1', 1, 'narayanan balu 2', 'gotonarayanan1@gmail.com', '', NULL, NULL, NULL, '12222', 'No', 'EMP001', 'Active', '2021-12-29 01:39:17', '2021-12-29 01:39:17');

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Location1', 'test location description', '2021-12-20 06:09:15', '2021-12-20 06:09:15'),
(2, 'Location 2', 'desc 2', '2021-12-31 04:45:34', '2021-12-31 04:45:34');

-- --------------------------------------------------------

--
-- Table structure for table `maintenance`
--

CREATE TABLE `maintenance` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `assetid` int(11) NOT NULL,
  `supplierid` int(11) NOT NULL,
  `startdate` date NOT NULL,
  `enddate` date NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2020_09_08_144316_user', 1),
(2, '2020_09_08_144451_location', 1),
(6, '2020_09_08_145414_supplier', 1),
(7, '2020_09_08_145942_component', 1),
(8, '2020_09_08_151408_component_assets', 1),
(9, '2020_09_08_151813_brand', 1),
(12, '2020_09_08_155627_maintenance', 1),
(13, '2020_09_09_003638_settings', 1),
(14, '2020_09_10_131841_add_language_currency', 1),
(15, '2020_09_21_000636_add_location_assets', 1),
(16, '2020_09_21_000701_add_location_componen', 1),
(17, '2020_10_13_161122_add_checkstatus', 1),
(21, '2021_12_27_122438_create_asset_category_models_table', 2),
(22, '2020_09_08_144735_asset_type', 3),
(23, '2021_12_28_062740_create_business_models_table', 4),
(38, '2020_09_08_144811_department', 7),
(40, '2020_09_08_144836_employee', 8),
(47, '2020_09_08_151937_asset', 9),
(60, '2020_09_08_155230_asset_history', 10);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company` char(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` char(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` char(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phonenumber` char(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` char(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `formatdate` char(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `currency` char(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `language` char(5) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `company`, `address`, `email`, `phonenumber`, `country`, `logo`, `formatdate`, `created_at`, `updated_at`, `currency`, `language`) VALUES
(1, 'HEMA\'S', 'Sepang', 'info@massets.com', '798989089', 'Malaysia', 'cropped-Hema-logo-1.png', 'd-m-Y', '2020-09-09 11:30:00', '2020-09-09 11:30:00', '$', 'en');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`, `name`, `email`, `city`, `country`, `zip`, `phone`, `address`, `created_at`, `updated_at`) VALUES
(1, 'test supplier 1', 'testsupplier1@gmail.com', 'cuddalore', 'India', '60701', '12345677', '2 kk nagar,vanniyar palayam,cuddalore.', '2021-12-20 06:08:50', '2021-12-20 06:08:50');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fullname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `password`, `status`, `city`, `phone`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin@example.com', '$2y$10$UC70weIRUWjYxfl4n9N3DuytohYU3LDsLTsBuVWFyas29kslhtnGa', '1', 'Selangor', '628548945798', '1', '2020-09-13 00:10:45', '2020-09-13 00:21:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assets`
--
ALTER TABLE `assets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `assets_assetid_unique` (`assetid`);

--
-- Indexes for table `asset_category_models`
--
ALTER TABLE `asset_category_models`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `asset_history`
--
ALTER TABLE `asset_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `asset_type`
--
ALTER TABLE `asset_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `business_models`
--
ALTER TABLE `business_models`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `component`
--
ALTER TABLE `component`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `component_assets`
--
ALTER TABLE `component_assets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employees_emp_id_unique` (`emp_id`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `maintenance`
--
ALTER TABLE `maintenance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assets`
--
ALTER TABLE `assets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `asset_category_models`
--
ALTER TABLE `asset_category_models`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `asset_history`
--
ALTER TABLE `asset_history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `asset_type`
--
ALTER TABLE `asset_type`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `business_models`
--
ALTER TABLE `business_models`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `component`
--
ALTER TABLE `component`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `component_assets`
--
ALTER TABLE `component_assets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `maintenance`
--
ALTER TABLE `maintenance`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
