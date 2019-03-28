<?php   
//   require('../../autentificacion/aut_config.inc.php');
 //    mysql_select_db($bd_cnn,$cnn);
include_once('../../funciones/funciones.php');
require("../../autentificacion/aut_config.inc.php");
require_once("../../".class_bd);
$bd = new DataBase();
	$typing     = $_GET['q'];
	$filtro     = $_GET['filtro'];


	$where  = "  WHERE v_preingreso.cod_status = control.preingreso_aprobado ";

	switch ($filtro) {
	
		case "codigo":
		   $where  .= " AND LOCATE('$typing', ficha.cod_ficha) "; 		  	
		break;   
		case 'cedula':
		   $where  .= " AND LOCATE('$typing',  v_preingreso.cedula) "; 
        break;
				
		case 'nombres':
		   $where  .= " AND LOCATE('$typing', v_preingreso.nombres) "; 		  
		break;		

		case 'apellidos':
		   $where  .= " AND LOCATE('$typing', v_preingreso.apellidos) "; 		  
		break;		

		case 'trabajador':
		   $where  .= " AND LOCATE('$typing', v_preingreso.ap_nombre) "; 		  
		break;				
		
		}	

    $sql ="SELECT IFNULL(ficha.cod_ficha, 'NUEVO INGRESO') as cod_ficha,  v_preingreso.cedula, 
	              v_preingreso.ap_nombre 
             FROM v_preingreso LEFT JOIN ficha ON v_preingreso.cedula = ficha.cedula,  control 
		          $where
			ORDER BY ap_nombre DESC "; 
			
   $query = $bd->consultar($sql);

	while ($datos=$bd->obtener_fila($query,0)){
 			

	$descripcion = "(".$datos['cedula'].")&nbsp;".$datos[2]."&nbsp; (".$datos['cod_ficha'].")"; 
	$cod          = $datos['cedula'];
?>

<li onselect=" this.setText('<?php echo $descripcion?>').setValue('<?php echo  $cod ?>') ">
  <b></b> <?php echo $descripcion?>

</li>
<?php }?>