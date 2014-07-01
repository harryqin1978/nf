/*
Navicat MySQL Data Transfer

Source Server         : 192.168.10.254 (virtual ubuntu 12.04)
Source Server Version : 50534
Source Host           : 192.168.10.254:3306
Source Database       : nf

Target Server Type    : MYSQL
Target Server Version : 50534
File Encoding         : 65001

Date: 2014-07-01 15:18:48
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `nf_order`
-- ----------------------------
DROP TABLE IF EXISTS `nf_order`;
CREATE TABLE `nf_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `price` decimal(10,2) NOT NULL,
  `receive_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_price` (`price`),
  KEY `idx_receive_name` (`receive_name`),
  KEY `IDX_86F6CA98A76ED395` (`user_id`),
  CONSTRAINT `FK_86F6CA98A76ED395` FOREIGN KEY (`user_id`) REFERENCES `nf_user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of nf_order
-- ----------------------------
INSERT INTO `nf_order` VALUES ('2', '19.99', 'Foo', '13');

-- ----------------------------
-- Table structure for `nf_role`
-- ----------------------------
DROP TABLE IF EXISTS `nf_role`;
CREATE TABLE `nf_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `role` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_542609ED57698A6A` (`role`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of nf_role
-- ----------------------------
INSERT INTO `nf_role` VALUES ('1', 'admin', 'ROLE_ADMIN');
INSERT INTO `nf_role` VALUES ('2', 'user', 'ROLE_USER');

-- ----------------------------
-- Table structure for `nf_user`
-- ----------------------------
DROP TABLE IF EXISTS `nf_user`;
CREATE TABLE `nf_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8EDC55CE5E237E06` (`name`),
  UNIQUE KEY `UNIQ_8EDC55CEE7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of nf_user
-- ----------------------------
INSERT INTO `nf_user` VALUES ('13', 'admin', '$2y$12$43bac476c3884ae7af357eoCFEn5j8ywFlogHeutD.uByDN8oeDCC', 'admin@126.com', '1');
INSERT INTO `nf_user` VALUES ('14', 'harry', '$2y$12$43bac476c3884ae7af357eoCFEn5j8ywFlogHeutD.uByDN8oeDCC', 'harry@126.com', '1');

-- ----------------------------
-- Table structure for `nf_user_role`
-- ----------------------------
DROP TABLE IF EXISTS `nf_user_role`;
CREATE TABLE `nf_user_role` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `IDX_81292ACAA76ED395` (`user_id`),
  KEY `IDX_81292ACAD60322AC` (`role_id`),
  CONSTRAINT `FK_81292ACAA76ED395` FOREIGN KEY (`user_id`) REFERENCES `nf_user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_81292ACAD60322AC` FOREIGN KEY (`role_id`) REFERENCES `nf_role` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of nf_user_role
-- ----------------------------
INSERT INTO `nf_user_role` VALUES ('13', '1');
INSERT INTO `nf_user_role` VALUES ('13', '2');
INSERT INTO `nf_user_role` VALUES ('14', '2');
