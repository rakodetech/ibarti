<?php 
	$Nmenu = '404'; 
	require_once('autentificacion/aut_verifica_menu.php');
	require_once('sql/sql_report_t.php');	
	$tabla = "asistencia_semaforo";
	$bd = new DataBase();
	$archivo = "asistencia_semaforo";
	$titulo = " PLANIFICACION DE TRABAJADORES ";
	$vinculo = "inicio.php?area=pestanas/Add_$archivo&Nmenu=".$_GET['Nmenu']."&mod=".$_GET['mod']."&titulo=$titulo&tb=$tabla&archivo=$archivo";
	
	if (isset($_GET['cod_status'])){
	    	$cod_status = $_GET['cod_status'];
	$sql01 = "SELECT preing_status.codigo AS cod_status, preing_status.descripcion AS status
               FROM preing_status
              WHERE preing_status.codigo = '$cod_status'";

	}else{
	$sql01 = "SELECT preing_status.codigo AS cod_status, preing_status.descripcion AS status
               FROM control , preing_status
              WHERE control.preingreso_nuevo = preing_status.codigo";		
	}	
	$query01 = $bd->consultar($sql01);		
    $row02   = $bd->obtener_fila($query01,0);
	$cod_status = $row02[0]; 
    $status     = $row02[1];

?>
<script language="JavaScript" type="text/javascript">

function Add_filtroX(){  // CARGAR  ARCHIVO DE AJAX CON UN PARAMETRO //

	var fecha_desde = document.getElementById("fecha_desde").value; 
	var fecha_hasta = document.getElementById("fecha_hasta").value; 
	var rol         = document.getElementById("rol").value; 
	var region      = document.getElementById("region").value; 
	var estado      = document.getElementById("estado").value; 
	var contrato    = document.getElementById("contrato").value; 
	var cargo       = document.getElementById("cargo").value; 		
    var cliente     = document.getElementById("cliente").value; 			

	 if((fecha_desde != null)||(fecha_hasta != null)){
		 
		var contenido = "listar";
 
		ajax=nuevoAjax();
			ajax.open("POST", "ajax/Add_pl_planificacion.php", true);
			ajax.onreadystatechange=function(){ 
				if (ajax.readyState==4){
		        document.getElementById(contenido).innerHTML = ajax.responseText;					
				}
			} 
			ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			ajax.send("rol="+rol+"&region="+region+"&estado="+estado+"&contrato="+contrato+"&cargo="+cargo+"&cliente="+cliente+"&fecha_desde="+fecha_desde+"&fecha_hasta="+fecha_hasta+"");	
	
	}else{
		 	alert("Debe de Seleccionar Un Campo o Fecha");
	}	
}
</script>	
<div align="center" class="etiqueta_title"> CONSULTA  <?php echo $titulo;?> </div> 
<div id="Contenedor01"></div>
<form name="form_reportes" id="form_reportes" action="<?php echo $archivo;?>" method="post" target="_blank">
<fieldset>
<legend>Filtros:</legend>
	<table width="98%">

		<tr><td width="14%">Fecha Desde:</td>
		 <td width="20%" id="fecha01"><input type="text" name="fecha_desde" id="fecha_desde" size="12"
                              value="" onkeyup=""/></td>
        <td width="13%">Fecha Hasta:</td>   
		 <td width="20%" id="fecha02"><input type="text" name="fecha_hasta" id="fecha_hasta" size="12"
                              value="" onkeyup=""/></td>            
         <td width="13%">&nbsp; </td>
		 <td width="20%">&nbsp;</td>    
         <td>&nbsp;</td>       
        </tr>
        <tr> 
		<td>Rol: </td>
			<td><select name="rol" id="rol" style="width:150px;">
					<option value="TODOS">TODOS</option> 
					<?php 
	   			$query01 = $bd->consultar($sql_rol);		
		 		while($row01=$bd->obtener_fila($query01,0)){							   							
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';						   		
			   }?></select></td>
            <td>Region: </td>
			<td><select name="region" id="region" style="width:150px;">
					<option value="TODOS">TODOS</option> 
					<?php 
	   			$query01 = $bd->consultar($sql_region);		
		 		while($row01=$bd->obtener_fila($query01,0)){							   							
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';						   		
			   }?></select></td>
            <td>Estado: </td>
			<td><select name="estado" id="estado" style="width:150px;">
					<option value="TODOS">TODOS</option> 
					<?php 
	   			$query01 = $bd->consultar($sql_estado);		
		 		while($row01=$bd->obtener_fila($query01,0)){							   							
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';						   		
			   }?></select></td>

			<td>&nbsp;</td>
      </tr>
        <tr> 
		<td>Contrato: </td>
			<td><select name="contracto" id="contrato" style="width:150px;">
					<option value="TODOS">TODOS</option> 
					<?php 
				$query01 = $bd->consultar($sql_contrato);		
		 		while($row01=$bd->obtener_fila($query01,0)){							   							
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';						   		
			   }?></select></td>
            <td>Cargo: </td>
			<td><select name="cargo" id="cargo" style="width:150px;">
					<option value="TODOS">TODOS</option> 
					<?php 
	   			$query01 = $bd->consultar($sql_cargo);		
		 		while($row01=$bd->obtener_fila($query01,0)){							   							
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';						   		
			   }?></select></td>
            <td>Cliente:</td>
			<td><select name="cliente" id="cliente" style="width:150px;">
					<option value="TODOS">TODOS</option> 
					<?php 
	   			$query01 = $bd->consultar($sql_cliente);		
		 		while($row01=$bd->obtener_fila($query01,0)){							   							
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';						   		
			   }?></select></td>
			<td>&nbsp; 
            <input type="hidden" name="Nmenu" id="Nmenu" value="<?php echo $Nmenu;?>" />
            <input type="hidden" name="mod" id="mod" value="<?php echo $mod;?>" />
            <input type="hidden" name="filtro" id="filtro" value="" />
            <input type="hidden" name="filtro_value" id="filtro_value" value="" />
            <input type="hidden" name="fecha_clasif" id="fecha_clasif" value="" />
             </td>
      </tr>
</table>
</fieldset>
<fieldset>
<legend>Aplicar:</legend>
	<table width="98%">
		<tr><td width="14%">Turno:</td>
		 <td width="20%" id="select01"><select name="TURNO" id="TURNO" style="width:150px;" onchange="Add_filtroX()">
				   	<option value="">Seleccione...</option> 
					<?php 
				$sql01 = "SELECT turno.codigo, turno.descripcion FROM turno 
				           WHERE turno.`status` = 'T' ORDER BY 2 ASC";
	   			$query01 = $bd->consultar($sql01);		
		 		while($row01=$bd->obtener_fila($query01,0)){							   							
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';						   		
			   }?></select></td>
        <td width="13%">&nbsp;</td>   
		 <td width="20%" id="select02">&nbsp;</td>            
         <td width="13%">&nbsp; </td>
		 <td width="20%" id="fecha03">&nbsp;</td>           
        </tr>
</table>
</fieldset>
</form>
<div id="listar">&nbsp;</div>
<script language="javascript">
var fecha01 = new Spry.Widget.ValidationTextField("fecha01", "date", {format:"dd-mm-yyyy", hint:"DD-MM-AAAA", validateOn:["blur", "change"], useCharacterMasking:true, isRequired:true});
var fecha02 = new Spry.Widget.ValidationTextField("fecha02", "date", {format:"dd-mm-yyyy", hint:"DD-MM-AAAA", validateOn:["blur", "change"], useCharacterMasking:true, isRequired:true});

var select01 = new Spry.Widget.ValidationSelect("select01", {validateOn:["blur", "change"]});
var select02 = new Spry.Widget.ValidationSelect("select02", {validateOn:["blur", "change"]});
</script>