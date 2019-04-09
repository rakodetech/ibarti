<?php
define("SPECIALCONSTANT", true);
include_once('../../../funciones/funciones.php');
require("../../../autentificacion/aut_config.inc.php");
require_once("../../../".class_bdI);

class FichaDotacion
{
	private $datos;
	private $propiedades;
	private $lineas;
	private $bd;

	function __construct()
	{
		$this->datos     = array();
		$this->dotacion     = array();
		$this->lineas     = array();
		$this->bd        = new Database;
	}

	public function get_lineas(){
		$sql = "SELECT codigo, descripcion FROM prod_lineas
		WHERE  status = 'T'
		ORDER BY descripcion ASC";
		$query = $this->bd->consultar($sql);
		while ($datos= $this->bd->obtener_fila($query)) {
			$this->lineas[] = $datos;
		}
		return $this->lineas;
	} 

	public function get_sub_lineas($codigo){
		$sql = "SELECT codigo, descripcion FROM prod_sub_lineas
		WHERE  status = 'T' AND cod_linea = '$codigo'
		ORDER BY descripcion ASC";
		$query = $this->bd->consultar($sql);
		while ($datos= $this->bd->obtener_fila($query)) {
			$this->lineas[] = $datos;
		}
		return $this->lineas;
	} 

	public function get_productos($linea,$sub_linea){
		$sql = "SELECT codigo, descripcion FROM productos
		WHERE  status = 'T' AND cod_linea = '$linea' 
		AND cod_sub_linea = '$sub_linea'
		ORDER BY descripcion ASC";
		$query = $this->bd->consultar($sql);
		while ($datos= $this->bd->obtener_fila($query)) {
			$this->lineas[] = $datos;
		}
		return $this->lineas;
	} 


	public function cargar_dotacion($codigo){
		$sql = "select * from ficha_dotacion
		WHERE  cod_ficha = '$codigo'
		ORDER BY 2 ASC";
		$query = $this->bd->consultar($sql);
		while ($datos= $this->bd->obtener_fila($query)) {
			$this->dotacion[] = $datos;
		}
		return $this->dotacion;
	} 
}
?>