<?php include_once('../../../funciones/funciones.php');
require("../../../autentificacion/aut_config.inc.php");
require_once("../../../".class_bd);
$bd = new DataBase();

$cod_ubic       = $_POST['codigo'];
$tamano         = $_POST['tamano'];
$evento         = $_POST['evento'];
$name           = $_POST['name'];
$usuario        = $_POST['usuario'];

 $sql = "SELECT clientes_ub_puesto.codigo, clientes_ub_puesto.nombre
           FROM clientes_ub_puesto
          WHERE clientes_ub_puesto.cod_cl_ubicacion = '$cod_ubic'
            AND clientes_ub_puesto.`status` = 'T'
          ORDER BY 2 ASC";
$query = $bd->consultar($sql);

echo '<select name="'.$name.'" id="'.$name.'" style="width:'.$tamano.'" onchange="'.$evento.'" required>';
	  while($datos=$bd->obtener_fila($query,0)){
						echo '<option value="'.$datos[0].'">'.$datos[1].'</option>';
	 				}
		echo'</select>';
mysql_free_result($query);
?>
