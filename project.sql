-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 27, 2020 at 12:52 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `berita_acara`
--

CREATE TABLE `berita_acara` (
  `id` int(11) NOT NULL,
  `id_mahasiswa` int(11) DEFAULT NULL,
  `id_dosen_pembimbing` int(11) DEFAULT NULL,
  `id_ketua_penguji` int(11) DEFAULT NULL,
  `id_dosen_penguji` int(11) DEFAULT NULL,
  `tanggal` date NOT NULL DEFAULT current_timestamp(),
  `time` time NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `berkas`
--

CREATE TABLE `berkas` (
  `id` int(11) NOT NULL,
  `id_mahasiswa` int(11) DEFAULT NULL,
  `id_dosen_pembimbing` int(11) DEFAULT NULL,
  `id_ketua_penguji` int(11) DEFAULT NULL,
  `id_dosen_penguji` int(11) DEFAULT NULL,
  `file` varchar(100) NOT NULL,
  `revisi_dosen_pembimbing` varchar(100) DEFAULT NULL,
  `revisi_ketua_penguji` varchar(100) DEFAULT NULL,
  `revisi_dosen_penguji` varchar(100) DEFAULT NULL,
  `status_dosen_pembimbing` int(11) NOT NULL DEFAULT 0,
  `status_ketua_penguji` int(11) NOT NULL DEFAULT 0,
  `status_dosen_penguji` int(11) NOT NULL DEFAULT 0,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nomor` varchar(20) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `password` text NOT NULL,
  `profile_picture` varchar(100) NOT NULL,
  `role` tinyint(4) NOT NULL DEFAULT 0,
  `id_dosen_pembimbing` int(11) DEFAULT NULL,
  `id_ketua_penguji` int(11) DEFAULT NULL,
  `id_dosen_penguji` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `berita_acara`
--
ALTER TABLE `berita_acara`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_mahasiswa` (`id_mahasiswa`),
  ADD KEY `id_dosen_pembimbing` (`id_dosen_pembimbing`),
  ADD KEY `id_ketua_penguji` (`id_ketua_penguji`),
  ADD KEY `id_dosen_penguji` (`id_dosen_penguji`);

--
-- Indexes for table `berkas`
--
ALTER TABLE `berkas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `berkas_ibfk_1` (`id_dosen_pembimbing`),
  ADD KEY `berkas_ibfk_2` (`id_dosen_penguji`),
  ADD KEY `berkas_ibfk_3` (`id_ketua_penguji`),
  ADD KEY `id_mahasiswa` (`id_mahasiswa`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_dosen_pembimbing` (`id_dosen_pembimbing`),
  ADD KEY `id_ketua_penguji` (`id_ketua_penguji`),
  ADD KEY `id_dosen_penguji` (`id_dosen_penguji`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `berita_acara`
--
ALTER TABLE `berita_acara`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `berkas`
--
ALTER TABLE `berkas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `berita_acara`
--
ALTER TABLE `berita_acara`
  ADD CONSTRAINT `berita_acara_ibfk_1` FOREIGN KEY (`id_mahasiswa`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `berita_acara_ibfk_2` FOREIGN KEY (`id_dosen_pembimbing`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `berita_acara_ibfk_3` FOREIGN KEY (`id_ketua_penguji`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `berita_acara_ibfk_4` FOREIGN KEY (`id_dosen_penguji`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `berkas`
--
ALTER TABLE `berkas`
  ADD CONSTRAINT `berkas_ibfk_1` FOREIGN KEY (`id_dosen_pembimbing`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `berkas_ibfk_2` FOREIGN KEY (`id_dosen_penguji`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `berkas_ibfk_3` FOREIGN KEY (`id_ketua_penguji`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `berkas_ibfk_4` FOREIGN KEY (`id_mahasiswa`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`id_dosen_pembimbing`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `user_ibfk_2` FOREIGN KEY (`id_ketua_penguji`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `user_ibfk_3` FOREIGN KEY (`id_dosen_penguji`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
