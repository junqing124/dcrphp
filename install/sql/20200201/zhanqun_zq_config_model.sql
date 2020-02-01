-- MySQL dump 10.13  Distrib 8.0.16, for Win64 (x86_64)
--
-- Host: localhost    Database: zhanqun
-- ------------------------------------------------------
-- Server version	5.7.24

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
 SET NAMES utf8 ;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `zq_config_model`
--

DROP TABLE IF EXISTS `zq_config_model`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `zq_config_model` (
  `cm_id` int(11) NOT NULL AUTO_INCREMENT,
  `cm_add_time` int(11) NOT NULL,
  `cm_update_time` int(11) NOT NULL,
  `cm_approval_status` tinyint(4) NOT NULL,
  `cm_add_user_id` smallint(6) NOT NULL,
  `zt_id` smallint(6) NOT NULL,
  `cm_key` varchar(45) DEFAULT NULL,
  `cm_dec` varchar(45) DEFAULT NULL,
  `cm_model_name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`cm_id`),
  UNIQUE KEY `uidx_mk` (`cm_model_name`,`cm_key`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zq_config_model`
--

LOCK TABLES `zq_config_model` WRITE;
/*!40000 ALTER TABLE `zq_config_model` DISABLE KEYS */;
INSERT INTO `zq_config_model` VALUES (4,1580140310,1580309758,0,29,1,'pk1','p1','product'),(6,1580140310,1580309758,0,29,1,'','','info'),(7,1580140392,1580309758,0,29,1,'pk3','p3','product'),(10,1580215091,1580309758,0,29,1,'pk4','p3','product'),(11,1580306832,1580309758,0,29,1,'b','a','news'),(12,1580306845,1580309758,0,29,1,'c','a','news'),(13,1580306856,1580309758,0,29,1,'d','d','news'),(14,1580307683,1580309758,0,29,1,'e','e','news');
/*!40000 ALTER TABLE `zq_config_model` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-02-01 16:36:57
