-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 05, 2025 at 03:05 AM
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
-- Database: `membership`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `Adminid` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `verification_code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`Adminid`, `Username`, `Password`, `email`, `verification_code`) VALUES
(1, 'ADMIN', '$2y$10$ObTThPGXgYZS4o0wh3snIO/7h0sG6lJHuUeES7cWO6xK5JkNYcE4y', 'dummy@gmail.com', 0);

-- --------------------------------------------------------

--
-- Table structure for table `equipmentlogs`
--

CREATE TABLE `equipmentlogs` (
  `Logid` int(11) NOT NULL,
  `Memberid` int(11) DEFAULT NULL,
  `Equipmentuse` varchar(255) DEFAULT NULL,
  `Logtimestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `equipmentlogs`
--

INSERT INTO `equipmentlogs` (`Logid`, `Memberid`, `Equipmentuse`, `Logtimestamp`) VALUES
(2, 3, 'Jumping Rope', '2025-01-16 00:20:18');

-- --------------------------------------------------------

--
-- Table structure for table `equipmentname`
--

CREATE TABLE `equipmentname` (
  `equipment_id` int(11) NOT NULL,
  `equipment_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `equipmentname`
--

INSERT INTO `equipmentname` (`equipment_id`, `equipment_name`) VALUES
(1, 'Treadmills'),
(5, 'Barbell'),
(6, 'Jumping Rope');

-- --------------------------------------------------------

--
-- Table structure for table `equipmentrentals`
--

CREATE TABLE `equipmentrentals` (
  `Rentalid` int(11) NOT NULL,
  `Memberid` int(11) NOT NULL,
  `Equipmentname` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `equipmentrentals`
--

INSERT INTO `equipmentrentals` (`Rentalid`, `Memberid`, `Equipmentname`) VALUES
(2, 2, 'None'),
(3, 3, 'Jumping Rope'),
(4, 4, 'None');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `Logid` int(11) NOT NULL,
  `Memberid` int(11) NOT NULL,
  `Activity` varchar(100) NOT NULL,
  `Activitydate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`Logid`, `Memberid`, `Activity`, `Activitydate`) VALUES
(2, 2, 'In', '2025-01-15 12:13:54'),
(3, 3, 'In', '2025-01-15 12:15:09'),
(4, 2, 'Out', '2025-01-15 12:15:46'),
(5, 4, 'In', '2025-01-16 00:19:49'),
(8, 4, 'Out', '2025-06-14 03:56:13');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `Memberid` int(11) NOT NULL,
  `Firstname` varchar(50) NOT NULL,
  `Middlename` varchar(50) DEFAULT NULL,
  `Lastname` varchar(50) NOT NULL,
  `Contactnumber` varchar(15) NOT NULL,
  `Address` varchar(100) NOT NULL,
  `Birthdate` date DEFAULT NULL,
  `Membershiptype` enum('Member','Session') NOT NULL,
  `Startdate` date NOT NULL,
  `Enddate` date NOT NULL,
  `Status` enum('In','Out') DEFAULT 'Out',
  `ProfileImage` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`Memberid`, `Firstname`, `Middlename`, `Lastname`, `Contactnumber`, `Address`, `Birthdate`, `Membershiptype`, `Startdate`, `Enddate`, `Status`, `ProfileImage`) VALUES
(2, 'Marcel', 'Del Pelar', 'Mercado', '09342346234', 'G.M.A, Brgy Poblacion 5, Blk 11 Lot 15', NULL, 'Session', '2025-01-15', '2025-02-14', 'Out', 'uploads/customer2.jpg'),
(3, 'Paulo', 'C.', 'Escobar', '09213123123', 'G.M.A, San Jose, Blk 15 Lot 12', NULL, 'Member', '2025-01-15', '2025-02-14', 'In', 'uploads/customer3.jpg'),
(4, 'Mark', 'Balyosa', 'Mercus', '09692942182', 'Manila Tondo, Philippines Cavite', NULL, 'Session', '2025-06-14', '2025-02-15', 'Out', 'uploads/customer1.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `equipmentlogs`
--
ALTER TABLE `equipmentlogs`
  ADD PRIMARY KEY (`Logid`),
  ADD KEY `member_id` (`Memberid`);

--
-- Indexes for table `equipmentname`
--
ALTER TABLE `equipmentname`
  ADD PRIMARY KEY (`equipment_id`);

--
-- Indexes for table `equipmentrentals`
--
ALTER TABLE `equipmentrentals`
  ADD PRIMARY KEY (`Rentalid`),
  ADD KEY `Memberid` (`Memberid`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`Logid`),
  ADD KEY `Memberid` (`Memberid`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`Memberid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `equipmentlogs`
--
ALTER TABLE `equipmentlogs`
  MODIFY `Logid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `equipmentname`
--
ALTER TABLE `equipmentname`
  MODIFY `equipment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `equipmentrentals`
--
ALTER TABLE `equipmentrentals`
  MODIFY `Rentalid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `Logid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `Memberid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `equipmentlogs`
--
ALTER TABLE `equipmentlogs`
  ADD CONSTRAINT `equipmentlogs_ibfk_1` FOREIGN KEY (`Memberid`) REFERENCES `members` (`Memberid`);

--
-- Constraints for table `equipmentrentals`
--
ALTER TABLE `equipmentrentals`
  ADD CONSTRAINT `equipmentrentals_ibfk_1` FOREIGN KEY (`Memberid`) REFERENCES `members` (`Memberid`);

--
-- Constraints for table `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `logs_ibfk_1` FOREIGN KEY (`Memberid`) REFERENCES `members` (`Memberid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
