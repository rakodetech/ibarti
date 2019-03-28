<?php
define("SPECIALCONSTANT",true);
session_start();
$Nmenu   = 573;
require("../autentificacion/aut_config.inc.php");
include_once('../'.Funcion);
require_once("../".class_bdI);
require_once("../".Leng);
$bd = new DataBase();

$linea           = $_POST['linea'];
$reporte         = $_POST['reporte'];
$archivo         = "rp_inv_sin_movimiento_".$date."";
$titulo          = " REPORTE DE INVENTARIO SIN MOVIMIENTO \n";

if(isset($reporte)){
		$where = " WHERE productos.cod_linea = prod_lineas.codigo
                     AND productos.cod_sub_linea = prod_sub_lineas.codigo  ";

	if($linea   != "TODOS"){
		$where  .= " AND prod_lineas.codigo = '$linea' ";
	}

	// QUERY A MOSTRAR //
			$sql= "SELECT
			productos.codigo,
			prod_lineas.descripcion,
			prod_sub_lineas.descripcion,
			productos.descripcion,
			productos.item,
			IFNULL(v_prod_movimiento_act.cod_producto, 0) AS cantidad
			FROM
			productos
			LEFT JOIN prod_lineas ON productos.cod_linea = prod_lineas.codigo
			LEFT JOIN prod_sub_lineas ON productos.cod_sub_linea = prod_sub_lineas.codigo
			LEFT JOIN v_prod_movimiento_act ON productos.codigo = v_prod_movimiento_act.cod_producto
			HAVING cantidad=0
			ORDER BY 1 ASC";

	if($reporte== 'excel'){
		echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition:  filename=\"$archivo.xls\";");

		$query01  = $bd->consultar($sql);

	 echo "<table border=1>";
	 echo "<th> CÓDIGO </th><th> LINEA </th><th> SUB LINEA </th><th> SERIAL </th>
	       <th> PRODUCTO </th>
		   </tr>";

		while ($row01 = $bd->obtener_num($query01)){
		 echo "<tr><td>".$row01[0]."</td><td>".$row01[1]."</td><td>".$row01[2]."</td><td>".$row01[3]."</td>
		           <td>".$row01[4]."</td></tr>";
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
            <th width='15%'>Código</th>
            <th width='20%'>Linea</th>
            <th width='20%'>Sub Linea</th>
            <th width='25%'>Producto</th>
            <th width='20%'>Serial</th>
            </tr>";

            $f=0;
    while ($row = $bd->obtener_num($query)){
    	 if ($f%2==0){
                echo "<tr>";
            }else{
                echo "<tr class='class= odd_row'>";
            }
    echo   "<td width='15%'>".$row[0]."</td>
            <td width='20%'>".$row[1]."</td>
            <td width='20%'>".$row[2]."</td>
            <td width='25%'>".$row[3]."</td>
            <td width='20%'>".$row[4]."</td></tr>";

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