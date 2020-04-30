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
-- Table structure for table `zq_config_table_edit_item`
--

DROP TABLE IF EXISTS `zq_config_table_edit_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `zq_config_table_edit_item` (
  `ctei_id` int(11) NOT NULL AUTO_INCREMENT,
  `add_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  `approval_status` tinyint(4) NOT NULL DEFAULT '1',
  `add_user_id` smallint(6) NOT NULL DEFAULT '0',
  `zt_id` smallint(6) NOT NULL DEFAULT '1',
  `ctei_is_input_hidden` varchar(5) NOT NULL DEFAULT '',
  `ctei_default` varchar(200) NOT NULL DEFAULT '',
  `ctei_is_update_required` varchar(5) NOT NULL DEFAULT '',
  `ctei_is_update` varchar(5) NOT NULL DEFAULT '',
  `ctei_is_insert_required` varchar(5) NOT NULL DEFAULT '',
  `ctei_tip` varchar(200) NOT NULL DEFAULT '',
  `ctei_is_insert` varchar(5) NOT NULL DEFAULT '',
  `ctei_search_type` varchar(10) NOT NULL DEFAULT '',
  `ctei_is_search` varchar(5) NOT NULL DEFAULT '',
  `ctei_is_show_list` varchar(5) NOT NULL DEFAULT '',
  `ctei_data_type` varchar(45) NOT NULL DEFAULT '',
  `ctei_title` varchar(45) NOT NULL DEFAULT '',
  `ctei_db_field_name` varchar(45) NOT NULL DEFAULT '',
  `ctei_ctel_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ctei_id`),
  UNIQUE KEY `uidx_db_ctel_id` (`ctei_db_field_name`,`ctei_ctel_id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8 COMMENT='单表配置字段';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zq_config_table_edit_item`
--

LOCK TABLES `zq_config_table_edit_item` WRITE;
/*!40000 ALTER TABLE `zq_config_table_edit_item` DISABLE KEYS */;
INSERT INTO `zq_config_table_edit_item` VALUES (11,1588232180,1588232469,1,1,1,'','','','','','','','','','是','string','ID','ctei_id',2),(17,1588236303,1588236549,1,1,1,'是','','','','','','是','','','是','string','父表ID','ctei_ctel_id',2),(18,1588236592,1588236654,1,1,1,'','','是','是','是','小写英文字母开头，只能小写英文及数字','是','like','是','是','string','字段名','ctei_db_field_name',2),(19,1588236657,1588236683,1,1,1,'','','是','是','是','','是','like','是','是','string','标题','ctei_title',2),(20,1588237014,1588237037,1,1,1,'','','是','是','是','','是','','','是','string','数据类型','ctei_data_type',2),(21,1588237039,1588237068,1,1,1,'','是','','是','','','是','','','是','checkbox','列表中显示','ctei_is_show_list',2),(22,1588237069,1588237094,1,1,1,'','是','','是','','','是','','','是','checkbox','列表中能搜索','ctei_is_search',2),(23,1588237096,1588237115,1,1,1,'','是','','是','','','是','','','是','checkbox','能添加','ctei_is_insert',2),(24,1588237120,1588237143,1,1,1,'','是','','是','','','是','','','是','checkbox','添加必填','ctei_is_insert_required',2),(25,1588237144,1588237161,1,1,1,'','是','','是','','','是','','','是','checkbox','能更新','ctei_is_update',2),(26,1588237178,1588237196,1,1,1,'','是','','是','','','是','','','是','checkbox','更新必填','ctei_is_update_required',2),(27,1588237198,1588237245,1,1,1,'','是','','是','','编辑页面类型为hidden','是','','','','checkbox','input hidden','ctei_is_input_hidden',2),(28,1588237247,1588237277,1,1,1,'','','','是','','','是','','','是','string','搜索类型','ctei_search_type',2),(29,1588237280,1588237294,1,1,1,'','','','是','','','是','','','','string','提示','ctei_tip',2),(30,1588237296,1588237316,1,1,1,'','','','是','','','是','','','是','string','默认值','ctei_default',2),(31,1588237317,1588237368,1,1,1,'是','','','','','','是','','','','date','添加时间','ctei_add_time',2),(32,1588237371,1588237397,1,1,1,'是','','','是','','','是','','','是','date','更新时间','ctei_update_time',2),(33,1588240674,1588240698,1,1,1,'','','','','','','','','','是','string','ID','ctel_id',1),(34,1588240699,1588240734,1,1,1,'','','是','是','是','','是','','是','是','string','关键字','ctel_key',1),(35,1588240735,1588240755,1,1,1,'','','是','是','是','','是','','是','是','string','页面标题','ctel_page_title',1),(36,1588240758,1588240781,1,1,1,'','','是','是','是','','是','','','是','string','模块名','ctel_page_model',1),(37,1588240832,1588240845,1,1,1,'','','是','是','是','','是','','是','是','string','表名','ctel_table_name',1),(38,1588240846,1588240861,1,1,1,'','','是','是','是','','是','','','','string','主键名','ctel_index_id',1),(39,1588241160,1588241185,1,1,1,'','','是','是','是','不要以_结尾','是','','','是','string','表前缀','ctel_table_pre',1),(40,1588241187,1588241210,1,1,1,'','是','','是','','','是','','','是','checkbox','允许删除','ctel_is_del',1),(41,1588241211,1588241230,1,1,1,'','是','','是','','','是','','','是','checkbox','允许添加','ctel_is_add',1),(42,1588241231,1588241259,1,1,1,'','是','','是','','','是','','','是','checkbox','允许编辑','ctel_is_edit',1),(43,1588241274,1588241292,1,1,1,'','','','是','','','是','','','','string','排序','ctel_list_order',1),(44,1588241294,1588241307,1,1,1,'','','','是','','','是','','','是','string','where','ctel_list_where',1),(45,1588241312,1588241348,1,1,1,'','','','是','','添加或编辑弹出的窗口的宽以px或%结尾','是','','','是','string','编辑窗口宽','ctel_edit_window_width',1),(46,1588241356,1588241377,1,1,1,'','','','是','','添加或编辑弹出的窗口的高以px或%结尾	','是','','','是','string','编辑窗口高','ctel_edit_window_height',1),(47,1588241386,1588241541,1,1,1,'','','','是','','','是','','','','text','操作列自定义额外html','ctel_addition_option_html',1),(48,1588241542,1588241607,1,1,1,'','','','是','','配置字段允许哪些使用可以外部传入的变量，用,分隔字段。比如想通过get post配置list_order额外配置，请访问 ip/admin/tools/table-edit-list-view/zq_user?list_order=u_id,那么实际使用的list_order=list_order配置和get(','是','','','','string','允许使用外部变量','ctel_allow_config_from_request',1),(50,0,0,1,1,1,'','','','是','','添加字段页面form里额外的html','是','','','','text','添加页面额外的html','ctel_add_page_addition_html',1),(51,0,0,1,1,1,'','编辑字段页面form里额外的html','','是','','','是','','','','text','编辑页面额外的html','ctel_edit_page_addition_html',1),(52,0,0,1,1,1,'','','','是','','列表里添加按钮拼接html','是','','','','text','列表添加按钮拼接html','ctel_add_button_addition_html',1),(53,0,0,1,1,1,'','','','是','','列表里编辑按钮拼接html','是','','','','text','列表里编辑按钮拼接html','ctel_edit_button_addition_html',1),(54,0,0,1,1,1,'是','','','','','','','','','是','string','ID','u_id',3),(55,0,0,1,1,1,'','','','','','','','like','是','是','string','用户名','u_username',3),(56,0,0,1,1,1,'','','是','是','','','','like','是','是','string','电话','u_mobile',3);
/*!40000 ALTER TABLE `zq_config_table_edit_item` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-05-01  0:55:24
