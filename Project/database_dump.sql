-- phpMyAdmin SQL Dump
-- version 4.6.6deb5ubuntu0.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 23, 2023 at 04:41 PM
-- Server version: 5.7.35-0ubuntu0.18.04.1
-- PHP Version: 7.2.24-0ubuntu0.18.04.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `id` int(5) NOT NULL,
  `manufactor` varchar(30) COLLATE utf8_lithuanian_ci NOT NULL,
  `model` varchar(30) COLLATE utf8_lithuanian_ci NOT NULL,
  `year` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`id`, `manufactor`, `model`, `year`) VALUES
(1, 'Ford', 'Fiesta', 2009),
(2, 'Volkswagen', 'Golf', 2004),
(3, 'Fiat', '500', 2010),
(5, 'Peugeot', '307', 2004),
(6, 'Volkswagen', 'Passat', 2008);

-- --------------------------------------------------------

--
-- Table structure for table `duk`
--

CREATE TABLE `duk` (
  `id` int(5) NOT NULL,
  `question` varchar(255) COLLATE utf8_lithuanian_ci NOT NULL,
  `answer` varchar(255) COLLATE utf8_lithuanian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

--
-- Dumping data for table `duk`
--

INSERT INTO `duk` (`id`, `question`, `answer`) VALUES
(1, 'Ar visas prekes turite vietoje?', 'Prisijungę prie paskyros galite matyti norimos prekės likutį.'),
(2, 'Kokius automobilius modifikuojate?', 'Modifikuojamus automobilius galite peržiūrėti atsidarę skyrelį \"Tiuningas\".'),
(10, 'Jei turiu klausimų, ar galima susisiekti?', 'Visi sistemos nariai gali bendrauti su administratoriumi žinutėmis.');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(5) NOT NULL,
  `sender` varchar(30) COLLATE utf8_lithuanian_ci NOT NULL,
  `receiver` varchar(30) COLLATE utf8_lithuanian_ci NOT NULL,
  `message` varchar(255) COLLATE utf8_lithuanian_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sender`, `receiver`, `message`, `timestamp`) VALUES
(7, 'narys2', 'admin', 'Kiek trunka pristatymas?', '2023-11-21 13:21:52'),
(8, 'admin', 'narys2', 'Iki 4 d.d., jei turime sandelyje. ', '2023-11-21 13:23:01'),
(11, 'narys', 'admin', 'Ar mano užsakyta prekė atvyks laiku?', '2023-11-21 18:27:13'),
(12, 'admin', 'narys', 'Taip, prekė jau pakeliui.', '2023-11-21 18:27:49');

-- --------------------------------------------------------

--
-- Table structure for table `modifications`
--

CREATE TABLE `modifications` (
  `id` int(5) NOT NULL,
  `name` varchar(100) COLLATE utf8_lithuanian_ci NOT NULL,
  `car_manufactor` varchar(30) COLLATE utf8_lithuanian_ci NOT NULL,
  `car_model` varchar(30) COLLATE utf8_lithuanian_ci NOT NULL,
  `car_year` year(4) NOT NULL,
  `price` decimal(6,2) NOT NULL,
  `count` int(5) NOT NULL,
  `delivery` varchar(100) COLLATE utf8_lithuanian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

--
-- Dumping data for table `modifications`
--

INSERT INTO `modifications` (`id`, `name`, `car_manufactor`, `car_model`, `car_year`, `price`, `count`, `delivery`) VALUES
(1, 'Spoileris', 'Ford', 'Fiesta', 2009, '99.00', 1, '1-2 d.d.'),
(2, 'Ratlankiai (komplektas)', 'Ford', 'Fiesta', 2009, '149.00', 1, '3-4 d.d.'),
(3, 'Bamperis', 'Volkswagen', 'Golf', 2004, '112.00', 0, '11 d.d.'),
(4, 'Kapotas', 'Ford', 'Fiesta', 2009, '50.00', 1, '1-2 d.d.'),
(5, 'Priekinės durys (kairė pusė)', 'Volkswagen', 'Golf', 2004, '80.00', 3, '1-2 d.d.'),
(9, 'Priekinis stiklas', 'Peugeot', '307', 2004, '259.95', 1, '1-2 d.d.'),
(10, 'Priekinis žibintas (k.p.)', 'Volkswagen', 'Passat', 2008, '118.67', 5, '4 d.d.');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(5) NOT NULL,
  `user` varchar(30) COLLATE utf8_lithuanian_ci NOT NULL,
  `modification_name` varchar(100) COLLATE utf8_lithuanian_ci NOT NULL,
  `car_data` varchar(100) COLLATE utf8_lithuanian_ci NOT NULL,
  `price` decimal(5,2) NOT NULL,
  `delivery` varchar(100) COLLATE utf8_lithuanian_ci NOT NULL,
  `status` int(4) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user`, `modification_name`, `car_data`, `price`, `delivery`, `status`, `timestamp`) VALUES
(1, 'narys', 'Spoileris', 'Ford Fiesta 2009', '99.00', '1-2 d.d.', 3, '2023-11-12 18:25:31'),
(9, 'narys', 'Ratlankiai (komplektas)', 'Ford Fiesta 2009', '149.00', '3-4 d.d.', 2, '2023-11-12 18:25:31'),
(12, 'narys', 'Priekinės durys (kairė pusė)', 'Volkswagen Golf 2004', '80.00', '1-2 d.d.', 1, '2023-11-12 18:25:31'),
(13, 'narys', 'Priekinis stiklas', 'Peugeot 307 2004', '259.95', '1-2 d.d.', 3, '2023-11-12 18:31:13'),
(14, 'narys2', 'Bamperis', 'Volkswagen Golf 2004', '112.00', '11 d.d.', 1, '2023-11-12 18:53:55'),
(15, 'narys2', 'Priekinis žibintas (k.p.)', 'Volkswagen Passat 2008', '118.67', '4 d.d.', 1, '2023-11-12 18:56:32'),
(16, 'narys2', 'Kapotas', 'Ford Fiesta 2009', '50.00', '1-2 d.d.', 2, '2023-11-21 13:25:21');

-- --------------------------------------------------------

--
-- Table structure for table `order_status`
--

CREATE TABLE `order_status` (
  `id` int(11) NOT NULL,
  `value` varchar(100) COLLATE utf8_lithuanian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

--
-- Dumping data for table `order_status`
--

INSERT INTO `order_status` (`id`, `value`) VALUES
(1, 'Pateiktas'),
(2, 'Ruošiamas'),
(3, 'Paruoštas');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(5) NOT NULL,
  `text` varchar(255) COLLATE utf8_lithuanian_ci NOT NULL,
  `username` varchar(30) COLLATE utf8_lithuanian_ci NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `text`, `username`, `date`) VALUES
(1, 'Puikus aptarnavimas.', 'Ad1', '2023-10-31 00:00:00'),
(14, 'Labai gerai.', 'narys', '2023-11-03 18:37:51'),
(20, 'labai labai gerai', 'narys2', '2023-11-21 16:08:31');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userid` varchar(32) COLLATE utf8_lithuanian_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_lithuanian_ci NOT NULL,
  `username` varchar(30) COLLATE utf8_lithuanian_ci NOT NULL,
  `password` varchar(32) COLLATE utf8_lithuanian_ci NOT NULL,
  `userlevel` tinyint(1) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `email`, `username`, `password`, `userlevel`, `timestamp`) VALUES
('2e0d1d3baee407f0a296a83c858beb2c', 'supplier1@ktu.lt', 'supplier1', '6fe6353aefcec66b7aaed466682184b9', 4, '2023-11-22 14:14:07'),
('36d2e61088b1693a58281b41de8f27d1', 'narys@ktu.lt', 'narys', '1ad9311f4de255335fef7686da94155e', 2, '2023-11-22 16:29:53'),
('47343b6c19b925baff3a1cdfbd49534e', 'admin1@ktu.lt', 'ad1', 'b1486ad95a1398e3eeb3d83bc4010015', 3, '2023-11-03 16:38:49'),
('4e211a2c92b884756c1ac88f68e79974', 'demo@ktu.lt', 'demo', '16c354b68848cdbd8f54a226a0a55b21', 2, '2023-11-02 20:31:40'),
('8849ebcfabb87b9fef664e2de25eccd6', 'admin@ktu.lt', 'admin', '6e5b5410415bde908bd4dee15dfb167a', 3, '2023-11-22 16:30:06'),
('90b175808d6809986b99d62f820f8101', 'narys2@ktu.lt', 'narys2', 'de181377263209ae1680f76a59c5f076', 2, '2023-11-22 16:23:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `duk`
--
ALTER TABLE `duk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `modifications`
--
ALTER TABLE `modifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `duk`
--
ALTER TABLE `duk`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `modifications`
--
ALTER TABLE `modifications`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
