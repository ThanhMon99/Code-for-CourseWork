-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 06, 2020 lúc 05:00 PM
-- Phiên bản máy phục vụ: 10.4.11-MariaDB
-- Phiên bản PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `asmtest`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `account`
--

CREATE TABLE `account` (
  `id` int(200) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(100) DEFAULT NULL,
  `fullname` varchar(200) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Address` varchar(100) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `Dob` date DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `status1` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `account`
--

INSERT INTO `account` (`id`, `username`, `password`, `role`, `fullname`, `Email`, `Address`, `Description`, `Dob`, `status`, `status1`) VALUES
(7, 'Admin', '202cb962ac59075b964b07152d234b70', 'Admin', 'thanh', 'admin@gmail.com', 'Ha Noi', 'I am Admin', '1999-10-08', '', ''),
(8, 'Staff', '202cb962ac59075b964b07152d234b70', 'Staff', 'Staff', 'Staff@gmail.com', 'Staff', '', '1999-04-22', '', ''),
(9, 'tutor1', '202cb962ac59075b964b07152d234b70', 'Tutor', 'tutor1', 'tutor1@gmail.com', 'Ha Noi', NULL, NULL, '0', '1'),
(10, 'tutor2', '202cb962ac59075b964b07152d234b70', 'Tutor', 'tutor2', 'tutor2@gmail.com', 'Ha Noi', NULL, NULL, '0', '0'),
(11, 'student1', '202cb962ac59075b964b07152d234b70', 'Student', 'student1', 'thanhnddgch17409@fpt.edu.vn', 'Ha Noi', '', '0000-00-00', '0', '1'),
(12, 'student2', '202cb962ac59075b964b07152d234b70', 'Student', 'student2', 'student2@gmail.com', 'Ha Noi', '', '0000-00-00', '0', '0'),
(13, 'student3', '202cb962ac59075b964b07152d234b70', 'Student', 'student3', 'student3@gmail.com', 'Ha Noi', NULL, NULL, '0', '0'),
(14, 'student4', '202cb962ac59075b964b07152d234b70', 'Student', 'student4', 'student4@gmail.com', 'Ha Noi', NULL, NULL, '0', '0'),
(15, 'student5', '202cb962ac59075b964b07152d234b70', 'Student', 'student5', 'student5@gmail.com', NULL, NULL, NULL, '0', '0');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `allocate`
--

CREATE TABLE `allocate` (
  `acid` int(200) NOT NULL,
  `tutorid` int(200) NOT NULL,
  `studentid` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `allocate`
--

INSERT INTO `allocate` (`acid`, `tutorid`, `studentid`) VALUES
(68, 9, 11),
(69, 9, 12),
(97, 9, 13);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chat_message`
--

CREATE TABLE `chat_message` (
  `chat_message_id` int(11) NOT NULL,
  `to_user_id` int(11) NOT NULL,
  `from_user_id` int(11) NOT NULL,
  `chat_message` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `chat_message`
--

INSERT INTO `chat_message` (`chat_message_id`, `to_user_id`, `from_user_id`, `chat_message`, `timestamp`, `status`) VALUES
(25, 8, 7, 'hello', '2020-04-06 14:34:18', 2),
(26, 11, 9, 'hello', '2020-04-08 08:10:04', 0),
(27, 9, 11, 'hi', '2020-04-08 08:10:11', 0),
(28, 8, 7, 'hello\n', '2020-04-09 09:56:32', 2),
(29, 11, 9, 'fgfdg', '2020-04-11 18:50:05', 2),
(30, 8, 7, 'hello\n', '2020-04-21 10:17:37', 2),
(31, 8, 7, 'hello', '2020-04-21 10:17:50', 0),
(32, 8, 7, 'hello', '2020-04-21 10:22:30', 0),
(33, 8, 7, 'dsfgdfg', '2020-04-21 10:22:46', 0),
(34, 7, 8, 'Thành', '2020-04-21 10:24:38', 0),
(35, 8, 7, 'sfdsdfsdfsd', '2020-04-23 11:06:31', 1),
(36, 8, 7, 'fsdfasdf', '2020-04-23 11:09:21', 1),
(37, 8, 7, 'fdsafasd', '2020-04-23 11:09:25', 1),
(38, 8, 7, 'sfdfsdf', '2020-04-23 11:12:36', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comment`
--

CREATE TABLE `comment` (
  `comment_id` int(11) NOT NULL,
  `comment` varchar(200) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `login_details`
--

CREATE TABLE `login_details` (
  `login_details_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `last_activity` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_type` enum('no','yes') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `login_details`
--

INSERT INTO `login_details` (`login_details_id`, `user_id`, `last_activity`, `is_type`) VALUES
(49, 7, '2020-04-07 10:19:23', 'no'),
(50, 8, '2020-04-08 05:59:45', 'no'),
(51, 8, '2020-04-08 08:07:22', 'no'),
(52, 9, '2020-04-08 08:11:02', 'no'),
(53, 11, '2020-04-08 08:16:50', 'no'),
(54, 9, '2020-04-08 08:16:45', 'no'),
(55, 7, '2020-04-08 09:04:03', 'no'),
(56, 7, '2020-04-08 12:03:35', 'no'),
(57, 7, '2020-04-08 13:35:32', 'no'),
(58, 7, '2020-04-08 13:36:24', 'no'),
(59, 7, '2020-04-08 17:26:14', 'no'),
(60, 8, '2020-04-09 08:44:24', 'no'),
(61, 7, '2020-04-09 09:57:30', 'no'),
(62, 8, '2020-04-09 09:56:53', 'no'),
(63, 9, '2020-04-09 09:57:54', 'no'),
(64, 10, '2020-04-09 09:58:22', 'no'),
(65, 7, '2020-04-09 09:58:38', 'no'),
(66, 8, '2020-04-09 18:12:08', 'no'),
(67, 7, '2020-04-10 08:31:10', 'no'),
(68, 7, '2020-04-10 09:09:03', 'no'),
(69, 9, '2020-04-10 10:38:11', 'no'),
(70, 11, '2020-04-10 11:20:03', 'no'),
(71, 9, '2020-04-10 11:20:31', 'no'),
(72, 11, '2020-04-10 11:21:05', 'no'),
(73, 9, '2020-04-10 11:22:09', 'no'),
(74, 9, '2020-04-10 15:05:19', 'no'),
(75, 9, '2020-04-11 14:15:29', 'no'),
(76, 11, '2020-04-11 14:28:58', 'no'),
(77, 7, '2020-04-11 17:08:51', 'no'),
(78, 7, '2020-04-11 17:25:42', 'no'),
(79, 7, '2020-04-11 17:36:39', 'no'),
(80, 9, '2020-04-11 18:50:10', 'no'),
(81, 11, '2020-04-11 19:29:56', 'no'),
(82, 7, '2020-04-12 13:49:40', 'no'),
(83, 7, '2020-04-12 13:51:11', 'no'),
(84, 9, '2020-04-12 15:30:10', 'no'),
(85, 7, '2020-04-12 17:18:39', 'no'),
(86, 7, '2020-04-12 17:26:40', 'no'),
(87, 7, '2020-04-13 14:38:38', 'no'),
(88, 9, '2020-04-13 15:23:22', 'no'),
(89, 7, '2020-04-13 16:43:09', 'no'),
(90, 9, '2020-04-13 16:54:26', 'no'),
(91, 9, '2020-04-15 06:09:06', 'no'),
(92, 9, '2020-04-15 07:09:17', 'no'),
(93, 9, '2020-04-15 07:10:35', 'no'),
(94, 12, '2020-04-15 07:21:57', 'no'),
(95, 9, '2020-04-15 09:33:14', 'no'),
(96, 8, '2020-04-15 09:40:28', 'no'),
(97, 9, '2020-04-17 11:44:07', 'no'),
(98, 8, '2020-04-17 12:29:58', 'no'),
(99, 9, '2020-04-17 14:34:09', 'no'),
(100, 7, '2020-04-17 14:39:00', 'no'),
(101, 8, '2020-04-20 15:16:15', 'no'),
(102, 8, '2020-04-20 17:22:15', 'no'),
(103, 9, '2020-04-20 19:16:07', 'no'),
(104, 7, '2020-04-20 19:16:58', 'no'),
(105, 9, '2020-04-20 19:33:18', 'no'),
(106, 11, '2020-04-20 19:44:21', 'no'),
(107, 11, '2020-04-20 19:44:59', 'no'),
(108, 8, '2020-04-21 05:24:21', 'no'),
(109, 7, '2020-04-21 07:48:11', 'no'),
(110, 15, '2020-04-21 07:56:56', 'no'),
(111, 8, '2020-04-21 07:58:27', 'no'),
(112, 7, '2020-04-21 10:00:48', 'no'),
(113, 7, '2020-04-21 10:25:26', 'no'),
(114, 8, '2020-04-21 10:16:01', 'no'),
(115, 11, '2020-04-21 10:16:41', 'no'),
(116, 8, '2020-04-21 11:21:13', 'no'),
(117, 9, '2020-04-21 10:44:12', 'no'),
(118, 8, '2020-04-21 11:00:15', 'no'),
(119, 9, '2020-04-21 11:03:42', 'no'),
(120, 8, '2020-04-21 11:14:42', 'no'),
(121, 7, '2020-04-23 13:48:22', 'no'),
(122, 11, '2020-04-24 10:51:25', 'no'),
(123, 8, '2020-04-24 10:56:37', 'no'),
(124, 8, '2020-04-24 11:07:20', 'no'),
(125, 8, '2020-04-24 12:59:31', 'no'),
(126, 8, '2020-04-24 14:34:23', 'no'),
(127, 8, '2020-04-24 14:35:35', 'no'),
(128, 8, '2020-04-28 05:57:15', 'no'),
(129, 9, '2020-04-28 06:00:21', 'no'),
(130, 8, '2020-04-28 06:17:04', 'no'),
(131, 7, '2020-05-01 16:29:36', 'no'),
(132, 13, '2020-05-01 16:39:01', 'no'),
(133, 9, '2020-05-01 17:23:34', 'no'),
(134, 8, '2020-05-01 17:23:49', 'no'),
(135, 9, '2020-05-03 08:03:33', 'no'),
(136, 11, '2020-05-03 08:04:29', 'no'),
(137, 12, '2020-05-03 08:07:51', 'no');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `meeting`
--

CREATE TABLE `meeting` (
  `MeetingID` int(11) NOT NULL,
  `AllocateID` int(11) NOT NULL,
  `Date` datetime NOT NULL,
  `Date_end` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `meeting`
--

INSERT INTO `meeting` (`MeetingID`, `AllocateID`, `Date`, `Date_end`) VALUES
(1, 97, '2020-04-23 02:06:00', '2020-05-01 23:53:07'),
(15, 69, '2020-05-02 00:18:35', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `to_user_id` int(11) NOT NULL,
  `createdate` timestamp NULL DEFAULT NULL,
  `updatedate` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `upload_file`
--

CREATE TABLE `upload_file` (
  `upload_id` int(11) NOT NULL,
  `fileName` varchar(150) NOT NULL,
  `fileUrl` varchar(200) NOT NULL,
  `type` varchar(20) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `allocate`
--
ALTER TABLE `allocate`
  ADD PRIMARY KEY (`acid`),
  ADD KEY `ibfk_1` (`tutorid`),
  ADD KEY `ibfk_2` (`studentid`);

--
-- Chỉ mục cho bảng `chat_message`
--
ALTER TABLE `chat_message`
  ADD PRIMARY KEY (`chat_message_id`);

--
-- Chỉ mục cho bảng `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `bfk_1` (`user_id`),
  ADD KEY `comment_ibfk_1` (`post_id`);

--
-- Chỉ mục cho bảng `login_details`
--
ALTER TABLE `login_details`
  ADD PRIMARY KEY (`login_details_id`);

--
-- Chỉ mục cho bảng `meeting`
--
ALTER TABLE `meeting`
  ADD PRIMARY KEY (`MeetingID`);

--
-- Chỉ mục cho bảng `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_ibfk_1` (`user_id`);

--
-- Chỉ mục cho bảng `upload_file`
--
ALTER TABLE `upload_file`
  ADD PRIMARY KEY (`upload_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `account`
--
ALTER TABLE `account`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `allocate`
--
ALTER TABLE `allocate`
  MODIFY `acid` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT cho bảng `chat_message`
--
ALTER TABLE `chat_message`
  MODIFY `chat_message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT cho bảng `comment`
--
ALTER TABLE `comment`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT cho bảng `login_details`
--
ALTER TABLE `login_details`
  MODIFY `login_details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;

--
-- AUTO_INCREMENT cho bảng `meeting`
--
ALTER TABLE `meeting`
  MODIFY `MeetingID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `upload_file`
--
ALTER TABLE `upload_file`
  MODIFY `upload_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `allocate`
--
ALTER TABLE `allocate`
  ADD CONSTRAINT `ibfk_1` FOREIGN KEY (`tutorid`) REFERENCES `account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ibfk_2` FOREIGN KEY (`studentid`) REFERENCES `account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `bfk_1` FOREIGN KEY (`user_id`) REFERENCES `account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
