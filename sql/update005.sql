DROP TABLE IF EXISTS `migrations`;
DROP TABLE IF EXISTS `i18n_language`;
DROP TABLE IF EXISTS `settings_website`;
DROP TABLE IF EXISTS `i18n_language_settings_website`;

CREATE TABLE `i18n_language` (
    `id`                  integer(11)   NOT NULL AUTO_INCREMENT,
    `code`                varchar(7)    NOT NULL,
    `name`                varchar(128)  NOT NULL,
    `default`             tinyint(1)    NOT NULL DEFAULT 0,
    `active`              tinyint(1)    NOT NULL DEFAULT 1,
    `country`             varchar(25)   NOT NULL,
    `creation_date`       datetime      NULL     DEFAULT '0000-00-00 00:00:00',
    `last_update_date`    timestamp     NULL     DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='I18n Language Table';

CREATE TABLE `settings_website` (
    `id`                  integer(11)   NOT NULL AUTO_INCREMENT,
    `name`                varchar(128)  NOT NULL,
    `domain`              varchar(50)   NOT NULL,
    `title`               varchar(70)   NOT NULL,
    `description`         varchar(160)  NOT NULL,
    `keywords`            text          NOT NULL,
    `category_id`         integer(11)   NOT NULL,
    `creation_date`       datetime      NULL     DEFAULT '0000-00-00 00:00:00',
    `last_update_date`    timestamp     NULL     DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_domain` (`domain`),
    KEY `fk_website_category` (`category_id`),
    CONSTRAINT `fk_website_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='Website Settings Table';

CREATE TABLE `i18n_language_settings_website` (
    `id`                  integer(11)   NOT NULL AUTO_INCREMENT,
    `settings_website_id` integer(11)   NOT NULL,
    `i18n_language_id`    integer(11)   NOT NULL,
    `creation_date`       datetime      NULL     DEFAULT '0000-00-00 00:00:00',
    `last_update_date`    timestamp     NULL     DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_language_website` (`i18n_language_id`,`settings_website_id`),
    KEY `fk_settings_website` (`settings_website_id`),
    KEY `fk_i18n_language` (`i18n_language_id`),
    CONSTRAINT `fk_settings_website` FOREIGN KEY (`settings_website_id`) REFERENCES `settings_website` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_i18n_language` FOREIGN KEY (`i18n_language_id`) REFERENCES `i18n_language` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='Relation with Website Settings Table and I18n Language Table';