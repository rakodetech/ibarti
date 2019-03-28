<style type="text/css">
.flechas{
	font-size: 12px;
	text-decoration: none; 
	color: #000066;
	font-weight: bold;
	font-family: Arial, Helvetica, sans-serif;
}
.flechas1{
	font-size: 12px;
	text-decoration: none;
	color: #000000;
	font-weight: bold;	
    font-family: Arial, Helvetica, sans-serif;	
}

.flechas2{
	font-size: 15px;
	text-decoration: none;
	color: #FF0000;
	font-weight: bold;
	font-family: Arial, Helvetica, sans-serif;	
}
</style>
<?php
//   VARIABLES DE LOS NUMEROS INTERMEDIOS  INTERMEDIOS       ///////////////////
/////	$cant_interm = 7;    // cantidad de Nº intermedios para avanzar  ///////
/////	$num_mostrar = 7;    // Cantidad Nº mostrar                    
/////	$url_pag ='pl_plantillas3.php?area=Consulta_Gesta&orden='.$orden.''; // URL //
//////////////////////////////////////////////////////////////////////////////////////




//  PRIMERA PAGINA //
echo "<p>";
if ($pg <> 0){
    $pginc = 0;

echo "<a href='".$url_pag."&pg=".$pginc."'title='Primera pagina' class='flechas'><|</a> ";
	  echo '&nbsp;'; 
}else{
      echo " ";
}

// INTERMEDIOS    <<  //

if ( $pg >= $cant_interm ){

$inic = $_GET['inicio'];

$interm = $pg - $cant_interm;   
	
	if( ($inic-$cant_interm) >=1  ){
	$ini = $inic  - $cant_interm;
	}else{
	$ini = 1;
	} 
      echo "<a href='".$url_pag."&pg=".$interm."&inicio=".$ini."'title='Anteriores ".$cant_interm."' class='flechas'> << </a>";
 	  echo '&nbsp;';  
}else{
}

//  ANTERIOR   < //
if ( ($pg > 0) )
{
$url = $pg - 1;

	if(!isset($_GET['inicio'])){
		$inic = 1;
	}else{
		$inic = $_GET['inicio'];
	}
	
	if($inic > 1 ){
		$ini=$inic--;
	}else{  
		$ini=$inic;
	}	
echo "<a href='".$url_pag."&pg=".$url."&inicio=".$inic."'title='Anterior' class='flechas'> < </a> ";
echo '&nbsp;'; 
}else {
}

//  NUMEROS DE PAGINAS//
$pagesss = $pages +1;

if ($pagesss > $num_mostrar)  //  Nº ha mostrar //
{
	if(!isset($_GET['inicio'])){
		$inic = 1;
		$fin = $num_mostrar;
	}else{
		$inic = $_GET['inicio'];
	    $fin = ($inic + $num_mostrar) -1;
	}

	for ($i = $inic; $i< $fin +1; $i++) {
	// numero de la pagina Actual desde 0 hasta N  //
	$ni = $i -1;
		if ($ni <= $pages){
		
			if ($ni == $pg) {
				echo "<span class='flechas2'>$i</span> ";
				}
			else {
			echo "<a href='".$url_pag."&pg=".$ni."&inicio=".$inic."'><span class='flechas'>".$i."</span> </a> ";  
			}
		}
	}
}else{  
	for ($i = 1; $i<($pagesss + 1); $i++) {
	// numero de la pagina Actual desde 0 hasta N  //
	$ni = $i -1;
		
		if ($ni == $pg) {
			echo "<span class='flechas2'>$i</span> ";
			}
		else {
		echo "<a href='".$url_pag."&pg=".$ni."'><span class='flechas'>".$i."</span></a> ";  
		}
	}
	
}

// SIGUIENTE   > //
if ($pg < $pages) {

	if(!isset($_GET['inicio'])){
		$inic = 1;
	}else{
		$inic = $_GET['inicio'];
	}
$url = $pg + 1;

$y = ($inic + $cant_interm)- 1;

  	// Incrementos Nº paginas
	if(($y <= $pages)){ 
	$in = $inic + 1;
	}
	else{
     $in = $inic; 
	}

echo "<a href='".$url_pag."&pg=".$url."&inicio=".$in."'title='Siguiente' class='flechas'> &nbsp;> </a>";
}
else {
}

// INTERMEDIOS    >>   //
$num_mayor = ($pages - $pg); 

if ($num_mayor >= $cant_interm){
$interm = $pg + $cant_interm ;
$x = ($inic + $num_mostrar) -1;
$y =  ($pages - $num_mostrar) +2;  // verificar para mantener los numeros ha mostrar al final
	if ( ($x) > $pages  ){
	$in = $inic;	
	}else{
    $in = $inic+$num_mostrar;  // acomadarrrrr 
	}
	
	if ( $in  > $y ){
   $in =  $y;
	}else{
	}


	  echo '&nbsp;';  
	  echo "<a href='".$url_pag."&pg=".$interm."&inicio=".$in."'title='proximas ".$cant_interm."' class='flechas'>>></a>";
  
}else{
}

// ULTIMA PAGINA 
if ($pages > 1 )
{
	if ( ($pg < $pages) or ($pages <1 ) )
	{  
		 $in = ($pages-$cant_interm) +2;
	  echo '&nbsp;';
	  echo "<a href='".$url_pag."&pg=".$pages."&inicio=".$in."'title='ultima' class='flechas'> >| </a>";
	
	}else{
	}
}
echo "</p>";
?>