<link rel="stylesheet" type="text/css" href="latest/stylesheets/autocomplete.css" />
<script type="text/javascript" src="latest/scripts/autocomplete.js"></script>
<?php
$Nmenu   = 563;
$mod     =  $_GET['mod'];
$titulo  = " REPORTE NOVEDADES CHECK LIST RESUMEM ";
$archivo = "reportes/rp_nov_check_list_resum_det.php?Nmenu=$Nmenu&mod=$mod";
require_once('autentificacion/aut_verifica_menu.php');
require_once('sql/sql_report.php');
$bd = new DataBase();
?>
<script language="JavaScript" type="text/javascript">
function Add_filtroX(){  // CARGAR  ARCHIVO DE AJAX CON UN PARAMETRO //

	var Nmenu       = document.getElementById("Nmenu").value;
	var mod         = document.getElementById("mod").value;
	var archivo     = document.getElementById("archivo").value;

	var fecha_desde = document.getElementById("fecha_desde").value;
	var fecha_hasta = document.getElementById("fecha_hasta").value;

	var clasif      = document.getElementById("clasif").value;
	var tipo        = document.getElementById("tipo").value;
    var cliente     = document.getElementById("cliente").value;
    var ubicacion   = document.getElementById("ubicacion").value;
    var status      = document.getElementById("status").value;

	var trabajador  = document.getElementById("stdID").value;

	var error = 0;
    var errorMessage = ' ';
	 if( fechaValida(fecha_desde) !=  true || fechaValida(fecha_hasta) != true){
    var errorMessage = ' Campos De Fecha Incorrectas ';
	 var error = error+1;
	}
	if(error == 0){

		var contenido = "listar";

		ajax=nuevoAjax();
			ajax.open("POST", "ajax_rp/Add_nov_check_list.php", true);
			ajax.onreadystatechange=function(){
				if (ajax.readyState==1){
		        document.getElementById(contenido).innerHTML =  '<img src="imagenes/loading.gif" />';
				ajax.responseText;
				}
				if (ajax.readyState==4){
		        document.getElementById(contenido).innerHTML = ajax.responseText;
				}
			}
			ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			ajax.send("Nmenu="+Nmenu+"&mod="+mod+"&archivo="+archivo+"&clasif="+clasif+"&tipo="+tipo+"&cliente="+cliente+"&ubicacion="+ubicacion+"&status="+status+"&trabajador="+trabajador+"&fecha_desde="+fecha_desde+"&fecha_hasta="+fecha_hasta+"");

	}else{
 		alert(errorMessage);
	}
}
</script>
<div align="center" class="etiqueta_title"><?php echo $titulo;?></div>
<div id="Contenedor01"></div>
<form name="form_reportes" id="form_reportes" action="<?php echo $archivo;?>"  method="post" target="_blank">
	<hr /><table width="100%" class="etiqueta">
		<tr><td width="10%">Fecha Desde:</td>
		 <td width="14%" id="fecha01"><input type="text" name="fecha_desde" id="fecha_desde" size="9"  onclick="javascript:muestraCalendario('form_reportes', 'fecha_desde');">&nbsp;<img src="imagenes/icono-calendario.gif" onclick="javascript:muestraCalendario('form_reportes', 'fecha_desde');" border="0" width="17px"></td>
        <td width="10%">Fecha Hasta:</td>
		 <td width="14%" id="fecha02"><input type="text" name="fecha_hasta" id="fecha_hasta" size="9" onclick="javascript:muestraCalendario('form_reportes', 'fecha_hasta');">&nbsp;<img src="imagenes/icono-calendario.gif" onclick="javascript:muestraCalendario('form_reportes', 'fecha_hasta');" border="0" width="17px"></td>
        <td >Status: </td>
		<td ><select name="status" id="status" style="width:120px;" >
					<option value="TODOS">TODOS</option>
					<?php
	   			$query01 = $bd->consultar($sql_nov_status);
		 		while($row01=$bd->obtener_fila($query01,0)){
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
			   }?></select></td>
        <td width="24%"></td>
      <td width="4%" ><img class="imgLink" src="imagenes/actualizar.png" border="0" onclick="Add_filtroX()"></td>
        </tr>
        <tr>
			<td><?php echo $leng['cliente']?>:</td>
			<td><select name="cliente" id="cliente" style="width:120px;" onchange="Add_Cl_Ubic(this.value, 'contenido_ubic', 'T', '120')">
					    <option value="TODOS">TODOS</option>
					<?php
	   			$query01 = $bd->consultar($sql_cliente);
		 		while($row01=$bd->obtener_fila($query01,0)){
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
			   }?></select></td>
			<td><?php echo $leng['ubicacion']?>: </td>
			<td id="contenido_ubic"><select name="ubicacion" id="ubicacion" style="width:120px;">
					                        <option value="TODOS">TODOS</option>
                                    </select></td>
        <td>Clasificacion:</td>
		<td><select  name="clasif" id="clasif" style="width:120px;">
					<option value="TODOS">TODOS</option>
		<?php
	   			$query01 = $bd->consultar($sql_nov_clasif);
		 		while($row01=$bd->obtener_fila($query01,0)){
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
			   }?></select></td>
        <td>Tipo:</td>
		<td><select  name="tipo" id="tipo" style="width:120px;" >
					<option value="TODOS">TODOS</option>
		<?php
	   			$query01 = $bd->consultar($sql_nov_tipo);
		 		while($row01=$bd->obtener_fila($query01,0)){
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
			   }?></select></td>
       <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
		 <td>Filtro <?php echo $leng['trab']?>.:</td>
		<td id="select01">
			<select id="paciFiltro" onchange="EstadoFiltro(this.value)" style="width:120px">
				<option value="TODOS"> TODOS</option>
				<option value="codigo"><?php echo $leng['ficha']?></option>
				<option value="cedula"><?php echo $leng['ci']?></option>
				<option value="trabajador"><?php echo $leng['trabajador']?></option>
                <option value="nombres"> Nombre </option>
                <option value="apellidos"> Apellido </option>
		</select></td>

	  <td><?php echo $leng['trabajador']?>:</td>
      <td colspan="3"><input  id="stdName" type="text" style="width:300px" disabled="disabled" />
	      <input type="hidden" name="trabajador" id="stdID" value=""/></td>
    <td>&nbsp;</td>
            <td>&nbsp;<input type="hidden" name="Nmenu" id="Nmenu" value="<?php echo $Nmenu;?>" />
            <input type="hidden" name="mod" id="mod" value="<?php echo $mod;?>" />
            <input type="hidden" name="archivo" id="archivo" value="<?php echo $archivo;?>" /></td>

      </tr>
</table><hr /><div id="listar">&nbsp;</div>
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

	filtroId = document.getElementById("paciFiltro");
	filtroIndice = filtroId.selectedIndex;
	filtroValue  = filtroId.options[filtroIndice].value;

    new Autocomplete("stdName", function() {
        this.setValue = function(id) {
            document.getElementById("stdID").value = id; // document.getElementsByName("stdID")[0].value = id;
        }
        if (this.isModified) this.setValue("");
        if (this.value.length < 1) return ;
          return "autocompletar/tb/trabajador.php?q="+this.text.value +"&filtro="+filtroValue+""});
</script>
