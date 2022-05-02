-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Hostiteľ: localhost
-- Čas generovania: Út 04.Máj 2021, 19:00
-- Verzia serveru: 8.0.23-0ubuntu0.20.04.1
-- Verzia PHP: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáza: `zad7_geo`
--

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `stats_visits`
--

CREATE TABLE `stats_visits` (
  `id` int UNSIGNED NOT NULL,
  `country` varchar(64) NOT NULL,
  `sumary` int NOT NULL,
  `country_code` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Sťahujem dáta pre tabuľku `stats_visits`
--

INSERT INTO `stats_visits` (`id`, `country`, `sumary`, `country_code`) VALUES
(17, 'United States', 2, 'us'),
(18, 'Slovakia', 3, 'sk'),
(19, 'Canada', 2, 'ca'),
(20, 'France', 2, 'fr'),
(21, 'Germany', 1, 'de');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `visitors`
--

CREATE TABLE `visitors` (
  `id` int UNSIGNED NOT NULL,
  `ip` varchar(15) NOT NULL,
  `country` varchar(64) NOT NULL,
  `visit` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Sťahujem dáta pre tabuľku `visitors`
--

INSERT INTO `visitors` (`id`, `ip`, `country`, `visit`) VALUES
(24, '68.235.61.86', 'United States', '2021-04-25 02:36:25'),
(25, '206.189.180.94', 'United States', '2021-04-25 02:36:25'),
(26, '188.123.100.210', 'Slovakia', '2021-05-03 07:25:11'),
(27, '167.114.175.21', 'Canada', '2021-04-25 02:36:25'),
(28, '74.91.27.146', 'United States', '2021-04-25 02:36:53'),
(29, '104.149.150.230', 'United States', '2021-04-25 02:36:56'),
(30, '69.197.191.214', 'United States', '2021-04-25 02:37:01'),
(31, '69.30.224.166', 'United States', '2021-04-25 02:37:06'),
(32, '68.235.60.205', 'United States', '2021-04-25 02:37:17'),
(33, '164.132.162.219', 'France', '2021-04-25 02:37:24'),
(34, '217.182.175.75', 'France', '2021-04-25 02:37:30'),
(35, '145.239.165.168', 'France', '2021-04-25 02:37:35'),
(36, '176.31.227.198', 'France', '2021-04-25 02:37:39'),
(37, '54.39.133.107', 'Canada', '2021-04-25 02:37:51'),
(38, '135.148.32.86', 'United States', '2021-04-25 02:38:12'),
(39, '46.4.112.20', 'Germany', '2021-04-25 02:38:41'),
(40, '178.143.32.118', 'Slovakia', '2021-04-25 15:55:33'),
(41, '77.234.240.166', 'Slovakia', '2021-04-29 21:52:36');

--
-- Kľúče pre exportované tabuľky
--

--
-- Indexy pre tabuľku `stats_visits`
--
ALTER TABLE `stats_visits`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pre tabuľku `visitors`
--
ALTER TABLE `visitors`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pre exportované tabuľky
--

--
-- AUTO_INCREMENT pre tabuľku `stats_visits`
--
ALTER TABLE `stats_visits`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pre tabuľku `visitors`
--
ALTER TABLE `visitors`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
COMMIT;


--
-- Table structure for table `info`
--

CREATE TABLE `info` (
  `id` int UNSIGNED NOT NULL,
  `country` varchar(64) COLLATE utf8_slovak_ci NOT NULL,
  `country_kod` varchar(8) COLLATE utf8_slovak_ci NOT NULL,
  `city` varchar(64) COLLATE utf8_slovak_ci NOT NULL,
  `longtitude` int NOT NULL,
  `latitude` int NOT NULL,
  `data_time` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_slovak_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `info`
--
ALTER TABLE `info`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `info`
--
ALTER TABLE `info`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
