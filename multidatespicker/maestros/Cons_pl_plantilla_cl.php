<?php
	$Nmenu = '306';
	require_once('autentificacion/aut_verifica_menu.php');
	require_once('sql/sql_report_t.php');
	$tabla = "pl_plantilla_cliente";
	$bd = new DataBase();
	$archivo = "pl_plantilla_cl";
	$titulo = " Plantilla ".$leng['cliente']."";
	$vinculo = "inicio.php?area=maestros/Add_$archivo&Nmenu=".$_GET['Nmenu']."&mod=".$_GET['mod']."&archivo=$archivo";
?>
<script language="javascript">
function Add_filtroX(){  // CARGAR  ARCHIVO DE AJAX CON UN PARAMETRO//

		var cliente   = document.getElementById("cliente").value;
		var ubicacion = document.getElementById("ubicacion").value;
		var cargo     = document.getElementById("cargo").value;
		var turno     = document.getElementById("turno").value;

		var Nmenu     = document.getElementById("Nmenu").value;
		var mod       = document.getElementById("mod").value;
		var archivo   = document.getElementById("archivo").value;



		var aj = "ajax/Add_pl_plantilla_cl.php";
		ajax=nuevoAjax();
			ajax.open("POST", aj, true);
			ajax.onreadystatechange=function()
			{
				if (ajax.readyState==4){
		        document.getElementById("listar").innerHTML = ajax.responseText;
				}
			}
			ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			ajax.send("cliente="+cliente+"&ubicacion="+ubicacion+"&cargo="+cargo+"&turno="+turno+"&Nmenu="+Nmenu+"&mod="+mod+"&archivo="+archivo+"");
	}
</script>
<div align="center" class="etiqueta_title"> Consulta <?php echo $titulo;?> </div>
<div id="Contenedor01"></div>
<fieldset>
<legend>Filtros:</legend>
	<table width="100%">
		<tr><td width="10%"><?php echo $leng['cliente']?>: </td>
			<td width="14%"><select name="cliente" id="cliente" style="width:120px;"
                                    onchange="Add_Cl_Ubic(this.value, 'contenido_ubic', 'T', '120')">
					                <option value="TODOS">TODOS</option>
				<?php
	   			$query01 = $bd->consultar($sql_cliente);
		 		while($row01=$bd->obtener_fila($query01,0)){
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
			   }?></select></td>
            <td width="10%"><?php echo $leng['ubicacion']?>: </td>
			<td width="14%" id="contenido_ubic"><select name="ubicacion" id="ubicacion" style="width:120px;">
					    <option value="TODOS">TODOS</option></select></td>
               <td width="10%">Cargos: </td>
			<td width="14%"><select  name="cargo" id="cargo" style="width:120px;">
					                 <option value="TODOS">TODOS</option>
				<?php
				$query01 = $bd->consultar($sql_cargo);
		 		while($row01=$bd->obtener_fila($query01,0)){
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
			   }?></select></td>
               <td width="10%">Turno: </td>
			<td width="14%"><select name="turno" id="turno" style="width:120px;" >
					                <option value="TODOS">TODOS</option>
			<?php
	   			$query01 = $bd->consultar($sql_turno);
		 		while($row01=$bd->obtener_fila($query01,0)){
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
			   }?></select></td>
			<td width="4%"><img class="imgLink" src="imagenes/actualizar.png" border="0" onclick="Add_filtroX()">
            <input type="hidden" name="Nmenu" id="Nmenu" value="<?php echo $Nmenu;?>" />
            <input type="hidden" name="mod" id="mod" value="<?php echo $mod;?>" />
            <input type="hidden" name="tabla" id="tabla" value="<?php echo $tabla;?>"/>
            <input type="hidden" name="archivo" id="archivo" value="<?php echo $archivo;?>"/>
             </td>
</tr>
</table>
</fieldset>
<div id="listar"><table width="100%" border="0" align="center">
		<tr class="fondo00">
			<th width="20%" class="etiqueta"><?php echo $leng['cliente']?></th>
			<th width="30%" class="etiqueta"><?php echo $leng['ubicacion']?></th>
            <th width="20%" class="etiqueta">Cargo</th>
  			<th width="20%" class="etiqueta">Turno</th>
            <th width="3%" class="etiqueta">Cant.</th>
		    <th width="7%" align="center"><a href="<?php echo $vinculo."&codigo=''&metodo=agregar&codigo=";?>"><img src="imagenes/nuevo.bmp" alt="Agregar Registro" title="Agregar Registro" width="20px" height="20px" border="null"/></a></th>
		</tr>
    </table></div>
