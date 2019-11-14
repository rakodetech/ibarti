<?php
define("SPECIALCONSTANT", true);
include_once('../../../../funciones/funciones.php');
require("../../../../autentificacion/aut_config.inc.php");
require_once("../../../../".class_bdI);

class Ub_puesto
{
	 private $datos;
	 private $bd;

	function __construct()
	{
    $this->bd = new Database;
	}

	public function get($cl, $ubic){
		$this->datos   = array();
    $sql = " SELECT * FROM clientes_ub_puesto a
							WHERE a.cod_cliente = '$cl' AND a.cod_cl_ubicacion = '$ubic'
					 ORDER BY 3 DESC ";
    $query = $this->bd->consultar($sql);

    while ($datos= $this->bd->  obtener_fila($query)) {
      $this->datos[] = $datos;
    }
    return $this->datos;
	}

  public function inicio(){
    $this->datos = array('codigo' => '',  'nombre' => '',
                         'actividades' => '',  'observ' => '',
                         'status' => '');
		return $this->datos;
  }

	public function editar($cod){
		$this->datos   = array();
  	$sql = "SELECT a.*, clientes.nombre cliente,
		               clientes.abrev, clientes_ubicacion.descripcion ubic
	            FROM clientes_ub_puesto a, clientes, clientes_ubicacion
	           WHERE a.cod_cliente = clientes.codigo 	AND a.cod_cl_ubicacion  = clientes_ubicacion.codigo
              AND a.codigo =  '$cod'";

    $query = $this->bd->consultar($sql);
    return $this->datos = $this->bd->obtener_fila($query);
  }



}
?>
