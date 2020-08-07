-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 07, 2017 at 03:48 AM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `Jewelry` (
  `Jewelry_id` int(100) NOT NULL,
  `Jewelry_title` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `brands`
--

INSERT INTO `Jewelry` (`Jewelry_id`, `Jewelry_title`) VALUES
(1, 'PENDANT'),
(2, 'RING'),
(3, 'EARRING'),
(4, 'NECKLACE'),
(5, 'WATCH');


-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(10) NOT NULL,
  `p_id` int(10) NOT NULL,
  `ip_add` varchar(250) NOT NULL,
  `user_id` int(10) DEFAULT NULL,
  `qty` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Collection`
--

CREATE TABLE `Collection` (
  `Collection_id` int(100) NOT NULL,
  `Collection_title` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `Collection` (`Collection_id`, `Collection_title`) VALUES
(1, 'GOLD'),
(2, 'DIAMOND'),
(3, 'SILVER'),
(4, 'PLATINUM'),
(5, 'MENS');


-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `trx_id` varchar(255) NOT NULL,
  `p_status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `product_id`, `qty`, `trx_id`, `p_status`) VALUES
(1, 2, 7, 1, '07M47684BS5725041', 'Completed'),
(2, 2, 2, 1, '07M47684BS5725041', 'Completed');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(100) NOT NULL,
  `product_collection` int(100) NOT NULL,
  `product_jewelry` int(100) NOT NULL,
  `product_title` varchar(255) NOT NULL,
  `product_price` int(100) NOT NULL,
  `product_desc` text NOT NULL,
  `product_image` text NOT NULL,
  `product_keywords` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` ( `product_id`, `product_collection`, `product_jewelry`, `product_title`, `product_price`, `product_desc`, `product_image`, `product_keywords`) VALUES
(1, 1, 1, 'Golden Pendent', 3500, 'GP', 'g1.jpg', 'Golden Pendent india'),
(2, 1, 1, 'Golden Pendent 2', 2500, 'GP', 'g2.jpg', 'Golden Pendent italy'),
(3, 1, 2, 'Golden Ring', 1200, 'GR', 'g3.jpg', 'Golden ring singapore'),
(4, 1, 2, 'Golden Ring 2', 2400, 'GR', 'g4.jpg', 'Golden ring srilanka'),
(5, 1, 3, 'Golden Earring', 1500, 'GE', 'g5.jpg', 'Golden earring india'),
(6, 1, 3, 'Golden Earring 2', 1100, 'GE', 'g6.jpg', 'Golden earring italy'),
(7, 1, 4, 'Golden Necklace', 4500, 'GN', 'g7.jpg', 'Golden necklace singapore'),
(8, 1, 4, 'Golden Necklace 2', 5000, 'GN', 'g8.jpg', 'Golden necklace dubai'),
(9, 1, 5, 'Golden Watch', 3000, 'GW', 'g9.jpg', 'Golden watch india'),
(10, 1, 5, 'Golden Watch 2', 2500, 'GW', 'g10.jpg', 'Golden watch italy'),

(11, 2, 1, 'Diamond Pendent', 1100, 'DP', 'd1.jpg', 'diamond Pendent france'),
(12, 2, 1, 'Diamond Pendent 2', 1600, 'DP', 'd2.jpg', 'diamond Pendent italy'),
(13, 2, 2, 'Diamond Ring', 1300, 'DR', 'd3.jpg', 'diamond ring singapore'),
(14, 2, 2, 'Diamond Ring 2', 1200, 'DR', 'd4.jpg', 'diamond ring germany'),
(15, 2, 3, 'Diamond Earring', 1100, 'DE', 'd5.jpg', 'diamond earring india'),
(16, 2, 3, 'Diamond Earring 2', 4500, 'DE', 'd6.jpg', 'diamond earring italy'),
(17, 2, 4, 'Diamond Necklace', 4400, 'DN', 'd7.jpg', 'diamond necklace canada'),
(18, 2, 4, 'Diamond Necklace 2', 3400, 'DN', 'd8.jpg', 'diamond necklace bangalesh'),
(19, 2, 5, 'Diamond Watch', 1500, 'DW', 'd9.jpg', 'diamond watch dubai'),
(20, 2, 5, 'Diamond Watch 2', 3000, 'DW', 'd10.jpg', 'diamond watch italy'),

(21, 3, 1, 'Diamond Pendent', 1100, 'DP', 'p1.jpg', 'diamond Pendent france'),
(22, 3, 1, 'Diamond Pendent 2', 1600, 'DP', 'p2.jpg', 'diamond Pendent italy'),
(23, 3, 2, 'Diamond Ring', 1300, 'DR', 'p3.jpg', 'diamond ring singapore'),
(24, 3, 2, 'Diamond Ring 2', 1200, 'DR', 'p4.jpg', 'diamond ring germany'),
(25, 3, 3, 'Diamond Earring', 1100, 'DE', 'p5.jpg', 'diamond earring india'),
(26, 3, 3, 'Diamond Earring 2', 4500, 'DE', 'p6.jpg', 'diamond earring italy'),
(27, 3, 4, 'Diamond Necklace', 4400, 'DN', 'p7.jpg', 'diamond necklace canada'),
(28, 3, 4, 'Diamond Necklace 2', 3400, 'DN', 'p8.jpg', 'diamond necklace bangalesh'),
(29, 3, 5, 'Diamond Watch', 1500, 'DW', 'p9.jpg', 'diamond watch dubai'),
(30, 3, 5, 'Diamond Watch 2', 3000, 'DW', 'p10.jpg', 'diamond watch italy'),

(31, 4, 1, 'Diamond Pendent', 1100, 'DP', 's1.jpg', 'diamond Pendent france'),
(32, 4, 1, 'Diamond Pendent 2', 1600, 'DP', 's2.jpg', 'diamond Pendent italy'),
(33, 4, 2, 'Diamond Ring', 1300, 'DR', 's3.jpg', 'diamond ring singapore'),
(34, 4, 2, 'Diamond Ring 2', 1200, 'DR', 's4.jpg', 'diamond ring germany'),
(35, 4, 3, 'Diamond Earring', 1100, 'DE', 's5.jpg', 'diamond earring india'),
(36, 4, 3, 'Diamond Earring 2', 4500, 'DE', 's6.jpg', 'diamond earring italy'),
(37, 4, 4, 'Diamond Necklace', 4400, 'DN', 's7.jpg', 'diamond necklace canada'),
(38, 4, 4, 'Diamond Necklace 2', 3400, 'DN', 's8.jpg', 'diamond necklace bangalesh'),
(39, 4, 5, 'Diamond Watch', 1500, 'DW', 's9.jpg', 'diamond watch dubai'),
(40, 4, 5, 'Diamond Watch 2', 3000, 'DW', 's10.jpg', 'diamond watch italy'),

(41, 5, 1, 'Diamond Pendent', 1100, 'DP', 'm1.jpg', 'diamond Pendent france'),
(42, 5, 1, 'Diamond Pendent 2', 1600, 'DP', 'm2.jpg', 'diamond Pendent italy'),
(43, 5, 2, 'Diamond Ring', 1300, 'DR', 'm3.jpg', 'diamond ring singapore'),
(44, 5, 2, 'Diamond Ring 2', 1200, 'DR', 'm4.jpg', 'diamond ring germany'),
(45, 5, 3, 'Diamond Earring', 1100, 'DE', 'm5.jpg', 'diamond earring india'),
(46, 5, 3, 'Diamond Earring 2', 4500, 'DE', 'm6.jpg', 'diamond earring italy'),
(47, 5, 4, 'Diamond Necklace', 4400, 'DN', 'm7.jpg', 'diamond necklace canada'),
(48, 5, 4, 'Diamond Necklace 2', 3400, 'DN', 'm8.jpg', 'diamond necklace bangalesh'),
(49, 5, 5, 'Diamond Watch', 1500, 'DW', 'm9.jpg', 'diamond watch dubai'),
(50, 5, 5, 'Diamond Watch 2', 3000, 'DW', 'm10.jpg', 'diamond watch italy');


-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE `user_info` (
  `user_id` int(10) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(300) NOT NULL,
  `password` varchar(300) NOT NULL,
  `mobile` varchar(10) NOT NULL,
  `address1` varchar(300) NOT NULL,
  `address2` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`user_id`, `first_name`, `last_name`, `email`, `password`, `mobile`, `address1`, `address2`) VALUES
(1, 'bruce', 'wayne', 'dark.knight34@gmail.com', '25f9e794323b453885f5181f1b624d0b', '9432080183', 'Green Park City Lane', 'gotham'),
(2, 'bruce', 'wayne', 'dark.knight34@gmail.com', '25f9e794323b453885f5181f1b624d0b', '9432080183', 'Green Park City Lane', 'sydney');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `Jewelry`
  ADD PRIMARY KEY (`Jewelry_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `Collection`
  ADD PRIMARY KEY (`Collection_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `Jewelry`
  MODIFY `Jewelry_id` int(100) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `Collection`
  MODIFY `Collection_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(100) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user_info`
--
ALTER TABLE `user_info`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
