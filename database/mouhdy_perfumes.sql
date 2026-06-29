-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 29, 2026 at 09:28 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mouhdy_perfumes`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2026-05-21 10:51:16'),
(2, 'kasansa', '12345', '2026-05-21 11:04:41');

-- --------------------------------------------------------

--
-- Table structure for table `blog_posts`
--

CREATE TABLE `blog_posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `author` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog_posts`
--

INSERT INTO `blog_posts` (`id`, `title`, `content`, `category`, `author`, `created_at`) VALUES
(1, 'Best Arabic Oud Perfumes in 2026', 'Discover the top Arabic fragrances that are trending this year...', 'Arabic Perfumes', NULL, '2026-05-21 16:25:19'),
(2, 'How to Make Your Perfume Last Longer', 'Tips and tricks to increase the longevity of your favorite scents...', 'Tips & Guides', NULL, '2026-05-21 16:25:19');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`) VALUES
(1, 'Arabic Oud', 'arabic-oud'),
(2, 'Men', 'men'),
(3, 'Women', 'women'),
(4, 'Luxury', 'luxury');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `customer_id`, `title`, `message`, `created_at`) VALUES
(1, 1, 'kubali', 'Hatar', '2026-06-03 17:54:57');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `status` enum('pending','paid','shipped','delivered') DEFAULT 'pending',
  `created_at` datetime DEFAULT current_timestamp(),
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `customer_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total`, `status`, `created_at`, `phone`, `address`, `customer_name`) VALUES
(1, NULL, 100000.00, 'delivered', '2026-05-22 17:19:46', '0717232586', 'ilala bungoni dar es salaam', 'david kasansa'),
(2, NULL, 185000.00, 'delivered', '2026-05-22 17:26:20', '0717232586', 'kidatu', 'kitupi'),
(3, NULL, 185000.00, 'delivered', '2026-05-22 18:10:36', '0717232586', 'leo leo leo kazi ipo', 'david kasansa'),
(4, NULL, 555000.00, 'shipped', '2026-05-22 18:35:08', '0717232586', 'kijo', 'babu'),
(5, NULL, 40000.00, 'shipped', '2026-05-22 18:43:58', '0765242424', 'tabata', 'danny'),
(6, NULL, 10000.00, 'shipped', '2026-06-03 18:59:42', '0717232586', 'kidatu', 'david kasansa'),
(7, NULL, 2260000.00, 'delivered', '2026-06-03 20:02:46', '0717232586', 'musoma', 'kilwa kivinje'),
(8, NULL, 100000.00, 'delivered', '2026-06-03 20:11:54', '0717232586', 'kigoma', 'kitupi');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 1, 3, 1, 0.00),
(2, 2, 1, 1, NULL),
(3, 3, 1, 1, NULL),
(4, 4, 1, 3, NULL),
(5, 5, 5, 4, NULL),
(6, 6, 5, 1, NULL),
(7, 7, 2, 1, NULL),
(8, 7, 1, 9, NULL),
(9, 7, 3, 5, NULL),
(10, 8, 3, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(150) NOT NULL,
  `slug` varchar(150) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `sale_price` decimal(10,2) DEFAULT NULL,
  `image` varchar(255) DEFAULT 'placeholder.jpg',
  `description` text DEFAULT NULL,
  `top_notes` text DEFAULT NULL,
  `middle_notes` text DEFAULT NULL,
  `base_notes` text DEFAULT NULL,
  `longevity` varchar(50) DEFAULT NULL,
  `gender` enum('Men','Women','Unisex') DEFAULT 'Unisex',
  `stock` int(11) DEFAULT 50,
  `featured` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `slug`, `price`, `sale_price`, `image`, `description`, `top_notes`, `middle_notes`, `base_notes`, `longevity`, `gender`, `stock`, `featured`, `created_at`) VALUES
(1, 1, 'Royal Oud Majesty', NULL, 185000.00, 165000.00, '1779367955.jpg', 'Signature Arabic Oud blend...', 'Bergamot, Saffron', 'Rose, Jasmine', 'Oud, Amber, Musk', '12+ hours', 'Unisex', 50, 1, '2026-05-21 10:51:16'),
(2, 2, 'Desert Warrior', NULL, 95000.00, NULL, '1779352683.jpg', 'Powerful woody fragrance...', 'Citrus, Lavender', 'Cedar, Vetiver', 'Sandalwood, Patchouli', '8-10 hours', 'Men', 50, 1, '2026-05-21 10:51:16'),
(3, NULL, 'Chapo', NULL, 100000.00, NULL, '1779458098.jpg', 'njoo na hela mkononi', 'lemon', 'udi', 'marashi', '8-10 hours', 'Women', 50, 0, '2026-05-22 16:54:58'),
(4, NULL, 'Kitikta utobe', NULL, 5000.00, NULL, '1779458417.jpg', 'tanua duara', 'Citrus, Lavender', 'Rose, Jasmine', 'Oud, Amber, Musk', '12+ hours', 'Unisex', 50, 0, '2026-05-22 17:00:17'),
(5, NULL, 'kila kiliwa', NULL, 10000.00, NULL, '1779464477.jpg', 'yyfkqyfs', 'Citrus, Lavender', 'Rose, Jasmine', 'Oud, Amber, Musk', '8-10 hours', 'Unisex', 50, 0, '2026-05-22 18:41:17'),
(6, NULL, 'david martn', NULL, 99999999.99, NULL, '1780567642.JPG', 'anauzwa', 'kilo 55', 'urefu 135 cm', 'unene 50 cm', 'miaka 23', 'Men', 50, 0, '2026-06-04 13:07:22');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `product_id`, `user_id`, `name`, `rating`, `comment`, `created_at`) VALUES
(1, 5, NULL, 'david kasansa', 5, 'this is good', '2026-06-03 18:59:14'),
(2, 6, NULL, 'david kasansa', 5, 'huyu hata bure sichukui', '2026-06-04 13:08:25');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `updated_at`) VALUES
(1, 'whatsapp_number', '255784947198', '2026-06-03 21:01:41'),
(2, 'store_email', 'allydav1703@gmaiil.com', '2026-06-03 21:01:41'),
(3, 'store_phone', '+255 784 947 198', '2026-06-03 21:01:41'),
(4, 'store_address', 'Ilala Bungoni, Dar es Salaam, Tanzania', '2026-05-21 15:55:03'),
(5, 'store_name', 'Mouhdy Perfumes Store', '2026-05-21 15:55:03'),
(6, 'slogan', 'Beautiful Mind Smell Good', '2026-05-21 15:55:03');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `address`, `created_at`) VALUES
(1, 'david kasansa', 'kasansadavid94@gmail.com', '$2y$10$hvzpevi.tpmrjnNtxeR9jukD0DqA2TQwBdjf//ccUy5oI5P6CMHPa', '0717232586', NULL, '2026-05-21 16:28:40'),
(2, 'kilwa kivinje', 'D~t@gmail.com', '$2y$10$nk7flHxIIfE.fcgRN/NvZuwfMjIUbryUVBzf4vw8hvenrk7zVOsM2', '0717232586', NULL, '2026-06-03 19:29:56');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`id`, `user_id`, `product_id`, `created_at`) VALUES
(1, 1, 4, '2026-05-22 17:56:05'),
(3, 2, 1, '2026-06-03 19:30:34'),
(4, 2, 2, '2026-06-03 19:30:45');

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
-- Indexes for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_wishlist` (`user_id`,`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
