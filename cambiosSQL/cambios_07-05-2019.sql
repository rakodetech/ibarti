/*
Navicat MySQL Data Transfer

Source Server         : IBARTI
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : ib2_oesvica

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2019-05-07 10:00:21
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for acciones
-- ----------------------------
DROP TABLE IF EXISTS `acciones`;
CREATE TABLE `acciones` (
  `codigo` varchar(11) COLLATE utf8_spanish_ci NOT NULL DEFAULT '' COMMENT 'Código principal de la tabla acciones',
  `descripcion` varchar(60) COLLATE utf8_spanish_ci NOT NULL DEFAULT '' COMMENT 'Descripción de la accion',
  `campo01` varchar(60) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Campo adicional 01',
  `campo02` varchar(60) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Campo adicional 02',
  `campo03` varchar(60) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Campo adicional 03',
  `campo04` varchar(60) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Campo adicional 04',
  `cod_us_ing` varchar(11) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Código del usuario que ingresó',
  `fec_us_ing` date DEFAULT NULL COMMENT 'Fecha del usuario que ingresó',
  `cod_us_mod` varchar(11) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Código del usuario que ingresó',
  `fec_us_mod` date DEFAULT NULL COMMENT 'Fecha del usuario que modificó',
  `status` varchar(1) COLLATE utf8_spanish_ci DEFAULT 'F' COMMENT 'Estatus.Indica si esta activo o inactivo el registro',
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Información sobre las lineas que se disponen para productos';

-- ----------------------------
-- Records of acciones
-- ----------------------------
INSERT INTO `acciones` VALUES ('01', 'act_ficha', null, null, null, null, '9999', '2019-05-06', '9999', '2019-05-06', 'T');



DROP TRIGGER IF EXISTS `trig_audit`;
DELIMITER ;;
CREATE TRIGGER `trig_audit` AFTER UPDATE ON `ficha` FOR EACH ROW BEGIN
	DECLARE
		ultimo INTEGER;
DECLARE vieja VARCHAR
(255);
DECLARE nueva VARCHAR
(255);


INSERT INTO audit_ficha
	(
	cod_us_ing,
	cod_ficha,
	fecha,
	hora,
                  cod_accion
	)
VALUES
	(
		NEW.cod_us_mod,
		NEW.cod_ficha,
		DATE_FORMAT(NOW(), "%Y-%m-%d"),
		DATE_FORMAT(NOW(), "%T"),
                                      '01'
	);


SELECT
	IFNULL(MAX(audit_ficha.codigo), 0)
INTO ultimo
FROM
	audit_ficha
LIMIT
1;


IF (OLD.cedula <> NEW.cedula) THEN
INSERT INTO audit_ficha_det
	(
	cod_audit,
	campo,
	valor_ant,
	valor_new
	)
VALUES
	(
		ultimo,
		'CEDULA',
		OLD.cedula,
		NEW.cedula
	);


END
IF;


IF (
	OLD.cod_nacionalidad <> NEW.cod_nacionalidad
) THEN

SELECT
	nacionalidad.descripcion
INTO vieja
FROM
	nacionalidad
WHERE
                  nacionalidad.codigo = OLD.cod_nacionalidad
LIMIT 1;


SELECT
	nacionalidad.descripcion
INTO nueva
FROM
	nacionalidad
WHERE
                  nacionalidad.codigo = NEW.cod_nacionalidad
LIMIT 1;

INSERT INTO audit_ficha_det
	(
	cod_audit,
	campo,
	valor_ant,
	valor_new
	)
VALUES
	(
		ultimo,
		'NACIONALIDAD',
		vieja,
		nueva
	);


END
IF;


IF (
	OLD.cod_estado_civil <> NEW.cod_estado_civil
) THEN

SELECT
	estado_civil.descripcion
INTO vieja
FROM
	estado_civil
WHERE
                  estado_civil.codigo = OLD.cod_estado_civil
LIMIT 1;

SELECT
	estado_civil.descripcion
INTO nueva
FROM
	estado_civil
WHERE
                  estado_civil.codigo = NEW.cod_estado_civil
LIMIT 1;

INSERT INTO audit_ficha_det
	(
	cod_audit,
	campo,
	valor_ant,
	valor_new
	)
VALUES
	(
		ultimo,
		'ESTADO CIVIL',
		vieja,
		nueva
	);


END
IF;


IF (
	OLD.cod_cargo <> NEW.cod_cargo
) THEN

SELECT
	cargos.descripcion
INTO vieja
FROM
	cargos
WHERE
                  cargos.codigo = OLD.cod_cargo
LIMIT 1;

SELECT
	cargos.descripcion
INTO nueva
FROM
	cargos
WHERE
                  cargos.codigo = NEW.cod_cargo
LIMIT 1;

INSERT INTO audit_ficha_det
	(
	cod_audit,
	campo,
	valor_ant,
	valor_new
	)
VALUES
	(
		ultimo,
		'CARGO',
		vieja,
		nueva
	);


END
IF;


IF (
	OLD.cod_ocupacion <> NEW.cod_ocupacion
) THEN

SELECT
	ocupacion.descripcion
INTO vieja
FROM
	ocupacion
WHERE
                  ocupacion.codigo = OLD.cod_ocupacion
LIMIT 1;

SELECT
	ocupacion.descripcion
INTO nueva
FROM
	ocupacion
WHERE
                  ocupacion.codigo = NEW.cod_ocupacion
LIMIT 1;


INSERT INTO audit_ficha_det
	(
	cod_audit,
	campo,
	valor_ant,
	valor_new
	)
VALUES
	(
		ultimo,
		'OCUPACION',
		vieja,
		nueva
	);


END
IF;


IF (
	OLD.cod_estado <> NEW.cod_estado
) THEN

SELECT
	estados.descripcion
INTO vieja
FROM
	estados
WHERE
                  estados.codigo = OLD.cod_estado
LIMIT 1;

SELECT
	estados.descripcion
INTO nueva
FROM
	estados
WHERE
                  estados.codigo = NEW.cod_estado
LIMIT 1;

INSERT INTO audit_ficha_det
	(
	cod_audit,
	campo,
	valor_ant,
	valor_new
	)
VALUES
	(
		ultimo,
		'ESTADO',
		vieja,
		nueva
	);


END
IF;


IF (
	OLD.cod_ciudad <> NEW.cod_ciudad
) THEN


SELECT
	ciudades.descripcion
INTO vieja
FROM
	ciudades
WHERE
                  ciudades.codigo = OLD.cod_ciudad
LIMIT 1;

SELECT
	ciudades.descripcion
INTO nueva
FROM
	ciudades
WHERE
                  ciudades.codigo = NEW.cod_ciudad
LIMIT 1;

INSERT INTO audit_ficha_det
	(
	cod_audit,
	campo,
	valor_ant,
	valor_new
	)
VALUES
	(
		ultimo,
		'CIUDAD',
		vieja,
		nueva
	);


END
IF;


IF (
	OLD.cod_nivel_academico <> NEW.cod_nivel_academico
) THEN

SELECT
	nivel_academico.descripcion
INTO vieja
FROM
	nivel_academico
WHERE
                  nivel_academico.codigo = OLD.cod_nivel_academico
LIMIT 1;

SELECT
	nivel_academico.descripcion
INTO nueva
FROM
	nivel_academico
WHERE
                  nivel_academico.codigo = NEW.cod_nivel_academico
LIMIT 1;


INSERT INTO audit_ficha_det
	(
	cod_audit,
	campo,
	valor_ant,
	valor_new
	)
VALUES
	(
		ultimo,
		'NIVEL ACADEMICO',
		vieja,
		nueva
	);


END
IF;


IF (
	OLD.cod_t_pantalon <> NEW.cod_t_pantalon
) THEN

SELECT
	preing_pantalon.descripcion
INTO vieja
FROM
	preing_pantalon
WHERE
                  preing_pantalon.codigo = OLD.cod_t_pantalon
LIMIT 1;

SELECT
	preing_pantalon.descripcion
INTO nueva
FROM
	preing_pantalon
WHERE
                  preing_pantalon.codigo = NEW.cod_t_pantalon
LIMIT 1;

INSERT INTO audit_ficha_det
	(
	cod_audit,
	campo,
	valor_ant,
	valor_new
	)
VALUES
	(
		ultimo,
		'TALLA PANTALON',
		vieja,
		nueva
	);


END
IF;

IF (
	OLD.cod_t_camisas <> NEW.cod_t_camisas
) THEN

SELECT
	preing_camisas.descripcion
INTO vieja
FROM
	preing_camisas
WHERE
                  preing_camisas.codigo = OLD.cod_t_camisas
LIMIT 1;

SELECT
	preing_camisas.descripcion
INTO nueva
FROM
	preing_camisas
WHERE
                  preing_camisas.codigo = NEW.cod_t_camisas
LIMIT 1;


INSERT INTO audit_ficha_det
	(
	cod_audit,
	campo,
	valor_ant,
	valor_new
	)
VALUES
	(
		ultimo,
		'TALLA CAMISA',
		vieja,
		nueva
	);


END
IF;


IF (
	OLD.cod_n_zapatos <> NEW.cod_n_zapatos
) THEN

SELECT
	preing_zapatos.descripcion
INTO vieja
FROM
	preing_zapatos
WHERE
                  preing_zapatos.codigo = OLD.cod_n_zapatos
LIMIT 1;

SELECT
	preing_zapatos.descripcion
INTO nueva
FROM
	preing_zapatos
WHERE
                  preing_zapatos.codigo = NEW.cod_n_zapatos
LIMIT 1;

INSERT INTO audit_ficha_det
	(
	cod_audit,
	campo,
	valor_ant,
	valor_new
	)
VALUES
	(
		ultimo,
		'TALLA ZAPATOS',
		vieja,
		nueva
	);


END
IF;


IF (
	OLD.cod_contracto <> NEW.cod_contracto
) THEN

SELECT
	contractos.descripcion
INTO vieja
FROM
	contractos
WHERE
                  contractos.codigo = OLD.cod_contracto
LIMIT 1;

SELECT
	contractos.descripcion
INTO nueva
FROM
	contractos
WHERE
                  contractos.codigo = NEW.cod_contracto
LIMIT 1;

INSERT INTO audit_ficha_det
	(
	cod_audit,
	campo,
	valor_ant,
	valor_new
	)
VALUES
	(
		ultimo,
		'CONTRATO',
		vieja,
		nueva
	);


END
IF;


IF (
	OLD.cod_n_contracto <> NEW.cod_n_contracto
) THEN

SELECT
	ficha_n_contracto.descripcion
INTO vieja
FROM
	ficha_n_contracto
WHERE
                  ficha_n_contracto.codigo = OLD.cod_n_contracto
LIMIT 1;

SELECT
	ficha_n_contracto.descripcion
INTO nueva
FROM
	ficha_n_contracto
WHERE
                  ficha_n_contracto.codigo = NEW.cod_n_contracto
LIMIT 1;

INSERT INTO audit_ficha_det
	(
	cod_audit,
	campo,
	valor_ant,
	valor_new
	)
VALUES
	(
		ultimo,
		'NUMERO CONTRATO',
		vieja,
		nueva
	);


END
IF;

IF (
	OLD.cod_region <> NEW.cod_region
) THEN

SELECT
	regiones.descripcion
INTO vieja
FROM
	regiones
WHERE
                  regiones.codigo = OLD.cod_region
LIMIT 1;

SELECT
	regiones.descripcion
INTO nueva
FROM
	regiones
WHERE
                  regiones.codigo = NEW.cod_region
LIMIT 1;


INSERT INTO audit_ficha_det
	(
	cod_audit,
	campo,
	valor_ant,
	valor_new
	)
VALUES
	(
		ultimo,
		'REGION',
		vieja,
		nueva
	);


END
IF;


IF (
	OLD.cod_cliente <> NEW.cod_cliente
) THEN

SELECT
	clientes.descripcion
INTO vieja
FROM
	clientes
WHERE
                  clientes.codigo = OLD.cod_cliente
LIMIT 1;

SELECT
	clientes.descripcion
INTO nueva
FROM
	clientes
WHERE
                  clientes.codigo = NEW.cod_cliente
LIMIT 1;

INSERT INTO audit_ficha_det
	(
	cod_audit,
	campo,
	valor_ant,
	valor_new
	)
VALUES
	(
		ultimo,
		'CLIENTE',
		vieja,
		nueva
	);


END
IF;


IF (
	OLD.cod_ubicacion <> NEW.cod_ubicacion
) THEN

SELECT
	clientes_ubicacion.descripcion
INTO vieja
FROM
	clientes_ubicacion
WHERE
                  clientes_ubicacion.codigo = OLD.cod_ubicacion
LIMIT 1;

SELECT
	clientes_ubicacion.descripcion
INTO nueva
FROM
	clientes_ubicacion
WHERE
                  clientes_ubicacion.codigo = NEW.cod_ubicacion
LIMIT 1;

INSERT INTO audit_ficha_det
	(
	cod_audit,
	campo,
	valor_ant,
	valor_new
	)
VALUES
	(
		ultimo,
		'UBICACION',
		vieja,
		nueva
	);


END
IF;


IF (
	OLD.cod_turno <> NEW.cod_turno
) THEN

SELECT
	turno.descripcion
INTO vieja
FROM
	turno
WHERE
                  turno.codigo = OLD.cod_turno
LIMIT 1;

SELECT
	turno.descripcion
INTO nueva
FROM
	turno
WHERE
                  turno.codigo = NEW.cod_turno
LIMIT 1;

INSERT INTO audit_ficha_det
	(
	cod_audit,
	campo,
	valor_ant,
	valor_new
	)
VALUES
	(
		ultimo,
		'TURNO',
		vieja,
		nueva
	);


END
IF;


IF (
	OLD.n_rotacion <> NEW.n_rotacion
) THEN

INSERT INTO audit_ficha_det
	(
	cod_audit,
	campo,
	valor_ant,
	valor_new
	)
VALUES
	(
		ultimo,
		'NUMERO DE ROTACIONES',
		OLD.n_rotacion,
		NEW.n_rotacion
	);


END
IF;


IF (
	OLD.cod_banco <> NEW.cod_banco
) THEN

SELECT
	bancos.descripcion
INTO vieja
FROM
	bancos
WHERE
                  bancos.codigo = OLD.cod_banco
LIMIT 1;

SELECT
	bancos.descripcion
INTO nueva
FROM
	bancos
WHERE
                  bancos.codigo = NEW.cod_banco
LIMIT 1;

INSERT INTO audit_ficha_det
	(
	cod_audit,
	campo,
	valor_ant,
	valor_new
	)
VALUES
	(
		ultimo,
		'BANCO',
		vieja,
		nueva
	);


END
IF;


IF (
	OLD.cta_banco <> NEW.cta_banco
) THEN
INSERT INTO audit_ficha_det
	(
	cod_audit,
	campo,
	valor_ant,
	valor_new
	)
VALUES
	(
		ultimo,
		'NUMERO DE CUENTA',
		OLD.cta_banco,
		NEW.cta_banco
	);


END
IF;


IF (OLD.carnet <> NEW.carnet) THEN
INSERT INTO audit_ficha_det
	(
	cod_audit,
	campo,
	valor_ant,
	valor_new
	)
VALUES
	(
		ultimo,
		'POSEE CARNET',
		OLD.carnet,
		NEW.carnet
	);


END
IF;


IF (OLD.nombres <> NEW.nombres) THEN
INSERT INTO audit_ficha_det
	(
	cod_audit,
	campo,
	valor_ant,
	valor_new
	)
VALUES
	(
		ultimo,
		'NOMBRES',
		OLD.nombres,
		NEW.nombres
	);


END
IF;


IF (
	OLD.apellidos <> NEW.apellidos
) THEN
INSERT INTO audit_ficha_det
	(
	cod_audit,
	campo,
	valor_ant,
	valor_new
	)
VALUES
	(
		ultimo,
		'APELLIDOS',
		OLD.apellidos,
		NEW.apellidos
	);


END
IF;


IF (
	OLD.fec_nacimiento <> NEW.fec_nacimiento
) THEN
INSERT INTO audit_ficha_det
	(
	cod_audit,
	campo,
	valor_ant,
	valor_new
	)
VALUES
	(
		ultimo,
		'FECHA DE NACIMIENTO',
		OLD.fec_nacimiento,
		NEW.fec_nacimiento
	);


END
IF;


IF (
	OLD.lugar_nac <> NEW.lugar_nac
) THEN
INSERT INTO audit_ficha_det
	(
	cod_audit,
	campo,
	valor_ant,
	valor_new
	)
VALUES
	(
		ultimo,
		'LUGAR DE NACIMIENTO',
		OLD.lugar_nac,
		NEW.lugar_nac
	);


END
IF;


IF (OLD.sexo <> NEW.sexo) THEN
INSERT INTO audit_ficha_det
	(
	cod_audit,
	campo,
	valor_ant,
	valor_new
	)
VALUES
	(
		ultimo,
		'SEXO',
		OLD.sexo,
		NEW.sexo
	);


END
IF;


IF (OLD.telefono <> NEW.telefono) THEN
INSERT INTO audit_ficha_det
	(
	cod_audit,
	campo,
	valor_ant,
	valor_new
	)
VALUES
	(
		ultimo,
		'TELEFONO',
		OLD.telefono,
		NEW.telefono
	);


END
IF;


IF (OLD.celular <> NEW.celular) THEN
INSERT INTO audit_ficha_det
	(
	cod_audit,
	campo,
	valor_ant,
	valor_new
	)
VALUES
	(
		ultimo,
		'CELULAR',
		OLD.celular,
		NEW.celular
	);


END
IF;


IF (
	OLD.direccion <> NEW.direccion
) THEN
INSERT INTO audit_ficha_det
	(
	cod_audit,
	campo,
	valor_ant,
	valor_new
	)
VALUES
	(
		ultimo,
		'DIRECCION',
		OLD.direccion,
		NEW.direccion
	);


END
IF;


IF (OLD.correo <> NEW.correo) THEN
INSERT INTO audit_ficha_det
	(
	cod_audit,
	campo,
	valor_ant,
	valor_new
	)
VALUES
	(
		ultimo,
		'CORREO',
		OLD.correo,
		NEW.correo
	);


END
IF;


IF (
	OLD.experiencia <> NEW.experiencia
) THEN
INSERT INTO audit_ficha_det
	(
	cod_audit,
	campo,
	valor_ant,
	valor_new
	)
VALUES
	(
		ultimo,
		'EXPERIENCIA',
		OLD.experiencia,
		NEW.experiencia
	);


END
IF;


IF (
	OLD.observacion <> NEW.observacion
) THEN
INSERT INTO audit_ficha_det
	(
	cod_audit,
	campo,
	valor_ant,
	valor_new
	)
VALUES
	(
		ultimo,
		'OBSERVACION',
		OLD.observacion,
		NEW.observacion
	);


END
IF;


IF (
	OLD.fec_carnet <> NEW.fec_carnet
) THEN
INSERT INTO audit_ficha_det
	(
	cod_audit,
	campo,
	valor_ant,
	valor_new
	)
VALUES
	(
		ultimo,
		'FECHA DE CARNET',
		OLD.fec_carnet,
		NEW.fec_carnet
	);


END
IF;


IF (
	OLD.fec_ingreso <> NEW.fec_ingreso
) THEN
INSERT INTO audit_ficha_det
	(
	cod_audit,
	campo,
	valor_ant,
	valor_new
	)
VALUES
	(
		ultimo,
		'FECHA DE INGRESO',
		OLD.fec_ingreso,
		NEW.fec_ingreso
	);


END
IF;


IF (
	OLD.fec_profit <> NEW.fec_profit
) THEN
INSERT INTO audit_ficha_det
	(
	cod_audit,
	campo,
	valor_ant,
	valor_new
	)
VALUES
	(
		ultimo,
		'FECHA PROFIT',
		OLD.fec_profit,
		NEW.fec_profit
	);


END
IF;


IF (
	OLD.fec_contracto <> NEW.fec_contracto
) THEN
INSERT INTO audit_ficha_det
	(
	cod_audit,
	campo,
	valor_ant,
	valor_new
	)
VALUES
	(
		ultimo,
		'FECHA DE CONTRATO',
		OLD.fec_contracto,
		NEW.fec_contracto
	);


END
IF;


IF (OLD.campo01 <> NEW.campo01) THEN
INSERT INTO audit_ficha_det
	(
	cod_audit,
	campo,
	valor_ant,
	valor_new
	)
VALUES
	(
		ultimo,
		'CAMPO ADICIONAL 1',
		OLD.campo01,
		NEW.campo01
	);


END
IF;


IF (OLD.campo02 <> NEW.campo02) THEN
INSERT INTO audit_ficha_det
	(
	cod_audit,
	campo,
	valor_ant,
	valor_new
	)
VALUES
	(
		ultimo,
		'CAMPO ADICIONAL 2',
		OLD.campo02,
		NEW.campo02
	);


END
IF;


IF (OLD.campo03 <> NEW.campo03) THEN
INSERT INTO audit_ficha_det
	(
	cod_audit,
	campo,
	valor_ant,
	valor_new
	)
VALUES
	(
		ultimo,
		'CAMPO ADICIONAL 3',
		OLD.campo03,
		NEW.campo03
	);


END
IF;


IF (OLD.campo04 <> NEW.campo04) THEN
INSERT INTO audit_ficha_det
	(
	cod_audit,
	campo,
	valor_ant,
	valor_new
	)
VALUES
	(
		ultimo,
		'CAMPO ADICIONAL 4',
		OLD.campo04,
		NEW.campo04
	);


END
IF;



IF (
	OLD.cod_ficha_status <> NEW.cod_ficha_status
) THEN

SELECT
	ficha_status.descripcion
INTO vieja
FROM
	ficha_status
WHERE
                  ficha_status.codigo = OLD.cod_ficha_status
LIMIT 1;

SELECT
	ficha_status.descripcion
INTO nueva
FROM
	ficha_status
WHERE
                  ficha_status.codigo = NEW.cod_ficha_status
LIMIT 1;


INSERT INTO audit_ficha_det
	(
	cod_audit,
	campo,
	valor_ant,
	valor_new
	)
VALUES
	(
		ultimo,
		'STATUS DE LA FICHA',
		vieja,
		nueva
	);


END
IF;


IF (
	OLD.cod_ficha_status_militar <> NEW.cod_ficha_status_militar
) THEN

SELECT
	ficha_status_militar.descripcion
INTO vieja
FROM
	ficha_status_militar
WHERE
                  ficha_status_militar.codigo = OLD.cod_ficha_status_militar
LIMIT 1;

SELECT
	ficha_status_militar.descripcion
INTO nueva
FROM
	ficha_status_militar
WHERE
                  ficha_status_militar.codigo = NEW.cod_ficha_status_militar
LIMIT 1;

INSERT INTO audit_ficha_det
	(
	cod_audit,
	campo,
	valor_ant,
	valor_new
	)
VALUES
	(
		ultimo,
		'ESTATUS MILITAR',
		vieja,
		nueva
	);


END
IF;


IF (
	OLD.status_militar_obs <> NEW.status_militar_obs
) THEN
INSERT INTO audit_ficha_det
	(
	cod_audit,
	campo,
	valor_ant,
	valor_new
	)
VALUES
	(
		ultimo,
		'ESTATUS MILITAR OBSERVACION',
		OLD.status_militar_obs,
		NEW.status_militar_obs
	);


END
IF;


IF (
	OLD.servicio_militar <> NEW.servicio_militar
) THEN
INSERT INTO audit_ficha_det
	(
	cod_audit,
	campo,
	valor_ant,
	valor_new
	)
VALUES
	(
		ultimo,
		'SERVIVIO MILITAR',
		OLD.servicio_militar,
		NEW.servicio_militar
	);


END
IF;




END
;;
DELIMITER ;
