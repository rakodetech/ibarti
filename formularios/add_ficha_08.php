<?php
//	require_once('autentificacion/aut_verifica_menu.php');
$proced      = "p_fichas_08";
$metodo    = "agregar";
//	$archivo = "pestanas/add_ficha&Nmenu=".$Nmenu."&codigo=".$codigo."&mod=$mod&pagina=2&metodo=modificar";




$sql01 =	"SELECT  IFNULL((SELECT ADDDATE((b.fec_fin), INTERVAL 1 DAY) FROM ficha_historial_covid19 b WHERE b.codigo = MAX(ficha_historial_covid19.codigo)), ficha.fec_ingreso) AS fec_inicio
	             FROM ficha LEFT JOIN  ficha_historial_covid19  ON ficha.cod_ficha = ficha_historial_covid19.cod_ficha
	            WHERE ficha.cod_ficha = '$codigo' ";
$query = $bd->consultar($sql01);
$datos = $bd->obtener_fila($query, 0);
$fec_inicio = conversion($datos[0]);

$sql01 =	"SELECT ficha_historial_covid19.codigo,
                    ficha_historial_covid19.fec_inicio, ficha_historial_covid19.fec_fin,
                    ficha_dosis_covid19.descripcion AS dosis, ficha_historial_covid19.fec_us_ing,
                    CONCAT(men_usuarios.apellido,' ', men_usuarios.nombre) AS usuario, ficha_historial_covid19.observacion
               FROM ficha_historial_covid19
							  LEFT JOIN men_usuarios ON ficha_historial_covid19.cod_us_ing = men_usuarios.codigo ,
                     ficha_dosis_covid19
               WHERE ficha_historial_covid19.cod_ficha =  '$codigo'
                 AND ficha_historial_covid19.cod_dosis = ficha_dosis_covid19.codigo
								 ORDER BY codigo DESC  ";
?>
<script language="javascript">
	function Historial(metodo) { // CARGAR  ARCHIVO DE AJAX CON UN PARAMETRO //
		$("#button_historial_dosis").attr('disabled', true);
		var codigo = $("#codigo_dosis").val();
		var cod_ficha = $("#codigo").val();
		var fecha = $("#fecha_dosis").val();
		var dosis = $("#dosis_hist").val();
		var observacion = $("#observacion_dosis").val();
		var Nmenu = $("#Nmenu").val();
		var mod = $("#mod").val();
		var archivo = $("#archivo").val();
		var usuario = $("#usuario").val();

		var error = 0;
		var errorMessage = ' ';

		if (dosis == '') {
			var error = error + 1;
			errorMessage = errorMessage + ' \n Debe Seleccionar un dosis ';
		}
		if (observacion == '') {
			var error = error + 1;
			errorMessage = errorMessage + ' \n Debe Ingresar una observacion ';
		}

		if (error == 0) {


			var parametros = {
				"codigo": codigo,
				"cod_ficha": cod_ficha,
				"fecha": fecha,
				"observacion": observacion,
				"dosis": dosis,
				"metodo": metodo,
				"Nmenu": Nmenu,
				"mod": mod,
				"archivo": archivo,
				"usuario": usuario,
				"proced": 'p_fichas_08'
			};
			$.ajax({
				data: parametros,
				url: 'scripts/sc_ficha_08.php',
				type: 'post',
				beforeSend: function() {
					$("#button_historial_dosis").remove();
					$("#cont_button_08").html("<img src='imagenes/loading.gif' /> Procesando, espere por favor...");
				},
				success: function(response) {
					location.reload();
				},

				error: function(xhr, ajaxOptions, thrownError) {
					alert(xhr.status);
					alert(thrownError);
				}
			});

		} else {
			alert(errorMessage);
		}
		$("#button_historial_dosis").attr('disabled', false);
	}
</script>
<div align="center" class="etiqueta_title"> HISTORIAL DE DOSIS</div>
<hr />
<div id="Contenedor08" class="mensaje"></div>
<form id="add_08" name="add_08" action="scripts/sc_ficha_08.php" method="post">
	<table width="100%" border="0" align="center">
		<tr>
			<td width="15%" class="etiqueta">Fecha</td>
			<td width="30%" class="etiqueta" id="fecha01_7">
				<input type="text" name="fecha_dosis" id="fecha_dosis" size="9" value="<?php echo $fec_inicio; ?>" onclick="javascript:muestraCalendario('add_08', 'fecha_dosis');">&nbsp;<img src="imagenes/icono-calendario.gif" onclick="javascript:muestraCalendario('add_08', 'fecha_dosis');" border="0" width="17px">
			</td>
			<td width="15%" class="etiqueta">Dosis</td>
			<td width="30%" class="etiqueta" id="select01_7"><select name="dosis_hist" id="dosis_hist" style="width:150px">
					<option value="">Seleccione...</option>
					<?php
					$query = $bd->consultar($sql_dosis_covid19);
					while ($datos = $bd->obtener_fila($query, 0)) {
					?>
						<option value="<?php echo $datos[0]; ?>"><?php echo $datos[1]; ?></option>
					<?php } ?>
				</select> </td>
			<td width="10%"><img src="imagenes/loading2.gif" width="20" height="20" title="" border="null" /></th>
		</tr>
		<tr>
			<td class="etiqueta">Observación</td>
			<td colspan="2" class="etiqueta" id="textarea01_7"><textarea name="observacion_dosis" id="observacion_dosis" cols="60" rows="1"></textarea> </td>
			<td width="10%"><span class="art-button-wrapper">
					<span class="art-button-l"> </span>
					<span class="art-button-r"> </span>
					<id="cont_button_08"><input type="button" name="submit" id="button_historial_dosis" value="Ingresar" onclick="Historial('agregar')" class="readon art-button" />
				</span>
				<input type="hidden" name="codigo_dosis" id="codigo_dosis" value="0" />
				</span></th>
		</tr>
	</table>
	<hr />

	<table width="100%" border="0" align="center">
		<tr class="fondo00">
			<th width="20%" class="etiqueta">Fecha </th>
			<th width="20%" class="etiqueta">Dosis </th>
			<th width="32%" class="etiqueta">Observacion</th>
			<th width="28%" class="etiqueta">Usuario Ingreso </th>
		</tr>
		<?php
		$query = $bd->consultar($sql01);
		$i = 0;
		$valor = 0;
		while ($datos = $bd->obtener_fila($query, 0)) {
			$i++;
			if ($valor == 0) {
				$fondo = 'fondo01';
				$valor = 1;
			} else {
				$fondo = 'fondo02';
				$valor = 0;
			}
			$us_ing =  $datos['fec_us_ing'] . " - " . $datos['usuario'];

			$borrar = 	 "'" . $datos[0] . "'";
			echo '<tr class="' . $fondo . '">
									<td>' . conversion($datos['fec_inicio']) . ' al ' . conversion($datos['fec_fin']) . ' </td>
									<td>' . longitud($datos['dosis']) . '</td>
				  				<td>' . $datos['observacion'] . '</td>
           	      <td>' . longitudMax($us_ing) . '<td>
								</tr>';
		}
		?>
	</table>
	<input name="href" type="hidden" value="../inicio.php?area=<?php echo $archivo ?>" />
	<input name="metodo" type="hidden" value="<?php echo $metodo; ?>" />
	<input name="proced" id="proced" type="hidden" value="<?php echo $proced; ?>" />
	<input name="pestana" type="hidden" value="familia" />
	<input type="hidden" name="usuario" id="usuario" value="<?php echo $usuario; ?>" />
	<input type="hidden" name="codigo" id="codigo" value="<?php echo $codigo; ?>" />
	<input type="hidden" id="i" value="<?php echo $i; ?>" />
</form>
<br />
<br />
<script language="javascript" type="text/javascript">
	var select01_7 = new Spry.Widget.ValidationSelect("select01_7", {
		validateOn: ["blur", "change"]
	});

	var fecha01_7 = new Spry.Widget.ValidationTextField("fecha01_7", "date", {
		format: "dd-mm-yyyy",
		hint: "DD-MM-AAAA",
		validateOn: ["blur", "change"],
		useCharacterMasking: true
	});

	var textarea01_7 = new Spry.Widget.ValidationTextarea("textarea01_7", {
		maxChars: 255,
		validateOn: ["blur", "change"],
		counterType: "chars_count",
		counterId: "Counterror_mess1",
		useCharacterMasking: false
	});
</script>