<?php
require "../modelo/vetados_modelo.php";
require "../../../../".Leng;
$titulo = 'Vetados';
$cliente = $_POST['cliente'];
$vetados = new Vetado;
$matriz  =  $vetados->get($cliente);
?>

<div align="center" class="etiqueta_title"> Consulta De <?php echo $titulo;?> </div> <hr />
<div class="tabla_sistema">
  <table width="100%" border="0" align="center">
    <tr>
      <th><?php echo $leng['ficha']; ?></th>
      <th><?php echo $leng['trabajador']; ?></th>
      <th><?php echo $leng['ubicacion']; ?></th>
      <th>Fecha Desde</th>
      <th><img src="imagenes/nuevo.bmp" alt="Agregar Vetado" onclick="Add_vetado($('#cont_cliente').val(),'agregar')" title="Agregar Registro" width="30px" height="30px" border="null"/></th>
    </tr>
    <?php
    foreach ($matriz as  $datos) {
      echo '<tr>
      <td>'.$datos["cod_ficha"].'</td>
      <td>'.longitudMax($datos["ap_nombre"]).'</td>
      <td>'.$datos["ubicacion"].'</td>
      <td>'.$datos["fec_us_ing"].'</td>
      <td><img src="imagenes/consultar.png" onclick="Cons_vetado(\''.$datos['cod_ficha'].'\',\''.$datos["cod_ubicacion"].'\',\'consultar\')" alt="Consultar" title="Consultar" width="20" height="20" border="null"/>&nbsp;
      <img src="imagenes/actualizar.bmp" onclick="Cons_vetado(\''.$datos['cod_ficha'].'\',\''.$datos["cod_ubicacion"].'\',\'modificar\')" alt="Modificar" title="Modificar Registro" width="20" height="20" border="null"/>&nbsp;
      <img src="imagenes/borrar.bmp"  width="20px" height="20px" title="Borrar Vetado" border="null" onclick="Borrar_vetado(\''.$datos["cod_ficha"].'\',\''.$datos["cod_ubicacion"].'\')"/></td></tr>';
    }
    ?>
  </table>
</div>
