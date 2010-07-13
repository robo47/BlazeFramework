/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50141
Source Host           : localhost:3306
Source Database       : mydb

Target Server Type    : MYSQL
Target Server Version : 50141
File Encoding         : 65001

Date: 2010-07-13 10:45:18
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `attribute`
-- ----------------------------
DROP TABLE IF EXISTS `attribute`;
CREATE TABLE `attribute` (
  `attr_id` int(11) NOT NULL,
  `attr_name` varchar(60) DEFAULT NULL,
  `attr_label` varchar(60) DEFAULT NULL,
  `attr_required` tinyint(1) DEFAULT NULL,
  `attr_searchable` tinyint(1) DEFAULT NULL,
  `attr_filterable` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`attr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of attribute
-- ----------------------------

-- ----------------------------
-- Table structure for `attribute_value`
-- ----------------------------
DROP TABLE IF EXISTS `attribute_value`;
CREATE TABLE `attribute_value` (
  `atva_id` int(11) NOT NULL,
  `atva_value` varchar(60) DEFAULT NULL,
  `atva_attribute_attr_id` int(11) NOT NULL,
  PRIMARY KEY (`atva_id`),
  KEY `fk_attribute_value_attribute1` (`atva_attribute_attr_id`),
  CONSTRAINT `fk_attribute_value_attribute1` FOREIGN KEY (`atva_attribute_attr_id`) REFERENCES `attribute` (`attr_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of attribute_value
-- ----------------------------

-- ----------------------------
-- Table structure for `available_product`
-- ----------------------------
DROP TABLE IF EXISTS `available_product`;
CREATE TABLE `available_product` (
  `avpr_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Available product id',
  `avpr_discount` int(11) DEFAULT NULL COMMENT 'Discount for available product',
  `avpr_price` decimal(10,0) DEFAULT NULL COMMENT 'Price for available product',
  `avpr_discount_from` date DEFAULT NULL COMMENT 'Date from when a discount begins',
  `avpr_discount_to` date DEFAULT NULL COMMENT 'Date to when a discount lasts',
  `avpr_available` tinyint(1) DEFAULT NULL COMMENT 'Specifies wether a product is available or not',
  `avpr_available_unit` int(11) DEFAULT NULL COMMENT 'Number of units of available product',
  `avpr_available_from` date DEFAULT NULL COMMENT 'Date from when a product is available',
  `avpr_available_to` date DEFAULT NULL COMMENT 'Date to when a product lasts available',
  `avpr_added` date DEFAULT NULL,
  `avpr_product_prod_id` int(11) NOT NULL COMMENT 'Product',
  `tax_class_tacl_id` int(11) NOT NULL,
  PRIMARY KEY (`avpr_id`),
  KEY `fk_available_product_product1` (`avpr_product_prod_id`),
  KEY `fk_available_product_tax_class1` (`tax_class_tacl_id`),
  CONSTRAINT `fk_available_product_product1` FOREIGN KEY (`avpr_product_prod_id`) REFERENCES `product` (`prod_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_available_product_tax_class1` FOREIGN KEY (`tax_class_tacl_id`) REFERENCES `tax_class` (`tacl_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of available_product
-- ----------------------------

-- ----------------------------
-- Table structure for `cart_entry`
-- ----------------------------
DROP TABLE IF EXISTS `cart_entry`;
CREATE TABLE `cart_entry` (
  `caen_id` int(11) NOT NULL,
  `caen_position` int(11) DEFAULT NULL,
  `caen_unit` int(11) DEFAULT NULL,
  `caen_price` varchar(60) DEFAULT NULL,
  `caen_size` varchar(60) DEFAULT NULL,
  `caen_product_avpr_id` int(11) NOT NULL,
  `caen_user_user_id` int(11) NOT NULL,
  PRIMARY KEY (`caen_id`),
  KEY `fk_cart_entry_available_product1` (`caen_product_avpr_id`),
  KEY `fk_cart_user1` (`caen_user_user_id`),
  CONSTRAINT `fk_cart_entry_available_product1` FOREIGN KEY (`caen_product_avpr_id`) REFERENCES `available_product` (`avpr_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_cart_user1` FOREIGN KEY (`caen_user_user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cart_entry
-- ----------------------------

-- ----------------------------
-- Table structure for `city`
-- ----------------------------
DROP TABLE IF EXISTS `city`;
CREATE TABLE `city` (
  `city_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'City id',
  `city_name` varchar(60) DEFAULT NULL COMMENT 'Name of a city',
  PRIMARY KEY (`city_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of city
-- ----------------------------
INSERT INTO `city` VALUES ('1', 'St.Pölten');

-- ----------------------------
-- Table structure for `config`
-- ----------------------------
DROP TABLE IF EXISTS `config`;
CREATE TABLE `config` (
  `conf_id` int(11) NOT NULL,
  `conf_name` varchar(60) DEFAULT NULL,
  `conf_label` varchar(60) DEFAULT NULL,
  `conf_value` text,
  `conf_config_group_cogr_key` varchar(60) NOT NULL,
  `conf_config_group_module_modu_id` int(11) NOT NULL,
  PRIMARY KEY (`conf_id`),
  KEY `fk_config_config_group1` (`conf_config_group_cogr_key`,`conf_config_group_module_modu_id`),
  CONSTRAINT `fk_config_config_group1` FOREIGN KEY (`conf_config_group_cogr_key`, `conf_config_group_module_modu_id`) REFERENCES `config_group` (`cogr_key`, `cogr_module_modu_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of config
-- ----------------------------

-- ----------------------------
-- Table structure for `config_group`
-- ----------------------------
DROP TABLE IF EXISTS `config_group`;
CREATE TABLE `config_group` (
  `cogr_key` varchar(60) NOT NULL,
  `cogr_module_modu_id` int(11) NOT NULL,
  PRIMARY KEY (`cogr_key`,`cogr_module_modu_id`),
  KEY `fk_config_group_module1` (`cogr_module_modu_id`),
  CONSTRAINT `fk_config_group_module1` FOREIGN KEY (`cogr_module_modu_id`) REFERENCES `module` (`modu_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of config_group
-- ----------------------------

-- ----------------------------
-- Table structure for `contact_detail`
-- ----------------------------
DROP TABLE IF EXISTS `contact_detail`;
CREATE TABLE `contact_detail` (
  `code_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Contact detail id',
  `code_name` varchar(60) DEFAULT NULL COMMENT 'Name of a contact',
  `code_url` varchar(60) DEFAULT NULL COMMENT 'Url of a contact',
  `code_phone1` varchar(60) DEFAULT NULL COMMENT 'First phone number of a contact',
  `code_phone2` varchar(60) DEFAULT NULL COMMENT 'Second phone number of a contact',
  `code_fax1` varchar(60) DEFAULT NULL COMMENT 'First fax number of a contact',
  `code_fax2` varchar(60) DEFAULT NULL COMMENT 'Second fax number of a contact',
  `code_email1` varchar(60) DEFAULT NULL COMMENT 'First email of a contact',
  `code_email2` varchar(60) DEFAULT NULL COMMENT 'Second email of a contact',
  `location_loca_id` int(11) NOT NULL,
  PRIMARY KEY (`code_id`),
  KEY `fk_contact_detail_location1` (`location_loca_id`),
  CONSTRAINT `fk_contact_detail_location1` FOREIGN KEY (`location_loca_id`) REFERENCES `location` (`loca_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of contact_detail
-- ----------------------------
INSERT INTO `contact_detail` VALUES ('1', '', '', '', '', '', '', '', '', '1');
INSERT INTO `contact_detail` VALUES ('2', 'Post AG', 'http://www.post.at', '', '', '', '', '', '', '1');

-- ----------------------------
-- Table structure for `country`
-- ----------------------------
DROP TABLE IF EXISTS `country`;
CREATE TABLE `country` (
  `coun_id` char(2) NOT NULL COMMENT 'ISO1-Code',
  `coun_name` varchar(60) DEFAULT NULL COMMENT 'Capitalized name of a country',
  `coun_printable_name` varchar(60) DEFAULT NULL COMMENT 'Printable name of a country',
  `coun_iso3` char(3) DEFAULT NULL COMMENT 'ISO3-Code of a country',
  `coun_area_code` varchar(60) DEFAULT NULL COMMENT 'Phone area code of a country',
  `coun_flag_pict_id` int(11) DEFAULT NULL COMMENT 'Picture of a flag of a country',
  PRIMARY KEY (`coun_id`),
  KEY `fk_country_picture1` (`coun_flag_pict_id`),
  CONSTRAINT `fk_country_picture1` FOREIGN KEY (`coun_flag_pict_id`) REFERENCES `picture` (`pict_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of country
-- ----------------------------
INSERT INTO `country` VALUES ('AT', 'AUSTRIA', 'Austria', 'AUT', '43', null);

-- ----------------------------
-- Table structure for `currency`
-- ----------------------------
DROP TABLE IF EXISTS `currency`;
CREATE TABLE `currency` (
  `curr_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Currency id',
  `curr_name` varchar(60) DEFAULT NULL COMMENT 'Name of the currency',
  `curr_symbol` varchar(10) DEFAULT NULL COMMENT 'Symbol of the currency',
  `curr_code` varchar(10) DEFAULT NULL COMMENT 'Code of the currency(e.g. EUR)',
  PRIMARY KEY (`curr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of currency
-- ----------------------------
INSERT INTO `currency` VALUES ('1', 'Euro', '€', 'EUR');
INSERT INTO `currency` VALUES ('2', 'US Dollar', '$', 'USD');

-- ----------------------------
-- Table structure for `customer`
-- ----------------------------
DROP TABLE IF EXISTS `customer`;
CREATE TABLE `customer` (
  `cust_id` int(11) NOT NULL,
  `cust_user_user_id` int(11) NOT NULL,
  `cust_discount` int(11) DEFAULT NULL,
  `cust_discount_from` date DEFAULT NULL,
  `cust_discount_to` date DEFAULT NULL,
  PRIMARY KEY (`cust_id`),
  KEY `fk_customer_user1` (`cust_user_user_id`),
  CONSTRAINT `fk_customer_user1` FOREIGN KEY (`cust_user_user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of customer
-- ----------------------------

-- ----------------------------
-- Table structure for `customer_group`
-- ----------------------------
DROP TABLE IF EXISTS `customer_group`;
CREATE TABLE `customer_group` (
  `cugr_id` int(11) NOT NULL,
  `cugr_user_group_usgr_id` int(11) NOT NULL,
  `cugr_discount` int(11) DEFAULT NULL,
  `cugr_discount_from` date DEFAULT NULL,
  `cugr_discount_to` date DEFAULT NULL,
  PRIMARY KEY (`cugr_id`),
  KEY `fk_customer_group_user_group1` (`cugr_user_group_usgr_id`),
  CONSTRAINT `fk_customer_group_user_group1` FOREIGN KEY (`cugr_user_group_usgr_id`) REFERENCES `user_group` (`usgr_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of customer_group
-- ----------------------------

-- ----------------------------
-- Table structure for `delivery`
-- ----------------------------
DROP TABLE IF EXISTS `delivery`;
CREATE TABLE `delivery` (
  `deli_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Delivery id',
  `deli_price` decimal(10,0) DEFAULT NULL COMMENT 'Price per unit for delivery',
  `deli_lump_sum` decimal(10,0) DEFAULT NULL,
  `deli_added` date DEFAULT NULL,
  `deli_dety_id` int(11) NOT NULL COMMENT 'Delivery type',
  `deli_deliverer_code_id` int(11) DEFAULT NULL COMMENT 'Contact details for deliverer',
  PRIMARY KEY (`deli_id`),
  KEY `fk_deliverer_has_delivery_type_delivery_type1` (`deli_dety_id`),
  KEY `fk_delivery_contact_detail1` (`deli_deliverer_code_id`),
  CONSTRAINT `fk_deliverer_has_delivery_type_delivery_type1` FOREIGN KEY (`deli_dety_id`) REFERENCES `delivery_type` (`dety_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_delivery_contact_detail1` FOREIGN KEY (`deli_deliverer_code_id`) REFERENCES `contact_detail` (`code_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of delivery
-- ----------------------------
INSERT INTO `delivery` VALUES ('1', '0', '0', '2010-05-26', '1', null);
INSERT INTO `delivery` VALUES ('2', '3', '5', '2010-05-26', '2', '2');

-- ----------------------------
-- Table structure for `delivery_type`
-- ----------------------------
DROP TABLE IF EXISTS `delivery_type`;
CREATE TABLE `delivery_type` (
  `dety_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Delivery type id',
  `dety_name` varchar(60) DEFAULT NULL COMMENT 'Name of the delivery type',
  `dety_description` varchar(255) DEFAULT NULL COMMENT 'Description of the delivery type',
  PRIMARY KEY (`dety_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of delivery_type
-- ----------------------------
INSERT INTO `delivery_type` VALUES ('1', 'Abholung', 'Die Ware wird bei der Abholung übergeben');
INSERT INTO `delivery_type` VALUES ('2', 'Lieferung', 'Die Ware wird geliefert');

-- ----------------------------
-- Table structure for `entry_status`
-- ----------------------------
DROP TABLE IF EXISTS `entry_status`;
CREATE TABLE `entry_status` (
  `enst_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Entry status id',
  `enst_name` varchar(60) DEFAULT NULL COMMENT 'Name of an entry status',
  `enst_description` varchar(255) DEFAULT NULL COMMENT 'Description of an entry status',
  PRIMARY KEY (`enst_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of entry_status
-- ----------------------------

-- ----------------------------
-- Table structure for `location`
-- ----------------------------
DROP TABLE IF EXISTS `location`;
CREATE TABLE `location` (
  `loca_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Location id',
  `loca_zipc_id` char(10) NOT NULL COMMENT 'Zipcode',
  `loca_coun_id` char(2) NOT NULL COMMENT 'Country',
  `loca_city_id` int(11) NOT NULL COMMENT 'City',
  `province_prov_id` int(11) NOT NULL,
  PRIMARY KEY (`loca_id`),
  KEY `fk_location_zipcode1` (`loca_zipc_id`),
  KEY `fk_location_country1` (`loca_coun_id`),
  KEY `fk_location_city1` (`loca_city_id`),
  KEY `fk_location_province1` (`province_prov_id`),
  CONSTRAINT `fk_location_city1` FOREIGN KEY (`loca_city_id`) REFERENCES `city` (`city_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_location_country1` FOREIGN KEY (`loca_coun_id`) REFERENCES `country` (`coun_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_location_province1` FOREIGN KEY (`province_prov_id`) REFERENCES `province` (`prov_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_location_zipcode1` FOREIGN KEY (`loca_zipc_id`) REFERENCES `zipcode` (`zipc_code`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of location
-- ----------------------------
INSERT INTO `location` VALUES ('1', '3100', 'AT', '1', '1');

-- ----------------------------
-- Table structure for `log`
-- ----------------------------
DROP TABLE IF EXISTS `log`;
CREATE TABLE `log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `log_added` int(11) DEFAULT NULL COMMENT 'Timestamp',
  `log_type` int(11) DEFAULT NULL,
  `log_priority` int(11) DEFAULT NULL,
  `log_description` text,
  `log_ip` char(15) DEFAULT NULL,
  `log_url` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of log
-- ----------------------------

-- ----------------------------
-- Table structure for `login_log`
-- ----------------------------
DROP TABLE IF EXISTS `login_log`;
CREATE TABLE `login_log` (
  `lolo_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Login log id',
  `lolo_last_try` int(11) DEFAULT NULL COMMENT 'Specifies the last try to login\nTimestamp',
  `lolo_successfull` tinyint(1) DEFAULT NULL COMMENT 'Specifies wether a login was successfull or not',
  `lolo_ip` char(15) DEFAULT NULL COMMENT 'IP address of the client who tries to login',
  `lolo_login_id` varchar(60) DEFAULT NULL COMMENT 'If the login fails, this is the login id  otherwise null',
  `lolo_user_user_id` int(11) DEFAULT NULL COMMENT 'User',
  PRIMARY KEY (`lolo_id`),
  KEY `fk_login_log_user1` (`lolo_user_user_id`),
  CONSTRAINT `fk_login_log_user1` FOREIGN KEY (`lolo_user_user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of login_log
-- ----------------------------

-- ----------------------------
-- Table structure for `manufacturer`
-- ----------------------------
DROP TABLE IF EXISTS `manufacturer`;
CREATE TABLE `manufacturer` (
  `manu_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Manufacturer id',
  `manu_added` date DEFAULT NULL,
  `manu_logo_pict_id` int(11) NOT NULL COMMENT 'Logo picture',
  `manu_contact_code_id` int(11) NOT NULL COMMENT 'Contact detail',
  PRIMARY KEY (`manu_id`),
  KEY `fk_manufacturer_picture1` (`manu_logo_pict_id`),
  KEY `fk_manufacturer_contact_detail1` (`manu_contact_code_id`),
  CONSTRAINT `fk_manufacturer_contact_detail1` FOREIGN KEY (`manu_contact_code_id`) REFERENCES `contact_detail` (`code_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_manufacturer_picture1` FOREIGN KEY (`manu_logo_pict_id`) REFERENCES `picture` (`pict_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of manufacturer
-- ----------------------------

-- ----------------------------
-- Table structure for `menue`
-- ----------------------------
DROP TABLE IF EXISTS `menue`;
CREATE TABLE `menue` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(60) DEFAULT NULL,
  `menu_available` tinyint(1) DEFAULT NULL,
  `menu_order` int(11) DEFAULT NULL,
  `menu_menue_menu_id` int(11) DEFAULT NULL,
  `menu_module_modu_id` int(11) NOT NULL,
  PRIMARY KEY (`menu_id`),
  KEY `fk_menue_menue1` (`menu_menue_menu_id`),
  KEY `fk_menue_module1` (`menu_module_modu_id`),
  CONSTRAINT `fk_menue_menue1` FOREIGN KEY (`menu_menue_menu_id`) REFERENCES `menue` (`menu_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_menue_module1` FOREIGN KEY (`menu_module_modu_id`) REFERENCES `module` (`modu_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of menue
-- ----------------------------

-- ----------------------------
-- Table structure for `module`
-- ----------------------------
DROP TABLE IF EXISTS `module`;
CREATE TABLE `module` (
  `modu_id` int(11) NOT NULL AUTO_INCREMENT,
  `modu_name` varchar(60) DEFAULT NULL,
  `modu_description` varchar(60) DEFAULT NULL,
  `modu_added` date DEFAULT NULL,
  `modu_uid` int(11) DEFAULT NULL,
  `modu_system` tinyint(1) DEFAULT NULL,
  `modue_active` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`modu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of module
-- ----------------------------

-- ----------------------------
-- Table structure for `module_dependency`
-- ----------------------------
DROP TABLE IF EXISTS `module_dependency`;
CREATE TABLE `module_dependency` (
  `mode_id` int(11) NOT NULL AUTO_INCREMENT,
  `mode_uid` varchar(60) DEFAULT NULL,
  `mode_module_modu_id` int(11) NOT NULL,
  PRIMARY KEY (`mode_id`),
  KEY `fk_module_dependency_module1` (`mode_module_modu_id`),
  CONSTRAINT `fk_module_dependency_module1` FOREIGN KEY (`mode_module_modu_id`) REFERENCES `module` (`modu_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of module_dependency
-- ----------------------------

-- ----------------------------
-- Table structure for `order`
-- ----------------------------
DROP TABLE IF EXISTS `order`;
CREATE TABLE `order` (
  `orde_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Order id',
  `orde_firstname` varchar(60) DEFAULT NULL COMMENT 'Firstname for transport',
  `orde_lastname` varchar(60) DEFAULT NULL COMMENT 'Lastname for transport',
  `orde_address` varchar(100) DEFAULT NULL COMMENT 'Address for transport',
  `orde_zipcode` int(11) DEFAULT NULL COMMENT 'Zipcode for transport',
  `orde_city` varchar(60) DEFAULT NULL COMMENT 'City for transport',
  `orde_discount` int(11) DEFAULT NULL COMMENT 'Discount for the whole order',
  `orde_comment` varchar(100) DEFAULT NULL COMMENT 'Customer comment',
  `orde_order_date` date DEFAULT NULL COMMENT 'Specifies the date on which the customer ordered the products',
  `orde_delivery_date` date DEFAULT NULL COMMENT 'Specifies the date on which the customer received the products',
  `orde_country_coun_id` char(2) NOT NULL COMMENT 'Country',
  `orde_status_orst_id` int(11) NOT NULL COMMENT 'Order status',
  `orde_currency_curr_id` int(11) NOT NULL COMMENT 'Currency',
  `orde_payment_paym_id` int(11) NOT NULL COMMENT 'Payment',
  `orde_delivery_deli_id` int(11) NOT NULL,
  `orde_customer_cust_id` int(11) NOT NULL,
  PRIMARY KEY (`orde_id`),
  KEY `fk_order_country1` (`orde_country_coun_id`),
  KEY `fk_order_order_status1` (`orde_status_orst_id`),
  KEY `fk_order_currency1` (`orde_currency_curr_id`),
  KEY `fk_order_payment1` (`orde_payment_paym_id`),
  KEY `fk_order_delivery1` (`orde_delivery_deli_id`),
  KEY `fk_order_customer1` (`orde_customer_cust_id`),
  CONSTRAINT `fk_order_country1` FOREIGN KEY (`orde_country_coun_id`) REFERENCES `country` (`coun_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_order_currency1` FOREIGN KEY (`orde_currency_curr_id`) REFERENCES `currency` (`curr_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_order_customer1` FOREIGN KEY (`orde_customer_cust_id`) REFERENCES `customer` (`cust_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_order_delivery1` FOREIGN KEY (`orde_delivery_deli_id`) REFERENCES `delivery` (`deli_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_order_order_status1` FOREIGN KEY (`orde_status_orst_id`) REFERENCES `order_status` (`orst_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_order_payment1` FOREIGN KEY (`orde_payment_paym_id`) REFERENCES `payment` (`paym_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of order
-- ----------------------------

-- ----------------------------
-- Table structure for `order_has_order_row`
-- ----------------------------
DROP TABLE IF EXISTS `order_has_order_row`;
CREATE TABLE `order_has_order_row` (
  `order_row_orro_id` int(11) NOT NULL,
  `order_orde_id` int(11) NOT NULL,
  PRIMARY KEY (`order_row_orro_id`,`order_orde_id`),
  KEY `fk_order_row_has_order_order_row1` (`order_row_orro_id`),
  KEY `fk_order_row_has_order_order1` (`order_orde_id`),
  CONSTRAINT `fk_order_row_has_order_order1` FOREIGN KEY (`order_orde_id`) REFERENCES `order` (`orde_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_order_row_has_order_order_row1` FOREIGN KEY (`order_row_orro_id`) REFERENCES `order_row` (`orro_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of order_has_order_row
-- ----------------------------

-- ----------------------------
-- Table structure for `order_row`
-- ----------------------------
DROP TABLE IF EXISTS `order_row`;
CREATE TABLE `order_row` (
  `orro_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Order row id',
  `orro_position` int(11) DEFAULT NULL,
  `orro_unit` int(11) DEFAULT NULL COMMENT 'Number of product which are ordered',
  `orro_price` decimal(10,0) DEFAULT NULL COMMENT 'Price per unit',
  `orro_size` varchar(60) DEFAULT NULL COMMENT 'Size of the product',
  `orro_remark` varchar(60) DEFAULT NULL COMMENT 'Remark to the row',
  `orro_product_avpr_id` int(11) NOT NULL COMMENT 'Available product',
  PRIMARY KEY (`orro_id`),
  KEY `fk_order_row_available_product1` (`orro_product_avpr_id`),
  CONSTRAINT `fk_order_row_available_product1` FOREIGN KEY (`orro_product_avpr_id`) REFERENCES `available_product` (`avpr_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of order_row
-- ----------------------------

-- ----------------------------
-- Table structure for `order_status`
-- ----------------------------
DROP TABLE IF EXISTS `order_status`;
CREATE TABLE `order_status` (
  `orst_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Order status id',
  `orst_name` varchar(60) DEFAULT NULL COMMENT 'Name or an order status',
  `orst_description` varchar(255) DEFAULT NULL COMMENT 'Description of an order status',
  PRIMARY KEY (`orst_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of order_status
-- ----------------------------
INSERT INTO `order_status` VALUES ('1', 'Offen', 'Die Bestellung wurde noch nicht bearbeitet');
INSERT INTO `order_status` VALUES ('2', 'In Bearbeitung', 'Die Bestellung wird bearbeitet');
INSERT INTO `order_status` VALUES ('3', 'Versendet', 'Die Bestellung wurde versandt');

-- ----------------------------
-- Table structure for `partner`
-- ----------------------------
DROP TABLE IF EXISTS `partner`;
CREATE TABLE `partner` (
  `part_contact_code_id` int(11) NOT NULL,
  PRIMARY KEY (`part_contact_code_id`),
  KEY `fk_partner_contact_detail1` (`part_contact_code_id`),
  CONSTRAINT `fk_partner_contact_detail1` FOREIGN KEY (`part_contact_code_id`) REFERENCES `contact_detail` (`code_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of partner
-- ----------------------------

-- ----------------------------
-- Table structure for `password_request`
-- ----------------------------
DROP TABLE IF EXISTS `password_request`;
CREATE TABLE `password_request` (
  `pare_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Password request id',
  `pare_request_time` int(11) DEFAULT NULL COMMENT 'Specifies the time when the password code is requested\nTimestamp',
  `pare_request_code` char(128) DEFAULT NULL COMMENT 'The request code\nHash value with SHA512',
  `pare_ip` char(15) DEFAULT NULL COMMENT 'IP address of the user who requested',
  `pare_user_user_id` int(11) DEFAULT NULL COMMENT 'User\nIf user is null, then the request was not successfull',
  PRIMARY KEY (`pare_id`),
  KEY `fk_password_request_user1` (`pare_user_user_id`),
  CONSTRAINT `fk_password_request_user1` FOREIGN KEY (`pare_user_user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of password_request
-- ----------------------------

-- ----------------------------
-- Table structure for `payment`
-- ----------------------------
DROP TABLE IF EXISTS `payment`;
CREATE TABLE `payment` (
  `paym_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Payment id',
  `paym_payment_combination_paco_id` int(11) NOT NULL,
  PRIMARY KEY (`paym_id`),
  KEY `fk_payment_payment_combination1` (`paym_payment_combination_paco_id`),
  CONSTRAINT `fk_payment_payment_combination1` FOREIGN KEY (`paym_payment_combination_paco_id`) REFERENCES `payment_combination` (`paco_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of payment
-- ----------------------------

-- ----------------------------
-- Table structure for `payment_combination`
-- ----------------------------
DROP TABLE IF EXISTS `payment_combination`;
CREATE TABLE `payment_combination` (
  `paco_id` int(11) NOT NULL,
  `paco_payment_type_paty_id` int(11) NOT NULL,
  `paco_payment_method_pame_id` int(11) NOT NULL,
  PRIMARY KEY (`paco_id`),
  KEY `fk_payment_combination_payment_type1` (`paco_payment_type_paty_id`),
  KEY `fk_payment_combination_payment_method1` (`paco_payment_method_pame_id`),
  CONSTRAINT `fk_payment_combination_payment_method1` FOREIGN KEY (`paco_payment_method_pame_id`) REFERENCES `payment_method` (`pame_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_payment_combination_payment_type1` FOREIGN KEY (`paco_payment_type_paty_id`) REFERENCES `payment_type` (`paty_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of payment_combination
-- ----------------------------

-- ----------------------------
-- Table structure for `payment_entry`
-- ----------------------------
DROP TABLE IF EXISTS `payment_entry`;
CREATE TABLE `payment_entry` (
  `paen_id` int(11) NOT NULL,
  `paen_amount` decimal(10,0) DEFAULT NULL,
  `paen_date` date DEFAULT NULL,
  `paen_data` text,
  `paen_currency_curr_id` int(11) NOT NULL,
  `payment_type_paty_id` int(11) NOT NULL,
  `paypal_payment_papa_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`paen_id`),
  KEY `fk_payment_entry_currency1` (`paen_currency_curr_id`),
  KEY `fk_payment_entry_payment_type1` (`payment_type_paty_id`),
  KEY `fk_payment_entry_paypal_payment1` (`paypal_payment_papa_id`),
  CONSTRAINT `fk_payment_entry_currency1` FOREIGN KEY (`paen_currency_curr_id`) REFERENCES `currency` (`curr_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_payment_entry_payment_type1` FOREIGN KEY (`payment_type_paty_id`) REFERENCES `payment_method` (`pame_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_payment_entry_paypal_payment1` FOREIGN KEY (`paypal_payment_papa_id`) REFERENCES `paypal_payment` (`papa_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of payment_entry
-- ----------------------------

-- ----------------------------
-- Table structure for `payment_has_payment_entry`
-- ----------------------------
DROP TABLE IF EXISTS `payment_has_payment_entry`;
CREATE TABLE `payment_has_payment_entry` (
  `payment_paym_id` int(11) NOT NULL,
  `payment_entry_paen_id` int(11) NOT NULL,
  PRIMARY KEY (`payment_paym_id`,`payment_entry_paen_id`),
  KEY `fk_payment_has_payment_entry_payment1` (`payment_paym_id`),
  KEY `fk_payment_has_payment_entry_payment_entry1` (`payment_entry_paen_id`),
  CONSTRAINT `fk_payment_has_payment_entry_payment1` FOREIGN KEY (`payment_paym_id`) REFERENCES `payment` (`paym_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_payment_has_payment_entry_payment_entry1` FOREIGN KEY (`payment_entry_paen_id`) REFERENCES `payment_entry` (`paen_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of payment_has_payment_entry
-- ----------------------------

-- ----------------------------
-- Table structure for `payment_method`
-- ----------------------------
DROP TABLE IF EXISTS `payment_method`;
CREATE TABLE `payment_method` (
  `pame_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Payment type id',
  `pame_name` varchar(60) DEFAULT NULL COMMENT 'Name of the payment type',
  `pame_description` varchar(255) DEFAULT NULL COMMENT 'Description of the payment type',
  PRIMARY KEY (`pame_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of payment_method
-- ----------------------------
INSERT INTO `payment_method` VALUES ('1', 'Barzahlung', 'Barzahlung bei Abbholung');
INSERT INTO `payment_method` VALUES ('2', 'Kreditkarte', 'Zahlung mit Kreditkarte');
INSERT INTO `payment_method` VALUES ('3', 'Banküberweisung', 'Überweisung an ein Bankkonto');

-- ----------------------------
-- Table structure for `payment_type`
-- ----------------------------
DROP TABLE IF EXISTS `payment_type`;
CREATE TABLE `payment_type` (
  `paty_id` int(11) NOT NULL,
  `paty_name` varchar(60) DEFAULT NULL,
  `paty_description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`paty_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of payment_type
-- ----------------------------
INSERT INTO `payment_type` VALUES ('1', 'Barzahlung', 'Barzahlung bei Abholung');
INSERT INTO `payment_type` VALUES ('2', 'Vorauszahlung', 'Zahlung vor der Abholung/Lieferung');
INSERT INTO `payment_type` VALUES ('3', 'Teilzahlung', 'Zahlung erfolgt in 3 Schritten, Anzahlung, Teilzahlung und Schlusszahlung');
INSERT INTO `payment_type` VALUES ('4', 'Nachname', 'Zahlung bei der übergabe der Ware');

-- ----------------------------
-- Table structure for `paypal_payment`
-- ----------------------------
DROP TABLE IF EXISTS `paypal_payment`;
CREATE TABLE `paypal_payment` (
  `papa_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Paypal payment id',
  `papa_user` varchar(60) DEFAULT NULL COMMENT 'Paypal user which made a payment with paypal',
  PRIMARY KEY (`papa_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of paypal_payment
-- ----------------------------

-- ----------------------------
-- Table structure for `permission`
-- ----------------------------
DROP TABLE IF EXISTS `permission`;
CREATE TABLE `permission` (
  `perm_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Permission id',
  `perm_permission` int(11) DEFAULT NULL COMMENT 'Bitfield for permission',
  `perm_user_user_id` int(11) DEFAULT NULL COMMENT 'User',
  `perm_user_group_usgr_id` int(11) DEFAULT NULL COMMENT 'User group',
  `perm_module_modu_id` int(11) DEFAULT NULL COMMENT 'If this is null, then the general rights are defined by the perm_permission field',
  PRIMARY KEY (`perm_id`),
  KEY `fk_permission_user1` (`perm_user_user_id`),
  KEY `fk_permission_user_group1` (`perm_user_group_usgr_id`),
  KEY `fk_permission_module1` (`perm_module_modu_id`),
  CONSTRAINT `fk_permission_module1` FOREIGN KEY (`perm_module_modu_id`) REFERENCES `module` (`modu_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_permission_user1` FOREIGN KEY (`perm_user_user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_permission_user_group1` FOREIGN KEY (`perm_user_group_usgr_id`) REFERENCES `user_group` (`usgr_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of permission
-- ----------------------------
INSERT INTO `permission` VALUES ('1', '8', null, '1', null);

-- ----------------------------
-- Table structure for `person`
-- ----------------------------
DROP TABLE IF EXISTS `person`;
CREATE TABLE `person` (
  `pers_id` int(11) NOT NULL AUTO_INCREMENT,
  `pers_firstname` varchar(60) DEFAULT NULL,
  `pers_lastname` varchar(60) DEFAULT NULL,
  `pers_gender` char(1) DEFAULT NULL,
  `pers_birthday` date DEFAULT NULL,
  `pers_contact_code_id` int(11) NOT NULL,
  PRIMARY KEY (`pers_id`),
  KEY `fk_person_contact_detail1` (`pers_contact_code_id`),
  CONSTRAINT `fk_person_contact_detail1` FOREIGN KEY (`pers_contact_code_id`) REFERENCES `contact_detail` (`code_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of person
-- ----------------------------
INSERT INTO `person` VALUES ('1', 'Christian', 'Beikov', 'M', '1991-01-21', '1');

-- ----------------------------
-- Table structure for `photo_entry`
-- ----------------------------
DROP TABLE IF EXISTS `photo_entry`;
CREATE TABLE `photo_entry` (
  `phen_id` int(11) NOT NULL,
  `phen_text` varchar(255) DEFAULT NULL,
  `phen_builder` varchar(255) DEFAULT NULL,
  `phen_order` int(11) DEFAULT NULL,
  `phen_duration` decimal(10,0) DEFAULT NULL,
  `phen_photo_show_phsh_id` int(11) NOT NULL,
  `phen_picture_pict_id` int(11) DEFAULT NULL,
  `phen_available_product_avpr_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`phen_id`),
  KEY `fk_photo_entry_photo_show1` (`phen_photo_show_phsh_id`),
  KEY `fk_photo_entry_picture1` (`phen_picture_pict_id`),
  KEY `fk_photo_entry_available_product1` (`phen_available_product_avpr_id`),
  CONSTRAINT `fk_photo_entry_available_product1` FOREIGN KEY (`phen_available_product_avpr_id`) REFERENCES `available_product` (`avpr_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_photo_entry_photo_show1` FOREIGN KEY (`phen_photo_show_phsh_id`) REFERENCES `photo_show` (`phsh_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_photo_entry_picture1` FOREIGN KEY (`phen_picture_pict_id`) REFERENCES `picture` (`pict_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of photo_entry
-- ----------------------------

-- ----------------------------
-- Table structure for `photo_show`
-- ----------------------------
DROP TABLE IF EXISTS `photo_show`;
CREATE TABLE `photo_show` (
  `phsh_id` int(11) NOT NULL,
  `phsh_name` varchar(60) DEFAULT NULL,
  `phsh_description` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`phsh_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of photo_show
-- ----------------------------

-- ----------------------------
-- Table structure for `picture`
-- ----------------------------
DROP TABLE IF EXISTS `picture`;
CREATE TABLE `picture` (
  `pict_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Picture id',
  `pict_name` varchar(60) DEFAULT NULL COMMENT 'Name of a picture',
  `pict_description` varchar(255) DEFAULT NULL COMMENT 'Description of a picture',
  `pict_picture` binary(1) DEFAULT NULL COMMENT 'Binary data of a picture',
  `pict_owner` varchar(60) DEFAULT NULL COMMENT 'Owner of a picture',
  `pict_added` date DEFAULT NULL,
  `pict_status_enst_id` int(11) NOT NULL COMMENT 'Entry status',
  `pict_watermark_pict_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`pict_id`),
  KEY `fk_picture_entry_status1` (`pict_status_enst_id`),
  KEY `fk_picture_picture1` (`pict_watermark_pict_id`),
  CONSTRAINT `fk_picture_entry_status1` FOREIGN KEY (`pict_status_enst_id`) REFERENCES `entry_status` (`enst_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_picture_picture1` FOREIGN KEY (`pict_watermark_pict_id`) REFERENCES `picture` (`pict_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of picture
-- ----------------------------

-- ----------------------------
-- Table structure for `product`
-- ----------------------------
DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `prod_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Product id',
  `prod_name` varchar(60) DEFAULT NULL COMMENT 'Name of a product',
  `prod_description` varchar(255) DEFAULT NULL COMMENT 'Description of a product',
  `prod_subtitle` varchar(60) DEFAULT NULL COMMENT 'Subtitle of a product',
  `prod_tender` varchar(255) DEFAULT NULL COMMENT 'Tender of a product',
  `prod_sizeable` tinyint(1) DEFAULT NULL COMMENT 'Specifies wether a customer can choose the size of a product or not',
  `prod_min_size` varchar(60) DEFAULT NULL COMMENT 'Minimum size of a product\nFormat is Width x Height x Depth without the whitespaces',
  `prod_max_size` varchar(60) DEFAULT NULL COMMENT 'Maximum size of a product\nFormat is Width x Height x Depth without the whitespaces',
  `prod_default_size` varchar(60) DEFAULT NULL,
  `prod_weight` decimal(10,0) DEFAULT NULL,
  `prod_added` date DEFAULT NULL,
  `prod_status_enst_id` int(11) NOT NULL COMMENT 'Entry status',
  `prod_preview_pict_id` int(11) NOT NULL COMMENT 'Preview picture',
  `prod_manufacturer_manu_id` int(11) NOT NULL COMMENT 'Manufacturer',
  PRIMARY KEY (`prod_id`),
  KEY `fk_product_entry_status1` (`prod_status_enst_id`),
  KEY `fk_product_picture1` (`prod_preview_pict_id`),
  KEY `fk_product_manufacturer1` (`prod_manufacturer_manu_id`),
  CONSTRAINT `fk_product_entry_status1` FOREIGN KEY (`prod_status_enst_id`) REFERENCES `entry_status` (`enst_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_product_manufacturer1` FOREIGN KEY (`prod_manufacturer_manu_id`) REFERENCES `manufacturer` (`manu_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_product_picture1` FOREIGN KEY (`prod_preview_pict_id`) REFERENCES `picture` (`pict_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product
-- ----------------------------

-- ----------------------------
-- Table structure for `product_group`
-- ----------------------------
DROP TABLE IF EXISTS `product_group`;
CREATE TABLE `product_group` (
  `prgr_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Product group id',
  `prgr_name` varchar(60) DEFAULT NULL COMMENT 'Name of a product group',
  `prgr_description` varchar(255) DEFAULT NULL COMMENT 'Description of a product group',
  `prgr_available` tinyint(1) DEFAULT NULL COMMENT 'Specifies wether a product group is available or not',
  `prgr_available_from` date DEFAULT NULL COMMENT 'Specifies from when a product group is available',
  `prgr_available_to` date DEFAULT NULL COMMENT 'Specifies to when a product group is available',
  `prgr_added` date DEFAULT NULL,
  `prgr_preview_pict_id` int(11) NOT NULL COMMENT 'Preview picture',
  `prgr_group_prgr_id` int(11) DEFAULT NULL COMMENT 'Product group',
  PRIMARY KEY (`prgr_id`),
  KEY `fk_product_group_picture1` (`prgr_preview_pict_id`),
  KEY `fk_product_group_product_group1` (`prgr_group_prgr_id`),
  CONSTRAINT `fk_product_group_picture1` FOREIGN KEY (`prgr_preview_pict_id`) REFERENCES `picture` (`pict_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_product_group_product_group1` FOREIGN KEY (`prgr_group_prgr_id`) REFERENCES `product_group` (`prgr_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product_group
-- ----------------------------

-- ----------------------------
-- Table structure for `product_group_has_attribute_value`
-- ----------------------------
DROP TABLE IF EXISTS `product_group_has_attribute_value`;
CREATE TABLE `product_group_has_attribute_value` (
  `product_group_prgr_id` int(11) NOT NULL,
  `attribute_value_atva_id` int(11) NOT NULL,
  PRIMARY KEY (`product_group_prgr_id`,`attribute_value_atva_id`),
  KEY `fk_product_group_has_attribute_value_product_group1` (`product_group_prgr_id`),
  KEY `fk_product_group_has_attribute_value_attribute_value1` (`attribute_value_atva_id`),
  CONSTRAINT `fk_product_group_has_attribute_value_attribute_value1` FOREIGN KEY (`attribute_value_atva_id`) REFERENCES `attribute_value` (`atva_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_product_group_has_attribute_value_product_group1` FOREIGN KEY (`product_group_prgr_id`) REFERENCES `product_group` (`prgr_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product_group_has_attribute_value
-- ----------------------------

-- ----------------------------
-- Table structure for `product_group_has_product`
-- ----------------------------
DROP TABLE IF EXISTS `product_group_has_product`;
CREATE TABLE `product_group_has_product` (
  `product_group_prgr_id` int(11) NOT NULL,
  `product_prod_id` int(11) NOT NULL,
  PRIMARY KEY (`product_group_prgr_id`,`product_prod_id`),
  KEY `fk_product_group_has_product_product_group1` (`product_group_prgr_id`),
  KEY `fk_product_group_has_product_product1` (`product_prod_id`),
  CONSTRAINT `fk_product_group_has_product_product1` FOREIGN KEY (`product_prod_id`) REFERENCES `product` (`prod_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_product_group_has_product_product_group1` FOREIGN KEY (`product_group_prgr_id`) REFERENCES `product_group` (`prgr_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product_group_has_product
-- ----------------------------

-- ----------------------------
-- Table structure for `product_has_attribute_value`
-- ----------------------------
DROP TABLE IF EXISTS `product_has_attribute_value`;
CREATE TABLE `product_has_attribute_value` (
  `product_prod_id` int(11) NOT NULL,
  `attribute_value_atva_id` int(11) NOT NULL,
  PRIMARY KEY (`product_prod_id`,`attribute_value_atva_id`),
  KEY `fk_product_has_attribute_value_product1` (`product_prod_id`),
  KEY `fk_product_has_attribute_value_attribute_value1` (`attribute_value_atva_id`),
  CONSTRAINT `fk_product_has_attribute_value_attribute_value1` FOREIGN KEY (`attribute_value_atva_id`) REFERENCES `attribute_value` (`atva_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_product_has_attribute_value_product1` FOREIGN KEY (`product_prod_id`) REFERENCES `product` (`prod_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product_has_attribute_value
-- ----------------------------

-- ----------------------------
-- Table structure for `product_has_picture`
-- ----------------------------
DROP TABLE IF EXISTS `product_has_picture`;
CREATE TABLE `product_has_picture` (
  `product_prod_id` int(11) NOT NULL,
  `picture_pict_id` int(11) NOT NULL,
  PRIMARY KEY (`product_prod_id`,`picture_pict_id`),
  KEY `fk_product_has_picture_product1` (`product_prod_id`),
  KEY `fk_product_has_picture_picture1` (`picture_pict_id`),
  CONSTRAINT `fk_product_has_picture_picture1` FOREIGN KEY (`picture_pict_id`) REFERENCES `picture` (`pict_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_product_has_picture_product1` FOREIGN KEY (`product_prod_id`) REFERENCES `product` (`prod_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product_has_picture
-- ----------------------------

-- ----------------------------
-- Table structure for `project`
-- ----------------------------
DROP TABLE IF EXISTS `project`;
CREATE TABLE `project` (
  `proj_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Project id',
  `proj_name` varchar(60) DEFAULT NULL COMMENT 'Name of a project',
  `proj_subtitle` varchar(60) DEFAULT NULL COMMENT 'Subtitle of a project',
  `proj_description` varchar(255) DEFAULT NULL COMMENT 'Description of a project',
  `proj_from` date DEFAULT NULL COMMENT 'Specifies when a project started',
  `proj_to` date DEFAULT NULL COMMENT 'Specifies when a project ended',
  `proj_added` date DEFAULT NULL,
  `proj_preview_pict_id` int(11) NOT NULL COMMENT 'Preview picture',
  `proj_status_enst_id` int(11) NOT NULL COMMENT 'Entry status',
  PRIMARY KEY (`proj_id`),
  KEY `fk_project_picture` (`proj_preview_pict_id`),
  KEY `fk_project_entry_status1` (`proj_status_enst_id`),
  CONSTRAINT `fk_project_entry_status1` FOREIGN KEY (`proj_status_enst_id`) REFERENCES `entry_status` (`enst_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_project_picture` FOREIGN KEY (`proj_preview_pict_id`) REFERENCES `picture` (`pict_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of project
-- ----------------------------

-- ----------------------------
-- Table structure for `project_has_person`
-- ----------------------------
DROP TABLE IF EXISTS `project_has_person`;
CREATE TABLE `project_has_person` (
  `project_proj_id` int(11) NOT NULL,
  `person_pers_id` int(11) NOT NULL,
  PRIMARY KEY (`project_proj_id`,`person_pers_id`),
  KEY `fk_project_has_person_project1` (`project_proj_id`),
  KEY `fk_project_has_person_person1` (`person_pers_id`),
  CONSTRAINT `fk_project_has_person_person1` FOREIGN KEY (`person_pers_id`) REFERENCES `person` (`pers_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_project_has_person_project1` FOREIGN KEY (`project_proj_id`) REFERENCES `project` (`proj_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of project_has_person
-- ----------------------------

-- ----------------------------
-- Table structure for `project_has_picture`
-- ----------------------------
DROP TABLE IF EXISTS `project_has_picture`;
CREATE TABLE `project_has_picture` (
  `project_proj_id` int(11) NOT NULL,
  `picture_pict_id` int(11) NOT NULL,
  PRIMARY KEY (`project_proj_id`,`picture_pict_id`),
  KEY `fk_project_has_picture_project1` (`project_proj_id`),
  KEY `fk_project_has_picture_picture1` (`picture_pict_id`),
  CONSTRAINT `fk_project_has_picture_picture1` FOREIGN KEY (`picture_pict_id`) REFERENCES `picture` (`pict_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_project_has_picture_project1` FOREIGN KEY (`project_proj_id`) REFERENCES `project` (`proj_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of project_has_picture
-- ----------------------------

-- ----------------------------
-- Table structure for `province`
-- ----------------------------
DROP TABLE IF EXISTS `province`;
CREATE TABLE `province` (
  `prov_id` int(11) NOT NULL,
  `prov_name` varchar(60) DEFAULT NULL,
  `prov_code` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`prov_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of province
-- ----------------------------
INSERT INTO `province` VALUES ('1', 'Niederösterreich', 'NOE');

-- ----------------------------
-- Table structure for `quantity_discount`
-- ----------------------------
DROP TABLE IF EXISTS `quantity_discount`;
CREATE TABLE `quantity_discount` (
  `qudi_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Quantity discount id',
  `qudi_from_quantity` int(11) DEFAULT NULL COMMENT 'Specifies at which number of products a discount is possible',
  `qudi_discount` int(11) DEFAULT NULL COMMENT 'Value of the discount in %',
  `qudi_from` date DEFAULT NULL COMMENT 'Date from when a discount begins',
  `qudi_to` date DEFAULT NULL COMMENT 'Date to when a discount lasts',
  `qudi_added` date DEFAULT NULL,
  `qudi_product_avpr_id` int(11) NOT NULL COMMENT 'Available product',
  PRIMARY KEY (`qudi_id`),
  KEY `fk_quantity_discount_available_product1` (`qudi_product_avpr_id`),
  CONSTRAINT `fk_quantity_discount_available_product1` FOREIGN KEY (`qudi_product_avpr_id`) REFERENCES `available_product` (`avpr_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of quantity_discount
-- ----------------------------

-- ----------------------------
-- Table structure for `session`
-- ----------------------------
DROP TABLE IF EXISTS `session`;
CREATE TABLE `session` (
  `sess_id` char(32) NOT NULL COMMENT 'Session id',
  `sess_session_lock` char(128) DEFAULT NULL COMMENT 'Lock value for secure session\nHash value with SHA512',
  `sess_last_update` int(11) DEFAULT NULL COMMENT 'Specifies the last time a user requested for something\nTimestamp',
  `sess_start` int(11) DEFAULT NULL COMMENT 'Specifies the time when a session started\nTimestamp',
  `sess_value` text COMMENT 'The value of the session which is encrypted',
  `sess_ip` char(15) DEFAULT NULL COMMENT 'IP address of the user of the session',
  `sess_cookie_id` char(128) DEFAULT NULL COMMENT 'Identifier for the cookie\nHash value with SHA512',
  `sess_user_user_id` int(11) DEFAULT NULL COMMENT 'User\nIf user is null, then it is a guest session',
  PRIMARY KEY (`sess_id`),
  KEY `fk_session_user1` (`sess_user_user_id`),
  CONSTRAINT `fk_session_user1` FOREIGN KEY (`sess_user_user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of session
-- ----------------------------

-- ----------------------------
-- Table structure for `tax`
-- ----------------------------
DROP TABLE IF EXISTS `tax`;
CREATE TABLE `tax` (
  `tax_id` int(11) NOT NULL,
  `tax_value` decimal(10,0) DEFAULT NULL,
  `country_coun_id` char(2) NOT NULL,
  `province_prov_id` int(11) NOT NULL,
  `tax_class_tacl_id` int(11) NOT NULL,
  PRIMARY KEY (`tax_id`),
  KEY `fk_tax_country1` (`country_coun_id`),
  KEY `fk_tax_province1` (`province_prov_id`),
  KEY `fk_tax_tax_class1` (`tax_class_tacl_id`),
  CONSTRAINT `fk_tax_country1` FOREIGN KEY (`country_coun_id`) REFERENCES `country` (`coun_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_tax_province1` FOREIGN KEY (`province_prov_id`) REFERENCES `province` (`prov_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_tax_tax_class1` FOREIGN KEY (`tax_class_tacl_id`) REFERENCES `tax_class` (`tacl_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tax
-- ----------------------------

-- ----------------------------
-- Table structure for `tax_class`
-- ----------------------------
DROP TABLE IF EXISTS `tax_class`;
CREATE TABLE `tax_class` (
  `tacl_id` int(11) NOT NULL,
  `tacl_name` varchar(60) DEFAULT NULL,
  `tacl_description` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`tacl_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tax_class
-- ----------------------------

-- ----------------------------
-- Table structure for `test`
-- ----------------------------
DROP TABLE IF EXISTS `test`;
CREATE TABLE `test` (
  `test_decimal` decimal(30,10) DEFAULT NULL,
  `test_date` date DEFAULT NULL,
  `test_time` time DEFAULT NULL,
  `test_timestamp` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `test_datetime` datetime DEFAULT NULL,
  `test_blob` blob
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of test
-- ----------------------------
INSERT INTO `test` VALUES ('156186131131116.2132133100', '2010-06-18', '21:10:01', '2010-06-17 21:11:22', '2010-06-19 21:10:09', 0xFFD8FFE000104A46494600010201004800480000FFE10FD04578696600004D4D002A000000080007011200030000000100010000011A00050000000100000062011B0005000000010000006A012800030000000100020000013100020000001C0000007201320002000000140000008E8769000400000001000000A4000000D0000AFC8000002710000AFC800000271041646F62652050686F746F73686F70204353342057696E646F777300323030393A31313A31312030303A34343A33370000000003A00100030000000100010000A0020004000000010000008DA003000400000001000000CC0000000000000006010300030000000100060000011A0005000000010000011E011B0005000000010000012601280003000000010002000002010004000000010000012E020200040000000100000E9A0000000000000048000000010000004800000001FFD8FFE000104A46494600010200004800480000FFED000C41646F62655F434D0001FFEE000E41646F626500648000000001FFDB0084000C08080809080C09090C110B0A0B11150F0C0C0F1518131315131318110C0C0C0C0C0C110C0C0C0C0C0C0C0C0C0C0C0C0C0C0C0C0C0C0C0C0C0C0C0C0C0C0C0C010D0B0B0D0E0D100E0E10140E0E0E14140E0E0E0E14110C0C0C0C0C11110C0C0C0C0C0C110C0C0C0C0C0C0C0C0C0C0C0C0C0C0C0C0C0C0C0C0C0C0C0C0C0C0C0CFFC000110800A0006F03012200021101031101FFDD00040007FFC4013F0000010501010101010100000000000000030001020405060708090A0B0100010501010101010100000000000000010002030405060708090A0B1000010401030204020507060805030C33010002110304211231054151611322718132061491A1B14223241552C16233347282D14307259253F0E1F163733516A2B283264493546445C2A3743617D255E265F2B384C3D375E3F3462794A485B495C4D4E4F4A5B5C5D5E5F55666768696A6B6C6D6E6F637475767778797A7B7C7D7E7F711000202010204040304050607070605350100021103213112044151617122130532819114A1B14223C152D1F0332462E1728292435315637334F1250616A2B283072635C2D2449354A317644555367465E2F2B384C3D375E3F34694A485B495C4D4E4F4A5B5C5D5E5F55666768696A6B6C6D6E6F62737475767778797A7B7C7FFDA000C03010002110311003F00F2F00F215AAEBD84B8F079F22874B376A740275F38D159B2B76D76D11B7513AF64C25780D673E4099FF679A7630813BA02232BD3CCEA64E9CAB55631DE5A1A483CC0EDE491214236D3F4C93DCCF1E699D44700FC4ADEC6E8CF7ED7069734E9234208FDE0B447D5FAF42E6C0E60F8A8CE5019460243C61AC83C27F4A7E2BA4CFE84D6FBAAE7C162D956D96B87B81FB9384ED64B118B4783AE8516A6EE727B5B22620851ADEE619FC138DD2EC5202638B60DEAE9F2527D236A6C6C9DCED8FF00929E55A195E9C955CF17153BD0380E0390510039D6800985020800A97264A78042B0068E0CE5C52240DF67FFD0F3BC566E6869D0920CF7F056DB8EF12CEC75746BA850E958BEBD827E8F7F92ED7A6F45C4DAD7DA0B8FEE8D000ABE49D3671E325E7BA7F46BF26035B23B185D1E1FD57A59B5D7998EC16DE3D555436D6C0D03C9590C006AA194C96C47188B45B894D436D4C0D111C73F142B69D0F60AFD9B6156B20B60F74C650E464D31AF65CE759C42D7FAAD1A185D7DC06D92163F52C537D6E634EA3C54B8F761CA3421E3DF49120FFA8558B60F92D1CAA322976DB1A44FD19EEA838013E1C85686AD23A1D98EF2C7077822E4DBEA42AF67D113E3A29C40129BC22C1658E690C72C77A15774E3829BBA90E0A256446AFF00FFD1E47EAFB41708E40FC57718640AC2E07A0DE19925BD8C10BB8C67C0D35F254F37CCE8603E974EB784536E8A955B9CED4F1D95A6D6481C2880662C5DB9FAA1BEA2049E3BCA3D9632A6FE52B9AEA5D4BAB65D86AC370A681A3AD76807F293846D04D06DE6E75141DA0EF7771E0B29F996BDE5CDAC9677F1537DDD23A7D4D6DD78BAE7FD27587DC49EEDABDDE9B14B1F3B172096D7EEDBA6D13A7C44052015D18C9E2D2F5ECD3CFC7FB562B8367734173679042E7B0B1BED79B463BF40EB06EF91F735768FC72C01F11BBB2E72EC738BD6AABEA692DDDBCB4788E42960742183243D425E3AB67AEE19CCA725D5340AF15AD76331A00F633D971FFAA5CC335685DEED27A7B32634AE924FF29AE13637FE92E06B22004B19D293CC400A3B58D59C243BA5B804B781F34FDD8C1008D5FFD2F3BC0B4D795599E4ED2BB4C6EB1898F5B4DCFF00744168D4CF8185C352CB5F6454D2E7B46F8689236FB9C5757D17ECD5503236EFB48DDEED79FDD55F3446EDBE5C9A203A4DFAD5439FB6AA2C76BD9A56963F57F546B2D27B1E5737D43AF751358FB3631B6AB496D77ED2E6970F6EC631BB7F3BFC258B49F875D74B771FD396B4D8341B5C47BDACDBEEFA6A394285D0668CEEC592EE5E5CFA3D5074EEB06CAECBDC04ED63493F3FDE3FD56FF36B53A65EEB31CD561DC418286582AB4B0896932134321EEE464744E976E6B72E90FA402D71A376E6B9EDF6FAB1F4B72D6A318979B6C1B675D7E913FCA572AA5A1A1CC13A68A6F60DB11089913A223088D6B7D5A1903DA4470B0731E5B94C7B7F31E1C5745700345839F5CBEC8F2852418B33A06BB9BD3DE5E47A4E36358DEEDA9C5CF61FED2F3A07405751D43EB60182EC0C6A1CCB8B7D3B5EE20B6636EEAFF3972FC2931C4806FBB0E5C9C4456B4196F0A049267C12292918087FFFD3F37AB2AEC7B996D2ED9657C1F107E935DFC9DAB7FA18AF3311F493B5C2440EC09276AE6AC90E20F6D168743CEFB2666D3F46DD3E63E8FF009CA398B8B3619F0CC03B5D3D862E2DD5D4DA5AE736968FA0D76D040F1DBF495D6D01ACDA06A7943C6BDAF60737C15CA21C49239E15524F57404746960582BBF6CC4F2AF65B27DCDE4F7543318CC6C8169D1A5A1D274123E9236475BC5189157BED70FD1803DC4F82406A829B1332CADE31EE8DCE9D8E1DF6FD20AD3AED095958755A1EDBF209B2E008686886B6447B7F39DFD77A35F94EAC4BF6B1BFCA30891AA84B44973839A4B7B72B233049769AC2D5699607BF40F041F90DCD599926449EE13E05872BC7755AF665B9C068F12A9483DD7456B6C01D6B091B496923982BB7C3C2E91D57A2E3D9938B45F35377935B43B7191B7D5AC32D6ED7FE729F8A9A7C2F93C265B3F59BA1B7A46633D125D8792DF52871D4883B6DA8FEF7A6B1BCFF00DC9C1697FFD4F35B9BFA6703DCC21905AEF6987375047970AE675419679CF2AABE374F8A644D85F3152FABD5747EAD4DFED6121E1A0B9A74877D176D5D0517CB66785E6F8D90EC7B9B756756F3E63F39ABB2E9DD46BB6B6BC3A58FEFE0A0CB0A361B787358A2EC643DAE0DDC37693B4890509B632906C780DF002265446F78DCC87103DB3C2CE7E1E6596175AEDFE43411FBA9819E26E5AB62FEA96BC966303A731FF7E7FF00DF1889D33A797DDF6CCA3EABC68CDDC09FDC6A007B71DD552F610CB4ED691C4F9B96DB5BB180711A6BE48DE949991B008B31D0DD381C7DCB1B2DC1AD99E1BAAD3CD786D7120F89F8AC6B4BAFB8543BEAE8F009D0142DAD90DE8B538BBB1087082F04C7E2B5FEA767018D93D31F06CA8EE603DDA4ED77FD2FFAB426531501D950A2BB69EBD88EA1A4DB6BFD3DA34DCD768F6FF9BEF4F06D64A3403ABF5BFA63B33A2305403ADC62EBAB8EE07F38D6FF0059ABCDB4E7B2F66C96B5AF0C6896D6D0C6F9C7B579AE6746189F5A99D35E269B322ADBFF0017739AE0DFC54C366B1DCBFFD5E17ABB60B08FCE747DC157E9EC6599F8ED78058FB1AD20EB20908FD62C9B6967F59C7F204BA257BBAB623639B98DF9970FFC8A8A1A4033663794D3E9B4B2AAD829F459B5A34606B482DECF6FB7DCC543AAF4D665B43B1E9F46EAE7610035AEFE4591F47FAEB66CC6DECDC3DAE6999EC1C7BFF51C9EA639ECDCCB1CC2DD1CD26435DFB85349B14A88A361E36ABEEC6B4D368757637E956EE47FE49BFD557ABB9AF20E8656C753E9FF00B4AAF42C817D6D73AAB4000877E6B7FA8F5CA13938AE2CB012D69227C08EC54662D886434EE57E95808780769060F88FDD53BAD6C174FC96451D4AB83243639928193D62A73F65336DA740DAF5FF00A9404755C67D93F50CA6804CE83940E9153ED0EC8708161DAC9FDD1DFF00B4874F4ACBCB70B337F455CCFA4DFA47E2B769A5AC6B58D0001F44760027134282D8C75B2C760DB0070B43A1F4C6B1EEEAD68F786B998608D40768FBBFB4A38784ECBBC567F9B026D3E5FBBFDA5BB79686863406B5A00681D80E0238C59B599A7C3A753BB476075AD1FCA93F72A999F55F072FAAD5D56F6B85F53D8EADED7449A8B7D36399F25A78ECDD6974709CB9C728069D03F5F8A9C96B016FFFD6E03A9B83B35ADFDC66BE4795B9F53BA79B3370B208D3D773BE55565DFF0049EF62E6CD86DBADBCEA5E49F9765E97F55705B8FD370DF1AFA333FCAB3DCE2A33A001906B225E859EDD0EA382836B2DA6C1752371FCE67EF347FDFDA8A0A41E340E3047D13E098BD1B5FEADF6380036B03076FE51FED2E7BAAD4D6E73C11EDB65F1C6B2B5FD4CDB722CAB08B19638975975A3735A3F35AD67B772A5D631AE157AE47E968DAF7C0D098DB6B75FCDB99EE67F513640D2FC668EBD5C0B70F185BFA5ADAE69EE44ABF463E331BFA26B5806BED00293AA6DCCD383C2036ABAA30D32DF02A3B6C506CEEDDA81A782B38D53DE43583738FF00AC955E8618F72D7C6C7634FA27E9B9A0DB1DE4FD071FCDAD8888DF92C9CC443AB878ACC5C7DADD5EEF73DDE250AC3B8A8D0FF4ABD0E93C78FF005548B83B5F156214346A4EC9B3AA5C7647C4EA8347BAC73C76B9F3F00E56187686AACD2C6376B068497BBE6497245517FFD7E1A8C123098488373B43E558FF00BFDBEC5EA58748A31D940E2A6860FEC885C4B9A3D4E9D4861F4582A07CC1735EFF00F3BF48BB4AB2EAB498D09ECA1259A31AD9B8D50C8786565D3C11AF879A931D23449ED6BA091B834C96F8C20A45D3B04065D7DA0FAB926403CB583E8CA25A1CD782ED46BCEA083F498EFDE6A336EDC4BF99FA5F14AC13C708A9C67F49A2BB67189A6A76A2BFA4D063DC19CFB541D836BBE806BE3B891FF5416B31DB1F074463EA3C86B0EBE3C1FF00CE534C02F19643C5E78556D77D75BD85BB883C1E275FE4AD16BE6D0D00BEDB4EE654380D1FE16E77FA36AB5663E4328D0B5AF8833240F12D4F894D18ED71DCEB6C7EAFB0B609FDD6FF0025AD4631A54E7C492AA4304BA09FDE8FFA80A560260711C0EFF1727361EC23F12A1BBC13A98CB17DC2B69DFA6C1B8FC0213458314BA3F49B341FCA8FFC926C8AFD52C1BA1B2378F1683308D3EDFC6112801FFFD0E6BEAA75065F935E3653FDF4C3AA275DC072DFFADED5DC3A8AEC1BDA60F621793E0E43B13369C96FF837827E07DAEFFA2BD4B12C0581CDD5AED7451486A3C596074F24F5BEEA4C3BDC3C55DAAD6D8DD39EEAB820F293416191C25494EF26A7EF1F40F3E48AD7CF983F44A80707B60F7EC81B8D0EDAEFE69DC1F029213DED81B8723956EA1037772156DC1CC2D3DC687B2B20FB40F2494AB4CE9D95525CD3A9D1597EA09F82AEE829215208E534A1905A6427DE9255F9CA72873AA79D5253FFD9FFED14A050686F746F73686F7020332E30003842494D0425000000000010000000000000000000000000000000003842494D03ED000000000010004800000001000200480000000100023842494D042600000000000E000000000000000000003F8000003842494D040D000000000004000000783842494D04190000000000040000001E3842494D03F3000000000009000000000000000001003842494D271000000000000A000100000000000000023842494D03F5000000000048002F66660001006C66660006000000000001002F6666000100A1999A0006000000000001003200000001005A00000006000000000001003500000001002D000000060000000000013842494D03F80000000000700000FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF03E800000000FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF03E800000000FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF03E800000000FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF03E800003842494D040000000000000200013842494D0402000000000004000000003842494D043000000000000201013842494D042D0000000000060001000000023842494D0408000000000010000000010000024000000240000000003842494D041E000000000004000000003842494D041A00000000034B000000060000000000000000000000CC0000008D0000000B0055006E00620065006E0061006E006E0074002D003100000001000000000000000000000000000000000000000100000000000000000000008D000000CC00000000000000000000000000000000010000000000000000000000000000000000000010000000010000000000006E756C6C0000000200000006626F756E64734F626A6300000001000000000000526374310000000400000000546F70206C6F6E6700000000000000004C6566746C6F6E67000000000000000042746F6D6C6F6E67000000CC00000000526768746C6F6E670000008D00000006736C69636573566C4C73000000014F626A6300000001000000000005736C6963650000001200000007736C69636549446C6F6E67000000000000000767726F757049446C6F6E6700000000000000066F726967696E656E756D0000000C45536C6963654F726967696E0000000D6175746F47656E6572617465640000000054797065656E756D0000000A45536C6963655479706500000000496D672000000006626F756E64734F626A6300000001000000000000526374310000000400000000546F70206C6F6E6700000000000000004C6566746C6F6E67000000000000000042746F6D6C6F6E67000000CC00000000526768746C6F6E670000008D0000000375726C54455854000000010000000000006E756C6C54455854000000010000000000004D7367655445585400000001000000000006616C74546167544558540000000100000000000E63656C6C54657874497348544D4C626F6F6C010000000863656C6C546578745445585400000001000000000009686F727A416C69676E656E756D0000000F45536C696365486F727A416C69676E0000000764656661756C740000000976657274416C69676E656E756D0000000F45536C69636556657274416C69676E0000000764656661756C740000000B6267436F6C6F7254797065656E756D0000001145536C6963654247436F6C6F7254797065000000004E6F6E6500000009746F704F75747365746C6F6E67000000000000000A6C6566744F75747365746C6F6E67000000000000000C626F74746F6D4F75747365746C6F6E67000000000000000B72696768744F75747365746C6F6E6700000000003842494D042800000000000C000000023FF00000000000003842494D0414000000000004000000023842494D040C000000000EB6000000010000006F000000A0000001500000D20000000E9A00180001FFD8FFE000104A46494600010200004800480000FFED000C41646F62655F434D0001FFEE000E41646F626500648000000001FFDB0084000C08080809080C09090C110B0A0B11150F0C0C0F1518131315131318110C0C0C0C0C0C110C0C0C0C0C0C0C0C0C0C0C0C0C0C0C0C0C0C0C0C0C0C0C0C0C0C0C0C010D0B0B0D0E0D100E0E10140E0E0E14140E0E0E0E14110C0C0C0C0C11110C0C0C0C0C0C110C0C0C0C0C0C0C0C0C0C0C0C0C0C0C0C0C0C0C0C0C0C0C0C0C0C0C0CFFC000110800A0006F03012200021101031101FFDD00040007FFC4013F0000010501010101010100000000000000030001020405060708090A0B0100010501010101010100000000000000010002030405060708090A0B1000010401030204020507060805030C33010002110304211231054151611322718132061491A1B14223241552C16233347282D14307259253F0E1F163733516A2B283264493546445C2A3743617D255E265F2B384C3D375E3F3462794A485B495C4D4E4F4A5B5C5D5E5F55666768696A6B6C6D6E6F637475767778797A7B7C7D7E7F711000202010204040304050607070605350100021103213112044151617122130532819114A1B14223C152D1F0332462E1728292435315637334F1250616A2B283072635C2D2449354A317644555367465E2F2B384C3D375E3F34694A485B495C4D4E4F4A5B5C5D5E5F55666768696A6B6C6D6E6F62737475767778797A7B7C7FFDA000C03010002110311003F00F2F00F215AAEBD84B8F079F22874B376A740275F38D159B2B76D76D11B7513AF64C25780D673E4099FF679A7630813BA02232BD3CCEA64E9CAB55631DE5A1A483CC0EDE491214236D3F4C93DCCF1E699D44700FC4ADEC6E8CF7ED7069734E9234208FDE0B447D5FAF42E6C0E60F8A8CE5019460243C61AC83C27F4A7E2BA4CFE84D6FBAAE7C162D956D96B87B81FB9384ED64B118B4783AE8516A6EE727B5B22620851ADEE619FC138DD2EC5202638B60DEAE9F2527D236A6C6C9DCED8FF00929E55A195E9C955CF17153BD0380E0390510039D6800985020800A97264A78042B0068E0CE5C52240DF67FFD0F3BC566E6869D0920CF7F056DB8EF12CEC75746BA850E958BEBD827E8F7F92ED7A6F45C4DAD7DA0B8FEE8D000ABE49D3671E325E7BA7F46BF26035B23B185D1E1FD57A59B5D7998EC16DE3D555436D6C0D03C9590C006AA194C96C47188B45B894D436D4C0D111C73F142B69D0F60AFD9B6156B20B60F74C650E464D31AF65CE759C42D7FAAD1A185D7DC06D92163F52C537D6E634EA3C54B8F761CA3421E3DF49120FFA8558B60F92D1CAA322976DB1A44FD19EEA838013E1C85686AD23A1D98EF2C7077822E4DBEA42AF67D113E3A29C40129BC22C1658E690C72C77A15774E3829BBA90E0A256446AFF00FFD1E47EAFB41708E40FC57718640AC2E07A0DE19925BD8C10BB8C67C0D35F254F37CCE8603E974EB784536E8A955B9CED4F1D95A6D6481C2880662C5DB9FAA1BEA2049E3BCA3D9632A6FE52B9AEA5D4BAB65D86AC370A681A3AD76807F293846D04D06DE6E75141DA0EF7771E0B29F996BDE5CDAC9677F1537DDD23A7D4D6DD78BAE7FD27587DC49EEDABDDE9B14B1F3B172096D7EEDBA6D13A7C44052015D18C9E2D2F5ECD3CFC7FB562B8367734173679042E7B0B1BED79B463BF40EB06EF91F735768FC72C01F11BBB2E72EC738BD6AABEA692DDDBCB4788E42960742183243D425E3AB67AEE19CCA725D5340AF15AD76331A00F633D971FFAA5CC335685DEED27A7B32634AE924FF29AE13637FE92E06B22004B19D293CC400A3B58D59C243BA5B804B781F34FDD8C1008D5FFD2F3BC0B4D795599E4ED2BB4C6EB1898F5B4DCFF00744168D4CF8185C352CB5F6454D2E7B46F8689236FB9C5757D17ECD5503236EFB48DDEED79FDD55F3446EDBE5C9A203A4DFAD5439FB6AA2C76BD9A56963F57F546B2D27B1E5737D43AF751358FB3631B6AB496D77ED2E6970F6EC631BB7F3BFC258B49F875D74B771FD396B4D8341B5C47BDACDBEEFA6A394285D0668CEEC592EE5E5CFA3D5074EEB06CAECBDC04ED63493F3FDE3FD56FF36B53A65EEB31CD561DC418286582AB4B0896932134321EEE464744E976E6B72E90FA402D71A376E6B9EDF6FAB1F4B72D6A318979B6C1B675D7E913FCA572AA5A1A1CC13A68A6F60DB11089913A223088D6B7D5A1903DA4470B0731E5B94C7B7F31E1C5745700345839F5CBEC8F2852418B33A06BB9BD3DE5E47A4E36358DEEDA9C5CF61FED2F3A07405751D43EB60182EC0C6A1CCB8B7D3B5EE20B6636EEAFF3972FC2931C4806FBB0E5C9C4456B4196F0A049267C12292918087FFFD3F37AB2AEC7B996D2ED9657C1F107E935DFC9DAB7FA18AF3311F493B5C2440EC09276AE6AC90E20F6D168743CEFB2666D3F46DD3E63E8FF009CA398B8B3619F0CC03B5D3D862E2DD5D4DA5AE736968FA0D76D040F1DBF495D6D01ACDA06A7943C6BDAF60737C15CA21C49239E15524F57404746960582BBF6CC4F2AF65B27DCDE4F7543318CC6C8169D1A5A1D274123E9236475BC5189157BED70FD1803DC4F82406A829B1332CADE31EE8DCE9D8E1DF6FD20AD3AED095958755A1EDBF209B2E008686886B6447B7F39DFD77A35F94EAC4BF6B1BFCA30891AA84B44973839A4B7B72B233049769AC2D5699607BF40F041F90DCD599926449EE13E05872BC7755AF665B9C068F12A9483DD7456B6C01D6B091B496923982BB7C3C2E91D57A2E3D9938B45F35377935B43B7191B7D5AC32D6ED7FE729F8A9A7C2F93C265B3F59BA1B7A46633D125D8792DF52871D4883B6DA8FEF7A6B1BCFF00DC9C1697FFD4F35B9BFA6703DCC21905AEF6987375047970AE675419679CF2AABE374F8A644D85F3152FABD5747EAD4DFED6121E1A0B9A74877D176D5D0517CB66785E6F8D90EC7B9B756756F3E63F39ABB2E9DD46BB6B6BC3A58FEFE0A0CB0A361B787358A2EC643DAE0DDC37693B4890509B632906C780DF002265446F78DCC87103DB3C2CE7E1E6596175AEDFE43411FBA9819E26E5AB62FEA96BC966303A731FF7E7FF00DF1889D33A797DDF6CCA3EABC68CDDC09FDC6A007B71DD552F610CB4ED691C4F9B96DB5BB180711A6BE48DE949991B008B31D0DD381C7DCB1B2DC1AD99E1BAAD3CD786D7120F89F8AC6B4BAFB8543BEAE8F009D0142DAD90DE8B538BBB1087082F04C7E2B5FEA767018D93D31F06CA8EE603DDA4ED77FD2FFAB426531501D950A2BB69EBD88EA1A4DB6BFD3DA34DCD768F6FF9BEF4F06D64A3403ABF5BFA63B33A2305403ADC62EBAB8EE07F38D6FF0059ABCDB4E7B2F66C96B5AF0C6896D6D0C6F9C7B579AE6746189F5A99D35E269B322ADBFF0017739AE0DFC54C366B1DCBFFD5E17ABB60B08FCE747DC157E9EC6599F8ED78058FB1AD20EB20908FD62C9B6967F59C7F204BA257BBAB623639B98DF9970FFC8A8A1A4033663794D3E9B4B2AAD829F459B5A34606B482DECF6FB7DCC543AAF4D665B43B1E9F46EAE7610035AEFE4591F47FAEB66CC6DECDC3DAE6999EC1C7BFF51C9EA639ECDCCB1CC2DD1CD26435DFB85349B14A88A361E36ABEEC6B4D368757637E956EE47FE49BFD557ABB9AF20E8656C753E9FF00B4AAF42C817D6D73AAB4000877E6B7FA8F5CA13938AE2CB012D69227C08EC54662D886434EE57E95808780769060F88FDD53BAD6C174FC96451D4AB83243639928193D62A73F65336DA740DAF5FF00A9404755C67D93F50CA6804CE83940E9153ED0EC8708161DAC9FDD1DFF00B4874F4ACBCB70B337F455CCFA4DFA47E2B769A5AC6B58D0001F44760027134282D8C75B2C760DB0070B43A1F4C6B1EEEAD68F786B998608D40768FBBFB4A38784ECBBC567F9B026D3E5FBBFDA5BB79686863406B5A00681D80E0238C59B599A7C3A753BB476075AD1FCA93F72A999F55F072FAAD5D56F6B85F53D8EADED7449A8B7D36399F25A78ECDD6974709CB9C728069D03F5F8A9C96B016FFFD6E03A9B83B35ADFDC66BE4795B9F53BA79B3370B208D3D773BE55565DFF0049EF62E6CD86DBADBCEA5E49F9765E97F55705B8FD370DF1AFA333FCAB3DCE2A33A001906B225E859EDD0EA382836B2DA6C1752371FCE67EF347FDFDA8A0A41E340E3047D13E098BD1B5FEADF6380036B03076FE51FED2E7BAAD4D6E73C11EDB65F1C6B2B5FD4CDB722CAB08B19638975975A3735A3F35AD67B772A5D631AE157AE47E968DAF7C0D098DB6B75FCDB99EE67F513640D2FC668EBD5C0B70F185BFA5ADAE69EE44ABF463E331BFA26B5806BED00293AA6DCCD383C2036ABAA30D32DF02A3B6C506CEEDDA81A782B38D53DE43583738FF00AC955E8618F72D7C6C7634FA27E9B9A0DB1DE4FD071FCDAD8888DF92C9CC443AB878ACC5C7DADD5EEF73DDE250AC3B8A8D0FF4ABD0E93C78FF005548B83B5F156214346A4EC9B3AA5C7647C4EA8347BAC73C76B9F3F00E56187686AACD2C6376B068497BBE6497245517FFD7E1A8C123098488373B43E558FF00BFDBEC5EA58748A31D940E2A6860FEC885C4B9A3D4E9D4861F4582A07CC1735EFF00F3BF48BB4AB2EAB498D09ECA1259A31AD9B8D50C8786565D3C11AF879A931D23449ED6BA091B834C96F8C20A45D3B04065D7DA0FAB926403CB583E8CA25A1CD782ED46BCEA083F498EFDE6A336EDC4BF99FA5F14AC13C708A9C67F49A2BB67189A6A76A2BFA4D063DC19CFB541D836BBE806BE3B891FF5416B31DB1F074463EA3C86B0EBE3C1FF00CE534C02F19643C5E78556D77D75BD85BB883C1E275FE4AD16BE6D0D00BEDB4EE654380D1FE16E77FA36AB5663E4328D0B5AF8833240F12D4F894D18ED71DCEB6C7EAFB0B609FDD6FF0025AD4631A54E7C492AA4304BA09FDE8FFA80A560260711C0EFF1727361EC23F12A1BBC13A98CB17DC2B69DFA6C1B8FC0213458314BA3F49B341FCA8FFC926C8AFD52C1BA1B2378F1683308D3EDFC6112801FFFD0E6BEAA75065F935E3653FDF4C3AA275DC072DFFADED5DC3A8AEC1BDA60F621793E0E43B13369C96FF837827E07DAEFFA2BD4B12C0581CDD5AED7451486A3C596074F24F5BEEA4C3BDC3C55DAAD6D8DD39EEAB820F293416191C25494EF26A7EF1F40F3E48AD7CF983F44A80707B60F7EC81B8D0EDAEFE69DC1F029213DED81B8723956EA1037772156DC1CC2D3DC687B2B20FB40F2494AB4CE9D95525CD3A9D1597EA09F82AEE829215208E534A1905A6427DE9255F9CA72873AA79D5253FFD93842494D042100000000005500000001010000000F00410064006F00620065002000500068006F0074006F00730068006F00700000001300410064006F00620065002000500068006F0074006F00730068006F0070002000430053003400000001003842494D04060000000000070008000100010100FFE1112D687474703A2F2F6E732E61646F62652E636F6D2F7861702F312E302F003C3F787061636B657420626567696E3D22EFBBBF222069643D2257354D304D7043656869487A7265537A4E54637A6B633964223F3E203C783A786D706D65746120786D6C6E733A783D2261646F62653A6E733A6D6574612F2220783A786D70746B3D2241646F626520584D5020436F726520342E322E322D633036332035332E3335323632342C20323030382F30372F33302D31383A31323A31382020202020202020223E203C7264663A52444620786D6C6E733A7264663D22687474703A2F2F7777772E77332E6F72672F313939392F30322F32322D7264662D73796E7461782D6E7323223E203C7264663A4465736372697074696F6E207264663A61626F75743D222220786D6C6E733A786D703D22687474703A2F2F6E732E61646F62652E636F6D2F7861702F312E302F2220786D6C6E733A786D704D4D3D22687474703A2F2F6E732E61646F62652E636F6D2F7861702F312E302F6D6D2F2220786D6C6E733A73744576743D22687474703A2F2F6E732E61646F62652E636F6D2F7861702F312E302F73547970652F5265736F757263654576656E74232220786D6C6E733A64633D22687474703A2F2F7075726C2E6F72672F64632F656C656D656E74732F312E312F2220786D6C6E733A70686F746F73686F703D22687474703A2F2F6E732E61646F62652E636F6D2F70686F746F73686F702F312E302F2220786D6C6E733A746966663D22687474703A2F2F6E732E61646F62652E636F6D2F746966662F312E302F2220786D6C6E733A657869663D22687474703A2F2F6E732E61646F62652E636F6D2F657869662F312E302F2220786D703A43726561746F72546F6F6C3D2241646F62652050686F746F73686F70204353342057696E646F77732220786D703A4D65746164617461446174653D22323030392D31312D31315430303A34343A33372B30313A30302220786D703A4D6F64696679446174653D22323030392D31312D31315430303A34343A33372B30313A30302220786D703A437265617465446174653D22323030392D31312D31315430303A34343A33372B30313A30302220786D704D4D3A496E7374616E636549443D22786D702E6969643A35443638453830313533434544453131393142324545364337374343304134462220786D704D4D3A446F63756D656E7449443D22786D702E6469643A35433638453830313533434544453131393142324545364337374343304134462220786D704D4D3A4F726967696E616C446F63756D656E7449443D22786D702E6469643A3543363845383031353343454445313139314232454536433737434330413446222064633A666F726D61743D22696D6167652F6A706567222070686F746F73686F703A436F6C6F724D6F64653D2233222070686F746F73686F703A49434350726F66696C653D22735247422049454336313936362D322E312220746966663A4F7269656E746174696F6E3D22312220746966663A585265736F6C7574696F6E3D223732303030302F31303030302220746966663A595265736F6C7574696F6E3D223732303030302F31303030302220746966663A5265736F6C7574696F6E556E69743D22322220746966663A4E61746976654469676573743D223235362C3235372C3235382C3235392C3236322C3237342C3237372C3238342C3533302C3533312C3238322C3238332C3239362C3330312C3331382C3331392C3532392C3533322C3330362C3237302C3237312C3237322C3330352C3331352C33333433323B36364635433932433242463732423144433436324637324430343138334145462220657869663A506978656C5844696D656E73696F6E3D223134312220657869663A506978656C5944696D656E73696F6E3D223230342220657869663A436F6C6F7253706163653D22312220657869663A4E61746976654469676573743D2233363836342C34303936302C34303936312C33373132312C33373132322C34303936322C34303936332C33373531302C34303936342C33363836372C33363836382C33333433342C33333433372C33343835302C33343835322C33343835352C33343835362C33373337372C33373337382C33373337392C33373338302C33373338312C33373338322C33373338332C33373338342C33373338352C33373338362C33373339362C34313438332C34313438342C34313438362C34313438372C34313438382C34313439322C34313439332C34313439352C34313732382C34313732392C34313733302C34313938352C34313938362C34313938372C34313938382C34313938392C34313939302C34313939312C34313939322C34313939332C34313939342C34313939352C34313939362C34323031362C302C322C342C352C362C372C382C392C31302C31312C31322C31332C31342C31352C31362C31372C31382C32302C32322C32332C32342C32352C32362C32372C32382C33303B3333333333353834303432424643413135424534463944313145314630463142223E203C786D704D4D3A486973746F72793E203C7264663A5365713E203C7264663A6C692073744576743A616374696F6E3D2263726561746564222073744576743A696E7374616E636549443D22786D702E6969643A3543363845383031353343454445313139314232454536433737434330413446222073744576743A7768656E3D22323030392D31312D31315430303A34343A33372B30313A3030222073744576743A736F6674776172654167656E743D2241646F62652050686F746F73686F70204353342057696E646F7773222F3E203C7264663A6C692073744576743A616374696F6E3D227361766564222073744576743A696E7374616E636549443D22786D702E6969643A3544363845383031353343454445313139314232454536433737434330413446222073744576743A7768656E3D22323030392D31312D31315430303A34343A33372B30313A3030222073744576743A736F6674776172654167656E743D2241646F62652050686F746F73686F70204353342057696E646F7773222073744576743A6368616E6765643D222F222F3E203C2F7264663A5365713E203C2F786D704D4D3A486973746F72793E203C2F7264663A4465736372697074696F6E3E203C2F7264663A5244463E203C2F783A786D706D6574613E2020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020203C3F787061636B657420656E643D2277223F3EFFE20C584943435F50524F46494C4500010100000C484C696E6F021000006D6E74725247422058595A2007CE00020009000600310000616373704D5346540000000049454320735247420000000000000000000000010000F6D6000100000000D32D4850202000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000001163707274000001500000003364657363000001840000006C77747074000001F000000014626B707400000204000000147258595A00000218000000146758595A0000022C000000146258595A0000024000000014646D6E640000025400000070646D6464000002C400000088767565640000034C0000008676696577000003D4000000246C756D69000003F8000000146D6561730000040C0000002474656368000004300000000C725452430000043C0000080C675452430000043C0000080C625452430000043C0000080C7465787400000000436F70797269676874202863292031393938204865776C6574742D5061636B61726420436F6D70616E790000646573630000000000000012735247422049454336313936362D322E31000000000000000000000012735247422049454336313936362D322E31000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000058595A20000000000000F35100010000000116CC58595A200000000000000000000000000000000058595A200000000000006FA2000038F50000039058595A2000000000000062990000B785000018DA58595A2000000000000024A000000F840000B6CF64657363000000000000001649454320687474703A2F2F7777772E6965632E636800000000000000000000001649454320687474703A2F2F7777772E6965632E63680000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000064657363000000000000002E4945432036313936362D322E312044656661756C742052474220636F6C6F7572207370616365202D207352474200000000000000000000002E4945432036313936362D322E312044656661756C742052474220636F6C6F7572207370616365202D20735247420000000000000000000000000000000000000000000064657363000000000000002C5265666572656E63652056696577696E6720436F6E646974696F6E20696E2049454336313936362D322E3100000000000000000000002C5265666572656E63652056696577696E6720436F6E646974696F6E20696E2049454336313936362D322E31000000000000000000000000000000000000000000000000000076696577000000000013A4FE00145F2E0010CF140003EDCC0004130B00035C9E0000000158595A2000000000004C09560050000000571FE76D6561730000000000000001000000000000000000000000000000000000028F0000000273696720000000004352542063757276000000000000040000000005000A000F00140019001E00230028002D00320037003B00400045004A004F00540059005E00630068006D00720077007C00810086008B00900095009A009F00A400A900AE00B200B700BC00C100C600CB00D000D500DB00E000E500EB00F000F600FB01010107010D01130119011F0125012B01320138013E0145014C0152015901600167016E0175017C0183018B0192019A01A101A901B101B901C101C901D101D901E101E901F201FA0203020C0214021D0226022F02380241024B0254025D02670271027A0284028E029802A202AC02B602C102CB02D502E002EB02F50300030B03160321032D03380343034F035A03660372037E038A039603A203AE03BA03C703D303E003EC03F9040604130420042D043B0448045504630471047E048C049A04A804B604C404D304E104F004FE050D051C052B053A05490558056705770586059605A605B505C505D505E505F6060606160627063706480659066A067B068C069D06AF06C006D106E306F507070719072B073D074F076107740786079907AC07BF07D207E507F8080B081F08320846085A086E0882089608AA08BE08D208E708FB09100925093A094F09640979098F09A409BA09CF09E509FB0A110A270A3D0A540A6A0A810A980AAE0AC50ADC0AF30B0B0B220B390B510B690B800B980BB00BC80BE10BF90C120C2A0C430C5C0C750C8E0CA70CC00CD90CF30D0D0D260D400D5A0D740D8E0DA90DC30DDE0DF80E130E2E0E490E640E7F0E9B0EB60ED20EEE0F090F250F410F5E0F7A0F960FB30FCF0FEC1009102610431061107E109B10B910D710F511131131114F116D118C11AA11C911E81207122612451264128412A312C312E31303132313431363138313A413C513E5140614271449146A148B14AD14CE14F01512153415561578159B15BD15E0160316261649166C168F16B216D616FA171D17411765178917AE17D217F7181B18401865188A18AF18D518FA19201945196B199119B719DD1A041A2A1A511A771A9E1AC51AEC1B141B3B1B631B8A1BB21BDA1C021C2A1C521C7B1CA31CCC1CF51D1E1D471D701D991DC31DEC1E161E401E6A1E941EBE1EE91F131F3E1F691F941FBF1FEA20152041206C209820C420F0211C2148217521A121CE21FB22272255228222AF22DD230A23382366239423C223F0241F244D247C24AB24DA250925382568259725C725F726272657268726B726E827182749277A27AB27DC280D283F287128A228D429062938296B299D29D02A022A352A682A9B2ACF2B022B362B692B9D2BD12C052C392C6E2CA22CD72D0C2D412D762DAB2DE12E162E4C2E822EB72EEE2F242F5A2F912FC72FFE3035306C30A430DB3112314A318231BA31F2322A3263329B32D4330D3346337F33B833F1342B3465349E34D83513354D358735C235FD3637367236AE36E937243760379C37D738143850388C38C839053942397F39BC39F93A363A743AB23AEF3B2D3B6B3BAA3BE83C273C653CA43CE33D223D613DA13DE03E203E603EA03EE03F213F613FA23FE24023406440A640E74129416A41AC41EE4230427242B542F7433A437D43C044034447448A44CE45124555459A45DE4622466746AB46F04735477B47C04805484B489148D7491D496349A949F04A374A7D4AC44B0C4B534B9A4BE24C2A4C724CBA4D024D4A4D934DDC4E254E6E4EB74F004F494F934FDD5027507150BB51065150519B51E65231527C52C75313535F53AA53F65442548F54DB5528557555C2560F565C56A956F75744579257E0582F587D58CB591A596959B85A075A565AA65AF55B455B955BE55C355C865CD65D275D785DC95E1A5E6C5EBD5F0F5F615FB36005605760AA60FC614F61A261F56249629C62F06343639763EB6440649464E9653D659265E7663D669266E8673D679367E9683F689668EC6943699A69F16A486A9F6AF76B4F6BA76BFF6C576CAF6D086D606DB96E126E6B6EC46F1E6F786FD1702B708670E0713A719571F0724B72A67301735D73B87414747074CC7528758575E1763E769B76F8775677B37811786E78CC792A798979E77A467AA57B047B637BC27C217C817CE17D417DA17E017E627EC27F237F847FE5804780A8810A816B81CD8230829282F4835783BA841D848084E3854785AB860E867286D7873B879F8804886988CE8933899989FE8A648ACA8B308B968BFC8C638CCA8D318D988DFF8E668ECE8F368F9E9006906E90D6913F91A89211927A92E3934D93B69420948A94F4955F95C99634969F970A977597E0984C98B89924999099FC9A689AD59B429BAF9C1C9C899CF79D649DD29E409EAE9F1D9F8B9FFAA069A0D8A147A1B6A226A296A306A376A3E6A456A4C7A538A5A9A61AA68BA6FDA76EA7E0A852A8C4A937A9A9AA1CAA8FAB02AB75ABE9AC5CACD0AD44ADB8AE2DAEA1AF16AF8BB000B075B0EAB160B1D6B24BB2C2B338B3AEB425B49CB513B58AB601B679B6F0B768B7E0B859B8D1B94AB9C2BA3BBAB5BB2EBBA7BC21BC9BBD15BD8FBE0ABE84BEFFBF7ABFF5C070C0ECC167C1E3C25FC2DBC358C3D4C451C4CEC54BC5C8C646C6C3C741C7BFC83DC8BCC93AC9B9CA38CAB7CB36CBB6CC35CCB5CD35CDB5CE36CEB6CF37CFB8D039D0BAD13CD1BED23FD2C1D344D3C6D449D4CBD54ED5D1D655D6D8D75CD7E0D864D8E8D96CD9F1DA76DAFBDB80DC05DC8ADD10DD96DE1CDEA2DF29DFAFE036E0BDE144E1CCE253E2DBE363E3EBE473E4FCE584E60DE696E71FE7A9E832E8BCE946E9D0EA5BEAE5EB70EBFBEC86ED11ED9CEE28EEB4EF40EFCCF058F0E5F172F1FFF28CF319F3A7F434F4C2F550F5DEF66DF6FBF78AF819F8A8F938F9C7FA57FAE7FB77FC07FC98FD29FDBAFE4BFEDCFF6DFFFFFFEE000E41646F626500644000000001FFDB008400010101010101010101010101010101010101010101010101010101010101010101010101010101010101010202020202020202020202030303030303030303030101010101010101010101020201020203030303030303030303030303030303030303030303030303030303030303030303030303030303030303030303030303FFC000110800CC008D03011100021101031101FFDD00040012FFC400C0000001050101010101000000000000000008050607090A04020301000100010403010100000000000000000000060304050700010208091000020103030302040404040502050500010203110405211206001307312241511408613223157181420991A15216F062824324B133C1D1633417E253834418110001030203040705060403060505000001000203110421120531415161F071C1D122130681A1B1325291E142622314F1D233077292B282C243532415A2E26335087383D33444FFDA000C03010002110311003F00C1A886528E7668540DC2876EE91141A035FCC40FE7D46134C52AC8EA76A7F633097395B7B3BD823EC49672A253DA0DC9B79633327AE8428AEBA69A74DA59400494FE18AB41D3AD49F92C95BE36CEC9E1EDA9924BD67B7643DC79A489903536FA140DFC3A68C797BCE1B93D2D11B413C547D91960B8768E0996E4CD1DACB6D0C750629624952606A004D8D2D28695AE9D2E9B3A3F32B44A787C6652823577450BDC9A4411CD240032AEF316E323A8DD4F68275EB97343E80ECAA4440E889703B577DD63EE12E02CB7A973215F6FFF006F15623FF718070E8C0D051A8DAFA74AB04718DBF14A362924C3B972371A8EED25B8173ED4044953B4574A850FB4C9FF004D7AE2E268CB1A01DFCF9A55D612C8D1418D7977A6F5E71F9E08DC46AED1BAEE471FD5465FC7DBA7CE9D710CECE29BBACA566DDBECEF489F40FDE90005AAC8C469A2852AEC013F02469F8F4E5F2B72020EF49E4941A1387B12826063BA2DB1D8CA10B2C7B1855AA34A90147AFAD69D23E77E64E18F7B28375520491342EF6CEA56589BDC1B4D069EA680FAFCFAE9B2E20E6C2A9FDADC38CEC1D3E0BAE242C5574F5FC3D6A69D292C81B193CBB117B5ADB87C2C231C074D8A52E2987174A084DDB50D7D3D6A07FA87F0E81752B9F2B31237F4DCBD6BFDB0F48C5710C65ADAF839FF003A9B717C64C81484DB450A6A10FE3E9BC1F8755FEA1A896C86A7C35EFE4BD73E98FEDB3658DAEC98D39FFF00912E5DF138DE13B82B5016D001A853FF0038E906EA791B1969DA40E9E145F7FF00DB38A6B69237B300336FDDFF00DC43F72FC525B4CE3685024F8EDFF4B1F40D5EAC7D0EFDEF8D953D29D4BC21FDE0D12D747B99A3DE0F3E3FE2728BCA1799D6305B68269F806009D7F13D14B647B8D1C5796354F2CC40B36E7E7C0AE2D8FDFEDED6DF4FCB43F2A7F0F5E9CFE0F6280FC4BFFFD0C2E632C5EF668A1806F69A7B6800D01677BA802A00684963F01F0EA0E69E3CB4CD8D79A998A27C8ECAC153453EE1314D8DB6B3690C71C12DE5C8ABB22B2BCB2FD3A168777741332EDFCBF8FA6BD307E790D46C4FA388C75A84C6CA2B4F975B63DB7BB495BB72C84048E29BBE11C46684D4C44540D3E3D6A30E85E5D20A348DBCFD8B9B805EC6866DAFBB15DD6FC4ADD9ED20783B1732772713413445A6983280CB473ED2189DBF98FCB4E953730838BFDC7B96410C95C5BF0523F1FE26B763F6EBC89CCCB31686E544F0DC0944522C68C91AF76546DDF94022B43F0E9B5CDEC2C8C16BF7F03C0F252CCB3F3034167BFEF4F9C3F89F2F790DADB4D66F14D35D35BBC5796AA85E462CD0CC2E0D182944228C40D75D7A81B8D558D2692FBBAF929FD3F4396520362AFB47F375222F0BF6B9C8321636B7431B6CFF004F2A23DBF6E3556428E7BBDC671116069A6EDDAD6941D425DEB91B1B5749F8B81E7F9517DBFA4AEE5CC1B698015F99BFCEBED73F66DC966B6BDBA8E29226672E96FDB4789102B68BB198035A7F2EB50EB919A525DDC0FF002A6779E8FD4684B6D3FF001B79FE7426F32F0A6738964A583238E91444E5B78882A955AEA5EA53F97AF53DA76A626908F3300CE1CC7243579E9CBAB11E75DDB648C9A7CC0E389FC2E3C0A604DC6A6D8F7768AD6CF102A03A14DE07AA2EE0BB813435F4D3A99F3C1C7361D487AE2DE0072B5DE2AF3E69939DC25BDCC0D28DAB74BACA4100B10AC2807A9A9F957A5237991D461AD132742CB6226905232695E67ED2A3FB476B7942B4664D927B95A8A428AD490DAD3E1FCFA73207B99940A14EA0D4E21730B9B260D2371DDEC53CF08E458EB78C24B02238A39DCAD42B515150A457711A7413AEE9D7CE8B3470FE3DB56EFAF12BDC7FD9EFEE0FA5ADFCBB5BAD4F2CCD88923CB94ECC0E223A6186F450F1BBBC6E6E049EC1632C168CAA76EBF1A86DA41A9EAA6D52DEED92BBCC8E86BC5ABE94FF006BB57D0F5FB58C69D73E6BE9F4C8DFF5B5ABBF311ADA59DC5C4C0471C713C80920862BA15A02C7E3D25610CB3CAC664C36EEFB914FADAE20D0748B8BFBB3E5C02A2B42EE3B9A1C78EE411F35CD7EE19397B24150ED40A0814155AEA057D7FCFABB7D39A55C36163DCCC29C477AF899FDF7F5AC1EA2F505DDA68773E74AD7B81194B298F1918D1B79A695AC0770937047A9AFC770FF004E80FC7A2F9191D3CB8CFEA56B4E5B2B5386D5E7B86EAE04AEB3BD196E00CD4C0EFA6D68A7BD77FD0CBF562EFDBB4218F6E9EA48D7F8E9D25514C9F8B6290F264F9F2F87D8BFFFD1C4BF8FECD658EF7231C4256C78B7BA826DCB4B49E0C95848F70C8C43BAC56824D0035AE953D0A4D856BC512580ACEE1F94FC429C71925BDF5C62A2BB81F6C97F68D759485166804535CDCDE2B9886E75AA460D36EE1E94AF4D5D7022071C3A72534DB7F34F4EF5F2C9F1AB6BFE476CF6CEB2B2C6B66D3B40A8A5BBB76EA36802424AB2FB88DA2BEB5E9137AC92A09D98F4C174FD39EE68CA2B8F4DEA41E37C032B6D716CD359C53CB0CCCCA1A1327E8336D0D0CA85A3594315A548D2BD30B8BE8998934FB7B948D969133F2F87E1FCDC9133C17C0599CB66C3DB62B397693D257786256B8B49D9A208D1386DAE8158E8A4FAF43FA8EAEC11F85D535EC3F951A68FE9C91F70F0E1F8797F32B66F0EFD8FE62FF036F1F2DC5DD7ED37CF1C8990CABDBA5FDAB28EE472010CCD7046D057685AEB5F81E81B54D6CB41C871A1EDFCAAC5D37D3CD8C834E98FE645D61BEDC38DF11B5ECC567249DC5A4AF2C8248A3308091858D98B16916AD51E9435E8464D6659642D3B07571FF0A3AB4D25AC0EA8C69DA79A43E43C36CF1704F1436D0F6B6920242A1A80115248F4FC3A90B4D49C5CDDC7EEEA495E69ADA1A8C3B71E681AF2E787B01CC21BE86E6CA390CD149DBF688CF7B6B05F7280C080C7D74FE74E89F4FD5DD0C8483B5B4EDFA50BEA1A0477D1188EC69CDBF7547D438AA67F2C78BAF384672EB1CD3836E8EFD875321ED8AB1168CAC352C0577536FB695D7A3FD1EF4DC16871C7A63B02A6BD49A20B391E5A3107BFF31433E4B1E827B84921612C7A390CAC1376A1A8ACDB81A7C3E7D1D32263636C8DDA7055E5ED5EC0CDC0F7A8B72B8F36D76D248BBB702166028AD52084DBA30AD3E54D3ADA8668C928C700BEF8C93632172555493A57534228403F107AE2485B330B1DB36A2B8356B8D3A38E7B5FEAD68766CC6BB411DAA54F1B730930B9A6B369CFD34EE18B307A2ABB0D28A9534FC7AAEBD47A307B048078C61F7ED5EEBFFE387F752F6CAEA08669A80D69834E3B3FE51E2A57F29F2636B888E0B7942994283B496AF763998025410344F9F42FA0583DFA8BDAE1E00D2776E239AF44FF00F207FBA2FB5F433243255D25CB19B38B1EEFF947E9E1EDE22550B4866989DEC18D3D7424126A2A3ABAF4C1E544E68D8BE3FDFEA925C7A92EAEDC6A1EF27DF5E1D8BBD0280B4F5A8F87F2FF00D7A55D512BDFBB291EFAAC963F36FF00F77C5B4E9FC12BFF00DAFF00ABA67E6FEA7B7B511F95FF004B9E9D2ABFFFD2C5978F02D9CB0C525C40AB749299A258A4915D592816611A38ED1908FE74E84677020E3BD1658DB4D1CC5D2368D2DA56A0EF1C0A2EF15E3DB7CB6361BDC5C73CB2CD05AA5C8B02B15ADB4D1A480816F33C53B38069BD54A50915D7A16D4350822243A4A7B0F3E48DF4DD2EEA7C8591579D40DC79A9DB817DBBF22E5590C759C3C72EA7460A56E5128ED2772340CEE8DA0A39AD7E3D0C5CEAF1C60BBCDDA69B0F3FCA8BECB43B87C8E0E83C143F886DFF0032B92F01FF006F285EDB1B73C9AD25862DC934C2460CC506D3B09762A6A69A0A9D3E5D0BEA3AC9707E492BECEBFCA8EF49D0012D2F8F0EBEBFCCAD2F82FDBAF8FB84C76BFB7E12179ADA2327EA468E5E68DE358EA6257F55A9F969F3E85A4BFB99DC435B5A63BBB91AFF00DA22B68D92B1BE22EA6D3CFF003152CDEE165915488D21846DDA8A1D638A8AC020570809FE15F4E902E73FFAA683A704F2088B686899194C14728955B6B5149A0DBEA2809D7F8D3A6F232DC50B5F575781D89FE72C68A9C141FCB78F5B891EDFB61A5784FB4014DA48A9AFE5A83F8D7A776DE534825D420F34DEE23B878244751B768E684AE73C45ADA7335BC5F95E8C3DB40181AD7DDD105988A571631D5752BBD40CB23AD8BCC832E60471F85555FF00DD9F8B2DE7B5BDCE2A0128B7DC117657BA031D75F4DAADAFA7E3D1FE8B1CCD232B3DE39AA8BD591CD267786F847574DEAAA73DC5D20ADCDB32C8678C2CDEE52500FCCC5776EF6B00341F1EAC8B3FDC16D256F869CB8F254ADD5D59B247B64968FEA776050C729C7C304D0DAB386678FB89EC61571514DDB768FCDF123A7264636A09C54448F0F7668CE15E9B5305A26B79591C6D02A7E74F40355A835AF4DEE26C91B5CD38E6EF527692873658C0F16427A7DA922EAF65C7E42DAE23D0175D7DBF975D7DC0FC47F1EB6F821BA86B26DF6F6108BBD17EA3D4B42D41B216658C38118B4FFBAE29F7C8F3B265ADAD86F2E3B1181AD6ACAA40A1201AFB8FE1D44D8696C86F257B5BF80FC473563FF733D777BEA4F4FD859B9F58DB76C76C68D91CAD3FF0DBF5714D764FD28FE2C346FC0EBF1AD0FA75341A633B282AA8ABD8E2735A61755FBC63DABAA34345D35AFCFF001FE3D772C8D7C79198B877273667CC8DB1D7F541A9EAF86D4AFB5BB3E9FD5F31F3FF00E5D44D24F3694C7B2A8BFF004FFEDC4D70AF3DABFFD3C79F82F87CFCB3358E86325236BD4B59DADC441B6121DA3227641DB62952457503AAEF57B936B6FE60DB9C0F8F22ADBD22C85D5C0888A0CA4D3A10B44BF6C9F6D3C5390DBD99CC423F6CB7291FD3988452CD30688090C916E62BB770A7A548EA9CD6B577191D8EF3D3E5574E81A1B0B1A32F4FF32B89F1DF8A3C75C1ECEDC6138C416D344E91ADC48527678A8198D181DB578D4EBAE9D0D9D4CCA32B9D874E48E6CF45687B891F87BBF3227B0856E2158822ED660A9088D5028A68E0D00140294FC7A41F3890506C4F5D6C2D478474FB4A7AC38CB5B68CB4B2B2311B2A8ACC7711B8268A74201D7D3AE21680F791F495C3277C8F111D80D7EC48D948ED6380ABCAEE370DAAD5A576BD08D07C0F5A937F527F16CF6A88B22F12DC3941B5750CC585369AD74AD6BB874C5DB42EE5F9475A8AF3A90C92C93E8EE24D800D4F6A8D56FE0180FC75E9CC5BBAD3C3FD33FE1EC505735B583B732B4694BBAC01895D37069376A410476FF8F447A3FF00FB1257664423A9B739A7024FC502BE64E04BCC71790B3B49E359E3824B708C37868CAB548A680EEA6BE9D589A65C06D29B3F8F255CFA8211246F62A3FF002D78A79AF06C8DE3DD636718D8CC84DD208E48D622C5B71ED4AE557DBE94AF477A76A0D73DC0ECCBF7F05467A8744923689DA3F1F2DE0FE6E4848E4F6D35C36F949EEAC2F35B2EDA178E31EE606800A0F9907A24640C99B982087BDF0BB26FAA8F6FDD5D61441591ADC4A74209054B2A82D40CC5509A0A9D3D3A6B751C4C680F346E6E7CD3AB51712B9E2115765E5DA9979D1592D90901984476B10AE04818A9DA68C3F2FCB4F8F4E58D8CC5E0387B52CD9AF2DE4F18D9FE1FBD39D2D5ADAD2D839DEA5568D50C6A57D34A91A74CA18CB6E242781F8A9E76A4FBAB68E176E757DC4701C57B740631B753BBE5F0A11F1FC7AEA5DFD6936B33F52FBA2101491A03526A3E75F9F4D62F9E4EA29F5AC0637B9C7616F7255FFF00AF5F86E1FF00A13D37FF00FA3D9DA8807FED6EFF0018ED5FFFD4CBB7DA061AD8E5706576CB2493C325D2E80C466A346DEEFCDB82D34AD2BAF556FA99CCFD83493879A3E0E57B7A59864D432C6DA9F289F871EB5A73FB76B68D6C2DAB08B71037648001DC59A360E769209A2F5456B390CB8397A1343B69991073A3F0EDDA3BD1F78D9E348D4020EABEA0D3FCC7FC57A1E983DAC0E6F1444C93338B23C5E0623F8A9570778B1240F45D1C7F50AFA56BA1AFAF5D425D8172E64639D5CC37272DCE7B4600023706F5D0514EBA8D295EA5237B1AD38ED09A981A0B4B31757DCA3CCDE5A5BB72B137A3574AAFA061EBA0F8F5A746F78AB45704E18D73768DE99173697731762A586D3E9246BFE6CE35A74D248256657399415E21237B730DB44D9277E561701B09C687803C132EFB1D21495943427552F268A7E3B6AC682B4F5F4D3A756F6D3494C8CAE3C477A7D14F15CC44C2ECC29C08F8D10CFE46E7BC578FCF736192BF863BEB743548CF708908F682E15A1A507A86D3A26D274FBB33B88870CBC5BDE87F508CC45D24A28CD9C71C7820339479A3076D9E304525C3C370CCB248B0B3C48AC47B8BC11B8D294E8AA1B5BB8F174741D63BD575A84F6F24AECCFC6BC0A6D72CB1C5F37C1E42D6636D7B6392B57888EDABB88DD7461A6F521E835F9F4F85C4D6D91DB01206EEE2A1F56B086F74F6B2219A40EAEF1B011BC81BD516F9838D4BC1F9B6538F5EC0425B4B71259BB8403E85A3947D3020904B9707FE9EAD0D22E9CEB5AD71CBD372A0FD4166CB1BB2D9C65A9A0DFC7812898FEDF7F6F1C6FCA3E50CF732E758C8B21C2F89E0A0C85958DD18CD84B948AFB170442E7DC7F48DA5CCE08207AF42DEAABBBB11442D855DE68AEC18509DE38D15A1FDB1D1ECAE2F679EFCE5B37DB3830F88D5E5EC2051AECC3C21D89C30C71A28E7EF5FC5B0722E267CDBC7F8AE238B61F1FCDB2BC6FE83076A6D9130BF57796D8BC8DC23047A4B7568B1EDDBBC770310175E97F4FEA99B2C53BE921C29F6EF02888BD63E867DB40FBC86DEB6FC7371E46427DC802C7C8F71636EAF56DA9B81AFA856922AEBA8059187F2E8CE596D846D7B5FB4D361545CAD8EDE52D268EAF3FBD2A08288091F1D3D3E47A8F92563AB95DBD4C58C4F7D0E5F0AF6C8361DBA9D74F4D287E3D231901CF27650A95B87C36F10CEFC4BA9B0F03D7C1766C6FA53A7F50F88FF004B7E3D35F319E7EDE95523E53FFED44E5C3303ECC57FFFD5CB47DA265059738B6B09A892A5A58BFB9C50B24B6CAC0104AD4093AA97D51FFB733FFAADF8395DDE8EB90CD55C78C47E2392D3DF862FD6DB1F8E6042C770B1CD55F76EDA101D17711F9BE34EA8ED57FABED5E96D166F32DC5518D699B8E1B713BB878C9083535DE416145A06FCAA7E1D44BDB9A3A537F6295B614BA969F41F884F4E3FC85EF5822078E254243B061B88655002901868DEB4EBA862248A2712EDF627D992478F68724CA367C6A036A4EB41F0E9FB62DE5350EA3EB4DC97717C750405EE9772005F7B95003545352DF23D3C8E3AD004A67E49A5CDB9DF05F1E62AF729C8EF6DEC6DACE079598C88A40505EAC482A136A9FC6B4EA460B36CF563B763D315C3EEECED98E92F47E9D283E6F9B77CA09E3C9542F993FB8371FE5DC8A3E07E1EB0CAF22CEE5DDAD6D21B48D984A54B2C8F144638E45D848F79A253E3523A73FB4311F074F7A02BFD74CB7462B2C184F69FA9A99394F06F3DCFDABE639D640E2AFEF23B6BB9F1375EEBA8E19D1CAB09627921600FB480C4A922B4E948669ADDF5076E0767DEA662B69996ADB8B9755AEC06CDB89DC7B2893AD3C19C72C5248A047BB9DE0FA79DA7757857B8565F6393B44B58C535AD2BD4C417CE34CDD367243B7FA732476766CE9CD70FFB08F1B90263C6FB46FD0910027B64B7741A9342A3B54D3E7D3F92413323036820A8B36AE60CBBB674C557C7DF67879AFB17073DC55BA0BCB0B70B918D63566920305C296217DDB8BEDD47A7477A3DD0640180EEE9B9545EBAD0CBA564C06FEFFCCB97FB7C669E4F1D79478F778D97EEF94E2D86D5D56564CA656C71B34700525F72CF76874D052A7404F4C3D427FE9DB21DF2763BB94FFA15CF8E3B6807CC08F8108E6F3D78DB052F02F2FF008F2F6CA15E33CB38EE5F2381631298F19C870F858B202059541489DA4C62BEF2421331F754102074E97F59B43C3B55F3EA281D2E8443C605ADFF00495977C6281098D68595D9147A130C4C5227D74FD494C9A7AE95F422B6307E6B6671CDDFDEBCA9ABE9CC8DE5C053C74F8F34E144AFB5C7A0AFC0FC7D7E23A453EB38591C54AF4C579963014951AFA7C07A83FC3E3D6C1A57A96A564733D8C2361AEFDD55D3B0FD3ECA0DE57781B97F285A135AD3E3FC7AE3C8C7CCA74DAA73CC87F6FF00B7FC34E7D3DEBFFFD6C72F85B933E1BC81C7EF649FB42F248E23A9D57B9115A95069F97E3D55FEA3B49E6B1F2E3655E2406951B002379A6F566FA76FEDE2D44074B4718C8D879725A93FB77E670E438C6307715AE2168E06A963B15D772FB88035DA3D0F543EB51490CD9646D0D7976752F527A59CE9ED039988CA8F7C159BDED97D46F69503A368D558D8E81BD75037534F9F5191B1C599A9E1AA2981F1B2E1ED71A3F291EF53871982DACC46B7C13BBB54195A88BB5886D953452C40AFF2E9564F0C783DFEE29C48D2EF946E52F5A5DE03B6926E85BB6C039AD02D6BAD481BBF80AF4F629E09080C7E34E053291AF6D3C2B8B96F26860C6CD1C320FA764AA18C905480D463500D00A8A75230BA307E6F8A4C8900CC598758552DF7496D9EF25DF8E3936512C30573088269218E495DC2B7BBBD0C61A6789A3DDBB6A9DBEA7DA09120C943285B8E0A0358859A8C31DB5685B2071EA01C3971E2839E279CE09F6EE999CF78CB865F66B2F690E48DD66B1D8C8735C9EF1F1D6B2B646DB8D4BB2682CAC2468C17B891921475552E1D94199B285D39F971EBE9C143DDDB699A55ABA56CFF00AE061E17F79084887EFBFC9FF70FE58E31C13C73C5B8C616DB371224C32379CA2E6F70CF177239E6E5F24F6691AE524998505A992D54120B062A092374468617BE94186FC7AB1D986FE54AE34AD21F56EBBAB6AB2E96C82B6CC617839A31B0E5FA01FC5C4F52337C5983F3BB65EEEDF97C3C62D614BA960832D82BBBC9A0C8AC72C6085B5BB2AF1B6D04D4A86D34D2BD405FB6DA02435DE2E142AD0D223BA922FD78A9ED1CF8238AD3875AD9E0276BF492E2EEE2DD9A395D414671B49A250BA114F560074CEC266BAE0D4F8034FDBFC13ABCB2765616B3F18271DD8D77A0C7CDFC7E2BBE3794B2992316F7314965234882403BD14A146CA160432835A507CFA2DB09C02003E1FE282FD656F0DC5A648B19403863F12404027DB978B6E7866672993B7CAAC365C4796E1733C822D924A87096F9BB1BB9EECC3009249BE95D633B515DE95A0E9F7A81ED974E8B21AB84A09EACAEEF085FD04D8E0D7325D1CACF2DDC4E385362B58FB9FC0D8DBF807C911595D1BBCAD8F1DFDCA3C944E1E149F2985824BCB78A71FA66516D74A405624AEEA7E56A0D68E4DC5CF950789D5D9B3E345E84F555C590D0888A5FC2373BE93C42C7547732437329202B0B89A1750410A904AC22218555BB81D89A134235EAD08627E46C2055C003EEC7EC2BC87AC3E699C5AC6E01E4EED98A5E7BEAC4AC8D572C14E87FD24FCA8751D2BFB69BE8F78EF514EBC743196BCD1D4E9B9734B7D2C68FBCD2AA69AFC4FA7A0FC3AD1B59DD8067BC77A809F5491B25586B8F2E3D49BE7913FD6AC7DCFD3ED3A1D1BF36F4A6B4FE3D4AF943F6D93FE25567FDE67A6DF15397F2AFFFD7C3DE36F0D8CB6D771CC45D63EE2078906E52024AA5C86A0534404D01D69D09EA76E0C6EE67DF89477A7B5914AC98752BF6FB78F3FF001FE13C731F366AF9DA6BFC758DCE3AD60DF24D725A246AB9D8D1DBA1D841EE1435A7CFAA7359D25B24E5CE1BFA6F5E87F4B6ADE5DA6561DDDFC915573F7E7CFAE30EF6FE39F16731CDC6842BCB0E0329716744255A55B9B4B474347A0DDBB67BBD6B4EA3596B6B6918320AD70DFCCEE2548DE5F5DCAF2E88E3FECECF685EB8F7DE0FDCAE532309CB78E32BC771F36D224CD5A5CE34B222D5CC516485B49201182772A90694AD4EBD496964E697018FFB5DE95B1BBBE7BC34BFDCDEE46778FF00EE40E42086DB317710BC93B52CB01B8D8F1872AA1C44C43950CD4A8040AF507746DBE48078ABCF663C517B593C11B6E253E1269BB9F0EAE08E3E37343CD38ADD4B15C2196340C2312296DBB18FF530F6907F874943B4A911FA911C772AEDF32E3F2777C82EB19652DD4266B59ADBEA2D9963BA45925482516EF232057EDC86A6BAA540D48E9D499B2329B70516D962B4B87CB38F01046FDB5AEEAF0493E38C649E28BD7CBD862AC5AFEFF19FB1C58FBCB617F69678D792017A563459D4C79609DE987E7DF18D35D5FDA5FBA1A66DBD39735D4F269D7CD2C70DA3F37DC9B583F0BF8EAC394DD725E25E3CC763393E5EEAF9F237983C54F6425692E609A07692E608228EDA6209201A820569D4A5E7A81FE40CA77F61FCAA0E2F4D5947706E606F89C287E6D87ADDD5B9163C2BC72D8DB98F33C8E9F57ACF0626231BDAD985015646689A48DE635A684E8C7A1A93517DCCB576249E9B8234B3D2DAC88D3A6DE695792457215FB32A287EE1345F6A466B4880F893A7A7CBA9EB46652D7FB3B130D56DC45097531AD3E3CD023E7067B4C5E415A22ECEE1ABA529B25F750E9EBD1358EEEBEF5557A83F1A0C7C4F6F909798F33E3504D1DB4DCFF8A663010779D028BDC9359436CE8ECDB125520B066202D3D7A96D49B9AC9E39F61417E9E7166B208FA1DF10AC03EE1B8443C13C197096590BDC9626CB83E62DB90C17128923BFCC62F887D15AE5B7927F4FBC248BD4D0B027420F509E928ABA83852B572B3BD57AA363D1F2F21F03C9634FB8080EADFF006E27DA6BBBBD732DDC9715A8F48991547C0D74AF56E3581B2835C72F685E76B9B8CF99DBABDFC97D52F9E2A16D47F8EBA6BE9F21D2EA0EE4F984F553E2936FF2535CD234D1436EAFA0F4229F03F1EB6DDAA1E7B7A36A38F4DE91BB1EFEEEF3BBF87E20FF000EBB4D7C93C57FFFD0C33C0C9DDB7DE8EE27570FB55CBAC86270856350649086D28A09D6BF0EA2AFE36061F30D057BD4F697712DD86323F16FA6038F20AD27ECBF8DE1796E4A393994B74A78FC898DFA5631832B599B213594915C329ECAFD5C6C5D4104D284D1A954FA8E781A0F96EF19151B7A0D8BD0DE8EB0BB744C7CF15231CDBCF81AABA0E45E75E39E1CE38B658882D7116D616D1A442CE28E7BDBAB99D916DB198BC7376FF73C9DD31AA88FB8AA88E4D00A800D36C2F751BF7C7711D2D830906ADDB514D841D84F2475AD6A5A4E93A7B247DC52674997E57EF0E3C08DCABCF31F7E5CF7CB1E52E37E35C378F717C725C9739C5719C96372D88C965797646CE6793EBB2BBB73E331E228454C4920277680D0D2C36E8B631DAFEA4B4706F077F374EA4050FA8679EE9A6C8676D70D83FD4D5689CD3C33C738B63EF21C7DE366AF63BC5171732E3530DFB2A4D109AD9A3BD49CCB7CCAC0AF6103D3D5A854755BEAD636F6D317C0FA92781ED2559705EEA52D9C22F61CB0E6C0D5A71A1DCD15E3C94F3F6B3CEB2B8F9EFB8CE532571742D98089E40BD9683D8A02EA6E19887D370029EBAD3A8E8BC24E6457651C92C5502A29DEA4EF2EF1C825BBB3E438F86B243297986DDA1D69216521C29A1600FF002EA52D0C523CB0BBF0F3E498EA76B14918139CA3361B4E3434181EB493C3ECB0BC825816EE30974F4704293EF52ABDAF42A01DD5AD69A74A5CDA3B29746DC29DFCD425BD8C1E78A49E1EA3DEA75B4E33063E2DB15AC801902376D6357ED90CC4F71B420902B4D7A8B89AC12B99706829EFAF2F6A33FDB451DB4462755C5D4DFCF894A17B8F8BE81EDE0B731EED7B8EC865AED2285B71F6EBFE5D77E437CCCD1E23674AA7E24222755B8D0A8873F6CB65110C4BEBB5890D41556D2A47C87C3A20B57839595C50BEA97156398F3BFE15E4830F3ED84373C7EFDE3406408A569A1276BFC4D3E07A26B004D29D36AAC35EF167A2AEEBAE578EF13F30E31CFF002D6125FE1F0371064F2F690D3BF3E3E2AA5D760824F7A3DE180F534D2A7A2492CAE2EE0922823CD26DDA07C4855ED9DD43A75EFEE6EDF921A115A1389C763413BB828FFEF5FF00BA7F0CF21F8C727E2AF06C1C8E5C5721B2BCB3BBBECED98B48EC61BC9E2FAC8E06B986DAF9E58C0A2FB7695DDAD6954BD39A06A76578E96EADC363AFD4D35FF293D0A53D51EA7D36FACFF6F65779E4A52991C3FD4D0150A30086BBF7EE6914B50802388A880D08AFEAABB1F98A6BF0EAC292173487FE1A5156CF2E30873B6E6EC5E19811EBF1EB8CA782401E257204A312E28B4D0E875D3E1AF5D35AE2700B99831CC18D4D57BA45F3FF002FFF004F5DE47704D7CB6FD2BFFFD1C4AE3F3A78E65B8DF20C65ADB4995C2E4ECB23145771473594A96D2069D2F206A89609622C855416AB0D280F51374EF3D8E6577553FD165FDB4A1BC074E2AC5BC1BE55E3FE47F3465333C771EFC6939A63F1597CA60A4444B4C6726B664C764E1C6F646C16B728F1CBA7B4D00AD453AACBD41A6D1CE770DFD0AF447A475E6BE36C44D0903B7F2F6A39337E3CE5779E55E25C8B3AF2DE607893FD7E22CE1BC5B4FADC8C4BFF008B7A5CACC8E600EF1F6E40951213E8BD044575FB498B87CD4A74C0AB49BA641A8303AE07E9ED1B76F1C083B0A2DF0965FBEF35879C5AF0BF1FF1AE4D636F108F93E2F8F5B3F2ABA370A05F19323B9E2FAB47441BF6A82750DD2F36BE4B0C64E3D3F2A716DA169D6D207B46FF00CDFCC51131717DF8B43979AF6F6EAE527FA459E77927324CDF5124B7C14B5BB4C5A2F6B06215491F1E866E67333893B2AA76E5F6F736B15AC03C4D7876FDC08DF4E3C530F816424C0F318AE8C9DB77BF16F2815A6C53F94850431AA0FE5D364EEDA5F259977AB0CCC41FEE1E2D090AA923C3B8B7B5AAA63635D3E27F1E9CDAC9E54B9B91495F8334630DFD850A73F283C1B2B0916371756F15E470492400FE9B4B200AC57F315A8A680FAEBD110FD48B6A8160C930AEC08D0E1BCFF8FF0027C159E4F1B324F1CB094915D8AC914C8E63759209552E2360C8C016500D3427A1EBB664797530AF7A2A8A40F8A31BF32EABBCBDA6E937856054855F401AA286A7DBA007FC7AE219684553C77F4DDFE1EC510728916EA1B929202AA0B2C601AEE008077529400FF9F52F6730F32BC908EABBBDA838F27186F31D7B6D2B12DB1AA36B100056075A6DF53F3AF459A74C28287A62AB9D6F63956BF9C70715F71FBBB30BB84F65716B4FF95A099E9AD3E318D7A3AD2E4A4EEE4DFB367DAAA1F51BCB2CC387FCC1F072CF9723C736273793C6B115B5BFB98C29910B2869188057712174F5F4E89A2903B1AEC55C4B3B8CA0F4DA91248DD53738D89EA19D95158EBED4662048E47C16A48074D3A72E90B9A0291F3CBA1693862B9D68DE845695DA480F4F9EC24301F8D3AE127E70FA97E488DB469F1F98F91FC7AEE3F98F52E5F36183973575A7C7A5D25E71FA97FFD2C30656531CF6CE24A0118AA7FCADEE036FAFF8FA750D6B56D6594D222280F3F663B1389ADAE6D2E1E1CCCBBB6838D7ACA923C2BCE6EF86F9138C656390C11365EDAD6762C42A433CA837B6CAD14CA880FC86A74A911BAE5899EDA57C42A69F6FDA78231F4B5F4963790FEE9D95998703C7802B565E2CCAE3F9861B057331B4BB905A804AA24DFAABDAFEB3FA6CB47D08343F0AF5416A11BE1BBB8F3051B8F3C7D8BD93A3BAD6FB45B57C5254E6E07873A71454E03078A644096D02B472877A411C550AA4905C01515234D7A1C9666B64C5D8578734590E916F2418BB1EA3FCC9F98DC40CC5D168635ED43BADC8F680A4AB0DC03904EA3E1F3EA49EF81D6EC0C7564CDCF663EC4D19A4C56D349203B5A46FDB5AF13C1083E42C464F89F32B110A3982FE5BA9ED4828048F6D3A2CA00DD5429BFD1A84FC2BD22D8DCED8145DCC52B5E6ADC3D8AC0BC2F2DDF2DC058D8C86934D190A242106D4011F7BC9B638802DEA48EBBF22614393DE138134724463CDE315DC5443E699F8978EEE2FE2E4B7F6B688F2296B8B9758E2B668A41702E1EE0FE89877C012A188AB8E8A2D2DA774552CC29C473E687AE278DB2901D88EB5137DBDE5EFB3DC8F9B66B1C93D8F0B9EDB049899A5496182FB231FD6B6426B0EF2C6D3DAAEF5ACA80C6C58518F513ABDB4CE8DAD8D957E7E23650F12A6EC1E1D8035681527ED45364B29690C6F03DD2BCE632D1AEEA7B81FCC5E82350149F523A8F8B4DBFC81C61C3ADBB3ED52125FDA31A58E97C54E07B946979929A2B88EE92E96E2C4325BDF80D536CB2BAAACBDB3FA92812155AA061EEF974E20125BC83CE1414EBF8550DEA3FACD0E8F118F4C542BE51B416F25ED9AA7BA4532446A06F0109343A501DDF1D3A29D3E40682BD3155E6B6C778853155DFE6183B587B8B87452B0A97F731A7F544C404AB16F7FA1D3A3FD258F7CD206B71C95F785536BB1D6DDAD77D7D8E5537CA3C13C7B94F33C9CD94E479AC0FEE0F6D2D9ADAE2B1B9282E0DCDCC16E164433ABC716FB8DC58D1805F4A5489F6CAD82A6534A74DC80E4B30E930DFDFD6AC30FF604F33720F1860BC9DE2DF3278B7945A677111E5AC70F9AC766B8D654492931C58F5C8DCC098D59DE4042967588ED277E9AAD1EA964491E778A9C1DDC96B9B67181A23157077BA878954FBF705F6D7E69FB62E613704F33F0FC9F17CDA2B5C44D7372B7F8EC844A6827C3E46D44D8FC8DB90FF9A09A4DB5008A9E9DB2EEDE41564951D47B945BA095B8B9BEF087E24306A1FC8C81BE1ABAB3002B4DD4035A5769D0D091D3B8C826A3826B360D15E2B83FEE7FC7CBA5936A85FFD3C34F2BC7B5A66AEAD96170F1CD2A6EA7E9852E4A287FC849515F5F8742F612BA6B56B0EC18A98F52562BE207D6902AE1094768DD59937AD4323323FBC102A0C63DF51FE9A7AE9D4A4C43E2CA5B51F1A6EF6A8F92EE481D1B8F11FC762BC1FB03F3F5FDE717B2C6642F057006D70F75DE95DDC242BBED2F253AD12EA057ABFE55600310CCA0D45EA8D14B0BE560FD373E9F6826989AE070D9B97AA7FB67EA61776C2D9E706C75ECFA47C55E1F16E52B98B55105C47B8F62E032B804ACC8FDBAD685448A4915A7A75565E5A98E5C3657A6F5E85D36F637C5876F3E4884E19751DAAAD644259D19F5AFB84885BD2A0FE9D7ADB0500095B970700471EF4CAF3B71E4CA60F1B95C645135E62AFEEEEB6051DEB9B299250F0DBFA526795908A9F41D3D8B775280BDDA7ABBD0C9C17CC5E57E272E431B6BC4327FB0998A5A2DECD0DBDF4B74EA5A308C67575B72AADEB45AD3A7ED6E60DE4A0E491D1825BB4E09127E15E4BF37F38C7F2DF28E16D2D70184EEFED784BCBB5B958EF12446B5BEB98A19E6B3BD58EDBBA9DB98888992A7503A9682E831B946CE9C93236924CECD92BED1DE8A6B182E7038B7EFE471988B3FA760A26ECDAC49146C8889690424DB46BB75D9116A815F8758E679BE21C53DCB2DBC648189C377DE86EE79E6AE1187E478FE376999BAE51CA3213ADADA61306D77752CD24914AE3BD25BC2F6F6700EDD0C93491C609504D48056734C716CDDD8A35D2CAE97C437F2443F00C0645F8BDF6633B673E3CDF595E3476D772C52CB6BDA8CDC431318A4943B7D44282A09A7AFA54F42D3CB9E673074E81485D1F2ECDB4181777F728AFC9F985BEBFB29D996331F1FB08DC0350D70F0CA6E09DBFE968D454E86BA744BA6ED6F5F7AAF75A93E734E982AF9F325F4270574864F6B47286DAAEF40588068A0FF00511D587A5C9E54B23BF2D3DEAA6D65C1F1B1BFFA9D8509DCC7855C41C4F15C9AD498AF916359E43A88E1943857F525B610ADA548A74EEE66CE1D8F4C544B6C0B985D4C7A735A99FEDA1E605F28FDB0F0DB216A9F59C33880C2DC06892E43E6F8E5DBB43713473511C5EC172541D757AFA2922309C8731D89B3A121C59BC0430FF71BFB6AC47DD4F80FCC7878309D9E75C0B1B173FE159602E6EB236D92804B7197C58BABF8E16B7B3EC33A88636303165DA4903A9FD3497E51D37A84BD1E5E6AF4DAB0DB7D03C33CF1DC5B4969247757BBE1950A4B04E6558AEE195080CACB3DBD469A03D163622D687F143B2C999C5BB8249A47BAB534AD2B43EBFC29EBD6D22BFFD4C49F3AB692C393653BF1A2C62E02111B48E9DDF755941074A03D0A69D736660636196AEA6383BB4233F54E9F2B6F5CE7C7E0CF5DA3BD35F256115BC705C2B6D8AE51F79A1A02D0CBB4D07BBF3803D3E3D4AB1ED71A0C4212D57C97B18D81D578DD8F6A973EDCBCB76BE20E73264F31697773C6F39876C3E62CEDE5404C6CD0DDADDA02C46F827B14F4F7518D3E23A61EA1B265DE9CD65B106612024623001C369C37828DFD03ACB34B9DCDB893283165D95A6FDC0AD087DB679CF1BCF78A6232587BF1731CE91A9057B72BC7664C516FDCA9244D6D1C9B4AB00589A8040AF547EB7A55CC5212F872D398EF5E97F4F7A96DAE18D0C9EADFF09E7F95587F12E529359ACC8C5882C69B886A2A90C4A1F75031F5A742CE19465AE35561D8DE096425C7C193B472EB4F0E419B8AE78FD9999410EC46E2EC1D00DC77C61016320A5294E9CC2D2EA506E5CDF5CC0D2497E14E079F2514497D92CB4F206682D2C61923ED5EDFF750F6E35605BBDB446B4AE8A4863F2D0F522D69637C5860A1629EDAEA610B24ABABC0EEFB123F33F39E138842B0D8DBD8642EB1D6CDBF27737739B28A511953325946A67BC9413450119684D4E83A6844DE6785B46FB1593A4E8E6786A19514E3FF0099067C879FF3DF248926C61C8A59DCB3C77792BF245CC713C835C56391F64763E9A9512D40D284F4436D7100606B9FE21C8F727171A3C50E775CB72C5ED38FB1D54517DAF7DBFE37017AFCDEFAD639B2F2D3E9EEF23024992BA591E195E457F7F66DC3443DAFB5AB4D34EB579776FE539A1F8F51EE55EEADFB0864764931EA7237797DDC431D2411D7B4904A8F421103C9048BB42E84FBC8D694E84A18A59EEDFE5B2A329DE3AB7A1FBBB98DD6C066C3361F61E4815E5F3A7D75E24C2BDBB18EDC02EBED6547275048D294AFE3D1869D1BDAE008E98AAFF5A9451C772047C8C64BE9B1B84B246967C9E416D803A6E8EB23B6AF445154AD49034E8CD956B6B4C2AAB0BC71B97B628F1707D69B36578D14AF9EF1EDBDC7089712F1F7298B50015029298C5BC8431A02625999B4F5DBA75B1711E6C85DE2F6F7227B5B370B504C7B8EFF00BD4D3FDA5FCEEFE2EF2AF39F0665EED22B4E456F7D77808EEA510937D868A158E0B7EE1085EFAC27B89B6D41261A537150777514AF858626D49772E7C5094D1E5BC946C14ED57922C97218DE777771FACD77845B7BD85C94082E55278E09D29BA9340B4208A0DD434240E887476B9AE01E287F8A19D658431FC31F8AC247F711FB74C87DBF7DC1724B56B658B8EF369EF398E06E455622994BB8BEAACE127D882D279554A1DAC6B500A8620FA4617DB3320A9AF7A088E40E9DE298D0FC5001D91BFB741B8CA631EE5DA6452015EE57B628580F5E99796FAD32E29CD42FFFD5C7879878B2594F713CA773BEFB824AEA5EE1B7EA7FFA7E9D56BA33DAE7BDADDCCED0ADAF54DB3CC6277EF929EE71E3C941D914DF8982362A248D9410CCAA02F6E423DEC429D3E00D7A2D876B7A95577515253D7DA5361A3EEA218D5645A6C2194EB421980D2ABA2FAFA74F0531AF04B445D03448D1E2AF62333ED13CD771E35E5D6981BB9CA71FCF5C2B5B526212C6F43C4888C41212178CB93E82A06BD03FA934DF3627BC6DE9CD5A9E91D71B1C8C6BDD87F1FCAB429E2CF26DACE2DED6E2FED184E19D181632EC90A6D046DA94248D7D2B4EA989ECE465CC81CDF08D9D2ABD17A66AD1BADC16BB773E7C94F525E4F928EDED04B3EC491A406DC2B855D7DCC49DAC843528B56A91A7AF4A46DF2F14B4D7027069B4E1D3042EF9AB917926EEECE138BE25715804510DF5FEF9E5B9BC7D8C2AB6FF00F6F7035DD4F853E3D3C864123B29380094D2A00CBCF31DF41EC50EF11E157F3DE4375CA1B2F9396D9BB91C0904AB14B6E1D6B1C8D3858917711AB11D38C8CFA95AF657EDB6B6DB8D3A6E2899E099AE2B9DE516DC4127DB92864510E3A18E28A4B754641D87745ED4C3DD53B588D3A4E5736268703BD0BEADEA17C84C4D3BEBD3C2AC5F0B6898DC65B88235710AF60305DADED1AAD0804D180D40E993FF00541C507DC9FDC3B391874EA4D1E4F349063B212DCA9DF22968E3622B400B061A9F403A5B4E8697249FA4F6288D54B63B46E53E2CC3E042AF5F2172A8216CB3EDF74C0F6CEEF4543B647D750558814F5D6A05074696B67E1CFB80E9BD569AA5CF9AE2C07A7D887FE098A9F97F2E7CC4A49B3C49FA6B53B098DAE2478D8329A0A90AADAFA6BD3996E7CB190E34E9C143D9E965F719C0DC7A6D466DCF1B69B136F14A763346EAFED0765519C1245777E5F857A8B37359295C49AF4C1160B6C90163874FB5573F94F0777E3BF27718F22E0657B0E4386CAC77F673C332DB8B8FA5EE493C61B7AAF726B28A40158D5ABB402481D10B2E4185809DFD3720DBDB02C7C92914A8A74C56A93816462C9783715CB4C57A6EBCA3161F944897B0CD6D7EF65738FB7686155BA489ADED9A5B471B1F6B0A824508A98E9108735A41C3F8AADB5D9833330AA57FEF1FF6E537947EDE66F20F1EC69BCE41E1996E7905D4A96E2695B8EDCC3793E4ED642A37BA58308DEA370A2D05491D184525418F83505C6CA4AE7F223DEB2266CC19D57B68218E46901AAED6EEC89234C63AF7004BA8447422A77546809EB9FC7EC4E17FFFD6CAF7DC9E096C71D777A28D1450C6256A53B6C5B6AE950586E603407E7D52DE90BD65D5E4AC63EA7C92767E61C82F4FFF0072B4F8ED7498720F11B90298ECC92733C903F70A64B1756AAB381B4854723B2A5E522A76A954AEBA57E1D59B182C01CE1E1A2F38DDBA1131A9C6BCF8956F5FDB8FFB77F8C3EE8AD321CA7C91C8B908C362F271E33F6AC3DEC78CB89AEDA249CA24881E49C7D387AA2A9AD6BFD27A63A8DF3591B042FABF38AE1BB1AED1D5B314FEDEDCCD19691E1030E955738FFD8D3ECA331688F84BDF2560990EDFA88F96C7DCEF4722CB48D9A201599E21F1A81A1E9466A1A7490649A6A3E9F4B8FC051736F6BA941701F143E0AD76B7B4A8B7EE0BED26FBEDAECF0591E1991CC723E03650C36590BCBFBA92F72381BC4490DACD93B910C71C78E786DDD5A7DC6112BA2160CEA0D73EA0B288812DB78AAFE630A1E255C1E9AD69F13F25DBF28C9C2B8FFB2D487E37F2C4963DB8F210C932054ECD41EE6F731B445C11B82491062A4D037C3A05BB618EB514E855A7A6DF433D32CB51D479F2EA44A5C6670BC86186E512289E68AA622AA642C48D4C657B9B057F3536FA0AEA3A8865D8648ECA7C54EDEA44B2B647319FB46E690115D83C3BCE386DA734AD63C7B0F7D147B903AA90B488C516F947A24C1CA930900D40F8D3A5FF007EFE9FC14D417AE6C392634701D7F00BD617EDDB8C7FF93F8E794F190AD865317148B7F676E7659DCAB344087A958DE56A06A827407AE5D7324D4601BEBBBB942BF29B9748E77E953A73446E6AF9EDA27B58A27586DDE568A689946B31DE646D47B63A529EBAF4F6DE391D4AB7E1C92771756AC8CB5B2634D943DC872F2472C36962CCD3CD31B76324B2B897688BB33A14DA543B7BDC1A80469D4F59C46391AE70A3294401AA5E48C0F74C69097501DB8E2770AF15567E5AE5CD6ECE90CA93CF7F2398204701CB4F2189542923D0495A1F9747D03EDC5B573E343B8A0A30DC5CCE5EC6563EB03B8A2EFC2DC19713C670966540B916F1DF5E3B229732DC6D70ACDAEE2A1B4009E83EF1EEF3A5A7CA8FB48B3CCC3186FEA65A9E95A6F44A5E6277C11D28D1C6013502335DA501A3ED3AB301A0F53D4379A44A71C4252E031AF311750A87F8CFDA9E43EE8BCE5C1F814109B5E3B84CF63F9073AC918832D960B157514B3DAD43073717934F120540CDB0B69404826B3F3AE8323B76D5E31A6030AEDC6887FD46D8AC34C1757072C6E90341C4E2438D282A76027653057CDCE2D6CA39ADB0B86805B60B0D0FECF8BB1262FF00C2B1C5DBADB5AAC610EDEDBAC6CD41A8275EADCD118D86DC0970781D78ECDCBCE9AF4A27B92E80D454F2E3C540BE47F1B5C738FB74F31F1FB7B5B79EFB98F03E5B80B2FABA981AEB2D8E9F1368D2ECAB512EAF10EA0014A9200AF4FDB710C33CAF91F461691B0EDAF20A36389C63069E359141FD97BEEF87226C67ED3C3CE22478ECBFDCDFBA63BE952D61C8492EB0FEE7F526E65B79F78213FA083AD075BFFB85A67FEB6EE0EEE5D7912D3E5F785FFFD7CC6FDDCF66CF80E5A42C16E25BBB2B58942925E41700BA0650545029F8D0F5477A1EDFCABF7BC8FF008247FE20BD59FDDC9991E97096EDFDD8FF0043D57C985C9B84746A2ACA21A15FCF259B56A06A177756C3BFA27ABB17966E2B25CD3895AAEFEC95C5A4CAF83F9DC990B65971CFCAAD243258A98F336DDEC559CF6D778D91B6EDB85575DDF2899C7A9A742BA8383713F577A2FB284881A69B55D5DBC6F0DECB80CBDDDDD9DF88CCB064318AAD6596B18CA45135BC2C7725E44B20132902566D54150C44679AD52B0C54A1A62BFAE7C5FC073A92D9E5B96493A64A37B6BCB2C8C77D71677B04BFFB9657B6D25B3593C0EC0165660548046A0749CA193B7214F4668BC6D55C9F72FF00DBEF23E3EC2E4FC8BE12CB6272FC6ED835EE67853DF49737F8B63DCB8965E3372F22493E376C443432D26477511A95DC4405F69EC7D40387F1E689B48D6DF0BC309E9FE5412705F27986E97197B73242EB24512C57C9B2682500892D0BB0128A36A43500A0AEB4E856EB4A11D5ED1B5DDFCD59106B8E10B5D5DA7A7E1450E1799D8C914D044C0DC100232B9F74A4A90054014A57DD5A7E35E99FEC0F4FE2A5ED35513D3374F77253F71AE5B2C98986D05CC41D543485A4542B20140A5DD82B0DAC7D0FC3AE9B686335AEDC3A62A5CCF0BA2C1DBF9F04D4E5DE476B0B6BAC74F305F61669E17EEB2A8041F745BFDBAF5296B09A8AE210D6A970D0D394E22BD3675A033CC5E65B3B31235D5F3FD1C7692051DCA24CD5140ED4DAAC75D0D0F44B63031EE2D78C036BF0407A94D25C8118C487D77731CB8A1BBC1BC172FE70F23D9F2BCBC13D8F0FE3D7C6705D498EE6E639634B689454BCC92A4AE7DA180A7C29D777B7C2D9A580ECE9C0A94D22C5D56823A63CD5C6F1DE2E96713810AC352029DD19ED3A002DA30AAC4B068771D01029F881D07BAF4BE67E6E1D37231B9B73656F14CCF99CF0D3EDAF33C139A4C35EDCA0B3821972192BE68ED2CA1810F7249A4910440290285240A75A0A0E95B568B8940031E9D495BB8216593AE5E68F039F4F72B75FB7AF0B59F823C6F334D10979EF2A823CAF2ACB98D0CF1CB2C47E9AC5261B9362C2F560AC4554756568B62637799F94F6F35E7CF55FA83F7AE7E9F5F031F9BEC047D2389DE9B9C8A2632811046DF33A8A83DE91E50E598B36941AD75F5E8FE00638F11414F7AABEE5F9A53BF1ED2A57E3382B0C5F13593256C65B78A585A4B40549B98E59A33246586E503FAB5A6ABD475D4F525BCFBD48DBDB55A0F4F8AF55E1AD93FD985847FB2C593A496FECEE9B9B85FAE85FBD4DA5562B69068682B43AD0751F9FC5CD3CFDB8C9B30AF4DEBFFFD0CA97DE466246C171EC631205E6724B997D7DDD8924DABF23ED63FE1D555E93B57F9C5CD67FC2E3BABD7C68AF7FEE86AD15C5A471092A45C56943F4BB90E2857C6DACB91C85A5BC487EA2F6EA2816314358E49617DFBBF22D608DBD483F0F52013A95ED8A221E6869D8A8A89DE6DC0CBF577AD8A7F633E357F69F6EF97CC5C466D2497C8995B1B35914347776D8BC561EC0B12B5002BAC91D1A841D7D35E84353787801871CDDEAC9B48BFE9623BD5D5737E0314F6F697F8B071F77031BBC4CEAB14BFB564D55DDEDAE096292C17B07728416456A0241A750DFABD289EC6003E2D8BB38B5971FE69879E5BAC5DBDBDDDAB2DAE531896B12E42D6FD7F47EA694ACB0DD962D58CB01515A75949BF0B6A7D89EB3C978734BB7734C3E45C59B05718DC3C02E62B5CB721B5B6114F00688476E97190B85634659D2482CDA2D80927B95A501211944E36B3DE14731AE65C870C1B5ED54EFF7D3F6998BE2FCF6E795711817158EE5D7991CADA43046698FC9BB40F77664444EC01D830A80B43A1F5EA32E1A284C830AF4D8ACBD347EF206DBC0734CD1988D986CAD4D06DE6ABA6F333CEF81B3DBDE4776D3D9C447D5411094C911652371AB26D3B41F5AF4CC1B671CA36FB53C732EADF02CA11CC7DFC13A2C7EE9F0F86C6451E5B27325E56AF0ED067DE14FA448AD2B7F0009EB9BCB7F2E0649928D2EA6DE479ADB2E7509096323AE1C5BB3EC51B677CF1E4BF22CF2E33C6DC2F35957BA711C594CA59498CC7A2B308D9CCD90165DC2A5C10350403D256F2C3150B9D43EDE9C52A2D6FA6A6787DEDEF52278F3ECBB35C9AFBF7FF33669AFCCF730DCC783C65C91671B6C672B32770A14435534F52DA74FA5D46DE38AB1CBE3D94A1ED09E5B69ECB793CDBBF0C74EBC4F5127655588F08E17C7F8D5958E2B1D61678EB1B12224B6B48C247488111B4800DF24A76FA8A8FC7A82B917970F2F11D5879B7EE53B0DBC6007C388F6F6953562B1CB74239B6D24EEEB19215076C12ACF21A46008C36A48F97A91D475D189B13238DF59F30A8A1D98EF38705316223B89648AE4D1AD8CBB7ED040DD4E2792393ED43C2E994CD4FE48CE5BB4B618FB92D808255411CB3C6515AE3B6E4388E21B87B9454B022A35E89BD3DA6DE3DF1BDD0783FC4DE35E3C1541EB9F507ECFCDB78A4A8EAEBE2D3F1469F33C9EC5994CB23025848C41DACE41D81500A8118040D29D5C760D8DB1B23FF8806231D9F0540DD4CD9669270EF13B05087D135FE62CE209BD1D84835035DC0575229F9BA9292689B1E50EC7DBB6899318E7BEA47854C9CBA4878F70A9A791013DCB1B48D74F75CDF5C2595BA022BAB4F70A2A741EA48009E87E72F2F7381C114D8863BC0D38D3B76FBD40031AFBA4AC9287FAB8A5136E357FFC29AE98FF00FC628BFF0057F1EA3BCF1E6E5AF8BEFDAA57CB6D29BD7FFFD1C90FDDDE485CF24E1B87257BA05DDD4F10F718CCB3C69117A55407121FE1F1E80FD33118B3BF77974F7D51FF00AEEE84A5AD3FF3BFDD3C976FDACF8F9FC8BE66E3F83313C96B63733662F805AAB5871EB7390BE52C4851B628AB4AEE7F4504E9D48EA129A3F1C287B508E9B6AE7BC3E98FF1E6B6CFFDB0BC7BFEC9FB45F1DC73C621B9CF5FF24E6132EC0AF6FF00EE3CE5ECB6F0315A87DB6767130A5695A1A10474293BF31A577AB0A139626C676856658F315D5ACD8CBC51243354A96D4B30FF00DBDA4E89B5E8DAD341D374A28439661393712CD47CB78D9924CB5A156CB59C2018B2D631C8B219562DD42F6C912D7FA9BE00F5DB369EA5DB1E19989E0BBF23CD2E39BF21E0F6EC8AA98D8EFB3AF17D3C914B15F5C28B38269A39638DF6AC77B22D08A8DD53A6BD273EE4DBCDFD4A8E2A01FBC9E30D96E0F94668D24B8C35DDFE552A1854CB6F02C4D14CA0A90E8B27B01AD5751E951DD55CE6C04B76E7EC2AC7F494ED6DE499CED88FFA82A7BBBE3F8BE53864964B3B69646B65769D65624B6D7553B5C0EE256B5A568450F41CFBC7B24C78F4DCAC91A7B6E5A5C37F4E21457C6F8AF15B5CD7D166311807B88663241717786B59770575455EE3A96DDEEFE3A1EA64DE9B88591938035F88E038A632E9EDB7754627674C4A2E705C7F08F0AC300B2B50B189956C618208CA2ED01446A02A9A91AFAF4925E1876715DF3E4D6666B6B28BE9560FFC56958AB33FF56EF6D7E29D33BDCDE534B76E61F029D496CD91AD0E1BC74DA9730503DDDC42C626020608CE3DC664DC05562526466AEB4009A03F0EBA8EF1E5818478BA724BD1B0C589C5185E19F165F790F3F6B8BEC4B060926493297E15550DBA3C7FA111621A6776715D9B88A1AF4EB4DD3DF77785CE151949F7F58419AEEBC34E87CC8CD1CE765FB6A77B4F056F76984C7716E376B89C4DBC56B678EB411F6A350AE9DB5081DC0D5CC83524034EAD5D16D9B034349E98F3541FA8F5192FE62E3B2BCB9F20A12CFCFF005ADB0124B4DB8835076059013EEA0F5234F5E8CDB0358DF31BBCD1094A28C15DB55E38CE295E74BA9929D8902A9D1B4A83E8B53D339B7F5AC8361EB5D9E6BB95B5E1D858D8065BFE73C36D02EE0B546CBC73331A9D00107A7AF51770F0C692779A7C510E99FD43FE0ED091FF00DBD27EE1BFDBF49F59F4DB6A9B7BDF426C76577694BB3B2BF97E35A6BD44E439FCCDD5FBD4CD57FFD2C5EF91B93FFBF7CADC8F3D5DD696170F636A953B02DB7E946B1EF0A4F7260BA8141EA74D7A15D3207B600C6B3C45B5DBBB6298F54DE47737458D92A4495D87653A82B8FF00ED0BE209397726F2EF34FA6FA818AC663F038D8584754BAE416DB320E8EECAA192381D4EBA86D2BD47EA4E0DA87606BDEA6B44634C4D35C68B621E27E3F63C3780715E2962122B3C2E0B19636D1A2D0318A395AE09DA28A63964035A56BA5474394739E48F95118639A6A47878A949E568A2DC8C55A95522BF3AFC3E74EB791DC17495A3BB3974B7B84DA991B342B1C3EDFF00C940A430727D84153E95A93D76D690710B45AF782182A50C3E42F2371FE05CC33BCCF2568D2DA5AC18AB0C46131D1CBFB966B2323AC525BC56B1C6D3C71F7B425D154B50D682BD71331CEA6509B7ED6EF3D7CBC3AC77A8EB2FE42E4BE62E27CB2FB2DE30E45C00E0E1B6CB61F139AEC5E1E5184592432491AD94D746DE4668C9DB376E408A7DB43D455DD9CB246E05985788EF44BA65C3ED246B89A1A53DFD4556058613FDA9CD394F8EEFDE0618CC83DF7139D1833657896580C9D85E4463DEBDBFABBE9E1911F6C96ED0AACAA85E3DC177F60629097329EDE7D6AF0D06FA296DDA0BFC54E07B937B99F004BDADDDA234175DCAC64A3210155C1700805806A0FE7D35B7B9B70E11093C40703DC9E5CC6F99E431B515AFC5363019CCF71A905A642DDEF214AA7D5A101956A3DA509EE15A2FC14EA3A9169CFF002E2B96445940E14EF529F179AE729741D227EDDCCF54520AD4ED26A4BD028DB5F5A75B92301B5985195C3AFD8BA9B3167E98A907DDED44FF008DF824BCA7290D8B4D358E3A28AEB2393BE829DF871F64A3EA85B10777D4B19140500BB29240A03D2B6BA64D2481F1455671A8ED28375AD661B68DCC7C947529B09FF74A3A38D6172F678CC4CF8ABDBDC3637136D0FECF6362C914FF004176E1E1BFCC4F50934D7460AD37174068C0746D636CC81987F508E9BE8AA4D43516DFBCC41F56835D94E5C022C709CB2FD31704394BA8AF2B1A4773704334AA8CA69DC9029465F9D09D69D3E8649A296B97C35E486EF2D039AEC831FE3CD205E04B8BC792220C2C8CF1B034564AA8DC09A1F5F87463677B14EC1107D6402A450F7537A16B9B6B88CE67C748C9E20E38F3AA7371B41141333A8A12284D29ABAA83F1A7BBAEA6071C37A4E16BB1C37A4CF23E0ACF9759F15B392FBB3063F96E373120DB27EA8C4457BDC88FB7E12CAA7E448D2BD42DFC723E3191B5F1711B2854F69CE0C97C47F053E0B9C676C7EB5ADC8A5A7623DAB46D725F57248ED5DB40546DD7D0D7D7A4B0F27CBFC7C3DAA6733695AE0BFFD3C6378CB81CD9BC4E6F31711CBD8C571DC8E6669F462F7732496B8F0E0132169B20C140A57FA8FB413D448736D63CC0D0D29D36AEA7649717AE79C41EAFB96A93FB1DF8EDB0DE23E65C87236C7B79FE630B4465501E45C6E3ED612BB4FEA288AE2795482010CBD076A730926723AD1E131C788C5684F1886095A3A522277C7A83B00DA368035035E9801E1054D9713E12704F0531B200C7DA5769343A1A9FC0FC3AC5A4DBCBCCF8889F2115C76A38CEADBBB676953508CF450E541A57D7D06B41D625237647135DC844C44595F227DCB637058FC4DB6471582B739DC94F945699ED5E38C3589216A3BB25DCA945A12A0D5801D6D2DE70FA91A3C9CC59CB338DCFDA3DB5DB5CCD6F6592B769215B45B030C96A92470AEE96D2EA26B885969E8D534D0F5A2DCE08290B8B82D6B0B4D4E61DAABABEE3BEDB73BCD6DECFC97E2BC4DB47CB38F1C85BF21E1B74F1117586DCB7065E33776B295505ED632D0BB862589DBA7433AAD939E1CDA606BDBCF923BF4E6BA220D613D3FCA870E3BF537B691DA65B1790C6DD448893D95F59DC136AEC087513B46772061A9A951F135A74157761240448D1E2AD3E3CD58C2FDB7910113BC40D7E23780BC65B82DA492BCF188E44D9BDBB6AAE0508AD295AB54FA0D7A423370C380F82E9B04EFC337C17DF138BB7C7507762B7454121EE011C8C8AE80058C812166720683407A7B04B24AFF2E4D83A92A6296CD8E9A43E1229BB7F55782307C5FF00F85E3ACC656C6496D67CFDE9C6A4B0C0AF71021475B98EDFBA06E0D0A96252A7DBD1FE931523AE5E98AA9BD4F3E791E77FDE885C0DDCB8DE382D551ED2D648AD2CD2EB233336472F0DBA9DAF6B182524B7A93554AB86034F5EA5DACA389403134895E48DC7E2A62C5E2B2993B388DE32D9630A44D6B8BB74637D7F450A1E464DC208E8C6A24286B4E942B72EC3D49C591C2C589B1B78E096679E665DB6ECE256B78CA484C4E632E036E03E3A53A7B61208A57389FC3DA1445D45E6B1ADA6C35F8A51E3F938A3B59A3982930D0C8370DCBDB75763B7D4D1149A0D74EA644E5FBF02A35D0861D899DCB7912C37F87B143DA796F331280096261B636B1CEE0283ED47BF887E3BB4AD1A9CDC369107576F725ACDD59E94DC5707EDB3FEDBDDDCDDCFA813EFA8DDB7716FF57A7515F8FD8A67F07B57FFD4CF8F05F053E0BEDCF0D9A907D15F792B91E120B5EE229965E3D84C95862ADCEC42D2431E4AF72E4ED90237E9EE236EBD01DC6A2D9269220FF0D387DC8D469AE8EC219BCAA38BA9B7913C569AFF00B75F168707F6C9E36C94766B672726B8E51C8D9142AF71339C96FB2D6ED4527D90D85D4012B4AA914F43481B82ECE5C056A54CDA18DB1904E3ED5649692C6D200AD5A2ED3A11AD53E607CBAEFCD8B2068778C75A56B89276277DA020536D4906834D6A47CF41D6B3B78ADE61C5473E4C96E5F06F636F034B72F7B6C56D91199EE1937BC312B202A0C972A952480056B41D6676F15CB882304FAF0EF8F878D9AEEEF2A209397F26D994CEE4A34567B76BF547B7C5ACC9B90A59C51D0ED6209F43D6B3B78AE1485CA7156976B345EEA8B790C739A152EEE859D547B837F11D2D0C91B5C73BB0A734AC4D638B8486829EFF006284BB57985BB88C123C2D1898457493280AF243246D23AAB333ABC7232ED20EAC0FC3AC9991CB500D47B53671B989F581B8758ED4D81E39B7C9DCE427B3C7F1E9E2B98ADDE08B3115CBCC92D1C5D77268227431CB33034AF4D1BA645238F9ADF06EDBB7D854DC3EA0BEB08C3DA31387E1E67E929BB77F6D98CC84724D9FC660F14A4891A7C45DDCC36DB59D62401988485D9E60773D147C4F4DE7D22D8D437B7F994C59FAD6F86534A1FF00679FFE9A83F99FDB8016D7D0F14CEDA364ACEFE1820C6E763EF43213BBB8F6993B7125ACED1A1A8225294AEB5A0EA267D25C29FB6655E0E38D30C7894471FAB45D874574FCB165A8C2B8EED8C07794AD6583FF00F16F1DC4E3F90DCC598B8C41B9B9B4C662DE549F2595BB9627B5B7B78A6550492AC18FA76F76BAEA41611F92D025143F6F1E082F58BA8677D637D7D87B9137E27E03C87228DCD7C91710CFC9B2FB25B3E3CC9DBC370EC57B5AD6D31D6C2A24BE99555A474DCB5075D7A7F4121A3313D8871B231AE754A2461B66B489FE8A368893592FAE976F6D29AB45BF6964F4F6282C7D69A1EB3C993E9F82E64918EAD0EE485712DA6E916D4969240564BF903EC131A132AC6C038016A294F8F5B10CC6995B8F584DD9903897ECA7BD32791AAE36D1B2563BB742D0A5E6D3EDB813CC904971B7D555049E875D7A92B5CEDFEA8A74E5EC4D6E599EBE58A9FE3C543B88B99F95F3FBCB90E66C7718C6C3864941FD2972595B84BCCB01B88DCF6BFB6400B0AAB6FF0069343479733C5FB70DCD8D781E0533B3B69DB725EE8E8DA1DE38F5A9F7B716F16D5F67D3B7C0FE6F68F4A75139DB9EB5C28A672BB2D298D57FFFD5A93F235C67AFBC65E294C25AA1C460F8AE1B24935BBC223271568F35B2AC2645959F2175B64202920C43753AAD6EA031CEE796F2567D848DB8B18E3AE00D7DD4E4AF13ED8BC8F2711F0DF8A78A64F1F25945C7381F0FC3A3BC1285964C7602C2C2E2E498E361BAE4DB2CA7E65BE60F4CA6D8148C36CC3BFA7DA8EBE39CBF1F968A39E0962FD4652A54B7A914A7A023F9F4DE01595FD47E2BABC85B1C0C236E61F02A5EB1BA344918AECDBA15653AE94D1496A53F0E9DE4E6A368BEB7B024A62C8C746B8B4945C40280879555D4060D41B42B93AE951D664E6B28BAB1DC91F24CC923C9F550C81A49256D6E25028280EAAB1A920759939ACA27A25F0C8D9491C8692A686B5048008A6A2A46B5F975A74750B47C22A9819EC434D1B4B15498D49F51F9803EB520D0F4B43192451739F9244E3793ED4A2CA442647629DBF42C372E9BBF20F4F9F4F84268909CE6601CD3FEE2CAE331756B63146D2DBEF876D83B016F25C891452F892049689033B950492EAB4E9B4F11DA93649E5D382E8B1F0FCF8719117F9537115C5E5DDC58DCD8C309117D451D6D6086F0C72436D1ED352406DCA29A13D378E3F114EE3BB0363B774DCA1AC0F8C38560F975D723E4F619BE5DC8ECAE9E7C64F75327D0DAA6E01624B6DDDA13A31043D368008AEBD2BE5D37ADBE6F339A9F1793C862896CF149049B58C97392314AE3711B16310B390231E9A7A74AC2DCAE26BB9347B40F104957593B89DAB777335C3FE6EDA384B651E9ED4241DC2BA69E87A72934912DDB3B53B6553D42547AFA062DA8E948FE63D4B976C48798B8867B1B8B4977AACE9DB70BA92A48245694D08AFF002E955C269F02E3B63C631CD6368F34C67BEBFC85DDC4C773C92CD3466DEA7F31A44CD4F9535A7485C7C83AFBD2B0FCC7A9497DD15EED75DBB7E3E9503E5D324E57FFD6CEE7D8479B64E799DC6785B9A64F7CE2CD64C0DDE4AE512D9A0B1B57B3FDAD24918442576BE565DCC01119A57A11D52D249034C2DA9CC780E3C4A2BD22F98200D0FC69C3EE5AF0E2FC630795E2780C788ED6E513176312CD6C114011D941008D980011F746DA1A1A0AD29D095D48C89D9243470FBF822CB71732333B63F06DDA3ED5C13F08CD719B93361AEA55B343ADB1914D093BF70AC82B4094D3E7D29631BDF2BDCD6F8687E216E599CE6889DB41AF62953897916EAD845699085C941B5E57DC750CA0E9A9F4EA4FC993E9F826E893C465EDB236A935A85903254D08F534AE8D43D679327D3F05A269B536793DA4D8D962CC586ED91C8AD7089E8015666AAD416155F803D679327D3F05ACCDE29CB8BCFA5FDB417F6AEAF5411DCC6B5AA2E9BA465201A86503415D7ACF25E6956FBD233B86414C714EDDE2EA10C881E264DCEC36E9E80D45775413E94AF4BC6C2DF9826953F4A8AB2B6C717C82C6E52AB6F25C46ACD4000123050768F713BC81E95E9C12C005574D2DFC6281137C66C52D4ADECB18DF462BE87DCA1431A82694DC3FC7A4242C703438A425C41C8977357CFF004F0045AB6C90ECF9484D575242FE407A418C01E4BB8268D6CCD7569F05057235BB127D5472845903125146EDEA7F29F8D3F1E96A37EAF727B0B88A17F14DBB7C83AED4B9924472410CE772903E41376D27AD10373AA9DBE48DCD01AEC6A9564DAE03A4B5AD07C75FC351A75A48AF83DC11B632351AD452BE94A7F3AF5DB080715A70A8C13732ACE75034A8D6A3D28DD299DBC57194F05DB8A92216F52D46F88A1D07F853E1D213B8160A1DE958410E35E0BB7EAD776DAE9FF57A52BF2E9A270BFFD7C42714CFDFF0DE5B83E438EB996DB2185CA595FC5244D22953673477B22178BFA25B7B7653AD35EA1AA1E1C01C6853EB77FED9B18A6F1D37ADCAFDA6F94C735F1A70CE6189BD79ECF3B88C764AE6DCCA7B6B757902199A3126D65FA7780AD29FD7A755DEAB156E1F857A156769537996A69F4A3FF15938B21119260B20340452BA9A7C0EBE84F52D60CCAD2797694DE51FAAE3D7F15FB7F82B2B90F3C51ED2C080134A1F5DC3D3D29F8F522B84A3C5B2B77849D2D8EFED1342EC770037269415F80EB0AE1FB14FD0DE5BE42D42B6C962962A32906923103D942053435A9D34EB4925106423BDE0F96932166CEF8A998FD5DAB1DCB123B2BB3050493431D34AFAF589397E51D6A53C2E76DE78EDEFACA70F8DBC50650377E948D434A101C52874A758904B99EC6C792B7B39A30A59721672AB210C0C49212C4904814F91A134F4EB893E51D6B97EC5385BCAB15BC702FC15D811E947ED14D69FD4A0FF008748A4D72DFB999E045D4D08A57FAB63FC4D0758B146D9651DB11B0AB01302BA68778F8FA1EB1628F325675F7C6D56553A0AE87D695A807D3AC0BB66D4876F9196DDBB73BB2B06A6D35229FC402075B4A257FAB5936B87AD74F8FF001F957AC58B82F5F7D47AE95F8FFF001FE3D62C5EECDC2414AD0D403A1FF9BF9749C9F28EB4A47F31EA5EBB8DBABF0FE3FF0007A412ABFFD0C381EDEF7F9F69BBBBBFFDAEC4BDDFC6BD9AD3F1A750D6FF0033EBF49EC4A5F7CCCA7D63B56B3BFB4F7FB87FFF003870CFDDB67D06CBCFD9B7777BBFB5FD543F4DDEDFA6EA5694D29D04EA997CF75765705626819FF6A3370EE5759C769B5BB35FCA2BFE9FE8AD3F1EA46D7FA2DE18A90B8F9F9FF152259F769EFA536EB5F4F51FE74E9C24174CDF4BB3E1DCA8AEDA56BF87E3D615C3F627AF1FFABFA68FB7BB66F5DBBFD6B434FE5F3EB4924BB9CFA3FA1B8FDDBB5D8ED3772B4DDB69F0F8D7AC49CBF28EB511700FDCFF0073BCFDAB7FFB6FB8FB7EB6BDBEE77129DAA7FF004F753E1D624110387FACDF3763FF00B0AAFF00EE6EDBDFEF47FF00B55FF93775C49F28EB5CBF629C1776D8F6569B21F5F5AECD3D3F9F48A4D7C7DDF5516EFF0051FF001D8FEBD62C518E6FBDF5269F9774D4F9FE75F9FC7AC589B2FBBDD5A5686B5AD3FCFF001EB02ED9B534727D9DDAFE6EE0A6DF5AD1BFCABD6D2892D7BFBD7B7BB6D7E3E94FFE74EB162EF97BBB457D69F8FF00C57AC58BF53B9DA1F3DDAFAFC8FA53A4E4F9475A523F98F52FEFD5FF008DDD20955FFFD9);

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'User id',
  `user_name` varchar(60) DEFAULT NULL COMMENT 'Name of the user',
  `user_email` varchar(100) DEFAULT NULL COMMENT 'Email of the user',
  `user_password` char(128) DEFAULT NULL COMMENT 'Password  of the user\nHash value with SHA512',
  `user_added` date DEFAULT NULL COMMENT 'Specifies the date when the user registered',
  `user_last_login` int(11) DEFAULT NULL COMMENT 'Specifies the time of the last successful login of the user\nTimestamp',
  `user_available` tinyint(1) DEFAULT NULL COMMENT 'Specifies wether a user is available(activated) or not',
  `user_available_from` date DEFAULT NULL COMMENT 'Specifies from when a user is available',
  `user_available_to` date DEFAULT NULL COMMENT 'Specifies to when a user is available',
  `user_person_pers_id` int(11) NOT NULL,
  `user_menue_menu_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `fk_user_person1` (`user_person_pers_id`),
  KEY `fk_user_menue1` (`user_menue_menu_id`),
  CONSTRAINT `fk_user_menue1` FOREIGN KEY (`user_menue_menu_id`) REFERENCES `menue` (`menu_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_person1` FOREIGN KEY (`user_person_pers_id`) REFERENCES `person` (`pers_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'admin', 'admin@blazebit.com', '123', '2010-05-25', null, '1', null, null, '1', null);

-- ----------------------------
-- Table structure for `user_activision`
-- ----------------------------
DROP TABLE IF EXISTS `user_activision`;
CREATE TABLE `user_activision` (
  `usac_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'User avticision',
  `usac_request_time` int(11) DEFAULT NULL COMMENT 'Specifies the time when the activision code is requested\nTimestamp',
  `usac_request_code` char(128) DEFAULT NULL COMMENT 'The activision code\nHash value with SHA512',
  `usac_user_user_id` int(11) NOT NULL COMMENT 'User',
  PRIMARY KEY (`usac_id`),
  KEY `fk_user_activision_user1` (`usac_user_user_id`),
  CONSTRAINT `fk_user_activision_user1` FOREIGN KEY (`usac_user_user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_activision
-- ----------------------------

-- ----------------------------
-- Table structure for `user_group`
-- ----------------------------
DROP TABLE IF EXISTS `user_group`;
CREATE TABLE `user_group` (
  `usgr_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'User group id',
  `usgr_name` varchar(60) DEFAULT NULL COMMENT 'Name of the user group',
  `usgr_description` varchar(60) DEFAULT NULL COMMENT 'Description of the user group',
  `usgr_menue_menu_id` int(11) DEFAULT NULL,
  `usgr_parent_group_usgr_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`usgr_id`),
  KEY `fk_user_group_menue1` (`usgr_menue_menu_id`),
  KEY `fk_user_group_user_group1` (`usgr_parent_group_usgr_id`),
  CONSTRAINT `fk_user_group_menue1` FOREIGN KEY (`usgr_menue_menu_id`) REFERENCES `menue` (`menu_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_group_user_group1` FOREIGN KEY (`usgr_parent_group_usgr_id`) REFERENCES `user_group` (`usgr_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_group
-- ----------------------------
INSERT INTO `user_group` VALUES ('1', 'Administrator', 'The user group for administrators', null, null);

-- ----------------------------
-- Table structure for `user_group_has_user`
-- ----------------------------
DROP TABLE IF EXISTS `user_group_has_user`;
CREATE TABLE `user_group_has_user` (
  `user_group_usgr_id` int(11) NOT NULL,
  `user_user_id` int(11) NOT NULL,
  PRIMARY KEY (`user_group_usgr_id`,`user_user_id`),
  KEY `fk_user_group_has_user_user_group1` (`user_group_usgr_id`),
  KEY `fk_user_group_has_user_user1` (`user_user_id`),
  CONSTRAINT `fk_user_group_has_user_user1` FOREIGN KEY (`user_user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_group_has_user_user_group1` FOREIGN KEY (`user_group_usgr_id`) REFERENCES `user_group` (`usgr_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_group_has_user
-- ----------------------------
INSERT INTO `user_group_has_user` VALUES ('1', '1');

-- ----------------------------
-- Table structure for `zipcode`
-- ----------------------------
DROP TABLE IF EXISTS `zipcode`;
CREATE TABLE `zipcode` (
  `zipc_code` char(10) NOT NULL COMMENT 'Zipcode',
  PRIMARY KEY (`zipc_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zipcode
-- ----------------------------
INSERT INTO `zipcode` VALUES ('3100');

-- ----------------------------
-- View structure for `vi_user`
-- ----------------------------
DROP VIEW IF EXISTS `vi_user`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vi_user` AS select `user`.`user_id` AS `user_id`,`user`.`user_name` AS `user_name`,`user`.`user_email` AS `user_email`,`user`.`user_password` AS `user_password`,`user`.`user_added` AS `user_added`,`user`.`user_last_login` AS `user_last_login`,`user`.`user_available` AS `user_available`,`user`.`user_available_from` AS `user_available_from`,`user`.`user_available_to` AS `user_available_to`,`user`.`user_person_pers_id` AS `user_person_pers_id`,`user`.`user_menue_menu_id` AS `user_menue_menu_id` from `user`;
