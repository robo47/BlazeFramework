-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 10. August 2010 um 07:02
-- Server Version: 5.1.41
-- PHP-Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `dstest`
--
CREATE DATABASE `dstest` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `dstest`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `testtable`
--

CREATE TABLE IF NOT EXISTS `testtable` (
  `integer` int(11) NOT NULL,
  `string` varchar(40) DEFAULT NULL,
  `double` double NOT NULL,
  `boolean` tinyint(1) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`integer`),
  UNIQUE KEY `date` (`date`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `testtable`
--


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
