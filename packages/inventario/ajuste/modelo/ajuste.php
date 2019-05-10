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

if(isset($_POST['metodo'])){
	try {
    if(($metodo == "agregar") or ($metodo == "modificar" or ($metodo == "anular"))){
      $anulado = "F";
      $nro_ajuste_c = "";
      if($metodo == "agregar"){

        $sql = " SELECT a.n_ajuste FROM control a ";
        $query = $bd->consultar($sql);
        $data =$bd->obtener_fila($query);
        $nro_ajuste   =  $data[0];
        $cod_ajuste = $nro_ajuste + 1;
        $sql = " INSERT INTO ajuste(codigo, cod_tipo,referencia,cod_proveedor, fecha,  motivo,
        total, cod_us_ing, fec_us_ing, cod_us_mod, fec_us_mod)
        VALUES ($cod_ajuste, '$tipo','$referencia','$proveedor','$fecha', '$descripcion',
        '$total',
        '$us', CURRENT_TIMESTAMP, '$us', CURRENT_TIMESTAMP); ";
        $bd->consultar($sql);
        $sql = " UPDATE control SET n_ajuste = $cod_ajuste; ";
        $bd->consultar($sql);
      }elseif ($metodo == "modificar") {

        $sql = "UPDATE ajuste SET
        fecha           = '$fecha',              motivo = '$descripcion',
        total           = '$total',
        cod_us_mod      = '$us',            fec_us_mod     = CURRENT_TIMESTAMP
        WHERE codigo          = $nro_ajuste;";
        $bd->consultar($sql);

        $sql = " DELETE FROM ajuste_reng WHERE cod_ajuste =  '$nro_ajuste' ;";
        $bd->consultar($sql);
      }elseif ($metodo == "anular") {
       $anulado = "T";
       $sql = " SELECT a.n_ajuste FROM control a ";
       $query = $bd->consultar($sql);
       $data =$bd->obtener_fila($query);
       $nro_ajuste  =  $data[0];
       $cod_ajuste = $nro_ajuste + 1;
       $nro_ajuste_c = $nro_ajuste;
       $sql = " UPDATE control SET n_ajuste = $cod_ajuste; ";
       $bd->consultar($sql);
       $sql = "UPDATE ajuste SET anulado = 'T'
       WHERE codigo          = $nro_ajuste;";
       $bd->consultar($sql);
       $sql = " INSERT INTO ajuste(codigo, cod_tipo,referencia,cod_proveedor, fecha,  motivo,
       total, cod_us_ing, fec_us_ing, cod_us_mod, fec_us_mod,anulado)
       VALUES ($cod_ajuste, '$tipo','$referencia','$proveedor', '$fecha', '$descripcion',
       '$total', '$us', CURRENT_TIMESTAMP, '$us', CURRENT_TIMESTAMP,'T'); ";
       $bd->consultar($sql);
     }

     foreach($ped_reng as $obj) {
      $sql = " INSERT INTO ajuste_reng (cod_ajuste, reng_num, cod_almacen,
      cod_producto,fec_vencimiento,lote, cantidad,  costo,  neto, aplicar,anulado,cod_anulado) VALUES
      ($cod_ajuste, '$obj->reng_num', '$obj->cod_almacen', '$obj->cod_producto', 
      '','$obj->lote',$obj->cantidad, $obj->costo, $obj->neto, '$aplicar','$anulado','$nro_ajuste_c') ";
      $bd->consultar($sql);
    }
    $result["sql"] = $sql;

  }

}catch (Exception $e) {
 $error =  $e->getMessage();
 $result['error'] = true;
 $result['mensaje'] = $error;
 $bd->log_error("Aplicacion", "sistema/sc_ajuste.php",  "$us", "$error", "$sql");
}
}
print_r(json_encode($result));
return json_encode($result);
//     $bd->start();
// $bd->commit();
//  $bd->rollback();
// $bd->start();
?>
