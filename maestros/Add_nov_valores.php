<?php 
$metodo = $_GET['metodo'];
$titulo = $_GET['titulo'];
$tabla   = $_GET['tb'];
$archivo = $_GET['archivo'];
$proced      = "p_nov_valores";
$archivo2 = "../inicio.php?area=maestros/Cons_$archivo&Nmenu=".$_GET['Nmenu']."&mod=".$_GET['mod'].""; 

if($metodo == 'modificar'){
	$codigo = $_GET['codigo'];
	$bd = new DataBase();
 	$sql = " SELECT nov_valores.codigo, nov_valores.abrev,
                    nov_valores.factor, nov_valores.descripcion,
                    nov_valores.campo01, nov_valores.campo02,
                    nov_valores.campo03, nov_valores.campo04,
                    nov_valores.cod_us_ing, nov_valores.fec_us_ing,
                    nov_valores.cod_us_mod, nov_valores.fec_us_mod,
                    nov_valores.`status`
               FROM nov_valores		    
              WHERE nov_valores.codigo = '$codigo'";

	$query = $bd->consultar($sql);
	$result=$bd->obtener_fila($query,0);

	$titulo         = "MODIFICAR DATOS BASICOS $titulo";	  	   

	$abrev          = $result["abrev"];
	$descripcion    = $result["descripcion"];
	$factor         = $result["factor"];
	$activo         = $result["status"];

	}else{

	$titulo       = "AGREGAR DATOS BASICOS $titulo";	
	$codigo       = "";		
	$abrev        = "";
	$descripcion  = "";
	$factor       = "";
	$activo       = 'T';
	}
?><form action="sc_maestros/sc_<?php echo $archivo;?>.php" method="post" name="add" id="add"> 
  <fieldset class="fieldset">
  <legend> <?php echo $titulo;?> </legend>
     <table width="80%" align="center">
    <tr>
      <td class="etiqueta">C&oacute;digo:</td>
      <td id="input01"><input type="text" name="codigo" maxlength="11" size="12" value="<?php echo $codigo;?>" />
               Activo: <input name="activo" type="checkbox"  <?php echo statusCheck("$activo");?> value="T" /><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
	 </tr>
    <tr>
      <td class="etiqueta">Abreviatura:</td>
      <td id="input02"><input type="text" name="abrev" maxlength="2" size="12" value="<?php echo $abrev;?>" /><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>
    <tr>
      <td class="etiqueta">Descripcion:</td>
      <td id="input03"><input type="text" name="descripcion" maxlength="60" size="40" value="<?php echo $descripcion;?>" /><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>
      <td class="etiqueta">Factor:</td>
      <td id="radio01" class="texto">Positivo (+) <input type="radio" name="factor"  value="+" style="width:auto"  <?php echo CheckX($factor, '+');?> />Negativo (-) <input type="radio" name="factor" value="-" style="width:auto"  <?php echo CheckX($factor, '-');?> />
            <br/><span class="radioRequiredMsg">Debe Seleccionar Un Campo.</span>
        </td>
    </tr>
	 <tr> 
         <td height="8" colspan="2" align="center"><hr></td>
     </tr>	
  </table>

  </fieldset>
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
</div>   
  </form>
  <script type="text/javascript">
var input01  = new Spry.Widget.ValidationTextField("input01", "none", {validateOn:["blur", "change"]});
var input02  = new Spry.Widget.ValidationTextField("input02", "none", {validateOn:["blur", "change"]});
var input03  = new Spry.Widget.ValidationTextField("input03", "none", {validateOn:["blur", "change"]});

var radio01 = new Spry.Widget.ValidationRadio("radio01", { validateOn:["change", "blur"]});
</script>