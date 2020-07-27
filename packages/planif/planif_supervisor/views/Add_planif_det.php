<?php
require "../modelo/planificacion_modelo.php";
require "../../../../".Leng;

$result = array();

$plan  = new Planificacion;
if(isset($_POST['codigo'])){
$apertura  = $_POST['codigo'];
$cliente  = $_POST['cliente'];
$trab  = $plan->get_planif_det($apertura, $cliente);
$mod  = $plan->get_ultima_mod($apertura, $cliente);
$fechas = $plan->get_fechas_apertura($apertura, $cliente);

$supervisores = $plan->get_supervisores($cliente);
$result['html'] = '</br><div align="center" class="etiqueta_title">Planificacion Detalle</div>
<div align="right"><span class="etiqueta">Ultima Modificacion: </span> '.$mod["fecha"].' ('.$mod["us_mod"].')</div>
<div align="right"><span class="etiqueta">Nro. de Supervisores sin planificar en este cliente: <h6 id="cantidad_sin_planif"></h6></div>
<div id="wrap">

<div id="supervisor-wrap" class="scroll">
<div id="external-events">
<h4>Supervisores:</h4>

<div id="external-events-list">';

foreach ($supervisores as  $datos) {
	$result['html'] .= '<div class="fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event" cod_ficha="'.$datos[0].'" cedula="'.$datos[5].'">
	  <div class="fc-event-main">'. $datos[0].' - '.$datos[5].'<br>'.$datos[1].'</div>
	</div>';
} 

$result['html'] .= '</div></div></div><div id="calendar-wrap"> <div id="calendar"></div></div></div>';

$result["data"] = $trab;
$result["fechas"] = $fechas;
}else{
	$ubicacion  = $_POST['ubicacion'];
	$cliente  = $_POST['cliente'];
	$fecha_desde  = $_POST['fecha_desde'];
	$fecha_hasta  = $_POST['fecha_hasta'];
	$result  = $plan->get_planif_det_rp($fecha_desde, $fecha_hasta, $cliente, $ubicacion);
}
print_r(json_encode($result));
return json_encode($result);
?>
