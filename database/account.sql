/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 100509
Source Host           : localhost:3306
Source Database       : fifa

Target Server Type    : MYSQL
Target Server Version : 100509
File Encoding         : 65001

Date: 2022-04-07 18:09:37
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for account
-- ----------------------------
DROP TABLE IF EXISTS `account`;
CREATE TABLE `account` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `username` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(255) DEFAULT NULL,
  `coins` int(11) DEFAULT NULL,
  `status` enum('active','disabled','in_progress','invalid') DEFAULT 'invalid',
  `type` enum('ps','xbox','origin') DEFAULT NULL,
  `code_count` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `daleted_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `account_username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of account
-- ----------------------------
INSERT INTO `account` VALUES ('1', '1', 'gargisbrhoxbck@zoho.eu', 'JHAtq8bjpz21', '10000', 'invalid', 'ps', '0', '2022-03-30 01:40:54', '2022-03-30 04:19:14');
INSERT INTO `account` VALUES ('2', '1', 'Fifaplaza005@gmail.com', 'Aazeez1994', '5000', 'active', 'ps', '0', '2022-03-30 01:40:54', '2022-03-30 01:40:54');

-- ----------------------------
-- Table structure for admin
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO `admin` VALUES ('1', 'Onyx', 'admin@gmail.com', '2021-03-22 00:07:42', '$2y$10$.I/Y1Am6z0i34n2Rupc3c.hjQtRUnDGRcWy4weY3gdn02bsVbWtiW', null, null, '2021-03-29 17:46:28', 'admin');

-- ----------------------------
-- Table structure for card
-- ----------------------------
DROP TABLE IF EXISTS `card`;
CREATE TABLE `card` (
   `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(500) DEFAULT NULL,
  `url` varchar(500) DEFAULT NULL,
  `raiting` varchar(255) DEFAULT NULL,
  `type` enum('type1','type2') NOT NULL DEFAULT 'type1',
   `price` int(11) DEFAULT NULL,
  `ps_start_price` int(11) DEFAULT NULL,
  `ps_end_price` int(11) DEFAULT NULL,
  `xbox_start_price` int(11) DEFAULT NULL,
  `xbox_end_price` int(11) DEFAULT NULL,
  `origin_start_price` int(11) DEFAULT NULL,
  `origin_end_price` int(11) DEFAULT NULL,
  `published` smallint(1) DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL,
   PRIMARY KEY (`id`)
)  ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
-- ----------------------------
-- Records of card
-- ----------------------------

-- ----------------------------
-- Table structure for code
-- ----------------------------
DROP TABLE IF EXISTS `code`;
CREATE TABLE `code` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL,
  `code` varchar(10) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of code
-- ----------------------------
INSERT INTO `code` VALUES ('1', '1', '123213');
INSERT INTO `code` VALUES ('2', '1', '34343');

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for faq
-- ----------------------------
DROP TABLE IF EXISTS `faq`;
CREATE TABLE `faq` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `system_name` varchar(255) DEFAULT '',
  `title` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT '',
  `text` longtext DEFAULT NULL,
  `published` tinyint(4) DEFAULT 1,
  `created_at` date DEFAULT NULL,
  `ordering` int(11) DEFAULT NULL,
  `image_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of faq
-- ----------------------------
INSERT INTO `faq` VALUES ('13', '', 'How1 do you deliver the OSRS Gold?', '<p>fghjfgjh</p>', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.</p>', '1', null, null, '29');
INSERT INTO `faq` VALUES ('14', '', 'How do you deliver the OSRS Gold?', '', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.</p>', '1', null, null, null);

-- ----------------------------
-- Table structure for log
-- ----------------------------
DROP TABLE IF EXISTS `log`;
CREATE TABLE `log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) DEFAULT NULL,
  `type` enum('validate') DEFAULT NULL,
  `data` varchar(500) DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `status` enum('success','fail') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of log
-- ----------------------------
INSERT INTO `log` VALUES ('1', '1', 'validate', 'Coins - 10.000', '2022-03-30 04:12:00', 'fail');

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES ('1', '2014_10_12_000000_create_users_table', '1');
INSERT INTO `migrations` VALUES ('2', '2014_10_12_100000_create_password_resets_table', '1');
INSERT INTO `migrations` VALUES ('3', '2019_08_19_000000_create_failed_jobs_table', '1');

-- ----------------------------
-- Table structure for order
-- ----------------------------
DROP TABLE IF EXISTS `order`;
CREATE TABLE `order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `coins` varchar(50) DEFAULT '',
  `amount` varchar(50) DEFAULT '',
  `type` enum('ps','xbox','origin') NOT NULL DEFAULT 'ps',
  `status` enum('in_progress','success','cancel','fail') NOT NULL DEFAULT 'in_progress',
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `created_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of order
-- ----------------------------
INSERT INTO `order` VALUES ('4', '3', '15000', '100', 'ps', 'success', '2022-03-15 17:28:07', '2022-03-15 17:28:07');
INSERT INTO `order` VALUES ('11', '5', '20000', '1', 'ps', 'in_progress', '2022-03-15 17:23:58', '2022-03-15 17:23:58');
INSERT INTO `order` VALUES ('12', '6', '100000', '10', 'ps', 'fail', '2022-03-15 17:29:47', '2022-03-15 17:29:47');

-- ----------------------------
-- Table structure for orderold
-- ----------------------------
DROP TABLE IF EXISTS `orderold`;
CREATE TABLE `orderold` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) DEFAULT NULL,
  `buyer_id` int(11) DEFAULT NULL,
  `platform` enum('ps','xbox') DEFAULT 'ps',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of orderold
-- ----------------------------
INSERT INTO `orderold` VALUES ('1', '1', '2', 'ps');

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for settings
-- ----------------------------
DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of settings
-- ----------------------------
INSERT INTO `settings` VALUES ('1', 'rso_rate', '0.56');
INSERT INTO `settings` VALUES ('2', 'rs_rate', '0.14');
INSERT INTO `settings` VALUES ('3', 'contact_email', 'test5@gmail.com');
INSERT INTO `settings` VALUES ('4', 'discord_link', 'https://discord.com/');

-- ----------------------------
-- Table structure for timezones
-- ----------------------------
DROP TABLE IF EXISTS `timezones`;
CREATE TABLE `timezones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of timezones
-- ----------------------------
INSERT INTO `timezones` VALUES ('1', '-12:00', '(GMT -12:00) Eniwetok, Kwajalein');
INSERT INTO `timezones` VALUES ('2', '-11:00', '(GMT -11:00) Midway Island, Samoa');
INSERT INTO `timezones` VALUES ('3', '-10:00', '(GMT -10:00) Hawaii');
INSERT INTO `timezones` VALUES ('4', '-09:50', '(GMT -9:30) Taiohae');
INSERT INTO `timezones` VALUES ('5', '-09:00', '(GMT -9:00) Alaska');
INSERT INTO `timezones` VALUES ('6', '-08:00', '(GMT -8:00) Pacific Time (US &amp; Canada)');
INSERT INTO `timezones` VALUES ('7', '-07:00', '(GMT -7:00) Mountain Time (US &amp; Canada)');
INSERT INTO `timezones` VALUES ('8', '-06:00', '(GMT -6:00) Central Time (US &amp; Canada), Mexico City');
INSERT INTO `timezones` VALUES ('9', '-05:00', '(GMT -5:00) Eastern Time (US &amp; Canada), Bogota, Lima');
INSERT INTO `timezones` VALUES ('10', '-04:50', '(GMT -4:30) Caracas');
INSERT INTO `timezones` VALUES ('11', '-04:00', '(GMT -4:00) Atlantic Time (Canada), Caracas, La Paz');
INSERT INTO `timezones` VALUES ('12', '-03:50', '(GMT -3:30) Newfoundland');
INSERT INTO `timezones` VALUES ('13', '-03:00', '(GMT -3:00) Brazil, Buenos Aires, Georgetown');
INSERT INTO `timezones` VALUES ('14', '-02:00', '(GMT -2:00) Mid-Atlantic');
INSERT INTO `timezones` VALUES ('15', '-01:00', '(GMT -1:00) Azores, Cape Verde Islands');
INSERT INTO `timezones` VALUES ('16', '+00:00', '(GMT) Western Europe Time, London, Lisbon, Casablanca');
INSERT INTO `timezones` VALUES ('17', '+01:00', '(GMT +1:00) Brussels, Copenhagen, Madrid, Paris');
INSERT INTO `timezones` VALUES ('18', '+02:00', '(GMT +2:00) Kaliningrad, South Africa');
INSERT INTO `timezones` VALUES ('19', '+03:00', '(GMT +3:00) Baghdad, Riyadh, Moscow, St. Petersburg');
INSERT INTO `timezones` VALUES ('20', '+03:50', '(GMT +3:30) Tehran');
INSERT INTO `timezones` VALUES ('21', '+04:00', '(GMT +4:00) Abu Dhabi, Muscat, Baku, Tbilisi');
INSERT INTO `timezones` VALUES ('22', '+04:50', '(GMT +4:30) Kabul');
INSERT INTO `timezones` VALUES ('23', '+05:00', '(GMT +5:00) Ekaterinburg, Islamabad, Karachi, Tashkent');
INSERT INTO `timezones` VALUES ('24', '+05:50', '(GMT +5:30) Bombay, Calcutta, Madras, New Delhi');
INSERT INTO `timezones` VALUES ('25', '+05:75', '(GMT +5:45) Kathmandu, Pokhar');
INSERT INTO `timezones` VALUES ('26', '+06:00', '(GMT +6:00) Almaty, Dhaka, Colombo');
INSERT INTO `timezones` VALUES ('27', '+06:50', '(GMT +6:30) Yangon, Mandalay');
INSERT INTO `timezones` VALUES ('28', '+07:00', '(GMT +7:00) Bangkok, Hanoi, Jakarta');
INSERT INTO `timezones` VALUES ('29', '+08:00', '(GMT +8:00) Beijing, Perth, Singapore, Hong Kong');
INSERT INTO `timezones` VALUES ('30', '+08:75', '(GMT +8:45) Eucla');
INSERT INTO `timezones` VALUES ('31', '+09:00', '(GMT +9:00) Tokyo, Seoul, Osaka, Sapporo, Yakutsk');
INSERT INTO `timezones` VALUES ('32', '+09:50', '(GMT +9:30) Adelaide, Darwin');
INSERT INTO `timezones` VALUES ('33', '+10:00', '(GMT +10:00) Eastern Australia, Guam, Vladivostok');
INSERT INTO `timezones` VALUES ('34', '+10:50', '(GMT +10:30) Lord Howe Island');
INSERT INTO `timezones` VALUES ('35', '+11:00', '(GMT +11:00) Magadan, Solomon Islands, New Caledonia');
INSERT INTO `timezones` VALUES ('36', '+11:50', '(GMT +11:30) Norfolk Island');
INSERT INTO `timezones` VALUES ('37', '+12:00', '(GMT +12:00) Auckland, Wellington, Fiji, Kamchatka');
INSERT INTO `timezones` VALUES ('38', '+12:75', '(GMT +12:45) Chatham Islands');
INSERT INTO `timezones` VALUES ('39', '+13:00', '(GMT +13:00) Apia, Nukualofa');
INSERT INTO `timezones` VALUES ('40', '+14:00', '(GMT +14:00) Line Islands, Tokelau');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `coins` int(11) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `accounts_count` int(11) DEFAULT NULL,
  `status` enum('active','disabled') COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `type` enum('customer','supplier') COLLATE utf8mb4_unicode_ci DEFAULT 'customer',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', '5655656', '0000-00-00 00:00:00', '$2y$10$E2E2oFhrKlWY7nvhbVxDROXgTNNpy/V0Zx.rxcLxJsS05BXQnkzr6', null, null, '2021-10-30 16:36:55', null, null, null, 'active', 'customer');
INSERT INTO `users` VALUES ('6', 'jon@gmail.com', null, '$2y$10$cZMpWlisEUjv9Wdy0hHaye7OX04fZmrfg3P9g8C.EBjbybUzqcu6W', null, '2021-04-05 14:57:19', '2021-10-30 16:45:19', null, null, null, 'active', 'supplier');
INSERT INTO `users` VALUES ('7', 'jonf@gmail.com', null, '$2y$10$qtYfyd4oC6lsC04hSk0DXOOLBUGG05zFLJRx1UmJKxylIWOFY.5Ee', null, '2021-04-05 15:08:18', '2021-10-29 23:11:41', null, null, null, 'disabled', 'customer');
INSERT INTO `users` VALUES ('8', 'asdasd@asdasd.com', null, '$2y$10$OKiAMzZ6K3QWQL4CbhdLg.ttR3PAfQDwfXyFRRd0N/qkqcj.s4r2K', null, '2021-04-05 15:15:58', '2022-03-19 15:28:53', null, null, null, 'disabled', 'supplier');
INSERT INTO `users` VALUES ('9', 'asdasddddd@asdasd.com', null, '$2y$10$Gz/HAZBNDE/u90vCVFjAvOD2MLHg6q4Il29sKQO5SR8bcBoxSryVC', null, '2021-04-09 14:37:16', '2022-03-29 20:05:06', null, null, null, 'active', 'customer');
SET FOREIGN_KEY_CHECKS=1;
