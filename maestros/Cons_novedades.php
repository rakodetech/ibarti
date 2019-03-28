<?php 
	$Nmenu = '344'; 
	require_once('autentificacion/aut_verifica_menu.php');
	require_once('sql/sql_report.php');
	$bd = new DataBase();
	$archivo = "novedades";
	$titulo = "  NOVEDADES ";
	$vinculo = "inicio.php?area=maestros/Add_$archivo&Nmenu=".$_GET['Nmenu']."&mod=".$_GET['mod']."&titulo=$titulo&archivo=$archivo";
?>
<script language="JavaScript" type="text/javascript">
function Add_filtroX(){  // CARGAR  ARCHIVO DE AJAX CON UN PARAMETRO //

	var Nmenu       = document.getElementById("Nmenu").value; 
	var mod         = document.getElementById("mod").value; 
	var archivo     = document.getElementById("archivo").value; 

	var novedades   = document.getElementById("novedades").value; 
	var clasif      = document.getElementById("clasif").value; 
	var tipo        = document.getElementById("tipo").value; 
	var check_list  = document.getElementById("check_list").value; 

	var error = 0; 
    var errorMessage = ' ';
	 
	if(error == 0){	 
		 
		var contenido = "listar";
 
		ajax=nuevoAjax();
			ajax.open("POST", "ajax/Add_novedades_m.php", true);
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
			ajax.send("Nmenu="+Nmenu+"&mod="+mod+"&archivo="+archivo+"&novedades="+novedades+"&clasif="+clasif+"&tipo="+tipo+"&check_list="+check_list+"");	
	
	}else{
 		alert(errorMessage);
	}	
}

function llenar_nov_tipo(clasificacion){
	
	var parametros = { 'clasificacion':clasificacion,'inicial':'TODOS'};
		$.ajax({
		data:  parametros,
		url:   'ajax/Add_novedades_tipo.php',
		type:  'post',
		success:  function (response) {
			$('#tipo').html(response);
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);}
			});
	}

</script>	
<div align="center" class="etiqueta_title"> CONSULTA <?php echo $titulo;?> </div> <hr />
<div id="Contenedor01"></div>
<form name="form_reportes" id="form_reportes" action="reportes/rp_cons_novedades_det.php"  method="post" target="_blank">
	<hr /><table width="100%" class="etiqueta">
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

        <td width="10%">Clasificacion:</td>
		<td width="14%"><select  name="clasif" id="clasif" style="width:120px;" onchange="llenar_nov_tipo(this.value)">
					<option value="TODOS">TODOS</option> 
					<?php 
	   			$query01 = $bd->consultar($sql_nov_clasif);		
		 		while($row01=$bd->obtener_fila($query01,0)){							   							
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';						   		
			   }?></select></td>   

        <td width="10%">Tipo:</td>
		<td width="14%"><select  name="tipo" id="tipo" style="width:120px;">
					<option value="TODOS">TODOS</option> 
					<?php 
	   			$query01 = $bd->consultar($sql_nov_tipo);		
		 		while($row01=$bd->obtener_fila($query01,0)){							   							
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';						   		
			   }?></select></td>
                 <td width="4%" ><img class="imgLink" src="imagenes/actualizar.png" border="0" onclick="Add_filtroX()">&nbsp;<input type="hidden" name="Nmenu" id="Nmenu" value="<?php echo $Nmenu;?>" />
            <input type="hidden" name="mod" id="mod" value="<?php echo $mod;?>" />
            <input type="hidden" name="archivo" id="archivo" value="<?php echo $archivo;?>" /></td>      
      
      </tr>       
</table><hr />
<div id="listar"><table width="100%" align="center">  	
   <tr class="fondo00">
			<th width="8%" class="etiqueta">codigo</th>
			<th width="18%" class="etiqueta">Clasificacion</th>
       		<th width="18%" class="etiqueta">Tipo</th>
            <th width="25%" class="etiqueta">Novedad</th>
            <th width="8%" class="etiqueta">Orden</th>
            <th width="8%" class="etiqueta">Status</th>
            <th width="7%" align="center"><a href="<?php echo $vinculo."&codigo=''&metodo=agregar";?>"><img src="imagenes/nuevo.bmp" alt="Agregar" title="Agregar Registro" width="30px" height="30px" border="null"/></a></th> 
	   </tr></table></div>

	   <input type="submit" name="procesar" id="procesar" hidden="hidden">
        <input type="text" name="reporte" id="reporte" hidden="hidden">
</form>
<img class="imgLink" id="img_excel" src="imagenes/excel.gif" border="0"
		onclick="{$('#reporte').val('excel');$('#procesar').click();}" width="25px" title="imprimir a excel"> 