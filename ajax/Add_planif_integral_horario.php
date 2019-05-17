<?php
	include_once('../funciones/funciones.php');
	require "../autentificacion/aut_config.inc.php";
	require "../".class_bd;
	require "../".Leng;
	$bd = new DataBase();

	$periodo     = $_POST["codigo"];
	$cliente     = $_POST["cliente"];
	$ubicacion   = $_POST["ubicacion"];
	$usuario     = $_POST["usuario"];

	  $proced    = "p_planif_integral_horario";

		$sql   = "$SELECT $proced('$periodo', '$cliente', '$ubicacion','$usuario')";
	  $query = $bd->consultar($sql);

	$where = " WHERE a.periodo = '$periodo'
           	   AND a.cod_cliente = '$cliente'
							 AND a.cod_ubicacion = $ubicacion
							 AND a.cod_turno = turno.codigo
            	 AND a.cod_horario = horarios.codigo
	             AND a.cod_ubicacion = clientes_ubicacion.codigo ";

     	$sql = "SELECT clientes_ubicacion.descripcion ubicacion, turno.abrev turno, horarios.nombre horario,  a.*
               FROM plan_integral_horario a, turno, horarios, clientes_ubicacion
					   $where
					    ORDER BY a.cod_ubicacion ";
$query = $bd -> consultar($sql);

$sql01 = " SELECT DATE_FORMAT(LAST_DAY('$periodo".'-01'."'), '%d') d_max  ";
$query01 = $bd->consultar($sql01);
$row =$bd->obtener_fila($query01,0);
$d_max = $row[0];
?>

<table class="tabla_planif">
		<tr class="t_titulo f_titulo">
			<td rowspan="3" colspan="2" class="td_width"><?php echo $leng["ubicacion"];?></td>
			<td rowspan="3" colspan="2" class="td_width">Turno</td>
			<td rowspan="3" colspan="2" class="td_width">Horario</td>
		<?php
				for ($i=1; $i <= $d_max; $i++) {
					echo '<td colspan="2" >'.str_pad((int) $i, 2, "0", STR_PAD_LEFT).' - '.Semana(date("w", strtotime(date("Y-m-$i"))),'c').'</td>';
				} ?>
		</tr>

		<tr class="t_sub_titulo f_sub_titulo">
			<?php
			for ($i=1; $i <= $d_max; $i++) {
				echo	'<td colspan="2">TRABAJADORES</td>';
			} ?>
		</tr>
		<tr class="t_sub_titulo f_sub_titulo">
			<?php
			for ($i=1; $i <= $d_max; $i++) {
						'<td >Solicitado</td>
							<td>Cubierto</td>';
			} ?>
		</tr>
		<?php
		 while ($datos=$bd->obtener_fila($query,0)){

			echo '<tr class="t_contenido imgLink" title="'.$datos["ubicacion"].' - '.$datos["horario"].'">
					 <td colspan="2" onclick="Planif_mod(1, \'TODOS\',\'TODOS\', \'TODOS\')">'.longitud($datos["ubicacion"]).'</td>
					 <td colspan="2" onclick="Planif_mod(1, \''.$datos["cod_turno"].'\', \''.$datos["cod_horario"].'\', \'TODOS\')">'.longitudMin($datos["turno"]).'</td>
					 <td colspan="2" onclick="Planif_mod(1, \''.$datos["cod_turno"].'\', \''.$datos["cod_horario"].'\', \'TODOS\')">'.longitudMin($datos["horario"]).'</td>';
	 					 for ($i=1; $i <= $d_max; $i++) {

							  $dia       = str_pad((int) $i, 2, "0", STR_PAD_LEFT);
	  					 	$dia_p_cl  = "c".$dia;
	  						$dia_p_tab = "t".$dia;

	  						echo '<td onclick="Planif_mod(0, \''.$datos["cod_turno"].'\', \''.$datos["cod_horario"].'\',\''.$dia.'\')">'.$datos["$dia_p_cl"].'</td>
	  							 		<td onclick="Planif_mod(1, \''.$datos["cod_turno"].'\', \''.$datos["cod_horario"].'\',\''.$dia.'\')" class="'.fondo_cal($datos["$dia_p_cl"], $datos["$dia_p_tab"]).'">'.$datos["$dia_p_tab"].'</td>';
	  						}

			 echo '</tr>';
		 }?>
</table>
