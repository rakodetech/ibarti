<?php 
//	require_once('autentificacion/aut_verifica_menu.php');

	$archivo = "$area&Nmenu=$Nmenu&codigo=$codigo&mod=$mod&pagina=1&metodo=modificar";
	$proced  = "p_fichas_02";
	$metodo  = "modificar";						

	$sql_dot = " SELECT v_prod_dot_max2.cod_dotacion,
		                v_prod_dot_max2.fecha_max AS fecha, prod_lineas.descripcion AS linea,
                        prod_sub_lineas.descripcion AS sub_linea, v_prod_dot_max2.cod_producto,
                        productos.descripcion AS producto, v_prod_dot_max2.cantidad
                   FROM v_prod_dot_max2, prod_lineas, prod_sub_lineas, productos
                  WHERE v_prod_dot_max2.cod_linea = prod_lineas.codigo
                    AND v_prod_dot_max2.cod_sub_linea = prod_sub_lineas.codigo
                    AND v_prod_dot_max2.cod_producto = productos.codigo 
				    AND v_prod_dot_max2.cod_ficha = '$codigo'
				  ORDER BY 3 DESC ";
?>
<form action="scripts/sc_ficha_02.php" method="post" name="add" id="add"> 
  <fieldset class="fieldset">
  <legend>Informacion De Uniformes</legend>
     <table width="80%" align="center">
    <tr>
      <td class="etiqueta">Talla De Pantal&oacute;n:</td>
       <td id="select01_2"><select name="t_pantalon" style="width:250px">
							<option value="<?php echo $cod_t_pantalon?>"><?php echo $t_pantalon;?></option>
          <?php  	$sql = " SELECT codigo, descripcion FROM preing_pantalon
							  WHERE `status` = 'T' 
							AND codigo <> '$cod_t_pantalon'  ORDER BY 2 ASC ";
		            $query = $bd->consultar($sql);
            		while($datos=$bd->obtener_fila($query,0)){	
		  ?>
          <option value="<?php echo $datos[0];?>"><?php echo $datos[1];?></option>
          <?php }?>		  	  
        </select><br /><span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
	 </tr>
    <tr>
      <td class="etiqueta">Talla Camisa:</td>
       <td id="select02_2"><select name="t_camisa" style="width:250px">
							<option value="<?php echo $cod_t_camisa;?>"><?php echo $t_camisa;?></option>
          <?php  	$sql = " SELECT codigo, descripcion FROM preing_camisas
							  WHERE `status` = 'T' 
							AND codigo <> '$cod_t_camisa' ORDER BY 2 ASC ";

		            $query = $bd->consultar($sql);
            		while($datos=$bd->obtener_fila($query,0)){	
		  ?>
          <option value="<?php echo $datos[0];?>"><?php echo $datos[1];?></option>
          <?php }?>		  	  
        </select><br /><span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
	 </tr>	
    <tr>
      <td class="etiqueta">N&uacute;mero De Zapato:</td>
       <td id="select03_2"><select name="n_zapato" style="width:250px">
							<option value="<?php echo $cod_n_zapato;?>"><?php echo $n_zapato; ?></option>
          <?php  	$sql = " SELECT codigo, descripcion FROM preing_zapatos
							  WHERE `status` = 'T' 
							AND codigo <> '$cod_n_zapato'  ORDER BY 2 ASC ";
		            $query = $bd->consultar($sql);
            		while($datos=$bd->obtener_fila($query,0)){	
		  ?>
          <option value="<?php echo $datos[0];?>"><?php echo $datos[1];?></option>
          <?php }?>		  	  
        </select><br /><span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>        
	 </tr>	  		 
      <tr> 
            <td height="8" colspan="2" align="center"><hr></td>
         </tr>	
  </table>
<div align="center"><span class="art-button-wrapper">
                    <span class="art-button-l"> </span>
                    <span class="art-button-r"> </span>
                <input type="submit" name="salvar"  id="salvar" value="Guardar" class="readon art-button" />	
                </span>&nbsp;
             <span class="art-button-wrapper">
                    <span class="art-button-l"> </span>
                    <span class="art-button-r"> </span>
                <input type="reset" id="limpiar" value="Restablecer" class="readon art-button" />	
                </span>&nbsp;
             <span class="art-button-wrapper">
                    <span class="art-button-l"> </span>
                    <span class="art-button-r"> </span>
                <input type="button" id="volver" value="Volver" onClick="history.back(-1);" class="readon art-button" />	
                </span>		
</div>
  </fieldset>
</fieldset>
  <fieldset class="fieldset">
  <legend>Ultima Dotacion Uniformes </legend>
<table width="100%" border="0" align="center">
		<tr class="fondo00">
			<th width="10%" class="etiqueta">Cod. Dotacion</th>
            <th width="15%" class="etiqueta">Fecha Ultima <br /> Dotacion</th>
			<th width="20%" class="etiqueta">Linea</th>
    		<th width="20%" class="etiqueta">Sub Linea</th>
			<th width="25%" class="etiqueta">Producto</th>
            <th width="10%" class="etiqueta">Cantidad</th>
	</tr>
   <?php      
	$valor = 0;
		$query = $bd->consultar($sql_dot);
		while($datos=$bd->obtener_fila($query,0)){
		if ($valor == 0){
			$fondo = 'fondo01';
		$valor = 1;
		}else{
			$fondo = 'fondo02';
			$valor = 0;
		}
        echo '<tr class="'.$fondo.'"> 
                  <td>'.longitudMin($datos["cod_dotacion"]).'</td>
				  <td>'.longitudMin($datos["fecha"]).'</td>
				  <td>'.longitud($datos["linea"]).'</td>
				  <td>'.longitud($datos["sub_linea"]).'</td> 
                  <td>'.longitud($datos["producto"]).'</td>		
				  <td>'.$datos["cantidad"].'</td>
            </tr>'; 
        }?>
    </table>
</fieldset>
<input type="hidden" name="codigo" value="<?php echo $codigo;?>" />
<input type="hidden" name="proced" value="<?php echo $proced;?>" />
<input type="hidden" name="metodo" value="<?php echo $metodo;?>" />
<input type="hidden" name="usuario" value="<?php echo $usuario;?>" />
<!-- <input type="hidden" name="href" value="<?php echo $archivo;?>" /> -->
<input name="href" type="hidden" value="../inicio.php?area=<?php echo $archivo ?>"/>
</form>