<?php
define("SPECIALCONSTANT", true);
include_once('../../../../funciones/funciones.php');
require "../../../../autentificacion/aut_config.inc.php";
require "../../../../".class_bdI;
$bd = new DataBase();
$result = array();

foreach($_POST as $nombre_campo => $valor){
  if($valor != "ped_reng"){
    $variables = "\$".$nombre_campo."='".$valor."';";
    eval($variables);
  }
}

//  $xx  = (isset($_POST["xx"]))?$_POST["xx"]:"";
$ped_reng = json_decode(stripslashes($_POST["ped_reng"]));
//  $nombre      = htmlentities($nombre);

try {
       /* $sql = " SELECT a.n_ajuste FROM control a ";
        $query = $bd->consultar($sql);
        $data =$bd->obtener_fila($query);
        $nro_ajuste   =  $data[0];
        $nro_ajuste2 = $nro_ajuste +1;
        $sql = " INSERT INTO ajuste(codigo, cod_tipo, fecha,  motivo,
        total, cod_us_ing, fec_us_ing, cod_us_mod, fec_us_mod)
        VALUES ($nro_ajuste, 'ENT', CURRENT_TIMESTAMP, '$descripcion',
        '$total','$us', CURRENT_TIMESTAMP, '$us', CURRENT_TIMESTAMP); ";
        $bd->consultar($sql);

        $sql = " INSERT INTO ajuste(codigo, cod_tipo, fecha,  motivo,
        total, cod_us_ing, fec_us_ing, cod_us_mod, fec_us_mod)
        VALUES ($nro_ajuste2, 'SAL', CURRENT_TIMESTAMP, '$descripcion',
        '$total','$us', CURRENT_TIMESTAMP, '$us', CURRENT_TIMESTAMP); ";
        $bd->consultar($sql);
        $sql = " UPDATE control SET n_ajuste = $nro_ajuste+2; ";
        $bd->consultar($sql);
*/
                           foreach($ped_reng as $obj) {
     /* $sql = " INSERT INTO ajuste_reng (cod_ajuste, reng_num, cod_almacen, lote,
                                        cod_producto, cantidad,  precio,  neto) VALUES
                         ($nro_ajuste, '$obj->reng_num', 'alm_destino', '$obj->lote',
                         '$obj->cod_producto', $obj->cantidad, $obj->precio,  $obj->neto) ";

                         $bd->consultar($sql);*/

                         $sql = "$SELECT $proced('$alm_origen', '$alm_destino','$obj->lote',
                         '$obj->cod_producto', $obj->cantidad, '$us')";

                        $bd->consultar($sql);
                       }

                /*                                  foreach($ped_reng as $obj) {
      $sql = " INSERT INTO ajuste_reng (cod_ajuste, reng_num, cod_almacen, lote,
                                        cod_producto, cantidad,  precio,  neto) VALUES
                         ($nro_ajuste2, '$obj->reng_num', '$alm_origen', '$obj->lote',
                         '$obj->cod_producto', $obj->cantidad, $obj->precio,  $obj->neto) ";

                         $bd->consultar($sql);
                       }*/


                       $result['sql'] = $sql;
                     }catch (Exception $e) {
                       $error =  $e->getMessage();
                       $result['error'] = true;
                       $result['mensaje'] = $error;
                       $bd->log_error("Aplicacion", "inventario/sc_movimiento.php",  "$us", "$error", "$sql");
                     }

                     print_r(json_encode($result));
                     return json_encode($result);
                     ?>
