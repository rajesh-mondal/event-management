-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 01, 2025 at 03:23 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `event_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendees`
--

CREATE TABLE `attendees` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `registration_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `attendees`
--

INSERT INTO `attendees` (`id`, `event_id`, `user_id`, `registration_date`) VALUES
(1, 1, 1, '2025-01-27 16:01:49'),
(2, 2, 1, '2025-01-27 18:01:45'),
(7, 9, 1, '2025-01-27 18:49:05'),
(8, 1, 5, '2025-01-29 18:10:42'),
(9, 10, 1, '2025-01-31 09:48:08'),
(10, 14, 1, '2025-01-31 09:48:14'),
(11, 16, 1, '2025-01-31 09:48:19'),
(12, 11, 1, '2025-01-31 09:56:57'),
(13, 13, 1, '2025-01-31 20:49:20'),
(14, 17, 1, '2025-02-01 12:30:50');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `event_date` date NOT NULL,
  `event_time` time NOT NULL,
  `location` varchar(255) NOT NULL,
  `max_capacity` int(11) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `name`, `description`, `event_date`, `event_time`, `location`, `max_capacity`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Get Set Rock', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&amp;amp;amp;#039;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum.', '2025-02-09', '18:00:00', 'Mirpur', 60, 1, '2025-01-26 16:10:20', '2025-02-01 07:20:59'),
(2, 'Dhyan | Shohojiya Live Concert', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorem numquam quisquam vel laboriosam..', '2025-02-06', '18:35:00', 'Dhaka University Area', 70, 6, '2025-01-26 16:49:28', '2025-02-01 12:31:39'),
(9, 'Him Utsob ', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', '2025-02-07', '10:00:00', 'JU Area', 60, 1, '2025-01-27 18:05:12', '2025-02-01 12:33:11'),
(10, 'National Film Conference 2025', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorem numquam quisquam vel laboriosam tempora ratione earum rem exercitationem aut maiores!', '2025-02-26', '00:00:00', 'Dhaka University Area', 120, 1, '2025-01-28 17:37:10', '2025-01-28 17:37:10'),
(11, '8th National Adventure Festival ', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorem numquam quisquam vel laboriosam tempora ratione earum rem exercitationem aut maiores!', '2025-02-18', '22:00:00', 'Motijheel', 65, 1, '2025-01-28 17:44:57', '2025-02-01 12:32:52'),
(12, ' Yahama One True Sound', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorem numquam quisquam vel laboriosam tempora ratione earum rem exercitationem aut maiores!', '2025-02-18', '17:00:00', 'Tejgaon', 200, 1, '2025-01-28 17:47:26', '2025-02-01 12:32:05'),
(13, 'Rickshaw Artistry: A World Heritage', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorem numquam quisquam vel laboriosam tempora ratione earum rem exercitationem aut maiores!', '2025-02-12', '15:00:00', 'Dhanmondi', 50, 1, '2025-01-28 18:00:34', '2025-01-29 16:47:13'),
(14, 'Aubak Jolpan (Puppet Show) ', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorem numquam quisquam vel laboriosam tempora ratione earum rem exercitationem aut maiores!', '2025-02-18', '17:00:00', 'Dhanmondi', 120, 1, '2025-01-28 18:01:49', '2025-02-01 12:32:39'),
(15, 'Winter Food Festival 2025', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', '2025-02-19', '15:00:00', 'Agargaon', 100, 1, '2025-01-29 09:50:50', '2025-02-01 12:32:21'),
(16, 'Orcasta Events presents #Fusion', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', '2025-02-18', '17:30:00', 'Tejgaon', 75, 1, '2025-01-29 15:00:35', '2025-01-29 15:00:35'),
(17, '2nd MMDS National Debate Festival', 'You will witness the gathering of all the brilliant minds with great logics. The theme for our event is &quot;Child. Wake Up, Child, Release the light&quot;', '2025-02-11', '09:00:00', 'Rampura', 100, 1, '2025-01-29 15:21:03', '2025-01-29 18:14:37');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@gmail.com', '$2y$10$lmtTra2IHKdpgk6FVfn9V.iUEz.p9THJck9.OZdLMEn1sNlAR6psW', 'admin', '2025-01-25 19:42:25', '2025-01-27 14:13:14'),
(5, 'Demo User', 'demo@gmail.com', '$2y$10$n.ZgfabOWE9kAac54IxVouA6JzM0yFiQ0vqJnm/1x3rR35eAKisfy', 'user', '2025-01-26 14:54:17', '2025-01-26 14:54:17'),
(6, 'Demo 2', 'demo2@gmail.com', '$2y$10$LbRkOe9z7mlQ5yLh9fV7Ye6nE0VQLA9CGjJ0Lv7dS6fVtKmFSI35y', 'user', '2025-01-26 14:55:35', '2025-01-26 14:55:35'),
(8, 'Demo 3', 'demo3@gmail.com', '$2y$10$m/j7FcLGalcYoBTdGpLQYelegKMKSYBuYf3eow/WcuzkR/47vNx36', 'user', '2025-01-26 15:20:44', '2025-01-26 15:20:44'),
(9, 'Rajesh', 'rajesh@gmail.com', '$2y$10$f2XtoVySt.2pTUkrRu9ok..h/B3VD5W9EM.YvLhMgGRCMfUPtu.8e', 'user', '2025-01-31 18:03:00', '2025-01-31 18:03:00'),
(10, 'Demo6', 'demo6@gmail.com', '$2y$10$mKN7EL89o1ppKfF0FTXLKuJN7ASWQ/cudf9eWHs5I/Cy9wm1B90gC', 'user', '2025-01-31 18:51:35', '2025-01-31 18:51:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendees`
--
ALTER TABLE `attendees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `event_id` (`event_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendees`
--
ALTER TABLE `attendees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendees`
--
ALTER TABLE `attendees`
  ADD CONSTRAINT `attendees_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attendees_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
