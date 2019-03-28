<?php
include_once "../funciones/funciones.php";
require "../autentificacion/aut_config.inc.php";
require "../".class_bd;
require "../".Leng;
$bd = new DataBase();


$rol          = $_POST['rol'];
$contrato          = $_POST['contrato'];
$estado          = $_POST['estado'];
$ciudad          = $_POST['ciudad'];
$cargo           = $_POST['cargo'];
$cedula          = $_POST['cedula'];
$status          = $_POST['status'];

$trabajador      = $_POST['trabajador'];


	$where = "  WHERE  v_ficha.cod_ficha =  v_ficha.cod_ficha ";

	if($contrato != "TODOS"){
		$where .= " AND v_ficha.cod_contracto = '$contrato' ";  // cambie AND asistencia.co_cont = '$contracto'
	}

	if($rol != "TODOS"){
		$where .= " AND v_ficha.cod_rol = '$rol' ";  // cambie AND asistencia.co_cont = '$contracto'
	}

	if($estado != "TODOS"){
		$where .= " AND v_ficha.cod_estado = '$estado' ";  // cambie AND asistencia.co_cont = '$contracto'
	}

	if($estado != "TODOS"){
		$where .= " AND v_ficha.cod_estado = '$estado' ";  // cambie AND asistencia.co_cont = '$contracto'
	}

	if($ciudad != "TODOS"){
		$where .= " AND  v_ficha.cod_ciudad = '$ciudad' ";  // cambie AND asistencia.co_cont = '$contracto'
	}

	if($cargo != "TODOS"){
		$where  .= " AND  v_ficha.cod_cargo = '$cargo' ";
	}

	if($status != "TODOS"){
		$where  .= " AND  v_ficha.cod_ficha_status = '$status' ";
	}

	if($trabajador != NULL){
		$where  .= " AND  v_ficha.cod_ficha = '$trabajador' ";
	}



	$sql = " SELECT  v_ficha.rol,    v_ficha.estado,
			         v_ficha.ciudad, v_ficha.cargo,
				     v_ficha.cedula, v_ficha.ap_nombre ,
					 v_ficha.status
               FROM  v_ficha
		      $where
			  ORDER BY 1 ASC
			  LIMIT 0, 1000   ";


	// QUERY A MOSTRAR //

   $query = $bd->consultar($sql);
?><table width="100%" border="0" align="center">
		<tr class="fondo00">


            <th width="20%" class="etiqueta"><?php echo $leng['estado']?></th>
            <th width="20%" class="etiqueta">Cargo </th>
            <th width="10%" class="etiqueta"><?php echo $leng['ci']?> </th>
            <th width="30%" class="etiqueta"><?php echo $leng['trabajador']?></th>
            <th width="20%" class="etiqueta"><?php echo $leng['ci']?></th>
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

	$filename = "../imagenes/cedula/".$datos["cedula"].".jpg";

	if($cedula == "TODOS"){
		$imprimir = "SI";

	}elseif($cedula == "S"){
	  if (file_exists($filename)) {
 		$imprimir = "SI";
		}else {
		$imprimir = "NO";
		}

	}elseif($cedula == "N"){
	  if (file_exists($filename)) {
 		$imprimir = "NO";
		}else{
		$imprimir = "SI";
		}
	}else{
		$imprimir = "NO";
	}

		if($imprimir == "SI"){
        echo '<tr class="'.$fondo.'">
			      <td class="texto">'.$datos["estado"].'</td>
				  <td class="texto">'.$datos["cargo"].'</td>
				  <td class="texto">'.$datos["cedula"].'</td>
				  <td class="texto">'.longitud($datos["ap_nombre"]).'</td>';
				$filename = "imagenes/cedula/".$datos["cedula"].".jpg";
		  echo "<td><a href='".$filename."'><img src='".$filename."' border='0' width='60' height='45' alt='SIN CEDULA' /></a></td>";
          echo  '</tr>';
        	}
		};?>
    </table>
