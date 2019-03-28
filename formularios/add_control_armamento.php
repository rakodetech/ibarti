<?php 
$Nmenu = $_GET['Nmenu'];
$titulo = "CONTROL DE ARMAMENTO";
$metodo  =$_GET['metodo'];
require_once('autentificacion/aut_verifica_menu.php');

$proced      = "p_prod_movimiento"; 
if($metodo == 'modificar'){
   $titulo = "MODIFICAR $titulo";
	$codigo = $_GET['codigo'];
	$bd = new DataBase();
	
	$sql = " SELECT productos.item,  
                    prod_movimiento.cod_producto, productos.descripcion AS producto,
					productos.item AS serial,
                    clientes_ubicacion.cod_estado, estados.descripcion AS estado,
                    productos.campo01 AS n_porte, productos.campo02 AS fec_venc_permiso,
                    productos.campo03, productos.campo04,
                    prod_movimiento.cod_cliente, clientes.nombre AS cliente,
                    prod_movimiento.cod_ubicacion, clientes_ubicacion.descripcion AS ubicacion,
                    prod_movimiento.fec_entrega, prod_movimiento.fec_retiro,
					prod_movimiento.motivo, prod_movimiento.observacion,
					prod_movimiento.campo01, prod_movimiento.campo02,
                    prod_movimiento.campo03, prod_movimiento.campo04,
                    prod_movimiento.`status`
               FROM prod_movimiento, productos, clientes_ubicacion, clientes, estados
			  WHERE prod_movimiento.cod_producto = productos.codigo
			    AND prod_movimiento.cod_cliente = clientes.codigo
			    AND prod_movimiento.cod_ubicacion = clientes_ubicacion.codigo 
			    AND clientes_ubicacion.cod_estado = estados.codigo
				AND prod_movimiento.codigo =  '$codigo' ";
	$query = $bd->consultar($sql);
	$result = $bd->obtener_fila($query,0);

    $cod_producto  = $result['cod_producto'];
    $producto      = $result['producto'].' '.$result['serial'];
    $cod_cliente   = $result['cod_cliente'];
    $cliente       = $result['cliente'];
    $cod_ubicacion = $result['cod_ubicacion'];
    $ubicacion     = $result['ubicacion'];
    $fec_entrega   = conversion($result['fec_entrega']);
	$fec_retiro    = conversion($result['fec_retiro']);
    $retiro_readonly  = '';
	$motivo        = $result['motivo'];
    $observacion   = $result['observacion'];
    $campo01       = $result['campo01'];	
    $campo02       = $result['campo02'];
    $campo03       = $result['campo03'];
    $campo04       = $result['campo04'];
	$activo        = $result['status']; 

	}else{
    $titulo       = "AGREGAR $titulo";
	$codigo       = '';	
    $cod_producto = '';
    $producto     = 'Seleccione...';
    $cod_cliente  = '';
    $cliente       = 'Seleccione...';
    $cod_ubicacion = '';
    $ubicacion     = 'Seleccione...';
    $fec_entrega   = '';
	$fec_retiro    = '';
    $retiro_readonly  = 'readonly="readonly"';
	$motivo        = '';
    $observacion   = '';

    $campo01     = '';	
    $campo02     = '';	
    $campo03     = '';		
    $campo04     = '';	
	$activo      = 'T'; 
	}?>
     <table width="80%" align="center">
         <tr valign="top">                    
		     <td height="23" colspan="2" class="etiqueta_title" align="center"><?php echo $titulo;?></td>
         </tr>
         <tr> 
    	       <td height="8" colspan="2" align="center"><hr></td>    
     	</tr>			 
    <tr>
      <td class="etiqueta">Productos:</td>
      	<td id="select01"><select name="producto" style="width:250px" onchange="Add_ajax01(this.value, 'ajax/control_armamento.php', 'Contenedor03')">
							<option value="<?php echo $cod_producto;?>"><?php echo $producto;?></option>
          <?php  		   
		  	$sql   = "SELECT productos.codigo, productos.descripcion, productos.item
                                FROM productos , control
                               WHERE productos.`status` = 'T' 
                                 AND productos.cod_linea = control.control_arma_linea 
                                 AND productos.codigo <> '$cod_producto'                    
                            ORDER BY 2, 3 ASC";			   		

		    $query = $bd->consultar($sql);
           	while($row02 = $bd->obtener_fila($query,0)){
				
			$cod_value = $row02[0];
			$sql01       = "SELECT COUNT(v_prod_movimiento_act.cod_producto ) AS cantidad
                            FROM v_prod_movimiento_act
                           WHERE v_prod_movimiento_act.cod_producto = '$cod_value'";		  
		   $query01     = $bd->consultar($sql01);
		   $row01      = $bd->obtener_fila($query01,0);
		   if($row01[0] == 0){					
		  ?>
          <option value="<?php echo $row02[0];?>"><?php echo $row02[1].' '.$row02[2];?></option>
          <?php }}?>		  	  
        </select> Activo: <input name="activo" type="checkbox"  <?php echo statusCheck("$activo");?> value="T" /><br />
        	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
    </tr>
    <tr>
      <td id="Contenedor03" colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td class="etiqueta">Cliente:</td>
      	<td id="select02"><select name="cliente" id="cliente" style="width:250px"  
    	                          onchange="Add_ajax01(this.value, 'ajax/Add_cl_ubicacion.php', 'select03')">
                                  <option value="<?php echo $cod_cliente;?>"><?php echo $cliente;?></option>
          <?php
			    	$sql   = "SELECT clientes.codigo, clientes.nombre FROM clientes
                               WHERE clientes.`status` = 'T'
							     AND clientes.codigo <> '$cod_cliente' 
							ORDER BY 2 ASC";
		            $query = $bd->consultar($sql);
            		while($row02 = $bd->obtener_fila($query,0)){	
		  ?>							
          <option value="<?php echo $row02[0];?>"><?php echo $row02[1];?></option>
          <?php }?>		  	  
        </select></td>
    </tr>	
    <tr>
      <td class="etiqueta">Ubicaci&oacute;n:</td>
      	<td id="select03"><select name="ubicacion" style="width:250px">
                                  <option value="<?php echo $cod_ubicacion;?>"><?php echo $ubicacion;?></option>
          <?php
			    	$sql   = "SELECT clientes_ubicacion.id, clientes_ubicacion.descripcion
							    FROM clientes_ubicacion 
							   WHERE clientes_ubicacion.co_cli = '$cliente' 
							 	 AND clientes_ubicacion.`status` = 'T'
								 AND clientes_ubicacion.id <> '$cod_ubicacion'
							   ORDER BY 2 ASC";
		            $query = $bd->consultar($sql);
            		while($row02 = $bd->obtener_fila($query,0)){	
		  ?>
          <option value="<?php echo $row02[0];?>"><?php echo $row02[1];?></option>
          <?php }?>		  	  
        </select></td>
    </tr>	
    <tr>
      <td class="etiqueta">Fecha Entrega:</td>
      <td id="fecha01"><input type="text" name="fec_entrega"  style="width:100px" value="<?php echo $fec_entrega;?>" /></td>
    </tr>
    <tr>
      <td class="etiqueta">Fecha Retiro:</td>
      <td id="fecha02"><input type="text" name="fec_retiro"  style="width:100px" value="<?php echo $fec_retiro;?>"
                               <?php echo $retiro_readonly;?> /></td>
    </tr>
    <tr>
      <td class="etiqueta">Motivo:</td>
      <td id="textarea01"><textarea  name="motivo" cols="50" rows="2"><?php echo $motivo;?></textarea>
        <span id="Counterror_mess1" class="texto">&nbsp;</span></td>
    </tr>
    <tr>
      <td class="etiqueta">Observacion:</td>
      <td id="textarea02"><textarea  name="observacion" cols="50" rows="3"><?php echo $observacion;?></textarea>
        <span id="Counterror_mess1" class="texto">&nbsp;</span></td>
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
			<input name="metodo" type="hidden" value="<?php echo $metodo;?>" />
			<input name="proced" type="hidden" value="<?php echo $proced;?>" />
            <input name="usuario" type="hidden" value="<?php echo $usuario;?>" />
	        <input name="href" type="hidden" value="<?php echo $archivo2;?>"/>	
            <input name="codigo" type="hidden" value="<?php echo $codigo;?>"/>                
                </div>
</body>
</html>
<script type="text/javascript">

var fecha01 = new Spry.Widget.ValidationTextField("fecha01", "date", {format:"dd-mm-yyyy", hint:"DD-MM-AAAA", 
    validateOn:["blur", "change"], useCharacterMasking:true, isRequired:false});
	
var fecha02 = new Spry.Widget.ValidationTextField("fecha02", "date", {format:"dd-mm-yyyy", hint:"DD-MM-AAAA", 
    validateOn:["blur", "change"], useCharacterMasking:true, isRequired:false});	

var select01 = new Spry.Widget.ValidationSelect("select01", {validateOn:["blur", "change"]});
var select02 = new Spry.Widget.ValidationSelect("select02", {validateOn:["blur", "change"]});

var select10 = new Spry.Widget.ValidationSelect("select10", {validateOn:["blur", "change"]});

var textarea01 = new Spry.Widget.ValidationTextarea("textarea01", {maxChars:255, validateOn:["blur", "change"],
 counterType:"chars_count", counterId:"Counterror_mess1", useCharacterMasking:false , isRequired:false});
 
var textarea02 = new Spry.Widget.ValidationTextarea("textarea02", {maxChars:255, validateOn:["blur", "change"],
 counterType:"chars_count", counterId:"Counterror_mess1", useCharacterMasking:false , isRequired:false});
</script>