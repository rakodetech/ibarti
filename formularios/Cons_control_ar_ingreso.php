<?php 
	$Nmenu = '451'; 
	require_once('autentificacion/aut_verifica_menu.php');
	$tabla = "productos";
	$bd = new DataBase();
	$archivo = "control_ar_ingreso";
	$titulo = " ARMAMENTOS ";
	$vinculo = "inicio.php?area=pestanas/add_$archivo&Nmenu=".$_GET['Nmenu']."&mod=".$_GET['mod']."&titulo=$titulo&tb=$tabla&archivo=$archivo";
?>
<div align="center" class="etiqueta_title"> CONSULTA GENERAL <?php echo $titulo;?> </div> <hr />
<div id="Contenedor01"></div>
<div id="listar"><table width="100%" border="0" align="center">
		<tr class="fondo00">
			<th width="10%" class="etiqueta">Codigo</th>
			<th width="25%" class="etiqueta">Producto</th>
            <th width="15%" class="etiqueta">Serial</th>
             <th width="10%" class="etiqueta">N Porte</th>
              <th width="10%" class="etiqueta">Fec. Venc. Permiso</th>
            <th width="10%" class="etiqueta">Activo</th>
		    <th width="10%" align="center"><a href="<?php echo $vinculo."&codigo=''&metodo=agregar";?>"><img src="imagenes/nuevo.bmp" alt="Detalle" title="Detalle Registro" width="30px" height="30px" border="null"/></a></th> 
		</tr>
    <?php       
	$usuario = $_SESSION['usuario_cod'];
	$valor = 0;
	$sql = "  SELECT productos.codigo, productos.cod_linea, prod_lineas.descripcion AS linea, productos.cod_sub_linea,
                     prod_sub_lineas.descripcion AS sub_linea, productos.cod_color, colores.descripcion AS color,
                     productos.cod_prod_tipo, prod_tipos.descripcion AS prod_tipo, productos.cod_unidad,
					 unidades.descripcion AS unidad, 
					 productos.cod_proveedor, proveedores.nombre AS proveedor, productos.cod_iva,
					 iva.descripcion AS iva, productos.item AS serial, productos.descripcion,
					 productos.cos_actual, productos.fec_cos_actual, productos.cos_promedio,
				 	 productos.fec_cos_prom, productos.cos_ultimo, productos.fec_cos_ultimo,
					 productos.stock_actual, productos.stock_comp, productos.stock_llegar,
					 productos.punto_pedido, productos.stock_maximo, productos.stock_minimo,
					 productos.garantia, productos.talla, productos.peso,
				 	 productos.piecubico, productos.campo01 AS n_porte,
					 productos.campo02 AS fec_venc_permiso, productos.campo03,
					 productos.campo04, productos.status
                FROM productos , prod_lineas , prod_sub_lineas , colores , prod_tipos ,
                     unidades ,  proveedores , iva, control
	   		   WHERE productos.cod_linea = prod_lineas.codigo 
				 AND productos.cod_sub_linea = prod_sub_lineas.codigo 
				 AND productos.cod_color = colores.codigo 
				 AND productos.cod_prod_tipo = prod_tipos.codigo 
			 	 AND productos.cod_unidad = unidades.codigo 
				 AND productos.cod_proveedor = proveedores.codigo 
				 AND productos.cod_iva = iva.codigo
				 AND productos.cod_linea = control.control_arma_linea
				 ORDER BY serial ASC ";

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
                  <td>'.$datos["codigo"].'</td> 
                  <td>'.$datos["descripcion"].'</td>
				  <td>'.$datos["serial"].'</td>
				  <td>'.$datos["n_porte"].'</td>
				  <td>'.$datos["fec_venc_permiso"].'</td>
				  <td>'.statuscal($datos["status"]).'</td>
				  <td align="center"><a href="'.$vinculo.'&codigo='.$datos[0].'&metodo=modificar"><img src="imagenes/actualizar.bmp" alt="Modificar" title="Modificar Registro" width="20" height="20" border="null"/></a>&nbsp;<img src="imagenes/borrar.bmp"  width="20px" height="20px" title="Borrar Registro" border="null" onclick="'.$Borrar.'" class="imgLink"/></td> 
            </tr>'; 
        }     
     echo '<input type="hidden" name="tabla" id="tabla" value="'.$tabla.'"/>';
	?>
    </table>   
</div>