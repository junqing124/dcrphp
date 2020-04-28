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
-- Table structure for table `zq_config_table_edit_list`
--

DROP TABLE IF EXISTS `zq_config_table_edit_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `zq_config_table_edit_list` (
  `ctel_id` int(11) NOT NULL AUTO_INCREMENT,
  `ctel_add_time` int(11) NOT NULL DEFAULT '0',
  `ctel_update_time` int(11) NOT NULL DEFAULT '0',
  `ctel_approval_status` tinyint(4) NOT NULL DEFAULT '1',
  `ctel_add_user_id` smallint(6) NOT NULL DEFAULT '0',
  `zt_id` smallint(6) NOT NULL DEFAULT '1',
  `ctel_key` varchar(45) NOT NULL,
  `ctel_page_title` varchar(45) NOT NULL,
  `ctel_page_model` varchar(45) NOT NULL,
  `ctel_table_name` varchar(45) NOT NULL,
  `ctel_index_id` varchar(45) NOT NULL,
  `ctel_table_pre` varchar(45) NOT NULL,
  `ctel_is_del` varchar(45) NOT NULL DEFAULT '是',
  `ctel_is_add` varchar(45) NOT NULL DEFAULT '是',
  `ctel_is_edit` varchar(45) NOT NULL DEFAULT '是',
  `ctel_list_order` varchar(45) NOT NULL,
  `ctel_list_where` varchar(45) NOT NULL,
  `ctel_edit_window_width` varchar(45) NOT NULL,
  `ctel_edit_window_height` varchar(45) NOT NULL DEFAULT '',
  PRIMARY KEY (`ctel_id`),
  UNIQUE KEY `uidx_key` (`ctel_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='单表配置列表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zq_config_table_edit_list`
--

LOCK TABLES `zq_config_table_edit_list` WRITE;
/*!40000 ALTER TABLE `zq_config_table_edit_list` DISABLE KEYS */;
/*!40000 ALTER TABLE `zq_config_table_edit_list` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-04-29  0:14:48
