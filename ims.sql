-- MySQL dump 10.13  Distrib 5.7.12, for Linux (x86_64)
--
-- Host: localhost    Database: digitala_ims
-- ------------------------------------------------------
-- Server version	5.7.12-0ubuntu1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `tbl_admin`
--

DROP TABLE IF EXISTS `tbl_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `pass` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `status` int(11) DEFAULT NULL,
  `last_modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_admin`
--

LOCK TABLES `tbl_admin` WRITE;
/*!40000 ALTER TABLE `tbl_admin` DISABLE KEYS */;
INSERT INTO `tbl_admin` VALUES (1,'guest','mjtCxmTJ4LiVonnFQppEEigjShqJISy84dg6wLoQYUA=','masanjeev@gmail.com','Guest',NULL,'0000-00-00 00:00:00'),(2,'buddha1','J6g/OBTOL5iUz+dMh/nMIqDN90zUERtBYIpv4dhM6HY=','','',NULL,'0000-00-00 00:00:00'),(3,'buddha2','J6g/OBTOL5iUz+dMh/nMIqDN90zUERtBYIpv4dhM6HY=','','',NULL,'0000-00-00 00:00:00');
/*!40000 ALTER TABLE `tbl_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_category`
--

DROP TABLE IF EXISTS `tbl_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `urlcode` varchar(200) DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  `description` text,
  `parent_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_category`
--

LOCK TABLES `tbl_category` WRITE;
/*!40000 ALTER TABLE `tbl_category` DISABLE KEYS */;
INSERT INTO `tbl_category` VALUES (1,'vodka','Vodka','',NULL),(2,'beer','Beer','',NULL),(3,'rum','Rum','',NULL),(4,'liquer','Liquer','',NULL),(5,'whiskey','Whiskey','',NULL),(6,'tequila','Tequila','',NULL),(7,'shots','Shots',NULL,NULL),(8,'red-bull','red bull','500 ml',NULL),(9,'brew','brew','500ml',NULL),(10,'wine','wine','',NULL);
/*!40000 ALTER TABLE `tbl_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_config`
--

DROP TABLE IF EXISTS `tbl_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `metades` text,
  `metakey` text,
  `title` varchar(255) DEFAULT NULL,
  `sitename` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_config`
--

LOCK TABLES `tbl_config` WRITE;
/*!40000 ALTER TABLE `tbl_config` DISABLE KEYS */;
INSERT INTO `tbl_config` VALUES (1,'KTM Bike Station','KTM Bike Station','KTM Bike Station','KTM Bike Station');
/*!40000 ALTER TABLE `tbl_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_product`
--

DROP TABLE IF EXISTS `tbl_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ordering` int(11) DEFAULT NULL,
  `urlcode` varchar(200) DEFAULT NULL,
  `cid` int(11) DEFAULT NULL,
  `scid` int(11) DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  `itemcode` varchar(100) DEFAULT NULL,
  `description` text,
  `quantity` int(11) NOT NULL,
  `costprice` float NOT NULL,
  `mrp` float NOT NULL,
  `date_added` date NOT NULL,
  PRIMARY KEY (`id`,`quantity`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_product`
--

LOCK TABLES `tbl_product` WRITE;
/*!40000 ALTER TABLE `tbl_product` DISABLE KEYS */;
INSERT INTO `tbl_product` VALUES (9,NULL,'red-wine',10,NULL,'red wine','16-9','100 ml',117,11999,12000,'2016-06-02'),(10,NULL,'flavoured-vodka',1,NULL,'flavoured vodka','16-10','500 ml',999,1000,1000,'2016-06-03'),(11,NULL,'taquila-gold',6,NULL,'taquila gold','16-11','500ml',122,1230,1230,'2016-06-03'),(12,NULL,'cherry-bomb',7,NULL,'cherry bomb','16-12','1 ltr',5000,5000,5000,'2016-06-03'),(13,NULL,'nepal-ice',2,NULL,'nepal ice','16-13','500 ml',1000,524,530,'2016-06-03'),(14,NULL,'tuborg',2,NULL,'tuborg','16-14','500 ml',1000,250,250,'2016-06-03');
/*!40000 ALTER TABLE `tbl_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_sale`
--

DROP TABLE IF EXISTS `tbl_sale`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_sale` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sale_date` date NOT NULL,
  `sale_datetime` datetime NOT NULL,
  `saletype` varchar(50) NOT NULL,
  `pid` int(11) NOT NULL,
  `costprice` float NOT NULL,
  `saleprice` float NOT NULL,
  `quantity` int(11) NOT NULL,
  `sold_by` int(11) NOT NULL,
  `remarks` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_sale`
--

LOCK TABLES `tbl_sale` WRITE;
/*!40000 ALTER TABLE `tbl_sale` DISABLE KEYS */;
INSERT INTO `tbl_sale` VALUES (16,'2016-06-03','2016-06-03 16:24:25','Product',10,1000,1000,1,1,'cash paid'),(17,'2016-06-03','2016-06-03 16:25:21','Product',9,11999,12000,5,1,'cash');
/*!40000 ALTER TABLE `tbl_sale` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-06-03 16:57:10
