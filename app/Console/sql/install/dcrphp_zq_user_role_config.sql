-- MySQL dump 10.13  Distrib 8.0.16, for Win64 (x86_64)
--
-- Host: localhost    Database: zhanqqq11
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
-- Table structure for table `zq_user_role_config`
--

DROP TABLE IF EXISTS `zq_user_role_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `zq_user_role_config` (
  `urc_id` int(11) NOT NULL AUTO_INCREMENT,
  `urc_add_time` int(11) NOT NULL,
  `urc_update_time` int(11) NOT NULL,
  `urc_approval_status` tinyint(4) NOT NULL,
  `urc_add_user_id` smallint(6) NOT NULL,
  `zt_id` smallint(6) NOT NULL,
  `urc_u_id` int(11) DEFAULT NULL COMMENT '用户ID',
  `urc_r_id` int(11) DEFAULT NULL COMMENT '角色id',
  PRIMARY KEY (`urc_id`),
  UNIQUE KEY `uidx_ru` (`urc_u_id`,`urc_r_id`,`zt_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='用户的角色配置';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zq_user_role_config`
--

LOCK TABLES `zq_user_role_config` WRITE;
/*!40000 ALTER TABLE `zq_user_role_config` DISABLE KEYS */;
INSERT INTO `zq_user_role_config` VALUES (2,1583034614,1583034614,0,1,1,3,1),(3,1583034651,1583034651,0,1,1,2,2);
/*!40000 ALTER TABLE `zq_user_role_config` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-03-01 15:40:00
