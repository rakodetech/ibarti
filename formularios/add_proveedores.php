<?php
	$proced   = "p_proveedores";
if($metodo == 'modificar'){
	$codigo = $_GET['codigo'];
	$bd = new DataBase();
	$sql = " SELECT proveedores.codigo, proveedores.cod_prov_tipo,
	                 prov_tipos.descripcion AS prov_tipo, proveedores.cod_zona,
	                 zonas.descripcion AS zona, proveedores.cod_estado,
					 estados.descripcion AS estados, proveedores.cod_ciudad,
					 ciudades.descripcion AS ciudad, proveedores.rif,
					 proveedores.nit, proveedores.nacional,
					 proveedores.nombre, proveedores.telefono,
					 proveedores.fax, proveedores.direccion,
					 proveedores.email, proveedores.website,
					 proveedores.contacto, proveedores.dias_credito,
					 proveedores.lim_credito, proveedores.plazo_pago,
					 proveedores.desc_pago, proveedores.desc_global,
					 proveedores.campo01, proveedores.campo02,
					 proveedores.campo03, proveedores.campo04,
					 proveedores.status
                FROM proveedores , prov_tipos ,  zonas ,  estados , ciudades
			   WHERE proveedores.cod_prov_tipo = prov_tipos.codigo
				 AND proveedores.cod_zona = zonas.codigo
				 AND proveedores.cod_estado = estados.codigo
				 AND proveedores.cod_ciudad = ciudades.codigo
			     AND proveedores.codigo = '$codigo' ";
	$query = $bd->consultar($sql);
	$result=$bd->obtener_fila($query,0);

	$cod_zona    = $result["cod_zona"];
	$zona        = $result["zona"];
	$cod_prov_tipo = $result["cod_prov_tipo"];
	$prov_tipo   = $result["prov_tipo"];
	$cod_estados = $result["cod_estado"];
	$estados     = $result["estados"];
	$cod_ciudad  = $result["cod_ciudad"];
	$ciudad      = $result["ciudad"];
	$rif         = $result["rif"];
	$nit         = $result["nit"];
	$nacional    = $result["nacional"];
	$nombre      = $result["nombre"];
	$telefono    = $result["telefono"];
	$fax         = $result["fax"];
	$direccion   = $result["direccion"];
	$email       = $result["email"];
	$contacto    = $result["contacto"];
	$website     = $result["website"];
	$activo    = $result["status"];

// PARTE adiccional
    $dias_credito = $result["dias_credito"];
	$lim_credito = $result["lim_credito"];
	$plazo_pago  = $result["plazo_pago"];
	$desc_pago   = $result["desc_pago"];
	$desc_global = $result["desc_global"];
	$campo01    = $result["campo01"];
	$campo02    = $result["campo02"];
	$campo03    = $result["campo03"];
	$campo04    = $result["campo04"];

	}else{
	$codigo      = '';
	$cod_zona    = '';
	$zona        = ' Seleccione... ';
	$cod_prov_tipo = '';
	$prov_tipo = ' Seleccione... ';
	$cod_estados = '';
	$estados     = 'Seleccione...';
	$cod_ciudad  = '';
	$ciudad      = 'Seleccione...';
	$rif = '';
	$nit = '';
	$nacional = 'T';
	$nombre = '';
	$telefono = '';
	$fax = '';
	$direccion = '';
	$email = '';
	$contacto    = '';
	$website = '';
	$activo      = 'T';

// PARTE adiccional
    $dias_credito = '';
	$lim_credito = '';
	$plazo_pago  = '';
	$desc_pago = '';
	$desc_global = '';
    $dir_entrega = '';

	$campo01    = '';
	$campo02    = '';
	$campo03    = '';
	$campo04    = '';

	}
$sql_ciudad = " SELECT codigo, descripcion FROM ciudades WHERE cod_estado = '$cod_estados'
			       AND codigo <> '$cod_ciudad' ORDER BY descripcion ASC ";
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
      <td class="etiqueta"><?php echo $leng['rif'];?>: </td>
      <td id="input03"><input type="text" name="rif" maxlength="20" style="width:150px" value="<?php echo $rif;?>"/>
             <?php echo $leng['nacional'];?>: <input name="nacional" type="checkbox"  <?php echo statusCheck("$nacional");?> value="T" /><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>
    <tr>
      <td class="etiqueta"><?php echo $leng['nit'];?>: </td>
      <td id="input04"><input type="text" name="nit" maxlength="20" style="width:150px" value="<?php echo $nit;?>"/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>
    <tr>
      <td class="etiqueta">nombre: </td>
      <td id="input05"><input type="text" name="nombre" maxlength="120" style="width:300px"
                              value="<?php echo $nombre;?>"/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>
    <tr>
      <td class="etiqueta">Tel&eacute;fono: </td>
      <td id="input06"><input type="text" name="telefono" maxlength="60" style="width:250px"
                              value="<?php echo $telefono;?>"/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>
    <tr>
      <td class="etiqueta">Fax: </td>
      <td id="input07"><input type="text" name="fax" maxlength="60" style="width:250px"
                              value="<?php echo $fax;?>"/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>
    <tr>
      <td class="etiqueta">Tipo Proveedor: </td>
      	<td id="select01"><select name="prov_tipo" style="width:250px">
							<option value="<?php echo $cod_prov_tipo;?>"><?php echo $prov_tipo;?></option>
          <?php  	$sql = " SELECT codigo, descripcion FROM prov_tipos WHERE status = 'T' AND codigo <> '$cod_prov_tipo' ORDER BY 2 ASC ";
		            $query = $bd->consultar($sql);
            		while($datos=$bd->obtener_fila($query,0)){
		  ?>
          <option value="<?php echo $datos[0];?>"><?php echo $datos[1];?></option>
          <?php }?>
        </select><br /><span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
	 </tr>
    <tr>
      <td class="etiqueta">Zona:</td>
      	<td id="select02"><select name="zona" style="width:250px">
							<option value="<?php echo $cod_zona;?>"><?php echo $zona;?></option>
          <?php  	$sql = " SELECT codigo, descripcion FROM zonas  WHERE status = 'T' AND codigo <> '$cod_zona' ORDER BY 2 ASC ";
		            $query = $bd->consultar($sql);
            		while($datos=$bd->obtener_fila($query,0)){
		  ?>
          <option value="<?php echo $datos[0];?>"><?php echo $datos[1];?></option>
          <?php }?>
        </select><br /><span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
    </tr>
    <tr>
      <td class="etiqueta"><?php echo $leng['estado'];?>:</td>
      	<td id="select03"><select name="estados" style="width:250px" onchange="Add_ajax01(this.value, 'ajax/Add_ciudad.php', 'ciudad')">
							<option value="<?php echo $cod_estados;?>"><?php echo $estados;?></option>
          <?php  	$sql = " SELECT codigo, descripcion FROM estados, control WHERE status = 'T'
                                AND control.cod_pais = estados.cod_pais
                                AND codigo <> '$cod_estados'
                           ORDER BY 2 ASC ";
		            $query = $bd->consultar($sql);
            		while($datos=$bd->obtener_fila($query,0)){
		  ?>
          <option value="<?php echo $datos[0];?>"><?php echo $datos[1];?></option>
          <?php }?>
        </select><br /><span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
    </tr>
    <tr>
      <td class="etiqueta"><?php echo $leng['ciudad'];?>:</td>
      	<td id="ciudad"><select name="ciudad" style="width:250px">
						<option value="<?php echo $cod_ciudad;?>"><?php echo $ciudad;?></option>
          <?php     $query = $bd->consultar($sql_ciudad);
            		while($datos=$bd->obtener_fila($query,0)){
		  ?>
          <option value="<?php echo $datos[0];?>"><?php echo $datos[1];?></option>
          <?php }?>
        </select><br /><span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
    </tr>

   <tr>
      <td class="etiqueta">Email: </td>
      <td id="email01"><input type="text" name="email" maxlength="60" style="width:250px"
                              value="<?php echo $email;?>"/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
           <span class="textfieldInvalidFormatMsg">El Formato Es Invalido</span>
      </td>
    </tr>
   <tr>
      <td class="etiqueta">Website: </td>
      <td id="input08"><input type="text" name="website" maxlength="60" style="width:250px"
                              value="<?php echo $website;?>"/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>
    <tr>
      <td class="etiqueta">Contacto: </td>
      <td id="input09"><input type="text" name="contacto" maxlength="60" style="width:250px"
                              value="<?php echo $contacto;?>"/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>
    <tr>
      <td class="etiqueta">Direcci&oacute;n:</td>
      <td id="textarea01"><textarea  name="direccion" cols="45" rows="3"><?php echo $direccion;?></textarea>
        <span id="Counterror_mess2" class="texto">&nbsp;</span><br />
        <span class="textareaRequiredMsg">El Campo es Requerido.</span>
        <span class="textareaMinCharsMsg">Debe Escribir mas de 4 caracteres.</span>
        <span class="textareaMaxCharsMsg">El maximo de caracteres permitidos es 300.</span></td>
    </tr>

	 <tr>
         <td height="8" colspan="2" align="center"><hr></td>
     </tr>
     <tr>
         <td colspan="2" align="center">

         </td>
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
  </div>
  </fieldset>
  <script type="text/javascript">
var input01  = new Spry.Widget.ValidationTextField("input01", "none", {validateOn:["blur", "change"]});
var input02  = new Spry.Widget.ValidationTextField("input02", "none", {validateOn:["blur", "change"]});
var input03  = new Spry.Widget.ValidationTextField("input03", "none", {validateOn:["blur", "change"]});
var input04  = new Spry.Widget.ValidationTextField("input04", "none", {validateOn:["blur", "change"]});
var input05  = new Spry.Widget.ValidationTextField("input05", "none", {validateOn:["blur", "change"]});
var input06  = new Spry.Widget.ValidationTextField("input06", "none", {validateOn:["blur", "change"]});
var input07  = new Spry.Widget.ValidationTextField("input07", "none", {validateOn:["blur", "change"],isRequired:false});
var input08  = new Spry.Widget.ValidationTextField("input08", "none", {validateOn:["blur", "change"],isRequired:false});
var input09  = new Spry.Widget.ValidationTextField("input09", "none", {validateOn:["blur", "change"]});

var email01  = new Spry.Widget.ValidationTextField("email01", "email", {validateOn:["blur"],isRequired:false});
var select01 = new Spry.Widget.ValidationSelect("select01", {validateOn:["blur", "change"]});
var select02 = new Spry.Widget.ValidationSelect("select02", {validateOn:["blur", "change"]});
var select03 = new Spry.Widget.ValidationSelect("select03", {validateOn:["blur", "change"]});

var textarea01 = new Spry.Widget.ValidationTextarea("textarea01", {maxChars:300, validateOn:["blur", "change"], counterType:"chars_count", counterId:"Counterror_mess2", useCharacterMasking:false});
</script>
