-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 07 Jul 2025 pada 15.51
-- Versi server: 5.7.33
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
  `id` int(11) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `developers`
--

CREATE TABLE `developers` (
  `id` int(11) UNSIGNED NOT NULL,
  `slug` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `developers`
--

INSERT INTO `developers` (`id`, `slug`, `name`, `logo`, `location`, `created_at`, `updated_at`) VALUES
(1, 'sentul-city', 'Sentul City', '1751829817_6080bce84d5c9161b9f2.jpeg', 'Bogor', '2025-07-06 18:57:12', '2025-07-07 02:43:50'),
(2, 'ciputra', 'Ciputra', '1751830457_ae435c67e7199dd55135.png', 'Bogor', '2025-07-06 19:34:17', '2025-07-07 02:43:50');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `id` int(11) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `total` decimal(18,2) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `properties`
--

CREATE TABLE `properties` (
  `id` int(11) NOT NULL,
  `developer_id` int(11) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `location` varchar(255) NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `description` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `id` int(11) NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `id` int(11) NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `slug`, `email`, `password`, `foto`, `role`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Admin Demo', 'admin-demo', 'admin@propertyplace.id', '$2y$10$LazP.s.60/JRw.7OUyAuPesdOPRDdR2M4T4jDuKeYEHyZyIcxQkMu', NULL, 'admin', 1, '2025-07-04 21:50:16', '2025-07-04 21:50:16', NULL),
(2, 'Karyawan Sample', 'karyawan-sample', 'karyawan@propertyplace.id', '$2y$10$3nN2ctRJoQ8gUTbqNVMRoe2DiaPuppwBDP2lb.DeRiS8BQR4IHNB6', NULL, 'karyawan', 1, '2025-07-04 21:50:16', '2025-07-04 21:50:16', NULL),
(3, 'Customer Dummy', 'customer-dummy', 'customer@propertyplace.id', '$2y$10$xFBV7b9Z9JTFuIG5EsxCl.G8eUrfRDFq..zJdYZG0gc5mORUIeBMG', NULL, 'customer', 1, '2025-07-04 21:50:16', '2025-07-04 21:50:16', NULL),
(4, 'fahmi', 'fahmi', 'fahmi@propertyplace.id', '$2y$10$fBJqxyFNLgDJQYeDhUjr.OADNRkouXmL/IwwCNU8IajRAh4uIYpAe', '1751704153_395e21d279986f7106fc.jpg', 'admin', 1, '2025-07-04 23:30:18', '2025-07-05 01:29:13', NULL),
(5, 'Maulidina', 'maulidina', 'maulidina@propertyplace.id', '$2y$10$.jmATbK1xT1FxtNAyHEnIO0BRQYCfGJXrmmQOT6dSRpK3tDaAzuM2', '1751709620_27f17f9a9eaf5e2d859a.png', 'admin', 1, '2025-07-05 03:00:21', '2025-07-06 10:54:37', NULL);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `developers`
--
ALTER TABLE `developers`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `properties`
--
ALTER TABLE `properties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `property_images`
--
ALTER TABLE `property_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
