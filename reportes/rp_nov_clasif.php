<?php 
$Nmenu   = 562; 
$mod     =  $_GET['mod'];
$titulo  = " REPORTE NOVEDADES CLASIFICACION ";
$archivo = "reportes/rp_nov_clasif_det.php?Nmenu=$Nmenu&mod=$mod";
require_once('autentificacion/aut_verifica_menu.php');
require_once('sql/sql_report.php');
$bd = new DataBase();
?> 
<script language="JavaScript" type="text/javascript">




function Add_filtroX(){  // CARGAR  ARCHIVO DE AJAX CON UN PARAMETRO //

	var novedades   = $( "#novedades").val(); 
	var clasif      = $( "#clasif").val(); 
	var tipo        = $( "#tipo").val(); 
	var check_list  = $( "#check_list").val(); 
	var valores     = $( "#valores").val(); 
	var status      = $( "#status").val(); 
	var Nmenu       = $( "#Nmenu").val(); 
	var mod         = $( "#mod").val(); 
	var archivo     = $( "#archivo").val(); 
	
	var error = 0; 
    var errorMessage = ' ';	
	if(error == 0){	  
	var contenido = "listar";
	  var parametros = {	
						"novedades": novedades,
						"clasif" : clasif,
						"tipo" : tipo,
						"check_list" : check_list,
						"valores":valores,
						"status":status,
						"Nmenu" : Nmenu, 
						"mod" : mod,
						"archivo": archivo
				};			
				$.ajax({
						data:  parametros,
						url:   'ajax_rp/Add_nov_clasif.php',
						type:  'post',
						beforeSend: function () {
							 $("#img_actualizar").remove();
							 $("#listar").html("<img src='imagenes/loading.gif' /> Procesando, espere por favor...");
							},											
						success:  function (response) {
								$("#listar").html(response);
								$("#cont_img").html("<img class='imgLink' id='img_actualizar' src='imagenes/actualizar.png' border='0'                               onclick='Add_filtroX()'>");					
						},
									
					error: function (xhr, ajaxOptions, thrownError) {
       				alert(xhr.status);
        			alert(thrownError);}		

				});
	 
		}else{
			alert(errorMessage);
		}
}


function Add_filtroX2(){  // CARGAR  ARCHIVO DE AJAX CON UN PARAMETRO //

	var Nmenu       = document.getElementById("Nmenu").value; 
	var mod         = document.getElementById("mod").value; 
	var archivo     = document.getElementById("archivo").value; 

	var novedades   = document.getElementById("novedades").value; 
	var clasif      = document.getElementById("clasif").value; 
	var tipo        = document.getElementById("tipo").value; 
	var check_list  = document.getElementById("check_list").value; 
	var valores     = document.getElementById("valores").value; 
	var status      = document.getElementById("status").value; 

	var error = 0; 
    var errorMessage = ' ';
	 
	if(error == 0){	 
		 
		var contenido = "listar";
 
		ajax=nuevoAjax();
			ajax.open("POST", "ajax_rp/Add_nov_clasif.php", true);
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
			ajax.send("Nmenu="+Nmenu+"&mod="+mod+"&archivo="+archivo+"&novedades="+novedades+"&clasif="+clasif+"&tipo="+tipo+           "&check_list="+check_list+"&valores="+valores+"&status="+status+"");	
	
	}else{
 		alert(errorMessage);
	}	
}
</script>	
<div align="center" class="etiqueta_title"><?php echo $titulo;?></div> 
<div id="Contenedor01"></div>
<form name="form_reportes" id="form_reportes" action="<?php echo $archivo;?>"  method="post" target="_blank">
	<hr /><table width="100%" class="etiqueta">
		<tr>
        <td width="10%">Novedades:</td>
		<td width="14%"><select name="novedades" id="novedades" style="width:120px;">
					            <option value="TODOS">TODOS</option> 
		<?php 
	   			$query01 = $bd->consultar($sql_novedad);		
		 		while($row01=$bd->obtener_fila($query01,0)){							   							
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';						   		
			   }?></select></td>
        <td width="10%">Check List: </td>
		<td width="14%"><select name="check_list" id="check_list" style="width:120px;" >
					<option value="TODOS">TODOS</option> 
					<option value="T">SI</option>
                    <option value="F">NO</option>						   		
				</select></td>               

        <td width="10%">Valores: </td>
		<td width="14%"><select name="valores" id="valores" style="width:120px;" >
                    <option value="F">NO</option>						   		
					<option value="T">SI</option>

				</select></td>
        <td>Status: </td>
		<td><select name="status" id="status" style="width:120px;" >
					<option value="TODOS">TODOS</option> 
					<option value="T">Activo</option>
                    <option value="F">Inactivo</option>						   		
				</select></td>  
      <td width="4%" id="cont_img"><img class="imgLink" src="imagenes/actualizar.png" border="0" onclick="Add_filtroX()"></td>  
        </tr>
        <tr> 
        <td>Clasificacion:</td>
		<td><select  name="clasif" id="clasif" style="width:120px;">
					<option value="TODOS">TODOS</option> 
					<?php 
	   			$query01 = $bd->consultar($sql_nov_clasif);		
		 		while($row01=$bd->obtener_fila($query01,0)){							   							
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';						   		
			   }?></select></td>
        <td>Tipo:</td>
		<td><select  name="tipo" id="tipo" style="width:120px;">
					<option value="TODOS">TODOS</option> 
					<?php 
	   			$query01 = $bd->consultar($sql_nov_tipo);		
		 		while($row01=$bd->obtener_fila($query01,0)){							   							
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';						   		
			   }?></select></td>
        
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