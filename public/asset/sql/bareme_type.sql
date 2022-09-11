-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 11, 2022 at 01:26 PM
-- Server version: 8.0.30-0ubuntu0.20.04.2
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `angifode`
--

-- --------------------------------------------------------

--
-- Table structure for table `type_bareme`
--

CREATE TABLE `type_bareme` (
  `id` int NOT NULL,
  `num_bar` varchar(6) NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `type_bareme`
--

INSERT INTO `type_bareme` (`id`, `num_bar`, `date_debut`, `date_fin`) VALUES
(1, 'BS01', '1961-01-01', '1969-06-30'),
(2, 'BS02', '1969-07-01', '1970-06-30'),
(3, 'BS03', '1970-07-01', '1971-12-31'),
(4, 'BS04', '1972-01-01', '1973-08-31'),
(5, 'BS05', '1973-09-01', '1974-06-30'),
(6, 'BS06', '1974-07-01', '1975-12-31'),
(7, 'BS07', '1976-01-01', '1977-06-30'),
(8, 'BS08', '1977-07-01', '1978-06-30'),
(9, 'BS09', '1978-07-01', '1979-11-30'),
(10, 'BS10', '1979-12-01', '1981-01-31'),
(11, 'BS11', '1981-02-01', '1981-11-30'),
(12, 'BS12', '1981-12-01', '1982-11-30'),
(13, 'BS13', '1982-12-01', '1983-10-31'),
(14, 'BS14', '1983-11-01', '1985-06-30'),
(15, 'BS15', '1985-07-01', '1992-12-31'),
(16, 'BS16', '1993-01-01', '1993-10-31'),
(17, 'BS17', '1993-11-01', '1997-01-31'),
(18, 'BS18', '1997-02-01', '2000-06-30'),
(19, 'BS19', '2000-07-01', '2008-03-31'),
(20, 'BS20', '2008-04-01', '2014-06-30'),
(21, 'BS21', '2014-07-01', '2030-12-31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `type_bareme`
--
ALTER TABLE `type_bareme`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `type_bareme`
--
ALTER TABLE `type_bareme`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
