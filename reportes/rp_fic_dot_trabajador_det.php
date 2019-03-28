<?php
define("SPECIALCONSTANT",true);
session_start();
$Nmenu   = 527;
require("../autentificacion/aut_config.inc.php");
include_once('../funciones/funciones.php');
require_once("../".class_bdI);
require_once("../".Leng);
$bd = new DataBase();

$rol             = $_POST['rol'];
$region          = $_POST['region'];
$estado          = $_POST['estado'];
$cliente         = $_POST['cliente'];
$contrato        = $_POST['contrato'];

$trabajador      = $_POST['trabajador'];

$reporte         = $_POST['reporte'];

$archivo         = "rp_dot_trabajador_det_".$fecha."";
$titulo          = " REPORTE ULTIMA DOTACION TRABAJADOR \n";


if(isset($reporte)){

	$where = " WHERE v_prod_dot_max2.cod_rol = roles.codigo
                 AND v_prod_dot_max2.cod_region = regiones.codigo
                 AND v_prod_dot_max2.cod_estado = estados.codigo
                 AND v_prod_dot_max2.cod_ciudad = ciudades.codigo
                 AND v_prod_dot_max2.cod_contracto = contractos.codigo
                 AND v_prod_dot_max2.cod_cliente = clientes.codigo
                 AND v_prod_dot_max2.cod_ubicacion = clientes_ubicacion.codigo
                 AND v_prod_dot_max2.cod_linea = prod_lineas.codigo
                 AND v_prod_dot_max2.cod_sub_linea = prod_sub_lineas.codigo
                 AND v_prod_dot_max2.cod_producto = productos.codigo
				 AND v_prod_dot_max2.cod_ficha_status = control.ficha_activo  ";

	if($rol != "TODOS"){
		$where .= " AND v_prod_dot_max2.cod_rol = '$rol' ";
	}

	if($region != "TODOS"){
		$where .= " AND v_prod_dot_max2.cod_region = '$region' ";
	}
	if($estado != "TODOS"){
		$where .= " AND v_prod_dot_max2.cod_estado = '$estado' ";
	}
	if($contrato != "TODOS"){
		$where  .= " AND v_prod_dot_max2.cod_contracto = '$contrato' ";
	}
	if($cliente != "TODOS"){
		$where .= " AND v_prod_dot_max2.cod_cliente = '$cliente' ";
	}

	if($trabajador != NULL){
		$where  .= " AND v_prod_dot_max2.cod_ficha = '$trabajador' ";
	}

	// QUERY A MOSTRAR //
	    $sql = "SELECT v_prod_dot_max2.cod_dotacion, v_prod_dot_max2.fecha_max AS fecha,
		               roles.descripcion AS rol, regiones.descripcion AS region,
					   estados.descripcion AS estado, ciudades.descripcion AS ciudad,
					   contractos.descripcion AS contrato, v_prod_dot_max2.cedula,
					   v_prod_dot_max2.cod_ficha, v_prod_dot_max2.ap_nombre ,
					   clientes.nombre AS ciente,  clientes_ubicacion.descripcion AS ubicacion,
					   prod_lineas.descripcion AS linea, prod_sub_lineas.descripcion AS sub_linea,
					   v_prod_dot_max2.cod_producto, productos.descripcion AS producto,
					   v_prod_dot_max2.cantidad
                  FROM v_prod_dot_max2 , roles, regiones, estados,
                       ciudades, contractos, clientes, clientes_ubicacion,
	                   prod_lineas, prod_sub_lineas, productos, control
               $where
			  ORDER BY ap_nombre ASC  ";
	if($reporte== 'excel'){
		echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition:  filename=\"rp_$archivo.xls\";");

		$query01  = $bd->consultar($sql);
		 echo "<table border=1>";


 	 echo "<tr><th> Cod. Dotación </th>
	           <th> Fecha </th><th> ".$leng['rol']." </th><th> ".$leng['region']." </th> <th> ".$leng['estado']." </th>
	           <th> ".$leng['ciudad']." </th><th> ".$leng['contrato']." </th><th> ".$leng['ci']." </th><th> ".$leng['ficha']." </th>
			   <th> ".$leng['trabajador']." </th><th> ".$leng['cliente']." </th><th> ".$leng['ubicacion']." </th><th> Línea </th>
			   <th> Sub Línea</th><th> Cod. Producto </th><th> Producto </th><th> Cantidad </th></tr>";

		while ($row01 = $bd->obtener_num($query01)){
		 echo "<tr><td>".$row01[0]."</td><td>".$row01[1]."</td><td>".$row01[2]."</td><td>".$row01[3]."</td>
		           <td>".$row01[4]."</td><td>".$row01[5]."</td><td>".$row01[6]."</td><td>'".$row01[7]."</td>
				   <td>".$row01[8]."</td><td>".$row01[9]."</td><td>".$row01[10]."</td><td>".$row01[11]."</td>
				   <td>".$row01[12]."</td><td>".$row01[13]."</td><td>".$row01[14]."</td><td>".$row01[15]."</td>
				   <td>".$row01[16]."</td></tr>";
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
            <th width='13%'>".$leng['rol']."</th>
            <th width='13%'>".$leng['estado']."</th>
            <th width='13%'>".$leng['ficha']."</th>
            <th width='30%'>".$leng['trabajador']."</th>
            <th width='23%'>Dotacion</th>
            <th width='10%'>Cantidad</th>
            </tr>";

            $f=0;
    while ($row = $bd->obtener_num($query)){
    	 if ($f%2==0){
                echo "<tr>";
            }else{
                echo "<tr class='class= odd_row'>";
            }
    echo   "<td width='13%'>".$row[2]."</td>
            <td width='13%'>".$row[4]."</td>
            <td width='13%'>".$row[8]."</td>
            <td width='30%'>".$row[9]."</td>
            <td width='23%'>".$row[15]."</td>
            <td width='10%' style='text-align:center;'>".$row[16]."</td></tr>";

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
