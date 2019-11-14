<?php
define("SPECIALCONSTANT",true);
session_start();
$Nmenu   = 512;
require("../autentificacion/aut_config.inc.php");
include_once('../'.Funcion);
require_once("../".class_bdI);
require_once("../".Leng);
$bd = new DataBase();

$cliente           = $_POST['cliente'];

$reporte         = $_POST['reporte'];
$usuario         = $_POST['trabajador'];
$archivo         = "rp_mant_usuarios_cliente".$fecha."";
$titulo          = "  REPORTE USUARIOS CLIENTES \n";

if(isset($reporte)){

		$where = " WHERE men_usuarios.codigo = usuario_clientes.cod_usuario
                   AND usuario_clientes.cod_ubicacion = clientes_ubicacion.codigo
                   AND clientes_ubicacion.cod_cliente = clientes.codigo ";


	if($cliente != "TODOS"){
		$where .= " AND clientes.codigo = '$cliente' ";
	}

	if($usuario != NULL){
		$where  .= " AND men_usuarios.`status` = '$usuario' ";
	}
	// QUERY A MOSTRAR //
	    $sql = "SELECT men_usuarios.cedula, men_usuarios.apellido,
		               men_usuarios.nombre, men_usuarios.`status`,
                       clientes.nombre AS cliente, clientes_ubicacion.descripcion AS ubicacion
                  FROM men_usuarios , usuario_clientes ,
                       clientes_ubicacion , clientes
				       $where
              ORDER BY 3 ASC";

	if($reporte== 'excel'){
		echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition:  filename=\"rp_$archivo.xls\";");

		$query01  = $bd->consultar($sql);

	 echo "<table border=1>";
 	 echo "<tr><th> ".$leng['ci']." </th><th> Apellido </th><th> Nombre </th><th> Status </th><th> ".$leng['cliente']." </th><th> ".$leng['ubicacion']." </th></tr>";

		while ($row01 = $bd->obtener_num($query01)){
		 echo "<tr><td>".$row01[0]."</td><td>".$row01[1]."</td><td>".$row01[2]."</td><td>".statuscal($row01[3])."</td>
		           <td>".$row01[4]."</td><td>".$row01[5]."</td></tr>";
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
            <th width='12%'>".$leng['ci']."</th>
            <th width='14%'>Apellido</th>
            <th width='14%'>Nombre</th>
            <th width='20%'>".$leng['cliente']."</th>
            <th width='40%'>".$leng['ubicacion']."</th>
            </tr>";

            $f=0;
    while ($row = $bd->obtener_num($query)){
    	 if ($f%2==0){
                echo "<tr>";
            }else{
                echo "<tr class='class= odd_row'>";
            }
    echo   "<td width='12%'>".$row[0]."</td>
            <td width='14%'>".$row[1]."</td>
            <td width='14%'>".$row[2]."</td>
            <td width='20%'>".$row[4]."</td>
            <td width='40%'>".$row[5]."</td>";

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