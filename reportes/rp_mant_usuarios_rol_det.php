<?php
define("SPECIALCONSTANT",true);
session_start();
$Nmenu   = 511;
require("../autentificacion/aut_config.inc.php");
include_once('../'.Funcion);
require_once("../".class_bdI);
require_once("../".Leng);
$bd = new DataBase();

$rol           = $_POST['rol'];
$reporte       = $_POST['reporte'];
$usuario       = $_POST['trabajador'];
$archivo       = "rp_mant_usuarios_roles_".$fecha."";
$titulo        = " REPORTE USUARIOS ROLES \n";

if(isset($reporte)){

		$where = " WHERE men_usuarios.codigo = usuario_roles.cod_usuario
                     AND usuario_roles.cod_rol = roles.codigo ";


	if($rol != "TODOS"){
		$where .= " AND roles.codigo = '$rol' ";
	}

	if($usuario != NULL){
		$where  .= " AND men_usuarios.codigo = '$usuario' ";
	}
	// QUERY A MOSTRAR //
	    $sql = "SELECT men_usuarios.cedula, men_usuarios.apellido,
		               men_usuarios.nombre, roles.descripcion AS rol,
					   men_usuarios.`status`
                  FROM men_usuarios, usuario_roles, roles
				       $where
              ORDER BY 2 ASC";

	if($reporte== 'excel'){
		echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition:  filename=\"rp_$archivo.xls\";");

		$query01  = $bd->consultar($sql);
	 echo "<table border=1>";
 	 echo "<tr><th> ".$leng['ci']." </th><th> Apellido </th><th> Nombre </th><th> Roles </th><th> Status </th></tr>";

		while ($row01 = $bd->obtener_num($query01)){
		 echo "<tr><td>".$row01[0]."</td><td>".$row01[1]."</td><td>".$row01[2]."</td><td>".$row01[3]."</td>
		           <td>".statuscal($row01[4])."</td>
			   </tr>";
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
            <th width='15%'>".$leng['ci']."</th>
            <th width='25%'>Apellido</th>
            <th width='25%'>Nombre</th>
            <th width='20%'>".$leng['rol']."</th>
            <th width='10%'>Status</th>
            </tr>";

            $f=0;
    while ($row = $bd->obtener_num($query)){
    	 if ($f%2==0){
                echo "<tr>";
            }else{
                echo "<tr class='class= odd_row'>";
            }
    echo   "<td width='15%'>".$row[0]."</td>
            <td width='25%'>".$row[1]."</td>
            <td width='25%'>".$row[2]."</td>
            <td width='20%'>".$row[3]."</td>
            <td width='10%'>".statuscal($row[4])."</td></tr>";

             $f++;
         }

    echo "</tbody>
        </table>
		</div>
		</body>
		</html>";

		    $dompdf->load_html(ob_get_clean(),'UTF-8');
		    $dompdf->set_paper ('letter','landscape');
		    $dompdf->render();
		    $dompdf->stream($archivo, array('Attachment' => 0));
	}
}