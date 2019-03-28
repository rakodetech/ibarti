<?php 
if($metodo == 'modificar'){
	$codigo = $_GET['codigo'];
	$bd = new DataBase();
	$sql = "  SELECT fact_procesos.cod_producto, productos.descripcion AS producto,
	                 productos.prec_vta1, productos.prec_vta2,
					 productos.prec_vta3,productos.prec_vta4,
					 productos.prec_vta5,
					 fact_procesos.campo01, fact_procesos.campo02,
					 fact_procesos.campo03, fact_procesos.campo04, 
					 fact_procesos.activo
                FROM fact_procesos, productos, men_usuarios
               WHERE productos.codigo = productos.codigo 
			     AND fact_procesos.cod_us_mod = men_usuarios.codigo
				 AND fact_procesos.cod_producto = '$codigo'";
	$query = $bd->consultar($sql);
	$result=$bd->obtener_fila($query,0);

	$titulo      = "MODIFICAR DATOS BASICOS $titulo";	  	   
	$producto    = $result["cod_producto"];
	$producto    = $result["producto"];
	$prec_vta1   = $result["prec_vta1"];
	$prec_vta2   = $result["prec_vta2"];
	$prec_vta3   = $result["prec_vta3"];
	$prec_vta4   = $result["prec_vta4"];
	$prec_vta5   = $result["prec_vta5"];
	
	$activo      = $result["activo"];
	
	$campo01    = $result["campo01"];
	$campo02    = $result["campo02"];
	$campo03    = $result["campo03"];
	$campo04    = $result["campo04"];

	}else{

	$titulo      = "AGREGAR DATOS BASICOS $titulo";	
	$codigo      = "";		
	$cod_producto= "";
	$producto    = " Seleccione... ";
	$prec_vta1   = "";
	$prec_vta2   = "";
	$prec_vta3   = "";
	$prec_vta4   = "";
	$prec_vta5   = "";
	$activo      = 'T';
	
	$campo01    = "";
	$campo02    = "";
	$campo03    = "";
	$campo04    = "";
	}
?>

  <fieldset class="fieldset">
  <legend> <?php echo $titulo;?> </legend>
     <table width="80%" align="center">
    <tr>
      <td class="etiqueta">Producto:</td>
      	<td id="select01"><select name="codigo" style="width:250px">
							<option value="<?php echo $codigo;?>"><?php echo $producto;?></option>
          <?php  	$sql = " SELECT productos.codigo, productos.descripcion
                               FROM productos
                              WHERE productos.activo ORDER BY productos.descripcion ASC ";
		            $query = $bd->consultar($sql);
            		while($datos=$bd->obtener_fila($query,0)){	
		  ?>
          <option value="<?php echo $datos[0];?>"><?php echo $datos[1];?></option>
          <?php }?>		  	  
        </select>
              Activo: <input name="activo" type="checkbox"  <?php echo statusCheck("$activo");?> value="T" /><br />
        	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
    </tr>
    <tr>
      <td class="etiqueta">Precio: </td>
      <td id="input01"><input type="text" name="prec_vta5" maxlength="60" style="width:120px" 
                              value="<?php echo $prec_vta5;?>"/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>
	 <tr> 
         <td height="8" colspan="2" align="center"><hr></td>
     </tr>	     
     <tr> 
         <td colspan="2" align="center">
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
         </td>
   </tr>
  </table>
  		    <input name="metodo" id="metodo" type="hidden"  value="<?php echo $metodo;?>" />
            <input name="proced" id="proced" type="hidden"  value="<?php echo $proced;?>" />
            <input name="tabla" id="tabla" type="hidden"  value="<?php echo $tabla;?>" />            
            <input name="usuario" id="usuario" type="hidden"  value="<?php echo $usuario;?>" />            
	        <input name="href" type="hidden" value="<?php echo $archivo2;?>"/>			   			
  </fieldset>
<script type="text/javascript">
var input01 = new Spry.Widget.ValidationTextField("input01", "currency", {format:"comma_dot", validateOn:["blur", "change"], useCharacterMasking:true ,isRequired:false}); 
var select01 = new Spry.Widget.ValidationSelect("select01", {validateOn:["blur", "change"]});
</script>