-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 07, 2022 at 04:17 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `manpro2`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `id_pegawai` int(11) NOT NULL,
  `id_unit` int(11) NOT NULL,
  `id_lokasi` int(11) NOT NULL,
  `latitude` int(11) DEFAULT NULL,
  `longtidue` int(11) DEFAULT NULL,
  `nama_device` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `biro`
--

CREATE TABLE `biro` (
  `username` varchar(10) NOT NULL,
  `sandi` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `biro`
--

INSERT INTO `biro` (`username`, `sandi`) VALUES
('admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `cuti`
--

CREATE TABLE `cuti` (
  `id_cuti` int(11) NOT NULL,
  `id_surat` int(11) NOT NULL,
  `id_katagoricuti` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `katagori_cuti`
--

CREATE TABLE `katagori_cuti` (
  `id_katagoricuti` int(11) NOT NULL,
  `nama_cuti` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `katagori_cuti`
--

INSERT INTO `katagori_cuti` (`id_katagoricuti`, `nama_cuti`) VALUES
(1, 'sakit'),
(2, 'cuti tahunan'),
(3, 'cuti melahirkan'),
(4, 'cuti besar'),
(5, 'cuti karena alasan yang penting'),
(6, 'cuti bersama'),
(7, 'cuti diluar tanggungan negara');

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `id_pegawai` int(11) NOT NULL,
  `id_unit` int(11) NOT NULL,
  `nama_pegawai` varchar(255) NOT NULL,
  `username` varchar(10) NOT NULL,
  `sandi` varchar(10) NOT NULL,
  `jabatan_pegawai` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`id_pegawai`, `id_unit`, `nama_pegawai`, `username`, `sandi`, `jabatan_pegawai`) VALUES
(1, 1, 'Sutomo', 'sutomo1234', 'sutomo1234', 'kepala unit'),
(2, 2, 'Ko Rico', 'rico12345', 'rico12345', 'kepala unit'),
(3, 3, 'William', 'william123', 'william123', 'kepala unit'),
(4, 4, 'Kevin', 'kevin12345', 'kevin12345', 'kepala unit');

-- --------------------------------------------------------

--
-- Table structure for table `surat`
--

CREATE TABLE `surat` (
  `id_surat` int(11) NOT NULL,
  `nama_pegawai` varchar(255) NOT NULL,
  `upload_surat` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `surat`
--

INSERT INTO `surat` (`id_surat`, `nama_pegawai`, `upload_surat`) VALUES
(1, 'Sutomo', '.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `unit`
--

CREATE TABLE `unit` (
  `Id_unit` int(11) NOT NULL,
  `nama_unit` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `unit`
--

INSERT INTO `unit` (`Id_unit`, `nama_unit`) VALUES
(1, 'Database'),
(2, 'FrontEnd'),
(3, 'BackEnd'),
(4, 'Sekret');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id_lokasi`),
  ADD KEY `id_pegawai` (`id_pegawai`),
  ADD KEY `id_unit` (`id_unit`);

--
-- Indexes for table `cuti`
--
ALTER TABLE `cuti`
  ADD PRIMARY KEY (`id_cuti`),
  ADD KEY `id_surat` (`id_surat`),
  ADD KEY `id_katagoricuti` (`id_katagoricuti`);

--
-- Indexes for table `katagori_cuti`
--
ALTER TABLE `katagori_cuti`
  ADD PRIMARY KEY (`id_katagoricuti`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id_pegawai`),
  ADD KEY `id_unit` (`id_unit`);

--
-- Indexes for table `surat`
--
ALTER TABLE `surat`
  ADD PRIMARY KEY (`id_surat`);

--
-- Indexes for table `unit`
--
ALTER TABLE `unit`
  ADD PRIMARY KEY (`Id_unit`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id_lokasi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cuti`
--
ALTER TABLE `cuti`
  MODIFY `id_cuti` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `surat`
--
ALTER TABLE `surat`
  MODIFY `id_surat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `absensi_ibfk_1` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawai` (`id_pegawai`),
  ADD CONSTRAINT `absensi_ibfk_2` FOREIGN KEY (`id_unit`) REFERENCES `pegawai` (`id_unit`);

--
-- Constraints for table `cuti`
--
ALTER TABLE `cuti`
  ADD CONSTRAINT `cuti_ibfk_1` FOREIGN KEY (`id_surat`) REFERENCES `surat` (`id_surat`),
  ADD CONSTRAINT `cuti_ibfk_2` FOREIGN KEY (`id_katagoricuti`) REFERENCES `katagori_cuti` (`id_katagoricuti`);

--
-- Constraints for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD CONSTRAINT `pegawai_ibfk_1` FOREIGN KEY (`id_unit`) REFERENCES `unit` (`Id_unit`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
