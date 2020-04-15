/*
Navicat MySQL Data Transfer

Source Server         : LOCAL
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : ib_oesvica

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2020-04-15 11:37:27
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for experiencias
-- ----------------------------
DROP TABLE IF EXISTS `experiencias`;
CREATE TABLE `experiencias` (
  `codigo` varchar(11) COLLATE utf8mb4_spanish_ci NOT NULL,
  `descripcion` varchar(100) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `campo01` varchar(60) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `campo02` varchar(60) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `campo03` varchar(60) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `campo04` varchar(60) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `cod_us_ing` varchar(11) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `fec_us_ing` datetime DEFAULT NULL,
  `cod_us_mod` varchar(60) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `fec_us_mod` datetime DEFAULT NULL,
  `status` varchar(1) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT 'F' COMMENT 'Estatus.Indica si esta activo o inactivo el registro',
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
