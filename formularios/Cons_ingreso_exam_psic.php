<?php
	$Nmenu = '442';
	require 'autentificacion/aut_verifica_menu.php';
	$bd = new DataBase();
	$tabla    = "preingreso";
	$archivo = "ingreso_exam_psic";
	$titulo = " PREINGRESO DE TRABAJADOR EXAMEN PSICOLOGICO ";
	$vinculo = "inicio.php?area=formularios/Add_$archivo&Nmenu=$Nmenu&mod=$mod&archivo=$archivo";

	$sql01 = "SELECT preing_status.codigo AS cod_status, preing_status.descripcion AS status
               FROM control , preing_status
              WHERE control.preingreso_nuevo = preing_status.codigo";

	$query01 = $bd->consultar($sql01);
    $row02   = $bd->obtener_fila($query01,0);
	$cod_status = $row02[0];
    $status     = $row02[1];
?>
<script language="JavaScript" type="text/javascript">
function Add_filtroX(){  // CARGAR  ARCHIVO DE AJAX CON UN PARAMETRO//

	var Nmenu       = document.getElementById("Nmenu").value;
	var mod         = document.getElementById("mod").value;
	var archivo     = document.getElementById("archivo").value;
	var status      = document.getElementById("status").value;
	var estado      = document.getElementById("estado").value;
	var psic        = document.getElementById("psic").value;
	var pol         = document.getElementById("pol").value;
	var error = 0;
    var errorMessage = ' ';
	if(error == 0){
	var contenido = "listar";
	ajax=nuevoAjax();
			ajax.open("POST", "ajax/Add_fic_ingreso_exam_psic.php", true);
			ajax.onreadystatechange=function(){
				if (ajax.readyState==4){
		        document.getElementById(contenido).innerHTML = ajax.responseText;
				}
			}
			ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			ajax.send("Nmenu="+Nmenu+"&mod="+mod+"&archivo="+archivo+"&status="+status+"&estado="+estado+"&psic="+psic+"&pol="+pol+"");

	}else{
		 	 alert(errorMessage);
	}
}
</script>
<div align="center" class="etiqueta_title"> CONSULTA <?php echo $titulo;?> </div> <hr />
<div id="Contenedor01"></div>
<fieldset>
<legend>Filtros:</legend>
<table width="100%">
		<tr><td width="10%">Status: </td>
			<td width="14%"><select  name="status" id="status" style="width:120px;">
					<option value="<?php echo $cod_status?>"><?php echo $status; ?></option>
					<?php
				$sql01 = "SELECT preing_status.codigo, preing_status.descripcion
                            FROM preing_status
						   WHERE preing_status.`status` = 'T' AND preing_status.codigo <> '$ing_nuevo'
					    ORDER BY 2 ASC";
	   			$query01 = $bd->consultar($sql01);
		 		while($row01=$bd->obtener_fila($query01,0)){
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
			   }?></select></td>
			<td width="10%"><?php echo $leng["estado"];?>: </td>
			<td width="14%"><select  name="estado" id="estado" style="width:120px;">
					<option value="TODOS">TODOS</option>
					<?php
				$sql01 = "SELECT estados.codigo, estados.descripcion
                            FROM estados
						   WHERE estados.status = 'T'
					    ORDER BY 2 ASC";
	   			$query01 = $bd->consultar($sql01);
		 		while($row01=$bd->obtener_fila($query01,0)){
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
			   }?></select></td>
			<td width="12%">Ex. Psicologico:</td>
			<td width="12%"><select  name="psic" id="psic" style="width:120px;" >
					<option value="TODOS">TODOS</option>
                    <option value="S"><?php echo $leng["aprobado"];?></option>
                    <option value="N"><?php echo $leng["reprobado"];?></option>
                    <option value="C"><?php echo $leng["condiccional"];?></option>
                    <option value="I"><?php echo $leng["indefinido"];?></option>

                    </select></td>
			<td width="12%">Cheq. Policial:</td>
			<td width="12%"><select  name="pol" id="pol" style="width:120px;" >
					<option value="TODOS">TODOS</option>
                    <option value="S"><?php echo $leng["aprobado"];?></option>
                    <option value="N"><?php echo $leng["reprobado"];?></option>
                    <option value="I"><?php echo $leng["indefinido"];?></option></select>
            </td>
            <td width="4%"><img class="imgLink" src="imagenes/actualizar.png" border="0" onclick="Add_filtroX()">
            <input type="hidden" name="Nmenu" id="Nmenu" value="<?php echo $Nmenu;?>" />
                   <input type="hidden" name="mod" id="mod" value="<?php echo $mod;?>" />
                   <input type="hidden" name="archivo" id="archivo" value="<?php echo $archivo;?>" /></td>
       </tr>
</table>
</fieldset>
<div id="listar"><table width="100%" border="0" align="center">
<tr class="fondo00">
			<th width="20%" class="etiqueta"><?php echo $leng["estado"];?></th>
			<th width="10%" class="etiqueta"><?php echo $leng["ci"];?></th>
			<th width="30%" class="etiqueta">Nombre</th>
  			<th width="11%" class="etiqueta">Fec. Sistema</th>
            <th width="11%" class="etiqueta">Fec. Ingreso</th>
            <th width="10%" class="etiqueta">Status</th>
		    <th width="8%" align="center"><img src="imagenes/loading2.gif" alt="Consultar Registro" title="Consultar Registro"
                                                width="20px" height="20px" border="null"/></th>
		</tr>
    <?php
	$usuario = $_SESSION['usuario_cod'];
	$valor = 0;
	$sql = " SELECT preingreso.cod_estado, estados.descripcion AS estados,
                    preingreso.cedula, preingreso.cod_cargo, cargos.descripcion AS cargo,
	                 CONCAT(preingreso.apellidos, '', preingreso.nombres) AS nombres,  preingreso.fec_nacimiento,
                    preingreso.sexo, preingreso.telefono,
					preingreso.fec_preingreso,
					preingreso.fec_psic, preingreso.psic_apto,
					preingreso.fec_pol, preingreso.pol_apto,
					preingreso.fec_us_ing,
					preingreso.`status` AS cod_status, preing_status.descripcion AS status
               FROM preingreso , estados, cargos , preing_status
              WHERE preingreso.cod_estado = estados.codigo
                AND  preingreso.cod_cargo = cargos.codigo
                AND preingreso.`status` = preing_status.codigo
                AND preingreso.`status` = '$cod_status'
		   ORDER BY fec_us_ing DESC";

   $query = $bd->consultar($sql);

		while ($datos=$bd->obtener_fila($query,0)){
		if ($valor == 0){
			$fondo = 'fondo01';
		$valor = 1;
		}else{
			$fondo = 'fondo02';
			$valor = 0;
		}

	// $Modificar = "Add_Mod01('".$datos[0]."', 'modificar')";
	   $Borrar = "Borrar01('".$datos[0]."')";
        echo '<tr class="'.$fondo.'">
                  <td>'.$datos["estados"].'</td>
				  <td>'.$datos["cedula"].'</td>
                  <td>'.$datos["nombres"].'</td>
				  <td>'.$datos["fec_us_ing"].'</td>
				  <td>'.$datos["fec_preingreso"].'</td>
				  <td>'.$datos["status"].'</td>
				  <td align="center"><a href="'.$vinculo.'&codigo='.$datos["cedula"].'&metodo=modificar"><img src="imagenes/actualizar.bmp" alt="Modificar" title="Modificar Registro" width="20" height="20" border="null"/></a>&nbsp;<img src="imagenes/borrar.bmp"  width="20px" height="20px" title="Borrar Registro" border="null" onclick="'.$Borrar.'" class="imgLink"/></td>
            </tr>';
        }
     echo '<input type="hidden" name="tabla" id="tabla" value="'.$tabla.'"/>';
	?></table>
</div>
