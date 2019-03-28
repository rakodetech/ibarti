<?php   
   require('../../autentificacion/aut_config.inc.php');
     mysql_select_db($bd_cnn,$cnn);
	$tab        = $_GET['tab'];
	$typing     = $_GET['q'];
	$COD_CLASIF = $_GET['COD_CLASIF'];
	$filtro     = $_GET['filtro'];
	$where  = " ";
	switch ($filtro) {
	
		case codigo:
		   $where  .= " WHERE LOCATE('$typing', id) "; 		  
		break;
		case descripcion:
		   $where  .= " WHERE LOCATE('$typing', descripcion) "; 		  
		break;				
		
	 break;		
	}	

    $result = mysql_query("SELECT id, descripcion, campo01, campo02, campo03, campo04, campo05, campo06, status FROM $tab ".$where."", $cnn);
 			
 while ($row01 = mysql_fetch_array($result)) {
	
	$id          = $row01[0].'$$'.$row01[1].'$$'.$row01[2].'$$'.$row01[3].'$$'.$row01[4].'$$'.$row01[5].'$$'.$row01[6].'$$'.$row01[7].'$$'.$row01[8];
	$descripcion = "".$row01[0]." - ".$row01[1].""; 
?>

<li onselect=" this.setText('<?php echo $descripcion?>').setValue('<?php echo  $id ?>') ">
  <b></b> <?php echo $descripcion?>

</li>
<?php }?>