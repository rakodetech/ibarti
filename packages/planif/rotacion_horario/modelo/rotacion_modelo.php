<?php
define("SPECIALCONSTANT", true);
include_once('../../../../funciones/funciones.php');
require  "../../../../autentificacion/aut_config.inc.php";
require_once  "../../../../".class_bdI;

class Rotacion
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
    $sql = " SELECT * FROM rotacion ORDER BY 2 ASC ";
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
  $sql = " SELECT * FROM rotacion a
            WHERE a.codigo = '$cod' ";
  $query = $this->bd->consultar($sql);
  return $this->datos = $this->bd->obtener_fila($query);
}

public function get_rotacion_det($rotacion){

  $sql = " SELECT rotacion_det.codigo, rotacion_det.cod_turno, turno.descripcion turno,
                  CONCAT('Horario:', horarios.nombre, ', Dia Habil: ',dias_habiles.descripcion) detalle
             FROM rotacion_det, turno, horarios,  dias_habiles
            WHERE rotacion_det.cod_rotacion = '$rotacion'
              AND rotacion_det.cod_turno = turno.codigo
              AND turno.cod_horario = horarios.codigo
              AND turno.cod_dia_habil = dias_habiles.codigo
         ORDER BY 1 ASC ";
  $query = $this->bd->consultar($sql);

  while ($datos= $this->bd->obtener_fila($query)) {
    $this->concepto[] = $datos;
  }
  return $this->concepto;
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

public function buscar_rotacion($data,$filtro){
   $where="";
   if ($data) $where =" WHERE a.$filtro LIKE '%$data%' ";

   $sql   = "SELECT * FROM rotacion a ".$where." ORDER BY 2 ASC";
   $query = $this->bd->consultar($sql);

   while ($datos= $this->bd->obtener_fila($query)) {
    $this->datos[] = $datos;
    }
  return $this->datos;
  }
}
?>
