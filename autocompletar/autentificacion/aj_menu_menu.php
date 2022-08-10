<?php
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase();

$codigo      =  $_POST['codigo'];	

	$sql = " SELECT DISTINCT men_menu_modulos.cod_men_principal, men_principal.descripcion
			   FROM men_menu_modulos, men_principal 
			  WHERE cod_menu_modulo = '$codigo' 
			    AND men_menu_modulos.cod_men_principal = men_principal.codigo ORDER BY 2 ASC ";

   $query = $bd->consultar($sql);

	echo'<select id="menu" name="menu"  style="width:150px" onchange="Actualizar()">
			     <option value="">SELECCIONE...</option>';
			  	 while($row02=$bd->obtener_fila($query,0)){
					echo '<option value="'.$row02[0].'">'.$row02[1].'</option>';
				}
		  echo' 
        </select>';
mysql_free_result($query);
?>