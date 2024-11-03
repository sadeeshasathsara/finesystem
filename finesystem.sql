-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 21, 2024 at 03:35 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `finesystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `username` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`username`, `name`, `password`) VALUES
('admin', 'John Doe', 'Password2'),
('admin2', 'Jane Smith', 'pwd2'),
('admin3', 'Alice Johnson', 'pwd3');

-- --------------------------------------------------------

--
-- Table structure for table `fine`
--

CREATE TABLE `fine` (
  `fid` int(11) NOT NULL,
  `fine_name` varchar(255) DEFAULT NULL,
  `details` text DEFAULT NULL,
  `fine_payment` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fine`
--

INSERT INTO `fine` (`fid`, `fine_name`, `details`, `fine_payment`) VALUES
(1, 'Speeding', 'Exceeding the speed limits', 30000),
(2, 'Running a Red Light', 'Failing to stop at a red traffic light', 5000),
(3, 'Illegal Parking', 'Parking in a no-parking zone', 2000),
(4, 'No Seatbelt', 'Not wearing a seatbelt while driving', 1500),
(5, 'Using Mobile Phone', 'Using a mobile phone while driving', 3000),
(6, 'Reckless Driving', 'Driving in a reckless or dangerous manner', 7000),
(7, 'Driving Under Influence', 'Driving under the influence of alcohol or drugs', 10000),
(8, 'Invalid License', 'Driving with an expired or invalid license', 5000),
(9, 'Uninsured Vehicle', 'Driving an uninsured vehicle', 6000),
(10, 'No Helmet', 'Riding a motorbike without a helmet', 2000),
(11, 'Failure to Signal', 'Not using indicators or signals', 1000),
(12, 'Overloading', 'Carrying more passengers than the vehicle\'s capacity', 2500),
(13, 'Illegal U-Turn', 'Making a U-turn where it is not allowed', 3000),
(14, 'Obstructing Traffic', 'Obstructing the flow of traffic', 1500),
(15, 'Not Yielding', 'Failing to yield to pedestrians or other vehicles', 2000),
(16, 'Faulty Lights', 'Driving with faulty headlights or tail lights', 1000),
(17, 'Excessive Smoke', 'Emitting excessive smoke from the vehicle', 3000),
(18, 'No Registration', 'Driving without a proper vehicle registration', 5000),
(19, 'No Emission Test', 'Driving without a valid emission test certificate', 2500),
(20, 'Breaking Traffic Rules', 'General violation of traffic rules', 2000),
(21, 'Test fine', 'test', 1000),
(22, 'Test 1', 'Test Description', 2000);

-- --------------------------------------------------------

--
-- Table structure for table `license`
--

CREATE TABLE `license` (
  `license_number` varchar(20) NOT NULL,
  `dob` date DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `expiry_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `license`
--

INSERT INTO `license` (`license_number`, `dob`, `address`, `name`, `expiry_date`) VALUES
('B0000001', '1994-10-21', 'Narmada, Gungamuw', 'Kamal Gunarathne', '2024-09-20');

-- --------------------------------------------------------

--
-- Table structure for table `license_holder`
--

CREATE TABLE `license_holder` (
  `nic` varchar(20) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `license_number` varchar(20) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `license_holder`
--

INSERT INTO `license_holder` (`nic`, `password`, `mobile`, `license_number`, `profile_picture`) VALUES
('149824577292', 'Password@1', '0700000003', 'B0000001', 'B0000001.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `license_notifications`
--

CREATE TABLE `license_notifications` (
  `license_number` varchar(20) NOT NULL,
  `notification_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `notification_id` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `pid` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_option`
--

CREATE TABLE `payment_option` (
  `card_number` char(16) NOT NULL,
  `license_number` varchar(50) NOT NULL,
  `cardholder_name` varchar(100) NOT NULL,
  `expiry_date` char(5) DEFAULT NULL,
  `cvv` char(3) NOT NULL,
  `billing_address` varchar(255) NOT NULL,
  `payment_method` varchar(50) NOT NULL DEFAULT 'Card',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_option`
--

INSERT INTO `payment_option` (`card_number`, `license_number`, `cardholder_name`, `expiry_date`, `cvv`, `billing_address`, `payment_method`, `created_at`, `updated_at`) VALUES
('1111111111111111', 'B0000001', 'Kamal Gunarathne', '10/24', '110', 'Narmada, Gungamuwa', 'Card', '2024-09-21 13:04:50', '2024-09-21 13:04:50');

-- --------------------------------------------------------

--
-- Table structure for table `penalty_fine`
--

CREATE TABLE `penalty_fine` (
  `fid` int(11) NOT NULL,
  `pid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penalty_fine`
--

INSERT INTO `penalty_fine` (`fid`, `pid`) VALUES
(4, 8722);

-- --------------------------------------------------------

--
-- Table structure for table `penalty_sheet`
--

CREATE TABLE `penalty_sheet` (
  `pid` int(11) NOT NULL,
  `police_id` varchar(255) DEFAULT NULL,
  `license_number` varchar(20) DEFAULT NULL,
  `issued_date` date DEFAULT NULL,
  `deadline` date DEFAULT NULL,
  `total_fine` decimal(10,2) NOT NULL DEFAULT 0.00,
  `payment_status` varchar(50) NOT NULL DEFAULT 'unpaid'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penalty_sheet`
--

INSERT INTO `penalty_sheet` (`pid`, `police_id`, `license_number`, `issued_date`, `deadline`, `total_fine`, `payment_status`) VALUES
(8722, 'P00001', 'B0000001', '2024-09-21', '2024-10-05', 1500.00, 'paid');

-- --------------------------------------------------------

--
-- Table structure for table `policeman`
--

CREATE TABLE `policeman` (
  `police_id` varchar(20) NOT NULL,
  `did` int(11) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `daily_target` int(2) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `position` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `policeman`
--

INSERT INTO `policeman` (`police_id`, `did`, `dob`, `mobile`, `address`, `name`, `password`, `daily_target`, `profile_picture`, `position`) VALUES
('P00001', 1, '2024-09-16', '0760722924', 'Updated', 'Asela Perera', '123', 15, 'P00001.jpg', 'Sergeant');

-- --------------------------------------------------------

--
-- Table structure for table `police_division`
--

CREATE TABLE `police_division` (
  `did` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `police_division`
--

INSERT INTO `police_division` (`did`, `name`) VALUES
(1, 'Colombo Central Police Division'),
(2, 'Kandy Police Division'),
(3, 'Galle Police Division'),
(4, 'Matara Police Division'),
(5, 'Jaffna Police Division'),
(6, 'Kurunegala Police Division'),
(7, 'Anuradhapura Police Division'),
(8, 'Ratnapura Police Division'),
(9, 'Negombo Police Division'),
(10, 'Trincomalee Police Division'),
(12, 'Horana Police Division');

-- --------------------------------------------------------

--
-- Table structure for table `police_notification`
--

CREATE TABLE `police_notification` (
  `police_id` varchar(255) NOT NULL,
  `notification_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `fine`
--
ALTER TABLE `fine`
  ADD PRIMARY KEY (`fid`);

--
-- Indexes for table `license`
--
ALTER TABLE `license`
  ADD PRIMARY KEY (`license_number`);

--
-- Indexes for table `license_holder`
--
ALTER TABLE `license_holder`
  ADD PRIMARY KEY (`nic`),
  ADD UNIQUE KEY `license_number` (`license_number`);

--
-- Indexes for table `license_notifications`
--
ALTER TABLE `license_notifications`
  ADD KEY `license_number` (`license_number`),
  ADD KEY `notification_id` (`notification_id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`notification_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `pid` (`pid`);

--
-- Indexes for table `payment_option`
--
ALTER TABLE `payment_option`
  ADD PRIMARY KEY (`card_number`);

--
-- Indexes for table `penalty_fine`
--
ALTER TABLE `penalty_fine`
  ADD PRIMARY KEY (`fid`,`pid`),
  ADD KEY `pid` (`pid`);

--
-- Indexes for table `penalty_sheet`
--
ALTER TABLE `penalty_sheet`
  ADD PRIMARY KEY (`pid`),
  ADD KEY `penalty_sheet_ibfk_1` (`police_id`),
  ADD KEY `penalty_sheet_ibfk_2` (`license_number`);

--
-- Indexes for table `policeman`
--
ALTER TABLE `policeman`
  ADD PRIMARY KEY (`police_id`),
  ADD KEY `did` (`did`);

--
-- Indexes for table `police_division`
--
ALTER TABLE `police_division`
  ADD PRIMARY KEY (`did`);

--
-- Indexes for table `police_notification`
--
ALTER TABLE `police_notification`
  ADD PRIMARY KEY (`police_id`,`notification_id`),
  ADD KEY `notification_id` (`notification_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fine`
--
ALTER TABLE `fine`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `penalty_sheet`
--
ALTER TABLE `penalty_sheet`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8724;

--
-- AUTO_INCREMENT for table `police_division`
--
ALTER TABLE `police_division`
  MODIFY `did` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `license_holder`
--
ALTER TABLE `license_holder`
  ADD CONSTRAINT `fk_license_license_holder` FOREIGN KEY (`license_number`) REFERENCES `license` (`license_number`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `license_notifications`
--
ALTER TABLE `license_notifications`
  ADD CONSTRAINT `license_notifications_ibfk_1` FOREIGN KEY (`license_number`) REFERENCES `license` (`license_number`),
  ADD CONSTRAINT `license_notifications_ibfk_2` FOREIGN KEY (`notification_id`) REFERENCES `notification` (`notification_id`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `penalty_sheet` (`pid`);

--
-- Constraints for table `penalty_fine`
--
ALTER TABLE `penalty_fine`
  ADD CONSTRAINT `penalty_fine_ibfk_1` FOREIGN KEY (`fid`) REFERENCES `fine` (`fid`),
  ADD CONSTRAINT `penalty_fine_ibfk_2` FOREIGN KEY (`pid`) REFERENCES `penalty_sheet` (`pid`);

--
-- Constraints for table `penalty_sheet`
--
ALTER TABLE `penalty_sheet`
  ADD CONSTRAINT `penalty_sheet_ibfk_1` FOREIGN KEY (`police_id`) REFERENCES `policeman` (`police_id`),
  ADD CONSTRAINT `penalty_sheet_ibfk_2` FOREIGN KEY (`license_number`) REFERENCES `license` (`license_number`);

--
-- Constraints for table `policeman`
--
ALTER TABLE `policeman`
  ADD CONSTRAINT `policeman_ibfk_1` FOREIGN KEY (`did`) REFERENCES `police_division` (`did`);

--
-- Constraints for table `police_notification`
--
ALTER TABLE `police_notification`
  ADD CONSTRAINT `police_notification_ibfk_1` FOREIGN KEY (`police_id`) REFERENCES `policeman` (`police_id`),
  ADD CONSTRAINT `police_notification_ibfk_2` FOREIGN KEY (`notification_id`) REFERENCES `notification` (`notification_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
