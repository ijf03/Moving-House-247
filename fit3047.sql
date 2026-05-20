-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2026 at 08:22 PM
-- Server version: 11.8.6-MariaDB
-- PHP Version: 8.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS `content_blocks`;
DROP TABLE IF EXISTS `content_blocks_phinxlog`;
DROP TABLE IF EXISTS `phinxlog`;
DROP TABLE IF EXISTS `job_resources`;
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

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `3047`
--

-- --------------------------------------------------------

--
-- Table structure for table `availability`
--

CREATE TABLE `availability` (
                                `availability_id` int(11) NOT NULL,
                                `staff_id` int(11) NOT NULL,
                                `start_datetime` datetime NOT NULL,
                                `end_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
                            `booking_id` int(11) NOT NULL,
                            `customer_id` int(11) NOT NULL,
                            `job_type_id` int(1) NOT NULL,
                            `pickup_address` varchar(95) NOT NULL,
                            `dropoff_address` varchar(95) DEFAULT NULL,
                            `job_date` date NOT NULL,
                            `job_time` time NOT NULL,
                            `status` varchar(20) NOT NULL DEFAULT 'Pending',
                            `created` datetime NOT NULL DEFAULT current_timestamp(),
                            `message` text DEFAULT NULL,
                            `accepted_notified` tinyint(1) NOT NULL DEFAULT 0,
                            `rejected_notified` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `customer_id`, `job_type_id`, `pickup_address`, `dropoff_address`, `job_date`, `job_time`, `status`, `created`, `message`, `accepted_notified`, `rejected_notified`) VALUES
                                                                                                                                                                                                               (1, 11, 3, 'CH109, 21 Sports Walk, Clayton, VIC, Clayton, 3168', 'a24rgvv, Monash, 3168', '2026-05-28', '16:03:00', 'Pending', '2026-05-13 15:01:18', NULL, 0, 0),
                                                                                                                                                                                                               (2, 11, 1, '12 Joan Avenue, Ferntree Gully, 3156', NULL, '2026-05-16', '16:22:00', 'Pending', '2026-05-16 06:20:01', NULL, 0, 0),
                                                                                                                                                                                                               (3, 11, 1, '12, 1, 4000', NULL, '2026-05-29', '18:52:00', 'Pending', '2026-05-16 08:50:10', NULL, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `contact_forms`
--

CREATE TABLE `contact_forms` (
                                 `contact_form_id` int(11) NOT NULL,
                                 `customer_id` int(11) NOT NULL,
                                 `subject` varchar(100) NOT NULL,
                                 `message` text NOT NULL,
                                 `created` datetime NOT NULL DEFAULT current_timestamp(),
                                 `status` varchar(20) NOT NULL DEFAULT 'new',
                                 `admin_reply` text DEFAULT NULL,
                                 `replied_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `contact_forms`
--

INSERT INTO `contact_forms` (`contact_form_id`, `customer_id`, `subject`, `message`, `created`, `status`, `admin_reply`, `replied_at`) VALUES
                                                                                                                                           (1, 1, 'Quote for apartment move', 'Hi, I would like a quote for moving a 2-bedroom apartment from Clayton to Melbourne.', '2026-04-18 09:30:00', 'replied', 'Thanks Emily. We have sent you a preliminary quote and will confirm availability shortly.', '2026-04-18 11:05:00'),
                                                                                                                                           (2, 2, 'Short-term storage question', 'Do you offer storage for furniture while renovations are happening?', '2026-04-18 13:20:00', 'replied', 'Yes, we offer short-term storage options. We can include this in your quote.', '2026-04-18 15:10:00'),
                                                                                                                                           (3, 3, 'Office relocation availability', 'We need help moving office equipment next week. Are morning slots available?', '2026-04-19 08:45:00', 'new', NULL, NULL),
                                                                                                                                           (4, 4, 'Transfer booking request', 'Can you transfer packed boxes from South Yarra to Carlton?', '2026-04-19 12:00:00', 'replied', 'Yes, we can assist with transfer jobs. Please provide your preferred date.', '2026-04-19 14:35:00'),
                                                                                                                                           (5, 5, 'Fragile items handling', 'I have glassware and framed artwork. Can your movers handle fragile items?', '2026-04-20 10:25:00', 'new', NULL, NULL),
                                                                                                                                           (6, 6, 'Storage unit size', 'What storage unit size would suit a studio apartment?', '2026-04-20 16:15:00', 'replied', 'A small to medium unit is usually suitable for a studio apartment.', '2026-04-20 17:40:00'),
                                                                                                                                           (7, 7, 'Packing materials', 'Can I request wardrobe boxes and packing tape with my booking?', '2026-04-21 09:10:00', 'new', NULL, NULL),
                                                                                                                                           (8, 8, 'Student move inquiry', 'I am moving from Bundoora to the city and only have a few furniture items.', '2026-04-21 13:55:00', 'replied', 'We can help with smaller student moves. Please submit a booking request online.', '2026-04-21 15:25:00'),
                                                                                                                                           (9, 9, 'Large family move', 'We are moving a family home and need help with heavy furniture.', '2026-04-22 11:35:00', 'new', NULL, NULL),
                                                                                                                                           (10, 10, 'Storage before settlement', 'Can my items be stored for two weeks before delivery to my new address?', '2026-04-22 14:50:00', 'replied', 'Yes, we can arrange storage before final delivery.', '2026-04-22 16:20:00'),
                                                                                                                                           (11, 11, 'Test', 'message', '2026-05-13 12:05:59', 'new', NULL, NULL),
                                                                                                                                           (12, 12, 'hello', 'this works', '2026-05-13 12:06:36', 'new', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `contact_form_replies`
--

CREATE TABLE `contact_form_replies` (
                                        `contact_form_reply_id` int(11) NOT NULL,
                                        `contact_form_id` int(11) NOT NULL,
                                        `sender_type` varchar(20) NOT NULL,
                                        `message` text NOT NULL,
                                        `created` datetime NOT NULL DEFAULT current_timestamp(),
                                        `modified` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `contact_form_replies`
--

INSERT INTO `contact_form_replies` (`contact_form_reply_id`, `contact_form_id`, `sender_type`, `message`, `created`, `modified`) VALUES
                                                                                                                                     (1, 1, 'customer', 'Hi, I would like a quote for moving a 2-bedroom apartment from Clayton to Melbourne.', '2026-04-18 09:30:00', '2026-05-13 11:28:29'),
                                                                                                                                     (2, 2, 'customer', 'Do you offer storage for furniture while renovations are happening?', '2026-04-18 13:20:00', '2026-05-13 11:28:29'),
                                                                                                                                     (3, 3, 'customer', 'We need help moving office equipment next week. Are morning slots available?', '2026-04-19 08:45:00', '2026-05-13 11:28:29'),
                                                                                                                                     (4, 4, 'customer', 'Can you transfer packed boxes from South Yarra to Carlton?', '2026-04-19 12:00:00', '2026-05-13 11:28:29'),
                                                                                                                                     (5, 5, 'customer', 'I have glassware and framed artwork. Can your movers handle fragile items?', '2026-04-20 10:25:00', '2026-05-13 11:28:29'),
                                                                                                                                     (6, 6, 'customer', 'What storage unit size would suit a studio apartment?', '2026-04-20 16:15:00', '2026-05-13 11:28:29'),
                                                                                                                                     (7, 7, 'customer', 'Can I request wardrobe boxes and packing tape with my booking?', '2026-04-21 09:10:00', '2026-05-13 11:28:29'),
                                                                                                                                     (8, 8, 'customer', 'I am moving from Bundoora to the city and only have a few furniture items.', '2026-04-21 13:55:00', '2026-05-13 11:28:29'),
                                                                                                                                     (9, 9, 'customer', 'We are moving a family home and need help with heavy furniture.', '2026-04-22 11:35:00', '2026-05-13 11:28:29'),
                                                                                                                                     (10, 10, 'customer', 'Can my items be stored for two weeks before delivery to my new address?', '2026-04-22 14:50:00', '2026-05-13 11:28:29'),
                                                                                                                                     (16, 1, 'admin', 'Thanks Emily. We have sent you a preliminary quote and will confirm availability shortly.', '2026-04-18 11:05:00', '2026-05-13 11:28:29'),
                                                                                                                                     (17, 2, 'admin', 'Yes, we offer short-term storage options. We can include this in your quote.', '2026-04-18 15:10:00', '2026-05-13 11:28:29'),
                                                                                                                                     (18, 4, 'admin', 'Yes, we can assist with transfer jobs. Please provide your preferred date.', '2026-04-19 14:35:00', '2026-05-13 11:28:29'),
                                                                                                                                     (19, 6, 'admin', 'A small to medium unit is usually suitable for a studio apartment.', '2026-04-20 17:40:00', '2026-05-13 11:28:29'),
                                                                                                                                     (20, 8, 'admin', 'We can help with smaller student moves. Please submit a booking request online.', '2026-04-21 15:25:00', '2026-05-13 11:28:29'),
                                                                                                                                     (21, 10, 'admin', 'Yes, we can arrange storage before final delivery.', '2026-04-22 16:20:00', '2026-05-13 11:28:29'),
                                                                                                                                     (23, 11, 'customer', 'message', '2026-05-13 12:05:59', '2026-05-13 12:05:59'),
                                                                                                                                     (24, 12, 'customer', 'this works', '2026-05-13 12:06:36', '2026-05-13 12:06:36');

-- --------------------------------------------------------

--
-- Table structure for table `content_blocks`
--

CREATE TABLE `content_blocks` (
                                  `id` int(11) NOT NULL,
                                  `parent` varchar(128) NOT NULL,
                                  `slug` varchar(128) NOT NULL,
                                  `label` varchar(255) NOT NULL,
                                  `description` varchar(255) NOT NULL,
                                  `type` varchar(32) NOT NULL,
                                  `value` text DEFAULT NULL,
                                  `previous_value` text DEFAULT NULL,
                                  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `content_blocks`
--

INSERT INTO `content_blocks`
(`id`, `parent`, `slug`, `label`, `description`, `type`, `value`, `previous_value`, `modified`)
VALUES
    (1, 'Home Page Main Content', 'header-description-main', 'Header Description', 'Shown on the home page as header description (coloured)', 'text', 'Available 24/7 across Victoria', NULL, NOW()),
    (2, 'Home Page Main Content', 'website-title-main', 'Website Title (Main)', 'Shown on the home page as the main title', 'text', 'Move done right,', NULL, NOW()),
    (3, 'Home Page Main Content', 'website-title-main-coloured', 'Website Title (Coloured)', 'Shown on the home page as the main title (coloured)', 'text', 'any time of day.', NULL, NOW()),
    (4, 'Home Page Main Content', 'main-page-description', 'Main page description', 'Shown on the homepage, under the main website title', 'text', 'Trusted local removals and storage solutions. Get a fast online quote and book your move in minutes. \n                No hold music, no guesswork.', NULL, NOW()),
    (5, 'Home Page Main Content', 'first-additional-description-main', 'Additional Description (Fully Insured)', 'Shown on the home page as the first description', 'text', '🛡 Fully insured', NULL, NOW()),
    (6, 'Home Page Main Content', 'second-additional-description-main', 'Additional Description (Trained Crews)', 'Shown on the home page as the second description', 'text', '⭐ Trained crews', NULL, NOW()),
    (7, 'Home Page Main Content', 'third-additional-description-main', 'Additional Description (24/7 availability)', 'Shown on the home page as the third description', 'text', '◷ 24/7 availability', NULL, NOW()),
    (8, 'Home Page Main Content', 'logo', 'Logo (Navigation Bar)', 'Shown in the navigation bar for staff and customer', 'image', 'company-logo.png', NULL, NOW()),
    (9, 'Home Page Statistics', 'hero-stat-first', 'Statistics 1 - On-time arrival', 'Shown in the first row of the main statistics on the home page.', 'text', '98%', NULL, NOW()),
    (10, 'Home Page Statistics', 'hero-label-first', 'Statistics 1 Label - On-time arrival', 'Shown in the first row of the main statistics on the home page.', 'text', 'On-time arrival', NULL, NOW()),
    (11, 'Home Page Statistics', 'hero-stat-second', 'Statistics 2 - 5-star reviews', 'Shown in the second row of the main statistics on the home page.', 'text', '4.9/5', NULL, NOW()),
    (12, 'Home Page Statistics', 'hero-label-second', 'Statistics 2 Label -5-star reviews', 'Shown in the second row of the main statistics on the home page.', 'text', '5-star reviews', NULL, NOW()),
    (13, 'Home Page Statistics', 'hero-stat-third', 'Statistics 3 - Moves Completed', 'Shown in the third row of the main statistics on the home page.', 'text', '10,000+', NULL, NOW()),
    (14, 'Home Page Statistics', 'hero-label-third', 'Statistics 3 Label - Moves Completed', 'Shown in the third row of the main statistics on the home page.', 'text', 'Moves Completed', NULL, NOW()),
    (15, 'Services (Home)', 'services-title', 'Services (Title)', 'Shown on the home page in the services section', 'text', 'Our Services', NULL, NOW()),
    (16, 'Services (Home)', 'services-subtitle', 'Services (Subtitle)', 'Shown on the home page under the service title in the services section ', 'text', 'Whatever your move looks it, we have a solution to fit.', NULL, NOW()),
    (17, 'Services (Home)', 'removal-tag', 'Relocation Service Tag Card', 'Shown on the home page in the services section', 'text', 'Removals', NULL, NOW()),
    (18, 'Services (Home)', 'removal-name', 'Relocation Service Name Card', 'Shown on the home page in the services section', 'text', 'Relocation', NULL, NOW()),
    (19, 'Services (Home)', 'removal-description', ' Relocation Service Description Card', 'Shown on the home page in the services section', 'text', 'Full-service home and apartment moves, planned and executed by trained crews.', NULL, NOW()),
    (20, 'Services (Home)', 'transport-tag', 'Transport Service Tag Card', 'Shown on the home page in the services section ', 'text', 'Transport', NULL, NOW()),
    (21, 'Services (Home)', 'transport-name', 'Transport Service Name Card', 'Shown on the home page in the services section ', 'text', 'Moving Your Belongings', NULL, NOW()),
    (22, 'Services (Home)', 'transport-description', 'Transport Service Description Card', 'Shown on the home page in the services section ', 'text', 'Careful handling of your possessions from packing to delivery, every step covered.', NULL, NOW()),
    (23, 'Services (Home)', 'storage-tag', 'Storage Service Tag Card', 'Shown on the home page in the services section ', 'text', 'Storage', NULL, NOW()),
    (24, 'Services (Home)', 'storage-name', 'Storage Service Name Card', 'Shown on the home page in the services section', 'text', 'Storage Solutions', NULL, NOW()),
    (25, 'Services (Home)', 'storage-description', 'Storage Service Description Card', 'Shown on the home page in the services section', 'text', 'Short and long-term secure storage when you need extra time between properties.', NULL, NOW()),
    (26, 'Services (Home)', 'furniture-tag', 'Furniture Service Tag Card', 'Shown on the home page in the services section', 'text', 'Furniture', NULL, NOW()),
    (27, 'Services (Home)', 'furniture-name', 'Furniture Service Name Card', 'Shown on the home page in the services section', 'text', 'Furniture &amp; Item Removal', NULL, NOW()),
    (28, 'Services (Home)', 'furniture-description', 'Furniture Service Description Card', 'Shown on the home page in the services section', 'text', 'Single items, large furniture, or full clear-outs, we handle the heavy lifting.', NULL, NOW()),
    (29, 'Booking (Home)', 'booking-tag', 'Booking (Tag)', 'Shown on the home page in the booking section ', 'text', 'HOW IT WORKS', NULL, NOW()),
    (30, 'Booking (Home)', 'booking-title', 'Booking (Title)', 'Shown on the home page in the booking section ', 'text', 'Booking is Simple', NULL, NOW()),
    (31, 'Booking (Home)', 'booking-subtitle', 'Booking (Subtitle)', 'Shown on the home page in the booking section ', 'text', 'Three straightforward steps from quote to move-in day.', NULL, NOW()),
    (32, 'Booking (Home)', 'first-booking-title-card', 'First Step Booking Title Card', 'Shown on the home page in the booking section', 'text', 'Request a quote', NULL, NOW()),
    (33, 'Booking (Home)', 'first-booking-description-card', 'First Step Booking Description Card', 'Shown on the home page in the booking section', 'text', 'Tell us about your move with our quick online form. No phone calls needed', NULL, NOW()),
    (34, 'Booking (Home)', 'second-booking-title-card', 'Second Step Booking Title Card', 'Shown on the home page in the booking section ', 'text', 'Confirm your booking', NULL, NOW()),
    (35, 'Booking (Home)', 'second-booking-description-card', 'Second Step Booking Description Card', 'Shown on the home page in the booking section ', 'text', 'We confirm date, time, crew size and pricing all in writing, no surprises.', NULL, NOW()),
    (36, 'Booking (Home)', 'third-booking-title-card', 'Third Step Booking Title Card', 'Shown on the home page in the booking section ', 'text', 'Move with ease', NULL, NOW()),
    (37, 'Booking (Home)', 'third-booking-description-card', 'Third Step Booking Description Card', 'Shown on the home page in the booking section ', 'text', 'Our team arrives on time, handles the work, and gets you settled in stress-free.', NULL, NOW()),
    (38, 'Footer', 'title-footer', 'Main Title (Footer)', 'Shown in the footer of every pages for staff and customer.', 'text', 'Get your free quote today', NULL, NOW()),
    (39, 'Footer', 'subtitle-footer', 'Subtitle (Footer)', 'Shown in the footer of every pages for staff and customer.', 'text', 'Most quotes returned within the same day.', NULL, NOW()),
    (40, 'Footer', 'company-name-footer', 'Company name (Footer)', 'Shown in the footer of every pages for staff and customer.', 'text', 'Moving House 24/7', NULL, NOW()),
    (41, 'Footer', 'company-description-footer', 'Company description (Footer)', 'Shown in the footer of every pages for staff and customer.', 'text', 'Reliable removals &amp; storage across Victoria, any time of day.', NULL, NOW()),
    (42, 'Footer', 'title-service-description-footer', 'Title service description (Footer)', 'Shown in the footer of every pages for staff and customer.', 'text', 'Trust', NULL, NOW()),
    (43, 'Footer', 'service-description-footer', 'Service Description (Footer)', 'Shown in the footer of every pages for staff and customer.', 'text', 'Fully insured, professionally trained crews. Transparent quotes, no hidden fees.', NULL, NOW()),
    (44, 'Footer', 'phone-contact-footer', 'Phone Number (Footer)', 'Shown in the footer of every pages for staff and customer.', 'text', '0412 345 678', NULL, NOW()),
    (45, 'Footer', 'email-contact-footer', 'Email (Footer)', 'Shown in the footer of every pages for staff and customer.', 'text', 'hello@movinghouse247.com.au', NULL, NOW()),
    (46, 'Footer', 'address-footer', 'Address (Footer)', 'Shown in the footer of every pages for staff and customer.', 'text', 'Victoria, Australia', NULL, NOW()),
    (47, 'Footer', 'logo-footer', 'Logo (Footer)', 'Shown in the footer of every pages for staff and customer.', 'image', 'company-logo.png', NULL, NOW());

-- --------------------------------------------------------

--
-- Table structure for table `content_blocks_phinxlog`
--

CREATE TABLE `content_blocks_phinxlog` (
                                           `version` bigint(20) NOT NULL,
                                           `migration_name` varchar(100) DEFAULT NULL,
                                           `start_time` timestamp NULL DEFAULT NULL,
                                           `end_time` timestamp NULL DEFAULT NULL,
                                           `breakpoint` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `content_blocks_phinxlog`
--

INSERT INTO `content_blocks_phinxlog` (`version`, `migration_name`, `start_time`, `end_time`, `breakpoint`) VALUES
    (20230402063959, 'ContentBlocksMigration', '2026-05-02 11:25:48', '2026-05-02 11:25:48', 0);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
                             `customer_id` int(11) NOT NULL,
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
                                                                                                      (1, 'Emily', 'Carter', 'emily.carter@example.com', '0412345678', NULL),
                                                                                                      (2, 'Liam', 'Nguyen', 'liam.nguyen@example.com', '0423456789', NULL),
                                                                                                      (3, 'Sophie', 'Patel', 'sophie.patel@example.com', '0434567890', NULL),
                                                                                                      (4, 'Daniel', 'Reyes', 'daniel.reyes@example.com', '0445678901', NULL),
                                                                                                      (5, 'Mia', 'Thompson', 'mia.thompson@example.com', '0456789012', NULL),
                                                                                                      (6, 'Joshua', 'Tan', 'joshua.tan@example.com', '0467890123', NULL),
                                                                                                      (7, 'Hannah', 'Lim', 'hannah.lim@example.com', '0478901234', NULL),
                                                                                                      (8, 'Noah', 'Brown', 'noah.brown@example.com', '0489012345', NULL),
                                                                                                      (9, 'Ava', 'Williams', 'ava.williams@example.com', '0490123456', NULL),
                                                                                                      (10, 'Marcus', 'Smith', 'marcus.smith@example.com', '0401234567', NULL),
                                                                                                      (11, 'Alex', 'Morgan', 'customer@myapp.local', '0411111111', 'cus_UVcoOXAshCoV72'),
                                                                                                      (12, 'Testing form', 'Fernan', 'test@me.com', '0422264066', 'cus_UVcoqDvVYdhVFA');

-- --------------------------------------------------------

--
-- Table structure for table `equipment`
--

CREATE TABLE `equipment` (
                             `equipment_id` int(11) NOT NULL,
                             `name` varchar(100) NOT NULL,
                             `category` varchar(50) NOT NULL,
                             `quantity_available` int(11) NOT NULL DEFAULT 1,
                             `status` varchar(30) NOT NULL DEFAULT 'available',
                             `storage_location` varchar(100) DEFAULT NULL,
                             `condition_notes` text DEFAULT NULL,
                             `is_active` tinyint(1) NOT NULL DEFAULT 1,
                             `created` datetime NOT NULL DEFAULT current_timestamp(),
                             `modified` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `equipment`
--

INSERT INTO `equipment` (`equipment_id`, `name`, `category`, `quantity_available`, `status`, `storage_location`, `condition_notes`, `is_active`, `created`, `modified`) VALUES
                                                                                                                                                                            (1, 'Heavy-duty trolley', 'Trolley', 4, 'available', 'Clayton Depot', NULL, 1, '2026-05-13 11:28:29', '2026-05-13 11:28:29'),
                                                                                                                                                                            (2, 'Moving blanket', 'Protective', 20, 'available', 'Clayton Depot', NULL, 1, '2026-05-13 11:28:29', '2026-05-13 11:28:29'),
                                                                                                                                                                            (3, 'Ratchet strap', 'Securing', 15, 'available', 'Springvale Depot', NULL, 1, '2026-05-13 11:28:29', '2026-05-13 11:28:29');

-- --------------------------------------------------------

--
-- Table structure for table `inventory_items`
--

CREATE TABLE `inventory_items` (
                                   `inventory_item_id` int(11) NOT NULL,
                                   `name` varchar(100) NOT NULL,
                                   `category` varchar(50) NOT NULL,
                                   `quantity_on_hand` int(11) NOT NULL DEFAULT 0,
                                   `reorder_threshold` int(11) NOT NULL DEFAULT 0,
                                   `unit` varchar(20) NOT NULL DEFAULT 'each',
                                   `storage_location` varchar(100) DEFAULT NULL,
                                   `is_active` tinyint(1) NOT NULL DEFAULT 1,
                                   `created` datetime NOT NULL DEFAULT current_timestamp(),
                                   `modified` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `inventory_items`
--

INSERT INTO `inventory_items` (`inventory_item_id`, `name`, `category`, `quantity_on_hand`, `reorder_threshold`, `unit`, `storage_location`, `is_active`, `created`, `modified`) VALUES
                                                                                                                                                                                     (1, 'Small box', 'Boxes', 100, 20, 'each', 'Warehouse Shelf A', 1, '2026-05-13 11:28:29', '2026-05-13 11:28:29'),
                                                                                                                                                                                     (2, 'Packing tape', 'Packing', 60, 10, 'roll', 'Warehouse Shelf B', 1, '2026-05-13 11:28:29', '2026-05-13 11:28:29'),
                                                                                                                                                                                     (3, 'Bubble wrap', 'Packing', 25, 5, 'roll', 'Warehouse Shelf C', 1, '2026-05-13 11:28:29', '2026-05-13 11:28:29');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
                            `invoice_id` int(11) NOT NULL,
                            `booking_id` int(11) NOT NULL,
                            `customer_id` int(11) NOT NULL,
                            `stripe_invoice_id` varchar(255) DEFAULT NULL,
                            `invoice_url` text DEFAULT NULL,
                            `status` varchar(50) NOT NULL DEFAULT 'draft',
                            `subtotal_cents` int(11) DEFAULT NULL,
                            `total_cents` int(11) DEFAULT NULL,
                            `due_date` date DEFAULT NULL,
                            `sent_at` datetime DEFAULT NULL,
                            `paid_at` datetime DEFAULT NULL,
                            `created` datetime NOT NULL DEFAULT current_timestamp(),
                            `modified` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`invoice_id`, `booking_id`, `customer_id`, `stripe_invoice_id`, `invoice_url`, `status`, `subtotal_cents`, `total_cents`, `due_date`, `sent_at`, `paid_at`, `created`, `modified`) VALUES
    (1, 1, 11, NULL, NULL, 'draft', 0, 0, NULL, NULL, NULL, '2026-05-13 15:04:32', '2026-05-13 15:04:32');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_items`
--

CREATE TABLE `invoice_items` (
                                 `invoice_item_id` int(11) NOT NULL,
                                 `invoice_id` int(11) NOT NULL,
                                 `description` varchar(255) NOT NULL,
                                 `quantity` decimal(10,2) NOT NULL DEFAULT 1.00,
                                 `unit_price_cents` int(11) NOT NULL,
                                 `line_total_cents` int(11) NOT NULL,
                                 `sort_order` int(11) NOT NULL DEFAULT 0,
                                 `created` datetime NOT NULL DEFAULT current_timestamp(),
                                 `modified` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                                 `invoice_item_preset_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_item_presets`
--

CREATE TABLE `invoice_item_presets` (
                                        `invoice_item_preset_id` int(11) NOT NULL,
                                        `code` varchar(50) NOT NULL,
                                        `name` varchar(100) NOT NULL,
                                        `description` varchar(255) NOT NULL,
                                        `unit_price_cents` int(11) NOT NULL,
                                        `is_active` tinyint(1) NOT NULL DEFAULT 1,
                                        `sort_order` int(11) NOT NULL DEFAULT 0,
                                        `created` datetime NOT NULL DEFAULT current_timestamp(),
                                        `modified` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `invoice_item_presets`
--

INSERT INTO `invoice_item_presets` (`invoice_item_preset_id`, `code`, `name`, `description`, `unit_price_cents`, `is_active`, `sort_order`, `created`, `modified`) VALUES
                                                                                                                                                                       (1, 'labour_hour', 'Labour', 'Labour - per hour', 8500, 1, 1, '2026-05-13 11:28:29', '2026-05-13 11:28:29'),
                                                                                                                                                                       (2, 'truck_small', 'Small truck', 'Truck rental - small truck', 18000, 1, 2, '2026-05-13 11:28:29', '2026-05-13 11:28:29'),
                                                                                                                                                                       (3, 'truck_large', 'Large truck', 'Truck rental - large truck', 28000, 1, 3, '2026-05-13 11:28:29', '2026-05-13 11:28:29'),
                                                                                                                                                                       (4, 'packing_materials', 'Packing materials', 'Packing materials', 5000, 1, 4, '2026-05-13 11:28:29', '2026-05-13 11:28:29'),
                                                                                                                                                                       (5, 'stairs_surcharge', 'Stairs surcharge', 'Stairs surcharge', 7500, 1, 5, '2026-05-13 11:28:29', '2026-05-13 11:28:29');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
                        `job_id` int(11) NOT NULL,
                        `job_type_id` int(1) NOT NULL,
                        `description` text NOT NULL,
                        `pickup_address` varchar(95) NOT NULL,
                        `dropoff_address` varchar(95) DEFAULT NULL,
                        `job_date` date NOT NULL,
                        `job_time` time NOT NULL,
                        `customer_id` int(11) NOT NULL,
                        `allocated_at` datetime DEFAULT NULL,
                        `cancelled_at` datetime DEFAULT NULL,
                        `status` varchar(20) NOT NULL DEFAULT 'Pending',
                        `driver_required` int(11) NOT NULL DEFAULT 0,
                        `porter_required` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`job_id`, `job_type_id`, `description`, `pickup_address`, `dropoff_address`, `job_date`, `job_time`, `customer_id`, `allocated_at`, `cancelled_at`, `status`, `driver_required`, `porter_required`) VALUES
                                                                                                                                                                                                                            (1, 1, 'Move 2-bedroom apartment including fridge, sofa, washing machine, and boxes.', '12 King Street, Clayton VIC 3168', '88 Collins Street, Melbourne VIC 3000', '2026-05-01', '09:00:00', 1, '2026-05-13 11:33:05', NULL, 'Processing', 2, 2),
                                                                                                                                                                                                                            (2, 1, 'Store household furniture and personal boxes during apartment renovation.', '5 Princes Highway, Dandenong VIC 3175', 'Unit 4, Storage Hub, Springvale VIC 3171', '2026-05-02', '13:30:00', 2, '2026-05-13 15:39:22', NULL, 'Processing', 2, 3),
                                                                                                                                                                                                                            (3, 1, 'Office equipment relocation including desks, monitors, and chairs.', '21 Wellington Road, Mulgrave VIC 3170', '9 Queen Street, Melbourne VIC 3000', '2026-05-03', '08:15:00', 3, NULL, NULL, 'Pending', 0, 0),
                                                                                                                                                                                                                            (4, 3, 'Transfer packed boxes between rental properties.', '44 Chapel Street, South Yarra VIC 3141', '72 Lygon Street, Carlton VIC 3053', '2026-05-04', '10:30:00', 4, '2026-05-13 15:39:36', NULL, 'Completed', 1, 1),
                                                                                                                                                                                                                            (5, 1, 'Move 2-bedroom unit with lift access and fragile items.', '18 High Street, Glen Iris VIC 3146', '120 Burke Road, Camberwell VIC 3124', '2026-05-05', '11:00:00', 5, NULL, NULL, 'Pending', 0, 0),
                                                                                                                                                                                                                            (6, 2, 'Store boxes and small appliances from a studio apartment.', '7 Sydney Road, Brunswick VIC 3056', 'Storage King, Preston VIC 3072', '2026-05-06', '14:00:00', 6, '2026-05-13 15:57:49', NULL, 'Processing', 2, 1),
                                                                                                                                                                                                                            (7, 1, 'Move apartment furniture and provide wardrobe boxes.', '33 Bay Street, Port Melbourne VIC 3207', '54 Smith Street, Collingwood VIC 3066', '2026-05-07', '09:45:00', 7, NULL, NULL, 'Pending', 0, 0),
                                                                                                                                                                                                                            (8, 3, 'Transfer student room furniture and personal boxes.', '90 Plenty Road, Bundoora VIC 3083', '27 Swanston Street, Melbourne VIC 3000', '2026-05-08', '12:15:00', 8, NULL, NULL, 'Pending', 0, 0),
                                                                                                                                                                                                                            (9, 1, 'Move family home furniture including outdoor setting and dining table.', '14 Main Road, Eltham VIC 3095', '65 Toorak Road, Toorak VIC 3142', '2026-05-09', '08:30:00', 9, NULL, NULL, 'Pending', 0, 0),
                                                                                                                                                                                                                            (10, 2, 'Store household items while customer waits for property settlement.', '101 Bridge Road, Richmond VIC 3121', 'Secure Store, Moorabbin VIC 3189', '2026-05-10', '15:30:00', 10, NULL, NULL, 'Pending', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `job_resources`
--

CREATE TABLE `job_resources` (
                                 `job_resource_id` int(11) NOT NULL,
                                 `job_id` int(11) NOT NULL,
                                 `truck_id` int(11) DEFAULT NULL,
                                 `equipment_id` int(11) DEFAULT NULL,
                                 `storage_unit_id` int(11) DEFAULT NULL,
                                 `inventory_id` int(11) DEFAULT NULL,
                                 `quantity` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `job_resources`
--

INSERT INTO `job_resources` (`job_resource_id`, `job_id`, `truck_id`, `equipment_id`, `storage_unit_id`, `inventory_id`, `quantity`) VALUES
                                                                                                                                         (1, 1, 1, NULL, NULL, NULL, 1.00),
                                                                                                                                         (2, 2, 1, NULL, NULL, NULL, 1.00),
                                                                                                                                         (3, 2, 2, NULL, NULL, NULL, 1.00),
                                                                                                                                         (4, 4, 1, NULL, NULL, NULL, 1.00),
                                                                                                                                         (5, 6, 1, NULL, NULL, NULL, 1.00),
                                                                                                                                         (6, 6, 2, NULL, NULL, NULL, 1.00);

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
                                                                                     (2, 'Storage', 'Storage of items from customer'),
                                                                                     (3, 'Transfer', 'Transfer of items for customer');

-- --------------------------------------------------------

--
-- Table structure for table `phinxlog`
--

CREATE TABLE `phinxlog` (
                            `version` bigint(20) NOT NULL,
                            `migration_name` varchar(100) DEFAULT NULL,
                            `start_time` timestamp NULL DEFAULT NULL,
                            `end_time` timestamp NULL DEFAULT NULL,
                            `breakpoint` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
                         `staff_id` int(11) NOT NULL,
                         `first_name` varchar(50) NOT NULL,
                         `last_name` varchar(50) NOT NULL,
                         `email` varchar(62) NOT NULL,
                         `phone` varchar(15) NOT NULL,
                         `isDriver` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_id`, `first_name`, `last_name`, `email`, `phone`, `isDriver`) VALUES
                                                                                              (1, 'Jordan', 'Lee', 'staff@myapp.local', '0422222222', 0),
                                                                                              (2, 'Uba', 'Driver', 'driver@staff.com', '0444444444', 1);

-- --------------------------------------------------------

--
-- Table structure for table `staff_job`
--

CREATE TABLE `staff_job` (
                             `allocation_id` int(11) NOT NULL,
                             `staff_id` int(11) NOT NULL,
                             `job_id` int(11) NOT NULL,
                             `status` enum('Waiting','Confirmed','Rejected') NOT NULL DEFAULT 'Waiting',
                             `role` varchar(10) DEFAULT NULL,
                             `report_notes` text DEFAULT NULL,
                             `report_photo` varchar(255) DEFAULT NULL,
                             `report_submitted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `staff_job`
--

INSERT INTO `staff_job` (`allocation_id`, `staff_id`, `job_id`, `status`, `role`, `report_notes`, `report_photo`, `report_submitted_at`) VALUES
                                                                                                                                             (1, 1, 4, 'Confirmed', 'Porter', '\' OR \'1\'=\'1', 'job_4_staff_1_3994a0d8b4a02123.jpg', '2026-05-14 01:47:52'),
                                                                                                                                             (2, 2, 4, 'Confirmed', 'Driver', '<script>alert(\'XSS\')</script>', 'job_4_staff_2_63a9f3362c24d501.png', '2026-05-14 01:46:32');

-- --------------------------------------------------------

--
-- Table structure for table `storage_units`
--

CREATE TABLE `storage_units` (
                                 `storage_unit_id` int(11) NOT NULL,
                                 `unit_code` varchar(50) NOT NULL,
                                 `facility_name` varchar(100) NOT NULL,
                                 `unit_size_m3` decimal(10,2) DEFAULT NULL,
                                 `status` varchar(30) NOT NULL DEFAULT 'available',
                                 `security_level` varchar(50) DEFAULT NULL,
                                 `is_climate_controlled` tinyint(1) NOT NULL DEFAULT 0,
                                 `is_active` tinyint(1) NOT NULL DEFAULT 1,
                                 `created` datetime NOT NULL DEFAULT current_timestamp(),
                                 `modified` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `storage_units`
--

INSERT INTO `storage_units` (`storage_unit_id`, `unit_code`, `facility_name`, `unit_size_m3`, `status`, `security_level`, `is_climate_controlled`, `is_active`, `created`, `modified`) VALUES
                                                                                                                                                                                           (1, 'A01', 'Springvale Storage', 12.00, 'available', 'standard', 0, 1, '2026-05-13 11:28:29', '2026-05-13 11:28:29'),
                                                                                                                                                                                           (2, 'B14', 'Moorabbin Storage', 25.00, 'available', 'high', 1, 1, '2026-05-13 11:28:29', '2026-05-13 11:28:29');

-- --------------------------------------------------------

--
-- Table structure for table `trucks`
--

CREATE TABLE `trucks` (
                          `truck_id` int(11) NOT NULL,
                          `name` varchar(100) NOT NULL,
                          `rego` varchar(20) NOT NULL,
                          `truck_size` varchar(50) DEFAULT NULL,
                          `capacity_m3` decimal(10,2) DEFAULT NULL,
                          `max_payload_kg` decimal(10,2) DEFAULT NULL,
                          `status` varchar(30) NOT NULL DEFAULT 'available',
                          `current_location` varchar(100) DEFAULT NULL,
                          `next_service_date` date DEFAULT NULL,
                          `is_active` tinyint(1) NOT NULL DEFAULT 1,
                          `created` datetime NOT NULL DEFAULT current_timestamp(),
                          `modified` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `trucks`
--

INSERT INTO `trucks` (`truck_id`, `name`, `rego`, `truck_size`, `capacity_m3`, `max_payload_kg`, `status`, `current_location`, `next_service_date`, `is_active`, `created`, `modified`) VALUES
                                                                                                                                                                                            (1, 'Truck 1', '1ABC123', 'Small', 20.00, 2000.00, 'available', 'Clayton Depot', NULL, 1, '2026-05-13 11:28:29', '2026-05-13 11:28:29'),
                                                                                                                                                                                            (2, 'Truck 2', '1DEF456', 'Large', 35.00, 4000.00, 'available', 'Springvale Depot', NULL, 1, '2026-05-13 11:28:29', '2026-05-13 11:28:29');

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
                         `user_type` int(1) NOT NULL,
                         `reset_id` varchar(20) DEFAULT NULL,
                         `time_limit` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `phone`, `password`, `first_name`, `last_name`, `user_type`, `reset_id`, `time_limit`) VALUES
                                                                                                                                    (1, 'customer@myapp.local', '0411111111', '$2y$12$O2mUGRcOpX4i.RgsD0Dofe9hmwPLsxC.teN0iMwi7a9Dx0ainBcum', 'Alexis', 'Morgan', 3, NULL, NULL),
                                                                                                                                    (2, 'staff@myapp.local', '0422222222', '$2y$12$uVkWd9a7/30M6Zc3CZ8Ou.NOtS2NHNaB8pdaZbmwq8gvFCjjnICse', 'Jordan', 'Lee', 2, NULL, NULL),
                                                                                                                                    (3, 'admin@test.com', '0433333333', '$2y$12$xGvQK7AIhGg7iytP8aIEjOV1pm4Ev7hmJweuns1iNDkYW4VI69ipS', 'Alice', 'Admin', 1, NULL, NULL),
                                                                                                                                    (4, 'driver@staff.com', '0444444444', '$2y$12$bXFuHfh4UdmDlcC/c7wblus5E1Kel3LiThtfpGv3xxaWlU/lLwPQ6', 'Uba', 'Driver', 2, NULL, NULL);

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
                                                                     (2, 'Staff', 'Operational staff member'),
                                                                     (3, 'Customer', 'Handles customer communication and enquiries');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `availability`
--
ALTER TABLE `availability`
    ADD PRIMARY KEY (`availability_id`),
  ADD KEY `staff_availability_id` (`staff_id`);

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
-- Indexes for table `contact_form_replies`
--
ALTER TABLE `contact_form_replies`
    ADD PRIMARY KEY (`contact_form_reply_id`),
  ADD KEY `contact_form_replies_contact_form_id` (`contact_form_id`);

--
-- Indexes for table `content_blocks`
--
ALTER TABLE `content_blocks`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `content_blocks_phinxlog`
--
ALTER TABLE `content_blocks_phinxlog`
    ADD PRIMARY KEY (`version`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
    ADD PRIMARY KEY (`customer_id`),
  ADD KEY `email` (`email`);

--
-- Indexes for table `equipment`
--
ALTER TABLE `equipment`
    ADD PRIMARY KEY (`equipment_id`);

--
-- Indexes for table `inventory_items`
--
ALTER TABLE `inventory_items`
    ADD PRIMARY KEY (`inventory_item_id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
    ADD PRIMARY KEY (`invoice_id`),
  ADD KEY `invoices_customer_id` (`customer_id`),
  ADD KEY `invoices_booking_id` (`booking_id`);

--
-- Indexes for table `invoice_items`
--
ALTER TABLE `invoice_items`
    ADD PRIMARY KEY (`invoice_item_id`),
  ADD KEY `invoice_item_invoice_id` (`invoice_id`),
  ADD KEY `invoice_item_preset_id` (`invoice_item_preset_id`);

--
-- Indexes for table `invoice_item_presets`
--
ALTER TABLE `invoice_item_presets`
    ADD PRIMARY KEY (`invoice_item_preset_id`),
  ADD UNIQUE KEY `invoice_item_presets_code` (`code`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
    ADD PRIMARY KEY (`job_id`),
  ADD KEY `job_type_id` (`job_type_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `job_resources`
--
ALTER TABLE `job_resources`
    ADD PRIMARY KEY (`job_resource_id`),
  ADD KEY `job_resources_job_id` (`job_id`),
  ADD KEY `job_resources_truck_id` (`truck_id`),
  ADD KEY `job_resources_storage_unit_id` (`storage_unit_id`),
  ADD KEY `job_resources_inventory_id` (`inventory_id`),
  ADD KEY `job_resources_equipment_id` (`equipment_id`);

--
-- Indexes for table `job_types`
--
ALTER TABLE `job_types`
    ADD PRIMARY KEY (`job_type_id`);

--
-- Indexes for table `phinxlog`
--
ALTER TABLE `phinxlog`
    ADD PRIMARY KEY (`version`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
    ADD PRIMARY KEY (`staff_id`),
  ADD KEY `email` (`email`);

--
-- Indexes for table `staff_job`
--
ALTER TABLE `staff_job`
    ADD PRIMARY KEY (`allocation_id`),
  ADD KEY `staff_job_staff_id` (`staff_id`),
  ADD KEY `staff_job_job_id` (`job_id`);

--
-- Indexes for table `storage_units`
--
ALTER TABLE `storage_units`
    ADD PRIMARY KEY (`storage_unit_id`),
  ADD UNIQUE KEY `storage_units_unit_code` (`unit_code`);

--
-- Indexes for table `trucks`
--
ALTER TABLE `trucks`
    ADD PRIMARY KEY (`truck_id`),
  ADD UNIQUE KEY `trucks_rego` (`rego`);

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
-- AUTO_INCREMENT for table `availability`
--
ALTER TABLE `availability`
    MODIFY `availability_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
    MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `contact_forms`
--
ALTER TABLE `contact_forms`
    MODIFY `contact_form_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `contact_form_replies`
--
ALTER TABLE `contact_form_replies`
    MODIFY `contact_form_reply_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `content_blocks`
--
ALTER TABLE `content_blocks`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
    MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `equipment`
--
ALTER TABLE `equipment`
    MODIFY `equipment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `inventory_items`
--
ALTER TABLE `inventory_items`
    MODIFY `inventory_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
    MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `invoice_items`
--
ALTER TABLE `invoice_items`
    MODIFY `invoice_item_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_item_presets`
--
ALTER TABLE `invoice_item_presets`
    MODIFY `invoice_item_preset_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
    MODIFY `job_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `job_resources`
--
ALTER TABLE `job_resources`
    MODIFY `job_resource_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `job_types`
--
ALTER TABLE `job_types`
    MODIFY `job_type_id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
    MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `staff_job`
--
ALTER TABLE `staff_job`
    MODIFY `allocation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `storage_units`
--
ALTER TABLE `storage_units`
    MODIFY `storage_unit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `trucks`
--
ALTER TABLE `trucks`
    MODIFY `truck_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
    MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_types`
--
ALTER TABLE `user_types`
    MODIFY `user_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `availability`
--
ALTER TABLE `availability`
    ADD CONSTRAINT `staff_availability_id` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`staff_id`);

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
    ADD CONSTRAINT `bookings_customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`),
  ADD CONSTRAINT `bookings_job_type_id` FOREIGN KEY (`job_type_id`) REFERENCES `job_types` (`job_type_id`);

--
-- Constraints for table `contact_forms`
--
ALTER TABLE `contact_forms`
    ADD CONSTRAINT `contact_forms_customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`);

--
-- Constraints for table `contact_form_replies`
--
ALTER TABLE `contact_form_replies`
    ADD CONSTRAINT `contact_form_replies_contact_form_id` FOREIGN KEY (`contact_form_id`) REFERENCES `contact_forms` (`contact_form_id`) ON DELETE CASCADE;

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
    ADD CONSTRAINT `invoices_booking_id` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`booking_id`),
  ADD CONSTRAINT `invoices_customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`);

--
-- Constraints for table `invoice_items`
--
ALTER TABLE `invoice_items`
    ADD CONSTRAINT `invoice_item_invoice_id` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`invoice_id`),
  ADD CONSTRAINT `invoice_item_preset_id` FOREIGN KEY (`invoice_item_preset_id`) REFERENCES `invoice_item_presets` (`invoice_item_preset_id`);

--
-- Constraints for table `jobs`
--
ALTER TABLE `jobs`
    ADD CONSTRAINT `jobs_customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`),
  ADD CONSTRAINT `jobs_job_type_id` FOREIGN KEY (`job_type_id`) REFERENCES `job_types` (`job_type_id`);

--
-- Constraints for table `staff_job`
--
ALTER TABLE `staff_job`
    ADD CONSTRAINT `staff_job_job_id` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`job_id`),
  ADD CONSTRAINT `staff_job_staff_id` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`staff_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
    ADD CONSTRAINT `users_user_type_id` FOREIGN KEY (`user_type`) REFERENCES `user_types` (`user_type_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
