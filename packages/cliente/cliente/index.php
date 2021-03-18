<link rel="stylesheet" href="css/modal.css" type="text/css" media="screen" />
<!-- <script type="text/javascript" src="funciones/modal.js"></script> -->
<script type="text/javascript" src="packages/cliente/cliente/controllers/clienteCtrl.js"></script>
<?php
$Nmenu = '436';
if (isset($_SESSION['usuario_cod'])) {
	require_once('autentificacion/aut_verifica_menu.php');
	$us = $_SESSION['usuario_cod'];
} else {
	$us = $_POST['usuario'];
}
?>
<div id="Cont_cliente">
</div>
<input name="usuario" id="usuario" type="hidden" value="<?php echo $us; ?>" />