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
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `environment`
--

LOCK TABLES `environment` WRITE;
/*!40000 ALTER TABLE `environment` DISABLE KEYS */;
INSERT INTO `environment` VALUES (1,'int注入','file/docker/environment/php/injection/mysql/intInjection','2024-05-09 23:39:38','2024-05-24 09:57:36','{\"F_PORT\": 58191}',0,'http://www.baidu.com',0),(13,'登录绕过','file/docker/environment/php/injection/mysql/loginBypass','2024-05-14 08:42:38','2024-05-20 06:15:58','{\"F_PORT\": 58225}',0,NULL,0),(21,'绕waf','file/docker/environment/php/injection/mysql/bypassWaf','2024-05-14 10:33:05','2024-05-19 14:37:59','{\"F_PORT\": 54341}',0,NULL,0),(23,'union 注入','file/docker/environment/php/injection/mysql/unionInjection','2024-05-14 12:29:23','2024-05-19 14:37:59','{\"F_PORT\": 51637}',0,NULL,0),(24,'单列数据','file/docker/environment/php/injection/mysql/singleColumnData','2024-05-14 12:43:29','2024-05-19 14:37:59','{\"F_PORT\": 55914}',0,NULL,0),(30,'条件注入','file/docker/environment/php/injection/mysql/ConditionalInjection','2024-05-17 14:07:35','2024-05-19 14:37:59','{\"F_PORT\": 57231}',0,'',0),(47,'字符串注入','file/docker/environment/1716172807','2024-05-20 02:40:07','2024-05-20 02:44:45','{\"F_PORT\": 53918}',0,'xx',0),(48,'报错注入','file/docker/environment/1716175822','2024-05-20 03:30:22','2024-05-20 04:07:01','{\"F_PORT\": 55976}',0,'111',0),(50,'时间盲注','file/docker/environment/1716183104','2024-05-20 05:31:44','2024-05-20 05:53:40','{\"F_PORT\": 54467}',0,'xxx',0),(51,'用户名枚举','file/docker/environment/1716188906','2024-05-20 07:08:26','2024-05-20 07:21:03','{\"F_PORT\": 54317}',0,'',0),(52,'时间差异','file/docker/environment/1716199332','2024-05-20 10:02:12','2024-05-20 10:03:24','{\"F_PORT\": 57524}',0,'x',0),(53,'观察页面','file/docker/environment/1716200429','2024-05-20 10:20:29','2024-05-20 10:22:46','{\"F_PORT\": 54192}',0,'',0),(54,'限制次数','file/docker/environment/1716269144','2024-05-21 05:25:44','2024-05-21 05:37:17','{\"F_PORT\": 51701}',0,'',0),(55,'多次请求','file/docker/environment/1716292719','2024-05-21 11:58:39','2024-05-21 13:01:31','{\"F_PORT\": 59130}',0,'',0),(56,'2FA旁路','file/docker/environment/1716296469','2024-05-21 13:01:09','2024-05-24 09:58:44','{\"F_PORT\": 58065}',0,'',0),(57,'2FA逻辑失效','file/docker/environment/1716339839','2024-05-22 01:03:59','2024-05-22 01:10:17','{\"F_PORT\": 59873}',0,'',0),(58,'暴力破解','file/docker/environment/1716357268','2024-05-22 05:54:28','2024-05-22 06:01:32','{\"F_PORT\": 57480}',0,'',0),(59,'保持会话','file/docker/environment/1716361842','2024-05-22 07:10:42','2024-05-22 08:37:01','{\"F_PORT\": 58826}',0,'',0),(60,'离线破解','file/docker/environment/1716364301','2024-05-22 07:51:41','2024-05-22 08:19:28','{\"F_PORT\": 54269}',0,'',0),(61,'密码重置','file/docker/environment/1716545101','2024-05-24 10:05:01','2024-05-28 04:29:06','{\"F_PORT\": 52028}',0,'',0),(62,'密码重置投毒','file/docker/environment/1716870530','2024-05-28 04:28:50','2024-05-28 05:34:51','{\"F_PORT\": 50467}',1,'',0);
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
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu`
--

LOCK TABLES `menu` WRITE;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
INSERT INTO `menu` VALUES (1,'首页',NULL,NULL,0,'2024-05-07 11:53:14','2024-05-14 08:23:13',NULL,0,0),(2,'主页','pi pi-fw pi-home','/',1,'2024-05-07 11:56:25','2024-05-11 04:32:40',NULL,0,0),(3,'靶场',NULL,NULL,0,'2024-05-07 11:57:05','2024-05-11 04:32:40',NULL,0,0),(4,'php','pi pi-fw pi-id-card',NULL,3,'2024-05-07 15:13:24','2024-05-11 04:32:40',NULL,0,0),(5,'java','pi pi-fw pi-check-square',NULL,3,'2024-05-07 15:13:43','2024-05-16 10:03:01',NULL,0,0),(6,'sql注入','pi pi-fw pi-exclamation-circle',NULL,4,'2024-05-07 15:15:08','2024-05-11 04:32:40',NULL,0,0),(7,'mysql','pi pi-fw pi-exclamation-circle',NULL,6,'2024-05-07 15:15:40','2024-05-14 12:30:50',NULL,0,0),(8,'int注入','pi pi-fw pi-exclamation-circle','/env',7,'2024-05-09 23:40:11','2024-05-13 03:59:08',1,0,0),(9,'管理',NULL,NULL,0,'2024-05-11 00:53:38','2024-05-11 04:32:40',NULL,0,0),(10,'目录操作','pi pi-fw pi-pencil','/menu',9,'2024-05-11 05:13:55','2024-05-19 10:06:39',NULL,0,0),(11,'登录绕过','pi pi-fw pi-exclamation-circle','/env',7,'2024-05-11 09:50:59','2024-05-14 08:36:50',13,0,0),(12,'靶场操作',NULL,'/env/controls',9,'2024-05-13 14:45:52','2024-05-19 12:00:33',NULL,0,0),(13,'绕waf',NULL,'/env',7,'2024-05-14 10:17:08','2024-05-14 10:28:51',21,0,0),(14,'union 注入',NULL,'/env',7,'2024-05-14 12:22:49','2024-05-14 12:22:49',23,0,0),(15,'单列数据',NULL,'/env',7,'2024-05-14 12:41:59','2024-05-14 12:41:59',24,0,0),(16,'条件注入',NULL,'/env',7,'2024-05-17 14:06:22','2024-05-17 14:06:22',30,0,0),(58,'字符串注入',NULL,'/env',7,'2024-05-20 02:40:07','2024-05-20 02:40:07',47,0,0),(59,'报错注入',NULL,'/env',7,'2024-05-20 03:30:22','2024-05-20 03:30:22',48,0,0),(61,'时间盲注',NULL,'/env',7,'2024-05-20 05:31:44','2024-05-20 05:31:44',50,0,0),(62,'认证',NULL,'',4,'2024-05-20 06:59:34','2024-05-20 06:59:34',NULL,0,0),(63,'密码登录',NULL,'',62,'2024-05-20 07:00:20','2024-05-20 07:00:20',NULL,0,0),(64,'用户名枚举',NULL,'/env',63,'2024-05-20 07:08:26','2024-05-20 07:08:26',51,0,0),(65,'时间差异',NULL,'/env',63,'2024-05-20 10:02:12','2024-05-20 10:02:12',52,0,0),(66,'观察页面',NULL,'/env',63,'2024-05-20 10:20:29','2024-05-20 10:20:29',53,0,0),(67,'限制次数',NULL,'/env',63,'2024-05-21 05:25:44','2024-05-21 05:25:44',54,0,0),(68,'多次请求',NULL,'/env',63,'2024-05-21 11:58:39','2024-05-21 11:58:39',55,0,0),(69,'双因素认证',NULL,'',62,'2024-05-21 13:00:19','2024-05-21 13:00:19',NULL,0,0),(70,'2FA旁路',NULL,'/env',69,'2024-05-21 13:01:09','2024-05-21 13:01:09',56,0,0),(71,'2FA逻辑失效',NULL,'/env',69,'2024-05-22 01:03:59','2024-05-22 01:03:59',57,0,0),(72,'暴力破解',NULL,'/env',69,'2024-05-22 05:54:28','2024-05-22 05:54:28',58,0,0),(73,'认证缺陷',NULL,'',62,'2024-05-22 07:10:18','2024-05-22 07:10:18',NULL,0,0),(74,'保持会话',NULL,'/env',73,'2024-05-22 07:10:42','2024-05-22 07:10:42',59,0,0),(75,'离线破解',NULL,'/env',73,'2024-05-22 07:51:41','2024-05-22 07:51:41',60,0,0),(76,'密码重置',NULL,'/env',73,'2024-05-24 10:05:01','2024-05-24 10:05:01',61,0,0),(77,'密码重置投毒',NULL,'/env',73,'2024-05-28 04:28:50','2024-05-28 04:28:50',62,0,0);
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

-- Dump completed on 2024-05-28  5:38:16
