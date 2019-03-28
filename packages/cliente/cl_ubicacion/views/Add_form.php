<link rel="stylesheet" href="css/pestanas.css" type="text/css" media="screen" />
<script type="text/javascript" src="funciones/pestanas.js"></script>
<?php
require "../modelo/ubicacion_modelo.php";
require "../../../general/modelo/general_modelo.php";
require "../../../../".Leng;
$ubicacion = new Ubicacion;
$general   = new General;

$metodo = $_POST['metodo'];
$titulo = " ".$leng['cliente'] ." ".$leng['ubicacion']."";
$codigo = $_POST['codigo'];
$cliente = $_POST['cliente'];
$proced      = "p_clientes_ubic";

if($metodo == 'modificar')
{
	$titulo   = "Modificar ".$leng['ubicacion'];
	$ubic     =  $ubicacion->editar("$codigo");
}else{
	$titulo    = "Agregar ".$leng['ubicacion'];
	$ubic      =  $ubicacion->inicio();
}

$region     = $general->get_region($ubic['cod_region']);
$estado     = $general->get_estado($ubic['cod_estado']);
$ciudad     = $general->get_ciudad($ubic['cod_ciudad'],$ubic['cod_estado']);
$calendario = $general->get_calendario($ubic['cod_calendario']);
$zona       = $general->get_zona($ubic['cod_zona']);
?>
<div class="tab">
  <button class="tablinks" onclick="openTap(0)"><?php echo $leng['ubicacion']?></button>
  <button class="tablinks" onclick="openTap(1)">Datos Adiccionales</button>
  <button class="tablinks" onclick="openTap(2)">Puesto de Trabajo</button>
  <button class="tablinks" onclick="openTap(3)">Capta Huella</button>
</div>
<div class="tabcontent" id="tab_cont01">
<?php  include('p_ubic.php');?>
</div>
<div class="tabcontent" id="tab_cont02">
<?php include('p_ubic_ad.php');?>
</div>
<div class="tabcontent" id="tab_cont03">
  <?php if($metodo== "modificar"){
      include('../../cl_ubic_puesto/index.php'); }?>
</div>
<div class="tabcontent" id="tab_cont03">
  <?php if($metodo== "modificar"){
      include('p_ubic_ch.php'); }?>
</div>
