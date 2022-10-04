<?php   
include_once('../../funciones/funciones.php');
require("../../autentificacion/aut_config.inc.php");
require_once("../../".class_bd);
$bd = new DataBase();
 	$typing     = $_GET['q'];
	$filtro     = $_GET['filtro'];
	$where  = " WHERE productos.cod_linea = prod_lineas.codigo 
                  AND productos.cod_sub_linea = prod_sub_lineas.codigo 
	              AND productos.cod_prod_tipo = prod_tipos.codigo 
                  AND productos.`status` = 'T' ";
	switch ($filtro) {	
		case "codigo":
		   $where  .= " AND LOCATE('$typing', productos.codigo) "; 		  
		break;
		case "serial":
		   $where  .= " AND LOCATE('$typing', productos.item) "; 		  
		break;
		case "linea":
		   $where  .= " AND LOCATE('$typing', prod_lineas.descripcion) "; 		  
		break;				
		case "sub_linea":
		   $where  .= " AND LOCATE('$typing', prod_sub_lineas.descripcion) "; 		  
		break;				
		case "tipo":
		   $where  .= " AND LOCATE('$typing', prod_tipos.descripcion) "; 		  
		break;				
		case "descripcion":
		   $where  .= " AND LOCATE('$typing', productos.descripcion) "; 		  		   
	 break;		
	}	
	
	$sql = "SELECT productos.codigo, productos.item,
 	               productos.descripcion,  prod_tipos.descripcion AS prod_tipo,
	               prod_lineas.descripcion AS linea, prod_sub_lineas.descripcion AS sub_linea                  
              FROM productos , prod_lineas , prod_sub_lineas ,  prod_tipos 
		    $where            
          ORDER BY 3 DESC";
   $query = $bd->consultar($sql);
	while ($datos=$bd->obtener_fila($query,0)){

	$descripcion = "".$datos[1]." - (".$datos[0].")&nbsp;".$datos[2]; 
	$codigo      = $datos[0];
?>

<li onselect=" this.setText('<?php echo $descripcion;?>').setValue('<?php echo  $codigo;?>') ">
  <b></b> <?php echo $descripcion;?>

</li>
<?php }?>