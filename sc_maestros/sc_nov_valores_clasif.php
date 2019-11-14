<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<title>Documento sin t&iacute;tulo</title>
</head>
<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../" . class_bd);
$bd = new DataBase();
//include_once('../funciones/mensaje_error.php');
$tabla    = $_POST['tabla'];
$tabla_id = 'codigo';

$codigo       = htmlspecialchars($_POST['codigo']);

$descripcion  = htmlspecialchars($_POST["descripcion"]);

$activo       = statusbd($_POST['activo']);

$cp01         = "";
$cp02         = "";
$cp03         = "";
$cp04         = "";

$href         = $_POST['href'];
$usuario      = $_POST['usuario'];

$metodo       = $_POST['metodo'];

if ($metodo != 'modificar') {
	$sql = "INSERT INTO nov_valores_clasif(
	codigo,
	descripcion,
	cod_us_ing,
	fec_us_ing,
	cod_us_mod,
	fec_us_mod,
	status
	) VALUES 
	('$codigo',
	'$descripcion',
	'$usuario',
	'" . date("Y-m-d") . "',
	'$usuario',
	'" . date("Y-m-d") . "','T'
	)";
} else {
	$sql = "UPDATE nov_valores_clasif SET
			descripcion = '$descripcion',
			cod_us_mod = '$usuario',
			fec_us_mod = '".date("Y-m-d")."'
			WHERE codigo = '$codigo'
	";
};
$query    = $bd->consultar($sql);

require_once('../funciones/sc_direccionar.php');
?>

<body>
</body>

</html>