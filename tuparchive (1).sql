-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 06, 2016 at 05:41 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 7.0.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tuparchive`
--

-- --------------------------------------------------------

--
-- Table structure for table `all`
--

CREATE TABLE `all` (
  `Id` int(10) NOT NULL,
  `name` varchar(30) NOT NULL,
  `description` varchar(99) NOT NULL,
  `year` int(10) NOT NULL,
  `category` varchar(20) NOT NULL,
  `location` varchar(255) NOT NULL,
  `time` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP
) ;

--
-- Dumping data for table `all`
--

INSERT INTO `all` (`Id`, `name`, `description`, `year`, `category`, `location`, `time`, `size`, `content`) VALUES
(15, 'IO-20-05-16 Sample 1', 'Sample 1', 2016, 'Implementing Order', '../docs/board files/Implementing Order/2016/IO-20-05-16 Sample 1.docx', '2016-06-03 01:44:50.000000', 64892, 0x73616d706c65646f63782e646f6378);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(10) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `last` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP
) ;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `username`, `password`, `last`) VALUES
(1, 'admin', 'wow123', '2016-05-26 20:59:34.261999'),
(2, 'tup_bor', 'boardsec2016', '2016-05-31 05:19:14.623554'),
(3, 'boardsec', 'boardsec2016', '0000-00-00 00:00:00.000000'),
(4, 'admin2', 'boardsec2016', '0000-00-00 00:00:00.000000');

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `all`
--
ALTER TABLE `all`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
