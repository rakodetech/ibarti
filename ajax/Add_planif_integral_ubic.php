<?php
	include_once('../funciones/funciones.php');
	require "../autentificacion/aut_config.inc.php";
	require "../".class_bd;
	require "../".Leng;
	$bd = new DataBase();

	$periodo  = $_POST["codigo"];
	$cliente   = $_POST["cliente"];
	$usuario   = $_POST["usuario"];
  $proced    = "p_planif_integral_cliente";



// Horario de planificacion
 	$sql   = "$SELECT $proced('$periodo', '$cliente', '$usuario')";
  $query = $bd->consultar($sql);

 $sql = " SELECT plan_integral.*,clientes.nombre cliente, clientes.abrev,
                clientes_ubicacion.descripcion ubicacion
           FROM plan_integral ,   clientes, clientes_ubicacion
          WHERE plan_integral.periodo = '$periodo'
            AND plan_integral.cod_cliente = '$cliente'
					  AND plan_integral.cod_cliente = clientes.codigo
            AND clientes_ubicacion.codigo = plan_integral.cod_ubicacion
            AND plan_integral.tipo = 'ubic'";
$query = $bd -> consultar($sql);

$sql01 = " SELECT DATE_FORMAT(LAST_DAY('$periodo".'-01'."'), '%d') d_max  ";
$query01 = $bd->consultar($sql01);
$row =$bd->obtener_fila($query01,0);
$d_max = $row[0];
?>


<table class="tabla_planif">
		<tr class="t_titulo f_titulo">
			<td rowspan="3" colspan="2" class="td_width"><?php echo $leng["cliente"];?></td>
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
				echo	'<td >Solicitado</td>
							<td>Cubierto</td>';
			} ?>
		</tr>
		<?php
		 while ($datos=$bd->obtener_fila($query,0)){

			echo '<tr class="t_contenido imgLink" title="'.$datos["ubicacion"].'"
								onclick="Planif_ubic_horario(\''.$datos["periodo"].'\', \''.$datos["cod_cliente"].'\', \''.$datos["cod_ubicacion"].'\',\' Cliente: '.$datos["cliente"].', Ubicacion: '.$datos["ubicacion"].' \')">
					 <td colspan="2">'.longitudMin($datos["ubicacion"]).'</td>';

					 for ($i=1; $i <= $d_max; $i++) {
 					 	$p_cl =   "c".str_pad((int) $i, 2, "0", STR_PAD_LEFT)."";
 						$p_tab =  "t".str_pad((int) $i, 2, "0", STR_PAD_LEFT)."";

 						echo '<td>'.$datos["$p_cl"].'</td>
 							 		<td class="'.fondo_cal($datos["$p_cl"], $datos["$p_tab"]).'">'.$datos["$p_tab"].'</td>';
 						}

			 echo '</tr>';
		 }?>
</table>
