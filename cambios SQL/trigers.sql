/*
Navicat MySQL Data Transfer

Source Server         : IBARTI
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : ib2_oesvica_nueva

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2019-07-09 10:25:23
*/

DROP TRIGGER IF EXISTS `trig_detalle_status_delete_p`;
DELIMITER ;;
CREATE TRIGGER `trig_detalle_status_delete_p` AFTER UPDATE ON `dotacion_proceso` FOR EACH ROW BEGIN
IF(NEW.anulado='T') THEN
      DELETE FROM dotacion_proceso_status WHERE  cod_proceso = NEW.codigo ;
END IF;

END
;;
DELIMITER ;

DROP TRIGGER IF EXISTS `trig_detalle_status_add`;
DELIMITER ;;
CREATE TRIGGER `trig_detalle_status_add` AFTER INSERT ON `dotacion_proceso_det` FOR EACH ROW BEGIN

INSERT INTO dotacion_proceso_status(cod_dotacion,
cod_proceso,
cod_us_ing,
fecha,
cod_status) VALUES (NEW.cod_dotacion,NEW.cod_dotacion_proceso,NEW.cod_us_mod,NEW.fec_us_mod,NEW.status);

END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `trig_detalle_status_mod`;
DELIMITER ;;
CREATE TRIGGER `trig_detalle_status_mod` AFTER UPDATE ON `dotacion_proceso_det` FOR EACH ROW BEGIN

IF(NEW.status="04") THEN
DELETE FROM dotacion_proceso_status WHERE cod_dotacion = OLD.cod_dotacion AND cod_proceso = OLD.cod_dotacion_proceso and cod_status = "05";
END IF;

IF(NEW.status<>"04") THEN
INSERT INTO dotacion_proceso_status(cod_dotacion,
cod_proceso,
cod_us_ing,
fecha,
cod_status) VALUES (NEW.cod_dotacion,NEW.cod_dotacion_proceso,NEW.cod_us_mod,NEW.fec_us_mod,NEW.status);
END IF;
END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `trig_detalle_status_delete`;
DELIMITER ;;
CREATE TRIGGER `trig_detalle_status_delete` BEFORE DELETE ON `dotacion_proceso_det` FOR EACH ROW BEGIN

DELETE FROM dotacion_proceso_status WHERE cod_dotacion = OLD.cod_dotacion AND cod_proceso = OLD.cod_dotacion_proceso ;

END
;;
DELIMITER ;

DROP TRIGGER IF EXISTS `trig_detalle_status_delete_r`;
DELIMITER ;;
CREATE TRIGGER `trig_detalle_status_delete_r` AFTER UPDATE ON `dotacion_recepcion` FOR EACH ROW BEGIN
IF(NEW.anulado='T') THEN
      DELETE FROM dotacion_recepcion_status WHERE  cod_recepcion = NEW.codigo ;
END IF;

END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `trig_detalle_statusr_add_r`;
DELIMITER ;;
CREATE TRIGGER `trig_detalle_statusr_add_r` AFTER INSERT ON `dotacion_recepcion_det` FOR EACH ROW BEGIN

INSERT INTO dotacion_recepcion_status(cod_dotacion,
cod_recepcion,
cod_us_ing,
fecha,
cod_status) VALUES (NEW.cod_dotacion,NEW.cod_dotacion_recepcion,NEW.cod_us_mod,NEW.fec_us_mod,NEW.status);

END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `trig_detalle_statusr_mod_r`;
DELIMITER ;;
CREATE TRIGGER `trig_detalle_statusr_mod_r` AFTER UPDATE ON `dotacion_recepcion_det` FOR EACH ROW BEGIN

IF(NEW.status="06") THEN
DELETE FROM dotacion_recepcion_status WHERE cod_dotacion = OLD.cod_dotacion AND cod_recepcion = OLD.cod_dotacion_recepcion and cod_status = "07";
END IF;

IF(NEW.status<>"06") THEN
INSERT INTO dotacion_recepcion_status(cod_dotacion,
cod_recepcion,
cod_us_ing,
fecha,
cod_status) VALUES (NEW.cod_dotacion,NEW.cod_dotacion_recepcion,NEW.cod_us_mod,NEW.fec_us_mod,NEW.status);
END IF;
END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `trig_detalle_statusr_delete_r`;
DELIMITER ;;
CREATE TRIGGER `trig_detalle_statusr_delete_r` BEFORE DELETE ON `dotacion_recepcion_det` FOR EACH ROW BEGIN

DELETE FROM dotacion_proceso_status WHERE cod_dotacion = OLD.cod_dotacion AND cod_proceso = OLD.cod_dotacion_proceso ;

END
;;
DELIMITER ;
