<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase();

$codigo       = $_POST['codigo'];
// todas

	$sql = " SELECT asistencia_apertura.codigo, asistencia_apertura.fec_diaria
              FROM asistencia_apertura
             WHERE asistencia_apertura.cod_contracto = '$codigo'
               AND asistencia_apertura.`status` = 'T'
             ORDER BY 2 ASC ";

   $query = $bd->consultar($sql);
echo' <select name="cod_apertura" id="cod_apertura" style="width:150px">
			     <option value="">Seleccione...</option>';
			  	 while($datos=$bd->obtener_fila($query,0)){
						 echo '<option value="'.$datos[0].'">'.$datos[1].'</option>';
				}
		  echo'</select>';
   mysql_free_result($query);
?>
