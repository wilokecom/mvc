-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th7 22, 2019 lúc 10:48 AM
-- Phiên bản máy phục vụ: 10.3.15-MariaDB
-- Phiên bản PHP: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `fantom`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `postmeta`
--

CREATE TABLE `postmeta` (
  `meta_id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `meta_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `meta_value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `postmeta`
--

INSERT INTO `postmeta` (`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES
(333, 367, 'phone number', '0'),
(334, 368, 'phone number', '0377082583'),
(335, 369, 'phone number', '0'),
(336, 370, 'phone number', '0377082583'),
(337, 371, 'phone number', '0377082583'),
(351, 385, 'phone number', '222'),
(352, 386, 'phone number', 'hjhj'),
(353, 387, 'phone number', '321'),
(354, 388, 'phone number', '222'),
(355, 389, 'phone number', '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `posts`
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
-- Đang đổ dữ liệu cho bảng `posts`
--

INSERT INTO `posts` (`ID`, `post_author`, `post_date`, `post_content`, `post_title`, `post_status`, `post_mime_type`, `post_type`, `guid`) VALUES
(367, 24, '2019-07-16 09:26:05', 'ss', 'Ngày khai trường', 'publish', 'image/png', 'post', 'http://localhost/mvc/post/add/post_id=24'),
(368, 24, '2019-07-16 09:26:19', 'ssss', 'Ngày khai trường', 'publish', 'image/png', 'post', 'http://localhost/mvc/post/add/post_id=24'),
(369, 24, '2019-07-16 09:26:33', 's', 'aaaaaaaaaaaaaaaaaaaaaaaaaa', 'publish', 'image/png', 'page', 'http://localhost/mvc/post/add/page_id=24'),
(370, 24, '2019-07-16 09:26:50', 'fffffff', 'vvvvv', 'publish', 'image/png', 'post', 'http://localhost/mvc/post/add/post_id=24'),
(371, 24, '2019-07-16 09:34:11', 'bbbbbbbbb', 'Ngày khai trường', 'publish', 'image/png', 'post', 'http://localhost/mvc/post/add/post_id=24'),
(385, 23, '2019-07-22 08:44:42', 'fffffffff', 'fgfgfg', 'publish', 'image/png', 'post', 'http://localhost/mvc/post/add/post_id=23'),
(386, 23, '2019-07-22 08:45:07', 'fgfgf', 'hhh', 'publish', 'image/png', 'post', 'http://localhost/mvc/post/add/post_id=23'),
(387, 23, '2019-07-22 08:45:23', 'ssdsd', 'jhjhj', 'publish', 'image/png', 'post', 'http://localhost/mvc/post/add/post_id=23'),
(388, 23, '2019-07-22 08:45:40', 'fg', 'abc', 'publish', 'image/png', 'post', 'http://localhost/mvc/post/add/post_id=23'),
(389, 23, '2019-07-22 08:45:58', 'fffffffffff', 'hà nội', 'publish', 'image/png', 'post', 'http://localhost/mvc/post/add/post_id=23');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `terms`
--

CREATE TABLE `terms` (
  `term_id` bigint(20) UNSIGNED NOT NULL,
  `term_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `slug` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `term_group` bigint(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `terms`
--

INSERT INTO `terms` (`term_id`, `term_name`, `slug`, `term_group`) VALUES
(193, 'abchhfg', 'abchhfg', 0),
(198, 'z123', 'z123', 0),
(199, 'z123', 'z123', 0),
(200, 'z123', 'z123', 0),
(201, 'z123', 'z123', 0),
(202, 'z123', 'z123', 0),
(203, 'z123', 'z123', 0),
(204, 'z123', 'z123', 0),
(205, 'z123', 'z123', 0),
(206, 'z123', 'z123', 0),
(207, 'z123', 'z123', 0),
(208, 'z123', 'z123', 0),
(209, 'z123', 'z123', 0),
(210, 'z123', 'z123', 0),
(211, 'z123', 'z123', 0),
(212, 'z123', 'z123', 0),
(213, 'z123', 'z123', 0),
(214, 'z123', 'z123', 0),
(215, 'z123', 'z123', 0),
(216, 'z123', 'z123', 0),
(217, 'z123', 'z123', 0),
(218, 'z123', 'z123', 0),
(219, 'z123', 'z123', 0),
(220, 'z123', 'z123', 0),
(221, 'z123', 'z123', 0),
(222, 'zzzddadad', 'zzzddadad', 0),
(223, 'zzzddadad', 'zzzddadad', 0),
(224, 'zzzddadad', 'zzzddadad', 0),
(225, 'zzzddadad', 'zzzddadad', 0),
(226, 'zzzddadad', 'zzzddadad', 0),
(227, 'zzzddadad', 'zzzddadad', 0),
(228, 'zzzddadad', 'zzzddadad', 0),
(229, 'zzzddadad', 'zzzddadad', 0),
(230, 'zzzddadad', 'zzzddadad', 0),
(239, 'vbnbvnb', 'zc', 0),
(240, 'cvvvv', 'bb', 0),
(241, 'vvv', 'czz', 0),
(242, 'nmmn,m', 'zxxx', 0),
(243, 'bvnb', 's', 0),
(244, ',gvdff', 'ccv', 0),
(245, 'mm,mn', 'vbmvb', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `term_relationships`
--

CREATE TABLE `term_relationships` (
  `object_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `term_taxonomy_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `term_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `term_relationships`
--

INSERT INTO `term_relationships` (`object_id`, `term_taxonomy_id`, `term_order`) VALUES
(385, 162, 0),
(386, 158, 0),
(386, 159, 0),
(387, 156, 0),
(388, 156, 0),
(388, 157, 0),
(389, 156, 0),
(389, 159, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `term_taxonomy`
--

CREATE TABLE `term_taxonomy` (
  `term_taxonomy_id` bigint(20) UNSIGNED NOT NULL,
  `term_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `taxonomy` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `count_taxonomy` bigint(20) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `term_taxonomy`
--

INSERT INTO `term_taxonomy` (`term_taxonomy_id`, `term_id`, `taxonomy`, `description`, `parent`, `count_taxonomy`) VALUES
(142, 193, '0', '0', 0, 0),
(156, 239, 'tag', 'xcxcx', 0, 3),
(157, 240, 'tag', 'mm,', 0, 1),
(158, 241, 'tag', '', 0, 1),
(159, 242, 'tag', 'dđ', 0, 2),
(160, 243, 'tag', 'bvb', 0, 0),
(161, 244, 'tag', 'ss', 0, 0),
(162, 245, 'tag', 'ddd', 0, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`ID`, `username`, `password`, `email`) VALUES
(23, 'phuc', '74b87337454200d4d33f80c4663dc5e5', 'chienthan75@gmail.com'),
(24, 'aaaa', '74b87337454200d4d33f80c4663dc5e5', 'phucngocdo@gmail.com'),
(25, 'aaaaaaaaaaaaaaaa', '47bce5c74f589f4867dbd57e9ca9f808', 'chienthan75gggggg@gmail.com'),
(26, 'dongocphuc', '74b87337454200d4d33f80c4663dc5e5', 'phuccuong1@gmail.com');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `postmeta`
--
ALTER TABLE `postmeta`
  ADD PRIMARY KEY (`meta_id`),
  ADD KEY `meta_key` (`meta_key`),
  ADD KEY `post_id` (`post_id`);

--
-- Chỉ mục cho bảng `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `post_date` (`post_date`),
  ADD KEY `post_status` (`post_status`),
  ADD KEY `post_type` (`post_type`),
  ADD KEY `ID` (`ID`),
  ADD KEY `post_author` (`post_author`);

--
-- Chỉ mục cho bảng `terms`
--
ALTER TABLE `terms`
  ADD PRIMARY KEY (`term_id`),
  ADD KEY `slug` (`slug`(191)),
  ADD KEY `name` (`term_name`(191));

--
-- Chỉ mục cho bảng `term_relationships`
--
ALTER TABLE `term_relationships`
  ADD KEY `term_taxonomy_id` (`term_taxonomy_id`),
  ADD KEY `object_id` (`object_id`);

--
-- Chỉ mục cho bảng `term_taxonomy`
--
ALTER TABLE `term_taxonomy`
  ADD PRIMARY KEY (`term_taxonomy_id`),
  ADD UNIQUE KEY `term_id_taxonomy` (`term_id`,`taxonomy`),
  ADD KEY `taxonomy` (`taxonomy`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `postmeta`
--
ALTER TABLE `postmeta`
  MODIFY `meta_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=356;

--
-- AUTO_INCREMENT cho bảng `posts`
--
ALTER TABLE `posts`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=390;

--
-- AUTO_INCREMENT cho bảng `terms`
--
ALTER TABLE `terms`
  MODIFY `term_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=246;

--
-- AUTO_INCREMENT cho bảng `term_taxonomy`
--
ALTER TABLE `term_taxonomy`
  MODIFY `term_taxonomy_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=163;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `postmeta`
--
ALTER TABLE `postmeta`
  ADD CONSTRAINT `postmeta_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`post_author`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `term_relationships`
--
ALTER TABLE `term_relationships`
  ADD CONSTRAINT `term_relationships_ibfk_1` FOREIGN KEY (`object_id`) REFERENCES `posts` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `term_relationships_ibfk_2` FOREIGN KEY (`term_taxonomy_id`) REFERENCES `term_taxonomy` (`term_taxonomy_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `term_taxonomy`
--
ALTER TABLE `term_taxonomy`
  ADD CONSTRAINT `term_taxonomy_ibfk_1` FOREIGN KEY (`term_id`) REFERENCES `terms` (`term_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
