-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 10 Jul 2025 pada 18.50
-- Versi server: 8.4.3
-- Versi PHP: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `propertyplace`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `customers`
--

CREATE TABLE `customers` (
  `id` int NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `developers`
--

CREATE TABLE `developers` (
  `id` int UNSIGNED NOT NULL,
  `slug` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `developers`
--

INSERT INTO `developers` (`id`, `slug`, `name`, `logo`, `location`, `created_at`, `updated_at`) VALUES
(1, 'sentul-city', 'Sentul City', '1752087561_b9f498dbcdec8c597798.png', 'Bogor', '2025-07-06 18:57:12', '2025-07-09 18:59:21'),
(2, 'ciputra', 'Ciputra', '1752087548_4f53ddb3800e80fff97a.png', 'Bogor', '2025-07-06 19:34:17', '2025-07-09 19:06:25'),
(3, 'sinarmas-land', 'Sinarmas Land', '1752087596_0ac7706c2a98c91f2466.png', 'Bogor', '2025-07-09 18:59:56', '2025-07-09 19:07:09'),
(4, 'lippo-group', 'Lippo Group', '1752088018_628811d0ff04b5e795cd.png', 'Tangerang', '2025-07-09 19:06:58', '2025-07-09 19:06:58'),
(5, 'agung-podomoro-land', 'Agung Podomoro Land', '1752088056_50686777ae905839f4f5.png', 'Bogor', '2025-07-09 19:07:36', '2025-07-09 19:07:36'),
(6, 'paramount-land', 'Paramount Land', '1752088249_359ba3775bbab2def9a0.png', 'Tangerang', '2025-07-09 19:10:49', '2025-07-09 19:10:49'),
(7, 'pakuwon-group', 'Pakuwon Group', '1752088273_77b3deec502bdff6ebfa.png', 'Jakarta', '2025-07-09 19:11:13', '2025-07-09 19:11:13'),
(8, 'habitat-land', 'Habitat Land', '1752088290_777de08eb293a51a0bb7.png', 'Bogor', '2025-07-09 19:11:30', '2025-07-09 19:11:30'),
(9, 'summarecon', 'Summarecon', '1752088305_131c98af7e5f9f8ccde8.png', 'Bogor', '2025-07-09 19:11:45', '2025-07-09 19:11:45'),
(10, 'adhi-city', 'Adhi City', '1752088317_30dd7d333b68798aedf1.png', 'Bogor', '2025-07-09 19:11:57', '2025-07-09 19:11:57'),
(11, 'triniti-land', 'Triniti Land', '1752088337_e4574c11ae8178d779a5.png', 'Bogor', '2025-07-09 19:12:17', '2025-07-09 19:12:17'),
(12, 'ocbd', 'OCBD', '1752088364_1cdd8451892319d708e7.png', 'Bogor', '2025-07-09 19:12:44', '2025-07-09 19:12:44'),
(13, 'sentul-alaya', 'Sentul Alaya', '1752088388_b713211105e0fb522490.png', 'Bogor', '2025-07-09 19:13:08', '2025-07-09 19:13:08'),
(14, 'sanctuary', 'Sanctuary', '1752088401_ec84262a61313eaf9d68.png', 'Bogor', '2025-07-09 19:13:21', '2025-07-09 19:13:21'),
(15, 'graha-laras', 'Graha Laras', '1752088422_a070e12da6a9255e4a62.png', 'Bogor', '2025-07-09 19:13:42', '2025-07-09 19:13:42'),
(16, 'paradiso-sentul', 'Paradiso Sentul', '1752088435_08dc758de84da4e10963.png', 'Bogor', '2025-07-09 19:13:55', '2025-07-09 19:13:55');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int NOT NULL,
  `batch` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(3, '2017-11-20-223112', 'App\\Database\\Migrations\\CreateAuthTables', 'default', 'App', 1751124190, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `penjualan`
--

CREATE TABLE `penjualan` (
  `id` int NOT NULL,
  `tanggal` date DEFAULT NULL,
  `total` decimal(18,2) DEFAULT NULL,
  `customer_id` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `properties`
--

CREATE TABLE `properties` (
  `id` int NOT NULL,
  `developer_id` int UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `location` varchar(255) NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `description` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `properties`
--

INSERT INTO `properties` (`id`, `developer_id`, `title`, `slug`, `location`, `price`, `description`, `created_at`) VALUES
(1, 1, 'Rumah Cluster BSD', 'rumah-cluster-bsd', 'BSD City', 1500000000.00, 'Rumah modern minimalis siap huni.', '2025-06-28 01:24:56'),
(6, NULL, 'Agung podomoro', 'agung-podomoro', 'serpong', 600000000.00, 'OK', '2025-07-01 19:21:17');

-- --------------------------------------------------------

--
-- Struktur dari tabel `property_images`
--

CREATE TABLE `property_images` (
  `id` int NOT NULL,
  `property_id` int NOT NULL,
  `filename` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `property_images`
--

INSERT INTO `property_images` (`id`, `property_id`, `filename`, `created_at`) VALUES
(1, 1, '1751123359_9fe5c95a6cadfa137471.png', '2025-06-28 08:09:19'),
(2, 1, '1751823663_e7a43e57523277b21553.jpeg', '2025-07-06 10:41:03');

-- --------------------------------------------------------

--
-- Struktur dari tabel `settings`
--

CREATE TABLE `settings` (
  `id` int NOT NULL,
  `site_name` varchar(255) NOT NULL,
  `site_logo` varchar(255) DEFAULT NULL,
  `site_icon` varchar(255) DEFAULT NULL,
  `tagline` varchar(255) DEFAULT NULL,
  `about` text,
  `phone` varchar(20) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `tiktok` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `maintenance` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `timezone` varchar(100) NOT NULL DEFAULT 'UTC',
  `date_format` varchar(50) NOT NULL DEFAULT 'Y-m-d',
  `datetime_format` varchar(50) NOT NULL DEFAULT 'Y-m-d H:i:s',
  `language` varchar(10) NOT NULL DEFAULT 'en'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `settings`
--

INSERT INTO `settings` (`id`, `site_name`, `site_logo`, `site_icon`, `tagline`, `about`, `phone`, `instagram`, `tiktok`, `location`, `maintenance`, `created_at`, `updated_at`, `timezone`, `date_format`, `datetime_format`, `language`) VALUES
(1, 'Property Place', 'logo_1751820210.png', 'icon_1751820210.png', 'Pilihan tepat mencari property terbaik', 'OK', '08561331998', 'propertyplace.id', 'propertyplace.id', 'Bogor', 0, '2025-07-06 16:42:38', '2025-07-06 16:44:47', 'UTC', 'Y-m-d', 'Y-m-d H:i:s', 'en');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(150) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `role` enum('admin','karyawan','customer') DEFAULT 'admin',
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `slug`, `email`, `password`, `foto`, `role`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Admin Demo', 'admin-demo', 'admin@propertyplace.id', '$2y$10$LazP.s.60/JRw.7OUyAuPesdOPRDdR2M4T4jDuKeYEHyZyIcxQkMu', NULL, 'admin', 1, '2025-07-04 21:50:16', '2025-07-04 21:50:16', NULL),
(2, 'Karyawan Sample', 'karyawan-sample', 'karyawan@propertyplace.id', '$2y$10$3nN2ctRJoQ8gUTbqNVMRoe2DiaPuppwBDP2lb.DeRiS8BQR4IHNB6', NULL, 'karyawan', 1, '2025-07-04 21:50:16', '2025-07-04 21:50:16', NULL),
(3, 'Customer Dummy', 'customer-dummy', 'customer@propertyplace.id', '$2y$10$xFBV7b9Z9JTFuIG5EsxCl.G8eUrfRDFq..zJdYZG0gc5mORUIeBMG', NULL, 'customer', 1, '2025-07-04 21:50:16', '2025-07-04 21:50:16', NULL),
(4, 'Muhamad Fahmi PS', 'muhamad-fahmi-ps', 'fahmi@propertyplace.id', '$2y$10$fBJqxyFNLgDJQYeDhUjr.OADNRkouXmL/IwwCNU8IajRAh4uIYpAe', '1752170761_7e62da6707fe75eb19a6.jpg', 'admin', 1, '2025-07-04 23:30:18', '2025-07-10 11:41:21', NULL),
(5, 'Maulidina', 'maulidina', 'maulidina@propertyplace.id', '$2y$10$.jmATbK1xT1FxtNAyHEnIO0BRQYCfGJXrmmQOT6dSRpK3tDaAzuM2', '1752170842_190de76ecd37e540440d.jpg', 'karyawan', 1, '2025-07-05 03:00:21', '2025-07-10 11:32:07', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `developers`
--
ALTER TABLE `developers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`id`),
  ADD KEY `developer_id` (`developer_id`);

--
-- Indeks untuk tabel `property_images`
--
ALTER TABLE `property_images`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `developers`
--
ALTER TABLE `developers`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `properties`
--
ALTER TABLE `properties`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `property_images`
--
ALTER TABLE `property_images`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `properties`
--
ALTER TABLE `properties`
  ADD CONSTRAINT `fk_properties_developer` FOREIGN KEY (`developer_id`) REFERENCES `developers` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
