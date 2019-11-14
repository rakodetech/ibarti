<?php
$metodo = $_GET['metodo'];
$titulo = $_GET['titulo'];
$archivo = $_GET['archivo'];

$archivo2 = "../inicio.php?area=maestros/Cons_$archivo&Nmenu=".$_GET['Nmenu']."&mod=".$_GET['mod']."";
$proced  = "p_contracto";

if($metodo == 'modificar'){
	$codigo = $_GET['codigo'];
	$bd = new DataBase();

	$sql = " SELECT contractos.descripcion,  contractos.contracto_tipo AS cod_contracto_tipo,
                    contracto_tipo.descripcion AS contracto_tipo, contractos.cestaticket,
                    contractos.fec_inicio, contractos.fec_ultimo,
					contractos.fec_us_mod, contractos.`status`
               FROM contractos, contracto_tipo
              WHERE contractos.codigo = '$codigo'
                AND contractos.contracto_tipo = contracto_tipo.codigo ";
	$query = $bd->consultar($sql);
	$result=$bd->obtener_fila($query,0);

	$descripcion    = $result["descripcion"];
	$cod_contracto_tipo  = $result["cod_contracto_tipo"];
	$contracto_tipo = $result["contracto_tipo"];
	$cestaticket    = $result["cestaticket"];
	$fec_inicio     = conversion($result["fec_inicio"]);
	$fec_ultimo     = conversion($result["fec_ultimo"]);
	$fec_us_mod     = conversion($result["fec_us_mod"]);
	$activo         = $result["status"];

	}else{
	$codigo         = '';
	$descripcion    = '';
	$cod_contracto_tipo  = '';
	$contracto_tipo = 'Seleccione...';
	$cestaticket    = '';
	$fec_inicio     = '';
	$fec_ultimo     = '';
	$fec_us_mod     = '';
	$activo         = 'T';

	}
	$sql_contracto = " SELECT codigo, descripcion FROM contracto_tipo WHERE status = 'T'
		                        AND codigo <> '$contracto_tipo' ORDER BY 2 ASC ";
?>

<form action="sc_maestros/<?php echo $archivo;?>.php" method="post" name="Mod" id="Mod">
     <table width="70%" align="center">
         <tr valign="top">
		     <td height="23" colspan="2" class="etiqueta_title" align="center"> Modificar <?php echo $titulo;?> </td>
         </tr>
         <tr>
            <td height="8" colspan="2" align="center"><hr></td>
         </tr>
    <tr>
      <td class="etiqueta">C&oacute;digo:</td>
      <td id="input01"><input type="text" name="codigo" maxlength="11" size="15" value="<?php echo $codigo;?>" />
               Activo: <input name="activo" type="checkbox"  <?php echo statusCheck("$activo");?> value="T" /><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>
    <tr>
      <td class="etiqueta" width="25%">Descripci&oacute;n:</td>
      <td id="input02" width="75%"><input type="text" name="descripcion" maxlength="120" value="<?php echo $descripcion;?>" size="25" /><br>
        <span class="textfieldRequiredMsg">La Descripcion es Requerida.</span>
		<span class="textfieldMinCharsMsg">Debe Escribir m�nimo 2 Caracteres.</span></td>
    </tr>
    <tr>
      <td class="etiqueta">Contrato Tipo: </td>
      	<td id="select01"><select name="contracto_tipo" style="width:200px">
							<option value="<?php echo $cod_contracto_tipo;?>"><?php echo $contracto_tipo;?></option>
          <?php
		            $query = $bd->consultar($sql_contracto);
            		while($datos=$bd->obtener_fila($query,0)){
		  ?>
          <option value="<?php echo $datos[0];?>"><?php echo $datos[1];?></option>
          <?php }?>
        </select><br /><span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
	 </tr>
    <tr>
      <td class="etiqueta" width="25%">Monto De Cestaticket:</td>
      <td id="input03" width="75%"><input type="text" name="cestaticket" maxlength="12" size="15" value="<?php echo $cestaticket;?>" /><br>
        <span class="textfieldRequiredMsg">La Descripcion es Requerida.</span>
		<span class="textfieldMinCharsMsg">Debe Escribir m�nimo 2 Caracteres.</span></td>
    </tr>
    <tr>
      <td class="etiqueta">Fecha Inicio: </td>
      <td id="fecha01"><input type="text" name="fec_inicio" maxlength="20" size="15" value="<?php echo $fec_inicio;?>" readonly="readonly"/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>
    <tr>
      <td class="etiqueta">Fecha Cierre: </td>
      <td id="fecha02"><input type="text" name="fec_ultimo" maxlength="20" size="15" value="<?php echo $fec_ultimo;?>"/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>
    <tr>
      <td class="etiqueta">Fecha Ultima Modificacion: </td>
      <td id="fecha02"><input type="text" name="fec_us_mod" maxlength="20" size="15" value="<?php echo $fec_us_mod;?>"/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>
      <tr>
          <td colspan="2" align="center"><hr></td>
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
        <input type="hidden" name="metodo" id="metodo" value="<?php echo $metodo;?>" />
        <input type="hidden" name="proced" id="proced" value="<?php echo $proced;?>" />
        <input type="hidden" name="usuario" id="usuario" value="<?php echo $usuario;?>" />
	    <input type="hidden" name="href" value="<?php echo $archivo2;?>"/>

  </div>
</form>
</body>
</html>
<script language="javascript" type="text/javascript">
var input01 = new Spry.Widget.ValidationTextField("input01", "none", {minChars:2, validateOn:["blur", "change"]});
var input02 = new Spry.Widget.ValidationTextField("input02", "none", {minChars:2, validateOn:["blur", "change"]});

var input03 = new Spry.Widget.ValidationTextField("input03", "currency", {validateOn:["blur"], useCharacterMasking:true});

var fecha01 = new Spry.Widget.ValidationTextField("fecha01", "date", {format:"dd-mm-yyyy", hint:"DD-MM-AAAA",
    validateOn:["blur", "change"], useCharacterMasking:true, isRequired:false});

var fecha02 = new Spry.Widget.ValidationTextField("fecha02", "date", {format:"dd-mm-yyyy", hint:"DD-MM-AAAA",
    validateOn:["blur", "change"], useCharacterMasking:true, isRequired:false});

var select01 = new Spry.Widget.ValidationSelect("select01", {validateOn:["blur", "change"]});
</script>
