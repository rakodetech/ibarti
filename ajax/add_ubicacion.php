<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase(); 

$codigo  = $_POST['codigo'];
$usuario = $_POST['usuario'];
$i       = $_POST['i'];

    $sql = "SELECT clientes_ubicacion.codigo, clientes_ubicacion.descripcion AS ubicacion
              FROM usuario_clientes , clientes_ubicacion
             WHERE usuario_clientes.cod_usuario = '$usuario' 
               AND usuario_clientes.cod_ubicacion = clientes_ubicacion.codigo  
               AND clientes_ubicacion.cod_cliente = '$codigo'
               AND clientes_ubicacion.`status` = 'T'
          ORDER BY 2 ASC";
   $query = $bd->consultar($sql);

	echo'<select name="ubicacion" id="ubicacion'.$i.'" style="width:120px" onchange="spryValidarSelect(this.id), Concepto(\''.$i.'\', this.value)" required> 
         <option value="">Seleccione...</option>';
    while($row02=$bd->obtener_fila($query,0)){
			echo '<option value="'.$row02[0].'">'.$row02[1].'</option>';
	}
	 echo'</select>';
	 mysql_free_result($query);
?>