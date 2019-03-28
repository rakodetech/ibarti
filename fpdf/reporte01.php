<?php
require('mysql_report.php');

$pdf = new PDF('L','pt','A3');
$pdf->SetFont('Arial','',11);
$pdf->connect('localhost','root','4321','resinca');
$attr = array('titleFontSize'=>18, 'titleText'=>'REPORTES DE TRABAJADORES');
$pdf->mysql_report("SELECT cedula2 AS cedula, nombre, apellido, fecha_nacimiento AS 'Fecha De Navimiento' FROM trabajadores ORDER BY nombre LIMIT 1000",false,$attr);
$pdf->Output();
?>