<?php   
include_once('../../funciones/funciones.php');
require("../../autentificacion/aut_config.inc.php");
require_once("../../".class_bd);
$bd = new DataBase();
 	$typing     = $_GET['q'];
	
	$where  = " AND LOCATE('".$typing."',nov_procesos.codigo)";
	
	
	$sql = "SELECT nov_procesos.codigo , novedades.descripcion,nov_procesos.fec_us_mod from nov_procesos,novedades where nov_procesos.cod_novedad = novedades.codigo".$where." order by nov_procesos.fec_us_mod desc";
   $query = $bd->consultar($sql);

	while ($datos=$bd->obtener_fila($query,0)){
        
	$descripcion = "".$datos[0]." - (".$datos[2]."(".$datos[1]."))"; 
	$codigo      = $datos[0];
?>

<li onselect=" this.setText('<?php echo $descripcion;?>').setValue('<?php echo  $codigo;?>') ">
  <b></b> <?php echo $descripcion;?>

</li>
<?php }?>