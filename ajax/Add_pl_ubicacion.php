<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase();
$cod_cliente  = $_POST['cliente'];
$cod_ficha    = $_POST['ficha'];


    $sql = "SELECT clientes_ubicacion.codigo, clientes_ubicacion.descripcion
			  FROM clientes_ubicacion
			 WHERE clientes_ubicacion.cod_cliente = '$cod_cliente'
			   AND clientes_ubicacion.`status` = 'T'
			 ORDER BY 2 ASC";

   $query = $bd->consultar($sql);

	echo'<select name="ubicacion_'.$cod_ficha.'" style="width:160px" required>
			     <option value="">Seleccione...</option>';
    while($row02=$bd->obtener_fila($query,0)){
				echo '<option value="'.$row02[0].'">'.$row02[1].'</option>';
				}
		  echo'
        </select>';mysql_free_result($query);?>
