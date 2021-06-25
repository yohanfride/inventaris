-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.31-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- -- Dumping database structure for inventaris
-- CREATE DATABASE IF NOT EXISTS `inventaris` /*!40100 DEFAULT CHARACTER SET latin1 */;
-- USE `inventaris`;

-- Dumping structure for table inventaris.barang
CREATE TABLE IF NOT EXISTS `barang` (
  `idbarang` int(11) NOT NULL AUTO_INCREMENT,
  `kode_barang` char(50) DEFAULT NULL,
  `idjenis` int(11) DEFAULT NULL,
  `barang` char(50) DEFAULT NULL,
  `user_id` char(50) DEFAULT NULL,
  `date_add` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `date_add_otomatis` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `keterangan_barang` varchar(255) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `satuan` char(50) DEFAULT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `foto` text,
  `status` int(11) DEFAULT '1',
  PRIMARY KEY (`idbarang`),
  KEY `FK_barang_jenis` (`idjenis`),
  CONSTRAINT `FK_barang_jenis` FOREIGN KEY (`idjenis`) REFERENCES `jenis` (`idjenis`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Dumping data for table inventaris.barang: ~2 rows (approximately)
/*!40000 ALTER TABLE `barang` DISABLE KEYS */;
INSERT INTO `barang` (`idbarang`, `kode_barang`, `idjenis`, `barang`, `user_id`, `date_add`, `date_add_otomatis`, `keterangan_barang`, `jumlah`, `satuan`, `lokasi`, `foto`, `status`) VALUES
	(2, 'KD00001', 3, 'Bahan 1', '1', '2021-06-19 00:00:00', '2021-06-19 14:01:36', '-', 5, 'Pcs', 'M7', 'assets/upload/barang/(2021-06-19)-KD00001.jpg', 1),
	(4, 'KD00002', 3, 'Bahan 2', '1', '2021-06-19 00:00:00', '2021-06-19 16:30:36', '-', 5, 'Pcs', 'M8', 'assets/upload/barang/(2021-06-19_04-43-04)-KD00002.png', 1);
/*!40000 ALTER TABLE `barang` ENABLE KEYS */;

-- Dumping structure for table inventaris.barang_keluar
CREATE TABLE IF NOT EXISTS `barang_keluar` (
  `idbarang_keluar` int(11) NOT NULL AUTO_INCREMENT,
  `idbarang` int(11) DEFAULT NULL,
  `jumlah_keluar` int(11) DEFAULT NULL,
  `user_id` char(50) DEFAULT NULL,
  `tanggal_keluar` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `date_add_otomatis` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `keterangan` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idbarang_keluar`),
  KEY `FK__barang` (`idbarang`),
  CONSTRAINT `FK__barang` FOREIGN KEY (`idbarang`) REFERENCES `barang` (`idbarang`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table inventaris.barang_keluar: ~1 rows (approximately)
/*!40000 ALTER TABLE `barang_keluar` DISABLE KEYS */;
INSERT INTO `barang_keluar` (`idbarang_keluar`, `idbarang`, `jumlah_keluar`, `user_id`, `tanggal_keluar`, `date_add_otomatis`, `keterangan`) VALUES
	(1, 4, 5, '1', '2021-06-20 00:00:00', '2021-06-20 02:31:52', '-'),
	(3, 2, 5, '1', '2021-06-20 00:00:00', '2021-06-20 02:40:21', '');
/*!40000 ALTER TABLE `barang_keluar` ENABLE KEYS */;

-- Dumping structure for table inventaris.barang_masuk
CREATE TABLE IF NOT EXISTS `barang_masuk` (
  `idbarang_masuk` int(11) NOT NULL AUTO_INCREMENT,
  `idbarang` int(11) DEFAULT NULL,
  `jumlah_masuk` int(11) DEFAULT NULL,
  `user_id` char(50) DEFAULT NULL,
  `tanggal_masuk` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `date_add_otomatis` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `keterangan` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idbarang_masuk`),
  KEY `FK_barang_masuk_barang` (`idbarang`),
  CONSTRAINT `FK_barang_masuk_barang` FOREIGN KEY (`idbarang`) REFERENCES `barang` (`idbarang`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Dumping data for table inventaris.barang_masuk: ~3 rows (approximately)
/*!40000 ALTER TABLE `barang_masuk` DISABLE KEYS */;
INSERT INTO `barang_masuk` (`idbarang_masuk`, `idbarang`, `jumlah_masuk`, `user_id`, `tanggal_masuk`, `date_add_otomatis`, `keterangan`) VALUES
	(3, 4, 5, '1', '2021-06-20 00:00:00', '2021-06-20 00:31:50', '-'),
	(4, 2, 10, '1', '2021-06-20 00:00:00', '2021-06-20 00:32:18', '-'),
	(5, 4, 10, '1', '2021-06-20 00:00:00', '2021-06-20 00:32:50', '-');
/*!40000 ALTER TABLE `barang_masuk` ENABLE KEYS */;

-- Dumping structure for table inventaris.jenis
CREATE TABLE IF NOT EXISTS `jenis` (
  `idjenis` int(11) NOT NULL AUTO_INCREMENT,
  `jenis` char(50) DEFAULT NULL,
  `keterangan_jenis` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idjenis`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table inventaris.jenis: ~2 rows (approximately)
/*!40000 ALTER TABLE `jenis` DISABLE KEYS */;
INSERT INTO `jenis` (`idjenis`, `jenis`, `keterangan_jenis`) VALUES
	(1, 'Test Jenis', '-'),
	(3, 'Tesst2', '-');
/*!40000 ALTER TABLE `jenis` ENABLE KEYS */;

-- Dumping structure for table inventaris.peminjaman
CREATE TABLE IF NOT EXISTS `peminjaman` (
  `idpeminjaman` int(11) NOT NULL AUTO_INCREMENT,
  `kode_peminjaman` varchar(50) NOT NULL DEFAULT '0',
  `peminjam` varchar(255) DEFAULT NULL,
  `user_id` char(50) DEFAULT NULL,
  `tgl_pinjam` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `date_add_otomatis` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tgl_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `keterangan_pinjam` varchar(255) DEFAULT NULL,
  `status_pinjam` int(11) DEFAULT '1',
  PRIMARY KEY (`idpeminjaman`),
  UNIQUE KEY `kode_peminjaman` (`kode_peminjaman`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table inventaris.peminjaman: ~1 rows (approximately)
/*!40000 ALTER TABLE `peminjaman` DISABLE KEYS */;
INSERT INTO `peminjaman` (`idpeminjaman`, `kode_peminjaman`, `peminjam`, `user_id`, `tgl_pinjam`, `date_add_otomatis`, `tgl_update`, `keterangan_pinjam`, `status_pinjam`) VALUES
	(1, 'PJ00001', 'test', '1', '2021-06-22 00:00:00', '2021-06-22 10:31:25', '2021-06-22 10:46:41', '-', 1),
	(2, 'PJ00002', 'test2', '1', '2021-06-23 00:00:00', '2021-06-23 19:47:07', '2021-06-23 07:47:31', '', 0);
/*!40000 ALTER TABLE `peminjaman` ENABLE KEYS */;

-- Dumping structure for table inventaris.peminjaman_item
CREATE TABLE IF NOT EXISTS `peminjaman_item` (
  `id_peminjaman_item` int(11) NOT NULL AUTO_INCREMENT,
  `idpeminjaman` int(11) DEFAULT NULL,
  `idbarang` int(11) NOT NULL,
  `jumlah_pinjam` int(11) DEFAULT NULL,
  `status_kembali` int(11) NOT NULL DEFAULT '0',
  `jumlah_kembali` int(11) DEFAULT NULL,
  `tgl_kembali` datetime DEFAULT NULL,
  PRIMARY KEY (`id_peminjaman_item`),
  KEY `FK_peminjaman_item_barang` (`idbarang`),
  KEY `FK_peminjaman_item_peminjaman` (`idpeminjaman`),
  CONSTRAINT `FK_peminjaman_item_barang` FOREIGN KEY (`idbarang`) REFERENCES `barang` (`idbarang`) ON UPDATE CASCADE,
  CONSTRAINT `FK_peminjaman_item_peminjaman` FOREIGN KEY (`idpeminjaman`) REFERENCES `peminjaman` (`idpeminjaman`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Dumping data for table inventaris.peminjaman_item: ~4 rows (approximately)
/*!40000 ALTER TABLE `peminjaman_item` DISABLE KEYS */;
INSERT INTO `peminjaman_item` (`id_peminjaman_item`, `idpeminjaman`, `idbarang`, `jumlah_pinjam`, `status_kembali`, `jumlah_kembali`, `tgl_kembali`) VALUES
	(2, 1, 4, 3, 0, NULL, NULL),
	(3, 2, 2, 5, 1, 5, '2021-06-25 00:00:00'),
	(4, 2, 4, 2, 1, 2, '2021-06-25 00:00:00');
/*!40000 ALTER TABLE `peminjaman_item` ENABLE KEYS */;

-- Dumping structure for table inventaris.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `last_login` datetime NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `role` varchar(255) NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table inventaris.users: ~2 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `username`, `nama`, `password`, `last_login`, `status`, `role`) VALUES
	(1, 'master', 'Master Admin', 'd5802d05bbf0881de2fd823c9560619e', '2021-06-24 05:58:30', 1, 'master'),
	(2, 'omkadmin', 'omkadmin', '67fabbd16ed22365bad751a7b67b6497', '0000-00-00 00:00:00', 1, 'master');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
