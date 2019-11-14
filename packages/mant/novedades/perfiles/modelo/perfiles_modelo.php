<?php
define("SPECIALCONSTANT", true);
require  "../../../../../autentificacion/aut_config.inc.php";
require_once "../../../../../".Funcion;
require_once  "../../../../../".class_bdI;

class novPerfiles{
	
	private $datos;
	private $bd;

	function __construct(){
		$this->datos   = array();
		$this->bd = new Database;
	}

	public function get($clasificacion){
		$sql   = "SELECT men_perfiles.codigo, men_perfiles.descripcion,
	               IFNULL(nov_perfiles.cod_nov_clasif, 'NO') AS existe,
	               nov_perfiles.ingreso, nov_perfiles.respuesta, nov_perfiles.`status`
              FROM men_perfiles LEFT JOIN nov_perfiles 
			    ON men_perfiles.codigo = nov_perfiles.cod_perfil AND nov_perfiles.cod_nov_clasif = '$clasificacion'
             WHERE men_perfiles.`status` = 'T'
	         ORDER BY 2 ASC";
		$query = $this->bd->consultar($sql);
		while ($datos = $this->bd->obtener_fila($query)) {
			$this->datos[] = $datos;
		}
		return $this->datos;
	}

	public function get_clasif(){
		$sql   = "SELECT codigo, descripcion FROM nov_clasif WHERE nov_clasif.`status` = 'T'";
		$query = $this->bd->consultar($sql);
		while ($datos = $this->bd->obtener_fila($query)) {
			$this->datos[] = $datos;
		}
		return $this->datos;
	}

}

?>
