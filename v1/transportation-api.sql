-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 25, 2023 at 09:09 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `transportation-api`
--

-- --------------------------------------------------------

--
-- Table structure for table `agency`
--

CREATE TABLE `agency` (
  `agency_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `url` varchar(255) NOT NULL,
  `timezone` enum('sample') NOT NULL DEFAULT 'sample',
  `lang` text DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `fare_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `agency`
--

INSERT INTO `agency` (`agency_id`, `name`, `url`, `timezone`, `lang`, `phone`, `fare_url`) VALUES
(1, 'Société de transport de Montréal', 'http://www.stm.info,America/Montreal', 'sample', 'fr', '498-498-4844', 'http://www.stm.info/fr/infos/titres-et-tarifs');

-- --------------------------------------------------------

--
-- Table structure for table `fare`
--

CREATE TABLE `fare` (
  `fare_id` int(35) NOT NULL,
  `price decimal` decimal(10,0) DEFAULT NULL,
  `currency_type` text NOT NULL,
  `payment_method` enum('credit','debit','cash','gift card') NOT NULL DEFAULT 'debit',
  `transfers` int(11) DEFAULT NULL,
  `transfer_duration` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fare`
--

INSERT INTO `fare` (`fare_id`, `price decimal`, `currency_type`, `payment_method`, `transfers`, `transfer_duration`) VALUES
(1, '11', 'CAD', 'debit', NULL, 7200),
(2, '4', 'CAD', 'debit', NULL, 7200);

-- --------------------------------------------------------

--
-- Table structure for table `fare_rule`
--

CREATE TABLE `fare_rule` (
  `fare_rule_id` int(11) NOT NULL,
  `fare_id` int(11) DEFAULT NULL,
  `route_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fare_rule`
--

INSERT INTO `fare_rule` (`fare_rule_id`, `fare_id`, `route_id`) VALUES
(1, 1, NULL),
(2, 2, NULL),
(3, 1, NULL),
(4, 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `feed_info`
--

CREATE TABLE `feed_info` (
  `feed_info_id` int(255) NOT NULL,
  `publisher_name` text NOT NULL,
  `publisher_url` text NOT NULL,
  `lang` enum('en','fr') NOT NULL DEFAULT 'en',
  `start_date` date NOT NULL DEFAULT current_timestamp(),
  `end_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feed_info`
--

INSERT INTO `feed_info` (`feed_info_id`, `publisher_name`, `publisher_url`, `lang`, `start_date`, `end_date`) VALUES
(1, 'Société de transport de Montréal', 'http://www.stm.info', 'fr', '2023-01-09', '2023-06-18');

-- --------------------------------------------------------

--
-- Table structure for table `incident`
--

CREATE TABLE `incident` (
  `incident_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `primary_cause` varchar(25) NOT NULL,
  `secondary_cause` varchar(25) NOT NULL,
  `line_name` enum('Ligne orange','Ligne vert','Ligne bleu','Ligne jaune') NOT NULL,
  `symptom` varchar(25) NOT NULL,
  `incident_time` time NOT NULL,
  `start_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `incident`
--

INSERT INTO `incident` (`incident_id`, `date`, `primary_cause`, `secondary_cause`, `line_name`, `symptom`, `incident_time`, `start_time`) VALUES
(1, '2019-01-01', 'Autres', 'Autres', 'Ligne orange', 'Clientèle - Ligne orange', '03:42:00', '02:56:00'),
(2, '2019-01-01', 'Autres', 'Autres', 'Ligne vert', 'Clientèle - Ligne orange', '03:32:00', '02:56:00'),
(3, '2019-01-01', 'Autres', 'Autres', 'Ligne jaune', 'Clientèle - Ligne verte', '04:41:00', '03:35:00'),
(4, '2019-01-01', 'Autres', 'Autres', 'Ligne bleu', 'Clientèle - Ligne verte', '05:36:00', '04:56:00'),
(5, '2019-01-01', 'Autres', 'Autres', 'Ligne orange', 'Clientèle - Ligne verte', '05:54:00', '05:25:00');

-- --------------------------------------------------------

--
-- Table structure for table `route`
--

CREATE TABLE `route` (
  `route_id` int(11) NOT NULL,
  `agency_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `type` enum('Bus','Metro') NOT NULL,
  `url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `route`
--

INSERT INTO `route` (`route_id`, `agency_id`, `name`, `type`, `url`) VALUES
(1, 1, 'Verte', 'Metro', 'http://www.stm.info/fr/infos/reseaux/metro/verte'),
(2, 1, 'Orange', 'Metro', 'http://www.stm.info/fr/infos/reseaux/metro/orange'),
(3, 1, 'Jaune', 'Metro', 'http://www.stm.info/fr/infos/reseaux/metro/jaune'),
(4, 1, 'Bleue', 'Metro', 'http://www.stm.info/fr/infos/reseaux/metro/bleue'),
(5, 1, 'De Lorimier', 'Bus', 'http://www.stm.info/fr/infos/reseaux/bus'),
(6, 1, 'Parc-du-Mont-Royal / Ridgewood', 'Bus', 'http://www.stm.info/fr/infos/reseaux/bus'),
(7, 1, 'Île-des-Soeurs', 'Bus', 'http://www.stm.info/fr/infos/reseaux/bus'),
(9, 1, 'Atateken', 'Bus', 'http://www.stm.info/fr/infos/reseaux/bus'),
(10, 1, 'Pie-IX', 'Bus', 'http://www.stm.info/fr/infos/reseaux/bus/cote-des-neige');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`schedule_id`, `trip_id`, `arrival_time`, `departure_time`, `stop_id`, `stop_sequence`) VALUES
(1, 1, '05:13:00', '05:13:00', 1, 1),
(2, 2, '05:14:51', '05:14:51', 2, 2),
(3, 3, '05:16:12', '05:16:12', 3, 3),
(4, 4, '02:20:10', '05:17:00', 4, 4),
(8, 1, '09:10:01', '12:45:54', 1, 1);

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
  `start_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service`
--

INSERT INTO `service` (`service_id`, `monday`, `tuesday`, `wednesday`, `thursday`, `friday`, `saturday`, `sunday`, `start_date`, `end_date`) VALUES
(1, 1, 1, 1, 1, 0, 0, 0, '2023-01-09', '2023-03-24'),
(2, 0, 0, 0, 0, 1, 0, 0, '2023-01-09', '2023-03-24'),
(3, 1, 1, 1, 1, 1, 0, 0, '2023-01-09', '2023-03-24'),
(4, 1, 1, 1, 1, 1, 0, 0, '2023-01-09', '2023-03-24');

-- --------------------------------------------------------

--
-- Table structure for table `shape`
--

CREATE TABLE `shape` (
  `shape_id` int(11) NOT NULL,
  `shape_pt_lat` int(11) NOT NULL,
  `shape_pt_lon` int(11) NOT NULL,
  `shape_pt_sequence` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `code` text DEFAULT NULL,
  `name` text NOT NULL,
  `lat` decimal(9,6) NOT NULL,
  `lon` decimal(9,6) NOT NULL,
  `url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stop`
--

INSERT INTO `stop` (`stop_id`, `code`, `name`, `lat`, `lon`, `url`) VALUES
(1, '10118', 'STATION ANGRIGNON', '45.446466', '-73.603118', NULL),
(2, '10118', 'STATION ANGRIGNON', '45.446466', '-73.603118', 'http://www.stm.info/fr/infos/reseaux/metro/angrignon'),
(3, '10118', 'STATION ANGRIGNON', '45.446319', '-73.603835', NULL),
(4, '10120', 'STATION MONK', '45.451158', '-73.593242', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `trip`
--

CREATE TABLE `trip` (
  `trip_id` int(11) NOT NULL,
  `route_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `headsign` text NOT NULL,
  `shape_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trip`
--

INSERT INTO `trip` (`trip_id`, `route_id`, `service_id`, `headsign`, `shape_id`) VALUES
(1, 1, 1, 'STATION CÔTE-VERTU', 1),
(2, 2, 2, 'STATION MONTMORENCY', 2),
(3, 3, 3, 'STATION MONTMORENCY', 2),
(4, 4, 4, 'STATION CÔTE-VERTU', 1),
(6, 3, 1, 'STATION nigmail', 4);

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
  ADD KEY `fk_fare_route` (`route_id`);

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
  ADD KEY `fk_route_agency` (`agency_id`);

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
  ADD PRIMARY KEY (`trip_id`),
  ADD KEY `fk_trip_route` (`route_id`),
  ADD KEY `fk_trip_service` (`service_id`),
  ADD KEY `fk_trip_shape` (`shape_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agency`
--
ALTER TABLE `agency`
  MODIFY `agency_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `fare_rule`
--
ALTER TABLE `fare_rule`
  MODIFY `fare_rule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `feed_info`
--
ALTER TABLE `feed_info`
  MODIFY `feed_info_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `incident`
--
ALTER TABLE `incident`
  MODIFY `incident_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `route`
--
ALTER TABLE `route`
  MODIFY `route_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  MODIFY `trip_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `fare_rule`
--
ALTER TABLE `fare_rule`
  ADD CONSTRAINT `fare_rule_ibfk_1` FOREIGN KEY (`fare_id`) REFERENCES `fare` (`fare_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_fare_route` FOREIGN KEY (`route_id`) REFERENCES `route` (`route_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `route`
--
ALTER TABLE `route`
  ADD CONSTRAINT `agency_id` FOREIGN KEY (`agency_id`) REFERENCES `agency` (`agency_id`),
  ADD CONSTRAINT `fk_route_agency` FOREIGN KEY (`agency_id`) REFERENCES `agency` (`agency_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `fk_schedule_trip` FOREIGN KEY (`trip_id`) REFERENCES `trip` (`trip_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `trip`
--
ALTER TABLE `trip`
  ADD CONSTRAINT `fk_trip_route` FOREIGN KEY (`route_id`) REFERENCES `route` (`route_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_trip_service` FOREIGN KEY (`service_id`) REFERENCES `service` (`service_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_trip_shape` FOREIGN KEY (`shape_id`) REFERENCES `shape` (`shape_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
