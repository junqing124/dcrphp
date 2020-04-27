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
-- Table structure for table `zq_plugins`
--

DROP TABLE IF EXISTS `zq_plugins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `zq_plugins` (
  `p_id` int(11) NOT NULL AUTO_INCREMENT,
  `p_add_time` int(11) NOT NULL DEFAULT '0',
  `p_update_time` int(11) NOT NULL DEFAULT '0',
  `p_approval_status` tinyint(4) NOT NULL DEFAULT '1',
  `p_add_user_id` smallint(6) NOT NULL DEFAULT '0',
  `zt_id` smallint(6) NOT NULL DEFAULT '1',
  `p_name` varchar(45) NOT NULL DEFAULT '',
  `p_description` varchar(100) NOT NULL DEFAULT '',
  `p_is_valid` tinyint(1) NOT NULL DEFAULT '1',
  `p_author` varchar(45) NOT NULL DEFAULT '',
  `p_version` varchar(45) NOT NULL DEFAULT '',
  `p_title` varchar(45) NOT NULL DEFAULT '',
  PRIMARY KEY (`p_id`),
  UNIQUE KEY `uidx_name` (`p_name`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zq_plugins`
--

LOCK TABLES `zq_plugins` WRITE;
/*!40000 ALTER TABLE `zq_plugins` DISABLE KEYS */;
INSERT INTO `zq_plugins` VALUES (10,1585734408,1585734408,1,0,1,'DbBackup','数据库备份',1,'dcr','1.0.1','数据库备份'),(11,1585734793,1585734793,1,0,1,'TableGeneral','用于生成指定表的表结构',1,'dcr','1.0.1','生成表结构');
/*!40000 ALTER TABLE `zq_plugins` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-04-27 23:08:22
