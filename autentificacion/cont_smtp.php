<?php
require_once('autentificacion/aut_verifica_menu.php');
$titulo = " CONTROL DE SMTP ";
$bd = new DataBase();

$href = "../inicio.php?area=autentificacion/Cons_$archivo&Nmenu=$Nmenu&mod=$mod";
$proced = "p_control";
$titulo = "MODIFICAR $titulo";

$sql = " SELECT control.host_smtp,  control.puerto_smtp, control.protocolo_smtp,
control.cuenta_smtp,control.password_smtp
FROM control ";

$query = $bd->consultar($sql);
$result = $bd->obtener_fila($query,0);
?>
<table width="80%" align="center">
 <tr valign="top">
   <td height="23" colspan="2" class="etiqueta_title" align="center">CONTROL DE SMTP</td>
 </tr>
 <tr>
   <td height="8" colspan="2" align="center"><hr></td>
 </tr>
 <tr>
  <td class="etiqueta">Host: </td>
  <td id="input_1_01"><input type="text" name="host_smtp" style="width:200px" value="<?php echo $result['host_smtp']?>" /></td>
  </tr>
  <tr>
    <td class="etiqueta">Puerto: </td>
    <td id="input_1_02"><input type="text" name="puerto_smtp" maxlength="10" size="10" value="<?php echo $result['puerto_smtp']?>" /></td>
    </tr>
    <tr>
      <td class="etiqueta">Protocolo de Seguridad: </td>
      <td id="select_1_01"><select name="protocolo_smtp" style="width:100px">
        <?php
        if($result['protocolo_smtp'] == "NINGUNO"){
          echo '<option value="NINGUNO">NINGUNO</option>
          <option value="ssl">SSL</option>
          <option value="tsl">TSL</option>';
        }elseif ($result['protocolo_smtp'] == "ssl") {
          echo '<option value="ssl">SSL</option>
          <option value="tsl">TSL</option>
          <option value="NINGUNO">NINGUNO</option>';
        }elseif ($result['protocolo_smtp'] == "tsl") {
         echo '<option value="tsl">TSL</option>
         <option value="ssl">SSL</option>                
         <option value="NINGUNO">NINGUNO</option>';
       }
       ?>
       </select></td>
       </tr>
       <tr>
       <td class="etiqueta">Cuenta: </td>
       <td id="input_1_03"><input type="text" name="cuenta_smtp" style="width:200px" value="<?php echo $result['cuenta_smtp']?>" /></td>
       </tr>
       <tr>
       <td class="etiqueta">Password Cuenta: </td>
       <td id="input_1_04"><input type="password" name="password_smtp" style="width:200px" value="<?php echo $result['password_smtp']?>"/></td>
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
       <input name="href" type="hidden" value="<?php echo $href;?>"/>
       <input name="codigo" type="hidden" value="<?php echo $codigo;?>"/>
       </div>
       </body>
       </html>
       <script type="text/javascript">
       var input_1_01 = new Spry.Widget.ValidationTextField("input_1_01", "none", {validateOn:["blur", "change"]});
       var input_1_02 = new Spry.Widget.ValidationTextField("input_1_02", "none", {validateOn:["blur", "change"]});
       var input_1_03 = new Spry.Widget.ValidationTextField("input_1_03", "none", {validateOn:["blur", "change"]});
       var input_1_04 = new Spry.Widget.ValidationTextField("input_1_04", "none", {validateOn:["blur", "change"]});
       </script>
