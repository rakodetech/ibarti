<?php
define("SPECIALCONSTANT", true);
require  "../../../../autentificacion/aut_config.inc.php";
require_once "../../../../" . Funcion;
require_once  "../../../../" . class_bdI;

class PerfilCargos
{

	private $datos;
	private $bd;

	function __construct()
	{
		$this->datos   = array();
		$this->bd = new Database;
	}

	public function get($perfil)
	{
		$sql   = "SELECT cargos.codigo, cargos.descripcion,
	               IFNULL(planif_perfil_cargos.cod_cargo, 'NO') AS existe, planif_perfil_cargos.`status`
              FROM cargos LEFT JOIN planif_perfil_cargos 
			    ON cargos.codigo = planif_perfil_cargos.cod_cargo AND planif_perfil_cargos.cod_perfil = '$perfil'
             WHERE cargos.`status` = 'T'
	         ORDER BY 2 ASC";
		$query = $this->bd->consultar($sql);
		while ($datos = $this->bd->obtener_fila($query)) {
			$this->datos[] = $datos;
		}
		return $this->datos;
	}

	public function get_perfiles()
	{
		$sql   = "SELECT codigo, descripcion FROM men_perfiles WHERE men_perfiles.`status` = 'T'";
		$query = $this->bd->consultar($sql);
		while ($datos = $this->bd->obtener_fila($query)) {
			$this->datos[] = $datos;
		}
		return $this->datos;
	}
}
