<?php 
if($metodo == 'modificar'){
	$codigo = $_GET['codigo'];
	$bd = new DataBase();

	$sql = "SELECT productos.codigo, productos.cod_linea, prod_lineas.descripcion AS linea, productos.cod_sub_linea,
                   prod_sub_lineas.descripcion AS sub_linea, productos.cod_color, colores.descripcion AS color,
                   productos.cod_prod_tipo, prod_tipos.descripcion AS prod_tipo, productos.cod_unidad,
				   unidades.descripcion AS unidad,
				   productos.cod_proveedor, proveedores.nombre AS proveedor, productos.cod_almacen, 
				   almacenes.descripcion AS almacen,  productos.cod_iva,
				   iva.descripcion AS iva, productos.item, productos.descripcion,
				   productos.cos_actual, productos.fec_cos_actual, productos.cos_promedio,
				   productos.fec_cos_prom, productos.cos_ultimo, productos.fec_cos_ultimo,
				   productos.stock_actual, productos.stock_comp, productos.stock_llegar,
				   productos.punto_pedido, productos.stock_maximo, productos.stock_minimo,
				   productos.garantia, productos.talla, productos.peso,
				   productos.fec_prec_v1, productos.prec_vta1,
                   productos.fec_prec_v2, productos.prec_vta2,
                   productos.fec_prec_v3, productos.prec_vta3,
                   productos.fec_prec_v4, productos.prec_vta4,
                   productos.fec_prec_v5, productos.prec_vta5,
				   productos.piecubico, productos.campo01,
				   productos.campo02, productos.campo03,
				   productos.campo04, productos.`status`
              FROM productos , prod_lineas , prod_sub_lineas , colores , prod_tipos ,
                   unidades , proveedores , iva, almacenes
	   		 WHERE productos.cod_linea = prod_lineas.codigo 
			   AND productos.cod_sub_linea = prod_sub_lineas.codigo 
			   AND productos.cod_color = colores.codigo 
			   AND productos.cod_prod_tipo = prod_tipos.codigo 
			   AND productos.cod_unidad = unidades.codigo 
			   AND productos.cod_proveedor = proveedores.codigo 
			   AND productos.cod_almacen = almacenes.codigo
			   AND productos.cod_iva = iva.codigo
			   AND productos.codigo = '$codigo'
		  ORDER BY 2 ASC ";
	$query = $bd->consultar($sql);
	$result=$bd->obtener_fila($query,0);

	$cod_linea     = $result["cod_linea"];
	$linea         = $result["linea"];		
	$cod_sub_linea = $result["cod_sub_linea"];
	$sub_linea     = $result["linea"];
	$cod_color     = $result["cod_color"];
	$color         = $result["color"];
	$cod_prod_tipo = $result["cod_prod_tipo"];
	$prod_tipo     = $result["prod_tipo"];		
	$cod_unidad    = $result["cod_unidad"];
	$unidad        = $result["unidad"];		
	$cod_proveedor = $result["cod_proveedor"];
	$proveedor     = $result["proveedor"];		
	$cod_iva       = $result["cod_iva"];
	$iva           = $result["iva"];
	$cod_almacen   = $result["cod_almacen"];
	$almacen       = $result["almacen"];	
	$item          = $result["item"];		
	$descripcion   = $result["descripcion"];		
	$activo        = $result["status"]; 

// STOCK
    $cos_actual    = $result["cos_actual"];
	$fec_cos_actual= Rconversion($result["fec_cos_actual"]);
    $cos_promedio  = $result["cos_promedio"];
	$fec_cos_prom  = Rconversion($result["fec_cos_prom"]);
	$cos_ultimo    = $result["cos_ultimo"];
	$fec_cos_ultimo= Rconversion($result["fec_cos_ultimo"]);
	$stock_actual  = $result["stock_actual"];
	$stock_comp    = $result["stock_comp"];
	$stock_llegar  = $result["stock_llegar"];
	$punto_pedido  = $result["punto_pedido"];
	$stock_maximo  = $result["stock_maximo"];
	$stock_minimo  = $result["stock_minimo"];
	$garantia      = $result["garantia"];
	$talla         = $result["talla"];
	$peso          = $result["peso"];
	$piecubico     = $result["piecubico"];

// PRECIO DE VENTA 
	$prec_vta1     = $result["prec_vta1"];		
	$fec_prec_v1   = $result["fec_prec_v1"];		
	$prec_vta2     = $result["prec_vta2"];		
	$fec_prec_v2   = $result["fec_prec_v2"];		
	$prec_vta3     = $result["prec_vta3"];		
	$fec_prec_v3   = $result["fec_prec_v3"];		
	$prec_vta4     = $result["prec_vta4"];		
	$fec_prec_v4   = $result["fec_prec_v4"];		
	$prec_vta5     = $result["prec_vta5"];		
	$fec_prec_v5   = $result["fec_prec_v5"];		

// PARTE adiccional	
	$campo01    = $result["campo01"];  // N Porte 
	$campo02    = conversion($result["campo02"]);  // Fec. Venc. 
	$campo03    = $result["campo03"];
	$campo04    = $result["campo04"];

	}else{
	$codigo       = "";		
//	$cod_linea    = "";
//	$linea        = "Seleccione...";		
	$cod_sub_linea = "";
	$sub_linea    = "Seleccione...";
	$cod_color    = "";
	$color        = "Seleccione...";
	$cod_prod_tipo = "";
	$prod_tipo    = "Seleccione...";		
	$cod_unidad   = "";
	$unidad       = "Seleccione...";		
	$cod_proveedor = "";
	$proveedor     = "Seleccione...";	
	$cod_almacen   = "";
	$almacen       = "Seleccione...";	
	$cod_iva       = "";
	$iva           = "Seleccione...";			
	$item          = "";		
	$descripcion   = "";		
	$activo        = "T"; 
	
// STOCK
    $cos_actual    = "";
	$fec_cos_actual= "";
    $cos_promedio  = "";
	$fec_cos_prom  = "";
	$cos_ultimo    = "";
	$fec_cos_ultimo= "";
	$stock_actual  = "";
	$stock_comp    = "";
	$stock_llegar  = "";
	$punto_pedido  = "";
	$stock_maximo  = "";
	$stock_minimo  = "";	
	$garantia      = "";
	$talla         = "";
	$peso          = "";
	$piecubico     = "";

// PRECIO DE VENTA 
	$prec_vta1     = "";		
	$fec_prec_v1   = "";		
	$prec_vta2     = "";		
	$fec_prec_v2   = "";		
	$prec_vta3     = "";		
	$fec_prec_v3   = "";		
	$prec_vta4     = "";		
	$fec_prec_v4   = "";		
	$prec_vta5     = "";		
	$fec_prec_v5   = "";		

// PARTE adiccional	
	$campo01    = "";
	$campo02    = "";
	$campo03    = "";
	$campo04    = "";
	
	}
	$proced      = "p_productos"; 	
?>

  <fieldset class="fieldset">
  <legend>DATOS BASICOS <?php echo $titulo;?></legend>
     <table width="80%" align="center">
    <tr>
      <td class="etiqueta">C&oacute;digo:</td>
      <td id="input01"><input type="text" name="codigo" maxlength="11" style="width:120px" value="<?php echo $codigo;?>" />
               Activo: <input name="activo" type="checkbox"  <?php echo statusCheck("$activo");?> value="T" /><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>
    <tr>
      <td class="etiqueta">Serial:</td>
      <td id="input02"><input type="text" name="item" maxlength="20" size="25" value="<?php echo $item;?>" /><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>    
    <tr>
      <td class="etiqueta">Producto: </td>
      <td id="input03"><input type="text" name="descripcion" maxlength="120" style="width:300px" 
                              value="<?php echo $descripcion;?>"/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>
    <tr>
      <td class="etiqueta">N Porte: </td>
      <td id="campo01"><input type="text" name="campo01" maxlength="30"  size="25" 
                              value="<?php echo $campo01;?>"/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>
    <tr>
      <td class="etiqueta">Fecha Venc. Permiso: </td>
      <td id="campo02"><input type="text" name="campo02" maxlength="60"  size="16" 
                              value="<?php echo $campo02;?>"/><br />
            <span class="textfieldRequiredMsg">La Fecha Es Requerida.</span>
            <span class="textfieldInvalidFormatMsg">El Formato Es Invalido</span>
      </td>
    </tr>
    <tr>
      <td class="etiqueta">Linea: </td>
      	<td id="select01"><select name="linea" id="linea" onchange="Add_ajax01(this.value, 'ajax/Add_sub_linea.php', 'sub_linea')" style="width:250px">
          <?php  	$sql = "SELECT prod_lineas.codigo, prod_lineas.descripcion 
		                      FROM prod_lineas, control 
                             WHERE `status` = 'T' AND prod_lineas.codigo = control.control_arma_linea
                          ORDER BY 2 ASC ";
		            $query = $bd->consultar($sql);
            		while($datos=$bd->obtener_fila($query,0)){	
					 $cod_linea = $datos[0]; 
		  ?>
          <option value="<?php echo $datos[0];?>"><?php echo $datos[1];?></option>
          <?php  $cod_linea = $datos[0]; }?>		  	  
        </select><br /><span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>       	        	    
	 </tr>
    <tr>
      <td class="etiqueta">Sub Linea:</td>
      	<td id="sub_linea"><select name="sub_linea" style="width:250px">
							<option value="<?php echo $cod_sub_linea;?>"><?php echo $sub_linea;?></option>
          <?php  	$sql = " SELECT codigo, descripcion FROM prod_sub_lineas
		                      WHERE cod_linea = '02' 
							    AND `status` = 'T' 
							  ORDER BY  2 ASC ";
		            $query = $bd->consultar($sql);
            		while($datos=$bd->obtener_fila($query,0)){	
		  ?>
          <option value="<?php echo $datos[0];?>"><?php echo $datos[1];?></option>
          <?php }?>		  	  
        </select><br /><span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
    </tr>
    <tr>
      <td class="etiqueta">Colores:</td>
      	<td id="select03"><select name="color" style="width:250px">
						  <option value="<?php echo $cod_color;?>"><?php echo $color;?></option>
          <?php  	$sql = " SELECT codigo, descripcion FROM colores WHERE `status` = 'T' ORDER BY 2 ASC ";
		            $query = $bd->consultar($sql);
            		while($datos=$bd->obtener_fila($query,0)){	
		  ?>
          <option value="<?php echo $datos[0];?>"><?php echo $datos[1];?></option>
          <?php }?>		  	  
        </select><br /><span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
    </tr>
    <tr>
      <td class="etiqueta">Producto Tipo:</td>
      	<td id="select04"><select name="prod_tipo" style="width:250px">
							<option value="<?php echo $cod_prod_tipo;?>"><?php echo $prod_tipo;?></option>
          <?php  	$sql = " SELECT codigo, descripcion FROM prod_tipos WHERE `status` = 'T' ORDER BY 2 ASC ";
		          $query = $bd->consultar($sql);
            		while($datos=$bd->obtener_fila($query,0)){	
		  ?>
          <option value="<?php echo $datos[0];?>"><?php echo $datos[1];?></option>
          <?php }?>		  	  
        </select><br />
        	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>       	        	    
    </tr>    
    <tr>
      <td class="etiqueta">Unidad:</td>
      	<td id="select05"><select name="unidad" style="width:250px">
							<option value="<?php echo $cod_unidad;?>"><?php echo $unidad;?></option>
         <?php  	$sql = " SELECT codigo, descripcion FROM unidades WHERE `status` = 'T' ORDER BY 2 ASC ";
		          $query = $bd->consultar($sql);
            		while($datos=$bd->obtener_fila($query,0)){	
		  ?>
          <option value="<?php echo $datos[0];?>"><?php echo $datos[1];?></option>
          <?php }?>		  	  
        </select><br />
        	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>       	        	    
   </tr>
    <tr>
      <td class="etiqueta">Proveedor:</td>
      	<td id="select06"><select name="proveedor" style="width:250px">
							<option value="<?php echo $cod_proveedor;?>"><?php echo $proveedor;?></option>
         <?php  	$sql = " SELECT codigo, nombre FROM proveedores WHERE `status` = 'T' ORDER BY 2 ASC ";
		          $query = $bd->consultar($sql);
            		while($datos=$bd->obtener_fila($query,0)){	
		  ?>
          <option value="<?php echo $datos[0];?>"><?php echo $datos[1];?></option>
          <?php }?>		  	  
        </select><br /><span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>       	        	    
   </tr>
    <tr>
      <td class="etiqueta">Almacen:</td>
      	<td id="select07"><select name="almacen" style="width:250px">
							<option value="<?php echo $cod_almacen;?>"><?php echo $almacen;?></option>
         <?php  	$sql = " SELECT codigo, descripcion FROM almacenes WHERE `status` = 'T' ORDER BY 2 ASC ";
		          $query = $bd->consultar($sql);
            		while($datos=$bd->obtener_fila($query,0)){	
		  ?>
          <option value="<?php echo $datos[0];?>"><?php echo $datos[1];?></option>
          <?php }?>		  	  
        </select><br /><span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>       	        	    
   </tr>
    <tr>
      <td class="etiqueta">Iva:</td>
      	<td id="select08"><select name="iva" style="width:250px">
							<option value="<?php echo $cod_iva;?>"><?php echo $iva;?></option>
         <?php  	$sql = " SELECT codigo, descripcion FROM iva WHERE `status` = 'T' ORDER BY 2 ASC ";
		          $query = $bd->consultar($sql);
            		while($datos=$bd->obtener_fila($query,0)){	
		  ?>
          <option value="<?php echo $datos[0];?>"><?php echo $datos[1];?></option>
          <?php }?>		  	  
        </select><br /><span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>       	        	    
   </tr>

    <tr>
      <td class="etiqueta">Campo adiccional 01: </td>
      <td id="campo03"><input type="text" name="campo03" maxlength="60" style="width:300px" 
                              value="<?php echo $campo03;?>"/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr> 
    <tr>
      <td class="etiqueta">Campo adiccional 02: </td>
      <td id="campo04"><input type="text" name="campo04" maxlength="60" style="width:300px" 
                              value="<?php echo $campo04;?>"/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr> 
	 <tr> 
         <td height="8" colspan="2" align="center"><hr></td>
     </tr>	
  </table>
<div align="center">
             <span class="art-button-wrapper">
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
  		    <input name="metodo" id="metodo" type="hidden"  value="<?php echo $metodo;?>" />
            <input name="proced" id="proced" type="hidden"  value="<?php echo $proced;?>" />
            <input name="tabla" id="tabla" type="hidden"  value="<?php echo $tabla;?>" />            
            <input name="usuario" id="usuario" type="hidden"  value="<?php echo $usuario;?>" />            
	        <input name="href" type="hidden" value="<?php echo $archivo2;?>"/>	
            
            <input type="hidden" name="garantia" maxlength="60"  value="<?php echo $garantia;?>"/>
            <input type="hidden" name="talla" maxlength="60"  value="<?php echo $talla;?>"/>
            <input type="hidden" name="peso" maxlength="60"   value="<?php echo $peso;?>"/>	
            <input type="hidden" name="piecubico" maxlength="60" value="<?php echo $piecubico;?>"/>                       			
</div>
  </fieldset>
  <script type="text/javascript">
var input01  = new Spry.Widget.ValidationTextField("input01", "none", {validateOn:["blur", "change"]});
var input02  = new Spry.Widget.ValidationTextField("input02", "none", {validateOn:["blur", "change"]});
var input03  = new Spry.Widget.ValidationTextField("input03", "none", {validateOn:["blur", "change"]});

var campo01 = new Spry.Widget.ValidationTextField("campo01", "none", {validateOn:["blur", "change"]});
var fecha01 = new Spry.Widget.ValidationTextField("campo02", "date", {format:"dd-mm-yyyy", hint:"DD-MM-AAAA", 
    validateOn:["blur", "change"], useCharacterMasking:true});

var select01 = new Spry.Widget.ValidationSelect("select01", {validateOn:["blur", "change"]});
var select03 = new Spry.Widget.ValidationSelect("select03", {validateOn:["blur", "change"]});
var select04 = new Spry.Widget.ValidationSelect("select04", {validateOn:["blur", "change"]});
var select05 = new Spry.Widget.ValidationSelect("select05", {validateOn:["blur", "change"]});
var select06 = new Spry.Widget.ValidationSelect("select06", {validateOn:["blur", "change"]});
var select07 = new Spry.Widget.ValidationSelect("select07", {validateOn:["blur", "change"]});
var select08 = new Spry.Widget.ValidationSelect("select08", {validateOn:["blur", "change"]});
</script>