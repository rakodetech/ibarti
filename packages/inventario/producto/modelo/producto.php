<?php
define("SPECIALCONSTANT", true);

include_once('../../../../funciones/funciones.php');
require("../../../../autentificacion/aut_config.inc.php");
require_once("../../../../".class_bdI);
$bd = new DataBase();
$result = array();

foreach($_POST as $nombre_campo => $valor){
  $variables = "\$".$nombre_campo."='".$valor."';";
  eval($variables);
}

if(isset($_POST['proced'])){
  try {
/*
metodo VARCHAR(12), cod VARCHAR(12), linea VARCHAR(12), sub_linea VARCHAR(12),   color VARCHAR(12), prod_tipo VARCHAR(12), unidad VARCHAR(12), proveedor VARCHAR(12),procedencia VARCHAR(12), alm VARCHAR(12),  iva VARCHAR(12), item VARCHAR(120), descrip VARCHAR(120), precio1 NUMERIC(12,2), precio2 NUMERIC(12,2), precio3 NUMERIC(12,2), precio4 NUMERIC(12,2), precio5 NUMERIC(12,2),  p_garantia VARCHAR(60), p_talla VARCHAR(60), p_peso VARCHAR(60), p_piecubico VARCHAR(60),  venc VARCHAR(12), fec_venc VARCHAR(12),  cp01 VARCHAR(60), cp02 VARCHAR(60), cp03 VARCHAR(60), cp04 VARCHAR(60),  usuario VARCHAR(12), act VARCHAR(1)

CALL p_productos('agregar', 'dsbv', 'BOL-01', '130', '09', '01',\r\n    'und',  '0002','9999','almacen', '01','dsbv-BOL-01-130', 'dbs', \r\n    '', '',' ', '',  '',   \r\n    '', 'dh','', '','F', 'DD-MM-AAAA',\r\n    '', '', '', '', '9999', 'T')"*/

    $sql    = "$SELECT $proced('$metodo', '$codigo', '$linea', '$sub_linea', '$color', '$prod_tipo',
    '$unidad',  '$proveedor','$procedencia','$almacen', '$iva','$item', '$descripcion', 
    '$prec_vta1', '$prec_vta2',' $prec_vta3', '$prec_vta4',  '$prec_vta5',   
    '$garantia', '$talla','$peso', '$piecubico','$venc', '$fec_venc',
    '$campo01', '$campo02', '$campo03', '$campo04', '$usuario', '$activo')";

    $result['sql'] = $sql;
    $query   = $bd->consultar($sql);
    

  }catch (Exception $e) {
   $error =  $e->getMessage();
   $result['error'] = true;
   $result['mensaje'] = $error;

   $bd->log_error("Aplicacion", "sc_producto.php",  "$usuario", "$error", "$sql");
 }

}
print_r(json_encode($result));
return json_encode($result);

?>
