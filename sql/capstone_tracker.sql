-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 11, 2025 at 07:02 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `capstone_tracker`
--

-- --------------------------------------------------------

--
-- Table structure for table `file_comments`
--

CREATE TABLE `file_comments` (
  `id` int(11) NOT NULL,
  `file` varchar(255) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `parent_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `file_comments`
--

INSERT INTO `file_comments` (`id`, `file`, `username`, `comment`, `created_at`, `parent_id`) VALUES
(1, 'Front page.pdf', '123', '123', '2025-07-14 21:06:15', NULL),
(2, 'Front page.pdf', '123', 'hi guys', '2025-07-14 21:06:22', NULL),
(3, 'Front page.pdf', '123', '123', '2025-07-17 20:26:12', 1),
(4, 'Front page.pdf', '123', '123', '2025-07-17 20:46:53', 2),
(5, 'Front page.pdf', '123', 'hala', '2025-07-17 20:47:00', 2),
(6, 'Front page.pdf', '123', 'ahah', '2025-07-17 20:55:07', 2),
(7, 'Front page.pdf', '123', 'ajhahah', '2025-07-17 21:00:56', NULL),
(8, 'Front page.pdf', '123', 'bakit kaya', '2025-07-17 21:01:05', NULL),
(9, 'Front page.pdf', '123', '123', '2025-07-17 21:01:55', 1),
(10, 'Front page.pdf', '123', 'aahahha', '2025-07-17 21:02:03', NULL),
(11, 'Front page.pdf', '123', 'nice one', '2025-07-17 21:03:49', 8),
(12, 'Front page.pdf', '123', '13123123', '2025-07-17 21:14:09', 1),
(13, 'Front page.pdf', '123', 'hi', '2025-07-17 21:57:37', NULL),
(14, 'Front page.pdf', '123', '123213', '2025-07-17 22:10:53', NULL),
(15, 'Front page.pdf', '123', 'halaka bata ka', '2025-07-17 22:11:14', NULL),
(16, 'Front page.pdf', 'harly1', 'wow okay', '2025-07-20 15:26:12', 15),
(17, 'SIA2-Import_Export.pdf', 'harly1', 'hi', '2025-07-22 21:50:41', NULL),
(18, 'Front page.pdf', 'admin', '123213', '2025-07-23 16:39:42', NULL),
(19, 'Dentistru.pdf', 'admin', '13123', '2025-07-23 17:35:31', NULL),
(20, 'Dentistru.pdf', 'admin', '213213', '2025-07-23 17:35:34', 19),
(21, 'Front page.pdf', '123', '1231adasd', '2025-07-24 20:27:13', NULL),
(22, 'Front page.pdf', '123', 'hala', '2025-07-24 20:27:20', 21),
(23, 'Cephalometric_Tracing_Cheat_Sheet.pdf', 'admin', 'ayun ohhhh', '2025-07-31 23:37:12', NULL),
(24, 'Cephalometric_Tracing_Cheat_Sheet.pdf', '123', 'angas', '2025-07-31 23:37:32', 23);

-- --------------------------------------------------------

--
-- Table structure for table `uploaded_files`
--

CREATE TABLE `uploaded_files` (
  `id` int(11) NOT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `url` text DEFAULT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `uploaded_by` varchar(255) DEFAULT NULL,
  `capstone_title` varchar(255) DEFAULT NULL,
  `date_uploaded` datetime DEFAULT current_timestamp(),
  `approved` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `uploaded_files`
--

INSERT INTO `uploaded_files` (`id`, `filename`, `url`, `uploaded_at`, `uploaded_by`, `capstone_title`, `date_uploaded`, `approved`) VALUES
(1, 'Activity System Integration and Architecture 2  (1).pdf', 'https://firebasestorage.googleapis.com/v0/b/ctraker-7f380.firebasestorage.app/o/pdfs%2FActivity%20System%20Integration%20and%20Architecture%202%20%20(1).pdf?alt=media&token=20654db1-51a5-441e-b1b1-522ed694cc4a', '2025-06-29 12:44:44', NULL, NULL, '2025-07-08 23:36:53', 1),
(2, 'SIA2-Import_Export.pdf', 'https://firebasestorage.googleapis.com/v0/b/ctraker-7f380.firebasestorage.app/o/pdfs%2FSIA2-Import_Export.pdf?alt=media&token=daa15e55-471e-4dbf-b81c-48657916265f', '2025-06-30 14:48:31', '123', NULL, '2025-07-08 23:36:53', 1),
(3, 'Final Project - Documentation.pdf', 'https://firebasestorage.googleapis.com/v0/b/ctraker-7f380.firebasestorage.app/o/pdfs%2FFinal%20Project%20-%20Documentation.pdf?alt=media&token=9d122857-8bfe-42dd-b8e3-590923e19fc1', '2025-07-08 15:06:40', '123', '123123', '2025-07-08 23:36:53', 1),
(4, 'Front page.pdf', 'https://firebasestorage.googleapis.com/v0/b/ctraker-7f380.firebasestorage.app/o/pdfs%2FFront%20page.pdf?alt=media&token=ac37693e-dfb2-4432-ad57-4788644b864f', '2025-07-08 15:39:59', '123', '123', '2025-07-08 23:39:59', 1),
(5, 'Dentistru.pdf', 'https://firebasestorage.googleapis.com/v0/b/ctraker-7f380.firebasestorage.app/o/pdfs%2FDentistru.pdf?alt=media&token=74908eaa-192d-4b91-a45d-19fa5afec36a', '2025-07-23 09:21:22', 'admin', '213213', '2025-07-23 17:21:22', 1),
(8, 'Cephalometric_Tracing_Cheat_Sheet.pdf', 'https://firebasestorage.googleapis.com/v0/b/ctraker-7f380.firebasestorage.app/o/pdfs%2FCephalometric_Tracing_Cheat_Sheet.pdf?alt=media&token=6140027b-a4bb-445b-8cb0-af1949199dd9', '2025-07-31 15:36:43', '123', 'wala lang', '2025-07-31 23:36:43', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` varchar(50) DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `password_hash`, `role`, `created_at`) VALUES
(3, '1231', '1231', '123', '$2y$10$TAhzarT360MNr227C1p8vu/ew.po0JVLVKWPA8d0/F5dHJEK7yFuS', 'user', '2025-06-11 07:46:29'),
(4, 'harlky', 'pinuhu', 'john@gmail.com', '$2y$10$zZhd6ir39uTi.5fGNMOp..DjpEcg0ioSRMrsRf/I.VHQN6A3zJ7sS', 'user', '2025-06-12 11:28:50'),
(5, 'harly', 'john', 'harly1', '$2y$10$M.nbEXLWjsTFuYj7K6OfAuYE4ZvNK0O5w9nkDu79KQ95fD/Nzt1L6', 'user', '2025-07-20 07:25:55'),
(6, 'harlky', '123', 'john', '$2y$10$CUqt29/uyPK1Ieaoz5WUxO4iq7NxExBf8OrMDj81WtSztHY1.eQiO', 'user', '2025-07-20 11:19:07'),
(7, 'marky', 'cafaf', 'shiki', '$2y$10$aCD0QaVAmKD25GWjtT7lMeJMudfo1rm/A0P7FSmp3hVliKtbHTJwm', 'user', '2025-07-20 11:22:21'),
(10, 'vince', 'pinugu', 'admin', '$2y$10$d1JR1wgMk4Az/lxxl5YcEOq6sIUs6vv/di3uWh2HpvhOhN9HqNU0K', 'admin', '2025-07-22 07:22:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `file_comments`
--
ALTER TABLE `file_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uploaded_files`
--
ALTER TABLE `uploaded_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `file_comments`
--
ALTER TABLE `file_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `uploaded_files`
--
ALTER TABLE `uploaded_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
