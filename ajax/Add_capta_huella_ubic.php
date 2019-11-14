<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);

$bd = new DataBase();
$codigo   = $_POST['cod'];

$sql_ch = " SELECT clientes_ub_ch.cod_capta_huella, descripcion FROM clientes_ubicacion , clientes_ub_ch
WHERE clientes_ubicacion.cod_cliente = '$codigo'
AND clientes_ubicacion.codigo = clientes_ub_ch.cod_cl_ubicacion
ORDER BY 2 ASC ";

$query = $bd->consultar($sql_ch);
echo'<select name="capta_huella" id="capta_huella" style="width:250px">
<option value="TODOS">Todos</option>';
while($row02=$bd->obtener_fila($query,0)){
	echo '<option value="'.$row02[0].'">'.$row02[1]. ' - '.$row02[0].'</option>';
}

echo'</select>';
mysql_free_result($query);?>
