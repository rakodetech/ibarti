<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require "../".class_bd;
require "../".Leng;


$bd = new DataBase();
//require_once('../autentificacion/aut_config.inc.php');
//include_once('../funciones/mensaje_error.php');

	$Nmenu     = $_POST['Nmenu'];
	$mod       = $_POST['mod'];
	$archivo   = $_POST['archivo'];
	$vinculo   = "inicio.php?area=maestros/Add_$archivo&Nmenu=$Nmenu&mod=$mod&archivo=$archivo";
	$cliente   = $_POST['cliente'];
	$ubicacion = $_POST['ubicacion'];
	$cargo     = $_POST['cargo'];
	$turno     = $_POST['turno'];

	$where = " WHERE pl_plantilla_cliente.cod_cliente = clientes.codigo
                 AND pl_plantilla_cliente.cod_ubicacion  = clientes_ubicacion.codigo
                 AND pl_plantilla_cliente.cod_cargo = cargos.codigo
                 AND pl_plantilla_cliente.cod_turno = turno.codigo ";

	if($cliente != "TODOS"){
		$where  .= " AND clientes.codigo = '$cliente' ";
	}

	if($ubicacion != "TODOS"){
		$where  .= " AND clientes_ubicacion.codigo = '$ubicacion' ";
	}



	if($cargo != "TODOS"){
		$where  .= " AND cargos.codigo = '$cargo' ";
	}

	if($turno != "TODOS"){
		$where  .= " AND turno.codigo = '$turno' ";
	}


	$sql = "  SELECT pl_plantilla_cliente.codigo,
	                 pl_plantilla_cliente.cod_cliente, clientes.nombre AS cliente,
					 clientes.abrev,
                     pl_plantilla_cliente.cod_ubicacion, clientes_ubicacion.descripcion AS ubicacion,
                 	 pl_plantilla_cliente.cod_cargo, cargos.descripcion AS cargo,
                     pl_plantilla_cliente.cod_turno, turno.descripcion AS turno,
					 pl_plantilla_cliente.cantidad,
					 pl_plantilla_cliente.fec_us_mod, pl_plantilla_cliente.fec_us_ing
                FROM pl_plantilla_cliente , clientes , clientes_ubicacion, cargos , turno
               $where
		   ORDER BY 1 DESC";

   $query = $bd->consultar($sql);
?>
<table width="100%" border="0" align="center">
		<tr class="fondo00">
			<th width="20%" class="etiqueta"><?php echo $leng['cliente']?></th>
			<th width="30%" class="etiqueta"><?php echo $leng['ubicacion']?></th>
            <th width="20%" class="etiqueta">Cargo</th>
  			<th width="20%" class="etiqueta">Turno</th>
            <th width="3%" class="etiqueta">Cant.</th>
		    <th width="7%" align="center"><a href="<?php echo $vinculo."&codigo=''&metodo=agregar&codigo=";?>"><img src="imagenes/nuevo.bmp" alt="Agregar Registro" title="Agregar Registro" width="20px" height="20px" border="null"/></a></th>
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
	// $Modificar = "Add_Mod01('".$datos[0]."', 'modificar')";
	//</a>&nbsp;<img src="imagenes/borrar.bmp"  width="20px" height="20px" title="Borrar Registro" border="null" onclick="'.$Borrar.'" class="imgLink"/>
	   $Borrar = "Borrar01('".$datos[0]."')";
        echo '<tr class="'.$fondo.'">
                  <td class="texo">'.$datos["abrev"].'</td>
				  <td class="texo">'.$datos["ubicacion"].'</td>
                  <td class="texo">'.$datos["cargo"].'</td>
				  <td class="texo">'.$datos["turno"].'</td>
				  <td class="texo">'.$datos["cantidad"].'</td>
				  <td align="center"><a href="'.$vinculo.'&codigo='.$datos[0].'&metodo=modificar"><img src="imagenes/actualizar.bmp" alt="Modificar" title="Modificar Registro" width="20" height="20" border="null"/></a>&nbsp;<img src="imagenes/borrar.bmp"  width="20px" height="20px" title="Borrar Registro" border="null" onclick="'.$Borrar.'" class="imgLink"/></td>
            </tr>';
        }
     ;mysql_free_result($query);?>
    </table>
