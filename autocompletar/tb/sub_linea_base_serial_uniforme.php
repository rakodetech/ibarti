<?php   
include_once('../../funciones/funciones.php');
require("../../autentificacion/aut_config.inc.php");
require_once("../../".class_bd);
$bd = new DataBase();
$typing     = $_GET['q'];
$where  = "  ";

$sql = "SELECT prod_sub_lineas.codigo, prod_sub_lineas.descripcion            
FROM prod_sub_lineas, control
WHERE (LOCATE('$typing', prod_sub_lineas.codigo) OR LOCATE('$typing', prod_sub_lineas.descripcion))   
AND prod_sub_lineas.cod_linea = control.control_uniforme_linea      
ORDER BY 2 DESC";
$query = $bd->consultar($sql);
while ($datos=$bd->obtener_fila($query,0)){

	$descripcion = "".$datos[1]."&nbsp;";
	$codigo      = $datos[0];
?>

	<li onselect=" this.setText('<?php echo $descripcion;?>').setValue('<?php echo  $codigo;?>') ">
		<?php echo $descripcion;?>
	</li>
<?php 
	}
?>