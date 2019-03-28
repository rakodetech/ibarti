<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase();

//require_once('../autentificacion/aut_config.inc.php');
//include_once('../funciones/mensaje_error.php');
$codigo   = $_POST['codigo'];
$tabla    = "estados";

	$sql = " SELECT estados.codigo, estados.descripcion
               FROM estados
              WHERE estados.cod_pais = '$codigo'
              ORDER BY estados.descripcion ASC ";

   $query = $bd->consultar($sql);
$ajax = "Add_ajax01(this.value, 'ajax/Add_ciudad.php', 'ciudad')";
	echo'<select name="estados" style="width:250px" onchange="'.$ajax.'">
			     <option value="">Seleccione...</option>';
			  	 while($datos=$bd->obtener_fila($query,0)){

		echo '<option value="'.$datos[0].'">'.$datos[1].'</option>';
				}
		  echo'
        </select>';
		mysql_free_result($query); ?>
