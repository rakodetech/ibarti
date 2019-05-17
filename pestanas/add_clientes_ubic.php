<link rel="stylesheet" href="css/pestanas.css" type="text/css" media="screen" />

<script type="text/javascript" src="funciones/pestanas.js"></script>
</script>
<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require "../".class_bd;
require "../".Leng;

$metodo = $_POST['metodo'];
$titulo = " ".$leng['cliente'] ." ".$leng['ubicacion']."";
$cliente = $_POST['cliente'];
$codigo = $_POST['codigo'];
$archivo = "";

?>
<div class="tab">
  <button class="tablinks" onclick="openTap(0)"><?php echo $leng['ubicacion']?></button>
  <button class="tablinks" onclick="openTap(1)">Datos Adiccionales</button>
  <button class="tablinks" onclick="openTap(2)">Puesto de Trabajo</button>
  <button class="tablinks" onclick="openTap(3)">Capta Huella</button>
</div>

<div class="tabcontent" id="tab_cont01">

<?php  include('../formularios/add_clientes_ubic.php');?>
</div>
<div class="tabcontent" id="tab_cont02">


<?php include('../formularios/add_cl_ubic_ad.php');?>

</div>
<div class="tabcontent" id="tab_cont03">
  <?php if($metodo== "modificar"){
      include('../formularios/Cons_cl_ubic_puesto.php'); }?>
</div>

<div class="tabcontent" id="tab_cont03">
  <?php if($metodo== "modificar"){
      include('../formularios/add_cl_ubic_ch.php'); }?>
</div>


  <?php //     include('../formularios/add_cl_ubic_puesto.php'); }?>
