<?php 
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase();

$link     = $_POST["link"]; 
$ci       = $_POST["ci"]; 
$ficha    = $_POST["ficha"]; 
$doc      = $_POST["doc"];

	$sql = " UPDATE ficha_documentos SET link = '$link'
			  WHERE ficha_documentos.cod_ficha  = '$ficha'
                AND ficha_documentos.cod_documento = '$doc' ";
	$query = $bd->consultar($sql);
	
?>