-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 12, 2023 at 11:07 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `customerservices`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `DeleteOldJobs` ()   BEGIN
    DELETE FROM `job`
    WHERE `date` IS NOT NULL AND `date` < DATE_SUB(NOW(), INTERVAL 12 MONTH);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Washing machine'),
(2, 'Refrigerator'),
(8, 'Heater');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `message` text DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job`
--

CREATE TABLE `job` (
  `id` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `job_status` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `engineer_id` int(11) DEFAULT NULL,
  `feedback` text DEFAULT NULL,
  `rank` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job`
--

INSERT INTO `job` (`id`, `description`, `category_id`, `user_id`, `job_status`, `date`, `engineer_id`, `feedback`, `rank`) VALUES
(2, 'testing123', 2, 6, 'Complete', '2023-12-01', 5, NULL, NULL),
(3, 'Testing....', 1, 4, 'Complete', '2023-12-07', 5, 'good', 4),
(4, 'testing testing testing testing testing testing testing testing testing testing testing testing', 2, 4, 'Accepted', '2023-12-07', 7, NULL, NULL),
(5, 'testing', 1, 4, 'Complete', '2023-12-07', 5, NULL, NULL),
(6, 'testing 1', 1, 4, 'Accepted', '2023-12-07', 7, NULL, NULL),
(7, 'testingfsfsf', 1, 10, 'Complete', '2023-12-07', 5, 'testing', 5),
(8, 'testing1456', 1, 10, 'Complete', '2023-12-07', 5, 'Good', 5),
(10, 'tester', 1, 10, 'Complete', '2023-12-07', 5, NULL, NULL),
(11, 'test333', 1, 10, 'Accepted', '2023-12-07', 5, NULL, NULL),
(15, 'test556', 2, 10, 'Accepted', '2023-12-07', 5, NULL, NULL),
(16, 'test 1567', 1, 10, 'Accepted', '2023-12-07', 5, NULL, NULL),
(17, 'test789', 1, 10, 'Accepted', '2023-12-07', 5, NULL, NULL),
(18, 'Pyin yan2', 2, 10, 'Complete', '2023-12-10', 5, 'not bad', 3),
(19, 'testing 167', 2, 4, 'Complete', '2023-12-10', 11, 'Very good service', 4),
(24, 'Testing 999', 8, 4, 'Accepted', '2023-12-12', 5, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `name`) VALUES
(1, 'customer'),
(2, 'engineer'),
(3, 'system manager');

-- --------------------------------------------------------

--
-- Table structure for table `user_table`
--

CREATE TABLE `user_table` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `ph_number` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `postcode` varchar(20) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_table`
--

INSERT INTO `user_table` (`id`, `name`, `email`, `password`, `ph_number`, `address`, `postcode`, `role_id`, `gender`, `category_id`) VALUES
(2, 'Lin Te Mye', 'lintmye777@gmail.com', '$2y$10$yZlJBzNnlm7eDU.TYJVGXegwJWbPOR/lt9W39ArVUdlv4cRyUKyOW', '0943164774', 'london', 'N7 8RT', 1, 'male', NULL),
(3, 'Formula', 'formula@gmail.com', '$2y$10$CVIdSeyd/jqH2SuRwADHHeftbNb.joTM0I/CD773BIBBhWnY/0WcK', '0777431524', 'Islington', 'N5 TYL', 1, 'male', NULL),
(4, 'lin', 'lin@gmail.com', '$2y$10$dRfleoqk73I3sy3/RkRBZOFA0MTpSdB5eScJqmzA4tSg5ryFXwHm.', '0943153774', 'london', 'N7 8RT', 1, 'female', NULL),
(5, 'Tony', 'tony@gmail.com', '$2y$10$cGQKv0EzqeqyEZu078nn/OTIp4JVum.DmhPutTDk5mp9L0kP/G97.', '09953164774', NULL, NULL, 2, NULL, NULL),
(6, 'admin', 'admin@gmail.com', '$2y$10$IO5S47RJjTkq6ccBovWu7.qZFQydbCJLe7OMmeLLKzDN8RRfpFjgW', '07774413524', 'london', 'N7 8RT', 3, 'male', NULL),
(7, 'Aung', 'aung@gmail.com', '$2y$10$wxeQa49SdK3qQMaOQTUhwOXv7Z0.ux7XS.BPdSz1nN7y8bs3Mo5Ke', '07774315678', NULL, NULL, 2, NULL, NULL),
(10, 'Jack', 'jack@gmail.com', '$2y$10$dK2VGBC/WrKAYHZevkwUdu3J9vrWsnCpbG0QGg0U7TwghXvdLv/g6', '07765487342', 'Manchester city', 'N7 8RT', 1, 'male', NULL),
(11, 'Smith', 'smith@gmail.com', '$2y$10$cxMnxKrcWK9HcacCRKjkfuN6LSHxPJP1/DLm2RbrlDzrNVi0V0U4S', '07775483724', NULL, NULL, 2, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `feedback_ibfk_1` (`user_id`);

--
-- Indexes for table `job`
--
ALTER TABLE `job`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_category_id` (`category_id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_engineer_id` (`engineer_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_table`
--
ALTER TABLE `user_table`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `user_table_ibfk_2` (`category_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `job`
--
ALTER TABLE `job`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `user_table`
--
ALTER TABLE `user_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_table` (`id`);

--
-- Constraints for table `job`
--
ALTER TABLE `job`
  ADD CONSTRAINT `fk_category_id` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `fk_engineer_id` FOREIGN KEY (`engineer_id`) REFERENCES `user_table` (`id`),
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `user_table` (`id`);

--
-- Constraints for table `user_table`
--
ALTER TABLE `user_table`
  ADD CONSTRAINT `user_table_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`),
  ADD CONSTRAINT `user_table_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `delete_old_jobs_event` ON SCHEDULE EVERY 1 DAY STARTS '2023-12-11 19:20:02' ON COMPLETION NOT PRESERVE ENABLE COMMENT 'Deletes old job records' DO BEGIN
    CALL DeleteOldJobs();
END$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
