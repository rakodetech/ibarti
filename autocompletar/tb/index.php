<div class="etiqueta_title" align="center">Conceptos Para la carga de Asistencia </div>
<table width="600px" border="0" align="center"> 
         <tr> 
    	       <td height="8" colspan="3"  align="center"><hr></td>    
     	</tr>
  <tr class="etiqueta_title">
    <td class="fondo02">Abreviatura	</td>
    <td class="fondo02">Descripci&oacute;n	</td>
    <td class="fondo02">Observaci&oacute;n</td>    
  </tr>
  <?php 
	$bd = new DataBase();
	$sql = " SELECT conceptos.codigo, conceptos.descripcion,  conceptos.abrev FROM conceptos
              WHERE `status` = 'T' ORDER BY 2 ASC ";
	$query = $bd->consultar($sql);
	$row01=$bd->obtener_fila($query,0);  
	
			
		$fondo = "";
		$fondo01 = 'class="fondo01"';
		$fondo02 = 'class="fondo02"';
		
        while($row01=$bd->obtener_fila($query,0)){

			if ($fondo == $fondo02){
				$fondo = $fondo01;
				}else{
				$fondo = $fondo02;
				}
		 echo "<tr><td ".$fondo.">".utf8_decode($row01[1])."</td><td ".$fondo.">".utf8_decode($row01[2])."</td>
		 <td ".$fondo.">&nbsp;</td></tr>";		
		}
		echo "</table>";
  ?>	