<?php 
	$Nmenu = '450';
	require_once('autentificacion/aut_verifica_menu.php');
	require_once('sql/sql_report_t.php');
	$bd = new DataBase();
	$archivo = "pl_trabajador_dl";
	$titulo  = " PLANIFICACION DE CALENDARIO ";
	$vinculo = "../inicio.php?area=formularios/Cons_$archivo&Nmenu=".$_GET['Nmenu']."&mod=".$_GET['mod']."";

    $metodo  = "agregar";
	$proced  = "p_pl_trabajador_dl";
	$titulo  = " $titulo ";

	$cod_turno   = '';
	$turno       = ' Seleccione... ';
?>
<script language="JavaScript" type="text/javascript">

function Add_filtroX(){  // CARGAR  ARCHIVO DE AJAX CON UN PARAMETRO //

	var rol         = document.getElementById("rol").value;
	var region      = document.getElementById("region").value;
	var estado      = document.getElementById("estado").value;
    var contrato    = document.getElementById("contrato").value;
    var cargo       = document.getElementById("cargo").value;
    var	cliente     = document.getElementById("cliente").value;
    var	ubicacion   = document.getElementById("ubicacion").value;

	var usuario     = document.getElementById("usuario").value;

	var error = 0;
    var errorMessage = ' ';

     if(rol == '') {
	 var error = error+1;
	  errorMessage = errorMessage + ' \n Debe Seleccionar Un Rol ';
	}
	 if(error == 0){

		var contenido = "listar";
		ajax=nuevoAjax();
			ajax.open("POST", "ajax/Add_pl_trabajador_dl.php", true);
			ajax.onreadystatechange=function(){
				if (ajax.readyState==4){
		        document.getElementById(contenido).innerHTML = ajax.responseText;
				}
			}
			ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			ajax.send("&rol="+rol+"&region="+region+"&estado="+estado+"&contrato="+contrato+"&cargo="+cargo+"&cliente="+cliente+"&ubicacion="+ubicacion+"&usuario="+usuario+"");

	}else{
		 alert(errorMessage);
	}
}

function Add_cliente(codigo, ficha, archivo, contenido){
	 if(codigo!=''){
		ajax=nuevoAjax();
			ajax.open("POST", archivo, true);
			ajax.onreadystatechange=function()
			{
				if (ajax.readyState==4){
		        document.getElementById(contenido).innerHTML = ajax.responseText;
				}
			}
			ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			ajax.send("cliente="+codigo+"&ficha="+ficha+"");
	}else{
		 	alert("Debe de Seleccionar Un Campo ");
	 }
}
</script>

<?php
function ultimoDia($mes,$ano){
 $ultimo_dia=28;
 while (checkdate($mes,$ultimo_dia + 1,$ano)){
 $ultimo_dia++;
 }
 return $ultimo_dia;
}

function calendar_html(){
 $meses= array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
 //$fecha_fin=date('d-m-Y',time());
 $mes=date('m',time());
 $anio=date('Y',time());
 ?>
 <table style="width:200px;text-align:center;border:1px solid #808080;border-bottom:0px;" cellpadding="0" cellspacing="0">
 <tr>
 <td colspan="4">
 <select id="calendar_mes" onchange="update_calendar()">
 <?php
 $mes_numero=1;
 while($mes_numero<=12){
 if($mes_numero==$mes){
 echo "<option value=".$mes_numero." selected=\"selected\">".$meses[$mes_numero-1]."</option> \n";
 }else{
 echo "<option value=".$mes_numero.">".$meses[$mes_numero-1]."</option> \n";
 }
 $mes_numero++;
 }
 ?>
 </select>
 </td>
 <td colspan="3">
 <select style="width:70px;" id="calendar_anio" onchange="update_calendar()">
 <?php
 // años a mostrar
 $anio_min=$anio-30; //hace 30 años
 $anio_max=$anio; //año actual
 while($anio_min<=$anio_max){
 echo "<option value=".$anio_min.">".$anio_min."</option> \n";
 $anio_min++;
 }
 ?>
 </select>
 </td>
 </tr>
 </table>
 <div id="calendario_dias">
 <?php calendar($mes,$anio) ?>
 </div>
 <?php
}

function calendar($mes,$anio){
 $dia=1;
 if(strlen($mes)==1) $mes='0'.$mes;
 ?>
 <table style="width:200px;text-align:center;border:1px solid #808080;border-top:0px;" cellpadding="0" cellspacing="0">
 <tr style="background-color:#CCCCCC;">
 <td>D</td>
 <td>L</td>
 <td>M</td>
 <td>M</td>
 <td>J</td>
 <td>V</td>
 <td>S</td>
 </tr>
 <?php

 //echo $mes.$dia.$anio;
 $numero_primer_dia = date('w', mktime(0,0,0,$mes,$dia,$anio));
 $ultimo_dia=ultimoDia($mes,$anio);

 $total_dias=$numero_primer_dia+$ultimo_dia;

 $diames=1;
 //$j dias totales (dias que empieza a contarse el 1º + los dias del mes)
 $j=1;
 while($j<$total_dias){
 echo "<tr> \n";
 //$i contador dias por semana
 $i=0;
 while($i<7){
 if($j<=$numero_primer_dia){
 echo " <td></td> \n";
 }elseif($diames>$ultimo_dia){
 echo " <td></td> \n";
 }else{
 if($diames<10) $diames_con_cero='0'.$diames;
 else $diames_con_cero=$diames;

 echo " <td><a style=\"display:block;cursor:pointer;\" onclick=\"set_date('".$anio."-".$mes."-".$diames_con_cero."')\">".$diames."</a></td> \n";
 $diames++;
 }
 $i++;
 $j++;
 }
 echo "</tr> \n";
 }
 ?>
 </table>
 <?php
}
?>


<div align="center" class="etiqueta_title"><?php echo $titulo;?> </div>
<div id="Contenedor01"></div>
<form name="form_reportes" id="form_reportes" action="scripts/sc_<?php echo $archivo;?>.php" method="post" target="_self">
<fieldset>
<legend>Filtros:</legend>
	<table width="100%">
       <tr>
		 <td width="10%">Rol: </td>
		<td width="14%" id="select01"><select name="rol" id="rol" style="width:120px;">
					<option value="">Seleccione...</option>
					<?php
				$sql01 = "SELECT roles.codigo, roles.descripcion
                            FROM usuario_roles , roles
                           WHERE usuario_roles.cod_usuario = '$usuario'
						     AND usuario_roles.cod_rol =   roles.codigo
						     AND roles.`status` = 'T'
						ORDER BY 2 ASC";
	   			$query01 = $bd->consultar($sql01);
		 		while($row01=$bd->obtener_fila($query01,0)){
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
			   }?></select></td>

		 <td width="10%">Region: </td>
		 <td width="14%"><select name="region" id="region" style="width:120px;">
					<option value="TODOS">TODOS</option>
					<?php
	   			$query01 = $bd->consultar($sql_region);
		 		while($row01=$bd->obtener_fila($query01,0)){
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
			   }?></select></td>
            <td width="10%">Estado: </td>
			<td width="14%"><select name="estado" id="estado" style="width:120px;">
					<option value="TODOS">TODOS</option>
					<?php
	   			$query01 = $bd->consultar($sql_estado);
		 		while($row01=$bd->obtener_fila($query01,0)){
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
			   }?></select></td>
		 <td width="10%">Contrato: </td>
			<td width="14%"><select name="contrato" id="contrato" style="width:120px;">
					<option value="TODOS">TODOS</option>
					<?php
	   			$query01 = $bd->consultar($sql_contrato);
		 		while($row01=$bd->obtener_fila($query01,0)){
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
			   }?></select></td>
           <td width="4%"><img class="imgLink" src="imagenes/actualizar.png" border="0" onclick="Add_filtroX()"></td>
      </tr>
        <tr>
		 <td>Cargo: </td>
			<td><select name="cargo" id="cargo" style="width:120px;">
					<option value="TODOS">TODOS</option>
					<?php
				$query01 = $bd->consultar($sql_cargo);
		 		while($row01=$bd->obtener_fila($query01,0)){
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
			   }?></select></td>
		 <td>Cliente:</td>
			<td><select name="cliente" id="cliente" style="width:120px;" onchange="Add_Cl_Ubic(this.value, 'contenido_ubic', 'T', '120')">
					    <option value="TODOS">TODOS</option>
					<?php
	   			$query01 = $bd->consultar($sql_cliente);
		 		while($row01=$bd->obtener_fila($query01,0)){
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
			   }?></select></td>
			<td>Ubicacion: </td>
			<td id="contenido_ubic"><select name="ubicacion" id="ubicacion" style="width:120px;">
					                        <option value="TODOS">TODOS</option>
                                    </select></td>
           <td>&nbsp;
            <input type="hidden" name="codigo" id="codigo" value="<?php echo $codigo;?>" />
            <input type="hidden" name="Nmenu" id="Nmenu" value="<?php echo $Nmenu;?>" />
            <input type="hidden" name="mod" id="mod" value="<?php echo $mod;?>" />
            <input type="hidden" name="metodo" id="metodo" value="<?php echo $metodo;?>" />
            <input type="hidden" name="proced" id="proced" value="<?php echo $proced;?>" />
            <input type="hidden" name="usuario" id="usuario" value="<?php echo $usuario;?>" />
            <input type="hidden" name="href" id="href" value="<?php echo $vinculo;?>"/></td>
      </tr>
</table>
</fieldset>
<div id="listar">&nbsp;</div>
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
<script language="javascript">
var select01 = new Spry.Widget.ValidationSelect("select01", {validateOn:["blur", "change"]});
</script>
