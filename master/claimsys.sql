-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 28, 2015 at 10:21 AM
-- Server version: 5.6.16
-- PHP Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `claimsys`
--

-- --------------------------------------------------------

--
-- Table structure for table `recordmaster`
--

CREATE TABLE IF NOT EXISTS `recordmaster` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `makerName` varchar(50) NOT NULL,
  `date` date DEFAULT NULL,
  `status` int(11) NOT NULL,
  `editedBy` varchar(20) NOT NULL,
  `modified` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `recordmaster`
--

INSERT INTO `recordmaster` (`id`, `makerName`, `date`, `status`, `editedBy`, `modified`) VALUES
(20, 'KALDEWEI', '2015-12-08', 0, 'admin', '2015-12-28');

-- --------------------------------------------------------

--
-- Table structure for table `records`
--

CREATE TABLE IF NOT EXISTS `records` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_recordMaster` int(11) NOT NULL,
  `id_dmg` varchar(50) NOT NULL,
  `modelNo` varchar(50) NOT NULL,
  `tformNo` varchar(30) NOT NULL,
  `orderNo` varchar(50) NOT NULL,
  `spec` varchar(100) NOT NULL,
  `invoiceNo` varchar(50) NOT NULL,
  `invoiceDate` date DEFAULT NULL,
  `invoiceGntNo` varchar(50) NOT NULL,
  `invoiceValue` double NOT NULL,
  `damageType` int(11) NOT NULL,
  `damageSize` double NOT NULL,
  `damageMemoEn` varchar(150) NOT NULL,
  `damageMemoJp` varchar(150) NOT NULL,
  `currency` varchar(20) NOT NULL,
  `flgPending` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=553 ;

--
-- Dumping data for table `records`
--

INSERT INTO `records` (`id`, `id_recordMaster`, `id_dmg`, `modelNo`, `tformNo`, `orderNo`, `spec`, `invoiceNo`, `invoiceDate`, `invoiceGntNo`, `invoiceValue`, `damageType`, `damageSize`, `damageMemoEn`, `damageMemoJp`, `currency`, `flgPending`) VALUES
(482, 0, 'D-151202-36', '372-1', '', '', '', '', NULL, '', 0, 0, 0, '', '', '', 0),
(483, 0, 'D-151202-37', '372-1', '', '', '', '', NULL, '', 0, 0, 0, '', '', '', 0),
(484, 0, 'D-151202-38', '361-1SPE', '', '', '', '', NULL, '', 0, 0, 0, '', '', '', 0),
(485, 0, 'D-151202-38', '361-1SPE', '', '', '', '', NULL, '', 0, 0, 0, '', '', '', 0),
(486, 0, 'D-151202-37', '372-1', '', '', '', '', NULL, '', 0, 0, 0, '', '', '', 0),
(487, 0, 'D-151202-36', '372-1', '', '', '', '', NULL, '', 0, 0, 0, '', '', '', 0),
(488, 0, 'D-151202-36', '372-1', '', '', '', '', NULL, '', 0, 0, 0, '', '', '', 0),
(489, 0, 'D-151202-38', '361-1SPE', '', '', '', '', NULL, '', 0, 0, 0, '', '', '', 0),
(490, 0, 'D-151202-37', '372-1', '', '', '', '', NULL, '', 0, 0, 0, '', '', '', 0),
(491, 0, 'D-151202-36', '372-1', '', '', '', '', NULL, '', 0, 0, 0, '', '', '', 0),
(492, 0, 'D-151202-38', '361-1SPE', '', '', '', '', NULL, '', 0, 0, 0, '', '', '', 0),
(493, 0, 'D-151202-37', '372-1', '', '', '', '', NULL, '', 0, 0, 0, '', '', '', 0),
(494, 0, 'D-151202-37', '372-1', '', '', '', '', NULL, '', 0, 0, 0, '', '', '', 0),
(495, 0, 'D-151202-36', '372-1', '', '', '', '', NULL, '', 0, 0, 0, '', '', '', 0),
(496, 0, 'D-151202-38', '361-1SPE', '', '', '', '', NULL, '', 0, 0, 0, '', '', '', 0),
(507, 20, 'D-FLN72-151207-8', '366-1', 'ADF70-1112-A01', '', '', '', '2015-12-10', '', 1200, 1, 4, '', '', '0', 2),
(548, 20, 'D-FLN72-151207-7', '122-D', 'ADF80-1111-222', '', '', '', '2015-12-02', '', 0, 0, 0, '', '', '0', 0),
(549, 20, '', '', '', '', '', '', '2015-12-10', '', 0, 0, 0, '', '', '0', 0),
(550, 20, '', '', '', '', '', '', '2015-12-05', '', 0, 0, 0, '', '', '0', 0),
(551, 20, '', '', '', '', '', '', '2015-12-02', '', 0, 0, 0, '', '', '0', 0),
(552, 20, '', '', '', '', '', '', '2015-12-01', '', 0, 0, 0, '', '', '0', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userName` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `userName`) VALUES
(1, 'admin'),
(2, '河合'),
(3, 'ハウ'),
(4, '上杉');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
