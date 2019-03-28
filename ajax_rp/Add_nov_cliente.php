<?php
include_once "../funciones/funciones.php";
require "../autentificacion/aut_config.inc.php";
require "../".class_bd;
require "../".Leng;
$bd = new DataBase();

$Nmenu      = $_POST['Nmenu'];
$mod        = $_POST['mod'];
$archivo    = $_POST['archivo']."&Nmenu=$Nmenu&mod=$mod";
$vinculo    = "reportes/rp_nov_check_list_printer.php?Nmenu=$Nmenu&mod=$mod";

$novedades       = $_POST['novedades'];
$clasif          = $_POST['clasif'];
$tipo            = $_POST['tipo'];
$cliente         = $_POST['cliente'];
$ubicacion       = $_POST['ubicacion'];

	$where = " WHERE nov_cl_ubicacion.cod_cl_ubicacion = clientes_ubicacion.codigo
                 AND clientes_ubicacion.cod_cliente = clientes.codigo
                 AND nov_cl_ubicacion.cod_novedad = novedades.codigo
                 AND novedades.cod_nov_clasif = nov_clasif.codigo
                 AND novedades.cod_nov_tipo = nov_tipo.codigo ";

	if($novedades != "TODOS"){
		$where  .= " AND novedades.codigo = '$novedades' ";
	}

	if($clasif != "TODOS"){
		$where .= " AND nov_clasif.codigo = '$clasif' ";
	}


	if($tipo != "TODOS"){
		$where  .= " AND nov_tipo.codigo = '$tipo' ";
	}

	if($cliente != "TODOS"){
		$where  .= " AND clientes.codigo = '$cliente' ";
	}

	if($ubicacion != "TODOS"){
		$where  .= " AND clientes_ubicacion.codigo = '$ubicacion' ";
	}

	// QUERY A MOSTRAR //
		  	$sql = "SELECT novedades.codigo, novedades.descripcion AS novedades,
                           nov_clasif.descripcion AS clasif, nov_tipo.descripcion AS tipo,
						   clientes.abrev, clientes.nombre, clientes_ubicacion.descripcion
                      FROM nov_cl_ubicacion, clientes_ubicacion, clientes, novedades , nov_clasif, nov_tipo
					       $where
                  ORDER BY 3 ASC ";


   $query = $bd->consultar($sql);
?><table width="100%" align="center">
   <tr class="fondo00">
			<th width="8%" class="etiqueta">codigo</th>
            <th width="20%" class="etiqueta">Novedad</th>
			<th width="18%" class="etiqueta">Clasificacion</th>
       		<th width="18%" class="etiqueta">Tipo</th>
  			<th width="16%" class="etiqueta"><?php echo $leng['cliente']?></th>
            <th width="18%" class="etiqueta"><?php echo $leng['ubicacion']?></th>
	   </tr>
    <?php
	$valor = 0;
		while ($datos=$bd->obtener_fila($query,0)){
		if ($valor == 0){
			$fondo = 'fondo01';
		$valor = 1;
		}else{
			$fondo = 'fondo02';
			$valor = 0;
		}

	   $Borrar = "Borrar01('".$datos[0]."')";
        echo '<tr class="'.$fondo.'">
                  <td class="texo">'.$datos[0].'</td>
				  <td class="texo">'.longitudMax($datos[1]).'</td>
                  <td class="texo">'.longitudMin($datos[2]).'</td>
				  <td class="texo">'.longitudMin($datos[3]).'</td>
				  <td class="texo">'.longitudMin($datos[4]).'</td>
				  <td class="texo">'.longitudMin($datos[6]).'</td>
            </tr>';
        }
	?>
     </table>
