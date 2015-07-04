ALTER TABLE `newsletter_contact` ADD `active_flag` INT(1) DEFAULT 1;
ALTER TABLE `newsletter_contact` ADD `source` VARCHAR(50) DEFAULT NULL;

CREATE TABLE `newsletter` (
    `id`                  integer(11)   NOT NULL AUTO_INCREMENT,
    `name`                varchar(255)  NOT NULL,
    `from`                varchar(255)  NOT NULL,
    `template`            varchar(255)  NOT NULL,
    `site`                varchar(255)  NOT NULL,
    `content_types`       varchar(255)          ,
    `contents_start_date` datetime              ,
    `contents_end_date`   datetime              ,
    `body`                text          NOT NULL,
    `creator_id`          integer(11)           ,
    `creation_date`       datetime DEFAULT '0000-00-00 00:00:00',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='Newsletter Table';
