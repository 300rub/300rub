
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
DROP TABLE IF EXISTS `blocks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blocks` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `language` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `contentType` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `contentId` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `blocks_language_contentType_contentId` (`language`,`contentType`,`contentId`),
  KEY `blocks_language_contentType` (`language`,`contentType`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `blocks` WRITE;
/*!40000 ALTER TABLE `blocks` DISABLE KEYS */;
/*!40000 ALTER TABLE `blocks` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `catalogBins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `catalogBins` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `catalogId` int(11) unsigned NOT NULL,
  `catalogInstanceId` int(11) unsigned NOT NULL,
  `count` smallint(5) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `catalogBins_catalogId_fk` (`catalogId`),
  KEY `catalogBins_catalogInstanceId_fk` (`catalogInstanceId`),
  KEY `catalogBins_status` (`status`),
  CONSTRAINT `catalogBins_catalogId_fk` FOREIGN KEY (`catalogId`) REFERENCES `catalogs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `catalogBins_catalogInstanceId_fk` FOREIGN KEY (`catalogInstanceId`) REFERENCES `catalogInstances` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `catalogBins` WRITE;
/*!40000 ALTER TABLE `catalogBins` DISABLE KEYS */;
/*!40000 ALTER TABLE `catalogBins` ENABLE KEYS */;
UNLOCK TABLES;
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

LOCK TABLES `catalogInstanceLinks` WRITE;
/*!40000 ALTER TABLE `catalogInstanceLinks` DISABLE KEYS */;
/*!40000 ALTER TABLE `catalogInstanceLinks` ENABLE KEYS */;
UNLOCK TABLES;
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
  `price` float NOT NULL DEFAULT '0',
  `oldPrice` float NOT NULL DEFAULT '0',
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

LOCK TABLES `catalogInstances` WRITE;
/*!40000 ALTER TABLE `catalogInstances` DISABLE KEYS */;
/*!40000 ALTER TABLE `catalogInstances` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `catalogMenu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `catalogMenu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parentId` int(11) unsigned DEFAULT NULL,
  `seoId` int(11) unsigned NOT NULL,
  `catalogId` int(11) unsigned NOT NULL,
  `icon` varchar(50) NOT NULL DEFAULT '',
  `subName` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `catalogMenu_parentId_fk` (`parentId`),
  KEY `catalogMenu_seoId_fk` (`seoId`),
  KEY `catalogMenu_catalogId_fk` (`catalogId`),
  CONSTRAINT `catalogMenu_catalogId_fk` FOREIGN KEY (`catalogId`) REFERENCES `catalogs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `catalogMenu_parentId_fk` FOREIGN KEY (`parentId`) REFERENCES `catalogMenu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `catalogMenu_seoId_fk` FOREIGN KEY (`seoId`) REFERENCES `seo` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `catalogMenu` WRITE;
/*!40000 ALTER TABLE `catalogMenu` DISABLE KEYS */;
/*!40000 ALTER TABLE `catalogMenu` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `catalogOrders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `catalogOrders` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `catalogBinId` int(11) unsigned NOT NULL,
  `formId` int(11) unsigned NOT NULL,
  `email` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `catalogOrders_catalogBinId_fk` (`catalogBinId`),
  KEY `catalogOrders_formId_fk` (`formId`),
  CONSTRAINT `catalogOrders_catalogBinId_fk` FOREIGN KEY (`catalogBinId`) REFERENCES `catalogBins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `catalogOrders_formId_fk` FOREIGN KEY (`formId`) REFERENCES `forms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `catalogOrders` WRITE;
/*!40000 ALTER TABLE `catalogOrders` DISABLE KEYS */;
/*!40000 ALTER TABLE `catalogOrders` ENABLE KEYS */;
UNLOCK TABLES;
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
  `hasImages` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `useAutoload` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `pageNavigationSize` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `shortCardDateType` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `fullCardDateType` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `hasRelations` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `relationsLabel` varchar(255) NOT NULL DEFAULT '',
  `hasBin` tinyint(1) unsigned NOT NULL DEFAULT '0',
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

LOCK TABLES `catalogs` WRITE;
/*!40000 ALTER TABLE `catalogs` DISABLE KEYS */;
/*!40000 ALTER TABLE `catalogs` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `designBlocks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `designBlocks` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `marginTop` smallint(6) NOT NULL DEFAULT '0',
  `marginTopHover` smallint(6) NOT NULL DEFAULT '0',
  `marginRight` smallint(6) NOT NULL DEFAULT '0',
  `marginRightHover` smallint(6) NOT NULL DEFAULT '0',
  `marginBottom` smallint(6) NOT NULL DEFAULT '0',
  `marginBottomHover` smallint(6) NOT NULL DEFAULT '0',
  `marginLeft` smallint(6) NOT NULL DEFAULT '0',
  `marginLeftHover` smallint(6) NOT NULL DEFAULT '0',
  `hasMarginHover` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `hasMarginAnimation` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `paddingTop` smallint(5) unsigned NOT NULL DEFAULT '0',
  `paddingTopHover` smallint(5) unsigned NOT NULL DEFAULT '0',
  `paddingRight` smallint(5) unsigned NOT NULL DEFAULT '0',
  `paddingRightHover` smallint(5) unsigned NOT NULL DEFAULT '0',
  `paddingBottom` smallint(5) unsigned NOT NULL DEFAULT '0',
  `paddingBottomHover` smallint(5) unsigned NOT NULL DEFAULT '0',
  `paddingLeft` smallint(5) unsigned NOT NULL DEFAULT '0',
  `paddingLeftHover` smallint(5) unsigned NOT NULL DEFAULT '0',
  `hasPaddingHover` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `hasPaddingAnimation` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `backgroundColorFrom` varchar(25) NOT NULL DEFAULT '',
  `backgroundColorFromHover` varchar(25) NOT NULL DEFAULT '',
  `backgroundColorTo` varchar(25) NOT NULL DEFAULT '',
  `backgroundColorToHover` varchar(25) NOT NULL DEFAULT '',
  `gradientDirection` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `gradientDirectionHover` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `hasBackgroundGradient` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `hasBackgroundHover` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `hasBackgroundAnimation` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `imageInstanceId` int(11) unsigned DEFAULT NULL,
  `backgroundPosition` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `backgroundRepeat` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `isBackgroundCover` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `borderTopLeftRadius` smallint(5) unsigned NOT NULL DEFAULT '0',
  `borderTopLeftRadiusHover` smallint(5) unsigned NOT NULL DEFAULT '0',
  `borderTopRightRadius` smallint(5) unsigned NOT NULL DEFAULT '0',
  `borderTopRightRadiusHover` smallint(5) unsigned NOT NULL DEFAULT '0',
  `borderBottomRightRadius` smallint(5) unsigned NOT NULL DEFAULT '0',
  `borderBottomRightRadiusHover` smallint(5) unsigned NOT NULL DEFAULT '0',
  `borderBottomLeftRadius` smallint(5) unsigned NOT NULL DEFAULT '0',
  `borderBottomLeftRadiusHover` smallint(5) unsigned NOT NULL DEFAULT '0',
  `borderTopWidth` smallint(5) unsigned NOT NULL DEFAULT '0',
  `borderTopWidthHover` smallint(5) unsigned NOT NULL DEFAULT '0',
  `borderRightWidth` smallint(5) unsigned NOT NULL DEFAULT '0',
  `borderRightWidthHover` smallint(5) unsigned NOT NULL DEFAULT '0',
  `borderBottomWidth` smallint(5) unsigned NOT NULL DEFAULT '0',
  `borderBottomWidthHover` smallint(5) unsigned NOT NULL DEFAULT '0',
  `borderLeftWidth` smallint(5) unsigned NOT NULL DEFAULT '0',
  `borderLeftWidthHover` smallint(5) unsigned NOT NULL DEFAULT '0',
  `borderStyle` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `borderStyleHover` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `borderColor` varchar(25) NOT NULL DEFAULT '',
  `borderColorHover` varchar(25) NOT NULL DEFAULT '',
  `hasBorderHover` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `hasBorderAnimation` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `width` smallint(5) unsigned NOT NULL DEFAULT '0',
  `height` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `designBlocks_imageInstanceId_fk` (`imageInstanceId`),
  CONSTRAINT `designBlocks_imageInstanceId_fk` FOREIGN KEY (`imageInstanceId`) REFERENCES `imageInstances` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `designBlocks` WRITE;
/*!40000 ALTER TABLE `designBlocks` DISABLE KEYS */;
/*!40000 ALTER TABLE `designBlocks` ENABLE KEYS */;
UNLOCK TABLES;
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
  `shortCardViewType` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `fullCardImagesPosition` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `fullCardDatePosition` tinyint(3) unsigned NOT NULL DEFAULT '0',
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

LOCK TABLES `designCatalogs` WRITE;
/*!40000 ALTER TABLE `designCatalogs` DISABLE KEYS */;
/*!40000 ALTER TABLE `designCatalogs` ENABLE KEYS */;
UNLOCK TABLES;
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

LOCK TABLES `designFields` WRITE;
/*!40000 ALTER TABLE `designFields` DISABLE KEYS */;
/*!40000 ALTER TABLE `designFields` ENABLE KEYS */;
UNLOCK TABLES;
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
  `submitIcon` varchar(50) NOT NULL DEFAULT '',
  `submitIconPosition` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `submitAlignment` tinyint(3) unsigned NOT NULL DEFAULT '0',
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

LOCK TABLES `designForms` WRITE;
/*!40000 ALTER TABLE `designForms` DISABLE KEYS */;
/*!40000 ALTER TABLE `designForms` ENABLE KEYS */;
UNLOCK TABLES;
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

LOCK TABLES `designImageAlbums` WRITE;
/*!40000 ALTER TABLE `designImageAlbums` DISABLE KEYS */;
/*!40000 ALTER TABLE `designImageAlbums` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `designImageSimple`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `designImageSimple` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `containerDesignBlockId` int(11) unsigned NOT NULL,
  `imageDesignBlockId` int(11) unsigned NOT NULL,
  `descriptionDesignBlockId` int(11) unsigned NOT NULL,
  `descriptionDesignTextId` int(11) unsigned NOT NULL,
  `useDescription` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `alignment` tinyint(3) unsigned NOT NULL DEFAULT '0',
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

LOCK TABLES `designImageSimple` WRITE;
/*!40000 ALTER TABLE `designImageSimple` DISABLE KEYS */;
/*!40000 ALTER TABLE `designImageSimple` ENABLE KEYS */;
UNLOCK TABLES;
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
  `isFullWidth` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `hasDescription` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `effect` text NOT NULL,
  `hasAutoPlay` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `playSpeed` tinyint(3) unsigned NOT NULL DEFAULT '0',
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

LOCK TABLES `designImageSliders` WRITE;
/*!40000 ALTER TABLE `designImageSliders` DISABLE KEYS */;
/*!40000 ALTER TABLE `designImageSliders` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `designImageZooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `designImageZooms` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `designBlockId` int(11) unsigned NOT NULL,
  `effect` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `designImageZooms_designBlockId_fk` (`designBlockId`),
  CONSTRAINT `designImageZooms_designBlockId_fk` FOREIGN KEY (`designBlockId`) REFERENCES `designBlocks` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `designImageZooms` WRITE;
/*!40000 ALTER TABLE `designImageZooms` DISABLE KEYS */;
/*!40000 ALTER TABLE `designImageZooms` ENABLE KEYS */;
UNLOCK TABLES;
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

LOCK TABLES `designMenu` WRITE;
/*!40000 ALTER TABLE `designMenu` DISABLE KEYS */;
/*!40000 ALTER TABLE `designMenu` ENABLE KEYS */;
UNLOCK TABLES;
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
  `viewType` tinyint(3) unsigned NOT NULL DEFAULT '0',
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

LOCK TABLES `designRecordClones` WRITE;
/*!40000 ALTER TABLE `designRecordClones` DISABLE KEYS */;
/*!40000 ALTER TABLE `designRecordClones` ENABLE KEYS */;
UNLOCK TABLES;
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
  `shortCardViewType` tinyint(3) unsigned NOT NULL DEFAULT '0',
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

LOCK TABLES `designRecords` WRITE;
/*!40000 ALTER TABLE `designRecords` DISABLE KEYS */;
/*!40000 ALTER TABLE `designRecords` ENABLE KEYS */;
UNLOCK TABLES;
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

LOCK TABLES `designSearch` WRITE;
/*!40000 ALTER TABLE `designSearch` DISABLE KEYS */;
/*!40000 ALTER TABLE `designSearch` ENABLE KEYS */;
UNLOCK TABLES;
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

LOCK TABLES `designTabs` WRITE;
/*!40000 ALTER TABLE `designTabs` DISABLE KEYS */;
/*!40000 ALTER TABLE `designTabs` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `designTexts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `designTexts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `size` smallint(5) unsigned NOT NULL DEFAULT '0',
  `sizeHover` smallint(5) unsigned NOT NULL DEFAULT '0',
  `family` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `color` varchar(25) NOT NULL DEFAULT '',
  `colorHover` varchar(25) NOT NULL DEFAULT '',
  `isItalic` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `isItalicHover` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `isBold` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `isBoldHover` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `align` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `decoration` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `decorationHover` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `transform` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `transformHover` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `letterSpacing` smallint(6) NOT NULL DEFAULT '0',
  `letterSpacingHover` smallint(6) NOT NULL DEFAULT '0',
  `lineHeight` smallint(5) unsigned NOT NULL DEFAULT '0',
  `lineHeightHover` smallint(6) NOT NULL DEFAULT '0',
  `hasHover` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `designTexts` WRITE;
/*!40000 ALTER TABLE `designTexts` DISABLE KEYS */;
/*!40000 ALTER TABLE `designTexts` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `feedback`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `feedback` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `formId` int(11) unsigned NOT NULL,
  `subjectFormInstanceId` int(11) unsigned NOT NULL,
  `subjectText` varchar(255) NOT NULL DEFAULT '',
  `host` varchar(255) NOT NULL DEFAULT '',
  `port` smallint(5) unsigned NOT NULL DEFAULT '0',
  `type` varchar(25) NOT NULL DEFAULT '',
  `user` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `feedback_formId_fk` (`formId`),
  KEY `feedback_subjectFormInstanceId_fk` (`subjectFormInstanceId`),
  CONSTRAINT `feedback_formId_fk` FOREIGN KEY (`formId`) REFERENCES `forms` (`id`),
  CONSTRAINT `feedback_subjectFormInstanceId_fk` FOREIGN KEY (`subjectFormInstanceId`) REFERENCES `formInstances` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `feedback` WRITE;
/*!40000 ALTER TABLE `feedback` DISABLE KEYS */;
/*!40000 ALTER TABLE `feedback` ENABLE KEYS */;
UNLOCK TABLES;
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

LOCK TABLES `fieldGroups` WRITE;
/*!40000 ALTER TABLE `fieldGroups` DISABLE KEYS */;
/*!40000 ALTER TABLE `fieldGroups` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `fieldInstances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fieldInstances` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fieldGroupId` int(11) unsigned NOT NULL,
  `fieldTemplateId` int(11) unsigned NOT NULL,
  `value` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `fieldInstances_fieldGroupId_fk` (`fieldGroupId`),
  KEY `fieldInstances_fieldTemplateId_fk` (`fieldTemplateId`),
  KEY `fieldInstances_value` (`value`),
  CONSTRAINT `fieldInstances_fieldGroupId_fk` FOREIGN KEY (`fieldGroupId`) REFERENCES `fieldGroups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fieldInstances_fieldTemplateId_fk` FOREIGN KEY (`fieldTemplateId`) REFERENCES `fieldTemplates` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `fieldInstances` WRITE;
/*!40000 ALTER TABLE `fieldInstances` DISABLE KEYS */;
/*!40000 ALTER TABLE `fieldInstances` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `fieldListValues`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fieldListValues` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fieldTemplateId` int(11) unsigned NOT NULL,
  `value` varchar(255) NOT NULL DEFAULT '',
  `sort` smallint(6) NOT NULL DEFAULT '0',
  `isChecked` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fieldListValues_fieldTemplateId_fk` (`fieldTemplateId`),
  KEY `fieldListValues_sort` (`sort`),
  CONSTRAINT `fieldListValues_fieldTemplateId_fk` FOREIGN KEY (`fieldTemplateId`) REFERENCES `fieldTemplates` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `fieldListValues` WRITE;
/*!40000 ALTER TABLE `fieldListValues` DISABLE KEYS */;
/*!40000 ALTER TABLE `fieldListValues` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `fieldTemplates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fieldTemplates` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fieldId` int(11) unsigned NOT NULL,
  `sort` smallint(6) NOT NULL DEFAULT '0',
  `label` varchar(255) NOT NULL DEFAULT '',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `validationType` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `isHideForShortCard` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `isShowEmpty` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fieldTemplates_fieldId_fk` (`fieldId`),
  KEY `fieldTemplates_sort` (`sort`),
  CONSTRAINT `fieldTemplates_fieldId_fk` FOREIGN KEY (`fieldId`) REFERENCES `fields` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `fieldTemplates` WRITE;
/*!40000 ALTER TABLE `fieldTemplates` DISABLE KEYS */;
/*!40000 ALTER TABLE `fieldTemplates` ENABLE KEYS */;
UNLOCK TABLES;
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

LOCK TABLES `fields` WRITE;
/*!40000 ALTER TABLE `fields` DISABLE KEYS */;
/*!40000 ALTER TABLE `fields` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `files` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `originalName` varchar(255) NOT NULL DEFAULT '',
  `type` varchar(50) NOT NULL DEFAULT '',
  `size` int(10) unsigned NOT NULL DEFAULT '0',
  `uniqueName` varchar(25) NOT NULL DEFAULT '',
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `isUsed` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `files_uniqueName` (`uniqueName`),
  KEY `files_date_isUsed` (`date`,`isUsed`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `files` WRITE;
/*!40000 ALTER TABLE `files` DISABLE KEYS */;
/*!40000 ALTER TABLE `files` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `formInstances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `formInstances` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `formId` int(11) unsigned NOT NULL,
  `sort` smallint(6) NOT NULL DEFAULT '0',
  `label` varchar(255) NOT NULL DEFAULT '',
  `isRequired` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `validationType` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `formInstances_formId_fk` (`formId`),
  KEY `formInstances_sort` (`sort`),
  CONSTRAINT `formInstances_formId_fk` FOREIGN KEY (`formId`) REFERENCES `forms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `formInstances` WRITE;
/*!40000 ALTER TABLE `formInstances` DISABLE KEYS */;
/*!40000 ALTER TABLE `formInstances` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `formListValues`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `formListValues` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `formInstanceId` int(11) unsigned NOT NULL,
  `sort` smallint(6) NOT NULL DEFAULT '0',
  `value` varchar(255) NOT NULL DEFAULT '',
  `isChecked` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `formListValues_formInstanceId_fk` (`formInstanceId`),
  KEY `formListValues_sort` (`sort`),
  CONSTRAINT `formListValues_formInstanceId_fk` FOREIGN KEY (`formInstanceId`) REFERENCES `formInstances` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `formListValues` WRITE;
/*!40000 ALTER TABLE `formListValues` DISABLE KEYS */;
/*!40000 ALTER TABLE `formListValues` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `forms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `forms` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `designFormId` int(11) unsigned NOT NULL,
  `hasLabel` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `successText` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `forms_designFormId_fk` (`designFormId`),
  CONSTRAINT `forms_designFormId_fk` FOREIGN KEY (`designFormId`) REFERENCES `designForms` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `forms` WRITE;
/*!40000 ALTER TABLE `forms` DISABLE KEYS */;
/*!40000 ALTER TABLE `forms` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `gridLines`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gridLines` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sectionId` int(11) unsigned NOT NULL,
  `outsideDesignId` int(11) unsigned NOT NULL,
  `insideDesignId` int(11) unsigned NOT NULL,
  `sort` smallint(6) NOT NULL DEFAULT '0',
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

LOCK TABLES `gridLines` WRITE;
/*!40000 ALTER TABLE `gridLines` DISABLE KEYS */;
/*!40000 ALTER TABLE `gridLines` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `grids`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grids` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `gridLineId` int(11) unsigned NOT NULL,
  `blockId` int(11) unsigned NOT NULL,
  `x` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `y` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `width` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `grids_gridLineId_fk` (`gridLineId`),
  KEY `grids_blockId_fk` (`blockId`),
  CONSTRAINT `grids_blockId_fk` FOREIGN KEY (`blockId`) REFERENCES `blocks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `grids_gridLineId_fk` FOREIGN KEY (`gridLineId`) REFERENCES `gridLines` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `grids` WRITE;
/*!40000 ALTER TABLE `grids` DISABLE KEYS */;
/*!40000 ALTER TABLE `grids` ENABLE KEYS */;
UNLOCK TABLES;
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
  `sort` smallint(6) NOT NULL DEFAULT '0',
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

LOCK TABLES `imageGroups` WRITE;
/*!40000 ALTER TABLE `imageGroups` DISABLE KEYS */;
/*!40000 ALTER TABLE `imageGroups` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `imageInstances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `imageInstances` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `imageGroupId` int(11) unsigned DEFAULT NULL,
  `originalFileId` int(11) unsigned NOT NULL,
  `viewFileId` int(11) unsigned NOT NULL,
  `thumbFileId` int(11) unsigned NOT NULL,
  `isCover` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `sort` smallint(6) NOT NULL DEFAULT '0',
  `alt` text NOT NULL,
  `link` text NOT NULL,
  `width` smallint(5) unsigned NOT NULL DEFAULT '0',
  `height` smallint(5) unsigned NOT NULL DEFAULT '0',
  `viewX` smallint(5) unsigned NOT NULL DEFAULT '0',
  `viewY` smallint(5) unsigned NOT NULL DEFAULT '0',
  `viewWidth` smallint(5) unsigned NOT NULL DEFAULT '0',
  `viewHeight` smallint(5) unsigned NOT NULL DEFAULT '0',
  `viewAngle` smallint(6) NOT NULL DEFAULT '0',
  `viewFlip` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `thumbX` smallint(5) unsigned NOT NULL DEFAULT '0',
  `thumbY` smallint(5) unsigned NOT NULL DEFAULT '0',
  `thumbWidth` smallint(5) unsigned NOT NULL DEFAULT '0',
  `thumbHeight` smallint(5) unsigned NOT NULL DEFAULT '0',
  `thumbAngle` smallint(6) NOT NULL DEFAULT '0',
  `thumbFlip` tinyint(3) unsigned NOT NULL DEFAULT '0',
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

LOCK TABLES `imageInstances` WRITE;
/*!40000 ALTER TABLE `imageInstances` DISABLE KEYS */;
/*!40000 ALTER TABLE `imageInstances` ENABLE KEYS */;
UNLOCK TABLES;
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
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `autoCropType` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `cropX` int(10) unsigned NOT NULL DEFAULT '0',
  `cropY` int(10) unsigned NOT NULL DEFAULT '0',
  `thumbAutoCropType` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `thumbCropX` smallint(5) unsigned NOT NULL DEFAULT '0',
  `thumbCropY` smallint(5) unsigned NOT NULL DEFAULT '0',
  `useAlbums` tinyint(1) unsigned NOT NULL DEFAULT '0',
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

LOCK TABLES `images` WRITE;
/*!40000 ALTER TABLE `images` DISABLE KEYS */;
/*!40000 ALTER TABLE `images` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `designMenuId` int(11) unsigned NOT NULL,
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `menu_designMenuId_fk` (`designMenuId`),
  CONSTRAINT `menu_designMenuId_fk` FOREIGN KEY (`designMenuId`) REFERENCES `designMenu` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `menu` WRITE;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `menuInstances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menuInstances` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `menuId` int(11) unsigned NOT NULL,
  `parentId` int(11) unsigned DEFAULT NULL,
  `sectionId` int(11) unsigned DEFAULT NULL,
  `icon` varchar(50) NOT NULL DEFAULT '',
  `sort` smallint(6) NOT NULL DEFAULT '0',
  `staticName` varchar(255) NOT NULL DEFAULT '',
  `staticUrl` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `menuInstances_menuId_fk` (`menuId`),
  KEY `menuInstances_parentId_fk` (`parentId`),
  KEY `menuInstances_sectionId_fk` (`sectionId`),
  CONSTRAINT `menuInstances_menuId_fk` FOREIGN KEY (`menuId`) REFERENCES `menu` (`id`),
  CONSTRAINT `menuInstances_parentId_fk` FOREIGN KEY (`parentId`) REFERENCES `menuInstances` (`id`),
  CONSTRAINT `menuInstances_sectionId_fk` FOREIGN KEY (`sectionId`) REFERENCES `sections` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `menuInstances` WRITE;
/*!40000 ALTER TABLE `menuInstances` DISABLE KEYS */;
/*!40000 ALTER TABLE `menuInstances` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(100) NOT NULL DEFAULT '',
  `down` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'M160302000005Blocks','DROP TABLE IF EXISTS blocks;'),(2,'M160302000010DesignBlocks','DROP TABLE IF EXISTS designBlocks;'),(3,'M160302000020DesignTexts','DROP TABLE IF EXISTS designTexts;'),(4,'M160303000000Seo','DROP TABLE IF EXISTS seo;'),(5,'M160305000000Sections','DROP TABLE IF EXISTS sections;'),(6,'M160307000000Users','DROP TABLE IF EXISTS userEvents; DROP TABLE IF EXISTS userSettingsOperations; DROP TABLE IF EXISTS userSectionGroupOperations; DROP TABLE IF EXISTS userSectionOperations; DROP TABLE IF EXISTS userBlockGroupOperations; DROP TABLE IF EXISTS userBlockOperations; DROP TABLE IF EXISTS userSessions; DROP TABLE IF EXISTS users;'),(7,'M160308000000Files','DROP TABLE IF EXISTS files;'),(8,'M160309000000Texts','DROP TABLE IF EXISTS textInstanceFileMap; DROP TABLE IF EXISTS textInstances; DROP TABLE IF EXISTS texts;'),(9,'M160311000000Grids','DROP TABLE IF EXISTS grids; DROP TABLE IF EXISTS gridLines;'),(10,'M160317000000Images','ALTER TABLE designBlocks DROP FOREIGN KEY designBlocks_imageInstanceId_fk; DROP TABLE IF EXISTS imageInstances; DROP TABLE IF EXISTS imageGroups; DROP TABLE IF EXISTS images; DROP TABLE IF EXISTS designImageSliders; DROP TABLE IF EXISTS designImageZooms; DROP TABLE IF EXISTS designImageSimple; DROP TABLE IF EXISTS designImageAlbums;'),(11,'M160317001000Forms','DROP TABLE IF EXISTS formListValues; DROP TABLE IF EXISTS formInstances; DROP TABLE IF EXISTS forms; DROP TABLE IF EXISTS designForms;'),(12,'M160321000000Feedback','DROP TABLE IF EXISTS feedback;'),(13,'M160321000100Records','DROP TABLE IF EXISTS recordInstances; DROP TABLE IF EXISTS recordClones; DROP TABLE IF EXISTS designRecordClones; DROP TABLE IF EXISTS records; DROP TABLE IF EXISTS designRecords;'),(14,'M160321000200Menu','DROP TABLE IF EXISTS menuInstances; DROP TABLE IF EXISTS menu; DROP TABLE IF EXISTS designMenu;'),(15,'M160321000300SiteMaps','DROP TABLE IF EXISTS siteMaps;'),(16,'M160321000400Search','DROP TABLE IF EXISTS searchQueries; DROP TABLE IF EXISTS search; DROP TABLE IF EXISTS designSearch;'),(17,'M160321000500Fields','DROP TABLE IF EXISTS fieldListValues; DROP TABLE IF EXISTS fieldInstances; DROP TABLE IF EXISTS fieldGroups; DROP TABLE IF EXISTS fieldTemplates; DROP TABLE IF EXISTS fields; DROP TABLE IF EXISTS designFields;'),(18,'M160321000550Tabs','DROP TABLE IF EXISTS tabInstances; DROP TABLE IF EXISTS tabGroups; DROP TABLE IF EXISTS tabTemplates; DROP TABLE IF EXISTS tabs; DROP TABLE IF EXISTS designTabs;'),(19,'M160321000700Catalogs','DROP TABLE IF EXISTS catalogOrders; DROP TABLE IF EXISTS catalogBins; DROP TABLE IF EXISTS catalogInstanceLinks; DROP TABLE IF EXISTS catalogInstances; DROP TABLE IF EXISTS catalogMenu; DROP TABLE IF EXISTS catalogs; DROP TABLE IF EXISTS designCatalogs;'),(20,'M160321000800Settings','DROP TABLE IF EXISTS settings;');
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `recordClones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recordClones` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `recordId` int(11) unsigned NOT NULL,
  `coverImageId` int(11) unsigned NOT NULL,
  `descriptionTextId` int(11) unsigned NOT NULL,
  `designRecordCloneId` int(11) unsigned NOT NULL,
  `hasCover` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `hasCoverZoom` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `hasDescription` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `dateType` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `maxCount` tinyint(3) unsigned NOT NULL DEFAULT '0',
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

LOCK TABLES `recordClones` WRITE;
/*!40000 ALTER TABLE `recordClones` DISABLE KEYS */;
/*!40000 ALTER TABLE `recordClones` ENABLE KEYS */;
UNLOCK TABLES;
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
  `sort` smallint(6) NOT NULL DEFAULT '0',
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

LOCK TABLES `recordInstances` WRITE;
/*!40000 ALTER TABLE `recordInstances` DISABLE KEYS */;
/*!40000 ALTER TABLE `recordInstances` ENABLE KEYS */;
UNLOCK TABLES;
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
  `hasCover` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `hasImages` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `hasCoverZoom` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `hasDescription` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `useAutoload` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `pageNavigationSize` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `shortCardDateType` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `fullCardDateType` tinyint(3) unsigned NOT NULL DEFAULT '0',
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

LOCK TABLES `records` WRITE;
/*!40000 ALTER TABLE `records` DISABLE KEYS */;
/*!40000 ALTER TABLE `records` ENABLE KEYS */;
UNLOCK TABLES;
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

LOCK TABLES `search` WRITE;
/*!40000 ALTER TABLE `search` DISABLE KEYS */;
/*!40000 ALTER TABLE `search` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `searchQueries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `searchQueries` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `searchId` int(11) unsigned NOT NULL,
  `text` varchar(255) NOT NULL DEFAULT '',
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(25) NOT NULL DEFAULT '',
  `ua` varchar(255) NOT NULL DEFAULT '',
  `uri` varchar(255) NOT NULL DEFAULT '',
  `ref` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `searchQueries_searchId_fk` (`searchId`),
  CONSTRAINT `searchQueries_searchId_fk` FOREIGN KEY (`searchId`) REFERENCES `search` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `searchQueries` WRITE;
/*!40000 ALTER TABLE `searchQueries` DISABLE KEYS */;
/*!40000 ALTER TABLE `searchQueries` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `sections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sections` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `seoId` int(11) unsigned NOT NULL,
  `designBlockId` int(11) unsigned NOT NULL,
  `language` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `padding` int(10) unsigned NOT NULL DEFAULT '0',
  `isMain` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `isPublished` tinyint(1) unsigned NOT NULL DEFAULT '0',
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

LOCK TABLES `sections` WRITE;
/*!40000 ALTER TABLE `sections` DISABLE KEYS */;
/*!40000 ALTER TABLE `sections` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `seo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `seo` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `title` varchar(100) NOT NULL DEFAULT '',
  `keywords` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `seo_name` (`name`),
  KEY `seo_alias` (`alias`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `seo` WRITE;
/*!40000 ALTER TABLE `seo` DISABLE KEYS */;
/*!40000 ALTER TABLE `seo` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(25) NOT NULL DEFAULT '',
  `value` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `siteMaps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `siteMaps` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `containerDesignBlockId` int(11) unsigned NOT NULL,
  `itemDesignBlockId` int(11) unsigned NOT NULL,
  `itemDesignTextId` int(11) unsigned NOT NULL,
  `style` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `siteMaps_containerDesignBlockId_fk` (`containerDesignBlockId`),
  KEY `siteMaps_itemDesignBlockId_fk` (`itemDesignBlockId`),
  KEY `siteMaps_itemDesignTextId_fk` (`itemDesignTextId`),
  CONSTRAINT `siteMaps_containerDesignBlockId_fk` FOREIGN KEY (`containerDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `siteMaps_itemDesignBlockId_fk` FOREIGN KEY (`itemDesignBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `siteMaps_itemDesignTextId_fk` FOREIGN KEY (`itemDesignTextId`) REFERENCES `designTexts` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `siteMaps` WRITE;
/*!40000 ALTER TABLE `siteMaps` DISABLE KEYS */;
/*!40000 ALTER TABLE `siteMaps` ENABLE KEYS */;
UNLOCK TABLES;
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

LOCK TABLES `tabGroups` WRITE;
/*!40000 ALTER TABLE `tabGroups` DISABLE KEYS */;
/*!40000 ALTER TABLE `tabGroups` ENABLE KEYS */;
UNLOCK TABLES;
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

LOCK TABLES `tabInstances` WRITE;
/*!40000 ALTER TABLE `tabInstances` DISABLE KEYS */;
/*!40000 ALTER TABLE `tabInstances` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `tabTemplates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tabTemplates` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tabId` int(11) unsigned NOT NULL,
  `sort` smallint(6) NOT NULL DEFAULT '0',
  `label` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `tabTemplates_tabId_fk` (`tabId`),
  KEY `tabTemplates_sort` (`sort`),
  CONSTRAINT `tabTemplates_tabId_fk` FOREIGN KEY (`tabId`) REFERENCES `tabs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `tabTemplates` WRITE;
/*!40000 ALTER TABLE `tabTemplates` DISABLE KEYS */;
/*!40000 ALTER TABLE `tabTemplates` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `tabs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tabs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `designTabsId` int(11) unsigned NOT NULL,
  `textId` int(11) unsigned NOT NULL,
  `isShowEmpty` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `isLazyLoad` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `tabs_designTabsId_fk` (`designTabsId`),
  KEY `tabs_textId_fk` (`textId`),
  CONSTRAINT `tabs_designTabsId_fk` FOREIGN KEY (`designTabsId`) REFERENCES `designTabs` (`id`),
  CONSTRAINT `tabs_textId_fk` FOREIGN KEY (`textId`) REFERENCES `texts` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `tabs` WRITE;
/*!40000 ALTER TABLE `tabs` DISABLE KEYS */;
/*!40000 ALTER TABLE `tabs` ENABLE KEYS */;
UNLOCK TABLES;
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

LOCK TABLES `textInstanceFileMap` WRITE;
/*!40000 ALTER TABLE `textInstanceFileMap` DISABLE KEYS */;
/*!40000 ALTER TABLE `textInstanceFileMap` ENABLE KEYS */;
UNLOCK TABLES;
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

LOCK TABLES `textInstances` WRITE;
/*!40000 ALTER TABLE `textInstances` DISABLE KEYS */;
/*!40000 ALTER TABLE `textInstances` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `texts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `texts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `designTextId` int(11) unsigned NOT NULL,
  `designBlockId` int(11) unsigned NOT NULL,
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `hasEditor` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `texts_designTextId_fk` (`designTextId`),
  KEY `texts_designBlockId_fk` (`designBlockId`),
  CONSTRAINT `texts_designBlockId_fk` FOREIGN KEY (`designBlockId`) REFERENCES `designBlocks` (`id`),
  CONSTRAINT `texts_designTextId_fk` FOREIGN KEY (`designTextId`) REFERENCES `designTexts` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `texts` WRITE;
/*!40000 ALTER TABLE `texts` DISABLE KEYS */;
/*!40000 ALTER TABLE `texts` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `userBlockGroupOperations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userBlockGroupOperations` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(11) unsigned NOT NULL,
  `blockType` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `operation` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `userBlockGroupOperations_userId_fk` (`userId`),
  CONSTRAINT `userBlockGroupOperations_userId_fk` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `userBlockGroupOperations` WRITE;
/*!40000 ALTER TABLE `userBlockGroupOperations` DISABLE KEYS */;
/*!40000 ALTER TABLE `userBlockGroupOperations` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `userBlockOperations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userBlockOperations` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(11) unsigned NOT NULL,
  `blockId` int(11) unsigned NOT NULL,
  `blockType` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `operation` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `userBlockOperations_userId_fk` (`userId`),
  KEY `userBlockOperations_blockId_fk` (`blockId`),
  CONSTRAINT `userBlockOperations_blockId_fk` FOREIGN KEY (`blockId`) REFERENCES `blocks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `userBlockOperations_userId_fk` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `userBlockOperations` WRITE;
/*!40000 ALTER TABLE `userBlockOperations` DISABLE KEYS */;
/*!40000 ALTER TABLE `userBlockOperations` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `userEvents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userEvents` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(11) unsigned NOT NULL,
  `category` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `event` varchar(255) NOT NULL DEFAULT '',
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `userEvents_userId_fk` (`userId`),
  KEY `userEvents_date` (`date`),
  CONSTRAINT `userEvents_userId_fk` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `userEvents` WRITE;
/*!40000 ALTER TABLE `userEvents` DISABLE KEYS */;
/*!40000 ALTER TABLE `userEvents` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `userSectionGroupOperations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userSectionGroupOperations` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(11) unsigned NOT NULL,
  `operation` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `userSectionGroupOperations_userId_fk` (`userId`),
  CONSTRAINT `userSectionGroupOperations_userId_fk` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `userSectionGroupOperations` WRITE;
/*!40000 ALTER TABLE `userSectionGroupOperations` DISABLE KEYS */;
/*!40000 ALTER TABLE `userSectionGroupOperations` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `userSectionOperations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userSectionOperations` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(11) unsigned NOT NULL,
  `sectionId` int(11) unsigned NOT NULL,
  `operation` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `userSectionOperations_userId_fk` (`userId`),
  KEY `userSectionOperations_sectionId_fk` (`sectionId`),
  CONSTRAINT `userSectionOperations_sectionId_fk` FOREIGN KEY (`sectionId`) REFERENCES `sections` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `userSectionOperations_userId_fk` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `userSectionOperations` WRITE;
/*!40000 ALTER TABLE `userSectionOperations` DISABLE KEYS */;
/*!40000 ALTER TABLE `userSectionOperations` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `userSessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userSessions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(11) unsigned NOT NULL,
  `token` char(32) NOT NULL DEFAULT '',
  `ip` varchar(25) NOT NULL DEFAULT '',
  `ua` varchar(255) NOT NULL DEFAULT '',
  `lastActivity` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `userSessions_token` (`token`),
  KEY `userSessions_userId_fk` (`userId`),
  CONSTRAINT `userSessions_userId_fk` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `userSessions` WRITE;
/*!40000 ALTER TABLE `userSessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `userSessions` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `userSettingsOperations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userSettingsOperations` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(11) unsigned NOT NULL,
  `operation` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `userSettingsOperations_userId_fk` (`userId`),
  CONSTRAINT `userSettingsOperations_userId_fk` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `userSettingsOperations` WRITE;
/*!40000 ALTER TABLE `userSettingsOperations` DISABLE KEYS */;
/*!40000 ALTER TABLE `userSettingsOperations` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(50) NOT NULL DEFAULT '',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `password` char(40) NOT NULL DEFAULT '',
  `name` varchar(100) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `code` varchar(25) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_login` (`login`),
  UNIQUE KEY `users_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

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

