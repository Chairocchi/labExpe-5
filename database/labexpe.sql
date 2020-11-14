-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 14, 2020 at 11:00 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+08:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `labexpe`
--

-- --------------------------------------------------------

--
-- Table structure for table `accountant`
--
-- CREATE DATABASE IF NOT EXISTS labexpe;
-- USE labexpe;

-- if the table already exists, remove it before trying to create the table again
DROP TABLE IF EXISTS accountant;
DROP TABLE IF EXISTS branch;
DROP TABLE IF EXISTS fees_transaction;
DROP TABLE IF EXISTS student;
DROP TABLE IF EXISTS user;

CREATE TABLE `accountant` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `dateBirth` date NOT NULL,
  `branch` varchar(255) NOT NULL,
  `joindate` datetime NOT NULL,
  `salary` int(255) NOT NULL,
  `delete_status` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `accountant`
--

INSERT INTO `accountant` (`id`, `username`, `password`, `name`, `dateBirth`, `branch`, `joindate`, `salary`, `delete_status`) VALUES
(1, 'b1', 'b1', 'Porter R.', '1994-10-09', '1', '2020-10-14 00:00:00', 15000, '0'),
(2, 'b2', 'b2', 'Luke Silas', '1993-07-20', '2', '2020-11-04 00:00:00', 13000, '0');

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `id` int(255) NOT NULL,
  `branch` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `detail` varchar(255) NOT NULL,
  `delete_status` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`id`, `branch`, `address`, `detail`, `delete_status`) VALUES
(1, 'Secret Sky', 'Shelter St., Wolf City', 'Get your wish campaign', '0'),
(2, 'Rhode Island', 'Styla East St., Rhode Island City', '8-bit fun', '0'),
(3, 'Main', 'Panda St., Quezon City', 'Main Branch', '0');

-- --------------------------------------------------------

--
-- Table structure for table `fees_transaction`
--

CREATE TABLE `fees_transaction` (
  `id` int(255) NOT NULL,
  `stdid` varchar(255) NOT NULL,
  `paid` int(255) NOT NULL,
  `submitdate` datetime NOT NULL,
  `transaction_remark` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fees_transaction`
--

INSERT INTO `fees_transaction` (`id`, `stdid`, `paid`, `submitdate`, `transaction_remark`) VALUES
(1, '1', 6500, '2020-10-29 00:00:00', 'none'),
(2, '2', 10000, '2020-11-05 00:00:00', ''),
(3, '1', 1000, '2020-11-05 00:00:00', ''),
(4, '2', 3000, '2020-11-12 00:00:00', ''),
(5, '3', 13000, '2020-11-05 00:00:00', '');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(255) NOT NULL,
  `emailid` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `joindate` datetime NOT NULL,
  `about` text NOT NULL,
  `contact` varchar(11) NOT NULL,
  `fees` int(255) NOT NULL,
  `branch` enum('1','2','3','4') NOT NULL,
  `balance` int(255) NOT NULL,
  `delete_status` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `emailid`, `name`, `joindate`, `about`, `contact`, `fees`, `branch`, `balance`, `delete_status`) VALUES
(1, 'chai@bot.com', 'Chairo', '2020-10-29 00:00:00', 'black hair, female', '09347584732', 10000, '3', 2500, '0'),
(2, 'jai@wolf.com', 'Jai Wolf', '2020-11-05 00:00:00', 'male', '09534678532', 13000, '1', 0, '0'),
(3, 'james@anamanaguchi.com', 'James DeVito', '2020-11-05 00:00:00', 'male', '09384756323', 14000, '2', 1000, '0');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `emailid` varchar(255) NOT NULL,
  `lastlogin` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `user_type`, `name`, `emailid`, `lastlogin`) VALUES
(1, 'admin', '6c7ca345f63f835cb353ff15bd6c5e052ec08e7a', 'admin', 'allen', 'allen.garcia@neu.edu.ph', '2020-11-14 12:33:11'),
(2, 'b1', 'dab34f9f860460454b365ab4ca5158285f150db4', 'b1', 'Porter R.', 'porter@secretsky.com', '2020-11-13 10:34:32'),
(3, 'b2', '63a67e67d74df0369f188ae539ae59f143a3c1f4', 'b2', 'Luke Silas', 'luke@anamanaguchi.com', '2020-11-12 12:36:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accountant`
--
ALTER TABLE `accountant`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fees_transaction`
--
ALTER TABLE `fees_transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accountant`
--
ALTER TABLE `accountant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `branch`
--
ALTER TABLE `branch`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `fees_transaction`
--
ALTER TABLE `fees_transaction`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
