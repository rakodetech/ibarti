/*
Navicat MySQL Data Transfer

Source Server         : IBARTI
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : ib2_oesvica

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2019-05-23 09:15:01
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for nov_check_list_trab
-- ----------------------------
DROP TABLE IF EXISTS `nov_check_list_trab`;
CREATE TABLE `nov_check_list_trab` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Código principal del check list',
  `hora` time NOT NULL,
  `cod_nov_clasif` varchar(11) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Clasificacion de novedad',
  `cod_nov_tipo` varchar(11) COLLATE utf8_spanish_ci NOT NULL DEFAULT '9999',
  `cod_ficha` varchar(17) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Código de ficha',
  `cedula` varchar(11) COLLATE utf8_spanish_ci NOT NULL,
  `observacion` text COLLATE utf8_spanish_ci NOT NULL COMMENT 'Observación del proceso',
  `repuesta` text COLLATE utf8_spanish_ci COMMENT 'Respuesta del proceso',
  `campo01` varchar(60) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'campo adicional 1',
  `campo02` varchar(60) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'campo adicional 2',
  `campo03` varchar(60) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'campo adicional 3',
  `campo04` varchar(60) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'campo adicional 4',
  `cod_us_ing` varchar(11) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Código del usuario que ingresó',
  `fec_us_ing` date DEFAULT NULL COMMENT 'Fecha del usuario que ingresó',
  `cod_us_mod` varchar(11) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Código del usuario que ingresó',
  `fec_us_mod` date DEFAULT NULL COMMENT 'Fecha del usuario que ingresó',
  `cod_nov_status` varchar(11) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Código de esatus de novedad',
  PRIMARY KEY (`codigo`),
  KEY `FK_nov_cl_ficha` (`cod_ficha`) USING BTREE,
  KEY `FK_nov_cl_status` (`cod_nov_status`) USING BTREE,
  KEY `FK_nov_cl_tipo` (`cod_nov_tipo`) USING BTREE,
  KEY `IND_nov_cl_fecha` (`fec_us_ing`) USING BTREE,
  KEY `KU_nov_cl` (`cod_nov_clasif`,`cod_ficha`,`fec_us_ing`,`cod_nov_tipo`,`cod_us_ing`) USING BTREE,
  CONSTRAINT `nov_check_list_trab_ibfk_2` FOREIGN KEY (`cod_nov_clasif`) REFERENCES `nov_clasif` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `nov_check_list_trab_ibfk_3` FOREIGN KEY (`cod_ficha`) REFERENCES `ficha` (`cod_ficha`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `nov_check_list_trab_ibfk_4` FOREIGN KEY (`cod_nov_status`) REFERENCES `nov_status` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `nov_check_list_trab_ibfk_5` FOREIGN KEY (`cod_nov_tipo`) REFERENCES `nov_tipo` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Cabezera de Check List (Modulo Novedades)';
