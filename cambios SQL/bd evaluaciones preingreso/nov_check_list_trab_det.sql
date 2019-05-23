/*
Navicat MySQL Data Transfer

Source Server         : IBARTI
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : ib2_oesvica

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2019-05-23 09:15:10
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for nov_check_list_trab_det
-- ----------------------------
DROP TABLE IF EXISTS `nov_check_list_trab_det`;
CREATE TABLE `nov_check_list_trab_det` (
  `cod_check_list` int(11) NOT NULL COMMENT 'Código Foraneo de check list',
  `cod_novedades` varchar(11) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Novedades',
  `cod_valor` varchar(11) COLLATE utf8_spanish_ci NOT NULL COMMENT 'valor T, F o(Si o NO)',
  `valor` int(3) NOT NULL DEFAULT '0',
  `valor_max` int(3) NOT NULL DEFAULT '0' COMMENT 'Valor Maximo',
  `observacion` text COLLATE utf8_spanish_ci NOT NULL COMMENT 'Observacion de Check List',
  UNIQUE KEY `KU_nov_cl_det` (`cod_check_list`,`cod_novedades`) USING BTREE,
  KEY `FK_nov_check_list` (`cod_check_list`) USING BTREE,
  KEY `FK_nov_cl_novedades` (`cod_novedades`) USING BTREE,
  KEY `FK_cod_nov_valores` (`cod_valor`) USING BTREE,
  CONSTRAINT `nov_check_list_trab_det_ibfk_1` FOREIGN KEY (`cod_valor`) REFERENCES `nov_valores` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `nov_check_list_trab_det_ibfk_2` FOREIGN KEY (`cod_check_list`) REFERENCES `nov_check_list_trab` (`codigo`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `nov_check_list_trab_det_ibfk_3` FOREIGN KEY (`cod_novedades`) REFERENCES `novedades` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Detalle de Check List';
