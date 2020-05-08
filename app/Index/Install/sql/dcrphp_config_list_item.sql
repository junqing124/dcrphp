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
-- Table structure for table `config_list_item`
--

DROP TABLE IF EXISTS `config_list_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `config_list_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `add_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_approval` tinyint(1) NOT NULL DEFAULT '1',
  `add_user_id` smallint(6) NOT NULL DEFAULT '0',
  `zt_id` smallint(6) NOT NULL DEFAULT '1',
  `form_text` varchar(45) NOT NULL DEFAULT '',
  `data_type` varchar(10) NOT NULL DEFAULT '',
  `db_field_name` varchar(45) NOT NULL DEFAULT '',
  `order_str` smallint(6) NOT NULL DEFAULT '1',
  `default_str` varchar(45) NOT NULL DEFAULT '',
  `is_system` tinyint(1) NOT NULL DEFAULT '0',
  `cl_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='表配置item列表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `config_list_item`
--

LOCK TABLES `config_list_item` WRITE;
/*!40000 ALTER TABLE `config_list_item` DISABLE KEYS */;
INSERT INTO `config_list_item` VALUES (1,'0000-00-00 00:00:00','0000-00-00 00:00:00',1,1,1,'网站名','string','site_name',1,'',1,1),(4,'0000-00-00 00:00:00','0000-00-00 00:00:00',1,1,1,'模板名','select','template_name',1,'var.systemTemplateStr',1,2),(5,'0000-00-00 00:00:00','0000-00-00 00:00:00',1,1,1,'材质','string','material',1,'',0,4),(6,'0000-00-00 00:00:00','0000-00-00 00:00:00',1,1,1,'颜色','string','color',2,'',0,4),(7,'0000-00-00 00:00:00','0000-00-00 00:00:00',1,1,1,'产地','select','from',3,'江西,浙江',0,4);
/*!40000 ALTER TABLE `config_list_item` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-05-08 21:19:51
