<?php
require("../autentificacion/aut_config.inc.php");
require_once("../" . class_bd);
$bd = new DataBase();

$link     = $_POST["link"];
$cliente    = $_POST["cliente"];
$doc      = $_POST["doc"];

$sql = " UPDATE clientes_documentos SET link = '$link'
			  WHERE clientes_documentos.cod_cliente  = '$cliente'
                AND clientes_documentos.cod_documento = '$doc' ";
$query = $bd->consultar($sql);
