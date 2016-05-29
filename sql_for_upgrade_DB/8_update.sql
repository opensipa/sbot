-- Aggiornamento del 29 maggio 2016 da applicare ad una installazione già presente
-- 
-- Questo aggiornamento è da applicare solo se avete fatto una installazione
-- di Sbot prima del 29 maggio 2016, altrimenti basta usare telegram_base.sql
-- Applica 8_update.sql
--
-- Apply the patch 8_update.sql only not first installation. Or installation is antecedent at 29/05/2016
-- Apply 8_update.sql


--
-- Sbot version 0.20
--

-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 16, 2016 at 02:55 PM
-- Server version: 5.5.46-0ubuntu0.14.04.2
-- PHP Version: 5.5.9-1ubuntu4.14

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
-- Table structure for table `software_config_button`
--

--
-- AUTO_INCREMENT for dumped tables
--

--
-- For table `software_config_button` ALTER TABLE
--
ALTER TABLE `software_config_button` CHANGE `Param` `Param` VARCHAR(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;


--
-- For table `utenti` ALTER TABLE
--

ALTER TABLE `utenti` CHANGE `UserID` `UserID` VARCHAR(200) NOT NULL;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
