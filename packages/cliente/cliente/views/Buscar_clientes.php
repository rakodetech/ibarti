<?php
$data = $_POST['data'];
$filtro = $_POST['filtro'];

require "../modelo/cliente_modelo.php";
$cliente = new Cliente;

$lista_clientes = $cliente->buscar_cliente($data, $filtro);

if($lista_clientes){
foreach ($lista_clientes as  $datos) {
	echo '<tr onclick="Cons_cliente(\''.$datos[0].'\', \'modificar\')" title="Click para Modificar..">
    <td>'.$datos["codigo"].'</td>
    <td>'.$datos["rif"].'</td>
    <td>'.$datos["nombre"].'</td>
    <td>'.$datos["region"].'</td>
    <td>'.statuscal($datos["status"]).'</td>
    </tr>';
}
}else{
	echo '';
}
?>