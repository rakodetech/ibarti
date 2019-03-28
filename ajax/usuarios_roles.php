<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase();
	$codigo       =  $_POST['codigo'];	// rol
	$i =  0;

	$sql = "  SELECT roles.codigo, roles.descripcion, IFNULL(usuario_roles.cod_usuario, 'NO') AS existe
				FROM roles LEFT JOIN usuario_roles ON usuario_roles.cod_usuario = '$codigo'  
				                 AND roles.codigo = usuario_roles.cod_rol
			   WHERE roles.`status` = 'T'
			   ORDER BY descripcion ASC";
   $query = $bd->consultar($sql);
	echo'<table width="90%" align="center">';
	$valor = 0;

    while($row03=$bd->obtener_fila($query,0)){
	$i++;
		if ($valor == 0){
			$fondo = 'fondo01';
		$valor = 1;
		}else{
			$fondo = 'fondo02';
			$valor = 0;
		}
		if($row03['existe'] != 'NO'){ 
			echo'
				<tr class="'.$fondo.'">
					<td class="etiqueta">'.$row03[1].'</td>
					<td><input type="checkbox" name="roles[]" value="'.$row03[0].'" style="width:auto" checked="checked"/>
					</td>
			   </tr>';
		  }else{	

			echo'
				<tr class="'.$fondo.'">
					<td class="etiqueta">'.$row03[1].'</td>
					<td><input type="checkbox" name="roles[]" value="'.$row03[0].'" style="width:auto"/>
					</td>
			   </tr>';
		  }}
mysql_free_result($query);?>