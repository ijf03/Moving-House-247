-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 19, 2026 at 09:30 PM
-- Server version: 11.8.6-MariaDB
-- PHP Version: 8.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fit3047`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `customer_id` int(3) NOT NULL,
  `job_type_id` int(1) NOT NULL,
  `pickup_address` varchar(95) NOT NULL,
  `dropoff_address` varchar(95) NOT NULL,
  `job_date` date NOT NULL,
  `job_time` time NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Pending',
  `created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `customer_id`, `job_type_id`, `pickup_address`, `dropoff_address`, `job_date`, `job_time`, `status`, `created`) VALUES
(3, 24, 1, 'aaa', 'bbbb', '2026-04-19', '21:14:35', 'Pending', '2026-04-19 11:14:37');

-- --------------------------------------------------------

--
-- Table structure for table `contact_forms`
--

CREATE TABLE `contact_forms` (
  `contact_form_id` int(3) NOT NULL,
  `customer_id` int(3) NOT NULL,
  `subject` varchar(30) NOT NULL,
  `message` text NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `contact_forms`
--

INSERT INTO `contact_forms` (`contact_form_id`, `customer_id`, `subject`, `message`, `created`) VALUES
(26, 24, 'Stripe', 'Test', '2026-04-19 11:14:03');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(3) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(62) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `stripe_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `first_name`, `last_name`, `email`, `phone`, `stripe_id`) VALUES
(24, 'Le', 'Nguyen', 'weejamese0451@gmail.com', '0416647617', 'cus_UMcXsRr9cNNhT8');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `invoice_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `stripe_invoice_id` varchar(255) NOT NULL,
  `invoice_url` text DEFAULT NULL,
  `status` varchar(50) NOT NULL,
  `subtotal_cents` int(11) DEFAULT NULL,
  `total_cents` int(11) DEFAULT NULL,
  `sent_at` datetime DEFAULT NULL,
  `paid_at` datetime DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`invoice_id`, `booking_id`, `customer_id`, `stripe_invoice_id`, `invoice_url`, `status`, `subtotal_cents`, `total_cents`, `sent_at`, `paid_at`, `created`, `modified`) VALUES
(22, 3, 24, 'in_1TNtJfAu2SFjfSfr6Tj1N34S', 'https://invoice.stripe.com/i/acct_1TKCNrAu2SFjfSfr/test_YWNjdF8xVEtDTnJBdTJTRmpmU2ZyLF9VTWNZR3FuODJ3bXBWT3puMjRmMHNRcUtWTnFpaDNwLDE2NzEzODEwOQ0200dGQL5kZr?s=ap', 'open', 68000, 68000, '2026-04-19 11:15:09', NULL, '2026-04-19 11:15:06', '2026-04-19 11:15:09'),
(23, 3, 24, 'in_1TNtMtAu2SFjfSfrvLFLV66f', 'https://invoice.stripe.com/i/acct_1TKCNrAu2SFjfSfr/test_YWNjdF8xVEtDTnJBdTJTRmpmU2ZyLF9VTWNjbE1pc0l3YmFYblZnTzJnOG9VT2VROXRnemVpLDE2NzEzODMwOQ0200grGfw7MW?s=ap', 'open', 34000, 34000, '2026-04-19 11:18:29', NULL, '2026-04-19 11:18:25', '2026-04-19 11:18:29'),
(24, 3, 24, 'in_1TNtOiAu2SFjfSfrvSS3sXuQ', 'https://invoice.stripe.com/i/acct_1TKCNrAu2SFjfSfr/test_YWNjdF8xVEtDTnJBdTJTRmpmU2ZyLF9VTWNlVFpvNTVwcDMwTG9Vd1RtYzBKVDAyOXdjYUJaLDE2NzEzODQyMg0200LIztwZux?s=ap', 'open', 72000, 72000, '2026-04-19 11:20:22', NULL, '2026-04-19 11:20:18', '2026-04-19 11:20:22'),
(25, 3, 24, 'in_1TNtPsAu2SFjfSfrtTssDL8Y', 'https://invoice.stripe.com/i/acct_1TKCNrAu2SFjfSfr/test_YWNjdF8xVEtDTnJBdTJTRmpmU2ZyLF9VTWNmQ1ZWaTJCVFNvcVlkV2VQZGI0czF4QkRHR0NwLDE2NzEzODQ5NA0200BNYkjx92?s=ap', 'open', 569500, 569500, '2026-04-19 11:21:34', NULL, '2026-04-19 11:21:30', '2026-04-19 11:21:34'),
(26, 3, 24, 'in_1TNtRlAu2SFjfSfrFQv80sA6', 'https://invoice.stripe.com/i/acct_1TKCNrAu2SFjfSfr/test_YWNjdF8xVEtDTnJBdTJTRmpmU2ZyLF9VTWNoVVlWZHVYUTRLRWZxblhHaU4wT29YTDlBeFFuLDE2NzEzODYxMg0200mrf7UZ9z?s=ap', 'paid', 112000, 112000, '2026-04-19 11:23:32', '2026-04-19 11:23:42', '2026-04-19 11:23:27', '2026-04-19 11:23:32');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_items`
--

CREATE TABLE `invoice_items` (
  `invoice_item_id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `unit_price_cents` int(11) NOT NULL,
  `line_total_cents` int(11) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `invoice_items`
--

INSERT INTO `invoice_items` (`invoice_item_id`, `invoice_id`, `description`, `quantity`, `unit_price_cents`, `line_total_cents`, `sort_order`, `created`, `modified`) VALUES
(3, 3, 'Labour - per hour', 3.00, 8500, 25500, 1, '2026-04-19 08:40:10', '2026-04-19 08:40:10'),
(4, 3, 'Truck rental - small truck', 1.00, 18000, 18000, 2, '2026-04-19 08:40:10', '2026-04-19 08:40:10'),
(5, 4, 'Labour - per hour', 3.00, 8500, 25500, 1, '2026-04-19 08:57:40', '2026-04-19 08:57:40'),
(6, 4, 'Truck rental - small truck', 1.00, 18000, 18000, 2, '2026-04-19 08:57:40', '2026-04-19 08:57:40'),
(7, 4, 'Packing materials', 3.00, 5000, 15000, 3, '2026-04-19 08:57:40', '2026-04-19 08:57:40'),
(8, 5, 'Labour - per hour', 3.00, 8500, 25500, 1, '2026-04-19 09:02:37', '2026-04-19 09:02:37'),
(9, 5, 'Truck rental - small truck', 2.00, 18000, 36000, 2, '2026-04-19 09:02:37', '2026-04-19 09:02:37'),
(10, 5, 'Packing materials', 3.00, 5000, 15000, 3, '2026-04-19 09:02:37', '2026-04-19 09:02:37'),
(11, 6, 'Labour - per hour', 3.00, 8500, 25500, 1, '2026-04-19 09:03:09', '2026-04-19 09:03:09'),
(12, 6, 'Truck rental - small truck', 2.00, 18000, 36000, 2, '2026-04-19 09:03:09', '2026-04-19 09:03:09'),
(13, 6, 'Packing materials', 3.00, 5000, 15000, 3, '2026-04-19 09:03:09', '2026-04-19 09:03:09'),
(14, 7, 'Labour - per hour', 3.00, 8500, 25500, 1, '2026-04-19 09:13:38', '2026-04-19 09:13:38'),
(15, 7, 'Truck rental - small truck', 2.00, 18000, 36000, 2, '2026-04-19 09:13:38', '2026-04-19 09:13:38'),
(16, 7, 'Packing materials', 3.00, 5000, 15000, 3, '2026-04-19 09:13:38', '2026-04-19 09:13:38'),
(17, 8, 'Labour - per hour', 5.00, 8500, 42500, 1, '2026-04-19 09:14:15', '2026-04-19 09:14:15'),
(18, 9, 'Packing materials', 6.00, 5000, 30000, 1, '2026-04-19 09:15:52', '2026-04-19 09:15:52'),
(19, 10, 'Packing materials', 6.00, 5000, 30000, 1, '2026-04-19 09:16:03', '2026-04-19 09:16:03'),
(20, 11, 'Truck rental - small truck', 4.00, 18000, 72000, 1, '2026-04-19 09:20:30', '2026-04-19 09:20:30'),
(21, 12, 'Packing materials', 1.00, 5000, 5000, 1, '2026-04-19 09:32:32', '2026-04-19 09:32:32'),
(22, 13, 'Labour - per hour', 1.00, 8500, 8500, 1, '2026-04-19 09:36:04', '2026-04-19 09:36:04'),
(23, 14, 'Labour - per hour', 1.00, 8500, 8500, 1, '2026-04-19 09:36:24', '2026-04-19 09:36:24'),
(24, 15, 'Labour - per hour', 1.00, 8500, 8500, 1, '2026-04-19 09:36:36', '2026-04-19 09:36:36'),
(25, 16, 'Labour - per hour', 1.00, 8500, 8500, 1, '2026-04-19 09:36:59', '2026-04-19 09:36:59'),
(26, 17, 'Truck rental - large truck', 4.00, 28000, 112000, 1, '2026-04-19 09:50:55', '2026-04-19 09:50:55'),
(27, 18, 'test', 11.00, 50, 550, 1, '2026-04-19 09:51:41', '2026-04-19 09:51:41'),
(28, 19, 'Labour - per hour', 13.00, 8500, 110500, 1, '2026-04-19 11:07:37', '2026-04-19 11:07:37'),
(30, 21, 'Packing materials', 432.00, 5000, 2160000, 1, '2026-04-19 11:09:39', '2026-04-19 11:09:39'),
(31, 22, 'Labour - per hour', 8.00, 8500, 68000, 1, '2026-04-19 11:15:06', '2026-04-19 11:15:06'),
(32, 23, 'Labour - per hour', 4.00, 8500, 34000, 1, '2026-04-19 11:18:25', '2026-04-19 11:18:25'),
(33, 24, 'Truck rental - small truck', 4.00, 18000, 72000, 1, '2026-04-19 11:20:18', '2026-04-19 11:20:18'),
(34, 25, 'Labour - per hour', 67.00, 8500, 569500, 1, '2026-04-19 11:21:30', '2026-04-19 11:21:30'),
(35, 26, 'Truck rental - large truck', 4.00, 28000, 112000, 1, '2026-04-19 11:23:27', '2026-04-19 11:23:27');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `job_id` int(11) NOT NULL,
  `job_type_id` int(1) NOT NULL,
  `description` text NOT NULL,
  `pickup_address` varchar(95) NOT NULL,
  `dropoff_address` varchar(95) NOT NULL,
  `job_date` varchar(11) NOT NULL,
  `job_time` varchar(5) NOT NULL,
  `customer_id` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_types`
--

CREATE TABLE `job_types` (
  `job_type_id` int(1) NOT NULL,
  `job_type_name` varchar(20) NOT NULL,
  `job_type_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `job_types`
--

INSERT INTO `job_types` (`job_type_id`, `job_type_name`, `job_type_description`) VALUES
(1, 'Removal', 'Removal of items from customer'),
(2, 'Storage', 'Storage of items from customer');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `email` varchar(62) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(46) NOT NULL,
  `last_name` varchar(46) NOT NULL,
  `user_type` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `phone`, `password`, `first_name`, `last_name`, `user_type`) VALUES
(1, 'admin@test.com', '', '$2y$12$xGvQK7AIhGg7iytP8aIEjOV1pm4Ev7hmJweuns1iNDkYW4VI69ipS', 'Alice', 'Admin', 1),
(4, 'weejamese0451@gmail.com', '0416647617', '$2y$12$0TqBdoMAs4C1J4PMubVGLuC.75mcX4VxhCVk8oSQNQ5PXZVbk6Hl2', 'Le', 'Nguyen', 2);

-- --------------------------------------------------------

--
-- Table structure for table `user_types`
--

CREATE TABLE `user_types` (
  `user_type_id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `user_types`
--

INSERT INTO `user_types` (`user_type_id`, `name`, `description`) VALUES
(1, 'Admin', 'Full system access'),
(2, 'Customer', 'Limited system access');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `bookings_customer_id` (`customer_id`),
  ADD KEY `bookings_job_type_id` (`job_type_id`);

--
-- Indexes for table `contact_forms`
--
ALTER TABLE `contact_forms`
  ADD PRIMARY KEY (`contact_form_id`),
  ADD KEY `contact_forms_customer_id` (`customer_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`invoice_id`),
  ADD KEY `fk_invoices_booking_id` (`booking_id`),
  ADD KEY `fk_invoices_customer_id` (`customer_id`);

--
-- Indexes for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD PRIMARY KEY (`invoice_item_id`),
  ADD KEY `fk_invoice_item_invoice_id` (`invoice_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`job_id`),
  ADD KEY `job_type_id` (`job_type_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `job_types`
--
ALTER TABLE `job_types`
  ADD PRIMARY KEY (`job_type_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `users_user_type_id` (`user_type`);

--
-- Indexes for table `user_types`
--
ALTER TABLE `user_types`
  ADD PRIMARY KEY (`user_type_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `contact_forms`
--
ALTER TABLE `contact_forms`
  MODIFY `contact_form_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `invoice_items`
--
ALTER TABLE `invoice_items`
  MODIFY `invoice_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `job_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `job_types`
--
ALTER TABLE `job_types`
  MODIFY `job_type_id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_types`
--
ALTER TABLE `user_types`
  MODIFY `user_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `fk_bookings_customer` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`),
  ADD CONSTRAINT `fk_bookings_job_type` FOREIGN KEY (`job_type_id`) REFERENCES `job_types` (`job_type_id`);

--
-- Constraints for table `contact_forms`
--
ALTER TABLE `contact_forms`
  ADD CONSTRAINT `contact_forms_customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`);

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `fk_invoices_booking_id` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`booking_id`),
  ADD CONSTRAINT `fk_invoices_customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`);

--
-- Constraints for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD CONSTRAINT `fk_invoice_item_invoice_id` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`invoice_id`);

--
-- Constraints for table `jobs`
--
ALTER TABLE `jobs`
  ADD CONSTRAINT `jobs_customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`),
  ADD CONSTRAINT `jobs_job_type_id` FOREIGN KEY (`job_type_id`) REFERENCES `job_types` (`job_type_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_user_type_id` FOREIGN KEY (`user_type`) REFERENCES `user_types` (`user_type_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
