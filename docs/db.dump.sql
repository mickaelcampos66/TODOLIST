-- Adminer 4.7.6 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'L''identifiant de la catégorie  ',
  `name` varchar(50) NOT NULL COMMENT 'Le nom de la catégorie  ',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'La date de création de la catégorie ',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT 'La date de la dernière mise à jour de la catégorie',
  `task_id` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `task_id` (`task_id`),
  CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`, `task_id`) VALUES
(1,	'Courses',	'2023-08-22 12:56:31',	NULL,	NULL),
(2,	'Menage',	'2023-08-23 11:55:03',	'2023-08-23 12:07:27',	NULL),
(4,	'Nettoyage',	'2023-09-04 08:02:28',	NULL,	NULL);

DROP TABLE IF EXISTS `tags`;
CREATE TABLE `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'L''identifiant du tag ',
  `label` varchar(50) NOT NULL COMMENT 'Nom du tag',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'La date de création du tag ',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT 'La date de la dernière mise à jour du tag',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `tags` (`id`, `label`, `created_at`, `updated_at`) VALUES
(2,	'Nettoyage',	'2023-08-28 15:22:39',	NULL),
(3,	'rangement',	'2023-08-28 15:22:46',	NULL),
(4,	'nourriture',	'2023-08-28 15:22:53',	NULL);

DROP TABLE IF EXISTS `tag_task`;
CREATE TABLE `tag_task` (
  `task_id` bigint(20) unsigned NOT NULL,
  `tag_id` int(11) NOT NULL,
  KEY `task_id` (`task_id`),
  KEY `tag_id` (`tag_id`),
  CONSTRAINT `tag_task_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`),
  CONSTRAINT `tag_task_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `tasks`;
CREATE TABLE `tasks` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `category_id` bigint(20) unsigned DEFAULT NULL,
  `tag_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  KEY `tag_id` (`tag_id`),
  CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  CONSTRAINT `tasks_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  CONSTRAINT `tasks_ibfk_3` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `tasks` (`id`, `title`, `status`, `created_at`, `updated_at`, `category_id`, `tag_id`) VALUES
(1,	'Acheter une salade',	0,	'2022-08-21 17:13:59',	'2022-08-21 17:13:59',	1,	4),
(3,	'Laver son assiette',	0,	'2022-08-21 17:14:33',	'2022-08-21 17:14:33',	2,	3),
(4,	'Faire le menage',	1,	NULL,	NULL,	4,	2),
(49,	'test',	0,	'2023-09-04 12:21:30',	'2023-09-04 12:21:30',	NULL,	NULL);

-- 2023-09-04 14:22:55