<?php
$metodo = $_GET['metodo'];
$titulo = $_GET['titulo'];
$archivo = $_GET['archivo'];
$proced      = "p_novedades";
$archivo2 = "../inicio.php?area=maestros/Cons_$archivo&Nmenu=" . $_GET['Nmenu'] . "&mod=" . $_GET['mod'] . "";

if ($metodo == 'modificar') {
	$codigo = $_GET['codigo'];
	$bd = new DataBase();
	$sql = " SELECT novedades.codigo, 
	                novedades.descripcion,
                    novedades.cod_nov_clasif, nov_clasif.descripcion AS clasif,
                    novedades.cod_nov_tipo,  nov_tipo.descripcion AS tipo,                   
                    novedades.`status` , novedades.orden, novedades.dias_vencimiento
               FROM novedades , nov_clasif, nov_tipo 
              WHERE novedades.cod_nov_clasif = nov_clasif.codigo	
                AND novedades.cod_nov_tipo = nov_tipo.codigo 			    
                AND novedades.codigo = '$codigo' ";
	$query = $bd->consultar($sql);
	$result = $bd->obtener_fila($query, 0);

	$titulo         = "MODIFICAR DATOS BASICOS $titulo";

	$orden          = $result["orden"];
	$descripcion    = $result["descripcion"];
	$cod_clasif     = $result["cod_nov_clasif"];
	$clasif         = $result["clasif"];
	$cod_tipo       = $result["cod_nov_tipo"];
	$tipo           = $result["tipo"];
	$activo         = $result["status"];
	$dias_v					= $result["dias_vencimiento"];
} else {

	$titulo       = "AGREGAR DATOS BASICOS $titulo";
	$codigo       = "";
	$orden        = "";
	$descripcion  = "";
	$cod_clasif   = "";
	$clasif       = " Seleccione... ";
	$cod_tipo     = "";
	$tipo         = " Seleccione... ";
	$dias_v				= 0;
	$activo       = 'T';
}
?>
<script>
	function llenar_nov_tipo(clasificacion) {

		var parametros = {
			'clasificacion': clasificacion,
			'inicial': ''
		};
		$.ajax({
			data: parametros,
			url: 'ajax/Add_novedades_tipo.php',
			type: 'post',
			success: function(response) {

				console.log(response);
				$('#tipo').html(response);


			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
			}
		});
	}
</script>
<form action="sc_maestros/sc_<?php echo $archivo; ?>.php" method="post" name="add" id="add">
	<fieldset class="fieldset">
		<legend> <?php echo $titulo; ?> </legend>
		<table width="80%" align="center">
			<tr>
				<td class="etiqueta">C&oacute;digo:</td>
				<td id="input01"><input type="text" name="codigo" maxlength="11" style="width:120px" value="<?php echo $codigo; ?>" />
					Activo: <input name="activo" type="checkbox" <?php echo statusCheck("$activo"); ?> value="T" /><br />
					<span class="textfieldRequiredMsg">El Campo es Requerido...</span>
				</td>
			</tr>
			<tr>
				<td class="etiqueta">Orden:</td>
				<td id="input02"><input type="text" name="orden" maxlength="11" style="width:120px" value="<?php echo $orden; ?>" />
					<span class="textfieldRequiredMsg">El Campo es Requerido...</span>
				</td>
			</tr>
			<tr>
				<td class="etiqueta">Dias Vencimiento:</td>
				<td class="etiqueta"><input type="number" name="dias_v" min="1" id="dias_v" value="<?php echo $dias_v ?>"></td>
			</tr>
			<tr>
				<td class="etiqueta">Clasificaci&oacute;n:</td>
				<td id="select01"><select name="clasif" style="width:250px">
						<option value="<?php echo $cod_clasif; ?>"><?php echo $clasif; ?></option>
						<?php $sql = " SELECT codigo, descripcion FROM nov_clasif WHERE `status` = 'T' 
		                        AND codigo <> '$cod_clasif' ORDER BY 2 ASC ";
						$query = $bd->consultar($sql);
						while ($datos = $bd->obtener_fila($query, 0)) {
							?>
							<option value="<?php echo $datos[0]; ?>"><?php echo $datos[1]; ?></option>
						<?php } ?>
					</select><br />
					<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
			</tr>
			<tr>
				<td class="etiqueta">Tipo:</td>
				<td id="select02"><select name="tipo" id='tipo' style="width:250px">
						<option value="<?php echo $cod_tipo; ?>"><?php echo $tipo; ?></option>
						<?php $sql = " SELECT codigo, descripcion FROM nov_tipo WHERE `status` = 'T' 
		                        AND codigo <> '$cod_tipo' ORDER BY 2 ASC ";
						$query = $bd->consultar($sql);
						while ($datos = $bd->obtener_fila($query, 0)) {
							?>
							<option value="<?php echo $datos[0]; ?>"><?php echo $datos[1]; ?></option>
						<?php } ?>
					</select><br />
					<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
			</tr>
			<tr>
				<td class="etiqueta">Descripcion:</td>
				<td id="textarea01"><textarea name="descripcion" cols="60" rows="3"><?php echo $descripcion; ?></textarea>
					<span id="Counterror_mess2" class="texto">&nbsp;</span><br />
					<span class="textareaRequiredMsg">El Campo es Requerido.</span>
					<span class="textareaMinCharsMsg">Debe Escribir mas de 4 caracteres.</span>
					<span class="textareaMaxCharsMsg">El maximo de caracteres permitidos es 300.</span></td>
			</tr>

			<tr>
				<td height="8" colspan="2" align="center">
					<hr>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<?php

					$clasifi = '';
					$sql = "SELECT codigo,descripcion FROM nov_valores_clasif";
					$query = $bd->consultar($sql);
					$clasifi .= '<option value="">TODOS</option>';
					while ($datos = $bd->obtener_fila($query, 0)) {

						$clasifi .= '<option value="' . $datos[0] . '">' . $datos[1] . '</option>';
					}
					echo '
					<table width="100%" aling="center">
							<tr>
								<td>Clasificacion:</td>
								<td>Valores:</td>
								<td>Cantidad:</td>
							</tr>
							<tr>
								<td>
									<select id="clasif" style="width:150px;" onchange="llenar_valores(this.value)">
									' . $clasifi . '
									</select>
								</td>
								
								<td>
									<select id="valor" style="width:150px;">
									</select>
								</td>
								
								<td><input type="number" min="0" id="cantidad" value="0"></td>
								<td><input type="button" value="Agregar" onclick="agregar_arreglo(`valor`,`clasif`,`cantidad`,`tabla_add`)"></td>
							</tr>

							<tr>
								<td colspan="7">
									<table id="tabla_add" width="100%" border="1">
										<thead>
											<tr>
												<td class="etiqueta" style="align-content: center;" width="10%">Codigo</td>
												<td class="etiqueta" style="align-content: center;" width="20%">Valor</td>
												<td class="etiqueta" style="align-content: center;" width="20%">Clasificacion</td>
												<td class="etiqueta" style="align-content: center;" width="20%">Cantidad</td>
												<td class="etiqueta" style="align-content: center;" width="20%"></td>
											</tr>
										</thead>
										<tbody>
										
										</tbody>
									</table>								
								</td>
							</tr>
					</table>
					
					'
					/*
							


					$sql = " SELECT nov_valores.codigo AS cod, nov_valores.abrev,
                        nov_valores.descripcion, IFNULL(nov_valores_det.cod_novedades, 'N') AS factor,
						 nov_valores_det.valor 
                   FROM nov_valores LEFT JOIN nov_valores_det ON nov_valores_det.cod_novedades = '$codigo' 
				                                             AND nov_valores.codigo = nov_valores_det.cod_valores 
                  WHERE nov_valores.`status` = 'T' ";
					$query = $bd->consultar($sql);

					echo '<table width="100%" align="center">
					<tr>
						<td width="30%">VALOR</td>
						<td width="10%">CHECK</td>	
						<td width="20%">CANTIDAD</td> 
                        <td width="40%">&nbsp;</td>
					</tr>';

					while ($datos = $bd->obtener_fila($query, 0)) {
						extract($datos);
						if ($factor != "N") {
							$valorX = "S";
						} else {
							$valorX = "N";
						}
						echo ' 		
					<tr>
						<td width="20%" class="texto">' . $descripcion . '&nbsp;(' . $abrev . ')</td>
						<td width="10%"><input name="valor[]" type="checkbox" value="' . $cod . '" style="width:auto"
						                       ' . CheckX('' . $valorX . '', 'S') . ' /></td>	
						<td width="20%"><input type="text" name="cantidad_' . $cod . '" id="valor_' . $cod . '" maxlength="4" style="width:60px"
						                       value="' . $valor . '" onclick="spryN(this.id)" /></td> 
                        <td width="50%">&nbsp;</td>
					</tr>';
					}
					echo '</table></td></tr>';
*/


					?>
		</table>
	</fieldset>
	<div align="center">
		<span class="art-button-wrapper">
			<span class="art-button-l"> </span>
			<span class="art-button-r"> </span>
			<input type="submit" name="salvar" id="salvar" value="Guardar" class="readon art-button" />
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
		<input name="metodo" id="metodo" type="hidden" value="<?php echo $metodo; ?>" />
		<input name="proced" id="proced" type="hidden" value="<?php echo $proced; ?>" />
		<input name="usuario" id="usuario" type="hidden" value="<?php echo $usuario; ?>" />
		<input name="href" type="hidden" value="<?php echo $archivo2; ?>" />
	</div>
</form>

<script type="text/javascript">
	var input01 = new Spry.Widget.ValidationTextField("input01", "none", {
		validateOn: ["blur", "change"]
	});
	var input02 = new Spry.Widget.ValidationTextField("input02", "integer", {
		validateOn: ["blur", "change"]
	});

	var textarea01 = new Spry.Widget.ValidationTextarea("textarea01", {
		maxChars: 300,
		validateOn: ["blur", "change"],
		counterType: "chars_count",
		counterId: "Counterror_mess2",
		useCharacterMasking: false
	});

	var select01 = new Spry.Widget.ValidationSelect("select01", {
		validateOn: ["blur", "change"]
	});
	var select02 = new Spry.Widget.ValidationSelect("select02", {
		validateOn: ["blur", "change"]
	});

	function spryN(campoX) {
		var input04 = new Spry.Widget.ValidationTextField("" + campoX + "", "real", {
			validateOn: ["blur", "change"],
			useCharacterMasking: true,
			isRequired: false
		});
	}
</script>

<script>
	var arreglo_valores = [];
	var modificar = false;
	var pos_modificar;

	function agregar_arreglo(id1, id2, id3, tabla) {

		var aparicion = false;
		var codigo = $('#' + id1).val();
		var descripcion = $("#" + id1 + " option:selected").text();
		var id_clasif = $('#' + id2).val();
		var clasificacion = $("#" + id2 + " option:selected").text();
		var cantidad = $('#' + id3).val();

		if (!(codigo == '' || descripcion == '' || clasificacion == '' || cantidad == '')) {


			arreglo_valores.forEach((res, i) => {
				if (res.id == codigo) {
					aparicion = !aparicion;
				}
			});
			if (modificar) {
				arreglo_valores[pos_modificar] = {
					id: codigo,
					id_clasif: id_clasif,
					descripcion: descripcion,
					clasificacion: clasificacion,
					cantidad: cantidad
				}
				modificar=false;
			} else {
				if (aparicion == false) {
					arreglo_valores.push({
						id: codigo,
						id_clasif: id_clasif,
						descripcion: descripcion,
						clasificacion: clasificacion,
						cantidad: cantidad
					});
				}
			}

			update_table(tabla, arreglo_valores);
		}
	}

	function update_table(id_tabla, arreglo) {
		$('#' + id_tabla + ' tbody').html('');
		if (arreglo.length > 0) {

			console.log(arreglo)

			arreglo.forEach((res, i) => {
				$('#' + id_tabla + ' tbody').append(`
			<tr>
				<td name="valor[]" value="${res.id}">${res.id}</td>
				<td>${res.descripcion}</td>
				<td>${res.clasificacion}</td>
				<td>${res.cantidad}</td>
				<td><input type="button" value="modificar" onclick="accionar(${i},'modificar')"><input type="button" value="eliminar" onclick="accionar(${i},'eliminar')"></td>
			</tr>
			`)
			});
		}


	}

	function accionar(pos, tipo) {
		switch (tipo) {
			case 'eliminar':
				arreglo_valores.splice(pos, 1);
				break;
			case 'modificar':
				$('#clasif').val(arreglo_valores[pos].id_clasif);
				llenar_valores(arreglo_valores[pos].id_clasif);
				$('#valor').val(arreglo_valores[pos].id);
				$('#cantidad').val(arreglo_valores[pos].cantidad);
				modificar=true;
				pos_modificar=pos;
		}
		update_table('tabla_add', arreglo_valores);
	}

	function llenar_valores(clasif) {
		var parametros = {
			"clasif": clasif
		};
		$.ajax({
			data: parametros,
			url: 'ajax/Add_nov_valores.php',
			type: 'post',
			success: function(response) {
				$('#valor').html(response)
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
			}
		});
	}
</script>