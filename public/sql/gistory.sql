/*
Navicat MySQL Data Transfer

Source Server         : homestead
Source Server Version : 50712
Source Host           : 127.0.0.1:33060
Source Database       : gistory

Target Server Type    : MYSQL
Target Server Version : 50712
File Encoding         : 65001

Date: 2016-11-09 23:05:22
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for edge
-- ----------------------------
DROP TABLE IF EXISTS `edge`;
CREATE TABLE `edge` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weight` int(11) NOT NULL DEFAULT '1',
  `erosseg` double(8,2) NOT NULL,
  `node1_id` int(10) unsigned NOT NULL,
  `node2_id` int(10) unsigned NOT NULL,
  `subproject_id` int(10) unsigned DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `edge_node1_id_node2_id_subproject_id_unique` (`node1_id`,`node2_id`,`subproject_id`),
  KEY `edge_node2_id_foreign` (`node2_id`),
  KEY `edge_subproject_id_foreign` (`subproject_id`),
  CONSTRAINT `edge_node1_id_foreign` FOREIGN KEY (`node1_id`) REFERENCES `node` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `edge_node2_id_foreign` FOREIGN KEY (`node2_id`) REFERENCES `node` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `edge_subproject_id_foreign` FOREIGN KEY (`subproject_id`) REFERENCES `subproject` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=642 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for menu
-- ----------------------------
DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `menu_id` int(10) unsigned DEFAULT NULL,
  `tipus` enum('fooldal','kapcsolat','szoveg','url','regisztracio') COLLATE utf8_unicode_ci NOT NULL,
  `szoveg_id` int(10) unsigned DEFAULT NULL,
  `nev` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `seotitle` text COLLATE utf8_unicode_ci NOT NULL,
  `seokeywords` text COLLATE utf8_unicode_ci NOT NULL,
  `seodescription` text COLLATE utf8_unicode_ci NOT NULL,
  `ogtitle` text COLLATE utf8_unicode_ci NOT NULL,
  `ogdescription` text COLLATE utf8_unicode_ci NOT NULL,
  `ujablak` tinyint(1) NOT NULL,
  `aktiv` tinyint(1) NOT NULL,
  `sorrend` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_menu_id_index` (`menu_id`),
  KEY `menu_szoveg_id_index` (`szoveg_id`),
  CONSTRAINT `menu_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `menu_szoveg_id_foreign` FOREIGN KEY (`szoveg_id`) REFERENCES `szoveg` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for node
-- ----------------------------
DROP TABLE IF EXISTS `node`;
CREATE TABLE `node` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nev` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `project_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `node_project_id_foreign` (`project_id`),
  CONSTRAINT `node_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=200 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for nodeattribute
-- ----------------------------
DROP TABLE IF EXISTS `nodeattribute`;
CREATE TABLE `nodeattribute` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `degree` int(11) NOT NULL,
  `weightdegree` int(11) NOT NULL,
  `node_id` int(10) unsigned NOT NULL,
  `subproject_id` int(10) unsigned NOT NULL,
  `clustering` double(8,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nodeattribute_node_id_subproject_id_unique` (`node_id`,`subproject_id`),
  KEY `nodeattribute_subproject_id_foreign` (`subproject_id`),
  CONSTRAINT `nodeattribute_node_id_foreign` FOREIGN KEY (`node_id`) REFERENCES `node` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `nodeattribute_subproject_id_foreign` FOREIGN KEY (`subproject_id`) REFERENCES `subproject` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=195 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for permission_role
-- ----------------------------
DROP TABLE IF EXISTS `permission_role`;
CREATE TABLE `permission_role` (
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `permission_role_role_id_foreign` (`role_id`),
  CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for project
-- ----------------------------
DROP TABLE IF EXISTS `project`;
CREATE TABLE `project` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL,
  `cim` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `leiras` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `szoveg` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `project_user_id_foreign` (`user_id`),
  CONSTRAINT `project_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for project2team
-- ----------------------------
DROP TABLE IF EXISTS `project2team`;
CREATE TABLE `project2team` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(10) unsigned NOT NULL,
  `team_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `project2team_project_id_team_id_unique` (`project_id`,`team_id`),
  KEY `project2team_team_id_foreign` (`team_id`),
  CONSTRAINT `project2team_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `project2team_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `team` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for role_user
-- ----------------------------
DROP TABLE IF EXISTS `role_user`;
CREATE TABLE `role_user` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `role_user_role_id_foreign` (`role_id`),
  CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for subproject
-- ----------------------------
DROP TABLE IF EXISTS `subproject`;
CREATE TABLE `subproject` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nev` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `leiras` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `project_id` int(10) unsigned DEFAULT NULL,
  `clustering` double(8,2) DEFAULT NULL,
  `transitivity` double(8,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subproject_project_id_foreign` (`project_id`),
  CONSTRAINT `subproject_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for szoveg
-- ----------------------------
DROP TABLE IF EXISTS `szoveg`;
CREATE TABLE `szoveg` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cim` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `szoveg` text COLLATE utf8_unicode_ci NOT NULL,
  `seotitle` text COLLATE utf8_unicode_ci NOT NULL,
  `seokeywords` text COLLATE utf8_unicode_ci NOT NULL,
  `seodescription` text COLLATE utf8_unicode_ci NOT NULL,
  `ogtitle` text COLLATE utf8_unicode_ci NOT NULL,
  `ogdescription` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for team
-- ----------------------------
DROP TABLE IF EXISTS `team`;
CREATE TABLE `team` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `leiras` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `owner_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `team_owner_id_name_unique` (`owner_id`,`name`),
  CONSTRAINT `team_owner_id_foreign` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for user2team
-- ----------------------------
DROP TABLE IF EXISTS `user2team`;
CREATE TABLE `user2team` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `team_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user2team_user_id_team_id_unique` (`user_id`,`team_id`),
  KEY `user2team_team_id_foreign` (`team_id`),
  CONSTRAINT `user2team_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `team` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user2team_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `hash` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
