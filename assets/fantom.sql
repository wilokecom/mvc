-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 14, 2019 at 10:57 AM
-- Server version: 10.3.15-MariaDB
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fantom`
--

-- --------------------------------------------------------

--
-- Table structure for table `postmeta`
--

CREATE TABLE `postmeta` (
  `meta_id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `meta_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `meta_value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `postmeta`
--

INSERT INTO `postmeta` (`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES
(19, 42, 'phone number', '0377082583'),
(20, 43, 'phone number', '0377082583'),
(21, 46, 'phone number', '0377082583'),
(22, 47, 'phone number', '0377082583'),
(23, 48, 'phone number', '0377082583'),
(24, 49, 'phone number', '0377082583'),
(25, 50, 'phone number', '0377082583'),
(26, 51, 'phone number', '0377082583'),
(27, 52, 'phone number', '0377082583'),
(28, 53, 'phone number', '0'),
(29, 54, 'phone number', '0377082583'),
(30, 57, 'phone number', '0377082583'),
(31, 58, 'phone number', '0377082583'),
(32, 59, 'phone number', '0377082583'),
(33, 60, 'phone number', '0377082583'),
(34, 61, 'phone number', '0377082583'),
(35, 62, 'phone number', '0377082583'),
(36, 63, 'phone number', '0377082583'),
(37, 64, 'phone number', '0377082583'),
(38, 65, 'phone number', '0377082583');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `post_author` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `post_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `post_content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `post_title` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `post_status` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'publish',
  `post_mime_type` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `post_type` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'post',
  `guid` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`ID`, `post_author`, `post_date`, `post_content`, `post_title`, `post_status`, `post_mime_type`, `post_type`, `guid`) VALUES
(42, 21, '2019-06-14 05:19:25', 'aaaaaaaaaaa', 'NgÃ y khai trÆ°á»ng ', 'publish', 'image/gif', 'post', ''),
(43, 21, '2019-06-14 07:03:10', 'Äá»— Ngá»c PhÃºc', 'NgÃ y khai trÆ°á»ng ', 'publish', 'image/gif', 'post', ''),
(44, 21, '2019-06-14 07:11:24', 'Äá»— Ngá»c PhÃºc', 'NgÃ y khai trÆ°á»ng ', 'publish', 'image/gif', 'post', ''),
(45, 21, '2019-06-14 07:11:30', 'Äá»— Ngá»c PhÃºc', 'NgÃ y khai trÆ°á»ng ', 'publish', 'image/gif', 'post', ''),
(46, 21, '2019-06-14 07:22:41', 'Äá»— Ngá»c PhÃºc', 'NgÃ y khai trÆ°á»ng ', 'publish', 'image/gif', 'post', ''),
(47, 21, '2019-06-14 07:24:26', 'Äá»— Ngá»c PhÃºc', 'NgÃ y khai trÆ°á»ng ', 'publish', 'image/gif', 'post', ''),
(48, 21, '2019-06-14 07:24:34', 'Äá»— Ngá»c PhÃºc', 'NgÃ y khai trÆ°á»ng ', 'publish', 'image/gif', 'post', ''),
(49, 21, '2019-06-14 07:30:06', 'Äá»— Ngá»c PhÃºc', 'NgÃ y khai trÆ°á»ng ', 'publish', 'image/png', 'post', ''),
(50, 21, '2019-06-14 07:32:42', 'Äá»— Ngá»c PhÃºc', 'NgÃ y khai trÆ°á»ng ', 'none-publish', 'image/png', 'page', ''),
(51, 21, '2019-06-14 07:33:14', 'Äá»— Ngá»c PhÃºc', 'NgÃ y khai trÆ°á»ng ', 'none-publish', 'image/png', 'post', ''),
(52, 21, '2019-06-14 07:33:58', 'PhÃºc', 'NgÃ y khai trÆ°á»ng ', 'publish', 'image/gif', 'post', ''),
(53, 21, '2019-06-14 07:35:35', 'PhÃºc', 'NgÃ y khai trÆ°á»ng ', 'publish', 'image/gif', 'page', ''),
(54, 21, '2019-06-14 07:39:41', 'PhÃºc', 'NgÃ y khai trÆ°á»ng ', 'none-publish', 'image/gif', 'attachment', ''),
(56, 21, '2019-06-14 07:45:15', 'Hà Nội', 'Hà Nội', 'publish', '', 'post', ''),
(57, 21, '2019-06-14 07:48:04', 'NgÃ y khai trÆ°á»ng ', 'NgÃ y khai trÆ°á»ng ', 'none-publish', 'image/gif', 'page', ''),
(58, 21, '2019-06-14 07:49:19', 'NgÃ y khai trÆ°á»ng ', 'NgÃ y khai trÆ°á»ng ', 'none-publish', 'image/gif', 'post', ''),
(59, 21, '2019-06-14 07:52:31', 'NgÃ y khai trÆ°á»ng ', 'NgÃ y khai trÆ°á»ng ', 'none-publish', 'image/gif', 'page', ''),
(60, 20, '2019-06-14 08:22:03', 'NgÃ y khai trÆ°á»ng ', 'NgÃ y khai trÆ°á»ng ', 'publish', 'image/png', 'page', ''),
(61, 20, '2019-06-14 08:26:49', 'NgÃ y khai trÆ°á»ng', 'NgÃ y khai trÆ°á»ng', 'publish', 'image/png', 'post', ''),
(62, 20, '2019-06-14 08:29:39', 'NgÃ y khai trÆ°á»ng', 'NgÃ y khai trÆ°á»ng', 'publish', 'image/png', 'post', ''),
(63, 20, '2019-06-14 08:32:17', 'NgÃ y khai trÆ°á»ng', 'NgÃ y khai trÆ°á»ng', 'publish', 'image/png', 'post', ''),
(64, 20, '2019-06-14 08:49:16', 'NgÃ y khai trÆ°á»ng', 'NgÃ y khai trÆ°á»ng', 'publish', 'image/gif', 'post', ''),
(65, 20, '2019-06-14 08:49:36', 'NgÃ y khai trÆ°á»ng', 'hÃ  ná»™i', 'publish', 'image/gif', 'post', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `username`, `password`, `email`) VALUES
(20, 'phuc', '74b87337454200d4d33f80c4663dc5e5', 'phucngocdo@gmail.com'),
(21, 'phucaa', '74b87337454200d4d33f80c4663dc5e5', 'chienthan75@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `postmeta`
--
ALTER TABLE `postmeta`
  ADD PRIMARY KEY (`meta_id`),
  ADD KEY `meta_key` (`meta_key`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `post_date` (`post_date`),
  ADD KEY `post_status` (`post_status`),
  ADD KEY `post_type` (`post_type`),
  ADD KEY `ID` (`ID`),
  ADD KEY `post_author` (`post_author`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `postmeta`
--
ALTER TABLE `postmeta`
  MODIFY `meta_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `postmeta`
--
ALTER TABLE `postmeta`
  ADD CONSTRAINT `postmeta_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`ID`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`post_author`) REFERENCES `users` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
