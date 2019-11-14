<?php include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase();

$cod_turno      = $_POST['codigo'];
$tamano         = $_POST['tamano'];
$evento         = $_POST['evento'];
$name           = $_POST['name'];
$usuario        = $_POST['usuario'];

 $sql = "SELECT horarios.codigo,  horarios.nombre descripcion
           FROM turno , horarios
          WHERE turno.codigo = '$cod_turno'
            AND turno.cod_horario = horarios.codigo
          ORDER BY 2 ASC";

$query = $bd->consultar($sql);

echo '<select name="'.$name.'" id="'.$name.'" style="width:'.$tamano.'" onchange="'.$evento.'">';
	  while($datos=$bd->obtener_fila($query,0)){
						echo '<option value="'.$datos[0].'">'.$datos[1].'</option>';
	 				}

		echo'</select>';
mysql_free_result($query);
?>
