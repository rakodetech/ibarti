<?php
define("SPECIALCONSTANT",true);
session_start();
$Nmenu   = 563;
require("../autentificacion/aut_config.inc.php");
require_once("../".Funcion);
require_once("../".class_bdI);
require_once("../".Leng);
$bd = new DataBase();

$novedades       = $_POST['novedades'];
$clasif          = $_POST['clasif'];
$tipo            = $_POST['tipo'];
$cliente         = $_POST['cliente'];
$ubicacion       = $_POST['ubicacion'];
$reporte         = $_POST['reporte'];
$archivo         = "rp_nov_novedad_cliente_".$fecha."";
$titulo          = " REPORTE DE NOVEDADES CLIENTES \n";

if(isset($reporte)){
	$where = " WHERE nov_cl_ubicacion.cod_cl_ubicacion = clientes_ubicacion.codigo
                 AND clientes_ubicacion.cod_cliente    = clientes.codigo
                 AND nov_cl_ubicacion.cod_novedad      = novedades.codigo
                 AND novedades.cod_nov_clasif          = nov_clasif.codigo
                 AND novedades.cod_nov_tipo            = nov_tipo.codigo ";

	if($novedades != "TODOS"){
		$where  .= " AND novedades.codigo = '$novedades' ";
	}

	if($clasif != "TODOS"){
		$where .= " AND nov_clasif.codigo = '$clasif' ";
	}


	if($tipo != "TODOS"){
		$where  .= " AND nov_tipo.codigo = '$tipo' ";
	}

	if($cliente != "TODOS"){
		$where  .= " AND clientes.codigo = '$cliente' ";
	}

	if($ubicacion != "TODOS"){
		$where  .= " AND clientes_ubicacion.codigo = '$ubicacion' ";
	}

	// QUERY A MOSTRAR //
		  	$sql = "SELECT novedades.codigo, novedades.descripcion AS novedades,
                           nov_clasif.descripcion AS clasif, nov_tipo.descripcion AS tipo,
						   clientes.nombre AS cliente, clientes_ubicacion.descripcion AS ubicacion
                      FROM nov_cl_ubicacion, clientes_ubicacion, clientes, novedades , nov_clasif, nov_tipo
					       $where
                  ORDER BY 3 ASC ";

	if($reporte== 'excel'){
		echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition:  filename=\"$archivo.xls\";");

		$query01  = $bd->consultar($sql);
		 echo "<table border=1>";
 	 echo "<tr>
            <th width='23%'>Novedades</th>
            <th width='23%'>Clasificaión</th>
            <th width='12%'>Tipo</th>
            <th width='12%'>".$leng['cliente']."</th>
            <th width='30%'>".$leng['ubicacion']."</th>
            </tr>";

		while ($row01 = $bd->obtener_num($query01)){
		 echo "<tr><td> ".$row01[0]." </td><td>".$row01[1]."</td><td>".$row01[2]."</td><td>".$row01[3]."</td>
		           <td>".$row01[4]."</td><td>".$row01[5]."</td><td>".$row01[6]."</td><td>".$row01[7]."</td>
				   <td>".$row01[8]."</td><td>".$row01[9]."</td><td>".$row01[10]."</td><td>".$row01[11]."</td>
				   <td>".$row01[12]."</td></tr>";
		}
		 echo "</table>";

				 echo "<tr><td>".$row01[0]."</td><td>".$row01[1]."</td><td>".$row01[2]."</td><td>".$row01[3]."</td>
						   <td>".$row01[4]."</td><td>".$row01[5]."</td></tr>";
				}
		 echo "</table>";
		}
	if($reporte == 'pdf'){
		require_once('../'.ConfigDomPdf);
		$dompdf= new DOMPDF();

		$query = $bd->consultar($sql);

		ob_start();

		require('../'.PlantillaDOM.'/header_ibarti_2.php');
		include('../'.pagDomPdf.'/paginacion_ibarti.php');

		echo "<br><div>
        <table>
		<tbody>
            <tr style='background-color: #4CAF50;'>
            <th width='23%'>Novedades</th>
            <th width='23%'>Clasificaión</th>
            <th width='12%'>Tipo</th>
            <th width='12%'>".$leng['cliente']."</th>
            <th width='30%'>".$leng['ubicacion']."</th>
            </tr>";

            $f=0;
    while ($row = $bd->obtener_num($query)){
    	 if ($f%2==0){
                echo "<tr>";
            }else{
                echo "<tr class='odd_row'>";
            }
    echo   "<td width='23%'>".$row[1]."</td>
   		    <td width='23%'>".$row[2]."</td>
            <td width='12%'>".$row[3]."</td>
            <td width='12%'>".$row[4]."</td>
            <td width='30%'>".$row[5]."</td></tr>";

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