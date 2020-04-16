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
-- Table structure for table `zq_config`
--

DROP TABLE IF EXISTS `zq_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `zq_config` (
  `c_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_add_time` int(11) NOT NULL DEFAULT '0',
  `c_update_time` int(11) NOT NULL DEFAULT '0',
  `c_approval_status` tinyint(4) NOT NULL DEFAULT '1',
  `c_add_user_id` smallint(6) NOT NULL DEFAULT '0',
  `zt_id` smallint(6) NOT NULL DEFAULT '1',
  `c_db_field_name` varchar(45) NOT NULL DEFAULT '' COMMENT '字段名',
  `c_value` varchar(45) NOT NULL DEFAULT '' COMMENT '字段值',
  `c_cl_id` int(11) NOT NULL DEFAULT '0' COMMENT '配置列表id',
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='基本配置';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zq_config`
--

LOCK TABLES `zq_config` WRITE;
/*!40000 ALTER TABLE `zq_config` DISABLE KEYS */;
INSERT INTO `zq_config` VALUES (1,1587050159,1587050174,1,1,1,'site_name','DcrPHP建站系统11',1),(2,1587050159,1587050174,1,1,1,'213123','12',1),(3,1587050182,1587050367,1,1,1,'template_name','default',2);
/*!40000 ALTER TABLE `zq_config` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-04-16 23:19:43
