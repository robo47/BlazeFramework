SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci ;
USE `mydb`;

-- -----------------------------------------------------
-- Table `mydb`.`entry_status`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`entry_status` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`entry_status` (
  `enst_id` INT NOT NULL AUTO_INCREMENT COMMENT 'Entry status id' ,
  `enst_name` VARCHAR(60) NULL COMMENT 'Name of an entry status' ,
  `enst_description` VARCHAR(255) NULL COMMENT 'Description of an entry status' ,
  PRIMARY KEY (`enst_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`picture`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`picture` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`picture` (
  `pict_id` INT NOT NULL AUTO_INCREMENT COMMENT 'Picture id' ,
  `pict_name` VARCHAR(60) NULL COMMENT 'Name of a picture' ,
  `pict_description` VARCHAR(255) NULL COMMENT 'Description of a picture' ,
  `pict_picture` BINARY NULL COMMENT 'Binary data of a picture' ,
  `pict_owner` VARCHAR(60) NULL COMMENT 'Owner of a picture' ,
  `pict_added` DATE NULL ,
  `pict_status_enst_id` INT NOT NULL COMMENT 'Entry status' ,
  `pict_watermark_pict_id` INT NULL ,
  PRIMARY KEY (`pict_id`) ,
  INDEX `fk_picture_entry_status1` (`pict_status_enst_id` ASC) ,
  INDEX `fk_picture_picture1` (`pict_watermark_pict_id` ASC) ,
  CONSTRAINT `fk_picture_entry_status1`
    FOREIGN KEY (`pict_status_enst_id` )
    REFERENCES `mydb`.`entry_status` (`enst_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_picture_picture1`
    FOREIGN KEY (`pict_watermark_pict_id` )
    REFERENCES `mydb`.`picture` (`pict_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`project`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`project` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`project` (
  `proj_id` INT NOT NULL AUTO_INCREMENT COMMENT 'Project id' ,
  `proj_name` VARCHAR(60) NULL COMMENT 'Name of a project' ,
  `proj_subtitle` VARCHAR(60) NULL COMMENT 'Subtitle of a project' ,
  `proj_description` VARCHAR(255) NULL COMMENT 'Description of a project' ,
  `proj_from` DATE NULL COMMENT 'Specifies when a project started' ,
  `proj_to` DATE NULL COMMENT 'Specifies when a project ended' ,
  `proj_added` DATE NULL ,
  `proj_preview_pict_id` INT NOT NULL COMMENT 'Preview picture' ,
  `proj_status_enst_id` INT NOT NULL COMMENT 'Entry status' ,
  PRIMARY KEY (`proj_id`) ,
  INDEX `fk_project_picture` (`proj_preview_pict_id` ASC) ,
  INDEX `fk_project_entry_status1` (`proj_status_enst_id` ASC) ,
  CONSTRAINT `fk_project_picture`
    FOREIGN KEY (`proj_preview_pict_id` )
    REFERENCES `mydb`.`picture` (`pict_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_project_entry_status1`
    FOREIGN KEY (`proj_status_enst_id` )
    REFERENCES `mydb`.`entry_status` (`enst_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`zipcode`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`zipcode` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`zipcode` (
  `zipc_code` CHAR(10) NOT NULL COMMENT 'Zipcode' ,
  PRIMARY KEY (`zipc_code`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`city`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`city` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`city` (
  `city_id` INT NOT NULL AUTO_INCREMENT COMMENT 'City id' ,
  `city_name` VARCHAR(60) NULL COMMENT 'Name of a city' ,
  PRIMARY KEY (`city_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`country`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`country` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`country` (
  `coun_id` CHAR(2) NOT NULL COMMENT 'ISO1-Code' ,
  `coun_name` VARCHAR(60) NULL COMMENT 'Capitalized name of a country' ,
  `coun_printable_name` VARCHAR(60) NULL COMMENT 'Printable name of a country' ,
  `coun_iso3` CHAR(3) NULL COMMENT 'ISO3-Code of a country' ,
  `coun_area_code` VARCHAR(60) NULL COMMENT 'Phone area code of a country' ,
  `coun_flag_pict_id` INT NULL COMMENT 'Picture of a flag of a country' ,
  PRIMARY KEY (`coun_id`) ,
  INDEX `fk_country_picture1` (`coun_flag_pict_id` ASC) ,
  CONSTRAINT `fk_country_picture1`
    FOREIGN KEY (`coun_flag_pict_id` )
    REFERENCES `mydb`.`picture` (`pict_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`province`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`province` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`province` (
  `prov_id` INT NOT NULL ,
  `prov_name` VARCHAR(60) NULL ,
  `prov_code` VARCHAR(5) NULL ,
  PRIMARY KEY (`prov_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`location`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`location` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`location` (
  `loca_id` INT NOT NULL AUTO_INCREMENT COMMENT 'Location id' ,
  `loca_zipc_id` CHAR(10) NOT NULL COMMENT 'Zipcode' ,
  `loca_coun_id` CHAR(2) NOT NULL COMMENT 'Country' ,
  `loca_city_id` INT NOT NULL COMMENT 'City' ,
  `province_prov_id` INT NOT NULL ,
  PRIMARY KEY (`loca_id`) ,
  INDEX `fk_location_zipcode1` (`loca_zipc_id` ASC) ,
  INDEX `fk_location_country1` (`loca_coun_id` ASC) ,
  INDEX `fk_location_city1` (`loca_city_id` ASC) ,
  INDEX `fk_location_province1` (`province_prov_id` ASC) ,
  CONSTRAINT `fk_location_zipcode1`
    FOREIGN KEY (`loca_zipc_id` )
    REFERENCES `mydb`.`zipcode` (`zipc_code` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_location_country1`
    FOREIGN KEY (`loca_coun_id` )
    REFERENCES `mydb`.`country` (`coun_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_location_city1`
    FOREIGN KEY (`loca_city_id` )
    REFERENCES `mydb`.`city` (`city_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_location_province1`
    FOREIGN KEY (`province_prov_id` )
    REFERENCES `mydb`.`province` (`prov_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`currency`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`currency` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`currency` (
  `curr_id` INT NOT NULL AUTO_INCREMENT COMMENT 'Currency id' ,
  `curr_name` VARCHAR(60) NULL COMMENT 'Name of the currency' ,
  `curr_symbol` VARCHAR(10) NULL COMMENT 'Symbol of the currency' ,
  `curr_code` VARCHAR(10) NULL COMMENT 'Code of the currency(e.g. EUR)' ,
  PRIMARY KEY (`curr_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`contact_detail`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`contact_detail` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`contact_detail` (
  `code_id` INT NOT NULL AUTO_INCREMENT COMMENT 'Contact detail id' ,
  `code_name` VARCHAR(60) NULL COMMENT 'Name of a contact' ,
  `code_url` VARCHAR(60) NULL COMMENT 'Url of a contact' ,
  `code_phone1` VARCHAR(60) NULL COMMENT 'First phone number of a contact' ,
  `code_phone2` VARCHAR(60) NULL COMMENT 'Second phone number of a contact' ,
  `code_fax1` VARCHAR(60) NULL COMMENT 'First fax number of a contact' ,
  `code_fax2` VARCHAR(60) NULL COMMENT 'Second fax number of a contact' ,
  `code_email1` VARCHAR(60) NULL COMMENT 'First email of a contact' ,
  `code_email2` VARCHAR(60) NULL COMMENT 'Second email of a contact' ,
  `location_loca_id` INT NOT NULL ,
  PRIMARY KEY (`code_id`) ,
  INDEX `fk_contact_detail_location1` (`location_loca_id` ASC) ,
  CONSTRAINT `fk_contact_detail_location1`
    FOREIGN KEY (`location_loca_id` )
    REFERENCES `mydb`.`location` (`loca_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`manufacturer`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`manufacturer` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`manufacturer` (
  `manu_id` INT NOT NULL AUTO_INCREMENT COMMENT 'Manufacturer id' ,
  `manu_added` DATE NULL ,
  `manu_logo_pict_id` INT NOT NULL COMMENT 'Logo picture' ,
  `manu_contact_code_id` INT NOT NULL COMMENT 'Contact detail' ,
  PRIMARY KEY (`manu_id`) ,
  INDEX `fk_manufacturer_picture1` (`manu_logo_pict_id` ASC) ,
  INDEX `fk_manufacturer_contact_detail1` (`manu_contact_code_id` ASC) ,
  CONSTRAINT `fk_manufacturer_picture1`
    FOREIGN KEY (`manu_logo_pict_id` )
    REFERENCES `mydb`.`picture` (`pict_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_manufacturer_contact_detail1`
    FOREIGN KEY (`manu_contact_code_id` )
    REFERENCES `mydb`.`contact_detail` (`code_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`file`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`file` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`file` (
  `file_id` INT NOT NULL ,
  `file_name` VARCHAR(60) NULL ,
  `file_description` VARCHAR(60) NULL ,
  `file_data` BINARY NULL ,
  `file_added` DATE NULL ,
  `file_entry_status_enst_id` INT NOT NULL ,
  `file_picture_pict_id` INT NOT NULL ,
  PRIMARY KEY (`file_id`) ,
  INDEX `fk_file_entry_status1` (`file_entry_status_enst_id` ASC) ,
  INDEX `fk_file_picture1` (`file_picture_pict_id` ASC) ,
  CONSTRAINT `fk_file_entry_status1`
    FOREIGN KEY (`file_entry_status_enst_id` )
    REFERENCES `mydb`.`entry_status` (`enst_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_file_picture1`
    FOREIGN KEY (`file_picture_pict_id` )
    REFERENCES `mydb`.`picture` (`pict_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`product`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`product` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`product` (
  `prod_id` INT NOT NULL AUTO_INCREMENT COMMENT 'Product id' ,
  `prod_name` VARCHAR(60) NULL COMMENT 'Name of a product' ,
  `prod_description` VARCHAR(255) NULL COMMENT 'Description of a product' ,
  `prod_subtitle` VARCHAR(60) NULL COMMENT 'Subtitle of a product' ,
  `prod_tender` VARCHAR(255) NULL COMMENT 'Tender of a product' ,
  `prod_sizeable` TINYINT(1) NULL COMMENT 'Specifies wether a customer can choose the size of a product or not' ,
  `prod_min_size` VARCHAR(60) NULL COMMENT 'Minimum size of a product\nFormat is Width x Height x Depth without the whitespaces' ,
  `prod_max_size` VARCHAR(60) NULL COMMENT 'Maximum size of a product\nFormat is Width x Height x Depth without the whitespaces' ,
  `prod_default_size` VARCHAR(60) NULL ,
  `prod_weight` DECIMAL(10,0) NULL ,
  `prod_added` DATE NULL ,
  `prod_status_enst_id` INT NOT NULL COMMENT 'Entry status' ,
  `prod_preview_pict_id` INT NOT NULL COMMENT 'Preview picture' ,
  `prod_manufacturer_manu_id` INT NOT NULL COMMENT 'Manufacturer' ,
  `file_file_id` INT NOT NULL ,
  PRIMARY KEY (`prod_id`) ,
  INDEX `fk_product_entry_status1` (`prod_status_enst_id` ASC) ,
  INDEX `fk_product_picture1` (`prod_preview_pict_id` ASC) ,
  INDEX `fk_product_manufacturer1` (`prod_manufacturer_manu_id` ASC) ,
  INDEX `fk_product_file1` (`file_file_id` ASC) ,
  CONSTRAINT `fk_product_entry_status1`
    FOREIGN KEY (`prod_status_enst_id` )
    REFERENCES `mydb`.`entry_status` (`enst_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_product_picture1`
    FOREIGN KEY (`prod_preview_pict_id` )
    REFERENCES `mydb`.`picture` (`pict_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_product_manufacturer1`
    FOREIGN KEY (`prod_manufacturer_manu_id` )
    REFERENCES `mydb`.`manufacturer` (`manu_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_product_file1`
    FOREIGN KEY (`file_file_id` )
    REFERENCES `mydb`.`file` (`file_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`product_group`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`product_group` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`product_group` (
  `prgr_id` INT NOT NULL AUTO_INCREMENT COMMENT 'Product group id' ,
  `prgr_name` VARCHAR(60) NULL COMMENT 'Name of a product group' ,
  `prgr_description` VARCHAR(255) NULL COMMENT 'Description of a product group' ,
  `prgr_available` TINYINT(1) NULL COMMENT 'Specifies wether a product group is available or not' ,
  `prgr_available_from` DATE NULL COMMENT 'Specifies from when a product group is available' ,
  `prgr_available_to` DATE NULL COMMENT 'Specifies to when a product group is available' ,
  `prgr_added` DATE NULL ,
  `prgr_preview_pict_id` INT NOT NULL COMMENT 'Preview picture' ,
  `prgr_group_prgr_id` INT NULL COMMENT 'Product group' ,
  PRIMARY KEY (`prgr_id`) ,
  INDEX `fk_product_group_picture1` (`prgr_preview_pict_id` ASC) ,
  INDEX `fk_product_group_product_group1` (`prgr_group_prgr_id` ASC) ,
  CONSTRAINT `fk_product_group_picture1`
    FOREIGN KEY (`prgr_preview_pict_id` )
    REFERENCES `mydb`.`picture` (`pict_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_product_group_product_group1`
    FOREIGN KEY (`prgr_group_prgr_id` )
    REFERENCES `mydb`.`product_group` (`prgr_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`product_has_picture`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`product_has_picture` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`product_has_picture` (
  `product_prod_id` INT NOT NULL ,
  `picture_pict_id` INT NOT NULL ,
  PRIMARY KEY (`product_prod_id`, `picture_pict_id`) ,
  INDEX `fk_product_has_picture_product1` (`product_prod_id` ASC) ,
  INDEX `fk_product_has_picture_picture1` (`picture_pict_id` ASC) ,
  CONSTRAINT `fk_product_has_picture_product1`
    FOREIGN KEY (`product_prod_id` )
    REFERENCES `mydb`.`product` (`prod_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_product_has_picture_picture1`
    FOREIGN KEY (`picture_pict_id` )
    REFERENCES `mydb`.`picture` (`pict_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`project_has_picture`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`project_has_picture` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`project_has_picture` (
  `project_proj_id` INT NOT NULL ,
  `picture_pict_id` INT NOT NULL ,
  PRIMARY KEY (`project_proj_id`, `picture_pict_id`) ,
  INDEX `fk_project_has_picture_project1` (`project_proj_id` ASC) ,
  INDEX `fk_project_has_picture_picture1` (`picture_pict_id` ASC) ,
  CONSTRAINT `fk_project_has_picture_project1`
    FOREIGN KEY (`project_proj_id` )
    REFERENCES `mydb`.`project` (`proj_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_project_has_picture_picture1`
    FOREIGN KEY (`picture_pict_id` )
    REFERENCES `mydb`.`picture` (`pict_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`order_status`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`order_status` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`order_status` (
  `orst_id` INT NOT NULL AUTO_INCREMENT COMMENT 'Order status id' ,
  `orst_name` VARCHAR(60) NULL COMMENT 'Name or an order status' ,
  `orst_description` VARCHAR(255) NULL COMMENT 'Description of an order status' ,
  PRIMARY KEY (`orst_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`payment_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`payment_type` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`payment_type` (
  `paty_id` INT NOT NULL ,
  `paty_name` VARCHAR(60) NULL ,
  `paty_description` VARCHAR(255) NULL ,
  PRIMARY KEY (`paty_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`payment_method`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`payment_method` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`payment_method` (
  `pame_id` INT NOT NULL AUTO_INCREMENT COMMENT 'Payment type id' ,
  `pame_name` VARCHAR(60) NULL COMMENT 'Name of the payment type' ,
  `pame_description` VARCHAR(255) NULL COMMENT 'Description of the payment type' ,
  PRIMARY KEY (`pame_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`payment_combination`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`payment_combination` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`payment_combination` (
  `paco_id` INT NOT NULL ,
  `paco_payment_type_paty_id` INT NOT NULL ,
  `paco_payment_method_pame_id` INT NOT NULL ,
  PRIMARY KEY (`paco_id`) ,
  INDEX `fk_payment_combination_payment_type1` (`paco_payment_type_paty_id` ASC) ,
  INDEX `fk_payment_combination_payment_method1` (`paco_payment_method_pame_id` ASC) ,
  CONSTRAINT `fk_payment_combination_payment_type1`
    FOREIGN KEY (`paco_payment_type_paty_id` )
    REFERENCES `mydb`.`payment_type` (`paty_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_payment_combination_payment_method1`
    FOREIGN KEY (`paco_payment_method_pame_id` )
    REFERENCES `mydb`.`payment_method` (`pame_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`payment`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`payment` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`payment` (
  `paym_id` INT NOT NULL AUTO_INCREMENT COMMENT 'Payment id' ,
  `paym_payment_combination_paco_id` INT NOT NULL ,
  PRIMARY KEY (`paym_id`) ,
  INDEX `fk_payment_payment_combination1` (`paym_payment_combination_paco_id` ASC) ,
  CONSTRAINT `fk_payment_payment_combination1`
    FOREIGN KEY (`paym_payment_combination_paco_id` )
    REFERENCES `mydb`.`payment_combination` (`paco_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`delivery_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`delivery_type` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`delivery_type` (
  `dety_id` INT NOT NULL AUTO_INCREMENT COMMENT 'Delivery type id' ,
  `dety_name` VARCHAR(60) NULL COMMENT 'Name of the delivery type' ,
  `dety_description` VARCHAR(255) NULL COMMENT 'Description of the delivery type' ,
  PRIMARY KEY (`dety_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`delivery`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`delivery` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`delivery` (
  `deli_id` INT NOT NULL AUTO_INCREMENT COMMENT 'Delivery id' ,
  `deli_price` DECIMAL(10,0) NULL COMMENT 'Price per unit for delivery' ,
  `deli_lump_sum` DECIMAL(10,0) NULL ,
  `deli_added` DATE NULL ,
  `deli_dety_id` INT NOT NULL COMMENT 'Delivery type' ,
  `deli_deliverer_code_id` INT NULL COMMENT 'Contact details for deliverer' ,
  PRIMARY KEY (`deli_id`) ,
  INDEX `fk_deliverer_has_delivery_type_delivery_type1` (`deli_dety_id` ASC) ,
  INDEX `fk_delivery_contact_detail1` (`deli_deliverer_code_id` ASC) ,
  CONSTRAINT `fk_deliverer_has_delivery_type_delivery_type1`
    FOREIGN KEY (`deli_dety_id` )
    REFERENCES `mydb`.`delivery_type` (`dety_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_delivery_contact_detail1`
    FOREIGN KEY (`deli_deliverer_code_id` )
    REFERENCES `mydb`.`contact_detail` (`code_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`person`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`person` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`person` (
  `pers_id` INT NOT NULL AUTO_INCREMENT ,
  `pers_firstname` VARCHAR(60) NULL ,
  `pers_lastname` VARCHAR(60) NULL ,
  `pers_gender` CHAR(1) NULL ,
  `pers_birthday` DATE NULL ,
  `pers_contact_code_id` INT NOT NULL ,
  PRIMARY KEY (`pers_id`) ,
  INDEX `fk_person_contact_detail1` (`pers_contact_code_id` ASC) ,
  CONSTRAINT `fk_person_contact_detail1`
    FOREIGN KEY (`pers_contact_code_id` )
    REFERENCES `mydb`.`contact_detail` (`code_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`module`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`module` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`module` (
  `modu_id` INT NOT NULL AUTO_INCREMENT ,
  `modu_name` VARCHAR(60) NULL ,
  `modu_description` VARCHAR(60) NULL ,
  `modu_added` DATE NULL ,
  `modu_uid` INT NULL ,
  `modu_system` TINYINT(1) NULL ,
  `modue_active` TINYINT(1) NULL ,
  PRIMARY KEY (`modu_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`menue`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`menue` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`menue` (
  `menu_id` INT NOT NULL AUTO_INCREMENT ,
  `menu_name` VARCHAR(60) NULL ,
  `menu_available` TINYINT(1) NULL ,
  `menu_order` INT NULL ,
  `menu_menue_menu_id` INT NULL ,
  `menu_module_modu_id` INT NOT NULL ,
  PRIMARY KEY (`menu_id`) ,
  INDEX `fk_menue_menue1` (`menu_menue_menu_id` ASC) ,
  INDEX `fk_menue_module1` (`menu_module_modu_id` ASC) ,
  CONSTRAINT `fk_menue_menue1`
    FOREIGN KEY (`menu_menue_menu_id` )
    REFERENCES `mydb`.`menue` (`menu_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_menue_module1`
    FOREIGN KEY (`menu_module_modu_id` )
    REFERENCES `mydb`.`module` (`modu_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`user` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`user` (
  `user_id` INT NOT NULL AUTO_INCREMENT COMMENT 'User id' ,
  `user_name` VARCHAR(60) NULL COMMENT 'Name of the user' ,
  `user_email` VARCHAR(100) NULL COMMENT 'Email of the user' ,
  `user_password` CHAR(128) NULL COMMENT 'Password  of the user\nHash value with SHA512' ,
  `user_added` DATE NULL COMMENT 'Specifies the date when the user registered' ,
  `user_last_login` INT NULL COMMENT 'Specifies the time of the last successful login of the user\nTimestamp' ,
  `user_available` TINYINT(1) NULL COMMENT 'Specifies wether a user is available(activated) or not' ,
  `user_available_from` DATE NULL COMMENT 'Specifies from when a user is available' ,
  `user_available_to` DATE NULL COMMENT 'Specifies to when a user is available' ,
  `user_person_pers_id` INT NOT NULL ,
  `user_menue_menu_id` INT NULL ,
  PRIMARY KEY (`user_id`) ,
  INDEX `fk_user_person1` (`user_person_pers_id` ASC) ,
  INDEX `fk_user_menue1` (`user_menue_menu_id` ASC) ,
  CONSTRAINT `fk_user_person1`
    FOREIGN KEY (`user_person_pers_id` )
    REFERENCES `mydb`.`person` (`pers_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_menue1`
    FOREIGN KEY (`user_menue_menu_id` )
    REFERENCES `mydb`.`menue` (`menu_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`customer`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`customer` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`customer` (
  `cust_id` INT NOT NULL ,
  `cust_user_user_id` INT NOT NULL ,
  `cust_discount` INT NULL ,
  `cust_discount_from` DATE NULL ,
  `cust_discount_to` DATE NULL ,
  PRIMARY KEY (`cust_id`) ,
  INDEX `fk_customer_user1` (`cust_user_user_id` ASC) ,
  CONSTRAINT `fk_customer_user1`
    FOREIGN KEY (`cust_user_user_id` )
    REFERENCES `mydb`.`user` (`user_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`order`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`order` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`order` (
  `orde_id` INT NOT NULL AUTO_INCREMENT COMMENT 'Order id' ,
  `orde_firstname` VARCHAR(60) NULL COMMENT 'Firstname for transport' ,
  `orde_lastname` VARCHAR(60) NULL COMMENT 'Lastname for transport' ,
  `orde_address` VARCHAR(100) NULL COMMENT 'Address for transport' ,
  `orde_zipcode` INT NULL COMMENT 'Zipcode for transport' ,
  `orde_city` VARCHAR(60) NULL COMMENT 'City for transport' ,
  `orde_discount` INT NULL COMMENT 'Discount for the whole order' ,
  `orde_comment` VARCHAR(100) NULL COMMENT 'Customer comment' ,
  `orde_order_date` DATE NULL COMMENT 'Specifies the date on which the customer ordered the products' ,
  `orde_delivery_date` DATE NULL COMMENT 'Specifies the date on which the customer received the products' ,
  `orde_country_coun_id` CHAR(2) NOT NULL COMMENT 'Country' ,
  `orde_status_orst_id` INT NOT NULL COMMENT 'Order status' ,
  `orde_currency_curr_id` INT NOT NULL COMMENT 'Currency' ,
  `orde_payment_paym_id` INT NOT NULL COMMENT 'Payment' ,
  `orde_delivery_deli_id` INT NOT NULL ,
  `orde_customer_cust_id` INT NOT NULL ,
  PRIMARY KEY (`orde_id`) ,
  INDEX `fk_order_country1` (`orde_country_coun_id` ASC) ,
  INDEX `fk_order_order_status1` (`orde_status_orst_id` ASC) ,
  INDEX `fk_order_currency1` (`orde_currency_curr_id` ASC) ,
  INDEX `fk_order_payment1` (`orde_payment_paym_id` ASC) ,
  INDEX `fk_order_delivery1` (`orde_delivery_deli_id` ASC) ,
  INDEX `fk_order_customer1` (`orde_customer_cust_id` ASC) ,
  CONSTRAINT `fk_order_country1`
    FOREIGN KEY (`orde_country_coun_id` )
    REFERENCES `mydb`.`country` (`coun_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_order_order_status1`
    FOREIGN KEY (`orde_status_orst_id` )
    REFERENCES `mydb`.`order_status` (`orst_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_order_currency1`
    FOREIGN KEY (`orde_currency_curr_id` )
    REFERENCES `mydb`.`currency` (`curr_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_order_payment1`
    FOREIGN KEY (`orde_payment_paym_id` )
    REFERENCES `mydb`.`payment` (`paym_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_order_delivery1`
    FOREIGN KEY (`orde_delivery_deli_id` )
    REFERENCES `mydb`.`delivery` (`deli_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_order_customer1`
    FOREIGN KEY (`orde_customer_cust_id` )
    REFERENCES `mydb`.`customer` (`cust_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`tax_class`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`tax_class` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`tax_class` (
  `tacl_id` INT NOT NULL ,
  `tacl_name` VARCHAR(60) NULL ,
  `tacl_description` VARCHAR(60) NULL ,
  PRIMARY KEY (`tacl_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`unit`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`unit` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`unit` (
  `unit_id` INT NOT NULL ,
  `unit_name` VARCHAR(60) NULL ,
  `unit_description` VARCHAR(60) NULL ,
  PRIMARY KEY (`unit_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`available_product`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`available_product` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`available_product` (
  `avpr_id` INT NOT NULL AUTO_INCREMENT COMMENT 'Available product id' ,
  `avpr_discount` INT NULL COMMENT 'Discount for available product' ,
  `avpr_price_per_unit` DECIMAL(10,0) NULL COMMENT 'Price for available product' ,
  `avpr_discount_from` DATE NULL COMMENT 'Date from when a discount begins' ,
  `avpr_discount_to` DATE NULL COMMENT 'Date to when a discount lasts' ,
  `avpr_available` TINYINT(1) NULL COMMENT 'Specifies wether a product is available or not' ,
  `avpr_available_unit` INT NULL COMMENT 'Number of units of available product' ,
  `avpr_available_from` DATE NULL COMMENT 'Date from when a product is available' ,
  `avpr_available_to` DATE NULL COMMENT 'Date to when a product lasts available' ,
  `avpr_added` DATE NULL ,
  `avpr_product_prod_id` INT NOT NULL COMMENT 'Product' ,
  `avpr_tax_class_tacl_id` INT NOT NULL ,
  `avpr_unit_id` INT NOT NULL COMMENT 'The unit which is used for the calculation of the price.' ,
  PRIMARY KEY (`avpr_id`) ,
  INDEX `fk_available_product_product1` (`avpr_product_prod_id` ASC) ,
  INDEX `fk_available_product_tax_class1` (`avpr_tax_class_tacl_id` ASC) ,
  INDEX `fk_available_product_unit1` (`avpr_unit_id` ASC) ,
  CONSTRAINT `fk_available_product_product1`
    FOREIGN KEY (`avpr_product_prod_id` )
    REFERENCES `mydb`.`product` (`prod_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_available_product_tax_class1`
    FOREIGN KEY (`avpr_tax_class_tacl_id` )
    REFERENCES `mydb`.`tax_class` (`tacl_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_available_product_unit1`
    FOREIGN KEY (`avpr_unit_id` )
    REFERENCES `mydb`.`unit` (`unit_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`order_row`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`order_row` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`order_row` (
  `orro_id` INT NOT NULL AUTO_INCREMENT COMMENT 'Order row id' ,
  `orro_position` INT NULL ,
  `orro_unit` INT NULL COMMENT 'Number of product which are ordered' ,
  `orro_price` DECIMAL(10,0) NULL COMMENT 'Price per unit' ,
  `orro_size` VARCHAR(60) NULL COMMENT 'Size of the product' ,
  `orro_remark` VARCHAR(60) NULL COMMENT 'Remark to the row' ,
  `orro_product_avpr_id` INT NOT NULL COMMENT 'Available product' ,
  PRIMARY KEY (`orro_id`) ,
  INDEX `fk_order_row_available_product1` (`orro_product_avpr_id` ASC) ,
  CONSTRAINT `fk_order_row_available_product1`
    FOREIGN KEY (`orro_product_avpr_id` )
    REFERENCES `mydb`.`available_product` (`avpr_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`paypal_payment`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`paypal_payment` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`paypal_payment` (
  `papa_id` INT NOT NULL AUTO_INCREMENT COMMENT 'Paypal payment id' ,
  `papa_user` VARCHAR(60) NULL COMMENT 'Paypal user which made a payment with paypal' ,
  PRIMARY KEY (`papa_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`quantity_discount`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`quantity_discount` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`quantity_discount` (
  `qudi_id` INT NOT NULL AUTO_INCREMENT COMMENT 'Quantity discount id' ,
  `qudi_from_quantity` INT NULL COMMENT 'Specifies at which number of products a discount is possible' ,
  `qudi_discount` INT NULL COMMENT 'Value of the discount in %' ,
  `qudi_from` DATE NULL COMMENT 'Date from when a discount begins' ,
  `qudi_to` DATE NULL COMMENT 'Date to when a discount lasts' ,
  `qudi_added` DATE NULL ,
  `qudi_product_avpr_id` INT NOT NULL COMMENT 'Available product' ,
  PRIMARY KEY (`qudi_id`) ,
  INDEX `fk_quantity_discount_available_product1` (`qudi_product_avpr_id` ASC) ,
  CONSTRAINT `fk_quantity_discount_available_product1`
    FOREIGN KEY (`qudi_product_avpr_id` )
    REFERENCES `mydb`.`available_product` (`avpr_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`order_has_order_row`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`order_has_order_row` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`order_has_order_row` (
  `order_row_orro_id` INT NOT NULL ,
  `order_orde_id` INT NOT NULL ,
  PRIMARY KEY (`order_row_orro_id`, `order_orde_id`) ,
  INDEX `fk_order_row_has_order_order_row1` (`order_row_orro_id` ASC) ,
  INDEX `fk_order_row_has_order_order1` (`order_orde_id` ASC) ,
  CONSTRAINT `fk_order_row_has_order_order_row1`
    FOREIGN KEY (`order_row_orro_id` )
    REFERENCES `mydb`.`order_row` (`orro_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_order_row_has_order_order1`
    FOREIGN KEY (`order_orde_id` )
    REFERENCES `mydb`.`order` (`orde_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`cart_entry`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`cart_entry` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`cart_entry` (
  `caen_id` INT NOT NULL ,
  `caen_position` INT NULL ,
  `caen_unit` INT NULL ,
  `caen_price` VARCHAR(60) NULL ,
  `caen_size` VARCHAR(60) NULL ,
  `caen_product_avpr_id` INT NOT NULL ,
  `caen_user_user_id` INT NOT NULL ,
  PRIMARY KEY (`caen_id`) ,
  INDEX `fk_cart_entry_available_product1` (`caen_product_avpr_id` ASC) ,
  INDEX `fk_cart_user1` (`caen_user_user_id` ASC) ,
  CONSTRAINT `fk_cart_entry_available_product1`
    FOREIGN KEY (`caen_product_avpr_id` )
    REFERENCES `mydb`.`available_product` (`avpr_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cart_user1`
    FOREIGN KEY (`caen_user_user_id` )
    REFERENCES `mydb`.`user` (`user_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`session`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`session` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`session` (
  `sess_id` CHAR(32) NOT NULL COMMENT 'Session id' ,
  `sess_session_lock` CHAR(128) NULL COMMENT 'Lock value for secure session\nHash value with SHA512' ,
  `sess_last_update` INT NULL COMMENT 'Specifies the last time a user requested for something\nTimestamp' ,
  `sess_start` INT NULL COMMENT 'Specifies the time when a session started\nTimestamp' ,
  `sess_value` TEXT NULL COMMENT 'The value of the session which is encrypted' ,
  `sess_ip` CHAR(15) NULL COMMENT 'IP address of the user of the session' ,
  `sess_cookie_id` CHAR(128) NULL COMMENT 'Identifier for the cookie\nHash value with SHA512' ,
  `sess_user_user_id` INT NULL COMMENT 'User\nIf user is null, then it is a guest session' ,
  PRIMARY KEY (`sess_id`) ,
  INDEX `fk_session_user1` (`sess_user_user_id` ASC) ,
  CONSTRAINT `fk_session_user1`
    FOREIGN KEY (`sess_user_user_id` )
    REFERENCES `mydb`.`user` (`user_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`login_log`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`login_log` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`login_log` (
  `lolo_id` INT NOT NULL AUTO_INCREMENT COMMENT 'Login log id' ,
  `lolo_last_try` INT NULL COMMENT 'Specifies the last try to login\nTimestamp' ,
  `lolo_successfull` TINYINT(1) NULL COMMENT 'Specifies wether a login was successfull or not' ,
  `lolo_ip` CHAR(15) NULL COMMENT 'IP address of the client who tries to login' ,
  `lolo_login_id` VARCHAR(60) NULL COMMENT 'If the login fails, this is the login id  otherwise null' ,
  `lolo_user_user_id` INT NULL COMMENT 'User' ,
  PRIMARY KEY (`lolo_id`) ,
  INDEX `fk_login_log_user1` (`lolo_user_user_id` ASC) ,
  CONSTRAINT `fk_login_log_user1`
    FOREIGN KEY (`lolo_user_user_id` )
    REFERENCES `mydb`.`user` (`user_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`password_request`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`password_request` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`password_request` (
  `pare_id` INT NOT NULL AUTO_INCREMENT COMMENT 'Password request id' ,
  `pare_request_time` INT NULL COMMENT 'Specifies the time when the password code is requested\nTimestamp' ,
  `pare_request_code` CHAR(128) NULL COMMENT 'The request code\nHash value with SHA512' ,
  `pare_ip` CHAR(15) NULL COMMENT 'IP address of the user who requested' ,
  `pare_user_user_id` INT NULL COMMENT 'User\nIf user is null, then the request was not successfull' ,
  PRIMARY KEY (`pare_id`) ,
  INDEX `fk_password_request_user1` (`pare_user_user_id` ASC) ,
  CONSTRAINT `fk_password_request_user1`
    FOREIGN KEY (`pare_user_user_id` )
    REFERENCES `mydb`.`user` (`user_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`user_activision`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`user_activision` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`user_activision` (
  `usac_id` INT NOT NULL AUTO_INCREMENT COMMENT 'User avticision' ,
  `usac_request_time` INT NULL COMMENT 'Specifies the time when the activision code is requested\nTimestamp' ,
  `usac_request_code` CHAR(128) NULL COMMENT 'The activision code\nHash value with SHA512' ,
  `usac_user_user_id` INT NOT NULL COMMENT 'User' ,
  PRIMARY KEY (`usac_id`) ,
  INDEX `fk_user_activision_user1` (`usac_user_user_id` ASC) ,
  CONSTRAINT `fk_user_activision_user1`
    FOREIGN KEY (`usac_user_user_id` )
    REFERENCES `mydb`.`user` (`user_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`user_group`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`user_group` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`user_group` (
  `usgr_id` INT NOT NULL AUTO_INCREMENT COMMENT 'User group id' ,
  `usgr_name` VARCHAR(60) NULL COMMENT 'Name of the user group' ,
  `usgr_description` VARCHAR(60) NULL COMMENT 'Description of the user group' ,
  `usgr_menue_menu_id` INT NULL ,
  `usgr_parent_group_usgr_id` INT NULL ,
  PRIMARY KEY (`usgr_id`) ,
  INDEX `fk_user_group_menue1` (`usgr_menue_menu_id` ASC) ,
  INDEX `fk_user_group_user_group1` (`usgr_parent_group_usgr_id` ASC) ,
  CONSTRAINT `fk_user_group_menue1`
    FOREIGN KEY (`usgr_menue_menu_id` )
    REFERENCES `mydb`.`menue` (`menu_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_group_user_group1`
    FOREIGN KEY (`usgr_parent_group_usgr_id` )
    REFERENCES `mydb`.`user_group` (`usgr_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`user_group_has_user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`user_group_has_user` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`user_group_has_user` (
  `user_group_usgr_id` INT NOT NULL ,
  `user_user_id` INT NOT NULL ,
  PRIMARY KEY (`user_group_usgr_id`, `user_user_id`) ,
  INDEX `fk_user_group_has_user_user_group1` (`user_group_usgr_id` ASC) ,
  INDEX `fk_user_group_has_user_user1` (`user_user_id` ASC) ,
  CONSTRAINT `fk_user_group_has_user_user_group1`
    FOREIGN KEY (`user_group_usgr_id` )
    REFERENCES `mydb`.`user_group` (`usgr_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_group_has_user_user1`
    FOREIGN KEY (`user_user_id` )
    REFERENCES `mydb`.`user` (`user_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`module_group`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`module_group` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`module_group` (
  `mogr_id` INT NOT NULL ,
  `mogr_module_modu_id` INT NOT NULL ,
  `mogr_name` VARCHAR(60) NULL ,
  PRIMARY KEY (`mogr_id`) ,
  INDEX `fk_config_group_module1` (`mogr_module_modu_id` ASC) ,
  CONSTRAINT `fk_config_group_module1`
    FOREIGN KEY (`mogr_module_modu_id` )
    REFERENCES `mydb`.`module` (`modu_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`component_group`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`component_group` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`component_group` (
  `cogr_id` INT NOT NULL ,
  `cogr_module_group_mogr_id` INT NOT NULL ,
  `cogr_name` VARCHAR(60) NULL ,
  PRIMARY KEY (`cogr_id`) ,
  INDEX `fk_component_group_module_group1` (`cogr_module_group_mogr_id` ASC) ,
  CONSTRAINT `fk_component_group_module_group1`
    FOREIGN KEY (`cogr_module_group_mogr_id` )
    REFERENCES `mydb`.`module_group` (`mogr_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`property_class`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`property_class` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`property_class` (
  `prcl_id` INT NOT NULL ,
  `prcl_name` VARCHAR(60) NULL ,
  `prcl_description` VARCHAR(60) NULL ,
  `prcl_class` VARCHAR(60) NULL ,
  PRIMARY KEY (`prcl_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`property_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`property_type` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`property_type` (
  `prty_id` INT NOT NULL ,
  `prty_type_class_prcl_id` INT NOT NULL ,
  `prty_validator_class_prcl_id` INT NOT NULL ,
  PRIMARY KEY (`prty_id`) ,
  INDEX `fk_property_type_property_class1` (`prty_type_class_prcl_id` ASC) ,
  INDEX `fk_property_type_property_class2` (`prty_validator_class_prcl_id` ASC) ,
  CONSTRAINT `fk_property_type_property_class1`
    FOREIGN KEY (`prty_type_class_prcl_id` )
    REFERENCES `mydb`.`property_class` (`prcl_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_property_type_property_class2`
    FOREIGN KEY (`prty_validator_class_prcl_id` )
    REFERENCES `mydb`.`property_class` (`prcl_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`property`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`property` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`property` (
  `prop_id` INT NOT NULL ,
  `prop_component_group_cogr_id` INT NOT NULL ,
  `prop_name` VARCHAR(60) NULL ,
  `prop_label` VARCHAR(60) NULL ,
  `prop_value` TEXT NULL ,
  `prop_property_type_prty_id` INT NOT NULL ,
  PRIMARY KEY (`prop_id`) ,
  INDEX `fk_property_component_group1` (`prop_component_group_cogr_id` ASC) ,
  INDEX `fk_property_property_type1` (`prop_property_type_prty_id` ASC) ,
  CONSTRAINT `fk_property_component_group1`
    FOREIGN KEY (`prop_component_group_cogr_id` )
    REFERENCES `mydb`.`component_group` (`cogr_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_property_property_type1`
    FOREIGN KEY (`prop_property_type_prty_id` )
    REFERENCES `mydb`.`property_type` (`prty_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`permission`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`permission` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`permission` (
  `perm_id` INT NOT NULL AUTO_INCREMENT COMMENT 'Permission id' ,
  `perm_permission` INT NULL COMMENT 'Bitfield for permission' ,
  `perm_user_user_id` INT NULL COMMENT 'User' ,
  `perm_user_group_usgr_id` INT NULL COMMENT 'User group' ,
  `perm_property_prop_id` INT NULL ,
  `perm_component_group_cogr_id` INT NULL ,
  `perm_module_group_mogr_id` INT NULL ,
  `perm_module_modu_id` INT NULL ,
  PRIMARY KEY (`perm_id`) ,
  INDEX `fk_permission_user1` (`perm_user_user_id` ASC) ,
  INDEX `fk_permission_user_group1` (`perm_user_group_usgr_id` ASC) ,
  INDEX `fk_permission_property1` (`perm_property_prop_id` ASC) ,
  INDEX `fk_permission_component_group1` (`perm_component_group_cogr_id` ASC) ,
  INDEX `fk_permission_module_group1` (`perm_module_group_mogr_id` ASC) ,
  INDEX `fk_permission_module1` (`perm_module_modu_id` ASC) ,
  CONSTRAINT `fk_permission_user1`
    FOREIGN KEY (`perm_user_user_id` )
    REFERENCES `mydb`.`user` (`user_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_permission_user_group1`
    FOREIGN KEY (`perm_user_group_usgr_id` )
    REFERENCES `mydb`.`user_group` (`usgr_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_permission_property1`
    FOREIGN KEY (`perm_property_prop_id` )
    REFERENCES `mydb`.`property` (`prop_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_permission_component_group1`
    FOREIGN KEY (`perm_component_group_cogr_id` )
    REFERENCES `mydb`.`component_group` (`cogr_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_permission_module_group1`
    FOREIGN KEY (`perm_module_group_mogr_id` )
    REFERENCES `mydb`.`module_group` (`mogr_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_permission_module1`
    FOREIGN KEY (`perm_module_modu_id` )
    REFERENCES `mydb`.`module` (`modu_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`log`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`log` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`log` (
  `log_id` INT NOT NULL AUTO_INCREMENT ,
  `log_added` INT NULL COMMENT 'Timestamp' ,
  `log_type` INT NULL ,
  `log_priority` INT NULL ,
  `log_description` TEXT NULL ,
  `log_ip` CHAR(15) NULL ,
  `log_url` VARCHAR(60) NULL ,
  PRIMARY KEY (`log_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`module_dependency`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`module_dependency` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`module_dependency` (
  `mode_id` INT NOT NULL AUTO_INCREMENT ,
  `mode_uid` VARCHAR(60) NULL ,
  `mode_module_modu_id` INT NOT NULL ,
  PRIMARY KEY (`mode_id`) ,
  INDEX `fk_module_dependency_module1` (`mode_module_modu_id` ASC) ,
  CONSTRAINT `fk_module_dependency_module1`
    FOREIGN KEY (`mode_module_modu_id` )
    REFERENCES `mydb`.`module` (`modu_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`product_group_has_product`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`product_group_has_product` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`product_group_has_product` (
  `product_group_prgr_id` INT NOT NULL ,
  `product_prod_id` INT NOT NULL ,
  PRIMARY KEY (`product_group_prgr_id`, `product_prod_id`) ,
  INDEX `fk_product_group_has_product_product_group1` (`product_group_prgr_id` ASC) ,
  INDEX `fk_product_group_has_product_product1` (`product_prod_id` ASC) ,
  CONSTRAINT `fk_product_group_has_product_product_group1`
    FOREIGN KEY (`product_group_prgr_id` )
    REFERENCES `mydb`.`product_group` (`prgr_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_product_group_has_product_product1`
    FOREIGN KEY (`product_prod_id` )
    REFERENCES `mydb`.`product` (`prod_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`attribute`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`attribute` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`attribute` (
  `attr_id` INT NOT NULL ,
  `attr_name` VARCHAR(60) NULL ,
  `attr_label` VARCHAR(60) NULL ,
  `attr_required` TINYINT(1) NULL ,
  `attr_searchable` TINYINT(1) NULL ,
  `attr_filterable` TINYINT(1) NULL ,
  PRIMARY KEY (`attr_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`attribute_value`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`attribute_value` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`attribute_value` (
  `atva_id` INT NOT NULL ,
  `atva_value` VARCHAR(60) NULL ,
  `atva_attribute_attr_id` INT NOT NULL ,
  PRIMARY KEY (`atva_id`) ,
  INDEX `fk_attribute_value_attribute1` (`atva_attribute_attr_id` ASC) ,
  CONSTRAINT `fk_attribute_value_attribute1`
    FOREIGN KEY (`atva_attribute_attr_id` )
    REFERENCES `mydb`.`attribute` (`attr_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`product_group_has_attribute_value`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`product_group_has_attribute_value` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`product_group_has_attribute_value` (
  `product_group_prgr_id` INT NOT NULL ,
  `attribute_value_atva_id` INT NOT NULL ,
  PRIMARY KEY (`product_group_prgr_id`, `attribute_value_atva_id`) ,
  INDEX `fk_product_group_has_attribute_value_product_group1` (`product_group_prgr_id` ASC) ,
  INDEX `fk_product_group_has_attribute_value_attribute_value1` (`attribute_value_atva_id` ASC) ,
  CONSTRAINT `fk_product_group_has_attribute_value_product_group1`
    FOREIGN KEY (`product_group_prgr_id` )
    REFERENCES `mydb`.`product_group` (`prgr_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_product_group_has_attribute_value_attribute_value1`
    FOREIGN KEY (`attribute_value_atva_id` )
    REFERENCES `mydb`.`attribute_value` (`atva_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`product_has_attribute_value`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`product_has_attribute_value` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`product_has_attribute_value` (
  `product_prod_id` INT NOT NULL ,
  `attribute_value_atva_id` INT NOT NULL ,
  PRIMARY KEY (`product_prod_id`, `attribute_value_atva_id`) ,
  INDEX `fk_product_has_attribute_value_product1` (`product_prod_id` ASC) ,
  INDEX `fk_product_has_attribute_value_attribute_value1` (`attribute_value_atva_id` ASC) ,
  CONSTRAINT `fk_product_has_attribute_value_product1`
    FOREIGN KEY (`product_prod_id` )
    REFERENCES `mydb`.`product` (`prod_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_product_has_attribute_value_attribute_value1`
    FOREIGN KEY (`attribute_value_atva_id` )
    REFERENCES `mydb`.`attribute_value` (`atva_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`customer_group`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`customer_group` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`customer_group` (
  `cugr_id` INT NOT NULL ,
  `cugr_user_group_usgr_id` INT NOT NULL ,
  `cugr_discount` INT NULL ,
  `cugr_discount_from` DATE NULL ,
  `cugr_discount_to` DATE NULL ,
  PRIMARY KEY (`cugr_id`) ,
  INDEX `fk_customer_group_user_group1` (`cugr_user_group_usgr_id` ASC) ,
  CONSTRAINT `fk_customer_group_user_group1`
    FOREIGN KEY (`cugr_user_group_usgr_id` )
    REFERENCES `mydb`.`user_group` (`usgr_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`payment_entry`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`payment_entry` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`payment_entry` (
  `paen_id` INT NOT NULL ,
  `paen_amount` DECIMAL(10,0) NULL ,
  `paen_date` DATE NULL ,
  `paen_data` TEXT NULL ,
  `paen_currency_curr_id` INT NOT NULL ,
  `payment_type_paty_id` INT NOT NULL ,
  `paypal_payment_papa_id` INT NULL ,
  PRIMARY KEY (`paen_id`) ,
  INDEX `fk_payment_entry_currency1` (`paen_currency_curr_id` ASC) ,
  INDEX `fk_payment_entry_payment_type1` (`payment_type_paty_id` ASC) ,
  INDEX `fk_payment_entry_paypal_payment1` (`paypal_payment_papa_id` ASC) ,
  CONSTRAINT `fk_payment_entry_currency1`
    FOREIGN KEY (`paen_currency_curr_id` )
    REFERENCES `mydb`.`currency` (`curr_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_payment_entry_payment_type1`
    FOREIGN KEY (`payment_type_paty_id` )
    REFERENCES `mydb`.`payment_method` (`pame_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_payment_entry_paypal_payment1`
    FOREIGN KEY (`paypal_payment_papa_id` )
    REFERENCES `mydb`.`paypal_payment` (`papa_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`payment_has_payment_entry`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`payment_has_payment_entry` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`payment_has_payment_entry` (
  `payment_paym_id` INT NOT NULL ,
  `payment_entry_paen_id` INT NOT NULL ,
  PRIMARY KEY (`payment_paym_id`, `payment_entry_paen_id`) ,
  INDEX `fk_payment_has_payment_entry_payment1` (`payment_paym_id` ASC) ,
  INDEX `fk_payment_has_payment_entry_payment_entry1` (`payment_entry_paen_id` ASC) ,
  CONSTRAINT `fk_payment_has_payment_entry_payment1`
    FOREIGN KEY (`payment_paym_id` )
    REFERENCES `mydb`.`payment` (`paym_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_payment_has_payment_entry_payment_entry1`
    FOREIGN KEY (`payment_entry_paen_id` )
    REFERENCES `mydb`.`payment_entry` (`paen_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`project_has_person`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`project_has_person` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`project_has_person` (
  `project_proj_id` INT NOT NULL ,
  `person_pers_id` INT NOT NULL ,
  PRIMARY KEY (`project_proj_id`, `person_pers_id`) ,
  INDEX `fk_project_has_person_project1` (`project_proj_id` ASC) ,
  INDEX `fk_project_has_person_person1` (`person_pers_id` ASC) ,
  CONSTRAINT `fk_project_has_person_project1`
    FOREIGN KEY (`project_proj_id` )
    REFERENCES `mydb`.`project` (`proj_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_project_has_person_person1`
    FOREIGN KEY (`person_pers_id` )
    REFERENCES `mydb`.`person` (`pers_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`tax`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`tax` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`tax` (
  `tax_id` INT NOT NULL ,
  `tax_value` DECIMAL(10,0) NULL ,
  `country_coun_id` CHAR(2) NOT NULL ,
  `province_prov_id` INT NOT NULL ,
  `tax_class_tacl_id` INT NOT NULL ,
  PRIMARY KEY (`tax_id`) ,
  INDEX `fk_tax_country1` (`country_coun_id` ASC) ,
  INDEX `fk_tax_province1` (`province_prov_id` ASC) ,
  INDEX `fk_tax_tax_class1` (`tax_class_tacl_id` ASC) ,
  CONSTRAINT `fk_tax_country1`
    FOREIGN KEY (`country_coun_id` )
    REFERENCES `mydb`.`country` (`coun_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tax_province1`
    FOREIGN KEY (`province_prov_id` )
    REFERENCES `mydb`.`province` (`prov_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tax_tax_class1`
    FOREIGN KEY (`tax_class_tacl_id` )
    REFERENCES `mydb`.`tax_class` (`tacl_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`photo_show`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`photo_show` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`photo_show` (
  `phsh_id` INT NOT NULL ,
  `phsh_name` VARCHAR(60) NULL ,
  `phsh_description` VARCHAR(60) NULL ,
  PRIMARY KEY (`phsh_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`photo_entry`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`photo_entry` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`photo_entry` (
  `phen_id` INT NOT NULL ,
  `phen_text` VARCHAR(255) NULL ,
  `phen_builder` VARCHAR(255) NULL ,
  `phen_order` INT NULL ,
  `phen_duration` DECIMAL(10,0) NULL ,
  `phen_photo_show_phsh_id` INT NOT NULL ,
  `phen_picture_pict_id` INT NULL ,
  `phen_available_product_avpr_id` INT NULL ,
  PRIMARY KEY (`phen_id`) ,
  INDEX `fk_photo_entry_photo_show1` (`phen_photo_show_phsh_id` ASC) ,
  INDEX `fk_photo_entry_picture1` (`phen_picture_pict_id` ASC) ,
  INDEX `fk_photo_entry_available_product1` (`phen_available_product_avpr_id` ASC) ,
  CONSTRAINT `fk_photo_entry_photo_show1`
    FOREIGN KEY (`phen_photo_show_phsh_id` )
    REFERENCES `mydb`.`photo_show` (`phsh_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_photo_entry_picture1`
    FOREIGN KEY (`phen_picture_pict_id` )
    REFERENCES `mydb`.`picture` (`pict_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_photo_entry_available_product1`
    FOREIGN KEY (`phen_available_product_avpr_id` )
    REFERENCES `mydb`.`available_product` (`avpr_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`test`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`test` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`test` (
  `test_decimal` DECIMAL(30,10) NOT NULL ,
  `test_date` DATE NULL ,
  `test_time` TIME NULL ,
  `test_timestamp` TIMESTAMP NULL ,
  `test_datetime` DATETIME NULL ,
  `test_blob` BLOB NULL ,
  `test` INT NULL ,
  PRIMARY KEY (`test_decimal`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`accessory`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`accessory` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`accessory` (
  `product_prod_id` INT NOT NULL ,
  `product_prod_id1` INT NOT NULL ,
  PRIMARY KEY (`product_prod_id`, `product_prod_id1`) ,
  INDEX `fk_product_has_product_product1` (`product_prod_id` ASC) ,
  INDEX `fk_product_has_product_product2` (`product_prod_id1` ASC) ,
  CONSTRAINT `fk_product_has_product_product1`
    FOREIGN KEY (`product_prod_id` )
    REFERENCES `mydb`.`product` (`prod_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_product_has_product_product2`
    FOREIGN KEY (`product_prod_id1` )
    REFERENCES `mydb`.`product` (`prod_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`picture_group`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`picture_group` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`picture_group` (
  `pigr_id` INT NOT NULL ,
  `pigr_name` VARCHAR(60) NULL ,
  `pigr_description` VARCHAR(60) NULL ,
  PRIMARY KEY (`pigr_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`picture_group_has_picture`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`picture_group_has_picture` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`picture_group_has_picture` (
  `picture_group_pigr_id` INT NOT NULL ,
  `picture_pict_id` INT NOT NULL ,
  PRIMARY KEY (`picture_group_pigr_id`, `picture_pict_id`) ,
  INDEX `fk_picture_group_has_picture_picture_group1` (`picture_group_pigr_id` ASC) ,
  INDEX `fk_picture_group_has_picture_picture1` (`picture_pict_id` ASC) ,
  CONSTRAINT `fk_picture_group_has_picture_picture_group1`
    FOREIGN KEY (`picture_group_pigr_id` )
    REFERENCES `mydb`.`picture_group` (`pigr_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_picture_group_has_picture_picture1`
    FOREIGN KEY (`picture_pict_id` )
    REFERENCES `mydb`.`picture` (`pict_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`sub_picture`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`sub_picture` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`sub_picture` (
  `supi_id` INT NOT NULL ,
  `supi_name` VARCHAR(60) NULL ,
  `supi_x` INT NULL ,
  `supi_y` INT NULL ,
  `supi_width` INT NULL ,
  `supi_height` INT NULL ,
  PRIMARY KEY (`supi_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`article_group`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`article_group` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`article_group` (
  `argr_id` INT NOT NULL ,
  `argr_name` VARCHAR(60) NULL ,
  `argr_description` VARCHAR(60) NULL ,
  PRIMARY KEY (`argr_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`article`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`article` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`article` (
  `arti_id` INT NOT NULL ,
  `arti_headline` VARCHAR(60) NULL ,
  `arti_subheadline` VARCHAR(60) NULL ,
  `arti_added` DATE NULL ,
  `arti_text` TEXT NULL ,
  `arti_article_group_argr_id` INT NOT NULL ,
  `arti_entry_status_enst_id` INT NOT NULL ,
  `arti_author_user_id` INT NOT NULL ,
  PRIMARY KEY (`arti_id`) ,
  INDEX `fk_article_article_group1` (`arti_article_group_argr_id` ASC) ,
  INDEX `fk_article_entry_status1` (`arti_entry_status_enst_id` ASC) ,
  INDEX `fk_article_user1` (`arti_author_user_id` ASC) ,
  CONSTRAINT `fk_article_article_group1`
    FOREIGN KEY (`arti_article_group_argr_id` )
    REFERENCES `mydb`.`article_group` (`argr_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_article_entry_status1`
    FOREIGN KEY (`arti_entry_status_enst_id` )
    REFERENCES `mydb`.`entry_status` (`enst_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_article_user1`
    FOREIGN KEY (`arti_author_user_id` )
    REFERENCES `mydb`.`user` (`user_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `mydb`.`zipcode`
-- -----------------------------------------------------
SET AUTOCOMMIT=0;
USE `mydb`;
INSERT INTO `zipcode` (`zipc_code`) VALUES ('3100');

COMMIT;

-- -----------------------------------------------------
-- Data for table `mydb`.`city`
-- -----------------------------------------------------
SET AUTOCOMMIT=0;
USE `mydb`;
INSERT INTO `city` (`city_id`, `city_name`) VALUES (1, 'St.Pölten');

COMMIT;

-- -----------------------------------------------------
-- Data for table `mydb`.`country`
-- -----------------------------------------------------
SET AUTOCOMMIT=0;
USE `mydb`;
INSERT INTO `country` (`coun_id`, `coun_name`, `coun_printable_name`, `coun_iso3`, `coun_area_code`, `coun_flag_pict_id`) VALUES ('AT', 'AUSTRIA', 'Austria', 'AUT', '43', null);

COMMIT;

-- -----------------------------------------------------
-- Data for table `mydb`.`province`
-- -----------------------------------------------------
SET AUTOCOMMIT=0;
USE `mydb`;
INSERT INTO `province` (`prov_id`, `prov_name`, `prov_code`) VALUES (1, 'Niederösterreich', 'NOE');

COMMIT;

-- -----------------------------------------------------
-- Data for table `mydb`.`location`
-- -----------------------------------------------------
SET AUTOCOMMIT=0;
USE `mydb`;
INSERT INTO `location` (`loca_id`, `loca_zipc_id`, `loca_coun_id`, `loca_city_id`, `province_prov_id`) VALUES (1, '3100', 'AT', 1, 1);

COMMIT;

-- -----------------------------------------------------
-- Data for table `mydb`.`currency`
-- -----------------------------------------------------
SET AUTOCOMMIT=0;
USE `mydb`;
INSERT INTO `currency` (`curr_id`, `curr_name`, `curr_symbol`, `curr_code`) VALUES (1, 'Euro', '€', 'EUR');
INSERT INTO `currency` (`curr_id`, `curr_name`, `curr_symbol`, `curr_code`) VALUES (2, 'US Dollar', '$', 'USD');

COMMIT;

-- -----------------------------------------------------
-- Data for table `mydb`.`contact_detail`
-- -----------------------------------------------------
SET AUTOCOMMIT=0;
USE `mydb`;
INSERT INTO `contact_detail` (`code_id`, `code_name`, `code_url`, `code_phone1`, `code_phone2`, `code_fax1`, `code_fax2`, `code_email1`, `code_email2`, `location_loca_id`) VALUES (1, '', '', '', '', '', '', '', '', 1);
INSERT INTO `contact_detail` (`code_id`, `code_name`, `code_url`, `code_phone1`, `code_phone2`, `code_fax1`, `code_fax2`, `code_email1`, `code_email2`, `location_loca_id`) VALUES (2, 'Post AG', 'http://www.post.at', '', '', '', '', '', '', 1);

COMMIT;

-- -----------------------------------------------------
-- Data for table `mydb`.`order_status`
-- -----------------------------------------------------
SET AUTOCOMMIT=0;
USE `mydb`;
INSERT INTO `order_status` (`orst_id`, `orst_name`, `orst_description`) VALUES (1, 'Offen', 'Die Bestellung wurde noch nicht bearbeitet');
INSERT INTO `order_status` (`orst_id`, `orst_name`, `orst_description`) VALUES (2, 'In Bearbeitung', 'Die Bestellung wird bearbeitet');
INSERT INTO `order_status` (`orst_id`, `orst_name`, `orst_description`) VALUES (3, 'Versendet', 'Die Bestellung wurde versandt');

COMMIT;

-- -----------------------------------------------------
-- Data for table `mydb`.`payment_type`
-- -----------------------------------------------------
SET AUTOCOMMIT=0;
USE `mydb`;
INSERT INTO `payment_type` (`paty_id`, `paty_name`, `paty_description`) VALUES (1, 'Barzahlung', 'Barzahlung bei Abholung');
INSERT INTO `payment_type` (`paty_id`, `paty_name`, `paty_description`) VALUES (2, 'Vorauszahlung', 'Zahlung vor der Abholung/Lieferung');
INSERT INTO `payment_type` (`paty_id`, `paty_name`, `paty_description`) VALUES (3, 'Teilzahlung', 'Zahlung erfolgt in 3 Schritten, Anzahlung, Teilzahlung und Schlusszahlung');
INSERT INTO `payment_type` (`paty_id`, `paty_name`, `paty_description`) VALUES (4, 'Nachname', 'Zahlung bei der übergabe der Ware');

COMMIT;

-- -----------------------------------------------------
-- Data for table `mydb`.`payment_method`
-- -----------------------------------------------------
SET AUTOCOMMIT=0;
USE `mydb`;
INSERT INTO `payment_method` (`pame_id`, `pame_name`, `pame_description`) VALUES (1, 'Barzahlung', 'Barzahlung bei Abbholung');
INSERT INTO `payment_method` (`pame_id`, `pame_name`, `pame_description`) VALUES (2, 'Kreditkarte', 'Zahlung mit Kreditkarte');
INSERT INTO `payment_method` (`pame_id`, `pame_name`, `pame_description`) VALUES (3, 'Banküberweisung', 'Überweisung an ein Bankkonto');

COMMIT;

-- -----------------------------------------------------
-- Data for table `mydb`.`delivery_type`
-- -----------------------------------------------------
SET AUTOCOMMIT=0;
USE `mydb`;
INSERT INTO `delivery_type` (`dety_id`, `dety_name`, `dety_description`) VALUES (1, 'Abholung', 'Die Ware wird bei der Abholung übergeben');
INSERT INTO `delivery_type` (`dety_id`, `dety_name`, `dety_description`) VALUES (2, 'Lieferung', 'Die Ware wird geliefert');

COMMIT;

-- -----------------------------------------------------
-- Data for table `mydb`.`delivery`
-- -----------------------------------------------------
SET AUTOCOMMIT=0;
USE `mydb`;
INSERT INTO `delivery` (`deli_id`, `deli_price`, `deli_lump_sum`, `deli_added`, `deli_dety_id`, `deli_deliverer_code_id`) VALUES (1, 0, 0, '2010-05-26', 1, NULL);
INSERT INTO `delivery` (`deli_id`, `deli_price`, `deli_lump_sum`, `deli_added`, `deli_dety_id`, `deli_deliverer_code_id`) VALUES (2, 3, 5, '2010-05-26', 2, 2);

COMMIT;

-- -----------------------------------------------------
-- Data for table `mydb`.`person`
-- -----------------------------------------------------
SET AUTOCOMMIT=0;
USE `mydb`;
INSERT INTO `person` (`pers_id`, `pers_firstname`, `pers_lastname`, `pers_gender`, `pers_birthday`, `pers_contact_code_id`) VALUES (1, 'Christian', 'Beikov', 'M', '1991-01-21', 1);

COMMIT;

-- -----------------------------------------------------
-- Data for table `mydb`.`user`
-- -----------------------------------------------------
SET AUTOCOMMIT=0;
USE `mydb`;
INSERT INTO `user` (`user_id`, `user_name`, `user_email`, `user_password`, `user_added`, `user_last_login`, `user_available`, `user_available_from`, `user_available_to`, `user_person_pers_id`, `user_menue_menu_id`) VALUES (1, 'admin', 'admin@blazebit.com', '123', '2010-05-25', NULL, 1, NULL, NULL, 1, NULL);

COMMIT;

-- -----------------------------------------------------
-- Data for table `mydb`.`user_group`
-- -----------------------------------------------------
SET AUTOCOMMIT=0;
USE `mydb`;
INSERT INTO `user_group` (`usgr_id`, `usgr_name`, `usgr_description`, `usgr_menue_menu_id`, `usgr_parent_group_usgr_id`) VALUES (1, 'Administrator', 'The user group for administrators', null, null);

COMMIT;

-- -----------------------------------------------------
-- Data for table `mydb`.`user_group_has_user`
-- -----------------------------------------------------
SET AUTOCOMMIT=0;
USE `mydb`;
INSERT INTO `user_group_has_user` (`user_group_usgr_id`, `user_user_id`) VALUES (1, 1);

COMMIT;

-- -----------------------------------------------------
-- Data for table `mydb`.`permission`
-- -----------------------------------------------------
SET AUTOCOMMIT=0;
USE `mydb`;
INSERT INTO `permission` (`perm_id`, `perm_permission`, `perm_user_user_id`, `perm_user_group_usgr_id`, `perm_property_prop_id`, `perm_component_group_cogr_id`, `perm_module_group_mogr_id`, `perm_module_modu_id`) VALUES (1, 8, null, 1, null, null, null, null);

COMMIT;
