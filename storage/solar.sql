/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 100424
 Source Host           : localhost:3306
 Source Schema         : solar

 Target Server Type    : MySQL
 Target Server Version : 100424
 File Encoding         : 65001

 Date: 04/10/2022 10:50:02
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for admin
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `email_verified_at` timestamp(0) NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `role` enum('superadmin','master') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 15 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO `admin` VALUES (1, 'Admin', 'asdasdsad', 'admin@gmail.com', '545450', '2021-03-22 00:07:42', '$2y$10$.I/Y1Am6z0i34n2Rupc3c.hjQtRUnDGRcWy4weY3gdn02bsVbWtiW', NULL, NULL, '2021-03-29 17:46:28', 'admin', 'superadmin', NULL);
INSERT INTO `admin` VALUES (13, 'Leonid', 'Sahakyan', 'leonid.sahakyan@gmail.com', '+37477701105', NULL, '$2y$10$u/k6G6bX8IS8iBwJTz4WbOSePlqB7wUil18Tr.mW1JdgVio8xulcC', NULL, '2022-09-29 13:08:08', '2022-09-29 13:08:08', 'leonid.sahakyan@gmail.com', 'master', NULL);
INSERT INTO `admin` VALUES (14, 'asdasd', 'asdasd', 'onyxsto@gmail.com', 'asdasdasd', NULL, '$2y$10$jpAoAopzgg/bfhk.OOoOWenJAX45FKDyyl/gqsIRgQQYVcgLBSN1e', NULL, '2022-09-29 13:09:21', '2022-09-29 13:09:21', 'onyxsto@gmail.com', 'master', NULL);

-- ----------------------------
-- Table structure for bookmarks
-- ----------------------------
DROP TABLE IF EXISTS `bookmarks`;
CREATE TABLE `bookmarks`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NULL DEFAULT NULL,
  `employee_id` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 33 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of bookmarks
-- ----------------------------
INSERT INTO `bookmarks` VALUES (8, 2, 11);
INSERT INTO `bookmarks` VALUES (10, 16, 13);
INSERT INTO `bookmarks` VALUES (26, 11, 13);
INSERT INTO `bookmarks` VALUES (27, 11, 16);
INSERT INTO `bookmarks` VALUES (28, 11, 3);
INSERT INTO `bookmarks` VALUES (29, 11, 2);
INSERT INTO `bookmarks` VALUES (30, 11, 36);
INSERT INTO `bookmarks` VALUES (31, 37, 13);
INSERT INTO `bookmarks` VALUES (32, 11, 63);

-- ----------------------------
-- Table structure for categories
-- ----------------------------
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `title_ru` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `title_am` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `title_en` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `parent_id` int NULL DEFAULT NULL,
  `icon` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `temp` tinyint(1) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `published` tinyint(1) NULL DEFAULT 0,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  `ordering` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 69 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of categories
-- ----------------------------
INSERT INTO `categories` VALUES (1, 'Репетиторство', 'Ուսուցում', 'Tutoring', 0, 'd02b27d4dc39.png', NULL, NULL, 1, NULL, 11);
INSERT INTO `categories` VALUES (2, 'Дошкольная подготовка', 'Նախադպրոցական պատրաստում', 'Preschool education', 1, 'c7c82059c0ba.png', NULL, NULL, 1, NULL, NULL);
INSERT INTO `categories` VALUES (3, 'Школьная программа', 'Դպրոցական ծրագիր', 'School curriculum', 1, '253cb01cd6cf.png', NULL, NULL, 1, NULL, NULL);
INSERT INTO `categories` VALUES (4, 'Подготовка абитуриентов', 'Ավարտական պատրաստումներ', 'High school graduate', 1, '48e637420af0.png', NULL, NULL, 0, '2022-09-29 12:12:13', NULL);
INSERT INTO `categories` VALUES (5, 'Дополнительное образование', 'Լրացուցիչ կրթություն', 'Additional education', 1, '2fa6943a9112.png', NULL, NULL, 1, NULL, NULL);
INSERT INTO `categories` VALUES (6, 'Услуги няни', 'Դայակի ծառայություններ', 'Babysitting', 0, '5c5bbf00ac9f.png', NULL, NULL, 1, NULL, 14);
INSERT INTO `categories` VALUES (7, 'Для детей', 'Երեխաների համար', 'For children', 6, '05939edfcbff.png', NULL, NULL, 1, NULL, 3);
INSERT INTO `categories` VALUES (8, 'Для людей с ограниченными возможностями', 'Հաշմանդամություն ունեցող անձանց համար', 'For people with special need', 6, '9d75cd2ecd40.png', NULL, NULL, 1, NULL, 2);
INSERT INTO `categories` VALUES (9, 'Для пожилых людей', 'Տարեց մարդկանց համար', 'For elderly', 6, '269792655767.png', NULL, NULL, 1, NULL, 1);
INSERT INTO `categories` VALUES (10, 'Медицинские услуги на дому', 'Բուժօգնություն տանը', 'Nursing', 0, 'fbb0597a6e24.png', NULL, NULL, 1, NULL, 12);
INSERT INTO `categories` VALUES (11, 'Уколы, системный уход', 'Ներարկումներ, համակարգային խնամք', 'Injections, systemic nursing care', 10, '2e4d7fa0a380.png', NULL, NULL, 1, NULL, 3);
INSERT INTO `categories` VALUES (12, 'Массаж', 'Մերսում', 'Massage', 10, '8b102a1fab80.png', NULL, NULL, 1, NULL, 2);
INSERT INTO `categories` VALUES (13, 'Услуги по уходу за собой', 'Խնամք', 'Beauty services', 0, '3719f69c5801.png', NULL, NULL, 1, NULL, 15);
INSERT INTO `categories` VALUES (14, 'Парикмахерские услуги', 'Վարսավիրի ծառայություններ', 'Hairstyling', 13, '315da843eefb.png', NULL, NULL, 1, NULL, 4);
INSERT INTO `categories` VALUES (15, 'Маникюр, педикюр', 'Մատնահարդարում և ոտնահարդարում', 'Manicure, pedicure', 13, '2f7e4a4f2eb3.png', NULL, NULL, 1, NULL, 3);
INSERT INTO `categories` VALUES (16, 'Косметология', 'Կոսմետոլոգիա', 'Cosmetology', 13, 'f94274bb48ac.png', NULL, NULL, 1, NULL, 2);
INSERT INTO `categories` VALUES (17, 'Шитье и рукоделие', 'Կար ու ձև / Ձեռքի աշխատանք', 'Handicraft', 0, 'aea6dcf19e3b.png', NULL, NULL, 1, NULL, 7);
INSERT INTO `categories` VALUES (18, 'Пошив и переделка', 'Կար ու ձև', 'Tailoring and upcycling', 17, '727f106dda5a.png', NULL, NULL, 1, NULL, 3);
INSERT INTO `categories` VALUES (19, 'Рукоделие', 'Ձեռքի աշխատանք', 'Handicraft', 17, '9b6e0403a7a0.png', NULL, NULL, 1, NULL, 2);
INSERT INTO `categories` VALUES (20, 'Фотография', 'Ֆոտոնկարահանում', 'Photography', 0, 'a620287d256f.png', NULL, NULL, 1, NULL, 10);
INSERT INTO `categories` VALUES (21, 'Студийная съемка', 'Նկարահանում տաղավարում', 'Studio shooting', 20, 'eabf28772ab5.png', NULL, NULL, 1, NULL, NULL);
INSERT INTO `categories` VALUES (22, 'Уличная съемка', 'Քաղաքային լուսանկարահանում', 'Streetstyle', 20, 'e1c069510db5.png', NULL, NULL, 1, NULL, NULL);
INSERT INTO `categories` VALUES (23, 'Съемка мероприятий', 'Միջոցառումների նկարահանում', 'Event shooting', 20, 'c3bfa00f1f8e.png', NULL, NULL, 1, NULL, NULL);
INSERT INTO `categories` VALUES (24, 'Кулинария', 'Խոհարարություն', 'Cookery', 0, 'ae101ddabd57.png', NULL, NULL, 1, NULL, 8);
INSERT INTO `categories` VALUES (25, 'Выпечка тортов на заказ', 'Պատվերով խմորեղենների պատրաստում', 'Baking on order', 24, '12663fb1c176.png', NULL, NULL, 1, NULL, 4);
INSERT INTO `categories` VALUES (26, 'Изготовление полуфабрикатов', 'Կիսաֆաբրիկատների պատրաստում', 'Semifinished food making', 24, 'b4b2dd1e065d.png', NULL, NULL, 1, NULL, 3);
INSERT INTO `categories` VALUES (27, 'Изготовление сухофруктов и консервирование', 'Չրերի և պահածոների պատրաստում', 'Dehydrated fruit making and conservation', 24, 'caf86b98ec6a.png', NULL, NULL, 1, NULL, 2);
INSERT INTO `categories` VALUES (28, 'Такси', 'Տաքսի ծառայություն', 'Taxi', 0, 'c4c7c31f4283.png', NULL, NULL, 1, NULL, 13);
INSERT INTO `categories` VALUES (29, 'Перевозка пассажиров', 'Ուղևորափոխադրումներ', 'Passenger transportation', 28, '2db2b34a43ca.png', NULL, NULL, 1, NULL, NULL);
INSERT INTO `categories` VALUES (30, 'Перевозка грузов', 'Ծանրոցների փոխադրում', 'Carriage of goods', 28, '948402232c29.png', NULL, NULL, 1, NULL, NULL);
INSERT INTO `categories` VALUES (31, 'Копирайтинг', 'Ստեղծագրություն', 'Сopywriting', 0, '781cab4edf1e.png', NULL, NULL, 1, NULL, 5);
INSERT INTO `categories` VALUES (32, 'Армянский язык', 'Հայերեն', 'Armenian', 31, 'e97fe517a103.png', NULL, NULL, 1, NULL, 2);
INSERT INTO `categories` VALUES (33, 'Русский язык', 'Ռուսերեն', 'Russian', 31, '0b03e54c5034.png', NULL, NULL, 1, NULL, 3);
INSERT INTO `categories` VALUES (34, 'Английский язык', 'Անգլերեն', 'English', 31, '627591bb2c59.png', NULL, NULL, 1, NULL, 4);
INSERT INTO `categories` VALUES (35, 'SMM', 'SMM', 'SMM', 0, '9f5478066048.png', NULL, NULL, 1, NULL, 4);
INSERT INTO `categories` VALUES (36, 'Ювелирное дело', 'Զարդեր', 'Jewellery', 0, '2792d26e62a7.png', NULL, NULL, 1, NULL, 3);
INSERT INTO `categories` VALUES (37, 'Кузнечное дело', 'Դարբին', 'Smithcraft', 0, '54b020308f61.png', NULL, NULL, 1, NULL, 2);
INSERT INTO `categories` VALUES (38, 'Ремонт и строительство', 'Վերանորոգում և շինարարություն', 'Repair and construction', 0, 'e79107d04777.png', NULL, NULL, 1, NULL, 16);
INSERT INTO `categories` VALUES (39, 'Дом', 'Տուն', 'Home decorating', 38, '29be282dc176.png', NULL, NULL, 1, NULL, 5);
INSERT INTO `categories` VALUES (40, 'Сантехника', 'Սանտեխնիկա', 'Plumbing fixtures', 38, '11d1488b8a0e.png', NULL, NULL, 1, NULL, 3);
INSERT INTO `categories` VALUES (41, 'Бытовая техника', 'Կենցաղային տեխնիկա', 'Household appliances', 38, '781648723ac4.png', NULL, NULL, 1, NULL, 4);
INSERT INTO `categories` VALUES (42, 'Ремонт компьютеров', 'Համակարգչային օգնություն', 'Computer equipment', 38, 'a0a6d65ccc85.png', NULL, NULL, 1, NULL, 2);
INSERT INTO `categories` VALUES (43, 'Клининг', 'Մաքրման ծառայություններ', 'Cleaning', 0, '442d0be676f9.png', NULL, NULL, 1, NULL, 9);
INSERT INTO `categories` VALUES (44, 'Организация и проведение праздников и торжеств', 'Միջոցառումների կազմակերպում', 'Party planning', 0, '346537487433.png', NULL, NULL, 1, NULL, 6);
INSERT INTO `categories` VALUES (45, 'Дизайн и декорации', 'Դիզայն և դեկոռացիաներ', 'Design and decoration', 44, 'ed260392ae2e.png', NULL, NULL, 1, NULL, 4);
INSERT INTO `categories` VALUES (46, 'Сценарий', 'Սցենարագրություն', 'Script', 44, '7fc6117ef103.png', NULL, NULL, 1, NULL, 3);
INSERT INTO `categories` VALUES (47, 'Тамада', 'Թամադա', 'Entertainer', 44, '20a589758fa1.png', NULL, NULL, 1, NULL, 2);
INSERT INTO `categories` VALUES (48, 'Другое', 'Այլ', 'Other', 0, NULL, NULL, NULL, 0, NULL, 1);
INSERT INTO `categories` VALUES (53, 'Другое', 'Այլ', 'Other', 10, 'ad29c7d23ea6.png', NULL, '2022-07-12 10:58:53', 1, NULL, 1);
INSERT INTO `categories` VALUES (54, 'Другое', 'Այլ', 'Other', 13, '0dd0ad38bb7c.png', NULL, '2022-07-12 11:06:41', 1, NULL, 1);
INSERT INTO `categories` VALUES (55, 'Другое', 'Այլ', 'Other', 17, 'd33ad592f902.png', NULL, '2022-07-12 11:15:15', 1, NULL, 1);
INSERT INTO `categories` VALUES (56, 'Другое', 'Այլ', 'Other', 44, '3925b054bf68.png', NULL, '2022-07-12 11:38:39', 1, NULL, 1);
INSERT INTO `categories` VALUES (57, 'Другое', 'Այլ', 'Other', 31, '7ec428d4510d.png', NULL, '2022-07-12 12:52:30', 1, NULL, 1);
INSERT INTO `categories` VALUES (59, 'Другое', 'Այլ', 'Other', 24, '36e980899e73.png', NULL, '2022-07-12 12:53:57', 1, NULL, 1);
INSERT INTO `categories` VALUES (60, 'Другое', 'Այլ', 'Other', 38, '1e2b9b917521.png', NULL, '2022-07-12 12:57:53', 1, NULL, 1);
INSERT INTO `categories` VALUES (61, NULL, NULL, NULL, 0, NULL, 1, '2022-08-25 12:18:58', 0, NULL, 17);
INSERT INTO `categories` VALUES (62, NULL, NULL, NULL, 0, NULL, 1, '2022-09-29 08:54:16', 0, NULL, 18);
INSERT INTO `categories` VALUES (63, NULL, NULL, NULL, 0, NULL, 1, '2022-09-29 08:58:25', 0, NULL, 19);
INSERT INTO `categories` VALUES (64, NULL, NULL, NULL, 0, NULL, 1, '2022-09-29 08:58:42', 0, NULL, 20);
INSERT INTO `categories` VALUES (65, NULL, NULL, NULL, 0, NULL, 1, '2022-09-29 09:50:45', 0, NULL, 21);
INSERT INTO `categories` VALUES (66, NULL, NULL, NULL, 0, '4f20f685aa32.jpg', 1, '2022-09-29 11:19:13', 0, NULL, 22);
INSERT INTO `categories` VALUES (67, NULL, NULL, NULL, 0, '4e69c628b8f6.jpg', 1, '2022-09-29 11:19:53', 0, NULL, 23);
INSERT INTO `categories` VALUES (68, NULL, NULL, NULL, 0, '606572119fb6.jpg', 1, '2022-09-29 11:24:41', 0, NULL, 24);

-- ----------------------------
-- Table structure for code
-- ----------------------------
DROP TABLE IF EXISTS `code`;
CREATE TABLE `code`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `phone` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `code` int NULL DEFAULT NULL,
  `used` tinyint(1) NOT NULL DEFAULT 0,
  `exp_date` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 321 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of code
-- ----------------------------
INSERT INTO `code` VALUES (179, '37477701105', 563049, 0, '2022-06-16 15:05:07');
INSERT INTO `code` VALUES (180, '37494233447', 151848, 0, '2022-06-16 15:05:49');
INSERT INTO `code` VALUES (181, '37477252052', 283639, 1, '2022-06-16 15:48:35');
INSERT INTO `code` VALUES (182, '37499993999', 640824, 1, '2022-06-16 16:31:50');
INSERT INTO `code` VALUES (183, '37494233447', 353473, 0, '2022-06-18 18:02:33');
INSERT INTO `code` VALUES (184, '37494233447', 577713, 0, '2022-06-18 18:07:50');
INSERT INTO `code` VALUES (185, '37494233447', 904989, 0, '2022-06-18 18:12:16');
INSERT INTO `code` VALUES (186, '37494233447', 684061, 0, '2022-06-18 18:21:27');
INSERT INTO `code` VALUES (187, '37494233447', 154070, 0, '2022-06-18 18:28:22');
INSERT INTO `code` VALUES (188, '37494233447', 705528, 0, '2022-06-18 20:21:00');
INSERT INTO `code` VALUES (189, '37494233447', 424197, 0, '2022-06-18 20:27:41');
INSERT INTO `code` VALUES (190, '37494233447', 319658, 0, '2022-06-18 20:29:25');
INSERT INTO `code` VALUES (191, '37494233447', 123816, 0, '2022-06-18 20:30:43');
INSERT INTO `code` VALUES (192, '37494233447', 226721, 0, '2022-06-18 20:38:23');
INSERT INTO `code` VALUES (193, '37494233447', 791574, 0, '2022-06-18 20:42:24');
INSERT INTO `code` VALUES (194, '37494233447', 429243, 1, '2022-06-18 20:44:14');
INSERT INTO `code` VALUES (195, '37494233447', 506655, 0, '2022-06-18 20:46:08');
INSERT INTO `code` VALUES (196, '37494233447', 250756, 1, '2022-06-18 20:47:31');
INSERT INTO `code` VALUES (197, '37497979797', 825270, 0, '2022-06-18 20:51:13');
INSERT INTO `code` VALUES (198, '37497979797', 128484, 0, '2022-06-18 20:52:13');
INSERT INTO `code` VALUES (199, '37494233447', 303041, 1, '2022-06-18 21:10:33');
INSERT INTO `code` VALUES (200, '37494233446', 269428, 0, '2022-06-18 21:11:00');
INSERT INTO `code` VALUES (201, '37494088020', 657520, 1, '2022-06-19 08:04:23');
INSERT INTO `code` VALUES (202, '37494233447', 212049, 1, '2022-06-19 15:25:08');
INSERT INTO `code` VALUES (203, '37494233447', 320454, 0, '2022-06-20 08:34:34');
INSERT INTO `code` VALUES (204, '37494233447', 932701, 1, '2022-06-20 09:03:30');
INSERT INTO `code` VALUES (205, '37494233446', 295946, 0, '2022-06-20 10:40:48');
INSERT INTO `code` VALUES (206, '37494233446', 491456, 0, '2022-06-20 10:43:15');
INSERT INTO `code` VALUES (207, '37494233446', 378320, 0, '2022-06-20 10:45:38');
INSERT INTO `code` VALUES (208, '37494233444', 703136, 0, '2022-06-20 10:47:05');
INSERT INTO `code` VALUES (209, '37494233443', 587659, 0, '2022-06-20 10:48:11');
INSERT INTO `code` VALUES (210, '37494233446', 462747, 0, '2022-06-20 10:50:01');
INSERT INTO `code` VALUES (211, '37494233447', 507037, 1, '2022-06-20 12:40:04');
INSERT INTO `code` VALUES (212, '37494233447', 824209, 0, '2022-06-20 16:46:09');
INSERT INTO `code` VALUES (213, '37494233447', 352387, 1, '2022-06-20 16:49:37');
INSERT INTO `code` VALUES (214, '37494233447', 420069, 1, '2022-06-21 08:21:27');
INSERT INTO `code` VALUES (215, '37411111112', 420069, 0, '2022-06-21 10:40:02');
INSERT INTO `code` VALUES (216, '37411111112', 420069, 1, '2022-06-21 10:42:05');
INSERT INTO `code` VALUES (217, '37494233447', 420069, 1, '2022-06-21 12:44:42');
INSERT INTO `code` VALUES (218, '37433555888', 420069, 1, '2022-06-21 12:47:21');
INSERT INTO `code` VALUES (219, '37494233447', 420069, 1, '2022-06-21 13:16:14');
INSERT INTO `code` VALUES (220, '37412123456', 420069, 1, '2022-06-21 13:56:13');
INSERT INTO `code` VALUES (221, '37412123456', 420069, 1, '2022-06-22 07:45:12');
INSERT INTO `code` VALUES (222, '37494233447', 420069, 1, '2022-06-22 14:27:32');
INSERT INTO `code` VALUES (223, '37494233447', 420069, 1, '2022-06-23 21:13:49');
INSERT INTO `code` VALUES (224, '37494233447', 420069, 1, '2022-06-29 12:43:52');
INSERT INTO `code` VALUES (225, '37477701105', 420069, 1, '2022-06-29 13:02:35');
INSERT INTO `code` VALUES (226, '37494233447', 420069, 1, '2022-06-29 14:11:19');
INSERT INTO `code` VALUES (227, '37455184607', 420069, 0, '2022-06-30 12:21:42');
INSERT INTO `code` VALUES (228, '37455184607', 420069, 0, '2022-06-30 12:22:51');
INSERT INTO `code` VALUES (229, '37455184607', 420069, 0, '2022-06-30 12:24:37');
INSERT INTO `code` VALUES (230, '37455184607', 420069, 1, '2022-06-30 12:26:39');
INSERT INTO `code` VALUES (231, '37477808915', 420069, 1, '2022-06-30 12:31:43');
INSERT INTO `code` VALUES (232, '37477701105', 420069, 1, '2022-07-01 09:08:10');
INSERT INTO `code` VALUES (233, '37455252308', 420069, 1, '2022-07-01 13:25:54');
INSERT INTO `code` VALUES (234, '37412123456', 420069, 1, '2022-07-01 13:32:19');
INSERT INTO `code` VALUES (235, '37456565656', 420069, 1, '2022-07-01 13:40:33');
INSERT INTO `code` VALUES (236, '37455236603', 420069, 1, '2022-07-01 13:41:25');
INSERT INTO `code` VALUES (237, '37494233447', 420069, 1, '2022-07-01 15:35:29');
INSERT INTO `code` VALUES (238, '37422558855', 420069, 0, '2022-07-01 16:13:38');
INSERT INTO `code` VALUES (239, '37412123456', 420069, 1, '2022-07-01 16:23:09');
INSERT INTO `code` VALUES (240, '37494233447', 420069, 1, '2022-07-01 17:10:55');
INSERT INTO `code` VALUES (241, '37494233447', 420069, 1, '2022-07-01 21:01:37');
INSERT INTO `code` VALUES (242, '37494233447', 420069, 1, '2022-07-01 21:02:47');
INSERT INTO `code` VALUES (243, '37494233447', 420069, 1, '2022-07-02 17:41:01');
INSERT INTO `code` VALUES (244, '37494233447', 420069, 1, '2022-07-02 18:50:30');
INSERT INTO `code` VALUES (245, '37499666333', 420069, 1, '2022-07-05 10:25:14');
INSERT INTO `code` VALUES (246, '37463252525', 420069, 1, '2022-07-05 10:40:31');
INSERT INTO `code` VALUES (247, '37463252525', 420069, 1, '2022-07-05 10:41:49');
INSERT INTO `code` VALUES (248, '37463252525', 420069, 1, '2022-07-05 10:43:27');
INSERT INTO `code` VALUES (249, '37422555888', 420069, 1, '2022-07-05 10:44:54');
INSERT INTO `code` VALUES (250, '37411444555', 420069, 1, '2022-07-05 10:46:19');
INSERT INTO `code` VALUES (251, '37494233447', 420069, 1, '2022-07-05 11:21:11');
INSERT INTO `code` VALUES (252, '37412123456', 420069, 1, '2022-07-05 16:58:34');
INSERT INTO `code` VALUES (253, '37494233447', 420069, 1, '2022-07-05 17:17:18');
INSERT INTO `code` VALUES (254, '37494233447', 420069, 1, '2022-07-05 17:19:03');
INSERT INTO `code` VALUES (255, '37494233447', 420069, 1, '2022-07-06 12:54:06');
INSERT INTO `code` VALUES (256, '37494081568', 420069, 1, '2022-07-07 06:43:16');
INSERT INTO `code` VALUES (257, '37494233447', 420069, 1, '2022-07-07 08:49:32');
INSERT INTO `code` VALUES (258, '37494233447', 420069, 1, '2022-07-07 08:58:31');
INSERT INTO `code` VALUES (259, '37494233447', 420069, 1, '2022-07-07 15:56:56');
INSERT INTO `code` VALUES (260, '37494233447', 420069, 0, '2022-07-07 16:48:04');
INSERT INTO `code` VALUES (261, '37494233447', 420069, 1, '2022-07-07 16:50:46');
INSERT INTO `code` VALUES (262, '37494233447', 420069, 1, '2022-07-07 16:53:23');
INSERT INTO `code` VALUES (263, '37412123456', 420069, 1, '2022-07-07 17:04:56');
INSERT INTO `code` VALUES (264, '37494233447', 420069, 1, '2022-07-07 18:02:05');
INSERT INTO `code` VALUES (265, '37494233447', 420069, 1, '2022-07-07 19:58:16');
INSERT INTO `code` VALUES (266, '37412123456', 420069, 1, '2022-07-07 19:58:59');
INSERT INTO `code` VALUES (267, '37494233447', 420069, 0, '2022-07-07 20:19:57');
INSERT INTO `code` VALUES (268, '37494233443', 420069, 1, '2022-07-07 20:23:11');
INSERT INTO `code` VALUES (269, '37412121212', 420069, 0, '2022-07-07 20:28:34');
INSERT INTO `code` VALUES (270, '37494233447', 420069, 0, '2022-07-07 20:32:16');
INSERT INTO `code` VALUES (271, '37494233447', 420069, 0, '2022-07-07 20:35:35');
INSERT INTO `code` VALUES (272, '37494233447', 420069, 1, '2022-07-07 20:44:10');
INSERT INTO `code` VALUES (273, '37494233447', 420069, 1, '2022-07-07 20:44:54');
INSERT INTO `code` VALUES (274, '37494233447', 420069, 1, '2022-07-07 21:07:36');
INSERT INTO `code` VALUES (275, '37494233447', 420069, 1, '2022-07-07 21:09:29');
INSERT INTO `code` VALUES (276, '37494233446', 420069, 1, '2022-07-08 06:21:27');
INSERT INTO `code` VALUES (277, '37494233447', 420069, 1, '2022-07-08 06:22:52');
INSERT INTO `code` VALUES (278, '37494233446', 420069, 0, '2022-07-08 06:23:23');
INSERT INTO `code` VALUES (279, '37414141414', 420069, 1, '2022-07-08 06:44:01');
INSERT INTO `code` VALUES (280, '37494233447', 420069, 1, '2022-07-08 09:50:27');
INSERT INTO `code` VALUES (281, '37494233447', 420069, 1, '2022-07-08 13:19:07');
INSERT INTO `code` VALUES (282, '37477252052', 420069, 1, '2022-07-08 15:21:40');
INSERT INTO `code` VALUES (283, '37494233447', 420069, 1, '2022-07-08 15:27:37');
INSERT INTO `code` VALUES (284, '37494267690', 420069, 0, '2022-07-11 08:15:31');
INSERT INTO `code` VALUES (285, '37494267690', 420069, 1, '2022-07-11 08:17:28');
INSERT INTO `code` VALUES (286, '37411447700', 420069, 1, '2022-07-12 21:16:37');
INSERT INTO `code` VALUES (287, '37422885544', 420069, 1, '2022-07-12 21:19:18');
INSERT INTO `code` VALUES (288, '37411885522', 420069, 1, '2022-07-12 21:22:17');
INSERT INTO `code` VALUES (289, '37499662244', 420069, 1, '2022-07-12 21:24:42');
INSERT INTO `code` VALUES (290, '37411880077', 420069, 1, '2022-07-12 21:26:22');
INSERT INTO `code` VALUES (291, '37466554477', 420069, 1, '2022-07-12 21:27:35');
INSERT INTO `code` VALUES (292, '37466332288', 420069, 1, '2022-07-12 21:30:39');
INSERT INTO `code` VALUES (293, '37411447709', 420069, 1, '2022-07-12 21:35:09');
INSERT INTO `code` VALUES (294, '37422558866', 420069, 1, '2022-07-12 21:37:54');
INSERT INTO `code` VALUES (295, '37425885211', 420069, 1, '2022-07-12 21:44:25');
INSERT INTO `code` VALUES (296, '37433669988', 420069, 1, '2022-07-12 21:51:53');
INSERT INTO `code` VALUES (297, '37455774411', 420069, 1, '2022-07-12 21:54:00');
INSERT INTO `code` VALUES (298, '37494233447', 420069, 1, '2022-07-12 22:05:13');
INSERT INTO `code` VALUES (299, '37412123456', 420069, 1, '2022-07-12 22:07:42');
INSERT INTO `code` VALUES (300, '37477252052', 420069, 1, '2022-07-13 11:46:44');
INSERT INTO `code` VALUES (301, '37494233447', 420069, 1, '2022-07-13 14:03:19');
INSERT INTO `code` VALUES (302, '37415648521', 420069, 1, '2022-07-13 17:08:38');
INSERT INTO `code` VALUES (303, '37494233447', 420069, 1, '2022-07-13 17:19:18');
INSERT INTO `code` VALUES (304, '37494233447', 420069, 1, '2022-07-13 17:22:35');
INSERT INTO `code` VALUES (305, '37433666999', 420069, 1, '2022-07-13 17:23:04');
INSERT INTO `code` VALUES (306, '37415935742', 420069, 1, '2022-07-13 17:49:30');
INSERT INTO `code` VALUES (307, '37494233447', 420069, 1, '2022-07-13 17:50:06');
INSERT INTO `code` VALUES (308, '37477252052', 420069, 1, '2022-07-14 09:49:50');
INSERT INTO `code` VALUES (309, '37455221819', 420069, 0, '2022-07-18 17:46:38');
INSERT INTO `code` VALUES (310, '37477701105', 420069, 0, '2022-07-19 07:54:13');
INSERT INTO `code` VALUES (311, '37477701105', 420069, 1, '2022-07-20 12:10:24');
INSERT INTO `code` VALUES (312, '37477701105', 420069, 1, '2022-07-20 12:13:04');
INSERT INTO `code` VALUES (313, '37477701105', 420069, 1, '2022-07-20 12:17:46');
INSERT INTO `code` VALUES (314, '17477701105', 420069, 0, '2022-08-05 09:27:22');
INSERT INTO `code` VALUES (315, '17477701105', 420069, 0, '2022-08-05 09:33:20');
INSERT INTO `code` VALUES (316, '17477701105', 420069, 0, '2022-08-05 09:36:40');
INSERT INTO `code` VALUES (317, '17477701105', 420069, 0, '2022-08-05 09:42:30');
INSERT INTO `code` VALUES (318, '37477701105', 420069, 1, '2022-08-08 09:06:14');
INSERT INTO `code` VALUES (319, '37477701105', 694972, 1, '2022-09-12 11:33:25');
INSERT INTO `code` VALUES (320, '37477701105', 845938, 1, '2022-09-12 12:38:29');

-- ----------------------------
-- Table structure for dictionary
-- ----------------------------
DROP TABLE IF EXISTS `dictionary`;
CREATE TABLE `dictionary`  (
  `key` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `en` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `am` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `ru` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`key`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dictionary
-- ----------------------------
INSERT INTO `dictionary` VALUES ('AddServiceCategorieDropdownPlaceholder', 'Choose Service', 'Ընտրել ծառայությունը', 'Выбрать категорию');
INSERT INTO `dictionary` VALUES ('AddServiceSubCategorieDropdownPlaceholder', 'Choose Subservice', 'Ընտրել ենթակատեգորիան', 'Выбрать подкатегорию');
INSERT INTO `dictionary` VALUES ('ChangePhoneVerificationDescription', 'We sent an SMS to your mobile number ********', 'Մենք հաղորդագրություն ենք ուղարկել հետևյալ համարին********', 'Мы отправили SMS на номер ********');
INSERT INTO `dictionary` VALUES ('ChangePhoneVerificationInputTopText', 'Enter 6 digits code', 'Մուտքագրեք 6-նիշ ծածկագիրը', 'Ввести 6-значный код');
INSERT INTO `dictionary` VALUES ('ChangePhoneVerificationPrimaryButtonText', 'Resend Code', 'Ուղարկել ծածկագիրը կրկին', 'Выслать код повторно');
INSERT INTO `dictionary` VALUES ('ChangePhoneVerificationPrimaryButtonTextVerified', 'Verify', 'Հաստատել', 'Подтвердить');
INSERT INTO `dictionary` VALUES ('ChangePhoneVerificationTitle', 'Verify new phone number', 'Հաստատել նոր հեռախոսահամարը', 'Подтвердить новый номер телефона');
INSERT INTO `dictionary` VALUES ('CustomerOrdersActiveOrderCancelText', 'Cancel', 'Չեղարկել', 'Отменить');
INSERT INTO `dictionary` VALUES ('EmployeeAddYourFirstService', 'Add Your First Service', 'Ավելացրեք Ձեր առաջին ծառայությունը', 'Добавьте свою первую услугу');
INSERT INTO `dictionary` VALUES ('EmployeeInfoVerifiedBadeText', 'Verified', 'Հաստատված', 'Подтверждено');
INSERT INTO `dictionary` VALUES ('EmployeeListSendRequestModalCancelButtonText', 'Cancel', 'Չեղարկել', 'Отменить');
INSERT INTO `dictionary` VALUES ('EmployeeListSendRequestModalHeaderTitle', 'Send The Request', 'Ուղարկել հարցում', 'Отправить запрос');
INSERT INTO `dictionary` VALUES ('EmployeeListSendRequestModalInputTitle', 'Description*', 'Նկարագրություն*', 'Описание*');
INSERT INTO `dictionary` VALUES ('EmployeeListSendRequestModalPriceTitle', 'Your Prefered Price', 'Նախընտրելի արժեք', 'Желаемая стоимость');
INSERT INTO `dictionary` VALUES ('EmployeeListSendRequestModalSendButtonText', 'Send', 'Ուղարկել', 'Отправить');
INSERT INTO `dictionary` VALUES ('EmployeeListTitle', 'Employees', 'Մասնագետներ', 'Специалисты');
INSERT INTO `dictionary` VALUES ('EmployeeOrdersStatusApproved', 'Approved', 'Approved', 'Approved');
INSERT INTO `dictionary` VALUES ('EmployeeOrdersStatusCanceled', 'Canceled', 'Canceled', 'Canceled');
INSERT INTO `dictionary` VALUES ('EmployeeOrdersStatusDeclined', 'Declined', 'Declined', 'Declined');
INSERT INTO `dictionary` VALUES ('EmployeeOrdersStatusWaiting', 'Waiting', 'Waiting', 'Waiting');
INSERT INTO `dictionary` VALUES ('EmployeePageAboutMeTitle', 'About Me', 'Իմ մասին', 'Обо мне');
INSERT INTO `dictionary` VALUES ('EmployeePageMyServicesTitle', 'My Services', 'Իմ ծառայությունները', 'Мои услуги');
INSERT INTO `dictionary` VALUES ('EmployeePageReviewsTabTitle', 'Reviews', 'Կարծիքներ', 'Отзывы');
INSERT INTO `dictionary` VALUES ('EmployeePageServicesTabTitle', 'Services', 'Ծառայությունների ցանկ', 'Категории');
INSERT INTO `dictionary` VALUES ('HomeCategoriesSearchPlaceholder', 'Category search', 'HomeCategoriesSearchPlaceholder', 'Поиск по категориям');
INSERT INTO `dictionary` VALUES ('HomeCustomerCategoriesTitle', 'Services', 'Ծառայությունների ցանկ', 'Категории');
INSERT INTO `dictionary` VALUES ('HomeCustomerNoResultsFound', 'No Results Found', 'Արդյունքներ չեն գտնվել', 'Не найдено');
INSERT INTO `dictionary` VALUES ('HomeCustomerResultsTitle', 'Results', 'Արդյունք', 'Результат');
INSERT INTO `dictionary` VALUES ('HomeEmployeeAddServiceCancelButtonText', 'Cancel', 'Չեղարկել', 'Отменить');
INSERT INTO `dictionary` VALUES ('HomeEmployeeAddServiceDeleteServiceText', 'Delete service', 'Հեռացնել ծառայությունը', 'Удалить категорию');
INSERT INTO `dictionary` VALUES ('HomeEmployeeAddServiceDropdownTitle', 'Select Service', 'Ընտրել ծառայությունը', 'Выбрать категорию');
INSERT INTO `dictionary` VALUES ('HomeEmployeeAddServiceLibORcameraText', 'or', 'կամ', 'или');
INSERT INTO `dictionary` VALUES ('HomeEmployeeAddServiceNewOrderAcceptButtonText', 'Accept', 'Ընդունել', 'Принять');
INSERT INTO `dictionary` VALUES ('HomeEmployeeAddServiceNewOrderCancelButtonText', 'Cancel', 'Չեղարկել', 'Отменить');
INSERT INTO `dictionary` VALUES ('HomeEmployeeAddServiceNewOrderDiscussTitle', 'Discuss', 'Քննարկում', 'Обсуждение');
INSERT INTO `dictionary` VALUES ('HomeEmployeeAddServiceNewOrderModalHeaderTitle', 'New Order', 'Նոր պատվեր', 'Новый заказ');
INSERT INTO `dictionary` VALUES ('HomeEmployeeAddServicePictureTitle', 'Add Pictures', 'Ավելացնել լուսանկար', 'Добавить фото');
INSERT INTO `dictionary` VALUES ('HomeEmployeeAddServicePriceTitle', 'Price', 'Արժեք', 'Стоимость');
INSERT INTO `dictionary` VALUES ('HomeEmployeeAddServiceSaveButtonText', 'Save', 'Պահպանել', 'Сохранить');
INSERT INTO `dictionary` VALUES ('HomeEmployeeAddServiceSubserviceDropdownTitle', 'Select Subservice', 'Ընտրեք ենթակատեգորիա', 'Выберите подкатегорию');
INSERT INTO `dictionary` VALUES ('HomeEmployeeCommentsTitle', 'Comments', 'Մեկնաբանություններ', 'Отзывы');
INSERT INTO `dictionary` VALUES ('HomeEmployeeOrdersTitle', 'Orders', 'Պատվերներ', 'Заказы');
INSERT INTO `dictionary` VALUES ('loginPageDescription', 'Login and start Your journey with us!', 'Մուտք գործեք և մեզ հետ միասին սկսեք Ձեր ճամփորդությունը', 'Войдите в систему и начните свое путешествие вместе с нами!');
INSERT INTO `dictionary` VALUES ('loginPageInputTopText', 'Enter your phone number', 'Մուտքագրեք Ձեր հեռախոսահամարը', 'Введите свой номер телефона');
INSERT INTO `dictionary` VALUES ('loginPagePrimaryButtonText', 'Login', 'Մուտք գործել', 'Войти');
INSERT INTO `dictionary` VALUES ('loginPageSecondaryButtonText', 'Don’t have an account', 'Չունե՞ք անձնական էջ', 'Нет аккаунта');
INSERT INTO `dictionary` VALUES ('loginPageTitle', 'Let’s Start', 'Եկեք սկսենք', 'Давайте начнем');
INSERT INTO `dictionary` VALUES ('loginVerificationDescription', 'We sent an SMS to your mobile number ********', 'Մենք հաղորդագրություն ենք ուղարկել հետևյալ հեռախոսահամարին********', 'Мы выслали SMS на номер ********');
INSERT INTO `dictionary` VALUES ('loginVerificationInputTopText', 'Enter 6 digits code', 'Մուտքագրեք 6-նիշ ծածկագիրը', 'Ввести 6-значный код');
INSERT INTO `dictionary` VALUES ('loginVerificationPrimaryButtonText', 'Resend Code', 'Ուղարկել ծածկագիրը կրկին', 'Выслать код повторно');
INSERT INTO `dictionary` VALUES ('loginVerificationPrimaryButtonTextVerified', 'Login', 'Մուտք գործել', 'Войти');
INSERT INTO `dictionary` VALUES ('loginVerificationSecondaryButtonText', 'Don’t have an account', 'Չունե՞ք անձնական էջ', 'Нет аккаунта');
INSERT INTO `dictionary` VALUES ('loginVerificationTitle', 'Have you received the verification code?', 'Դուք ստացե՞լ եք հաստատման ծածկագիրը։', 'Вы получили код верификации?');
INSERT INTO `dictionary` VALUES ('NavBarHome', 'Home', 'Հիմնական էջ', 'На главную');
INSERT INTO `dictionary` VALUES ('NavBarOrders', 'Orders', 'Պատվերներ', 'Заказы');
INSERT INTO `dictionary` VALUES ('NavBarProfile', 'Profile', 'Անձնական էջ', 'Профиль');
INSERT INTO `dictionary` VALUES ('OrdersPageBookmarksTabTitle', 'Bookmarks', 'Էջանիշեր', 'Закладки');
INSERT INTO `dictionary` VALUES ('OrdersPageMyCommentModalHeaderTitle', 'My comments', 'Իմ մեկնաբանությունները', 'Мои отзывы');
INSERT INTO `dictionary` VALUES ('OrdersPageOrdersTabActiveOrderTitle', 'Active Orders', 'Ակտիվ պատվերներ', 'Активные заказы');
INSERT INTO `dictionary` VALUES ('OrdersPageOrdersTabServiceNameTitle', 'Orders', 'Պատվերներ', 'Заказы');
INSERT INTO `dictionary` VALUES ('OrdersPageOrdersTabTitle', 'Orders', 'Պատվերներ', 'Заказы');
INSERT INTO `dictionary` VALUES ('OrdersPageRateTheEmployeeModalHeaderTitle', 'Rate The Employee', 'Գնահատել մասնագետին', 'Оценить специалиста');
INSERT INTO `dictionary` VALUES ('OrdersPageRateTheEmployeeModalInputTitle', 'Leave Your Comment *', 'Թողնել մեկնաբանություն', 'Оставить отзыв *');
INSERT INTO `dictionary` VALUES ('OrdersPageRateTheEmployeeModalSaveButton', 'Save', 'Պահպանել', 'Сохранить');
INSERT INTO `dictionary` VALUES ('ProfileaboutMeNullPlaceholder', 'no description yet', 'Նկարագիրը բացակայում է', 'пока нет описания');
INSERT INTO `dictionary` VALUES ('ProfileaboutMeTitle', 'About Me', 'Իմ մասին', 'Обо мне');
INSERT INTO `dictionary` VALUES ('ProfileaddButton', 'Add', 'Ավելացնել', 'Добавить');
INSERT INTO `dictionary` VALUES ('ProfileaddressNullPlaceholder', 'no address yet', 'Հասցեն բացակայում է', 'пока нет адреса');
INSERT INTO `dictionary` VALUES ('ProfileAddressPlaceholder', 'no address yet', 'Հասցեն բացակայում է', 'пока нет адреса');
INSERT INTO `dictionary` VALUES ('ProfileeditButton', 'Edit', 'Փոփոխել', 'Изменить');
INSERT INTO `dictionary` VALUES ('ProfileNameNullPlaceholder', 'no name yet', 'Անունը բացակայում է', 'пока нет имени');
INSERT INTO `dictionary` VALUES ('ProfileonlyCustomerButton', 'Become An Employee', 'Դառնալ մասնագետ', 'Стань специалистом');
INSERT INTO `dictionary` VALUES ('ProfileonlyEmployeeButton', 'Become A Customer', 'Դառնալ պատվիրատու', 'Стань заказчиком');
INSERT INTO `dictionary` VALUES ('ProfilesignOut', 'Sign Out', 'Դուրս գալ', 'Выйти');
INSERT INTO `dictionary` VALUES ('ProfileswitchTextcustomer', 'Customer', 'Պատվիրատու', 'Заказчик');
INSERT INTO `dictionary` VALUES ('ProfileswitchTextemployee', 'Employee', 'Մասնագետ', 'Специалист');
INSERT INTO `dictionary` VALUES ('ProfileVerificationButtonText', 'Verify', 'Հաստատել', 'Подтвердить');
INSERT INTO `dictionary` VALUES ('selectUserTypeCustomerButtonText', 'Customer', 'Պատվիրատու', 'Заказчик');
INSERT INTO `dictionary` VALUES ('selectUserTypeDescription', 'You can change it after registration', 'Դուք կարող եք կատարել փոփոխություններ անգամ գրանցումից հետո', 'Вы сможете поменять его после регистрации');
INSERT INTO `dictionary` VALUES ('selectUserTypeEmployeeButtonText', 'Employee', 'Մասնագետ', 'Специалист');
INSERT INTO `dictionary` VALUES ('selectUserTypeTitle', 'Select your role', 'Ընտրեք ձեր գործունեությունը', 'Выберите свою позицию');
INSERT INTO `dictionary` VALUES ('SendRequestDescriptionPlaceholder', 'Write here', 'Write here', 'Write here');
INSERT INTO `dictionary` VALUES ('signUpDescription', 'Sign up and start your journey with us!', 'Գրանցվեք և մեզ հետ միասին սկսեք Ձեր ճամփորդությունը', 'Зарегистрируйтесь и начните свое путешествие вместе с нами!');
INSERT INTO `dictionary` VALUES ('signUpInputTopText', 'Enter your phone number', 'Մուտքագրեք Ձեր հեռախոսահամարը', 'Введите свой номер телефона');
INSERT INTO `dictionary` VALUES ('signUpPrimaryButtonText', 'Sign Up', 'Գրանցվել', 'Зарегистрироваться');
INSERT INTO `dictionary` VALUES ('signUpSecondaryButtonText', 'I have an account', 'Ես ունեմ անձնական էջ', 'У меня есть аккаунт');
INSERT INTO `dictionary` VALUES ('signUpTitle', 'Let’s Start', 'Եկեք սկսենք', 'Давайте начнем');
INSERT INTO `dictionary` VALUES ('signUpVerificationDescription', 'We sent an SMS to your mobile number ********', 'Մենք հաղորդագրություն ենք ուղարկել Ձեր համարին', 'Мы выслали SMS на ваш номер ********');
INSERT INTO `dictionary` VALUES ('signUpVerificationInputTopText', 'Enter 6 digits code', 'Մուտքագրեք 6-նիշ ծածկագիրը', 'Ввести 6-значный код');
INSERT INTO `dictionary` VALUES ('signUpVerificationPrimaryButtonText', 'Resend Code', 'Ուղարկել ծածկագիրը կրկին', 'Выслать код повторно');
INSERT INTO `dictionary` VALUES ('signUpVerificationPrimaryButtonTextVerified', 'Sign Up', 'Գրանցվել', 'Зарегистрироваться');
INSERT INTO `dictionary` VALUES ('signUpVerificationSecondaryButtonText', 'I Have An Account', 'Ես ունեմ անձնական էջ', 'У меня есть аккаунт');
INSERT INTO `dictionary` VALUES ('signUpVerificationTitle', 'Have you received the verification code?', 'Դուք ստացե՞լ եք վերիֆիկացման ծածկագիրը։', 'Вы получили код верификации?');
INSERT INTO `dictionary` VALUES ('VerificationPlaceholder', 'no verification yet', 'Վերիֆիկացում դեռ չկա', 'пока нет верификации');
INSERT INTO `dictionary` VALUES ('VerificationStatusPending', 'Pending...', 'Մշակում․․․', 'Обрабатывается...');
INSERT INTO `dictionary` VALUES ('VerificationStatusVerified', 'Verified', 'Հաստատված է', 'Подтверждено');
INSERT INTO `dictionary` VALUES ('VerifyPage1Description1', '1. Make sure your document is up-to-date', 'Համոզվեք որ Ձեր փաստաթուղթը վավեր է', '1. Убедитесь, что ваш документ действующий');
INSERT INTO `dictionary` VALUES ('VerifyPage1Description2', '2. Photo should be good quality, bright and clear', 'Լուսանկարը պետք է լինի լավ որակի, լուսավոր և պարզ', '2. Фото должно быть хорошего качества, светлое и ясное');
INSERT INTO `dictionary` VALUES ('VerifyPage1Title', 'Take a photo of your Passport or ID', 'Լուսանկարեք Ձեր անձնագիրը կամ ID քարտը', 'Сфотографируйте свой паспорт или ID карту');
INSERT INTO `dictionary` VALUES ('VerifyPage2ButtonNextText', 'Next', 'Հաջորդ', 'Далее');
INSERT INTO `dictionary` VALUES ('VerifyPage2ButtonSelfieText', 'Let\'s Take a selfie', 'Եկեք ինքնանկարվենք', 'Давайте сделаем селфи');
INSERT INTO `dictionary` VALUES ('VerifyPage2Description', '1. Make sure the background is clear', 'Համոզվեք, որ ետնաշերտը մաքուր է', '1. Убедитесь, что на фоне ничего нет');
INSERT INTO `dictionary` VALUES ('VerifyPage2Title', 'Take a selfie', 'Ինքնանկարվել', 'Сделать селфи');
INSERT INTO `dictionary` VALUES ('VerifyPage3ButtonText', 'Back To Profile', 'Վերադառնալ անձնական էջ', 'Обратно в профиль');
INSERT INTO `dictionary` VALUES ('VerifyPage3Title', 'We will analyse your pictures and inform you as soon as possible', 'Մենք կդիտարկեք Ձեր լուսանկաները և հնարավորինս արագ կպատասխանենք Ձեզ', 'Мы проанализируем ваши фото и сразу напишем вам');
INSERT INTO `dictionary` VALUES ('VerifyPageAddImageTitle', 'Add Image', 'Ավելացնել լուսանկար', 'Добавить изображение');
INSERT INTO `dictionary` VALUES ('VerifyPageLibORCamText', 'or', 'Կամ', 'или');
INSERT INTO `dictionary` VALUES ('VerifyPageNextButtonText', 'Next', 'Հաջորդ', 'VerifyPageNextButtonText');
INSERT INTO `dictionary` VALUES ('VerifyPageTitle', 'Identity document', 'Անձը հաստատող փաստաթուղթ', 'Документ, удостоверяющий личность');
INSERT INTO `dictionary` VALUES ('VerifyPageTitleFinished', 'Congrats!', 'Շնորհավորում ենք։', 'Поздравляем!');
INSERT INTO `dictionary` VALUES ('welcomePagepage1Description', 'welcomePagepage1Descript', 'welcomePagepage1Description', 'welcomePagepage1Description');
INSERT INTO `dictionary` VALUES ('welcomePagepage1Title', 'The first Armenian  \\n application for finding  \\nspecialists in any industry', 'Առաջին հայկական \\n գտնելու համար նախատեսված հավելված \\n Ցանկացած ոլորտի մասնագետ', 'Первое армянское  \\n приложения для поиска  \\nспециалистов любой отрасли');
INSERT INTO `dictionary` VALUES ('welcomePagepage2Description', 'Fast \\nConveniently \\nWithout an intermediary', 'Արագ \\n Հարմար \\n Առանց միջնորդների', 'Быстро \\nУдобно \\nБез посредников');
INSERT INTO `dictionary` VALUES ('welcomePagepage2Title', 'Find a specialist for any task', 'Գտիր մասնագետ ցանկացած խնդրի համար', 'Найди специалиста под любую задачу');
INSERT INTO `dictionary` VALUES ('welcomePagepage3Description', 'Many offers \\nWork for yourself \\nSet the price yourself', 'Բազում առաջարկներ \\n Աշխատիր քեզ համար \\n Սահմանիր գինը ինքդ', 'Много предложений \\nРаботай на себя \\nНазначай цену сам');
INSERT INTO `dictionary` VALUES ('welcomePagepage3Title', 'Find new customers and projects', 'Գտնել նոր պատվիրատուներ և նախագծեր', 'Найди новых заказчиков и проекты');
INSERT INTO `dictionary` VALUES ('welcomePagepagePrimaryButtonText', 'Next', 'Հաջորդ', 'Дальше');
INSERT INTO `dictionary` VALUES ('welcomePagepageSecondaryButtonText', 'Skip1', 'Բաց թողնել', 'Пропустить');

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp(0) NOT NULL DEFAULT current_timestamp(0),
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `failed_jobs_uuid_unique`(`uuid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for images
-- ----------------------------
DROP TABLE IF EXISTS `images`;
CREATE TABLE `images`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `filename` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `temp` int NOT NULL DEFAULT 0,
  `ordering` int NULL DEFAULT 0,
  `parent_id` int NULL DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `params` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of images
-- ----------------------------
INSERT INTO `images` VALUES (1, '551ebe10dcd5.jpg', 0, 0, NULL, NULL, '2022-09-29 11:51:47', '2022-09-29 11:51:47', NULL);
INSERT INTO `images` VALUES (2, '1c3f8c7bcbfd.jpg', 0, 0, NULL, NULL, '2022-09-29 11:52:29', '2022-09-29 11:52:29', NULL);
INSERT INTO `images` VALUES (3, '7ac78e3e359d.jpg', 0, 0, NULL, NULL, '2022-09-29 11:53:57', '2022-09-29 11:53:57', NULL);

-- ----------------------------
-- Table structure for log
-- ----------------------------
DROP TABLE IF EXISTS `log`;
CREATE TABLE `log`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `owner_id` int NULL DEFAULT NULL,
  `type` enum('registration','verification','order_request') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `data` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  `created_at` timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of log
-- ----------------------------
INSERT INTO `log` VALUES (2, 127, 'order_request', '', '2022-07-20 18:24:23');
INSERT INTO `log` VALUES (3, 71, 'registration', '', '2022-07-20 18:24:27');

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (2, '2014_10_12_100000_create_password_resets_table', 1);
INSERT INTO `migrations` VALUES (3, '2019_08_19_000000_create_failed_jobs_table', 1);
INSERT INTO `migrations` VALUES (5, '2019_12_14_000001_create_personal_access_tokens_table', 2);

-- ----------------------------
-- Table structure for notification
-- ----------------------------
DROP TABLE IF EXISTS `notification`;
CREATE TABLE `notification`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NULL DEFAULT NULL,
  `title` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `body` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `type` enum('order_request','order_approved','order_declined','order_canceled','user_verification','order_request_timeout') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `order_id` int NULL DEFAULT NULL,
  `status` int NULL DEFAULT 0,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `data` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 403 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of notification
-- ----------------------------
INSERT INTO `notification` VALUES (163, 13, 'New order', 'You have new order in categoryпрогулочная съемка', 'order_request', 127, 1, '2022-06-16 07:47:54', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:12;s:11:\"description\";s:3:\"ggg\";s:5:\"phone\";s:11:\"+7987654321\";s:8:\"order_id\";i:127;s:14:\"category_title\";s:35:\"прогулочная съемка\";}');
INSERT INTO `notification` VALUES (164, 16, 'Order approved', 'Your order is approved', 'order_approved', 127, 1, '2022-06-16 07:48:11', 'a:1:{s:4:\"type\";s:14:\"order_approved\";}');
INSERT INTO `notification` VALUES (165, 13, 'New order', 'You have new order in categoryпрогулочная съемка', 'order_request', 128, 1, '2022-06-16 07:48:53', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:12;s:11:\"description\";s:3:\"ggg\";s:5:\"phone\";s:11:\"+7987654321\";s:8:\"order_id\";i:128;s:14:\"category_title\";s:35:\"прогулочная съемка\";}');
INSERT INTO `notification` VALUES (166, 16, 'Order declined', 'Your order is declined', 'order_declined', 128, 1, '2022-06-16 07:48:59', 'a:1:{s:4:\"type\";s:14:\"order_declined\";}');
INSERT INTO `notification` VALUES (167, 16, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 129, 1, '2022-06-16 07:50:45', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:12;s:11:\"description\";s:3:\"Dfg\";s:5:\"phone\";s:12:\"+37412123456\";s:8:\"order_id\";i:129;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (168, 13, 'Order approved', 'Your order is approved', 'order_approved', 129, 1, '2022-06-16 07:50:50', 'a:1:{s:4:\"type\";s:14:\"order_approved\";}');
INSERT INTO `notification` VALUES (169, 16, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 130, 1, '2022-06-16 07:51:18', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:12;s:11:\"description\";s:3:\"Dfg\";s:5:\"phone\";s:12:\"+37412123456\";s:8:\"order_id\";i:130;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (170, 13, 'Order declined', 'Your order is declined', 'order_declined', 130, 1, '2022-06-16 07:51:22', 'a:1:{s:4:\"type\";s:14:\"order_declined\";}');
INSERT INTO `notification` VALUES (171, 16, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 131, 1, '2022-06-16 07:51:29', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:12;s:11:\"description\";s:3:\"Dfg\";s:5:\"phone\";s:12:\"+37412123456\";s:8:\"order_id\";i:131;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (172, 13, 'Order approved', 'Your order is approved', 'order_approved', 131, 1, '2022-06-16 07:51:32', 'a:1:{s:4:\"type\";s:14:\"order_approved\";}');
INSERT INTO `notification` VALUES (173, 16, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 132, 1, '2022-06-16 07:51:57', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:12;s:11:\"description\";s:3:\"Dfg\";s:5:\"phone\";s:12:\"+37412123456\";s:8:\"order_id\";i:132;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (174, 13, 'Order approved', 'Your order is approved', 'order_approved', 132, 1, '2022-06-16 07:52:01', 'a:1:{s:4:\"type\";s:14:\"order_approved\";}');
INSERT INTO `notification` VALUES (175, 16, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 133, 1, '2022-06-16 07:54:39', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:12;s:11:\"description\";s:3:\"Dfg\";s:5:\"phone\";s:12:\"+37412123456\";s:8:\"order_id\";i:133;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (176, 16, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 135, 1, '2022-06-16 07:57:00', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:12;s:11:\"description\";s:3:\"Dfg\";s:5:\"phone\";s:12:\"+37412123456\";s:8:\"order_id\";i:135;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (177, 16, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 136, 1, '2022-06-16 07:58:28', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:12;s:11:\"description\";s:3:\"Dfg\";s:5:\"phone\";s:12:\"+37412123456\";s:8:\"order_id\";i:136;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (178, 16, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 137, 1, '2022-06-16 07:59:11', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:12;s:11:\"description\";s:3:\"Dfg\";s:5:\"phone\";s:12:\"+37412123456\";s:8:\"order_id\";i:137;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (179, 16, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 138, 1, '2022-06-16 08:00:22', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:12;s:11:\"description\";s:3:\"Dfg\";s:5:\"phone\";s:12:\"+37412123456\";s:8:\"order_id\";i:138;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (180, 16, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 139, 1, '2022-06-16 08:02:08', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:12;s:11:\"description\";s:3:\"Dfg\";s:5:\"phone\";s:12:\"+37412123456\";s:8:\"order_id\";i:139;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (181, 16, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 140, 1, '2022-06-16 08:02:29', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:12;s:11:\"description\";s:3:\"Dfg\";s:5:\"phone\";s:12:\"+37412123456\";s:8:\"order_id\";i:140;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (182, 13, 'Order approved', 'Your order is approved', 'order_approved', 140, 1, '2022-06-16 08:02:38', 'a:1:{s:4:\"type\";s:14:\"order_approved\";}');
INSERT INTO `notification` VALUES (183, 13, 'New order', 'You have new order in categoryпрогулочная съемка', 'order_request', 141, 1, '2022-06-16 08:21:55', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:11;s:11:\"description\";s:3:\"asd\";s:5:\"phone\";s:11:\"+7987654321\";s:8:\"order_id\";i:141;s:14:\"category_title\";s:35:\"прогулочная съемка\";}');
INSERT INTO `notification` VALUES (184, 16, 'Order approved', 'Your order is approved', 'order_approved', 141, 1, '2022-06-16 08:22:18', 'a:1:{s:4:\"type\";s:14:\"order_approved\";}');
INSERT INTO `notification` VALUES (185, 13, 'New order', 'You have new order in categoryпрогулочная съемка', 'order_request', 142, 1, '2022-06-16 09:18:16', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:11;s:11:\"description\";s:3:\"asd\";s:5:\"phone\";s:11:\"+7987654321\";s:8:\"order_id\";i:142;s:14:\"category_title\";s:35:\"прогулочная съемка\";}');
INSERT INTO `notification` VALUES (186, 16, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 143, 1, '2022-06-16 09:19:33', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:11;s:11:\"description\";s:3:\"Asd\";s:5:\"phone\";s:12:\"+37412123456\";s:8:\"order_id\";i:143;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (187, 13, 'New order', 'You have new order in categoryпрогулочная съемка', 'order_request', 145, 1, '2022-06-16 11:53:38', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:11;s:11:\"description\";s:5:\"ahaha\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:145;s:14:\"category_title\";s:35:\"прогулочная съемка\";}');
INSERT INTO `notification` VALUES (188, 36, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 146, 1, '2022-06-16 12:46:26', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:11;s:11:\"description\";s:3:\"Asd\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:146;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (189, 11, 'Order approved', 'Your order is approved', 'order_approved', 146, 1, '2022-06-16 12:46:38', 'a:1:{s:4:\"type\";s:14:\"order_approved\";}');
INSERT INTO `notification` VALUES (190, 37, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 147, 1, '2022-06-16 16:33:36', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";N;s:11:\"description\";s:26:\"Когда придешь?\";s:5:\"phone\";s:12:\"+37499993999\";s:8:\"order_id\";i:147;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (191, 38, 'Order approved', 'Your order is approved', 'order_approved', 147, 1, '2022-06-16 16:34:10', 'a:1:{s:4:\"type\";s:14:\"order_approved\";}');
INSERT INTO `notification` VALUES (192, 3, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 148, 0, '2022-06-17 17:45:17', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";N;s:11:\"description\";s:26:\"I need to change 5 toilets\";s:5:\"phone\";s:12:\"+37499993999\";s:8:\"order_id\";i:148;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (193, 37, 'New order', 'You have new order in categoryдля детей', 'order_request', 149, 1, '2022-06-17 18:00:45', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";N;s:11:\"description\";s:2:\"Hi\";s:5:\"phone\";s:12:\"+37499993999\";s:8:\"order_id\";i:149;s:14:\"category_title\";s:17:\"для детей\";}');
INSERT INTO `notification` VALUES (194, 38, 'Order approved', 'Your order is approved', 'order_approved', 149, 1, '2022-06-17 18:01:10', 'a:1:{s:4:\"type\";s:14:\"order_approved\";}');
INSERT INTO `notification` VALUES (195, 37, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 150, 1, '2022-06-19 07:56:49', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";N;s:11:\"description\";s:5:\"Zakaz\";s:5:\"phone\";s:12:\"+37499993999\";s:8:\"order_id\";i:150;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (196, 38, 'New order', 'You have new order in categoryкомпьютерная техника', 'order_request', 151, 1, '2022-06-19 08:04:45', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:15;s:11:\"description\";s:10:\"barev dzez\";s:5:\"phone\";s:12:\"+37494088020\";s:8:\"order_id\";i:151;s:14:\"category_title\";s:39:\"компьютерная техника\";}');
INSERT INTO `notification` VALUES (197, 39, 'Order approved', 'Your order is approved', 'order_approved', 151, 1, '2022-06-19 08:05:19', 'a:1:{s:4:\"type\";s:14:\"order_approved\";}');
INSERT INTO `notification` VALUES (198, 3, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 152, 0, '2022-06-20 15:50:24', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:12;s:11:\"description\";s:3:\"Asd\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:152;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (199, 13, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 153, 1, '2022-06-20 15:52:56', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:12;s:11:\"description\";s:3:\"Asd\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:153;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (200, 13, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 154, 1, '2022-06-20 15:58:17', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:22;s:11:\"description\";s:3:\"Asd\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:154;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (201, 36, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 155, 1, '2022-06-20 15:59:38', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:22;s:11:\"description\";s:3:\"Asd\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:155;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (202, 3, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 156, 0, '2022-06-20 16:14:03', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:12;s:11:\"description\";s:3:\"Asd\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:156;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (203, 16, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 157, 1, '2022-06-20 16:19:24', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:11;s:11:\"description\";s:3:\"Asd\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:157;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (204, 3, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 158, 0, '2022-06-20 16:24:58', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:12;s:11:\"description\";s:3:\"Asd\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:158;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (205, 13, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 159, 1, '2022-06-20 16:49:56', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:11;s:11:\"description\";s:3:\"Asd\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:159;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (206, 36, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 160, 1, '2022-06-20 16:51:14', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:11;s:11:\"description\";s:3:\"Asd\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:160;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (207, 13, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 161, 1, '2022-06-21 07:01:54', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:100;s:11:\"description\";s:3:\"Asd\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:161;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (208, 36, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 162, 1, '2022-06-21 07:03:15', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:100;s:11:\"description\";s:3:\"Asd\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:162;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (209, 16, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 163, 1, '2022-06-21 07:04:20', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:100;s:11:\"description\";s:3:\"Asd\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:163;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (210, 3, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 164, 0, '2022-06-21 07:06:01', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:100;s:11:\"description\";s:3:\"Asd\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:164;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (211, 13, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 165, 1, '2022-06-21 07:08:11', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:100;s:11:\"description\";s:3:\"Asd\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:165;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (212, 13, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 166, 1, '2022-06-21 10:12:24', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:1212;s:11:\"description\";s:2:\"Ag\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:166;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (213, 40, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 167, 1, '2022-06-21 11:58:41', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:1000000;s:11:\"description\";s:4:\"Halo\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:167;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (214, 11, 'Order approved', 'Your order is approved', 'order_approved', 167, 1, '2022-06-21 11:59:18', 'a:1:{s:4:\"type\";s:14:\"order_approved\";}');
INSERT INTO `notification` VALUES (215, 40, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 168, 1, '2022-06-21 11:59:33', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:1000000;s:11:\"description\";s:4:\"Halo\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:168;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (216, 11, 'Order approved', 'Your order is approved', 'order_approved', 168, 1, '2022-06-21 11:59:37', 'a:1:{s:4:\"type\";s:14:\"order_approved\";}');
INSERT INTO `notification` VALUES (217, 40, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 169, 1, '2022-06-21 11:59:43', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:1000000;s:11:\"description\";s:4:\"Halo\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:169;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (218, 11, 'Order approved', 'Your order is approved', 'order_approved', 169, 1, '2022-06-21 11:59:47', 'a:1:{s:4:\"type\";s:14:\"order_approved\";}');
INSERT INTO `notification` VALUES (219, 40, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 170, 1, '2022-06-21 12:00:27', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:1000000;s:11:\"description\";s:4:\"Halo\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:170;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (220, 11, 'Order approved', 'Your order is approved', 'order_approved', 170, 1, '2022-06-21 12:00:34', 'a:1:{s:4:\"type\";s:14:\"order_approved\";}');
INSERT INTO `notification` VALUES (221, 40, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 171, 1, '2022-06-21 12:00:46', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:1000000;s:11:\"description\";s:4:\"Halo\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:171;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (222, 11, 'Order approved', 'Your order is approved', 'order_approved', 171, 1, '2022-06-21 12:00:56', 'a:1:{s:4:\"type\";s:14:\"order_approved\";}');
INSERT INTO `notification` VALUES (223, 40, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 172, 1, '2022-06-21 12:01:40', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:1000000;s:11:\"description\";s:4:\"Halo\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:172;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (224, 11, 'Order approved', 'Your order is approved', 'order_approved', 172, 1, '2022-06-21 12:01:44', 'a:1:{s:4:\"type\";s:14:\"order_approved\";}');
INSERT INTO `notification` VALUES (225, 40, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 173, 1, '2022-06-21 12:01:58', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:1000000;s:11:\"description\";s:4:\"Halo\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:173;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (226, 11, 'Order approved', 'Your order is approved', 'order_approved', 173, 1, '2022-06-21 12:02:03', 'a:1:{s:4:\"type\";s:14:\"order_approved\";}');
INSERT INTO `notification` VALUES (227, 40, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 174, 1, '2022-06-21 12:02:08', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:1000000;s:11:\"description\";s:4:\"Halo\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:174;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (228, 11, 'Order approved', 'Your order is approved', 'order_approved', 174, 1, '2022-06-21 12:02:15', 'a:1:{s:4:\"type\";s:14:\"order_approved\";}');
INSERT INTO `notification` VALUES (229, 40, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 175, 1, '2022-06-21 12:02:22', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:1000000;s:11:\"description\";s:4:\"Halo\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:175;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (230, 11, 'Order approved', 'Your order is approved', 'order_approved', 175, 1, '2022-06-21 12:02:27', 'a:1:{s:4:\"type\";s:14:\"order_approved\";}');
INSERT INTO `notification` VALUES (231, 40, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 176, 1, '2022-06-21 12:02:58', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:1000000;s:11:\"description\";s:4:\"Halo\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:176;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (232, 11, 'Order approved', 'Your order is approved', 'order_approved', 176, 1, '2022-06-21 12:03:06', 'a:1:{s:4:\"type\";s:14:\"order_approved\";}');
INSERT INTO `notification` VALUES (233, 40, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 177, 1, '2022-06-21 12:03:11', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:1000000;s:11:\"description\";s:4:\"Halo\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:177;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (234, 11, 'Order approved', 'Your order is approved', 'order_approved', 177, 1, '2022-06-21 12:03:14', 'a:1:{s:4:\"type\";s:14:\"order_approved\";}');
INSERT INTO `notification` VALUES (235, 40, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 178, 1, '2022-06-21 12:03:50', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:1000000;s:11:\"description\";s:4:\"Halo\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:178;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (236, 11, 'Order approved', 'Your order is approved', 'order_approved', 178, 1, '2022-06-21 12:03:56', 'a:1:{s:4:\"type\";s:14:\"order_approved\";}');
INSERT INTO `notification` VALUES (237, 40, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 179, 1, '2022-06-21 12:04:05', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:10000002;s:11:\"description\";s:4:\"Halo\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:179;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (238, 11, 'Order approved', 'Your order is approved', 'order_approved', 179, 1, '2022-06-21 12:04:09', 'a:1:{s:4:\"type\";s:14:\"order_approved\";}');
INSERT INTO `notification` VALUES (239, 40, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 180, 1, '2022-06-21 12:26:14', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:22;s:11:\"description\";s:3:\"Asd\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:180;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (240, 11, 'Order approved', 'Your order is approved', 'order_approved', 180, 1, '2022-06-21 12:26:20', 'a:1:{s:4:\"type\";s:14:\"order_approved\";}');
INSERT INTO `notification` VALUES (241, 3, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 181, 0, '2022-06-23 08:56:43', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:22;s:11:\"description\";s:3:\"sss\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:181;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (242, 13, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 182, 1, '2022-06-23 08:56:55', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:22;s:11:\"description\";s:3:\"sss\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:182;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (243, 13, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 183, 1, '2022-06-23 09:17:31', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:11;s:11:\"description\";s:3:\"asd\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:183;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (244, 3, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 184, 0, '2022-06-23 09:30:32', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:11;s:11:\"description\";s:3:\"asd\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:184;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (245, 13, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 185, 1, '2022-06-23 09:34:44', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:11;s:11:\"description\";s:3:\"aaa\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:185;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (246, 13, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 186, 1, '2022-06-23 09:55:17', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:222;s:11:\"description\";s:3:\"aaa\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:186;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (247, 3, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 187, 0, '2022-06-23 09:56:27', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:666;s:11:\"description\";s:9:\"blablabla\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:187;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (248, 3, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 188, 0, '2022-06-23 10:35:18', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:12;s:11:\"description\";s:3:\"asd\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:188;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (249, 36, 'New order', 'You have new order in categoryпошив и переделка', 'order_request', 189, 1, '2022-06-23 11:25:00', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:444;s:11:\"description\";s:3:\"asd\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:189;s:14:\"category_title\";s:32:\"пошив и переделка\";}');
INSERT INTO `notification` VALUES (250, 36, 'New order', 'You have new order in categoryпошив и переделка', 'order_request', 190, 1, '2022-06-23 11:30:25', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:444;s:11:\"description\";s:3:\"asd\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:190;s:14:\"category_title\";s:32:\"пошив и переделка\";}');
INSERT INTO `notification` VALUES (251, 36, 'New order', 'You have new order in categoryпошив и переделка', 'order_request', 191, 1, '2022-06-23 11:43:40', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:444;s:11:\"description\";s:3:\"asd\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:191;s:14:\"category_title\";s:32:\"пошив и переделка\";}');
INSERT INTO `notification` VALUES (252, 3, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 192, 0, '2022-06-23 11:46:04', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:666;s:11:\"description\";s:9:\"blablabla\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:192;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (253, 37, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 193, 1, '2022-06-23 11:46:23', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:666;s:11:\"description\";s:9:\"blablabla\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:193;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (254, 13, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 194, 1, '2022-06-23 11:48:45', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:11;s:11:\"description\";s:3:\"aaa\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:194;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (255, 3, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 195, 0, '2022-06-23 11:58:58', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:44;s:11:\"description\";s:3:\"aaa\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:195;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (256, 13, 'New order', 'You have new order in categoryдля детей', 'order_request', 196, 1, '2022-06-24 08:22:21', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:22;s:11:\"description\";s:6:\"фыа\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:196;s:14:\"category_title\";s:17:\"для детей\";}');
INSERT INTO `notification` VALUES (257, 13, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 197, 1, '2022-06-24 13:22:08', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:22;s:11:\"description\";s:4:\"halo\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:197;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (258, 36, 'New order', 'You have new order in categoryстудийная съемка', 'order_request', 198, 1, '2022-06-24 13:24:21', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:55;s:11:\"description\";s:3:\"fff\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:198;s:14:\"category_title\";s:31:\"студийная съемка\";}');
INSERT INTO `notification` VALUES (259, 13, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 199, 1, '2022-06-24 18:29:00', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:22;s:11:\"description\";s:8:\"halo man\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:199;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (260, 11, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 200, 1, '2022-06-27 10:25:20', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:420;s:11:\"description\";s:4:\"[AS]\";s:5:\"phone\";s:12:\"+37412123456\";s:8:\"order_id\";i:200;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (261, 13, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 201, 1, '2022-06-27 10:27:21', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:420;s:11:\"description\";s:4:\"[AS]\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:201;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (262, 13, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 202, 1, '2022-06-27 10:51:18', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:420;s:11:\"description\";s:4:\"[AS]\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:202;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (263, 13, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 203, 1, '2022-06-27 11:59:39', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:420;s:11:\"description\";s:79:\"hqhwhwhehehehehehehehhshshshdhdhdhdh hegehegegshsgsgdgsggegegsgsgsgsgsgsgsgsgsg\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:203;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (264, 11, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 204, 1, '2022-06-27 12:03:59', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:33;s:11:\"description\";s:28:\"#ddddddddddddddddddddddddddd\";s:5:\"phone\";s:12:\"+37412123456\";s:8:\"order_id\";i:204;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (265, 13, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 205, 1, '2022-06-27 12:07:00', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:333;s:11:\"description\";s:35:\"gggggggggggggggggffffffffffffffffff\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:205;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (266, 13, 'New order', 'You have new order in categoryдополнительное образование', 'order_request', 206, 1, '2022-06-27 12:09:06', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:333;s:11:\"description\";s:5:\"fffff\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:206;s:14:\"category_title\";s:51:\"дополнительное образование\";}');
INSERT INTO `notification` VALUES (267, 13, 'New order', 'You have new order in categoryдля детей', 'order_request', 207, 1, '2022-06-27 12:10:11', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:222;s:11:\"description\";s:80:\"ddddddddddddddddddddffffffffffffffffffffffffssssssssssssssssssssssssssssssssssss\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:207;s:14:\"category_title\";s:17:\"для детей\";}');
INSERT INTO `notification` VALUES (268, 13, 'New order', 'You have new order in categoryподготовка абитуриентов', 'order_request', 208, 1, '2022-06-27 12:10:58', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:22;s:11:\"description\";s:6:\"trying\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:208;s:14:\"category_title\";s:45:\"подготовка абитуриентов\";}');
INSERT INTO `notification` VALUES (269, 13, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 209, 1, '2022-06-27 12:13:10', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:33;s:11:\"description\";s:13:\"ggggggggggggg\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:209;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (270, 13, 'New order', 'You have new order in categoryподготовка абитуриентов', 'order_request', 210, 1, '2022-06-27 12:16:40', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:22;s:11:\"description\";s:2:\"dd\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:210;s:14:\"category_title\";s:45:\"подготовка абитуриентов\";}');
INSERT INTO `notification` VALUES (271, 13, 'New order', 'You have new order in categoryдополнительное образование', 'order_request', 211, 1, '2022-06-27 12:17:39', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:33;s:11:\"description\";s:1:\"t\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:211;s:14:\"category_title\";s:51:\"дополнительное образование\";}');
INSERT INTO `notification` VALUES (272, 13, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 212, 1, '2022-06-27 12:20:24', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:88;s:11:\"description\";s:2:\"tt\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:212;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (273, 13, 'New order', 'You have new order in categoryдополнительное образование', 'order_request', 213, 1, '2022-06-27 12:23:22', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:33;s:11:\"description\";s:2:\"ll\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:213;s:14:\"category_title\";s:51:\"дополнительное образование\";}');
INSERT INTO `notification` VALUES (274, 13, 'New order', 'You have new order in categoryдля детей', 'order_request', 214, 1, '2022-06-27 12:24:33', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:66;s:11:\"description\";s:2:\"gg\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:214;s:14:\"category_title\";s:17:\"для детей\";}');
INSERT INTO `notification` VALUES (275, 13, 'New order', 'You have new order in categoryподготовка абитуриентов', 'order_request', 215, 1, '2022-06-27 12:25:55', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:1;s:11:\"description\";s:1:\"l\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:215;s:14:\"category_title\";s:45:\"подготовка абитуриентов\";}');
INSERT INTO `notification` VALUES (276, 13, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 216, 1, '2022-06-27 12:26:36', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:55;s:11:\"description\";s:3:\"ttt\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:216;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (277, 13, 'New order', 'You have new order in categoryдля детей', 'order_request', 217, 1, '2022-06-27 12:31:15', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:22;s:11:\"description\";s:4:\"tyyy\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:217;s:14:\"category_title\";s:17:\"для детей\";}');
INSERT INTO `notification` VALUES (278, 11, 'Order approved', 'Your order is approved', 'order_approved', 217, 1, '2022-06-27 12:31:33', 'a:1:{s:4:\"type\";s:14:\"order_approved\";}');
INSERT INTO `notification` VALUES (279, 13, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 218, 1, '2022-06-27 12:33:47', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:22;s:11:\"description\";s:2:\"ll\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:218;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (280, 11, 'Order approved', 'Your order is approved', 'order_approved', 218, 1, '2022-06-27 12:35:22', 'a:1:{s:4:\"type\";s:14:\"order_approved\";}');
INSERT INTO `notification` VALUES (281, 13, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 219, 1, '2022-06-27 12:35:51', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:22;s:11:\"description\";s:2:\"ll\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:219;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (282, 11, 'Order approved', 'Your order is approved', 'order_approved', 219, 1, '2022-06-27 12:36:23', 'a:1:{s:4:\"type\";s:14:\"order_approved\";}');
INSERT INTO `notification` VALUES (283, 13, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 220, 1, '2022-06-27 12:36:29', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:22;s:11:\"description\";s:2:\"ll\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:220;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (284, 11, 'Order approved', 'Your order is approved', 'order_approved', 220, 1, '2022-06-27 12:36:44', 'a:1:{s:4:\"type\";s:14:\"order_approved\";}');
INSERT INTO `notification` VALUES (285, 13, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 221, 1, '2022-06-27 12:37:27', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:22;s:11:\"description\";s:2:\"ll\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:221;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (286, 11, 'Order approved', 'Your order is approved', 'order_approved', 221, 1, '2022-06-27 12:37:52', 'a:1:{s:4:\"type\";s:14:\"order_approved\";}');
INSERT INTO `notification` VALUES (287, 13, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 222, 1, '2022-06-27 12:39:48', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:22;s:11:\"description\";s:2:\"ll\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:222;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (288, 11, 'Order declined', 'Your order is declined', 'order_declined', 222, 1, '2022-06-27 12:39:55', 'a:1:{s:4:\"type\";s:14:\"order_declined\";}');
INSERT INTO `notification` VALUES (289, 13, 'New order', 'You have new order in categoryдошкольная подготовка', 'order_request', 223, 1, '2022-06-27 12:40:02', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:22;s:11:\"description\";s:2:\"ll\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:223;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (290, 11, 'Order approved', 'Your order is approved', 'order_approved', 223, 1, '2022-06-27 12:40:09', 'a:1:{s:4:\"type\";s:14:\"order_approved\";}');
INSERT INTO `notification` VALUES (291, 13, 'New order', 'You have new order in categoryуслуги ювелира', 'order_request', 224, 1, '2022-06-27 12:50:40', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:200;s:11:\"description\";s:80:\"gggggggggggggggggggwgwgegegsgsgege gsgsgshshshshshshdhshshshshshshshshshshshshsh\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:224;s:14:\"category_title\";s:27:\"услуги ювелира\";}');
INSERT INTO `notification` VALUES (292, 11, 'Order approved', 'Your order is approved', 'order_approved', 224, 1, '2022-06-27 12:50:55', 'a:1:{s:4:\"type\";s:14:\"order_approved\";}');
INSERT INTO `notification` VALUES (293, 13, 'New order', 'You have new order in categoryуслуги ювелира', 'order_request', 225, 1, '2022-06-27 13:04:48', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:22;s:11:\"description\";s:4:\"halo\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:225;s:14:\"category_title\";s:27:\"услуги ювелира\";}');
INSERT INTO `notification` VALUES (294, 11, 'Order approved', 'Your order is approved', 'order_approved', 225, 1, '2022-06-27 13:05:09', 'a:1:{s:4:\"type\";s:14:\"order_approved\";}');
INSERT INTO `notification` VALUES (295, 13, 'New order', 'You have new order in categoryуслуги SMM', 'order_request', 226, 1, '2022-06-27 13:06:27', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:999;s:11:\"description\";s:3:\"ggg\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:226;s:14:\"category_title\";s:16:\"услуги SMM\";}');
INSERT INTO `notification` VALUES (296, 11, 'Order approved', 'Your order is approved', 'order_approved', 226, 1, '2022-06-27 13:06:47', 'a:1:{s:4:\"type\";s:14:\"order_approved\";}');
INSERT INTO `notification` VALUES (297, 13, 'New order', 'You have new order in categoryуслуги SMM', 'order_request', 227, 1, '2022-06-27 13:13:29', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:22;s:11:\"description\";s:2:\"tt\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:227;s:14:\"category_title\";s:16:\"услуги SMM\";}');
INSERT INTO `notification` VALUES (298, 11, 'Order approved', 'Your order is approved', 'order_approved', 227, 1, '2022-06-27 13:14:01', 'a:1:{s:4:\"type\";s:14:\"order_approved\";}');
INSERT INTO `notification` VALUES (299, 13, 'New order', 'You have new order in categoryсантехника', 'order_request', 228, 1, '2022-06-27 13:47:27', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:300;s:11:\"description\";s:47:\"Problems in kitchen, must be fixed until sunday\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:228;s:14:\"category_title\";s:20:\"сантехника\";}');
INSERT INTO `notification` VALUES (300, 11, 'Order approved', 'Your order is approved', 'order_approved', 228, 1, '2022-06-27 13:47:46', 'a:1:{s:4:\"type\";s:14:\"order_approved\";}');
INSERT INTO `notification` VALUES (301, 16, 'New order', 'You have new order in category дошкольная подготовка', 'order_request', 229, 1, '2022-06-30 06:58:22', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:22;s:11:\"description\";s:2:\"hi\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:229;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (302, 16, 'New order', 'You have new order in category дошкольная подготовка', 'order_request', 230, 1, '2022-06-30 07:07:07', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:30;s:11:\"description\";s:9:\"hey buddy\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:230;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (303, 16, 'New order', 'You have new order in category дошкольная подготовка', 'order_request', 231, 1, '2022-06-30 07:13:56', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:99;s:11:\"description\";s:3:\"asd\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:231;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (304, 16, 'Order canceled', 'Your order in category дошкольная подготовка is canceled', 'order_canceled', 231, 1, '2022-06-30 07:15:37', 'a:1:{s:4:\"type\";s:14:\"order_canceled\";}');
INSERT INTO `notification` VALUES (305, 16, 'New order', 'You have new order in category дошкольная подготовка', 'order_request', 232, 1, '2022-06-30 07:16:07', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:99;s:11:\"description\";s:3:\"asd\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:232;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (306, 16, 'Order canceled', 'Your order in category дошкольная подготовка is canceled', 'order_canceled', 232, 1, '2022-06-30 07:16:35', 'a:1:{s:4:\"type\";s:14:\"order_canceled\";}');
INSERT INTO `notification` VALUES (307, 16, 'New order', 'You have new order in category дошкольная подготовка', 'order_request', 233, 1, '2022-06-30 07:20:04', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:99;s:11:\"description\";s:3:\"asd\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:233;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (308, 16, 'Order canceled', 'Your order in category дошкольная подготовка is canceled', 'order_canceled', 233, 1, '2022-06-30 07:21:32', 'a:1:{s:4:\"type\";s:14:\"order_canceled\";}');
INSERT INTO `notification` VALUES (309, 16, 'New order', 'You have new order in category дошкольная подготовка', 'order_request', 234, 1, '2022-06-30 07:26:08', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:99;s:11:\"description\";s:3:\"asd\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:234;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (310, 16, 'Order canceled', 'Your order in category дошкольная подготовка is canceled', 'order_canceled', 234, 1, '2022-06-30 07:26:16', 'a:1:{s:4:\"type\";s:14:\"order_canceled\";}');
INSERT INTO `notification` VALUES (311, 16, 'New order', 'You have new order in category дошкольная подготовка', 'order_request', 235, 1, '2022-06-30 07:26:40', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:99;s:11:\"description\";s:3:\"asd\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:235;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (312, 16, 'Order canceled', 'Your order in category дошкольная подготовка is canceled', 'order_canceled', 235, 1, '2022-06-30 07:26:44', 'a:1:{s:4:\"type\";s:14:\"order_canceled\";}');
INSERT INTO `notification` VALUES (313, 16, 'New order', 'You have new order in category дошкольная подготовка', 'order_request', 236, 1, '2022-06-30 07:27:16', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:99;s:11:\"description\";s:3:\"asd\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:236;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (314, 16, 'Order canceled', 'Your order in category дошкольная подготовка is canceled', 'order_canceled', 236, 1, '2022-06-30 07:27:21', 'a:1:{s:4:\"type\";s:14:\"order_canceled\";}');
INSERT INTO `notification` VALUES (315, 16, 'New order', 'You have new order in category дошкольная подготовка', 'order_request', 237, 1, '2022-06-30 08:42:24', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:33;s:11:\"description\";s:6:\"sgsvsg\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:237;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (316, 16, 'Order canceled', 'Your order in category дошкольная подготовка is canceled', 'order_canceled', 237, 1, '2022-06-30 08:42:40', 'a:1:{s:4:\"type\";s:14:\"order_canceled\";}');
INSERT INTO `notification` VALUES (317, 16, 'New order', 'You have new order in category дошкольная подготовка', 'order_request', 238, 1, '2022-06-30 08:43:41', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:33;s:11:\"description\";s:6:\"sgsvsg\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:238;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (318, 16, 'Order canceled', 'Your order in category дошкольная подготовка is canceled', 'order_canceled', 238, 1, '2022-06-30 08:43:45', 'a:1:{s:4:\"type\";s:14:\"order_canceled\";}');
INSERT INTO `notification` VALUES (319, 16, 'New order', 'You have new order in category дошкольная подготовка', 'order_request', 239, 1, '2022-06-30 08:45:31', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:33;s:11:\"description\";s:6:\"sgsvsg\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:239;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (320, 16, 'Order canceled', 'Your order in category дошкольная подготовка is canceled', 'order_canceled', 239, 1, '2022-06-30 08:45:35', 'a:1:{s:4:\"type\";s:14:\"order_canceled\";}');
INSERT INTO `notification` VALUES (321, 16, 'New order', 'You have new order in category дошкольная подготовка', 'order_request', 240, 1, '2022-06-30 08:46:31', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:33;s:11:\"description\";s:6:\"sgsvsg\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:240;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (322, 16, 'Order canceled', 'Your order in category дошкольная подготовка is canceled', 'order_canceled', 240, 1, '2022-06-30 08:47:31', 'a:1:{s:4:\"type\";s:14:\"order_canceled\";}');
INSERT INTO `notification` VALUES (323, 16, 'New order', 'You have new order in category дошкольная подготовка', 'order_request', 241, 1, '2022-06-30 08:47:41', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:33;s:11:\"description\";s:6:\"sgsvsg\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:241;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (324, 3, 'New order', 'You have new order in category дошкольная подготовка', 'order_request', 242, 0, '2022-06-30 08:47:44', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:33;s:11:\"description\";s:6:\"sgsvsg\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:242;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (325, 16, 'Order canceled', 'Your order in category дошкольная подготовка is canceled', 'order_canceled', 241, 1, '2022-06-30 08:47:49', 'a:1:{s:4:\"type\";s:14:\"order_canceled\";}');
INSERT INTO `notification` VALUES (326, 3, 'Order canceled', 'Your order in category дошкольная подготовка is canceled', 'order_canceled', 242, 0, '2022-06-30 08:47:51', 'a:1:{s:4:\"type\";s:14:\"order_canceled\";}');
INSERT INTO `notification` VALUES (327, 37, 'New order', 'You have new order in category для детей', 'order_request', 243, 1, '2022-06-30 13:53:09', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:5588;s:11:\"description\";s:9:\"Bg Hn but\";s:5:\"phone\";s:12:\"+37477808915\";s:8:\"order_id\";i:243;s:14:\"category_title\";s:17:\"для детей\";}');
INSERT INTO `notification` VALUES (328, 13, 'New order', 'You have new order in category подготовка абитуриентов', 'order_request', 244, 1, '2022-07-01 09:14:19', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:69;s:11:\"description\";s:3:\"hey\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:244;s:14:\"category_title\";s:45:\"подготовка абитуриентов\";}');
INSERT INTO `notification` VALUES (329, 11, 'Order approved', 'Your order is approved', 'order_approved', 244, 1, '2022-07-01 09:14:32', 'a:1:{s:4:\"type\";s:14:\"order_approved\";}');
INSERT INTO `notification` VALUES (330, 43, 'New order', 'You have new order in category для детей', 'order_request', 245, 1, '2022-07-01 12:56:13', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:1000000;s:11:\"description\";s:3:\"Asd\";s:5:\"phone\";s:12:\"+37412123456\";s:8:\"order_id\";i:245;s:14:\"category_title\";s:17:\"для детей\";}');
INSERT INTO `notification` VALUES (331, 13, 'Order approved', 'Your order is approved', 'order_approved', 245, 1, '2022-07-01 12:56:29', 'a:1:{s:4:\"type\";s:14:\"order_approved\";}');
INSERT INTO `notification` VALUES (332, 43, 'New order', 'You have new order in category для детей', 'order_request', 246, 1, '2022-07-01 12:58:22', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:1000000;s:11:\"description\";s:10:\"Lalalalala\";s:5:\"phone\";s:12:\"+37412123456\";s:8:\"order_id\";i:246;s:14:\"category_title\";s:17:\"для детей\";}');
INSERT INTO `notification` VALUES (333, 13, 'Order declined', 'Your order is declined', 'order_declined', 246, 1, '2022-07-01 12:58:30', 'a:1:{s:4:\"type\";s:14:\"order_declined\";}');
INSERT INTO `notification` VALUES (334, 43, 'New order', 'You have new order in category услуги SMM', 'order_request', 247, 1, '2022-07-01 13:14:03', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:80000;s:11:\"description\";s:5:\"Hello\";s:5:\"phone\";s:12:\"+37412123456\";s:8:\"order_id\";i:247;s:14:\"category_title\";s:16:\"услуги SMM\";}');
INSERT INTO `notification` VALUES (335, 13, 'Order approved', 'Your order is approved', 'order_approved', 247, 1, '2022-07-01 13:14:17', 'a:1:{s:4:\"type\";s:14:\"order_approved\";}');
INSERT INTO `notification` VALUES (336, 13, 'New order', 'You have new order in category подготовка абитуриентов', 'order_request', 248, 1, '2022-07-01 13:29:11', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:588;s:11:\"description\";s:6:\"Ccucuc\";s:5:\"phone\";s:12:\"+37455252308\";s:8:\"order_id\";i:248;s:14:\"category_title\";s:45:\"подготовка абитуриентов\";}');
INSERT INTO `notification` VALUES (337, 44, 'Order approved', 'Your order is approved', 'order_approved', 248, 1, '2022-07-01 13:30:00', 'a:1:{s:4:\"type\";s:14:\"order_approved\";}');
INSERT INTO `notification` VALUES (338, 43, 'New order', 'You have new order in category пошив и переделка', 'order_request', 249, 1, '2022-07-01 13:53:42', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:23;s:11:\"description\";s:5:\"Fucuc\";s:5:\"phone\";s:12:\"+37456565656\";s:8:\"order_id\";i:249;s:14:\"category_title\";s:32:\"пошив и переделка\";}');
INSERT INTO `notification` VALUES (339, 43, 'Order canceled', 'Your order in category пошив и переделка is canceled', 'order_canceled', 249, 1, '2022-07-01 13:54:34', 'a:1:{s:4:\"type\";s:14:\"order_canceled\";}');
INSERT INTO `notification` VALUES (340, 43, 'New order', 'You have new order in category пошив и переделка', 'order_request', 250, 1, '2022-07-01 13:55:36', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:2588858;s:11:\"description\";s:5:\"Fucuc\";s:5:\"phone\";s:12:\"+37456565656\";s:8:\"order_id\";i:250;s:14:\"category_title\";s:32:\"пошив и переделка\";}');
INSERT INTO `notification` VALUES (341, 36, 'New order', 'You have new order in category пошив и переделка', 'order_request', 251, 1, '2022-07-01 13:56:25', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:2588858;s:11:\"description\";s:5:\"Fucuc\";s:5:\"phone\";s:12:\"+37456565656\";s:8:\"order_id\";i:251;s:14:\"category_title\";s:32:\"пошив и переделка\";}');
INSERT INTO `notification` VALUES (342, 13, 'New order', 'You have new order in category подготовка абитуриентов', 'order_request', 252, 1, '2022-07-01 21:14:01', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:69;s:11:\"description\";s:4:\"halo\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:252;s:14:\"category_title\";s:45:\"подготовка абитуриентов\";}');
INSERT INTO `notification` VALUES (343, 13, 'Order canceled', 'Your order in category подготовка абитуриентов is canceled', 'order_canceled', 252, 1, '2022-07-01 21:14:10', 'a:1:{s:4:\"type\";s:14:\"order_canceled\";}');
INSERT INTO `notification` VALUES (344, 16, 'New order', 'You have new order in category дошкольная подготовка', 'order_request', 253, 1, '2022-07-01 21:15:16', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:420;s:11:\"description\";s:5:\"ah ha\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:253;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (345, 36, 'New order', 'You have new order in category дошкольная подготовка', 'order_request', 254, 1, '2022-07-01 21:15:24', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:420;s:11:\"description\";s:5:\"ah ha\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:254;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (346, 36, 'New order', 'You have new order in category студийная съемка', 'order_request', 255, 1, '2022-07-01 21:15:48', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:66;s:11:\"description\";s:2:\"hi\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:255;s:14:\"category_title\";s:31:\"студийная съемка\";}');
INSERT INTO `notification` VALUES (347, 16, 'Order canceled', 'Your order in category дошкольная подготовка is canceled', 'order_canceled', 253, 1, '2022-07-01 21:16:54', 'a:1:{s:4:\"type\";s:14:\"order_canceled\";}');
INSERT INTO `notification` VALUES (348, 36, 'Order canceled', 'Your order in category дошкольная подготовка is canceled', 'order_canceled', 254, 1, '2022-07-01 21:16:56', 'a:1:{s:4:\"type\";s:14:\"order_canceled\";}');
INSERT INTO `notification` VALUES (349, 36, 'Order canceled', 'Your order in category студийная съемка is canceled', 'order_canceled', 255, 1, '2022-07-01 21:16:59', 'a:1:{s:4:\"type\";s:14:\"order_canceled\";}');
INSERT INTO `notification` VALUES (350, 13, 'New order', 'You have new order in category услуги ювелира', 'order_request', 256, 1, '2022-07-02 18:03:35', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:66;s:11:\"description\";s:2:\"hi\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:256;s:14:\"category_title\";s:27:\"услуги ювелира\";}');
INSERT INTO `notification` VALUES (351, 13, 'Order canceled', 'Your order in category услуги ювелира is canceled', 'order_canceled', 256, 1, '2022-07-02 18:03:44', 'a:1:{s:4:\"type\";s:14:\"order_canceled\";}');
INSERT INTO `notification` VALUES (352, 16, 'New order', 'You have new order in category дошкольная подготовка', 'order_request', 257, 1, '2022-07-04 13:36:38', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:11;s:11:\"description\";s:2:\"hi\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:257;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (353, 16, 'Order canceled', 'Your order in category дошкольная подготовка is canceled', 'order_canceled', 257, 1, '2022-07-04 13:38:09', 'a:1:{s:4:\"type\";s:14:\"order_canceled\";}');
INSERT INTO `notification` VALUES (354, 16, 'New order', 'You have new order in category дошкольная подготовка', 'order_request', 258, 1, '2022-07-05 10:47:38', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:200;s:11:\"description\";s:6:\"yo man\";s:5:\"phone\";s:12:\"+37411444555\";s:8:\"order_id\";i:258;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (355, 16, 'New order', 'You have new order in category дошкольная подготовка', 'order_request', 259, 1, '2022-07-07 09:06:48', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:111;s:11:\"description\";s:3:\"Asd\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:259;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (356, 16, 'Order canceled', 'Your order in category дошкольная подготовка is canceled', 'order_canceled', 259, 1, '2022-07-07 09:06:57', 'a:1:{s:4:\"type\";s:14:\"order_canceled\";}');
INSERT INTO `notification` VALUES (357, 16, 'Order canceled', 'Your order in category дошкольная подготовка is canceled', 'order_canceled', 259, 1, '2022-07-07 09:06:57', 'a:1:{s:4:\"type\";s:14:\"order_canceled\";}');
INSERT INTO `notification` VALUES (358, 16, 'New order', 'You have new order in category дошкольная подготовка', 'order_request', 261, 1, '2022-07-07 09:07:19', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:111;s:11:\"description\";s:3:\"Asd\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:261;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (359, 16, 'New order', 'You have new order in category дошкольная подготовка', 'order_request', 260, 1, '2022-07-07 09:07:19', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:111;s:11:\"description\";s:3:\"Asd\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:260;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (360, 16, 'Order canceled', 'Your order in category дошкольная подготовка is canceled', 'order_canceled', 260, 1, '2022-07-07 09:07:37', 'a:1:{s:4:\"type\";s:14:\"order_canceled\";}');
INSERT INTO `notification` VALUES (361, 16, 'Order canceled', 'Your order in category дошкольная подготовка is canceled', 'order_canceled', 261, 1, '2022-07-07 09:07:40', 'a:1:{s:4:\"type\";s:14:\"order_canceled\";}');
INSERT INTO `notification` VALUES (362, 16, 'New order', 'You have new order in category дошкольная подготовка', 'order_request', 262, 1, '2022-07-07 09:08:00', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:111;s:11:\"description\";s:3:\"Asd\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:262;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (363, 16, 'Order canceled', 'Your order in category дошкольная подготовка is canceled', 'order_canceled', 262, 1, '2022-07-07 09:08:11', 'a:1:{s:4:\"type\";s:14:\"order_canceled\";}');
INSERT INTO `notification` VALUES (364, 16, 'New order', 'You have new order in category дошкольная подготовка', 'order_request', 263, 1, '2022-07-07 09:08:27', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:111;s:11:\"description\";s:3:\"Asd\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:263;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (365, 11, 'Verification of account', 'Verification is successfull.', 'order_request_timeout', 0, 1, '2022-07-07 09:13:47', 'a:1:{s:4:\"type\";s:17:\"user_verification\";}');
INSERT INTO `notification` VALUES (366, 11, 'Timeout order', 'Your order canceled by timeout', 'order_request_timeout', 263, 1, '2022-07-07 09:14:01', 'a:1:{s:4:\"type\";s:21:\"order_request_timeout\";}');
INSERT INTO `notification` VALUES (367, 16, 'Timeout order', 'You order canceled becouse of no respose', 'order_request_timeout', 263, 1, '2022-07-07 09:14:02', 'a:1:{s:4:\"type\";s:21:\"order_request_timeout\";}');
INSERT INTO `notification` VALUES (368, 11, 'Verification of account', 'Verification is faild.', 'order_request_timeout', 0, 1, '2022-07-07 09:15:29', 'a:1:{s:4:\"type\";s:17:\"user_verification\";}');
INSERT INTO `notification` VALUES (369, 11, 'Verification of account', 'Verification is faild.', 'order_request_timeout', 0, 1, '2022-07-07 09:29:34', 'a:1:{s:4:\"type\";s:17:\"user_verification\";}');
INSERT INTO `notification` VALUES (370, 11, 'Verification of account', 'Verification is faild.', 'order_request_timeout', 0, 1, '2022-07-07 09:36:31', 'a:1:{s:4:\"type\";s:17:\"user_verification\";}');
INSERT INTO `notification` VALUES (371, 11, 'Verification of account', 'Verification is successfull.', 'order_request_timeout', 0, 1, '2022-07-07 09:39:03', 'a:1:{s:4:\"type\";s:17:\"user_verification\";}');
INSERT INTO `notification` VALUES (372, 11, 'Verification of account', 'Verification is successfull.', 'order_request_timeout', 0, 1, '2022-07-07 09:40:40', 'a:1:{s:4:\"type\";s:17:\"user_verification\";}');
INSERT INTO `notification` VALUES (373, 13, 'Verification of account', 'Verification is faild.', 'order_request_timeout', 0, 1, '2022-07-07 09:45:28', 'a:1:{s:4:\"type\";s:17:\"user_verification\";}');
INSERT INTO `notification` VALUES (374, 11, 'Verification of account', 'Verification is successfull.', 'order_request_timeout', 0, 1, '2022-07-07 09:52:46', 'a:1:{s:4:\"type\";s:17:\"user_verification\";}');
INSERT INTO `notification` VALUES (375, 11, 'Verification of account', 'Verification is faild.', 'order_request_timeout', 0, 1, '2022-07-07 09:54:11', 'a:1:{s:4:\"type\";s:17:\"user_verification\";}');
INSERT INTO `notification` VALUES (376, 11, 'Verification of account', 'Verification is faild.', 'order_request_timeout', 0, 1, '2022-07-07 09:54:52', 'a:1:{s:4:\"type\";s:17:\"user_verification\";}');
INSERT INTO `notification` VALUES (377, 11, 'Verification of account', 'Verification is successfull.', 'order_request_timeout', 0, 1, '2022-07-07 09:55:40', 'a:1:{s:4:\"type\";s:17:\"user_verification\";}');
INSERT INTO `notification` VALUES (378, 11, 'Verification of account', 'Verification is faild.', 'order_request_timeout', 0, 1, '2022-07-07 09:57:10', 'a:1:{s:4:\"type\";s:17:\"user_verification\";}');
INSERT INTO `notification` VALUES (379, 11, 'Verification of account', 'Verification is successfull.', 'order_request_timeout', 0, 1, '2022-07-07 09:57:40', 'a:1:{s:4:\"type\";s:17:\"user_verification\";}');
INSERT INTO `notification` VALUES (380, 11, 'Verification of account', 'Verification is faild.', 'order_request_timeout', 0, 1, '2022-07-07 09:58:14', 'a:1:{s:4:\"type\";s:17:\"user_verification\";}');
INSERT INTO `notification` VALUES (381, 11, 'Verification of account', 'Verification is successfull.', 'order_request_timeout', 0, 1, '2022-07-07 09:58:55', 'a:1:{s:4:\"type\";s:17:\"user_verification\";}');
INSERT INTO `notification` VALUES (382, 11, 'Verification of account', 'Verification is faild.', 'order_request_timeout', 0, 1, '2022-07-07 11:18:56', 'a:1:{s:4:\"type\";s:17:\"user_verification\";}');
INSERT INTO `notification` VALUES (383, 3, 'New order', 'You have new order in category дошкольная подготовка', 'order_request', 264, 0, '2022-07-07 11:23:30', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:22;s:11:\"description\";s:3:\"aaa\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:264;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (384, 11, 'Timeout order', 'Your order canceled by timeout', 'order_request_timeout', 264, 1, '2022-07-07 11:29:01', 'a:1:{s:4:\"type\";s:21:\"order_request_timeout\";}');
INSERT INTO `notification` VALUES (385, 3, 'Timeout order', 'You order canceled becouse of no respose', 'order_request_timeout', 264, 0, '2022-07-07 11:29:02', 'a:1:{s:4:\"type\";s:21:\"order_request_timeout\";}');
INSERT INTO `notification` VALUES (386, 11, 'New order', 'You have new order in category школьная программа', 'order_request', 265, 1, '2022-07-07 17:06:47', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:22;s:11:\"description\";s:5:\"Agsgs\";s:5:\"phone\";s:12:\"+37412123456\";s:8:\"order_id\";i:265;s:14:\"category_title\";s:35:\"школьная программа\";}');
INSERT INTO `notification` VALUES (387, 13, 'Order approved', 'Your order is approved', 'order_approved', 265, 1, '2022-07-07 17:08:15', 'a:1:{s:4:\"type\";s:14:\"order_approved\";}');
INSERT INTO `notification` VALUES (388, 11, 'Verification of account', 'Verification is faild.', 'order_request_timeout', 0, 1, '2022-07-07 18:17:53', 'a:1:{s:4:\"type\";s:17:\"user_verification\";}');
INSERT INTO `notification` VALUES (389, 16, 'New order', 'You have new order in category дошкольная подготовка', 'order_request', 266, 1, '2022-07-07 19:36:31', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:22;s:11:\"description\";s:3:\"aaa\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:266;s:14:\"category_title\";s:41:\"дошкольная подготовка\";}');
INSERT INTO `notification` VALUES (390, 16, 'Order canceled', 'Your order in category дошкольная подготовка is canceled', 'order_canceled', 266, 1, '2022-07-07 19:36:37', 'a:1:{s:4:\"type\";s:14:\"order_canceled\";}');
INSERT INTO `notification` VALUES (391, 37, 'New order', 'You have new order in category для пожилых людей', 'order_request', 267, 1, '2022-07-08 15:27:10', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:40;s:11:\"description\";s:9:\"Maybe 40?\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:267;s:14:\"category_title\";s:32:\"для пожилых людей\";}');
INSERT INTO `notification` VALUES (392, 11, 'Order approved', 'Your order is approved', 'order_approved', 267, 1, '2022-07-08 15:30:41', 'a:1:{s:4:\"type\";s:14:\"order_approved\";}');
INSERT INTO `notification` VALUES (393, 37, 'Verification of account', 'Verification is faild.', 'order_request_timeout', 0, 1, '2022-07-08 15:35:19', 'a:1:{s:4:\"type\";s:17:\"user_verification\";}');
INSERT INTO `notification` VALUES (394, 37, 'Verification of account', 'Verification is successfull.', 'order_request_timeout', 0, 1, '2022-07-08 15:35:56', 'a:1:{s:4:\"type\";s:17:\"user_verification\";}');
INSERT INTO `notification` VALUES (395, 37, 'New order', 'You have new order in category студийная съемка', 'order_request', 268, 1, '2022-07-11 08:19:00', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:5;s:11:\"description\";s:11:\"Я хочу\";s:5:\"phone\";s:12:\"+37494267690\";s:8:\"order_id\";i:268;s:14:\"category_title\";s:31:\"студийная съемка\";}');
INSERT INTO `notification` VALUES (396, 12, 'Order approved', 'Your order is approved', 'order_approved', 268, 1, '2022-07-11 08:19:29', 'a:1:{s:4:\"type\";s:14:\"order_approved\";}');
INSERT INTO `notification` VALUES (397, 11, 'New order', 'You have new order in category Cosmetology', 'order_request', 269, 1, '2022-07-12 22:08:31', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:22;s:11:\"description\";s:2:\"Hi\";s:5:\"phone\";s:12:\"+37412123456\";s:8:\"order_id\";i:269;s:14:\"category_title\";s:11:\"Cosmetology\";}');
INSERT INTO `notification` VALUES (398, 13, 'Order approved', 'Your order is approved', 'order_approved', 269, 1, '2022-07-12 22:08:39', 'a:1:{s:4:\"type\";s:14:\"order_approved\";}');
INSERT INTO `notification` VALUES (399, 11, 'New order', 'You have new order in category Cosmetology', 'order_request', 270, 1, '2022-07-12 22:08:45', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:22;s:11:\"description\";s:2:\"Hi\";s:5:\"phone\";s:12:\"+37412123456\";s:8:\"order_id\";i:270;s:14:\"category_title\";s:11:\"Cosmetology\";}');
INSERT INTO `notification` VALUES (400, 13, 'Order declined', 'Your order is declined', 'order_declined', 270, 1, '2022-07-12 22:08:48', 'a:1:{s:4:\"type\";s:14:\"order_declined\";}');
INSERT INTO `notification` VALUES (401, 38, 'New order', 'You have new order in category Համակարգչային օգնություն', 'order_request', 271, 1, '2022-07-13 14:23:29', 'a:6:{s:4:\"type\";s:13:\"order_request\";s:5:\"price\";i:300;s:11:\"description\";s:6:\"Ола\";s:5:\"phone\";s:12:\"+37494233447\";s:8:\"order_id\";i:271;s:14:\"category_title\";s:47:\"Համակարգչային օգնություն\";}');
INSERT INTO `notification` VALUES (402, 38, 'Order canceled', 'Your order in category Համակարգչային օգնություն is canceled', 'order_canceled', 271, 1, '2022-07-13 14:27:58', 'a:1:{s:4:\"type\";s:14:\"order_canceled\";}');

-- ----------------------------
-- Table structure for orders
-- ----------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `master_id` int NULL DEFAULT NULL,
  `service_id` int NOT NULL DEFAULT 0,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  `price` int NULL DEFAULT NULL,
  `status` enum('waiting','approved','declined','canceled') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'waiting',
  `comment` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `rate` tinyint(1) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 272 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of orders
-- ----------------------------
INSERT INTO `orders` VALUES (127, 16, 13, 48, 'ggg', 12, 'approved', 'asfadd', 3, '2022-06-16 07:47:54');
INSERT INTO `orders` VALUES (128, 16, 13, 48, 'ggg', 12, 'declined', NULL, NULL, '2022-06-16 07:48:53');
INSERT INTO `orders` VALUES (129, 13, 16, 51, 'Dfg', 12, 'approved', 'Asd', 5, '2022-06-16 07:50:45');
INSERT INTO `orders` VALUES (130, 13, 16, 51, 'Dfg', 12, 'declined', NULL, NULL, '2022-06-16 07:51:18');
INSERT INTO `orders` VALUES (131, 13, 16, 51, 'Dfg', 12, 'approved', NULL, NULL, '2022-06-16 07:51:29');
INSERT INTO `orders` VALUES (132, 13, 16, 51, 'Dfg', 12, 'approved', NULL, NULL, '2022-06-16 07:51:57');
INSERT INTO `orders` VALUES (133, 13, 16, 51, 'Dfg', 12, 'canceled', NULL, NULL, '2022-06-16 07:54:39');
INSERT INTO `orders` VALUES (134, 1, 2, 1, 'Dfg', 12, 'canceled', NULL, NULL, '2022-06-16 07:45:57');
INSERT INTO `orders` VALUES (135, 13, 16, 51, 'Dfg', 12, 'canceled', NULL, NULL, '2022-06-16 07:57:00');
INSERT INTO `orders` VALUES (136, 13, 16, 51, 'Dfg', 12, 'canceled', NULL, NULL, '2022-06-16 07:58:28');
INSERT INTO `orders` VALUES (137, 13, 16, 51, 'Dfg', 12, 'canceled', NULL, NULL, '2022-06-16 07:59:11');
INSERT INTO `orders` VALUES (138, 13, 16, 51, 'Dfg', 12, 'canceled', NULL, NULL, '2022-06-16 08:00:22');
INSERT INTO `orders` VALUES (139, 13, 16, 51, 'Dfg', 12, 'canceled', NULL, NULL, '2022-06-16 08:02:08');
INSERT INTO `orders` VALUES (140, 13, 16, 51, 'Dfg', 12, 'approved', NULL, NULL, '2022-06-16 08:02:29');
INSERT INTO `orders` VALUES (141, 16, 13, 48, 'asd', 11, 'approved', NULL, NULL, '2022-06-16 08:21:55');
INSERT INTO `orders` VALUES (142, 16, 13, 48, 'asd', 11, 'canceled', NULL, NULL, '2022-06-16 09:18:16');
INSERT INTO `orders` VALUES (143, 13, 16, 51, 'Asd', 11, 'canceled', NULL, NULL, '2022-06-16 09:19:33');
INSERT INTO `orders` VALUES (144, 1, 2, 1, 'Asd', 11, 'canceled', NULL, NULL, '2022-06-16 07:19:33');
INSERT INTO `orders` VALUES (145, 11, 13, 48, 'ahaha', 11, 'canceled', NULL, NULL, '2022-06-16 11:53:38');
INSERT INTO `orders` VALUES (146, 11, 36, 55, 'Asd', 11, 'approved', NULL, NULL, '2022-06-16 12:46:26');
INSERT INTO `orders` VALUES (147, 38, 37, 65, 'Когда придешь?', NULL, 'approved', NULL, NULL, '2022-06-16 16:33:36');
INSERT INTO `orders` VALUES (148, 38, 3, 7, 'I need to change 5 toilets', NULL, 'canceled', NULL, NULL, '2022-06-17 17:45:17');
INSERT INTO `orders` VALUES (149, 38, 37, 66, 'Hi', NULL, 'approved', NULL, NULL, '2022-06-17 18:00:45');
INSERT INTO `orders` VALUES (150, 38, 37, 65, 'Zakaz', NULL, 'canceled', NULL, NULL, '2022-06-19 07:56:49');
INSERT INTO `orders` VALUES (151, 39, 38, 69, 'barev dzez', 15, 'approved', NULL, NULL, '2022-06-19 08:04:45');
INSERT INTO `orders` VALUES (152, 11, 3, 7, 'Asd', 12, 'canceled', NULL, NULL, '2022-06-20 15:50:24');
INSERT INTO `orders` VALUES (153, 11, 13, 54, 'Asd', 12, 'canceled', NULL, NULL, '2022-06-20 15:52:56');
INSERT INTO `orders` VALUES (154, 11, 13, 54, 'Asd', 22, 'canceled', NULL, NULL, '2022-06-20 15:58:17');
INSERT INTO `orders` VALUES (155, 11, 36, 63, 'Asd', 22, 'canceled', NULL, NULL, '2022-06-20 15:59:38');
INSERT INTO `orders` VALUES (156, 11, 3, 7, 'Asd', 12, 'canceled', NULL, NULL, '2022-06-20 16:14:03');
INSERT INTO `orders` VALUES (157, 11, 16, 51, 'Asd', 11, 'canceled', NULL, NULL, '2022-06-20 16:19:24');
INSERT INTO `orders` VALUES (158, 11, 3, 7, 'Asd', 12, 'canceled', NULL, NULL, '2022-06-20 16:24:58');
INSERT INTO `orders` VALUES (159, 11, 13, 54, 'Asd', 11, 'canceled', NULL, NULL, '2022-06-20 16:49:56');
INSERT INTO `orders` VALUES (160, 11, 36, 63, 'Asd', 11, 'canceled', NULL, NULL, '2022-06-20 16:51:14');
INSERT INTO `orders` VALUES (161, 11, 13, 54, 'Asd', 100, 'canceled', NULL, NULL, '2022-06-21 07:01:54');
INSERT INTO `orders` VALUES (162, 11, 36, 63, 'Asd', 100, 'canceled', NULL, NULL, '2022-06-21 07:03:15');
INSERT INTO `orders` VALUES (163, 11, 16, 51, 'Asd', 100, 'canceled', NULL, NULL, '2022-06-21 07:04:20');
INSERT INTO `orders` VALUES (164, 11, 3, 7, 'Asd', 100, 'canceled', NULL, NULL, '2022-06-21 07:06:01');
INSERT INTO `orders` VALUES (165, 11, 13, 54, 'Asd', 100, 'canceled', NULL, NULL, '2022-06-21 07:08:11');
INSERT INTO `orders` VALUES (166, 11, 13, 54, 'Ag', 1212, 'canceled', NULL, NULL, '2022-06-21 10:12:24');
INSERT INTO `orders` VALUES (167, 11, 40, 71, 'Halo', 1000000, 'approved', NULL, NULL, '2022-06-21 11:58:41');
INSERT INTO `orders` VALUES (168, 11, 40, 71, 'Halo', 1000000, 'approved', NULL, NULL, '2022-06-21 11:59:33');
INSERT INTO `orders` VALUES (169, 11, 40, 71, 'Halo', 1000000, 'approved', NULL, NULL, '2022-06-21 11:59:43');
INSERT INTO `orders` VALUES (170, 11, 40, 71, 'Halo', 1000000, 'approved', NULL, NULL, '2022-06-21 12:00:27');
INSERT INTO `orders` VALUES (171, 11, 40, 71, 'Halo', 1000000, 'approved', NULL, NULL, '2022-06-21 12:00:46');
INSERT INTO `orders` VALUES (172, 11, 40, 71, 'Halo', 1000000, 'approved', NULL, NULL, '2022-06-21 12:01:40');
INSERT INTO `orders` VALUES (173, 11, 40, 71, 'Halo', 1000000, 'approved', NULL, NULL, '2022-06-21 12:01:58');
INSERT INTO `orders` VALUES (174, 11, 40, 71, 'Halo', 1000000, 'approved', NULL, NULL, '2022-06-21 12:02:08');
INSERT INTO `orders` VALUES (175, 11, 40, 71, 'Halo', 1000000, 'approved', NULL, NULL, '2022-06-21 12:02:22');
INSERT INTO `orders` VALUES (176, 11, 40, 71, 'Halo', 1000000, 'approved', NULL, NULL, '2022-06-21 12:02:58');
INSERT INTO `orders` VALUES (177, 11, 40, 71, 'Halo', 1000000, 'approved', NULL, NULL, '2022-06-21 12:03:11');
INSERT INTO `orders` VALUES (178, 11, 40, 71, 'Halo', 1000000, 'approved', NULL, NULL, '2022-06-21 12:03:50');
INSERT INTO `orders` VALUES (179, 11, 40, 71, 'Halo', 10000002, 'approved', NULL, NULL, '2022-06-21 12:04:05');
INSERT INTO `orders` VALUES (180, 11, 40, 71, 'Asd', 22, 'approved', NULL, NULL, '2022-06-21 12:26:14');
INSERT INTO `orders` VALUES (181, 11, 3, 7, 'sss', 22, 'canceled', NULL, NULL, '2022-06-23 08:56:43');
INSERT INTO `orders` VALUES (182, 11, 13, 79, 'sss', 22, 'canceled', NULL, NULL, '2022-06-23 08:56:55');
INSERT INTO `orders` VALUES (183, 11, 13, 79, 'asd', 11, 'canceled', NULL, NULL, '2022-06-23 09:17:31');
INSERT INTO `orders` VALUES (184, 11, 3, 7, 'asd', 11, 'canceled', NULL, NULL, '2022-06-23 09:30:32');
INSERT INTO `orders` VALUES (185, 11, 13, 79, 'aaa', 11, 'canceled', NULL, NULL, '2022-06-23 09:34:44');
INSERT INTO `orders` VALUES (186, 11, 13, 79, 'aaa', 222, 'canceled', NULL, NULL, '2022-06-23 09:55:17');
INSERT INTO `orders` VALUES (187, 11, 3, 7, 'blablabla', 666, 'canceled', NULL, NULL, '2022-06-23 09:56:27');
INSERT INTO `orders` VALUES (188, 11, 3, 7, 'asd', 12, 'canceled', NULL, NULL, '2022-06-23 10:35:18');
INSERT INTO `orders` VALUES (189, 11, 36, 61, 'asd', 444, 'canceled', NULL, NULL, '2022-06-23 11:25:00');
INSERT INTO `orders` VALUES (190, 11, 36, 61, 'asd', 444, 'canceled', NULL, NULL, '2022-06-23 11:30:25');
INSERT INTO `orders` VALUES (191, 11, 36, 61, 'asd', 444, 'canceled', NULL, NULL, '2022-06-23 11:43:40');
INSERT INTO `orders` VALUES (192, 11, 3, 7, 'blablabla', 666, 'canceled', NULL, NULL, '2022-06-23 11:46:04');
INSERT INTO `orders` VALUES (193, 11, 37, 65, 'blablabla', 666, 'canceled', NULL, NULL, '2022-06-23 11:46:23');
INSERT INTO `orders` VALUES (194, 11, 13, 79, 'aaa', 11, 'canceled', NULL, NULL, '2022-06-23 11:48:45');
INSERT INTO `orders` VALUES (195, 11, 3, 7, 'aaa', 44, 'canceled', NULL, NULL, '2022-06-23 11:58:58');
INSERT INTO `orders` VALUES (196, 11, 13, 81, 'фыа', 22, 'canceled', NULL, NULL, '2022-06-24 08:22:21');
INSERT INTO `orders` VALUES (197, 11, 13, 79, 'halo', 22, 'canceled', NULL, NULL, '2022-06-24 13:22:08');
INSERT INTO `orders` VALUES (198, 11, 36, 64, 'fff', 55, 'canceled', NULL, NULL, '2022-06-24 13:24:20');
INSERT INTO `orders` VALUES (199, 11, 13, 79, 'halo man', 22, 'canceled', NULL, NULL, '2022-06-24 18:29:00');
INSERT INTO `orders` VALUES (200, 13, 11, 91, '[AS]', 420, 'canceled', NULL, NULL, '2022-06-27 10:25:20');
INSERT INTO `orders` VALUES (201, 11, 13, 79, '[AS]', 420, 'canceled', NULL, NULL, '2022-06-27 10:27:21');
INSERT INTO `orders` VALUES (202, 11, 13, 79, '[AS]', 420, 'canceled', NULL, NULL, '2022-06-27 10:51:18');
INSERT INTO `orders` VALUES (203, 11, 13, 79, 'hqhwhwhehehehehehehehhshshshdhdhdhdh hegehegegshsgsgdgsggegegsgsgsgsgsgsgsgsgsg', 420, 'canceled', NULL, NULL, '2022-06-27 11:59:39');
INSERT INTO `orders` VALUES (204, 13, 11, 91, '#ddddddddddddddddddddddddddd', 33, 'canceled', NULL, NULL, '2022-06-27 12:03:59');
INSERT INTO `orders` VALUES (205, 11, 13, 79, 'gggggggggggggggggffffffffffffffffff', 333, 'canceled', NULL, NULL, '2022-06-27 12:07:00');
INSERT INTO `orders` VALUES (206, 11, 13, 92, 'fffff', 333, 'canceled', NULL, NULL, '2022-06-27 12:09:06');
INSERT INTO `orders` VALUES (207, 11, 13, 81, 'ddddddddddddddddddddffffffffffffffffffffffffssssssssssssssssssssssssssssssssssss', 222, 'canceled', NULL, NULL, '2022-06-27 12:10:11');
INSERT INTO `orders` VALUES (208, 11, 13, 82, 'trying', 22, 'canceled', NULL, NULL, '2022-06-27 12:10:58');
INSERT INTO `orders` VALUES (209, 11, 13, 79, 'ggggggggggggg', 33, 'canceled', NULL, NULL, '2022-06-27 12:13:10');
INSERT INTO `orders` VALUES (210, 11, 13, 82, 'dd', 22, 'canceled', NULL, NULL, '2022-06-27 12:16:40');
INSERT INTO `orders` VALUES (211, 11, 13, 92, 't', 33, 'canceled', NULL, NULL, '2022-06-27 12:17:39');
INSERT INTO `orders` VALUES (212, 11, 13, 79, 'tt', 88, 'canceled', NULL, NULL, '2022-06-27 12:20:24');
INSERT INTO `orders` VALUES (213, 11, 13, 92, 'll', 33, 'canceled', NULL, NULL, '2022-06-27 12:23:22');
INSERT INTO `orders` VALUES (214, 11, 13, 81, 'gg', 66, 'canceled', NULL, NULL, '2022-06-27 12:24:33');
INSERT INTO `orders` VALUES (215, 11, 13, 82, 'l', 1, 'canceled', NULL, NULL, '2022-06-27 12:25:55');
INSERT INTO `orders` VALUES (216, 11, 13, 79, 'ttt', 55, 'canceled', NULL, NULL, '2022-06-27 12:26:36');
INSERT INTO `orders` VALUES (217, 11, 13, 81, 'tyyy', 22, 'approved', 'good', 5, '2022-06-27 12:31:15');
INSERT INTO `orders` VALUES (218, 11, 13, 79, 'll', 22, 'approved', 'Good', 5, '2022-06-27 12:33:47');
INSERT INTO `orders` VALUES (219, 11, 13, 79, 'll', 22, 'approved', NULL, NULL, '2022-06-27 12:35:51');
INSERT INTO `orders` VALUES (220, 11, 13, 79, 'll', 22, 'approved', NULL, NULL, '2022-06-27 12:36:29');
INSERT INTO `orders` VALUES (221, 11, 13, 79, 'll', 22, 'approved', 'asd', 3, '2022-06-27 12:37:27');
INSERT INTO `orders` VALUES (222, 11, 13, 79, 'll', 22, 'declined', NULL, NULL, '2022-06-27 12:39:48');
INSERT INTO `orders` VALUES (223, 11, 13, 79, 'll', 22, 'approved', 'cool', 5, '2022-06-27 12:40:02');
INSERT INTO `orders` VALUES (224, 11, 13, 94, 'gggggggggggggggggggwgwgegegsgsgege gsgsgshshshshshshdhshshshshshshshshshshshshsh', 200, 'approved', 'fantastic', 5, '2022-06-27 12:50:40');
INSERT INTO `orders` VALUES (225, 11, 13, 94, 'halo', 22, 'approved', 'ddd\nfffyjkl\nfffffff\nggg', 5, '2022-06-27 13:04:48');
INSERT INTO `orders` VALUES (226, 11, 13, 93, 'ggg', 999, 'approved', 'cook guy', 5, '2022-06-27 13:06:27');
INSERT INTO `orders` VALUES (227, 11, 13, 93, 'tt', 22, 'approved', 'gggg', 5, '2022-06-27 13:13:29');
INSERT INTO `orders` VALUES (228, 11, 13, 95, 'Problems in kitchen, must be fixed until sunday', 300, 'approved', 'At the time of its release Ducati claimed that the 1199 Panigale was the worl', 5, '2022-06-27 13:47:27');
INSERT INTO `orders` VALUES (229, 11, 16, 51, 'hi', 22, 'canceled', NULL, NULL, '2022-06-30 06:58:22');
INSERT INTO `orders` VALUES (230, 11, 16, 51, 'hey buddy', 30, 'canceled', NULL, NULL, '2022-06-30 07:07:07');
INSERT INTO `orders` VALUES (231, 11, 16, 51, 'asd', 99, 'canceled', NULL, NULL, '2022-06-30 07:13:56');
INSERT INTO `orders` VALUES (232, 11, 16, 51, 'asd', 99, 'canceled', NULL, NULL, '2022-06-30 07:16:07');
INSERT INTO `orders` VALUES (233, 11, 16, 51, 'asd', 99, 'canceled', NULL, NULL, '2022-06-30 07:20:04');
INSERT INTO `orders` VALUES (234, 11, 16, 51, 'asd', 99, 'canceled', NULL, NULL, '2022-06-30 07:26:08');
INSERT INTO `orders` VALUES (235, 11, 16, 51, 'asd', 99, 'canceled', NULL, NULL, '2022-06-30 07:26:40');
INSERT INTO `orders` VALUES (236, 11, 16, 51, 'asd', 99, 'canceled', NULL, NULL, '2022-06-30 07:27:16');
INSERT INTO `orders` VALUES (237, 11, 16, 51, 'sgsvsg', 33, 'canceled', NULL, NULL, '2022-06-30 08:42:24');
INSERT INTO `orders` VALUES (238, 11, 16, 51, 'sgsvsg', 33, 'canceled', NULL, NULL, '2022-06-30 08:43:41');
INSERT INTO `orders` VALUES (239, 11, 16, 51, 'sgsvsg', 33, 'canceled', NULL, NULL, '2022-06-30 08:45:31');
INSERT INTO `orders` VALUES (240, 11, 16, 51, 'sgsvsg', 33, 'canceled', NULL, NULL, '2022-06-30 08:46:31');
INSERT INTO `orders` VALUES (241, 11, 16, 51, 'sgsvsg', 33, 'canceled', NULL, NULL, '2022-06-30 08:47:41');
INSERT INTO `orders` VALUES (242, 11, 3, 7, 'sgsvsg', 33, 'canceled', NULL, NULL, '2022-06-30 08:47:44');
INSERT INTO `orders` VALUES (243, 43, 37, 66, 'Bg Hn but', 5588, 'canceled', NULL, NULL, '2022-06-30 13:53:09');
INSERT INTO `orders` VALUES (244, 11, 13, 82, 'hey', 69, 'approved', 'cool man !', 5, '2022-07-01 09:14:19');
INSERT INTO `orders` VALUES (245, 13, 43, 98, 'Asd', 1000000, 'approved', 'Maybe 500k?', 5, '2022-07-01 12:56:13');
INSERT INTO `orders` VALUES (246, 13, 43, 98, 'Lalalalala', 1000000, 'declined', NULL, NULL, '2022-07-01 12:58:22');
INSERT INTO `orders` VALUES (247, 13, 43, 108, 'Hello', 80000, 'approved', NULL, NULL, '2022-07-01 13:14:03');
INSERT INTO `orders` VALUES (248, 44, 13, 82, 'Ccucuc', 588, 'approved', 'thx', 3, '2022-07-01 13:29:11');
INSERT INTO `orders` VALUES (249, 45, 43, 107, 'Fucuc', 23, 'canceled', NULL, NULL, '2022-07-01 13:53:42');
INSERT INTO `orders` VALUES (250, 45, 43, 107, 'Fucuc', 2588858, 'canceled', NULL, NULL, '2022-07-01 13:55:36');
INSERT INTO `orders` VALUES (251, 45, 36, 61, 'Fucuc', 2588858, 'canceled', NULL, NULL, '2022-07-01 13:56:25');
INSERT INTO `orders` VALUES (252, 11, 13, 82, 'halo', 69, 'canceled', NULL, NULL, '2022-07-01 21:14:01');
INSERT INTO `orders` VALUES (253, 11, 16, 51, 'ah ha', 420, 'canceled', NULL, NULL, '2022-07-01 21:15:16');
INSERT INTO `orders` VALUES (254, 11, 36, 63, 'ah ha', 420, 'canceled', NULL, NULL, '2022-07-01 21:15:24');
INSERT INTO `orders` VALUES (255, 11, 36, 64, 'hi', 66, 'canceled', NULL, NULL, '2022-07-01 21:15:48');
INSERT INTO `orders` VALUES (256, 11, 13, 94, 'hi', 66, 'canceled', NULL, NULL, '2022-07-02 18:03:35');
INSERT INTO `orders` VALUES (257, 11, 16, 51, 'hi', 11, 'canceled', NULL, NULL, '2022-07-04 13:36:38');
INSERT INTO `orders` VALUES (258, 50, 16, 51, 'yo man', 200, 'canceled', NULL, NULL, '2022-07-05 10:47:38');
INSERT INTO `orders` VALUES (259, 11, 16, 51, 'Asd', 111, 'canceled', NULL, NULL, '2022-07-07 09:06:48');
INSERT INTO `orders` VALUES (260, 11, 16, 51, 'Asd', 111, 'canceled', NULL, NULL, '2022-07-07 09:07:19');
INSERT INTO `orders` VALUES (261, 11, 16, 51, 'Asd', 111, 'canceled', NULL, NULL, '2022-07-07 09:07:19');
INSERT INTO `orders` VALUES (262, 11, 16, 51, 'Asd', 111, 'canceled', NULL, NULL, '2022-07-07 09:08:00');
INSERT INTO `orders` VALUES (263, 11, 16, 51, 'Asd', 111, 'canceled', NULL, NULL, '2022-07-07 09:08:27');
INSERT INTO `orders` VALUES (264, 11, 3, 7, 'aaa', 22, 'canceled', NULL, NULL, '2022-07-07 11:23:30');
INSERT INTO `orders` VALUES (265, 13, 11, 104, 'Agsgs', 22, 'approved', NULL, NULL, '2022-07-07 17:06:47');
INSERT INTO `orders` VALUES (266, 11, 16, 51, 'aaa', 22, 'canceled', NULL, NULL, '2022-07-07 19:36:31');
INSERT INTO `orders` VALUES (267, 11, 37, 118, 'Maybe 40?', 40, 'approved', 'Good man', 5, '2022-07-08 15:27:10');
INSERT INTO `orders` VALUES (268, 12, 37, 119, 'Я хочу', 5, 'approved', 'Оки', 5, '2022-07-11 08:19:00');
INSERT INTO `orders` VALUES (269, 13, 11, 115, 'Hi', 22, 'approved', NULL, NULL, '2022-07-12 22:08:31');
INSERT INTO `orders` VALUES (270, 13, 11, 115, 'Hi', 22, 'declined', NULL, NULL, '2022-07-12 22:08:45');
INSERT INTO `orders` VALUES (271, 11, 38, 69, 'Ола', 300, 'canceled', NULL, NULL, '2022-07-13 14:23:29');

-- ----------------------------
-- Table structure for personal_access_tokens
-- ----------------------------
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `last_used_at` timestamp(0) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `personal_access_tokens_token_unique`(`token`) USING BTREE,
  INDEX `personal_access_tokens_tokenable_type_tokenable_id_index`(`tokenable_type`, `tokenable_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 235 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of personal_access_tokens
-- ----------------------------
INSERT INTO `personal_access_tokens` VALUES (11, 'App\\Models\\User', 2, 'auth_token', 'd29f645ff84a3dc4bf46abef6d16f1cf04a02e3a951e55d3cbc002c9ff4d8d2d', '[\"*\"]', NULL, '2022-05-28 10:47:30', '2022-05-28 10:47:30');
INSERT INTO `personal_access_tokens` VALUES (22, 'App\\Models\\User', 3, 'auth_token', 'ee6993c31c162e51f414376ef2f72a719b348fa275d437be5089dbff8809ed04', '[\"*\"]', '2022-05-29 08:03:02', '2022-05-29 08:01:00', '2022-05-29 08:03:02');
INSERT INTO `personal_access_tokens` VALUES (45, 'App\\Models\\User', 3, 'auth_token', 'ee626017be42fd5f9bcce3364e65e3f110edb2a104be47cb0b78daa41de2a0aa', '[\"*\"]', '2022-06-02 12:57:19', '2022-06-01 12:16:15', '2022-06-02 12:57:19');
INSERT INTO `personal_access_tokens` VALUES (46, 'App\\Models\\User', 3, 'auth_token', '23e16157a768196a2b987154b19b2394fde77adac2019466fdaa53291c3a8eb8', '[\"*\"]', '2022-06-01 13:15:04', '2022-06-01 13:13:34', '2022-06-01 13:15:04');
INSERT INTO `personal_access_tokens` VALUES (59, 'App\\Models\\User', 3, 'auth_token', '85def0d39e0763d17e2a71dd239d785914c5b89004679b43d4ccff6600abf5ff', '[\"*\"]', '2022-06-02 12:57:11', '2022-06-02 12:56:52', '2022-06-02 12:57:11');
INSERT INTO `personal_access_tokens` VALUES (60, 'App\\Models\\User', 2, 'auth_token', '2e6e7ee190f3c772bf345d11dc6b7601e18958f4468b34b4ec000e6132669e53', '[\"*\"]', '2022-06-02 13:11:07', '2022-06-02 13:11:04', '2022-06-02 13:11:07');
INSERT INTO `personal_access_tokens` VALUES (64, 'App\\Models\\User', 3, 'auth_token', '2a0ae147738583b77d86e2c674e7fc3e9fb61d54d55eae760e74694285e920c0', '[\"*\"]', '2022-06-03 18:07:36', '2022-06-03 12:16:49', '2022-06-03 18:07:36');
INSERT INTO `personal_access_tokens` VALUES (65, 'App\\Models\\User', 3, 'auth_token', 'b2b870e650a4022d270aca803c6d26c0fd92bb7d27379142b9de0d949816c55b', '[\"*\"]', '2022-06-03 18:01:12', '2022-06-03 17:44:30', '2022-06-03 18:01:12');
INSERT INTO `personal_access_tokens` VALUES (74, 'App\\Models\\User', 2, 'auth_token', '7edd51016bdd2f27418754067b950c204c2a3b47255a073a7030618afb868c98', '[\"*\"]', '2022-06-05 18:15:26', '2022-06-05 18:11:25', '2022-06-05 18:15:26');
INSERT INTO `personal_access_tokens` VALUES (78, 'App\\Models\\User', 4, 'auth_token', 'c0f58ed60cf28827421c3676772514e16a133067916e33eabf01f46e416b99a9', '[\"*\"]', '2022-06-06 14:07:12', '2022-06-06 09:42:22', '2022-06-06 14:07:12');
INSERT INTO `personal_access_tokens` VALUES (80, 'App\\Models\\User', 11, 'auth_token', 'ef09a71ab940d778cea4061aa24cd48a27431af6bee6c9eea9dcac5e0f2155aa', '[\"*\"]', '2022-06-06 13:48:26', '2022-06-06 13:47:50', '2022-06-06 13:48:26');
INSERT INTO `personal_access_tokens` VALUES (81, 'App\\Models\\User', 12, 'auth_token', '16c23bd432e18aa45b343929327b32e79b4528e680a2a9492e48de16429e8c52', '[\"*\"]', '2022-06-07 11:41:24', '2022-06-06 14:22:58', '2022-06-07 11:41:24');
INSERT INTO `personal_access_tokens` VALUES (85, 'App\\Models\\User', 3, 'auth_token', '8d7c2add41bb065a1fa098aa5537dfa160e98bfe9494d9fd942c4e1931957409', '[\"*\"]', '2022-06-10 08:54:31', '2022-06-10 08:47:25', '2022-06-10 08:54:31');
INSERT INTO `personal_access_tokens` VALUES (88, 'App\\Models\\User', 3, 'auth_token', '4fa78fcacabdbacbb4f8c5e46a0ce8fe88c783df960d23fd8217f9c17e10483d', '[\"*\"]', NULL, '2022-06-11 20:51:12', '2022-06-11 20:51:12');
INSERT INTO `personal_access_tokens` VALUES (89, 'App\\Models\\User', 3, 'auth_token', '910d794fb5f3a268c5b2a64bdd2f9df7e69e29790474f77e440436bbcf79f6f5', '[\"*\"]', '2022-06-11 22:04:01', '2022-06-11 21:49:00', '2022-06-11 22:04:01');
INSERT INTO `personal_access_tokens` VALUES (91, 'App\\Models\\User', 3, 'auth_token', '81f8d3d6f823ae15d36d476043d48836d8d3ed0da8a56a3539cb273295e71dc6', '[\"*\"]', '2022-06-12 12:25:15', '2022-06-12 12:24:58', '2022-06-12 12:25:15');
INSERT INTO `personal_access_tokens` VALUES (93, 'App\\Models\\User', 2, 'auth_token', '693687d88064d1fd09933c566ead690b7cfcf52dbfb924b05590d4a735390a79', '[\"*\"]', '2022-06-12 13:15:22', '2022-06-12 13:15:08', '2022-06-12 13:15:22');
INSERT INTO `personal_access_tokens` VALUES (96, 'App\\Models\\User', 2, 'auth_token', 'f3955b6a953bbf0a5f7faea396b86bf1062df48e10ca9cfceffc14d6ac2d62f2', '[\"*\"]', '2022-06-23 09:22:04', '2022-06-13 07:55:07', '2022-06-23 09:22:04');
INSERT INTO `personal_access_tokens` VALUES (97, 'App\\Models\\User', 13, 'auth_token', 'efdb010b356b8aaedc6ae527a0a14850df2d130c0eefbc92cc1aa3cb37bb0fc4', '[\"*\"]', '2022-06-13 09:53:48', '2022-06-13 09:48:40', '2022-06-13 09:53:48');
INSERT INTO `personal_access_tokens` VALUES (132, 'App\\Models\\User', 35, 'auth_token', '165a07b1b211ff476ccb309b185ba40ba8eb21f22c59ed94eb6436b6a3d35b40', '[\"*\"]', NULL, '2022-06-16 12:02:15', '2022-06-16 12:02:15');
INSERT INTO `personal_access_tokens` VALUES (136, 'App\\Models\\User', 35, 'auth_token', '968c7d489d6bd3a5c0d9f728329f46fb8db5e293460cc5bc96a279d5aed49b00', '[\"*\"]', NULL, '2022-06-16 13:53:25', '2022-06-16 13:53:25');
INSERT INTO `personal_access_tokens` VALUES (137, 'App\\Models\\User', 35, 'auth_token', '4c7d830bb0181c23f00eff6344b9f65970d71bef704292a959dffbda6f0015b4', '[\"*\"]', NULL, '2022-06-16 14:58:27', '2022-06-16 14:58:27');
INSERT INTO `personal_access_tokens` VALUES (138, 'App\\Models\\User', 37, 'auth_token', '4e0b3c51e83e742d361ecb4b08e54e510dd4b074d4e7c1457bd9b987425cd727', '[\"*\"]', '2022-06-17 18:02:51', '2022-06-16 15:47:59', '2022-06-17 18:02:51');
INSERT INTO `personal_access_tokens` VALUES (139, 'App\\Models\\User', 38, 'auth_token', 'fe5c2f585ced17f49633db25e2089befc06555cb0e1c57900822bc475f53b9b6', '[\"*\"]', '2022-07-13 16:28:20', '2022-06-16 16:31:09', '2022-07-13 16:28:20');
INSERT INTO `personal_access_tokens` VALUES (143, 'App\\Models\\User', 39, 'auth_token', 'f13cef745e6d90971bc685ae9e6b1c1c38af7a5d1b04b6fbc1d4d2948b331cbe', '[\"*\"]', '2022-06-19 08:05:47', '2022-06-19 08:03:42', '2022-06-19 08:05:47');
INSERT INTO `personal_access_tokens` VALUES (158, 'App\\Models\\User', 35, 'auth_token', '6f1bfde7cfbdef80c5b5ca947df0235e9342a8b8e24e14dab1d05915daaeb584', '[\"*\"]', '2022-06-29 13:02:42', '2022-06-29 13:01:38', '2022-06-29 13:02:42');
INSERT INTO `personal_access_tokens` VALUES (160, 'App\\Models\\User', 42, 'auth_token', '015e0ead0ec42b2cc3284199d14f4273d5f2e40d63754a7e389bbefde95d643b', '[\"*\"]', '2022-07-01 12:53:17', '2022-06-30 12:25:47', '2022-07-01 12:53:17');
INSERT INTO `personal_access_tokens` VALUES (162, 'App\\Models\\User', 35, 'auth_token', 'a2cc91ac4385c20a531aea1ef85ddfdb7456d6dd30b98bbaf535f442847358ef', '[\"*\"]', '2022-07-01 09:12:04', '2022-07-01 09:07:13', '2022-07-01 09:12:04');
INSERT INTO `personal_access_tokens` VALUES (166, 'App\\Models\\User', 46, 'auth_token', '747a04d941d16d72d7590ea10a0d5226e92e6295748bd473c871e7bb5bb642f5', '[\"*\"]', '2022-07-01 14:00:28', '2022-07-01 13:40:48', '2022-07-01 14:00:28');
INSERT INTO `personal_access_tokens` VALUES (171, 'App\\Models\\User', 11, 'auth_token', '8c41311dff6b58329c410ddca97f0cacf5aa653fc502a8a8149e4c5401625db3', '[\"*\"]', '2022-07-02 17:39:53', '2022-07-01 21:01:51', '2022-07-02 17:39:53');
INSERT INTO `personal_access_tokens` VALUES (172, 'App\\Models\\User', 11, 'auth_token', 'd2dfcedc5dd9a75abd7ab24a661541bd231178b38d507ed60c38dfc4acb05cd1', '[\"*\"]', '2022-07-02 18:48:57', '2022-07-02 17:40:05', '2022-07-02 18:48:57');
INSERT INTO `personal_access_tokens` VALUES (188, 'App\\Models\\User', 11, 'auth_token', '1563c540d7881fae7139ac6f2d41edce75c04262b7b1bf420c9cd4f0ac8b44ff', '[\"*\"]', '2022-07-07 15:58:36', '2022-07-07 15:56:07', '2022-07-07 15:58:36');
INSERT INTO `personal_access_tokens` VALUES (189, 'App\\Models\\User', 11, 'auth_token', 'a4c33d260bda577ac8067309554d66aff4c744834889f871928b28a27bc09902', '[\"*\"]', NULL, '2022-07-07 16:50:03', '2022-07-07 16:50:03');
INSERT INTO `personal_access_tokens` VALUES (191, 'App\\Models\\User', 13, 'auth_token', '65cbdb8f14f4820ddf6452ebee092c34d62e88e51cecaab9254253e59a119510', '[\"*\"]', '2022-07-07 17:54:54', '2022-07-07 17:04:00', '2022-07-07 17:54:54');
INSERT INTO `personal_access_tokens` VALUES (195, 'App\\Models\\User', 52, 'auth_token', '0fd3ed1bfa2bd94d64304f82310e1fc1923941aa3e7f43ce33980078f930beb9', '[\"*\"]', NULL, '2022-07-07 20:22:23', '2022-07-07 20:22:23');
INSERT INTO `personal_access_tokens` VALUES (196, 'App\\Models\\User', 11, 'auth_token', '5f8f222599c142184478041cfb0939909acaf5304c403b4a1944d48439caeb0e', '[\"*\"]', NULL, '2022-07-07 20:43:15', '2022-07-07 20:43:15');
INSERT INTO `personal_access_tokens` VALUES (203, 'App\\Models\\User', 37, 'auth_token', 'd8e700e4250c454dc8b422bfae72a7e6db1d4ec8aa4f5c7e116d18335e18ddb9', '[\"*\"]', '2022-07-13 11:44:37', '2022-07-08 15:20:47', '2022-07-13 11:44:37');
INSERT INTO `personal_access_tokens` VALUES (205, 'App\\Models\\User', 12, 'auth_token', 'f3268ada03b65d54c3d7df5d4e037dec80599afcb2a1a61d6f9e7efb3fee75d8', '[\"*\"]', '2022-07-11 08:24:59', '2022-07-11 08:16:33', '2022-07-11 08:24:59');
INSERT INTO `personal_access_tokens` VALUES (219, 'App\\Models\\User', 13, 'auth_token', 'b9799deeccf2208d1355bc18f04cd4e537d5947a696dd22a69b8f65998a4baef', '[\"*\"]', '2022-07-18 13:49:38', '2022-07-12 22:06:46', '2022-07-18 13:49:38');
INSERT INTO `personal_access_tokens` VALUES (220, 'App\\Models\\User', 37, 'auth_token', 'cfac6642cde187b264f2e64817b27118b863425b4641318e4574d5c34751ba1d', '[\"*\"]', '2022-07-13 11:47:23', '2022-07-13 11:46:05', '2022-07-13 11:47:23');
INSERT INTO `personal_access_tokens` VALUES (221, 'App\\Models\\User', 11, 'auth_token', '542075b9e9e9f11598e117791c6e5f8e08669aebc23cf2e2f08bd2cfc07e95e6', '[\"*\"]', '2022-07-20 06:24:15', '2022-07-13 14:02:24', '2022-07-20 06:24:15');
INSERT INTO `personal_access_tokens` VALUES (227, 'App\\Models\\User', 11, 'auth_token', 'a1f2ebe557123e2af03c1abcf33e597064d076a3124cf9876e6a39d99179d5d9', '[\"*\"]', '2022-07-19 08:01:47', '2022-07-13 17:49:12', '2022-07-19 08:01:47');
INSERT INTO `personal_access_tokens` VALUES (228, 'App\\Models\\User', 37, 'auth_token', '87f34e4f456cd5dbfeb0db0eb621a2b806955205a390cf76a7da3683a06cbc73', '[\"*\"]', '2022-07-19 10:51:49', '2022-07-14 09:49:12', '2022-07-19 10:51:49');
INSERT INTO `personal_access_tokens` VALUES (229, 'App\\Models\\User', 69, 'auth_token', 'a7a8d38b4372f9450382c558c94b8cdc630a15dba55d5a235eba53a936dbf1e5', '[\"*\"]', NULL, '2022-07-20 12:09:41', '2022-07-20 12:09:41');
INSERT INTO `personal_access_tokens` VALUES (230, 'App\\Models\\User', 70, 'auth_token', '850d8ebb6e8bb1bf8d7e489118ca4d98e0429b8c2007e77345843bfbc4dee055', '[\"*\"]', NULL, '2022-07-20 12:12:10', '2022-07-20 12:12:10');
INSERT INTO `personal_access_tokens` VALUES (231, 'App\\Models\\User', 71, 'auth_token', '5d88a63c7e60eec951cce036c34e11c06d9602cfb9a80bfa9898b91a5b3d17a8', '[\"*\"]', '2022-07-20 12:19:28', '2022-07-20 12:16:53', '2022-07-20 12:19:28');
INSERT INTO `personal_access_tokens` VALUES (232, 'App\\Models\\User', 71, 'auth_token', 'dbd578d03bc61a36e0deff341b4f354d8b9e7f47dbba5d0199e1676e507cef7d', '[\"*\"]', '2022-08-08 09:17:30', '2022-08-08 09:05:21', '2022-08-08 09:17:30');
INSERT INTO `personal_access_tokens` VALUES (233, 'App\\Models\\User', 71, 'auth_token', '4ff2c169e4a09c247ad93b174be9c5236b08247fd9743e7248aa02ff72463fed', '[\"*\"]', '2022-09-12 12:37:08', '2022-09-12 11:32:44', '2022-09-12 12:37:08');
INSERT INTO `personal_access_tokens` VALUES (234, 'App\\Models\\User', 71, 'auth_token', '06a17f48bb9b3cbbcccf196321606941d49e359b276d2e1575decea5f2dbc6ad', '[\"*\"]', '2022-09-12 12:38:04', '2022-09-12 12:37:45', '2022-09-12 12:38:04');

-- ----------------------------
-- Table structure for services
-- ----------------------------
DROP TABLE IF EXISTS `services`;
CREATE TABLE `services`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `category_id` int NOT NULL DEFAULT 0,
  `price` int NULL DEFAULT NULL,
  `gallery_id` int NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 132 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of services
-- ----------------------------
INSERT INTO `services` VALUES (1, 11, 2, 0, NULL, '2022-06-14 12:52:50');
INSERT INTO `services` VALUES (2, 11, 11, 100, NULL, '2022-06-14 13:03:24');
INSERT INTO `services` VALUES (3, 2, 2, 1233, NULL, '2022-06-13 13:55:35');
INSERT INTO `services` VALUES (4, 13, 2, 100, NULL, '2022-06-13 19:15:26');
INSERT INTO `services` VALUES (5, 11, 18, 202, NULL, '2022-06-14 13:10:15');
INSERT INTO `services` VALUES (6, 11, 40, 22, NULL, '2022-06-14 13:16:30');
INSERT INTO `services` VALUES (7, 3, 2, 23, NULL, NULL);
INSERT INTO `services` VALUES (8, 13, 21, 25, NULL, '2022-06-15 07:37:49');
INSERT INTO `services` VALUES (9, 2, 2, 36, NULL, '2022-06-14 17:02:43');
INSERT INTO `services` VALUES (10, 13, 11, 0, NULL, '2022-06-15 07:37:43');
INSERT INTO `services` VALUES (11, 13, 25, 11, NULL, '2022-06-15 07:37:36');
INSERT INTO `services` VALUES (12, 2, 7, 123, NULL, '2022-06-14 17:13:17');
INSERT INTO `services` VALUES (13, 2, 9, 33, NULL, '2022-06-14 17:13:20');
INSERT INTO `services` VALUES (14, 11, 2, 15, NULL, '2022-06-14 13:42:27');
INSERT INTO `services` VALUES (15, 11, 7, 111, NULL, '2022-06-14 13:22:37');
INSERT INTO `services` VALUES (16, 11, 2, 35, NULL, '2022-06-15 13:10:13');
INSERT INTO `services` VALUES (17, 2, 37, 3636, NULL, '2022-06-14 17:13:23');
INSERT INTO `services` VALUES (18, 2, 8, 0, NULL, '2022-06-14 17:13:25');
INSERT INTO `services` VALUES (19, 2, 4, 0, NULL, '2022-06-14 17:13:28');
INSERT INTO `services` VALUES (20, 2, 2, 1, NULL, '2022-06-14 17:14:17');
INSERT INTO `services` VALUES (21, 2, 2, 1, NULL, '2022-06-14 17:28:31');
INSERT INTO `services` VALUES (22, 2, 37, 123, NULL, '2022-06-14 17:28:29');
INSERT INTO `services` VALUES (23, 13, 2, 0, NULL, '2022-06-15 07:37:30');
INSERT INTO `services` VALUES (24, 11, 35, 3000000, NULL, '2022-06-15 13:10:17');
INSERT INTO `services` VALUES (25, 13, 1, 12, NULL, '2022-06-16 12:37:58');
INSERT INTO `services` VALUES (26, 16, 2, 0, NULL, '2022-06-15 13:42:10');
INSERT INTO `services` VALUES (27, 16, 2, 12, NULL, '2022-06-15 14:43:45');
INSERT INTO `services` VALUES (28, 16, 11, 0, NULL, '2022-06-15 14:57:21');
INSERT INTO `services` VALUES (29, 16, 18, 0, NULL, '2022-06-15 14:57:29');
INSERT INTO `services` VALUES (30, 16, 14, 0, NULL, '2022-06-15 14:44:25');
INSERT INTO `services` VALUES (31, 16, 2, 0, NULL, '2022-06-15 14:44:21');
INSERT INTO `services` VALUES (32, 16, 2, 0, NULL, '2022-06-15 14:44:18');
INSERT INTO `services` VALUES (33, 16, 2, 0, NULL, '2022-06-15 14:44:14');
INSERT INTO `services` VALUES (34, 16, 2, 0, NULL, '2022-06-15 15:15:13');
INSERT INTO `services` VALUES (35, 16, 7, 0, NULL, '2022-06-15 15:15:11');
INSERT INTO `services` VALUES (36, 16, 14, 0, NULL, '2022-06-15 15:15:08');
INSERT INTO `services` VALUES (37, 16, 18, 0, NULL, '2022-06-15 15:15:05');
INSERT INTO `services` VALUES (38, 16, 36, 0, NULL, '2022-06-15 15:15:00');
INSERT INTO `services` VALUES (39, 16, 2, 0, NULL, '2022-06-15 15:15:50');
INSERT INTO `services` VALUES (40, 16, 2, 0, NULL, '2022-06-15 15:59:58');
INSERT INTO `services` VALUES (41, 11, 8, 45, NULL, '2022-06-15 16:54:09');
INSERT INTO `services` VALUES (42, 11, 2, 0, NULL, '2022-06-15 20:09:07');
INSERT INTO `services` VALUES (43, 11, 22, 0, NULL, '2022-06-15 20:08:58');
INSERT INTO `services` VALUES (44, 11, 19, 0, NULL, '2022-06-15 20:08:46');
INSERT INTO `services` VALUES (45, 11, 25, 0, NULL, '2022-06-15 20:08:37');
INSERT INTO `services` VALUES (46, 16, 2, 0, NULL, '2022-06-15 22:41:16');
INSERT INTO `services` VALUES (47, 11, 37, 122, NULL, '2022-06-15 20:08:25');
INSERT INTO `services` VALUES (48, 13, 22, 15, NULL, '2022-06-16 12:38:00');
INSERT INTO `services` VALUES (49, 13, 30, 100, NULL, '2022-06-16 12:38:03');
INSERT INTO `services` VALUES (50, 16, 2, 0, NULL, '2022-06-15 22:43:08');
INSERT INTO `services` VALUES (51, 16, 2, 0, NULL, NULL);
INSERT INTO `services` VALUES (52, 34, 2, 11, NULL, '2022-06-16 11:04:51');
INSERT INTO `services` VALUES (53, 2, 8, 36, NULL, '2022-06-16 13:54:44');
INSERT INTO `services` VALUES (54, 13, 2, 100, NULL, '2022-06-22 09:46:29');
INSERT INTO `services` VALUES (55, 36, 2, 11, NULL, '2022-06-16 14:14:18');
INSERT INTO `services` VALUES (56, 2, 12, 363609, NULL, '2022-06-16 14:13:24');
INSERT INTO `services` VALUES (57, 2, 11, 1000, NULL, '2022-06-16 13:12:13');
INSERT INTO `services` VALUES (58, 2, 11, 5, NULL, NULL);
INSERT INTO `services` VALUES (59, 36, 13, 0, NULL, '2022-06-16 14:50:30');
INSERT INTO `services` VALUES (60, 2, 4, 3636, NULL, '2022-06-16 14:13:27');
INSERT INTO `services` VALUES (61, 36, 18, 0, NULL, NULL);
INSERT INTO `services` VALUES (62, 36, 2, 0, NULL, '2022-06-16 14:16:45');
INSERT INTO `services` VALUES (63, 36, 2, 0, NULL, NULL);
INSERT INTO `services` VALUES (64, 36, 21, 0, NULL, NULL);
INSERT INTO `services` VALUES (65, 37, 2, 0, NULL, NULL);
INSERT INTO `services` VALUES (66, 37, 7, 9999, NULL, NULL);
INSERT INTO `services` VALUES (67, 11, 35, 0, NULL, '2022-06-18 14:22:12');
INSERT INTO `services` VALUES (68, 11, 36, 0, NULL, '2022-06-22 15:21:31');
INSERT INTO `services` VALUES (69, 38, 42, 25, NULL, NULL);
INSERT INTO `services` VALUES (70, 11, 2, 100, NULL, '2022-06-23 07:54:30');
INSERT INTO `services` VALUES (71, 40, 2, 11, NULL, NULL);
INSERT INTO `services` VALUES (72, 41, 2, 22, NULL, NULL);
INSERT INTO `services` VALUES (73, 13, 11, 0, NULL, '2022-06-22 09:44:36');
INSERT INTO `services` VALUES (74, 13, 35, 0, NULL, '2022-06-22 09:43:56');
INSERT INTO `services` VALUES (75, 13, 4, 0, NULL, '2022-06-22 09:47:10');
INSERT INTO `services` VALUES (76, 13, 48, 0, NULL, '2022-06-22 09:42:58');
INSERT INTO `services` VALUES (77, 13, 2, 0, NULL, '2022-06-22 09:47:55');
INSERT INTO `services` VALUES (78, 13, 48, 0, NULL, '2022-06-22 09:49:56');
INSERT INTO `services` VALUES (79, 13, 2, 0, NULL, '2022-06-29 10:50:19');
INSERT INTO `services` VALUES (80, 13, 48, 11, NULL, '2022-06-22 11:22:42');
INSERT INTO `services` VALUES (81, 13, 7, 0, NULL, '2022-06-29 10:51:20');
INSERT INTO `services` VALUES (82, 13, 4, 0, NULL, NULL);
INSERT INTO `services` VALUES (83, 13, 35, 0, NULL, '2022-06-22 12:42:01');
INSERT INTO `services` VALUES (84, 2, 2, 665, NULL, NULL);
INSERT INTO `services` VALUES (85, 11, 2, 2223, NULL, '2022-06-23 08:49:51');
INSERT INTO `services` VALUES (86, 11, 35, 450, NULL, '2022-06-23 08:21:23');
INSERT INTO `services` VALUES (87, 11, 2, 69, NULL, '2022-06-24 16:01:00');
INSERT INTO `services` VALUES (88, 11, 48, 0, NULL, '2022-06-24 16:13:56');
INSERT INTO `services` VALUES (89, 11, 2, 420, NULL, '2022-06-24 16:24:32');
INSERT INTO `services` VALUES (90, 11, 3, 111, NULL, '2022-06-24 16:24:27');
INSERT INTO `services` VALUES (91, 11, 2, 420, NULL, '2022-06-29 14:30:29');
INSERT INTO `services` VALUES (92, 13, 5, 0, NULL, NULL);
INSERT INTO `services` VALUES (93, 13, 35, 0, NULL, NULL);
INSERT INTO `services` VALUES (94, 13, 36, 0, NULL, NULL);
INSERT INTO `services` VALUES (95, 13, 40, 1000000, NULL, NULL);
INSERT INTO `services` VALUES (96, 11, 5, 0, NULL, '2022-06-29 14:30:37');
INSERT INTO `services` VALUES (97, 11, 14, 0, NULL, '2022-06-29 22:14:35');
INSERT INTO `services` VALUES (98, 43, 7, 20, NULL, NULL);
INSERT INTO `services` VALUES (99, 43, 16, 2000, NULL, NULL);
INSERT INTO `services` VALUES (100, 43, 12, 500, NULL, NULL);
INSERT INTO `services` VALUES (101, 43, 14, 50, NULL, NULL);
INSERT INTO `services` VALUES (102, 43, 8, 0, NULL, NULL);
INSERT INTO `services` VALUES (103, 43, 19, 29658, NULL, NULL);
INSERT INTO `services` VALUES (104, 11, 3, 22, NULL, NULL);
INSERT INTO `services` VALUES (105, 11, 7, 33, NULL, NULL);
INSERT INTO `services` VALUES (106, 43, 11, 500, NULL, NULL);
INSERT INTO `services` VALUES (107, 43, 18, 5000, NULL, NULL);
INSERT INTO `services` VALUES (108, 43, 35, 858055, NULL, NULL);
INSERT INTO `services` VALUES (109, 46, 35, 65524578, NULL, NULL);
INSERT INTO `services` VALUES (110, 46, 2, 0, NULL, NULL);
INSERT INTO `services` VALUES (111, 46, 5, 0, NULL, NULL);
INSERT INTO `services` VALUES (112, 46, 11, 8860906, NULL, NULL);
INSERT INTO `services` VALUES (113, 46, 18, 28, NULL, NULL);
INSERT INTO `services` VALUES (114, 11, 4, 0, NULL, NULL);
INSERT INTO `services` VALUES (115, 11, 16, 0, NULL, NULL);
INSERT INTO `services` VALUES (116, 11, 12, 0, NULL, NULL);
INSERT INTO `services` VALUES (117, 11, 5, 69, NULL, '2022-07-08 07:27:48');
INSERT INTO `services` VALUES (118, 37, 9, 50, NULL, NULL);
INSERT INTO `services` VALUES (119, 37, 21, 99, NULL, NULL);
INSERT INTO `services` VALUES (120, 61, 41, 0, NULL, NULL);
INSERT INTO `services` VALUES (121, 63, 39, 0, NULL, NULL);
INSERT INTO `services` VALUES (122, 63, 30, 0, NULL, NULL);
INSERT INTO `services` VALUES (123, 63, 16, 0, NULL, NULL);
INSERT INTO `services` VALUES (124, 63, 53, 0, NULL, NULL);
INSERT INTO `services` VALUES (125, 64, 7, 0, NULL, NULL);
INSERT INTO `services` VALUES (126, 65, 41, 11, NULL, NULL);
INSERT INTO `services` VALUES (127, 65, 15, 88, NULL, NULL);
INSERT INTO `services` VALUES (128, 65, 7, 0, NULL, NULL);
INSERT INTO `services` VALUES (129, 11, 42, 0, NULL, '2022-07-13 17:06:59');
INSERT INTO `services` VALUES (130, 71, 14, 450, NULL, '2022-09-12 12:20:52');
INSERT INTO `services` VALUES (131, 71, 14, 5, NULL, NULL);

-- ----------------------------
-- Table structure for settings
-- ----------------------------
DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `key` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `value` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of settings
-- ----------------------------
INSERT INTO `settings` VALUES (1, 'sync_time', '2022-07-14 10:03:55');

-- ----------------------------
-- Table structure for timezones
-- ----------------------------
DROP TABLE IF EXISTS `timezones`;
CREATE TABLE `timezones`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `value` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 41 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of timezones
-- ----------------------------
INSERT INTO `timezones` VALUES (1, '-12:00', '(GMT -12:00) Eniwetok, Kwajalein');
INSERT INTO `timezones` VALUES (2, '-11:00', '(GMT -11:00) Midway Island, Samoa');
INSERT INTO `timezones` VALUES (3, '-10:00', '(GMT -10:00) Hawaii');
INSERT INTO `timezones` VALUES (4, '-09:50', '(GMT -9:30) Taiohae');
INSERT INTO `timezones` VALUES (5, '-09:00', '(GMT -9:00) Alaska');
INSERT INTO `timezones` VALUES (6, '-08:00', '(GMT -8:00) Pacific Time (US &amp; Canada)');
INSERT INTO `timezones` VALUES (7, '-07:00', '(GMT -7:00) Mountain Time (US &amp; Canada)');
INSERT INTO `timezones` VALUES (8, '-06:00', '(GMT -6:00) Central Time (US &amp; Canada), Mexico City');
INSERT INTO `timezones` VALUES (9, '-05:00', '(GMT -5:00) Eastern Time (US &amp; Canada), Bogota, Lima');
INSERT INTO `timezones` VALUES (10, '-04:50', '(GMT -4:30) Caracas');
INSERT INTO `timezones` VALUES (11, '-04:00', '(GMT -4:00) Atlantic Time (Canada), Caracas, La Paz');
INSERT INTO `timezones` VALUES (12, '-03:50', '(GMT -3:30) Newfoundland');
INSERT INTO `timezones` VALUES (13, '-03:00', '(GMT -3:00) Brazil, Buenos Aires, Georgetown');
INSERT INTO `timezones` VALUES (14, '-02:00', '(GMT -2:00) Mid-Atlantic');
INSERT INTO `timezones` VALUES (15, '-01:00', '(GMT -1:00) Azores, Cape Verde Islands');
INSERT INTO `timezones` VALUES (16, '+00:00', '(GMT) Western Europe Time, London, Lisbon, Casablanca');
INSERT INTO `timezones` VALUES (17, '+01:00', '(GMT +1:00) Brussels, Copenhagen, Madrid, Paris');
INSERT INTO `timezones` VALUES (18, '+02:00', '(GMT +2:00) Kaliningrad, South Africa');
INSERT INTO `timezones` VALUES (19, '+03:00', '(GMT +3:00) Baghdad, Riyadh, Moscow, St. Petersburg');
INSERT INTO `timezones` VALUES (20, '+03:50', '(GMT +3:30) Tehran');
INSERT INTO `timezones` VALUES (21, '+04:00', '(GMT +4:00) Abu Dhabi, Muscat, Baku, Tbilisi');
INSERT INTO `timezones` VALUES (22, '+04:50', '(GMT +4:30) Kabul');
INSERT INTO `timezones` VALUES (23, '+05:00', '(GMT +5:00) Ekaterinburg, Islamabad, Karachi, Tashkent');
INSERT INTO `timezones` VALUES (24, '+05:50', '(GMT +5:30) Bombay, Calcutta, Madras, New Delhi');
INSERT INTO `timezones` VALUES (25, '+05:75', '(GMT +5:45) Kathmandu, Pokhar');
INSERT INTO `timezones` VALUES (26, '+06:00', '(GMT +6:00) Almaty, Dhaka, Colombo');
INSERT INTO `timezones` VALUES (27, '+06:50', '(GMT +6:30) Yangon, Mandalay');
INSERT INTO `timezones` VALUES (28, '+07:00', '(GMT +7:00) Bangkok, Hanoi, Jakarta');
INSERT INTO `timezones` VALUES (29, '+08:00', '(GMT +8:00) Beijing, Perth, Singapore, Hong Kong');
INSERT INTO `timezones` VALUES (30, '+08:75', '(GMT +8:45) Eucla');
INSERT INTO `timezones` VALUES (31, '+09:00', '(GMT +9:00) Tokyo, Seoul, Osaka, Sapporo, Yakutsk');
INSERT INTO `timezones` VALUES (32, '+09:50', '(GMT +9:30) Adelaide, Darwin');
INSERT INTO `timezones` VALUES (33, '+10:00', '(GMT +10:00) Eastern Australia, Guam, Vladivostok');
INSERT INTO `timezones` VALUES (34, '+10:50', '(GMT +10:30) Lord Howe Island');
INSERT INTO `timezones` VALUES (35, '+11:00', '(GMT +11:00) Magadan, Solomon Islands, New Caledonia');
INSERT INTO `timezones` VALUES (36, '+11:50', '(GMT +11:30) Norfolk Island');
INSERT INTO `timezones` VALUES (37, '+12:00', '(GMT +12:00) Auckland, Wellington, Fiji, Kamchatka');
INSERT INTO `timezones` VALUES (38, '+12:75', '(GMT +12:45) Chatham Islands');
INSERT INTO `timezones` VALUES (39, '+13:00', '(GMT +13:00) Apia, Nukualofa');
INSERT INTO `timezones` VALUES (40, '+14:00', '(GMT +14:00) Line Islands, Tokelau');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `status` enum('active','disabled') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT 'active',
  `is_customer` tinyint(1) NULL DEFAULT 0,
  `is_employee` tinyint(1) NULL DEFAULT 0,
  `active_type` enum('customer','employee') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT 'customer',
  `fullname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `about` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '',
  `language` enum('en','ru','am') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT 'en',
  `rating` float(2, 1) NULL DEFAULT 0,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `lat` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `lon` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `expo_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `verify` enum('base','pending','approved','declined') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'base',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 72 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------

-- ----------------------------
-- Table structure for verification
-- ----------------------------
DROP TABLE IF EXISTS `verification`;
CREATE TABLE `verification`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NULL DEFAULT NULL,
  `status` enum('base','pending','approved','declined') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'base',
  `message` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `document` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `selfie` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of verification
-- ----------------------------
INSERT INTO `verification` VALUES (1, 11, 'pending', 'asd', '2022-07-07 21:23:09', '576e3cea5a94.png', 'c875f8e37d5c.jpeg');
INSERT INTO `verification` VALUES (2, 47, 'declined', 'asdasdasd', NULL, 'a2c14f73d043.png', 'e39674a7b09a.jpeg');
INSERT INTO `verification` VALUES (3, 13, 'declined', NULL, '2022-07-05 16:58:07', '7e0fa4c5821d.png', '588ada4c6681.jpeg');
INSERT INTO `verification` VALUES (4, 37, 'approved', 'selfie issue', '2022-07-08 15:35:35', 'f3ee9bbbb78b.jpeg', 'f190d8d7a880.jpeg');

SET FOREIGN_KEY_CHECKS = 1;
