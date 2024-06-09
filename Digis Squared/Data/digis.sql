-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 09, 2024 at 06:45 AM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `digis`
--

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

DROP TABLE IF EXISTS `employee`;
CREATE TABLE IF NOT EXISTS `employee` (
  `employeeID` int NOT NULL AUTO_INCREMENT,
  `mID` int NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `employeeName` varchar(50) NOT NULL,
  PRIMARY KEY (`employeeID`),
  UNIQUE KEY `employeeUsername` (`username`),
  KEY `mID` (`mID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`employeeID`, `mID`, `username`, `password`, `employeeName`) VALUES
(1, 1, 'Samy_O', '12345', 'Samy Omar'),
(2, 2, 'Mohamed_S', '12345', 'Mohamed Samer');

-- --------------------------------------------------------

--
-- Table structure for table `hr`
--

DROP TABLE IF EXISTS `hr`;
CREATE TABLE IF NOT EXISTS `hr` (
  `hrID` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `hrName` varchar(50) NOT NULL,
  PRIMARY KEY (`hrID`),
  UNIQUE KEY `hrUsername` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `hr`
--

INSERT INTO `hr` (`hrID`, `username`, `password`, `hrName`) VALUES
(1, 'Seif_S', '12345', 'Seif Shady');

-- --------------------------------------------------------

--
-- Table structure for table `manager`
--

DROP TABLE IF EXISTS `manager`;
CREATE TABLE IF NOT EXISTS `manager` (
  `managerID` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `managerName` varchar(50) NOT NULL,
  PRIMARY KEY (`managerID`),
  UNIQUE KEY `managerUsername` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `manager`
--

INSERT INTO `manager` (`managerID`, `username`, `password`, `managerName`) VALUES
(1, 'Ahmedd_', '12345', 'Ahmed Samy'),
(2, 'Khaledd_', '12345', 'Khaled Tamer');

-- --------------------------------------------------------

--
-- Table structure for table `work_hours`
--

DROP TABLE IF EXISTS `work_hours`;
CREATE TABLE IF NOT EXISTS `work_hours` (
  `workID` int NOT NULL AUTO_INCREMENT,
  `empID` int NOT NULL,
  `approved` tinyint(1) NOT NULL,
  `salary` int NOT NULL,
  `month` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `year` int NOT NULL,
  `day1` int NOT NULL DEFAULT '0',
  `day2` int NOT NULL DEFAULT '0',
  `day3` int NOT NULL DEFAULT '0',
  `day4` int NOT NULL DEFAULT '0',
  `day5` int NOT NULL DEFAULT '0',
  `day6` int NOT NULL DEFAULT '0',
  `day7` int NOT NULL DEFAULT '0',
  `day8` int NOT NULL DEFAULT '0',
  `day9` int NOT NULL DEFAULT '0',
  `day10` int NOT NULL DEFAULT '0',
  `day11` int NOT NULL DEFAULT '0',
  `day12` int NOT NULL DEFAULT '0',
  `day13` int NOT NULL DEFAULT '0',
  `day14` int NOT NULL DEFAULT '0',
  `day15` int NOT NULL DEFAULT '0',
  `day16` int NOT NULL DEFAULT '0',
  `day17` int NOT NULL DEFAULT '0',
  `day18` int NOT NULL DEFAULT '0',
  `day19` int NOT NULL DEFAULT '0',
  `day20` int NOT NULL DEFAULT '0',
  `day21` int NOT NULL DEFAULT '0',
  `day22` int NOT NULL DEFAULT '0',
  `day23` int NOT NULL DEFAULT '0',
  `day24` int NOT NULL DEFAULT '0',
  `day25` int NOT NULL DEFAULT '0',
  `day26` int NOT NULL DEFAULT '0',
  `day27` int NOT NULL DEFAULT '0',
  `day28` int NOT NULL DEFAULT '0',
  `day29` int NOT NULL DEFAULT '0',
  `day30` int NOT NULL DEFAULT '0',
  `day31` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`workID`),
  KEY `empID` (`empID`)
) ENGINE=InnoDB AUTO_INCREMENT=122 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `work_hours`
--

INSERT INTO `work_hours` (`workID`, `empID`, `approved`, `salary`, `month`, `year`, `day1`, `day2`, `day3`, `day4`, `day5`, `day6`, `day7`, `day8`, `day9`, `day10`, `day11`, `day12`, `day13`, `day14`, `day15`, `day16`, `day17`, `day18`, `day19`, `day20`, `day21`, `day22`, `day23`, `day24`, `day25`, `day26`, `day27`, `day28`, `day29`, `day30`, `day31`) VALUES
(115, 1, 1, 9, 'February', 2024, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(116, 1, 1, 10, 'February', 2024, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 0, 0, 0),
(117, 1, 1, 11, 'April', 2024, 0, 0, 0, 0, 0, 0, 0, 8, 0, 11, 0, 0, 12, 0, 0, 0, 0, 12, 15, 0, 0, 0, 12, 14, 0, 12, 0, 17, 15, 11, 0),
(118, 1, 1, 1000, 'January', 2024, 0, 0, 13, 12, 0, 0, 22, 0, 0, 11, 0, 24, 0, 0, 24, 0, 21, 0, 0, 24, 0, 0, 24, 0, 0, 0, 11, 0, 0, 0, 22),
(121, 2, 1, 100, 'January', 2024, 18, 0, 15, 20, 0, 19, 0, 16, 19, 0, 0, 0, 0, 0, 19, 0, 19, 0, 0, 0, 0, 0, 0, 14, 12, 13, 14, 11, 11, 12, 11);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `employee_ibfk_1` FOREIGN KEY (`mID`) REFERENCES `manager` (`managerID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `work_hours`
--
ALTER TABLE `work_hours`
  ADD CONSTRAINT `work_hours_ibfk_1` FOREIGN KEY (`empID`) REFERENCES `employee` (`employeeID`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
