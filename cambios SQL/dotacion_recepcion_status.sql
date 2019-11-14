/*
Navicat MySQL Data Transfer

Source Server         : IBARTI
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : ib2_oesvica_nueva

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2019-07-09 10:10:38
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for dotacion_recepcion_status
-- ----------------------------
DROP TABLE IF EXISTS `dotacion_recepcion_status`;
CREATE TABLE `dotacion_recepcion_status` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `cod_dotacion` int(11) NOT NULL,
  `cod_recepcion` int(11) unsigned NOT NULL,
  `cod_us_ing` varchar(11) COLLATE utf8_spanish_ci NOT NULL,
  `fecha` date NOT NULL,
  `cod_status` varchar(11) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`codigo`),
  KEY `FK_status_rec` (`cod_status`),
  KEY `FK_dot_rec` (`cod_recepcion`),
  KEY `FK_dot_rec_dot` (`cod_dotacion`),
  CONSTRAINT `FK_dot_rec` FOREIGN KEY (`cod_recepcion`) REFERENCES `dotacion_recepcion` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_dot_rec_dot` FOREIGN KEY (`cod_dotacion`) REFERENCES `prod_dotacion` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_status_rec` FOREIGN KEY (`cod_status`) REFERENCES `dotacion_status` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
