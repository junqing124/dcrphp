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
-- Table structure for table `config_table_edit_item`
--

DROP TABLE IF EXISTS `config_table_edit_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `config_table_edit_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `add_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_approval` tinyint(1) NOT NULL DEFAULT '1',
  `add_user_id` smallint(6) NOT NULL DEFAULT '0',
  `zt_id` smallint(6) NOT NULL DEFAULT '1',
  `is_input_hidden` tinyint(1) NOT NULL DEFAULT '0',
  `default_str` varchar(200) NOT NULL DEFAULT '',
  `is_update_required` tinyint(1) NOT NULL DEFAULT '0',
  `is_update` tinyint(1) NOT NULL DEFAULT '0',
  `is_insert_required` tinyint(1) NOT NULL DEFAULT '0',
  `tip` varchar(200) NOT NULL DEFAULT '0',
  `is_insert` tinyint(1) NOT NULL DEFAULT '0',
  `search_type` varchar(10) NOT NULL DEFAULT '',
  `is_search` tinyint(1) NOT NULL DEFAULT '0',
  `is_show_list` tinyint(1) NOT NULL DEFAULT '0',
  `data_type` varchar(45) NOT NULL DEFAULT '',
  `title` varchar(45) NOT NULL DEFAULT '',
  `db_field_name` varchar(45) NOT NULL DEFAULT '',
  `ctel_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uidx_db_ctel_id` (`db_field_name`,`ctel_id`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8 COMMENT='单表配置字段';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `config_table_edit_item`
--

LOCK TABLES `config_table_edit_item` WRITE;
/*!40000 ALTER TABLE `config_table_edit_item` DISABLE KEYS */;
INSERT INTO `config_table_edit_item` VALUES (11,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'',0,1,0,'',0,'',0,1,'string','ID','id',2),(17,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,1,'',0,1,0,'',1,'',0,0,'string','父表ID','ctel_id',2),(18,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'',0,1,0,'小写英文字母开头，只能小写英文及数字',1,'like',1,1,'string','字段名','db_field_name',2),(19,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'',0,1,0,'',0,'like',1,1,'string','标题','title',2),(20,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'',0,1,0,'',1,'',0,1,'string','数据类型','data_type',2),(21,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'是',0,1,0,'',1,'',0,1,'checkbox','列表中显示','is_show_list',2),(22,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'是',0,1,0,'',1,'',0,1,'checkbox','列表中能搜索','is_search',2),(23,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'是',0,1,0,'',1,'',0,1,'checkbox','能添加','is_insert',2),(24,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'是',0,1,0,'',1,'',0,0,'checkbox','添加必填','is_insert_required',2),(25,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'是',0,1,0,'',1,'',0,0,'checkbox','能更新','is_update',2),(26,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'是',0,1,0,'',1,'',0,0,'checkbox','更新必填','is_update_required',2),(27,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'是',0,1,0,'编辑页面类型为hidden',1,'',0,0,'checkbox','input hidden','is_input_hidden',2),(28,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'like,like_left,like_right,equal',0,1,0,'',1,'',0,0,'select','搜索类型','search_type',2),(29,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'',0,1,0,'',1,'',0,0,'string','提示','tip',2),(30,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'',0,1,0,'',1,'',0,0,'string','默认值','default_str',2),(33,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'',0,0,0,'',0,'',0,1,'string','ID','id',1),(34,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'',1,1,1,'',1,'',1,1,'string','关键字','keyword',1),(35,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'',1,1,1,'',1,'like',1,1,'string','页面标题','page_title',1),(36,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'',1,1,1,'',1,'like',1,1,'string','模块名','page_model',1),(37,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'',0,1,0,'',0,'like',0,0,'string','表名','table_name',1),(40,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'是',0,1,0,'',1,'',0,1,'checkbox','允许删除','is_del',1),(41,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'是',0,1,0,'',1,'',0,1,'checkbox','允许添加','is_add',1),(42,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'是',0,1,0,'',1,'',0,1,'checkbox','允许编辑','is_edit',1),(43,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'',0,1,0,'',0,'',0,0,'string','排序','list_order',1),(44,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'',0,1,0,'',0,'',0,0,'string','where','list_where',1),(45,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'',0,1,0,'添加或编辑弹出的窗口的宽以px或%结尾',0,'',0,0,'string','编辑窗口宽','edit_window_width',1),(46,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'',0,1,0,'添加或编辑弹出的窗口的高以px或%结尾	',0,'',0,0,'string','编辑窗口高','edit_window_height',1),(47,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'',0,1,0,'',0,'',0,0,'text','操作列自定义额外html','addition_option_html',1),(48,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'',0,1,0,'配置字段允许哪些使用可以外部传入的变量，用,分隔字段。比如想通过get post配置list_order额外配置，请访问 ip/admin/tools/table-edit-list-view/zq_user?list_order=u_id,那么实际使用的list_order=list_order配置和get(',0,'',0,0,'string','允许使用外部变量','allow_config_from_request',1),(50,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'',0,1,0,'添加页面form额外的html',0,'',0,0,'text','添加页面form额外的html','add_page_addition_html',1),(51,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'',0,1,0,'编辑页面form额外的html',0,'',0,0,'text','编辑页面form额外的html','edit_page_addition_html',1),(52,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'',0,1,0,'列表里添加按钮拼接html',0,'',0,0,'text','列表添加按钮拼接html','add_button_addition_html',1),(53,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'',0,1,0,'列表里编辑按钮拼接html',0,'',0,0,'text','列表里编辑按钮拼接html','edit_button_addition_html',1),(54,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,1,'',0,0,0,'',0,'',0,0,'string','ID','id',3),(55,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'',0,0,0,'',0,'like',1,1,'string','用户名','username',3),(56,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'',0,1,0,'',0,'like',1,1,'string','电话','mobile',3),(57,'2020-05-07 17:05:19','2020-05-07 17:05:18',1,1,1,0,'',0,1,0,'列表按钮区额外html',1,'',0,0,'text','列表按钮区额外html','button_area_addition_html',1);
/*!40000 ALTER TABLE `config_table_edit_item` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-05-12 12:14:05
