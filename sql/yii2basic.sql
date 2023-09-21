-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 21, 2023 at 05:09 PM
-- Server version: 8.0.34-0ubuntu0.22.04.1
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `yii2basic`
--

-- --------------------------------------------------------

--
-- Table structure for table `auth_assignment`
--

CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `user_id` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('admin', '1', NULL),
('create-branch', '2', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item`
--

CREATE TABLE `auth_item` (
  `name` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `type` smallint NOT NULL,
  `description` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `rule_name` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('admin', 1, 'allow to create branch and company', NULL, NULL, NULL, NULL),
('create-branch', 1, 'allow a user to add branch', NULL, NULL, NULL, NULL),
('create-company', 1, 'allow a user to add company', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item_child`
--

CREATE TABLE `auth_item_child` (
  `parent` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `child` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('admin', 'create-branch'),
('admin', 'create-company');

-- --------------------------------------------------------

--
-- Table structure for table `auth_rule`
--

CREATE TABLE `auth_rule` (
  `name` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `id` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `gender` enum('male','female') NOT NULL DEFAULT 'male',
  `address` text NOT NULL,
  `profile` varchar(250) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ref_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `name`, `email`, `phone`, `gender`, `address`, `profile`, `created_at`, `ref_id`) VALUES
(1, 'Amit', 'amit@gmail.com', '7865100980', 'male', 'test', '', '2020-07-15 17:19:01', 0),
(2, 'Ramesh', 'ramesh@gmail.com', '7867120982', 'male', '', '', '2020-07-15 17:19:01', 1),
(3, 'priyanka', 'priyanka@gmail.com', '8807120980', 'female', '', '', '2020-07-15 17:19:01', 0),
(4, 'Mario', 'mario@gmail.com', '9888120966', 'male', '', '', '2020-07-15 17:19:01', 3),
(5, 'Vishnu', 'vishnu@gmail.com', '9807120981', 'male', '', '', '2020-07-15 17:19:01', 1),
(6, 'Mahesh', 'mahes@gmail.com', '6807120911', 'male', '', '', '2020-07-15 17:19:01', 1),
(7, 'Helal', 'helal@gmail.com', '<b>880712098</b>', 'male', '', '', '2020-07-15 17:19:01', 1),
(11, 'test', 'test@gmail.com', '7865100980', 'male', 'testing', '1607084774.png', '0000-00-00 00:00:00', 33),
(12, 'final test', 'testfinal@gmail.com', '7865100980', 'male', 'ttttttt', '1607084817.png', '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1607192075),
('m140506_102106_rbac_init', 1607193855),
('m170907_052038_rbac_add_index_on_auth_assignment_user_id', 1607193856),
('m180523_151638_rbac_updates_indexes_without_prefix', 1607193857),
('m200409_110543_rbac_update_mssql_trigger', 1607193857);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int NOT NULL,
  `name` varchar(40) NOT NULL,
  `email` varchar(20) DEFAULT NULL,
  `phone_no` varchar(14) NOT NULL,
  `profile_pic` varchar(200) DEFAULT NULL,
  `password` varchar(200) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `name`, `email`, `phone_no`, `profile_pic`, `password`, `created_at`) VALUES
(7, 'Mikky', 'mikki@gmail.com', '7800980067', '1596568227.png', '123456', '2020-08-04 19:10:27'),
(8, 'Remo', 'remo@gmail.com', '9800990909', '1596568261.png', '989898', '2020-08-04 19:11:01'),
(9, 'surus', 'suru@gmail.com', '6789098767', '1596568288.png', '1212', '2020-08-04 19:11:28'),
(10, 'DSSR', 'dssr@gmail.com', '7800098009', '1596568347.png', '0909', '2020-08-04 19:12:27'),
(11, 'noone', 'noone@gmail.com', '8000900099', 'TEST', '890890', '2020-08-04 19:13:02'),
(16, 'Code Improve', 'code@gmail.com', '9090909090', 'test.png', '12345678', '2020-11-07 10:43:15'),
(17, 'real data', 'real@gmail.com', '9087891191', 'real.jpg', 'Facebook', '2020-11-08 09:52:52'),
(20, 'test data', 'testdata@gmail.com', '9898989890', 'test.jpg', '1234', '2020-11-08 10:40:43'),
(21, 'samir', 'samir@gmail.com', '9898989898', '9898989', '1234', '2022-12-31 18:30:00'),
(22, 'Mikky', 'mikki@gmail.com', '7800980067', '1596568227.png', '123456', '2020-08-04 13:40:27'),
(23, 'Remo', 'remo@gmail.com', '9800990909', '1596568261.png', '989898', '2020-08-04 13:41:01'),
(24, 'surus', 'suru@gmail.com', '6789098767', '1596568288.png', '1212', '2020-08-04 13:41:28'),
(25, 'DSSR', 'dssr@gmail.com', '7800098009', '1596568347.png', '0909', '2020-08-04 13:42:27'),
(26, 'noone', 'noone@gmail.com', '8000900099', NULL, '890890', '2020-08-04 13:43:02'),
(27, 'Code Improve', 'code@gmail.com', '9090909090', 'test.png', '12345678', '2020-11-07 05:13:15'),
(28, 'real data', 'real@gmail.com', '9087891191', 'real.jpg', 'Facebook', '2020-11-08 04:22:52'),
(29, 'test data', 'testdata@gmail.com', '9898989890', 'test.jpg', '1234', '2020-11-08 05:10:43'),
(30, 'samir', 'samir@gmail.com', '9898989898', '9898989', '1234', '2022-12-31 13:00:00'),
(31, 'Mikky', 'mikki@gmail.com', '7800980067', '1596568227.png', '123456', '2020-08-04 13:40:27'),
(32, 'Remo', 'remo@gmail.com', '9800990909', '1596568261.png', '989898', '2020-08-04 13:41:01'),
(33, 'surus', 'suru@gmail.com', '6789098767', '1596568288.png', '1212', '2020-08-04 13:41:28'),
(34, 'DSSR', 'dssr@gmail.com', '7800098009', '1596568347.png', '0909', '2020-08-04 13:42:27'),
(35, 'noone', 'noone@gmail.com', '8000900099', NULL, '890890', '2020-08-04 13:43:02'),
(36, 'Code Improve', 'code@gmail.com', '9090909090', 'test.png', '12345678', '2020-11-07 05:13:15'),
(37, 'real data', 'real@gmail.com', '9087891191', 'real.jpg', 'Facebook', '2020-11-08 04:22:52'),
(38, 'test data', 'testdata@gmail.com', '9898989890', 'test.jpg', '1234', '2020-11-08 05:10:43'),
(39, 'samir', 'samir@gmail.com', '9898989898', '9898989', '1234', '2022-12-31 13:00:00'),
(40, 'Mikky', 'mikki@gmail.com', '7800980067', '1596568227.png', '123456', '2020-08-04 13:40:27'),
(41, 'Remo', 'remo@gmail.com', '9800990909', '1596568261.png', '989898', '2020-08-04 13:41:01'),
(42, 'surus', 'suru@gmail.com', '6789098767', '1596568288.png', '1212', '2020-08-04 13:41:28'),
(43, 'DSSR', 'dssr@gmail.com', '7800098009', '1596568347.png', '0909', '2020-08-04 13:42:27'),
(44, 'noone', 'noone@gmail.com', '8000900099', NULL, '890890', '2020-08-04 13:43:02'),
(45, 'Code Improve', 'code@gmail.com', '9090909090', 'test.png', '12345678', '2020-11-07 05:13:15'),
(46, 'real data', 'real@gmail.com', '9087891191', 'real.jpg', 'Facebook', '2020-11-08 04:22:52'),
(47, 'test data', 'testdata@gmail.com', '9898989890', 'test.jpg', '1234', '2020-11-08 05:10:43'),
(48, 'samir', 'samir@gmail.com', '9898989898', '9898989', '1234', '2022-12-31 13:00:00'),
(49, 'Mikky', 'mikki@gmail.com', '7800980067', '1596568227.png', '123456', '2020-08-04 13:40:27'),
(50, 'Remo', 'remo@gmail.com', '9800990909', '1596568261.png', '989898', '2020-08-04 13:41:01'),
(51, 'surus', 'suru@gmail.com', '6789098767', '1596568288.png', '1212', '2020-08-04 13:41:28'),
(52, 'DSSR', 'dssr@gmail.com', '7800098009', '1596568347.png', '0909', '2020-08-04 13:42:27'),
(53, 'noone', 'noone@gmail.com', '8000900099', NULL, '890890', '2020-08-04 13:43:02'),
(54, 'Code Improve', 'code@gmail.com', '9090909090', 'test.png', '12345678', '2020-11-07 05:13:15'),
(55, 'real data', 'real@gmail.com', '9087891191', 'real.jpg', 'Facebook', '2020-11-08 04:22:52'),
(56, 'test data', 'testdata@gmail.com', '9898989890', 'test.jpg', '1234', '2020-11-08 05:10:43'),
(57, 'samir', 'samir@gmail.com', '9898989898', '9898989', '1234', '2022-12-31 13:00:00'),
(58, 'Mikky', 'mikki@gmail.com', '7800980067', '1596568227.png', '123456', '2020-08-04 13:40:27'),
(59, 'Remo', 'remo@gmail.com', '9800990909', '1596568261.png', '989898', '2020-08-04 13:41:01'),
(60, 'surus', 'suru@gmail.com', '6789098767', '1596568288.png', '1212', '2020-08-04 13:41:28'),
(61, 'DSSR', 'dssr@gmail.com', '7800098009', '1596568347.png', '0909', '2020-08-04 13:42:27'),
(62, 'noone', 'noone@gmail.com', '8000900099', NULL, '890890', '2020-08-04 13:43:02'),
(63, 'Code Improve', 'code@gmail.com', '9090909090', 'test.png', '12345678', '2020-11-07 05:13:15'),
(64, 'real data', 'real@gmail.com', '9087891191', 'real.jpg', 'Facebook', '2020-11-08 04:22:52'),
(65, 'test data', 'testdata@gmail.com', '9898989890', 'test.jpg', '1234', '2020-11-08 05:10:43'),
(66, 'samir', 'samir@gmail.com', '9898989898', '9898989', '1234', '2022-12-31 13:00:00'),
(67, 'Mikky', 'mikki@gmail.com', '7800980067', '1596568227.png', '123456', '2020-08-04 13:40:27'),
(68, 'Remo', 'remo@gmail.com', '9800990909', '1596568261.png', '989898', '2020-08-04 13:41:01'),
(69, 'surus', 'suru@gmail.com', '6789098767', '1596568288.png', '1212', '2020-08-04 13:41:28'),
(70, 'DSSR', 'dssr@gmail.com', '7800098009', '1596568347.png', '0909', '2020-08-04 13:42:27'),
(75, 'samir', 'samir@gmail.com', '9898989898', '9898989', '1234', '2022-12-31 13:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `id` int NOT NULL,
  `student_id` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`id`, `student_id`, `name`, `created_at`) VALUES
(1, 7, 'Math', '2020-07-10 19:23:51'),
(2, 7, 'Science', '2020-07-10 19:23:51'),
(3, 8, 'Science', '2020-07-10 19:23:51'),
(4, 8, 'Hindi', '2020-07-10 19:23:51'),
(5, 8, 'SST', '2020-07-10 19:23:51'),
(6, 8, 'ECO', '2020-07-10 19:23:51'),
(7, 4, 'GK', '2020-07-10 19:23:51'),
(8, 4, 'ENGLISH', '2020-07-10 19:23:51'),
(9, 4, 'COM', '2020-07-10 19:23:51'),
(10, 4, 'Hindi', '2020-07-10 19:23:51'),
(11, 4, 'SST', '2020-07-10 19:23:51'),
(12, 1, 'Science', '2020-07-10 19:23:51');

-- --------------------------------------------------------

--
-- Table structure for table `tradebook`
--

CREATE TABLE `tradebook` (
  `id` bigint NOT NULL,
  `watchlist_id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL,
  `price` double(10,2) NOT NULL,
  `amount` double(10,2) NOT NULL,
  `date` date DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1=>active,0=>inactive',
  `ip_address` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `created_dt` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `updated_dt` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tradebook`
--

INSERT INTO `tradebook` (`id`, `watchlist_id`, `quantity`, `price`, `amount`, `date`, `status`, `ip_address`, `created_by`, `created_dt`, `updated_by`, `updated_dt`) VALUES
(1, 1, 10, 251.00, 2510.00, '2023-09-21', 1, '', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `auth_key` varchar(250) NOT NULL,
  `password_hash` varchar(250) NOT NULL,
  `password_reset_token` varchar(250) NOT NULL,
  `status` varchar(250) NOT NULL,
  `role` varchar(250) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `created_at`, `auth_key`, `password_hash`, `password_reset_token`, `status`, `role`, `updated_at`) VALUES
(1, 'root', 'test@gmail.com', '', '0000-00-00 00:00:00', '', '', '', '9', '', '0000-00-00 00:00:00'),
(2, 'demos', 'demo@gmail.com', '', '0000-00-00 00:00:00', '', '$2y$13$N9zp3iMVLReVvOSTEPKYz.nzVC99fyIpnnfOwmWL9kXlKE3HldJim', '', '9', '', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `watchlist`
--

CREATE TABLE `watchlist` (
  `id` int NOT NULL,
  `scrip_name` varchar(32) COLLATE utf8mb4_general_ci NOT NULL,
  `desired_per_share_price` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `desired_profit` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `date` date DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1=>active,0=>inactive',
  `ip_address` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `created_by` int DEFAULT NULL,
  `created_dt` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `updated_dt` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `watchlist`
--

INSERT INTO `watchlist` (`id`, `scrip_name`, `desired_per_share_price`, `desired_profit`, `date`, `status`, `ip_address`, `created_by`, `created_dt`, `updated_by`, `updated_dt`) VALUES
(1, 'TS', '1.5', '200', '2023-09-20', 1, '::1', NULL, NULL, 0, 1695289851),
(2, 'TP', '2', '200', '2023-09-14', 1, '::1', NULL, NULL, 0, 1695190183),
(3, 'TM', '5', '500', '2023-09-14', 1, '::1', NULL, NULL, 0, 1695190164);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD PRIMARY KEY (`item_name`,`user_id`),
  ADD KEY `idx-auth_assignment-user_id` (`user_id`);

--
-- Indexes for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `idx-auth_item-type` (`type`);

--
-- Indexes for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Indexes for table `auth_rule`
--
ALTER TABLE `auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `tradebook`
--
ALTER TABLE `tradebook`
  ADD PRIMARY KEY (`id`),
  ADD KEY `watchlist_id` (`watchlist_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `watchlist`
--
ALTER TABLE `watchlist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tradebook`
--
ALTER TABLE `tradebook`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `watchlist`
--
ALTER TABLE `watchlist`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
