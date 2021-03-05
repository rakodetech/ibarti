<?php
define("SPECIALCONSTANT", true);
require  "../../../autentificacion/aut_config.inc.php";
require_once "../../../" . Funcion;
require_once  "../../../" . class_bdI;

class novedades_reporte
{
	private $datos;
	private $bd;


	function __construct()
	{
		$this->datos   = array();

		$this->bd = new Database;
	}

	public function llenar_estatus_pendiente($mod)
	{
		if ($mod == 1) {
			$where = "where control_notificaciones = 'T'";
		}
		if ($mod == 2) {
			$where = "";
		}
		$sql   = "SELECT codigo,descripcion FROM nov_status $where";
		$query = $this->bd->consultar($sql);
		while ($datos = $this->bd->obtener_fila($query)) {
			$this->datos[] = $datos;
		}
		return $this->datos;
	}

	//////////////////////////////////////////////////////
	////////////////////////////////////////////////////77
	public function obtener_cantidad_novedades_general($fecha_desde, $fecha_hasta, $perfil, $usuario, $estatus)
	{


		if ($estatus != "TODOS") {
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
		} else {
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


	public function llenar_departamentos()
	{
		$sql   = "SELECT codigo, descripcion from men_perfiles where men_perfiles.`status` <> 'F'";
		$query = $this->bd->consultar($sql);
		while ($datos = $this->bd->obtener_fila($query)) {
			$this->datos[] = $datos;
		}
		return $this->datos;
	}

	public function llenar_regiones()
	{
		$sql   = "SELECT codigo, descripcion from regiones where regiones.`status` <> 'F'";
		$query = $this->bd->consultar($sql);
		while ($datos = $this->bd->obtener_fila($query)) {
			$this->datos[] = $datos;
		}
		return $this->datos;
	}

	public function llenar_estados($region)
	{
		$sql   = "SELECT codigo, descripcion from estados where estados.`status` <> 'F'";
		if ($region !== '' && $region !== null && $region !== 'TODOS') {
			$sql .= " AND estados.cod_region = '$region' ";
		}
		$query = $this->bd->consultar($sql);
		while ($datos = $this->bd->obtener_fila($query)) {
			$this->datos[] = $datos;
		}
		return $this->datos;
	}

	public function llenar_ciudades($estado)
	{
		$sql   = "SELECT codigo, descripcion from ciudades where ciudades.`status` <> 'F'";
		if ($estado !== '' && $estado !== null  && $estado !== 'TODOS') {
			$sql .= " AND ciudades.cod_estado = '$estado' ";
		}
		$query = $this->bd->consultar($sql);
		while ($datos = $this->bd->obtener_fila($query)) {
			$this->datos[] = $datos;
		}
		return $this->datos;
	}

	public function llenar_tabla_novedades_generales($fecha_desde, $fecha_hasta, $depar, $estatus)
	{

		if ($estatus != "TODOS") {
			$where = "where men_usuarios.cod_perfil = men_perfiles.codigo
			and men_perfiles.codigo = nov_perfiles.cod_perfil
			and nov_status.codigo = '$estatus'
			and nov_procesos.cod_nov_status = nov_status.codigo

			";
		} else {
			$where = "where men_usuarios.cod_perfil = men_perfiles.codigo
			and men_perfiles.codigo = nov_perfiles.cod_perfil
			and nov_procesos.cod_nov_status = nov_status.codigo

			";
		}


		if ($depar != "TODOS") {
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
		} else {
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

	///////////////////////////////////////////////7
	public function obtener_cantidad_novedades_pendientes($perfil, $usuario, $estatus, $region, $estado, $ciudad)
	{


		if ($estatus != "TODOS") {
			$where = "WHERE  nov_procesos.cod_novedad = novedades.codigo and nov_procesos_det.cod_nov_proc = nov_procesos.codigo AND novedades.`status` = 'T' 
	
	
				
				AND novedades.cod_nov_clasif = nov_perfiles.cod_nov_clasif
				and nov_status.codigo = '$estatus'
				and nov_procesos.cod_nov_status = nov_status.codigo
				AND nov_perfiles.cod_perfil = '$perfil' 
	
					AND nov_procesos.cod_us_mod = men_usuarios.codigo
				and men_usuarios.status = 'T'
				
					and nov_procesos.cod_us_ing <> '$usuario'
						and nov_perfiles.respuesta = 'T'
						AND nov_procesos.cod_ubicacion = clientes_ubicacion.codigo
				";
		} else {
			$where = "WHERE  nov_procesos.cod_novedad = novedades.codigo and nov_procesos_det.cod_nov_proc = nov_procesos.codigo AND novedades.`status` = 'T'
				
							and nov_status.control_notificaciones = 'T'
							AND novedades.cod_nov_clasif = nov_perfiles.cod_nov_clasif
							and nov_procesos.cod_nov_status = nov_status.codigo
							AND nov_perfiles.cod_perfil = '$perfil' 
							AND nov_procesos.cod_us_mod = men_usuarios.codigo
							and men_usuarios.status = 'T'
					
						and nov_procesos.cod_us_ing <> '$usuario'
							and nov_perfiles.respuesta = 'T'
							AND nov_procesos.cod_ubicacion = clientes_ubicacion.codigo
				";
		}

		if ($region != '' && $region != null) {
			$where .= " AND clientes_ubicacion.cod_region = '$region' ";
		} else {
			$where .= " AND (men_usuarios.cod_region = NULL OR men_usuarios.cod_region = '') ";
		}

		if ($estado != '' && $estado != null) {
			$where .= " AND clientes_ubicacion.cod_estado = '$estado' ";
		} else {
			$where .= " AND (men_usuarios.cod_estado = NULL OR men_usuarios.cod_estado = '') ";
		}

		if ($ciudad != '' && $ciudad != null) {
			$where .= " AND clientes_ubicacion.cod_ciudad = '$ciudad' ";
		} else {
			$where .= " AND (men_usuarios.cod_ciudad = NULL OR men_usuarios.cod_ciudad = '') ";
		}


		$sql = "SELECT nov_procesos.codigo ,nov_status.descripcion as stat, concat(men_usuarios.nombre,' ',men_usuarios.apellido) nombre,nov_procesos_det.observacion, novedades.descripcion,nov_status.codigo cod_status,nov_procesos_det.fec_us_ing fecha, nov_procesos_det.cod_us_ing usuario
		FROM nov_procesos, clientes_ubicacion, nov_procesos_det,novedades,nov_perfiles, men_usuarios,nov_status
		$where
		GROUP BY nov_procesos.codigo
		ORDER BY stat ASC, fecha ASC ";

		$query = $this->bd->consultar($sql);
		while ($datos = $this->bd->obtener_fila($query)) {
			$this->datos[] = $datos;
		}
		return $this->datos;
	}

	///////////////////////////////////
	public function llenar_tabla_novedades_pendientes($depar, $estatus, $region, $estado, $ciudad)
	{

		if ($estatus != "TODOS") {
			$where = " where nov_status.codigo = '$estatus'
				men_usuarios.cod_perfil = men_perfiles.codigo
				AND men_perfiles.codigo = nov_perfiles.cod_perfil
				AND nov_status.control_notificaciones = 'T'
				AND nov_procesos.cod_nov_status = nov_status.codigo
	
				";
		} else {
			$where = " where men_usuarios.cod_perfil = men_perfiles.codigo
			AND men_perfiles.codigo = nov_perfiles.cod_perfil
			AND nov_status.control_notificaciones = 'T'
			AND nov_procesos.cod_nov_status = nov_status.codigo
	
				";
		}


		if ($depar != "TODOS") {
			$where .= "
				
				and nov_perfiles.cod_perfil = '$depar'
	
				AND novedades.`status` = 'T'
				AND novedades.cod_nov_clasif = nov_perfiles.cod_nov_clasif
				AND nov_procesos.cod_novedad = novedades.codigo
				AND nov_procesos.cod_us_ing <> men_usuarios.codigo
				AND nov_procesos_det.cod_nov_proc = nov_procesos.codigo
				AND nov_procesos.cod_us_mod IN (
					SELECT
						codigo
					FROM
						men_usuarios
					WHERE
						`status` = 'T'
				)
				AND nov_perfiles.respuesta = 'T'
				AND men_usuarios. STATUS = 'T'
				AND nov_procesos.cod_ubicacion = clientes_ubicacion.codigo
				";
		} else {
			$where .= "
			AND novedades.`status` = 'T'
			AND novedades.cod_nov_clasif = nov_perfiles.cod_nov_clasif
			AND nov_procesos.cod_novedad = novedades.codigo
			AND nov_procesos.cod_us_ing <> men_usuarios.codigo
			AND nov_procesos_det.cod_nov_proc = nov_procesos.codigo
			AND nov_procesos.cod_us_mod IN (
				SELECT
					codigo
				FROM
					men_usuarios
				WHERE
					`status` = 'T'
			)
			AND nov_perfiles.respuesta = 'T'
			AND men_usuarios. STATUS = 'T'
			AND nov_procesos.cod_ubicacion = clientes_ubicacion.codigo
	
				";
		}

		$where2 = $where;

		if ($region != 'TODOS') {
			$where .= " AND men_usuarios.cod_region = '$region' 
			AND nov_procesos.cod_ubicacion = clientes_ubicacion.codigo
			AND men_usuarios.cod_region = regiones.codigo
			AND men_usuarios.cod_region = clientes_ubicacion.cod_region ";

			$where2 .= " AND clientes_ubicacion.cod_region = '$region'  
			AND (men_usuarios.cod_region = '$region'  OR (men_usuarios.cod_region = NULL OR men_usuarios.cod_region = '')) ";
		} else {
			$where .= " AND nov_procesos.cod_ubicacion = clientes_ubicacion.codigo
			AND men_usuarios.cod_region = regiones.codigo
			AND men_usuarios.cod_region = clientes_ubicacion.cod_region ";
			//$where2 .= " AND (men_usuarios.cod_region = NULL OR men_usuarios.cod_region = '')";
		}
		if ($estado != 'TODOS') {
			$where .= " AND men_usuarios.cod_estado = '$estado' 
			AND nov_procesos.cod_ubicacion = clientes_ubicacion.codigo
			AND men_usuarios.cod_estado = estados.codigo
			AND men_usuarios.cod_estado = clientes_ubicacion.cod_estado ";

			$where2 .= " AND clientes_ubicacion.cod_estado = '$estado'  
			AND (men_usuarios.cod_estado = '$estado'  OR (men_usuarios.cod_estado = NULL OR men_usuarios.cod_estado = '')) ";
		} else {
			$where .= " AND nov_procesos.cod_ubicacion = clientes_ubicacion.codigo
			AND men_usuarios.cod_estado = estados.codigo
			AND men_usuarios.cod_estado = clientes_ubicacion.cod_estado ";

			//$where2 .= " AND (men_usuarios.cod_estado = NULL OR men_usuarios.cod_estado = '')";
		}


		if ($ciudad != 'TODOS') {
			$where .= " AND men_usuarios.cod_ciudad = '$ciudad' 
			AND nov_procesos.cod_ubicacion = clientes_ubicacion.codigo
			AND men_usuarios.cod_ciudad = estados.codigo
			AND men_usuarios.cod_ciudad = clientes_ubicacion.cod_ciudad ";

			$where2 .= " AND clientes_ubicacion.cod_ciudad = '$ciudad'  
			AND (men_usuarios.cod_ciudad = '$ciudad'  OR (men_usuarios.cod_ciudad = NULL OR men_usuarios.cod_ciudad = '')) ";
		} else {
			$where .= " AND  nov_procesos.cod_ubicacion = clientes_ubicacion.codigo
			AND men_usuarios.cod_ciudad = estados.codigo
			AND men_usuarios.cod_ciudad = clientes_ubicacion.cod_ciudad ";

			//$where2 .= " AND (men_usuarios.cod_ciudad = NULL OR men_usuarios.cod_ciudad = '')";
		}

		$sql   = "SELECT DISTINCT nov_procesos.codigo codigo_nov ,men_usuarios.codigo codigo_usuario,men_usuarios.cod_perfil,
			men_usuarios.cod_region,
						IFNULL(
							regiones.descripcion,
							'TODAS'
						) region,
						men_usuarios.cod_estado,
						IFNULL(
							estados.descripcion,
							'TODAS'
						) estado,
						men_usuarios.cod_ciudad,
						IFNULL(
							ciudades.descripcion,
							'TODAS'
						) ciudad,
				men_usuarios.codigo,men_usuarios.nombre , men_usuarios.apellido , men_perfiles.descripcion , men_usuarios.cedula , men_usuarios.codigo usuario 
			from 	men_usuarios
INNER JOIN regiones ON men_usuarios.cod_region = regiones.codigo

INNER JOIN estados ON men_usuarios.cod_estado = regiones.codigo

INNER JOIN ciudades ON men_usuarios.cod_ciudad = ciudades.codigo

INNER JOIN clientes_ubicacion ON men_usuarios.cod_region = clientes_ubicacion.cod_region
AND men_usuarios.cod_estado = clientes_ubicacion.cod_estado
AND men_usuarios.cod_ciudad = clientes_ubicacion.cod_ciudad,
 men_perfiles,
 nov_perfiles,
 nov_procesos_det,
 novedades,
 nov_procesos,
 nov_status
	
			$where ";

		$sql2 = " UNION SELECT DISTINCT nov_procesos.codigo codigo_nov ,men_usuarios.codigo codigo_usuario,men_usuarios.cod_perfil,
				men_usuarios.cod_region, 						IFNULL(
					regiones.descripcion,
					'TODAS'
				) region,
				men_usuarios.cod_estado,
				IFNULL(
					estados.descripcion,
					'TODAS'
				) estado,
				men_usuarios.cod_ciudad,
				IFNULL(
					ciudades.descripcion,
					'TODAS'
				) ciudad,
			men_usuarios.codigo,men_usuarios.nombre , men_usuarios.apellido , men_perfiles.descripcion , men_usuarios.cedula , men_usuarios.codigo usuario 
			from 	men_usuarios
			LEFT JOIN regiones ON men_usuarios.cod_region = regiones.codigo
			LEFT JOIN estados ON men_usuarios.cod_estado = estados.codigo
			LEFT JOIN ciudades ON men_usuarios.cod_ciudad = ciudades.codigo,
				men_perfiles,
				nov_perfiles,
				nov_procesos_det,
				novedades,
				nov_procesos,
				nov_status,
				clientes_ubicacion
	
			$where2

			ORDER BY nombre";

		$sqlunion = $sql . ' ' . $sql2;
		//return $sqlunion;

		$query = $this->bd->consultar($sqlunion);
		while ($datos = $this->bd->obtener_fila($query)) {
			$this->datos[] = $datos;
		}

		return $this->datos;
		//////////////////////////////////////////////////////7

	}
}
