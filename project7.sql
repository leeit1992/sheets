/*
 Navicat Premium Data Transfer

 Source Server         : Mamp
 Source Server Type    : MySQL
 Source Server Version : 50542
 Source Host           : localhost
 Source Database       : project7

 Target Server Type    : MySQL
 Target Server Version : 50542
 File Encoding         : utf-8

 Date: 09/06/2017 08:40:33 AM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `op_logs`
-- ----------------------------
DROP TABLE IF EXISTS `op_logs`;
CREATE TABLE `op_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `logs` text,
  `log_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=547 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `op_messages`
-- ----------------------------
DROP TABLE IF EXISTS `op_messages`;
CREATE TABLE `op_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `op_messages` text COLLATE utf8_unicode_ci,
  `op_sheet_id` int(11) DEFAULT NULL,
  `op_user_send` int(11) DEFAULT NULL,
  `op_user_receiver` int(11) DEFAULT NULL,
  `op_datetime` datetime DEFAULT NULL,
  `op_status` tinyint(2) DEFAULT NULL,
  `op_message_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `op_type` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `op_data_sheet` longtext CHARACTER SET latin1,
  `op_data_sheet_meta` longtext CHARACTER SET latin1,
  `op_accept_status` tinyint(4) DEFAULT NULL,
  `op_user_start_send` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=450 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `op_sheetmeta`
-- ----------------------------
DROP TABLE IF EXISTS `op_sheetmeta`;
CREATE TABLE `op_sheetmeta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sheet_id` int(11) DEFAULT NULL,
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=150 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records of `op_sheetmeta`
-- ----------------------------
BEGIN;
INSERT INTO `op_sheetmeta` VALUES ('32', '70', 'sheet_meta', '[]'), ('33', '71', 'sheet_meta', '[]'), ('34', '72', 'sheet_meta', '[]'), ('35', '73', 'sheet_meta', '[]'), ('36', '74', 'sheet_meta', '[]'), ('37', '75', 'sheet_meta', '[]'), ('38', '76', 'sheet_meta', '[]'), ('39', '77', 'sheet_meta', '[]'), ('40', '78', 'sheet_meta', '[]'), ('41', '79', 'sheet_meta', '[]');
COMMIT;

-- ----------------------------
--  Table structure for `op_sheets`
-- ----------------------------
DROP TABLE IF EXISTS `op_sheets`;
CREATE TABLE `op_sheets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sheet_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sheet_content` longtext COLLATE utf8_unicode_ci,
  `sheet_description` text COLLATE utf8_unicode_ci,
  `sheet_author` int(11) DEFAULT NULL,
  `sheet_datetime` datetime DEFAULT NULL,
  `sheet_status` tinyint(2) DEFAULT NULL,
  `sheet_share` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=188 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `op_sheets`
-- ----------------------------
BEGIN;
INSERT INTO `op_sheets` VALUES ('70', 'admin-0', '[]', '', '2', '2017-08-31 15:31:04', '1', '[\"17\"]'), ('71', 'admin-1', '[]', null, '2', '2017-08-17 18:41:50', '1', null), ('72', 'admin-2', '[]', null, '2', '2017-08-09 15:28:46', '1', null), ('73', 'admin-3', '[]', null, '2', '2017-08-09 15:28:46', '1', null), ('74', 'admin-4', '[]', null, '2', '2017-08-09 15:28:46', '1', null), ('75', 'admin-5', '[]', null, '2', '2017-08-09 15:28:46', '1', null), ('76', 'admin-6', '[]', null, '2', '2017-08-09 15:28:46', '1', null), ('77', 'admin-7', '[]', null, '2', '2017-08-09 15:28:46', '1', null), ('78', 'admin-8', '[]', null, '2', '2017-08-09 15:28:46', '1', null), ('79', 'admin-9', '[]', null, '2', '2017-08-09 15:28:46', '1', null);
COMMIT;

-- ----------------------------
--  Table structure for `op_usermeta`
-- ----------------------------
DROP TABLE IF EXISTS `op_usermeta`;
CREATE TABLE `op_usermeta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=139 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records of `op_usermeta`
-- ----------------------------
BEGIN;
INSERT INTO `op_usermeta` VALUES ('8', '2', 'user_birthday', '26.07.2017'), ('9', '2', 'user_address', 'Ha noi'), ('10', '2', 'user_moreinfo', 'Admin'), ('11', '2', 'user_phone', '0977005547'), ('12', '2', 'user_social', '{\"fb\":\"https:\\/\\/www.facebook.com\\/\",\"twitter\":\"https:\\/\\/www.facebook.com\\/\",\"linkedin\":\"https:\\/\\/www.facebook.com\\/\",\"gplus\":\"https:\\/\\/www.facebook.com\\/\"}'), ('13', '2', 'user_role', '1'), ('14', '2', 'user_avatar', '/uploads/avatar_user/avatar-user-2.png');
COMMIT;

-- ----------------------------
--  Table structure for `op_users`
-- ----------------------------
DROP TABLE IF EXISTS `op_users`;
CREATE TABLE `op_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) DEFAULT NULL,
  `user_password` varchar(255) DEFAULT NULL,
  `user_email` varchar(255) DEFAULT NULL,
  `user_registered` datetime DEFAULT NULL,
  `user_status` tinyint(2) DEFAULT NULL,
  `user_display_name` varchar(255) DEFAULT NULL,
  `user_token` varchar(255) DEFAULT NULL,
  `user_code` varchar(50) DEFAULT NULL,
  `user_color` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records of `op_users`
-- ----------------------------
BEGIN;
INSERT INTO `op_users` VALUES ('2', 'Administrator', '21232f297a57a5a743894a0e4a801fc3', 'admin@gmail.com', '2017-07-23 21:03:41', '1', 'Administrator', null, null, null);
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
