-- MySQL dump 10.13  Distrib 5.5.41, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: simple_sample_site
-- ------------------------------------------------------
-- Server version	5.5.41-0ubuntu0.12.04.1

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
-- Table structure for table `tab_documenti`
--

DROP TABLE IF EXISTS `tab_documenti`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tab_documenti` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `save_folder` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `hash_name` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `real_name` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `nome` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `descrizione` varchar(512) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `codice_lingua` varchar(6) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `keywords` varchar(512) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `chiave` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tab_documenti`
--

LOCK TABLES `tab_documenti` WRITE;
/*!40000 ALTER TABLE `tab_documenti` DISABLE KEYS */;
/*!40000 ALTER TABLE `tab_documenti` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tab_immagini`
--

DROP TABLE IF EXISTS `tab_immagini`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tab_immagini` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `save_folder` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `hash_name` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `real_name` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `nome` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `descrizione` varchar(512) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `keywords` varchar(512) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tab_immagini`
--

LOCK TABLES `tab_immagini` WRITE;
/*!40000 ALTER TABLE `tab_immagini` DISABLE KEYS */;
/*!40000 ALTER TABLE `tab_immagini` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tab_immagini_prodotti_servizi`
--

DROP TABLE IF EXISTS `tab_immagini_prodotti_servizi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tab_immagini_prodotti_servizi` (
  `id_immagine_prodotto_servizio` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_prodotto_servizio` bigint(20) unsigned NOT NULL COMMENT 'id del prodotto a cui agganciare l''immagine',
  `nome_immagine` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'percorso dell''immagine',
  PRIMARY KEY (`id_immagine_prodotto_servizio`)
) ENGINE=MyISAM AUTO_INCREMENT=82 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tab_immagini_prodotti_servizi`
--

LOCK TABLES `tab_immagini_prodotti_servizi` WRITE;
/*!40000 ALTER TABLE `tab_immagini_prodotti_servizi` DISABLE KEYS */;
INSERT INTO `tab_immagini_prodotti_servizi` VALUES (39,28,'20120531_105107.jpg'),(40,28,'20120531_105131.jpg'),(41,28,'20120531_105550.jpg'),(42,28,'20120531_110157.jpg'),(47,30,'20120601_094204.jpg'),(48,30,'20120601_094404.jpg'),(49,30,'20120601_094451.jpg'),(60,34,'20120601_110506.jpg'),(61,34,'20120601_111129.jpg'),(62,34,'20120601_110905.jpg'),(63,34,'20120601_111611.jpg'),(64,34,'20120601_111833.jpg'),(72,86,'10425518_10204382751314064_2005812629_n.jpg'),(73,86,'10466716_10204382751354065_1647841725_n.jpg'),(78,86,'10522633_10204430965719394_2145690744_n.jpg'),(77,86,'10487153_10204430965679393_1507752219_n.jpg'),(79,86,'10410723_10204431206965425_6158454683342657310_n.jpg'),(81,86,'10426644_10204431206445412_8532709115750202300_n.jpg');
/*!40000 ALTER TABLE `tab_immagini_prodotti_servizi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tab_prodotti_servizi`
--

DROP TABLE IF EXISTS `tab_prodotti_servizi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tab_prodotti_servizi` (
  `id_prodotto_servizio` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'nome del prodotto/servizio',
  `descrizione` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'descrizione',
  `link_sito_produttore` varchar(512) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'link sito produttore',
  `prezzo_iva_esclusa` double DEFAULT NULL COMMENT 'prezzo iva esclusa',
  PRIMARY KEY (`id_prodotto_servizio`)
) ENGINE=MyISAM AUTO_INCREMENT=87 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tab_prodotti_servizi`
--

LOCK TABLES `tab_prodotti_servizi` WRITE;
/*!40000 ALTER TABLE `tab_prodotti_servizi` DISABLE KEYS */;
INSERT INTO `tab_prodotti_servizi` VALUES (28,'A fun cube','<p>A fun cube is hanging here ...</p><p>What is it?? It\'s quite fun ...</p>',NULL,NULL),(30,'Some planet images','<p>Fun planet drawings here</p><p>Drawn with bare hands and a free paint software.</p>',NULL,NULL),(34,'Some random filters','<p>Some random filters just to fill spaces</p><p>These iimages are not so beautiful ...</p>',NULL,NULL),(86,'Some random images','',NULL,0);
/*!40000 ALTER TABLE `tab_prodotti_servizi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tab_prodotto_servizio_vetrina`
--

DROP TABLE IF EXISTS `tab_prodotto_servizio_vetrina`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tab_prodotto_servizio_vetrina` (
  `id_prodotto_servizio_vetrina` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_vetrina` bigint(20) unsigned NOT NULL,
  `id_prodotto_servizio` bigint(20) unsigned NOT NULL,
  `nome_immagine` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'L''immagine da utilizzare per la vetrina di questo prodotto',
  PRIMARY KEY (`id_prodotto_servizio_vetrina`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tab_prodotto_servizio_vetrina`
--

LOCK TABLES `tab_prodotto_servizio_vetrina` WRITE;
/*!40000 ALTER TABLE `tab_prodotto_servizio_vetrina` DISABLE KEYS */;
INSERT INTO `tab_prodotto_servizio_vetrina` VALUES (25,2,30,'20120601_094204.jpg'),(23,2,28,'20120531_105131.jpg'),(36,1,86,'10466716_10204382751354065_1647841725_n.jpg'),(29,2,34,'20120601_111611.jpg');
/*!40000 ALTER TABLE `tab_prodotto_servizio_vetrina` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tab_testi`
--

DROP TABLE IF EXISTS `tab_testi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tab_testi` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tipo` smallint(5) unsigned NOT NULL,
  `titolo` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `testo` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `codice_lingua` varchar(6) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `keywords` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `chiave` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tab_testi`
--

LOCK TABLES `tab_testi` WRITE;
/*!40000 ALTER TABLE `tab_testi` DISABLE KEYS */;
INSERT INTO `tab_testi` VALUES (1,0,'SimpleSampleSite - Who is','<p>Here on SimpleSampleSite you can find various stuff, mostly random generated images. Trust us. The download was done very slowly and carefully, all bits are in the right places.</p><p>Here you can find images of planets, flowers, and maybe some other kind of images.</p>','it','simple sample site, who am i','chi_sono'),(2,0,'SimpleSampleSite - Collections','<p>Some nice fractal images are used as random background.</p>','it','simple sample site, collections','le_collezioni'),(3,0,'SimpleSampleSite - Laboratory','<p>Here we have amazing strange images. Just ask.</p>','it','laboratory','laboratorio');
/*!40000 ALTER TABLE `tab_testi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tab_vetrina`
--

DROP TABLE IF EXISTS `tab_vetrina`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tab_vetrina` (
  `id_vetrina` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nome_vetrina` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nome della vetrina',
  `blocco_vetrina` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'Blocco da utilizzare per il rendering della vetrina',
  PRIMARY KEY (`id_vetrina`),
  UNIQUE KEY `unique_nome_vetrina` (`nome_vetrina`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tab_vetrina`
--

LOCK TABLES `tab_vetrina` WRITE;
/*!40000 ALTER TABLE `tab_vetrina` DISABLE KEYS */;
INSERT INTO `tab_vetrina` VALUES (1,'vetrina sinistra',''),(2,'vetrina destra','');
/*!40000 ALTER TABLE `tab_vetrina` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-04-09 17:38:37
