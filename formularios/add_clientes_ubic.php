<script language="javascript">


$("#cl_form").on('submit', function(evt){
	 evt.preventDefault();
	 save_ubic();
});

 	function save_ubic(){


		var error = 0;
		var errorMessage = ' ';
		var cliente     = $("#codigo").val();

		var codigo     = $("#cl_codigo").val();
		var activo     = $("#cl_activo").val();
	  var nombre     = $("#cl_nombre").val();
		var region     = $("#cl_region").val();
		var estado     = $("#cl_estado").val();
		var ciudad     = $("#cl_ciudad").val();
		var calendario = $("#cl_calendario").val();
	  var contacto   = $("#cl_contacto").val();
		var cargo      = $("#cl_cargo").val();
		var telefono   = $("#cl_telefono").val();
		var email      = $("#cl_email").val();
		var direccion  = $("#cl_direccion").val();
		var observ     = $("#cl_observ").val();
		var campo01    = $("#campo01").val();
		var campo02    = $("#campo02").val();
  	var campo03    = $("#campo03").val();
		var campo04    = $("#campo04").val();


		var proced     = "p_clientes_ubic";


		var usuario     = $("#usuario").val();
		var metodo     = $("#cl_metodo").val();

		if(error == 0){
			var parametros = "X";
			var parametros = {"codigo": codigo, 	  			"activo": activo,
                        "nombre": nombre,           "region" : region,
												"estado": estado,           "ciudad": ciudad ,
												"calendario":calendario ,   "contacto": contacto ,
												"cargo": cargo,             "telefono": telefono ,
												"email": email,             "direccion": direccion ,
												"observ":observ,
												"proced": proced, 					"usuario": usuario,
												"metodo":metodo,            "cliente": cliente,
												"campo01":campo01,          "campo02":campo02 ,
												"campo03":campo03, 					"campo04":campo04
												};

								$.ajax({
										data:  parametros,
										url:   'scripts/sc_clientes_ubic.php',
										type:  'post',
										success:  function (response) {
											CloseModal();
										},
									error: function (xhr, ajaxOptions, thrownError) {
				       				alert(xhr.status);
				        			alert(thrownError);}
								});


			}else{
				alert(errorMessage);
			}
		}
	</script>
<?php
	$proced      = "p_clientes_ubic";
if($metodo == 'modificar'){

	$bd = new DataBase();
	$sql = " SELECT clientes_ubicacion.cod_estado, estados.descripcion AS estado,
					clientes_ubicacion.cod_ciudad, ciudades.descripcion AS ciudad,
                    clientes_ubicacion.cod_region, regiones.descripcion AS region,
				    clientes_ubicacion.cod_calendario, nom_calendario.descripcion AS calendario,
                    clientes_ubicacion.descripcion, clientes_ubicacion.direccion,
                    clientes_ubicacion.contacto, clientes_ubicacion.cargo,
					clientes_ubicacion.telefono,
                    clientes_ubicacion.email, clientes_ubicacion.observacion,
					clientes_ubicacion.campo01, clientes_ubicacion.campo02,
					clientes_ubicacion.campo03, clientes_ubicacion.campo04,
					clientes_ubicacion.`status`
               FROM clientes_ubicacion, estados,  ciudades , regiones, nom_calendario
              WHERE clientes_ubicacion.cod_estado = estados.codigo
			    AND clientes_ubicacion.cod_ciudad = ciudades.codigo
			    AND clientes_ubicacion.cod_region = regiones.codigo
			    AND clientes_ubicacion.cod_calendario = nom_calendario.codigo
				AND clientes_ubicacion.codigo = '$codigo'";

	$query = $bd->consultar($sql);
	$result=$bd->obtener_fila($query,0);

	$cod_estado   = $result["cod_estado"];
	$estado       = $result["estado"];
    $cod_ciudad   = $result["cod_ciudad"];
	$ciudad       = $result["ciudad"];
	$cod_region   = $result["cod_region"];
	$region       = $result["region"];
	$cod_calendario= $result["cod_calendario"];
	$calendario   = $result["calendario"];
	$nombre       = $result["descripcion"];
	$direccion    = $result["direccion"];
	$contacto     = $result["contacto"];
	$cargo        = $result["cargo"];
	$telefono     = $result["telefono"];
	$email        = $result["email"];
    $observ       = $result["observacion"];
	$activo       = $result["status"];
	// PARTE adiccional
	$campo01    = $result["campo01"];
	$campo02    = $result["campo02"];
	$campo03    = $result["campo03"];
	$campo04    = $result["campo04"];

	}else{
	$codigo       = '';
	$cod_estado   = '';
	$estado       = ' Seleccione... ';
    $cod_ciudad   = '';
	$ciudad       = ' Seleccione... ';
	$cod_region   = '';
	$region       = ' Seleccione... ';
	$cod_calendario = '';
	$calendario   = ' Seleccione... ';
	$nombre       = '';
	$direccion    = '';
	$contacto     = '';
	$cargo        = '';
	$telefono     = '';
	$email        = '';
	$observ       = '';
	// PARTE adiccional
	$campo01    = '';
	$campo02    = '';
	$campo03    = '';
	$campo04    = '';
	$activo     = 'T';

	}
?>

<form id="cl_form" name="cl_form" method="post">


<fieldset class="fieldset">
  <legend>Datos <?php echo $titulo;?></legend>
     <table width="90%" align="center">
    <tr>
      <td width="15%" class="etiqueta">C&oacute;digo:</td>
      <td width="35%"><input type="text" id="cl_codigo" name="cl_codigo" maxlength="11" size="15" value="<?php echo $codigo;?>" readonly  />
               Activo: <input id="cl_activo" name="cl_activo" type="checkbox"  <?php echo statusCheck("$activo");?> value="T" />
      </td>

      <td width="15%" class="etiqueta"><?php echo $leng['ubicacion']?>: </td>
      <td width="35%"><input type="text" name="cl_nombre" id="cl_nombre" maxlength="30" size="30" required value="<?php echo $nombre;?>"/>
      </td>
    </tr>
    <tr>
      <td class="etiqueta"><?php echo $leng['region']?>:</td>
      	<td><select name="cl_region" id="cl_region" style="width:250px" required>
							<option value="<?php echo $cod_region;?>"><?php echo $region;?></option>
          <?php  	$sql = " SELECT codigo, descripcion FROM regiones WHERE status = 'T' ORDER BY 2 ASC ";
		            $query = $bd->consultar($sql);
            		while($datos=$bd->obtener_fila($query,0)){
		  ?>
          <option value="<?php echo $datos[0];?>"><?php echo $datos[1];?></option>
          <?php }?>
        </select></td>

      <td class="etiqueta"><?php echo $leng['estado']?>: </td>
      	<td><select id="cl_estado" name="cl_estado" required style="width:250px" onchange="Filtrar_select(this.value, 'cl_ciudad', 'ajax/Add_select_ciudad.php', 'ciudad', '250px', '')">
							<option value="<?php echo $cod_estado;?>"><?php echo $estado;?></option>
          <?php  	$sql = "SELECT estados.codigo, estados.descripcion, estados.`status` FROM estados , control
                             WHERE estados.cod_pais = control.cod_pais
                               AND estados.`status` = 'T' ORDER BY 2 ASC ";
		            $query = $bd->consultar($sql);
            		while($datos=$bd->obtener_fila($query,0)){
		  ?>
          <option value="<?php echo $datos[0];?>"><?php echo $datos[1];?></option>
          <?php }?>
        </select><br /><span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
	 </tr>
    <tr>
      <td class="etiqueta"><?php echo $leng['ciudad']?>:</td>
      <td id="ciudad"><select id="cl_ciudad" name="cl_ciudad" style="width:250px"  required>
							<option value="<?php echo $cod_ciudad;?>"><?php echo $ciudad;?></option>
          <?php  	$sql = " SELECT ciudades.codigo, ciudades.descripcion FROM ciudades
							  WHERE ciudades.cod_estado = '$cod_estado'
							    AND ciudades.`status` = 'T'  ORDER BY 2 ASC ";
		            $query = $bd->consultar($sql);
            		while($datos=$bd->obtener_fila($query,0)){
		  ?>
          <option value="<?php echo $datos[0];?>"><?php echo $datos[1];?></option>
          <?php }?>
        </select></td>

				<td class="etiqueta">Calendario:</td>
				<td id="ciudad"><select id="cl_calendario" name="cl_calendario" style="width:250px"  required>
								<option value="<?php echo $cod_calendario;?>"><?php echo $calendario;?></option>
						<?php  	$sql = " SELECT nom_calendario.codigo, nom_calendario.descripcion
	                             FROM nom_calendario
	                            WHERE status = 'T'  AND tipo = 'VAR'
	                            ORDER BY 2 ASC ";
									$query = $bd->consultar($sql);
									while($datos=$bd->obtener_fila($query,0)){
				?>
						<option value="<?php echo $datos[0];?>"><?php echo $datos[1];?></option>
						<?php }?>
					</select></td>


    </tr>
    <tr>
      <td class="etiqueta">Contacto: </td>
      <td id="input03"><input type="text" name="cl_contacto" id="cl_contacto" maxlength="30" size="30" value="<?php echo $contacto;?>" required/><br />
		   <span class="textfieldRequiredMsg">El Campo es Requerido...</span>
      </td>

      <td class="etiqueta">Cargo: </td>
      <td id="input04"><input type="text" name="cl_cargo" id="cl_cargo" maxlength="30" size="30" value="<?php echo $cargo;?>" required/>
      </td>
    </tr>
    <tr>
      <td class="etiqueta">Tel&eacute;fono: </td>
      <td id="input05"><input type="text" name="cl_telefono" id="cl_telefono" maxlength="60" size="30" value="<?php echo $telefono;?>"/>
      </td>

      <td class="etiqueta"><?php echo $leng['correo']?>: </td>
      <td><input  type="email" name="cl_email" id="cl_email" maxlength="60" size="30" value="<?php echo $email;?>"/></td>
    </tr>
    <tr>
      <td class="etiqueta">Direcci&oacute;n:</td>
      <td id="textarea01"><textarea  name="cl_direccion" id="cl_direccion" cols="50" rows="3"><?php echo $direccion;?></textarea>
        <span id="Counterror_mess2" class="texto">&nbsp;</span><br />
        <span class="textareaRequiredMsg">El Campo es Requerido.</span>
        <span class="textareaMinCharsMsg">Debe Escribir mas de 4 caracteres.</span>
        <span class="textareaMaxCharsMsg">El maximo de caracteres permitidos es 300.</span></td>

      <td class="etiqueta">Observación:</td>
      <td id="textarea02"><textarea  name="cl_observ" id="cl_observ" cols="50" rows="3"><?php echo $observ;?></textarea>
        <span id="Counterror_mess2" class="texto">&nbsp;</span><br />
        <span class="textareaRequiredMsg">El Campo es Requerido.</span>
        <span class="textareaMinCharsMsg">Debe Escribir mas de 4 caracteres.</span>
        <span class="textareaMaxCharsMsg">El maximo de caracteres permitidos es 300.</span></td>
    </tr>
	 <tr>
         <td height="8" colspan="4" align="center"><hr></td>
     </tr>

  </table>
	<div align="center"><br/><!--<span class="art-button-wrapper">
				 <span class="art-button-l"> </span>
				 <span class="art-button-r"> </span>
		 	 	<input type="button" name="salvar"  id="salvar" value="Guardar" onclick="save_ubic()" class="readon art-button" />
		 </span>&nbsp; -->

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
		 <input type="button" id="volver" value="Cerrar" onClick="CloseModal();" class="readon art-button" />
		 </span>
	</div>
	 <input name="metodo" id="cl_metodo" type="hidden"  value="<?php echo $metodo;?>" />

  </fieldset>


<script type="text/javascript">
var textarea01 = new Spry.Widget.ValidationTextarea("textarea01", {maxChars:300, validateOn:["blur", "change"], counterType:"chars_count", counterId:"Counterror_mess2", useCharacterMasking:false ,isRequired:false});
var textarea02 = new Spry.Widget.ValidationTextarea("textarea02", {maxChars:300, validateOn:["blur", "change"], counterType:"chars_count", counterId:"Counterror_mess2", useCharacterMasking:false ,isRequired:false});
</script>
