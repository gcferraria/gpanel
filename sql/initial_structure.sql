SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Estrutura da tabela `administrator`
--

CREATE TABLE IF NOT EXISTS `administrator` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Administrator Table' AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `administrator`
--

INSERT INTO `administrator` (`id`, `name`, `username`, `password`, `email`, `sex`, `super_admin_flag`, `active_flag`, `creation_date`, `last_update_date`, `avatar`) VALUES
(1, 'Gonçalo da Costa Ferraria', 'gcferraria', '756624085a54da7f45daf8113008f3262f826c54', 'gferraria@gmail.com', 'M', 1, 1, '2012-04-27 00:00:00', '2013-03-22 08:42:52', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `administrator_session`
--

CREATE TABLE IF NOT EXISTS `administrator_session` (
  `session_id` varchar(32) NOT NULL,
  `administrator_id` int(11) NOT NULL,
  `creation_date` datetime NOT NULL,
  `user_agent` varchar(120) DEFAULT NULL,
  `ip_address` varchar(16) DEFAULT NULL,
  `browser` varchar(255) DEFAULT NULL,
  `operating_system` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`session_id`,`administrator_id`),
  UNIQUE KEY `uk_administrator_session` (`session_id`,`administrator_id`),
  KEY `fk_administrator_session` (`administrator_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Administrator Session Table';

-- --------------------------------------------------------

--
-- Estrutura da tabela `category`
--

CREATE TABLE IF NOT EXISTS `category` (
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
  KEY `idx_uripath_publish` (`uripath`,`publish_flag`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Category Table.' AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `category`
--

INSERT INTO `category` (`id`, `parent_id`, `name`, `uriname`, `uripath`, `weight`, `publish_flag`, `listed`, `exposed`, `creation_date`, `last_update_date`, `description`, `creator_id`) VALUES
(1, NULL, 'Sites', 'sites', '/sites/', 0, 1, 0, 0, '2016-02-23 23:11:38', '2016-02-23 23:11:38', '', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `category_content`
--

CREATE TABLE IF NOT EXISTS `category_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `content_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_category_content` (`content_id`,`category_id`),
  KEY `fk_category_content_category` (`category_id`),
  KEY `fk_category_content_content` (`content_id`),
  KEY `category_id_content_id` (`category_id`,`content_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `category_content_type`
--

CREATE TABLE IF NOT EXISTS `category_content_type` (
  `category_id` int(11) NOT NULL,
  `content_type_id` int(11) NOT NULL,
  PRIMARY KEY (`category_id`,`content_type_id`),
  UNIQUE KEY `uk_category_content_type` (`content_type_id`,`category_id`),
  KEY `fk_category_content_type_category` (`category_id`),
  KEY `fk_category_content_type_content_type` (`content_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Content Types for Category Table.';

-- --------------------------------------------------------

--
-- Estrutura da tabela `category_option`
--

CREATE TABLE IF NOT EXISTS `category_option` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `name` varchar(40) NOT NULL,
  `value` varchar(40) NOT NULL,
  `inheritable` tinyint(1) NOT NULL DEFAULT '1',
  `creation_date` datetime DEFAULT '0000-00-00 00:00:00',
  `last_update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`,`category_id`),
  KEY `fk_category_option_category` (`category_id`),
  KEY `uk_name` (`name`,`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Category Options Table.' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `category_view`
--

CREATE TABLE IF NOT EXISTS `category_view` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `dest_category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_category_category` (`category_id`,`dest_category_id`),
  KEY `fk_cat_category` (`category_id`),
  KEY `fk_dest_category_category` (`dest_category_id`),
  KEY `cat_id_dest_cat_id` (`category_id`,`dest_category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `content`
--

CREATE TABLE IF NOT EXISTS `content` (
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
  KEY `fk_content_content_type1` (`content_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Content Table.' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `content_counter`
--

CREATE TABLE IF NOT EXISTS `content_counter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content_id` int(11) NOT NULL,
  `creation_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`,`content_id`),
  KEY `fk_content_counter_content` (`content_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `content_type`
--

CREATE TABLE IF NOT EXISTS `content_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `uriname` varchar(40) NOT NULL,
  `active_flag` tinyint(1) DEFAULT '1',
  `creation_date` datetime DEFAULT '0000-00-00 00:00:00',
  `last_update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_uriname` (`uriname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Content Type Table.' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `content_type_field`
--

CREATE TABLE IF NOT EXISTS `content_type_field` (
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
  KEY `fk_content_type_field_content_type` (`content_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Content Type Field Table.' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `content_value`
--

CREATE TABLE IF NOT EXISTS `content_value` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content_id` int(11) NOT NULL,
  `content_type_field_id` int(11) NOT NULL,
  `name` varchar(40) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`,`content_id`,`content_type_field_id`),
  KEY `fk_content_value_content` (`content_id`),
  KEY `fk_content_value_content_type_field` (`content_type_field_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Content Values Table.' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `file`
--

CREATE TABLE IF NOT EXISTS `file` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `i18n_language`
--

CREATE TABLE IF NOT EXISTS `i18n_language` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='I18n Language Table' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `i18n_language_settings_website`
--

CREATE TABLE IF NOT EXISTS `i18n_language_settings_website` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `settings_website_id` int(11) NOT NULL,
  `i18n_language_id` int(11) NOT NULL,
  `creation_date` datetime DEFAULT '0000-00-00 00:00:00',
  `last_update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_language_website` (`i18n_language_id`,`settings_website_id`),
  KEY `fk_settings_website` (`settings_website_id`),
  KEY `fk_i18n_language` (`i18n_language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Relation with Website Settings Table and I18n Language Table' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `newsletter`
--

CREATE TABLE IF NOT EXISTS `newsletter` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Newsletter Table' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `newsletter_contact`
--

CREATE TABLE IF NOT EXISTS `newsletter_contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `creation_date` datetime DEFAULT '0000-00-00 00:00:00',
  `active_flag` int(1) DEFAULT '1',
  `source` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `notification`
--

CREATE TABLE IF NOT EXISTS `notification` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `key_match` varchar(255) NOT NULL,
  `active_flag` tinyint(1) DEFAULT '1',
  `creation_date` datetime DEFAULT '0000-00-00 00:00:00',
  `last_update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Role Table' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `role_user`
--

CREATE TABLE IF NOT EXISTS `role_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_role_user` (`user_id`,`role_id`),
  KEY `fk_user` (`user_id`),
  KEY `fk_role` (`role_id`),
  KEY `user_id_role_id` (`user_id`,`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `settings_website`
--

CREATE TABLE IF NOT EXISTS `settings_website` (
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
  KEY `fk_website_category` (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Website Settings Table' AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `translation`
--

CREATE TABLE IF NOT EXISTS `translation` (
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
  KEY `fk_translation_language` (`language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Translations Table' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `user`
--

CREATE TABLE IF NOT EXISTS `user` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='User Table' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `user_session`
--

CREATE TABLE IF NOT EXISTS `user_session` (
  `session_id` varchar(32) NOT NULL,
  `user_id` int(11) NOT NULL,
  `creation_date` datetime NOT NULL,
  `user_agent` varchar(120) DEFAULT NULL,
  `ip_address` varchar(16) DEFAULT NULL,
  `browser` varchar(255) DEFAULT NULL,
  `operating_system` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`session_id`,`user_id`),
  UNIQUE KEY `uk_user_session` (`session_id`,`user_id`),
  KEY `fk_user_session` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='User Session Table';

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `administrator_session`
--
ALTER TABLE `administrator_session`
  ADD CONSTRAINT `fk_administrator_session` FOREIGN KEY (`administrator_id`) REFERENCES `administrator` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `category`
--
ALTER TABLE `category`
  ADD CONSTRAINT `fk_category_category` FOREIGN KEY (`parent_id`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `category_content`
--
ALTER TABLE `category_content`
  ADD CONSTRAINT `fk_category_content_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_category_content_content` FOREIGN KEY (`content_id`) REFERENCES `content` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `category_content_type`
--
ALTER TABLE `category_content_type`
  ADD CONSTRAINT `fk_category_content_type_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_category_content_type_content_type` FOREIGN KEY (`content_type_id`) REFERENCES `content_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `category_option`
--
ALTER TABLE `category_option`
  ADD CONSTRAINT `fk_category_option_category1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `category_view`
--
ALTER TABLE `category_view`
  ADD CONSTRAINT `fk_cat_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_dest_category_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `content`
--
ALTER TABLE `content`
  ADD CONSTRAINT `fk_content_content_type1` FOREIGN KEY (`content_type_id`) REFERENCES `content_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `content_counter`
--
ALTER TABLE `content_counter`
  ADD CONSTRAINT `fk_content_counter_content` FOREIGN KEY (`content_id`) REFERENCES `content` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `content_type_field`
--
ALTER TABLE `content_type_field`
  ADD CONSTRAINT `fk_content_type_field_content_type` FOREIGN KEY (`content_type_id`) REFERENCES `content_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `content_value`
--
ALTER TABLE `content_value`
  ADD CONSTRAINT `content_value_ibfk_1` FOREIGN KEY (`content_type_field_id`) REFERENCES `content_type_field` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_content_value_content1` FOREIGN KEY (`content_id`) REFERENCES `content` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `i18n_language_settings_website`
--
ALTER TABLE `i18n_language_settings_website`
  ADD CONSTRAINT `fk_i18n_language` FOREIGN KEY (`i18n_language_id`) REFERENCES `i18n_language` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_settings_website` FOREIGN KEY (`settings_website_id`) REFERENCES `settings_website` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `fk_role` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `settings_website`
--
ALTER TABLE `settings_website`
  ADD CONSTRAINT `fk_website_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `translation`
--
ALTER TABLE `translation`
  ADD CONSTRAINT `fk_translation_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_translation_content` FOREIGN KEY (`content_id`) REFERENCES `content` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_translation_language` FOREIGN KEY (`language_id`) REFERENCES `i18n_language` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `user_session`
--
ALTER TABLE `user_session`
  ADD CONSTRAINT `fk_user_session` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
