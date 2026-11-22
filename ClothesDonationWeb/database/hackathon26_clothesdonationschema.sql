-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 22, 2026 at 11:57 PM
-- Server version: 10.11.16-MariaDB
-- PHP Version: 8.3.36

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hackathon26_clothesdonationschema`
--

-- --------------------------------------------------------

--
-- Table structure for table `charities`
--

CREATE TABLE `charities` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `country` char(2) NOT NULL,
  `city` varchar(100) NOT NULL DEFAULT '',
  `address` varchar(255) NOT NULL DEFAULT '',
  `lat` decimal(9,6) NOT NULL,
  `lng` decimal(9,6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `charities`
--

INSERT INTO `charities` (`id`, `name`, `country`, `city`, `address`, `lat`, `lng`) VALUES
(1, 'Warm Hands Prishtina', 'XK', 'Prishtina', 'Sample street 1', 42.662900, 21.165500),
(2, 'Prizren Winter Aid', 'XK', 'Prizren', 'Sample street 2', 42.213900, 20.739700),
(3, 'Tirana Coat Drive', 'AL', 'Tirana', 'Sample street 3', 41.327500, 19.818700),
(4, 'Skopje Clothing Bank', 'MK', 'Skopje', 'Sample street 4', 41.997300, 21.428000),
(5, 'Berlin Kleiderhilfe', 'DE', 'Berlin', 'Sample street 5', 52.520000, 13.405000),
(6, 'Caritas Argentina', 'AR', 'Buenos Aires', 'Balcarce 236, Piso 1', 45.483826, 9.214773),
(7, 'Mission Australia', 'AU', 'Sydney', 'Level 7, 580 George Street, Sydney NSW 2000', -33.765449, 151.391602),
(8, 'Holiday Heroes', 'BG', 'Sofia', 'Zlatovrah 34, vhod Biznes, Floor 1, Sofia, Bulgaria.', 42.697920, 23.321958),
(12, 'Humana', 'AT', 'Wien', '45', 48.206327, 16.349192),
(17, 'Henry Laden', 'AT', 'Hollabrunn', 'Znaimerstraße 2', 48.566857, 16.079610),
(43, 'Soogut', 'AT', 'St. Pölten', 'Eybnerstraße 13', 48.209112, 15.631904),
(50, 'SamLa', 'AT', 'Ebreichsdorf', 'Wiener Neustädter Straße 20', 47.958182, 16.399856),
(51, 'carla', 'AT', 'Wien', 'Mittersteig 10', 48.192061, 16.362182),
(52, 'ORA-Flohmarkt', 'AT', 'Mauerkirchen', 'Spitzgasse 28', 48.194889, 13.133338),
(53, 'rifa', 'AT', 'Ried im Innkreis', 'Braunauer Straße 8', 48.206374, 13.480850),
(54, 'soogut Sozialmarkt Ternitz', 'AT', 'Ternitz', 'Gfiederstraße 3', 47.712972, 16.029864),
(56, 'SOLA Sozialladen', 'AT', 'Klosterneuburg', 'Magdeburggasse 7', 48.297244, 16.338209);

-- --------------------------------------------------------

--
-- Table structure for table `clothes`
--

CREATE TABLE `clothes` (
  `id` int(11) NOT NULL,
  `cloth_name` varchar(255) NOT NULL,
  `cloth_desc` varchar(255) NOT NULL,
  `cloth_quantity` int(11) NOT NULL,
  `cloth_size` int(11) NOT NULL,
  `cloth_img` varchar(255) NOT NULL DEFAULT '',
  `charity_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clothes`
--

INSERT INTO `clothes` (`id`, `cloth_name`, `cloth_desc`, `cloth_quantity`, `cloth_size`, `cloth_img`, `charity_id`) VALUES
(1, 'Winter coats', 'Warm, clean coats with working zippers.', 20, 40, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTMbuvosw18D3Y84uHKiem0RiEzHp6Itr8NXD-YylkrDA&s=10', 1),
(2, 'Children\'s boots', 'Waterproof boots for kids.', 15, 32, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTBSST5jRhmCBFWnTysIfcNB5tSWERwGToMtBNk256usA&s=10', 2),
(3, 'Wool sweaters', 'Thick sweaters, no holes or stains.', 10, 42, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQSuhRNi0ymKWxvrEcUV1oRoSk9h1n-QxIQoD-3fWPDiQ&s=10', 3),
(4, 'Thermal socks', 'New or very lightly used socks.', 40, 38, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSxaR9H1KeqPYe5JHZ5Ts8smqnm0JarYL2i91cepxyqzA&s=10', 1),
(5, 'Winter Coats', 'Warm, clean coats with working zippers', 17, 40, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTMbuvosw18D3Y84uHKiem0RiEzHp6Itr8NXD-YylkrDA&s=10', 3),
(6, 'Winter Coats', 'Warm, clean coats with working zippers', 20, 40, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQFp1Yxu0T3-SAVuMTLQEc8FmXOQ1Fy_RhJB9Az_s-qHg&s=10', 4),
(7, 'Children\'s Boots', 'Waterproof boots, clean and not damaged', 14, 32, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQoDi6QYMVyb9dqQWS2qXzGRHPpFWOfkwHv0LqRrR9dhw&s=10', 3),
(8, 'Children\'s Boots', 'Waterproof boots, clean and not damaged', 13, 32, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ8-u-sjM4IDZ6fqNImIU8AcgoJRSSOVEUE0hSN55h8Pw&s', 5),
(9, 'Wool Sweaters', 'Thick sweaters, no holes or stains', 11, 42, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQSuhRNi0ymKWxvrEcUV1oRoSk9h1n-QxIQoD-3fWPDiQ&s=10', 5),
(10, 'Wool Sweaters', 'Thick sweaters, no holes or stains', 15, 42, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQkE0J9fBpv4mIbNrhafSslYRZ4FTGNCfqQbyWU--4yXg&s=10', 4),
(11, 'Wool Sweaters', 'Thick sweaters, no holes or stains', 13, 42, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQpfe2h-Vr3Yy18ZnfXmQ2NomFD-qXlyTqXG7wU1-Cj7Q&s=10', 1),
(12, 'Wool Sweaters', 'Thick sweaters, no holes or stains', 16, 42, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRropFjy-UOQKnBF39zRZnpPQt3BUMXyyGKH4m1WjoDZA&s=10', 2),
(13, 'Thermal Socks', 'New or very lightly used thermal socks', 32, 38, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSSW15GbgKGIFjKISXLnvb61nCgpbpQeZsC6sodLTudow&s=10', 3),
(14, 'Thermal Socks', 'New or very lightly used thermal socks', 35, 38, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT8wQGVW6EML5kA91quzuZfXMC8zx7HEQP2Si9PZ1tFdg&s=10', 4),
(15, 'Women\'s Pants', 'Clean, wearable trousers and jeans', 14, 38, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT-KIP3sjMm7m4OQHdwzTgLaMqAShCWpACbpNlsp5ACaw&s=10', 3),
(16, 'Women\'s Pants', 'Clean, wearable trousers and jeans', 13, 38, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQriW7aDGeAiVL5DuWtX60LvW5KT7vVvIi882x788Uqsw&s=10', 5),
(17, 'Women\'s Pants', 'Clean, wearable trousers and jeans', 18, 38, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTpki_AtJn5X34XvdjJZ2IKHfuY134LHv_-kvHT6C9kTg&s=10', 2),
(18, 'Men\'s Pants', 'Clean, wearable trousers and jeans', 11, 42, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTzT50vEdYpU8sC4VIpasltWWTUiUvQk6Bn0etQQcNrMQ&s=10', 5),
(19, 'Men\'s Pants', 'Clean, wearable trousers and jeans', 15, 42, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQIXqLSHVthxZ2bbzxgOuK0Riz42m8pANR01TWVwJEegw&s=10', 4),
(20, 'Men\'s Pants', 'Clean, wearable trousers and jeans', 13, 42, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTzT50vEdYpU8sC4VIpasltWWTUiUvQk6Bn0etQQcNrMQ&s=10', 1),
(21, 'Men\'s Pants', 'Clean, wearable trousers and jeans', 16, 42, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRg3-Fyih_15k4fOiAd9bwYQ0sb2Nwojg9QMn1mA2RiNA&s=10', 2),
(22, 'Summer Dresses', 'Clean, no stains, light fabrics', 16, 36, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcToPEfX28YwQofVs3ARlqxcj3fn226j2n07Ev8nQ9yOGw&s=10', 3),
(23, 'Summer Dresses', 'Clean, no stains, light fabrics', 19, 36, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQAFkzn4il-dlANbXaL02UfBHXuYSF1R7JfJLvKeNHWlw&s=10', 4),
(24, 'Summer Dresses', 'Clean, no stains, light fabrics', 17, 36, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSBunsjC6UL-wsyW4aUAWLQLj-in7eU-8TVRP6Puh0p3w&s=10', 1),
(25, 'Children\'s Sweaters', 'Warm sweaters, clean, no stains', 20, 14, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTcT6cQlbt5VUFdAgnAmF5qTuply7sXoGwwIvpDJSYDsg&s', 3),
(26, 'Children\'s Sweaters', 'Warm sweaters, clean, no stains', 19, 12, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTJperEMFULaJv7p6H7wJQpDee8zhzNkXaUWvkLWwSrkw&s', 5),
(27, 'Children\'s Sweaters', 'Warm sweaters, clean, no stains', 24, 8, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQy7raqiKBQnRkiEsvkGbxi2XQNYtP9f-kGEi-jjLge2Q&s=10', 2),
(28, 'Rain Jackets', 'Waterproof jackets for adults and teens', 10, 44, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRLoDM1tWG7uF_jFB3BycjmCejATq_Ptc1aXEZNZQUD7g&s=10', 5),
(29, 'Rain Jackets', 'Waterproof jackets for adults and teens', 14, 44, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQn1GlVGgXIVyrMXjffZLEg7XC87396j0eyyca9TWC0ug&s=10', 4),
(30, 'Rain Jackets', 'Waterproof jackets for adults and teens', 12, 44, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR1zzcT1fUUDfNMXRwQfBMQLANvz8zUlZK2KXHdibUIgw&s=10', 1),
(31, 'Rain Jackets', 'Waterproof jackets for adults and teens', 15, 44, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQn1GlVGgXIVyrMXjffZLEg7XC87396j0eyyca9TWC0ug&s=10', 2),
(32, 'Winter Hats', 'Warm hats, clean, any colour', 27, 10, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRMtifoYY5ghnyXsWCloxUuuEvdS6s0twIAZD9YEeMj9A&s=10', 3),
(33, 'Winter Hats', 'Warm hats, clean, any colour', 30, 2, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSCDIzNfgeLe5OjSaAWaqAkgK2PJeCOTu-jPcE599ZScw&s=10', 4),
(34, 'Winter Hats', 'Warm hats, clean, any colour', 28, 9, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTEmcjIs4R0gFJ305CDN5WIOEBXX884TAwkgK7iQaLaNQ&s=10', 1),
(35, 'Winter Gloves', 'Pairs of warm gloves, no holes', 22, 8, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSu7A6tPFCvrE7dr88RAUJ_-Q681HS87JPbQO5ANTdUXQ&s=10', 3),
(36, 'Winter Gloves', 'Pairs of warm gloves, no holes', 21, 8, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQEftP_KC2KlKSeh4hEVgGqJyyQ3QczJH9P363hCeTTtw&s', 5),
(37, 'Winter Gloves', 'Pairs of warm gloves, no holes', 26, 8, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTHZSSFTcbc_StFR4wIvn-VI1Xn9Z_H1DYkHb41drXfLw&s=10', 2),
(38, 'Children\'s T-shirts', 'Cotton t-shirts, clean and not faded', 23, 16, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSR8ASc387glsWFTJ-Nip14rm4MBRGgVJg08Q_HZf6N8w&s=10', 5),
(39, 'Children\'s T-shirts', 'Cotton t-shirts, clean and not faded', 27, 14, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSR8ASc387glsWFTJ-Nip14rm4MBRGgVJg08Q_HZf6N8w&s=10', 4),
(40, 'Children\'s T-shirts', 'Cotton t-shirts, clean and not faded', 25, 10, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTPdMvCc2hC5n2q2OYO7-w2pVnd2YLG9hbiofXp63jEGg&s=10', 1),
(41, 'Children\'s T-shirts', 'Cotton t-shirts, clean and not faded', 28, 8, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSfQvcXeny8kWbTu5g6LKg_KDXoPiLXs72_wMHz6m14uA&s', 2),
(68, 'Accessories', 'clean', 20, 1, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQB82r9i9UzegfJ32_V-BFzXE7sD3uEQLdw5xBExDr4BQ&s=10', 12),
(69, 'Winter Gloves', 'clean', 23, 1, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRk-i_4TPAI2RL5HtqHqp2Icb0D9QqzaTzdM-6ivGdOyg&s=10', 8);

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `code` char(2) NOT NULL,
  `name` varchar(100) NOT NULL,
  `lat` decimal(9,6) NOT NULL,
  `lng` decimal(9,6) NOT NULL,
  `zoom` int(11) NOT NULL DEFAULT 6
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`code`, `name`, `lat`, `lng`, `zoom`) VALUES
('AL', 'Albania', 41.150000, 20.170000, 7),
('AR', 'Argentina', -38.400000, -63.600000, 4),
('AT', 'Austria', 47.520000, 14.550000, 7),
('AU', 'Australia', -25.300000, 133.800000, 4),
('BA', 'Bosnia and Herzegovina', 43.920000, 17.680000, 7),
('BE', 'Belgium', 50.500000, 4.470000, 8),
('BG', 'Bulgaria', 42.730000, 25.490000, 7),
('BR', 'Brazil', -14.200000, -51.900000, 4),
('CA', 'Canada', 56.100000, -106.300000, 3),
('CH', 'Switzerland', 46.820000, 8.230000, 7),
('CZ', 'Czechia', 49.820000, 15.470000, 7),
('DE', 'Germany', 51.170000, 10.450000, 6),
('DK', 'Denmark', 56.260000, 9.500000, 7),
('EG', 'Egypt', 26.800000, 30.800000, 6),
('ES', 'Spain', 40.460000, -3.750000, 6),
('FI', 'Finland', 64.000000, 26.000000, 5),
('FR', 'France', 46.230000, 2.210000, 6),
('GB', 'United Kingdom', 54.000000, -2.000000, 6),
('GR', 'Greece', 39.070000, 21.820000, 6),
('HR', 'Croatia', 45.100000, 15.200000, 7),
('HU', 'Hungary', 47.160000, 19.500000, 7),
('IE', 'Ireland', 53.410000, -8.240000, 7),
('IN', 'India', 20.600000, 78.960000, 5),
('IT', 'Italy', 41.870000, 12.570000, 6),
('JP', 'Japan', 36.200000, 138.250000, 5),
('KE', 'Kenya', -0.020000, 37.900000, 6),
('ME', 'Montenegro', 42.710000, 19.370000, 8),
('MK', 'North Macedonia', 41.610000, 21.750000, 8),
('MX', 'Mexico', 23.600000, -102.500000, 5),
('NG', 'Nigeria', 9.080000, 8.680000, 6),
('NL', 'Netherlands', 52.130000, 5.290000, 7),
('NO', 'Norway', 64.000000, 10.000000, 5),
('PL', 'Poland', 51.920000, 19.150000, 6),
('PT', 'Portugal', 39.400000, -8.220000, 7),
('RO', 'Romania', 45.940000, 24.970000, 6),
('RS', 'Serbia', 44.020000, 21.010000, 7),
('SE', 'Sweden', 62.000000, 15.000000, 5),
('SI', 'Slovenia', 46.150000, 14.990000, 8),
('SK', 'Slovakia', 48.670000, 19.700000, 7),
('TR', 'Türkiye', 38.960000, 35.240000, 6),
('UA', 'Ukraine', 48.380000, 31.170000, 6),
('US', 'United States', 39.800000, -98.600000, 4),
('XK', 'Kosovo', 42.600000, 20.900000, 8),
('ZA', 'South Africa', -30.560000, 22.940000, 5);

-- --------------------------------------------------------

--
-- Table structure for table `donations`
--

CREATE TABLE `donations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cloth_id` int(11) NOT NULL,
  `nr_donations` int(11) NOT NULL,
  `date` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL,
  `is_approved` varchar(255) NOT NULL DEFAULT 'false'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donations`
--

INSERT INTO `donations` (`id`, `user_id`, `cloth_id`, `nr_donations`, `date`, `time`, `is_approved`) VALUES
(1, 2, 2, 15, '2026-11-22', '16:00', 'true'),
(2, 2, 32, 17, '2026-11-26', '10:00', 'true'),
(3, 3, 69, 12, '2026-11-30', '10:00', 'true'),
(4, 3, 7, 12, '2026-11-23', '10:00', 'true'),
(5, 3, 68, 19, '2026-11-22', '09:00', 'true'),
(6, 3, 69, 5, '2026-11-24', '09:00', 'true');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` varchar(255) NOT NULL DEFAULT 'false',
  `charity_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `password`, `is_admin`, `charity_id`) VALUES
(1, 'diellamaqedonci', 'diellamaqedonci', 'diella@gmail.com', '$2y$10$FfW3tnQN6wPFJ7Dm2znd2u/iJvxQSq3gOvN9mcv/t9G8GoJI65U6m', '1', NULL),
(2, 'hana', 'hana', 'hana@gmail.com', '$2y$10$T0/TZfzYvUZUUaR/KfxZ1uv.v71dAMsJC8jlL0.v2d4Om3cDJCpuW', 'false', NULL),
(3, 'zana', 'zana', 'zana@gmail.com', '$2y$10$14p/G8cAHyBhxpQ3R0FC6eSAYC9ptkQZIB5BcbGGGWGFW/089FzE2', 'false', NULL),
(4, 'warmhandsprishtina', 'warmhandsprishtina', 'warmhandspr@gmail.com', '$2y$10$2EriuZJWLX9R8eWUVDMQSeEyNVRVShwEtm/AoAGPB7FnY1zZic5Iq', 'false', 1),
(5, 'prizrenwinteraid', 'prizrenwinteraid', 'prizrenwinteraid@gmail.com', '$2y$10$esBncX2GjWEvD4RrrQr6..qmRxCLr0SPHZCo/n9hF4xtyHOfwlF/C', 'false', 2),
(6, 'tiranacoatdrive', 'tiranacoatdrive', 'tiranacoatdrive@gmail.com', '$2y$10$AnrGyAs9De7kC5sUyd.17eetaMvCHPbxnp.Bbk8jRte4gFbkbN5CG', 'false', 3),
(7, 'skopjeclothingbank', 'skopjeclothingbank', 'skopjeclothingbank@gmail.com', '$2y$10$5VVmjcgCDbo.mbBtkL/nV.XPMttyP/PwHTnbxrNi3H/ikxiivQuzW', 'false', 4),
(8, 'berlinkleiderhilfe', 'berlinkleiderhilfe', 'berlinkleiderhilfe@gmail.com', '$2y$10$sLzI1g4PtOO6a0PKqSQrLezqDi20wIHYIhc5oL3F0Ht2oyF88xoR2', 'false', 5),
(9, 'egzona', 'egzona', 'egzona@gmail.com', '$2y$10$iSYEDv82jUfCpdxUjUqv5OZXzkXA3LVA4KfjwvgskJerNjB.LNNeW', 'false', NULL),
(10, 'caritasargentina', 'caritasargentina', 'caritasargentina@gmail.com', '$2y$10$3GkRbRBiOv8MR.EPjSryFe3TzLUihhOjskjiMyhs7gAi2lqSVu8Cy', 'false', 6),
(11, 'missionaustralia', 'missionaustralia', 'missionaustralia@gmail.com', '$2y$10$b/BJWMKElgcLzYTriG0y/.NDDdEIahA7/Yz1KjlaK.b9SdP9PFXvi', 'false', 7),
(12, 'holidayheroes', 'holidayheroes', 'holidayheroes@gmail.com', '$2y$10$Ld/MUQln.cYxspyWzj316enGZG3GfRCXbiImNwX3yHPpmD3RXaEWK', 'false', 8),
(13, 'humana', 'humana', 'humana@gmail.com', '$2y$10$CXyGqOHhGbVIQ7KS2VRgM.lS68tPZZezyozE.SZ4SivO9iFYi/mXG', 'false', 9),
(14, 'henryladen', 'henryladen', 'henryladen@gmail.com', '$2y$10$xGQNDC6Cj31rsBA1HIgfc.6Sb0z7LOmulJK1jvk1RJEx0XD.5mE.6', 'false', 10);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `charities`
--
ALTER TABLE `charities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_charities_country` (`country`);

--
-- Indexes for table `clothes`
--
ALTER TABLE `clothes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_clothes_charity` (`charity_id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`code`);

--
-- Indexes for table `donations`
--
ALTER TABLE `donations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_donations_user` (`user_id`),
  ADD KEY `fk_donations_cloth` (`cloth_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `charities`
--
ALTER TABLE `charities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `clothes`
--
ALTER TABLE `clothes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `donations`
--
ALTER TABLE `donations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `charities`
--
ALTER TABLE `charities`
  ADD CONSTRAINT `fk_charities_country` FOREIGN KEY (`country`) REFERENCES `countries` (`code`);

--
-- Constraints for table `clothes`
--
ALTER TABLE `clothes`
  ADD CONSTRAINT `fk_clothes_charity` FOREIGN KEY (`charity_id`) REFERENCES `charities` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `donations`
--
ALTER TABLE `donations`
  ADD CONSTRAINT `fk_donations_cloth` FOREIGN KEY (`cloth_id`) REFERENCES `clothes` (`id`),
  ADD CONSTRAINT `fk_donations_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
