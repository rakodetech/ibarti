<?php 
require_once('paginador/PHPPaging.lib.php');
mysql_select_db($bd_cnn, $cnn);
$paging = new PHPPaging($cnn);

$Nmenu = 427; 
$tabla   = "foros";
$titulo   = " FOROS ";
$archivo2 = "foros_renglon&Nmenu=".$Nmenu."";
$archivo  = "foros&Nmenu=".$Nmenu."";
require_once('autentificacion/aut_verifica_menu.php');
?>

<br>
<div align="center" class="etiqueta_title"> CONSULTA GENERAL <?php echo $titulo ?></div> 
<hr />
<div id="Contenedor01"></div>
<br/>
	<table width="98%" border="0" align="center">
		<tr class="fondo00">
			<th width="10%" class="etiqueta">Fecha</th>
			<th width="30%" class="etiqueta">Titulo</th>
			<th width="20%" class="etiqueta">Categoria</th>
			<th width="20%" class="etiqueta">Autor</th>
			<th width="10%" class="etiqueta">Status</th>
		    <th width="10%"><a href="inicio.php?area=formularios/Add_<?php echo $archivo?>"><img src="imagenes/nuevo.bmp" 
			alt="Agregar Registro" width="40" height="40" title="Agregar Registro" border="null" /></a></th> 
		</tr>
    <?php   
         // Instanciamos el objeto
        $paging = new PHPPaging;        
        // Indicamos la consulta al objeto 
        $paging->agregarConsulta(" SELECT foros.codigo, foros.fec_us_ing, 
		                                  foros.cod_autor, CONCAT(usuarios.apellido,' ',usuarios.nombre) AS autor,
                                          foros.cod_region, regiones.descripcion AS region,
										  foros.cod_categoria, foros_categoria.descripcion AS categoria,
										  foros.asunto AS titulo, foros.mensaje,
										  foros.`status`
                                     FROM foros , regiones , foros_categoria , oesvica_sistema.usuarios
                                    WHERE foros.cod_region = regiones.id 
                                      AND foros.cod_categoria = foros_categoria.id  
                                      AND foros.cod_autor = usuarios.cedula 
                                 ORDER BY foros.fec_us_ing, foros.codigo DESC ");        
        // Ejecutamos la paginación
        $paging->ejecutar();          
        // Imprimimos los resultados, para esto creamos un ciclo while
         while($datos = $paging->fetchResultado()) { 
			if ($valor == 0){
		$fondo = 'fondo01';
		$valor = 1;
	}else{
		 $fondo = 'fondo02';
		 $valor = 0;
	}
	   $conf = "Borrar01('".$datos[0]."')";
        echo '<tr class="'.$fondo.'"> 
                  <td>'.Rconversion($datos['fec_us_ing']).' <br/></td>
				  <td>'.$datos['titulo'].'</td>
				  <td>'.$datos['categoria'].'</td>
			      <td>'.$datos['autor'].'</td>
				  <td>'.statuscal($datos['status']).'</td> 
			      <td width="15%" align="center">				  

			<a href="inicio.php?area=formularios/Mod_'.$archivo.'&codigo='.$datos[0].'"><img src="imagenes/actualizar.bmp" 
			   alt="Modificar"  title="Modificar Registro" width="25" height="25" border="null"/></a>
			   <a href="inicio.php?area=formularios/Cons_'.$archivo2.'&codigo='.$datos[0].'"><img src="imagenes/detalle.bmp" 
			   alt="Detalle"  title="Detalle Registro" width="25" height="25" border="null"/></a>
              
      	          </td> 								
            </tr>'; 
        }     
    /* <img src="imagenes/borrar.bmp" onClick="'.$conf.'" class="imgLink" alt="Eliminar" title="Eliminar Registro" width="25" height="25" border="null"/>	  <a onClick="ConfirmacionS('.$confir.')"><img src="imagenes/borrar.bmp" alt="Eliminar" title="Eliminar Registro" width="30" height="30" border="null"/></a>*/	
	?>
	<input type="hidden" id="tabla" value="<?php echo $tabla;?>" />
	</table>	
<br/>
<br />
<div align="center">  
<?php
    // Imprimimos la barra de navegación
    echo $paging->fetchNavegacion();
?>
</div>