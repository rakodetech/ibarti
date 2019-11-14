<?php
	include_once('../funciones/funciones.php');
	require("../autentificacion/aut_config.inc.php");
	require_once("../".class_bd);
	$bd = new DataBase();


	$periodo = $_POST["codigo"];
	$ficha   = $_POST["trabajador"];
	$usuario = $_POST["usuario"];
	$proced ="p_cal_plan_trabajador";

//	$periodo = $year.'-'.$month;
$periodoX = explode("-", $periodo);

$year = $periodoX[0];
$month = $periodoX[1];

//	$year = "2017";
//	$month = "12";
	# Obtenemos el dia de la semana del primer dia # Devuelve 0 para domingo, 6 para sabado
	$diaSemana = date("w", mktime(0, 0, 0, $month, 1, $year));
	if($diaSemana == 0) $diaSemana = 7;

	# Obtenemos el ultimo dia del mes
	$ultimoDiaMes = date("d", (mktime(0, 0, 0, $month + 1, 1, $year) - 1));
	# Obtenemos el ultimo dia del mes anterior
	$ultimoDiaMesAnterior = date("d", (mktime(0, 0, 0, $month, 1, $year) - 1));
	$fecha_H = date("Y-m-d", (mktime(0, 0, 0, $month + 1, 1, $year) - 1));
	$meses = array("01"=> "Enero", "02"=> "Febrero", "03"=> "Marzo", "04"=> "Abril", "05"=> "Mayo", "06"=> "Junio", "07"=> "Julio",
		"08"=> "Agosto", "09"=> "Septiembre", "10"=> "Octubre", "11"=> "Noviembre", "12"=> "Diciembre");


$sql    = "$SELECT $proced('$periodo', '$ficha', '$usuario')";
$query = $bd->consultar($sql);

$sql = " SELECT * FROM calendario_plan_trab WHERE periodo = '$periodo' AND cod_ficha = '$ficha'";
$query = $bd -> consultar($sql);


	$sql = " SELECT * FROM calendario_plan_trab WHERE periodo = '$periodo' AND cod_ficha = '$ficha'";
	$query = $bd -> consultar($sql);
	$row = array();
	if ($bd -> num_fila($query) > 0) {
		$row = $bd -> fetch_assoc($query);
		$vacio = "NO";
	}else{
		$vacio = "SI";
	}
?>
<link rel="stylesheet" type = "text/css" href = "css/calendario_planif.css" media = "screen" >
<div class="calendario" >
	<div class="calendar" >
		<div class="cal_title" >
			<span class="fecha" > <?php echo $meses[$month].' '.$year; ?> </span>
		</div>
		<table class="cal_semana">
			<tbody>
				<td> Lun </td>
				<td> Mar </td>
				<td> Mie </td>
				<td> Jue </td>
				<td> Vie </td>
				<td> Sáb </td>
				<td> Dom </td>
			</tbody>
		</table>
		<div class="cal_dia">
			<table class="dias">
				<tbody>
					<tr>
					<?php
						$ultima_celda=$diaSemana + $ultimoDiaMes;
						for ($i = 1; $i <= 42; $i++) {
							if ($i == $diaSemana || $i == $ultima_celda+1) {
								$dia = 1;
							}
							if ($i <= $diaSemana || $i > $ultima_celda) {
								if ($i > $ultima_celda) {
									echo "<td class='nulo'><span class='cal_dia_text_nulo'>".str_pad((int) $dia, 2, "0", STR_PAD_LEFT)."</span></td>";
									$dia++;
								} else {
									echo "<td class='nulo'><span class='cal_dia_text_nulo'>".($ultimoDiaMesAnterior - ($diaSemana - $i) + 1)."</span></td>";
								}

							} else {
							echo "<td>";
								if($vacio == "NO"){
									if($row['d'.str_pad((int) $dia, 2, "0", STR_PAD_LEFT)]){

										$caracteres = strlen ($row['d'.str_pad((int) $dia, 2, "0", STR_PAD_LEFT)]);
										echo "<div class='cal_dia_valor'>";
											if($caracteres <= 3) echo "<span class='corto'>".$row['d'.str_pad((int) $dia, 2, "0", STR_PAD_LEFT)]."</span>";
											if($caracteres > 3 && $caracteres <8) echo "<span class='mediano'>".$row['d'.str_pad((int) $dia, 2, "0", STR_PAD_LEFT)]."</span>";
											if($caracteres >= 8) echo "<span class='largo'>".$row['d'.str_pad((int) $dia, 2, "0", STR_PAD_LEFT)]."</span>";
										echo "</div>";
									}else{
										echo "<div class='cal_dia_valor_nulo'>
											<span>Sin Data</span>
										</div>";
									}
								}else{
									echo "<div class='cal_dia_valor_nulo'>
										<span>Sin Data</span>
									</div>";

								}
									echo "<div class='cal_dia_text'>
											<span>".str_pad((int) $dia, 2, "0", STR_PAD_LEFT)."</sapn>
										</div>
								</td>";
								$dia++;
							}
							if ($i % 7 == 0) {
								if ($i == 42) echo "</tr>\n";
								else echo "</tr><tr>\n";
							}
						}
					?>
	</tbody>
	</table>
	</div>
	</div>
	</div>
