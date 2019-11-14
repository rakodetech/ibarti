<?php
	$proced   = "p_clientes";
if($metodo == 'modificar'){
	$codigo = $_GET['codigo'];
	$bd = new DataBase();
	$sql = " SELECT clientes.codigo, clientes.cod_cl_tipo, clientes_tipos.descripcion AS cl_tipo,
                    clientes.cod_vendedor, vendedores.nombre AS vendedor, clientes.cod_region,
                    regiones.descripcion AS region,
                    clientes.abrev, clientes.rif,
					clientes.nit, clientes.nombre, clientes.telefono,
					clientes.fax, clientes.direccion, clientes.dir_entrega,
					clientes.email, clientes.website, clientes.contacto,
					clientes.observacion,
					clientes.juridico, clientes.contribuyente, clientes.lunes,
					clientes.martes, clientes.miercoles,  clientes.jueves,
					clientes.viernes, clientes.sabado, clientes.domingo,
					clientes.limite_cred, clientes.plazo_pago, clientes.desc_global,
					clientes.desc_p_pago,
					clientes.campo01, clientes.campo02, clientes.campo03,
					clientes.campo04,  clientes.cod_us_ing, clientes.fec_us_ing,
					clientes.cod_us_mod, clientes.fec_us_mod, clientes.status
			   FROM clientes, clientes_tipos, vendedores, regiones
			  WHERE clientes.cod_cl_tipo = clientes_tipos.codigo
			    AND clientes.cod_vendedor = vendedores.codigo
			    AND clientes.cod_region = regiones.codigo
			    AND clientes.codigo = '$codigo'  ";
	$query = $bd->consultar($sql);
	$result=$bd->obtener_fila($query,0);

	$abrev       = $result["abrev"];
	$cod_region  = $result["cod_region"];
	$region      = $result["region"];
	$cod_cl_tipo = $result["cod_cl_tipo"];
	$cl_tipo     = $result["cl_tipo"];
	$cod_vendedor= $result["cod_vendedor"];
	$vendedor    = $result["vendedor"];
	$rif         = $result["rif"];
	$nit         = $result["nit"];
	$juridico    = $result["juridico"];
	$contrib     = $result["contribuyente"];
	$nombre      = $result["nombre"];
	$telefono    = $result["telefono"];
	$fax         = $result["fax"];
	$direccion   = $result["direccion"];
	$email       = $result["email"];
	$contacto    = $result["contacto"];
	$website     = $result["website"];
	$observ      = $result["observacion"];
	$activo      = $result["status"];

	$readonly   = "readonly";

// PARTE adiccional
	$limite_cred = $result["limite_cred"];
	$plazo_pago  = $result["plazo_pago"];
	$desc_p_pago = $result["desc_p_pago"];
	$desc_global = $result["desc_global"];
    $dir_entrega = $result["dir_entrega"];
	$lunes      = $result["lunes"];
	$martes     = $result["martes"];
	$miercoles  = $result["miercoles"];
	$jueves     = $result["jueves"];
	$viernes    = $result["viernes"];
	$sabado     = $result["sabado"];
	$domingo    = $result["domingo"];
	$campo01    = $result["campo01"];
	$campo02    = $result["campo02"];
	$campo03    = $result["campo03"];
	$campo04    = $result["campo04"];

	}else{
	$readonly    = "";
	$codigo      = '';
	$abrev       = '';
	$cod_region  = '';
	$region      = ' Seleccione... ';
	$cod_cl_tipo = '';
	$cl_tipo     = ' Seleccione... ';
	$cod_vendedor= '';
	$vendedor    = 'Seleccione...';
	$rif         = '';
	$nit         = '';
	$juridico    = 'T';
	$contrib     = 'T';
	$nombre      = '';
	$telefono    = '';
	$fax         = '';
	$direccion   = '';
	$email       =  '';
	$contacto    = '';
	$website     = '';
	$observ      = '';
	$activo      = 'T';


// PARTE adiccional
	$limite_cred = '';
	$plazo_pago  = '';
	$desc_p_pago = '';
	$desc_global = '';
    $dir_entrega = '';
	$lunes    = '';
	$martes   = '';
	$miercoles = '';
	$jueves   = '';
	$viernes   = '';
	$sabado    = '';
	$domingo   = '';

	$campo01    = '';
	$campo02    = '';
	$campo03    = '';
	$campo04    = '';

	}
?>
<form action="scripts/sc_<?php echo $archivo;?>.php" method="post" name="add" id="add">
  <fieldset class="fieldset">
  <legend>Datos <?php echo $leng['cliente'];?></legend>
     <table width="100%" align="center">
    <tr>
      <td width="15%" class="etiqueta">C&oacute;digo:</td>
      <td width="35%" id="input01"><input type="text" name="codigo" id="codigo" maxlength="11" style="width:120px" value="<?php echo $codigo;?>" <?php echo $readonly;?> />
               <br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>

			<td width="15%" class="etiqueta">Abreviatura:</td>
			<td width="35%" id="input02"><input type="text" name="abrev" maxlength="14" style="width:120px" value="<?php echo $abrev;?>" />
				Activo: <input name="activo" type="checkbox"  <?php echo statusCheck("$activo");?> value="T" /><br />
			 <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
			</td>
		</tr>
		<tr>
		<td colspan="2"></td>
			<td class="etiqueta">Aplicar</td>
			<td><?php echo $leng['juridico'];?>: <input name="juridico" type="checkbox" <?php echo statusCheck("$juridico");?> value="T" />  Contribuyente: <input name="contrib" type="checkbox"  <?php echo statusCheck("$contrib");?> value="T" /></td>

    </tr>
    <tr>
      <td class="etiqueta"><?php echo $leng['rif'];?>: </td>
      <td id="input03"><input type="text" name="rif" maxlength="20" style="width:150px" value="<?php echo $rif;?>"/>
              <br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
      <td class="etiqueta"><?php echo $leng['nit'];?>: </td>
      <td id="input04"><input type="text" name="nit" maxlength="20" style="width:150px" value="<?php echo $nit;?>"/>
            <br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>
    </tr>
    <tr>
      <td class="etiqueta">Nombre: </td>
      <td id="input05"><input type="text" name="nombre" maxlength="60" style="width:280px"
                              value="<?php echo $nombre;?>"/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>

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

      <td class="etiqueta">Tipo <?php echo $leng['cliente'];?>: </td>
      	<td id="select01"><select name="cl_tipo" style="width:250px">
							<option value="<?php echo $cod_cl_tipo;?>"><?php echo $cl_tipo;?></option>
          <?php  	$sql = " SELECT codigo, descripcion FROM clientes_tipos
		                      WHERE status = 'T' AND codigo <> '$cod_cl_tipo' ORDER BY 2 ASC ";
		            $query = $bd->consultar($sql);
            		while($datos=$bd->obtener_fila($query,0)){
		  ?>
          <option value="<?php echo $datos[0];?>"><?php echo $datos[1];?></option>
          <?php }?>
        </select><br />
        	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
	 </tr>
    <tr>
      <td class="etiqueta"><?php echo $leng['region'];?>:</td>
      	<td id="select02"><select name="region" style="width:250px">
							<option value="<?php echo $cod_region;?>"><?php echo $region;?></option>
          <?php  	$sql = " SELECT codigo, descripcion FROM regiones WHERE status = 'T' ORDER BY 2 ASC ";
		            $query = $bd->consultar($sql);
            		while($datos=$bd->obtener_fila($query,0)){
		  ?>
          <option value="<?php echo $datos[0];?>"><?php echo $datos[1];?></option>
          <?php }?>
        </select><br />
        	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>

      <td class="etiqueta">Vendedor:</td>
      	<td id="select03"><select name="vendedor" style="width:250px">
							<option value="<?php echo $cod_vendedor;?>"><?php echo $vendedor;?></option>
          <?php  	$sql = " SELECT codigo, nombre FROM vendedores  WHERE status = 'T' ORDER BY 2 ASC ";
		            $query = $bd->consultar($sql);
            		while($datos=$bd->obtener_fila($query,0)){
		  ?>
          <option value="<?php echo $datos[0];?>"><?php echo $datos[1];?></option>
          <?php }?>
        </select><br />
        	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
   </tr>
   <tr>
      <td class="etiqueta">Email: </td>
      <td id="email01"><input type="text" name="email" maxlength="60" style="width:250px"
                              value="<?php echo $email;?>"/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
           <span class="textfieldInvalidFormatMsg">El Formato Es Invalido</span>
      </td>

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
<tr/>
<tr>

      <td class="etiqueta">Direcci&oacute;n:</td>
      <td id="textarea01"><textarea  name="direccion" cols="38" rows="4"><?php echo $direccion;?></textarea>
        <span id="Counterror_mess1" class="texto">&nbsp;</span><br />
        <span class="textareaRequiredMsg">El Campo es Requerido.</span>
        <span class="textareaMinCharsMsg">Debe Escribir mas de 4 caracteres.</span>
        <span class="textareaMaxCharsMsg">El maximo de caracteres permitidos es 300.</span></td>

      <td class="etiqueta">Observación:</td>
      <td id="textarea02"><textarea  name="observ" cols="38" rows="4"><?php echo $observ;?></textarea>
        <span id="Counterror_mess2" class="texto">&nbsp;</span><br />
        <span class="textareaRequiredMsg">El Campo es Requerido.</span>
        <span class="textareaMinCharsMsg">Debe Escribir mas de 4 caracteres.</span>
        <span class="textareaMaxCharsMsg">El maximo de caracteres permitidos es 300.</span></td>
    </tr>
     <tr>
         <td height="8" colspan="4" align="center"><hr></td>
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
                <input type="button" id="volver" value="Volver" onClick="Vinculo('<?php echo $inicio;?>')" class="readon art-button" />
                </span>
</div>

  		    <input name="metodo" id="metodo" type="hidden"  value="<?php echo $metodo;?>" />
            <input name="proced" id="proced" type="hidden"  value="<?php echo $proced;?>" />
            <input name="tabla" id="tabla" type="hidden"  value="<?php echo $tabla;?>" />
            <input name="usuario" id="usuario" type="hidden"  value="<?php echo $usuario;?>" />
	        <input name="href" type="hidden" value="<?php echo $archivo2;?>"/>
  </fieldset>
  <script type="text/javascript">
var input01  = new Spry.Widget.ValidationTextField("input01", "none", {validateOn:["blur", "change"]});
var input02  = new Spry.Widget.ValidationTextField("input02", "none", {validateOn:["blur", "change"]});
var input03  = new Spry.Widget.ValidationTextField("input03", "none", {validateOn:["blur", "change"]});
var input04  = new Spry.Widget.ValidationTextField("input04", "none", {validateOn:["blur", "change"],isRequired:false});
var input05  = new Spry.Widget.ValidationTextField("input05", "none", {validateOn:["blur", "change"]});
var input06  = new Spry.Widget.ValidationTextField("input06", "none", {validateOn:["blur", "change"]});
var input07  = new Spry.Widget.ValidationTextField("input07", "none", {validateOn:["blur", "change"],isRequired:false});
var input08  = new Spry.Widget.ValidationTextField("input08", "none", {validateOn:["blur", "change"],isRequired:false});
var input09  = new Spry.Widget.ValidationTextField("input09", "none", {validateOn:["blur", "change"]});

var email01    = new Spry.Widget.ValidationTextField("email01", "email", {validateOn:["blur"],isRequired:false});
var select01 = new Spry.Widget.ValidationSelect("select01", {validateOn:["blur", "change"]});
var select02 = new Spry.Widget.ValidationSelect("select02", {validateOn:["blur", "change"]});
var select03 = new Spry.Widget.ValidationSelect("select03", {validateOn:["blur", "change"]});

var textarea01 = new Spry.Widget.ValidationTextarea("textarea01", {maxChars:300, validateOn:["blur", "change"], counterType:"chars_count", counterId:"Counterror_mess1", useCharacterMasking:false});
var textarea02 = new Spry.Widget.ValidationTextarea("textarea02", {maxChars:300, validateOn:["blur", "change"], counterType:"chars_count", counterId:"Counterror_mess2", useCharacterMasking:false ,isRequired:false});
</script>
