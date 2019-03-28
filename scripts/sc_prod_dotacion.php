<script type="text/javascript" src="../jquery.js"></script>
<script language="JavaScript" type="text/javascript">
function Pdf(){
 	$('#pdf').attr('action', '../reportes/rp_inv_prod_dotacion.php');
	$('#pdf').submit();
	}
</script>

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
$tabla_id = 'codigo';

$codigo      = $_POST["codigo"];
$fecha       = conversion($_POST["fecha"]);
$descripcion = $_POST["descripcion"];
$trabajador  = $_POST["trabajador"];
$incr        = $_POST["incremento"];

$campo01     = $_POST["campo01"];
$campo02     = $_POST["campo02"];
$campo03     = $_POST["campo03"];
$campo04     = $_POST["campo04"];
$usuario = $_POST["usuario"];

$activo   = 'T';
$href     = $_POST['href'];
$proced   = $_POST['proced'];
$metodo   = $_POST['metodo'];

	if(isset($_POST['proced'])){
	 $sql    = "$SELECT $proced('$metodo', '$codigo', '$fecha', '$trabajador',
	                           '$descripcion',
							   '$campo01', '$campo02', '$campo03', '$campo04', '$usuario', '$activo')";
	 $query = $bd->consultar($sql);
// procedimiento debe retonrar un valor pediente.. OJO ///
// y eliminar el SELECT MAX

if($metodo == "agregar"){
    $sql    = "SELECT MAX(prod_dotacion.codigo) codigo FROM prod_dotacion
                WHERE cod_ficha = '$trabajador' ";
	 $query = $bd->consultar($sql);
	 $datos = $bd->obtener_fila($query,0);
	 $codigo = $datos[0];
}

	for ($i = 1; $i <= $incr; $i++) {
		if(isset($_POST['relacion_'.$i.''])) {
   		$relacion = $_POST['relacion_'.$i.''];
		} else {
   		$relacion =  "";
		}

		   if(($relacion !="")&& ($metodo == "agregar")){
		 //	$tipo     = $_POST['tipo'.$i.''];
			$producto = $_POST['producto_'.$i.''];
			$producto_old = $producto;
			$cantidad = $_POST['cantida_'.$i.''];
			$almacen = $_POST['almacen_'.$i.''];

			$sql = "$SELECT p_prod_dotacion_det('$metodo', '$codigo', '$producto', '$producto_old', '$almacen', '$cantidad')";
			$query = $bd->consultar($sql);
			}

			if($incr > $i){
				echo '<form id="pdf" name="pdf" action="" method="post" target="_blank">
						   <input type="hidden" id="codigo" name="codigo" value="'.$codigo.'">
				</form>';
				echo "<script> Pdf(); </script>";
			}
		}

	}

	require_once('../funciones/sc_direccionar.php');
?>
<body>

</body>
</html>
