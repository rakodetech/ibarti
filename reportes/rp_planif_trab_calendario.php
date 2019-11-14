<link rel="stylesheet" type="text/css" href="../css/horarios.css"/>
<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase();


$fecha_D         = Conversion($_POST['fecha_desde']);
$fecha_N1 = explode("-", $fecha_D );
$a   = $fecha_N1[0]; 
$m   = $fecha_N1[1]; 
$d   = 01;			

$fecha_D = $a."-".$m."-".$d;
$trabajador = $_POST['trabajador'];

 # definimos los valores iniciales para nuestro calendario 
//$month=date("n");
//$year=date("Y"); 
$diaActual=date("j"); 
$month= $m;
$year = $a; 

# Obtenemos el dia de la semana del primer dia # Devuelve 0 para domingo, 6 para sabado
 $diaSemana=date("w",mktime(0,0,0,$month,1,$year))+7; 
 # Obtenemos el ultimo dia del mes 
 $ultimoDiaMes=date("d",(mktime(0,0,0,$month+1,1,$year)-1)); 
 $fecha_H=date("Y-m-d",(mktime(0,0,0,$month+1,1,$year)-1)); 
 $meses=array(1=>"Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"); 
 
 $sql = "  SELECT v_ficha.ap_nombre FROM v_ficha WHERE v_ficha.cod_ficha = $trabajador";
$query = $bd->consultar($sql);

$row01 = mysql_fetch_row($query);

$empleado = $row01[0];
 
 $sql = " SELECT pl_trab_mensual.fecha, pl_trab_mensual.nivel,                  
				 pl_trab_mensual.cod_cliente, clientes.abrev AS cliente,
				 pl_trab_mensual.cod_ubicacion, clientes_ubicacion.descripcion AS ubicacion,
                 pl_trab_mensual.cod_horario, horarios.nombre AS horario 
            FROM pl_trab_mensual , clientes , clientes_ubicacion , horarios
           WHERE pl_trab_mensual.fecha BETWEEN \"$fecha_D\" AND \"$fecha_H\"
		     AND pl_trab_mensual.cod_ficha = '$trabajador' 
			 AND pl_trab_mensual.cod_cliente = clientes.codigo 
			 AND pl_trab_mensual.cod_ubicacion = clientes_ubicacion.codigo 
			 AND pl_trab_mensual.cod_horario = horarios.codigo";

$query = $bd->consultar($sql);

$arr = array();
if($bd->num_fila($query) > 0) {
   while ($row = $bd->fetch_assoc($query)) {
	   	  $arr[] = $row;
	}
} 


	if(isset($_POST['proced'])){ ?>
<table id="calendar"><caption><?php echo $empleado."  (".$meses[$month]." ".$year.")"?></caption> 
<tr> <th>Lun</th><th>Mar</th><th>Mie</th><th>Jue</th> <th>Vie</th><th>Sab</th><th>Dom</th> </tr> 
<tr bgcolor="silver"> 
<?php $last_cell=$diaSemana+$ultimoDiaMes; 
// hacemos un bucle hasta 42, que es el máximo de valores que puede // haber... 6 columnas de 7 dias 
for($i=1;$i<=42;$i++) { 

	if($i==$diaSemana) { 
// determinamos en que dia empieza 
	$day=1; } 
	if($i<$diaSemana || $i>=$last_cell) { 
	// celca vacia 
	echo "<td> </td>"; }
	else{
		if($day < 10){
			$day_x = '0'.$day;
		}else{
			$day_x = $day;
		} 

		$fecha_x = "$year-$month-$day_x";
		$horario_x = "";
		$borrar = "";
			foreach ($arr as $arr2) {
				if($arr2["fecha"] == "$fecha_x"){
				$horario_x   = $arr2["horario"];
				$nivel       = $arr2["nivel"];
				$cliente     = $arr2["cod_cliente"];				
				$ubicacion   = $arr2["cod_ubicacion"];				
				$cod_horario = $arr2["cod_horario"];

				$borrar = " ";
				}		
			}	
// mostramos el dia 
		
		echo "<td>$day_x $borrar \n <br /><span class='horario'>$horario_x </span></td>"; 		
		$day++; 
		} 
	// cuando llega al final de la semana, iniciamos una columna nueva 
	if($i%7==0) { echo "</tr><tr>\n"; } } ?> </tr> </table>  
<?php 
		   
echo  '<script language="javascript" type="text/javascript">
              window.print();</script>';
	}?>