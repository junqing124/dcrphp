-- MySQL dump 10.13  Distrib 8.0.16, for Win64 (x86_64)
--
-- Host: localhost    Database: dcrphp
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zq_config_model`
--

LOCK TABLES `zq_config_model` WRITE;
/*!40000 ALTER TABLE `zq_config_model` DISABLE KEYS */;
INSERT INTO `zq_config_model` VALUES (1,1583047085,1583134927,0,1,1,'news_key','新闻点','news'),(2,1583047085,1583134927,0,1,1,'color','颜色','product'),(3,1583047085,1583134927,0,1,1,'caizhi','材质','product');
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

-- Dump completed on 2020-03-17 18:19:07
