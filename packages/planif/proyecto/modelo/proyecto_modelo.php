<?php
define("SPECIALCONSTANT", true);
include_once('../../../../funciones/funciones.php');
require  "../../../../autentificacion/aut_config.inc.php";
require_once  "../../../../".class_bdI;

class Proyecto
{
  private $datos;
  private $horario;
  private $concepto;
  private $bd;

  function __construct()
  {
    $this->datos   = array();
    $this->bd = new Database;
  }

  public function get(){
    $sql = " SELECT * FROM planif_proyecto ORDER BY 2 ASC ";
    $query = $this->bd->consultar($sql);
    while ($datos= $this->bd->  obtener_fila($query)) {
      $this->datos[] = $datos;
    }
    return $this->datos;
  }

  public function inicio(){
   $this->datos = array('codigo' => '',  'descripcion' => '',
                          'abrev' => '', 'status' => 'T');
   return $this->datos;
 }

 public function editar($cod){
    $this->datos   = array();
  $sql = " SELECT * FROM planif_proyecto a
            WHERE a.codigo = '$cod' ";
  $query = $this->bd->consultar($sql);
  return $this->datos = $this->bd->obtener_fila($query);
}

public function get_planif_actividad($proyecto){
  $this->datos   = array();
  $sql = " SELECT planif_actividad.codigo, planif_actividad.descripcion,
            planif_actividad.minutos, planif_actividad.principal
            FROM planif_actividad
            WHERE planif_actividad.cod_proyecto = '$proyecto'
          ORDER BY 1 ASC ";
  $query = $this->bd->consultar($sql);

  while ($datos= $this->bd->obtener_fila($query)) {
    $this->datos[] = $datos;
  }
  return $this->datos;
}

public function get_turno_det($turno){
  $this->datos   = array();
  $sql = " SELECT horarios.nombre horario, dias_habiles.descripcion dh
             FROM turno , horarios , dias_habiles
            WHERE  turno.codigo = '$turno'
              AND turno.cod_dia_habil = dias_habiles.codigo
              AND turno.cod_horario = horarios.codigo ";
 $query = $this->bd->consultar($sql);
 return $this->datos = $this->bd->obtener_fila($query);
}

public function buscar_proyecto($data,$filtro){
   $where="";
   if ($data) $where =" WHERE a.$filtro LIKE '%$data%' ";

   $sql   = "SELECT * FROM proyecto a ".$where." ORDER BY 2 ASC";
   $query = $this->bd->consultar($sql);

   while ($datos= $this->bd->obtener_fila($query)) {
    $this->datos[] = $datos;
    }
  return $this->datos;
  }
}
?>
