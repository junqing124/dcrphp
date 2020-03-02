-- MySQL dump 10.13  Distrib 8.0.16, for Win64 (x86_64)
--
-- Host: localhost    Database: zhanqqq123
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zq_model_list`
--

LOCK TABLES `zq_model_list` WRITE;
/*!40000 ALTER TABLE `zq_model_list` DISABLE KEYS */;
INSERT  IGNORE INTO `zq_model_list` VALUES (1,1583047462,1583047764,0,1,1,'dcrphp系统说明',NULL,7,'news',0),(2,1583047567,1583047758,0,1,1,'文档中心',NULL,6,'news',0),(3,1583047863,1583047863,0,1,1,'影响亚马逊广告展示的主要因素有哪些？',NULL,4,'news',0),(4,1583047943,1583047943,0,1,1,'站内广告优化策略：ACOS应该这样解读才合适',NULL,4,'news',0),(5,1583048162,1583048162,0,1,1,'关于我们',NULL,8,'info',0),(6,1583048197,1583048197,0,1,1,'联系我们',NULL,8,'info',0);
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

-- Dump completed on 2020-03-02 15:05:27
