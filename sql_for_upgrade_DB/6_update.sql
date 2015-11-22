-- Aggiornamento del 22 novembre 2015 da applicare ad una installazione già presente
-- 
-- Questo aggiornamento è da applicare solo se avete fatto una installazione
-- di Sbot prima del 22 novembre 2015, altrimenti basta usare telegram_base.sql
-- Applica 6_update.sql
--
-- Apply the patch 6_update.sql only not first installation. Or installation is antecedent at 22/11/2015
-- Apply 6_update.sql

-- phpMyAdmin SQL Dump
-- version 4.4.14.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 22, 2015 at 01:51 PM
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
-- Table structure for table `software_config`
--

CREATE TABLE IF NOT EXISTS `software_config` (
  `ID` int(11) NOT NULL,
  `SoftDesc` varchar(50) DEFAULT NULL,
  `Code` varchar(20) DEFAULT NULL,
  `Param` varchar(50) DEFAULT NULL,
  `Number` int(2) DEFAULT NULL,
  `Note` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) NOT NULL DEFAULT '1',
  `Log` varchar(50) DEFAULT NULL,
  `DateUpdt` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `software_config`
--

INSERT INTO `software_config` (`ID`, `SoftDesc`, `Code`, `Param`, `Number`, `Note`, `Active`, `Log`, `DateUpdt`) VALUES
(1, 'Mail', 'mittente', 'xxxxxx@gmail.com', NULL, 'Mail di invio comunicazioni', 0, 'admin', NULL),
(2, 'Mail', 'nomemittente', 'nome', NULL, NULL, 0, 'admin', NULL),
(3, 'Mail', 'destinatario', 'yyyyyyy@gmail.com', NULL, NULL, 0, 'admin', NULL),
(4, 'Mail', 'nomedestinatario', 'nome', NULL, 'Nome del destinatario a cui inviare mail', 0, 'admin', NULL),
(5, 'Mail', 'serversmtp', 'smtp.gmail.com', NULL, NULL, 0, 'admin', NULL),
(6, 'Mail', 'username', 'xxxxxx', NULL, NULL, 0, 'admin', NULL),
(7, 'Mail', 'password', 'yyyyyyy', NULL, NULL, 0, 'admin', NULL),
(8, 'Mail', 'port', '587', NULL, '', 0, 'admin', NULL),
(9, 'Mail', 'secure', 'tsl', NULL, NULL, 0, 'admin', NULL),
(10, 'Demone', 'status', '--', NULL, 'start=1 / stop=0', 1, 'admin', NULL);  

--
-- Indexes for dumped tables
--

--
-- Indexes for table `software_config`
--
ALTER TABLE `software_config`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `SoftDesc` (`SoftDesc`,`Code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `software_config`
--
ALTER TABLE `software_config`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
