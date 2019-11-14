<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');



  ///// MOSTRAR in formacion utf8_decode();  GUardar Informacion
  ///// GUARSAR INFORMACION          htmlentities();
//  CHEK MEJORADO
		$query01 = mysql_query ("DELETE FROM $tabla WHERE $tabla_id = $id",$cnn);

			 foreach ($menu as $valorX){

				 mysql_query("INSERT INTO $tabla
							 (modulo, id_menu)
					  VALUES ($id, $valorX)",$cnn);
			 }
//  CHECK
		$query02 = mysql_query("SELECT * FROM defectos WHERE status = 1",$cnn)or die
								 ('<br><h3>Error Consulta # 2:</h3> '.mysql_error().'<br>');

		while($row02 =mysql_fetch_array($query02)){

		 echo $check_id     = $row02[0]; //aqui
		 echo  $check_V     = 'checkDef'.$check_id.'','<br>';
		 echo $check       = $_POST[''.$check_V.''],'<br />';

			  if($check == 'S'){
			  echo $check_id,'<br>';

				     mysql_query("INSERT INTO novedad_defectos
								 (id_novedad,  id_defectos)
						  VALUES ($campo_id2,  '".$check_id."')",$cnn)  or die
								 ('<br><h3>Error Consulta # 3:</h3> '.mysql_error().'<br>');
			}
		}

	///Array
	$DiasX = array('lunes_s', 'martes_s', 'miercoles_s','jueves_s','viernes_s','sabado_s');
	foreach ($DiasX as $dia) {
	}
	// SI EXISTE UN VALOR
			$query01 = mysql_query("SELECT id FROM planificacion_produccion_det WHERE id = $campo_id AND ".$dia." = 1", $cnn);
		 if (mysql_num_rows($query01)!=0){

//////////////////	 CREAR ARCHIVOS XML
mysql_select_db($bd2_cnn,$cnn);
	$tabla    = "usuarios";
   $orden     ='apellido';
     $sql     = "SELECT * FROM usuarios
			   ORDER BY apellido ASC";
				   $query01 = mysql_query($sql, $cnn);

$archivo = "xml_Usuario.xml";
$fp      = fopen($archivo, "w+");

$contenido ='<?xml version="1.0" encoding="iso-8859-1"?>
<specials>';
fwrite($fp, $contenido);
$i=1;

while($row01=mysql_fetch_array($query01)){
	if ($valor == 0){
		$fondo = 'fondo01';
		$valor = 1;
	}else{
		 $fondo = 'fondo02';
		 $valor = 0;
	}

$contenido ='
	<menu_item id="'.$i.'">
			<codigo>'.$row01[0].'</codigo>
			<campo01>'.$row01[1].'</campo01>
			<campo02>'.$row01[2].'</campo02>
			<campo03>'.$row01[3].'</campo03>
			<fondo>'.$fondo.'</fondo>
		</menu_item>';

	fwrite($fp, $contenido);
$i++;
	 }

$contenido = '</specials>';
fwrite($fp, $contenido);
mysql_free_result($query01);
mysql_close($cnn);
fclose($fp);

////  MANIPULACION DE FECHA
				$fecha_N = explode("-", $fec_hasta);
				$year2   = $fecha_N[0];
				$mes2    = $fecha_N[1];
				$dia2    = $fecha_N[2];

				$fecha_x    = mktime(0,0,0,$mes2,$dia2,$year2);
				$fec_desde  = strtotime("+1 day", $fecha_x);
		        $fec_desde  = date("Y-m-d", $fec_desde);

				$fec_hasta  = strtotime("+7 day", $fecha_x);
		        $fec_hasta  = date("Y-m-d", $fec_hasta);

				$y = $i+1;

		    	$descripcion = "PERIODO ".$year." SEMANA ".$y."";

// Recorrido de Matriz multidimensionaL
foreach ($arr as $arr2) {
	foreach ($arr2 as $k => $v) {
	//	echo "$k => $v.\n";
	//	echo $arr2["nivel"], "\n";
		if($arr2["fecha"] == "2014-12-17"){
		echo $arr2["horario"];
		}
	}
}}


?>
