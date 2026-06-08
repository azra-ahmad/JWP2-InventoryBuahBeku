-- MeyJuice Inventory - XAMPP Compatible
-- Fixed: collation utf8mb4_0900_ai_ci -> utf8mb4_general_ci
-- Fixed: tambah CREATE DATABASE + USE
-- Fixed: urutan insert (kategori dulu sebelum buah_beku karena FK)

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET FOREIGN_KEY_CHECKS = 0;
START TRANSACTION;
SET time_zone = "+00:00";
SET NAMES utf8mb4;

CREATE DATABASE IF NOT EXISTS `jwp2-inventory` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `jwp2-inventory`;

-- --------------------------------------------------------
-- Table: kategori_buah_beku (dibuat duluan karena FK)
-- --------------------------------------------------------

CREATE TABLE `kategori_buah_beku` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_kategori` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `kategori_buah_beku` (`id`, `nama_kategori`, `created_at`, `updated_at`) VALUES
(1, 'Frozen Fruits', NULL, '2026-06-08 03:22:08'),
(2, 'Smoothie Mix', NULL, NULL),
(3, 'Puree Buah', NULL, NULL);

-- --------------------------------------------------------
-- Table: admin
-- --------------------------------------------------------

CREATE TABLE `admin` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `admin` (`id`, `nama`, `username`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin', 'admin@meyjuice.com', '$2y$12$po5k8DJO7WKw6UbC4rJIF.NOVtDXJvyYvfnQTuFALX95hik0fqOmO', NULL, NULL),
(2, 'Azra', 'azra', 'ajraahmad@gmail.com', '$2y$12$YZ5skeFKBXkGVKlbXgx0.Oeeesmhq09Aps0hAAYYo9H6twjzUxccu', '2026-06-02 21:34:19', '2026-06-03 00:33:39');

-- --------------------------------------------------------
-- Table: buah_beku
-- --------------------------------------------------------

CREATE TABLE `buah_beku` (
  `id` bigint UNSIGNED NOT NULL,
  `kategori_id` bigint UNSIGNED NOT NULL,
  `kode_produk` varchar(20) NOT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `stok` int NOT NULL DEFAULT '0',
  `satuan` varchar(20) NOT NULL DEFAULT 'kg',
  `harga` decimal(12,2) NOT NULL DEFAULT '0.00',
  `gambar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `buah_beku` (`id`, `kategori_id`, `kode_produk`, `nama_produk`, `stok`, `satuan`, `harga`, `gambar`, `created_at`, `updated_at`) VALUES
(1, 1, 'FB001', 'Frozen Strawberry', 120, 'kg', 85000.00, NULL, NULL, NULL),
(2, 1, 'FB002', 'Frozen Mango', 95, 'kg', 75000.00, NULL, NULL, NULL),
(3, 1, 'FB003', 'Frozen Dragon Fruit', 151, 'kg', 70000.00, NULL, NULL, '2026-06-02 19:25:26'),
(4, 1, 'FB004', 'Frozen Blackberry', 9, 'kg', 120000.00, 'products/XrbQy63DATG5XLjlRmAnvKPmVTfYNQD7DZ5OsgXI.jpg', NULL, '2026-06-08 03:23:08'),
(5, 2, 'SM001', 'Mix Berry Smoothie', 10, 'kg', 95000.00, NULL, NULL, '2026-06-08 03:29:15'),
(6, 3, 'PB001', 'Puree Buah Sirsak', 50, 'kg', 19000.00, NULL, '2026-06-04 23:16:06', '2026-06-05 06:33:01'),
(7, 1, 'FB009', 'Durian', 0, 'kg', 19000.00, NULL, '2026-06-05 06:20:31', '2026-06-08 03:25:04'),
(9, 1, 'Test003', 'Test7', 100, 'kg', 9000.00, NULL, '2026-06-05 06:37:03', '2026-06-05 06:38:13');

-- --------------------------------------------------------
-- Table: buah_beku_masuk
-- --------------------------------------------------------

CREATE TABLE `buah_beku_masuk` (
  `id` bigint UNSIGNED NOT NULL,
  `buah_beku_id` bigint UNSIGNED NOT NULL,
  `jumlah` int NOT NULL,
  `tanggal_masuk` date NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `buah_beku_masuk` (`id`, `buah_beku_id`, `jumlah`, `tanggal_masuk`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 1, 50, '2026-05-01', 'Pembelian supplier', NULL, NULL),
(2, 2, 40, '2026-05-02', 'Pembelian supplier', NULL, NULL),
(3, 3, 30, '2026-05-03', 'Restock gudang', NULL, NULL),
(4, 4, 20, '2026-05-13', 'Masuk nih', '2026-06-02 11:12:48', '2026-06-02 11:12:48'),
(5, 6, 10, '2026-06-03', 'Beli di pasar Induk', '2026-06-04 23:50:20', '2026-06-04 23:50:20'),
(6, 7, 10, '2026-06-05', 'test', '2026-06-05 06:20:53', '2026-06-05 06:20:53'),
(7, 6, 50, '2026-06-05', NULL, '2026-06-05 06:33:01', '2026-06-05 06:33:01'),
(8, 9, 90, '2026-06-05', NULL, '2026-06-05 06:38:13', '2026-06-05 06:38:13');

-- --------------------------------------------------------
-- Table: buah_beku_keluar
-- --------------------------------------------------------

CREATE TABLE `buah_beku_keluar` (
  `id` bigint UNSIGNED NOT NULL,
  `buah_beku_id` bigint UNSIGNED NOT NULL,
  `jumlah` int NOT NULL,
  `tanggal_keluar` date NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `buah_beku_keluar` (`id`, `buah_beku_id`, `jumlah`, `tanggal_keluar`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 1, 10, '2026-05-05', 'Pesanan pelanggan', NULL, NULL),
(2, 2, 5, '2026-05-06', 'Pesanan pelanggan', NULL, NULL),
(3, 3, 14, '2026-05-07', 'Pesanan pelanggan', NULL, '2026-06-02 19:25:26'),
(4, 4, 31, '2026-06-05', 'Si PT anu mau beli', '2026-06-04 21:44:52', '2026-06-04 21:44:52'),
(5, 6, 10, '2026-06-05', 'Si itu beli', '2026-06-05 00:01:02', '2026-06-05 00:01:02'),
(6, 7, 10, '2026-06-05', 'Baru bayar 50%', '2026-06-05 06:21:15', '2026-06-08 03:30:33'),
(7, 5, 35, '2026-06-08', 'Bu itu beli', '2026-06-08 03:23:35', '2026-06-08 03:30:19');

-- --------------------------------------------------------
-- Indexes
-- --------------------------------------------------------

ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

ALTER TABLE `kategori_buah_beku`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `buah_beku`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_produk` (`kode_produk`),
  ADD KEY `fk_buah_kategori` (`kategori_id`);

ALTER TABLE `buah_beku_masuk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_masuk_buah` (`buah_beku_id`);

ALTER TABLE `buah_beku_keluar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_keluar_buah` (`buah_beku_id`);

-- --------------------------------------------------------
-- AUTO_INCREMENT
-- --------------------------------------------------------

ALTER TABLE `admin`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `kategori_buah_beku`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

ALTER TABLE `buah_beku`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

ALTER TABLE `buah_beku_masuk`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

ALTER TABLE `buah_beku_keluar`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

-- --------------------------------------------------------
-- Foreign Keys
-- --------------------------------------------------------

ALTER TABLE `buah_beku`
  ADD CONSTRAINT `fk_buah_kategori` FOREIGN KEY (`kategori_id`) REFERENCES `kategori_buah_beku` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

ALTER TABLE `buah_beku_masuk`
  ADD CONSTRAINT `fk_masuk_buah` FOREIGN KEY (`buah_beku_id`) REFERENCES `buah_beku` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

ALTER TABLE `buah_beku_keluar`
  ADD CONSTRAINT `fk_keluar_buah` FOREIGN KEY (`buah_beku_id`) REFERENCES `buah_beku` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

SET FOREIGN_KEY_CHECKS = 1;
COMMIT;
