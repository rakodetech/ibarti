<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase();
$codigo    = $_POST['codigo'];
					
 	 $sql   = " SELECT productos.item FROM productos
                 WHERE productos.item = '$codigo'";						  		

	 $query = $bd->consultar($sql);	

	if($bd->num_fila($query) == 0){
 
	}else{
		echo $mensaje = "Ya existe ese Serial ($codigo)";		
	}
	mysql_free_result($query);?>