# Host: localhost  (Version 5.5.5-10.4.32-MariaDB)
# Date: 2025-08-26 11:01:26
# Generator: MySQL-Front 6.0  (Build 2.20)


#
# Structure for table "kategori"
#

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `status` enum('aktif','nonaktif') DEFAULT 'aktif',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

#
# Data for table "kategori"
#

INSERT INTO `kategori` VALUES (1,'Elektronik','Produk elektronik dan gadget','aktif'),(2,'Pakaian','Pakaian pria, wanita dan anak-anak','aktif'),(3,'Makanan','Makanan ringan dan kebutuhan sehari-hari','aktif'),(4,'Minuman','Minuman dalam kemasan','aktif'),(5,'Perabotan','Perabotan rumah tangga','aktif'),(6,'Olahraga','Alat olahraga dan fitness','aktif'),(7,'Kesehatan','Produk kesehatan dan kecantikan','aktif'),(8,'Buku','Buku dan alat tulis','aktif'),(9,'Mainan','Mainan anak-anak','aktif'),(10,'Aksesoris','Aksesoris fashion dan gadget','aktif');

#
# Structure for table "pelanggan"
#

CREATE TABLE `pelanggan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_pelanggan` varchar(20) NOT NULL,
  `nama_pelanggan` varchar(100) NOT NULL,
  `alamat` text DEFAULT NULL,
  `telepon` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `status` enum('aktif','nonaktif') DEFAULT 'aktif',
  `tanggal_daftar` date DEFAULT curdate(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `kode_pelanggan` (`kode_pelanggan`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

#
# Data for table "pelanggan"
#

INSERT INTO `pelanggan` VALUES (1,'PLG001','Budi Santoso','Jl. Mangga No. 11, Jakarta','081234567890','budi@email.com','aktif','2025-08-25'),(2,'PLG002','Siti Rahayu','Jl. Jeruk No. 22, Jakarta','081234567891','siti@email.com','aktif','2025-08-25'),(3,'PLG003','Ahmad Fauzi','Jl. Apel No. 33, Jakarta','081234567892','ahmad@email.com','aktif','2025-08-25'),(4,'PLG004','Dewi Anggraini','Jl. Melon No. 44, Jakarta','081234567893','dewi@email.com','aktif','2025-08-25'),(5,'PLG005','Rudi Hermawan','Jl. Semangka No. 55, Jakarta','081234567894','rudi@email.com','aktif','2025-08-25');

#
# Structure for table "pengaturan"
#

CREATE TABLE `pengaturan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_aplikasi` varchar(100) DEFAULT 'Aplikasi Kasir',
  `logo_aplikasi` varchar(255) DEFAULT 'logo.png',
  `nama_bisnis` varchar(100) DEFAULT 'Nama Bisnis',
  `alamat_bisnis` text DEFAULT NULL,
  `telepon_bisnis` varchar(20) DEFAULT NULL,
  `footer_text` varchar(255) DEFAULT 'c 2023 Aplikasi Kasir',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

#
# Data for table "pengaturan"
#

INSERT INTO `pengaturan` VALUES (1,'Aplikasi Kasir','logo.png','Toko Serba Ada','Jl. Merdeka No. 123, Jakarta','(021) 1234567','c 2023 Toko Serba Ada');

#
# Structure for table "pengguna"
#

CREATE TABLE `pengguna` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `level` enum('admin','kasir') DEFAULT 'kasir',
  `status` enum('aktif','nonaktif') DEFAULT 'aktif',
  `tanggal_dibuat` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

#
# Data for table "pengguna"
#

INSERT INTO `pengguna` VALUES (1,'admin','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','Administrator Utama','admin','aktif','2025-08-25 22:41:44'),(2,'kasir1','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','Kasir Pertama','kasir','aktif','2025-08-25 22:41:44'),(3,'kasir2','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','Kasir Kedua','kasir','aktif','2025-08-25 22:41:44');

#
# Structure for table "satuan"
#

CREATE TABLE `satuan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_satuan` varchar(50) NOT NULL,
  `status` enum('aktif','nonaktif') DEFAULT 'aktif',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

#
# Data for table "satuan"
#

INSERT INTO `satuan` VALUES (1,'Pcs','aktif'),(2,'Box','aktif'),(3,'Pack','aktif'),(4,'Lusin','aktif'),(5,'Karton','aktif'),(6,'Gram','aktif'),(7,'Kg','aktif'),(8,'Liter','aktif'),(9,'Meter','aktif'),(10,'Unit','aktif');

#
# Structure for table "produk"
#

CREATE TABLE `produk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_produk` varchar(20) NOT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `kategori_id` int(11) NOT NULL,
  `satuan_id` int(11) NOT NULL,
  `harga_beli` decimal(15,2) NOT NULL,
  `harga_jual` decimal(15,2) NOT NULL,
  `stok` int(11) DEFAULT 0,
  `minimal_stok` int(11) DEFAULT 5,
  `status` enum('aktif','nonaktif') DEFAULT 'aktif',
  PRIMARY KEY (`id`),
  UNIQUE KEY `kode_produk` (`kode_produk`),
  KEY `kategori_id` (`kategori_id`),
  KEY `satuan_id` (`satuan_id`),
  CONSTRAINT `produk_ibfk_1` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id`),
  CONSTRAINT `produk_ibfk_2` FOREIGN KEY (`satuan_id`) REFERENCES `satuan` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

#
# Data for table "produk"
#

INSERT INTO `produk` VALUES (1,'PRD001','TV LED 32 inch',1,1,1800000.00,2200000.00,15,5,'aktif'),(2,'PRD002','Kemeja Lengan Panjang',2,1,120000.00,150000.00,30,5,'aktif'),(3,'PRD003','Biskuit Coklat',3,6,8000.00,10000.00,50,5,'aktif'),(4,'PRD004','Air Mineral 600ml',4,1,3000.00,5000.00,100,5,'aktif'),(5,'PRD005','Meja Kayu Minimalis',5,1,450000.00,600000.00,8,5,'aktif'),(6,'PRD006','Dumbell 5kg',6,1,90000.00,120000.00,20,5,'aktif'),(7,'PRD007','Vitamin C 1000mg',7,1,50000.00,75000.00,40,5,'aktif'),(8,'PRD008','Buku Tulis 100hlm',8,1,6000.00,8000.00,80,5,'aktif'),(9,'PRD009','Lego Classic',9,1,150000.00,200000.00,12,5,'aktif'),(10,'PRD010','Case HP Samsung',10,1,40000.00,60000.00,25,5,'aktif');

#
# Structure for table "keranjang"
#

CREATE TABLE `keranjang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` varchar(100) NOT NULL,
  `produk_id` int(11) NOT NULL,
  `harga` decimal(15,2) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `diskon_produk` decimal(15,2) DEFAULT 0.00,
  `sub_total` decimal(15,2) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `produk_id` (`produk_id`),
  CONSTRAINT `keranjang_ibfk_1` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

#
# Data for table "keranjang"
#


#
# Structure for table "transaksi"
#

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_transaksi` varchar(20) NOT NULL,
  `pelanggan_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `tanggal_transaksi` datetime DEFAULT current_timestamp(),
  `total_item` int(11) DEFAULT 0,
  `total_harga` decimal(15,2) DEFAULT 0.00,
  `diskon` decimal(15,2) DEFAULT 0.00,
  `total_bayar` decimal(15,2) DEFAULT 0.00,
  `tunai` decimal(15,2) DEFAULT 0.00,
  `kembalian` decimal(15,2) DEFAULT 0.00,
  `catatan` text DEFAULT NULL,
  `status` enum('selesai','batal') DEFAULT 'selesai',
  PRIMARY KEY (`id`),
  UNIQUE KEY `kode_transaksi` (`kode_transaksi`),
  KEY `pelanggan_id` (`pelanggan_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`pelanggan_id`) REFERENCES `pelanggan` (`id`),
  CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `pengguna` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

#
# Data for table "transaksi"
#


#
# Structure for table "transaksi_detail"
#

CREATE TABLE `transaksi_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transaksi_id` int(11) NOT NULL,
  `produk_id` int(11) NOT NULL,
  `harga` decimal(15,2) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `diskon_produk` decimal(15,2) DEFAULT 0.00,
  `sub_total` decimal(15,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `transaksi_id` (`transaksi_id`),
  KEY `produk_id` (`produk_id`),
  CONSTRAINT `transaksi_detail_ibfk_1` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`id`) ON DELETE CASCADE,
  CONSTRAINT `transaksi_detail_ibfk_2` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

#
# Data for table "transaksi_detail"
#

