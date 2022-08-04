<?php   
//   require('../../autentificacion/aut_config.inc.php');
 //    mysql_select_db($bd_cnn,$cnn);
include_once('../../funciones/funciones.php');
require("../../autentificacion/aut_config.inc.php");
require_once("../../".class_bd);
$bd = new DataBase();
	$typing     = $_GET['q'];
	$filtro     = $_GET['filtro'];	
	$where  = " ";
	
	switch ($filtro) {
	
		case 'cedula':
		   $where  .= " WHERE LOCATE('$typing',  v_preingreso.cedula) "; 
        break;
				
		case 'nombres':
		   $where  .= " WHERE LOCATE('$typing', v_preingreso.nombres) "; 		  
		break;		

		case 'apellidos':
		   $where  .= " WHERE LOCATE('$typing', v_preingreso.apellidos) "; 		  
		break;		

		case 'trabajador':
		   $where  .= " WHERE LOCATE('$typing', v_preingreso.ap_nombre) "; 		  
		break;		
	}	

    $sql ="SELECT v_preingreso.cedula, v_preingreso.ap_nombre
             FROM v_preingreso
	   ".$where." ORDER BY v_preingreso.ap_nombre DESC "; 
   $query = $bd->consultar($sql);
	while ($datos=$bd->obtener_fila($query,0)){
 			

	$descripcion = "".$datos['ap_nombre'].")&nbsp;(".$datos['cedula'].")"; 
	$cod          = $datos[0];
?>

<li onselect=" this.setText('<?php echo $descripcion?>').setValue('<?php echo  $cod ?>') ">
  <b></b> <?php echo $descripcion?>

</li>
<?php }?>