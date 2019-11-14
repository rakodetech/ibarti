<?php
define("SPECIALCONSTANT", true);
include_once('../../../../funciones/funciones.php');
require  "../../../../autentificacion/aut_config.inc.php";
require_once  "../../../../".class_bdI;

class Vetado
{
	private $datos;
	private $bd;

	function __construct()
	{
		$this->datos   = array();
		$this->bd = new Database;
	}

	public function get($cliente){
		$this->datos   = array();
		$sql = "SELECT a.cod_ficha,concat(`ficha`.`nombres`,' ',`ficha`.`apellidos`) AS ap_nombre,
		a.cod_ubicacion,clientes_ubicacion.descripcion ubicacion, a.comentario,a.fec_us_ing
		FROM
		clientes_vetados AS a
		INNER JOIN clientes_ubicacion ON a.cod_ubicacion = clientes_ubicacion.codigo
		INNER JOIN ficha ON a.cod_ficha = ficha.cod_ficha
		WHERE a.cod_cliente = '$cliente'
		ORDER BY 3 DESC";

		$query = $this->bd->consultar($sql);
		while ($datos= $this->bd->  obtener_fila($query)) {
			$this->datos[] = $datos;
		}
		return $this->datos;
	}


	public function get_trab_det($codigo,$cliente,$ubicacion){
		$this->datos   = array();
		$sql = "SELECT
		v_ficha.cod_ficha,
		v_ficha.cedula,
		v_ficha.cargo,
		v_ficha.contracto,
		v_ficha.ap_nombre,
		v_ficha.nombres,
		v_ficha.apellidos,
		clientes_vetados.comentario,
		clientes_vetados.fec_us_ing,
		clientes_vetados.fec_us_mod,
		clientes_vetados.cod_ubicacion,
		clientes_ubicacion.descripcion ubicacion,
		CONCAT(ui.nombre,' ',ui.apellido) us_ing,
		CONCAT(um.nombre,' ',um.apellido)  us_mod
		FROM
		clientes_vetados
		LEFT JOIN men_usuarios AS ui ON clientes_vetados.cod_us_ing = ui.codigo
		LEFT JOIN men_usuarios AS um ON clientes_vetados.cod_us_mod = um.codigo 
		LEFT JOIN v_ficha ON clientes_vetados.cod_ficha = v_ficha.cod_ficha 
		LEFT JOIN clientes_ubicacion ON clientes_vetados.cod_cliente = clientes_ubicacion.cod_cliente AND
		clientes_vetados.cod_ubicacion = clientes_ubicacion.codigo
		WHERE
		clientes_vetados.cod_ficha = '$codigo' AND clientes_vetados.cod_cliente = '$cliente'
		AND clientes_vetados.cod_ubicacion ='$ubicacion'";

		$query = $this->bd->consultar($sql);
		return $this->datos = $this->bd->obtener_name($query);
	}


	public function get_trab($cliente,$ubicacion){
		$this->datos   = array();
		$sql = "SELECT cod_ficha,ap_nombre FROM v_ficha 
		WHERE cod_ficha NOT IN (SELECT cod_ficha FROM clientes_vetados WHERE clientes_vetados.cod_cliente = '$cliente'
								AND clientes_vetados.cod_ubicacion = '$ubicacion') AND cod_ficha_status = 'A' ORDER BY 1 ASC";
		$query = $this->bd->consultar($sql);
		while ($datos= $this->bd->  obtener_fila($query)) {
			$this->datos[] = $datos;
		}
		return $this->datos;
	}

	public function get_ubic($cliente){
		$this->datos   = array();
		$sql = " SELECT clientes_ubicacion.codigo, clientes_ubicacion.descripcion
		FROM clientes_ubicacion
		WHERE clientes_ubicacion.cod_cliente = '$cliente'
		AND clientes_ubicacion.`status` = 'T'
		ORDER BY 2 ASC ";
		$query = $this->bd->consultar($sql);
		while ($datos= $this->bd->  obtener_fila($query)) {
			$this->datos[] = $datos;
		}
		return $this->datos;
	}
}
?>
