<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase();

$tabla       = "conceptos";
$tabla_id    = "codigo";
$codigo      = $_POST['codigo'];
$descripcion = strtoupper($_POST['descripcion']);
$valor       = $_POST['valor'];
$abrev       = strtoupper($_POST['abrev']);
$horario     = $_POST['horario'];
$as_perfecta = $_POST['asist_perfecta'];
$as_diaria   = $_POST['asist_diaria'];
$rol         = $_POST['rol'];
$categoria   = $_POST['categoria'];
$usuario     = $_POST['usuario'];
$proced      = $_POST['proced'];
$conceptos   = $_POST['conceptos'];

$status      = $_POST['activo'];
$href        = $_POST['href'].'&categoria='.$categoria.'';
$metodo    = $_POST['metodo'];

if (isset($_POST['metodo'])) {
   $i=$_POST['metodo'];

	switch ($i) {
    case 'agregar':	case 'modificar':

	 $sql    = "$SELECT $proced('$metodo', '$codigo', '$horario',  '$descripcion',
	                            '$abrev', '$valor', '$as_perfecta','$as_diaria',
								'$usuario', '$status')";
		 $query = $bd->consultar($sql);
    break;

	case 'renglones':
	 			   $sql = "DELETE FROM concepto_det WHERE codigo = '$codigo' AND  cod_rol = '$rol'
		                      AND concepto_det.cod_categoria = '$categoria'";
			    $query = $bd->consultar($sql);

			 foreach ($conceptos as $valorX){
				 $cantidad = $_POST[$valorX];

 			    $sql = "INSERT INTO concepto_det
							 (codigo, cod_concepto, checks, cantidad,  cod_rol, cod_categoria,
							  fec_us_ing, cod_us_ing, fec_us_mod, cod_us_mod)
					  VALUES ('$codigo', '$valorX', 'S', '$cantidad', '$rol', '$categoria',
					          '$date', '$usuario', '$date', '$usuario')";
			    $query = $bd->consultar($sql);
			 }
	break;
	case 'renglones_masivo':
	 			    $sql = "DELETE FROM concepto_det WHERE codigo = '$codigo'
		                            AND concepto_det.cod_categoria = '$categoria'";
			    $query = $bd->consultar($sql);


			 foreach ($conceptos as $valorX){
				 $cantidad = $_POST[$valorX];
				 		    $sql = "INSERT INTO concepto_det
									(codigo, cod_concepto, checks, cantidad,  cod_rol, cod_categoria,
									fec_us_ing, cod_us_ing, fec_us_mod, cod_us_mod)
							SELECT '$codigo', '$valorX', 'S', '$cantidad', roles.codigo, '$categoria',
							       '$date', '$usuario', '$date', '$usuario'
							   FROM roles WHERE roles.`status` = 'T'";
			    $query = $bd->consultar($sql);
			 }
	break;
	}
}
 require_once('../funciones/sc_direccionar.php');
?>
