<?php
define("SPECIALCONSTANT", true);
require  "../../../../autentificacion/aut_config.inc.php";
require_once "../../../../" . Funcion;
require_once  "../../../../" . class_bdI;

class stock_ubic_alcance
{
  private $datos;
  private $bd;

  function __construct()
  {
    $this->datos   = array();
    $this->bd = new Database;
  }

  public function get()
  {
    $sql = " SELECT a.*, b.codigo cod_tipo, b.descripcion tipo,c.nombre proveedor
    FROM ajuste_alcance a, prod_mov_tipo b, proveedores c
    WHERE a.cod_tipo = b.codigo
    AND a.cod_proveedor = c.codigo
    ORDER BY a.codigo LIMIT 100";
    $query = $this->bd->consultar($sql);

    while ($datos = $this->bd->obtener_fila($query)) {
      $this->datos[] = $datos;
    }
    return $this->datos;
  }

  public function get_almacenes_stock($codigo)
  {
    $sql = " SELECT b.codigo, b.descripcion
    FROM stock a,almacenes b WHERE 
    a.cod_almacen = b.codigo
    AND a.cod_producto = '$codigo'
    AND b.`status`='T' ORDER BY 1 ASC";
    $query = $this->bd->consultar($sql);

    while ($datos = $this->bd->obtener_fila($query)) {
      $this->datos[] = $datos;
    }
    return $this->datos;
  }

  //  'fecha' => Date,
  public function inicio()
  {
    $this->datos   = array();
    $this->datos = array(
      'codigo' => '',        'motivo' => '',
      'cod_tipo' => '',               'tipo' => 'Seleccione...',
      'ubicacion' => '',
      'descripcion' => '',           'fecha' => date("d-m-Y")
    );
    return $this->datos;
  }

  public function editar($cod)
  {
    $this->datos   = array();
    $sql = "  SELECT a.*, b.descripcion tipo, c.nombre proveedor
    FROM ajuste_alcance a, prod_mov_tipo b, proveedores c
    WHERE a.codigo = $cod
    AND a.cod_tipo = b.codigo
    AND a.cod_proveedor = c.codigo
    ORDER BY a.codigo DESC";
    $query = $this->bd->consultar($sql);
    return  $this->datos = $this->bd->obtener_fila($query);
  }

  public function get_stock_actual($producto, $almacen)
  {
    $this->datos   = array();
    $sql = " SELECT FORMAT(stock_actual,0) stock_actual
    FROM stock_alcance WHERE cod_producto = '$producto' AND cod_almacen = '$almacen'";
    $query = $this->bd->consultar($sql);
    return  $this->datos = $this->bd->obtener_fila($query);
  }

  public function get_ubicaciones($cliente)
  {
    $this->datos   = array();
    $sql = "SELECT codigo, descripcion FROm clientes_ubicacion 
    WHERE cod_cliente = '$cliente' AND status='T'";
    $query = $this->bd->consultar($sql);
    while ($datos = $this->bd->obtener_fila($query)) {
      $this->datos[] = $datos;
    }
    return $this->datos;
  }

  public function buscar_productos($dato)
  {
    $sql = "SELECT a.codigo,a.descripcion FROM productos a
    WHERE (a.codigo LIKE '%$dato%'
    OR a.item LIKE '%$dato%'
    OR a.descripcion LIKE '%$dato%')   
    WHERE a.`status` = 'T'
    GROUP BY 2  
    ORDER BY a.codigo ASC  ";
    $query         = $this->bd->consultar($sql);
    while ($datos = $this->bd->obtener_fila($query)) {
      $this->datos[] = $datos;
    }
    return $this->datos;
  }

  public function buscar($fecha_desde, $fecha_hasta, $mov_tipo, $proveedor, $referencia)
  {
    $WHERE = " WHERE a.cod_tipo = b.codigo
   AND a.cod_proveedor = c.codigo ";
    if ($fecha_desde != '' && $fecha_desde != '0000-00-00' && $fecha_hasta != '' && $fecha_hasta != '0000-00-00') {
      $WHERE .= " AND a.fecha BETWEEN '$fecha_desde' AND '$fecha_hasta' ";
    }
    if ($mov_tipo != 'TODOS') {
      $WHERE .= " AND b.codigo = '$mov_tipo'";
    }
    if ($proveedor != 'TODOS') {
      $WHERE .= " AND  c.codigo = '$proveedor'";
    }
    if ($referencia != '' and $referencia != null) {
      $WHERE .= " AND  a.referencia = '$referencia'";
    }

    $sql = "SELECT a.*, b.codigo cod_tipo, b.descripcion tipo,c.nombre proveedor
  FROM ajuste_alcance a, prod_mov_tipo b,proveedores c
  $WHERE       
  ORDER BY a.codigo ASC  ";

    $query         = $this->bd->consultar($sql);
    while ($datos = $this->bd->obtener_fila($query)) {
      $this->datos[] = $datos;
    }
    return $this->datos;
  }

  public function get_tipo($cod)
  {
    $this->datos   = array();
    $sql = " SELECT * FROM prod_mov_tipo a
  WHERE a.`status` = 'T' AND a.codigo <> '$cod'
  AND a.codigo <> '9999' AND a.codigo <> 'TRAS' AND a.codigo <> 'TRAS-'
  ORDER BY 2 ASC ";
    $query = $this->bd->consultar($sql);

    while ($datos = $this->bd->obtener_fila($query)) {
      $this->datos[] = $datos;
    }
    return $this->datos;
  }

  public function get_tipo_aplicar($cod)
  {
    $this->datos   = array();
    $sql = " SELECT tipo_movimiento FROM prod_mov_tipo WHERE codigo = '$cod'";
    $query = $this->bd->consultar($sql);
    return  $this->datos = $this->bd->obtener_fila($query);
  }

  public function get_if_ean($cod)
  {
    $this->datos   = array();
    $sql = " SELECT ean FROM productos WHERE item = '$cod'";
    $query = $this->bd->consultar($sql);
    return  $this->datos = $this->bd->obtener_fila($query);
  }

  public function get_aj_reng($cod)
  {
    $this->datos   = array();
    $sql = " SELECT a.*, b.descripcion producto,c.descripcion ubicacion,b.item serial,b.ean
    FROM ajuste_alcance_reng a , productos b,clientes_ubicacion c
    WHERE a.cod_ajuste = $cod
    AND a.cod_producto = b.item
    AND a.cod_ubicacion = c.codigo
    ORDER BY a.reng_num ASC";
    $query = $this->bd->consultar($sql);

    while ($datos = $this->bd->obtener_fila($query)) {
      $this->datos[] = $datos;
    }
    return $this->datos;
  }

  public function get_aj_reng_eans($ajuste_alcance, $renglon)
  {
    $this->datos   = array();
    $sql = " SELECT cod_ean FROM ajuste_alcance_reng_eans WHERE cod_ajuste_alcance = '$ajuste_alcance' AND reng_num = '$renglon';";
    $query = $this->bd->consultar($sql);

    while ($datos = $this->bd->obtener_fila($query)) {
      $this->datos[] = $datos['cod_ean'];
    }
    return $this->datos;
  }

  public function get_eans($cod, $salida)
  {
    $this->datos   = array();
    if ($salida) {
      $sql = " SELECT cod_ean FROM prod_ean WHERE inStock = 'F' AND cod_producto = '$cod'
    ORDER BY 1 DESC";
    } else {
      $sql = " SELECT a.cod_producto, a.cod_ean
    FROM prod_ean a
    WHERE a.cod_producto = '$cod'
    AND a.cod_ean NOT IN (SELECT cod_ean FROM prod_ean WHERE inStock = 'F' AND cod_producto = '$cod')
    ORDER BY a.fec_us_mod DESC";
    }
    $query = $this->bd->consultar($sql);

    while ($datos = $this->bd->obtener_fila($query)) {
      $this->datos[] = $datos;
    }
    return $this->datos;
  }

  public function get_cantidad_mayor_a_stock_actual($cod_ajuste_alcance)
  {
    $sql = "
  SELECT
  ajuste_alcance_reng.cantidad
  ,stock.stock_actual
   ,stock.cod_producto
  FROM 
  ajuste_alcance_reng
  ,stock 
  WHERE 
  ajuste_alcance_reng.cod_ajuste_alcance = '$cod_ajuste_alcance' AND
  stock.cod_producto = ajuste_alcance_reng.cod_producto AND
  stock.cod_almacen =ajuste_alcance_reng.cod_almacen
  GROUP BY ajuste_alcance_reng.cod_almacen,ajuste_alcance_reng.cod_producto,ajuste_alcance_reng.cantidad
  HAVING
  ajuste_alcance_reng.cantidad>stock.stock_actual
  ";
    $query = $this->bd->consultar($sql);

    while ($datos = $this->bd->obtener_fila($query)) {
      $this->datos[] = $datos;
    }
    return $this->datos;
  }
}
