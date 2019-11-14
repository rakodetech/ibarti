<?php
define("SPECIALCONSTANT", true);
require  "../../../autentificacion/aut_config.inc.php";
require_once "../../../".Funcion;
require_once  "../../../".class_bdI;

class novedades_reporte
{
	private $datos;
	private $bd;
	

	function __construct()
	{
		$this->datos   = array();
		
		$this->bd = new Database;
	}

	public function llenar_estatus_pendiente($mod){
		if ($mod == 1){
			$where = "where control_notificaciones = 'T'"; 
		}
		if($mod == 2){
			$where = "";
		}
		$sql   = "SELECT codigo,descripcion FROM nov_status $where";
		$query = $this->bd->consultar($sql);
		while ($datos = $this->bd->obtener_fila($query)) {
			$this->datos[] = $datos;
		}
		return $this->datos;
	}
///////////////////////////////////////////////7
	public function obtener_cantidad_novedades_pendientes($perfil,$usuario,$estatus){


		if ($estatus !="TODOS"){
			$where = "WHERE  nov_procesos.cod_novedad = novedades.codigo and nov_procesos_det.cod_nov_proc = nov_procesos.codigo AND novedades.`status` = 'T' 


			
			AND novedades.cod_nov_clasif = nov_perfiles.cod_nov_clasif
			and nov_status.codigo = '$estatus'
			and nov_procesos.cod_nov_status = nov_status.codigo
			AND nov_perfiles.cod_perfil = '$perfil' 

				AND nov_procesos.cod_us_mod = men_usuarios.codigo
			and men_usuarios.status = 'T'
			
				and nov_procesos.cod_us_ing <> '$usuario'
					and nov_perfiles.respuesta = 'T'
			";
		}else{
			$where = "WHERE  nov_procesos.cod_novedad = novedades.codigo and nov_procesos_det.cod_nov_proc = nov_procesos.codigo AND novedades.`status` = 'T'
			
						and nov_status.control_notificaciones = 'T'
						AND novedades.cod_nov_clasif = nov_perfiles.cod_nov_clasif
						and nov_procesos.cod_nov_status = nov_status.codigo
						AND nov_perfiles.cod_perfil = '$perfil' 
						AND nov_procesos.cod_us_mod = men_usuarios.codigo
						and men_usuarios.status = 'T'
				
					and nov_procesos.cod_us_ing <> '$usuario'
						and nov_perfiles.respuesta = 'T'
			";
		}



		$sql = "SELECT nov_procesos.codigo ,nov_status.descripcion as stat, concat(men_usuarios.nombre,' ',men_usuarios.apellido) nombre,nov_procesos_det.observacion, novedades.descripcion,nov_status.codigo cod_status,nov_procesos_det.fec_us_ing fecha, nov_procesos_det.cod_us_ing usuario
		FROM nov_procesos,nov_procesos_det,novedades,nov_perfiles, men_usuarios,nov_status
		$where
		GROUP BY nov_procesos.codigo
		ORDER BY nov_status.codigo ASC,nov_procesos_det.fec_us_ing ASC 
		";
		$query = $this->bd->consultar($sql);
		while ($datos = $this->bd->obtener_fila($query)) {
			$this->datos[] = $datos;
		}
		return $this->datos;
	}
//////////////////////////////////////////////////////
////////////////////////////////////////////////////77
	public function obtener_cantidad_novedades_general($fecha_desde,$fecha_hasta,$perfil,$usuario,$estatus){


		if ($estatus !="TODOS"){
			$where = "WHERE  nov_procesos.cod_novedad = novedades.codigo and nov_procesos_det.cod_nov_proc = nov_procesos.codigo AND novedades.`status` = 'T'	
			and nov_procesos.fec_us_mod BETWEEN '$fecha_desde' and '$fecha_hasta'
			AND novedades.cod_nov_clasif = nov_perfiles.cod_nov_clasif
			and nov_procesos.cod_nov_status = nov_status.codigo
			AND nov_perfiles.cod_perfil = '$perfil' 
			and nov_status.codigo  = '$estatus'
			AND nov_procesos.cod_us_mod = men_usuarios.codigo
			and men_usuarios.status = 'T'
		
			and nov_perfiles.respuesta = 'T'
			";
		}else{
			$where = "
			WHERE  nov_procesos.cod_novedad = novedades.codigo and nov_procesos_det.cod_nov_proc = nov_procesos.codigo AND novedades.`status` = 'T'	
			and nov_procesos.fec_us_mod BETWEEN '$fecha_desde' and '$fecha_hasta'
			AND novedades.cod_nov_clasif = nov_perfiles.cod_nov_clasif
			and nov_procesos.cod_nov_status = nov_status.codigo
			AND nov_perfiles.cod_perfil = '$perfil' 
			AND nov_procesos.cod_us_mod = men_usuarios.codigo
			and men_usuarios.status = 'T'
			and nov_perfiles.respuesta = 'T'
			";
		}



		$sql = "SELECT nov_procesos.codigo ,nov_status.descripcion as stat, concat(men_usuarios.nombre,' ',men_usuarios.apellido) nombre,nov_procesos_det.observacion, novedades.descripcion,nov_status.codigo cod_status,nov_procesos_det.fec_us_ing fecha, nov_procesos_det.cod_us_ing usuario
		FROM nov_procesos,nov_procesos_det,novedades,nov_perfiles, men_usuarios,nov_status
		$where
		GROUP BY nov_procesos.codigo
		ORDER BY nov_status.codigo ASC,nov_procesos_det.fec_us_ing ASC
		";
		$query = $this->bd->consultar($sql);
		while ($datos = $this->bd->obtener_fila($query)) {
			$this->datos[] = $datos;
		}
		return $this->datos;
	}

	/////////////////////////////////////////77


	public function llenar_departamentos(){
		$sql   = "SELECT codigo, descripcion from men_perfiles where men_perfiles.`status` <> 'F'";
		$query = $this->bd->consultar($sql);
		while ($datos = $this->bd->obtener_fila($query)) {
			$this->datos[] = $datos;
		}
		return $this->datos;
	}

///////////////////////////////////
	public function llenar_tabla_novedades_pendientes($depar,$estatus){

		if($estatus != "TODOS"){
			$where = "where men_usuarios.cod_perfil = men_perfiles.codigo
			and men_perfiles.codigo = nov_perfiles.cod_perfil
			and nov_status.codigo = '$estatus'
			and nov_procesos.cod_nov_status = nov_status.codigo

			";
		}else{
			$where = "where men_usuarios.cod_perfil = men_perfiles.codigo
			and men_perfiles.codigo = nov_perfiles.cod_perfil
			and nov_status.control_notificaciones = 'T'
			and nov_procesos.cod_nov_status = nov_status.codigo

			";
		}


		if($depar != "TODOS"){
			$where .= "
			
			and nov_perfiles.cod_perfil = '$depar'

			and novedades.`status` = 'T'
			and novedades.cod_nov_clasif = nov_perfiles.cod_nov_clasif
			and nov_procesos.cod_novedad = novedades.codigo
		
					and nov_procesos.cod_us_ing <> men_usuarios.codigo
			and nov_procesos_det.cod_nov_proc = nov_procesos.codigo

			and nov_procesos.cod_us_mod in (SELECT codigo from men_usuarios where `status` = 'T')
			and nov_perfiles.respuesta = 'T'
			and men_usuarios.status='T'
			";
		}else{
			$where .= "
			and novedades.`status` = 'T'
			and novedades.cod_nov_clasif = nov_perfiles.cod_nov_clasif
			and nov_procesos.cod_novedad = novedades.codigo
		
					and nov_procesos.cod_us_ing <> men_usuarios.codigo
			and nov_procesos_det.cod_nov_proc = nov_procesos.codigo

			and nov_procesos.cod_us_mod in (SELECT codigo from men_usuarios where `status` = 'T')
			and nov_perfiles.respuesta = 'T'
			and men_usuarios.status='T'

			";
		}


		$sql   = "SELECT DISTINCT nov_procesos.codigo codigo_nov ,men_usuarios.codigo codigo_usuario,men_usuarios.cod_perfil,men_usuarios.codigo,men_usuarios.nombre , men_usuarios.apellido , men_perfiles.descripcion , men_usuarios.cedula , men_usuarios.codigo usuario 
		from men_usuarios, men_perfiles, nov_perfiles, nov_procesos_det, novedades, nov_procesos ,nov_status

		$where

		
		ORDER BY men_usuarios.nombre";

		$query = $this->bd->consultar($sql);
		while ($datos = $this->bd->obtener_fila($query)) {
			$this->datos[] = $datos;
		}

		return $this->datos;
//////////////////////////////////////////////////////7

	}

	public function llenar_tabla_novedades_generales($fecha_desde,$fecha_hasta,$depar,$estatus){

		if($estatus != "TODOS"){
			$where = "where men_usuarios.cod_perfil = men_perfiles.codigo
			and men_perfiles.codigo = nov_perfiles.cod_perfil
			and nov_status.codigo = '$estatus'
			and nov_procesos.cod_nov_status = nov_status.codigo

			";
		}else{
			$where = "where men_usuarios.cod_perfil = men_perfiles.codigo
			and men_perfiles.codigo = nov_perfiles.cod_perfil
			and nov_procesos.cod_nov_status = nov_status.codigo

			";
		}


		if($depar != "TODOS"){
			$where .= "
			and nov_perfiles.cod_perfil = '$depar'

			and novedades.`status` = 'T'
			and novedades.cod_nov_clasif = nov_perfiles.cod_nov_clasif
			and nov_procesos.cod_novedad = novedades.codigo
	
			and nov_procesos_det.cod_nov_proc = nov_procesos.codigo
			and nov_procesos_det.fec_us_ing BETWEEN '$fecha_desde' and '$fecha_hasta'
			and nov_procesos.cod_us_mod in (SELECT codigo from men_usuarios where `status` = 'T')
			and nov_perfiles.respuesta = 'T'
			and men_usuarios.status='T'

			";
		}else{
			$where .= "
			and novedades.`status` = 'T'
			and novedades.cod_nov_clasif = nov_perfiles.cod_nov_clasif
			and nov_procesos.cod_novedad = novedades.codigo
	
			and nov_procesos_det.cod_nov_proc = nov_procesos.codigo
			and nov_procesos_det.fec_us_ing BETWEEN '$fecha_desde' and '$fecha_hasta'
			and nov_procesos.cod_us_mod in (SELECT codigo from men_usuarios where `status` = 'T')
			and nov_perfiles.respuesta = 'T'
			and men_usuarios.status='T'

			";
		}



		$sql   = "SELECT DISTINCT nov_procesos.codigo codigo_nov ,men_usuarios.codigo codigo_usuario,men_usuarios.cod_perfil,men_usuarios.codigo,men_usuarios.nombre , men_usuarios.apellido , men_perfiles.descripcion , men_usuarios.cedula , men_usuarios.codigo usuario 
		from men_usuarios, men_perfiles, nov_perfiles, nov_procesos_det, novedades, nov_procesos ,nov_status

		$where

		
		ORDER BY men_usuarios.nombre";

		$query = $this->bd->consultar($sql);
		while ($datos = $this->bd->obtener_fila($query)) {
			$this->datos[] = $datos;
		}

		return $this->datos;


	}
}



?>
