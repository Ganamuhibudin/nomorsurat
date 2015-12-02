/*
Navicat MySQL Data Transfer

Source Server         : LOCAL_DB
Source Server Version : 50616
Source Host           : localhost:3306
Source Database       : nosuratdb

Target Server Type    : MYSQL
Target Server Version : 50616
File Encoding         : 65001

Date: 2015-12-01 16:24:20
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `tbl_formats`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_formats`;
CREATE TABLE `tbl_formats` (
  `format_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tipe` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `keterangan` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`format_id`),
  UNIQUE KEY `formats_tipe_unique` (`tipe`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of tbl_formats
-- ----------------------------
INSERT INTO `tbl_formats` VALUES ('1', 'AUTO', 'Angka Autoincrement', '2015-11-26 16:59:51', '2015-11-26 16:59:51');
INSERT INTO `tbl_formats` VALUES ('2', 'FREETEXT', 'Teks Bebas', '2015-11-26 17:01:15', '2015-11-26 17:01:15');
INSERT INTO `tbl_formats` VALUES ('3', 'YEAR', 'Tahun Sekarang', '2015-11-26 17:02:32', '2015-11-26 17:02:32');

-- ----------------------------
-- Table structure for `tbl_logs`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_logs`;
CREATE TABLE `tbl_logs` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `surat_id` int(11) NOT NULL,
  `nomor_surat` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of tbl_logs
-- ----------------------------
INSERT INTO `tbl_logs` VALUES ('1', '1', '12', '0/QQQ/WWW/2015', '2015-11-30 15:04:27', '2015-11-30 15:04:27');
INSERT INTO `tbl_logs` VALUES ('2', '1', '9', '0/MEMO/DEV/2015', '2015-11-27 13:02:23', '2015-11-27 13:02:23');
INSERT INTO `tbl_logs` VALUES ('3', '1', '1', '0/NODIN/HRD/2015', '2015-11-27 12:37:34', '2015-11-27 12:37:34');
INSERT INTO `tbl_logs` VALUES ('4', '1', '12', '1/QQQ/WWW/2015', '2015-11-30 17:09:58', '2015-11-30 17:09:58');
INSERT INTO `tbl_logs` VALUES ('5', '1', '12', '2/QQQ/WWW/2015', '2015-11-30 17:10:03', '2015-11-30 17:10:03');
INSERT INTO `tbl_logs` VALUES ('6', '1', '12', '2015/QQQ/WWW/0', '2015-11-30 17:24:44', '2015-11-30 17:24:44');
INSERT INTO `tbl_logs` VALUES ('8', '1', '12', '2015/QQQ/WWW/1', '2015-11-30 17:28:05', '2015-11-30 17:28:05');
INSERT INTO `tbl_logs` VALUES ('9', '1', '12', '2015/QQQ/WWW/2', '2015-11-30 17:28:09', '2015-11-30 17:28:09');
INSERT INTO `tbl_logs` VALUES ('10', '1', '12', '2015/QQQ/WWW/3', '2015-11-30 17:28:37', '2015-11-30 17:28:37');

-- ----------------------------
-- Table structure for `tbl_migrations`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_migrations`;
CREATE TABLE `tbl_migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of tbl_migrations
-- ----------------------------
INSERT INTO `tbl_migrations` VALUES ('2015_11_19_175323_CreateTableUser', '1');
INSERT INTO `tbl_migrations` VALUES ('2015_11_19_180245_AlterTableUserAddRoleid', '2');
INSERT INTO `tbl_migrations` VALUES ('2015_11_19_190353_CreatTableRoles', '3');
INSERT INTO `tbl_migrations` VALUES ('2015_11_23_034929_CreateTableSurat', '4');
INSERT INTO `tbl_migrations` VALUES ('2015_11_26_164858_CreateTableFormat', '5');
INSERT INTO `tbl_migrations` VALUES ('2015_11_30_105637_CreateTableLog', '6');

-- ----------------------------
-- Table structure for `tbl_roles`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_roles`;
CREATE TABLE `tbl_roles` (
  `role_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `keterangan` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of tbl_roles
-- ----------------------------
INSERT INTO `tbl_roles` VALUES ('1', 'Administrator', '2015-11-19 19:14:34', '2015-11-19 19:14:34');
INSERT INTO `tbl_roles` VALUES ('2', 'User', '2015-11-19 19:14:34', '2015-11-19 19:14:34');

-- ----------------------------
-- Table structure for `tbl_surat`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_surat`;
CREATE TABLE `tbl_surat` (
  `surat_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kode_surat` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `keterangan` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `jumlah_segmen` int(11) NOT NULL,
  `format` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`surat_id`),
  UNIQUE KEY `surat_kode_surat_unique` (`kode_surat`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of tbl_surat
-- ----------------------------
INSERT INTO `tbl_surat` VALUES ('1', 'NDN', 'Surat Nodin', '4', 'AUTO/NODIN/HRD/YEAR', '2015-11-27 12:37:34', '2015-11-30 12:32:23');
INSERT INTO `tbl_surat` VALUES ('9', 'MEMO', 'Surat Memo', '4', 'AUTO/MEMO/DEV/YEAR', '2015-11-27 13:02:23', '2015-11-27 13:02:23');
INSERT INTO `tbl_surat` VALUES ('12', 'XXX', 'XXXX', '4', 'YEAR/QQQ/WWW/AUTO', '2015-11-30 15:04:27', '2015-11-30 17:24:44');

-- ----------------------------
-- Table structure for `tbl_users`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_users`;
CREATE TABLE `tbl_users` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `email` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of tbl_users
-- ----------------------------
INSERT INTO `tbl_users` VALUES ('1', '1', 'admin@rpl.com', '$2y$10$k7RbOcLesAh8Hs2aGyfZjOGjn760l82HBxuz7fwtyhTTs7TN2aJsG', 'Fulan', '2015-11-19 18:38:10', '2015-11-27 10:10:50', '7ZrGLGq4BCvAjGcAbkJjUFnf5eHGWE00FyqD7bmQS9TDs5SSq65a9IXolWcy');
INSERT INTO `tbl_users` VALUES ('2', '2', 'user@rpl.com', '$2y$10$p3XLyZ.4kjd3h0IfOv/xOe/vumJEBZU/FXf7HIVc0U2wRz3RhN6CS', 'Nuraini', '2015-11-20 15:38:51', '2015-11-20 15:38:51', null);
INSERT INTO `tbl_users` VALUES ('3', '2', 'gana@rpl.com', '$2y$10$PcoW2qQ1dO4Kvj5LYhr/cec1WskrZ4kvNAU7powHehYpzgOJwhvya', 'Gana', '2015-11-20 17:17:30', '2015-11-20 17:17:30', null);
