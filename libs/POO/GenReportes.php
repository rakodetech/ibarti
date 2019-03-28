<link rel="stylesheet" type="text/css" href="../css/style_reportes.css">
<?php
/////////////////////  CONFIGURACION DE LOS ELEMTOS QUE QUERAMOS  ////////////
/*  
$configuracion = array( 'fieldset'=>'SI','imgleft'=>'../imagenes/logoinsalud.png', 'bgdetallet'=>'red',
                        'bgdetalle'=>'#999999', 'bgdetalle2' =>'#CCCCCC"' );
////////////////////  INSTACIA DE LA CLASE GenReportes  //////////////////

$configuracion = array( 'fieldset'=>'SI','imgleft'=>'NO', 'bgdetallet'=>'#0099CC', 'bgdetalle'=>'#999999', 
                        'bgdetalle2' =>'#CCCCCC'); 
$GenReportes = new GenReportes($bd,  $titulo, $reporte, $configuracion );

///////////////////   METODO QUE IMPRIME LA CABECERA DEL REPORTE ///////// 
$GenReportes->mostrarEncabezado($sql, $camposdesc);

/////////////////   METODO QUE IMPRIME EL DETALLE DEL REPORTE//////////////

$GenReportes->mostrarDetalle($camposdesc, $sqlN, $descripcion);
*/
class GenReportes
{
    //constantes  
    //variables
	var $titulo;
	var $reporte;
    var $imgleft;
	var $camposdesc; 	


    function GenReportes($bd,  $titulo, $reporte, $configuracion) {
		foreach($configuracion as $etiquetas => $muestraCampos){
			 $x = $etiquetas;
			 $y = $muestraCampos;

			$this->$etiquetas = $muestraCampos;
			}
			

        $this->bd      = $bd;
        $this->titulo  = $titulo;
        $this->reporte = $reporte;

//		$this->calcularRows($camposdesc);		
		
    }

//   Descripcion: Metodo que muestra el contenido en la pagina	    
   function mostrarEncabezado ($sql, $camposdesc){
    $this->sql     = $sql;
  	$numcampos = count($camposdesc);
	$rows = $numcampos +2;
	$fecha = date(d).'/'.date(m).'/'.date(Y);	
		   


        $r = $this->bd->bbdd_query($this->sql);
		if(strlen($this->imgleft)>5){
		$img = 'SI';
		}
        if($this->bd->bbdd_num($r)){?>
      
		<table  class="rep_tabla" align="center" >
			<tr > 			

		<?php
		if(strlen($this->titulo)>5){
		$titul = 'SI';  
		}

		if ($titul == 'SI' && $img == 'SI'){
		$imagtam = getimagesize($this->imgleft);
		$imagh = $imagtam[1];
		$imgheight = "height=".$imagh/($numcampos+1)."px";  


	
		  echo'
    			<td rowspan="'.$rows.'"><img src="'.$this->imgleft.'" alt="IMAGEN" border="null" /></td>
    			<td colspan="2" class="rep_title" '.$imgheight.'>'.$this->titulo.'</td>
				<td rowspan="'.$rows.'" class="rep_tablaDesc">'.$this->reporte.'<br/><br/>'.$fecha.'</td>
  			</tr> 
		<tr >';
		}elseif ($titul == 'SI' && $img == ''){
 		echo'
     			<td colspan="2" class="rep_title" >'.$this->titulo.'</td>
				<td rowspan="'.$rows.'">'.$this->reporte.'<br/><br/>'.$fecha.'</td>
  			</tr>';

		}					
		
			$row = $this->bd->bbdd_fetch($r);
			foreach($camposdesc as $etiquetas => $muestraCampos){	
				
				echo  
				     '<tr >
					 <td class="rep_membreteTitle" '.$imgheight.'>'.$etiquetas.'</td>
					 <td class="rep_membreteDesc">'.$row[$muestraCampos].'</td>
					 </tr>';
		}

			?>
			
        </table>

        <?php }
    }
////////////// Descripcion: Metodo que muestra el contenido en la pagina /////////////

   function mostrarDetalle ($camposdesc, $sqlN, $tituloDet ){
   $numcampos = count($camposdesc);         

	      $r = $this->bd->bbdd_query($sqlN);
		  
		  if(isset($this->bgdetalle)){
		  $bgcolor =' bgcolor="'.$this->bgdetalle.'"'; 
		  $bgcolor2 =' bgcolor="'.$this->bgdetalle2.'"'; 
		  $ncolor = 1;
		  }else{
		  $color =  $this->backgdetalle;
		  }
		  if(isset($this->bgdetallet)){
		  $bgcolort =' bgcolor="'.$this->bgdetallet.'"';
		  }

        if($this->bd->bbdd_num($r)){

		if ($this->fieldset == 'SI'){
		
			echo'
			<table align="center"><tr><td> 
			<div align="center" class="rep_tabla2">
				<fieldset align="center">
				  <legend  class="rep_tableTitle">'.$tituloDet.'</legend>
		<table border="1" width="100%">
			<tr>';		

	    }else{echo'<table align="center" border="1" class="rep_tabla" >
			<tr>
			<td colspan="'.$numcampos.'" class="rep_tableTitle" >'.$tituloDet.'</td>
			</tr>
			<tr>';} 
			
							
		// muestro las etiquetas del listado creando sus respectivos link que indican el orden 
			foreach($camposdesc as $etiquetas => $muestraCampos){
            	echo '<td class="rep_tableTitle2" '.$bgcolort.'>'.$etiquetas.'</td>';
			}
			
			echo'
						
			</tr>';
		
			//muestro los datos del listado
			
            while($row = $this->bd->bbdd_fetch($r)){

			// BG COLOR  
				if (strlen($bgcolor)>6){
					 if ($ncolor == 1){
					 $bgcolors = $bgcolor;
					 $ncolor++;
					 }else{
					$bgcolors = $bgcolor2;
					 $ncolor--;
					 } 
				}
			
			echo '<tr '.$bgcolors.'>';
				foreach($camposdesc as $etiquetas => $muestraCampos){
					
				echo '<td class="rep_tablaDesc">'.$row[$muestraCampos].''; /*if($muestraCampos == status_id){
								 $statu = $row[$muestraCampos];
								 if ($statu == 0){
								  echo 'Inactivo';
								 //echo $statu;
								 }else{ 
								 //echo $statu;
							      echo 'Activo';
							     } 	
							}else{
								echo $row[$muestraCampos];
							}*/?>
				</td>
					
            <?php }				
			
			echo '</tr>';
			}
			?>
        </table>

        <?php 
	
			}		
		
		if ($this->fieldset == 'SI'){
	
	echo '     
 	</fieldset></div> </td> </tr></table>';
	
	}
    }	
}
?> 