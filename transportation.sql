-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 30, 2023 at 05:10 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `transportation`
--

-- --------------------------------------------------------

--
-- Table structure for table `agency`
--

CREATE TABLE `agency` (
  `agency_id` int(11) NOT NULL,
  `agency_name` text NOT NULL,
  `agency_url` varchar(255) NOT NULL,
  `agency_timezone` enum('sample') NOT NULL DEFAULT 'sample',
  `agency_lang` text DEFAULT NULL,
  `agency_phone` varchar(255) DEFAULT NULL,
  `agency_fare_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `agency`
--

INSERT INTO `agency` (`agency_id`, `agency_name`, `agency_url`, `agency_timezone`, `agency_lang`, `agency_phone`, `agency_fare_url`) VALUES
(1, 'Société de transport de Montréal', 'http://www.stm.info,America/Montreal', 'sample', 'fr', '498-498-4844', 'http://www.stm.info/fr/infos/titres-et-tarifs');

-- --------------------------------------------------------

--
-- Table structure for table `fare`
--

CREATE TABLE `fare` (
  `fare_id` varchar(35) NOT NULL,
  `price decimal` decimal(10,0) DEFAULT NULL,
  `currency_type` text NOT NULL,
  `payment_method` enum('credit','debit','cash','gift card') NOT NULL DEFAULT 'debit',
  `transfers` int(11) DEFAULT NULL,
  `transfer_duration` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `fare_rule`
--

CREATE TABLE `fare_rule` (
  `fare_rule_id` varchar(35) NOT NULL,
  `fare_id` varchar(35) NOT NULL,
  `route_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `feed_info`
--

CREATE TABLE `feed_info` (
  `feed_info_id` int(255) NOT NULL,
  `feed_publisher_name` text NOT NULL,
  `feed_publisher_url` text NOT NULL,
  `feed_lang` enum('en','fr') NOT NULL DEFAULT 'en',
  `feed_start_date` date NOT NULL DEFAULT current_timestamp(),
  `feed_end_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `incident`
--

CREATE TABLE `incident` (
  `incident_id` int(11) NOT NULL,
  `incident_date` date NOT NULL,
  `primary_cause` varchar(25) NOT NULL,
  `secondary_cause` varchar(25) NOT NULL,
  `symptom` varchar(25) NOT NULL,
  `incident_time` date NOT NULL,
  `start_time` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `incident`
--

INSERT INTO `incident` (`incident_id`, `incident_date`, `primary_cause`, `secondary_cause`, `symptom`, `incident_time`, `start_time`) VALUES
(1, '0000-00-00', 'Autres', 'Autres', 'Clientèle', '0000-00-00', '0000-00-00'),
(2, '0000-00-00', 'Autres', 'Autres', 'Clientèle', '0000-00-00', '0000-00-00'),
(3, '2019-01-01', 'Autres', 'Autres', 'Clientèle', '0000-00-00', '0000-00-00'),
(4, '2019-01-01', 'Autres', 'Autres', 'Clientèle', '0000-00-00', '0000-00-00'),
(5, '2020-01-01', 'Autres', 'Autres', 'Clientèle', '0000-00-00', '0000-00-00'),
(6, '2020-01-01', 'Autres', 'Autres', 'Clientèle', '0000-00-00', '0000-00-00'),
(7, '2021-01-01', 'Autres', 'Autres', 'Exploitation', '0000-00-00', '0000-00-00'),
(8, '2021-01-01', 'Autres', 'Autres', 'Exploitation', '0000-00-00', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `route`
--

CREATE TABLE `route` (
  `route_id` int(11) NOT NULL,
  `agency_id` int(11) NOT NULL,
  `route_short_name` text NOT NULL,
  `route_long_name` text NOT NULL,
  `route_type` enum('sample') NOT NULL DEFAULT 'sample',
  `route_url` varchar(255) NOT NULL,
  `route_color` enum('sample') NOT NULL DEFAULT 'sample',
  `route_text_color` enum('sample') NOT NULL DEFAULT 'sample'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `route`
--

INSERT INTO `route` (`route_id`, `agency_id`, `route_short_name`, `route_long_name`, `route_type`, `route_url`, `route_color`, `route_text_color`) VALUES
(1, 1, 'STM', 'Verte', 'sample', 'http://www.stm.info/fr/infos/reseaux/metro/verte', 'sample', 'sample'),
(2, 1, 'STM', 'De Lorimier', 'sample', 'http://www.stm.info/fr/infos/reseaux/bus', 'sample', 'sample'),
(4, 1, 'STM', 'Jaune', 'sample', 'http://www.stm.info/fr/infos/reseaux/metro/jaune', 'sample', 'sample'),
(5, 1, 'STM', 'Bleue', 'sample', 'http://www.stm.info/fr/infos/reseaux/metro/bleue', 'sample', 'sample');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `schedule_id` int(11) NOT NULL,
  `trip_id` int(11) NOT NULL,
  `arrival_time` time NOT NULL,
  `departure_time` time NOT NULL,
  `stop_id` int(11) NOT NULL,
  `stop_sequence` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE `service` (
  `service_id` int(11) NOT NULL,
  `monday` tinyint(1) NOT NULL,
  `tuesday` tinyint(1) NOT NULL,
  `wednesday` tinyint(1) NOT NULL,
  `thursday` tinyint(1) NOT NULL,
  `friday` tinyint(1) NOT NULL,
  `saturday` tinyint(1) NOT NULL,
  `sunday` tinyint(1) NOT NULL,
  `start_date` date NOT NULL DEFAULT current_timestamp(),
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `shape`
--

CREATE TABLE `shape` (
  `shape_id` int(11) NOT NULL,
  `shape_pt_lat` int(11) NOT NULL,
  `shape_pt_lon` int(11) NOT NULL,
  `shape_pt_sequence` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `shape`
--

INSERT INTO `shape` (`shape_id`, `shape_pt_lat`, `shape_pt_lon`, `shape_pt_sequence`) VALUES
(1, 45, -74, 10001),
(2, 45, -74, 10002),
(3, 45, -74, 20002),
(4, 45, -74, 30002),
(5, 45, -74, 40002);

-- --------------------------------------------------------

--
-- Table structure for table `stop`
--

CREATE TABLE `stop` (
  `stop_id` int(11) NOT NULL,
  `stop_code` text DEFAULT NULL,
  `stop_name` text NOT NULL,
  `stop_lat` int(11) NOT NULL,
  `stop_lon` int(11) NOT NULL,
  `stop_url` varchar(255) DEFAULT NULL,
  `location_type` enum('Ca','','','','') NOT NULL DEFAULT 'Ca',
  `parent_station` varchar(255) NOT NULL,
  `wheelchair_boarding` enum('yes','no') NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stop`
--

INSERT INTO `stop` (`stop_id`, `stop_code`, `stop_name`, `stop_lat`, `stop_lon`, `stop_url`, `location_type`, `parent_station`, `wheelchair_boarding`) VALUES
(1, NULL, '', 0, 0, NULL, 'Ca', '', 'no'),
(2, '10118', 'Station Angrignon', 45, -74, 'http://www.stm.info/fr/infos/reseaux/metro/angrignon', 'Ca', 'STATION_M118', 'no'),
(3, '[value-2]', '[value-3]', 0, 0, '[value-6]', '', '[value-8]', ''),
(4, '10120', 'Station Monk', 45, -74, 'http://www.stm.info/fr/infos/reseaux/metro/monk', 'Ca', 'STATION_M120', 'no'),
(5, '10122', 'Station Jolicoeur', 45, -74, 'http://www.stm.info/fr/infos/reseaux/metro/jolicoeur', 'Ca', 'STATION_M122', 'no'),
(6, '10124', 'Station Verdun', 45, -74, 'http://www.stm.info/fr/infos/reseaux/metro/verdun', 'Ca', 'STATION_M124', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `trip`
--

CREATE TABLE `trip` (
  `trip_id` int(11) NOT NULL,
  `route_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `shapes_id` int(11) NOT NULL,
  `direction_id` enum('sample') DEFAULT 'sample',
  `wheelchair_accessible` enum('sample') DEFAULT 'sample',
  `headsign` text NOT NULL,
  `note_en` text NOT NULL,
  `note_fr` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agency`
--
ALTER TABLE `agency`
  ADD PRIMARY KEY (`agency_id`);

--
-- Indexes for table `fare`
--
ALTER TABLE `fare`
  ADD PRIMARY KEY (`fare_id`);

--
-- Indexes for table `fare_rule`
--
ALTER TABLE `fare_rule`
  ADD PRIMARY KEY (`fare_rule_id`),
  ADD KEY `fare_id` (`fare_id`),
  ADD KEY `route_id` (`route_id`);

--
-- Indexes for table `feed_info`
--
ALTER TABLE `feed_info`
  ADD PRIMARY KEY (`feed_info_id`);

--
-- Indexes for table `incident`
--
ALTER TABLE `incident`
  ADD PRIMARY KEY (`incident_id`);

--
-- Indexes for table `route`
--
ALTER TABLE `route`
  ADD PRIMARY KEY (`route_id`),
  ADD KEY `agency_id` (`agency_id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`schedule_id`),
  ADD KEY `stop_id` (`stop_id`),
  ADD KEY `trip_id` (`trip_id`);

--
-- Indexes for table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`service_id`);

--
-- Indexes for table `shape`
--
ALTER TABLE `shape`
  ADD PRIMARY KEY (`shape_id`);

--
-- Indexes for table `stop`
--
ALTER TABLE `stop`
  ADD PRIMARY KEY (`stop_id`);

--
-- Indexes for table `trip`
--
ALTER TABLE `trip`
  ADD PRIMARY KEY (`trip_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agency`
--
ALTER TABLE `agency`
  MODIFY `agency_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `feed_info`
--
ALTER TABLE `feed_info`
  MODIFY `feed_info_id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `incident`
--
ALTER TABLE `incident`
  MODIFY `incident_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `route`
--
ALTER TABLE `route`
  MODIFY `route_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shape`
--
ALTER TABLE `shape`
  MODIFY `shape_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `stop`
--
ALTER TABLE `stop`
  MODIFY `stop_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `trip`
--
ALTER TABLE `trip`
  MODIFY `trip_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `fare_rule`
--
ALTER TABLE `fare_rule`
  ADD CONSTRAINT `fare_id` FOREIGN KEY (`fare_id`) REFERENCES `fare` (`fare_id`),
  ADD CONSTRAINT `route_id` FOREIGN KEY (`route_id`) REFERENCES `route` (`route_id`);

--
-- Constraints for table `route`
--
ALTER TABLE `route`
  ADD CONSTRAINT `agency_id` FOREIGN KEY (`agency_id`) REFERENCES `agency` (`agency_id`);

--
-- Constraints for table `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `stop_id` FOREIGN KEY (`stop_id`) REFERENCES `stop` (`stop_id`),
  ADD CONSTRAINT `trip_id` FOREIGN KEY (`trip_id`) REFERENCES `trip` (`trip_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
