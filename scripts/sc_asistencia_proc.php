<?php
define("SPECIALCONSTANT",true);
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bdI);
$bd = new DataBase();

$tabla    = 'asistencia';

$apertura   = $_POST['apertura'];
$rol        = $_POST['rol'];
$contracto  = $_POST['contracto'];
$fec_diaria  = $_POST['fec_diaria'];

$href       = $_POST['href'];
$usuario    = $_POST['usuario'];
$proced     = $_POST['proced'];
$metodo     = $_POST['metodo'];
$mensaje    = "";
$i = $_POST['metodo'];

//  PROBLEMAS CON LA FECHA EN APERTURA DE FECHA

if (isset($_POST['metodo'])) {

	switch ($i) {

    case 'cerrar_as':
   	 // $sql = "SELECT COUNT(trab_roles.cod_ficha) AS trabajadoress
     //           FROM trab_roles , ficha , control
     //          WHERE trab_roles.cod_ficha = ficha.cod_ficha
     //            AND trab_roles.cod_rol = '$rol'
     //            AND ficha.cod_contracto = '$contracto'
     //            AND ficha.cod_ficha_status = control.ficha_activo
					// 			AND '$fec_diaria' >= ficha.fec_ingreso";

$sql = "SELECT COUNT(trab_roles.cod_ficha) AS trabajadores, DATEDIFF(MAX(ficha_historial.fec_fin), CURDATE()) dias
               FROM trab_roles , ficha , control, ficha_historial
              WHERE trab_roles.cod_ficha = ficha.cod_ficha
                AND trab_roles.cod_rol = '$rol'
                AND ficha.cod_contracto = '$contracto'
                AND ficha.cod_ficha_status = control.ficha_activo
				AND ficha.cod_ficha = ficha_historial.cod_ficha
				AND '$fec_diaria' >= ficha.fec_ingreso
				GROUP BY ficha.cod_ficha
				HAVING dias > -1";
   	$query = $bd->consultar($sql);
    $row01 = $bd->obtener_fila($query,0);
	$trab  = $row01[0];

   	 // $sql = " SELECT COUNT(DISTINCT(asistencia.cod_ficha)) AS trab_reportados
		   //      FROM trab_roles,ficha, asistencia , asistencia_apertura, control
	    //        WHERE trab_roles.cod_rol = '$rol'
	    //          AND trab_roles.cod_ficha = ficha.cod_ficha
		   //       AND ficha.cod_contracto = '$contracto'
		   //       AND asistencia.cod_as_apertura = '$apertura'
		   //       AND asistencia.cod_as_apertura = asistencia_apertura.codigo
		   //       AND asistencia.cod_ficha = trab_roles.cod_ficha
				 // AND asistencia.cod_concepto <> control.concepto_rep";

 	 $sql = " SELECT COUNT(DISTINCT(asistencia.cod_ficha)) AS trab_reportados, DATEDIFF(MAX(ficha_historial.fec_fin), CURDATE()) dias
		        FROM trab_roles,ficha, asistencia , asistencia_apertura, control, ficha_historial
	           WHERE trab_roles.cod_rol = '$rol'
	             AND trab_roles.cod_ficha = ficha.cod_ficha
   				AND ficha.cod_contracto = '$contracto'
		         AND asistencia.cod_as_apertura = '$apertura'
		         AND asistencia.cod_as_apertura = asistencia_apertura.codigo
		         AND asistencia.cod_ficha = trab_roles.cod_ficha
				 AND asistencia.cod_concepto <> control.concepto_rep
				 AND ficha.cod_ficha = ficha_historial.cod_ficha
 				HAVING dias > -1";

   	$query   = $bd->consultar($sql);
    $row01   = $bd->obtener_fila($query,0);
	$trab_as = $row01[0];

   	 // 	$sql = " SELECT COUNT(DISTINCT(asistencia.cod_ficha)) AS concepto_rep
		   //      FROM trab_roles,ficha, asistencia , asistencia_apertura, control
	    //        WHERE trab_roles.cod_rol = '$rol'
	    //          AND trab_roles.cod_ficha = ficha.cod_ficha
		   //       AND ficha.cod_contracto = '$contracto'
		   //       AND asistencia.cod_as_apertura = '$apertura'
		   //       AND asistencia.cod_as_apertura = asistencia_apertura.codigo
		   //       AND asistencia.cod_ficha = trab_roles.cod_ficha
				 // AND asistencia.cod_concepto = control.concepto_rep";

		$sql = " SELECT COUNT(DISTINCT(asistencia.cod_ficha)) AS concepto_rep,
				DATEDIFF(MAX(ficha_historial.fec_fin), CURDATE()) dias
		        FROM trab_roles,ficha, asistencia , asistencia_apertura, control, ficha_historial
	           WHERE trab_roles.cod_rol = '$rol'
	             AND trab_roles.cod_ficha = ficha.cod_ficha
		         AND ficha.cod_contracto = '$contracto'
		         AND asistencia.cod_as_apertura = '$apertura'
		         AND asistencia.cod_as_apertura = asistencia_apertura.codigo
		         AND asistencia.cod_ficha = trab_roles.cod_ficha
				 AND asistencia.cod_concepto = control.concepto_rep
				 AND ficha.cod_ficha = ficha_historial.cod_ficha
 				HAVING dias > -1";

   	$query   = $bd->consultar($sql);
    $row01   = $bd->obtener_fila($query,0);
	$concepto_rep = $row01[0];

	if ($trab == $trab_as){
		if ($concepto_rep == 0){
		$sql    = "$SELECT $proced('$metodo', '$apertura', '$fec_diaria', '$rol', '$contracto', '$usuario')";
		$query = $bd->consultar($sql);
		$mensaje = "SE CERRO CORRECTAMENTE LA ASISTENCIA";
		}else{
		$mensaje = "HAY CONCEPTOS DE REPLICAR EN LAS ASISTENCIA \n  ASISTENCIA NO CERRADA";
		}
	}else{
		$mensaje = "HAY DIFERENCIA EN LA ASISTENCIA ASISTENCIA. \n TRABAJADORES A REPORTAR: ".$trab.", TRABAJADORES REPORTADOS ".$trab_as." ";
	}
	 echo '<input type="hidden" id="mensaje_aj" value="'.$mensaje.'"/>';
	break;

    case 'replicar':
	$sql    = "$SELECT $proced('$metodo', '$apertura', '$fec_diaria', '$rol', '$contracto', '$usuario')";
	echo $sql;
	 $query = $bd->consultar($sql);

	break;
    case 'trab_reportar':

		$sql    = "SELECT ficha.cod_ficha, CONCAT(ficha.apellidos, ' ',ficha.nombres) AS trabajador,
                          IFNULL(asistencia.cod_ficha, 'NO') AS valor
                     FROM ficha_historial,ficha LEFT JOIN asistencia ON asistencia.cod_as_apertura = '$apertura'
                      AND ficha.cod_ficha = asistencia.cod_ficha , control, trab_roles
					WHERE ficha.cod_ficha_status = control.ficha_activo
                      AND ficha.cod_contracto = '$contracto'
                      AND ficha.cod_ficha = trab_roles.cod_ficha
					  AND ficha_historial.cod_ficha = ficha.cod_ficha
					  AND (DATEDIFF(ficha_historial.fec_fin,now())>(-1))
                      AND trab_roles.cod_rol = '$rol'
											AND '$fec_diaria' >= ficha.fec_ingreso
											AND IFNULL(asistencia.cod_ficha, 'NO') = 'NO'

					  UNION
			  SELECT ficha.cod_ficha, CONCAT(ficha.apellidos, '',ficha.nombres, ' ',' REPLICA') AS trabajador,
                     'NO' AS valor
                FROM ficha, asistencia,  control, trab_roles,ficha_historial
               WHERE asistencia.cod_as_apertura = '$apertura'
                 AND ficha.cod_ficha = asistencia.cod_ficha
                 AND asistencia.cod_concepto = control.concepto_rep
                 AND ficha.cod_contracto = '$contracto'
                 AND ficha.cod_ficha = trab_roles.cod_ficha
				 AND ficha_historial.cod_ficha = ficha.cod_ficha
AND (DATEDIFF(ficha_historial.fec_fin,now())>0)
				 AND trab_roles.cod_rol = '$rol' ";
				//  echo $sql;
	$query = $bd->consultar($sql);
	while($row01 = $bd->obtener_fila($query,0)){
		 $mensaje .= "ficha: ".$row01[0].", ".$row01[1]." \n ";
   }
	 echo '<input type="hidden" id="mensaje_aj" value="'.$mensaje.'"/>';

	break;
	}
}
//require_once('../funciones/sc_direccionar.php');
?>
