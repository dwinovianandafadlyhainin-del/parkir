-- ============================================================
-- DATABASE: parkir
-- SMKN 1 CIBINONG - SIJA PARKING SYSTEM
-- ============================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+07:00";

-- Buat database jika belum ada
CREATE DATABASE IF NOT EXISTS `parkir`
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `parkir`;

-- ============================================================
-- TABLE: users
-- ============================================================
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`name`, `email`, `password`, `created_at`, `updated_at`) VALUES
('Admin', 'admin@parkir.com', '$2y$12$LtPWPm6X1zl5wCkbXpyEJOXGKE4NwFfAezECZ5rFJZf9yZEb1BQFS', NOW(), NOW());

-- ============================================================
-- TABLE: password_reset_tokens
-- ============================================================
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- TABLE: sessions
-- ============================================================
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- TABLE: cache
-- ============================================================
DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- TABLE: jobs (queue)
-- ============================================================
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- TABLE: migrations (laravel tracking)
-- ============================================================
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('0001_01_01_000000_create_users_table', 1),
('0001_01_01_000001_create_cache_table', 1),
('0001_01_01_000002_create_jobs_table', 1),
('2024_01_01_000001_create_locations_table', 1),
('2024_01_01_000002_create_vehicle_types_table', 1),
('2024_01_01_000003_create_transactions_table', 1);

-- ============================================================
-- TABLE: locations
-- ============================================================
DROP TABLE IF EXISTS `locations`;
CREATE TABLE `locations` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `location_name` varchar(100) NOT NULL,
  `max_motorcycle` int(11) NOT NULL DEFAULT 0,
  `max_car` int(11) NOT NULL DEFAULT 0,
  `max_other` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data sample: Gedung A, B, C
INSERT INTO `locations` (`location_name`, `max_motorcycle`, `max_car`, `max_other`, `created_at`, `updated_at`) VALUES
('Gedung A', 3, 3, 3, NOW(), NOW()),
('Gedung B', 3, 3, 3, NOW(), NOW()),
('Gedung C', 3, 3, 3, NOW(), NOW());

-- ============================================================
-- TABLE: vehicle__types (double underscore sesuai konvensi Laravel)
-- ============================================================
DROP TABLE IF EXISTS `vehicle__types`;
CREATE TABLE `vehicle__types` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `jenis` enum('motorcycle','car','other') NOT NULL,
  `perjam_pertama` int(11) NOT NULL DEFAULT 0,
  `perjam_berikutnya` int(11) NOT NULL DEFAULT 0,
  `max_perhari` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `vehicle__types_jenis_unique` (`jenis`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data sesuai PDF soal:
-- Motor: pertama=2000, berikutnya=1000, max=10000
-- Mobil: pertama=3000, berikutnya=2000, max=15000
-- Truk: pertama=5000, berikutnya=3000, max=30000
INSERT INTO `vehicle__types` (`jenis`, `perjam_pertama`, `perjam_berikutnya`, `max_perhari`, `created_at`, `updated_at`) VALUES
('motorcycle', 2000, 1000, 10000, NOW(), NOW()),
('car',        3000, 2000, 15000, NOW(), NOW()),
('other',      5000, 3000, 30000, NOW(), NOW());

-- ============================================================
-- TABLE: transactions
-- ============================================================
DROP TABLE IF EXISTS `transactions`;
CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_lokasi` bigint(20) UNSIGNED NOT NULL,
  `no_tiket` varchar(255) DEFAULT NULL,
  `no_polisi` varchar(15) DEFAULT NULL,
  `id_jenis` bigint(20) UNSIGNED NOT NULL,
  `masuk` datetime DEFAULT NULL,
  `keluar` datetime DEFAULT NULL,
  `perjam_pertama` int(11) DEFAULT NULL,
  `perjam_berikutnya` int(11) DEFAULT NULL,
  `max_perhari` int(11) DEFAULT NULL,
  `total_jam` int(11) DEFAULT NULL,
  `total_bayar` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transactions_id_lokasi_foreign` (`id_lokasi`),
  KEY `transactions_id_jenis_foreign` (`id_jenis`),
  CONSTRAINT `transactions_id_lokasi_foreign` FOREIGN KEY (`id_lokasi`) REFERENCES `locations` (`id`),
  CONSTRAINT `transactions_id_jenis_foreign` FOREIGN KEY (`id_jenis`) REFERENCES `vehicle__types` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data sample transaksi (sudah keluar)
INSERT INTO `transactions`
  (`id_lokasi`, `no_tiket`, `no_polisi`, `id_jenis`, `masuk`, `keluar`,
   `perjam_pertama`, `perjam_berikutnya`, `max_perhari`, `total_jam`, `total_bayar`, `created_at`, `updated_at`)
VALUES
-- Motor Gedung A, 16 jam → max_perhari = 10.000
(1, '20251208130651', 'F5566DG', 1,
 '2025-12-08 13:06:55', '2025-12-08 13:23:42',
 2000, 1000, 10000, 16, 10000, NOW(), NOW()),

-- Mobil Gedung B, 6 jam → 3000 + (2000*5) = 13.000
(2, '20251209102242', 'B7789NM', 2,
 '2025-12-09 10:22:24', '2025-12-09 10:29:14',
 3000, 2000, 15000, 6, 13000, NOW(), NOW()),

-- Truk Gedung C, 89 jam (3 hari) → 3 * (30000*60%) = 54.000
(3, '20251209114263', 'D9788RT', 3,
 '2025-12-09 11:14:26', '2025-12-09 12:43:26',
 5000, 3000, 30000, 89, 54000, NOW(), NOW());

COMMIT;

-- ============================================================
-- SELESAI
-- Cara import:
-- 1. Buka phpMyAdmin
-- 2. Klik tab "Import"
-- 3. Pilih file ini → klik "Go"
-- ATAU jalankan via CLI:
--   mysql -u root -p < parkir_database.sql
-- ============================================================
