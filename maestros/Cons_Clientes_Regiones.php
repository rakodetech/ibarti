<?php 
require_once('paginador/PHPPaging.lib.php');
mysql_select_db($bd_cnn, $cnn);
$paging = new PHPPaging($cnn);

$id    =  $_GET['id'];
$Nmenu = 301; 
$archivo = "Clientes_Regiones&Nmenu=".$Nmenu."";
$tabla   = "clientes_regiones";
require_once('autentificacion/aut_verifica_menu.php');

 $query02 = mysql_query("SELECT cli_des FROM clientes WHERE co_cli = '$id'", $cnn);
 $row02   = mysql_fetch_array($query02);
?>
<br>
<div align="center" class="etiqueta_title"> CONSULTA GENERAL DE REGIONES CLIENTE: (<?php echo $row02[0]?>) </div> 
<hr />
<br/>
	<table width="80%" border="0" align="center">
		<tr class="fondo00">
			<th width="20%" class="etiqueta">C&oacute;digo</th>
			<th width="50%" class="etiqueta">Nombre</th>
			<th width="15%" class="etiqueta">Status</th>			
		    <th width="15%"><a href="inicio.php?area=maestros/Add_<?php echo $archivo?>&id=<?php echo $id?>"><img src="imagenes/nuevo.bmp" alt="Agregar Registro" width="40" height="40" title="Agregar Registro" border="null" /></a></th> 
		</tr>

    <?php
       
        // Instanciamos el objeto
        $paging = new PHPPaging;
        
        // Indicamos la consulta al objeto 
        $paging->agregarConsulta("SELECT a.co_cli, b.descripcion, a.status, a.id_region
                                    FROM clientes_regiones AS a, regiones AS b
								   WHERE a.co_cli =  '$id' 
									 AND a.id_region =  b.id");
        
        // Ejecutamos la paginación
        $paging->ejecutar();  
        
        // Imprimimos los resultados, para esto creamos un ciclo while
        // Similar a while($datos = mysql_fetch_array($sql))
        while($datos = $paging->fetchResultado()) { 
			if ($valor == 0){
		$fondo = 'fondo01';
		$valor = 1;
	}else{
		 $fondo = 'fondo02';
		 $valor = 0;
	}
        echo '<tr class="'.$fondo.'"> 
                  <td class="texto">'.$datos[0].'</td> 
                  <td class="texto">'.$datos[1].'</td> 
           	      <td class="texto">'.statuscal($datos[2]).'</td> 
			      <td width="15%" align="center"><a href="inicio.php?area=maestros/Mod_Clientes_Regiones&id='.$datos[0].'&campo_id='.$datos[3].'"><img src="imagenes/actualizar.bmp" alt="Agregar" title="Agregar Ubicacion" width="30" height="30" border="null"/>
				  <a href="inicio.php?area=maestros/Cons_'.$archivo.'&id='.$datos[0].'"><img src="imagenes/detalle.bmp" alt="Detalle" title="Detalle Registro" width="30" height="30" border="null"/></a> 
		          </td> 								
            </tr>'; 
        }     
    ?>
	</table>	

<br/>
<br />
<div align="center">  
<?php
    // Imprimimos la barra de navegación
    echo $paging->fetchNavegacion();
?>
</div>