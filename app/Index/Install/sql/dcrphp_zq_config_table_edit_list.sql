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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `add_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  `is_approval` tinyint(1) NOT NULL DEFAULT '1',
  `add_user_id` smallint(6) NOT NULL DEFAULT '0',
  `zt_id` smallint(6) NOT NULL DEFAULT '1',
  `keyword` varchar(45) NOT NULL,
  `page_title` varchar(45) NOT NULL,
  `page_model` varchar(45) NOT NULL,
  `table_name` varchar(45) NOT NULL,
  `index_id` varchar(45) NOT NULL,
  `table_pre` varchar(45) NOT NULL,
  `is_del` varchar(45) NOT NULL DEFAULT '是',
  `is_add` varchar(45) NOT NULL DEFAULT '是',
  `is_edit` varchar(45) NOT NULL DEFAULT '是',
  `list_order` varchar(45) NOT NULL,
  `list_where` varchar(45) NOT NULL,
  `edit_window_width` varchar(45) NOT NULL,
  `edit_window_height` varchar(45) NOT NULL DEFAULT '',
  `addition_option_html` varchar(2000) NOT NULL DEFAULT '' COMMENT '操作里自定义操作html',
  `allow_config_from_request` varchar(2000) NOT NULL DEFAULT '' COMMENT '请求里可以有的字段',
  `add_page_addition_html` varchar(2000) NOT NULL DEFAULT '' COMMENT '添加页面form里额外的html',
  `edit_button_addition_html` varchar(2000) NOT NULL DEFAULT '' COMMENT '列表里编辑按钮拼接html',
  `add_button_addition_html` varchar(2000) NOT NULL DEFAULT '' COMMENT '列表里添加按钮拼接html',
  `edit_page_addition_html` varchar(2000) NOT NULL DEFAULT '' COMMENT '编辑页面form里额外的html',
  `button_area_addition_html` varchar(2000) NOT NULL DEFAULT '' COMMENT '列表按钮区额外html',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uidx_key` (`keyword`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='单表配置列表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zq_config_table_edit_list`
--

LOCK TABLES `zq_config_table_edit_list` WRITE;
/*!40000 ALTER TABLE `zq_config_table_edit_list` DISABLE KEYS */;
INSERT INTO `zq_config_table_edit_list` VALUES (1,1588130186,1588435099,1,1,1,'zq_config_table_edit_list','单表管理列表(勿删)','系统配置','zq_config_table_edit_list','id','','是','是','是','id desc','','95%','95%','<a title=\"字段\" href=\"javascript:;\" onclick=\"open_iframe(\'配置字段\',\'/admin/tools/table-edit-list-view/zq_config_table_edit_item?ctel_id={db.index_id}&list_where=ctel_id={db.index_id}\',\'95%\',\'95%\')\" class=\"ml-5\" style=\"text-decoration:none\"><i class=\"Hui-iconfont Hui-iconfont-menu\"></i></a>','','','','','',''),(2,1588161750,1588345103,1,1,1,'zq_config_table_edit_item','单表管理字段(勿删)','系统配置','zq_config_table_edit_item','id','','是','是','是','id desc','','95%','95%','','list_where','<input type=\"hidden\" name=\"ctei_ctel_id\" value=\"{get.ctei_ctel_id}\">','','?ctei_ctel_id={get.ctei_ctel_id}','',''),(3,1588262871,1588435107,1,1,1,'zq_user_mobile','会员手机号(案例)','用户','zq_user','id','','','','是','','','600px','250px','','','','','','','');
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

-- Dump completed on 2020-05-02 23:59:46
