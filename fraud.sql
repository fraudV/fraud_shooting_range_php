-- MySQL dump 10.13  Distrib 8.0.16, for linux-glibc2.12 (x86_64)
--
-- Host: 127.0.0.1    Database: fraud
-- ------------------------------------------------------
-- Server version	8.0.16

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
 SET NAMES utf8mb4 ;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `environment`
--

DROP TABLE IF EXISTS `environment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `environment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `path` varchar(255) DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ports` json DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  `address` varchar(255) DEFAULT NULL,
  `del` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `environment`
--

LOCK TABLES `environment` WRITE;
/*!40000 ALTER TABLE `environment` DISABLE KEYS */;
INSERT INTO `environment` VALUES (1,'int注入','file/docker/environment/php/injection/mysql/intInjection','2024-05-09 23:39:38','2024-06-11 07:02:31','{\"F_PORT\": 58199}',0,'http://www.baidu.com',0),(13,'登录绕过','file/docker/environment/php/injection/mysql/loginBypass','2024-05-14 08:42:38','2024-05-20 06:15:58','{\"F_PORT\": 58225}',0,NULL,0),(21,'绕waf','file/docker/environment/php/injection/mysql/bypassWaf','2024-05-14 10:33:05','2024-05-19 14:37:59','{\"F_PORT\": 54341}',0,NULL,0),(23,'union 注入','file/docker/environment/php/injection/mysql/unionInjection','2024-05-14 12:29:23','2024-05-19 14:37:59','{\"F_PORT\": 51637}',0,NULL,0),(24,'单列数据','file/docker/environment/php/injection/mysql/singleColumnData','2024-05-14 12:43:29','2024-05-19 14:37:59','{\"F_PORT\": 55914}',0,NULL,0),(30,'条件注入','file/docker/environment/php/injection/mysql/ConditionalInjection','2024-05-17 14:07:35','2024-05-19 14:37:59','{\"F_PORT\": 57231}',0,'',0),(47,'字符串注入','file/docker/environment/1716172807','2024-05-20 02:40:07','2024-05-20 02:44:45','{\"F_PORT\": 53918}',0,'xx',0),(48,'报错注入','file/docker/environment/1716175822','2024-05-20 03:30:22','2024-05-20 04:07:01','{\"F_PORT\": 55976}',0,'111',0),(50,'时间盲注','file/docker/environment/1716183104','2024-05-20 05:31:44','2024-05-20 05:53:40','{\"F_PORT\": 54467}',0,'xxx',0),(51,'用户名枚举','file/docker/environment/1716188906','2024-05-20 07:08:26','2024-05-20 07:21:03','{\"F_PORT\": 54317}',0,'',0),(52,'时间差异','file/docker/environment/1716199332','2024-05-20 10:02:12','2024-05-20 10:03:24','{\"F_PORT\": 57524}',0,'x',0),(53,'观察页面','file/docker/environment/1716200429','2024-05-20 10:20:29','2024-05-20 10:22:46','{\"F_PORT\": 54192}',0,'',0),(54,'限制次数','file/docker/environment/1716269144','2024-05-21 05:25:44','2024-05-21 05:37:17','{\"F_PORT\": 51701}',0,'',0),(55,'多次请求','file/docker/environment/1716292719','2024-05-21 11:58:39','2024-05-21 13:01:31','{\"F_PORT\": 59130}',0,'',0),(56,'2FA旁路','file/docker/environment/1716296469','2024-05-21 13:01:09','2024-05-24 09:58:44','{\"F_PORT\": 58065}',0,'',0),(57,'2FA逻辑失效','file/docker/environment/1716339839','2024-05-22 01:03:59','2024-05-22 01:10:17','{\"F_PORT\": 59873}',0,'',0),(58,'暴力破解','file/docker/environment/1716357268','2024-05-22 05:54:28','2024-05-22 06:01:32','{\"F_PORT\": 57480}',0,'',0),(59,'保持会话','file/docker/environment/1716361842','2024-05-22 07:10:42','2024-05-22 08:37:01','{\"F_PORT\": 58826}',0,'',0),(60,'离线破解','file/docker/environment/1716364301','2024-05-22 07:51:41','2024-05-22 08:19:28','{\"F_PORT\": 54269}',0,'',0),(61,'密码重置','file/docker/environment/1716545101','2024-05-24 10:05:01','2024-05-28 04:29:06','{\"F_PORT\": 52028}',0,'',0),(62,'密码重置投毒','file/docker/environment/1716870530','2024-05-28 04:28:50','2024-05-28 13:17:56','{\"F_PORT\": 50467}',0,'',0),(63,'密码重置枚举','file/docker/environment/1716904350','2024-05-28 13:52:30','2024-06-02 14:10:57','{\"F_PORT\": 56312}',0,'',0),(66,'文件目录枚举','file/docker/environment/1717337498','2024-06-02 14:11:38','2024-06-02 14:23:07','{\"F_PORT\": 54182}',0,'',0),(67,'文件目录遍历过滤字符串','file/docker/environment/1717340065','2024-06-02 14:54:25','2024-06-03 01:51:23','{\"F_PORT\": 57012}',0,'',0),(68,'绝对路径','file/docker/environment/1717380681','2024-06-03 02:11:21','2024-06-03 02:12:14','{\"F_PORT\": 57616}',0,'',0),(69,'url编码','file/docker/environment/1717381481','2024-06-03 02:24:41','2024-06-03 02:27:47','{\"F_PORT\": 55480}',0,'',0),(70,'验证参数','file/docker/environment/1717382233','2024-06-03 02:37:14','2024-06-03 02:37:14','{\"F_PORT\": 51637}',0,'',0),(71,'%00截断','file/docker/environment/1717382880','2024-06-03 02:48:00','2024-06-03 04:45:21','{\"F_PORT\": 57120}',0,'',0),(72,'简单案例','file/docker/environment/1717396330','2024-06-03 06:32:10','2024-06-03 07:54:59','{\"F_PORT\": 57625}',0,'',0),(73,'延迟注入','file/docker/environment/1717399143','2024-06-03 07:19:03','2024-06-03 07:36:44','{\"F_PORT\": 53765}',0,'',0),(74,'重定向','file/docker/environment/1717401281','2024-06-03 07:54:41','2024-06-03 08:23:11','{\"F_PORT\": 58267}',0,'',0),(75,'外带数据','file/docker/environment/1717403867','2024-06-03 08:37:47','2024-06-04 09:18:35','{\"F_PORT\": 59298}',0,'',0),(76,'过度信任','file/docker/environment/1717511515','2024-06-04 14:31:56','2024-06-06 11:50:48','{\"F_PORT\": 51147}',0,'',0),(77,'高级逻辑漏洞','file/docker/environment/1717674752','2024-06-06 11:52:32','2024-06-07 05:26:36','{\"F_PORT\": 50371}',0,'',0);
/*!40000 ALTER TABLE `environment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu`
--

DROP TABLE IF EXISTS `menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `to` varchar(255) DEFAULT NULL,
  `superiors` int(11) DEFAULT '0',
  `start_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `env_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  `del` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_env_id` (`env_id`),
  CONSTRAINT `fk_env_id` FOREIGN KEY (`env_id`) REFERENCES `environment` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=96 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu`
--

LOCK TABLES `menu` WRITE;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
INSERT INTO `menu` VALUES (1,'首页',NULL,NULL,0,'2024-05-07 11:53:14','2024-06-11 06:51:19',NULL,0,1),(2,'主页','pi pi-fw pi-home','/',1,'2024-05-07 11:56:25','2024-06-11 06:54:57',NULL,0,0),(3,'靶场',NULL,NULL,0,'2024-05-07 11:57:05','2024-05-11 04:32:40',NULL,0,0),(4,'php','pi pi-fw pi-id-card',NULL,3,'2024-05-07 15:13:24','2024-05-11 04:32:40',NULL,0,0),(6,'sql注入','pi pi-fw pi-exclamation-circle',NULL,4,'2024-05-07 15:15:08','2024-05-11 04:32:40',NULL,0,0),(7,'mysql','pi pi-fw pi-exclamation-circle',NULL,6,'2024-05-07 15:15:40','2024-05-14 12:30:50',NULL,0,0),(8,'int注入','pi pi-fw pi-exclamation-circle','/env',7,'2024-05-09 23:40:11','2024-05-13 03:59:08',1,0,0),(9,'管理',NULL,NULL,0,'2024-05-11 00:53:38','2024-06-11 06:54:24',NULL,0,1),(10,'目录操作','pi pi-fw pi-pencil','/menu',9,'2024-05-11 05:13:55','2024-05-19 10:06:39',NULL,0,0),(11,'登录绕过','pi pi-fw pi-exclamation-circle','/env',7,'2024-05-11 09:50:59','2024-05-14 08:36:50',13,0,0),(12,'靶场操作',NULL,'/env/controls',9,'2024-05-13 14:45:52','2024-05-19 12:00:33',NULL,0,0),(13,'绕waf',NULL,'/env',7,'2024-05-14 10:17:08','2024-05-14 10:28:51',21,0,0),(14,'union 注入',NULL,'/env',7,'2024-05-14 12:22:49','2024-05-14 12:22:49',23,0,0),(15,'单列数据',NULL,'/env',7,'2024-05-14 12:41:59','2024-05-14 12:41:59',24,0,0),(16,'条件注入',NULL,'/env',7,'2024-05-17 14:06:22','2024-05-17 14:06:22',30,0,0),(58,'字符串注入',NULL,'/env',7,'2024-05-20 02:40:07','2024-05-20 02:40:07',47,0,0),(59,'报错注入',NULL,'/env',7,'2024-05-20 03:30:22','2024-05-20 03:30:22',48,0,0),(61,'时间盲注',NULL,'/env',7,'2024-05-20 05:31:44','2024-05-20 05:31:44',50,0,0),(62,'认证',NULL,'',4,'2024-05-20 06:59:34','2024-05-20 06:59:34',NULL,0,0),(63,'密码登录',NULL,'',62,'2024-05-20 07:00:20','2024-05-20 07:00:20',NULL,0,0),(64,'用户名枚举',NULL,'/env',63,'2024-05-20 07:08:26','2024-05-20 07:08:26',51,0,0),(65,'时间差异',NULL,'/env',63,'2024-05-20 10:02:12','2024-05-20 10:02:12',52,0,0),(66,'观察页面',NULL,'/env',63,'2024-05-20 10:20:29','2024-05-20 10:20:29',53,0,0),(67,'限制次数',NULL,'/env',63,'2024-05-21 05:25:44','2024-05-21 05:25:44',54,0,0),(68,'多次请求',NULL,'/env',63,'2024-05-21 11:58:39','2024-05-21 11:58:39',55,0,0),(69,'双因素认证',NULL,'',62,'2024-05-21 13:00:19','2024-05-21 13:00:19',NULL,0,0),(70,'2FA旁路',NULL,'/env',69,'2024-05-21 13:01:09','2024-05-21 13:01:09',56,0,0),(71,'2FA逻辑失效',NULL,'/env',69,'2024-05-22 01:03:59','2024-05-22 01:03:59',57,0,0),(72,'暴力破解',NULL,'/env',69,'2024-05-22 05:54:28','2024-05-22 05:54:28',58,0,0),(73,'认证缺陷',NULL,'',62,'2024-05-22 07:10:18','2024-05-22 07:10:18',NULL,0,0),(74,'保持会话',NULL,'/env',73,'2024-05-22 07:10:42','2024-05-22 07:10:42',59,0,0),(75,'离线破解',NULL,'/env',73,'2024-05-22 07:51:41','2024-05-22 07:51:41',60,0,0),(76,'密码重置',NULL,'/env',73,'2024-05-24 10:05:01','2024-05-24 10:05:01',61,0,0),(77,'密码重置投毒',NULL,'/env',73,'2024-05-28 04:28:50','2024-05-28 04:28:50',62,0,0),(78,'密码重置枚举',NULL,'/env',73,'2024-05-28 13:52:30','2024-05-28 13:52:30',63,0,0),(79,'目录遍历',NULL,'',4,'2024-06-02 14:04:08','2024-06-02 14:04:08',NULL,0,0),(82,'文件目录枚举',NULL,'/env',79,'2024-06-02 14:11:38','2024-06-02 14:11:38',66,0,0),(83,'文件目录遍历过滤字符串',NULL,'/env',79,'2024-06-02 14:54:25','2024-06-02 14:54:25',67,0,0),(84,'绝对路径',NULL,'/env',79,'2024-06-03 02:11:21','2024-06-03 02:11:21',68,0,0),(85,'url编码',NULL,'/env',79,'2024-06-03 02:24:41','2024-06-03 02:24:41',69,0,0),(86,'验证参数',NULL,'/env',79,'2024-06-03 02:37:14','2024-06-03 02:37:14',70,0,0),(87,'%00截断',NULL,'/env',79,'2024-06-03 02:48:00','2024-06-03 02:48:00',71,0,0),(88,'命令执行',NULL,'',4,'2024-06-03 06:30:34','2024-06-03 06:30:34',NULL,0,0),(89,'简单案例',NULL,'/env',88,'2024-06-03 06:32:10','2024-06-03 06:32:10',72,0,0),(90,'延迟注入',NULL,'/env',88,'2024-06-03 07:19:03','2024-06-03 07:19:03',73,0,0),(91,'重定向',NULL,'/env',88,'2024-06-03 07:54:41','2024-06-03 07:54:41',74,0,0),(92,'外带数据',NULL,'/env',88,'2024-06-03 08:37:47','2024-06-03 08:37:47',75,0,0),(93,'逻辑漏洞',NULL,'',4,'2024-06-04 14:31:36','2024-06-04 14:31:36',NULL,0,0),(94,'过度信任',NULL,'/env',93,'2024-06-04 14:31:56','2024-06-04 14:31:56',76,0,0),(95,'高级逻辑漏洞',NULL,'/env',93,'2024-06-06 11:52:32','2024-06-06 11:52:32',77,0,0);
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-06-11  7:30:17
