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
) ENGINE=InnoDB AUTO_INCREMENT=136 DEFAULT CHARSET=utf8 COMMENT='单表配置字段';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `config_table_edit_item`
--

LOCK TABLES `config_table_edit_item` WRITE;
/*!40000 ALTER TABLE `config_table_edit_item` DISABLE KEYS */;
INSERT INTO `config_table_edit_item` VALUES (11,'0000-00-00 00:00:00','2020-05-07 10:04:44',1,1,1,0,'',0,1,0,'',0,'',0,1,'string','ID','id',2),(17,'0000-00-00 00:00:00','2020-05-07 10:20:25',1,1,1,1,'',0,1,0,'',1,'',0,0,'string','父表ID','ctel_id',2),(18,'0000-00-00 00:00:00','2020-05-07 10:05:10',1,1,1,0,'',0,1,0,'小写英文字母开头，只能小写英文及数字',1,'like',1,1,'string','字段名','db_field_name',2),(19,'0000-00-00 00:00:00','2020-05-07 10:19:17',1,1,1,0,'',0,1,0,'',0,'like',1,1,'string','标题','title',2),(20,'0000-00-00 00:00:00','2020-05-07 10:20:42',1,1,1,0,'',0,1,0,'',1,'',0,1,'string','数据类型','data_type',2),(21,'0000-00-00 00:00:00','2020-05-07 10:19:45',1,1,1,0,'是',0,1,0,'',1,'',0,1,'checkbox','列表中显示','is_show_list',2),(22,'0000-00-00 00:00:00','2020-05-07 10:19:53',1,1,1,0,'是',0,1,0,'',1,'',0,1,'checkbox','列表中能搜索','is_search',2),(23,'0000-00-00 00:00:00','2020-05-07 10:20:02',1,1,1,0,'是',0,1,0,'',1,'',0,1,'checkbox','能添加','is_insert',2),(24,'0000-00-00 00:00:00','2020-05-07 10:21:16',1,1,1,0,'是',0,1,0,'',1,'',0,0,'checkbox','添加必填','is_insert_required',2),(25,'0000-00-00 00:00:00','2020-05-07 10:21:23',1,1,1,0,'是',0,1,0,'',1,'',0,0,'checkbox','能更新','is_update',2),(26,'0000-00-00 00:00:00','2020-05-07 10:21:29',1,1,1,0,'是',0,1,0,'',1,'',0,0,'checkbox','更新必填','is_update_required',2),(27,'0000-00-00 00:00:00','2020-05-07 10:21:39',1,1,1,0,'是',0,1,0,'编辑页面类型为hidden',1,'',0,0,'checkbox','input hidden','is_input_hidden',2),(28,'0000-00-00 00:00:00','2020-05-07 10:21:45',1,1,1,0,'like,like_left,like_right,equal',0,1,0,'',1,'',0,0,'select','搜索类型','search_type',2),(29,'0000-00-00 00:00:00','2020-05-07 10:21:49',1,1,1,0,'',0,1,0,'',1,'',0,0,'string','提示','tip',2),(30,'0000-00-00 00:00:00','2020-05-07 10:21:54',1,1,1,0,'',0,1,0,'',1,'',0,0,'string','默认值','default_str',2),(33,'0000-00-00 00:00:00','2020-05-07 10:03:47',1,1,1,0,'',0,0,0,'',0,'',0,1,'string','ID','id',1),(34,'0000-00-00 00:00:00','2020-05-07 10:05:54',1,1,1,0,'',1,1,1,'',1,'',1,1,'string','关键字','keyword',1),(35,'0000-00-00 00:00:00','2020-05-07 10:06:05',1,1,1,0,'',1,1,1,'',1,'like',1,1,'string','页面标题','page_title',1),(36,'0000-00-00 00:00:00','2020-05-07 10:06:22',1,1,1,0,'',1,1,1,'',1,'like',1,1,'string','模块名','page_model',1),(37,'0000-00-00 00:00:00','2020-05-07 09:54:57',1,1,1,0,'',0,1,0,'',0,'like',0,0,'string','表名','table_name',1),(40,'0000-00-00 00:00:00','2020-05-07 10:07:17',1,1,1,0,'是',0,1,0,'',1,'',0,1,'checkbox','允许删除','is_del',1),(41,'0000-00-00 00:00:00','2020-05-07 10:06:55',1,1,1,0,'是',0,1,0,'',1,'',0,1,'checkbox','允许添加','is_add',1),(42,'0000-00-00 00:00:00','2020-05-07 10:06:47',1,1,1,0,'是',0,1,0,'',1,'',0,1,'checkbox','允许编辑','is_edit',1),(43,'0000-00-00 00:00:00','2020-05-07 09:54:57',1,1,1,0,'',0,1,0,'',0,'',0,0,'string','排序','list_order',1),(44,'0000-00-00 00:00:00','2020-05-07 09:54:57',1,1,1,0,'',0,1,0,'',0,'',0,0,'string','where','list_where',1),(45,'0000-00-00 00:00:00','2020-05-07 09:54:57',1,1,1,0,'',0,1,0,'添加或编辑弹出的窗口的宽以px或%结尾',0,'',0,0,'string','编辑窗口宽','edit_window_width',1),(46,'0000-00-00 00:00:00','2020-05-07 09:54:57',1,1,1,0,'',0,1,0,'添加或编辑弹出的窗口的高以px或%结尾	',0,'',0,0,'string','编辑窗口高','edit_window_height',1),(47,'0000-00-00 00:00:00','2020-05-07 09:54:57',1,1,1,0,'',0,1,0,'',0,'',0,0,'text','操作列自定义额外html','addition_option_html',1),(48,'0000-00-00 00:00:00','2020-05-07 09:54:57',1,1,1,0,'',0,1,0,'配置字段允许哪些使用可以外部传入的变量，用,分隔字段。比如想通过get post配置list_order额外配置，请访问 ip/admin/tools/table-edit-list-view/zq_user?list_order=u_id,那么实际使用的list_order=list_order配置和get(',0,'',0,0,'string','允许使用外部变量','allow_config_from_request',1),(50,'0000-00-00 00:00:00','2020-05-07 09:54:57',1,1,1,0,'',0,1,0,'添加页面form额外的html',0,'',0,0,'text','添加页面form额外的html','add_page_addition_html',1),(51,'0000-00-00 00:00:00','2020-05-07 09:54:57',1,1,1,0,'',0,1,0,'编辑页面form额外的html',0,'',0,0,'text','编辑页面form额外的html','edit_page_addition_html',1),(52,'0000-00-00 00:00:00','2020-05-07 09:54:57',1,1,1,0,'',0,1,0,'列表里添加按钮拼接html',0,'',0,0,'text','列表添加按钮拼接html','add_button_addition_html',1),(53,'0000-00-00 00:00:00','2020-05-07 09:54:57',1,1,1,0,'',0,1,0,'列表里编辑按钮拼接html',0,'',0,0,'text','列表里编辑按钮拼接html','edit_button_addition_html',1),(54,'0000-00-00 00:00:00','2020-05-07 09:54:57',1,1,1,0,'',0,1,0,'',0,'',0,0,'string','ID','id',3),(55,'0000-00-00 00:00:00','2020-05-07 09:54:57',1,1,1,0,'',0,1,0,'',0,'like',0,0,'string','用户名','username',3),(56,'0000-00-00 00:00:00','2020-05-07 09:54:57',1,1,1,0,'',0,1,0,'',0,'like',0,0,'string','电话','mobile',3),(57,'0000-00-00 00:00:00','2020-05-07 10:05:29',1,1,1,0,'',0,1,0,'列表按钮区额外html',1,'',0,0,'text','列表按钮区额外html','button_area_addition_html',1),(58,'0000-00-00 00:00:00','2020-05-07 09:54:57',1,0,1,0,'',0,1,0,'',0,'',0,0,'string','','id',7),(59,'0000-00-00 00:00:00','2020-05-07 10:36:37',1,0,1,0,'',0,1,0,'',0,'like',1,1,'string','','username',7),(60,'0000-00-00 00:00:00','2020-05-07 09:54:57',1,0,1,0,'',0,1,0,'',0,'',0,0,'string','','name',7),(61,'0000-00-00 00:00:00','2020-05-07 09:54:57',1,0,1,0,'',0,1,0,'',0,'',0,0,'string','','password',7),(62,'0000-00-00 00:00:00','2020-05-07 09:54:57',1,0,1,0,'',0,1,0,'',0,'',0,0,'string','','zt_id',7),(63,'0000-00-00 00:00:00','2020-05-07 09:54:57',1,0,1,0,'',0,1,0,'',0,'',0,0,'string','','add_time',7),(64,'0000-00-00 00:00:00','2020-05-07 09:54:57',1,0,1,0,'',0,1,0,'',0,'',0,0,'string','','update_time',7),(65,'0000-00-00 00:00:00','2020-05-07 09:54:57',1,0,1,0,'',0,1,0,'',0,'',0,0,'string','','login_ip',7),(66,'0000-00-00 00:00:00','2020-05-07 09:54:57',1,0,1,0,'',0,1,0,'',0,'',0,0,'string','','login_count',7),(67,'0000-00-00 00:00:00','2020-05-07 09:54:57',1,0,1,0,'',0,1,0,'',0,'',0,0,'string','','login_time',7),(68,'0000-00-00 00:00:00','2020-05-07 09:54:57',1,0,1,0,'',0,1,0,'',0,'',0,0,'checkbox','','is_valid',7),(69,'0000-00-00 00:00:00','2020-05-07 09:54:57',1,0,1,0,'',0,1,0,'',0,'',0,0,'string','','sex',7),(70,'0000-00-00 00:00:00','2020-05-07 10:37:43',1,0,1,0,'',0,1,0,'',0,'',0,1,'string','','mobile',7),(71,'0000-00-00 00:00:00','2020-05-07 09:54:57',1,0,1,0,'',0,1,0,'',0,'',0,0,'string','','tel',7),(72,'0000-00-00 00:00:00','2020-05-07 09:54:57',1,0,1,0,'',0,1,0,'',0,'',0,0,'string','','note',7),(73,'0000-00-00 00:00:00','2020-05-07 09:54:57',1,0,1,0,'',0,1,0,'',0,'',0,0,'string','添加人id','add_user_id',7),(74,'0000-00-00 00:00:00','2020-05-07 09:54:57',1,0,1,0,'',0,1,0,'',0,'',0,0,'string','','edit_user_id',7),(75,'0000-00-00 00:00:00','2020-05-07 09:54:57',1,0,1,0,'',0,1,0,'',0,'',0,0,'checkbox','是不是超级帐号','is_super',7),(76,'0000-00-00 00:00:00','2020-05-07 09:54:57',1,0,1,0,'',0,1,0,'',0,'',0,0,'checkbox','','is_approval',7);
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

-- Dump completed on 2020-05-08 21:19:52
