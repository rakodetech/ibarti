<?php
define("SPECIALCONSTANT",true);
require("../autentificacion/aut_config.inc.php");
require_once("../".Funcion);
require_once("../".class_bdI);
require_once("../".Leng);
$bd = new DataBase();

$usuario         = $_POST['usuario'];
$perfil         = $_POST['perfil'];
$reporte         = $_POST['reporte'];
$titulo          = " REPORTE PERACIONAL DE NOVEDADES PENDIENTES";

$archivo         = "rp_nov_novedad_pendiente";


if(isset($reporte)){

	$sql_det = "SELECT nov_procesos.codigo ,nov_status.descripcion as stat, nov_clasif.descripcion clasificacion,
concat(men_usuarios.nombre,' ',men_usuarios.apellido) nombre,
nov_procesos.observacion,
nov_procesos_det.observacion, novedades.descripcion,nov_status.codigo cod_status,nov_procesos_det.fec_us_ing fecha, nov_procesos_det.cod_us_ing usuario
		FROM nov_procesos,nov_procesos_det,novedades,nov_perfiles, men_usuarios,nov_status,nov_clasif
WHERE  nov_procesos.cod_novedad = novedades.codigo
and nov_procesos_det.cod_nov_proc = nov_procesos.codigo
 AND novedades.`status` = 'T'
AND nov_status.control_notificaciones = 'T'
			and nov_perfiles.cod_nov_clasif = nov_clasif.codigo
						AND novedades.cod_nov_clasif = nov_perfiles.cod_nov_clasif
						and nov_procesos.cod_nov_status = nov_status.codigo
						AND nov_perfiles.cod_perfil = '$perfil' 
						AND nov_procesos.cod_us_mod = men_usuarios.codigo
						and men_usuarios.status = 'T'
				and nov_procesos.cod_us_mod <> '$usuario'
					and nov_procesos.cod_us_ing <> $usuario
						and nov_perfiles.respuesta = 'T'
		ORDER BY nov_status.codigo ASC,nov_procesos_det.fec_us_ing ASC  ";

	if($reporte == 'excel'){
		echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition:  filename=\"$archivo.xls\";");
		echo "<table border=1>";
		$query01  = $bd->consultar($sql_det);
		echo "<tr><th>Código </th><th>Fecha Sistema </th><th> Clasificación </th><th> Novedad </th>
		<th> ".$leng['cliente']." </th><th> ".$leng['ubicacion']." </th><th> ".$leng['ficha']." </th><th> ".$leng['ci']." </th>
		<th> ".$leng['trabajador']." </th><th> Observación General </th><th>Respuesta </th><th> Usuario </th><th> Fecha Ingreso </th>
		<th> Hora </th><th> Status </th><th> Observación </th></tr>";

		while ($row01 = $bd->obtener_num($query01)){
			echo "<tr><td >".$row01[0]."</td><td>".$row01[1]."</td><td>".$row01[2]."</td><td>".$row01[3]."</td>
			<td>".$row01[4]."</td><td>".$row01[5]."</td><td>".$row01[6]."</td><td>".$row01[7]."</td>
			<td>".$row01[8]."</td><td>".$row01[9]."</td><td>".$row01[10]."</td><td>".$row01[11]."</td>
			<td>".$row01[12]."</td><td>".$row01[13]."</td><td>".$row01[14]."</td><td>".$row01[15]."</td></tr>";
		}

	}
