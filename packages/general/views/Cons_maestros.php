<?php
require "../modelo/general_modelo.php";
$modelo = new General;
$tabla = $_POST['tb'];
$data = $_POST['data'];
$titulo = $_POST['titulo'];
$maestros  =  $modelo->buscar($tabla,$data);
if($maestros){
	foreach ($maestros as  $datos) {
		echo '<tr class="color" onclick="Cons_maestro(\''.$datos["codigo"].'\', \'modificar\',\''.$tabla.'\',\''.$titulo.'\')" title="Click para Modificar.."> 
		<td class="texto">'.$datos["codigo"].'</td>
		<td class="texto">'.$datos["descripcion"].'</td>
		<td class="texto">'.$datos["status"].'</td>
		</tr>';
	}
}else{
	echo '<tr > 
	<td class="texto" colspan="3">Sin Resultados..</td>
	</tr>';
}
?>