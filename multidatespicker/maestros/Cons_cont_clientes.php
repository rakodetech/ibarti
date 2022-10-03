<?php 
require_once('paginador/PHPPaging.lib.php');
mysql_select_db($bd_cnn, $cnn);
$paging = new PHPPaging($cnn);

$Nmenu = 339; 
$archivo = "cont_clientes&Nmenu=".$Nmenu."";
$tabla   = "cont_clientes";
require_once('autentificacion/aut_verifica_menu.php');

	   $sql01 =	"SELECT cont_clientes.codigo, cont_clientes.cod_cont_clasif,
                        cont_clientes.id_dpt1, cont_clientes.id_dpt2,
                        cont_clientes.descripcion, cont_clientes.direccion,
                        cont_clientes.telefono, cont_clientes.`status`
                   FROM cont_clientes
                  ORDER BY descripcion ASC  ";
?>
<br>
<div align="center" class="etiqueta_title"> CONSULTA GENERAL DE CLIENTES </div> 
<hr />
<br/>
	<table width="98%" border="0" align="center">
		<tr class="fondo00">
			<th width="10%" class="etiqueta"><span class="etiqueta">C&oacute;digo</span></th>
			<th width="30%" class="etiqueta"><span class="etiqueta">Nombre</span></th>
			<th width="40%" class="etiqueta"><span class="etiqueta">Direcci&oacute;n</span></th>
			<th width="12%" class="etiqueta"><span class="etiqueta">Telefono</span></th>			
		    <th width="8%"><a href="inicio.php?area=maestros/Add_<?php echo $archivo?>"><img src="imagenes/nuevo.bmp" alt="Agregar Registro" width="40" height="40" title="Agregar Registro" border="null" /></a>
            </th> 
		</tr>
    <?php       
        // Instanciamos el objeto
        $paging = new PHPPaging;
        $paging->porPagina(16);
        // Indicamos la consulta al objeto 
        $paging->agregarConsulta($sql01);
        
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
                  <td class="texto">'.$datos['codigo'].'</td> 
                  <td class="texto">'.$datos['descripcion'].'</td>
				  <td class="texto">'.$datos['direccion'].'</td> 
           	      <td class="texto">'.$datos['telefono'].'</td> 
			      <td width="15%" align="center">
				  <a href="inicio.php?area=maestros/Mod_'.$archivo.'&codigo='.$datos[0].'"><img src="imagenes/actualizar.bmp" alt="Detalle" title="Detalle Registro" width="30" height="30" border="null"/></a></a> 
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