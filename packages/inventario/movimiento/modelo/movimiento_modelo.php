<?php
define("SPECIALCONSTANT", true);
require  "../../../../autentificacion/aut_config.inc.php";
require_once "../../../../".Funcion;
require_once  "../../../../".class_bdI;

class Movimiento
{
  private $datos;
  private $bd;

  function __construct()
  {
    $this->datos   = array();
    $this->bd = new Database;
  }

  public function get(){
    $sql = " SELECT a.*, b.descripcion tipo

    FROM ajuste a, ajuste_tipo b
    WHERE a.cod_tipo = b.codigo
    ORDER BY a.codigo DESC";
    $query = $this->bd->consultar($sql);

    while ($datos= $this->bd->obtener_fila($query)) {
      $this->datos[] = $datos;
    }
    return $this->datos;
  }

    public function get_almacenes(){
    $sql = " SELECT codigo, descripcion
    FROM almacenes WHERE `status`='T' ORDER BY 1 ASC";
    $query = $this->bd->consultar($sql);

    while ($datos= $this->bd->obtener_fila($query)) {
      $this->datos[] = $datos;
    }
    return $this->datos;
  }
//  'fecha' => Date,
  public function inicio(){

    $this->datos   = array();
    $this->datos = array('codigo' => 0,                 'motivo' => '',
     'cod_tipo' =>'',               'tipo' => 'Seleccione...',
     'descripcion' => '',           'fecha' => "",
     'total' => 0                   );
    return $this->datos;

  }

  public function editar($cod){
    $this->datos   = array();
    $sql = "  SELECT a.*, b.descripcion tipo
    FROM ajuste a, ajuste_tipo b
    WHERE a.codigo = $cod
    AND a.cod_tipo = b.codigo
    ORDER BY a.codigo DESC";
    $query = $this->bd->consultar($sql);
    return  $this->datos = $this->bd->obtener_fila($query);
  }

    public function buscar_productos($dato,$almacen){
    $sql = "SELECT a.codigo,a.descripcion FROM productos a,stock b
    WHERE (a.codigo LIKE '%$dato%'
    OR a.item LIKE '%$dato%'
    OR a.descripcion LIKE '%$dato%')
    AND a.item = b.cod_producto
    AND b.cod_almacen = '$almacen'
    ORDER BY a.codigo ASC";
    $query         = $this->bd->consultar($sql);
    while ($datos= $this->bd->obtener_fila($query)) {
      $this->datos[] = $datos;
    }
    return $this->datos;
  }

  public function get_mov_reng($cod){
    $this->datos   = array();
    $sql = " SELECT a.*, b.descripcion producto
    FROM ajuste_reng a , productos b
    WHERE a.cod_ajuste = $cod
    AND a.cod_producto = b.item
    ORDER BY a.reng_num ASC";
    $query = $this->bd->consultar($sql);

    while ($datos= $this->bd->  obtener_fila($query)) {
      $this->datos[] = $datos;
    }
    return $this->datos;
  }


}
?>
