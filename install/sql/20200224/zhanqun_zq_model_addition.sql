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
-- Table structure for table `zq_model_addition`
--

DROP TABLE IF EXISTS `zq_model_addition`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `zq_model_addition` (
  `ma_id` int(11) NOT NULL AUTO_INCREMENT,
  `ma_add_time` int(11) NOT NULL,
  `ma_update_time` int(11) NOT NULL,
  `ma_approval_status` tinyint(4) NOT NULL,
  `ma_add_user_id` smallint(6) NOT NULL,
  `zt_id` smallint(6) NOT NULL,
  `ma_keyword` text,
  `ma_description` text,
  `ma_content` text NOT NULL,
  `ma_ml_id` int(11) NOT NULL COMMENT 'ml表主键',
  PRIMARY KEY (`ma_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COMMENT='长字段表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zq_model_addition`
--

LOCK TABLES `zq_model_addition` WRITE;
/*!40000 ALTER TABLE `zq_model_addition` DISABLE KEYS */;
INSERT INTO `zq_model_addition` VALUES (1,1580916569,1580916569,0,29,1,'','','',7),(2,1580916674,1580916674,0,29,1,'','','',8),(3,1580916978,1580916978,0,29,1,'','','',9),(4,1580917030,1580917030,0,29,1,'','','',10),(5,1580917364,1580917364,0,29,1,'','','',11),(6,1580917440,1580917440,0,29,1,'','','<p>12321</p>',12),(7,1580917462,1580917462,0,29,1,'a','b','<p>12313</p>',13),(8,1581050115,1581050115,0,29,1,'','','<p>1</p>',14),(9,1581050144,1581050144,0,29,1,'','','<p>1</p>',15),(10,1581090139,1581090139,0,29,1,'','','<p>test<br/></p>',16),(11,1581090307,1581328135,0,29,1,'1','2','<p>test221111</p>',17),(13,1581091366,1581091366,0,29,1,'','','<p>sdfsdfsdfsd</p>',18),(16,1581091592,1581091592,0,29,1,'','','<p>21312</p>',19),(17,1581328221,1581328858,0,29,1,'1','2','<p>11111</p>',20),(18,1582338072,1582338072,0,29,1,'','','<p>test</p>',21),(19,1582356084,1582356084,0,29,1,'','','<p>asdfsdafdasf</p>',22),(20,1582356091,1582356091,0,29,1,'','','<p>sdfds3254543</p>',23);
/*!40000 ALTER TABLE `zq_model_addition` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-02-24 18:26:26
