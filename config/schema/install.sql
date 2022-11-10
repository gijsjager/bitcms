# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.17)
# Database: dotbits_iris
# Generation Time: 2017-11-19 18:52:38 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table block_groups
# ------------------------------------------------------------

DROP TABLE IF EXISTS `block_groups`;

CREATE TABLE `block_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `model` varchar(255) NOT NULL DEFAULT 'Pages',
  `entity_id` int(11) DEFAULT NULL,
  `class` varchar(255) DEFAULT NULL,
  `wrapper_class` varchar(255) DEFAULT NULL,
  `position` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `entity_id` (`entity_id`,`model`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table blocks
# ------------------------------------------------------------

DROP TABLE IF EXISTS `blocks`;

CREATE TABLE `blocks` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `block_group_id` int(11) NOT NULL,
  `type` enum('text','images') NOT NULL DEFAULT 'text',
  `class` varchar(255) DEFAULT NULL,
  `position` int(11) DEFAULT '0',
  `content` longtext,
  PRIMARY KEY (`id`),
  KEY `block_group_id` (`block_group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table files
# ------------------------------------------------------------

DROP TABLE IF EXISTS `files`;

CREATE TABLE `files` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `model` varchar(255) NOT NULL DEFAULT '',
  `entity_id` int(11) NOT NULL,
  `language_id` int(11) DEFAULT NULL,
  `filename` varchar(255) NOT NULL DEFAULT '',
  `title` varchar(255) DEFAULT NULL,
  `position` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `model` (`model`,`entity_id`),
  KEY `language_id` (`language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table history
# ------------------------------------------------------------

DROP TABLE IF EXISTS `history`;

CREATE TABLE `history` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `content` text,
  `position` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table i18n
# ------------------------------------------------------------

DROP TABLE IF EXISTS `i18n`;

CREATE TABLE `i18n` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `locale` varchar(6) NOT NULL,
  `model` varchar(255) NOT NULL,
  `foreign_key` int(10) NOT NULL,
  `field` varchar(255) NOT NULL,
  `content` longtext,
  PRIMARY KEY (`id`),
  UNIQUE KEY `I18N_LOCALE_FIELD` (`locale`,`model`,`foreign_key`,`field`),
  KEY `I18N_FIELD` (`model`,`foreign_key`,`field`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table images
# ------------------------------------------------------------

DROP TABLE IF EXISTS `images`;

CREATE TABLE `images` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `model` varchar(255) NOT NULL,
  `entity_id` int(11) NOT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `alt` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `meta` text,
  `position` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `model` (`model`,`entity_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


# Dump of table images_responsive
# ------------------------------------------------------------
CREATE TABLE `image_responsive` (
                                    `id` int(11) UNSIGNED NOT NULL,
                                    `image_id` int(11) DEFAULT NULL,
                                    `type` enum('mobile','tablet','desktop') NOT NULL DEFAULT 'mobile',
                                    `filename` varchar(255) NOT NULL DEFAULT '',
                                    `model` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `image_responsive`
    ADD PRIMARY KEY (`id`),
    ADD KEY `image_id` (`image_id`);


ALTER TABLE `image_responsive` MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;


# Dump of table languages
# ------------------------------------------------------------

DROP TABLE IF EXISTS `languages`;

CREATE TABLE `languages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `abbreviation` varchar(10) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `locale` varchar(10) DEFAULT NULL,
  `position` int(11) DEFAULT '0',
  `active` tinyint(1) DEFAULT '1',
  `is_default` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `active` (`active`),
  KEY `abbreviation` (`abbreviation`),
  KEY `default` (`is_default`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `languages` WRITE;
/*!40000 ALTER TABLE `languages` DISABLE KEYS */;

INSERT INTO `languages` (`id`, `abbreviation`, `name`, `locale`, `position`, `active`, `is_default`)
VALUES
	(1,'nl','Nederlands','nl_NL',0,1,1);

/*!40000 ALTER TABLE `languages` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table logs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `logs`;

CREATE TABLE `logs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `entity_id` int(11) DEFAULT NULL,
  `data` longtext,
  `date_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table mails
# ------------------------------------------------------------

DROP TABLE IF EXISTS `mails`;

CREATE TABLE `mails` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `date_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `receiver` varchar(255) DEFAULT NULL,
  `sender` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `content` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table news
# ------------------------------------------------------------

DROP TABLE IF EXISTS `news`;

CREATE TABLE `news` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `publication` date DEFAULT NULL,
  `online` tinyint(1) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL DEFAULT '',
  `slug` varchar(255) DEFAULT '',
  `category` varchar(255) DEFAULT NULL,
  `intro` text,
  `content` text,
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table pages
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pages`;

CREATE TABLE `pages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `online` int(11) DEFAULT '1',
  `menu` int(11) DEFAULT '0',
  `title` varchar(255) NOT NULL DEFAULT '',
  `slug` varchar(255) NOT NULL DEFAULT '',
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_description` varchar(255) DEFAULT NULL,
  `position` int(11) DEFAULT '0',
  `parent_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `parent_id` (`parent_id`),
  KEY `menu` (`menu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table redirects
# ------------------------------------------------------------

DROP TABLE IF EXISTS `redirects`;

CREATE TABLE `redirects` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `from_url` varchar(255) NOT NULL DEFAULT '',
  `to_url` varchar(255) NOT NULL DEFAULT '',
  `type` enum('301','302') DEFAULT '301',
  `date_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `from_url` (`from_url`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table settings
# ------------------------------------------------------------

DROP TABLE IF EXISTS `settings`;

CREATE TABLE `settings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `value` text,
  `info` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table showcases
# ------------------------------------------------------------

DROP TABLE IF EXISTS `showcases`;

CREATE TABLE `showcases` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `slug` varchar(255) DEFAULT NULL,
  `online` tinyint(1) DEFAULT '0',
  `big_title` varchar(255) DEFAULT NULL,
  `content` text,
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_description` varchar(11) DEFAULT NULL,
  `position` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `slug` (`slug`),
  KEY `online` (`online`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `role` enum('admin','superuser','user') NOT NULL DEFAULT 'admin',
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created`, `modified`, `fullname`, `email`)
VALUES
	(1,'gijs','$2y$10$.aUqH4KXUeWcy7DGlD1Ts.bN6QhrVjw.8KTx2CQU1V5O6GB1C/5T6','admin','2017-05-12 07:56:19','2017-06-11 14:14:09','Gijs Jager','gijs@dotbits.nl');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table visitors
# ------------------------------------------------------------

DROP TABLE IF EXISTS `visitors`;

CREATE TABLE `visitors` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `date_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `ipaddress` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `browser_data` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
