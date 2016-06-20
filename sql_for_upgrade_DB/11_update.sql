-- Aggiornamento del 19 giugno 2016 da applicare ad una installazione già presente
-- 
-- Questo aggiornamento è da applicare solo se avete fatto una installazione
-- di Sbot prima del 19 giugno 2016, altrimenti basta usare telegram_base.sql
-- Applica 11_update.sql
--
-- Apply the patch 11_update.sql only not first installation. Or installation is antecedent at 19/06/2016
-- Apply 11_update.sql


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
-- Alter table for new dimension
--

ALTER TABLE `software_config` CHANGE `Param` `Param` VARCHAR(300) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;


--
-- Dumping data for table `software_config`
--
-- Insert new variable
--

INSERT INTO `software_config` (`ID`, `SoftDesc`, `Code`, `Param`, `Number`, `Note`, `Active`, `Log`, `DateUpdt`) VALUES
(NULL, 'Search', 'url', 'http://www.google.it/search?hl=it&ie=UTF-8&q=', NULL, 'Puoi scegliere tra http://www.google.it/search?hl=it&ie=UTF-8&q= oppure http://www.google.com/search?as_sitesearch=www.SITO_INTERNET.COM&as_q=', 1, 'admin', NULL),
(NULL, 'Search', 'text', 'Tento la ricerca con Google:', NULL, 'Messaggio di testo pre URL che invio in caso di mancata risposta del Bot', 1, 'admin', NULL),
(NULL, 'Message', 'exit', 'Questo bot non riesce a rispondere alla domanda.', NULL, 'Messaggio di scuse quando il Bot non sa rispondere', 1, 'admin', NULL);

