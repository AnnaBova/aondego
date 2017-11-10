/*
SQLyog Ultimate v12.09 (64 bit)
MySQL - 5.5.41-log : Database - restomulti
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `addon` */

DROP TABLE IF EXISTS `addon`;

CREATE TABLE `addon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `price` float(8,2) DEFAULT NULL,
  `time_in_minutes` int(11) NOT NULL DEFAULT '0',
  `merchant_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`merchant_id`),
  KEY `fk_merch_addon123` (`merchant_id`),
  CONSTRAINT `fk_merch_addon123` FOREIGN KEY (`merchant_id`) REFERENCES `mt_merchant` (`merchant_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

/*Data for the table `addon` */

insert  into `addon`(`id`,`name`,`price`,`time_in_minutes`,`merchant_id`) values (9,'Dekoltee Massage',110.00,20,2),(10,'Mandelöl',10.00,0,2),(11,'Microdermabrasion',75.00,45,2),(12,'Needling',30.00,30,2);

/*Table structure for table `addon_has_order` */

DROP TABLE IF EXISTS `addon_has_order`;

CREATE TABLE `addon_has_order` (
  `addon_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  PRIMARY KEY (`addon_id`,`order_id`),
  KEY `fk_addon_has_order_order1_idx` (`order_id`),
  KEY `fk_addon_has_order_addon1_idx` (`addon_id`),
  CONSTRAINT `fk_addon_has_order_addon1` FOREIGN KEY (`addon_id`) REFERENCES `addon` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_addon_has_order_order1` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `addon_has_order` */

insert  into `addon_has_order`(`addon_id`,`order_id`) values (9,42),(9,43),(9,44);

/*Table structure for table `addon_has_staff` */

DROP TABLE IF EXISTS `addon_has_staff`;

CREATE TABLE `addon_has_staff` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL,
  `addon_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`staff_id`,`addon_id`),
  KEY `fk_addon_staff_k` (`staff_id`),
  KEY `fk_addon_id_kk` (`addon_id`),
  CONSTRAINT `fk_addon_id_kk` FOREIGN KEY (`addon_id`) REFERENCES `addon` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_addon_staff_k` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8;

/*Data for the table `addon_has_staff` */

insert  into `addon_has_staff`(`id`,`staff_id`,`addon_id`) values (84,6,9),(85,6,10),(83,9,11),(89,10,11),(90,10,12),(86,12,9),(87,12,11),(88,12,12);

/*Table structure for table `category` */

DROP TABLE IF EXISTS `category`;

CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `category` */

/*Table structure for table `category_has_merchant` */

DROP TABLE IF EXISTS `category_has_merchant`;

CREATE TABLE `category_has_merchant` (
  `category_id` int(11) NOT NULL,
  `merchant_id` int(11) NOT NULL,
  `price` float(8,2) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time_in_minutes` int(11) NOT NULL DEFAULT '0',
  `additional_time` int(11) NOT NULL DEFAULT '0',
  `service_time_slot` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `group_people` int(11) NOT NULL DEFAULT '0',
  `is_group` tinyint(1) NOT NULL DEFAULT '0',
  `staff_id` int(11) DEFAULT NULL,
  `color` varchar(255) NOT NULL DEFAULT '',
  `description` text,
  PRIMARY KEY (`category_id`,`merchant_id`,`id`),
  KEY `fk_category_has_merchant_merchant1_idx` (`merchant_id`),
  KEY `fk_category_has_merchant_category1_idx` (`category_id`),
  KEY `id` (`id`),
  KEY `staff_id` (`staff_id`),
  CONSTRAINT `category_has_merchant_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fc_merch` FOREIGN KEY (`merchant_id`) REFERENCES `mt_merchant` (`merchant_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_cat_111_ppr` FOREIGN KEY (`category_id`) REFERENCES `mt_service_subcategory` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

/*Data for the table `category_has_merchant` */

insert  into `category_has_merchant`(`category_id`,`merchant_id`,`price`,`is_active`,`id`,`time_in_minutes`,`additional_time`,`service_time_slot`,`title`,`group_people`,`is_group`,`staff_id`,`color`,`description`) values (4,2,79.00,1,14,60,0,60,'Gesichtsbehandlung Basic',0,0,NULL,'#4fc3f7',NULL),(4,2,45.00,1,16,60,0,0,'Test classs',15,1,6,'#1de9b6',NULL),(4,2,129.00,1,21,90,0,90,'Gesichtsbehandlung Premium',0,0,NULL,'#827717',NULL),(4,2,179.00,1,22,120,0,120,'Gesichtsbehandlung Deluxe',0,0,NULL,'#66bb6a',NULL),(4,3,99.00,1,2,90,10,90,'Erstbehandlung mit Hautanalyse',0,0,NULL,'#311b92',NULL),(5,2,45.00,1,13,30,10,30,'Haarentfernung',0,0,NULL,'#ff3d00',NULL),(5,2,49.00,1,17,30,0,30,'Haarentfernung Laser 30 Min.',0,0,NULL,'#ffeb3b',NULL),(12,2,35.00,1,7,60,0,0,'Makeup class',15,1,NULL,'#f48fb1',NULL),(12,2,149.00,1,18,90,0,90,'Hochzeitsstyling',0,0,NULL,'#795548',NULL),(15,2,99.00,1,19,120,0,120,'Lomi Lomi Nui',0,0,NULL,'#757575',NULL),(15,2,39.00,1,20,30,0,30,'Ultratone',0,0,NULL,'#ce93d8',NULL),(16,2,49.00,1,23,30,0,30,'Brazilian Bikini',0,0,NULL,'#4a148c',NULL);

/*Table structure for table `client` */

DROP TABLE IF EXISTS `client`;

CREATE TABLE `client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `client` */

/*Table structure for table `gallery` */

DROP TABLE IF EXISTS `gallery`;

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `versions_data` text NOT NULL,
  `name` tinyint(1) NOT NULL DEFAULT '1',
  `description` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `gallery` */

insert  into `gallery`(`id`,`versions_data`,`name`,`description`) values (1,'a:2:{s:5:\"small\";a:1:{s:15:\"centeredpreview\";a:2:{i:0;i:98;i:1;i:98;}}s:6:\"medium\";a:1:{s:6:\"resize\";a:2:{i:0;i:800;i:1;N;}}}',1,1),(2,'a:2:{s:5:\"small\";a:1:{s:15:\"centeredpreview\";a:2:{i:0;i:98;i:1;i:98;}}s:6:\"medium\";a:1:{s:6:\"resize\";a:2:{i:0;i:800;i:1;N;}}}',1,1);

/*Table structure for table `gallery_photo` */

DROP TABLE IF EXISTS `gallery_photo`;

CREATE TABLE `gallery_photo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gallery_id` int(11) NOT NULL,
  `rank` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `description` text,
  `file_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_gallery_photo_gallery1` (`gallery_id`),
  CONSTRAINT `fk_gallery_photo_gallery1` FOREIGN KEY (`gallery_id`) REFERENCES `gallery` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `gallery_photo` */

insert  into `gallery_photo`(`id`,`gallery_id`,`rank`,`name`,`description`,`file_name`) values (1,1,1,'test 2','test test test','laden4.jpg'),(2,1,2,'test 1','test test','laden3.jpg'),(3,1,3,'test 3','test test tetst tets','laden2.jpg'),(4,2,4,'Eingang','Eingang Frontansicht','img4040.jpg');

/*Table structure for table `group_order` */

DROP TABLE IF EXISTS `group_order`;

CREATE TABLE `group_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `user_name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `service_id` int(11) NOT NULL,
  `servise_date` int(11) NOT NULL DEFAULT '0',
  `more_info` varchar(510) NOT NULL DEFAULT '',
  `price` float(8,2) NOT NULL DEFAULT '0.00',
  `is_payd` tinyint(1) NOT NULL DEFAULT '0',
  `status_id` int(3) NOT NULL DEFAULT '0',
  `merchant_id` int(11) NOT NULL DEFAULT '0',
  `create_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

/*Data for the table `group_order` */

insert  into `group_order`(`id`,`user_id`,`user_name`,`phone`,`email`,`service_id`,`servise_date`,`more_info`,`price`,`is_payd`,`status_id`,`merchant_id`,`create_time`) values (10,0,'mimi','098765','mimi@test.de',7,1463389200,'einfach nur ein test',0.00,0,3,2,'0000-00-00 00:00:00'),(11,0,'puppi','1234567','pup@test.de',7,1463389200,'weiterer test',0.00,0,0,2,'0000-00-00 00:00:00');

/*Table structure for table `group_schedule` */

DROP TABLE IF EXISTS `group_schedule`;

CREATE TABLE `group_schedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `work_date` date NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `group_id` int(11) NOT NULL,
  `reason` varchar(520) NOT NULL DEFAULT '',
  `schedule_days_template_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_staff_schedule_staff1_idx` (`group_id`),
  KEY `schedule_days_template_id` (`schedule_days_template_id`),
  CONSTRAINT `group_schedule_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `category_has_merchant` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `group_schedule` */

insert  into `group_schedule`(`id`,`work_date`,`status`,`group_id`,`reason`,`schedule_days_template_id`) values (1,'2016-06-10',0,16,'class',3);

/*Table structure for table `group_schedule_days_template` */

DROP TABLE IF EXISTS `group_schedule_days_template`;

CREATE TABLE `group_schedule_days_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(45) DEFAULT NULL,
  `merchant_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`merchant_id`),
  KEY `merchant_id` (`merchant_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `group_schedule_days_template` */

insert  into `group_schedule_days_template`(`id`,`title`,`merchant_id`) values (3,'Makeup Class',2),(5,'Test class',2);

/*Table structure for table `group_schedule_history` */

DROP TABLE IF EXISTS `group_schedule_history`;

CREATE TABLE `group_schedule_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `mon` int(11) DEFAULT NULL,
  `tue` int(11) DEFAULT NULL,
  `wed` int(11) DEFAULT NULL,
  `thu` int(11) DEFAULT NULL,
  `fri` int(11) DEFAULT NULL,
  `sat` int(11) DEFAULT NULL,
  `sun` int(11) DEFAULT NULL,
  `change_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `staff_id` (`group_id`),
  KEY `mon` (`mon`),
  KEY `tue` (`tue`),
  KEY `wed` (`wed`),
  KEY `thu` (`thu`),
  KEY `fri` (`fri`),
  KEY `sat` (`sat`),
  KEY `sun` (`sun`),
  CONSTRAINT `group_schedule_history_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `category_has_merchant` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

/*Data for the table `group_schedule_history` */

insert  into `group_schedule_history`(`id`,`group_id`,`mon`,`tue`,`wed`,`thu`,`fri`,`sat`,`sun`,`change_date`) values (2,7,NULL,NULL,2,NULL,NULL,NULL,2,NULL),(6,7,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(7,7,NULL,3,NULL,3,NULL,NULL,NULL,NULL),(11,7,NULL,3,NULL,3,NULL,NULL,NULL,NULL),(12,7,3,NULL,3,NULL,3,NULL,NULL,NULL),(14,16,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(15,16,5,NULL,NULL,5,NULL,NULL,NULL,NULL),(16,7,3,NULL,3,NULL,3,NULL,NULL,NULL),(17,16,5,NULL,NULL,5,NULL,NULL,NULL,NULL);

/*Table structure for table `group_time_range` */

DROP TABLE IF EXISTS `group_time_range`;

CREATE TABLE `group_time_range` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time_start` varchar(45) NOT NULL,
  `group_schedule_days_template_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_time_range_schedule_days_template_idx` (`group_schedule_days_template_id`),
  CONSTRAINT `group_time_range_ibfk_1` FOREIGN KEY (`group_schedule_days_template_id`) REFERENCES `group_schedule_days_template` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `group_time_range` */

insert  into `group_time_range`(`id`,`time_start`,`group_schedule_days_template_id`) values (2,'12:00',3),(8,'15:00',5);

/*Table structure for table `loyalty_points` */

DROP TABLE IF EXISTS `loyalty_points`;

CREATE TABLE `loyalty_points` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `merchant_id` int(11) NOT NULL,
  `count_on_order` int(11) NOT NULL DEFAULT '0',
  `count_on_like` int(11) NOT NULL DEFAULT '0',
  `is_active` int(11) NOT NULL DEFAULT '0',
  `count_on_comment` int(11) NOT NULL DEFAULT '0',
  `count_on_rate` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `merchant_id` (`merchant_id`),
  CONSTRAINT `loyalty_points_ibfk_1` FOREIGN KEY (`merchant_id`) REFERENCES `mt_merchant` (`merchant_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `loyalty_points` */

/*Table structure for table `merch_cat_has_addon` */

DROP TABLE IF EXISTS `merch_cat_has_addon`;

CREATE TABLE `merch_cat_has_addon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `m_c_id` int(11) NOT NULL,
  `addon_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`m_c_id`,`addon_id`),
  KEY `fk_m_id_ad_m111` (`m_c_id`),
  KEY `fk_addon_for_cat_3219` (`addon_id`),
  CONSTRAINT `fk_addon_for_cat_3219` FOREIGN KEY (`addon_id`) REFERENCES `addon` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_m_id_ad_m111` FOREIGN KEY (`m_c_id`) REFERENCES `category_has_merchant` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8;

/*Data for the table `merch_cat_has_addon` */

insert  into `merch_cat_has_addon`(`id`,`m_c_id`,`addon_id`) values (65,2,9),(66,2,11),(67,2,12),(70,7,9),(63,14,11),(73,16,9),(74,16,11),(64,19,10),(68,21,11),(69,22,9);

/*Table structure for table `merchant_schedule` */

DROP TABLE IF EXISTS `merchant_schedule`;

CREATE TABLE `merchant_schedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `work_date` date NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `merchant_id` int(11) NOT NULL,
  `reason` varchar(520) NOT NULL DEFAULT '',
  `schedule_days_template_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_staff_schedule_staff1_idx` (`merchant_id`),
  KEY `schedule_days_template_id` (`schedule_days_template_id`),
  CONSTRAINT `merchant_schedule_ibfk_1` FOREIGN KEY (`merchant_id`) REFERENCES `mt_merchant` (`merchant_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `merchant_schedule_ibfk_2` FOREIGN KEY (`schedule_days_template_id`) REFERENCES `schedule_days_template` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `merchant_schedule` */

/*Table structure for table `merchant_schedule_history` */

DROP TABLE IF EXISTS `merchant_schedule_history`;

CREATE TABLE `merchant_schedule_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `merchant_id` int(11) NOT NULL,
  `mon` int(11) DEFAULT NULL,
  `tue` int(11) DEFAULT NULL,
  `wed` int(11) DEFAULT NULL,
  `thu` int(11) DEFAULT NULL,
  `fri` int(11) DEFAULT NULL,
  `sat` int(11) DEFAULT NULL,
  `sun` int(11) DEFAULT NULL,
  `change_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `staff_id` (`merchant_id`),
  KEY `mon` (`mon`),
  KEY `tue` (`tue`),
  KEY `wed` (`wed`),
  KEY `thu` (`thu`),
  KEY `fri` (`fri`),
  KEY `sat` (`sat`),
  KEY `sun` (`sun`),
  CONSTRAINT `merchant_schedule_history_ibfk_1` FOREIGN KEY (`merchant_id`) REFERENCES `mt_merchant` (`merchant_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `merchant_schedule_history_ibfk_2` FOREIGN KEY (`mon`) REFERENCES `schedule_days_template` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `merchant_schedule_history_ibfk_3` FOREIGN KEY (`tue`) REFERENCES `schedule_days_template` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `merchant_schedule_history_ibfk_4` FOREIGN KEY (`wed`) REFERENCES `schedule_days_template` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `merchant_schedule_history_ibfk_5` FOREIGN KEY (`thu`) REFERENCES `schedule_days_template` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `merchant_schedule_history_ibfk_6` FOREIGN KEY (`fri`) REFERENCES `schedule_days_template` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `merchant_schedule_history_ibfk_7` FOREIGN KEY (`sat`) REFERENCES `schedule_days_template` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `merchant_schedule_history_ibfk_8` FOREIGN KEY (`sun`) REFERENCES `schedule_days_template` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

/*Data for the table `merchant_schedule_history` */

insert  into `merchant_schedule_history`(`id`,`merchant_id`,`mon`,`tue`,`wed`,`thu`,`fri`,`sat`,`sun`,`change_date`) values (4,2,NULL,NULL,NULL,NULL,6,7,6,NULL),(5,2,6,6,6,6,6,9,NULL,NULL),(6,2,6,6,6,6,6,9,9,NULL),(7,3,6,6,6,6,6,NULL,NULL,NULL),(8,3,6,6,6,6,6,9,NULL,NULL),(9,2,10,10,10,10,10,7,NULL,NULL);

/*Table structure for table `mt_address_book` */

DROP TABLE IF EXISTS `mt_address_book`;

CREATE TABLE `mt_address_book` (
  `id` int(14) NOT NULL AUTO_INCREMENT,
  `client_id` int(14) NOT NULL,
  `street` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zipcode` varchar(255) NOT NULL,
  `location_name` varchar(255) NOT NULL,
  `country_code` varchar(3) NOT NULL,
  `as_default` int(1) NOT NULL DEFAULT '1',
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `ip_address` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `mt_address_book` */

/*Table structure for table `mt_admin_user` */

DROP TABLE IF EXISTS `mt_admin_user`;

CREATE TABLE `mt_admin_user` (
  `admin_id` int(14) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(100) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `role` varchar(100) NOT NULL DEFAULT '',
  `date_created` datetime NOT NULL,
  `date_modified` datetime DEFAULT NULL,
  `ip_address` varchar(100) NOT NULL DEFAULT '',
  `user_lang` int(2) NOT NULL DEFAULT '0',
  `email_address` varchar(255) NOT NULL,
  `lost_password_code` varchar(255) NOT NULL DEFAULT '',
  `session_token` varchar(255) NOT NULL DEFAULT '',
  `last_login` datetime DEFAULT NULL,
  `user_access` text,
  `is_active` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `mt_admin_user` */

insert  into `mt_admin_user`(`admin_id`,`username`,`password`,`first_name`,`last_name`,`role`,`date_created`,`date_modified`,`ip_address`,`user_lang`,`email_address`,`lost_password_code`,`session_token`,`last_login`,`user_access`,`is_active`) values (1,'restomulti','$2y$13$vWA.nUk5Is3h1hyWsgcJ5uWMt8jIwOecd9VYmbdZHvPvu9UkqHohi','dmytro','strafun','','2015-12-22 16:48:53','2016-05-30 12:15:53','127.0.0.1',0,'strafun.web@gmail.com','','36967090949f528764d624db129b32c21fbca0cb8d6','2016-06-13 11:11:05','[\"autologin\",\"dashboard\",\"merchant\",\"packages\",\"serviceCategory\",\"serviceSubcategory\",\"orderStatus\",\"settings\",\"commisionsettings\",\"merchantcommission\",\"emailsettings\",\"emailtpl\",\"customPage\",\"ratings\",\"contactSettings\",\"socialSettings\",\"yiiT\",\"seo\",\"client\",\"newsletter\",\"review\",\"paypalSettings\",\"paymentProvider\",\"reports\",\"rptMerchantReg\",\"rptMerchantPayment\",\"rptMerchanteSales\",\"rptmerchantsalesummary\",\"adminUser\"]',1);

/*Table structure for table `mt_bank_deposit` */

DROP TABLE IF EXISTS `mt_bank_deposit`;

CREATE TABLE `mt_bank_deposit` (
  `id` int(14) NOT NULL AUTO_INCREMENT,
  `merchant_id` int(14) NOT NULL,
  `branch_code` varchar(100) NOT NULL,
  `date_of_deposit` date NOT NULL,
  `time_of_deposit` varchar(50) NOT NULL,
  `amount` float(14,4) NOT NULL,
  `scanphoto` varchar(255) NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'pending',
  `date_created` date NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  `transaction_type` varchar(255) NOT NULL DEFAULT 'merchant_signup',
  `client_id` int(14) NOT NULL,
  `order_id` int(14) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `mt_bank_deposit` */

/*Table structure for table `mt_barclay_trans` */

DROP TABLE IF EXISTS `mt_barclay_trans`;

CREATE TABLE `mt_barclay_trans` (
  `id` int(14) NOT NULL AUTO_INCREMENT,
  `orderid` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `transaction_type` varchar(255) NOT NULL DEFAULT 'signup',
  `date_created` date NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  `param1` varchar(255) NOT NULL,
  `param2` text NOT NULL,
  `param3` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `mt_barclay_trans` */

/*Table structure for table `mt_bookingtable` */

DROP TABLE IF EXISTS `mt_bookingtable`;

CREATE TABLE `mt_bookingtable` (
  `booking_id` int(14) NOT NULL AUTO_INCREMENT,
  `merchant_id` int(14) NOT NULL,
  `number_guest` int(14) NOT NULL,
  `date_booking` date NOT NULL,
  `booking_time` varchar(50) NOT NULL,
  `booking_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(100) NOT NULL,
  `booking_notes` text NOT NULL,
  `date_created` datetime NOT NULL,
  `ip_address` varchar(100) NOT NULL,
  `date_modified` datetime NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `viewed` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`booking_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `mt_bookingtable` */

/*Table structure for table `mt_category` */

DROP TABLE IF EXISTS `mt_category`;

CREATE TABLE `mt_category` (
  `cat_id` int(14) NOT NULL AUTO_INCREMENT,
  `merchant_id` int(14) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_description` text NOT NULL,
  `photo` varchar(255) NOT NULL,
  `status` varchar(100) NOT NULL,
  `sequence` int(14) NOT NULL,
  `date_created` varchar(50) NOT NULL,
  `date_modified` varchar(50) NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  `spicydish` int(2) NOT NULL DEFAULT '1',
  `spicydish_notes` text NOT NULL,
  `dish` text NOT NULL,
  `category_name_trans` text NOT NULL,
  `category_description_trans` text NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `mt_category` */

insert  into `mt_category`(`cat_id`,`merchant_id`,`category_name`,`category_description`,`photo`,`status`,`sequence`,`date_created`,`date_modified`,`ip_address`,`spicydish`,`spicydish_notes`,`dish`,`category_name_trans`,`category_description_trans`) values (1,1,'sadsfddsgd','dsfsdfsdfdsg dsf ds fsdf sdf ','1450873270-2014-01-26-14.25.32.jpg','publish',0,'2015-12-23T15:21:14+03:00','2015-12-23T15:21:33+03:00','127.0.0.1',1,'','','','');

/*Table structure for table `mt_client` */

DROP TABLE IF EXISTS `mt_client`;

CREATE TABLE `mt_client` (
  `client_id` int(14) NOT NULL AUTO_INCREMENT,
  `social_strategy` varchar(100) NOT NULL DEFAULT '',
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email_address` varchar(200) NOT NULL,
  `password` varchar(100) NOT NULL DEFAULT '',
  `street` varchar(255) NOT NULL DEFAULT '',
  `city` varchar(255) NOT NULL DEFAULT '',
  `state` varchar(255) NOT NULL DEFAULT '',
  `zipcode` varchar(100) NOT NULL DEFAULT '',
  `country_code` varchar(3) NOT NULL DEFAULT '',
  `location_name` text,
  `contact_phone` varchar(20) NOT NULL,
  `lost_password_token` varchar(255) NOT NULL DEFAULT '',
  `date_created` datetime NOT NULL,
  `date_modified` datetime DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `ip_address` varchar(50) NOT NULL DEFAULT '',
  `status` int(1) NOT NULL DEFAULT '0',
  `token` varchar(255) NOT NULL DEFAULT '',
  `mobile_verification_code` int(11) NOT NULL DEFAULT '0',
  `mobile_verification_date` datetime DEFAULT NULL,
  `custom_field1` varchar(255) NOT NULL DEFAULT '',
  `custom_field2` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`client_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `mt_client` */

insert  into `mt_client`(`client_id`,`social_strategy`,`first_name`,`last_name`,`email_address`,`password`,`street`,`city`,`state`,`zipcode`,`country_code`,`location_name`,`contact_phone`,`lost_password_token`,`date_created`,`date_modified`,`last_login`,`ip_address`,`status`,`token`,`mobile_verification_code`,`mobile_verification_date`,`custom_field1`,`custom_field2`) values (1,'web','asda','asd','asd@ff.com','7815696ecbf1c96e6894b779456d330e','','','','','','','+380636989961','','2015-12-23 16:30:21','0000-00-00 00:00:00','2015-12-23 16:30:21','127.0.0.1',0,'',0,'0000-00-00 00:00:00','','');

/*Table structure for table `mt_client_cc` */

DROP TABLE IF EXISTS `mt_client_cc`;

CREATE TABLE `mt_client_cc` (
  `cc_id` int(14) NOT NULL AUTO_INCREMENT,
  `client_id` int(14) NOT NULL,
  `card_name` varchar(255) NOT NULL,
  `credit_card_number` varchar(20) NOT NULL,
  `expiration_month` varchar(5) NOT NULL,
  `expiration_yr` varchar(5) NOT NULL,
  `cvv` varchar(20) NOT NULL,
  `billing_address` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`cc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `mt_client_cc` */

insert  into `mt_client_cc`(`cc_id`,`client_id`,`card_name`,`credit_card_number`,`expiration_month`,`expiration_yr`,`cvv`,`billing_address`,`date_created`,`date_modified`,`ip_address`) values (1,1,'visa','21213213131231231231','01','2015','1231','svobody 5','2015-12-23 16:31:49','0000-00-00 00:00:00','127.0.0.1');

/*Table structure for table `mt_cooking_ref` */

DROP TABLE IF EXISTS `mt_cooking_ref`;

CREATE TABLE `mt_cooking_ref` (
  `cook_id` int(14) NOT NULL AUTO_INCREMENT,
  `merchant_id` int(14) NOT NULL,
  `cooking_name` varchar(255) NOT NULL,
  `sequence` int(14) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'published',
  `ip_address` varchar(50) NOT NULL,
  `cooking_name_trans` text NOT NULL,
  PRIMARY KEY (`cook_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `mt_cooking_ref` */

insert  into `mt_cooking_ref`(`cook_id`,`merchant_id`,`cooking_name`,`sequence`,`date_created`,`date_modified`,`status`,`ip_address`,`cooking_name_trans`) values (1,1,'thytytr',0,'2015-12-23 15:22:40','0000-00-00 00:00:00','publish','127.0.0.1','');

/*Table structure for table `mt_cuisine` */

DROP TABLE IF EXISTS `mt_cuisine`;

CREATE TABLE `mt_cuisine` (
  `cuisine_id` int(14) NOT NULL AUTO_INCREMENT,
  `cuisine_name` varchar(255) NOT NULL,
  `sequence` int(14) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`cuisine_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

/*Data for the table `mt_cuisine` */

insert  into `mt_cuisine`(`cuisine_id`,`cuisine_name`,`sequence`,`date_created`,`date_modified`,`ip_address`) values (1,'American',0,'2015-12-22 16:48:53','0000-00-00 00:00:00','127.0.0.1'),(2,'Deli',0,'2015-12-22 16:48:53','0000-00-00 00:00:00','127.0.0.1'),(3,'Indian',0,'2015-12-22 16:48:53','0000-00-00 00:00:00','127.0.0.1'),(4,'Mediterranean',0,'2015-12-22 16:48:53','0000-00-00 00:00:00','127.0.0.1'),(5,'Sandwiches',0,'2015-12-22 16:48:53','0000-00-00 00:00:00','127.0.0.1'),(6,'Barbeque',0,'2015-12-22 16:48:53','0000-00-00 00:00:00','127.0.0.1'),(7,'Diner',0,'2015-12-22 16:48:53','0000-00-00 00:00:00','127.0.0.1'),(8,'Italian',0,'2015-12-22 16:48:53','0000-00-00 00:00:00','127.0.0.1'),(9,'Mexican',0,'2015-12-22 16:48:53','0000-00-00 00:00:00','127.0.0.1'),(10,'Sushi',0,'2015-12-22 16:48:53','0000-00-00 00:00:00','127.0.0.1'),(11,'Burgers',0,'2015-12-22 16:48:53','0000-00-00 00:00:00','127.0.0.1'),(12,'Greek',0,'2015-12-22 16:48:53','0000-00-00 00:00:00','127.0.0.1'),(13,'Japanese',0,'2015-12-22 16:48:53','0000-00-00 00:00:00','127.0.0.1'),(14,'Middle Eastern',0,'2015-12-22 16:48:53','0000-00-00 00:00:00','127.0.0.1'),(15,'Thai',0,'2015-12-22 16:48:53','0000-00-00 00:00:00','127.0.0.1'),(16,'Chinese',0,'2015-12-22 16:48:53','0000-00-00 00:00:00','127.0.0.1'),(17,'Healthy',0,'2015-12-22 16:48:53','0000-00-00 00:00:00','127.0.0.1'),(18,'Korean',0,'2015-12-22 16:48:53','0000-00-00 00:00:00','127.0.0.1'),(19,'Pizza',0,'2015-12-22 16:48:53','0000-00-00 00:00:00','127.0.0.1'),(20,'Vegetarian',0,'2015-12-22 16:48:53','0000-00-00 00:00:00','127.0.0.1');

/*Table structure for table `mt_currency` */

DROP TABLE IF EXISTS `mt_currency`;

CREATE TABLE `mt_currency` (
  `currency_code` varchar(3) NOT NULL,
  `currency_symbol` varchar(100) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`currency_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `mt_currency` */

insert  into `mt_currency`(`currency_code`,`currency_symbol`,`date_created`,`date_modified`,`ip_address`) values ('AUD','&#36;','2015-12-22 16:48:53','0000-00-00 00:00:00','127.0.0.1'),('CAD','&#36;','2015-12-22 16:48:53','0000-00-00 00:00:00','127.0.0.1'),('CNY','&yen;','2015-12-22 16:48:53','0000-00-00 00:00:00','127.0.0.1'),('EUR','&euro;','2015-12-22 16:48:53','0000-00-00 00:00:00','127.0.0.1'),('HKD','&#36;','2015-12-22 16:48:53','0000-00-00 00:00:00','127.0.0.1'),('JPY','&yen;','2015-12-22 16:48:53','0000-00-00 00:00:00','127.0.0.1'),('MXN','&#36;','2015-12-22 16:48:53','0000-00-00 00:00:00','127.0.0.1'),('MYR','&#82;&#77;','2015-12-22 16:48:53','0000-00-00 00:00:00','127.0.0.1'),('NZD','&#36;','2015-12-22 16:48:53','0000-00-00 00:00:00','127.0.0.1'),('USD','&#36;','2015-12-22 16:48:53','0000-00-00 00:00:00','127.0.0.1');

/*Table structure for table `mt_custom_page` */

DROP TABLE IF EXISTS `mt_custom_page`;

CREATE TABLE `mt_custom_page` (
  `id` int(14) NOT NULL AUTO_INCREMENT,
  `slug_name` varchar(255) NOT NULL DEFAULT '',
  `page_name` varchar(255) NOT NULL,
  `content` text,
  `seo_title` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL DEFAULT '',
  `meta_keywords` varchar(255) NOT NULL DEFAULT '',
  `icons` varchar(255) NOT NULL DEFAULT '',
  `assign_to` varchar(50) NOT NULL DEFAULT '',
  `sequence` int(11) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `date_created` datetime NOT NULL,
  `date_modified` datetime DEFAULT NULL,
  `open_new_tab` int(1) NOT NULL DEFAULT '0',
  `is_custom_link` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `mt_custom_page` */

insert  into `mt_custom_page`(`id`,`slug_name`,`page_name`,`content`,`seo_title`,`meta_description`,`meta_keywords`,`icons`,`assign_to`,`sequence`,`status`,`date_created`,`date_modified`,`open_new_tab`,`is_custom_link`) values (1,'sdasd','sdasd','dsfds','','','','sdsd','',0,0,'2016-01-25 10:43:10','2016-01-25 10:43:37',1,1);

/*Table structure for table `mt_dishes` */

DROP TABLE IF EXISTS `mt_dishes`;

CREATE TABLE `mt_dishes` (
  `dish_id` int(14) NOT NULL AUTO_INCREMENT,
  `dish_name` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `status` varchar(100) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `ip_address` varchar(100) NOT NULL,
  PRIMARY KEY (`dish_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `mt_dishes` */

insert  into `mt_dishes`(`dish_id`,`dish_name`,`photo`,`status`,`date_created`,`date_modified`,`ip_address`) values (1,'sdsad','1451989992-2013-05-09-18.50.56.jpg','publish','2016-01-05 13:33:16','0000-00-00 00:00:00','127.0.0.1');

/*Table structure for table `mt_fax_broadcast` */

DROP TABLE IF EXISTS `mt_fax_broadcast`;

CREATE TABLE `mt_fax_broadcast` (
  `id` int(14) NOT NULL AUTO_INCREMENT,
  `merchant_id` int(14) NOT NULL,
  `faxno` varchar(50) NOT NULL,
  `recipname` varchar(32) NOT NULL,
  `faxurl` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `jobid` varchar(255) NOT NULL,
  `api_raw_response` text NOT NULL,
  `date_created` datetime NOT NULL,
  `date_process` datetime NOT NULL,
  `date_postback` datetime NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `mt_fax_broadcast` */

/*Table structure for table `mt_fax_package` */

DROP TABLE IF EXISTS `mt_fax_package`;

CREATE TABLE `mt_fax_package` (
  `fax_package_id` int(14) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` float(14,4) NOT NULL,
  `promo_price` float(14,4) NOT NULL,
  `fax_limit` int(14) NOT NULL,
  `sequence` int(14) NOT NULL,
  `status` varchar(100) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `ip_address` varchar(100) NOT NULL,
  PRIMARY KEY (`fax_package_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `mt_fax_package` */

/*Table structure for table `mt_fax_package_trans` */

DROP TABLE IF EXISTS `mt_fax_package_trans`;

CREATE TABLE `mt_fax_package_trans` (
  `id` int(14) NOT NULL AUTO_INCREMENT,
  `merchant_id` int(14) NOT NULL,
  `fax_package_id` int(14) NOT NULL,
  `payment_type` varchar(50) NOT NULL,
  `package_price` float(14,4) NOT NULL,
  `fax_limit` int(14) NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'pending',
  `payment_reference` varchar(255) NOT NULL,
  `payment_gateway_response` text NOT NULL,
  `date_created` datetime NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `mt_fax_package_trans` */

/*Table structure for table `mt_ingredients` */

DROP TABLE IF EXISTS `mt_ingredients`;

CREATE TABLE `mt_ingredients` (
  `ingredients_id` int(14) NOT NULL AUTO_INCREMENT,
  `merchant_id` int(14) NOT NULL,
  `ingredients_name` varchar(255) NOT NULL,
  `sequence` int(14) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'published',
  `ip_address` varchar(50) NOT NULL,
  `ingredients_name_trans` text NOT NULL,
  PRIMARY KEY (`ingredients_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `mt_ingredients` */

insert  into `mt_ingredients`(`ingredients_id`,`merchant_id`,`ingredients_name`,`sequence`,`date_created`,`date_modified`,`status`,`ip_address`,`ingredients_name_trans`) values (1,1,'joijoi',0,'2015-12-23 15:22:30','0000-00-00 00:00:00','publish','127.0.0.1','');

/*Table structure for table `mt_item` */

DROP TABLE IF EXISTS `mt_item`;

CREATE TABLE `mt_item` (
  `item_id` int(14) NOT NULL AUTO_INCREMENT,
  `merchant_id` int(14) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `item_description` text NOT NULL,
  `status` varchar(50) NOT NULL,
  `category` text NOT NULL,
  `price` text NOT NULL,
  `addon_item` text NOT NULL,
  `cooking_ref` text NOT NULL,
  `discount` varchar(14) NOT NULL,
  `multi_option` text NOT NULL,
  `multi_option_value` text NOT NULL,
  `photo` varchar(255) NOT NULL,
  `sequence` int(14) NOT NULL,
  `is_featured` tinyint(1) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  `ingredients` text NOT NULL,
  `spicydish` int(2) NOT NULL DEFAULT '1',
  `two_flavors` int(2) NOT NULL,
  `two_flavors_position` text NOT NULL,
  `require_addon` text NOT NULL,
  `dish` text NOT NULL,
  `item_name_trans` text NOT NULL,
  `item_description_trans` text NOT NULL,
  `non_taxable` int(1) NOT NULL DEFAULT '1',
  `not_available` int(1) NOT NULL DEFAULT '1',
  `gallery_photo` text NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `mt_item` */

insert  into `mt_item`(`item_id`,`merchant_id`,`item_name`,`item_description`,`status`,`category`,`price`,`addon_item`,`cooking_ref`,`discount`,`multi_option`,`multi_option_value`,`photo`,`sequence`,`is_featured`,`date_created`,`date_modified`,`ip_address`,`ingredients`,`spicydish`,`two_flavors`,`two_flavors_position`,`require_addon`,`dish`,`item_name_trans`,`item_description_trans`,`non_taxable`,`not_available`,`gallery_photo`) values (1,1,'kjlokpokp22','sadsadads','publish','[\"1\"]','{\"1\":\"4444\",\"0\":\"4444\"}','{\"1\":[\"1\"]}','[\"1\"]','2','{\"1\":[\"one\"]}','{\"1\":[\"\"]}','1450873477-2014-02-01-04.00.37.jpg',0,0,'2015-12-23 15:25:22','2015-12-23 15:45:51','127.0.0.1','[\"1\"]',0,0,'{\"1\":[\"left\"]}','{\"1\":[\"2\"]}','','','',2,1,'');

/*Table structure for table `mt_languages` */

DROP TABLE IF EXISTS `mt_languages`;

CREATE TABLE `mt_languages` (
  `lang_id` int(14) NOT NULL AUTO_INCREMENT,
  `country_code` varchar(14) NOT NULL,
  `language_code` varchar(10) NOT NULL,
  `source_text` text NOT NULL,
  `is_assign` int(1) NOT NULL DEFAULT '2',
  `date_created` datetime NOT NULL,
  `last_updated` datetime NOT NULL,
  `status` varchar(50) NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`lang_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `mt_languages` */

/*Table structure for table `mt_merchant` */

DROP TABLE IF EXISTS `mt_merchant`;

CREATE TABLE `mt_merchant` (
  `merchant_id` int(14) NOT NULL AUTO_INCREMENT,
  `service_name` varchar(255) NOT NULL,
  `service_phone` varchar(100) NOT NULL,
  `contact_name` varchar(255) NOT NULL,
  `contact_phone` varchar(100) NOT NULL,
  `contact_email` varchar(255) NOT NULL,
  `country_code` varchar(3) NOT NULL DEFAULT '',
  `street` text NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `post_code` varchar(100) NOT NULL,
  `cuisine` text,
  `service` varchar(255) NOT NULL DEFAULT '',
  `free_delivery` int(1) NOT NULL DEFAULT '0',
  `delivery_estimation` varchar(100) NOT NULL DEFAULT '',
  `username` varchar(100) NOT NULL DEFAULT '',
  `password` varchar(100) NOT NULL DEFAULT '',
  `activation_key` varchar(50) NOT NULL DEFAULT '',
  `activation_token` varchar(100) NOT NULL DEFAULT '',
  `status` int(1) NOT NULL DEFAULT '0',
  `date_created` datetime NOT NULL,
  `date_modified` datetime DEFAULT NULL,
  `date_activated` datetime DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `ip_address` varchar(50) NOT NULL DEFAULT '',
  `package_id` int(14) NOT NULL,
  `package_price` float NOT NULL DEFAULT '0',
  `membership_expired` date DEFAULT NULL,
  `payment_steps` int(1) NOT NULL DEFAULT '0',
  `is_featured` int(1) NOT NULL DEFAULT '0',
  `is_ready` int(1) NOT NULL DEFAULT '0',
  `is_sponsored` int(2) NOT NULL DEFAULT '0',
  `sponsored_expiration` date DEFAULT NULL,
  `lost_password_code` varchar(50) NOT NULL DEFAULT '',
  `user_lang` int(11) NOT NULL DEFAULT '0',
  `membership_purchase_date` date DEFAULT NULL,
  `sort_featured` int(11) NOT NULL DEFAULT '0',
  `is_commission` int(1) NOT NULL DEFAULT '0',
  `percent_commission` float NOT NULL DEFAULT '0',
  `fixed_commission` float(8,2) NOT NULL DEFAULT '0.00',
  `session_token` varchar(255) NOT NULL DEFAULT '',
  `commission_type` smallint(5) NOT NULL DEFAULT '0',
  `seo_title` varchar(255) NOT NULL DEFAULT '',
  `seo_description` varchar(255) NOT NULL DEFAULT '',
  `seo_keywords` varchar(255) NOT NULL DEFAULT '',
  `url` varchar(255) NOT NULL,
  `manager_username` varchar(100) NOT NULL DEFAULT '',
  `manager_password` varchar(100) NOT NULL DEFAULT '',
  `manager_extended` tinyint(1) NOT NULL DEFAULT '0',
  `fb` varchar(255) NOT NULL DEFAULT '',
  `tw` varchar(255) NOT NULL DEFAULT '',
  `gl` varchar(255) NOT NULL DEFAULT '',
  `yt` varchar(255) NOT NULL DEFAULT '',
  `it` varchar(255) NOT NULL DEFAULT '',
  `paypall_id` varchar(255) NOT NULL DEFAULT '',
  `paypall_pass` varchar(255) NOT NULL DEFAULT '',
  `gmap_altitude` varchar(10) NOT NULL DEFAULT '',
  `gmap_latitude` varchar(10) NOT NULL DEFAULT '',
  `gallery_id` int(11) DEFAULT NULL,
  `address` varchar(510) NOT NULL DEFAULT '',
  `vk` varchar(255) NOT NULL DEFAULT '',
  `pr` varchar(255) NOT NULL DEFAULT '',
  `is_purchase` int(1) NOT NULL DEFAULT '0',
  `description` text,
  PRIMARY KEY (`merchant_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `mt_merchant` */

insert  into `mt_merchant`(`merchant_id`,`service_name`,`service_phone`,`contact_name`,`contact_phone`,`contact_email`,`country_code`,`street`,`city`,`state`,`post_code`,`cuisine`,`service`,`free_delivery`,`delivery_estimation`,`username`,`password`,`activation_key`,`activation_token`,`status`,`date_created`,`date_modified`,`date_activated`,`last_login`,`ip_address`,`package_id`,`package_price`,`membership_expired`,`payment_steps`,`is_featured`,`is_ready`,`is_sponsored`,`sponsored_expiration`,`lost_password_code`,`user_lang`,`membership_purchase_date`,`sort_featured`,`is_commission`,`percent_commission`,`fixed_commission`,`session_token`,`commission_type`,`seo_title`,`seo_description`,`seo_keywords`,`url`,`manager_username`,`manager_password`,`manager_extended`,`fb`,`tw`,`gl`,`yt`,`it`,`paypall_id`,`paypall_pass`,`gmap_altitude`,`gmap_latitude`,`gallery_id`,`address`,`vk`,`pr`,`is_purchase`,`description`) values (2,'Auszeit Kosmetikinstitut','0711213456','Iris','0711223344','Ik@test.com','De','Hauptstrasse 60','Leinfelden-Echterdingen','Baden-Württemberg','70771',NULL,'',0,'','test@test.com','$2y$13$/j2ksi6ueXIsXA744tijx.k7nrLbwttpx7N4v.q6dYmt6jwGxfaMS','','',1,'2016-01-27 13:08:07','2016-05-10 20:54:49',NULL,'2016-06-14 13:28:08','127.0.0.1',3,0,NULL,0,1,0,1,NULL,'',0,NULL,0,1,0,0.00,'61472743436f528764d624db129b32c21fbca0cb8d6',1,'','','','qwe','tester@test.com','$2y$13$o7.pLF1yXeV4j1fKveB.DubUJKeW.fledWQmcon1NyOxzIcg0UNs.',0,'','','','','','','','-3.7037901','40.4167754',1,'hauptstr. 46 70771leinfelden-echterdingen','','',0,NULL),(3,'Your Beauty','1223344567','Melanie','122334455','test@test1.com','de','Bonländer Hauptstr. 76','Fildersatdt','Baden-Württemberg','70794',NULL,'',0,'','test@test1.com','$2y$13$osMkqASD2nxd.Gf5ZfaswuFbhMDnV9KjxjKLhWFCK6R8HFCfE/uvW','','',1,'2016-04-15 13:23:07','2016-04-15 17:28:42',NULL,'2016-05-13 16:13:04','115.178.255.160',2,0,NULL,0,0,0,0,NULL,'',0,NULL,0,0,0,0.00,'',0,'','','','your-beauty','','',0,'','','','','','','','13.4049539','52.5200065',2,'bonländer hauptstr. 76 70794 Filderstadt','','',0,NULL);

/*Table structure for table `mt_merchant_cc` */

DROP TABLE IF EXISTS `mt_merchant_cc`;

CREATE TABLE `mt_merchant_cc` (
  `mt_id` int(14) NOT NULL AUTO_INCREMENT,
  `merchant_id` int(14) NOT NULL,
  `card_name` varchar(255) NOT NULL,
  `credit_card_number` varchar(20) NOT NULL,
  `expiration_month` varchar(5) NOT NULL,
  `expiration_yr` varchar(5) NOT NULL,
  `cvv` varchar(20) NOT NULL,
  `billing_address` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`mt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `mt_merchant_cc` */

/*Table structure for table `mt_merchant_user` */

DROP TABLE IF EXISTS `mt_merchant_user`;

CREATE TABLE `mt_merchant_user` (
  `merchant_user_id` int(14) NOT NULL AUTO_INCREMENT,
  `merchant_id` int(14) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_access` text NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'active',
  `last_login` datetime NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  `contact_email` varchar(255) NOT NULL,
  `session_token` varchar(255) NOT NULL,
  PRIMARY KEY (`merchant_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `mt_merchant_user` */

/*Table structure for table `mt_newsletter` */

DROP TABLE IF EXISTS `mt_newsletter`;

CREATE TABLE `mt_newsletter` (
  `id` int(14) NOT NULL AUTO_INCREMENT,
  `email_address` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `mt_newsletter` */

/*Table structure for table `mt_offers` */

DROP TABLE IF EXISTS `mt_offers`;

CREATE TABLE `mt_offers` (
  `offers_id` int(14) NOT NULL AUTO_INCREMENT,
  `merchant_id` int(14) NOT NULL,
  `offer_percentage` float(14,4) NOT NULL,
  `offer_price` float(14,4) NOT NULL,
  `valid_from` date NOT NULL,
  `valid_to` date NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`offers_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `mt_offers` */

/*Table structure for table `mt_option` */

DROP TABLE IF EXISTS `mt_option`;

CREATE TABLE `mt_option` (
  `id` int(14) NOT NULL AUTO_INCREMENT,
  `merchant_id` int(11) NOT NULL DEFAULT '0',
  `option_name` varchar(255) NOT NULL,
  `option_value` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `merchant_id` (`merchant_id`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8;

/*Data for the table `mt_option` */

insert  into `mt_option`(`id`,`merchant_id`,`option_name`,`option_value`) values (1,0,'website_title','restomulti1'),(2,0,'admin_country_set','UA'),(3,0,'website_address','restomulti'),(4,0,'website_contact_phone','34234324'),(5,0,'website_contact_email','strafun.web@gmail.com'),(6,0,'admin_currency_set','EUR'),(7,1,'merchant_switch_master_cod',''),(8,1,'merchant_switch_master_ccr',''),(9,1,'merchant_switch_master_pyr',''),(10,0,'admin_enabled_paypal','0'),(11,0,'admin_paypal_mode','sandbox'),(12,0,'admin_sanbox_paypal_user','dsfdsf'),(13,0,'admin_sanbox_paypal_pass','fdfsdf'),(14,0,'admin_sanbox_paypal_signature','dsfsdfsdf'),(15,0,'admin_live_paypal_user','dfdsfds'),(16,0,'admin_live_paypal_pass','sdfsfd'),(17,0,'admin_live_paypal_signature','sdfgfgre'),(18,0,'admin_paypal_fee','234324234324'),(19,1,'enabled_paypal','yes'),(20,1,'paypal_mode','sandbox'),(21,1,'sanbox_paypal_user','324324`'),(22,1,'sanbox_paypal_pass','ewrwer'),(23,1,'sanbox_paypal_signature','erewr'),(24,1,'live_paypal_user','erwr'),(25,1,'live_paypal_pass','erer'),(26,1,'live_paypal_signature','ef'),(27,1,'merchant_paypal_fee','24324324'),(28,0,'customer_ask_address','1'),(29,0,'merchant_changeorder_sms','1'),(30,0,'blocked_email_add','zxcxz'),(31,0,'blocked_mobile',''),(32,0,'website_reviews_actual_purchase','0'),(33,0,'merchant_can_edit_reviews','0'),(34,0,'website_disabled_guest_checkout','0'),(35,0,'admin_activated_menu',''),(36,0,'disabled_cart_sticky','0'),(37,0,'website_enabled_map_address','0'),(38,0,'disabled_cc_management','0'),(39,0,'disabled_featured_merchant','0'),(40,0,'disabled_subscription','0'),(41,0,'merchant_disabled_registration','0'),(42,0,'merchant_reg_abn','0'),(43,0,'merchant_sigup_status','pending'),(44,0,'merchant_email_verification','0'),(45,0,'merchant_payment_enabled','0'),(46,0,'admin_enabled_card','0'),(47,0,'global_admin_sender_email',''),(48,0,'admin_thousand_separator',''),(49,0,'admin_decimal_separator',''),(50,0,'website_loyalty_points','10'),(51,0,'admin_exclude_cod_balance','0'),(52,0,'admin_commission_enabled','0'),(53,0,'admin_disabled_membership','0'),(54,0,'admin_include_merchant_cod','0'),(55,0,'admin_commission_type','percentage'),(56,0,'admin_commission_percent','10'),(57,0,'admin_commission_fixed_val',''),(58,0,'admin_vat_no',''),(59,0,'admin_vat_percent','');

/*Table structure for table `mt_order` */

DROP TABLE IF EXISTS `mt_order`;

CREATE TABLE `mt_order` (
  `order_id` int(14) NOT NULL AUTO_INCREMENT,
  `merchant_id` int(14) NOT NULL,
  `client_id` int(14) NOT NULL,
  `json_details` text NOT NULL,
  `trans_type` varchar(100) NOT NULL,
  `payment_type` varchar(100) NOT NULL,
  `sub_total` float(14,4) NOT NULL,
  `tax` float(14,4) NOT NULL,
  `taxable_total` decimal(14,4) NOT NULL,
  `total_w_tax` float(14,4) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `stats_id` int(14) NOT NULL,
  `viewed` int(1) NOT NULL DEFAULT '1',
  `delivery_charge` float(14,4) NOT NULL,
  `delivery_date` date NOT NULL,
  `delivery_time` varchar(100) NOT NULL,
  `delivery_asap` varchar(14) NOT NULL,
  `delivery_instruction` varchar(255) NOT NULL,
  `voucher_code` varchar(100) NOT NULL,
  `voucher_amount` float(14,4) NOT NULL,
  `voucher_type` varchar(100) NOT NULL,
  `cc_id` int(14) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  `order_change` float(14,4) NOT NULL,
  `payment_provider_name` varchar(255) NOT NULL,
  `discounted_amount` float(14,5) NOT NULL,
  `discount_percentage` float(14,5) NOT NULL,
  `percent_commision` float(14,4) NOT NULL,
  `total_commission` float(14,4) NOT NULL,
  `commision_ontop` int(2) NOT NULL DEFAULT '2',
  `merchant_earnings` float(14,4) NOT NULL,
  `packaging` float(14,4) NOT NULL,
  `cart_tip_percentage` float(14,4) NOT NULL,
  `cart_tip_value` float(14,4) NOT NULL,
  `card_fee` float(14,4) NOT NULL,
  `donot_apply_tax_delivery` int(1) NOT NULL DEFAULT '1',
  `order_locked` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`order_id`),
  KEY `merchant_id` (`merchant_id`),
  KEY `client_id` (`client_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `mt_order` */

insert  into `mt_order`(`order_id`,`merchant_id`,`client_id`,`json_details`,`trans_type`,`payment_type`,`sub_total`,`tax`,`taxable_total`,`total_w_tax`,`status`,`stats_id`,`viewed`,`delivery_charge`,`delivery_date`,`delivery_time`,`delivery_asap`,`delivery_instruction`,`voucher_code`,`voucher_amount`,`voucher_type`,`cc_id`,`date_created`,`date_modified`,`ip_address`,`order_change`,`payment_provider_name`,`discounted_amount`,`discount_percentage`,`percent_commision`,`total_commission`,`commision_ontop`,`merchant_earnings`,`packaging`,`cart_tip_percentage`,`cart_tip_value`,`card_fee`,`donot_apply_tax_delivery`,`order_locked`) values (1,1,1,'[{\"item_id\":\"1\",\"row\":\"\",\"merchant_id\":\"1\",\"discount\":\"2\",\"currentController\":\"store\",\"price\":\"4444\",\"qty\":\"1\",\"notes\":\"\",\"require_addon_1\":\"2\",\"sub_item\":{\"1\":[\"1|22|sdsfdsf|left\"]},\"non_taxable\":\"2\",\"addon_ids\":[\"1\"]}]','pickup','pyp',4464.0000,0.0000,'0.0000',24328788.0000,'initial_order',0,1,0.0000,'2015-12-30','21:35','','','',0.0000,'',0,'2015-12-23 16:34:42','0000-00-00 00:00:00','127.0.0.1',0.0000,'',0.00000,0.00000,0.0000,0.0000,2,0.0000,0.0000,0.0000,0.0000,24324324.0000,1,1),(2,1,1,'[{\"item_id\":\"1\",\"row\":\"\",\"merchant_id\":\"1\",\"discount\":\"2\",\"currentController\":\"store\",\"price\":\"4444\",\"qty\":\"1\",\"notes\":\"\",\"require_addon_1\":\"2\",\"sub_item\":{\"1\":[\"1|22|sdsfdsf|left\"]},\"non_taxable\":\"2\",\"addon_ids\":[\"1\"]}]','delivery','pyp',4464.0000,0.0000,'0.0000',24328788.0000,'initial_order',0,1,0.0000,'2015-12-23','','','','',0.0000,'',0,'2015-12-23 18:33:45','0000-00-00 00:00:00','127.0.0.1',0.0000,'',0.00000,0.00000,0.0000,0.0000,2,0.0000,0.0000,0.0000,0.0000,24324324.0000,1,1);

/*Table structure for table `mt_order_delivery_address` */

DROP TABLE IF EXISTS `mt_order_delivery_address`;

CREATE TABLE `mt_order_delivery_address` (
  `id` int(14) NOT NULL AUTO_INCREMENT,
  `order_id` int(14) NOT NULL,
  `client_id` int(14) NOT NULL,
  `street` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zipcode` varchar(255) NOT NULL,
  `location_name` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  `contact_phone` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `client_id` (`client_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `mt_order_delivery_address` */

insert  into `mt_order_delivery_address`(`id`,`order_id`,`client_id`,`street`,`city`,`state`,`zipcode`,`location_name`,`country`,`date_created`,`ip_address`,`contact_phone`) values (1,2,1,'Svobody Avenue',' Kiev',' Kyiv city','','','Ukraine','2015-12-23 18:33:45','127.0.0.1','+380636989961');

/*Table structure for table `mt_order_details` */

DROP TABLE IF EXISTS `mt_order_details`;

CREATE TABLE `mt_order_details` (
  `id` int(14) NOT NULL AUTO_INCREMENT,
  `order_id` int(14) NOT NULL,
  `client_id` int(14) NOT NULL,
  `item_id` int(14) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `order_notes` text NOT NULL,
  `normal_price` float(14,4) NOT NULL,
  `discounted_price` float(14,4) NOT NULL,
  `size` varchar(255) NOT NULL,
  `qty` int(14) NOT NULL,
  `cooking_ref` varchar(255) NOT NULL,
  `addon` text NOT NULL,
  `ingredients` text NOT NULL,
  `non_taxable` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `mt_order_details` */

insert  into `mt_order_details`(`id`,`order_id`,`client_id`,`item_id`,`item_name`,`order_notes`,`normal_price`,`discounted_price`,`size`,`qty`,`cooking_ref`,`addon`,`ingredients`,`non_taxable`) values (1,1,1,1,'kjlokpokp22','',4444.0000,4442.0000,'',1,'','[{\"addon_name\":\"sdsfdsf\",\"addon_category\":\"fdsfsdf1112\",\"addon_qty\":\"1\",\"addon_price\":\"22\"}]','\"\"',2),(2,2,1,1,'kjlokpokp22','',4444.0000,4442.0000,'',1,'','[{\"addon_name\":\"sdsfdsf\",\"addon_category\":\"fdsfsdf1112\",\"addon_qty\":\"1\",\"addon_price\":\"22\"}]','\"\"',2);

/*Table structure for table `mt_order_history` */

DROP TABLE IF EXISTS `mt_order_history`;

CREATE TABLE `mt_order_history` (
  `id` int(14) NOT NULL AUTO_INCREMENT,
  `order_id` int(14) NOT NULL,
  `status` varchar(255) NOT NULL,
  `remarks` text NOT NULL,
  `date_created` datetime NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `mt_order_history` */

/*Table structure for table `mt_order_sms` */

DROP TABLE IF EXISTS `mt_order_sms`;

CREATE TABLE `mt_order_sms` (
  `id` int(14) NOT NULL AUTO_INCREMENT,
  `mobile` varchar(50) NOT NULL,
  `code` int(4) NOT NULL,
  `session` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `session` (`session`),
  KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `mt_order_sms` */

/*Table structure for table `mt_order_status` */

DROP TABLE IF EXISTS `mt_order_status`;

CREATE TABLE `mt_order_status` (
  `stats_id` int(14) NOT NULL AUTO_INCREMENT,
  `description` varchar(200) NOT NULL,
  `date_created` date NOT NULL,
  `date_modified` datetime DEFAULT NULL,
  PRIMARY KEY (`stats_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `mt_order_status` */

insert  into `mt_order_status`(`stats_id`,`description`,`date_created`,`date_modified`) values (1,'pending1','2015-12-22','2016-01-24 23:03:09'),(2,'cancelled','2015-12-22','0000-00-00 00:00:00'),(4,'paid','2015-12-22','0000-00-00 00:00:00');

/*Table structure for table `mt_package_trans` */

DROP TABLE IF EXISTS `mt_package_trans`;

CREATE TABLE `mt_package_trans` (
  `id` int(14) NOT NULL AUTO_INCREMENT,
  `package_id` int(14) NOT NULL,
  `merchant_id` int(14) NOT NULL,
  `price` float(14,4) NOT NULL,
  `payment_type` varchar(100) NOT NULL,
  `mt_id` int(14) NOT NULL,
  `TOKEN` varchar(255) NOT NULL,
  `membership_expired` date NOT NULL,
  `TRANSACTIONID` varchar(255) NOT NULL,
  `TRANSACTIONTYPE` varchar(100) NOT NULL,
  `PAYMENTSTATUS` varchar(100) NOT NULL,
  `PAYPALFULLRESPONSE` text NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'pending',
  `date_created` datetime NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  `fee` float(14,4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `mt_package_trans` */

/*Table structure for table `mt_packages` */

DROP TABLE IF EXISTS `mt_packages`;

CREATE TABLE `mt_packages` (
  `package_id` int(14) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text,
  `price` float(8,2) NOT NULL,
  `promo_price` float(8,2) NOT NULL DEFAULT '0.00',
  `expiration` int(11) NOT NULL DEFAULT '0',
  `expiration_type` int(2) NOT NULL DEFAULT '0',
  `unlimited_post` int(1) NOT NULL DEFAULT '0',
  `post_limit` int(11) NOT NULL DEFAULT '0',
  `sequence` int(11) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `date_created` datetime NOT NULL,
  `date_modified` datetime DEFAULT NULL,
  `sell_limit` int(11) NOT NULL DEFAULT '0',
  `workers_limit` int(11) NOT NULL DEFAULT '0',
  `is_commission` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0',
  `commission_type` tinyint(3) NOT NULL DEFAULT '0',
  `percent_commission` float(8,2) NOT NULL DEFAULT '0.00',
  `fixed_commission` float(8,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`package_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `mt_packages` */

insert  into `mt_packages`(`package_id`,`title`,`description`,`price`,`promo_price`,`expiration`,`expiration_type`,`unlimited_post`,`post_limit`,`sequence`,`status`,`date_created`,`date_modified`,`sell_limit`,`workers_limit`,`is_commission`,`commission_type`,`percent_commission`,`fixed_commission`) values (2,'Starter Paket',NULL,19.00,0.00,0,0,1,0,1,1,'2016-04-15 13:28:30','2016-04-15 13:29:18',0,1,1,1,0.00,0.00),(3,'Business Paket',NULL,39.00,0.00,0,0,1,0,2,1,'2016-04-15 13:30:58',NULL,0,5,1,1,0.00,0.00),(4,'Premium Paket',NULL,59.00,0.00,0,0,1,0,3,1,'2016-04-15 13:31:47',NULL,0,10,1,1,0.00,0.00),(5,'Platinium Paket',NULL,79.00,0.00,0,0,1,0,4,1,'2016-04-15 13:33:06',NULL,0,20,1,1,0.00,0.00);

/*Table structure for table `mt_payment_order` */

DROP TABLE IF EXISTS `mt_payment_order`;

CREATE TABLE `mt_payment_order` (
  `id` int(14) NOT NULL AUTO_INCREMENT,
  `payment_type` varchar(10) CHARACTER SET utf8 NOT NULL,
  `payment_reference` varchar(255) CHARACTER SET utf8 NOT NULL,
  `order_id` int(14) NOT NULL,
  `raw_response` text CHARACTER SET utf8 NOT NULL,
  `date_created` datetime NOT NULL,
  `ip_address` varchar(100) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `mt_payment_order` */

/*Table structure for table `mt_payment_provider` */

DROP TABLE IF EXISTS `mt_payment_provider`;

CREATE TABLE `mt_payment_provider` (
  `id` int(14) NOT NULL AUTO_INCREMENT,
  `payment_name` varchar(255) NOT NULL,
  `payment_logo` varchar(255) NOT NULL DEFAULT '',
  `sequence` int(11) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `date_created` datetime NOT NULL,
  `date_modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `mt_payment_provider` */

insert  into `mt_payment_provider`(`id`,`payment_name`,`payment_logo`,`sequence`,`status`,`date_created`,`date_modified`) values (1,'test','',0,0,'2016-01-25 16:30:34',NULL),(2,'Pay cash in salon','',0,0,'2016-02-29 22:43:01',NULL);

/*Table structure for table `mt_paypal_checkout` */

DROP TABLE IF EXISTS `mt_paypal_checkout`;

CREATE TABLE `mt_paypal_checkout` (
  `id` int(14) NOT NULL AUTO_INCREMENT,
  `order_id` int(14) NOT NULL,
  `token` varchar(255) NOT NULL,
  `paypal_request` text NOT NULL,
  `paypal_response` text NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'checkout',
  `date_created` datetime NOT NULL,
  `ip_address` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `mt_paypal_checkout` */

/*Table structure for table `mt_paypal_payment` */

DROP TABLE IF EXISTS `mt_paypal_payment`;

CREATE TABLE `mt_paypal_payment` (
  `id` int(14) NOT NULL AUTO_INCREMENT,
  `order_id` int(14) NOT NULL,
  `TOKEN` varchar(255) NOT NULL,
  `TRANSACTIONID` varchar(100) NOT NULL,
  `TRANSACTIONTYPE` varchar(100) NOT NULL,
  `PAYMENTTYPE` varchar(100) NOT NULL,
  `ORDERTIME` varchar(100) NOT NULL,
  `AMT` varchar(14) NOT NULL,
  `FEEAMT` varchar(14) NOT NULL,
  `TAXAMT` varchar(14) NOT NULL,
  `CURRENCYCODE` varchar(3) NOT NULL,
  `PAYMENTSTATUS` varchar(100) NOT NULL,
  `CORRELATIONID` varchar(100) NOT NULL,
  `TIMESTAMP` varchar(100) NOT NULL,
  `json_details` text NOT NULL,
  `date_created` varchar(50) NOT NULL,
  `ip_address` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `mt_paypal_payment` */

/*Table structure for table `mt_rating` */

DROP TABLE IF EXISTS `mt_rating`;

CREATE TABLE `mt_rating` (
  `id` int(14) NOT NULL AUTO_INCREMENT,
  `merchant_id` int(14) NOT NULL,
  `ratings` float(14,1) NOT NULL,
  `client_id` int(14) NOT NULL,
  `date_created` datetime NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `mt_rating` */

/*Table structure for table `mt_rating_meaning` */

DROP TABLE IF EXISTS `mt_rating_meaning`;

CREATE TABLE `mt_rating_meaning` (
  `id` int(14) NOT NULL AUTO_INCREMENT,
  `rating_start` float(14,1) NOT NULL,
  `rating_end` float(14,1) NOT NULL,
  `meaning` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `mt_rating_meaning` */

insert  into `mt_rating_meaning`(`id`,`rating_start`,`rating_end`,`meaning`,`date_created`,`date_modified`,`ip_address`) values (1,1.0,1.9,'poor','2015-12-22 16:48:53','0000-00-00 00:00:00','127.0.0.1'),(2,2.0,2.9,'good','2015-12-22 16:48:53','0000-00-00 00:00:00','127.0.0.1'),(3,3.0,4.0,'very good','2015-12-22 16:48:53','0000-00-00 00:00:00','127.0.0.1'),(4,4.1,5.0,'excellent','2015-12-22 16:48:53','0000-00-00 00:00:00','127.0.0.1');

/*Table structure for table `mt_review` */

DROP TABLE IF EXISTS `mt_review`;

CREATE TABLE `mt_review` (
  `id` int(14) NOT NULL AUTO_INCREMENT,
  `merchant_id` int(14) NOT NULL,
  `client_id` int(14) NOT NULL,
  `review` text NOT NULL,
  `rating` float(14,1) NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'publish',
  `date_created` datetime NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  `order_id` varchar(14) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `mt_review` */

/*Table structure for table `mt_service_category` */

DROP TABLE IF EXISTS `mt_service_category`;

CREATE TABLE `mt_service_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text,
  `is_active` int(1) NOT NULL DEFAULT '1',
  `is_approved` int(2) NOT NULL DEFAULT '0',
  `approved_text` varchar(500) NOT NULL DEFAULT '',
  `date_created` datetime NOT NULL,
  `date_updated` datetime DEFAULT NULL,
  `merchant_id` int(11) NOT NULL DEFAULT '0',
  `seo_title` varchar(255) NOT NULL DEFAULT '',
  `url` varchar(255) NOT NULL,
  `seo_description` varchar(255) NOT NULL DEFAULT '',
  `seo_keywords` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

/*Data for the table `mt_service_category` */

insert  into `mt_service_category`(`id`,`title`,`description`,`is_active`,`is_approved`,`approved_text`,`date_created`,`date_updated`,`merchant_id`,`seo_title`,`url`,`seo_description`,`seo_keywords`) values (1,'Fitness','',1,0,'','2016-01-27 02:15:06','2016-04-15 13:16:34',0,'','fitness','',''),(2,'Friseur','<p>This is a test</p>',1,0,'','2016-02-29 19:10:00','2016-04-17 17:36:21',0,'','friseur','',''),(3,'Massage','',1,0,'','2016-04-15 12:08:29',NULL,0,'','massage','',''),(4,'Kosmetik','',1,0,'','2016-04-15 13:11:46','2016-04-15 13:35:49',0,'','kosmetikinstitut','',''),(5,'Wellness','',1,0,'','2016-04-15 13:36:06',NULL,0,'','wellness','',''),(6,'Nagelstudio','',1,0,'','2016-04-15 13:36:25','2016-04-17 16:45:18',0,'','nagelstudio','',''),(7,'Ernährung','',1,0,'','2016-04-17 16:45:41',NULL,0,'','ernaehrung','',''),(8,'Haarentfernung','',1,0,'','2016-04-17 17:35:11',NULL,0,'','haarentfernung','',''),(9,'Maniküre','',1,0,'','2016-04-17 17:38:28',NULL,0,'','manikuere','',''),(10,'Pediküre','',1,0,'','2016-04-17 17:38:58',NULL,0,'','pedikuere','',''),(11,'Shopping','',1,0,'','2016-05-07 09:51:28',NULL,0,'','shopping','',''),(12,'Tattoo','',1,0,'','2016-05-07 09:52:47',NULL,0,'','tattoo','',''),(13,'Piercing','',1,0,'','2016-05-07 09:53:04',NULL,0,'','piercing','',''),(14,'Lifestyle','',1,0,'','2016-05-07 10:11:56',NULL,0,'','lifestyle','',''),(15,'Kurse & Seminare','',1,0,'','2016-05-07 10:12:11','2016-05-07 10:45:36',0,'','kurse-seminare','',''),(16,'Gesundheit','',1,0,'','2016-05-07 10:42:34',NULL,0,'','gesundheit','',''),(17,'Eventplanung','',1,0,'','2016-05-07 17:48:05','2016-05-07 17:48:31',0,'','eventplanung','','');

/*Table structure for table `mt_service_subcategory` */

DROP TABLE IF EXISTS `mt_service_subcategory`;

CREATE TABLE `mt_service_subcategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text,
  `is_active` int(1) NOT NULL DEFAULT '1',
  `is_approved` int(2) NOT NULL DEFAULT '0',
  `approved_text` varchar(500) NOT NULL DEFAULT '',
  `date_created` datetime NOT NULL,
  `date_updated` datetime DEFAULT NULL,
  `merchant_id` int(11) NOT NULL DEFAULT '0',
  `url` varchar(255) NOT NULL,
  `seo_title` varchar(255) NOT NULL DEFAULT '',
  `seo_description` varchar(255) NOT NULL DEFAULT '',
  `seo_keywords` varchar(255) NOT NULL DEFAULT '',
  `is_group` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `Subcat_fk_id` (`category_id`),
  CONSTRAINT `Subcat_fk_id` FOREIGN KEY (`category_id`) REFERENCES `mt_service_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

/*Data for the table `mt_service_subcategory` */

insert  into `mt_service_subcategory`(`id`,`category_id`,`title`,`description`,`is_active`,`is_approved`,`approved_text`,`date_created`,`date_updated`,`merchant_id`,`url`,`seo_title`,`seo_description`,`seo_keywords`,`is_group`) values (2,3,'klassische Massage','<p>sadsad</p>',1,0,'','2016-02-15 12:28:58','2016-04-15 13:18:10',0,'klassische-massage','','','',0),(3,2,'Frauen Haarschnitt','',1,0,'','2016-04-15 12:09:25','2016-04-17 17:32:48',0,'frauen-haarschnitt','','','',0),(4,4,'Gesichtshandlung','',1,0,'','2016-04-15 13:14:06',NULL,0,'gesichtsbehandlung','','','',0),(5,8,'Haarentfernung Laser','',1,0,'','2016-04-15 13:15:16','2016-04-17 17:37:24',0,'haarentfernung-laser','','','',0),(6,1,'Yoga','',1,0,'','2016-04-15 14:19:57',NULL,0,'yoga','','','',0),(7,3,'Ayurveda Massage','',1,0,'','2016-04-17 17:28:47',NULL,0,'ayurveda-massage','','','',0),(8,3,'Hot Stone Massage','',1,0,'','2016-04-17 17:29:41',NULL,0,'hot-stone-massage','','','',0),(9,3,'Lomi Lomi Massage','',1,0,'','2016-04-17 17:30:42',NULL,0,'lomi-lomi-massage','','','',0),(10,2,'Männer Haarschnitt','',1,0,'','2016-04-17 17:31:49',NULL,0,'maenner-haarschnitt','','','',0),(11,2,'Kinder Haarschnitt','',1,0,'','2016-04-17 17:33:51',NULL,0,'kinder-haarschnitt','','','',0),(12,4,'Make-up','',1,0,'','2016-04-28 14:36:29',NULL,0,'make-up','','','',0),(13,8,'Waxing','',1,0,'','2016-05-07 09:54:50',NULL,0,'waxing','','','',0),(14,7,'Ernährungsberatung','',1,0,'','2016-05-07 10:43:38',NULL,0,'ernährungsberatung','','','',0),(15,4,'Körperbehandlungen','',1,0,'','2016-05-12 11:53:46',NULL,0,'koerperbehandlungen','','','',0),(16,8,'Haarentfernung Waxing','',1,0,'','2016-05-14 10:22:02',NULL,0,'waxing','','','',0);

/*Table structure for table `mt_shipping_rate` */

DROP TABLE IF EXISTS `mt_shipping_rate`;

CREATE TABLE `mt_shipping_rate` (
  `id` int(14) NOT NULL AUTO_INCREMENT,
  `merchant_id` int(14) NOT NULL,
  `distance_from` int(14) NOT NULL,
  `distance_to` int(14) NOT NULL,
  `shipping_units` varchar(5) NOT NULL,
  `distance_price` float(8,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `mt_shipping_rate` */

/*Table structure for table `mt_size` */

DROP TABLE IF EXISTS `mt_size`;

CREATE TABLE `mt_size` (
  `size_id` int(14) NOT NULL AUTO_INCREMENT,
  `merchant_id` int(14) NOT NULL,
  `size_name` varchar(255) NOT NULL,
  `sequence` int(14) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'published',
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  `size_name_trans` text NOT NULL,
  PRIMARY KEY (`size_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `mt_size` */

insert  into `mt_size`(`size_id`,`merchant_id`,`size_name`,`sequence`,`status`,`date_created`,`date_modified`,`ip_address`,`size_name_trans`) values (1,1,'ps',0,'publish','2015-12-23 15:21:45','0000-00-00 00:00:00','127.0.0.1','');

/*Table structure for table `mt_sms_broadcast` */

DROP TABLE IF EXISTS `mt_sms_broadcast`;

CREATE TABLE `mt_sms_broadcast` (
  `broadcast_id` int(14) NOT NULL AUTO_INCREMENT,
  `merchant_id` int(14) NOT NULL,
  `send_to` int(14) NOT NULL,
  `list_mobile_number` text CHARACTER SET utf8 NOT NULL,
  `sms_alert_message` varchar(255) CHARACTER SET utf8 NOT NULL,
  `status` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT 'pending',
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `ip_address` varchar(50) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`broadcast_id`)
) ENGINE=InnoDB DEFAULT CHARSET=ucs2;

/*Data for the table `mt_sms_broadcast` */

/*Table structure for table `mt_sms_broadcast_details` */

DROP TABLE IF EXISTS `mt_sms_broadcast_details`;

CREATE TABLE `mt_sms_broadcast_details` (
  `id` int(14) NOT NULL AUTO_INCREMENT,
  `merchant_id` int(14) NOT NULL,
  `broadcast_id` int(14) NOT NULL,
  `client_id` int(14) NOT NULL,
  `client_name` varchar(255) NOT NULL,
  `contact_phone` varchar(50) NOT NULL,
  `sms_message` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `gateway_response` text NOT NULL,
  `date_created` datetime NOT NULL,
  `date_executed` datetime NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  `gateway` varchar(255) NOT NULL DEFAULT 'twilio',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `mt_sms_broadcast_details` */

/*Table structure for table `mt_sms_package` */

DROP TABLE IF EXISTS `mt_sms_package`;

CREATE TABLE `mt_sms_package` (
  `sms_package_id` int(14) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` float(14,4) NOT NULL,
  `promo_price` float(14,4) NOT NULL,
  `sms_limit` int(14) NOT NULL,
  `sequence` int(14) NOT NULL,
  `status` varchar(100) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `ip_address` varchar(100) NOT NULL,
  PRIMARY KEY (`sms_package_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `mt_sms_package` */

/*Table structure for table `mt_sms_package_trans` */

DROP TABLE IF EXISTS `mt_sms_package_trans`;

CREATE TABLE `mt_sms_package_trans` (
  `id` int(14) NOT NULL AUTO_INCREMENT,
  `merchant_id` int(14) NOT NULL,
  `sms_package_id` int(14) NOT NULL,
  `payment_type` varchar(50) NOT NULL,
  `package_price` float(14,4) NOT NULL,
  `sms_limit` int(14) NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'pending',
  `payment_reference` varchar(255) NOT NULL,
  `payment_gateway_response` text NOT NULL,
  `date_created` datetime NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `mt_sms_package_trans` */

/*Table structure for table `mt_stripe_logs` */

DROP TABLE IF EXISTS `mt_stripe_logs`;

CREATE TABLE `mt_stripe_logs` (
  `id` int(14) NOT NULL AUTO_INCREMENT,
  `order_id` int(14) NOT NULL,
  `json_result` text CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `mt_stripe_logs` */

/*Table structure for table `mt_subcategory` */

DROP TABLE IF EXISTS `mt_subcategory`;

CREATE TABLE `mt_subcategory` (
  `subcat_id` int(14) NOT NULL AUTO_INCREMENT,
  `merchant_id` int(14) NOT NULL,
  `subcategory_name` varchar(255) NOT NULL,
  `subcategory_description` text NOT NULL,
  `discount` varchar(20) NOT NULL,
  `sequence` int(14) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'publish',
  `subcategory_name_trans` text NOT NULL,
  `subcategory_description_trans` text NOT NULL,
  `is_group` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`subcat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `mt_subcategory` */

insert  into `mt_subcategory`(`subcat_id`,`merchant_id`,`subcategory_name`,`subcategory_description`,`discount`,`sequence`,`date_created`,`date_modified`,`ip_address`,`status`,`subcategory_name_trans`,`subcategory_description_trans`,`is_group`) values (1,1,'fdsfsdf1112','lmlklk333','',0,'2015-12-23 15:22:00','0000-00-00 00:00:00','127.0.0.1','publish','','',0);

/*Table structure for table `mt_subcategory_item` */

DROP TABLE IF EXISTS `mt_subcategory_item`;

CREATE TABLE `mt_subcategory_item` (
  `sub_item_id` int(14) NOT NULL AUTO_INCREMENT,
  `merchant_id` int(14) NOT NULL,
  `sub_item_name` varchar(255) NOT NULL,
  `item_description` text NOT NULL,
  `category` varchar(255) NOT NULL,
  `price` varchar(15) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `sequence` int(14) NOT NULL,
  `status` varchar(50) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  `sub_item_name_trans` text NOT NULL,
  `item_description_trans` text NOT NULL,
  PRIMARY KEY (`sub_item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `mt_subcategory_item` */

insert  into `mt_subcategory_item`(`sub_item_id`,`merchant_id`,`sub_item_name`,`item_description`,`category`,`price`,`photo`,`sequence`,`status`,`date_created`,`date_modified`,`ip_address`,`sub_item_name_trans`,`item_description_trans`) values (1,1,'sdsfdsf','sdfdsf','[\"1\"]','22','1450873340-2014-01-25-18.37.39.png',0,'publish','2015-12-23 15:22:22','0000-00-00 00:00:00','127.0.0.1','','');

/*Table structure for table `mt_voucher` */

DROP TABLE IF EXISTS `mt_voucher`;

CREATE TABLE `mt_voucher` (
  `voucher_id` int(14) NOT NULL AUTO_INCREMENT,
  `voucher_owner` varchar(255) NOT NULL DEFAULT '',
  `merchant_id` int(11) NOT NULL DEFAULT '0',
  `joining_merchant` text,
  `voucher_name` varchar(255) NOT NULL,
  `voucher_type` varchar(255) NOT NULL,
  `amount` float(8,2) NOT NULL,
  `expiration` date DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `date_created` datetime NOT NULL,
  `date_modified` datetime DEFAULT NULL,
  `used_once` int(1) NOT NULL DEFAULT '0',
  `service_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`voucher_id`),
  KEY `voucher_name` (`voucher_name`),
  KEY `status` (`status`),
  KEY `merchant_id` (`merchant_id`),
  KEY `service_id` (`service_id`),
  CONSTRAINT `mt_voucher_ibfk_1` FOREIGN KEY (`merchant_id`) REFERENCES `mt_merchant` (`merchant_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `mt_voucher_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `category_has_merchant` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `mt_voucher` */

insert  into `mt_voucher`(`voucher_id`,`voucher_owner`,`merchant_id`,`joining_merchant`,`voucher_name`,`voucher_type`,`amount`,`expiration`,`status`,`date_created`,`date_modified`,`used_once`,`service_id`) values (1,'',2,'[]','Sommer Special','1',10.00,'2016-08-31',1,'2016-05-02 18:26:07','2016-05-12 12:42:08',0,13);

/*Table structure for table `mt_voucher_list` */

DROP TABLE IF EXISTS `mt_voucher_list`;

CREATE TABLE `mt_voucher_list` (
  `voucher_id` int(14) NOT NULL,
  `voucher_code` varchar(50) NOT NULL,
  `status` varchar(50) CHARACTER SET latin1 NOT NULL DEFAULT 'unused',
  `client_id` int(14) NOT NULL,
  `date_used` varchar(50) NOT NULL,
  `order_id` int(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `mt_voucher_list` */

/*Table structure for table `mt_withdrawal` */

DROP TABLE IF EXISTS `mt_withdrawal`;

CREATE TABLE `mt_withdrawal` (
  `withdrawal_id` int(14) NOT NULL AUTO_INCREMENT,
  `merchant_id` int(14) NOT NULL,
  `payment_type` varchar(100) NOT NULL,
  `payment_method` varchar(100) NOT NULL,
  `amount` float(14,4) NOT NULL,
  `current_balance` float(14,4) NOT NULL,
  `balance` float(14,4) NOT NULL,
  `currency_code` varchar(3) NOT NULL,
  `account` varchar(255) NOT NULL,
  `account_name` varchar(255) NOT NULL,
  `bank_account_number` varchar(255) NOT NULL,
  `swift_code` varchar(100) NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `bank_branch` varchar(255) NOT NULL,
  `bank_country` varchar(50) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `viewed` int(2) NOT NULL DEFAULT '1',
  `date_created` datetime NOT NULL,
  `date_to_process` date NOT NULL,
  `date_process` datetime NOT NULL,
  `api_raw_response` text NOT NULL,
  `withdrawal_token` text NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  `bank_type` varchar(255) NOT NULL DEFAULT 'default',
  PRIMARY KEY (`withdrawal_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `mt_withdrawal` */

/*Table structure for table `mt_zipcode` */

DROP TABLE IF EXISTS `mt_zipcode`;

CREATE TABLE `mt_zipcode` (
  `zipcode_id` int(14) NOT NULL AUTO_INCREMENT,
  `zipcode` varchar(255) NOT NULL,
  `country_code` varchar(5) NOT NULL,
  `city` varchar(255) NOT NULL,
  `area` varchar(255) NOT NULL,
  `stree_name` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`zipcode_id`),
  KEY `country_code` (`country_code`),
  KEY `area` (`area`),
  KEY `stree_name` (`stree_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `mt_zipcode` */

/*Table structure for table `order` */

DROP TABLE IF EXISTS `order`;

CREATE TABLE `order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `client_id` int(11) DEFAULT NULL,
  `payment_type` tinyint(2) NOT NULL DEFAULT '0',
  `client_name` varchar(50) NOT NULL DEFAULT '',
  `client_phone` varchar(50) NOT NULL DEFAULT '',
  `client_email` varchar(50) NOT NULL DEFAULT '',
  `order_time` datetime NOT NULL,
  `category_id` int(11) NOT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `merchant_id` int(11) NOT NULL DEFAULT '0',
  `create_time` datetime NOT NULL,
  `is_group` int(1) NOT NULL DEFAULT '0',
  `source_type` int(2) NOT NULL DEFAULT '0',
  `order_id` int(11) NOT NULL,
  `price` float(8,2) NOT NULL DEFAULT '0.00',
  `more_info` varchar(511) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `fk_order_client1_idx` (`client_id`),
  KEY `fk_order_subcat_12` (`category_id`),
  KEY `fl_order_staf_123` (`staff_id`),
  CONSTRAINT `fk_order_client1` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_order_subcat_12` FOREIGN KEY (`category_id`) REFERENCES `category_has_merchant` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fl_order_staf_123` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;

/*Data for the table `order` */

insert  into `order`(`id`,`status`,`client_id`,`payment_type`,`client_name`,`client_phone`,`client_email`,`order_time`,`category_id`,`staff_id`,`merchant_id`,`create_time`,`is_group`,`source_type`,`order_id`,`price`,`more_info`) values (10,0,NULL,0,'susi','123456','susi@test.de','2016-05-23 11:00:00',14,12,2,'0000-00-00 00:00:00',0,0,0,0.00,''),(11,0,NULL,0,'baby','334455','bayb@test.de','2016-05-23 10:00:00',14,10,2,'0000-00-00 00:00:00',0,0,0,0.00,''),(12,0,NULL,0,'maxi','987665','maxi@test.de','2016-05-23 14:00:00',22,10,2,'0000-00-00 00:00:00',0,0,0,0.00,''),(14,0,NULL,0,'Daisy','998877','daisy@test.de','2016-05-24 12:00:00',17,12,2,'0000-00-00 00:00:00',0,0,0,0.00,''),(15,0,NULL,0,'babsi','445566','babsi@test.de','2016-05-17 10:00:00',19,11,2,'0000-00-00 00:00:00',0,0,0,0.00,''),(16,0,NULL,0,'donna','123456','donna@test.de','2016-05-23 12:00:00',17,10,2,'0000-00-00 00:00:00',0,0,0,0.00,''),(17,0,NULL,0,'mel','567432','mel@test.de','2016-05-18 14:00:00',19,10,2,'0000-00-00 00:00:00',0,0,0,0.00,''),(18,0,NULL,0,'Zest','1346','Tester@test.de','2016-05-18 15:00:00',17,9,2,'0000-00-00 00:00:00',0,0,0,0.00,''),(19,0,NULL,0,'trixi','1234567','trixi@test.de','2016-05-18 15:45:00',17,9,2,'0000-00-00 00:00:00',0,0,0,0.00,''),(20,0,NULL,0,'bibi','988765','bibi@test.de','2016-05-26 11:30:00',23,9,2,'0000-00-00 00:00:00',0,0,0,0.00,''),(21,0,NULL,0,'kiki','654321','kiki@test.de','2016-05-23 11:15:00',20,10,2,'0000-00-00 00:00:00',0,0,0,0.00,''),(22,0,NULL,0,'babsi','665544','babsi@test.de','2016-05-23 16:15:00',22,10,2,'0000-00-00 00:00:00',0,0,0,0.00,''),(23,0,NULL,0,'dixi','1234567','dixi@test.de','2016-05-23 09:00:00',14,12,2,'0000-00-00 00:00:00',0,0,0,0.00,''),(25,2,NULL,0,'s7','dsfds','dsfdsf','2016-05-31 09:00:00',14,6,2,'2016-05-25 19:23:08',0,1,2147483647,0.00,''),(26,0,NULL,0,'dsadsadas','asdsa','asdsa','2016-05-31 09:00:00',21,10,2,'2016-05-25 19:28:08',0,1,2147483647,0.00,''),(27,2,NULL,0,'ddsad','dsfds','strafun.web@gmail.com','2016-05-31 09:00:00',21,10,2,'2016-05-25 19:28:54',0,1,2147483647,0.00,''),(28,0,NULL,0,'wefwe','efewf','strafun.web@gmail.com','2016-05-26 15:00:00',16,6,2,'2016-05-25 19:34:00',1,1,2147483647,0.00,'ewrw'),(30,0,NULL,0,'dsad','sdad','strafun.web@gmail.com','2016-05-26 15:00:00',16,6,2,'2016-05-25 20:17:35',1,1,2147483647,0.00,'sadsad'),(32,0,NULL,0,'выы','0636989961','strafun.web@gmail.com','2016-06-02 15:00:00',16,6,2,'2016-05-26 19:14:36',1,1,2147483647,0.00,'авыаыва'),(33,0,NULL,0,'sadas','0636989961','strafun.web@gmail.com','2016-06-07 09:30:00',14,6,2,'2016-06-06 17:19:17',0,1,2147483647,0.00,''),(34,0,NULL,0,'sadas','0636989961','strafun.web@gmail.com','2016-06-08 09:45:00',14,10,2,'2016-06-06 17:24:06',0,1,2147483647,0.00,''),(35,0,NULL,0,'sadas','0636989961','strafun.web@gmail.com','2016-06-07 12:30:00',14,6,2,'2016-06-06 17:53:03',0,1,2147483647,0.00,''),(36,0,NULL,0,'sadas','0636989961','strafun.web@gmail.com','2016-06-07 15:00:00',14,6,2,'2016-06-06 17:56:37',0,1,2147483647,0.00,''),(37,0,NULL,0,'sadas','0636989961','strafun.web@gmail.com','2016-06-07 17:00:00',14,6,2,'2016-06-06 18:03:46',0,1,2147483647,0.00,''),(38,2,NULL,0,'pepe','333','strafun.web@gmail.com','2016-06-08 10:00:00',14,6,2,'2016-06-07 14:37:20',0,1,2147483647,0.00,''),(39,2,NULL,0,'dfdsfds','324234','strafun.web@gmail.com','2016-06-09 15:00:00',16,6,2,'2016-06-07 14:43:45',1,1,2147483647,0.00,'ewrw'),(40,0,NULL,0,'ewe1111','werer','strafun.web@gmail.com','2016-06-09 15:00:00',16,6,2,'2016-06-07 14:44:22',1,1,2147483647,0.00,'werewr'),(41,0,NULL,0,'ereww213','234234','strafun.web@gmail.com','2016-06-09 15:00:00',16,6,2,'2016-06-07 15:38:08',1,1,2147483647,0.00,'erewr'),(42,0,NULL,0,'dsfds','sdfsdf','strafun.web@gmail.com','2016-06-09 15:00:00',16,6,2,'2016-06-07 18:14:13',1,1,2147483647,155.00,'dfdsf'),(43,0,NULL,0,'вів','2222','strafun.web@gmail.com','2016-06-09 09:00:00',14,6,2,'2016-06-08 13:33:20',0,1,2147483647,189.00,''),(44,0,NULL,0,'ewqewq','qwewqe','strafun.web@gmail.com','2016-06-14 09:00:00',14,6,2,'2016-06-10 19:27:05',0,1,2147483647,189.00,'');

/*Table structure for table `schedule_days_template` */

DROP TABLE IF EXISTS `schedule_days_template`;

CREATE TABLE `schedule_days_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(45) DEFAULT NULL,
  `merchant_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`merchant_id`),
  KEY `merchant_id` (`merchant_id`),
  CONSTRAINT `merchant_id` FOREIGN KEY (`merchant_id`) REFERENCES `mt_merchant` (`merchant_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

/*Data for the table `schedule_days_template` */

insert  into `schedule_days_template`(`id`,`title`,`merchant_id`) values (4,'regular day',3),(5,'sanday',2),(6,'Fullday',3),(7,'Morning',2),(8,'Afternoon',2),(9,'Saturday',3),(10,'fullday',2),(11,'Makeup Class',2);

/*Table structure for table `staff` */

DROP TABLE IF EXISTS `staff`;

CREATE TABLE `staff` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `merchant_id` int(11) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`,`merchant_id`),
  KEY `fk_staff_category_has_merchant1_idx` (`merchant_id`),
  CONSTRAINT `fk_merch_for_staf_id` FOREIGN KEY (`merchant_id`) REFERENCES `mt_merchant` (`merchant_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

/*Data for the table `staff` */

insert  into `staff`(`id`,`name`,`merchant_id`,`is_active`) values (6,'Tina',2,1),(9,'Susi',2,1),(10,'Iris',2,1),(11,'Gabi',2,1),(12,'Eva',2,1),(13,'Bella',3,1);

/*Table structure for table `staff_has_category` */

DROP TABLE IF EXISTS `staff_has_category`;

CREATE TABLE `staff_has_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`staff_id`,`category_id`),
  KEY `fk_staff_12345` (`staff_id`),
  KEY `fk_categ_s_6634` (`category_id`),
  CONSTRAINT `fk_categ_s_6634` FOREIGN KEY (`category_id`) REFERENCES `category_has_merchant` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_staff_12345` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=190 DEFAULT CHARSET=utf8;

/*Data for the table `staff_has_category` */

insert  into `staff_has_category`(`id`,`staff_id`,`category_id`) values (167,6,14),(168,6,21),(169,6,22),(170,6,17),(171,6,20),(164,9,13),(165,9,17),(166,9,23),(182,10,14),(183,10,21),(184,10,22),(185,10,13),(186,10,17),(187,10,7),(188,10,19),(189,10,20),(178,11,7),(179,11,18),(180,11,19),(181,11,20),(172,12,14),(173,12,21),(174,12,22),(175,12,13),(176,12,17),(177,12,19),(108,13,2);

/*Table structure for table `staff_schedule` */

DROP TABLE IF EXISTS `staff_schedule`;

CREATE TABLE `staff_schedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `work_date` date NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `staff_id` int(11) NOT NULL,
  `reason` varchar(520) NOT NULL DEFAULT '',
  `schedule_days_template_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_staff_schedule_staff1_idx` (`staff_id`),
  KEY `schedule_days_template_id` (`schedule_days_template_id`),
  CONSTRAINT `fk_staff_schedule_staff1` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `staff_schedule_ibfk_1` FOREIGN KEY (`schedule_days_template_id`) REFERENCES `schedule_days_template` (`id`) ON DELETE CASCADE ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `staff_schedule` */

insert  into `staff_schedule`(`id`,`work_date`,`status`,`staff_id`,`reason`,`schedule_days_template_id`) values (3,'2016-05-06',0,6,'seminar',7),(4,'2016-05-20',0,10,'seminar',7),(6,'2016-05-23',0,12,'krank',NULL);

/*Table structure for table `staff_schedule_has_time_range` */

DROP TABLE IF EXISTS `staff_schedule_has_time_range`;

CREATE TABLE `staff_schedule_has_time_range` (
  `staff_schedule_id` int(11) NOT NULL,
  `time_range_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`staff_schedule_id`,`time_range_id`),
  KEY `fk_staff_schedule_has_time_range_time_range1_idx` (`time_range_id`),
  KEY `fk_staff_schedule_has_time_range_staff_schedule1_idx` (`staff_schedule_id`),
  CONSTRAINT `fk_staff_schedule_has_time_range_staff_schedule1` FOREIGN KEY (`staff_schedule_id`) REFERENCES `staff_schedule` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_staff_schedule_has_time_range_time_range1` FOREIGN KEY (`time_range_id`) REFERENCES `time_range` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `staff_schedule_has_time_range` */

/*Table structure for table `staff_schedule_history` */

DROP TABLE IF EXISTS `staff_schedule_history`;

CREATE TABLE `staff_schedule_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL,
  `mon` int(11) DEFAULT NULL,
  `tue` int(11) DEFAULT NULL,
  `wed` int(11) DEFAULT NULL,
  `thu` int(11) DEFAULT NULL,
  `fri` int(11) DEFAULT NULL,
  `sat` int(11) DEFAULT NULL,
  `sun` int(11) DEFAULT NULL,
  `change_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `staff_id` (`staff_id`),
  KEY `mon` (`mon`),
  KEY `tue` (`tue`),
  KEY `wed` (`wed`),
  KEY `thu` (`thu`),
  KEY `fri` (`fri`),
  KEY `sat` (`sat`),
  KEY `sun` (`sun`),
  CONSTRAINT `staff_schedule_history_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `staff_schedule_history_ibfk_2` FOREIGN KEY (`mon`) REFERENCES `schedule_days_template` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `staff_schedule_history_ibfk_3` FOREIGN KEY (`tue`) REFERENCES `schedule_days_template` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `staff_schedule_history_ibfk_4` FOREIGN KEY (`wed`) REFERENCES `schedule_days_template` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `staff_schedule_history_ibfk_5` FOREIGN KEY (`thu`) REFERENCES `schedule_days_template` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `staff_schedule_history_ibfk_6` FOREIGN KEY (`fri`) REFERENCES `schedule_days_template` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `staff_schedule_history_ibfk_7` FOREIGN KEY (`sat`) REFERENCES `schedule_days_template` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `staff_schedule_history_ibfk_8` FOREIGN KEY (`sun`) REFERENCES `schedule_days_template` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

/*Data for the table `staff_schedule_history` */

insert  into `staff_schedule_history`(`id`,`staff_id`,`mon`,`tue`,`wed`,`thu`,`fri`,`sat`,`sun`,`change_date`) values (4,6,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(8,9,6,NULL,6,7,7,NULL,NULL,NULL),(9,6,6,6,7,6,6,9,NULL,NULL),(10,9,6,NULL,6,7,7,NULL,NULL,NULL),(12,6,6,6,7,6,8,9,NULL,NULL),(14,6,6,6,7,6,8,9,NULL,NULL),(15,9,6,NULL,6,7,7,NULL,NULL,NULL),(17,6,6,6,7,6,8,9,NULL,NULL),(19,10,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(20,10,6,6,6,6,6,9,NULL,NULL),(21,11,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(22,11,6,7,8,6,6,9,NULL,NULL),(23,12,7,7,7,7,7,NULL,NULL,NULL),(25,12,7,7,7,7,7,NULL,NULL,NULL),(27,12,7,7,7,7,7,NULL,NULL,NULL),(28,10,6,6,6,6,6,9,NULL,NULL),(29,12,7,7,7,7,7,NULL,NULL,NULL),(30,13,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(32,13,4,4,4,4,4,9,NULL,NULL),(33,12,7,7,7,7,7,NULL,NULL,NULL),(34,10,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(35,10,10,10,10,10,10,7,NULL,NULL),(36,11,NULL,7,8,NULL,NULL,NULL,NULL,NULL),(37,6,NULL,NULL,7,NULL,8,NULL,NULL,NULL),(38,6,10,10,7,10,8,NULL,NULL,NULL),(39,9,NULL,NULL,NULL,7,7,NULL,NULL,NULL),(40,11,11,7,11,NULL,11,NULL,NULL,NULL);

/*Table structure for table `staff_vacation` */

DROP TABLE IF EXISTS `staff_vacation`;

CREATE TABLE `staff_vacation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `remark` varchar(510) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `staff_id` (`staff_id`),
  CONSTRAINT `staff_vacation_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `staff_vacation` */

insert  into `staff_vacation`(`id`,`staff_id`,`start_date`,`end_date`,`remark`) values (2,6,'2016-04-24','2016-04-30','Holiday'),(3,9,'2016-05-15','2016-05-21','Urlaub'),(4,6,'2016-05-21','2016-05-28','Holiday');

/*Table structure for table `tbl_migration` */

DROP TABLE IF EXISTS `tbl_migration`;

CREATE TABLE `tbl_migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `tbl_migration` */

insert  into `tbl_migration`(`version`,`apply_time`) values ('m000000_000000_base',1452693933),('m160113_140447_init',1452693935),('m160123_134123_table_categories',1453560367),('m160123_134134_table_subcategories',1453560367),('m160124_182442_table_user_and_package_fixes',1453661673),('m160124_185830_add_fields_admin_merchant',1453662236),('m160124_193147_clear_tables',1453665084),('m160125_083714_voucher_changing',1453712670),('m160125_105153_clear_page_custom',1453719479),('m160125_115729_clear_client',1453723892),('m160125_131441_clear_payment',1453728410),('m160125_174548_clear_and_add_merchant',1453753910),('m160125_203656_add_c_seo',1453754685),('m160126_094642_clear_settings',1453801921),('m160308_070914_gallery',1457421046),('m160416_062610_merch_soc_add',1460796329),('m160420_081337_merch_subcat_remove',1461163135),('m160424_151914_group_status',1461512865),('m160512_094852_add_color_to_cat',1463049492),('m160513_031621_add_merch_id_order',1463110837),('m160520_163425_addtimes_to_order',1464111802),('m160520_163946_addtimes_to_gorder',1464111804),('m160523_054906_types_to_order',1464111810),('m160524_072035_order_id',1464111811),('m160524_121813_add_f_to_order',1464111815),('m160527_174746_addyiit',1464371832),('m160614_104601_additional_fix_f',1465901709);

/*Table structure for table `time_range` */

DROP TABLE IF EXISTS `time_range`;

CREATE TABLE `time_range` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time_from` varchar(45) NOT NULL,
  `time_to` varchar(45) NOT NULL,
  `additional_time` varchar(45) NOT NULL DEFAULT '0',
  `schedule_days_template_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_time_range_schedule_days_template_idx` (`schedule_days_template_id`),
  CONSTRAINT `fk_time_range_schedule_days_template` FOREIGN KEY (`schedule_days_template_id`) REFERENCES `schedule_days_template` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

/*Data for the table `time_range` */

insert  into `time_range`(`id`,`time_from`,`time_to`,`additional_time`,`schedule_days_template_id`) values (6,'08:30','12:30','0',4),(8,'09:00','12:00','0',5),(9,'14:00','18:00','0',5),(10,'19:30','21:00','0',5),(11,'08:30','19:30','0',6),(13,'09:00','13:00','0',7),(14,'13:00','19:00','0',8),(15,'13:30','18:30','0',4),(16,'09:00','16:00','0',9),(17,'09:00','18:30','0',10),(18,'09:00','12:00','0',11),(19,'16:00','19:00','0',11);

/*Table structure for table `yii_t` */

DROP TABLE IF EXISTS `yii_t`;

CREATE TABLE `yii_t` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value_en` varchar(255) NOT NULL,
  `translate_de` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=870 DEFAULT CHARSET=utf8;

/*Data for the table `yii_t` */

insert  into `yii_t`(`id`,`value_en`,`translate_de`) values (3,'ID','id'),(4,'Name','Name'),(5,'Price','Preis'),(6,'Image','Bild'),(7,'Merchant','Händler'),(8,'Time in minutes','Dauer in Minuten'),(9,'Add-on','Zusatzleistungen'),(10,'Order','Termin'),(11,'Staff','Mitarbeiter'),(12,'Subcategory','Unterkategorie'),(13,'Category','Kategorie'),(14,'Additional Time','Zusatzliche Zeit'),(15,'Service Time Slot','Zeitfenster'),(16,'Add-ons','Zusatzleistungen'),(17,'Peoples In Group','Anzahl Teilnehmer'),(18,'Title','Titel'),(19,'Color','Farbe'),(20,'Client','Kunde'),(21,'Social Strategy','Strategie Soziale Medien'),(22,'First Name','Vorname'),(23,'Last Name','Nachname'),(24,'Email Address','Email Adresse'),(25,'Password','Passwort'),(26,'Street','Straße'),(27,'City','Stadt'),(28,'State','Bundesland'),(29,'Zipcode','PLZ'),(30,'Country Code','Länderkürzel'),(31,'Location Name','Location'),(32,'Contact Phone','Kontakt Telefon'),(33,'Lost Password Token','Passwort vergessen'),(34,'Date Created','Erstelldatum'),(35,'Date Modified','Barbeitungsdatum'),(36,'Last Login','Letzter Login'),(37,'Ip Address','IP Adresse'),(38,'Is Active','Ist aktiv'),(39,'Token','Token'),(40,'Mobile Verification Code','Mobiler Verifikationscode'),(41,'Mobile Verification Date','Datum Mobile VerifiKation'),(42,'Custom Field One','Benutzerdefiniertes Feld 1'),(43,'Custom Field Two','Benutzerdefiniertes Feld 2'),(44,'Cc','CC'),(45,'Card Name','Karten Name'),(46,'Credit Card Number','Kreditkarten Nummer'),(47,'Expiration Month','Gültig bis (Monat)'),(48,'Expiration Yr','Gültig bis (Jahr)'),(49,'Cvv','CVV'),(50,'Billing Address','Rechnungsadresse'),(51,'Slug Name','Slug Name'),(52,'Page Name','Seitenname'),(53,'Content','Inhalt'),(54,'Seo Title','SEO Titel'),(55,'Meta Description','Meta Beschreibung'),(56,'Meta Keywords','Meta Schlüsselwörter'),(57,'Icons','Icon'),(58,'Assign To','Zugewiesen'),(59,'Sequence','Sequenz'),(60,'Open New Tab','Neuen Tab öffnen'),(61,'Is Custom Link','Benutzerdefinierter Link'),(62,'Work Date','Arbeits Datum'),(63,'Group','Gruppe'),(64,'Reason','Grund'),(65,'Schedule Days Template','Vorlage Arbeitszeiten'),(66,'Mon','Mo'),(67,'Tue','Di'),(68,'Wed','Mi'),(69,'Thu','Do'),(70,'Fri','Fr'),(71,'Sat','Sa'),(72,'Sun','So'),(73,'Change Date','Datum ändern'),(74,'Time Start','Beginn'),(75,'Group Schedule Days Template','Vorlage Gruppenplan'),(76,'Count On Order','Für Terminvereinbarung'),(77,'Count On Like','Für Likes bei Facebook'),(79,'Count On Comment','Für Kommentar'),(80,'Count On Rate','Für Bewertung'),(81,'Main Photo','Hauptbild'),(82,'Service Name','Firmenname'),(83,'Service Phone','Telefon'),(84,'Contact Name','Kontaktperson'),(85,'Contact Email','Email'),(86,'Post Code','PLZ'),(87,'Cuisine','Cuisine'),(88,'Service','Service'),(89,'Free Delivery','Free Delivery'),(90,'Delivery Estimation','Delivery Estimation'),(91,'Merchant Admin Email','Admin Email'),(92,'Merchant Manager Email','Manager Email'),(93,'Activation Key','Aktivierungscode'),(94,'Activation Token','Aktivierungs Token'),(95,'Date Activated','Aktivierungsdatum'),(96,'Package','Abo Plan'),(97,'Package Price','Abo Preis'),(98,'Membership Expired','Mitgliedschaft beendet'),(99,'Payment Steps','Zahlungsschritte'),(100,'Is Featured','Hervorgehoben'),(101,'Is Ready','Fertig'),(102,'Is Sponsored','Sponsor'),(103,'Sponsored Expiration','Sponsor endet'),(104,'Lost Password Code','Code vergessenes Passwort'),(105,'User Lang','Benutzer Sprache'),(106,'Membership Purchase Date','Kaufdatum Mitgliedschaft'),(107,'Sort Featured','Sortieren'),(108,'Is Commission','Provision'),(109,'Percent Commission','Prozentuale Provision'),(110,'Fixed Commission','Fixe Provision'),(111,'Session Token','Session Token'),(112,'Commission Type','Provisionstyp'),(113,'New Password','Neues Passwort'),(114,'Confirm Password','Passwort bestätigen'),(115,'Manager New Password','Neues Passwort für Manager'),(116,'Manager Confirm Password','Neues Passwort für Manager bestätigen'),(117,'Extended Manager','Erweiterter Manager'),(118,'Facebook','Facebook'),(119,'Twitter','Twitter'),(120,'Google','Google'),(121,'Youtube','Youtube'),(122,'Instagram','Instagram'),(123,'PayPall ID','Paypal ID'),(124,'PayPall Pass','Paypal Passwort'),(125,'Altitude','Altitude'),(126,'Latitude','Latitude'),(127,'Address','Adresse'),(128,'Vkontakte','Vkontakte'),(129,'Pinterest','Pinterest'),(130,'Merchant User','Händler Benutzer'),(131,'User Access','Benutzer Zugriff'),(132,'M C','MC'),(133,'option name','Option'),(134,'Disabled popup asking customer address','Popup Benutzeradresse deaktiviert'),(135,'Disabled send sms/email after change order','SMS/Email senden nach Änderung der Bestellung deaktiviert'),(136,'Disabled Guest Checkout','Checkout für Gäste deaktiviert'),(137,'Default Menu','Hauptmenu'),(138,'Disabled Sticky Cart','Sticky Cart deaktiviert'),(139,'Enabled Map Address','Adresse auf Karte aktiviert'),(140,'Disabled','Deaktiviert'),(142,'Disabled Registration','Registrierung deaktiviert'),(143,'Disabled Verification','Verifikation deaktiviert'),(144,'Enabled Payment','Zahlungsart aktiviert'),(145,'Disabled Paypal','Zahlungsart deaktiviert'),(146,'Disabled Card Payment','Kreditkartenzahlung deaktiviert'),(147,'Exclude All Offline Payment from admin balance','Alle Offline Zahlungen von Admin Bilanz exkludieren'),(148,'Enabled Commission','Provision aktiviert'),(149,'Disabled Membership','Mitgliedschaft deaktiviert'),(150,'Include Cash Payment on merchant balance','Barzahlungen der Händlerbilanz hinzufügen'),(151,'Set commission on','Provision setzen auf'),(152,'email provider','Email Provider'),(153,'Display Google Map','Google Map deaktivieren'),(154,'Disabled Social Icon','Soziale Medien deaktivieren'),(155,'Disabled restaurant share','Geschäft teilen deaktivieren'),(156,'Disabled Facebook Login','Facebook Login deaktivieren'),(157,'Enabled Google Login','Google Anmeldung aktivieren'),(158,'Mode','Methode'),(159,'Option Value','Optionswert'),(160,'Payment Type','Zahlungsart'),(161,'Client Name','Kunden Name'),(162,'Client Phone','Kunden Telefon'),(163,'Client Email','Kunden Email'),(164,'Order Time','Termindatum/Uhrzeit'),(165,'Client time','Kunden Uhrzeit'),(166,'More Info','Mehr Info'),(167,'Is Group Order','Gruppenbestellung'),(168,'Status','Status'),(169,'Description','Beschreibung'),(170,'Promo Price','Promotion Preis'),(171,'Expiration Days','Ablauf in Tage'),(172,'Expiration Type','Ablauftyp'),(173,'Unlimited Post','Unbegrenzte Posts'),(174,'Post Limit','Post Limit'),(175,'Sell Limit','Verkaufslimit'),(176,'Workers Limit','Mitarbeiter Limit'),(177,'Payment Name','Name Zahlungsart'),(178,'Payment Logo','Logo Bezahlart'),(179,'Rating Start','Rating Start'),(180,'Rating End','Rating Ende'),(181,'Meaning','Bedeutung'),(182,'Review','Rezension'),(183,'Rating','Bewertung'),(184,'Time Range','Zeitspanne'),(185,'Is Approved','ist bestätigt'),(186,'Approved Text','Bestätigter Text'),(187,'Date Updated','Aktualisiert am'),(188,'Categories','Kategorien'),(189,'Staff Schedule','Arbeitsplan Mitarbeiter'),(191,'Start Date','Beginn'),(192,'End Date','Ende'),(193,'Remark','Hinweis'),(194,'Time From','Zeit von'),(195,'Time To','Zeit bis'),(196,'Voucher','Rabattcoupon'),(197,'Voucher Owner','Rabattcoupon Inhaber'),(198,'Joining Merchant','Teilnehmender Händler'),(199,'Voucher Name','Rabattcoupon Bezeichnung'),(200,'Voucher Type','Rabattcoupon Typ'),(201,'Amount','Betrag'),(202,'Used Once','Einmal gebraucht'),(204,'Voucher Code','Rabattcoupon Code'),(205,'Date Used','Gebraucht am'),(206,'Value En','Wert'),(207,'Translate De','Übersetzung'),(208,'Activate Menu 1','Menu 1 aktivieren'),(209,'Activate Menu 2','Menu 2 aktivieren'),(210,'Address & Currency','Adresse & Währung'),(211,'Admin Commission Settings','Admin Provisions Einstellungen'),(212,'Administration','Administration'),(213,'Available Tags','Verfügbare Tags'),(214,'Available tags {merchant-name}','Verfügbare Tags {merchant-name}'),(215,'Back','Zurück'),(216,'Block email address list','Liste gesperrter Email Adressen'),(217,'Block mobile number list','Liste gesperrter Handynummer'),(218,'Booking Summary Report','Bericht Termin Zusammenfassung'),(219,'Card Fee','Kreditkartengebühr'),(220,'Cart Options','Optionen Einkaufswagen'),(221,'Category List','Kategorieliste'),(222,'Check this if you want to disabled merchant Verification','Markieren wenn Händler Verifikation deaktiviert werden soll'),(223,'Check this if you want to disabled merchant registration','Markieren wenn Händler Registrierung deaktiviert werden soll'),(224,'Checkout Page','Checkout Seite'),(225,'Client Contact Content','Kunden Kontakt Inhalt'),(226,'Client ID','Kunden ID'),(227,'Client Secret','Kunden Secret'),(228,'Commission','Provision'),(229,'Commission (%)','Provision (%)'),(230,'Commission Settings','Provisionseinstellungen'),(231,'Commission on Sub total order','Provision auf Zwischensumme'),(232,'Commission on Total order','Provision auf Endsumme'),(233,'Commission price','Provisionsrate'),(234,'Contact Page','Kontaktseite'),(235,'Contact Settings','Kontakteinstellungen'),(236,'Custom Page','Benutzerdefinierte Seite'),(237,'Customer List','Kundenliste'),(238,'Customer popup address options','Optionen für Kundenadresse Popup'),(239,'Dashboard','Übersicht'),(240,'Date','Datum'),(242,'Delivery Fee','Liefergebühr'),(243,'Email Template','Email Vorlage'),(247,'Featured Services','Featured Service'),(248,'Fixed','Fix'),(249,'Forgot Password','Passwort vergessen'),(250,'General Settings','Allgemeine Einstellungen'),(252,'Google Page URL','URL Google Page'),(253,'Guest Checkout','Gäste Checkout'),(254,'Home Page','Homepage'),(256,'Instagramm','Instagram'),(257,'Invoice','Rechnung'),(258,'Live','Live'),(259,'Login','Login'),(260,'Logout','Logout'),(261,'Mail & SMTP Settings','Mail & SMTP Einstellungen'),(262,'Manage Language','Sprachen verwalten'),(263,'Mandrill API','Mandrill API'),(264,'Map','Karte'),(265,'Menu Options','Menu Optionen'),(266,'Menu Page','Menu Seite'),(267,'Merchant Commission','Händler Provision'),(268,'Merchant Contact Content','Händler Kontakt'),(269,'Merchant List','Händler Liste'),(270,'Merchant Name','Händler Name'),(271,'Merchant Payment','Zahlungsart Händler'),(272,'Merchant Registration','Händler Registrierung'),(273,'Merchant Sales Report','Verkaufsbericht Händler'),(274,'Merchant Sales Summary Report','Händler Verkaufsbericht Zusammenfassung'),(275,'Merchant Signup Page','Händler Anmeldeseite'),(276,'Merchant Signup Settings','Anmeldeeinstellungen Händler'),(277,'Merchant change order options','Händler Optionen Bestellung ändern'),(280,'Multiple email separated by comma','Mehrere Emails mit Komma getrennt'),(281,'Multiple mobile separated by comma','Mehrere Handynummer mit Komma getrennt'),(282,'Note: When using SMTP make sure the port number is open in your server','Hinweis: Wenn SMTP verwendet wird muss die Port Nummer auf dem Server offen sein'),(283,'Order Details','Bestelldetails'),(284,'Packages','Packages'),(285,'Pay On Delivery settings','Einstellungen Barzahlung'),(286,'Payment Gateway','Gateway Zahlungsarten'),(288,'Paypal','Paypal'),(289,'Paypal Password','Paypal Passwort'),(290,'Paypal Signature','Paypal Signatur'),(291,'Paypal User','Paypal Benutzer'),(292,'Percentage','Prozentsatz'),(294,'Redirect URL Must equal to','Redirect URL muss gleich sein mit'),(295,'Redirect Url','Umleitungs URL'),(296,'Reference #','Referenznummer'),(297,'Registration Status','Registrierungsstatus'),(298,'Reports','Berichte'),(299,'Reviews','Rezensionen'),(300,'SEO','SEO'),(302,'Sandbox','Sandbox'),(303,'Search Page','Suchseite'),(304,'Set this url to your google developer settings','URL für Google Entwickler Einstellungen'),(305,'Social Settings','Soziale Medien'),(308,'Subcategory List','Liste Unterkategorien'),(309,'Submit','Senden'),(310,'Subscriber List','Abonnenten Liste'),(311,'Subscription','Abonnements'),(312,'Subtotal','Zwischensumme'),(313,'Tax','MwSt.'),(314,'The status of the merchant after registration','Merchant Status nach Registrierung'),(315,'This email address will be use when sending email','Diese Email wird zum Versand von Mails verwendet'),(316,'This options enabled the customer to select his/her address from the map during checkout','Dies Option ermöglicht es dem Kunden seine Adresse  von der Karte auszuwählen'),(317,'Total','Gesamt'),(318,'Total Price','Gesamt Betrag'),(320,'Twitter Page URL','Twitter URL Seite'),(321,'User List','Benutzerliste'),(323,'Website','Webseite'),(324,'You can ask your hosting to open this for you','Bitte den Hosting Provider fragen um diese zu öffnen'),(325,'active','aktiv'),(326,'blocked','blockiert'),(327,'commission on orders','Provision auf Terminbuchung'),(328,'customer welcome email template','Kunden Willkommens Mail Vorlage'),(329,'expired','abgelaufen'),(330,'instagramm Page URL','Instagram URL'),(331,'leave empty to use standard decimal separators','Frei lassen um den Standard Dezimal Trenner zu verwenden'),(333,'merchant activation email template','Merchant Aktivierungsmail Vorlage'),(334,'merchant forgot password email template','Merchant Vorlage Passwort vergessen'),(335,'pending for approval','warten auf Bestätigung'),(336,'phpmail','phpmail'),(337,'pinterest Page URL','Pinterest URL'),(339,'smtp','smtp'),(340,'suspended','ausgesetzt'),(341,'{activation_key}','{activation_key}'),(342,'{client_name}','{client_name}'),(343,'{email_address}','{email_address}'),(344,'{merchant_name}','{merchant_name}'),(345,'{service_name}','{service_name}'),(346,'{verification_code}','{verification_code}'),(347,'{website_name}','{website_name}'),(348,'{website_title}','{website_title}'),(349,'{website_url}','{website_url}'),(350,'Addon','Zusatzleistung'),(351,'Administration info','Admin Information'),(352,'Customer reviews','Kundenrezensionen'),(353,'Gallery','Galerie'),(354,'Group Orders','Termine Gruppen'),(356,'Group Table Booking','Terminkalender Gruppe'),(357,'Loyalty Points','Treuepunkte'),(359,'Merchant Additional Info','weitere informationen'),(360,'Merchant Extra Schedule','Abwesenheitsplan'),(361,'Merchant Extra Schedule  History','Abwesenheitsplan Historie'),(362,'Merchant Main Info','Hauptinformation'),(363,'Merchant Schedule','tägliche Arbeitszeiten'),(364,'My Group Services','Gruppenservice'),(365,'My Single Services','Einzelserivce'),(366,'Orders','Termine'),(367,'PayPal settings','Paypal Einstellungen'),(369,'Schedule and Vacation History','Abwesenheiten Historie'),(370,'Social links','Soziale Medien'),(372,'Table Booking','Terminkalender'),(373,'Username and Passwords','Benutzername und Passwort'),(374,'Vouchers','Rabattcoupon'),(379,'Admin Users','Admin Benutzer'),(381,'Appointment made in the last 24 hours','Termine letzte 24 Stunden'),(395,'Clients','Kunden'),(404,'Create','Erstellen'),(405,'Custom Pages','Benutzerdefinierte Seiten'),(410,'Email Settings','Email Einstellungen'),(411,'Email Tpl','Email Vorlage'),(416,'Fields with {span} are required.','Felder mit {span} sind erforderlich.'),(428,'Manage','Verwalten'),(442,'Merchants','Händler'),(445,'Monthly Recap Report','Monatliche Zusammenfassung'),(447,'Most booked services','Meist gebucht'),(450,'New Merchants Today','Neue Händler heute'),(451,'Newsletters','Newsletter'),(453,'Order Statuses','Bestellstatus'),(454,'Out of','von'),(456,'Payment Providers','Zahlungsprovider '),(465,'Rating Meanings','Bewertung Bedeutung'),(470,'Report Payment','Zahlungsbericht'),(471,'Report Registration','Registrierungsstatistik'),(472,'Report Sales','Verkaufsstatistik'),(473,'Report Summary','Zusammenfassung Statistik'),(476,'Sales','Verkauf'),(480,'Service Categories','Service Kategorie'),(481,'Service Subcategories','Service Unterkategorien'),(482,'Services in {count} categories','Service in {count} Kategorien'),(484,'Settings','Einstellungen'),(493,'Total Appointments','Termine gesamt'),(494,'Total Merchants','Händler gesamt'),(498,'Update','Aktualisierung'),(504,'for last month','für den letzten Monat'),(512,'profile','Profil'),(526,'Additional Info','Zusätzliche Info'),(528,'Appointments for today','Termine heute'),(529,'Appointments made since you joined','Termine seit Beginn'),(530,'Before add photos to product gallery, you need to save product','Bevor Produktbilder hinzugefügt werden können, erst das Produkt speichern'),(531,'Call/Direct','Anruf/Direktbuchung'),(532,'Clear','Entfernen'),(533,'Create/Update Event','Termin erstellen/aktualisieren'),(534,'Create/Update Group Event','Gruppenservice erstellen/aktualisieren'),(535,'Delete','Löschen'),(536,'Extra Schedule','Extraplan'),(537,'Find staff','Mitarbeiter finden'),(538,'First photo in list will be main gallery photo.','Das erste Bild wird das Hauptbild in der Galerie'),(539,'Free Orders','Termine neu vergeben'),(541,'Group Order','Gruppentermin'),(543,'Group Service','Gruppenservice'),(544,'Group Services','Gruppenservices'),(545,'Important','Wichtig'),(546,'In-Store','Eigene Webseite'),(547,'Latest Orders','Letzte Terminbuchungen'),(548,'List','Liste'),(550,'Main Info','Hauptinfo'),(551,'Member since','Mitglied seit'),(552,'Members','aktiv'),(554,'Merchant History','Merchant Historie'),(555,'Merchant Module','Händler Admin'),(556,'Messages','Nachrichten'),(557,'More days','Mehr Tage'),(558,'On Spot','Im Geschäft'),(559,'Online','Portalbuchungen'),(563,'Payment settings','Zahlungseinstellungen'),(564,'Place New Order','Neuen Termin erstellen'),(566,'Recently Added Services','Kürzlich hinzugefügte Service'),(568,'Sales Graph','Verkaufsstatistik'),(569,'Save','Speichern'),(570,'Schedule','Plan'),(572,'Schedule Days Templates','Terminplan Tagesvorlage'),(574,'See All Messages','Alle Nachrichten'),(575,'Select','Auswählen'),(576,'Select Free Time','Zeit auswählen'),(577,'Select Service','Service auswählen'),(578,'Select Staff','Mitarbeiter wählen'),(579,'Sender Name','Name Absender'),(580,'Sign out','Abmelden'),(581,'Single Service','Einzelservice'),(582,'Single Services','Einzelservices'),(586,'Under count, we mean, how much points user get for each move','Angeben wieviele Punkte für jede Aktivität vergeben werden z.B. 5 für einen Termin, 2 für ein Facebook like etc.'),(588,'Vacations','Urlaub'),(589,'View All Orders','Alle Terminbuchungen anzeigen'),(590,'View All Services','Alle Services anzeigen'),(591,'View all','Alle anzeigen'),(592,'Warnings','Warnungen'),(593,'Week Day','Wochentag'),(594,'Week Schedule','Wochenplan'),(595,'You have {count} messages','Sie haben {count} Nachrichten'),(596,'You have {count} notifications','Sie haben {count} Hinweise'),(597,'no','nein'),(598,'points','Punkte'),(599,'search','suchen'),(600,'yes','ja'),(621,'Find Free Time Slots',''),(639,'Marketing Section',''),(650,'Merchant Section',''),(655,'New Order Canceled On Merchant',''),(656,'New Order Changed On Merchant',''),(657,'New Order Created On Frontend',''),(658,'New Order Created On Merchant',''),(680,'Schedule Section',''),(688,'Service Section',''),(695,'Staff Section',''),(698,'Time/Price',''),(716,'leave empty if you want to apply to all merchants',''),(721,'select date',''),(732,'Admin Settings',''),(733,'Admin User',''),(770,'Email Templates',''),(784,'Language',''),(812,'Newsletter',''),(816,'Order Status',''),(821,'Payment Provider',''),(831,'Rating Meaning',''),(844,'Sale Section',''),(849,'Service Category',''),(851,'Service Subcategory',''),(869,'Translation','');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
