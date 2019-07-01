-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 01, 2019 at 08:22 AM
-- Server version: 5.7.26
-- PHP Version: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `polls_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `polls_options`
--

DROP TABLE IF EXISTS `polls_options`;
CREATE TABLE IF NOT EXISTS `polls_options` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `sub_id` int(10) NOT NULL,
  `poll_option` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `sub_id` (`sub_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `polls_options`
--

INSERT INTO `polls_options` (`id`, `sub_id`, `poll_option`) VALUES
(1, 1, 'Miguel de Cervantes'),
(2, 1, 'Charles Dickens'),
(3, 1, 'J.R.R. Tolkien'),
(4, 1, 'Antoine de Saint-Exuper');

-- --------------------------------------------------------

--
-- Table structure for table `poll_count`
--

DROP TABLE IF EXISTS `poll_count`;
CREATE TABLE IF NOT EXISTS `poll_count` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `sub_id` int(10) NOT NULL,
  `poll_option_id` int(10) NOT NULL,
  `vote_count` bigint(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `id_2` (`id`),
  KEY `sub_id` (`sub_id`,`poll_option_id`),
  KEY `poll_option_1d` (`poll_option_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `poll_count`
--

INSERT INTO `poll_count` (`id`, `sub_id`, `poll_option_id`, `vote_count`) VALUES
(14, 1, 1, 2),
(15, 1, 2, 1),
(16, 1, 3, 4),
(17, 1, 4, 5);

-- --------------------------------------------------------

--
-- Table structure for table `poll_subject`
--

DROP TABLE IF EXISTS `poll_subject`;
CREATE TABLE IF NOT EXISTS `poll_subject` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `subject` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('1','0') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `poll_subject`
--

INSERT INTO `poll_subject` (`id`, `subject`, `status`) VALUES
(1, 'Who is your favourite author?', '1');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `polls_options`
--
ALTER TABLE `polls_options`
  ADD CONSTRAINT `polls_options_ibfk_1` FOREIGN KEY (`sub_id`) REFERENCES `poll_subject` (`id`);

--
-- Constraints for table `poll_count`
--
ALTER TABLE `poll_count`
  ADD CONSTRAINT `poll_count_ibfk_1` FOREIGN KEY (`sub_id`) REFERENCES `poll_subject` (`id`),
  ADD CONSTRAINT `poll_count_ibfk_2` FOREIGN KEY (`poll_option_id`) REFERENCES `polls_options` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
