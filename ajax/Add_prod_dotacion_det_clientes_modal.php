<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase();
$rel   = $_POST['codigo'];
$vinculo    = "inicio.php?area=formularios/Add_EANS_clientes.php";
$mensajep="Hola";
$cadena_busqueda=$_POST["codigo"];

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
?>
<html>
<head>
   <script language="javascript"> 
      function mensajex($mensaje) {
	      
	       alert("'.$mensaje.'");
	
      }
 
   </script> 
</head>
<body>  
<form id="formulario" name="formulario" >
<table width="100%" border="2" align="center" name="table1">
    <tr class="fondo00">
        <th width="15%" class="etiqueta">Cod Producto</th>
        <th width="15%" class="etiqueta">Codigo EANS</th>
        <th width="5%" class="etiqueta">OK</th>
    </tr>
    <?php
    $valor = 0;
    $query = $bd->consultar($sql);
    
    while ($datos = $bd->obtener_fila($query, 0)) {
        if ($datos["codigo"] == 0) {
            $fondo = 'fondo01';
        } else if ($datos["codigo"] < 0) {
            $fondo = 'fondo03';
        } else if ($datos["codigo"] > 0) {
            $fondo = 'fondo02';
        }
        echo '<tr class="' . $fondo . '">
			<td class="texto" id="center">' . $datos["codigo"] . '</td>
			<td class="texto" id="center">' . $datos["eans"] . '</td>
            <td class="aCentro" width="10%"><input type="checkbox" name="checkbox_socio" id="checkbox_socio" value="' . $datos["codigo"] . '"</td>
												
			</tr>';
      }; 
    ?>
   
</table>

</form>    
</body>
</html>
