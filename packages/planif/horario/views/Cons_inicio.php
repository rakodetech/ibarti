<?php
  require "../modelo/horario_modelo.php";
  require "../../../../".Leng;
  $titulo = $leng['horario'];
  $horario = new Horario;
  $matriz  =  $horario->get();
?>

<div align="center" class="etiqueta_title"> Consulta De <?php echo $titulo;?> </div> <hr />
<div class="tabla_sistema"><table width="100%" border="0" align="center">

		<tr>
			<th width="10%">Codigo</th>
			<th width="25%">Nombre</th>
      <th width="12%">Hora Entrada</th>
      <th width="12%">Hora Salida</th>
      <th width="12%">Inicio Marcaje<br />Entrada</th>
      <th width="12%">Fin Marcaje<br />Entrada</th>
      <th width="12%">Status</th>
  	  <th width="5%" align="center"><img src="imagenes/nuevo.bmp" alt="Agregar" onclick="Cons_horario('', 'agregar')" title="Agregar Registro" width="30px" height="30px" border="null"/></th>
		</tr>
    <?php
    foreach ($matriz as  $datos){
      echo '<tr>
         <td>'.$datos["codigo"].'</td>
			   <td>'.longitud($datos["nombre"]).'</td>
			   <td>'.$datos["hora_entrada"].'</td>
			   <td>'.$datos["hora_salida"].'</td>
			   <td>'.$datos["inicio_marc_entrada"].'</td>
			   <td>'.$datos["fin_marc_entrada"].'</td>
			  <td>'.statuscal($datos["status"]).'</td>
			  <td><img src="imagenes/actualizar.bmp" onclick="Cons_horario(\''.$datos[0].'\', \'modificar\')" alt="Modificar" title="Modificar Registro" width="20" height="20" border="null"/></a>&nbsp;<img src="imagenes/borrar.bmp"  width="20px" height="20px" title="Borrar Registro" border="null" onclick="Borrar_horario(\''.$datos[0].'\')"/></td></tr>';
    }?>
    </table>
</div>
