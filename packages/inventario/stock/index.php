
<script type="text/javascript" src="packages/inventario/stock/controllers/existenciaCtrl.js"></script>

<?php
$Nmenu = '473';
if(isset($_SESSION['usuario_cod'])){
	require_once('autentificacion/aut_verifica_menu.php');
	$us = $_SESSION['usuario_cod'];
}else{
	$us = $_POST['usuario'];
}
?>

<div id="Cont_existencia"></div>
<input name="usuario" id="usuario" type="hidden" value="<?php echo $us;?>" />