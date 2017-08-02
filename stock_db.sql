-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 01, 2017 at 06:27 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `stock_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_balance`
--

CREATE TABLE IF NOT EXISTS `tbl_balance` (
  `bal_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `open_bal_usd` decimal(18,2) NOT NULL,
  `open_bal_riel` int(11) NOT NULL,
  `exchange_rate` int(10) DEFAULT '4000',
  `bal_status` tinyint(1) NOT NULL DEFAULT '1',
  `open_bal_desc` text,
  `user_crea` varchar(20) NOT NULL,
  `date_crea` date NOT NULL,
  `user_updt` varchar(20) DEFAULT NULL,
  `date_updt` date DEFAULT NULL,
  PRIMARY KEY (`bal_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

--
-- Dumping data for table `tbl_balance`
--

INSERT INTO `tbl_balance` (`bal_id`, `user_id`, `open_bal_usd`, `open_bal_riel`, `exchange_rate`, `bal_status`, `open_bal_desc`, `user_crea`, `date_crea`, `user_updt`, `date_updt`) VALUES
(36, 12, '100.00', 100000, 4000, 0, 'This is the balance of seller&nbsp;', 'admin', '2017-08-01', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE IF NOT EXISTS `tbl_category` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(100) DEFAULT NULL,
  `cat_name_kh` varchar(100) DEFAULT NULL,
  `cat_desc` varchar(250) DEFAULT NULL,
  `user_crea` varchar(50) DEFAULT NULL,
  `date_crea` date DEFAULT NULL,
  `user_updt` varchar(50) DEFAULT NULL,
  `date_updt` date DEFAULT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`cat_id`, `cat_name`, `cat_name_kh`, `cat_desc`, `user_crea`, `date_crea`, `user_updt`, `date_updt`) VALUES
(8, 'Mineral Water', 'ទឹកបរិសុទ្ធ', 'Hello world', 'admin', '2017-07-06', NULL, NULL),
(7, 'Drink', 'ភេសជ្ជះ', 'Hello world', 'admin', '2017-07-06', 'admin', '2017-07-06'),
(9, 'Beer', 'ស្រាបៀរ', 'Hello worl', 'admin', '2017-07-06', NULL, NULL),
(10, 'Candy', 'ស្កគ្រាប់', 'fadafda', 'admin', '2017-07-23', 'admin', '2017-07-23'),
(11, 'Food', 'អាហារ', 'Hello world', 'admin', '2017-07-25', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_closeshift`
--

CREATE TABLE IF NOT EXISTS `tbl_closeshift` (
  `clsft_id` int(11) NOT NULL AUTO_INCREMENT,
  `clsft_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  `ttl_usd` decimal(18,2) NOT NULL,
  `ttl_riel` int(11) NOT NULL,
  `cash_usd` decimal(18,2) NOT NULL,
  `cash_riel` int(11) NOT NULL,
  `exchange_usd` decimal(18,2) NOT NULL,
  `exchange_riel` int(11) NOT NULL,
  `open_bal_usd` decimal(18,2) NOT NULL,
  `open_bal_riel` int(11) NOT NULL,
  `ending_bal_usd` decimal(18,2) NOT NULL,
  `ending_bal_riel` int(11) NOT NULL,
  `exchange_rate` int(11) NOT NULL,
  PRIMARY KEY (`clsft_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_closeshift`
--

INSERT INTO `tbl_closeshift` (`clsft_id`, `clsft_date`, `user_id`, `ttl_usd`, `ttl_riel`, `cash_usd`, `cash_riel`, `exchange_usd`, `exchange_riel`, `open_bal_usd`, `open_bal_riel`, `ending_bal_usd`, `ending_bal_riel`, `exchange_rate`) VALUES
(2, '2017-08-01 23:23:10', 12, '143.26', 573000, '150.00', 0, '6.74', 26960, '100.00', 100000, '243.26', 673000, 4000);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_delivery`
--

CREATE TABLE IF NOT EXISTS `tbl_delivery` (
  `del_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `per_id` int(10) unsigned NOT NULL,
  `del_status` tinyint(3) unsigned NOT NULL,
  `del_addr1` text,
  `del_desc` text,
  `user_crea` varchar(60) NOT NULL,
  `date_crea` date NOT NULL,
  `user_updt` varchar(60) DEFAULT NULL,
  `date_updt` date DEFAULT NULL,
  PRIMARY KEY (`del_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tbl_delivery`
--

INSERT INTO `tbl_delivery` (`del_id`, `per_id`, `del_status`, `del_addr1`, `del_desc`, `user_crea`, `date_crea`, `user_updt`, `date_updt`) VALUES
(2, 1, 1, '154,str,272,dermkor,phnom penh ,cambodai', 'Hello world', 'admin', '2017-07-05', 'admin', '2017-07-25'),
(3, 4, 1, '124#,str145 dounpenh,phnom penh,cambodai', 'Hello world', 'admin', '2017-07-25', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_delivery_transaction`
--

CREATE TABLE IF NOT EXISTS `tbl_delivery_transaction` (
  `del_tr_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `del_id` int(10) unsigned NOT NULL,
  `inv_hdr_id` int(10) unsigned NOT NULL,
  `staff_id` int(10) unsigned NOT NULL,
  `del_tr_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(3) unsigned DEFAULT NULL,
  `user_crea` varchar(60) NOT NULL,
  `date_crea` date NOT NULL,
  `user_updt` varchar(60) DEFAULT NULL,
  `date_updt` date DEFAULT NULL,
  PRIMARY KEY (`del_tr_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `tbl_delivery_transaction`
--

INSERT INTO `tbl_delivery_transaction` (`del_tr_id`, `del_id`, `inv_hdr_id`, `staff_id`, `del_tr_date`, `status`, `user_crea`, `date_crea`, `user_updt`, `date_updt`) VALUES
(10, 2, 68, 1, '2017-08-01 16:13:49', 1, 'seller', '2017-08-01', NULL, NULL),
(9, 2, 65, 1, '2017-08-01 03:18:06', 1, 'dara', '2017-08-01', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_expense`
--

CREATE TABLE IF NOT EXISTS `tbl_expense` (
  `exp_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `exp_type` varchar(100) NOT NULL,
  `exp_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `exp_amount_usd` decimal(18,2) NOT NULL,
  `exp_amount_riel` decimal(18,2) DEFAULT NULL,
  `exp_desc` text,
  `user_crea` varchar(60) NOT NULL,
  `date_crea` date NOT NULL,
  `user_updt` varchar(60) DEFAULT NULL,
  `date_updt` date DEFAULT NULL,
  PRIMARY KEY (`exp_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_expense`
--

INSERT INTO `tbl_expense` (`exp_id`, `exp_type`, `exp_date`, `exp_amount_usd`, `exp_amount_riel`, `exp_desc`, `user_crea`, `date_crea`, `user_updt`, `date_updt`) VALUES
(2, 'computer', '2017-07-05 04:20:48', '20.00', '5000.00', 'Helo wold', 'admin', '2017-07-05', 'admin', '2017-07-25');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_invoice_detail`
--

CREATE TABLE IF NOT EXISTS `tbl_invoice_detail` (
  `inv_det_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `inv_hdr_id` int(10) unsigned NOT NULL,
  `pro_id` int(10) unsigned NOT NULL,
  `qty` int(10) unsigned NOT NULL,
  `price_usd` decimal(18,2) NOT NULL,
  `price_riel` int(11) DEFAULT NULL,
  PRIMARY KEY (`inv_det_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=238 ;

--
-- Dumping data for table `tbl_invoice_detail`
--

INSERT INTO `tbl_invoice_detail` (`inv_det_id`, `inv_hdr_id`, `pro_id`, `qty`, `price_usd`, `price_riel`) VALUES
(237, 68, 36, 2, '4.00', 16000),
(232, 69, 33, 2, '14.00', 56000),
(231, 69, 31, 2, '12.00', 48000),
(230, 69, 27, 2, '11.00', 44000),
(236, 68, 37, 2, '0.63', 2500),
(235, 68, 23, 2, '30.00', 120000);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_invoice_hdr`
--

CREATE TABLE IF NOT EXISTS `tbl_invoice_hdr` (
  `inv_hdr_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `per_id` int(10) unsigned NOT NULL,
  `inv_hdr_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `inv_no` varchar(30) NOT NULL,
  `inv_hdr_status` tinyint(3) unsigned NOT NULL,
  `credit` int(1) DEFAULT NULL,
  `user_crea` varchar(60) NOT NULL,
  `date_crea` date NOT NULL,
  `user_updt` varchar(60) DEFAULT NULL,
  `date_updt` date DEFAULT NULL,
  PRIMARY KEY (`inv_hdr_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=70 ;

--
-- Dumping data for table `tbl_invoice_hdr`
--

INSERT INTO `tbl_invoice_hdr` (`inv_hdr_id`, `per_id`, `inv_hdr_date`, `inv_no`, `inv_hdr_status`, `credit`, `user_crea`, `date_crea`, `user_updt`, `date_updt`) VALUES
(69, 5, '2017-08-01 16:01:36', '170801-0002', 2, 1, 'seller', '2017-08-01', NULL, NULL),
(68, 5, '2017-08-01 15:59:40', '170801-0001', 2, 1, 'seller', '2017-08-01', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_person`
--

CREATE TABLE IF NOT EXISTS `tbl_person` (
  `per_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `per_name` varchar(60) NOT NULL,
  `per_type` varchar(60) NOT NULL,
  `per_email` varchar(100) DEFAULT NULL,
  `per_phone` varchar(15) NOT NULL,
  `per_address` text,
  `per_status` tinyint(3) unsigned NOT NULL,
  `per_desc` text,
  `user_crea` varchar(60) NOT NULL,
  `date_crea` date NOT NULL,
  `user_updt` varchar(60) DEFAULT NULL,
  `date_updt` date DEFAULT NULL,
  PRIMARY KEY (`per_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tbl_person`
--

INSERT INTO `tbl_person` (`per_id`, `per_name`, `per_type`, `per_email`, `per_phone`, `per_address`, `per_status`, `per_desc`, `user_crea`, `date_crea`, `user_updt`, `date_updt`) VALUES
(1, 'choumeng', 'customer', 'choumengit@gmail.com', '086830867', 'pp', 1, 'Hello world', 'admin', '2017-07-05', NULL, NULL),
(2, 'Choumeng', 'supplyer', 'choumengit@gmail.com', '086830867', 'PP', 1, 'Hello world', 'admin', '2017-07-07', NULL, NULL),
(3, 'sophea', 'supplyer', 'sophea@gmail.com', '086830867', 'pp', 1, 'Hello world', 'admin', '2017-07-07', 'admin', '2017-07-25'),
(4, 'Samnang', 'customer', 'samnang@yahoo.com', '086830867', 'PP', 1, 'Hello world', 'admin', '2017-07-23', NULL, NULL),
(5, 'General', 'customer', '', '086830867', 'NO Address', 1, 'It is The general customer...', 'admin', '2017-07-28', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product`
--

CREATE TABLE IF NOT EXISTS `tbl_product` (
  `pro_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cat_id` int(10) unsigned NOT NULL,
  `pro_name` varchar(60) NOT NULL,
  `pro_image` varchar(255) DEFAULT NULL,
  `pro_status` tinyint(3) unsigned NOT NULL,
  `pro_desc` text,
  `user_crea` varchar(60) NOT NULL,
  `date_crea` date NOT NULL,
  `user_updt` varchar(60) DEFAULT NULL,
  `date_updt` date DEFAULT NULL,
  PRIMARY KEY (`pro_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=40 ;

--
-- Dumping data for table `tbl_product`
--

INSERT INTO `tbl_product` (`pro_id`, `cat_id`, `pro_name`, `pro_image`, `pro_status`, `pro_desc`, `user_crea`, `date_crea`, `user_updt`, `date_updt`) VALUES
(26, 9, 'Cambodai', 'anchor-smooth-pilsener-beer-can-330-ml-24-pack-500x500.png', 1, 'welcom to cambodia of wonder', 'admin', '2017-07-23', NULL, NULL),
(24, 9, 'Turbog', 'main-qimg-e79d89953fa9f8b1d3765429a94977b7-c.jpg', 1, 'Hello tuborg', 'admin', '2017-07-23', NULL, NULL),
(25, 9, 'Anchor', 'anchor_beer_323ml_canned.jpg', 1, 'welcom to anchor', 'admin', '2017-07-23', NULL, NULL),
(23, 9, 'ABC', '53835c3524a91d9952f7312c9bff7ea5--acquired-taste-beer-cans.jpg', 1, 'Hello abc', 'admin', '2017-07-23', NULL, NULL),
(27, 9, 'Angkor', 'Angkor-150x150.jpg', 1, 'Hello angkor', 'admin', '2017-07-23', NULL, NULL),
(28, 9, 'Heineken', '9f90e1d68528592236c2d99922c7cdc4.jpg', 1, 'wecom to heineken', 'admin', '2017-07-23', NULL, NULL),
(29, 9, 'Singha', 'beer-online-singha-beer-scaled600.jpg', 1, 'welcom to singha', 'admin', '2017-07-23', NULL, NULL),
(30, 7, 'M150', '8851123212526_2.jpg', 1, 'Hello m150', 'admin', '2017-07-23', NULL, NULL),
(31, 7, 'Carabao', '72012.jpg', 1, 'Hello caraboa', 'admin', '2017-07-23', NULL, NULL),
(32, 7, 'Sting', 'Sting-Red-can-01.jpg', 1, 'Hello sting', 'admin', '2017-07-23', NULL, NULL),
(33, 7, 'Cocacolar', '2A975A1200000578-3164107-image-m-39_1437124518040.jpg', 1, 'Hello cocacola', 'admin', '2017-07-23', NULL, NULL),
(34, 7, 'Yeo''s', 'YEO-S-WITNER-MELON-TEA-DRINK-CAN.jpg', 1, 'jj', 'admin', '2017-07-23', 'admin', '2017-07-23'),
(35, 8, 'Dasani', '7-1_1_12__15697.1492924088.jpg', 1, 'Hello dasani', 'admin', '2017-07-23', NULL, NULL),
(36, 8, 'Kulen', 'Kulen-1500ml.jpg', 1, 'Hello kulen', 'admin', '2017-07-23', NULL, NULL),
(37, 10, 'XO', 's643667121527569464_p240_i1_w1000.jpeg', 1, 'ad', 'admin', '2017-07-23', NULL, NULL),
(38, 11, 'Mama noddle', 'Mama-Instant-Noodles.jpg', 1, 'Hello mama', 'admin', '2017-07-25', NULL, NULL),
(39, 11, 'Yeang nuddle', 'DSCN2956.jpg', 1, 'Hello world', 'admin', '2017-07-25', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_purchase_det`
--

CREATE TABLE IF NOT EXISTS `tbl_purchase_det` (
  `pch_det_id` int(11) NOT NULL AUTO_INCREMENT,
  `pch_id` int(11) DEFAULT NULL,
  `pro_id` int(11) DEFAULT NULL,
  `pch_qty` int(11) DEFAULT NULL,
  `pch_price_in_usd` decimal(18,2) DEFAULT NULL,
  `pch_price_in_riel` int(10) unsigned DEFAULT NULL,
  `pch_price_out_usd` decimal(18,2) DEFAULT NULL,
  `pch_price_out_riel` int(10) unsigned DEFAULT NULL,
  `pch_valid` date DEFAULT NULL,
  `pch_expire` date DEFAULT NULL,
  PRIMARY KEY (`pch_det_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=253 ;

--
-- Dumping data for table `tbl_purchase_det`
--

INSERT INTO `tbl_purchase_det` (`pch_det_id`, `pch_id`, `pro_id`, `pch_qty`, `pch_price_in_usd`, `pch_price_in_riel`, `pch_price_out_usd`, `pch_price_out_riel`, `pch_valid`, `pch_expire`) VALUES
(107, 62, 32, 10, '10.00', NULL, '12.00', NULL, '2017-07-23', '2017-07-23'),
(106, 61, 31, 10, '10.00', NULL, '12.00', NULL, '2017-07-23', '2017-07-23'),
(105, 60, 30, 10, '10.00', NULL, '14.00', NULL, '2017-07-23', '2017-07-23'),
(104, 59, 29, 10, '13.00', NULL, '15.00', NULL, '2017-07-23', '2017-07-23'),
(103, 58, 28, 10, '25.00', NULL, '30.00', NULL, '2017-07-23', '2017-07-23'),
(102, 57, 27, 10, '9.00', NULL, '11.00', NULL, '2017-07-23', '2017-07-23'),
(101, 56, 26, 10, '10.00', NULL, '12.00', NULL, '2017-07-23', '2017-07-23'),
(100, 55, 25, 10, '12.00', NULL, '16.00', NULL, '2017-07-23', '2017-07-28'),
(99, 54, 24, 10, '10.00', NULL, '15.00', NULL, '2017-07-23', '2017-07-28'),
(98, 53, 23, 10, '20.00', NULL, '30.00', NULL, '2017-07-23', '2017-07-24'),
(108, 63, 33, 10, '11.00', NULL, '14.00', NULL, '2017-07-23', '2017-07-23'),
(109, 64, 34, 10, '10.00', NULL, '12.00', NULL, '2017-07-23', '2017-07-23'),
(110, 65, 35, 10, '2.00', NULL, '3.00', NULL, '2017-07-23', '2017-07-23'),
(111, 66, 36, 10, '3.00', NULL, '4.00', NULL, '2017-07-23', '2017-07-23'),
(112, 67, 37, 10, NULL, 2000, NULL, 2500, '2017-07-23', '2017-07-23'),
(131, 76, 39, 20, NULL, 60000, NULL, 70000, '2017-07-25', '2017-07-25'),
(130, 75, 38, 20, NULL, 40000, NULL, 50000, '2017-07-25', '2017-07-25'),
(252, 108, 36, -2, NULL, NULL, NULL, NULL, NULL, NULL),
(247, 109, 33, -2, NULL, NULL, NULL, NULL, NULL, NULL),
(246, 109, 31, -2, NULL, NULL, NULL, NULL, NULL, NULL),
(251, 108, 37, -2, NULL, NULL, NULL, NULL, NULL, NULL),
(250, 108, 23, -2, NULL, NULL, NULL, NULL, NULL, NULL),
(245, 109, 27, -2, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_purchase_hdr`
--

CREATE TABLE IF NOT EXISTS `tbl_purchase_hdr` (
  `pch_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `per_id` int(10) unsigned NOT NULL,
  `inv_hdr_id` int(10) unsigned DEFAULT NULL,
  `pch_type` char(1) NOT NULL,
  `pch_hdr_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pch_desc` text,
  `pch_status` tinyint(3) unsigned NOT NULL,
  `user_crea` varchar(60) NOT NULL,
  `date_crea` date NOT NULL,
  `user_updt` varchar(60) DEFAULT NULL,
  `date_updt` date DEFAULT NULL,
  PRIMARY KEY (`pch_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=110 ;

--
-- Dumping data for table `tbl_purchase_hdr`
--

INSERT INTO `tbl_purchase_hdr` (`pch_id`, `per_id`, `inv_hdr_id`, `pch_type`, `pch_hdr_date`, `pch_desc`, `pch_status`, `user_crea`, `date_crea`, `user_updt`, `date_updt`) VALUES
(58, 2, NULL, 'i', '2017-07-23 10:46:01', 'Hello heineken', 1, 'admin', '2017-07-23', NULL, NULL),
(57, 2, NULL, 'i', '2017-07-23 10:44:40', 'Hello Angkor', 1, 'admin', '2017-07-23', NULL, NULL),
(56, 2, NULL, 'i', '2017-07-23 10:43:23', 'The first purchase cambodai', 1, 'admin', '2017-07-23', NULL, NULL),
(55, 2, NULL, 'i', '2017-07-23 10:42:03', 'The first purchase anchor', 1, 'admin', '2017-07-23', NULL, NULL),
(54, 2, NULL, 'i', '2017-07-23 10:40:36', 'The first purchase tuborg', 1, 'admin', '2017-07-23', NULL, NULL),
(53, 2, NULL, 'i', '2017-07-23 10:39:22', 'The first purchase abc', 1, 'admin', '2017-07-23', 'admin', '2017-07-25'),
(59, 2, NULL, 'i', '2017-07-23 10:48:53', 'The first purchase singha', 1, 'admin', '2017-07-23', NULL, NULL),
(60, 2, NULL, 'i', '2017-07-23 10:50:29', 'Hello m150', 1, 'admin', '2017-07-23', NULL, NULL),
(61, 2, NULL, 'i', '2017-07-23 10:51:29', 'The first purchase caraboa', 1, 'admin', '2017-07-23', NULL, NULL),
(62, 2, NULL, 'i', '2017-07-23 10:53:13', 'The first purchase sting', 1, 'admin', '2017-07-23', NULL, NULL),
(63, 2, NULL, 'i', '2017-07-23 10:55:14', 'The first purchase cocacola', 1, 'admin', '2017-07-23', NULL, NULL),
(64, 2, NULL, 'i', '2017-07-23 10:56:46', 'dfa', 1, 'admin', '2017-07-23', NULL, NULL),
(65, 2, NULL, 'i', '2017-07-23 11:02:01', 'asdf', 1, 'admin', '2017-07-23', NULL, NULL),
(66, 2, NULL, 'i', '2017-07-23 11:04:13', 'fd', 1, 'admin', '2017-07-23', NULL, NULL),
(67, 2, NULL, 'i', '2017-07-23 11:10:51', 'Hello candy xo', 1, 'admin', '2017-07-23', NULL, NULL),
(75, 2, NULL, 'i', '2017-07-25 16:48:53', 'Hello world', 1, 'admin', '2017-07-25', NULL, NULL),
(76, 2, NULL, 'i', '2017-07-25 16:52:47', 'hello choumeng', 1, 'admin', '2017-07-25', 'admin', '2017-07-25'),
(108, 0, 68, 'o', '2017-08-01 15:59:40', NULL, 1, 'seller', '2017-08-01', NULL, NULL),
(109, 0, 69, 'o', '2017-08-01 16:01:36', NULL, 1, 'seller', '2017-08-01', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_receipt`
--

CREATE TABLE IF NOT EXISTS `tbl_receipt` (
  `rec_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rec_no` varchar(200) DEFAULT NULL,
  `inv_hdr_id` int(10) unsigned NOT NULL,
  `rec_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ttl_usd` decimal(18,2) NOT NULL,
  `ttl_riel` int(11) NOT NULL,
  `cash_usd` decimal(18,2) NOT NULL,
  `cash_riel` int(11) NOT NULL,
  `exchange_usd` decimal(18,2) NOT NULL,
  `exchange_riel` int(11) NOT NULL,
  `ex_rate` decimal(10,0) NOT NULL,
  `rec_status` tinyint(3) unsigned NOT NULL,
  `clsft_status` tinyint(1) NOT NULL DEFAULT '1',
  `user_crea` varchar(60) NOT NULL,
  `date_crea` date NOT NULL,
  `user_updt` varchar(60) DEFAULT NULL,
  `date_updt` date DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`rec_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `tbl_receipt`
--

INSERT INTO `tbl_receipt` (`rec_id`, `rec_no`, `inv_hdr_id`, `rec_date`, `ttl_usd`, `ttl_riel`, `cash_usd`, `cash_riel`, `exchange_usd`, `exchange_riel`, `ex_rate`, `rec_status`, `clsft_status`, `user_crea`, `date_crea`, `user_updt`, `date_updt`, `user_id`) VALUES
(17, '170801-0001', 69, '2017-08-01 16:15:48', '74.00', 296000, '80.00', 0, '6.00', 24000, '4000', 1, 0, 'seller', '2017-08-01', NULL, NULL, 12),
(18, '170801-0002', 68, '2017-08-01 16:16:28', '69.26', 277000, '70.00', 0, '0.74', 2960, '4000', 1, 0, 'seller', '2017-08-01', NULL, NULL, 12);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_specification`
--

CREATE TABLE IF NOT EXISTS `tbl_specification` (
  `spec_id` int(11) NOT NULL AUTO_INCREMENT,
  `pro_id` int(11) DEFAULT NULL,
  `spec_type` varchar(50) DEFAULT NULL,
  `value1` varchar(100) DEFAULT NULL,
  `value2` varchar(100) DEFAULT NULL,
  `value3` varchar(100) DEFAULT NULL,
  `value4` varchar(100) DEFAULT NULL,
  `value5` varchar(100) DEFAULT NULL,
  `value6` varchar(100) DEFAULT NULL,
  `value7` varchar(100) DEFAULT NULL,
  `value8` varchar(100) DEFAULT NULL,
  `value9` varchar(100) DEFAULT NULL,
  `value10` varchar(100) DEFAULT NULL,
  `user_crea` varchar(50) DEFAULT NULL,
  `date_crea` date DEFAULT NULL,
  `user_updt` varchar(50) DEFAULT NULL,
  `date_updt` date DEFAULT NULL,
  PRIMARY KEY (`spec_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_staff`
--

CREATE TABLE IF NOT EXISTS `tbl_staff` (
  `staff_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `staff_name` varchar(60) NOT NULL,
  `staff_phone` varchar(20) DEFAULT NULL,
  `staff_email` varchar(100) DEFAULT NULL,
  `staff_gender` char(1) NOT NULL,
  `staff_address` text,
  `staff_photo` text,
  `staff_status` tinyint(4) NOT NULL,
  `staff_desc` text,
  `user_crea` varchar(60) NOT NULL,
  `date_crea` date NOT NULL,
  `user_updt` varchar(60) DEFAULT NULL,
  `date_updt` date DEFAULT NULL,
  PRIMARY KEY (`staff_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_staff`
--

INSERT INTO `tbl_staff` (`staff_id`, `staff_name`, `staff_phone`, `staff_email`, `staff_gender`, `staff_address`, `staff_photo`, `staff_status`, `staff_desc`, `user_crea`, `date_crea`, `user_updt`, `date_updt`) VALUES
(1, 'Chouemeng', '086830867', 'choumengit@gmail.com', 'm', 'PP', 'myAvatar Meng.png', 1, 'Hello world', 'admin', '2017-07-05', NULL, NULL),
(2, 'Boy', '086830867', 'Boy@gmail.com', 'm', 'PP', 'myAvatar Boy.png', 1, 'Hello boy', 'admin', '2017-07-23', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sysdata`
--

CREATE TABLE IF NOT EXISTS `tbl_sysdata` (
  `key_id` int(11) NOT NULL AUTO_INCREMENT,
  `key_type` varchar(100) NOT NULL,
  `key_code` varchar(100) NOT NULL,
  `key_data` varchar(100) NOT NULL,
  `key_data1` varchar(100) NOT NULL,
  `key_data2` varchar(100) NOT NULL,
  `key_desc` varchar(100) NOT NULL,
  `user_crea` varchar(30) NOT NULL,
  `date_crea` date NOT NULL,
  `user_updt` varchar(30) DEFAULT NULL,
  `date_updt` date DEFAULT NULL,
  PRIMARY KEY (`key_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

--
-- Dumping data for table `tbl_sysdata`
--

INSERT INTO `tbl_sysdata` (`key_id`, `key_type`, `key_code`, `key_data`, `key_data1`, `key_data2`, `key_desc`, `user_crea`, `date_crea`, `user_updt`, `date_updt`) VALUES
(35, 'exrate', '4000', '', '', '', 'Hello world', 'admin', '2017-07-04', 'admin', '2017-07-21');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE IF NOT EXISTS `tbl_user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_code` varchar(50) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_pass` varchar(100) NOT NULL,
  `user_type` varchar(50) NOT NULL,
  `user_status` tinyint(1) unsigned NOT NULL,
  `user_desc` text,
  `user_crea` varchar(50) NOT NULL,
  `date_crea` date NOT NULL,
  `user_updt` varchar(50) DEFAULT NULL,
  `date_updt` date DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_code` (`user_code`),
  UNIQUE KEY `user_code_2` (`user_code`),
  UNIQUE KEY `user_code_3` (`user_code`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`user_id`, `user_code`, `user_name`, `user_pass`, `user_type`, `user_status`, `user_desc`, `user_crea`, `date_crea`, `user_updt`, `date_updt`) VALUES
(4, 'usr:001', 'admin', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'Administrator', 1, '<p>This Account<br /><br /></p>', 'Choumeng', '2017-05-04', 'samnang', '2017-08-01'),
(8, 'usr:002', 'dara', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'Inputer', 1, 'asdfdsfadsfd', 'choumeng', '2017-06-22', 'samnang', '2017-08-01'),
(7, 'usr:003', 'choumeng', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'Administrator', 1, 'Hello world', 'admin', '2017-06-22', 'samnang', '2017-08-01'),
(9, 'usr:004', 'samnang', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'Inputer', 1, 'Hello wold', 'dara', '2017-06-22', 'samnang', '2017-08-01'),
(12, 'seller:001', 'seller', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'Seller', 1, 'welcome to seller', 'dara', '2017-08-01', NULL, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
