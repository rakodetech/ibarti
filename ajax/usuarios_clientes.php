<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd       = new DataBase();
$codigo   = $_POST['codigo'];	// rol
$i        = 0;

	$sql = "  SELECT clientes_ubicacion.cod_cliente, clientes.nombre AS cliente , 
	                 clientes_ubicacion.codigo,  clientes_ubicacion.descripcion AS ubicacion,
                     IFNULL(usuario_clientes.cod_usuario, 'NO') AS existe
                FROM clientes_ubicacion LEFT JOIN usuario_clientes ON usuario_clientes.cod_usuario = '$codigo'
				                                  AND  clientes_ubicacion.codigo = usuario_clientes.cod_ubicacion ,
					 clientes 
               WHERE clientes_ubicacion.cod_cliente = clientes.codigo
                 AND clientes.`status` = 'T'
                 AND clientes_ubicacion.`status` = 'T' 
			   ORDER BY 2, 5 ASC";
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
					<td class="etiqueta">'.$row03[1].' - '.$row03[3].'</td>
					<td><input type="checkbox" name="ubicacion[]" value="'.$row03['codigo'].'" style="width:auto" checked="checked"/>
					</td>
			   </tr>';
		  }else{	

			echo'
				<tr class="'.$fondo.'">
					<td class="etiqueta">'.$row03[1].' - '.$row03[3].'</td>
					<td><input type="checkbox" name="ubicacion[]" value="'.$row03['codigo'].'" style="width:auto"/>
					</td>
			   </tr>';
		  }}
		  mysql_free_result($query);?>