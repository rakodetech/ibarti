<link rel="stylesheet" href="css/modal_planif.css" type="text/css" media="screen" />
<script type="text/javascript" src="funciones/modal.js"></script>

<?php
$Nmenu = '471';
if(isset($_SESSION['usuario_cod'])){
	require_once('autentificacion/aut_verifica_menu.php');
	$us = $_SESSION['usuario_cod'];
}else{
	$us = $_POST['usuario'];
}
?>

<div id="myModal" class="modal">
	<div class="modal-content">
		<div class="modal-header">
			<span class="close" onclick="CloseModal()" >&times;</span>
			<span id="modal_titulo"></span>
		</div>
		<div class="modal-body">
			<div id="modal_contenido">
					<br>
					<div align="center" class="etiqueta_title">Ingrese la Descripcion(Motivo de la Anulación)</div>
					<br>
					<div align="center"><textarea id="ped_descripcion_anular" required  cols="70" rows="3"></textarea></div>
					<br>
					<hr />
					<div align="center">
						<span class="art-button-wrapper">
							<span class="art-button-l"> </span>
							<span class="art-button-r"> </span>
							<input type="button" title="Anular Ajuste" class="readon art-button"  value="Anular" onclick="anular()" />
						</span>
						<span class="art-button-wrapper">
							<span class="art-button-l"> </span>
							<span class="art-button-r"> </span>
							<input type="button" title="Cancelar" class="readon art-button"  value="Cancelar" 
							onclick="CloseModal()" />
						</span>
					</div>
			</div>
		</div>
	</div>
</div>

<div id="Cont_ajuste"></div>
<input name="usuario" id="usuario" type="hidden" value="<?php echo $us;?>" />

<script type="text/javascript" src="packages/inventario/ajuste/controllers/ajusteCtrl.js"></script>


