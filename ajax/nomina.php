<?php

include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require "../".class_bd;
require "../".Leng;
$bd = new DataBase();


$codigo       = $_POST['codigo'];

  	 $sql    = "SELECT contractos.descripcion AS nomina,
                                contractos.fec_inicio, contractos.fec_ultimo,
                                contracto_tipo.descripcion AS tipo_nomina, contractos.`status`
                           FROM contractos , contracto_tipo
                          WHERE contractos.contracto_tipo = contracto_tipo.codigo
						  AND  contractos.codigo = '$codigo'";

	 $query = $bd->consultar($sql);
	$row01  = $bd->obtener_fila($query,0);
	?>
     <table width="75%" align="center">
         <tr>
            <td height="8" colspan="2" align="center"><hr></td>
         </tr>
   <tr>
      <td class="etiqueta">Fecha De Inicio:</td>
      <td id="input02"><input type="text" name="fec_inicio" maxlength="12" style="width:120px"
	                                      value="<?php echo conversion($row01["fec_inicio"]);?>" readonly="true"/><br>
        <span class="textfieldRequiredMsg">La Descripcion es Requerida.</span>
		<span class="textfieldMinCharsMsg">Debe Escribir mínimo 2 Caracteres.</span></td>
    </tr>
    <tr>
      <td class="etiqueta">Fecha De Cierre:</td>
      <td id="input03"><input type="text" name="usuarios" maxlength="120" style="width:250px"
                                          value="<?php echo conversion($row01["fec_ultimo"]);?>"  readonly="true"/><br>
        <span class="textfieldRequiredMsg">La Descripcion es Requerida.</span>
		<span class="textfieldMinCharsMsg">Debe Escribir mínimo 2 Caracteres.</span></td>
    </tr>
    <tr>
      <td class="etiqueta">Tipo De <?php echo $leng['nomina']?>:</td>
      <td id="input04"><input type="text" name="telefonos" maxlength="60" style="width:250px"
                                          value="<?php echo $row01["tipo_nomina"];?>"  readonly="true"/><br>
        <span class="textfieldRequiredMsg">La Descripcion es Requerida.</span>
		<span class="textfieldMinCharsMsg">Debe Escribir mínimo 2 Caracteres.</span></td>
    </tr>
    <tr>
      <td class="etiqueta">Ejecutar:</td>
      <td id="radio02" class="texto">Cerrar
       <input type = "radio" name="metodo"  value = "cerrar" style="width:auto" checked="checked"/>
         <!-- Reabrir<input type = "radio" name="metodo"  value = "reabir" style="width:auto" /> -->
  </td>
    </tr>

     <tr>
      <td class="etiqueta">Status:</td>
      <td id="input05"><input type="text" name="status" maxlength="12" style="width:250px"
	                                      value="<?php echo statuscal($row01["status"]);?>" readonly="true"/><br>
        <span class="textfieldRequiredMsg">La Descripcion es Requerida.</span>
		<span class="textfieldMinCharsMsg">Debe Escribir mínimo 2 Caracteres.</span></td>
    </tr>

          <tr>
              <td colspan="2" align="center"><hr></td>
         </tr>
  </table>
<div align="center">  <span class="art-button-wrapper">
                    <span class="art-button-l"> </span>
                    <span class="art-button-r"> </span>
                <input type="submit" name="salvar"  id="salvar" value="Procesar"  class="readon art-button" />
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
