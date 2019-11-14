<?php
define("SPECIALCONSTANT", true);
require  "../../../../autentificacion/aut_config.inc.php";
require_once "../../../../".Funcion;
require_once  "../../../../".class_bdI;

class reporte_usuario_menu{
	
	private $datos;
	private $bd;

	function __construct(){
		$this->datos   = array();
		$this->bd = new Database;
	}

	public function generar($perfil,$modulo,$seccion){
		$where = ' WHERE men_perfil_menu.cod_men_perfil = men_perfiles.codigo
		AND men_perfil_menu.cod_menu_modulo = men_modulos.codigo
		AND men_perfil_menu.cod_men_principal = men_principal.codigo
		AND men_perfil_menu.cod_menu = men_menu.codigo';
		if($perfil != 'TODOS'){
			$where .= " AND men_perfiles.codigo = '$perfil' ";
		}
		
		if($modulo != 'TODOS'){
			$where .= " AND men_modulos.codigo = '$modulo' ";
		}

		if($seccion!= 'TODOS'){
			$where .= "AND men_principal.codigo = '$seccion'";
		}

		$sql   = "SELECT men_perfiles.codigo ,men_perfiles.descripcion perfil,men_modulos.descripcion modulo, men_principal.descripcion seccion,men_menu.descripcion menu,if (men_perfil_menu.agregar = 'true', 'SI','NO') agregar , if (men_perfil_menu.modificar = 'true' ,'SI','NO')modificar,if(men_perfil_menu.eliminar ='true','SI','NO') eliminar, if(men_perfil_menu.consultar = 'true','SI','NO') consultar
			FROM men_perfil_menu, men_perfiles, men_modulos, men_principal, men_menu
			$where
			ORDER BY 1,2,3 ";
		$query = $this->bd->consultar($sql);
		while ($datos = $this->bd->obtener_fila($query)) {
			$this->datos[] = $datos;
		}
		return $this->datos;
	}

	public function get_modulos($perfil){
		$where = ' WHERE men_perfil_menu.cod_menu_modulo = men_modulos.codigo';
		if($perfil != 'TODOS'){
			$where .= " AND men_perfil_menu.cod_men_perfil = '$perfil' ";
		}

		$sql   = "SELECT men_modulos.codigo, men_modulos.descripcion
		FROM men_perfil_menu, men_modulos
		$where
		GROUP BY 1
		ORDER BY 2 ASC";
		$query = $this->bd->consultar($sql);
		while ($datos = $this->bd->obtener_fila($query)) {
			$this->datos[] = $datos;
		}
		return $this->datos;
	}

	public function get_seccion($perfil,$modulo){
		$where = ' WHERE men_perfil_menu.cod_menu_modulo = men_modulos.codigo
					AND men_perfil_menu.cod_men_principal = men_principal.codigo';
		if($perfil != 'TODOS'){
			$where .= " AND men_perfil_menu.cod_men_perfil = '$perfil' ";
		}
		if($modulo != 'TODOS'){
			$where .= " AND men_perfil_menu.cod_menu_modulo = '$modulo' ";
		}

		$sql   = "SELECT men_principal.codigo, men_principal.descripcion
		FROM men_perfil_menu, men_modulos,men_principal
		$where
		GROUP BY 1
		ORDER BY 2 ASC";
		$query = $this->bd->consultar($sql);
		while ($datos = $this->bd->obtener_fila($query)) {
			$this->datos[] = $datos;
		}
		return $this->datos;
	}

///
	public function get_clasifi(){
		$where = ' WHERE nov_clasif.status = "T"';
		$sql   = "SELECT nov_clasif.codigo, nov_clasif.descripcion
		FROM nov_clasif
		$where
		ORDER BY 1 ASC";
		$query = $this->bd->consultar($sql);
		while ($datos = $this->bd->obtener_fila($query)) {
			$this->datos[] = $datos;
		}
		return $this->datos;
	}
///
	public function get_perfiles(){
		$sql   = "SELECT codigo, descripcion from men_perfiles where men_perfiles.`status` = 'T'";
		$query = $this->bd->consultar($sql);
		while ($datos = $this->bd->obtener_fila($query)) {
			$this->datos[] = $datos;
		}
		return $this->datos;
	}

		public function llenar_usuario_novedad($check,$perfil,$clasif){
		$where = '';
		if($check != 'TODOS'){
			$where.= " AND nov_clasif.campo04 = '$check'";
		}
		if($perfil != 'TODOS'){
			$where .= "AND men_perfiles.codigo = '$perfil'";
		}

		if($clasif !='TODOS'){
			$where .= "AND nov_clasif.codigo = '$clasif'";
		}

		$sql = "SELECT men_perfiles.codigo,men_perfiles.codigo,men_perfiles.descripcion perfil,if(nov_perfiles.ingreso = 'T','SI','NO') ingreso,if(nov_perfiles.respuesta = 'T','SI','NO') respuesta, nov_clasif.descripcion modulo , nov_tipo.descripcion seccion, novedades.descripcion menu
			from men_perfiles,nov_clasif,nov_perfiles,novedades,nov_tipo
			where nov_perfiles.cod_perfil = men_perfiles.codigo
			and nov_perfiles.cod_nov_clasif = nov_clasif.codigo
			and nov_perfiles.`status` = 'T'
			and novedades.cod_nov_clasif =nov_clasif.codigo
			and nov_tipo.codigo = novedades.cod_nov_tipo
			$where
			";
		$query = $this->bd->consultar($sql);
		while ($datos = $this->bd->obtener_fila($query)) {
			$this->datos[] = $datos;
		}
		return $this->datos;
	}

}

?>
