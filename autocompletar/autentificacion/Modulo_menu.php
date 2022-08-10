<?php
	$bd = new DataBase();
	$mod = $_GET['mod'];
	$sql   = "SELECT men_modulos.descripcion
                FROM men_modulos
               WHERE men_modulos.codigo = '$mod'";
	
   $query = $bd->consultar($sql);
	$rowModulo = $bd->obtener_fila($query,0);
   $Modulo_X  = 'MODULO: '.$rowModulo[0]; 		

	if(isset($_GET['Nmenu'])){
	$Nmenu = $_GET['Nmenu']; 
	$sql   = "SELECT men_menu.descripcion 
                FROM men_menu
               WHERE men_menu.codigo = '$Nmenu'";

   $query = $bd->consultar($sql);
   $rowMenu = $bd->obtener_fila($query,0);
   $Menu_X    = 'MENU: '.$rowMenu[0];  
	}else{
		$Menu_X  = "";
	}




?>
