<?php 
$metodo = $_GET['metodo'];
$titulo = $_GET['titulo'];
$tabla   = $_GET['tb'];
$archivo = $_GET['archivo'];
$archivo2 = "maestros/Cons_$archivo&Nmenu=".$_GET['Nmenu']."&mod=".$_GET['mod'].""; 
$proced  = "p_iva";  
if($metodo == 'modificar'){
	$codigo = $_GET['codigo'];
	$bd = new DataBase();
	$sql = " SELECT codigo, descripcion, p_venta, p_compra,
                    cod_us_ing, fec_us_ing, cod_us_mod, fec_us_mod, status
               FROM iva WHERE codigo  = '$codigo' 
			   ORDER BY 2 DESC";
	$query = $bd->consultar($sql);
	$result=$bd->obtener_fila($query,0);

	$descripcion = $result["descripcion"];
	$p_venta     = $result["p_venta"];
	$p_compra    = $result["p_compra"];
	$activo      = $result["status"]; ;

	}else{
	$codigo      = '';		
	$descripcion = '';
	$p_venta     = '';		
	$p_compra    = '';
	$activo      = 'T';
	}
?>
<form action="sc_maestros/sc_iva.php" method="post" name="add" id="add"> 
  <fieldset class="fieldset">
  <legend>DATOS BASICOS <?php echo $titulo;?> </legend>
     <table width="80%" align="center">
    <tr>
      <td class="etiqueta">C&oacute;digo:</td>
      <td id="input01"><input type="text" name="codigo" maxlength="11" style="width:120px" value="<?php echo $codigo;?>" />
               Activo: <input name="activo" type="checkbox"  <?php echo statusCheck("$activo");?> value="T" />
           <img src="imagenes/ok.gif" title="Valid" alt="Valid" class="validMsg" border="0"/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
	 </tr>
    <tr>
      <td class="etiqueta">Descripcion: </td>
      <td id="input02"><input type="text" name="descripcion" maxlength="120" style="width:300px" 
                              value="<?php echo $descripcion;?>"/>
		   <img src="imagenes/ok.gif" title="Valid" alt="Valid" class="validMsg" border="0"/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>
   <tr>
      <td class="etiqueta">Precio Venta: </td>
      <td id="input03"><input type="text" name="p_venta" maxlength="60" style="width:150px" 
                              value="<?php echo $p_venta;?>"/>
		   <img src="imagenes/ok.gif" title="Valid" alt ="Valid" class="validMsg" border="0"/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>    	        	    
   <tr>
      <td class="etiqueta">Precio Comprar: </td>
      <td id="input04"><input type="text" name="p_compra" maxlength="60" style="width:150px" 
                              value="<?php echo $p_compra;?>"/>
		   <img src="imagenes/ok.gif" title="Valid" alt="Valid" class="validMsg" border="0"/><br />
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
                </span></td>
   </tr>
  </table>
  		    <input name="metodo" id="metodo" type="hidden"  value="<?php echo $metodo;?>" />
            <input name="tabla" id="tabla" type="hidden"  value="<?php echo $tabla;?>" />            
            <input name="usuario" id="usuario" type="hidden"  value="<?php echo $usuario;?>" />            
	        <input name="proced" type="hidden" value="<?php echo $proced;?>"/>	
            <input name="href" type="hidden" value="../inicio.php?area=<?php echo $archivo2 ?>"/>

  </fieldset>
  </form>
  <script type="text/javascript">
var input01  = new Spry.Widget.ValidationTextField("input01", "none", {validateOn:["blur", "change"]});
var input02  = new Spry.Widget.ValidationTextField("input02", "none", {validateOn:["blur", "change"]});
var input03  = new Spry.Widget.ValidationTextField("input03", "currency", {format:"comma_dot", validateOn:["blur", "change"],useCharacterMasking:true , isRequired:false});
var input04  = new Spry.Widget.ValidationTextField("input04","currency", {format:"comma_dot", validateOn:["blur", "change"],useCharacterMasking:true , isRequired:false});

</script>