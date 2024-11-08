-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 08, 2024 at 06:06 PM
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
-- Database: `dbwc`
--

-- --------------------------------------------------------

--
-- Table structure for table `akun`
--

CREATE TABLE `akun` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `email` varchar(100) NOT NULL,
  `profile_picture` varchar(255) NOT NULL,
  `disable` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `akun`
--

INSERT INTO `akun` (`id`, `username`, `password`, `deskripsi`, `email`, `profile_picture`, `disable`) VALUES
(-1, 'Anonymous', '', '', '', 'default.jpg', 1),
(0, 'uploader', '', '', '', 'uploader.jpg', 0),
(2, 'admin', '$2y$10$OR8gx8qTGAx5BpqJImAczey4UbaIhY7Ip98flaZlRlB4JBUW0RcCG', '', 'admin@admin.com', 'default.jpg', 0),
(3, 'tembokkertas', '$2y$10$l/F18u44vm7empxUk1.nMOShEeNU1BZpEI9drBOA6iFv4t3Skvs9q', '', 'tembokkertas@tembokkertas.com', 'default.jpg', 0),
(5, '', '$2y$10$bGhPTseU5Qkd13iYkC.c6uhzuLSAWypovGa3fS2OiO9QxnGgx8.3S', '', '', 'default.jpg', 0),
(6, 'aryafr', '$2y$10$KrfG.VHYhMx8QqsFZvv7vulo0eLu2FfpCHcvZKYoqfSE9U78gdbee', '', 'aryafr@gmail.com', 'default.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `komentar`
--

CREATE TABLE `komentar` (
  `id` int(11) NOT NULL,
  `id_akun` int(11) NOT NULL,
  `id_wallpaper` int(11) NOT NULL,
  `komen` text NOT NULL,
  `jumlahlike` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE `tag` (
  `id` int(11) NOT NULL,
  `id_wallpaper` int(11) NOT NULL,
  `id_tag_detail` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tag`
--

INSERT INTO `tag` (`id`, `id_wallpaper`, `id_tag_detail`) VALUES
(1, 1, 2),
(2, 1, 1),
(3, 2, 1),
(4, 3, 2),
(5, 3, 1),
(6, 3, 3),
(7, 4, 2),
(8, 4, 1),
(9, 5, 2),
(10, 5, 1),
(11, 5, 3),
(12, 6, 19),
(13, 7, 19),
(28, 0, 4),
(29, 0, 19),
(30, 0, 10),
(31, 0, 4),
(32, 0, 19),
(33, 0, 4),
(34, 0, 19),
(35, 0, 1),
(36, 0, 5),
(37, 0, 6),
(58, 17, 4),
(59, 17, 2),
(60, 17, 19),
(61, 18, 2),
(62, 18, 19),
(64, 20, 2),
(65, 20, 19),
(66, 20, 10),
(67, 20, 23);

-- --------------------------------------------------------

--
-- Table structure for table `tag_detail`
--

CREATE TABLE `tag_detail` (
  `id` int(11) NOT NULL,
  `jenis` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tag_detail`
--

INSERT INTO `tag_detail` (`id`, `jenis`) VALUES
(4, 'Abstract'),
(2, 'Animal'),
(1, 'Anime'),
(19, 'Anomaly'),
(5, 'Cartoon'),
(6, 'Fantasy'),
(7, 'Game'),
(8, 'Landscape'),
(9, 'Medieval'),
(10, 'Memes'),
(21, 'Minimalist'),
(11, 'Music'),
(15, 'Nature'),
(17, 'Pixel Art'),
(12, 'Retro'),
(18, 'Sci-Fi'),
(23, 'Skena'),
(13, 'Sports'),
(14, 'Technology'),
(20, 'Unspecified Genre'),
(3, 'Vehicle');

-- --------------------------------------------------------

--
-- Table structure for table `wallpaper`
--

CREATE TABLE `wallpaper` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL,
  `disukai` int(11) NOT NULL,
  `size` varchar(100) NOT NULL,
  `path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akun`
--
ALTER TABLE `akun`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `komentar`
--
ALTER TABLE `komentar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tag_detail`
--
ALTER TABLE `tag_detail`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `jenis` (`jenis`);

--
-- Indexes for table `wallpaper`
--
ALTER TABLE `wallpaper`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `akun`
--
ALTER TABLE `akun`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `komentar`
--
ALTER TABLE `komentar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `tag`
--
ALTER TABLE `tag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `tag_detail`
--
ALTER TABLE `tag_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `wallpaper`
--
ALTER TABLE `wallpaper`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
