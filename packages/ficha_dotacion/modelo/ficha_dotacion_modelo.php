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

	public function get_dot_reng($ficha){
		$sql = "SELECT prod_lineas.codigo, prod_lineas.descripcion,prod_sub_lineas.codigo, prod_sub_lineas.descripcion,ficha_dotacion.cantidad, ficha_dotacion.cod_ficha,tallas.descripcion
		FROM ficha_dotacion, prod_lineas,prod_sub_lineas, tallas
		WHERE ficha_dotacion.cod_ficha = '$ficha' 
		AND prod_sub_lineas.codigo = ficha_dotacion.cod_sub_linea
		AND prod_sub_lineas.cod_linea = prod_lineas.codigo
		AND tallas.codigo = ficha_dotacion.cod_talla
		ORDER BY ficha_dotacion.fec_us_mod ASC";
		$query = $this->bd->consultar($sql);
		while ($datos= $this->bd->obtener_fila($query)) {
			$this->datos[] = $datos;
		}
		return $this->datos;
	}

	public function get_tallas($linea,$sub_linea){
		$sql = "SELECT talla FROM prod_sub_lineas WHERE cod_linea = '$linea' AND codigo = '$sub_linea'";
		$query = $this->bd->consultar($sql);
		$data= $this->bd->obtener_fila($query);
		if($data[0] == 'T'){
			$sql = "SELECT tallas.codigo, tallas.descripcion  FROM tallas
					WHERE tallas.codigo != '9999'
					ORDER BY tallas. descripcion ASC";
			$query = $this->bd->consultar($sql);
			while ($datos= $this->bd->obtener_fila($query)) {
				$this->lineas[] = $datos;
			}

			return $this->lineas;
		}else{
			return [];
		}

	} 

	public function validar_sub_linea($linea,$sub_linea){
		$sql = "SELECT talla FROM prod_sub_lineas WHERE cod_linea = '$linea' AND codigo = '$sub_linea'";
		$query = $this->bd->consultar($sql);
		return  $this->datos = $this->bd->obtener_fila($query);
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