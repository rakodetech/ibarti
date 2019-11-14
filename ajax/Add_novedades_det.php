<?php 	
$Nmenu        = $_POST['Nmenu']; 
$mod          = $_POST['mod']; 
$usuario      = $_POST['usuario'];
$codigo       = $_POST['cod'];
$proced2      = $_POST['proced2'];

$href         = "";

include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase();

//////  SQL CLIENTES Y NOMINA    //////////

   		   $SQL_PAG = "SELECT nov_procesos_det.observacion AS observacion_det, nov_procesos_det.cod_us_ing, 
	                   CONCAT(men_usuarios.apellido, men_usuarios.nombre) AS usuarios_det, nov_procesos_det.fec_us_ing AS fecha_det,
                       nov_procesos_det.hora AS hora_det, nov_procesos_det.cod_nov_status AS cod_nov_status_det,
					   nov_status.descripcion AS nov_status_det                        
                  FROM nov_procesos_det LEFT JOIN men_usuarios ON nov_procesos_det.cod_us_ing = men_usuarios.codigo, nov_status
                 WHERE nov_procesos_det.cod_nov_proc = '$codigo' 
                   AND nov_procesos_det.cod_nov_status = nov_status.codigo
			  ORDER BY nov_procesos_det.fec_us_ing DESC";										


	$sql   = " SELECT men_usuarios.apellido, men_usuarios.nombre
				 FROM men_usuarios WHERE men_usuarios.codigo = '$usuario'";
	$query = $bd->consultar($sql);
	$row02 = $bd->obtener_fila($query,0);

	?><form id="asistencia_01" name="asistencia_01"  action="scripts/sc_asistencia.php"
                       method="post"><div id="contenedor_listar"><table width="100%" border="0" align="center">	
		<tr class="fondo00">			
            <th width="8%" class="etiqueta">Fecha</th>
			<th width="8%" class="etiqueta">Hora</th>
            <th width="25%" class="etiqueta">Usuario</th>		
			<th width="38%" class="etiqueta">Observacion</th>			
   			<th width="15%" class="etiqueta">Status</th>
			<th width="6%"><img src="imagenes/loading2.gif" width="40px" height="40px"/></th> 
		</tr><?php	echo '<tr class="fondo01">
                        <td><input type="text" name="nov_fecha" id="nov_fecha" size="8" value="'.$date.'"/></td>
                        <td><input type="text" name="nov_hora" id="nov_hora" size="8" value="'.date("H:i:s").'"/></td>
                        <td><input type="text" name="nov_usuario" id="nov_usuario" size="28" 
                                   value="'.$row02[0].'&nbsp;'.$row02[1].'"/></td>
                        <td><textarea  name="observ" id="observ" cols="48" rows="2"></textarea></td>
                        <td><select name="nov_status" id="nov_status" style="width:120px">
                                    <option value="">Selec...</option>';	
                $sql   = "SELECT codigo, descripcion FROM nov_status, control 
                           WHERE status =  'T'
                             AND nov_status.codigo <> control.novedad";							
                $query04 = $bd->consultar($sql); 	
                   while($row04=$bd->obtener_fila($query04,0)){	echo '<option value="'.$row04[0].'">'.$row04[1].'</option>';
                   }echo'</select></td>
        '; ?>				  
			  <td align="center"><span class="art-button-wrapper">
                    <span class="art-button-l"> </span>
                    <span class="art-button-r"> </span>
                 <input type="button" name="submit" id="submit" value="Ingresar" class="readon art-button" onclick="Ingresar()" />	
                </span></td>  
		</tr><?php 	 	
	   $query = $bd->consultar($SQL_PAG);
		$valor = 1;
		$i     = 0;	
		while ($datos=$bd->obtener_fila($query,0)){
		$i++;
		if ($valor == 0){
			$fondo = 'fondo01';
		$valor = 1;
		}else{
			$fondo = 'fondo02';
			$valor = 0;
		}

		 $fechaX  = conversion($fecha);
		 $campo_id = $datos[0];
	echo '<tr class="fondo01">
		                    <td><input type="text" name="nov_fecha" id="nov_fecha" size="8" value="'.$datos["fecha_det"].'"/></td>
							<td><input type="text" name="nov_hora" id="nov_hora" size="8" value="'.$datos["hora_det"].'"/></td>
							<td><input type="text" name="nov_usuario" id="nov_usuario" size="28" 
							           value="'.$datos["usuarios_det"].'"/></td>
							<td><textarea  name="observ" id="observ" cols="48" rows="2">'.$datos["observacion_det"].'</textarea></td>
			  			    <td><select name="nov_status" id="nov_status" style="width:120px">
							            <option value="'.$datos["cod_nov_status_det"].'">'.$datos["nov_status_det"].'</option>	
                                 </select></td>	 
			  <td align="center">&nbsp;</td>  
		</tr>';}
		mysql_free_result($query);?><tr><td colspan="5"><input type="hidden" id="Nmenu" name="Nmenu" value="<?php echo $Nmenu;?>" /><input type="hidden" id="mod" name="mod" value="<?php echo $mod;?>" /><input type="hidden" name="href"  value="../inicio.php?area=<?php echo $href;?>"/><input type="hidden" name="metodo" value="<?php echo $metodo;?>"/><input type="hidden" name="usuario" id="usuario" value="<?php echo $usuario;?>"/><input type="hidden"  id="i" value="<?php echo $i;?>"/><input type="hidden" name="proced2" id="proced2" value="<?php echo $proced2;?>"/></td></tr></table></div></form>           