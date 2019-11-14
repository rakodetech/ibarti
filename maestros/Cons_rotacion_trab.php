<link rel="stylesheet" type="text/css" href="latest/stylesheets/autocomplete.css" />
<script type="text/javascript" src="latest/scripts/autocomplete.js"></script>
<?php
	$Nmenu = '3002';
	require_once('autentificacion/aut_verifica_menu.php');
	require_once('sql/sql_report_t.php');
	$bd = new DataBase();
	$archivo = "rotacion_trab";
	$titulo  = " Rotacion  De ".$leng['trabajador']."";
	$vinculo = "../inicio.php?area=maestros/Cons_$archivo&Nmenu=$Nmenu&mod=".$_GET['mod']."";
	$men     = "Nmenu=$Nmenu&mod=".$_GET['mod']."";

    $metodo  = "modificar";
	$proced  = "p_rotacion_trab";
	$titulo  = " $titulo ";

	$cod_ficha = 'TODOS';
?>
<script language="JavaScript" type="text/javascript">

function Add_filtroX(){  // CARGAR  ARCHIVO DE AJAX CON UN PARAMETRO //

	var rol         = document.getElementById("rol").value;
	var region      = document.getElementById("region").value;
	var estado      = document.getElementById("estado").value;
    var contrato    = document.getElementById("contrato").value;
    var cargo       = document.getElementById("cargo").value;
    var rotacion    = document.getElementById("rotacion").value;
    var cliente     = document.getElementById("cliente").value;
    var ubicacion   = document.getElementById("ubicacion").value;
	var	trabajador  = document.getElementById("stdID").value;

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
			ajax.open("POST", "ajax/Add_rotacion_trab.php", true);
			ajax.onreadystatechange=function(){
				if (ajax.readyState==4){
		        document.getElementById(contenido).innerHTML = ajax.responseText;
				}
			}
			ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			ajax.send("&rol="+rol+"&region="+region+"&estado="+estado+"&contrato="+contrato+"&cargo="+cargo+"&cliente="+cliente+"&ubicacion="+ubicacion+"&rotacion="+rotacion+"&trabajador="+trabajador+"&usuario="+usuario+"");

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

function Add_form(valor, targ){
   document.getElementById("form_reportes").action = valor;
   document.getElementById("form_reportes").target = targ;
}


</script>
<div align="center" class="etiqueta_title"><?php echo $titulo;?> </div>
<div id="Contenedor01"></div><form name="form_reportes" id="form_reportes" action="sc_maestros/sc_<?php echo $archivo;?>.php"
                                   method="post" target="_self">
<fieldset>
<legend>Filtros:</legend>
	<table width="100%">
       <tr>
		 <td width="10%"><?php echo $leng['rol']?>: </td>
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

		 <td width="10%"><?php echo $leng['region']?>: </td>
		 <td width="14%"><select name="region" id="region" style="width:120px;">
					<option value="TODOS">TODOS</option>
					<?php
	   			$query01 = $bd->consultar($sql_region);
		 		while($row01=$bd->obtener_fila($query01,0)){
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
			   }?></select></td>
            <td width="10%"><?php echo $leng['estado']?>: </td>
			<td width="14%"><select name="estado" id="estado" style="width:120px;">
					<option value="TODOS">TODOS</option>
					<?php
	   			$query01 = $bd->consultar($sql_estado);
		 		while($row01=$bd->obtener_fila($query01,0)){
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
			   }?></select></td>
		<td width="10%">Tipo Reporte:</td>
		<td width="14%" id="select10"><select name="reporte" style="width:120px;">
  					   <option value="pdf">PDF</option>
					   <option value="excel">Excel</option>
               </select></td>
		 <td width="4%"><img class="imgLink" src="imagenes/actualizar.png" border="0" onclick="Add_filtroX()"></td>
      </tr>
        <tr>
		 <td><?php echo $leng['contrato']?>: </td>
			<td><select name="contrato" id="contrato" style="width:120px;">
					<option value="TODOS">TODOS</option>
					<?php
	   			$query01 = $bd->consultar($sql_contrato);
		 		while($row01=$bd->obtener_fila($query01,0)){
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
			   }?></select></td>

		 <td>Cargo: </td>
			<td><select name="cargo" id="cargo" style="width:120px;">
					<option value="TODOS">TODOS</option>
					<?php
	   			$query01 = $bd->consultar($sql_cargo);
		 		while($row01=$bd->obtener_fila($query01,0)){
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
			   }?></select></td>

		 <td><?php echo $leng['cliente']?>: </td>
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
			<td>&nbsp;</td>
      </tr>
        <tr>

		 <td>Rotacion: </td>
		<td><select name="rotacion" id="rotacion" style="width:120px;">
					    <option value="TODOS">TODOS</option>
					<?php
	   			$query01 = $bd->consultar($sql_rotacion);
		 		while($row01=$bd->obtener_fila($query01,0)){
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
			   }?></select></td>
       <td>Filtro:</td>
		<td><select id="paciFiltro" onchange="EstadoFiltro(this.value)" style="width:120px">
				<option value="">Seleccione...</option>
				<option value="codigo"> <?php echo $leng['ficha']?></option>
				<option value="cedula"><?php echo $leng['ci']?></option>
				<option value="trabajador"><?php echo $leng['trabajador']?></option>
                <option value="apellidos">Apellido</option>
                <option value="nombres">Nombre</option>
		</select><br />
       	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
	  <td>Trabajador:</td>
      <td colspan="3"><input name="trabajador" id="stdName" type="text" style="width:300px" disabled="disabled" value=""/>
	        <span id="input01"><input type="hidden" name="trabajador" id="stdID" value="<?php echo $cod_ficha;?>"/>	<br />
            <span class="textfieldRequiredMsg">Debe De Seleccionar Un Campo De la Lista.</span>
            <span class="textfieldInvalidFormatMsg">El Formato es Invalido</span> </span></td>

        <td>&nbsp;
            <input type="hidden" name="codigo" id="codigo" value="<?php echo $codigo;?>" />
            <input type="hidden" name="Nmenu" id="Nmenu" value="<?php echo $Nmenu;?>" />
            <input type="hidden" name="mod" id="mod" value="<?php echo $mod;?>" />
            <input type="hidden" name="metodo" id="metodo" value="<?php echo $metodo;?>" />
            <input type="hidden" name="proced" id="proced" value="<?php echo $proced;?>" />
            <input type="hidden" name="usuario" id="usuario" value="<?php echo $usuario;?>" />
            <input type="hidden" name="href" id="href" value="<?php echo $vinculo;?>"/></td>
      </tr>

</table></fieldset>
<div id="listar"></div>
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
