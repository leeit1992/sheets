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

 Date: 08/13/2017 23:52:50 PM
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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=172 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=latin1;

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

SET FOREIGN_KEY_CHECKS = 1;
