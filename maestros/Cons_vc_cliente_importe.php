<script language="javascript">
function Add_filtroX(){  // CARGAR  ARCHIVO DE AJAX CON UN PARAMETRO //

	var Nmenu      = document.getElementById("Nmenu").value;
	var mod        = document.getElementById("mod").value;
	var cliente    = document.getElementById("cliente").value;
	var turno      = document.getElementById("turno").value;
	var error = 0;
    var errorMessage = ' ';

	if(error == 0){
		var contenido = "listar";

		ajax=nuevoAjax();
			ajax.open("POST", "ajax/Add_vc_cliente_importe.php", true);
			ajax.onreadystatechange=function(){
				if (ajax.readyState==4){
		        document.getElementById(contenido).innerHTML = ajax.responseText;
				}
			}
			ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			ajax.send("cliente="+cliente+"&turno="+turno+"&Nmenu="+Nmenu+"&mod="+mod+"");
	}else{
 		alert(errorMessage);
	}
}
</script>
<?php
	$Nmenu = '360';
	require_once('autentificacion/aut_verifica_menu.php');
	$tabla = "vc_cliente_importe";
	$bd = new DataBase();
	$archivo = "vc_cliente_importe";
	$titulo = "  ".$leng['cliente']." Importe ";
	$vinculo = "inicio.php?area=maestros/add_$archivo&Nmenu=$Nmenu&mod=".$_GET['mod']."&archivo=$archivo";
?>
<div align="center" class="etiqueta_title"> Consulta <?php echo $titulo;?> </div>
<div id="Contenedor01"></div>
<fieldset>
<legend>Filtros:</legend>
	<table width="100%">
		<tr><td width="10%"><?php echo $leng['cliente'];?>: </td>
			<td width="20%"><select  name="cliente" id="cliente" style="width:150px;" onchange="Add_filtroX()">
					<option value="TODOS">TODOS</option>
					<?php
				$sql01 = " SELECT clientes.codigo, clientes.nombre
                             FROM clientes WHERE clientes.`status` = 'T'
					     ORDER BY 2 ASC";
	   			$query01 = $bd->consultar($sql01);
		 		while($row01=$bd->obtener_fila($query01,0)){
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
			   }?></select></td>
			<td width="10%">Turno: </td>
			<td width="20%"><select  name="turno" id="turno" style="width:150px;" onchange="Add_filtroX()">
					<option value="TODOS">TODOS</option>
					<?php
				$sql01 = " SELECT turno.codigo, turno.descripcion, turno.abrev
                             FROM turno WHERE turno.`status` = 'T'
					        ORDER BY 2 ASC ";
	   			$query01 = $bd->consultar($sql01);
		 		while($row01=$bd->obtener_fila($query01,0)){
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
			   }?></select></td>
			<td width="40%">&nbsp;
            <input type="hidden" name="Nmenu" id="Nmenu" value="<?php echo $Nmenu;?>" />
            <input type="hidden" name="mod" id="mod" value="<?php echo $mod;?>" />
             </td></tr>
</table>
</fieldset>
<div id="listar"><table width="100%" border="0" align="center">
		<tr class="fondo00">
			 <th width="10%" class="etiqueta">Fecha</th>
            <th width="15%" class="etiqueta"><?php echo $leng['cliente'];?></th>
            <th width="20%" class="etiqueta"><?php echo $leng['ubicacion'];?></th>
			<th width="20%" class="etiqueta">Cargo</th>
  			<th width="20%" class="etiqueta">Turno</th>
            <th width="10%" class="etiqueta">Importe</th>
		    <th width="5%" align="center"><a href="<?php echo $vinculo."&codigo=''&metodo=agregar&codigo=";?>"><img src="imagenes/nuevo.bmp" alt="Agregar Registro" title="Agregar Registro" width="20px" height="20px" border="null"/></a></th>
		</tr>
    <?php
	$usuario = $_SESSION['usuario_cod'];
	$valor = 0;
	$sql = "  SELECT clientes_importe.codigo, clientes_importe.fecha,
	                 clientes_importe.cod_cliente,  clientes.abrev AS cl_abrev,
					 clientes.nombre AS cliente, clientes_ubicacion.descripcion AS ubicacion,
                 	 clientes_importe.cod_cargo, cargos.descripcion AS cargo,
                     clientes_importe.cod_turno, turno.descripcion AS turno,
					 clientes_importe.importe, clientes_importe.observacion,
					 clientes_importe.fec_us_mod, clientes_importe.fec_us_ing
                FROM clientes_importe , clientes ,  clientes_ubicacion, cargos , turno
               WHERE clientes_importe.cod_cliente = clientes.codigo
			     AND clientes_importe.cod_ubicacion = clientes_ubicacion.codigo
                 AND clientes_importe.cod_cargo = cargos.codigo
                 AND clientes_importe.cod_turno = turno.codigo
		   ORDER BY 3 DESC";

   $query = $bd->consultar($sql);

		while ($datos=$bd->obtener_fila($query,0)){
		if ($valor == 0){
			$fondo = 'fondo01';
		$valor = 1;
		}else{
			$fondo = 'fondo02';
			$valor = 0;
		}
	   $Borrar = "Borrar01('".$datos[0]."')";
        echo '<tr class="'.$fondo.'">
                  <td class="texo">'.conversion($datos["fecha"]).'</td>
				  <td class="texo">'.$datos["cl_abrev"].'</td>
				  <td class="texo">'.longitud($datos["ubicacion"]).'</td>
                  <td class="texo">'.longitud($datos["cargo"]).'</td>
				  <td class="texo">'.longitud($datos["turno"]).'</td>
				  <td class="texo">'.$datos["importe"].'</td>
				  <td align="center"><a href="'.$vinculo.'&codigo='.$datos[0].'&metodo=modificar"><img src="imagenes/actualizar.bmp" alt="Modificar" title="Modificar Registro" width="20" height="20" border="null"/></td>
            </tr>';
        } ;?>
    </table></div>
<?php  echo '<input type="hidden" name="tabla" id="tabla" value="'.$tabla.'"/>';?>
