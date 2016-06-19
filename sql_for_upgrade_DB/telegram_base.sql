-- Version of Structure Jan 19, 2016
-- DB {S}Bot version 0.51.0
--
-- phpMyAdmin SQL Dump
-- version 19/06/2016

-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 05, 2016 at 12:03 PM
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
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(120) NOT NULL,
  `password` varchar(120) NOT NULL,
  `signature` varchar(255) DEFAULT NULL,
  `level` varchar(25) DEFAULT 'admin',
  `active` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `signature`, `level`, `active`) VALUES
(1, 'admin', 'sha256:1000:T2vvAPNGbltVdfnLi3hveiuCi/4Chp5w:u/U7a9WppkzD2213syyhruPMTFHSguCI', 'Il Team del Bot', 'admin', 1);

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

-- --------------------------------------------------------

--
-- Table structure for table `message_send`
--

CREATE TABLE `message_send` (
  `ID` int(11) NOT NULL,
  `DataInsert` datetime DEFAULT NULL,
  `Text` varchar(2048) NOT NULL,
  `Signature` varchar(255) DEFAULT NULL,
  `MessageID` int(11) DEFAULT NULL,
  `Utenti_messageID` int(11) DEFAULT NULL,
  `Archive` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `software_config`
--

CREATE TABLE `software_config` (
  `ID` int(11) NOT NULL,
  `SoftDesc` varchar(50) DEFAULT NULL,
  `Code` varchar(20) DEFAULT NULL,
  `Param` varchar(300) DEFAULT NULL,
  `Number` int(2) DEFAULT NULL,
  `Note` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) NOT NULL DEFAULT '1',
  `Log` varchar(50) DEFAULT NULL,
  `DateUpdt` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(10, 'Demone', 'status', '--', NULL, 'start=1 / stop=0', 1, 'admin', NULL),
(11, 'Demone', 'nomebot', 'Bot di Test', NULL, 'Nome del bot che stai gestendo', 1, 'admin', NULL),
(12, 'Google', 'key', 'xxxxxxxxxxxxxxxxxxxxxxx', NULL, 'Key per le Api Google - https://console.developers.google.com', 0, 'admin', NULL),
(13, 'Message', 'waiting', 'Attendere prego ...', NULL, 'Messaggio di attesa in caso di elaborazione.', 1, 'admin', NULL),
(14, 'Search', 'url', 'http://www.google.it/search?hl=it&ie=UTF-8&q=', NULL, 'Puoi scegliere tra http://www.google.it/search?hl=it&ie=UTF-8&q= oppure http://www.google.com/search?as_sitesearch=www.SITO_INTERNET.COM&as_q=', '1', 'admin', NULL),
(15, 'Search', 'text', 'Tento la ricerca con Google:', NULL, 'Messaggio di testo pre URL che invio in caso di mancata risposta del Bot', '1', 'admin', NULL),
(16, 'Message', 'exit', 'Questo bot non riesce a rispondere alla domanda.', NULL, 'Messaggio di scuse quando il Bot non sa rispondere', '1', 'admin', NULL);

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
  `Param` varchar(1000) DEFAULT NULL,
  `Active` tinyint(1) NOT NULL DEFAULT '1',
  `Log` varchar(50) DEFAULT NULL,
  `DateUpdt` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `software_config_button`
--

INSERT INTO `software_config_button` (`ID`, `Type`, `SoftDesc`, `Number`, `Titolo`, `Param`, `Active`, `Log`, `DateUpdt`) VALUES
(1, 'Normal', 'Hello', 0, 'Benvenuto', 'Benvenuto nel Bot. Utilizzando il Bot acconsenti al trattamento dei tuoi dati personali secondo quanto disposto dal D.Lgs 196/2003.', 1, 'admin', '2016-01-09 17:26:11'),
(2, 'Normal', 'Button', 1, 'Meteo', 'Puoi scegliere tra /PrevisioniDomani o  /MeteoOggi', 1, 'admin', '2016-01-09 17:26:11'),
(3, 'Normal', 'Button', 2, 'News', '/News', 1, 'admin', '2016-01-09 17:26:11'),
(4, 'Normal', 'Button', 3, 'Button1', 'Button1', 1, 'admin', '2016-01-09 17:26:11'),
(5, 'Normal', 'Button', 4, 'Button1', 'Button1', 1, 'admin', '2016-01-09 17:26:11'),
(6, 'Normal', 'Button', 5, 'Button1', 'Button1', 1, 'admin', '2016-01-09 17:26:11'),
(7, 'Normal', 'Button', 6, 'Button1', 'Button1', 1, 'admin', '2016-01-09 17:26:11'),
(8, 'Normal', 'Button', 7, 'Button1', 'Button1', 1, 'admin', '2016-01-09 17:26:11'),
(9, 'Normal', 'Button', 8, 'Button1', 'Button1', 1, 'admin', '2016-01-09 17:26:11'),
(17, 'Normal', 'Meteo', 51, '/PrevisioniDomani', 'link1', 1, 'matteo', NULL),
(18, 'Normal', 'Meteo', 52, '/MeteoOggi', 'link2', 1, 'matteo', NULL),
(19, 'Function', 'Notizie', 80, '/News', 'Read|http://link/rss/link_rss', 1, 'admin', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `utenti`
--

CREATE TABLE `utenti` (
  `UserID` varchar(200) NOT NULL,
  `FirstName` text CHARACTER SET latin1,
  `LastName` text CHARACTER SET latin1,
  `Username` text CHARACTER SET latin1,
  `DataInsert` date DEFAULT NULL,
  `StatoUtente` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `utenti_message`
--

CREATE TABLE `utenti_message` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `FirstName` text,
  `DataInsert` datetime DEFAULT NULL,
  `Message` int(11) NOT NULL,
  `Text` varchar(2048) DEFAULT NULL,
  `Document` blob,
  `FileName` varchar(255) DEFAULT NULL,
  `MimeType` varchar(50) DEFAULT NULL,
  `FileId` varchar(250) DEFAULT NULL,
  `FileId2` varchar(250) DEFAULT NULL,
  `FileSize` int(11) DEFAULT NULL,
  `Width` int(11) DEFAULT NULL,
  `Height` int(11) DEFAULT NULL,
  `Archive` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `message_scheduler`
--
ALTER TABLE `message_scheduler`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `message_send`
--
ALTER TABLE `message_send`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `software_config`
--
ALTER TABLE `software_config`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `SoftDesc` (`SoftDesc`,`Code`);

--
-- Indexes for table `software_config_button`
--
ALTER TABLE `software_config_button`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `utenti`
--
ALTER TABLE `utenti`
  ADD PRIMARY KEY (`UserID`);

--
-- Indexes for table `utenti_message`
--
ALTER TABLE `utenti_message`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `message_scheduler`
--
ALTER TABLE `message_scheduler`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `message_send`
--
ALTER TABLE `message_send`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;
--
-- AUTO_INCREMENT for table `software_config`
--
ALTER TABLE `software_config`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `software_config_button`
--
ALTER TABLE `software_config_button`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `utenti_message`
--
ALTER TABLE `utenti_message`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=172;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

