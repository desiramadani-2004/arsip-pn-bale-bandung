-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 13, 2026 at 03:37 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_earchive_pn`
--

-- --------------------------------------------------------

--
-- Table structure for table `arsips`
--

CREATE TABLE `arsips` (
  `id` bigint UNSIGNED NOT NULL,
  `nomor_dokumen` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `judul_arsip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori_dokumen` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deskripsi_metadata` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_akses` enum('public','private') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'private',
  `kategori_bagian_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `file_size` bigint DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `arsips`
--

INSERT INTO `arsips` (`id`, `nomor_dokumen`, `judul_arsip`, `kategori_dokumen`, `deskripsi_metadata`, `file_path`, `status_akses`, `kategori_bagian_id`, `user_id`, `created_at`, `updated_at`, `file_size`) VALUES
(1, '001desicantik', 'nyoba', 'Surat Keputusan', 'jbjbhjvb', 'dokumen_arsip/1778634670_Desi Ramadani_20123042_ETS Mobile Programming Lanjut.pdf', 'private', 2, 5, '2026-05-13 01:02:16', '2026-05-13 01:11:10', 8262),
(5, 'W11.U16/45/HK.01/05/2025', 'nyoba', 'Surat Keputusan', 'dnlkadmjlka', 'dokumen_arsip/1778638849_Kelompok 4 _ BonitaSoft.pdf', 'private', 6, 10, '2026-05-13 02:20:49', '2026-05-13 02:20:49', 7628);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hak_akses`
--

CREATE TABLE `hak_akses` (
  `id` bigint UNSIGNED NOT NULL,
  `grup_pemilik` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `grup_pengakses` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bisa_lihat` tinyint(1) NOT NULL DEFAULT '0',
  `bisa_komentar` tinyint(1) NOT NULL DEFAULT '0',
  `bisa_edit_hapus` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hak_akses`
--

INSERT INTO `hak_akses` (`id`, `grup_pemilik`, `grup_pengakses`, `bisa_lihat`, `bisa_komentar`, `bisa_edit_hapus`, `created_at`, `updated_at`) VALUES
(1, 'Kepaniteraan Pidana', 'Pimpinan', 1, 1, 0, '2026-05-11 06:38:48', '2026-05-11 06:38:48'),
(2, 'Kepaniteraan Pidana', 'Kepaniteraan', 1, 1, 0, '2026-05-11 06:38:48', '2026-05-11 06:38:48'),
(3, 'Kepaniteraan Perdata', 'Kepaniteraan', 1, 1, 0, '2026-05-11 06:38:48', '2026-05-11 06:38:48'),
(4, 'Kepaniteraan Hukum', 'Kepaniteraan', 1, 1, 0, '2026-05-11 06:38:48', '2026-05-11 06:38:48'),
(5, 'Umum dan Keuangan', 'Kesekretariatan', 1, 1, 0, '2026-05-11 06:38:48', '2026-05-11 06:38:48'),
(6, 'Ortala', 'Kesekretariatan', 1, 1, 0, '2026-05-11 06:38:48', '2026-05-11 06:38:48'),
(7, 'PTIP', 'Kesekretariatan', 1, 1, 0, '2026-05-11 06:38:48', '2026-05-11 06:38:48');

-- --------------------------------------------------------

--
-- Table structure for table `kategori_bagians`
--

CREATE TABLE `kategori_bagians` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_bagian` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kelompok` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kategori_bagians`
--

INSERT INTO `kategori_bagians` (`id`, `nama_bagian`, `kelompok`, `created_at`, `updated_at`) VALUES
(1, 'Pidana', 'kepaniteraan', '2026-05-11 04:11:55', '2026-05-11 04:11:55'),
(2, 'Perdata', 'kepaniteraan', '2026-05-11 04:11:55', '2026-05-11 04:11:55'),
(3, 'Hukum', 'kepaniteraan', '2026-05-11 04:11:55', '2026-05-11 04:11:55'),
(4, 'Umum dan Keuangan', 'kesekretariatan', '2026-05-11 04:11:55', '2026-05-11 04:11:55'),
(5, 'Ortala', 'kesekretariatan', '2026-05-11 04:11:55', '2026-05-11 04:11:55'),
(6, 'PTIP', 'kesekretariatan', '2026-05-11 04:11:55', '2026-05-11 04:11:55');

-- --------------------------------------------------------

--
-- Table structure for table `kategori_dokumens`
--

CREATE TABLE `kategori_dokumens` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `milik_grup` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `komentars`
--

CREATE TABLE `komentars` (
  `id` bigint UNSIGNED NOT NULL,
  `arsip_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `isi_komentar` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `komentars`
--

INSERT INTO `komentars` (`id`, `arsip_id`, `user_id`, `isi_komentar`, `created_at`, `updated_at`) VALUES
(4, 5, 7, 'revisi', '2026-05-13 02:21:46', '2026-05-13 02:21:46');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2026_03_28_144604_create_kategori_bagians_table', 1),
(6, '2026_03_28_144623_create_arsips_table', 1),
(7, '2026_03_28_154911_add_grup_to_users_table', 1),
(8, '2026_04_06_141554_add_file_size_to_arsips_table', 1),
(9, '2026_05_05_025139_add_kategori_dokumen_to_arsips_table', 1),
(10, '2026_05_05_154937_add_nohp_to_users_table', 1),
(11, '2026_05_05_154947_create_hak_akses_table', 1),
(12, '2026_05_05_154956_create_komentars_table', 1),
(13, '2026_05_05_155007_create_kategori_dokumens_table', 1),
(14, '2026_05_06_110452_add_username_to_users_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_hp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grup` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `username`, `no_hp`, `grup`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin PNBB', 'admin@pnbb.com', NULL, '85795280947', 'Admin', NULL, '$2y$12$Qhz.Fby.dVLYV8amp4qp.eLZXFZ0Pmmvx.TAqaEhL4MkoakSF6qji', NULL, '2026-05-11 04:11:55', '2026-05-11 04:59:22'),
(2, 'Ketua/Wakil', 'pimpinan@pn.go.id', NULL, '85795280947', 'Pimpinan', NULL, '$2y$12$rb3j66kFzOAzRtAO7uiHrute8cEC.bc6kdJHTKwpE0R9m90G0Z2Ki', NULL, '2026-05-11 04:11:56', '2026-05-11 04:59:41'),
(3, 'Panitera', 'panitera@pn.go.id', NULL, '85795280947', 'Kepaniteraan', NULL, '$2y$12$UWThG8eQFgONugtdkfFDmev0we463ogOOptU1H8bDu0QRATU.jY6O', NULL, '2026-05-11 04:11:56', '2026-05-11 05:00:18'),
(4, 'Staf Pidana', 'pidana@pn.go.id', NULL, '85795280947', 'Kepaniteraan Pidana', NULL, '$2y$12$du7quY5Wgl.XlaI52mc4ieCzcEpS9v9wjuKVGEW1t3fnCMbU1wzqm', NULL, '2026-05-11 04:11:56', '2026-05-11 05:00:41'),
(5, 'Staf Perdata', 'perdata@pn.go.id', NULL, '85795280947', 'Kepaniteraan Perdata', NULL, '$2y$12$O2DyztPJoryVOSPYyjTgNO.HOVXTu87ov37D4wIsEMAJPwmT9muda', NULL, '2026-05-11 04:11:57', '2026-05-11 05:01:18'),
(6, 'Staf Hukum', 'hukum@pn.go.id', NULL, '85795280947', 'Kepaniteraan Hukum', NULL, '$2y$12$Qw9oBkIvZJfaTG3TR1LFMuzODRObAGNKRbgnKRsHvGaBZ4VSkYNCG', NULL, '2026-05-11 04:11:57', '2026-05-11 05:01:41'),
(7, 'Sekretaris', 'sekretaris@pn.go.id', NULL, '85795280947', 'Kesekretariatan', NULL, '$2y$12$yQmF2DLTyTjQgGyC8tj7O.KoUAU52h8E9PB/TlFxTqGQruq6J1cay', NULL, '2026-05-11 04:11:57', '2026-05-11 05:02:04'),
(8, 'Staf Umum', 'umum@pn.go.id', NULL, '85795280947', 'Umum dan Keuangan', NULL, '$2y$12$EROcj16ybQ7quIvTFRm0sej6UEmMi0jVdPbVMLxX6KfdjihGWtVma', NULL, '2026-05-11 04:11:58', '2026-05-11 05:02:19'),
(9, 'Staf Ortala', 'ortala@pn.go.id', NULL, '85795280947', 'Ortala', NULL, '$2y$12$bldIN2lgoHcwkLWXfgtcrOIfnUwZpEwfeBxhux7ARk1b4CToCXFT.', NULL, '2026-05-11 04:11:58', '2026-05-11 05:02:40'),
(10, 'Staf PTIP', 'ptip@pn.go.id', NULL, '85795280947', 'PTIP', NULL, '$2y$12$nesEP4D4a6BDYwkyOASnC.hIsf1fUQC.68pDirrIeB/OPfFvh88za', NULL, '2026-05-11 04:11:58', '2026-05-11 05:02:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `arsips`
--
ALTER TABLE `arsips`
  ADD PRIMARY KEY (`id`),
  ADD KEY `arsips_kategori_bagian_id_foreign` (`kategori_bagian_id`),
  ADD KEY `arsips_user_id_foreign` (`user_id`);
ALTER TABLE `arsips` ADD FULLTEXT KEY `arsips_nomor_dokumen_judul_arsip_deskripsi_metadata_fulltext` (`nomor_dokumen`,`judul_arsip`,`deskripsi_metadata`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `hak_akses`
--
ALTER TABLE `hak_akses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori_bagians`
--
ALTER TABLE `kategori_bagians`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori_dokumens`
--
ALTER TABLE `kategori_dokumens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `komentars`
--
ALTER TABLE `komentars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `komentars_arsip_id_foreign` (`arsip_id`),
  ADD KEY `komentars_user_id_foreign` (`user_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `arsips`
--
ALTER TABLE `arsips`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hak_akses`
--
ALTER TABLE `hak_akses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `kategori_bagians`
--
ALTER TABLE `kategori_bagians`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `kategori_dokumens`
--
ALTER TABLE `kategori_dokumens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `komentars`
--
ALTER TABLE `komentars`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `arsips`
--
ALTER TABLE `arsips`
  ADD CONSTRAINT `arsips_kategori_bagian_id_foreign` FOREIGN KEY (`kategori_bagian_id`) REFERENCES `kategori_bagians` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `arsips_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `komentars`
--
ALTER TABLE `komentars`
  ADD CONSTRAINT `komentars_arsip_id_foreign` FOREIGN KEY (`arsip_id`) REFERENCES `arsips` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `komentars_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
