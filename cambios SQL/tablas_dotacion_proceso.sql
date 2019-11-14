
SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for dotacion_status
-- ----------------------------
DROP TABLE IF EXISTS `dotacion_status`;
CREATE TABLE `dotacion_status` (
  `codigo` varchar(11) COLLATE utf8_spanish_ci NOT NULL,
  `abr` varchar(5) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `status` varchar(1) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'T',
  `cod_us_ing` varchar(11) COLLATE utf8_spanish_ci NOT NULL,
  `fec_us_ing` date NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for dotacion_proceso
-- ----------------------------
DROP TABLE IF EXISTS `dotacion_proceso`;
CREATE TABLE `dotacion_proceso` (
  `codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cod_us_ing` varchar(11) COLLATE utf8_spanish_ci NOT NULL,
  `fec_us_ing` date NOT NULL,
  `cod_us_mod` varchar(11) COLLATE utf8_spanish_ci NOT NULL,
  `fec_us_mod` date NOT NULL,
  `status` varchar(11) COLLATE utf8_spanish_ci NOT NULL,
  `anulado` varchar(1) COLLATE utf8_spanish_ci NOT NULL,
  `observacion` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`codigo`),
  KEY `FK_status` (`status`),
  CONSTRAINT `FK_status` FOREIGN KEY (`status`) REFERENCES `dotacion_status` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for dotacion_recepcion
-- ----------------------------
DROP TABLE IF EXISTS `dotacion_recepcion`;
CREATE TABLE `dotacion_recepcion` (
  `codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cod_us_ing` varchar(11) COLLATE utf8_spanish_ci NOT NULL,
  `fec_us_ing` date NOT NULL,
  `cod_us_mod` varchar(11) COLLATE utf8_spanish_ci NOT NULL,
  `fec_us_mod` date NOT NULL,
  `status` varchar(11) COLLATE utf8_spanish_ci NOT NULL,
  `anulado` varchar(1) COLLATE utf8_spanish_ci NOT NULL,
  `observacion` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`codigo`),
  KEY `FK_stat` (`status`),
  CONSTRAINT `FK_stat` FOREIGN KEY (`status`) REFERENCES `dotacion_status` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;



SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for dotacion_proceso_det
-- ----------------------------
DROP TABLE IF EXISTS `dotacion_proceso_det`;
CREATE TABLE `dotacion_proceso_det` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `cod_dotacion_proceso` int(11) unsigned NOT NULL,
  `cod_dotacion` int(11) NOT NULL,
  `status` varchar(11) COLLATE utf8_spanish_ci NOT NULL,
  `fec_us_ing` date NOT NULL,
  `cod_us_ing` varchar(11) COLLATE utf8_spanish_ci NOT NULL,
  `fec_us_mod` date NOT NULL,
  `cod_us_mod` varchar(11) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`codigo`),
  KEY `FK_status_dpd` (`status`),
  KEY `FK_dotacion` (`cod_dotacion`),
  KEY `FK_proceso` (`cod_dotacion_proceso`),
  CONSTRAINT `FK_dotacion` FOREIGN KEY (`cod_dotacion`) REFERENCES `prod_dotacion` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_proceso` FOREIGN KEY (`cod_dotacion_proceso`) REFERENCES `dotacion_proceso` (`codigo`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `FK_status_dpd` FOREIGN KEY (`status`) REFERENCES `dotacion_status` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;



SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for dotacion_recepcion_det
-- ----------------------------
DROP TABLE IF EXISTS `dotacion_recepcion_det`;
CREATE TABLE `dotacion_recepcion_det` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `cod_dotacion_proceso` int(11) unsigned NOT NULL,
  `cod_dotacion_recepcion` int(11) unsigned NOT NULL,
  `cod_dotacion` int(11) NOT NULL,
  `status` varchar(11) COLLATE utf8_spanish_ci NOT NULL,
  `fec_us_ing` date NOT NULL,
  `cod_us_ing` varchar(11) COLLATE utf8_spanish_ci NOT NULL,
  `fec_us_mod` date NOT NULL,
  `cod_us_mod` varchar(11) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`codigo`),
  KEY `FK_status_drd` (`status`),
  KEY `FK_dotacion_r` (`cod_dotacion`),
  KEY `FK_proceso_r` (`cod_dotacion_proceso`),
  KEY `FK_recepcion` (`cod_dotacion_recepcion`),
  CONSTRAINT `FK_dotacion_r` FOREIGN KEY (`cod_dotacion`) REFERENCES `prod_dotacion` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_proceso_r` FOREIGN KEY (`cod_dotacion_proceso`) REFERENCES `dotacion_proceso` (`codigo`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `FK_recepcion` FOREIGN KEY (`cod_dotacion_recepcion`) REFERENCES `dotacion_recepcion` (`codigo`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `FK_status_drd` FOREIGN KEY (`status`) REFERENCES `dotacion_status` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


INSERT INTO `dotacion_status` VALUES ('01', 'IN', 'INICIADO', 'T', '9999', '2019-06-21');
INSERT INTO `dotacion_status` VALUES ('02', 'EP', 'EN PROCESO', 'T', '9999', '2019-06-21');
INSERT INTO `dotacion_status` VALUES ('03', 'P', 'PROCESADO', 'T', '9999', '2019-06-21');
INSERT INTO `dotacion_status` VALUES ('04', 'P.O', 'PENDIENTE POR OPERACIONES', 'T', '9999', '2019-06-21');
INSERT INTO `dotacion_status` VALUES ('05', 'R.O', 'RECIBIDO POR OPERACIONES', 'T', '9999', '2019-06-21');
INSERT INTO `dotacion_status` VALUES ('06', 'P.A', 'PENDIENTE POR ALMACEN', 'T', '9999', '2019-06-21');
INSERT INTO `dotacion_status` VALUES ('07', 'R.A', 'RECIBIDO POR ALMACEN', 'T', '9999', '2019-06-21');
INSERT INTO `dotacion_status` VALUES ('08', 'AN', 'ANULADO', 'T', '9999', '2019-06-21');
INSERT INTO `dotacion_status` VALUES ('09', 'F', 'FINALIZADO', 'T', '9999', '2019-07-02');
INSERT INTO `dotacion_status` VALUES ('9999', 'G', 'GENERAL', 'T', '9999', '2019-06-20');
