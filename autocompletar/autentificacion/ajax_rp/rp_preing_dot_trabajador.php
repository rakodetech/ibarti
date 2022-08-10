<link rel="stylesheet" type="text/css" href="latest/stylesheets/autocomplete.css" />
<script type="text/javascript" src="latest/scripts/autocomplete.js"></script>
<?php
$Nmenu   = 580;
$mod     =  $_GET['mod'];
$titulo  = " REPORTE REFERENCIA PREINGRESO UNIFOFRME ";
$archivo = "reportes/rp_preing_dot_trabajador_det.php?Nmenu=$Nmenu&mod=$mod";
require_once('autentificacion/aut_verifica_menu.php');
require_once('sql/sql_report.php');
$bd = new DataBase();
?>
<script language="JavaScript" type="text/javascript">

function Add_filtroX(){  // CARGAR  ARCHIVO DE AJAX CON UN PARAMETRO //
	var fecha_desde = $("#fecha_desde").val();
	var fecha_hasta = $("#fecha_hasta").val();

	var status      = $("#status").val();
	var estado      = $("#estado").val();
	var ciudad      = $("#ciudad").val();
	var cargo       = $("#cargo").val();
	var trabajador  = document.getElementById("stdID").value;

	var error = 0;
	var errorMessage = ' ';

	if( fechaValida(fecha_desde) !=  true || fechaValida(fecha_hasta) != true){
		var errorMessage = errorMessage + ' Campos De Fecha Incorrectas \n ';
		var error = error+1;
	}

	if(error == 0){
		var contenido = "listar";

		ajax=nuevoAjax();
		ajax.open("POST", "ajax_rp/Add_preing_dot_trabajador.php", true);
		ajax.onreadystatechange=function(){
			if (ajax.readyState==1 || ajax.readyState==2 || ajax.readyState==3){
				document.getElementById(contenido).innerHTML = '<img src="imagenes/loading.gif" />';
				document.getElementById("cont_img").innerHTML =
				'<img src="imagenes/loading.gif" onclick="" class="imgLink" />';
			}
			if (ajax.readyState==4){
				document.getElementById(contenido).innerHTML = ajax.responseText;
				document.getElementById("cont_img").innerHTML =
				'<img class="imgLink" src="imagenes/actualizar.png" border="0" onclick="Add_filtroX()">';
			}
		}
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		ajax.send("fecha_desde="+fecha_desde+"&fecha_hasta="+fecha_hasta+"&estado="+estado+"&ciudad="+ciudad+"&cargo="+cargo+"&trabajador="+trabajador+"&status="+status+"");

	}else{
		alert(errorMessage);
	}
}
</script>

<div align="center" class="etiqueta_title"><?php echo $titulo;?> </div>
<div id="Contenedor01"></div>
<form name="form_reportes" id="form_reportes" action="<?php echo $archivo;?>"  method="post" target="_blank" enctype="multipart/form-data">
	<hr /><table width="100%" class="etiqueta">
		<tr><td width="5%">Fecha Desde:</td>
			<td width="14%" id="fecha01"><input type="text" name="fecha_desde" id="fecha_desde" size="9" required onclick="javascript:muestraCalendario('form_reportes', 'fecha_desde');">&nbsp;<img src="imagenes/icono-calendario.gif" onclick="javascript:muestraCalendario('form_reportes', 'fecha_desde');" border="0" width="17px"></td>
			<td width="10%">Fecha Hasta:</td>
			<td width="14%" id="fecha02"><input type="text" name="fecha_hasta" id="fecha_hasta" size="9" required onclick="javascript:muestraCalendario('form_reportes', 'fecha_hasta');">&nbsp;<img src="imagenes/icono-calendario.gif" onclick="javascript:muestraCalendario('form_reportes', 'fecha_hasta');" border="0" width="17px"></td>

			<td width="10%">Status : </td>
			<td width="14%"><select name="status" id="status" style="width:120px;">
				<option value="TODOS">TODOS</option>
				<?php
				$query01 = $bd->consultar($sql_preing_status);
				while($row01=$bd->obtener_fila($query01,0)){
					echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
				}?></select></td>

				<td width="10%"><?php echo $leng['estado']?>:</td>
				<td width="14%"><select name="estado" id="estado" style="width:120px;">
					<option value="TODOS">TODOS</option>
					<?php
					$query01 = $bd->consultar($sql_estado);
					while($row01=$bd->obtener_fila($query01,0)){
						echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
					}?></select></td>
					<td width="4%" id="cont_img"><img class="imgLink" src="imagenes/actualizar.png" border="0" onclick="Add_filtroX()"></td>

				</tr>
				<tr>
					<td width="10%"><?php echo $leng['ciudad']?>:</td>
					<td width="14%"><select name="ciudad" id="ciudad" style="width:120px;">
						<option value="TODOS">TODOS</option>
						<?php
						$query01 = $bd->consultar($sql_ciudad);
						while($row01=$bd->obtener_fila($query01,0)){
							echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
						}?></select></td>
						<td width="10%">Cargo: </td>
						<td width="14%"><select name="cargo" id="cargo" style="width:120px;">
							<option value="TODOS">TODOS</option>
							<?php
							$query01 = $bd->consultar($sql_cargo);
							while($row01=$bd->obtener_fila($query01,0)){
								echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
							}?></select></td>
							<td>Filtro <?php echo $leng['trab']?>.:</td>
							<td id="select01">
								<select id="paciFiltro" onchange="EstadoFiltro(this.value)" style="width:120px">
									<option value="TODOS"> TODOS</option>
									<option value="cedula"><?php echo $leng['ci']?> </option>
									<option value="trabajador"><?php echo $leng['trabajador']?></option>
									<option value="nombres"> Nombre </option>
									<option value="apellidos"> Apellido </option>
								</select></td>
								<td><?php echo $leng['trabajador']?>:</td>
								<td colspan="2"><input  id="stdName" type="text" style="width:160px" disabled="disabled" />
									<input type="hidden" name="trabajador" id="stdID" value=""/>&nbsp; <input type="hidden" name="Nmenu" id="Nmenu" value="<?php echo $Nmenu;?>" />
									<input type="hidden" name="mod" id="mod" value="<?php echo $mod;?>" />
									<input type="hidden" name="usuario" id="usuario" value="<?php echo $_SESSION['usuario_cod'];?>"/>   </td>
								</tr>
							</table><hr />
							<div id="listar">&nbsp;</div>
							<div align="center"><br/>
								<span class="art-button-wrapper">
									<span class="art-button-l"> </span>
									<span class="art-button-r"> </span>
									<input type="button" name="salir" id="salir" value="Salir" onclick="Vinculo('inicio.php?area=formularios/index')"
									class="readon art-button">
								</span>&nbsp;

								<input type="submit" name="procesar" id="procesar" hidden="hidden">
								<input type="text" name="reporte" id="reporte" hidden="hidden">

								<img class="imgLink" id="img_pdf" src="imagenes/pdf.gif" border="0"
								onclick="{$('#reporte').val('pdf');$('#procesar').click();}" width="25px" title="imprimir a pdf">

								<img class="imgLink" id="img_excel" src="imagenes/excel.gif" border="0"
								onclick="{$('#reporte').val('excel');$('#procesar').click();}" width="25px" title="imprimir a excel">
							</div>
						</form>
						<script type="text/javascript">
							usuario   = $("#usuario").val();
							filtroValue = $("#paciFiltro").val();

							new Autocomplete("stdName", function() {
								this.setValue = function(id) {
            document.getElementById("stdID").value = id; // document.getElementsByName("stdID")[0].value = id;
        }
        if (this.isModified) this.setValue("");
        if (this.value.length < 1) return ;
        return "autocompletar/tb/ingreso.php?q="+this.text.value +"&filtro="+filtroValue+"&usuario="+usuario+""});
    </script>
