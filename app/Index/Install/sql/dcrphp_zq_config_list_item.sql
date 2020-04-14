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
-- Table structure for table `zq_config_list_item`
--

DROP TABLE IF EXISTS `zq_config_list_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `zq_config_list_item` (
  `cli_id` int(11) NOT NULL AUTO_INCREMENT,
  `cli_add_time` int(11) NOT NULL DEFAULT '0',
  `cli_update_time` int(11) NOT NULL DEFAULT '0',
  `cli_approval_status` tinyint(4) NOT NULL DEFAULT '1',
  `cli_add_user_id` smallint(6) NOT NULL DEFAULT '0',
  `zt_id` smallint(6) NOT NULL DEFAULT '1',
  `cli_form_text` varchar(45) NOT NULL DEFAULT '',
  `cli_data_type` varchar(10) NOT NULL DEFAULT '',
  `cli_db_field_name` varchar(45) NOT NULL DEFAULT '',
  `cli_order` smallint(6) NOT NULL DEFAULT '1',
  `cli_default` varchar(45) NOT NULL DEFAULT '',
  `cli_is_system` tinyint(1) NOT NULL DEFAULT '0',
  `cli_cl_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cli_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='表配置item列表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zq_config_list_item`
--

LOCK TABLES `zq_config_list_item` WRITE;
/*!40000 ALTER TABLE `zq_config_list_item` DISABLE KEYS */;
INSERT INTO `zq_config_list_item` VALUES (1,1586860452,1586877666,1,1,1,'24321','radio','2432111',1,'1212',0,1),(3,1586878879,1586878879,1,1,1,'abc123','checkbox','213123',31,'12',0,1);
/*!40000 ALTER TABLE `zq_config_list_item` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-04-14 23:57:39