-- Aggiornamento del 16 gennaio 2016 da applicare ad una installazione già presente
-- 
-- Questo aggiornamento è da applicare solo se avete fatto una installazione
-- di Sbot prima del 16 gennaio 2016, altrimenti basta usare telegram_base.sql
-- Applica 7_update.sql
--
-- Apply the patch 7_update.sql only not first installation. Or installation is antecedent at 16/01/2016
-- Apply 7_update.sql


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

CREATE TABLE `software_config_button` (
  `ID` int(11) NOT NULL,
  `Type` varchar(8) NOT NULL DEFAULT 'Normal',
  `SoftDesc` varchar(50) DEFAULT NULL,
  `Number` int(2) DEFAULT NULL,
  `Titolo` varchar(25) DEFAULT NULL,
  `Param` varchar(400) DEFAULT NULL,
  `Active` tinyint(1) NOT NULL DEFAULT '1',
  `Log` varchar(50) DEFAULT NULL,
  `DateUpdt` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `software_config_button`
--

INSERT INTO `software_config_button` (`ID`, `Type`, `SoftDesc`, `Number`, `Titolo`, `Param`, `Active`, `Log`, `DateUpdt`) VALUES
(1, 'Normal', 'Hello', 0, 'Benvenuto nel Bot. Utilizzando il Bot acconsenti al trattamento dei tuoi dati personali secondo quanto disposto dal D.Lgs 196/2003.', 'Benvenuto', 1, 'admin', '2016-01-09 17:26:11'), 
(2, 'Normal', 'Button', 1, 'Puoi scegliere tra /PrevisioniDomani o  /MeteoOggi', 'Meteo', 1, 'admin', '2016-01-09 17:26:11'),
(3, 'Normal', 'Button', 2, '/News', 'News', 1, 'admin', '2016-01-09 17:26:11'),
(4, 'Normal', 'Button', 3, 'Button1', 'Button1', 1, 'admin', '2016-01-09 17:26:11'),
(5, 'Normal', 'Button', 4, 'Button1', 'Button1', 1, 'admin', '2016-01-09 17:26:11'),
(6, 'Normal', 'Button', 5, 'Button1', 'Button1', 1, 'admin', '2016-01-09 17:26:11'),
(7, 'Normal', 'Button', 6, 'Button1', 'Button1', 1, 'admin', '2016-01-09 17:26:11'),
(8, 'Normal', 'Button', 7, 'Button1', 'Button1', 1, 'admin', '2016-01-09 17:26:11'),
(9, 'Normal', 'Button', 8, 'Button1', 'Button1', 1, 'admin', '2016-01-09 17:26:11'),
(17, 'Normal', 'Meteo', 51, '/PrevisioniDomani', 'link1', 1, 'matteo', NULL),
(18, 'Normal', 'Meteo', 52, '/MeteoOggi', 'link2', 1, 'matteo', NULL),
(19, 'Function', 'Notizie', 80, '/News', 'Read|http://link/rss/link_rss', 1, 'admin', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `software_config_button`
--
ALTER TABLE `software_config_button`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `software_config_button`
--
ALTER TABLE `software_config_button`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
