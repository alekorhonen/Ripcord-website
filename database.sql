-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 11, 2018 at 12:42 PM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ripcord`
--

-- --------------------------------------------------------

--
-- Table structure for table `table_apikeys`
--

CREATE TABLE `table_apikeys` (
  `aid` int(11) NOT NULL,
  `apikey` varchar(32) NOT NULL,
  `request_limit` int(11) NOT NULL,
  `registered_ip` varchar(32) NOT NULL,
  `last_known_ip` varchar(32) NOT NULL,
  `banned` int(11) NOT NULL DEFAULT '0',
  `total_lookups` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `table_apikeys`
--

INSERT INTO `table_apikeys` (`aid`, `apikey`, `request_limit`, `registered_ip`, `last_known_ip`, `banned`, `total_lookups`) VALUES
(1, '312', 2, '', '', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `table_limits`
--

CREATE TABLE `table_limits` (
  `apikey` varchar(32) NOT NULL,
  `requests_done` int(11) NOT NULL,
  `date_created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `table_limits`
--

INSERT INTO `table_limits` (`apikey`, `requests_done`, `date_created`) VALUES
('312', 4, '2018-02-19');

-- --------------------------------------------------------

--
-- Table structure for table `table_proxies`
--

CREATE TABLE `table_proxies` (
  `pid` int(11) NOT NULL,
  `proxy` varchar(20) NOT NULL,
  `anonymity_level` varchar(15) NOT NULL,
  `country` varchar(32) NOT NULL,
  `region` varchar(32) NOT NULL,
  `city` varchar(32) NOT NULL,
  `speed` int(11) NOT NULL,
  `times_checked` int(11) NOT NULL,
  `date_uploaded` datetime NOT NULL,
  `last_checked` datetime NOT NULL,
  `added_by` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `table_apikeys`
--
ALTER TABLE `table_apikeys`
  ADD PRIMARY KEY (`aid`);

--
-- Indexes for table `table_limits`
--
ALTER TABLE `table_limits`
  ADD PRIMARY KEY (`apikey`);

--
-- Indexes for table `table_proxies`
--
ALTER TABLE `table_proxies`
  ADD PRIMARY KEY (`pid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `table_apikeys`
--
ALTER TABLE `table_apikeys`
  MODIFY `aid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `table_proxies`
--
ALTER TABLE `table_proxies`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
