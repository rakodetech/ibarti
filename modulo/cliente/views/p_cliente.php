<?php
	$proced   = "p_clientes";
if($metodo == 'modificar'){
//	$codigo = $_GET['codigo'];
	$bd = new DataBase();
	$sql = " SELECT clientes.codigo,
	                clientes.cod_cl_tipo, clientes_tipos.descripcion cl_tipo,
                  clientes.cod_vendedor, vendedores.nombre  vendedor,
								  clientes.cod_region, regiones.descripcion region,
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
<form action="" method="post"  id="add_cliente">
  <fieldset class="fieldset">
  <legend>Datos <?php echo $leng['cliente'];?></legend>
     <table width="100%" align="center">
    <tr>
      <td width="15%" class="etiqueta">C&oacute;digo:</td>

      <td width="35%"><input type="text" id="c_codigo" maxlength="11" style="width:120px" required value="<?php echo $codigo;?>" <?php echo $readonly;?> /></td>
			<td width="15%" class="etiqueta">Abreviatura:</td>
			<td width="35%"><input type="text" id="c_abrev" maxlength="14" required style="width:120px" value="<?php echo $abrev;?>" />
				Activo: <input id="c_activo" type="checkbox" <?php echo statusCheck("$activo");?> value="T" />
			</td>
		</tr>

      <td class="etiqueta"><?php echo $leng['rif'];?>: </td>
      <td><input type="text" id="c_rif" maxlength="20" style="width:150px" value="<?php echo $rif;?>"/></td>
      <td class="etiqueta"><?php echo $leng['nit'];?>:</td>
      <td><input type="text" id="c_nit" maxlength="20" style="width:150px" value="<?php echo $nit;?>"/></td>
    </tr>
    <tr>
      <td class="etiqueta">Nombre: </td>
      <td><input type="text" id="c_nombre" maxlength="60" style="width:280px" value="<?php echo $nombre;?>"/></td>
			<td class="etiqueta">Aplicar</td>
			<td><?php echo $leng['juridico'];?>: <input type="checkbox" id="c_juridico" <?php echo statusCheck("$juridico");?> value="T" />  Contribuyente: <input type="checkbox" id="c_contrib" <?php echo statusCheck("$contrib");?> value="T" /></td>
    </tr>

		<tr>
			<td class="etiqueta">Tel&eacute;fono: </td>
			<td><input type="text" id="c_telefono" maxlength="60" style="width:250px" value="<?php echo $telefono;?>"/></td>
			<td class="etiqueta">Fax: </td>
			<td><input type="text" id="c_fax" maxlength="60" style="width:250px" value="<?php echo $fax;?>"/></td>
		<tr>

		<tr>

      <td class="etiqueta">Tipo <?php echo $leng['cliente'];?>: </td>
      	<td><select id="c_cl_tipo" style="width:250px">
							<option value="<?php echo $cod_cl_tipo;?>"><?php echo $cl_tipo;?></option>
          <?php  	$sql = " SELECT codigo, descripcion FROM clientes_tipos
		                      WHERE status = 'T' AND codigo <> '$cod_cl_tipo' ORDER BY 2 ASC ";
		            $query = $bd->consultar($sql);
            		while($datos=$bd->obtener_fila($query,0)){
		  ?>
          <option value="<?php echo $datos[0];?>"><?php echo $datos[1];?></option>
          <?php }?>
        </select></td>
				<td class="etiqueta"><?php echo $leng['region'];?>:</td>
	      	<td><select id="c_region" style="width:250px" required>
								<option value="<?php echo $cod_region;?>"><?php echo $region;?></option>
	          <?php  	$sql = " SELECT codigo, descripcion FROM regiones WHERE status = 'T' ORDER BY 2 ASC ";
			            $query = $bd->consultar($sql);
	            		while($datos=$bd->obtener_fila($query,0)){
			  ?>
	          <option value="<?php echo $datos[0];?>"><?php echo $datos[1];?></option>
	          <?php }?>
	        </select></td>

	 </tr>
    <tr>
      	<td class="etiqueta">Vendedor:</td>
      	<td><select id="c_vendedor" style="width:250px" required>
							<option value="<?php echo $cod_vendedor;?>"><?php echo $vendedor;?></option>
          <?php  	$sql = " SELECT codigo, nombre FROM vendedores  WHERE status = 'T' ORDER BY 2 ASC ";
		            $query = $bd->consultar($sql);
            		while($datos=$bd->obtener_fila($query,0)){
		  ?>
          <option value="<?php echo $datos[0];?>"><?php echo $datos[1];?></option>
          <?php }?>
        </select></td>
				<td class="etiqueta">Contacto:</td>
				<td><input type="text" id="c_contacto" maxlength="60" style="width:250px" value="<?php echo $contacto;?>"/></td>
   </tr>
   <tr>
      <td class="etiqueta">Email: </td>
      <td><input type="text" id="c_email" maxlength="60" style="width:250px" value="<?php echo $email;?>"/></td>
      <td class="etiqueta">Website: </td>
      <td><input type="text" id="c_website" maxlength="60" style="width:250px" value="<?php echo $website;?>"/></td>
    </tr>
		<tr>
      <td class="etiqueta">Direcci&oacute;n:</td>
      <td><textarea id="c_direccion" cols="38" rows="4" maxlength="300" required><?php echo $direccion;?></textarea>
      <td class="etiqueta">Observación:</td>
      <td><textarea  id="c_observ" cols="38" rows="4"><?php echo $observ;?></textarea></td>
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
                <input type="button" id="volver" value="Volver" onClick="Cons_cliente_inicio()" class="readon art-button" />
                </span>
	</div>
  		    <input id="c_metodo" type="hidden" value="<?php echo $metodo;?>" />
  </fieldset>
</form>
