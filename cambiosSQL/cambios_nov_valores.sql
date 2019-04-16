/*
Navicat MySQL Data Transfer

Source Server         : IBARTI
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : ib2_oesvica

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2019-04-16 11:03:52
*/

SET FOREIGN_KEY_CHECKS=0;
ALTER TABLE `nov_valores`
ADD COLUMN `cod_clasif_val`  varchar(11) NULL DEFAULT '00' AFTER `descripcion`;

-- ----------------------------
-- Table structure for nov_valores_clasif
-- ----------------------------
DROP TABLE IF EXISTS `nov_valores_clasif`;
CREATE TABLE `nov_valores_clasif` (
  `codigo` varchar(11) COLLATE utf8_spanish_ci NOT NULL DEFAULT '' COMMENT 'Código principal de la tabla nov_valores_clasif',
  `descripcion` varchar(60) COLLATE utf8_spanish_ci NOT NULL DEFAULT '' COMMENT 'Descripción de la clasificación',
  `campo01` varchar(60) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Campo adicional 01',
  `campo02` varchar(60) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Campo adicional 02',
  `campo03` varchar(60) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Campo adicional 03',
  `campo04` varchar(60) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Campo adicional 04',
  `cod_us_ing` varchar(11) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Código del usuario que ingresó',
  `fec_us_ing` date DEFAULT NULL COMMENT 'Fecha del usuario que ingresó',
  `cod_us_mod` varchar(11) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Código del usuario que modificó',
  `fec_us_mod` date DEFAULT NULL COMMENT 'Código del usuario que modificó',
  `status` varchar(1) COLLATE utf8_spanish_ci DEFAULT 'F' COMMENT 'Estatus.Indica si esta activo o inactivo el registro',
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
