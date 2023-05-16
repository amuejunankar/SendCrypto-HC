-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2023 at 12:14 PM
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
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `email` varchar(500) NOT NULL,
  `from_address` varchar(1000) NOT NULL,
  `to_address` varchar(255) NOT NULL,
  `amountRupee` varchar(255) NOT NULL,
  `amount` decimal(18,6) NOT NULL,
  `tx_hash` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `transaction_status` varchar(50) NOT NULL,
  `transaction_type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `email`, `from_address`, `to_address`, `amountRupee`, `amount`, `tx_hash`, `created_at`, `transaction_status`, `transaction_type`) VALUES
(29, 'junankgg@gmail.com', '0x395897c8a5fa52aedcad10d5c1a55a8393d77733', '0x16530059aB82b5e1D2b1719d571fB5d77431468d', '148.549', '0.001000', '0x7d3a32c6e3ff96d583021614a2426df20b56094a877a8aa3b91f107a251060aa', '2023-05-13 10:13:23', '', ''),
(30, 'junankgg@gmail.com', '0x395897c8a5fa52aedcad10d5c1a55a8393d77733', '0x16530059ab82b5e1d2b1719d571fb5d77431468d', '14.8602', '0.000100', '0xd009c920f9140811a92e592ff4fb38580ab049e41f792afe1ebf42ac669d3979', '2023-05-13 11:12:32', '', ''),
(31, 'junankgg@gmail.com', 'Prepaid Recharge ', '888635805\n                                 > Jio\n                                ', '399\n                                ', '0.002697', '0xb9ab940fff9a930bc9eed348b32e5edfbeaa97b0e9b6cb22bf114753a959ccdb\n                                ', '2023-05-13 14:35:51', '', 'recharge'),
(32, 'junankgg@gmail.com', 'Prepaid Recharge ', '888635805\n                                 > Airtel\n                                ', '399\n                                ', '0.002697', '0x2ba49932ff1dec9b4e9ff25d113512b5d05e23931ac249af88c2b9be1b49dacb\n                                ', '2023-05-13 14:40:06', '', 'recharge'),
(33, 'junankgg@gmail.com', 'Prepaid Recharge ', '888635805\n                                 > Jio\n                                ', '399\n                                ', '0.002697', '0x4f03c0de3657b93275f02b50cead68d2687947589b1d6909263b649d935d1143\n                                ', '2023-05-13 14:43:00', '', 'recharge'),
(35, 'adityaumaratkar@gmail.com', 'Prepaid Recharge ', '888635805\n                                 > Airtel\n                                ', '199\n                                ', '0.001349', '0x61d91811ee9d007f98e7296ca5327ba81136d6771659a38a2a46a1c85645abf2\n                                ', '2023-05-13 19:18:06', '', 'recharge'),
(49, 'junankgg@gmail.com', '0x395897c8a5fa52aedcad10d5c1a55a8393d77733', '0xaA1534d1F6a9E625e27e8Cd6AC73Ac5fA6Fc716d', '147.59', '0.001000', '0xdf2376115438653fc0d43b8ba7746e14477cff059a8ad59142d09340cbc9149c', '2023-05-13 20:03:05', '', 'transaction'),
(50, 'junankgg@gmail.com', '0x395897c8a5fa52aedcad10d5c1a55a8393d77733', '0x16530059ab82b5e1d2b1719d571fb5d77431468d', '0.99', '0.000007', '0x363765c2babd3e312052ae60ab0b106ddd0e990a3edafc4027cd2b2a187e0672', '2023-05-14 05:26:10', '', 'transaction'),
(51, 'junankgg@gmail.com', '0x395897c8a5fa52aedcad10d5c1a55a8393d77733', '0x16530059ab82b5e1d2b1719d571fb5d77431468d', '5.67', '0.000038', '0x0a71b5159631ccdc687f10acdc23d4ef55256b70611dfe2d6eb9956dfe16e684', '2023-05-14 05:26:25', '', 'transaction');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
