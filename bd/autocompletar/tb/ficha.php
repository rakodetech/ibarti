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
	
		case "codigo":
		   $where  .= " WHERE LOCATE('$typing', v_ficha.cod_ficha) "; 		  			
		break;   	
		case 'cedula':
		   $where  .= " WHERE LOCATE('$typing',  v_ficha.cedula) "; 
        break;
				
		case 'nombres':
		   $where  .= " WHERE LOCATE('$typing', v_ficha.nombres) "; 		  
		break;		

		case 'apellidos':
		   $where  .= " WHERE LOCATE('$typing', v_ficha.apellidos) "; 		  
		break;		

		case 'trabajador':
		   $where  .= " WHERE LOCATE('$typing', v_ficha.ap_nombre) "; 		  
		break;				
		
		}	

    $sql ="SELECT v_ficha.cod_ficha, v_ficha.cedula, v_ficha.ap_nombre 
             FROM v_ficha 
		          $where
			ORDER BY v_ficha.ap_nombre DESC "; 

   $query = $bd->consultar($sql);

	while ($datos=$bd->obtener_fila($query,0)){
 			

	$descripcion = "(".$datos['cedula'].")&nbsp;".$datos[2]."&nbsp; (".$datos['cod_ficha'].")"; 
	$cod          = $datos[0];
?>

<li onselect=" this.setText('<?php echo $descripcion?>').setValue('<?php echo  $cod ?>') ">
  <b></b> <?php echo $descripcion?>

</li>
<?php }?>