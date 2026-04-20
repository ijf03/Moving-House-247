SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

DROP TABLE IF EXISTS `invoice_items`;
DROP TABLE IF EXISTS `invoices`;
DROP TABLE IF EXISTS `contact_forms`;
DROP TABLE IF EXISTS `jobs`;
DROP TABLE IF EXISTS `bookings`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `customers`;
DROP TABLE IF EXISTS `job_types`;
DROP TABLE IF EXISTS `user_types`;

CREATE TABLE `customers` (
                             `customer_id` int(3) NOT NULL AUTO_INCREMENT,
                             `first_name` varchar(50) NOT NULL,
                             `last_name` varchar(50) NOT NULL,
                             `email` varchar(62) NOT NULL,
                             `phone` varchar(15) NOT NULL,
                             `stripe_id` varchar(255) DEFAULT NULL,
                             PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE TABLE `job_types` (
                             `job_type_id` int(1) NOT NULL AUTO_INCREMENT,
                             `job_type_name` varchar(20) NOT NULL,
                             `job_type_description` text NOT NULL,
                             PRIMARY KEY (`job_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

INSERT INTO `job_types` (`job_type_id`, `job_type_name`, `job_type_description`) VALUES
                                                                                     (1, 'Removal', 'Removal of items from customer'),
                                                                                     (2, 'Storage', 'Storage of items from customer');

CREATE TABLE `user_types` (
                              `user_type_id` int(11) NOT NULL AUTO_INCREMENT,
                              `name` varchar(20) NOT NULL,
                              `description` text NOT NULL,
                              PRIMARY KEY (`user_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

INSERT INTO `user_types` (`user_type_id`, `name`, `description`) VALUES
                                                                     (1, 'Admin', 'Full system access'),
                                                                     (2, 'Staff', 'Operational staff member'),
                                                                     (3, 'Customer', 'Handles customer communication and enquiries');

CREATE TABLE `users` (
                         `user_id` int(11) NOT NULL AUTO_INCREMENT,
                         `email` varchar(62) NOT NULL,
                         `phone` varchar(15) NOT NULL,
                         `password` varchar(255) NOT NULL,
                         `first_name` varchar(46) NOT NULL,
                         `last_name` varchar(46) NOT NULL,
                         `user_type` int(1) NOT NULL,
                         PRIMARY KEY (`user_id`),
                         KEY `users_user_type_id` (`user_type`),
                         CONSTRAINT `users_user_type_id`
                             FOREIGN KEY (`user_type`) REFERENCES `user_types` (`user_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

INSERT INTO `users` (`user_id`, `email`, `phone`, `password`, `first_name`, `last_name`, `user_type`) VALUES
                                                                                                          (1, 'customer@myapp.local', '0400000001', '$2y$12$O2mUGRcOpX4i.RgsD0Dofe9hmwPLsxC.teN0iMwi7a9Dx0ainBcum', 'Alex', 'Morgan', 1),
                                                                                                          (2, 'staff@myapp.local', '0400000002', '$2y$12$uVkWd9a7/30M6Zc3CZ8Ou.NOtS2NHNaB8pdaZbmwq8gvFCjjnICse', 'Jordan', 'Lee', 2),
                                                                                                          (3, 'admin@test.com', '0400000003', '$2y$12$xGvQK7AIhGg7iytP8aIEjOV1pm4Ev7hmJweuns1iNDkYW4VI69ipS', 'Alice', 'Admin', 1);

CREATE TABLE `bookings` (
                            `booking_id` int(11) NOT NULL AUTO_INCREMENT,
                            `customer_id` int(3) NOT NULL,
                            `job_type_id` int(1) NOT NULL,
                            `pickup_address` varchar(95) NOT NULL,
                            `dropoff_address` varchar(95) NOT NULL,
                            `job_date` date NOT NULL,
                            `job_time` time NOT NULL,
                            `status` varchar(20) NOT NULL DEFAULT 'Pending',
                            `created` datetime NOT NULL DEFAULT current_timestamp(),
                            PRIMARY KEY (`booking_id`),
                            KEY `bookings_customer_id` (`customer_id`),
                            KEY `bookings_job_type_id` (`job_type_id`),
                            CONSTRAINT `fk_bookings_customer`
                                FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`),
                            CONSTRAINT `fk_bookings_job_type`
                                FOREIGN KEY (`job_type_id`) REFERENCES `job_types` (`job_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE TABLE `jobs` (
                        `job_id` int(11) NOT NULL AUTO_INCREMENT,
                        `job_type_id` int(1) NOT NULL,
                        `description` text NOT NULL,
                        `pickup_address` varchar(95) NOT NULL,
                        `dropoff_address` varchar(95) NOT NULL,
                        `job_date` date NOT NULL,
                        `job_time` time NOT NULL,
                        `customer_id` int(3) NOT NULL,
                        PRIMARY KEY (`job_id`),
                        KEY `jobs_job_type_id` (`job_type_id`),
                        KEY `jobs_customer_id` (`customer_id`),
                        CONSTRAINT `jobs_customer_id`
                            FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`),
                        CONSTRAINT `jobs_job_type_id`
                            FOREIGN KEY (`job_type_id`) REFERENCES `job_types` (`job_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

INSERT INTO `jobs` (`job_id`, `job_type_id`, `description`, `pickup_address`, `dropoff_address`, `job_date`, `job_time`, `customer_id`) VALUES
                                                                                                                                            (1, 1, 'Move 2-bedroom apartment including fridge, sofa, washing machine, and boxes.', '12 King St, Clayton VIC 3168', '88 Collins St, Melbourne VIC 3000', '2026-03-28', '09:00:00', 1),
                                                                                                                                            (2, 2, 'Store household furniture and personal boxes for temporary relocation.', '5 Princes Hwy, Dandenong VIC 3175', 'Unit 4, Storage Hub, Springvale VIC 3171', '2026-03-30', '13:30:00', 2),
                                                                                                                                            (3, 1, 'Office equipment relocation including desks, monitors, and chairs.', '21 Wellington Rd, Mulgrave VIC 3170', '9 Queen St, Melbourne VIC 3000', '2026-04-02', '08:15:00', 3);

CREATE TABLE `contact_forms` (
                                 `contact_form_id` int(11) NOT NULL AUTO_INCREMENT,
                                 `customer_id` int(3) NOT NULL,
                                 `subject` varchar(100) NOT NULL,
                                 `message` text NOT NULL,
                                 `created` datetime NOT NULL DEFAULT current_timestamp(),
                                 `status` varchar(20) NOT NULL DEFAULT 'new',
                                 `admin_reply` text DEFAULT NULL,
                                 `replied_at` datetime DEFAULT NULL,
                                 PRIMARY KEY (`contact_form_id`),
                                 KEY `contact_forms_customer_id` (`customer_id`),
                                 CONSTRAINT `contact_forms_customer_id`
                                     FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

INSERT INTO `contact_forms` (`contact_form_id`, `customer_id`, `subject`, `message`, `created`, `status`, `admin_reply`, `replied_at`) VALUES
    (1, 9, 'vfjefkebfjgej', 'asdasda', '2026-04-15 15:18:28', 'new', NULL, NULL);

CREATE TABLE `invoices` (
                            `invoice_id` int(11) NOT NULL AUTO_INCREMENT,
                            `booking_id` int(11) NOT NULL,
                            `customer_id` int(3) NOT NULL,
                            `stripe_invoice_id` varchar(255) DEFAULT NULL,
                            `invoice_url` text DEFAULT NULL,
                            `status` varchar(50) NOT NULL DEFAULT 'draft',
                            `subtotal_cents` int(11) DEFAULT NULL,
                            `total_cents` int(11) DEFAULT NULL,
                            `sent_at` datetime DEFAULT NULL,
                            `paid_at` datetime DEFAULT NULL,
                            `created` datetime NOT NULL DEFAULT current_timestamp(),
                            `modified` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                            PRIMARY KEY (`invoice_id`),
                            KEY `fk_invoices_booking_id` (`booking_id`),
                            KEY `fk_invoices_customer_id` (`customer_id`),
                            CONSTRAINT `fk_invoices_booking_id`
                                FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`booking_id`),
                            CONSTRAINT `fk_invoices_customer_id`
                                FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE TABLE `invoice_items` (
                                 `invoice_item_id` int(11) NOT NULL AUTO_INCREMENT,
                                 `invoice_id` int(11) NOT NULL,
                                 `description` varchar(255) NOT NULL,
                                 `quantity` decimal(10,2) NOT NULL DEFAULT 1.00,
                                 `unit_price_cents` int(11) NOT NULL,
                                 `line_total_cents` int(11) NOT NULL,
                                 `sort_order` int(11) NOT NULL DEFAULT 0,
                                 `created` datetime NOT NULL DEFAULT current_timestamp(),
                                 `modified` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                                 PRIMARY KEY (`invoice_item_id`),
                                 KEY `fk_invoice_item_invoice_id` (`invoice_id`),
                                 CONSTRAINT `fk_invoice_item_invoice_id`
                                     FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`invoice_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

COMMIT;
