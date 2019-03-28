<?php
define("SPECIALCONSTANT",true);
$Nmenu   = 572;
require("../autentificacion/aut_config.inc.php");
include_once('../'.Funcion);
require_once("../".class_bdI);
require_once("../".Leng);

$bd = new DataBase();

$producto   = $_POST['producto'];
$linea      = $_POST['linea'];
$sub_linea  = $_POST['sub_linea'];
$tipo_mov   = $_POST['tipo_mov'];
$cliente    = $_POST['cliente'];
$ubicacion  = $_POST['ubicacion'];

$fecha_D   = conversion($_POST['fecha_desde']);
$fecha_H   = conversion($_POST['fecha_hasta']);
$reporte         = $_POST['reporte'];

$archivo         = "rp_mov_inventario_".$date."";
$titulo          = " REPORTE DE MOVIMIENTO DE INVENTARIO \n";

if(isset($reporte)){

	$where = " WHERE prod_movimiento.fecha BETWEEN \"$fecha_D\" AND \"$fecha_H\"
	             AND prod_movimiento.cod_producto = productos.codigo
                 AND prod_movimiento.cod_cliente = clientes.codigo
                 AND prod_movimiento.cod_ubicacion = clientes_ubicacion.codigo
                 AND clientes_ubicacion.cod_estado = estados.codigo
                 AND prod_movimiento.`status` = 'T'
                 AND prod_movimiento.cod_mov_tipo =  prod_mov_tipo.codigo
                 AND productos.cod_linea = prod_lineas.codigo
                 AND productos.cod_sub_linea = prod_sub_lineas.codigo
                 AND prod_movimiento.cod_ficha = ficha.cod_ficha
                 AND ficha.cedula = preingreso.cedula ";

	if($producto != "TODOS"){
		$where .= " AND productos.codigo  = '$producto' ";
	}
	if($linea != "TODOS"){
		$where .= " AND prod_lineas.codigo  = '$linea' ";
	}
	if($sub_linea != "TODOS"){
		$where .= "  AND prod_sub_lineas.codigo = '$sub_linea' ";
	}
	if($tipo_mov != "TODOS"){
		$where .= "  AND prod_mov_tipo.codigo = '$tipo_mov' ";
	}

	if($cliente != "TODOS"){
		$where .= "  AND clientes.codigo = '$cliente' ";
	}

	if($ubicacion != "TODOS"){
		$where .= "  AND clientes_ubicacion.codigo = '$ubicacion'";
	}

 $sql = " SELECT CONCAT(prod_movimiento.fecha,' ',prod_movimiento.hora) AS fecha,  prod_movimiento.cod_producto,
                 productos.item AS serial, productos.descripcion AS producto,
                 prod_mov_tipo.descripcion AS mov_tipo, prod_lineas.descripcion AS linea,
				 prod_sub_lineas.descripcion AS sub_linea, productos.campo01 AS n_porte,
				 productos.campo02 AS fec_venc_permiso,
         preingreso.cedula, CONCAT(preingreso.apellidos,' ',preingreso.nombres) AS trabajador,
		         estados.descripcion AS estado,
				 clientes.nombre AS cliente, clientes_ubicacion.descripcion AS ubicacion,
				 prod_movimiento.observacion, prod_movimiento.`status`
            FROM prod_movimiento, productos, clientes_ubicacion, clientes, estados,
			     control, prod_mov_tipo,  prod_lineas, prod_sub_lineas, ficha, preingreso
			     $where
		   ORDER BY 2 DESC ";

	if($reporte== 'excel'){
		echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition:  filename=\"$archivo.xls\";");

		$query01  = $bd->consultar($sql);

	 echo "<table border=1>";
	 echo "<tr><th> Fecha </th><th> Cod. Producto </th><th> Serial </th><th> Producto </th>
	           <th> Tipo Movimiento </th><th> Linea </th><th> Sub Linea </th><th> N. Porte </th>
			   <th> Fecha Vencimiento </th><th> ".$leng['ci']." </th><th> Responsable </th> <th> ".$leng['estado']." </th>
			   <th> ".$leng['cliente']." </th><th> ".$leng['ubicacion']." </th> <th> Observación </th><th> Status </th></tr>";

		while ($row01 = $bd->obtener_num($query01)){
		 echo "<tr><td >".$row01[0]."</td><td>".$row01[1]."</td><td>".$row01[2]."</td><td>".$row01[3]."</td>
		           <td >".$row01[4]."</td><td>".$row01[5]."</td><td>".$row01[6]."</td><td>".$row01[7]."</td>
		           <td >".$row01[8]."</td><td>".$row01[9]."</td><td>".$row01[10]."</td><td>".$row01[11]."</td>
		           <td>".$row01[12]."</td><td>".$row01[13]."</td><td>".$row01[14]."</td><td>".$row01[15]."</td></tr>";
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
            <th width='16%'>Fecha</th>
            <th width='10%'>Producto</th>
            <th width='12%'>Sub Linea</th>
            <th width='12%'>Sub Linea</th>
            <th width='20%'>Tipo de Movimiento</th>
            <th width='10%'>".$leng['estado']."</th>
            <th width='20%'>".$leng['cliente']."</th>
            </tr>";

            $f=0;
    while ($row = $bd->obtener_num($query)){
    	 if ($f%2==0){
                echo "<tr>";
            }else{
                echo "<tr class='class= odd_row'>";
            }
    echo   "<td width='16%'>".$row[0]."</td>
            <td width='10%'>".$row[3]."</td>
            <td width='12%'>".$row[2]."</td>
            <td width='12%'>".$row[5]."</td>
            <td width='20%'>".$row[8]."</td>
            <td width='10%'>".$row[10]."</td>
            <td width='20%'>".$row[6]."</td></tr>";

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