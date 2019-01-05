-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 05, 2019 at 07:36 PM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ezonera1`
--

-- --------------------------------------------------------

--
-- Table structure for table `compname`
--

CREATE TABLE `compname` (
  `CompID` int(10) NOT NULL,
  `CompName` varchar(70) NOT NULL,
  `CompSite` varchar(1000) NOT NULL,
  `CompStatus` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `compname`
--

INSERT INTO `compname` (`CompID`, `CompName`, `CompSite`, `CompStatus`) VALUES
(1, 'google Inc.', 'https://www.google.com', '');

-- --------------------------------------------------------

--
-- Table structure for table `empemail`
--

CREATE TABLE `empemail` (
  `EmpEmailID` int(10) NOT NULL,
  `EmpID` int(10) NOT NULL,
  `EmpEmail` varchar(300) NOT NULL,
  `EmpEmailStatus` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `empemail`
--

INSERT INTO `empemail` (`EmpEmailID`, `EmpID`, `EmpEmail`, `EmpEmailStatus`) VALUES
(10, 1, 'jeff@amazon.com', NULL),
(11, 2, 'Phil@shield.com', NULL),
(12, 3, 'Maria@shield.com', NULL),
(15, 4, 'peterp@dailybugle.com', NULL),
(16, 5, 'gwens@oscorp.com', NULL),
(17, 5, 'gwenStacy@oscorp.com', 'incorrect'),
(18, 6, 'eddie@dailybugle.com', NULL),
(19, 6, 'ebrock@dailybugle.com', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `empname`
--

CREATE TABLE `empname` (
  `EmpID` int(10) NOT NULL,
  `CompID` int(10) NOT NULL,
  `EmpName` text NOT NULL,
  `EmpDesig` text,
  `EmpStatus` text,
  `EmpPhone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `empname`
--

INSERT INTO `empname` (`EmpID`, `CompID`, `EmpName`, `EmpDesig`, `EmpStatus`, `EmpPhone`) VALUES
(1, 1, 'Jeff Bezos', 'CEO', 'DNC', NULL),
(2, 1, 'Phil Coulson', 'Director Engineering', NULL, NULL),
(3, 1, 'Maria Hill', 'Director HR', 'point-of-Contact', NULL),
(4, 1, 'Peter Parker', 'Director Engineering', NULL, NULL),
(5, 1, 'Gwen Stacy', 'Director Engineering', NULL, NULL),
(6, 1, 'Eddie Brock', 'CTO', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `profilelog`
--

CREATE TABLE `profilelog` (
  `ProfiledID` int(10) NOT NULL,
  `ProfiledDate` date NOT NULL,
  `RAID` int(10) NOT NULL,
  `CompID` int(10) NOT NULL,
  `JobTitle` text NOT NULL,
  `JobLocation` text NOT NULL,
  `JDLink` varchar(2000) NOT NULL,
  `EmpID` int(10) NOT NULL,
  `EmpEmailID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `profilelog`
--

INSERT INTO `profilelog` (`ProfiledID`, `ProfiledDate`, `RAID`, `CompID`, `JobTitle`, `JobLocation`, `JDLink`, `EmpID`, `EmpEmailID`) VALUES
(4, '2019-01-04', 1, 1, 'Salesfroce Developer', 'Detroit, MI', 'www.google.com/jdlink', 4, 15),
(5, '2019-01-04', 1, 1, 'Salesfroce Developer', 'Detroit, MI', 'www.google.com/jdlink', 6, 18),
(6, '2019-01-04', 1, 1, 'Salesfroce Developer', 'Detroit, MI', 'www.google.com/jdlink', 6, 19),
(7, '2019-01-04', 1, 1, 'Salesfroce Developer', 'Detroit, MI', 'www.google.com/jdlink', 2, 11),
(8, '2019-01-04', 1, 1, 'cryptography Engineer', 'Detroit, MI', 'www.google.com/jdlink', 2, 11),
(9, '2019-01-04', 1, 1, 'cryptography Engineer', 'Detroit, MI', 'www.google.com/jdlink', 5, 16),
(10, '2019-01-04', 1, 1, 'cryptography Engineer', 'Detroit, MI', 'www.google.com/jdlink', 5, 17),
(11, '2019-01-04', 1, 1, 'Safety Engineer', 'Detroit, MI', 'www.google.com/jdlink', 1, 10),
(12, '2019-01-04', 1, 1, 'Safety Engineer', 'Detroit, MI', 'www.google.com/jdlink', 2, 11),
(13, '2019-01-04', 1, 1, 'asdfasdf', 'asdf', 'asdfdf', 3, 12);

-- --------------------------------------------------------

--
-- Table structure for table `radetails`
--

CREATE TABLE `radetails` (
  `RAID` int(10) NOT NULL,
  `RAName` text NOT NULL,
  `RAemail` varchar(300) NOT NULL,
  `RAPass` varchar(20) NOT NULL,
  `RAuserType` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `radetails`
--

INSERT INTO `radetails` (`RAID`, `RAName`, `RAemail`, `RAPass`, `RAuserType`) VALUES
(1, 'Test', 'ahannan@ezonestaffing.com', '1234', 'Admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `compname`
--
ALTER TABLE `compname`
  ADD PRIMARY KEY (`CompID`);

--
-- Indexes for table `empemail`
--
ALTER TABLE `empemail`
  ADD PRIMARY KEY (`EmpEmailID`),
  ADD KEY `EmpID` (`EmpID`);

--
-- Indexes for table `empname`
--
ALTER TABLE `empname`
  ADD PRIMARY KEY (`EmpID`),
  ADD KEY `CompID` (`CompID`);

--
-- Indexes for table `profilelog`
--
ALTER TABLE `profilelog`
  ADD PRIMARY KEY (`ProfiledID`),
  ADD KEY `RAID` (`RAID`),
  ADD KEY `CompID` (`CompID`),
  ADD KEY `EmpID` (`EmpID`),
  ADD KEY `EmpEmailID` (`EmpEmailID`);

--
-- Indexes for table `radetails`
--
ALTER TABLE `radetails`
  ADD PRIMARY KEY (`RAID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `compname`
--
ALTER TABLE `compname`
  MODIFY `CompID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `empemail`
--
ALTER TABLE `empemail`
  MODIFY `EmpEmailID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `empname`
--
ALTER TABLE `empname`
  MODIFY `EmpID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `profilelog`
--
ALTER TABLE `profilelog`
  MODIFY `ProfiledID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `radetails`
--
ALTER TABLE `radetails`
  MODIFY `RAID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `empemail`
--
ALTER TABLE `empemail`
  ADD CONSTRAINT `empemail_ibfk_1` FOREIGN KEY (`EmpID`) REFERENCES `empname` (`EmpID`);

--
-- Constraints for table `empname`
--
ALTER TABLE `empname`
  ADD CONSTRAINT `empname_ibfk_1` FOREIGN KEY (`CompID`) REFERENCES `compname` (`CompID`);

--
-- Constraints for table `profilelog`
--
ALTER TABLE `profilelog`
  ADD CONSTRAINT `profilelog_ibfk_1` FOREIGN KEY (`RAID`) REFERENCES `radetails` (`RAID`),
  ADD CONSTRAINT `profilelog_ibfk_2` FOREIGN KEY (`CompID`) REFERENCES `compname` (`CompID`),
  ADD CONSTRAINT `profilelog_ibfk_3` FOREIGN KEY (`EmpID`) REFERENCES `empname` (`EmpID`),
  ADD CONSTRAINT `profilelog_ibfk_4` FOREIGN KEY (`EmpEmailID`) REFERENCES `empemail` (`EmpEmailID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
