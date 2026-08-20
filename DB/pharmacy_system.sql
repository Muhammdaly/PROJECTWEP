-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 20, 2026 at 08:48 AM
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
-- Database: `pharmacy_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `medicines`
--

CREATE TABLE `medicines` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medicines`
--

INSERT INTO `medicines` (`id`, `name`) VALUES
(16, 'باراسيتامول'),
(17, 'بانادول'),
(18, 'أوجمنتين'),
(19, 'كتافلام'),
(20, 'فولتارين'),
(21, 'نيوروفين'),
(22, 'زيرتك'),
(23, 'كونجستال'),
(24, 'بروفين'),
(25, 'انتينال');

-- --------------------------------------------------------

--
-- Table structure for table `pharmacies`
--

CREATE TABLE `pharmacies` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pharmacies`
--

INSERT INTO `pharmacies` (`id`, `name`, `address`, `phone`, `user_id`, `image`) VALUES
(14, 'صيدلية العزبي - مدينة نصر', 'القاهرة، مدينة نصر، شارع عباس العقاد', '01012345001', 3, 'imags/pharmacy1.png'),
(15, 'صيدلية سيف - المعادي', 'القاهرة، المعادي، شارع 9', '01012345002', 3, 'imags/pharmacy2.png'),
(16, 'صيدلية 19011 - مصر الجديدة', 'القاهرة، مصر الجديدة، شارع الميرغني', '01012345003', 3, 'imags/pharmacy3.png'),
(17, 'صيدلية رشدي - وسط البلد', 'القاهرة، وسط البلد، شارع طلعت حرب', '01012345004', 3, 'imags/pharmacy4.png'),
(18, 'صيدلية النهضة - المهندسين', 'القاهرة، المهندسين، شارع جامعة الدول', '01012345005', 3, 'imags/pharmacy5.png');

-- --------------------------------------------------------

--
-- Table structure for table `pharmacy_medicines`
--

CREATE TABLE `pharmacy_medicines` (
  `id` int(11) NOT NULL,
  `pharmacy_id` int(11) NOT NULL,
  `medicine_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pharmacy_medicines`
--

INSERT INTO `pharmacy_medicines` (`id`, `pharmacy_id`, `medicine_id`, `quantity`, `price`) VALUES
(31, 14, 16, 50, 10.50),
(32, 14, 17, 30, 15.00),
(33, 14, 19, 20, 25.00),
(34, 15, 16, 15, 11.00),
(35, 15, 18, 40, 45.00),
(36, 15, 21, 25, 20.00),
(37, 16, 17, 60, 14.50),
(38, 16, 20, 35, 30.00),
(39, 16, 24, 45, 18.00),
(40, 17, 16, 10, 12.00),
(41, 17, 22, 20, 35.00),
(42, 17, 25, 15, 22.00),
(43, 18, 18, 25, 44.00),
(44, 18, 23, 30, 16.50),
(45, 18, 20, 10, 31.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(30) NOT NULL DEFAULT 'user',
  `image` varchar(255) DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `image`, `date`) VALUES
(3, 'm', 'n@gmail.com', '$2y$10$OhRZggAeDbwFwzAPj18kfepqz2MQmHQVBIRO3X4iSWn.w0DvN6hg2', 'user', 'upload/pharmacy1.png', '2026-08-18 15:07:32'),
(4, 'mmm', 'mmm@gmail.com', '$2y$10$wUqw.SF3cRY05Ad9x5SZzOyILneJfgpW7/81KrFHNYiNxk1l7ExS6', 'user', NULL, '2026-08-20 02:59:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `medicines`
--
ALTER TABLE `medicines`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pharmacies`
--
ALTER TABLE `pharmacies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `pharmacy_medicines`
--
ALTER TABLE `pharmacy_medicines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pharmacy_id` (`pharmacy_id`),
  ADD KEY `medicine_id` (`medicine_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `medicines`
--
ALTER TABLE `medicines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `pharmacies`
--
ALTER TABLE `pharmacies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `pharmacy_medicines`
--
ALTER TABLE `pharmacy_medicines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pharmacies`
--
ALTER TABLE `pharmacies`
  ADD CONSTRAINT `pharmacies_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `pharmacy_medicines`
--
ALTER TABLE `pharmacy_medicines`
  ADD CONSTRAINT `pharmacy_medicines_ibfk_1` FOREIGN KEY (`pharmacy_id`) REFERENCES `pharmacies` (`id`),
  ADD CONSTRAINT `pharmacy_medicines_ibfk_2` FOREIGN KEY (`medicine_id`) REFERENCES `medicines` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
