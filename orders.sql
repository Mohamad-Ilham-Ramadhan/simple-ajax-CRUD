-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 10, 2017 at 06:38 AM
-- Server version: 5.5.53-0ubuntu0.14.04.1
-- PHP Version: 5.6.29-1+deb.sury.org~trusty+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `coffee_orders`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `drink` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=291 ;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `name`, `drink`) VALUES
(36, 'Udin Gamboet', 'Jamu Kuat'),
(42, 'Wiz', 'Weed Juice original taylor gang'),
(43, 'MGK', 'Kecut seger'),
(44, 'Ilham', 'Coffee Hitam kupu-kupuku'),
(189, 'Laura', 'Tea'),
(190, 'Sena', 'Lemon Tea'),
(288, 'Leon', 'Ganja Liquid'),
(289, 'MasMus', 'Es Doger'),
(290, 'Loki', 'Cendol');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
