<?php
	$Nmenu = '441';
	require_once('autentificacion/aut_verifica_menu.php');
require_once('sql/sql_report_t.php');
	$tabla = "pl_cliente";
	$bd = new DataBase();
	$archivo = "pl_cliente";
	$titulo  = " Planificacion De ".$leng['cliente']." ";
	$vinculo = "../inicio.php?area=formularios/Cons_$archivo&Nmenu=".$_GET['Nmenu']."&mod=".$_GET['mod']."";

	$metodo = $_GET['metodo'];
	$proced  = "p_pl_cliente";
	$proced2 = "p_pl_cliente_det";

if($metodo == 'modificar'){
	$titulo = "Modificar  $titulo";

	$codigo = $_GET['codigo'];
	$sql = " SELECT pl_cliente.fecha, pl_cliente.cod_turno, turno.descripcion AS turno
               FROM pl_cliente , turno
              WHERE pl_cliente.codigo = '$codigo'
                AND pl_cliente.cod_turno = turno.codigo ";
	$query = $bd->consultar($sql);
	$result=$bd->obtener_fila($query,0);

	$fec_desde    = conversion($result["fecha"]);
	$fec_hasta    = conversion($result["fecha"]);

	$fec_desde_r    = 'readonly="readonly"';
	$fec_hasta_r    = 'readonly="readonly"';
	$cod_turno    = $result["cod_turno"];
	$turno        = $result["turno"];
	}else{
	$titulo = "Agregar $titulo";
	$codigo      = '';

	$fec_desde   = '';
	$fec_hasta   = '';
	$fec_desde_r = '';
	$fec_hasta_r = '';

	$cod_turno   = '';
	$turno       = ' Seleccione... ';
	}

?>
<script language="JavaScript" type="text/javascript">

function Add_filtroX(){  // CARGAR  ARCHIVO DE AJAX CON UN PARAMETRO //

	var codigo      = document.getElementById("codigo").value;
	var fecha_desde = document.getElementById("fecha_desde").value;
	var fecha_hasta = document.getElementById("fecha_hasta").value;
    var cliente     = document.getElementById("cliente").value;
    var ubicacion   = document.getElementById("ubicacion").value;
    var cargo       = document.getElementById("cargo").value;
    var metodo      = document.getElementById("metodo").value;

	var error = 0;
    var errorMessage = ' ';
	 if( fechaValida(fecha_desde) !=  true || fechaValida(fecha_hasta) != true){
    var errorMessage = ' Campos De Fecha Incorrectas ';
	 var error = error+1;
	}

	if((ubicacion == "") || (ubicacion == "TODOS")){
    var errorMessage = ' Debe Seleccionar Una Ubicacion ';
	 var error = error+1;
	}

	if((cliente == "") || (cliente == "TODOS")){
    var errorMessage = ' Debe Seleccionar Un Cliente ';
	 var error = error+1;
	}

	 if(error == 0){
		var contenido = "listar";

		ajax=nuevoAjax();
			ajax.open("POST", "ajax/Add_pl_cliente.php", true);
			ajax.onreadystatechange=function(){
				if (ajax.readyState==4){
		        document.getElementById(contenido).innerHTML = ajax.responseText;
				}
			}
			ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			ajax.send("codigo="+codigo+"&metodo="+metodo+"&cliente="+cliente+"&ubicacion="+ubicacion+"&cargo="+cargo+"");

	}else{
		 	alert(errorMessage);
	}
}
</script>
<div align="center" class="etiqueta_title"><?php echo $titulo;?> </div>
<div id="Contenedor01"></div>
<form name="form_reportes" id="form_reportes" action="scripts/sc_<?php echo $archivo;?>.php" method="post" target="_self">
<fieldset>
<legend>Filtros:</legend>
	<table width="100%">

		<tr><td width="10%">Fecha Desde:</td>
		 <td width="14%" id="fecha01"><input type="text" name="fecha_desde" id="fecha_desde" size="9" onclick="javascript:muestraCalendario('form_reportes', 'fecha_desde');">&nbsp;<img src="imagenes/icono-calendario.gif" onclick="javascript:muestraCalendario('form_reportes', 'fecha_desde');" border="0" width="17px"></td>
        <td width="10%">Fecha Hasta:</td>
		 <td width="14%" id="fecha02"><input type="text" name="fecha_hasta" id="fecha_hasta" size="9"  onclick="javascript:muestraCalendario('form_reportes', 'fecha_hasta');">&nbsp;<img src="imagenes/icono-calendario.gif" onclick="javascript:muestraCalendario('form_reportes', 'fecha_hasta');" border="0" width="17px"></td>
         <td width="10%"><?php echo $leng['cliente']?>:</td>
			<td width="14%"><select name="cliente" id="cliente" style="width:120px;"
                                    onchange="Add_Cl_Ubic(this.value, 'contenido_ubic', 'T', '120')">
					        <option value="TODOS">Seleccione ...</option>
		<?php 	$query01 = $bd->consultar($sql_cliente);
		 		while($row01=$bd->obtener_fila($query01,0)){
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
			   }?></select></td>
			<td width="10%"><?php echo $leng['ubicacion']?>: </td>
			<td id="contenido_ubic" width="14%"><select name="ubicacion" id="ubicacion" style="width:120px;" onchange="Add_filtroX()">
					                        <option value="TODOS">TODOS</option>
                                    </select></td>
         <td width="4%"><img class="imgLink" src="imagenes/actualizar.png" border="0" onclick="Add_filtroX()">
         <input type="hidden" name="codigo" id="codigo" value="<?php echo $codigo;?>" />
            <input type="hidden" name="Nmenu" id="Nmenu" value="<?php echo $Nmenu;?>" />
            <input type="hidden" name="mod" id="mod" value="<?php echo $mod;?>" />
            <input type="hidden" name="metodo" id="metodo" value="<?php echo $metodo;?>" />
            <input type="hidden" name="proced" id="proced" value="<?php echo $proced;?>" />
            <input type="hidden" name="proced2" id="proced2" value="<?php echo $proced2;?>" />
            <input type="hidden" name="usuario" id="proced" value="<?php echo $usuario;?>" />
            <input type="hidden" name="href" id="href" value="<?php echo $vinculo;?>"/></td>
      </tr>
      <tr>
		<td>Cargo:</td>
        <td><select name="cargo" id="cargo" style="width:120px;"  onchange="Add_filtroX()">
				    <option value="TODOS">TODOS</option>
		<?php  $query01 = $bd->consultar($sql_cargo);
		 		while($row01=$bd->obtener_fila($query01,0)){
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
			   }?></select></td>
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
