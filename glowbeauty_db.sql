-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 04, 2026 at 11:18 PM
-- Server version: 10.4.32-MariaDB-log
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `glowbeauty_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `beauty_orders`
--

CREATE TABLE `beauty_orders` (
  `order_id` int(11) NOT NULL,
  `invoice_number` varchar(30) NOT NULL,
  `member_id` int(11) NOT NULL,
  `sales_id` int(11) NOT NULL,
  `order_date` date NOT NULL,
  `order_status` enum('Pending','Processed','Shipped','Completed','Cancelled') DEFAULT 'Pending',
  `grand_total` decimal(12,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `beauty_orders`
--

INSERT INTO `beauty_orders` (`order_id`, `invoice_number`, `member_id`, `sales_id`, `order_date`, `order_status`, `grand_total`, `created_at`) VALUES
(1, 'INV-GB-001', 1, 2, '2026-06-05', 'Processed', 700000.00, '2026-06-04 23:11:38');

-- --------------------------------------------------------

--
-- Table structure for table `beauty_order_items`
--

CREATE TABLE `beauty_order_items` (
  `item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(12,2) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `beauty_order_items`
--

INSERT INTO `beauty_order_items` (`item_id`, `order_id`, `product_id`, `quantity`, `unit_price`, `subtotal`) VALUES
(1, 1, 1, 2, 350000.00, 700000.00);

-- --------------------------------------------------------

--
-- Table structure for table `beauty_products`
--

CREATE TABLE `beauty_products` (
  `product_id` int(11) NOT NULL,
  `product_code` varchar(20) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `category` varchar(50) DEFAULT NULL,
  `price` decimal(12,2) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `beauty_products`
--

INSERT INTO `beauty_products` (`product_id`, `product_code`, `product_name`, `category`, `price`, `stock`, `created_at`) VALUES
(1, 'GB001', 'Hair Dryer Pro', 'Hair Tools', 350000.00, 15, '2026-06-04 23:11:38'),
(2, 'GB002', 'Nano Facial Steamer', 'Face Care', 420000.00, 10, '2026-06-04 23:11:38'),
(3, 'GB003', 'Premium Hair Straightener', 'Hair Tools', 285000.00, 20, '2026-06-04 23:11:38'),
(4, 'GB004', 'Electric Nail Dryer', 'Nail Care', 190000.00, 25, '2026-06-04 23:11:38'),
(5, 'GB005', 'Beauty Massager', 'Skin Care', 315000.00, 12, '2026-06-04 23:11:38');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `member_id` int(11) NOT NULL,
  `member_name` varchar(100) NOT NULL,
  `address` text DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`member_id`, `member_name`, `address`, `phone_number`, `created_at`) VALUES
(1, 'Alya Putri', 'Jakarta', '081234567890', '2026-06-04 23:11:38'),
(2, 'Citra Amelia', 'Bandung', '082345678901', '2026-06-04 23:11:38'),
(3, 'Nadia Safira', 'Tangerang', '083456789012', '2026-06-04 23:11:38');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','sales','manager') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `full_name`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'Administrator', 'admin', '0192023a7bbd73250516f069df18b500', 'admin', '2026-06-04 23:11:38'),
(2, 'Bella Sales', 'bella', '8a5c81d64eadf256b052d9aa9146fd6c', 'sales', '2026-06-04 23:11:38'),
(3, 'Siska Manager', 'manager', '0795151defba7a4b5dfa89170de46277', 'manager', '2026-06-04 23:11:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `beauty_orders`
--
ALTER TABLE `beauty_orders`
  ADD PRIMARY KEY (`order_id`),
  ADD UNIQUE KEY `invoice_number` (`invoice_number`),
  ADD KEY `fk_order_member` (`member_id`),
  ADD KEY `fk_order_sales` (`sales_id`);

--
-- Indexes for table `beauty_order_items`
--
ALTER TABLE `beauty_order_items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `fk_item_order` (`order_id`),
  ADD KEY `fk_item_product` (`product_id`);

--
-- Indexes for table `beauty_products`
--
ALTER TABLE `beauty_products`
  ADD PRIMARY KEY (`product_id`),
  ADD UNIQUE KEY `product_code` (`product_code`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`member_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `beauty_orders`
--
ALTER TABLE `beauty_orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `beauty_order_items`
--
ALTER TABLE `beauty_order_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `beauty_products`
--
ALTER TABLE `beauty_products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `beauty_orders`
--
ALTER TABLE `beauty_orders`
  ADD CONSTRAINT `fk_order_member` FOREIGN KEY (`member_id`) REFERENCES `members` (`member_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_order_sales` FOREIGN KEY (`sales_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `beauty_order_items`
--
ALTER TABLE `beauty_order_items`
  ADD CONSTRAINT `fk_item_order` FOREIGN KEY (`order_id`) REFERENCES `beauty_orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_item_product` FOREIGN KEY (`product_id`) REFERENCES `beauty_products` (`product_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
