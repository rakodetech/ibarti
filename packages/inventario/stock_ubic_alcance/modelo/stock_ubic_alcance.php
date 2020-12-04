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
//$result = json_encode($ped_reng[0]['eans']);
//  $nombre      = htmlentities($nombre);

if(isset($_POST['metodo'])){
	try {
    if(($metodo == "agregar") or ($metodo == "modificar" or ($metodo == "anular"))){
      $anulado = "F";
      $nro_stock_alcance_c = "";
      if($metodo == "agregar"){
        if($total == ""){
          $total = 0;
        }
        $sql = " SELECT a.n_stock_alcance FROM control a ";
        $query = $bd->consultar($sql);
        $data =$bd->obtener_fila($query);
        $nro_stock_alcance   =  $data[0];
        $cod_stock_alcance = $nro_stock_alcance + 1;
        $sql = " INSERT INTO stock_alcance(codigo, cod_tipo,referencia, fecha,  motivo,
        total, cod_us_ing, fec_us_ing, cod_us_mod, fec_us_mod)
        VALUES ($cod_stock_alcance, '$tipo','$referencia','$fecha', '$descripcion',
        '$total', '$us', CURRENT_TIMESTAMP, '$us', CURRENT_TIMESTAMP); ";
        $bd->consultar($sql);
        $sql = " UPDATE control SET n_stock_alcance = $cod_stock_alcance; ";
        $bd->consultar($sql);
      }elseif ($metodo == "modificar") {

        $sql = "UPDATE stock_alcance SET
        fecha           = '$fecha',              motivo = '$descripcion',
        total           = '$total',
        cod_us_mod      = '$us',            fec_us_mod     = CURRENT_TIMESTAMP
        WHERE codigo          = $nro_stock_alcance;";
        $bd->consultar($sql);

        $sql = " DELETE FROM stock_alcance_reng WHERE cod_stock_alcance =  '$nro_stock_alcance' ;";
        $bd->consultar($sql);
      }elseif ($metodo == "anular") {
       $anulado = "T";
       $sql = " SELECT a.n_stock_alcance FROM control a ";
       $query = $bd->consultar($sql);
       $nro_stock_alcance_c = $nro_stock_alcance;
       $data =$bd->obtener_fila($query);
       $nro_stock_alcance  =  $data[0];
       $cod_stock_alcance = $nro_stock_alcance + 1;
       $sql = " UPDATE control SET n_stock_alcance = $cod_stock_alcance; ";
       $result['sql'][]=$sql;
       $bd->consultar($sql);
       $sql = "UPDATE stock_alcance SET anulado = 'T'
       WHERE codigo          = $nro_stock_alcance_c;";
       $result['sql'][]=$sql;
       $bd->consultar($sql);
       $sql = " INSERT INTO stock_alcance(codigo, cod_tipo,referencia, fecha,  motivo,
       total, cod_us_ing, fec_us_ing, cod_us_mod, fec_us_mod,anulado)
       VALUES ($cod_stock_alcance, '$tipo','$referencia', CURRENT_TIMESTAMP, '$descripcion',
       '$total', '$us', CURRENT_TIMESTAMP, '$us', CURRENT_TIMESTAMP,'T'); ";
       $result['sql'][]=$sql;
       $bd->consultar($sql);
     }

     foreach($ped_reng as $obj) {
      if($nro_stock_alcance_c == ""){
        $nro_stock_alcance_c = 0;
      }
      $sql = " INSERT INTO stock_alcance_reng (cod_stock_alcance, reng_num, cod_almacen,
      cod_producto,fec_vencimiento,lote, cantidad,  costo,  neto, aplicar,anulado,cod_anulado) VALUES
      ($cod_stock_alcance, '$obj->reng_num', '$obj->cod_almacen', '$obj->cod_producto', 
      '0000-00-00','$obj->lote',$obj->cantidad, $obj->costo, $obj->neto, '$aplicar','$anulado','$nro_stock_alcance_c') ";
      $result['sql_reng'][]=$sql;
      $bd->consultar($sql);
      if(count($obj->eans)>0){
        foreach($obj->eans as $ean) {
          $sql = " INSERT INTO stock_alcance_reng_eans(cod_stock_alcance, reng_num, cod_ean) VALUES
          ($cod_stock_alcance, '$obj->reng_num', '$ean') ";
          $bd->consultar($sql);
          if($aplicar=='IN'){
            $sql = " UPDATE prod_ean SET cod_almacen = '$obj->cod_almacen' , inStock='T'
            WHERE cod_producto = '$obj->cod_producto' AND cod_ean = '$ean'";
            $bd->consultar($sql);
          }else{
            $sql = " UPDATE prod_ean SET inStock='F'
            WHERE cod_producto = '$obj->cod_producto' AND cod_ean = '$ean'";
            $bd->consultar($sql);
          }  
        }
      }
    }
    $result["sql"] = $sql;

  }

}catch (Exception $e) {
 $error =  $e->getMessage();
 $result['error'] = true;
 $result['mensaje'] = $error;
 $bd->log_error("Aplicacion", "sistema/sc_stock_alcance.php",  "$us", "$error", "$sql");
}
}
print_r(json_encode($result));
return json_encode($result);
//     $bd->start();
// $bd->commit();
//  $bd->rollback();
// $bd->start();
?>
