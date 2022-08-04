<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../" . class_bd);
$bd = new DataBase();
$codigo      = $_POST['codigo'];

$sql = "SELECT  clientes_ubicacion.contacto, clientes_ubicacion.campo04
			  FROM clientes_ubicacion 
			 WHERE clientes_ubicacion.codigo = '$codigo' ";

$query = $bd->consultar($sql);
$row02 = $bd->obtener_fila($query, 0);

echo '<input type="hidden" id="cl_ubic_contato" value="' . $row02[0] . '" />
			  <input type="hidden" id="cl_ubic_campo_04" value="' . $row02[1] . '" />';
