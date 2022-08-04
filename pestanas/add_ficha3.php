<?php
$Nmenu = 412;
require_once('autentificacion/aut_verifica_menu.php');
require_once('sql/sql_report_t.php');
$codigo = $_GET['codigo'];
$metodo = $_GET['metodo'];
$mod    = $_GET['mod'];
	$sql    = " SELECT v_ficha.cedula, v_ficha.nombres  FROM v_ficha WHERE v_ficha.cod_ficha = '$codigo' ";
		            $query = $bd->consultar($sql);
            		$row00=$bd->obtener_fila($query,0);

if(isset($_GET['pagina'])){
$pag = $_GET['pagina'];
}else{
$pag = 0;
}
?>
	 <div align="center" class="etiqueta_title">
	 <?php echo " EVENTUALES: ".$row00[1]." (".$codigo.")"; ?>
	 </div>
 <div class="TabbedPanels" id="tp1">
	 <ul class="TabbedPanelsTabGroup">
		<li class="TabbedPanelsTab"> Ficha </li>
 		<li class="TabbedPanelsTab"> Historial Contrato </li>
 		<li class="TabbedPanelsTab"> Dotación </li>
 		<li class="TabbedPanelsTab"> Carga Familiar </li>
 		<li class="TabbedPanelsTab"> Recepción de Documentos </li>
 		<li class="TabbedPanelsTab"> Egreso </li>
    <li class="TabbedPanelsTab"> Huellas </li>
    <li class="TabbedPanelsTab"> Cargar Fotos </li>
	 </ul>
	  <div class="TabbedPanelsContentGroup">
         <div class="TabbedPanelsContent"><?php include('formularios/add_ficha3_01.php');?></div>
				 <div class="TabbedPanelsContent"><?php include("formularios/add_ficha_07.php");?></div>
  	  	 <div class="TabbedPanelsContent"><?php include('formularios/add_ficha_02.php');?></div>
			 <div class="TabbedPanelsContent"><?php include('formularios/add_ficha2_03.php'); ?></div>
		 <div class="TabbedPanelsContent"><?php include('formularios/add_ficha3_04.php');?></div>
		 <div class="TabbedPanelsContent"><?php include('formularios/add_ficha3_05.php');?></div>
          <div class="TabbedPanelsContent"><?php include("formularios/add_ficha_06.php");?></div>
         <div class="TabbedPanelsContent"><?php include('formularios/add_adicionales_trab.php');?></div>
	  </div>
 </div>
<input type="hidden" value="<?php echo $_GET['metodo'];?>" id="metodoX" />

<script language="JavaScript" type="text/javascript">
var tp1 = new Spry.Widget.TabbedPanels("tp1", { defaultTab:<?php echo $pag;?>});
var TabbedPanels = new Spry.Widget.TabbedPanels("TabbedPanels");

var metodo = $( "#metodoX").val();

    if(metodo == 'consultar'){
        $(':selected, :input').prop("disabled", true);
        $('#volver').prop("disabled", false);
        $('#volver04').prop("disabled", false);
        $('#volver05').prop("disabled", false);
    }
    </script>


		<form id="pdf" name="pdf" action="" method="post" target="_blank">
				 <input type="hidden" name="codigo" value="<?php echo $_GET["codigo"]?>">
		</form>
