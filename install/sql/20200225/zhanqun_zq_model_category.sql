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
-- Table structure for table `zq_model_category`
--

DROP TABLE IF EXISTS `zq_model_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `zq_model_category` (
  `mc_id` int(11) NOT NULL AUTO_INCREMENT,
  `mc_add_time` int(11) NOT NULL,
  `mc_update_time` int(11) NOT NULL,
  `mc_approval_status` tinyint(4) NOT NULL,
  `mc_add_user_id` smallint(6) NOT NULL,
  `zt_id` smallint(6) NOT NULL,
  `mc_model_name` varchar(45) DEFAULT NULL,
  `mc_name` varchar(45) DEFAULT NULL,
  `mc_parent_id` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`mc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zq_model_category`
--

LOCK TABLES `zq_model_category` WRITE;
/*!40000 ALTER TABLE `zq_model_category` DISABLE KEYS */;
INSERT INTO `zq_model_category` VALUES (1,1580389049,1580389049,0,29,1,'news','a1',0),(4,1580483296,1580545531,0,29,1,'news','a2',1),(10,1580546163,1580546163,0,29,1,'news','a3',4),(12,1580614810,1580614810,0,29,1,'news','b1',0),(13,1580614816,1580614816,0,29,1,'news','b2',12),(14,1580649228,1580649228,0,29,1,'product','p1',0),(15,1580649235,1580649235,0,29,1,'product','q1',0),(16,1580649241,1580649241,0,29,1,'product','q2',15),(21,1582336950,1582336950,0,29,1,'help','牛蛙',0),(24,1582337427,1582337427,0,29,1,'help','蝌蚪',0),(25,1582337437,1582354292,0,29,1,'help','帮助中心',0),(26,1582337449,1582337449,0,29,1,'help','销售',21),(27,1582337488,1582337488,0,29,1,'help','采购',21),(28,1582337758,1582337758,0,29,1,'help','开发',21),(29,1582363627,1582363627,0,29,1,'help','基础',25);
/*!40000 ALTER TABLE `zq_model_category` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-02-25 11:10:29
