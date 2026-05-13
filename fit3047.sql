-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 03, 2026 at 05:05 PM
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
-- Database: `fit3047`
--

-- --------------------------------------------------------
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS `content_blocks`;
DROP TABLE IF EXISTS `content_blocks_phinxlog`;
DROP TABLE IF EXISTS `phinxlog`;
DROP TABLE IF EXISTS `booking_resources`;
DROP TABLE IF EXISTS `invoice_items`;
DROP TABLE IF EXISTS `invoice_item_presets`;
DROP TABLE IF EXISTS `invoices`;
DROP TABLE IF EXISTS `contact_form_replies`;
DROP TABLE IF EXISTS `contact_forms`;
DROP TABLE IF EXISTS `jobs`;
DROP TABLE IF EXISTS `trucks`;
DROP TABLE IF EXISTS `storage_units`;
DROP TABLE IF EXISTS `equipment`;
DROP TABLE IF EXISTS `inventory_items`;
DROP TABLE IF EXISTS `bookings`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `customers`;
DROP TABLE IF EXISTS `job_types`;
DROP TABLE IF EXISTS `user_types`;
DROP TABLE IF EXISTS `phinxlog`;
DROP TABLE IF EXISTS `staff`;
DROP TABLE IF EXISTS `staff_job`;
DROP TABLE IF EXISTS `availability`;
DROP TABLE IF EXISTS `job_trucks`;
DROP TABLE IF EXISTS `job_resources`;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE `staff`
(
    `staff_id` int(11) NOT NULL,
    `first_name`  varchar(50) NOT NULL,
    `last_name`   varchar(50) NOT NULL,
    `email`       varchar(62) NOT NULL,
    `phone`       varchar(15) NOT NULL,
    `isDriver`    tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE TABLE `availability`
(
    `availability_id` int(11) NOT NULL AUTO_INCREMENT,
    `staff_id` int(11) NOT NULL,
    `start_datetime` datetime NOT NULL,
    `end_datetime` datetime NOT NULL,

    PRIMARY KEY (`availability_id`),
    KEY `availability_staff_id` (`staff_id`)

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE TABLE `staff_job`
(
    `allocation_id` int(11) NOT NULL,
    `staff_id` int(11) NOT NULL,
    `job_id`  int(11) NOT NULL,
    `status` ENUM('Waiting', 'Confirmed', 'Rejected') NOT NULL DEFAULT 'Waiting'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE TABLE `content_blocks`
(
    `id`             int(11) NOT NULL,
    `parent`         varchar(128) NOT NULL,
    `slug`           varchar(128) NOT NULL,
    `label`          varchar(255) NOT NULL,
    `description`    varchar(255) NOT NULL,
    `type`           varchar(32)  NOT NULL,
    `value`          text                  DEFAULT NULL,
    `previous_value` text                  DEFAULT NULL,
    `modified`       timestamp    NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;


CREATE TABLE `content_blocks_phinxlog`
(
    `version`        bigint(20) NOT NULL,
    `migration_name` varchar(100) DEFAULT NULL,
    `start_time`     timestamp NULL DEFAULT NULL,
    `end_time`       timestamp NULL DEFAULT NULL,
    `breakpoint`     tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE TABLE `phinxlog`
(
    `version`        bigint(20) NOT NULL,
    `migration_name` varchar(100) DEFAULT NULL,
    `start_time`     timestamp NULL DEFAULT NULL,
    `end_time`       timestamp NULL DEFAULT NULL,
    `breakpoint`     tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE TABLE `contact_forms`
(
    `contact_form_id` int(11) NOT NULL,
    `customer_id`     int(11) NOT NULL,
    `subject`         varchar(100) NOT NULL,
    `message`         text         NOT NULL,
    `created`         datetime     NOT NULL DEFAULT current_timestamp(),
    `status`          varchar(20)  NOT NULL DEFAULT 'new',
    `admin_reply`     text                  DEFAULT NULL,
    `replied_at`      datetime              DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE TABLE `contact_form_replies`
(
    `contact_form_reply_id` int(11) NOT NULL AUTO_INCREMENT,
    `contact_form_id`       int(11) NOT NULL,
    `sender_type`           varchar(20) NOT NULL,
    `message`               text NOT NULL,
    `created`               datetime NOT NULL DEFAULT current_timestamp(),
    `modified`              datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`contact_form_reply_id`),
    KEY `contact_form_replies_contact_form_id` (`contact_form_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE TABLE `customers`
(
    `customer_id` int(11) NOT NULL,
    `first_name`  varchar(50) NOT NULL,
    `last_name`   varchar(50) NOT NULL,
    `email`       varchar(62) NOT NULL,
    `phone`       varchar(15) NOT NULL,
    `stripe_id`   varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE TABLE `jobs`
(
    `job_id`          int(11) NOT NULL,
    `job_type_id`     int(1) NOT NULL,
    `description`     text        NOT NULL,
    `pickup_address`  varchar(95) NOT NULL,
    `dropoff_address` varchar(95) NULL,
    `job_date`        date        NOT NULL,
    `job_time`        time        NOT NULL,
    `customer_id`     int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE TABLE `job_types`
(
    `job_type_id`          int(1) NOT NULL,
    `job_type_name`        varchar(20) NOT NULL,
    `job_type_description` text        NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE TABLE `bookings`
(
    `booking_id`        int(11) NOT NULL,
    `customer_id`       int(11) NOT NULL,
    `job_type_id`       int(1) NOT NULL,
    `pickup_address`    varchar(95) NOT NULL,
    `dropoff_address`   varchar(95) NOT NULL,
    `job_date`          date        NOT NULL,
    `job_time`          time        NOT NULL,
    `status`            varchar(20) NOT NULL DEFAULT 'Pending',
    `created`           datetime    NOT NULL DEFAULT current_timestamp(),
    `message`           text                 DEFAULT NULL,
    `accepted_notified` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE TABLE `users`
(
    `user_id`    int(11) NOT NULL,
    `email`      varchar(62)  NOT NULL,
    `phone`      varchar(15)  NOT NULL,
    `password`   varchar(255) NOT NULL,
    `first_name` varchar(46)  NOT NULL,
    `last_name`  varchar(46)  NOT NULL,
    `user_type`  int(1) NOT NULL,
    `reset_id`   varchar(20) DEFAULT NULL,
    `time_limit` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE TABLE `user_types`
(
    `user_type_id` int(11) NOT NULL,
    `name`         varchar(20) NOT NULL,
    `description`  text        NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE TABLE `invoices`
(
    `invoice_id`        int(11) NOT NULL,
    `booking_id`        int(11) NOT NULL,
    `customer_id`       int(11) NOT NULL,
    `stripe_invoice_id` varchar(255)         DEFAULT NULL,
    `invoice_url`       text                 DEFAULT NULL,
    `status`            varchar(50) NOT NULL DEFAULT 'draft',
    `subtotal_cents`    int(11) DEFAULT NULL,
    `total_cents`       int(11) DEFAULT NULL,
    `due_date`          date                 DEFAULT NULL,
    `sent_at`           datetime             DEFAULT NULL,
    `paid_at`           datetime             DEFAULT NULL,
    `created`           datetime    NOT NULL DEFAULT current_timestamp(),
    `modified`          datetime    NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE TABLE `invoice_item_presets`
(
    `invoice_item_preset_id` int(11) NOT NULL AUTO_INCREMENT,
    `code`                   varchar(50)  NOT NULL,
    `name`                   varchar(100) NOT NULL,
    `description`            varchar(255) NOT NULL,
    `unit_price_cents`       int(11) NOT NULL,
    `is_active`              tinyint(1) NOT NULL DEFAULT 1,
    `sort_order`             int(11) NOT NULL DEFAULT 0,
    `created`                datetime     NOT NULL DEFAULT current_timestamp(),
    `modified`               datetime     NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`invoice_item_preset_id`),
    UNIQUE KEY `invoice_item_presets_code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE TABLE `invoice_items`
(
    `invoice_item_id`        int(11) NOT NULL,
    `invoice_id`             int(11) NOT NULL,
    `description`            varchar(255)   NOT NULL,
    `quantity`               decimal(10, 2) NOT NULL DEFAULT 1.00,
    `unit_price_cents`       int(11) NOT NULL,
    `line_total_cents`       int(11) NOT NULL,
    `sort_order`             int(11) NOT NULL DEFAULT 0,
    `created`                datetime       NOT NULL DEFAULT current_timestamp(),
    `modified`               datetime       NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    `invoice_item_preset_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE TABLE `trucks`
(
    `truck_id`          int(11) NOT NULL AUTO_INCREMENT,
    `name`              varchar(100) NOT NULL,
    `rego`              varchar(20)  NOT NULL,
    `truck_size`        varchar(50)           DEFAULT NULL,
    `capacity_m3`       decimal(10, 2)        DEFAULT NULL,
    `max_payload_kg`    decimal(10, 2)        DEFAULT NULL,
    `current_location`  varchar(100)          DEFAULT NULL,
    `next_service_date` date                  DEFAULT NULL,
    `is_active`         tinyint(1) NOT NULL DEFAULT 1,
    `created`           datetime     NOT NULL DEFAULT current_timestamp(),
    `modified`          datetime     NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`truck_id`),
    UNIQUE KEY `trucks_rego` (`rego`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE TABLE `storage_units`
(
    `storage_unit_id`       int(11) NOT NULL AUTO_INCREMENT,
    `unit_code`             varchar(50)  NOT NULL,
    `facility_name`         varchar(100) NOT NULL,
    `unit_size_m3`          decimal(10, 2)        DEFAULT NULL,
    `security_level`        varchar(50)           DEFAULT NULL,
    `is_climate_controlled` tinyint(1) NOT NULL DEFAULT 0,
    `is_active`             tinyint(1) NOT NULL DEFAULT 1,
    `created`               datetime     NOT NULL DEFAULT current_timestamp(),
    `modified`              datetime     NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`storage_unit_id`),
    UNIQUE KEY `storage_units_unit_code` (`unit_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE TABLE `equipment`
(
    `equipment_id`       int(11) NOT NULL AUTO_INCREMENT,
    `name`               varchar(100) NOT NULL,
    `category`           varchar(50)  NOT NULL,
    `quantity_available` int(11) NOT NULL DEFAULT 1,
    `storage_location`   varchar(100)          DEFAULT NULL,
    `condition_notes`    text                  DEFAULT NULL,
    `is_active`          tinyint(1) NOT NULL DEFAULT 1,
    `created`            datetime     NOT NULL DEFAULT current_timestamp(),
    `modified`           datetime     NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`equipment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE TABLE `inventory_items`
(
    `inventory_item_id` int(11) NOT NULL AUTO_INCREMENT,
    `name`              varchar(100) NOT NULL,
    `category`          varchar(50)  NOT NULL,
    `quantity_on_hand`  int(11) NOT NULL DEFAULT 0,
    `reorder_threshold` int(11) NOT NULL DEFAULT 0,
    `unit`              varchar(20)  NOT NULL DEFAULT 'each',
    `storage_location`  varchar(100)          DEFAULT NULL,
    `is_active`         tinyint(1) NOT NULL DEFAULT 1,
    `created`           datetime     NOT NULL DEFAULT current_timestamp(),
    `modified`          datetime     NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`inventory_item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE TABLE `booking_resources`
(
    `booking_resource_id` int(11) NOT NULL AUTO_INCREMENT,
    `booking_id`          int(11) DEFAULT NULL,
    `resource_type`       varchar(30)    NOT NULL,
    `resource_id`         int(11) NOT NULL,
    `quantity`            decimal(10, 2) NOT NULL DEFAULT 1.00,
    `notes`               text                    DEFAULT NULL,
    `created`             datetime       NOT NULL DEFAULT current_timestamp(),
    `modified`            datetime       NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`booking_resource_id`),
    KEY                   `booking_resources_booking_id` (`booking_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE TABLE `job_trucks` (
                              `job_truck_id` INT(11) NOT NULL AUTO_INCREMENT,
                              `job_id` INT(11) NOT NULL,
                              `truck_id` INT(11) NOT NULL,
                              `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

                              PRIMARY KEY (`job_truck_id`),

                              KEY `job_trucks_job_id` (`job_id`),
                              KEY `job_trucks_truck_id` (`truck_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

INSERT INTO `contact_forms`
(`contact_form_id`, `customer_id`, `subject`, `message`, `created`, `status`, `admin_reply`, `replied_at`)
VALUES (1, 1, 'Quote for apartment move',
        'Hi, I would like a quote for moving a 2-bedroom apartment from Clayton to Melbourne.', '2026-04-18 09:30:00',
        'replied', 'Thanks Emily. We have sent you a preliminary quote and will confirm availability shortly.',
        '2026-04-18 11:05:00'),
       (2, 2, 'Short-term storage question', 'Do you offer storage for furniture while renovations are happening?',
        '2026-04-18 13:20:00', 'replied',
        'Yes, we offer short-term storage options. We can include this in your quote.', '2026-04-18 15:10:00'),
       (3, 3, 'Office relocation availability',
        'We need help moving office equipment next week. Are morning slots available?', '2026-04-19 08:45:00', 'new',
        NULL, NULL),
       (4, 4, 'Transfer booking request', 'Can you transfer packed boxes from South Yarra to Carlton?',
        '2026-04-19 12:00:00', 'replied', 'Yes, we can assist with transfer jobs. Please provide your preferred date.',
        '2026-04-19 14:35:00'),
       (5, 5, 'Fragile items handling', 'I have glassware and framed artwork. Can your movers handle fragile items?',
        '2026-04-20 10:25:00', 'new', NULL, NULL),
       (6, 6, 'Storage unit size', 'What storage unit size would suit a studio apartment?', '2026-04-20 16:15:00',
        'replied', 'A small to medium unit is usually suitable for a studio apartment.', '2026-04-20 17:40:00'),
       (7, 7, 'Packing materials', 'Can I request wardrobe boxes and packing tape with my booking?',
        '2026-04-21 09:10:00', 'new', NULL, NULL),
       (8, 8, 'Student move inquiry', 'I am moving from Bundoora to the city and only have a few furniture items.',
        '2026-04-21 13:55:00', 'replied',
        'We can help with smaller student moves. Please submit a booking request online.', '2026-04-21 15:25:00'),
       (9, 9, 'Large family move', 'We are moving a family home and need help with heavy furniture.',
        '2026-04-22 11:35:00', 'new', NULL, NULL),
       (10, 10, 'Storage before settlement', 'Can my items be stored for two weeks before delivery to my new address?',
        '2026-04-22 14:50:00', 'replied', 'Yes, we can arrange storage before final delivery.', '2026-04-22 16:20:00');

INSERT INTO `contact_form_replies`
(`contact_form_id`, `sender_type`, `message`, `created`)
SELECT
    `contact_form_id`,
    'customer',
    `message`,
    `created`
FROM `contact_forms`;

INSERT INTO `contact_form_replies`
(`contact_form_id`, `sender_type`, `message`, `created`)
SELECT
    `contact_form_id`,
    'admin',
    `admin_reply`,
    `replied_at`
FROM `contact_forms`
WHERE `admin_reply` IS NOT NULL;

INSERT INTO `customers`
(`customer_id`, `first_name`, `last_name`, `email`, `phone`)
VALUES (1, 'Emily', 'Carter', 'emily.carter@example.com', '0412345678'),
       (2, 'Liam', 'Nguyen', 'liam.nguyen@example.com', '0423456789'),
       (3, 'Sophie', 'Patel', 'sophie.patel@example.com', '0434567890'),
       (4, 'Daniel', 'Reyes', 'daniel.reyes@example.com', '0445678901'),
       (5, 'Mia', 'Thompson', 'mia.thompson@example.com', '0456789012'),
       (6, 'Joshua', 'Tan', 'joshua.tan@example.com', '0467890123'),
       (7, 'Hannah', 'Lim', 'hannah.lim@example.com', '0478901234'),
       (8, 'Noah', 'Brown', 'noah.brown@example.com', '0489012345'),
       (9, 'Ava', 'Williams', 'ava.williams@example.com', '0490123456'),
       (10, 'Marcus', 'Smith', 'marcus.smith@example.com', '0401234567');

INSERT INTO `job_types`
(`job_type_id`, `job_type_name`, `job_type_description`)
VALUES (1, 'Removal', 'Removal of items from customer'),
       (2, 'Storage', 'Storage of items from customer'),
       (3, 'Transfer', 'Transfer of items for customer');

INSERT INTO `jobs`
(`job_id`, `job_type_id`, `description`, `pickup_address`, `dropoff_address`, `job_date`, `job_time`, `customer_id`)
VALUES (1, 1, 'Move 2-bedroom apartment including fridge, sofa, washing machine, and boxes.',
        '12 King Street, Clayton VIC 3168', '88 Collins Street, Melbourne VIC 3000', '2026-05-01', '09:00:00', 1),
       (2, 2, 'Store household furniture and personal boxes during apartment renovation.',
        '5 Princes Highway, Dandenong VIC 3175', 'Unit 4, Storage Hub, Springvale VIC 3171', '2026-05-02', '13:30:00',
        2),
       (3, 1, 'Office equipment relocation including desks, monitors, and chairs.',
        '21 Wellington Road, Mulgrave VIC 3170', '9 Queen Street, Melbourne VIC 3000', '2026-05-03', '08:15:00', 3),
       (4, 3, 'Transfer packed boxes between rental properties.', '44 Chapel Street, South Yarra VIC 3141',
        '72 Lygon Street, Carlton VIC 3053', '2026-05-04', '10:30:00', 4),
       (5, 1, 'Move 2-bedroom unit with lift access and fragile items.', '18 High Street, Glen Iris VIC 3146',
        '120 Burke Road, Camberwell VIC 3124', '2026-05-05', '11:00:00', 5),
       (6, 2, 'Store boxes and small appliances from a studio apartment.', '7 Sydney Road, Brunswick VIC 3056',
        'Storage King, Preston VIC 3072', '2026-05-06', '14:00:00', 6),
       (7, 1, 'Move apartment furniture and provide wardrobe boxes.', '33 Bay Street, Port Melbourne VIC 3207',
        '54 Smith Street, Collingwood VIC 3066', '2026-05-07', '09:45:00', 7),
       (8, 3, 'Transfer student room furniture and personal boxes.', '90 Plenty Road, Bundoora VIC 3083',
        '27 Swanston Street, Melbourne VIC 3000', '2026-05-08', '12:15:00', 8),
       (9, 1, 'Move family home furniture including outdoor setting and dining table.', '14 Main Road, Eltham VIC 3095',
        '65 Toorak Road, Toorak VIC 3142', '2026-05-09', '08:30:00', 9),
       (10, 2, 'Store household items while customer waits for property settlement.',
        '101 Bridge Road, Richmond VIC 3121', 'Secure Store, Moorabbin VIC 3189', '2026-05-10', '15:30:00', 10);

INSERT INTO `users`
(`user_id`, `phone`, `email`, `password`, `first_name`, `last_name`, `user_type`)
VALUES (1, '0411111111', 'customer@myapp.local', '$2y$12$O2mUGRcOpX4i.RgsD0Dofe9hmwPLsxC.teN0iMwi7a9Dx0ainBcum', 'Alex',
        'Morgan', 3),
       (2, '0422222222', 'staff@myapp.local', '$2y$12$uVkWd9a7/30M6Zc3CZ8Ou.NOtS2NHNaB8pdaZbmwq8gvFCjjnICse', 'Jordan',
        'Lee', 2),
       (3, '0433333333', 'admin@test.com', '$2y$12$xGvQK7AIhGg7iytP8aIEjOV1pm4Ev7hmJweuns1iNDkYW4VI69ipS', 'Alice',
        'Admin', 1),
       (4, '0444444444', 'driver@staff.com', '$2y$12$bXFuHfh4UdmDlcC/c7wblus5E1Kel3LiThtfpGv3xxaWlU/lLwPQ6', 'Uba',
        'Driver', 2);

INSERT INTO `user_types`
(`user_type_id`, `name`, `description`)
VALUES (1, 'Admin', 'Full system access'),
       (2, 'Staff', 'Operational staff member'),
       (3, 'Customer', 'Handles customer communication and enquiries');

INSERT INTO `invoice_item_presets`
(`code`, `name`, `description`, `unit_price_cents`, `sort_order`)
VALUES ('labour_hour', 'Labour', 'Labour - per hour', 8500, 1),
       ('truck_small', 'Small truck', 'Truck rental - small truck', 18000, 2),
       ('truck_large', 'Large truck', 'Truck rental - large truck', 28000, 3),
       ('packing_materials', 'Packing materials', 'Packing materials', 5000, 4),
       ('stairs_surcharge', 'Stairs surcharge', 'Stairs surcharge', 7500, 5);

INSERT INTO `trucks`
(`name`, `rego`, `truck_size`, `capacity_m3`, `max_payload_kg`, `current_location`)
VALUES ('Truck 1', '1ABC123', 'Small', 20.00, 2000.00, 'Clayton Depot'),
       ('Truck 2', '1DEF456', 'Large', 35.00, 4000.00, 'Springvale Depot');

INSERT INTO storage_units
(unit_code, facility_name, unit_size_m3, security_level, is_climate_controlled)
VALUES ('A01', 'Springvale Storage', 12.00, 'standard', 0),
       ('B14', 'Moorabbin Storage', 25.00, 'high', 1);

INSERT INTO `equipment`
(`name`, `category`, `quantity_available`, `storage_location`)
VALUES ('Heavy-duty trolley', 'Trolley', 4,  'Clayton Depot'),
       ('Moving blanket', 'Protective', 20, 'Clayton Depot'),
       ('Ratchet strap', 'Securing', 15, 'Springvale Depot');

INSERT INTO `inventory_items`
(`name`, `category`, `quantity_on_hand`, `reorder_threshold`, `unit`, `storage_location`)
VALUES ('Small box', 'Boxes', 100, 20, 'each', 'Warehouse Shelf A'),
       ('Packing tape', 'Packing', 60, 10, 'roll', 'Warehouse Shelf B'),
       ('Bubble wrap', 'Packing', 25, 5, 'roll', 'Warehouse Shelf C');

INSERT INTO `staff` (`staff_id`,`first_name`,`last_name`,`email`,`phone`,`isDriver`)
VALUES (1,'Jordan','Lee', 'staff@myapp.local', '0422222222', 0),
       (2,'Uba', 'Driver', 'driver@staff.com', '0444444444', 1);

INSERT INTO `content_blocks` (`id`, `parent`, `slug`, `label`, `description`, `type`, `value`, `previous_value`,
                              `modified`)
VALUES (1, 'global', 'website-title-main', 'Website Title (Main)',
        'Shown on the home page, as well  as any tabs in the users browser.', 'text', 'Move done right,', NULL,
        '2026-05-03 06:54:39'),
       (2, 'global', 'website-title-accent', 'Website Title (Accent)',
        'Shown on the home page, as well as any tabs in the users browser.', 'text', 'any time of day.', NULL,
        '2026-05-03 06:54:55'),
       (3, 'global', 'logo', 'Logo',
        'Shown in the centre of the home page, and also in the top corner of all administration pages.', 'image', 'company-logo.png',
        NULL, '2026-05-03 06:53:07'),
       (4, 'global', 'phone-contact-footer', 'Phone Number (footer)',
        'Shown in the footer of every pages.', 'text',
        '0412 345 678', NULL, '2026-05-03 06:53:07'),
       (5, 'global', 'email-contact-footer', 'Email (Footer)', 'Shown in the footer of every pages.',
        'text', 'hello@movinghouse247.com.au', NULL,
        '2026-05-03 06:53:07'),
       (6, 'home', 'home-content', 'Home Page Content',
        'Copyright information shown at the bottom of the home page.', 'text',
        'The main content shown in the centre of the home page.', '<p>Example app showcasing the <code>ugie-cake/cakephp-content-blocks</code> plugin.</p>' ,
        '2026-05-03 06:53:07');

INSERT INTO `content_blocks_phinxlog` (`version`, `migration_name`, `start_time`, `end_time`, `breakpoint`)
VALUES (20230402063959, 'ContentBlocksMigration', '2026-05-02 11:25:48', '2026-05-02 11:25:48', 0);

ALTER TABLE `staff`
    ADD PRIMARY KEY (`staff_id`),
    ADD KEY `email` (`email`);

ALTER TABLE `staff_job`
    ADD PRIMARY KEY (`allocation_id`);

ALTER TABLE `content_blocks`
    ADD PRIMARY KEY (`id`);

ALTER TABLE `content_blocks_phinxlog`
    ADD PRIMARY KEY (`version`);

ALTER TABLE `customers`
    ADD PRIMARY KEY (`customer_id`),
    ADD KEY `email` (`email`);

ALTER TABLE `jobs`
    ADD PRIMARY KEY (`job_id`),
    ADD KEY `job_type_id` (`job_type_id`),
    ADD KEY `customer_id` (`customer_id`);

ALTER TABLE `job_types`
    ADD PRIMARY KEY (`job_type_id`);

ALTER TABLE `phinxlog`
    ADD PRIMARY KEY (`version`);

ALTER TABLE `users`
    ADD PRIMARY KEY (`user_id`),
    ADD KEY `users_user_type_id` (`user_type`);

ALTER TABLE `user_types`
    ADD PRIMARY KEY (`user_type_id`);

ALTER TABLE `bookings`
    ADD PRIMARY KEY (`booking_id`);

ALTER TABLE `contact_forms`
    ADD PRIMARY KEY (`contact_form_id`);

ALTER TABLE `invoices`
    ADD PRIMARY KEY (`invoice_id`);

ALTER TABLE `invoice_items`
    ADD PRIMARY KEY (`invoice_item_id`);

ALTER TABLE `staff`
    MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `availability`
    MODIFY `availability_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `staff_job`
    MODIFY `allocation_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `customers`
    MODIFY `customer_id` int (11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `jobs`
    MODIFY `job_id` int (11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `job_types`
    MODIFY `job_type_id` int (1) NOT NULL AUTO_INCREMENT;

ALTER TABLE `users`
    MODIFY `user_id` int (11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `user_types`
    MODIFY `user_type_id` int (11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `bookings`
    MODIFY `booking_id` int (11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `contact_forms`
    MODIFY `contact_form_id` int (11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `content_blocks`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

ALTER TABLE `customers`
    MODIFY `customer_id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

ALTER TABLE `invoices`
    MODIFY `invoice_id` int (11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `invoice_items`
    MODIFY `invoice_item_id` int (11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `contact_form_replies`
    ADD CONSTRAINT `contact_form_replies_contact_form_id`
        FOREIGN KEY (`contact_form_id`)
            REFERENCES `contact_forms` (`contact_form_id`)
            ON DELETE CASCADE;

ALTER TABLE `contact_forms`
    ADD CONSTRAINT `contact_forms_customer_id`
        FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`);

ALTER TABLE `availability`
    ADD CONSTRAINT `staff_availability_id`
        FOREIGN KEY (`staff_id`) REFERENCES `staff` (`staff_id`);

ALTER TABLE `jobs`
    ADD CONSTRAINT `jobs_customer_id`
        FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`),
    ADD CONSTRAINT `jobs_job_type_id`
    FOREIGN KEY (`job_type_id`) REFERENCES `job_types` (`job_type_id`);

ALTER TABLE `users`
    ADD CONSTRAINT `users_user_type_id`
        FOREIGN KEY (`user_type`) REFERENCES `user_types` (`user_type_id`);

ALTER TABLE `bookings`
    ADD CONSTRAINT `bookings_customer_id`
        FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`),
    ADD CONSTRAINT `bookings_job_type_id`
    FOREIGN KEY (`job_type_id`) REFERENCES `job_types` (`job_type_id`);

ALTER TABLE `invoices`
    ADD CONSTRAINT `invoices_customer_id`
        FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`),
    ADD CONSTRAINT `invoices_booking_id`
    FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`booking_id`);

ALTER TABLE `invoice_items`
    ADD CONSTRAINT `invoice_item_invoice_id`
        FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`invoice_id`),
    ADD CONSTRAINT `invoice_item_preset_id`
    FOREIGN KEY (`invoice_item_preset_id`) REFERENCES `invoice_item_presets` (`invoice_item_preset_id`);

ALTER TABLE `booking_resources`
    ADD CONSTRAINT `booking_resources_booking_id`
        FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`booking_id`);

ALTER TABLE `staff_job`
    ADD CONSTRAINT `staff_job_staff_id`
        FOREIGN KEY (`staff_id`) REFERENCES `staff` (`staff_id`),
    ADD CONSTRAINT `staff_job_job_id`
        FOREIGN KEY (`job_id`) REFERENCES `jobs` (`job_id`);

ALTER TABLE jobs
    ADD allocated_at DATETIME NULL,
ADD cancelled_at DATETIME NULL;

ALTER TABLE jobs
    ADD status VARCHAR(20) NOT NULL DEFAULT 'Pending',
    ADD driver_required INT NOT NULL DEFAULT 0,
    ADD porter_required INT NOT NULL DEFAULT 0;

ALTER TABLE job_trucks
    ADD CONSTRAINT `job_trucks_job_id_fk`
        FOREIGN KEY (`job_id`) REFERENCES `jobs` (`job_id`),

    ADD CONSTRAINT `job_trucks_truck_id_fk`
        FOREIGN KEY (`truck_id`) REFERENCES `trucks` (`truck_id`);

-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 03, 2026 at 05:05 PM
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
-- Database: `fit3047`
--

-- --------------------------------------------------------
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS `content_blocks`;
DROP TABLE IF EXISTS `content_blocks_phinxlog`;
DROP TABLE IF EXISTS `phinxlog`;
DROP TABLE IF EXISTS `booking_resources`;
DROP TABLE IF EXISTS `invoice_items`;
DROP TABLE IF EXISTS `invoice_item_presets`;
DROP TABLE IF EXISTS `invoices`;
DROP TABLE IF EXISTS `contact_form_replies`;
DROP TABLE IF EXISTS `contact_forms`;
DROP TABLE IF EXISTS `jobs`;
DROP TABLE IF EXISTS `trucks`;
DROP TABLE IF EXISTS `storage_units`;
DROP TABLE IF EXISTS `equipment`;
DROP TABLE IF EXISTS `inventory_items`;
DROP TABLE IF EXISTS `bookings`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `customers`;
DROP TABLE IF EXISTS `job_types`;
DROP TABLE IF EXISTS `user_types`;
DROP TABLE IF EXISTS `phinxlog`;
DROP TABLE IF EXISTS `staff`;
DROP TABLE IF EXISTS `staff_job`;
DROP TABLE IF EXISTS `availability`;
DROP TABLE IF EXISTS `job_trucks`;
DROP TABLE IF EXISTS `job_resources`;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE `staff`
(
    `staff_id` int(11) NOT NULL,
    `first_name`  varchar(50) NOT NULL,
    `last_name`   varchar(50) NOT NULL,
    `email`       varchar(62) NOT NULL,
    `phone`       varchar(15) NOT NULL,
    `isDriver`    tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE TABLE `availability`
(
    `availability_id` int(11) NOT NULL AUTO_INCREMENT,
    `staff_id` int(11) NOT NULL,
    `start_datetime` datetime NOT NULL,
    `end_datetime` datetime NOT NULL,

    PRIMARY KEY (`availability_id`),
    KEY `availability_staff_id` (`staff_id`)

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE TABLE `staff_job`
(
    `allocation_id` int(11) NOT NULL,
    `staff_id` int(11) NOT NULL,
    `job_id`  int(11) NOT NULL,
    `status` ENUM('Waiting', 'Confirmed', 'Rejected') NOT NULL DEFAULT 'Waiting'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE TABLE `content_blocks`
(
    `id`             int(11) NOT NULL,
    `parent`         varchar(128) NOT NULL,
    `slug`           varchar(128) NOT NULL,
    `label`          varchar(255) NOT NULL,
    `description`    varchar(255) NOT NULL,
    `type`           varchar(32)  NOT NULL,
    `value`          text                  DEFAULT NULL,
    `previous_value` text                  DEFAULT NULL,
    `modified`       timestamp    NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;


CREATE TABLE `content_blocks_phinxlog`
(
    `version`        bigint(20) NOT NULL,
    `migration_name` varchar(100) DEFAULT NULL,
    `start_time`     timestamp NULL DEFAULT NULL,
    `end_time`       timestamp NULL DEFAULT NULL,
    `breakpoint`     tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE TABLE `phinxlog`
(
    `version`        bigint(20) NOT NULL,
    `migration_name` varchar(100) DEFAULT NULL,
    `start_time`     timestamp NULL DEFAULT NULL,
    `end_time`       timestamp NULL DEFAULT NULL,
    `breakpoint`     tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE TABLE `contact_forms`
(
    `contact_form_id` int(11) NOT NULL,
    `customer_id`     int(11) NOT NULL,
    `subject`         varchar(100) NOT NULL,
    `message`         text         NOT NULL,
    `created`         datetime     NOT NULL DEFAULT current_timestamp(),
    `status`          varchar(20)  NOT NULL DEFAULT 'new',
    `admin_reply`     text                  DEFAULT NULL,
    `replied_at`      datetime              DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE TABLE `contact_form_replies`
(
    `contact_form_reply_id` int(11) NOT NULL AUTO_INCREMENT,
    `contact_form_id`       int(11) NOT NULL,
    `sender_type`           varchar(20) NOT NULL,
    `message`               text NOT NULL,
    `created`               datetime NOT NULL DEFAULT current_timestamp(),
    `modified`              datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`contact_form_reply_id`),
    KEY `contact_form_replies_contact_form_id` (`contact_form_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE TABLE `customers`
(
    `customer_id` int(11) NOT NULL,
    `first_name`  varchar(50) NOT NULL,
    `last_name`   varchar(50) NOT NULL,
    `email`       varchar(62) NOT NULL,
    `phone`       varchar(15) NOT NULL,
    `stripe_id`   varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE TABLE `jobs`
(
    `job_id`          int(11) NOT NULL,
    `job_type_id`     int(1) NOT NULL,
    `description`     text        NOT NULL,
    `pickup_address`  varchar(95) NOT NULL,
    `dropoff_address` varchar(95) NULL,
    `job_date`        date        NOT NULL,
    `job_time`        time        NOT NULL,
    `customer_id`     int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE TABLE `job_types`
(
    `job_type_id`          int(1) NOT NULL,
    `job_type_name`        varchar(20) NOT NULL,
    `job_type_description` text        NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE TABLE `bookings`
(
    `booking_id`        int(11) NOT NULL,
    `customer_id`       int(11) NOT NULL,
    `job_type_id`       int(1) NOT NULL,
    `pickup_address`    varchar(95) NOT NULL,
    `dropoff_address`   varchar(95) NOT NULL,
    `job_date`          date        NOT NULL,
    `job_time`          time        NOT NULL,
    `status`            varchar(20) NOT NULL DEFAULT 'Pending',
    `created`           datetime    NOT NULL DEFAULT current_timestamp(),
    `message`           text                 DEFAULT NULL,
    `accepted_notified` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE TABLE `users`
(
    `user_id`    int(11) NOT NULL,
    `email`      varchar(62)  NOT NULL,
    `phone`      varchar(15)  NOT NULL,
    `password`   varchar(255) NOT NULL,
    `first_name` varchar(46)  NOT NULL,
    `last_name`  varchar(46)  NOT NULL,
    `user_type`  int(1) NOT NULL,
    `reset_id`   varchar(20) DEFAULT NULL,
    `time_limit` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE TABLE `user_types`
(
    `user_type_id` int(11) NOT NULL,
    `name`         varchar(20) NOT NULL,
    `description`  text        NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE TABLE `invoices`
(
    `invoice_id`        int(11) NOT NULL,
    `booking_id`        int(11) NOT NULL,
    `customer_id`       int(11) NOT NULL,
    `stripe_invoice_id` varchar(255)         DEFAULT NULL,
    `invoice_url`       text                 DEFAULT NULL,
    `status`            varchar(50) NOT NULL DEFAULT 'draft',
    `subtotal_cents`    int(11) DEFAULT NULL,
    `total_cents`       int(11) DEFAULT NULL,
    `due_date`          date                 DEFAULT NULL,
    `sent_at`           datetime             DEFAULT NULL,
    `paid_at`           datetime             DEFAULT NULL,
    `created`           datetime    NOT NULL DEFAULT current_timestamp(),
    `modified`          datetime    NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE TABLE `invoice_item_presets`
(
    `invoice_item_preset_id` int(11) NOT NULL AUTO_INCREMENT,
    `code`                   varchar(50)  NOT NULL,
    `name`                   varchar(100) NOT NULL,
    `description`            varchar(255) NOT NULL,
    `unit_price_cents`       int(11) NOT NULL,
    `is_active`              tinyint(1) NOT NULL DEFAULT 1,
    `sort_order`             int(11) NOT NULL DEFAULT 0,
    `created`                datetime     NOT NULL DEFAULT current_timestamp(),
    `modified`               datetime     NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`invoice_item_preset_id`),
    UNIQUE KEY `invoice_item_presets_code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE TABLE `invoice_items`
(
    `invoice_item_id`        int(11) NOT NULL,
    `invoice_id`             int(11) NOT NULL,
    `description`            varchar(255)   NOT NULL,
    `quantity`               decimal(10, 2) NOT NULL DEFAULT 1.00,
    `unit_price_cents`       int(11) NOT NULL,
    `line_total_cents`       int(11) NOT NULL,
    `sort_order`             int(11) NOT NULL DEFAULT 0,
    `created`                datetime       NOT NULL DEFAULT current_timestamp(),
    `modified`               datetime       NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    `invoice_item_preset_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE TABLE `trucks`
(
    `truck_id`          int(11) NOT NULL AUTO_INCREMENT,
    `name`              varchar(100) NOT NULL,
    `rego`              varchar(20)  NOT NULL,
    `truck_size`        varchar(50)           DEFAULT NULL,
    `capacity_m3`       decimal(10, 2)        DEFAULT NULL,
    `max_payload_kg`    decimal(10, 2)        DEFAULT NULL,
    `status` varchar(30) NOT NULL DEFAULT 'available',
    `current_location`  varchar(100)          DEFAULT NULL,
    `next_service_date` date                  DEFAULT NULL,
    `is_active`         tinyint(1) NOT NULL DEFAULT 1,
    `created`           datetime     NOT NULL DEFAULT current_timestamp(),
    `modified`          datetime     NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`truck_id`),
    UNIQUE KEY `trucks_rego` (`rego`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE TABLE `storage_units`
(
    `storage_unit_id`       int(11) NOT NULL AUTO_INCREMENT,
    `unit_code`             varchar(50)  NOT NULL,
    `facility_name`         varchar(100) NOT NULL,
    `unit_size_m3`          decimal(10, 2)        DEFAULT NULL,
    `security_level`        varchar(50)           DEFAULT NULL,
    `is_climate_controlled` tinyint(1) NOT NULL DEFAULT 0,
    `is_active`             tinyint(1) NOT NULL DEFAULT 1,
    `created`               datetime     NOT NULL DEFAULT current_timestamp(),
    `modified`              datetime     NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`storage_unit_id`),
    UNIQUE KEY `storage_units_unit_code` (`unit_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE TABLE `equipment`
(
    `equipment_id`       int(11) NOT NULL AUTO_INCREMENT,
    `name`               varchar(100) NOT NULL,
    `category`           varchar(50)  NOT NULL,
    `quantity_available` int(11) NOT NULL DEFAULT 1,
    `storage_location`   varchar(100)          DEFAULT NULL,
    `condition_notes`    text                  DEFAULT NULL,
    `is_active`          tinyint(1) NOT NULL DEFAULT 1,
    `created`            datetime     NOT NULL DEFAULT current_timestamp(),
    `modified`           datetime     NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`equipment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE TABLE `inventory_items`
(
    `inventory_item_id` int(11) NOT NULL AUTO_INCREMENT,
    `name`              varchar(100) NOT NULL,
    `category`          varchar(50)  NOT NULL,
    `quantity_on_hand`  int(11) NOT NULL DEFAULT 0,
    `reorder_threshold` int(11) NOT NULL DEFAULT 0,
    `unit`              varchar(20)  NOT NULL DEFAULT 'each',
    `storage_location`  varchar(100)          DEFAULT NULL,
    `is_active`         tinyint(1) NOT NULL DEFAULT 1,
    `created`           datetime     NOT NULL DEFAULT current_timestamp(),
    `modified`          datetime     NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`inventory_item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE TABLE `booking_resources`
(
    `booking_resource_id` int(11) NOT NULL AUTO_INCREMENT,
    `booking_id`          int(11) DEFAULT NULL,
    `resource_type`       varchar(30)    NOT NULL,
    `resource_id`         int(11) NOT NULL,
    `quantity`            decimal(10, 2) NOT NULL DEFAULT 1.00,
    `notes`               text                    DEFAULT NULL,
    `created`             datetime       NOT NULL DEFAULT current_timestamp(),
    `modified`            datetime       NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`booking_resource_id`),
    KEY                   `booking_resources_booking_id` (`booking_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE TABLE `job_trucks` (
                              `job_truck_id` INT(11) NOT NULL AUTO_INCREMENT,
                              `job_id` INT(11) NOT NULL,
                              `truck_id` INT(11) NOT NULL,
                              `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

                              PRIMARY KEY (`job_truck_id`),

                              KEY `job_trucks_job_id` (`job_id`),
                              KEY `job_trucks_truck_id` (`truck_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE TABLE `job_resources` (
                                 `job_resource_id` int(11) NOT NULL AUTO_INCREMENT,
                                 `job_id` int(11) NOT NULL,
                                 `truck_id` int(11) DEFAULT NULL,
                                 `equipment_id` int(11) DEFAULT NULL,
                                 `storage_unit_id` int(11) DEFAULT NULL,
                                 `inventory_id` int(11) DEFAULT NULL,
                                 `quantity` decimal(10,2) NOT NULL DEFAULT 1.00,

                                 PRIMARY KEY (`job_resource_id`),
                                 KEY `job_resources_job_id` (`job_id`),
                                 KEY `job_resources_truck_id` (`truck_id`),
                                 KEY `job_resources_equipment_id` (`equipment_id`),
                                 KEY `job_resources_storage_unit_id` (`storage_unit_id`),
                                 KEY `job_resources_inventory_id` (`inventory_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

INSERT INTO `contact_forms`
(`contact_form_id`, `customer_id`, `subject`, `message`, `created`, `status`, `admin_reply`, `replied_at`)
VALUES (1, 1, 'Quote for apartment move',
        'Hi, I would like a quote for moving a 2-bedroom apartment from Clayton to Melbourne.', '2026-04-18 09:30:00',
        'replied', 'Thanks Emily. We have sent you a preliminary quote and will confirm availability shortly.',
        '2026-04-18 11:05:00'),
       (2, 2, 'Short-term storage question', 'Do you offer storage for furniture while renovations are happening?',
        '2026-04-18 13:20:00', 'replied',
        'Yes, we offer short-term storage options. We can include this in your quote.', '2026-04-18 15:10:00'),
       (3, 3, 'Office relocation availability',
        'We need help moving office equipment next week. Are morning slots available?', '2026-04-19 08:45:00', 'new',
        NULL, NULL),
       (4, 4, 'Transfer booking request', 'Can you transfer packed boxes from South Yarra to Carlton?',
        '2026-04-19 12:00:00', 'replied', 'Yes, we can assist with transfer jobs. Please provide your preferred date.',
        '2026-04-19 14:35:00'),
       (5, 5, 'Fragile items handling', 'I have glassware and framed artwork. Can your movers handle fragile items?',
        '2026-04-20 10:25:00', 'new', NULL, NULL),
       (6, 6, 'Storage unit size', 'What storage unit size would suit a studio apartment?', '2026-04-20 16:15:00',
        'replied', 'A small to medium unit is usually suitable for a studio apartment.', '2026-04-20 17:40:00'),
       (7, 7, 'Packing materials', 'Can I request wardrobe boxes and packing tape with my booking?',
        '2026-04-21 09:10:00', 'new', NULL, NULL),
       (8, 8, 'Student move inquiry', 'I am moving from Bundoora to the city and only have a few furniture items.',
        '2026-04-21 13:55:00', 'replied',
        'We can help with smaller student moves. Please submit a booking request online.', '2026-04-21 15:25:00'),
       (9, 9, 'Large family move', 'We are moving a family home and need help with heavy furniture.',
        '2026-04-22 11:35:00', 'new', NULL, NULL),
       (10, 10, 'Storage before settlement', 'Can my items be stored for two weeks before delivery to my new address?',
        '2026-04-22 14:50:00', 'replied', 'Yes, we can arrange storage before final delivery.', '2026-04-22 16:20:00');

INSERT INTO `contact_form_replies`
(`contact_form_id`, `sender_type`, `message`, `created`)
SELECT
    `contact_form_id`,
    'customer',
    `message`,
    `created`
FROM `contact_forms`;

INSERT INTO `contact_form_replies`
(`contact_form_id`, `sender_type`, `message`, `created`)
SELECT
    `contact_form_id`,
    'admin',
    `admin_reply`,
    `replied_at`
FROM `contact_forms`
WHERE `admin_reply` IS NOT NULL;

INSERT INTO `customers`
(`customer_id`, `first_name`, `last_name`, `email`, `phone`)
VALUES (1, 'Emily', 'Carter', 'emily.carter@example.com', '0412345678'),
       (2, 'Liam', 'Nguyen', 'liam.nguyen@example.com', '0423456789'),
       (3, 'Sophie', 'Patel', 'sophie.patel@example.com', '0434567890'),
       (4, 'Daniel', 'Reyes', 'daniel.reyes@example.com', '0445678901'),
       (5, 'Mia', 'Thompson', 'mia.thompson@example.com', '0456789012'),
       (6, 'Joshua', 'Tan', 'joshua.tan@example.com', '0467890123'),
       (7, 'Hannah', 'Lim', 'hannah.lim@example.com', '0478901234'),
       (8, 'Noah', 'Brown', 'noah.brown@example.com', '0489012345'),
       (9, 'Ava', 'Williams', 'ava.williams@example.com', '0490123456'),
       (10, 'Marcus', 'Smith', 'marcus.smith@example.com', '0401234567');

INSERT INTO `job_types`
(`job_type_id`, `job_type_name`, `job_type_description`)
VALUES (1, 'Removal', 'Removal of items from customer'),
       (2, 'Storage', 'Storage of items from customer'),
       (3, 'Transfer', 'Transfer of items for customer');

INSERT INTO `jobs`
(`job_id`, `job_type_id`, `description`, `pickup_address`, `dropoff_address`, `job_date`, `job_time`, `customer_id`)
VALUES (1, 1, 'Move 2-bedroom apartment including fridge, sofa, washing machine, and boxes.',
        '12 King Street, Clayton VIC 3168', '88 Collins Street, Melbourne VIC 3000', '2026-05-01', '09:00:00', 1),
       (2, 2, 'Store household furniture and personal boxes during apartment renovation.',
        '5 Princes Highway, Dandenong VIC 3175', 'Unit 4, Storage Hub, Springvale VIC 3171', '2026-05-02', '13:30:00',
        2),
       (3, 1, 'Office equipment relocation including desks, monitors, and chairs.',
        '21 Wellington Road, Mulgrave VIC 3170', '9 Queen Street, Melbourne VIC 3000', '2026-05-03', '08:15:00', 3),
       (4, 3, 'Transfer packed boxes between rental properties.', '44 Chapel Street, South Yarra VIC 3141',
        '72 Lygon Street, Carlton VIC 3053', '2026-05-04', '10:30:00', 4),
       (5, 1, 'Move 2-bedroom unit with lift access and fragile items.', '18 High Street, Glen Iris VIC 3146',
        '120 Burke Road, Camberwell VIC 3124', '2026-05-05', '11:00:00', 5),
       (6, 2, 'Store boxes and small appliances from a studio apartment.', '7 Sydney Road, Brunswick VIC 3056',
        'Storage King, Preston VIC 3072', '2026-05-06', '14:00:00', 6),
       (7, 1, 'Move apartment furniture and provide wardrobe boxes.', '33 Bay Street, Port Melbourne VIC 3207',
        '54 Smith Street, Collingwood VIC 3066', '2026-05-07', '09:45:00', 7),
       (8, 3, 'Transfer student room furniture and personal boxes.', '90 Plenty Road, Bundoora VIC 3083',
        '27 Swanston Street, Melbourne VIC 3000', '2026-05-08', '12:15:00', 8),
       (9, 1, 'Move family home furniture including outdoor setting and dining table.', '14 Main Road, Eltham VIC 3095',
        '65 Toorak Road, Toorak VIC 3142', '2026-05-09', '08:30:00', 9),
       (10, 2, 'Store household items while customer waits for property settlement.',
        '101 Bridge Road, Richmond VIC 3121', 'Secure Store, Moorabbin VIC 3189', '2026-05-10', '15:30:00', 10);

INSERT INTO `users`
(`user_id`, `phone`, `email`, `password`, `first_name`, `last_name`, `user_type`)
VALUES (1, '0411111111', 'customer@myapp.local', '$2y$12$O2mUGRcOpX4i.RgsD0Dofe9hmwPLsxC.teN0iMwi7a9Dx0ainBcum', 'Alex',
        'Morgan', 3),
       (2, '0422222222', 'staff@myapp.local', '$2y$12$uVkWd9a7/30M6Zc3CZ8Ou.NOtS2NHNaB8pdaZbmwq8gvFCjjnICse', 'Jordan',
        'Lee', 2),
       (3, '0433333333', 'admin@test.com', '$2y$12$xGvQK7AIhGg7iytP8aIEjOV1pm4Ev7hmJweuns1iNDkYW4VI69ipS', 'Alice',
        'Admin', 1),
       (4, '0444444444', 'driver@staff.com', '$2y$12$bXFuHfh4UdmDlcC/c7wblus5E1Kel3LiThtfpGv3xxaWlU/lLwPQ6', 'Uba',
        'Driver', 2);

INSERT INTO `user_types`
(`user_type_id`, `name`, `description`)
VALUES (1, 'Admin', 'Full system access'),
       (2, 'Staff', 'Operational staff member'),
       (3, 'Customer', 'Handles customer communication and enquiries');

INSERT INTO `invoice_item_presets`
(`code`, `name`, `description`, `unit_price_cents`, `sort_order`)
VALUES ('labour_hour', 'Labour', 'Labour - per hour', 8500, 1),
       ('truck_small', 'Small truck', 'Truck rental - small truck', 18000, 2),
       ('truck_large', 'Large truck', 'Truck rental - large truck', 28000, 3),
       ('packing_materials', 'Packing materials', 'Packing materials', 5000, 4),
       ('stairs_surcharge', 'Stairs surcharge', 'Stairs surcharge', 7500, 5);

INSERT INTO `trucks`
(`name`, `rego`, `truck_size`, `capacity_m3`, `max_payload_kg`, `current_location`)
VALUES ('Truck 1', '1ABC123', 'Small', 20.00, 2000.00, 'Clayton Depot'),
       ('Truck 2', '1DEF456', 'Large', 35.00, 4000.00, 'Springvale Depot');

INSERT INTO storage_units
(unit_code, facility_name, unit_size_m3, security_level, is_climate_controlled)
VALUES ('A01', 'Springvale Storage', 12.00, 'standard', 0),
       ('B14', 'Moorabbin Storage', 25.00, 'high', 1);

INSERT INTO `equipment`
(`name`, `category`, `quantity_available`, `storage_location`)
VALUES ('Heavy-duty trolley', 'Trolley', 4,  'Clayton Depot'),
       ('Moving blanket', 'Protective', 20, 'Clayton Depot'),
       ('Ratchet strap', 'Securing', 15, 'Springvale Depot');

INSERT INTO `inventory_items`
(`name`, `category`, `quantity_on_hand`, `reorder_threshold`, `unit`, `storage_location`)
VALUES ('Small box', 'Boxes', 100, 20, 'each', 'Warehouse Shelf A'),
       ('Packing tape', 'Packing', 60, 10, 'roll', 'Warehouse Shelf B'),
       ('Bubble wrap', 'Packing', 25, 5, 'roll', 'Warehouse Shelf C');

INSERT INTO `staff` (`staff_id`,`first_name`,`last_name`,`email`,`phone`,`isDriver`)
VALUES (1,'Jordan','Lee', 'staff@myapp.local', '0422222222', 0),
       (2,'Uba', 'Driver', 'driver@staff.com', '0444444444', 1);

INSERT INTO `content_blocks` (`id`, `parent`, `slug`, `label`, `description`, `type`, `value`, `previous_value`,
                              `modified`)
VALUES (1, 'global', 'website-title-main', 'Website Title (Main)',
        'Shown on the home page, as well  as any tabs in the users browser.', 'text', 'Move done right,', NULL,
        '2026-05-03 06:54:39'),
       (2, 'global', 'website-title-accent', 'Website Title (Accent)',
        'Shown on the home page, as well as any tabs in the users browser.', 'text', 'any time of day.', NULL,
        '2026-05-03 06:54:55'),
       (3, 'global', 'logo', 'Logo',
        'Shown in the centre of the home page, and also in the top corner of all administration pages.', 'image', 'company-logo.png',
        NULL, '2026-05-03 06:53:07'),
       (4, 'global', 'phone-contact-footer', 'Phone Number (footer)',
        'Shown in the footer of every pages.', 'text',
        '0412 345 678', NULL, '2026-05-03 06:53:07'),
       (5, 'global', 'email-contact-footer', 'Email (Footer)', 'Shown in the footer of every pages.',
        'text', 'hello@movinghouse247.com.au', NULL,
        '2026-05-03 06:53:07'),
       (6, 'home', 'home-content', 'Home Page Content',
        'Copyright information shown at the bottom of the home page.', 'text',
        'The main content shown in the centre of the home page.', '<p>Example app showcasing the <code>ugie-cake/cakephp-content-blocks</code> plugin.</p>' ,
        '2026-05-03 06:53:07');

INSERT INTO `content_blocks_phinxlog` (`version`, `migration_name`, `start_time`, `end_time`, `breakpoint`)
VALUES (20230402063959, 'ContentBlocksMigration', '2026-05-02 11:25:48', '2026-05-02 11:25:48', 0);

ALTER TABLE `staff`
    ADD PRIMARY KEY (`staff_id`),
    ADD KEY `email` (`email`);

ALTER TABLE `staff_job`
    ADD PRIMARY KEY (`allocation_id`);

ALTER TABLE `content_blocks`
    ADD PRIMARY KEY (`id`);

ALTER TABLE `content_blocks_phinxlog`
    ADD PRIMARY KEY (`version`);

ALTER TABLE `customers`
    ADD PRIMARY KEY (`customer_id`),
    ADD KEY `email` (`email`);

ALTER TABLE `jobs`
    ADD PRIMARY KEY (`job_id`),
    ADD KEY `job_type_id` (`job_type_id`),
    ADD KEY `customer_id` (`customer_id`);

ALTER TABLE `job_types`
    ADD PRIMARY KEY (`job_type_id`);

ALTER TABLE `phinxlog`
    ADD PRIMARY KEY (`version`);

ALTER TABLE `users`
    ADD PRIMARY KEY (`user_id`),
    ADD KEY `users_user_type_id` (`user_type`);

ALTER TABLE `user_types`
    ADD PRIMARY KEY (`user_type_id`);

ALTER TABLE `bookings`
    ADD PRIMARY KEY (`booking_id`);

ALTER TABLE `contact_forms`
    ADD PRIMARY KEY (`contact_form_id`);

ALTER TABLE `invoices`
    ADD PRIMARY KEY (`invoice_id`);

ALTER TABLE `invoice_items`
    ADD PRIMARY KEY (`invoice_item_id`);

ALTER TABLE `staff`
    MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `availability`
    MODIFY `availability_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `staff_job`
    MODIFY `allocation_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `customers`
    MODIFY `customer_id` int (11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `jobs`
    MODIFY `job_id` int (11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `job_types`
    MODIFY `job_type_id` int (1) NOT NULL AUTO_INCREMENT;

ALTER TABLE `users`
    MODIFY `user_id` int (11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `user_types`
    MODIFY `user_type_id` int (11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `bookings`
    MODIFY `booking_id` int (11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `contact_forms`
    MODIFY `contact_form_id` int (11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `content_blocks`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

ALTER TABLE `customers`
    MODIFY `customer_id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

ALTER TABLE `invoices`
    MODIFY `invoice_id` int (11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `invoice_items`
    MODIFY `invoice_item_id` int (11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `contact_form_replies`
    ADD CONSTRAINT `contact_form_replies_contact_form_id`
        FOREIGN KEY (`contact_form_id`)
            REFERENCES `contact_forms` (`contact_form_id`)
            ON DELETE CASCADE;

ALTER TABLE `contact_forms`
    ADD CONSTRAINT `contact_forms_customer_id`
        FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`);

ALTER TABLE `availability`
    ADD CONSTRAINT `staff_availability_id`
        FOREIGN KEY (`staff_id`) REFERENCES `staff` (`staff_id`);

ALTER TABLE `jobs`
    ADD CONSTRAINT `jobs_customer_id`
        FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`),
    ADD CONSTRAINT `jobs_job_type_id`
    FOREIGN KEY (`job_type_id`) REFERENCES `job_types` (`job_type_id`);

ALTER TABLE `users`
    ADD CONSTRAINT `users_user_type_id`
        FOREIGN KEY (`user_type`) REFERENCES `user_types` (`user_type_id`);

ALTER TABLE `bookings`
    ADD CONSTRAINT `bookings_customer_id`
        FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`),
    ADD CONSTRAINT `bookings_job_type_id`
    FOREIGN KEY (`job_type_id`) REFERENCES `job_types` (`job_type_id`);

ALTER TABLE `invoices`
    ADD CONSTRAINT `invoices_customer_id`
        FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`),
    ADD CONSTRAINT `invoices_booking_id`
    FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`booking_id`);

ALTER TABLE `invoice_items`
    ADD CONSTRAINT `invoice_item_invoice_id`
        FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`invoice_id`),
    ADD CONSTRAINT `invoice_item_preset_id`
    FOREIGN KEY (`invoice_item_preset_id`) REFERENCES `invoice_item_presets` (`invoice_item_preset_id`);

ALTER TABLE `booking_resources`
    ADD CONSTRAINT `booking_resources_booking_id`
        FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`booking_id`);

ALTER TABLE `staff_job`
    ADD CONSTRAINT `staff_job_staff_id`
        FOREIGN KEY (`staff_id`) REFERENCES `staff` (`staff_id`),
    ADD CONSTRAINT `staff_job_job_id`
        FOREIGN KEY (`job_id`) REFERENCES `jobs` (`job_id`);

ALTER TABLE jobs
    ADD allocated_at DATETIME NULL,
ADD cancelled_at DATETIME NULL;

ALTER TABLE jobs
    ADD status VARCHAR(20) NOT NULL DEFAULT 'Pending',
    ADD driver_required INT NOT NULL DEFAULT 0,
    ADD porter_required INT NOT NULL DEFAULT 0;

ALTER TABLE job_trucks
    ADD CONSTRAINT `job_trucks_job_id_fk`
        FOREIGN KEY (`job_id`) REFERENCES `jobs` (`job_id`),

    ADD CONSTRAINT `job_trucks_truck_id_fk`
        FOREIGN KEY (`truck_id`) REFERENCES `trucks` (`truck_id`);

ALTER TABLE staff_job
    ADD report_notes TEXT NULL AFTER status,
    ADD report_photo VARCHAR(255) NULL AFTER report_notes,
    ADD report_submitted_at DATETIME NULL AFTER report_photo;

ALTER TABLE bookings
    ADD rejected_notified TINYINT(1) NOT NULL DEFAULT 0;

ALTER TABLE staff_job
    ADD role VARCHAR(10) NULL AFTER status;

COMMIT;
