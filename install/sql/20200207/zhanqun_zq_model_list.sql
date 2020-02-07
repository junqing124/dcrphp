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
-- Table structure for table `zq_model_list`
--

DROP TABLE IF EXISTS `zq_model_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `zq_model_list` (
  `ml_id` int(11) NOT NULL AUTO_INCREMENT,
  `ml_add_time` int(11) NOT NULL,
  `ml_update_time` int(11) NOT NULL,
  `ml_approval_status` tinyint(4) NOT NULL,
  `ml_add_user_id` smallint(6) NOT NULL,
  `zt_id` smallint(6) NOT NULL,
  `ml_title` varchar(150) NOT NULL,
  `ml_pic_path` varchar(150) DEFAULT NULL,
  `ml_category_id` smallint(5) NOT NULL,
  `ml_model_name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`ml_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zq_model_list`
--

LOCK TABLES `zq_model_list` WRITE;
/*!40000 ALTER TABLE `zq_model_list` DISABLE KEYS */;
INSERT INTO `zq_model_list` VALUES (1,0,1580915764,0,29,1,'1','',10,'news'),(2,0,1580915823,0,29,1,'1','',10,'news'),(3,0,1580915854,0,29,1,'1','',10,'news'),(4,1580915910,1580915910,0,29,1,'1','',10,'news'),(7,1580916569,1580916569,0,29,1,'1','',10,'news'),(8,1580916674,1580916674,0,29,1,'1','',10,'news'),(9,1580916978,1580916978,0,29,1,'1','',10,'news'),(10,1580917030,1580917030,0,29,1,'1','',13,'news'),(11,1580917364,1580917364,0,29,1,'1','',13,'news'),(12,1580917440,1580917440,0,29,1,'1','',10,'news'),(13,1580917462,1580917462,0,29,1,'12312','',10,'news'),(14,1581050115,1581050115,0,29,1,'1','uploads\\2020-02-07\\15810501155e3ce90376020.png',10,'news'),(15,1581050144,1581050144,0,29,1,'1','uploads\\2020-02-07\\15810501445e3ce9205d218.png',10,'product'),(16,1581090139,1581090139,0,29,1,'test','uploads\\2020-02-07\\15810901395e3d855b42499.png',13,'news'),(17,1581090307,1581090307,0,29,1,'123','uploads\\2020-02-07\\15810903075e3d8603e1f95.jpg',13,'news');
/*!40000 ALTER TABLE `zq_model_list` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-02-07 23:58:46
