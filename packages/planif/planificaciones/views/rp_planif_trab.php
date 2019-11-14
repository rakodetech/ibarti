<?php
define("SPECIALCONSTANT",true);
require("../../../../autentificacion/aut_config.inc.php");
include_once('../../../../funciones/funciones.php');
require_once("../../../../".class_bdI);
require_once("../../../../".Leng);
$bd = new DataBase();
$ficha           = $_POST['ficha'];
$apertura        = $_POST['apertura'];
$reporte         = $_POST['reporte'];
$archivo         = "rp_planif_trabajador_det_".$fecha."";
$titulo          = "REPORTE PLANIFICACION TRABAJADOR \n";

if(isset($reporte)){
	// QUERY A MOSTRAR //
  $sql = " SELECT a.fecha, Dia_semana_abrev(a.fecha) d_semana,
                  clientes.abrev cliente, clientes_ubicacion.descripcion ubicacion,
                  clientes_ub_puesto.nombre puesto_trabajo,
                  ficha.cod_ficha, CONCAT(ficha.apellidos,' ',ficha.nombres) ap_nombre,
                  turno.abrev tuno_abrev, turno.descripcion turno,
                  horarios.nombre horario
             FROM planif_clientes_trab_det a, turno, horarios, clientes_ub_puesto, ficha, clientes, clientes_ubicacion
            WHERE a.cod_ficha = '$ficha'
              AND a.cod_planif_cl = '$apertura'
              AND a.cod_turno = turno.codigo
              AND turno.cod_horario = horarios.codigo
              AND a.cod_puesto_trabajo =clientes_ub_puesto.codigo
              AND a.cod_ficha = ficha.cod_ficha
              AND a.cod_cliente = clientes.codigo
              AND a.cod_ubicacion = clientes_ubicacion.codigo
         ORDER BY a.fecha ASC ";

if($reporte== 'excel'){
  echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
  header("Content-type: application/vnd.ms-excel");
  header("Content-Disposition: filename=\"rp_$archivo.xls\";");

  $query01  = $bd->consultar($sql);
   echo "<table border=1>";
 echo "<tr><th>Fecha </th><th> Día </th><th>".$leng['cliente']." </th><th> ".$leng['ubicacion']."</th>
        <th>Puesto De Trabajo</th><th> ".$leng['ficha']." </th><th> ".$leng['trabajador']." </th><th> Abrav. Turno </th>
       <th> Turno </th><th> Horario </th></tr>";

  while ($row01 = $bd->obtener_num($query01)){
   echo "<tr><td> ".$row01[0]." </td><td>".$row01[1]."</td><td>".$row01[2]."</td><td>".$row01[3]."</td>
             <td>".$row01[4]."</td><td>".$row01[5]."</td><td>".$row01[6]."</td><td>".$row01[7]."</td>
         <td>".$row01[8]."</td><td>".$row01[9]."</td></tr>";
  }
   echo "</table>";
}

	if($reporte == 'pdf'){
    $sql00 = " SELECT CONCAT(ficha.apellidos,' ',ficha.nombres) ap_nombre
               FROM ficha  WHERE ficha.cod_ficha = '$ficha' ";
    $query00  = $bd->consultar($sql00);
    $row00 = $bd->obtener_num($query00);
    $trabajador = $row00[0];
    require_once('../../../../'.ConfigDomPdf);
		$dompdf= new DOMPDF();
  //  $dompdf->loadHtml('hello world');
		$query  = $bd->consultar($sql);
		ob_start();

		require('../../../../'.PlantillaDOM.'/packages_header.php');
		require('../../../../'.pagDomPdf.'/paginacion_ibarti.php');

echo '<div><table style="padding-top: 2px;">
        <tbody>
           <tr>
              <td width="25%">
                <span class="etiqueta">'.$leng["ficha"].': </span><span class="texto">'.$ficha.'</span>
              </td>
              <td width="50%">
                <span class="etiqueta">'.$leng["trabajador"].': </span><span class="texto">'.$trabajador.'</span>
              </td>
              <td width="25%"></td>
            </tr>
          </tbody>
      </table></div>';

		echo "<div><table>
		        <tbody>
            <tr style='background-color: #4CAF50;'>
              <th width='16%'>Fecha</th>
              <th width='15%'>".$leng['cliente']."</th>
              <th width='25%'>".$leng['ubicacion']."</th>
              <th width='22%'>Puesto trabajo</th>
              <th width='22%'>Horario</th>
            </tr>";
            $f=0;
    while ($row = $bd->obtener_num($query)){
    	 if ($f%2==0){
                echo "<tr>";
            }else{
                echo "<tr class='class= odd_row'>";
            }
    echo   "<td width='16%'>".$row[0]." (".$row[1].")</td>
            <td width='15%'>".$row[2]."</td>
            <td width='25%'>".$row[3]."</td>
            <td width='22%'>".$row[4]."</td>
            <td width='22%'>".$row[9]."</td>
            </tr>";
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
       //$dompdf->stream('aa.pdf');
	}
}
?>
