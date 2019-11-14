<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase(); 

$codigo       = $_POST['codigo'];	
$i        = 0; 

    $sql = "SELECT asistencia_apertura.codigo, asistencia_apertura.fec_diaria,
                   asistencia_apertura.apertura
              FROM asistencia_apertura
             WHERE asistencia_apertura.cod_contracto = '$codigo'
               AND asistencia_apertura.`status` = 'T' 
	      ORDER BY 2 DESC ";
   $query = $bd->consultar($sql);

echo'<table width="100%" align="center">';
		echo'<tr>
			<td class="etiqueta" width="25%">Fecha Diaria</td>
			<td class="etiqueta" width="75%" align="left">Apertura</td>
	   </tr>';	

    while($row02=$bd->obtener_fila($query,0)){

	 $check    = $row02['apertura'];									  
	 $i++;
	
	$checkX = CheckX($check, 'S');

		echo'<tr>
			<td>'.$row02["fec_diaria"].'</td>
			<td><input type="checkbox" name="apertura_cod[]"value="'.$row02['codigo'].'" style="width:auto" '.$checkX.'/></td>
	   </tr>';	
 	}	
echo '<tr><td  colspan="2"><input name="metodo" type="hidden"  value="apertura"/></td>
	   </tr></table>';	 
	   mysql_free_result($query);
?> 