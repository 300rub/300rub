-- MySQL dump 10.13  Distrib 5.7.24, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: source
-- ------------------------------------------------------
-- Server version	5.7.22

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
-- Table structure for table `blocks`
--

DROP TABLE IF EXISTS `blocks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blocks` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `language` tinyint(3) unsigned NOT NULL,
  `contentType` tinyint(3) unsigned NOT NULL,
  `contentId` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `blocks_language_contentType_contentId` (`language`,`contentType`,`contentId`),
  KEY `blocks_language_contentType` (`language`,`contentType`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blocks`
--

LOCK TABLES `blocks` WRITE;
/*!40000 ALTER TABLE `blocks` DISABLE KEYS */;
/*!40000 ALTER TABLE `blocks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `catalogBins`
--

DROP TABLE IF EXISTS `catalogBins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `catalogBins` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `catalogId` int(11) unsigned NOT NULL,
  `catalogInstanceId` int(11) unsigned NOT NULL,
  `count` smallint(5) unsigned NOT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `catalogBins_catalogId_fk` (`catalogId`),
  KEY `catalogBins_catalogInstanceId_fk` (`catalogInstanceId`),
  KEY `catalogBins_status` (`status`),
  CONSTRAINT `catalogBins_catalogId_fk` FOREIGN KEY (`catalogId`) REFERENCES `catalogs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `catalogBins_catalogInstanceId_fk` FOREIGN KEY (`catalogInstanceId`) REFERENCES `catalogInstances` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `catalogBins`
--

LOCK TABLES `catalogBins` WRITE;
/*!40000 ALTER TABLE `catalogBins` DISABLE KEYS */;
/*!40000 ALTER TABLE `catalogBins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `catalogInstanceLinks`
--

DROP TABLE IF EXISTS `catalogInstanceLinks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `catalogInstanceLinks` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `catalogInstanceId` int(11) unsigned NOT NULL,
  `linkCatalogInstanceId` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `catalogInstanceLinks_catalogInstanceId_linkCatalogInstanceId` (`catalogInstanceId`,`linkCatalogInstanceId`),
  KEY `catalogInstanceLinks_linkCatalogInstanceId_fk` (`linkCatalogInstanceId`),
  CONSTRAINT `catalogInstanceLinks_catalogInstanceId_fk` FOREIGN KEY (`catalogInstanceId`) REFERENCES `catalogInstances` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `catalogInstanceLinks_linkCatalogInstanceId_fk` FOREIGN KEY (`linkCatalogInstanceId`) REFERENCES `catalogInstances` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `catalogInstanceLinks`
--

LOCK TABLES `catalogInstanceLinks` WRITE;
/*!40000 ALTER TABLE `catalogInstanceLinks` DISABLE KEYS */;
/*!40000 ALTER TABLE `catalogInstanceLinks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `catalogInstances`
--

DROP TABLE IF EXISTS `catalogInstances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `catalogInstances` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `seoId` int(11) unsigned NOT NULL,
  `tabGroupId` int(11) unsigned NOT NULL,
  `imageGroupId` int(11) unsigned NOT NULL,
  `catalogMenuId` int(11) unsigned NOT NULL,
  `fieldGroupId` int(11) unsigned NOT NULL,
  `price` float NOT NULL,
  `oldPrice` float NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `catalogInstances_seoId_fk` (`seoId`),
  KEY `catalogInstances_tabGroupId_fk` (`tabGroupId`),
  KEY `catalogInstances_imageGroupId_fk` (`imageGroupId`),
  KEY `catalogInstances_catalogMenuId_fk` (`catalogMenuId`),
  KEY `catalogInstances_fieldGroupId_fk` (`fieldGroupId`),
  KEY `catalogInstances_price` (`price`),
  KEY `catalogInstances_date` (`date`),
  CONSTRAINT `catalogInstances_catalogMenuId_fk` FOREIGN KEY (`catalogMenuId`) REFERENCES `catalogMenu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `catalogInstances_fieldGroupId_fk` FOREIGN KEY (`fieldGroupId`) REFERENCES `fieldGroups` (`id`),
  CONSTRAINT `catalogInstances_imageGroupId_fk` FOREIGN KEY (`imageGroupId`) REFERENCES `imageGroups` (`id`),
  CONSTRAINT `catalogInstances_seoId_fk` FOREIGN KEY (`seoId`) REFERENCES `seo` (`id`),
  CONSTRAINT `catalogInstances_tabGroupId_fk` FOREIGN KEY (`tabGroupId`) REFERENCES `tabGroups` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `catalogInstances`
--

LOCK TABLES `catalogInstances` WRITE;
/*!40000 ALTER TABLE `catalogInstances` DISABLE KEYS */;
/*!40000 ALTER TABLE `catalogInstances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `catalogMenu`
--

DROP TABLE IF EXISTS `catalogMenu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `catalogMenu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parentId` int(11) unsigned DEFAULT NULL,
  `seoId` int(11) unsigned NOT NULL,
  `catalogId` int(11) unsigned NOT NULL,
  `icon` varchar(50) NOT NULL,
  `subName` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `catalogMenu_parentId_fk` (`parentId`),
  KEY `catalogMenu_seoId_fk` (`seoId`),
  KEY `catalogMenu_catalogId_fk` (`catalogId`),
  CONSTRAINT `catalogMenu_catalogId_fk` FOREIGN KEY (`catalogId`) REFERENCES `catalogs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `catalogMenu_parentId_fk` FOREIGN KEY (`parentId`) REFERENCES `catalogMenu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `catalogMenu_seoId_fk` FOREIGN KEY (`seoId`) REFERENCES `seo` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `catalogMenu`
--

LOCK TABLES `catalogMenu` WRITE;
/*!40000 ALTER TABLE `catalogMenu` DISABLE KEYS */;
/*!40000 ALTER TABLE `catalogMenu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `catalogOrders`
--

DROP TABLE IF EXISTS `catalogOrders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `catalogOrders` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `catalogBinId` int(11) unsigned NOT NULL,
  `formId` int(11) unsigned NOT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `catalogOrders_catalogBinId_fk` (`catalogBinId`),
  KEY `catalogOrders_formId_fk` (`formId`),
  CONSTRAINT `catalogOrders_catalogBinId_fk` FOREIGN KEY (`catalogBinId`) REFERENCES `catalogBins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `catalogOrders_formId_fk` FOREIGN KEY (`formId`) REFERENCES `forms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `catalogOrders`
--

LOCK TABLES `catalogOrders` WRITE;
/*!40000 ALTER TABLE `catalogOrders` DISABLE KEYS */;
/*!40000 ALTER TABLE `catalogOrders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `catalogs`
--

DROP TABLE IF EXISTS `catalogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `catalogs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `imageId` int(11) unsigned NOT NULL,
  `tabId` int(11) unsigned NOT NULL,
  `fieldId` int(11) unsigned NOT NULL,
  `descriptionTextId` int(11) unsigned NOT NULL,
  `designCatalogId` int(11) unsigned NOT NULL,
  `hasImages` tinyint(1) unsigned NOT NULL,
  `useAutoload` tinyint(1) unsigned NOT NULL,
  `pageNavigationSize` tinyint(3) unsigned NOT NULL,
  `shortCardDateType` tinyint(3) unsigned NOT NULL,
  `fullCardDateType` tinyint(3) unsigned NOT NULL,
  `hasRelations` tinyint(1) unsigned NOT NULL,
  `relationsLabel` varchar(255) NOT NULL,
  `hasBin` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `catalogs_imageId_fk` (`imageId`),
  KEY `catalogs_tabId_fk` (`tabId`),
  KEY `catalogs_fieldId_fk` (`fieldId`),
  KEY `catalogs_descriptionTextId_fk` (`descriptionTextId`),
  KEY `catalogs_designCatalogId_fk` (`designCatalogId`),
  CONSTRAINT `catalogs_descriptionTextId_fk` FOREIGN KEY (`descriptionTextId`) REFERENCES `texts` (`id`),
  CONSTRAINT `catalogs_designCatalogId_fk` FOREIGN KEY (`designCatalogId`) REFERENCES `designCatalogs` (`id`),
  CONSTRAINT `catalogs_fieldId_fk` FOREIGN KEY (`fieldId`) REFERENCES `fields` (`id`),
  CONSTRAINT `catalogs_imageId_fk` FOREIGN KEY (`imageId`) REFERENCES `images` (`id`),
  CONSTRAINT `catalogs_tabId_fk` FOREIGN KEY (`tabId`) REFERENCES `tabs` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `catalogs`
--

LOCK TABLES `catalogs` WRITE;
/*!40000 ALTER TABLE `catalogs` DISABLE KEYS */;
/*!40000 ALTER TABLE `catalogs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `designBlocks`
--

DROP TABLE IF EXISTS `designBlocks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `designBlocks` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `marginTop` smallint(6) NOT NULL,
  `marginTopHover` smallint(6) NOT NULL,
  `marginRight` smallint(6) NOT NULL,
  `marginRightHover` smallint(6) NOT NULL,
  `marginBottom` smallint(6) NOT NULL,
  `marginBottomHover` smallint(6) NOT NULL,
  `marginLeft` smallint(6) NOT NULL,
  `marginLeftHover` smallint(6) NOT NULL,
  `hasMarginHover` tinyint(1) unsigned NOT NULL,
  `hasMarginAnimation` tinyint(1) unsigned NOT NULL,
  `paddingTop` smallint(5) unsigned NOT NULL,
  `paddingTopHover` smallint(5) unsigned NOT NULL,
  `paddingRight` smallint(5) unsigned NOT NULL,
  `paddingRightHover` smallint(5) unsigned NOT NULL,
  `paddingBottom` smallint(5) unsigned NOT NULL,
  `paddingBottomHover` smallint(5) unsigned NOT NULL,
  `paddingLeft` smallint(5) unsigned NOT NULL,
  `paddingLeftHover` smallint(5) unsigned NOT NULL,
  `hasPaddingHover` tinyint(1) unsigned NOT NULL,
  `hasPaddingAnimation` tinyint(1) unsigned NOT NULL,
  `backgroundColorFrom` varchar(25) NOT NULL,
  `backgroundColorFromHover` varchar(25) NOT NULL,
  `backgroundColorTo` varchar(25) NOT NULL,
  `backgroundColorToHover` varchar(25) NOT NULL,
  `gradientDirection` tinyint(3) unsigned NOT NULL,
  `gradientDirectionHover` tinyint(3) unsigned NOT NULL,
  `hasBackgroundGradient` tinyint(1) unsigned NOT NULL,
  `hasBackgroundHover` tinyint(1) unsigned NOT NULL,
  `hasBackgroundAnimation` tinyint(1) unsigned NOT NULL,
  `imageInstanceId` int(11) unsigned DEFAULT NULL,
  `backgroundPosition` tinyint(3) unsigned NOT NULL,
  `backgroundRepeat` tinyint(3) unsigned NOT NULL,
  `isBackgroundCover` tinyint(1) unsigned NOT NULL,
  `borderTopLeftRadius` smallint(5) unsigned NOT NULL,
  `borderTopLeftRadiusHover` smallint(5) unsigned NOT NULL,
  `borderTopRightRadius` smallint(5) unsigned NOT NULL,
  `borderTopRightRadiusHover` smallint(5) unsigned NOT NULL,
  `borderBottomRightRadius` smallint(5) unsigned NOT NULL,
  `borderBottomRightRadiusHover` smallint(5) unsigned NOT NULL,
  `borderBottomLeftRadius` smallint(5) unsigned NOT NULL,
  `borderBottomLeftRadiusHover` smallint(5) unsigned NOT NULL,
  `borderTopWidth` smallint(5) unsigned NOT NULL,
  `borderTopWidthHover` smallint(5) unsigned NOT NULL,
  `borderRightWidth` smallint(5) unsigned NOT NULL,
  `borderRightWidthHover` smallint(5) unsigned NOT NULL,
  `borderBottomWidth` smallint(5) unsigned NOT NULL,
  `borderBottomWidthHover` smallint(5) unsigned NOT NULL,
  `borderLeftWidth` smallint(5) unsigned NOT NULL,
  `borderLeftWidthHover` smallint(5) unsigned NOT NULL,
  `borderStyle` tinyint(3) unsigned NOT NULL,
  `borderStyleHover` tinyint(3) unsigned NOT NULL,
  `borderColor` varchar(25) NOT NULL,
  `borderColorHover` varchar(25) NOT NULL,
  `hasBorderHover` tinyint(1) unsigned NOT NULL,
  `hasBorderAnimation` tinyint(1) unsigned NOT NULL,
  `width` smallint(5) unsigned NOT NULL,
  `height` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `designBlocks_imageInstanceId_fk` (`imageInstanceId`),
  CONSTRAINT `designBlocks_imageInstanceId_fk` FOREIGN KEY (`imageInstanceId`) REFERENCES `imageInstances` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `designBlocks`
--

LOCK TABLES `designBlocks` WRITE;
/*!40000 ALTER TABLE `designBlocks` DISABLE KEYS */;
/*!40000 ALTER TABLE `designBlocks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `designCatalogs`
--

DROP TABLE IF EXISTS `designCatalogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `designCatalogs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `shortCardContainerDesignBlockId` int(11) unsigned NOT NULL,
  `shortCardInstanceDesignBlockId` int(11) unsigned NOT NULL,
  `shortCardTitleDesignBlockId` int(11) unsigned NOT NULL,
  `shortCardTitleDesignTextId` int(11) unsigned NOT NULL,
  `shortCardDateDesignTextId` int(11) unsigned NOT NULL,
  `shortCardPriceDesignBlockId` int(11) unsigned NOT NULL,
  `shortCardPriceDesignTextId` int(11) unsigned NOT NULL,
  `shortCardOldPriceDesignBlockId` int(11) unsigned NOT NULL,
  `shortCardOldPriceDesignTextId` int(11) unsigned NOT NULL,
  `shortCardDescriptionDesignBlockId` int(11) unsigned NOT NULL,
  `shortCardDescriptionDesignTextId` int(11) unsigned NOT NULL,
  `shortCardPaginationDesignBlockId` int(11) unsigned NOT NULL,
  `shortCardPaginationItemDesignBlockId` int(11) unsigned NOT NULL,
  `shortCardPaginationItemDesignTextId` int(11) unsigned NOT NULL,
  `fullCardContainerDesignBlockId` int(11) unsigned NOT NULL,
  `fullCardTitleDesignBlockId` int(11) unsigned NOT NULL,
  `fullCardTitleDesignTextId` int(11) unsigned NOT NULL,
  `fullCardDateDesignTextId` int(11) unsigned NOT NULL,
  `fullCardPriceDesignBlockId` int(11) unsigned NOT NULL,
  `fullCardPriceDesignTextId` int(11) unsigned NOT NULL,
  `fullCardOldPriceDesignBlockId` int(11) unsigned NOT NULL,
  `fullCardOldPriceDesignTextId` int(11) unsigned NOT NULL,
  `fullCardBinButtonDesignBlockId` int(11) unsigned NOT NULL,
  `fullCardBinButtonDesignTextId` int(11) unsigned NOT NULL,
  `shortCardViewType` tinyint(3) unsigned NOT NULL,
  `fullCardImagesPosition` tinyint(3) unsigned NOT NULL,
  `fullCardDatePosition` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `designCatalogs_shortCardContainerDesignBlockId_fk` (`shortCardContainerDesignBlockId`),
  KEY `designCatalogs_shortCardInstanceDesignBlockId_fk` (`shortCardInstanceDesignBlockId`),
  KEY `designCatalogs_shortCardTitleDesignBlockId_fk` (`shortCardTitleDesignBlockId`),
  KEY `designCatalogs_shortCardTitleDesignTextId_fk` (`shortCardTitleDesignTextId`),
  KEY `designCatalogs_shortCardDateDesignTextId_fk` (`shortCardDateDesignTextId`),
  KEY `designCatalogs_shortCardPriceDesignBlockId_fk` (`shortCardPriceDesignBlockId`),
  KEY `designCatalogs_shortCardPriceDesignTextId_fk` (`shortCardPriceDesignTextId`),
  KEY `designCatalogs_shortCardOldPriceDesignBlockId_fk` (`shortCardOldPriceDesignBlockId`),
  KEY `designCatalogs_shortCardOldPriceDesignTextId_fk` (`shortCardOldPriceDesignTextId`),
  KEY `designCatalogs_shortCardDescriptionDesignBlockId_fk` (`shortCardDescriptionDesignBlockId`),
  KEY `designCatalogs_shortCardDescriptionDesignTextId_fk` (`shortCardDescriptionDesignTextId`),
  KEY `designCatalogs_shortCardPaginationDesignBlockId_fk` (`shortCardPaginationDesignBlockId`),
  KEY `designCatalogs_shortCardPaginationItemDesignBlockId_fk` (`shortCardPaginationItemDesignBlockId`),
  KEY `designCatalogs_shortCardPaginationItemDesignTextId_fk` (`shortCardPaginationItemDesignTextId`),
  KEY `designCatalogs_fullCardContainerDesignBlockId_fk` (`fullCardContainerDesignBlockId`),
  KEY `designCatalogs_fullCardTitleDesignBlockId_fk` (`fullCardTitleDesignBlockId`),
  KEY `designCatalogs_fullCardTitleDesignTextId_fk` (`fullCardTitleDesignTextId`),
  KEY `designCatalogs_fullCardDateDesignTextId_fk` (`fullCardDateDesignTextId`),
  KEY `designCatalogs_fullCardPriceDesignBlockId_fk` (`fullCardPriceDesignBlockId`),
  KEY `designCatalogs_fullCardPriceDesignTextId_fk` (`fullCardPriceDesignTextId`),
  KEY `designCatalogs_fullCardOldPriceDesignBlockId_fk` (`fullCardOldPriceDesignBlockId`),
  KEY `designCatalogs_fullCardOldPriceDesignTextId_fk` (`fullCardOldPriceDesignTextId`),
  KEY `designCatalogs_fullCardBinButtonDesignBlockId_fk` (`fullCardBinButtonDesignBlockId`),
  KEY `designCatalogs_fullCardBinButtonDesignTextId_fk` (`fullCardBinButtonDesignTextId`),
  CONSTRAINT `designCatalogs_fullCardBinButtonDesignBlockId_fk` FOREIGN KEY (`fullCardBinButtonDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `designCatalogs_fullCardBinButtonDesignTextId_fk` FOREIGN KEY (`fullCardBinButtonDesignTextId`) REFERENCES `designTexts` (`id`),
  CONSTRAINT `designCatalogs_fullCardContainerDesignBlockId_fk` FOREIGN KEY (`fullCardContainerDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `designCatalogs_fullCardDateDesignTextId_fk` FOREIGN KEY (`fullCardDateDesignTextId`) REFERENCES `designTexts` (`id`),
  CONSTRAINT `designCatalogs_fullCardOldPriceDesignBlockId_fk` FOREIGN KEY (`fullCardOldPriceDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `designCatalogs_fullCardOldPriceDesignTextId_fk` FOREIGN KEY (`fullCardOldPriceDesignTextId`) REFERENCES `designTexts` (`id`),
  CONSTRAINT `designCatalogs_fullCardPriceDesignBlockId_fk` FOREIGN KEY (`fullCardPriceDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `designCatalogs_fullCardPriceDesignTextId_fk` FOREIGN KEY (`fullCardPriceDesignTextId`) REFERENCES `designTexts` (`id`),
  CONSTRAINT `designCatalogs_fullCardTitleDesignBlockId_fk` FOREIGN KEY (`fullCardTitleDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `designCatalogs_fullCardTitleDesignTextId_fk` FOREIGN KEY (`fullCardTitleDesignTextId`) REFERENCES `designTexts` (`id`),
  CONSTRAINT `designCatalogs_shortCardContainerDesignBlockId_fk` FOREIGN KEY (`shortCardContainerDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `designCatalogs_shortCardDateDesignTextId_fk` FOREIGN KEY (`shortCardDateDesignTextId`) REFERENCES `designTexts` (`id`),
  CONSTRAINT `designCatalogs_shortCardDescriptionDesignBlockId_fk` FOREIGN KEY (`shortCardDescriptionDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `designCatalogs_shortCardDescriptionDesignTextId_fk` FOREIGN KEY (`shortCardDescriptionDesignTextId`) REFERENCES `designTexts` (`id`),
  CONSTRAINT `designCatalogs_shortCardInstanceDesignBlockId_fk` FOREIGN KEY (`shortCardInstanceDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `designCatalogs_shortCardOldPriceDesignBlockId_fk` FOREIGN KEY (`shortCardOldPriceDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `designCatalogs_shortCardOldPriceDesignTextId_fk` FOREIGN KEY (`shortCardOldPriceDesignTextId`) REFERENCES `designTexts` (`id`),
  CONSTRAINT `designCatalogs_shortCardPaginationDesignBlockId_fk` FOREIGN KEY (`shortCardPaginationDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `designCatalogs_shortCardPaginationItemDesignBlockId_fk` FOREIGN KEY (`shortCardPaginationItemDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `designCatalogs_shortCardPaginationItemDesignTextId_fk` FOREIGN KEY (`shortCardPaginationItemDesignTextId`) REFERENCES `designTexts` (`id`),
  CONSTRAINT `designCatalogs_shortCardPriceDesignBlockId_fk` FOREIGN KEY (`shortCardPriceDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `designCatalogs_shortCardPriceDesignTextId_fk` FOREIGN KEY (`shortCardPriceDesignTextId`) REFERENCES `designTexts` (`id`),
  CONSTRAINT `designCatalogs_shortCardTitleDesignBlockId_fk` FOREIGN KEY (`shortCardTitleDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `designCatalogs_shortCardTitleDesignTextId_fk` FOREIGN KEY (`shortCardTitleDesignTextId`) REFERENCES `designTexts` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `designCatalogs`
--

LOCK TABLES `designCatalogs` WRITE;
/*!40000 ALTER TABLE `designCatalogs` DISABLE KEYS */;
/*!40000 ALTER TABLE `designCatalogs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `designFields`
--

DROP TABLE IF EXISTS `designFields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `designFields` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `shortCardContainerDesignBlockId` int(11) unsigned NOT NULL,
  `shortCardLabelDesignBlockId` int(11) unsigned NOT NULL,
  `shortCardLabelDesignTextId` int(11) unsigned NOT NULL,
  `shortCardValueDesignBlockId` int(11) unsigned NOT NULL,
  `shortCardValueDesignTextId` int(11) unsigned NOT NULL,
  `fullCardContainerDesignBlockId` int(11) unsigned NOT NULL,
  `fullCardLabelDesignBlockId` int(11) unsigned NOT NULL,
  `fullCardLabelDesignTextId` int(11) unsigned NOT NULL,
  `fullCardValueDesignBlockId` int(11) unsigned NOT NULL,
  `fullCardValueDesignTextId` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `designFields_shortCardContainerDesignBlockId_fk` (`shortCardContainerDesignBlockId`),
  KEY `designFields_shortCardLabelDesignBlockId_fk` (`shortCardLabelDesignBlockId`),
  KEY `designFields_shortCardLabelDesignTextId_fk` (`shortCardLabelDesignTextId`),
  KEY `designFields_shortCardValueDesignBlockId_fk` (`shortCardValueDesignBlockId`),
  KEY `designFields_shortCardValueDesignTextId_fk` (`shortCardValueDesignTextId`),
  KEY `designFields_fullCardContainerDesignBlockId_fk` (`fullCardContainerDesignBlockId`),
  KEY `designFields_fullCardLabelDesignBlockId_fk` (`fullCardLabelDesignBlockId`),
  KEY `designFields_fullCardLabelDesignTextId_fk` (`fullCardLabelDesignTextId`),
  KEY `designFields_fullCardValueDesignBlockId_fk` (`fullCardValueDesignBlockId`),
  KEY `designFields_fullCardValueDesignTextId_fk` (`fullCardValueDesignTextId`),
  CONSTRAINT `designFields_fullCardContainerDesignBlockId_fk` FOREIGN KEY (`fullCardContainerDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `designFields_fullCardLabelDesignBlockId_fk` FOREIGN KEY (`fullCardLabelDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `designFields_fullCardLabelDesignTextId_fk` FOREIGN KEY (`fullCardLabelDesignTextId`) REFERENCES `designTexts` (`id`),
  CONSTRAINT `designFields_fullCardValueDesignBlockId_fk` FOREIGN KEY (`fullCardValueDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `designFields_fullCardValueDesignTextId_fk` FOREIGN KEY (`fullCardValueDesignTextId`) REFERENCES `designTexts` (`id`),
  CONSTRAINT `designFields_shortCardContainerDesignBlockId_fk` FOREIGN KEY (`shortCardContainerDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `designFields_shortCardLabelDesignBlockId_fk` FOREIGN KEY (`shortCardLabelDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `designFields_shortCardLabelDesignTextId_fk` FOREIGN KEY (`shortCardLabelDesignTextId`) REFERENCES `designTexts` (`id`),
  CONSTRAINT `designFields_shortCardValueDesignBlockId_fk` FOREIGN KEY (`shortCardValueDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `designFields_shortCardValueDesignTextId_fk` FOREIGN KEY (`shortCardValueDesignTextId`) REFERENCES `designTexts` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `designFields`
--

LOCK TABLES `designFields` WRITE;
/*!40000 ALTER TABLE `designFields` DISABLE KEYS */;
/*!40000 ALTER TABLE `designFields` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `designForms`
--

DROP TABLE IF EXISTS `designForms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `designForms` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `containerDesignBlockId` int(11) unsigned NOT NULL,
  `lineDesignBlockId` int(11) unsigned NOT NULL,
  `labelDesignBlockId` int(11) unsigned NOT NULL,
  `labelDesignTextId` int(11) unsigned NOT NULL,
  `formDesignBlockId` int(11) unsigned NOT NULL,
  `formDesignTextId` int(11) unsigned NOT NULL,
  `submitDesignBlockId` int(11) unsigned NOT NULL,
  `submitDesignTextId` int(11) unsigned NOT NULL,
  `submitIconDesignTextId` int(11) unsigned NOT NULL,
  `submitIcon` varchar(50) NOT NULL,
  `submitIconPosition` tinyint(3) unsigned NOT NULL,
  `submitAlignment` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `designForms_containerDesignBlockId_fk` (`containerDesignBlockId`),
  KEY `designForms_lineDesignBlockId_fk` (`lineDesignBlockId`),
  KEY `designForms_labelDesignBlockId_fk` (`labelDesignBlockId`),
  KEY `designForms_labelDesignTextId_fk` (`labelDesignTextId`),
  KEY `designForms_formDesignBlockId_fk` (`formDesignBlockId`),
  KEY `designForms_formDesignTextId_fk` (`formDesignTextId`),
  KEY `designForms_submitDesignBlockId_fk` (`submitDesignBlockId`),
  KEY `designForms_submitDesignTextId_fk` (`submitDesignTextId`),
  KEY `designForms_submitIconDesignTextId_fk` (`submitIconDesignTextId`),
  CONSTRAINT `designForms_containerDesignBlockId_fk` FOREIGN KEY (`containerDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `designForms_formDesignBlockId_fk` FOREIGN KEY (`formDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `designForms_formDesignTextId_fk` FOREIGN KEY (`formDesignTextId`) REFERENCES `designTexts` (`id`),
  CONSTRAINT `designForms_labelDesignBlockId_fk` FOREIGN KEY (`labelDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `designForms_labelDesignTextId_fk` FOREIGN KEY (`labelDesignTextId`) REFERENCES `designTexts` (`id`),
  CONSTRAINT `designForms_lineDesignBlockId_fk` FOREIGN KEY (`lineDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `designForms_submitDesignBlockId_fk` FOREIGN KEY (`submitDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `designForms_submitDesignTextId_fk` FOREIGN KEY (`submitDesignTextId`) REFERENCES `designTexts` (`id`),
  CONSTRAINT `designForms_submitIconDesignTextId_fk` FOREIGN KEY (`submitIconDesignTextId`) REFERENCES `designTexts` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `designForms`
--

LOCK TABLES `designForms` WRITE;
/*!40000 ALTER TABLE `designForms` DISABLE KEYS */;
/*!40000 ALTER TABLE `designForms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `designImageAlbums`
--

DROP TABLE IF EXISTS `designImageAlbums`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `designImageAlbums` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `containerDesignBlockId` int(11) unsigned NOT NULL,
  `imageDesignBlockId` int(11) unsigned NOT NULL,
  `nameDesignBlockId` int(11) unsigned NOT NULL,
  `nameDesignTextId` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `designImageAlbums_containerDesignBlockId_fk` (`containerDesignBlockId`),
  KEY `designImageAlbums_imageDesignBlockId_fk` (`imageDesignBlockId`),
  KEY `designImageAlbums_nameDesignBlockId_fk` (`nameDesignBlockId`),
  KEY `designImageAlbums_nameDesignTextId_fk` (`nameDesignTextId`),
  CONSTRAINT `designImageAlbums_containerDesignBlockId_fk` FOREIGN KEY (`containerDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `designImageAlbums_imageDesignBlockId_fk` FOREIGN KEY (`imageDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `designImageAlbums_nameDesignBlockId_fk` FOREIGN KEY (`nameDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `designImageAlbums_nameDesignTextId_fk` FOREIGN KEY (`nameDesignTextId`) REFERENCES `designTexts` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `designImageAlbums`
--

LOCK TABLES `designImageAlbums` WRITE;
/*!40000 ALTER TABLE `designImageAlbums` DISABLE KEYS */;
/*!40000 ALTER TABLE `designImageAlbums` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `designImageSimple`
--

DROP TABLE IF EXISTS `designImageSimple`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `designImageSimple` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `containerDesignBlockId` int(11) unsigned NOT NULL,
  `imageDesignBlockId` int(11) unsigned NOT NULL,
  `descriptionDesignBlockId` int(11) unsigned NOT NULL,
  `descriptionDesignTextId` int(11) unsigned NOT NULL,
  `useDescription` tinyint(1) unsigned NOT NULL,
  `alignment` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `designImageSimple_containerDesignBlockId_fk` (`containerDesignBlockId`),
  KEY `designImageSimple_imageDesignBlockId_fk` (`imageDesignBlockId`),
  KEY `designImageSimple_descriptionDesignBlockId_fk` (`descriptionDesignBlockId`),
  KEY `designImageSimple_descriptionDesignTextId_fk` (`descriptionDesignTextId`),
  CONSTRAINT `designImageSimple_containerDesignBlockId_fk` FOREIGN KEY (`containerDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `designImageSimple_descriptionDesignBlockId_fk` FOREIGN KEY (`descriptionDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `designImageSimple_descriptionDesignTextId_fk` FOREIGN KEY (`descriptionDesignTextId`) REFERENCES `designTexts` (`id`),
  CONSTRAINT `designImageSimple_imageDesignBlockId_fk` FOREIGN KEY (`imageDesignBlockId`) REFERENCES `designBlocks` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `designImageSimple`
--

LOCK TABLES `designImageSimple` WRITE;
/*!40000 ALTER TABLE `designImageSimple` DISABLE KEYS */;
/*!40000 ALTER TABLE `designImageSimple` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `designImageSliders`
--

DROP TABLE IF EXISTS `designImageSliders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `designImageSliders` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `arrowDesignTextId` int(11) unsigned NOT NULL,
  `bulletDesignBlockId` int(11) unsigned NOT NULL,
  `bulletActiveDesignBlockId` int(11) unsigned NOT NULL,
  `descriptionDesignBlockId` int(11) unsigned NOT NULL,
  `descriptionDesignTextId` int(11) unsigned NOT NULL,
  `isFullWidth` tinyint(1) unsigned NOT NULL,
  `hasDescription` tinyint(1) unsigned NOT NULL,
  `effect` text NOT NULL,
  `hasAutoPlay` tinyint(1) unsigned NOT NULL,
  `playSpeed` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `designImageSliders_arrowDesignTextId_fk` (`arrowDesignTextId`),
  KEY `designImageSliders_bulletDesignBlockId_fk` (`bulletDesignBlockId`),
  KEY `designImageSliders_bulletActiveDesignBlockId_fk` (`bulletActiveDesignBlockId`),
  KEY `designImageSliders_descriptionDesignBlockId_fk` (`descriptionDesignBlockId`),
  KEY `designImageSliders_descriptionDesignTextId_fk` (`descriptionDesignTextId`),
  CONSTRAINT `designImageSliders_arrowDesignTextId_fk` FOREIGN KEY (`arrowDesignTextId`) REFERENCES `designTexts` (`id`),
  CONSTRAINT `designImageSliders_bulletActiveDesignBlockId_fk` FOREIGN KEY (`bulletActiveDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `designImageSliders_bulletDesignBlockId_fk` FOREIGN KEY (`bulletDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `designImageSliders_descriptionDesignBlockId_fk` FOREIGN KEY (`descriptionDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `designImageSliders_descriptionDesignTextId_fk` FOREIGN KEY (`descriptionDesignTextId`) REFERENCES `designTexts` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `designImageSliders`
--

LOCK TABLES `designImageSliders` WRITE;
/*!40000 ALTER TABLE `designImageSliders` DISABLE KEYS */;
/*!40000 ALTER TABLE `designImageSliders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `designImageZooms`
--

DROP TABLE IF EXISTS `designImageZooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `designImageZooms` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `designBlockId` int(11) unsigned NOT NULL,
  `effect` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `designImageZooms_designBlockId_fk` (`designBlockId`),
  CONSTRAINT `designImageZooms_designBlockId_fk` FOREIGN KEY (`designBlockId`) REFERENCES `designBlocks` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `designImageZooms`
--

LOCK TABLES `designImageZooms` WRITE;
/*!40000 ALTER TABLE `designImageZooms` DISABLE KEYS */;
/*!40000 ALTER TABLE `designImageZooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `designMenu`
--

DROP TABLE IF EXISTS `designMenu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `designMenu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `containerDesignBlockId` int(11) unsigned NOT NULL,
  `firstLevelDesignBlockId` int(11) unsigned NOT NULL,
  `firstLevelDesignTextId` int(11) unsigned NOT NULL,
  `firstLevelActiveDesignBlockId` int(11) unsigned NOT NULL,
  `firstLevelActiveDesignTextId` int(11) unsigned NOT NULL,
  `secondLevelDesignBlockId` int(11) unsigned NOT NULL,
  `secondLevelDesignTextId` int(11) unsigned NOT NULL,
  `secondLevelActiveDesignBlockId` int(11) unsigned NOT NULL,
  `secondLevelActiveDesignTextId` int(11) unsigned NOT NULL,
  `lastLevelDesignBlockId` int(11) unsigned NOT NULL,
  `lastLevelDesignTextId` int(11) unsigned NOT NULL,
  `lastLevelActiveDesignBlockId` int(11) unsigned NOT NULL,
  `lastLevelActiveDesignTextId` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `designMenu_containerDesignBlockId_fk` (`containerDesignBlockId`),
  KEY `designMenu_firstLevelDesignBlockId_fk` (`firstLevelDesignBlockId`),
  KEY `designMenu_firstLevelDesignTextId_fk` (`firstLevelDesignTextId`),
  KEY `designMenu_firstLevelActiveDesignBlockId_fk` (`firstLevelActiveDesignBlockId`),
  KEY `designMenu_firstLevelActiveDesignTextId_fk` (`firstLevelActiveDesignTextId`),
  KEY `designMenu_secondLevelDesignBlockId_fk` (`secondLevelDesignBlockId`),
  KEY `designMenu_secondLevelDesignTextId_fk` (`secondLevelDesignTextId`),
  KEY `designMenu_secondLevelActiveDesignBlockId_fk` (`secondLevelActiveDesignBlockId`),
  KEY `designMenu_secondLevelActiveDesignTextId_fk` (`secondLevelActiveDesignTextId`),
  KEY `designMenu_lastLevelDesignBlockId_fk` (`lastLevelDesignBlockId`),
  KEY `designMenu_lastLevelDesignTextId_fk` (`lastLevelDesignTextId`),
  KEY `designMenu_lastLevelActiveDesignBlockId_fk` (`lastLevelActiveDesignBlockId`),
  KEY `designMenu_lastLevelActiveDesignTextId_fk` (`lastLevelActiveDesignTextId`),
  CONSTRAINT `designMenu_containerDesignBlockId_fk` FOREIGN KEY (`containerDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `designMenu_firstLevelActiveDesignBlockId_fk` FOREIGN KEY (`firstLevelActiveDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `designMenu_firstLevelActiveDesignTextId_fk` FOREIGN KEY (`firstLevelActiveDesignTextId`) REFERENCES `designTexts` (`id`),
  CONSTRAINT `designMenu_firstLevelDesignBlockId_fk` FOREIGN KEY (`firstLevelDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `designMenu_firstLevelDesignTextId_fk` FOREIGN KEY (`firstLevelDesignTextId`) REFERENCES `designTexts` (`id`),
  CONSTRAINT `designMenu_lastLevelActiveDesignBlockId_fk` FOREIGN KEY (`lastLevelActiveDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `designMenu_lastLevelActiveDesignTextId_fk` FOREIGN KEY (`lastLevelActiveDesignTextId`) REFERENCES `designTexts` (`id`),
  CONSTRAINT `designMenu_lastLevelDesignBlockId_fk` FOREIGN KEY (`lastLevelDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `designMenu_lastLevelDesignTextId_fk` FOREIGN KEY (`lastLevelDesignTextId`) REFERENCES `designTexts` (`id`),
  CONSTRAINT `designMenu_secondLevelActiveDesignBlockId_fk` FOREIGN KEY (`secondLevelActiveDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `designMenu_secondLevelActiveDesignTextId_fk` FOREIGN KEY (`secondLevelActiveDesignTextId`) REFERENCES `designTexts` (`id`),
  CONSTRAINT `designMenu_secondLevelDesignBlockId_fk` FOREIGN KEY (`secondLevelDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `designMenu_secondLevelDesignTextId_fk` FOREIGN KEY (`secondLevelDesignTextId`) REFERENCES `designTexts` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `designMenu`
--

LOCK TABLES `designMenu` WRITE;
/*!40000 ALTER TABLE `designMenu` DISABLE KEYS */;
/*!40000 ALTER TABLE `designMenu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `designRecordClones`
--

DROP TABLE IF EXISTS `designRecordClones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `designRecordClones` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `containerDesignBlockId` int(11) unsigned NOT NULL,
  `instanceDesignBlockId` int(11) unsigned NOT NULL,
  `titleDesignBlockId` int(11) unsigned NOT NULL,
  `titleDesignTextId` int(11) unsigned NOT NULL,
  `dateDesignBlockId` int(11) unsigned NOT NULL,
  `dateDesignTextId` int(11) unsigned NOT NULL,
  `descriptionDesignBlockId` int(11) unsigned NOT NULL,
  `descriptionDesignTextId` int(11) unsigned NOT NULL,
  `viewType` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `designRecordClones_containerDesignBlockId_fk` (`containerDesignBlockId`),
  KEY `designRecordClones_instanceDesignBlockId_fk` (`instanceDesignBlockId`),
  KEY `designRecordClones_titleDesignBlockId_fk` (`titleDesignBlockId`),
  KEY `designRecordClones_titleDesignTextId_fk` (`titleDesignTextId`),
  KEY `designRecordClones_dateDesignBlockId_fk` (`dateDesignBlockId`),
  KEY `designRecordClones_dateDesignTextId_fk` (`dateDesignTextId`),
  KEY `designRecordClones_descriptionDesignBlockId_fk` (`descriptionDesignBlockId`),
  KEY `designRecordClones_descriptionDesignTextId_fk` (`descriptionDesignTextId`),
  CONSTRAINT `designRecordClones_containerDesignBlockId_fk` FOREIGN KEY (`containerDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `designRecordClones_dateDesignBlockId_fk` FOREIGN KEY (`dateDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `designRecordClones_dateDesignTextId_fk` FOREIGN KEY (`dateDesignTextId`) REFERENCES `designTexts` (`id`),
  CONSTRAINT `designRecordClones_descriptionDesignBlockId_fk` FOREIGN KEY (`descriptionDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `designRecordClones_descriptionDesignTextId_fk` FOREIGN KEY (`descriptionDesignTextId`) REFERENCES `designTexts` (`id`),
  CONSTRAINT `designRecordClones_instanceDesignBlockId_fk` FOREIGN KEY (`instanceDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `designRecordClones_titleDesignBlockId_fk` FOREIGN KEY (`titleDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `designRecordClones_titleDesignTextId_fk` FOREIGN KEY (`titleDesignTextId`) REFERENCES `designTexts` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `designRecordClones`
--

LOCK TABLES `designRecordClones` WRITE;
/*!40000 ALTER TABLE `designRecordClones` DISABLE KEYS */;
/*!40000 ALTER TABLE `designRecordClones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `designRecords`
--

DROP TABLE IF EXISTS `designRecords`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `designRecords` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `shortCardContainerDesignBlockId` int(11) unsigned NOT NULL,
  `shortCardInstanceDesignBlockId` int(11) unsigned NOT NULL,
  `shortCardTitleDesignBlockId` int(11) unsigned NOT NULL,
  `shortCardTitleDesignTextId` int(11) unsigned NOT NULL,
  `shortCardDateDesignBlockId` int(11) unsigned NOT NULL,
  `shortCardDateDesignTextId` int(11) unsigned NOT NULL,
  `shortCardDescriptionDesignBlockId` int(11) unsigned NOT NULL,
  `shortCardDescriptionDesignTextId` int(11) unsigned NOT NULL,
  `shortCardPaginationDesignBlockId` int(11) unsigned NOT NULL,
  `shortCardPaginationItemDesignBlockId` int(11) unsigned NOT NULL,
  `shortCardPaginationItemDesignTextId` int(11) unsigned NOT NULL,
  `shortCardViewType` tinyint(3) unsigned NOT NULL,
  `fullCardContainerDesignBlockId` int(11) unsigned NOT NULL,
  `fullCardTitleDesignBlockId` int(11) unsigned NOT NULL,
  `fullCardTitleDesignTextId` int(11) unsigned NOT NULL,
  `fullCardDateDesignBlockId` int(11) unsigned NOT NULL,
  `fullCardDateDesignTextId` int(11) unsigned NOT NULL,
  `fullCardTextDesignBlockId` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `designRecords_shortCardContainerDesignBlockId_fk` (`shortCardContainerDesignBlockId`),
  KEY `designRecords_shortCardInstanceDesignBlockId_fk` (`shortCardInstanceDesignBlockId`),
  KEY `designRecords_shortCardTitleDesignBlockId_fk` (`shortCardTitleDesignBlockId`),
  KEY `designRecords_shortCardTitleDesignTextId_fk` (`shortCardTitleDesignTextId`),
  KEY `designRecords_shortCardDateDesignBlockId_fk` (`shortCardDateDesignBlockId`),
  KEY `designRecords_shortCardDateDesignTextId_fk` (`shortCardDateDesignTextId`),
  KEY `designRecords_shortCardDescriptionDesignBlockId_fk` (`shortCardDescriptionDesignBlockId`),
  KEY `designRecords_shortCardDescriptionDesignTextId_fk` (`shortCardDescriptionDesignTextId`),
  KEY `designRecords_shortCardPaginationDesignBlockId_fk` (`shortCardPaginationDesignBlockId`),
  KEY `designRecords_shortCardPaginationItemDesignBlockId_fk` (`shortCardPaginationItemDesignBlockId`),
  KEY `designRecords_shortCardPaginationItemDesignTextId_fk` (`shortCardPaginationItemDesignTextId`),
  KEY `designRecords_fullCardContainerDesignBlockId_fk` (`fullCardContainerDesignBlockId`),
  KEY `designRecords_fullCardTitleDesignBlockId_fk` (`fullCardTitleDesignBlockId`),
  KEY `designRecords_fullCardTitleDesignTextId_fk` (`fullCardTitleDesignTextId`),
  KEY `designRecords_fullCardDateDesignBlockId_fk` (`fullCardDateDesignBlockId`),
  KEY `designRecords_fullCardDateDesignTextId_fk` (`fullCardDateDesignTextId`),
  KEY `designRecords_fullCardTextDesignBlockId_fk` (`fullCardTextDesignBlockId`),
  CONSTRAINT `designRecords_fullCardContainerDesignBlockId_fk` FOREIGN KEY (`fullCardContainerDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `designRecords_fullCardDateDesignBlockId_fk` FOREIGN KEY (`fullCardDateDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `designRecords_fullCardDateDesignTextId_fk` FOREIGN KEY (`fullCardDateDesignTextId`) REFERENCES `designTexts` (`id`),
  CONSTRAINT `designRecords_fullCardTextDesignBlockId_fk` FOREIGN KEY (`fullCardTextDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `designRecords_fullCardTitleDesignBlockId_fk` FOREIGN KEY (`fullCardTitleDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `designRecords_fullCardTitleDesignTextId_fk` FOREIGN KEY (`fullCardTitleDesignTextId`) REFERENCES `designTexts` (`id`),
  CONSTRAINT `designRecords_shortCardContainerDesignBlockId_fk` FOREIGN KEY (`shortCardContainerDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `designRecords_shortCardDateDesignBlockId_fk` FOREIGN KEY (`shortCardDateDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `designRecords_shortCardDateDesignTextId_fk` FOREIGN KEY (`shortCardDateDesignTextId`) REFERENCES `designTexts` (`id`),
  CONSTRAINT `designRecords_shortCardDescriptionDesignBlockId_fk` FOREIGN KEY (`shortCardDescriptionDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `designRecords_shortCardDescriptionDesignTextId_fk` FOREIGN KEY (`shortCardDescriptionDesignTextId`) REFERENCES `designTexts` (`id`),
  CONSTRAINT `designRecords_shortCardInstanceDesignBlockId_fk` FOREIGN KEY (`shortCardInstanceDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `designRecords_shortCardPaginationDesignBlockId_fk` FOREIGN KEY (`shortCardPaginationDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `designRecords_shortCardPaginationItemDesignBlockId_fk` FOREIGN KEY (`shortCardPaginationItemDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `designRecords_shortCardPaginationItemDesignTextId_fk` FOREIGN KEY (`shortCardPaginationItemDesignTextId`) REFERENCES `designTexts` (`id`),
  CONSTRAINT `designRecords_shortCardTitleDesignBlockId_fk` FOREIGN KEY (`shortCardTitleDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `designRecords_shortCardTitleDesignTextId_fk` FOREIGN KEY (`shortCardTitleDesignTextId`) REFERENCES `designTexts` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `designRecords`
--

LOCK TABLES `designRecords` WRITE;
/*!40000 ALTER TABLE `designRecords` DISABLE KEYS */;
/*!40000 ALTER TABLE `designRecords` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `designSearch`
--

DROP TABLE IF EXISTS `designSearch`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `designSearch` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `containerDesignBlockId` int(11) unsigned NOT NULL,
  `titleDesignBlockId` int(11) unsigned NOT NULL,
  `titleDesignTextId` int(11) unsigned NOT NULL,
  `descriptionDesignBlockId` int(11) unsigned NOT NULL,
  `descriptionDesignTextId` int(11) unsigned NOT NULL,
  `paginationDesignBlockId` int(11) unsigned NOT NULL,
  `paginationItemDesignBlockId` int(11) unsigned NOT NULL,
  `paginationItemDesignTextId` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `designSearch_containerDesignBlockId_fk` (`containerDesignBlockId`),
  KEY `designSearch_titleDesignBlockId_fk` (`titleDesignBlockId`),
  KEY `designSearch_titleDesignTextId_fk` (`titleDesignTextId`),
  KEY `designSearch_descriptionDesignBlockId_fk` (`descriptionDesignBlockId`),
  KEY `designSearch_descriptionDesignTextId_fk` (`descriptionDesignTextId`),
  KEY `designSearch_paginationDesignBlockId_fk` (`paginationDesignBlockId`),
  KEY `designSearch_paginationItemDesignBlockId_fk` (`paginationItemDesignBlockId`),
  KEY `designSearch_paginationItemDesignTextId_fk` (`paginationItemDesignTextId`),
  CONSTRAINT `designSearch_containerDesignBlockId_fk` FOREIGN KEY (`containerDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `designSearch_descriptionDesignBlockId_fk` FOREIGN KEY (`descriptionDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `designSearch_descriptionDesignTextId_fk` FOREIGN KEY (`descriptionDesignTextId`) REFERENCES `designTexts` (`id`),
  CONSTRAINT `designSearch_paginationDesignBlockId_fk` FOREIGN KEY (`paginationDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `designSearch_paginationItemDesignBlockId_fk` FOREIGN KEY (`paginationItemDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `designSearch_paginationItemDesignTextId_fk` FOREIGN KEY (`paginationItemDesignTextId`) REFERENCES `designTexts` (`id`),
  CONSTRAINT `designSearch_titleDesignBlockId_fk` FOREIGN KEY (`titleDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `designSearch_titleDesignTextId_fk` FOREIGN KEY (`titleDesignTextId`) REFERENCES `designTexts` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `designSearch`
--

LOCK TABLES `designSearch` WRITE;
/*!40000 ALTER TABLE `designSearch` DISABLE KEYS */;
/*!40000 ALTER TABLE `designSearch` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `designTabs`
--

DROP TABLE IF EXISTS `designTabs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `designTabs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `containerDesignBlockId` int(11) unsigned NOT NULL,
  `tabDesignBlockId` int(11) unsigned NOT NULL,
  `tabDesignTextId` int(11) unsigned NOT NULL,
  `contentDesignBlockId` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `designTabs_containerDesignBlockId_fk` (`containerDesignBlockId`),
  KEY `designTabs_tabDesignBlockId_fk` (`tabDesignBlockId`),
  KEY `designTabs_tabDesignTextId_fk` (`tabDesignTextId`),
  KEY `designTabs_contentDesignBlockId_fk` (`contentDesignBlockId`),
  CONSTRAINT `designTabs_containerDesignBlockId_fk` FOREIGN KEY (`containerDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `designTabs_contentDesignBlockId_fk` FOREIGN KEY (`contentDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `designTabs_tabDesignBlockId_fk` FOREIGN KEY (`tabDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `designTabs_tabDesignTextId_fk` FOREIGN KEY (`tabDesignTextId`) REFERENCES `designTexts` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `designTabs`
--

LOCK TABLES `designTabs` WRITE;
/*!40000 ALTER TABLE `designTabs` DISABLE KEYS */;
/*!40000 ALTER TABLE `designTabs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `designTexts`
--

DROP TABLE IF EXISTS `designTexts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `designTexts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `size` smallint(5) unsigned NOT NULL,
  `sizeHover` smallint(5) unsigned NOT NULL,
  `family` tinyint(3) unsigned NOT NULL,
  `color` varchar(25) NOT NULL,
  `colorHover` varchar(25) NOT NULL,
  `isItalic` tinyint(1) unsigned NOT NULL,
  `isItalicHover` tinyint(1) unsigned NOT NULL,
  `isBold` tinyint(1) unsigned NOT NULL,
  `isBoldHover` tinyint(1) unsigned NOT NULL,
  `align` tinyint(3) unsigned NOT NULL,
  `decoration` tinyint(3) unsigned NOT NULL,
  `decorationHover` tinyint(3) unsigned NOT NULL,
  `transform` tinyint(3) unsigned NOT NULL,
  `transformHover` tinyint(3) unsigned NOT NULL,
  `letterSpacing` smallint(6) NOT NULL,
  `letterSpacingHover` smallint(6) NOT NULL,
  `lineHeight` smallint(5) unsigned NOT NULL,
  `lineHeightHover` smallint(6) NOT NULL,
  `hasHover` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `designTexts`
--

LOCK TABLES `designTexts` WRITE;
/*!40000 ALTER TABLE `designTexts` DISABLE KEYS */;
/*!40000 ALTER TABLE `designTexts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `feedback`
--

DROP TABLE IF EXISTS `feedback`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `feedback` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `formId` int(11) unsigned NOT NULL,
  `subjectFormInstanceId` int(11) unsigned NOT NULL,
  `subjectText` varchar(255) NOT NULL,
  `host` varchar(255) NOT NULL,
  `port` smallint(5) unsigned NOT NULL,
  `type` varchar(25) NOT NULL,
  `user` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `feedback_formId_fk` (`formId`),
  KEY `feedback_subjectFormInstanceId_fk` (`subjectFormInstanceId`),
  CONSTRAINT `feedback_formId_fk` FOREIGN KEY (`formId`) REFERENCES `forms` (`id`),
  CONSTRAINT `feedback_subjectFormInstanceId_fk` FOREIGN KEY (`subjectFormInstanceId`) REFERENCES `formInstances` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `feedback`
--

LOCK TABLES `feedback` WRITE;
/*!40000 ALTER TABLE `feedback` DISABLE KEYS */;
/*!40000 ALTER TABLE `feedback` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fieldGroups`
--

DROP TABLE IF EXISTS `fieldGroups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fieldGroups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fieldId` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fieldGroups_fieldId_fk` (`fieldId`),
  CONSTRAINT `fieldGroups_fieldId_fk` FOREIGN KEY (`fieldId`) REFERENCES `fields` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fieldGroups`
--

LOCK TABLES `fieldGroups` WRITE;
/*!40000 ALTER TABLE `fieldGroups` DISABLE KEYS */;
/*!40000 ALTER TABLE `fieldGroups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fieldInstances`
--

DROP TABLE IF EXISTS `fieldInstances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fieldInstances` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fieldGroupId` int(11) unsigned NOT NULL,
  `fieldTemplateId` int(11) unsigned NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fieldInstances_fieldGroupId_fk` (`fieldGroupId`),
  KEY `fieldInstances_fieldTemplateId_fk` (`fieldTemplateId`),
  KEY `fieldInstances_value` (`value`),
  CONSTRAINT `fieldInstances_fieldGroupId_fk` FOREIGN KEY (`fieldGroupId`) REFERENCES `fieldGroups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fieldInstances_fieldTemplateId_fk` FOREIGN KEY (`fieldTemplateId`) REFERENCES `fieldTemplates` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fieldInstances`
--

LOCK TABLES `fieldInstances` WRITE;
/*!40000 ALTER TABLE `fieldInstances` DISABLE KEYS */;
/*!40000 ALTER TABLE `fieldInstances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fieldListValues`
--

DROP TABLE IF EXISTS `fieldListValues`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fieldListValues` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fieldTemplateId` int(11) unsigned NOT NULL,
  `value` varchar(255) NOT NULL,
  `sort` smallint(6) NOT NULL,
  `isChecked` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fieldListValues_fieldTemplateId_fk` (`fieldTemplateId`),
  KEY `fieldListValues_sort` (`sort`),
  CONSTRAINT `fieldListValues_fieldTemplateId_fk` FOREIGN KEY (`fieldTemplateId`) REFERENCES `fieldTemplates` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fieldListValues`
--

LOCK TABLES `fieldListValues` WRITE;
/*!40000 ALTER TABLE `fieldListValues` DISABLE KEYS */;
/*!40000 ALTER TABLE `fieldListValues` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fieldTemplates`
--

DROP TABLE IF EXISTS `fieldTemplates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fieldTemplates` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fieldId` int(11) unsigned NOT NULL,
  `sort` smallint(6) NOT NULL,
  `label` varchar(255) NOT NULL,
  `type` tinyint(3) unsigned NOT NULL,
  `validationType` tinyint(3) unsigned NOT NULL,
  `isHideForShortCard` tinyint(1) unsigned NOT NULL,
  `isShowEmpty` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fieldTemplates_fieldId_fk` (`fieldId`),
  KEY `fieldTemplates_sort` (`sort`),
  CONSTRAINT `fieldTemplates_fieldId_fk` FOREIGN KEY (`fieldId`) REFERENCES `fields` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fieldTemplates`
--

LOCK TABLES `fieldTemplates` WRITE;
/*!40000 ALTER TABLE `fieldTemplates` DISABLE KEYS */;
/*!40000 ALTER TABLE `fieldTemplates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fields`
--

DROP TABLE IF EXISTS `fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fields` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `designFieldId` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fields_designFieldId_fk` (`designFieldId`),
  CONSTRAINT `fields_designFieldId_fk` FOREIGN KEY (`designFieldId`) REFERENCES `designFields` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fields`
--

LOCK TABLES `fields` WRITE;
/*!40000 ALTER TABLE `fields` DISABLE KEYS */;
/*!40000 ALTER TABLE `fields` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `files`
--

DROP TABLE IF EXISTS `files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `files` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `originalName` varchar(255) NOT NULL,
  `type` varchar(50) NOT NULL,
  `size` int(10) unsigned NOT NULL,
  `uniqueName` varchar(25) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `files_uniqueName` (`uniqueName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `files`
--

LOCK TABLES `files` WRITE;
/*!40000 ALTER TABLE `files` DISABLE KEYS */;
/*!40000 ALTER TABLE `files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `formInstances`
--

DROP TABLE IF EXISTS `formInstances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `formInstances` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `formId` int(11) unsigned NOT NULL,
  `sort` smallint(6) NOT NULL,
  `label` varchar(255) NOT NULL,
  `isRequired` tinyint(1) unsigned NOT NULL,
  `validationType` tinyint(3) unsigned NOT NULL,
  `type` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `formInstances_formId_fk` (`formId`),
  KEY `formInstances_sort` (`sort`),
  CONSTRAINT `formInstances_formId_fk` FOREIGN KEY (`formId`) REFERENCES `forms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `formInstances`
--

LOCK TABLES `formInstances` WRITE;
/*!40000 ALTER TABLE `formInstances` DISABLE KEYS */;
/*!40000 ALTER TABLE `formInstances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `formListValues`
--

DROP TABLE IF EXISTS `formListValues`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `formListValues` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `formInstanceId` int(11) unsigned NOT NULL,
  `sort` smallint(6) NOT NULL,
  `value` varchar(255) NOT NULL,
  `isChecked` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `formListValues_formInstanceId_fk` (`formInstanceId`),
  KEY `formListValues_sort` (`sort`),
  CONSTRAINT `formListValues_formInstanceId_fk` FOREIGN KEY (`formInstanceId`) REFERENCES `formInstances` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `formListValues`
--

LOCK TABLES `formListValues` WRITE;
/*!40000 ALTER TABLE `formListValues` DISABLE KEYS */;
/*!40000 ALTER TABLE `formListValues` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `forms`
--

DROP TABLE IF EXISTS `forms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `forms` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `designFormId` int(11) unsigned NOT NULL,
  `hasLabel` tinyint(1) unsigned NOT NULL,
  `successText` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `forms_designFormId_fk` (`designFormId`),
  CONSTRAINT `forms_designFormId_fk` FOREIGN KEY (`designFormId`) REFERENCES `designForms` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `forms`
--

LOCK TABLES `forms` WRITE;
/*!40000 ALTER TABLE `forms` DISABLE KEYS */;
/*!40000 ALTER TABLE `forms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gridLines`
--

DROP TABLE IF EXISTS `gridLines`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gridLines` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sectionId` int(11) unsigned NOT NULL,
  `outsideDesignId` int(11) unsigned NOT NULL,
  `insideDesignId` int(11) unsigned NOT NULL,
  `sort` smallint(6) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `gridLines_sectionId_fk` (`sectionId`),
  KEY `gridLines_outsideDesignId_fk` (`outsideDesignId`),
  KEY `gridLines_insideDesignId_fk` (`insideDesignId`),
  KEY `gridLines_sort` (`sort`),
  CONSTRAINT `gridLines_insideDesignId_fk` FOREIGN KEY (`insideDesignId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `gridLines_outsideDesignId_fk` FOREIGN KEY (`outsideDesignId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `gridLines_sectionId_fk` FOREIGN KEY (`sectionId`) REFERENCES `sections` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gridLines`
--

LOCK TABLES `gridLines` WRITE;
/*!40000 ALTER TABLE `gridLines` DISABLE KEYS */;
/*!40000 ALTER TABLE `gridLines` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grids`
--

DROP TABLE IF EXISTS `grids`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grids` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `gridLineId` int(11) unsigned NOT NULL,
  `blockId` int(11) unsigned NOT NULL,
  `x` tinyint(3) unsigned NOT NULL,
  `y` tinyint(3) unsigned NOT NULL,
  `width` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `grids_gridLineId_fk` (`gridLineId`),
  KEY `grids_blockId_fk` (`blockId`),
  CONSTRAINT `grids_blockId_fk` FOREIGN KEY (`blockId`) REFERENCES `blocks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `grids_gridLineId_fk` FOREIGN KEY (`gridLineId`) REFERENCES `gridLines` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grids`
--

LOCK TABLES `grids` WRITE;
/*!40000 ALTER TABLE `grids` DISABLE KEYS */;
/*!40000 ALTER TABLE `grids` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `imageGroups`
--

DROP TABLE IF EXISTS `imageGroups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `imageGroups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `imageId` int(11) unsigned NOT NULL,
  `seoId` int(11) unsigned NOT NULL,
  `containerDesignBlockId` int(11) unsigned NOT NULL,
  `coverDesignBlockId` int(11) unsigned NOT NULL,
  `nameDesignBlockId` int(11) unsigned NOT NULL,
  `nameDesignTextId` int(11) unsigned NOT NULL,
  `sort` smallint(6) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `imageGroups_imageId_fk` (`imageId`),
  KEY `imageGroups_seoId_fk` (`seoId`),
  KEY `imageGroups_containerDesignBlockId_fk` (`containerDesignBlockId`),
  KEY `imageGroups_coverDesignBlockId_fk` (`coverDesignBlockId`),
  KEY `imageGroups_nameDesignBlockId_fk` (`nameDesignBlockId`),
  KEY `imageGroups_nameDesignTextId_fk` (`nameDesignTextId`),
  KEY `imageGroups_sort` (`sort`),
  CONSTRAINT `imageGroups_containerDesignBlockId_fk` FOREIGN KEY (`containerDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `imageGroups_coverDesignBlockId_fk` FOREIGN KEY (`coverDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `imageGroups_imageId_fk` FOREIGN KEY (`imageId`) REFERENCES `images` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `imageGroups_nameDesignBlockId_fk` FOREIGN KEY (`nameDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `imageGroups_nameDesignTextId_fk` FOREIGN KEY (`nameDesignTextId`) REFERENCES `designTexts` (`id`),
  CONSTRAINT `imageGroups_seoId_fk` FOREIGN KEY (`seoId`) REFERENCES `seo` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `imageGroups`
--

LOCK TABLES `imageGroups` WRITE;
/*!40000 ALTER TABLE `imageGroups` DISABLE KEYS */;
/*!40000 ALTER TABLE `imageGroups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `imageInstances`
--

DROP TABLE IF EXISTS `imageInstances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `imageInstances` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `imageGroupId` int(11) unsigned DEFAULT NULL,
  `originalFileId` int(11) unsigned NOT NULL,
  `viewFileId` int(11) unsigned NOT NULL,
  `thumbFileId` int(11) unsigned NOT NULL,
  `isCover` tinyint(1) unsigned NOT NULL,
  `sort` smallint(6) NOT NULL,
  `alt` text NOT NULL,
  `link` text NOT NULL,
  `width` smallint(5) unsigned NOT NULL,
  `height` smallint(5) unsigned NOT NULL,
  `x1` smallint(5) unsigned NOT NULL,
  `y1` smallint(5) unsigned NOT NULL,
  `x2` smallint(5) unsigned NOT NULL,
  `y2` smallint(5) unsigned NOT NULL,
  `angle` smallint(6) NOT NULL,
  `flip` tinyint(3) unsigned NOT NULL,
  `thumbX1` smallint(5) unsigned NOT NULL,
  `thumbY1` smallint(5) unsigned NOT NULL,
  `thumbX2` smallint(5) unsigned NOT NULL,
  `thumbY2` smallint(5) unsigned NOT NULL,
  `thumbAngle` smallint(6) NOT NULL,
  `thumbFlip` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `imageInstances_imageGroupId_fk` (`imageGroupId`),
  KEY `imageInstances_originalFileId_fk` (`originalFileId`),
  KEY `imageInstances_viewFileId_fk` (`viewFileId`),
  KEY `imageInstances_thumbFileId_fk` (`thumbFileId`),
  KEY `imageInstances_isCover` (`isCover`),
  KEY `imageInstances_sort` (`sort`),
  CONSTRAINT `imageInstances_imageGroupId_fk` FOREIGN KEY (`imageGroupId`) REFERENCES `imageGroups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `imageInstances_originalFileId_fk` FOREIGN KEY (`originalFileId`) REFERENCES `files` (`id`),
  CONSTRAINT `imageInstances_thumbFileId_fk` FOREIGN KEY (`thumbFileId`) REFERENCES `files` (`id`),
  CONSTRAINT `imageInstances_viewFileId_fk` FOREIGN KEY (`viewFileId`) REFERENCES `files` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `imageInstances`
--

LOCK TABLES `imageInstances` WRITE;
/*!40000 ALTER TABLE `imageInstances` DISABLE KEYS */;
/*!40000 ALTER TABLE `imageInstances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `images`
--

DROP TABLE IF EXISTS `images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `images` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `designBlockId` int(11) unsigned NOT NULL,
  `designImageAlbumId` int(11) unsigned NOT NULL,
  `designImageSliderId` int(11) unsigned NOT NULL,
  `designImageZoomId` int(11) unsigned NOT NULL,
  `designImageSimpleId` int(11) unsigned NOT NULL,
  `type` tinyint(3) unsigned NOT NULL,
  `autoCropType` tinyint(3) unsigned NOT NULL,
  `cropX` int(10) unsigned NOT NULL,
  `cropY` int(10) unsigned NOT NULL,
  `thumbAutoCropType` tinyint(3) unsigned NOT NULL,
  `thumbCropX` smallint(5) unsigned NOT NULL,
  `thumbCropY` smallint(5) unsigned NOT NULL,
  `useAlbums` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `images_designBlockId_fk` (`designBlockId`),
  KEY `images_designImageAlbumId_fk` (`designImageAlbumId`),
  KEY `images_designImageSliderId_fk` (`designImageSliderId`),
  KEY `images_designImageZoomId_fk` (`designImageZoomId`),
  KEY `images_designImageSimpleId_fk` (`designImageSimpleId`),
  CONSTRAINT `images_designBlockId_fk` FOREIGN KEY (`designBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `images_designImageAlbumId_fk` FOREIGN KEY (`designImageAlbumId`) REFERENCES `designImageAlbums` (`id`),
  CONSTRAINT `images_designImageSimpleId_fk` FOREIGN KEY (`designImageSimpleId`) REFERENCES `designImageSimple` (`id`),
  CONSTRAINT `images_designImageSliderId_fk` FOREIGN KEY (`designImageSliderId`) REFERENCES `designImageSliders` (`id`),
  CONSTRAINT `images_designImageZoomId_fk` FOREIGN KEY (`designImageZoomId`) REFERENCES `designImageZooms` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `images`
--

LOCK TABLES `images` WRITE;
/*!40000 ALTER TABLE `images` DISABLE KEYS */;
/*!40000 ALTER TABLE `images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu`
--

DROP TABLE IF EXISTS `menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `designMenuId` int(11) unsigned NOT NULL,
  `type` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_designMenuId_fk` (`designMenuId`),
  CONSTRAINT `menu_designMenuId_fk` FOREIGN KEY (`designMenuId`) REFERENCES `designMenu` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu`
--

LOCK TABLES `menu` WRITE;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menuInstances`
--

DROP TABLE IF EXISTS `menuInstances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menuInstances` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `menuId` int(11) unsigned NOT NULL,
  `parentId` int(11) unsigned DEFAULT NULL,
  `sectionId` int(11) unsigned DEFAULT NULL,
  `icon` varchar(50) NOT NULL,
  `sort` smallint(6) NOT NULL,
  `staticName` varchar(255) NOT NULL,
  `staticUrl` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `menuInstances_menuId_fk` (`menuId`),
  KEY `menuInstances_parentId_fk` (`parentId`),
  KEY `menuInstances_sectionId_fk` (`sectionId`),
  CONSTRAINT `menuInstances_menuId_fk` FOREIGN KEY (`menuId`) REFERENCES `menu` (`id`),
  CONSTRAINT `menuInstances_parentId_fk` FOREIGN KEY (`parentId`) REFERENCES `menuInstances` (`id`),
  CONSTRAINT `menuInstances_sectionId_fk` FOREIGN KEY (`sectionId`) REFERENCES `sections` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menuInstances`
--

LOCK TABLES `menuInstances` WRITE;
/*!40000 ALTER TABLE `menuInstances` DISABLE KEYS */;
/*!40000 ALTER TABLE `menuInstances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(100) NOT NULL,
  `up` text NOT NULL,
  `down` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'M160302000005Blocks','CREATE TABLE blocks (`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, `name` VARCHAR(255) NOT NULL, `language` TINYINT(3) UNSIGNED NOT NULL, `contentType` TINYINT(3) UNSIGNED NOT NULL, `contentId` INT(11) UNSIGNED NOT NULL) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci; ALTER TABLE blocks ADD INDEX blocks_language_contentType (language,contentType); ALTER TABLE blocks ADD UNIQUE INDEX blocks_language_contentType_contentId (language,contentType,contentId);',''),(2,'M160302000010DesignBlocks','CREATE TABLE designBlocks (`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, `marginTop` SMALLINT NOT NULL, `marginTopHover` SMALLINT NOT NULL, `marginRight` SMALLINT NOT NULL, `marginRightHover` SMALLINT NOT NULL, `marginBottom` SMALLINT NOT NULL, `marginBottomHover` SMALLINT NOT NULL, `marginLeft` SMALLINT NOT NULL, `marginLeftHover` SMALLINT NOT NULL, `hasMarginHover` TINYINT(1) UNSIGNED NOT NULL, `hasMarginAnimation` TINYINT(1) UNSIGNED NOT NULL, `paddingTop` SMALLINT UNSIGNED NOT NULL, `paddingTopHover` SMALLINT UNSIGNED NOT NULL, `paddingRight` SMALLINT UNSIGNED NOT NULL, `paddingRightHover` SMALLINT UNSIGNED NOT NULL, `paddingBottom` SMALLINT UNSIGNED NOT NULL, `paddingBottomHover` SMALLINT UNSIGNED NOT NULL, `paddingLeft` SMALLINT UNSIGNED NOT NULL, `paddingLeftHover` SMALLINT UNSIGNED NOT NULL, `hasPaddingHover` TINYINT(1) UNSIGNED NOT NULL, `hasPaddingAnimation` TINYINT(1) UNSIGNED NOT NULL, `backgroundColorFrom` VARCHAR(25) NOT NULL, `backgroundColorFromHover` VARCHAR(25) NOT NULL, `backgroundColorTo` VARCHAR(25) NOT NULL, `backgroundColorToHover` VARCHAR(25) NOT NULL, `gradientDirection` TINYINT(3) UNSIGNED NOT NULL, `gradientDirectionHover` TINYINT(3) UNSIGNED NOT NULL, `hasBackgroundGradient` TINYINT(1) UNSIGNED NOT NULL, `hasBackgroundHover` TINYINT(1) UNSIGNED NOT NULL, `hasBackgroundAnimation` TINYINT(1) UNSIGNED NOT NULL, `imageInstanceId` INT(11) UNSIGNED NULL, `backgroundPosition` TINYINT(3) UNSIGNED NOT NULL, `backgroundRepeat` TINYINT(3) UNSIGNED NOT NULL, `isBackgroundCover` TINYINT(1) UNSIGNED NOT NULL, `borderTopLeftRadius` SMALLINT UNSIGNED NOT NULL, `borderTopLeftRadiusHover` SMALLINT UNSIGNED NOT NULL, `borderTopRightRadius` SMALLINT UNSIGNED NOT NULL, `borderTopRightRadiusHover` SMALLINT UNSIGNED NOT NULL, `borderBottomRightRadius` SMALLINT UNSIGNED NOT NULL, `borderBottomRightRadiusHover` SMALLINT UNSIGNED NOT NULL, `borderBottomLeftRadius` SMALLINT UNSIGNED NOT NULL, `borderBottomLeftRadiusHover` SMALLINT UNSIGNED NOT NULL, `borderTopWidth` SMALLINT UNSIGNED NOT NULL, `borderTopWidthHover` SMALLINT UNSIGNED NOT NULL, `borderRightWidth` SMALLINT UNSIGNED NOT NULL, `borderRightWidthHover` SMALLINT UNSIGNED NOT NULL, `borderBottomWidth` SMALLINT UNSIGNED NOT NULL, `borderBottomWidthHover` SMALLINT UNSIGNED NOT NULL, `borderLeftWidth` SMALLINT UNSIGNED NOT NULL, `borderLeftWidthHover` SMALLINT UNSIGNED NOT NULL, `borderStyle` TINYINT(3) UNSIGNED NOT NULL, `borderStyleHover` TINYINT(3) UNSIGNED NOT NULL, `borderColor` VARCHAR(25) NOT NULL, `borderColorHover` VARCHAR(25) NOT NULL, `hasBorderHover` TINYINT(1) UNSIGNED NOT NULL, `hasBorderAnimation` TINYINT(1) UNSIGNED NOT NULL, `width` SMALLINT UNSIGNED NOT NULL, `height` SMALLINT UNSIGNED NOT NULL) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;',''),(3,'M160302000020DesignTexts','CREATE TABLE designTexts (`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, `size` SMALLINT UNSIGNED NOT NULL, `sizeHover` SMALLINT UNSIGNED NOT NULL, `family` TINYINT(3) UNSIGNED NOT NULL, `color` VARCHAR(25) NOT NULL, `colorHover` VARCHAR(25) NOT NULL, `isItalic` TINYINT(1) UNSIGNED NOT NULL, `isItalicHover` TINYINT(1) UNSIGNED NOT NULL, `isBold` TINYINT(1) UNSIGNED NOT NULL, `isBoldHover` TINYINT(1) UNSIGNED NOT NULL, `align` TINYINT(3) UNSIGNED NOT NULL, `decoration` TINYINT(3) UNSIGNED NOT NULL, `decorationHover` TINYINT(3) UNSIGNED NOT NULL, `transform` TINYINT(3) UNSIGNED NOT NULL, `transformHover` TINYINT(3) UNSIGNED NOT NULL, `letterSpacing` SMALLINT NOT NULL, `letterSpacingHover` SMALLINT NOT NULL, `lineHeight` SMALLINT UNSIGNED NOT NULL, `lineHeightHover` SMALLINT NOT NULL, `hasHover` TINYINT(1) UNSIGNED NOT NULL) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;',''),(4,'M160303000000Seo','CREATE TABLE seo (`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, `name` VARCHAR(255) NOT NULL, `alias` VARCHAR(255) NOT NULL, `title` VARCHAR(100) NOT NULL, `keywords` VARCHAR(255) NOT NULL, `description` VARCHAR(255) NOT NULL) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci; ALTER TABLE seo ADD INDEX seo_name (name); ALTER TABLE seo ADD INDEX seo_alias (alias);',''),(5,'M160305000000Sections','CREATE TABLE sections (`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, `seoId` INT(11) UNSIGNED NOT NULL, `designBlockId` INT(11) UNSIGNED NOT NULL, `language` TINYINT(3) UNSIGNED NOT NULL, `padding` INT UNSIGNED NOT NULL, `isMain` TINYINT(1) UNSIGNED NOT NULL, `isPublished` TINYINT(1) UNSIGNED NOT NULL) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci; ALTER TABLE sections ADD CONSTRAINT sections_seoId_fk FOREIGN KEY (seoId) REFERENCES seo(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE sections ADD CONSTRAINT sections_designBlockId_fk FOREIGN KEY (designBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE sections ADD INDEX sections_language_isMain_isPublished (language,isMain,isPublished); ALTER TABLE sections ADD INDEX sections_language_isPublished (language,isPublished); ALTER TABLE sections ADD INDEX sections_language (language);',''),(6,'M160307000000Users','CREATE TABLE users (`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, `login` VARCHAR(50) NOT NULL, `type` TINYINT(3) UNSIGNED NOT NULL, `password` CHAR(40) NOT NULL, `name` VARCHAR(100) NOT NULL, `email` VARCHAR(100) NOT NULL, `code` VARCHAR(25) NOT NULL) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci; ALTER TABLE users ADD UNIQUE INDEX users_login (login); ALTER TABLE users ADD UNIQUE INDEX users_email (email); CREATE TABLE userSessions (`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, `userId` INT(11) UNSIGNED NOT NULL, `token` CHAR(32) NOT NULL, `ip` VARCHAR(25) NOT NULL, `ua` VARCHAR(255) NOT NULL, `lastActivity` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci; ALTER TABLE userSessions ADD CONSTRAINT userSessions_userId_fk FOREIGN KEY (userId) REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE; ALTER TABLE userSessions ADD UNIQUE INDEX userSessions_token (token); CREATE TABLE userBlockOperations (`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, `userId` INT(11) UNSIGNED NOT NULL, `blockId` INT(11) UNSIGNED NOT NULL, `blockType` TINYINT(3) UNSIGNED NOT NULL, `operation` VARCHAR(50) NOT NULL) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci; ALTER TABLE userBlockOperations ADD CONSTRAINT userBlockOperations_userId_fk FOREIGN KEY (userId) REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE; ALTER TABLE userBlockOperations ADD CONSTRAINT userBlockOperations_blockId_fk FOREIGN KEY (blockId) REFERENCES blocks(id) ON UPDATE CASCADE ON DELETE CASCADE; CREATE TABLE userBlockGroupOperations (`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, `userId` INT(11) UNSIGNED NOT NULL, `blockType` TINYINT(3) UNSIGNED NOT NULL, `operation` VARCHAR(50) NOT NULL) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci; ALTER TABLE userBlockGroupOperations ADD CONSTRAINT userBlockGroupOperations_userId_fk FOREIGN KEY (userId) REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE; CREATE TABLE userSectionOperations (`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, `userId` INT(11) UNSIGNED NOT NULL, `sectionId` INT(11) UNSIGNED NOT NULL, `operation` VARCHAR(50) NOT NULL) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci; ALTER TABLE userSectionOperations ADD CONSTRAINT userSectionOperations_userId_fk FOREIGN KEY (userId) REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE; ALTER TABLE userSectionOperations ADD CONSTRAINT userSectionOperations_sectionId_fk FOREIGN KEY (sectionId) REFERENCES sections(id) ON UPDATE CASCADE ON DELETE CASCADE; CREATE TABLE userSectionGroupOperations (`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, `userId` INT(11) UNSIGNED NOT NULL, `operation` VARCHAR(50) NOT NULL) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci; ALTER TABLE userSectionGroupOperations ADD CONSTRAINT userSectionGroupOperations_userId_fk FOREIGN KEY (userId) REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE; CREATE TABLE userSettingsOperations (`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, `userId` INT(11) UNSIGNED NOT NULL, `operation` VARCHAR(50) NOT NULL) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci; ALTER TABLE userSettingsOperations ADD CONSTRAINT userSettingsOperations_userId_fk FOREIGN KEY (userId) REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE; CREATE TABLE userEvents (`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, `userId` INT(11) UNSIGNED NOT NULL, `category` TINYINT(3) UNSIGNED NOT NULL, `type` TINYINT(3) UNSIGNED NOT NULL, `event` VARCHAR(255) NOT NULL, `date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci; ALTER TABLE userEvents ADD CONSTRAINT userEvents_userId_fk FOREIGN KEY (userId) REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE; ALTER TABLE userEvents ADD INDEX userEvents_date (date);',''),(7,'M160308000000Files','CREATE TABLE files (`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, `originalName` VARCHAR(255) NOT NULL, `type` VARCHAR(50) NOT NULL, `size` INT UNSIGNED NOT NULL, `uniqueName` VARCHAR(25) NOT NULL) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci; ALTER TABLE files ADD UNIQUE INDEX files_uniqueName (uniqueName); CREATE TABLE removedFiles (`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, `uniqueName` VARCHAR(255) NOT NULL) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;',''),(8,'M160309000000Texts','CREATE TABLE texts (`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, `designTextId` INT(11) UNSIGNED NOT NULL, `designBlockId` INT(11) UNSIGNED NOT NULL, `type` TINYINT(3) UNSIGNED NOT NULL, `hasEditor` TINYINT(1) UNSIGNED NOT NULL) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci; ALTER TABLE texts ADD CONSTRAINT texts_designTextId_fk FOREIGN KEY (designTextId) REFERENCES designTexts(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE texts ADD CONSTRAINT texts_designBlockId_fk FOREIGN KEY (designBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; CREATE TABLE textInstances (`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, `textId` INT(11) UNSIGNED NOT NULL, `text` TEXT NOT NULL) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci; ALTER TABLE textInstances ADD CONSTRAINT textInstances_textId_fk FOREIGN KEY (textId) REFERENCES texts(id) ON UPDATE CASCADE ON DELETE CASCADE; ALTER TABLE textInstances ADD FULLTEXT(text); CREATE TABLE textInstanceFileMap (`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, `textInstanceId` INT(11) UNSIGNED NOT NULL, `fileId` INT(11) UNSIGNED NOT NULL) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci; ALTER TABLE textInstanceFileMap ADD CONSTRAINT textInstanceFileMap_textInstanceId_fk FOREIGN KEY (textInstanceId) REFERENCES textInstances(id) ON UPDATE CASCADE ON DELETE CASCADE; ALTER TABLE textInstanceFileMap ADD CONSTRAINT textInstanceFileMap_fileId_fk FOREIGN KEY (fileId) REFERENCES files(id) ON UPDATE CASCADE ON DELETE CASCADE;',''),(9,'M160311000000Grids','CREATE TABLE gridLines (`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, `sectionId` INT(11) UNSIGNED NOT NULL, `outsideDesignId` INT(11) UNSIGNED NOT NULL, `insideDesignId` INT(11) UNSIGNED NOT NULL, `sort` SMALLINT NOT NULL) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci; ALTER TABLE gridLines ADD CONSTRAINT gridLines_sectionId_fk FOREIGN KEY (sectionId) REFERENCES sections(id) ON UPDATE CASCADE ON DELETE CASCADE; ALTER TABLE gridLines ADD CONSTRAINT gridLines_outsideDesignId_fk FOREIGN KEY (outsideDesignId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE gridLines ADD CONSTRAINT gridLines_insideDesignId_fk FOREIGN KEY (insideDesignId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE gridLines ADD INDEX gridLines_sort (sort); CREATE TABLE grids (`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, `gridLineId` INT(11) UNSIGNED NOT NULL, `blockId` INT(11) UNSIGNED NOT NULL, `x` TINYINT(3) UNSIGNED NOT NULL, `y` TINYINT(3) UNSIGNED NOT NULL, `width` TINYINT(3) UNSIGNED NOT NULL) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci; ALTER TABLE grids ADD CONSTRAINT grids_gridLineId_fk FOREIGN KEY (gridLineId) REFERENCES gridLines(id) ON UPDATE CASCADE ON DELETE CASCADE; ALTER TABLE grids ADD CONSTRAINT grids_blockId_fk FOREIGN KEY (blockId) REFERENCES blocks(id) ON UPDATE CASCADE ON DELETE CASCADE;',''),(10,'M160317000000Images','CREATE TABLE designImageAlbums (`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, `containerDesignBlockId` INT(11) UNSIGNED NOT NULL, `imageDesignBlockId` INT(11) UNSIGNED NOT NULL, `nameDesignBlockId` INT(11) UNSIGNED NOT NULL, `nameDesignTextId` INT(11) UNSIGNED NOT NULL) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci; ALTER TABLE designImageAlbums ADD CONSTRAINT designImageAlbums_containerDesignBlockId_fk FOREIGN KEY (containerDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designImageAlbums ADD CONSTRAINT designImageAlbums_imageDesignBlockId_fk FOREIGN KEY (imageDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designImageAlbums ADD CONSTRAINT designImageAlbums_nameDesignBlockId_fk FOREIGN KEY (nameDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designImageAlbums ADD CONSTRAINT designImageAlbums_nameDesignTextId_fk FOREIGN KEY (nameDesignTextId) REFERENCES designTexts(id) ON UPDATE RESTRICT ON DELETE RESTRICT; CREATE TABLE designImageSimple (`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, `containerDesignBlockId` INT(11) UNSIGNED NOT NULL, `imageDesignBlockId` INT(11) UNSIGNED NOT NULL, `descriptionDesignBlockId` INT(11) UNSIGNED NOT NULL, `descriptionDesignTextId` INT(11) UNSIGNED NOT NULL, `useDescription` TINYINT(1) UNSIGNED NOT NULL, `alignment` TINYINT(3) UNSIGNED NOT NULL) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci; ALTER TABLE designImageSimple ADD CONSTRAINT designImageSimple_containerDesignBlockId_fk FOREIGN KEY (containerDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designImageSimple ADD CONSTRAINT designImageSimple_imageDesignBlockId_fk FOREIGN KEY (imageDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designImageSimple ADD CONSTRAINT designImageSimple_descriptionDesignBlockId_fk FOREIGN KEY (descriptionDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designImageSimple ADD CONSTRAINT designImageSimple_descriptionDesignTextId_fk FOREIGN KEY (descriptionDesignTextId) REFERENCES designTexts(id) ON UPDATE RESTRICT ON DELETE RESTRICT; CREATE TABLE designImageZooms (`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, `designBlockId` INT(11) UNSIGNED NOT NULL, `effect` TINYINT(3) UNSIGNED NOT NULL) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci; ALTER TABLE designImageZooms ADD CONSTRAINT designImageZooms_designBlockId_fk FOREIGN KEY (designBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; CREATE TABLE designImageSliders (`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, `arrowDesignTextId` INT(11) UNSIGNED NOT NULL, `bulletDesignBlockId` INT(11) UNSIGNED NOT NULL, `bulletActiveDesignBlockId` INT(11) UNSIGNED NOT NULL, `descriptionDesignBlockId` INT(11) UNSIGNED NOT NULL, `descriptionDesignTextId` INT(11) UNSIGNED NOT NULL, `isFullWidth` TINYINT(1) UNSIGNED NOT NULL, `hasDescription` TINYINT(1) UNSIGNED NOT NULL, `effect` TEXT NOT NULL, `hasAutoPlay` TINYINT(1) UNSIGNED NOT NULL, `playSpeed` TINYINT(3) UNSIGNED NOT NULL) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci; ALTER TABLE designImageSliders ADD CONSTRAINT designImageSliders_arrowDesignTextId_fk FOREIGN KEY (arrowDesignTextId) REFERENCES designTexts(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designImageSliders ADD CONSTRAINT designImageSliders_bulletDesignBlockId_fk FOREIGN KEY (bulletDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designImageSliders ADD CONSTRAINT designImageSliders_bulletActiveDesignBlockId_fk FOREIGN KEY (bulletActiveDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designImageSliders ADD CONSTRAINT designImageSliders_descriptionDesignBlockId_fk FOREIGN KEY (descriptionDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designImageSliders ADD CONSTRAINT designImageSliders_descriptionDesignTextId_fk FOREIGN KEY (descriptionDesignTextId) REFERENCES designTexts(id) ON UPDATE RESTRICT ON DELETE RESTRICT; CREATE TABLE images (`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, `designBlockId` INT(11) UNSIGNED NOT NULL, `designImageAlbumId` INT(11) UNSIGNED NOT NULL, `designImageSliderId` INT(11) UNSIGNED NOT NULL, `designImageZoomId` INT(11) UNSIGNED NOT NULL, `designImageSimpleId` INT(11) UNSIGNED NOT NULL, `type` TINYINT(3) UNSIGNED NOT NULL, `autoCropType` TINYINT(3) UNSIGNED NOT NULL, `cropX` INT UNSIGNED NOT NULL, `cropY` INT UNSIGNED NOT NULL, `thumbAutoCropType` TINYINT(3) UNSIGNED NOT NULL, `thumbCropX` SMALLINT UNSIGNED NOT NULL, `thumbCropY` SMALLINT UNSIGNED NOT NULL, `useAlbums` TINYINT(1) UNSIGNED NOT NULL) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci; ALTER TABLE images ADD CONSTRAINT images_designBlockId_fk FOREIGN KEY (designBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE images ADD CONSTRAINT images_designImageAlbumId_fk FOREIGN KEY (designImageAlbumId) REFERENCES designImageAlbums(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE images ADD CONSTRAINT images_designImageSliderId_fk FOREIGN KEY (designImageSliderId) REFERENCES designImageSliders(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE images ADD CONSTRAINT images_designImageZoomId_fk FOREIGN KEY (designImageZoomId) REFERENCES designImageZooms(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE images ADD CONSTRAINT images_designImageSimpleId_fk FOREIGN KEY (designImageSimpleId) REFERENCES designImageSimple(id) ON UPDATE RESTRICT ON DELETE RESTRICT; CREATE TABLE imageGroups (`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, `imageId` INT(11) UNSIGNED NOT NULL, `seoId` INT(11) UNSIGNED NOT NULL, `containerDesignBlockId` INT(11) UNSIGNED NOT NULL, `coverDesignBlockId` INT(11) UNSIGNED NOT NULL, `nameDesignBlockId` INT(11) UNSIGNED NOT NULL, `nameDesignTextId` INT(11) UNSIGNED NOT NULL, `sort` SMALLINT NOT NULL) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci; ALTER TABLE imageGroups ADD CONSTRAINT imageGroups_imageId_fk FOREIGN KEY (imageId) REFERENCES images(id) ON UPDATE CASCADE ON DELETE CASCADE; ALTER TABLE imageGroups ADD CONSTRAINT imageGroups_seoId_fk FOREIGN KEY (seoId) REFERENCES seo(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE imageGroups ADD CONSTRAINT imageGroups_containerDesignBlockId_fk FOREIGN KEY (containerDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE imageGroups ADD CONSTRAINT imageGroups_coverDesignBlockId_fk FOREIGN KEY (coverDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE imageGroups ADD CONSTRAINT imageGroups_nameDesignBlockId_fk FOREIGN KEY (nameDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE imageGroups ADD CONSTRAINT imageGroups_nameDesignTextId_fk FOREIGN KEY (nameDesignTextId) REFERENCES designTexts(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE imageGroups ADD INDEX imageGroups_sort (sort); CREATE TABLE imageInstances (`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, `imageGroupId` INT(11) UNSIGNED NULL, `originalFileId` INT(11) UNSIGNED NOT NULL, `viewFileId` INT(11) UNSIGNED NOT NULL, `thumbFileId` INT(11) UNSIGNED NOT NULL, `isCover` TINYINT(1) UNSIGNED NOT NULL, `sort` SMALLINT NOT NULL, `alt` TEXT NOT NULL, `link` TEXT NOT NULL, `width` SMALLINT UNSIGNED NOT NULL, `height` SMALLINT UNSIGNED NOT NULL, `x1` SMALLINT UNSIGNED NOT NULL, `y1` SMALLINT UNSIGNED NOT NULL, `x2` SMALLINT UNSIGNED NOT NULL, `y2` SMALLINT UNSIGNED NOT NULL, `angle` SMALLINT NOT NULL, `flip` TINYINT(3) UNSIGNED NOT NULL, `thumbX1` SMALLINT UNSIGNED NOT NULL, `thumbY1` SMALLINT UNSIGNED NOT NULL, `thumbX2` SMALLINT UNSIGNED NOT NULL, `thumbY2` SMALLINT UNSIGNED NOT NULL, `thumbAngle` SMALLINT NOT NULL, `thumbFlip` TINYINT(3) UNSIGNED NOT NULL) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci; ALTER TABLE imageInstances ADD CONSTRAINT imageInstances_imageGroupId_fk FOREIGN KEY (imageGroupId) REFERENCES imageGroups(id) ON UPDATE CASCADE ON DELETE CASCADE; ALTER TABLE imageInstances ADD CONSTRAINT imageInstances_originalFileId_fk FOREIGN KEY (originalFileId) REFERENCES files(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE imageInstances ADD CONSTRAINT imageInstances_viewFileId_fk FOREIGN KEY (viewFileId) REFERENCES files(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE imageInstances ADD CONSTRAINT imageInstances_thumbFileId_fk FOREIGN KEY (thumbFileId) REFERENCES files(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE imageInstances ADD INDEX imageInstances_isCover (isCover); ALTER TABLE imageInstances ADD INDEX imageInstances_sort (sort); ALTER TABLE designBlocks ADD CONSTRAINT designBlocks_imageInstanceId_fk FOREIGN KEY (imageInstanceId) REFERENCES imageInstances(id) ON UPDATE SET NULL ON DELETE SET NULL;',''),(11,'M160317001000Forms','CREATE TABLE designForms (`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, `containerDesignBlockId` INT(11) UNSIGNED NOT NULL, `lineDesignBlockId` INT(11) UNSIGNED NOT NULL, `labelDesignBlockId` INT(11) UNSIGNED NOT NULL, `labelDesignTextId` INT(11) UNSIGNED NOT NULL, `formDesignBlockId` INT(11) UNSIGNED NOT NULL, `formDesignTextId` INT(11) UNSIGNED NOT NULL, `submitDesignBlockId` INT(11) UNSIGNED NOT NULL, `submitDesignTextId` INT(11) UNSIGNED NOT NULL, `submitIconDesignTextId` INT(11) UNSIGNED NOT NULL, `submitIcon` VARCHAR(50) NOT NULL, `submitIconPosition` TINYINT(3) UNSIGNED NOT NULL, `submitAlignment` TINYINT(3) UNSIGNED NOT NULL) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci; ALTER TABLE designForms ADD CONSTRAINT designForms_containerDesignBlockId_fk FOREIGN KEY (containerDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designForms ADD CONSTRAINT designForms_lineDesignBlockId_fk FOREIGN KEY (lineDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designForms ADD CONSTRAINT designForms_labelDesignBlockId_fk FOREIGN KEY (labelDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designForms ADD CONSTRAINT designForms_labelDesignTextId_fk FOREIGN KEY (labelDesignTextId) REFERENCES designTexts(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designForms ADD CONSTRAINT designForms_formDesignBlockId_fk FOREIGN KEY (formDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designForms ADD CONSTRAINT designForms_formDesignTextId_fk FOREIGN KEY (formDesignTextId) REFERENCES designTexts(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designForms ADD CONSTRAINT designForms_submitDesignBlockId_fk FOREIGN KEY (submitDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designForms ADD CONSTRAINT designForms_submitDesignTextId_fk FOREIGN KEY (submitDesignTextId) REFERENCES designTexts(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designForms ADD CONSTRAINT designForms_submitIconDesignTextId_fk FOREIGN KEY (submitIconDesignTextId) REFERENCES designTexts(id) ON UPDATE RESTRICT ON DELETE RESTRICT; CREATE TABLE forms (`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, `designFormId` INT(11) UNSIGNED NOT NULL, `hasLabel` TINYINT(1) UNSIGNED NOT NULL, `successText` VARCHAR(255) NOT NULL) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci; ALTER TABLE forms ADD CONSTRAINT forms_designFormId_fk FOREIGN KEY (designFormId) REFERENCES designForms(id) ON UPDATE RESTRICT ON DELETE RESTRICT; CREATE TABLE formInstances (`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, `formId` INT(11) UNSIGNED NOT NULL, `sort` SMALLINT NOT NULL, `label` VARCHAR(255) NOT NULL, `isRequired` TINYINT(1) UNSIGNED NOT NULL, `validationType` TINYINT(3) UNSIGNED NOT NULL, `type` TINYINT(3) UNSIGNED NOT NULL) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci; ALTER TABLE formInstances ADD CONSTRAINT formInstances_formId_fk FOREIGN KEY (formId) REFERENCES forms(id) ON UPDATE CASCADE ON DELETE CASCADE; ALTER TABLE formInstances ADD INDEX formInstances_sort (sort); CREATE TABLE formListValues (`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, `formInstanceId` INT(11) UNSIGNED NOT NULL, `sort` SMALLINT NOT NULL, `value` VARCHAR(255) NOT NULL, `isChecked` TINYINT(1) UNSIGNED NOT NULL) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci; ALTER TABLE formListValues ADD CONSTRAINT formListValues_formInstanceId_fk FOREIGN KEY (formInstanceId) REFERENCES formInstances(id) ON UPDATE CASCADE ON DELETE CASCADE; ALTER TABLE formListValues ADD INDEX formListValues_sort (sort);',''),(12,'M160321000000Feedback','CREATE TABLE feedback (`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, `formId` INT(11) UNSIGNED NOT NULL, `subjectFormInstanceId` INT(11) UNSIGNED NOT NULL, `subjectText` VARCHAR(255) NOT NULL, `host` VARCHAR(255) NOT NULL, `port` SMALLINT UNSIGNED NOT NULL, `type` VARCHAR(25) NOT NULL, `user` VARCHAR(255) NOT NULL, `password` VARCHAR(255) NOT NULL) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci; ALTER TABLE feedback ADD CONSTRAINT feedback_formId_fk FOREIGN KEY (formId) REFERENCES forms(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE feedback ADD CONSTRAINT feedback_subjectFormInstanceId_fk FOREIGN KEY (subjectFormInstanceId) REFERENCES formInstances(id) ON UPDATE RESTRICT ON DELETE RESTRICT;',''),(13,'M160321000100Records','CREATE TABLE designRecords (`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, `shortCardContainerDesignBlockId` INT(11) UNSIGNED NOT NULL, `shortCardInstanceDesignBlockId` INT(11) UNSIGNED NOT NULL, `shortCardTitleDesignBlockId` INT(11) UNSIGNED NOT NULL, `shortCardTitleDesignTextId` INT(11) UNSIGNED NOT NULL, `shortCardDateDesignBlockId` INT(11) UNSIGNED NOT NULL, `shortCardDateDesignTextId` INT(11) UNSIGNED NOT NULL, `shortCardDescriptionDesignBlockId` INT(11) UNSIGNED NOT NULL, `shortCardDescriptionDesignTextId` INT(11) UNSIGNED NOT NULL, `shortCardPaginationDesignBlockId` INT(11) UNSIGNED NOT NULL, `shortCardPaginationItemDesignBlockId` INT(11) UNSIGNED NOT NULL, `shortCardPaginationItemDesignTextId` INT(11) UNSIGNED NOT NULL, `shortCardViewType` TINYINT(3) UNSIGNED NOT NULL, `fullCardContainerDesignBlockId` INT(11) UNSIGNED NOT NULL, `fullCardTitleDesignBlockId` INT(11) UNSIGNED NOT NULL, `fullCardTitleDesignTextId` INT(11) UNSIGNED NOT NULL, `fullCardDateDesignBlockId` INT(11) UNSIGNED NOT NULL, `fullCardDateDesignTextId` INT(11) UNSIGNED NOT NULL, `fullCardTextDesignBlockId` INT(11) UNSIGNED NOT NULL) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci; ALTER TABLE designRecords ADD CONSTRAINT designRecords_shortCardContainerDesignBlockId_fk FOREIGN KEY (shortCardContainerDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designRecords ADD CONSTRAINT designRecords_shortCardInstanceDesignBlockId_fk FOREIGN KEY (shortCardInstanceDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designRecords ADD CONSTRAINT designRecords_shortCardTitleDesignBlockId_fk FOREIGN KEY (shortCardTitleDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designRecords ADD CONSTRAINT designRecords_shortCardTitleDesignTextId_fk FOREIGN KEY (shortCardTitleDesignTextId) REFERENCES designTexts(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designRecords ADD CONSTRAINT designRecords_shortCardDateDesignBlockId_fk FOREIGN KEY (shortCardDateDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designRecords ADD CONSTRAINT designRecords_shortCardDateDesignTextId_fk FOREIGN KEY (shortCardDateDesignTextId) REFERENCES designTexts(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designRecords ADD CONSTRAINT designRecords_shortCardDescriptionDesignBlockId_fk FOREIGN KEY (shortCardDescriptionDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designRecords ADD CONSTRAINT designRecords_shortCardDescriptionDesignTextId_fk FOREIGN KEY (shortCardDescriptionDesignTextId) REFERENCES designTexts(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designRecords ADD CONSTRAINT designRecords_shortCardPaginationDesignBlockId_fk FOREIGN KEY (shortCardPaginationDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designRecords ADD CONSTRAINT designRecords_shortCardPaginationItemDesignBlockId_fk FOREIGN KEY (shortCardPaginationItemDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designRecords ADD CONSTRAINT designRecords_shortCardPaginationItemDesignTextId_fk FOREIGN KEY (shortCardPaginationItemDesignTextId) REFERENCES designTexts(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designRecords ADD CONSTRAINT designRecords_fullCardContainerDesignBlockId_fk FOREIGN KEY (fullCardContainerDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designRecords ADD CONSTRAINT designRecords_fullCardTitleDesignBlockId_fk FOREIGN KEY (fullCardTitleDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designRecords ADD CONSTRAINT designRecords_fullCardTitleDesignTextId_fk FOREIGN KEY (fullCardTitleDesignTextId) REFERENCES designTexts(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designRecords ADD CONSTRAINT designRecords_fullCardDateDesignBlockId_fk FOREIGN KEY (fullCardDateDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designRecords ADD CONSTRAINT designRecords_fullCardDateDesignTextId_fk FOREIGN KEY (fullCardDateDesignTextId) REFERENCES designTexts(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designRecords ADD CONSTRAINT designRecords_fullCardTextDesignBlockId_fk FOREIGN KEY (fullCardTextDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; CREATE TABLE records (`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, `coverImageId` INT(11) UNSIGNED NOT NULL, `imagesImageId` INT(11) UNSIGNED NOT NULL, `descriptionTextId` INT(11) UNSIGNED NOT NULL, `textTextId` INT(11) UNSIGNED NOT NULL, `designRecordId` INT(11) UNSIGNED NOT NULL, `hasCover` TINYINT(1) UNSIGNED NOT NULL, `hasImages` TINYINT(1) UNSIGNED NOT NULL, `hasCoverZoom` TINYINT(1) UNSIGNED NOT NULL, `hasDescription` TINYINT(1) UNSIGNED NOT NULL, `useAutoload` TINYINT(1) UNSIGNED NOT NULL, `pageNavigationSize` TINYINT(3) UNSIGNED NOT NULL, `shortCardDateType` TINYINT(3) UNSIGNED NOT NULL, `fullCardDateType` TINYINT(3) UNSIGNED NOT NULL) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci; ALTER TABLE records ADD CONSTRAINT records_coverImageId_fk FOREIGN KEY (coverImageId) REFERENCES images(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE records ADD CONSTRAINT records_imagesImageId_fk FOREIGN KEY (imagesImageId) REFERENCES images(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE records ADD CONSTRAINT records_descriptionTextId_fk FOREIGN KEY (descriptionTextId) REFERENCES texts(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE records ADD CONSTRAINT records_textTextId_fk FOREIGN KEY (textTextId) REFERENCES texts(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE records ADD CONSTRAINT records_designRecordId_fk FOREIGN KEY (designRecordId) REFERENCES designRecords(id) ON UPDATE RESTRICT ON DELETE RESTRICT; CREATE TABLE designRecordClones (`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, `containerDesignBlockId` INT(11) UNSIGNED NOT NULL, `instanceDesignBlockId` INT(11) UNSIGNED NOT NULL, `titleDesignBlockId` INT(11) UNSIGNED NOT NULL, `titleDesignTextId` INT(11) UNSIGNED NOT NULL, `dateDesignBlockId` INT(11) UNSIGNED NOT NULL, `dateDesignTextId` INT(11) UNSIGNED NOT NULL, `descriptionDesignBlockId` INT(11) UNSIGNED NOT NULL, `descriptionDesignTextId` INT(11) UNSIGNED NOT NULL, `viewType` TINYINT(3) UNSIGNED NOT NULL) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci; ALTER TABLE designRecordClones ADD CONSTRAINT designRecordClones_containerDesignBlockId_fk FOREIGN KEY (containerDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designRecordClones ADD CONSTRAINT designRecordClones_instanceDesignBlockId_fk FOREIGN KEY (instanceDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designRecordClones ADD CONSTRAINT designRecordClones_titleDesignBlockId_fk FOREIGN KEY (titleDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designRecordClones ADD CONSTRAINT designRecordClones_titleDesignTextId_fk FOREIGN KEY (titleDesignTextId) REFERENCES designTexts(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designRecordClones ADD CONSTRAINT designRecordClones_dateDesignBlockId_fk FOREIGN KEY (dateDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designRecordClones ADD CONSTRAINT designRecordClones_dateDesignTextId_fk FOREIGN KEY (dateDesignTextId) REFERENCES designTexts(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designRecordClones ADD CONSTRAINT designRecordClones_descriptionDesignBlockId_fk FOREIGN KEY (descriptionDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designRecordClones ADD CONSTRAINT designRecordClones_descriptionDesignTextId_fk FOREIGN KEY (descriptionDesignTextId) REFERENCES designTexts(id) ON UPDATE RESTRICT ON DELETE RESTRICT; CREATE TABLE recordClones (`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, `recordId` INT(11) UNSIGNED NOT NULL, `coverImageId` INT(11) UNSIGNED NOT NULL, `descriptionTextId` INT(11) UNSIGNED NOT NULL, `designRecordCloneId` INT(11) UNSIGNED NOT NULL, `hasCover` TINYINT(1) UNSIGNED NOT NULL, `hasCoverZoom` TINYINT(1) UNSIGNED NOT NULL, `hasDescription` TINYINT(1) UNSIGNED NOT NULL, `dateType` TINYINT(3) UNSIGNED NOT NULL, `maxCount` TINYINT(3) UNSIGNED NOT NULL) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci; ALTER TABLE recordClones ADD CONSTRAINT recordClones_recordId_fk FOREIGN KEY (recordId) REFERENCES records(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE recordClones ADD CONSTRAINT recordClones_coverImageId_fk FOREIGN KEY (coverImageId) REFERENCES images(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE recordClones ADD CONSTRAINT recordClones_descriptionTextId_fk FOREIGN KEY (descriptionTextId) REFERENCES texts(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE recordClones ADD CONSTRAINT recordClones_designRecordCloneId_fk FOREIGN KEY (designRecordCloneId) REFERENCES designRecordClones(id) ON UPDATE RESTRICT ON DELETE RESTRICT; CREATE TABLE recordInstances (`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, `recordId` INT(11) UNSIGNED NOT NULL, `seoId` INT(11) UNSIGNED NOT NULL, `textTextInstanceId` INT(11) UNSIGNED NOT NULL, `descriptionTextInstanceId` INT(11) UNSIGNED NOT NULL, `imageGroupId` INT(11) UNSIGNED NOT NULL, `coverImageInstanceId` INT(11) UNSIGNED NULL, `date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, `sort` SMALLINT NOT NULL) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci; ALTER TABLE recordInstances ADD CONSTRAINT recordInstances_recordId_fk FOREIGN KEY (recordId) REFERENCES records(id) ON UPDATE CASCADE ON DELETE CASCADE; ALTER TABLE recordInstances ADD CONSTRAINT recordInstances_seoId_fk FOREIGN KEY (seoId) REFERENCES seo(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE recordInstances ADD CONSTRAINT recordInstances_textTextInstanceId_fk FOREIGN KEY (textTextInstanceId) REFERENCES textInstances(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE recordInstances ADD CONSTRAINT recordInstances_descriptionTextInstanceId_fk FOREIGN KEY (descriptionTextInstanceId) REFERENCES textInstances(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE recordInstances ADD CONSTRAINT recordInstances_imageGroupId_fk FOREIGN KEY (imageGroupId) REFERENCES imageGroups(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE recordInstances ADD CONSTRAINT recordInstances_coverImageInstanceId_fk FOREIGN KEY (coverImageInstanceId) REFERENCES imageInstances(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE recordInstances ADD INDEX recordInstances_date (date); ALTER TABLE recordInstances ADD INDEX recordInstances_sort (sort);',''),(14,'M160321000200Menu','CREATE TABLE designMenu (`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, `containerDesignBlockId` INT(11) UNSIGNED NOT NULL, `firstLevelDesignBlockId` INT(11) UNSIGNED NOT NULL, `firstLevelDesignTextId` INT(11) UNSIGNED NOT NULL, `firstLevelActiveDesignBlockId` INT(11) UNSIGNED NOT NULL, `firstLevelActiveDesignTextId` INT(11) UNSIGNED NOT NULL, `secondLevelDesignBlockId` INT(11) UNSIGNED NOT NULL, `secondLevelDesignTextId` INT(11) UNSIGNED NOT NULL, `secondLevelActiveDesignBlockId` INT(11) UNSIGNED NOT NULL, `secondLevelActiveDesignTextId` INT(11) UNSIGNED NOT NULL, `lastLevelDesignBlockId` INT(11) UNSIGNED NOT NULL, `lastLevelDesignTextId` INT(11) UNSIGNED NOT NULL, `lastLevelActiveDesignBlockId` INT(11) UNSIGNED NOT NULL, `lastLevelActiveDesignTextId` INT(11) UNSIGNED NOT NULL) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci; ALTER TABLE designMenu ADD CONSTRAINT designMenu_containerDesignBlockId_fk FOREIGN KEY (containerDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designMenu ADD CONSTRAINT designMenu_firstLevelDesignBlockId_fk FOREIGN KEY (firstLevelDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designMenu ADD CONSTRAINT designMenu_firstLevelDesignTextId_fk FOREIGN KEY (firstLevelDesignTextId) REFERENCES designTexts(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designMenu ADD CONSTRAINT designMenu_firstLevelActiveDesignBlockId_fk FOREIGN KEY (firstLevelActiveDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designMenu ADD CONSTRAINT designMenu_firstLevelActiveDesignTextId_fk FOREIGN KEY (firstLevelActiveDesignTextId) REFERENCES designTexts(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designMenu ADD CONSTRAINT designMenu_secondLevelDesignBlockId_fk FOREIGN KEY (secondLevelDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designMenu ADD CONSTRAINT designMenu_secondLevelDesignTextId_fk FOREIGN KEY (secondLevelDesignTextId) REFERENCES designTexts(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designMenu ADD CONSTRAINT designMenu_secondLevelActiveDesignBlockId_fk FOREIGN KEY (secondLevelActiveDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designMenu ADD CONSTRAINT designMenu_secondLevelActiveDesignTextId_fk FOREIGN KEY (secondLevelActiveDesignTextId) REFERENCES designTexts(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designMenu ADD CONSTRAINT designMenu_lastLevelDesignBlockId_fk FOREIGN KEY (lastLevelDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designMenu ADD CONSTRAINT designMenu_lastLevelDesignTextId_fk FOREIGN KEY (lastLevelDesignTextId) REFERENCES designTexts(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designMenu ADD CONSTRAINT designMenu_lastLevelActiveDesignBlockId_fk FOREIGN KEY (lastLevelActiveDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designMenu ADD CONSTRAINT designMenu_lastLevelActiveDesignTextId_fk FOREIGN KEY (lastLevelActiveDesignTextId) REFERENCES designTexts(id) ON UPDATE RESTRICT ON DELETE RESTRICT; CREATE TABLE menu (`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, `designMenuId` INT(11) UNSIGNED NOT NULL, `type` TINYINT(3) UNSIGNED NOT NULL) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci; ALTER TABLE menu ADD CONSTRAINT menu_designMenuId_fk FOREIGN KEY (designMenuId) REFERENCES designMenu(id) ON UPDATE RESTRICT ON DELETE RESTRICT; CREATE TABLE menuInstances (`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, `menuId` INT(11) UNSIGNED NOT NULL, `parentId` INT(11) UNSIGNED NULL, `sectionId` INT(11) UNSIGNED NULL, `icon` VARCHAR(50) NOT NULL, `sort` SMALLINT NOT NULL, `staticName` VARCHAR(255) NOT NULL, `staticUrl` VARCHAR(255) NOT NULL) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci; ALTER TABLE menuInstances ADD CONSTRAINT menuInstances_menuId_fk FOREIGN KEY (menuId) REFERENCES menu(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE menuInstances ADD CONSTRAINT menuInstances_parentId_fk FOREIGN KEY (parentId) REFERENCES menuInstances(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE menuInstances ADD CONSTRAINT menuInstances_sectionId_fk FOREIGN KEY (sectionId) REFERENCES sections(id) ON UPDATE RESTRICT ON DELETE RESTRICT;',''),(15,'M160321000300SiteMaps','CREATE TABLE siteMaps (`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, `containerDesignBlockId` INT(11) UNSIGNED NOT NULL, `itemDesignBlockId` INT(11) UNSIGNED NOT NULL, `itemDesignTextId` INT(11) UNSIGNED NOT NULL, `style` TINYINT(3) UNSIGNED NOT NULL) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci; ALTER TABLE siteMaps ADD CONSTRAINT siteMaps_containerDesignBlockId_fk FOREIGN KEY (containerDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE siteMaps ADD CONSTRAINT siteMaps_itemDesignBlockId_fk FOREIGN KEY (itemDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE siteMaps ADD CONSTRAINT siteMaps_itemDesignTextId_fk FOREIGN KEY (itemDesignTextId) REFERENCES designTexts(id) ON UPDATE RESTRICT ON DELETE RESTRICT;',''),(16,'M160321000400Search','CREATE TABLE designSearch (`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, `containerDesignBlockId` INT(11) UNSIGNED NOT NULL, `titleDesignBlockId` INT(11) UNSIGNED NOT NULL, `titleDesignTextId` INT(11) UNSIGNED NOT NULL, `descriptionDesignBlockId` INT(11) UNSIGNED NOT NULL, `descriptionDesignTextId` INT(11) UNSIGNED NOT NULL, `paginationDesignBlockId` INT(11) UNSIGNED NOT NULL, `paginationItemDesignBlockId` INT(11) UNSIGNED NOT NULL, `paginationItemDesignTextId` INT(11) UNSIGNED NOT NULL) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci; ALTER TABLE designSearch ADD CONSTRAINT designSearch_containerDesignBlockId_fk FOREIGN KEY (containerDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designSearch ADD CONSTRAINT designSearch_titleDesignBlockId_fk FOREIGN KEY (titleDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designSearch ADD CONSTRAINT designSearch_titleDesignTextId_fk FOREIGN KEY (titleDesignTextId) REFERENCES designTexts(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designSearch ADD CONSTRAINT designSearch_descriptionDesignBlockId_fk FOREIGN KEY (descriptionDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designSearch ADD CONSTRAINT designSearch_descriptionDesignTextId_fk FOREIGN KEY (descriptionDesignTextId) REFERENCES designTexts(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designSearch ADD CONSTRAINT designSearch_paginationDesignBlockId_fk FOREIGN KEY (paginationDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designSearch ADD CONSTRAINT designSearch_paginationItemDesignBlockId_fk FOREIGN KEY (paginationItemDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designSearch ADD CONSTRAINT designSearch_paginationItemDesignTextId_fk FOREIGN KEY (paginationItemDesignTextId) REFERENCES designTexts(id) ON UPDATE RESTRICT ON DELETE RESTRICT; CREATE TABLE search (`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, `formId` INT(11) UNSIGNED NOT NULL, `searchDesignId` INT(11) UNSIGNED NOT NULL) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci; ALTER TABLE search ADD CONSTRAINT search_formId_fk FOREIGN KEY (formId) REFERENCES forms(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE search ADD CONSTRAINT search_searchDesignId_fk FOREIGN KEY (searchDesignId) REFERENCES designSearch(id) ON UPDATE RESTRICT ON DELETE RESTRICT; CREATE TABLE searchQueries (`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, `searchId` INT(11) UNSIGNED NOT NULL, `text` VARCHAR(255) NOT NULL, `date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, `ip` VARCHAR(25) NOT NULL, `ua` VARCHAR(255) NOT NULL, `uri` VARCHAR(255) NOT NULL, `ref` VARCHAR(255) NOT NULL) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci; ALTER TABLE searchQueries ADD CONSTRAINT searchQueries_searchId_fk FOREIGN KEY (searchId) REFERENCES search(id) ON UPDATE CASCADE ON DELETE CASCADE;',''),(17,'M160321000500Fields','CREATE TABLE designFields (`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, `shortCardContainerDesignBlockId` INT(11) UNSIGNED NOT NULL, `shortCardLabelDesignBlockId` INT(11) UNSIGNED NOT NULL, `shortCardLabelDesignTextId` INT(11) UNSIGNED NOT NULL, `shortCardValueDesignBlockId` INT(11) UNSIGNED NOT NULL, `shortCardValueDesignTextId` INT(11) UNSIGNED NOT NULL, `fullCardContainerDesignBlockId` INT(11) UNSIGNED NOT NULL, `fullCardLabelDesignBlockId` INT(11) UNSIGNED NOT NULL, `fullCardLabelDesignTextId` INT(11) UNSIGNED NOT NULL, `fullCardValueDesignBlockId` INT(11) UNSIGNED NOT NULL, `fullCardValueDesignTextId` INT(11) UNSIGNED NOT NULL) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci; ALTER TABLE designFields ADD CONSTRAINT designFields_shortCardContainerDesignBlockId_fk FOREIGN KEY (shortCardContainerDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designFields ADD CONSTRAINT designFields_shortCardLabelDesignBlockId_fk FOREIGN KEY (shortCardLabelDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designFields ADD CONSTRAINT designFields_shortCardLabelDesignTextId_fk FOREIGN KEY (shortCardLabelDesignTextId) REFERENCES designTexts(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designFields ADD CONSTRAINT designFields_shortCardValueDesignBlockId_fk FOREIGN KEY (shortCardValueDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designFields ADD CONSTRAINT designFields_shortCardValueDesignTextId_fk FOREIGN KEY (shortCardValueDesignTextId) REFERENCES designTexts(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designFields ADD CONSTRAINT designFields_fullCardContainerDesignBlockId_fk FOREIGN KEY (fullCardContainerDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designFields ADD CONSTRAINT designFields_fullCardLabelDesignBlockId_fk FOREIGN KEY (fullCardLabelDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designFields ADD CONSTRAINT designFields_fullCardLabelDesignTextId_fk FOREIGN KEY (fullCardLabelDesignTextId) REFERENCES designTexts(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designFields ADD CONSTRAINT designFields_fullCardValueDesignBlockId_fk FOREIGN KEY (fullCardValueDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designFields ADD CONSTRAINT designFields_fullCardValueDesignTextId_fk FOREIGN KEY (fullCardValueDesignTextId) REFERENCES designTexts(id) ON UPDATE RESTRICT ON DELETE RESTRICT; CREATE TABLE fields (`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, `designFieldId` INT(11) UNSIGNED NOT NULL) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci; ALTER TABLE fields ADD CONSTRAINT fields_designFieldId_fk FOREIGN KEY (designFieldId) REFERENCES designFields(id) ON UPDATE RESTRICT ON DELETE RESTRICT; CREATE TABLE fieldTemplates (`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, `fieldId` INT(11) UNSIGNED NOT NULL, `sort` SMALLINT NOT NULL, `label` VARCHAR(255) NOT NULL, `type` TINYINT(3) UNSIGNED NOT NULL, `validationType` TINYINT(3) UNSIGNED NOT NULL, `isHideForShortCard` TINYINT(1) UNSIGNED NOT NULL, `isShowEmpty` TINYINT(1) UNSIGNED NOT NULL) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci; ALTER TABLE fieldTemplates ADD CONSTRAINT fieldTemplates_fieldId_fk FOREIGN KEY (fieldId) REFERENCES fields(id) ON UPDATE CASCADE ON DELETE CASCADE; ALTER TABLE fieldTemplates ADD INDEX fieldTemplates_sort (sort); CREATE TABLE fieldGroups (`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, `fieldId` INT(11) UNSIGNED NOT NULL) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci; ALTER TABLE fieldGroups ADD CONSTRAINT fieldGroups_fieldId_fk FOREIGN KEY (fieldId) REFERENCES fields(id) ON UPDATE RESTRICT ON DELETE RESTRICT; CREATE TABLE fieldInstances (`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, `fieldGroupId` INT(11) UNSIGNED NOT NULL, `fieldTemplateId` INT(11) UNSIGNED NOT NULL, `value` VARCHAR(255) NOT NULL) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci; ALTER TABLE fieldInstances ADD CONSTRAINT fieldInstances_fieldGroupId_fk FOREIGN KEY (fieldGroupId) REFERENCES fieldGroups(id) ON UPDATE CASCADE ON DELETE CASCADE; ALTER TABLE fieldInstances ADD CONSTRAINT fieldInstances_fieldTemplateId_fk FOREIGN KEY (fieldTemplateId) REFERENCES fieldTemplates(id) ON UPDATE CASCADE ON DELETE CASCADE; ALTER TABLE fieldInstances ADD INDEX fieldInstances_value (value); CREATE TABLE fieldListValues (`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, `fieldTemplateId` INT(11) UNSIGNED NOT NULL, `value` VARCHAR(255) NOT NULL, `sort` SMALLINT NOT NULL, `isChecked` TINYINT(1) UNSIGNED NOT NULL) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci; ALTER TABLE fieldListValues ADD CONSTRAINT fieldListValues_fieldTemplateId_fk FOREIGN KEY (fieldTemplateId) REFERENCES fieldTemplates(id) ON UPDATE CASCADE ON DELETE CASCADE; ALTER TABLE fieldListValues ADD INDEX fieldListValues_sort (sort);',''),(18,'M160321000550Tabs','CREATE TABLE designTabs (`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, `containerDesignBlockId` INT(11) UNSIGNED NOT NULL, `tabDesignBlockId` INT(11) UNSIGNED NOT NULL, `tabDesignTextId` INT(11) UNSIGNED NOT NULL, `contentDesignBlockId` INT(11) UNSIGNED NOT NULL) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci; ALTER TABLE designTabs ADD CONSTRAINT designTabs_containerDesignBlockId_fk FOREIGN KEY (containerDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designTabs ADD CONSTRAINT designTabs_tabDesignBlockId_fk FOREIGN KEY (tabDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designTabs ADD CONSTRAINT designTabs_tabDesignTextId_fk FOREIGN KEY (tabDesignTextId) REFERENCES designTexts(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designTabs ADD CONSTRAINT designTabs_contentDesignBlockId_fk FOREIGN KEY (contentDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; CREATE TABLE tabs (`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, `designTabsId` INT(11) UNSIGNED NOT NULL, `textId` INT(11) UNSIGNED NOT NULL, `isShowEmpty` TINYINT(1) UNSIGNED NOT NULL, `isLazyLoad` TINYINT(1) UNSIGNED NOT NULL) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci; ALTER TABLE tabs ADD CONSTRAINT tabs_designTabsId_fk FOREIGN KEY (designTabsId) REFERENCES designTabs(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE tabs ADD CONSTRAINT tabs_textId_fk FOREIGN KEY (textId) REFERENCES texts(id) ON UPDATE RESTRICT ON DELETE RESTRICT; CREATE TABLE tabTemplates (`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, `tabId` INT(11) UNSIGNED NOT NULL, `sort` SMALLINT NOT NULL, `label` VARCHAR(255) NOT NULL) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci; ALTER TABLE tabTemplates ADD CONSTRAINT tabTemplates_tabId_fk FOREIGN KEY (tabId) REFERENCES tabs(id) ON UPDATE CASCADE ON DELETE CASCADE; ALTER TABLE tabTemplates ADD INDEX tabTemplates_sort (sort); CREATE TABLE tabGroups (`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, `tabId` INT(11) UNSIGNED NOT NULL) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci; ALTER TABLE tabGroups ADD CONSTRAINT tabGroups_tabId_fk FOREIGN KEY (tabId) REFERENCES tabs(id) ON UPDATE RESTRICT ON DELETE RESTRICT; CREATE TABLE tabInstances (`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, `tabGroupId` INT(11) UNSIGNED NOT NULL, `textInstanceId` INT(11) UNSIGNED NOT NULL, `tabTemplateId` INT(11) UNSIGNED NOT NULL) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci; ALTER TABLE tabInstances ADD CONSTRAINT tabInstances_tabGroupId_fk FOREIGN KEY (tabGroupId) REFERENCES tabGroups(id) ON UPDATE CASCADE ON DELETE CASCADE; ALTER TABLE tabInstances ADD CONSTRAINT tabInstances_textInstanceId_fk FOREIGN KEY (textInstanceId) REFERENCES textInstances(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE tabInstances ADD CONSTRAINT tabInstances_tabTemplateId_fk FOREIGN KEY (tabTemplateId) REFERENCES tabTemplates(id) ON UPDATE CASCADE ON DELETE CASCADE;',''),(19,'M160321000700Catalogs','CREATE TABLE designCatalogs (`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, `shortCardContainerDesignBlockId` INT(11) UNSIGNED NOT NULL, `shortCardInstanceDesignBlockId` INT(11) UNSIGNED NOT NULL, `shortCardTitleDesignBlockId` INT(11) UNSIGNED NOT NULL, `shortCardTitleDesignTextId` INT(11) UNSIGNED NOT NULL, `shortCardDateDesignTextId` INT(11) UNSIGNED NOT NULL, `shortCardPriceDesignBlockId` INT(11) UNSIGNED NOT NULL, `shortCardPriceDesignTextId` INT(11) UNSIGNED NOT NULL, `shortCardOldPriceDesignBlockId` INT(11) UNSIGNED NOT NULL, `shortCardOldPriceDesignTextId` INT(11) UNSIGNED NOT NULL, `shortCardDescriptionDesignBlockId` INT(11) UNSIGNED NOT NULL, `shortCardDescriptionDesignTextId` INT(11) UNSIGNED NOT NULL, `shortCardPaginationDesignBlockId` INT(11) UNSIGNED NOT NULL, `shortCardPaginationItemDesignBlockId` INT(11) UNSIGNED NOT NULL, `shortCardPaginationItemDesignTextId` INT(11) UNSIGNED NOT NULL, `fullCardContainerDesignBlockId` INT(11) UNSIGNED NOT NULL, `fullCardTitleDesignBlockId` INT(11) UNSIGNED NOT NULL, `fullCardTitleDesignTextId` INT(11) UNSIGNED NOT NULL, `fullCardDateDesignTextId` INT(11) UNSIGNED NOT NULL, `fullCardPriceDesignBlockId` INT(11) UNSIGNED NOT NULL, `fullCardPriceDesignTextId` INT(11) UNSIGNED NOT NULL, `fullCardOldPriceDesignBlockId` INT(11) UNSIGNED NOT NULL, `fullCardOldPriceDesignTextId` INT(11) UNSIGNED NOT NULL, `fullCardBinButtonDesignBlockId` INT(11) UNSIGNED NOT NULL, `fullCardBinButtonDesignTextId` INT(11) UNSIGNED NOT NULL, `shortCardViewType` TINYINT(3) UNSIGNED NOT NULL, `fullCardImagesPosition` TINYINT(3) UNSIGNED NOT NULL, `fullCardDatePosition` TINYINT(3) UNSIGNED NOT NULL) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci; ALTER TABLE designCatalogs ADD CONSTRAINT designCatalogs_shortCardContainerDesignBlockId_fk FOREIGN KEY (shortCardContainerDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designCatalogs ADD CONSTRAINT designCatalogs_shortCardInstanceDesignBlockId_fk FOREIGN KEY (shortCardInstanceDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designCatalogs ADD CONSTRAINT designCatalogs_shortCardTitleDesignBlockId_fk FOREIGN KEY (shortCardTitleDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designCatalogs ADD CONSTRAINT designCatalogs_shortCardTitleDesignTextId_fk FOREIGN KEY (shortCardTitleDesignTextId) REFERENCES designTexts(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designCatalogs ADD CONSTRAINT designCatalogs_shortCardDateDesignTextId_fk FOREIGN KEY (shortCardDateDesignTextId) REFERENCES designTexts(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designCatalogs ADD CONSTRAINT designCatalogs_shortCardPriceDesignBlockId_fk FOREIGN KEY (shortCardPriceDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designCatalogs ADD CONSTRAINT designCatalogs_shortCardPriceDesignTextId_fk FOREIGN KEY (shortCardPriceDesignTextId) REFERENCES designTexts(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designCatalogs ADD CONSTRAINT designCatalogs_shortCardOldPriceDesignBlockId_fk FOREIGN KEY (shortCardOldPriceDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designCatalogs ADD CONSTRAINT designCatalogs_shortCardOldPriceDesignTextId_fk FOREIGN KEY (shortCardOldPriceDesignTextId) REFERENCES designTexts(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designCatalogs ADD CONSTRAINT designCatalogs_shortCardDescriptionDesignBlockId_fk FOREIGN KEY (shortCardDescriptionDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designCatalogs ADD CONSTRAINT designCatalogs_shortCardDescriptionDesignTextId_fk FOREIGN KEY (shortCardDescriptionDesignTextId) REFERENCES designTexts(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designCatalogs ADD CONSTRAINT designCatalogs_shortCardPaginationDesignBlockId_fk FOREIGN KEY (shortCardPaginationDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designCatalogs ADD CONSTRAINT designCatalogs_shortCardPaginationItemDesignBlockId_fk FOREIGN KEY (shortCardPaginationItemDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designCatalogs ADD CONSTRAINT designCatalogs_shortCardPaginationItemDesignTextId_fk FOREIGN KEY (shortCardPaginationItemDesignTextId) REFERENCES designTexts(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designCatalogs ADD CONSTRAINT designCatalogs_fullCardContainerDesignBlockId_fk FOREIGN KEY (fullCardContainerDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designCatalogs ADD CONSTRAINT designCatalogs_fullCardTitleDesignBlockId_fk FOREIGN KEY (fullCardTitleDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designCatalogs ADD CONSTRAINT designCatalogs_fullCardTitleDesignTextId_fk FOREIGN KEY (fullCardTitleDesignTextId) REFERENCES designTexts(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designCatalogs ADD CONSTRAINT designCatalogs_fullCardDateDesignTextId_fk FOREIGN KEY (fullCardDateDesignTextId) REFERENCES designTexts(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designCatalogs ADD CONSTRAINT designCatalogs_fullCardPriceDesignBlockId_fk FOREIGN KEY (fullCardPriceDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designCatalogs ADD CONSTRAINT designCatalogs_fullCardPriceDesignTextId_fk FOREIGN KEY (fullCardPriceDesignTextId) REFERENCES designTexts(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designCatalogs ADD CONSTRAINT designCatalogs_fullCardOldPriceDesignBlockId_fk FOREIGN KEY (fullCardOldPriceDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designCatalogs ADD CONSTRAINT designCatalogs_fullCardOldPriceDesignTextId_fk FOREIGN KEY (fullCardOldPriceDesignTextId) REFERENCES designTexts(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designCatalogs ADD CONSTRAINT designCatalogs_fullCardBinButtonDesignBlockId_fk FOREIGN KEY (fullCardBinButtonDesignBlockId) REFERENCES designBlocks(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE designCatalogs ADD CONSTRAINT designCatalogs_fullCardBinButtonDesignTextId_fk FOREIGN KEY (fullCardBinButtonDesignTextId) REFERENCES designTexts(id) ON UPDATE RESTRICT ON DELETE RESTRICT; CREATE TABLE catalogs (`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, `imageId` INT(11) UNSIGNED NOT NULL, `tabId` INT(11) UNSIGNED NOT NULL, `fieldId` INT(11) UNSIGNED NOT NULL, `descriptionTextId` INT(11) UNSIGNED NOT NULL, `designCatalogId` INT(11) UNSIGNED NOT NULL, `hasImages` TINYINT(1) UNSIGNED NOT NULL, `useAutoload` TINYINT(1) UNSIGNED NOT NULL, `pageNavigationSize` TINYINT(3) UNSIGNED NOT NULL, `shortCardDateType` TINYINT(3) UNSIGNED NOT NULL, `fullCardDateType` TINYINT(3) UNSIGNED NOT NULL, `hasRelations` TINYINT(1) UNSIGNED NOT NULL, `relationsLabel` VARCHAR(255) NOT NULL, `hasBin` TINYINT(1) UNSIGNED NOT NULL) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci; ALTER TABLE catalogs ADD CONSTRAINT catalogs_imageId_fk FOREIGN KEY (imageId) REFERENCES images(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE catalogs ADD CONSTRAINT catalogs_tabId_fk FOREIGN KEY (tabId) REFERENCES tabs(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE catalogs ADD CONSTRAINT catalogs_fieldId_fk FOREIGN KEY (fieldId) REFERENCES fields(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE catalogs ADD CONSTRAINT catalogs_descriptionTextId_fk FOREIGN KEY (descriptionTextId) REFERENCES texts(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE catalogs ADD CONSTRAINT catalogs_designCatalogId_fk FOREIGN KEY (designCatalogId) REFERENCES designCatalogs(id) ON UPDATE RESTRICT ON DELETE RESTRICT; CREATE TABLE catalogMenu (`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, `parentId` INT(11) UNSIGNED NULL, `seoId` INT(11) UNSIGNED NOT NULL, `catalogId` INT(11) UNSIGNED NOT NULL, `icon` VARCHAR(50) NOT NULL, `subName` VARCHAR(255) NOT NULL) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci; ALTER TABLE catalogMenu ADD CONSTRAINT catalogMenu_parentId_fk FOREIGN KEY (parentId) REFERENCES catalogMenu(id) ON UPDATE CASCADE ON DELETE CASCADE; ALTER TABLE catalogMenu ADD CONSTRAINT catalogMenu_seoId_fk FOREIGN KEY (seoId) REFERENCES seo(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE catalogMenu ADD CONSTRAINT catalogMenu_catalogId_fk FOREIGN KEY (catalogId) REFERENCES catalogs(id) ON UPDATE CASCADE ON DELETE CASCADE; CREATE TABLE catalogInstances (`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, `seoId` INT(11) UNSIGNED NOT NULL, `tabGroupId` INT(11) UNSIGNED NOT NULL, `imageGroupId` INT(11) UNSIGNED NOT NULL, `catalogMenuId` INT(11) UNSIGNED NOT NULL, `fieldGroupId` INT(11) UNSIGNED NOT NULL, `price` FLOAT NOT NULL, `oldPrice` FLOAT NOT NULL, `date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci; ALTER TABLE catalogInstances ADD CONSTRAINT catalogInstances_seoId_fk FOREIGN KEY (seoId) REFERENCES seo(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE catalogInstances ADD CONSTRAINT catalogInstances_tabGroupId_fk FOREIGN KEY (tabGroupId) REFERENCES tabGroups(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE catalogInstances ADD CONSTRAINT catalogInstances_imageGroupId_fk FOREIGN KEY (imageGroupId) REFERENCES imageGroups(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE catalogInstances ADD CONSTRAINT catalogInstances_catalogMenuId_fk FOREIGN KEY (catalogMenuId) REFERENCES catalogMenu(id) ON UPDATE CASCADE ON DELETE CASCADE; ALTER TABLE catalogInstances ADD CONSTRAINT catalogInstances_fieldGroupId_fk FOREIGN KEY (fieldGroupId) REFERENCES fieldGroups(id) ON UPDATE RESTRICT ON DELETE RESTRICT; ALTER TABLE catalogInstances ADD INDEX catalogInstances_price (price); ALTER TABLE catalogInstances ADD INDEX catalogInstances_date (date); CREATE TABLE catalogInstanceLinks (`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, `catalogInstanceId` INT(11) UNSIGNED NOT NULL, `linkCatalogInstanceId` INT(11) UNSIGNED NOT NULL) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci; ALTER TABLE catalogInstanceLinks ADD CONSTRAINT catalogInstanceLinks_catalogInstanceId_fk FOREIGN KEY (catalogInstanceId) REFERENCES catalogInstances(id) ON UPDATE CASCADE ON DELETE CASCADE; ALTER TABLE catalogInstanceLinks ADD CONSTRAINT catalogInstanceLinks_linkCatalogInstanceId_fk FOREIGN KEY (linkCatalogInstanceId) REFERENCES catalogInstances(id) ON UPDATE CASCADE ON DELETE CASCADE; ALTER TABLE catalogInstanceLinks ADD UNIQUE INDEX catalogInstanceLinks_catalogInstanceId_linkCatalogInstanceId (catalogInstanceId,linkCatalogInstanceId); CREATE TABLE catalogBins (`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, `catalogId` INT(11) UNSIGNED NOT NULL, `catalogInstanceId` INT(11) UNSIGNED NOT NULL, `count` SMALLINT UNSIGNED NOT NULL, `status` TINYINT(3) UNSIGNED NOT NULL) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci; ALTER TABLE catalogBins ADD CONSTRAINT catalogBins_catalogId_fk FOREIGN KEY (catalogId) REFERENCES catalogs(id) ON UPDATE CASCADE ON DELETE CASCADE; ALTER TABLE catalogBins ADD CONSTRAINT catalogBins_catalogInstanceId_fk FOREIGN KEY (catalogInstanceId) REFERENCES catalogInstances(id) ON UPDATE CASCADE ON DELETE CASCADE; ALTER TABLE catalogBins ADD INDEX catalogBins_status (status); CREATE TABLE catalogOrders (`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, `catalogBinId` INT(11) UNSIGNED NOT NULL, `formId` INT(11) UNSIGNED NOT NULL, `email` VARCHAR(100) NOT NULL) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci; ALTER TABLE catalogOrders ADD CONSTRAINT catalogOrders_catalogBinId_fk FOREIGN KEY (catalogBinId) REFERENCES catalogBins(id) ON UPDATE CASCADE ON DELETE CASCADE; ALTER TABLE catalogOrders ADD CONSTRAINT catalogOrders_formId_fk FOREIGN KEY (formId) REFERENCES forms(id) ON UPDATE CASCADE ON DELETE CASCADE;',''),(20,'M160321000800Settings','CREATE TABLE settings (`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, `type` VARCHAR(25) NOT NULL, `value` TEXT NOT NULL) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci; ALTER TABLE settings ADD UNIQUE INDEX settings_type (type);','');
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recordClones`
--

DROP TABLE IF EXISTS `recordClones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recordClones` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `recordId` int(11) unsigned NOT NULL,
  `coverImageId` int(11) unsigned NOT NULL,
  `descriptionTextId` int(11) unsigned NOT NULL,
  `designRecordCloneId` int(11) unsigned NOT NULL,
  `hasCover` tinyint(1) unsigned NOT NULL,
  `hasCoverZoom` tinyint(1) unsigned NOT NULL,
  `hasDescription` tinyint(1) unsigned NOT NULL,
  `dateType` tinyint(3) unsigned NOT NULL,
  `maxCount` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `recordClones_recordId_fk` (`recordId`),
  KEY `recordClones_coverImageId_fk` (`coverImageId`),
  KEY `recordClones_descriptionTextId_fk` (`descriptionTextId`),
  KEY `recordClones_designRecordCloneId_fk` (`designRecordCloneId`),
  CONSTRAINT `recordClones_coverImageId_fk` FOREIGN KEY (`coverImageId`) REFERENCES `images` (`id`),
  CONSTRAINT `recordClones_descriptionTextId_fk` FOREIGN KEY (`descriptionTextId`) REFERENCES `texts` (`id`),
  CONSTRAINT `recordClones_designRecordCloneId_fk` FOREIGN KEY (`designRecordCloneId`) REFERENCES `designRecordClones` (`id`),
  CONSTRAINT `recordClones_recordId_fk` FOREIGN KEY (`recordId`) REFERENCES `records` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recordClones`
--

LOCK TABLES `recordClones` WRITE;
/*!40000 ALTER TABLE `recordClones` DISABLE KEYS */;
/*!40000 ALTER TABLE `recordClones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recordInstances`
--

DROP TABLE IF EXISTS `recordInstances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recordInstances` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `recordId` int(11) unsigned NOT NULL,
  `seoId` int(11) unsigned NOT NULL,
  `textTextInstanceId` int(11) unsigned NOT NULL,
  `descriptionTextInstanceId` int(11) unsigned NOT NULL,
  `imageGroupId` int(11) unsigned NOT NULL,
  `coverImageInstanceId` int(11) unsigned DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sort` smallint(6) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `recordInstances_recordId_fk` (`recordId`),
  KEY `recordInstances_seoId_fk` (`seoId`),
  KEY `recordInstances_textTextInstanceId_fk` (`textTextInstanceId`),
  KEY `recordInstances_descriptionTextInstanceId_fk` (`descriptionTextInstanceId`),
  KEY `recordInstances_imageGroupId_fk` (`imageGroupId`),
  KEY `recordInstances_coverImageInstanceId_fk` (`coverImageInstanceId`),
  KEY `recordInstances_date` (`date`),
  KEY `recordInstances_sort` (`sort`),
  CONSTRAINT `recordInstances_coverImageInstanceId_fk` FOREIGN KEY (`coverImageInstanceId`) REFERENCES `imageInstances` (`id`),
  CONSTRAINT `recordInstances_descriptionTextInstanceId_fk` FOREIGN KEY (`descriptionTextInstanceId`) REFERENCES `textInstances` (`id`),
  CONSTRAINT `recordInstances_imageGroupId_fk` FOREIGN KEY (`imageGroupId`) REFERENCES `imageGroups` (`id`),
  CONSTRAINT `recordInstances_recordId_fk` FOREIGN KEY (`recordId`) REFERENCES `records` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `recordInstances_seoId_fk` FOREIGN KEY (`seoId`) REFERENCES `seo` (`id`),
  CONSTRAINT `recordInstances_textTextInstanceId_fk` FOREIGN KEY (`textTextInstanceId`) REFERENCES `textInstances` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recordInstances`
--

LOCK TABLES `recordInstances` WRITE;
/*!40000 ALTER TABLE `recordInstances` DISABLE KEYS */;
/*!40000 ALTER TABLE `recordInstances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `records`
--

DROP TABLE IF EXISTS `records`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `records` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `coverImageId` int(11) unsigned NOT NULL,
  `imagesImageId` int(11) unsigned NOT NULL,
  `descriptionTextId` int(11) unsigned NOT NULL,
  `textTextId` int(11) unsigned NOT NULL,
  `designRecordId` int(11) unsigned NOT NULL,
  `hasCover` tinyint(1) unsigned NOT NULL,
  `hasImages` tinyint(1) unsigned NOT NULL,
  `hasCoverZoom` tinyint(1) unsigned NOT NULL,
  `hasDescription` tinyint(1) unsigned NOT NULL,
  `useAutoload` tinyint(1) unsigned NOT NULL,
  `pageNavigationSize` tinyint(3) unsigned NOT NULL,
  `shortCardDateType` tinyint(3) unsigned NOT NULL,
  `fullCardDateType` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `records_coverImageId_fk` (`coverImageId`),
  KEY `records_imagesImageId_fk` (`imagesImageId`),
  KEY `records_descriptionTextId_fk` (`descriptionTextId`),
  KEY `records_textTextId_fk` (`textTextId`),
  KEY `records_designRecordId_fk` (`designRecordId`),
  CONSTRAINT `records_coverImageId_fk` FOREIGN KEY (`coverImageId`) REFERENCES `images` (`id`),
  CONSTRAINT `records_descriptionTextId_fk` FOREIGN KEY (`descriptionTextId`) REFERENCES `texts` (`id`),
  CONSTRAINT `records_designRecordId_fk` FOREIGN KEY (`designRecordId`) REFERENCES `designRecords` (`id`),
  CONSTRAINT `records_imagesImageId_fk` FOREIGN KEY (`imagesImageId`) REFERENCES `images` (`id`),
  CONSTRAINT `records_textTextId_fk` FOREIGN KEY (`textTextId`) REFERENCES `texts` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `records`
--

LOCK TABLES `records` WRITE;
/*!40000 ALTER TABLE `records` DISABLE KEYS */;
/*!40000 ALTER TABLE `records` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `removedFiles`
--

DROP TABLE IF EXISTS `removedFiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `removedFiles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniqueName` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `removedFiles`
--

LOCK TABLES `removedFiles` WRITE;
/*!40000 ALTER TABLE `removedFiles` DISABLE KEYS */;
/*!40000 ALTER TABLE `removedFiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `search`
--

DROP TABLE IF EXISTS `search`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `search` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `formId` int(11) unsigned NOT NULL,
  `searchDesignId` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `search_formId_fk` (`formId`),
  KEY `search_searchDesignId_fk` (`searchDesignId`),
  CONSTRAINT `search_formId_fk` FOREIGN KEY (`formId`) REFERENCES `forms` (`id`),
  CONSTRAINT `search_searchDesignId_fk` FOREIGN KEY (`searchDesignId`) REFERENCES `designSearch` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `search`
--

LOCK TABLES `search` WRITE;
/*!40000 ALTER TABLE `search` DISABLE KEYS */;
/*!40000 ALTER TABLE `search` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `searchQueries`
--

DROP TABLE IF EXISTS `searchQueries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `searchQueries` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `searchId` int(11) unsigned NOT NULL,
  `text` varchar(255) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(25) NOT NULL,
  `ua` varchar(255) NOT NULL,
  `uri` varchar(255) NOT NULL,
  `ref` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `searchQueries_searchId_fk` (`searchId`),
  CONSTRAINT `searchQueries_searchId_fk` FOREIGN KEY (`searchId`) REFERENCES `search` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `searchQueries`
--

LOCK TABLES `searchQueries` WRITE;
/*!40000 ALTER TABLE `searchQueries` DISABLE KEYS */;
/*!40000 ALTER TABLE `searchQueries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sections`
--

DROP TABLE IF EXISTS `sections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sections` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `seoId` int(11) unsigned NOT NULL,
  `designBlockId` int(11) unsigned NOT NULL,
  `language` tinyint(3) unsigned NOT NULL,
  `padding` int(10) unsigned NOT NULL,
  `isMain` tinyint(1) unsigned NOT NULL,
  `isPublished` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sections_seoId_fk` (`seoId`),
  KEY `sections_designBlockId_fk` (`designBlockId`),
  KEY `sections_language_isMain_isPublished` (`language`,`isMain`,`isPublished`),
  KEY `sections_language_isPublished` (`language`,`isPublished`),
  KEY `sections_language` (`language`),
  CONSTRAINT `sections_designBlockId_fk` FOREIGN KEY (`designBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `sections_seoId_fk` FOREIGN KEY (`seoId`) REFERENCES `seo` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sections`
--

LOCK TABLES `sections` WRITE;
/*!40000 ALTER TABLE `sections` DISABLE KEYS */;
/*!40000 ALTER TABLE `sections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `seo`
--

DROP TABLE IF EXISTS `seo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `seo` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `title` varchar(100) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `seo_name` (`name`),
  KEY `seo_alias` (`alias`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `seo`
--

LOCK TABLES `seo` WRITE;
/*!40000 ALTER TABLE `seo` DISABLE KEYS */;
/*!40000 ALTER TABLE `seo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(25) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `siteMaps`
--

DROP TABLE IF EXISTS `siteMaps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `siteMaps` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `containerDesignBlockId` int(11) unsigned NOT NULL,
  `itemDesignBlockId` int(11) unsigned NOT NULL,
  `itemDesignTextId` int(11) unsigned NOT NULL,
  `style` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `siteMaps_containerDesignBlockId_fk` (`containerDesignBlockId`),
  KEY `siteMaps_itemDesignBlockId_fk` (`itemDesignBlockId`),
  KEY `siteMaps_itemDesignTextId_fk` (`itemDesignTextId`),
  CONSTRAINT `siteMaps_containerDesignBlockId_fk` FOREIGN KEY (`containerDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `siteMaps_itemDesignBlockId_fk` FOREIGN KEY (`itemDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `siteMaps_itemDesignTextId_fk` FOREIGN KEY (`itemDesignTextId`) REFERENCES `designTexts` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `siteMaps`
--

LOCK TABLES `siteMaps` WRITE;
/*!40000 ALTER TABLE `siteMaps` DISABLE KEYS */;
/*!40000 ALTER TABLE `siteMaps` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tabGroups`
--

DROP TABLE IF EXISTS `tabGroups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tabGroups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tabId` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tabGroups_tabId_fk` (`tabId`),
  CONSTRAINT `tabGroups_tabId_fk` FOREIGN KEY (`tabId`) REFERENCES `tabs` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tabGroups`
--

LOCK TABLES `tabGroups` WRITE;
/*!40000 ALTER TABLE `tabGroups` DISABLE KEYS */;
/*!40000 ALTER TABLE `tabGroups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tabInstances`
--

DROP TABLE IF EXISTS `tabInstances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tabInstances` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tabGroupId` int(11) unsigned NOT NULL,
  `textInstanceId` int(11) unsigned NOT NULL,
  `tabTemplateId` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tabInstances_tabGroupId_fk` (`tabGroupId`),
  KEY `tabInstances_textInstanceId_fk` (`textInstanceId`),
  KEY `tabInstances_tabTemplateId_fk` (`tabTemplateId`),
  CONSTRAINT `tabInstances_tabGroupId_fk` FOREIGN KEY (`tabGroupId`) REFERENCES `tabGroups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tabInstances_tabTemplateId_fk` FOREIGN KEY (`tabTemplateId`) REFERENCES `tabTemplates` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tabInstances_textInstanceId_fk` FOREIGN KEY (`textInstanceId`) REFERENCES `textInstances` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tabInstances`
--

LOCK TABLES `tabInstances` WRITE;
/*!40000 ALTER TABLE `tabInstances` DISABLE KEYS */;
/*!40000 ALTER TABLE `tabInstances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tabTemplates`
--

DROP TABLE IF EXISTS `tabTemplates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tabTemplates` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tabId` int(11) unsigned NOT NULL,
  `sort` smallint(6) NOT NULL,
  `label` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tabTemplates_tabId_fk` (`tabId`),
  KEY `tabTemplates_sort` (`sort`),
  CONSTRAINT `tabTemplates_tabId_fk` FOREIGN KEY (`tabId`) REFERENCES `tabs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tabTemplates`
--

LOCK TABLES `tabTemplates` WRITE;
/*!40000 ALTER TABLE `tabTemplates` DISABLE KEYS */;
/*!40000 ALTER TABLE `tabTemplates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tabs`
--

DROP TABLE IF EXISTS `tabs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tabs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `designTabsId` int(11) unsigned NOT NULL,
  `textId` int(11) unsigned NOT NULL,
  `isShowEmpty` tinyint(1) unsigned NOT NULL,
  `isLazyLoad` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tabs_designTabsId_fk` (`designTabsId`),
  KEY `tabs_textId_fk` (`textId`),
  CONSTRAINT `tabs_designTabsId_fk` FOREIGN KEY (`designTabsId`) REFERENCES `designTabs` (`id`),
  CONSTRAINT `tabs_textId_fk` FOREIGN KEY (`textId`) REFERENCES `texts` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tabs`
--

LOCK TABLES `tabs` WRITE;
/*!40000 ALTER TABLE `tabs` DISABLE KEYS */;
/*!40000 ALTER TABLE `tabs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `textInstanceFileMap`
--

DROP TABLE IF EXISTS `textInstanceFileMap`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `textInstanceFileMap` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `textInstanceId` int(11) unsigned NOT NULL,
  `fileId` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `textInstanceFileMap_textInstanceId_fk` (`textInstanceId`),
  KEY `textInstanceFileMap_fileId_fk` (`fileId`),
  CONSTRAINT `textInstanceFileMap_fileId_fk` FOREIGN KEY (`fileId`) REFERENCES `files` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `textInstanceFileMap_textInstanceId_fk` FOREIGN KEY (`textInstanceId`) REFERENCES `textInstances` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `textInstanceFileMap`
--

LOCK TABLES `textInstanceFileMap` WRITE;
/*!40000 ALTER TABLE `textInstanceFileMap` DISABLE KEYS */;
/*!40000 ALTER TABLE `textInstanceFileMap` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `textInstances`
--

DROP TABLE IF EXISTS `textInstances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `textInstances` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `textId` int(11) unsigned NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `textInstances_textId_fk` (`textId`),
  FULLTEXT KEY `text` (`text`),
  CONSTRAINT `textInstances_textId_fk` FOREIGN KEY (`textId`) REFERENCES `texts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `textInstances`
--

LOCK TABLES `textInstances` WRITE;
/*!40000 ALTER TABLE `textInstances` DISABLE KEYS */;
/*!40000 ALTER TABLE `textInstances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `texts`
--

DROP TABLE IF EXISTS `texts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `texts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `designTextId` int(11) unsigned NOT NULL,
  `designBlockId` int(11) unsigned NOT NULL,
  `type` tinyint(3) unsigned NOT NULL,
  `hasEditor` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `texts_designTextId_fk` (`designTextId`),
  KEY `texts_designBlockId_fk` (`designBlockId`),
  CONSTRAINT `texts_designBlockId_fk` FOREIGN KEY (`designBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `texts_designTextId_fk` FOREIGN KEY (`designTextId`) REFERENCES `designTexts` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `texts`
--

LOCK TABLES `texts` WRITE;
/*!40000 ALTER TABLE `texts` DISABLE KEYS */;
/*!40000 ALTER TABLE `texts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `userBlockGroupOperations`
--

DROP TABLE IF EXISTS `userBlockGroupOperations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userBlockGroupOperations` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(11) unsigned NOT NULL,
  `blockType` tinyint(3) unsigned NOT NULL,
  `operation` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userBlockGroupOperations_userId_fk` (`userId`),
  CONSTRAINT `userBlockGroupOperations_userId_fk` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userBlockGroupOperations`
--

LOCK TABLES `userBlockGroupOperations` WRITE;
/*!40000 ALTER TABLE `userBlockGroupOperations` DISABLE KEYS */;
/*!40000 ALTER TABLE `userBlockGroupOperations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `userBlockOperations`
--

DROP TABLE IF EXISTS `userBlockOperations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userBlockOperations` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(11) unsigned NOT NULL,
  `blockId` int(11) unsigned NOT NULL,
  `blockType` tinyint(3) unsigned NOT NULL,
  `operation` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userBlockOperations_userId_fk` (`userId`),
  KEY `userBlockOperations_blockId_fk` (`blockId`),
  CONSTRAINT `userBlockOperations_blockId_fk` FOREIGN KEY (`blockId`) REFERENCES `blocks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `userBlockOperations_userId_fk` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userBlockOperations`
--

LOCK TABLES `userBlockOperations` WRITE;
/*!40000 ALTER TABLE `userBlockOperations` DISABLE KEYS */;
/*!40000 ALTER TABLE `userBlockOperations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `userEvents`
--

DROP TABLE IF EXISTS `userEvents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userEvents` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(11) unsigned NOT NULL,
  `category` tinyint(3) unsigned NOT NULL,
  `type` tinyint(3) unsigned NOT NULL,
  `event` varchar(255) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `userEvents_userId_fk` (`userId`),
  KEY `userEvents_date` (`date`),
  CONSTRAINT `userEvents_userId_fk` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userEvents`
--

LOCK TABLES `userEvents` WRITE;
/*!40000 ALTER TABLE `userEvents` DISABLE KEYS */;
/*!40000 ALTER TABLE `userEvents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `userSectionGroupOperations`
--

DROP TABLE IF EXISTS `userSectionGroupOperations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userSectionGroupOperations` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(11) unsigned NOT NULL,
  `operation` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userSectionGroupOperations_userId_fk` (`userId`),
  CONSTRAINT `userSectionGroupOperations_userId_fk` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userSectionGroupOperations`
--

LOCK TABLES `userSectionGroupOperations` WRITE;
/*!40000 ALTER TABLE `userSectionGroupOperations` DISABLE KEYS */;
/*!40000 ALTER TABLE `userSectionGroupOperations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `userSectionOperations`
--

DROP TABLE IF EXISTS `userSectionOperations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userSectionOperations` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(11) unsigned NOT NULL,
  `sectionId` int(11) unsigned NOT NULL,
  `operation` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userSectionOperations_userId_fk` (`userId`),
  KEY `userSectionOperations_sectionId_fk` (`sectionId`),
  CONSTRAINT `userSectionOperations_sectionId_fk` FOREIGN KEY (`sectionId`) REFERENCES `sections` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `userSectionOperations_userId_fk` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userSectionOperations`
--

LOCK TABLES `userSectionOperations` WRITE;
/*!40000 ALTER TABLE `userSectionOperations` DISABLE KEYS */;
/*!40000 ALTER TABLE `userSectionOperations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `userSessions`
--

DROP TABLE IF EXISTS `userSessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userSessions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(11) unsigned NOT NULL,
  `token` char(32) NOT NULL,
  `ip` varchar(25) NOT NULL,
  `ua` varchar(255) NOT NULL,
  `lastActivity` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `userSessions_token` (`token`),
  KEY `userSessions_userId_fk` (`userId`),
  CONSTRAINT `userSessions_userId_fk` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userSessions`
--

LOCK TABLES `userSessions` WRITE;
/*!40000 ALTER TABLE `userSessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `userSessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `userSettingsOperations`
--

DROP TABLE IF EXISTS `userSettingsOperations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userSettingsOperations` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(11) unsigned NOT NULL,
  `operation` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userSettingsOperations_userId_fk` (`userId`),
  CONSTRAINT `userSettingsOperations_userId_fk` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userSettingsOperations`
--

LOCK TABLES `userSettingsOperations` WRITE;
/*!40000 ALTER TABLE `userSettingsOperations` DISABLE KEYS */;
/*!40000 ALTER TABLE `userSettingsOperations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(50) NOT NULL,
  `type` tinyint(3) unsigned NOT NULL,
  `password` char(40) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `code` varchar(25) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_login` (`login`),
  UNIQUE KEY `users_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-11-15 17:31:08
