<link rel="stylesheet" type="text/css" href="latest/stylesheets/autocomplete.css" />
<link rel="stylesheet" href="libs/control_fecha/fecha.css">
<script type="text/javascript" src="libs/control_fecha/fecha.js"></script>
<script type="text/javascript" src="latest/scripts/autocomplete.js"></script>
<?php
$Nmenu   = 474;
$mod     =  $_GET['mod'];
$titulo  = " REPORTE AUDITORIA FICHA ";
$archivo = "reportes/rp_audit_fic_det.php?Nmenu=$Nmenu&mod=$mod";
require_once('autentificacion/aut_verifica_menu.php');
require_once('sql/sql_report.php');
$bd = new DataBase();
?>
<script language="JavaScript" type="text/javascript">

function Add_filtroX(){  // CARGAR  ARCHIVO DE AJAX CON UN PARAMETRO //
	
	var ficha  = $('#stdID').val();
	var usuario  = $('#user').val();
	var accion  = $('#act').val();
	var fecha_desde  = $('#fec_d').val();
	var fecha_hasta  = $('#fec_h').val();
	var campo = $('#campo').val();
var error=0;
	
   

	if(error == 0){
	  var parametros = {
						"ficha":ficha,
						"user":usuario,
						"accion":accion,
						"fecha_desde" :fecha_desde,
						"fecha_hasta" : fecha_hasta,
						"campo":campo
				};
				$.ajax({
						data:  parametros,
						url:   'ajax_rp/Add_fic_audit.php',
						type:  'post',
						beforeSend: function () {
							 $("#img_actualizar").hide();
							 $("#listar").html("<img src='imagenes/loading.gif' /> Procesando, espere por favor...");
							},
						success:  function (response) {
								$("#listar").html(response);
								$("#img_actualizar").show();
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
<div align="center" class="etiqueta_title"><?php echo $titulo;?> </div>
<div id="Contenedor01"></div>
<form name="form_reportes" id="form_reportes" action="<?php echo $archivo;?>"  method="post" target="_blank">
<hr />
<table width="100%" class="etiqueta">
	<tr>
		<td width="5%">
			Fecha:
		</td>
		<td width="25%"><input style="width:100%;" type="button" value="Establecer Fecha" id="fec" onclick="crear_control(this.id,'fec_d','fec_h')">
			<input type="hidden" name="fecha_desde" id="fec_d">
			<input type="hidden" name="fecha_hasta" id="fec_h">
		</td>
		<td width="5%" >
			Usuarios:
		</td>
		<td width="20%">
			<select name="user" id="user" style="width:95%;margin-left: 5px;">
			<option value="">TODOS</option>
			<?php 
				$sql= "SELECT codigo,	CONCAT(nombre,' ',apellido)  FROM men_usuarios WHERE status='T' ORDER BY 2 ASC";
				$query = $bd->consultar($sql);
				while ($datos=$bd->obtener_fila($query,0)){
					echo "<option value='$datos[0]'>$datos[1]</option>";
				}
			?>
			</select>
		</td>
		<td width="5%">
			Accion:
		</td>
		<td width="20%">
			<select name="act" id="act" style="width:95%;margin-left: 5px;">
			<option value="">TODOS</option>
			<?php 
				$sql= "SELECT codigo,	descripcion  FROM acciones WHERE status='T' ORDER BY 2 ASC";
				$query = $bd->consultar($sql);
				while ($datos=$bd->obtener_fila($query,0)){
					echo "<option value='$datos[0]'>$datos[1]</option>";
				}
			?>
		</select>
		</td>
		<td width="5%" rowspan="3">
		<img class="imgLink" id="img_actualizar" src="imagenes/actualizar.png" border="0" onclick=" Add_filtroX()">
		</td>
		<td width="15%"></td>
	</tr>
	<tr><td colspan="9" height="5"></td></tr>
	<tr>
		<td>
		Trabajador:
		</td>
			
			<td colspan="2">
		<input id="stdName" type="text"  disabled="disabled" onclick="{$('#stdID').val('');$('#stdName').val('');}"  />
				<input type="hidden" name="trabajador" id="stdID" value="" />
		<select id="paciFiltro" onchange="EstadoFiltro(this.value)" style="width:120px">
					<option value=""> TODOS</option>
					<option value="codigo"> <?php echo $leng['ficha'] ?> </option>
					<option value="cedula"><?php echo $leng['ci'] ?> </option>
					<option value="trabajador"><?php echo $leng['trabajador'] ?> </option>
					<option value="nombres"> Nombre </option>
					<option value="apellidos"> Apellido </option>
				</select></td>
    <td colspan="3">
			Campos:
		<select name="campo" id="campo" style="width:150px;margin-left: 5px;">
			<option value="">TODOS</option>
			<?php 
				$sql= "SELECT campo  FROM audit_ficha_det GROUP BY campo ORDER BY 1 ASC";
				$query = $bd->consultar($sql);
				while ($datos=$bd->obtener_fila($query,0)){
					echo "<option value='$datos[0]'>$datos[0]</option>";
				}
			?>
		</select>

			&nbsp; <input type="hidden" name="Nmenu" id="Nmenu" value="<?php echo $Nmenu;?>" />
			<input type="hidden" name="mod" id="mod" value="<?php echo $mod;?>" />
		</td>            
  </tr>
</table>
<hr />
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
		
        
</div></form>
<script type="text/javascript">
	r_cliente = $("#r_cliente").val();
	r_rol     = $("#r_rol").val();
	usuario   = $("#usuario").val();
	filtroValue = $("#paciFiltro").val();

	new Autocomplete("stdName", function() {
		this.setValue = function(id) {
			document.getElementById("stdID").value = id; // document.getElementsByName("stdID")[0].value = id;
		}
		if (this.isModified) this.setValue("");
		if (this.value.length < 1) return;
		return "autocompletar/tb/trabajador.php?q=" + this.text.value + "&filtro=" + filtroValue + "&r_cliente=" + r_cliente + "&r_rol=" + r_rol + "&usuario=" + usuario + ""
	});
</script>
