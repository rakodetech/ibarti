<?php
define("SPECIALCONSTANT", true);
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bdI);
$cliente = $_POST['codigo'];
$tabla   = "clientes_ubic";
$bd      = new DataBase();
$archivo = "clientes_ubic";
$titulo  = " Consulta De Puesto de Trabajo";

$sql = " SELECT * FROM clientes_ub_puesto
					WHERE clientes_ub_puesto.cod_cliente = clientes_ub_puesto.cod_cliente
			ORDER BY 3 DESC ";

 $query = $bd->consultar($sql);
?>

<div  class="tabla_sistema"><table width="100%">
		<tr>
			<th width="20%">Codigo</th>
  		<th width="50%">Nombre</th>
      <th width="20%" >Status</th>
		  <th width="10%"><img src="imagenes/nuevo.bmp" alt="Agregar" onclick="Cons_puesto('', 'agregar')" title="Agregar Registro" width="30px" height="30px" border="null"/></th>
		</tr>
    <?php
	$valor = 0;

		while ($datos=$bd->obtener_fila($query,0)){

   	$Borrar = "Borrar01('".$datos[0]."')";
        echo '<tr>
                <td>'.$datos["codigo"].'</td>
				  			<td>'.longitudMax($datos["nombre"]).'</td>
				  			<td>'.statuscal($datos["status"]).'</td>
				  			<td><img onclick="Cons_puesto(\''.$datos[0].'\', \'modificar\')" src="imagenes/actualizar.bmp" alt="Modificar" title="Modificar Registro" width="20" height="20" border="null"/></a>&nbsp;<img src="imagenes/borrar.bmp"  width="20px" height="20px" title="Borrar Registro" border="null" onclick="'.$Borrar.'"/></td>
            </tr>';
        }

	?>
    </table>
</div>
<div align="center"><br/>
	<span class="art-button-wrapper">
				 <span class="art-button-l"> </span>
				 <span class="art-button-r"> </span>
		 <input type="button" id="volver" value="Cerrar" onClick="CloseModal();" class="readon art-button" />
		 </span>
		</div>
