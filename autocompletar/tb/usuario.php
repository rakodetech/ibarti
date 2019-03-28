<?php   
//   require('../../autentificacion/aut_config.inc.php');
 //    mysql_select_db($bd_cnn,$cnn);
/*
SELECT men_usuarios.codigo, men_usuarios.cedula,
men_usuarios.nombre, men_usuarios.apellido,
men_usuarios.login
FROM men_usuarios 
*/

include_once('../../funciones/funciones.php');
require("../../autentificacion/aut_config.inc.php");
require_once("../../".class_bd);
$bd = new DataBase();
	$typing     = $_GET['q'];
	$filtro     = $_GET['filtro'];
	$where  = " ";
	switch ($filtro){	
		case 'cedula':
		   $where  .= " WHERE LOCATE('$typing',  men_usuarios.cedula) "; 
        break;
		case 'nombre':
		   $where  .= " WHERE LOCATE('$typing', men_usuarios.nombres) "; 		  
	 break;
		case 'apellido':
		   $where  .= " WHERE LOCATE('$typing',  men_usuarios.apellido) "; 
        break;		
	}	

    $sql ="SELECT men_usuarios.codigo, men_usuarios.cedula,
                  men_usuarios.nombre, men_usuarios.apellido
             FROM men_usuarios 
		   ".$where." ORDER BY apellido DESC"; 

   $query = $bd->consultar($sql);

	while ($datos=$bd->obtener_fila($query,0)){
 			

	$descripcion = $datos['apellido']." &nbsp; ".$datos['nombre']." &nbsp;(".$datos['cedula'].")"; 
	$cod          = $datos[0];
?>

<li onselect=" this.setText('<?php echo $descripcion?>').setValue('<?php echo  $cod ?>') ">
  <b></b> <?php echo $descripcion?>

</li>
<?php }?>