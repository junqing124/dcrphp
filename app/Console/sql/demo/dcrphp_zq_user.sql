-- MySQL dump 10.13  Distrib 8.0.16, for Win64 (x86_64)
--
-- Host: localhost    Database: zhanqqq124
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
-- Table structure for table `zq_user`
--

DROP TABLE IF EXISTS `zq_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `zq_user` (
  `u_id` int(11) NOT NULL AUTO_INCREMENT,
  `u_username` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
  `u_name` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
  `u_password` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
  `zt_id` smallint(5) DEFAULT NULL,
  `u_add_time` int(11) DEFAULT NULL,
  `u_update_time` int(11) DEFAULT NULL,
  `u_login_ip` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
  `u_login_count` smallint(5) DEFAULT '0',
  `u_login_time` int(11) DEFAULT NULL,
  `u_is_valid` tinyint(4) DEFAULT '1',
  `u_sex` tinyint(1) DEFAULT NULL,
  `u_mobile` varchar(45) DEFAULT NULL,
  `u_tel` varchar(45) DEFAULT NULL,
  `u_note` varchar(100) DEFAULT NULL,
  `u_add_user_id` smallint(5) DEFAULT NULL COMMENT '添加人id',
  `u_edit_user_id` smallint(5) DEFAULT NULL,
  PRIMARY KEY (`u_id`),
  UNIQUE KEY `uidx_uz` (`u_username`,`zt_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COMMENT='用户表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zq_user`
--

LOCK TABLES `zq_user` WRITE;
/*!40000 ALTER TABLE `zq_user` DISABLE KEYS */;
INSERT INTO `zq_user` VALUES (1,'admin',NULL,'dcJ49.bznhA7c',1,1583134320,1583134320,'unknown',2,1583398290,1,1,'15718126135','','管理员',0,NULL),(2,'张三',NULL,'',1,1583034580,1583034651,NULL,0,NULL,1,1,'15718126135','','测试用户1',1,1),(3,'李四',NULL,'dciMMVvAhRqFk',1,1583034614,1583034614,NULL,0,NULL,1,2,'15718126135','8420124','',1,NULL);
/*!40000 ALTER TABLE `zq_user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-03-08 22:26:54
