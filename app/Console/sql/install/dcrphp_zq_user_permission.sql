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
-- Table structure for table `zq_user_permission`
--

DROP TABLE IF EXISTS `zq_user_permission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `zq_user_permission` (
  `up_id` int(11) NOT NULL AUTO_INCREMENT,
  `up_add_time` int(11) NOT NULL DEFAULT '0',
  `up_update_time` int(11) NOT NULL DEFAULT '0',
  `up_approval_status` tinyint(4) NOT NULL DEFAULT '1',
  `up_add_user_id` smallint(6) NOT NULL DEFAULT '0',
  `zt_id` smallint(6) NOT NULL DEFAULT '1',
  `up_name` varchar(45) NOT NULL DEFAULT '' COMMENT '权限名',
  `up_version` char(13) NOT NULL DEFAULT '' COMMENT '版本名',
  PRIMARY KEY (`up_id`),
  UNIQUE KEY `uidx_name` (`up_name`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zq_user_permission`
--

LOCK TABLES `zq_user_permission` WRITE;
/*!40000 ALTER TABLE `zq_user_permission` DISABLE KEYS */;
INSERT INTO `zq_user_permission` VALUES (2,1584377145,1584520992,0,0,1,'/文章列表/添加编辑','5e71df208cefb'),(3,1584377145,1584520992,0,0,1,'/文章列表/分类列表','5e71df208cefb'),(9,1584436409,1584520992,0,0,1,'/文章列表','5e71df208cefb'),(12,1584517759,1584520992,0,0,1,'/会员管理','5e71df208cefb'),(13,1584517759,1584520992,0,0,1,'/会员管理/会员添加','5e71df208cefb'),(14,1584517759,1584520992,0,0,1,'/会员管理/角色编辑','5e71df208cefb'),(15,1584517759,1584520992,0,0,1,'/会员管理/权限列表','5e71df208cefb'),(16,1584520602,1584520992,0,0,1,'/系统工具','5e71df208cefb'),(17,1584520992,1584520992,0,0,1,'/系统配置','5e71df208cefb');
/*!40000 ALTER TABLE `zq_user_permission` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-04-01 17:54:12
