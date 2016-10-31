--Aggiornamento del 31 ottobre 2016 da applicare ad una installazione già presente
-- 
-- Questo aggiornamento è da applicare solo se avete fatto una installazione
-- di Sbot prima del 31 ottobre 2016, altrimenti basta usare telegram_base.sql
-- Applica 12_update.sql
--
-- Apply the patch 11_update.sql only not first installation. Or installation is antecedent at 30/10/2016
-- Apply 12_update.sql


--
-- Sbot version 0.53
--

--- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--


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
-- Struttura della tabella `utenti_log`
--

CREATE TABLE `utenti_log` (
  `IdOperation` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `LogDate` datetime NOT NULL,
  `Operation` text NOT NULL,
  `Result` varchar(4000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `utenti_log`
--
ALTER TABLE `utenti_log`
  ADD PRIMARY KEY (`IdOperation`),
  ADD KEY `IdOperation` (`IdOperation`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `utenti_log`
--
ALTER TABLE `utenti_log`
  MODIFY `IdOperation` int(11) NOT NULL AUTO_INCREMENT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
