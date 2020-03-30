-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 05, 2020 at 04:39 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `examination`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `createddate` datetime DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  `updateddate` datetime DEFAULT NULL,
  `updatedby` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `createddate`, `createdby`, `updateddate`, `updatedby`) VALUES
(2, 'admin', 'admin', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bobot_nilai_kategori`
--

CREATE TABLE `bobot_nilai_kategori` (
  `id` int(11) NOT NULL,
  `kategori_soal` int(11) NOT NULL,
  `nilai_benar` int(11) DEFAULT NULL,
  `nilai_salah` int(11) DEFAULT NULL,
  `nilai_kosong` int(11) DEFAULT NULL,
  `createddate` date DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  `updateddate` datetime DEFAULT NULL,
  `updatedby` int(11) DEFAULT NULL,
  `deleted` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bobot_nilai_kategori`
--

INSERT INTO `bobot_nilai_kategori` (`id`, `kategori_soal`, `nilai_benar`, `nilai_salah`, `nilai_kosong`, `createddate`, `createdby`, `updateddate`, `updatedby`, `deleted`) VALUES
(1, 16, 5, 0, 0, '2020-01-10', 2, NULL, NULL, 0),
(2, 15, 5, 0, 0, '2020-01-10', 2, NULL, NULL, 0),
(3, 14, 5, 0, 0, '2020-01-10', 2, NULL, NULL, 0),
(4, 13, 4, -1, 0, '2020-01-10', 2, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `guru`
--

CREATE TABLE `guru` (
  `id` int(11) NOT NULL,
  `nama` varchar(150) DEFAULT NULL,
  `nip` varchar(150) DEFAULT NULL,
  `mata_pelajaran` int(11) NOT NULL,
  `password` varchar(45) DEFAULT NULL,
  `createddate` datetime DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  `updateddate` datetime DEFAULT NULL,
  `updatedby` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `guru`
--

INSERT INTO `guru` (`id`, `nama`, `nip`, `mata_pelajaran`, `password`, `createddate`, `createdby`, `updateddate`, `updatedby`) VALUES
(2, 'Januri', '1318033', 5, '1318033', '2018-02-24 20:58:18', 2, '2020-01-03 20:15:30', 2),
(3, 'dodik', '1318033', 3, 'sasuke', '2018-06-08 10:58:07', 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jurusan`
--

CREATE TABLE `jurusan` (
  `id` int(11) NOT NULL,
  `jurusan` varchar(150) DEFAULT NULL,
  `createddate` datetime DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  `updateddate` datetime DEFAULT NULL,
  `updatedby` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jurusan`
--

INSERT INTO `jurusan` (`id`, `jurusan`, `createddate`, `createdby`, `updateddate`, `updatedby`) VALUES
(12, 'Akuntansi', '2018-02-24 22:15:15', 2, NULL, NULL),
(13, 'Pemasaran', '2018-02-27 08:14:13', 2, NULL, NULL),
(14, 'Pariwisata', '2018-02-27 08:14:13', 2, NULL, NULL),
(15, 'Teknik Komputer dan Jaringan', '2018-02-27 08:16:49', 2, NULL, NULL),
(16, ' Multimedia', '2018-02-27 08:16:49', 2, NULL, NULL),
(17, 'Usaha Perjalanan Wisata', '2018-02-27 08:16:49', 2, NULL, NULL),
(18, 'Busana Butik', '2018-02-27 08:16:49', 2, NULL, NULL),
(19, 'Administrasi Perkantoran', '2018-02-27 08:16:49', 2, NULL, NULL),
(20, 'Pemasaran,beni', '2018-02-27 08:31:56', 2, NULL, NULL),
(21, 'Jakarta', '2018-06-08 10:27:11', 2, NULL, NULL),
(22, 'Akuntasi', '2020-02-11 03:05:13', 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kategori_soal`
--

CREATE TABLE `kategori_soal` (
  `id` int(11) NOT NULL,
  `mata_pelajaran` int(11) NOT NULL,
  `kategori` varchar(45) DEFAULT NULL,
  `poin_by` varchar(100) NOT NULL DEFAULT 'SOAL',
  `createddate` datetime DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  `updateddate` datetime DEFAULT NULL,
  `updatedby` int(11) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kategori_soal`
--

INSERT INTO `kategori_soal` (`id`, `mata_pelajaran`, `kategori`, `poin_by`, `createddate`, `createdby`, `updateddate`, `updatedby`, `deleted`) VALUES
(13, 2, 'TPA', 'SOAL', '2018-02-24 21:25:32', 2, '2020-01-10 13:08:28', 2, 0),
(14, 2, 'TBI', 'SOAL', '2018-02-27 08:18:09', 2, '2020-01-10 13:08:35', 2, 0),
(15, 2, 'TWK', 'SOAL', '2018-02-27 08:40:05', 2, '2020-01-10 13:08:43', 2, 0),
(16, 2, 'TKP', 'SOAL', '2018-02-27 08:40:05', 2, '2020-01-10 13:08:52', 2, 0),
(18, 3, 'SAtu', 'SOAL', '2018-06-08 14:20:44', 3, NULL, NULL, 0),
(19, 4, 'kategori', 'SOAL', '2020-01-22 06:18:27', 2, NULL, NULL, 0),
(20, 2, 'TES', 'JAWABAN', '2020-02-02 01:23:41', 2, '2020-02-02 01:24:49', 2, 0),
(21, 5, 'TKP', 'SOAL', '2020-02-07 09:40:10', 2, '2020-03-03 02:06:17', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `kategori_ujian`
--

CREATE TABLE `kategori_ujian` (
  `id` int(11) NOT NULL,
  `kategori_ujian` varchar(150) DEFAULT NULL COMMENT 'Pilihan Ganda\nIsian',
  `createddate` datetime DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  `updateddate` datetime DEFAULT NULL,
  `updatedby` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kategori_ujian`
--

INSERT INTO `kategori_ujian` (`id`, `kategori_ujian`, `createddate`, `createdby`, `updateddate`, `updatedby`) VALUES
(2, 'Pilihan Ganda', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mata_pelajaran`
--

CREATE TABLE `mata_pelajaran` (
  `id` int(11) NOT NULL,
  `mata_pelajaran` varchar(150) DEFAULT NULL,
  `createddate` datetime DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  `updateddate` datetime DEFAULT NULL,
  `updatedby` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mata_pelajaran`
--

INSERT INTO `mata_pelajaran` (`id`, `mata_pelajaran`, `createddate`, `createdby`, `updateddate`, `updatedby`) VALUES
(2, 'Matematika', '2018-02-24 20:58:01', 2, NULL, NULL),
(3, 'Bahasa Inggris', '2018-06-08 10:57:33', 2, NULL, NULL),
(4, 'mapel', '2020-01-22 06:18:27', 2, NULL, NULL),
(5, 'TKP', '2020-02-07 09:40:10', 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

CREATE TABLE `module` (
  `id` int(11) NOT NULL,
  `module` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pengaturan_nilai`
--

CREATE TABLE `pengaturan_nilai` (
  `id` int(11) NOT NULL,
  `show` int(11) DEFAULT '0',
  `updateddate` datetime DEFAULT NULL,
  `updatedby` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pengaturan_nilai`
--

INSERT INTO `pengaturan_nilai` (`id`, `show`, `updateddate`, `updatedby`) VALUES
(2, 1, '2018-06-08 15:40:34', 3);

-- --------------------------------------------------------

--
-- Table structure for table `pengawas_ujian`
--

CREATE TABLE `pengawas_ujian` (
  `id` int(11) NOT NULL,
  `guru` int(11) NOT NULL,
  `createddate` datetime DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  `updateddate` datetime DEFAULT NULL,
  `updatedby` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pengawas_ujian`
--

INSERT INTO `pengawas_ujian` (`id`, `guru`, `createddate`, `createdby`, `updateddate`, `updatedby`) VALUES
(4, 2, '2018-02-24 22:16:41', 2, NULL, NULL),
(5, 3, '2018-06-08 14:17:09', 3, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `peserta_ujian`
--

CREATE TABLE `peserta_ujian` (
  `id` int(11) NOT NULL,
  `ujian` int(11) NOT NULL,
  `siswa` int(11) NOT NULL,
  `nilai` double DEFAULT '0',
  `createddate` datetime DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  `updateddate` datetime DEFAULT NULL,
  `updatedby` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `role_access`
--

CREATE TABLE `role_access` (
  `id` int(11) NOT NULL,
  `guru` int(11) NOT NULL DEFAULT '0',
  `module` int(11) NOT NULL,
  `createddate` datetime DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  `updateddate` datetime DEFAULT NULL,
  `updatedby` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `id` int(11) NOT NULL,
  `nama` varchar(150) DEFAULT NULL,
  `nis` varchar(45) DEFAULT NULL,
  `jurusan` int(11) NOT NULL,
  `kelas` varchar(120) NOT NULL,
  `is_login` int(11) DEFAULT NULL COMMENT 'Status Login Peserta\n\n0 : Sedang Offline\n1 : Sedang Online',
  `password` varchar(45) DEFAULT NULL,
  `createddate` datetime DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  `updateddate` datetime DEFAULT NULL,
  `updatedby` int(11) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id`, `nama`, `nis`, `jurusan`, `kelas`, `is_login`, `password`, `createddate`, `createdby`, `updateddate`, `updatedby`, `deleted`) VALUES
(98, 'Siswa Bibel AE', '200012', 12, '-', 0, '200012*', '2018-02-24 22:15:30', 2, '2020-02-22 04:22:54', 98, 0),
(106, 'AJENG PRATIWI', '06-109-065-8', 17, '', NULL, '065upw', '2018-02-27 08:16:49', 2, NULL, NULL, 0),
(107, 'AJENG SULISTIANA PRATIWI', '06-109-095-2', 18, '', NULL, '095bb', '2018-02-27 08:16:49', 2, NULL, NULL, 0),
(110, 'ADELINA NIA SARI', '06-109-429-4', 13, '', NULL, '429pm', '2018-02-27 08:16:49', 2, '2020-03-05 04:15:51', 2, 1),
(113, 'Beni', '1456', 13, '', 0, 'beni', '2018-02-27 08:32:52', 2, '2020-03-05 04:12:27', 2, 0),
(114, 'Benyamin', '3344', 14, '', NULL, 'bn', '2018-02-27 08:32:52', 2, NULL, NULL, 0),
(115, 'D', '12321', 12, '12', NULL, 'ss', '2018-03-13 13:20:02', 2, NULL, NULL, 0),
(117, 'Beni', '1456', 13, '1', 1, 'beni', '2018-06-08 10:25:07', 2, '2020-02-11 01:55:40', 0, 0),
(118, 'Benyamin', '3344', 14, '2', NULL, 'bn', '2018-06-08 10:25:07', 2, NULL, NULL, 0),
(119, 'BAB I', 'Blitar', 21, 'Apakah Ibu Kota Yordania Itu ?', NULL, 'Bandung', '2018-06-08 10:27:11', 2, NULL, NULL, 0),
(120, 'BAB II', 'Phi/benar', 12, '?? Apa Simbol Ini ?', NULL, 'T', '2018-06-08 10:27:11', 2, NULL, NULL, 0),
(121, 'tejo', '766', 22, '2 A', NULL, '766', '2020-02-11 03:05:13', 2, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `siswa_has_jawaban`
--

CREATE TABLE `siswa_has_jawaban` (
  `id` int(11) NOT NULL,
  `ujian` int(11) NOT NULL,
  `siswa` int(11) NOT NULL,
  `soal` int(11) NOT NULL,
  `soal_has_jawaban` int(11) NOT NULL,
  `status_jawaban` int(11) NOT NULL,
  `createddate` datetime DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  `updateddate` datetime DEFAULT NULL,
  `updatedby` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `siswa_has_jawaban`
--

INSERT INTO `siswa_has_jawaban` (`id`, `ujian`, `siswa`, `soal`, `soal_has_jawaban`, `status_jawaban`, `createddate`, `createdby`, `updateddate`, `updatedby`) VALUES
(40, 14, 98, 45, 339, 1, '2018-03-24 09:58:19', 98, '2018-03-24 09:58:51', 98),
(41, 14, 98, 51, 372, 1, '2018-03-24 09:58:57', 98, NULL, NULL),
(42, 14, 98, 48, 357, 1, '2018-03-24 09:59:04', 98, NULL, NULL),
(43, 14, 98, 47, 350, 1, '2018-03-24 09:59:10', 98, NULL, NULL),
(44, 14, 98, 93, 581, 1, '2018-03-24 09:59:15', 98, NULL, NULL),
(45, 14, 98, 90, 567, 1, '2018-03-24 09:59:19', 98, NULL, NULL),
(46, 14, 98, 96, 591, 1, '2018-03-24 09:59:26', 98, NULL, NULL),
(47, 14, 98, 91, 571, 1, '2018-03-24 09:59:32', 98, NULL, NULL),
(48, 15, 98, 103, 623, 1, '2018-06-07 08:44:47', 98, NULL, NULL),
(49, 16, 98, 108, 643, 1, '2018-06-08 15:03:29', 98, NULL, NULL),
(50, 16, 98, 107, 638, 1, '2018-06-08 15:07:20', 98, NULL, NULL),
(51, 17, 98, 48, 356, 1, '2019-12-02 15:22:33', 98, '2019-12-22 15:24:40', 98),
(52, 17, 98, 46, 343, 1, '2019-12-22 15:22:21', 98, '2019-12-22 15:24:58', 98),
(53, 17, 98, 101, 615, 1, '2019-12-22 15:22:36', 98, NULL, NULL),
(54, 17, 98, 100, 612, 1, '2019-12-22 15:22:43', 98, NULL, NULL),
(55, 17, 98, 106, 637, 1, '2019-12-22 15:22:49', 98, '2019-12-22 15:22:49', 98),
(56, 19, 98, 45, 338, 1, '2020-01-04 04:23:45', 98, NULL, NULL),
(57, 19, 98, 49, 360, 1, '2020-01-04 04:23:47', 98, NULL, NULL),
(58, 19, 98, 103, 625, 1, '2020-01-04 04:23:50', 98, NULL, NULL),
(59, 18, 98, 50, 363, 1, '2020-01-10 15:40:59', 98, NULL, NULL),
(60, 18, 98, 44, 333, 1, '2020-01-10 15:41:02', 98, NULL, NULL),
(61, 18, 98, 109, 649, 1, '2020-01-10 15:41:04', 98, NULL, NULL),
(62, 20, 98, 117, 676, 1, '2020-02-02 03:38:52', 98, NULL, NULL),
(63, 20, 98, 47, 350, 1, '2020-02-02 03:38:57', 98, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `siswa_has_kategori_random_soal`
--

CREATE TABLE `siswa_has_kategori_random_soal` (
  `id` int(11) NOT NULL,
  `siswa` int(11) NOT NULL,
  `ujian` int(11) NOT NULL,
  `kategori_soal` int(11) NOT NULL,
  `soal` int(11) NOT NULL,
  `createddate` datetime DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  `updateddate` datetime DEFAULT NULL,
  `updatedby` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `siswa_has_kategori_random_soal`
--

INSERT INTO `siswa_has_kategori_random_soal` (`id`, `siswa`, `ujian`, `kategori_soal`, `soal`, `createddate`, `createdby`, `updateddate`, `updatedby`) VALUES
(127, 98, 15, 13, 103, '2018-04-09 09:45:28', 98, NULL, NULL),
(128, 98, 16, 18, 108, '2018-06-08 14:50:50', 98, NULL, NULL),
(129, 98, 16, 18, 107, '2018-06-08 14:50:50', 98, NULL, NULL),
(130, 98, 17, 13, 46, '2019-04-28 13:54:01', 98, NULL, NULL),
(131, 98, 17, 13, 48, '2019-04-28 13:54:01', 98, NULL, NULL),
(132, 98, 17, 14, 101, '2019-04-28 13:54:01', 98, NULL, NULL),
(133, 98, 17, 14, 100, '2019-04-28 13:54:01', 98, NULL, NULL),
(134, 98, 17, 14, 106, '2019-04-28 13:54:01', 98, NULL, NULL),
(135, 98, 19, 13, 45, '2020-01-04 04:19:03', 98, NULL, NULL),
(136, 98, 19, 13, 49, '2020-01-04 04:19:03', 98, NULL, NULL),
(137, 98, 19, 13, 103, '2020-01-04 04:19:03', 98, NULL, NULL),
(145, 98, 18, 13, 50, '2020-01-10 15:36:48', 98, NULL, NULL),
(146, 98, 18, 13, 44, '2020-01-10 15:36:48', 98, NULL, NULL),
(147, 98, 18, 13, 109, '2020-01-10 15:36:48', 98, NULL, NULL),
(148, 98, 20, 20, 117, '2020-02-02 03:27:31', 98, NULL, NULL),
(149, 98, 20, 13, 47, '2020-02-02 03:27:31', 98, NULL, NULL),
(150, 98, 22, 21, 132, '2020-02-22 03:56:17', 98, NULL, NULL),
(151, 98, 22, 21, 129, '2020-02-22 03:56:17', 98, NULL, NULL),
(152, 98, 22, 21, 128, '2020-02-22 03:56:17', 98, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `siswa_has_ujian`
--

CREATE TABLE `siswa_has_ujian` (
  `id` int(11) NOT NULL,
  `siswa` int(11) NOT NULL,
  `ujian` int(11) NOT NULL,
  `nilai` double NOT NULL,
  `status` varchar(45) DEFAULT NULL COMMENT 'Menentukan Siswa Sudah Submit Apa Belum\n\n1. Done : Sudah Submit\n2. In Progress : Belum submit',
  `sisa_waktu` int(11) DEFAULT '-1',
  `createddate` datetime DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  `updateddate` datetime DEFAULT NULL,
  `updatedby` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `siswa_has_ujian`
--

INSERT INTO `siswa_has_ujian` (`id`, `siswa`, `ujian`, `nilai`, `status`, `sisa_waktu`, `createddate`, `createdby`, `updateddate`, `updatedby`) VALUES
(110, 98, 12, 100, 'Done', 22, '2018-02-24 22:17:13', 2, '2018-02-24 22:31:02', 98),
(111, 98, 13, 7.6923076923077, 'Done', 28, '2018-03-23 08:12:40', 2, '2018-03-23 09:37:27', 98),
(112, 98, 14, 23.076923076923, 'Done', -1, '2018-03-24 08:18:08', 2, '2018-03-24 10:13:23', 98),
(113, 98, 15, 0, 'Done', -1, '2018-04-09 09:18:07', 2, '2018-06-07 08:44:55', 98),
(114, 98, 16, 100, 'Done', 24, '2018-06-08 14:37:35', 3, '2018-06-08 15:24:39', 98),
(115, 98, 17, 0, 'Done', 38, '2019-04-28 13:43:33', 2, '2019-12-22 15:34:32', 98),
(117, 98, 18, 7, 'Done', 59, '2019-12-23 15:05:50', 2, '2020-01-10 15:41:11', 98),
(119, 115, 18, 0, 'In Progress', -1, '2019-12-23 15:05:50', 2, NULL, NULL),
(120, 98, 19, 0, 'Done', 56, '2020-01-03 20:57:39', 2, '2020-01-04 04:24:23', 98),
(121, 98, 21, 0, 'In Progress', -1, '2020-01-22 06:31:01', 2, NULL, NULL),
(122, 98, 20, 4, 'Done', 48, '2020-02-02 01:54:16', 2, '2020-02-02 03:44:52', 98),
(123, 98, 22, 0, 'In Progress', 89, '2020-02-22 03:53:35', 2, '2020-02-22 10:22:22', 98);

-- --------------------------------------------------------

--
-- Table structure for table `soal`
--

CREATE TABLE `soal` (
  `id` int(11) NOT NULL,
  `kategori_soal` int(11) NOT NULL,
  `type_soal` int(11) NOT NULL DEFAULT '1',
  `soal` longtext,
  `file_soal` longtext,
  `createddate` datetime DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  `updateddate` datetime DEFAULT NULL,
  `updatedby` int(11) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `soal`
--

INSERT INTO `soal` (`id`, `kategori_soal`, `type_soal`, `soal`, `file_soal`, `createddate`, `createdby`, `updateddate`, `updatedby`, `deleted`) VALUES
(44, 13, 3, '<p>ibu kota jawa timur</p>', NULL, '2018-02-24 21:26:23', 2, NULL, NULL, 0),
(45, 13, 3, '<p>saeqdew</p>', NULL, '2018-02-24 21:34:40', 2, NULL, NULL, 0),
(46, 13, 3, '<p>masdhajdhkajsd</p>', NULL, '2018-02-24 21:35:17', 2, NULL, NULL, 0),
(47, 13, 3, '<p>x</p>', NULL, '2018-02-24 21:36:04', 2, NULL, NULL, 0),
(48, 13, 3, '<p>aSDADASDAD</p>', NULL, '2018-02-24 21:37:52', 2, NULL, NULL, 0),
(49, 13, 3, '<p>sajhdkashjdk</p>', NULL, '2018-02-24 21:41:29', 2, NULL, NULL, 0),
(50, 13, 3, '<p>sda</p>', NULL, '2018-02-24 21:50:52', 2, NULL, NULL, 0),
(51, 13, 1, '<p>ssss</p>', NULL, '2018-02-24 21:55:29', 2, '2018-02-28 10:15:17', 2, 0),
(90, 15, 1, 'Apakah Ibu Kota Yordania Itu ?', NULL, '2018-02-27 08:40:05', 2, NULL, NULL, 0),
(91, 16, 1, '?? Apa Simbol Ini ?', NULL, '2018-02-27 08:40:05', 2, NULL, NULL, 0),
(92, 14, 1, '\"Jarak sebenarnya antara kota A dan B adalah 120 km. Jika digambarkan pada peta yang berskala 1 : 2.000.000, maka jarak antara kota A dan kota B pada peta adalah ?\"', NULL, '2018-02-27 08:43:52', 2, NULL, NULL, 0),
(93, 14, 1, '\"Ana baru saja belanja sepatu di toko yang tertera discount 15%. Jika Ana harus membayar Rp. 212.500,00. Maka harga sepatu sebenarnya di toko itu adalah?...\"', NULL, '2018-02-27 08:43:52', 2, NULL, NULL, 0),
(94, 14, 1, '<p><math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mn>2</mn><mroot><mn>2</mn><mn>2</mn></mroot></math></p>', NULL, '2018-02-28 10:18:05', 2, NULL, NULL, 0);
INSERT INTO `soal` (`id`, `kategori_soal`, `type_soal`, `soal`, `file_soal`, `createddate`, `createdby`, `updateddate`, `updatedby`, `deleted`) VALUES
(96, 15, 1, '<p><img title=\"pp.jpg\" src=\"data:image/jpeg;base64,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\" alt=\"\" width=\"200\" height=\"200\" /> Gambar Apoa Ini ?</p>', NULL, '2018-03-01 08:42:44', 2, NULL, NULL, 0);
INSERT INTO `soal` (`id`, `kategori_soal`, `type_soal`, `soal`, `file_soal`, `createddate`, `createdby`, `updateddate`, `updatedby`, `deleted`) VALUES
(97, 14, 1, 'Jarak sebenarnya antara kota A dan B adalah 120 km. Jika digambarkan pada peta yang berskala 1 : 2.000.000, maka jarak antara kota A dan kota B pada peta adalah ?', NULL, '2018-03-01 12:43:54', 2, NULL, NULL, 0),
(98, 14, 1, 'Ana baru saja belanja sepatu di toko yang tertera discount 15%. Jika Ana harus membayar Rp. 212.500,00. Maka harga sepatu sebenarnya di toko itu adalah?...', NULL, '2018-03-01 12:43:54', 2, NULL, NULL, 0),
(99, 14, 1, 'Jika dari log 3 = x dan log 4 = y maka nilai dari log 360 = ...', NULL, '2018-03-01 12:43:54', 2, NULL, NULL, 0),
(100, 14, 1, 'Nilai 2xy pada system persamaan Linier  x ? 2y = 4 dan 2x + y = 3  adalah?', NULL, '2018-03-01 12:43:54', 2, NULL, NULL, 0),
(101, 14, 1, 'Harga  3 buah buku dan  2 penggaris  Rp.9.000,00. Jika harga sebuah buku Rp.500,00  lebih mahal dari harga sebuah penggaris, maka harga sebuah buku dan 3 buah penggaris adalah  . . . .', NULL, '2018-03-01 12:43:54', 2, NULL, NULL, 0),
(103, 13, 1, '<p><math xmlns=\"http://www.w3.org/1998/Math/MathML\"><msup><mn>2</mn><mn>2</mn></msup></math> ?</p>', NULL, '2018-03-03 08:26:29', 2, NULL, NULL, 0),
(104, 13, 1, '<p>coba1</p>', NULL, '2018-06-08 08:28:57', 2, NULL, NULL, 0),
(106, 14, 1, '<p>asa</p>', 'download.png', '2018-06-08 08:31:38', 2, NULL, NULL, 0),
(107, 18, 1, '<p>Ibu kota Jawa Timur ?</p>', NULL, '2018-06-08 14:21:25', 3, NULL, NULL, 0),
(108, 18, 1, '<p>Ibu Kota Jawa Tengah ?</p>', NULL, '2018-06-08 14:22:08', 3, NULL, NULL, 0),
(109, 13, 1, '<p>sadasda</p>', NULL, '2020-01-10 14:34:52', 2, NULL, NULL, 0),
(111, 13, 1, '<p>sadasda???</p>', NULL, '2020-01-10 15:01:20', 2, '2020-01-10 15:08:24', 2, 0),
(114, 13, 1, '<p>ibu kota jawa timur ?</p>', NULL, '2020-01-22 06:11:32', 2, NULL, NULL, 0),
(115, 19, 1, 'soal', NULL, '2020-01-22 06:18:27', 2, NULL, NULL, 0),
(116, 13, 1, 'nama sekolah surabaya ?', NULL, '2020-01-22 06:18:27', 2, NULL, NULL, 0),
(117, 20, 1, '<p>oke siappp bro?</p>', NULL, '2020-02-02 01:34:24', 2, NULL, NULL, 0),
(128, 21, 1, 'INI MASI PERCOBAAN?', NULL, '2020-02-07 09:53:21', 2, '2020-03-05 04:00:44', 2, 1),
(129, 21, 1, 'INI MASI PERCOBAAN BESOK UJIAN?', NULL, '2020-02-07 09:53:22', 2, '2020-03-05 04:00:44', 2, 1),
(130, 21, 1, '<p>INI MASI PERCOBAAN LANCAR UJIAN?</p>', NULL, '2020-02-07 09:53:22', 2, '2020-03-05 04:00:44', 2, 1),
(131, 21, 1, 'INI MASI PERCOBAAN TEMENAN?', NULL, '2020-02-07 09:53:22', 2, '2020-02-11 02:08:27', 2, 1),
(132, 21, 1, 'INI MASI PERCOBAAN YA?', NULL, '2020-02-07 09:53:22', 2, '2020-02-11 02:06:45', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `soal_has_jawaban`
--

CREATE TABLE `soal_has_jawaban` (
  `id` int(11) NOT NULL,
  `soal` int(11) NOT NULL,
  `jawaban` longtext,
  `file_jawaban` longtext,
  `true_or_false` int(11) DEFAULT NULL COMMENT 'Keterangan Jawaban Benar atau Salah\n0: salah\n1: benar',
  `poin` int(11) NOT NULL DEFAULT '0',
  `createddate` datetime DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  `updateddate` datetime DEFAULT NULL,
  `updatedby` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `soal_has_jawaban`
--

INSERT INTO `soal_has_jawaban` (`id`, `soal`, `jawaban`, `file_jawaban`, `true_or_false`, `poin`, `createddate`, `createdby`, `updateddate`, `updatedby`) VALUES
(333, 44, 'Surabaya', '', 1, 0, '2018-02-24 21:26:23', 2, NULL, NULL),
(334, 44, 'asd', '', 0, 0, '2018-02-24 21:26:23', 2, NULL, NULL),
(335, 44, 'sadasd', '', 0, 0, '2018-02-24 21:26:23', 2, NULL, NULL),
(336, 44, 'asdasd', '', 0, 0, '2018-02-24 21:26:23', 2, NULL, NULL),
(337, 44, 'sdfsf', '', 0, 0, '2018-02-24 21:26:23', 2, NULL, NULL),
(338, 45, 'asdasdas', '', 0, 0, '2018-02-24 21:34:40', 2, NULL, NULL),
(339, 45, 'dsfsfsdf', '', 0, 0, '2018-02-24 21:34:40', 2, NULL, NULL),
(340, 45, 'sdfsdfsdf', '', 0, 0, '2018-02-24 21:34:40', 2, NULL, NULL),
(341, 45, 'jhkyukh', '', 1, 0, '2018-02-24 21:34:40', 2, NULL, NULL),
(342, 45, 'jhkjkjh', '', 0, 0, '2018-02-24 21:34:40', 2, NULL, NULL),
(343, 46, 'asjhdkasdh', '', 0, 0, '2018-02-24 21:35:17', 2, NULL, NULL),
(344, 46, 'ajshd', '', 0, 0, '2018-02-24 21:35:17', 2, NULL, NULL),
(345, 46, 'ajhsdkjadhaks', '', 0, 0, '2018-02-24 21:35:17', 2, NULL, NULL),
(346, 46, 'sjkdhksf', '', 0, 0, '2018-02-24 21:35:17', 2, NULL, NULL),
(347, 46, 'sdsdf', '', 1, 0, '2018-02-24 21:35:17', 2, NULL, NULL),
(348, 47, 's', '', 0, 0, '2018-02-24 21:36:04', 2, NULL, NULL),
(349, 47, 's', '', 0, 0, '2018-02-24 21:36:04', 2, NULL, NULL),
(350, 47, 's', '', 0, 0, '2018-02-24 21:36:04', 2, NULL, NULL),
(351, 47, 's', '', 1, 0, '2018-02-24 21:36:04', 2, NULL, NULL),
(352, 47, 'sss', '', 0, 0, '2018-02-24 21:36:04', 2, NULL, NULL),
(353, 48, 'S', '', 0, 0, '2018-02-24 21:37:52', 2, NULL, NULL),
(354, 48, 'EWE', '', 0, 0, '2018-02-24 21:37:52', 2, NULL, NULL),
(355, 48, 'DSDAD', '', 0, 0, '2018-02-24 21:37:52', 2, NULL, NULL),
(356, 48, 'DADASD', '', 0, 0, '2018-02-24 21:37:52', 2, NULL, NULL),
(357, 48, 'ASDAD', '', 1, 0, '2018-02-24 21:37:52', 2, NULL, NULL),
(358, 49, 's', '', 0, 0, '2018-02-24 21:41:29', 2, NULL, NULL),
(359, 49, 's', '', 0, 0, '2018-02-24 21:41:29', 2, NULL, NULL),
(360, 49, 's', '', 0, 0, '2018-02-24 21:41:29', 2, NULL, NULL),
(361, 49, 's', '', 1, 0, '2018-02-24 21:41:29', 2, NULL, NULL),
(362, 49, 's', '', 0, 0, '2018-02-24 21:41:29', 2, NULL, NULL),
(363, 50, '21', '', 0, 0, '2018-02-24 21:50:52', 2, NULL, NULL),
(364, 50, 'asdasd', '', 0, 0, '2018-02-24 21:50:52', 2, NULL, NULL),
(365, 50, 'asdasd', '', 0, 0, '2018-02-24 21:50:52', 2, NULL, NULL),
(366, 50, 'wdda', '', 0, 0, '2018-02-24 21:50:52', 2, NULL, NULL),
(367, 50, 'zdada', '', 1, 0, '2018-02-24 21:50:52', 2, NULL, NULL),
(368, 51, 'sasdda', '', 0, 0, '2018-02-24 21:55:29', 2, '2018-02-28 10:15:17', 2),
(369, 51, 'asda', '', 0, 0, '2018-02-24 21:55:29', 2, '2018-02-28 10:15:17', 2),
(370, 51, 'xs', '', 0, 0, '2018-02-24 21:55:29', 2, '2018-02-28 10:15:17', 2),
(371, 51, 'sds', '', 0, 0, '2018-02-24 21:55:29', 2, '2018-02-28 10:15:17', 2),
(372, 51, 'sd', '', 1, 0, '2018-02-24 21:55:29', 2, '2018-02-28 10:15:17', 2),
(563, 90, 'Blitar', NULL, 0, 0, '2018-02-27 08:40:05', 2, NULL, NULL),
(564, 90, 'Jakarta', NULL, 0, 0, '2018-02-27 08:40:05', 2, NULL, NULL),
(565, 90, 'Bandung', NULL, 0, 0, '2018-02-27 08:40:05', 2, NULL, NULL),
(566, 90, 'Surabaya', NULL, 0, 0, '2018-02-27 08:40:05', 2, NULL, NULL),
(567, 90, 'Malang', NULL, 1, 0, '2018-02-27 08:40:05', 2, NULL, NULL),
(568, 91, 'Phi', NULL, 1, 0, '2018-02-27 08:40:05', 2, NULL, NULL),
(569, 91, 'U', NULL, 0, 0, '2018-02-27 08:40:05', 2, NULL, NULL),
(570, 91, 'T', NULL, 0, 0, '2018-02-27 08:40:05', 2, NULL, NULL),
(571, 91, 'S', NULL, 0, 0, '2018-02-27 08:40:05', 2, NULL, NULL),
(572, 91, 'K', NULL, 0, 0, '2018-02-27 08:40:05', 2, NULL, NULL),
(573, 92, '12 cm', NULL, 1, 0, '2018-02-27 08:43:52', 2, NULL, NULL),
(574, 92, '8 cm ', NULL, 0, 0, '2018-02-27 08:43:52', 2, NULL, NULL),
(575, 92, '6 cm ', NULL, 0, 0, '2018-02-27 08:43:52', 2, NULL, NULL),
(576, 92, '\"1,2 cm\"', NULL, 0, 0, '2018-02-27 08:43:52', 2, NULL, NULL),
(577, 92, '36 km', NULL, 0, 0, '2018-02-27 08:43:52', 2, NULL, NULL),
(578, 93, '\"Rp. 250.000,00\"', NULL, 0, 0, '2018-02-27 08:43:52', 2, NULL, NULL),
(579, 93, '\"Rp. 260.000,00\"', NULL, 0, 0, '2018-02-27 08:43:52', 2, NULL, NULL),
(580, 93, '\"Rp.275.000,00\"', NULL, 0, 0, '2018-02-27 08:43:52', 2, NULL, NULL),
(581, 93, '\"Rp.245.000,00 \"', NULL, 0, 0, '2018-02-27 08:43:52', 2, NULL, NULL),
(582, 93, '\"Rp.300.000,00\"', NULL, 1, 0, '2018-02-27 08:43:52', 2, NULL, NULL),
(583, 94, 's', '', 0, 0, '2018-02-28 10:18:05', 2, NULL, NULL),
(584, 94, 'asd', '', 0, 0, '2018-02-28 10:18:05', 2, NULL, NULL),
(585, 94, 'asd', '', 0, 0, '2018-02-28 10:18:05', 2, NULL, NULL),
(586, 94, 'asd', '', 0, 0, '2018-02-28 10:18:05', 2, NULL, NULL),
(587, 94, 'asdad', '', 1, 0, '2018-02-28 10:18:05', 2, NULL, NULL),
(588, 96, 'asd', '', 0, 0, '2018-03-01 08:42:44', 2, NULL, NULL),
(589, 96, 'asd', '', 0, 0, '2018-03-01 08:42:44', 2, NULL, NULL),
(590, 96, 'as', '', 0, 0, '2018-03-01 08:42:44', 2, NULL, NULL),
(591, 96, 'asd', '', 0, 0, '2018-03-01 08:42:44', 2, NULL, NULL),
(592, 96, 'asd', '', 1, 0, '2018-03-01 08:42:44', 2, NULL, NULL),
(593, 97, '12 cm', NULL, 1, 0, '2018-03-01 12:43:54', 2, NULL, NULL),
(594, 97, '8 cm ', NULL, 0, 0, '2018-03-01 12:43:54', 2, NULL, NULL),
(595, 97, '6 cm ', NULL, 0, 0, '2018-03-01 12:43:54', 2, NULL, NULL),
(596, 97, '1,2 cm', NULL, 0, 0, '2018-03-01 12:43:54', 2, NULL, NULL),
(597, 97, '36 km', NULL, 0, 0, '2018-03-01 12:43:54', 2, NULL, NULL),
(598, 98, 'Rp. 250.000,00', NULL, 0, 0, '2018-03-01 12:43:54', 2, NULL, NULL),
(599, 98, 'Rp. 260.000,00', NULL, 0, 0, '2018-03-01 12:43:54', 2, NULL, NULL),
(600, 98, 'Rp.275.000,00', NULL, 0, 0, '2018-03-01 12:43:54', 2, NULL, NULL),
(601, 98, 'Rp.245.000,00 ', NULL, 0, 0, '2018-03-01 12:43:54', 2, NULL, NULL),
(602, 98, 'Rp.300.000,00', NULL, 1, 0, '2018-03-01 12:43:54', 2, NULL, NULL),
(603, 99, '2x+y', NULL, 0, 0, '2018-03-01 12:43:54', 2, NULL, NULL),
(604, 99, '2x+y+1', NULL, 0, 0, '2018-03-01 12:43:54', 2, NULL, NULL),
(605, 99, '2x-y', NULL, 0, 0, '2018-03-01 12:43:54', 2, NULL, NULL),
(606, 99, '2x-y-1', NULL, 1, 0, '2018-03-01 12:43:54', 2, NULL, NULL),
(607, 99, '2x+y-1', NULL, 0, 0, '2018-03-01 12:43:54', 2, NULL, NULL),
(608, 100, '-4', NULL, 0, 0, '2018-03-01 12:43:54', 2, NULL, NULL),
(609, 100, '-2', NULL, 0, 0, '2018-03-01 12:43:54', 2, NULL, NULL),
(610, 100, '2', NULL, 0, 0, '2018-03-01 12:43:54', 2, NULL, NULL),
(611, 100, '4', NULL, 1, 0, '2018-03-01 12:43:54', 2, NULL, NULL),
(612, 100, '6', NULL, 0, 0, '2018-03-01 12:43:54', 2, NULL, NULL),
(613, 101, 'Rp. 6.500,00', NULL, 0, 0, '2018-03-01 12:43:54', 2, NULL, NULL),
(614, 101, 'Rp. 7.000,00', NULL, 0, 0, '2018-03-01 12:43:54', 2, NULL, NULL),
(615, 101, 'Rp. 8.000,00', NULL, 1, 0, '2018-03-01 12:43:54', 2, NULL, NULL),
(616, 101, 'Rp. 8.500,00', NULL, 0, 0, '2018-03-01 12:43:54', 2, NULL, NULL),
(617, 101, 'Rp. 9.000,00', NULL, 0, 0, '2018-03-01 12:43:54', 2, NULL, NULL),
(623, 103, '<p><math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mfenced open=\"{\" close=\"}\"><mn>4</mn></mfenced></math></p>', '', 0, 0, '2018-03-03 08:26:29', 2, NULL, NULL),
(624, 103, '<p><math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mfenced open=\"{\" close=\"}\"><mn>22</mn></mfenced></math></p>', '', 0, 0, '2018-03-03 08:26:29', 2, NULL, NULL),
(625, 103, '<p><math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mfrac><mn>2</mn><mn>2</mn></mfrac></math></p>', '', 0, 0, '2018-03-03 08:26:29', 2, NULL, NULL),
(626, 103, '<p><math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mfenced><mn>23</mn></mfenced></math></p>', '', 0, 0, '2018-03-03 08:26:29', 2, NULL, NULL),
(627, 103, '<p><math xmlns=\"http://www.w3.org/1998/Math/MathML\"><mfenced open=\"|\" close=\"|\"><mn>2</mn></mfenced></math></p>', '', 1, 0, '2018-03-03 08:26:29', 2, NULL, NULL),
(628, 104, '<p>jawab 1</p>', '', 0, 0, '2018-06-08 08:28:57', 2, NULL, NULL),
(629, 104, '<p>jawab 2</p>', '', 0, 0, '2018-06-08 08:28:57', 2, NULL, NULL),
(630, 104, '<p>jawab 3</p>', '', 0, 0, '2018-06-08 08:28:57', 2, NULL, NULL),
(631, 104, '<p>jawab 4</p>', '', 0, 0, '2018-06-08 08:28:57', 2, NULL, NULL),
(632, 104, '<p>jawab 5</p>', '', 1, 0, '2018-06-08 08:28:57', 2, NULL, NULL),
(633, 106, '<p>as</p>', 'Dikopikan.png', 1, 0, '2018-06-08 08:31:38', 2, NULL, NULL),
(634, 106, '<p>asdasda</p>', '', 0, 0, '2018-06-08 08:31:38', 2, NULL, NULL),
(635, 106, '<p>asdads</p>', '', 0, 0, '2018-06-08 08:31:38', 2, NULL, NULL),
(636, 106, '<p>aa</p>', '', 0, 0, '2018-06-08 08:31:38', 2, NULL, NULL),
(637, 106, '<p>asdad</p>', '', 0, 0, '2018-06-08 08:31:38', 2, NULL, NULL),
(638, 107, '<p>Surabaya</p>', '', 1, 0, '2018-06-08 14:21:25', 3, NULL, NULL),
(639, 107, '<p>Malang</p>', '', 0, 0, '2018-06-08 14:21:25', 3, NULL, NULL),
(640, 107, '<p>Blitar</p>', '', 0, 0, '2018-06-08 14:21:25', 3, NULL, NULL),
(641, 107, '<p>Jember</p>', '', 0, 0, '2018-06-08 14:21:25', 3, NULL, NULL),
(642, 107, '<p>Kediri</p>', '', 0, 0, '2018-06-08 14:21:25', 3, NULL, NULL),
(643, 108, '<p>Solo</p>', '', 1, 0, '2018-06-08 14:22:08', 3, NULL, NULL),
(644, 108, '<p>Pnorogo</p>', '', 0, 0, '2018-06-08 14:22:08', 3, NULL, NULL),
(645, 108, '<p>Kediri</p>', '', 0, 0, '2018-06-08 14:22:08', 3, NULL, NULL),
(646, 108, '<p>Malang</p>', '', 0, 0, '2018-06-08 14:22:08', 3, NULL, NULL),
(647, 108, '<p>Surabaya</p>', '', 0, 0, '2018-06-08 14:22:08', 3, NULL, NULL),
(648, 109, '<p>asdasdasd</p>', NULL, 0, 0, '2020-01-10 14:34:52', 2, NULL, NULL),
(649, 109, '<p>asdad</p>', NULL, 1, 0, '2020-01-10 14:34:52', 2, NULL, NULL),
(650, 109, '<p>sadad</p>', NULL, 0, 0, '2020-01-10 14:34:52', 2, NULL, NULL),
(654, 111, '<p>asdasdasd1</p>', NULL, 0, 0, '2020-01-10 15:01:20', 2, '2020-01-10 15:08:24', 2),
(655, 111, '<p>asdad2</p>', NULL, 1, 0, '2020-01-10 15:01:20', 2, '2020-01-10 15:08:24', 2),
(656, 111, '<p>sadad3</p>', NULL, 0, 0, '2020-01-10 15:01:20', 2, '2020-01-10 15:08:24', 2),
(657, 111, '<p>aajjj</p>', NULL, 0, 0, '2020-01-10 15:01:20', 2, '2020-01-10 15:08:24', 2),
(666, 114, '<p>surabyaa</p>', NULL, 0, 0, '2020-01-22 06:11:32', 2, NULL, NULL),
(667, 114, '<p>solo</p>', NULL, 0, 0, '2020-01-22 06:11:32', 2, NULL, NULL),
(668, 114, '<p>bandung</p>', NULL, 0, 0, '2020-01-22 06:11:32', 2, NULL, NULL),
(669, 115, 'keterangan', NULL, 0, 0, '2020-01-22 06:18:27', 2, NULL, NULL),
(670, 116, 'SD SBY', NULL, 0, 0, '2020-01-22 06:18:27', 2, NULL, NULL),
(671, 116, 'SD JKT', NULL, 0, 0, '2020-01-22 06:18:27', 2, NULL, NULL),
(672, 116, 'SD NBM', NULL, 1, 0, '2020-01-22 06:18:27', 2, NULL, NULL),
(673, 116, 'SD II', NULL, 0, 0, '2020-01-22 06:18:27', 2, NULL, NULL),
(674, 116, 'SD 88', NULL, 0, 0, '2020-01-22 06:18:27', 2, NULL, NULL),
(675, 117, '<p>yoi mamen</p>', NULL, 0, 0, '2020-02-02 01:34:24', 2, NULL, NULL),
(676, 117, '<p>oke mamen</p>', NULL, 0, 5, '2020-02-02 01:34:24', 2, NULL, NULL),
(727, 128, 'IWAK LELE', NULL, 0, 3, '2020-02-07 09:53:21', 2, NULL, NULL),
(728, 128, 'IWAK BAWAL', NULL, 0, 3, '2020-02-07 09:53:21', 2, NULL, NULL),
(729, 128, 'IWAK indosiar', NULL, 0, 3, '2020-02-07 09:53:21', 2, NULL, NULL),
(730, 128, 'IWAK GATHUL', NULL, 0, 3, '2020-02-07 09:53:21', 2, NULL, NULL),
(731, 128, 'IWAK SEPAT', NULL, 0, 3, '2020-02-07 09:53:21', 2, NULL, NULL),
(732, 129, 'IWAK LELE', NULL, 0, 4, '2020-02-07 09:53:22', 2, NULL, NULL),
(733, 129, 'IWAK BAWAL', NULL, 0, 4, '2020-02-07 09:53:22', 2, NULL, NULL),
(734, 129, 'IWAK indosiar', NULL, 0, 4, '2020-02-07 09:53:22', 2, NULL, NULL),
(735, 129, 'IWAK GATHUL', NULL, 0, 4, '2020-02-07 09:53:22', 2, NULL, NULL),
(736, 129, 'IWAK SEPAT', NULL, 0, 4, '2020-02-07 09:53:22', 2, NULL, NULL),
(737, 130, '<p>IWAK LELE</p>', NULL, 0, 3, '2020-02-07 09:53:22', 2, '2020-02-14 14:33:55', 2),
(738, 130, '<p>IWAK BAWAL</p>', NULL, 1, 2, '2020-02-07 09:53:22', 2, '2020-02-14 14:33:55', 2),
(739, 130, '<p>IWAK indosiar</p>', NULL, 0, 3, '2020-02-07 09:53:22', 2, '2020-02-14 14:33:55', 2),
(740, 130, '<p>IWAK GATHUL</p>', NULL, 0, 3, '2020-02-07 09:53:22', 2, '2020-02-14 14:33:55', 2),
(741, 130, '<p>IWAK SEPAT</p>', NULL, 0, 3, '2020-02-07 09:53:22', 2, '2020-02-14 14:33:55', 2),
(742, 131, 'IWAK LELE', NULL, 0, 4, '2020-02-07 09:53:22', 2, NULL, NULL),
(743, 131, 'IWAK BAWAL', NULL, 0, 4, '2020-02-07 09:53:22', 2, NULL, NULL),
(744, 131, 'IWAK indosiar', NULL, 0, 4, '2020-02-07 09:53:22', 2, NULL, NULL),
(745, 131, 'IWAK GATHUL', NULL, 0, 4, '2020-02-07 09:53:22', 2, NULL, NULL),
(746, 131, 'IWAK SEPAT', NULL, 0, 4, '2020-02-07 09:53:22', 2, NULL, NULL),
(747, 132, 'IWAK LELE', NULL, 0, 2, '2020-02-07 09:53:22', 2, NULL, NULL),
(748, 132, 'IWAK BAWAL', NULL, 0, 2, '2020-02-07 09:53:22', 2, NULL, NULL),
(749, 132, 'IWAK indosiar', NULL, 0, 2, '2020-02-07 09:53:22', 2, NULL, NULL),
(750, 132, 'IWAK GATHUL', NULL, 0, 2, '2020-02-07 09:53:22', 2, NULL, NULL),
(751, 132, 'IWAK SEPAT', NULL, 0, 2, '2020-02-07 09:53:22', 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `start_ujian`
--

CREATE TABLE `start_ujian` (
  `id` int(11) NOT NULL,
  `time_limit` int(11) NOT NULL,
  `ujian` int(11) NOT NULL,
  `status` int(11) DEFAULT NULL COMMENT 'Status Untuk memulai ujian atau menghentikan ujian\n0 : Ujian Stop\n1 : Ujian Dimulai',
  `createddate` datetime DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  `updateddate` datetime DEFAULT NULL,
  `updatedby` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `start_ujian`
--

INSERT INTO `start_ujian` (`id`, `time_limit`, `ujian`, `status`, `createddate`, `createdby`, `updateddate`, `updatedby`) VALUES
(11, 9, 12, 0, '2018-02-24 22:17:21', 2, '2018-02-24 22:31:02', 98),
(12, 9, 13, 0, '2018-03-23 08:13:00', 2, '2018-03-23 09:37:27', 98),
(13, 9, 14, 0, '2018-03-24 08:18:19', 2, '2018-03-24 10:13:23', 98),
(14, 9, 15, 0, '2018-04-09 09:18:18', 2, '2018-06-07 08:44:55', 98),
(15, 9, 16, 0, '2018-06-08 14:37:48', 3, '2018-06-08 15:24:37', 98),
(16, 8, 17, 1, '2019-04-28 13:43:52', 2, '2019-04-28 13:44:47', 2),
(17, 8, 18, 1, '2019-12-23 15:08:33', 2, '2019-12-23 15:17:13', 2),
(18, 8, 19, 0, '2020-01-03 21:00:58', 2, '2020-01-04 04:24:23', 98),
(19, 10, 21, 1, '2020-01-22 06:32:27', 2, '2020-01-22 06:35:09', 2),
(20, 8, 20, 0, '2020-02-02 01:54:25', 2, '2020-02-02 03:44:52', 98),
(21, 11, 22, 1, '2020-02-22 03:53:43', 2, '2020-02-22 03:54:14', 2);

-- --------------------------------------------------------

--
-- Table structure for table `status_jawaban`
--

CREATE TABLE `status_jawaban` (
  `id` int(11) NOT NULL,
  `status` varchar(45) DEFAULT NULL COMMENT 'R : Ragu Ragu\nY : Yakin'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `status_jawaban`
--

INSERT INTO `status_jawaban` (`id`, `status`) VALUES
(1, 'Y'),
(2, 'R');

-- --------------------------------------------------------

--
-- Table structure for table `time_limit`
--

CREATE TABLE `time_limit` (
  `id` int(11) NOT NULL,
  `time_limit` int(11) DEFAULT NULL,
  `createddate` datetime DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  `updateddate` datetime DEFAULT NULL,
  `updatedby` int(11) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `time_limit`
--

INSERT INTO `time_limit` (`id`, `time_limit`, `createddate`, `createdby`, `updateddate`, `updatedby`, `deleted`) VALUES
(8, 60, '2018-02-24 20:57:35', 2, NULL, NULL, 0),
(9, 30, '2018-02-24 20:58:28', 2, NULL, NULL, 0),
(10, 15, '2020-01-22 06:32:17', 2, NULL, NULL, 0),
(11, 90, '2020-02-22 03:52:25', 2, NULL, NULL, 0),
(12, 180, '2020-02-22 03:52:34', 2, '2020-03-03 13:38:49', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `type_soal`
--

CREATE TABLE `type_soal` (
  `id` int(11) NOT NULL,
  `type` varchar(45) DEFAULT NULL COMMENT 'L: Listeining\nS: Standard'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `type_soal`
--

INSERT INTO `type_soal` (`id`, `type`) VALUES
(1, 'S'),
(2, 'L');

-- --------------------------------------------------------

--
-- Table structure for table `ujian`
--

CREATE TABLE `ujian` (
  `id` int(11) NOT NULL,
  `nama_ujian` varchar(150) DEFAULT NULL,
  `kode_ujian` varchar(45) DEFAULT NULL,
  `token` varchar(50) NOT NULL,
  `guru` int(11) NOT NULL,
  `kategori_ujian` int(11) NOT NULL,
  `tanggal_ujian` date DEFAULT NULL,
  `waktu_ujian` varchar(45) DEFAULT NULL,
  `createddate` datetime DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  `updateddate` datetime DEFAULT NULL,
  `updatedby` int(11) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL COMMENT 'Untuk Mengeset status bahwa ujian ini sudah selesai, belum dilaksanakan,\n1. Done : Selesai\n2. New: Belum Dilaksanakan\n3. In Progreess: Sedang Dilaksanakan',
  `deleted` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ujian`
--

INSERT INTO `ujian` (`id`, `nama_ujian`, `kode_ujian`, `token`, `guru`, `kategori_ujian`, `tanggal_ujian`, `waktu_ujian`, `createddate`, `createdby`, `updateddate`, `updatedby`, `status`, `deleted`) VALUES
(12, 'a', 'U24022018001', '', 2, 2, '2018-02-24', '05:00', '2018-02-24 22:16:41', 2, '2020-02-11 02:12:28', 2, 'Done', 1),
(13, 'Tes 2', 'U23032018001', '', 2, 2, '2018-03-23', '08:00', '2018-03-23 08:09:22', 2, '2020-02-11 02:16:06', 2, 'Done', 1),
(14, 'tes 3', 'U24032018001', '', 2, 2, '2018-03-24', '08:00', '2018-03-24 08:17:12', 2, '2018-03-24 10:13:23', 98, 'Done', 0),
(15, 'sdfdsf', 'U09042018001', 'gp7vn', 2, 2, '2018-04-10', '08:00', '2018-04-09 09:13:26', 2, '2018-06-07 08:44:55', 98, 'Done', 0),
(16, 'Ujian Coba', 'U08062018001', 'pgbm0', 3, 2, '2018-06-08', '14:30', '2018-06-08 14:17:09', 3, '2018-06-08 15:24:37', 98, 'Done', 0),
(17, 'Ujian Matematika', 'U28042019001', '0renh', 2, 2, '2019-04-30', '08:00', '2019-04-28 13:39:35', 2, '2019-04-28 13:44:47', 2, 'In Progress', 0),
(18, 'Ujian Matematika ', 'U22112019001', '0g5yo', 2, 2, '2020-01-10', '15:20', '2019-11-22 14:16:52', 2, '2019-12-23 15:17:13', 2, 'In Progress', 0),
(19, 'UJIAN TAHAP 1 ', 'U03012020001', 'rya8m', 2, 2, '2020-01-04', '10.20', '2020-01-03 20:32:50', 2, '2020-01-04 04:24:23', 98, 'Done', 0),
(20, 'UJIAN STAN TAHAP 1', 'U22012020001', 'sy3w2', 2, 2, '2020-01-22', '08:00', '2020-01-22 06:20:51', 2, '2020-02-02 03:44:52', 98, 'Done', 0),
(21, 'UJIAN STAN TAHAP 2', 'U22012020002', 'yedkf', 2, 2, '2020-01-22', '08:00', '2020-01-22 06:22:20', 2, '2020-01-22 06:35:09', 2, 'In Progress', 0),
(22, 'UJIAN 90 MENIT', 'U22022020001', 'do4az', 2, 2, '2020-02-22', '09:00', '2020-02-22 03:53:10', 2, '2020-02-22 03:54:14', 2, 'In Progress', 0),
(23, 'UJIAN TES TPA II', 'U03032020001', 'l2zs3', 2, 2, '2020-03-03', '23:00', '2020-03-03 13:42:03', 2, '2020-03-03 13:42:18', 2, 'Ready', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ujian_has_pengawas`
--

CREATE TABLE `ujian_has_pengawas` (
  `id` int(11) NOT NULL,
  `pengawas_ujian` int(11) NOT NULL,
  `ujian` int(11) NOT NULL,
  `createddate` datetime DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  `updateddate` datetime DEFAULT NULL,
  `updatedby` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ujian_has_pengawas`
--

INSERT INTO `ujian_has_pengawas` (`id`, `pengawas_ujian`, `ujian`, `createddate`, `createdby`, `updateddate`, `updatedby`) VALUES
(13, 4, 12, '2018-02-24 22:16:41', 2, NULL, NULL),
(14, 4, 13, '2018-03-23 08:09:22', 2, NULL, NULL),
(15, 4, 14, '2018-03-24 08:17:12', 2, NULL, NULL),
(16, 4, 15, '2018-04-09 09:13:26', 2, NULL, NULL),
(17, 5, 16, '2018-06-08 14:17:09', 3, NULL, NULL),
(18, 5, 17, '2019-04-28 13:39:35', 2, NULL, NULL),
(19, 5, 18, '2019-11-22 14:16:52', 2, NULL, NULL),
(20, 4, 19, '2020-01-03 20:32:50', 2, NULL, NULL),
(21, 4, 20, '2020-01-22 06:20:51', 2, NULL, NULL),
(22, 4, 21, '2020-01-22 06:22:20', 2, NULL, NULL),
(23, 5, 22, '2020-02-22 03:53:10', 2, NULL, NULL),
(24, 5, 23, '2020-03-03 13:42:03', 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ujian_has_soal`
--

CREATE TABLE `ujian_has_soal` (
  `id` int(11) NOT NULL,
  `ujian` int(11) NOT NULL,
  `soal` int(11) NOT NULL,
  `is_played` int(11) NOT NULL DEFAULT '0',
  `createddate` datetime DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  `updateddate` datetime DEFAULT NULL,
  `updatedby` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ujian_has_soal`
--

INSERT INTO `ujian_has_soal` (`id`, `ujian`, `soal`, `is_played`, `createddate`, `createdby`, `updateddate`, `updatedby`) VALUES
(54, 12, 51, 0, '2018-02-24 22:16:53', 2, NULL, NULL),
(55, 13, 51, 0, '2018-03-23 08:11:54', 2, NULL, NULL),
(56, 13, 103, 0, '2018-03-23 08:11:54', 2, NULL, NULL),
(57, 13, 92, 0, '2018-03-23 08:11:54', 2, NULL, NULL),
(58, 13, 93, 0, '2018-03-23 08:11:54', 2, NULL, NULL),
(59, 13, 94, 0, '2018-03-23 08:11:54', 2, NULL, NULL),
(60, 13, 97, 0, '2018-03-23 08:11:54', 2, NULL, NULL),
(61, 13, 98, 0, '2018-03-23 08:11:54', 2, NULL, NULL),
(62, 13, 99, 0, '2018-03-23 08:11:54', 2, NULL, NULL),
(63, 13, 100, 0, '2018-03-23 08:11:54', 2, NULL, NULL),
(64, 13, 101, 0, '2018-03-23 08:11:54', 2, NULL, NULL),
(65, 13, 90, 0, '2018-03-23 08:11:54', 2, NULL, NULL),
(66, 13, 96, 0, '2018-03-23 08:11:54', 2, NULL, NULL),
(67, 13, 91, 0, '2018-03-23 08:11:54', 2, NULL, NULL),
(68, 14, 51, 0, '2018-03-24 08:17:40', 2, NULL, NULL),
(69, 14, 103, 0, '2018-03-24 08:17:40', 2, NULL, NULL),
(70, 14, 92, 0, '2018-03-24 08:17:40', 2, NULL, NULL),
(71, 14, 93, 0, '2018-03-24 08:17:40', 2, NULL, NULL),
(72, 14, 94, 0, '2018-03-24 08:17:40', 2, NULL, NULL),
(73, 14, 97, 0, '2018-03-24 08:17:40', 2, NULL, NULL),
(74, 14, 98, 0, '2018-03-24 08:17:40', 2, NULL, NULL),
(75, 14, 99, 0, '2018-03-24 08:17:40', 2, NULL, NULL),
(76, 14, 100, 0, '2018-03-24 08:17:40', 2, NULL, NULL),
(77, 14, 101, 0, '2018-03-24 08:17:40', 2, NULL, NULL),
(78, 14, 90, 0, '2018-03-24 08:17:40', 2, NULL, NULL),
(79, 14, 96, 0, '2018-03-24 08:17:40', 2, NULL, NULL),
(80, 14, 91, 0, '2018-03-24 08:17:40', 2, NULL, NULL),
(81, 15, 51, 0, '2018-04-09 09:15:06', 2, NULL, NULL),
(82, 15, 103, 0, '2018-04-09 09:15:06', 2, NULL, NULL),
(83, 16, 107, 0, '2018-06-08 14:29:27', 3, NULL, NULL),
(84, 16, 108, 0, '2018-06-08 14:29:27', 3, NULL, NULL),
(85, 17, 51, 0, '2019-04-28 13:40:34', 2, NULL, NULL),
(86, 17, 103, 0, '2019-04-28 13:40:34', 2, NULL, NULL),
(87, 17, 104, 0, '2019-04-28 13:40:34', 2, NULL, NULL),
(88, 17, 92, 0, '2019-04-28 13:40:34', 2, NULL, NULL),
(89, 17, 93, 0, '2019-04-28 13:40:34', 2, NULL, NULL),
(90, 17, 94, 0, '2019-04-28 13:40:34', 2, NULL, NULL),
(91, 17, 97, 0, '2019-04-28 13:40:34', 2, NULL, NULL),
(92, 17, 98, 0, '2019-04-28 13:40:34', 2, NULL, NULL),
(93, 17, 99, 0, '2019-04-28 13:40:34', 2, NULL, NULL),
(94, 17, 100, 0, '2019-04-28 13:40:34', 2, NULL, NULL),
(95, 17, 101, 0, '2019-04-28 13:40:34', 2, NULL, NULL),
(96, 17, 106, 0, '2019-04-28 13:40:34', 2, NULL, NULL),
(97, 17, 90, 0, '2019-04-28 13:40:34', 2, NULL, NULL),
(98, 17, 96, 0, '2019-04-28 13:40:34', 2, NULL, NULL),
(99, 17, 91, 0, '2019-04-28 13:40:34', 2, NULL, NULL),
(100, 18, 51, 0, '2019-12-23 14:55:09', 2, NULL, NULL),
(101, 18, 103, 0, '2019-12-23 14:55:09', 2, NULL, NULL),
(102, 18, 104, 0, '2019-12-23 14:55:09', 2, NULL, NULL),
(103, 19, 51, 0, '2020-01-03 20:37:07', 2, NULL, NULL),
(104, 19, 103, 0, '2020-01-03 20:37:07', 2, NULL, NULL),
(105, 19, 104, 0, '2020-01-03 20:37:07', 2, NULL, NULL),
(106, 21, 114, 0, '2020-01-22 06:23:35', 2, NULL, NULL),
(107, 21, 116, 0, '2020-01-22 06:23:35', 2, NULL, NULL),
(108, 20, 117, 0, '2020-02-02 01:36:49', 2, NULL, NULL),
(109, 20, 116, 0, '2020-02-02 01:36:49', 2, NULL, NULL),
(110, 22, 130, 0, '2020-02-22 03:53:20', 2, NULL, NULL),
(111, 22, 129, 0, '2020-02-22 03:53:20', 2, NULL, NULL),
(112, 22, 128, 0, '2020-02-22 03:53:20', 2, NULL, NULL),
(113, 23, 130, 0, '2020-03-03 13:42:14', 2, NULL, NULL),
(114, 23, 129, 0, '2020-03-03 13:42:14', 2, NULL, NULL),
(115, 23, 128, 0, '2020-03-03 13:42:14', 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ujian_has_soal_limit_keluar`
--

CREATE TABLE `ujian_has_soal_limit_keluar` (
  `id` int(11) NOT NULL,
  `ujian` int(11) NOT NULL,
  `kategori_soal` int(11) NOT NULL,
  `limit_soal_keluar` int(11) DEFAULT NULL,
  `createddate` datetime DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  `updateddate` datetime DEFAULT NULL,
  `updatedby` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ujian_has_soal_limit_keluar`
--

INSERT INTO `ujian_has_soal_limit_keluar` (`id`, `ujian`, `kategori_soal`, `limit_soal_keluar`, `createddate`, `createdby`, `updateddate`, `updatedby`) VALUES
(7, 12, 13, 1, '2018-02-24 22:17:31', 2, NULL, NULL),
(8, 13, 13, 1, '2018-03-23 08:13:30', 2, NULL, NULL),
(9, 13, 14, 2, '2018-03-23 08:13:41', 2, NULL, NULL),
(10, 13, 15, 1, '2018-03-23 08:13:52', 2, NULL, NULL),
(11, 13, 16, 1, '2018-03-23 08:14:03', 2, NULL, NULL),
(12, 14, 13, 4, '2018-03-24 08:18:36', 2, NULL, NULL),
(13, 14, 14, 1, '2018-03-24 08:18:46', 2, NULL, NULL),
(14, 14, 15, 2, '2018-03-24 08:18:57', 2, NULL, NULL),
(15, 14, 16, 1, '2018-03-24 08:19:12', 2, NULL, NULL),
(16, 15, 13, 1, '2018-04-09 09:18:35', 2, NULL, NULL),
(17, 16, 18, 2, '2018-06-08 14:37:03', 3, NULL, NULL),
(18, 17, 13, 2, '2019-04-28 13:42:27', 2, NULL, NULL),
(19, 17, 14, 3, '2019-04-28 13:42:50', 2, NULL, NULL),
(20, 18, 13, 3, '2019-12-23 15:16:37', 2, NULL, NULL),
(21, 19, 13, 3, '2020-01-03 21:06:03', 2, NULL, NULL),
(22, 21, 13, 2, '2020-01-22 06:33:47', 2, NULL, NULL),
(23, 20, 20, 1, '2020-02-02 01:54:38', 2, NULL, NULL),
(24, 20, 13, 1, '2020-02-02 01:54:42', 2, NULL, NULL),
(25, 22, 21, 3, '2020-02-22 03:53:52', 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ujian_poin_lulus`
--

CREATE TABLE `ujian_poin_lulus` (
  `id` int(11) NOT NULL,
  `ujian` int(11) DEFAULT NULL,
  `poin` int(11) DEFAULT '0',
  `createddate` date DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  `updateddate` datetime DEFAULT NULL,
  `updatedby` int(11) DEFAULT NULL,
  `deleted` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ujian_poin_lulus`
--

INSERT INTO `ujian_poin_lulus` (`id`, `ujian`, `poin`, `createddate`, `createdby`, `updateddate`, `updatedby`, `deleted`) VALUES
(1, 20, 80, '2020-02-02', 2, NULL, NULL, 0),
(2, 22, 5, '2020-02-22', 2, NULL, NULL, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bobot_nilai_kategori`
--
ALTER TABLE `bobot_nilai_kategori`
  ADD PRIMARY KEY (`id`,`kategori_soal`),
  ADD KEY `fk_bobot_nilai_kategori_kategori_soal1_idx` (`kategori_soal`);

--
-- Indexes for table `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`id`,`mata_pelajaran`),
  ADD KEY `fk_guru_mata_pelajaran1_idx` (`mata_pelajaran`);

--
-- Indexes for table `jurusan`
--
ALTER TABLE `jurusan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori_soal`
--
ALTER TABLE `kategori_soal`
  ADD PRIMARY KEY (`id`,`mata_pelajaran`),
  ADD KEY `fk_kategori_soal_mata_pelajaran1_idx` (`mata_pelajaran`);

--
-- Indexes for table `kategori_ujian`
--
ALTER TABLE `kategori_ujian`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mata_pelajaran`
--
ALTER TABLE `mata_pelajaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengaturan_nilai`
--
ALTER TABLE `pengaturan_nilai`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengawas_ujian`
--
ALTER TABLE `pengawas_ujian`
  ADD PRIMARY KEY (`id`,`guru`),
  ADD KEY `fk_pengawas_ujian_guru1_idx` (`guru`);

--
-- Indexes for table `peserta_ujian`
--
ALTER TABLE `peserta_ujian`
  ADD PRIMARY KEY (`id`,`ujian`,`siswa`),
  ADD KEY `fk_peserta_ujian_siswa1_idx` (`siswa`),
  ADD KEY `fk_peserta_ujian_ujian1_idx` (`ujian`);

--
-- Indexes for table `role_access`
--
ALTER TABLE `role_access`
  ADD PRIMARY KEY (`id`,`guru`,`module`),
  ADD KEY `fk_role_access_guru1_idx` (`guru`),
  ADD KEY `fk_role_access_module1_idx` (`module`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id`,`jurusan`),
  ADD KEY `fk_siswa_jurusan_idx` (`jurusan`);

--
-- Indexes for table `siswa_has_jawaban`
--
ALTER TABLE `siswa_has_jawaban`
  ADD PRIMARY KEY (`id`,`ujian`,`siswa`,`soal`,`soal_has_jawaban`,`status_jawaban`),
  ADD KEY `fk_siswa_has_jawaban_soal_has_jawaban1_idx` (`soal_has_jawaban`),
  ADD KEY `fk_siswa_has_jawaban_siswa1_idx` (`siswa`),
  ADD KEY `fk_siswa_has_jawaban_status_jawaban1_idx` (`status_jawaban`),
  ADD KEY `fk_siswa_has_jawaban_ujian1_idx` (`ujian`),
  ADD KEY `fk_siswa_has_jawaban_soal1_idx` (`soal`);

--
-- Indexes for table `siswa_has_kategori_random_soal`
--
ALTER TABLE `siswa_has_kategori_random_soal`
  ADD PRIMARY KEY (`id`,`siswa`,`ujian`,`kategori_soal`,`soal`),
  ADD KEY `fk_siswa_has_kategori_random_soal_siswa1_idx` (`siswa`),
  ADD KEY `fk_siswa_has_kategori_random_soal_kategori_soal1_idx` (`kategori_soal`),
  ADD KEY `fk_siswa_has_kategori_random_soal_soal1_idx` (`soal`),
  ADD KEY `fk_siswa_has_kategori_random_soal_ujian1_idx` (`ujian`);

--
-- Indexes for table `siswa_has_ujian`
--
ALTER TABLE `siswa_has_ujian`
  ADD PRIMARY KEY (`id`,`siswa`,`ujian`),
  ADD KEY `fk_siswa_has_ujian_siswa1_idx` (`siswa`),
  ADD KEY `fk_siswa_has_ujian_ujian1_idx` (`ujian`);

--
-- Indexes for table `soal`
--
ALTER TABLE `soal`
  ADD PRIMARY KEY (`id`,`kategori_soal`),
  ADD KEY `fk_soal_kategori_soal1_idx` (`kategori_soal`);

--
-- Indexes for table `soal_has_jawaban`
--
ALTER TABLE `soal_has_jawaban`
  ADD PRIMARY KEY (`id`,`soal`),
  ADD KEY `fk_soal_has_jawaban_soal1_idx` (`soal`);

--
-- Indexes for table `start_ujian`
--
ALTER TABLE `start_ujian`
  ADD PRIMARY KEY (`id`,`time_limit`,`ujian`),
  ADD KEY `fk_start_ujian_ujian1_idx` (`ujian`),
  ADD KEY `fk_start_ujian_time_limit1_idx` (`time_limit`);

--
-- Indexes for table `status_jawaban`
--
ALTER TABLE `status_jawaban`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `time_limit`
--
ALTER TABLE `time_limit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `type_soal`
--
ALTER TABLE `type_soal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ujian`
--
ALTER TABLE `ujian`
  ADD PRIMARY KEY (`id`,`guru`,`kategori_ujian`),
  ADD KEY `fk_soal_guru1_idx` (`guru`),
  ADD KEY `fk_ujian_kategori_ujian1_idx` (`kategori_ujian`);

--
-- Indexes for table `ujian_has_pengawas`
--
ALTER TABLE `ujian_has_pengawas`
  ADD PRIMARY KEY (`id`,`pengawas_ujian`,`ujian`),
  ADD KEY `fk_ujian_has_pengawas_ujian1_idx` (`ujian`),
  ADD KEY `fk_ujian_has_pengawas_pengawas_ujian1_idx` (`pengawas_ujian`);

--
-- Indexes for table `ujian_has_soal`
--
ALTER TABLE `ujian_has_soal`
  ADD PRIMARY KEY (`id`,`ujian`,`soal`),
  ADD KEY `fk_ujian_has_soal_ujian1_idx` (`ujian`),
  ADD KEY `fk_ujian_has_soal_soal1_idx` (`soal`);

--
-- Indexes for table `ujian_has_soal_limit_keluar`
--
ALTER TABLE `ujian_has_soal_limit_keluar`
  ADD PRIMARY KEY (`id`,`ujian`,`kategori_soal`),
  ADD KEY `fk_ujian_has_soal_limit_keluar_ujian1_idx` (`ujian`),
  ADD KEY `fk_ujian_has_soal_limit_keluar_kategori_soal1_idx` (`kategori_soal`);

--
-- Indexes for table `ujian_poin_lulus`
--
ALTER TABLE `ujian_poin_lulus`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bobot_nilai_kategori`
--
ALTER TABLE `bobot_nilai_kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `guru`
--
ALTER TABLE `guru`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jurusan`
--
ALTER TABLE `jurusan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `kategori_soal`
--
ALTER TABLE `kategori_soal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `kategori_ujian`
--
ALTER TABLE `kategori_ujian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `mata_pelajaran`
--
ALTER TABLE `mata_pelajaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `module`
--
ALTER TABLE `module`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pengaturan_nilai`
--
ALTER TABLE `pengaturan_nilai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pengawas_ujian`
--
ALTER TABLE `pengawas_ujian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `peserta_ujian`
--
ALTER TABLE `peserta_ujian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `role_access`
--
ALTER TABLE `role_access`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT for table `siswa_has_jawaban`
--
ALTER TABLE `siswa_has_jawaban`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `siswa_has_kategori_random_soal`
--
ALTER TABLE `siswa_has_kategori_random_soal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;

--
-- AUTO_INCREMENT for table `siswa_has_ujian`
--
ALTER TABLE `siswa_has_ujian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT for table `soal`
--
ALTER TABLE `soal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;

--
-- AUTO_INCREMENT for table `soal_has_jawaban`
--
ALTER TABLE `soal_has_jawaban`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=752;

--
-- AUTO_INCREMENT for table `start_ujian`
--
ALTER TABLE `start_ujian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `status_jawaban`
--
ALTER TABLE `status_jawaban`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `time_limit`
--
ALTER TABLE `time_limit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `type_soal`
--
ALTER TABLE `type_soal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ujian`
--
ALTER TABLE `ujian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `ujian_has_pengawas`
--
ALTER TABLE `ujian_has_pengawas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `ujian_has_soal`
--
ALTER TABLE `ujian_has_soal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `ujian_has_soal_limit_keluar`
--
ALTER TABLE `ujian_has_soal_limit_keluar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `ujian_poin_lulus`
--
ALTER TABLE `ujian_poin_lulus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `guru`
--
ALTER TABLE `guru`
  ADD CONSTRAINT `fk_guru_mata_pelajaran1` FOREIGN KEY (`mata_pelajaran`) REFERENCES `mata_pelajaran` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `kategori_soal`
--
ALTER TABLE `kategori_soal`
  ADD CONSTRAINT `fk_kategori_soal_mata_pelajaran1` FOREIGN KEY (`mata_pelajaran`) REFERENCES `mata_pelajaran` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `pengawas_ujian`
--
ALTER TABLE `pengawas_ujian`
  ADD CONSTRAINT `fk_pengawas_ujian_guru1` FOREIGN KEY (`guru`) REFERENCES `guru` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `peserta_ujian`
--
ALTER TABLE `peserta_ujian`
  ADD CONSTRAINT `fk_peserta_ujian_siswa1` FOREIGN KEY (`siswa`) REFERENCES `siswa` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_peserta_ujian_ujian1` FOREIGN KEY (`ujian`) REFERENCES `ujian` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `role_access`
--
ALTER TABLE `role_access`
  ADD CONSTRAINT `fk_role_access_guru1` FOREIGN KEY (`guru`) REFERENCES `guru` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_role_access_module1` FOREIGN KEY (`module`) REFERENCES `module` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `fk_siswa_jurusan` FOREIGN KEY (`jurusan`) REFERENCES `jurusan` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `siswa_has_jawaban`
--
ALTER TABLE `siswa_has_jawaban`
  ADD CONSTRAINT `fk_siswa_has_jawaban_siswa1` FOREIGN KEY (`siswa`) REFERENCES `siswa` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_siswa_has_jawaban_soal1` FOREIGN KEY (`soal`) REFERENCES `soal` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_siswa_has_jawaban_soal_has_jawaban1` FOREIGN KEY (`soal_has_jawaban`) REFERENCES `soal_has_jawaban` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_siswa_has_jawaban_status_jawaban1` FOREIGN KEY (`status_jawaban`) REFERENCES `status_jawaban` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_siswa_has_jawaban_ujian1` FOREIGN KEY (`ujian`) REFERENCES `ujian` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `siswa_has_kategori_random_soal`
--
ALTER TABLE `siswa_has_kategori_random_soal`
  ADD CONSTRAINT `fk_siswa_has_kategori_random_soal_kategori_soal1` FOREIGN KEY (`kategori_soal`) REFERENCES `kategori_soal` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_siswa_has_kategori_random_soal_siswa1` FOREIGN KEY (`siswa`) REFERENCES `siswa` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_siswa_has_kategori_random_soal_soal1` FOREIGN KEY (`soal`) REFERENCES `soal` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_siswa_has_kategori_random_soal_ujian1` FOREIGN KEY (`ujian`) REFERENCES `ujian` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `siswa_has_ujian`
--
ALTER TABLE `siswa_has_ujian`
  ADD CONSTRAINT `fk_siswa_has_ujian_siswa1` FOREIGN KEY (`siswa`) REFERENCES `siswa` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_siswa_has_ujian_ujian1` FOREIGN KEY (`ujian`) REFERENCES `ujian` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `soal`
--
ALTER TABLE `soal`
  ADD CONSTRAINT `fk_soal_kategori_soal1` FOREIGN KEY (`kategori_soal`) REFERENCES `kategori_soal` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `soal_has_jawaban`
--
ALTER TABLE `soal_has_jawaban`
  ADD CONSTRAINT `fk_soal_has_jawaban_soal1` FOREIGN KEY (`soal`) REFERENCES `soal` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `start_ujian`
--
ALTER TABLE `start_ujian`
  ADD CONSTRAINT `fk_start_ujian_time_limit1` FOREIGN KEY (`time_limit`) REFERENCES `time_limit` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_start_ujian_ujian1` FOREIGN KEY (`ujian`) REFERENCES `ujian` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `ujian`
--
ALTER TABLE `ujian`
  ADD CONSTRAINT `fk_soal_guru1` FOREIGN KEY (`guru`) REFERENCES `guru` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ujian_kategori_ujian1` FOREIGN KEY (`kategori_ujian`) REFERENCES `kategori_ujian` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `ujian_has_pengawas`
--
ALTER TABLE `ujian_has_pengawas`
  ADD CONSTRAINT `fk_ujian_has_pengawas_pengawas_ujian1` FOREIGN KEY (`pengawas_ujian`) REFERENCES `pengawas_ujian` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ujian_has_pengawas_ujian1` FOREIGN KEY (`ujian`) REFERENCES `ujian` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `ujian_has_soal`
--
ALTER TABLE `ujian_has_soal`
  ADD CONSTRAINT `fk_ujian_has_soal_soal1` FOREIGN KEY (`soal`) REFERENCES `soal` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ujian_has_soal_ujian1` FOREIGN KEY (`ujian`) REFERENCES `ujian` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `ujian_has_soal_limit_keluar`
--
ALTER TABLE `ujian_has_soal_limit_keluar`
  ADD CONSTRAINT `fk_ujian_has_soal_limit_keluar_kategori_soal1` FOREIGN KEY (`kategori_soal`) REFERENCES `kategori_soal` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ujian_has_soal_limit_keluar_ujian1` FOREIGN KEY (`ujian`) REFERENCES `ujian` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
