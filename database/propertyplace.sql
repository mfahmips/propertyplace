-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 15, 2025 at 11:54 AM
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
-- Database: `propertyplace`
--

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `title`, `slug`, `content`, `cover_image`, `created_at`, `updated_at`) VALUES
(1, 'Identity Blog', 'identity-blog', 'Logo kami menggambarkan 3 hal utama:\r\n🏡 Rumah = simbol kenyamanan\r\n💛 Warna ceria = semangat dan optimisme\r\n🔄 Bentuk seimbang = kepercayaan & transparansi\r\n\r\nKami ingin jadi partner properti yang nggak ribet, nggak menipu, dan dekat dengan kamu.\r\n#BrandMeaning #MaknaLogo #AgencyProperti', '1752390076_9b4af8248e8efca575c2.jpg', '2025-07-13 07:01:16', '2025-07-13 08:10:13');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
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
-- Table structure for table `developers`
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
-- Dumping data for table `developers`
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
-- Table structure for table `migrations`
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
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(3, '2017-11-20-223112', 'App\\Database\\Migrations\\CreateAuthTables', 'default', 'App', 1751124190, 1);

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
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
-- Table structure for table `properties`
--

CREATE TABLE `properties` (
  `id` int NOT NULL,
  `developer_id` int UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `price` bigint NOT NULL,
  `price_text` varchar(100) NOT NULL,
  `description` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `properties`
--

INSERT INTO `properties` (`id`, `developer_id`, `title`, `slug`, `price`, `price_text`, `description`, `created_at`) VALUES
(1, 1, 'Centronia Residence', 'centronia-residence', 550, '550 Juta', 'Rumah tiga lantai yang luar biasa dengan sky lounge\r\natap yang terletak di kawasan premium dan eksklusif\r\nSentul City.\r\nTingkatkan hidup Anda dengan pemandangan dan\r\nalam yang menakjubkan untuk lingkungan yang nyaman. Nikmati\r\ngaya hidup holistik dengan kenyamanan Argenia\r\nSport Club dan Centronia Square tepat di depan pintu Anda.\r\nSebuah karya seni sejati dengan kesempurnaan di dalamnya.', '2025-06-28 01:24:56');

-- --------------------------------------------------------

--
-- Table structure for table `property_details`
--

CREATE TABLE `property_details` (
  `id` int NOT NULL,
  `property_id` int NOT NULL,
  `rooms` int DEFAULT NULL,
  `bedrooms` int DEFAULT NULL,
  `bathrooms` int DEFAULT NULL,
  `sqft` int DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `purpose` varchar(100) DEFAULT NULL,
  `parking` tinyint(1) DEFAULT '0',
  `elevator` tinyint(1) DEFAULT '0',
  `wifi` tinyint(1) DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `property_details`
--

INSERT INTO `property_details` (`id`, `property_id`, `rooms`, `bedrooms`, `bathrooms`, `sqft`, `type`, `purpose`, `parking`, `elevator`, `wifi`, `created_at`, `updated_at`) VALUES
(1, 1, 8, 4, 4, 196, 'rumah', 'For Sale', 1, 1, 1, '2025-07-14 23:47:02', '2025-07-15 00:10:26');

-- --------------------------------------------------------

--
-- Table structure for table `property_documents`
--

CREATE TABLE `property_documents` (
  `id` int NOT NULL,
  `property_id` int NOT NULL,
  `type` enum('pdf','video') NOT NULL,
  `title` varchar(255) NOT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `video_url` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `property_floor_plan`
--

CREATE TABLE `property_floor_plan` (
  `id` int NOT NULL,
  `property_id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `property_images`
--

CREATE TABLE `property_images` (
  `id` int NOT NULL,
  `property_id` int NOT NULL,
  `filename` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `sort_order` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `property_images`
--

INSERT INTO `property_images` (`id`, `property_id`, `filename`, `created_at`, `sort_order`) VALUES
(1, 1, '1751123359_9fe5c95a6cadfa137471.png', '2025-06-28 08:09:19', 0);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
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
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `site_name`, `site_logo`, `site_icon`, `tagline`, `about`, `phone`, `instagram`, `tiktok`, `location`, `maintenance`, `created_at`, `updated_at`, `timezone`, `date_format`, `datetime_format`, `language`) VALUES
(1, 'Property Place', 'logo_1751820210.png', 'icon_1751820210.png', 'Pilihan tepat mencari property terbaik', 'OK', '08561331998', 'propertyplace.id', 'propertyplace.id', 'Bogor', 0, '2025-07-06 16:42:38', '2025-07-06 16:44:47', 'UTC', 'Y-m-d', 'Y-m-d H:i:s', 'en');

-- --------------------------------------------------------

--
-- Table structure for table `users`
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
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `slug`, `email`, `password`, `foto`, `role`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 'Customer Dummy', 'customer-dummy', 'customer@propertyplace.id', '$2y$10$xFBV7b9Z9JTFuIG5EsxCl.G8eUrfRDFq..zJdYZG0gc5mORUIeBMG', NULL, 'customer', 1, '2025-07-04 21:50:16', '2025-07-04 21:50:16', NULL),
(4, 'Muhamad Fahmi PS', 'muhamad-fahmi-ps', 'fahmi@propertyplace.id', '$2y$10$fBJqxyFNLgDJQYeDhUjr.OADNRkouXmL/IwwCNU8IajRAh4uIYpAe', '1752170761_7e62da6707fe75eb19a6.jpg', 'admin', 1, '2025-07-04 23:30:18', '2025-07-10 11:41:21', NULL),
(5, 'Maulidina Fadzri', 'maulidina-fadzri', 'maulidina@propertyplace.id', '$2y$10$.jmATbK1xT1FxtNAyHEnIO0BRQYCfGJXrmmQOT6dSRpK3tDaAzuM2', '1752170842_190de76ecd37e540440d.jpg', 'karyawan', 1, '2025-07-05 03:00:21', '2025-07-12 08:15:57', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `developers`
--
ALTER TABLE `developers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`id`),
  ADD KEY `developer_id` (`developer_id`);

--
-- Indexes for table `property_details`
--
ALTER TABLE `property_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `property_documents`
--
ALTER TABLE `property_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `property_id` (`property_id`);

--
-- Indexes for table `property_floor_plan`
--
ALTER TABLE `property_floor_plan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `property_id` (`property_id`);

--
-- Indexes for table `property_images`
--
ALTER TABLE `property_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `developers`
--
ALTER TABLE `developers`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `properties`
--
ALTER TABLE `properties`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `property_details`
--
ALTER TABLE `property_details`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `property_documents`
--
ALTER TABLE `property_documents`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `property_floor_plan`
--
ALTER TABLE `property_floor_plan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `property_images`
--
ALTER TABLE `property_images`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `properties`
--
ALTER TABLE `properties`
  ADD CONSTRAINT `fk_properties_developer` FOREIGN KEY (`developer_id`) REFERENCES `developers` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `property_documents`
--
ALTER TABLE `property_documents`
  ADD CONSTRAINT `property_documents_ibfk_1` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `property_floor_plan`
--
ALTER TABLE `property_floor_plan`
  ADD CONSTRAINT `property_floor_plan_ibfk_1` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
