<?php

/*
$cnn = mysql_connect("localhost","oesvica_admin","$4321&") or die ('NO SE PUDO CONECTAR CON LA BASE DE DATOS:'. mysql_error());
$bd_cnn  = 'oesvica_oesvica';
$bd2_cnn = 'oesvica_sistema';
mysql_connect($conf_host,$conf_usuario,$conf_pass);
mysql_select_db($bd_cnn);
*/
$pdf=new PDF();
$pdf->AddPage();
//First table: put all columns automatically
$pdf->Table('SELECT * FROM trabajadores ORDER BY nombre LIMIT 100');
$pdf->AddPage();

//Second table: specify 3 columns
$pdf->AddCol('cedula',20,'','C');
$pdf->AddCol('nombre',40,'Country');
$pdf->AddCol('apellido',40,'Pop (2001)','R');
$pdf->AddCol('fecha_nacimiento',40,'Pop2 (2001)','R');
$prop=array('HeaderColor'=>array(255,150,100),
            'color1'=>array(210,245,255),
            'color2'=>array(255,255,210),
            'color3'=>array(255,255,210),
            'padding'=>2);
$pdf->Table('SELECT cedula2 AS cedula, nombre, apellido, fecha_nacimiento FROM trabajadores ORDER BY nombre LIMIT 10',$prop);
$pdf->Output();
?>