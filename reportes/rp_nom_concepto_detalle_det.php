<?php
define("SPECIALCONSTANT",true);
session_start();
$Nmenu   = 547;
require("../autentificacion/aut_config.inc.php");
include_once('../'.Funcion);
require_once("../".class_bdI);
require_once("../".Leng);
$bd = new DataBase();

$concepto        = $_POST['concepto'];
$categoria       = $_POST['categoria'];
$rol          = $_POST['rol'];
$status          = $_POST['status'];

$reporte         = $_POST['reporte'];
$trabajador      = $_POST['trabajador'];
$archivo         = "rp_nom_concepto_detalle_".$fecha."";
$titulo          = "  REPORTE CONCEPTO DETALLE \n";

if(isset($reporte)){

	$where = "WHERE concepto_det.codigo = conceptos.codigo
				AND concepto_det.cod_rol = roles.codigo
				AND concepto_det.cod_categoria = concepto_categoria.codigo ";

	if($concepto != "TODOS"){
		$where  .= " AND conceptos.codigo = '$concepto' ";
	}

	if($categoria != "TODOS"){
		$where  .= " AND concepto_det.cod_categoria = '$categoria' ";
	}

	if($rol != "TODOS"){
		$where  .= " AND roles.codigo = '$rol' ";
	}

	if($status != "TODOS"){

	}elseif($status == "T"){

		$where  .= " AND conceptos.`status` = '$status' ";
	}elseif($status == "T"){

		$where  .= " AND conceptos.`status` = '$status' ";
	}

	// QUERY A MOSTRAR //
		$sql = "SELECT concepto_categoria.descripcion AS categoria, roles.descripcion AS rol,
                       concepto_det.codigo , conceptos.abrev,
					   conceptos.descripcion AS concepto, concepto_det.cod_concepto AS aplicar,
					   concepto_det.cantidad
                  FROM concepto_det, conceptos, concepto_categoria, roles
					   $where
			 ORDER BY categoria, rol,  concepto_det.codigo ASC";

	if($reporte== 'excel'){
		echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
		header("Content-type: application/vnd.ms-excel");
		 header("Content-Disposition:  filename=\"rp_$archivo.xls\";");

		$query01  = $bd->consultar($sql);
		 echo "<table border=1>";
 	 echo "<tr><th>Categoría </th><th> ".$leng['rol']."</th><th> Cod. ".$leng['concepto']." </th><th> Abrev. </th>
	           <th> ".$leng['concepto']." </th><th> Aplicar </th><th> Cantidad </th></tr>";

		while ($row01 = $bd->obtener_num($query01)){
		 echo "<tr><td > ".$row01[0]." </td><td>".$row01[1]."</td>
		 <td>".$row01[2]."</td><td>".$row01[3]."</td>
		 <td>".$row01[4]."</td><td>".$row01[5]."</td>
		 <td>".$row01[6]."</td></tr>";

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
            <th width='15%'>Categoria</th>
            <th width='10%'>".$leng['rol']."</th>
            <th width='12%'>Cod. ".$leng['concepto']."</th>
            <th width='10%'>Abreviatura</th>
            <th width='33%'>".$leng['concepto']."</th>
            <th width='10%'>Aplicar</th>
            <th width='10%'>Cantidad</th>
            </tr>";

            $f=0;
    while ($row = $bd->obtener_num($query)){
    	 if ($f%2==0){
                echo "<tr>";
            }else{
                echo "<tr class='class= odd_row'>";
            }
    echo   "<td width='15%'>".$row[0]."</td>
   		    <td width='10%'>".$row[1]."</td>
            <td width='10%'>".$row[2]."</td>
            <td width='10%'>".$row[3]."</td>
            <td width='35%'>".$row[4]."</td>
            <td width='10%'>".$row[5]."</td>
            <td width='10%'>".$row[6]."</td></tr>";

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