-- Version of Strructure Oct 09, 2015
-- DB {S}Bot
--
-- Host: localhost
-- Generation Time: Oct 09, 2015 at 09:25 AM
-- 
-- PHP Version: 5.5.9-1ubuntu4.13

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

CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(120) NOT NULL,
  `password` varchar(120) NOT NULL,
  `signature` varchar(255) DEFAULT NULL,
  `level` varchar(25) DEFAULT 'admin',
  `active` int(2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admins`
--
-- default user:admin  default_password:password
--

INSERT INTO `admins` (`id`, `username`, `password`, `signature`, `level`, `active`) VALUES
(1, 'admin', 'sha256:1000:T2vvAPNGbltVdfnLi3hveiuCi/4Chp5w:u/U7a9WppkzD2213syyhruPMTFHSguCI', 'Il Team del Bot', 'admin', 1);

-- --------------------------------------------------------

--
-- Table structure for table `message_send`
--

CREATE TABLE IF NOT EXISTS `message_send` (
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
-- Table structure for table `utenti`
--

CREATE TABLE IF NOT EXISTS `utenti` (
  `UserID` int(11) NOT NULL,
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

CREATE TABLE IF NOT EXISTS `utenti_message` (
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
-- Indexes for table `message_send`
--
ALTER TABLE `message_send`
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
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `ID` (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `message_send`
--
ALTER TABLE `message_send`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=124;
--
-- AUTO_INCREMENT for table `utenti_message`
--
ALTER TABLE `utenti_message`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19284;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
