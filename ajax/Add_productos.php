<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase(); 



//require_once('../autentificacion/aut_config.inc.php'); 
//include_once('../funciones/mensaje_error.php');

$archivo    = "productos";
$tabla      = "";
$linea      = $_POST['linea'];
$sub_linea  = $_POST['sub_linea'];
$prod_tipo  = $_POST['prod_tipo'];
$tipo_mov   = $_POST['tipo_mov'];

$Nmenu      = $_POST['Nmenu'];
$mod        = $_POST['mod'];
$filtro     = $_POST['filtro'];
$producto    = $_POST['producto'];

$vinculo = "inicio.php?area=pestanas/add_$archivo&Nmenu=$Nmenu&mod=$mod&archivo=$archivo";

	$where =" WHERE productos.cod_linea     = prod_lineas.codigo 
				AND productos.cod_sub_linea = prod_sub_lineas.codigo 
				AND productos.cod_prod_tipo = prod_tipos.codigo ";


	if($linea != "TODOS"){		
		$where .= " AND prod_lineas.codigo  = '$linea' ";
	}
	if($sub_linea != "TODOS"){
		$where .= "  AND prod_sub_lineas.codigo = '$sub_linea' ";
	}

	if($prod_tipo != "TODOS"){
		$where .= "  AND prod_tipos.codigo = '$prod_tipo' ";
	}

	if($tipo_mov != "TODOS"){
		$where .= "  AND v_prod_ultimo_mov.cod_mov_tipo = '$tipo_mov' ";
	}

	if(($filtro != "TODOS") and ($producto) != ""){
		$where .= "  AND productos.codigo = '$producto' ";
	}

	$sql = "SELECT productos.codigo, prod_lineas.descripcion AS linea,
                   prod_sub_lineas.descripcion AS sub_linea,   prod_tipos.descripcion AS prod_tipo,
				   productos.item, productos.descripcion, IFNULL(v_prod_ultimo_mov.mov_tipo , 'SIN MOVIMIENTO') AS mov_tipo,
				   productos.status
              FROM productos LEFT JOIN v_prod_ultimo_mov ON productos.codigo = v_prod_ultimo_mov.cod_producto ,
			       prod_lineas , prod_sub_lineas , prod_tipos ,
                   control
		    $where	   		   
		    ORDER BY 1 DESC "; 
?><table width="100%" border="0" align="center">
		<tr class="fondo00">
			<th width="10%" class="etiqueta">Codigo</th>
   			<th width="16%" class="etiqueta">Serial</th>
			<th width="26%" class="etiqueta">Producto</th>
            <th width="16%" class="etiqueta">Linea</th>
            <th width="16%" class="etiqueta">Movimiento</th>
            <th width="10%" class="etiqueta">Activo</th>
		    <th width="6%" align="center"><a href="<?php echo $vinculo."&codigo=''&metodo=agregar";?>"><img src="imagenes/nuevo.bmp" alt="Detalle" title="Detalle Registro" width="25px" height="25px" border="null"/></a></th> 
		</tr>
    <?php       
	$valor = 0;
    $query = $bd->consultar($sql);

		while ($datos=$bd->obtener_fila($query,0)){
		if ($valor == 0){
			$fondo = 'fondo01';
		$valor = 1;
		}else{
			$fondo = 'fondo02';
			$valor = 0;
		}

	// $Modificar = "Add_Mod01('".$datos[0]."', 'modificar')";
	   $Borrar = "Borrar01('".$datos[0]."')";
        echo '<tr class="'.$fondo.'"> 
                  <td class="texo">'.longitudMin($datos["codigo"]).'</td>
				  <td class="texo">'.longitudMin($datos["item"]).'</td> 
                  <td class="texo">'.longitud($datos["descripcion"]).'</td>
				  <td class="texo">'.longitudMin($datos["linea"]).'</td>
				  <td class="texo">'.longitudMin($datos["mov_tipo"]).'</td>
				  <td class="texo">'.statuscal($datos["status"]).'</td>
				  <td align="center"><a href="'.$vinculo.'&codigo='.$datos[0].'&metodo=modificar"><img src="imagenes/actualizar.bmp" alt="Modificar" title="Modificar Registro" width="20" height="20" border="null"/></a>&nbsp;<img src="imagenes/borrar.bmp"  width="20px" height="20px" title="Borrar Registro" border="null" onclick="'.$Borrar.'" class="imgLink"/></td> 
            </tr>'; 
        }     
		mysql_free_result($query);
     echo '<input type="hidden" name="tabla" id="tabla" value="'.$tabla.'"/>';
	?>
    </table>   