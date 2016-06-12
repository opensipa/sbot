-- Aggiornamento del 12 giugno 2016 da applicare ad una installazione già presente
-- 
-- Questo aggiornamento è da applicare solo se avete fatto una installazione
-- di Sbot prima del 12 giugno 2016, altrimenti basta usare telegram_base.sql
-- Applica 10_update.sql
--
-- Apply the patch 10_update.sql only not first installation. Or installation is antecedent at 12/06/2016
-- Apply 10_update.sql


--
-- Sbot version 0.45
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
-- Dumping data for table `software_config`
--

INSERT INTO `software_config` (`ID`, `SoftDesc`, `Code`, `Param`, `Number`, `Note`, `Active`, `Log`, `DateUpdt`) VALUES
(NULL, 'Demone', 'nomebot', 'BOT_NAME', NULL, 'Nome del bot che stai gestendo', 1, 'admin', '2016-06-11 00:00:00'), 
(NULL, 'Google', 'key', 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx', NULL, 'Key per le Api Google - https://console.developers.google.com', '0', 'admin', '2016-06-11 00:00:00'),
(NULL, 'Message', 'waiting', 'Attendere prego ...', NULL, 'Messaggio di attesa in caso di elaborazione.', '1', 'admin', '2016-06-11 00:00:00'); 
