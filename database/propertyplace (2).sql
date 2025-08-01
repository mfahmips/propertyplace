-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 01, 2025 at 04:10 PM
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
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `developers`
--

INSERT INTO `developers` (`id`, `slug`, `name`, `logo`, `created_at`, `updated_at`) VALUES
(1, 'sentul-city', 'Sentul City', '1753519477_b58424da17130edfa37e.png', '2025-07-06 18:57:12', '2025-07-26 08:44:37'),
(2, 'citra-city-sentul', 'Citra City Sentul', '1753519504_9855411f8dadf3e8eaff.png', '2025-07-26 08:45:04', '2025-07-26 08:45:04'),
(3, 'sentul-alaya', 'Sentul Alaya', '1753519585_8580dd7e1b7961b007f9.png', '2025-07-26 08:46:25', '2025-07-26 08:46:25'),
(4, 'sanctuary', 'Sanctuary', '1753519607_a77f15d397c586121ba2.png', '2025-07-26 08:46:47', '2025-07-26 08:46:47'),
(5, 'sequoia-hills', 'Sequoia Hills', '1753519637_6e5e86b9205f17b165e7.png', '2025-07-26 08:47:17', '2025-07-26 08:47:17'),
(6, 'citra-sentul-raya', 'Citra Sentul Raya', '1753521155_36b8e93b13b23ca4ef3d.png', '2025-07-26 09:08:43', '2025-07-26 09:12:35'),
(7, 'd-amandita', 'D\'Amandita', '1753521141_e6732f4657f75bf40d26.png', '2025-07-26 09:09:07', '2025-07-26 16:13:51'),
(8, 'adhi-city', 'Adhi City', '1753520965_6da8cc4a017fcf680ff2.png', '2025-07-26 09:09:25', '2025-07-26 09:09:25'),
(9, 'paradiso-sentul', 'Paradiso @Sentul', '1753521177_2b1c0e2856de8240a059.png', '2025-07-26 09:12:57', '2025-07-26 09:12:57');

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
  `thumbnail` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `properties`
--

INSERT INTO `properties` (`id`, `developer_id`, `title`, `slug`, `thumbnail`, `created_at`) VALUES
(1, 1, 'Arcadia Residence', 'arcadia-residence', '1753514498_5a551b67dab8ea39a0f3.jpg', '2025-07-26 07:21:38'),
(2, 1, 'Spring Valley Extension', 'spring-valley-extension', '1753516404_2382e3d13023135e8b3c.jpg', '2025-07-26 07:49:47'),
(3, 1, 'Centronia Residence', 'centronia-residence', '1753516980_0b8d89c9c85859c80807.jpg', '2025-07-26 08:03:00'),
(4, 1, 'Spring Residence', 'spring-residence', '1753517005_72535dddfff698ee078e.jpg', '2025-07-26 08:03:25'),
(5, 1, 'Spring Garden', 'spring-garden', '1753517027_d66cca0fc4437ccca9fc.jpg', '2025-07-26 08:03:47'),
(6, 2, 'Chianti', 'chianti', '1753521330_f7b2f098ab12ea641f83.jpg', '2025-07-26 09:15:30'),
(7, 2, 'Reina Sofia', 'reina-sofia', '1753521357_1180338677bd9cc2ad22.jpg', '2025-07-26 09:15:57'),
(8, 2, 'Golf Horizon', 'golf-horizon', '1753521391_522646f60bb653747697.jpg', '2025-07-26 09:16:31'),
(9, 3, 'Andante', 'andante', '1753521439_f1ca9e866145b9c831a6.jpg', '2025-07-26 09:17:19'),
(10, 3, 'Altissimo', 'altissimo', '1753521463_6a106fb6260acf1ee0ce.jpg', '2025-07-26 09:17:43'),
(11, 4, 'Orchard Riviera', 'orchard-riviera', '1753521519_ab32121a28038ddd792a.jpg', '2025-07-26 09:18:39'),
(12, 4, 'Tanglin Parc', 'tanglin-parc', '1753521536_fa177ed2a7963ada76a6.jpg', '2025-07-26 09:18:56'),
(13, 5, 'Harvest Ville', 'harvest-ville', '1753521582_63862d344262ea84e97e.jpg', '2025-07-26 09:19:42'),
(14, 5, 'Mono', 'mono', '1753521600_e549f14de57d946b5f2e.jpg', '2025-07-26 09:20:00'),
(15, 5, 'Earthville', 'earthville', '1753521626_387f0bab0372348be4b8.jpg', '2025-07-26 09:20:26'),
(16, 6, 'Volga', 'volga', '1753521668_bc327c68da3aeb0d71cb.jpg', '2025-07-26 09:21:08'),
(17, 6, '8 Park Avenue', '8-park-avenue', '1753521689_0a102e14e6cf006380c7.jpg', '2025-07-26 09:21:29');

-- --------------------------------------------------------

--
-- Table structure for table `property_details`
--

CREATE TABLE `property_details` (
  `id` int NOT NULL,
  `property_id` int NOT NULL,
  `price` bigint DEFAULT NULL,
  `price_text` varchar(100) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `purpose` varchar(100) DEFAULT NULL,
  `description` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `property_details`
--

INSERT INTO `property_details` (`id`, `property_id`, `price`, `price_text`, `location`, `type`, `purpose`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 800000000, '800 Juta', 'Bogor', 'Rumah', 'For Sale', 'Arcadia Residence adalah hunian modern yang menawarkan kenyamanan dan kemudahan di lokasi strategis Sentul City. Dikelilingi oleh berbagai fasilitas unggulan, rumah ini dirancang untuk memenuhi kebutuhan Anda akan gaya hidup praktis dan berkualitas.\r\n\r\n✅ Lokasi strategis dengan panorama alam yang memukau\r\n✅ Berada di pusat Sentul City, dekat dengan berbagai fasilitas\r\n✅ Dilengkapi dengan Smart Home System untuk kemudahan hidup\r\n✅ Garansi Bangunan 2 Tahun untuk rasa tenang dan aman\r\n\r\nDengan lokasi yang strategis, Arcadia Residence memungkinkan Anda mengakses pusat perbelanjaan, sekolah, fasilitas kesehatan, dan tempat rekreasi hanya dalam hitungan menit.', '2025-07-26 10:25:46', '2025-07-26 10:26:11'),
(2, 3, 2500000000, '2.5 M', 'Bogor', 'Rumah', 'For Sale', 'Centronia Residence adalah rumah 3 lantai dengan rooftop yang terletak di kawasan premium Sentul City. Rumah ini memiliki lokasi yang strategis tepat di belakang Argenia Sport Club dan Centronia Square, yang membuatnya sangat mudah dijangkau dan dekat dengan berbagai fasilitas penting di sekitarnya:\r\n\r\n✅ Rooftop dengan view perkotaan yang hijau\r\n✅ Dilengkapi dengan Smart Home System\r\n✅ Berlokasi tepat di belakang Argenia Sport Club & Centronia Square\r\n✅ Garansi Bangunan 2 Tahun!\r\n\r\nDengan lokasi yang strategis serta dekat dengan berbagai fasilitas mumpuni, Centronia Residence akan menjadi hunian yang nyaman untuk Anda dan keluarga.', '2025-07-26 11:25:36', '2025-07-26 11:25:36'),
(3, 5, 1000000000, '1 M', 'Bogor', 'Rumah', 'For Sale', 'Spring Garden adalah hunian 1 & 2 lantai dengan view indah Gunung Pancar, berada di ketinggian 370 - 440 mdpl. Dikelilingi oleh Flowing Garden yang menambah keindahan dan kenyamanan hunian ini, Spring Garden berada di kawasan terbaru Spring City, Sentul City, membuat hunian ini semakin menarik dan nyaman untuk ditinggali.\r\n\r\n✅ Dilengkapi dengan Smart Home System\r\n✅ 11 Fasilitas Unggulan; Barbeque Garden, Menteng Garden, Reflexology Garden, Suropati Garden, Children Playground, Rock Garden, Spring City Club House, Ayodya Garden, Adventure Playground, Mataram Garden, dan Communal Garden\r\n✅ Garansi Bangunan 2 Tahun!\r\n\r\nSpring Garden menghadirkan fasilitas lengkap yang mengintegrasikan keindahan alam dengan teknologi modern, menciptakan gaya hidup sehat dan seimbang. Jadikan Spring Garden sebagai pilihan utama untuk ciptakan momen-momen berharga bersama keluarga, di lingkungan yang menenangkan dan penuh gaya.', '2025-07-26 15:21:00', '2025-07-26 15:21:00');

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
-- Table structure for table `property_images`
--

CREATE TABLE `property_images` (
  `id` int NOT NULL,
  `property_id` int NOT NULL,
  `filename` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `sort_order` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `property_type`
--

CREATE TABLE `property_type` (
  `id` int NOT NULL,
  `property_id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_unit` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `floors` tinyint UNSIGNED DEFAULT '1',
  `land_area` float DEFAULT NULL,
  `building_area` float DEFAULT NULL,
  `bedrooms` tinyint UNSIGNED DEFAULT '0',
  `bathrooms` tinyint UNSIGNED DEFAULT '0',
  `carport` tinyint UNSIGNED DEFAULT '0',
  `elevator` tinyint(1) DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `property_type`
--

INSERT INTO `property_type` (`id`, `property_id`, `name`, `slug`, `type_unit`, `floors`, `land_area`, `building_area`, `bedrooms`, `bathrooms`, `carport`, `elevator`, `created_at`, `updated_at`) VALUES
(1, 1, '33 F', '33-f', 'Flat', 1, 60, 36, 2, 1, 1, 0, '2025-07-26 11:19:21', '2025-07-26 18:21:47'),
(2, 1, '36 F', '36-f', 'Flat', 1, 80, 36, 2, 1, 1, 0, '2025-07-26 11:20:20', '2025-07-26 18:21:53'),
(3, 1, '36 U', '36-u', 'Upslope', 2, 120, 36, 3, 2, 2, 0, '2025-07-26 11:20:59', '2025-07-26 18:21:57');

-- --------------------------------------------------------

--
-- Table structure for table `property_type_images`
--

CREATE TABLE `property_type_images` (
  `id` int NOT NULL,
  `property_id` int NOT NULL,
  `type_id` int DEFAULT NULL,
  `name_floor` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
-- Table structure for table `settings_images`
--

CREATE TABLE `settings_images` (
  `id` int NOT NULL,
  `type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `filename` varchar(255) NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `sort_order` int DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `slug` varchar(150) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `gender` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `place_of_birth` varchar(100) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `address` text,
  `facebook` varchar(100) DEFAULT NULL,
  `instagram` varchar(100) DEFAULT NULL,
  `tiktok` varchar(100) DEFAULT NULL,
  `role` enum('admin','sales','management') DEFAULT 'sales',
  `position` varchar(100) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `slug`, `email`, `phone`, `password`, `foto`, `gender`, `place_of_birth`, `date_of_birth`, `address`, `facebook`, `instagram`, `tiktok`, `role`, `position`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Muhamad Fahmi PS', 'mfahmips', 'muhamad-fahmi-ps', 'fahmi@propertyplace.id', '08123456789', '$2y$10$KjP7ZxAM6cycuo9PDdN4jOva/kgGcLqhq0pDMjKABlRD7BMGE7vwe', '1752170761_7e62da6707fe75eb19a6.jpg', 'Laki-laki', 'Bogor', '1998-03-13', 'JALAN JEMBATAN HITAM NO. 1 RT. 03/10, CIJUJUNG, SUKARAJA, KABUPATEN BOGOR, JAWA BARAT, 16710', NULL, 'mfahmips', 'mfahmips', 'admin', 'Digital Marketing', 1, '2025-07-05 06:30:18', '2025-07-31 16:46:05', NULL),
(2, 'Maulidina Fadzri', 'maulidinafzr', 'maulidina-fadzri', 'maulidina@propertyplace.id', NULL, '$2y$10$9vzcjgw09eqZiWxQlPD1O6.L7aN8pwoHajkGwWk6LC843KndFr1FDS', '1752170842_190de76ecd37e540440d.jpg', 'Perempuan', 'Bogor', '1998-07-17', NULL, NULL, NULL, NULL, 'admin', 'Public Relation', 1, '2025-07-05 10:00:21', '2025-07-31 16:46:44', NULL),
(6, 'Muhamad Wildan', 'wildan123', 'wildan123', 'wildan@propertyplace.id', NULL, '$2y$10$zzZcJ/bIrU9wJzOurA3wouSIh2x27/uro6oVhU2jRnTy.FN9PZq2q', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'sales', 'Sales Executive', 1, '2025-07-31 17:53:07', '2025-07-31 17:53:39', NULL);

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
-- Indexes for table `property_images`
--
ALTER TABLE `property_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `property_type`
--
ALTER TABLE `property_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `property_id` (`property_id`);

--
-- Indexes for table `property_type_images`
--
ALTER TABLE `property_type_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `property_id` (`property_id`),
  ADD KEY `fk_unit` (`type_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings_images`
--
ALTER TABLE `settings_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `username_2` (`username`);

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
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `property_details`
--
ALTER TABLE `property_details`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `property_documents`
--
ALTER TABLE `property_documents`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `property_images`
--
ALTER TABLE `property_images`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `property_type`
--
ALTER TABLE `property_type`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `property_type_images`
--
ALTER TABLE `property_type_images`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `settings_images`
--
ALTER TABLE `settings_images`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
-- Constraints for table `property_type`
--
ALTER TABLE `property_type`
  ADD CONSTRAINT `property_type_ibfk_1` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `property_type_images`
--
ALTER TABLE `property_type_images`
  ADD CONSTRAINT `fk_unit` FOREIGN KEY (`type_id`) REFERENCES `property_type` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `property_type_images_ibfk_1` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
