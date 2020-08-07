-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 28, 2018 at 10:55 AM
-- Server version: 10.1.35-MariaDB
-- PHP Version: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jwellerystore`
--

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `token` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`id`, `email`, `token`) VALUES
(0, 'kgeorgesilva97@gmail.com', '00f444d74f620585aeb2166fec2cfec91f6efa169166db63a7e76a8840148c69ed67db48631ebdf96ef695e0878557fb5a70'),
(0, 'kgeorgesilva97@gmail.com', '109d5fad999ba0aeed38dea311d758114883759cc985b6be519c37b14e572bee0481807650054ad187ab5d2307be2bf5c23e'),
(0, 'kgeorgesilva97@gmail.com', '276cf73ffeb08045aa605558c1b54672da2135899ed8007fe75e0936237e41f9151efe9034d92ad501fd67dfc23974f6cb70'),
(0, 'kgeorgesilva97@gmail.com', '3dabb1c89a363f5893a38421d95e387f26b3ec8779853c10ee025ecf6789ae7637baf9ddfd1efdf1e406d6966b5566b53732'),
(0, 'kgeorgesilva97@gmail.com', '415f84308b4f8d12d0e4054f9da0b46d031daa00b2764779929b9a92b210be44bc93bb9c9817cdc85a517338ba6b2c30ed85'),
(0, 'kgeorgesilva97@gmail.com', '46960ae4543d3ccb36ebe05d1779c2c8a6996beec1d0943e3b3454214f24295dc0e2183ab2f95205c780ea6398e1756a82a3'),
(0, 'kgeorgesilva97@gmail.com', '49ec3104cc1e158e320974a97e8e029daa4e947e227deed065dc2c55545a91168e2101cfee399d29c77cde60bd18df479dce'),
(0, 'kgeorgesilva97@gmail.com', '61f82970bb8522f56d43fc9d30f0032d318fd52b24adab2374a565f82ca81a1ee127c2bf8b4d3ff3015a68481f72cbec2655'),
(0, 'kgeorgesilva97@gmail.com', '694617d05e1f7f91bece706c4f5899d430ab542f22b24cd22ef9e654ab0b28a1876d89f752bdb330d8abcba37fb36d5f57f1'),
(0, 'kgeorgesilva97@gmail.com', 'aab11b3339d6564388296a8ffdcd96f15825af16dd290211422c96eb672f42fcf9e0fef7a3573ab34ecafa4f28c4d70946f8'),
(0, 'kgeorgesilva97@gmail.com', 'd5ba6f73230936607413a502cb5f3b7cf9ef796861b082bafb229f7a5a19bc9ab503c7e3b3a5cb62f12b4796616f9c72a5a8'),
(0, 'kgeorgesilva97@gmail.com', 'dd2c9bc30b0b3651d32a6eb7b371daea1067ecb5aa6c169d9957696dc79dd06499332ea66a1ab3ce4584f6d9e992d28e85b7'),
(0, 'kgeorgesilva97@gmail.com', 'ee3b8a1aaa9b233b586bb70df0f4a1cd33f20d763b8983a144a48d40a07f9511bd21c7e5debdd12ea047b8afc89c26c1be48'),
(0, 'kgeorgesilva97@gmail.com', 'f77593a8ed1a06d971358ab289d22bbe693bfd60fb67b9db3f2ec2cf8617e3ceba87ca7877ce21e1f5ae7347f09643a1cda7');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`) VALUES
(1, 'Admin', 'Has authority of users and roles and permissions.'),
(2, 'Author', 'Has full authority of own posts'),
(3, 'Editor', 'Has full authority over all posts');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `fname`, `lname`, `username`, `email`, `address`, `password`, `profile_picture`, `created_at`, `updated_at`) VALUES
(2, NULL, '', '', 'geo', 'kgeorgesilva97@gmail.com', '', '$2y$10$LoCOsuqWNwNEJjUodyuiCuqTDCYfowCm5w9nuH8j3jegty57dqxU.', NULL, '2018-09-16 00:41:09', '0000-00-00 00:00:00'),
(3, 1, 'george', 'silva', 'George', '123@gmail.com4', 'D 31,Old Galaha Road,Peradeniya', '$2y$10$U.2/MNK2YxkNGFWWMWWBMO7ZPLVN5y5BkaeHbyiGCnxHyjNO3/11.', NULL, '2018-09-20 14:49:13', '0000-00-00 00:00:00'),
(4, NULL, '', '', 'ush', 'ush@gmail.com', '', '$2y$10$OxlS9gsO3i6p95V.XFYfOOmL8R5X6Q56BiVk2Q7mDURAT5f66qmFm', NULL, '2018-09-16 07:55:01', '0000-00-00 00:00:00'),
(5, 1, '', '', 'gehan', 'gehan@gmail.com', '', '$2y$10$7lEfTx6HeQL3Xz9CUDqa4.eVrGkE49O3uNtSl4Ua2wjgC9.gqREQu', NULL, '2018-09-16 16:03:28', '0000-00-00 00:00:00'),
(6, NULL, 'geo', 'silva', 'ush123', '123@gmail.com', 'D 31,Old Galaha Road,Peradeniya', '$2y$10$JU6qDi0bdnkMtlgREstR7Odp5KAvYdYVD2WlSNHp2OonWqrEwBvOm', '2018.09.20Funny-Star-Wars-HD-Wallpaper-2560x1600.jpg', '2018-09-20 11:22:49', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `user_reg`
--

CREATE TABLE `user_reg` (
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telephone` varchar(10) NOT NULL,
  `address` varchar(100) NOT NULL,
  `postcode` int(11) NOT NULL,
  `country` varchar(10) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_reg`
--

INSERT INTO `user_reg` (`firstname`, `lastname`, `email`, `telephone`, `address`, `postcode`, `country`, `password`) VALUES
('geo', 'silva', 'fefe', '7799756', 'old galaha', 2040, 'usa', '81dc9bdb52d04dc20036dbd8313ed055'),
('geo', 'silva', 'kgeorgesilva97@gmail.com', '7799756', 'old galaha', 2040, 'usa', '81dc9bdb52d04dc20036dbd8313ed055');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD UNIQUE KEY `token` (`token`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `permission_id` (`permission_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `users_ibfk_1` (`role_id`);

--
-- Indexes for table `user_reg`
--
ALTER TABLE `user_reg`
  ADD PRIMARY KEY (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permission_role`
--
ALTER TABLE `permission_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `permission_role_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
