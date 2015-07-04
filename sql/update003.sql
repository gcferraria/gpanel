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
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='User Table';

CREATE TABLE `role` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(50) NOT NULL,
    `key_match` varchar(255) NOT NULL,
    `active_flag` tinyint(1) DEFAULT '1',
    `creation_date` datetime DEFAULT '0000-00-00 00:00:00',
    `last_update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='Role Table';

CREATE TABLE `role_user` (
    `id`      int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `role_id` int(11) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_role_user` (`user_id`,`role_id`),
    KEY `fk_user` (`user_id`),
    KEY `fk_role` (`role_id`),
    KEY `user_id_role_id` (`user_id`,`role_id`),
    CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) 
    ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_role` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) 
    ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE `user_session` (
  `session_id`       varchar(32) NOT NULL,
  `user_id`          int(11) NOT NULL,
  `creation_date`    datetime NOT NULL,
  `user_agent`       varchar(120) DEFAULT NULL,
  `ip_address`       varchar(16) DEFAULT NULL,
  `browser`          varchar(255) DEFAULT NULL,
  `operating_system` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`session_id`,`user_id`),
  UNIQUE KEY `uk_user_session` (`session_id`,`user_id`),
  KEY `fk_user_session` (`user_id`),
  CONSTRAINT `fk_user_session` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='User Session Table';

