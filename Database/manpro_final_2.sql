-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 08, 2022 at 09:52 AM
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
-- Database: `manpro_final_2`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `id_absensi` int(11) NOT NULL,
  `id_pegawai` int(11) NOT NULL,
  `id_unit` int(11) NOT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `nama_device` varchar(50) DEFAULT NULL,
  `_timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `terlambat` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `absensi`
--

INSERT INTO `absensi` (`id_absensi`, `id_pegawai`, `id_unit`, `latitude`, `longitude`, `nama_device`, `_timestamp`, `terlambat`) VALUES
(1, 3, 3, -7.2553631, 112.7494044, 'DESKTOP-EEBICNQ', '2021-10-03 01:57:53', 0),
(2, 1, 1, -7.2553631, 112.7494044, 'DESKTOP-EEBICNQ', '2021-10-03 02:03:35', 0),
(3, 3, 3, -7.2553194, 112.7494347, 'DESKTOP-EEBICNQ', '2021-10-14 09:22:23', 0),
(4, 5, 1, -7.255327, 112.7494337, 'DESKTOP-EEBICNQ', '2021-10-14 10:03:24', 1),
(5, 2, 2, -8.3525632, 113.6361472, 'LAPTOP-CB4M6SRF', '2021-10-16 04:03:38', 1),
(6, 5, 1, -8.3525632, 113.6361472, 'LAPTOP-CB4M6SRF', '2021-10-16 04:04:46', 0),
(7, 1, 1, -8.3525632, 113.6361472, 'LAPTOP-CB4M6SRF', '2021-10-16 07:23:26', 0),
(8, 3, 3, -8.3525632, 113.6361472, 'LAPTOP-CB4M6SRF', '2021-10-16 07:23:58', 0),
(9, 2, 2, -8.175616, 113.6590848, 'LAPTOP-CB4M6SRF', '2021-10-17 01:26:05', 0),
(10, 5, 1, -8.175616, 113.6590848, 'LAPTOP-CB4M6SRF', '2021-10-17 01:28:36', 0),
(11, 1, 1, -8.175616, 113.6590848, 'LAPTOP-CB4M6SRF', '2021-10-17 02:39:24', 0),
(12, 3, 3, -8.175616, 113.6590848, 'LAPTOP-CB4M6SRF', '2021-10-17 02:41:55', 0),
(13, 2, 2, -8.175616, 113.6590848, 'LAPTOP-CB4M6SRF', '2021-10-18 01:57:27', 0),
(14, 1, 1, -8.175616, 113.6590848, 'LAPTOP-CB4M6SRF', '2021-10-18 03:01:35', 0),
(15, 2, 2, -8.175616, 113.6590848, 'LAPTOP-CB4M6SRF', '2021-10-19 03:53:18', 0),
(16, 1, 1, -8.175616, 113.6590848, 'LAPTOP-CB4M6SRF', '2021-10-19 04:23:43', 0),
(17, 5, 1, -8.175616, 113.6590848, 'LAPTOP-CB4M6SRF', '2021-10-19 06:20:58', 0),
(18, 1, 1, -8.1690624, 113.70496, 'LAPTOP-CB4M6SRF', '2021-10-20 00:04:32', 0),
(19, 5, 1, -8.1690624, 113.70496, 'LAPTOP-CB4M6SRF', '2021-10-20 00:07:32', 0),
(20, 2, 2, -8.1690624, 113.70496, 'LAPTOP-CB4M6SRF', '2021-10-20 02:32:50', 0),
(21, 2, 2, -8.1690624, 113.70496, 'LAPTOP-CB4M6SRF', '2021-10-20 17:14:26', 0),
(22, 5, 1, -8.1690624, 113.70496, 'LAPTOP-CB4M6SRF', '2021-10-20 17:14:38', 0),
(23, 1, 1, -8.1690624, 113.70496, 'LAPTOP-CB4M6SRF', '2021-10-21 06:09:08', 0),
(24, 3, 3, -8.1690624, 113.70496, 'LAPTOP-CB4M6SRF', '2021-10-21 06:16:22', 0),
(25, 4, 4, -8.1690624, 113.70496, 'LAPTOP-CB4M6SRF', '2021-10-21 06:16:41', 0),
(26, 1, 1, -8.1854464, 113.6656384, 'LAPTOP-CB4M6SRF', '2021-10-22 00:23:46', 0),
(27, 2, 2, -8.1854464, 113.6656384, 'LAPTOP-CB4M6SRF', '2021-10-22 01:34:07', 0),
(28, 1, 1, -8.1526784, 113.7180672, 'LAPTOP-CB4M6SRF', '2021-10-26 10:41:28', 0),
(29, 1, 1, -8.1821696, 113.70496, 'LAPTOP-CB4M6SRF', '2021-10-28 15:01:33', 0),
(30, 1, 1, -8.1723392, 113.6820224, 'LAPTOP-CB4M6SRF', '2021-10-29 00:31:59', 0),
(31, 1, 1, -8.1723392, 113.6820224, 'LAPTOP-CB4M6SRF', '2021-10-30 03:31:31', 0),
(32, 2, 2, -8.1723392, 113.7016832, 'LAPTOP-CB4M6SRF', '2021-11-01 06:41:02', 0),
(33, 1, 1, -8.1723392, 113.7016832, 'LAPTOP-CB4M6SRF', '2021-11-01 06:42:44', 0),
(34, 5, 1, -8.1723392, 113.7016832, 'LAPTOP-CB4M6SRF', '2021-11-01 08:53:20', 0),
(35, 2, 2, -8.1723392, 113.6951296, 'LAPTOP-CB4M6SRF', '2021-11-02 09:32:16', 0),
(36, 1, 1, -8.1723392, 113.6951296, 'LAPTOP-CB4M6SRF', '2021-11-02 09:32:51', 0),
(39, 5, 1, -8.1723392, 113.6951296, 'LAPTOP-CB4M6SRF', '2021-11-03 07:22:43', 0),
(40, 2, 2, -8.1723392, 113.6951296, 'LAPTOP-CB4M6SRF', '2021-11-03 11:38:02', 0),
(41, 1, 1, -8.1723392, 113.6951296, 'LAPTOP-CB4M6SRF', '2021-11-03 11:38:59', 0),
(42, 4, 4, -8.1723392, 113.6951296, 'LAPTOP-CB4M6SRF', '2021-11-03 11:40:01', 0),
(43, 3, 3, -8.1723392, 113.6951296, 'LAPTOP-CB4M6SRF', '2021-11-03 11:41:36', 0),
(44, 5, 1, -8.1723392, 113.6951296, 'LAPTOP-CB4M6SRF', '2021-11-04 15:12:13', 0),
(45, 2, 2, -8.1723392, 113.6951296, 'LAPTOP-CB4M6SRF', '2021-11-04 15:29:10', 0),
(46, 1, 1, -8.1723392, 113.6951296, 'LAPTOP-CB4M6SRF', '2021-11-04 15:33:12', 0),
(47, 5, 1, -8.1723392, 113.688576, 'LAPTOP-CB4M6SRF', '2021-11-05 01:03:00', 0),
(48, 1, 1, -8.1723392, 113.688576, 'LAPTOP-CB4M6SRF', '2021-11-05 01:06:00', 0),
(49, 2, 2, -8.1723392, 113.688576, 'LAPTOP-CB4M6SRF', '2021-11-05 10:08:35', 0),
(50, 5, 1, -7.2553577, 112.7494295, 'DESKTOP-EEBICNQ', '2021-11-08 09:01:30', 0),
(51, 1, 1, -7.2553515, 112.7494301, 'DESKTOP-EEBICNQ', '2021-11-08 09:40:05', 0),
(52, 5, 1, -7.2553761, 112.7494295, 'DESKTOP-EEBICNQ', '2021-11-09 10:14:46', 0),
(53, 1, 1, -7.2553761, 112.7494295, 'DESKTOP-EEBICNQ', '2021-11-09 10:15:34', 0),
(54, 5, 1, -7.2553501, 112.7494352, 'DESKTOP-EEBICNQ', '2021-11-11 12:22:26', 1),
(55, 1, 1, -7.255359, 112.7494456, 'DESKTOP-EEBICNQ', '2021-11-15 12:45:05', 0),
(56, 5, 1, -7.2553546, 112.7494435, 'DESKTOP-EEBICNQ', '2021-11-15 13:31:15', 0),
(57, 1, 1, -7.2553449, 112.7494385, 'DESKTOP-EEBICNQ', '2021-11-16 09:13:24', 0),
(58, 5, 1, -7.2555625, 112.7494057, 'DESKTOP-EEBICNQ', '2021-11-18 06:13:37', 0),
(59, 1, 1, -7.2555625, 112.7494057, 'DESKTOP-EEBICNQ', '2021-11-18 06:18:40', 0),
(60, 3, 3, -7.2553544, 112.7494351, 'DESKTOP-EEBICNQ', '2021-11-18 10:56:38', 0),
(61, 1, 1, -7.2553422, 112.7494433, 'DESKTOP-EEBICNQ', '2021-11-19 00:32:18', 0),
(62, 1, 1, -7.2553963, 112.7494314, 'DESKTOP-EEBICNQ', '2021-11-20 08:30:21', 0),
(63, 5, 1, -7.2553963, 112.7494314, 'DESKTOP-EEBICNQ', '2021-11-20 08:44:26', 0),
(64, 3, 3, -7.2555985, 112.749417, 'DESKTOP-EEBICNQ', '2021-11-20 15:30:15', 1),
(65, 2, 2, -7.2555985, 112.749417, 'DESKTOP-EEBICNQ', '2021-11-20 15:33:25', 0),
(66, 5, 1, -7.2555983, 112.7494193, 'DESKTOP-EEBICNQ', '2021-11-21 14:10:28', 1),
(67, 1, 1, -7.2555983, 112.7494193, 'DESKTOP-EEBICNQ', '2021-11-21 14:20:46', 1),
(68, 1, 1, -7.25553, 112.749403, 'DESKTOP-EEBICNQ', '2021-11-22 04:35:56', 1),
(69, 5, 1, -7.2553867, 112.749404, 'DESKTOP-EEBICNQ', '2021-11-23 03:38:29', 1),
(70, 1, 1, -7.2553867, 112.749404, 'DESKTOP-EEBICNQ', '2021-11-23 03:56:39', 1),
(71, 5, 1, -7.2554002, 112.7494026, 'DESKTOP-EEBICNQ', '2021-11-25 06:36:19', 1),
(72, 1, 1, -7.2554002, 112.7494026, 'DESKTOP-EEBICNQ', '2021-11-25 06:36:57', 1),
(73, 2, 2, -7.4402694, 112.6996102, 'DESKTOP-D3N2TJ7', '2021-11-25 14:53:54', 1),
(74, 4, 4, 0, 0, 'DESKTOP-D3N2TJ7', '2021-11-25 15:25:28', 1),
(75, 3, 3, -6.176768, 106.807296, 'DESKTOP-D3N2TJ7', '2021-11-25 15:25:54', 1),
(76, 1, 1, 0, 0, 'LAPTOP-J54C2HB6', '2021-11-25 23:43:10', 0),
(77, 1, 1, 0, 0, 'LAPTOP-J54C2HB6', '2022-06-07 04:46:49', 1);

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
  `id_pegawai` int(11) DEFAULT NULL,
  `id_katagoricuti` int(11) DEFAULT NULL,
  `nama_surat` varchar(199) DEFAULT NULL,
  `deskripsi` varchar(255) NOT NULL,
  `status_cuti` tinyint(1) NOT NULL DEFAULT 0,
  `_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cuti`
--

INSERT INTO `cuti` (`id_cuti`, `id_pegawai`, `id_katagoricuti`, `nama_surat`, `deskripsi`, `status_cuti`, `_time`) VALUES
(1, 5, 4, 'file_11.pdf', 'Tes Untuk Cuti', 0, '2021-11-18 05:47:13'),
(2, 4, 5, 'file_11.pdf', 'Tes Untuk Cuti', 0, '2021-11-18 05:47:02'),
(3, 3, 2, 'file_11.pdf', 'Tes Untuk Cuti', 0, '2021-11-18 05:47:02'),
(4, 1, 6, 'file_11.pdf', 'Tes Untuk Cuti', 1, '2021-11-18 05:47:02'),
(5, 5, 7, 'file_11.pdf', 'Tes Untuk Cuti', 0, '2021-11-18 05:47:02'),
(6, 1, 1, 'file_11.pdf', 'Tes Untuk Cuti', 0, '2021-11-18 05:47:02'),
(7, 1, 1, 'file_11.pdf', 'Tes Untuk Cuti', 0, '2021-11-18 05:47:02'),
(8, 1, 6, 'file_11.pdf', 'Tes Untuk Cuti', 0, '2021-11-18 05:47:02'),
(9, 5, 2, 'file_11.pdf', 'Tes Untuk Cuti', 0, '2021-11-18 05:47:02'),
(10, 5, 5, 'file_11.pdf', 'Tes Untuk Cuti', 0, '2021-11-18 05:47:02'),
(11, 3, 4, 'file_11.pdf', 'Tes Untuk Cuti', 0, '2021-11-18 05:47:02'),
(12, 1, 2, 'file_12.pdf', 'TES 1 2 3', 0, '2021-11-20 01:43:49'),
(13, 5, 6, 'file_13.pdf', 'Write something here...', 0, '2021-11-20 01:45:39'),
(14, 5, 1, 'file_14.pdf', 'Hello, im want to holiday', 1, '2021-11-25 14:39:20'),
(15, 1, 2, 'file_15.pdf', 'aku mau liburrrrr', 1, '2021-11-25 14:52:35'),
(16, 2, 4, 'file_16.pdf', 'cutiiii', 1, '2021-11-25 14:54:32'),
(17, 1, 2, 'file_17.pdf', 'dawwadawd', 0, '2021-11-25 14:56:37');

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
(1, 'Sakit'),
(2, 'Cuti Tahunan'),
(3, 'Cuti Melahirkan'),
(4, 'Cuti Besar'),
(5, 'Cuti Karena Alasan Penting'),
(6, 'Cuti Bersama'),
(7, 'Cuti Diluar Tanggungan Negara');

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
  `jabatan_pegawai` varchar(255) NOT NULL,
  `tbl_img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`id_pegawai`, `id_unit`, `nama_pegawai`, `username`, `sandi`, `jabatan_pegawai`, `tbl_img`) VALUES
(1, 1, 'Sutomo', 'sutomo1234', 'sutomo1234', 'Kepala Unit', 'tomo.jpg'),
(2, 2, 'Ko Rico', 'rico12345', 'rico12345', 'Kepala Unit', 'korico.jpg'),
(3, 3, 'William', 'william123', 'william123', 'Kepala Unit', 'william.jpg'),
(4, 4, 'Kevin', 'kevin12345', 'kevin12345', 'Kepala Unit', 'kevin.jpg'),
(5, 1, 'Andi', 'andi', 'andi', 'Karyawan', 'download.jpg');

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
  ADD PRIMARY KEY (`id_absensi`),
  ADD KEY `id_pegawai` (`id_pegawai`),
  ADD KEY `id_unit` (`id_unit`);

--
-- Indexes for table `cuti`
--
ALTER TABLE `cuti`
  ADD PRIMARY KEY (`id_cuti`),
  ADD KEY `id_pegawai` (`id_pegawai`),
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
  MODIFY `id_absensi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `cuti`
--
ALTER TABLE `cuti`
  MODIFY `id_cuti` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

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
  ADD CONSTRAINT `cuti_ibfk_1` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawai` (`id_pegawai`),
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
