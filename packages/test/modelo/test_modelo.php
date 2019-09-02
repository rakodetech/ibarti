<?php
define("SPECIALCONSTANT", true);
include_once('../../../funciones/funciones.php');
require  "../../../autentificacion/aut_config.inc.php";
require_once  "../../../".class_bdI;

class Test
{
	private $datos;
	private $bd;

	function __construct()
	{
		$this->datos   = array();
		$this->bd   = new DataBase();
	}

	public function get(){
		$sql = " SELECT * FROM test ORDER BY 1 ASC ";
    //    $query =  parent::consultar($sql);
		$query = $this->bd->consultar($sql);

		while ($datos= $this->bd->  obtener_fila($query)) {
			$this->datos[] = $datos;
		}
		return $this->datos;
	}

	public function inicio(){
		$this->datos = array('id' => '',  'descripcion' => '',
			'estado' => 'T');
		return $this->datos;
	}

	public function editar($cod){

		$sql = " SELECT *
		FROM test
		WHERE id = '$cod' ";

		$query = $this->bd->consultar($sql);
		return $this->datos = $this->bd->obtener_fila($query);
	}
}
?>
