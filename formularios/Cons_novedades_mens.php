<?php 
	$Nmenu     = 450; 
	$mod       = $_GET['mod']; 
	require_once('autentificacion/aut_verifica_menu.php');
	require_once('sql/sql_report_t.php');
	$bd = new DataBase();
	$archivo  = "novedades_mens";
	$vinculo  = "inicio.php?area=formularios/Add_$archivo&Nmenu=$Nmenu&mod=$mod";
	$titulo   = "NOVEDADES MENSAJERIA DE TEXTO";
?>
<script language="JavaScript" type="text/javascript">
function Add_filtroX(){  // CARGAR  ARCHIVO DE AJAX CON UN PARAMETRO//

	var Nmenu       = document.getElementById("Nmenu").value; 
	var mod         = document.getElementById("mod").value;						
    var archivo     = document.getElementById("archivo").value;						
	var fecha_desde = document.getElementById("fecha_desde").value; 
	var fecha_hasta = document.getElementById("fecha_hasta").value;
	var novedad     = document.getElementById("novedad").value; 
	var clasif      = document.getElementById("clasif").value; 
	var status      = document.getElementById("status").value;						

					
	var error = 0; 
    var errorMessage = ' ';
	 if( fechaValida(fecha_desde) !=  true || fechaValida(fecha_hasta) != true){
    var errorMessage = ' Campos De Fecha Incorrectas ';
	 var error = error+1; 		 
	}
 
	if(error == 0){
	var contenido = "listar";
	ajax=nuevoAjax();
			ajax.open("POST", "ajax/novedades_mens.php", true);
			ajax.onreadystatechange=function(){ 
				if (ajax.readyState==4){
		        document.getElementById(contenido).innerHTML = ajax.responseText;					
				}
			} 
			ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			ajax.send("Nmenu="+Nmenu+"&mod="+mod+"&archivo="+archivo+"&fecha_desde="+fecha_desde+"&fecha_hasta="+fecha_hasta+"&novedad="+novedad+"&clasif="+clasif+"&cliente="+cliente+"&ubicacion="+ubicacion+"&status="+status+"&perfil="+perfil+"");	
	
	}else{
		 	 alert(errorMessage);
	}	
}
</script>	
<div align="center" class="etiqueta_title"> CONSULTA <?php echo $titulo;?> </div> <hr />
<div id="Contenedor01"></div>
<form name="form_consulta" id="form_consulta" action="<?php echo $archivo;?>" method="post" target="_blank">
<fieldset>
<legend>Filtros:</legend>
	<table width="100%" class="etiqueta">
		<tr>
         <td width="10%">Fecha Desde:</td>
        <td width="14%" id="fecha01"><input type="text" name="fecha_desde" id="fecha_desde" size="9"  onclick="javascript:muestraCalendario('form_consulta', 'fecha_desde');">&nbsp;<img src="imagenes/icono-calendario.gif" onclick="javascript:muestraCalendario('form_consulta', 'fecha_desde');" border="0" width="17px"></td>
        <td width="10%">Fec. Hasta:</td>   
		 <td width="14%" id="fecha02"><input type="text" name="fecha_hasta" id="fecha_hasta"  size="9"  onclick="javascript:muestraCalendario('form_consulta', 'fecha_hasta');">&nbsp;<img src="imagenes/icono-calendario.gif" onclick="javascript:muestraCalendario('form_consulta', 'fecha_hasta');" border="0" width="17px"></td>
        <td width="10%">Novedades: </td>
			<td width="14%"><select  name="novedad" id="novedad" style="width:120px;">
					<option value="TODOS">TODOS</option>  
					<?php 
			  $sql01   = "SELECT novedades.codigo, novedades.descripcion 
				               FROM novedades , nov_perfiles, nov_clasif 
                              WHERE novedades.`status` = 'T' 
                                AND novedades.cod_nov_clasif = nov_clasif.codigo 
                                AND nov_clasif.codigo = nov_perfiles.cod_nov_clasif                              
                                AND nov_perfiles.cod_perfil = ".$_SESSION['cod_perfil']."
                                AND nov_clasif.campo04 = 'F'    
                           ORDER BY 2 ASC  ";	
	   			$query01 = $bd->consultar($sql01);		
		 		while($row01=$bd->obtener_fila($query01,0)){							   							
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';						   		
			   }?></select></td>
			<td width="10%">Clasificacion: </td>
			<td width="14%"><select  name="clasif" id="clasif" style="width:120px;">
					<option value="TODOS">TODOS</option> 
					<?php 
				$sql01    = "SELECT nov_clasif.codigo,  nov_clasif.descripcion
				               FROM nov_perfiles, nov_clasif 
                              WHERE nov_perfiles.cod_nov_clasif = nov_clasif.codigo
                                AND nov_perfiles.cod_perfil = '".$_SESSION['cod_perfil']."'                              
                                AND nov_clasif.campo04 = 'F'    
                           ORDER BY 2 ASC";
	   			$query01 = $bd->consultar($sql01);		
		 		while($row01=$bd->obtener_fila($query01,0)){							   							
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';						   		
			   }?></select></td>
			 <td width="4%"><img class="imgLink" src="imagenes/actualizar.png" border="0" onclick="Add_filtroX()"></td>    
            </tr>
           <tr>
           	<td>Status: </td>    
            <td><select name="status" id="status" style="width:120px;">
                <option value="TODOS">TODOS</option>
     <?php  $query01 = $bd->consultar($sql_nov_status);		
            while($row01=$bd->obtener_fila($query01,0)){							   							
                 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';						   		
           }?></select></td>
           	<td>Usuario: </td>    
            <td><select name="usuario" id="usuario" style="width:120px;">
                <option value="TODOS">TODOS</option>
     <?php  $query01 = $bd->consultar($sql_usuario);		
            while($row01=$bd->obtener_fila($query01,0)){							   							
                 echo '<option value="'.$row01[0].'">'.$row01[2].'</option>';						   		
           }?></select></td>
           
        <td>&nbsp;<input type="hidden" name="Nmenu" id="Nmenu" value="<?php echo $Nmenu;?>" />
        <input type="hidden" name="mod" id="mod" value="<?php echo $mod;?>" />
        <input type="hidden" name="archivo" id="archivo" value="<?php echo $archivo;?>" />
        <input type="hidden" name="perfil" id="perfil" value="<?php echo $_SESSION['cod_perfil'];?>" /></td>	    
        </tr> 
</table>
</fieldset>
</form>
<div id="listar"><table width="100%" border="0" align="center">
		<tr class="fondo00">
			<th width="10%" class="etiqueta">Codigo</th>
            <th width="12%" class="etiqueta">Fecha</th>
			<th width="30%" class="etiqueta">Novedad</th>
            <th width="30%" class="etiqueta">Trabajador</th>
            <th width="10%" class="etiqueta">Leido</th>
		    <th width="8%" align="center"><img src="imagenes/nuevo.bmp" alt="Agregar Registro" title="Agregar Registro" width="20px" height="20px" border="null"/></th> 
		</tr>
<?php 
$sql = " SELECT nov_mensajeria.codigo, nov_mensajeria.cod_ficha,
                ficha.cedula, CONCAT(ficha.apellidos, ' ',ficha.nombres) AS trabajador,
                novedades.descripcion AS novedades, 
                nov_clasif.descripcion AS nov_clasif,  nov_mensajeria.fecha,
                nov_mensajeria.telefono, nov_mensajeria.descripcion,
                Valores(nov_mensajeria.`status`) AS status,
                CONCAT(men_usuarios.apellido, ' ',men_usuarios.nombre) AS usuario_mod
		   FROM nov_mensajeria LEFT JOIN men_usuarios ON nov_mensajeria.cod_us_mod = men_usuarios.codigo ,
		        novedades , ficha , nov_clasif
          WHERE nov_mensajeria.cod_ficha = ficha.cod_ficha 
		    AND nov_mensajeria.cod_novedad = novedades.codigo 
			AND novedades.cod_nov_clasif = nov_clasif.codigo 
			ORDER BY 1 DESC
			LIMIT 0, 20 ";

		  $query = $bd->consultar($sql);
			 $valor = 0;		
	    while($row02=$bd->obtener_fila($query,0)){
		
		if ($valor == 0){
			$fondo = 'fondo01';
		$valor = 1;
		}else{
			$fondo = 'fondo02';
			$valor = 0;
		}								
		echo'<tr class="'.$fondo.'">
				<td class="texto">'.$row02["codigo"].'</td>
				<td class="texto">'.$row02["fecha"].'</td>
				<td class="texto">'.longitud($row02["novedades"]).'</td>
				<td class="texto">'.longitud($row02["trabajador"]).'</td>
				<td class="texto">'.$row02["status"].'</td>			
				<td class="texto"><a href="'.$vinculo.'&codigo='.$row02['codigo'].'&metodo=agregar_mens"><img src="imagenes/detalle.bmp" alt="Modificar" title="Modificar Registro" width="20px" height="20px" border="null"/></a><a href="'.$vinculo.'&codigo='.$row02['codigo'].'&metodo=mensaje"><img src="imagenes/buscar.bmp" alt="Ver Registro" title="Ver Registro" width="20px" height="20px" border="null"/></a></td>
				</tr>';
		}?>
    </table>   
</div>