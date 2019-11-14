<?php
define("SPECIALCONSTANT",true);
session_start();
$Nmenu   = 535;
require("../autentificacion/aut_config.inc.php");
include_once('../'.Funcion);
require_once("../".class_bdI);
require_once("../".Leng);
$bd = new DataBase();

$rol        = $_POST['rol'];
$region     = $_POST['region'];
$estado     = $_POST['estado'];
$contrato   = $_POST['contrato'];
$cargo      = $_POST['cargo'];
$cliente    = $_POST['cliente'];
$ubicacion  = $_POST['ubicacion'];
$rotacion   = $_POST['rotacion'];
$trabajador = $_POST['trabajador'];

$reporte      = $_POST['reporte'];
$archivo         = " rp_pl_rotacion_trab_".$fecha."";
$titulo          = " REPORTE PLANTILLA DE ROTACION TRABAJADOR  \n";

if(isset($reporte)){

	$where = "  WHERE v_ficha.cod_ficha_status = control.ficha_activo
              	  AND horarios.codigo = Rotacion(v_ficha.cod_ficha, v_ficha.cod_rotacion, 'F')";

	if($rol != "TODOS"){
		$where .= " AND v_ficha.cod_rol = '$rol' ";
	}
	if($region != "TODOS"){
		$where .= " AND v_ficha.cod_region = '$region' ";
	}

	if($estado != "TODOS"){
		$where .= " AND v_ficha.cod_estado = '$estado' ";
	}

	if($contrato != "TODOS"){
		$where  .= " AND v_ficha.cod_contracto = '$contrato' ";
	}
	if($cargo != "TODOS"){
		$where  .= " AND v_ficha.cod_cargo = '$cargo' ";
	}

	if($cliente != "TODOS"){
		$where  .= " AND v_ficha.cod_cliente = '$cliente' ";
	}

	if($ubicacion != "TODOS"){
		$where  .= " AND v_ficha.cod_ubicacion = '$ubicacion' ";
	}
	if($rotacion != "TODOS"){
		$where  .= " AND v_ficha.cod_rotacion = '$rotacion' ";
	}

	if($trabajador != NULL){
		$where  .= " AND v_ficha.cod_ficha.cod_ficha = '$trabajador' ";
	}
 // v_ficha.cod_ubicacion,
/*
     $sql = "SELECT v_ficha.cod_ficha, v_ficha.cedula,
                    v_ficha.ap_nombre, v_ficha.rol,
					v_ficha.region,  v_ficha.estado,
                    v_ficha.contracto, v_ficha.cargo,
					v_ficha.cliente, v_ficha.cliente_abrev,
					v_ficha.ubicacion, v_ficha.rotacion,
					(v_ficha.n_rotacion +1)AS n_rotacion, horarios.nombre AS horario
               FROM v_ficha, control , horarios

          $where
           ORDER BY 1 ASC ";*/

           $sql="SELECT
					v_ficha.cod_ficha,
					v_ficha.cedula,
					v_ficha.ap_nombre,
					v_ficha.rol,
					v_ficha.region,
					v_ficha.estado,
					v_ficha.contracto,
					v_ficha.cargo,
					clientes.nombre,
					clientes.abrev,
					rotacion.descripcion,
					clientes_ubicacion.direccion,
					(v_ficha.n_rotacion +1) AS n_rotacion,
					horarios.nombre AS horario
					FROM
					v_ficha ,
					control ,
					horarios , 
					clientes ,
					rotacion ,
					clientes_ubicacion
					WHERE v_ficha.cod_ficha_status = control.ficha_activo
					        AND horarios.codigo = Rotacion(v_ficha.cod_ficha, v_ficha.cod_rotacion, 'F')
					AND v_ficha.cod_cliente = clientes.codigo
					AND v_ficha.cod_rotacion = rotacion.codigo
					AND v_ficha.cod_ubicacion = clientes_ubicacion.codigo
					ORDER BY 1 ASC
					";

	if($reporte== 'excel'){
		echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
		 header("Content-type: application/vnd.ms-excel");
		 header("Content-Disposition:  filename=\"rp_$archivo.xls\";");

		$query01  = $bd->consultar($sql);
		 echo "<table border=1>";
 	 echo "<tr><th> ".$leng['ficha']." </th><th> ".$leng['ci']." </th><th> ".$leng['trabajador']." </th><th> ".$leng['rol']." </th>
	           <th> ".$leng['region']." </th> <th> ".$leng['estado']." </th><th> ".$leng['contrato']." </th><th> Cargo </th>
		       <th> ".$leng['cliente']." </th><th> ".$leng['cliente']." Abrev. </th><th> Rotación </th><th> ".$leng['ubicacion']." </th>
			   <th> Posición </th><th> Horario </th></tr>";

		while ($row01 = $bd->obtener_num($query01)){
		 echo "<tr><td> ".$row01[0]." </td><td>".$row01[1]."</td><td>".$row01[2]."</td><td>".$row01[3]."</td>
		           <td>".$row01[4]."</td><td>".$row01[5]."</td><td>".$row01[6]."</td><td>".$row01[7]."</td>
		           <td>".$row01[8]."</td><td>".$row01[9]."</td><td>".$row01[10]."</td><td>".$row01[11]."</td>
				   <td>".$row01[12]."</td><td>".$row01[13]."</td></tr>";
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
            <th width='12%'>".$leng['cliente']."</th>
            <th width='20%'>".$leng['ubicacion']."</th>
            <th width='10%'>".$leng['ficha']."</th>
            <th width='20%'>".$leng['trabajador']."</th>
            <th width='16%'>Rotacion</th>
            <th width='10%'>Posicion</th>
            <th width='12%'>Horario</th>
            </tr>";

            $f=0;
    while ($row = $bd->obtener_num($query)){
    	 if ($f%2==0){
                echo "<tr>";
            }else{
                echo "<tr class='class= odd_row'>";
            }
    echo   "<td width='12%'>".$row[8]."</td>
            <td width='20%'>".$row[11]."</td>
            <td width='10%'>".$row[0]."</td>
            <td width='20%'>".$row[2]."</td>
            <td width='16%'>".$row[11]."</td>
            <td width='10%'>".$row[12]."</td>
            <td width='12%'>".$row[13]."</td></tr>";

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
