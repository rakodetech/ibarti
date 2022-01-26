<link rel="stylesheet" href="css/modal_planif.css" type="text/css" media="screen" />
<?php
$Nmenu = '703';
if (isset($_SESSION['usuario_cod'])) {
	require_once('autentificacion/aut_verifica_menu.php');
	$us = $_SESSION['usuario_cod'];
} else {
	$us = $_POST['usuario'];
}
?>
<div id="myModal" class="modal">
	<div class="modal-content">
		<div class="modal-header">
			<span class="close" onclick="CloseModal()">&times;</span>
			<span id="modal_titulo"></span>
		</div>
		<div class="modal-body">
			<div id="modal_contenido">
				<br>
				<span style="float: right; padding-left: 10px;" align="center">
					Filtro: <input id="filtro" type="text" style="width:180px" onkeyup="buscar(this.value)" />
				</span>
				<br>
				<br>
				<br>
				<table width="95%" align="modal_contenido" class="tabla_planif">
					<thead>
						<tr>
							<th>Código</th>
							<th>Linea</th>
							<th>Descripcion</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody id="contenido_tabla">

					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div id="Cont_prod_sub_linea"></div>
<input name="usuario" id="usuario" type="hidden" value="<?php echo $_SESSION['usuario_cod']; ?>" />
<script type="text/javascript" src="funciones/modal.js"></script>
<script type="text/javascript" src="packages/inventario/sub_linea/controllers/productoSubLinea.js"></script>