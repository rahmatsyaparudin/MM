-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 02, 2018 at 10:08 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fileupload`
--

-- --------------------------------------------------------

--
-- Table structure for table `file_list`
--

CREATE TABLE `file_list` (
  `file_id` int(11) NOT NULL,
  `file_tittle` varchar(150) CHARACTER SET utf8mb4 NOT NULL,
  `file_name` varchar(150) CHARACTER SET utf8mb4 NOT NULL,
  `file_desc` text CHARACTER SET utf8mb4,
  `location` tinytext CHARACTER SET utf8mb4 NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `username` varchar(30) CHARACTER SET utf8mb4 NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `id` int(11) NOT NULL,
  `file_format` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `path_to_upload` varchar(30) CHARACTER SET utf8mb4 NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `file_format`, `path_to_upload`, `status`, `timestamp`) VALUES
(1, 'pdf', 'uploads', 1, '2018-03-01 09:27:14');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(30) CHARACTER SET utf8mb4 NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `isAdmin` tinyint(4) DEFAULT NULL,
  `isDeleted` tinyint(4) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `password`, `name`, `email`, `status`, `isAdmin`, `isDeleted`, `timestamp`) VALUES
('admin', '3iiFB9hctlVe_xAR9L-dxf1k5p_XMpoJwjemqgRoya4', 'Administrator', 'administrator@administrator.com', 1, 1, NULL, '2018-03-02 09:08:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `file_list`
--
ALTER TABLE `file_list`
  ADD PRIMARY KEY (`file_id`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `file_list`
--
ALTER TABLE `file_list`
  MODIFY `file_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
