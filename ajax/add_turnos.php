<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase(); 

$horario        = $_POST['horario'];	
$cod_turno_tipo = $_POST['turno_tipo'];	
$usuario        = $_POST['usuario'];	

$sql = " SELECT turno_dias.dia, turno_dias.tipo,
                turno_dias.descripcion
           FROM turno_dias
          WHERE turno_dias.tipo = '$cod_turno_tipo'
            AND turno_dias.`status` = 'T'
       ORDER BY 1 ASC ";
       $query = $bd->consultar($sql);
         
		 if (isset($_POST['turno_tipo'])){
		 	echo'<table width="100%" align="center">
						<tr>
							<td class="etiqueta" width="25%">Fecha Diaria</td>
							<td class="etiqueta" width="75%" align="left">Apertura</td>
		                </tr>';   
					while($row02=$bd->obtener_fila($query,0)){	
				echo '<tr>
						<td> '.$row02[2].'</td>
						<td><input type="checkbox" name="DIA[]"value="'.$row02[0].'" style="width:auto" checked="checked"/></td>
				   </tr>';
					}
		echo '</table>';
		 }
		 mysql_free_result($query);
?> 