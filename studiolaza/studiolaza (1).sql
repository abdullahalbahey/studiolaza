-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 29, 2022 at 05:50 AM
-- Server version: 5.7.31
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `studiolaza`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

DROP TABLE IF EXISTS `booking`;
CREATE TABLE IF NOT EXISTS `booking` (
  `booking_id` int(10) NOT NULL AUTO_INCREMENT,
  `customer_id` int(5) NOT NULL,
  `price` int(11) DEFAULT NULL,
  `balance` int(11) DEFAULT NULL,
  `booking_date` date NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`booking_id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`booking_id`, `customer_id`, `price`, `balance`, `booking_date`, `status`) VALUES
(1, 1, NULL, NULL, '2022-03-27', 2),
(2, 1, NULL, NULL, '2022-03-27', 2),
(3, 1, 0, 25000, '2022-03-27', 3),
(4, 1, NULL, NULL, '2022-03-28', 2),
(5, 1, NULL, NULL, '2022-03-28', 2),
(6, 1, NULL, NULL, '2022-03-28', 2),
(7, 1, NULL, NULL, '2022-03-28', 2),
(8, 1, NULL, NULL, '2022-03-28', 2),
(9, 1, NULL, NULL, '2022-03-28', 2),
(10, 1, NULL, NULL, '2022-03-28', 2),
(11, 1, 0, 25000, '2022-03-28', 1),
(12, 1, NULL, NULL, '2022-03-28', 2),
(13, 1, NULL, NULL, '2022-03-28', 2),
(14, 1, NULL, NULL, '2022-03-28', 2),
(15, 1, NULL, NULL, '2022-03-28', 2),
(16, 1, NULL, NULL, '2022-03-28', 2),
(17, 1, 199000, 199000, '2022-03-28', 0),
(18, 1, 49500, 49500, '2022-03-28', 0),
(19, 6, 256000, 25000, '2022-03-28', 1);

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

DROP TABLE IF EXISTS `contact_us`;
CREATE TABLE IF NOT EXISTS `contact_us` (
  `contact_id` int(10) NOT NULL AUTO_INCREMENT,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `message` varchar(150) NOT NULL,
  `message_replied` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`contact_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contact_us`
--

INSERT INTO `contact_us` (`contact_id`, `fname`, `lname`, `email`, `message`, `message_replied`) VALUES
(1, 'Abdulla', 'Al Bahey', 'abdullahalbahey01@gmail.com', 'How much is the basic package?', 'LKR 60,000'),
(2, 'Kumar', 'Raajmokan', 'abdullahalbahey01@gmail.com', 'How do you calculate traveling costs?', 'It costs LKR 50/ km');

-- --------------------------------------------------------

--
-- Table structure for table `costume`
--

DROP TABLE IF EXISTS `costume`;
CREATE TABLE IF NOT EXISTS `costume` (
  `costume_id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `image` varchar(100) NOT NULL,
  `price` int(7) NOT NULL,
  PRIMARY KEY (`costume_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
CREATE TABLE IF NOT EXISTS `customer` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `nic` varchar(20) NOT NULL,
  `line1` varchar(50) NOT NULL,
  `city` varchar(20) NOT NULL,
  `contact` int(10) NOT NULL,
  `v_status` int(1) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`customer_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `name`, `nic`, `line1`, `city`, `contact`, `v_status`, `user_id`) VALUES
(1, 'Fernando', '986896180V', '133A', 'Kandy', 776778980, 1, 3),
(2, 'John', '916678918V', '175B', 'Mathale', 768197865, 1, 4),
(3, 'Viranga', '886564985V', '19A', 'Kandy', 768118976, 1, 5),
(4, 'Mary', '686456298V', '134A', 'Galle', 710717178, 1, 6),
(5, 'Vinoth', '956875634V', '156C', 'Colombo', 758978543, 1, 7),
(6, 'Abdullah', '981533640v', '50A, Haneefa Road,', 'Kalmunai', 779897506, 1, 8);

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

DROP TABLE IF EXISTS `employee`;
CREATE TABLE IF NOT EXISTS `employee` (
  `employee_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `nic` varchar(20) NOT NULL,
  `line1` varchar(50) NOT NULL,
  `city` varchar(20) NOT NULL,
  `contact` int(10) NOT NULL,
  `enrolled` date NOT NULL,
  `roles` varchar(30) NOT NULL,
  `emptype` varchar(15) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`employee_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`employee_id`, `name`, `nic`, `line1`, `city`, `contact`, `enrolled`, `roles`, `emptype`, `user_id`) VALUES
(1, 'Maalik', '981533640v', '23 Cotta Road, Colombo 8', 'Rajagiriya', 779897506, '2022-03-29', 'Photographer', 'Permanent', 12),
(2, 'Shakir', '981435653v', '120, Haneefa Rd, Kalmunia', 'Kalmunai', 77123724, '2022-03-29', 'Photographer,Editor', 'Permanent', 13);

-- --------------------------------------------------------

--
-- Table structure for table `engagement`
--

DROP TABLE IF EXISTS `engagement`;
CREATE TABLE IF NOT EXISTS `engagement` (
  `engagement_id` int(10) NOT NULL AUTO_INCREMENT,
  `datee` date NOT NULL,
  `timee` time NOT NULL,
  `venuee` varchar(50) NOT NULL,
  `engagementdetails` varchar(500) DEFAULT NULL,
  `booking_id` int(11) NOT NULL,
  `price` int(11) DEFAULT NULL,
  `progress` int(1) DEFAULT NULL,
  `photographer_id` int(11) DEFAULT NULL,
  `p_charges` int(6) DEFAULT NULL,
  `editor_id` int(11) DEFAULT NULL,
  `e_charges` int(6) DEFAULT NULL,
  PRIMARY KEY (`engagement_id`),
  KEY `booking_id` (`booking_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `engagement`
--

INSERT INTO `engagement` (`engagement_id`, `datee`, `timee`, `venuee`, `engagementdetails`, `booking_id`, `price`, `progress`, `photographer_id`, `p_charges`, `editor_id`, `e_charges`) VALUES
(1, '2022-04-13', '14:18:00', 'sdbdhasd', '', 9, 0, NULL, NULL, NULL, NULL, NULL),
(2, '2022-04-13', '14:18:00', 'sdbdhasd', '', 10, 0, NULL, NULL, NULL, NULL, NULL),
(3, '2022-04-13', '14:18:00', 'sdbdhasd', '', 11, 0, 0, NULL, NULL, NULL, NULL),
(4, '2022-05-04', '15:00:00', 'Viharamahadevi Park, Colombo', '', 18, 0, NULL, NULL, NULL, NULL, NULL),
(5, '2022-04-07', '15:30:00', '64/2, Kuruppu Road, Borella, Colombo 8', 'Magazine_Family_Album+Photo_Cover_[8x12]_10/20 <br />\n', 19, 15000, 0, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `finance`
--

DROP TABLE IF EXISTS `finance`;
CREATE TABLE IF NOT EXISTS `finance` (
  `financeID` int(11) NOT NULL AUTO_INCREMENT,
  `orderID` int(10) NOT NULL,
  `financePurpose` varchar(20) NOT NULL,
  `otherFinancePurpose` varchar(40) DEFAULT NULL,
  `financeDate` date NOT NULL,
  `financeAmount` int(11) NOT NULL,
  `financeType` varchar(10) NOT NULL,
  PRIMARY KEY (`financeID`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `finance`
--

INSERT INTO `finance` (`financeID`, `orderID`, `financePurpose`, `otherFinancePurpose`, `financeDate`, `financeAmount`, `financeType`) VALUES
(1, 11, 'Advance Payment', '', '2022-03-28', 25000, 'income'),
(3, 19, 'Advance Payment', '', '2022-03-28', 25000, 'income'),
(4, 19, 'Balance Payment', '', '2022-03-29', 120000, 'income'),
(5, 19, 'Traveling Cost', '', '2022-03-30', 3500, 'expense'),
(6, 11, 'others', 'Food Expence', '2022-03-29', 1800, 'expense'),
(12, 11, 'Employee Salary', '', '2022-03-31', 12000, 'expense');

-- --------------------------------------------------------

--
-- Table structure for table `forgetpassword`
--

DROP TABLE IF EXISTS `forgetpassword`;
CREATE TABLE IF NOT EXISTS `forgetpassword` (
  `email` varchar(30) NOT NULL,
  `token` varchar(300) NOT NULL,
  `timecheck` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `homecoming`
--

DROP TABLE IF EXISTS `homecoming`;
CREATE TABLE IF NOT EXISTS `homecoming` (
  `homecoming_id` int(10) NOT NULL AUTO_INCREMENT,
  `datew` date NOT NULL,
  `timew` time NOT NULL,
  `venuew` varchar(50) NOT NULL,
  `homecomingdetails` varchar(500) DEFAULT NULL,
  `booking_id` int(11) NOT NULL,
  `price` int(11) DEFAULT NULL,
  `progress` int(1) DEFAULT NULL,
  `photographer_id` int(11) DEFAULT NULL,
  `p_charges` int(6) DEFAULT NULL,
  `editor_id` int(11) DEFAULT NULL,
  `e_charges` int(6) DEFAULT NULL,
  PRIMARY KEY (`homecoming_id`),
  KEY `booking_id` (`booking_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `homecoming`
--

INSERT INTO `homecoming` (`homecoming_id`, `datew`, `timew`, `venuew`, `homecomingdetails`, `booking_id`, `price`, `progress`, `photographer_id`, `p_charges`, `editor_id`, `e_charges`) VALUES
(1, '2022-04-26', '15:50:00', 'Home Venue', NULL, 5, NULL, NULL, NULL, NULL, NULL, NULL),
(2, '2022-04-26', '15:50:00', 'Home Venue', NULL, 6, NULL, NULL, NULL, NULL, NULL, NULL),
(3, '2022-04-26', '15:50:00', 'Home Venue', 'Magazine_Album_[30sheets/60pgs]_10x12<br />\nMagazine_Family_Album-Photo_Cover_[8x12]_10/20 <br />\nEnlargement_with_Frame 8x12 <br />\nThankingCard_6x6 <br />\nMagazine_Mini_Album_<br />\n', 8, 350000, NULL, NULL, NULL, NULL, NULL),
(4, '2022-04-26', '15:50:00', 'Home Venue', NULL, 10, NULL, NULL, NULL, NULL, NULL, NULL),
(5, '2022-04-26', '15:50:00', 'Home Venue', '', 11, 0, 0, NULL, NULL, NULL, NULL),
(6, '2022-06-03', '13:45:00', '64/2, Kuruppu Road, Borella, Colombo 8', '', 18, 0, NULL, NULL, NULL, NULL, NULL),
(7, '2022-04-29', '16:30:00', '64/2, Kuruppu Road, Borella, Colombo 8', 'Magazine_Album_[30sheets/60pgs]_10x12<br />\nEnlargement_with_Frame 8x12 <br />\n', 19, 25000, 0, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

DROP TABLE IF EXISTS `logs`;
CREATE TABLE IF NOT EXISTS `logs` (
  `login_id` int(30) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `type` varchar(1) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  PRIMARY KEY (`login_id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`login_id`, `username`, `type`, `date`, `time`) VALUES
(1, 'Fernando', 'C', '2022-03-27', '13:07:30'),
(2, 'admin', 'A', '2022-03-27', '20:03:26'),
(3, 'admin', 'A', '2022-03-27', '20:04:41'),
(4, 'Fernando', 'C', '2022-03-27', '20:08:24'),
(5, 'manager', 'M', '2022-03-27', '22:31:41'),
(6, 'manager', 'M', '2022-03-28', '04:42:42'),
(7, 'Fernando', 'C', '2022-03-28', '04:47:03'),
(8, 'manager', 'M', '2022-03-28', '06:47:51'),
(9, 'Fernando', 'C', '2022-03-28', '07:08:22'),
(10, 'manager', 'M', '2022-03-28', '07:24:23'),
(11, 'Fernando', 'C', '2022-03-28', '07:58:09'),
(12, 'manager', 'M', '2022-03-28', '10:55:30'),
(13, 'manager', 'M', '2022-03-28', '11:09:17'),
(14, 'manager', 'M', '2022-03-28', '14:01:12'),
(15, 'admin', 'A', '2022-03-28', '14:09:00'),
(16, 'manager', 'M', '2022-03-28', '14:24:03'),
(17, 'Fernando', 'C', '2022-03-28', '15:50:43'),
(18, 'manager', 'M', '2022-03-28', '16:48:15'),
(19, 'manager', 'M', '2022-03-28', '17:40:16'),
(20, 'manager', 'M', '2022-03-28', '18:09:57'),
(21, 'Fernando', 'C', '2022-03-28', '18:50:15'),
(22, 'abdulla01', 'C', '2022-03-28', '19:16:52'),
(23, 'abdulla01', 'C', '2022-03-28', '19:18:43'),
(24, 'abdulla01', 'C', '2022-03-28', '19:58:08'),
(25, 'manager', 'M', '2022-03-28', '20:19:23'),
(26, 'abdulla01', 'C', '2022-03-28', '20:25:29'),
(27, 'manager', 'M', '2022-03-28', '20:59:07'),
(28, 'manager', 'M', '2022-03-29', '02:51:21'),
(29, 'admin', 'A', '2022-03-29', '03:13:21'),
(30, 'manager', 'M', '2022-03-29', '03:15:09'),
(31, 'abdulla01', 'C', '2022-03-29', '04:25:42'),
(32, 'manager', 'M', '2022-03-29', '04:28:01'),
(33, 'abdulla01', 'C', '2022-03-29', '04:30:51'),
(34, 'admin', 'A', '2022-03-29', '04:34:42'),
(35, 'manager', 'M', '2022-03-29', '04:52:24'),
(36, 'admin', 'A', '2022-03-29', '04:54:00'),
(37, 'emp_shakir', 'E', '2022-03-29', '04:58:36'),
(38, 'manager', 'M', '2022-03-29', '05:11:03');

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

DROP TABLE IF EXISTS `notes`;
CREATE TABLE IF NOT EXISTS `notes` (
  `note_id` int(10) NOT NULL AUTO_INCREMENT,
  `content` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `event_type` int(1) NOT NULL,
  `event_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  PRIMARY KEY (`note_id`),
  KEY `employee_id` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

DROP TABLE IF EXISTS `packages`;
CREATE TABLE IF NOT EXISTS `packages` (
  `package_id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `price` int(6) NOT NULL,
  PRIMARY KEY (`package_id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`package_id`, `name`, `price`) VALUES
(1, 'Bride\'s Preparation Shoot-Venue', 15000),
(2, 'Bride\'s Preparation Shoot-Salon', 15000),
(3, 'Groom\'s Preparation Shoot-Venue', 10000),
(4, 'Magazine Main Album 30sheets/60pages with photo cover and box-10 x 12', 25000),
(5, 'Magazine Main Album 30sheets/60pages with photo cover and box-12 x 15', 30000),
(6, 'Magazine Mini Album', 5000),
(7, 'Magazine Family Album + Photo cover 8 x 12 10sheets/20pages', 10000),
(8, 'Magazine Family Album + Photo cover 8 x 12 15sheets/30pages', 15000),
(9, 'Pre Shoot Animated Slide Show', 5000),
(10, 'Group photos with Frame 12 x 18', 15000),
(11, 'Signature board 16 x 24', 4500),
(12, 'Soft copies in DVD', 5000),
(13, 'Same day wedding shoot slide show', 20000),
(14, 'Online Story book', 5000),
(15, 'Thanking card 6x6', 80),
(16, 'Thanking card 6x8', 100),
(17, 'Enlargement with frame 8 x 12', 2500),
(18, 'Enlargement with frame 12 x 18', 3500),
(19, 'Enlargement with frame 16 x 24', 4500),
(20, 'Enlargement with frame 20 x 30', 6000),
(21, 'Engagement coverage + Couple photo session + 8x12  Album [20 Spreads/40pgs + Photo Cover + Standard Box]', 40000),
(22, 'Engagement coverage + Couple photo session + 10x12 Album [20 Spreads/40pgs + Photo Cover + Standard Box]', 45000),
(23, 'Engagement coverage + Couple photo session + 12x15 Album [20 Spreads/40pgs + Photo Cover + Standard Box]', 50000),
(24, 'Home Coming / Reception Coverage + Couple Photo Session', 25000),
(25, 'Home Coming / Reception Coverage', 20000),
(26, 'Home Coming Couple Photo Session', 15000),
(27, '8x12 Magazine Pre Shoot Album 20 Spreads/ 40pgs', 15000),
(28, '10x12 Magazine Pre Shoot Album 20 Spreads/ 40pgs', 20000),
(29, '12x15 Magazine Pre Shoot Album 20 Spreads/ 40pgs', 25000),
(30, 'Pre Wedding Shoot 4hrs', 15000),
(31, 'Pre Wedding Shoot 8hrs', 25000);

-- --------------------------------------------------------

--
-- Table structure for table `portfolio`
--

DROP TABLE IF EXISTS `portfolio`;
CREATE TABLE IF NOT EXISTS `portfolio` (
  `portfolio_id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`portfolio_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `portfolio_image`
--

DROP TABLE IF EXISTS `portfolio_image`;
CREATE TABLE IF NOT EXISTS `portfolio_image` (
  `image_id` int(8) NOT NULL AUTO_INCREMENT,
  `image` varchar(100) NOT NULL,
  `portfolio_id` int(5) NOT NULL,
  PRIMARY KEY (`image_id`),
  KEY `portfolio_id` (`portfolio_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `preweddingshoot`
--

DROP TABLE IF EXISTS `preweddingshoot`;
CREATE TABLE IF NOT EXISTS `preweddingshoot` (
  `preweddingshoot_id` int(10) NOT NULL AUTO_INCREMENT,
  `dateh` date NOT NULL,
  `timeh` time NOT NULL,
  `venueh` varchar(50) NOT NULL,
  `preweddingshootdetails` varchar(500) DEFAULT NULL,
  `booking_id` int(11) NOT NULL,
  `price` int(11) DEFAULT NULL,
  `progress` int(1) DEFAULT NULL,
  `photographer_id` int(11) DEFAULT NULL,
  `p_charges` int(6) DEFAULT NULL,
  `editor_id` int(11) DEFAULT NULL,
  `e_charges` int(6) DEFAULT NULL,
  PRIMARY KEY (`preweddingshoot_id`),
  KEY `booking_id` (`booking_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `preweddingshoot`
--

INSERT INTO `preweddingshoot` (`preweddingshoot_id`, `dateh`, `timeh`, `venueh`, `preweddingshootdetails`, `booking_id`, `price`, `progress`, `photographer_id`, `p_charges`, `editor_id`, `e_charges`) VALUES
(1, '2022-04-11', '09:30:00', 'Victoria Park', 'Magazine_Preshoot_Album_[20sheets/40pgs]8x12<br />\n4<br />\n', 19, 30000, 0, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

DROP TABLE IF EXISTS `review`;
CREATE TABLE IF NOT EXISTS `review` (
  `review_id` int(10) NOT NULL AUTO_INCREMENT,
  `content` varchar(300) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `rating` int(1) NOT NULL,
  `customer_id` int(11) NOT NULL,
  PRIMARY KEY (`review_id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `thankingcard`
--

DROP TABLE IF EXISTS `thankingcard`;
CREATE TABLE IF NOT EXISTS `thankingcard` (
  `thankingcard_id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `image` varchar(100) NOT NULL,
  PRIMARY KEY (`thankingcard_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `thankingcard`
--

INSERT INTO `thankingcard` (`thankingcard_id`, `name`, `description`, `image`) VALUES
(1, 'Lassana Flower', '  From Lassana Flora', 'img/thankingcard/1.jpg'),
(2, 'a', ' tdty', 'img/thankingcard/loginwallpaper.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(40) NOT NULL,
  `password` varchar(500) NOT NULL,
  `type` varchar(1) NOT NULL,
  `email` varchar(30) NOT NULL,
  `image` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `password`, `type`, `email`, `image`) VALUES
(1, 'admin', '$2y$10$G6Yffli2DanNXoGiyHnZ9OhlrMKoJi5YjgHpzOKX6WmN02WcF81Ci', 'A', 'abc@gmail.com', NULL),
(2, 'manager', '$2y$10$gt8X/vf60UDpaXoVh6hzvue2jNOGkjs4Qo4bxTz/uMpbeQHsLaSxW', 'M', 'mbc@gmail.com', 'img/Kanishka.jpg'),
(3, 'Fernando', '$2y$10$kdrYDZhw8SlY6mL7oESmiO6PdEy.p0/eFCAUYAl9OgNOrxzdx/k8u', 'C', 'cus1@gmail.com', NULL),
(4, 'John', '$2y$10$kdrYDZhw8SlY6mL7oESmiO6PdEy.p0/eFCAUYAl9OgNOrxzdx/k8u', 'C', 'cus2@gmail.com', NULL),
(5, 'Viranga', '$2y$10$kdrYDZhw8SlY6mL7oESmiO6PdEy.p0/eFCAUYAl9OgNOrxzdx/k8u', 'C', 'cus3@gmail.com', NULL),
(6, 'Mary', '$2y$10$kdrYDZhw8SlY6mL7oESmiO6PdEy.p0/eFCAUYAl9OgNOrxzdx/k8u', 'C', 'cus4@gmail.com', NULL),
(7, 'Vinoth', '$2y$10$kdrYDZhw8SlY6mL7oESmiO6PdEy.p0/eFCAUYAl9OgNOrxzdx/k8u', 'C', 'cus5@gmail.com', NULL),
(8, 'abdulla01', '$2y$10$/Hp8InbZsMBvGUncYYNhOOaiCr.vlny5VBdyigmDqTzj5pJVUUcX.', 'C', 'boiya@gmail.com', ''),
(9, '', '$2y$10$zPz9rxJvkqR3ULYrDqULX.wg7pFF2Ms9tPUKIIjrrv81sZSdCf.LO', 'C', '', ''),
(10, '', '$2y$10$UVgFOM12PDHHerQUfFl0U.1Ekrcvcnx6PycOTV05Jy7HSi5w5gi26', 'C', '', ''),
(11, '', '$2y$10$Wq7MBwijoIxJdQ9Drz5h5uFEglFfQ2p42zboxwkskbGD5V0aL.XOu', 'C', '', ''),
(12, 'emp_maalik', '$2y$10$Ahz3/1ZfirdTg1Z7VO0nCOKaSyjUk4QTG9NWWJuouoZv/GjpcozzS', 'E', 'boiya123@gmail.com', ''),
(13, 'emp_shakir', '$2y$10$7c4mM3ChE4nYf9qhzFfgceRh7Ffag1K5abS06ljWbhCq1.TWjZNE6', 'E', 'emp_shakir@gmail.com', '');

-- --------------------------------------------------------

--
-- Table structure for table `wedding`
--

DROP TABLE IF EXISTS `wedding`;
CREATE TABLE IF NOT EXISTS `wedding` (
  `wedding_id` int(10) NOT NULL AUTO_INCREMENT,
  `datew` date NOT NULL,
  `timew` time NOT NULL,
  `venuew` varchar(50) NOT NULL,
  `weddingdetails` varchar(1000) DEFAULT NULL,
  `booking_id` int(11) NOT NULL,
  `thankingcard_id` int(11) DEFAULT NULL,
  `thankingcard_price` int(11) DEFAULT NULL,
  `thankingcard_detail` varchar(50) DEFAULT NULL,
  `costume_id` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `progress` int(1) DEFAULT NULL,
  `photographer_id` int(11) DEFAULT NULL,
  `p_charges` int(6) DEFAULT NULL,
  `editor_id` int(11) DEFAULT NULL,
  `e_charges` int(6) DEFAULT NULL,
  PRIMARY KEY (`wedding_id`),
  KEY `booking_id` (`booking_id`),
  KEY `thankingcard_id` (`thankingcard_id`),
  KEY `costume_id` (`costume_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wedding`
--

INSERT INTO `wedding` (`wedding_id`, `datew`, `timew`, `venuew`, `weddingdetails`, `booking_id`, `thankingcard_id`, `thankingcard_price`, `thankingcard_detail`, `costume_id`, `price`, `progress`, `photographer_id`, `p_charges`, `editor_id`, `e_charges`) VALUES
(1, '2022-04-12', '18:41:00', 'Shanhiri la', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, '2022-04-15', '23:59:00', 'Shanhiri la', 'Online_Story_book_Private <br />\n', 2, NULL, NULL, NULL, NULL, 5000, NULL, NULL, NULL, NULL, NULL),
(4, '2022-04-20', '12:41:00', 'Galadari', NULL, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, '2022-04-08', '14:47:00', 'Galadari', 'Bride\'s_Preparation_Shoot<br />\n', 5, NULL, NULL, NULL, NULL, 15000, NULL, NULL, NULL, NULL, NULL),
(6, '2022-04-08', '14:47:00', 'Galadari', '', 6, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(7, '2022-04-30', '17:28:00', 'ShangHiri La', '', 7, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(8, '2022-04-08', '14:47:00', 'Galadari', '', 8, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(9, '2022-04-08', '14:47:00', 'Galadari', '', 9, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(10, '2022-04-08', '14:47:00', 'Galadari', '', 10, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(11, '2022-04-08', '14:47:00', 'Galadari', '', 11, NULL, NULL, NULL, NULL, 0, 1, NULL, NULL, NULL, NULL),
(12, '2022-04-16', '19:57:00', 'Galadari', '', 12, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(13, '2022-04-27', '10:24:00', 'Cinnamon Lack Side, Colombo', NULL, 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, '2022-04-27', '10:24:00', 'Cinnamon Lack Side, Colombo', NULL, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(15, '2022-04-18', '10:00:00', 'Cinnamon Lack Side, Colombo', NULL, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, '2022-04-25', '13:30:00', 'Cinnamon Lake Side, Colombo', NULL, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, '2022-05-07', '13:32:00', 'Cinnamon Lake Side, Colombo', 'Bride\'s_Preparation_Shoot<br />\nEnlargement_with_Frame 8x12 <br />\nSignature_Board <br />\nWeddingDay_Shoot_SlideShow <br />\n', 17, 1, 0, 'ThankingCard_6x6 <br />\n', NULL, 99500, NULL, NULL, NULL, NULL, NULL),
(18, '2022-06-01', '10:40:00', 'Cinnamon Lake Side, Colombo', 'Bride\'s_Preparation_Shoot<br />\nGroom\'s_Preparation_Shoot_[Venue_of_Function]<br />\nSignature_Board <br />\nWeddingDay_Shoot_SlideShow <br />\n', 18, NULL, NULL, NULL, NULL, 49500, NULL, NULL, NULL, NULL, NULL),
(19, '2022-04-28', '10:30:00', 'Cinnamon Lake Side, Colombo', 'Bride\'s_Preparation_Shoot<br />\nMagazine_Album_[30sheets/60pgs]_10x12<br />\nMagazine_Mini_Album_<br />\nMagazine_Family_Album-Photo_Cover_[8x12]_10/20<br />\nEnlargement_with_Frame 8x12 <br />\nSignature_Board <br />\nWeddingDay_Shoot_SlideShow <br />\n', 19, 1, 0, 'ThankingCard_6x6 <br />\n', NULL, 85500, 0, NULL, NULL, NULL, NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON UPDATE CASCADE;

--
-- Constraints for table `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `customer_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON UPDATE CASCADE;

--
-- Constraints for table `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `employee_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON UPDATE CASCADE;

--
-- Constraints for table `engagement`
--
ALTER TABLE `engagement`
  ADD CONSTRAINT `engagement_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `booking` (`booking_id`) ON UPDATE CASCADE;

--
-- Constraints for table `homecoming`
--
ALTER TABLE `homecoming`
  ADD CONSTRAINT `homecoming_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `booking` (`booking_id`) ON UPDATE CASCADE;

--
-- Constraints for table `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `notes_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`employee_id`) ON UPDATE CASCADE;

--
-- Constraints for table `portfolio_image`
--
ALTER TABLE `portfolio_image`
  ADD CONSTRAINT `portfolio_image_ibfk_1` FOREIGN KEY (`portfolio_id`) REFERENCES `portfolio` (`portfolio_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `preweddingshoot`
--
ALTER TABLE `preweddingshoot`
  ADD CONSTRAINT `preweddingshoot_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `booking` (`booking_id`) ON UPDATE CASCADE;

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `wedding`
--
ALTER TABLE `wedding`
  ADD CONSTRAINT `wedding_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `booking` (`booking_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `wedding_ibfk_2` FOREIGN KEY (`thankingcard_id`) REFERENCES `thankingcard` (`thankingcard_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `wedding_ibfk_3` FOREIGN KEY (`costume_id`) REFERENCES `costume` (`costume_id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
