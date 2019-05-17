<?php
	$Nmenu = '412';

	require_once('autentificacion/aut_verifica_menu.php');
	require_once('sql/sql_report_t.php');
	$tabla = "ficha3";
	$bd = new DataBase();
	$archivo = "ficha3";
	$titulo = " FICHA EVENTUALES";
	$vinculo = "inicio.php?area=pestanas/add_$archivo&Nmenu=$Nmenu&mod=".$_GET['mod']."";

	$sql01 = " SELECT ficha_status.codigo, ficha_status.descripcion
				 FROM control , ficha_status
				WHERE control.ficha_activo = ficha_status.codigo ";

	$query01    = $bd->consultar($sql01);
    $row02      = $bd->obtener_fila($query01,0);
	$cod_status = $row02[0];
    $status     = $row02[1];
?>
<script language="javascript">
	function FiltarX(ValorN){

	var href = "inicio.php?area=formularios/Cons_Ficha&Nmenu=<?php echo $Nmenu;?>&filtroX="+ValorN+"";
	window.location.href=""+href+"";
	}
</script>
<script language="JavaScript" type="text/javascript">
function Add_filtroX(){  // CARGAR  ARCHIVO DE AJAX CON UN PARAMETRO//

	var Nmenu    = document.getElementById("Nmenu").value;
	var mod      = document.getElementById("mod").value;
	var rol      = document.getElementById("rol").value;
	var status   = document.getElementById("status").value;

	var error = 0;
    var errorMessage = ' ';
	if(error == 0){
	var contenido = "listar";
	ajax=nuevoAjax();
			ajax.open("POST", "ajax/Add_fic_eventuales.php", true);
			ajax.onreadystatechange=function(){
				if (ajax.readyState==4){
		        document.getElementById(contenido).innerHTML = ajax.responseText;
				}
			}
			ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			ajax.send("Nmenu="+Nmenu+"&mod="+mod+"&status="+status+"&rol="+rol+"");

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
		<tr><td width="10%"><?php echo $leng["rol"];?>: </td>
			<td width="25%"><select name="rol" id="rol" style="width:150px;" required>
					<?php
					echo $select_rol;
	   			$query01 = $bd->consultar($sql_rol);
		 		while($row01=$bd->obtener_fila($query01,0)){
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
			   }?></select></td>   <td width="10%">Status: </td>
			<td width="25%"><select  name="status" id="status" style="width:150px;">
					<option value="<?php echo $cod_status?>"><?php echo $status; ?></option>
					<?php
				$sql01 = "SELECT ficha_status.codigo, ficha_status.descripcion
                            FROM ficha_status
                           WHERE ficha_status.`status` = 'T'
						     AND ficha_status.codigo <> '$cod_status'
                           ORDER BY 2 ASC";
	   			$query01 = $bd->consultar($sql01);
		 		while($row01=$bd->obtener_fila($query01,0)){
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
			   }?></select></td>
              <td width="20%">&nbsp;</td>
              <td width="5%"><img class="imgLink" src="imagenes/actualizar.png" border="0" onclick="Add_filtroX()"></td>
			<td width="5%">&nbsp;<input type="hidden" name="Nmenu" id="Nmenu" value="<?php echo $Nmenu;?>" />
            <input type="hidden" name="mod" id="mod" value="<?php echo $mod;?>" />
             </td>
</tr>
</table>
</fieldset>
<div id="Contenedor01"></div>
<div id="listar"><table width="100%" border="0" align="center">
		<tr class="fondo00">
			<th width="17%" class="etiqueta"><?php echo $leng["rol"];?></th>
    		<th width="10%" class="etiqueta"><?php echo $leng["ficha"];?></th>
			<th width="25%" class="etiqueta">Nombre</th>
  			<th width="10%" class="etiqueta">Fecha De Ingreso</th>
  			<th width="10%" class="etiqueta">Fecha Ult. <br />Actualizacion</th>
            <th width="10%" class="etiqueta">Status</th>
		    <th width="8%" align="center"><a href="inicio.php?area=formularios/Bus_ficha_add3&Nmenu=<?php echo $Nmenu.'&mod='.$mod;?>"><img src="imagenes/nuevo.bmp" alt="Agregar" title="Agregar Registro" width="22px" height="22px" border="null" class="imgLink"/></a></th>
	</tr>
<?php
	$valor = 0;
	$sql = " SELECT ficha.cod_ficha, ficha.cedula,
	                CONCAT(ficha.apellidos, ficha.nombres) AS nombres,  roles.descripcion AS rol,
				    ficha.fec_ingreso,  ficha.fec_us_ing,
				    ficha.fec_us_mod, ficha.cod_ficha_status,
					ficha_status.descripcion AS status
	           FROM ficha, ficha_status, control, trab_roles, roles
              WHERE ficha.cod_ficha_status = ficha_status.codigo
                AND ficha.cod_ficha_status = control.ficha_activo
                AND ficha.cod_contracto = control.contracto_eventuales
                AND ficha.cod_ficha = trab_roles.cod_ficha
                AND trab_roles.cod_rol = roles.codigo
	       ORDER BY 3,2 DESC ";

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
                  <td>'.$datos["rol"].'</td>
 			      <td>'.$datos["cod_ficha"].'</td>
                  <td>'.longitud($datos["nombres"]).'</td>
				  <td>'.$datos["fec_us_ing"].'</td>
				  <td>'.$datos["fec_us_mod"].'</td>
				  <td>'.$datos["status"].'</td>
				  <td align="center"><a href="'.$vinculo.'&codigo='.$datos[0].'&metodo=modificar"><img src="imagenes/actualizar.bmp" alt="Modificar" title="Modificar Registro" width="20" height="20" border="null"/></a>&nbsp;<img src="imagenes/borrar.bmp"  width="20px" height="20px" title="Borrar Registro" border="null" onclick="'.$Borrar.'" class="imgLink"/></td>
            </tr>';
        }
     echo '<input type="hidden" name="tabla" id="tabla" value="'.$tabla.'"/>';
	?>
    </table>
</div>
