-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 19, 2024 at 02:42 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cocoa`
--

-- --------------------------------------------------------

--
-- Table structure for table `acheteur_collaborations`
--

CREATE TABLE `acheteur_collaborations` (
  `id` int(11) NOT NULL,
  `acheteur_id` int(11) DEFAULT NULL,
  `corporation_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `location` varchar(255) NOT NULL,
  `descriptionland` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `location`, `descriptionland`, `image`, `user_id`) VALUES
(6, 'tongolo', 'ferny', '../uploads/Screenshot 2023-12-16 095316.png', 13),
(7, 'Awae', 'ARIEL', '../uploads/20221106_112237.jpg', 13);

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `idcity` int(11) NOT NULL,
  `idregion` int(11) NOT NULL,
  `namcity` varchar(254) NOT NULL DEFAULT '0',
  `statuscity` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`idcity`, `idregion`, `namcity`, `statuscity`) VALUES
(1, 2, 'Yola', 2),
(2, 2, 'Yola', 2),
(3, 2, 'Yola', 2),
(4, 2, 'Yola', 2),
(5, 2, 'Yola', 2),
(6, 2, 'Yola', 0),
(7, 2, 'Yola', 0),
(8, 2, 'Yola', 0),
(9, 2, 'Yola', 0),
(10, 2, 'Yola', 2),
(11, 2, 'Yola', 2);

-- --------------------------------------------------------

--
-- Table structure for table `corporations`
--

CREATE TABLE `corporations` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `idcity` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `corporations`
--

INSERT INTO `corporations` (`id`, `name`, `address`, `idcity`, `created_at`, `updated_at`) VALUES
(2, 'B200r12', '12', 1, '2024-09-17 22:03:42', '2024-09-17 22:03:42'),
(3, 'ferny', 'lonfi', 4, '2024-09-18 03:24:42', '2024-09-18 03:24:42'),
(4, 'ARIEL', 'jhnhjdj', 1, '2024-09-19 00:23:04', '2024-09-19 00:23:04');

-- --------------------------------------------------------

--
-- Table structure for table `corporation_delegates`
--

CREATE TABLE `corporation_delegates` (
  `id` int(11) NOT NULL,
  `corporation_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `corporation_delegates`
--

INSERT INTO `corporation_delegates` (`id`, `corporation_id`, `user_id`, `created_at`) VALUES
(2, 2, 8, '2024-09-17 22:03:42'),
(3, 3, 14, '2024-09-18 03:24:42'),
(4, 4, 19, '2024-09-19 00:23:04');

-- --------------------------------------------------------

--
-- Table structure for table `corporation_members`
--

CREATE TABLE `corporation_members` (
  `id` int(11) NOT NULL,
  `corporation_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `corporation_members`
--

INSERT INTO `corporation_members` (`id`, `corporation_id`, `user_id`, `created_at`) VALUES
(1, 3, 17, '2024-09-18 03:40:53');

-- --------------------------------------------------------

--
-- Table structure for table `formateur_resources`
--

CREATE TABLE `formateur_resources` (
  `id` int(11) NOT NULL,
  `formateur_id` int(11) DEFAULT NULL,
  `resource_type` enum('file','folder','video') NOT NULL,
  `resource_path` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `recipient_id` int(11) NOT NULL,
  `stock_id` int(11) DEFAULT NULL,
  `reservation_info` text DEFAULT NULL,
  `message` text NOT NULL,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_read` tinyint(1) DEFAULT 0,
  `video_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `recipient_id`, `stock_id`, `reservation_info`, `message`, `sent_at`, `is_read`, `video_path`) VALUES
(2, 1, 8, NULL, NULL, 'bbb', '2024-09-17 22:22:18', 0, NULL),
(3, 1, 7, NULL, NULL, 'vcerv', '2024-09-17 22:22:28', 0, NULL),
(4, 6, 7, NULL, NULL, 'vcerv', '2024-09-17 22:33:50', 0, NULL),
(5, 6, 9, NULL, NULL, 'bin', '2024-09-17 22:34:07', 0, NULL),
(6, 6, 9, NULL, NULL, 'bin', '2024-09-17 22:34:12', 0, NULL),
(7, 6, 9, NULL, NULL, 'bin', '2024-09-17 22:34:16', 0, NULL),
(8, 6, 9, NULL, NULL, 'bin', '2024-09-17 22:35:17', 0, NULL),
(9, 6, 8, NULL, NULL, 'bonjour', '2024-09-17 22:35:45', 0, NULL),
(10, 6, 8, NULL, NULL, 'bonjour', '2024-09-17 22:35:49', 0, NULL),
(11, 18, 8, NULL, NULL, '', '2024-09-18 16:01:02', 0, NULL),
(12, 18, 8, NULL, NULL, '', '2024-09-18 16:01:05', 0, NULL),
(13, 18, 8, NULL, NULL, '', '2024-09-18 16:09:58', 0, NULL),
(14, 0, 0, NULL, NULL, 'jjj', '2024-09-18 16:33:00', 0, NULL),
(15, 0, 0, NULL, NULL, 'jjj', '2024-09-18 16:37:10', 0, NULL),
(16, 0, 0, NULL, NULL, 'lnerubisdl cpwe;f wiycgiwe', '2024-09-18 16:37:43', 0, NULL),
(17, 13, 3, NULL, NULL, 'A stock has been reserved by SE3 (momo@gmail.com, 671343867). Please prepare the stock for delivery.', '2024-09-18 19:13:19', 0, NULL),
(18, 13, 0, NULL, NULL, 'A stock has been reserved by SE3 (momo@gmail.com, 671343867). Please prepare the stock for delivery.', '2024-09-18 19:13:19', 0, NULL),
(19, 0, 0, NULL, NULL, 'sdvf', '2024-09-18 19:22:23', 0, NULL),
(20, 0, 0, NULL, NULL, 'I am interested in your stock with the description: ferny', '2024-09-18 19:23:44', 0, NULL),
(21, 0, 0, NULL, NULL, 'I am interested in your stock with the description: ferny', '2024-09-18 19:23:46', 0, NULL),
(22, 0, 0, NULL, NULL, 'I am interested in your stock with the description: ferny', '2024-09-18 19:23:48', 0, NULL),
(23, 0, 0, NULL, NULL, 'I am interested in your stock with the description: ferny', '2024-09-18 19:23:48', 0, NULL),
(24, 0, 0, NULL, NULL, 'I am interested in your stock with the description: ferny', '2024-09-18 19:23:48', 0, NULL),
(25, 0, 0, NULL, NULL, 'I am interested in your stock with the description: ferny', '2024-09-18 19:23:48', 0, NULL),
(26, 0, 0, NULL, NULL, 'I am interested in your stock with the description: ferny', '2024-09-18 19:23:48', 0, NULL),
(27, 0, 0, NULL, NULL, 'I am interested in your stock with the description: ferny', '2024-09-18 19:23:48', 0, NULL),
(28, 0, 0, NULL, NULL, 'I am interested in your stock with the description: ferny', '2024-09-18 19:23:48', 0, NULL),
(29, 0, 0, NULL, NULL, 'I am interested in your stock with the description: ferny', '2024-09-18 19:23:48', 0, NULL),
(30, 0, 0, NULL, NULL, 'I am interested in your stock with the description: ferny', '2024-09-18 19:23:49', 0, NULL),
(31, 0, 0, NULL, NULL, ',', '2024-09-18 19:24:42', 0, NULL),
(32, 13, 0, NULL, NULL, 'A stock has been reserved by akh (nana@gmail.com, 671343867). Please prepare the stock for delivery.', '2024-09-18 19:26:35', 0, NULL),
(33, 6, 21, NULL, NULL, '', '2024-09-19 00:23:50', 0, NULL),
(34, 0, 0, NULL, NULL, 'I am interested in your stock with the description: ferny', '2024-09-19 00:30:03', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `region`
--

CREATE TABLE `region` (
  `idregion` int(11) NOT NULL,
  `nameregion` varchar(254) NOT NULL,
  `statusregion` tinyint(1) DEFAULT 1,
  `dateregion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `region`
--

INSERT INTO `region` (`idregion`, `nameregion`, `statusregion`, `dateregion`) VALUES
(1, 'Center', 2, '2024-09-17 19:45:27'),
(2, 'Centre', 0, '2024-09-17 19:58:34'),
(3, 'East', 0, '2024-09-17 19:59:36'),
(4, 'Littoral', 0, '2024-09-17 19:42:33'),
(5, 'Nord', 0, '2024-09-17 19:59:54'),
(6, 'Adamawa', 2, '2024-09-19 00:14:27'),
(7, 'Adamawa', 2, '2024-09-19 00:14:23');

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `id` int(11) NOT NULL,
  `corporation_id` int(11) DEFAULT NULL,
  `picture` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `location` varchar(255) NOT NULL,
  `status` enum('available','reserved') DEFAULT 'available',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`id`, `corporation_id`, `picture`, `quantity`, `unit_price`, `total_price`, `location`, `status`, `created_at`, `updated_at`) VALUES
(1, 3, '../uploads/Screenshot 2023-12-12 144358.png', 5000000, '700.00', '0.00', 'hihiye', 'reserved', '2024-09-18 04:09:43', '2024-09-18 19:13:19'),
(2, 3, '../uploads/Screenshot 2023-12-16 095316.png', 75069, '800.00', '0.00', 'tongolo', 'available', '2024-09-18 04:10:19', '2024-09-18 04:10:19'),
(3, 4, '../uploads/20221106_112237.jpg', 150000, '5000.00', '0.00', 'Awae', 'available', '2024-09-19 00:27:25', '2024-09-19 00:27:25');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `acheteur_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phonenumber` varchar(20) NOT NULL,
  `city` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `transaction_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `acheteur_id`, `name`, `email`, `phonenumber`, `city`, `country`, `total_price`, `transaction_date`) VALUES
(3, 13, 'SE3', 'momo@gmail.com', '671343867', 'YAOUNDE', 'Cameroun', '0.00', '2024-09-18 19:13:19'),
(4, 13, 'SE3', 'momo@gmail.com', '671343867', 'YAOUNDE', 'Cameroun', '0.00', '2024-09-18 19:17:30'),
(5, 13, 'SE3', 'momo@gmail.com', '671343867', 'YAOUNDE', 'Cameroun', '0.00', '2024-09-18 19:19:25'),
(6, 13, 'SR3A', 'momo@gmail.com', '671343867', 'YAOUNDE', 'Cameroun', '0.00', '2024-09-18 19:20:25'),
(7, 13, 'akh', 'nana@gmail.com', '671343867', 'YAOUNDE', 'Cameroun', '0.00', '2024-09-18 19:26:35'),
(8, 13, 'vijnk', 'cheussopkeng@yahoo.com', '671343867', 'YAOUNDE', 'Cameroun', '0.00', '2024-09-18 19:27:18'),
(9, 13, 'bib', 'pa@gmail.com', '671343867', 'YAOUNDE', 'Cameroun', '0.00', '2024-09-18 19:28:03'),
(10, 13, 'toti', 'cheussopkeng@yahoo.com', '671343867', 'YAOUNDE', 'Cameroun', '0.00', '2024-09-19 00:33:54'),
(11, 13, 'fen', 'fen@gmail.com', '671859632', 'lody', 'Cameroun', '0.00', '2024-09-19 00:36:08'),
(12, 13, 'fen', 'fen@gmail.com', '671859632', 'lody', 'Cameroun', '0.00', '2024-09-19 00:36:14');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role` enum('acheteur','formateur','delegue_corp','membre_corp','admin') NOT NULL,
  `name` varchar(100) NOT NULL,
  `photo` varchar(255) NOT NULL DEFAULT '0',
  `phone` varchar(15) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `idregion` int(11) NOT NULL,
  `idcity` int(11) NOT NULL,
  `permission_card` varchar(255) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role`, `name`, `photo`, `phone`, `email`, `password`, `address`, `idregion`, `idcity`, `permission_card`, `created_at`, `updated_at`) VALUES
(5, 'admin', 'momo', 'uploads/Untitled-1.png', '671343867', 'momo@gmail.com', '3c331613a26f366446dd2bb9297a8b4104e340d5', NULL, 2, 9, '0', '2024-09-17 21:03:44', '2024-09-17 21:03:44'),
(6, 'admin', 'nana', 'uploads/IMG-20240326-WA0012.jpg', '671343867', 'mana@gmail.com', '$2y$10$nA5dq2GcxJR4CV.9MGlwkes21HjL6XfYpzBWKM.feFLHNBktBfuYu', NULL, 2, 6, '0', '2024-09-17 21:23:59', '2024-09-17 21:23:59'),
(7, 'formateur', 'SE3', 'uploads/20240524_112828.jpg', '671343867', 'momoian@gmail.com', '$2y$10$DxxzsTDMlE5pEgdelnwTheOMWK9bPeOJAc74RlWwFgclNqNgiS2u6', NULL, 4, 8, '0', '2024-09-17 21:43:46', '2024-09-17 21:43:46'),
(8, 'delegue_corp', 'SR3A', 'uploads/IMG-20240326-WA0012.jpg', '671343867', 'zinga@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', NULL, 3, 7, '0', '2024-09-17 21:44:40', '2024-09-17 22:03:42'),
(10, 'acheteur', 'pao', 'uploads/20240524_114928.jpg', '671343867', 'pao@gmail.com', '$2y$10$bvXj0rTaDHTFbK2kcPK/qukQXMy1RyQWsJFUOrTxsUhGPsYznHJwS', NULL, 3, 7, '', '2024-09-17 22:37:48', '2024-09-17 22:37:48'),
(13, 'acheteur', 'GL3', 'uploads/Untitled-1.png', '671343867', 'pa@gmail.com', '$2y$10$ZxRXs1inhgv5z.WhezUoce9mqu/hwv0ZdNn1fjSUZ9Ydv1CgSvuhu', NULL, 2, 9, '', '2024-09-17 22:42:03', '2024-09-17 22:42:03'),
(14, 'delegue_corp', 'aaa', 'uploads/IMG-20240326-WA0012.jpg', '671343867', 'aaa@gmail.com', '$2y$10$hpkaVmGOIZX4CDY.zXBS0OAP/voU8oDbw.khfS0nvSYEtYquA6SNO', NULL, 2, 8, '0', '2024-09-17 22:46:12', '2024-09-18 03:24:42'),
(15, 'membre_corp', 'abc', 'uploads/20240524_112828.jpg', '671343867', 'abc@gmail.com', '$2y$10$dTsjtWv6HY7iTJESEKPuieWWzi5u8Peo4Iw12aR6ZrgXeMLtTiDKq', NULL, 4, 8, '0', '2024-09-17 22:47:23', '2024-09-17 22:47:23'),
(17, 'membre_corp', 'fendy', '1726630853_Screenshot 2023-12-12 144358.png', '3333535541', 'fendy@gmail.com', '0', NULL, 4, 7, '0', '2024-09-18 03:40:53', '2024-09-18 03:40:53'),
(18, 'formateur', 'esly', 'uploads/Screenshot 2023-12-16 095914.png', '6554268925', 'esly@gmail.com', '$2y$10$l/1yJLBzItYXBaY82OOZ4O0sm6A/Q3x9mOXaI/jzED7xk0jcXXGTy', NULL, 3, 6, '0', '2024-09-18 15:35:15', '2024-09-18 15:35:15'),
(19, 'delegue_corp', 'ariel', 'uploads/maxresdefault.jpg', '671343867', 'ariel@gmail.com', '$2y$10$fCo1U633rAJjbP3S20sW9.6MykBOoId22yN0P5vzY2boKxYhHxDVe', NULL, 2, 7, '0', '2024-09-19 00:16:56', '2024-09-19 00:23:04'),
(21, 'membre_corp', 'ariel', 'uploads/Screenshot 2023-12-16 120936.png', '662522151681', 'al@gmail.com', '$2y$10$qm.A.geUbJMpr.d5.CqI/uUMb.Wgtx8K5KuF8.0dX9lacWNmOmf4W', NULL, 5, 8, '0', '2024-09-19 00:20:55', '2024-09-19 00:20:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `acheteur_collaborations`
--
ALTER TABLE `acheteur_collaborations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `acheteur_id` (`acheteur_id`),
  ADD KEY `corporation_id` (`corporation_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`idcity`);

--
-- Indexes for table `corporations`
--
ALTER TABLE `corporations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `corporation_delegates`
--
ALTER TABLE `corporation_delegates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `corporation_id` (`corporation_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `corporation_members`
--
ALTER TABLE `corporation_members`
  ADD PRIMARY KEY (`id`),
  ADD KEY `corporation_id` (`corporation_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `formateur_resources`
--
ALTER TABLE `formateur_resources`
  ADD PRIMARY KEY (`id`),
  ADD KEY `formateur_id` (`formateur_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_stock` (`stock_id`);

--
-- Indexes for table `region`
--
ALTER TABLE `region`
  ADD PRIMARY KEY (`idregion`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `corporation_id` (`corporation_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `acheteur_id` (`acheteur_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `acheteur_collaborations`
--
ALTER TABLE `acheteur_collaborations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `city`
--
ALTER TABLE `city`
  MODIFY `idcity` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `corporations`
--
ALTER TABLE `corporations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `corporation_delegates`
--
ALTER TABLE `corporation_delegates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `corporation_members`
--
ALTER TABLE `corporation_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `formateur_resources`
--
ALTER TABLE `formateur_resources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `region`
--
ALTER TABLE `region`
  MODIFY `idregion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `acheteur_collaborations`
--
ALTER TABLE `acheteur_collaborations`
  ADD CONSTRAINT `acheteur_collaborations_ibfk_1` FOREIGN KEY (`acheteur_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `acheteur_collaborations_ibfk_2` FOREIGN KEY (`corporation_id`) REFERENCES `corporations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `corporation_delegates`
--
ALTER TABLE `corporation_delegates`
  ADD CONSTRAINT `corporation_delegates_ibfk_1` FOREIGN KEY (`corporation_id`) REFERENCES `corporations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `corporation_delegates_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `corporation_members`
--
ALTER TABLE `corporation_members`
  ADD CONSTRAINT `corporation_members_ibfk_1` FOREIGN KEY (`corporation_id`) REFERENCES `corporations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `corporation_members_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `formateur_resources`
--
ALTER TABLE `formateur_resources`
  ADD CONSTRAINT `formateur_resources_ibfk_1` FOREIGN KEY (`formateur_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `fk_stock` FOREIGN KEY (`stock_id`) REFERENCES `stocks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stocks`
--
ALTER TABLE `stocks`
  ADD CONSTRAINT `stocks_ibfk_1` FOREIGN KEY (`corporation_id`) REFERENCES `corporations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`acheteur_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
