<?php
define("SPECIALCONSTANT", true);
include_once('../../../../funciones/funciones.php');
require("../../../../autentificacion/aut_config.inc.php");
require_once("../../../../".class_bdI);

class Linea
{
  private $datos;
  private $linea;
  private $lineas;
  private $bd;

  function __construct()
  {
    $this->datos     = array();
    $this->linea     = array();
    $this->lineas     = array();
    $this->bd        = new Database;
  }

  public function inicio()
  {

    $this->producto = array('codigo' => '',  'descripcion' => '',
      'campo01' => '', 'campo02' => '','campo03' => '','campo04' => '','status' => 'T');
    return $this->linea;
  }

  public function editar($cod)
  {
    $sql = " SELECT 
    FROM prod_linea
    WHERE prod_linea.codigo = '$cod'";

    $query = $this->bd->consultar($sql);
    return $this->producto = $this->bd->obtener_fila($query);
  }

  public function get_lineas(){

    $sql = "SELECT codigo,descripcion FROM prod_lineas WHERE `status`='T' ORDER BY descripcion ASC";
    $query = $this->bd->consultar($sql);

    while ($datos= $this->bd->obtener_fila($query)) {
      $this->linea[] = $datos;
    }
    return $this->linea;
  }

  public function get_sub_lineas($linea){
    $sql = "SELECT codigo, descripcion FROM prod_sub_lineas
    WHERE cod_linea = '$linea'
    AND status = 'T'
    ORDER BY descripcion ASC";
    $query = $this->bd->consultar($sql);
    while ($datos= $this->bd->obtener_fila($query)) {
      $this->sub_linea[] = $datos;
    }
    return $this->sub_linea;
  }

  public function get_colores(){
    $sql = "SELECT codigo, descripcion FROM colores WHERE `status` = 'T' ORDER BY 2 ";
    $query = $this->bd->consultar($sql);
    while ($datos = $this->bd->obtener_fila($query)) {
      $this->color[] = $datos;
    }
    return $this->color;
  }

  public function get_tipos(){
    $sql = "SELECT codigo, descripcion FROM prod_tipos WHERE `status` = 'T' ORDER BY 2 ASC";
    $query = $this->bd->consultar($sql);
    while ($datos= $this->bd->obtener_fila($query)) {
      $this->tipo[] = $datos;
    }
    return $this->tipo;
  }

  public function get_unidades(){
    $sql = "SELECT codigo, descripcion FROM unidades WHERE `status` = 'T' ORDER BY 2 ASC";
    $query = $this->bd->consultar($sql);
    while ($datos= $this->bd->obtener_fila($query)) {
      $this->unidad[] = $datos;
    }
    return $this->unidad;
  }

  public function buscar_producto($data,$filtro){
    $where="";
    if ($data) $where =" WHERE producto.$filtro LIKE '%$data%' ";

    $sql = "SELECT * FROM producto ".$where." ORDER BY 2 ASC";
    $query         = $this->bd->consultar($sql);

    while ($datos= $this->bd->obtener_fila($query)) {
      $this->datos[] = $datos;
    }
    return $this->datos;
  }

  public function inicio_buscar(){
    $sql = "SELECT productos.codigo, prod_lineas.descripcion AS linea, 
    prod_sub_lineas.descripcion AS sub_linea,  prod_tipos.descripcion AS prod_tipo, 
    productos.descripcion,  IFNULL(v_prod_ultimo_mov.mov_tipo , 'SIN MOVIMIENTO') AS mov_tipo,
    productos.status
    FROM productos LEFT JOIN v_prod_ultimo_mov ON productos.codigo = v_prod_ultimo_mov.cod_producto , prod_lineas , prod_sub_lineas , prod_tipos ,  control
    WHERE productos.cod_linea = prod_lineas.codigo 
    AND productos.cod_sub_linea = prod_sub_lineas.codigo 
    AND productos.cod_prod_tipo = prod_tipos.codigo 
    AND productos.fec_us_mod  BETWEEN DATE_FORMAT(CURDATE(), '%Y-%m-01') AND CURDATE()   
    ORDER BY productos.codigo ASC ";

    $query         = $this->bd->consultar($sql);

    while ($datos= $this->bd->obtener_fila($query)) {
      $this->productos[] = $datos;
    }
    return $this->productos;
  }

  public function get_tipo_mov(){
    $sql = "SELECT prod_mov_tipo.codigo, prod_mov_tipo.descripcion,
    prod_mov_tipo.tipo_movimiento FROM prod_mov_tipo ORDER BY 2 ASC";

    $query = $this->bd->consultar($sql);

    while ($datos= $this->bd->obtener_fila($query)) {
      $this->datos[] = $datos;
    }
    return $this->datos;
  }
  
}
?>
