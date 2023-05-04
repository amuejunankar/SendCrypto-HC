-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 04, 2023 at 08:24 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `account`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounttable`
--

CREATE TABLE `accounttable` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `email` text NOT NULL,
  `mobilecode` int(10) NOT NULL,
  `mobilenumber` varchar(12) NOT NULL,
  `password` text NOT NULL,
  `profile_picture` longblob NOT NULL,
  `is_verified` int(10) DEFAULT 0,
  `token` varchar(100) DEFAULT NULL,
  `otp` varchar(10) DEFAULT NULL,
  `otpsms` int(12) NOT NULL,
  `fname` text NOT NULL,
  `lname` text NOT NULL,
  `eth_address` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounttable`
--

INSERT INTO `accounttable` (`id`, `name`, `email`, `mobilecode`, `mobilenumber`, `password`, `profile_picture`, `is_verified`, `token`, `otp`, `otpsms`, `fname`, `lname`, `eth_address`) VALUES
(63, 'Dummy User', 'user_1c99da@example.com', 91, '0000000000', 'dummy_password', NULL, 1, NULL, '0', 0, 'User', 'Dummy', '0x395897c8a5fa52aedcad10d5c1a55a8393d77733'),
(65, 'Dummy User', 'user_694dc7@example.com', 91, '0000000000', 'dummy_password', NULL, 1, NULL, '0', 0, 'User', 'Dummy', ''),
(66, 'Dummy User', 'user_564f52@example.com', 91, '0000000000', 'dummy_password', NULL, 1, NULL, '0', 0, 'User', 'Dummy', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounttable`
--
ALTER TABLE `accounttable`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounttable`
--
ALTER TABLE `accounttable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
