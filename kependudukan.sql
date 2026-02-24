-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: Feb 24, 2026 at 04:27 AM
-- Server version: 8.0.30
-- PHP Version: 8.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kependudukan`
--

-- --------------------------------------------------------

--
-- Table structure for table `agendas`
--

CREATE TABLE `agendas` (
  `id` bigint UNSIGNED NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `tanggal_mulai` date NOT NULL,
  `tanggal_akhir` date DEFAULT NULL,
  `status` enum('active','inactive','closed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `agendas`
--

INSERT INTO `agendas` (`id`, `judul`, `deskripsi`, `tanggal_mulai`, `tanggal_akhir`, `status`, `created_at`, `updated_at`) VALUES
(1, 'rapat sincia', 'bahas sincia', '2026-02-20', '2026-02-21', 'active', '2026-02-20 08:51:17', '2026-02-20 08:51:17');

-- --------------------------------------------------------

--
-- Table structure for table `approvals`
--

CREATE TABLE `approvals` (
  `id` bigint UNSIGNED NOT NULL,
  `folder_id` bigint UNSIGNED NOT NULL,
  `admin_id` bigint UNSIGNED NOT NULL,
  `status` enum('approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'approved',
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `agenda_id` bigint UNSIGNED DEFAULT NULL,
  `folder_id` bigint UNSIGNED DEFAULT NULL,
  `nama_dokumen` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_dokumen` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Lainnya',
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ukuran_file` bigint NOT NULL,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `tahun` year DEFAULT NULL,
  `admin_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `user_id`, `agenda_id`, `folder_id`, `nama_dokumen`, `jenis_dokumen`, `file_path`, `file_type`, `ukuran_file`, `status`, `keterangan`, `tahun`, `admin_id`, `created_at`, `updated_at`) VALUES
(3, 3, NULL, NULL, 'sampan - Hasil_Diagnosa_anjing_2026-01-02 (3).pdf', 'RKAKL', 'documents/ICOFm0Ye5RzmhLLRBfXACTXZjvovNwaJBjMOz8D1.pdf', 'pdf', 722959, 'pending', 'qwee', 2026, NULL, '2026-02-20 08:53:24', '2026-02-20 08:53:24'),
(4, 3, 1, NULL, 'asd - penjualan mingguan.pdf', 'RAPK', 'documents/iuSt2n3GnHQ5JQeehwBoPjWJOTrat9MIFG8jJBJF.pdf', 'pdf', 344846, 'rejected', 'Ditolak', 2026, 1, '2026-02-20 08:59:15', '2026-02-20 09:11:57'),
(5, 2, 1, NULL, 'sas - 20260130 RAB Radep KBKR 30 Januari 2026.xlsx', 'RAPK', 'documents/1BrYxcPEbv0PfDJIgb0Kx4e2vaFN914b7d5xqkVj.xlsx', 'xlsx', 21662, 'pending', 'abcd', 2026, NULL, '2026-02-23 06:56:39', '2026-02-23 06:56:39');

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
-- Table structure for table `folders`
--

CREATE TABLE `folders` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `nama_folder` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `jenis_dokumen` enum('RKAKL','RAPK','SPJ','LKJ','LAKIP') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `alasan_reject` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `folders`
--

INSERT INTO `folders` (`id`, `user_id`, `nama_folder`, `deskripsi`, `jenis_dokumen`, `status`, `alasan_reject`, `created_at`, `updated_at`) VALUES
(1, 3, 'hari ini', 'wrwff', 'LAKIP', 'pending', NULL, '2026-02-20 08:21:58', '2026-02-20 08:21:58');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(9, '0001_01_01_000000_create_users_table', 1),
(10, '0001_01_01_000001_create_cache_table', 1),
(11, '0001_01_01_000002_create_jobs_table', 1),
(12, '2026_02_20_141231_create_folders_table', 1),
(13, '2026_02_20_141319_create_documents_table', 1),
(14, '2026_02_20_141320_create_approvals_table', 1),
(15, '2026_02_20_142737_remove_departemen_from_users_table', 1),
(16, '2026_02_20_143000_update_jenis_dokumen_enum', 1),
(17, '2026_02_20_150000_simplify_documents_table', 2),
(18, '2026_02_20_160000_add_columns_to_documents_table', 3),
(19, '2026_02_20_170000_make_folder_id_nullable_in_documents', 4),
(20, '2026_02_20_170000_create_agendas_table', 5),
(21, '2026_02_23_create_rabs_table', 6);

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
-- Table structure for table `rabs`
--

CREATE TABLE `rabs` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `agenda_id` bigint UNSIGNED DEFAULT NULL,
  `judul_rab` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_rab` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_rab` date NOT NULL,
  `tahun_anggaran` year NOT NULL,
  `keterangan_rab` text COLLATE utf8mb4_unicode_ci,
  `total_jumlah` decimal(15,2) NOT NULL DEFAULT '0.00',
  `status` enum('draft','submitted','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rab_items`
--

CREATE TABLE `rab_items` (
  `id` bigint UNSIGNED NOT NULL,
  `rab_id` bigint UNSIGNED NOT NULL,
  `uraian` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `volume` decimal(10,2) NOT NULL,
  `satuan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga_satuan` decimal(15,2) NOT NULL,
  `jumlah` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('4K7CSw6QFXqv8Z4HLNUlbGtEHAMbRozLwKVqjRdW', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.109.5 Chrome/142.0.7444.265 Electron/39.3.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWENpVTNnNWkyR0dBMTM3NnNhdHVQWXpldGRDSXpENXZvOGJXV0RmSCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0NDoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL2FwcHJvdmFsLWhpc3RvcnkiO31zOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czoyNzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1771855953),
('CBm6RGZVy4Gl93hj5mY1vWRaFNNihB0aJeKdj7US', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMW50V05YVDF3Yk5uc0tjdjBGQno5R0plQ2dWUjVlZUVDMjdoOE5wQiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9wZW5kaW5nLWFwcHJvdmFscyI7czo1OiJyb3V0ZSI7czoxMzoiYWRtaW4ucGVuZGluZyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1771907261),
('fMM8dsPGUpjAsTuaU02HMyZRw0XHc0Cqb8Afa5xZ', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicWJmUnVRblg2SGc4Q2M0eG9iZmZPS2ZHTjJGUVJKaWw1QmhXNVZHZSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9wZW5kaW5nLWFwcHJvdmFscyI7czo1OiJyb3V0ZSI7czoxMzoiYWRtaW4ucGVuZGluZyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1771859560),
('s8sbX7QW1Usq0UCecuH4YYmjVAbGi96FLUkf2TTr', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoib2Y1eGdvdENpakw4SHhhOGZoSWNEOWU3YndOblpqRUdKTVFnRjE4ZyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZ2VuZGEvMSI7czo1OiJyb3V0ZSI7czoxMToiYWdlbmRhLnNob3ciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTozO30=', 1771854791),
('snGIhpomKSQwAhCYBQeii5VTnYOAXThN7QSQCflN', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibUpBaFZLQmNZVlV4dkVOTmZ2YVlkeThCdjhMbG9pMG93VWw2bWNMbSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6OToiZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9', 1771859492);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','karyawan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'karyawan',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin RMSP', 'admin', 'admin@rmsp.local', NULL, '$2y$12$xnyZvS.2wgalC/RexcwOvevF11LBoyry9nZRoOyTx0yeZ3kONTEDe', 'admin', NULL, '2026-02-20 07:55:14', '2026-02-20 07:55:14'),
(2, 'Budi Santoso', 'budi', 'budi@rmsp.local', NULL, '$2y$12$dYr2J4V0/r6gRcoMqaKgkOKqdbIvBrKuJSScyPoTfw1G6w1NbvAfW', 'karyawan', NULL, '2026-02-20 07:55:14', '2026-02-20 07:55:14'),
(3, 'Siti Nurhaliza', 'siti', 'siti@rmsp.local', NULL, '$2y$12$1yAsE0yM7/KTGJculMLGL.ZRMoGbkwDDlUWB3R/hi4tb8L048akxC', 'karyawan', NULL, '2026-02-20 07:55:15', '2026-02-20 07:55:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agendas`
--
ALTER TABLE `agendas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `approvals`
--
ALTER TABLE `approvals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `approvals_folder_id_foreign` (`folder_id`),
  ADD KEY `approvals_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `documents_folder_id_foreign` (`folder_id`),
  ADD KEY `documents_user_id_foreign` (`user_id`),
  ADD KEY `documents_agenda_id_foreign` (`agenda_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `folders`
--
ALTER TABLE `folders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `folders_user_id_foreign` (`user_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `rabs`
--
ALTER TABLE `rabs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rabs_nomor_rab_unique` (`nomor_rab`),
  ADD KEY `rabs_user_id_foreign` (`user_id`),
  ADD KEY `rabs_agenda_id_foreign` (`agenda_id`);

--
-- Indexes for table `rab_items`
--
ALTER TABLE `rab_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rab_items_rab_id_foreign` (`rab_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agendas`
--
ALTER TABLE `agendas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `approvals`
--
ALTER TABLE `approvals`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `folders`
--
ALTER TABLE `folders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `rabs`
--
ALTER TABLE `rabs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rab_items`
--
ALTER TABLE `rab_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `approvals`
--
ALTER TABLE `approvals`
  ADD CONSTRAINT `approvals_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `approvals_folder_id_foreign` FOREIGN KEY (`folder_id`) REFERENCES `folders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_agenda_id_foreign` FOREIGN KEY (`agenda_id`) REFERENCES `agendas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `documents_folder_id_foreign` FOREIGN KEY (`folder_id`) REFERENCES `folders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `documents_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `folders`
--
ALTER TABLE `folders`
  ADD CONSTRAINT `folders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rabs`
--
ALTER TABLE `rabs`
  ADD CONSTRAINT `rabs_agenda_id_foreign` FOREIGN KEY (`agenda_id`) REFERENCES `agendas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `rabs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rab_items`
--
ALTER TABLE `rab_items`
  ADD CONSTRAINT `rab_items_rab_id_foreign` FOREIGN KEY (`rab_id`) REFERENCES `rabs` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
