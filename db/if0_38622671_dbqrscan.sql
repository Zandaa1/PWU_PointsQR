-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql306.infinityfree.com
-- Generation Time: Apr 03, 2025 at 09:07 PM
-- Server version: 10.6.19-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_38622671_dbqrscan`
--

-- --------------------------------------------------------

--
-- Table structure for table `qr_codes`
--

CREATE TABLE `qr_codes` (
  `id` int(6) UNSIGNED NOT NULL,
  `unique_text` varchar(255) NOT NULL,
  `booth_name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `points` int(6) NOT NULL,
  `expiration_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `qr_codes`
--

INSERT INTO `qr_codes` (`id`, `unique_text`, `booth_name`, `description`, `points`, `expiration_time`, `created_at`) VALUES
(1, 'IOKSA', 'IT Booth', 'Visiting the booth.', 1, '2025-12-14 04:00:00', '2025-03-12 14:43:59'),
(4, 'IOKSW', 'IT Booth', 'Bought Sticker', 5, '2025-03-14 05:33:00', '2025-03-13 05:33:51'),
(5, 'MNY5T', 'Sample Booth', '+50 visited booth', 50, '2025-03-27 16:00:00', '2025-03-27 12:25:56'),
(6, 'devQR', 'QR Test 2', 'test description', 99, '2026-12-13 16:00:00', '2025-03-27 18:45:39');

-- --------------------------------------------------------

--
-- Table structure for table `scan_history`
--

CREATE TABLE `scan_history` (
  `id` int(6) UNSIGNED NOT NULL,
  `user_id` int(6) UNSIGNED NOT NULL,
  `qr_code_id` int(6) UNSIGNED DEFAULT NULL,
  `scan_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `points_added` int(6) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `scan_history`
--

INSERT INTO `scan_history` (`id`, `user_id`, `qr_code_id`, `scan_time`, `points_added`, `description`) VALUES
(8, 1, 1, '2025-03-13 05:33:18', 1, NULL),
(9, 1, 4, '2025-03-13 05:34:03', 5, NULL),
(10, 1, 5, '2025-03-27 12:26:41', 50, NULL),
(12, 1, 6, '2025-03-27 18:48:39', 99, 'test description'),
(16, 2, 1, '2025-03-30 23:44:50', 1, 'Visiting the booth.'),
(17, 2, NULL, '2025-03-31 05:08:11', -1, 'PWU Hat'),
(18, 1, NULL, '2025-03-31 05:59:58', -3000, 'Foodpanda Voucher P100'),
(19, 1, NULL, '2025-03-31 06:00:18', -3000, 'Foodpanda Voucher P100'),
(20, 1, NULL, '2025-03-31 06:00:23', -3000, 'Foodpanda Voucher P100'),
(21, 1, NULL, '2025-03-31 06:02:04', -500, 'P500'),
(22, 1, NULL, '2025-03-31 07:48:00', -200, 'Tshirt'),
(23, 2, 6, '2025-03-31 09:16:23', 99, 'test description'),
(24, 2, NULL, '2025-03-31 09:16:46', -50, 'Food'),
(25, 2, NULL, '2025-03-31 09:18:26', -90, 'T-Shirt'),
(26, 3, 6, '2025-04-03 16:57:00', 99, 'test description'),
(27, 3, NULL, '2025-04-03 16:58:18', -5, 'Food'),
(28, 4, 6, '2025-04-04 00:25:13', 99, 'test description');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(6) UNSIGNED NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('student','faculty','admin') NOT NULL,
  `points` int(6) UNSIGNED DEFAULT 0,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `points`, `reg_date`, `name`, `email`) VALUES
(1, 'a1550023', '1234', 'admin', 300, '2025-03-31 07:48:00', '', ''),
(2, 'dummyacc', '1234', 'student', 9910, '2025-03-31 09:18:26', '', ''),
(3, 'Liah ', 'liah05', 'student', 94, '2025-04-03 16:58:18', '', ''),
(4, 'Zandaa', '1234', 'student', 99, '2025-04-04 00:25:13', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `qr_codes`
--
ALTER TABLE `qr_codes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_text` (`unique_text`);

--
-- Indexes for table `scan_history`
--
ALTER TABLE `scan_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `qr_code_id` (`qr_code_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `qr_codes`
--
ALTER TABLE `qr_codes`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `scan_history`
--
ALTER TABLE `scan_history`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `scan_history`
--
ALTER TABLE `scan_history`
  ADD CONSTRAINT `scan_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `scan_history_ibfk_2` FOREIGN KEY (`qr_code_id`) REFERENCES `qr_codes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
