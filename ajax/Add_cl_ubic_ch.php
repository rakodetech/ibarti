<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase(); 
$codigo      = $_POST['codigo'];
	   $sql01 =	" SELECT clientes_ub_ch.cod_capta_huella
                    FROM clientes_ub_ch
                   WHERE clientes_ub_ch.cod_cl_ubicacion = '$codigo' ";
?>	<table width="50%" border="0" align="center">
			<tr class="fondo01">
			<th width="60%" class="etiqueta">Codigo Capta Huella</th>
		    <th width="10%"><img src="imagenes/loading2.gif" alt="Agregar Registro" width="40" height="40" 
			                     title="Agregar Registro" border="null" class="imgLink"/></th>
                  <th width="10%">&nbsp;</th>
 		</tr>
		<tr class="fondo02">
			<input type="hidden" id="codigo_ubic" name="codigo_ubic" style="width:90px" 
                                     value="<?php echo $codigo;?>"   readonly="readonly" />
			<td id="input02_3"><input type="text" id="codigo_capta" name="codigo_capta" style="width:250px" maxlength="20"/>
            <input type="hidden" id="codigo_capta_old" name="codigo_capta_old"/></td>
			<td><span class="art-button-wrapper">
                    <span class="art-button-l"> </span>
                    <span class="art-button-r"> </span>
                    <input type="button"  name="submit" id="submit" value="Agregar"  class="readon art-button" 
                           onclick=" validarCampo('', 'agregar')"/>
             </span></td>
		 </tr>		
		 <tr><td colspan="2" class="etiqueta_title">Listado</td></tr>
    <?php       
        $query = $bd->consultar($sql01); 		   
        $i =0;
        $valor = 0;
  		while($datos=$bd->obtener_fila($query,0)){	
		$i++;
			if ($valor == 0){
				$fondo = 'fondo01';
				$valor = 1;
			}else{
				 $fondo = 'fonddo02';
				 $valor = 0;
			}
			$modificar = 	 "'".$i."', 'modificar'";				 
			$borrar    = 	 "'".$i."', 'eliminar' ";
        echo '<tr class="'.$fondo.'"> 
                  <input type="hidden" id="codigo_ubic'.$i.'" style="width:90px"  value="'.$codigo.'"/>
				  
                  <td><input type="text" id="codigo_capta'.$i.'" disabled style="width:250px" maxlength="20" 
				             value="'.$datos['cod_capta_huella'].'"/><input type="hidden" id="codigo_capta_old'.$i.'"
				             value="'.$datos['cod_capta_huella'].'"/></td>
		  </td><td align="center">
		  <img src="imagenes/borrar.bmp" alt="Detalle" title="Borrar Registro" width="25" height="25" border="null" 
			   onclick="Borrar('.$borrar.')" class="imgLink" /> 		   
		  </td> 								
	</tr>'; 
        } mysql_free_result($query);?>
	</table>