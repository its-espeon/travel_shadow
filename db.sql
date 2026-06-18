/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.5.5-10.1.21-MariaDB : Database - travel_shadow
*********************************************************************
*/


/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`travel_shadow` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `travel_shadow`;

/*Table structure for table `booking` */

DROP TABLE IF EXISTS `booking`;

CREATE TABLE `booking` (
  `booking_id` int(30) NOT NULL AUTO_INCREMENT,
  `user_id` int(30) NOT NULL,
  `quantity` int(11) NOT NULL,
  `package_id` varchar(30) DEFAULT NULL,
  `booked_date` varchar(30) NOT NULL,
  `tour_date` varchar(30) NOT NULL,
  `total_amount` varchar(30) DEFAULT NULL,
  `status` varchar(20) NOT NULL,
  PRIMARY KEY (`booking_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

/*Data for the table `booking` */

insert  into `booking`(`booking_id`,`user_id`,`quantity`,`package_id`,`booked_date`,`tour_date`,`total_amount`,`status`) values (6,25,8,'7','2019-10-11 10:21:44','2019-10-18','1500','rejected'),(5,25,2,'7','2019-10-11 09:59:22','2019-10-17','1500','rejected'),(4,25,6,'7','2019-10-10 21:36:47','2019-10-24','1500','rejected'),(7,25,1,'7','2019-10-11 19:56:46','2019-10-03','1500','pending'),(8,25,4,'7','2019-10-14 10:31:41','2019-10-16','1500','rejected'),(9,25,2,'7','2019-10-14 11:16:14','2019-10-15','1500','rejected'),(10,25,3,'7','2019-10-14 11:32:28','2019-10-17','4500','pending'),(11,25,1,'7','2019-10-14 11:50:32','2019-10-13','1500','rejected'),(12,25,1,'7','2019-10-14 11:58:23','2019-10-25','1500','pending'),(13,24,4,'7','2019-10-14 13:11:25','2019-10-15','6000','pending');

/*Table structure for table `categories` */

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `category_id` int(30) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(30) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `categories` */

insert  into `categories`(`category_id`,`category_name`) values (1,'sea'),(2,'hill station'),(3,'water activity'),(4,'nature'),(5,'forest');

/*Table structure for table `complaint` */

DROP TABLE IF EXISTS `complaint`;

CREATE TABLE `complaint` (
  `complaint_id` int(30) NOT NULL AUTO_INCREMENT,
  `package_id` int(11) NOT NULL,
  `user_id` int(30) NOT NULL,
  `complaint_description` varchar(200) NOT NULL,
  `datetime` datetime NOT NULL,
  `reply_description` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`complaint_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `complaint` */

insert  into `complaint`(`complaint_id`,`package_id`,`user_id`,`complaint_description`,`datetime`,`reply_description`) values (8,7,25,'test','2019-10-11 10:05:32','pending');

/*Table structure for table `enquiry` */

DROP TABLE IF EXISTS `enquiry`;

CREATE TABLE `enquiry` (
  `enquiry_id` int(30) NOT NULL AUTO_INCREMENT,
  `user_id` int(30) NOT NULL,
  `package_id` int(30) NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `datetime` datetime NOT NULL,
  `reply` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`enquiry_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `enquiry` */

insert  into `enquiry`(`enquiry_id`,`user_id`,`package_id`,`description`,`datetime`,`reply`) values (4,25,7,'test','2019-10-11 09:56:45','test'),(5,25,7,'test','2019-10-11 19:06:14','pending');

/*Table structure for table `favourite` */

DROP TABLE IF EXISTS `favourite`;

CREATE TABLE `favourite` (
  `favourite_id` int(30) NOT NULL AUTO_INCREMENT,
  `package_id` int(30) NOT NULL,
  `user_id` int(30) NOT NULL,
  PRIMARY KEY (`favourite_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `favourite` */

insert  into `favourite`(`favourite_id`,`package_id`,`user_id`) values (3,7,25),(4,7,24);

/*Table structure for table `feedback` */

DROP TABLE IF EXISTS `feedback`;

CREATE TABLE `feedback` (
  `user_id` int(11) NOT NULL,
  `review_id` int(20) NOT NULL AUTO_INCREMENT,
  `description` varchar(250) DEFAULT NULL,
  `rating` varchar(30) DEFAULT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`review_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `feedback` */

/*Table structure for table `images` */

DROP TABLE IF EXISTS `images`;

CREATE TABLE `images` (
  `image_id` int(11) NOT NULL AUTO_INCREMENT,
  `package_id` int(11) NOT NULL,
  `image_path` varchar(500) NOT NULL,
  PRIMARY KEY (`image_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

/*Data for the table `images` */

insert  into `images`(`image_id`,`package_id`,`image_path`) values (12,7,'products/5d9f55b4e4b51.jpg');

/*Table structure for table `login` */

DROP TABLE IF EXISTS `login`;

CREATE TABLE `login` (
  `log_id` int(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(500) NOT NULL,
  `type` varchar(30) DEFAULT NULL,
  `login_status` varchar(20) NOT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

/*Data for the table `login` */

insert  into `login`(`log_id`,`username`,`password`,`type`,`login_status`) values (24,'al','al','user','active'),(22,'admin','admin','admin','active'),(20,'travelista','travelista','tour_providers','active'),(25,'akshay','akshay','user','active');

/*Table structure for table `packages` */

DROP TABLE IF EXISTS `packages`;

CREATE TABLE `packages` (
  `package_id` int(30) NOT NULL AUTO_INCREMENT,
  `tour_provider_id` int(30) NOT NULL,
  `package_title` varchar(30) NOT NULL,
  `package_image` varchar(500) DEFAULT NULL,
  `places_included` varchar(30) NOT NULL,
  `category_id` int(30) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `amount` varchar(30) DEFAULT NULL,
  `status` varchar(20) NOT NULL,
  PRIMARY KEY (`package_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `packages` */

insert  into `packages`(`package_id`,`tour_provider_id`,`package_title`,`package_image`,`places_included`,`category_id`,`description`,`amount`,`status`) values (7,3,'Top station','products/5d5f8d4ae760f.jpg','munnar',2,'munnar contain many top stations','1500','active');

/*Table structure for table `payment` */

DROP TABLE IF EXISTS `payment`;

CREATE TABLE `payment` (
  `payment_id` int(30) NOT NULL AUTO_INCREMENT,
  `booking_id` int(30) NOT NULL,
  `amount` varchar(30) DEFAULT NULL,
  `user_id` int(30) NOT NULL,
  `datetime` datetime NOT NULL,
  PRIMARY KEY (`payment_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `payment` */

insert  into `payment`(`payment_id`,`booking_id`,`amount`,`user_id`,`datetime`) values (6,9,'3000',25,'2019-10-14 11:16:47'),(5,5,'3000',25,'2019-10-11 10:00:46'),(4,4,'9000',25,'2019-10-10 21:38:00'),(7,10,'4500',25,'2019-10-14 11:33:55');

/*Table structure for table `places` */

DROP TABLE IF EXISTS `places`;

CREATE TABLE `places` (
  `place_id` int(30) NOT NULL AUTO_INCREMENT,
  `place_name` varchar(30) NOT NULL,
  `place_image` varchar(5000) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `latitude` varchar(30) NOT NULL,
  `longitude` varchar(30) NOT NULL,
  PRIMARY KEY (`place_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

/*Data for the table `places` */

insert  into `places`(`place_id`,`place_name`,`place_image`,`description`,`latitude`,`longitude`) values (13,'angamaly','products/5da003535f3bd.jpg','angamaly','10.1926','76.3869'),(12,'Munnar','products/5d9f4aa147420.jpg','Munnar is a town in the Western Ghats mountain range in Kerala state.','10.0889','77.0595');

/*Table structure for table `tour_providers` */

DROP TABLE IF EXISTS `tour_providers`;

CREATE TABLE `tour_providers` (
  `tour_provider_id` int(30) NOT NULL AUTO_INCREMENT,
  `login_id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `place` varchar(30) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `about` varchar(100) DEFAULT NULL,
  `status` varchar(20) NOT NULL,
  PRIMARY KEY (`tour_provider_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `tour_providers` */

insert  into `tour_providers`(`tour_provider_id`,`login_id`,`name`,`place`,`email`,`phone`,`about`,`status`) values (3,20,'Travelista','Ernakulam','travelista@gmail.com','1234567890','good facility,quality plans','active');

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `user_id` int(30) NOT NULL AUTO_INCREMENT,
  `login_id` int(11) DEFAULT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `house_name` varchar(30) DEFAULT NULL,
  `place` varchar(30) DEFAULT NULL,
  `district` varchar(30) DEFAULT NULL,
  `pincode` varchar(30) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `phone` varchar(30) NOT NULL,
  `gender` varchar(30) NOT NULL,
  `date_of_birth` varchar(30) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `user` */

insert  into `user`(`user_id`,`login_id`,`first_name`,`last_name`,`house_name`,`place`,`district`,`pincode`,`email`,`phone`,`gender`,`date_of_birth`) values (3,10,'albert','jose','maliyekal koonan','melur','thrissur','680311','albertjose649@gmail.com','8606295034','male','2000-06-29'),(6,25,'Akshay','Santhosh','Nangelil','Pulluvazhy','Ernakulam','683541','akshaysanthosh005@gmail.com','7558829195','on','1999-02-02');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
