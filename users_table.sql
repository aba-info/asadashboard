-- MariaDB dump 10.19-11.0.3-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: asadashboard
-- ------------------------------------------------------
-- Server version	11.0.3-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
(2,'martinrosbier','martinrosbier@gmail.com',NULL,'$2y$10$We3GumSHbXs5zKMDsLSg5uBgAvDB/pPo726Uk8K62Ds4iVagJOyTa',NULL,'2023-09-29 13:20:00','2023-09-29 13:20:00'),
(3,'Daniel Cazap','daniel@asabarak.com',NULL,'$2y$10$UAhgnjkB9gUXEjzzd0qjfedYzcOoXlKJJ0Ru2WvRhRw7mWpUIAh0K',NULL,'2023-10-06 14:33:29','2023-10-06 14:33:29'),
(4,'Asa Barak','asa@asabarak.com',NULL,'$2y$10$ld9YnWlsvjuUsczB5HOhGO2T10K5WCjmxCwxpGwhWIoCKhk.FTjtu',NULL,'2023-10-06 14:41:05','2023-10-06 14:41:05'),
(5,'Romy Zheng','romy@asabarak.com',NULL,'$2y$10$Fyhcp1NRa.ABbtz9AKGToeyA4PZC3GlP6Qw64LLO.RB2E/KpeF8Hy',NULL,'2023-10-06 14:42:50','2023-10-06 14:42:50'),
(6,'Sofia M Funes','sofia@asabarak.com',NULL,'$2y$10$owkIWxmbtorfBuVyJ4.qteoDbU/jCGT06qjh.UWDODHooSTw2jj9K',NULL,'2023-10-06 14:43:29','2023-10-06 14:43:29'),
(7,'Silvina Cazap','silvina@asabarak.com',NULL,'$2y$10$kXLp3Q54pcMTXtKC98Xdz.fPqwGWgLtZCJ1mltO8zrQ5BVwrQJ3FK',NULL,'2023-10-06 14:43:53','2023-10-06 14:43:53'),
(8,'Tatiana','tatiana@asabarak.com',NULL,'$2y$10$HITqbeX9mKhgJ920lFnOnucXlB7CmeLtFRJH2hMy1nY7xaqBhbCAq',NULL,'2024-03-21 13:25:49','2024-03-21 13:25:49'),
(9,'INFO','INFO@ASABARAK.COM',NULL,'$2y$10$yDSC6ObkUMH/8MBeVhJe2O9u7S51lNOQCAvq/O3TMIYel/CF/WCby',NULL,'2024-05-20 19:07:28','2024-05-20 19:07:28');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-09-09  1:48:45
