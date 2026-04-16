-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 23, 2026 at 10:19 PM
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
-- Table structure for table `contact_forms`
--

CREATE TABLE `contact_forms` (
                                 `contact_form_id` int(3) NOT NULL,
                                 `customer_id` int(3) NOT NULL,
                                 `subject` varchar(30) NOT NULL,
                                 `message` text NOT NULL,
                                 `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
                             `customer_id` int(3) NOT NULL,
                             `first_name` varchar(50) NOT NULL,
                             `last_name` varchar(50) NOT NULL,
                             `email` varchar(62) NOT NULL,
                             `phone` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

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
                         `password` varchar(255) NOT NULL,
                         `first_name` varchar(46) NOT NULL,
                         `last_name` varchar(46) NOT NULL,
                         `user_type` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_types`
--

CREATE TABLE `user_types` (
                              `user_type_id` int(11) NOT NULL,
                              `name` varchar(20) NOT NULL,
                              `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE TABLE bookings (
                          booking_id int(11) NOT NULL AUTO_INCREMENT,
                          customer_id int(3) NOT NULL,
                          job_type_id int(1) NOT NULL,
                          pickup_address varchar(95) NOT NULL,
                          dropoff_address varchar(95) NOT NULL,
                          job_date date NOT NULL,
                          job_time time NOT NULL,
                          status varchar(20) NOT NULL DEFAULT 'Pending',
                          created datetime NOT NULL DEFAULT current_timestamp(),
                          PRIMARY KEY (booking_id),
                          KEY bookings_customer_id (customer_id),
                          KEY bookings_job_type_id (job_type_id),
                          CONSTRAINT fk_bookings_customer
                              FOREIGN KEY (customer_id) REFERENCES customers (customer_id),
                          CONSTRAINT fk_bookings_job_type
                              FOREIGN KEY (job_type_id) REFERENCES job_types (job_type_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for table `contact_forms`
--
ALTER TABLE `contact_forms`
    MODIFY `contact_form_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
    MODIFY `customer_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
    MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_types`
--
ALTER TABLE `user_types`
    MODIFY `user_type_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `contact_forms`
--
ALTER TABLE `contact_forms`
    ADD CONSTRAINT `contact_forms_customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`);

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

ALTER TABLE users ADD phone varchar(15) NOT NULL AFTER email;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*dummy test cases*/
INSERT INTO user_types (name, description) VALUES
    ('Admin', 'Full system access');
INSERT INTO user_types (name, description) VALUES
    ('Customer', 'Limited system access');
INSERT INTO users (email, password, first_name, last_name, user_type) VALUES
    ('admin@test.com', '$2y$12$xGvQK7AIhGg7iytP8aIEjOV1pm4Ev7hmJweuns1iNDkYW4VI69ipS', 'Alice', 'Admin', 1);
