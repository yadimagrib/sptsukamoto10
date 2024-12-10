-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 11, 2022 at 05:13 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_tsukamoto`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_admin`
--

CREATE TABLE `tb_admin` (
  `user` varchar(16) NOT NULL,
  `pass` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_admin`
--

INSERT INTO `tb_admin` (`user`, `pass`) VALUES
('admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `tb_alternatif`
--

CREATE TABLE `tb_alternatif` (
  `kode_alternatif` varchar(16) NOT NULL,
  `nama_alternatif` varchar(255) NOT NULL,
  `keterangan` text NOT NULL,
  `rank` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_alternatif`
--

INSERT INTO `tb_alternatif` (`kode_alternatif`, `nama_alternatif`, `keterangan`, `rank`) VALUES
('A02', 'JUMLAH BALITA PENDERITA GEJALA STUNTING PADA TAHUN 2022', 'Faktor yang banyak diderita oleh Pasien Balita yaitu Asupan Gizi, Kualitas MCK, dan Perkembangan Fisik.', 0),
('A01', 'JUMLAH BALITA PENDERITA GEJALA STUNTING PADA TAHUN 2021', 'Faktor yang banyak diderita oleh Pasien Balita yaitu Asupan Gizi, Massa Tubuh, dan Perkembangan Fisik.', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_aturan`
--

CREATE TABLE `tb_aturan` (
  `id_aturan` int(11) NOT NULL,
  `no_aturan` int(11) DEFAULT NULL,
  `kode_kriteria` varchar(16) DEFAULT NULL,
  `operator` varchar(16) DEFAULT NULL,
  `kode_himpunan` varchar(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_aturan`
--

INSERT INTO `tb_aturan` (`id_aturan`, `no_aturan`, `kode_kriteria`, `operator`, `kode_himpunan`) VALUES
(1, 1, 'K01', 'AND', 'K01-01'),
(2, 1, 'K02', 'AND', 'K02-01'),
(3, 1, 'K03', 'AND', 'K03-01'),
(4, 1, 'K04', 'AND', 'K04-01'),
(5, 1, 'K05', 'AND', 'K05-01'),
(6, 2, 'K01', 'AND', 'K01-01'),
(7, 2, 'K02', 'AND', 'K02-01'),
(8, 2, 'K03', 'AND', 'K03-01'),
(9, 2, 'K04', 'AND', 'K04-02'),
(10, 2, 'K05', 'AND', 'K05-02'),
(11, 3, 'K01', 'AND', 'K01-01'),
(12, 3, 'K02', 'AND', 'K02-01'),
(13, 3, 'K03', 'AND', 'K03-02'),
(14, 3, 'K04', 'AND', 'K04-01'),
(15, 3, 'K05', 'AND', 'K05-01'),
(16, 4, 'K01', 'AND', 'K01-01'),
(17, 4, 'K02', 'AND', 'K02-01'),
(18, 4, 'K03', 'AND', 'K03-02'),
(19, 4, 'K04', 'AND', 'K04-02'),
(20, 4, 'K05', 'AND', 'K05-02'),
(21, 5, 'K01', 'AND', 'K01-01'),
(22, 5, 'K02', 'AND', 'K02-02'),
(23, 5, 'K03', 'AND', 'K03-01'),
(24, 5, 'K04', 'AND', 'K04-01'),
(25, 5, 'K05', 'AND', 'K05-01'),
(26, 6, 'K01', 'AND', 'K01-01'),
(27, 6, 'K02', 'AND', 'K02-02'),
(28, 6, 'K03', 'AND', 'K03-01'),
(29, 6, 'K04', 'AND', 'K04-02'),
(30, 6, 'K05', 'AND', 'K05-01'),
(31, 7, 'K01', 'AND', 'K01-01'),
(32, 7, 'K02', 'AND', 'K02-02'),
(33, 7, 'K03', 'AND', 'K03-02'),
(34, 7, 'K04', 'AND', 'K04-01'),
(35, 7, 'K05', 'AND', 'K05-01'),
(36, 8, 'K01', 'AND', 'K01-01'),
(37, 8, 'K02', 'AND', 'K02-02'),
(38, 8, 'K03', 'AND', 'K03-02'),
(39, 8, 'K04', 'AND', 'K04-02'),
(40, 8, 'K05', 'AND', 'K05-02'),
(41, 9, 'K01', 'AND', 'K01-02'),
(42, 9, 'K02', 'AND', 'K02-01'),
(43, 9, 'K03', 'AND', 'K03-01'),
(44, 9, 'K04', 'AND', 'K04-01'),
(45, 9, 'K05', 'AND', 'K05-01'),
(46, 10, 'K01', 'AND', 'K01-02'),
(47, 10, 'K02', 'AND', 'K02-01'),
(48, 10, 'K03', 'AND', 'K03-01'),
(49, 10, 'K04', 'AND', 'K04-02'),
(50, 10, 'K05', 'AND', 'K05-01'),
(51, 11, 'K01', 'AND', 'K01-02'),
(52, 11, 'K02', 'AND', 'K02-01'),
(53, 11, 'K03', 'AND', 'K03-02'),
(54, 11, 'K04', 'AND', 'K04-01'),
(55, 11, 'K05', 'AND', 'K05-01'),
(56, 12, 'K01', 'AND', 'K01-02'),
(57, 12, 'K02', 'AND', 'K02-01'),
(58, 12, 'K03', 'AND', 'K03-02'),
(59, 12, 'K04', 'AND', 'K04-02'),
(60, 12, 'K05', 'AND', 'K05-01'),
(61, 13, 'K01', 'AND', 'K01-02'),
(62, 13, 'K02', 'AND', 'K02-02'),
(63, 13, 'K03', 'AND', 'K03-01'),
(64, 13, 'K04', 'AND', 'K04-01'),
(65, 13, 'K05', 'AND', 'K05-01'),
(66, 14, 'K01', 'AND', 'K01-02'),
(67, 14, 'K02', 'AND', 'K02-02'),
(68, 14, 'K03', 'AND', 'K03-01'),
(69, 14, 'K04', 'AND', 'K04-02'),
(70, 14, 'K05', 'AND', 'K05-01'),
(71, 15, 'K01', 'AND', 'K01-02'),
(72, 15, 'K02', 'AND', 'K02-02'),
(73, 15, 'K03', 'AND', 'K03-02'),
(74, 15, 'K04', 'AND', 'K04-01'),
(75, 15, 'K05', 'AND', 'K05-02'),
(76, 16, 'K01', 'AND', 'K01-02'),
(77, 16, 'K02', 'AND', 'K02-02'),
(78, 16, 'K03', 'AND', 'K03-02'),
(79, 16, 'K04', 'AND', 'K04-02'),
(80, 16, 'K05', 'AND', 'K05-01');

-- --------------------------------------------------------

--
-- Table structure for table `tb_himpunan`
--

CREATE TABLE `tb_himpunan` (
  `kode_himpunan` varchar(16) NOT NULL,
  `kode_kriteria` varchar(16) DEFAULT NULL,
  `nama_himpunan` varchar(255) DEFAULT NULL,
  `n1` double DEFAULT NULL,
  `n2` double DEFAULT NULL,
  `n3` double DEFAULT NULL,
  `n4` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_himpunan`
--

INSERT INTO `tb_himpunan` (`kode_himpunan`, `kode_kriteria`, `nama_himpunan`, `n1`, `n2`, `n3`, `n4`) VALUES
('K01-01', 'K01', 'Kekurangan Gizi', 0, 0, 16, 70),
('K01-02', 'K01', 'Gizi Bertambah', 0, 0, 70, 16),
('K02-01', 'K02', 'Kurang Ideal', 0, 0, 11, 70),
('K02-02', 'K02', 'Bertambah', 0, 0, 70, 11),
('K03-01', 'K03', 'Lambat Berkembang', 0, 0, 11, 70),
('K03-02', 'K03', 'Cepat Berkembang', 0, 0, 70, 11),
('K04-01', 'K04', 'Tidak Layak', 0, 0, 10, 70),
('K04-02', 'K04', 'Layak', 0, 0, 70, 10),
('K05-01', 'K05', 'Akut', 0, 0, 18, 70),
('K05-02', 'K05', 'Kronis', 0, 0, 70, 18);

-- --------------------------------------------------------

--
-- Table structure for table `tb_kriteria`
--

CREATE TABLE `tb_kriteria` (
  `kode_kriteria` varchar(16) NOT NULL,
  `nama_kriteria` varchar(255) DEFAULT NULL,
  `batas_bawah` double DEFAULT NULL,
  `batas_atas` double DEFAULT NULL,
  `dicari` tinyint(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_kriteria`
--

INSERT INTO `tb_kriteria` (`kode_kriteria`, `nama_kriteria`, `batas_bawah`, `batas_atas`, `dicari`) VALUES
('K01', 'Asupan Gizi', 0, 70, 0),
('K02', 'Massa Tubuh (Berat Badan dan Tinggi Badan)', 0, 70, 0),
('K03', 'Perkembangan Fisik (Sensorik, Motorik, dan Kognitif)', 0, 70, 0),
('K04', 'Kualitas MCK', 0, 70, 0),
('K05', 'Status Gejala Pasien', 0, 70, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_rel_alternatif`
--

CREATE TABLE `tb_rel_alternatif` (
  `ID` int(11) NOT NULL,
  `kode_alternatif` varchar(16) DEFAULT NULL,
  `kode_kriteria` varchar(16) DEFAULT NULL,
  `nilai` double DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_rel_alternatif`
--

INSERT INTO `tb_rel_alternatif` (`ID`, `kode_alternatif`, `kode_kriteria`, `nilai`) VALUES
(27, 'A02', 'K04', 20),
(26, 'A02', 'K03', 15),
(25, 'A02', 'K02', 14),
(23, 'A01', 'K05', 0),
(22, 'A01', 'K04', 11),
(21, 'A01', 'K03', 12),
(20, 'A01', 'K02', 12),
(28, 'A02', 'K05', 0),
(24, 'A02', 'K01', 21),
(19, 'A01', 'K01', 19);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD PRIMARY KEY (`user`);

--
-- Indexes for table `tb_alternatif`
--
ALTER TABLE `tb_alternatif`
  ADD PRIMARY KEY (`kode_alternatif`);

--
-- Indexes for table `tb_aturan`
--
ALTER TABLE `tb_aturan`
  ADD PRIMARY KEY (`id_aturan`);

--
-- Indexes for table `tb_himpunan`
--
ALTER TABLE `tb_himpunan`
  ADD PRIMARY KEY (`kode_himpunan`);

--
-- Indexes for table `tb_kriteria`
--
ALTER TABLE `tb_kriteria`
  ADD PRIMARY KEY (`kode_kriteria`);

--
-- Indexes for table `tb_rel_alternatif`
--
ALTER TABLE `tb_rel_alternatif`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_aturan`
--
ALTER TABLE `tb_aturan`
  MODIFY `id_aturan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `tb_rel_alternatif`
--
ALTER TABLE `tb_rel_alternatif`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
