-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 09, 2021 at 02:54 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `boostorder`
--

-- --------------------------------------------------------

--
-- Table structure for table `bulk_option_table`
--

CREATE TABLE `bulk_option_table` (
  `Bulk_ID` int(11) UNSIGNED NOT NULL,
  `Bulk_Name` varchar(40) NOT NULL,
  `Bulk_Price` decimal(2,0) NOT NULL,
  `Item_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bulk_option_table`
--

INSERT INTO `bulk_option_table` (`Bulk_ID`, `Bulk_Name`, `Bulk_Price`, `Item_ID`) VALUES
(1, '1 Dozen Rem', '22', 2);

-- --------------------------------------------------------

--
-- Table structure for table `catalogue`
--

CREATE TABLE `catalogue` (
  `ID` int(11) UNSIGNED NOT NULL,
  `Name` varchar(70) NOT NULL,
  `Description` mediumtext DEFAULT NULL,
  `Unit_Price` decimal(38,2) NOT NULL,
  `Bulk_Option` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `catalogue`
--

INSERT INTO `catalogue` (`ID`, `Name`, `Description`, `Unit_Price`, `Bulk_Option`) VALUES
(1, 'Colgate Advanced Whitening 2', 'Colgate 2 description', '10.00', 0),
(2, 'Rem', 'https://downloadmorerem.com/', '2.00', 1),
(3, 'Ram', 'https://downloadmoreram.com/', '3.00', 0),
(4, 'Rim', 'No description', '30.00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `ID` int(11) UNSIGNED NOT NULL,
  `Subject` varchar(60) NOT NULL,
  `Content` text NOT NULL,
  `Seen` tinyint(1) NOT NULL,
  `Order_ID` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `Order_ID` int(11) UNSIGNED NOT NULL,
  `Description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`Description`)),
  `Status` varchar(30) NOT NULL,
  `Changed_by_user` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Triggers `order`
--
DELIMITER $$
CREATE TRIGGER `t_create_notification` AFTER UPDATE ON `order` FOR EACH ROW INSERT INTO `notification`(`Subject`, `Content`, `Seen`,`Order_ID`) 
	SELECT 'Order status changed', CONCAT('Order ', NEW.Order_ID, ' changed status to ',REPLACE(REPLACE(NEW.Status, 'D', 'd'),'P','p'),'.'), FALSE, NEW.Order_ID
    FROM DUAL
    WHERE (NEW.Changed_by_user = FALSE)
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bulk_option_table`
--
ALTER TABLE `bulk_option_table`
  ADD PRIMARY KEY (`Bulk_ID`);

--
-- Indexes for table `catalogue`
--
ALTER TABLE `catalogue`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`Order_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bulk_option_table`
--
ALTER TABLE `bulk_option_table`
  MODIFY `Bulk_ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `catalogue`
--
ALTER TABLE `catalogue`
  MODIFY `ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `Order_ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bulk_option_table`
--
ALTER TABLE `bulk_option_table`
  ADD CONSTRAINT `bulk_option_table_ibfk_1` FOREIGN KEY (`Bulk_ID`) REFERENCES `catalogue` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
