<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase(); 
$codigo      = $_POST['codigo'];
$tamano      = $_POST['tamano'];
$fecha_D    = conversion($_POST['fecha_desde']);
$fecha_H    = conversion($_POST['fecha_hasta']);
$change =  'onchange="Add_Cl_Ubic(this.value, \'contenido_ubic\', \'T\', \'120\')"';

$sql = "SELECT
b.codigo,
b.nombre
FROM
planif_cliente_trab_det AS a
INNER JOIN ficha ON a.cod_ficha = ficha.cod_ficha
INNER JOIN clientes AS b ON a.cod_cliente = b.codigo
WHERE
a.fecha BETWEEN '$fecha_D' AND '$fecha_H' AND
ficha.cod_ficha = '$codigo'
AND b.status = 'T'
GROUP BY 1
ORDER BY 2";

$query = $bd->consultar($sql);
echo'<select name="cliente" id="cliente" style="width:'.$tamano.'px" '.$change.' required >
<option value="TODOS">Seleccione...</option>'; 
while($row02=$bd->obtener_fila($query,0)){
	echo '<option value="'.$row02[0].'">'.$row02[1].'</option>';
}
echo'</select>';
mysql_free_result($query);?>	