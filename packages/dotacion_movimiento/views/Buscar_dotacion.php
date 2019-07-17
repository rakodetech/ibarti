<?php

require "../model/dotacion_modelo.php";

$listado      = new dotaciones;
$vista        = isset($_POST['view']) ? $_POST['view'] : '';
if ($vista == "clo") {
  $titulo = "Recepcion De Lotes Operaciones";
  $agregar = "<th width='6%' align='center'></th>";
  $cantidad = $listado->obtener_procesos('almacen',$vista);
}

if($vista=="vla"){
  $titulo = "Consulta De Lotes Almacen";
  $agregar = '<th width="6%" align="center"><img src="imagenes/nuevo.bmp" alt="Agregar" onclick="cons_inicio(\'vista_dotacion\', \'agregar\')" title="Agregar Registro" width="30px" height="30px" border="null"/></th>';
  $cantidad = $listado->obtener_procesos('almacen',$vista);
}

if($vista=="vlo"){
  $titulo = "Consulta De Lotes Operaciones";
  $agregar = '<th width="6%" align="center"><img src="imagenes/nuevo.bmp" alt="Agregar" onclick="cons_inicio(\'vista_recepcion\', \'agregar\')" title="Agregar Registro" width="30px" height="30px" border="null"/></th>';
  $cantidad = $listado->obtener_procesos('operaciones',$vista);
}

if ($vista == "cla") {
  $titulo = "Recepcion De Lotes Almacen";
  $agregar = "<th width='6%' align='center'></th>";
  $cantidad = $listado->obtener_procesos('operaciones',$vista);
}


?>

<div align="center" class="etiqueta_title"> <?php echo $titulo; ?> </div>
<hr />
<div class="tabla_sistema listar"><table width="100%" border="0" align="center">
    <tr>
      <th width="10%">Codigo</th>
      <th width="30%" style="max-width: 150px;">Observación</th>
      <th width="15%">Fecha</th>
      <th width="25%">Usuario Mod.</th>
      <th width="10%">Status</th>
      <th width="10%">Anulado</th>
      <?php echo $agregar; ?>
    </tr>
    <?php
    foreach ($cantidad as  $datos) {
      if($vista=="clo"){
        $contenido = '<tr title="Seleccione para ver detalles" onclick="llenar_consulta(\'' . $datos["codigo"] . '\',\''.$vista.'\', \'\')">';
      }
      
      if($vista=="vla"){
        $contenido = '<tr title="Seleccione para ver detalles" onclick="llenar_consulta(\'' . $datos["codigo"] . '\',\'vista_dotacion\', \'\')">';
      }

      if($vista=="vlo"){
        $contenido = '<tr title="Seleccione para ver detalles" onclick="llenar_consulta(\'' . $datos["codigo"] . '\',\'vista_recepcion\', \'\')">';
      }
      
      if($vista=="cla"){
        $contenido = '<tr title="Seleccione para ver detalles" onclick="llenar_consulta(\'' . $datos["codigo"] . '\',\''.$vista.'\', \'\')">';
      }

      $contenido.='
      <td>' . $datos["codigo"] . '</td>
      <td style="max-width: 200px; overflow: hidden;
                text-overflow: ellipsis; white-space: nowrap;">'
                 . $datos["observacion"] . '</td>
      <td>' . $datos["fecha"] . '</td>
      <td>' . $datos["nombre"] . '</td>
      <td>' . $datos["estatus"] . '</td>
      <td>' . $datos["anulado"] . '</td>
      <td></td></tr>';
      echo $contenido;
    }
    ?>
  </table>
</div>