<?php
define("SPECIALCONSTANT", true);
require  "../../../autentificacion/aut_config.inc.php";
require_once "../../../".Funcion;
require_once  "../../../".class_bdI;


$clasificacion = $_POST['clasif'];
$tipo = $_POST['tipo'];
$cedula = $_POST['codigo_trabajador'];
$ficha = $_POST['codigo_supervisor'];
$observacion = $_POST['observacion'];
$respuesta = '';
$usuario = $_POST['usuario'];
$fecha = date("Y-m-d");
$hora = date("H:i:s");
$valores = $_POST['valores'];
$obs = $_POST['obs'];
//echo $fecha. $hora;

$sql = "INSERT INTO nov_check_list_trab (
    hora,
	cod_nov_clasif,
    cod_nov_tipo,
	cod_ficha,
	cedula,
	observacion,
	repuesta,
	cod_us_ing,
	fec_us_ing,
	cod_us_mod,
	fec_us_mod,
	cod_nov_status
)
VALUES(
    '$hora',
	'$clasificacion',
    '$tipo',
    '$ficha',
    '$cedula',
    '$observacion',
    '$respuesta',
    '$usuario',
    
    '$usuario',
    '$fecha',
    '$fecha',
    '01'
)";
echo "1:".$sql;
$sql = "SELECT MAX(codigo) from nov_check_list_trab";


//echo "2:".$sql;
/*
$metodo = $_POST['metodo'];
$codigo_supervisor = $_POST['codigo_supervisor'];
$codigo_trabajador = $_POST['codigo_trabajador'];*/
$sql = "INSERT INTO nov_check_list_trab_det (cod_check_list,
cod_novedades,
cod_valor,
valor,
valor_max,
observacion
) VALUES ";
$i=0;
foreach($valores as $novedad=>$valor){
    if($i==0){
        $sql.="('3','$novedad','$valor','$valor','$valor','".$obs[$novedad]."')";
    }else{
        $sql.=",('3','$novedad','$valor','$valor','$valor','".$obs[$novedad]."')";
    }
    $i++;
}

echo "3:".$sql;
/*
foreach($_POST as $key => $value){
    
    if($key=="valores"|| $key=="obs"){
        echo $key."=><br>";
        foreach($value as $indice => $valor){
            echo "*".$indice."=>'".$valor."'<br>";
        }
    }else{
        echo $key."=>'".$value."'<br>";
    }
}
*/
//echo json_encode($_POST);
?>
