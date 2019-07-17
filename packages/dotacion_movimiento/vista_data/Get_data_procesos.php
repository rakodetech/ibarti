<?php

require "../model/dotacion_modelo.php";

$listado      = new dotaciones;

$vista        = isset($_POST['view']) ? $_POST['view'] : '';
$codigo       = isset($_POST['filtro_codigo']) ? $_POST['filtro_codigo'] : '';
$fecha_d       = isset($_POST['f_d']) ? $_POST['f_d'] : '';
$fecha_h       = isset($_POST['f_h']) ? $_POST['f_h'] : '';
$status       = isset($_POST['filtro_status']) ? $_POST['filtro_status'] : '';
if ($vista == "clo") {
  $titulo = "Recepcion De Lotes Operaciones";
  $agregar = "<th width='6%' align='center'></th>";
  $cantidad = $listado->obtener_procesos('almacen', $vista,$fecha_d,$fecha_h,$codigo,$status);
}

if ($vista == "vla") {
  $titulo = "Consulta De Lotes Almacen";
  $agregar = '<th width="6%" align="center"><img src="imagenes/nuevo.bmp" alt="Agregar" onclick="cons_inicio(\'vista_dotacion\', \'agregar\')" title="Agregar Registro" width="30px" height="30px" border="null"/></th>';
  $cantidad = $listado->obtener_procesos('almacen',  $vista,$fecha_d,$fecha_h,$codigo,$status);
}

if ($vista == "vlo") {
  $titulo = "Consulta De Lotes Operaciones";
  $agregar = '<th width="6%" align="center"><img src="imagenes/nuevo.bmp" alt="Agregar" onclick="cons_inicio(\'vista_recepcion\', \'agregar\')" title="Agregar Registro" width="30px" height="30px" border="null"/></th>';
  $cantidad = $listado->obtener_procesos('operaciones',  $vista,$fecha_d,$fecha_h,$codigo,$status);
}

if ($vista == "cla") {
  $titulo = "Recepcion De Lotes Almacen";
  $agregar = "<th width='6%' align='center'></th>";
  $cantidad = $listado->obtener_procesos('operaciones',  $vista,$fecha_d,$fecha_h,$codigo,$status);
}

echo  json_encode($cantidad);
