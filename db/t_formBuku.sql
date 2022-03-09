-- --------------------------------------------------------
-- Host:                         192.168.0.2
-- Server version:               8.0.24 - MySQL Community Server - GPL
-- Server OS:                    Linux
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for t_formBuku
CREATE DATABASE IF NOT EXISTS `t_formBuku`;
USE `t_formBuku`;

-- Dumping structure for table t_formBuku.buku
CREATE TABLE IF NOT EXISTS `buku` (
  `id_buku` int NOT NULL AUTO_INCREMENT,
  `judul` varchar(225) NOT NULL,
  `pengarang` varchar(225) DEFAULT NULL,
  `penerbit` varchar(225) DEFAULT NULL,
  `gambar` varchar(225) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `update_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_buku`)
) ENGINE=InnoDB AUTO_INCREMENT=10;

-- Dumping data for table t_formBuku.buku: ~4 rows (approximately)
/*!40000 ALTER TABLE `buku` DISABLE KEYS */;
INSERT INTO `buku` (`id_buku`, `judul`, `pengarang`, `penerbit`, `gambar`, `created_at`, `update_at`) VALUES
	(1, 'Apa itu resiq', 'Produk hasil karya mahasiswa Fakultas Teknik Universitas Dian Nuswantoro dalam pengelolaan sampah plastik untuk diolah menjadi paving block.', NULL, NULL, NULL, NULL),
	(2, 'Alamat kantor ', 'Jl. Imam Bonjol No.207, Pendrikan Kidul, Kec. Semarang Tengah, Kota Semarang, Jawa Tengah 50131', NULL, NULL, NULL, NULL),
	(3, 'Info', 'No Telp. 024-3517261 | Email : info@resiq.id', NULL, NULL, NULL, NULL),
	(4, 'Kontak', 'No Telp. 024-3517261 | Email : info@resiq.id', NULL, NULL, NULL, NULL);
/*!40000 ALTER TABLE `buku` ENABLE KEYS */;

-- Dumping structure for table t_formBuku.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3;

-- Dumping data for table t_formBuku.user: ~1 rows (approximately)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `name`, `username`, `password`) VALUES
	(1, 'Admin', 'admin', '$argon2id$v=19$m=65536,t=4,p=1$azhqdnJMekl6R3l6S3RBYg$EjqU0RsN7aQkdpN4zHrZypWFQ8Jfa7OKt4xgQQtysTw');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
