<?php 
	$Nmenu = '450'; 
	require_once('autentificacion/aut_verifica_menu.php');
	$tabla = "control_armamento";
	$bd = new DataBase();
	$archivo = "control_armamento";
	$titulo = " CONTROL DE ARMAMENTO ";
	$vinculo = "inicio.php?area=pestanas/add_$archivo&Nmenu=".$_GET['Nmenu']."&mod=".$_GET['mod']."&titulo=$titulo&archivo=$archivo";
	
	if (isset($_GET['cod_estado'])){
	    	$cod_estado = $_GET['cod_estado'];
	$sql01 = "SELECT estados.codigo, estados.descripcion
                FROM estados
		       WHERE estados.codigo = '$cod_estado'";

	$query01 = $bd->consultar($sql01);		
    $row02   = $bd->obtener_fila($query01,0);
	$cod_estado = $row02[0]; 
    $estado    = $row02[1];
	
	$filtro = " AND estados.codigo = '$cod_estado' ";

	}else{
	$cod_estado = ""; 
    $estado    = "Seleccione...";
	
	$filtro = "";	
	}	
?>
<script language="JavaScript" type="text/javascript">
function FiltarX(ValorN){
	var mod = document.getElementById("mod").value;	
	var Nmenu = document.getElementById("Nmenu").value;
	var href = "inicio.php?area=formularios/Cons_control_armamento&Nmenu="+Nmenu+"&mod="+mod+"&cod_estado="+ValorN+"";
	window.location.href=""+href+"";		
	//alert(href);
}
</script>	
<div align="center" class="etiqueta_title"> CONSULTA GENERAL <?php echo $titulo;?> </div> <hr />
<div id="Contenedor01"></div>
<fieldset>
<legend>Filtros:</legend>
	<table width="98%">
		<tr><td width="10%">Estado: </td>
			<td width="40%"><select  name="estado" id="estado" style="width:200px;" onchange="FiltarX(this.value)">
					<option value="<?php echo $cod_estado?>"><?php echo $estado; ?></option> 
					<?php 
				$sql01 = "SELECT estados.codigo, estados.descripcion
                             FROM estados
                            WHERE estados.`status` = 'T'
					     ORDER BY 2 ASC";
	   			$query01 = $bd->consultar($sql01);		
		 		while($row01=$bd->obtener_fila($query01,0)){							   							
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';						   		
			   }?></select></td>
			<td width="50%">&nbsp; 
            <input type="hidden" name="Nmenu" id="Nmenu" value="<?php echo $Nmenu;?>" />
            <input type="hidden" name="mod" id="mod" value="<?php echo $mod;?>" />
             </td>
</tr>
</table>
</fieldset>
<div id="listar"><table width="99%" border="0" align="center">
		<tr class="fondo00">
			<th width="20%" class="etiqueta">Producto</th>
			<th width="10%" class="etiqueta">Serial</th>
  			<th width="15%" class="etiqueta">Estado</th>
            <th width="20%" class="etiqueta">Cliente</th>
            <th width="20%" class="etiqueta">Ubicacion</th>
             <th width="10%" class="etiqueta">Status</th>
		    <th width="5%" align="center"><a href="<?php echo $vinculo."&codigo=''&metodo=agregar";?>"><img src="imagenes/nuevo.bmp" alt="Agregar Registro" title="Agregar Registro" width="20px" height="20px" border="null"/></a></th> 
		</tr>
    <?php       
	$usuario = $_SESSION['usuario_cod'];
	$valor = 0;
	$sql = " SELECT prod_movimiento.codigo, productos.item AS serial,  
                    prod_movimiento.cod_producto, productos.descripcion AS producto,
                    clientes_ubicacion.cod_estado, estados.descripcion AS estado,
                    productos.campo01 AS n_porte, productos.campo02 AS fec_venc_permiso,
                    productos.campo03 , productos.campo04,
                    prod_movimiento.cod_cliente, clientes.nombre AS cliente,
                    prod_movimiento.cod_ubicacion, clientes_ubicacion.descripcion AS ubicacion,
                    prod_movimiento.fec_entrega, prod_movimiento.fec_retiro,
                    prod_movimiento.`status`
               FROM prod_movimiento, productos, clientes_ubicacion, clientes, estados, control
			  WHERE prod_movimiento.cod_producto = productos.codigo
			    AND prod_movimiento.cod_cliente = clientes.codigo
			    AND prod_movimiento.cod_ubicacion = clientes_ubicacion.codigo 
			    AND clientes_ubicacion.cod_estado = estados.codigo
				AND prod_movimiento.`status` = 'T'
				AND productos.cod_linea = control_arma_linea
				    $filtro
		   ORDER BY 1 DESC";

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
	
	//</a>&nbsp;<img src="imagenes/borrar.bmp"  width="20px" height="20px" title="Borrar Registro" border="null" onclick="'.$Borrar.'" class="imgLink"/>
	   $Borrar = "Borrar01('".$datos[0]."')";
        echo '<tr class="'.$fondo.'"> 
                  <td class="texo">'.$datos["producto"].'</td> 
                  <td class="texo">'.$datos["serial"].'</td>
				  <td class="texo">'.$datos["estado"].'</td>
				  <td class="texo">'.$datos["cliente"].'</td>
				  <td class="texo">'.$datos["ubicacion"].'</td>
				  <td class="texo">'.statuscal($datos["status"]).'</td>
				  <td align="center"><a href="'.$vinculo.'&codigo='.$datos[0].'&metodo=modificar"><img src="imagenes/actualizar.bmp" alt="Modificar" title="Modificar Registro" width="20" height="20" border="null"/></td> 
            </tr>'; 
        }     
     echo '<input type="hidden" name="tabla" id="tabla" value="'.$tabla.'"/>';?>
    </table>   
</div>

