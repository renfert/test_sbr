-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         5.7.24 - MySQL Community Server (GPL)
-- SO del servidor:              Win64
-- HeidiSQL Versión:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Volcando estructura de base de datos para sbr
CREATE DATABASE IF NOT EXISTS `sbr` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `sbr`;

-- Volcando estructura para tabla sbr.activities
CREATE TABLE IF NOT EXISTS `activities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `create_user` int(11) NOT NULL,
  `mylesson_id` int(11) NOT NULL,
  `mycourse_id` int(11) NOT NULL,
  `program_id` int(11) NOT NULL,
  `type` varchar(45) DEFAULT NULL,
  `lead_name` varchar(45) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `course_title` varchar(150) DEFAULT NULL,
  `lesson_title` varchar(150) DEFAULT NULL,
  `module_title` varchar(150) DEFAULT NULL,
  `program_title` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_activities_myuser1_idx` (`create_user`),
  KEY `fk_activities_mylesson1_idx` (`mylesson_id`),
  KEY `fk_activities_mycourse1_idx` (`mycourse_id`),
  KEY `fk_activities_program1_idx` (`program_id`),
  CONSTRAINT `fk_activities_mycourse1` FOREIGN KEY (`mycourse_id`) REFERENCES `mycourse` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_activities_mylesson1` FOREIGN KEY (`mylesson_id`) REFERENCES `mylesson` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_activities_myuser1` FOREIGN KEY (`create_user`) REFERENCES `myuser` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_activities_program1` FOREIGN KEY (`program_id`) REFERENCES `program` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sbr.activities: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `activities` DISABLE KEYS */;
REPLACE INTO `activities` (`id`, `create_user`, `mylesson_id`, `mycourse_id`, `program_id`, `type`, `lead_name`, `date`, `course_title`, `lesson_title`, `module_title`, `program_title`) VALUES
	(1, 1, 1, 1, 1, 'logout', NULL, '2020-09-22 17:26:07', NULL, NULL, NULL, NULL),
	(2, 1, 1, 1, 1, 'logout', NULL, '2020-09-22 17:26:18', NULL, NULL, NULL, NULL);
/*!40000 ALTER TABLE `activities` ENABLE KEYS */;

-- Volcando estructura para tabla sbr.answer
CREATE TABLE IF NOT EXISTS `answer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `answer` varchar(600) NOT NULL,
  `correct` varchar(15) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sbr.answer: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `answer` DISABLE KEYS */;
REPLACE INTO `answer` (`id`, `answer`, `correct`, `position`) VALUES
	(1, 'default', NULL, NULL);
/*!40000 ALTER TABLE `answer` ENABLE KEYS */;

-- Volcando estructura para tabla sbr.banner
CREATE TABLE IF NOT EXISTS `banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(350) DEFAULT NULL,
  `button_id` int(11) NOT NULL DEFAULT '1',
  `header` varchar(300) DEFAULT 'null',
  `subheader` varchar(600) DEFAULT 'null',
  `header_color` varchar(45) DEFAULT NULL,
  `subheader_color` varchar(45) DEFAULT NULL,
  `text_position` varchar(45) DEFAULT NULL,
  `header_font` varchar(45) DEFAULT NULL,
  `subheader_font` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_banner_cta1_idx` (`button_id`),
  CONSTRAINT `fk_banner_cta1` FOREIGN KEY (`button_id`) REFERENCES `button` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sbr.banner: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `banner` DISABLE KEYS */;
REPLACE INTO `banner` (`id`, `image`, `button_id`, `header`, `subheader`, `header_color`, `subheader_color`, `text_position`, `header_font`, `subheader_font`) VALUES
	(1, NULL, 1, 'null', 'null', NULL, NULL, NULL, NULL, NULL),
	(2, 'default_banner.png', 2, 'Design digital', 'Improve your skills and become the best in digital design.', '#fff', '#fff', 'center', NULL, NULL);
/*!40000 ALTER TABLE `banner` ENABLE KEYS */;

-- Volcando estructura para tabla sbr.button
CREATE TABLE IF NOT EXISTS `button` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(150) DEFAULT 'null',
  `url` varchar(350) DEFAULT NULL,
  `target` varchar(45) DEFAULT NULL,
  `color` varchar(45) DEFAULT NULL,
  `color_hover` varchar(45) DEFAULT NULL,
  `style` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sbr.button: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `button` DISABLE KEYS */;
REPLACE INTO `button` (`id`, `title`, `url`, `target`, `color`, `color_hover`, `style`) VALUES
	(1, 'default', NULL, NULL, NULL, NULL, NULL),
	(2, 'SEE ALL COURSES', NULL, NULL, '#4682B4', '#4285f4', 'plain');
/*!40000 ALTER TABLE `button` ENABLE KEYS */;

-- Volcando estructura para tabla sbr.ci_sessions
CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `timestamp_UNIQUE` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sbr.ci_sessions: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `ci_sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `ci_sessions` ENABLE KEYS */;

-- Volcando estructura para tabla sbr.course_helper
CREATE TABLE IF NOT EXISTS `course_helper` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `myuser_id` int(11) NOT NULL,
  `mycourse_id` int(11) NOT NULL,
  `end_date` date DEFAULT NULL,
  `enroll_date` date DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_course_helper_myuser1_idx` (`myuser_id`),
  KEY `fk_course_helper_mycourse1_idx` (`mycourse_id`),
  CONSTRAINT `fk_course_helper_mycourse1` FOREIGN KEY (`mycourse_id`) REFERENCES `mycourse` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_course_helper_myuser1` FOREIGN KEY (`myuser_id`) REFERENCES `myuser` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sbr.course_helper: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `course_helper` DISABLE KEYS */;
/*!40000 ALTER TABLE `course_helper` ENABLE KEYS */;

-- Volcando estructura para tabla sbr.first_steps
CREATE TABLE IF NOT EXISTS `first_steps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sbr.first_steps: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `first_steps` DISABLE KEYS */;
REPLACE INTO `first_steps` (`id`, `name`, `status`) VALUES
	(1, 'create_user', 'finished'),
	(2, 'create_course', NULL),
	(3, 'personalize', NULL),
	(4, 'set_up', NULL);
/*!40000 ALTER TABLE `first_steps` ENABLE KEYS */;

-- Volcando estructura para tabla sbr.footer
CREATE TABLE IF NOT EXISTS `footer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `copyright` varchar(350) DEFAULT NULL,
  `color` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sbr.footer: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `footer` DISABLE KEYS */;
/*!40000 ALTER TABLE `footer` ENABLE KEYS */;

-- Volcando estructura para tabla sbr.footer_has_social_networks
CREATE TABLE IF NOT EXISTS `footer_has_social_networks` (
  `footer_id` int(11) NOT NULL,
  `social_networks_id` int(11) NOT NULL,
  PRIMARY KEY (`footer_id`,`social_networks_id`),
  KEY `fk_footer_has_social_networks_social_networks1_idx` (`social_networks_id`),
  KEY `fk_footer_has_social_networks_footer1_idx` (`footer_id`),
  CONSTRAINT `fk_footer_has_social_networks_footer1` FOREIGN KEY (`footer_id`) REFERENCES `footer` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_footer_has_social_networks_social_networks1` FOREIGN KEY (`social_networks_id`) REFERENCES `social_networks` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sbr.footer_has_social_networks: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `footer_has_social_networks` DISABLE KEYS */;
/*!40000 ALTER TABLE `footer_has_social_networks` ENABLE KEYS */;

-- Volcando estructura para tabla sbr.header
CREATE TABLE IF NOT EXISTS `header` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `logo` varchar(150) DEFAULT NULL,
  `logo_sticky` varchar(45) DEFAULT NULL,
  `logo_size` int(11) DEFAULT NULL,
  `color` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sbr.header: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `header` DISABLE KEYS */;
REPLACE INTO `header` (`id`, `logo`, `logo_sticky`, `logo_size`, `color`) VALUES
	(1, 'sabiorealm.png', 'sabiorealm.png', 15, '#1E90FF');
/*!40000 ALTER TABLE `header` ENABLE KEYS */;

-- Volcando estructura para tabla sbr.header_has_links
CREATE TABLE IF NOT EXISTS `header_has_links` (
  `header_id` int(11) NOT NULL,
  `links_id` int(11) NOT NULL,
  PRIMARY KEY (`header_id`,`links_id`),
  KEY `fk_header_has_links_links1_idx` (`links_id`),
  KEY `fk_header_has_links_header1_idx` (`header_id`),
  CONSTRAINT `fk_header_has_links_header1` FOREIGN KEY (`header_id`) REFERENCES `header` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_header_has_links_links1` FOREIGN KEY (`links_id`) REFERENCES `links` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sbr.header_has_links: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `header_has_links` DISABLE KEYS */;
/*!40000 ALTER TABLE `header_has_links` ENABLE KEYS */;

-- Volcando estructura para tabla sbr.integrations
CREATE TABLE IF NOT EXISTS `integrations` (
  `mp_public_key` varchar(150) DEFAULT NULL,
  `mp_access_token` varchar(150) DEFAULT NULL,
  `mp_country` varchar(45) DEFAULT NULL,
  `mp_last_update` date DEFAULT NULL,
  `ga_id` varchar(150) DEFAULT NULL,
  `fb_id` varchar(150) DEFAULT NULL,
  `gtm_id` varchar(150) DEFAULT NULL,
  `preference_id` varchar(600) DEFAULT NULL,
  `paypal_client_id` varchar(600) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sbr.integrations: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `integrations` DISABLE KEYS */;
/*!40000 ALTER TABLE `integrations` ENABLE KEYS */;

-- Volcando estructura para tabla sbr.jwt
CREATE TABLE IF NOT EXISTS `jwt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `signature` varchar(600) NOT NULL,
  `expiration` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sbr.jwt: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `jwt` DISABLE KEYS */;
/*!40000 ALTER TABLE `jwt` ENABLE KEYS */;

-- Volcando estructura para tabla sbr.lesson_status
CREATE TABLE IF NOT EXISTS `lesson_status` (
  `status` varchar(50) DEFAULT NULL,
  `myuser_id` int(11) NOT NULL,
  `mylesson_id` int(11) NOT NULL,
  `mycourse_id` int(11) NOT NULL,
  `score` int(11) DEFAULT NULL,
  `retest` int(11) DEFAULT '0',
  KEY `fk_lesson_status_mylesson1_idx` (`mylesson_id`),
  KEY `fk_lesson_status_myuser1` (`myuser_id`),
  KEY `fk_lesson_status_mycourse1` (`mycourse_id`),
  CONSTRAINT `fk_lesson_status_mycourse1` FOREIGN KEY (`mycourse_id`) REFERENCES `mycourse` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_lesson_status_mylesson1` FOREIGN KEY (`mylesson_id`) REFERENCES `mylesson` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_lesson_status_myuser1` FOREIGN KEY (`myuser_id`) REFERENCES `myuser` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sbr.lesson_status: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `lesson_status` DISABLE KEYS */;
/*!40000 ALTER TABLE `lesson_status` ENABLE KEYS */;

-- Volcando estructura para tabla sbr.links
CREATE TABLE IF NOT EXISTS `links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `url` varchar(350) NOT NULL,
  `position` int(11) NOT NULL,
  `target` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sbr.links: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `links` DISABLE KEYS */;
/*!40000 ALTER TABLE `links` ENABLE KEYS */;

-- Volcando estructura para tabla sbr.mycategory
CREATE TABLE IF NOT EXISTS `mycategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sbr.mycategory: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `mycategory` DISABLE KEYS */;
REPLACE INTO `mycategory` (`id`, `name`) VALUES
	(1, 'default');
/*!40000 ALTER TABLE `mycategory` ENABLE KEYS */;

-- Volcando estructura para tabla sbr.mycompany
CREATE TABLE IF NOT EXISTS `mycompany` (
  `name` varchar(250) NOT NULL,
  `country` varchar(45) NOT NULL,
  `plan` varchar(45) NOT NULL,
  `contact` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `creation_date` date NOT NULL,
  `type_project` varchar(500) NOT NULL,
  `step_project` varchar(500) NOT NULL,
  `expiration` date NOT NULL,
  `subdomain` varchar(600) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sbr.mycompany: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `mycompany` DISABLE KEYS */;
REPLACE INTO `mycompany` (`name`, `country`, `plan`, `contact`, `email`, `creation_date`, `type_project`, `step_project`, `expiration`, `subdomain`) VALUES
	('Eadtools', 'Peru', 'basic', 'tom', 'tom@eadtools.com', '2020-02-05', 'NA', 'NA', '2025-03-03', 'demo1');
/*!40000 ALTER TABLE `mycompany` ENABLE KEYS */;

-- Volcando estructura para tabla sbr.mycourse
CREATE TABLE IF NOT EXISTS `mycourse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL,
  `description` varchar(800) DEFAULT NULL,
  `photo` varchar(150) DEFAULT NULL,
  `price` varchar(45) DEFAULT NULL,
  `creation_date` date DEFAULT NULL,
  `release_date` date DEFAULT NULL,
  `expiration_date` date DEFAULT NULL,
  `spotlight` varchar(5) DEFAULT NULL,
  `validity` int(11) DEFAULT NULL,
  `preview` varchar(150) DEFAULT NULL,
  `certificate` varchar(45) DEFAULT NULL,
  `reviews` varchar(5) DEFAULT NULL,
  `creation_user` int(11) NOT NULL,
  `mycategory_id` int(11) NOT NULL,
  `currency` varchar(45) DEFAULT NULL,
  `payment_platform` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sbr.mycourse: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `mycourse` DISABLE KEYS */;
REPLACE INTO `mycourse` (`id`, `title`, `description`, `photo`, `price`, `creation_date`, `release_date`, `expiration_date`, `spotlight`, `validity`, `preview`, `certificate`, `reviews`, `creation_user`, `mycategory_id`, `currency`, `payment_platform`) VALUES
	(1, 'default', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL);
/*!40000 ALTER TABLE `mycourse` ENABLE KEYS */;

-- Volcando estructura para tabla sbr.mygroup
CREATE TABLE IF NOT EXISTS `mygroup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sbr.mygroup: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `mygroup` DISABLE KEYS */;
REPLACE INTO `mygroup` (`id`, `name`) VALUES
	(1, 'default');
/*!40000 ALTER TABLE `mygroup` ENABLE KEYS */;

-- Volcando estructura para tabla sbr.mylesson
CREATE TABLE IF NOT EXISTS `mylesson` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL,
  `position` int(11) DEFAULT NULL,
  `path` varchar(150) DEFAULT NULL,
  `ext` varchar(45) DEFAULT NULL,
  `real_name` varchar(250) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` varchar(45) DEFAULT NULL,
  `description` varchar(600) DEFAULT NULL,
  `url` varchar(250) DEFAULT NULL,
  `approval` int(11) DEFAULT NULL,
  `retest` int(11) DEFAULT NULL,
  `type_mylesson_id` int(11) NOT NULL,
  `status` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_mylesson_type_mylesson1_idx` (`type_mylesson_id`),
  CONSTRAINT `fk_mylesson_type_mylesson1` FOREIGN KEY (`type_mylesson_id`) REFERENCES `type_mylesson` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sbr.mylesson: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `mylesson` DISABLE KEYS */;
REPLACE INTO `mylesson` (`id`, `title`, `position`, `path`, `ext`, `real_name`, `date`, `time`, `description`, `url`, `approval`, `retest`, `type_mylesson_id`, `status`) VALUES
	(1, 'default', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL);
/*!40000 ALTER TABLE `mylesson` ENABLE KEYS */;

-- Volcando estructura para tabla sbr.mymodule
CREATE TABLE IF NOT EXISTS `mymodule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL,
  `position` int(11) DEFAULT NULL,
  `required_to_next` varchar(5) DEFAULT NULL,
  `release_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sbr.mymodule: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `mymodule` DISABLE KEYS */;
REPLACE INTO `mymodule` (`id`, `title`, `position`, `required_to_next`, `release_date`) VALUES
	(1, 'default', NULL, NULL, NULL);
/*!40000 ALTER TABLE `mymodule` ENABLE KEYS */;

-- Volcando estructura para tabla sbr.myrole
CREATE TABLE IF NOT EXISTS `myrole` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sbr.myrole: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `myrole` DISABLE KEYS */;
REPLACE INTO `myrole` (`id`, `name`) VALUES
	(1, 'administrator'),
	(2, 'instructor'),
	(3, 'student');
/*!40000 ALTER TABLE `myrole` ENABLE KEYS */;

-- Volcando estructura para tabla sbr.myuser
CREATE TABLE IF NOT EXISTS `myuser` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(350) NOT NULL,
  `avatar` varchar(150) NOT NULL,
  `last_login` varchar(45) DEFAULT NULL,
  `last_activity` varchar(45) DEFAULT NULL,
  `status` varchar(5) DEFAULT NULL,
  `description` varchar(600) DEFAULT NULL,
  `mode` varchar(45) NOT NULL,
  `myrole_id` int(11) NOT NULL,
  `excluded` varchar(5) DEFAULT NULL,
  `creation_date` date DEFAULT NULL,
  `lead` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_myuser_myrole_idx` (`myrole_id`),
  CONSTRAINT `fk_myuser_myrole` FOREIGN KEY (`myrole_id`) REFERENCES `myrole` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sbr.myuser: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `myuser` DISABLE KEYS */;
REPLACE INTO `myuser` (`id`, `name`, `email`, `password`, `avatar`, `last_login`, `last_activity`, `status`, `description`, `mode`, `myrole_id`, `excluded`, `creation_date`, `lead`) VALUES
	(1, 'Stuart little', 'demo@sabiorealm.com', '6f278f85c688b6cf275730b90ec6096c', 'NRJYR5qO8qD3vmcvJRG21R4qj5gRRlCwSNN2QWKo37.jpg', NULL, '2020-09-24 09:49:43', 'on', 'Sabiorealm demo user', 'enable', 1, NULL, NULL, NULL),
	(2, 'Camilo Rodriguez', 'camilo@sabiorealm.com', '6f278f85c688b6cf275730b90ec6096c', 'NRJYR5qO8qD3vmcvJRG21R4qj5gRRlCwSNN2QWKo37.jpg', NULL, '2020-09-23 10:21:25', 'on', 'Sabiorealm demo user', 'enable', 2, NULL, NULL, NULL),
	(3, 'Genaro Delgado', 'genaro@sabiorealm.com', '6f278f85c688b6cf275730b90ec6096c', 'NRJYR5qO8qD3vmcvJRG21R4qj5gRRlCwSNN2QWKo37.jpg', NULL, '2020-09-23 12:37:19', 'on', 'Sabiorealm demo user', 'enable', 2, NULL, NULL, NULL),
	(4, 'Flavio Martinez', 'flavio@sabiorealm.com', '202cb962ac59075b964b07152d234b70', 'default.png', NULL, '2020-09-23 10:21:25', 'on', NULL, 'enable', 3, NULL, '2020-09-22', NULL);
/*!40000 ALTER TABLE `myuser` ENABLE KEYS */;

-- Volcando estructura para tabla sbr.myuser_has_certificate
CREATE TABLE IF NOT EXISTS `myuser_has_certificate` (
  `number` int(11) NOT NULL AUTO_INCREMENT,
  `myuser_id` int(11) NOT NULL,
  `course` varchar(600) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `certificate` varchar(45) DEFAULT NULL,
  `mycourse_id` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`number`),
  KEY `fk_myuser_has_certificate_myuser1_idx` (`myuser_id`),
  CONSTRAINT `fk_myuser_has_certificate_myuser1` FOREIGN KEY (`myuser_id`) REFERENCES `myuser` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sbr.myuser_has_certificate: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `myuser_has_certificate` DISABLE KEYS */;
/*!40000 ALTER TABLE `myuser_has_certificate` ENABLE KEYS */;

-- Volcando estructura para tabla sbr.myuser_has_social_networks
CREATE TABLE IF NOT EXISTS `myuser_has_social_networks` (
  `myuser_id` int(11) NOT NULL,
  `social_networks_id` int(11) NOT NULL,
  `url` varchar(250) NOT NULL,
  PRIMARY KEY (`myuser_id`,`social_networks_id`),
  KEY `fk_myuser_has_social_networks_social_networks1_idx` (`social_networks_id`),
  KEY `fk_myuser_has_social_networks_myuser1_idx` (`myuser_id`),
  CONSTRAINT `fk_myuser_has_social_networks_myuser1` FOREIGN KEY (`myuser_id`) REFERENCES `myuser` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_myuser_has_social_networks_social_networks1` FOREIGN KEY (`social_networks_id`) REFERENCES `social_networks` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sbr.myuser_has_social_networks: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `myuser_has_social_networks` DISABLE KEYS */;
/*!40000 ALTER TABLE `myuser_has_social_networks` ENABLE KEYS */;

-- Volcando estructura para tabla sbr.payments
CREATE TABLE IF NOT EXISTS `payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_id` varchar(600) DEFAULT NULL,
  `payment_status` varchar(45) DEFAULT NULL,
  `myuser_id` int(11) NOT NULL,
  `mycourse_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_payments_myuser1_idx` (`myuser_id`),
  KEY `fk_payments_mycourse1_idx` (`mycourse_id`),
  CONSTRAINT `fk_payments_mycourse1` FOREIGN KEY (`mycourse_id`) REFERENCES `mycourse` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_payments_myuser1` FOREIGN KEY (`myuser_id`) REFERENCES `myuser` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sbr.payments: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;

-- Volcando estructura para tabla sbr.persons
CREATE TABLE IF NOT EXISTS `persons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `occupation` varchar(150) DEFAULT NULL,
  `comment` varchar(150) DEFAULT NULL,
  `photo` varchar(150) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sbr.persons: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `persons` DISABLE KEYS */;
/*!40000 ALTER TABLE `persons` ENABLE KEYS */;

-- Volcando estructura para tabla sbr.product_list
CREATE TABLE IF NOT EXISTS `product_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number_of_products` int(11) DEFAULT NULL,
  `header` varchar(150) DEFAULT NULL,
  `subheader` varchar(600) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sbr.product_list: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `product_list` DISABLE KEYS */;
REPLACE INTO `product_list` (`id`, `number_of_products`, `header`, `subheader`) VALUES
	(1, 10, NULL, NULL);
/*!40000 ALTER TABLE `product_list` ENABLE KEYS */;

-- Volcando estructura para tabla sbr.program
CREATE TABLE IF NOT EXISTS `program` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL,
  `description` varchar(600) DEFAULT NULL,
  `photo` varchar(150) DEFAULT NULL,
  `release_date` date DEFAULT NULL,
  `expiration_date` date DEFAULT NULL,
  `creation_date` date NOT NULL,
  `creation_user` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sbr.program: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `program` DISABLE KEYS */;
REPLACE INTO `program` (`id`, `title`, `description`, `photo`, `release_date`, `expiration_date`, `creation_date`, `creation_user`) VALUES
	(1, 'default', NULL, NULL, NULL, NULL, '2020-03-03', 1);
/*!40000 ALTER TABLE `program` ENABLE KEYS */;

-- Volcando estructura para tabla sbr.program_has_mycourse
CREATE TABLE IF NOT EXISTS `program_has_mycourse` (
  `position` int(11) DEFAULT NULL,
  `mycourse_id` int(11) NOT NULL,
  `program_id` int(11) NOT NULL,
  PRIMARY KEY (`mycourse_id`,`program_id`),
  KEY `fk_program_has_mycourse_mycourse1_idx` (`mycourse_id`),
  KEY `fk_program_has_mycourse_program1_idx` (`program_id`),
  CONSTRAINT `fk_program_has_mycourse_mycourse1` FOREIGN KEY (`mycourse_id`) REFERENCES `mycourse` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_program_has_mycourse_program1` FOREIGN KEY (`program_id`) REFERENCES `program` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sbr.program_has_mycourse: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `program_has_mycourse` DISABLE KEYS */;
/*!40000 ALTER TABLE `program_has_mycourse` ENABLE KEYS */;

-- Volcando estructura para tabla sbr.question
CREATE TABLE IF NOT EXISTS `question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weight` int(11) DEFAULT NULL,
  `question` varchar(600) DEFAULT NULL,
  `image` varchar(150) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `feedback` varchar(600) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `type_question_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_question_type_question1_idx` (`type_question_id`),
  CONSTRAINT `fk_question_type_question1` FOREIGN KEY (`type_question_id`) REFERENCES `type_question` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sbr.question: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `question` DISABLE KEYS */;
REPLACE INTO `question` (`id`, `weight`, `question`, `image`, `position`, `feedback`, `status`, `type_question_id`) VALUES
	(1, NULL, 'default', NULL, NULL, NULL, NULL, 1);
/*!40000 ALTER TABLE `question` ENABLE KEYS */;

-- Volcando estructura para tabla sbr.relationship
CREATE TABLE IF NOT EXISTS `relationship` (
  `myuser_id` int(11) NOT NULL,
  `mycourse_id` int(11) NOT NULL,
  `mymodule_id` int(11) NOT NULL,
  `mylesson_id` int(11) NOT NULL,
  `mygroup_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `answer_id` int(11) NOT NULL,
  `program_id` int(11) NOT NULL,
  KEY `fk_relationship_myuser1_idx` (`myuser_id`),
  KEY `fk_relationship_mycourse1_idx` (`mycourse_id`),
  KEY `fk_relationship_mymodule1_idx` (`mymodule_id`),
  KEY `fk_relationship_mylesson1_idx` (`mylesson_id`),
  KEY `fk_relationship_mygroup1_idx` (`mygroup_id`),
  KEY `fk_relationship_questions1_idx` (`question_id`),
  KEY `fk_relationship_answer1_idx` (`answer_id`),
  KEY `fk_relationship_program1` (`program_id`),
  CONSTRAINT `fk_relationship_answer1` FOREIGN KEY (`answer_id`) REFERENCES `answer` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_relationship_mycourse1` FOREIGN KEY (`mycourse_id`) REFERENCES `mycourse` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_relationship_mygroup1` FOREIGN KEY (`mygroup_id`) REFERENCES `mygroup` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_relationship_mylesson1` FOREIGN KEY (`mylesson_id`) REFERENCES `mylesson` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_relationship_mymodule1` FOREIGN KEY (`mymodule_id`) REFERENCES `mymodule` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_relationship_myuser1` FOREIGN KEY (`myuser_id`) REFERENCES `myuser` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_relationship_program1` FOREIGN KEY (`program_id`) REFERENCES `program` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_relationship_questions1` FOREIGN KEY (`question_id`) REFERENCES `question` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sbr.relationship: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `relationship` DISABLE KEYS */;
/*!40000 ALTER TABLE `relationship` ENABLE KEYS */;

-- Volcando estructura para tabla sbr.reviews
CREATE TABLE IF NOT EXISTS `reviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comment` varchar(800) DEFAULT NULL,
  `rate` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `myuser_id` int(11) NOT NULL,
  `mycourse_id` int(11) NOT NULL,
  `status` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`,`myuser_id`,`mycourse_id`),
  KEY `fk_reviews_myuser1_idx` (`myuser_id`),
  KEY `fk_reviews_mycourse1_idx` (`mycourse_id`),
  CONSTRAINT `fk_reviews_mycourse1` FOREIGN KEY (`mycourse_id`) REFERENCES `mycourse` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_reviews_myuser1` FOREIGN KEY (`myuser_id`) REFERENCES `myuser` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sbr.reviews: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;

-- Volcando estructura para tabla sbr.section
CREATE TABLE IF NOT EXISTS `section` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `position` int(11) NOT NULL,
  `banner_id` int(11) NOT NULL DEFAULT '1',
  `product_list_id` int(11) NOT NULL DEFAULT '1',
  `testimonial_id` int(11) NOT NULL DEFAULT '1',
  `text_and_media_id` int(11) NOT NULL DEFAULT '1',
  `type` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_section_banner1_idx` (`banner_id`),
  KEY `fk_section_product_list1_idx` (`product_list_id`),
  KEY `fk_section_testimonial1_idx` (`testimonial_id`),
  KEY `fk_section_text_and_media1_idx` (`text_and_media_id`),
  CONSTRAINT `fk_section_banner1` FOREIGN KEY (`banner_id`) REFERENCES `banner` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_section_product_list1` FOREIGN KEY (`product_list_id`) REFERENCES `product_list` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_section_testimonial1` FOREIGN KEY (`testimonial_id`) REFERENCES `testimonial` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_section_text_and_media1` FOREIGN KEY (`text_and_media_id`) REFERENCES `text_and_media` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sbr.section: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `section` DISABLE KEYS */;
REPLACE INTO `section` (`id`, `position`, `banner_id`, `product_list_id`, `testimonial_id`, `text_and_media_id`, `type`) VALUES
	(1, 0, 2, 1, 1, 1, 'banner');
/*!40000 ALTER TABLE `section` ENABLE KEYS */;

-- Volcando estructura para tabla sbr.settings
CREATE TABLE IF NOT EXISTS `settings` (
  `name` varchar(250) DEFAULT NULL,
  `description` varchar(250) DEFAULT NULL,
  `favicon` varchar(250) DEFAULT NULL,
  `logo` varchar(250) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `currency` varchar(45) DEFAULT NULL,
  `marketplace` varchar(5) DEFAULT NULL,
  `lang` varchar(5) NOT NULL,
  `theme` varchar(15) NOT NULL,
  `zone` varchar(150) NOT NULL,
  `color` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sbr.settings: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
REPLACE INTO `settings` (`name`, `description`, `favicon`, `logo`, `email`, `phone`, `currency`, `marketplace`, `lang`, `theme`, `zone`, `color`) VALUES
	('Eadtools', 'Disruptive education', 'favicon.png', 'sabiorealm.png', 'youremail@company.com', '+55 41 99713-8892', NULL, 'on', 'en', 'default', 'America/Bogota', '#1E90FF');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;

-- Volcando estructura para tabla sbr.social_comments
CREATE TABLE IF NOT EXISTS `social_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `social_publication_id` int(11) DEFAULT NULL,
  `myuser_id` int(11) DEFAULT NULL,
  `comment` varchar(800) DEFAULT NULL,
  `prev_comment` varchar(100) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `social_comments_myuser_id_fk` (`myuser_id`),
  KEY `social_comments_social_publications_id_fk` (`social_publication_id`),
  CONSTRAINT `social_comments_myuser_id_fk` FOREIGN KEY (`myuser_id`) REFERENCES `myuser` (`id`) ON DELETE CASCADE,
  CONSTRAINT `social_comments_social_publications_id_fk` FOREIGN KEY (`social_publication_id`) REFERENCES `social_publications` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sbr.social_comments: ~9 rows (aproximadamente)
/*!40000 ALTER TABLE `social_comments` DISABLE KEYS */;
REPLACE INTO `social_comments` (`id`, `social_publication_id`, `myuser_id`, `comment`, `prev_comment`, `created`, `modified`) VALUES
	(3, 57, 1, 'gaaa', 'gaaa...', '2020-09-23 16:41:22', '2020-09-23 16:41:22'),
	(51, 98, 1, 'ijdawkdmaldkaw', 'ijdawkdmaldkaw...', '2020-09-23 18:09:45', '2020-09-23 18:09:45'),
	(52, 103, 1, 'www', 'www...', '2020-09-23 18:10:00', '2020-09-23 18:10:00'),
	(53, 98, 1, 'dwdw', 'dwdw...', '2020-09-23 18:10:01', '2020-09-23 18:10:01'),
	(54, 104, 1, 'wdwd', 'wdwd...', '2020-09-23 18:10:21', '2020-09-23 18:10:21'),
	(55, 103, 1, 'aea', 'aea...', '2020-09-23 18:10:29', '2020-09-23 18:10:29'),
	(56, 104, 1, 'dwdwd', 'dwdwd...', '2020-09-23 18:24:23', '2020-09-23 18:24:23'),
	(57, 103, 1, 'wdwdwdwwwwwwwdw', 'wdwdwdwwwwwwwdw...', '2020-09-23 18:38:40', '2020-09-23 18:38:40'),
	(58, 108, 1, 'gaea', 'gaea...', '2020-09-24 09:48:36', '2020-09-24 09:48:36');
/*!40000 ALTER TABLE `social_comments` ENABLE KEYS */;

-- Volcando estructura para tabla sbr.social_likes
CREATE TABLE IF NOT EXISTS `social_likes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `social_publication_id` int(11) DEFAULT NULL,
  `myuser_id` int(11) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `social_likes_myuser_id_fk` (`myuser_id`),
  KEY `social_likes_social_publications_id_fk` (`social_publication_id`),
  CONSTRAINT `social_likes_myuser_id_fk` FOREIGN KEY (`myuser_id`) REFERENCES `myuser` (`id`) ON DELETE CASCADE,
  CONSTRAINT `social_likes_social_publications_id_fk` FOREIGN KEY (`social_publication_id`) REFERENCES `social_publications` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sbr.social_likes: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `social_likes` DISABLE KEYS */;
/*!40000 ALTER TABLE `social_likes` ENABLE KEYS */;

-- Volcando estructura para tabla sbr.social_networks
CREATE TABLE IF NOT EXISTS `social_networks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `url` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sbr.social_networks: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `social_networks` DISABLE KEYS */;
/*!40000 ALTER TABLE `social_networks` ENABLE KEYS */;

-- Volcando estructura para tabla sbr.social_publications
CREATE TABLE IF NOT EXISTS `social_publications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `myuser_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `pub_url` varchar(255) DEFAULT NULL,
  `description` varchar(1500) DEFAULT NULL,
  `prev_description` varchar(250) DEFAULT NULL,
  `media_path` varchar(255) DEFAULT NULL,
  `media_realname` varchar(255) DEFAULT NULL,
  `media_type` varchar(50) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `social_publications_mygroup_id_fk` (`group_id`),
  KEY `social_publications_myuser_id_fk` (`myuser_id`),
  CONSTRAINT `social_publications_mygroup_id_fk` FOREIGN KEY (`group_id`) REFERENCES `mygroup` (`id`),
  CONSTRAINT `social_publications_myuser_id_fk` FOREIGN KEY (`myuser_id`) REFERENCES `myuser` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=109 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sbr.social_publications: ~6 rows (aproximadamente)
/*!40000 ALTER TABLE `social_publications` DISABLE KEYS */;
REPLACE INTO `social_publications` (`id`, `myuser_id`, `group_id`, `pub_url`, `description`, `prev_description`, `media_path`, `media_realname`, `media_type`, `created`, `modified`) VALUES
	(57, 1, NULL, NULL, 'jejeje', 'jejeje...', NULL, NULL, NULL, '2020-09-23 12:38:50', '2020-09-23 12:38:50'),
	(98, 1, NULL, NULL, 'jajaj\n', 'jajaj\n...', NULL, NULL, NULL, '2020-09-23 17:38:21', '2020-09-23 17:38:21'),
	(103, 1, NULL, NULL, 'gaaa', 'gaaa...', NULL, NULL, NULL, '2020-09-23 18:09:52', '2020-09-23 18:09:52'),
	(104, 1, NULL, NULL, 'wdwdw', 'wdwdw...', NULL, NULL, NULL, '2020-09-23 18:10:15', '2020-09-23 18:10:15'),
	(105, 1, NULL, NULL, 'pppp', 'pppp...', NULL, NULL, NULL, '2020-09-23 18:24:27', '2020-09-23 18:24:27'),
	(108, 1, NULL, NULL, 'jaaa', 'jaaa...', NULL, NULL, NULL, '2020-09-24 09:45:54', '2020-09-24 09:45:54');
/*!40000 ALTER TABLE `social_publications` ENABLE KEYS */;

-- Volcando estructura para tabla sbr.testimonial
CREATE TABLE IF NOT EXISTS `testimonial` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `header` varchar(300) DEFAULT NULL,
  `subheader` varchar(600) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sbr.testimonial: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `testimonial` DISABLE KEYS */;
REPLACE INTO `testimonial` (`id`, `header`, `subheader`) VALUES
	(1, 'default', 'default');
/*!40000 ALTER TABLE `testimonial` ENABLE KEYS */;

-- Volcando estructura para tabla sbr.testimonial_has_persons
CREATE TABLE IF NOT EXISTS `testimonial_has_persons` (
  `testimonial_id` int(11) NOT NULL,
  `persons_id` int(11) NOT NULL,
  PRIMARY KEY (`testimonial_id`,`persons_id`),
  KEY `fk_testimonial_has_persons_persons1_idx` (`persons_id`),
  KEY `fk_testimonial_has_persons_testimonial1_idx` (`testimonial_id`),
  CONSTRAINT `fk_testimonial_has_persons_persons1` FOREIGN KEY (`persons_id`) REFERENCES `persons` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_testimonial_has_persons_testimonial1` FOREIGN KEY (`testimonial_id`) REFERENCES `testimonial` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sbr.testimonial_has_persons: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `testimonial_has_persons` DISABLE KEYS */;
/*!40000 ALTER TABLE `testimonial_has_persons` ENABLE KEYS */;

-- Volcando estructura para tabla sbr.text_and_media
CREATE TABLE IF NOT EXISTS `text_and_media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `header` varchar(250) DEFAULT NULL,
  `content` varchar(1000) DEFAULT NULL,
  `media` varchar(150) DEFAULT NULL,
  `media_position` varchar(45) DEFAULT NULL,
  `button_id` int(11) NOT NULL DEFAULT '1',
  `button_align` varchar(15) DEFAULT NULL,
  `subheader` varchar(600) DEFAULT NULL,
  `media_align` varchar(45) DEFAULT NULL,
  `text_align` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_text_and_media_cta1_idx` (`button_id`),
  CONSTRAINT `fk_text_and_media_cta1` FOREIGN KEY (`button_id`) REFERENCES `button` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sbr.text_and_media: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `text_and_media` DISABLE KEYS */;
REPLACE INTO `text_and_media` (`id`, `header`, `content`, `media`, `media_position`, `button_id`, `button_align`, `subheader`, `media_align`, `text_align`) VALUES
	(1, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL);
/*!40000 ALTER TABLE `text_and_media` ENABLE KEYS */;

-- Volcando estructura para tabla sbr.type_mylesson
CREATE TABLE IF NOT EXISTS `type_mylesson` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sbr.type_mylesson: ~8 rows (aproximadamente)
/*!40000 ALTER TABLE `type_mylesson` DISABLE KEYS */;
REPLACE INTO `type_mylesson` (`id`, `name`) VALUES
	(1, 'video'),
	(2, 'audio'),
	(3, 'pdf'),
	(4, 'downloadable'),
	(5, 'videocall'),
	(6, 'webinar'),
	(7, 'html'),
	(8, 'exam');
/*!40000 ALTER TABLE `type_mylesson` ENABLE KEYS */;

-- Volcando estructura para tabla sbr.type_question
CREATE TABLE IF NOT EXISTS `type_question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sbr.type_question: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `type_question` DISABLE KEYS */;
REPLACE INTO `type_question` (`id`, `name`) VALUES
	(1, 'descriptive'),
	(2, 'multiple'),
	(3, 'free');
/*!40000 ALTER TABLE `type_question` ENABLE KEYS */;

-- Volcando estructura para tabla sbr.users_answers
CREATE TABLE IF NOT EXISTS `users_answers` (
  `myuser_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `answer` varchar(600) DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `feedback` varchar(600) DEFAULT NULL,
  `feedback_useful` varchar(45) DEFAULT NULL,
  `feedback_user` int(11) DEFAULT NULL,
  KEY `fk_users_answers_question1_idx` (`question_id`),
  KEY `fk_users_answers_myuser1` (`myuser_id`),
  CONSTRAINT `fk_users_answers_myuser1` FOREIGN KEY (`myuser_id`) REFERENCES `myuser` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_answers_question1` FOREIGN KEY (`question_id`) REFERENCES `question` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sbr.users_answers: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `users_answers` DISABLE KEYS */;
/*!40000 ALTER TABLE `users_answers` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
