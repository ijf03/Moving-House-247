-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 16, 2026 at 01:21 AM
-- Server version: 11.8.6-MariaDB
-- PHP Version: 8.4.16

SET
SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET
time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `my_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact_forms`
--

CREATE TABLE `contact_forms`
(
    `contact_form_id` int(11) NOT NULL,
    `customer_id`     int(3) NOT NULL,
    `subject`         varchar(100) NOT NULL,
    `message`         text         NOT NULL,
    `created`         datetime     NOT NULL DEFAULT current_timestamp(),
    `status`          varchar(20)  NOT NULL DEFAULT 'new',
    `admin_reply`     text                  DEFAULT NULL,
    `replied_at`      datetime              DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `contact_forms`
--

INSERT INTO `contact_forms` (`contact_form_id`, `customer_id`, `subject`, `message`, `created`, `status`, `admin_reply`,
                             `replied_at`)
VALUES (0, 9, 'vfjefkebfjgej', 'asdasda', '2026-04-15 15:18:28', 'new', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers`
(
    `customer_id` int(3) NOT NULL,
    `first_name`  varchar(50) NOT NULL,
    `last_name`   varchar(50) NOT NULL,
    `email`       varchar(62) NOT NULL,
    `phone`       varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `first_name`, `last_name`, `email`, `phone`)
VALUES (1, 'Emily', 'Carter', 'emily.carter@example.com', '0412345678'),
       (2, 'Liam', 'Nguyen', 'liam.nguyen@example.com', '0423456789'),
       (3, 'Sophie', 'Patel', 'sophie.patel@example.com', '0434567890'),
       (4, 'first', 'last', 'email@mail.com', '0987654321');
-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs`
(
    `job_id`          int(11) NOT NULL,
    `job_type_id`     int(1) NOT NULL,
    `description`     text        NOT NULL,
    `pickup_address`  varchar(95) NOT NULL,
    `dropoff_address` varchar(95) NOT NULL,
    `job_date`        date        NOT NULL,
    `job_time`        time        NOT NULL,
    `customer_id`     int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`job_id`, `job_type_id`, `description`, `pickup_address`, `dropoff_address`, `job_date`, `job_time`,
                    `customer_id`)
VALUES (1, 1, 'Move 2-bedroom apartment including fridge, sofa, washing machine, and boxes.',
        '12 King St, Clayton VIC 3168', '88 Collins St, Melbourne VIC 3000', '28/03/2026', '09:00', 1),
       (2, 2, 'Store household furniture and personal boxes for temporary relocation.',
        '5 Princes Hwy, Dandenong VIC 3175', 'Unit 4, Storage Hub, Springvale VIC 3171', '30/03/2026', '13:30', 2),
       (3, 1, 'Office equipment relocation including desks, monitors, and chairs.',
        '21 Wellington Rd, Mulgrave VIC 3170', '9 Queen St, Melbourne VIC 3000', '02/04/2026', '08:15', 3);

-- --------------------------------------------------------

--
-- Table structure for table `job_types`
--

CREATE TABLE `job_types`
(
    `job_type_id`          int(1) NOT NULL,
    `job_type_name`        varchar(20) NOT NULL,
    `job_type_description` text        NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `job_types`
--

INSERT INTO `job_types` (`job_type_id`, `job_type_name`, `job_type_description`)
VALUES (1, 'Removal', 'Removal of items from customer'),
       (2, 'Storage', 'Storage of items from customer');

-- --------------------------------------------------------
--
-- Table structure for table `bookings`
--
CREATE TABLE `bookings`
(
    `booking_id`      int(11) NOT NULL,
    `customer_id`     int(3) NOT NULL,
    `job_type_id`     int(1) NOT NULL,
    `pickup_address`  varchar(95) NOT NULL,
    `dropoff_address` varchar(95) NOT NULL,
    `job_date`        date        NOT NULL,
    `job_time`        time        NOT NULL,
    `status`          varchar(20) NOT NULL DEFAULT 'Pending',
    `created`         datetime    NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Table structure for table `users`
--

CREATE TABLE `users`
(
    `user_id`    int(11) NOT NULL,
    `email`      varchar(62)  NOT NULL,
    `password`   varchar(255) NOT NULL,
    `first_name` varchar(46)  NOT NULL,
    `last_name`  varchar(46)  NOT NULL,
    `user_type`  int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `password`, `first_name`, `last_name`, `user_type`)
VALUES (1, 'customer@myapp.local', '$2y$12$O2mUGRcOpX4i.RgsD0Dofe9hmwPLsxC.teN0iMwi7a9Dx0ainBcum', 'Alex', 'Morgan', 1), --customer123
       (2, 'staff@myapp.local', '$2y$12$uVkWd9a7/30M6Zc3CZ8Ou.NOtS2NHNaB8pdaZbmwq8gvFCjjnICse', 'Jordan', 'Lee', 2), --staff123
       (3, 'admin@test.com', '$2y$12$xGvQK7AIhGg7iytP8aIEjOV1pm4Ev7hmJweuns1iNDkYW4VI69ipS', 'Alice', 'Admin', 1); --admin123

-- --------------------------------------------------------

--
-- Table structure for table `user_types`
--

CREATE TABLE `user_types`
(
    `user_type_id` int(11) NOT NULL,
    `name`         varchar(20) NOT NULL,
    `description`  text        NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `user_types`
--

INSERT INTO `user_types` (`user_type_id`, `name`, `description`)
VALUES (1, 'Admin', 'Full system access'),
       (2, 'Staff', 'Operational staff member'),
       (3, 'Customer', 'Handles customer communication and enquiries');

--
-- Indexes for dumped tables
--

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
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
    ADD PRIMARY KEY (`booking_id`);

--
-- Indexes for table `contact_forms`
--
ALTER TABLE `contact_forms`
    ADD PRIMARY KEY (`contact_form_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
    MODIFY `customer_id` int (3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
    MODIFY `job_id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `job_types`
--
ALTER TABLE `job_types`
    MODIFY `job_type_id` int (1) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
    MODIFY `user_id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_types`
--
ALTER TABLE `user_types`
    MODIFY `user_type_id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
    MODIFY `booking_id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact_forms`
--
ALTER TABLE `contact_forms`
    MODIFY `contact_form_id` int (11) NOT NULL AUTO_INCREMENT;

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

--
-- Constraints for table `users`
--
ALTER TABLE `bookings`
    ADD CONSTRAINT `bookings_customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`),
    ADD CONSTRAINT `bookings_job_type_id` FOREIGN KEY (`job_type_id`) REFERENCES `job_types` (`job_type_id`);

ALTER TABLE users
    ADD phone varchar(15) NOT NULL AFTER email;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
