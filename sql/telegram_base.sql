-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Set 08, 2015 alle 18:41
-- Versione del server: 5.6.24
-- PHP Version: 5.5.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `telegram`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `admins`
--

CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(120) NOT NULL,
  `password` varchar(120) NOT NULL,
  `signature` VARCHAR(255) NULL,
  `level` VARCHAR(25) NULL;
  `active` int(2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `admins`
--
-- default user:admin  default_password:password
INSERT INTO `admins` (`id`, `username`, `password`, `active`) VALUES
(1, 'admin', 'sha256:1000:T2vvAPNGbltVdfnLi3hveiuCi/4Chp5w:u/U7a9WppkzD2213syyhruPMTFHSguCI',admin, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti`
--

CREATE TABLE IF NOT EXISTS `utenti` (
  `UserID` int(11) NOT NULL,
  `FirstName` text,
  `LastName` text,
  `Username` text,
  `DataInsert` date DEFAULT NULL,
  `StatoUtente` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Struttura della tabella `utenti_message` Registra i messaggi inviati dagli utenti
--

CREATE TABLE IF NOT EXISTS `utenti_message` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `FirstName` text,
  `DataInsert` datetime DEFAULT NULL,
  `Message` int(11) NOT NULL,
  `Text` varchar(2048) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
  


--
-- Dump dei dati per la tabella `message_send`
--


SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE IF NOT EXISTS `message_send` (
  `ID` int(11) NOT NULL,
  `DataInsert` datetime DEFAULT NULL,
  `Text` varchar(2048) CHARACTER SET utf8 NOT NULL,
  `Signature` VARCHAR(255) NULL AFTER,
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


ALTER TABLE `message_send`
  ADD PRIMARY KEY (`ID`);


ALTER TABLE `message_send`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

  
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
