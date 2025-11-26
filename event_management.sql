-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 26, 2025 at 05:30 AM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `event_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

DROP TABLE IF EXISTS `bookings`;
CREATE TABLE IF NOT EXISTS `bookings` (
  `booking_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `client_id` int UNSIGNED NOT NULL,
  `event_id` int UNSIGNED NOT NULL,
  `booking_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `booking_status` enum('confirmed','cancelled','waitlist') NOT NULL DEFAULT 'confirmed',
  PRIMARY KEY (`booking_id`),
  KEY `idx_bookings_client` (`client_id`),
  KEY `idx_bookings_event` (`event_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `client_id`, `event_id`, `booking_date`, `booking_status`) VALUES
(11, 5, 16, '2025-10-14 15:22:44', 'waitlist'),
(12, 5, 17, '2025-10-14 15:24:02', 'waitlist'),
(13, 6, 18, '2025-10-14 15:25:47', 'waitlist'),
(14, 7, 19, '2025-10-14 15:27:41', 'waitlist'),
(15, 8, 20, '2025-10-14 15:30:10', 'waitlist'),
(16, 9, 21, '2025-10-14 15:32:19', 'waitlist');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
CREATE TABLE IF NOT EXISTS `clients` (
  `client_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `client_name` varchar(100) NOT NULL,
  `contact_no` varchar(20) DEFAULT NULL,
  `email_address` varchar(150) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`client_id`),
  UNIQUE KEY `email_address` (`email_address`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`client_id`, `client_name`, `contact_no`, `email_address`, `address`, `password`, `created_at`) VALUES
(5, 'Thushara Pradeep', '0764104839', 'thushara@gmail.com', 'jayanthipara,galenbindunuwewa', 'thushara', '2025-10-14 14:43:17'),
(6, 'Anju Sooriyagoda', '0711447562', 'anju@gmail.com', '234B jayanthipara,galenbindunuwewa', 'anju', '2025-10-14 14:45:33'),
(7, 'Tharindu Imesh', '0741236548', 'tharindu@gmail.com', '265 gatalawa', 'tharindu', '2025-10-14 14:47:56'),
(8, 'Mihisara Methmali', '0765288112', 'mihisara@gmail.com', '357B Getalawa Galenbindunuwewa', 'mihisara123', '2025-10-14 14:51:10'),
(9, 'Nalin Suranga', '0766162419', 'nalin@gmail.com', '384 Getalawa Galenbindunuwewa', '123456', '2025-10-14 14:52:31');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `event_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `event_name` varchar(150) NOT NULL,
  `event_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `event_status` enum('scheduled','completed','cancelled','pending') NOT NULL DEFAULT 'pending',
  `event_description` text,
  `venue_id` int UNSIGNED NOT NULL,
  `staff_id` int UNSIGNED NOT NULL,
  `max_attendees` int DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`event_id`),
  KEY `idx_events_venue` (`venue_id`),
  KEY `idx_events_staff` (`staff_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `event_name`, `event_date`, `end_date`, `start_time`, `end_time`, `event_status`, `event_description`, `venue_id`, `staff_id`, `max_attendees`, `created_at`) VALUES
(16, 'wedding', '2025-10-20', '2025-10-20', '09:00:00', '16:30:00', 'pending', '', 21, 1, 500, '2025-10-14 15:22:44'),
(17, 'Birthday Party', '2025-10-30', '2025-10-30', '18:00:00', '23:00:00', 'pending', '', 6, 1, 250, '2025-10-14 15:24:02'),
(18, 'Batch Party', '2025-11-11', '2025-11-11', '10:00:00', '15:00:00', 'pending', 'Dj Party', 9, 1, 1000, '2025-10-14 15:25:47'),
(19, 'Dj Party', '2025-11-30', '2025-11-30', '19:30:00', '23:45:00', 'pending', '', 8, 1, 1500, '2025-10-14 15:27:41'),
(20, 'Exhibition', '2025-12-01', '2025-12-05', '08:00:00', '15:00:00', 'pending', '', 7, 1, 1400, '2025-10-14 15:30:10'),
(21, 'Conference', '2025-10-30', '2025-10-30', '09:00:00', '14:30:00', 'pending', '', 22, 1, 750, '2025-10-14 15:32:19');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

DROP TABLE IF EXISTS `staff`;
CREATE TABLE IF NOT EXISTS `staff` (
  `staff_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `staff_name` varchar(100) NOT NULL,
  `role` enum('admin','manager','coordinator','sales','staff','catering','cleaning','security') NOT NULL DEFAULT 'staff',
  `contact_no` varchar(20) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `email_address` varchar(150) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`staff_id`),
  UNIQUE KEY `email_address` (`email_address`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_id`, `staff_name`, `role`, `contact_no`, `address`, `email_address`, `password`, `created_at`) VALUES
(1, 'Malith Kavindu', 'manager', '0764288704', 'jayanthipara', 'malith@mail.com', '123456', '2025-10-13 06:46:19'),
(2, 'Sahan Tharuka', 'admin', '0764288704', '383B, Getalawa, Galenbindunuwewa.', 'sahantharuka@gmail.com', 'Sahan123', '2025-10-13 09:54:56'),
(9, 'Sasindu Nirvaan', 'sales', '0788090707', '383B Getalawa Galenbindunuwewa', 'sasi@gmail.com', 'Sasi123', '2025-10-14 15:12:28'),
(10, 'Madhushi Rashmika', 'coordinator', '0728045285', '280 Getalawa, Galenbindunuwewa.', 'madhushi@gmai.com', 'M123456', '2025-10-14 15:16:36'),
(11, 'Navindu Dulakshana', 'staff', '0764972918', '172B karalliyadda, Galenbindunuwewa', 'navi@gmail.com', '123456', '2025-10-14 15:19:27'),
(12, 'Harshana Kelum', 'security', '0747197830', 'Jayanthimawatha, Anurashapura', 'kelum@gmail.com', 'Kelum12', '2025-10-14 15:21:01');

-- --------------------------------------------------------

--
-- Table structure for table `venues`
--

DROP TABLE IF EXISTS `venues`;
CREATE TABLE IF NOT EXISTS `venues` (
  `venue_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `venue_name` varchar(100) NOT NULL,
  `address` varchar(200) DEFAULT NULL,
  `capacity` int NOT NULL,
  `contact_info` varchar(100) DEFAULT NULL,
  `Phone_Number` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`venue_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `venues`
--

INSERT INTO `venues` (`venue_id`, `venue_name`, `address`, `capacity`, `contact_info`, `Phone_Number`, `created_at`) VALUES
(6, 'Athula Restorent', 'Nikawewa, Galenbindunuwewa', 600, 'athulahotel@gmail.com', NULL, '2025-10-14 15:01:13'),
(7, 'Mango Mango', 'Jyanthimawatha, Anuradhapura', 1000, 'mongohotel@gmail.com', NULL, '2025-10-14 15:02:03'),
(8, 'Uga Jungle Beach', 'Trincomale', 2000, 'ugajungle@gmail.com', NULL, '2025-10-14 15:06:25'),
(9, 'Galadari Hotel', '64 Lotus Road, Colombo', 1000, 'galadari@gmail.com', '0787840547', '2025-10-14 15:11:02'),
(19, 'Aba Sevana', 'Galenbindunuwewa', 1200, 'aba.hotel@gmail.com', '0785242521', '2025-10-21 08:26:36'),
(21, 'Cinnamon Grand Colombo', '77, Galle road, Colombo 03, Sri Lanka', 1500, 'cinnamon@gmail.com', '012161161', '2025-10-22 17:37:23'),
(22, 'The Hotel', 'Kandy Road, Colombo', 1000, 'thehotel@gmail.com', '0787840545', '2025-10-22 17:38:47');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `fk_bookings_client` FOREIGN KEY (`client_id`) REFERENCES `clients` (`client_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_bookings_event` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `fk_events_staff` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`staff_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_events_venue` FOREIGN KEY (`venue_id`) REFERENCES `venues` (`venue_id`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
