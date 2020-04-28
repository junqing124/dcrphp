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
-- Table structure for table `zq_config_list`
--

DROP TABLE IF EXISTS `zq_config_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `zq_config_list` (
  `cl_id` int(11) NOT NULL AUTO_INCREMENT,
  `cl_add_time` int(11) NOT NULL DEFAULT '0',
  `cl_update_time` int(11) NOT NULL DEFAULT '0',
  `cl_approval_status` tinyint(4) NOT NULL DEFAULT '1',
  `cl_add_user_id` smallint(6) NOT NULL DEFAULT '0',
  `zt_id` smallint(6) NOT NULL DEFAULT '1',
  `cl_name` varchar(45) NOT NULL DEFAULT '',
  `cl_is_system` tinyint(4) NOT NULL DEFAULT '0',
  `cl_type` varchar(45) NOT NULL DEFAULT '' COMMENT '类型 配置还是模型(config or model)',
  `cl_key` varchar(45) NOT NULL DEFAULT '' COMMENT '关键字，可以用来给列表做区别',
  PRIMARY KEY (`cl_id`),
  UNIQUE KEY `uidx_name` (`cl_name`,`zt_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='配置项列表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zq_config_list`
--

LOCK TABLES `zq_config_list` WRITE;
/*!40000 ALTER TABLE `zq_config_list` DISABLE KEYS */;
INSERT INTO `zq_config_list` VALUES (1,1586603908,1586603908,1,1,1,'基本配置',1,'config','base'),(2,1586603908,1586603908,1,1,1,'模板配置',1,'config','template'),(3,1587915103,1587918070,1,1,1,'新闻中心',0,'model','news'),(4,1587915114,1587915114,1,1,1,'产品中心',0,'model','product'),(5,1587915122,1587915122,1,1,1,'资料中心',0,'model','info');
/*!40000 ALTER TABLE `zq_config_list` ENABLE KEYS */;
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
