<?php
                  //      Funciones     //
function gesta($fur){   // Edad gestacional con la Fecha de ultima Regla

	$date = mktime(0,0,0,date("m"),date("d"),date("Y"));
	$dia_nac=substr($fur, 8, 2);
	$mes_nac=substr($fur, 5, 2);
	$anno_nac=substr($fur, 0, 4);
	
	$fur=mktime(0,0,0,$mes_nac,$dia_nac,$anno_nac);
	
	$ges=round(($date-$fur)/604800);
	
	return $ges;
}

function fpp($fur)  // Fecha Probable de parto por fur
{

$date = mktime(0,0,0,date("m"),date("d"),date("Y"));

$dia_nac=substr($fur, 8, 2);
$mes_nac=substr($fur, 5, 2);
$anno_nac=substr($fur, 0, 4);
	
	if ( $anno_nac==0000 or $mes_nac == 0 or $dia_nac == 0 ){
	    return $fppeco = 'DATA INSUFICIENTE';
	   }else{

	$fur=mktime(0,0,0,$mes_nac,$dia_nac,$anno_nac);
	
	$fpp=strtotime("+41 weeks", $fur);
	
	$fpp=date("d/m/Y", $fpp); 
	   
	return $fpp;              
   }
}

function fppeco($feco, $gesta1){  // Fecha Probable de parto de Eco

	$dia=substr($feco, 8, 2);
	$mes=substr($feco, 5, 2);
	$anno=substr($feco, 0, 4);
	if ( $anno==0000 or  $gesta1 == 0 ){
		return $fppeco = 'DATA INSUFICIENTE';
	}else{
		$feco=mktime(0,0,0,$mes,$dia,$anno);
		
		$sem=40-$gesta1;
		$sem='+'.$sem.' weeks';
		
		$fppeco=strtotime($sem, $feco);
		
		$fppeco=date("d/m/Y", $fppeco);
		return $fppeco;
	}
}

function gestaeco($feco, $gesta1){  //gestacion segun Eco 
 
	$dia=substr($feco, 8, 2);
	$mes=substr($feco, 5, 2);
	$anno=substr($feco, 0, 4);
	if ( $anno==0000 or  $gesta1 == 0 ){
		return $fppeco = 'DATA INSUFICIENTE';
   }else{
	
	$feco=mktime(0,0,0,$mes,$dia,$anno);
	$date = mktime(0,0,0,date("m"),date("d"),date("Y"));
	
	$ges=round(($date-$feco)/604800);
	
	$ges=$ges+$gesta1;
	
	return $ges; 
	}
}

// CALCULO DE LA EDAD
function fnacimient($fecha)   
{
	$dia=date(j);
	$mes=date(n);
	$ano=date(Y);

	$dia_nac=substr($fecha, 8, 2);
	$mes_nac=substr($fecha, 5, 2);
	$anonac=substr($fecha, 0, 4);	
		if ( $anonac==0000 or $mes_nac == 0 or $dia_nac == 0 ){
	    return $edad = 'INDEFINIDO';
	   }else{
	
		if (($mes_nac == $mes) && ($dia_nac > $dia)) {
		$ano=($ano-1); }
		
		if ($mesnaz > $mes) {
		$ano=($ano-1);}
		
		$edad=($ano-$anonac);
		return $edad;
	}
}

// calcular el valor real de S o N  ==> SI Ó NO 
function valorcal($valor){
	
	if ( ($valor == 'S') or ($valor == 's') ) {
		$valorcal = 'SI';
	
	}elseif (($valor == 'N') or ($valor == 'n')){
		$valorcal = 'NO';
	}else{
		$valorcal ='INDEFINIDO';
	}
	
	return $valorcal;
}
/*
   1.
      $fechaComparacion = strtotime("14 May 1983");
   2.
      $calculo= strtotime("-15 days", $fechaComparacion); //Le restamos 15 dias
   3.
      echo date("Y-m-d", $calculo);
*/s

?>
