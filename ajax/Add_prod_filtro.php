<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase(); 
$codigo      = $_POST['codigo'];
$tamano      = $_POST['tamano'];
$activar     = $_POST['activar'];

	if($activar == "T"){	
		$change =  'onchange="Add_filtroX()"';
	}else{
		$change =  'onchange="Validar02(this.value)"';
	}
	
	$sql = " SELECT codigo, item, descripcion FROM productos
              WHERE productos.cod_sub_linea = '$codigo'
                AND status = 'T'
           ORDER BY 2 ASC ";
   $query = $bd->consultar($sql);		   

	echo'<select name="producto" id="producto" style="width:'.$tamano.'px" '.$change.' required>
			     <option value="">Seleccione...</option>'; 
    while($row02=$bd->obtener_fila($query,0)){
				echo '<option value="'.$row02[0].'">'.$row02[2].' - '.$row02[1].'</option>';
				}
		  echo'</select>';
		  mysql_free_result($query);
?>