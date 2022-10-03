<?php 
$metodo = $_GET['metodo'];
$titulo = $_GET['titulo'];
$tabla   = $_GET['tb'];
$archivo = $_GET['archivo'];
$proced      = "p_cl_puesto";
$archivo2 = "../inicio.php?area=maestros/Cons_$archivo&Nmenu=".$_GET['Nmenu']."&mod=".$_GET['mod'].""; 

if($metodo == 'modificar'){
	$codigo = $_GET['codigo'];
	$bd = new DataBase();
	
	$sql = " SELECT cl_puesto.cod_clasif_puesto, cl_clasif_puesto.descripcion clasif, 
	                cl_puesto.descripcion,
                    cl_puesto.cod_us_ing, cl_puesto.fec_us_ing,
                    cl_puesto.cod_us_mod, cl_puesto.fec_us_mod,
                    cl_puesto.`status` 
               FROM cl_puesto, cl_clasif_puesto
              WHERE cl_puesto.codigo = '$codigo'
			    AND cl_puesto.cod_clasif_puesto = cl_clasif_puesto.codigo";
	$query = $bd->consultar($sql);
	$result=$bd->obtener_fila($query,0);

	$titulo      = "MODIFICAR DATOS $titulo";	  	   
	$cod_clasif_puesto   = $result["cod_clasif_puesto"];
	$clasif      = $result["clasif"];
	$descripcion = $result["descripcion"];
	$activo      = $result["status"];

	}else{

	$titulo      = "AGREGAR BASICOS $titulo";	
	$codigo      = "";		
	$cod_clasif_puesto   = "";
	$clasif       = " Seleccione... ";
	$descripcion = "";
	$activo      = 'T';

	}
?>

<form action="sc_maestros/sc_<?php echo $archivo;?>.php" method="post" name="add" id="add"> 
  <fieldset class="fieldset">
  <legend> <?php echo $titulo;?> </legend>
     <table width="80%" align="center">
    <tr>
      <td class="etiqueta">C&oacute;digo:</td>
      <td id="input01"><input type="text" name="codigo" maxlength="11" style="width:120px" value="<?php echo $codigo;?>" readonly />
               Activo: <input name="activo" type="checkbox"  <?php echo statusCheck("$activo");?> value="T" />
              <img src="imagenes/ok.gif" title="Valid" alt="Valid" class="validMsg" border="0"/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
	 </tr>
    <tr>
      <td class="etiqueta">Clasificación:</td>
      	<td id="select01"><select name="clasif" style="width:250px">
							<option value="<?php echo $cod_clasif_puesto;?>"><?php echo $clasif;?></option>
          <?php  	$sql = " SELECT codigo, descripcion FROM cl_clasif_puesto WHERE status = 'T' 
		                        AND codigo <> '$cod_clasif_puesto' ORDER BY 2 ASC ";
		            $query = $bd->consultar($sql);
            		while($datos=$bd->obtener_fila($query,0)){	
		  ?>
          <option value="<?php echo $datos[0];?>"><?php echo $datos[1];?></option>
          <?php }?>		  	  
        </select>
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br />
        	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
    </tr>
    <tr>
      <td class="etiqueta">Puesto: </td>
      <td id="input02"><input type="text" name="descripcion" maxlength="60" style="width:300px" 
                              value="<?php echo utf8_decode($descripcion);?>"/>
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
  </form>
  <script type="text/javascript">
var input02  = new Spry.Widget.ValidationTextField("input02", "none", {validateOn:["blur", "change"]});
var select01 = new Spry.Widget.ValidationSelect("select01", {validateOn:["blur", "change"]});
</script>