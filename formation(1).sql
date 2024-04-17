-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2023 at 06:22 PM
-- Server version: 5.7.17
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `formation`
--

-- --------------------------------------------------------

--
-- Table structure for table `formation`
--

CREATE TABLE `formation` (
  `id` varchar(30) NOT NULL,
  `intitule` varchar(250) DEFAULT NULL,
  `formateur` varchar(50) DEFAULT NULL,
  `description` varchar(250) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `nbPlace` int(11) DEFAULT NULL,
  `nbReservation` int(11) DEFAULT NULL,
  `prix` decimal(10,0) DEFAULT NULL,
  `score` decimal(10,0) DEFAULT NULL,
  `nbScore` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `id` varchar(30) NOT NULL,
  `etat` int(1) DEFAULT NULL,
  `login` varchar(50) DEFAULT NULL,
  `id_formation` varchar(30) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `login` varchar(50) NOT NULL,
  `password` varchar(250) DEFAULT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `cin` varchar(8) DEFAULT NULL,
  `date_naiss` date DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `role` int(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `utilisateur`
--

INSERT INTO `utilisateur` (`login`, `password`, `nom`, `cin`, `date_naiss`, `email`, `role`) VALUES
('admin', 'admin', 'admin', '1111111', '2023-04-03', 'admin@admin.com', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `formation`
--
ALTER TABLE `formation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_formation` (`id_formation`),
  ADD KEY `login` (`login`);

--
-- Indexes for table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`login`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
