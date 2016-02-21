SET FOREIGN_KEY_CHECKS = 1;

--
-- Table structure for table `administrator`
--

DROP TABLE IF EXISTS `administrator`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `administrator` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(40) NOT NULL,
  `email` varchar(50) NOT NULL,
  `sex` enum('M','F') NOT NULL,
  `super_admin_flag` tinyint(1) NOT NULL DEFAULT '0',
  `active_flag` tinyint(1) DEFAULT '1',
  `creation_date` datetime DEFAULT '0000-00-00 00:00:00',
  `last_update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `avatar` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='Administrator Table';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `administrator`
--

LOCK TABLES `administrator` WRITE;
/*!40000 ALTER TABLE `administrator` DISABLE KEYS */;
INSERT INTO `administrator` VALUES (1,'Gonçalo da Costa Ferraria','gcferraria','756624085a54da7f45daf8113008f3262f826c54','gferraria@gmail.com','M',1,1,'2012-04-27 00:00:00','2013-03-22 08:42:52',NULL);
/*!40000 ALTER TABLE `administrator` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `administrator_session`
--

DROP TABLE IF EXISTS `administrator_session`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `administrator_session` (
  `session_id` varchar(32) NOT NULL,
  `administrator_id` int(11) NOT NULL,
  `creation_date` datetime NOT NULL,
  `user_agent` varchar(120) DEFAULT NULL,
  `ip_address` varchar(16) DEFAULT NULL,
  `browser` varchar(255) DEFAULT NULL,
  `operating_system` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`session_id`,`administrator_id`),
  UNIQUE KEY `uk_administrator_session` (`session_id`,`administrator_id`),
  KEY `fk_administrator_session` (`administrator_id`),
  CONSTRAINT `fk_administrator_session` FOREIGN KEY (`administrator_id`) REFERENCES `administrator` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Administrator Session Table';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `name` varchar(80) DEFAULT NULL,
  `uriname` varchar(80) DEFAULT NULL,
  `uripath` varchar(255) NOT NULL,
  `weight` int(11) DEFAULT '0',
  `publish_flag` tinyint(1) DEFAULT '1',
  `listed` tinyint(1) DEFAULT '0',
  `exposed` tinyint(1) NOT NULL DEFAULT '1',
  `creation_date` datetime DEFAULT '0000-00-00 00:00:00',
  `last_update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `description` text NOT NULL,
  `creator_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_uriname` (`uriname`,`parent_id`),
  UNIQUE KEY `uk_category_parent` (`id`,`parent_id`),
  KEY `fk_category_category` (`parent_id`),
  KEY `idx_uripath_publish` (`uripath`,`publish_flag`),
  CONSTRAINT `fk_category_category` FOREIGN KEY (`parent_id`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='Category Table.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,NULL,'Sites','sites','/sites/',0,1,0,0,NOW(),NOW(),'',1);
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category_content`
--

DROP TABLE IF EXISTS `category_content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `content_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_category_content` (`content_id`,`category_id`),
  KEY `fk_category_content_category` (`category_id`),
  KEY `fk_category_content_content` (`content_id`),
  KEY `category_id_content_id` (`category_id`,`content_id`),
  CONSTRAINT `fk_category_content_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_category_content_content` FOREIGN KEY (`content_id`) REFERENCES `content` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `category_content_type`
--

DROP TABLE IF EXISTS `category_content_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category_content_type` (
  `category_id` int(11) NOT NULL,
  `content_type_id` int(11) NOT NULL,
  PRIMARY KEY (`category_id`,`content_type_id`),
  UNIQUE KEY `uk_category_content_type` (`content_type_id`,`category_id`),
  KEY `fk_category_content_type_category` (`category_id`),
  KEY `fk_category_content_type_content_type` (`content_type_id`),
  CONSTRAINT `fk_category_content_type_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_category_content_type_content_type` FOREIGN KEY (`content_type_id`) REFERENCES `content_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Content Types for Category Table.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `category_option`
--

DROP TABLE IF EXISTS `category_option`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category_option` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `name` varchar(40) NOT NULL,
  `value` varchar(40) NOT NULL,
  `inheritable` tinyint(1) NOT NULL DEFAULT '1',
  `creation_date` datetime DEFAULT '0000-00-00 00:00:00',
  `last_update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`,`category_id`),
  KEY `fk_category_option_category` (`category_id`),
  KEY `uk_name` (`name`,`category_id`),
  CONSTRAINT `fk_category_option_category1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='Category Options Table.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `category_view`
--

DROP TABLE IF EXISTS `category_view`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category_view` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `dest_category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_category_category` (`category_id`,`dest_category_id`),
  KEY `fk_cat_category` (`category_id`),
  KEY `fk_dest_category_category` (`dest_category_id`),
  KEY `cat_id_dest_cat_id` (`category_id`,`dest_category_id`),
  CONSTRAINT `fk_cat_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_dest_category_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `content`
--

DROP TABLE IF EXISTS `content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content_type_id` int(11) NOT NULL,
  `name` varchar(55) NOT NULL,
  `uriname` varchar(55) DEFAULT NULL,
  `uripath` varchar(255) NOT NULL,
  `publish_flag` tinyint(1) DEFAULT '1',
  `publish_date` datetime DEFAULT '0000-00-00 00:00:00',
  `disable_date` datetime DEFAULT '0000-00-00 00:00:00',
  `weight` int(11) DEFAULT '0',
  `creation_date` datetime DEFAULT '0000-00-00 00:00:00',
  `last_update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `keywords` varchar(255) DEFAULT NULL,
  `creator_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_uriname` (`uriname`),
  KEY `fk_content_content_type1` (`content_type_id`),
  CONSTRAINT `fk_content_content_type1` FOREIGN KEY (`content_type_id`) REFERENCES `content_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='Content Table.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `content_counter`
--

DROP TABLE IF EXISTS `content_counter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `content_counter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content_id` int(11) NOT NULL,
  `creation_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`,`content_id`),
  KEY `fk_content_counter_content` (`content_id`),
  CONSTRAINT `fk_content_counter_content` FOREIGN KEY (`content_id`) REFERENCES `content` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `content_type`
--

DROP TABLE IF EXISTS `content_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `content_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `uriname` varchar(40) NOT NULL,
  `active_flag` tinyint(1) DEFAULT '1',
  `creation_date` datetime DEFAULT '0000-00-00 00:00:00',
  `last_update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_uriname` (`uriname`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='Content Type Table.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `content_type_field`
--

DROP TABLE IF EXISTS `content_type_field`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `content_type_field` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content_type_id` int(11) NOT NULL,
  `name` varchar(40) NOT NULL,
  `label` varchar(50) NOT NULL,
  `type` varchar(20) NOT NULL,
  `required` tinyint(1) DEFAULT '0',
  `args` longblob,
  `position` int(11) DEFAULT '0',
  `help` varchar(255) DEFAULT NULL,
  `active_flag` tinyint(1) DEFAULT '1',
  `creation_date` datetime DEFAULT '0000-00-00 00:00:00',
  `last_update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `translatable` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`,`content_type_id`),
  UNIQUE KEY `uk_content_type_field_content_type` (`content_type_id`,`name`),
  KEY `fk_content_type_field_content_type` (`content_type_id`),
  CONSTRAINT `fk_content_type_field_content_type` FOREIGN KEY (`content_type_id`) REFERENCES `content_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='Content Type Field Table.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `content_value`
--

DROP TABLE IF EXISTS `content_value`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `content_value` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content_id` int(11) NOT NULL,
  `content_type_field_id` int(11) NOT NULL,
  `name` varchar(40) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`,`content_id`,`content_type_field_id`),
  KEY `fk_content_value_content` (`content_id`),
  KEY `fk_content_value_content_type_field` (`content_type_field_id`),
  CONSTRAINT `content_value_ibfk_1` FOREIGN KEY (`content_type_field_id`) REFERENCES `content_type_field` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_content_value_content1` FOREIGN KEY (`content_id`) REFERENCES `content` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='Content Values Table.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `file`
--

DROP TABLE IF EXISTS `file`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `filetype` varchar(25) NOT NULL,
  `filepath` varchar(100) NOT NULL,
  `fullpath` varchar(100) NOT NULL,
  `raw_name` varchar(50) NOT NULL,
  `original_name` varchar(50) NOT NULL,
  `client_name` varchar(50) NOT NULL,
  `extension` varchar(10) NOT NULL,
  `filesize` float NOT NULL,
  `is_image` tinyint(1) NOT NULL DEFAULT '0',
  `image_width` int(11) DEFAULT NULL,
  `image_height` int(11) DEFAULT NULL,
  `image_type` varchar(10) DEFAULT NULL,
  `creation_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `i18n_language`
--

DROP TABLE IF EXISTS `i18n_language`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `i18n_language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(7) NOT NULL,
  `name` varchar(128) NOT NULL,
  `default` tinyint(1) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `country` varchar(25) NOT NULL,
  `creation_date` datetime DEFAULT '0000-00-00 00:00:00',
  `last_update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='I18n Language Table';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `i18n_language_settings_website`
--

DROP TABLE IF EXISTS `i18n_language_settings_website`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `i18n_language_settings_website` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `settings_website_id` int(11) NOT NULL,
  `i18n_language_id` int(11) NOT NULL,
  `creation_date` datetime DEFAULT '0000-00-00 00:00:00',
  `last_update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_language_website` (`i18n_language_id`,`settings_website_id`),
  KEY `fk_settings_website` (`settings_website_id`),
  KEY `fk_i18n_language` (`i18n_language_id`),
  CONSTRAINT `fk_i18n_language` FOREIGN KEY (`i18n_language_id`) REFERENCES `i18n_language` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_settings_website` FOREIGN KEY (`settings_website_id`) REFERENCES `settings_website` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Relation with Website Settings Table and I18n Language Table';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `newsletter`
--

DROP TABLE IF EXISTS `newsletter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `newsletter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `from` varchar(255) NOT NULL,
  `template` varchar(255) NOT NULL,
  `site` varchar(255) NOT NULL,
  `content_types` varchar(255) DEFAULT NULL,
  `contents_start_date` datetime DEFAULT NULL,
  `contents_end_date` datetime DEFAULT NULL,
  `body` text NOT NULL,
  `creator_id` int(11) DEFAULT NULL,
  `creation_date` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Newsletter Table';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `newsletter_contact`
--

DROP TABLE IF EXISTS `newsletter_contact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `newsletter_contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `creation_date` datetime DEFAULT '0000-00-00 00:00:00',
  `active_flag` int(1) DEFAULT '1',
  `source` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `notification`
--

DROP TABLE IF EXISTS `notification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `source` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `attach` varchar(255) DEFAULT NULL,
  `creation_date` datetime DEFAULT NULL,
  `last_update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `key_match` varchar(255) NOT NULL,
  `active_flag` tinyint(1) DEFAULT '1',
  `creation_date` datetime DEFAULT '0000-00-00 00:00:00',
  `last_update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Role Table';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `role_user`
--

DROP TABLE IF EXISTS `role_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_role_user` (`user_id`,`role_id`),
  KEY `fk_user` (`user_id`),
  KEY `fk_role` (`role_id`),
  KEY `user_id_role_id` (`user_id`,`role_id`),
  CONSTRAINT `fk_role` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `settings_website`
--

DROP TABLE IF EXISTS `settings_website`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings_website` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `domain` varchar(50) NOT NULL,
  `title` varchar(70) NOT NULL,
  `description` varchar(160) NOT NULL,
  `keywords` text NOT NULL,
  `category_id` int(11) NOT NULL,
  `creation_date` datetime DEFAULT '0000-00-00 00:00:00',
  `last_update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_domain` (`domain`),
  KEY `fk_website_category` (`category_id`),
  CONSTRAINT `fk_website_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='Website Settings Table';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `translation`
--

DROP TABLE IF EXISTS `translation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `translation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `content_id` int(11) DEFAULT NULL,
  `name` varchar(40) NOT NULL,
  `value` text NOT NULL,
  `creation_date` datetime DEFAULT '0000-00-00 00:00:00',
  `last_update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_translation_category` (`language_id`,`category_id`,`name`),
  UNIQUE KEY `uk_translation_content` (`language_id`,`content_id`,`name`),
  KEY `fk_translation_category` (`category_id`),
  KEY `fk_translation_content` (`content_id`),
  KEY `fk_translation_language` (`language_id`),
  CONSTRAINT `fk_translation_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_translation_content` FOREIGN KEY (`content_id`) REFERENCES `content` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_translation_language` FOREIGN KEY (`language_id`) REFERENCES `i18n_language` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Translations Table';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(40) NOT NULL,
  `active_flag` tinyint(1) DEFAULT '1',
  `creation_date` datetime DEFAULT '0000-00-00 00:00:00',
  `last_update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `avatar` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='User Table';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_session`
--

DROP TABLE IF EXISTS `user_session`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_session` (
  `session_id` varchar(32) NOT NULL,
  `user_id` int(11) NOT NULL,
  `creation_date` datetime NOT NULL,
  `user_agent` varchar(120) DEFAULT NULL,
  `ip_address` varchar(16) DEFAULT NULL,
  `browser` varchar(255) DEFAULT NULL,
  `operating_system` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`session_id`,`user_id`),
  UNIQUE KEY `uk_user_session` (`session_id`,`user_id`),
  KEY `fk_user_session` (`user_id`),
  CONSTRAINT `fk_user_session` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='User Session Table';
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
SET FOREIGN_KEY_CHECKS = 0
