-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 27, 2025 at 08:54 AM
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
(24, 'Cephalometric_Tracing_Cheat_Sheet.pdf', '123', 'angas', '2025-07-31 23:37:32', 23),
(25, 'SIA2-Import_Export.pdf', 'admin', 'ok bro', '2025-08-30 02:43:47', 17),
(26, 'Cephalometric_Tracing_Cheat_Sheet.pdf', 'admin', 'ok broo', '2025-08-30 02:45:50', 24),
(27, 'Cephalometric_Tracing_Cheat_Sheet.pdf', 'admin', 'ok boy', '2025-08-30 02:46:56', NULL),
(28, 'Cephalometric_Tracing_Cheat_Sheet.pdf', 'admin', 'hi brother whats up', '2025-08-30 02:47:18', 27),
(29, 'Cephalometric_Tracing_Cheat_Sheet.pdf', 'contri', 'hi guts', '2025-08-30 02:58:04', 28),
(30, 'Cephalometric_Tracing_Cheat_Sheet.pdf', 'admin', 'hi', '2025-09-05 03:11:55', 24),
(31, 'Front page.pdf', '123', 'ahaha', '2025-09-05 04:15:24', 12),
(32, 'Dentistru.pdf', '123', '13213', '2025-09-05 04:15:44', 20),
(33, 'Final Project - Documentation.pdf', 'admin', 'awww', '2025-09-05 04:31:05', NULL),
(34, 'Final Project - Documentation.pdf', 'admin', 'aray mooo', '2025-09-05 05:40:48', 33),
(35, 'Cephalometric_Tracing_Cheat_Sheet.pdf', 'admin', 'nice one', '2025-09-05 05:41:08', 29),
(36, 'Front page.pdf', 'contri', 'u guys good', '2025-09-05 05:43:07', 31),
(37, 'Front page.pdf', 'contri', 'nice try brother', '2025-09-05 05:43:20', 6),
(38, 'Front page.pdf', '123', 'yup', '2025-09-06 00:22:46', 36),
(39, 'Cephalometric_Tracing_Cheat_Sheet.pdf', '123', 'henlo', '2025-09-06 00:23:05', 30),
(40, 'Front page.pdf', 'admin', '@123 nc', '2025-09-08 22:53:23', 1),
(41, 'Front page.pdf', 'admin', 'sda', '2025-09-08 23:03:43', NULL),
(42, 'Front page.pdf', 'admin', '@admin  ok', '2025-09-08 23:03:51', 41),
(43, 'Front page.pdf', 'admin', '@123 ok', '2025-09-08 23:07:56', 1),
(44, 'Front page.pdf', 'admin', 'nicee', '2025-09-08 23:29:56', NULL),
(45, 'Front page.pdf', '123', '@admin yowww', '2025-09-08 23:30:40', 44),
(46, 'Front page.pdf', 'admin', 'nice', '2025-09-08 23:33:43', 1),
(47, 'Front page.pdf', 'admin', 'casd', '2025-09-08 23:40:33', NULL),
(48, 'Front page.pdf', 'admin', 'yup', '2025-09-08 23:47:10', NULL),
(49, 'Front page.pdf', 'admin', 'da', '2025-09-08 23:50:02', NULL),
(50, 'Front page.pdf', 'admin', '@admin 22', '2025-09-08 23:50:33', 48),
(51, 'Front page.pdf', 'admin', '@admin ad', '2025-09-08 23:52:33', 48),
(52, 'Front page.pdf', 'admin', '@123 asd', '2025-09-08 23:52:48', 14),
(53, 'Front page.pdf', 'admin', '@admin 12313', '2025-09-08 23:52:58', 48),
(54, 'Front page.pdf', 'admin', 'asssa', '2025-09-08 23:54:32', NULL),
(55, 'SIA2-Import_Export.pdf', 'admin', 'asdasd', '2025-09-08 23:56:03', NULL),
(56, 'SIA2-Import_Export.pdf', '123', 'asd', '2025-09-08 23:59:17', NULL),
(57, 'Front page.pdf', '123', 'asdasd', '2025-09-09 00:25:40', NULL),
(58, 'Front page.pdf', '123', '2323', '2025-09-09 00:25:48', NULL),
(59, 'Front page.pdf', '123', 'asda', '2025-09-09 00:27:05', NULL),
(60, 'Front page.pdf', '123', '@123 032', '2025-09-09 00:28:00', 59),
(61, 'Front page.pdf', '123', '123', '2025-09-09 00:35:17', NULL),
(62, 'Nagares-Pinugu Capstone 1 (2).pdf', '123', '3453', '2025-09-09 00:36:33', NULL),
(63, 'Nagares-Pinugu Capstone 1 (2).pdf', '123', '3453asd', '2025-09-09 00:41:43', NULL),
(64, 'Dentistru.pdf', 'admin', 'agay', '2025-09-09 15:13:53', NULL),
(65, 'try', 'admin', 'test from console', '2025-09-09 15:15:58', NULL),
(66, 'Front page.pdf', '123', 'asd', '2025-09-09 16:02:17', NULL),
(67, 'Capstone-Project-Guide-with-Variable.pdf', 'admin', 'nice', '2025-09-09 21:48:55', NULL),
(68, 'Capstone-Project-Guide-with-Variable.pdf', '123', 'okay', '2025-09-09 21:49:12', 67),
(69, 'Capstone-Project-Guide-with-Variable.pdf', '123', '@admin heyyy', '2025-09-09 21:49:45', 67),
(70, 'Capstone-Project-Guide-with-Variable.pdf', '123', 'adasd', '2025-09-09 22:02:44', NULL),
(71, 'Capstone-Project-Guide-with-Variable.pdf', 'admin', '@123 31', '2025-09-09 22:02:56', 70),
(72, 'try', 'admin', 'test from console', '2025-09-09 22:40:08', NULL),
(73, 'Capstone-Project-Guide-with-Variable.pdf', 'admin', '@123 how are youuu', '2025-09-09 22:58:47', 70),
(74, 'Capstone-Project-Guide-with-Variable.pdf', '123', 'yow', '2025-09-09 23:00:24', NULL),
(75, 'Capstone-Project-Guide-with-Variable.pdf', '123', '@admin wassup', '2025-09-09 23:00:34', 67),
(76, 'Capstone-Project-Guide-with-Variable.pdf', 'admin', 'asdasd', '2025-09-17 22:30:49', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_key` varchar(255) NOT NULL,
  `type` enum('system','comment') NOT NULL DEFAULT 'system',
  `ref_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `status` enum('sent','revoked') NOT NULL DEFAULT 'sent',
  `revoke_reason` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `read_at` datetime DEFAULT NULL,
  `revoked_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_key`, `type`, `ref_id`, `title`, `body`, `status`, `revoke_reason`, `created_at`, `read_at`, `revoked_at`) VALUES
(1, 'admin', 'system', NULL, 'Your PDF upload was approved', 'File: Nagares-Pinugu Capstone 1 (2).pdf\nCapstone: asd', 'sent', NULL, '2025-09-02 01:29:55', '2025-09-03 23:58:39', NULL),
(2, 'contri', 'system', NULL, 'Your PDF upload was approved', 'File: Adviser-Consultation-Form.pdf\nCapstone: brooo', 'sent', NULL, '2025-09-02 02:35:38', '2025-09-03 23:58:32', NULL),
(3, 'contri', 'system', NULL, 'Your PDF upload was approved', 'File: Final Project - Documentation.pdf\nCapstone: dasd', 'sent', NULL, '2025-09-02 02:37:15', '2025-09-03 23:58:31', NULL),
(4, 'admin', 'system', NULL, 'Your PDF upload was rejected', 'File: Capstone-Project-Guide-with-Variable.pdf\nCapstone: test rejection\nReason: awit', 'sent', NULL, '2025-09-02 03:41:42', '2025-09-03 23:58:39', NULL),
(5, 'admin', 'system', NULL, 'Your PDF upload was rejected', 'File: Front page.pdf\nCapstone: pendi denied\nReason: try again', 'sent', NULL, '2025-09-02 17:06:48', '2025-09-03 23:58:38', NULL),
(6, '123', 'system', NULL, 'Your PDF upload was approved', 'File: Front page.pdf\nCapstone: try', 'sent', NULL, '2025-09-02 17:11:58', '2025-09-03 03:11:59', NULL),
(8, '123', 'system', NULL, 'Your PDF upload was rejected', 'File: John Harly A. Pinugu.pdf\nCapstone: ano\nReason: bakit', 'sent', NULL, '2025-09-02 20:12:49', '2025-09-03 03:11:58', NULL),
(9, '123', 'comment', 30, 'New reply to your comment', 'admin replied on file: Cephalometric_Tracing_Cheat_Sheet.pdf', 'sent', NULL, '2025-09-05 03:11:55', '2025-09-08 23:30:31', NULL),
(10, 'admin', 'comment', 32, 'New reply to your comment', '123 replied on file: Dentistru.pdf', 'sent', NULL, '2025-09-05 04:15:44', '2025-09-08 23:16:21', NULL),
(11, 'contri', 'comment', 35, 'New reply to your comment', 'admin replied on file: Cephalometric_Tracing_Cheat_Sheet.pdf', 'sent', NULL, '2025-09-05 05:41:08', '2025-09-09 14:33:30', NULL),
(12, '123', 'comment', 36, 'New reply to your comment', 'contri replied on file: Front page.pdf', 'sent', NULL, '2025-09-05 05:43:07', '2025-09-08 23:30:24', NULL),
(13, '123', 'comment', 37, 'New reply to your comment', 'contri replied on file: Front page.pdf', 'sent', NULL, '2025-09-05 05:43:20', '2025-09-08 23:30:19', NULL),
(14, 'contri', 'comment', 38, 'New reply to your comment', '123 replied on file: Front page.pdf', 'sent', NULL, '2025-09-06 00:22:46', '2025-09-09 14:28:00', NULL),
(15, 'admin', 'comment', 39, 'New reply to your comment', '123 replied on file: Cephalometric_Tracing_Cheat_Sheet.pdf', 'sent', NULL, '2025-09-06 00:23:05', '2025-09-08 23:16:14', NULL),
(16, '123', 'comment', 40, 'New reply to your comment', 'admin replied on file: Front page.pdf', 'sent', NULL, '2025-09-08 22:53:23', '2025-09-08 23:30:15', NULL),
(17, '123', 'comment', 43, 'New reply to your comment', 'admin replied on file: Front page.pdf', 'sent', NULL, '2025-09-08 23:07:56', '2025-09-08 23:30:11', NULL),
(18, 'admin', 'comment', 45, 'New reply to your comment', '123 replied on file: Front page.pdf', 'sent', NULL, '2025-09-08 23:30:40', '2025-09-08 23:30:53', NULL),
(19, '123', 'comment', 46, 'New reply to your comment', 'admin replied on file: Front page.pdf', 'sent', NULL, '2025-09-08 23:33:43', '2025-09-09 15:18:42', NULL),
(20, '123', 'comment', 52, 'New reply to your comment', 'admin replied on file: Front page.pdf', 'sent', NULL, '2025-09-08 23:52:48', '2025-09-08 23:58:51', NULL),
(21, 'admin', 'system', NULL, 'Your PDF upload was approved', 'File: Capstone-Project-Guide-with-Variable.pdf\nCapstone: oo nalang', 'sent', NULL, '2025-09-09 20:50:04', NULL, NULL),
(22, '123', 'comment', 73, 'New reply to your comment', 'admin replied on file: Capstone-Project-Guide-with-Variable.pdf', 'sent', NULL, '2025-09-09 22:58:47', '2025-09-09 22:58:57', NULL),
(23, 'admin', 'comment', 75, 'New reply to your comment', '123 replied on file: Capstone-Project-Guide-with-Variable.pdf', 'sent', NULL, '2025-09-09 23:00:34', '2025-09-09 23:00:44', NULL),
(24, 'admin', 'system', NULL, 'Your PDF upload was approved', 'File: Adviser-Consultation-Form.pdf\nCapstone: ulol', 'sent', NULL, '2025-10-19 11:58:33', '2025-10-19 11:58:44', NULL);

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
  `approved` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=pending,1=approved,2=rejected',
  `rejection_reason` varchar(255) DEFAULT NULL,
  `reviewed_at` datetime DEFAULT NULL,
  `reviewed_by` int(11) DEFAULT NULL,
  `year_published` varchar(10) DEFAULT NULL,
  `authors` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `uploaded_files`
--

INSERT INTO `uploaded_files` (`id`, `filename`, `url`, `uploaded_at`, `uploaded_by`, `capstone_title`, `date_uploaded`, `approved`, `rejection_reason`, `reviewed_at`, `reviewed_by`, `year_published`, `authors`) VALUES
(1, 'Activity System Integration and Architecture 2  (1).pdf', 'https://firebasestorage.googleapis.com/v0/b/ctraker-7f380.firebasestorage.app/o/pdfs%2FActivity%20System%20Integration%20and%20Architecture%202%20%20(1).pdf?alt=media&token=20654db1-51a5-441e-b1b1-522ed694cc4a', '2025-06-29 12:44:44', NULL, NULL, '2025-07-08 23:36:53', 1, NULL, NULL, NULL, NULL, NULL),
(2, 'SIA2-Import_Export.pdf', 'https://firebasestorage.googleapis.com/v0/b/ctraker-7f380.firebasestorage.app/o/pdfs%2FSIA2-Import_Export.pdf?alt=media&token=daa15e55-471e-4dbf-b81c-48657916265f', '2025-06-30 14:48:31', '123', NULL, '2025-07-08 23:36:53', 1, NULL, NULL, NULL, NULL, NULL),
(3, 'Final Project - Documentation.pdf', 'https://firebasestorage.googleapis.com/v0/b/ctraker-7f380.firebasestorage.app/o/pdfs%2FFinal%20Project%20-%20Documentation.pdf?alt=media&token=9d122857-8bfe-42dd-b8e3-590923e19fc1', '2025-07-08 15:06:40', '123', '123123', '2025-07-08 23:36:53', 1, NULL, NULL, NULL, NULL, NULL),
(4, 'Front page.pdf', 'https://firebasestorage.googleapis.com/v0/b/ctraker-7f380.firebasestorage.app/o/pdfs%2FFront%20page.pdf?alt=media&token=ac37693e-dfb2-4432-ad57-4788644b864f', '2025-07-08 15:39:59', '123', '123', '2025-07-08 23:39:59', 1, NULL, NULL, NULL, NULL, NULL),
(5, 'Dentistru.pdf', 'https://firebasestorage.googleapis.com/v0/b/ctraker-7f380.firebasestorage.app/o/pdfs%2FDentistru.pdf?alt=media&token=74908eaa-192d-4b91-a45d-19fa5afec36a', '2025-07-23 09:21:22', 'admin', '213213', '2025-07-23 17:21:22', 1, NULL, NULL, NULL, NULL, NULL),
(8, 'Cephalometric_Tracing_Cheat_Sheet.pdf', 'https://firebasestorage.googleapis.com/v0/b/ctraker-7f380.firebasestorage.app/o/pdfs%2FCephalometric_Tracing_Cheat_Sheet.pdf?alt=media&token=6140027b-a4bb-445b-8cb0-af1949199dd9', '2025-07-31 15:36:43', '123', 'wala lang', '2025-07-31 23:36:43', 1, NULL, NULL, NULL, NULL, NULL),
(9, 'PINUGU, JOHN HARLY A. PICSPro Membership Certificate.pdf', 'https://firebasestorage.googleapis.com/v0/b/ctraker-7f380.firebasestorage.app/o/pdfs%2FPINUGU%2C%20JOHN%20HARLY%20A.%20PICSPro%20Membership%20Certificate.pdf?alt=media&token=2dd8016f-1fa6-420f-af74-3910679b3c55', '2025-08-30 14:26:07', 'contri', 'seaman', '2025-08-30 22:26:07', 1, NULL, NULL, NULL, NULL, NULL),
(10, 'Nagares-Pinugu Capstone 1 (2).pdf', 'https://firebasestorage.googleapis.com/v0/b/ctraker-7f380.firebasestorage.app/o/pdfs%2FNagares-Pinugu%20Capstone%201%20(2).pdf?alt=media&token=e1875262-5981-49e7-8131-2f691668049e', '2025-09-01 13:31:36', 'admin', 'asd', '2025-09-01 21:31:36', 1, NULL, NULL, NULL, NULL, NULL),
(11, 'Capstone-Project-Guide-with-Variable.pdf', 'https://firebasestorage.googleapis.com/v0/b/ctraker-7f380.firebasestorage.app/o/pdfs%2FCapstone-Project-Guide-with-Variable.pdf?alt=media&token=26385c02-6d26-49e0-958f-21a8dfec9d6d', '2025-09-01 17:30:56', 'admin', 'test rejection', '2025-09-02 01:30:56', 2, 'awit', '2025-09-02 03:41:42', 10, NULL, NULL),
(12, 'Adviser-Consultation-Form.pdf', 'https://firebasestorage.googleapis.com/v0/b/ctraker-7f380.firebasestorage.app/o/pdfs%2FAdviser-Consultation-Form.pdf?alt=media&token=b26242b4-4744-425b-a5dc-7194636a1332', '2025-09-01 18:35:03', 'contri', 'brooo', '2025-09-02 02:35:03', 1, NULL, NULL, NULL, NULL, NULL),
(13, 'Final Project - Documentation.pdf', 'https://firebasestorage.googleapis.com/v0/b/ctraker-7f380.firebasestorage.app/o/pdfs%2FFinal%20Project%20-%20Documentation.pdf?alt=media&token=7a0b3c02-a8b9-45be-8bd1-7986a85e0d8b', '2025-09-01 18:37:09', 'contri', 'dasd', '2025-09-02 02:37:09', 1, NULL, NULL, NULL, NULL, NULL),
(14, 'Numerology_Profile_May_4_2004.pdf', 'https://firebasestorage.googleapis.com/v0/b/ctraker-7f380.firebasestorage.app/o/pdfs%2FNumerology_Profile_May_4_2004.pdf?alt=media&token=287007f6-1c6a-4f29-ab73-25e19d8882a1', '2025-09-01 20:18:00', 'admin', 'saed1', '2025-09-02 04:18:00', 2, 'huh', '2025-09-02 04:18:18', 10, NULL, NULL),
(15, 'Front page.pdf', 'https://firebasestorage.googleapis.com/v0/b/ctraker-7f380.firebasestorage.app/o/pdfs%2FFront%20page.pdf?alt=media&token=a7f1eba3-f775-4ddd-930d-f0d1e5ab7639', '2025-09-02 09:06:37', 'admin', 'pendi denied', '2025-09-02 17:06:37', 2, 'try again', '2025-09-02 17:06:48', 10, NULL, NULL),
(16, 'Front page.pdf', 'https://firebasestorage.googleapis.com/v0/b/ctraker-7f380.firebasestorage.app/o/pdfs%2FFront%20page.pdf?alt=media&token=08601406-4ca0-46ac-8843-bcc2184e077a', '2025-09-02 09:11:30', '123', 'try', '2025-09-02 17:11:30', 1, NULL, NULL, NULL, NULL, NULL),
(17, 'Cephalometric_Tracing_Cheat_Sheet.pdf', 'https://firebasestorage.googleapis.com/v0/b/ctraker-7f380.firebasestorage.app/o/pdfs%2FCephalometric_Tracing_Cheat_Sheet.pdf?alt=media&token=20b169fc-1270-4093-8942-cfb077015150', '2025-09-02 09:11:46', '123', 'reject', '2025-09-02 17:11:46', 2, 'sad', '2025-09-02 17:41:14', 10, NULL, NULL),
(18, 'Front page.pdf', 'https://firebasestorage.googleapis.com/v0/b/ctraker-7f380.firebasestorage.app/o/pdfs%2FFront%20page.pdf?alt=media&token=0ca0b479-2e43-4c0d-828d-e51120e84e21', '2025-09-02 10:04:52', '123', 'as', '2025-09-02 18:04:52', 2, 'nothing', '2025-09-02 18:05:07', 10, NULL, NULL),
(19, 'John Harly A. Pinugu.pdf', 'https://firebasestorage.googleapis.com/v0/b/ctraker-7f380.firebasestorage.app/o/pdfs%2FJohn%20Harly%20A.%20Pinugu.pdf?alt=media&token=fbf90856-04e1-4fa1-b90f-75a89352f282', '2025-09-02 12:12:34', '123', 'ano', '2025-09-02 20:12:34', 2, 'bakit', '2025-09-02 20:12:49', 12, NULL, NULL),
(20, 'Adviser-Consultation-Form.pdf', 'https://firebasestorage.googleapis.com/v0/b/ctraker-7f380.firebasestorage.app/o/pdfs%2FAdviser-Consultation-Form.pdf?alt=media&token=dd9e91b8-1e74-4b6e-b009-b465624ccb9a', '2025-09-07 14:07:48', 'admin', 'ulol', '2025-09-07 22:07:48', 1, NULL, NULL, NULL, NULL, NULL),
(21, 'Capstone-Project-Guide-with-Variable.pdf', 'https://firebasestorage.googleapis.com/v0/b/ctraker-7f380.firebasestorage.app/o/pdfs%2FCapstone-Project-Guide-with-Variable.pdf?alt=media&token=5d295013-5bef-42d8-9b04-3871564fccf6', '2025-09-09 12:49:35', 'admin', 'oo nalang', '2025-09-09 20:49:35', 1, NULL, NULL, NULL, '2089', 'john harly pinugu & kyle austine nagares'),
(22, 'Final Project - Documentation.pdf', 'https://firebasestorage.googleapis.com/v0/b/ctraker-7f380.firebasestorage.app/o/pdfs%2FFinal%20Project%20-%20Documentation.pdf?alt=media&token=3c4af93d-6d32-4283-9e00-56ae9c6cfd2a', '2025-10-24 09:09:24', 'admin', 'dasd', '2025-10-24 17:09:24', 0, NULL, NULL, NULL, '20123', '12312');

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
(10, 'vince', 'pinugu', 'admin', '$2y$10$d1JR1wgMk4Az/lxxl5YcEOq6sIUs6vv/di3uWh2HpvhOhN9HqNU0K', 'admin', '2025-07-22 07:22:10'),
(11, 'ermina', 'delacruz', 'mina', '$2y$10$SoYzksDVNUQTsKRKCqJBeeiqfTXzo/ghjenBQIE0MbNj.O2Z/w5ke', 'user', '2025-08-26 15:17:13'),
(12, 'rick', 'davao', 'contri', '$2y$10$KlA1LeVCcMMI4ApWUqoxPusifOnx4Z0JqDskEzpDk5dDmlzXldRDi', 'contributor', '2025-08-29 18:56:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `file_comments`
--
ALTER TABLE `file_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_key` (`user_key`,`status`,`created_at`),
  ADD KEY `idx_notifs_user_read` (`user_key`,`read_at`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `uploaded_files`
--
ALTER TABLE `uploaded_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
