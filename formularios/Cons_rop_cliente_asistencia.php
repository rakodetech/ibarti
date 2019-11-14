<?php 
	$Nmenu = '448'; 
	require_once('autentificacion/aut_verifica_menu.php');
	$bd = new DataBase();
	require_once('sql/sql_report_t.php');
	$archivo = "reportes/rp_op_	cliente_asistencia_det.php?Nmenu=$Nmenu&mod=$mod";
	$titulo = " REPORTE OPERACIONAL CLIENTE ASISTENCIA ";
?>
<script language="JavaScript" type="text/javascript">

function Add_filtroX(){  // CARGAR  ARCHIVO DE AJAX CON UN PARAMETRO//

	var fecha_desde = document.getElementById("fecha_desde").value; 
	var fecha_hasta = document.getElementById("fecha_hasta").value;
	var region      = document.getElementById("REGION").value; 
	var estado      = document.getElementById("ESTADO").value;						
	var cliente     = document.getElementById("CLIENTE").value;
	var horario     = document.getElementById("HORARIO").value;

	var error = 0; 
    var errorMessage = ' ';
	 if( fechaValida(fecha_desde) !=  true || fechaValida(fecha_hasta) != true){
    var errorMessage = ' Campos De Fecha Incorrectas ';
	 var error = error+1; 		 
	}
	
     if(cliente == '') {
	 var error = error+1; 
	  errorMessage = errorMessage + ' \n Debe Seleccionar un Cliente ';
	}  

 if(error == 0){

	var contenido = "listar";
	document.getElementById(contenido).innerHTML = '<img src="imagenes/loading.gif" />';
	document.getElementById("cont_img").innerHTML =
				  '<img src="imagenes/loading.gif" onclick="" class="imgLink" />';
	ajax=nuevoAjax();
			ajax.open("POST", "ajax_rp/Add_rop_planif_cl_vs_as_horario.php", true);
			ajax.onreadystatechange=function(){ 
				if (ajax.readyState==4){
		     	  document.getElementById(contenido).innerHTML = ajax.responseText;	
				   document.getElementById("cont_img").innerHTML = 
				  '<img class="imgLink" src="imagenes/actualizar.png" border="0" onclick="Add_filtroX()">';
				}
			} 
			ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			ajax.send("fecha_desde="+fecha_desde+"&fecha_hasta="+fecha_hasta+"&region="+region+"&estado="+estado+"&cliente="+cliente+"&horario="+horario+"");	
	
	}else{
		 	 alert(errorMessage);
	}	
}
</script>	
<div align="center" class="etiqueta_title"> CONSULTA <?php echo $titulo;?> </div>
<div id="Contenedor01"></div>
<form name="form_reportes" id="form_reportes" action="<?php echo $archivo;?>" method="post" target="_blank">
<hr /><table width="100%" class="etiqueta">
			<tr><td width="10%">Fecha Desde:</td>
		 <td width="14%" id="fecha01"><input type="text" name="fecha_desde" id="fecha_desde" style="width:100px" required onclick="javascript:muestraCalendario('form_reportes', 'fecha_desde');">&nbsp;<img src="imagenes/icono-calendario.gif" onclick="javascript:muestraCalendario('form_reportes', 'fecha_desde');" border="0" width="17px"></td>
        <td width="10%">Fecha Hasta:</td>   
		 <td width="14%" id="fecha02"><input type="text" name="fecha_hasta" id="fecha_hasta" style="width:100px" required onclick="javascript:muestraCalendario('form_reportes', 'fecha_hasta');">&nbsp;<img src="imagenes/icono-calendario.gif" onclick="javascript:muestraCalendario('form_reportes', 'fecha_hasta');" border="0" width="17px"></td>            
		<td width="10%">Region: </td>
        <td width="14%"><select name="region" id="REGION" style="width:150px;">
                <option value="TODOS">TODOS</option> 
                <?php 
			$query01 = $bd->consultar($sql_region);		
            while($row01=$bd->obtener_fila($query01,0)){							   							
                 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';						   		
           }?></select></td>
     <td width="10%">Tipo Reporte:</td>
     <td width="14%" id="select10" ><select name="reporte" style="width:150px;">	 
                   <option value="pdf">PDF</option>
                   <option value="excel">Excel</option>
           </select></td>    
      <td width="4%" id="cont_img"><img class="imgLink" src="imagenes/actualizar.png" border="0" onclick="Add_filtroX()"></td>  
        </tr>
        <tr> 

            <td>Estado: </td>
			<td><select name="estado" id="ESTADO" style="width:150px;">
					<option value="TODOS">TODOS</option>
					<?php 
	   			$query01 = $bd->consultar($sql_estado);		
		 		while($row01=$bd->obtener_fila($query01,0)){							   							
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';						   		
			   }?></select></td>
            <td>Cliente: </td>
			<td><select name="cliente" id="CLIENTE" style="width:150px;" required>					
					<?php 
	   			$query01 = $bd->consultar($sql_cliente);		
		 		while($row01=$bd->obtener_fila($query01,0)){							   							
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';						   		
			   }?></select></td>
			<td>&nbsp;</td>
      </tr>
        <tr> 
            <td>Horario: </td>
			<td><select name="horario" id="HORARIO" style="width:150px;">
					<option value="TODOS">TODOS</option>
					<?php 
	   			$query01 = $bd->consultar($sql_horario);		
		 		while($row01=$bd->obtener_fila($query01,0)){							   							
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';						   		
			   }?></select></td>
           	<td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
			<td>&nbsp;<input type="hidden" name="Nmenu" id="Nmenu" value="<?php echo $Nmenu;?>" />
            <input type="hidden" name="mod" id="mod" value="<?php echo $mod;?>" /></td>
      </tr>
</table><hr /><div id="listar"></div>
<div align="center"><br/>
        <span class="art-button-wrapper">
            <span class="art-button-l"> </span>
            <span class="art-button-r"> </span>
        <input type="button" name="salir" id="salir" value="Salir" onclick="Vinculo('inicio.php?area=formularios/index')" 
               class="readon art-button">
        </span>&nbsp; 
		<span class="art-button-wrapper">
            <span class="art-button-l"> </span>
            <span class="art-button-r"> </span>
            <input type="submit" name="procesar" id="procesar" value="Procesar" class="readon art-button">  
        </span>    
</div>
</form>
