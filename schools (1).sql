-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 05, 2018 at 07:06 PM
-- Server version: 5.7.23-0ubuntu0.16.04.1
-- PHP Version: 7.0.31-1+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `schools`
--

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(220) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `name`, `address`) VALUES
(1, 'Tuol Svay Prey 1', '#64 ABC Street 348 Sangkat Tuol Svay Prey 1, Khan Chamkarmorn Phnom Penh, Cambodia');

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` int(11) NOT NULL,
  `name` varchar(80) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `name`, `active`) VALUES
(1, 'Linux', 1),
(2, 'Oracle', 1),
(3, 'Microsoft', 1),
(4, 'CCNA Bootcamp', 1),
(5, 'CCNA 1 Year (INEC)', 1),
(6, 'CCNA​​ 1-4', 1),
(7, 'CCNA Security', 1),
(8, 'Web Development', 1);

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` int(11) NOT NULL,
  `description` varchar(220) DEFAULT NULL,
  `file_name` varchar(120) DEFAULT NULL,
  `student_id` bigint(20) NOT NULL,
  `active` bit(1) NOT NULL DEFAULT b'1',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `description`, `file_name`, `student_id`, `active`, `create_at`) VALUES
(1, 'សៀវភៅគ្រួសា', '1-Screenshot from 2018-08-19 11-04-56.png', 3, b'1', '2018-08-20 06:51:00'),
(2, NULL, NULL, 3, b'0', '2018-08-20 06:51:03'),
(3, 'identifiy Card', '3-មនុស្សយ៉ាងហោចណាស់-៤៣នាក.pdf', 6, b'1', '2018-08-20 10:11:48'),
(4, 'សំបុត្រកំណើត', '4-AQ0197_01_standard.jpg', 8, b'1', '2018-08-24 12:12:02'),
(5, 'សញ្ញាបិត្រ', '5-1.png', 8, b'1', '2018-08-24 12:12:48');

-- --------------------------------------------------------

--
-- Table structure for table `families`
--

CREATE TABLE `families` (
  `id` int(11) NOT NULL,
  `full_name` varchar(50) NOT NULL,
  `gender` varchar(8) NOT NULL,
  `dob` varchar(20) DEFAULT NULL,
  `address` varchar(120) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `relation_type` varchar(30) NOT NULL,
  `student_id` bigint(20) NOT NULL DEFAULT '0',
  `career` varchar(80) DEFAULT NULL,
  `family_status` varchar(80) DEFAULT NULL,
  `is_alived` varchar(9) NOT NULL DEFAULT 'yes',
  `is_disabled` varchar(9) NOT NULL DEFAULT 'no',
  `is_minority` varchar(9) NOT NULL DEFAULT 'no',
  `active` bit(1) NOT NULL DEFAULT b'1',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` bigint(20) NOT NULL,
  `invoice_date` date NOT NULL,
  `invoice_by` int(11) DEFAULT NULL,
  `total_amount` float DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `invoice_ref` varchar(30) DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `customer_id` int(11) NOT NULL,
  `note` text,
  `total_due_amount` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `invoice_date`, `invoice_by`, `total_amount`, `due_date`, `invoice_ref`, `active`, `create_at`, `customer_id`, `note`, `total_due_amount`) VALUES
(1, '2018-09-05', 1, 400, '2018-09-25', 'NV00001', 1, '2018-09-05 12:02:18', 16, NULL, 100);

-- --------------------------------------------------------

--
-- Table structure for table `invoice_detials`
--

CREATE TABLE `invoice_detials` (
  `id` bigint(20) NOT NULL,
  `item_id` bigint(20) NOT NULL,
  `discount` float DEFAULT NULL,
  `subtotal` float NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `invoice_id` bigint(20) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `qty` int(11) NOT NULL,
  `unit_price` float NOT NULL,
  `due_amount` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `invoice_detials`
--

INSERT INTO `invoice_detials` (`id`, `item_id`, `discount`, `subtotal`, `active`, `invoice_id`, `create_at`, `qty`, `unit_price`, `due_amount`) VALUES
(1, 9, 0, 400, 1, 1, '2018-09-05 12:02:18', 1, 500, 100);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `item_category_id` int(11) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `description` text,
  `photo` varchar(255) DEFAULT NULL,
  `tax` float DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `name`, `item_category_id`, `price`, `description`, `photo`, `tax`, `branch_id`, `active`, `create_at`) VALUES
(1, 'CCNA 1 Year (INEC)', 1, 500, NULL, '1-765181631.jpg', 0, 1, 1, '2018-08-20 04:03:07'),
(2, 'Linux', 1, 600, NULL, '2-linux-200x200.jpg', 0, 1, 1, '2018-08-20 04:10:37'),
(3, 'Web Development', 1, 500, NULL, '3-web_development_technologies.jpg', 0, 1, 1, '2018-08-20 06:36:07'),
(4, 'Microsoft', 1, 500, NULL, '4-microsoft.png', 0, 1, 1, '2018-08-20 06:54:03'),
(5, 'Linux', 1, 1000, NULL, '5-running-shoes-QJGJa6D-600.jpg', 0, 1, 0, '2018-08-24 12:07:02'),
(6, 'CCNA Security', 1, 500, NULL, '6-download.png', 0, 1, 1, '2018-08-28 07:59:21'),
(7, 'Oracle', 1, 500, NULL, '7-unnamed.jpg', 0, 1, 1, '2018-08-28 08:01:41'),
(8, 'CCNA​​ 1-4', 1, 1000, NULL, '8-6-1-4.jpg', 0, 1, 1, '2018-08-28 08:03:58'),
(9, 'CCNA Bootcamp', 1, 500, NULL, '9-s.jpeg', 0, 1, 1, '2018-08-28 08:05:19');

-- --------------------------------------------------------

--
-- Table structure for table `item_categories`
--

CREATE TABLE `item_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `item_categories`
--

INSERT INTO `item_categories` (`id`, `name`, `active`, `create_at`) VALUES
(1, 'Course', 1, '2018-08-20 03:19:07'),
(2, 'Service', 1, '2018-08-20 03:19:12');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` bigint(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `description` varchar(220) NOT NULL,
  `action_type` varchar(30) NOT NULL,
  `record_id` bigint(20) NOT NULL,
  `log_date` date NOT NULL,
  `table_action` varchar(30) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `time` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `user_id`, `description`, `action_type`, `record_id`, `log_date`, `table_action`, `active`, `time`) VALUES
(1, 1, 'User Login', 'login', 1, '2018-09-05', 'users', 1, '11:16:10am'),
(2, 1, 'User Login', 'login', 1, '2018-09-05', 'users', 1, '11:16:28am'),
(3, 1, 'Add Student', 'insert', 1, '2018-09-05', 'students', 1, '11:22:00am'),
(4, 1, 'Update Student', 'update', 1, '2018-09-05', 'students', 1, '11:22:55am'),
(5, 1, 'Add Student', 'insert', 2, '2018-09-05', 'students', 1, '11:24:47am'),
(6, 1, 'Update Student', 'update', 2, '2018-09-05', 'students', 1, '11:30:02am'),
(7, 1, 'Update Student', 'update', 1, '2018-09-05', 'students', 1, '11:30:25am'),
(8, 1, 'Add Student', 'insert', 3, '2018-09-05', 'students', 1, '11:32:17am'),
(9, 1, 'Add Student', 'insert', 4, '2018-09-05', 'students', 1, '11:33:54am'),
(10, 1, 'Add Student', 'insert', 5, '2018-09-05', 'students', 1, '11:34:59am'),
(11, 1, 'Add Student', 'insert', 6, '2018-09-05', 'students', 1, '11:37:06am'),
(12, 1, 'Add Student', 'insert', 7, '2018-09-05', 'students', 1, '11:38:23am'),
(13, 1, 'Add Student', 'insert', 8, '2018-09-05', 'students', 1, '11:39:51am'),
(14, 1, 'Add Student', 'insert', 9, '2018-09-05', 'students', 1, '11:41:05am'),
(15, 1, 'Add Student', 'insert', 10, '2018-09-05', 'students', 1, '11:42:40am'),
(16, 1, 'Update Student', 'update', 10, '2018-09-05', 'students', 1, '11:43:02am'),
(17, 1, 'Add Student', 'insert', 11, '2018-09-05', 'students', 1, '11:44:26am'),
(18, 1, 'Add Student', 'insert', 12, '2018-09-05', 'students', 1, '11:45:57am'),
(19, 1, 'Add Student', 'insert', 13, '2018-09-05', 'students', 1, '11:48:38am'),
(20, 1, 'Add Student', 'insert', 14, '2018-09-05', 'students', 1, '11:50:31am'),
(21, 1, 'Add Student', 'insert', 15, '2018-09-05', 'students', 1, '11:51:49am'),
(22, 1, 'Add Student', 'insert', 16, '2018-09-05', 'students', 1, '11:53:24am'),
(23, 1, 'Add Student', 'insert', 17, '2018-09-05', 'students', 1, '11:54:50am'),
(24, 1, 'Add Student', 'insert', 18, '2018-09-05', 'students', 1, '11:56:18am'),
(25, 1, 'Add Student', 'insert', 19, '2018-09-05', 'students', 1, '11:57:39am'),
(26, 1, 'Add Student', 'insert', 20, '2018-09-05', 'students', 1, '11:58:59am'),
(27, 1, 'Add Student', 'insert', 21, '2018-09-05', 'students', 1, '12:00:32pm'),
(28, 1, 'Add Student', 'insert', 22, '2018-09-05', 'students', 1, '12:02:57pm'),
(29, 1, 'Add Student', 'insert', 23, '2018-09-05', 'students', 1, '12:04:53pm'),
(30, 1, 'Add Student', 'insert', 24, '2018-09-05', 'students', 1, '12:06:22pm'),
(31, 1, 'Add Student', 'insert', 25, '2018-09-05', 'students', 1, '12:07:59pm'),
(32, 1, 'User Login', 'login', 1, '2018-09-05', 'users', 1, '03:24:17pm'),
(33, 1, 'User Login', 'login', 1, '2018-09-05', 'users', 1, '03:24:29pm'),
(34, 1, 'User Login', 'login', 1, '2018-09-05', 'users', 1, '03:24:32pm'),
(35, 1, 'User Login', 'login', 1, '2018-09-05', 'users', 1, '03:25:29pm'),
(36, 1, 'Add Student', 'insert', 26, '2018-09-05', 'students', 1, '03:28:49pm'),
(37, 1, 'Add Student', 'insert', 27, '2018-09-05', 'students', 1, '03:29:50pm'),
(38, 1, 'Update Student', 'update', 27, '2018-09-05', 'students', 1, '03:30:05pm'),
(39, 1, 'Add Student', 'insert', 28, '2018-09-05', 'students', 1, '03:32:15pm'),
(40, 1, 'Add Student', 'insert', 29, '2018-09-05', 'students', 1, '03:34:28pm'),
(41, 1, 'Add Student', 'insert', 30, '2018-09-05', 'students', 1, '03:36:06pm'),
(42, 1, 'Add Student', 'insert', 31, '2018-09-05', 'students', 1, '03:37:16pm'),
(43, 1, 'Add Student', 'insert', 32, '2018-09-05', 'students', 1, '03:41:31pm'),
(44, 1, 'Add Student', 'insert', 33, '2018-09-05', 'students', 1, '03:43:30pm'),
(45, 1, 'Add Student', 'insert', 34, '2018-09-05', 'students', 1, '03:44:51pm'),
(46, 1, 'Add Student', 'insert', 35, '2018-09-05', 'students', 1, '03:46:04pm'),
(47, 1, 'Add Student', 'insert', 36, '2018-09-05', 'students', 1, '03:47:37pm'),
(48, 1, 'Add Student', 'insert', 37, '2018-09-05', 'students', 1, '03:48:39pm'),
(49, 1, 'Add Student', 'insert', 38, '2018-09-05', 'students', 1, '04:25:36pm'),
(50, 1, 'Add Student', 'insert', 39, '2018-09-05', 'students', 1, '04:27:44pm'),
(51, 1, 'User Login', 'login', 1, '2018-09-05', 'users', 1, '04:28:00pm'),
(52, 1, 'Add Student', 'insert', 40, '2018-09-05', 'students', 1, '04:29:47pm'),
(53, 1, 'Add Student', 'insert', 41, '2018-09-05', 'students', 1, '04:31:17pm'),
(54, 1, 'Add Student', 'insert', 42, '2018-09-05', 'students', 1, '04:33:07pm'),
(55, 1, 'Add Student', 'insert', 43, '2018-09-05', 'students', 1, '04:34:17pm'),
(56, 1, 'Add Student', 'insert', 44, '2018-09-05', 'students', 1, '04:35:53pm'),
(57, 1, 'Add Student', 'insert', 45, '2018-09-05', 'students', 1, '04:36:51pm'),
(58, 1, 'Add Student', 'insert', 46, '2018-09-05', 'students', 1, '04:38:33pm'),
(59, 1, 'User Login', 'login', 1, '2018-09-05', 'users', 1, '04:41:39pm'),
(60, 1, 'Add Student', 'insert', 47, '2018-09-05', 'students', 1, '04:42:59pm'),
(61, 1, 'Add Student', 'insert', 48, '2018-09-05', 'students', 1, '05:09:09pm'),
(62, 1, 'Add Student', 'insert', 49, '2018-09-05', 'students', 1, '05:10:19pm'),
(63, 1, 'Add Student', 'insert', 50, '2018-09-05', 'students', 1, '05:11:15pm'),
(64, 1, 'Update Student', 'update', 47, '2018-09-05', 'students', 1, '05:12:05pm'),
(65, 1, 'Add Student', 'insert', 51, '2018-09-05', 'students', 1, '05:14:17pm'),
(66, 1, 'Add Student', 'insert', 52, '2018-09-05', 'students', 1, '05:15:25pm'),
(67, 1, 'Add Student', 'insert', 53, '2018-09-05', 'students', 1, '05:16:47pm'),
(68, 1, 'Add Student', 'insert', 54, '2018-09-05', 'students', 1, '05:17:52pm'),
(69, 1, 'Add Student', 'insert', 55, '2018-09-05', 'students', 1, '05:20:28pm'),
(70, 1, 'Add Student', 'insert', 56, '2018-09-05', 'students', 1, '05:21:32pm'),
(71, 1, 'Add Student', 'insert', 57, '2018-09-05', 'students', 1, '05:22:38pm'),
(72, 1, 'Add Student', 'insert', 58, '2018-09-05', 'students', 1, '05:23:35pm'),
(73, 1, 'Add Student', 'insert', 59, '2018-09-05', 'students', 1, '05:25:04pm'),
(74, 1, 'Add Student', 'insert', 60, '2018-09-05', 'students', 1, '05:26:25pm'),
(75, 1, 'User Login', 'login', 1, '2018-09-05', 'users', 1, '05:26:44pm'),
(76, 1, 'Add Student', 'insert', 61, '2018-09-05', 'students', 1, '05:27:51pm'),
(77, 1, 'Add Student', 'insert', 62, '2018-09-05', 'students', 1, '05:29:05pm'),
(78, 1, 'Add Student', 'insert', 63, '2018-09-05', 'students', 1, '05:37:42pm'),
(79, 1, 'Add Student', 'insert', 64, '2018-09-05', 'students', 1, '05:39:01pm'),
(80, 1, 'Add Student', 'insert', 65, '2018-09-05', 'students', 1, '06:12:01pm'),
(81, 1, 'User Login', 'login', 1, '2018-09-05', 'users', 1, '06:52:51pm'),
(82, 1, 'Add Student', 'insert', 66, '2018-09-05', 'students', 1, '06:56:19pm'),
(83, 1, 'Add Student', 'insert', 67, '2018-09-05', 'students', 1, '06:57:23pm'),
(84, 1, 'Update Student', 'update', 67, '2018-09-05', 'students', 1, '06:57:56pm'),
(85, 1, 'Add Student', 'insert', 68, '2018-09-05', 'students', 1, '06:59:08pm'),
(86, 1, 'Add Student', 'insert', 69, '2018-09-05', 'students', 1, '07:00:18pm'),
(87, 1, 'Add Student', 'insert', 70, '2018-09-05', 'students', 1, '07:01:12pm'),
(88, 1, 'Add Invoice', 'insert', 1, '2018-09-05', 'invoices', 1, '07:02:18pm');

-- --------------------------------------------------------

--
-- Table structure for table `mails`
--

CREATE TABLE `mails` (
  `id` bigint(20) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `send_to` varchar(30) NOT NULL DEFAULT 'Employer',
  `send_date` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `open_classes`
--

CREATE TABLE `open_classes` (
  `id` int(11) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `class_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `name` varchar(90) NOT NULL,
  `list` tinyint(4) NOT NULL DEFAULT '0',
  `insert` tinyint(4) NOT NULL DEFAULT '0',
  `update` tinyint(4) NOT NULL DEFAULT '0',
  `delete` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `list`, `insert`, `update`, `delete`) VALUES
(1, 'Branch', 0, 0, 0, 0),
(2, 'Class', 0, 0, 0, 0),
(3, 'School Year', 0, 0, 0, 0),
(4, 'Invoice', 0, 0, 0, 0),
(5, 'Item', 0, 0, 0, 0),
(6, 'Student', 0, 0, 0, 0),
(7, 'Permission', 0, 0, 0, 0),
(8, 'Role', 0, 0, 0, 0),
(9, 'User', 0, 0, 0, 0),
(10, 'Shift', 0, 0, 0, 0),
(11, 'Item Category', 0, 0, 0, 0),
(12, 'User Action', 0, 0, 0, 0),
(13, 'Mail Marketing', 0, 0, 0, 0),
(14, 'Student Enroll', 0, 0, 0, 0),
(15, 'Report', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `registrations`
--

CREATE TABLE `registrations` (
  `id` bigint(20) NOT NULL,
  `registration_date` date DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `student_id` bigint(20) NOT NULL,
  `class_id` int(11) NOT NULL,
  `shift_id` int(11) DEFAULT NULL,
  `year_id` int(11) NOT NULL,
  `active` bit(1) NOT NULL DEFAULT b'1',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `study_time` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'Administrator'),
(2, 'Receptionist'),
(3, 'Manager');

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

CREATE TABLE `role_permissions` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `list` int(11) NOT NULL DEFAULT '0',
  `insert` int(11) NOT NULL DEFAULT '0',
  `update` int(11) NOT NULL DEFAULT '0',
  `delete` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `role_permissions`
--

INSERT INTO `role_permissions` (`id`, `role_id`, `permission_id`, `list`, `insert`, `update`, `delete`) VALUES
(1, 1, 1, 1, 1, 1, 1),
(2, 1, 6, 1, 1, 1, 1),
(3, 1, 5, 1, 1, 1, 1),
(4, 1, 4, 1, 1, 1, 1),
(5, 1, 3, 1, 1, 1, 1),
(6, 1, 2, 1, 1, 1, 1),
(7, 1, 7, 1, 1, 1, 1),
(8, 1, 8, 1, 1, 1, 1),
(9, 4, 2, 1, 1, 1, 1),
(10, 4, 3, 1, 1, 1, 1),
(11, 4, 6, 1, 1, 1, 1),
(12, 4, 9, 0, 0, 0, 0),
(13, 1, 9, 1, 1, 1, 1),
(14, 1, 10, 1, 1, 1, 1),
(15, 1, 11, 1, 1, 1, 1),
(16, 5, 1, 1, 0, 0, 0),
(17, 5, 2, 1, 0, 0, 0),
(18, 5, 3, 1, 0, 0, 0),
(19, 5, 4, 1, 0, 0, 0),
(20, 5, 5, 1, 0, 0, 0),
(21, 5, 6, 1, 0, 0, 0),
(22, 5, 7, 1, 0, 0, 0),
(23, 5, 8, 1, 0, 0, 0),
(24, 5, 9, 1, 0, 0, 0),
(25, 5, 10, 1, 0, 0, 0),
(26, 5, 11, 1, 0, 0, 0),
(27, 4, 1, 0, 0, 0, 0),
(28, 2, 6, 1, 1, 1, 1),
(29, 1, 12, 1, 1, 1, 1),
(30, 3, 12, 1, 1, 1, 1),
(31, 3, 11, 1, 1, 1, 1),
(32, 2, 1, 1, 1, 1, 1),
(33, 2, 2, 1, 1, 1, 1),
(34, 2, 3, 1, 1, 1, 1),
(35, 2, 4, 1, 1, 1, 1),
(36, 2, 7, 0, 0, 0, 0),
(37, 1, 13, 1, 1, 1, 1),
(38, 1, 14, 1, 1, 1, 1),
(39, 1, 15, 1, 1, 1, 1),
(40, 2, 10, 1, 1, 1, 1),
(41, 2, 11, 1, 1, 1, 1),
(42, 2, 12, 0, 0, 0, 0),
(43, 2, 13, 1, 1, 1, 1),
(44, 2, 5, 1, 1, 1, 1),
(45, 2, 14, 1, 1, 1, 1),
(46, 2, 15, 1, 1, 1, 1),
(47, 3, 1, 1, 1, 1, 1),
(48, 3, 2, 1, 1, 1, 1),
(49, 3, 3, 1, 1, 1, 1),
(50, 3, 4, 1, 1, 1, 1),
(51, 3, 5, 1, 1, 1, 1),
(52, 3, 6, 1, 0, 0, 0),
(53, 3, 10, 1, 1, 1, 1),
(54, 3, 13, 1, 0, 0, 0),
(55, 3, 14, 1, 0, 0, 0),
(56, 3, 15, 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `school_years`
--

CREATE TABLE `school_years` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `school_years`
--

INSERT INTO `school_years` (`id`, `name`) VALUES
(3, '2018-2019'),
(2, '2017-2018');

-- --------------------------------------------------------

--
-- Table structure for table `shifts`
--

CREATE TABLE `shifts` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `shifts`
--

INSERT INTO `shifts` (`id`, `name`, `active`, `create_at`) VALUES
(2, 'Morning', 1, '2018-04-30 03:33:31'),
(3, 'Afternoon', 1, '2018-04-30 03:33:33'),
(4, 'Evening', 1, '2018-05-01 04:18:16');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` bigint(20) NOT NULL,
  `code` varchar(30) NOT NULL,
  `english_name` varchar(30) DEFAULT NULL,
  `khmer_name` varchar(30) DEFAULT NULL,
  `gender` varchar(9) NOT NULL,
  `dob` varchar(30) DEFAULT NULL,
  `pob` varchar(220) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `address` varchar(120) DEFAULT NULL,
  `photo` varchar(120) DEFAULT NULL,
  `branch_id` int(11) NOT NULL,
  `active` bit(1) NOT NULL DEFAULT b'1',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `university` varchar(120) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `code`, `english_name`, `khmer_name`, `gender`, `dob`, `pob`, `phone`, `email`, `address`, `photo`, `branch_id`, `active`, `create_at`, `university`) VALUES
(1, 'SR-001', 'KHUON Dyna', 'ឃួន ឌីណា', 'Female', '01/12/1994', NULL, '010121314', 'khuondyna@gmail.com', 'Terk Thla, Sensok, Phnom Penh', NULL, 1, b'1', '2018-09-05 04:22:00', 'Build Bright University'),
(2, 'SR-002', 'SOK Chansy', 'សុខ ចាន់ស៊ី', 'Male', '01/01/1997', NULL, '077565422', 'sokchansy@gmail.com', 'Borey Solar, Sen Sok, Phnom Penh', NULL, 1, b'1', '2018-09-05 04:24:47', 'Paññāsāstra University of Cambodia'),
(3, 'SR-003', 'NORM Malis', 'ណម ម៉ាលីស', 'Female', '01/06/1994', NULL, '017263555', 'nornmalis@gmail.com', 'Villa No. 22, Street Kramounsar, PhsarThmey II, Khan Daun Penh, Phnom Penh, Cambodia.', NULL, 1, b'1', '2018-09-05 04:32:17', 'Paññāsāstra University of Cambodia'),
(4, 'SR-004', 'UNG Chhunheng', 'អ៊ឹង ឈុនហេង', 'Male', '07/07/1997', NULL, '016252442', 'ungchhunheng@gmail.com', '#A1, A3, A5, Russian Blvd, Sangkat Teuk Thla, Khan Sen Sok, Phnom Penh', NULL, 1, b'1', '2018-09-05 04:33:54', 'International University'),
(5, 'SR-005', 'SAY Sarath', 'សាយ សារ៉ាត', 'Male', '03/07/1998', NULL, '099617622', 'saysarath@gmail.com', '#46, St. 360, BKKIII, CKM, Phnom Penh, Cambodia', NULL, 1, b'1', '2018-09-05 04:34:59', 'International University'),
(6, 'SR-006', 'SOK Samnang', 'សុខ សំណាង', 'Male', '03/02/1996', NULL, '010273664', 'soksamnang@gmail.com', 'No. 148, Sihanouk (St. 274), 12302 Phnom Penh', NULL, 1, b'1', '2018-09-05 04:37:06', 'Chamroeun University of Poly-Technology'),
(7, 'SR-007', 'SAM Rithy', 'សំ រិទ្ធី', 'Male', '01/01/1995', NULL, '010476659', 'samrithy333@gmail.com', 'Borey Solar, Sen Sok, Phnom Penh', NULL, 1, b'1', '2018-09-05 04:38:23', 'Asia Euro University'),
(8, 'SR-008', 'SAM AN Sostyva', 'សំអាន សូស្ទីវ៉ា', 'Male', '06/02/1991', NULL, '016255443', 'samansostyva@gmail.com', 'National Road 4, Sangkat Kambol, Khan Po Senchey, Phnom Penh, Cambodia', NULL, 1, b'1', '2018-09-05 04:39:51', 'Western University'),
(9, 'SR-009', 'SEM Puthy', 'សែម ពុទ្ធី', 'Male', '09/12/1998', NULL, '0962552288', 'samputhy@gmail.com', '#308 Monivong Blvd, Phnom Penh, Cambodia', NULL, 1, b'1', '2018-09-05 04:41:05', 'Western University'),
(10, 'SR-0010', 'KEN Nara', 'កែន ណារ៉ា', 'Female', '19/04/1989', NULL, '012387766', 'kennara@gmail.com', '#81A, St.344, Boeung Salang', NULL, 1, b'1', '2018-09-05 04:42:40', 'Limkokwing University of Creative Technology'),
(11, 'SR-0011', 'KHAT Sophoan', 'ខាត់ សោភ័ណ', 'Male', '28/01/1995', NULL, '0965543222', 'khatsophoan@gmail.com', '#571, Kampuchea Krom Blvd.', NULL, 1, b'1', '2018-09-05 04:44:26', 'Royal University of Phnom Penh'),
(12, 'SR-0012', 'SOUM Dany', 'ស៊ុំ ដានី', 'Female', '11/11/1993', NULL, '070996433', 'soumdany@gmail.com', '#14, Street 335, Sangkat Beong Kork 1, Khan Toul Kork, Phnom Penh', NULL, 1, b'1', '2018-09-05 04:45:57', 'Royal University of Phnom Penh'),
(13, 'SR-0013', 'TOUCH Samath', 'ទូច សំអាត', 'Male', '23/01/1991', NULL, '099553432', 'touchsamath@gmail.com', '#68,st.360, BKK3, Chamkamon, Phnom Penh', NULL, 1, b'1', '2018-09-05 04:48:38', 'University of Puthisastra'),
(14, 'SR-0014', 'NEANG Sareth', 'នាង សារ៉េត', 'Male', '26/09/1998', NULL, '099544328', 'neangsareth@gmail.com', '#200, Street 63, Phnom Penh, CAMBODIA', NULL, 1, b'1', '2018-09-05 04:50:31', 'Royal University of Phnom Penh'),
(15, 'SR-0015', 'HUN Sereyvathana', 'ហ៊ុន សេរីវឌ្ឍនា', 'Male', '06/10/1999', NULL, '010276543', 'hunsreyleavathana@gmail.com', 'No. 15E2 Norodom Blvd., Phnom Penh', NULL, 1, b'1', '2018-09-05 04:51:49', 'Royal University of Phnom Penh'),
(16, 'SR-0016', 'CHAN Virak', 'ច័ន្ទ វីរៈ', 'Male', '09/09/1994', NULL, '0972554443', 'chanvirak@gmail.com', '2AEo, St.271, Sangkat Toeuk Laak III, Khan Toul Kork, Phnom Penh', NULL, 1, b'1', '2018-09-05 04:53:24', 'Vanda Institute'),
(17, 'SR-0017', 'SENG Ngim', 'សេង  ងីម', 'Male', '09/01/1997', NULL, '0966333322', 'sengngim@gmail.com', 'No.1, Street 92 Wat Phnom, 12202, Cambodia', NULL, 1, b'1', '2018-09-05 04:54:50', 'Royal University of Phnom Penh'),
(18, 'SR-0018', 'LONG Khoeun', 'ឡុង ឃឿន', 'Male', '09/11/1998', NULL, '0964444222', 'langkhoeun@gmail.com', 'No. 148, Sihanouk (St. 274), 12302 Phnom Penh', NULL, 1, b'1', '2018-09-05 04:56:18', 'Paññāsāstra University of Cambodia'),
(19, 'SR-0019', 'HAY   Sakiry', 'ហៃ សគ្គ័គិរី', 'Male', '26/04/1995', NULL, '010288333', 'haysakiry@gmail.com', '123,st 228, Boeng Reang, Duan Penh, Phnom Penh, Cambodia', NULL, 1, b'1', '2018-09-05 04:57:39', 'CamEd Business School'),
(20, 'SR-0020', 'RATH Malay', 'រ័ត្ន  ម៉ាឡៃ', 'Female', '11/11/1989', NULL, '010477773', 'rathmalary@gmail.com', 'Phnom Penh, Daun Penh, Street 392', NULL, 1, b'1', '2018-09-05 04:58:59', 'Cambodian Mekong University'),
(21, 'SR-0021', 'Kong  Narine', 'គង់ ណារីន', 'Male', '13/09/1996', NULL, '011377387', 'kongnarine@gmail.com', '#80, Street 315, Sangkat Boeung Kak 2, Khan Toul Kok, Phnom Penh, Cambodia.', NULL, 1, b'1', '2018-09-05 05:00:32', 'Panha Chiet University'),
(22, 'SR-0022', 'SOENG Chantha', 'សឹុង​  ចាន់ថា', 'Female', '17/03/1993', NULL, '016559933', 'soengchantha@gmail.com', '#788, Monivong Blvd, Sangkat Beoung Trabek, Khan Chamkamorn, Phnom Penh', NULL, 1, b'1', '2018-09-05 05:02:57', 'Paññāsāstra University of Cambodia'),
(23, 'SR-0023', 'IY Sopheaktra', 'អ៊ី សុភ័ក្រ្តា', 'Male', '01/12/1998', NULL, '010887722', 'lysopheaktr@gmail.com', '3F, No.216B, Preah Norodom Boulevard (41), Khan Chamkarmorn, Phnom Phen', NULL, 1, b'1', '2018-09-05 05:04:53', 'Phnom Penh Institute of Technology'),
(24, 'SR-0024', 'PO Sothy', 'ណម ម៉ាលីស', 'Male', '01/05/1998', NULL, '0993524242', 'posothy@gmail.com', '#60, Monivong BLvd, Sangkat Wat Phnom, Khan Daun Penh, Phnom Penh', NULL, 1, b'1', '2018-09-05 05:06:22', 'International University'),
(25, 'SR-0025', 'OEUN  Chandararoth', 'អឿន ច័ន្ទដារារ័ត្ន', 'Male', '09/09/1999', NULL, '077553366', 'oeunchandaraoth@gmail.com', '5BD, St. 169, Vealvong, 7 Makara, Phnom Penh, Cambodia', NULL, 1, b'1', '2018-09-05 05:07:59', 'Panha Chiet University'),
(26, 'SR-0026', 'PICH Sophoan', 'ពេជ សោភ័ណ', 'Male', '04/08/1992', NULL, '098376666', 'pichsophoan@gmail.com', '26 Old August Site, Sothearos Boulevard, Phnom Penh 12301, Cambodia', NULL, 1, b'1', '2018-09-05 08:28:49', 'University of Puthisastra'),
(27, 'SR-0027', 'NHEM AKLINN', 'ញ៉ែម អលីន', 'Male', '24/01/1999', NULL, '099828382', 'nhemaklinn@gmail.com', '#206E0E1, St 155, Sangkat Toul Tompoung1 Khan Chamkamorn, Phnom Penh', NULL, 1, b'1', '2018-09-05 08:29:50', 'Royal University of Phnom Penh'),
(28, 'SR-0028', 'SVAY Somana', 'ស្វាយ សុម៉ាណា', 'Male', '23/03/1996', NULL, '010929322', 'svaysomana@gmail.com', 'Street 289, Sangkat Boeung Kak II, Khan Toul Kork, 12152 Phnom Penh', NULL, 1, b'1', '2018-09-05 08:32:15', 'Western University'),
(29, 'SR-0029', 'SONG Sokly', 'សុង សុខលី', 'Male', '09/12/1989', NULL, '092545436', 'songsokly@gmail.com', '#81-83, St.136, Phsar Kandal I, Daun Penh, Phnom Penh', NULL, 1, b'1', '2018-09-05 08:34:28', 'Cambodian Mekong University'),
(30, 'SR-0030', 'HOEUNG Virany', 'ហឹង វិរ៉ានី', 'Male', '13/07/1993', 'Prek Pra, Chbar Ampov, Phnom Penh', '0973228221', 'hoeungvirany@gmail.com', 'Prek Pra, Chbar Ampov, Phnom Penh', NULL, 1, b'1', '2018-09-05 08:36:06', 'Royal University of Phnom Penh'),
(31, 'SR-0031', 'SOR Somaly', 'ស សុម៉ាលី', 'Female', '21/09/1992', 'Borey hitech Luxury National road 1, Chbar ampov', '092848484', 'sorsomaly@gmail.com', 'Borey hitech Luxury National road 1, Chbar ampov', NULL, 1, b'1', '2018-09-05 08:37:16', 'University of Puthisastra'),
(32, 'SR-0032', 'LIM  Krissna', 'លឹម  គ្រឹស្នា', 'Male', '02/02/1993', 'No. 452, St; National 5, Sangkat Kilomater 6, Khan Ruesey keo, Phnom Penh, Cambodia', '093394499', 'limkrissna@gmail.com', 'No. 452, St; National 5, Sangkat Kilomater 6, Khan Ruesey keo, Phnom Penh, Cambodia', NULL, 1, b'1', '2018-09-05 08:41:31', 'Royal University of Phnom Penh'),
(33, 'SR-0033', 'MAM Bunsocheat', 'ម៉ម ប៊ុនសុជាតិ', 'Male', '02/09/1998', NULL, '096233933', 'mambunsocheat@gmail.com', '#24Eo,St 113 Sangkat Beoung Prolit, Khan7makara, Phnom Penh', NULL, 1, b'1', '2018-09-05 08:43:30', 'University of Puthisastra'),
(34, 'SR-0034', 'OUK Bunroeun', 'អ៊ុក  ប៊ុនរឿន', 'Male', '19/07/1998', 'Building #128 (Room 106) Russian Blvd. Sangkat Toek Laak I, Khan Toul Kok, Phnom Penh CAMBODIA', '012933399', 'oukbunroeun@gmail.com', 'Building #128 (Room 106) Russian Blvd. Sangkat Toek Laak I, Khan Toul Kok, Phnom Penh CAMBODIA', NULL, 1, b'1', '2018-09-05 08:44:51', 'Paññāsāstra University of Cambodia'),
(35, 'SR-0035', 'PHAL SOPHEA', 'ផល សុភា', 'Male', '14/11/1989', 'RYBE Hub (2nd floor), #222Eo, St. 184, Sangkat Boeung Raing, Khan Daun Penh, Phnom Penh, Cambodia', '0973553333', 'phalsophea@gmail.com', 'RYBE Hub (2nd floor), #222Eo, St. 184, Sangkat Boeung Raing, Khan Daun Penh, Phnom Penh, Cambodia', NULL, 1, b'1', '2018-09-05 08:46:04', 'Western University'),
(36, 'SR-0036', 'CHEA Yon', 'ជា យ៉ុន', 'Male', '15/01/1992', '#50, Chbar Ampov, Phnom Penh', '010233399', 'cheayon@gmail.com', '#50, Chbar Ampov, Phnom Penh', NULL, 1, b'1', '2018-09-05 08:47:37', 'International University'),
(37, 'SR-0037', 'BOUNCHAN YOUTTIROUNG', 'ប៊ុនចាន់ យុត្តិរុង', 'Male', '01/03/1997', '15, Street 242, Daun Penh, Phnom Penh', '010227744', 'bounchanyouttiroung@gmail.com', '15, Street 242, Daun Penh, Phnom Penh', NULL, 1, b'1', '2018-09-05 08:48:39', 'Cambodian Mekong University'),
(38, 'SR-0038', 'CHEY Leanghout', 'ជ័យ លាងហួត', 'Male', '21/01/1996', 'Villa No. 22, Street Kramounsar, PhsarThmey II, Phnom Penh,', '098333777', 'cheyleanghout@gmail.com', 'Villa No. 22, Street Kramounsar, PhsarThmey II, Phnom Penh,', NULL, 1, b'1', '2018-09-05 09:25:36', 'Paññāsāstra University of Cambodia'),
(39, 'SR-0039', 'MAN Sokchea', 'ម៉ន សុខជា', 'Male', '18/11/1997', 'house 212B, strret 155, Near Russian market', '012636464', 'mansokchea@gmail.com', 'house 212B, strret 155, Near Russian market', NULL, 1, b'1', '2018-09-05 09:27:44', 'International University'),
(40, 'SR-0040', 'HEN  Molika', 'ហែន មល្លិកា', 'Female', '12/12/1989', '#43CE, Street 456, Toul Tom Poung, Phnom Penh', '0963555333', 'henmolika@gmail.com', '#43CE, Street 456, Toul Tom Poung, Phnom Penh', NULL, 1, b'1', '2018-09-05 09:29:47', 'Panha Chiet University'),
(41, 'SR-0041', 'VIT Vuthy', 'វ៉ិត វុទ្ធី', 'Male', '01/12/1999', 'no. 121, Jalan PJS 11/2, Subang Indah, Bandar Sunway, 46150 Kuala Lumpur, Malaysia', '098372822', 'vitvuthy@gmail.com', 'no. 121, Jalan PJS 11/2, Subang Indah, Bandar Sunway, 46150 Kuala Lumpur, Malaysia', NULL, 1, b'1', '2018-09-05 09:31:17', 'CamEd Business School'),
(42, 'SR-0042', 'KEO Chhomyung', 'កែវ ឆោមយង់', 'Male', '16/12/1997', '#95, 4th floor, Preah Norodom Blvd., Phnom Penh', '017263636', 'keochhomyung@gmail.com', '#95, 4th floor, Preah Norodom Blvd., Phnom Penh', NULL, 1, b'1', '2018-09-05 09:33:07', 'Western University'),
(43, 'SR-0043', 'KONG Mealin', 'គង់ មាលីន', 'Male', '09/06/1995', 'No 18, Street 347, Boeung Kok I, Khan Toul Kork', '098273644', 'kongmealin@gmail.com', 'No 18, Street 347, Boeung Kok I, Khan Toul Kork', NULL, 1, b'1', '2018-09-05 09:34:17', 'Phnom Penh Institute of Technology'),
(44, 'SR-0044', 'ORN Samnang', 'អន សំណាង', 'Male', '25/10/1989', 'Building #19, St. 90, Sras Chork, Daun Penh, Phnom Penh.', '099668844', 'ornsamnang@gmail.com', 'Building #19, St. 90, Sras Chork, Daun Penh, Phnom Penh.', NULL, 1, b'1', '2018-09-05 09:35:53', 'Western University'),
(45, 'SR-0045', 'SIN Wadhanak', 'ស៊ិន វឌ្ឍនៈ', 'Male', '01/02/1999', '8 Burn Road #13-13 s369977 Singapore', '092353635', 'sinwadhanak@gmail.com', '8 Burn Road #13-13 s369977 Singapore', NULL, 1, b'1', '2018-09-05 09:36:51', 'Royal University of Phnom Penh'),
(46, 'SR-0046', 'TANN Ngy', 'តាន់ ងី', 'Male', '28/05/1994', '#39, Preah Sihanouk Blvd, Sankat Chaktomok, Khan Daun Penh, Phnom Penh', '011399334', 'tannngy@gmail.com', '#39, Preah Sihanouk Blvd, Sankat Chaktomok, Khan Daun Penh, Phnom Penh', NULL, 1, b'1', '2018-09-05 09:38:33', 'CamEd Business School'),
(47, 'SR-0047', 'SOR Vichey', 'ស វិជ័យ', 'Male', '13/07/1996', 'Prey Sala, Kakab, Phosen Chey, Phnom Penh', '0962555209', 'sorvichey@gmail.com', 'Borey Solar, Sen Sok, Phnom Penh', '47-qx6O50XG3d9Sr6pZg3ay.png', 1, b'1', '2018-09-05 09:42:59', 'Asia Euro University'),
(48, 'SR-0048', 'IM Bunthoeun', 'អ៊ឹម ប៊ុនធឿន', 'Male', '11/11/1998', '#10 VTRUST Office Center 2FB, St109, Phnom Penh, Cambodia', '0973551442', 'imbunthoeun@gmail.com', '#10 VTRUST Office Center 2FB, St109, Phnom Penh, Cambodia', NULL, 1, b'1', '2018-09-05 10:09:09', 'Royal University of Phnom Penh'),
(49, 'SR-0049', 'CHHEAK  Dara', 'ឈៀក តារា', 'Male', '01/12/1996', 'No.C41, Borei Sopheak Mongkol, Sangkat Chroy Changvar, Khan Russey Keo', '0162554423', 'chheakdara@gmail.com', 'No.C41, Borei Sopheak Mongkol, Sangkat Chroy Changvar, Khan Russey Keo', NULL, 1, b'1', '2018-09-05 10:10:19', 'Cambodian Mekong University'),
(50, 'SR-0050', 'UNG Rozaly', 'អ៊ុង រ៉ូហ្សាលី', 'Male', '19/02/1993', 'St. 169, Sangkat Veal Vong, Khan 7Makara, Phnom Penh, Kingdom of Cambodia', '099637733', 'ungrozaly@gmail.com', 'St. 169, Sangkat Veal Vong, Khan 7Makara, Phnom Penh, Kingdom of Cambodia', NULL, 1, b'1', '2018-09-05 10:11:15', 'University of Puthisastra'),
(51, 'SR-0051', 'SEAN Savy', 'ស៊ាន សាវី', 'Female', '11/01/1999', 'No. 245C, Street 271, Phnom Penh', '092288837', 'seansavy@gmail.com', 'No. 245C, Street 271, Phnom Penh', NULL, 1, b'1', '2018-09-05 10:14:17', 'Royal University of Phnom Penh'),
(52, 'SR-0052', 'ITH Ponndara', 'អ៊ិត ប៉ុណ្ណដារ៉ា', 'Male', '01/12/1992', 'Prek Pra, Chbar Ampov, Phnom Penh', '0112384448', 'ithponndara@gmail.com', 'Borey Solar, Sen Sok, Phnom Penh', NULL, 1, b'1', '2018-09-05 10:15:25', 'Paññāsāstra University of Cambodia'),
(53, 'SR-0053', 'OU Bunda', 'អ៊ូ ប៊ុនដា', 'Male', '11/10/1998', '#79 ce2, St.122, DepoIII, Toul kork, Phnom Penh', '093772288', 'oubunda@gmail.com', '#79 ce2, St.122, DepoIII, Toul kork, Phnom Penh', NULL, 1, b'1', '2018-09-05 10:16:47', 'University of Puthisastra'),
(54, 'SR-0054', 'AIM SOTHEA', 'អែម សុធា', 'Male', '24/01/1997', 'Street 275, boeungKok I , toulkork, Phnom Penh', '098377466', 'aimsothea@gmail.com', 'Street 275, boeungKok I , toulkork, Phnom Penh', NULL, 1, b'1', '2018-09-05 10:17:52', 'Panha Chiet University'),
(55, 'SR-0055', 'KIM Sothea', 'គីម សុធា', 'Male', '11/01/1992', '#14A, St. 392, BKK I, Chamkar Morn, Phnom Penh', '093288377', 'kimsothea@gmail.com', '#14A, St. 392, BKK I, Chamkar Morn, Phnom Penh', NULL, 1, b'1', '2018-09-05 10:20:28', 'Western University'),
(56, 'SR-0056', 'LUY Sokkheang', 'លុយ សុខឃាង', 'Male', '11/02/1997', 'Borey hitech Luxury National road 1, Chbar ampov, Phnom Penh', '092477488', 'luysokkheang@gmail.com', 'Borey Solar, Sen Sok, Phnom Penh', NULL, 1, b'1', '2018-09-05 10:21:32', 'Phnom Penh Institute of Technology'),
(57, 'SR-0057', 'SANG SAMBO', 'សាង សំបូរ', 'Male', '11/01/1998', '#46, St. 360, BKKIII, CKM, Phnom Penh, Cambodia', '092773999', 'sansambo@gmail.com', '#46, St. 360, BKKIII, CKM, Phnom Penh, Cambodia', NULL, 1, b'1', '2018-09-05 10:22:38', 'Panha Chiet University'),
(58, 'SR-0058', 'PEN Mom', 'ប៉ែន មុំ', 'Female', '10/01/1992', '#201, Street 63, Phnom Penh, CAMBODIA', '0976622662', 'penmom@gmail.com', '#201, Street 63, Phnom Penh, CAMBODIA', NULL, 1, b'1', '2018-09-05 10:23:35', 'University of Puthisastra'),
(59, 'SR-0059', 'HUOY Sithan', 'ហួយ ស៊ីថន', 'Male', '02/07/1994', 'No. 77B, Street 149 Veal Vong, Khan 7 Makara Phnom Penh', '017263557', 'huoysithan@gmail.com', 'No. 77B, Street 149 Veal Vong, Khan 7 Makara Phnom Penh', NULL, 1, b'1', '2018-09-05 10:25:04', 'Royal University of Phnom Penh'),
(60, 'SR-0060', 'CHAN Borey', 'ច័ន្ទ បូរី', 'Male', '21/09/1998', 'Prek Pra, Chbar Ampov, Phnom Penh', '077263555', 'chanborey@gmail.com', 'Prek Pra, Chbar Ampov, Phnom Penh', NULL, 1, b'1', '2018-09-05 10:26:25', 'Panha Chiet University'),
(61, 'SR-0061', 'THEANG Thida', 'ធាង ធិតា', 'Male', '20/11/1994', 'No. 245C, Street 271, Phnom Penh', '012933883', 'theangthida@gmail.com', 'No. 245C, Street 271, Phnom Penh', NULL, 1, b'1', '2018-09-05 10:27:51', 'CamEd Business School'),
(62, 'SR-0062', 'TY SIMARO', 'ទឺ សុីម៉ារ៉ូ', 'Male', '09/12/1997', '#29, Parkway Building, Mao Tse Toung Blvd., Chamkamon, PHNOM PENH, CAMBODIA.', '016288223', 'tysimaro@gmail.com', '#29, Parkway Building, Mao Tse Toung Blvd., Chamkamon, PHNOM PENH, CAMBODIA.', NULL, 1, b'1', '2018-09-05 10:29:05', 'International University'),
(63, 'SR-0063', 'SENG Leakhana', 'សេង លក្ខណា', 'Male', '12/03/1998', 'Prek Pra, Chbar Ampov, Phnom Penh', '010293848', 'sengleakhana@gmail.com', '#14, Street 335, Sangkat Beong Kork 1, Khan Toul Kork, Phnom Penh', NULL, 1, b'1', '2018-09-05 10:37:42', 'Paññāsāstra University of Cambodia'),
(64, 'SR-0064', 'TY  VUTHY', 'ទី វុទ្ធី', 'Male', '27/08/1992', '#46, St. 360, BKKIII, CKM, Phnom Penh, Cambodia', '016233844', 'tyvuthy@gmail.com', '#46, St. 360, BKKIII, CKM, Phnom Penh, Cambodia', NULL, 1, b'1', '2018-09-05 10:39:01', 'Cambodian Mekong University'),
(65, 'SR-0065', 'ROS BORANY', 'រស់ បូរ៉ានី', 'Male', '10/12/1992', 'No. 245C, Street 271, Phnom Penh', '092384773', 'rosborany@gmail.com', '#46, St. 360, BKKIII, CKM, Phnom Penh, Cambodia', NULL, 1, b'1', '2018-09-05 11:12:01', 'Phnom Penh Institute of Technology'),
(66, 'SR-0066', 'SENG Sopheap', 'សេង សុភាព', 'Male', '19/10/1995', 'No. 452, St; National 5, Sangkat Kilomater 6, Khan Ruesey keo, Phnom Penh, Cambodia', '093847664', 'sengsopheap@gmail.com', '#46, St. 360, BKKIII, CKM, Phnom Penh, Cambodia', NULL, 1, b'1', '2018-09-05 11:56:19', 'Western University'),
(67, 'SR-0067', 'MAO  Bunsoth', 'ម៉ៅ  ប៊ុនសុទ្ធ', 'Male', '24/10/1998', 'Prek Pra, Chbar Ampov, Phnom Penh', '092383888', 'maobunsoth@gmail.com', 'Prek Pra, Chbar Ampov, Phnom Penh', NULL, 1, b'1', '2018-09-05 11:57:23', 'Asia Euro University'),
(68, 'SR-0068', 'LIM Solida', 'លីម សុលីដា', 'Male', '07/07/1994', '#201, Street 63, Phnom Penh, CAMBODIA', '012373736', 'simsolida@gmail.com', '#200, Street 63, Phnom Penh, CAMBODIA', NULL, 1, b'1', '2018-09-05 11:59:08', 'Royal University of Phnom Penh'),
(69, 'SR-0069', 'MEN Soly', 'ម៉ែន សូលី', 'Male', '12/12/1997', 'Sangkat Kilomater 6, Khan Ruesey keo, Phnom Penh', '010283877', 'mensoly@gmail.com', 'Sangkat Kilomater 6, Khan Ruesey keo, Phnom Penh', NULL, 1, b'1', '2018-09-05 12:00:18', 'Western University'),
(70, 'SR-0070', 'Suorn Monika', 'សួន ម៉ូនីកា', 'Male', '25/10/1996', 'No. 245C, Street 271, Phnom Penh', '092883334', 'suornmonika@gmail.com', '#46, St. 360, BKKIII, CKM, Phnom Penh, Cambodia', NULL, 1, b'1', '2018-09-05 12:01:12', 'CamEd Business School');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `photo` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT 'default.png',
  `language` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en',
  `role_id` int(11) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`, `photo`, `language`, `role_id`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$10$/qD60q8mFQnqwnle0S2FLOKQcUMbdcqUDu4w0f7cNsl1lbIGTpq3m', 'IMJDX0kSBbnAkVN77wVhoEtioaAgklaHsVVX1gQWvbg3FJRERIgCbG8KVecq', '2017-05-27 22:35:52', '2017-05-27 22:35:52', '0.jpeg', 'en', 1),
(2, 'Receptionist 1', 'receptionist1@gmail.com', '$2y$10$hicRIEyPxO0pQcydl6zyNuq5.JDtROO5HYYw.2WUn12V8JmWHtXMC', 'q2mJHx48RkxGVbQ1HyNOYCoaH9B8VoKiNe3ydpzXc8fE0HcLjyIQ3XOSRLRH', NULL, NULL, 'default.png', 'en', 2),
(3, 'manager', 'manager@gmail.com', '$2y$10$vir3tq/PWznZX9f9LNVeCOo8KEIWPRAPMMQ8TOmsXo0g6TrN4TwVy', 'aLig4qpEWhroqBscqdLyngMp08nSNjbLAw7CgfIo4fom9fvbDuHYuvqnTBcR', NULL, NULL, 'default.png', 'en', 3),
(4, 'director', 'director@gmail.com', '$2y$10$EMRVaORyyaEMuXTO0q3Vi.ydfIhp9rch.OBqdWdt7oh4RQvqVlxkm', '6bg7oMOlXSzjDgPpmBCrZMEynFQIKv9haSWn4iTiKKXIvui5usSdFLHIFakh', NULL, NULL, '0.jpeg', 'en', 4),
(5, 'Receptionist 2', 'receptionist2@gmail.com', '$2y$10$ihRQuLHNuLUNcJsrWwpEKuLNg5xHDQlS2tv2CI21OEVffXlPTv1oK', '4BGxgXBmaMnERiSU6IDXxQiNN8aV3Sv9tJZM4hj71YjNjA4XtqJ5lzNtbf8Y', NULL, NULL, 'default.png', 'en', 2),
(7, 'Receptionist3', 'Receptionist3@gmail.com', '$2y$10$cLI8fc7iMABD5tttpmQWu.jYqGUuuCm8cwS807T3t9kXQxlB7436C', 'NumJdLpK61vXwwz4QkIaClK56OCjptcF2qGDArlOORknufxFiNxGlbR3jK4a', NULL, NULL, 'default.png', 'en', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_branches`
--

CREATE TABLE `user_branches` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_branches`
--

INSERT INTO `user_branches` (`id`, `user_id`, `branch_id`) VALUES
(1, 1, 1),
(2, 6, 1),
(3, 6, 2),
(4, 6, 3),
(5, 6, 4),
(6, 6, 5),
(7, 6, 6),
(8, 6, 7),
(9, 6, 8),
(10, 6, 9),
(11, 6, 10),
(12, 6, 11),
(13, 6, 12),
(14, 5, 13),
(15, 5, 14),
(16, 5, 15),
(17, 5, 16),
(18, 5, 17),
(19, 5, 18),
(20, 5, 19),
(21, 4, 20),
(22, 4, 21),
(23, 4, 22),
(24, 4, 23),
(25, 4, 24),
(26, 4, 25),
(27, 4, 26),
(28, 1, 2),
(29, 1, 3),
(30, 1, 4),
(31, 1, 5),
(32, 1, 6),
(33, 1, 7),
(34, 1, 8),
(35, 1, 9),
(36, 1, 10),
(37, 1, 11),
(38, 1, 12),
(39, 1, 13),
(40, 1, 14),
(41, 1, 15),
(42, 1, 16),
(43, 1, 17),
(44, 1, 18),
(45, 1, 19),
(46, 1, 20),
(47, 1, 21),
(48, 1, 22),
(49, 1, 23),
(50, 1, 24),
(51, 1, 25),
(52, 1, 26),
(53, 5, 1),
(54, 4, 1),
(55, 3, 1),
(56, 2, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `families`
--
ALTER TABLE `families`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice_detials`
--
ALTER TABLE `invoice_detials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_categories`
--
ALTER TABLE `item_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mails`
--
ALTER TABLE `mails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `open_classes`
--
ALTER TABLE `open_classes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registrations`
--
ALTER TABLE `registrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `school_years`
--
ALTER TABLE `school_years`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shifts`
--
ALTER TABLE `shifts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_branches`
--
ALTER TABLE `user_branches`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `families`
--
ALTER TABLE `families`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `invoice_detials`
--
ALTER TABLE `invoice_detials`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `item_categories`
--
ALTER TABLE `item_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `mails`
--
ALTER TABLE `mails`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `open_classes`
--
ALTER TABLE `open_classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `registrations`
--
ALTER TABLE `registrations`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `role_permissions`
--
ALTER TABLE `role_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `school_years`
--
ALTER TABLE `school_years`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `shifts`
--
ALTER TABLE `shifts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_branches`
--
ALTER TABLE `user_branches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
