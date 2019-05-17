<?php
define("SPECIALCONSTANT", true);
include_once('../../../../funciones/funciones.php');
require("../../../../autentificacion/aut_config.inc.php");
require_once("../../../../".class_bdI);

class Turno
{
  private $datos;
  private $turno;
  private $bd;

  function __construct()
  {
    $this->datos     = array();
    $this->turno     = array();
    $this->bd        = new Database;
  }

  public function get()
  {
    $sql = " SELECT * FROM turno ORDER BY 2 ASC ";
    $query = $this->bd->consultar($sql);
    while ($datos= $this->bd->  obtener_fila($query))
    {
      $this->datos[] = $datos;
    }
    return $this->datos;
  }

  public function inicio()
  {
    $this->turno = array('codigo' => '',  'abrev' => '',
     'descripcion' => '',   'cod_dia_habil' => '',
     'dia_habil' => 'Seleccione...', 'cod_horario' => '',
     'horario' => 'Seleccione...', 'factor' => '',
     'trab_cubrir' => '', 'status' => 'T');
    return $this->turno;
  }

  public function editar($cod)
  {
    $sql = " SELECT turno.codigo, turno.abrev,
    turno.descripcion,
    turno.cod_horario, horarios.nombre AS horario,
    turno.cod_dia_habil, dias_habiles.descripcion AS dia_habil,
    turno.factor, turno.trab_cubrir,
    turno.`status`
    FROM turno , horarios, dias_habiles
    WHERE turno.codigo = '$cod'
    AND turno.cod_horario = horarios.codigo
    AND turno.cod_dia_habil = dias_habiles.codigo
    ORDER BY 2 ASC ";

    $query = $this->bd->consultar($sql);
    return $this->turno = $this->bd->obtener_fila($query);
  }

  public function buscar_turno($data,$filtro){
   $where="";
   if ($data) $where =" WHERE turno.$filtro LIKE '%$data%' ";

   $sql = "SELECT * FROM turno ".$where." ORDER BY 2 ASC";
   $query         = $this->bd->consultar($sql);

   while ($datos= $this->bd->obtener_fila($query)) {
    $this->datos[] = $datos;
  }
  return $this->datos;
}

}
?>
