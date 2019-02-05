-- MySQL dump 10.13  Distrib 8.0.14, for Linux (x86_64)
--
-- Host: localhost    Database: product_manager
-- ------------------------------------------------------
-- Server version	8.0.14

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
 #SET NAMES utf8mb4 ;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `catalogues`
--

DROP TABLE IF EXISTS `catalogues`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 #SET character_set_client = utf8mb4 ;
CREATE TABLE `catalogues` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `customer_id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  `quantity` int(11) NOT NULL,
  `isEmpty` int(2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_catalogue_customer_idx` (`customer_id`),
  KEY `fk_catalogue_product_idx` (`product_id`),
  CONSTRAINT `fk_catalogue_customer` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id_user`),
  CONSTRAINT `fk_catalogue_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `catalogues`
--

LOCK TABLES `catalogues` WRITE;
/*!40000 ALTER TABLE `catalogues` DISABLE KEYS */;
INSERT INTO `catalogues` VALUES (2,13,1,10,0,'2019-01-30 22:17:51','2019-01-30 22:17:51'),(3,12,1,10,0,'2019-01-31 18:02:12','2019-01-31 18:02:12'),(4,14,1,10,0,'2019-01-31 18:02:42','2019-01-31 18:02:42'),(5,18,2,10,0,'2019-01-31 18:06:59','2019-01-31 18:06:59'),(6,13,2,20,0,'2019-01-31 19:23:15','2019-01-31 19:23:15');
/*!40000 ALTER TABLE `catalogues` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 #SET character_set_client = utf8mb4 ;
CREATE TABLE `customers` (
  `id_user` int(10) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `isClientTo` int(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_user`),
  KEY `fk_customer_integrator_idx` (`isClientTo`),
  CONSTRAINT `fk_customer_integrator` FOREIGN KEY (`isClientTo`) REFERENCES `integrators` (`id_integrator`),
  CONSTRAINT `fk_customer_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES (12,'JM Parraguez',9,'2019-01-29 16:45:58','2019-01-29 16:45:58'),(13,'San Matte',9,'2019-01-29 19:52:20','2019-01-29 19:52:20'),(14,'Nelson Cere',9,'2019-01-29 19:52:46','2019-01-29 19:52:46'),(15,'Camila',9,'2019-01-29 19:53:01','2019-01-29 19:53:01'),(16,'Karol ql',9,'2019-01-29 19:53:20','2019-01-29 19:53:20'),(18,'Ozuna',17,'2019-01-31 18:05:36','2019-01-31 18:05:36');
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `integrators`
--

DROP TABLE IF EXISTS `integrators`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 #SET character_set_client = utf8mb4 ;
CREATE TABLE `integrators` (
  `id_integrator` int(10) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_integrator`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `integrators`
--

LOCK TABLES `integrators` WRITE;
/*!40000 ALTER TABLE `integrators` DISABLE KEYS */;
INSERT INTO `integrators` VALUES (9,'San Feng','2019-01-28 23:42:04','2019-01-28 23:42:04'),(17,'Hernan Galvez','2019-01-31 18:04:18','2019-01-31 18:04:18');
/*!40000 ALTER TABLE `integrators` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifies`
--

DROP TABLE IF EXISTS `notifies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 #SET character_set_client = utf8mb4 ;
CREATE TABLE `notifies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_integrator` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifies`
--

LOCK TABLES `notifies` WRITE;
/*!40000 ALTER TABLE `notifies` DISABLE KEYS */;
INSERT INTO `notifies` VALUES (1,'The product tomate has become available again.',9,'2019-01-31 00:52:47','2019-01-31 00:52:47'),(2,'The product tomate has become available again.',9,'2019-01-31 00:53:44','2019-01-31 00:53:44');
/*!40000 ALTER TABLE `notifies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 #SET character_set_client = utf8mb4 ;
CREATE TABLE `products` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'tomate','2019-01-29 21:32:01','2019-01-29 21:32:01'),(2,'lechuga','2019-01-31 18:06:42','2019-01-31 18:06:42');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 #SET character_set_client = utf8mb4 ;
CREATE TABLE `users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_user` int(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (9,'sanfeng@gmail.com',1,'2019-01-28 23:42:04','2019-01-28 23:42:04'),(12,'jm@gmail.com',1,'2019-01-29 16:45:58','2019-01-29 16:45:58'),(13,'sm@gmail.com',2,'2019-01-29 19:52:20','2019-01-29 19:52:20'),(14,'ncere@gmail.com',2,'2019-01-29 19:52:46','2019-01-29 19:52:46'),(15,'camila@gmail.com',2,'2019-01-29 19:53:01','2019-01-29 19:53:01'),(16,'chicoql@gmail.com',2,'2019-01-29 19:53:20','2019-01-29 19:53:20'),(17,'hg@gmail.com',1,'2019-01-31 18:04:17','2019-01-31 18:04:17'),(18,'ozuna@gmail.com',2,'2019-01-31 18:05:35','2019-01-31 18:05:35');
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

-- Dump completed on 2019-02-04  2:26:58