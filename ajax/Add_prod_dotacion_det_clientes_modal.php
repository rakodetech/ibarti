<?php
include_once('../funciones/funciones.php');
require "../autentificacion/aut_config.inc.php";
require "../".class_bd;
require "../".Leng;

$bd = new DataBase();
//require_once('../autentificacion/aut_config.inc.php');
//include_once('../funciones/mensaje_error.php');
$rel   = $_POST['codigo'];
$bloqueEANS=$_POST['numero'];
$vinculo    = "inicio.php?area=formularios/Add_EANS_clientes.php";
$where="1=1";
if ($rel <> "") { $where.=" AND prod_ean.cod_producto='$rel'"; }

$where.=" ORDER BY prod_ean.cod_ean DESC";
$query="SELECT count(*) as filas FROM productos,prod_ean WHERE productos.item=prod_ean.cod_producto AND ".$where;
$sql="SELECT prod_ean.cod_producto as codigo,prod_ean.cod_ean as eans FROM productos,prod_ean WHERE productos.item=prod_ean.cod_producto AND ".$where;

$rs_busqueda=$bd->consultar($query);
$filas=mysql_result($rs_busqueda,0,"filas");

$titulo="Listado de EANS";
$metodo="Agregar";
$Borrar="inicio.php?area=formularios/borrar_EANS_clientes.php";
$ndx='tabla' + '$bloqueEANS';    
$procesar="Procesar01('".$rel."')";
$salida='salir';
$salir = "Salir01('".$salida."')";
   $query = $bd->consultar($sql);

		echo '<table width="100%" border="2" class="fondo00" id="tabla1" name="'.$ndx.'">
			<tr>
				<th width="25%" class="etiqueta">Codigo</th>
				<th width="25%" class="etiqueta">Eans</th>
            	<th width="26%" class="etiqueta">Ok</th>
				<th width="4%"><a href="'.$vinculo.'&metodo=agregar"><img src="imagenes/nuevo.bmp" alt="Agregar Registro" width="20px" height="20px" title="Agregar Registro" border="null" /></a></th></tr>';
		 $valor = 0;
        
	    while($row02=$bd->obtener_fila($query,0)){

		   $clickip = "Clickup('".$row02["codigo"]."','".$row02["eans"]."')";  
           
		if ($valor == 0){
			$fondo = 'fondo01';
		    $valor = 1;
		}else{
			$fondo = 'fondo02';
			$valor = 0;
		}
		echo'<tr class="'.$fondo.'">
			  <td class="texto">'.$row02["codigo"].'</td>
			  <td class="texto">'.$row02["eans"].'</td>
			
			  <td class="texto"> <td class="aCentro" width="5%"><input type="checkbox" name="checkbox_socio" id="checkbox_socio" value="'.$row02["eans"].'" onclick="'.$clickip.'")</td>
		     </tr>';
		}
echo '</table>'; mysql_free_result($query);
echo '<tr class="'.$fondo.'">
			  <td class="texto"><img src="imagenes/detalle.bmp"  width="20px" height="20px" title="Cerrar" border="null" onclick="'.$procesar.'" class="imgLink"/></td>
			  <td class="texto"><img src="imagenes/detalle.bmp"  width="20px" height="20px" title="Cerrar" border="null" onclick="'.$salir.'" class="imgLink"/></td>
		</tr>'

 
?>
