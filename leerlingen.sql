-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 12, 2020 at 02:58 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `leerlingen`
--

-- --------------------------------------------------------

--
-- Table structure for table `leerlingen`
--

CREATE TABLE `leerlingen` (
  `id` int(9) NOT NULL,
  `voornaam` varchar(32) NOT NULL,
  `achternaam` varchar(32) NOT NULL,
  `email` varchar(32) NOT NULL,
  `telefoon` varchar(32) NOT NULL,
  `klas` int(3) NOT NULL,
  `punten` int(3) NOT NULL DEFAULT 50,
  `avatar` varchar(50) NOT NULL DEFAULT 'default.svg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `leerlingen`
--

INSERT INTO `leerlingen` (`id`, `voornaam`, `achternaam`, `email`, `telefoon`, `klas`, `punten`, `avatar`) VALUES
(1, 'Pjotr', 'Wisse', '84669@glr.nl', '03475343523', 1, 97, 'Kid30.svg'),
(2, 'Lars Jarred', 'Speetjens', 'lars@cubes.host', '0113223619', 1, 98, 'Kid9.svg'),
(3, 'Floris', 'Van der Waals', 'floris@waals.nl', '53487573957', 1, 99, 'Kid7.svg'),
(4, 'Giovanni', 'Eradus', 'boefjes@boevenplein.nl', '022371934523', 1, 96, 'default.svg'),
(5, 'Zeeshan', 'Ali', '484434@www.nl', '404394734985', 1, 50, 'Kid12.svg'),
(6, 'Dennis', 'Jochems', '484434@www.nl', '4567876543', 1, 41, 'Kid17.svg'),
(7, 'Tessa', 'De Beus', 'e434434jwe@jwl.nl', '3454567654', 1, 69, 'Kid14.svg'),
(8, 'Dawid', 'celinski', '9874348@glr.nl', '947495784958', 1, 78, 'Kid22.svg'),
(9, 'Calvin', 'Tangeman', '8487582@glr.nl', '884758490349587', 1, 12, 'Kid3.svg'),
(10, 'Thomas', 'van Otterloo', 'Otter@loo.otters', '5874839458', 1, 59, 'Kid11.svg'),
(11, 'Richayen', 'Kashie', '85204@glr.nl', '0313123319', 1, 50, 'Kid19.svg'),
(12, 'Maruf', 'Rodjan', 'appels@rodjan.maruf', '03948574343', 1, 87, 'Kid25.svg'),
(13, 'Linda', 'Speetjens', 'ellesse.goes@gmail.com', '113223619', 0, 50, 'Kid10.svg'),
(14, 'Martijn', 'Wisse', 'pimmetje_paniek@outlook.com', '31855784798393', 0, 50, 'Kid15.svg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(7) NOT NULL,
  `username` varchar(999) NOT NULL,
  `password` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'lars@cubes.host', '9e860fba8d4a603b2fefc0f766bf9c50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `leerlingen`
--
ALTER TABLE `leerlingen`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `leerlingen`
--
ALTER TABLE `leerlingen`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
