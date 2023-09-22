-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 22, 2023 at 06:05 PM
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
-- Table structure for table `tradebook`
--

CREATE TABLE `tradebook` (
  `id` bigint NOT NULL,
  `watchlist_id` bigint UNSIGNED NOT NULL,
  `date` date DEFAULT NULL,
  `quantity` int NOT NULL,
  `price` double(10,2) NOT NULL,
  `amount` double(10,2) NOT NULL,
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

INSERT INTO `tradebook` (`id`, `watchlist_id`, `date`, `quantity`, `price`, `amount`, `status`, `ip_address`, `created_by`, `created_dt`, `updated_by`, `updated_dt`) VALUES
(1, 2, '2023-09-18', 130, 263.50, 34255.00, 1, '', NULL, NULL, NULL, NULL),
(2, 2, '2023-09-21', 150, 274.30, 41145.00, 1, '', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `watchlist`
--

CREATE TABLE `watchlist` (
  `id` int NOT NULL,
  `scrip_name` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `current_price` double(10,2) DEFAULT NULL,
  `desired_per_share_price` int NOT NULL,
  `desired_profit` double(10,2) DEFAULT NULL,
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

INSERT INTO `watchlist` (`id`, `scrip_name`, `current_price`, `desired_per_share_price`, `desired_profit`, `date`, `status`, `ip_address`, `created_by`, `created_dt`, `updated_by`, `updated_dt`) VALUES
(1, 'TS', 128.30, 1, 200.00, '2023-09-20', 1, '::1', NULL, NULL, 0, 1695289851),
(2, 'TP', 258.50, 2, 200.00, '2023-09-14', 1, '::1', NULL, NULL, 0, 1695190183),
(3, 'TM', 627.35, 5, 500.00, '2023-09-14', 1, '::1', NULL, NULL, 0, 1695190164);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tradebook`
--
ALTER TABLE `tradebook`
  ADD PRIMARY KEY (`id`),
  ADD KEY `watchlist_id` (`watchlist_id`);

--
-- Indexes for table `watchlist`
--
ALTER TABLE `watchlist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tradebook`
--
ALTER TABLE `tradebook`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `watchlist`
--
ALTER TABLE `watchlist`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
