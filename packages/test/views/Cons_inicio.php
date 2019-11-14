<?php
  require "../modelo/test_modelo.php";
  require "../../../".Leng;
  $titulo = "Test";
  $test = new Test;
  $matriz  =  $test->get();
?>

<div align="center" class="etiqueta_title"> Consulta De <?php echo $titulo;?> </div> <hr />
<div class="tabla_sistema"><table width="100%" border="0" align="center">

		<tr>
			<th width="10%">id</th>
			<th width="75%">Descripción</th>
      <th width="10%">Estado</th>
  	  <th width="5%" align="center"><img src="imagenes/nuevo.bmp" alt="Agregar" onclick="Cons_test('', 'agregar')" title="Agregar Registro" width="30px" height="30px" border="null"/></th>
		</tr>
    <?php
    foreach ($matriz as  $datos){
      echo '<tr>
			   <td>'.$datos["id"].'</td>
			   <td>'.$datos["descripcion"].'</td>
			   <td colspan="2">'.statuscal($datos["estado"]).'</td></tr>';
    }?>
    </table>
</div>
