-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 17, 2024 at 09:37 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quick_spear`
--

-- --------------------------------------------------------

--
-- Table structure for table `shipments`
--

CREATE TABLE `shipments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `address_id` bigint(20) UNSIGNED DEFAULT NULL,
  `delegate_id` bigint(20) UNSIGNED DEFAULT NULL,
  `consignee_name` varchar(255) DEFAULT NULL,
  `consignee_phone` varchar(255) NOT NULL,
  `consignee_phone_2` varchar(255) DEFAULT NULL,
  `consignee_country_code` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `consignee_city` bigint(20) UNSIGNED NOT NULL,
  `consignee_region` varchar(255) NOT NULL,
  `consignee_zip_code` varchar(255) NOT NULL,
  `shipping_date_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `accepted_by_admin_at` timestamp NULL DEFAULT NULL,
  `due_date` varchar(255) NOT NULL,
  `order_price` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `value_on_delivery` varchar(255) DEFAULT NULL,
  `customer_notes` text CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `delegate_notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` bigint(20) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shipments`
--

INSERT INTO `shipments` (`id`, `user_id`, `address_id`, `delegate_id`, `consignee_name`, `consignee_phone`, `consignee_phone_2`, `consignee_country_code`, `consignee_city`, `consignee_region`, `consignee_zip_code`, `shipping_date_time`, `accepted_by_admin_at`, `due_date`, `order_price`, `value_on_delivery`, `customer_notes`, `delegate_notes`, `created_at`, `updated_at`, `status`) VALUES
(26, 1, 18, 2, 'أحمد العجي', '0936456369', '357459', 'JO', 3, 'منطقة الكرك', '', '2024-05-12 16:03:07', NULL, '2024-05-15 19:03:07', '1000', NULL, 'ملاحظات العميل', 'ملاحظات المندوب أحمد', '2024-04-15 17:28:35', '2024-05-12 16:03:07', 6),
(28, 1, 20, NULL, 'شش', '3216549875', '13', 'JO', 2, 'Similique qui exerci', '', '2024-04-26 12:00:29', NULL, '2024-04-18 20:46:21', '818', NULL, 'Esse fugit in et ex', 'Sit ea facilis labo', '2024-04-15 17:46:21', '2024-04-15 17:46:21', 4),
(34, NULL, 22, NULL, 'Lucas', '3216549875', '9', 'JO', 3, 'Vitae amet ea quod', '', '2024-04-26 13:09:07', NULL, '2024-04-29 16:09:07', '699', NULL, 'Aut quia hic id ulla', NULL, '2024-04-26 13:09:07', '2024-04-26 13:09:07', 0),
(35, NULL, 9, NULL, 'Jane Wright', '1234567891', '14', 'JO', 2, 'Est est nulla quisqu', '', '2024-04-26 13:11:39', NULL, '2024-04-29 16:11:39', '241', NULL, 'Et consectetur est', NULL, '2024-04-26 13:11:39', '2024-04-26 13:11:39', 0),
(36, 4, 3, 1, 'Bo Bell', '2316549875', '8', 'JO', 3, 'Odio omnis ipsum la', '', '2024-05-12 15:53:29', NULL, '2024-05-15 18:53:29', '190', NULL, 'Maiores in dicta aut', NULL, '2024-04-26 13:26:32', '2024-05-12 15:53:29', 1),
(37, NULL, 20, 2, 'Hashim Hammond', '3215649873', '22', 'JO', 2, 'Est qui id quos vol', '', '2024-04-26 13:26:42', NULL, '2024-04-29 16:26:42', '428', NULL, 'Eiusmod et ullam eos', 'Ex non consectetur', '2024-04-26 13:26:42', '2024-04-26 13:26:42', 0),
(38, 4, 10, NULL, 'اسماعيل', '3216549875', '14', 'JO', 1, 'Eum veniam reprehen', '', '2024-04-26 14:21:02', NULL, '2024-04-29 17:21:02', '356', NULL, 'Recusandae Consequa', NULL, '2024-04-26 14:21:02', '2024-04-26 14:21:02', 0),
(39, 4, 5, 1, 'Madeline Pierce', '1234567895', '25', 'JO', 3, 'Architecto non dolor', '', '2024-05-12 15:52:02', NULL, '2024-05-15 18:52:02', '789', NULL, 'Dolorem ullam ut sol', NULL, '2024-04-26 14:22:31', '2024-05-12 15:52:02', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `shipments`
--
ALTER TABLE `shipments`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `shipments`
--
ALTER TABLE `shipments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
