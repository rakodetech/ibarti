<?php include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase();

$filtro         = $_POST['filtro'];
$tamano         = $_POST['tamano'];
$evento         = $_POST['evento'];
$name           = $_POST['name'];
$usuario        = $_POST['usuario'];

 $sql = "SELECT ficha.cod_ficha, ficha.cedula, CONCAT(ficha.apellidos, ' ',ficha.nombres) AS ap_nombre
   	      FROM ficha
	 			 WHERE LOCATE('$filtro', ficha.cedula)
            OR LOCATE('$filtro', ficha.cod_ficha)
				   	OR LOCATE('$filtro', CONCAT(ficha.apellidos, ' ',ficha.nombres))
         ORDER BY 3 ASC";

$query = $bd->consultar($sql);

echo '<select name="'.$name.'" id="'.$name.'" style="width:'.$tamano.'" onchange="'.$evento.'">
              <option value="">Seleccione ... </option>';
	  while($datos=$bd->obtener_fila($query,0)){
						echo '<option value="'.$datos[0].'">'.$datos[2].' ('.$datos[0].')</option>';
	 				}

		echo'</select>';
mysql_free_result($query);
?>
