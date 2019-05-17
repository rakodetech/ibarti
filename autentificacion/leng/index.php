<?php
$bd = new DataBase();
$sql = " SELECT control.lenguaje FROM control ";
$query = $bd->consultar($sql);
$datosX=$bd->obtener_fila($query,0);
require ''.$datosX[0].'';
?>
