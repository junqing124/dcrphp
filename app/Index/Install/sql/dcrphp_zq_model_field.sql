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
-- Table structure for table `zq_model_field`
--

DROP TABLE IF EXISTS `zq_model_field`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `zq_model_field` (
  `mf_id` int(11) NOT NULL AUTO_INCREMENT,
  `mf_add_time` int(11) NOT NULL DEFAULT '0',
  `mf_update_time` int(11) NOT NULL DEFAULT '0',
  `mf_approval_status` tinyint(4) NOT NULL DEFAULT '1',
  `mf_add_user_id` smallint(6) NOT NULL DEFAULT '0',
  `zt_id` smallint(6) NOT NULL DEFAULT '1',
  `mf_key` varchar(45) NOT NULL DEFAULT '',
  `mf_value` varchar(200) NOT NULL DEFAULT '',
  `mf_ml_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`mf_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COMMENT='模型字段里的值';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zq_model_field`
--

LOCK TABLES `zq_model_field` WRITE;
/*!40000 ALTER TABLE `zq_model_field` DISABLE KEYS */;
/*!40000 ALTER TABLE `zq_model_field` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-04-29  0:14:47
