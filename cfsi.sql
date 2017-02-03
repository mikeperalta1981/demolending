-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 29, 2015 at 04:37 AM
-- Server version: 5.6.14
-- PHP Version: 5.5.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cfsi`
--

-- --------------------------------------------------------

--
-- Table structure for table `collection_schedule`
--

CREATE TABLE IF NOT EXISTS `collection_schedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `customer_loan_id` int(11) NOT NULL,
  `collection_date` date NOT NULL,
  `amount_due` decimal(10,0) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE IF NOT EXISTS `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_no` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `surname` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `middlename` varchar(255) NOT NULL,
  `nickname` varchar(50) DEFAULT NULL,
  `address_home_no` varchar(10) DEFAULT NULL,
  `address_st_name` varchar(255) DEFAULT NULL,
  `address_brgy` varchar(255) DEFAULT NULL,
  `address_municipality` varchar(255) DEFAULT NULL,
  `address_city` varchar(255) DEFAULT NULL,
  `address_prov` varchar(255) DEFAULT NULL,
  `postal_code` varchar(10) DEFAULT NULL,
  `residence_phone` varchar(20) NOT NULL,
  `house_type` varchar(255) DEFAULT NULL,
  `length_of_stay` varchar(50) DEFAULT NULL,
  `mobile_phone` varchar(20) NOT NULL,
  `birthdate` date NOT NULL,
  `age` int(11) NOT NULL,
  `marital_status` varchar(20) NOT NULL,
  `no_of_dependents` int(11) DEFAULT NULL,
  `type_of_business` varchar(50) DEFAULT NULL,
  `years_in_operation` int(11) DEFAULT NULL,
  `gross_income_monthly` decimal(10,0) DEFAULT NULL,
  `monthly_expenses` decimal(10,0) DEFAULT NULL,
  `other_source_of_income` varchar(255) DEFAULT NULL,
  `osi_gross_income` decimal(10,0) DEFAULT NULL,
  `osi_monthly_expenses` decimal(10,0) DEFAULT NULL,
  `assets` varchar(255) DEFAULT NULL,
  `spouse_surname` varchar(255) DEFAULT NULL,
  `spouse_firstname` varchar(255) DEFAULT NULL,
  `spouse_middlename` varchar(255) DEFAULT NULL,
  `spouse_nickname` varchar(255) DEFAULT NULL,
  `spouse_source_of_income` varchar(255) DEFAULT NULL,
  `spouse_business_type` varchar(50) DEFAULT NULL,
  `spouse_business_type_years_in_operation` int(11) DEFAULT NULL,
  `spouse_priv_govt` varchar(20) DEFAULT NULL,
  `spouse_present_employer` varchar(255) DEFAULT NULL,
  `spouse_gross_income` decimal(10,0) DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=75 ;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `account_no`, `created_at`, `created_by`, `updated_at`, `surname`, `firstname`, `middlename`, `nickname`, `address_home_no`, `address_st_name`, `address_brgy`, `address_municipality`, `address_city`, `address_prov`, `postal_code`, `residence_phone`, `house_type`, `length_of_stay`, `mobile_phone`, `birthdate`, `age`, `marital_status`, `no_of_dependents`, `type_of_business`, `years_in_operation`, `gross_income_monthly`, `monthly_expenses`, `other_source_of_income`, `osi_gross_income`, `osi_monthly_expenses`, `assets`, `spouse_surname`, `spouse_firstname`, `spouse_middlename`, `spouse_nickname`, `spouse_source_of_income`, `spouse_business_type`, `spouse_business_type_years_in_operation`, `spouse_priv_govt`, `spouse_present_employer`, `spouse_gross_income`, `active`) VALUES
(1, 1000001, '2014-12-11 00:58:35', 0, '0000-00-00 00:00:00', 'Peralta', 'Michael John', 'Gonzaga', 'Mike', 'Arista Pla', 'J.P. RIzal St.', 'Sto. Nino', '', 'Paranaque', '', '10001', '1111111', NULL, '1 yr', '2222222', '1981-02-16', 16, 'MARRIED', 333, 'Saklaan', 15, '10000', '2000', '', '0', '0', NULL, 'Julian', 'Barreto', 'G', 'Julz', 'Robbery', '', 0, 'private', 'MDC', '220000', 1),
(72, 111111, '2015-01-26 23:29:06', 0, '0000-00-00 00:00:00', 'asd', 'sad', 'sdg', 'sdg', 'sdg', 'sdg', 'sdg', 'sdg', 'sdg', 'sdg', 'sdg', '235', '["2"]', '2', '35', '2010-02-16', 4, 'MARRIED', 35, 'sg', 33, '124', '142124', 'sdggd', '124', '1241241', '["1","3","5","7","8"]', 'sdg', 'sdg', 'sadg', 'sdg', 'sdggsd', 'sdg', 22, 'private', 'sdgsd', '32352', 1),
(73, 352352, '2015-01-28 03:39:37', 0, '2015-01-28 11:39:37', 'sdg', 'sdg', 'asdg', 'asdg', '235', 'Asdg', 'sdg', 'sadg', 'asgd', 'sdg', '323', 'sag', NULL, '22', 'sdg2', '2010-02-03', 4, 'SEPARATED', NULL, 'Asdg', 2, '235', '325', 'dsggsda', '13214', '2342', NULL, 'sa', 'asdg', 'sgd', 'sgd', 'gsdg', 'wet', NULL, NULL, 'dg', '222', 1),
(74, 7777, '2015-01-28 03:43:52', 0, '2015-01-28 11:43:52', 'asdg', 'asdg', 'asdg', 'asdg', '2', 'sdg', 'sdg', 'sdg', 'sdg', 'asdg', '32', '214', '["1"]', '12', '23', '2010-02-02', 4, 'MARRIED', NULL, 'asg', 3, '213', '124', 'sdagsa', '124', '1241', '["1","6"]', 'gigi', 'mucho', 'asdg', 'asdg', 'sadg', 'sdagsdg', 0, 'private', 'sdgsd', '2325', 1);

-- --------------------------------------------------------

--
-- Table structure for table `customers_assets`
--

CREATE TABLE IF NOT EXISTS `customers_assets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `asset` varchar(255) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `customers_assets`
--

INSERT INTO `customers_assets` (`id`, `asset`, `active`) VALUES
(1, 'AIR CONDITIONING', 1),
(2, 'DVD PLAYER', 1),
(3, 'PERSONAL COMPUTER', 1),
(4, 'REFRIGIRATOR/FREEZER', 1),
(5, 'TV/CTV', 1),
(6, 'MOTORCYCLE/TRICYCLE', 1),
(7, 'CAR/JEEP', 1),
(8, 'COMPONENT/SOUND SYSTEM', 1);

-- --------------------------------------------------------

--
-- Table structure for table `customers_house_type`
--

CREATE TABLE IF NOT EXISTS `customers_house_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `house_type` varchar(100) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `customers_house_type`
--

INSERT INTO `customers_house_type` (`id`, `house_type`, `active`) VALUES
(1, 'OWNED', 1),
(2, 'RENTED', 1),
(3, 'MORTGAGED', 1),
(4, 'WITH RELATIVES', 1);

-- --------------------------------------------------------

--
-- Table structure for table `customers_loan`
--

CREATE TABLE IF NOT EXISTS `customers_loan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `loan_amount` decimal(10,0) NOT NULL,
  `loan_proceeds` decimal(10,0) NOT NULL,
  `loan_term` int(11) NOT NULL,
  `date_released` date NOT NULL,
  `maturity_date` date NOT NULL,
  `daily_amort` decimal(10,0) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `customers_references`
--

CREATE TABLE IF NOT EXISTS `customers_references` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `surname` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `middlename` varchar(255) DEFAULT NULL,
  `relationship` varchar(255) DEFAULT NULL,
  `school_employer` varchar(255) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `is_dependent` varchar(5) DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `customers_references`
--

INSERT INTO `customers_references` (`id`, `customer_id`, `created_at`, `created_by`, `updated_at`, `surname`, `firstname`, `middlename`, `relationship`, `school_employer`, `age`, `is_dependent`, `active`) VALUES
(1, 1, '0000-00-00 00:00:00', 0, '2014-12-11 15:58:35', 'Peralta', 'Mikaela', 'San Juan', 'Daughter', 'NA', 7, 'yes', 1),
(2, 1, '0000-00-00 00:00:00', 0, '2014-12-11 15:58:35', 'Jaden', 'Miguel', 'San Juan', 'Son', 'NA', 3, 'yes', 1),
(14, 72, '0000-00-00 00:00:00', 0, '2015-01-27 14:29:06', 'sadg', 'sad', 'asd', 'gsasdg', 'sadg', 1, 'yes', 1),
(15, 72, '0000-00-00 00:00:00', 0, '2015-01-27 14:29:06', 'sdgs', 'sdgsgd', 'dfhdf', 'herhehr', 'sddhd', 2, 'no', 1),
(16, 73, '0000-00-00 00:00:00', 0, '2015-01-28 11:39:38', 'asdg', 'asdg', 'asg', 'sd', 'gasdg', 1, 'yes', 1),
(17, 74, '0000-00-00 00:00:00', 0, '2015-01-28 11:43:52', 'tatatat', 'gegeeg', 'aaaaaa', 'sss', 'rrrrrr', 4, 'no', 1),
(18, 74, '0000-00-00 00:00:00', 0, '2015-01-28 11:43:52', 'wwwww', 'baabdbd', 'bbbb', 'nnnn', 'mmmmm', 8, 'yes', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `active` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
