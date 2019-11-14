<link rel="stylesheet" type="text/css" href="latest/stylesheets/autocomplete.css" />
<script type="text/javascript" src="latest/scripts/autocomplete.js"></script>
<?php
$Nmenu   = 537;
$mod     =  $_GET['mod'];
$titulo  = " Reporte ".$leng['trabajador']." Huella ";
$archivo = "reportes/rp_trab_sin_huella_det.php?Nmenu=$Nmenu&mod=$mod";
require_once('autentificacion/aut_verifica_menu.php');
require_once('sql/sql_report.php');
$bd = new DataBase();
?>
<script language="JavaScript" type="text/javascript">
function Add_filtroX(){  // CARGAR  ARCHIVO DE AJAX CON UN PARAMETRO //
	var rol         = document.getElementById("rol").value;
	var contrato    = document.getElementById("contrato").value;
	var estado      = document.getElementById("estado").value;
	var ciudad      = document.getElementById("ciudad").value;
	var huellas     = document.getElementById("huellas").value;
	var trabajador  = document.getElementById("stdID").value;


	var error = 0;
    var errorMessage = ' ';
     if(rol == '') {
	 var error = error+1;
	  errorMessage = errorMessage + ' \n Debe Seleccionar un Rol ';
	}

	if(error == 0){
		var contenido = "listar";

		ajax=nuevoAjax();
			ajax.open("POST", "ajax_rp/Add_trab_sin_huella.php", true);
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
			ajax.send("rol="+rol+"&contrato="+contrato+"&estado="+estado+"&ciudad="+ciudad+"&huellas="+huellas+"&trabajador="+trabajador+"");

	}else{
 		alert(errorMessage);
	}
}
</script>
<div align="center" class="etiqueta_title"><?php echo $titulo;?> </div>
<div id="Contenedor01"></div>
<form name="form_reportes" id="form_reportes" action="<?php echo $archivo;?>"  method="post" target="_blank" enctype="multipart/form-data">
<hr /><table width="100%" class="etiqueta">
		<tr><td width="10%">Rol:</td>
		 <td width="14%"><select name="rol" id="rol" style="width:120px;" required>
		<?php
				echo $select_rol;
				$query01 = $bd->consultar($sql_rol);
		 		     while($row01=$bd->obtener_fila($query01,0)){
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
			   }?></select></td>
         <td width="10%"><?php echo $leng['estado']?>:</td>
		 <td width="14%"><select name="estado" id="estado" style="width:120px;">
	                 			 <option value="TODOS">TODOS</option>
		<?php $query01 = $bd->consultar($sql_estado);
		 		     while($row01=$bd->obtener_fila($query01,0)){
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
			   }?></select></td>
        <td width="10%"><?php echo $leng['ciudad']?>:</td>
		 <td width="14%"><select name="ciudad" id="ciudad" style="width:120px;">
					<option value="TODOS">TODOS</option>
					<?php
	   			$query01 = $bd->consultar($sql_ciudad);
		 		while($row01=$bd->obtener_fila($query01,0)){
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
			   }?></select></td>
        
        <td><?php echo $leng['contrato']?>: </td>
		 <td><select name="contrato" id="contrato" style="width:120px;">
					<option value="TODOS">TODOS</option>
					<?php
		   			$query01 = $bd->consultar($sql_contrato);
		 		while($row01=$bd->obtener_fila($query01,0)){
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
			   }?></select></td>

      <td width="4%" id="cont_img"><img class="imgLink" src="imagenes/actualizar.png" border="0" onclick="Add_filtroX()"></td>
        </tr>
	<tr>
    	

    	<td>Huellas: </td>
		 <td><select name="huellas" id="huellas" style="width:120px;">
					<option value="TODOS">TODOS</option>
                    <option value="SI">SI</option>
                    <option value="NO">NO</option>
					</select></td>
             <td>Filtro <?php echo $leng['trab']?>.:</td>
		<td id="select01">
			<select id="paciFiltro" onchange="EstadoFiltro(this.value)" style="width:120px">
				<option value="TODOS"> TODOS</option>
				<option value="cedula"><?php echo $leng['ci']?></option>
				<option value="trabajador"><?php echo $leng['trabajador']?></option>
                <option value="nombres"> Nombre </option>
                <option value="apellidos"> Apellido </option>
		</select></td>
		<td><?php echo $leng['trabajador']?>:</td>
		<td colspan="2"><input  id="stdName" type="text" style="width:200px" disabled="disabled" />
         <input type="hidden" name="trabajador" id="stdID" value=""/>
          <input type="hidden" name="Nmenu" id="Nmenu" value="<?php echo $Nmenu;?>" />
          <input type="hidden" name="mod" id="mod" value="<?php echo $mod;?>" /></td>
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
          return "autocompletar/tb/ficha.php?q="+this.text.value +"&filtro="+filtroValue+""});
</script>
