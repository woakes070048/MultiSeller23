ALTER TABLE `oc_modification` CHANGE xml xml MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ;

CREATE TABLE IF NOT EXISTS `oc_badge` (
  `badge_id` int(11) NOT NULL AUTO_INCREMENT,
  `value` decimal(15,8) NOT NULL DEFAULT '0.00000000',
  PRIMARY KEY (`badge_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;



CREATE TABLE IF NOT EXISTS `oc_badge_description` (
  `badge_id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(11) NOT NULL,
  `title` varchar(32) NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`badge_id`,`language_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS `oc_badge_to_seller` (
  `badge_id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`badge_id`,`seller_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `oc_bankaccount` (
  `bankaccount_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `firstname` varchar(32) NOT NULL,
  `lastname` varchar(32) NOT NULL,
  `company` varchar(32) NOT NULL,
  `company_id` varchar(32) NOT NULL,
  `branch_id` varchar(32) NOT NULL,
  `bankaccount_1` varchar(128) NOT NULL,
  `bankaccount_2` varchar(128) NOT NULL,
  `bank_id` int(11) NOT NULL,
  PRIMARY KEY (`bankaccount_id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;


ALTER TABLE `oc_customer` ADD  `bankaccount_id` int(11) NOT NULL AFTER  `address_id` ;


CREATE TABLE IF NOT EXISTS `oc_bank` (
  `bank_id` int(11) NOT NULL AUTO_INCREMENT,
  `value` decimal(15,8) NOT NULL DEFAULT '0.00000000',
  PRIMARY KEY (`bank_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;



CREATE TABLE IF NOT EXISTS `oc_bank_description` (
  `bank_id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(11) NOT NULL,
  `title` varchar(32) NOT NULL,
  `unit` varchar(4) NOT NULL,
  PRIMARY KEY (`bank_id`,`language_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  ;



CREATE TABLE IF NOT EXISTS `oc_seller_group` (
  `seller_group_id` int(11) NOT NULL AUTO_INCREMENT,
`product_limit` int(11) NOT NULL,
`product_status` tinyint(1) NOT NULL,
`subscription_price` int(11) NOT NULL,
`commission` int(11) NOT NULL,
`fee` int(11) NOT NULL,
`subscription_duration` int(11) NOT NULL,
  `sort_order` int(3) NOT NULL,
 `status` tinyint(1) NOT NULL,
    PRIMARY KEY (`seller_group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `oc_seller_group_description` (
  `seller_group_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`seller_group_id`,`language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `oc_customer` ADD  `seller_group_id` int(11) NOT NULL AFTER  `address_id` ;
ALTER TABLE `oc_customer` ADD  `seller_approved` int(1) NOT NULL AFTER  `seller_group_id` ;
ALTER TABLE `oc_customer` ADD  `seller_changegroup` int(1) NOT NULL AFTER  `seller_approved` ;
ALTER TABLE `oc_customer` ADD `seller_date_added` DATETIME NOT NULL AFTER `seller_changegroup`;
ALTER TABLE `oc_customer` ADD `image`  varchar(255) NULL AFTER `seller_date_added`;
ALTER TABLE `oc_customer` ADD `banner`  varchar(255) NULL AFTER `image`;
ALTER TABLE `oc_customer` ADD `product_status`  tinyint(1) NULL AFTER `image`;
ALTER TABLE `oc_customer` ADD `description` text NOT NULL AFTER `seller_date_added`;
ALTER TABLE `oc_customer` ADD `website`  varchar(255) NULL AFTER `seller_date_added`;
ALTER TABLE `oc_customer` ADD `facebook`  varchar(255) NULL AFTER `seller_date_added`;
ALTER TABLE `oc_customer` ADD `twitter`  varchar(255) NULL AFTER `seller_date_added`;
ALTER TABLE `oc_customer` ADD `googleplus`  varchar(255) NULL AFTER `seller_date_added`;
ALTER TABLE `oc_customer` ADD `instagram`  varchar(255) NULL AFTER `seller_date_added`;
ALTER TABLE `oc_customer` ADD `nickname`  varchar(255) NULL AFTER `seller_date_added`;

ALTER TABLE `oc_order_product` ADD `status_id`  int(11) NOT NULL DEFAULT '0' AFTER `price`;
ALTER TABLE `oc_order_history` ADD `seller_id`  int(11) NOT NULL DEFAULT '0' AFTER `comment`;

CREATE TABLE IF NOT EXISTS `oc_order_sellerhistory` (
  `order_history_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `order_status_id` int(5) NOT NULL,
  `notify` tinyint(1) NOT NULL DEFAULT '0',
  `seller_id` int(11) NOT NULL,
 `settlement` tinyint(1) NOT NULL DEFAULT '0',
  `comment` text NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`order_history_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  ;

CREATE TABLE IF NOT EXISTS `oc_product_to_seller` (
  `product_id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`product_id`,`seller_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `oc_download_to_seller` (
  `download_id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`download_id`,`seller_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `oc_seller_transaction` (
`seller_transaction_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `amount` decimal(15,4) NOT NULL,
  `date_added` datetime NOT NULL,
 PRIMARY KEY (`seller_transaction_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `oc_order_seller_settlement` (
  `order_seller_settlement_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `settlement` tinyint(1) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`order_seller_settlement_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  ;

CREATE TABLE IF NOT EXISTS `oc_sellerreview` (
`sellerreview_id` int(11) NOT NULL AUTO_INCREMENT,
  `seller_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(64) NOT NULL,
  `text` text NOT NULL,
  `rating` int(1) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `sticky` tinyint(1) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
   PRIMARY KEY (`sellerreview_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `oc_category_to_seller_group` (
  `category_id` int(11) NOT NULL,
  `seller_group_id` int(11) NOT NULL,
PRIMARY KEY (`category_id`,`seller_group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `oc_category_to_seller` (
  `category_id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
PRIMARY KEY (`category_id`,`seller_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `oc_seller_shipping` (
  `seller_shipping_id` int(11) NOT NULL AUTO_INCREMENT,
  `seller_id` int(11) NOT NULL,
  `code` varchar(32) NOT NULL,
  PRIMARY KEY (`seller_shipping_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


ALTER TABLE `oc_order_product` ADD `shipping_method` varchar(128) NOT NULL AFTER  `status_id` ;
ALTER TABLE `oc_order_product` ADD `shipping_code` varchar(128) NOT NULL AFTER  `shipping_method` ;
ALTER TABLE `oc_geo_zone` ADD `seller_id`  int(11) NOT NULL DEFAULT '0' AFTER `description`;
ALTER TABLE `oc_order_total` ADD `seller_id`  int(11) NOT NULL DEFAULT '0' AFTER `value`;
ALTER TABLE `oc_order_total` ADD `product_id`  int(11) NOT NULL DEFAULT '0' AFTER `seller_id`;

