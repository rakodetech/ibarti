<?php   
include_once('../../funciones/funciones.php');
require("../../autentificacion/aut_config.inc.php");
require_once("../../".class_bd);
$bd = new DataBase();
 	$typing     = $_GET['q'];
	$filtro     = $_GET['filtro'];
	$where  = " WHERE productos.codigo = productos.codigo ";
	switch ($filtro) {	
		case "codigo":
		   $where  .= " AND LOCATE('$typing', productos.codigo) "; 		  
		break;
		case "serial":
		   $where  .= " AND LOCATE('$typing', productos.item) "; 		  
		break;
		case "descripcion":
		   $where  .= " AND LOCATE('$typing', productos.descripcion) "; 		  		   
	 break;		
	}	
	
	$sql = "SELECT productos.codigo, productos.item,  productos.descripcion                  
              FROM productos 
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