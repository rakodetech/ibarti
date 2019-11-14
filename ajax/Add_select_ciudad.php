<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase();
$codigo       = $_POST['codigo'];
$usuario      = $_POST['usuario'];
$name         = $_POST['name'];
$tamano       = $_POST['tamano'];
$evento       = $_POST['evento'];

$sql = " SELECT codigo, descripcion FROM ciudades
            WHERE cod_estado = '$codigo'
              AND `status` = 'T'
            ORDER BY descripcion ASC ";

   $query = $bd->consultar($sql);

	echo'<select name="'.$name.'" id="'.$name.'" style="width:'.$tamano.'" onchange="'.$evento.'" required>
			     <option value="">Seleccione...</option>';
    while($row02=$bd->obtener_fila($query,0)){
				echo '<option value="'.$row02[0].'">'.$row02[1].'</option>';
				}
		  echo'
        </select>';mysql_free_result($query);?>
