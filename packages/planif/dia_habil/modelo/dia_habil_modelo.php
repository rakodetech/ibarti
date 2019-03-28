<?php
define("SPECIALCONSTANT", true);
include_once('../../../../funciones/funciones.php');
require("../../../../autentificacion/aut_config.inc.php");
require_once("../../../../".class_bdI);

class Dia_habil
{
	private $datos;
	private $dh;
	private $bd;
	//Agregue esta variable porque daba problemas al cargar la table 
	//con el metodo get() y la variable $datos
	private $getDatos;

	function __construct()
	{
		$this->datos   = array();
		$this->horario = array();
		$this->getDatos = array();
		$this->bd = new Database;
	}

	public function get(){
		$sql = " SELECT * FROM dias_habiles ORDER BY 2 ASC  ";
		$query = $this->bd->consultar($sql);
		while ($datos= $this->bd->  obtener_fila($query)) {
			$this->getDatos[] = $datos;
		}
		return $this->getDatos;
	}

	public function inicio(){
		$this->horario = array('codigo' => '',  'descripcion' => '',
			'cod_dias_tipo' => '', 'dias_tipo' => 'Seleccione...',
			'minutos_trabajo' => '', 'status' => 'T');
		return $this->horario;
	}

	public function editar($cod){

		$sql = " SELECT a.codigo, a.descripcion, a.cod_dias_tipo, b.descripcion dias_tipo,
		a.cod_us_ing, a.fec_us_ing, a.cod_us_mod, a.fec_us_mod,
		a.`status`
		FROM dias_habiles a  LEFT JOIN dias_tipo b ON b.dia = a.cod_dias_tipo
		WHERE a.codigo = '$cod'  ";

		$query = $this->bd->consultar($sql);
		return $this->horario = $this->bd->obtener_fila($query);
	}

	public function dias($cod)
	{
		$sql  = "SELECT a.* ,  IFNULL(b.cod_dias_tipo, 'FALSE') existe
		FROM turno_dias a LEFT JOIN dias_habiles_det b ON b.`cod_dias_habiles` = '$codigo'
		AND b.cod_dias_tipo = a.dia
		WHERE a.tipo = '$$cod' AND a.`status` = 'T'
		ORDER BY a.orden ASC";
		$query = $this->bd->consultar($sql);
		while ($datos= $this->bd->  obtener_fila($query)) {
			$this->datos[] = $datos;
		}
		return $this->datos;
	}

	public function dias_tipo($cod)
	{
		$sql = "	SELECT dias_tipo.dia, dias_tipo.descripcion
		FROM dias_tipo
		WHERE dias_tipo.tipo = 'TIPO' AND dias_tipo.dia  <> '$cod'
		ORDER BY dias_tipo.orden ASC";
		$query = $this->bd->consultar($sql);

		while ($datos= $this->bd->  obtener_fila($query)) {
			$this->datos[] = $datos;
		}
		return $this->datos;
	}



	public function dias_det($cod, $cod_dia_tipo)
	{
		$sql  = "SELECT a.* ,  IFNULL(b.cod_dias_tipo, 'FALSE') existe
		FROM dias_tipo a LEFT JOIN dias_habiles_det b ON b.`cod_dias_habiles` = '$cod'
		AND b.cod_dias_tipo = a.dia
		WHERE a.tipo = '$cod_dia_tipo' AND a.`status` = 'T'
		ORDER BY a.orden ASC";

		$query = $this->bd->consultar($sql);

		while ($datos= $this->bd->  obtener_fila($query))
		{
			$this->datos[] = $datos;
		}
		return $this->datos;
	}

	public function buscar_dia_habil($data,$filtro){
		$where="";
		if ($data) $where =" WHERE dias_habiles.$filtro LIKE '%$data%' ";

		$sql = "SELECT * FROM dias_habiles ".$where." ORDER BY 2 ASC";
		$query         = $this->bd->consultar($sql);

		while ($datos= $this->bd->obtener_fila($query)) {
			$this->datos[] = $datos;
		}
		return $this->datos;
	}

}
?>
