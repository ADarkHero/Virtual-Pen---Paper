-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 30, 2018 at 12:57 PM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 5.6.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rpg`
--

-- --------------------------------------------------------

--
-- Table structure for table `characters`
--

CREATE TABLE `characters` (
  `id` int(11) NOT NULL,
  `account` int(11) NOT NULL,
  `firstName` text NOT NULL,
  `title` varchar(255) NOT NULL,
  `lastName` text NOT NULL,
  `sex` varchar(10) NOT NULL,
  `birthday` text NOT NULL,
  `age` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  `size` int(11) NOT NULL,
  `eyes` varchar(255) NOT NULL,
  `hair` varchar(255) NOT NULL,
  `race` varchar(255) NOT NULL,
  `subrace` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `subclass` varchar(255) NOT NULL,
  `weapon` varchar(255) NOT NULL,
  `subweapon` varchar(255) NOT NULL,
  `mainPicture` varchar(255) NOT NULL,
  `secondaryPicture` varchar(255) NOT NULL,
  `tertiaryPicture` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `courage` int(11) NOT NULL,
  `wisdom` int(11) NOT NULL,
  `intuition` int(11) NOT NULL,
  `charisma` int(11) NOT NULL,
  `dexterity` int(11) NOT NULL,
  `agility` int(11) NOT NULL,
  `physique` int(11) NOT NULL,
  `strenght` int(11) NOT NULL,
  `lpmax` int(11) NOT NULL,
  `lpcurrent` int(11) NOT NULL,
  `manamax` int(11) NOT NULL,
  `manacurrent` int(11) NOT NULL,
  `experience` int(11) NOT NULL,
  `unusedExperience` int(11) NOT NULL,
  `fightingTalents` text NOT NULL,
  `bodyTalents` text NOT NULL,
  `societyTalents` text NOT NULL,
  `natureTalents` text NOT NULL,
  `knowledgeTalents` text NOT NULL,
  `craftTalents` text NOT NULL,
  `publicEntry` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `characters`
--

INSERT INTO `characters` (`id`, `account`, `firstName`, `title`, `lastName`, `sex`, `birthday`, `age`, `weight`, `size`, `eyes`, `hair`, `race`, `subrace`, `class`, `subclass`, `weapon`, `subweapon`, `mainPicture`, `secondaryPicture`, `tertiaryPicture`, `description`, `courage`, `wisdom`, `intuition`, `charisma`, `dexterity`, `agility`, `physique`, `strenght`, `lpmax`, `lpcurrent`, `manamax`, `manacurrent`, `experience`, `unusedExperience`, `fightingTalents`, `bodyTalents`, `societyTalents`, `natureTalents`, `knowledgeTalents`, `craftTalents`, `publicEntry`) VALUES
(0, 0, '', '', '', '', '', 18, 80, 180, '', '', '', '', '', '', '', '', '', '', '', '', 10, 10, 10, 10, 10, 10, 10, 10, 20, 20, 0, 0, 500, 500, '', '', '', '', '', '', 'true');

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `name`) VALUES
(0, 'None');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `groupname` text NOT NULL,
  `account` text NOT NULL,
  `mainPicture` varchar(255) NOT NULL,
  `secondaryPicture` varchar(255) NOT NULL,
  `tertiaryPicture` varchar(255) NOT NULL,
  `publicEntry` varchar(10) NOT NULL,
  `members` text,
  `onlyAdminMode` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `groupname`, `account`, `mainPicture`, `secondaryPicture`, `tertiaryPicture`, `publicEntry`, `members`, `onlyAdminMode`) VALUES
(0, '', '', '', '', '', 'true', '', 'true');

-- --------------------------------------------------------

--
-- Table structure for table `races`
--

CREATE TABLE `races` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `races`
--

INSERT INTO `races` (`id`, `name`) VALUES
(0, 'None');

-- --------------------------------------------------------

--
-- Table structure for table `securitytokens`
--

CREATE TABLE `securitytokens` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) NOT NULL,
  `identifier` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `securitytoken` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `securitytokens`
--


-- --------------------------------------------------------

--
-- Table structure for table `sex`
--

CREATE TABLE `sex` (
  `ID` int(11) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sex`
--

INSERT INTO `sex` (`ID`, `name`) VALUES
(1, 'male'),
(2, 'female'),
(3, 'other');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--


--
-- Indexes for dumped tables
--

--
-- Indexes for table `characters`
--
ALTER TABLE `characters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `securitytokens`
--
ALTER TABLE `securitytokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sex`
--
ALTER TABLE `sex`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `characters`
--
ALTER TABLE `characters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `securitytokens`
--
ALTER TABLE `securitytokens`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
