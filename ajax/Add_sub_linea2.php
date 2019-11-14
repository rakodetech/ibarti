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
		$change =  'onchange="Validar01(this.value)"';
	}
	
	$sql = " SELECT codigo, descripcion FROM prod_sub_lineas
              WHERE cod_linea = '$codigo'
                AND status = 'T'
           ORDER BY descripcion ASC ";

   $query = $bd->consultar($sql);
	echo'<select name="sub_linea" id="sub_linea" style="width:'.$tamano.'px" '.$change.'  required>
			     <option value="TODOS">Seleccione...</option>'; 
    while($row02=$bd->obtener_fila($query,0)){
				echo '<option value="'.$row02[0].'">'.$row02[1].'</option>';
				}
		  echo'</select>';
		 mysql_free_result($query); ?>		 