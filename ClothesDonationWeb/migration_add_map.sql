DROP DATABASE IF EXISTS `hackathon26_clothesdonationschema`;
CREATE DATABASE `hackathon26_clothesdonationschema` DEFAULT CHARACTER SET utf8mb4;
USE `hackathon26_clothesdonationschema`;

CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` varchar(255) NOT NULL DEFAULT 'false',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `countries` (
  `code` char(2) NOT NULL,
  `name` varchar(100) NOT NULL,
  `lat` decimal(9,6) NOT NULL,
  `lng` decimal(9,6) NOT NULL,
  `zoom` int NOT NULL DEFAULT 6,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `charities` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `country` char(2) NOT NULL,
  `city` varchar(100) NOT NULL DEFAULT '',
  `address` varchar(255) NOT NULL DEFAULT '',
  `lat` decimal(9,6) NOT NULL,
  `lng` decimal(9,6) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_charities_country` (`country`),
  CONSTRAINT `fk_charities_country` FOREIGN KEY (`country`) REFERENCES `countries` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `clothes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cloth_name` varchar(255) NOT NULL,
  `cloth_desc` varchar(255) NOT NULL,
  `cloth_quantity` int NOT NULL,
  `cloth_size` int NOT NULL,
  `cloth_img` varchar(255) NOT NULL DEFAULT '',
  `charity_id` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_clothes_charity` (`charity_id`),
  CONSTRAINT `fk_clothes_charity` FOREIGN KEY (`charity_id`) REFERENCES `charities` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `donations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `cloth_id` int NOT NULL,
  `nr_donations` int NOT NULL,
  `date` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL,
  `is_approved` varchar(255) NOT NULL DEFAULT 'false',
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_donations_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `fk_donations_cloth` FOREIGN KEY (`cloth_id`) REFERENCES `clothes` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `countries` (`code`,`name`,`lat`,`lng`,`zoom`) VALUES
('AL','Albania',41.15,20.17,7),
('XK','Kosovo',42.6,20.9,8),
('MK','North Macedonia',41.61,21.75,8),
('ME','Montenegro',42.71,19.37,8),
('RS','Serbia',44.02,21.01,7),
('BA','Bosnia and Herzegovina',43.92,17.68,7),
('HR','Croatia',45.1,15.2,7),
('SI','Slovenia',46.15,14.99,8),
('GR','Greece',39.07,21.82,6),
('BG','Bulgaria',42.73,25.49,7),
('RO','Romania',45.94,24.97,6),
('TR','Türkiye',38.96,35.24,6),
('DE','Germany',51.17,10.45,6),
('AT','Austria',47.52,14.55,7),
('CH','Switzerland',46.82,8.23,7),
('FR','France',46.23,2.21,6),
('ES','Spain',40.46,-3.75,6),
('PT','Portugal',39.4,-8.22,7),
('IT','Italy',41.87,12.57,6),
('NL','Netherlands',52.13,5.29,7),
('BE','Belgium',50.5,4.47,8),
('GB','United Kingdom',54.0,-2.0,6),
('IE','Ireland',53.41,-8.24,7),
('PL','Poland',51.92,19.15,6),
('CZ','Czechia',49.82,15.47,7),
('HU','Hungary',47.16,19.5,7),
('SK','Slovakia',48.67,19.7,7),
('UA','Ukraine',48.38,31.17,6),
('SE','Sweden',62.0,15.0,5),
('NO','Norway',64.0,10.0,5),
('FI','Finland',64.0,26.0,5),
('DK','Denmark',56.26,9.5,7),
('US','United States',39.8,-98.6,4),
('CA','Canada',56.1,-106.3,3),
('MX','Mexico',23.6,-102.5,5),
('BR','Brazil',-14.2,-51.9,4),
('AR','Argentina',-38.4,-63.6,4),
('IN','India',20.6,78.96,5),
('JP','Japan',36.2,138.25,5),
('AU','Australia',-25.3,133.8,4),
('EG','Egypt',26.8,30.8,6),
('NG','Nigeria',9.08,8.68,6),
('KE','Kenya',-0.02,37.9,6),
('ZA','South Africa',-30.56,22.94,5);

-- SAMPLE charities (invented names, real city centres). Delete them whenever you like.
INSERT INTO `charities` (`id`,`name`,`country`,`city`,`address`,`lat`,`lng`) VALUES
(1,'Warm Hands Prishtina','XK','Prishtina','Sample street 1',42.662900,21.165500),
(2,'Prizren Winter Aid','XK','Prizren','Sample street 2',42.213900,20.739700),
(3,'Tirana Coat Drive','AL','Tirana','Sample street 3',41.327500,19.818700),
(4,'Skopje Clothing Bank','MK','Skopje','Sample street 4',41.997300,21.428000),
(5,'Berlin Kleiderhilfe','DE','Berlin','Sample street 5',52.520000,13.405000);

INSERT INTO `clothes` (`cloth_name`, `cloth_desc`, `cloth_quantity`, `cloth_size`, `cloth_img`, `charity_id`) VALUES
('Winter coats', 'Warm, clean coats with working zippers.', 20, 40, '', 1),
('Children''s boots', 'Waterproof boots for kids.', 15, 32, '', 2),
('Wool sweaters', 'Thick sweaters, no holes or stains.', 10, 42, '', 3),
('Thermal socks', 'New or very lightly used socks.', 40, 38, '', 1);


ALTER TABLE `users`
  ADD COLUMN `charity_id` int NULL DEFAULT NULL,
  ADD KEY `idx_users_charity` (`charity_id`),
  ADD CONSTRAINT `fk_users_charity` FOREIGN KEY (`charity_id`) REFERENCES `charities` (`id`) ON DELETE SET NULL;