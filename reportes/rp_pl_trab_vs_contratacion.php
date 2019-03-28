<link rel="stylesheet" type="text/css" href="latest/stylesheets/autocomplete.css" />
<link rel="stylesheet" href="css/modal_planif.css" type="text/css" media="screen" />
<script type="text/javascript" src="funciones/modal.js"></script>
<script type="text/javascript" src="latest/scripts/autocomplete.js"></script>
<script type="text/javascript" src="libs/planificacionRP.js"></script>

<?php 
$Nmenu   = '5303'; 
$mod     =  $_GET['mod'];
require_once('autentificacion/aut_verifica_menu.php');
require_once('sql/sql_report.php');
$bd = new DataBase(); 
$archivo = "reportes/rp_pl_trab_vs_contratacion_det.php?Nmenu=$Nmenu&mod=$mod.php";	
$titulo  = " PLANIFICACION VS CONTRATACION ";

$titulo      = "REPORTE $titulo";
?>	
<div id="modalRP" class="modal">
	<div class="modal-content">
		<div class="modal-header">
			<span class="close" onclick="$('#modalRP').hide()" >&times;</span>
			<span id="modal_titulo2"></span>
		</div>
		<div class="modal-body">
			<div id="RP"></div>
			<div id="modal_contenidoRP"></div>
			<form action="packages/planif/planificaciones/views/rp_planif_serv.php" method="post" name="add_planif_serv_modal" id="add_planif_serv_modal" method="post" target="_blank">
				<input type="hidden" name="contratacion" id="cod_contratacion_serv" value="">
				<input type="hidden" name="ubicacion" id="cod_ubic_serv" value="">
				<input type="hidden" name="body_planif" id="body_planif" value="">
				<input type="hidden" name="reporte" id="reporte_serv" value="">
			</form>
		</div>
	</div>
</div>
<div align="center" class="etiqueta_title"><?php echo $titulo;?> </div> 
<form name="form_reportes" id="form_reportes_planif" action="<?php echo $archivo;?>"  method="post" target="_blank">
	<hr />
	<table width="100%" align="center">
		<tr>
			<td width="10%" class="etiqueta">Fecha Desde:</td>
			<td width="14%" id="fecha01"><input type="text" name="fecha_desde" id="fecha_desde" style="width:85px" required onclick="javascript:muestraCalendario('form_reportes', 'fecha_desde');">&nbsp;<img src="imagenes/icono-calendario.gif" onclick="javascript:muestraCalendario('form_reportes', 'fecha_desde');" border="0" width="17px"></td>
			<td width="10%"  class="etiqueta">Fecha Hasta:</td>
			<td width="14%" id="fecha02"><input type="text" name="fecha_hasta" id="fecha_hasta" style="width:85px" required onclick="javascript:muestraCalendario('form_reportes', 'fecha_hasta');">&nbsp;<img src="imagenes/icono-calendario.gif" onclick="javascript:muestraCalendario('form_reportes', 'fecha_hasta');" border="0" width="17px"></td>
			<td  class="etiqueta"><?php echo $leng['cliente']?>:</td>
			<td><select name="cliente" id="cliente" style="width:120px;" onchange="Add_Cl_Ubic(this.value, 'contenido_ubic', 'T', '120')" required>

				<?php
				echo $select_cl;
				$query01 = $bd->consultar($sql_cliente);
				while($row01=$bd->obtener_fila($query01,0)){
					echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
				}?></select></td>
				<td  class="etiqueta"><?php echo $leng['ubicacion']?>: </td>
				<td id="contenido_ubic"><select name="ubicacion" id="ubicacion" style="width:120px;" required>
					<option value="TODOS">TODOS</option>
				</select></td>
			</tr>
			<tr>
				<td height="8" colspan="8" align="center"><hr></td>
			</tr>
		</table>
		<div align="center"><br/>
			<span class="art-button-wrapper">
				<span class="art-button-l"> </span>
				<span class="art-button-r"> </span>
				<input type="button" name="salir" id="salir" value="Salir" onclick="Vinculo('inicio.php?area=formularios/index')" 
				class="readon art-button">
			</span>
			<input hidden="hidden" type="submit"> 
			<img class="imgLink" src="imagenes\detalle2.bmp" alt="Ver Planificacion" title="Ver Planificacion"
			onclick="Add_filtroX()">
		</div>
	</form>
	<script type="text/javascript">

		function Add_filtroX(){
			var errorMessage = '';

			var cliente = $("#cliente").val();
			var ubicacion = $("#ubicacion").val();
			var fecha_desde = $("#fecha_desde").val();
			var fecha_hasta = $("#fecha_hasta").val();

			
			if( fechaValida(fecha_desde) !=  true || fechaValida(fecha_hasta) != true){
				var errorMessage = ' Campos De Fecha Incorrectas ';
				var error      = error+1;
			}else{
				var fecha1 = moment(fecha_desde,"DD-MM-YYYY");
				var fecha2 = moment(fecha_hasta,"DD-MM-YYYY");

				if(fecha2.diff(fecha1, 'days')>31){
					var errorMessage = ' El rango de fechas no puede ser mayor a 31 dias ';
					var error      = error+1;
				}
			}

			if(cliente == 'TODOS'){
				var errorMessage = errorMessage + '\n  Debe Seleccionar un Cliente ';
				var error = error+1;
			}

			if(ubicacion == 'TODOS'){
				var errorMessage = errorMessage + '\n  Debe Seleccionar una Ubicacion ';
				var error = error+1;
			}

			var parametros = {"cliente":cliente,"ubicacion" : ubicacion,"fecha_desde":fecha_desde,"fecha_hasta":fecha_hasta};
			if(errorMessage == ''){
				$.ajax({
					data:  parametros,
					url:   'ajax_rp/Add_pl_serv_vs_planif.php',
					type:  'post',
					beforeSend: function(){
						$('#modalRP').show();
						$("#RP").html('<img src="imagenes/loading3.gif" border="null" class="imgLink" width="30px" height="30px"> Procesando...');
						$("#modal_titulo2").text("Planificacion Servicio");
						limpiarContenedor('modal_contenidoRP');
					},
					success:  function (response) {
						//$("#modal_contenidoRP").html(response);
						
						var resp = JSON.parse(response);
						if(typeof resp['servicio'] == 'undefined'){
							$("#RP" ).html('No Existe Planificacion!..');
						}else{
							rp_planif_trab_serv(resp,'modal_contenidoRP',()=>{});
							$("#RP" ).html('');
						}
					},
					error: function (xhr, ajaxOptions, thrownError) {
						alert(xhr.status);
						alert(thrownError);}
					});
			}else{
				alert(errorMessage);
			}
		}

		function rp_planif_serv_rp(tipo,id_tabla){
			$('#body_planif').val($('#'+id_tabla).html());
			$("#reporte_serv").val(tipo);
			$("#add_planif_serv_modal").submit();
		}
	</script>