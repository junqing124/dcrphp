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
  `ml_view_nums` int(11) DEFAULT '0' COMMENT '浏览次数',
  PRIMARY KEY (`ml_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zq_model_list`
--

LOCK TABLES `zq_model_list` WRITE;
/*!40000 ALTER TABLE `zq_model_list` DISABLE KEYS */;
INSERT INTO `zq_model_list` VALUES (1,0,1580915764,0,29,1,'1','',10,'news',1),(2,0,1580915823,0,29,1,'1','',10,'news',0),(3,0,1580915854,0,29,1,'1','',10,'news',0),(4,1580915910,1580915910,0,29,1,'1','',10,'news',0),(7,1580916569,1580916569,0,29,1,'1','',10,'news',1),(8,1580916674,1580916674,0,29,1,'1','',10,'news',0),(9,1580916978,1580916978,0,29,1,'1','',10,'news',0),(10,1580917030,1580917030,0,29,1,'1','',13,'news',0),(11,1580917364,1580917364,0,29,1,'1','',13,'news',1),(12,1580917440,1580917440,0,29,1,'1','',10,'news',1),(13,1580917462,1580917462,0,29,1,'12312','',10,'news',0),(14,1581050115,1581050115,0,29,1,'1','uploads\\2020-02-07\\15810501155e3ce90376020.png',16,'news',1),(15,1581050144,1581050144,0,29,1,'1','uploads\\2020-02-07\\15810501445e3ce9205d218.png',10,'product',2),(16,1581090139,1581090139,0,29,1,'test','uploads\\2020-02-07\\15810901395e3d855b42499.png',13,'news',4),(17,1581090307,1581328135,0,29,1,'1231211','uploads\\2020-02-10\\15813281315e412703f3754.gif',13,'news',1),(18,1581091366,1581091366,0,29,1,'fdsfs','uploads\\2020-02-08\\15810913665e3d8a26a8589.png',16,'product',4),(19,1581091592,1581091592,0,29,1,'21312','',14,'product',0),(20,1581328221,1581328858,0,29,1,'11','uploads\\2020-02-10\\15813282215e41275d5ae41.png',16,'product',3),(21,1582338072,1582338072,0,29,1,'test',NULL,26,'help',8),(22,1582356084,1582356084,0,29,1,'dsfdsfsd',NULL,26,'help',9),(23,1582356091,1582356091,0,29,1,'sdfdsfdsf',NULL,26,'help',41);
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

-- Dump completed on 2020-02-25 11:10:28
