-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 02, 2026 at 07:34 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jwp2-inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `nama`, `username`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin', 'admin@meyjuice.com', '$2y$12$u9z4fQyJzqM8jR2rXWQ3ROwB4zR4LzP0R6JQW7wF5mQm8wYq2vL8e', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `buah_beku`
--

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `buah_beku`
--

INSERT INTO `buah_beku` (`id`, `kategori_id`, `kode_produk`, `nama_produk`, `stok`, `satuan`, `harga`, `gambar`, `created_at`, `updated_at`) VALUES
(1, 1, 'FB001', 'Frozen Strawberry', 120, 'kg', 85000.00, NULL, NULL, NULL),
(2, 1, 'FB002', 'Frozen Mango', 95, 'kg', 75000.00, NULL, NULL, NULL),
(3, 1, 'FB003', 'Frozen Dragon Fruit', 150, 'kg', 70000.00, NULL, NULL, NULL),
(4, 1, 'FB004', 'Frozen Blackberry', 20, 'kg', 120000.00, NULL, NULL, NULL),
(5, 2, 'SM001', 'Mix Berry Smoothie', 45, 'kg', 95000.00, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `buah_beku_keluar`
--

CREATE TABLE `buah_beku_keluar` (
  `id` bigint UNSIGNED NOT NULL,
  `buah_beku_id` bigint UNSIGNED NOT NULL,
  `jumlah` int NOT NULL,
  `tanggal_keluar` date NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `buah_beku_keluar`
--

INSERT INTO `buah_beku_keluar` (`id`, `buah_beku_id`, `jumlah`, `tanggal_keluar`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 1, 10, '2026-05-05', 'Pesanan pelanggan', NULL, NULL),
(2, 2, 5, '2026-05-06', 'Pesanan pelanggan', NULL, NULL),
(3, 3, 15, '2026-05-07', 'Pesanan pelanggan', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `buah_beku_masuk`
--

CREATE TABLE `buah_beku_masuk` (
  `id` bigint UNSIGNED NOT NULL,
  `buah_beku_id` bigint UNSIGNED NOT NULL,
  `jumlah` int NOT NULL,
  `tanggal_masuk` date NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `buah_beku_masuk`
--

INSERT INTO `buah_beku_masuk` (`id`, `buah_beku_id`, `jumlah`, `tanggal_masuk`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 1, 50, '2026-05-01', 'Pembelian supplier', NULL, NULL),
(2, 2, 40, '2026-05-02', 'Pembelian supplier', NULL, NULL),
(3, 3, 30, '2026-05-03', 'Restock gudang', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kategori_buah_beku`
--

CREATE TABLE `kategori_buah_beku` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_kategori` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kategori_buah_beku`
--

INSERT INTO `kategori_buah_beku` (`id`, `nama_kategori`, `created_at`, `updated_at`) VALUES
(1, 'Frozen Fruit', NULL, NULL),
(2, 'Smoothie Mix', NULL, NULL),
(3, 'Puree Buah', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `buah_beku`
--
ALTER TABLE `buah_beku`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_produk` (`kode_produk`),
  ADD KEY `fk_buah_kategori` (`kategori_id`);

--
-- Indexes for table `buah_beku_keluar`
--
ALTER TABLE `buah_beku_keluar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_keluar_buah` (`buah_beku_id`);

--
-- Indexes for table `buah_beku_masuk`
--
ALTER TABLE `buah_beku_masuk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_masuk_buah` (`buah_beku_id`);

--
-- Indexes for table `kategori_buah_beku`
--
ALTER TABLE `kategori_buah_beku`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `buah_beku`
--
ALTER TABLE `buah_beku`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `buah_beku_keluar`
--
ALTER TABLE `buah_beku_keluar`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `buah_beku_masuk`
--
ALTER TABLE `buah_beku_masuk`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kategori_buah_beku`
--
ALTER TABLE `kategori_buah_beku`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `buah_beku`
--
ALTER TABLE `buah_beku`
  ADD CONSTRAINT `fk_buah_kategori` FOREIGN KEY (`kategori_id`) REFERENCES `kategori_buah_beku` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `buah_beku_keluar`
--
ALTER TABLE `buah_beku_keluar`
  ADD CONSTRAINT `fk_keluar_buah` FOREIGN KEY (`buah_beku_id`) REFERENCES `buah_beku` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `buah_beku_masuk`
--
ALTER TABLE `buah_beku_masuk`
  ADD CONSTRAINT `fk_masuk_buah` FOREIGN KEY (`buah_beku_id`) REFERENCES `buah_beku` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
