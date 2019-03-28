<?php
define("SPECIALCONSTANT", true);
include_once('../../../../funciones/funciones.php');
require  "../../../../autentificacion/aut_config.inc.php";
require_once  "../../../../".class_bdI;

class gNovedades
{
  private $datos;
  private $bd;

  function __construct()
  {
    $this->datos   = array();
    $this->bd = new Database;
  }

  public function get_agrupado($fecha_desde,$fecha_hasta){

    $sql = "SELECT NP.fec_us_mod titulo, NC.descripcion titulo2,
    Count(NC.descripcion) valor, NS.codigo 
    FROM nov_procesos NP 
    INNER JOIN nov_status NS ON NP.cod_nov_status = NS.codigo 
    INNER JOIN nov_clasif NC ON NP.cod_novedad = NC.codigo 
    WHERE NP.fec_us_ing BETWEEN \"$fecha_desde\" AND \"$fecha_hasta\" 
    GROUP BY titulo,titulo2 ASC";

    $query = $this->bd->consultar($sql);
    while ($datos= $this->bd-> obtener_fila($query)) {
      $this->datos[] = $datos;
    }
    return $this->datos;

  }

  public function get_simple($fecha_desde,$fecha_hasta){

    $sql = "SELECT
    NS.descripcion AS titulo,
    Count(NS.descripcion) AS valor,
    NS.codigo AS codigo
    FROM
    nov_procesos AS NP
    INNER JOIN nov_status AS NS ON NP.cod_nov_status = NS.codigo
    WHERE NP.fec_us_ing BETWEEN \"$fecha_desde\" AND \"$fecha_hasta\"
    GROUP BY titulo ASC";
    $query = $this->bd->consultar($sql);
    while ($datos= $this->bd-> obtener_fila($query)) {
      $this->datos[] = $datos;
    }
    return $this->datos;

  }

  public function getNovStatusDet($fecha_desde,$fecha_hasta,$status){

    $sql = "SELECT
    NC.descripcion AS titulo,
    Count(NC.descripcion) AS valor,
    NC.codigo
    FROM
    nov_procesos AS NP
    INNER JOIN nov_status AS NS ON NP.cod_nov_status = NS.codigo
    INNER JOIN novedades AS N ON NP.cod_novedad = N.codigo
    INNER JOIN nov_clasif AS NC ON N.cod_nov_clasif = NC.codigo
    WHERE NS.codigo = \"$status\" AND NP.fec_us_ing BETWEEN \"$fecha_desde\" AND \"$fecha_hasta\" 
    GROUP BY
    titulo ASC";
    $query = $this->bd->consultar($sql);
    while ($datos= $this->bd-> obtener_fila($query)) {
      $this->datos[] = $datos;
    }
    return $this->datos;

  }

}
?>
