-- MySQL dump 10.13  Distrib 5.7.32, for osx10.14 (x86_64)
--
-- Host: localhost    Database: trigggggggger_local
-- ------------------------------------------------------
-- Server version	5.7.32

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `media`
--

DROP TABLE IF EXISTS `media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `media` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `active` int(1) unsigned NOT NULL DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `object` int(10) unsigned DEFAULT NULL,
  `weight` float DEFAULT NULL,
  `rank` int(10) unsigned DEFAULT NULL,
  `type` varchar(10) NOT NULL DEFAULT 'jpg',
  `caption` blob,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `media`
--

LOCK TABLES `media` WRITE;
/*!40000 ALTER TABLE `media` DISABLE KEYS */;
INSERT INTO `media` VALUES (1,1,'2021-01-17 02:16:54','2021-01-17 02:16:54',6,NULL,NULL,'jpg',''),(2,1,'2021-01-17 02:16:54','2021-01-17 02:16:54',6,NULL,NULL,'jpg',''),(3,1,'2021-01-17 02:17:32','2021-01-17 03:38:23',7,NULL,1,'jpg',_binary '[isThumbnail]dddcc'),(4,1,'2021-01-17 02:17:32','2021-01-17 03:37:17',7,NULL,1,'jpg',_binary 'ccccc'),(5,1,'2021-01-17 02:17:54','2021-01-17 02:17:54',8,NULL,NULL,'jpg',''),(6,1,'2021-01-17 02:17:54','2021-01-17 02:17:54',8,NULL,NULL,'jpg',''),(7,1,'2021-01-17 03:39:27','2021-01-17 03:39:27',15,NULL,NULL,'jpg',''),(8,1,'2021-01-17 03:39:27','2021-01-17 03:39:27',15,NULL,NULL,'jpg',''),(9,1,'2021-01-17 03:39:45','2021-01-17 03:39:45',14,NULL,NULL,'jpg','');
/*!40000 ALTER TABLE `media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `objects`
--

DROP TABLE IF EXISTS `objects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `objects` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `active` int(1) unsigned NOT NULL DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `rank` int(10) unsigned DEFAULT NULL,
  `name1` tinytext,
  `name2` tinytext,
  `address1` text,
  `address2` text,
  `city` tinytext,
  `state` tinytext,
  `zip` tinytext,
  `country` tinytext,
  `phone` tinytext,
  `fax` tinytext,
  `url` tinytext,
  `email` tinytext,
  `begin` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `head` tinytext,
  `deck` mediumblob,
  `body` mediumblob,
  `notes` mediumblob,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `objects`
--

LOCK TABLES `objects` WRITE;
/*!40000 ALTER TABLE `objects` DISABLE KEYS */;
INSERT INTO `objects` VALUES (1,1,'2021-01-16 07:09:17','2021-01-16 10:32:06',5,'Upcoming',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'upcoming',NULL,NULL,NULL,NULL,NULL,_binary '\r\n																								',_binary '\r\n																								',_binary '\r\n																								'),(2,1,'2021-01-16 07:09:26','2021-01-16 10:32:16',10,'Archive',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'archive',NULL,NULL,NULL,NULL,NULL,_binary '\r\n																								',_binary '\r\n																								',_binary '\r\n																								'),(3,1,'2021-01-16 07:11:40','2021-01-16 10:32:30',15,'Artist Index',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'artist-index',NULL,NULL,NULL,NULL,NULL,_binary '\r\n																								',_binary '\r\n																								',_binary '\r\n																								'),(4,1,'2021-01-16 07:11:54','2021-01-16 10:32:37',20,'About',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'about',NULL,NULL,NULL,NULL,NULL,_binary '\r\n																								',_binary '\r\n																								',_binary '\r\n																								'),(5,1,'2021-01-16 07:12:01','2021-01-16 07:12:01',NULL,'.Resource',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'resource',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(6,1,'2021-01-16 08:24:02','2021-01-17 02:16:54',NULL,'WeiTest weitest-1 WeiTest weitest-1 WeiTest weitest-1 WeiTest weitest-1WeiTest weitest-1 WeiTest weitest-1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'weitest-1',NULL,'2021-02-01 18:00:00',NULL,NULL,NULL,_binary '\r\n																								\r\n																								\r\n																								',_binary '\r\n																								\r\n																								\r\n																								',_binary '\r\n																								\r\n																								\r\n																								'),(7,1,'2021-01-16 08:24:13','2021-01-17 03:38:23',NULL,'weitest-2weitest-2 weitest-2weitest-2',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'weitest-2',NULL,'2021-02-02 18:30:00',NULL,NULL,NULL,_binary '\r\n																								\r\n																								\r\n																								\r\n																								\r\n																								\r\n																								\r\n																								',_binary '\r\n																								\r\n																								\r\n																								\r\n																								\r\n																								\r\n																								\r\n																								',_binary '\r\n																								\r\n																								\r\n																								\r\n																								\r\n																								\r\n																								\r\n																								'),(8,1,'2021-01-16 08:24:29','2021-01-17 02:17:54',NULL,'weitest-3',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'weitest-3',NULL,'2021-02-03 19:00:00',NULL,NULL,NULL,_binary '\r\n																								',_binary '\r\n																								',_binary '\r\n																								'),(9,1,'2021-01-16 08:24:48','2021-01-16 08:28:35',NULL,'.weitest-4',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'weitest-4',NULL,'2021-02-04 19:30:00',NULL,NULL,NULL,_binary '\r\n																								',_binary '\r\n																								',_binary '\r\n																								'),(10,1,'2021-01-16 08:25:19','2021-01-16 08:25:19',NULL,'weitest-5',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'weitest-5',NULL,'2022-02-01 18:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(11,1,'2021-01-16 10:16:27','2021-01-16 10:27:32',NULL,'.weitest-6',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'weitest-6',NULL,'2021-06-22 19:00:00',NULL,NULL,NULL,_binary '\r\n																								',_binary '\r\n																								',_binary '\r\n																								'),(12,1,'2021-01-17 00:38:45','2021-01-17 00:38:45',NULL,'weitest-7',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'weitest-7',NULL,'2020-12-25 00:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(13,1,'2021-01-17 00:39:06','2021-01-17 00:39:06',NULL,'weitest-8',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'weitest-8',NULL,'2020-12-24 17:00:00',NULL,NULL,NULL,NULL,NULL,NULL),(14,1,'2021-01-17 00:39:42','2021-01-17 03:39:45',NULL,'weitest-9 weitest-9 weitest-9weitest-9 weitest-9weitest-9weitest-9',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'weitest-9',NULL,'2020-12-23 18:00:00',NULL,NULL,NULL,_binary '\r\n																								\r\n																								\r\n																								',_binary '\r\n																								\r\n																								\r\n																								',_binary '\r\n																								\r\n																								\r\n																								'),(15,1,'2021-01-17 00:39:59','2021-01-17 03:39:27',NULL,'weitest-10 weitest-10weitest-10 weitest-10weitest-10 weitest-10',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'weitest-10',NULL,'2020-12-23 17:00:00',NULL,NULL,NULL,_binary '\r\n																								\r\n																								',_binary '\r\n																								\r\n																								',_binary '\r\n																								\r\n																								'),(16,1,'2021-01-17 00:40:16','2021-01-17 00:40:16',NULL,'.weitest-11',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'weitest-11',NULL,'2020-12-22 17:30:00',NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `objects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wires`
--

DROP TABLE IF EXISTS `wires`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wires` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `active` int(1) unsigned NOT NULL DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `fromid` int(10) unsigned DEFAULT NULL,
  `toid` int(10) unsigned DEFAULT NULL,
  `weight` float NOT NULL DEFAULT '1',
  `notes` blob,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wires`
--

LOCK TABLES `wires` WRITE;
/*!40000 ALTER TABLE `wires` DISABLE KEYS */;
INSERT INTO `wires` VALUES (1,1,'2021-01-16 07:09:17','2021-01-16 07:09:17',0,1,1,NULL),(2,1,'2021-01-16 07:09:26','2021-01-16 07:09:26',0,2,1,NULL),(3,1,'2021-01-16 07:11:40','2021-01-16 07:11:40',0,3,1,NULL),(4,1,'2021-01-16 07:11:54','2021-01-16 07:11:54',0,4,1,NULL),(5,1,'2021-01-16 07:12:01','2021-01-16 07:12:01',0,5,1,NULL),(6,1,'2021-01-16 08:24:02','2021-01-16 08:24:02',1,6,1,NULL),(7,1,'2021-01-16 08:24:13','2021-01-16 08:24:13',1,7,1,NULL),(8,1,'2021-01-16 08:24:29','2021-01-16 08:24:29',1,8,1,NULL),(9,1,'2021-01-16 08:24:48','2021-01-16 08:24:48',1,9,1,NULL),(10,1,'2021-01-16 08:25:19','2021-01-16 08:25:19',1,10,1,NULL),(11,1,'2021-01-16 10:16:27','2021-01-16 10:16:27',1,11,1,NULL),(12,1,'2021-01-17 00:38:45','2021-01-17 00:38:45',2,12,1,NULL),(13,1,'2021-01-17 00:39:06','2021-01-17 00:39:06',2,13,1,NULL),(14,1,'2021-01-17 00:39:42','2021-01-17 00:39:42',2,14,1,NULL),(15,1,'2021-01-17 00:39:59','2021-01-17 00:39:59',2,15,1,NULL),(16,1,'2021-01-17 00:40:16','2021-01-17 00:40:16',2,16,1,NULL);
/*!40000 ALTER TABLE `wires` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-01-17 18:14:57
