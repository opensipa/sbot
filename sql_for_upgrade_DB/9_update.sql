-- Aggiornamento del 05 giugno 2016 da applicare ad una installazione già presente
-- 
-- Questo aggiornamento è da applicare solo se avete fatto una installazione
-- di Sbot prima del 05 giugno 2016, altrimenti basta usare telegram_base.sql
-- Applica 9_update.sql
--
-- Apply the patch 9_update.sql only not first installation. Or installation is antecedent at 05/06/2016
-- Apply 8_update.sql


--
-- Sbot version 0.40
--

-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 05, 2016 at 12:07 PM
-- Server version: 5.5.49-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `telegram`
--

-- --------------------------------------------------------

--
-- Table structure for table `message_scheduler`
--

CREATE TABLE `message_scheduler` (
  `ID` int(11) NOT NULL,
  `DataInsert` datetime DEFAULT NULL,
  `DataScheduler` datetime DEFAULT NULL,
  `Repeater` tinyint(1) DEFAULT NULL COMMENT 'Ripetizioni Si/No',
  `NumberRepeat` int(1) DEFAULT NULL COMMENT 'Max 9 ripetizioni',
  `HowOften` int(2) DEFAULT NULL COMMENT 'Intervallo ripetizione',
  `Text` varchar(2048) DEFAULT NULL,
  `Note` varchar(2048) DEFAULT NULL,
  `Signature` varchar(255) DEFAULT NULL,
  `SingleUserID` int(11) DEFAULT NULL,
  `AlreadySent` tinyint(1) DEFAULT '1',
  `Counter` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `message_scheduler`
--
ALTER TABLE `message_scheduler`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `message_scheduler`
--
ALTER TABLE `message_scheduler`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
