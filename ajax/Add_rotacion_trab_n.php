<?php include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase();
$cod_rotacion   = $_POST['codigo'];
$tamano         = $_POST['tamano'];
$evento         = $_POST['evento'];
$name           = $_POST['name'];
$usuario        = $_POST['usuario'];

$query = $bd->consultar("SELECT COUNT(rotacion_det.codigo)
							             FROM rotacion_det
							            WHERE rotacion_det.cod_rotacion = ".$cod_rotacion."");

$row06   = $bd->obtener_fila($query,0);
$cantidad =$row06[0];
echo '<select name="'.$name.'" id="'.$name.'" style="width:'.$tamano.'" onchange="'.$evento.'">
              <option value="">Seleccione ... </option>';
			for ($i = 0; $i < $cantidad; $i++) {
				$x = $i+1;
		echo '<option value="'.$i.'">'.$x.'</option>';}
		echo'</select>';
mysql_free_result($query);
?>
