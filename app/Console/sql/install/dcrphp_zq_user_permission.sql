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
  `up_add_time` int(11) NOT NULL,
  `up_update_time` int(11) NOT NULL,
  `up_approval_status` tinyint(4) NOT NULL,
  `up_add_user_id` smallint(6) NOT NULL,
  `zt_id` smallint(6) NOT NULL,
  `up_name` varchar(45) NOT NULL DEFAULT '权限名',
  `up_version` char(13) DEFAULT '版本名',
  PRIMARY KEY (`up_id`),
  UNIQUE KEY `uidx_name` (`up_name`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zq_user_permission`
--

LOCK TABLES `zq_user_permission` WRITE;
/*!40000 ALTER TABLE `zq_user_permission` DISABLE KEYS */;
INSERT INTO `zq_user_permission` VALUES (2,1584377145,1584436409,0,0,1,'/文章列表/添加编辑','5e7094b9867ca'),(3,1584377145,1584436409,0,0,1,'/文章列表/分类列表','5e7094b9867ca'),(4,1584377145,1584436409,0,0,1,'/系统工具/生成表结构','5e7094b9867ca'),(6,1584377145,1584436409,0,0,1,'/会员列表/会员添加','5e7094b9867ca'),(7,1584377145,1584436409,0,0,1,'/会员列表/角色编辑','5e7094b9867ca'),(9,1584436409,1584436409,0,0,1,'/文章列表','5e7094b9867ca'),(10,1584436409,1584436409,0,0,1,'/会员列表','5e7094b9867ca');
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

-- Dump completed on 2020-03-17 18:19:07
