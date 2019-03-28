<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<title>Reporte de Ficha de Trabajador</title>
</head>
<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase();

$reporte = $_POST["reporte"];
$cedula   = $_POST["trabajador"];

	if(isset($_POST['trabajador'])){

 	  $sql = "SELECT * FROM v_rp_preingreso WHERE v_rp_preingreso.cedula = '$cedula' ";

	$query = $bd->consultar($sql);
	$result =$bd->obtener_fila($query,0);
	extract($result);

	 	  $sql02 = "SELECT REPLACE(men_reportes_html.html, '&quot;', '\'') AS html
                    FROM men_reportes_html
                   WHERE men_reportes_html.codigo = $reporte ";
	$query02  = $bd->consultar($sql02);
	$result02 = $bd->obtener_fila($query02,0);

 	$html =  html_entity_decode($result02['html']);
	eval("\$html = \"$html\";");
	echo $html. "\n";
	}
?>
<body>
</body>
</html>
