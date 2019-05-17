<?php
define("SPECIALCONSTANT", true);
include_once('../../../funciones/funciones.php');
require("../../../autentificacion/aut_config.inc.php");
require_once("../../../".class_bdI);
$bd = new DataBase();
$result = array();

	print_r(json_encode($result));
	return json_encode($result);



class Contratacion extends DataBase
{
	 private $datos = [];
	 private $obtener = [];

	function __construct(argument)
	{

	}

	function get_contracion(){

	}

	function set_contratacion(cod){

	}

}
?>
