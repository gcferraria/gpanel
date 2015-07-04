CREATE TABLE `category_view` (
    `id`               int(11) NOT NULL AUTO_INCREMENT,
    `category_id`      int(11) NOT NULL,
    `dest_category_id` int(11) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_category_category` (`category_id`,`dest_category_id`),
    KEY `fk_cat_category` (`category_id`),
    KEY `fk_dest_category_category` (`dest_category_id`),
    KEY `cat_id_dest_cat_id` (`category_id`,`dest_category_id`),
    CONSTRAINT `fk_cat_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) 
    ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_dest_category_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) 
    ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
