<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase();
$codigo    = $_POST['codigo'];
					
 	 $sql   = "SELECT preingreso.cedula AS cantidad
                 FROM preingreso 
                WHERE preingreso.cedula = '$codigo'";						  		

	 $query = $bd->consultar($sql);	

	if($bd->num_fila($query) == 0){
		echo $mensaje = "Cedula Valida";	  
	}else{
		echo $mensaje = "Ya existe Una Cedula con ese codigo ($codigo)";		
	}
	mysql_free_result($query);?>