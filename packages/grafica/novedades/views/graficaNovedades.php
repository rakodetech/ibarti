<script language="javascript">
	$("#g_novedades_form").on('submit', function(evt){
		evt.preventDefault();
		generar();
	});
</script>

<div>
	<div align="center" class="etiqueta_title"> Gráficas Novedades </div>
	<form id="g_novedades_form">
		<div class="col-xs-12">
			<label class="etiqueta">Desde:							
				<input class="form-control" id="fec_desde" type="date" value="<?php echo $_POST['fec_desde'];?>">
			</label>
			<label class="etiqueta">Hasta:
				<input class="form-control" id="fec_hasta" type="date" value="<?php echo $_POST['fec_hasta'];?>">
			</label>
			<img class="imgLink" src="imagenes/actualizar.png" onclick=" generar()" border="0">
			<button type="submit" hidden="hidden"></button>
		</div>
	</form>
	<label style="display: none;" id="sin_data" class="etiqueta">No hay Resultados</label>
	<div class="col-xs-12">
	<div id="grafica">
		<canvas id="chart-area"></canvas>
	</div>
	<div style="display: none;" class="barra_vertical" id="division"></div>
	<div id="grafica2">
		<canvas id="chart-area2"></canvas>
	</div>
	<br class="brs">
	<br>
	</div>
</div>