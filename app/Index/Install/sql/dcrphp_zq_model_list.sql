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
-- Table structure for table `zq_model_list`
--

DROP TABLE IF EXISTS `zq_model_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `zq_model_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `add_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  `is_approval` tinyint(1) NOT NULL DEFAULT '1',
  `add_user_id` smallint(6) NOT NULL DEFAULT '0',
  `zt_id` smallint(6) NOT NULL DEFAULT '1',
  `title` varchar(150) NOT NULL,
  `pic_path` varchar(150) NOT NULL DEFAULT '',
  `category_id` smallint(5) NOT NULL DEFAULT '0',
  `model_name` varchar(45) NOT NULL DEFAULT '',
  `view_nums` int(11) NOT NULL DEFAULT '0' COMMENT '浏览次数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zq_model_list`
--

LOCK TABLES `zq_model_list` WRITE;
/*!40000 ALTER TABLE `zq_model_list` DISABLE KEYS */;
INSERT INTO `zq_model_list` VALUES (1,1583047462,1583724318,0,1,1,'dcrphp简要说明','',1,'news',3),(2,1583047567,1583724305,0,1,1,'文档中心','',1,'news',15),(3,1583047863,1583723943,0,1,1,'影响亚马逊广告展示的主要因素有哪些？','',3,'news',6),(4,1583047943,1583723880,0,1,1,'站内广告优化策略：ACOS应该这样解读才合适','',3,'news',20),(5,1583048162,1583723218,0,1,1,'关于我们','',8,'info',20),(6,1583048197,1583722771,0,1,1,'联系我们','',8,'info',14),(7,1583569887,1583569887,0,1,1,'学校类模板','',9,'product',0),(8,1583569901,1583569901,0,1,1,'企业类模板','',9,'product',0),(9,1583569917,1583569917,0,1,1,'电商类模板','',9,'product',0),(10,1583569929,1583569929,0,1,1,'科技类模板','',9,'product',1),(11,1583569942,1587984062,0,1,1,'化工类模板','',9,'product',7);
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

-- Dump completed on 2020-05-02 12:52:37
