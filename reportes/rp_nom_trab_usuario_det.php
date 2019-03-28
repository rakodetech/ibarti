<?php
define("SPECIALCONSTANT",true);
session_start();
$Nmenu   = 541;
require("../autentificacion/aut_config.inc.php");
include_once('../'.Funcion);
require_once("../".class_bdI);
require_once("../".Leng);
$bd = new DataBase();

$rol             = $_POST['rol'];
$region          = $_POST['region'];
$estado          = $_POST['estado'];
$ciudad          = $_POST['ciudad'];

$reporte         = $_POST['reporte'];
$trabajador      = $_POST['trabajador'];
$archivo         = "rp_trab_usuario_".$fecha."";

$titulo          = "  REPORTE TRABAJADORES ASIGNADO HA USUARIOS \n";

if(isset($reporte)){

		$where = " WHERE usuario_roles.cod_rol = trab_roles.cod_rol
				     AND trab_roles.cod_ficha = ficha.cod_ficha
			 	     AND usuario_roles.cod_usuario = men_usuarios.codigo
				     AND ficha.cedula = preingreso.cedula
				     AND ficha.cod_ficha_status = control.ficha_activo
				     AND trab_roles.cod_rol = roles.codigo
				     AND ficha.cod_region = regiones.codigo
				     AND preingreso.cod_estado = estados.codigo
				     AND preingreso.cod_ciudad = ciudades.codigo ";

	if($rol != "TODOS"){
		$where  .= " AND roles.codigo = '$rol' ";
	}

	if($region != "TODOS"){
		$where .= " AND regiones.codigo = '$region' ";
	}

	if($estado != "TODOS"){
		$where .= " AND estados.codigo = '$estado' ";  // cambie AND asistencia.co_cont = '$contracto'
	}

	if($ciudad != "TODOS"){
		$where  .= " AND ciudades.codigo = '$ciudad' ";
	}

	if($trabajador != NULL){
		$where  .= " AND ficha.cod_ficha = '$trabajador' ";
	}

	// QUERY A MOSTRAR //
		$sql = "SELECT roles.descripcion AS rol, regiones.descripcion AS region,
                       estados.descripcion AS estado, ciudades.descripcion AS ciudad,
                       usuario_roles.cod_usuario, men_usuarios.nombre,
                       men_usuarios.apellido,
                       trab_roles.cod_ficha, preingreso.cedula,
                       preingreso.nombres
                  FROM usuario_roles , trab_roles , men_usuarios, ficha ,
                       preingreso, control, roles, regiones,
                       estados,  ciudades
					   $where
			  ORDER BY men_usuarios.apellido ASC ";


	if($reporte== 'excel'){
		echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
		header("Content-type: application/vnd.ms-excel");
		 header("Content-Disposition:  filename=\"rp_$archivo.xls\";");

		$query01  = $bd->consultar($sql);
		 echo "<table border=1>";
 	 echo "<tr><th> ".$leng['rol']."</th><th> ".$leng['region']." </th><th> ".$leng['estado']." </th><th> CIUDAD && MUNICIPIO </th><th>Cod. Usuario </th>
 	           <th>US. Nombre </th><th> US. Apellido</th><th> ".$leng['ficha']." </th><th> ".$leng['ci']." </th><th> Nombre</th></tr>";

		while ($row01 = $bd->obtener_num($query01)){
		 echo "<tr><td > ".$row01[0]." </td><td>".$row01[1]."</td>
		 <td>".$row01[2]."</td><td>".$row01[3]."</td>
		 <td>".$row01[4]."</td><td>".$row01[5]."</td>
		 <td>".$row01[6]."</td><td>".$row01[7]."</td>
		  <td>".$row01[8]."</td><td>".$row01[9]."</td></tr>";

		}
		 echo "</table>";
	}

	if($reporte == 'pdf'){
		require_once('../'.ConfigDomPdf);
		$dompdf= new DOMPDF();

		$query  = $bd->consultar($sql);

		ob_start();

		require('../'.PlantillaDOM.'/header_ibarti_2.php');
		include('../'.pagDomPdf.'/paginacion_ibarti.php');

		echo "<br><div>
        <table>
		<tbody>
            <tr style='background-color: #4CAF50;'>
            <th width='15%'>".$leng['rol']."</th>
            <th width='15%'>".$leng['estado']."</th>
            <th width='15%'>".$leng['ciudad']."</th>
            <th width='18%'>Us. Apellido</th>
            <th width='18%'>Trab. Ficha</th>
            <th width='19%'>Trab. Nombre</th>
            </tr>";

            $f=0;
    while ($row = $bd->obtener_num($query)){
    	 if ($f%2==0){
                echo "<tr>";
            }else{
                echo "<tr class='class= odd_row'>";
            }
    echo   "<td width='15%'>".$row[0]."</td>
   		    <td width='15%'>".$row[2]."</td>
            <td width='15%'>".$row[3]."</td>
            <td width='18%'>".$row[6]."</td>
            <td width='18%'>".$row[7]."</td>
            <td width='19%'>".$row[9]."</td></tr>";

             $f++;
         }

    echo "</tbody>
        </table>
		</div>
		</body>
		</html>";

		    $dompdf->load_html(ob_get_clean(),'UTF-8');
		    $dompdf->render();
		    $dompdf->stream($archivo, array('Attachment' => 0));
	}
}