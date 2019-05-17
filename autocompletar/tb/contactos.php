<?php   
   require('../../autentificacion/aut_config.inc.php');
   //   require('../../funciones/funciones.php');
     mysql_select_db($bd_cnn,$cnn);
	$typing     = $_GET['q'];
	$COD_CLASIF = $_GET['COD_CLASIF'];
	$filtro     = $_GET['filtro'];

	$where  = " WHERE cont_proceso.cod_cont_cliente = cont_clientes.codigo ";
		
	switch ($filtro) {	
		case codigo:
		$typing = Rconversion($typing);
	    $where  .= " AND LOCATE('$typing', codigo) "; 
        break;
		
		case fecha:
		   $where  .= " AND LOCATE('$typing', cont_proceso.fecha) "; 	
		break;		
		
		case cliente:
		   $where  .= " AND LOCATE('$typing', cont_clientes.descripcion) "; 		
		break;				
	}	

    $result= mysql_query(" SELECT cont_proceso.fecha, cont_proceso.cod_cont_cliente,
                                  cont_clientes.descripcion , cont_proceso.representante
                             FROM cont_proceso , cont_clientes
                            ".$where." ", $cnn);
 			
 	while ($row = mysql_fetch_array($result)) {
		$descripcion = "(".$row[0].")&nbsp;".$row[2];		
		$id          = $row[0]."&cliente=".$row[1]."";
?>

<li onselect=" this.setText('<?php echo $descripcion?>').setValue('<?php echo  $id ?>') ">
  <b></b> <?php echo $descripcion?>
</li>
<?php }?>