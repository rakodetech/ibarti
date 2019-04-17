/*
Navicat MySQL Data Transfer

Source Server         : IBARTI
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : ib2_oesvica

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2019-04-17 10:56:27
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for clientes_contactos
-- ----------------------------
DROP TABLE IF EXISTS `clientes_contactos`;
CREATE TABLE `clientes_contactos` (
  `documento` varchar(11) COLLATE utf8_spanish_ci NOT NULL,
  `cod_cliente` varchar(11) COLLATE utf8_spanish_ci NOT NULL,
  `nombres` varchar(60) COLLATE utf8_spanish_ci DEFAULT NULL,
  `cargo` varchar(60) COLLATE utf8_spanish_ci DEFAULT NULL,
  `telefono` varchar(60) COLLATE utf8_spanish_ci DEFAULT NULL,
  `correo` varchar(60) COLLATE utf8_spanish_ci DEFAULT NULL,
  `observacion` varchar(60) COLLATE utf8_spanish_ci DEFAULT NULL,
  KEY `cod_cliente` (`cod_cliente`),
  CONSTRAINT `clientes_contactos_ibfk_1` FOREIGN KEY (`cod_cliente`) REFERENCES `clientes` (`codigo`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

DELETE FROM clientes_contactos;
INSERT INTO clientes_contactos (

clientes_contactos.cod_cliente,
clientes_contactos.nombres,


clientes_contactos.correo,
clientes_contactos.observacion,
clientes_contactos.telefono
)
SELECT clientes.codigo,clientes.contacto,clientes.email,clientes.observacion,clientes.telefono
FROM clientes
