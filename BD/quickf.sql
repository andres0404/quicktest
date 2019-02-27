/*
SQLyog Community v13.1.1 (64 bit)
MySQL - 5.7.23 : Database - quickf
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`quickf` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `quickf`;

/*Table structure for table `clientes` */

DROP TABLE IF EXISTS `clientes`;

CREATE TABLE `clientes` (
  `cli_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cli_nombre` varchar(100) DEFAULT NULL,
  `cli_email` varchar(50) DEFAULT NULL,
  `cli_documento` bigint(20) DEFAULT NULL,
  `cli_estado` smallint(5) unsigned DEFAULT '1',
  PRIMARY KEY (`cli_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `clientes` */

insert  into `clientes`(`cli_id`,`cli_nombre`,`cli_email`,`cli_documento`,`cli_estado`) values 
(1,'Satena S.A.','satenainfo@satena.com',8545545,1),
(4,'pedrito buitrago','pedrito@buitrago.com',8898787,1),
(6,'Andres silva','andres.silva@gmail.com',166696667,1);

/*Table structure for table `factura_items` */

DROP TABLE IF EXISTS `factura_items`;

CREATE TABLE `factura_items` (
  `facitm_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fac_id` bigint(20) unsigned NOT NULL,
  `prod_id` bigint(20) unsigned NOT NULL,
  `itm_cantidad` bigint(20) NOT NULL,
  `itm_total` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`facitm_id`),
  KEY `REL_ITEM_FACTURA` (`fac_id`),
  KEY `REL_PROD_FACTURA` (`prod_id`),
  CONSTRAINT `REL_ITEM_FACTURA` FOREIGN KEY (`fac_id`) REFERENCES `facturas` (`fac_id`) ON DELETE CASCADE,
  CONSTRAINT `REL_PROD_FACTURA` FOREIGN KEY (`prod_id`) REFERENCES `productos` (`prod_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Data for the table `factura_items` */

insert  into `factura_items`(`facitm_id`,`fac_id`,`prod_id`,`itm_cantidad`,`itm_total`) values 
(1,1,2,2,5000),
(2,1,1,1,2000),
(3,2,2,3,70000),
(5,4,1,5,22500),
(6,4,1,5,22500);

/*Table structure for table `facturas` */

DROP TABLE IF EXISTS `facturas`;

CREATE TABLE `facturas` (
  `fac_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cli_id` bigint(20) unsigned NOT NULL,
  `fac_fecha_generacion` date NOT NULL,
  `fac_fecha_vence` date NOT NULL,
  `fac_estado` smallint(5) unsigned DEFAULT '1',
  `fac_total` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`fac_id`),
  KEY `REL_FACTURA_CLIENTE` (`cli_id`),
  CONSTRAINT `REL_FACTURA_CLIENTE` FOREIGN KEY (`cli_id`) REFERENCES `clientes` (`cli_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `facturas` */

insert  into `facturas`(`fac_id`,`cli_id`,`fac_fecha_generacion`,`fac_fecha_vence`,`fac_estado`,`fac_total`) values 
(1,4,'2019-02-25','2019-03-01',1,40100),
(2,1,'2019-02-18','2019-03-02',1,50000),
(4,4,'2019-02-26','2019-03-02',1,98400);

/*Table structure for table `m_contenido` */

DROP TABLE IF EXISTS `m_contenido`;

CREATE TABLE `m_contenido` (
  `mcon_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `mtabla_id` bigint(20) unsigned DEFAULT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `valor` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`mcon_id`),
  KEY `REL_MTABLA_MCONTENIDO` (`mtabla_id`),
  CONSTRAINT `REL_MTABLA_MCONTENIDO` FOREIGN KEY (`mtabla_id`) REFERENCES `m_contenido` (`mcon_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `m_contenido` */

insert  into `m_contenido`(`mcon_id`,`mtabla_id`,`nombre`,`valor`) values 
(1,1,'1','GENERADA'),
(2,1,'2','PAGADA'),
(3,1,'3','EN CARTERA');

/*Table structure for table `m_tablas` */

DROP TABLE IF EXISTS `m_tablas`;

CREATE TABLE `m_tablas` (
  `mtabla_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_tabla` varchar(100) DEFAULT NULL,
  `estado` smallint(6) DEFAULT '1',
  PRIMARY KEY (`mtabla_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `m_tablas` */

insert  into `m_tablas`(`mtabla_id`,`nombre_tabla`,`estado`) values 
(1,'ESTADOS FACTURA',1);

/*Table structure for table `productos` */

DROP TABLE IF EXISTS `productos`;

CREATE TABLE `productos` (
  `prod_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `prod_nombre` varchar(100) DEFAULT NULL,
  `prod_precio` bigint(20) unsigned DEFAULT NULL,
  `prod_marca` varchar(60) DEFAULT NULL,
  `prod_referencia` bigint(20) unsigned DEFAULT NULL,
  `prod_estado` smallint(5) unsigned DEFAULT NULL,
  PRIMARY KEY (`prod_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `productos` */

insert  into `productos`(`prod_id`,`prod_nombre`,`prod_precio`,`prod_marca`,`prod_referencia`,`prod_estado`) values 
(1,'producto 1',4500,NULL,111111,1),
(2,'Cable de datos blindado',17800,'samsung',8898789,1),
(4,'Calcomania DC',6000,'DC',55888,1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
