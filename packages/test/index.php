
<script type="text/javascript" src="packages/test/controllers/testCtrl.js"></script>

<?php
$Nmenu = '714';
if(isset($_SESSION['usuario_cod'])){
	require_once('autentificacion/aut_verifica_menu.php');
	$us = $_SESSION['usuario_cod'];
}else{
	$us = $_POST['usuario'];
}
?>

<div id="Cont_test"></div>
<input name="usuario" id="usuario" type="hidden" value="<?php echo $us;?>" />