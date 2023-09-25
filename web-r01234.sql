-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 25, 2023 at 01:27 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web-r01234`
--

-- --------------------------------------------------------

--
-- Table structure for table `aksesoris`
--

CREATE TABLE `aksesoris` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_aksesoris` varchar(255) NOT NULL,
  `kategori_id` bigint(20) UNSIGNED NOT NULL,
  `satuan_id` bigint(20) UNSIGNED NOT NULL,
  `nama_aksesoris` varchar(255) NOT NULL,
  `merk_aksesoris` varchar(255) NOT NULL,
  `gambar_aksesoris` varchar(255) NOT NULL,
  `harga_aksesoris` varchar(255) NOT NULL,
  `deskripsi_aksesoris` longtext NOT NULL,
  `stok_aksesoris` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `aksesoris`
--

INSERT INTO `aksesoris` (`id`, `kode_aksesoris`, `kategori_id`, `satuan_id`, `nama_aksesoris`, `merk_aksesoris`, `gambar_aksesoris`, `harga_aksesoris`, `deskripsi_aksesoris`, `stok_aksesoris`, `created_at`, `updated_at`) VALUES
(3, 'AKS001', 2, 3, 'Athena TV', 'Polytron', 'images/Aksesoris-Athena-TV-iU8j.jpg', '300000', '<p>Mantap</p>', '92', '2023-08-10 05:26:18', '2023-08-10 05:50:00');

-- --------------------------------------------------------

--
-- Table structure for table `barangs`
--

CREATE TABLE `barangs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_barang` varchar(255) NOT NULL,
  `kategori_id` bigint(20) UNSIGNED NOT NULL,
  `satuan_id` bigint(20) UNSIGNED NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `merk_barang` varchar(255) NOT NULL,
  `gambar_barang` varchar(255) NOT NULL,
  `harga_barang` varchar(255) NOT NULL,
  `deskripsi_barang` longtext NOT NULL,
  `stok_barang` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `barangs`
--

INSERT INTO `barangs` (`id`, `kode_barang`, `kategori_id`, `satuan_id`, `nama_barang`, `merk_barang`, `gambar_barang`, `harga_barang`, `deskripsi_barang`, `stok_barang`, `created_at`, `updated_at`) VALUES
(4, 'BR001', 2, 3, 'TV 20 inch', 'Panasonic', 'images/Barang-TV-20-inch-KQVd.jpg', '2000000', '<p>Mantap</p>', '92', '2023-08-10 03:50:45', '2023-08-10 05:48:23');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kategoris`
--

CREATE TABLE `kategoris` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_kategori` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kategoris`
--

INSERT INTO `kategoris` (`id`, `nama_kategori`, `created_at`, `updated_at`) VALUES
(2, 'Elektronik', '2023-07-08 11:02:59', '2023-07-09 12:41:17'),
(3, 'Celana', '2023-07-08 11:03:04', '2023-07-08 11:03:04'),
(4, 'Jaket', '2023-07-08 11:03:08', '2023-07-08 11:03:08');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_07_05_205709_add_field_username_to_users', 2),
(6, '2023_07_05_212814_create_settings_table', 3),
(7, '2023_07_06_192732_create_kategoris_table', 4),
(8, '2023_07_06_192814_create_satuans_table', 4),
(9, '2023_07_07_031840_create_barangs_table', 5),
(10, '2023_07_09_184327_add_field_merk_to_barangs', 6),
(11, '2023_07_09_184829_create_aksesoris_table', 7),
(12, '2023_07_09_192142_create_pembelians_table', 8),
(13, '2023_07_10_003056_create_penjualans_table', 9),
(14, '2023_07_11_061912_create_penyewaans_table', 10),
(15, '2023_08_10_120751_add_field_alamat_to_settings', 11),
(16, '2023_08_25_171005_create_suratjalans_table', 12),
(17, '2023_08_25_171340_create_produk_suratjalans_table', 13);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pembelians`
--

CREATE TABLE `pembelians` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `no_referensi` varchar(255) NOT NULL,
  `barang_id` bigint(20) UNSIGNED DEFAULT NULL,
  `aksesoris_id` bigint(20) UNSIGNED DEFAULT NULL,
  `nama_supplier` varchar(255) NOT NULL,
  `harga` varchar(255) NOT NULL,
  `jumlah` varchar(255) NOT NULL,
  `total` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pembelians`
--

INSERT INTO `pembelians` (`id`, `no_referensi`, `barang_id`, `aksesoris_id`, `nama_supplier`, `harga`, `jumlah`, `total`, `created_at`, `updated_at`) VALUES
(6, 'INV230810001', 4, NULL, 'Herry', '1000000', '100', '100000000', '2023-08-10 04:12:33', '2023-08-10 04:12:33'),
(7, 'INV230810002', NULL, 3, 'Herry', '250000', '100', '25000000', '2023-08-10 05:26:46', '2023-08-10 05:26:46');

-- --------------------------------------------------------

--
-- Table structure for table `penjualans`
--

CREATE TABLE `penjualans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `no_referensi` varchar(255) NOT NULL,
  `barang_id` bigint(20) UNSIGNED DEFAULT NULL,
  `aksesoris_id` bigint(20) UNSIGNED DEFAULT NULL,
  `nama_pembeli` varchar(255) NOT NULL,
  `harga` varchar(255) NOT NULL,
  `jumlah` varchar(255) NOT NULL,
  `total` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `penjualans`
--

INSERT INTO `penjualans` (`id`, `no_referensi`, `barang_id`, `aksesoris_id`, `nama_pembeli`, `harga`, `jumlah`, `total`, `created_at`, `updated_at`) VALUES
(6, 'TR230810001', 4, NULL, 'Terry Deff', '2000000', '2', '4000000', '2023-08-10 04:12:45', '2023-08-10 04:12:45'),
(7, 'TR230810002', NULL, 3, 'Terry Deff', '300000', '3', '900000', '2023-08-10 05:27:03', '2023-08-10 05:27:03'),
(8, 'TR230810003', 4, NULL, 'Terry Deff', '2300000', '1', '2300000', '2023-08-10 05:46:11', '2023-08-10 05:46:11'),
(9, 'TR230810004', 4, NULL, 'Terry Deff', '2200000', '5', '11000000', '2023-08-10 05:48:23', '2023-08-10 05:48:23'),
(10, 'TR230810005', NULL, 3, 'Terry Deff', '500000', '5', '2500000', '2023-08-10 05:50:00', '2023-08-10 05:50:00');

-- --------------------------------------------------------

--
-- Table structure for table `penyewaans`
--

CREATE TABLE `penyewaans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `no_referensi` varchar(255) NOT NULL,
  `barang_id` bigint(20) UNSIGNED DEFAULT NULL,
  `nama_penyewa` varchar(255) NOT NULL,
  `no_telp` varchar(255) NOT NULL,
  `jumlah` varchar(255) NOT NULL,
  `dari` date NOT NULL,
  `sampai` date NOT NULL,
  `total` varchar(255) NOT NULL,
  `status` enum('0','1','2','3') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `penyewaans`
--

INSERT INTO `penyewaans` (`id`, `no_referensi`, `barang_id`, `nama_penyewa`, `no_telp`, `jumlah`, `dari`, `sampai`, `total`, `status`, `created_at`, `updated_at`) VALUES
(4, 'SW230825001', 4, 'Terry', '089128123991', '1', '2023-08-25', '2023-08-30', '5000000', '2', '2023-08-25 11:16:22', '2023-08-25 11:16:30');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `produk_suratjalans`
--

CREATE TABLE `produk_suratjalans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `suratjalan_id` bigint(20) UNSIGNED NOT NULL,
  `barang_id` bigint(20) UNSIGNED NOT NULL,
  `harga` varchar(255) NOT NULL,
  `jumlah` varchar(255) NOT NULL,
  `total` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `produk_suratjalans`
--

INSERT INTO `produk_suratjalans` (`id`, `suratjalan_id`, `barang_id`, `harga`, `jumlah`, `total`, `created_at`, `updated_at`) VALUES
(3, 4, 4, '2000000', '2', '4000000', '2023-08-25 11:10:46', '2023-08-25 11:10:46');

-- --------------------------------------------------------

--
-- Table structure for table `satuans`
--

CREATE TABLE `satuans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_satuan` varchar(255) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `satuans`
--

INSERT INTO `satuans` (`id`, `nama_satuan`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 'Lsn', 'Lusin', '2023-07-06 20:07:15', '2023-07-06 20:14:17'),
(3, 'Pcs', 'Pcs', '2023-07-08 11:04:40', '2023-07-08 11:04:40');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_website` varchar(255) NOT NULL,
  `nama_toko` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `no_hp` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `logo` varchar(255) NOT NULL,
  `favicon` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `nama_website`, `nama_toko`, `email`, `no_hp`, `alamat`, `logo`, `favicon`, `created_at`, `updated_at`) VALUES
(1, 'Inventaris', 'CV. MULTI USAHA', 'multiusahacv@gmail.com', '0892829991', 'Kp. Pegadungan, RT 02 / RW 03 No. 15\r\nSertajaya, Cikarang Timur, Bekasi, Jawa Barat', 'images/Logo-Inventaris-RT9Y.png', 'images/Favicon-Inventaris-5VTM.png', '2023-07-05 15:02:55', '2023-08-10 05:19:47');

-- --------------------------------------------------------

--
-- Table structure for table `suratjalans`
--

CREATE TABLE `suratjalans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `no_po` varchar(255) NOT NULL,
  `tanggal_po` varchar(255) NOT NULL,
  `no_surat` varchar(255) NOT NULL,
  `tanggal` varchar(255) NOT NULL,
  `no_mobil` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suratjalans`
--

INSERT INTO `suratjalans` (`id`, `no_po`, `tanggal_po`, `no_surat`, `tanggal`, `no_mobil`, `created_at`, `updated_at`) VALUES
(4, 'PO-0001', '2023-08-25', 'SRTJ-00001', '2023-08-25', 'M 123 D', '2023-08-25 11:10:46', '2023-08-25 11:10:46');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `level` enum('Superadmin','Administrator','Operator') NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `email_verified_at`, `level`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Superadmin', 'superadmin', 'superadmin@gmail.com', NULL, 'Superadmin', '$2y$10$whOsQn4rpByXra0eci/7Vu1kVPV.IivAhSKjeP.5yW8wC6LY9.nTW', NULL, '2023-07-05 14:16:20', '2023-07-05 14:16:20'),
(4, 'Administrator', 'administrator', 'admin@example.com', NULL, 'Administrator', '$2y$10$Fq8HY8G.1ru/0JFj767Js.ov5dGi.lc1AlEe7c/sLC07sCbC/Xeau', NULL, '2023-07-05 20:06:33', '2023-07-05 20:06:33'),
(5, 'Operator', 'operator', 'operator@example.com', NULL, 'Operator', '$2y$10$5D9scKUUSngrwbNLcI/tP.ENX0NHvNfypKZYHN1T3WZgg5t7qrwma', NULL, '2023-07-05 20:06:55', '2023-07-05 20:06:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aksesoris`
--
ALTER TABLE `aksesoris`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aksesoris_kategori_id_foreign` (`kategori_id`),
  ADD KEY `aksesoris_satuan_id_foreign` (`satuan_id`);

--
-- Indexes for table `barangs`
--
ALTER TABLE `barangs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `barangs_kategori_id_foreign` (`kategori_id`),
  ADD KEY `barangs_satuan_id_foreign` (`satuan_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `kategoris`
--
ALTER TABLE `kategoris`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `pembelians`
--
ALTER TABLE `pembelians`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pembelians_barang_id_foreign` (`barang_id`),
  ADD KEY `pembelians_aksesoris_id_foreign` (`aksesoris_id`);

--
-- Indexes for table `penjualans`
--
ALTER TABLE `penjualans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `penjualans_barang_id_foreign` (`barang_id`),
  ADD KEY `penjualans_aksesoris_id_foreign` (`aksesoris_id`);

--
-- Indexes for table `penyewaans`
--
ALTER TABLE `penyewaans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `penyewaans_barang_id_foreign` (`barang_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `produk_suratjalans`
--
ALTER TABLE `produk_suratjalans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produk_suratjalans_suratjalan_id_foreign` (`suratjalan_id`),
  ADD KEY `produk_suratjalans_barang_id_foreign` (`barang_id`);

--
-- Indexes for table `satuans`
--
ALTER TABLE `satuans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suratjalans`
--
ALTER TABLE `suratjalans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aksesoris`
--
ALTER TABLE `aksesoris`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `barangs`
--
ALTER TABLE `barangs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategoris`
--
ALTER TABLE `kategoris`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `pembelians`
--
ALTER TABLE `pembelians`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `penjualans`
--
ALTER TABLE `penjualans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `penyewaans`
--
ALTER TABLE `penyewaans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `produk_suratjalans`
--
ALTER TABLE `produk_suratjalans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `satuans`
--
ALTER TABLE `satuans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `suratjalans`
--
ALTER TABLE `suratjalans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `aksesoris`
--
ALTER TABLE `aksesoris`
  ADD CONSTRAINT `aksesoris_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `kategoris` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `aksesoris_satuan_id_foreign` FOREIGN KEY (`satuan_id`) REFERENCES `satuans` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `barangs`
--
ALTER TABLE `barangs`
  ADD CONSTRAINT `barangs_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `kategoris` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `barangs_satuan_id_foreign` FOREIGN KEY (`satuan_id`) REFERENCES `satuans` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pembelians`
--
ALTER TABLE `pembelians`
  ADD CONSTRAINT `pembelians_aksesoris_id_foreign` FOREIGN KEY (`aksesoris_id`) REFERENCES `aksesoris` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pembelians_barang_id_foreign` FOREIGN KEY (`barang_id`) REFERENCES `barangs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `penjualans`
--
ALTER TABLE `penjualans`
  ADD CONSTRAINT `penjualans_aksesoris_id_foreign` FOREIGN KEY (`aksesoris_id`) REFERENCES `aksesoris` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `penjualans_barang_id_foreign` FOREIGN KEY (`barang_id`) REFERENCES `barangs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `penyewaans`
--
ALTER TABLE `penyewaans`
  ADD CONSTRAINT `penyewaans_barang_id_foreign` FOREIGN KEY (`barang_id`) REFERENCES `barangs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `produk_suratjalans`
--
ALTER TABLE `produk_suratjalans`
  ADD CONSTRAINT `produk_suratjalans_barang_id_foreign` FOREIGN KEY (`barang_id`) REFERENCES `barangs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `produk_suratjalans_suratjalan_id_foreign` FOREIGN KEY (`suratjalan_id`) REFERENCES `suratjalans` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
