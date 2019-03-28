<link rel="stylesheet" href="css/modal_planif.css" type="text/css" media="screen" />

<?php
	$Nmenu = '472';
	if(isset($_SESSION['usuario_cod'])){
		require_once('autentificacion/aut_verifica_menu.php');
		$us = $_SESSION['usuario_cod'];
	}else{
		$us = $_POST['usuario'];
	}
?>

<div id="Cont_movimiento"></div>
<input name="usuario" id="usuario" type="hidden" value="<?php echo $us;?>" />

<script type="text/javascript" src="packages/inventario/movimiento/controllers/movimientoCtrl.js"></script>
<script type="text/javascript" src="funciones/modal.js"></script>
