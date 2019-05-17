<?php
define("SPECIALCONSTANT", true);
require("../../../autentificacion/aut_config.inc.php");
require_once("../../../".class_bdI);
require_once "../../../".Funcion;

class General
{
	 private $bd;
 	 private $datos;
	function __construct()
	{
    $this->bd = new Database;
	}

	public function get_region($cod){
		$this->datos   = array();
	  $sql = " SELECT a.codigo, a.descripcion
	             FROM regiones AS a
	            WHERE a.`status` = 'T'
	              AND a.codigo <> '$cod'; ";
    $query = $this->bd->consultar($sql);

    while ($datos= $this->bd->obtener_fila($query)) {
      $this->datos[] = $datos;
    }
    return $this->datos;
	}

	public function get_zona($cod){
		$this->datos   = array();
	  $sql = " SELECT a.codigo, a.descripcion FROM zonas a
		  				WHERE a.`status` = 'T' AND a.codigo <> '$cod'
						  ORDER BY 2 ASC ";
	  $query = $this->bd->consultar($sql);

		while ($datos= $this->bd->obtener_fila($query)) {
      $this->datos[] = $datos;
    }
	  return $this->datos;
	}

	public function get_calendario($cod){
		$this->datos   = array();
		$sql = " SELECT a.codigo, a.descripcion FROM nom_calendario a
							WHERE a.`status` = 'T' AND a.tipo = 'VAR'  AND a.codigo <> '$cod'
							ORDER BY 2 ASC ";
		$query = $this->bd->consultar($sql);

		while ($datos= $this->bd->obtener_fila($query)) {
			$this->datos[] = $datos;
		}
		return $this->datos;
	}

	public function get_estado($cod){
		$this->datos   = array();
		$sql = " SELECT a.codigo, a.descripcion FROM estados a , control
							WHERE a.cod_pais = control.cod_pais AND a.`status` = 'T'
							  AND a.codigo <> '$cod' ORDER BY 2 ASC ";
		$query = $this->bd->consultar($sql);

		while ($datos= $this->bd->obtener_fila($query)) {
			$this->datos[] = $datos;
		}
		return $this->datos;
	}

	public function get_ciudad($cod, $cod_estado){
		$this->datos   = array();
		$sql = " SELECT a.codigo, a.descripcion FROM ciudades a
							WHERE a.cod_estado = '$cod_estado' AND a.`status` = 'T'
							  AND a.codigo <> '$cod' ORDER BY 2 ASC ";
		$query = $this->bd->consultar($sql);

		while ($datos= $this->bd->obtener_fila($query)) {
			$this->datos[] = $datos;
		}
		return $this->datos;
	}

	public function get_ubic_cl($cod){
		$this->datos   = array();
		$sql = " SELECT a.cod_cliente, b.abrev, b.nombre cliente, a.descripcion ubicacion
	             FROM clientes_ubicacion a, clientes b
	            WHERE a.codigo = '$cod'
	              AND a.cod_cliente = b.codigo ";
		$query = $this->bd->consultar($sql);

		while ($datos= $this->bd->obtener_fila($query)) {
			$this->datos[] = $datos;
		}
		return $this->datos;
	}


  public function buscar($tb,$data){
    $where = " WHERE codigo != '9999' ";
    if($data != null || $data != ""){
      $where .= " AND $tb.codigo LIKE '%$data%' OR  $tb.descripcion LIKE '%$data%' ";
    }
    $sql = "SELECT $tb.codigo,$tb.descripcion,IF($tb.`status`='T','ACTIVO','INACTIVO') status 
    FROM $tb
    $where ";

    $query = $this->bd->consultar($sql);

    while ($datos= $this->bd->obtener_fila($query)) {
      $this->datos[] = $datos;
    }
    return $this->datos;
  }

  public function get_maestro($tabla,$codigo){
  		$sql = " SELECT $tabla.codigo, $tabla.descripcion,
	                $tabla.campo01, $tabla.campo02, $tabla.campo03, $tabla.campo04,	               
				    $tabla.status
	           FROM $tabla WHERE codigo = '$codigo' AND  codigo != '9999'";
	  $query = $this->bd->consultar($sql);

   return $this->datos = $this->bd->obtener_fila($query);
}
}

?>
