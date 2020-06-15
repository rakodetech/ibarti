<?php
define("SPECIALCONSTANT", true);
include_once('../../../../funciones/funciones.php');
require("../../../../autentificacion/aut_config.inc.php");
require_once("../../../../" . class_bdI);

class Planificacion
{
	private $datos;
	private $bd;

	function __construct()
	{
		$this->datos   = array();
		$this->bd = new Database;
	}

	function get_cliente()
	{
		$sql = "  SELECT clientes.codigo, IF(COUNT(clientes_contratacion.codigo) = 0, 'S/P - ' , '') sc,
		clientes.abrev, clientes.nombre cliente
		FROM clientes LEFT JOIN clientes_contratacion ON clientes.codigo = clientes_contratacion.cod_cliente
		WHERE clientes.`status` = 'T'
		GROUP BY clientes.codigo ORDER BY 2 ASC ";

		$query = $this->bd->consultar($sql);

		while ($datos = $this->bd->obtener_fila($query)) {
			$this->datos[] = $datos;
		}
		return $this->datos;
	}

	function replicar_rot($cliente, $ubic, $contratacion, $apertura, $usuario)
	{
		$sql = "CALL p_planif_serv_rotacion('$cliente','$ubic',$contratacion,$apertura,'$usuario');";
		$query = $this->bd->consultar($sql);
		return $query;
	}

	function get_cl_contrato($cliente)
	{

		$sql = "SELECT a.codigo, a.descripcion, a.fecha_inicio, a.fecha_fin FROM clientes_contratacion a
		WHERE a.cod_cliente = '$cliente' AND a.`status` = 'T'
		ORDER BY 1 DESC;";
		$query = $this->bd->consultar($sql);
		if ($this->bd->obtener_num($query) > 0) {
			$query = $this->bd->consultar($sql);
			while ($datos = $this->bd->obtener_fila($query)) {
				$this->datos[] = $datos;
			}
		} else {
			$this->datos[] = array('codigo' => '', 'descripcion' => 'Sin Contrato');
		}
		return $this->datos;
	}

	function get_planif_ap($apertura)
	{
		$this->datos  = array();
		$sql = " SELECT a.codigo, a.fecha_inicio, a.fecha_fin, a.`status`
		FROM planif_clientes_superv a
		WHERE a.codigo = '$apertura' ";
		$query = $this->bd->consultar($sql);
		return $this->datos = $this->bd->obtener_fila($query);
	}

	function get_planif_apertura($cliente)
	{
		$this->datos  = array();
		$sql = "SELECT a.*, CONCAT(b.apellido,' ', b.nombre) us_mod
		FROM planif_clientes_superv a LEFT JOIN men_usuarios b ON a.cod_us_mod = b.codigo
		WHERE a.cod_cliente = '$cliente'
		ORDER BY 1 DESC";
		$query = $this->bd->consultar($sql);

		while ($datos = $this->bd->obtener_fila($query)) {
			$this->datos[] = $datos;
		}
		return $this->datos;
	}


	function get_planif_act($cliente)
	{
		$this->datos = array();
		$sql = "SELECT a.* FROM planif_clientes_superv a
		WHERE a.`status` = 'T' AND a.cod_cliente = '$cliente'
		ORDER BY 1 DESC;";
		$query    = $this->bd->consultar($sql);

		$query = $this->bd->consultar($sql);
		while ($datos = $this->bd->obtener_fila($query)) {
			$this->datos[] = $datos;
		}
		return $this->datos;
	}

	function get_planif_ap_ubic($cliente)
	{
		$this->datos  = array();
		$sql = "SELECT b.cod_ubicacion, c.descripcion
		FROM  clientes_supervision b , clientes_ubicacion c
		WHERE b.cod_ubicacion = c.codigo
		AND c.cod_cliente = '$cliente'
		AND c.`status` = 'T'
		GROUP BY b.cod_ubicacion ORDER BY c.descripcion DESC ";

		$query = $this->bd->consultar($sql);
		while ($datos = $this->bd->obtener_fila($query)) {
			$this->datos[] = $datos;
		}
		return $this->datos;
	}

	function get_planif_ap_inicio($cliente)
	{
		$this->datos  = array();
		$sql = "SELECT a.codigo, IFNULL (DATE_ADD(fecha_fin, INTERVAL 1 DAY), CURDATE()) fecha_inicio
		FROM planif_clientes_superv a WHERE a.cod_cliente = '$cliente'
		ORDER BY a.codigo DESC LIMIT 0, 1; ";
		$query = $this->bd->consultar($sql);
		return $this->datos = $this->bd->obtener_fila($query);
	}

	function get_supervision_det($ubic)
	{
		$this->datos  = array();
		$sql = "SELECT b.descripcion ubicacion, d.abrev turno_abrev, d.descripcion turno, a.cantidad
		FROM clientes_supervision a, clientes_ubicacion b,	turno d
		WHERE a.cod_ubicacion = '$ubic'
		AND a.cod_ubicacion = b.codigo
		AND a.cod_turno = d.codigo ORDER BY 2 DESC ";

		$query = $this->bd->consultar($sql);
		while ($datos = $this->bd->obtener_fila($query)) {
			$this->datos[] = $datos;
		}
		return $this->datos;
	}

	function get_planif_det($apertura, $ubic)
	{

		$sql = "SELECT c.codigo, a.fecha_inicio ap_fecha_inicio,  a.fecha_fin ap_fecha_fin,
		b.cod_ficha, CONCAT (b.apellidos,' ',b.nombres,IF(d.cod_ficha,' (VETADO)','')) trabajador,
		c.cod_rotacion, (SELECT x.descripcion  FROM rotacion x WHERE x.codigo =  c.cod_rotacion) rotacion,
		c.posicion_inicio, RotTurno(c.cod_rotacion, c.posicion_inicio) turno,
		IFNULL(c.fecha_inicio, a.fecha_inicio) fecha_inicio, IFNULL(c.fecha_fin, a.fecha_fin) fecha_fin, IFNULL(d.cod_ficha,'NO') vetado
		FROM planif_clientes_superv a, ficha b LEFT JOIN planif_clientes_superv_trab c ON  b.cod_ficha = c.cod_ficha AND c.cod_planif_cl = '$apertura' LEFT JOIN clientes_vetados d ON  (c.cod_ficha = d.cod_ficha AND c.cod_ubicacion = d.cod_ubicacion) OR (b.cod_ficha = d.cod_ficha AND b.cod_ubicacion = d.cod_ubicacion) ,control
		WHERE a.codigo = '$apertura'
		AND b.cod_ubicacion = '$ubic'
		AND b.cod_ficha_status= control.ficha_activo
		UNION ALL
		SELECT b.codigo,  a.fecha_inicio ap_fecha_inicio,  a.fecha_fin ap_fecha_fin,
		b.cod_ficha, CONCAT (c.apellidos,' ',c.nombres,IF(d.cod_ficha,' (VETADO)','')) trabajador,
		b.cod_rotacion , rotacion.descripcion rotacion,
		b.posicion_inicio , RotTurno(b.cod_rotacion, b.posicion_inicio) turno,
		IFNULL(b.fecha_inicio, a.fecha_inicio) fecha_inicio, IFNULL(b.fecha_fin, a.fecha_fin) fecha_fin,IFNULL(d.cod_ficha,'NO') vetado
		FROM planif_clientes_superv a, planif_clientes_superv_trab b LEFT JOIN clientes_vetados d ON  b.cod_ficha = d.cod_ficha AND b.cod_ubicacion = d.cod_ubicacion, ficha c, rotacion
		WHERE a.codigo = '$apertura'
		AND a.codigo = b.cod_planif_cl
		AND b.cod_ficha = c.cod_ficha
		AND b.cod_ubicacion = '$ubic'
		AND b.cod_rotacion = rotacion.codigo
		AND b.cod_ubicacion != c.cod_ubicacion
		ORDER BY 4 ASC ;";

		$query = $this->bd->consultar($sql);
		while ($datos = $this->bd->obtener_fila($query)) {
			$this->datos[] = $datos;
		}
		return $this->datos;
	}

	function get_ultima_mod($apertura, $ubic)
	{

		$sql = "SELECT MAX(a.fec_us_mod) fecha,CONCAT(b.apellido,' ',b.nombre) us_mod
		FROM
		planif_clientes_superv_trab_det a
		INNER JOIN men_usuarios b ON a.cod_us_mod = b.codigo
		WHERE a.cod_planif_cl = '$apertura' AND a.cod_ubicacion = '$ubic'";

		$query = $this->bd->consultar($sql);
		return $datos = $this->bd->obtener_fila($query);
	}

	function get_planif_trab_ap($cod_pl_trab)
	{
		$this->datos  = array();
		$sql = "SELECT a.cod_planif_cl, planif_clientes_superv.fecha_inicio,
		planif_clientes_superv.fecha_fin, planif_clientes_superv.`status`,
		a.cod_cliente , clientes.nombre cliente, clientes.abrev cl_abrev,
		a.cod_ubicacion, clientes_ubicacion.descripcion ubicacion,
		a.cod_puesto_trabajo, clientes_ub_puesto.nombre AS puesto_trabajo,
		ficha.cod_ficha, CONCAT(ficha.apellidos,' ',ficha.nombres) ap_nombre,
		rotacion.abrev rotacion_abrev, rotacion.descripcion rotacion,
		IFNULL(b.cod_ficha,'NO') vetado
		FROM planif_clientes_superv_trab a LEFT JOIN clientes_vetados b ON  a.cod_ficha = b.cod_ficha
		AND a.cod_ubicacion = b.cod_ubicacion, planif_clientes_superv,  clientes_ub_puesto, ficha,
		clientes, clientes_ubicacion, rotacion
		WHERE a.codigo = '$cod_pl_trab'
		AND a.cod_planif_cl = planif_clientes_superv.codigo
		AND a.cod_puesto_trabajo =clientes_ub_puesto.codigo
		AND a.cod_ficha = ficha.cod_ficha
		AND a.cod_cliente = clientes.codigo
		AND a.cod_ubicacion = clientes_ubicacion.codigo
		AND a.cod_rotacion = rotacion.codigo";
		$query = $this->bd->consultar($sql);
		return $this->datos = $this->bd->obtener_fila($query);
	}

	function get_planif_trab_det($cod_pl_trab)
	{
		$this->datos  = array();
		$sql = "SELECT a.codigo, a.fecha, Dia_semana_abrev(a.fecha) d_semana,
		a.cod_cliente, clientes.abrev cliente,
		a.cod_ubicacion, clientes_ubicacion.descripcion ubicacion,
		a.cod_puesto_trabajo, clientes_ub_puesto.nombre puesto_trabajo,
		ficha.cod_ficha, CONCAT(ficha.apellidos,' ',ficha.nombres) ap_nombre,
		a.cod_turno,turno.abrev tuno_abrev, turno.descripcion turno
		FROM planif_clientes_superv_trab_det a, turno, clientes_ub_puesto, ficha, clientes, clientes_ubicacion
		WHERE a.cod_planif_cl_trab = '$cod_pl_trab'
		AND a.cod_turno = turno.codigo
		AND a.cod_puesto_trabajo =clientes_ub_puesto.codigo
		AND a.cod_ficha = ficha.cod_ficha
		AND a.cod_cliente = clientes.codigo
		AND a.cod_ubicacion = clientes_ubicacion.codigo
		ORDER BY a.fecha ASC";

		$query = $this->bd->consultar($sql);
		while ($datos = $this->bd->obtener_fila($query)) {
			$this->datos[] = $datos;
		}
		return $this->datos;
	}

	function get_planif_trabajador($aperuta, $ficha)
	{
		$this->datos  = array();
		$sql = "SELECT a.codigo, a.fecha, Dia_semana_abrev(a.fecha) d_semana,
		a.cod_cliente, clientes.abrev cliente,
		a.cod_ubicacion, clientes_ubicacion.descripcion ubicacion,
		a.cod_puesto_trabajo, clientes_ub_puesto.nombre puesto_trabajo,
		ficha.cod_ficha, CONCAT(ficha.apellidos,' ',ficha.nombres) ap_nombre,
		a.cod_turno,turno.abrev tuno_abrev, turno.descripcion turno
		FROM planif_clientes_superv_trab_det a, turno, clientes_ub_puesto, ficha, clientes, clientes_ubicacion
		WHERE a.cod_ficha = '$ficha'
		AND a.cod_turno = turno.codigo
		AND a.cod_puesto_trabajo =clientes_ub_puesto.codigo
		AND a.cod_ficha = ficha.cod_ficha
		AND a.cod_cliente = clientes.codigo
		AND a.cod_ubicacion = clientes_ubicacion.codigo
		ORDER BY a.fecha ASC";

		$query = $this->bd->consultar($sql);
		while ($datos = $this->bd->obtener_fila($query)) {
			$this->datos[] = $datos;
		}
		return $this->datos;
	}

	function generar_planif($apertura, $ubic)
	{
		$this->datos  = array();
		$sql = "DELETE FROM planif_clientes_superv_trab
		WHERE planif_clientes_superv_trab.cod_planif_cl = '$apertura'
		AND planif_clientes_superv_trab.cod_ubicacion = '$ubic' ";
		$query = $this->bd->consultar($sql);

		$sql = "DELETE FROM planif_clientes_superv_trab
		WHERE planif_clientes_superv_trab.cod_planif_cl = '$apertura'
		AND planif_clientes_superv_trab.cod_ubicacion = '$ubic' ";
		$query = $this->bd->consultar($sql);
	}

	function get_ubic_puesto($ubic)
	{
		$this->datos  = array();
		$sql = "SELECT a.codigo, 		a.nombre
		FROM clientes_ub_puesto AS a
		WHERE a.cod_cl_ubicacion = '$ubic'
		AND a.`status` = 'T'
		ORDER BY 2 DESC ";

		$query = $this->bd->consultar($sql);
		while ($datos = $this->bd->obtener_fila($query)) {
			$this->datos[] = $datos;
		}
		return $this->datos;
	}

	function verificar_cl($cliente)
	{
		$this->datos  = array();
		$sql = "SELECT COUNT(clientes_supervision.codigo) contra FROM clientes_supervision, clientes_ubicacion 
		WHERE clientes_supervision.cod_ubicacion = clientes_ubicacion.codigo 
		AND clientes_ubicacion.cod_cliente = '$cliente'";
		$query = $this->bd->consultar($sql);
		return $this->datos = $this->bd->obtener_fila($query);
	}

	function verificar_cont($cliente, $contratacion)
	{
		$this->datos  = array();
		$sql = "SELECT COUNT(codigo) apertura FROM planif_clientes_superv WHERE `status` = 'T' AND cod_contratacion = '$contratacion' AND cod_cliente = '$cliente'";
		$query = $this->bd->consultar($sql);
		return $this->datos = $this->bd->obtener_fila($query);
	}

	function get_trab($cliente, $ubicacion)
	{
		$this->datos  = array();
		$sql = "SELECT a.cod_ficha, a.cedula, CONCAT(a.apellidos,' ', a.nombres) ap_nomb
		FROM ficha AS a ,	control
		WHERE a.cod_ficha_status = control.ficha_activo
		AND a.cod_ficha NOT IN(SELECT cod_ficha FROM clientes_vetados WHERE clientes_vetados.cod_cliente='$cliente' 
		AND clientes_vetados.cod_ubicacion='$ubicacion')
		ORDER BY a.cod_ficha ASC ";

		$query = $this->bd->consultar($sql);
		while ($datos = $this->bd->obtener_fila($query)) {
			$this->datos[] = $datos;
		}
		return $this->datos;
	}

	function get_dias_planif_apertura($cliente, $ubic, $apertura)
	{
		$this->datos  = array();
		$sql = "SELECT
		a.codigo,
		a.fecha,
		cl.nombre cliente,
		cl.codigo cod_cliente,
		cu.descripcion ubicacion,
		cu.codigo cod_ubicacion,
		t.abrev turno,
		t.codigo cod_turno,
		a.cantidad,
		a.fec_us_mod fecha_mod,
		CONCAT(mu.apellido,', ',mu.nombre) nombres
		FROM
		clientes_supervision_ap AS a,
		turno AS t,
		horarios AS h,
		dias_habiles,
		dias_habiles_det,
		dias_tipo,
		clientes AS cl,
		clientes_ubicacion AS cu,
		men_usuarios mu
		WHERE
		a.cod_turno = t.codigo
		AND mu.codigo = a.cod_us_mod
		AND t.cod_horario = h.codigo
		AND t.cod_dia_habil = dias_habiles.codigo
		AND dias_habiles_det.cod_dias_habiles = dias_habiles.codigo
		AND (
		(
		dias_habiles_det.cod_dias_tipo = dias_tipo.dia
		AND Dia_semana (a.fecha) = dias_tipo.descripcion
		)
		OR (
		dias_habiles_det.cod_dias_tipo = dias_tipo.dia
		AND dias_tipo.tipo = 'D'
		)
		OR (
		dias_habiles_det.cod_dias_tipo = dias_tipo.dia
		AND DATE_FORMAT(a.fecha, '%d') = dias_tipo.descripcion
		)
		)
		AND a.cod_cliente = cl.codigo
		AND a.cod_ubicacion = cu.codigo
		AND a.cod_cliente = '$cliente'
		AND a.cod_ubicacion = '$ubic'
		AND a.cod_planif_cl = '$apertura'
		AND a.`status` = 'T'
		ORDER BY 2,3,5,4,6,7
		";



		$query = $this->bd->consultar($sql);
		//$this->datos["sql"] = $sql;
		while ($datos = $this->bd->obtener_fila($query, 0)) {
			$this->datos[] = $datos;
		}
		return $this->datos;
	}


	function get_trab_sin_planif($cliente, $ubic, $apertura)
	{
		$this->datos  = array();

		$sql = "SELECT  v_ficha.rol, v_ficha.cod_ficha, v_ficha.cedula, 
		v_ficha.ap_nombre, v_ficha.cargo
		FROM v_ficha, control, clientes, clientes_ubicacion
		WHERE v_ficha.cod_ficha_status = control.ficha_activo 
		AND clientes.codigo = clientes_ubicacion.cod_cliente 
		AND clientes_ubicacion.codigo = v_ficha.cod_ubicacion
		AND v_ficha.cod_cliente = $cliente AND v_ficha.cod_ubicacion = $ubic
		AND v_ficha.cod_ficha NOT IN (SELECT planif_clientes_superv_trab_det.cod_ficha FROM planif_clientes_superv_trab_det
		WHERE planif_clientes_superv_trab_det.cod_planif_cl = '$apertura' AND  planif_clientes_superv_trab_det.cod_cliente = $cliente AND planif_clientes_superv_trab_det.cod_ubicacion = $ubic)";

		$query = $this->bd->consultar($sql);
		while ($datos = $this->bd->obtener_fila($query, 0)) {
			$this->datos[] = $datos;
		}
		return $this->datos;
	}

	function cantidad_trab_sin_planif($cliente, $ubic, $apertura)
	{
		$this->datos  = array();
		$sql = "SELECT COUNT(v_ficha.cod_ficha) cantidad
		FROM v_ficha, control
		WHERE v_ficha.cod_ficha_status = control.ficha_activo 
		AND v_ficha.cod_cliente = $cliente AND v_ficha.cod_ubicacion = $ubic
		AND v_ficha.cod_ficha NOT IN (SELECT planif_clientes_superv_trab_det.cod_ficha FROM planif_clientes_superv_trab_det
		WHERE planif_clientes_superv_trab_det.cod_planif_cl = '$apertura' AND  planif_clientes_superv_trab_det.cod_cliente = $cliente AND planif_clientes_superv_trab_det.cod_ubicacion = $ubic)";
		$query = $this->bd->consultar($sql);
		return $this->datos = $this->bd->obtener_fila($query);
	}
}
