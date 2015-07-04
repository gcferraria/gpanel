DROP TABLE IF EXISTS `translation`;

CREATE TABLE `translation` (
    `id`                  integer(11)   NOT NULL AUTO_INCREMENT,
    `language_id`         integer(11)   NOT NULL,
    `category_id`         integer(11)   NULL,
    `content_id`          integer(11)   NULL,
    `name`         		  varchar(40)   NOT NULL,
    `value`               text          NOT NULL,
    `creation_date`       datetime      NULL     DEFAULT '0000-00-00 00:00:00',
    `last_update_date`    timestamp     NULL     DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_translation_category` (`language_id`,`category_id`,`name`),
    UNIQUE KEY `uk_translation_content`  (`language_id`,`content_id`,`name`),
    KEY `fk_translation_category` (`category_id`),
    KEY `fk_translation_content` (`content_id`),
    KEY `fk_translation_language` (`language_id`),
    CONSTRAINT `fk_translation_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) 		ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_translation_content`  FOREIGN KEY (`content_id`)  REFERENCES `content` (`id`)  		ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_translation_language` FOREIGN KEY (`language_id`) REFERENCES `i18n_language` (`id`)  ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='Translations Table';

ALTER TABLE `content_type_field` ADD COLUMN `translatable` TINYINT(1) NOT NULL DEFAULT 1;