-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 21, 2021 at 12:01 PM
-- Server version: 10.4.16-MariaDB
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quiz`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id` int(11) NOT NULL,
  `answer` set('0','1') NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  `attempt` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `folk`
--

CREATE TABLE `folk` (
  `id` int(11) NOT NULL,
  `fullName` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `attempts` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `id` int(11) NOT NULL,
  `optionName` varchar(150) NOT NULL,
  `optionValue` varchar(10) NOT NULL,
  `optionStatus` set('0','1') NOT NULL DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `step_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

CREATE TABLE `quiz` (
  `id` int(11) NOT NULL,
  `quizName` varchar(150) NOT NULL,
  `afterText` text NOT NULL,
  `quizHeading` varchar(150) NOT NULL,
  `quizText` text NOT NULL,
  `quizButton` varchar(50) NOT NULL,
  `quizSubmit` varchar(50) NOT NULL,
  `quizNotice` varchar(255) NOT NULL,
  `backgroundColor` varchar(50) NOT NULL,
  `color` varchar(50) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `optionStatus` set('0','1') NOT NULL DEFAULT '0',
  `archived` set('0','1') NOT NULL DEFAULT '0',
  `defaultQuiz` set('0','1') NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `step`
--

CREATE TABLE `step` (
  `id` int(11) NOT NULL,
  `stepName` varchar(150) NOT NULL,
  `stepDescription` varchar(255) NOT NULL DEFAULT '''Korisnik nije dao objašnjenje''',
  `stepStatus` set('0','1') NOT NULL DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `quiz_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullName` varchar(150) NOT NULL DEFAULT '0',
  `userEmail` varchar(150) NOT NULL DEFAULT '0',
  `userPassword` varchar(150) NOT NULL DEFAULT '0',
  `userStatus` set('0','1') NOT NULL DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `folk`
--
ALTER TABLE `folk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `step`
--
ALTER TABLE `step`
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
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `folk`
--
ALTER TABLE `folk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quiz`
--
ALTER TABLE `quiz`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `step`
--
ALTER TABLE `step`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
