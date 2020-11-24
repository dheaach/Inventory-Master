-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 28, 2019 at 09:25 AM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `simple_inven`
--

-- --------------------------------------------------------

--
-- Table structure for table `cc_keluar`
--

CREATE TABLE `cc_keluar` (
  `id` int(11) NOT NULL,
  `keterangan` text NOT NULL,
  `total` int(10) NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cc_keluar`
--

INSERT INTO `cc_keluar` (`id`, `keterangan`, `total`, `tanggal`) VALUES
(1, 'makan', 12000, '2019-08-28'),
(2, 'minum', 10000, '2019-08-28');

-- --------------------------------------------------------

--
-- Table structure for table `cc_kembali`
--

CREATE TABLE `cc_kembali` (
  `id` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `id_master` int(11) NOT NULL,
  `tgl` datetime NOT NULL,
  `jml` int(11) NOT NULL,
  `keterangan` text NOT NULL,
  `stat` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cc_kembali`
--

INSERT INTO `cc_kembali` (`id`, `id_pelanggan`, `id_master`, `tgl`, `jml`, `keterangan`, `stat`) VALUES
(1, 2, 38, '2019-08-28 00:00:00', 10, 'Pinjaman Kembali', 1),
(2, 3, 38, '2019-08-28 00:00:00', 20, 'Pinjaman Kembali', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cc_laporan`
--

CREATE TABLE `cc_laporan` (
  `id` int(11) NOT NULL,
  `tgl` date NOT NULL,
  `qty_10` int(11) NOT NULL,
  `qty_12` int(11) NOT NULL,
  `sub_10` int(11) NOT NULL,
  `sub_12` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `waktu` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cc_laporan`
--

INSERT INTO `cc_laporan` (`id`, `tgl`, `qty_10`, `qty_12`, `sub_10`, `sub_12`, `total`, `waktu`) VALUES
(1, '2019-08-28', 2, 2, 20000, 24000, 44000, '2019-08-28 14:24:41');

-- --------------------------------------------------------

--
-- Table structure for table `cc_master`
--

CREATE TABLE `cc_master` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `stat` int(1) DEFAULT NULL,
  `stok` int(10) NOT NULL,
  `harga` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cc_master`
--

INSERT INTO `cc_master` (`id`, `nama`, `stat`, `stok`, `harga`) VALUES
(33, 'Galon Op (10 rb)', 0, 500, 10000),
(38, 'Galon Baku (Kosong)', 0, 1137, 0),
(84, 'Galon Op (12 rb)', 0, 499, 12000),
(86, 'Tutup Galon', 0, 446, 0);

-- --------------------------------------------------------

--
-- Table structure for table `cc_pelanggan`
--

CREATE TABLE `cc_pelanggan` (
  `id_p` int(11) NOT NULL,
  `nama_p` varchar(40) NOT NULL,
  `alamat` text NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `total_pinjam` int(10) NOT NULL,
  `ket` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cc_pelanggan`
--

INSERT INTO `cc_pelanggan` (`id_p`, `nama_p`, `alamat`, `no_hp`, `total_pinjam`, `ket`) VALUES
(1, 'gudang', '', '', 0, ''),
(2, 'aminah', 'malang', '087701500719', 0, ''),
(3, 'santo', 'singosari', '08676619', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `cc_pinjam_ambil`
--

CREATE TABLE `cc_pinjam_ambil` (
  `id` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `id_master` int(11) NOT NULL,
  `tgl` datetime NOT NULL,
  `jml` int(11) NOT NULL,
  `keterangan` text NOT NULL,
  `stat` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cc_pinjam_ambil`
--

INSERT INTO `cc_pinjam_ambil` (`id`, `id_pelanggan`, `id_master`, `tgl`, `jml`, `keterangan`, `stat`) VALUES
(3, 1, 38, '2019-08-28 00:00:00', 52, 'Restok Gudang', 1),
(4, 1, 38, '2019-08-28 00:00:00', 50, 'Restok Gudang', 1),
(5, 2, 38, '2019-08-28 00:00:00', 10, 'Pinjaman Awal', 1),
(6, 3, 38, '2019-08-28 00:00:00', 20, 'Pinjaman Awal', 1),
(7, 1, 38, '2019-08-28 00:00:00', 1, 'Restok Gudang', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cc_project`
--

CREATE TABLE `cc_project` (
  `id` int(11) NOT NULL,
  `nama_project` varchar(100) NOT NULL,
  `tgl` datetime NOT NULL,
  `stat` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Triggers `cc_project`
--
DELIMITER $$
CREATE TRIGGER `hapusp` BEFORE DELETE ON `cc_project` FOR EACH ROW BEGIN
	DELETE FROM cc_temp WHERE id_project = OLD.id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `cc_temp`
--

CREATE TABLE `cc_temp` (
  `id` int(11) NOT NULL,
  `id_project` int(11) NOT NULL,
  `tb` varchar(30) NOT NULL,
  `id_master` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `tgl` datetime NOT NULL,
  `jml` int(11) NOT NULL,
  `ket` varchar(300) NOT NULL,
  `stat` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cc_terima`
--

CREATE TABLE `cc_terima` (
  `id_t` int(11) NOT NULL,
  `id_master` int(11) DEFAULT NULL,
  `id_admin` int(11) NOT NULL,
  `tgl` date DEFAULT NULL,
  `jml` int(11) DEFAULT NULL,
  `ket` varchar(300) DEFAULT NULL,
  `stat` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cc_terima`
--

INSERT INTO `cc_terima` (`id_t`, `id_master`, `id_admin`, `tgl`, `jml`, `ket`, `stat`) VALUES
(1, 33, 1, '2019-08-28', 448, 'Stok Sebelumnya', 1),
(2, 38, 1, '2019-08-28', 1240, 'Stok Sebelumnya', 1),
(3, 84, 1, '2019-08-28', 450, 'Stok Sebelumnya', 1),
(4, 86, 1, '2019-08-28', 448, 'Stok Sebelumnya', 1),
(5, 33, 1, '2019-08-28', 52, '', 1),
(6, 84, 1, '2019-08-28', 50, '', 1),
(7, 33, 1, '2019-08-28', 1, '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cc_terjual`
--

CREATE TABLE `cc_terjual` (
  `id` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `id_master` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `jml` int(11) DEFAULT NULL,
  `total` int(11) NOT NULL,
  `tgl` datetime DEFAULT NULL,
  `ket` varchar(300) NOT NULL,
  `stat` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cc_terjual`
--

INSERT INTO `cc_terjual` (`id`, `id_pelanggan`, `id_master`, `harga`, `jml`, `total`, `tgl`, `ket`, `stat`) VALUES
(2, 2, 33, 10000, 1, 10000, '2019-08-28 00:00:00', '', 1),
(3, 2, 84, 12000, 1, 12000, '2019-08-28 00:00:00', '', 1);

--
-- Triggers `cc_terjual`
--
DELIMITER $$
CREATE TRIGGER `kurang` AFTER INSERT ON `cc_terjual` FOR EACH ROW BEGIN
	UPDATE cc_master set stok=stok-new.jml WHERE id = new.id_master;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `cms_admin`
--

CREATE TABLE `cms_admin` (
  `id` int(11) NOT NULL,
  `username` varchar(32) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `email` varchar(75) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `token` varchar(40) DEFAULT NULL,
  `priviledge` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cms_admin`
--

INSERT INTO `cms_admin` (`id`, `username`, `name`, `email`, `password`, `token`, `priviledge`) VALUES
(1, 'admin', 'Administrator', 'tianrosandhy@gmail.com', '$2y$10$NtVX2YLOV3nbuL8H5yYcJ.o3Q3VBKuBV3rfHg2NovHMUEDgM6o8aS', 'd8ed7457a3464c783a4485c5173c8adce2210c1a', 1),
(5, 'wati', 'wati wati', 'wati@gmail.com', '$2y$10$z2eZ8oe5afQ6cqF7Ro.QFuANzLUZvqSqwR3YqL5HmouzvUtPJ1rfK', NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `cms_admin_fail`
--

CREATE TABLE `cms_admin_fail` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `tgl` datetime DEFAULT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `useragent` varchar(500) DEFAULT NULL,
  `stat` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cms_admin_fail`
--

INSERT INTO `cms_admin_fail` (`id`, `username`, `tgl`, `ip`, `useragent`, `stat`) VALUES
(1, 'ADMIN', '2019-08-06 04:22:51', '::1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cms_admin_log`
--

CREATE TABLE `cms_admin_log` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `tgl` datetime DEFAULT NULL,
  `expired` datetime DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `user_agent` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cms_admin_log`
--

INSERT INTO `cms_admin_log` (`id`, `username`, `tgl`, `expired`, `token`, `ip`, `user_agent`) VALUES
(1, 'admin', '2017-06-30 05:02:19', '2017-06-30 17:02:19', 'c42b3d41b4d6a3895cf2b80e7a08dcb1be9a83c1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36'),
(2, 'admin', '2017-07-01 02:50:18', '2017-07-01 14:50:18', 'a2f9392bf91dc705be0c92d0f3458a6a52b697d2', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.115 Safari/537.36'),
(3, 'admin', '2017-07-03 02:01:15', '2017-07-03 14:01:15', '0ca31bee87d86235bc193dcd8ec46414c452a647', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.115 Safari/537.36'),
(4, 'admin', '2017-07-04 03:19:15', '2017-07-04 15:19:15', '15fc59bcb23e52ab0ec6a76a41d66ed28a8aedee', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.115 Safari/537.36'),
(5, 'admin', '2017-07-04 05:25:47', '2017-07-04 17:25:47', '26173cfafee8cb96a218ebe97df3ebb185c1fbe2', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.115 Safari/537.36'),
(6, 'admin', '2017-07-04 05:25:53', '2017-07-04 17:25:53', '7380ae29990cb723955ce30f7a2ba822fd479669', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.115 Safari/537.36'),
(7, 'admin', '2017-07-04 09:51:28', '2017-07-04 21:51:28', '98c1f89c3c6849332601c4bf6cc0d158607ad783', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.115 Safari/537.36'),
(8, 'admin', '2017-07-05 03:24:25', '2017-07-05 15:24:25', 'ed3e08a5348fe61c41e7c9d7a9a5219f4041f04f', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.115 Safari/537.36'),
(9, 'admin', '2017-07-05 05:12:36', '2017-07-05 17:12:36', '6fbcdf8202f29748e95572958f9f832dbe34eda6', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.115 Safari/537.36'),
(10, 'admin', '2017-07-21 02:24:46', '2017-07-21 14:24:46', '95ae6dde76e4e5dc672cd4d29028ab23568c0126', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.115 Safari/537.36'),
(11, 'admin', '2017-07-30 14:40:34', '2017-07-31 02:40:34', '769c11ee9774003dfe2a724f0f30f219e8c9d03d', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.115 Safari/537.36'),
(12, 'admin', '2017-07-30 14:59:12', '2017-07-31 02:59:12', 'ce7de48eb9bd8ee9b9130fb67d8d99e3f0b017ba', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.115 Safari/537.36'),
(13, 'admin', '2017-07-30 14:59:46', '2017-07-31 02:59:46', 'fb491ba4ed16da2d7c7c968a1e632d92e58b4c16', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.115 Safari/537.36'),
(14, 'admin', '2017-07-30 15:06:03', '2017-07-31 03:06:03', '3d69ddafbfaa8642ff8fd203eaa50db56b126c3f', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.115 Safari/537.36'),
(15, 'admin', '2019-07-30 08:08:28', '2019-07-30 20:08:28', '39b0ea46f6ef1b829092ca8f14d3f91414dcd1ee', '::1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36'),
(16, 'admin', '2019-07-31 04:13:49', '2019-07-31 16:13:49', 'b32e362e2eb58282fc9fbd6a0b70dc050b21b047', '::1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36'),
(17, 'admin', '2019-08-01 04:08:10', '2019-08-01 16:08:10', 'd47d502a0c8edb7a9565e1a94baba26517d8bb99', '::1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36'),
(18, 'deha', '2019-08-01 08:13:24', '2019-08-01 20:13:24', 'fcce4b0b438219eca42251c81b19434b2357ccdd', '::1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36'),
(19, 'deha', '2019-08-01 08:15:53', '2019-08-01 20:15:53', '30e6b19dc2445c5ab63e359010983a085dbe3212', '::1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36'),
(20, 'admin', '2019-08-01 08:16:05', '2019-08-01 20:16:05', '0c3a330975d008188699dab24ba4a9cfbb24c90b', '::1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36'),
(21, 'admin', '2019-08-01 08:21:25', '2019-08-01 20:21:25', '0a9fbc5eea3a2609a4d3ec9de5a215505007a1f6', '::1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36'),
(22, 'deha', '2019-08-01 08:21:39', '2019-08-01 20:21:39', '82aee519203915ff04810d8b273a8fa4f6df80f7', '::1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36'),
(23, 'admin', '2019-08-01 08:51:08', '2019-08-01 20:51:08', '651fe49361bcaf6e5bb289fa542024bc45601946', '::1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36'),
(24, 'admin', '2019-08-02 04:08:53', '2019-08-02 16:08:53', '22a092a4d6f1cad937704a70f64520af31dd531a', '::1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36'),
(25, 'admin', '2019-08-02 08:42:53', '2019-08-02 20:42:53', 'd8405e75be1f473670e004fb738237f06cbaf3f5', '::1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36'),
(26, 'admin', '2019-08-03 04:13:58', '2019-08-03 16:13:58', '32b68c29da63e0838f164273dc77c99d3d61191d', '::1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36'),
(27, 'wati', '2019-08-03 06:39:37', '2019-08-03 18:39:37', 'a8deb711ed326d00e105e81606c698282b34593c', '::1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36'),
(28, 'admin', '2019-08-03 06:40:10', '2019-08-03 18:40:10', 'e1622ca686ce97db23f465bd79e7bd5dcca98c51', '::1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36'),
(29, 'admin', '2019-08-05 04:15:05', '2019-08-05 16:15:05', 'f148c53226a92d438b02355149ee1fe0b58433f0', '::1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36'),
(30, 'admin', '2019-08-06 04:12:58', '2019-08-06 16:12:58', 'a5a4146064b4330b0ee64f792e09f96ddf4eba5e', '::1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36'),
(31, 'admin', '2019-08-06 04:28:32', '2019-08-06 16:28:32', 'd0fa0b340a6e18bfce957ac022de566390b8dc0a', '::1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36'),
(32, 'admin', '2019-08-06 08:27:22', '2019-08-06 20:27:22', '9674e3eb7e36fbe9aebceac0fa95e0d1de7eb3af', '::1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36'),
(33, 'admin', '2019-08-06 09:39:11', '2019-08-06 21:39:11', '6e3f70ff61090c8cd144913305bf443a81fa2a7c', '::1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36'),
(34, 'admin', '2019-08-07 04:11:49', '2019-08-07 16:11:49', '36d3fa2fe37232d494f395255a09d0dc27e3c0b6', '::1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36'),
(35, 'admin', '2019-08-07 05:56:19', '2019-08-07 17:56:19', '450e8764ce633bf6730f748cb79b2a13978331c7', '::1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36'),
(36, 'admin', '2019-08-07 06:18:29', '2019-08-07 18:18:29', 'f2e6c06b6e823cffc82b29e104379078897f460a', '::1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36'),
(37, 'admin', '2019-08-08 04:10:00', '2019-08-08 16:10:00', '8e1f308c6a1cad5b67982ce7c66fa0dd84af9724', '::1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36'),
(38, 'wati', '2019-08-08 04:45:32', '2019-08-08 16:45:32', '3b1ab1f0ee31152d13f3c66683258f725efeb659', '::1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36'),
(39, 'admin', '2019-08-08 04:46:22', '2019-08-08 16:46:22', '31c6eba0d6f4dfb1d636da95c693120404a5e442', '::1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36'),
(40, 'wati', '2019-08-08 04:46:54', '2019-08-08 16:46:54', '0cfea7606362f52cdd6761f4418a7e032e52e0b1', '::1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36'),
(41, 'admin', '2019-08-08 05:05:20', '2019-08-08 17:05:20', '48a5d837cc67715c7cfab6c45bd7e66a15d8e07d', '::1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36'),
(42, 'admin', '2019-08-08 10:57:25', '2019-08-08 22:57:25', 'd4fe62215ce7f755e156f3cb0833b26a70c7baaa', '::1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36'),
(43, 'admin', '2019-08-09 13:53:04', '2019-08-10 01:53:04', 'f4af3fd7609088e3021d3ff8db142732ee7c022b', '::1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36'),
(44, 'admin', '2019-08-11 03:46:01', '2019-08-11 15:46:01', '8dc61cdde9546d363d340390ae7c9e9b7d275133', '::1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36'),
(45, 'admin', '2019-08-11 03:55:53', '2019-08-11 15:55:53', '62d85ee9b7e71265ef3cac2ad166fe4e0e4bd70a', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/64.0.3282.140 Safari/537.36 Edge/17.17134'),
(46, 'admin', '2019-08-11 07:15:51', '2019-08-11 19:15:51', '06ee03be9c5e6a49ce60049d01058e06e3385900', '::1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36'),
(47, 'admin', '2019-08-11 11:27:55', '2019-08-11 23:27:55', 'c34efa3c6ab1885d2f61be4be86e44701a6fd78e', '::1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36'),
(48, 'admin', '2019-08-13 04:11:12', '2019-08-13 16:11:12', 'f3dfac7d385201f61eb94f1b55ba8bbd9f62bb15', '::1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36'),
(49, 'admin', '2019-08-13 08:16:46', '2019-08-13 20:16:46', 'e4403069b2a67a131be20b44fcb9f6553d4bab1e', '::1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36'),
(50, 'admin', '2019-08-14 04:17:47', '2019-08-14 16:17:47', 'fe8b31dbe2b38cb66402a7e594a4ef5081441dc1', '::1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36'),
(51, 'admin', '2019-08-14 09:05:43', '2019-08-14 21:05:43', 'a4af3c95437c782138dd9efe8b2dec3d1d6e73a3', '::1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36'),
(52, 'admin', '2019-08-14 14:38:51', '2019-08-15 02:38:51', '0349cfe04740838f134e6b0457baf0aa4075c044', '::1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36'),
(53, 'admin', '2019-08-14 14:41:04', '2019-08-15 02:41:04', '728409809e93870c2ac3b2621ada348bc3453eb6', '::1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36'),
(54, 'admin', '2019-08-14 14:42:06', '2019-08-15 02:42:06', 'cbb009345dd622e77f0082e7c46f1fd0c431e7cc', '::1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36'),
(55, 'admin', '2019-08-14 15:01:32', '2019-08-15 03:01:32', 'ccc2b6cf733391fb93318b84d2e72bffbb0ee4d3', '::1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36'),
(56, 'admin', '2019-08-14 15:57:17', '2019-08-15 03:57:17', 'fb7025b43265af7f27d4349138f71f3a1f5d4cb3', '::1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36'),
(57, 'admin', '2019-08-15 04:09:35', '2019-08-15 16:09:35', '06e9623e898ab22cd713be09bbcfb2a5958aa512', '::1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36'),
(58, 'admin', '2019-08-16 04:12:36', '2019-08-16 16:12:36', '4f01e45b093426527f41e3fd161c0c35de541641', '::1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36'),
(59, 'admin', '2019-08-16 09:56:44', '2019-08-16 21:56:44', '93a317ca61cc3a4bc807b1422b25455cd0c7b387', '::1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36'),
(60, 'admin', '2019-08-16 11:06:03', '2019-08-16 23:06:03', 'c2a1180f1e0f28f01afcb2e68690690138e96878', '::1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36'),
(61, 'admin', '2019-08-17 06:41:24', '2019-08-17 18:41:24', '33b44234d3c4ca578cfe3956b30b500e41844fc0', '::1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36'),
(62, 'admin', '2019-08-19 04:10:35', '2019-08-19 16:10:35', '89ed31f9edd039a2fa8c10d5e1429f29c82e63de', '::1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36'),
(63, 'admin', '2019-08-19 07:47:32', '2019-08-19 19:47:32', '14c0e796e6761955b70edca4a2d08fdc8b418d77', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/64.0.3282.140 Safari/537.36 Edge/17.17134'),
(64, 'admin', '2019-08-20 04:09:14', '2019-08-20 16:09:14', '398dbf4e0ea57393c24340acfe9d32249fbed38b', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/64.0.3282.140 Safari/537.36 Edge/17.17134'),
(65, 'wati', '2019-08-20 08:02:04', '2019-08-20 20:02:04', '21295fd3d97e6ce8770a8cddb9c2c5ac0bf49fa4', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/64.0.3282.140 Safari/537.36 Edge/17.17134'),
(66, 'admin', '2019-08-20 09:04:11', '2019-08-20 21:04:11', '2bf02ab4c6fb6da0647dd78c8ef63abeea031a98', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/64.0.3282.140 Safari/537.36 Edge/17.17134'),
(67, 'wati', '2019-08-20 09:10:04', '2019-08-20 21:10:04', '0e4600588386e10a439e199718cb46f638a5ced2', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/64.0.3282.140 Safari/537.36 Edge/17.17134'),
(68, 'admin', '2019-08-21 05:51:11', '2019-08-21 17:51:11', '1080a126974621ee50b71af55c686cf6c784383f', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/64.0.3282.140 Safari/537.36 Edge/17.17134'),
(69, 'admin', '2019-08-28 05:58:10', '2019-08-28 17:58:10', '09a12e759f36f40d32551e796923ebc5a4eab121', '::1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36');

-- --------------------------------------------------------

--
-- Table structure for table `cms_option`
--

CREATE TABLE `cms_option` (
  `id` int(4) NOT NULL,
  `param` varchar(30) DEFAULT NULL,
  `label` varchar(100) DEFAULT NULL,
  `content` text,
  `type` varchar(20) DEFAULT NULL,
  `def` text,
  `stat` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cms_option`
--

INSERT INTO `cms_option` (`id`, `param`, `label`, `content`, `type`, `def`, `stat`) VALUES
(1, 'session_key', 'Session Key', 'tianrosandhy_sess_key', 'text', 'tianrosandhy_sess_key', 9),
(2, 'backend_paging', 'Data Per Page (Admin)', '20', 'number', '20', 1),
(3, 'frontend_paging', 'Data Per Page (Front)', '10', 'number', '10', 1),
(4, 'webname', 'Website Name', 'Aplikasi Monitoring Inventory', 'text', 'Website Name', 1),
(5, 'websubtitle', 'Website Sub Title', 'Another TianRosandhy\'s App', 'text', 'Another TianRosandhy\'s CMS Site', 1),
(6, 'max_login_try', 'Login Failed Max Try', '5', 'number', '5', 1),
(7, 'header_image', 'Header Image', NULL, 'text', NULL, 1),
(8, 'favicon', 'Favicon', NULL, 'text', NULL, 1),
(9, 'mail_system', 'Website Mail', 'me@tianrosandhy.com', 'text', 'me@tianrosandhy.com', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cc_keluar`
--
ALTER TABLE `cc_keluar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cc_kembali`
--
ALTER TABLE `cc_kembali`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pelanggan` (`id_pelanggan`),
  ADD KEY `id_master` (`id_master`);

--
-- Indexes for table `cc_laporan`
--
ALTER TABLE `cc_laporan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cc_master`
--
ALTER TABLE `cc_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cc_pelanggan`
--
ALTER TABLE `cc_pelanggan`
  ADD PRIMARY KEY (`id_p`);

--
-- Indexes for table `cc_pinjam_ambil`
--
ALTER TABLE `cc_pinjam_ambil`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pel` (`id_pelanggan`),
  ADD KEY `id_mas` (`id_master`);

--
-- Indexes for table `cc_project`
--
ALTER TABLE `cc_project`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cc_temp`
--
ALTER TABLE `cc_temp`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idm` (`id_master`),
  ADD KEY `idp` (`id_project`);

--
-- Indexes for table `cc_terima`
--
ALTER TABLE `cc_terima`
  ADD PRIMARY KEY (`id_t`),
  ADD KEY `id_admin` (`id_admin`),
  ADD KEY `id_m` (`id_master`);

--
-- Indexes for table `cc_terjual`
--
ALTER TABLE `cc_terjual`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_p` (`id_pelanggan`),
  ADD KEY `id_maste` (`id_master`);

--
-- Indexes for table `cms_admin`
--
ALTER TABLE `cms_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_admin_fail`
--
ALTER TABLE `cms_admin_fail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_admin_log`
--
ALTER TABLE `cms_admin_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_option`
--
ALTER TABLE `cms_option`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cc_keluar`
--
ALTER TABLE `cc_keluar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cc_kembali`
--
ALTER TABLE `cc_kembali`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cc_laporan`
--
ALTER TABLE `cc_laporan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cc_master`
--
ALTER TABLE `cc_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `cc_pelanggan`
--
ALTER TABLE `cc_pelanggan`
  MODIFY `id_p` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cc_pinjam_ambil`
--
ALTER TABLE `cc_pinjam_ambil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `cc_project`
--
ALTER TABLE `cc_project`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cc_temp`
--
ALTER TABLE `cc_temp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `cc_terima`
--
ALTER TABLE `cc_terima`
  MODIFY `id_t` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `cc_terjual`
--
ALTER TABLE `cc_terjual`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cms_admin`
--
ALTER TABLE `cms_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `cms_admin_fail`
--
ALTER TABLE `cms_admin_fail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cms_admin_log`
--
ALTER TABLE `cms_admin_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `cms_option`
--
ALTER TABLE `cms_option`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cc_kembali`
--
ALTER TABLE `cc_kembali`
  ADD CONSTRAINT `id_master` FOREIGN KEY (`id_master`) REFERENCES `cc_master` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_pelanggan` FOREIGN KEY (`id_pelanggan`) REFERENCES `cc_pelanggan` (`id_p`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `cc_pinjam_ambil`
--
ALTER TABLE `cc_pinjam_ambil`
  ADD CONSTRAINT `id_mas` FOREIGN KEY (`id_master`) REFERENCES `cc_master` (`id`),
  ADD CONSTRAINT `id_pel` FOREIGN KEY (`id_pelanggan`) REFERENCES `cc_pelanggan` (`id_p`);

--
-- Constraints for table `cc_temp`
--
ALTER TABLE `cc_temp`
  ADD CONSTRAINT `idm` FOREIGN KEY (`id_master`) REFERENCES `cc_master` (`id`),
  ADD CONSTRAINT `idp` FOREIGN KEY (`id_project`) REFERENCES `cc_project` (`id`);

--
-- Constraints for table `cc_terima`
--
ALTER TABLE `cc_terima`
  ADD CONSTRAINT `id_admin` FOREIGN KEY (`id_admin`) REFERENCES `cms_admin` (`id`),
  ADD CONSTRAINT `id_m` FOREIGN KEY (`id_master`) REFERENCES `cc_master` (`id`);

--
-- Constraints for table `cc_terjual`
--
ALTER TABLE `cc_terjual`
  ADD CONSTRAINT `id_maste` FOREIGN KEY (`id_master`) REFERENCES `cc_master` (`id`),
  ADD CONSTRAINT `id_p` FOREIGN KEY (`id_pelanggan`) REFERENCES `cc_pelanggan` (`id_p`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
