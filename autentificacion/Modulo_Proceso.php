<?php

	$mod = $_GET['mod'];
	$Nmenu = $_GET['Nmenu'];
	$sql   = "SELECT men_menu.descripcion AS Menu, men_modulos.descripcion AS Modulo
                FROM men_menu , men_modulos
               WHERE men_menu.codigo = '$Nmenu' 
                 AND men_modulos.codigo = '$mod'";
	
   $query = $bd->consultar($sql);
	$rowModulo = $bd->obtener_fila($query,0);

   $Menu_X    = 'Menu: '.$rowModulo[0];  
   $Modulo_X  = 'Modulo: '.$rowModulo[1]; 	

?>
