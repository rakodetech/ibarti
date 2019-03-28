<?php
include_once('../funciones/funciones.php');
require "../autentificacion/aut_config.inc.php";
require "../".class_bd;
require "../".Leng;
$bd = new DataBase();

$codigo    = $_POST['codigo'];
$fecha_D    = conversion($_POST['fec_desde']);
$fecha_H   = conversion($_POST['fec_hasta']);




 	$sql = " SELECT COUNT(nom_calendario_det.fecha) cant1, COUNT(b.fecha) cant2, clientes.abrev
           FROM clientes_ubicacion , nom_calendario LEFT JOIN nom_calendario_det b
					                                          ON nom_calendario.cod_calendario_nl = b.cod_calendario
                                                    AND b.fecha BETWEEN  \"$fecha_D\" AND \"$fecha_H\" ,
							  nom_calendario_det, clientes
          WHERE clientes_ubicacion.cod_cliente = '$codigo'
            AND clientes_ubicacion.cod_calendario = nom_calendario.codigo
            AND nom_calendario.codigo = nom_calendario_det.cod_calendario
            AND nom_calendario_det.fecha BETWEEN  \"$fecha_D\" AND \"$fecha_H\"
            AND clientes_ubicacion.cod_cliente =clientes.codigo ";

   $query = $bd->consultar($sql);
	 $datos=$bd->obtener_fila($query,0);
	 $mensaje = "";
		if (($datos[0] == 0) && ($datos[1] == 0) ){
	//		echo $result = "No existe Fecha en el calendario para este cliente: ($datos[2]), <br> Desde : ".$_POST['fec_desde']." Hasta: ".$_POST['fec_hasta']."";
		echo	$mensaje = "No existe Fecha en el calendario de Feriado, para este cliente: ($datos[2]),  Desde : ".$_POST['fec_desde']." Hasta: ".$_POST['fec_hasta']."";

		}

?>
