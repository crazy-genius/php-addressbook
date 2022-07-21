SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

CREATE DATABASE `addressbook` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `addressbook`;

DROP TABLE IF EXISTS `address_in_groups`;
CREATE TABLE `address_in_groups` (
                                     `domain_id` int unsigned NOT NULL DEFAULT '0',
                                     `id` int unsigned NOT NULL DEFAULT '0',
                                     `group_id` int unsigned NOT NULL DEFAULT '0',
                                     `created` datetime DEFAULT NULL,
                                     `modified` datetime DEFAULT NULL,
                                     `deprecated` datetime DEFAULT NULL,
                                     PRIMARY KEY (`group_id`,`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `addressbook`;
CREATE TABLE `addressbook` (
                               `ID` int NOT NULL AUTO_INCREMENT,
                               `domain_id` int unsigned NOT NULL DEFAULT '0',
                               `firstname` varchar(255) NOT NULL,
                               `middlename` varchar(255) NOT NULL,
                               `lastname` varchar(255) NOT NULL,
                               `nickname` varchar(255) NOT NULL,
                               `company` varchar(255) NOT NULL,
                               `title` varchar(255) NOT NULL,
                               `address` text NOT NULL,
                               `addr_long` text,
                               `addr_lat` text,
                               `addr_status` text,
                               `home` text NOT NULL,
                               `mobile` text NOT NULL,
                               `work` text NOT NULL,
                               `fax` text NOT NULL,
                               `email` text NOT NULL,
                               `email2` text NOT NULL,
                               `email3` text NOT NULL,
                               `im` text,
                               `im2` text,
                               `im3` text,
                               `homepage` text NOT NULL,
                               `bday` tinyint NOT NULL,
                               `bmonth` varchar(50) NOT NULL,
                               `byear` varchar(4) NOT NULL,
                               `aday` tinyint NOT NULL,
                               `amonth` varchar(50) NOT NULL,
                               `ayear` varchar(4) NOT NULL,
                               `address2` text NOT NULL,
                               `phone2` text NOT NULL,
                               `notes` text NOT NULL,
                               `photo` mediumtext,
                               `x_vcard` mediumtext,
                               `x_activesync` mediumtext,
                               `created` datetime DEFAULT NULL,
                               `modified` datetime DEFAULT NULL,
                               `deprecated` datetime DEFAULT NULL,
                               `password` varchar(256) DEFAULT NULL,
                               `login` date DEFAULT NULL,
                               `role` varchar(256) DEFAULT NULL,
                               PRIMARY KEY (`ID`),
                               KEY `deprecated_domain_id_idx` (`deprecated`,`domain_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `group_list`;
CREATE TABLE `group_list` (
                              `domain_id` int unsigned NOT NULL DEFAULT '0',
                              `group_id` int unsigned NOT NULL AUTO_INCREMENT,
                              `group_parent_id` int DEFAULT NULL,
                              `created` datetime DEFAULT NULL,
                              `modified` datetime DEFAULT NULL,
                              `deprecated` datetime DEFAULT NULL,
                              `group_name` varchar(255) NOT NULL DEFAULT '',
                              `group_header` mediumtext NOT NULL,
                              `group_footer` mediumtext NOT NULL,
                              PRIMARY KEY (`group_id`,`domain_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `month_lookup`;
CREATE TABLE `month_lookup` (
                                `bmonth` varchar(50) NOT NULL DEFAULT '',
                                `bmonth_short` char(3) NOT NULL DEFAULT '',
                                `bmonth_num` int unsigned NOT NULL DEFAULT '0',
                                PRIMARY KEY (`bmonth_num`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

TRUNCATE `month_lookup`;
INSERT INTO `month_lookup` (`bmonth`, `bmonth_short`, `bmonth_num`) VALUES
                                                                        ('',	'',	0),
                                                                        ('January',	'Jan',	1),
                                                                        ('February',	'Feb',	2),
                                                                        ('March',	'Mar',	3),
                                                                        ('April',	'Apr',	4),
                                                                        ('May',	'May',	5),
                                                                        ('June',	'Jun',	6),
                                                                        ('July',	'Jul',	7),
                                                                        ('August',	'Aug',	8),
                                                                        ('September',	'Sep',	9),
                                                                        ('October',	'Oct',	10),
                                                                        ('November',	'Nov',	11),
                                                                        ('December',	'Dec',	12);

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
                         `user_id` int NOT NULL AUTO_INCREMENT,
                         `domain_id` int unsigned NOT NULL DEFAULT '0',
                         `username` char(128) NOT NULL,
                         `md5_pass` char(128) NOT NULL,
                         `password_hint` varchar(255) NOT NULL DEFAULT '',
                         `sso_facebook_uid` varchar(255) DEFAULT NULL,
                         `sso_google_uid` varchar(255) DEFAULT NULL,
                         `sso_live_uid` varchar(255) DEFAULT NULL,
                         `sso_yahoo_uid` varchar(255) DEFAULT NULL,
                         `lastname` varchar(50) NOT NULL DEFAULT '',
                         `firstname` varchar(50) NOT NULL DEFAULT '',
                         `email` varchar(100) NOT NULL DEFAULT '',
                         `phone` varchar(50) NOT NULL DEFAULT '',
                         `address1` varchar(100) NOT NULL DEFAULT '',
                         `address2` varchar(100) NOT NULL DEFAULT '',
                         `city` varchar(80) NOT NULL DEFAULT '',
                         `state` varchar(20) NOT NULL DEFAULT '',
                         `zip` varchar(20) NOT NULL DEFAULT '',
                         `country` varchar(50) NOT NULL DEFAULT '',
                         `master_code` char(128) NOT NULL,
                         `confirmation_code` char(128) DEFAULT NULL,
                         `pass_reset_code` char(128) DEFAULT NULL,
                         `status` char(128) NOT NULL DEFAULT 'NEW' COMMENT 'New, Ready, Blocked',
                         `trials` int NOT NULL DEFAULT '0',
                         `created` datetime DEFAULT NULL,
                         `modified` datetime DEFAULT NULL,
                         `deprecated` datetime DEFAULT NULL,
                         PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
