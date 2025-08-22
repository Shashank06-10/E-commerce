-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Aug 22, 2025 at 09:00 AM
-- Server version: 10.6.7-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerce_user`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `status` enum('pending','processing','shipped','delivered','cancelled') DEFAULT 'pending',
  `placed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total`, `status`, `placed_at`) VALUES
(19, 3, 5498.00, 'shipped', '2025-08-14 08:41:58'),
(20, 3, 3298.00, 'pending', '2025-08-14 08:42:18'),
(21, 3, 1499.00, 'pending', '2025-08-14 08:48:38'),
(22, 7, 3698.00, 'pending', '2025-08-17 11:50:54'),
(23, 3, 899.00, 'pending', '2025-08-17 13:58:06'),
(24, 3, 1798.00, 'pending', '2025-08-20 06:47:06'),
(25, 3, 1798.00, 'pending', '2025-08-20 20:52:40'),
(26, 9, 7797.00, 'pending', '2025-08-21 05:39:25');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(2, 19, 5, 1, 3999.00),
(3, 19, 4, 1, 1499.00),
(4, 20, 2, 1, 2499.00),
(5, 20, 1, 1, 799.00),
(6, 21, 4, 1, 1499.00),
(7, 22, 3, 1, 1199.00),
(8, 22, 2, 1, 2499.00),
(9, 23, 14, 1, 899.00),
(10, 24, 14, 2, 899.00),
(11, 25, 14, 2, 899.00),
(12, 26, 14, 2, 899.00),
(13, 26, 13, 1, 5999.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `stock`, `created_at`) VALUES
(1, 'Wireless Mouse', 'Ergonomic 2.4GHz wireless mouse', 799.00, 49, '2025-08-13 11:54:00'),
(2, 'Bluetooth Headphones', 'Over-ear noise-cancelling headphones', 2499.00, 25, '2025-08-13 11:54:00'),
(3, 'USB-C Charger', '65W fast charging adapter', 1199.00, 90, '2025-08-13 11:54:00'),
(4, 'Laptop Stand', 'Adjustable aluminum laptop stand', 1499.00, 32, '2025-08-13 11:54:00'),
(5, 'Smartwatch', 'Fitness tracker with heart rate sensor', 3999.00, 15, '2025-08-13 11:54:00'),
(6, 'Mechanical Keyboard', 'RGB backlit mechanical keyboard with blue switches', 2899.00, 35, '2025-08-17 15:24:00'),
(7, 'Portable SSD', '1TB USB 3.2 Gen2 solid state drive', 6499.00, 20, '2025-08-17 15:24:00'),
(8, 'Webcam HD', '1080p USB webcam with built-in microphone', 1799.00, 60, '2025-08-17 15:24:00'),
(9, 'Gaming Chair', 'Ergonomic gaming chair with lumbar support', 8999.00, 15, '2025-08-17 15:24:00'),
(10, 'Smart LED Bulb', 'Wi-Fi enabled RGB smart bulb compatible with Alexa', 499.00, 80, '2025-08-17 15:24:00'),
(11, 'Noise-Cancelling Earbuds', 'True wireless earbuds with ANC and touch controls', 3299.00, 45, '2025-08-17 15:24:00'),
(12, 'Wireless Keyboard', 'Slim wireless combo with long battery life', 1999.00, 70, '2025-08-17 15:24:00'),
(13, 'Action Camera', '4K waterproof action cam with wide-angle lens', 5999.00, 24, '2025-08-17 15:24:00'),
(14, 'Smart Plug', 'Remote-controlled smart plug with energy monitoring', 899.00, 83, '2025-08-17 15:24:00'),
(15, 'Mini Projector', 'Portable LED projector with HDMI and USB support', 7499.00, 18, '2025-08-17 15:24:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES
(2, 'shashank', 'sha@gmail.com', '$2y$10$9mL.8vjKErLovRDutY4RcOv5KCZW1fuZHza3SRvT9NHltO0ZJUcAm'),
(3, 'chintu', 'chintu@gmail.com', '$2y$10$nrB0Hg4hPfKjbxAeW65rces/WSFj5aMQau9nw/iok8yUdIgDJAkte'),
(4, 'soma', 'soma@gmail.com', '$2y$10$pacoNDti4Yj9VJQgH2cwB.y9Gzv1NtRI22dsutwqLyL96tBx.II.a'),
(7, 'Akshith', 'akshith@gmail.com', '$2y$10$1MIre5czZK9ZBVkQkl/epe0bIE0j/v7ouN4CYcicdksJXlV4nbiZe'),
(9, 'sravan', 'sravan@gmail.com', '$2y$10$U4Ml3epguLycVw3zPgh.2O876kw.m7nOVvpVTZ5WJOQrnAz8n/UA6');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
