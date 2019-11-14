<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
</head>
<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase();
//include_once('../funciones/mensaje_error.php');

$tabla_id = 'codigo';

$codigo      = $_POST["codigo"];
$linea       = $_POST["linea"];
$sub_linea   = $_POST["sub_linea"];		
$color       = $_POST["color"];		
$prod_tipo   = $_POST["prod_tipo"];
$unidad      = $_POST["unidad"];
$proveedor   = $_POST["proveedor"];
$almacen     = $_POST["almacen"];
$iva         = $_POST["iva"];
$item        = $_POST["item"];
$descripcion = $_POST["descripcion"];

// STOCK
//$cos_actual  = $_POST["cos_actual"];    
$cos_actual = 0;
//$fec_cos_actual = $_POST["fec_cos_actual"];
//$cos_promedio = $_POST["cos_promedio"];
$cos_promedio = 0;
//$fec_cos_prom = $_POST["fec_cos_prom"];
//$cos_ultimo   = $_POST["cos_ultimo"];
$cos_ultimo   = 0;
//$fec_cos_ultimo = $_POST["fec_cos_ultimo"];
//$stock_actual = $_POST["stock_actual"];
$stock_actual = 0;
//$stock_comp   = $_POST["stock_comp"];
$stock_comp   = 0;
//$stock_llegar = $_POST["stock_llegar"];
$stock_llegar = 0;
//$punto_pedido = $_POST["punto_pedido"];
$punto_pedido = 0;
//$stock_maximo = $_POST["stock_maximo"];
$stock_maximo = 0;
//$stock_minimo = $_POST["stock_minimo"];
$stock_minimo =0;
$garantia     = $_POST["garantia"];
$talla        = $_POST["talla"];
$peso         = $_POST["peso"];
$piecubico    = $_POST["piecubico"];
$venc         = $_POST["venc"];
$fec_venc     = conversion($_POST["fec_venc"]);

// PRECIO DE VENTA
$prec_vta1   = $_POST["prec_vta1"];
$prec_vta2   = $_POST["prec_vta2"];
$prec_vta3   = $_POST["prec_vta3"];
$prec_vta4   = $_POST["prec_vta4"];
$prec_vta5   = $_POST["prec_vta5"];

//$fec_prec_v1  = $_POST["fec_prec_v1"];
//$fec_prec_v2  = $_POST["fec_prec_v2"];
//$fec_prec_v3  = $_POST["fec_prec_v3"];
//$fec_prec_v4  = $_POST["fec_prec_v4"];
//$fec_prec_v5  = $_POST["fec_prec_v5"];

$campo01 = $_POST["campo01"];
$campo02 = $_POST["campo02"];
$campo03 = $_POST["campo03"];
$campo04 = $_POST["campo04"];

$activo      = statusbd($_POST["activo"]);

$href     = $_POST['href'];
$usuario  = $_POST['usuario']; 
$proced   = $_POST['proced'];
$metodo   = $_POST['metodo'];
	if(isset($_POST['proced'])){		

    $sql    = "$SELECT $proced('$metodo', '$codigo', '$linea', '$sub_linea', '$color', '$prod_tipo',
	                           '$unidad',  '$proveedor', '$almacen', '$iva', '$item',
							   '$descripcion', '$cos_actual', '$cos_promedio',  '$cos_ultimo',
							   '$stock_actual', '$stock_comp', '$stock_llegar',
							   '$punto_pedido', '$stock_maximo', '$stock_minimo', 
							   '$prec_vta1', '$prec_vta2',' $prec_vta3', '$prec_vta4',  '$prec_vta5',   
  							   '$garantia', '$talla','$peso', '$piecubico',
							   '$venc', '$fec_venc',
							   '$campo01', '$campo02', '$campo03', '$campo04', '$usuario', '$activo')";						  
	 $query = $bd->consultar($sql);	  			   		

	}
require_once('../funciones/sc_direccionar.php');  
?>
<body>
</body>
</html>